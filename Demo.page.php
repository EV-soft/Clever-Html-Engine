<?   $DocFile='../Proj1/Demo.page.php';    $DocVers='1.0.0';    $DocRev1='2020-05-29';     $DocIni='evs';  $ModulNo=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

  

htm_PagePrep('DEMO');
    echo '<div style="text-align: center;"><br>php2html-Demo:';  htm_nl(2);

### Program mainmenu:
//global $Øvis_finans, $Øvis_debitor, $Øvis_kreditor, $Øvis_prodkt, $Øvis_lager, $Øadd_on;
  if (($vismenu=true) and ($loggetind==true) or true)
    { Menu_Topdropdown(true); htm_nl(1); }

    echo 'The collection of htm_Input():';                            htm_nl(2);
    if (USEGRID) echo '<div class="grid-container tableStyle" style="width: 700px; margin:auto;">';

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    
    if (isset($_POST['name']))  { $namex = $_POST['name']; }
    
    $date= date("Y-m-d");

    htm_Input($type='text',$name='text',$valu=$text, $labl='@htm_Input(Text)',$hint='@Demo of htm_Input Field type text');
    htm_Input($type='date',$name='date',$valu=$date, $labl='@htm_Input(Date)',$hint='@Demo of htm_Input Field type date with browser popup selector');
    htm_Input($type='intg',$name='intg',$valu=$intg, $labl='@htm_Input(Intg)',$hint='@Demo of htm_Input Field type intg: centered integer',$algn='center');
    
    htm_Input($type='dec0',$name='dec0',$valu=$dec0, $labl='@htm_Input(Dec0)',$hint='@Demo of htm_Input Field type dec0: centered number with 0 decimals',$algn='center',$unit=' %');
    htm_Input($type='dec1',$name='dec1',$valu=$dec1, $labl='@htm_Input(Dec1)',$hint='@Demo of htm_Input Field type dec1: number with 1 decimal ');
    htm_Input($type='dec2',$name='dec2',$valu=$dec2, $labl='@htm_Input(Dec2)',$hint='@Demo of htm_Input Field type dec2: number with 2 decimal',$algn='center',$unit='<$ ');
    htm_Input($type='opti',$name='opti',$valu='87654321',$labl='@htm_Input(opti)',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',$algn='left',$unit=' %',$disa=false,$rows='3',$width='',$step='',$more='',$plho='@Enter...',$list= [
    ['name1','private','@Details about private'],
    ['name2','proff','@Details about profession'],
    ['name3','private','@Details about private','checked'],
    ['name4','hobby','@Details about hobby'],
    ['name5','private','@Details about private'],
    ]);
    htm_Input($type='dec0',$name='dec0a',$valu='87654321',$labl='htm_Input(Dec0)',$hint='Demo of htm_Input Field type dec0: left aligned number with %-suffix',$algn='left',$unit=' %',);
    htm_Input($type='dec1',$name='dec1a',$valu='87654321',$labl='htm_Input(Dec1)',$hint='Demo of htm_Input Field type dec1: centered number with %-suffix',$algn='center',$unit=' %',);
    htm_Input($type='dec2',$name='dec2a',$valu='87654321',$labl='htm_Input(Dec2)',$hint='Demo of htm_Input Field type dec2: right aligned number with %-suffix',$algn='right',$unit=' %',);
    
    htm_Input($type='num1',$name='num1',$valu='87654321',$labl='@htm_Input(num1)',$hint='@Demo of htm_Input Field type numb: number with 1 decimal',$algn='center');
    htm_Input(      'num0',      'num0',      '87654321',      '@htm_Input(num0)',      '@Demo of htm_Input Field type numb: left-justified number',$algn='left');
    htm_Input($type='chck',$name='chck',$valu='', $labl='htm_Input(chck)',$hint='Demo of htm_Input Field type chck: Multi-line formatted chck-text',$algn='left',$unit='',$disa=false,$rows='3',$width='',$step='',$more='',$plho='Enter...',$list= [
        ['name1','@Label1','@Details about label1','checked'],
        //['name2','@Label2','@Details about label2','checked']
    ]);
    htm_Input($type='mail',$name='mail',$valu='',       $labl='@htm_Input(mail)',$hint='@Demo of htm_Input Field type mail with syntax control');
    htm_Input($type='link',$name='link',$valu='',       $labl='@htm_Input(url)', $hint='@Demo of htm_Input Field type url with syntax control',$algn='left',$unit='',$disa=false,$rows='3',$width='',$step='',$more='',$plho='https://...');
    htm_Input($type='pass',$name='pas1',$valu='',       $labl='@htm_Input(pass)',$hint='@Demo of htm_Input Field type pass with "hidden" output');
    htm_Input($type='barc',$name='barc',$valu='BARCODE',$labl='@htm_Input(barc)',$hint='@Demo of htm_Input Field type barc: shown with font barcode',$algn='center');
    htm_Input($type='html',$name='html',$valu='',       $labl='@htm_Input(html)',$hint='@Demo of htm_Input Field type html: Multi-line formatted html-text',$disa=false,$rows='3');
    htm_Input($type='area',$name='area',$valu='',       $labl='@htm_Input(area)',$hint='@Demo of htm_Input Field type area: Multi-line text',$disa=false,$rows='6');
    
    htm_Input($type='chck',$name='chck1',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',$algn='left',$unit='',$disa=false,$rows='3',$width='',$step='',$more='',$plho='Enter...',$list= [
    ['pos1','@private','@Details about private'],
    ['pos2','@proff','@Details about profession'],
    ['pos3','@private','@Details about private'],
    ['pos4','@hobby','@Details about hobby','checked'],
    ['pos5','@private','@Details about private'],
    ]);
    
    htm_Input($type='rado',$name='rado',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio',$algn='left',$unit='',$disa=false,$rows='2',$width='',$step='',$more='',$plho='Enter...',$list= [
    ['post1','private','@private'],
    ['post2','proff','@profession'],
    ['post3','private','@private','checked'],
    ['post4','hobby','@hobby'],
    ['post5','private','@private'],
    ]);
    htm_Input($type='rang',$name='rang',$valu='10',$labl='@htm_Input(rang)',$hint='@Demo of htm_Input Field type range: 0..50 ',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more=' min="0" max="50"');
    htm_Input($type='chck',$name='chcka',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type checkbox in a row',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='',$plho='Enter...',$list= [
    ['postc','dark','@Dark','checked'],
    ['postd','shiny','@Shiny'],
    ]);
    htm_Input($type='rado',$name='rado',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio in a row',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='',$plho='Enter...',$list= [
    ['posta','happy','@Happy','checked'],
    ['postb','sorry','@Sorry'],
    ]);
    htm_Input($type='colr',$name='colr',$valu='#0000ff',$labl='@htm_Input(colr)',$hint='@Demo of htm_Input Field type color',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='');
    htm_Input($type='butt',$name='butt',$valu='BUTTON',$labl='@htm_Input(butt)',$hint='@Demo of htm_Input Field type butt',$algn='center',$unit='',$disa=false,$rows='1',$width='',$step='',$more='');
    htm_Input($type='sear',$name='sear',$valu='',$labl='@htm_Input(sear)',$hint='@Demo of htm_Input Field type search',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='');
    htm_Input($type='file',$name='file',$valu='',$labl='@htm_Input(file)',$hint='@Demo of htm_Input Field type file',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='');
    htm_Input($type='time',$name='time',$valu='',$labl='@htm_Input(time)',$hint='@Demo of htm_Input Field type time',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='');
    htm_Input($type='imag',$name='imag',$valu='',$labl='@htm_Input(imag)',$hint='@Demo of htm_Input Field type image',$algn='left',$unit='',$disa=false,$rows='1',$width='',$step='',$more='');
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
    //      ['@Pref',         '4%','butt','',['center'],'@Row prefix', '<ic class="fas fa-check" style="color:green; font-size:13px; "></ic>'],
            ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => butt
        $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',          '5%','text','',['center'],'@Position number in the group','.No.'],
          ['@Description', '20%','data','',['left'  ],'@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',      '6%','data','',['center'],'@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',       '6%','data','',['center'],'@VAT % rate','25 %...'],
          ['@Note',        '30%','text','',['left'  ],'@Note about the record','.?.'],
        ),
        $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','butt','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),            # Felt 4: ($fieldModes), er sammensat af: [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        $TblNote=   '<br><b>Notes about htm_Table():</b><br>
                    Records can be sorted, filtered, created, modifyed and more...<br>
                    The visibly rows can be scrolled in a window below the fixed header.
                    ',
        $tblData= array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
                         [['2'],[''],[''],[''],[''] ], 
                         [['3'],[''],[''],[''],[''] ] ),       # = array(),
        $FilterOn= true,        # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
        $SorterOn= true,        # Mulighed for at sortere records efter kolonne indhold
        $CreateRec=true,        # Mulighed for at oprette en record
        $ModifyRec=true,        # Mulighed for at vælge og ændre data i en row
        $ViewHeight= '200px',   # Højden af den synlige del af tabellens data
        $TblStyle= 'background-image: url(\'_background.png\');',
        $CalledFrom='',         // = __FUNCTION__
        $Kriterie= ['','']      # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
    );
    
    htm_nl(2);
    echo 'Examples of foldable panel-system:';  htm_nl(2);
    htm_PanlHead($frmName='head', $capt='htm_PanlHead(W= 560px) (click to close/open)', $parms='', $icon='fas fa-database', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-image: url(\'_background.png\');');
        // echo 'More examples of htm_Input():';   
        htm_nl(2);
        echo 'Panels are used to display a collection of input fields.<br>
              They are defined i 14 widths from 160 px to 1200 px.<br><br>
              The panel content can be displayed/hidden by clicking panel-header.';
        htm_nl(2);
        htm_Input($type='pass',$name='pass2',$valu='',$labl='@htm_Input(pass)',$hint='Demo of htm_Input Field type password with "hidden" output',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='95%');
        htm_Input($type='mail',$name='mail1',$valu='',$labl='@htm_Input(mail)',$hint='Demo of htm_Input Field type mail with syntax control',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='95%');
        htm_nl(2);
        htm_nl(2);
        htm_Input($type='chck',$name='chck2',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='300px',$step='',$more='',$plho='Enter...',$list= [
        ['name1','Label1','@Details about label','checked'],
        ['name1','Label2','@Details about label','checked']
        ]);
        htm_nl(2);
    htm_PanlFoot( $labl='Demo', $subm=false, $title='Buttom', $btnKind='', $akey='', $simu=false, $frmName='');
    
    $GridOn= false;
    htm_nl(2);
    htm_PanlHead($frmName='head1', $capt='@Signup: <small>(Example)</small>', $parms='', $icon='fas fa-user-check', $class='panelW240', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-image: url(\'_background.png\');');
        //echo 'Example of login:'; htm_nl(2);
        htm_Input($type='text',$name='text1',$valu=$text1,$labl='@Financial Accounting',$hint='@The name of the accounting for wich you have access',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='75%',$step='',$more='',$plho='@Account...');
        htm_Input($type='mail',$name='mail2',$valu=$mail2,$labl='@Your account',$hint='@Type your email as your accont',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='75%',$step='',$more='',$plho='@Email...');
        htm_Input($type='pass',$name='pass3',$valu=$pass3,$labl='@Your password',$hint='@Type your password for your account',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='75%',$step='',$more='',$plho='@Password...');
        $usr_name= 'user';  $usr_code= 'Code: PW-test';     $h= calcHash($usr_name,$usr_code);
        //htm_Input($type='html',$name='text',$valu=$h,$labl='Hash:',$hint='@Demo of htm_Input Field type html',$algn='left',$unit='',$disa=false,$rows='2',$width='95%',$step='',$more='',$plho='@Account...');
        echo '<br><br><a href="'.$link.'" accesskey="'.$akey.'"> '. Lbl_Tip('@Forgotten password ?','@Click to request a new password'). '</a>';
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
        htm_nl(0);
    htm_PanlFoot( $labl='Login', $subm=true, $title='@Login with the given data', $btnKind='', $akey='l', $simu=false, $frmName='');
    
    htm_nl(2);
    htm_PanlHead($frmName='head2', $capt='@Contact info:', $parms='', $icon='fas fa-pen-square', $class='panelW240', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-image: url(\'_background.png\');');
        //echo 'Example of login:'; htm_nl(2);
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
        //echo '<span style="text-aling: center;">';
        htm_Input($type='text',$name='name',$valu=$namex,$labl='@Name', $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@The name...');
        htm_Input($type='text',$name='stre',$valu=$stre,$labl='@Street',   $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Address 1...');
        htm_Input($type='text',$name='plac',$valu=$plac,$labl='@Place',    $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Address 2...');
        
        $GridOn= false; // Without grid the following fields can be placed on a single row.
//        htm_Input($type='opti',$name='opti',$valu='87654321',$labl='@htm_Input(opti)',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',$algn='left',$unit=' %',$disa=false,$rows='3',$width='',$step='',$more='',$plho='@Enter...',$list= [
//    ['name1','private','@Details about private'],
//    ['name2','proff','@Details about profession'],
//    ['name3','private','@Details about private','checked'],
//    ['name4','hobby','@Details about hobby'],
//    ['name5','private','@Details about private'],
//    ]);
        htm_Input($type='opti',$name='zipp',$valu=$zipp,$labl='@ZIP',      $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='31%',$step='',$more=$m,$plho='@Code...',$list= [
                    ['5000','5000','@5000'],
                    ['6000','6000','@6000'],
                    ['6050','6050','@6050','checked'],
                    ['6080','6080','@6080'],
                    ['7000','7000','@7000'],
                    ]);
        htm_Input($type='text',$name='city',$valu=$city,$labl='@City', $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more=$m,$plho='@Address town...');
        //if (USEGRID) $GridOn= true;
        
        htm_Input($type='text',$name='coun',$valu=$coun,$labl='@Country',  $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Country...');
        htm_Input($type='area',$name='remk',$valu=$remk,$labl='@Remark',   $hint='@Demo of htm_Input Field type area: Multi-line text',
                    $algn='left',$unit='',$disa=false,$rows='1',$width=$wdh,$step='',$more=$m,$plho='@Remark?...');
        htm_Input($type='text',$name='phon',$valu=$phon,$labl='@Phone',    $hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Phone number...');
        htm_Input($type='text',$name='refe',$valu=$refe,$labl='@Reference',$hint='',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='mail',$name='mail3',$valu=$mail3,$labl='@Email',   $hint='@Demo of htm_Input Field type mail',
                    $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Email address...');
        
        if (isset($_POST['namechck']))  { $namechck = 'checked'; }        
        htm_Input($type='chck',$name='chck3',$valu=$chck3,$labl='@Mailing',  $hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='80%',$step='',$more=$m,$plho='Enter...',
        $list= [['namechck','@Mailing active','@Use mail',$namechck]]);
        
        $GridOn= false;
        htm_nl(1);
        htm_Input($type='date',$name='datr',$valu=$datr, $labl='@Created',$hint='@Demo of htm_Input Field type date with browser popup selector',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='48%');
        htm_Input($type='date',$name='dath',$valu=$dath, $labl='@Changed',$hint='@Demo of htm_Input Field type date with browser popup selector',
                    $algn='left',$unit='',$disa=false,$rows='3',$width='48%');
        //if (USEGRID) $GridOn= true;
        
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
        htm_nl(0);
        //echo '</span>';
    htm_PanlFoot( $labl='Save', $subm=true, $title='@Save data in this panel', $btnKind='', $akey='s', $simu=false, $frmName='');
    
    echo '</div>'; // DEMO
    htm_nl(2);
    // echo 'A look at the translate system:';  scannLngStrings();
htm_PageFina();
    run_Script('toast("<b>'. lang('@You`re looking at a DEMO !'). '</b><br>'. lang('@It is a demonstration of the php2html-output.'). '","green","white")');

?>