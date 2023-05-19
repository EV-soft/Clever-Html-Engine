<?php   $DocFil= './functions.page.php';    $DocVer='1.3.0';    $DocRev='2023-05-18';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:       LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [$LibIx, '_assets/jquery/latest/',            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);   
define('LIB_JQUERYUI',      [$LibIx, '_assets/jquery-ui/latest/',         'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);
define('LIB_TABLESORTER',   [$LibIx, '_assets/tablesorter/latest/',       'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']); 
define('LIB_FONTAWESOME',   [$LibIx, '_assets/font-awesome/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/']);        // css/all.min.css
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN

include('../funcscann.php');

### PAGE-START:
htm_Page_0( titl:'functions.page.php', hint:'', info:'', inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:true);
    Menu_Topdropdown(true); htm_nl(1);
    
    htm_Card_0( capt: '@The overview over the system functions:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_TextPre('<big>FUNCTIONS - vers. '.$DocVer.' - '.date("Y-m-d").':</big><br>'.
            file_get_contents('Functions.html'));
        htm_nl(1);
    htm_Card_00();

    htm_Card_0( capt: '@Notes about function parameters - Keywords table();', icon: 'fas fa-info', 
                hint: '', form: 'keys', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;',vhgh:'800px');
        $data= [
            ['labl','Label'],
            ['capt','Caption'],
            ['body','Body (content)'],
            ['foot','Footer'],
            ['plho','PlaceHolder'],
            ['icon','Icon'],
            ['hint','Hint (user tip / title)'],
            ['type','Type'],
            ['name','Name'],
            ['valu','Value'],
            ['form','Form'],
            ['subm','Submit'],
            ['acti','Form action'],
            ['clas','Class'],
            ['wdth','Width'],
            ['algn','Align'],
            ['marg','Margin'],
            ['styl','Style'],
            ['attr','Attribute'],
            ['font','Font'],
            ['colr','Color'],
            ['fclr','Foreground color'],
            ['bclr','Background color'],
            ['llgn','LabelAlign'],
            ['link','Link'],
            ['targ','Target'],
            ['akey','AcessKey'],
            ['kind','Kind'],
            ['echo','Echo'],
            ['unit','Unit'],
            ['disa','Disabled'],
            ['rows','Rows'],
            ['step','Step'],
            ['bord','Border'],
            ['plac','Placement'],
            ['rept','Repeat'],
            ['rtrn','Return'],
            ['titl','Title'],
            ['info','Info'],
            ['inis','Initial script'],
            ['imag','image'],
            ['pbrd','Page border'],
            ['simu','Simulate'],
            ['clck','Click'],
            ['vhgh','ViewHeight'],
            ['stck','isSticky'],
            ['cntx','Context'],
            ['html','String with HTML codes'],
            ['butt','Button'],
            ['mess','Message'],
            ['tplc','Class for Placement of tooltip'],
            ['tsty','Style for Placement of tooltip'],
            ['head','Panel header background (style)'],
            ['evnt','Event script'],
            ['note','Note'],
            ['rept','Repeat'],
            ['shrt','shortcut'],
            ['frst','First'],
            ['last','Last'],
            ['from','From'],
            ['to__','To'],
            ['elem','Element id'],
            ['pref','Prefix'],
            ['suff','Suffix'],
            ['filt','Ability to filter records'],
            ['data','Data'],
            ['crea','Created / Flag for creating new record'],
            ['modi','Ability to modify data'],
            ['expo','Export file'],
            ['just','Justify'],
            ['sort','Flag for sorting'],
            ['filt','Flag for filtering'],
            ['vrnt','Variant'],
            ['capt','tblcapt - Caption above table'],
            ['pref','rowpref - fields prefixed table-rows'],
            ['body','rowbody - table fields'],
            ['suff','rowsuff - fields suffixed table-rows'],
            ['note','tblnote - text below the table'],
            ['data','tbldata - Array with the table content'],
            ['filt','filteron - Flag for table filtering (filt)'],
            ['sort','sorteron - Flag for table sorting (sort)'],
            ['crea','createrec - Flag for table creating new record'],
            ['modi','modifyrec - Flag for modifying table records'],
            ['vhgh','viewheight - The heigh of scrolling window showing the table'],
            ['styl','Style for table-span'],
            ['from','calledfrom - DebugData: source file'],
            ['list','list for options'],
            ['expo','export table to file'],
            ['show','Only show (disabled/readonly)'],
            ['help','Link to custom-help'],
            ['ftop','string: Ajust field vertical position']
        ];
        $keys= '';  foreach ($data as $k) $keys.= $k[0].' ';
        
        htm_Table(capt:[
                         ['Most function parameter names, are shortened to 4 characters.<br>
                           This gives a pretty lookout of the code, <br>and the possibility for syntax coloring of words.<br>
                           Here is en explanation of the shortened names:', '8%','show','left', '', '']
                       ], 
                  pref:[], 
                  body:[
                          ['@Key.',        '        10%','text','',['center','','font-family: monospace;'],'@Position number in the group','.No.'],
                          ['@Meening/Description', '80%','text','',['left'  ],'@Item Description. A descriptive text of your choice','@Enter text...'],
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
                  expo:''); // dataexport.csv

    htm_Card_00(labl:'@Save', icon:'', hint:'@If edited remember to save !', name:'', form:'keys',subm:true, attr:'', akey:'', kind:'save', simu:false);

    htm_Card_0( capt: '@Parameters for some complex htm_functions:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: lightgray;', attr: '',head:'background-color: white;');
    

    htm_Card_0( capt: ' htm_Page_0();', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW720', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_CodeDiv(highlight_words(highlight_str(
"function htm_Page_0(# titl:'', hint:'', info:'', inis:'', algn:'center', gbl_Imag:'', attr:'', gbl_Bord:true) 
    \$titl='',           # string: Page title
    \$hint='',           # string: Page tip  (vertical text - left)
    \$info='',           # string: Page into (vertical text - right)
                 
    \$inis='',           # string: Initial CSS/js script in page header
    \$algn='center',     # string: align background-image

    \$imag='',           # string: Page background-image
    \$attr='',           # string: Page attributes
    \$pbrd=true          # bool:   Draw border around the page body-div
) 

function htm_Page_00();  # End of page - has no parameters
",true)));
    htm_Card_00();


    htm_Card_0( capt: ' htm_Card_0();', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW720', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_CodeDiv(highlight_words(highlight_str(
"function htm_Card_0(# capt:'', icon:'', hint:'', form:'', acti:'', clas:'cardWmax', wdth:'', styl:'background-color: white;', attr:'', show:true, head:'', vhgh:'600px');
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

function htm_Card_00(# labl:'', icon:'', hint:'', name:'', form:'',subm:false, attr:'', akey:'', kind:'save', simu:false)
    \$labl='',       # string: Label on the submit button
    \$icon='',       # string: Icon left to label
    \$hint='',       # string: Hint on hover the submit button
    \$name='',       # string: The name of the button to submit
    \$form='',       # string: The name of the form to submit
    
    \$subm=false,    # bool:   Submit button shown and active
    \$attr='',       # string: Button attributes. Generel use e.g. action= \"\$link\"
    \$akey='',       # string: Shortcut to activate the button
    \$kind='save',   # string: The button appearance 
    \$simu=false     # bool:   Button only simulate
)
",true)));
    htm_Card_00();


    htm_Card_0( capt: ' htm_Input();', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW720', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_CodeDiv(highlight_words(highlight_str(
"
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
",true)));
    htm_Card_00();


    $gbl_CardsBgrd= 'white'; 
    htm_Card_0( capt: ' htm_Cleverbox();', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW720', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_CodeDiv(highlight_words(highlight_str(
"htm_Cleverbox(# labl:'',plho:'@Enter...',icon:'',hint:'',vrnt: 'noUse',name:'noUse',valu:'',form:'noUse',wdth:'200px;',algn:'left',attr:'',rtrn:false,unit:'noUse',disa:false,rows:'noUse',step:'noUse',list:['noUse'],llgn:'R',bord:'1px solid var(--grayColor);',ftop:'');
    \$labl= '',                            # string: Translated label above the input field
    \$plho= '@Enter...',                   # string: The placeholder shown with blank value
    \$icon= '',                            # string: The icon left of the label
    \$hint= '',                            # string: The Translated description for the field
                                           
    \$vrnt= 'noUse',                       # 
    \$name= 'Body_div',                    # String: Set the Editable name (and id)
    \$valu= '',                            # string: The HTML content of the box-body
    \$form= 'noUse',                       # 
                                           
    \$wdth= '200px',                       # string: The outher Width of the field-container
    \$algn= 'left',                        # string: The alignment of input content Default: left 
    \$attr= '',                            # string: Give more (special / non system) attrib to the field 
    \$rtrn= false,                         # bool:  Act as procedure: Echo result, or as function: Return string
                                           
    \$unit= 'noUse',                       # 
    \$disa= false,                         # bool: Disable the field as editeble. Default: field is not editeble
    \$rows= 'noUse',                       # 
    \$step= 'noUse',                       # 
                                           
    \$list= ['noUse'],                     # 
    \$llgn= 'R',                           # string: Label align Default: Right 
    \$bord= '1px solid var(--grayColor);', # string: BoxBorder color to mark required/optional field.   Default= 'border: 1px solid var(--grayColor);' 
    \$ftop= ''                             # string: Ajust field vertical position 
)
",true)));
    htm_Card_00();
    

    htm_Card_0( capt: ' htm_Table;', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW720', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_CodeDiv(highlight_words(highlight_str("
function htm_Table(# capt:[], pref:[], body:[]',suff:[], note:'', data:[],filt:true,sort:true,crea:true, modi:true, vhgh:'400px',  styl:'',  from:__FILE__,list:[],expo:'');
    \$capt= [ # ['0:Label',   '1:Width',    '2:Type',     '3:OutFormat', '4:horJust',       '5:Tip',    '6:placeholder', '7:Content';], ...
           ],
    \$pref= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:Html'], ...
           ],
    \$body= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:fldKey', '6:ColTip','7:placeholder','8:default','9:[selectList]'], ...
           ],           # Field 4: \$FieldProporties - is composed of: [horJust, FieldBgColor, FieldStyle, TdColor, SorterON, FilterON, SelectON,
    \$suff= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:value! '], ...
           ],
    \$note= '',         # string: HTML-string - note to be shown below the table
   &\$data,             # array:  [{\"name_0\":value_0, \"name_1\":value_1, \"name_2\":value_2, \"name_3\":value_3, \"name_4\":value_4, \"name_5\":value_5, \"name_6\":value_6, \"name_7\":value_7, \"name_8\":value_8, \"name_9\":value_9},{...},{...}]
    \$filt= true,       # bool:   Ability to hide records that do not match filter // Does not work with hidd fields!
    \$sort= true,       # bool:   Ability to sort records by column content
    \$crea= true,       # bool:   Ability to create a records - string: Labeltext on createButton
    \$modi= true,       # bool:   Ability to select and change data in a row
    \$vhgh= '400px',    # string: The height of the visible part of the table's data
    \$styl= '',         # string: Style for the span that holds the table;
    \$from= __FILE__,   # string: = __FILE__ / __FUNCTION__ (debugging: locate error)
    \$list= ['',''],    # array:  LookupLists for options // Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
    \$expo= ''          # string: Export values in table fields (only ROWBody-cols) to CSV-file
)
",true)));
    htm_Card_00();


    htm_Card_00();

    htm_Card_0( capt: '@PHP parameters variants:', icon: 'fas fa-info', 
                hint: '', form: '', acti: '', clas: 'cardW800', wdth: '', styl: 'background-color: white;', attr: '',head:'background-color: white;');
        htm_TextDiv("
Important about function parameters:<br>
From PHP 8.0 you can give parameters to functions as:<br>
Named arguments<br>
  --> Specify only required parameters, skipping optional ones. (free order!)<br>
  --> Arguments are order-independent and self-documented.<br>
<br>
On PHP 7+ the order of parameters was fixed, and could not be omitted.<br>
<br>
Be aware of PHP 7.4 is a supported version until 2023/24 !<br>
");
        htm_nl(1);
    htm_Card_00();

// arrPretty(get_defined_vars(),'Defined_vars:');


htm_Page_00();
CardOff(frst:1,last:9);
### :PAGE_END
/* 
    ## Notes:
    funcscann.php - Analyze project files and save in Functions.html
    functions.page.php - Display content in ../Functions.html
 */
?>
