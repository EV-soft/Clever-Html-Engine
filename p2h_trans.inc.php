<?php  $DocFileTrans='../p2h_trans.inc.php';    $DocVerTrans='1.8.0';    $DocRevTrans='2026-10-21';      $DocIni='evs';  ## File informative only
# Maintenance of the translations of a program (_trans.sys.json) - in the program itself, for its administrators.
# Optional: require it after php2html.lib.php. The program decides who may use it (like htm_AuditLog).
#
#   if (isset($_POST['p2h_trans_save']) && $userIsAdmin) [$ok, $msg]= p2h_trans_handle();     # Before any output - then redirect
#   htm_TransEditor(capt:'@Translations', scan:[__FILE__, __DIR__.'/php2html.lib.php']);      # The card: language, search, missing first
#
#   $gbl_TransFile= __DIR__.'/_trans.sys.json';     # Before require: the file (default: as the library reads it)
#
# Only the changed texts are sent (PHP's max_input_vars cuts a form of 2000 fields) - and written into the file line by line,
# so its layout stays and a diff shows only the change. When that can not be done safely, the whole file is written again.
# The file is checked before it is written, the old one is kept as *.bak.json, and the writing is locked.
# A translation may have simple HTML (<b>, <i>, <br>, <code> ...) - never a script or an event attribute.

function p2h_trans_file() {     # The translation file - as sys_get_translations() reads it
    if (!empty($GLOBALS['gbl_TransFile'])) return (string)$GLOBALS['gbl_TransFile'];
    return is_readable('./_trans.sys.json') ? './_trans.sys.json' : ($GLOBALS['gbl_ProgRoot'] ?? '').'_trans.sys.json';
}

function p2h_trans_clean($v) {  # A translation: one line of text with simple HTML - no script, no event attribute, no javascript: link
    $v= str_replace(["\r\n", "\r", "\n"], ' ', (string)$v);
    $v= strip_tags($v, '<b><i><u><em><strong><br><small><code><kbd><sup><sub><span><big>');
    $v= preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $v);
    return preg_replace('/javascript\s*:/i', '', $v);
}

function p2h_trans_scan($files) {   # The texts to translate in the source: '@English text' - [text => 1]
    $keys= [];
    foreach ((array)$files as $f) {
        $src= is_readable((string)$f) ? (string)file_get_contents($f) : '';
        preg_match_all("/'@((?:[^'\\\\]|\\\\.)*)'/s", $src, $m1);
        preg_match_all('/"@((?:[^"\\\\]|\\\\.)*)"/s', $src, $m2);
        foreach ($m1[1] as $k) $keys[str_replace(["\\'", '\\\\'], ["'", '\\'], $k)]= 1;
        foreach ($m2[1] as $k) $keys[stripcslashes($k)]= 1;
    }
    foreach (array_keys($keys) as $k)       # Not a text: CSS (@media ...), code, a placeholder - or too long
        if (trim($k) === '' || strpbrk($k, "\n\r{};\$") !== false || mb_strlen($k) > 400 || !preg_match('/\p{L}{2}/u', $k)) unset($keys[$k]);
    ksort($keys, SORT_NATURAL | SORT_FLAG_CASE);
    return $keys;
}

function p2h_trans_load(&$raw= null) {  # The decoded file - null when it is missing or broken
    $f= p2h_trans_file();
    $raw= is_readable($f) ? (string)file_get_contents($f) : '';
    $d= $raw !== '' ? json_decode($raw, true) : null;
    return (is_array($d) && is_array($d['language'] ?? null)) ? $d : null;
}

