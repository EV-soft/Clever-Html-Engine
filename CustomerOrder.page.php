<?php   $DocFil= './Proj1/CustomerOrder.page.php';    $DocVer='1.0.0';    $DocRev='2020-07-04';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

### SPECIAL this page:
//      [0:'value', 1:'@Label',     2:'@ToolTip',   3:'checked'],...
function DEB_Kateg () { return( [
        ['priv',    '@privat',     '@private'],
        ['prof',    '@erhverv','@professional'],
    ]);
}
function DEB_Grup () { return( [
        ['1', '@1. Danske debitorer',        '@1. Danske debitorer'],
        ['2', '@2. Europæiske debitorer',    '@2. Europæiske debitorer']
    ]  ); 
}
function DEB_Betl () { return( [
        ['1', '@Kontant',       '@Kontant'],
        ['2', '@Efterkrav',     '@Efterkrav'],
        ['3', '@Forud',         '@Forud'],
        ['4', '@Kreditkort',    '@Kreditkort'],
        ['5', '@Lb. måned',     '@Lb. Md.'],
        ['6', '@Konto',         '@Konto'] 
    ]  ); 
}
function DEB_Frist () { return( [
        ['0' , '@Straks' , '@Betaling øjeblikkelig' ],
        ['8' , '@8 dage' , '@Betaling inden 8 dage' ],
        ['14', '@14 dage', '@Betaling inden 14 dage'],
        ['30', '@30 dage', '@Betaling inden 30 dage']
    ]  ); 
}
function DEB_Dok () { return( [
        ['pdf',   '@PDF-fil','@Fil i pdf-format'       ],
        ['email', '@email'  ,'@Elektronisk forsendelse'],
        ['ioubl', '@OIOUBL' ,'@Elektronisk fakturering'],
        ['pbs',   '@PBS'    ,'@PBS faktura'            ]
    ]  ); 
}
function CVR_Land () {return( [
        ['dk',   '@Danmark', '@Søg i dansk register',   'checked'],
        ['no',   '@Norge',   '@Søg i norsk register',   '']
    ]  ); 
}
function CVR_Liste () {return( [  //  vat, name, produ, phone, search
        ['search','@Generelt', '@Generel søgning: (ikke telf.)',   ''],
        ['vat',   '@CVR',      '@Centralt Virksomheds Registernr', ''], 
        ['produ', '@P-enh.',   '@Produktionsenhed-nr',             ''],
        ['phone', '@Telefon',  '@Telefonnummer',                   ''],
        ['name',  '@Firma',    '@Firma navn',                      'checked']
    ]  ); 
}

function refresh($name) {if (isset($_POST[$name]))  {$_SESSION[$name]= $$name= htmlspecialchars($_POST[$name]); return $$name; } } //  En variabel med navnet: $name er opdateret, og husket i _SESSION. Værdien returneres
function set_FormVars ($names) { foreach ($names as $name) $$name= refresh($name); }  //  No: $$name is not a typeerror. It is the value of the variable with the name $name
function get_FormVars ($names) { foreach ($names as $name) $$name= $_SESSION[$name]; }
function dev_show() { if ($GLOBALS["Ødebug"]) {echo 'SESSIONS variablers indhold: ';  vis_data($_SESSION);} }

// session_destroy();  //  Slet alle SESSIONS variabler (Luk browser, sletter ikke ! ?)
// arrPrint($_SESSION,'$_SESSION');

function PanlSave(&$arr, $checks=[]) { 
    $result= [];
    foreach($_POST as $key=>$val) {
        if (substr($key,0,4) != 'btn_') $result[$key]= $val; 
    }
    # Unchecked boxes is not included in $_POST !    // $check_value = isset($_POST['my_checkbox_name']) ? 'checked' : 'unchecked';
    foreach ($checks as $ch) { if (!isset($_POST[$ch]))   $result[$ch]= 'unchecked'; }   
    $arr= $result;
}

##### DATA EXCHANGE:

### SAVE to database:    (DEMO: to files)
# UPDATE files:
$test= false;
$bytes= 0;
# activated buttons:
if (isset($_POST['btn_sav_customr'])) { PanlSave($arrCustomr);                                  $bytes+= FileWrite_arr($filepath='arrCustomr.dat', $arrCustomr); if ($test) $log= arrPrint($arrCustomr,'arrCustomr',false); }
if (isset($_POST['btn_sav_billing'])) { PanlSave($arrBilling, $checks=['use_mail']);            $bytes+= FileWrite_arr($filepath='arrBilling.dat', $arrBilling); if ($test) $log= arrPrint($arrBilling,'arrBilling',false); }
if (isset($_POST['btn_sav_deliver'])) { PanlSave($arrDeliver, $checks=['sameaddr','afs_endt']); $bytes+= FileWrite_arr($filepath='arrDeliver.dat', $arrDeliver); if ($test) $log= arrPrint($arrDeliver,'arrDeliver',false); }
if (isset($_POST['btn_sav_conditi'])) { PanlSave($arrConditi);                                  $bytes+= FileWrite_arr($filepath='arrConditi.dat', $arrConditi); if ($test) $log= arrPrint($arrConditi,'arrConditi',false); }
if (isset($_POST['btn_sav_mailinv'])) { PanlSave($arrMailing);                                  $bytes+= FileWrite_arr($filepath='arrMailing.dat', $arrMailing); if ($test) $log= arrPrint($arrMailing,'arrMailing',false); }
if (isset($_POST['btn_sav_contact'])) { PanlSave($arrContact);                                  $bytes+= FileWrite_arr($filepath='arrContact.dat', $arrContact); if ($test) $log= arrPrint($arrContact,'arrContact',false); }

if (isset($_POST['btn_sav_custFld'])) { PanlSave($arrCustfld);                                  $bytes+= FileWrite_arr($filepath='arrCustfld.dat', $arrCustfld); if ($test) $log= arrPrint($arrCustfld,'arrCustfld',false); }
if (isset($_POST['btn_sav_contact'])) {}    // { PanlSave($arrcontact);  /* $bytes+= FileWrite_arr($filepath='arrCustfld.dat', $arrCustfld); */ if ($test) arrPrint($arrCustfld,'arrCustfld'); }
if (isset($_POST['btn_cre_contact'])) {}    // Create new
if (isset($_POST['btn_era_contact'])) {}    // Erase contact
if (isset($_POST['btn_sav_cvrform'])) {}    // Use CVR-data

