<?php   $DocFil= './Proj1/translate.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-23';     $DocIni='evs';  $ModulNr=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

htm_PagePrep($pageTitl='translate.page.php', $ØPageImage='_background.png');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center; background-image: url(\'_background.png\');">';
    
    htm_PanlHead($frmName='', $capt='Translate system:', $parms='', $icon='fas fa-info', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
                
    echo '<div style="text-align: left; margin: 20px;">
    All english textstrings that should be translated, MUST have prefix \'@ <br>
    in the source. It will be translated with function lang(\'@English text\') <br><br>
    To create the table with strings to translate a function will scann all the
    source after prefix: <b>lang(\'</b>  .. and with suffix: <b>\')</b><br>
    Other prefix: <b>msg(\'</b>    (See more in file translate.inc.php)<br><br>
    The string with the @-prefix, is used as a lookup-key. <br><br>
    All translated languages is defined in file: .sys_trans.json <br>
    If there are no translation, the english text will output with prefix @ removed

<br><br>

</div>';

    htm_PanlFoot();

    echo '</div>';
htm_PageFina();
?>