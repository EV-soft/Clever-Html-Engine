<?php  $DocFile='../Proj.demo/Demo.page.php';    $DocVer='1.4.0';    $DocRev='2024-06-01';      $DocIni='evs';  $ModNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';
## NOTE: In this demo all function-parameters can be shown. In a real project you just need to give parameters different from default values !

$sys= $GLOBALS["gbl_ProgRoot"]= './../';
$gbl_ProgRoot= './../';
// $jsScripts= '';
$lateScripts= '';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';


require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');
 
 
$tblData=               # = array(),
        array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
               [['2'],[''],[''],[''],[''] ], 
               [['3'],[''],[''],[''],[''] ], 
               [['4'],[''],[''],[''],[''] ], 
               [['5'],[''],[''],[''],[''] ], 
               [['6'],[''],[''],[''],[''] ], 
               [['7'],[''],[''],[''],[''] ] );


htm_Page_( titl:'DEMO', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer,inis:'',algn:'center', imag: $bodybg='../_accessories/_background.png', pbrd:true);
    echo '<div style="text-align: center;"><br><b>Clever-Html-Engine</b> / php2html-Demo:';  htm_nl(2);

### Program mainmenu:
  if (($vismenu=true) and (($loggetind ?? '') == true) or true)
    { htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); htm_nl(1); }
//    { Menu_Topdropdown(true); htm_nl(1); }
// Menu_Topdropdown(true);     // htm_nl(1);
    echo '<style> body { padding-top: 0; margin-top:0; } </style>';
    
    // $menudata is set in: project.init.php
    // htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;');
    htm_nl(1);
    htm_Caption(labl:'@Be inspired - Here you can see examples of almost all system functions...',styl:'font-size:20px;');
    htm_nl(2);
    
// arrPrint($_POST,'$_POST');


// echo (float)number_format((float)'87654321',(int)substr('num2',3,1),DecimalSep,ThousandsSep);
// echo  number_format('87654321',2,'.',' ');
    
## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';}; # Init with value 12345
    
    if (isset($_POST['name']))  { $namex = $_POST['name']; } // Special case !

    $date= date("Y-m-d");
    htm_Card_( capt:'The variants of Input / Output:', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW960', wdth:'640px', styl:'background-color: white;', attr:'',  show:true,  head:$headbg, help:'CustHelp.htm');
    htm_nl();
    htm_Fieldset_(capt:'TEXT variants',icon:'',hint:'',wdth:'95%',marg:'',attr:'',rtrn:false);
        htm_Input(labl:'@htm_Input(Text)', plho:'?:',  icon:'', hint:'@Demo of htm_Input Field type single-line text',                      vrnt:'text', name:'text', valu:$text='text', form:'', wdth:'160px');
        htm_Input(labl:'@htm_Input(barc)', plho:'',    icon:'', hint:'@Demo of htm_Input Field type barc: shown with font barcode',         vrnt:'barc', name:'barc', valu:'BARCode39',   form:'', wdth:'160px;',   algn:'center');                                
        htm_Input(labl:'@htm_Input(html)', plho:'</>', icon:'', hint:'@Demo of htm_Input Field type html: Multi-line formatted html-text',  vrnt:'html', name:'html1', valu:'',          form:'', wdth:'140px;',   algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'', list:[], llgn:'R', bord:'', ftop:''); 
        htm_nl();   
        htm_Input(labl:'@htm_Input(area)', plho:'Multiline </>:', icon:'', hint:'@Demo of htm_Input Field type area: Multi-line text',      vrnt:'area', name:'area', valu:'',          form:'', wdth:'140px',    algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'6', step:'', list:[], llgn:'R', bord:'', ftop:'');
        $text= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & © 2019-2024 EV-soft'; 
        $html= '<a href="" border="0" style="cursor:help;" rel="nofollow" title="'.$text.'">
                <img style="width: 70%;" src=
               "https://qrcode.tec-it.com/API/QRCode?data='.urlencode($text).'&codepage=UTF8&size=small"></a>';
// debricated:  "https://chart.googleapis.com/chart?cht=qr&chl='.urlencode($text).'&chs=90x90&choe=UTF-8&chld=L|0"></a>';
/* 
<img src="https://qrcode.tec-it.com/API/QRCode?data=https%3a%2f%2fqrcode.tec-it.com" />
data            QR Code data, needs to be HTML encoded
errorcorrection Error correction level: L, M, Q or H
color           Hex color code for the QR symbol
backcolor       Hex color code for the background
istransparent   Transparency of the background: True or False
quietzone       Width of the whitespace around the QR code
quietunit       Measurement unit for the quiet zone: mm (default), in (inch), mil (mils), mod (modules) or px (pixel)
codepage        Code page used for encoding data. Choose between UTF8 (default), Cyrillic and ANSI
dpi             Resolution (DPI - dots per inch) of the QR code image [96..600]
size            Size of the QR code: small, medium or large
method          Method used for returning the created QR code image (PNG): BASE64 (BASE64 encoded byte array for AJAX calls), Image or Download
 */
        htm_Inbox(labl:'@htm_Inbox-demo',  plho:'', icon:'',hint:'@You can put anything html-code in htm_Inbox(). <br>Here it is a QR-code.',
                  vrnt:'',name:'Body_div1',valu:$html,form:'',wdth:'120px;',algn:'center',
                  attr:'color: green;',rtrn:false,unit:'',disa:false,rows:'2',step:'',list:[],llgn:'R',bord:'1px solid var(--grayColor);',ftop:'');
        $text= 'Copyright EV-soft [Code128]';
        $html= '<a href="" border="0" style="cursor:help" rel="nofollow" title="'.$text.'"><img width="100%"  src= 
                "https://barcodeapi.org/api/Code128/'.$text.'"></a>';
        htm_Inbox(labl:'@htm_Inbox-demo',  plho:'', icon:'',hint:'@You can put anything in htm_Inbox(). <br>Here it is a Code128 barcode.',
                  vrnt:'',name:'Body_div2',valu:$html, form:'',wdth:'340px;',algn:'center',
                  attr:'color: green;',rtrn:false,unit:'',disa:false,rows:'2',step:'',list:[],llgn:'R',bord:'1px solid var(--grayColor);',ftop:'');
        htm_nl(2);
        htm_Input(labl:'@htm_Input(mail)', plho:'', icon:'', hint:'@Demo of htm_Input Field type mail with syntax control',                 vrnt:'mail', name:'mail', valu:'',          form:'', wdth:'160px;');
        htm_Input(labl:'@htm_Input(url)',  plho:'https://...', icon:'', hint:'@Demo of htm_Input Field type url with syntax control',       vrnt:'link', name:'link', valu:'',          form:'', wdth:'160px;',   algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'');
        htm_Input(labl:'@htm_Input(pass)', plho:'', icon:'', hint:'@Demo of htm_Input Field type pass with "hidden" output',                vrnt:'pass', name:'pass1', valu:'',         form:'', wdth:'160px;',   algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'', list:[], llgn:'R', bord:'', ftop:'');
    htm_Fieldset_end();
    htm_nl(2);
    htm_Fieldset_(capt:'NUMBER variants',icon:'',hint:'',wdth:'95%',marg:'',attr:'',rtrn:false);
        htm_Input(labl:'@htm_Input(Intg)', plho:'', icon:'', hint:'@Demo of htm_Input Field type intg: centered integer',                   vrnt:'intg', name:'intg', valu:$intg='9999', form:'', wdth:'160px', algn:'center');
        htm_Input(labl:'@htm_Input(Dec0)', plho:'', icon:'', hint:'@Demo of htm_Input Field type dec0: centered number with 0 decimals',    vrnt:'dec0', name:'dec0', valu:$dec0='9999', form:'', wdth:'160px', algn:'center', attr:'', rtrn:false, unit:' %');
        htm_Input(labl:'@htm_Input(Dec1)', plho:'', icon:'', hint:'@Demo of htm_Input Field type dec1: number with 1 decimal ',             vrnt:'dec1', name:'dec1', valu:$dec1='9999', form:'', wdth:'160px', algn:'left',   attr:'', rtrn:false, unit:'<Unit prefix ');
        htm_Input(labl:'@htm_Input(Dec2)', plho:'', icon:'', hint:'@Demo of htm_Input Field type dec2: number with 2 decimal',              vrnt:'dec2', name:'dec2', valu:$dec2='9999', form:'', wdth:'160px', algn:'center', attr:'', rtrn:false, unit:' Unit suffix ');
        htm_nl(2);
        htm_Input(labl:'htm_Input(Dec0)',  plho:'', icon:'', hint:'Demo of htm_Input Field type dec0: left aligned number with %-suffix',   vrnt:'dec0', name:'dec0a', valu:'87654321',  form:'', wdth:'', algn:'left',   attr:'', rtrn:false, unit:' %');
        htm_Input(labl:'htm_Input(Dec1)',  plho:'', icon:'', hint:'Demo of htm_Input Field type dec1: centered number with %-suffix',       vrnt:'dec1', name:'dec1a', valu:'87654321',  form:'', wdth:'', algn:'center', attr:'', rtrn:false, unit:' %');
        htm_Input(labl:'htm_Input(Dec2)',  plho:'', icon:'', hint:'Demo of htm_Input Field type dec2: right aligned number with %-suffix',  vrnt:'dec2', name:'dec2a', valu:'87654321',  form:'', wdth:'', algn:'right',  attr:'', rtrn:false, unit:' %');
        htm_nl(2);
        htm_Input(labl:'@htm_Input(num1)', plho:'', icon:'', hint:'@Demo of htm_Input Field type numb: number with 1 decimal',              vrnt:'num1', name:'num1',  valu:'87654321',  form:'', wdth:'150px;', algn:'center');
        htm_Input(     '@htm_Input(num0)',      '',      '',      '@Demo of htm_Input Field type numb: left-justified number',                   'num0',      'num0',       '87654321',      '',      '150px;');
        htm_Input(labl:'@htm_Input(Date)', plho:'', icon:'', hint:'@Demo of htm_Input Field type date with browser popup selector',         vrnt:'date', name:'date',  valu:$date,       form:'', wdth:'160px',  algn:'center');
    htm_Fieldset_end();
    htm_nl(2);
    htm_Fieldset_(capt:'SELECT variants',icon:'',hint:'',wdth:'95%',marg:'',attr:'',rtrn:false);
        htm_Input(labl:'@htm_Input(opti)', plho:'@?...', icon:'', hint:'@Demo of htm_Input Field type opti: left aligned number with %-unit', vrnt:'opti', name:'opti', valu:'87654321', form:'', wdth:'160px', algn:'left', attr:'', rtrn:false, unit:' %', disa:false, rows:'3', step:'', list:[
            ['name1','@private','@Details about private'],
            ['name2','@proff','@Details about profession'],
            ['name3','@private','@Details about private','checked'],
            ['name4','@hobby','@Details about hobby'],
            ['name5','@private','@Details about private'],
        ]);
        htm_Input(labl:'htm_Input(chck)',  plho:'?...', icon:'', hint:'Demo of htm_Input Field type chck: Multi-line formatted chck-text',  vrnt:'chck', name:'chck',  valu:'',         form:'', wdth:'150px;', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'', list:[
            ['name1','@Label1','@Details about label1','checked'],
            ['name2','@Label2','@Details about label2','checked']
        ]);

        htm_Input(labl:'@htm_Input(chck)', plho:'?...', icon:'', hint:'@Demo of htm_Input Field type chck: Multi-line formatted chck-text, vertical layout',  vrnt:'chck', name:'chck1', valu:'', form:'', wdth:'120px;', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'', list: [
            ['pos1','@private','@Details about private' ],
            ['pos2','@proff','@Details about profession'],
            ['pos3','@private','@Details about private' ],
            ['pos4','@hobby','@Details about hobby','checked'],
            ['pos5','@private','@Details about private' ],
        ]);
        
        htm_Input(labl:'@htm_Input(rado)', plho:'?...', icon:'', hint:'@Demo of htm_Input Field type radio, vertical layout', vrnt:'rado', name:'rado1', valu:'',  form:'', wdth:'120px;', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'2', step:'', list: [
            ['post1','@private','@private'],
            ['post2','@proff','@profession'],
            ['post3','@private','@private','checked'],
            ['post4','@hobby','@hobby'],
            ['post5','@private','@private'],
        ]);
        htm_nl(2);
        htm_Input(labl:'@htm_Input(rang)', plho:'',     icon:'', hint:'@Demo of htm_Input Field type range: 0..50 ',     vrnt:'rang', name:'rang', valu:'30', form:'', wdth:'', algn:'left', attr:' min="0" max="50"', rtrn:false, unit:'', disa:false, rows:'1', step:'', list:[], llgn:'R', bord:'', ftop:'');
        htm_Input(labl:'@htm_Input(chck)', plho:'?...', icon:'', hint:'@Demo of htm_Input Field type checkbox in a row, horisontal layout', vrnt:'chck', name:'chcka', valu:'',  form:'', wdth:'', algn:'left', attr:'',                  rtrn:false, unit:'', disa:false, rows:'1', step:'', list:[
            ['postc','dark','@Dark (/Light)','checked'],
            ['postd','shiny','@Shiny (/Matt)'],
            ]);
        htm_Input(labl:'@htm_Input(rado)', plho:'?...', icon:'', hint:'@Demo of htm_Input Field type radio in a row, horisontal layout', vrnt:'rado', name:'rado2', valu:'', form:'',  wdth:'', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'', list: [
            ['posta','happy','@Happy','checked'],
            ['postb','sorry','@Sorry'],
        ]);
    htm_Fieldset_end();
    htm_nl(2);
    htm_Fieldset_(capt:'OTHER variants',icon:'',hint:'',wdth:'95%',marg:'',attr:'',rtrn:false);
        htm_Input(labl:'<i class=\'fas fa-search\'></i> '.lang('@htm_Input(sear)'),
                                            plho:'?', icon:'', hint:'@Demo of htm_Input Field type search',                                 vrnt:'sear', name:'sear', valu:'',        form:'', wdth:'',      algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'');
        htm_Input(labl:'@htm_Input(time)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type time<br>NOT supported by all browsers',  vrnt:'time', name:'time', valu:'',        form:'', wdth:'100px', algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'');
        htm_Input(labl:'@htm_Input(week)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type week<br>NOT supported by all browsers',  vrnt:'week', name:'week', valu:'',        form:'', wdth:'',      algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'');
        htm_Input(labl:'@htm_Input(mont)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type month<br>NOT supported by all browsers', vrnt:'mont', name:'mont', valu:'',        form:'', wdth:'',      algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'');
        htm_nl(2);
        htm_Input(labl:'@htm_Input(file)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type file',                                   vrnt:'file', name:'file', valu:'',        form:'', wdth:'',      algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'', list:[], llgn:'R', bord:'', ftop:'');
        htm_Input(labl:'@htm_Input(imag)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type image',                                  vrnt:'imag', name:'imag', valu:'',        form:'', wdth:'100px', algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'', list:[], llgn:'R', bord:'', ftop:'');
        htm_Input(labl:'@htm_Input(colr)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type color',                                  vrnt:'colr', name:'colr', valu:'#0000ff', form:'', wdth:'100px', algn:'left',   attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'');
        htm_Input(labl:'@htm_Input(butt)',  plho:'',  icon:'', hint:'@Demo of htm_Input Field type button',                                 vrnt:'butt', name:'butt', valu:'BUTTON',  form:'', wdth:'',      algn:'center', attr:'', rtrn:false, unit:'', disa:false, rows:'1', step:'', list:[], llgn:'R', bord:'', ftop:'-');
    htm_Fieldset_end();
    htm_Card_end();

    htm_Card_(capt:'@Example of htm_Table():', icon:'fas fa-info', hint:'', form:'', acti:'', clas:'cardW960', wdth:'640px', styl:'background-color: white;', attr:'',  show: true,  head: $headbg, help:'CustHelp.htm');           
    htm_Table(
        $TblCapt= array( # ['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:horAlgn',      '5:Tip',    '6:Content'],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
          ['<b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on Inland','@PURCHASE'],
          ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
        ),
        $RowPref= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
    //      ['@Pref',         '4%','butt','',['center'],'@Row prefix', '<ic class="fas fa-check" style="color:green; font-size:13px; "></ic>'],
            ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => butt
        $RowBody= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',          '5%','text','',['center'], 'f1', '@Position number in the group','.No.'],
          ['@Description', '20%','data','',['left'  ], 'f2', '@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',      '6%','data','',['center'], 'f3', '@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',       '6%','data','',['center'], 'f4', '@VAT % rate','25 %...'],
          ['@Note',        '30%','text','',['left'  ], 'f5', '@Note about the record','.?.'],
        ),
        $RowSuff= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','butt','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),            # Felt 4: ($fieldModes), er sammensat af: [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        $TblNote=   '<br><b>Notes about htm_Table():</b><br>
                    Records can be sorted, filtered, created, modifyed and more...<br>
                    The visibly rows can be scrolled in a window below the fixed header.
                    ',
        $tblData,               # = array(),
       /*  array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
               [['2'],[''],[''],[''],[''] ], 
               [['3'],[''],[''],[''],[''] ] ), */
        $FilterOn= true,        # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
        $SorterOn= true,        # Mulighed for at sortere records efter kolonne indhold
        $CreateRec=false,        # Mulighed for at oprette en record
        $ModifyRec=true,        # Mulighed for at vælge og ændre data i en row
        $ViewHeight= '200px',   # Højden af den synlige del af tabellens data
        $TblStyle= 'background-color: lightyellow;',
        $CalledFrom='',         // = __FUNCTION__
        $Criterion= ['','']     # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
    );

        htm_Card_( capt:'@PHP Source-code: htm_Table();', icon:'fas fa-code', hint:'@View part of the demo source-code. !', form:'', acti:'', clas:'cardW960', wdth:'640px', styl:'background-color: lightgray;', attr:'margin:0;', help:'CustHelp.htm');
        htm_CodeBox("
function htm_Table(# capt:[], pref:[], body:[]',suff:[], note:'', data:[], filt:true, sort:true, crea:true, modi:true, vhgh:'400px', styl:'', from:__FILE__,list:[],expo:'');
    \$capt= [ # ['0:Label',   '1:Width',    '2:Type',     '3:OutFormat', '4:horJust',       '5:Tip',    '6:placeholder', '7:Content';], ...
           ],
    \$pref= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:Html'], ...
           ],           // if ((\$ModifyRec) or (\$RowBody[0][2]!='indx')) is 2% ColWidth can be used to => row-select-button
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
    \$expo= ''          # string: Export values in table data fields to CSV-file
)
");
        htm_Card_end();
    htm_Card_end();

    htm_nl(2);
    htm_Card_(capt:'@Containers', icon:'fas fa-database', hint:'', form:'', acti:'', clas:'cardW560', wdth:'640px', styl:'background-color: #f8f8f8;', attr:'margin:0;',  show:true,  head:$headbg, help:'CustHelp.htm');    
        htm_TextDiv(body:'The system includes the following functions of container-type:.<br>
              htm_Page_()<br>
              htm_Card_()<br>
              htm_Fieldset_()<br>
              htm_wrapp_()<br><br>
              An example of htm_Page_() is this actual page.<br>
              On this page you also see examples on multiple cards<br>
              Tables... (also a container-type)
              ');
        htm_nl(1);
        
        htm_Fieldset_(capt:'@Caption: ', icon:'', hint:'@You can use hints', wdth:'180px', marg:'', attr:'background-color:lightyellow', rtrn:false);
        echo 'You place your html-objects here inside fieldset-frames...<br>';
        htm_Fieldset_end( rtrn:false);
        
        htm_Fieldset_(capt:'@Caption: ', icon:'', hint:'@You can use hints', wdth:'180px', marg:'', attr:'background-color:MintCream', rtrn:false);
        echo 'You place your html-objects here inside fieldset-frames...<br>';
        htm_Fieldset_end( rtrn:false);

    htm_Card_( capt:'@PHP Source-code: htm_Field_0_();', icon:'fas fa-code', hint:'@HINT for this card', form:'', acti:'', clas:'cardW480', wdth:'640px', styl:'background-color: lightgray;', attr:'margin:0;', help:'CustHelp.htm');


$strCode= 
<<< 'STRING'
// PHP7-syntax:
htm_Fieldset_($capt='@Caption: ',
              $hint='@You can use hints',$icon='',
              $wdth='180px',$marg='',
              $attr='background-color:MintCream',
              $rtrn=false); 

// PHP8-syntax:
htm_Fieldset_(capt:'@Caption: ',
              hint:'@You can use hints',
              wdth:'180px',
              attr:'background-color:MintCream'),
              rtrn:false); 

    // htm_Fieldset_() must be followed by the html-content and htm_Fieldset_end() !
    
