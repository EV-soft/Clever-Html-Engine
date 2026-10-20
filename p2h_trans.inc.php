<?php  $DocFileTrans='../p2h_trans.inc.php';    $DocVerTrans='1.8.0';    $DocRevTrans='2026-10-21';      $DocIni='evs';  ## File informative only
# Maintenance of the translations of a program (_trans.sys.json) - in the program itself, for its administrators.
# Optional: require it after php2html.lib.php. The program decides who may use it (like htm_AuditLog).
#
#   if (isset($_POST['p2h_trans_save']) && $userIsAdmin) [$ok, $msg]= p2h_trans_handle();     # Before any output - then redirect
#   htm_TransEditor(capt:'@Translations', scan:[__FILE__, __DIR__.'/php2html.lib.php']);      # The card: language, search, missing first
#
#   $gbl_TransFile= __DIR__.'/_trans.sys.json';     # Before require: the file (default: as the library reads it)
#
# Suggestions (sugg:true) - no key needed: the translator built into the browser (Chrome / Edge: on the PC, nothing is sent),
# else MyMemory (api.mymemory.translated.net - free, about 5000 characters a day). Only empty fields are filled, marked to be checked.
# Better: "Copy for AI" - the whole table (the missing texts shown + the translations made, as the words to use) with an instruction,
# for an AI chat (ChatGPT, Claude ...): it sees the context and keeps the words the same. Its JSON answer is pasted back ("Paste the answer").
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

