<?php   $DocFil= './Proj.demo/CustomerOrder.page.php';    $DocVer='1.2.0';    $DocRev='2022-05-31';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php');

## Speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                         CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',                  'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',          'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
// define('LIB_FONTAWESOME',   [1, '_assets/font-awesome5/5.15.4/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/']);
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome6/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome6/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN _assets/font-awesome6/js/all.js

### SPECIAL this page only:
require_once('../Data.demo/datainit.inc.php');

function refresh($name) {if (isset($_POST[$name]))  {$_SESSION[$name]= $$name= htmlspecialchars($_POST[$name]); return $$name; } } //  A variabel with name: $name is updated and remembered in _SESSION. The value is returned
function set_FormVars ($names) { foreach ($names as $name) $$name= refresh($name); }  //  No: $$name is not a typeerror. It is the value of the variable with the name $name
function get_FormVars ($names) { foreach ($names as $name) $$name= $_SESSION[$name] ?? ''; }
function dev_show() { if ($GLOBALS["Ødebug"]) {echo 'SESSIONS variablers indhold: ';  vis_data($_SESSION);} }

function indxCheck(&$arrData,$name,$pref='') {
    $id= -1;    $arrTemp= [];
    if ($arrData)
        foreach ($arrData as $rec) {
        if ($rec[$name]=='') {$id= $id+1; $rec[$name]=$pref.$id; } else $id= $rec[$name];
        $arrTemp[]= $rec;
    } $arrData= $arrTemp;
}

// session_destroy();  //  Slet alle SESSIONS variabler (Luk browser, sletter ikke ! ?)
/*
arrPrint($_SESSION,'$_SESSION');
arrPrint($_POST,'$_POST');
/*     */
global $lang;
       
$test= false;
$KIS = false;

if ($test) arrPrint($_POST,'$_POST');

##### DATA EXCHANGE:
$dPath= '../Data.demo/';

### SAVE to database:    (DEMO: to files)
# UPDATE files:
$savedBytes= 0;
# activated buttons:
if (isset($_POST['btn_sav_orders'  ])) { tabl2arr($arrOrders,'ord_id',['ord_total']); 
                                                                $savedBytes+= FileWrite_arr($dPath.$filepath= 'arrOrders.dat.json',$arrOrders );}
//if (false)
if (isset($_POST['btn_sav_content' ])) { tabl2arr($arrContent,'cnt_post',['cnt_price', 'cnt_total']);  
                                                                $savedBytes+= FileWrite_arr($dPath.$filepath='arrContent.dat.json',$arrContent);}
if (isset($_POST['btn_sav_customr' ])) { form2arr($arrCustomr); $savedBytes+= FileWrite_arr($dPath.$filepath='arrCustomr.dat.json',$arrCustomr);}
if (isset($_POST['btn_sav_billing' ])) { form2arr($arrBilling); $savedBytes+= FileWrite_arr($dPath.$filepath='arrBilling.dat.json',$arrBilling);}
if (isset($_POST['btn_sav_deliver' ])) { form2arr($arrDeliver); $savedBytes+= FileWrite_arr($dPath.$filepath='arrDeliver.dat.json',$arrDeliver);}
if (isset($_POST['btn_sav_conditi' ])) { form2arr($arrConditi); $savedBytes+= FileWrite_arr($dPath.$filepath='arrConditi.dat.json',$arrConditi);}
if (isset($_POST['btn_sav_mailinv' ])) { form2arr($arrMailing); $savedBytes+= FileWrite_arr($dPath.$filepath='arrMailing.dat.json',$arrMailing);}
if (isset($_POST['btn_sav_contact' ])) { form2arr($arrContact); $savedBytes+= FileWrite_arr($dPath.$filepath='arrContact.dat.json',$arrContact);}
if (isset($_POST['btn_sav_custFld' ])) { form2arr($arrCustfld); $savedBytes+= FileWrite_arr($dPath.$filepath='arrCustfld.dat.json',$arrCustfld);}
if (isset($_POST['btn_sav_cvrform' ])) {}    // Use CVR-data
if (isset($_POST['btn_sav_language'])) { $lang = $_POST['language']; }
if (isset($_POST['btn_cre_contact' ])) {  }  // Create new
if (isset($_POST['btn_era_contact' ])) {  }  // Erase contact
if (isset($_POST['btn_goo_doLookup'])) {  }  // Opslag
if (isset($_POST['btn_cre_doInvo'  ])) {  }  // Dan Faktura
if (isset($_POST['btn_cre_doNote'  ])) {  }  // Dan Følgeseddel
if (isset($_POST['btn_hom_doCredit'])) {  }  // Krediter
if (isset($_POST['btn_era_doErase' ])) {  }  // Slet



### READ from database:    (DEMO: from files)
# INIT variables:
$i= 0;
$arrNames= ['arrCustomr','arrBilling','arrDeliver','arrConditi','arrMailing','arrContact','arrCustfld','arrOrders' ,'arrContent'];
foreach ($arrNames as $arr) $$arr= json_decode(file_get_contents($dPath.$arr.'.dat.json'), true);
// print_r($arrCustomr);
/* 
foreach ($arrNames as $arr) echo ' '.$i++ .': '.$arr.' ';
echo '<br>';
 */
//foreach ($arrNames as $name) $$name= []; 

/* 
if (DEBUG) run_Script('$Timers->startTimer("fread");');
//$test= 
FileRead_arr($dPath, $arrNames);
if (DEBUG) run_Script('$Timers->endTimer("fread");');
echo '<br>('.$test.')';
 foreach ($arrNames as $arr) echo $i++ .': '.$$arr;
echo '<br>';
print_r($arrCustomr);
 */
 
# Add index if empty:
indxCheck($arrOrders,$name='ord_id',$pref='000'); 
indxCheck($arrContent,$name='cnt_post'); 

/** /
$arrContact= [    // DEMO-data:
    [ 'indx'  => 'INDX'   ,
      'name'  => 'ANDERS' ,
      'titel' => 'TITLE1' ,
      'phone' => 'PHONE1' ,
      'mobil' => 'MOBILE1',
      'email' => 'MAIL1@XXX'  ,
      'remark'=> 'REMARK1'
    ],
    [ 'indx'  => 'INDX'   ,
      'name'  => 'ANDERSINE' ,
      'titel' => 'TITLE2' ,
      'phone' => 'PHONE2' ,
      'mobil' => 'MOBILE2',
      'email' => 'MAIL2@XXX'  ,
      'remark'=> 'REMARK2'
    ]
];
//$arrContact= json_decode(json_encode($arrContact), true);
/**/


##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_Page_0

### From here this demo is written for PHP 8+ ! 
### (the vars order is maintained and default vars is not excluded)

htm_Page_0(titl:'@OrderCreate.page.php',hint:'@Tip: Toggle fullscreen-mode with function key: F11',
           info:'@Example: Customer-ORDER Build with <b style="color:darkgreen;">PHP2HTML</b>',
           inis:'',algn:'center', gbl_Imag:'',attr:'background: linear-gradient(0deg,#03a9f4 0%,#e3f2fd);',gbl_Bord:false);
    Menu_Topdropdown(true); 
    htm_nl(0);


