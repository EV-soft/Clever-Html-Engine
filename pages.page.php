<?php   $DocFil= './Proj1/pages.page.php';    $DocVer='1.0.0';    $DocRev='2020-06-14';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }

htm_PagePrep($pageTitl='pages.page.php', $ØPageImage='_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);
    
    htm_RowColTop($RowColWdth=480);
    htm_PanlHead($frmName='', $capt='About creating pages:', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');

    htm_TextDiv('To build a page there are 2 functions: <br><br>
        <b>htm_PagePrep()</b> - prepares the start of a page, by creating the HEAD content and starting the BODY section.<br>
        <br>and: <br>
        <b>htm_PageFina()</b> - finalize the page, by loading scripts and ending the BODY     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>');

    htm_PanlFoot();
    
    htm_RowColNext($RowColWdth=480);

    htm_PanlHead($frmName='', $capt='Layout wrapping (RowCols):', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
                
    htm_TextDiv('To automatic adapting layout to screens (windows) with various width, you can use the functions: <br><br>
        <b>htm_RowColTop()</b> - prepares the start of a RowCol.<br>
        <br>and: <br>

        <b>htm_RowColBott()</b> - finalize the RowCol <br><br>
        In between, you call <b>htm_RowColNext()</b>, to prepare an eventual RowCol-break. <br><br>
        <small>REMARK: <br>Output appears as a row if there is enough space. <br>Otherwise wrap to column layout<br></small>');

    htm_PanlFoot();
    htm_RowColBott();

htm_PageFina();
?>