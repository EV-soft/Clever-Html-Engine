<?php   $DocFil= './Proj1/pages.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-29';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }

htm_PagePrep($pageTitl='pages.page.php', $ØPageImage='_background.png');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center; background-image: url(\'_background.png\');">';
    
    htm_PanlHead($frmName='', $capt='About creating pages:', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
                
    echo '<div style="text-align: left; margin: 20px;">
To build a page there are 2 functions: <br><br>
<b>htm_PagePrep()</b> - prepares the start of a page, by creating the HEAD content and starting the BODY section.<br>
and: <br>
<b>htm_PageFina()</b> - finalize the page, by loading scripts and ending the BODY     <br><br>
In between, you add your content.             <br><br>
<small>See the source in php2html.lib.php to manage the function parameters.</small>
</div>';

    htm_PanlFoot();

    echo '</div>';
htm_PageFina();
?>