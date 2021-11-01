<?php   $DocFil= './Proj1/demoFile/CustomerOrder.page.php';  $DocVer='1.0.0';  $DocRev='2020-08-17';   $DocIni='evs';  $ModulNr=0;
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
function DEB_Grup () { return( [
['1', '@1. Danske debitorer',  '@1. Danske debitorer'],
['2', '@2. Europæiske debitorer',  '@2. Europæiske debitorer']
]  );
}
function DEB_Betl () { return( [
['1', '@Kontant',   '@Kontant'],
['2', '@Efterkrav',   '@Efterkrav'],
['3', '@Forud',   '@Forud'],
['4', '@Kreditkort',  '@Kreditkort'],
['5', '@Lb. måned',   '@Lb. Md.'],
['6', '@Konto',   '@Konto']
]  );
}
function DEB_Frist () { return( [
['0',  '@Straks',  '@Betaling øjeblikkelig' ],
['8',  '@8 dage',  '@Betaling inden 8 dage' ],
['14', '@14 dage', '@Betaling inden 14 dage'],
['30', '@30 dage', '@Betaling inden 30 dage']
]  );
}
function DEB_Dok () { return( [
['pdf',   '@PDF-fil','@Fil i pdf-format'   ],
['email', '@email',  '@Elektronisk forsendelse'],
['ioubl', '@OIOUBL', '@Elektronisk fakturering'],
['pbs',   '@PBS',  '@PBS faktura'  ]
]  );
}
function CVR_Land () {return( [
['dk',   '@Denmark',  '@Search the Danish register',   'checked'],
['no',   '@Norwegian',  '@Search the Norwegian register',   '']
]  );
}
function CVR_Liste () {return( [
['search','@General',   '@General search: (not tel.)',   ''],
['vat',   '@CVR',   '@Centralt Virksomheds Register nr', ''],
['produ', '@P-unit',  '@Production unit-no',   ''],
['phone', '@Phone',   '@Phone number',   ''],
['name',  '@Company name',  '@Company name',  'checked']
]  );
}
function refresh($name) {if (isset($_POST[$name]))  {$_SESSION[$name]= $$name= htmlspecialchars($_POST[$name]); return $$name; } }
function set_FormVars ($names) { foreach ($names as $name) $$name= refresh($name); }
function get_FormVars ($names) { foreach ($names as $name) $$name= $_SESSION[$name]; }
function dev_show() { if ($GLOBALS["Ødebug"]) {echo 'SESSIONS variablers indhold: ';  vis_data($_SESSION);} }
$test= false;
$KIS = false;
if ($test) arrPrint($_POST,'$_POST');
$dPath= '../demoData/';
$bytes= 0;
if (isset($_POST['btn_sav_orders'  ])) { tabl2arr($arrOrders,'ord_id',['ord_total']);
$bytes+= FileWrite_arr($dPath.$filepath= 'arrOrders.dat.json',$arrOrders );}
if (isset($_POST['btn_sav_content' ])) { tabl2arr($arrContent,'cnt_post',['cnt_price', 'cnt_total']);
$bytes+= FileWrite_arr($dPath.$filepath='arrContent.dat.json',$arrContent);}
if (isset($_POST['btn_sav_customr' ])) { form2arr($arrCustomr); $bytes+= FileWrite_arr($dPath.$filepath='arrCustomr.dat.json',$arrCustomr);}
if (isset($_POST['btn_sav_billing' ])) { form2arr($arrBilling); $bytes+= FileWrite_arr($dPath.$filepath='arrBilling.dat.json',$arrBilling);}
if (isset($_POST['btn_sav_deliver' ])) { form2arr($arrDeliver); $bytes+= FileWrite_arr($dPath.$filepath='arrDeliver.dat.json',$arrDeliver);}
if (isset($_POST['btn_sav_conditi' ])) { form2arr($arrConditi); $bytes+= FileWrite_arr($dPath.$filepath='arrConditi.dat.json',$arrConditi);}
if (isset($_POST['btn_sav_mailinv' ])) { form2arr($arrMailing); $bytes+= FileWrite_arr($dPath.$filepath='arrMailing.dat.json',$arrMailing);}
if (isset($_POST['btn_sav_contact' ])) { form2arr($arrContact); $bytes+= FileWrite_arr($dPath.$filepath='arrContact.dat.json',$arrContact);}
if (isset($_POST['btn_sav_custFld' ])) { form2arr($arrCustfld); $bytes+= FileWrite_arr($dPath.$filepath='arrCustfld.dat.json',$arrCustfld);}
if (isset($_POST['btn_sav_cvrform' ])) {}
if (isset($_POST['btn_sav_language'])) { $lang = $_POST['language']; }
if (isset($_POST['btn_cre_contact' ])) {  }
if (isset($_POST['btn_era_contact' ])) {  }
if (isset($_POST['btn_goo_doLookup'])) {  }
if (isset($_POST['btn_cre_doInvo'  ])) {  }
if (isset($_POST['btn_cre_doNote'  ])) {  }
if (isset($_POST['btn_hom_doCredit'])) {  }
if (isset($_POST['btn_era_doErase' ])) {  }
$arrNames= ['arrCustomr','arrBilling','arrDeliver','arrConditi','arrMailing','arrContact','arrCustfld','arrOrders' ,'arrContent'];
fromfile($dPath, $arrNames);
#!!!: Remember no OUTPUT to screen, before htm_PagePrep
htm_PagePrep($pageTitl='OrderCreate.page.php', $ØPageImage=$ØProgRoot.'_assets/images/_background.png',$align='center',$PgInfo=lang('@Example: Customer-ORDER'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
Menu_Topdropdown(true); htm_nl(1);
if ($test) echo '<pre>'.$log.'</pre>'. '<br>Saved: '.$bytes.' bytes to data-files.<br>';
htm_Caption($labl='Tiny-Cloud-Accounting',$style='color:'.$ØTitleColr.'; font-weight:600; font-size: 18px;',$align='center');
htm_nl(1);
htm_PanlHead($frmName='orders', $capt=lang('@Find existing order:'), $parms='', $icon='fas fa-search', $class='panelW960', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
htm_Table(
$TblCapt= array(
['@Customer orders', 'Width', 'html', 'OutFormat', 'horJust', 'Tip', 'placeholder', '']
),
$RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'  ], ['Næste record'],...
),
$RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],...
['@id',   '8%','show', '',   ['center'],  '@id number maintained by the system','..auto..'],
['@Order',  '9%','indx', '',   ['center'],  '@Order number','@Numb...'],
['@Order Date',   '4%','date', '',   ['left'  ],  '@Order Date','YYYY-MM-DD'],
['@Deliv. date',  '4%','date', '',   ['left'  ],  '@Delivery date','YYYY-MM-DD'],
['@Account',  '8%','text', '',   ['center'],  '@Debtor Account number','@Acco...'],
['@Company name','34%','text', '',   ['left'  ],  '@Company name','@Firm...'],
['@Seller',   '7%','text', '',   ['left'  ],  '@Seller','@Sell...'],
['@Amount',  '11%','text', '2d', ['right' ],  '@Order sum','@Amount...'],
['@Status',   '9%','osta', '',   ['left'  ],  '@Status','@Status...']
),
$RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!'], ['Næste record'],...
),
$TblNote= '',
$TblData= $arrOrders,
$fldNames=['ord_id', 'ord_ix', 'ord_date', 'del_date', 'ord_acco', 'ord_name', 'ord_sell', 'ord_total', 'ord_stat'],
$FilterOn= true,
$SorterOn= true,
$CreateRec=false,
$ModifyRec=true,
$ViewHeight= '200px',
$TblStyle= '',
$CalledFrom= __FUNCTION__
);
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='', $capt=lang('@Create new or modify order:'), $parms='', $icon='fas fa-plus', $class='panelW960', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
htm_PanlHead($frmName='customr', $capt=lang('Customer:'), $parms='', $icon='fas fa-user', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
htm_Input($type='text',$name='custkont',$valu=$arrCustomr[$name], $labl='@Customer nr.',  $hint='@Customer nr: Can not be edited, onlu created. The system sets this',$plho='@..auto..', $width='50%');
htm_Input($type='opti',$name='custopsl',$valu=$arrCustomr[$name], $labl='@Customer Lookup',   $hint='@Here you select which existing customer to select',$plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list= []);
htm_Input($type='rado',$name='custkate',$valu=$arrCustomr[$name], $labl='@Customer type',   $hint='@Customer kategori',  $plho='',  $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$more='required',
$list= [ ['priv', '@private', '@private'], ['prof', '@professional', '@professional']]);
htm_Input($type='text',$name='cust_cvr',$valu=$arrCustomr[$name], $labl='@CVR',   $hint='@CVR - Virksomheds ID.',  $plho='@Business only !',$width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid green;');
htm_Input($type='text',$name='cust_ean',$valu=$arrCustomr[$name], $labl='@EAN',   $hint='@EAN - Elektronisk-betalings ID', $plho='@Business only !',$width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid green;');
htm_Input($type='text',$name='custbreg',$valu=$arrCustomr[$name], $labl='@Bank reg.',   $hint='@Bank reg.',  $plho='Reg...',  $width= '33%');
htm_Input($type='text',$name='custbkto',$valu=$arrCustomr[$name], $labl='@Bank account',  $hint='@Bank account',   $plho='Account...',  $width= '66%');
htm_Input($type='text',$name='custinst',$valu=$arrCustomr[$name], $labl='@Institution',   $hint='@Additional information',   $plho='@Business only !',$width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid green;');
htm_Input($type='text',$name='custansv',$valu=$arrCustomr[$name], $labl='@Customer manager',  $hint='@Customer manager',   $plho='@Mana...',  $width='100%');
htm_Input($type='text',$name='custlang',$valu=$arrCustomr[$name], $labl='@Billing Language',  $hint='@The language to be used on invoice transcripts',$plho='@if the language is not local', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='R',$bord='border: 1px solid green;');
htm_Input($type='text',$name='custhome',$valu=$arrCustomr[$name], $labl='@Homepage',  $hint='@The customer Homepage',  $plho='@Business only!', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid green;');
htm_MiniNote('@Orange boxes are required fields.');
htm_MiniNote('@Green boxes - restricted use.');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='billing', $capt=lang('Billing:'), $parms='', $icon='fas fa-pen', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
htm_Input($type='area',$name='billoref',$valu=$arrBilling[$name], $labl='@Order info',   $hint='@@Systemfield: Auto fill out, when order is created/saved',$plho='@Order:... Date:...',   $width='100%', $algn='left',$unit='',$disa=true,$rows='1');
htm_Input($type='text',$name='billnavn',$valu=$arrBilling[$name], $labl='@Customer name',  $hint='@Enter costomer name',  $plho='@Name...',   $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$more='required');
htm_Input($type='text',$name='billaddr',$valu=$arrBilling[$name], $labl='@Customer address',   $hint='@Enter invoice address',  $plho='@Address...',   $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$more='required');
htm_Input($type='text',$name='billsted',$valu=$arrBilling[$name], $labl='@Customer place',   $hint='@Enter invoice place',  $plho='@Place...');
htm_Input($type='text',$name='billponr',$valu=$arrBilling[$name], $labl='@ZIP',  $hint='@ZIP code',   $plho='@ZIP...',   $width='30%', $algn='left',$unit='',$disa=false,$rows='1',$step='',$more='required');
htm_Input($type='text',$name='billbynv',$valu=$arrBilling[$name], $labl='@Invoice city',   $hint='@Invoice city',   $plho='@City...',  $width='68%', $algn='left',$unit='',$disa=false,$rows='1',$step='',$more='required');
htm_Input($type='text',$name='billland',$valu=$arrBilling[$name], $labl='@Invoice Country',  $hint='@Invoice Country',  $plho='@Country...');
htm_hr($ØTitleColr.'; height: 2px');
htm_Input($type='text',$name='billtelf',$valu=$arrBilling[$name], $labl='@Phone(s)',   $hint='@Phone, mobil, fax',  $plho='@Phone...',   $width='100%',$$algn='left',$unit='',$disa=false,$rows='1',$step='',$more='required');
htm_Input($type='text',$name='bill_att',$valu=$arrBilling[$name], $labl='@Attention',  $hint='@Attention - Customer contact', $plho='@Att...'  );
htm_Input($type='text',$name='billrekv',$valu=$arrBilling[$name], $labl='@Réquisition number',   $hint='@Customer reference to order',  $plho='@Ref...'  );
htm_Input($type='text',$name='billmail',$valu=$arrBilling[$name], $labl='@Email address',  $hint='@Customer Email address',   $plho='@Mail...' );
htm_Input($type='text',$name='billnote',$valu=$arrBilling[$name], $labl='@Remarks',  $hint='@Notes regarding the customer', $plho='@Rem...'  );
if (isset($_POST['use_mail'])) { $use_mail = 'checked'; }
htm_Input($type='chck',$name='use_mail',$valu=$arrBilling[$name], $labl='@Mailing',  $hint='@Send invoice with mail',   $plho='@...',  $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='', $list= [['use_mail','@Use mail','@Mailing active',$namechck]]);
htm_Input($type='date',$name='ordrdato',$valu=$arrBilling[$name], $labl='@Order Date',   $hint='@Dato for ordrens oprettelse',  $plho='@Date...',  $width='50%');
htm_Input($type='date',$name='faktdato',$valu=$arrBilling[$name], $labl='@Invoice Date',   $hint='@Invoice Date',   $plho='@Date...',  $width='50%');
htm_Input($type='date',$name='gen_fakt',$valu=$arrBilling[$name], $labl='@Rebills',  $hint='@When to rebill date',  $plho='@Date...',  $width='50%');
htm_MiniNote('@Orange boxes are required fields.');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='deliver', $capt=lang('Delivery:'), $parms='', $icon='fas fa-truck', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
htm_Input($type='chck', $name='sameaddr',  $valu= $arrDeliver[$name], $labl='@Delivered to invoice address', $hint='@Check here if the delivery address is the same as the invoice address',$plho='', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',
$list= [['sameaddr','@Same address','@Automatic fillout with the same address as faktura',$namechck]]);
htm_Input($type='text', $name='deliname', $valu= $arrDeliver[$name], $labl='@Recipient Name',   $hint='@Enter Recipient Name',  $plho='Name...',   $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid blue;');
htm_Input($type='text', $name='deliaddr', $valu= $arrDeliver[$name], $labl='@Delivery Address', $hint='@Enter Delivery Address',  $plho='Addr..',   $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid blue;');
htm_Input($type='text', $name='deliplac', $valu= $arrDeliver[$name], $labl='@Place of Delivery',$hint='@Specify Place of Delivery, supplement to address',$plho='Sted...', $width='100%');
htm_Input($type='text', $name='deli_zip', $valu= $arrDeliver[$name], $labl='@ZIP',  $hint='@Enter Delivery Customer postcode', $plho='Pnr..',  $width='30%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid blue;');
htm_Input($type='text', $name='delicity', $valu= $arrDeliver[$name], $labl='@City Name',  $hint='@Enter Delivery City name',  $plho='City..',   $width='68%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='',$bord='border: 1px solid blue;');
htm_Input($type='text', $name='delicoun', $valu= $arrDeliver[$name], $labl='@Delivery Country', $hint='@Specify Delivery Country',  $plho='Contry...');
htm_hr($ØTitleColr.'; height: 2px');
htm_Input($type='text', $name='deliphon', $valu= $arrDeliver[$name], $labl='@Phone(s)',   $hint='@Enter Recipient`s Phone',   $plho='Phone..');
htm_Input($type='text', $name='delikont', $valu= $arrDeliver[$name], $labl='@Contact person at the delivery address', $hint='@Enter Contact Name',  $plho='Name...');
htm_Input($type='mail', $name='delimail', $valu= $arrDeliver[$name], $labl='@Recipient`s Email Address', $hint='@Enter Recipient`s Email Address',  $plho='Mail...');
htm_Input($type='text', $name='shipmeth', $valu= $arrDeliver[$name], $labl='@Shipping Method.', $hint='@Enter Shipping Information. How / with whom was the package sent?',$plho='Shipp...');
htm_Input($type='area', $name='delinote', $valu= $arrDeliver[$name], $labl='@Notes to freight forwarder',$hint='@Notes regarding package delivery', $plho='Note...', $width='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$more='');
htm_Input($type='chck', $name='shipped_', $valu= $arrDeliver[$name], $labl='@Status',   $hint='@Once the service has been sent, amounts can be redeemed', $plho='@Enter...',$width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',
$list= [['shipped_','@Are shipped','@Ready for redemption',$shipped_]]);
htm_Input($type='date', $name='lev_dato', $valu= $arrDeliver[$name], $labl='@Delivery Date',  $hint='@Possibly. shipment date',  $plho='Date...',  $width='50%'   );
$delName= $arrDeliver['deliname'];
$delAddr= $arrDeliver['deliaddr'];
$delPlac= $arrDeliver['deliplac'];
$del_Zip= $arrDeliver['deli_zip'];
$delCity= $arrDeliver['delicity'];
if ($arrCustomr['custkate']=='prof') $register='/firma'; else $register='/personer';
htm_LinkButt(  $labl='@Address on card', $gotoLink='https://krak.dk/'. $arrDeliver['deliname'].'+'.$arrDeliver['deliaddr'].'+'.$arrDeliver['deli_zip'].'+'.$arrDeliver['delicity'].$register, $hint='@Show address on map', $target='_blank');
htm_AcceptButt($labl='@Delivery note', $hint='@Show delivery note for delivery', $btnKind='sear', $frmName='deliver', $width='', $akey='l', $proc=true,  $tipplc='LblTip_text', $tipstyl='',
$clickFunction="toast(\"<b>DEMO:</b><br>$delName <br>$delAddr <br>$delPlac <br>$del_Zip - $delCity\",\"lightyellow\",\"black\")");
htm_MiniNote('@Blue boxes and customer type, Used for map lookup.');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
if ($KIS!=true) {
htm_PanlHead($frmName='conditi', $capt=lang('Conditions:'), $parms='', $icon='far fa-credit-card', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
#htm_Input($type='opti',$name='faktbynv',$valu=$arrCustomr[$name], $labl='@Faktura By',  $hint='@Faktura by', $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more='',$plho='@Bynavn...');
htm_Input($type='opti', $name='debigrup', $valu= $arrConditi[$name], $labl='@Debtor group',  $hint='@Choose which group the customer belongs to', $plho='', $width='100%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='', $optlist= DEB_Grup() );
htm_Input($type='opti', $name='betaling', $valu= $arrConditi[$name], $labl='@Payment method',  $hint='@How to pay',   $plho='', $width='100%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='', $optlist= DEB_Betl() );
htm_Input($type='opti', $name='betfrist', $valu= $arrConditi[$name], $labl='@Payment deadline',  $hint='@How long is the deadline for payment', $plho='', $width='100%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='', $optlist= DEB_Frist(), $action='');
htm_Input($type='opti', $name='print_to', $valu= $arrConditi[$name], $labl='@Print to',  $hint='@Choose how to print, save or send the document.',$plho='',$width='68%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',  $optlist= DEB_Dok() );
htm_Input($type='text', $name='kunderef', $valu= $arrConditi[$name], $labl='@Customer reference',$hint='@for example. Requisitions no',   $plho='Ref...', $width='100%');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='mailinv', $capt=lang('Mail-invoice:'), $parms='', $icon='fas fa-envelope', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
htm_Input($type='text',$name='mailemne', $valu= $arrMailing[$name], $labl='@Mail subject',  $hint='@Enter Mail subject',   $plho='@Subj...');
htm_Input($type='area',$name='mailtext', $valu= $arrMailing[$name], $labl='@Mail message',  $hint='@Enter Mail text',  $plho='@Mess...');
htm_Input($type='file',$name='mailvedh', $valu= $arrMailing[$name], $labl='<i class=\'fas fa-paperclip\'></i> '.lang('@Mail Annex'),
$hint='@Enter Attached file',  $plho='@Annex...');
htm_Input($type='text',$name='mail__cc', $valu= $arrMailing[$name], $labl='@Copy to',   $hint='@Enter mail address to receive one copy of send mail',  $plho='Copy...');
htm_Input($type='text',$name='mail__bc', $valu= $arrMailing['mail__bc'], $labl='@Blind-copy to',  $hint='@Enter mail address to receive one BC-copy (hidden) of sent mail',$plho='BCopy...');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='contact', $capt=lang('Person contact:'), $parms='', $icon='fas fa-phone-square', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
function ContaktPers($arrCont,$value,$no='') {
htm_Input($type='text', $name= 'indx'  ."[$no]", $valu= $arrCont['indx'  ]["$no"], $labl='@No.',  $hint='@Specifies the order of the entries', $plho='@auto',  $width='15%',   $algn='center', $unit='',$disa=true,$rows='3',$step='1',$more='' );
htm_Input($type='text', $name= 'name'  ."[$no]", $valu= $arrCont['name'  ]["$no"], $labl='@Contact person', $hint='@Enter Contact person',   $plho='@Kont...',  $width='50%');
htm_Input($type='text', $name= 'titel' ."[$no]", $valu= $arrCont['titel' ]["$no"], $labl='@Titel',  $hint='@Enter the persons titel',  $plho='@Titl...',  $width='35%');
htm_Input($type='text', $name= 'phone' ."[$no]", $valu= $arrCont['phone' ]["$no"], $labl='@Phone',  $hint='@Enter phone number',   $plho='@Pho...',   $width='50%');
htm_Input($type='text', $name= 'mobil' ."[$no]", $valu= $arrCont['mobil' ]["$no"], $labl='@Mobil',  $hint='@Enter Mobilnr. or  lokal',   $plho='@Mobil/lok...', $width='50%',   $algn='left',   $unit='',$disa=false,$rows='3','',''  );
htm_Input($type='mail', $name= 'email' ."[$no]", $valu= $arrCont['email' ]["$no"], $labl='@E-mail',   $hint='@Enter E-mail',   $plho='@Mail...',  $width='80%');
htm_Input($type='area', $name= 'remark'."[$no]", $valu= $arrCont['remark']["$no"], $labl='@Remark',   $hint='@Enter note to the contact, e.g. role (director / secretary / driver)', $plho='@Note...', $width='80%',$algn='left',$unit='',$disa=false,$rows='1');
htm_hr('lightgray');
htm_AcceptButt($labl='@Delete', $hint='@Remove this contact person <br> (DEMO yet!)', $btnKind='eras', $frmName='contact_'.$no, $width='', $akey='', $proc=true, $tipplc='', $tipstyl='position: absolute; bottom: 8px;',$clickFunction='toast("Remove contact<br>Cant do it yet !","lightyellow","black")');
htm_hr('green'.'; height: 2px');
htm_nl(1);
}
if ($arrContact) {
if (is_array($arrContact['indx'])) $max= count($arrContact['indx']); else $max= 1;
for ($i= 0; $i < $max; $i++) { ContaktPers($arrContact,$value,$no=$i); }
}
else htm_Caption('@Ingen oprettede kontakter.');
htm_AcceptButt($labl='@Create new', $hint='@Create a new contact <br> (DEMO yet!)', $btnKind='crea', $frmName='contact', $width='', $akey='', $proc=true, $tipplc='', $tipstyl='position: absolute; bottom: 8px;',$clickFunction='toast("Create contact<br>Cant do it yet !","lightyellow","black")');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
$content= '<small><b>Lookup in the CVR register</b> <br>(Business only !)<br>
Copy or check data in the public company register.
Data is provided by CVR API<br> </small>';
htm_PanlHead($frmName='cvrform', $capt=lang('CVR-lookup:'), $parms='', $icon='fas fa-database', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
htm_TextDiv($content, $align='left',$marg='8px',$more='');
set_FormVars(['cvrLand','cvrKode','cvrSoeg'  ]);
get_FormVars(['cvrLand','cvrKode','cvrSoeg']);
$cvrLand= $_SESSION['cvrLand'];   if (!$cvrLand) $cvrLand= 'dk';
$cvrKode= $_SESSION['cvrKode'];   if (!$cvrKode) $cvrKode= 'search';
$cvrSoeg= $_SESSION['cvrSoeg'];
if (($cvrLand) and ($cvrKode) and ($cvrSoeg))
{ $url= 'https://cvrapi.dk/api?'.$cvrKode.'='.$cvrSoeg.'&country='.$cvrLand;
$content = file_get_contents($url, false, stream_context_create(['http' => ['user_agent' => 'any']]));
$svar= json_decode($content, true);
if ($svar['vat']) { $cvrDiv= '';
$cvrNumm= $svar['vat'];
$cvrNavn= $svar['name'];
$cvrAddr= $svar['address'];
$cvrPost= $svar['zipcode'];
$cvrBy  = $svar['city'];
$cvrTelf= $svar['phone'];
if ($svar['email'])  {$cvrDiv.= lang('@Mail').': '. $svar['email'].'&#xa;';}
if ($svar['fax'])  {$cvrDiv.= lang('@Fax ').': '. $svar['fax'].'&#xa;';}
if ($svar['cityname'])   {$cvrDiv.= lang('@Place').': '.$svar['cityname'].'&#xa;';}
if ($svar['companydesc'])  {$cvrDiv.= lang('@Type').': '. $svar['companydesc'].'&#xa;';}
$ix= 0; while ($svar['owners'][$ix]['name'])   {$cvrDiv.= lang('@Ovner').': '.$svar['owners'][$ix]['name'].'&#xa;'; $ix++;}
$ix= 0; while ($svar['productionunits'][$ix]['pno']) {$cvrDiv.= lang('@P-nr').': '. $svar['productionunits'][$ix]['pno'].'&#xa;'; $ix++;}
}
}
htm_Input($type='opti', $name='cvrLand', $valu= $cvrLand='dk',  $labl='@Land registry',  $hint='@In what country do you want to apply?', $plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',   $optlist= CVR_Land(),$llgn='R',$bord='border: 1px solid green;');
htm_Input($type='opti', $name='cvrKode', $valu= $cvrKode='search', $labl='@Search for',  $hint='@What do you know?',   $plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',   $optlist= CVR_Liste(),$llgn='R',$bord='border: 1px solid green;');
htm_Input($type='text', $name='cvrSoeg', $valu= $cvrSoeg,   $labl='@CVR/P-uni./Phon/Name', $hint='@Enter here, data or company name that you want to search for',$plho='@Business only !', $width='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list=[],$llgn='R',$bord='border: 1px solid green;');
htm_MiniNote('@Green boxes are the basis for entry in the CVR.');
htm_hr('lightgray');
htm_AcceptButt($labl='@Search', $hint='@Start search in the CVR register', $btnKind='crea', $frmName='cvrform', $width='', $akey='s', $proc=true);
htm_hr('green');
htm_TextDiv($content=lang('Register data:'), $align='left',$marg='8px',$more='');
htm_Input($type='text', $name='cvrNumm', $valu= $cvrNumm, $labl='@CVR-number',  $hint='@Retrieved from the CVR register', $plho='@CVR...',  $width='33%');
htm_Input($type='text', $name='cvrNavn', $valu= $cvrNavn, $labl='@Company Name',$hint='@Retrieved from the CVR register', $plho='@Name...', $width='66%');
htm_Input($type='text', $name='cvrTelf', $valu= $cvrTelf, $labl='@Phone',   $hint='@Retrieved from the CVR register', $plho='@Phon...', $width='33%');
htm_Input($type='text', $name='cvrAddr', $valu= $cvrAddr, $labl='@Address',   $hint='@Retrieved from the CVR register', $plho='@Addr...', $width='66%');
htm_Input($type='text', $name='cvrPost', $valu= $cvrPost, $labl='@ZIP',   $hint='@Retrieved from the CVR register', $plho='@zip...',  $width='33%');
htm_Input($type='text', $name='cvrBy',   $valu= $cvrBy,   $labl='@City',  $hint='@Retrieved from the CVR register', $plho='@City...',   $width='66%');
htm_AcceptButt('@Use',lang('@Use the data shown in your registration of ').$hvem.'. <br>'. lang('@Warning: Possibly previous data is overwritten! (Fields without content, do not affect external data). <br> Not working yet'), $btnKind='save', $frmName='cvrform', $width='', $akey='b', $proc=true);
htm_Input($type='area', $name='cvrDiv',   $valu= $cvrDiv,   $labl='@Other things',   $hint='@Retrieved from the CVR register, various supplementary data', $plho='@Various...', $width='100%');
htm_PanlFoot($labl='@Save', $subm=false, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
$custFld= [
['@Extra Field 1','@Extras - Fill in the field 1','@Field 1...'],
['@Extra Field 2','@Extras - Fill in the field 2','@Field 2...'],
['@Extra Field 3','@Extras - Fill in the field 3','@Field 3...'],
['@Extra Field 4','@Extras - Fill in the field 4','@Field 4...'],
['@Extra Field 5','@Extras - Fill in the field 5','@Field 5...']
];
htm_PanlHead($frmName='extra', $capt=lang('Extra fields:'), $parms='', $icon='fas fa-plus', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
htm_Input($type='text',$name='felt1', $valu= $arrCustfld['felt1'], $labl= lang($custFld[0][0]), $hint= lang($custFld[0][1]),$plho= lang($custFld[0][2]), $width='66%');
htm_Input($type='text',$name='felt2', $valu= $arrCustfld['felt2'], $labl= lang($custFld[1][0]), $hint= lang($custFld[1][1]),$plho= lang($custFld[1][2]), $width='66%');
htm_Input($type='text',$name='felt3', $valu= $arrCustfld['felt3'], $labl= lang($custFld[2][0]), $hint= lang($custFld[2][1]),$plho= lang($custFld[2][2]), $width='66%');
htm_Input($type='text',$name='felt4', $valu= $arrCustfld['felt4'], $labl= lang($custFld[3][0]), $hint= lang($custFld[3][1]),$plho= lang($custFld[3][2]), $width='66%');
htm_Input($type='text',$name='felt5', $valu= $arrCustfld['felt5'], $labl= lang($custFld[4][0]), $hint= lang($custFld[4][1]),$plho= lang($custFld[4][2]), $width='66%');
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
}
htm_PanlHead($frmName='', $capt='', $parms='', $icon='', $class='panelW280', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: white; visibility: hidden;');
htm_PanlFoot();
htm_PanlFoot($labl='', $subm=false, $title='');
htm_PanlHead($frmName='content', $capt=lang('@Content of the order:'), $parms='', $icon='fas fa-plus', $class='panelW960', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
global $ordrTotal;
$link= '#';
$ordrTotal= 0;
htm_Table(
$TblCapt= array( #['0:Label',   '1:Width',  '2:Type',  '3:OutFormat', '4:horJust',  '5:Tip',  '6:placeholder', '7:Content';],...
),
$RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'  ], ['Næste record'],...
),
$RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],...
['@Pos.',   '5%','indx', '',  ['center'],'@Position number. is assigned automatically','..auto..'],
['@Item no.',   '8%','text', '',  ['center'],'@Item number for the service','Item...'],
['@Number',   '3%','text', '1d',['center'],'@Quantity stated as number','@Numb...'],
['@Unit',   '6%','text', '',  ['left'  ],'@Unit designation','@Unit...'],
['@Description', '30%','text', '',  ['left'  ],'@Description of the product / service','@Dest...'],
['@VAT' ,   '5%','text', '1d',['center'],'@VAT pct. rate','@vat...'],
['@Price',  '8%','text', '2d',['center'],'@Unit price ','@Price...'],
['@%',  '6%','text', '1d',['right' ],'@Discount percent','@Disc...'],
['@Total',   '10%','calc', '2d',['right' ],'@Calculated amount for the current posting.',''],
['@Currency',   '5%','text', '',  ['center'],'@Currency code for the currency used on the specification.','Curr...'],
['@Maturity',   '9%','hidd', '',  ['center'],'@Due date of the amount','Due date'],
),
$RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!'], ['Næste record'],...
['@Del.', '2%','text', '',  ['center'],
lang('@Delete the row! <br> WARNING - you can not regret.'),
'<button type="button" onclick="deleteRow(\'table1\')"><i class="fas fa-trash-alt" style="font-size:14px; color:red;" title="'. lang('@You can not reverse this delete row !').'"></i></button>'
],
['@Und.', '2%','text', '',  ['center'],
lang('@Undo posting! <br> Refund the amount by clicking on the icon.').' '.
lang('@If the order is invoiced, the item can be returned until the order has been posted. Then it must be done by crediting the customer!'),
'<button style="padding: 2px 4px;" onclick=\'toast("Reverse this post<br>Cant do it yet !","lightyellow","black")\'><ic class="fas fa-undo" style="font-size:14px; color:orange;" title="'.
lang('@Reverse this entry, e.g. undo reminder fee').'"></ic></button>'],
['@Mov.', '2%','text', '',  ['center'], '@Move an entry up or down.',
'<button onclick=\'toast("Moving this post<br>Cant do it yet !","lightyellow","black")\'><ic class="fas fa-arrows-alt-v" style="font-size:14px; color:green;" title="'.
lang('@Not working yet').'"></ic></button>']
),
$TblNote=   '<small>This table contains an example of on the fly automatic calculation:<br>$total= ($DataRow[2]*$DataRow[6])*(100-$DataRow[7])/100*(100+$DataRow[5])/100;</small>',
$data = $arrContent,
$fldNames=['cnt_post', 'cnt_product', 'cnt_numb', 'cnt_unit', 'cnt_description', 'cnt_vat', 'cnt_price', 'cnt_discount', 'cnt_total', 'cnt_currency', 'cnt_duedate'],   #
$FilterOn= false,
$SorterOn= false,
$CreateRec=true,
$ModifyRec=true,
$ViewHeight= '250px',
$CalledFrom= __FUNCTION__
);
htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='handling', $capt=lang('Handling the order:'), $parms='', $icon='fas fa-check', $class='panelW960', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: lightgray;');
htm_nl(1);
htm_Input($type='text', $name='ordr', $valu= $xx='0000', $labl='<b>'.lang('@Order:').'</b>',  $hint='@System field: Order number',   $plho='',   $width='100px',$algn='left',$unit='',$disa=true,$rows='1',$step='',$more='');
htm_Input($type='text', $name='cust', $valu= 'Customer', $labl='<b>'.lang('@Customer:').'</b>', $hint='@System field: Customer name',  $plho='',   $width='400px',$algn='left',$unit='',$disa=true,$rows='1',$step='',$more='');
htm_Input($type='dec2', $name='totl', $valu= $ordrTotal, $labl='<b>'.lang('@Total:').'</b>',  $hint='@System field: Amount incl. VAT', $plho= '',  $width='120px',$algn='center',$unit=' DKK ',$disa=true,$rows='1',$step='',$more='');
htm_nl(2);
htm_AcceptButt('@Create / update',  lang('@Save the order'),  $btnKind='save',   $frmName='handling', $width='120px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;');
htm_nl(2);
htm_AcceptButt('@Lookup',   lang('@Browse other existing orders'),  $btnKind='goon',   $frmName='doLookup', $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Lookup<br>Cant search yet !","orange","black")');
htm_AcceptButt('@Make Delivery Note',lang('@Make delivery note for the shipment of the order'),   $btnKind='creat',  $frmName='doNote',   $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Make delive note<br>Cant create yet !","orange","black")');
htm_AcceptButt('@Create Invoice ',  lang('@Create invoice for (the saved!) Order'),   $btnKind='creat',  $frmName='doInvo',   $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Create invoice<br>Cant create yet !","orange","black")');
htm_AcceptButt('@Give credit',  lang('@Reset by crediting the order - if it is invoiced'),  $btnKind='home',   $frmName='doCredit', $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Give credit<br>Cant do it yet !","orange","black")');
htm_AcceptButt('@Delete',   lang('@Delete the order - provided the invoice is not formed'), $btnKind='eras',   $frmName='doErase',  $width='140px', $akey='', $proc=true, $tipplc='LblTip_text', $tipstyl='position: absolute; bottom: 50px;',$clickFunction='toast("Delete<br>Cant erase yet !","orange","black")');
htm_nl(2);
htm_PanlFoot();
htm_nl(1);
htm_PanlHead($frmName='language', $capt='Settings:', $parms='', $icon='fas fa-wrench', $class='panelW320', $where=__FILE__, $more='', $BookMark='blindAlley.page.php');
htm_TextDiv(lang('@Change the language for this page:<br>'));
global $lang;
htm_Input($type='opti',$name='language',$valu= $lang, $labl='@Select language', $hint='@Select among installed languages',$plho='', $width='50%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',
$list= [['en','@English','@Select english language'],
['fr','@French','@Select french language'],
['de','@German','@Select german language'],
['da','@Dansk','@Select danish language']]);
htm_TextDiv('Note: The translate is not complete !<br> Only the Panel-headers will change.<br>');
htm_PanlFoot($labl='@Save and use', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
htm_PanlHead($frmName='', $capt='Info about this page:', $parms='', $icon='fas fa-info', $class='panelW320', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: lightyellow; ');
htm_TextDiv('This is a demo under development !<br>
It stores data to JSON text files.<br>
No connection to a SQL-database.<br>
There is also a lack of functionality.<br>
');
htm_PanlFoot();
if ($KIS!=true) {
if ($bytes== 0) {
PanelOff($First=5,$Last=11);
PanelOff($First=14,$Last=15);
PanelOff($First=1,$Last=1);
}
}
htm_PageFina();
?>