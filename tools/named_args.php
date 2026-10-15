<?php   $DocFil= 'tools/named_args.php';    $DocVers='1.7.0';    $DocRev='2026-10-15';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft ***
#  Upgrade helper for version 1.7: in 1.7 the parameters of 34 functions got a new order
#  (texts first: labl/capt, icon, hint, plho - then variant, name, value, data - form, action - size, style, attr - own parameters - rtrn last).
#  Calls with named arguments (labl:'...') are not affected. Calls with positional arguments are:
#  this tool rewrites them to named arguments - from the first position whose name has changed - so they work with both your old version and 1.7.
#
#  Run it on YOUR code BEFORE you replace the library with 1.7 (from the command line only):
#     php tools/named_args.php  <file or folder> ...            # shows what would be changed
#     php tools/named_args.php  <file or folder> ... --write    # changes the files (a copy is saved as <file>.bak)
#     php tools/named_args.php  <folder> --from=1.6.3 ...        # your code was written for 1.6.3 or older (1.5 - 1.6.3):
#                                                                # htm_CodeBox() had rtrn as argument 6 (fold since 1.6.4), and 4 parameters had other names
#
#  An old-style argument  $labl= '...'  (an assignment used as a name) becomes  labl: '...'  when the name fits its position.
#  Code written for 1.7 must not be run through the tool (its positions would be read as the old ones).
#  1.7.2: htm_TextArea(), htm_ActionButt(), htm_MultistateButt() and htm_ModalDialog() echo by default, as all other functions
#  (they returned the HTML before) - a call whose result is used (echo, ., =, return) gets rtrn: true.

if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Run this tool from the command line: php tools/named_args.php <folder>'); }

