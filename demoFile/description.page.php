<?php   $DocFil= './Proj1/demoFile/description.page.php';    $DocVer='1.0.0';    $DocRev='2021-01-25';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');


### PAGE-START:
htm_PagePrep($pageTitl='description.page.php', $ØPageImage=$ØProgRoot.'_assets/images/_background.png',$align='center',$PgInfo=lang('@page: System presentation'));
    Menu_Topdropdown(true); htm_nl(1);
    
    htm_PanlHead($frmName='', $capt='System description:', $parms='', $icon='fas fa-info', $class='panelW640', $func='Undefined', $more='', 
            $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    htm_TextDiv('PHP2HTML is a library, a collection of functions that can be used systematically for the interface of your program that you develop in PHP.<br><br>
        It consists of a large number of functions, all of which support the use of different national languages.<br>
        The functions generate output in the HTML5 format that all modern browsers support.<br><br>

        Furthermore, most are combined with:<br>
        <i>Label</i> - A heading for a field.<br>
        <i>Hint</i> - A popup help text displayed by mouse over label.<br>
        <i>Placeholder</i> - A visible text in input fields when the value is undetermined.<br>
        <i>Icon</i> - A graphic element that highlights the purpose.<br><br>

        For data viewing and editing, an advanced table is offered with:<br>
        Column wise: Filtering - Sorting - Resizable width<br>
        Row wise: Create - Change - Delete - Spec. Buttons<br>
        Fixed (sticky) column headers<br>
        Scrolling content-window<br>
        Zebra-striped rows<br><br>

        When choosing a layout, it is emphasized that it is compact, so it is suitable for narrow screens that appear on phones and tablets.<br><br>

        Furthermore, there are functions that enable layout control.<br><br>
        And more...<br><br>');
    htm_TextDiv('
        <u>Requirement:</u><br>
        PHP 7+ <small>(PHP 8.0 ready)</small><br>
        HTML5<br>
        CSS3<br>
        Source must be UTF-8, no tabs<br><br>
        <u>Included libraries:</u><br>
        jQuery<br>
        Font-awesome - icons. <br>
        Mottie Tablesorter-system - Extended table functions.<br>
        
        
    ');
    htm_PanlFoot();
    
    htm_PanlHead($frmName='', $capt='Note about the demo:', $parms='', $icon='fas fa-info', $class='panelW640', $func='Undefined', $more='', 
            $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    htm_TextDiv('
        In demo source-files, are the variable name and variable value in all function calls specified to make the understanding clearer.<br><br>
        Most variable names is actually redundant and can be omitted.<br>
        Furthermore, variables that have a default value can be omitted, if no individual values are subsequently required.<br><br>
        <i>Example:</i><br>
        <b>htm_Input(</b>$type=\'num1\',$name=\'num1\',$valu=\'87654321\',$labl=\'@htm_Input(num1)\',
        $llgn=\'\',$hint=\'@Demo of htm_Input\',$algn=\'center\'<b>);</b><br><br>
        <i>Short form:</i><br>
        <b>htm_Input(</b>\'num0\',\'num0\',\'87654321\',\'@htm_Input(num0)\',\'@Demo of htm_Input\'<b>);</b><br><br>
        ');
    htm_PanlFoot();
    
htm_PageFina();
### :PAGE_END
?>