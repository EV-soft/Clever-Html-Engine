<?php   $DocFile= './Proj.demo/description.page.php';    $DocVer='1.4.1';    $DocRev='2024-07-01';      $DocIni='evs';  $ModNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2'; 
$needTinymce=     '2';

require_once ($sys.'php2html.lib.php');
// Other libraries:
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');


### PAGE-START:
htm_Page_( titl:'description.page.php', hint:$©,  info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:false);
    // Menu_Topdropdown(true); htm_nl(1);
    
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    
    htm_Card_(capt:'System description:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');

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
    
    htm_Card_end();
    
    htm_Card_(capt:'Note about the demo:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
    
    htm_TextDiv('
        In demo source-files, the variable name and variable value are in all function calls <br>
        specified to make the understanding clearer (PHP 7 syntax).<br><br>
        Most variable names is actually redundant and can be omitted.<br>
        Furthermore variables that have a default value can be omitted, <br>
        if no individual values are subsequently required.<br><br>
        <i>PHP 7 Example:</i><br>
        <b>htm_Input(</b><br>
        '."
        <small><small># labl:'', plho:'@Enter...', icon:'', hint:'', vrnt: 'text', name:'', valu:'', form:'', wdth:'100%', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'2', step:'', list:[], llgn:'R',bord:'', ftop:''
</small></small><br>".' 
        &nbsp;&nbsp;&nbsp;&nbsp; $labl=\'@htm_Input(num2)\', \'\', \'\', <br>
        &nbsp;&nbsp;&nbsp;&nbsp; $hint=\'@Demo of htm_Input\',<br>
        &nbsp;&nbsp;&nbsp;&nbsp; $vrnt=\'num2\', $name=\'num2\', <br>
        &nbsp;&nbsp;&nbsp;&nbsp; $valu=\'87654321\', \'\', wdth:\'120px\'<br>  
        &nbsp;&nbsp;&nbsp;&nbsp; $algn=\'right\'<b><br>
        );</b><br><br>
        <i>Short form:</i><br>
        <b>htm_Input(</b>\'@htm_Input(num2)\',  \'\', \'\', \'@Demo of htm_Input\', \'num2\', \'num2\', \'87654321\', \'120px\', \'right\'<b>);</b><br><br>
        <i>PHP 8 Example:</i><br>');
    echo htm_CodeBox(
"   htm_Input(
        labl:'@htm_Input(num2)',
        hint:'@Demo of htm_Input',
        vrnt:'num2',                // Input() Variant
        name:'num2',
        valu:'87654321',
        wdth:'120px',
        algn:'right'
    ); ", rtrn:true);
    
    echo 'Output in browser: ';
    htm_Input(
            labl:'@htm_Input(num2)',
            hint:'@Demo of htm_Input',
            vrnt:'num2',                // Input() Variant
            name:'num2',
            valu:'87654321',
            wdth:'120px',
            algn:'right'
        );
    htm_nl(3);
    htm_Card_end();
    
htm_Page_end();

### :PAGE_END
?>