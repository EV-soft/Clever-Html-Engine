<?php # File: ./Proj.demo/docHelp.inc.php - ver:1.6.4 - 2026-10-15 - evs    (only a comment: the variables $DocFile, $DocVer ... belong to the page that includes this file)
# Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** See the file: LICENSE
# Helpers for the reference pages of the demo (table.page.php, card.page.php ...)

# The code of an example: the lines between "// EXAMPLE: <name>" and "// END" in the page - the code shown is the code that runs
function docExample($name, $file= '') {
    static $src= [];
    $file= $file ?: (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[0]['file'] ?? '');   # The page that calls (also when it is included)
    $src[$file] ??= file($file);
    $out= [];  $on= false;
    foreach ($src[$file] as $l) {
        if ($on and preg_match('~^\s*// END\s*$~', $l)) break;
        if ($on) $out[]= rtrim($l)."\n";
        if (preg_match('~^\s*// EXAMPLE: '.preg_quote($name, '~').'\s*$~', $l)) $on= true;
    }
    $ind= min(array_map(function($l) { return strlen($l) - strlen(ltrim($l)); }, array_filter($out, 'trim')) ?: [0]);
    return implode('', array_map(function($l) use ($ind) { return substr($l, min($ind, strlen($l) - strlen(ltrim($l)))); }, $out));
}

# The parameters of a library function, read from the library itself (name, default and the comment after it) - so the list cannot get out of date
# Rows: [name, default, type, description]
function docParams($func) {
    $rf= new ReflectionFunction($func);
    $src= implode('', array_slice(file($rf->getFileName()), $rf->getStartLine() - 1, 80));
    if (preg_match('~\n\s*\)\s*(\{|\n|#|//)~', $src, $m, PREG_OFFSET_CAPTURE)) $src= substr($src, 0, $m[0][1] + 1);   # Only the parameter list (not the body)
    $rows= [];
    foreach ($rf->getParameters() as $p) {
        $n= $p->getName();
        if (preg_match('~&?\$'.$n.'\s*=\s*__FILE__~', $src)) $def= '__FILE__';
        else {
            $v= $p->isDefaultValueAvailable() ? $p->getDefaultValue() : null;
            $def= is_array($v) ? json_encode($v) : var_export($v, true);
        }
        $doc= ['', ''];
        if (preg_match('~&?\$'.$n.'\s*=[^\n#]*#\s*(\w+):\s*([^\n]*)~', $src, $m)) $doc= [$m[1], trim($m[2])];
        elseif (preg_match('~&?\$'.$n.'\s*=[^\n#]*#\s*([^\n]*)~', $src, $m)) $doc= ['', trim($m[1])];
        $more= '';                                           # The comment lines that follow (details)
        if (preg_match('~&?\$'.$n.'\s*=[^\n]*\n((?:[ \t]*#[^\n]*\n)+)~', $src, $m))
            foreach (explode("\n", trim($m[1])) as $l) $more.= '<br>'.sys_enc(trim(ltrim(trim($l), '#')));
        $rows[]= [$n.($p->isPassedByReference() ? ' (&amp;)' : ''), sys_enc($def), $doc[0], sys_enc($doc[1]).'<small>'.$more.'</small>'];
    }
    return $rows;
}

# A table with the parameters of a library function
function docParamTable($func, $vhgh= '600px') {
    $rows= docParams($func);
    htm_Table(body: [['@Parameter',   '12%', 'html', '', ['left'], 'p'],
                     ['@Default',     '16%', 'html', '', ['left'], 'd'],
                     ['@Type',        '8%',  'html', '', ['left'], 't'],
                     ['@Description', '64%', 'html', '', ['left'], 'x']],
              data: $rows, crea: false, modi: false, filt: false, sort: false, vhgh: $vhgh);
}

# The card that shows what the server received, when a form of the page was saved
function docPostCard() {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') return;
    $got= $_POST;  unset($got['csrf_token']);
    htm_Card_(capt:'@What the server received ($_POST)', icon:'fas fa-server', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        htm_TextPre(body:sys_enc(print_r($got, true)), attr:'max-height: 300px; overflow: auto;');
    htm_Card_end();
}
?>
