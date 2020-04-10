<?   $DocFile='../Proj1/Demo.page.php';    $DocVers='1.0.0';    $DocRev1='2020-04-10';     $DocIni='evs';  $ModulNo=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
//require_once ('translate.inc.php');

  

htm_PagePrep('DEMO');
    echo '<div style="text-align:center;"><br>php2html-Demo:';  htm_nl(2);

### Programmets hovedmenu:  
//global $Øvis_finans, $Øvis_debitor, $Øvis_kreditor, $Øvis_prodkt, $Øvis_lager, $Øadd_on;
  //if ($vismenu and ($loggetind==true))
  //  {Menu_Topdropdown($Øvis_finans=true, $Øvis_debitor=true, $Øvis_kreditor=true, $Øvis_prodkt=true, $Øvis_lager=true, $Øadd_on); htm_nl(2); }  /* include $ØProgRoot."_base/htm_TopMenu-body.htm"; Erstattet af rutiner i out_base.php*/ 

    echo 'Examples of htm_Input():';    						htm_nl(2);
    if (USEGRID) echo '<div class="grid-container" style="width: 700px; margin:auto;">';
	
	$vars= ['text','date','intg','dec0','dec1','dec2','chck','opti','num1','num0','mail','pass','barc','area','html','rado'];
	foreach ($vars as $v) {$$v= update($$v,$v); };	// echo $v.':'.$$v.' ';};

    htm_Input($type='text',$name='text',$valu=$text, $labl='@htm_Input(Text)',$hint='@Demo of htm_Input Field type text');
	htm_Input($type='date',$name='date',$valu=$date, $labl='@htm_Input(Date)',$hint='@Demo of htm_Input Field type date with browser popup selector');
    htm_Input($type='intg',$name='intg',$valu=$intg, $labl='@htm_Input(Intg)',$hint='@Demo of htm_Input Field type intg: centered integer',$algn='center');
    
	htm_Input($type='dec0',$name='dec0',$valu=$dec0, $labl='@htm_Input(Dec0)',$hint='@Demo of htm_Input Field type dec0: centered number with 0 decimals',$algn='center',$unit=' %');
    htm_Input($type='dec1',$name='dec1',$valu=$dec1, $labl='@htm_Input(Dec1)',$hint='@Demo of htm_Input Field type dec1: number with 1 decimal ');
    htm_Input($type='dec2',$name='dec2',$valu=$dec2, $labl='@htm_Input(Dec2)',$hint='@Demo of htm_Input Field type dec2: number with 2 decimal',$algn='center',$unit='<$ ');
    htm_Input($type='opti',$name='opti',$valu='87654321',$labl='@htm_Input(opti)',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',$algn='left',$unit=' %',$disabl=false,$rows='3',$width='',$step='',$more='',$plho='@Enter...',$dataList= [
    ['name1','private','@Details about private'],
    ['name2','proff','@Details about profession'],
    ['name3','private','@Details about private','checked'],
    ['name4','hobby','@Details about hobby'],
    ['name5','private','@Details about private'],
    ]);
    htm_Input($type='dec0',$name='dec0',$valu='87654321',$labl='htm_Input(Dec0)',$hint='Demo of htm_Input Field type dec0: left aligned number with %-suffix',$algn='left',$unit=' %',);
    htm_Input($type='dec1',$name='dec1',$valu='87654321',$labl='htm_Input(Dec1)',$hint='Demo of htm_Input Field type dec1: centered number with %-suffix',$algn='center',$unit=' %',);
    htm_Input($type='dec2',$name='dec2',$valu='87654321',$labl='htm_Input(Dec2)',$hint='Demo of htm_Input Field type dec2: right aligned number with %-suffix',$algn='right',$unit=' %',);
    
	htm_Input($type='num1',$name='num1',$valu='87654321',$labl='@htm_Input(num1)',$hint='@Demo of htm_Input Field type numb: number with 1 decimal',$algn='center');
    htm_Input(      'num0',      'num0',      '87654321',      '@htm_Input(num0)',      '@Demo of htm_Input Field type numb: left-justified number',$algn='left');
    htm_Input($type='chck',$name='chck',$valu='', $labl='htm_Input(chck)',$hint='Demo of htm_Input Field type chck: Multi-line formatted chck-text',$algn='left',$unit='',$disabl=false,$rows='3',$width='',$step='',$more='',$plho='Enter...',$dataList= [
        ['name1','@Label1','@Details about label1','checked'],
        //['name2','@Label2','@Details about label2','checked']
    ]);
    htm_Input($type='mail',$name='mail',$valu='',		$labl='@htm_Input(mail)',$hint='@Demo of htm_Input Field type mail with syntax control');
    htm_Input($type='pass',$name='pas1',$valu='',		$labl='@htm_Input(pass)',$hint='@Demo of htm_Input Field type pass with "hidden" output');
    htm_Input($type='barc',$name='barc',$valu='BARCODE',$labl='@htm_Input(barc)',$hint='@Demo of htm_Input Field type barc: shown with font barcode',$algn='center');
    htm_Input($type='area',$name='area',$valu='',		$labl='@htm_Input(area)',$hint='@Demo of htm_Input Field type area: Multi-line text',$disabl=false,$rows='3');
    htm_Input($type='html',$name='html',$valu='',		$labl='@htm_Input(html)',$hint='@Demo of htm_Input Field type html: Multi-line formatted html-text',$disabl=false,$rows='3');
    
	htm_Input($type='chck',$name='chck',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',$algn='left',$unit='',$disabl=false,$rows='3',$width='',$step='',$more='',$plho='Enter...',$dataList= [
    ['pos1','@private','@Details about private'],
    ['pos2','@proff','@Details about profession'],
    ['pos3','@private','@Details about private'],
    ['pos4','@hobby','@Details about hobby','checked'],
    ['pos5','@private','@Details about private'],
    ]);
    
	htm_Input($type='rado',$name='rado',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio',$algn='left',$unit='',$disabl=false,$rows='2',$width='',$step='',$more='',$plho='Enter...',$dataList= [
    ['post1','private','@private'],
    ['post2','proff','@profession'],
    ['post3','private','@private','checked'],
    ['post4','hobby','@hobby'],
    ['post5','private','@private'],
    ]);
    if (USEGRID) echo '</div>'; // grid-container}
    htm_nl(2);
    echo 'Example of htm_Table():'; 
	htm_nl(2);
    htm_Table(
        $TblCapt= array( #['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:horAlgn',      '5:Tip',    '6:Content'],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
          ['<b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on India','@PURCHASE'],
          ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
        ),
        $RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
            ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => knap
        $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',          '4%','text','',['center'],'@Position number in the group','.No.'],
          ['@Description', '20%','data','',['left'  ],'@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',      '6%','data','',['center'],'@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',       '6%','data','',['center'],'@VAT % rate','25 %...'],
          ['@Note',        '30%','text','',['left'  ],'@Note about the record','.?.'],
        ),
        $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','knap','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),            # Felt 4: ($fieldModes), er sammensat af: [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        $tblData= array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], [['2'],[''],[''],[''],[''] ] ),       # = array(),
        $FilterOn= true,        # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
        $SorterOn= true,        # Mulighed for at sortere records efter kolonne indhold
        $CreateRec=true,        # Mulighed for at oprette en record
        $ModifyRec=true,        # Mulighed for at vælge og ændre data i en row
        $ViewHeight= '200px',   # Højden af den synlige del af tabellens data
        $CalledFrom='',         // = __FUNCTION__
        $Kriterie= ['','']      # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
    );
	
    htm_nl(2);
    echo 'Example of htm_PanlHead():';  htm_nl(2);
    htm_PanlHead($frmName='head', $capt='htm_PanlHead(W= 560px)', $parms='', $icon='fas fa-database', $class='panelW560', $func='Undefined', $more='', $BookMark='../_base/page_Blindgyden.php');
        echo 'More examples of htm_Input():';   htm_nl(2);
        htm_Input($type='pass',$name='pass2',$valu='',$labl='@htm_Input(pass)',$hint='Demo of htm_Input Field type password with "hidden" output',$algn='left',$unit='',$disabl=false,$rows='3',$width='95%');
        htm_Input($type='mail',$name='mail',$valu='',$labl='@htm_Input(mail)',$hint='Demo of htm_Input Field type mail with syntax control',$algn='left',$unit='',$disabl=false,$rows='3',$width='95%');
        htm_nl(2);
        htm_nl(2);
        htm_Input($type='chck',$name='chck',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',$algn='left',$unit='',$disabl=false,$rows='3',$width='300px',$step='',$more='',$plho='Enter...',$dataList= [
        ['name1','Label1','@Details about label','checked'],
        ['name1','Label2','@Details about label','checked']
        ]);
        htm_nl(2);
    htm_PanlFoot( $pmpt='Demo', $subm=false, $hinte='Buttom', $knapArt='', $akey='', $simu=false, $frmName='');
    
    $GridOn= false;
	echo 'Example 2 of htm_PanlHead():';    htm_nl(2);
    htm_PanlHead($frmName='head1', $capt='@Example of login:', $parms='', $icon='fas fa-pen-square', $class='panelW240', $func='Undefined', $more='', $BookMark='../_base/page_Blindgyden.php');
        //echo 'Example of login:'; htm_nl(2);
        htm_Input($type='text',$name='text',$valu='',$labl='@Financial Accounting:',$hint='@The name of the accounting for wich you have access',$algn='left',$unit='',$disabl=false,$rows='3',$width='75%',$step='',$more='',$plho='@Account...');
        htm_Input($type='mail',$name='mail',$valu='',$labl='@Your account:',$hint='@Type your email as your accont',$algn='left',$unit='',$disabl=false,$rows='3',$width='75%',$step='',$more='',$plho='@Email...');
        htm_Input($type='pass',$name='pass3',$valu='',$labl='@Your password:',$hint='@Type your password for your account',$algn='left',$unit='',$disabl=false,$rows='3',$width='75%',$step='',$more='',$plho='@Password...');
        $usr_name= 'user';  $usr_code= 'Code: PW-test';     $h= calcHash($usr_name,$usr_code);
        //htm_Input($type='html',$name='text',$valu=$h,$labl='Hash:',$hint='@Demo of htm_Input Field type html',$algn='left',$unit='',$disabl=false,$rows='2',$width='95%',$step='',$more='',$plho='@Account...');
        echo '<a href="'.$link.'" accesskey="'.$akey.'" '. Lbl_Tip('@Forgotten password ?','@Click to request a new password'). '</a>';
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disabl=false,$rows='3',$width='95%');
        htm_nl(0);
    htm_PanlFoot( $pmpt='Login', $subm=true, $hinte='@Login with the given data', $knapArt='', $akey='l', $simu=false, $frmName='');
    
    echo 'Example 3 of htm_PanlHead():';    htm_nl(2);
    htm_PanlHead($frmName='head1', $capt='@Customer contact:', $parms='', $icon='fas fa-pen-square', $class='panelW240', $func='Undefined', $more='', $BookMark='../_base/page_Blindgyden.php');
        //echo 'Example of login:'; htm_nl(2);
		$wdh= '95%';
		$m= ' padding:0; test:99; ';
		echo '<span style="text-aling: center;">';
        htm_Input($type='text',$name='name',$valu='',$labl='@Name:',	$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='text',$name='stre',$valu='',$labl='@Street:',	$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='text',$name='plac',$valu='',$labl='@Place:',	$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
		
		$GridOn= false;	// Without grid the following fields can be placed on a single row.
        htm_Input($type='text',$name='zipp',$valu='',$labl='@ZIP:',		$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width='25%',$step='',$more=$m,$plho='@?...');
        htm_Input($type='text',$name='city',$valu='',$labl='@City:',	$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width='68%',$step='',$more=$m,$plho='@?...');
        //if (USEGRID) $GridOn= true;
        
		htm_Input($type='text',$name='coun',$valu='',$labl='@Country:',	$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='area',$name='remk',$valu='',$labl='@Remark:',	$hint='@Demo of htm_Input Field type area: Multi-line text',$disabl=false,$rows='3',$width=$wdh);
		htm_Input($type='text',$name='phon',$valu='',$labl='@Phone:',	$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='text',$name='refe',$valu='',$labl='@Reference:',$hint='',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='mail',$name='mail',$valu='',$labl='@Email:',	$hint='@Demo of htm_Input Field type mail',$algn='left',$unit='',$disabl=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Email...');
        htm_Input($type='chck',$name='chck',$valu='',$labl='@Mailing:',	$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',$algn='left',$unit='',$disabl=false,$rows='3',$width='60%',$step='',$more=$m,$plho='Enter...',
		$dataList= [['name1','@Mailing active','@Use mail']]);
		
		$GridOn= false;
		htm_nl(1);
        htm_Input($type='date',$name='datr',$valu=$date, $labl='@Created',$hint='@Demo of htm_Input Field type date with browser popup selector',$algn='left',$unit='',$disabl=false,$rows='3',$width='45%');
		htm_Input($type='date',$name='dath',$valu=$date, $labl='@Changed',$hint='@Demo of htm_Input Field type date with browser popup selector',$algn='left',$unit='',$disabl=false,$rows='3',$width='45%');
		if (USEGRID) $GridOn= true;
		
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disabl=false,$rows='3',$width='95%');
        htm_nl(0);
		echo '</span>';
    htm_PanlFoot( $pmpt='Save', $subm=true, $hinte='@Login with the given data', $knapArt='', $akey='l', $simu=false, $frmName='');
    
    echo '</div>'; // DEMO
htm_PageFina();
?>