htm_Fieldset_end(rtrn:false);
STRING
;

        htm_CodeBox($strCode);
        echo 'echo \'You place your html-objects here inside fieldset-frames...\';';
    htm_Card_end();
    
        htm_nl(2);
        htm_Field(labl:'Label with hint', body:'HTML-Content <br>in container htm_Field() <br>---
        ', icon:'', hint:'Tip for htm_Field()<br>
        htm_Field($labl=\'Label with hint\',$hint=\'HINT for htm_Field()\',$icon=\'\',$name=\'fld\',$html=\'HTML-Content <br>in container htm_Field() <br>---\',$width=\'\',$margin=\'\',$ftop=\'\',$attr=\'\',$rtrn=false);',
         name:'fld', wdth:'', styl:'', attr:'', llgn:'C', rtrn:false, ftop:'');

    htm_Card_( capt:'@PHP Source-code: htm_Field();', icon:'fas fa-code', hint:'', form:'', acti:'', clas:'cardW560', wdth:'640px', styl:'background-color: lightgray;', attr:'', help:'CustHelp.htm');
$strCode= 
<<< 'STRING'
// PHP8-syntax:
htm_Field(labl:'Label with hint',
          hint:'Tip for htm_Field()',
          icon:'',name:'fld',
          html:'HTML-Content <br>in container htm_Field() <br>---',
          wdth:'',
          marg:'',ftop:'',attr:'',
          rtrn:false);
               
STRING
; 
        htm_CodeBox($strCode);
    htm_Card_end();
        
        
        
        htm_wrapp_($ViewHeight='60px');
        echo 'You place your html-objects here inside Wrapper-window...<br><br>
        A Wrapper-window is a window with a fixed height<br>
        in with you can scroll the content<br>
        if it owerflow the window-height<br>
        <br>
        ';
        htm_wrapp_end();
        htm_nl(1);

    htm_Card_( capt:'@PHP Source-code: htm_wrapp_();', icon:'fas fa-code', hint:'', form:'', acti:'', clas:'cardW560', wdth:'640px', styl:'background-color: white;', attr:'', help:'CustHelp.htm');           


$strCode= 
<<< 'STRING'
// PHP7-syntax:
htm_wrapp_($ViewHeight='60px'); // htm_wrapp_() must be followed by htm_wrapp_end() !
    echo 'You place your html-objects here inside Wrapper-window...<br><br>
          A Wrapper-window is a window with a fixed height<br>
          in with you can scroll the content<br>
          if it owerflow the window-heigh';
          
htm_wrapp_end();
    
STRING
; 
        htm_CodeBox($strCode); //    /* highlight_words */(highlight_string($strCode,true)));
    htm_Card_end();

        htm_nl(2);
    htm_Card_end(labl:'Demo',    icon:'', hint:'Buttom', name:'', form:'',     subm:false, attr:'', akey:'',  kind:'goon', simu:false);
        htm_nl(2);
    echo 'Examples of foldable card-system:';  htm_nl(2);
    htm_Card_(capt:'@htm_Card_(W= 560px) (click to close/open)', icon:'fas fa-database', hint:'', form:'head0', acti:'', clas:'cardW560', wdth:'640px', styl:'background-color: lightcyan;', attr:'',  show: true,  head: $headbg, help:'CustHelp.htm');           
        htm_TextDiv(body:'Cards are used to display a collection of html-objects.<br>
              They are defined i 14 widths from 160px to 1200px and width 100%.<br>
              The height adapts to the content.<br><br>
              The card content can be displayed/hidden by clicking card-header text.<br>
              In the header you see som icons which can controle<br>
              actual or all cards dimensions.');
       
    htm_Card_end(labl:'Demo',    icon:'', hint:'Buttom', name:'', form:'',     subm:false, attr:'', akey:'',  kind:'goon', simu:false);
    
    $GridOn= false;
    htm_nl(2);
    $ic= ''; // iconStack($cl1='fa-stack fa-2x',$cl2='fa-solid fa-square fa-stack-2',$cl3='fab fa-twitter fa-stack-1x fa-inverse',$rtrn=false)
    htm_Card_(capt:'@Signup: ', icon:'fas fa-user-check', hint:'', form:'head1', acti:'', clas:'cardW240', wdth:'640px', styl:'background-color: lightcyan;', attr:'', help:'',poup:false);
        htm_Input(labl:'@Financial Accounting'.$ic, plho:'@Account...',  icon:'', hint:'@The name of the accounting for wich you have access', vrnt:'text', name:'text1', valu:$text1='Account A', form:'', wdth:'80%', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3',  step:'');
        htm_Input(labl:'@Your account',         plho:'@Email...',    icon:'', hint:'@Type your email as your accont',                          vrnt:'mail', name:'mail2', valu:$mail2='Bookkeeper', form:'', wdth:'80%', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3',  step:'');
        htm_Input(labl:'@Your password',        plho:'@Password...', icon:'', hint:'@Type your password for your account',                     vrnt:'pass', name:'pass3', valu:$pass3='xx', form:'', wdth:'80%', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3',  step:'', list:[], llgn:'R', bord:'', ftop:'');
                 // $usr_name= 'user';  $usr_code= 'Code: PW-test';     $h= calcHash($usr_name,$usr_code);
                   # $labl='',$icon='',$hint='',$type='submit',$name='',$link='',$acti='',$font='32px',$fclr='gray',$bclr='white',$akey='',$rtrn=false
        htm_IconButt(labl:'@Forgotten password ?', icon:'fas fa-key', hint:'@Click to request a new password', type:'button', name:'lost', link:'', evnt:'', wdth:'', font:'18px', fclr:'gray', bclr:'white', akey:'', rtrn:false);
        htm_nl(2);
        $html= htm_Humantest(capt:'@Are you human? ', icon:'fa-solid fa-arrow-right-to-bracket', hint:'@Grab and slide to right to change state', 
                             form:'human', wdth:'100%', hght:'22px', yclr:'lightgray', nclr:'white', xytx:'@YES', ntxt:'@NO',rtrn:true);
        htm_Inbox(labl:'@Robot ?',  plho:'', icon:'',hint:'@Confirm you are not a robot',
                  vrnt:'',name:'robot',valu:$html, form:'',wdth:'80%;',algn:'center',
                  attr:'color: green;',rtrn:false,unit:'',disa:false,rows:'2',step:'',list:[],llgn:'R',bord:'1px solid var(--grayColor);',ftop:'');
        htm_nl(2); 
                
    htm_Card_end(labl:'Login',    icon:'', hint:'@Login with the given data', name:'butt', form:'head1',     subm:true, attr:'', akey:'',  kind:'navi', simu:false);
    
    htm_nl(2);
    htm_Card_( capt:'@Contact info:', icon:'fas fa-pen-square', hint:'', form:'head2', acti:'', clas:'cardW480', wdth:'640', styl:'background-color: lightcyan;', attr:'', vhgh:'660px;', help:'CustHelp.htm');           
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
        htm_Input(labl:'@Name',   plho:'@The name...',  icon:'', hint:'', vrnt:'text', name:'name', valu:$namex ?? '', form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        htm_Input(labl:'@Street', plho:'@Address 1...', icon:'', hint:'', vrnt:'text', name:'stre', valu:$stre ?? '',  form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        htm_Input(labl:'@Place',  plho:'@Address 2...', icon:'', hint:'', vrnt:'text', name:'plac', valu:$plac ?? '',  form:'', wdth:'66%',  algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        
        $GridOn= false; // Without grid the following fields can be placed on a single row.
        htm_Input(labl:'@ZIP', plho:'@Code...', icon:'', hint:'', vrnt:'opti', name:'zipp', valu:$zipp ?? '', form:'', wdth:'30%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'', list: [
                    ['5000','5000','5000'],
                    ['6000','6000','6000'],
                    ['6050','6050','6050','checked'],
                    ['6080','6080','6080'],
                    ['7000','7000','7000'],
                    ]);
        htm_Input(labl:'@City',      plho:'@Address town...',  icon:'', hint:'',                                                    vrnt:'text', name:'city',  valu:$city ?? '',  form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:''); 
        htm_Input(labl:'@Country',   plho:'@Country...',       icon:'', hint:'',                                                    vrnt:'text', name:'coun',  valu:$coun ?? '',  form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        htm_Input(labl:'@Remark',    plho:'@Remark?...',       icon:'', hint:'@Demo of htm_Input Field type area: Multi-line text', vrnt:'area', name:'remk',  valu:$remk ?? '',  form:'', wdth:'100%' ,algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'1', step:'');
        htm_Input(labl:'@Phone',     plho:'@Phone number...',  icon:'', hint:'',                                                    vrnt:'text', name:'phon',  valu:$phon ?? '',  form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        htm_Input(labl:'@Reference', plho:'@?...',             icon:'', hint:'',                                                    vrnt:'text', name:'refe',  valu:$refe ?? '',  form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        htm_Input(labl:'@Email',     plho:'@Email address...', icon:'', hint:'@Demo of htm_Input Field type mail',                  vrnt:'mail', name:'mail3', valu:$mail3 ?? '', form:'', wdth:'100%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'');
        
        if (isset($_POST['namechck']))  { $namechck = 'checked'; }
        htm_Input(labl:'@Mailing',   plho:'@?...',             icon:'', hint:'@Demo of htm_Input Field type chck',                  vrnt:'chck', name:'chck3', valu:$chck3 ?? '', form:'', wdth:'96%', algn:'left', attr:$m, rtrn:false, unit:'', disa:false, rows:'3', step:'',
                   list: [['namechck','@Mailing active','@Use mail',$namechck ?? '']]);
        
        $GridOn= false;
        htm_nl(1);
        htm_Input(labl:'@Created', plho:'', icon:'', hint:'@Demo of htm_Input Field type date with browser popup selector', vrnt:'date', name:'datr', valu:$date, form:'', wdth:'46%; float: left', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3');
        htm_Input(labl:'@Changed', plho:'', icon:'', hint:'@Demo of htm_Input Field type date with browser popup selector', vrnt:'date', name:'dath', valu:$date, form:'', wdth:'46%',              algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3');
        
        htm_nl(0);
    htm_Card_end(labl:'Save',    icon:'', hint:'@Save data in this card', name:'', form:'', subm:true, attr:'', akey:'s',  kind:'save', simu:false);
    
    echo '</div>'; // DEMO
    
    htm_nl(4);
    htm_Card_( capt:'@User rights:', icon:'fas fa-pen-square', hint:'@In this card, you see a DEMO of the Multi-state button', form:'head3', acti:'', clas:'cardW800', wdth:'640', styl:'background-color: white;', attr:'',  show: true,  head: $headbg, help:'CustHelp.htm');           

    $task= [['@Chart of Accounts',      'Struktur for regnskabet'],
            ['@Account settings',       'Angående regnskabet'],
            ['@Journal Entry ',         'Daglige posteringer'],
            ['@Financial Accounting',   'Bogførte posteringer'],
            ['@Financial reports',      'Regnskabs posteringer'],
            ['@Debtor orders',          'Kunde ordrer'],
            ['@Debtor accounts',        'Kunde konti'],
            ['@Debtor reports',         'Kunde oversigter'],
            ['@Creditor orders',        'Leverandør ordrer'],
            ['@Creditor accounts',      'Leverandør konti'],
            ['@Creditor reports',       'Leverandør oversigter'],
            ['@Item stock',             'Salgs produkter'],
            ['@Product reception',      'Ankommende produkter'],
            ['@Product reception',      'Produkt oversigter'],
            ['@Production orders',      'Bestillinger'],
            ['@Program setting',        'Setup af program og databaser'],
            ['@Data backup',            'Sikkerheds kopiering af program og databaser'],
            ['@Security',               'Administrer bruger rettigheder']
            ];

    $users = [
        ['adm','Administrator', ['3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3']],
        ['bok','Bookkeeper',    ['3','3','3','3','3','2','1','3','3','3','3','3','3','3','3','3','3','1']],
        ['aud','Auditor',       ['3','3','3','3','3','2','1','3','3','3','3','3','3','3','3','3','3','1']]
    ];

    $w= 0;
    foreach ($task as $t) $w= max($w,strlen($t[0]));
    echo '<span style="text-align:left;">';
    echo '<style> table, th, td { border: none; border-collapse: collapse;} 
        td span { writing-mode: vertical-lr; transform: rotate(180deg); height: '.($w*7.5).'px; }
        </style>';
        
    echo '<table style="margin: auto; font-size: smaller; "><tr style="padding:5px;">
    <td style="vertical-align: bottom;"><i>'.lang('@Name:').'</i></td> 
    <td style="vertical-align: bottom;"><i>'.lang('@Title:').'</i></td>';
    foreach ($task as $t) echo '<td><span style="padding:3px;" title="'.lang($t[1]).'">'.lang($t[0]).'</span></td>';
    echo '</tr>';
    foreach ($users as $usr) { $i= 0;
        echo '<tr style="height: 22px;"><td style="height: 22px;"><a href="">'.$usr[0].'</a></td><td>'.$usr[1].'</td>';
            foreach ($usr[2] as $a)   echo '<td style="height: 22px; width: 22px; text-align: center;">'.htm_MultistateButt(name:'ROW'.$i.'COL'.$i++, valu: $a).'</td>';
        echo '</tr>';
    }
    echo '<tr><td>&nbsp;</td></tr>';
    echo '
    <tr><td colspan="2" ><i>'.lang('@Create New:').'</i></td>';
    for ($i=0; $i<count($task); $i++) echo '<td style="height: 22px; width: 22px; text-align: center;">'. htm_MultistateButt(name:'newROWyCOL'.$i, valu:2) .'</td>';
    echo '<tr>
    <td><input type= "text" name="name1" value="" style="width: 50px; border: 1px solid var(--grayColor);" placeholder="name..." /></td>
    <td><input type= "text" name="titl1" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="titl..." /></td>
    <td colspan="9" ><i><small>Password:</small><input type= "text" name="pass1" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="pass..." /></i></td>
    <td colspan="9" ><i><small>Repeat:</small><input type= "text" name="pass2" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="pass..." /></i></td></tr>';
    echo '<tr><td>&nbsp;</td></tr>';
    echo '<tr style="border: 1px solid lightgray;">
    <td colspan="1"> &nbsp;<small><strong>'.lang('@Meaning:').'</strong></small></td>
    <td colspan="1">'.htm_MultistateButt(name:'dontCare', valu:1, acti:false, styl:'').' <small>: '. lang('@No access').'</small></td>
    <td colspan="4">'.htm_MultistateButt(name:'dontCare', valu:2, acti:false, styl:'').' <small>: '. lang('@Read only').'</small></td>
    <td colspan="4">'.htm_MultistateButt(name:'dontCare', valu:3, acti:false, styl:'').' <small>: '. lang('@Full access').'</small></td>
    <td colspan="4">'.htm_MultistateButt(name:'dontCare', valu:0, acti:false, styl:'').' <small>: '. lang('@Undefined').'</small></td>
    <td colspan="'.(count($task)-8).'" style="text-align:right;"><small>'.lang('@CLICK symbol to change').'</small>&nbsp;</td></tr>';
    echo '</table>';
    
    echo '</span>';
    htm_AcceptButt(labl:'@Create', icon:'',hint:lang('@Create new user'), form:'head3',  wdth:'100px', attr:'' ,akey:'', kind:'creat', rtrn:false, 
                   tplc:'LblTip_text', tsty:'left: auto; top: 0; position: relative;',acti:'htm_Toast("Create new user<br>Cant create yet !","orange","black")');
    htm_MiniNote('This is an example of using the multi-state button.');
    htm_nl(1);
    
    htm_Card_end(labl:'Save changes',    icon:'', hint:'@Save data in this card', name:'', form:'head3',     subm:true, attr:'', akey:'s',  kind:'save', simu:false);

    htm_Card_(capt:'@Popup menues:',icon:'fas fa-pen-square',hint:'@HINT for this card',form:'head4',acti:'',clas:'cardW800',wdth:'640',styl:'background-color: white;',attr:'', show: true, head: $headbg, help:'CustHelp.htm');           
        htm_TextDiv($content= 'You can build popup-menues with the PHP2HTML-system.<br>
              Both left-click and context right-click triggered.<br><br>
              Here you can test it:');
        htm_ActionButt(labl:'@LeftClick Me', icon:'fas fa-mouse colrgreen', hint:'@Try clicking me <br>to test popup-menues',type:'button', name:'left_click', form:'', acti:'',  attr:'', rtrn:false);
        Pmnu_($elem='left_click',capt:'Popup-Menu', wdth:'200px', icon:'fas fa-info',stck:'false',attr:'background-color:lightcyan;',cntx:false);
        Pmnu_Item(labl:'@LABEL 1', icon:'fas fa-info',hint:'@Hint 1',vrnt:'plain',      name:'a',clck:'',attr:'',shrt:'A');
        Pmnu_Item(labl:'@LABEL 2', icon:'fas fa-info',hint:'@Hint 2',vrnt:'plain',      name:'b',clck:'',attr:'',shrt:'B');
        Pmnu_Item(labl:'<hr>',     icon:'',           hint:'',       vrnt:'separator');
        Pmnu_Item(labl:'@CUST A',  icon:'',           hint:'@Hint A',vrnt:'custom',     name:'c',clck:'',attr:'');
        Pmnu_end();

        htm_ActionButt(labl:'@RightClick Me', icon:'fas fa-mouse colrgreen', hint:'@Try right-clicking me <br>to test context-menu', type:'button', name:'right_click', form:'', acti:'', attr:'', rtrn:false);
        
        Pmnu_(elem:'right_click',capt:'Context-Menu', wdth:'280px',  icon:'',stck:'true',attr:'background-color:lightyellow; height: 16px;',cntx:true);
     // Pmnu_Item($type='plain',$labl='',$hint='',$icon='',$id='',$click='',$attr='',$shrt='',$enabl='true',$rtrn=false) 
     // Pmnu_Item($labl='',$icon='',$hint='',$type='plain',$name='',$clck='',$attr='',$shrt='',$enabl='true',$rtrn=false) 
        Pmnu_Item(labl:'@Select All',icon:'far fa-object-group colrbrown iconsize', hint:'@Mark to select',                            vrnt:'plain',    name:'d',    clck:'alert("sss");',  attr:'',shrt:'CTRL+A');
        Pmnu_Item(labl:'@Copy',      icon:'fas fa-copy colrgreen iconsize',         hint:'@Copy selected to text-buffer',              vrnt:'plain',    name:'d1',   clck:'alert("sss");',  attr:'',shrt:'CTRL+C');
        Pmnu_Item(labl:'@Paste',     icon:'fas fa-paste colrblue iconsize',         hint:'@Paste content in text-buffer',              vrnt:'plain',    name:'d2',   clck:'alert("sss");',  attr:'',shrt:'CTRL+V');
        Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',name:'',     clck:'',               attr:'');
        Pmnu_Item(labl:'@Delete',    icon:'fas fa-trash-alt colrred iconsize',      hint:'@Delete the selected',                       vrnt:'plain',    name:'e',    clck:'',               attr:'',shrt:'DEL'.str_sp(6));
        Pmnu_Item(labl:'@Cut',       icon:'fas fa-cut colrblue iconsize',           hint:'@Cut the selected and save to text-buffer',  vrnt:'plain',    name:'d3',   clck:'alert("sss");',  attr:'',shrt:'CTRL+X');
        Pmnu_Item(labl:'@Undo',      icon:'fas fa-undo colrblue iconsize',          hint:'@Undo latest task',                          vrnt:'plain',    name:'d5',   clck:'alert("sss");',  attr:'',shrt:'CTRL+Z');
        Pmnu_Item(labl:'@Redo',      icon:'fas fa-redo colrblue iconsize',          hint:'@Redo the last delete',                      vrnt:'plain',    name:'d4',   clck:'alert("sss");',  attr:'',shrt:'CTRL+Y');
        Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',name:'',     clck:'',               attr:'background-color:lightyellow;');
        Pmnu_Item(labl:'@Multi Menu',icon:'fas fa-home colrgreen iconsize',         hint:'@Horisontal menu.',                          vrnt:'multi',    name:'e2',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Delete',    icon:'fas fa-trash-alt colrred iconsize',      hint:'@Delete the selected',                       vrnt:'subitem',  name:'e',    clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Cut',       icon:'fas fa-cut colrblue iconsize',           hint:'@Cut the selected and save to text-buffer',  vrnt:'subitem',  name:'d3',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Undo',      icon:'fas fa-undo colrblue iconsize',          hint:'@Undo latest task',                          vrnt:'subitem',  name:'d5',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'',           icon:'',                                       hint:'',                                           vrnt:'end_sub'); // multimenu                  
        Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',name:'',     clck:'',               attr:'background-color:lightyellow;');
        Pmnu_Item(labl:'@Sub Menu',  icon:'fas fa-home colrgreen iconsize',         hint:'@Open submenu.',                             vrnt:'submenu',  name:'f1',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Sub Item 1',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 1',                         vrnt:'subitem',  name:'f2',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Sub Item 2',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 2',                         vrnt:'subitem',  name:'f3',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Sub Item 3',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 3',                         vrnt:'subitem',  name:'f4',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'',           icon:'',                                       hint:'',                                           vrnt:'end_sub'); // submenu                                         
        Pmnu_Item(labl:'@Hover Menu',icon:'fas fa-bars colrgreen iconsize',         hint:'@Open hovermenu',                            vrnt:'hovermenu',name:'g1',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Sub Item 4',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 4',                         vrnt:'subitem',  name:'g2',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Sub Item 5',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 5',                         vrnt:'subitem',  name:'g3',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'@Sub Item 6',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 6',                         vrnt:'subitem',  name:'g4',   clck:'',               attr:'',shrt:'');
        Pmnu_Item(labl:'',           icon:'',                                       hint:'',                                           vrnt:'end_sub'); // hovermenu
        Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',);
        //Pmnu_Item($type='footer',   $labl='@A demo of PopUp menu, witch showup when you right-click an object<br><br>',$hint='',$icon='',$id='f',$click='',$attr='',$shrt='');
        // Pmnu_Item($type='plain',$labl='@Remove',$hint='@Hint 4',$icon='fas fa-minus colrred',$id='e',$click='',$attr='',$shrt='CTRL+V');
        Pmnu_end(labl:'FOOTER',hint:'The menu footer.',attr:'background-color:lightyellow; padding-top: 8px;');

        htm_nl(2);
    htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'head4', subm:false, attr:'', akey:'s', kind:'save', simu:false);
    
    htm_Card_(capt:'@Switch buttons: (working on it)',icon:'fas fa-pen-square',hint:'',form:'sw',acti:'',clas:'cardW800',wdth:'640',styl:'background-color: white;',attr:'');           
    htm_SwitchButt(labl:'@Switch conneting',hint:'@Click to toggle setting', name:'switchbox_id1', valu:'presssed', 
                   list:['@Connect','@disconnect'], wdth:'6em', bclr:'blue', styl:'style="padding:1px;"', 
                   rtrn:false);
    htm_nl();
    htm_SwitchButton(labl:'@Switch accepting',name:'switchbox_id2', valu:'', wdth:'6em', bclr:'green', styl:'style="padding:1px;"', hint:'@Here you can toggle setting', 
                   list:['@Accept','@Decline'], rtrn:false);
    htm_nl();
    htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'sw', subm:false, attr:'', akey:'s',  kind:'save', simu:false);

    htm_Card_(capt:'@Toggleable Tabs:',icon:'fas fa-pen-square',hint:'@HINT for this card',form:'tb',acti:'',clas:'cardW800',wdth:'640',styl:'background-color: white;',attr:'', show: true, head: $headbg );           

    $strTabel= 'The function htm_Table() is a advanced module to show and input user data.<br>
            It has fixed (sticky) column headers, and Scrolling content-window.<br>
            Column wise it can: Filter - Sort - Width-Resize<br><br>
            Row wise it can: Create - Change - Delete - Spec. Buttons - set background color<br>
            Above and underneth the table, you can use special captions and notes.<br><br>
            Example: htm_Table(<abbr class= "hint"><data-hint>htm_Table($TblCapt, $RowPref, $RowBody, $RowSuff, $TblNote, &$TblData, $FilterOn, $SorterOn, $CreateRec, $ModifyRec, $ViewHeight, $TblStyle, $CalledFrom, $MultiList)</data-hint>Parameters</abbr>)
        ';
    $strcards= 'cards is a container for html-objects.<br>
            It is build with two functions: htm_Card_() and htm_Card_end()<br><br>
            It consists of: icon + header - a body with content - and a footer that can be hidden.<br>
            The header-caption is automatic translated to the current selected language.<br>
            When clicking the caption-text in the header, it will show/hide the body&footer-content.<br>
            In the headers right side there are icons to open/close single or all the cards in the window.<br><br>
            cards has predefined widths, and its position will swap, if the window-width is to small.<br>
            cards can be used as a "Local Menu" and to keep overview...<br>
            Example: htm_Card_(<abbr class= "hint"><data-hint>htm_Card_($frmName=\'orders\', $capt=lang(\'@Find existing order:\'), $parms=\'\', $icon=\'fas fa-search\', $class=\'cardW720\', $where=__FILE__, $attr=\'\', $BookMark=\'blindAlley.page.php\',$panlBg=\'background-color: rgba(240, 240, 240, 0.80);\');</data-hint>Parameters</abbr>) and htm_Card_end(<abbr class= "hint"><data-hint>htm_Card_end($labl=\'@Save\', $subm=true, $title=\'\', $btnKind=\'save\', $akey=\'\', $simu=false, $frmName);</data-hint>Parameters</abbr>)
		';
    $strPage= 'To build a page there are 2 functions: <br><br>
            <b>htm_Page_()</b> - prepares the start of a page, by creating the HEAD content and starting the BODY section.<br>
            <br>and: <br>
            <b>htm_Page_end()</b> - finalize the page, by loading scripts and ending the BODY     <br><br>
            In between, you add your content.             <br><br>
            <small>See the source in php2html.lib.php to manage the function parameters.</small>
        ';
    htm_Tabs_(head:'<small>Here you see the htm_Tabs_() - Toggleable tabs system:</small>', styl:'text-align:left;', rtrn:false);
    htm_Tab(labl:'@HTML Page',body:$strPage,  name:'HTMLPage', styl:'text-align:left;',    bclr:'white',      vhgh:'200px');
    htm_Tab(labl:'@Cards',    body:$strcards, name:'cards',    styl:'text-align:left;',    bclr:'lightyellow',vhgh:'200px');
    htm_Tab(labl:'@Tables',   body:$strTabel, name:'Tables',   styl:'text-align:left;',    bclr:'lightcyan',  vhgh:'200px');
    htm_Tab(labl:'@Input',    body:'',        name:'input',    styl:'text-align:left;',    bclr:'lightgray', );
    htm_Tabs_end(foot:'@FOOTER for Toggleable Tabs', styl:'font-size: smaller;', rtrn:false);
    
    htm_Card_end(labl:'', icon:'', hint:'', name:'tb', form:'tb', subm:false, attr:'', akey:'s', kind:'save', simu:false);

     
    htm_Card_(capt:'@Containers:',icon:'fas fa-info',hint:'@HINT for this card',form:'',acti:'',clas:'cardW800',wdth:'640',styl:'background-color: white;',attr:'', show: true, head: $headbg);           
    htm_Fieldset_(capt:'This is af fieldSet container',icon:'',hint:'',wdth:'80%',marg:'',attr:'',rtrn:false);
    htm_TextDiv('Tabels, Cards, Tabs and Fieldsets is areas that contains other elements.');
    htm_Fieldset_end();
    htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'tb', subm:false, attr:'', akey:'s',  kind:'save', simu:false);


    htm_Card_(capt:'@Navigate functions:',icon:'fas fa-info',hint:'@HINT for this card',form:'',acti:'',clas:'cardW800',wdth:'640',styl:'background-color: white;',attr:'', show: true, head: $headbg);           
    htm_TextDiv('To navigate in your project, you can use the Menu_Topdropdown() shown on top of all demo pages.<br>
                 You can also use various buttons for that...
    ');
    htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'tb', subm:false, attr:'', akey:'s',  kind:'save', simu:false);

    htm_Card_(capt:'@About function parameters:',icon:'fas fa-info',hint:'@HINT for this card',form:'head5',acti:'',clas:'cardW800',wdth:'640',styl:'background-color: white;',attr:'', show: true, head: $headbg);

    function b($s) {return '<b>'.$s.'</b>';}
    htm_TextDiv('
        A new way to give parameters to functions in PHP 8+ is: <br><b>Named arguments</b><br>
        <small style="paddign-left:100px;">
        &nbsp; --> Specify only required parameters, skipping optional ones. (free order!)
        &nbsp; --> Arguments are order-independent and self-documented.<br><br>
        </small>
        That means a simpler way to call functions.<br><br>
        Example PHP 7: (fixed order!)<br><code><div style="background-color:whitesmoke">
        htm_Input($labl=\'@htm_Input(Dec2)\', $plho=\'\', $hint=\'@Demo of htm_Input Field type dec2: number with 2 decimal\', ,<br>
         $type=\'dec2\', $name=\'dec2\', $valu=$dec2, $wdth=\'\', $algn=\'center\', $unit=\'<$ \');</div></code><br><br>
        Example PHP 8: (free order!)<br><code><div style="background-color:whitesmoke">
        htm_Input('.b('labl').':\'@htm_Input(Dec2)\', '.b('type').':\'dec2\','.b('name').':\'dec2\','.b('valu').':$dec2,'.b('unit').':\'<$ \','.
        b('hint').':\'@Demo of htm_Input Field type dec2: number with 2 decimal\');</div></code><br>
        <br>
        Be aware of PHP 7.4 is a supported version until 2023/24 ! <br>
        Use PHP 8 syntax...
        ');
    htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'head4', subm:false, attr:'', akey:'s',  kind:'save', simu:false);
       
    htm_Card_(capt:'@Demo of most recent functions (2024):',icon:'fas fa-info',hint:'@HINT for this card',form:'head6',acti:'',
              clas:'cardW800',wdth:'640',styl:'background-color: lightgray;',attr:'', show: true, head: $headbg, vhgh:'700px');
        htm_nl(2);
        htm_Field(labl:'@Demo of htm_Figure()', 
                  body: htm_Figure(
                           capt:'@The logo',type:'h2',imag:'../_accessories/21997911.png',
                           info:'@Missing image !',styl:'width:100px',
                           labl:'@EV-soft',
                           hint:'@Here you see mine Github-logo',rtrn:true), 
                  icon:'',
                  hint:'@Demo for htm_Figure()', name:'fig', wdth:'', styl:'background-color:lightcyan;', attr:'', llgn:'C', rtrn:false, ftop:'');
        echo '<hr>';
        htm_Field(labl:'@Demo of htm_Details()', 
                  body: htm_Details( capt:'@Details',type:'h3',
                           labl:'@Summery first',
                           body:'@This is the first details...',styl:'text-align:left; margin-left:20px;',
                           hint:'@These are summaries with collapsible details',mode:'',rtrn:true).
                        htm_Details( capt:'',type:'',
                           labl:'@Summery second',
                           body:'@This is the second details...',styl:'text-align:left; margin-left:20px;',
                           hint:'@Collapsible details',mode:'open',rtrn:true).
                        '<br>', 
                  icon:'',
                  hint:'@Demo of htm_Details()', name:'det', wdth:'300px;', styl:'background-color:lightcyan;', attr:'', llgn:'C', rtrn:false, ftop:'');
        htm_TextDiv(body:'@Also new in 2024 is htm_GoTopButt()<br>You see it on this page button to the right.', 
                algn:'left', marg:'8px', styl:'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',attr:'background-color: white;', rtrn:false );
        
        htm_Fieldset_(capt:'@Demo of htm_List_()',icon:'',hint:'@li list type<br>Marker: upper-roman',wdth:'',marg:'',styl:'background-color:white;',attr:'background-color:white;',rtrn:false);
            htm_List_(capt:'htm_List_(li):', vrnt:'li', type:'upper-roman', styl:'text-align:left;', rtrn:false);
                htm_List_item(labl:'@Label1', body:'@Description1', rtrn:false);
                htm_List_item(labl:'@Label2', body:'@Description2', rtrn:false);
                htm_List_item(labl:'@Label3', body:'@Description3', rtrn:false);
            htm_List_end();
        htm_Fieldset_end();
        htm_Fieldset_(capt:'@Demo of htm_List_()',icon:'',hint:'@ul unordered type',wdth:'',marg:'',styl:'background-color:white;',attr:'background-color:white;',rtrn:false);
            htm_List_(capt:'htm_List_(ul):', vrnt:'ul', strt:'10', styl:'text-align:left;', rtrn:false);
                htm_List_item(labl:'@Label1', body:'@Description1', rtrn:false);
                htm_List_item(labl:'@Label2', body:'@Description2', rtrn:false);
                htm_List_item(labl:'@Label3', body:'@Description3', rtrn:false);
            htm_List_end();
        htm_Fieldset_end();
        htm_Fieldset_(capt:'@Demo of htm_List_()',icon:'',hint:'@ol ordered type<br>Marker: square',wdth:'',marg:'',styl:'background-color:white;',attr:'background-color:white;',rtrn:false);
            htm_List_(capt:'htm_List_(ol):', vrnt:'ol', type:'square',strt:'10', styl:'text-align:left;', rtrn:false);
                htm_List_item(labl:'@Label1', body:'@Description1', rtrn:false);
                htm_List_item(labl:'@Label2', body:'@Description2', rtrn:false);
                htm_List_item(labl:'@Label3', body:'@Description3', rtrn:false);
            htm_List_end();
        htm_Fieldset_end();
        htm_Fieldset_(capt:'@Demo of htm_List_()',icon:'',hint:'@dl destriptive type',wdth:'',marg:'',styl:'background-color:white;',attr:'background-color:white;',rtrn:false);
            htm_List_(capt:'htm_List_(dl):', vrnt:'dl', strt:10, styl:'text-align:left;', rtrn:false);
                htm_List_item(labl:'@Label1', body:'@Description1', rtrn:false);
                htm_List_item(labl:'@Label2', body:'@Description2', rtrn:false);
                htm_List_item(labl:'@Label3', body:'@Description3', rtrn:false);
            htm_List_end();
        htm_Fieldset_end();
    htm_nl(3);   
    htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'head6', subm:false, attr:'', akey:'s',  kind:'save', simu:false);
    
    htm_nl(3);   
    htm_Card_(capt:'@Program name',icon:'fa-regular fa-address-card',
               hint:'@HINT for this card',form:'head7', acti:'',clas:'cardW800',wdth:'640',
               styl:'background-color: snow; ',attr:'', show: false, mode:'0', poup:false,
               help:'', fclr: "text-align:center; ",  
               frst:'<i class="fa-solid fa-bars" title="'.lang('@Use this as a menu-button').'"></i>', 
               last:'<i class="fa-solid fa-ellipsis-vertical" title="'.lang('@Use this as a setup-button').'"></i>');
        htm_nl(1);
        htm_TextDiv(body:'@The htm_Card() can also be used as a program window, <br>with icon-links for menu and settings to the right.', 
                    algn:'left', marg:'8px', styl:'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',attr:'background-color: white;', rtrn:false );
        htm_nl(1);
     htm_Card_end(labl:'', icon:'', hint:'', name:'', form:'head7', subm:false, attr:'', akey:'s',  kind:'save', simu:false);

    htm_GoTopButt();
    CardOff(frst:3,last:6);
    
htm_Page_end();

    run_Script('htm_Toast("<b>'. lang('@You`re looking at a DEMO !'). '</b><br>'. 
            lang('@It is a demonstration of the php2html-output.').'<br>Code is for PHP 8+ only!'. '","green","white")'
            );

// phpinfo();
// var_dump(opcache_get_status()['jit']);
// getState();
?>