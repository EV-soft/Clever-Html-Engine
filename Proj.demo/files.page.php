<?php   $DocFil= './Proj.demo/files.page.php';    $DocVer='1.4.0';    $DocRev='2024-06-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';
 
$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');

htm_Page_(titl:'files.page.php', hint:'', info:'', inis:'', algn:'center', imag:$gbl_ProgRoot.'_accessories/_background.png', pbrd:false);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    htm_Card_(capt:'Naming System-files', icon:'fas fa-file',hint: '',form: 'head', acti: '',clas:'cardW640', wdth: '',styl: 'background-color: white;',attr: '');
    htm_nl(1);

    htm_TextPre('The PHP2HTML-system uses this file naming system:      <br>
        NAME.KIND.TYP                <br>
         |    |    |                 <br>
         |    |    └─► File type: pdf/txt/json/png/php/...  <br>
         |    └──────► Content kind: <i>lib</i>/<i>inc</i><i>/min</i>/<i>css</i>/<i>page</i>/<i>dat</i>/...  <br>
         └───────────► File name: descriptive word     <br>
                                    <br>
    ','left',$marg='8px',$attr='line-height: 0.6;');
    
    htm_TextPre('For now there are the following files:
       _assets              (folder: support libraries) 
       _background.png      Image used as background in cards etc.
       _trans.sys.json      Data-file with translations
       php2html.<i>lib</i>.php     The main library
       menu.<i>inc</i>.php         Include regarding the system menu
       translate.<i>inc</i>.php    Include library regarding the translate system

       Demo.<b>page</b>.php        Intro...
       files.<b>page</b>.php       Intro...
       input.<b>page</b>.php       Intro...
       navigate.<b>page</b>.php    Intro...
       pages.<b>page</b>.php       Intro...
       card.<b>page</b>.php        Intro...
       table.<b>page</b>.php       Intro...
       translate.<b>page</b>.php   Intro...
       And more...<br>','left',$marg='8px',$attr='line-height: 1.4;');
       
    htm_Card_end();

htm_Page_end();
?>