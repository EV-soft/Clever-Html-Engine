<?php   $DocFile= './Proj.demo/pages.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../'; 

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }

htm_Page_(titl:'pages.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer,inis:'', algn:'center', imag:'../_accessories/_background.png', pbrd:true);
    // Menu_Topdropdown(true); htm_nl(1);
    
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    
    htm_RowCol_($RowColWdth=480);
    htm_Card_(capt:'Creating pages:', icon: 'fas fa-info', hint:'', form:'', acti:'', clas:'cardW480', wdth:'', styl:'background-color: white;', attr: '');

    htm_TextDiv('You build a page with 2 functions: <br><br>
        <b>htm_Page_()</b> - prepares the start of a page, by <br>
        creating the HEAD content and starting the BODY section.<br>
        <br>and: <br>
        <b>htm_Page_end()</b> - finalize the page, by loading scripts <br>
        and ending the BODY     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>');

        htm_Card_(capt:'@PHP Source-code:', icon:'fas fa-code', hint:'', form:'', acti:'', clas:'cardW480', wdth:'',styl:'background-color: white;', attr:'margin:0;');

$strCode= 
/* str_Pars(  */
<<< 'STRING'
// PHP7-syntax:
htm_Page_($pageTitl='pages.page.php',
           $ØPageImage=$gbl_ProgRoot.'_assets/images/_background.png',
           $align='center'); 
           // htm_Page_() must be followed by htm_Page_end() !

echo 'You place your page-content here...<br>';

htm_Page_end();
STRING
; 
        htm_CodeBox($strCode);
        htm_Card_end();

    htm_Card_end();
    
    htm_RowCol_next($RowColWdth=480);

    htm_Card_(capt:'@Layout wrapping (RowCols):', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW480', wdth:'', styl:'background-color: white;', attr:'');

    htm_TextDiv('To automatic adapting layout to screens (windows) with <br>
        various width, you can use the functions: <br><br>
        <b>htm_RowCol_()</b> - prepares the start of a RowCol.<br>
        <br>and: <br>

        <b>htm_RowCol_end()</b> - finalize the RowCol <br><br>
        In between, you call <b>htm_RowCol_next()</b>, to <br>
        prepare an eventual RowCol-break. <br><br>
        <small>REMARK: <br>Output appears as a row if there is enough space.<br>
        Otherwise wrap to column layout<br></small>');

    htm_Card_end();
    htm_RowCol_end();
    CardOff($First=2,$Last=2);
htm_Page_end();
?>