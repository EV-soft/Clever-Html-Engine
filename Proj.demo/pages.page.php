<?php   $DocFile= './Proj.demo/pages.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-18';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                            CDN-path:                                                               // File:
define('LIB_JQUERY',        [2, '_assets/jquery/latest/',               'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);               // jquery.min.js
define('LIB_JQUERYUI',      [2, '_assets/jquery-ui/latest/',            'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [2, '_assets/tablesortjquery-uier/latest/', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [0, '_assets/',  '']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }

htm_Page_0( $titl='pages.page.php',$hint=$©,$info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=true);

    Menu_Topdropdown(true); htm_nl(1);
    
    htm_RowCol_0($RowColWdth=480);
    htm_Panel_0($capt= 'About creating pages:',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '');

    htm_TextDiv('To build a page there are 2 functions: <br><br>
        <b>htm_Page_0()</b> - prepares the start of a page, by creating the HEAD content and starting the BODY section.<br>
        <br>and: <br>
        <b>htm_Page_00()</b> - finalize the page, by loading scripts and ending the BODY     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>');

    htm_Panel_0($capt= '@PHP Source-code:',$icon= 'fas fa-code',$hint= '',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: lightgray;',$attr= 'margin:0;');

$strCode= 
/* str_Pars(  */
<<< 'STRING'
<? // PHP7-syntax:
htm_Page_0($pageTitl='pages.page.php',
           $ØPageImage=$gbl_ProgRoot.'_assets/images/_background.png',
           $align='center'); 
           // htm_Page_0() must be followed by htm_Page_00() !

echo 'You place your page-content here...<br>';

htm_Page_00();
STRING
; 
        $strCode= highlight_string($strCode,true);
        
        $strCode= highlight_words($strCode,  // See: customLib.inc.php
                            $wrds=' labl capt body plho icon hint type name valu form subm acti clas wdth algn marg styl attr font colr fclr bclr bord llgn link targ akey kind rept rtrn', 
                            $styl='color:cyan;');
        $strCode= highlight_words($strCode,  // See: customLib.inc.php
                            $wrds=' htm_Table  htm_ htm_Panel_0 htm_Panel_00 htm_Fieldset_0 ', 
                            $styl='color:white;',
                            $patt='^htm_([A-z]+)\b^');
        htm_CodeDiv($strCode);
    htm_Panel_00();

    htm_Panel_00();
    
    htm_RowCol_next($RowColWdth=480);

    htm_Panel_0($capt= '@Layout wrapping (RowCols):',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '');

    htm_TextDiv('To automatic adapting layout to screens (windows) with various width, you can use the functions: <br><br>
        <b>htm_RowCol_0()</b> - prepares the start of a RowCol.<br>
        <br>and: <br>

        <b>htm_RowCol_00()</b> - finalize the RowCol <br><br>
        In between, you call <b>htm_RowCol_next()</b>, to prepare an eventual RowCol-break. <br><br>
        <small>REMARK: <br>Output appears as a row if there is enough space. <br>Otherwise wrap to column layout<br></small>');

    htm_Panel_00();
    htm_RowCol_00();
    PanelOff($First=2,$Last=2);
htm_Page_00();
?>