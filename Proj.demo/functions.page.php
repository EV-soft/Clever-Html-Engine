<?php   $DocFil= './functions.page.php';    $DocVer='1.6.0';    $DocRev='2026-10-11';     $DocIni='evs';  $ModNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Loscal-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

include('../funcscann.php');

### PAGE-START:
htm_Page_( titl:'functions.page.php', hint:'', info:'', inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:true);
   
    //                                              $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    
    htm_Card_( capt: '@Overview over the system functions:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_TextDiv(styl: 'padding: 5px;', body: '<big>FUNCTIONS - vers. '.$DocVer.' - '.date("Y-m-d").':</big><br>'.
            file_get_contents('Functions.html'));
        $lines = count(file('Functions.html'));
        // echo 'Total: '.floor(0.5+($lines/3)-1),' htm_Functions';
        echo 'Total: '.floor(0.5+($lines/3)-1),' htm_Functions<br>';
        echo 'Tip: Hovering the mouse over function names displays a short description.';
        htm_nl(2);
    htm_Card_end();

    htm_Card_( capt: '@Notes about function parameters - Keywords table();', icon: 'fas fa-info', 
                hint: '', form: 'keys', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;',vhgh:'800px');
        $data= [ # This is the source for keywords. 
            ['labl','Label','Built-in Translate'],
            ['capt','Caption','Built-in Translate'],
            ['body','Body (content)','Built-in Translate'],
            ['foot','Footer','Built-in Translate'],
            ['plho','PlaceHolder','Built-in Translate'],
            ['icon','Icon',''],
            ['hint','Hint (user tip / title)','Built-in Translate'],
            ['desc','Description',''],
            ['type','Type',''],
            ['name','Name',''],
            ['valu','Value',''],
            ['vmax','MaxValue',''],
            ['vmin','MinValue',''],
            ['form','Form',''],
            ['subm','Submit',''],
            ['acti','Form action',''],
            ['clas','Class',''],
            ['wdth','Width',''],
            ['heig','Height',''],
            ['algn','Align',''],
            ['marg','Margin',''],
            ['styl','Style',''],
            ['attr','Attribute',''],
            ['mode','Mode, method',''],
            ['font','Font',''],
            ['colr','Color',''],
            ['fclr','Foreground color',''],
            ['bclr','Background color',''],
            ['llgn','LabelAlign',''],
            ['link','Link',''],
            ['targ','Target',''],
            ['akey','AcessKey',''],
            ['kind','Kind',''],
            ['echo','Echo',''],
            ['unit','Unit',''],
            ['disa','Disabled',''],
            ['rows','Rows',''],
            ['step','Step',''],
            ['bord','Border',''],
            ['plac','Placement',''],
            ['rept','Repeat',''],
            ['rtrn','Return',''],
            ['titl','Title','Built-in Translate'],
            ['info','Info',''],
            ['inis','Initial script',''],
            ['imag','image',''],
            ['pbrd','Page border',''],
            ['simu','Simulate',''],
            ['clck','Click',''],
            ['stck','isSticky',''],
            ['cntx','Context',''],
            ['text','Plain text without HTML codes',''],
            ['html','Text with HTML codes',''],
            ['srce','Source with html content',''],
            ['butt','Button',''],
            ['mess','Message','Built-in Translate'],
            ['tplc','Class for Placement of tooltip',''],
            ['tsty','Style for Placement of tooltip',''],
            ['head','Panel header background (style)',''],
            ['evnt','Event script',''],
            ['note','Note','Built-in Translate'],
            ['rept','Repeat',''],
            ['shrt','shortcut',''],
            ['frst','First',''],
            ['last','Last',''],
            ['from','From',''],
            ['to__','To',''],
            ['elem','Element: id / the HTML element (htm_Card_: section, article, aside...)',''],
            ['pref','Prefix',''],
            ['suff','Suffix',''],
            ['filt','Ability to filter records',''],
            ['data','Data',''],
            ['crea','Created / Flag for creating new record',''],
            ['modi','Ability to modify data',''],
            ['expo','Export file',''],
            ['just','Justify',''],
            ['sort','Flag for sorting',''],
            ['filt','Flag for filtering',''],
            ['vrnt','Variant',''],
            ['capt','tblcapt - Caption above table','Built-in Translate'],
            ['pref','rowpref - fields prefixed table-rows',''],
            ['body','rowbody - table fields',''],
            ['suff','rowsuff - fields suffixed table-rows',''],
            ['idix','ix-suffix on name/id',''],
            ['note','tblnote - text below the table','Built-in Translate'],
            ['data','tbldata - Array with the table content',''],
            ['filt','filteron - Flag for table filtering (filt)',''],
            ['sort','sorton - Flag for table sorting (sort)',''],
            ['crea','createrec - Flag for table creating new record',''],
            ['modi','modifyrec - Flag for modifying table records',''],
            ['vhgh','viewheight - The height of scrolling window showing the table',''],
            ['styl','Style for table-span',''],
            ['from','calledfrom - DebugData: source file',''],
            ['list','list for options',''],
            ['enbl','Enabled',''],
            ['dflt','Default',''],
            ['strt','Start',''],
            ['expo','export table to file',''],
            ['show','Show cards arrows. Only show (disabled/readonly)',''],
            ['poup','Show cards popup/content-menu.',''],
            ['help','Link to custom-help',''],
            ['fold','Folded: a card that starts closed',''],
            ['ftop','string: Ajust field vertical position',''],
            ['code','Flag to convert html special characters',''],
            ['synt','Flag rel syntax output',''],
            ['repl','Flag rel formattet string',''],
            ['fmat','Format string',''],
            ['vlue','Value to replace ',''],
            ['niv0','Xtra style attribute= value in niveau 0',''],
            ['niv1','Xtra style attribute= value in niveau 1','Not active'],
            ['niv2','Xtra style attribute= value in niveau 2','Not active'],
            ['niv3','Xtra style attribute= value in niveau 3','Not active'],
            ['niv4','Xtra style attribute= value in niveau 4','Not active'],
            ['niv5','Xtra style attribute= value in niveau 5','Not active'],
            ['niv6','Xtra style attribute= value in niveau 6','Not active'],
            ['niv7','Xtra style attribute= value in niveau 7','Not active'],
            ['tout','Timeout',''],
            ['opti','option',''],
            ['extr','extra',''], /* ,
            ['dec2','htm_Input() Variant',''],
            ['num0','htm_Input() Variant',''],
            ['num1','htm_Input() Variant',''],
            ['num2','htm_Input() Variant',''],
            ['num3','htm_Input() Variant',''],
            ['mail','htm_Input() Variant',''],
            ['link','htm_Input() Variant',''],
            ['sear','htm_Input() Variant',''],
            ['file','htm_Input() Variant',''],      
            ['imag','htm_Input() Variant',''],
            ['date','htm_Input() Variant',''],
            ['time','htm_Input() Variant',''],
            ['week','htm_Input() Variant',''],
            ['mont','htm_Input() Variant',''],
            ['rang','htm_Input() Variant',''],
            ['butt','htm_Input() Variant',''],
            ['colr','htm_Input() Variant',''],
            ['phon','htm_Input() Variant',''],
            ['pass','htm_Input() Variant',''],
            ['area','htm_Input() Variant',''],
            ['html','htm_Input() Variant',''],
            ['chck','htm_Input() Variant',''],
            ['rado','htm_Input() Variant',''],
            ['opti','htm_Input() Variant',''],
            ['hidd','htm_Input() Variant','']   */
        ];
        $keys= '';  foreach ($data as $k) $keys.= $k[0].' ';
        sort($data);
        htm_Table(capt:[
                         ['Function parameter names, are shortened to 4 characters.<br>
                           This gives a pretty lookout of the code, <br>and the possibility for syntax coloring of words.<br>
                           Here is en explanation of all shortened names:', '8%','show','left', '', '']
                       ], 
                  pref:[], 
                  body:[
                          ['@Key.',        '        10%','text','',['center','','font-family: monospace;'],'@Position number in the group','.No.'],
                          ['@Meening/Description', '60%','text','',['left'  ],'@Item Description. A descriptive text of your choice','@Enter text...'],
                          ['@Note', '20%','text','',['left'  ],'@Item note.','@Enter text...'],
                       ],
                  suff:[], 
                  note:'Here are the list of keys, which you can copy/paste to your editors list for syntaks words:<br><i>'.$keys.'</i>', 
                  data:$data,
                  filt:true,
                  sort:true,
                  crea:false, 
                  modi:true, 
                  vhgh:'400px',  
                  styl:'',  
                  from:__FILE__,
                  list:[],
                  expo:'',
                  rtrn:false); // dataexport.csv
        // echo $tbl1;
        
        htm_TextDiv(body:
                    '@Built-in Translate - meens the htm_lang() function, mostly is called inside the function, so there are no need to convert the text before the function call. Just use the @-prefix',
                    attr:'white-space: wrap;');
    htm_Card_end(labl:'', icon:'', hint:'@If edited remember to save !', name:'', form:'',subm:false, attr:'', akey:'', kind:'save', simu:false);


    htm_Card_( capt: '@PHP parameters variants:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_TextDiv("
Important about function parameters:<br>
From PHP 8.0 you can give parameters to functions as:<br>
Named arguments<br>
  --> Specify only required parameters, skipping optional ones. (free order!)<br>
  --> Arguments are order-independent and self-documented.<br>
<br>
With positional arguments the order is fixed, and all arguments up to the last one you need must be given.<br>
<br>
The library needs PHP 8.1 or newer.<br>
");
        htm_nl(1);
    htm_Card_end();

    htm_Card_( capt: '@Advanced functions catalog:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
    echo lang('@Details about the most used and complex system functions.');

##--------------------------------------------
    # The declaration of htm_Table(), read from the library - so it is always the current one (was a copy that had got out of date)
    $rf= new ReflectionFunction('htm_Table');
    $decl= array_slice(file($rf->getFileName()), $rf->getStartLine() - 1, 80);
    $end= 0;  foreach ($decl as $i => $l) if (preg_match('~^\)~', $l)) { $end= $i;  break; }
    $out1= htm_CodeBox(code: implode('', array_slice($decl, 0, $end + 3)), rtrn: true).
           '<br>'.lang('@All details, with examples:').' <a href="table.page.php">table.page.php</a>';

   
    $arrData= [['1', lang('@Input VAT'), '66200', '25,00', ''],
               ['2', lang('@Input VAT'), '66201', '25,00', ''],
               ['3', lang('@Input VAT'), '66202', '15,00', '']];

    $tbl1= htm_Table(
                capt: array(
                  ['Caption: <b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on India','@PURCHASE'],
                  ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
                ),
                pref: array(),      
                body: array(
                  ['@No.',         '10%','text','',['center'],'vat_no',  '@Position number in the group','.No.'],
                  ['@Description', '26%','data','',['left'  ],'vat_desc','@Item Description. A descriptive text of your choice','@Enter text...'],
                  ['@Account',     '10%','data','',['center'],'vat_acc', '@The number in the statement of account to which the sales tax must be posted.','Account...'],
                  ['@%-rate',      '10%','data','',['center'],'vat_rate','@VAT % rate','25 %...'],
                  ['@Note',        '36%','text','',['left'  ],'vat_note','@Note about the record','.?.'],
                ),
                suff: array(
                  ['@Rows',         '8%','rowact','',['center'],'@Delete, copy, move and undo in the browser', 'del copy move undo'],
                ),                 
                note: 'Table-note:',          
                data: $arrData,    
                filt: true,        
                sort: true,        
                crea: true,        
                modi: true,        
                vhgh: '200px',     
                styl: 'background-image: none;',
                from:  __FILE__,   
                list: ['',''],     
                expo: '',
                rtrn: true
            );
    $htm1= preCode($tbl1);                                       # The HTML the example makes

        htm_Tabs_( head:'<b>htm_Card()</b>', styl:'', rtrn:false);
##--------------------------------------------
            htm_Tab(labl:'Output',body:'The function output:<br> Comming soon !', 
                    name:'out1',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white');
##--------------------------------------------
            htm_Tab(labl:'PHP',   body:'PHP-code for calling htm_Card():<br> '.
                    htm_CodeBox("
function htm_Card_(
    capt: '',                           # string: The card caption
    icon: '',                           # string: icon to the left of caption
    hint: '',                           # string: The hint on hover caption
    form: '',                           # string: form id/name (No form without a name)
    acti: '',                           # string: form action 
    clas: 'cardWmax',                   # string: The card class (general CSS-data)
    wdth: '',                           # string: The closed card width
    styl: 'background-color: white;',   # string: The card body style
    attr: '',                           # string: general attributes (style) for the card-container
    show: true,                         # bool:   Show card-buttons top-right
    head: 'background-color: white;',   # string: Style for Header background
    vhgh: '600px',                      # string: MaxHeight (ViewHeight) for span (HideBody) with scrollable content
    help: ''                            # string: Link to custom Card-help
)

function htm_Card_end(
    labl: '',           # string: Label on the submit button
    icon: '',           # string: Icon left to label
    hint: '',           # string: Hint on hover the submit button
    name: '',           # string: The name of the button to submit
    form: '',           # string: The name of the form to submit
    subm: false,        # bool:   Submit button shown and active
    attr: '',           # string: Button attributes. Generel use e.g. action= \"\$link\"
    akey: '',           # string: Shortcut to activate the button
    kind: 'save',       # string: The button appearance 
    simu: false         # bool:   Button only simulate
)
", rtrn:true)
            ,
                    name:'php1',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightcyan;', bclr:'lightcyan');
            htm_Tab(labl:'HTML',  body:'The generated HTML-code:<br> Comming soon !'.preCode(''), 
                    name:'htm1',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgray;', bclr:'lightgray');
            htm_Tab(labl:'Doc',   body:'Declaring of the function:'.
                                htm_CodeBox("
function htm_Card_(
    \$capt = '',                         # string: The card caption
    \$icon = '',                         # string: icon to the left of caption
    \$hint = '',                         # string: The hint on hover caption
    \$form = '',                         # string: form id/name (No form without a name)
    \$acti = '',                         # string: form action 

    \$clas = 'cardWmax',                 # string: The card class (general CSS-data)
    \$wdth = '',                         # string: The closed card width
    \$styl = 'background-color: white;', # string: The card body style
    \$attr = '',                         # string: general attributes (style) for the card-container
    
    \$show = true,                       # bool:   Show card-buttons top-right
    \$head = 'background-color: white;', # string: Style for Header background
    \$vhgh = '600px',                    # string: MaxHeight (ViewHeight) for span (HideBody) with scrollable content
    \$help = ''                          # string: Link to custom Card-help
)

function htm_Card_end(
    \$labl = '',            # string: Label on the submit button
    \$icon = '',            # string: Icon left to label
    \$hint = '',            # string: Hint on hover the submit button
    \$name = '',            # string: The name of the button to submit
    \$form = '',            # string: The name of the form to submit
                    
    \$subm = false,         # bool:   Submit button shown and active
    \$attr = '',            # string: Button attributes. Generel use e.g. action= \"\$link\"
    \$akey = '',            # string: Shortcut to activate the button
    \$kind = 'save',        # string: The button appearance 
    \$simu = false          # bool:   Button only simulate
)
", rtrn:true), 
                    name:'doc1',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightyellow;', bclr:'lightyellow');
            htm_Tab(labl:'Notes', body:'Some special notes:<br> '. 'htm_Card() do not exist, but <br>
                                        htm_Card_() - to prepare the card <br>
                                        htm_Carde_end() - to finalize the card', 
                    name:'not1',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgreen;', bclr:'lightgreen');
        htm_Tabs_end(foot:'', styl:'', rtrn:false);
        
        htm_Tabs_( head:'<b>htm_Inbox()</b>', styl:'', rtrn:false);
            htm_Tab(labl:'Output',body:'The function output:<br> Comming soon !', 
                    name:'out2',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white');
            htm_Tab(labl:'PHP',   body:'PHP-code for calling htm_Inbox():<br> Comming soon !',
                    name:'php2',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightcyan;', bclr:'lightcyan');
            htm_Tab(labl:'HTML',  body:'The generated HTML-code:<br> Comming soon !'.preCode(''), 
                    name:'htm2',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgray;', bclr:'lightgray');
            htm_Tab(labl:'Doc',   body:'Declaring of the function:<br> Comming soon !', 
                    name:'doc2',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightyellow;', bclr:'lightyellow');
        htm_Tabs_end(foot:'', styl:'', rtrn:false);
        
        htm_Tabs_( head:'<b>htm_Input()</b>', styl:'', rtrn:false);
            htm_Tab(labl:'Output',body:'The function output:<br> Comming soon !', 
                    name:'out3',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white');
            htm_Tab(labl:'PHP',   body:'PHP-code for calling htm_Input():<br> '.
                    htm_CodeBox("
function htm_Input(# labl:'',plho:'@Enter...',icon:'',hint:'',vrnt: 'text',name:'',valu:'',form:'',wdth:'',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'2',step:'',list:[],llgn:'R',bord:'',ftop:'');
    # Generel order:
    \$labl= '',              # string: Translated label above the input field
    \$plho= '@Enter...',     # string: Translated placeholder shown when field is empty. Default: Enter...
    \$icon= '',              # string: The icon left of the label (label prefix)
    \$hint= '',              # string: Translated description for the field
    
    \$vrnt= 'text',          # string: Variant - 'text', 'date', ... Look at source !
    \$name= '',              # string: Set the fields name (and id)
    \$valu= '',              # string: The current content in input field
    \$form= '',              # string: With Local form given, click on label to submit
    
    \$wdth= '100%',          # string: Width of the field-container
    \$algn= 'left',          # string: The alignment of input content Default: left
    \$attr= '',              # string: Give more (special / non system) input attrib to the input
    \$rtrn= false,           # bool:   Act as procedure: Echo result, or as function: Return string
    
    # htm_Input() only:
    \$unit= '',              # string: A unit added to the content eg. currency or % If in front: '<' it is added as a prefix, else a suffix
    \$disa= false,           # bool:   Disable the field. Default: field is active
    \$rows= '2',             # string: Number of rows in multiline input (eg. area/html) Default: 2 (Radio/Check-list: 1 to output horisontal)
    \$step= '',              # string: the value of stepup/stepdown for numbers
    
    \$list= [],              # array:  Data for subitems in \"multi-list\" (eg. options, checkbox, radiolist) {opti:value,label,hint,attr}
    \$llgn= 'R',             # string: Label align Default: Right
    \$bord= '',              # string: BoxBorder color to mark required/optional field.   Default= 'border: 1px solid var(--grayColor);'
    \$ftop= ''               # string: Ajust field vertical position
)
", rtrn:true)
            ,
                    name:'php3',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightcyan;', bclr:'lightcyan');
            htm_Tab(labl:'HTML',  body:'The generated HTML-code:<br> Comming soon !'.preCode(''), 
                    name:'htm3',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgray;', bclr:'lightgray');
            htm_Tab(labl:'Doc',   body:'Declaring of the function:<br> Comming soon !', 
                    name:'doc3',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightyellow;', bclr:'lightyellow');
        htm_Tabs_end(foot:'', styl:'', rtrn:false);
        
        htm_Tabs_( head:'<b>htm_Page()</b>', styl:'', rtrn:false);
            htm_Tab(labl:'Output',body:'There are normerly no visibly output from this function:<br>but you can set a title, a hint and info or a background-image. ', 
                    name:'out4',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white');
            htm_Tab(labl:'PHP',   body:'PHP-code for calling htm_Page():<br> '.
                htm_CodeBox("
function htm_Page_(
    titl:'',           # string: Page title
    hint:'',           # string: Page tip  (vertical text - left)
    info:'',           # string: Page into (vertical text - right)
    inis:'',           # string: Initial CSS/js script in page header
    algn:'center',     # string: align background-image
    imag:'',           # string: Page background-image
    attr:'',           # string: Page attributes
    pbrd:true          # bool:   Draw border around the page body-div
) 

function htm_Page_end();  # End of page - has no parameters
", rtrn:true) ,
                    name:'php4',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightcyan;', bclr:'lightcyan');

            htm_Tab(labl:'HTML',  body:'Part of generated HTML-code:<br>'.preCode('
<!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="This program is about using library PHP2HTML">
    <meta name="author" content="EV-soft">
    <meta name="robots" content="Noindex, Nofollow"><meta name="googlebot" content="Noindex"><title>functions.page.php</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/jquery.tablesorter.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/widgets/widget-cssStickyHeaders.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/parsers/parser-input-select.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/jquery.tablesorter.widgets.js"></script><link  href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/css/theme.blue.css" rel="stylesheet" />
...
'), 
                    name:'htm4',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgray;', bclr:'lightgray');
$out4= htm_CodeBox("
function htm_Page_(# titl:'', hint:'', info:'', inis:'', algn:'center', gbl_Imag:'', attr:'', gbl_Bord:true) 
    \$titl='',            # string: Page title
    \$hint='',            # string: Page tip  (vertical text - left)
    \$info='',            # string: Page into (vertical text - right)
                          
    \$inis='',            # string: Initial CSS/js script in page header
    \$algn='center',      # string: align background-image
                          
    \$imag='',            # string: Page background-image
    \$attr='',            # string: Page attributes
    \$pbrd=true           # bool:   Draw border around the page body-div
) 

# Page content must be given between htm_Page_() and htm_Page_end()

function htm_Page_end(); # End of page - has no parameters
", rtrn:true);
            htm_Tab(labl:'Doc',   body:'Function declaring and parameter default:<br> '.$out4,  
                    name:'doc4',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightyellow;', bclr:'lightyellow');
            htm_Tab(labl:'Notes', body:'Some special notes:<br> '. 'htm_Page() do not exist, but use<br>
                                        htm_Page_() - to prepare the page <br>
                                        htm_Page_end() - to finalize the page', 
                    name:'not4',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgreen;', bclr:'lightgreen');
        htm_Tabs_end(foot:'', styl:'', rtrn:false);
        
        $php1= htm_CodeBox("
htm_Table(capt: array(
            ['Caption: <b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on India','@PURCHASE'],
            ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
          ),
          pref: array(),      
          body: array(
            ['@No.',         '10%','text','',['center'],'vat_no',  '@Position number in the group','.No.'],
            ['@Description', '26%','data','',['left'  ],'vat_desc','@Item Description. A descriptive text of your choice','@Enter text...'],
            ['@Account',     '10%','data','',['center'],'vat_acc', '@The number in the statement of account to which the sales tax must be posted.','Account...'],
            ['@%-rate',      '10%','data','',['center'],'vat_rate','@VAT % rate','25 %...'],
            ['@Note',        '36%','text','',['left'  ],'vat_note','@Note about the record','.?.'],
          ),
          suff: array(
            ['@Rows',         '8%','rowact','',['center'],'@Delete, copy, move and undo in the browser', 'del copy move undo'],
          ),                 
          note: 'Table-note:',          
          data: \$arrData,    
          filt: true,        
          sort: true,        
          crea: true,        
          modi: true,        
          vhgh: '200px',     
          styl: 'background-image: none;',
          from:  __FILE__,   
          list: ['',''],     
          expo: '',
          rtrn: false
       );
", rtrn:true);
        
        htm_Tabs_( head:'<b>htm_Table()</b>', styl:'', rtrn:false);
            htm_Tab(labl:'Output',body:'The function output:<br> '.$tbl1, 
                    name:'out5',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white');
            htm_Tab(labl:'PHP',   body:'PHP-code for calling htm_Table():<br> '.$php1,
                    name:'php5',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightcyan;', bclr:'lightcyan');
            htm_Tab(labl:'HTML',  body:'The generated HTML-code for table:<br>'.($htm1), 
                    name:'htm5',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgray;', bclr:'lightgray');
            htm_Tab(labl:'Doc',   body:'Declaring of the function:<br> '.$out1, 
                    name:'doc5',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightyellow;', bclr:'lightyellow');
        htm_Tabs_end(foot:'', styl:'', rtrn:false);
        
        htm_Tabs_( head:'<b>htm_Tabs()</b>', styl:'', rtrn:false);
            htm_Tab(labl:'Output',body:'The function output:<br> Comming soon !', 
                    name:'out6',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white');
            htm_Tab(labl:'PHP',   body:'PHP-code for calling htm_Tabs():<br> Comming soon !',
                    name:'php6',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightcyan;', bclr:'lightcyan');
            htm_Tab(labl:'HTML',  body:'The generated HTML-code:<br> Comming soon !'.preCode(''), 
                    name:'htm6',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgray;', bclr:'lightgray');
            htm_Tab(labl:'Doc',   body:'Declaring of the function:<br> Comming soon !', 
                    name:'doc6',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightyellow;', bclr:'lightyellow');
            htm_Tab(labl:'Notes', body:'Some special notes:<br> '.
                                        'All names must be unique on a page.<br>There are no function "htm_Tabs()" but use these tree:<br>
                                        htm_Tabs_() - to prepare the element <br>
                                        htm_Tab() - to create a single tab<br>
                                        htm_Tabs_end() - to finalize the element', 
                    name:'not6',  styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: lightgreen;', bclr:'lightgreen');
        htm_Tabs_end(foot:'', styl:'', rtrn:false);
        
        htm_nl(1);
    htm_Card_end();

    htm_Card_( capt: '@Other functions:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_TextDiv('
In addition to system functions, php2html.php contains declarations for<br>
other functions without prefix: htm_<br>
They are usable in your project, but are only documented in php2html.php<br>
');
        htm_nl(1);
    htm_Card_end();

// arrPretty(get_defined_vars(),'Defined_vars:');
htm_Page_Sect('<small>'.$©.'</small>','border: 1px solid #888; border-radius: 8px; overflow: hidden; margin: auto; background-color:#ebeaea;');
 
htm_Page_end();
CardOff(frst:1,last:5);
### :PAGE_END
/* 
    ## Notes:
    funcscann.php - Analyze project files and save in Functions.html
    functions.page.php - Display content in ../Functions.html
 */
?>