const P2H_ORDER = [
    // function => [old order (1.6), new order (1.7)]
    'htm_Input' => [['labl', 'plho', 'icon', 'hint', 'vrnt', 'name', 'valu', 'form', 'wdth', 'algn', 'attr', 'rtrn', 'unit', 'disa', 'rows', 'step', 'list', 'llgn', 'bord', 'ftop', 'lpos'],
                    ['labl', 'icon', 'hint', 'plho', 'vrnt', 'name', 'valu', 'list', 'form', 'wdth', 'algn', 'bord', 'attr', 'unit', 'disa', 'rows', 'step', 'llgn', 'ftop', 'lpos', 'rtrn']],
    'htm_Inbox' => [['labl', 'plho', 'icon', 'hint', 'vrnt', 'name', 'valu', 'form', 'wdth', 'algn', 'attr', 'rtrn', 'unit', 'disa', 'rows', 'step', 'list', 'llgn', 'bord', 'ftop', 'edit'],
                    ['labl', 'icon', 'hint', 'plho', 'vrnt', 'name', 'valu', 'list', 'form', 'wdth', 'algn', 'bord', 'attr', 'unit', 'disa', 'rows', 'step', 'llgn', 'ftop', 'edit', 'rtrn']],
    'htm_Output' => [['labl', 'icon', 'hint', 'vrnt', 'name', 'form', 'valu', 'vmax', 'attr', 'bclr', 'rtrn'],
                     ['labl', 'icon', 'hint', 'vrnt', 'name', 'valu', 'form', 'bclr', 'attr', 'vmax', 'rtrn']],
    'htm_TextPre' => [['body', 'algn', 'marg', 'attr', 'font', 'code', 'rtrn'],
                      ['body', 'algn', 'marg', 'font', 'attr', 'code', 'rtrn']],
    'htm_List_' => [['capt', 'vrnt', 'type', 'strt', 'styl', 'rtrn'],
                    ['capt', 'vrnt', 'type', 'styl', 'strt', 'rtrn']],
    'htm_CodeBox' => [['code', 'synt', 'repl', 'fmat', 'valu', 'fold', 'rtrn', 'vlue'],
                      ['code', 'valu', 'synt', 'repl', 'fmat', 'fold', 'rtrn', 'vlue']],
    'htm_TextVer' => [['body', 'algn', 'marg', 'attr', 'font', 'code', 'rtrn'],
                      ['body', 'algn', 'marg', 'font', 'attr', 'code', 'rtrn']],
    'htm_faq' => [['ques', 'answ', 'open', 'grup', 'wdth', 'code', 'rtrn'],
                  ['ques', 'answ', 'wdth', 'open', 'grup', 'code', 'rtrn']],
    'htm_Figure' => [['capt', 'type', 'imag', 'info', 'styl', 'labl', 'hint', 'rtrn'],
                     ['capt', 'labl', 'hint', 'type', 'styl', 'imag', 'info', 'rtrn']],
    'htm_Details' => [['capt', 'type', 'labl', 'body', 'styl', 'hint', 'mode', 'rtrn'],
                      ['capt', 'labl', 'hint', 'type', 'mode', 'body', 'styl', 'rtrn']],
    'htm_Table' => [['capt', 'pref', 'body', 'suff', 'note', 'data', 'filt', 'sort', 'crea', 'modi', 'vhgh', 'styl', 'from', 'list', 'expo', 'rtrn', 'wdth'],
                    ['capt', 'pref', 'body', 'suff', 'note', 'list', 'data', 'wdth', 'vhgh', 'styl', 'filt', 'sort', 'crea', 'modi', 'from', 'expo', 'rtrn']],
    'htm_iFrame' => [['srce', 'wdth', 'vhgh', 'titl', 'styl', 'rtrn', 'heig'],
                     ['titl', 'srce', 'wdth', 'vhgh', 'styl', 'rtrn', 'heig']],
    'htm_Field' => [['labl', 'body', 'icon', 'hint', 'name', 'wdth', 'styl', 'attr', 'llgn', 'rtrn', 'ftop'],
                    ['labl', 'icon', 'hint', 'name', 'body', 'wdth', 'styl', 'attr', 'llgn', 'ftop', 'rtrn']],
    'htm_Card_' => [['capt', 'icon', 'hint', 'form', 'acti', 'clas', 'wdth', 'styl', 'attr', 'show', 'mode', 'poup', 'head', 'vhgh', 'help', 'fclr', 'frst', 'last', 'simp', 'fold', 'elem', 'move', 'rtrn'],
                    ['capt', 'icon', 'hint', 'mode', 'form', 'acti', 'wdth', 'vhgh', 'fclr', 'styl', 'attr', 'clas', 'show', 'poup', 'head', 'help', 'frst', 'last', 'simp', 'fold', 'elem', 'move', 'rtrn']],
    'htm_Card_end' => [['labl', 'icon', 'hint', 'name', 'form', 'subm', 'attr', 'akey', 'kind', 'simu', 'foot', 'rtrn'],
                       ['labl', 'icon', 'hint', 'kind', 'name', 'form', 'attr', 'subm', 'akey', 'simu', 'foot', 'rtrn']],
    'htm_DataGroup' => [['capt', 'icon', 'hint', 'head', 'data', 'foot', 'wdth', 'vhgh', 'fclr', 'attr', 'styl', 'bord', 'rtrn'],
                        ['capt', 'icon', 'hint', 'data', 'wdth', 'vhgh', 'bord', 'fclr', 'styl', 'attr', 'head', 'foot', 'rtrn']],
    'htm_DataList' => [['capt', 'icon', 'hint', 'plho', 'name', 'form', 'acti', 'data', 'wdth', 'fclr', 'attr', 'bord', 'rtrn'],
                       ['capt', 'icon', 'hint', 'plho', 'name', 'data', 'form', 'acti', 'wdth', 'bord', 'fclr', 'attr', 'rtrn']],
    'htm_Form_' => [['name', 'acti', 'mode', 'type', 'attr', 'rtrn'],
                    ['name', 'type', 'mode', 'acti', 'attr', 'rtrn']],
    'htm_AcceptButt' => [['labl', 'icon', 'hint', 'form', 'wdth', 'attr', 'akey', 'kind', 'rtrn', 'tplc', 'tsty', 'acti', 'idix', 'disa'],
                         ['labl', 'icon', 'hint', 'kind', 'form', 'acti', 'wdth', 'attr', 'akey', 'tplc', 'tsty', 'idix', 'disa', 'rtrn']],
    'htm_SwitchButton' => [['labl', 'name', 'valu', 'wdth', 'bclr', 'styl', 'hint', 'list', 'rtrn'],
                           ['labl', 'hint', 'name', 'valu', 'list', 'wdth', 'bclr', 'styl', 'rtrn']],
    'htm_Humantest' => [['capt', 'icon', 'hint', 'form', 'wdth', 'vhgh', 'yclr', 'nclr', 'bclr', 'xytx', 'ntxt', 'rtrn', 'hght'],
                        ['capt', 'icon', 'hint', 'form', 'wdth', 'vhgh', 'bclr', 'yclr', 'nclr', 'xytx', 'ntxt', 'rtrn', 'hght']],
    'htm_Tab' => [['labl', 'body', 'name', 'styl', 'bclr', 'vhgh', 'dflt'],
                  ['labl', 'name', 'body', 'vhgh', 'bclr', 'styl', 'dflt']],
    'htm_LinkButt' => [['labl', 'hint', 'attr', 'link', 'targ', 'rtrn'],
                       ['labl', 'hint', 'link', 'targ', 'attr', 'rtrn']],
    'htm_TextArea' => [['labl', 'hint', 'name', 'form', 'valu', 'rows', 'wdth', 'plho', 'attr', 'rtrn', 'widt'],
                       ['labl', 'hint', 'plho', 'name', 'valu', 'form', 'wdth', 'attr', 'rows', 'rtrn', 'widt']],
    'htm_ModalDialog' => [['type', 'capt', 'mess', 'butt', 'html', 'rtrn'],
                          ['capt', 'type', 'mess', 'html', 'butt', 'rtrn']],
    'htm_Badge' => [['labl', 'kind', 'hint', 'rtrn'],
                    ['labl', 'hint', 'kind', 'rtrn']],
    'htm_ConfirmPostLink' => [['labl', 'icon', 'hint', 'acti', 'data', 'mess', 'kind', 'rtrn'],
                              ['labl', 'icon', 'hint', 'kind', 'mess', 'data', 'acti', 'rtrn']],
    'htm_TableTools' => [['tabl', 'srch', 'sort', 'plho', 'rtrn'],
                         ['tabl', 'plho', 'srch', 'sort', 'rtrn']],
    'htm_Dialog' => [['capt', 'body', 'bclr', 'butt', 'labl', 'rtrn'],
                     ['capt', 'labl', 'body', 'bclr', 'butt', 'rtrn']],
    'msg_System' => [['vrnt', 'capt', 'body', 'mess', 'list', 'wdth', 'rtrn'],
                     ['capt', 'vrnt', 'body', 'mess', 'list', 'wdth', 'rtrn']],
    'htm_Pmnu_' => [['elem', 'capt', 'wdth', 'icon', 'stck', 'attr', 'cntx', 'rtrn'],
                    ['capt', 'icon', 'wdth', 'attr', 'elem', 'stck', 'cntx', 'rtrn']],
    'htm_Menu_TopDown' => [['capt', 'data', 'foot', 'styl', 'wdth', 'note', 'niv0', 'niv1', 'niv2', 'them', 'view', 'rtrn'],
                           ['capt', 'note', 'data', 'wdth', 'styl', 'foot', 'niv0', 'niv1', 'niv2', 'them', 'view', 'rtrn']],
    'htm_Menu_Leftout' => [['capt', 'data', 'foot', 'styl', 'wdth', 'rtrn'],
                           ['capt', 'data', 'wdth', 'styl', 'foot', 'rtrn']],
    'htm_Page_' => [['titl', 'hint', 'info', 'inis', 'algn', 'imag', 'attr', 'pbrd'],
                    ['titl', 'hint', 'algn', 'attr', 'info', 'inis', 'imag', 'pbrd']],
];

