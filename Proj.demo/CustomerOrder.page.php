<?php   $DocFil= './Proj.demo/CustomerOrder.page.php';    $DocVer='1.1.0';    $DocRev='2021-11-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= './../';
require ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
require_once ('../filedata.inc.php');

### SPECIAL this page only:
require_once ('../Data.demo/datainit.inc.php');

function refresh($name) {if (isset($_POST[$name]))  {$_SESSION[$name]= $$name= htmlspecialchars($_POST[$name]); return $$name; } } //  En variabel med navnet: $name er opdateret, og husket i _SESSION. Værdien returneres
function set_FormVars ($names) { foreach ($names as $name) $$name= refresh($name); }  //  No: $$name is not a typeerror. It is the value of the variable with the name $name
function get_FormVars ($names) { foreach ($names as $name) $$name= $_SESSION[$name] ?? ''; }
function dev_show() { if ($GLOBALS["Ødebug"]) {echo 'SESSIONS variablers indhold: ';  vis_data($_SESSION);} }

function indxCheck(&$arrData,$name,$pref='') {
    $id= -1;    $arrTemp= [];
    foreach ($arrData as $rec) {
        if ($rec[$name]=='') {$id= $id+1; $rec[$name]=$pref.$id; } else $id= $rec[$name];
        $arrTemp[]= $rec;
    } $arrData= $arrTemp;
}

// session_destroy();  //  Slet alle SESSIONS variabler (Luk browser, sletter ikke ! ?)
// arrPrint($_SESSION,'$_SESSION');
// arrPrint($_POST,'$_POST');


$test= false;
$KIS = false;

if ($test) arrPrint($_POST,'$_POST');

##### DATA EXCHANGE:
$dPath= '../Data.demo/';

### SAVE to database:    (DEMO: to files)
# UPDATE files:

$bytes= 0;
# activated buttons:
if (isset($_POST['btn_sav_orders'  ])) { tabl2arr($arrOrders,'ord_id',['ord_total']); 
                                                                $bytes+= FileWrite_arr($dPath.$filepath= 'arrOrders.dat.json',$arrOrders );}
//if (false)
if (isset($_POST['btn_sav_content' ])) { tabl2arr($arrContent,'cnt_post',['cnt_price', 'cnt_total']);  
                                                                $bytes+= FileWrite_arr($dPath.$filepath='arrContent.dat.json',$arrContent);}
if (isset($_POST['btn_sav_customr' ])) { form2arr($arrCustomr); $bytes+= FileWrite_arr($dPath.$filepath='arrCustomr.dat.json',$arrCustomr);}
if (isset($_POST['btn_sav_billing' ])) { form2arr($arrBilling); $bytes+= FileWrite_arr($dPath.$filepath='arrBilling.dat.json',$arrBilling);}
if (isset($_POST['btn_sav_deliver' ])) { form2arr($arrDeliver); $bytes+= FileWrite_arr($dPath.$filepath='arrDeliver.dat.json',$arrDeliver);}
if (isset($_POST['btn_sav_conditi' ])) { form2arr($arrConditi); $bytes+= FileWrite_arr($dPath.$filepath='arrConditi.dat.json',$arrConditi);}
if (isset($_POST['btn_sav_mailinv' ])) { form2arr($arrMailing); $bytes+= FileWrite_arr($dPath.$filepath='arrMailing.dat.json',$arrMailing);}
if (isset($_POST['btn_sav_contact' ])) { form2arr($arrContact); $bytes+= FileWrite_arr($dPath.$filepath='arrContact.dat.json',$arrContact);}
if (isset($_POST['btn_sav_custFld' ])) { form2arr($arrCustfld); $bytes+= FileWrite_arr($dPath.$filepath='arrCustfld.dat.json',$arrCustfld);}
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
//if (!$arrCustomr)
$arrNames= ['arrCustomr','arrBilling','arrDeliver','arrConditi','arrMailing','arrContact','arrCustfld','arrOrders' ,'arrContent'];
if (DEBUG) run_Script('$Timers->startTimer("fread");');
fromfile($dPath, $arrNames);
if (DEBUG) run_Script('$Timers->endTimer("fread");');

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

