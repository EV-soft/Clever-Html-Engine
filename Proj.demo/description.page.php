<?php   $DocFile= './Proj.demo/description.page.php';    $DocVer='1.3.0';    $DocRev='2023-05-17';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:       LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [$LibIx, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);               // jquery.min.js
define('LIB_JQUERYUI',      [$LibIx, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [$LibIx, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/']);
define('LIB_FONTAWESOME',   [$LibIx, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/']);
define('LIB_TINYMCE',       [0,      '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js']); 
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


### PAGE-START:
htm_Page_0( titl:'description.page.php', hint:$©,  info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:false);
    Menu_Topdropdown(true); htm_nl(1);
    
    htm_Card_0(capt:'System description:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');

    htm_TextDiv('PHP2HTML is a library, a collection of functions that can be used systematically for <br>
        the interface of your program that you develop in PHP.<br><br>
        It consists of a large number of functions, all of which support the use of different <br>
        national languages.<br>
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

        When choosing a layout, it is emphasized that it is compact, so it is suitable <br>
        for narrow screens that appear on phones and tablets.<br><br>

        Furthermore, there are functions that enable layout control.<br><br>
        And more...<br><br>');

    htm_TextDiv('
        <u>Requirement:</u><br>
        PHP 7+/ 8+<br>
        HTML5<br>
        CSS3<br> 
        Source code must be UTF-8, no tabs, indent 4 space<br><br>
        <u>Used libraries:</u><br>
        jQuery - Javascript. <br>
        Font-awesome - icons. <br>
        Mottie Tablesorter-system - Extended table functions.<br><br>
    ');

    htm_TextDiv('
        <u>Run mode:</u><br>
        You can chose between 2 running modes: "On-line" or "Off-line"<br><br>
        <b>"On-line"</b> means with internet access - Libraries is loaded from CDN-servers.<br>
        Used space is reduced with 29 Mb (/_assets is not needed),<br>
        but system can\'t run if connection to the internet breaks.<br><br>
        <b>"Off-line"</b> means without internet access - Libraries is in subfolder /_assets<br>
        Used space is min. 0.4 Mb. Delays is minimized.<br><br>
    ');
    
    htm_Card_00();
    
    htm_Card_0(capt:'Note about the demo:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
    
    htm_TextDiv('
        In demo source-files, the variable name and variable value are in all function calls <br>
        specified to make the understanding clearer (PHP 7 syntax).<br><br>
        Most variable names is actually redundant and can be omitted.<br>
        Furthermore variables that have a default value can be omitted, <br>
        if no individual values are subsequently required.<br><br>
        <i>PHP 7 Example:</i><br>
        <b>htm_Input(</b>$vrnt=\'num1\', $name=\'num1\', $valu=\'87654321\',<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$labl=\'@htm_Input(num1)\', $llgn=\'\', $hint=\'@Demo of htm_Input\',<br>
        &nbsp;&nbsp;&nbsp;&nbsp;$algn=\'center\'<b><br>
        );</b><br><br>
        <i>Short form:</i><br>
        <b>htm_Input(</b>\'num1\',\'num1\',\'87654321\',\'@htm_Input(num1)\',\'@Demo of htm_Input\'<b>);</b><br><br>
        <i>PHP 8 Example:</i><br>');
    echo htm_CodeDiv(highlight_words(highlight_str(
"   htm_Input(
        labl:'@htm_Input(num1)',
        hint:'@Demo of htm_Input',
        vrnt:'num1',                // Input() Variant
        name:'num1',
        valu:'87654321',
        wdth:'120px'
    ); " ,true)));
    echo 'Output in browser: ';
    htm_Input(
            labl:'@htm_Input(num1)',
            hint:'@Demo of htm_Input',
            vrnt:'num1',                // Input() Variant
            name:'num1',
            valu:'87654321',
            wdth:'120px'
        );
    htm_nl(3);
    htm_Card_00();
    
htm_Page_00();

### :PAGE_END
?>