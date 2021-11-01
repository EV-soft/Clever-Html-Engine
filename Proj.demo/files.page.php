<?php   $DocFil= './Proj1/demoFile/files.page.php';    $DocVer='1.0.0';    $DocRev='2020-07-19';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

htm_PagePrep($pageTitl='files.page.php', $ØPageImage=$ØProgRoot.'_assets/images/_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);
    htm_PanlHead($frmName='head', $capt='System-files', $parms='', $icon='fas fa-file', $class='panelW640', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php');
    htm_nl(1);

    htm_TextPre('The PHP2HTML-system uses this file naming system:      <br>
        NAME.KIND.TYP                <br>
         |    |    |                 <br>
         |    |    └─► File type: pdf/txt/json/png/php/...  <br>
         |    └──────► Content kind: <i>lib</i>/<i>inc</i><i>/min</i>/css/<b>page</b>/dat/...  <br>
         └───────────► File name: descriptive word     <br>
                                    <br>
    ','left',$marg='8px',$more='line-height: 0.6;');
    
    htm_TextPre('For now there are the following files:
       _assets              (folder: support libraries) 
       _background.png      Image used as background in panels etc.
       .sys_trans.json      Data-file with translations
       php2html.<i>lib</i>.php     The main library
       menu.<i>inc</i>.php         Include regarding the system menu
       translate.<i>inc</i>.php    Include library regarding the translate system
       blindAlley.<b>page</b>.php  Error page
       Demo.<b>page</b>.php        Intro...
       files.<b>page</b>.php       Intro...
       input.<b>page</b>.php       Intro...
       navigate.<b>page</b>.php    Intro...
       pages.<b>page</b>.php       Intro...
       panel.<b>page</b>.php       Intro...
       table.<b>page</b>.php       Intro...
       translate.<b>page</b>.php   Intro...
       And more...<br>','left',$marg='8px',$more='line-height: 1.4;');
       
    //htm_TextTip($capt='TIP',$body='Body tekst',$width='150px',$colr='yellow');
    htm_PanlFoot();

    //Menu_Bottom();  

htm_PageFina();
?>