function p2h_trans_end($s, $open) {   # The "}" that ends the object starting at $open - the texts ("...") are skipped
    for ($i= $open + 1, $n= strlen($s); $i < $n; $i++) {
        $c= $s[$i];
        if ($c === '"') { for ($i++; $i < $n && $s[$i] !== '"'; $i++) if ($s[$i] === '\\') $i++;  continue; }
        if ($c === '}') return $i;
    }
    return false;
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
            $close=  $open === false ? false : p2h_trans_end($raw, $open);    # The "}" of the block - not one in a text ("{n} files")
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
                if ($v === '' && $lm[2][0] === '' && preg_match('/,([ \t]*\r?\n[ \t]*)$/', substr($patch, $open, $at - $open), $pm, PREG_OFFSET_CAPTURE)) {
                    $patch= substr($patch, 0, $open + $pm[0][1]).substr($patch, $open + $pm[0][1] + 1);    # The last text removed: the line before is the last now - without its comma
                    $close--;
                }
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
            if ($patch !== false && strpos($raw, "\r\n") !== false) $patch= str_replace("\n", "\r\n", $patch);     # The line endings of the file stay
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

function htm_TransEditor(# capt:'@Translations', icon:'fa-solid fa-language', hint:'', scan:[], code:'', acti:'', sugg:true, prog:'', wdth:'98%', rtrn:false)
    $capt= '@Translations',             # string: The caption of the card ('' : no card)
    $icon= 'fa-solid fa-language',      # string: The icon of the card
    $hint= '',                          # string: The hint of the card
    $scan= [],                          # array:  The source files with the texts ('@English text') - their missing translations are shown first
    $code= '',                          # string: The language shown ('' : ?tl= or the language of the user - never English)
    $acti= '',                          # string: The address the form is sent to ('' : this page) - add &tl= yourself to come back to the language
    $sugg= true,                        # bool:   The button "Suggestions" for the missing texts (the browser's translator - else MyMemory)
    $prog= '',                          # string: The program for "Copy for AI" - what it is (e.g. 'Folder-explorer, a web file manager') - '' : the appName of the file
    $wdth= '98%',                       # string: The width of the table
    $rtrn= false                        # bool:   Return the HTML instead of echoing it
) {
    if ($rtrn) ob_start();
    $data= p2h_trans_load();
    $langs= $data ? array_values(array_filter($data['language'], fn($l) => isset($l['code']) && $l['code'] !== 'en')) : [];
    $code= $code ?: (is_string($_GET['tl'] ?? null) ? $_GET['tl'] : '') ?: (is_string($GLOBALS['lang'] ?? null) ? $GLOBALS['lang'] : '');
    if (!in_array($code, array_column($langs, 'code'), true)) $code= $langs[0]['code'] ?? '';
    foreach ($langs as $l) if ($l['code'] === $code) $cur= $l;
    $tr=   is_array($cur['translation'] ?? null) ? $cur['translation'] : [];
    $src=  $scan ? p2h_trans_scan($scan) : [];
    $ref=  [];                                          # The texts of the most translated language: also those the scan can not find (lang('@'.$x))
    foreach ($langs as $l) if ($l['code'] !== $code && count((array)($l['translation'] ?? [])) > count($ref)) $ref= (array)$l['translation'];
    $keys= array_keys($src + $ref + $tr);
    $rows= [];
    foreach ($keys as $k) $rows[]= [$k, $tr[$k] ?? '', !isset($tr[$k]) || $tr[$k] === '', false];   # text, translation, missing - (a text that is not found in the source is not marked: a program may build its texts, as lang('@'.$x))
    usort($rows, fn($a, $b) => [$b[2], mb_strtolower($a[0])] <=> [$a[2], mb_strtolower($b[0])]);       # Missing first
    $miss= count(array_filter($rows, fn($r) => $r[2]));
    $act=  $acti !== '' ? $acti : ($_SERVER['REQUEST_URI'] ?? '');
    if ($capt > '') htm_Card_(capt: $capt, icon: $icon, hint: $hint, clas: 'cardWmax');
    if (!$data) echo '<p class="p2hAlert p2hAlert-error">'.sys_enc(lang('@The translation file is missing or broken')).': '.sys_enc(p2h_trans_file()).'</p>';
    else {
        # Language - with the number of translations (the empty languages last)
        usort($langs, fn($a, $b) => [empty($a['translation']), $a['name'] ?? ''] <=> [empty($b['translation']), $b['name'] ?? '']);     # (was the other way round: the translated last)
        $lname= fn($l) => sys_enc($l['code'].' - '.($l['name'] ?? '').' ('.count((array)($l['translation'] ?? [])).')');
        $flag=  fn($c) => function_exists('p2h_flag') ? p2h_flag($c) : '';
        echo '<div class="p2hTrBar">'.sys_enc(lang('@Language')).': <span class="p2hTrLang">'.      # A list with flags (an <option> can not show one)
                 '<button type="button" class="p2hTrLangBtn" aria-haspopup="listbox" aria-expanded="false" onclick="p2hTrLangOpen(this)">'.
                     $flag($code).' '.$lname($cur ?? ['code' => $code]).' <i class="fa-solid fa-caret-down"></i></button>'.
                 '<div class="p2hTrLangList" role="listbox" aria-label="'.sys_enc(lang('@Language')).'" hidden>'.
                     '<input type="search" class="p2hTrLangFind" placeholder="'.sys_enc(lang('@Find a language...')).'" aria-label="'.sys_enc(lang('@Find a language...')).'" oninput="p2hTrLangFind(this)">'.
                     implode('', array_map(fn($l) => '<button type="button" role="option" data-c="'.sys_enc($l['code']).'" aria-selected="'.($l['code'] === $code ? 'true' : 'false').'"'.
                         (empty($l['translation']) ? ' class="p2hTrLangEmpty"' : '').' onclick="p2hTrGo(this.dataset.c)">'.$flag($l['code']).' '.$lname($l).'</button>', $langs)).
                 '</div></span> '.
             '<input type="search" class="p2hTrFind" placeholder="'.sys_enc(lang('@Search...')).'" aria-label="'.sys_enc(lang('@Search')).'" oninput="p2hTrFilter()"> '.
             '<label><input type="checkbox" class="p2hTrMiss" onchange="p2hTrFilter()"> '.sys_enc(lang('@Only missing')).' ('.$miss.')</label> '.
             '<span class="p2hTrCount"></span></div>';
        # How to add a new language - shown folded (open when the language has no translations yet)
        echo '<details class="p2hTrHow"'.(!$tr ? ' open' : '').'><summary><i class="fa-solid fa-circle-info"></i> '.sys_enc(lang('@How to add a new language')).'</summary><ol>'.
             implode('', array_map(fn($t) => '<li>'.lang($t).'</li>', [
                 '@Choose the language in the list - the languages without translations are at the bottom.',
                 '@<b>Copy for AI</b>: paste the text in an AI chat (ChatGPT, Claude ...), then its answer with <b>Paste the answer</b>. Or <b>Suggestions</b>: 50 at a time.',
                 '@Check the suggestions (dashed frame) and <b>Save the changes</b>.',
                 '@Reload the page: the language is in the language selector (the flag in the view bar) as soon as it has a translation.',
                 '@Flag: 23 languages have one - other languages are shown with their code (ES), or the program adds the flag with $gbl_Flags.'])).'</ol></details>';
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
             ' <span class="p2hTrN">0</span></button> '.
             ($sugg ? '<abbr class="hint"><button type="button" class="p2hTrSugBtn" data-lang="'.sys_enc($code).'" data-t="'.sys_enc(json_encode([
                     'none' => lang('@No empty missing texts are shown'), 'busy' => lang('@Suggesting...'), 'done' => lang('@suggestions - check them before you save'),
                     'quota' => lang('@The free daily amount of MyMemory is used - try again tomorrow'), 'err' => lang('@No suggestions could be fetched'),
                     'browser' => lang('@the translator of the browser'), 'mm' => 'MyMemory',
                     'aiCopied' => lang('@texts copied for the AI - paste them in the AI chat, then its answer below'),
                     'aiBad' => lang('@The answer is not JSON: {"English text": "translation", ...}'), 'aiSkip' => lang('@not used (unknown, empty or already translated)')], JSON_UNESCAPED_UNICODE)).'" onclick="p2hTrSuggest(this)">'.
                 '<i class="fa-solid fa-wand-magic-sparkles"></i> '.sys_enc(lang('@Suggestions')).'</button><data-hint>'.
                 sys_enc(lang('@Fills the empty missing texts shown (at most 50) - with the translator of the browser, or else MyMemory (the English texts are sent to translated.net). Check them before you save.')).
                 '</data-hint></abbr> <span class="p2hTrSugSt"></span> '.
                 '<abbr class="hint"><button type="button" class="p2hTrAiBtn" onclick="p2hTrAiCopy(this)" data-app="'.sys_enc($prog !== '' ? $prog : (string)($data['appName'] ?? '')).'" '.
                     'data-lname="'.sys_enc(($cur['name'] ?? $code).(($cur['native'] ?? '') > '' ? ' ('.$cur['native'].')' : '')).'">'.
                     '<i class="fa-solid fa-robot"></i> '.sys_enc(lang('@Copy for AI')).'</button><data-hint>'.
                     sys_enc(lang('@An AI (ChatGPT, Claude ...) translates better when it gets the whole table: the missing texts shown and the translations made (the words to use) - with an instruction. Paste it in the AI chat, and its answer below.')).
                 '</data-hint></abbr> '.
                 '<button type="button" class="p2hTrAiPasteBtn" onclick="var x= this.form.querySelector(\'.p2hTrAiBox\'); x.hidden= !x.hidden; if (!x.hidden) x.querySelector(\'textarea\').focus();">'.
                     '<i class="fa-solid fa-paste"></i> '.sys_enc(lang('@Paste the answer')).'</button> '.
                 '<div class="p2hTrAiBox" hidden><textarea rows="6" placeholder="'.sys_enc(lang('@The answer of the AI: {"English text": "translation", ...}')).'"></textarea><br>'.
                     '<button type="button" onclick="p2hTrAiUse(this)"><i class="fa-solid fa-check"></i> '.sys_enc(lang('@Use the answer')).'</button> '.
                     '<small>'.sys_enc(lang('@Only empty fields are filled - marked to be checked before you save.')).'</small></div>' : '').
             '<br><small>'.sys_enc(lang('@An empty field removes the translation - the English text is shown. Simple HTML (b, i, br, code) is allowed.')).'</small></div>'.
             '<noscript><p class="p2hAlert p2hAlert-error">'.sys_enc(lang('@The editor needs JavaScript')).'</p></noscript></form>';
        echo '<style>
.p2hTrBar { display: flex; flex-wrap: wrap; gap: 6px 14px; align-items: center; margin: 4px 0 8px; text-align: left; }
.p2hTrLang { position: relative; display: inline-block; }
.p2hTrLangBtn { display: inline-flex; align-items: center; gap: 6px; padding: 3px 8px; border: 1px solid #9aa5b1; border-radius: 4px; background: var(--InptBgrd, #fff); color: var(--TextColr, #222); font: inherit; cursor: pointer; }
.p2hTrLangList { position: absolute; left: 0; top: calc(100% + 2px); z-index: 50; width: 300px; max-height: 340px; overflow-y: auto; padding: 4px;
    background: var(--CardsBgrd, #fff); border: 1px solid #9aa5b1; border-radius: 6px; box-shadow: 0 4px 16px rgba(0,0,0,0.18); text-align: left; }
.p2hTrLangList input { width: 100%; box-sizing: border-box; margin-bottom: 4px; }
.p2hTrLangList button { display: flex; align-items: center; gap: 6px; width: 100%; padding: 3px 6px; border: 0; border-radius: 4px; background: none; color: inherit; font: inherit; text-align: left; cursor: pointer; }
.p2hTrLangList button:hover, .p2hTrLangList button:focus-visible { background: rgba(47,111,176,0.14); outline: none; }
.p2hTrLangList button[aria-selected=true] { font-weight: 600; }
.p2hTrLangList button.p2hTrLangEmpty { opacity: 0.7; }
.p2hTrLang .p2hFlag { flex: none; border: 1px solid rgba(0,0,0,0.15); }
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
.p2hTrTbl input.p2hTrSug { border-style: dashed; border-color: #8a4fc4; box-shadow: 0 0 0 2px rgba(138,79,196,0.2); }     /* A suggestion: to be checked */
.p2hTrSugSt { font-size: 12px; }
.p2hTrHow { text-align: left; margin: 0 0 8px; padding: 4px 10px; border: 1px solid #b8c4d0; border-radius: 4px; background: rgba(47,111,176,0.06); font-size: 13px; }
.p2hTrHow summary { cursor: pointer; font-weight: 600; }  .p2hTrHow ol { margin: 4px 0 2px; padding-left: 22px; }
.p2hTrAiBox { margin: 6px 0; }  .p2hTrAiBox textarea { width: 98%; font: 12px monospace; }
.p2hTrNote { color: #888; font-style: italic; }
.p2hTrFoot { margin-top: 8px; text-align: left; }
[data-theme="dark"] .p2hTrTbl td { border-color: #3f4852; }  [data-theme="dark"] .p2hTrWrap { border-color: #4a5560; }
</style><script>
function p2hTrGo(c) { var u= new URL(location.href); u.searchParams.set("tl", c); location.href= u.toString(); }
function p2hTrLangOpen(b) {         /* The list of languages with flags: open / close - search - arrows, Enter, Esc */
    var l= b.nextElementSibling, open= l.hidden;
    l.hidden= !open;  b.setAttribute("aria-expanded", open ? "true" : "false");
    if (open) { var f= l.querySelector("input");  f.value= "";  p2hTrLangFind(f);  f.focus();
                var sel= l.querySelector("[aria-selected=true]");  if (sel) sel.scrollIntoView({block: "nearest"}); }
}
function p2hTrLangFind(f) {
    var q= f.value.trim().toLowerCase();
    f.parentNode.querySelectorAll("button[role=option]").forEach(function(o) { o.hidden= q !== "" && o.textContent.toLowerCase().indexOf(q) < 0; });
}
document.addEventListener("click", function(e) {
    document.querySelectorAll(".p2hTrLangList:not([hidden])").forEach(function(l) {
        if (!l.parentNode.contains(e.target)) { l.hidden= true;  l.previousElementSibling.setAttribute("aria-expanded", "false"); }
    });
});
document.addEventListener("keydown", function(e) {
    var l= e.target.closest && e.target.closest(".p2hTrLangList");  if (!l) return;
    var os= Array.prototype.filter.call(l.querySelectorAll("button[role=option]"), function(o) { return !o.hidden; }), i= os.indexOf(document.activeElement);
    if (e.key === "Escape") { l.hidden= true;  l.previousElementSibling.setAttribute("aria-expanded", "false");  l.previousElementSibling.focus(); }
    else if (e.key === "ArrowDown" || e.key === "ArrowUp") { e.preventDefault();  if (os.length) os[i < 0 ? (e.key === "ArrowDown" ? 0 : os.length - 1) : (i + (e.key === "ArrowDown" ? 1 : os.length - 1)) % os.length].focus(); }
    else if (e.key === "Enter" && e.target.tagName === "INPUT" && os.length) { e.preventDefault();  p2hTrGo(os[0].dataset.c); }
});
function p2hTrMark(i, sug) {
    i.classList.toggle("p2hTrChg", i.value !== i.dataset.v);
    i.classList.toggle("p2hTrSug", !!sug && i.value !== i.dataset.v);       /* A suggestion until it is edited */
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
async function p2hTrSuggest(b) {    /* Suggestions for the empty missing texts shown: the translator of the browser - else MyMemory (free, no key) */
    var T= JSON.parse(b.dataset.t), code= b.dataset.lang, st= b.parentNode.parentNode.querySelector(".p2hTrSugSt");
    var rows= Array.prototype.filter.call(document.querySelectorAll(".p2hTrTbl tbody tr.p2hTrM"), function(tr) {
        return !tr.hidden && !tr.querySelector("input").value; }).slice(0, 50);
    if (!rows.length) { st.textContent= T.none;  return; }
    b.disabled= true;  st.textContent= T.busy;
    var tl= null, engine= T.mm, n= 0, fail= 0;
    try {                                           /* The browser (on the PC - nothing is sent) */
        if (self.Translator) {
            var av= await Translator.availability({sourceLanguage: "en", targetLanguage: code});
            if (av && av !== "unavailable") { tl= await Translator.create({sourceLanguage: "en", targetLanguage: code});  engine= T.browser; }
        }
    } catch (e) { tl= null; }
    function plain(h) { var d= document.createElement("textarea");  d.innerHTML= h;  return d.value; }
    async function mm(q) {
        var r= await fetch("https://api.mymemory.translated.net/get?q=" + encodeURIComponent(q) + "&langpair=en|" + encodeURIComponent(code));
        var j= await r.json(), t= j && j.responseData ? String(j.responseData.translatedText || "") : "";
        if (j.quotaFinished || /MYMEMORY WARNING/i.test(t) || r.status === 429) throw "quota";
        return plain(t);
    }
    for (var i= 0; i < rows.length; i++) {
        var inp= rows[i].querySelector("input"), k= inp.dataset.k, out= "";
        try { out= tl ? await tl.translate(k) : await mm(k); }
        catch (e) { if (e === "quota") { st.textContent= T.quota;  break; }  fail++;  continue; }
        out= String(out || "").trim();
        if (out && !/[.!?]$/.test(k.trim())) out= out.replace(/\.$/, "");      /* No full stop the English text does not have */
        if (out && /\s$/.test(k)) out+= " ";                                   /* "Warning: " keeps its space */
        if (out.trim() && out !== k && !inp.value) { inp.value= out;  p2hTrMark(inp, true);  n++; }
        st.textContent= T.busy + " " + (i + 1) + " / " + rows.length;
    }
    if (st.textContent !== T.quota) st.textContent= n ? n + " " + T.done + " (" + engine + ")" : T.err;
    b.disabled= false;
}
function p2hTrAiCopy(b) {          /* The whole table for an AI chat: the missing texts shown - and the translations made, as the words to use */
    var T= JSON.parse(b.form.querySelector(".p2hTrSugBtn").dataset.t), miss= {}, made= {}, nm= 0, nd= 0;
    document.querySelectorAll(".p2hTrTbl tbody tr").forEach(function(tr) {
        var i= tr.querySelector("input");
        if (tr.classList.contains("p2hTrM") && !tr.hidden && !i.value) { miss[i.dataset.k]= "";  nm++; }
        else if (i.value && nd < 600) { made[i.dataset.k]= i.value;  nd++; }
    });
    if (!nm) { b.parentNode.parentNode.querySelector(".p2hTrSugSt").textContent= T.none;  return; }
    var txt= "Translate the user interface texts of the web program \"" + (b.dataset.app || "") + "\" from English to " + b.dataset.lname + ".\n" +
        "Rules:\n- Short, natural texts as in a program (buttons, menus, messages) - the same words as in the translations already made (below).\n" +
        "- Keep HTML tags (<b>, <br> ...), placeholders and the punctuation: a text ending with \":\" or a space ends so in the translation too.\n" +
        "- Answer ONLY with one JSON object: {\"English text\": \"translation\", ...} - the English texts exactly as given.\n\n" +
        "TEXTS TO TRANSLATE (" + nm + "):\n" + JSON.stringify(miss, null, 1) + "\n\n" +
        "TRANSLATIONS ALREADY MADE - use the same words (" + nd + "):\n" + JSON.stringify(made, null, 1) + "\n";
    var st= b.parentNode.parentNode.querySelector(".p2hTrSugSt"), box= b.form.querySelector(".p2hTrAiBox");
    function done() { st.textContent= nm + " " + T.aiCopied;  box.hidden= false; }
    if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(txt).then(done, function() { box.hidden= false;  box.querySelector("textarea").value= txt; });
    else { box.hidden= false;  box.querySelector("textarea").value= txt; }
}
function p2hTrAiUse(b) {           /* The JSON answer of the AI: the empty fields with these English texts are filled - marked as suggestions */
    var T= JSON.parse(b.form.querySelector(".p2hTrSugBtn").dataset.t), ta= b.parentNode.querySelector("textarea"), st= b.form.querySelector(".p2hTrSugSt"), j= null;
    var t= ta.value, a= t.indexOf("{"), z= t.lastIndexOf("}");
    try { j= JSON.parse(t.slice(a, z + 1)); } catch (e) { j= null; }
    if (!j || typeof j !== "object") { st.textContent= T.aiBad;  return; }
    var inputs= {}, trimmed= {}, n= 0, skip= 0;
    document.querySelectorAll(".p2hTrTbl tbody input").forEach(function(i) { inputs[i.dataset.k]= i;  trimmed[i.dataset.k.trim()]= i; });
    Object.keys(j).forEach(function(k) {
        var i= inputs[k] || trimmed[k.trim()], v= typeof j[k] === "string" ? j[k] : "";     /* An AI may trim "Warning: " */
        if (i && /\s$/.test(i.dataset.k) && !/\s$/.test(v)) v+= " ";
        if (!i || !v.trim() || i.value) { skip++;  return; }
        i.value= v;  p2hTrMark(i, true);  n++;
    });
    st.textContent= n + " " + T.done + " (AI)" + (skip ? " - " + skip + " " + T.aiSkip : "");
    ta.value= "";  b.parentNode.hidden= true;
}
window.addEventListener("beforeunload", function(e) { if (!window.p2hTrSending && document.querySelector("input.p2hTrChg")) { e.preventDefault(); e.returnValue= ""; } });
p2hTrFilter();
</script>';
    }
    if ($capt > '') htm_Card_end();
    if ($rtrn) return ob_get_clean();
}
