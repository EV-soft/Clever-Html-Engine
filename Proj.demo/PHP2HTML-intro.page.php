<?php   $DocFile= './Proj.demo/PHP2HTML-intro.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-18';      $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [2, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);               // query.min.js
define('LIB_JQUERYUI',      [2, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [2, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_POLYFILL',      [0, '_assets/',  ' Not in use ']);      
define('LIB_POPSCRIPTS',    [0, '_assets/',  ' Not in use ']);      
define('LIB_FONTAWESOME',   [2, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
define('LIB_TINYMCE',       [0, '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/tinymce.min.js']); 
define('LIB_SWITCHBOX',     [0, '_assets/',  ' Not in use ']);
define('LIB_POPUPSYSTEM',   [0, '_assets/',  ' Not in use ']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


htm_Page_0($titl='PHP2HTML - Introduction to the systems most used modules:',$hint=$©,$info='File: '.$DocFile.' - Ver:'.$DocVer, $inis='',$algn='center', $gbl_Imag='', $gbl_Bord=false);
    Menu_Topdropdown(true); htm_nl(1);
//    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">';
    htm_RowCol_0($RowColWdth=1100);
    
    htm_TextDiv(body:'
            <p style="margin: 10px; text-align: center; line-height: 1.2;"><span style="font-size: 18pt;"><strong>Clever html engine</strong></span></p>
            <p style="margin: 10px; text-align: center; line-height: 1.2;"><strong>Procedural block-structured programming with the PHP2HTML</strong></p>
            <p style="margin: 10px; text-align: center; line-height: 1;"><strong>&nbsp;library gives you easy central maintenance of your code.</strong></p>
            <p>&nbsp;</p>
            <p style="margin: 12px;" >The PHP2HTML library can be used in PHP applications to produce HTML code with advanced features.</p>
            <p style="margin: 12px;" >Library consists of a collection of functions that produce both standard HTML elements and special variants.</p>
            <p style="margin: 12px;" >All modules are integrated with a language translation system, which allows the user to exchange all program texts into many different languages.</p>
            <p style="margin: 12px;" >Likewise, popup user hints (tip/title) are consistently possible for all labels, etc. They are made visible by hovering the mouse over the element.</p>
            <br>
            ', algn:'justify', marg:'12px;padding:12px', styl:' font-weight: 500; color: #000000; border-radius: 25px; width:700px; margin: auto; background-color: white;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
    echo '<br>';

    htm_Panel_0(capt:'@Benefits:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv(body:'
<table style="border-collapse: collapse; width: 100%; height: 278.125px;" border="0"><colgroup><col style="width: 24%;"><col style="width: 77%;"></colgroup>
<tbody>
<tr>
<td style="height: 26.125px; text-align: center;" colspan="2"><span style="font-size: 14pt;"><strong>Integrated advantages of the system:</strong></span></td>
</tr>
<tr style="height: 42px;">
<td style="height: 42px;"><strong>Translation</strong></td>
<td style="height: 42px;">Advanced translation system for the entire program interface</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Icons </strong></td>
<td style="height: 21px;">Option for font-awesome icons anywhere</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>User Advice </strong></td>
<td style="height: 21px;">Tooltip and placeholder for all html elements</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Panels </strong></td>
<td style="height: 21px;">Compact adaptive layout with collapsible panels</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Tables </strong></td>
<td style="height: 21px;">Advanced tables based on Mottie Table Sorter system</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>HTML editor</strong></td>
<td style="height: 21px;">TinyMCE integrated library</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Library Location</strong></td>
<td style="height: 21px;">Optional use of libraries locally or on the web (CDN)</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Adaptive </strong></td>
<td style="height: 21px;">Narrow panels suitable for adaptive fit</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Date Lookup</strong></td>
<td style="height: 21px;">Easily enter dates with the browser\'s date picker interface</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Validation</strong></td>
<td style="height: 21px;">Checks browser input validation</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>PHP 8.2</strong></td>
<td style="height: 21px;">Compatible with latest PHP</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Block oriented</strong></td>
<td style="height: 21px;">Provides compact and clearer code...</td>
</tr>
</tbody>
</table>
<p style="text-align:center;"><i>Don\'t reinvent the Wheel, use PHP2HTML…</i></p>
		',marg:'8px;padding:10px');
	htm_Panel_00();

    htm_Panel_0(capt: '@<small>System - </small>CODE EXAMPLE:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('@Here is an example of how the system generates html code.<br><i>This compact height level code:</i>');
        $strCode= '<? // PHP code:
htm_Input(type:\'dec2\',   name:\'dec2\', valu:0,
          labl:\'@Amount\',wdth:\'150px\',algn:\'center\',unit:\'<$ \'
          hint:\'@Demo of htm_Input Field Type dec2: number with 2 decimal <br>Unit: <$\');
 ';
        // esc_code();
        $strCode= highlight_string($strCode,true);
        // esc_code();
        htm_CodeDiv(highlight_words($strCode));
        htm_TextDiv('@w<i>ill produce css-data and this html code:</i>');
$strCode= highlight_string('<? // HTML code:
<div class="inpField" id="inpBox" style="margin: auto;  width: 150px; display: inline-block;"> 
    <input type= "text"  id="dec2" name="dec2"  value="$ 0,00"  class="boxStyle" 
        style="text-align: center; font-size: 14px; font-weight: 600; " 
        oninvalid="this.setCustomValidity(\'Wrong or missing data in htm_Input(Dec2) ! \')" 
        oninput="setCustomValidity(\'\')"  
        placeholder="Enter..."  
        pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" 
    /> 
    <abbr class= "hint">
        <label for="dec2" style="font-size: 12px; ">
            <div style="white-space: nowrap; margin-left: auto;">
                Amount
            </div>
        </label>
        <data-hint style="top: 45px; left: 2px;">
            Demo of htm_Input Field Type dec2: number with 2 decimal <br>Unit: <$ 
        </data-hint>
    </abbr>
</div>

',true);
// arrPretty($strCode,'$strCode');
// arrPretty(preg_replace('/^<\?(.*)(\>)?$/s', '$1',$strCode),'$strCode'); // str_replace()  preg_replace("/<\?/", 'xxx',$strCode),'$strCode')  // 
        htm_CodeDiv((preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "",$strCode)));
        htm_TextDiv('@<i>And here are the output:</i>');
        htm_Input(type:'dec2',name:'dec2',valu:'$dec2', labl:'@Amount',hint:'@Demo of htm_Input Field type dec2: number with 2 decimal',wdth:'150px',algn:'center',unit:'<$ ');
        htm_TextDiv('@and it will have all the properties: <br> placeholder, validation, hint, colors, dimensions and much more...<br><br>
                    As you can see, the source code is very compact. Less than 1/5 !
                    <br>');
    htm_Panel_00();

    htm_nl(1);
    htm_Caption('<big>PHP2HTML - Introduction to the systems most used modules:</big>',$style='',$align='',$hint='@Example of user popup help/info'); 
    htm_nl(1);
    htm_Panel_0(capt:'@<small>Layout - </small>PAGE:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('A page is a browser window with html objects.<br>
            It is build with two functions: htm_Page_0() and htm_Page_00()<br>
            Here are the page title, the window background and content align setup.<br>
            All the needed preparing (calling libraries) is done here.<br>
            Example: htm_Page_0(<abbr class= "hint"><data-hint>htm_Page_0($titl=\'\',$hint=\'\',$info=\'\',$inis=\'\',$algn=\'center\', $gbl_Imag=\'\',$gbl_Bord=true);</data-hint>Parameters</abbr>) and htm_Page_00()<br>
            <small><small>Mouse-over "Paremeters" shows hint !</small></small>
		');
	htm_Panel_00();

    htm_Panel_0(capt:'@<small>System - </small>PANELS:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Panels is a container for html-objects.<br>
            It is build with two functions: htm_Panel_0() and htm_Panel_00()<br>
            It consists of: icon + header - a body with content - and a footer that can be hidden.<br>
            The header-caption is automatic translated to the current selected language.<br>
            When clicking the caption-text in the header, it will show/hide the body&footer-content.<br>
            In the headers right side there are icons to open/close all the panels in the window.<br>
            Panels has predefined widths, and its position will swap, if the window-width is to small.<br>
            Panels can be used as a "Local Menu" and to keep overview...<br>
            Example: htm_Panel_0(<abbr class= "hint">
            <data-hint> htm_Panel_0('. highlight_words(
                "capt:'@<small>System - </small>PANELS:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:''").
            '</data-hint>
            Parameters</abbr>) and htm_Panel_00(<abbr class= "hint">
            <data-hint>htm_Panel_00('. highlight_words(
                "labl:'@Save', icon:'', hint:'', name:'', form:'', subm:true, attr:'', akey:'', kind:'save', simu:false)").
            '</data-hint>
            Parameters</abbr>)
		');
	htm_Panel_00();

    htm_Panel_0(capt:'@<small>System - </small>LAYOUT:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('If you will not let panels fill the window-width, you can use the functions: htm_RowColxxx() to create a column layout.<br> 
            Example: htm_RowCol_0(<abbr class= "hint"><data-hint>htm_RowCol_0 ($wdth=240)</data-hint>Parameters</abbr>) and htm_RowCol_next(<abbr class= "hint"><data-hint>htm_RowCol_next($wdth=320)</data-hint>Parameters</abbr>) and htm_RowCol_00()
		');
	htm_Panel_00();

    htm_Panel_0(capt:'@<small>System - </small>INPUT:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Input fields is the interface to interact with the users data of varies type.<br>
            It is build with function htm_Input()<br>
            It contains a Frame, - a Label - and a Data-field<br>
            <small>The Label:</small> is a translated caption for the field. When howering a translated hint will be shown.<br>
            <small>The Data-field:</small> If NULL data, a translated placeholder is shown.<br>
            <small>The Frame:</small> can be colored to signale special conditions.<br>
            At this time there are 25 htm_Input() types: \'intg\', \'text\', \'dec0\', \'dec1\', \'dec2\', \'num0\', \'num1\', \'num2\', \'num3\', \'barc\', \'mail\', \'link\', \'sear\', \'file\', \'imag\', \'date\', \'time\', \'week\', \'mont\', \'rang\', \'butt\', \'colr\', \'phon\', \'pass\', \'area\'<br>
            Example: htm_Input(<abbr class= "hint"><data-hint>htm_Input($type=\'text\', $name=\'deliphon\', $valu= $arrDeliver[$name], $labl=\'@Phone\', $hint=\'@Enter Recipient`s Phone\', $plho=\'@Phone...\');</data-hint>Parameters</abbr>)
		');
	htm_Panel_00();

    htm_Panel_0(capt:'@<small>System - </small>TABLE:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('The function htm_Table() is a advanced module to show and input user data.<br>
            It has fixed (sticky) column headers, and Scrolling content-window.<br>
            Column wise it can: Filter - Sort - Width-Resize<br>
            Row wise it can: Create - Change - Delete - Spec. Buttons - set background color<br>
            Above and underneth the table, you can use special captions and notes.<br>
            Example: htm_Table(<abbr class= "hint"><data-hint>htm_Table($TblCapt, $RowPref, $RowBody, $RowSuff, $TblNote, &$TblData, $FilterOn, $SorterOn, $CreateRec, $ModifyRec, $ViewHeight, $TblStyle, $CalledFrom, $MultiList)</data-hint>Parameters</abbr>)
		');
	htm_Panel_00();

    htm_Panel_0(capt:'@<small>System - </small>SPECIAL:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('In addition to standard html features, there are a number of specialized features: <br>
            Examples: <br>
            htm_MultistateButt(); - A button with 3 or more states<br>
            htm_Dialog(); - A system with messages to the user.<br>
            Pmnu_0(); / Pmnu_00(); - A context popup menu system.<br>
            
            <br>
		');
	htm_Panel_00();

      htm_Panel_0(capt:'@<small>System - </small>NAMING rules:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Rules for Naming Files:<br>
            <i>{file-name}.{content-type}.{file-type}</i><br><br>
            {file-names}: settings index <br>
            {content-types}: .page .inc .lib .min .css .js <small>(the secundary type)</small><br>
            {file-types}: .png .php .htm .txt .json <small>(the primary type)</small><br><br>
            Example: <b>intropage.css.php</b><br>
            <br>
            <br>
            Rules for Naming Funktions:<br>
            Block-start: {name}_0<br>
            Block-end: {name}_00<br>
            {name} could be htm_page / htm_panel<br>
            <br>
		');
	htm_Panel_00();

    htm_Panel_0(capt:'@<small>System - </small>NOTES:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'panelW720', wdth:'', styl:'background-color: white;', attr:'' /* ,$where='Undefined',$BookMark='' */ );
		htm_TextDiv('Click on the panels caption to show/hide the content<br>
                     The \'@\'-prefix in strings indicates that it is a translatable text.<br>
                     This introduction is created with the PHP2HTML-system.<br>
		');  
	htm_Panel_00();
    
    htm_RowCol_00();
    PanelOff($First=3,$Last=9);

htm_Page_00();

?>