<?php   $DocFile='./world/first.page.php';    $DocVer='1.5.0';    $DocRev='2026-10-09';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** See the file: LICENSE';

#   Getting started:
#   How to output your first page...

$sys= $GLOBALS["gbl_ProgRoot"]= '../';     // a system variable: path to the system folder

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '0';
$needTablesorter= '0';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');    // the system library

### PAGE-START:
htm_Page_(titl:'@DEMO', hint:'', info:lang('@PHP2HTML: My first page'), inis:'',
          algn:'center', imag:'../_accessories/_background.png', pbrd:false);

    htm_Caption(labl:'@HELLO WORLD:', icon:'fa-solid fa-earth-europe', hint:'@This is your first page', algn:'center',
                styl:'color:#550000; font-weight:600; font-size: 18px;');

    htm_Card_(capt:'@My first card', icon:'fa-solid fa-star', clas:'cardW480');
        htm_Input(labl:'@Your name', plho:'@Enter...', hint:'@Type your name', vrnt:'text', name:'yourName', valu:'');
        htm_Input(labl:'@Price', hint:'@Enter amount with 2 decimals', vrnt:'dec2', name:'price', valu:123.45, unit:'<$ ');
    htm_Card_end();

### :PAGE_END
htm_Page_end();
