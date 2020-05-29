<?php   $DocFil= './Proj1/other.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-29';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

htm_PagePrep($pageTitl='other.page.php', $ØPageImage='_background.png');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center; background-image: url(\'_background.png\');">';
    
    htm_PanlHead($frmName='', $capt='Other htm_functions:', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
                
    echo '<div style="text-align: left; margin: 20px;">
There are a lot of small functions that could be mentiond here.
e.g. htm_AcceptButt()

<br><br>
<b>htm_AcceptButt()</b> - a programmeble button. You give: <br>
$labl           - The caption on the button               <br>
$title          - The description about actual function   <br>
$btnKind        - The kind gives the color                <br>
$form           - The form name on witch it could submit  <br>
$width          - Width of the button                     <br>
$akey           - Shortcut key                            <br>
$proc=false,    - Act as a procedure or a function        <br>
$tipplc         - Placement of the popup tip              <br><br>

<b>htm_IconButt()</b> - a general button with icon. <br><br>

A special group of functions:                             <br>
<b>dvl_</b> functions - relates to development (tools and design) <br>

</div>';

    htm_PanlFoot();

    echo '</div>';
htm_PageFina();
?>