htm_Page_0($pageTitl='OrderCreate.page.php', $ØPageImage= $ØProgRoot.'_accessories/_background.png',$align='center',
           $PgInfo=lang('@Example: Customer-ORDER Build with <b style="color:darkgreen;">PHP2HTML</b>'),
           $PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'),$headScript='',$pageBorder= true);
    Menu_Topdropdown(true); htm_nl(1);


if ($test) echo '<pre>'.$log.'</pre>'. '<br>Saved: '.$bytes.' bytes to data-files.<br>';
//arrPrint($transTable['da']['Data-field in new record'],'$transTable');  // ->  'Datafelt i ny rekord'
//arrPrint($transTable['da']['Billing:'],"transTable['da']['Billing:'");

    //echo '<b>Cloud-Accounting</b><br>';
    htm_Caption($labl='Tiny-Cloud-Accounting',$style='color:'.$ØTitleColr.'; font-weight:600; font-size: 18px;',$align='center');
    htm_nl(1);
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    htm_Panel_0($frmName='orders', $capt=lang('@Find existing order:'), $parms='', $icon='fas fa-search', $class='panelW960', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
        
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
            /* $TblData=  */ $arrOrders,
            $FilterOn= true,     
            $SorterOn= true,     
            $CreateRec=false,    
            $ModifyRec=true,     
            $ViewHeight= '200px',
            $TblStyle= '',       
            $CalledFrom= __FUNCTION__
          );
    htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


    htm_Panel_0($frmName='', $capt=lang('@Create new or modify order:'), $parms='', $icon='fas fa-pen', $class='panelW960', $where=__FILE__, 
            $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);',$closWidth='',
            $panlHint='Demo ! <br>No connection to a DataBase. <br>Read/save from/to JSON-files.');

        htm_Panel_0($frmName='customr', $capt=lang('Customer:'), $parms='', $icon='fas fa-user', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='custkont',$valu=$arrCustomr[$name], $labl='@Customer nr.',        $hint='@Customer nr: Can not be edited, onlu created. The system sets this',$plho='@..auto..', $width='50%');
            htm_Input($type='opti',$name='custopsl',$valu=$arrCustomr[$name], $labl='@Customer Lookup',     $hint='@Here you select which existing customer to select',$plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list= []); //CustList());
            htm_Input($type='rado',$name='custkate',$valu=$arrCustomr[$name], $labl='@Customer type',       $hint='@Customer kategori',              $plho='',                $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='required',
                      $list= [ ['priv', '@private', '@private'], ['prof', '@professional', '@professional']]);
            htm_Input($type='text',$name='cust_cvr',$valu=$arrCustomr[$name], $labl='@CVR',                 $hint='@CVR - Virksomheds ID.',          $plho='@Business only !',$width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid green;');
            htm_Input($type='text',$name='cust_ean',$valu=$arrCustomr[$name], $labl='@EAN',                 $hint='@EAN - Elektronisk-betalings ID', $plho='@Business only !',$width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid green;');
            htm_Input($type='text',$name='custbreg',$valu=$arrCustomr[$name], $labl='@Bank reg.',           $hint='@Bank reg.',                      $plho='Reg...',          $width= '33%');
            htm_Input($type='text',$name='custbkto',$valu=$arrCustomr[$name], $labl='@Bank account',        $hint='@Bank account',                   $plho='Account...',      $width= '66%');
            htm_Input($type='text',$name='custinst',$valu=$arrCustomr[$name], $labl='@Institution',         $hint='@Additional information',         $plho='@Business only !',$width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid green;');
            htm_Input($type='text',$name='custansv',$valu=$arrCustomr[$name], $labl='@Customer manager',    $hint='@Customer manager',               $plho='@Mana...',        $width='100%');
            htm_Input($type='text',$name='custlang',$valu=$arrCustomr[$name], $labl='@Billing Language',    $hint='@The language to be used on invoice transcripts',$plho='@if the language is not local', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='R',$bord='border: 1px solid green;');
            htm_Input($type='text',$name='custhome',$valu=$arrCustomr[$name], $labl='@Homepage',            $hint='@The customer Homepage',          $plho='@Business only!', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid green;');
            htm_MiniNote('@Orange boxes are required fields.');
            htm_MiniNote('@Green boxes - restricted use.');

        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


        htm_Panel_0($frmName='billing', $capt=lang('Billing:'), $parms='', $icon='fas fa-pen', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='area',$name='billoref',$valu=$arrBilling[$name] ?? '', $labl='@Order info',           $hint='@@Systemfield: Auto fill out, when order is created/saved',$plho='@Order:... Date:...',   $width='100%', $algn='left',$unit='',$disa=true,$rows='1');
            htm_Input($type='text',$name='billnavn',$valu=$arrBilling[$name] ?? '', $labl='@Customer name',        $hint='@Enter costomer name',          $plho='@Name...',       $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='required');
            htm_Input($type='text',$name='billaddr',$valu=$arrBilling[$name] ?? '', $labl='@Customer address',     $hint='@Enter invoice address',        $plho='@Address...',     $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='required');
            htm_Input($type='text',$name='billsted',$valu=$arrBilling[$name] ?? '', $labl='@Customer place',       $hint='@Enter invoice place',          $plho='@Place...');
            htm_Input($type='text',$name='billponr',$valu=$arrBilling[$name] ?? '', $labl='@ZIP',                  $hint='@ZIP code',                     $plho='@ZIP...',       $width='30%', $algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='required');
            htm_Input($type='text',$name='billbynv',$valu=$arrBilling[$name] ?? '', $labl='@Invoice city',         $hint='@Invoice city',                 $plho='@City...',      $width='68%', $algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='required');
            htm_Input($type='text',$name='billland',$valu=$arrBilling[$name] ?? '', $labl='@Invoice Country',      $hint='@Invoice Country',              $plho='@Country...');
            htm_hr($ØTitleColr.'; height: 2px');
            htm_Input($type='text',$name='billtelf',$valu=$arrBilling[$name] ?? '', $labl='@Phone(s)',             $hint='@Phone, mobil, fax',            $plho='@Phone...',     $width='100%',$$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='required');
            htm_Input($type='text',$name='bill_att',$valu=$arrBilling[$name] ?? '', $labl='@Attention',            $hint='@Attention - Customer contact', $plho='@Att...'  );
            htm_Input($type='text',$name='billrekv',$valu=$arrBilling[$name] ?? '', $labl='@Réquisition number',   $hint='@Customer reference to order',  $plho='@Ref...'  );
            htm_Input($type='text',$name='billmail',$valu=$arrBilling[$name] ?? '', $labl='@Email address',        $hint='@Customer Email address',       $plho='@Mail...' );
            htm_Input($type='text',$name='billnote',$valu=$arrBilling[$name] ?? '', $labl='@Remarks',              $hint='@Notes regarding the customer', $plho='@Rem...'  );
            if (isset($_POST['use_mail'])) { $use_mail = 'checked'; }
            htm_Input($type='chck',$name='use_mail',$valu=$arrBilling[$name] ?? '', $labl='@Mailing',              $hint='@Send invoice with mail',       $plho='@...',          $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='', $list= [['use_mail','@Use mail','@Mailing active',$namechck ?? '']]);
            htm_Input($type='date',$name='ordrdato',$valu=$arrBilling[$name] ?? '', $labl='@Order Date',           $hint='@Dato for ordrens oprettelse',  $plho='@Date...',      $width='50%');
            htm_Input($type='date',$name='faktdato',$valu=$arrBilling[$name] ?? '', $labl='@Invoice Date',         $hint='@Invoice Date',                 $plho='@Date...',      $width='50%');
            htm_Input($type='date',$name='gen_fakt',$valu=$arrBilling[$name] ?? '', $labl='@Rebills',              $hint='@When to rebill date',          $plho='@Date...',      $width='50%');
            htm_MiniNote('@Orange boxes are required fields.');

        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


        htm_Panel_0($frmName='deliver', $capt=lang('Delivery:'), $parms='', $icon='fas fa-truck', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='chck', $name='sameaddr',  $valu= $arrDeliver[$name], $labl='@Delivered to invoice address', $hint='@Check here if the delivery address is the same as the invoice address',$plho='', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',
            $list= [['sameaddr','@Same address','@Automatic fillout with the same address as invoice',$namechck ?? '']]);
            htm_Input($type='text', $name='deliname', $valu= $arrDeliver[$name] ?? '', $labl='@Recipient Name',   $hint='@Enter Recipient Name',          $plho='Name...',         $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid blue;');
            htm_Input($type='text', $name='deliaddr', $valu= $arrDeliver[$name] ?? '', $labl='@Delivery Address', $hint='@Enter Delivery Address',        $plho='Addr..',       $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid blue;');
            htm_Input($type='text', $name='deliplac', $valu= $arrDeliver[$name] ?? '', $labl='@Place of Delivery',$hint='@Specify Place of Delivery, supplement to address',$plho='Sted...', $width='100%');
            htm_Input($type='text', $name='deli_zip', $valu= $arrDeliver[$name] ?? '', $labl='@ZIP',              $hint='@Enter Delivery Customer postcode', $plho='Pnr..',        $width='30%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid blue;');
            htm_Input($type='text', $name='delicity', $valu= $arrDeliver[$name] ?? '', $labl='@City Name',        $hint='@Enter Delivery City name',      $plho='City..',         $width='68%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='',$bord='border: 1px solid blue;');
            htm_Input($type='text', $name='delicoun', $valu= $arrDeliver[$name] ?? '', $labl='@Delivery Country', $hint='@Specify Delivery Country',      $plho='Contry...');
            htm_hr($ØTitleColr.'; height: 2px');                                                            
            htm_Input($type='text', $name='deliphon', $valu= $arrDeliver[$name] ?? '', $labl='@Phone(s)',         $hint='@Enter Recipient`s Phone',       $plho='Phone..');
            htm_Input($type='text', $name='delikont', $valu= $arrDeliver[$name] ?? '', $labl='@Contact person at the delivery address', $hint='@Enter Contact Name',  $plho='Name...');
            htm_Input($type='mail', $name='delimail', $valu= $arrDeliver[$name] ?? '', $labl='@Recipient`s Email Address', $hint='@Enter Recipient`s Email Address',  $plho='Mail...');
            htm_Input($type='text', $name='shipmeth', $valu= $arrDeliver[$name] ?? '', $labl='@Shipping Method.', $hint='@Enter Shipping Information. How / with whom was the package sent?',$plho='Shipp...');
            htm_Input($type='area', $name='delinote', $valu= $arrDeliver[$name] ?? '', $labl='@Notes to freight forwarder',$hint='@Notes regarding package delivery', $plho='Note...', $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
            htm_Input($type='chck', $name='shipped_', $valu= $arrDeliver[$name] ?? '', $labl='@Status',           $hint='@Once the service has been sent, amounts can be redeemed', $plho='@Enter...',$width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',
            $list= [['shipped_','@Are shipped','@Ready for redemption',$shipped_ ?? '']]);
            htm_Input($type='date', $name='lev_dato', $valu= $arrDeliver[$name] ?? '', $labl='@Delivery Date',    $hint='@Possibly. shipment date',      $plho='Date...',      $width='50%'   );

            $delName= $arrDeliver['deliname'];
            $delAddr= $arrDeliver['deliaddr'];
            $delPlac= $arrDeliver['deliplac'];
            $del_Zip= $arrDeliver['deli_zip'];
            $delCity= $arrDeliver['delicity'];
            if ($arrCustomr['custkate']=='prof') $register='/firma'; else $register='/personer';
            htm_LinkButt(  $labl='@Address on map', $gotoLink='https://krak.dk/'. $arrDeliver['deliname'].'+'.$arrDeliver['deliaddr'].'+'.$arrDeliver['deli_zip'].'+'.$arrDeliver['delicity'].$register, $hint='@Show address on map', $target='_blank');
            htm_AcceptButt($labl='@Delivery note', $hint='@Show delivery note for delivery', $btnKind='sear', $frmName='deliver', $width='', $akey='l', $proc=true,  $tipplc='LblTip_text', $tipstyl='',
                            $clickFunction="toast(\"<b>DEMO:</b><br>$delName <br>$delAddr <br>$delPlac <br>$del_Zip - $delCity\",\"lightyellow\",\"black\")");
            htm_MiniNote('@Blue boxes and customer type, Used for map lookup.');
        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

if ($KIS!=true) {

        htm_Panel_0($frmName='conditi', $capt=lang('Conditions:'), $parms='', $icon='far fa-credit-card', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            #htm_Input($type='opti',$name='faktbynv',$valu=$arrCustomr[$name], $labl='@Faktura By',  $hint='@Faktura by', $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$attr='',$plho='@Bynavn...');
            htm_Input($type='opti', $name='debigrup', $valu= $arrConditi[$name], $labl='@Debtor group',      $hint='@Choose which group the customer belongs to', $plho='', $width='100%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='', $optlist= DEB_Grup() );
            htm_Input($type='opti', $name='betaling', $valu= $arrConditi[$name], $labl='@Payment method',    $hint='@How to pay',               $plho='', $width='100%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='', $optlist= DEB_Betl() );
            htm_Input($type='opti', $name='betfrist', $valu= $arrConditi[$name], $labl='@Payment deadline',  $hint='@How long is the deadline for payment', $plho='', $width='100%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='', $optlist= DEB_Frist(), $action='');
            htm_Input($type='opti', $name='print_to', $valu= $arrConditi[$name], $labl='@Print to',          $hint='@Choose how to print, save or send the document.',$plho='',$width='68%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',  $optlist= DEB_Dok() );
            htm_Input($type='text', $name='kunderef', $valu= $arrConditi[$name], $labl='@Customer reference',$hint='@for example. Requisitions no',   $plho='Ref...', $width='100%');
        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


        htm_Panel_0($frmName='mailinv', $capt=lang('Mail-invoice:'), $parms='', $icon='fas fa-envelope', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='mailemne', $valu= $arrMailing[$name], $labl='@Mail subject',        $hint='@Enter Mail subject',         $plho='@Subj...');
            htm_Input($type='area',$name='mailtext', $valu= $arrMailing[$name], $labl='@Mail message',        $hint='@Enter Mail text',            $plho='@Mess...');
            htm_Input($type='file',$name='mailvedh', $valu= $arrMailing[$name], $labl='<i class=\'fas fa-paperclip\'></i> '.lang('@Mail Annex'),          
                                                                                                              $hint='@Enter Attached file',        $plho='@Annex...');
            htm_Input($type='text',$name='mail__cc', $valu= $arrMailing[$name], $labl='@Copy to',             $hint='@Enter mail address to receive one copy of send mail',            $plho='Copy...');
            htm_Input($type='text',$name='mail__bc', $valu= $arrMailing['mail__bc'], $labl='@Blind-copy to',  $hint='@Enter mail address to receive one BC-copy (hidden) of sent mail',$plho='BCopy...');
        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);


        htm_Panel_0($frmName='contact', $capt=lang('Person contact:'), $parms='', $icon='fas fa-phone-square', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            function ContaktPers($arrCont,$value,$no='') {
                htm_Input($type='text', $name= 'indx'  ."[$no]", $valu= $arrCont['indx'  ]["$no"] ?? '', $labl='@No.',            $hint='@Specifies the order of the entries', $plho='@auto',      $width='15%',   $algn='center', $unit='',$disa=true,$rows='3',$step='1',$attr='' );
                htm_Input($type='text', $name= 'name'  ."[$no]", $valu= $arrCont['name'  ]["$no"] ?? '', $labl='@Contact person', $hint='@Enter Contact person',         $plho='@Kont...',      $width='50%');
                htm_Input($type='text', $name= 'titel' ."[$no]", $valu= $arrCont['titel' ]["$no"] ?? '', $labl='@Titel',          $hint='@Enter the persons titel',      $plho='@Titl...',      $width='35%');
                htm_Input($type='text', $name= 'phone' ."[$no]", $valu= $arrCont['phone' ]["$no"] ?? '', $labl='@Phone',          $hint='@Enter phone number',           $plho='@Pho...',       $width='50%');
                htm_Input($type='text', $name= 'mobil' ."[$no]", $valu= $arrCont['mobil' ]["$no"] ?? '', $labl='@Mobil',          $hint='@Enter Mobilnr. or  lokal',     $plho='@Mobil/lok...', $width='50%',   $algn='left',   $unit='',$disa=false,$rows='3','',''            );
                htm_Input($type='mail', $name= 'email' ."[$no]", $valu= $arrCont['email' ]["$no"] ?? '', $labl='@E-mail',         $hint='@Enter E-mail',                 $plho='@Mail...',      $width='80%');
                htm_Input($type='area', $name= 'remark'."[$no]", $valu= $arrCont['remark']["$no"] ?? '', $labl='@Remark',         $hint='@Enter note to the contact, e.g. role (director / secretary / driver)', $plho='@Note...', $width='80%',$algn='left',$unit='',$disa=false,$rows='1');

                htm_hr('lightgray');
                htm_AcceptButt($labl='@Delete', $hint='@Remove this contact person <br> (DEMO yet!)', $btnKind='eras', $frmName='contact_'.$no, $width='', $akey='', $proc=true, $tipplc='', $tipstyl='position: absolute; bottom: 8px;',$clickFunction='toast("Remove contact<br>Cant do it yet !","lightyellow","black")');
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

            htm_AcceptButt($labl='@Create new', $hint='@Create a new contact <br> (DEMO yet!)', $btnKind='crea', $frmName='contact', $width='', $akey='', $proc=true, $tipplc='', $tipstyl='position: absolute; bottom: 8px;',$clickFunction='toast("Create contact<br>Cant do it yet !","lightyellow","black")');
        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

        $content= '<small><b>Lookup in the CVR register</b> <br>(Business only !)<br>
            Copy or check data in the public company register.
            Data is provided by CVR API<br> </small>';

        htm_Panel_0($frmName='cvrform', $capt=lang('CVR-lookup:'), $parms='', $icon='fas fa-database', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_TextDiv($content, $align='left',$marg='8px',$attr='');
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
            htm_Input($type='opti', $name='cvrLand', $valu= $cvrLand='dk',  $labl='@Land registry',        $hint='@In what country do you want to apply?', $plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',   $optlist= CVR_Land(),$llgn='R',$bord='border: 1px solid green;');
            htm_Input($type='opti', $name='cvrKode', $valu= $cvrKode='search', $labl='@Search for',        $hint='@What do you know?',             $plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',   $optlist= CVR_Liste(),$llgn='R',$bord='border: 1px solid green;');
            htm_Input($type='text', $name='cvrSoeg', $valu= $cvrSoeg,       $labl='@CVR/P-uni./Phon/Name', $hint='@Enter here, data or company name that you want to search for',$plho='@Business only !', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list=[],$llgn='R',$bord='border: 1px solid green;');
            htm_MiniNote('@Green boxes are the basis for entry in the CVR.');
            htm_hr('lightgray');
            htm_AcceptButt($labl='@Search', $hint='@Start search in the CVR register', $btnKind='crea', $frmName='cvrform', $width='', $akey='s', $proc=true);

            htm_hr('green');
            htm_TextDiv($content=lang('Register data:'), $align='left',$marg='8px',$attr='');

            htm_Input($type='text', $name='cvrNumm', $valu= $cvrNumm ?? '', $labl='@CVR-number',  $hint='@Retrieved from the CVR register', $plho='@CVR...',  $width='33%');
            htm_Input($type='text', $name='cvrNavn', $valu= $cvrNavn ?? '', $labl='@Company Name',$hint='@Retrieved from the CVR register', $plho='@Name...', $width='66%');
            htm_Input($type='text', $name='cvrTelf', $valu= $cvrTelf ?? '', $labl='@Phone',       $hint='@Retrieved from the CVR register', $plho='@Phon...', $width='33%');
            htm_Input($type='text', $name='cvrAddr', $valu= $cvrAddr ?? '', $labl='@Address',     $hint='@Retrieved from the CVR register', $plho='@Addr...', $width='66%');
            htm_Input($type='text', $name='cvrPost', $valu= $cvrPost ?? '', $labl='@ZIP',         $hint='@Retrieved from the CVR register', $plho='@zip...',  $width='33%');
            htm_Input($type='text', $name='cvrBy',   $valu= $cvrBy   ?? '', $labl='@City',        $hint='@Retrieved from the CVR register', $plho='@City...',   $width='66%');
            htm_AcceptButt('@Use',lang('@Use the data shown in your registration of ').($hvem ?? '').'. <br>'. lang('@Warning: Possibly previous data is overwritten! (Fields without content, do not affect external data). <br> Not working yet'), $btnKind='save', $frmName='cvrform', $width='', $akey='b', $proc=true);
            htm_Input($type='area', $name='cvrDiv',   $valu= $cvrDiv ?? '',   $labl='@Other things',   $hint='@Retrieved from the CVR register, various supplementary data', $plho='@Various...', $width='100%');
        htm_Panel_00($labl='@Save', $subm=false, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

        $custFld= [
        //[ 0:Label,         1:Hint,                  2:Placeholder]
          ['@Extra Field 1','@Extras - Fill in the field 1','@Field 1...'],
          ['@Extra Field 2','@Extras - Fill in the field 2','@Field 2...'],
          ['@Extra Field 3','@Extras - Fill in the field 3','@Field 3...'],
          ['@Extra Field 4','@Extras - Fill in the field 4','@Field 4...'],
          ['@Extra Field 5','@Extras - Fill in the field 5','@Field 5...']
        ];
     //   $custFld= $arrCustfld['custFld'];
        htm_Panel_0($frmName='extra', $capt=lang('Extra fields:'), $parms='', $icon='fas fa-plus', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='felt1', $valu= $arrCustfld['felt1'] ?? '', $labl= lang($custFld[0][0]), $hint= lang($custFld[0][1]),$plho= lang($custFld[0][2]), $width='66%');
            htm_Input($type='text',$name='felt2', $valu= $arrCustfld['felt2'] ?? '', $labl= lang($custFld[1][0]), $hint= lang($custFld[1][1]),$plho= lang($custFld[1][2]), $width='66%');
            htm_Input($type='text',$name='felt3', $valu= $arrCustfld['felt3'] ?? '', $labl= lang($custFld[2][0]), $hint= lang($custFld[2][1]),$plho= lang($custFld[2][2]), $width='66%');
            htm_Input($type='text',$name='felt4', $valu= $arrCustfld['felt4'] ?? '', $labl= lang($custFld[3][0]), $hint= lang($custFld[3][1]),$plho= lang($custFld[3][2]), $width='66%');
            htm_Input($type='text',$name='felt5', $valu= $arrCustfld['felt5'] ?? '', $labl= lang($custFld[4][0]), $hint= lang($custFld[4][1]),$plho= lang($custFld[4][2]), $width='66%');
        htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);
        }

       htm_Panel_0($frmName='', $capt='', $parms='', $icon='', $class='panelW280', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; visibility: hidden;');
       ## Hidden placeholder to fillout the row
       htm_Panel_00();

    htm_Panel_00($labl='', $subm=false, $hint=''); // '@New order:'



    htm_Panel_0($frmName='content', $capt=lang('@Content of the order:'), $parms='', $icon='fas fa-pen', $class='panelW960', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
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
                htm_ModalDialog($Btype='erro',$capt='@DEMO page!',
                          $mess='@The site is still under development.<br>The function to delete row is not finished yet.', 
                          $butt=[ ['clos'],['erro','','Got it'] ], $html=
                          '<ic class="fas fa-trash-alt" style="font-size:14px; color:red;" title="'.
                          lang('@Delete the row! <br> WARNING - you can not regret.').'"></ic>')
                              // onclick="remove(\'row_5\')" deleteRow(\'table1\') / removeRow() - not working: FIXIT
                ],
                ['@Clon.', '2%','text', '',  ['center'],
                              lang('@Make a copy of this row<br> It will be added as the last row in the table'),
                        /*    '<button class="plusbtn" type="button" style="padding: 2px 4px;" ><ic class="far fa-clone" style="font-size:14px; color:blue;" ></ic></button>' */
                htm_ModalDialog($Btype='hint',$capt='@DEMO page!', 
                          $mess1='@The site is still under development.<br>The function to clone row is not finished yet.', 
                          $butt=[ ['clos'],['hint','','Got it'] ], $html=
                          '<ic class="far fa-clone" style="font-size:14px; color:blue;" title="'.
                          lang('@Make a copy of this row<br> It will be added as the last row in the table').'"></ic>')
                ],
                ['@Und.', '2%','text', '',  ['center'],
                              lang('@Undo posting! <br> Refund the amount by clicking on the icon.').' '.
                              lang('@If the order is invoiced, the item can be returned until the order has been posted. Then it must be done by crediting the customer!'),
                            /*   '<button style="padding: 2px 4px;" onclick=\'toast("Reverse this post<br>Cant do it yet !","lightyellow","black")\'><ic class="fas fa-undo" style="font-size:14px; color:orange;" title="'.
                              lang('@Reverse this entry, e.g. undo reminder fee').'"></ic></button>' */
                htm_ModalDialog($Btype='warn',$capt='@DEMO page!', 
                          $mess2='@The site is still under development.<br>The function to undo posting is not finished yet.', 
                          $butt=[ ['clos'],['warn','','Got it'] ], $html=
                          '<ic class="fas fa-undo" style="font-size:14px; color:orange;" title="'.
                          lang('@Reverse this entry, e.g. undo reminder fee').'"></ic>')
                ],
                ['@Mov.', '2%','text', '',  ['center'], '@Move an entry up or down.',
                        /*    '<button type="button" onclick=\'phpDialog()\'><ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
                              lang('@Not working yet').'"></ic></button>' */
                htm_ModalDialog($Btype='succ',$capt='@DEMO page!', 
                          $mess3='@The site is still under development.<br>The function to move up/down is not finished yet.', 
                          $butt=[ ['clos'],['succ','','Got it'] ], $html=
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
    htm_Panel_00($labl='@Save', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

    htm_Panel_0($frmName='handling', $capt=lang('Handling the offer/order:'), $parms='', $icon='fas fa-check', $class='panelW960', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: lightgray;');
        htm_nl(1);
        htm_Input($type='text', $name='ordr', $valu= $xx='0000', $labl='<b>'.lang('@Order:').'</b>',    $hint='@System field: Order number',     $plho='',   $width='100px',$algn='left',$unit='',$disa=true,$rows='1',$step='',$attr='');
        htm_Input($type='text', $name='cust', $valu= 'Customer', $labl='<b>'.lang('@Customer:').'</b>', $hint='@System field: Customer name',    $plho='',   $width='400px',$algn='left',$unit='',$disa=true,$rows='1',$step='',$attr='');
        htm_Input($type='dec2', $name='totl', $valu= $ordrTotal, $labl='<b>'.lang('@Total:').'</b>',    $hint='@System field: Amount incl. VAT', $plho= '',  $width='120px',$algn='center',$unit=' DKK ',$disa=true,$rows='1',$step='',$attr='');
        htm_nl(2);
        htm_AcceptButt('@Create / update', lang('@Save the order'),                                       $btnKind='save',   $frmName='handling', $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;');
        htm_nl(2);
      //htm_AcceptButt('@Lookup',          lang('@Browse other existing orders'),                         $btnKind='goon',   $frmName='doLookup', $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Lookup<br>Cant search yet !","orange","black")');
        htm_AcceptButt('@Save as Offer',   lang('@Create offer for registration'),                         $btnKind='creat',  $frmName='doInvo',   $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt('@Save as Order',   lang('@Create invoice for (the saved!) Order'),                 $btnKind='creat',  $frmName='doInvo',   $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Create invoice<br>Cant create yet !","orange","black")');
        htm_AcceptButt('@Create Invoice',  lang('@Create invoice for (the saved!) Order'),                 $btnKind='creat',  $frmName='doInvo',   $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Create invoice<br>Cant create yet !","orange","black")');
      //htm_AcceptButt('@Make Delivery Note',lang('@Make delivery note for the shipment of the order'),    $btnKind='creat',  $frmName='doNote',   $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Make delive note<br>Cant create yet !","orange","black")');
        htm_AcceptButt('@Give credit',     lang('@Reset by crediting the order - if it is invoiced'),      $btnKind='goon',   $frmName='doCredit', $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Give credit<br>Cant do it yet !","orange","black")');
        htm_AcceptButt('@Delete',          lang('@Delete the order - provided the invoice is not formed'), $btnKind='eras',   $frmName='doErase',  $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Delete<br>Cant erase yet !","orange","black")');
        //  $proc=false, $tipplc='LblTip_text', $tipstyl='',$clickFunction='', $attr )
        htm_nl(2);
    htm_Panel_00();

        htm_nl(1);

    htm_Panel_0($frmName='language', $capt='Settings:', $parms='', $icon='fas fa-wrench', $class='panelW320', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php');
        htm_TextDiv(lang('@Change the language for this page:<br>'));

        global $lang;
        htm_Input($type='opti',$name='language',$valu= $lang, $labl='@Select language', $hint='@Select among installed languages',$plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',
                $list= [['en','@English','@Select english language'],
                        ['fr','@French','@Select french language'],
                        ['de','@German','@Select german language'],
                        ['da','@Dansk','@Select danish language']]);
        htm_TextDiv('Note: The translate is not complete !<br> Only the Panel-headers will change.<br>');
    htm_Panel_00($labl='@Save and use', $subm=true, $hint='', $btnKind='save', $akey='', $simu=false, $frmName);

    htm_Panel_0($frmName='', $capt='Info about this page:', $parms='', $icon='fas fa-info', $class='panelW320', $where=__FILE__, $attr='', $BookMark='blindAlley.page.php',$panlBg='background-color: lightyellow; ');
        htm_TextDiv('This is a demo under development !<br>
            It stores data to JSON text files.<br>
            No connection to a SQL-database.<br>
            There is also a lack of functionality.<br>
        ');
    htm_Panel_00();


if ($KIS!=true) {
        if ($bytes== 0) {   // on page open
            PanelOff($First=5,$Last=11); // Close panel 5 to 11,
            PanelOff($First=14,$Last=15);
            PanelOff($First=1,$Last=1);
        }
    }
    // Menu_BottomScroll();
    htm_Dialog($capt='INFO', $content='@This demo stores data to JSON text files. <br>No connection to a SQL-database.<br>There is also a lack of functionality.', 
               $bgColor='lightyellow'/* , $buttons=[] */);
    
    htm_nl(1);
    htm_ActionButt($label='RightClick Me', $id='right_click', $form='', $type='button', $onclick='', $icon='', $hint='Try the Context-Menu', $attr='border-radius: 5px;', $echo=true);
  
    Pmnu_0($id='right_click',$capt='Context-Menu', $widt='280px',  $icon='',$stick='true',$attr='background-color:lightyellow; height: 16px;',$context=true);
    Pmnu_Item($type='plain',    $labl='@Select All',$hint='@Mark to select',$icon='far fa-object-group colrbrown iconsize',$id='d',$click='alert(\"sss\");',$attr='',$short='CTRL+A');
    Pmnu_Item($type='plain',    $labl='@Copy',  $hint='@Copy selected to text-buffer',$icon='fas fa-copy colrgreen iconsize',$id='d1',$click='alert(\"sss\");',$attr='',$short='CTRL+C');
    Pmnu_Item($type='plain',    $labl='@Paste', $hint='@Paste content in text-buffer',$icon='fas fa-paste colrblue iconsize',$id='d2',$click='alert(\"sss\");',$attr='',$short='CTRL+V');
    Pmnu_Item($type='separator',$labl='<hr>',   $hint='',$icon='',$id='',$click='',$attr='');
    Pmnu_Item($type='plain',    $labl='@Delete',$hint='@Delete the selected',$icon='fas fa-trash-alt colrred iconsize',$id='e',$click='',$attr='',$short='DEL'.str_sp(6));
    Pmnu_Item($type='plain',    $labl='@Cut',   $hint='@Cut the selected and save to text-buffer',$icon='fas fa-cut colrblue iconsize',$id='d3',$click='alert(\"sss\");',$attr='',$short='CTRL+X');
    Pmnu_Item($type='plain',    $labl='@Undo',  $hint='@Undo latest task',$icon='fas fa-undo colrblue iconsize',$id='d5',$click='alert(\"sss\");',$attr='',$short='CTRL+Z');
    Pmnu_Item($type='plain',    $labl='@Redo',  $hint='@Redo the last delete',$icon='fas fa-redo colrblue iconsize',$id='d4',$click='alert(\"sss\");',$attr='',$short='CTRL+Y');
    Pmnu_Item($type='separator',$labl='<hr>',   $hint='',$icon='',$id='',$click='',$attr='background-color:lightyellow;');
    Pmnu_Item($type='multi',    $labl='@Multi Menu',$hint='@Horisontal menu.',$icon='fas fa-home colrgreen iconsize',$id='e2',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Delete',$hint='@Delete the selected',$icon='fas fa-trash-alt colrred iconsize',$id='e',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Cut',   $hint='@Cut the selected and save to text-buffer',$icon='fas fa-cut colrblue iconsize',$id='d3',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Undo',  $hint='@Undo latest task',$icon='fas fa-undo colrblue iconsize',$id='d5',$click='',$attr='',$short='');
    Pmnu_Item($type='end_sub'); // multimenu
    Pmnu_Item($type='separator',$labl='<hr>',$hint='',$icon='',$id='',$click='',$attr='background-color:lightyellow;');
    Pmnu_Item($type='submenu',  $labl='@Sub Menu',$hint='@Open submenu.',$icon='fas fa-home colrgreen iconsize',$id='f1',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Sub Item 1',$hint='@Open...Sub Item 1',$icon='fas fa-link colrblue iconsize',$id='f2',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Sub Item 2',$hint='@Open...Sub Item 2',$icon='fas fa-link colrblue iconsize',$id='f3',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Sub Item 3',$hint='@Open...Sub Item 3',$icon='fas fa-link colrblue iconsize',$id='f4',$click='',$attr='',$short='');
    Pmnu_Item($type='end_sub'); // submenu
    Pmnu_Item($type='hovermenu',$labl='@Hover Menu',$hint='@Open hovermenu',   $icon='fas fa-bars colrgreen iconsize',$id='g1',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Sub Item 4',$hint='@Open...Sub Item 4',$icon='fas fa-link colrblue iconsize',$id='g2',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Sub Item 5',$hint='@Open...Sub Item 5',$icon='fas fa-link colrblue iconsize',$id='g3',$click='',$attr='',$short='');
    Pmnu_Item($type='subitem',  $labl='@Sub Item 6',$hint='@Open...Sub Item 6',$icon='fas fa-link colrblue iconsize',$id='g4',$click='',$attr='',$short='');
    Pmnu_Item($type='end_sub'); // hovermenu
    Pmnu_Item($type='footer',$labl='@<hr>A demo of PopUp menu, witch showup when you right-click an object<br><br>',$hint='',$icon='',$id='f',$click='',$attr='background-color:lightcyan;',$short='');
    // Pmnu_Item($type='plain',$labl='@Remove',$hint='@Hint 4',$icon='fas fa-minus colrred',$id='e',$click='',$attr='',$short='CTRL+V');
    Pmnu_00($labl='FOOTER',$hint='The menu footer.',$attr='background-color:lightyellow;');
    
    htm_nl(2);
        
htm_Page_00();

##### CLEANUP:

?>