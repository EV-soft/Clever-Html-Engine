<?php   $DocFil= './PHP2HTML-intro.page.php';    $DocVer='1.1.0';    $DocRev='2021-11-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');

htm_Page_0($pageTitl='PHP2HTML - Introduction to the systems most used modules:', $ØPageImage=$ØProgRoot.'_accessories/_background.png',$align='center',$PgInfo=lang('@Introduction: PHP2HTML'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
    Menu_Topdropdown(true); htm_nl(1);
//    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">';
    htm_RowColTop($RowColWdth=1100);
    
    htm_TextDiv('<big><big>Clever-Html-Engine</big></big><br>
            Procedural block structured programming with the library PHP2HTML,<br> 
            gives you easy central maintenance of your code<br><br>
            The PHP2HTML library can be used in PHP applications to produce HTML code with advanced features.<br>
            It consists of a collection of features that produce both standard HTML elements and special variants.<br><br>
            All modules are integrated with a language translate system,<br>
            which allows the user to replace all program texts into many different languages.<br><br>
            Likewise, popup user tips (hints/title) are consistently possible for all labels etc. <br>
            They are made visible by hovering the mouse. <br>
            ',$align='left',$marg='8px',$attr='font-weight: 600; text-align: center; color: darkblue;');
    htm_nl(2);
    htm_Caption('<big>PHP2HTML - Introduction to the systems most used modules:</big>',$style='',$align='',$hint='@Example of user popup help/info'); 

	htm_Panel_0($frmName='', $capt='@<small>Layout - </small>PAGE:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('A page is a browser window with html objects.<br>
            It is build with two functions: htm_Page_0() and htm_Page_00()<br>
            Here are the page title, the window background and content align setup.<br>
            All the needed preparing (calling libraries) is done here.<br>
            Example: htm_Page_0(<abbr class= "hint"><data-hint>htm_Page_0($pageTitl=\'\', $ØPageImage=\'\',$align=\'center\', $PgInfo=\'\', $PgHint=\'\')</data-hint>Parameters</abbr>) and htm_Page_00()<br>
            <small><small>Mouse-over "Paremeters" shows hint !</small></small>
		');
	htm_Panel_00();

	htm_Panel_0($frmName='', $capt='@<small>Layout - </small>PANELS:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('Panels is a container for html-objects.<br>
            It is build with two functions: htm_Panel_0() and htm_Panel_00()<br>
            It consists of: icon + header - a body with content - and a footer that can be hidden.<br>
            The header-caption is automatic translated to the current selected language.<br>
            When clicking the caption-text in the header, it will show/hide the body&footer-content.<br>
            In the headers right side there are icons to open/close all the panels in the window.<br>
            Panels has predefined widths, and its position will swap, if the window-width is to small.<br>
            Panels can be used as a "Local Menu" and to keep overview...<br>
            Example: htm_Panel_0(<abbr class= "hint"><data-hint>htm_Panel_0($frmName=\'orders\', $capt=lang(\'@Find existing order:\'), $parms=\'\', $icon=\'fas fa-search\', $class=\'panelW720\', $where=__FILE__, $attr=\'\', $BookMark=\'blindAlley.page.php\',$panlBg=\'background-color: rgba(240, 240, 240, 0.80);\');</data-hint>Parameters</abbr>) and htm_Panel_00(<abbr class= "hint"><data-hint>htm_Panel_00($labl=\'@Save\', $subm=true, $title=\'\', $btnKind=\'save\', $akey=\'\', $simu=false, $frmName);</data-hint>Parameters</abbr>)
		');
	htm_Panel_00();

	htm_Panel_0($frmName='', $capt='@<small>Layout - </small>COLUMNS:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('If you will not let panels fill the window-width, you can use the functions: htm_RowColxxx() to create a column layout.<br>
            Example: htm_RowColTop(<abbr class= "hint"><data-hint>htm_RowColTop ($RowColWdth=240)</data-hint>Parameters</abbr>) and htm_RowColNext(<abbr class= "hint"><data-hint>htm_RowColNext ($RowColWdth=320)</data-hint>Parameters</abbr>) and htm_RowColBott()
		');
	htm_Panel_00();
 
	htm_Panel_0($frmName='', $capt='@<small>Data - </small>INPUT:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
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

	htm_Panel_0($frmName='', $capt='@<small>Data - </small>TABLE:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('The function htm_Table() is a advanced module to show and input user data.<br>
            It has fixed (sticky) column headers, and Scrolling content-window.<br>
            Column wise it can: Filter - Sort - Width-Resize<br>
            Row wise it can: Create - Change - Delete - Spec. Buttons - set background color<br>
            Above and underneth the table, you can use special captions and notes.<br>
            Example: htm_Table(<abbr class= "hint"><data-hint>htm_Table($TblCapt, $RowPref, $RowBody, $RowSuff, $TblNote, &$TblData, $FilterOn, $SorterOn, $CreateRec, $ModifyRec, $ViewHeight, $TblStyle, $CalledFrom, $MultiList)</data-hint>Parameters</abbr>)
		');
	htm_Panel_00();

	htm_Panel_0($frmName='', $capt='@<small>Extra - </small>SPECIAL:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('In addition to standard html features, there are a number of specialized features: <br>
            Examples: <br>
            htm_MultistateButt(); - A button with 3 or more states<br>
            htm_Dialog(); - A system with messages to the user.<br>
            Pmnu_0(); / Pmnu_00(); - A context popup menu system.<br>
            
            <br>
		');
	htm_Panel_00();

	htm_Panel_0($frmName='', $capt='@<small>System - </small>NAMING rules:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
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

	htm_Panel_0($frmName='', $capt='@<small>System - </small>NOTES:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('Click on the panels caption to show/hide the content<br>
                     The \'@\'-prefix in strings indicates that it is a translatable text.<br>
                     This introduction is created with the PHP2HTML-system.<br>
		');  
	htm_Panel_00();
    
    htm_RowColBott();
    PanelOff($First=1,$Last=7);

htm_Page_00();

?>