# Before 1.6.4 (1.5 - 1.6.3): the old order of these 4 functions (the names still work in 1.7 as aliases)
const P2H_ORDER_163 = [
    'htm_CodeBox'   => ['code', 'synt', 'repl', 'fmat', 'vlue', 'rtrn'],
    'htm_iFrame'    => ['srce', 'wdth', 'heig', 'titl', 'styl', 'rtrn'],
    'htm_Humantest' => ['capt', 'icon', 'hint', 'form', 'wdth', 'hght', 'yclr', 'nclr', 'bclr', 'xytx', 'ntxt', 'rtrn'],
    'htm_TextArea'  => ['labl', 'hint', 'name', 'form', 'valu', 'rows', 'widt', 'plho', 'attr', 'rtrn'],
];

# 1.7.2: these 4 functions echo by default, as all others (they returned the HTML before) - function => position of rtrn (0-based) in 1.6
const P2H_RTRN_WAS_TRUE = ['htm_textarea' => 9, 'htm_actionbutt' => 8, 'htm_multistatebutt' => 4, 'htm_modaldialog' => 5];

function na_order(): array {        # function name in lower case => [old order, new order, name]
    static $map = null;
    if ($map !== null) return $map;
    global $from;
    $map = [];
    foreach (P2H_ORDER as $fn => [$old, $new]) {
        if ($from !== null && version_compare($from, '1.6.4', '<') && isset(P2H_ORDER_163[$fn])) $old = P2H_ORDER_163[$fn];
        $map[strtolower($fn)] = [$old, $new, $fn];
    }
    return $map;
}

