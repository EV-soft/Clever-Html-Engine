<?php   $DocFile= './Proj.demo/PHP2HTML-intro.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';      $DocIni='evs';  $ModNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';
## NOTE: In this demo all function-parameters are shown. In a real project you just need to give parameters different from default values !

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

// $darkTheme= true;

htm_Page_($titl='PHP2HTML - Introduction to the systems most used modules:',$hint=$©,$info='File: '.$DocFile.' - Ver:'.$DocVer, $inis='',$algn='center', $gbl_Imag='', $gbl_Bord=false);

    htm_Menu_Leftout(capt:'Clever html engine', data:$menudata, foot:'PHP2HTML', styl:'top:88px;'); 
    run_script('desc_div("narrow","capt");');   // Init htm_Menu_Leftout() to narrow state
    
    htm_Menu_TopDown(capt:'Clever html engine', data:$menudata, foot:'PHP2HTML', styl:'top:0px;');
    htm_nl(5);
    
//    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">';

//  htm_RowCol_($RowColWdth=1100);
    
    htm_TextDiv(body:'
            <p style="margin: 10px; text-align: center; line-height: 1.2;"><span style="font-size: 18pt;"><strong>Clever html engine</strong></span></p>
            <p style="margin: 10px; text-align: center; line-height: 1.2;"><strong>Procedural block-structured programming with the PHP2HTML</strong></p>
            <p style="margin: 10px; text-align: center; line-height: 1;"><strong>&nbsp;library gives you easy central maintenance of your UI-code.</strong></p>
            <p>&nbsp;</p>
            <p style="margin: 12px;" >The PHP2HTML library are used in PHP applications to produce dynamic HTML/CSS/JS code with advanced features.</p>
            <p style="margin: 12px;" >Library consists of a collection of functions that produce both standard HTML elements and special usefull variants.</p>
            
            <p style="margin: 12px;" >With this library you can program a complete program, both backstage and frontstage, source code in PHP.</p>
            <p style="margin: 12px;" >From your compact block-structured source code, the generator produces the necessary html code in a >5:1 ratio</p>
            <p style="margin: 12px;" >In other words, you only have to write code that takes up 20% of the final code...</p>
            <p style="margin: 12px;" >The PHP2HTML system has built-in integration with several powerful open-source projects, Font-awesome, Tablesorter, Jquery, tinyMCE, which makes it easy to take advantage of these. </p>
            './* '
            <p style="margin: 12px;" >All modules are with a integrated language translation system, which allows the user to exchange all program texts into many different languages.</p>
            <p style="margin: 12px;" >User advice: input placeholder and pop-up user tip (hint/title) are consistently possible for all labels etc. They are made visible by hovering the mouse over the element.</p>
            <p style="margin: 12px;" >PHP2HTML make use of other open source libraryes: Font-awesome, Tablesorter, Jquery, tinyMCE...</p>
            '. */'
            <br>
            ', algn:'justify', marg:'12px;padding:12px', styl:' font-weight: 500; color: #000000; border-radius: 25px; width:700px; margin: auto; background-color: white;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);');
    echo '<br>';

    htm_Card_(capt:'@Benefits:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv(body:'
<table style="border-collapse: collapse; width: 100%; height: 278.125px;" border="0"><colgroup><col style="width: 24%;"><col style="width: 77%;"></colgroup>
<tbody>
<tr>
<td style="height: 40px; text-align: center;" colspan="2"><span style="font-size: 14pt;"><strong>Integrated advantages of the system:</strong></span></td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Translation</strong></td>
<td style="height: 21px;">Advanced translation system for your entire program interface</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Icons </strong></td>
<td style="height: 21px;">Option for font-awesome icons anywhere</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>User Advice </strong></td>
<td style="height: 21px;">Tooltip, placeholder and pop-up user tip (hint/title) for all html elements</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Cards </strong></td>
<td style="height: 21px;">Compact adaptive layout with collapsible cards</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Tables </strong></td>
<td style="height: 21px;">Advanced sortible tables based on Mottie Table Sorter system</td>
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
<td style="height: 21px;">Narrow cards suitable for adaptive fit</td>
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
<td style="height: 21px;"><strong>PHP 8.3+</strong></td>
<td style="height: 21px;">Compatible with latest PHP</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px;"><strong>Block oriented</strong></td>
<td style="height: 21px;">Provides compact and clearer code...</td>
</tr>
</tbody>
</table>
<p style="text-align:center;">
<br> PHP is the language for producing server-side backend programming.
<br> With PHP2HTML you can also produce client-side frontend programming in PHP.
<br> Thus, you can now program your entire project in PHP.
<br> 
<br> 

<i>Code and Time-saving when you are familiar with the system<br>
Don\'t reinvent the Wheel, use PHP2HTML…</i></p>
		',marg:'8px;padding:10px');
	htm_Card_end();

    htm_Card_(capt: '@CODE EXAMPLE:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'', vhgh:'900px');
		htm_TextDiv('@Here is an example of how the system generates html code.<br><i>This compact height level code:</i>');
        $strCode= '// php:
htm_Input(labl:\'@Amount\', icon:\'fas fa-euro\', vrnt:\'dec2\',
          hint:'. '\'@Demo of htm_Input Field variant dec2: number with 2 decimal\',
          name:\'dec2\', valu:0, wdth:\'150px\', algn:\'center\', unit:\'<$ \'); 

';
        htm_CodeBox(($strCode));
        
        htm_TextDiv('@<i>will produce css-data and this html code:</i>');
        
$strCode= '// HTML:
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
            Demo of htm_Input Field Variant dec2: number with 2 decimal <br>Unit: <$ 
        </data-hint>
    </abbr>
</div>
';
        htm_CodeBox((preg_replace("|^\\<code\\>\\<span style\\=\"color\\: #[a-fA-F0-9]{0,6}\"\\>|", "",$strCode)), rtrn:false);
        htm_TextDiv('@<i>And here are the output:</i>');
        $dec2= 0;
        htm_Input(labl:'@Amount',plho:'@Enter...',icon:'fas fa-euro',hint:'@Demo of htm_Input Field variant dec2: number with 2 decimal',
                  vrnt: 'dec2',name:'dec2',valu:$dec2,form:'',wdth:'150px',algn:'center',attr:'',rtrn:false,unit:'<$ ',disa:false,rows:'2',step:'',list:[],llgn:'R',bord:'',ftop:'');
        htm_TextDiv('@and it will have all the properties: <br> placeholder, validation, hint, colors, dimensions and much more...<br><br>
                    As you can see, the source code is very compact. Less than 1/5 !
                    <br>');
    htm_Card_end();

    htm_nl(1);
    htm_Caption('<big>PHP2HTML - Introduction to the systems most useful modules:</big>',$style='',$align='',$hint='@Example of user popup help/info'); 
    htm_nl(1);
    htm_Card_(capt:'@PAGE:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('A page is a browser window with html objects.<br>
            It is build with two functions: htm_Page_() and htm_Page_end()<br>
            Here are the page title, the window background and content align setup.<br>
            All the needed preparing (calling libraries) is done here.<br>
            Example: htm_Page_(<abbr class= "hint"><data-hint>htm_Page_(titl:\'\', hint:\'\', info:\'\', inis:\'\', algn:\'center\', imag:\'\', attr:\'\', pbrd:true);</data-hint>Parameters</abbr>) and htm_Page_end()<br>
            <small><small>Mouse-over "Paremeters" shows hint !</small></small>
		');
	htm_Card_end();

    htm_Card_(capt:'@CARDS:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Cards is a container for html-objects.<br>
            It is build with two functions: htm_Card_() and htm_Card_end()<br>
            It consists of: icon + header - a body with content - and a footer that can be hidden.<br>
            The header-caption is automatic translated to the current selected language.<br>
            When clicking the caption-text in the header, it will show/hide the body&footer-content.<br>
            In the headers right side there are icons to open/close all the cards in the window.<br>
            Cards has predefined widths, and its position will swap, if the window-width is to small.<br>
            Cards can be used as a "Local Menu" and to keep overview...<br>
            Example: htm_Card_(<abbr class= "hint">
            <data-hint style="background-color:#151515;"> '. highlight_words(highlight_str( 
                "htm_Card_(capt:'@CARDS:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:''"),styl:'color:'.'blue; font-style:italic;').
            '</data-hint>
            Parameters</abbr>) and htm_Card_end(<abbr class= "hint">
            <data-hint>htm_Card_end('. highlight_words(highlight_str( 
                "labl:'@Save', icon:'', hint:'', name:'', form:'', subm:true, attr:'', akey:'', kind:'save', simu:false)"),styl:'color:'.'blue; font-style:italic;').
            '</data-hint>
            Parameters</abbr>)
		');
	htm_Card_end();

    htm_Card_(capt:'@LAYOUT:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('If you will not let cards fill the window-width, you can use the functions: <br>
            htm_RowCol_() / htm_RowCol_next() / htm_RowCol_end() to create a column layout.<br> 
            Example: htm_RowCol_(<abbr class= "hint"><data-hint>htm_RowCol_0 (wdth:240)</data-hint> Parameters</abbr>) and htm_RowCol_next(<abbr class= "hint"><data-hint>htm_RowCol_next(wdth:320)</data-hint>Parameters</abbr>)<br>
            and htm_RowCol_end()
		');
	htm_Card_end();

    htm_Card_(capt:'@INPUT:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Input fields is the interface to interact with the users data of varies variants.<br>
            It is build with function htm_Input()<br>
            It contains a Border, - a Label - and a Data-field<br>
            <small>The Label:</small> is a translated caption for the field. When howering a translated hint will be shown.<br>
            <small>The Data-field:</small> If NULL data, a translated placeholder is shown.<br>
            <small>The Border:</small> can be colored to signale special conditions.<br>
            At this time there are 25 htm_Input() variants: \'intg\', \'text\', \'dec0\', \'dec1\', \'dec2\', <br>
            \'num0\', \'num1\', \'num2\', \'num3\', \'barc\', \'mail\', \'link\', \'sear\', \'file\', \'imag\', <br>
            \'date\', \'time\', \'week\', \'mont\', \'rang\', \'butt\', \'colr\', \'phon\', \'pass\', \'area\'<br>
            Example: htm_Input(<abbr class= "hint"><data-hint>htm_Input(vrnt:\'text\', name:\'deliphon\', valu: arrDeliver[$name], $labl:\'@Phone\', hint:\'@Enter Recipient`s Phone\', plho:\'@Phone...\');</data-hint>Parameters</abbr>)
		');
	htm_Card_end();

    htm_Card_(capt:'@TABLE:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('The function htm_Table() is a advanced module to show and input user data.<br>
            It has fixed (sticky) column headers, and Scrolling content-window.<br>
            Column wise it can: Filter - Sort - Width-Resize<br>
            Row wise it can: Create - Change - Delete - Spec. Buttons - set background color<br>
            Above and underneth the table, you can use special captions and notes.<br>
            Example: htm_Table(<abbr class= "hint"><data-hint>htm_Table('.
            highlight_words('capt:[], pref:[], body:[],suff:[], note:\'\', data:[],filt:true,sort:true,crea:true, modi:true, vhgh:\'400px\',  styl:\'\',  from:__FILE__,list:[],expo:\'\')','','color:'.'red; ').
            '</data-hint>Parameters</abbr>)
		');
	htm_Card_end();

    htm_Card_(capt:'@SPECIAL:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('In addition to standard html features, there are a number of specialized features: <br>
            Examples: <br>
            htm_MultistateButt(); - A button with 3 or more states<br>
            htm_Dialog(); - A system with messages to the user.<br>
            Pmnu_(); / Pmnu_end(); - A context popup menu system.<br>
            
            <br>
		');
	htm_Card_end();

      htm_Card_(capt:'@NAMING rules:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Rules for naming files:<br>
            <i>{file-name}.{content-type}.{file-type}</i><br><br>
            {file-names}: settings index <br>
            {content-types}: .page .inc .lib .min .css .js <small>(the secundary type)</small><br>
            {file-types}: .png .php .htm .txt .json <small>(the primary type)</small><br><br>
            Example: <b>intropage.css.php</b><br>
            <br>
            <br>
            Rules for naming funktions:<br>
            Block-start: <i>{name}_</i><br>
            Block-end:   <i>{name}_end</i><br>
            <i>{name}</i> could be htm_page / htm_card<br>
            <br>
		');
	htm_Card_end();

    htm_Card_(capt:'@NOTES:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW720', wdth:'', styl:'background-color: white;', attr:'');
		htm_TextDiv('Click on the cards caption to show/hide the content<br>
                     The \'@\'-prefix in strings indicates that it is a translatable text.<br>
                     This introduction is of course developed with the PHP2HTML-system.<br>
		');  
	htm_Card_end();
    
//  htm_RowCol_end();
    CardOff($First=3,$Last=9);

htm_Page_end();

?>