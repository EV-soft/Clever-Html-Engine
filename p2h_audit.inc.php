<?php  $DocFileAudit='../p2h_audit.inc.php';    $DocVerAudit='1.7.8';    $DocRevAudit='2026-10-20';      $DocIni='evs';  ## File informative only
# The activity log (audit log) of a program: who did what, when and from where - from TinyCash.
# Optional: require it after php2html.lib.php. No database: one JSON line per event in a PHP file, that shows nothing in the browser.
#
#   p2h_audit('@Upload', 'photos/a.jpg', '2 MB', $user);      # Write an event - where the program acts
#   htm_AuditLog(capt:'@Activity log', max:500);              # Show the newest events in a card (only to those who may see it - the program decides)
#
#   $gbl_AuditFile= __DIR__.'/my-audit.log.php';              # Before require: the file (default: p2h-audit.log.php next to this file)
#   $gbl_AuditMax=  2000000;                                  # Bytes: a fuller file is renamed to *.old.php (one old file is kept)
#   $gbl_AuditUser= 'name';                                   # The user, when p2h_audit() gets none
#
# The program must check the rights itself - htm_AuditLog() shows the log to anybody who gets to call it.

const P2H_AUDIT_HEAD= "<?php http_response_code(404); exit; ?>\n";    # The first line: the file shows nothing in the browser

function p2h_audit_file() {     # The log file - and the old one (renamed when the file was full)
    $f= (string)($GLOBALS['gbl_AuditFile'] ?? (__DIR__.'/p2h-audit.log.php'));
    return [$f, preg_replace('/(\.php)?$/', '.old.php', $f, 1)];
}

function p2h_audit($acti, $targ= '', $note= '', $user= null) {     # Write one event - true when it was written
    [$f, $old]= p2h_audit_file();
    $user= $user ?? ($GLOBALS['gbl_AuditUser'] ?? '');
    $clip= fn($v, $n) => mb_substr(preg_replace('/[\x00-\x1F\x7F]+/u', ' ', (string)$v) ?? '', 0, $n);  # One line, not too long
    $line= json_encode(['t' => date('c'), 'u' => $clip($user, 64), 'ip' => $clip($_SERVER['REMOTE_ADDR'] ?? 'cli', 45),
                        'a' => $clip($acti, 80), 'o' => $clip($targ, 400), 'n' => $clip($note, 400)],
                       JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    if ($line === false) return false;
    $h= @fopen($f, 'c+');                                   # Locked while it is checked and written: two requests never mix their lines
    if (!$h) return false;
    flock($h, LOCK_EX);
    clearstatcache(true, $f);
    $size= filesize($f);
    if ($size >= (int)($GLOBALS['gbl_AuditMax'] ?? 2000000)) {     # Full: the old file is replaced by this one, and it starts again
        if (@copy($f, $old)) { ftruncate($h, 0);  $size= 0; }
    }
    if ($size === 0) { fwrite($h, P2H_AUDIT_HEAD);  @chmod($f, 0640); }
    fseek($h, 0, SEEK_END);
    $ok= fwrite($h, $line."\n") !== false;
    fflush($h);  flock($h, LOCK_UN);  fclose($h);
    return $ok;
}

function p2h_audit_read($max= 500) {        # The newest events first: [['t'=>, 'u'=>, 'ip'=>, 'a'=>, 'o'=>, 'n'=>], ...] - also from the old file
    $rows= [];
    foreach (p2h_audit_file() as $f) {
        if (count($rows) >= $max || !is_file($f)) continue;
        $lines= @file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        for ($i= count($lines) - 1; $i >= 0 && count($rows) < $max; $i--) {
            $r= json_decode($lines[$i], true);
            if (is_array($r) && isset($r['t'], $r['a'])) $rows[]= $r;     # (the first line is not JSON)
        }
    }
    return $rows;
}

function htm_AuditLog(# capt:'@Activity log', icon:'fa-solid fa-clipboard-list', hint:'', max:500, wdth:'98%', vhgh:'400px', rtrn:false)
    $capt= '@Activity log',             # string: The caption of the card ('' : no card - only the table)
    $icon= 'fa-solid fa-clipboard-list',# string: The icon of the card
    $hint= '',                          # string: The hint of the card
    $max=  500,                         # int:    The newest events shown
    $wdth= '98%',                       # string: The width of the table
    $vhgh= '400px',                     # string: The height of the scrolling window with the rows
    $rtrn= false                        # bool:   Return the HTML instead of echoing it
) {
    if ($rtrn) ob_start();
    $data= array_map(fn($r) => [($ts= strtotime((string)$r['t'])) ? date('Y-m-d H:i:s', $ts) : (string)$r['t'],       # In the time zone of the program
                                $r['u'] ?? '', $r['ip'] ?? '',
                                lang((string)$r['a']), $r['o'] ?? '', $r['n'] ?? ''], p2h_audit_read((int)$max));
    if ($capt > '') htm_Card_(capt: $capt, icon: $icon, hint: $hint, clas: 'cardWmax');
    if (!$data) echo '<p>'.sys_enc(lang('@No events yet')).'</p>';
    else htm_Table(body: [['@Time', '18%', 'show', '', ['left'], 'time'], ['@User', '10%', 'show', '', ['left'], 'user'],
                          ['@Address', '11%', 'show', '', ['left'], 'ip'], ['@Action', '14%', 'show', '', ['left'], 'acti'],
                          ['@Object', '27%', 'show', '', ['left'], 'objt'], ['@Note', '20%', 'show', '', ['left'], 'note']],
                   data: $data, wdth: $wdth, vhgh: $vhgh, crea: false, modi: false,
                   note: '<small>'.sys_enc(lang('@The newest first')).' - '.count($data).' '.sys_enc(lang('@events')).'</small>');
    if ($capt > '') htm_Card_end();
    if ($rtrn) return ob_get_clean();
}