function na_rewrite(string $src, string $file, array &$log): string {
    $toks = token_get_all($src);
    $n = count($toks);  $edits = [];  $pos = 0;  $offs = [];
    foreach ($toks as $i => $t) { $offs[$i] = $pos;  $pos += strlen(is_array($t) ? $t[1] : $t); }
    $skip = [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT];
    $prev = function ($i) use ($toks, $skip) { for ($j = $i - 1; $j >= 0; $j--) if (!is_array($toks[$j]) || !in_array($toks[$j][0], $skip)) return $toks[$j]; return null; };
    $next = function ($i) use ($toks, $skip, $n) { for ($j = $i + 1; $j < $n; $j++) if (!is_array($toks[$j]) || !in_array($toks[$j][0], $skip)) return $j; return $n; };
    for ($i = 0; $i < $n; $i++) {
        $t = $toks[$i];
        # htm_Input(, \htm_Input( (in a namespace) and HTM_INPUT( (function names ignore case) - was only the exact spelling
        if (!is_array($t) || !in_array($t[0], [T_STRING, T_NAME_FULLY_QUALIFIED])) continue;
        $key = strtolower(ltrim($t[1], '\\'));
        if (!isset(na_order()[$key]) && !isset(P2H_RTRN_WAS_TRUE[$key])) continue;
        $p = $prev($i);
        if (is_array($p) && in_array($p[0], [T_FUNCTION, T_OBJECT_OPERATOR, T_DOUBLE_COLON, T_NEW, T_NULLSAFE_OBJECT_OPERATOR])) continue;
        $o = $next($i);
        if ($o >= $n || $toks[$o] !== '(') continue;
        // the arguments: [first token, last token] at depth 0
        $args = [];  $depth = 0;  $start = $o + 1;  $end = null;
        for ($j = $o + 1; $j < $n; $j++) {
            $c = is_array($toks[$j]) ? $toks[$j][1] : $toks[$j];
            if (in_array($c, ['(', '[', '{']) || (is_array($toks[$j]) && in_array($toks[$j][0], [T_CURLY_OPEN, T_DOLLAR_OPEN_CURLY_BRACES]))) $depth++;
            elseif (in_array($c, [')', ']', '}'])) { if ($depth === 0) { $args[] = [$start, $j - 1];  $end = $j;  break; }  $depth--; }
            elseif ($c === ',' && $depth === 0) { $args[] = [$start, $j - 1];  $start = $j + 1; }
        }
        if ($end === null) continue;
        // 1.7.2: these functions echo by default (returned before) - a call whose result is used gets rtrn: true
        if (isset(P2H_RTRN_WAS_TRUE[$key])) {
            $given = false;  $npos = 0;
            foreach ($args as [$a, $b]) {
                $f = $next($a - 1);  if ($f > $b) continue;
                $g = $next($f);
                if (is_array($toks[$f]) && $g <= $b && $toks[$g] === ':') { if ($toks[$f][1] === 'rtrn') $given = true; }
                else $npos++;
            }
            if ($npos > P2H_RTRN_WAS_TRUE[$key]) $given = true;                      // rtrn given by position
            $pt = $prev($i);  $pc = is_array($pt) ? $pt[1] : $pt;
            $statement = (in_array($pc, [';', '{', '}', ':', ')', null], true) || (is_array($pt) && in_array($pt[0], [T_OPEN_TAG, T_ELSE])))
                         && (($toks[$next($end)] ?? '') === ';');
            if (!$given && !$statement) {
                $last = $toks[$next($o)] === ')' ? '' : ', ';
                $edits[] = [$offs[$end], $offs[$end], $last.'rtrn: true'];
                $log[] = "$file:{$t[2]}  {$t[1]}(): the result is used - rtrn: true added (the function echoes by default since 1.7.2)";
            }
            if (!isset(na_order()[$key])) continue;
        }
        [$old, $new] = na_order()[$key];
        $first = null;                                          // first position whose name has changed
        foreach ($old as $k => $nm) if (($new[$k] ?? null) !== $nm) { $first = $k;  break; }
        if ($first === null) continue;
        $line = $t[2];  $did = [];
        foreach ($args as $k => [$a, $b]) {
            $f = $next($a - 1);
            if ($f > $b) continue;                              // empty (trailing comma)
            $ft = $toks[$f];
            if ($ft === '...' || (is_array($ft) && $ft[0] === T_ELLIPSIS)) { $log[] = "$file:$line  {$t[1]}(): spread arguments (...) - check by hand";  continue 2; }
            $g = $next($f);
            if (is_array($ft) && $g <= $b && $toks[$g] === ':' && in_array($ft[0], [T_STRING, T_LIST, T_ARRAY, T_PRINT, T_ECHO, T_FN, T_MATCH, T_DEFAULT, T_EMPTY])) break;   // named from here
            if ($k < $first) continue;
            if (!isset($old[$k])) { $log[] = "$file:$line  {$t[1]}(): more arguments than parameters - check by hand";  continue 2; }
            $name = $old[$k];
            // old style  $labl= value  ->  labl: value
            if (is_array($ft) && $ft[0] === T_VARIABLE && $g <= $b && $toks[$g] === '=' && $next($g) <= $b) {
                $vn = substr($ft[1], 1);
                if ($vn === $name) { $edits[] = [$offs[$f], $offs[$next($g)], "$name: "];  $did[] = "\$$vn= -> $name:";  continue; }
                $log[] = "$file:$line  {$t[1]}(): argument ".($k + 1)." is the assignment \$$vn= but the parameter there is $name - named as $name:";
            }
            $edits[] = [$offs[$f], $offs[$f], "$name: "];  $did[] = $name;
        }
        if ($did) $log[] = "$file:$line  {$t[1]}(): ".implode(', ', $did);
    }
    usort($edits, fn($x, $y) => $y[0] <=> $x[0]);
    foreach ($edits as [$from, $to, $text]) $src = substr($src, 0, $from).$text.substr($src, $to);
    return $src;
}