if (isset($_POST['btn_sav_service'])) {}    // Table
$serviceData= array( //  DEMO:
                ['post' => 1, 'product' => '45-876', 'numb' => 3, 'unit' =>'stk', 'description' =>'Redekasser', 'vat' => 25, 'price' => 235.50, 'discount' => 8,  'total' => 0.00, 'currency' =>'DKK'],
                ['post' => 2, 'product' => '45-876', 'numb' => 2, 'unit' =>'stk', 'description' =>'Redekasser', 'vat' => 25, 'price' => 235.50, 'discount' => 8,  'total' => 0.00, 'currency' =>'DKK'],
                ['post' => 3, 'product' => '45-876', 'numb' => 3, 'unit' =>'stk', 'description' =>'Redekasser', 'vat' => 25, 'price' => 235.50, 'discount' => 12, 'total' => 0.00, 'currency' =>'DKK'],
                ['post' => 4, 'product' => '45-876', 'numb' => 3, 'unit' =>'stk', 'description' =>'Redekasser', 'vat' => 25, 'price' => 235.50, 'discount' => 8,  'total' => 0.00, 'currency' =>'DKK']
            );
if (is_readable('serviceData.dat'))
    FileWrite_arr($filepath='serviceData.dat', $serviceData);

// btn_goo_doLookup // Opslag          
// btn_cre_doInvo'  // Dan Faktura     
// btn_cre_doNote'  // Dan Følgeseddel 
// btn_hom_doCredit // Krediter        
// btn_era_doErase  // Slet            

/* 
    $tbl='orders'; //  COMMENT "Ordre data 1"
    # PRIMARY KEY 'id' serial NOT NULL
    $arrOrders['ord_id__' ]=    [null,'ID'       , $tbl.'.ix'       , 'TEXT',            'COMMENT Key' ][$lookup];
    $arrOrders['ord_Numm' ]=    [null,'ORDER'    , $tbl.'.order'    , 'TEXT',            'COMMENT Ordre nummer' ][$lookup];
    $arrOrders['ord_Dato' ]=    [null,'DATE'     , $tbl.'.orderdate', 'DATE',            'COMMENT Ordre dato' ][$lookup];
    $arrOrders['ord_Ldat' ]=    [null,'DATE'     , $tbl.'.delevdate', 'DATE',            'COMMENT Leverings dato' ][$lookup];
    $arrOrders['ord_Kont' ]=    [null,'ACCOUNT'  , $tbl.'.account'  , 'TEXT',            'COMMENT Konto nummer' ][$lookup];
    $arrOrders['ord_Firm' ]=    [null,'COMPANY'  , $tbl.'.company'  , 'TEXT',            'COMMENT Firma/Navn' ][$lookup];
    $arrOrders['ord_Sælg' ]=    [null,'SALESMAN' , $tbl.'.salesman' , 'TEXT',            'COMMENT Sælger' ][$lookup];   
    $arrOrders['ord_Sum_' ]=    [null,'SUM'      , $tbl.'.sum'      , 'DECIMAL(15,3)',   'COMMENT Ordre sum' ][$lookup]; 
    $arrOrders['ord_Stat' ]=    [null,'STATUS'   , $tbl.'.status'   , 'TEXT',            'COMMENT Status' ][$lookup];    
    $fldOrdrer= [[$tbl],['id','ord_id__','ord_Numm','ord_Dato','ord_Ldat','ord_Kont','ord_Firm','ord_Sælg','ord_Sum_','ord_Stat'],
                        ['id','ix'      ,'order'   ,'orderdate','delevdate','account','company' ,'salesman','sum'    ,'status']];
*/
$arrOrders= array( // Table Services DEMO:
                ['ord_id__' => '0001', 'ord_Numm' => '45-876', 'ord_Dato' => '', 'ord_Ldat' =>'', 'ord_Kont' =>'Konto nr.', 'ord_Firm' => 'Firma navn', 'ord_Sælg' => 'Sælger', 'ord_Sum_' => 148,  'ord_Stat' => 'Status'],
                ['ord_id__' => '0002', 'ord_Numm' => '45-877', 'ord_Dato' => '', 'ord_Ldat' =>'', 'ord_Kont' =>'Konto nr.', 'ord_Firm' => 'Firma navn', 'ord_Sælg' => 'Sælger', 'ord_Sum_' => 148,  'ord_Stat' => 'Status'],
                ['ord_id__' => '0003', 'ord_Numm' => '45-878', 'ord_Dato' => '', 'ord_Ldat' =>'', 'ord_Kont' =>'Konto nr.', 'ord_Firm' => 'Firma navn', 'ord_Sælg' => 'Sælger', 'ord_Sum_' => 1412, 'ord_Stat' => 'Status'],
                ['ord_id__' => '0004', 'ord_Numm' => '45-879', 'ord_Dato' => '', 'ord_Ldat' =>'', 'ord_Kont' =>'Konto nr.', 'ord_Firm' => 'Firma navn', 'ord_Sælg' => 'Sælger', 'ord_Sum_' => 148,  'ord_Stat' => 'Status']
            );


### READ from database:    (DEMO: from files)
# INIT variables:
//if (!$arrCustomr)    
    if (is_readable('arrCustomr.dat')) FileRead_arr( $filepath='arrCustomr.dat', $arrCustomr);   // arrPrint($arrCustomr,'arrCustomr');
    if (is_readable('arrBilling.dat')) FileRead_arr( $filepath='arrBilling.dat', $arrBilling);
    if (is_readable('arrDeliver.dat')) FileRead_arr( $filepath='arrDeliver.dat', $arrDeliver);
    if (is_readable('arrConditi.dat')) FileRead_arr( $filepath='arrConditi.dat', $arrConditi);
    if (is_readable('arrMailing.dat')) FileRead_arr( $filepath='arrMailing.dat', $arrMailing);
    if (is_readable('arrContact.dat')) FileRead_arr( $filepath='arrContact.dat', $arrContact);
    if (is_readable('arrCustfld.dat')) FileRead_arr( $filepath='arrCustfld.dat', $arrCustfld);
    if (is_readable('arrCustfld.dat')) FileRead_arr( $filepath='arrCustfld.dat', $arrCustfld);

    if (is_readable('serviceData.dat')) FileRead_arr( $filepath='serviceData.dat', $arrService);