function p2h_trans_set($code, $changes, &$err= '') {   # Save [text => translation] of the language $code ('' = remove the translation) - true / false ($err)
    $f= p2h_trans_file();
    $lock= @fopen($f.'.lock', 'c');                     # One writer at a time
    if ($lock) flock($lock, LOCK_EX);
    try {
        $data= p2h_trans_load($raw);
        if ($data === null) { $err= lang('@The translation file is missing or broken');  return false; }
        $li= null;
        foreach ($data['language'] as $i => $l) if (($l['code'] ?? '') === $code) { $li= $i;  break; }
        if ($li === null) { $err= lang('@Unknown language').': '.$code;  return false; }
        $tr= is_array($data['language'][$li]['translation'] ?? null) ? $data['language'][$li]['translation'] : [];
        $patch= $raw;  $byText= true;
        $jf= JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
        # The block of the language in the text: from its "code" to the end of its "translation"
        if (!preg_match('/"code"\s*:\s*'.preg_quote(json_encode($code, $jf), '/').'/', $raw, $cm, PREG_OFFSET_CAPTURE)) $byText= false;
        else {
            $tStart= strpos($raw, '"translation"', $cm[0][1]);
            $open=   $tStart === false ? false : strpos($raw, '{', $tStart);
            $close=  $open === false ? false : strpos($raw, '}', $open);     # (a key or text with "}" makes the check below fail - then the whole file is written)
            if ($close === false) $byText= false;
        }
        foreach ($changes as $k => $v) {
            $k= (string)$k;  $v= p2h_trans_clean($v);
            if ($v === '') unset($tr[$k]);  else $tr[$k]= $v;
            if (!$byText) continue;
            $block= substr($patch, $open, $close - $open);
            $nl=    strpos($patch, "\r\n") !== false ? "\r\n" : "\n";
            if (preg_match('/^([ \t]*)'.preg_quote(json_encode($k, $jf), '/').'\s*:\s*"(?:[^"\\\\]|\\\\.)*"(,?)[ \t]*(\r?\n)/m', $block, $lm, PREG_OFFSET_CAPTURE)) {
                $at= $open + $lm[0][1];  $len= strlen($lm[0][0]);
                $new= $v === '' ? '' : $lm[1][0].json_encode($k, $jf).':'.json_encode($v, $jf).$lm[2][0].$lm[3][0];
                $patch= substr($patch, 0, $at).$new.substr($patch, $at + $len);
                $close+= strlen($new) - $len;
            } elseif ($v !== '') {                     # A new text: first in the block (with a comma when more follow)
                $more= trim(substr($patch, $open + 1, $close - $open - 1)) !== '';
                preg_match('/\n([ \t]*)"/', substr($patch, $open, $close - $open), $im);
                $ind= $im[1] ?? str_repeat(' ', 12);
                $new= $nl.$ind.json_encode($k, $jf).':'.json_encode($v, $jf).($more ? ',' : '');
                $patch= substr($patch, 0, $open + 1).$new.substr($patch, $open + 1);
                $close+= strlen($new);
            }
        }
        $data['language'][$li]['translation']= $tr;
        $check= json_decode($patch, true);
        if (!$byText || !is_array($check) || $check != $data) {      # The text could not be changed safely: the whole file - checked
            $patch= json_encode($data, $jf | JSON_PRETTY_PRINT);
            if ($patch === false || json_decode($patch, true) != $data) { $err= lang('@The translation file could not be written');  return false; }
        }
        @copy($f, preg_replace('/(\.json)?$/', '.bak.json', $f, 1));     # The file before - one backup
        $tmp= $f.'.'.bin2hex(random_bytes(4)).'.tmp';
        if (@file_put_contents($tmp, $patch) === false || !@rename($tmp, $f)) { @unlink($tmp);  $err= lang('@The translation file could not be written');  return false; }
        return true;
    } finally {
        if ($lock) { flock($lock, LOCK_UN);  fclose($lock); }
    }
}

function p2h_trans_handle() {   # The POST of htm_TransEditor() - call it before any output, when the user may translate: [ok, message]
    if (!function_exists('csrf_verify') || !csrf_verify()) return [false, lang('@The form has expired - reload the page and try again')];
    $code= (string)($_POST['p2h_trans_lang'] ?? '');
    $ch=   json_decode((string)($_POST['p2h_trans_changes'] ?? ''), true);
    if (!preg_match('/^[a-z]{2,3}(-[A-Za-z]{2,4})?$/', $code) || !is_array($ch)) return [false, lang('@Nothing was changed')];
    $ch= array_filter($ch, fn($v, $k) => is_string($v) && is_string($k) && $k !== '' && mb_strlen($k) <= 400 && mb_strlen($v) <= 2000, ARRAY_FILTER_USE_BOTH);
    if (!$ch) return [false, lang('@Nothing was changed')];
    return p2h_trans_set($code, $ch, $err) ? [true, lang('@Translations saved').': '.count($ch).' ('.$code.')'] : [false, $err];
}

