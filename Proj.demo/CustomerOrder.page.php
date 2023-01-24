<?php   $DocFil= './Proj.demo/CustomerOrder.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-19';   $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
$gbl_progvers= $DocVer;
$gbl_copydate= $DocRev; 
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php'); // sql_/dbi_-functions

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [1, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);   
define('LIB_JQUERYUI',      [1, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);
define('LIB_TABLESORTER',   [2, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/']);
define('LIB_FONTAWESOME',   [2, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
define('LIB_TINYMCE',       [0, '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/']); 
define('LIB_POLYFILL',      [0, '_assets/',  ' Not in use ']);      
// Set ix= 0:deactive  1:Local-source  2:WEB-source-CDN



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
$debug= false;
$report= '';

if ($test) arrPrint($_POST,'$_POST');


function sql_CreateTable($pref='tca_',$table,$arrName,$tblComm='AutoComment') { # Create or reset empty dbTable with fieldnames from array
    global $report;                                                     $report.= 'sql_CreateTable: '; // form2arr($arrName);
    $keys= array_keys($arrName);
    $table= $pref.$table; // Prefix: 'tca_' = Tiny-Cloud-Accounting
    $i= count($keys);                                                   $report.= sql_modify('DROP TABLE IF EXISTS `'.$table.'`;');   # WARNING !
    $strSQL=  'CREATE TABLE `'.$table.'` ( `id` serial NOT NULL';
    if ($i >0) $strSQL.= ',';
    foreach ($keys as $k) { 
        $strSQL.= '`'.$k.'` VARCHAR(255) COMMENT "AutoComment"'; 
        if (--$i>0) $strSQL.= ','; // CHARACTER SET = utf8_danish_ci
    }
    $strSQL.= ', PRIMARY KEY (`ID`), UNIQUE KEY (`'.$keys[0].'`) ) COMMENT "'.$tblComm.'";';
    $x= sql_modify($strSQL);                                            $report.= '<br>sql_CreateTable:<br>'.$strSQL.($x==1 ? ' - OK' : ' - Fail');
    return ''; // '<br>'.$strSQL; // Used to echo
}

function sql_Replace($table,$arrData) { # Add or replace dbTableRows with data from array
    global $report;                                         $report.= 'sql_Replace: ';
    $keys =  array_keys($arrData);
    $values = array_map( 'addslashes', array_values($arrData) );    //  arrPretty($values,'$values');
    $strSQL= 'REPLACE INTO '.$table.' ('.implode(', ',$keys).') VALUES ("'.implode('", "',$values).'");';
    $x= sql_modify($strSQL);                                $report.= '<br><br>'.$strSQL.($x==1 ? ' - OK' : ' - Fail');
    return $strSQL;
}
function sql_Update($table,$arrData,$id) { # Update dbTableRow with data from array
    global $report;                                         $report.= 'sql_Update: ';
    $i= count($arrData);
    $strSQL = 'UPDATE '.$table.' SET ';
    foreach ($arrData as $key => $val) {
        $strSQL.= ' '.$key.' = "'.addslashes($val).'"';
        if (--$i>0) $strSQL.= ', ';
    }
    $strSQL.= ' WHERE id = '.$id.';';                       $report.= '<br><br>'.$strSQL;
    return $strSQL;
}
function sql_Insert($table,$arrData) {
    sql_modify();
}

function sql_Fetch() {
    
}

function btnSaveArr($pref,$name,&$arrData,$table='') {
    $arr=$arrData;
    if ($_POST) $arr= form2arr($arr);
    if ($table=='') $table= $pref.$name.'Tbl';
    if (isset($_POST['btn_sav_'.$name ])) {
        if (false) // ['ordrnumb'] exists
             sql_Update($table,$arr,$id=1); // Update 
        else sql_Replace($table,$arr);      // Create new
        $arrData= $arr;        
    }
}

function btnSaveTbl($tblPref,$name,&$arrData,$table='') {
    global $report;                                         $report.= 'btnSaveTbl: ';
    $arr=$arrData;                                                                                          // arrPretty($arr,'btnSaveTbl-A');
    if ((is_array($_POST)) and (count($_POST)>0)) { 
        $arr= post2arr($arr,'');                               $report.= $table.': COUNT:'.count($arr).' ';    // arrPretty($arr,'btnSaveTbl-B');
    }
    if ($table=='') $table= $tblPref.$name.'Tbl'; // AutoName
    if (isset($_POST['btn_sav_'.strtolower($name)])) {
        foreach ($arr as $ar) {                             $report.= '<br>';
            sql_Replace($table,$ar);
        }
    }
}

function form2arr(&$arrData) { # Copy data from _POST to actual array
    $result= [];
    foreach($_POST as $key=>$val) {
        if (substr($key,0,4) != 'btn_') $result[$key]= $val;
    }
    $arrData= $result;
    return $arrData;
}

function tabl2arr(&$arrData,$pref) { # Copy data from _POST to actual array (single record)
    $result= [];
    if (!is_array($arrData)) { return $arrData; exit; }
    $keys= array_keys($arrData);
    $numb= count($arrData);
    for ($i= 0; $i < $numb; $i++) {
        if ($keys[$i]==$pref) $result[]= $_POST[$keys[$i]];
    }
    $arrData= $result;    // arrPretty($arrData,'$arrData-'.$pref);
    return $arrData;
}

function post2arr(&$arrData,$pref) { # Fill array with multible records from _POST()
    if ((is_array($arr= $_POST)) and (count($arr)>0)) {         // arrPretty($arr,'$arr');
        $keys= array_keys($arr);
        if ($pref=='') $pref= substr($keys[1],0,4);             // arrPretty($keys,'keys');  arrPretty($arr,'valu');
        if (is_array($keys)) {
            $res= [];   $result= [];
            
            for ($r= 0; $r < (is_countable($arr[$keys[0]]) ? count($arr[$keys[0]]) : 0); $r++) {
                for ($i= 0; $i < count($keys); $i++) {
                    if (substr($keys[$i],0,4)==$pref)
                        $res[$keys[$i]]= $arr[$keys[$i]][$r];
                }
                $result[]= $res;
            }                                                   // arrPretty($result,'result');
            $arrData= $result;
            return $result;
        }
    }
}


##### DATA EXCHANGE:
$dPath= '../Data.demo/';

### SAVE to database:    (DEMO: to files)


# UPDATE files:

$savedBytes= 0;
$ordrnumb= '#00-000';   // Common key
$strOrder= '<span style="background-color:white; padding: 2px 6px;"> '.$ordrnumb.'</span>';
$status= '<small>'.lang('@Status: Editable').'</small>';

################### Put Datafiles: ###################
# activated buttons:                     Create Array:              Save data to json-file:
if (isset($_POST['btn_sav_orders'  ])) { post2arr($arrOrders, 'ord_');  $savedBytes+= FileWrite_arr($dPath.$filepath='arrOrders.dat.json',$arrOrders );}
if (isset($_POST['btn_sav_content' ])) { post2arr($arrContent,'cnt_');  $savedBytes+= FileWrite_arr($dPath.$filepath='arrContent.dat.json',$arrContent);}
    
if (isset($_POST['btn_sav_customr' ])) { form2arr($arrCustomr);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrCustomr.dat.json',$arrCustomr);}
if (isset($_POST['btn_sav_billing' ])) { form2arr($arrBilling);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrBilling.dat.json',$arrBilling);}
if (isset($_POST['btn_sav_deliver' ])) { form2arr($arrDeliver);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrDeliver.dat.json',$arrDeliver);}
if (isset($_POST['btn_sav_conditi' ])) { form2arr($arrConditi);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrConditi.dat.json',$arrConditi);}
if (isset($_POST['btn_sav_mailinv' ])) { form2arr($arrMailing);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrMailing.dat.json',$arrMailing);}
// if (isset($_POST['btn_sav_contact' ])) { form2arr($arrContact);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrContact.dat.json',$arrContact);}
if (isset($_POST['btn_sav_custFld' ])) { form2arr($arrCustfld);         $savedBytes+= FileWrite_arr($dPath.$filepath='arrCustfld.dat.json',$arrCustfld);}
if (isset($_POST['btn_sav_cvrform' ])) {}    // Use CVR-data
if (isset($_POST['btn_sav_language'])) { $lang = $_POST['language']; }
if (isset($_POST['btn_cre_contact' ])) {  }  // Create new
if (isset($_POST['btn_era_contact' ])) {  }  // Erase contact
if (isset($_POST['btn_goo_doLookup'])) {  }  // Opslag
if (isset($_POST['btn_cre_doInvo'  ])) {  }  // Dan Faktura
if (isset($_POST['btn_cre_doNote'  ])) {  }  // Dan Følgeseddel
if (isset($_POST['btn_hom_doCredit'])) {  }  // Krediter
if (isset($_POST['btn_era_doErase' ])) {  }  // Slet

################### Get from Datafiles: ###################
$arrNames= ['arrCustomr','arrBilling','arrDeliver','arrConditi','arrMailing','arrContact','arrCustfld','arrOrders' ,'arrContent'];
$arrTabls= ['custTbl',   'billTbl',   'deliTbl',   'condTbl',   'mailTbl',   '',          'cstoTbl',   '' ,         'contTbl'];
// if (!isset($arrOrders))
//   foreach ($arrNames as $arr) $$arr= json_decode(file_get_contents($dPath.$arr.'.dat.json'), true); ## READ data from json files (DEMO)
 $arrContact= json_decode(file_get_contents($dPath.'arrContact.dat.json'), true);
// arrPretty($arrContact,'$arrContact');

/* manually: */
$arrContent= json_decode(file_get_contents($dPath.'arrContent.dat.json'), true); // arrPretty($arrContent,'$arrContent from file...'); 
$id=0; foreach ($arrContent as $row) { $result[]= array_merge(['id'=>$id++],$row); }; $arrContent= $result; ## Add id-field
/* manually: */





## define('DB_TYPE', 'mysql');  ## See: customLib.inc.php
$pref='tca_'; // Tiny-Cloud-Accounting
$db_Link= dbi_connect($sqhost='mysql62.unoeuro.com', $squser='viuff_info', $sqpass='M4d73anU8j', $sqdb='viuff_info_db8');
// arrPrint($db_Link,'$db_Link');
// "CREATE DATABASE $db_navn with encoding = 'UTF8'"


/* manually: * /
if (false) { ## Initiate arrays and dbTables:
################### Create DB-tables: ###################
    # activated buttons:                       Create dataArray:             Create dbTable with fieldnames as in array:
    if (isset($_POST['btn_sav_cust' ]))   {form2arr($arrCustomr);    echo sql_CreateTable($pref='tca_',$tblName='custTbl',$arrCustomr,'Customer data'); }
    if (isset($_POST['btn_sav_bill' ]))   {form2arr($arrBilling);    echo sql_CreateTable($pref='tca_',$tblName='billTbl',$arrBilling,'Billing data'); } 
    if (isset($_POST['btn_sav_deli' ]))   {form2arr($arrDeliver);    echo sql_CreateTable($pref='tca_',$tblName='deliTbl',$arrDeliver,'Delivery data'); }
    if (isset($_POST['btn_sav_cond' ]))   {form2arr($arrConditi);    echo sql_CreateTable($pref='tca_',$tblName='condTbl',$arrConditi,'Paying conditions');}
    if (isset($_POST['btn_sav_mail' ]))   {form2arr($arrMailing);    echo sql_CreateTable($pref='tca_',$tblName='mailTbl',$arrMailing,'Mail data'); }
    if (isset($_POST['btn_sav_cont' ]))   {form2arr($arrContact);    echo sql_CreateTable($pref='tca_',$tblName='contTbl',$arrContact,'Person contact'); } 
//  if (isset($_POST['btn_sav_cvr_' ]))   {form2arr($arrCVRlook);    echo sql_CreateTable($pref='tca_',$tblName='cvr_Tbl',$arrCVRlook,'CVR-lookup'); } 
    if (isset($_POST['btn_sav_csto' ]))   {form2arr($arrCustfld);    echo sql_CreateTable($pref='tca_',$tblName='cstoTbl',$arrCustfld,'Custom fields'); }   
    if (isset($_POST['btn_sav_cstn' ]))   {form2arr($arrCustnot);    echo sql_CreateTable($pref='tca_',$tblName='cstnTbl',$arrCustnot,'Custom Note'); }
                                          
    if (isset($_POST['btn_sav_orders']))  {form2arr($arrOrders[0]);  echo sql_CreateTable($pref='tca_',$tblName='OrdersTbl', $arrOrders[0],'Orders'); }
    if (isset($_POST['btn_sav_content'])) {form2arr($arrContent[0]); echo sql_CreateTable($pref='tca_',$tblName='ContentTbl',$arrContent[0],'Content'); }
}   // I 2D-tabellerne skal 2. kolonne slettes (erstattes af: `id` serial NOT NULL )
/* manually: * /
    if (isset($_POST['btn_sav_content'])) {form2arr($arrContent[0]); echo sql_CreateTable($pref='tca_',$tblName='ContentTbl',$arrContent[0],'Content'); }
* manually: */


// arrPretty( sql_readAssoc($strQuery= 'SELECT * FROM tca_OrdersTbl WHERE id=17'));
/* */

### READ from database:
# INIT variables:

################### Fetch from DataBase: ###################
$arrOrders = sql_readAssoc($strQuery='SELECT * FROM tca_OrdersTbl' ); // array_shift($arrOrders);
// $arrContent= sql_readAssoc($strQuery='SELECT * FROM tca_ContentTbl');
// arrPretty($arrContent,'$arrContent'); 
/* */ 
$arrCustomr= sql_readAssoc($strQuery='SELECT * FROM tca_custTbl')[0];
$arrBilling= sql_readAssoc($strQuery='SELECT * FROM tca_billTbl')[0];
$arrDeliver= sql_readAssoc($strQuery='SELECT * FROM tca_deliTbl')[0];
$arrConditi= sql_readAssoc($strQuery='SELECT * FROM tca_condTbl')[0];
$arrMailing= sql_readAssoc($strQuery='SELECT * FROM tca_mailTbl')[0];
// $arrContact= sql_readAssoc($strQuery='SELECT * FROM tca_contTbl'); // 3D-array !
// $arrCVRlook= sql_readAssoc($strQuery='SELECT * FROM tca_OrdersTbl'); // Special: verification af data. Not a datarecord
$arrCustfld= sql_readAssoc($strQuery='SELECT * FROM tca_cstoTbl')[0];
$arrCustnot= sql_readAssoc($strQuery='SELECT * FROM tca_OrdersTbl')[0];

if (!isset($arrBilling['cond_use'])) $arrBilling['cond_use']= 'unchecked';
// $arrContact= [];
/* */


if (true) {
################### Save data in panels to DataBase if pusbed save button: ###################
    btnSaveArr($pref,'cust',$arrCustomr);
    btnSaveArr($pref,'bill',$arrBilling);
    btnSaveArr($pref,'deli',$arrDeliver);
    btnSaveTbl($pref,'cont',$arrContact);          
//  btnSaveArr($pref,'cvr_', ); // Special: verification af data. Not a datarecord
    btnSaveArr($pref,'cond',$arrConditi);
    btnSaveArr($pref,'csto',$arrCustfld);
    btnSaveArr($pref,'cstn',$arrCustnot);
    btnSaveArr($pref,'mail',$arrMailing);
# Save data in tables:
    btnSaveTbl($pref,'Orders',$arrOrders); // unset($_POST['btn_sav_orders']);   // tca_OrdersTbl
    btnSaveTbl($pref,'Content',$arrContent); // unset($_POST['btn_sav_orders']);   // tca_OrdersTbl
}

dbi_DBclose($db_Link); 

/*  
# Add index if empty:
indxCheck($arrOrders,$name='ord_id',$pref='000'); 
indxCheck($arrContent,$name='cnt_post'); 
*/


##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_Page_0() - javascript will fail !

### From here this demo is written for PHP 8+ ! 
### (the vars order is maintained as for PHP 7, and default vars may not be excluded)

htm_Page_0(titl:'@OrderCreate.page.php', hint:'@Tip: Toggle fullscreen-mode with function key: F11',
           info:'@Example: Customer-ORDER Build with <b style="color:darkgreen;">PHP2HTML </b>',
           inis:'', algn:'center', gbl_Imag:'', attr:'background: linear-gradient(0deg,#03a9f4 0%,#e3f2fd);', gbl_Bord:false);
    Menu_Topdropdown(true); 

if ($test) echo '<pre>'.$log.'</pre>'. '<br>Saved: '.$savedBytes.' bytes to data-files.<br>';
    
    htm_Caption(labl:'@Tiny-Cloud-Accounting',icon:'',hint:'',algn:'center',styl:'color:'.$gbl_TitleColr.'; font-weight:600; font-size: 18px;');
    htm_nl(1);
    htm_Fieldset_0(capt:'@Customer Offer/Order',icon:'',hint:'',wdth:'100%; max-width:1150px',marg:'',
                   attr:'Color: green; font-weight: bold; background-color: white; border-radius: 4px; padding: 0 10px; text-align: center; ',rtrn:false);

    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    htm_Panel_0(capt: '@Find / select existing order:',icon: 'fas fa-search',hint: '',form: $f='orders',acti: '',clas: 'panelWaut',wdth: '',styl: 'background-color: rgba(240, 240, 240, 0.80);',attr: '',head:$headbg);

        htm_Table(
            TblCapt: [  ['@Customer orders', 'Width', 'html', 'OutFormat', 'horJust', 'Tip', '', ''] ],
            RowPref: [],
            RowBody: [  ['@id',           '8%','show', '',   ['center'], 'ord_id',      '@id number maintained by the system',          '..auto..'],
                        ['@Order',        '9%','indx', '',   ['center'], 'ord_ix',      '@Order number',                                '@Numb...'],
                        ['@Order Date',   '4%','date', '',   ['left'  ], 'ord_odate',   '@Order Date',                                  'YYYY-MM-DD'],
                        ['@Deliv. date',  '4%','date', '',   ['left'  ], 'ord_ddate',   '@Delivery date',                               'YYYY-MM-DD'],
                        ['@Account',      '8%','text', '',   ['center'], 'ord_acco',    '@Debtor Account number',                       '@Acco...'],
                        ['@Company name','36%','text', '',   ['left'  ], 'ord_name',    '@Company name',                                '@Firm...'],
                        ['@Seller',       '7%','text', '',   ['left'  ], 'ord_sell',    '@The employer with contact to the customer',   '@Sell...'],
                        ['@Amount',      '10%','text', '2d', ['right' ], 'ord_amou',    '@The total order sum',                         '@Amount...'],
                        ['@Currency',     '4%','ddwn', '',   ['center'], 'ord_currency','@Currency code for the currency used on the specification.','@Curr...','',[CurrencyArr(),'width: 55px;']],
                        ['@Maturity',     '4%','date', '',   ['center'], 'ord_duedate', '@Due date of the amount',                      '@Due...'],
                        ['@Status',       '9%','ddwn', '',   ['left'  ], 'ord_stat',    '@Status','@Status...',  '', [OrdrStatu(),'width: 70px;']], //  ORD_Status()
                     ],
            RowSuff: [],
            TblNote:    '',
            TblData:    $arrOrders,
            FilterOn:   true,     
            SorterOn:   true,     
            CreateRec:  false,    
            ModifyRec:  true,     
            ViewHeight: '200px',
            TblStyle:   '',       
            CalledFrom: 'Fi:'. __FILE__ .' Li:'. __LINE__ .' Fu:'. __FUNCTION__,
            MultiList:  ['',''],
            ExportTo: ''      
            // , dropFirst:true
          );
    htm_Panel_00(labl:'@Save', icon:'', hint:'@Remember to save here...', name:'tabl', form:$f,subm:true, attr:'', akey:'', kind:'save', simu:false);

## Naming variables in this project:
#   Form name is used as Prefix in variable names (4 characters)
#   Variable names are used as field names in arrays (4+4 characters)

// btn_sav_conderror_reporting(0);

    htm_Panel_0(capt: lang('@Create new or modify order: ').$strOrder,
                icon: 'fas fa-pen',hint: '@Demo ! <br>No connection to a DataBase. <br>Read/save from/to JSON-files.',
                form: '',acti: '',clas: 'panelWaut',wdth: '',styl: 'background-color: rgba(240, 240, 240, 0.80);',attr: '', head:$headbg);
                
        htm_Caption($labl='@Debtor card',$icon='',$hint='',$algn='center',$styl='color:'.$gbl_TitleColr.'; font-weight:600; font-size: 18px;');
        htm_nl(1);
        htm_Panel_0(capt: '@Customer:',icon: 'fas fa-user',hint: '',form: $fm='cust',
                    acti: '',clas: 'panelW280',wdth: '',styl: 'background-color: white;',attr: '',head:$headbg);
            htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl:'@Customer nr.',             plho:'@..auto..',                icon:'',hint:'@Customer nr: Can not be edited, onlu created. The system sets this',
                      type:'text',name:$n='custkont',   valu:$arrCustomr[$n],   form:'',wdth:'50%');
            htm_Input(labl:'@Customer Lookup',          plho:'@Select',         icon:'',hint:'@Here you select which existing customer to select',                 
                      type:'opti',name:$n='custopsl',   valu:$arrCustomr[$n],   form:'',wdth:'50%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]);
            htm_Input(labl:'@Customer type',            plho:'@Select',         icon:'',hint:'@Customer kategori',                                                 
                      type:'rado',name:$n='custkate',   valu:$arrCustomr[$n],   form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'',
                      list:[['priv', '@private', '@private'], ['prof', '@professional', '@professional']]);                                                                                                                                  
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
        htm_Panel_00(labl:'@Save', icon:'', hint:'', name:'', form:$fm,subm:true, attr:'', akey:'', kind:'save', simu:false);

        htm_Panel_0( capt: '@Conditions:', icon: 'far fa-credit-card', hint: '',form: $fm='cond', 
                     acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
            htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl:'@Debtor group',      plho:'@Select',      icon:'',  hint:'@Choose which group the customer belongs to',     
                      type:'opti', name:$n='condgrup', valu: $arrConditi[$n],form:'',wdth:'100%',  algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Grup() );
            htm_Input(labl:'@Payment method',    plho:'@Select',      icon:'',  hint:'@How to pay',                                     
                      type:'opti', name:$n='condpaym', valu: $arrConditi[$n],form:'',wdth:'100%',  algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Betl() );
            htm_Input(labl:'@Payment deadline',  plho:'@Select',      icon:'',  hint:'@How long is the deadline for payment',           
                      type:'opti', name:$n='conddead', valu: $arrConditi[$n],form:'',wdth:'100%',  algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Frist() );
            htm_Input(labl:'@Print to',          plho:'@Select',      icon:'',  hint:'@Choose how to print, save or send the document.',
                      type:'opti', name:$n='condoutp', valu: $arrConditi[$n],form:'',wdth:'68%',   algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'', list: DEB_Dok() );
            htm_Input(labl:'@Customer reference',/*plho:'Ref...',icon:'',*/ hint:'@for example. Requisitions no',                   
                      type:'text', name:$n='condrefr', valu: $arrConditi[$n],form:'',wdth:'100%');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:$fm, subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

        $body= '<small><i>Business only !</i><br>
            Copy or check data in the public company register.<br>
            Data is provided by CVR API<br></small>';

        htm_Panel_0( capt: '@CVR-lookup:', icon: 'fas fa-database', hint: '',
                     form: $fm='cvr_', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');

            htm_Fieldset_0( capt:'@Lookup in the CVR register:', icon:'', hint:'', wdth:'', marg:'', attr:'font-size: smaller; ', rtrn:false);
            
            htm_TextDiv($body,algn:'left',marg:'8px',styl:'',attr:'');
            set_FormVars(['cvrLand','cvrKode','cvrSoeg'/*, 'cvrNumm','cvrNavn','cvrTelf','cvrAddr','cvrPost','cvrBy','cvrDiv' */]);  // Opdater alle variabler på form 'cvrform' :
            get_FormVars(['cvrLand','cvrKode','cvrSoeg']);
        #      dev_show(); //  echo 'SESSIONS contents of variables: ';  vis_data($_SESSION);
                $cvrLand= $_SESSION['cvrLand'] ?? '';   if (!$cvrLand) $cvrLand= 'dk';
                $cvrKode= $_SESSION['cvrKode'] ?? '';   if (!$cvrKode) $cvrKode= 'search';
                $cvrSoeg= $_SESSION['cvrSoeg'] ?? '';
                if (($cvrLand) and ($cvrKode) and ($cvrSoeg)) //  Klar til søgning
                { $url= 'https://cvrapi.dk/api?'.$cvrKode.'='.$cvrSoeg.'&country='.$cvrLand;   //  https://cvrapi.dk/api?search=$cvrSoeg&country=dk  Generel søgning    //  https://cvrapi.dk/api?phone=$cvrSoeg&country=dk   specifikt telefonnr
                    $content = file_get_contents($url, false, stream_context_create(['http' => ['user_agent' => 'any']]));
                    // FIXIT: Prevent: "Failed to open streem" ved:  "404 Not Found"
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
            htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl:'@Land registry',       plho:'',                icon:'',hint:'@In what country do you want to apply?',                       
                      type:'opti', name:$n='cvr_Land', valu: $cvrLand='dk',    form:'',wdth:'50%', algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list: CVR_Land(), llgn:'R',bord:'border: 1px solid green;');
            htm_Input(labl:'@Search for',          plho:'',                icon:'',hint:'@What do you know?',                                           
                      type:'opti', name:$n='cvr_Kode', valu: $cvrKode='search',form:'',wdth:'50%', algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list: CVR_Liste(),llgn:'R',bord:'border: 1px solid green;');
            htm_Input(labl:'@CVR/P-uni./Phon/Name',plho:'@Business only !',icon:'',hint:'@Enter here, data or company name that you want to search for',
                      type:'text', name:$n='cvr_Soeg', valu: $cvrSoeg,         form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],          llgn:'R',bord:'border: 1px solid green;');
            htm_MiniNote('<span class="colrgreen">'.lang('@Green ').'</span>'.lang('@frames are the basis for entry in CVR.'));
            htm_hr('lightgray');
            htm_AcceptButt( labl:'@Search',  icon:'', hint:'@Start search in the CVR register', 
                            form:'cvrform', wdth:'', attr:'', akey:'s', kind:'crea', rtrn:false, tplc:'LblTip_text', tsty:'', acti:'', idix:'');
            htm_Fieldset_00();
            
            // htm_hr('green');
            htm_Fieldset_0( capt:'@Register data:', icon:'', hint:'', wdth:'', marg:'', attr:'font-size: smaller;', rtrn:false);
            htm_Input(labl:'@CVR-number',  plho:'@CVR...', icon:'',hint:'@Retrieved from the CVR register',
                      type:'text', name:$n='cvr_Numm', valu:$cvrNumm ?? '',form:'',wdth:'33%');
            htm_Input(labl:'@Company Name',plho:'@Name...',icon:'',hint:'@Retrieved from the CVR register',
                      type:'text', name:$n='cvr_Name', valu:$cvrNavn ?? '',form:'',wdth:'66%');
            htm_Input(labl:'@Phone',       plho:'@Phon...',icon:'',hint:'@Retrieved from the CVR register',
                      type:'text', name:$n='cvr_phon', valu:$cvrTelf ?? '',form:'',wdth:'33%');
            htm_Input(labl:'@Address',     plho:'@Addr...',icon:'',hint:'@Retrieved from the CVR register',
                      type:'text', name:$n='cvr_Adrs', valu:$cvrAddr ?? '',form:'',wdth:'66%');
            htm_Input(labl:'@ZIP',         plho:'@zip...', icon:'',hint:'@Retrieved from the CVR register',
                      type:'text', name:$n='cvr_zipp', valu:$cvrPost ?? '',form:'',wdth:'33%');
            htm_Input(labl:'@City',        plho:'@City...',icon:'',hint:'@Retrieved from the CVR register',
                      type:'text', name:$n='cvr_town',   valu:$cvrBy   ?? '',form:'',wdth:'66%');
            htm_AcceptButt('@Use',lang('@Use the data shown in your registration of ').($hvem ?? '').'. <br>'. lang('@Warning: Possibly previous data is overwritten! (Fields without content, do not affect external data). <br> Not working yet'), $btnKind='save', $frmName='cvrform', $width='', $akey='b', $rtrn=false);
            htm_Input(labl:'@Other things',plho:'@Various...',icon:'',hint:'@Retrieved from the CVR register, various supplementary data',type:'area', name:'cvrDiv',valu: $cvrDiv ?? '',wdth:'100%');
            htm_Fieldset_00();
        htm_Panel_00( labl:'@Update', icon:'', hint:'Overwrite existing data with CVR-register data !', name:'', form:'cvr_', subm:true, attr:'', akey:'', kind:'save', simu:false);

        htm_Panel_0(capt: '@Billing:',icon: 'fas fa-pen',hint: '',form: $fm='bill',acti: '',clas: 'panelW280',wdth: '',styl: 'background-color: white;',attr: '',head:$headbg);
            htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl:'@Order info',               plho:'@Order:... Date:...',icon:'',hint:'@@Systemfield: Auto fill out, when order is created/saved',
                      type:'area',name:$n='billoref',   valu:$arrBilling[$n] ?? '',form:'', wdth:'100%',algn:'left',attr:'',   rtrn:false,unit:'',disa:true,rows:'1');
            htm_Input(labl:'@Customer name',            plho:'@Name...',              icon:'',hint:'@Enter costomer name',                                     
                      type:'text',name:$n='billnavn',   valu:$arrBilling[$n], form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Customer address',         plho:'@Address...',           icon:'',hint:'@Enter invoice address',                                   
                      type:'text',name:$n='billaddr',   valu:$arrBilling[$n], form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Customer place',           plho:'@Place...',             icon:'',hint:'@Enter invoice place',                                     
                      type:'text',name:$n='billsted',   valu:$arrBilling[$n], form:'');    
            htm_Input(labl:'@ZIP',                      plho:'@ZIP...',               icon:'',hint:'@ZIP code',                                                
                      type:'text',name:$n='billponr',   valu:$arrBilling[$n], form:'',wdth:'26%', algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Invoice city',             plho:'@City...',              icon:'',hint:'@Invoice city',                                            
                      type:'text',name:$n='billbynv',   valu:$arrBilling[$n], form:'',wdth:'68%', algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Invoice Country',          plho:'@Country...',           icon:'',hint:'@Invoice Country',                                         
                      type:'text',name:$n='billland',   valu:$arrBilling[$n], form:'');
            htm_hr($gbl_TitleColr.'; height: 2px');                                                                                                                                                      
            htm_Input(labl:'@Phone(s)',                 plho:'@Phone...',             icon:'',hint:'@Phone, mobil, fax',                                       
                      type:'text',name:$n='billtelf',   valu:$arrBilling[$n], form:'',wdth:'100%',algn:'left',attr:'required',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Attention',                plho:'@Att...' ,              icon:'',hint:'@Attention - Customer contact',                            
                      type:'text',name:$n='bill_att',   valu:$arrBilling[$n], form:'');
            htm_Input(labl:'@Réquisition number',       plho:'@Ref...' ,              icon:'',hint:'@Customer reference to order',                             
                      type:'text',name:$n='billrekv',   valu:$arrBilling[$n], form:'');
            htm_Input(labl:'@Email address',            plho:'@Mail...',              icon:'',hint:'@Customer Email address',                                  
                      type:'text',name:$n='billmail',   valu:$arrBilling[$n], form:'');
            htm_Input(labl:'@Remarks',                  plho:'@Rem...' ,              icon:'',hint:'@Notes regarding the customer',                            
                      type:'text',name:$n='billnote',   valu:$arrBilling[$n], form:'');
            if (isset($_POST['use_mail'])) { $use_mail = 'checked'; } 
            htm_Input(labl:'@Order Date',               plho:'@Date...',              icon:'',hint:'@Dato for ordrens oprettelse',                             
                      type:'date',name:$n='conddate',   valu:$arrBilling[$n], form:'',wdth:'50%');
            htm_Input(labl:'@Invoice Date',             plho:'@Date...',              icon:'',hint:'@Invoice Date',                                            
                      type:'date',name:$n='condinvc',   valu:$arrBilling[$n], form:'',wdth:'50%');
            htm_Input(labl:'@Mailing',                  plho:'@...',                  icon:'',hint:'@Send invoice with mail',                                  
                      type:'chck',name:$n='cond_use',   valu:$arrBilling[$n], form:'',wdth:'50%',algn:'left',attr:' margin-left: 10px;',rtrn:false,unit:'',disa:false,rows:'3',step:'',
                      list: [['use_mail','@Use mail','@Mailing for this order is active',$namechck ?? '']]);
            htm_Input(labl:'@Rebills',                  plho:'@Date...',              icon:'',hint:'@When to rebill date',                                     
                      type:'date',name:$n='condrebi',   valu:$arrBilling[$n], form:'',wdth:'50%');
            htm_MiniNote('<span class="colrorange">'.lang('@Orange ').'</span>'.lang('@frames are required fields.'));
        htm_Panel_00(labl:'Save', icon:'', hint:'', name:'', form:$fm,subm:true, attr:'', akey:'', kind:'save', simu:false);

        htm_Panel_0( capt: '@Mail-invoice:', icon: 'fas fa-envelope', hint: '',
                     form: $fm='mail', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
//  htm_Panel_0($frmName='mailinv', $capt=lang('Mail-invoice:'), $parms='', $icon='fas fa-envelope', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl:'@Mail subject',                                          plho:'@Subj...',icon:'',hint:'@Enter Mail subject',                                             
                      type:'text',name:$n='mailemne', valu:$arrMailing[$n]);
            htm_Input(labl:'@Mail message',                                          plho:'@Mess...',icon:'',hint:'@Enter Mail text',                                                
                      type:'area',name:$n='mailtext', valu:$arrMailing[$n]);
            htm_Input(labl:'<i class=\'fas fa-paperclip\'></i> '.lang('@Mail Annex'),plho:'@Annex..',icon:'',hint:'@Enter Attached file',                                            
                      type:'file',name:$n='mailvedh', valu:$arrMailing[$n]);
            htm_Input(labl:'@Copy to',                                               plho:'Copy...' ,icon:'',hint:'@Enter mail address to receive one copy of send mail',            
                      type:'text',name:$n='mail__cc', valu:$arrMailing[$n]);
            htm_Input(labl:'@Blind-copy to',                                         plho:'BCopy...',icon:'',hint:'@Enter mail address to receive one BC-copy (hidden) of sent mail',
                      type:'text',name:$n='mail__bc', valu:$arrMailing[$n]);
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:$fm, subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);
//  htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

        $custFld= [
        //[ 0:Label,         1:Hint,                  2:Placeholder]
          ['@Extra Field 1','@Extras - Fill in the field 1','@Field 1...'],
          ['@Extra Field 2','@Extras - Fill in the field 2','@Field 2...'],
          ['@Extra Field 3','@Extras - Fill in the field 3','@Field 3...'],
          ['@Extra Field 4','@Extras - Fill in the field 4','@Field 4...'],
          ['@Extra Field 5','@Extras - Fill in the field 5','@Field 5...']
        ];
     //   $custFld= $arrCustfld['custFld'];
        htm_Panel_0( capt: '@Extra fields:', icon: 'fas fa-plus', hint: '',
                     form:$fm='csto', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
            htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl: lang($custFld[0][0]),       plho: lang($custFld[0][2]), icon:'', hint: lang($custFld[0][1]), 
                      type:'text', name:$n=$fm.'Fld1',  valu: $arrCustfld[$n] ?? '', form:'', wdth:'88%');
            htm_Input(labl: lang($custFld[1][0]),       plho: lang($custFld[1][2]), icon:'', hint: lang($custFld[1][1]), 
                      type:'text', name:$n=$fm.'Fld2',  valu: $arrCustfld[$n] ?? '', form:'', wdth:'88%');
            htm_Input(labl: lang($custFld[2][0]),       plho: lang($custFld[2][2]), icon:'', hint: lang($custFld[2][1]), 
                      type:'text', name:$n=$fm.'Fld3',  valu: $arrCustfld[$n] ?? '', form:'', wdth:'88%');
            htm_Input(labl: lang($custFld[3][0]),       plho: lang($custFld[3][2]), icon:'', hint: lang($custFld[3][1]), 
                      type:'text', name:$n=$fm.'Fld4',  valu: $arrCustfld[$n] ?? '', form:'', wdth:'88%');
            htm_Input(labl: lang($custFld[4][0]),       plho: lang($custFld[4][2]), icon:'', hint: lang($custFld[4][1]), 
                      type:'text', name:$n=$fm.'Fld5',  valu: $arrCustfld[$n] ?? '', form:'', wdth:'88%');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'', name:'',  form:$fm, subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);
        
        htm_Panel_0(capt: '@Delivery:',icon: 'fas fa-truck',hint: '',form: $fm='deli',acti: '',clas: 'panelW280',wdth: '',styl: 'background-color: white;',attr: '',head:$headbg);
            htm_Input(labl:'@Order number',             plho:'Hidden field', icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$arrCustomr[$n],       form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
            htm_Input(labl:'@Delivered to invoice address', plho:'Name...', icon:'',hint:'@Check here if the delivery address is the same as the invoice address',
                      type:'chck', name:$n='delisame',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',
                      list: [['delisame','@Same address','@Automatic fillout with the same address as invoice',$namechck ?? '']]);
            htm_Input(labl:'@Recipient Name',           plho:'@Name...',  icon:'',hint:'@Enter Recipient Name',                                             
                      type:'text', name:$n='deliname',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@Delivery Address',         plho:'@Addr..',   icon:'',hint:'@Enter Delivery Address',                                           
                      type:'text', name:$n='deliaddr',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@Place of Delivery',        plho:'S@ted...',  icon:'',hint:'@Specify Place of Delivery, supplement to address',                 
                      type:'text', name:$n='deliplac',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'100%');
            htm_Input(labl:'@ZIP',                      plho:'@Pnr..',    icon:'',hint:'@Enter Delivery Customer postcode',                                 
                      type:'text', name:$n='deli_zip',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'26%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@City Name',                plho:'@City..',   icon:'',hint:'@Enter Delivery City name',                                         
                      type:'text', name:$n='delicity',  valu: $arrDeliver[$n]  ?? '', form:'',wdth:'68%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[],llgn:'',bord:'border: 1px solid blue;');
            htm_Input(labl:'@Delivery Country',         plho:'@Contry...',icon:'',hint:'@Specify Delivery Country',                                         
                      type:'text', name:$n='delicoun',  valu: $arrDeliver[$n]  ?? '');
            htm_hr($gbl_TitleColr.'; height: 2px');
            htm_Input(labl:'@Phone(s)',                 plho:'@Phone..' , icon:'',hint:'@Enter Recipient`s Phone',                                          
                      type:'text', name:$n='deliphon',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Contact person',           plho:'Name...' , icon:'',hint:'@Contact person at the delivery address',                                               
                      type:'text', name:$n='delikont',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Recipient`s Email Address',plho:'@Mail...' , icon:'',hint:'@Enter Recipient`s Email Address',                                  
                      type:'mail', name:$n='delimail',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Shipping Method.',         plho:'@Shipp...', icon:'',hint:'@Enter Shipping Information. How / with whom was the package sent?',
                      type:'text', name:$n='delimeto',  valu: $arrDeliver[$n]  ?? '');
            htm_Input(labl:'@Notes to freight forwarder',plho:'@Note...',  icon:'',hint:'@Notes regarding package delivery',                                 
                      type:'area', name:$n='delinote',  valu: $arrDeliver[$n]  ?? '',form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'1',step:'');
            htm_Input(labl:'@Status',                   plho:'@Enter...',icon:'',hint:'@Once the service has been sent, amounts can be redeemed',          
                      type:'chck', name:$n='delistat',  valu: $arrDeliver[$n]  ?? '',form:'',wdth:'50%',algn:'left', attr:'margin: 0 10px;',rtrn:false,unit:'',disa:false,rows:'3',step:'',
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
            htm_LinkButt( $labl='@Address on map', $gotoLink='https://krak.dk/'. $arrDeliver['deliname'] ?? ''.'+'.$arrDeliver['deliaddr'].'+'.$arrDeliver['deli_zip'].'+'.$arrDeliver['delicity'].$register, 
                          $hint='@Show address on map', $target='_blank');
            htm_AcceptButt($labl='@Delivery note', $hint='@Show delivery note for delivery', $btnKind='sear', $frmName='deliver', $width='', $akey='l', $rtrn=false,  $tipplc='LblTip_text', $tipstyl='',
                            $clickFunction="toast(\"<b>DEMO:</b><br>$delName <br>$delAddr <br>$delPlac <br>$del_Zip - $delCity\",\"lightyellow\",\"black\")");
            htm_MiniNote('<span class="colrblue">'.lang('@Blue ').'</span>'.lang('@frames and customer type, Used for map lookup.'));
        htm_Panel_00( labl:'@Save',icon:'',hint:'',name:'',form:$fm, subm:true,attr:'',akey:'',kind:'save',simu:false);

        htm_Panel_0( capt: '@Person contact:', icon: 'fas fa-phone-square', hint: '',
                     form: $fm='cont', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');

            function ContaktPers($arrCont,$no='') {
                htm_Input(labl:'@No.',           plho:'@auto',        icon:'',hint:'@Specifies the order of the entries',
                          type:'text',name:$n='contindx' /* 'id' */, valu:$arrCont[$n],form:'',wdth:'15%', algn:'center', attr:'',rtrn:false,unit:'',disa:true,rows:'3',step:'1');
                htm_Input(labl:'@Contact person',plho:'@Kont...',    icon:'',hint:'@Enter Contact person',              
                          type:'text',name:$n='contname',  valu:$arrCont[$n],form:'',wdth:'50%');
                htm_Input(labl:'@Titel',         plho:'@Titl...',    icon:'',hint:'@Enter the persons titel',           
                          type:'text',name:$n='conttitel', valu:$arrCont[$n],form:'',wdth:'35%');
                htm_Input(labl:'@Phone',         plho:'@Phon...',    icon:'',hint:'@Enter phone number',                
                          type:'text',name:$n='contphone', valu:$arrCont[$n],form:'',wdth:'50%');
                htm_Input(labl:'@Mobil',         plho:'@Mobil/lok..',icon:'',hint:'@Enter Mobilnr. or  lokal',          
                          type:'text',name:$n='contmobil', valu:$arrCont[$n],form:'',wdth:'50%', algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3');
                htm_Input(labl:'@E-mail',        plho:'@Mail...',    icon:'',hint:'@Enter E-mail',                      
                          type:'mail',name:$n='contemail', valu:$arrCont[$n],form:'',wdth:'80%');
                htm_Input(labl:'@Remark',        plho:'@Note...',    icon:'',hint:'@Enter note to the contact, e.g. role (director / secretary / driver)',
                          type:'area',name:$n='contremark',valu:$arrCont[$n],form:'',wdth:'80%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'1');
                htm_hr('lightgray');
                htm_AcceptButt( labl:'@Delete',  icon:'',hint:'@Remove this contact person <br> (DEMO yet!)', form:'contact_'.$no, wdth:'', attr:'', akey:'',kind:'eras', rtrn:false, tplc:'', tsty:'position: absolute; bottom: 8px;', acti:'toast("Remove contact<br>Cant do it yet !","lightyellow","black")');
                htm_hr('green'.'; height: 2px');
                htm_nl(1);
            }
            if ($arrContact) { 
                if (is_array($arrContact[0])) 
                    $max= count($arrContact); else $max= 1;
                for ($i= 0; $i < $max; $i++) { ContaktPers($arrContact[$i],$no=$i); }
            }
            else htm_Caption('@No contacts created.');
            htm_AcceptButt( labl:'@Create new',  icon:'', hint:'@Create a new contact <br> (DEMO yet!)',  form:$fm,  wdth:'',  attr:'', akey:'', kind:'crea', rtrn:false, tplc:'', tsty:'position: absolute; bottom: 8px;', acti:'toast("Create contact<br>Cant do it yet !","lightyellow","black")');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:$fm, subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

        htm_Panel_0( capt: '@Order notes:', icon: 'fas fa-plus', hint: '',
                     form:$fm='cstn', acti: '', clas: 'panelW280', wdth: '', styl: 'background-color: white;', attr: '');
            htm_Input(labl:'@Order ',                   plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu: $arrCustomr[$n],       form:'', wdth:'0%', algn:'left',attr:'',   rtrn:false); 
            htm_Input(labl: '@Date',                    plho: '',               icon:'', hint: '@Here you can save a date for writing the notes', 
                      type:'date', name:$n=$fm.'date',  valu: $arrCustnot[$n] ?? '', form:'', wdth:'96%',rows:'9');
            htm_Input(labl: '@Notes',                   plho: '@Write here...', icon:'', hint: '@Notes associated with the order', 
                      type:'area', name:$n=$fm.'note',  valu: $arrCustnot[$n] ?? '', form:'', wdth:'96%',rows:'9');
        htm_Panel_00( labl:'@Save',  icon:'',  hint:'', name:'',  form:$fm, subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'',  form:'', subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Panel_0( capt: '@Content of the order:'.$strOrder.' - '.$status, icon: 'fas fa-pen', hint: '',
                 form: $f='content', acti: '', clas: 'panelW560', wdth: '', styl: 'background-color: rgba(240, 240, 240, 0.80);', attr: '',head:$headbg);
        global $ordrTotal;
        $link= '#';
        $ordrTotal= 0;
        
        htm_Table(
            TblCapt: [],
            RowPref: [],
            RowBody: [
                ['@Id.',          '5%','hidd', '',  ['center'],'id',             '@Id in the database','..auto..'],
                ['@Pos.',         '5%','indx', '',  ['center'],'cnt_post',       '@Position number. is assigned automatically','..auto..'],
                ['@Item no.',     '9%','text', '',  ['center'],'cnt_product',    '@Item number for the service','@Item...'],
                ['@Quantity',     '3%','text', '1d',['center'],'cnt_numb',       '@Quantity stated as number','@Quan...'],
                ['@Unit',         '6%','text', '',  ['left'  ],'cnt_unit',       '@Unit designation','@Unit...'],
                ['@Description', '26%','text', '',  ['left'  ],'cnt_description','@Description of the product / service','@Dest...'],
                ['@VAT' ,         '5%','text', '1d',['center'],'cnt_vat',        '@VAT pct. rate','@vat...'],
                ['@Price',        '8%','text', '2d',['center'],'cnt_price',      '@Unit price ','@Price...'],
                ['@%',            '6%','text', '1d',['right' ],'cnt_discount',   '@Discount percent','@Disc...'],
                ['@Total',       '10%','calc', '2d',['right' ],'cnt_total',      '@Calculated amount for the current posting.',''],
                ['@Currency',     '5%','ddwn', '',  ['center'],'cnt_currency',   '@Currency code for the currency used on the specification.','@Curr...','',[CurrencyArr(),'width: 55px;']],
                
              //['@Status',       '9%','ddwn', '',  ['left'  ],'cnt_stat',       '@Status',                                               '@Status...',  '',[OrdrStatu(),'width: 65px;']],
              /* ['@Maturity',     '9%','date', '',  ['center'],'cnt_duedate', '@Due date of the amount','@Due...'], */
            ],
            RowSuff: [
                # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:value! ']
                ['@Account',        '5%',     'text',     '',  ['center; font-size:smaller'],    '@Posting account and VAT code.','5600'],
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
                          butt:[ ['@clos'],['@hint','','@Got it'] ],  html:
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
                          butt:[ ['@clos'],[@'warn','','@Got it'] ],  html:
                          '<ic class="fas fa-undo" style="font-size:14px; color:orange;" title="'.
                          lang('@Reverse this entry, e.g. undo reminder fee').'"></ic>')
                ],
                ['@Mov.', '2%','text', '',  ['center'], '@Move an entry up or down.',
                        /*    '<button type="button" onclick=\'phpDialog()\'><ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
                              lang('@Not working yet').'"></ic></button>' */
                htm_ModalDialog(type:'succ',capt:'@DEMO page!', 
                          mess:'@The site is still under development.<br>The function to move up/down is not finished yet.', 
                          butt:[ ['@clos'],['@succ','','@Got it'] ],  html:
                          '<ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
                          lang('@Can`t move an entry up or down yet.').'"></ic>')
                ] // /* toast("Moving this post<br>Cant do it yet !","lightyellow","black") */
                
            ],            # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
            TblNote :   '<small>This table contains an example of on the fly automatic calculation:<br>$total= ($DataRow[2]*$DataRow[6])*(100-$DataRow[7])/100*(100+$DataRow[5])/100;</small>',
            TblData :   $arrContent,
            FilterOn:   false,        
            SorterOn:   true,         
            CreateRec:  true,         
            ModifyRec:  true,         
            ViewHeight: '250px',    
            CalledFrom: __FUNCTION__
        ); // htm_Table
    htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'cont',  form:$f, subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);



    htm_Panel_0( capt: '@Handling the offer/order:'.$strOrder.' '.$status, icon: 'fas fa-check', hint: '', form: 'handling', acti: '', clas: 'panelW560', wdth: '', styl: 'background-color: lightgray;', attr: '',head:$headbg);
        $heading= [['@Pos.','center'],['@Item no.','center'],['@Quantity','right'],['@Unit','left'],['@Description','left'],['@VAT','center'],
                   ['@Price','right'],['@%','right'],['@Total','right'],['@Currency','center']];
        $body= '<small>Preview:<br><table style="margin: 0 auto; width:700px;"><thead>';
        foreach ($heading as $h) {$body.= '<th>'.lang($h[0]).'</th>'; };
        $body.= '</thead>';
/*      ['@Item no.',     '9%','text', '',  [''      ],'cnt_product',    '@Item number for the service','@Item...'],
        ['@Quantity',     '3%','text', '1d',['center'],'cnt_numb',       '@Quantity stated as number','@Numb...'],
        ['@Unit',         '6%','text', '',  ['left'  ],'cnt_unit',       '@Unit designation','@Unit...'],
        ['@Description', '26%','text', '',  ['left'  ],'cnt_description','@Description of the product / service','@Dest...'],
        ['@VAT' ,         '5%','text', '1d',['center'],'cnt_vat',        '@VAT pct. rate','@vat...'],
        ['@Price',        '8%','text', '2d',['center'],'cnt_price',      '@Unit price ','@Price...'],
        ['@%',            '6%','text', '1d',['right' ],'cnt_discount',   '@Discount percent','@Disc...'],
        ['@Total',       '10%','calc', '2d',['right' ],'cnt_total',      '@Calculated amount for the current posting.',''],
        ['@Currency',     '5%','ddwn', '',  ['center'],'cnt_currency',   '@Currency code for the currency used on the specification.','@Curr...','',[CurrencyArr(),'width: 55px;']],   */    
        // arrPretty($arrContent,'$arrContent');
        if ($arrContent!=null) 
        foreach($arrContent as $row) if ($row['cnt_total']>120) {
            $body.= '<tr>';
            $i= count($heading)-11;
            foreach ($row as $r) { 
                if ($i>=0) $body.= '<td style="text-align: '.$heading[$i][1].';">'.$r.'</td>'; 
                $i++;
            }
            $body.= '</tr>';
        }
        $body.= ' </table></small>';    
        htm_TextDiv(body:$body, algn:'center',marg:'8px',styl:'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ');
        htm_Input(labl:'@Order number',             plho:'Hidden field',    icon:'',hint:'Hidden field',                 
                      type:'hidd',name:$n='ordrnumb',   valu:$ordrnumb,   form:'',wdth:'0%', algn:'left',attr:'',        rtrn:false,unit:'',disa:false,rows:'3',step:'',list:[]); 
        htm_Input(labl:'<b>'.lang('@Order:').'</b>',    plho:'',icon:'fas fa-hashtag',       hint:'@System field: Order number',    
                  type:'text',name:'ordr',valu:$ordrnumb,form:'',wdth:'100px',algn:'left',  attr:'',rtrn:false,unit:'',     disa:true,rows:'1',step:'');
        htm_Input(labl:'<b>'.lang('@Customer:').'</b>', plho:'',icon:'far fa-pen-to-square', hint:'@System field: Customer name',   
                  type:'text',name:'cust',valu:'Customer',form:'',wdth:'400px',algn:'left',  attr:'',rtrn:false,unit:'',     disa:true,rows:'1',step:'');
        htm_Input(labl:'<b>'.lang('@Total:').'</b>',    plho:'',icon:'far fa-credit-card',   hint:'@System field: Amount incl. VAT',
                  type:'dec2',name:'totl',valu:$ordrTotal,form:'',wdth:'120px',algn:'center',attr:'',rtrn:false,unit:' DKK ',disa:true,rows:'1',step:'');
        htm_nl(2);
                    # $labl='',$icon,$hint='',$form='',$wdth='',$attr,$akey='',$kind='',$rtrn=true,$tplc='LblTip_text',$tsty='',$clicking='',$idix='');
        htm_AcceptButt(labl:'@Create / update', icon:'',hint:lang('@Save the order'),                                        form:'handling', wdth:'120px',attr:'' ,akey:'', kind:'save',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;');
        htm_nl(2);                          //  icon:'',hint:                                                                form:,wdth:,$attr,                :'' ,                             :                                   :
      //htm_AcceptButt(labl:'@Lookup',          icon:'',hint:lang('@Browse other existing orders'),                          form:'doLookup' wdth:'140px', attr:'' ,akey:'', kind:'goon',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Lookup<br>Cant search yet !","orange","black")');
        htm_AcceptButt(labl:'@Save as Offer',   icon:'',hint:lang('@Create offer for registration'),                         form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Save as Order',   icon:'',hint:lang('@Create invoice for (the saved!) Order'),                 form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Save as a role model',icon:'',hint:lang('@Reuse content for re-creation'),                     form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Create Invoice',  icon:'',hint:lang('@Create invoice for (the saved!) Order'),                 form:'doInvo',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create invoice<br>Cant create yet !","orange","black")');
    //htm_AcceptButt(labl:'@Make Delivery Note',icon:'',hint:lang('@Make delivery note for the shipment of the order'),      form:'doNote',  wdth:'140px', attr:'' ,akey:'', kind:'creat', rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Make delive note<br>Cant create yet !","orange","black")');
        htm_AcceptButt(labl:'@Give credit',     icon:'',hint:lang('@Reset by crediting the order - if it is invoiced'),      form:'doCredit',wdth:'140px', attr:'' ,akey:'', kind:'goon',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Give credit<br>Cant do it yet !","orange","black")');
        htm_AcceptButt(labl:'@Delete',          icon:'',hint:lang('@Delete the order - provided the invoice is not formed'), form:'doErase', wdth:'140px', attr:'' ,akey:'', kind:'eras',  rtrn:false, tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Delete<br>Cant erase yet !","orange","black")');
        //  $rtrn=true, $tipplc='LblTip_text', $tipstyl='',$clickFunction='', $attr )
        htm_nl(2);
    htm_Panel_00( labl:'',  icon:'',  hint:'',  name:'',  form:'', subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Fieldset_00(); 
    htm_nl(3);

    htm_Panel_0( capt: '@Settings:', icon: 'fas fa-wrench', hint: '', form: 'language', acti: '', clas: 'panelW320', wdth: '', styl: 'background-color: white;', attr: '');
        htm_TextDiv('@Change the language for this project: <br>');

           # PHP7: $labl='',$plho='@Enter...',$icon='',$hint='',$type= 'text',$name='',$valu='',$form='',$wdth='',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='2',$step='',$list=[],$llgn='R',$bord='',$ftop='');
        htm_Input(labl:'@Select language',plho:'',icon:'',hint:'@Select among installed languages',
                  type:'opti',name:'language',valu:$lang,form:'',wdth:'50%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'3',step:'',
                  list: [['en','@English','@Select english language'], 
                         ['fr','@French','@Select french language'],
                         ['de','@German','@Select german language'],
                         ['da','@Dansk','@Select danish language']]);
        htm_TextDiv('@Note: The translate is not complete !<br>It is created with Google Translate, <br>and needs proofread.<br>');
    htm_Panel_00(labl:'@Save and use',  icon:'',  hint:'',  name:'', form:'language',  subm:true,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_Panel_0(capt: '@Info about this page:', icon: 'fas fa-info', hint: '', form: 'demo', acti: '', clas: 'panelW320', wdth: '', styl: 'background-color: lightyellow;', attr: '');
        htm_TextDiv('@This is a demo under development !<br>It partly stores data to JSON text files.<br>
                     Translations from English lack <br>proofreading, on Google translate. <br>
                     There is also a lack of functionality.<br>Code written for PHP 8+ !<br>');
    htm_Panel_00(labl:'@Save', icon: '', hint: '', name: '', form: '',subm: false, attr: '', akey: '', kind: 'save', simu: false);

    htm_nl(1);
    htm_Panel_0( capt: '@Overview of all variables:', icon: 'fas fa-info', hint: '@Here you can see all variables on the page.', form:$form='demo', acti: '', 
                 clas: 'panelWaut', wdth: '320px', styl: 'background-color: lightyellow;', attr: '');
        arrPretty(get_defined_vars(),'Defined_vars:');
    htm_Panel_00( labl:'@Save',  icon:'',  hint:'',  name:'', form:$form,  subm:false,  attr:'',  akey:'',  kind:'save',  simu:false);

    htm_nl(0);
    htm_Panel_0(capt: '@Adaptive - Tip:', icon: 'fas fa-info', hint: '', form: 'demo', acti: '', clas: 'panelW320', wdth: '', styl: 'background-color: lightyellow;', attr: '');
        htm_TextDiv('@To see how it adapts to narrow screens,<br> 
                     close the panels with wide tables.<br>
                     <br>'); 
    htm_Panel_00(labl:'@Save', icon: '', hint: '', name: '', form: '',subm: false, attr: '', akey: '', kind: 'save', simu: false);

    htm_hr('gray; height:2px;border-width:0;');
    
/// echo '<div style="text-align:left;">'.$report.'</div>';
    
htm_Page_00();
 
    run_Script('toast("<b>'. lang('@This page needs PHP 8+ !. <br>'). '</b>'.  '","lightgreen","blacck",1500)');

$savedBytes= 0;
    if ($savedBytes== 0) {   // page just opened
        PanelOff($First= 3,$Last=12); // Close panel 3 to 11,
        PanelOff($First=13,$Last=17);
        PanelOff($First= 1,$Last= 1);
    }
    $arrData= '';
    /// getState();     arrPretty($_POST,'_POST');
    /// echo '<input type="hidden" id="input_hidden_field" name="input_hidden_field" value="'.$arrData.'">';
    /// if (isset($_POST['input_hidden_field'])) $arrData = json_decode($_POST['input_hidden_field'], true); else echo '-';
    // arrPretty($arrData);
    
/* $array=json_decode($_POST["jsondata"]);
arrPretty($array); */ 
##### CLEANUP:


?>