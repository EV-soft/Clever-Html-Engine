<?php   $DocFil= './Proj1/support.page.php';    $DocVer='5.0.0';    $DocRev='2020-06-03';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

htm_PagePrep($pageTitl='support.page.php', $ØPageImage='_background.png');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center;">';
    htm_PanlHead($frmName='head', $capt='Support-files', $parms='', $icon='fas fa-file', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php');
    htm_nl(1);
    echo '<pre style="text-align: left;">
    The system relies on some external libraries,       <br>
    all of which are placed in a subfolder: <b>_assets</b>     <br>
    In there are currently following sub-folders:         <br>
    _assets:            - libraries  <br>
        css             - CSS styles  <br>
        font-awesome5   - Icon system  <br>
        fonts           - Special fonts  <br>
        icons           - System icons   <br>
        images          - System images  <br>
        jquery          - Base Java scripts  <br>
        tablesorter     - Mottie table-libraries  <br>
        </pre>';
    htm_nl(0);
    htm_PanlFoot( $labl='Demo', $subm=false, $title='Buttom', $buttonKind='', $akey='', $simu=false, $frmName='');
    echo '</div>';

htm_PageFina();
?>