function htm_TransEditor(# capt:'@Translations', icon:'fa-solid fa-language', hint:'', scan:[], code:'', acti:'', wdth:'98%', rtrn:false)
    $capt= '@Translations',             # string: The caption of the card ('' : no card)
    $icon= 'fa-solid fa-language',      # string: The icon of the card
    $hint= '',                          # string: The hint of the card
    $scan= [],                          # array:  The source files with the texts ('@English text') - their missing translations are shown first
    $code= '',                          # string: The language shown ('' : ?tl= or the language of the user - never English)
    $acti= '',                          # string: The address the form is sent to ('' : this page) - add &tl= yourself to come back to the language
    $wdth= '98%',                       # string: The width of the table
    $rtrn= false                        # bool:   Return the HTML instead of echoing it
) {
    if ($rtrn) ob_start();
    $data= p2h_trans_load();
    $langs= $data ? array_values(array_filter($data['language'], fn($l) => isset($l['code']) && $l['code'] !== 'en')) : [];
    $code= $code ?: (string)($_GET['tl'] ?? '') ?: (string)($GLOBALS['lang'] ?? '');
    if (!in_array($code, array_column($langs, 'code'), true)) $code= $langs[0]['code'] ?? '';
    foreach ($langs as $l) if ($l['code'] === $code) $cur= $l;
    $tr=   is_array($cur['translation'] ?? null) ? $cur['translation'] : [];
    $src=  $scan ? p2h_trans_scan($scan) : [];
    $keys= array_keys($src + $tr);
    $rows= [];
    foreach ($keys as $k) $rows[]= [$k, $tr[$k] ?? '', !isset($tr[$k]) || $tr[$k] === '', false];   # text, translation, missing - (a text that is not found in the source is not marked: a program may build its texts, as lang('@'.$x))
    usort($rows, fn($a, $b) => [$b[2], mb_strtolower($a[0])] <=> [$a[2], mb_strtolower($b[0])]);       # Missing first
    $miss= count(array_filter($rows, fn($r) => $r[2]));
    $act=  $acti !== '' ? $acti : ($_SERVER['REQUEST_URI'] ?? '');
    if ($capt > '') htm_Card_(capt: $capt, icon: $icon, hint: $hint, clas: 'cardWmax');
    if (!$data) echo '<p class="p2hAlert p2hAlert-error">'.sys_enc(lang('@The translation file is missing or broken')).': '.sys_enc(p2h_trans_file()).'</p>';
    else {
        # Language - with the number of translations (the empty languages last)
        usort($langs, fn($a, $b) => [empty($b['translation']), $a['name'] ?? ''] <=> [empty($a['translation']), $b['name'] ?? '']);
        echo '<div class="p2hTrBar"><label>'.sys_enc(lang('@Language')).': <select onchange="p2hTrGo(this.value)">'.
             implode('', array_map(fn($l) => '<option value="'.sys_enc($l['code']).'"'.($l['code'] === $code ? ' selected' : '').'>'.
                 sys_enc($l['code'].' - '.($l['name'] ?? '').' ('.count((array)($l['translation'] ?? [])).')').'</option>', $langs)).'</select></label> '.
             '<input type="search" class="p2hTrFind" placeholder="'.sys_enc(lang('@Search...')).'" aria-label="'.sys_enc(lang('@Search')).'" oninput="p2hTrFilter()"> '.
             '<label><input type="checkbox" class="p2hTrMiss" onchange="p2hTrFilter()"> '.sys_enc(lang('@Only missing')).' ('.$miss.')</label> '.
             '<span class="p2hTrCount"></span></div>';
        echo '<form method="post" action="'.sys_enc($act).'" class="p2hTrForm" onsubmit="return p2hTrSend(this)">'.
             (function_exists('csrf_field') ? csrf_field(true) : '').
             '<input type="hidden" name="p2h_trans_lang" value="'.sys_enc($code).'"><input type="hidden" name="p2h_trans_changes" value="">'.
             '<div class="p2hTrWrap"><table class="p2hTrTbl" style="width:'.sys_enc($wdth).'"><thead><tr><th>'.sys_enc(lang('@English text')).'</th><th>'.
             sys_enc(lang('@Translation')).' ('.sys_enc($code).')</th></tr></thead><tbody>';
        foreach ($rows as [$k, $v, $m, $unused])
            echo '<tr class="'.($m ? 'p2hTrM' : '').($unused ? ' p2hTrU' : '').'"><td>'.sys_enc($k).
                 ($unused ? ' <small class="p2hTrNote">'.sys_enc(lang('@not in the source')).'</small>' : '').'</td>'.
                 '<td><input type="text" data-k="'.sys_enc($k).'" value="'.sys_enc($v).'" data-v="'.sys_enc($v).'" aria-label="'.sys_enc(mb_substr($k, 0, 80)).'" oninput="p2hTrMark(this)"></td></tr>';
        echo '</tbody></table></div>'.
             '<div class="p2hTrFoot"><button type="submit" class="p2hTrSave" disabled><i class="fa-solid fa-floppy-disk"></i> '.sys_enc(lang('@Save the changes')).
             ' <span class="p2hTrN">0</span></button> <small>'.sys_enc(lang('@An empty field removes the translation - the English text is shown. Simple HTML (b, i, br, code) is allowed.')).'</small></div>'.
             '<noscript><p class="p2hAlert p2hAlert-error">'.sys_enc(lang('@The editor needs JavaScript')).'</p></noscript></form>';
        echo '<style>
.p2hTrBar { display: flex; flex-wrap: wrap; gap: 6px 14px; align-items: center; margin: 4px 0 8px; text-align: left; }
.p2hTrBar select, .p2hTrFind, .p2hTrTbl input { padding: 3px 6px; border: 1px solid #9aa5b1; border-radius: 4px; font: inherit; background: var(--InptBgrd, #fff); color: var(--TextColr, #222); }
.p2hTrFind { width: 220px; }
.p2hTrWrap { max-height: 60vh; overflow: auto; border: 1px solid #c9d1d9; border-radius: 4px; }
.p2hTrTbl { border-collapse: collapse; font-size: 13px; text-align: left; }
.p2hTrTbl th { position: sticky; top: 0; background: var(--CardsBgrd, #f3f5f7); padding: 4px 6px; border-bottom: 2px solid #b8c4d0; z-index: 1; }
.p2hTrTbl td { padding: 2px 6px; border-bottom: 1px solid #e1e6eb; vertical-align: middle; width: 50%; word-break: break-word; }
.p2hTrTbl input { width: 100%; box-sizing: border-box; }
.p2hTrM td:first-child { border-left: 3px solid #d9822b; }
.p2hTrU td:first-child { opacity: 0.6; }
.p2hTrTbl input.p2hTrChg { border-color: #2f6fb0; box-shadow: 0 0 0 2px rgba(47,111,176,0.25); }
.p2hTrNote { color: #888; font-style: italic; }
.p2hTrFoot { margin-top: 8px; text-align: left; }
[data-theme="dark"] .p2hTrTbl td { border-color: #3f4852; }  [data-theme="dark"] .p2hTrWrap { border-color: #4a5560; }
</style><script>
function p2hTrGo(c) { var u= new URL(location.href); u.searchParams.set("tl", c); location.href= u.toString(); }
function p2hTrMark(i) {
    i.classList.toggle("p2hTrChg", i.value !== i.dataset.v);
    var f= i.form, n= f.querySelectorAll("input.p2hTrChg").length;
    f.querySelector(".p2hTrN").textContent= n;  f.querySelector(".p2hTrSave").disabled= !n;
}
function p2hTrFilter() {
    var q= document.querySelector(".p2hTrFind").value.trim().toLowerCase(), m= document.querySelector(".p2hTrMiss").checked, n= 0;
    document.querySelectorAll(".p2hTrTbl tbody tr").forEach(function(tr) {
        var inp= tr.querySelector("input"), ok= (!m || tr.classList.contains("p2hTrM")) &&
                 (!q || tr.cells[0].textContent.toLowerCase().indexOf(q) >= 0 || inp.value.toLowerCase().indexOf(q) >= 0);
        tr.hidden= !ok;  if (ok) n++;
    });
    document.querySelector(".p2hTrCount").textContent= n + " / " + document.querySelectorAll(".p2hTrTbl tbody tr").length;
}
function p2hTrSend(f) {     /* Only the changed texts: one field (a form with 2000 fields is cut by PHP max_input_vars) */
    var ch= {};
    f.querySelectorAll("input.p2hTrChg").forEach(function(i) { ch[i.dataset.k]= i.value; });
    if (!Object.keys(ch).length) return false;
    f.querySelector("[name=p2h_trans_changes]").value= JSON.stringify(ch);
    window.p2hTrSending= true;
    return true;
}
window.addEventListener("beforeunload", function(e) { if (!window.p2hTrSending && document.querySelector("input.p2hTrChg")) { e.preventDefault(); e.returnValue= ""; } });
p2hTrFilter();
</script>';
    }
    if ($capt > '') htm_Card_end();
    if ($rtrn) return ob_get_clean();
}
