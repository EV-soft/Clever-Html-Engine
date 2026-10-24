<?php   $DocFil= 'tools/check_pages.php';    $DocVers='1.0.0';    $DocRev='2026-10-24';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft ***
#  Checks the repository before a commit or a release (from the command line only):
#     php tools/check_pages.php                  # lint every PHP file + open every demo page + is php2html.api.md up to date
#     php tools/check_pages.php  Proj.demo/card.page.php ...   # only these pages (and the lint)
#  1. php -l on every .php file (not latest/, _cache/, .git/).
#  2. Starts PHP's built-in web server on a free port and opens every *.page.php in Proj.demo/, Quick_Proj/ and world/:
#     the page must answer 200 and show no PHP error, warning, notice or deprecation (display_errors on, E_ALL).
#     Only real PHP messages count ("... in <file> on line <n>") - the word "Warning:" in a translation table does not.
#  3. php2html.api.md must be what tools/make_api_md.php makes now (else: run it).
#  Exit code 0 = all OK, 1 = something to fix.

if (PHP_SAPI !== 'cli') { http_response_code(404);  exit; }
$root= dirname(__DIR__);
chdir($root);
$php=  PHP_BINARY;
$bad=  0;
$t0=   microtime(true);
$say=  function($ok, $text) use (&$bad) { if (!$ok) $bad++;  echo ($ok ? '  ok    ' : '  FAIL  '), $text, "\n"; };

// 1. Lint
echo "1. php -l\n";
$it= new RecursiveIteratorIterator(new RecursiveCallbackFilterIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
     fn($f) => !($f->isDir() && in_array($f->getFilename(), ['.git', 'latest', '_cache', 'vendor', 'node_modules'], true))));
$n= 0;
foreach ($it as $f) {
    if (strtolower($f->getExtension()) !== 'php') continue;
    $n++;
    exec(escapeshellarg($php).' -l '.escapeshellarg($f->getPathname()).' 2>&1', $out, $rc);
    if ($rc !== 0) $say(false, substr($f->getPathname(), strlen($root) + 1).': '.trim(implode(' ', array_slice($out, 0, 2))));
    $out= [];
}
$say(true, "$n files - ".($bad ? 'the rest ' : '').'no syntax errors');

// 2. The pages - through the built-in web server
echo "2. Pages\n";
$gitState= fn() => is_dir('.git') ? (string)shell_exec('git status --porcelain 2>'.(PHP_OS_FAMILY === 'Windows' ? 'NUL' : '/dev/null')) : '';
$before= $gitState();                                           // Some demo pages write files (functions.page.php: Functions.html)
$pages= array_slice($argv, 1);
if (!$pages) foreach (['Proj.demo', 'Quick_Proj', 'world'] as $d) foreach (glob("$d/*.page.php") ?: [] as $p) $pages[]= $p;
$sock= stream_socket_server('tcp://127.0.0.1:0');  $port= (int)substr(strrchr(stream_socket_get_name($sock, false), ':'), 1);  fclose($sock);
$srv= proc_open([$php, '-d', 'display_errors=1', '-d', 'error_reporting='.E_ALL, '-d', 'log_errors=0', '-S', "127.0.0.1:$port", '-t', $root],
                [0 => ['pipe', 'r'], 1 => ['file', $null= (PHP_OS_FAMILY === 'Windows' ? 'NUL' : '/dev/null'), 'w'], 2 => ['file', $null, 'w']], $pipes, $root);
if (!is_resource($srv)) { echo "  FAIL  could not start php -S\n";  exit(1); }
for ($i= 0; $i < 50 && !@fsockopen('127.0.0.1', $port, $e1, $e2, 0.1); $i++) usleep(100000);
$ctx= stream_context_create(['http' => ['ignore_errors' => true, 'timeout' => 30, 'header' => "User-Agent: p2h-check\r\n"]]);
$diag= '~(?:<b>)?(Fatal error|Parse error|Warning|Notice|Deprecated|Recoverable fatal error)(?:</b>)?:\s+(.{1,220}?)\s+in\s+(?:<b>)?([^<\n]+?)(?:</b>)?\s+on\s+line\s+(?:<b>)?(\d+)~is';
foreach ($pages as $p) {
    $p= str_replace('\\', '/', $p);
    $s= microtime(true);
    $html= @file_get_contents("http://127.0.0.1:$port/".implode('/', array_map('rawurlencode', explode('/', $p))), false, $ctx);
    $code= isset($http_response_header[0]) && preg_match('~\s(\d{3})\s~', $http_response_header[0], $m) ? (int)$m[1] : 0;
    $ms= (int)((microtime(true) - $s) * 1000);
    if ($html === false || $code !== 200) { $say(false, "$p - HTTP $code");  continue; }
    if (preg_match_all($diag, $html, $mm, PREG_SET_ORDER)) {
        $list= [];  foreach ($mm as $d) $list[$d[1].': '.trim(strip_tags($d[2])).' ('.basename(trim($d[3])).':'.$d[4].')']= true;
        $say(false, "$p - ".count($mm).' PHP message(s):');
        foreach (array_slice(array_keys($list), 0, 5) as $l) echo '          ', $l, "\n";
    } else $say(true, sprintf('%-40s %5d ms  %4d KB', $p, $ms, strlen($html) / 1024));
}
proc_terminate($srv);  proc_close($srv);
$changed= array_diff(array_filter(explode("
", $gitState())), array_filter(explode("
", $before)));
if ($changed) { echo "  note  the pages wrote these files (check them before a commit):
";  foreach ($changed as $l) echo '          ', trim($l), "
"; }

// 3. The API reference
echo "3. php2html.api.md\n";
$tmp= tempnam(sys_get_temp_dir(), 'p2hapi');
exec(escapeshellarg($php).' '.escapeshellarg('tools/make_api_md.php').' php2html.lib.php '.escapeshellarg($tmp).' 2>&1', $out, $rc);
$norm= fn($s) => str_replace("\r\n", "\n", (string)$s);
$same= $rc === 0 && is_file('php2html.api.md') && $norm(file_get_contents($tmp)) === $norm(file_get_contents('php2html.api.md'));
@unlink($tmp);
$say($same, $same ? 'matches the library' : 'is out of date - run: php tools/make_api_md.php');

printf("\n%s - %d to fix, %.1f s\n", $bad ? 'NOT OK' : 'ALL OK', $bad, microtime(true) - $t0);
exit($bad ? 1 : 0);
