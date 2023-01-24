<?php   $DocFil= './Proj.demo/files.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-18';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [2, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);               // jquery.min.js
define('LIB_JQUERYUI',      [2, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [2, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/
/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [2, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN

htm_Page_0($titl='files.page.php',$hint='',$info='',$inis='',$algn='center', $gbl_Imag=$gbl_ProgRoot.'_accessories/_background.png',$gbl_Bord=false);
    Menu_Topdropdown(true); htm_nl(1);
    htm_Panel_0($capt='System-files', $icon='fas fa-file',$hint= '',$form= 'head', $acti= '',$clas='panelW640', $wdth= '',$styl= 'background-color: white;',$attr= '');
    htm_nl(1);

    htm_TextPre('The PHP2HTML-system uses this file naming system:      <br>
        NAME.KIND.TYP                <br>
         |    |    |                 <br>
         |    |    └─► File type: pdf/txt/json/png/php/...  <br>
         |    └──────► Content kind: <i>lib</i>/<i>inc</i><i>/min</i>/css/<b>page</b>/dat/...  <br>
         └───────────► File name: descriptive word     <br>
                                    <br>
    ','left',$marg='8px',$attr='line-height: 0.6;');
    
    htm_TextPre('For now there are the following files:
       _assets              (folder: support libraries) 
       _background.png      Image used as background in panels etc.
       _trans.sys.json      Data-file with translations
       php2html.<i>lib</i>.php     The main library
       menu.<i>inc</i>.php         Include regarding the system menu
       translate.<i>inc</i>.php    Include library regarding the translate system

       Demo.<b>page</b>.php        Intro...
       files.<b>page</b>.php       Intro...
       input.<b>page</b>.php       Intro...
       navigate.<b>page</b>.php    Intro...
       pages.<b>page</b>.php       Intro...
       panel.<b>page</b>.php       Intro...
       table.<b>page</b>.php       Intro...
       translate.<b>page</b>.php   Intro...
       And more...<br>','left',$marg='8px',$attr='line-height: 1.4;');
       
    //htm_TextTip($capt='TIP',$body='Body tekst',$width='150px',$colr='yellow');
    htm_Panel_00();

    //Menu_Bottom();  

htm_Page_00();
?>