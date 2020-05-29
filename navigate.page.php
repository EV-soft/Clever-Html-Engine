<?php   $DocFil= './Proj1/navigate.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-29';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

htm_PagePrep($pageTitl='navigate.page.php', $ØPageImage='_background.png');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center; background-image: url(\'_background.png\');">';
    
    htm_PanlHead($frmName='', $capt='Navigate functions:', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
                
    echo '<div style="text-align: left; margin: 20px;">
To navigate in a program you can use:<br><br>
TopMenu witch you can see at the top of all demo pages.<br>
You find it in the file: menu.inc.php <br>
and it is called with Menu_Topdropdown() <br><br>
Another button is <b>menuButt()</b> that can be used to link to subpages:<br><br>';
echo '<div style="text-align: center;">';
    menuCapt($h='24',$w='200',$label='Simple menuCaption()');
    htm_nl(0);
    menuButt($h='24',$w='200',$label='MenuButt 1',$link='',$title='MenuButt'); htm_nl(1);
    menuButt($h='24',$w='200',$label='MenuButt 2',$link='',$title='MenuButt');
echo '</div>';
    echo '<br><br>
See also: <b>htm_IconButt()</b> - a general button with icon. <br><br>
</div>';

    htm_PanlFoot();

    echo '</div>';
htm_PageFina();
?>