##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_PagePrep

htm_PagePrep($pageTitl='OrderCreate.page.php', $ØPageImage='_background.png',$align='center',$PgInfo=lang('@page: Customer-ORDER'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
    Menu_Topdropdown(true); htm_nl(1);

if ($test) echo '<pre>'.$log.'</pre>'. '<br>Saved: '.$bytes.' bytes to data-files.';
    
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    htm_PanlHead($frmName='orders', $capt=lang('@Find existing order:'), $parms='', $icon='fas fa-search', $class='panelW960', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
        htm_Table(
            $TblCapt= array( 
                    ['@Viser:', 'Width', 'Type', 'OutFormat', 'horJust', 'Tip', 'placeholder', '@Kundeordrer'] 
                ),
            $RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
                ),
            $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
                    ['@id',         '3%','show', '',   ['center'],  '@id nummer vedligeholdt af systemet','..auto..'],
                    ['@Ordre',      '6%','indx', '',   ['center'],  '@Ordre nummer','@Numr...'],
                    ['@Ordre dato', '5%','date', '',   ['left'  ],  '@Ordre dato','YYYY-MM-DD'],
                    ['@Lev. dato',  '5%','date', '',   ['left'  ],  '@Leverings dato','YYYY-MM-DD'],
                    ['@Konto',      '7%','text', '',   ['center'],  '@Debitor konto nummer','@Kont...'],
                    ['@Firma navn','25%','text', '',   ['left'  ],  '@Firma navn','@Firm...'],
                    ['@Sælger',     '7%','text', '',   ['left'  ],  '@Sælger','@Sælg...'],
                    ['@Beløb',      '8%','text', '2d', ['right' ],  '@Ordre sum','@Beløb...'],
                    ['@Status',     '5%','osta', '',   ['left'  ],  '@Status','@Status...'] //  ORD_Status()
                ),
            $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
                  //  ['@Select',     '3%','text', '',  ['center'],   lang('@Vælg en ordre for at behandle den').' ',
                  //        '<a href='.$link.'><ic class="fas fa-check" style="font-size:14px; color:green;" title="'. lang('@??').'"></ic></a>'],
                ),      # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON]
            $TblNote= '',           # HTML-string
            $TblData= $arrOrders, #=   array(      ),
            $FilterOn= true,        # Mulighed for at skjule records som ikke matcher filter
            $SorterOn= true,        # Mulighed for at sortere records efter kolonne indhold
            $CreateRec=false,       # Mulighed for at oprette en record
            $ModifyRec=true,        # Mulighed for at vælge/ændre data i en row
            $ViewHeight= '200px',   # Højden af den synlige del af tabellens data
            $TblStyle= '',          # Style for the span that holds the table;
            $CalledFrom= __FUNCTION__
          );
  
    htm_PanlFoot($labl='@Gem', $subm=false, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
    
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    htm_PanlHead($frmName='', $capt=lang('@Create new or modify order:'), $parms='', $icon='fas fa-plus', $class='panelW960', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
    //htm_TextDiv(lang('Here you can create a new order:<br>'));
    $wdh= '100%';   //Field width
    $m= ''; // more

        htm_PanlHead($frmName='customr', $capt=lang('Customer:'), $parms='', $icon='fas fa-user', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='custkont',$valu=$arrCustomr[$name],$labl='@kunde nr.', $llgn='', $hint='@Kundenr: Kan ikke rettes, kun nyoprettes. Systemet styrer dette', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='@Konto');
            htm_Input($type='opti',$name='custopsl',$valu=$arrCustomr[$name],$labl='@Kundeopslag', $llgn='', $hint='@Her vælges hvilken eksisterende kunde der skal benyttes', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='',$list= []); //CustList());
            htm_Input($type='rado',$name='custkate',$valu=$arrCustomr[$name],$labl='@Kundetype', $llgn='', $hint='@Kunde kategori', $algn='left',$unit='',$disa=false,$rows='1',$width='100%',$step='',$more=$m,$plho='',$list=DEB_Kateg() );
            htm_Input($type='text',$name='cust_cvr',$valu=$arrCustomr[$name],$labl='@CVR', $llgn='', $hint='@CVR - Virksomheds ID.', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@kun erhverv !');
            htm_Input($type='text',$name='cust_ean',$valu=$arrCustomr[$name],$labl='@EAN', $llgn='', $hint='@EAN - Elektronisk-betalings ID', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@kun erhverv !');
            htm_Input($type='text',$name='custbreg',$valu=$arrCustomr[$name],$labl='@Bank reg.', $llgn='', $hint='@Bank reg.', $algn='left',$unit='',$disa=false,$rows='3',$width='33%',$step='',$more=$m,$plho='Reg...');
            htm_Input($type='text',$name='custbkto',$valu=$arrCustomr[$name],$labl='@Bank konto', $llgn='', $hint='@Bank konto', $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho='Konto...');
            htm_Input($type='text',$name='custinst',$valu=$arrCustomr[$name],$labl='@Institution', $llgn='', $hint='@Supplerende oplysning', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@kun erhverv !');
            htm_Input($type='text',$name='custansv',$valu=$arrCustomr[$name],$labl='@Kundeansvarlig', $llgn='', $hint='@Kundeansvarlig', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@Ansv...');
            htm_Input($type='text',$name='custlang',$valu=$arrCustomr[$name],$labl='@Faktureringssprog', $llgn='', $hint='@Sproget som skal benyttes på faktura udskrifter', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@hvis sproget ikke er dansk');
            htm_Input($type='text',$name='custhome',$valu=$arrCustomr[$name],$labl='@Hjemmeside', $llgn='', $hint='@Kundens hjemmeside', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@kun erhverv !');
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);

        
        htm_PanlHead($frmName='billing', $capt=lang('Billing:'), $parms='', $icon='fas fa-pen', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='billnavn',$valu=$arrBilling[$name],$labl='@Customer name', $llgn='', $hint='@Angiv Kunde navn', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Name...');
            htm_Input($type='text',$name='billaddr',$valu=$arrBilling[$name],$labl='@Customer address',$llgn='', $hint='@Angiv Faktura adresse', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Adress...');
            htm_Input($type='text',$name='billsted',$valu=$arrBilling[$name],$labl='@Customer place',$llgn='', $hint='@Angiv Faktura Sted', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Place...');
            htm_Input($type='text',$name='billponr',$valu=$arrBilling[$name],$labl='@Postnr', $llgn='', $hint='@Postnr', $algn='left',$unit='',$disa=false,$rows='3',$width='30%',$step='',$more=$m,$plho='@Pnr...');
            htm_Input($type='text',$name='billbynv',$valu=$arrBilling[$name],$labl='@Faktura By', $llgn='', $hint='@Faktura by', $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more=$m,$plho='@Bynavn...');
            htm_Input($type='text',$name='billland',$valu=$arrBilling[$name],$labl='@Faktura Land',$llgn='', $hint='@Faktura Land', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Land...');
            htm_Input($type='text',$name='billnote',$valu=$arrBilling[$name],$labl='@Bemærkninger',$llgn='', $hint='@Noter angående kunden', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Bem...');
            htm_Input($type='text',$name='billtelf',$valu=$arrBilling[$name],$labl='@Telefon(er)',$llgn='', $hint='@Telefon(er)', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Phone...');
            htm_Input($type='text',$name='bill_att',$valu=$arrBilling[$name],$labl='@Attention',$llgn='', $hint='@Attention - Kundens kontakt', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Att...');
            htm_Input($type='text',$name='billmail',$valu=$arrBilling[$name],$labl='@Kundens Email adresse',$llgn='', $hint='@Faktura Land', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Mail...');
            if (isset($_POST['use_mail'])) { $use_mail = 'checked'; } 
            htm_Input($type='chck',$name='use_mail',$valu=$arrBilling[$name],$labl='@Mailing',$llgn='', $hint='@Send faktura med mail', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='@Enter...',
            $list= [['use_mail','@Use mail','@Mailing active',$namechck]]);
            htm_Input($type='date',$name='ordrdato',$valu=$arrBilling[$name],$labl='@Ordre Dato',$llgn='', $hint='@Dato for ordrens oprettelse', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='@Date...');
            htm_Input($type='date',$name='faktdato',$valu=$arrBilling[$name],$labl='@Faktura Dato',$llgn='', $hint='@Fakturerings dato', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='@Date...');
            htm_Input($type='date',$name='gen_fakt',$valu=$arrBilling[$name],$labl='@Genfakturering',$llgn='', $hint='@Genfakturerings dato', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='@Date...');
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);

        
        htm_PanlHead($frmName='deliver', $capt=lang('Delivery:'), $parms='', $icon='fas fa-truck', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='chck', $name='sameaddr',  $valu= $arrDeliver[$name], $labl='@Leveres til faktura-adresse',         $llgn='', $hint='@Afmærk her, hvis leverings adresse er den samme som faktura adresse', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='',
            $list= [['sameaddr','@Same address','@Same address as faktura',$namechck]]);
            htm_Input($type='text', $name='delinavn', $valu= $arrDeliver[$name], $labl='@Modtager navn',                       $llgn='', $hint='@Angiv Modtager Navn',               $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Navn..');
            htm_Input($type='text', $name='deliaddr', $valu= $arrDeliver[$name], $labl='@Leverings adresse',                   $llgn='', $hint='@Angiv Leverings Adresse',           $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Addr..');
            htm_Input($type='text', $name='delisted', $valu= $arrDeliver[$name], $labl='@Leverings Sted',                      $llgn='', $hint='@Angiv Leverings Sted, suplement til adresse', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Sted...');
            htm_Input($type='text', $name='deliponr', $valu= $arrDeliver[$name], $labl='@Postnr',                              $llgn='', $hint='@Angiv Leverings Kunde postnr',      $algn='left',$unit='',$disa=false,$rows='3',$width='30%',$step='',$more=$m,$plho='Pnr..');
            htm_Input($type='text', $name='delibynv', $valu= $arrDeliver[$name], $labl='@Leverings by',                        $llgn='', $hint='@Angiv Leveringsstedets Bynavn',     $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more=$m,$plho='By..');
            htm_Input($type='text', $name='deliland', $valu= $arrDeliver[$name], $labl='@Leverings Land',                      $llgn='', $hint='@Angiv Leverings Land',              $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Land...');
            htm_Input($type='text', $name='delitelf', $valu= $arrDeliver[$name], $labl='@Telefon(er)',                         $llgn='', $hint='@Angiv Modtagers Telefon',           $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Telf..');
            htm_Input($type='text', $name='delikont', $valu= $arrDeliver[$name], $labl='@Kontaktperson på leverings adressen', $llgn='', $hint='@Angiv Kontaktpersons Navn',         $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Navn...');
            htm_Input($type='mail', $name='delimail', $valu= $arrDeliver[$name], $labl='@Modtagerens Email adresse',           $llgn='', $hint='@Angiv Modtagers Email adresse',     $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Mail...');
            htm_Input($type='text', $name='forsend_', $valu= $arrDeliver[$name], $labl='@Fragtmetode.',                        $llgn='', $hint='@Angiv Forsendelses oplysninger. Hvordan/med hvem er pakken sendt?',   $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Fors...');
            htm_Input($type='area', $name='lev_note', $valu= $arrDeliver[$name], $labl='@Noter til fragtmand',                 $llgn='', $hint='@Noter angående pakkens levering',   $algn='left',$unit='',$disa=false,$rows='1',$width=$wdh,$step='',$more=$m);
            htm_Input($type='chck', $name='afs_endt', $valu= $arrDeliver[$name], $labl='@Status',                              $llgn='', $hint='@Når ydelsen er afsendt kan beløb indløses', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='@Enter...',
            $list= [['afs_endt','@Er afsendt','@Klar til indløsning',$afs_endt]]);
            htm_Input($type='date', $name='lev_dato', $valu= $arrDeliver[$name], $labl='@Leverings Dato',                      $llgn='', $hint='@evt. forsendelses dato',            $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,$plho='Dato...');
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
        
        
        htm_PanlHead($frmName='conditi', $capt=lang('Conditions:'), $parms='', $icon='far fa-credit-card', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            #htm_Input($type='opti',$name='faktbynv',$valu=$arrCustomr[$name],$labl='@Faktura By', $llgn='', $hint='@Faktura by', $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more=$m,$plho='@Bynavn...');
            htm_Input($type='opti',  $name='debigrup', $valu= $arrConditi[$name], $labl='@Debitorgruppe',     $llgn='', $hint='@Vælg hvilken gruppe kunden tilhører',   $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m, $plho='',$optlist= DEB_Grup() );
            htm_Input($type='opti',  $name='betaling', $valu= $arrConditi[$name], $labl='@Betalings metode',  $llgn='', $hint='@Hvordan skal der betales',              $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m, $plho='',$optlist= DEB_Betl() );
            htm_Input($type='opti',  $name='betfrist', $valu= $arrConditi[$name], $labl='@Betalings frist',   $llgn='', $hint='@Hvor lang frist er der til betaling',   $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m, $plho='',$optlist= DEB_Frist(), $action='');
            htm_Input($type='opti',  $name='print_to', $valu= $arrConditi[$name], $labl='@Udskriv til',       $llgn='', $hint='@Vælg på hvilken måde skal dokumentet udskrives, gemmes eller sendes.',$algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more=$m, $plho='', $optlist= DEB_Dok() );
            htm_Input($type='text',  $name='kunderef', $valu= $arrConditi[$name], $labl='@Kundens referance', $llgn='', $hint='@f.eks. Rekvisitions NR',                $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='Ref...');
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
        
        
        htm_PanlHead($frmName='mailinv', $capt=lang('Mail-invoice:'), $parms='', $icon='fas fa-envelope', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='mailemne', $valu= $arrMailing[$name], $labl='@Mail emne',           $llgn='', $hint='@Angiv Mail emne',     $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m, $plho='@Vedr...');
            htm_Input($type='area',$name='mailtext', $valu= $arrMailing[$name], $labl='@Mail tekst',          $llgn='', $hint='@Angiv Mail tekst',    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m, $plho='@Besked...');
            htm_Input($type='text',$name='mailvedh', $valu= $arrMailing[$name], $labl='@Mail bilag',          $llgn='', $hint='@Angiv Vedhæftet fil', $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m, $plho='@Bilag...');
            htm_Input($type='text',$name='mail__cc', $valu= $arrMailing[$name], $labl='@Kopi til',            $llgn='', $hint='@Angiv mail-adresse, som skal modtage en kopi af afsendt mail',            $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Copy...');
            htm_Input($type='text',$name='mail__bc', $valu= $arrMailing['mail__bc'], $labl='@Blind-kopi til', $llgn='', $hint='@Angiv mail-adresse, som skal modtage en BC-kopi (skjult) af afsendt mail',$algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='BCopy...');
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
        
        
        htm_PanlHead($frmName='contact', $capt=lang('Person contact:'), $parms='', $icon='fas fa-phone-square', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            function KontaktPers(&$posi, &$kontakt, &$titel, &$telf, &$mobil, &$mail, &$bemr) {  ## out_PanlsPrim.php
                htm_Input($type='num0', $name='contposi',   $valu= $arrContact[$name], $labl='@Pos.',  $llgn='', $hint='@Position styrer rækkefølgen af posterne', $algn='left',$unit='',$disa=false,$rows='3',$width='15%',$step='1',$more=$m );
                htm_Input($type='text', $name='contkontakt',$valu= $arrContact[$name], $labl='@Kontakt person',  $llgn='', $hint='@Angiv Kontakt person',      $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m, $plho='@Kont...');
                htm_Input($type='text', $name='conttitel',  $valu= $arrContact[$name], $labl='@Titel',       $llgn='', $hint='@Angiv personens titel',         $algn='left',$unit='',$disa=false,$rows='3',$width='35%',$step='',$more=$m, $plho='@Titl...');
                htm_Input($type='text', $name='conttelf',   $valu= $arrContact[$name], $labl='@Telefon',     $llgn='', $hint='@Angiv Telefon',                 $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m,  $plho='@Tlf...');
                htm_Input($type='text', $name='contmobil',  $valu= $arrContact[$name], $labl='@Mobil',       $llgn='', $hint='@Angiv Mobilnr. eller lokalnr',  $algn='left',$unit='',$disa=false,$rows='3',$width='50%','','', $plho='@Mobil/lok...');  
                htm_Input($type='mail', $name='contmail',   $valu= $arrContact[$name], $labl='@E-mail',      $llgn='', $hint='@Angiv E-mail',                  $algn='left',$unit='',$disa=false,$rows='3',$width='80%',$step='',$more=$m, $plho='@Mail...');
                htm_Input($type='area', $name='contbemr',   $valu= $arrContact[$name], $labl='@Bemærkning',  $llgn='', $hint='@Angiv bemærkning til kontakten, f.eks. rolle (direktør/sekretær/chauffør)', $algn='left',$unit='',$disa=false,$rows='1',$width='80%',$step='',$more=$m, $plho='@Note...');
                htm_hr('lightgray');
                htm_AcceptButt($labl='@Slet', $hint='@Fjern denne kontakt person <br>(DEMO yet !)', $btnKind='erase', $frmName='contact', $width='', $akey='', $proc=true);  
                htm_hr('green');
            }
            $arrKontakter['kont']= [    // DEMO-data:
                [ $kont['posi'] =   [null, 1        ,   $tbl.'.posi'  , 'TEXT',  'COMMENT Sorterings position' ][$lookup],     
                  $kont['navn'] =   [null, 'ANDERS' ,   $tbl.'.name'  , 'TEXT',  'COMMENT Navn' ][$lookup],      
                  $kont['titel']=   [null, 'TITLE1' ,   $tbl.'.title' , 'TEXT',  'COMMENT Titel' ][$lookup],      
                  $kont['telf'] =   [null, 'PHONE1' ,   $tbl.'.phone' , 'TEXT',  'COMMENT Telefon' ][$lookup],      
                  $kont['mobil']=   [null, 'MOBILE1',   $tbl.'.mobile', 'TEXT',  'COMMENT Mobiltelf.' ][$lookup],      
                  $kont['mail'] =   [null, 'MAIL1'  ,   $tbl.'.mail'  , 'TEXT',  'COMMENT Mail adresse' ][$lookup],      
                  $kont['bemr'] =   [null, 'REMARK1',   $tbl.'.remark', 'TEXT',  'COMMENT Bemærkning' ][$lookup]  
                ]/* ,          
                [ $kont['posi'] =   [null, 2          , $tbl.'.posi'  , 'TEXT',  'COMMENT Sorterings position' ][$lookup],  // Denne record 2 skal ikke oprette noget i DB!
                  $kont['navn'] =   [null, 'ANDERSINE', $tbl.'.name'  , 'TEXT',  'COMMENT Navn' ][$lookup],
                  $kont['titel']=   [null, 'TITLE2',    $tbl.'.title' , 'TEXT',  'COMMENT Titel' ][$lookup],      
                  $kont['telf'] =   [null, 'PHONE2',    $tbl.'.phone' , 'TEXT',  'COMMENT Telefon' ][$lookup],      
                  $kont['mobil']=   [null, 'MOBILE2',   $tbl.'.mobile', 'TEXT',  'COMMENT Mobiltelf.' ][$lookup],      
                  $kont['mail'] =   [null, 'MAIL2',     $tbl.'.mail'  , 'TEXT',  'COMMENT Mail adresse' ][$lookup],      
                  $kont['bemr'] =   [null, 'REMARK2',   $tbl.'.remark', 'TEXT',  'COMMENT Bemærkning' ][$lookup]  
                ] */
            ];
            if ($arrKontakter)
                foreach ($arrKontakter['kont'] as $kont) {
                    KontaktPers($kont[0], $kont[1], $kont[2], $kont[3], $kont[4], $kont[5], $kont[6]);  //  Kontakt($kont['posi'], $kont['navn'], $kont['titel'], $kont['telf'], $kont['mobil'], $kont['mail'], $kont['bemr']);
                }
            else htm_Caption('@Ingen oprettede kontakter.');
            htm_AcceptButt($labl='@Opret Ny', $hint='@Opret en ny kontakt <br>(DEMO yet !)', $btnKind='create', $frmName='contact', $width='', $akey='', $proc=true);
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
        
        $content= '<small><b>Opslag i CVR-registret</b> (kun erhverv)<br>
            Hent eller kontroller med data i det offentlige virksomhedsregister.<br>
            Data leveres af CVR API<br> </small>';
        
        htm_PanlHead($frmName='cvrform', $capt=lang('CVR-lookup:'), $parms='', $icon='fas fa-database', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_TextDiv($content, $align='left',$marg='8px',$more='');
            set_FormVars(['cvrLand','cvrKode','cvrSoeg'/* ,'cvrNumm','cvrNavn','cvrTelf','cvrAddr','cvrPost','cvrBy','cvrDiv' */]);  // Opdater alle variabler på form 'cvrform' :
            get_FormVars(['cvrLand','cvrKode','cvrSoeg']);
        #      dev_show(); //  echo 'SESSIONS variablers indhold: ';  vis_data($_SESSION);
                $cvrLand= $_SESSION['cvrLand'];   if (!$cvrLand) $cvrLand= 'dk';
                $cvrKode= $_SESSION['cvrKode'];   if (!$cvrKode) $cvrKode= 'search';
                $cvrSoeg= $_SESSION['cvrSoeg'];
                if (($cvrLand) and ($cvrKode) and ($cvrSoeg)) //  Klar til søgning
                { $url= 'https://cvrapi.dk/api?'.$cvrKode.'='.$cvrSoeg.'&country='.$cvrLand;   //  https://cvrapi.dk/api?search=$cvrSoeg&country=dk  Generel søgning    //  https://cvrapi.dk/api?phone=$cvrSoeg&country=dk   specifikt telefonnr
                    //$content = file_get_contents($url, false, stream_context_create(['http' => ['user_agent' => 'any']]));
                    // FIXIT: Forebyg: "Failed to open streem" ved:  "404 Not Found"
                    $svar= json_decode($content, true);       //  $svar= json_decode('{"vat":20756438,"name":"Saldi.dk ApS","address":"Gefionsvej 13, 1","zipcode":"3400","city":"Hiller\u00f8d","cityname":null,"protected":false,"phone":"46902208","email":"phr@danosoft.dk","fax":null,"startdate":"29\/12 - 1997","enddate":null,"employees":"2-4","addressco":null,"industrycode":620100,"industrydesc":"Computerprogrammering","companycode":80,"companydesc":"Anpartsselskab","creditstartdate":null,"creditbankrupt":false,"creditstatus":null,"owners":[{"name":"Peter Holten Rude"}],"productionunits":[{"pno":1018843737,"main":false,"name":"saldi.dk ApS","address":"Kirseb\u00e6rg\u00e5rden 2-4, 1. V.","zipcode":"3450","city":"Aller\u00f8d","cityname":null,"protected":false,"phone":"46902208","email":"phr@saldi.dk","fax":null,"startdate":"23\/10 - 2013","enddate":"23\/02 - 2016","employees":null,"addressco":null,"industrycode":620100,"industrydesc":"Computerprogrammering"},{"pno":1008561504,"main":true,"name":"Saldi.dk ApS","address":"Gefionsvej 13, 1","zipcode":"3400","city":"Hiller\u00f8d","cityname":null,"protected":false,"phone":"46902208","email":"phr@danosoft.dk","fax":null,"startdate":"06\/07 - 2001","enddate":null,"employees":null,"addressco":null,"industrycode":620100,"industrydesc":"Computerprogrammering"}],"t":100,"version":6}', true);
                    if ($svar['vat']) { $cvrDiv= '';
                        $cvrNumm= $svar['vat'];    
                        $cvrNavn= $svar['name'];   
                        $cvrAddr= $svar['address'];
                        $cvrPost= $svar['zipcode'];
                        $cvrBy  = $svar['city'];   
                        $cvrTelf= $svar['phone'];  
                        if ($svar['email'])                                  {$cvrDiv.= lang('@Mail').': '. $svar['email'].'&#xa;';}
                        if ($svar['fax'])                                    {$cvrDiv.= lang('@Fax ').': '. $svar['fax'].'&#xa;';}
                        if ($svar['cityname'])                               {$cvrDiv.= lang('@Sted').': '. $svar['cityname'].'&#xa;';}
                        if ($svar['companydesc'])                            {$cvrDiv.= lang('@Type').': '. $svar['companydesc'].'&#xa;';}
                        $ix= 0; while ($svar['owners'][$ix]['name'])         {$cvrDiv.= lang('@Ejer').': '. $svar['owners'][$ix]['name'].'&#xa;'; $ix++;}
                        $ix= 0; while ($svar['productionunits'][$ix]['pno']) {$cvrDiv.= lang('@P-nr').': '. $svar['productionunits'][$ix]['pno'].'&#xa;'; $ix++;}
                    } 
                }
            htm_Input($type='opti',  $name='cvrLand', $valu= $cvrLand='dk', $labl='@Lands-register', $llgn='', $hint='@I hvilket land vil du søge?', $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m, $plho='', $optlist= CVR_Land());
            htm_Input($type='opti',  $name='cvrKode', $valu= $cvrKode='search', $labl='@Søg efter', $llgn='', $hint='@Hvad kender du?',  $algn='left',$unit='',$disa=false,$rows='3',$width='50%',$step='',$more=$m, $plho='', $optlist= CVR_Liste());
            htm_Input($type='text', $name='cvrSoeg', $valu= $cvrSoeg, $labl='@CVR/P-enh./Telf/Navn', $llgn='', $hint='@Indtast her, data eller firma navn, som du vil søge efter', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m,$plho='@Kun erhverv !');
            htm_hr('lightgray');
            htm_AcceptButt($labl='@Søg', $hint='@Start søgning  i CVR-registret', $btnKind='create', $frmName='cvrform', $width='', $akey='s', $proc=true);
            htm_hr('green');
            htm_TextDiv($content=lang('Register data:'), $align='left',$marg='8px',$more='');
            
            htm_Input($type='text',  $name='cvrNumm',  $valu= $cvrNumm,  $labl='@CVR-nummer',   $llgn='', $hint='@Hentet i CVR-registret',  $algn='left',$unit='',$disa=false,$rows='3',$width='33%',$step='',$more=$m,$plho='@CVR...');
            htm_Input($type='text',  $name='cvrNavn',  $valu= $cvrNavn,  $labl='@Firmanavn',    $llgn='', $hint='@Hentet i CVR-registret',  $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho='@Navn...');
            htm_Input($type='text',  $name='cvrTelf',  $valu= $cvrTelf,  $labl='@Telefon',      $llgn='', $hint='@Hentet i CVR-registret',  $algn='left',$unit='',$disa=false,$rows='3',$width='33%',$step='',$more=$m,$plho='@Telf...');
            htm_Input($type='text',  $name='cvrAddr',  $valu= $cvrAddr,  $labl='@Adresse',      $llgn='', $hint='@Hentet i CVR-registret',  $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho='@Addr...');
            htm_Input($type='text',  $name='cvrPost',  $valu= $cvrPost,  $labl='@Postnr.',      $llgn='', $hint='@Hentet i CVR-registret',  $algn='left',$unit='',$disa=false,$rows='3',$width='33%',$step='',$more=$m,$plho='@Post...');
            htm_Input($type='text',  $name='cvrBy',    $valu= $cvrBy,    $labl='@Bynavn',       $llgn='', $hint='@Hentet i CVR-registret',  $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho='@By...');
            htm_AcceptButt('@Benyt',lang('@Benyt de viste data i din registrering af ').$hvem.'. <br>'. lang('@Advarsel: Evt. tidligere data overskrives! (Felter uden indhold, påvirker ikke ekst. data)'.'<br>Virker ikke endnu'), $btnKind='save', $frmName='cvrform', $width='', $akey='b', $proc=true);
            htm_Input($type='area',  $name='cvrDiv',   $valu= $cvrDiv,   $labl='@Andet', $llgn='', $hint='@Hentet i CVR-registret, diverse supplerende data', $algn='left',$unit='',$disa=false,$rows='3',$width='100%',$step='',$more=$m, $plho='@Diverse...');
        htm_PanlFoot($labl='@Gem', $subm=false, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
        
        $custFld= [
        //[ 0:Label,         1:Hint,                  2:Placeholder]
          ['@Ekstra Felt 1','@Ekstra - Udfyld Felt 1','@Felt 1...'],
          ['@Ekstra Felt 2','@Ekstra - Udfyld Felt 2','@Felt 2...'],
          ['@Ekstra Felt 3','@Ekstra - Udfyld Felt 3','@Felt 3...'],
          ['@Ekstra Felt 4','@Ekstra - Udfyld Felt 4','@Felt 4...'],
          ['@Ekstra Felt 5','@Ekstra - Udfyld Felt 5','@Felt 5...']
        ];   
     //   $custFld= $arrCustfld['custFld']; 
        htm_PanlHead($frmName='extra', $capt=lang('Extra fields:'), $parms='', $icon='fas fa-plus', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
            htm_Input($type='text',$name='felt1',  $valu= $arrCustfld['felt1'],  $labl= lang($custFld[0][0]), $llgn='', $hint= lang($custFld[0][1]), $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho= lang($custFld[0][2]));
            htm_Input($type='text',$name='felt2',  $valu= $arrCustfld['felt2'],  $labl= lang($custFld[1][0]), $llgn='', $hint= lang($custFld[1][1]), $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho= lang($custFld[1][2]));
            htm_Input($type='text',$name='felt3',  $valu= $arrCustfld['felt3'],  $labl= lang($custFld[2][0]), $llgn='', $hint= lang($custFld[2][1]), $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho= lang($custFld[2][2]));
            htm_Input($type='text',$name='felt4',  $valu= $arrCustfld['felt4'],  $labl= lang($custFld[3][0]), $llgn='', $hint= lang($custFld[3][1]), $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho= lang($custFld[3][2]));
            htm_Input($type='text',$name='felt5',  $valu= $arrCustfld['felt5'],  $labl= lang($custFld[4][0]), $llgn='', $hint= lang($custFld[4][1]), $algn='left',$unit='',$disa=false,$rows='3',$width='66%',$step='',$more=$m,$plho= lang($custFld[4][2]));
        htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
        
        
       htm_PanlHead($frmName='', $capt='', $parms='', $icon='', $class='panelW280', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; visibility: hidden;');
       ## Hidden placeholder to fillout the row
       htm_PanlFoot();

    htm_PanlFoot($labl='', $subm=false, $title=''); // '@New order:'
    /////////////////////////////////////////////////////////////////////
    
    //\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    htm_PanlHead($frmName='service', $capt=lang('@Services on the order:'), $parms='', $icon='fas fa-plus', $class='panelW960', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
        $link= '#';
        htm_Table(
            $TblCapt= array( #['0:Label',   '1:Width',    '2:Type',    '3:OutFormat', '4:horJust',      '5:Tip',    '6:placeholder', '7:Content';],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
            ),
            $RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
            ),
            $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
                ['@Pos.',         '5%','indx', '',  ['center'],'@Pos. nr tildeles automatisk','...pos...'],
                ['@Varenr',       '8%','text', '',  ['center'],'@Varenummer for ydelsen','Varenr...'],
                ['@Antal',        '3%','text', '',  ['center'],'@Mængden angivet som antal ','@Antal...'],
                ['@Enhed',        '6%','text', '',  ['left'  ],'@Enheds betegnelse ','@Enh...'],
                ['@Beskrivelse', '29%','text', '',  ['left'  ],'@Beskrivelse af varen/ydelsen ','@Besk...'],
                ['@Moms%',        '5%','text', '',  ['center'],'@Moms pct.sats ','@Moms...'],
                ['@À pris',       '9%','text', '2d',['center'],'@Enhedspris ','@Pris...'],
                ['@Rabat%',       '8%','text', '1d',['right' ],'@Rabat procent','@Rabat...'],
                ['@Ialt',         '9%','calc', '2d',['right' ],'@Kalkuleret beløb for den aktuelle postering. ',''],
                ['@Valuta',       '5%','text', '',  ['center'],'@Valutakode for den valuta, som er benyttet på specifikationen.','DKK'],
                ['@Forfald',      '9%','hidd', '',  ['center'],'@Beløbets forfalds dato','forf.dato'],
            ),
            $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!'], ['Næste record'],... # Generel struktur! 
                ['@Fortryd',      '3%','text', '',  ['center'],
                              lang('@Fortryd postering! <br>Tilbagefør beløbet ved at klikke på ikonen.').' '.
                              lang('@Er ordren faktureret, kan posten tilbageføres, indtil ordren er bogført. Derefter skal det ske ved at kreditere kunden!'),
                              '<a href='.$link.'><ic class="fas fa-undo" style="font-size:14px; color:red;" title="'.
                              lang('@Tilbagefør denne postering, f.eks. fortryd rykkergebyr').'"></ic></a>'],
                ['@Flyt',         '2%','text', '',  ['center'], '@Flyt en post op eller ned.',
                              '<a href='.$link.'><ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
                              lang('@Virker ikke endnu').'"></ic></a>']
                ),            # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
            $TblNote=   '',
            $data = $arrService,
            /* 
            array( //  DEMO:
                [1, '45-876', $antal=3, 'stk', 'Redekasser', $momssats=25, $pris=235.50, $rabat=8,  $ialt=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                [2, '45-876', $antal=2, 'stk', 'Redekasser', $momssats=25, $pris=235.50, $rabat=8,  $ialt=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                [3, '45-876', $antal=3, 'stk', 'Redekasser', $momssats=25, $pris=235.50, $rabat=12, $ialt=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                [4, '45-876', $antal=3, 'stk', 'Redekasser', $momssats=25, $pris=235.50, $rabat=8,  $ialt=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK']
            ),
             */
            $FilterOn= false,           # Mulighed for at skjule records som ikke matcher filter
            $SorterOn= false,           # Mulighed for at sortere records efter kolonne indhold
            $CreateRec=true,            # Mulighed for at oprette en record
            $ModifyRec=true,            # Mulighed for at ændre data i en row
            $ViewHeight= '250px',       # Højden af den synlige del af tabellens data 
            $CalledFrom= __FUNCTION__   # Ang. debugging
        );
    htm_PanlFoot($labl='@Gem', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
    
    htm_PanlHead($frmName='handling', $capt=lang('Handling the order:'), $parms='', $icon='fas fa-check', $class='panelW960', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: lightgray;');
        htm_nl(1);          
        htm_Input($type='text', $name='ordr', $valu= $xx='0000', $labl='<b>'.lang('@Ordre:').'</b>', $llgn='', $hint='@Ordre nummer', $algn='left',$unit='',$disa=true,$rows='1',$width='100px',$step='',$more=$m,$plho='');
        htm_Input($type='text', $name='cust', $valu= 'Customer', $labl='<b>'.lang('@Kunde:').'</b>', $llgn='', $hint='@Kunden navn',  $algn='left',$unit='',$disa=true,$rows='1',$width='400px',$step='',$more=$m,$plho= '');
        htm_Input($type='dec2', $name='totl', $valu= 0,          $labl='<b>'.lang('@Total:').'</b>', $llgn='', $hint='@Beløb inkl. moms', $algn='center',$unit=' DKK ',$disa=true,$rows='1',$width='120px',$step='',$more=$m,$plho= '');
        htm_nl(2);          
        htm_AcceptButt('@Opret / opdater',           lang('@Gem ordren'),                                     $btnKind='save',   $frmName='handling', $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px; ');
        htm_nl(2);                                                                                            
        htm_AcceptButt('@Opslag',          lang('@Gennemsøg andre eksisterende ordrer'),                      $btnKind='goon',   $frmName='doLookup', $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px; ');
        htm_AcceptButt('@Dan Faktura',     lang('@Lav faktura for (den gemte !) ordre'),                      $btnKind='create', $frmName='doInvo',   $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px; ');
        htm_AcceptButt('@Dan Følgeseddel', lang('@Lav følgesedden til ordrens forsendelse'),                  $btnKind='create', $frmName='doNote',   $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px; ');
        htm_AcceptButt('@Kreditér',        lang('@Nulstil ved at kreditére ordren - hvis den er faktureret'), $btnKind='home',   $frmName='doCredit', $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px; ');
        htm_AcceptButt('@Slet',            lang('@Slet ordren - forudsat faktura ikke er dannet'),            $btnKind='erase',  $frmName='doErase',  $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px; ');
        htm_nl(2);
    htm_PanlFoot();
    /////////////////////////////////////////////////////////////////////
        htm_nl(1);
    htm_PanlHead($frmName='', $capt='Info about this page:', $parms='', $icon='fas fa-info', $class='panelW560', $func='Undefined', $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: lightyellow; ');
        htm_TextDiv('This is a demo under development !<br>
            It can be slow because it stores data to text files.<br>
            No connection to a database yet.<br>
            There is also a lack of functionality.<br>
        ');
    htm_PanlFoot();
    
    if ($bytes== 0) {   // on page open
        PanelOff($First=5,$Last=11); // Close panel 5 to 11, 
        PanelOff($First=14,$Last=14);
    }
    // Menu_BottomScroll();  
htm_PageFina();

##### CLEANUP:

?>