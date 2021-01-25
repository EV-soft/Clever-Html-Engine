<?php   $DocFil= './Proj1/PHP2HTML-intro.page.php';    $DocVer='1.0.0';    $DocRev='2021-01-25';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');

htm_PagePrep($pageTitl='PHP2HTML - Introduction to the systems most usable modules:', $ØPageImage=$ØProgRoot.'_assets/images/_background.png',$align='center',$PgInfo=lang('@Introduction: PHP2HTML'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
    Menu_Topdropdown(true); htm_nl(1);
//    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">';
    htm_RowColTop($RowColWdth=1100);
    
    htm_TextDiv('Procedural block structured programming with the library PHP2HTML,<br> gives you easy central maintenance of your code',$align='left',$marg='8px',$more='font-weight: 600; text-align: center;');
    htm_nl(2);
    htm_Caption('<big>PHP2HTML - Introduction to the systems most usable modules:</big>');

	htm_PanlHead($frmName='', $capt='PAGE:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('A page is a window with html objects.<br>
            It uses two functions: htm_PagePrep() and htm_PageFina()<br>
            It setup the page title, the window background and content align.<br>
            All the needed preparing (calling libraries) is done here.<br>
            Example: htm_PagePrep(<abbr class= "hint"><data-hint>htm_PagePrep($pageTitl=\'\', $ØPageImage=\'\',$align=\'center\', $PgInfo=\'\', $PgHint=\'\')</data-hint>Parameters</abbr>) and htm_PageFina()
		');
	htm_PanlFoot();

	htm_PanlHead($frmName='', $capt='PANELS:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('Panels is a container for html-objects.<br>
            It uses two functions: htm_PanlHead() and htm_PanlFoot()<br>
            It constists of: icon - header - a body - and a footer that can be invisibly.<br>
            The header-caption is automatic translated to the selected language.<br>
            When clicking the caption-text in the header, it will show/hide the body&footer-content.<br>
            In the headers right side there are icons to open/close all the panels in the window.<br>
            Panels has predefined widths, and will swap if the window-width is to small.<br>
            Panels can be used as a "Local Menu" and to keep overview...<br>
            Example: htm_PanlHead(<abbr class= "hint"><data-hint>htm_PanlHead($frmName=\'orders\', $capt=lang(\'@Find existing order:\'), $parms=\'\', $icon=\'fas fa-search\', $class=\'panelW720\', $where=__FILE__, $more=\'\', $BookMark=\'blindAlley.page.php\',$panlBg=\'background-color: rgba(240, 240, 240, 0.80);\');</data-hint>Parameters</abbr>) and htm_PanlFoot(<abbr class= "hint"><data-hint>htm_PanlFoot($labl=\'@Save\', $subm=true, $title=\'\', $btnKind=\'save\', $akey=\'\', $simu=false, $frmName);</data-hint>Parameters</abbr>)
		');
	htm_PanlFoot();

	htm_PanlHead($frmName='', $capt='COLUMNS:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('If you will not let panels fill the window-width, you can use the functions: htm_RowColxxx() to create a column layout.<br>
            Example: htm_RowColTop(<abbr class= "hint"><data-hint>htm_RowColTop ($RowColWdth=240)</data-hint>Parameters</abbr>) and htm_RowColNext(<abbr class= "hint"><data-hint>htm_RowColNext ($RowColWdth=320)</data-hint>Parameters</abbr>) and htm_RowColBott()
		');
	htm_PanlFoot();
 
	htm_PanlHead($frmName='', $capt='INPUT:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('Input fields is the interface to interact with the users data of varies type.<br>
            It uses function htm_Input()<br>
            It constists of a Frame - Label - and a Data-field<br>
            <small>The Label:</small> is a translated caption for the field. When howering a translated hint will be shown.<br>
            <small>The Data-field:</small> If NULL data, a translated placeholder is shown.<br>
            <small>The Frame:</small> can be colored to signale special conditions.<br>
            Types: \'intg\', \'text\', \'dec0\', \'dec1\', \'dec2\', \'num0\', \'num1\', \'num2\', \'num3\', \'barc\', \'mail\', \'link\', \'sear\', \'file\', \'imag\', \'date\', \'time\', \'week\', \'mont\', \'rang\', \'butt\', \'colr\', \'phon\', \'pass\', \'area\'<br>
            Example: htm_Input(<abbr class= "hint"><data-hint>htm_Input($type=\'text\', $name=\'deliphon\', $valu= $arrDeliver[$name], $labl=\'@Phone\', $hint=\'@Enter Recipient`s Phone\', $plho=\'@Phone...\');</data-hint>Parameters</abbr>)
		');
	htm_PanlFoot();

	htm_PanlHead($frmName='', $capt='TABLE:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('The function htm_Table() is a advanced module to show and input user data.<br>
            It has fixed (sticky) column headers, and Scrolling content-window.<br>
            Column wise it can: Filter - Sort - Width-Resize<br>
            Row wise it can: Create - Change - Delete - Spec. Buttons - set background color<br>
            Above and underneth the table, you can use special captions and notes.<br>
            Example: htm_Table(<abbr class= "hint"><data-hint>htm_Table($TblCapt, $RowPref, $RowBody, $RowSuff, $TblNote, &$TblData, $FilterOn, $SorterOn, $CreateRec, $ModifyRec, $ViewHeight, $TblStyle, $CalledFrom, $MultiList)</data-hint>Parameters</abbr>)
		');
	htm_PanlFoot();

	htm_PanlHead($frmName='', $capt='NOTES:', $parms='', $icon='fas fa-info', $class='panelW720', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; ');
		htm_TextDiv('Click on the panels caption to show/hide the content<br>
                     The \'@\'-prefix in strings indicates that it is a translatable text.<br>
                     This introduction is created with the PHP2HTML-system.<br>
		');
	htm_PanlFoot();
    
    htm_RowColBott();
    PanelOff($First=1,$Last=5);

htm_PageFina();

?>