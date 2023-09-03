<?php   $DocFile= './Proj.demo/card.page.php';    $DocVer='1.3.1';    $DocRev='2023-09-02';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:       LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [$LibIx, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);               // jquery.min.js
define('LIB_JQUERYUI',      [$LibIx, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [$LibIx, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_FONTAWESOME',   [$LibIx, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


### DATA-INIT/UPDATE:
## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }    // Special case !

### PAGE-START:
htm_Page_0(titl:'card.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'',
           algn:'center', imag:'../_accessories/_background.png', pbrd:false);
    // Menu_Topdropdown(true); htm_nl(1);
    // echo 'About the foldable card-system:';  htm_nl(2);
    
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;');
    htm_nl(3);
    
    htm_RowCol_0($RowColWdth=1200);
    htm_Card_0(capt: 'htm_Card_0(); (click to close/open)',icon: 'fas fa-info',
               hint: '',form: 'head',acti: '',clas: 'cardW560',wdth: '',styl: 'background-color: white;',attr: '' );
        htm_nl(1);
        htm_TextDiv('Cards are used to display a collection of HTML-objects <br>
              possibly with a common form and submit button.<br>
              They are defined i 14 widths from 160px to 1200px.<br><br>
              The card content can be displayed/hidden by clicking card-header.','center');
        htm_nl(2);
                 
    htm_Card_00(labl:'Demo', icon:'', 
                hint:'Buttom', name:'', form:'',subm:false, attr:'', akey:'', kind:'save', simu:false);
    // htm_RowCol_00();
    
    //htm_RowCol_0($RowColWdth=400);
    
    htm_Card_0(capt: '@Signup: <small>(Example)</small>',icon: 'fas fa-user-check',
               hint: '',form: 'head1',acti: '',clas: 'cardW320',wdth: '',styl: 'background-color: white;',attr: '');
    htm_Input(labl:'@Financial Accounting',plho:'@Account...',icon:'',hint:'@The name of the accounting for wich you have access',
              vrnt:'text',name:'text1',valu:$text1='', form:'',wdth:'75%',algn:'left',attr:'',rtrn:false,
              unit:'',disa:false,rows:'3',step:'', list:[],llgn:'R',bord:'',ftop:'');
    htm_Input(labl:'@Your account',plho:'@Email...', icon:'',hint:'@Type your uniq code (maybe email) as your accont',
              vrnt:'mail',name:'mail2',valu:'mail2@donald.duck', form:'', wdth:'75%', algn:'left', attr:'',rtrn:false,
              unit:'',disa:false,rows:'3',step:'', list:[],llgn:'R',bord:'',ftop:'');
    htm_Input(labl:'@Your password',plho:'@Password...',icon:'',hint:'@Type the password for your account',
              vrnt:'pass',name:'pass3',valu:$pass3='', form:'',wdth:'75%',algn:'left',attr:'',rtrn:false,
              unit:'',disa:false,rows:'3',step:'', list:[],llgn:'R',bord:'',ftop:'');
        $usr_name= 'user';  
        $usr_code= 'Code: PW-test';     
        $h= calcHash($usr_name,$usr_code);
        //htm_Input($vrnt='html',$name='text',$valu=$h,$labl='Hash:',$hint='@Demo of htm_Input Field variant html',$algn='left',$unit='',$disa=false,$rows='2',$width='95%',$step='',$more='',$plho='@Account...');
        echo '<br><br><a href="'.($link ?? '').'" accesskey="'.$akey=''.'"> '. Lbl_Tip('@Forgotten password ?','@Click to request a new password'). '</a>';
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field variant intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
    htm_Card_00(labl:'@Login', icon:'fas fa-key', hint:'@Login with the given data', 
                name:'', form:'',subm:true, attr:'', akey:'l', kind:'save', simu:false);
    // htm_RowCol_next($RowColWdth=400);
    
    htm_Card_0(capt: '@Contact info: <small>(Example)</small>',icon: 'fas fa-pen-square',
               hint: '',form: 'head2',acti: '',clas: 'cardW320',wdth: '',styl: 'background-color: white;',attr: '');
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
    htm_Input(labl:'@Name',plho:'@The name...',icon:'',hint:'',
              vrnt:'text',name:'name',valu:$namex?? '',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Street',plho:'@Address...',icon:'',hint:'',
              vrnt:'text',name:'stre',valu:$stre='',form:'',wdth:$wdh,algn:'left',attr:'',rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Your password',plho:'@Password...',icon:'',hint:'@Type your password for your account',
              vrnt:'text',name:'pass4',valu:$pass3='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');
        
    htm_Input(labl:'@ZIP',plho:'@Code...',icon:'',hint:'',
              vrnt:'opti',name:'zipp',valu:$zipp='',form:'',wdth:'30%',algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[
                    ['5000','5000','@5000'],
                    ['6000','6000','@6000'],
                    ['6050','6050','@6050','checked'],
                    ['6080','6080','@6080'],
                    ['7000','7000','@7000']
              ],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@City',plho:'@Address town...',icon:'',hint:'',
              vrnt:'text',name:'city',valu:$city='',form:'',wdth:'65%',algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Country',plho:'@Country...',icon:'',hint:'',
              vrnt:'text',name:'coun',valu:$coun='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Remark',plho:'@Remark...',icon:'',hint:'@Demo of htm_Input Field type area: Multi-line text',
              vrnt:'area',name:'remk',valu:$remk='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'1',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Phone',plho:'@Phone...',icon:'',hint:'',
              vrnt:'text',name:'city1',valu:$city='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Reference',plho:'@?...',icon:'',hint:'',
              vrnt:'text',name:'refe',valu:$refe='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Email',plho:'@Email address...',icon:'',hint:'@Demo of htm_Input Field type mail',
              vrnt:'mail',name:'mail3',valu:$mail3='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    if (isset($_POST['namechck']))  { $namechck = 'checked'; }        
    htm_Input(labl:'@Mailing',plho:'@Enter...',icon:'',hint:'@Demo of htm_Input Field type chck: Multi-line formatted chck-text',
              vrnt:'chck',name:'chck3',valu:$chck3='',form:'',wdth:$wdh,algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[['namechck','@Mailing active','@Use mail',$namechck ?? '']],llgn:'R',bord:'',ftop:'');

    htm_nl(1);
    htm_Input(labl:'@Created',plho:'@Address town...',icon:'',hint:'@Demo of htm_Input Field type date with browser popup selector',
              vrnt:'date',name:'datr',valu:$date ?? '',form:'',wdth:'48%',algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Input(labl:'@Changed',plho:'',icon:'',hint:'@Demo of htm_Input Field type date with browser popup selector',
              vrnt:'date',name:'dath',valu:$date ?? '',form:'',wdth:'48%',algn:'left',attr:$m,rtrn:false,
              unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'',ftop:'');

    htm_Card_00(labl:'Save', icon:'', hint:'@Save data in this card', 
                name:'', form:'xxx',subm:true, attr:'', akey:'s', kind:'save', simu:false);
    
    // htm_RowCol_next($RowColWdth=480);
    
    htm_Card_0(capt: '@How creating cards:',icon: 'fas fa-info',hint: '',
               form: '',acti: '',clas: 'cardW560',wdth: '',styl: 'background-color: white;',attr: '');
    htm_TextDiv('To build a card there are 2 functions: <br><br>
        <b>htm_Card_0()</b> - prepares the start of a card.<br>
        and: <br>
        <b>htm_Card_00()</b> - finalize the card.     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>
        ');
        htm_Card_0(capt: '@PHP Source-code:',icon: 'fas fa-code',hint: '',
                   form: '',acti: '',clas: 'cardW560',wdth: '',styl: 'background-color: white;',attr: '');

$strCode= "
htm_Card_0(capt: '@PHP Source-code:',        # string: The card caption
           icon: 'fas fa-code',              # string: Class: icon to the left of caption
           hint: '',                         # string: The hint on hover caption
           form: '',                         # string: form id/name (No form without a name)
           acti: '',                         # string: form action 
                                             
           clas: 'cardW480',                 # string: The card class (general CSS-data)
           wdth: '',                         # string: The closed card width
           styl: 'background-color: white;', # string: The card body style
           attr: '',                         # string: general attributes (style) for the card-container
           
           show: true,                       # bool:   Show card-buttons top-right
           head: '',                         # string: Style for Header background
           vhgh: '600px',                    # string: MaxHeight (ViewHeight) for span (HideBody) with scrollable content
           help: ''                          # string: Link to custom Card-help
);

// Placed here the cardcontent...
htm_Card_00();
        ";
            htm_CodeDiv(highlight_words(highlight_str($strCode,true)));

        htm_Card_00();
    htm_Card_00();
    
    htm_Card_0(capt: '@How do you manage cards:',icon: 'fas fa-info',hint: '',
               form: '',acti: '',clas: 'cardW560',wdth: '',styl: 'background-color: white;',attr: '');
    htm_TextDiv('
        The Card header is always visible, and you can click on:<br>
        <i>Header</i> to: Show or hide the body.<br>
        <i>Icon</i> <i class="fas fa-question"></i>: to open a window with help for this card/page<br>
        <i>Icon</i> <i class="fas fa-angle-double-down"></i>: to Show content in all cards on the page<br>
        <i>Icon</i> <i class="fas fa-angle-double-up"></i>: to Hide content in all cards on the page<br>
        <i>Icon</i> <i class="fa-solid fa-right-left"></i>: to Toggle the actual card between normal- and max-width<br>
        <i>Icon</i> <i class="fas fa-arrows-alt-v"></i>: to Toggle the actual card between normal- and max-height<br>
        <br>
        Hover the mouse, and mouse cursor will change and a hint will be shown.<br>
        <br>
        If you right-click card-header a popup menu regarding all cards will be displayed<br>
        ');
    htm_Card_00();
    
    htm_RowCol_00();
    
    CardOff($First=2,$Last=3); // Close card 2 and 3 on page open
htm_Page_00();
### :PAGE_END
    CardOff($First=5,$Last=5);

?>