$write = in_array('--write', $argv);
$from  = null;                                          # --from=1.6.3: the code was written for that version
foreach ($argv as $a) if (preg_match('/^--from=(\d+\.\d+(?:\.\d+)?)$/', $a, $fm)) $from = $fm[1];
$paths = array_values(array_filter(array_slice($argv, 1), fn($a) => $a !== '--write' && !str_starts_with($a, '--from=')));
if (!$paths) { fwrite(STDERR, "Use: php tools/named_args.php <file or folder> ... [--write]\n");  exit(1); }
$files = [];
foreach ($paths as $p) {
    if (is_file($p)) { $files[] = $p;  continue; }
    if (!is_dir($p)) { fwrite(STDERR, "Not found: $p\n");  continue; }
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($p, FilesystemIterator::SKIP_DOTS));
    foreach ($it as $f) if (preg_match('/\.php$/i', $f->getFilename()) && !preg_match('#[\\\\/](\.git|vendor|node_modules)[\\\\/]#', $f->getPathname())) $files[] = $f->getPathname();
}
$changed = 0;  $log = [];
foreach ($files as $f) {
    if (realpath($f) === realpath(__FILE__)) continue;
    $src = file_get_contents($f);  $res = na_rewrite($src, $f, $log);
    if ($res === $src) continue;
    $changed++;
    if ($write) { copy($f, $f.'.bak');  file_put_contents($f, $res); }
}
foreach ($log as $l) echo $l, "\n";
echo $changed, ' file(s) ', ($write ? 'changed (copies: *.bak)' : 'would be changed - run again with --write to change them'), "\n";
