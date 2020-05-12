<?php   $DocFil= './Proj1/pages.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-12';     $DocIni='evs';  $ModulNr=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }

htm_PagePrep('pages.page.php');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center;">';
    
    echo 'About creating pages:';  htm_nl(2);

    echo '</div>';
htm_PageFina();
?>