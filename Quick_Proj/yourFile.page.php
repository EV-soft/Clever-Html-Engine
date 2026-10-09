<?php   $DocFile= './<yourFile>.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= './../';   # System in same folder: './'  # System in parent folder: './../'
$gbl_ProgRoot= './../'; 

## Activate needed libraries: Set 0:deactive  (1:Local-source)  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '0';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');

### PAGE-START:
htm_Page_(titl:'<yourFile>.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'',
          algn:'center', imag:'', pbrd:false);

### Here you put your code...
    echo 'Hello World - Build with Clever HTML engine...';
    
### :PAGE_END
htm_Page_end();

?>