if ($test) echo '<pre>'.$log.'</pre>'. '<br>Saved: '.$savedBytes.' bytes to data-files.<br>';
//arrPrint($transTable['da']['Data-field in new record'],'$transTable');  // ->  'Datafelt i ny rekord'
//arrPrint($transTable['da']['Billing:'],"transTable['da']['Billing:'");

    //echo '<b>Cloud-Accounting</b><br>';
    //  #$labl='',$icon='',$hint='',$algn='',$styl='color:#550000; font-weight:600; font-size: 13px;');
    // htm_Caption($labl='Tiny-Cloud-Accounting',$icon='',$hint='',$algn='center',$styl='color:'.$gbl_TitleColr.'; font-weight:600; font-size: 18px;');
    
    htm_Fieldset_0(capt:'Tiny-Cloud-Accounting<br>Customer Order',icon:'',hint:'',wdth:'80%',marg:'',attr:'Color: green; font-weight: bold; background-color: white; border-radius: 4px; ',rtrn:false);
    htm_nl(1);
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    htm_Panel_0(capt: '@Find existing order:',icon: 'fas fa-search',hint: '',form: 'orders',acti: '',clas: 'panelW960',wdth: '',styl: 'background-color: rgba(240, 240, 240, 0.80);',attr: '');

        htm_Table(
            $TblCapt= array(
                    ['@Customer orders', 'Width', 'html', 'OutFormat', 'horJust', 'Tip', '', '']
                ),
            $RowPref= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'                                          ], ['Next record'],...
                ),
            $RowBody= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_etc]', '5:fldKey', '6:ColTip','7:placeholder','8:default','9:[selectList]'], ...
                    ['@id',           '8%','show', '',  ['center'], 'ord_id',      '@id number maintained by the system',          '..auto..'],
                    ['@Order',        '9%','indx', '',  ['center'], 'ord_ix',      '@Order number',                                '@Numb...'],
                    ['@Order Date',   '4%','date', '',  ['left'  ], 'ord_odate',   '@Order Date',                                  'YYYY-MM-DD'],
                    ['@Deliv. date',  '4%','date', '',  ['left'  ], 'ord_ddate',   '@Delivery date',                               'YYYY-MM-DD'],
                    ['@Account',      '8%','text', '',  ['center'], 'ord_acco',    '@Debtor Account number',                       '@Acco...'],
                    ['@Company name','34%','text', '',  ['left'  ], 'ord_name',    '@Company name',                                '@Firm...'],
                    ['@Seller',       '7%','text', '',  ['left'  ], 'ord_sell',    '@The employer with contact to the customer',   '@Sell...'],
                    ['@Amount',      '10%','text', '2d',['right' ], 'ord_amou',    '@The total order sum',                         '@Amount...'],
                    ['@Currency',     '4%','ddwn', '',  ['center'], 'ord_currency','@Currency code for the currency used on the specification.','@Curr...','',[CurrencyArr(),'width: 55px;']],
                    ['@Maturity',     '4%','date', '',  ['center'], 'ord_duedate', '@Due date of the amount',                      '@Due...'],
                    ['@Status',       '9%','ddwn', '',  ['left'  ], 'ord_stat',    '@Status','@Status...',  '', [OrdrStatu(),'width: 70px;']], //  ORD_Status()
                ),
            $RowSuff= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!'], ['Next record'],...
                ),           # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON]
            $TblNote= '',    # HTML-string
            /* $TblData=  */ 
            $arrOrders,
            $FilterOn= true,     
            $SorterOn= true,     
            $CreateRec=false,    
            $ModifyRec=true,     
            $ViewHeight= '200px',
            $TblStyle= '',       
            $CalledFrom= __FUNCTION__
          );
    htm_Panel_00(labl:'', icon:'', hint:'', name:'', form:'',subm:false, attr:'', akey:'', kind:'save', simu:false);

    htm_Panel_0(capt: '@Create new or modify order:',icon: 'fas fa-pen',hint: 'Demo ! <br>No connection to a DataBase. <br>Read/save from/to JSON-files.',
                form: '',acti: '',clas: 'panelW960',wdth: '',styl: 'background-color: rgba(240, 240, 240, 0.80);',attr: '');

        htm_Panel_0(capt: 'Customer:',icon: 'fas fa-user',hint: '',
                    form: 'customr',acti: '',clas: 'panelW280',wdth: '',styl: 'background-color: white;',attr: '');
            htm_Input(labl:'@Customer nr.',             plho:'@..auto..',                icon:'',hint:'@Customer nr: Can not be edited, onlu created. The system sets this',
                      type:'text',name:$n='custkont',   valu:$arrCustomr[$n],   form:'',wdth:'50%');
            htm_Input(labl:'@Customer Lookup',          plho:'',                icon:'',hint:'@Here you select which existing customer to select',                 
                      type:'opti',name:$n='custopsl',   valu:$arrCustomr[$n],   form:'',wdth:'50%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); //CustList());
            htm_Input(labl:'@Customer type',            plho:'',                icon:'',hint:'@Customer kategori',                                                 
                      type:'rado',name:$n='custkate',   valu:$arrCustomr[$n],   form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'',list:[['priv', '@private', '@private'], ['prof', '@professional', '@professional']]);                                                                                                                                 
            htm_Input(labl:'@CVR',                      plho:'@Business only !',icon:'',hint:'@CVR - Virksomheds ID.',                                             
                      type:'text',name:$n='cust_cvr',   valu:$arrCustomr[$n],   form:'',wdth:'100%',algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid green;');
            htm_Input(labl:'@EAN',                      plho:'@Business only !',icon:'',hint:'@EAN - Elektronisk-betalings ID',                                    
                      type:'text',name:$n='cust_ean',   valu:$arrCustomr[$n],   form:'',wdth:'100%',algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid green;');
            htm_Input(labl:'@Bank reg.',                plho:'Reg...',          icon:'',hint:'@Bank reg.',                                                         
                      type:'text',name:$n='custbreg',   valu:$arrCustomr[$n],   form:'',wdth: '33%');          
            htm_Input(labl:'@Bank account',             plho:'Account...',      icon:'',hint:'@Bank account',                                                      
                      type:'text',name:$n='custbkto',   valu:$arrCustomr[$n],   form:'',wdth: '66%');          
            htm_Input(labl:'@Institution',              plho:'@Business only !',icon:'',hint:'@Additional information',                                            
                      type:'text',name:$n='custinst',   valu:$arrCustomr[$n] ,  form:'',wdth:'100%',algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid green;');
            htm_Input(labl:'@Customer manager',         plho:'@Mana...',        icon:'',hint:'@Customer manager',                                                  
                      type:'text',name:$n='custansv',   valu:$arrCustomr[$n],   form:'',wdth:'100%');          
            htm_Input(labl:'@Billing Language',         plho:'@if the language is not local',icon:'',hint:'@The language to be used on invoice transcripts',                    
                      type:'text',name:$n='custlang',   valu:$arrCustomr[$n],   form:'',wdth:'100%',algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'R',bord:'border: 1px solid green;');
            htm_Input(labl:'@Homepage',                 plho:'@Business only!', icon:'',hint:'@The customer Homepage',                                             
                      type:'text',name:$n='custhome',   valu:$arrCustomr[$n],   form:'',wdth:'100%',algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid green;');
            htm_MiniNote('<span class="colrorange">'.lang('@Orange ').'</span>'.lang('@frames are required fields.'));
            htm_MiniNote('<span class="colrgreen">' .lang('@Green ').'</span>'. lang('@frames - restricted use.'));
        htm_Panel_00(labl:'@Save', icon:'', hint:'', name:'', form:'',subm:true, attr:'', akey:'', kind:'save', simu:false);;


        htm_Panel_0(capt: 'Billing:',icon: 'fas fa-pen',hint: '',form: 'billing',acti: '',clas: 'panelW280',wdth: '',styl: 'background-color: white;',attr: '');
            htm_Input(labl:'@Order info',               plho:'@Order:... Date:...',icon:'',hint:'@@Systemfield: Auto fill out, when order is created/saved',
                      type:'area',name:$n='billoref',   valu:$arrBilling[$n] ?? '',form:'', wdth:'100%',algn:'left',attr:'',   rtrn:false,unit:'',disa:true,rows:'1');
            htm_Input(labl:'@Customer name',            plho:'@Name...',              icon:'',hint:'@Enter costomer name',                                     
                      type:'text',name:$n='billnavn',   valu:$arrBilling[$n], form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Customer address',         plho:'@Address...',           icon:'',hint:'@Enter invoice address',                                   
                      type:'text',name:$n='billaddr',   valu:$arrBilling[$n], form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Customer place',           plho:'@Place...',             icon:'',hint:'@Enter invoice place',                                     
                      type:'text',name:$n='billsted',   valu:$arrBilling[$n], form:'');    
            htm_Input(labl:'@ZIP',                      plho:'@ZIP...',               icon:'',hint:'@ZIP code',                                                
                      type:'text',name:$n='billponr',   valu:$arrBilling[$n], form:'',wdth:'30%', algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Invoice city',             plho:'@City...',              icon:'',hint:'@Invoice city',                                            
                      type:'text',name:$n='billbynv',   valu:$arrBilling[$n], form:'',wdth:'68%', algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Invoice Country',          plho:'@Country...',           icon:'',hint:'@Invoice Country',                                         
                      type:'text',name:$n='billland',   valu:$arrBilling[$n], form:'');
               htm_hr($gbl_TitleColr.'; height: 2px');                                                                                                                                                      
            htm_Input(labl:'@Phone(s)',                 plho:'@Phone...',             icon:'',hint:'@Phone, mobil, fax',                                       
                      type:'text',name:$n='billtelf',   valu:$arrBilling[$n], form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Attention',                plho:'@Att...' ,              icon:'',hint:'@Attention - Customer contact',                            
                      type:'text',name:$n='bill_att',   valu:$arrBilling[$n], form:'');
            htm_Input(labl:'@Réquisition number',       plho:'@Ref...' ,             icon:'',hint:'@Customer reference to order',                             
                      type:'text',name:$n='billrekv',   valu:$arrBilling[$n], form:'');
            htm_Input(labl:'@Email address',            plho:'@Mail...',              icon:'',hint:'@Customer Email address',                                  
                      type:'text',name:$n='billmail',   valu:$arrBilling[$n], form:'');
            htm_Input(labl:'@Remarks',                  plho:'@Rem...' ,              icon:'',hint:'@Notes regarding the customer',                            
                      type:'text',name:$n='billnote',   valu:$arrBilling[$n], form:'');
            if (isset($_POST['use_mail'])) { $use_mail = 'checked'; } 
            htm_Input(labl:'@Mailing',                  plho:'@...',                  icon:'',hint:'@Send invoice with mail',                                  
                      type:'chck',name:$n='use_mail',   valu:$arrBilling[$n], form:'',wdth:'50%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list: [['use_mail','@Use mail','@Mailing for this order is active',$namechck ?? '']]);
            htm_Input(labl:'@Order Date',               plho:'@Date...',              icon:'',hint:'@Dato for ordrens oprettelse',                             
                      type:'date',name:$n='ordrdato',   valu:$arrBilling[$n], form:'',wdth:'50%');
            htm_Input(labl:'@Invoice Date',             plho:'@Date...',              icon:'',hint:'@Invoice Date',                                            
                      type:'date',name:$n='faktdato',   valu:$arrBilling[$n], form:'',wdth:'50%');
            htm_Input(labl:'@Rebills',                  plho:'@Date...',              icon:'',hint:'@When to rebill date',                                     
                      type:'date',name:$n='gen_fakt',   valu:$arrBilling[$n], form:'',wdth:'50%');
            htm_MiniNote('<span class="colrorange">'.lang('@Orange ').'</span>'.lang('@frames are required fields.'));
            
        htm_Panel_00(labl:'Save', icon:'', hint:'', name:'', form:'',subm:true, attr:'', akey:'', kind:'save', simu:false);;


        htm_Panel_0(capt: 'Delivery:',icon: 'fas fa-truck',hint: '',form: 'deliver',acti: '',clas: 'panelW280',wdth: '',styl: 'background-color: white;',attr: '');
            htm_Input(labl:'@Delivered to invoice address',          plho:'Name...',  icon:'',hint:'@Check here if the delivery address is the same as the invoice address',
                      type:'chck', name:$n='sameaddr',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',
                      list: [['sameaddr','@Same address','@Automatic fillout with the same address as invoice',$namechck ?? '']]);
            htm_Input(labl:'@Recipient Name',           plho:'Name...',  icon:'',hint:'@Enter Recipient Name',                                             
                      type:'text', name:$n='deliname',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@Delivery Address',         plho:'Addr..',   icon:'',hint:'@Enter Delivery Address',                                           
                      type:'text', name:$n='deliaddr',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@Place of Delivery',        plho:'Sted...',  icon:'',hint:'@Specify Place of Delivery, supplement to address',                 
                      type:'text', name:$n='deliplac',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%');
            htm_Input(labl:'@ZIP',                      plho:'Pnr..',    icon:'',hint:'@Enter Delivery Customer postcode',                                 
                      type:'text', name:$n='deli_zip',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'30%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@City Name',                plho:'City..',   icon:'',hint:'@Enter Delivery City name',                                         
                      type:'text', name:$n='delicity',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'68%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@Delivery Country',         plho:'Contry...',icon:'',hint:'@Specify Delivery Country',                                         
                      type:'text', name:$n='delicoun',  valu: $arrDeliver[$n]  ?? '');
            htm_hr($gbl_TitleColr.'; height: 2px');
            htm_Input(labl:'@Phone(s)',                 plho:'Phone..' , icon:'',hint:'@Enter Recipient`s Phone',                                          
                      type:'text', name:$n='deliphon',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Contact person at the delivery address',plho:'Name...' , icon:'',hint:'@Enter Contact Name',                                               
                      type:'text', name:$n='delikont',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Recipient`s Email Address',plho:'Mail...' , icon:'',hint:'@Enter Recipient`s Email Address',                                  
                      type:'mail', name:$n='delimail',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Shipping Method.',         plho:'Shipp...', icon:'',hint:'@Enter Shipping Information. How / with whom was the package sent?',
                      type:'text', name:$n='shipmeth',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Notes to freight forwarder',plho:'Note...',  icon:'',hint:'@Notes regarding package delivery',                                 
                      type:'area', name:$n='delinote',  valu: $arrDeliver[$n]  ?? '',form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Status',                   plho:'@Enter...',icon:'',hint:'@Once the service has been sent, amounts can be redeemed',          
                      type:'chck', name:$n='shipped_',  valu: $arrDeliver[$n]  ?? '',form:'',wdth:'50%',algn:'left', attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',
                      list: [['shipped_','@Are shipped','@Ready for redemption',$shipped_ ?? '']]);           
           #htm_Input(# $labl='',$plho='@Enter...',$icon='',$hint='',$type= 'text',$name='',$valu='',form:'',$wdth='',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='2',$step='',$list=[],$llgn='R',$bord='',$ftop='');
            htm_Input($labl='@Delivery Date',plho:'@Enter...',icon:'',hint:'@Possibly. shipment date',
                      type:'date', name:$n='lev_dato', valu: $arrDeliver[$n]  ?? '', form:'',wdth:'50%'   );

            $delName= $arrDeliver['deliname'] ?? '';
            $delAddr= $arrDeliver['deliaddr'] ?? '';
            $delPlac= $arrDeliver['deliplac'] ?? '';
            $del_Zip= $arrDeliver['deli_zip'] ?? '';
            $delCity= $arrDeliver['delicity'] ?? '';
            if ($arrCustomr['custkate']=='prof') $register='/firma'; else $register='/personer';
            htm_LinkButt(  $labl='@Address on map', $gotoLink='https://krak.dk/'. $arrDeliver['deliname'] ?? ''.'+'.$arrDeliver['deliaddr'].'+'.$arrDeliver['deli_zip'].'+'.$arrDeliver['delicity'].$register, $hint='@Show address on map', $target='_blank');
            htm_AcceptButt($labl='@Delivery note', $hint='@Show delivery note for delivery', $btnKind='sear', $frmName='deliver', $width='', $akey='l', $rtrn=false,  $tipplc='LblTip_text', $tipstyl='',
                            $clickFunction="toast(\"<b>DEMO:</b><br>$delName <br>$delAddr <br>$delPlac <br>$del_Zip - $delCity\",\"lightyellow\",\"black\")");
            htm_MiniNote('<span class="colrblue">'.lang('@Blue ').'</span>'.lang('@frames and customer type, Used for map lookup.'));
            //htm_MiniNote('@Blue frames and customer type, Used for map lookup.');
                    # $labl='', $icon='', $hint='', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false)
        htm_Panel_00( labl:'Save',icon:'',hint:'',name:'',form:'', subm:true,attr:'',akey:'',kind:'save',simu:false);;

if ($KIS!=true) {

        // htm_TextDiv('@From here the source code are written for PHP8+ ONLY !','','','',$styl='background-color: lightyellow;');
        htm_Panel_0( capt: 'Conditions:', icon: 'far fa-credit-card', hint: '',
                     form: 'conditi', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
//  htm_Panel_0($frmName='conditi', $capt=lang('Conditions:'), $parms='', $icon='far fa-credit-card', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            #htm_Input($type='opti',$name='faktbynv',$valu=$arrCustomr[$name], $labl='@Faktura By',  $hint='@Faktura by', $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$attr='',$plho='@Bynavn...');
            htm_Input(labl:'@Debtor group',      /*plho:'',      icon:'',*/ hint:'@Choose which group the customer belongs to',     type:'opti', name:'debigrup', valu: $arrConditi['debigrup'],form:'',wdth:'100%',  algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Grup() );
            htm_Input(labl:'@Payment method',    /*plho:'',      icon:'',*/ hint:'@How to pay',                                     type:'opti', name:'betaling', valu: $arrConditi['betaling'],form:'',wdth:'100%',  algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Betl() );
            htm_Input(labl:'@Payment deadline',  /*plho:'',      icon:'',*/ hint:'@How long is the deadline for payment',           type:'opti', name:'betfrist', valu: $arrConditi['betfrist'],form:'',wdth:'100%',  algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Frist() );
            htm_Input(labl:'@Print to',          /*plho:'',      icon:'',*/ hint:'@Choose how to print, save or send the document.',type:'opti', name:'print_to', valu: $arrConditi['print_to'],form:'',wdth:'68%',   algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Dok() );
            htm_Input(labl:'@Customer reference',/*plho:'Ref...',icon:'',*/ hint:'@for example. Requisitions no',                   type:'text', name:'kunderef', valu: $arrConditi['kunderef'],form:'',wdth:'100%');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);
//  htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


        htm_Panel_0( capt: 'Mail-invoice:', icon: 'fas fa-envelope', hint: '',
                     form: 'mailinv', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
//  htm_Panel_0($frmName='mailinv', $capt=lang('Mail-invoice:'), $parms='', $icon='fas fa-envelope', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input(labl:'@Mail subject',                                          plho:'@Subj...',icon:'',hint:'@Enter Mail subject',                                             type:'text',name:'mailemne', valu:$arrMailing['mailemne']);
            htm_Input(labl:'@Mail message',                                          plho:'@Mess...',icon:'',hint:'@Enter Mail text',                                                type:'area',name:'mailtext', valu:$arrMailing['mailtext']);
            htm_Input(labl:'<i class=\'fas fa-paperclip\'></i> '.lang('@Mail Annex'),plho:'@Annex..',icon:'',hint:'@Enter Attached file',                                            type:'file',name:'mailvedh', valu:$arrMailing['mailvedh']);
            htm_Input(labl:'@Copy to',                                               plho:'Copy...' ,icon:'',hint:'@Enter mail address to receive one copy of send mail',            type:'text',name:'mail__cc', valu:$arrMailing['mail__cc']);
            htm_Input(labl:'@Blind-copy to',                                         plho:'BCopy...',icon:'',hint:'@Enter mail address to receive one BC-copy (hidden) of sent mail',type:'text',name:'mail__bc', valu:$arrMailing['mail__bc']);
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);
//  htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


        htm_Panel_0( capt: 'Person contact:', icon: 'fas fa-phone-square', hint: '',
                     form: 'contact', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
//  htm_Panel_0($frmName='contact', $capt=lang('Person contact:'), $parms='', $icon='fas fa-phone-square', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            function ContaktPers($arrCont,$value,$no='') {
                htm_Input(labl:'@No.',           plho:'@auto',        icon:'',hint:'@Specifies the order of the entries',type:'text',name:'indx' ."[$no]", valu:$arrCont['indx' ]["$no"] ?? '',form:'',wdth:'15%', algn:'center', attr:'',rtrn:false,unit:'',disa:true,rows:'3',step:'1');
                htm_Input(labl:'@Contact person',plho:'@Kont...',     icon:'',hint:'@Enter Contact person',              type:'text',name:'name' ."[$no]", valu:$arrCont['name' ]["$no"],form:'',wdth:'50%');
                htm_Input(labl:'@Titel',         plho:'@Titl...',     icon:'',hint:'@Enter the persons titel',           type:'text',name:'titel'."[$no]", valu:$arrCont['titel']["$no"],form:'',wdth:'35%');
                htm_Input(labl:'@Phone',         plho:'@Pho...',      icon:'',hint:'@Enter phone number',                type:'text',name:'phone'."[$no]", valu:$arrCont['phone']["$no"],form:'',wdth:'50%');
                htm_Input(labl:'@Mobil',         plho:'@Mobil/lok...',icon:'',hint:'@Enter Mobilnr. or  lokal',          type:'text',name:'mobil'."[$no]", valu:$arrCont['mobil']["$no"],form:'',wdth:'50%', algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3');
                htm_Input(labl:'@E-mail',        plho:'@Mail...',     icon:'',hint:'@Enter E-mail',                      type:'mail',name:'email'."[$no]", valu:$arrCont['email']["$no"],form:'',wdth:'80%');
                htm_Input(labl:'@Remark',        plho:'@Note...',     icon:'',hint:'@Enter note to the contact, e.g. role (director / secretary / driver)',type:'area',name:'remark'."[$no]",valu: $arrCont['remark']["$no"],form:'',wdth:'80%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'1');

                htm_hr('lightgray');
                # $labl='',$icon,$hint='',$form='',$wdth='',$attr,$akey='',$kind='',$rtrn=true,$tipplc='LblTip_text',$tipstyl='',$clicking='',$idix='');
                htm_AcceptButt( labl:'@Delete',  icon:'',hint:'@Remove this contact person <br> (DEMO yet!)', form:'contact_'.$no, wdth:'', attr:'', akey:'',kind:'eras', rtrn:false, tplc:'', tsty:'position: absolute; bottom: 8px;', acti:'toast("Remove contact<br>Cant do it yet !","lightyellow","black")');
                htm_hr('green'.'; height: 2px');
                htm_nl(1);
            }
    //      arrPrint($arrContact,'$arrContact');
    //      foreach ($arrContact as $key => $value)  ContaktPers($arrContact,$value,$no=$i++);
            if ($arrContact) { 
                if (is_array($arrContact['indx'] ?? '')) $max= count($arrContact['indx']); else $max= 1;
                for ($i= 0; $i < $max; $i++) { ContaktPers($arrContact,$value ?? '',$no=$i); }
            }
            else htm_Caption('@Ingen oprettede kontakter.');
            htm_AcceptButt( labl:'@Create new',  icon:'', hint:'@Create a new contact <br> (DEMO yet!)',  form:'contact',  wdth:'',  attr:'', akey:'', kind:'crea', rtrn:false, tplc:'', tsty:'position: absolute; bottom: 8px;', acti:'toast("Create contact<br>Cant do it yet !","lightyellow","black")');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);
//  htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

        $body= '<i>Business only !</i><br>
            Copy or check data in the public company register.<br>
            Data is provided by CVR API<br><br>';

        htm_Panel_0( capt: 'CVR-lookup:', icon: 'fas fa-database', hint: '',
                     form: 'cvr', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
//  htm_Panel_0($frmName='cvrform', $capt=lang('CVR-lookup:'), $parms='', $icon='fas fa-database', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Fieldset_0( capt:'Lookup in the CVR register:', icon:'', hint:'', wdth:'', marg:'', attr:'font-size: smaller; ', rtrn:false);
         // htm_TextDiv(#$body,$algn='left',$marg='8px',$styl='box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',$attr='background-color: white; ');
            
            htm_TextDiv($body,algn:'left',marg:'8px',styl:'',attr:'');
            set_FormVars(['cvrLand','cvrKode','cvrSoeg'/*, 'cvrNumm','cvrNavn','cvrTelf','cvrAddr','cvrPost','cvrBy','cvrDiv' */]);  // Opdater alle variabler på form 'cvrform' :
            get_FormVars(['cvrLand','cvrKode','cvrSoeg']);
        #      dev_show(); //  echo 'SESSIONS variablers indhold: ';  vis_data($_SESSION);
                $cvrLand= $_SESSION['cvrLand'] ?? '';   if (!$cvrLand) $cvrLand= 'dk';
                $cvrKode= $_SESSION['cvrKode'] ?? '';   if (!$cvrKode) $cvrKode= 'search';
                $cvrSoeg= $_SESSION['cvrSoeg'] ?? '';
                if (($cvrLand) and ($cvrKode) and ($cvrSoeg)) //  Klar til søgning
                { $url= 'https://cvrapi.dk/api?'.$cvrKode.'='.$cvrSoeg.'&country='.$cvrLand;   //  https://cvrapi.dk/api?search=$cvrSoeg&country=dk  Generel søgning    //  https://cvrapi.dk/api?phone=$cvrSoeg&country=dk   specifikt telefonnr
                    $content = file_get_contents($url, false, stream_context_create(['http' => ['user_agent' => 'any']]));
                    // FIXIT: Forebyg: "Failed to open streem" ved:  "404 Not Found"
                    $svar= json_decode($content, true);
                    if ($svar['vat']) { $cvrDiv= '';
                        $cvrNumm= $svar['vat'];
                        $cvrNavn= $svar['name'];
                        $cvrAddr= $svar['address'];
                        $cvrPost= $svar['zipcode'];
                        $cvrBy  = $svar['city'];
                        $cvrTelf= $svar['phone'];
                        if ($svar['email'])                                  {$cvrDiv.= lang('@Mail').': '. $svar['email'].'&#xa;';}
                        if ($svar['fax'])                                    {$cvrDiv.= lang('@Fax ').': '. $svar['fax'].'&#xa;';}
                        if ($svar['cityname'])                               {$cvrDiv.= lang('@Place').': '.$svar['cityname'].'&#xa;';}
                        if ($svar['companydesc'])                            {$cvrDiv.= lang('@Type').': '. $svar['companydesc'].'&#xa;';}
                        $ix= 0; while ($svar['owners'][$ix]['name'])         {$cvrDiv.= lang('@Ovner').': '.$svar['owners'][$ix]['name'].'&#xa;'; $ix++;}
                        $ix= 0; while ($svar['productionunits'][$ix]['pno']) {$cvrDiv.= lang('@P-nr').': '. $svar['productionunits'][$ix]['pno'].'&#xa;'; $ix++;}
                    }
                }
            htm_Input(labl:'@Land registry',       plho:'',                icon:'',hint:'@In what country do you want to apply?',                       type:'opti', name:'cvrLand', valu: $cvrLand='dk',    form:'',wdth:'50%', algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list: CVR_Land(), llgn:'R',bord:'border: 1px solid green;');
            htm_Input(labl:'@Search for',          plho:'',                icon:'',hint:'@What do you know?',                                           type:'opti', name:'cvrKode', valu: $cvrKode='search',form:'',wdth:'50%', algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list: CVR_Liste(),llgn:'R',bord:'border: 1px solid green;');
            htm_Input(labl:'@CVR/P-uni./Phon/Name',plho:'@Business only !',icon:'',hint:'@Enter here, data or company name that you want to search for',type:'text', name:'cvrSoeg', valu: $cvrSoeg,         form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],          llgn:'R',bord:'border: 1px solid green;');
            htm_MiniNote('<span class="colrgreen">'.lang('@Green ').'</span>'.lang('@frames are the basis for entry in the CVR.'));
            htm_hr('lightgray');
            htm_AcceptButt( labl:'@Search',  icon:'', hint:'@Start search in the CVR register', 
                            form:'cvrform', wdth:'', attr:'', akey:'s', kind:'crea', rtrn:false, tplc:'LblTip_text', tsty:'', acti:'', idix:'');
            htm_Fieldset_00();
            
            // htm_hr('green');
            htm_Fieldset_0( capt:'Register data:', icon:'', hint:'', wdth:'', marg:'', attr:'font-size: smaller;', rtrn:false);
            htm_nl();
            // htm_TextDiv($content='<small>'.lang('Register data:').'</small>', $align='left',$marg='8px',$attr='');

            htm_Input(labl:'@CVR-number',  plho:'@CVR...', icon:'',hint:'@Retrieved from the CVR register',type:'text', name:'cvrNumm', valu:$cvrNumm ?? '',form:'',wdth:'33%');
            htm_Input(labl:'@Company Name',plho:'@Name...',icon:'',hint:'@Retrieved from the CVR register',type:'text', name:'cvrNavn', valu:$cvrNavn ?? '',form:'',wdth:'66%');
            htm_Input(labl:'@Phone',       plho:'@Phon...',icon:'',hint:'@Retrieved from the CVR register',type:'text', name:'cvrTelf', valu:$cvrTelf ?? '',form:'',wdth:'33%');
            htm_Input(labl:'@Address',     plho:'@Addr...',icon:'',hint:'@Retrieved from the CVR register',type:'text', name:'cvrAddr', valu:$cvrAddr ?? '',form:'',wdth:'66%');
            htm_Input(labl:'@ZIP',         plho:'@zip...', icon:'',hint:'@Retrieved from the CVR register',type:'text', name:'cvrPost', valu:$cvrPost ?? '',form:'',wdth:'33%');
            htm_Input(labl:'@City',        plho:'@City...',icon:'',hint:'@Retrieved from the CVR register',type:'text', name:'cvrBy',   valu:$cvrBy   ?? '',form:'',wdth:'66%');
            htm_AcceptButt('@Use',lang('@Use the data shown in your registration of ').($hvem ?? '').'. <br>'. lang('@Warning: Possibly previous data is overwritten! (Fields without content, do not affect external data). <br> Not working yet'), $btnKind='save', $frmName='cvrform', $width='', $akey='b', $rtrn=false);
            htm_Input(labl:'@Other things',plho:'@Various...',icon:'',hint:'@Retrieved from the CVR register, various supplementary data',type:'area', name:'cvrDiv',valu: $cvrDiv ?? '',wdth:'100%');
            htm_Fieldset_00();
        htm_Panel_00( labl:'@Update',  icon:'',  hint:'Overwrite existing data with CVR-register data !', 
                      name:'',  form:'cvr', subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

        $custFld= [
        //[ 0:Label,         1:Hint,                  2:Placeholder]
          ['@Extra Field 1','@Extras - Fill in the field 1','@Field 1...'],
          ['@Extra Field 2','@Extras - Fill in the field 2','@Field 2...'],
          ['@Extra Field 3','@Extras - Fill in the field 3','@Field 3...'],
          ['@Extra Field 4','@Extras - Fill in the field 4','@Field 4...'],
          ['@Extra Field 5','@Extras - Fill in the field 5','@Field 5...']
        ];
     //   $custFld= $arrCustfld['custFld'];
        htm_Panel_0( capt: 'Extra fields:', icon: 'fas fa-plus', hint: '',
                     form: 'extra', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
            htm_Input( labl: lang($custFld[0][0]), plho: lang($custFld[0][2]), icon:'', hint: lang($custFld[0][1]), type:'text', name:'felt1',  valu: $arrCustfld['felt1'] ?? '', form:'', wdth:'66%');
            htm_Input( labl: lang($custFld[1][0]), plho: lang($custFld[1][2]), icon:'', hint: lang($custFld[1][1]), type:'text', name:'felt2',  valu: $arrCustfld['felt2'] ?? '', form:'', wdth:'66%');
            htm_Input( labl: lang($custFld[2][0]), plho: lang($custFld[2][2]), icon:'', hint: lang($custFld[2][1]), type:'text', name:'felt3',  valu: $arrCustfld['felt3'] ?? '', form:'', wdth:'66%');
            htm_Input( labl: lang($custFld[3][0]), plho: lang($custFld[3][2]), icon:'', hint: lang($custFld[3][1]), type:'text', name:'felt4',  valu: $arrCustfld['felt4'] ?? '', form:'', wdth:'66%');
            htm_Input( labl: lang($custFld[4][0]), plho: lang($custFld[4][2]), icon:'', hint: lang($custFld[4][1]), type:'text', name:'felt5',  valu: $arrCustfld['felt5'] ?? '', form:'', wdth:'66%');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);
        } // if ($KIS

       htm_Panel_0( capt: '', icon: '', hint: '', form: '', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white; visibility: hidden;', attr: '');
       ## Hidden placeholder to fillout the row
       htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);


    htm_Panel_0( capt: '@Content of the order:', icon: 'fas fa-pen', hint: '',
                 form: 'content', acti: '', clas: 'panelW960', wdth: '', styl: 'background-color: rgba(240, 240, 240, 0.80);', attr: '');
        global $ordrTotal;
        $link= '#';
        $ordrTotal= 0;
        htm_Table(
            $TblCapt= array( # ['0:Label',   '1:Width',    '2:Type',    '3:OutFormat', '4:horJust',      '5:Tip',    '6:placeholder', '7:Content';],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
            ),
            $RowPref= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_etc]', '5:fldKey', '6:ColTip','7:placeholder','8:default','9:[selectList]'], ...
            ),
            $RowBody= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur!
                ['@Pos.',         '5%','indx', '',  ['center'],'cnt_post',       '@Position number. is assigned automatically','..auto..'],
                ['@Item no.',     '9%','text', '',  ['center'],'cnt_product',    '@Item number for the service','Item...'],
                ['@Number',       '3%','text', '1d',['center'],'cnt_numb',       '@Quantity stated as number','@Numb...'],
                ['@Unit',         '6%','text', '',  ['left'  ],'cnt_unit',       '@Unit designation','@Unit...'],
                ['@Description', '26%','text', '',  ['left'  ],'cnt_description','@Description of the product / service','@Dest...'],
                ['@VAT' ,         '5%','text', '1d',['center'],'cnt_vat',        '@VAT pct. rate','@vat...'],
                ['@Price',        '8%','text', '2d',['center'],'cnt_price',      '@Unit price ','@Price...'],
                ['@%',            '6%','text', '1d',['right' ],'cnt_discount',   '@Discount percent','@Disc...'],
                ['@Total',       '10%','calc', '2d',['right' ],'cnt_total',      '@Calculated amount for the current posting.',''],
                ['@Currency',     '5%','ddwn', '',  ['center'],'cnt_currency',   '@Currency code for the currency used on the specification.','@Curr...','',[CurrencyArr(),'width: 55px;']],
              //['@Status',       '9%','ddwn', '',  ['left'  ],'cnt_stat',       '@Status',                                               '@Status...',  '',[OrdrStatu(),'width: 65px;']],
                /* ['@Maturity',     '9%','date', '',  ['center'],'cnt_duedate', '@Due date of the amount','@Due...'], */
            ),
            $RowSuff= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!'], ['Næste record'],... # Generel struktur!
                ['@Del.', '2%','text', '',  ['center'],
                              lang('@Delete the row! <br> WARNING - you can not regret.'),
                        /*    '<button type="button" id="ButtRowDelete" onclick="removeRow()"><i class="fas fa-trash-alt" style="font-size:14px; color:red;" title="'. lang('@You can not reverse this delete row !').'"></i></button>' */
                htm_ModalDialog(type:'erro',capt:'@DEMO page!',
                          mess:'@The site is still under development.<br>The function to delete row is not finished yet.', 
                          butt:[ ['clos'],['erro','','Got it'] ],  html:
                          '<ic class="fas fa-trash-alt" style="font-size:14px; color:red;" title="'.
                          lang('@Delete the row! <br> WARNING - you can not regret.').'"></ic>')
                              // onclick="remove(\'row_5\')" deleteRow(\'table1\') / removeRow() - not working: FIXIT
                ],
                ['@Clon.', '2%','text', '',  ['center'],
                              lang('@Make a copy of this row<br> It will be added as the last row in the table'),
                        /*    '<button class="plusbtn" type="button" style="padding: 2px 4px;" ><ic class="far fa-clone" style="font-size:14px; color:blue;" ></ic></button>' */
                htm_ModalDialog(type:'hint',capt:'@DEMO page!', 
                          mess:'@The site is still under development.<br>The function to clone row is not finished yet.', 
                          butt:[ ['clos'],['hint','','Got it'] ],  html:
                          '<ic class="far fa-clone" style="font-size:14px; color:blue;" title="'.
                          lang('@Make a copy of this row<br> It will be added as the last row in the table').'"></ic>')
                ],
                ['@Und.', '2%','text', '',  ['center'],
                              lang('@Undo posting! <br> Refund the amount by clicking on the icon.').' '.
                              lang('@If the order is invoiced, the item can be returned until the order has been posted. Then it must be done by crediting the customer!'),
                            /*   '<button style="padding: 2px 4px;" onclick=\'toast("Reverse this post<br>Cant do it yet !","lightyellow","black")\'><ic class="fas fa-undo" style="font-size:14px; color:orange;" title="'.
                              lang('@Reverse this entry, e.g. undo reminder fee').'"></ic></button>' */
                htm_ModalDialog(type:'warn',capt:'@DEMO page!', 
                          mess:'@The site is still under development.<br>The function to undo posting is not finished yet.', 
                          butt:[ ['clos'],['warn','','Got it'] ],  html:
                          '<ic class="fas fa-undo" style="font-size:14px; color:orange;" title="'.
                          lang('@Reverse this entry, e.g. undo reminder fee').'"></ic>')
                ],
                ['@Mov.', '2%','text', '',  ['center'], '@Move an entry up or down.',
                        /*    '<button type="button" onclick=\'phpDialog()\'><ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
                              lang('@Not working yet').'"></ic></button>' */
                htm_ModalDialog(type:'succ',capt:'@DEMO page!', 
                          mess:'@The site is still under development.<br>The function to move up/down is not finished yet.', 
                          butt:[ ['clos'],['succ','','Got it'] ],  html:
                          '<ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
                          lang('@Can`t move an entry up or down yet.').'"></ic>')
                ] // /* toast("Moving this post<br>Cant do it yet !","lightyellow","black") */
                
                ),            # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
            $TblNote=   '<small>This table contains an example of on the fly automatic calculation:<br>$total= ($DataRow[2]*$DataRow[6])*(100-$DataRow[7])/100*(100+$DataRow[5])/100;</small>',
            /* $data = */ $arrContent,
            $FilterOn= false,        
            $SorterOn= true,         
            $CreateRec=true,         
            $ModifyRec=true,         
            $ViewHeight= '250px',    
            $CalledFrom= __FUNCTION__
        );
    htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Panel_0( capt: 'Handling the offer/order:', icon: 'fas fa-check', hint: '', form: 'handling', acti: '', clas: 'panelW960', wdth: '', styl: 'background-color: lightgray;', attr: '');
        htm_nl(1);
        htm_Input(labl:'<b>'.lang('@Order:').'</b>',   plho:'',icon:'fas fa-hashtag',       hint:'@System field: Order number',    type:'text',name:'ordr',valu:$xx='0000',form:'',wdth:'100px',algn:'left',  attr:'',rtrn:false,unit:'',     disa:true,rows:'1',step:'');
        htm_Input(labl:'<b>'.lang('@Customer:').'</b>',plho:'',icon:'far fa-pen-to-square', hint:'@System field: Customer name',   type:'text',name:'cust',valu:'Customer',form:'',wdth:'400px',algn:'left',  attr:'',rtrn:false,unit:'',     disa:true,rows:'1',step:'');
        htm_Input(labl:'<b>'.lang('@Total:').'</b>',   plho:'',icon:'far fa-credit-card',   hint:'@System field: Amount incl. VAT',type:'dec2',name:'totl',valu:$ordrTotal,form:'',wdth:'120px',algn:'center',attr:'',rtrn:false,unit:' DKK ',disa:true,rows:'1',step:'');
        htm_nl(2);
                    # $labl='',$icon,$hint='',$form='',$wdth='',$attr,$akey='',$kind='',$rtrn=true,$tplc='LblTip_text',$tsty='',$clicking='',$idix='');
        htm_AcceptButt(labl:'@Create / update', icon:'',hint:lang('@Save the order'),                                        form:'handling', wdth:'120px',attr:'' ,akey:'', kind:'save',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;');
        htm_nl(2);                          //  icon:'',hint:                                                                form:,wdth:,$attr,                :'' ,                             :                                   :
      //htm_AcceptButt(labl:'@Lookup',          icon:'',hint:lang('@Browse other existing orders'),                          form:'doLookup' wdth:'140px', attr:'' ,akey:'', kind:'goon',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Lookup<br>Cant search yet !","orange","black")');
        htm_AcceptButt(labl:'@Save as Offer',   icon:'',hint:lang('@Create offer for registration'),                         form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Save as Order',   icon:'',hint:lang('@Create invoice for (the saved!) Order'),                 form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Create Invoice',  icon:'',hint:lang('@Create invoice for (the saved!) Order'),                 form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
    //htm_AcceptButt(labl:'@Make Delivery Note',icon:'',hint:lang('@Make delivery note for the shipment of the order'),      form:'doNote',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Make delive note<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Give credit',     icon:'',hint:lang('@Reset by crediting the order - if it is invoiced'),      form:'doCredit',wdth:'140px', attr:'' ,akey:'', kind:'goon',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Give credit<br>Cant do it yet !","orange","black")');
        htm_AcceptButt(labl:'@Delete',          icon:'',hint:lang('@Delete the order - provided the invoice is not formed'), form:'doErase', wdth:'140px', attr:'' ,akey:'', kind:'eras',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Delete<br>Cant erase yet !","orange","black")');
        //  $rtrn=true, $tipplc='LblTip_text', $tipstyl='',$clickFunction='', $attr )
        htm_nl(2);
    htm_Panel_00( labl:'',  icon:'',  hint:'',  name:'',  form:'', subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);

        htm_nl(1);

    htm_Panel_0( capt: '@Settings:', icon: 'fas fa-wrench', hint: '', form: 'language', acti: '', clas: 'panelW320', wdth: '', styl: 'background-color: white;', attr: '');
        htm_TextDiv(lang('@Change the language for this project: <br>'));

           # PHP7: $labl='',$plho='@Enter...',$icon='',$hint='',$type= 'text',$name='',$valu='',$form='',$wdth='',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='2',$step='',$list=[],$llgn='R',$bord='',$ftop='');
        htm_Input(labl:'@Select language',plho:'',icon:'',hint:'@Select among installed languages',type:'opti',name:'language',valu:$lang,form:'',wdth:'50%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',
                  list: [['en','@English','@Select english language'], 
                         ['fr','@French','@Select french language'],
                         ['de','@German','@Select german language'],
                         ['da','@Dansk','@Select danish language']]);
        htm_TextDiv('Note: The translate is not complete !<br> Only the Panel-headers will change.<br>');
    htm_Panel_00(labl:'@Save and use',  icon:'',  hint:'',  name:'', form:'language',  subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Panel_0(capt: '@Info about this page:', icon: 'fas fa-info', hint: '', form: 'demo', acti: '', clas: 'panelW320', wdth: '', styl: 'background-color: lightyellow;', attr: '');
        htm_TextDiv('This is a demo under development !<br>
            It stores data to JSON text files.<br>
            No connection to a SQL-database.<br>
            There is also a lack of functionality.<br>
            Code written for PHP 8+ !<br> 
        ');
    htm_Panel_00($labl='@Save', $icon='', $hint='', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false);

    // Menu_BottomScroll();
    /* 
    htm_Dialog($capt='INFO', $content='@This page needs PHP 8+ !. <br>', 
               $bgColor='lightyellow'); 
     */
    htm_nl(1);
  //  htm_ActionButt($label='RightClick Me', $id='right_click', $form='', $type='button', $onclick='', $icon='fas fa-mouse colrgreen', $hint='Try the Context-Menu', $attr='border-radius: 5px;', $rtrn=false);
  
    Pmnu_0( elem:'right_click', capt:'Context-Menu',  wdth:'280px',   icon:'', stck:'true', attr:'background-color:lightyellow; height: 16px;', cntx:true);
    Pmnu_Item( labl:'@Select All', icon:'far fa-object-group colrbrown iconsize', hint:'@Mark to select',                           type:'plain',     name:'d',   clck:'alert(\"sss\");', attr:'', akey:'CTRL+A');
    Pmnu_Item( labl:'@Copy',       icon:'fas fa-copy colrgreen iconsize',         hint:'@Copy selected to text-buffer',             type:'plain',     name:'d1',  clck:'alert(\"sss\");', attr:'', akey:'CTRL+C');
    Pmnu_Item( labl:'@Paste',      icon:'fas fa-paste colrblue iconsize',         hint:'@Paste content in text-buffer',             type:'plain',     name:'d2',  clck:'alert(\"sss\");', attr:'', akey:'CTRL+V');
    Pmnu_Item( labl:'<hr>',        icon:'',                                       hint:'',                                          type:'separator', name:'',    clck:'', attr:'');
    Pmnu_Item( labl:'@Delete',     icon:'fas fa-trash-alt colrred iconsize',      hint:'@Delete the selected',                      type:'plain',     name:'e',   clck:'', attr:'',akey:'DEL'.str_sp(6));
    Pmnu_Item( labl:'@Cut',        icon:'fas fa-cut colrblue iconsize',           hint:'@Cut the selected and save to text-buffer', type:'plain',     name:'d3',  clck:'alert(\"sss\");', attr:'', akey:'CTRL+X');
    Pmnu_Item( labl:'@Undo',       icon:'fas fa-undo colrblue iconsize',          hint:'@Undo latest task',                         type:'plain',     name:'d5',  clck:'alert(\"sss\");', attr:'', akey:'CTRL+Z');
    Pmnu_Item( labl:'@Redo',       icon:'fas fa-redo colrblue iconsize',          hint:'@Redo the last delete',                     type:'plain',     name:'d4',  clck:'alert(\"sss\");', attr:'', akey:'CTRL+Y');
    Pmnu_Item( labl:'<hr>',        icon:'',                                       hint:'',                                          type:'separator', name:'',    clck:'', attr:'background-color:lightyellow;');
    Pmnu_Item( labl:'@Multi Menu', icon:'fas fa-home colrgreen iconsize',         hint:'@Horisontal menu.',                         type:'multi',     name:'e2',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Delete',     icon:'fas fa-trash-alt colrred iconsize',      hint:'@Delete the selected',                      type:'subitem',   name:'e',   clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Cut',        icon:'fas fa-cut colrblue iconsize',           hint:'@Cut the selected and save to text-buffer', type:'subitem',   name:'d3',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Undo',       icon:'fas fa-undo colrblue iconsize',          hint:'@Undo latest task',                         type:'subitem',   name:'d5',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'',            icon:'',                                       hint:'',                                          type:'end_sub'   ); // multimenu
    Pmnu_Item( labl:'<hr>',        icon:'',                                       hint:'',                                          type:'separator', name:'',    clck:'', attr:'background-color:lightyellow;');
    Pmnu_Item( labl:'@Sub Menu',   icon:'fas fa-home colrgreen iconsize',         hint:'@Open submenu.',                            type:'submenu',   name:'f1',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Sub Item 1', icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 1',                        type:'subitem',   name:'f2',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Sub Item 2', icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 2',                        type:'subitem',   name:'f3',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Sub Item 3', icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 3',                        type:'subitem',   name:'f4',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'',            icon:'',                                       hint:'',                                          type:'end_sub'   ); // submenu                       
    Pmnu_Item( labl:'@Hover Menu', icon:'fas fa-bars colrgreen iconsize',         hint:'@Open hovermenu',                           type:'hovermenu', name:'g1',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Sub Item 4', icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 4',                        type:'subitem',   name:'g2',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Sub Item 5', icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 5',                        type:'subitem',   name:'g3',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'@Sub Item 6', icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 6',                        type:'subitem',   name:'g4',  clck:'', attr:'', akey:'');
    Pmnu_Item( labl:'',            icon:'',                                       hint:'',                                          type:'end_sub'); // hovermenu
    Pmnu_Item( labl:'@<hr>A demo of PopUp menu, witch showup when you right-clck an object<br><br>', icon:'', hint:'', type:'footer',  name:'f', clck:'', attr:'background-color:lightcyan;', akey:'');
    // Pmnu_Item($type='plain',$labl='@Remove',$hint='@Hint 4',$icon='fas fa-minus colrred',$id='e',$click='',$attr='',$akey='CTRL+V');
    Pmnu_00($labl='FOOTER',$hint='The menu footer.',$attr='background-color:lightyellow;');
    
    htm_nl(2);
    
    htm_Panel_0( capt: '@Info about Defined_vars:', icon: 'fas fa-info', hint: '', form:$form='demo', acti: '', clas: 'panelWmax', wdth: '', styl: 'background-color: lightyellow;', attr: '');
    arrPretty(get_defined_vars(),'Defined_vars:');
    htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'', form:$form,  subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Fieldset_00();
    
    if ($KIS!=true) {
            if ($savedBytes== 0) {   // page just opened
                PanelOff($First= 3,$Last=11); // Close panel 3 to 11,
                PanelOff($First=12,$Last=16);
                PanelOff($First= 1,$Last= 1);
            }
        }
htm_Page_00();

    run_Script('toast("<b>'. lang('@This page needs PHP 8+ !. <br>'). '</b>'.  '","lightgreen","blacck",1500)');

##### CLEANUP:

?>