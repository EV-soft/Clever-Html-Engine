<?   $DocFile='../Proj.demo/Demo.page.php';    $DocVer='1.1.0';    $DocRev='2021-11-01';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
//$GLOBALS["ØProgRoot"]= './';
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

$tblData=               # = array(),
        array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
               [['2'],[''],[''],[''],[''] ], 
               [['3'],[''],[''],[''],[''] ] );
        

htm_Page_0('DEMO', $ØPageImage='../_accessories/_background.png',$align='center',$PgInfo=lang('@PHP2HTML Demo and Documentation'));
    echo '<div style="text-align: center;"><br>php2html-Demo:';  htm_nl(2);

### Program mainmenu:
//global $Øvis_finans, $Øvis_debitor, $Øvis_kreditor, $Øvis_prodkt, $Øvis_lager, $Øadd_on;
  if (($vismenu=true) and (($loggetind ?? '') == true) or true)
    { Menu_Topdropdown(true); htm_nl(1); }

    
## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';}; # Init with value 12345
    
    if (isset($_POST['name']))  { $namex = $_POST['name']; } // Special case !
    
    $date= date("Y-m-d");
    
    htm_Panel_0($frmName='', $capt='The collection of htm_Input():', $parms='', $icon='fas fa-info', $class='panelW720', $func='Undefined', $attr='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;'); 
    if (USEGRID) echo '<div class="grid-container tableStyle" style="width: 700px; margin:auto;">';

    htm_Input($type='text',$name='text',$valu=$text, $labl='@htm_Input(Text)',$hint='@Demo of htm_Input Field type text');
    htm_Input($type='date',$name='date',$valu=$date, $labl='@htm_Input(Date)',$hint='@Demo of htm_Input Field type date with browser popup selector');
    htm_Input($type='intg',$name='intg',$valu=$intg, $labl='@htm_Input(Intg)',$hint='@Demo of htm_Input Field type intg: centered integer',                     $plho='',$wdth='',$algn='center');
        
    htm_Input($type='dec0',$name='dec0',$valu=$dec0, $labl='@htm_Input(Dec0)',$hint='@Demo of htm_Input Field type dec0: centered number with 0 decimals',      $plho='',$wdth='',$algn='center',$unit=' %');
    htm_Input($type='dec1',$name='dec1',$valu=$dec1, $labl='@htm_Input(Dec1)',$hint='@Demo of htm_Input Field type dec1: number with 1 decimal ');  
    htm_Input($type='dec2',$name='dec2',$valu=$dec2, $labl='@htm_Input(Dec2)',$hint='@Demo of htm_Input Field type dec2: number with 2 decimal',                $plho='',$wdth='',$algn='center',$unit='<$ ');
    htm_Input($type='opti',$name='opti',$valu='87654321',$labl='@htm_Input(opti)',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',  $plho='@?...',$wdth='',$algn='left',$unit=' %',$disa=false,$rows='3',$step='',$attr='',$list= [
        ['name1','private','@Details about private'],
        ['name2','proff','@Details about profession'],
        ['name3','private','@Details about private','checked'],
        ['name4','hobby','@Details about hobby'],
        ['name5','private','@Details about private'],
    ]);
    htm_Input($type='dec0',$name='dec0a',$valu='87654321',$labl='htm_Input(Dec0)',$hint='Demo of htm_Input Field type dec0: left aligned number with %-suffix', $plho='',$wdth='',$algn='left',$unit=' %');
    htm_Input($type='dec1',$name='dec1a',$valu='87654321',$labl='htm_Input(Dec1)',$hint='Demo of htm_Input Field type dec1: centered number with %-suffix',     $plho='',$wdth='',$algn='center',$unit=' %');
    htm_Input($type='dec2',$name='dec2a',$valu='87654321',$labl='htm_Input(Dec2)',$hint='Demo of htm_Input Field type dec2: right aligned number with %-suffix',$plho='',$wdth='',$algn='right',$unit=' %');
    
    htm_Input($type='num1',$name='num1',$valu='87654321',$labl='@htm_Input(num1)',$hint='@Demo of htm_Input Field type numb: number with 1 decimal',            $plho='',$wdth='',$algn='center');
    htm_Input(      'num0',      'num0',      '87654321',      '@htm_Input(num0)',      '@Demo of htm_Input Field type numb: left-justified number',            $plho='',$wdth='',$algn='left');
    htm_Input($type='chck',$name='chck',$valu='', $labl='htm_Input(chck)',$hint='Demo of htm_Input Field type chck: Multi-line formatted chck-text',            $plho='?...',$wdth='',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list= [
        ['name1','@Label1','@Details about label1','checked'],
        //['name2','@Label2','@Details about label2','checked']
    ]);
    htm_Input($type='mail',$name='mail',$valu='',       $labl='@htm_Input(mail)',$hint='@Demo of htm_Input Field type mail with syntax control',                $plho='',$wdth='25%');
    htm_Input($type='link',$name='link',$valu='',       $labl='@htm_Input(url)', $hint='@Demo of htm_Input Field type url with syntax control',                 $plho='https://...',$wdth='',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='');
    htm_Input($type='pass',$name='pas1',$valu='',       $labl='@htm_Input(pass)',$hint='@Demo of htm_Input Field type pass with "hidden" output',               $plho='',$wdth='25%');
    // FIXIT: Not showing pass-field ! ?
    htm_Input($type='barc',$name='barc',$valu='BARCODE',$labl='@htm_Input(barc)',$hint='@Demo of htm_Input Field type barc: shown with font barcode',           $plho='',$wdth='25%',$algn='center');
    htm_Input($type='html',$name='html',$valu='',       $labl='@htm_Input(html)',$hint='@Demo of htm_Input Field type html: Multi-line formatted html-text',    $plho='?...',$wdth='25%',$algn='left',$unit='',$disa=false,$rows='3');
    htm_Input($type='area',$name='area',$valu='',       $labl='@htm_Input(area)',$hint='@Demo of htm_Input Field type area: Multi-line text',                   $plho='?...',$wdth='200px',$algn='left',$unit='',$disa=false,$rows='6');
    
    htm_Input($type='chck',$name='chck1',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',          $plho='?...',$wdth='',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list= [
        ['pos1','@private','@Details about private'],
        ['pos2','@proff','@Details about profession'],
        ['pos3','@private','@Details about private'],
        ['pos4','@hobby','@Details about hobby','checked'],
        ['pos5','@private','@Details about private'],
    ]);
    
    htm_Input($type='rado',$name='rado1',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio',                                         $plho='?...',$wdth='',$algn='left',$unit='',$disa=false,$rows='2',$step='',$attr='',$list= [
        ['post1','private','@private'],
        ['post2','proff','@profession'],
        ['post3','private','@private','checked'],
        ['post4','hobby','@hobby'],
        ['post5','private','@private'],
    ]);
    htm_Input($type='rang',$name='rang',$valu='10',$labl='@htm_Input(rang)',$hint='@Demo of htm_Input Field type range: 0..50 ',                                $plho='',    $wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr=' min="0" max="50"',$list=[],$llgn='R',$bord='',$echo=true,$form='',$ftop='24px');
    htm_Input($type='chck',$name='chcka',$valu='', $labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type checkbox in a row',                            $plho='?...',$wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='',$list= [
        ['postc','dark','@Dark (/Light)','checked'],
        ['postd','shiny','@Shiny (/Matt)'],
        ]);
    htm_Input($type='rado',$name='rado2',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio in a row',                                $plho='?...',$wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='',$list= [
        ['posta','happy','@Happy','checked'],
        ['postb','sorry','@Sorry'],
    ]);
    htm_Input($type='colr',$name='colr',$valu='#0000ff',$labl='@htm_Input(colr)',$hint='@Demo of htm_Input Field type color',                                   $plho='',  $wdth='100px',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
    htm_Input($type='butt',$name='butt',$valu='BUTTON',$labl='@htm_Input(butt)',$hint='@Demo of htm_Input Field type butt',                                     $plho='',  $wdth='',   $algn='center',$unit='',$disa=false,$rows='1',$step='',$attr='');
    htm_Input($type='sear',$name='sear',$valu='',$labl='<i class=\'fas fa-search\'></i> '.lang('@htm_Input(sear)'),$hint='@Demo of htm_Input Field type search', $plho='?',     $wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
    htm_Input($type='time',$name='time',$valu='',$labl='@htm_Input(time)',$hint='@Demo of htm_Input Field type time<br>NOT supported by all browsers',          $plho='',       $wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
    htm_Input($type='week',$name='week',$valu='',$labl='@htm_Input(week)',$hint='@Demo of htm_Input Field type week<br>NOT supported by all browsers',          $plho='',       $wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
    htm_Input($type='mont',$name='mont',$valu='',$labl='@htm_Input(mont)',$hint='@Demo of htm_Input Field type month<br>NOT supported by all browsers',         $plho='',       $wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
    htm_Input($type='file',$name='file',$valu='',$labl='@htm_Input(file)',$hint='@Demo of htm_Input Field type file',                                           $plho='',       $wdth='',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='',$list=[],$llgn='R',$bord='',$echo=true,$form='',$ftop='-8px');
    htm_Input($type='imag',$name='imag',$valu='',$labl='@htm_Input(imag)',$hint='@Demo of htm_Input Field type image',                                          $plho='',  $wdth='100px',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr='');
    if (USEGRID) echo '</div>'; // grid-container}
    htm_Panel_00();

    htm_Panel_0($frmName='', $capt='Example of htm_Table():', $parms='', $icon='fas fa-info', $class='panelW960', $func='Undefined', $attr='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
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
        $TblStyle= 'background-image: url(\'../_accessories/_background.png\');',
        $CalledFrom='',         // = __FUNCTION__
        $Criterion= ['','']     # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
    );
    htm_Panel_00();
    
    htm_nl(2);
    echo 'Examples of foldable panel-system:';  htm_nl(2);
    htm_Panel_0($frmName='head', $capt='htm_Panel_0(W= 560px) (click to close/open)', $parms='', $icon='fas fa-database', $class='panelW560', $func='Undefined', $attr='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: lightcyan;');
        // echo 'More examples of htm_Input():';   
        htm_nl(2);
        htm_TextDiv($content= 'Panels are used to display a collection of fields.<br>
              They are defined i 14 widths from 160 px to 1200 px and width 100%.<br><br>
              The panel content can be displayed/hidden by clicking panel-header text.');
        htm_nl(1);
        htm_Input($type='pass',$name='pass2',$valu='',$labl='@htm_Input(pass)',$hint='Demo of htm_Input Field type password with "hidden" output',  $plho='',           $width='45%',$algn='left',$unit='',$disa=false,$rows='3');
        htm_Input($type='mail',$name='mail1',$valu='',$labl='@htm_Input(mail)',$hint='Demo of htm_Input Field type mail with syntax control',       $plho='xxx@yyy.zzz',$width='45%; top: -35px',$algn='left',$unit='',$disa=false,$rows='3');
        htm_nl(2);
        htm_Input($type='chck',$name='chck2',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text', $plho='?...',$width='300px',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr='',$list= [
            ['name1','Label1','@Details about label','checked'],
            ['name1','Label2','@Details about label','checked']
        ]);
        htm_nl(2);
    htm_Panel_00( $labl='Demo', $subm=false, $Hint='Buttom', $btnKind='goon', $akey='', $simu=false, $frmName='');
    
    $GridOn= false;
    htm_nl(2);
    htm_Panel_0($frmName='head1', $capt='@Signup: <small>(Example)</small>', $parms='', $icon='fas fa-user-check', $class='panelW240', $func='Undefined', $attr='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: lightcyan;');
        //echo 'Example of login:'; htm_nl(2);
        htm_Input($type='text',$name='text1',$valu=$text1,$labl='@Financial Accounting',$hint='@The name of the accounting for wich you have access', $plho='@Account...', $wdth='75%',$algn='left',$unit='',$disa=false,$rows='3', $step='',$attr='');
        htm_Input($type='mail',$name='mail2',$valu=$mail2,$labl='@Your account', $hint='@Type your email as your accont',                             $plho='@Email...',   $wdth='75%',$algn='left',$unit='',$disa=false,$rows='3', $step='',$attr='');
        htm_Input($type='pass',$name='pass3',$valu=$pass3,$labl='@Your password',$hint='@Type your password for your account',                        $plho='@Password...',$wdth='70%',$algn='left',$unit='',$disa=false,$rows='3', $step='',$attr='');
                 // $usr_name= 'user';  $usr_code= 'Code: PW-test';     $h= calcHash($usr_name,$usr_code);
        htm_IconButt($type='button',$faicon='fas fa-key',$labl='@Forgotten password ?',$Hint='@Click to request a new password',$id='lost',$link='',$action='',$akey='',$size='14px',$fg='gray',$bg='white',$echo=true);
        htm_nl(0);
    htm_Panel_00( $labl='Login', $subm=true, $Hint='@Login with the given data', $btnKind='navi', $akey='l', $simu=false, $frmName='');
    
    htm_nl(2);
    htm_Panel_0($frmName='head2', $capt='@Contact info:', $parms='', $icon='fas fa-pen-square', $class='panelW240', $func='Undefined', $attr='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: lightcyan;');
        //echo 'Example of login:'; htm_nl(2);
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
        //echo '<span style="text-aling: center;">';
        htm_Input($type='text',$name='name',$valu=$namex ?? '',$labl='@Name', $hint='', $plho='@The name...', $wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        htm_Input($type='text',$name='stre',$valu=$stre,$labl='@Street',$hint='',       $plho='@Address 1...',$wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        htm_Input($type='text',$name='plac',$valu=$plac,$labl='@Place', $hint='',       $plho='@Address 2...',$wdth='66%', $algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        
        $GridOn= false; // Without grid the following fields can be placed on a single row.
//        htm_Input($type='opti',$name='opti',$valu='87654321',$labl='@htm_Input(opti)',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',$plho='',$wdth='',$algn='left',$unit=' %',$disa=false,$rows='3',$step='',$attr='',$plho='@?...',$list= [
//    ['name1','private','@Details about private'],
//    ['name2','proff','@Details about profession'],
//    ['name3','private','@Details about private','checked'],
//    ['name4','hobby','@Details about hobby'],
//    ['name5','private','@Details about private'],
//    ]);
        htm_Input($type='opti',$name='zipp',$valu=$zipp,$labl='@ZIP',   $hint='',       $plho='@Code...',     $wdth='30%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m,$list= [
                    ['5000','5000','5000'],
                    ['6000','6000','6000'],
                    ['6050','6050','6050','checked'],
                    ['6080','6080','6080'],
                    ['7000','7000','7000'],
                    ]);
        htm_Input($type='text',$name='city',$valu=$city,$labl='@City', $hint='',                                                        $plho='@Address town...',$wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        //if (USEGRID) $GridOn= true;
        //htm_Input(# $type='',$name='',$valu='',$labl='',$hint='',$plho='@?...',$wdth='',$algn='left',$unit='',$disa=false,$rows='2',$step='',$attr='',$list=[],$llgn='R',$bord='');
        htm_Input($type='text',$name='coun',$valu=$coun,$labl='@Country',  $hint='',                                                    $plho='@Country...',     $wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        htm_Input($type='area',$name='remk',$valu=$remk,$labl='@Remark',   $hint='@Demo of htm_Input Field type area: Multi-line text', $plho='@Remark?...',     $wdth='100%',$algn='left',$unit='',$disa=false,$rows='1',$step='',$attr=$m);
        htm_Input($type='text',$name='phon',$valu=$phon,$labl='@Phone',    $hint='',                                                    $plho='@Phone number...',$wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        htm_Input($type='text',$name='refe',$valu=$refe,$labl='@Reference',$hint='',                                                    $plho='@?...',           $wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        htm_Input($type='mail',$name='mail3',$valu=$mail3,$labl='@Email',  $hint='@Demo of htm_Input Field type mail',                  $plho='@Email address...',$wdth='100%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m);
        
        if (isset($_POST['namechck']))  { $namechck = 'checked'; }
        htm_Input($type='chck',$name='chck3',$valu=$chck3,$labl='@Mailing',  $hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',   $plho='@?...',$wdth='80%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$attr=$m,
        $list= [['namechck','@Mailing active','@Use mail',$namechck ?? '']]);
        
        $GridOn= false;
        htm_nl(1);
        htm_Input($type='date',$name='datr',$valu=$date, $labl='@Created',$hint='@Demo of htm_Input Field type date with browser popup selector',   $plho='',$wdth='46%; float: left',$algn='left',$unit='',$disa=false,$rows='3');
        htm_Input($type='date',$name='dath',$valu=$date, $labl='@Changed',$hint='@Demo of htm_Input Field type date with browser popup selector',   $plho='',$wdth='46%',$algn='left',$unit='',$disa=false,$rows='3');
        //if (USEGRID) $GridOn= true;
        
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$wdth='95%',$algn='center',$unit='',$disa=false,$rows='3');
        htm_nl(0);
        //echo '</span>';
    htm_Panel_00( $labl='Save', $subm=true, $capt='@Save data in this panel', $btnKind='save', $akey='s', $simu=false, $frmName='');
    
    echo '</div>'; // DEMO
    htm_nl(2);



    htm_nl(2);
    htm_Panel_0($frmName='head3', $capt='@User rights:', $parms='', $icon='fas fa-pen-square', $class='panelW800', $func='Undefined', $attr= '', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;',$closWidth='',$panlHint='@In this panel, you see a DEMO of the Multi-state button');

    $task= [['@Chart of Accounts',      '@Struktur for regnskabet'],
            ['@Account settings',       '@Angående regnskabet'],
            ['@Journal Entry ',         '@Daglige posteringer'],
            ['@Financial Accounting',   '@Bogførte posteringer'],
            ['@Financial reports',      '@Regnskabs posteringer'],
            ['@Debtor orders',          '@Kunde ordrer'],
            ['@Debtor accounts',        '@Kunde konti'],
            ['@Debtor reports',         '@Kunde oversigter'],
            ['@Creditor orders',        '@Leverandør ordrer'],
            ['@Creditor accounts',      '@Leverandør konti'],
            ['@Creditor reports',       '@Leverandør oversigter'],
            ['@Item stock',             '@Salgs produkter'],
            ['@Product reception',      '@Ankommende produkter'],
            ['@Product reception',      '@Produkt oversigter'],
            ['@Production orders',      '@Bestillinger'],
            ['@Program setting',        '@Setup af program og databaser'],
            ['@Data backup',            '@Sikkerheds kopiering af program og databaser'],
            ['@Security',               '@Administrer bruger rettigheder']
            ];

    $users = [
        ['adm','Administrator', ['3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3']],
        ['bok','Bookkeeper',    ['3','3','3','3','3','2','1','3','3','3','3','3','3','3','3','3','3','1']],
        ['aud','Auditor',       ['3','3','3','3','3','2','1','3','3','3','3','3','3','3','3','3','3','1']]
    ];

    $w= 0;
    foreach ($task as $t) $w= max($w,strlen($t[0]));
    echo '<span style="text-align:left;">';
    echo '<style> table, th, td { border: 0px solid lightgray; border-collapse: collapse;} 
        td span { writing-mode: vertical-lr; transform: rotate(180deg); height: '.($w*7.5).'px; }
        </style>';

    echo '<table style="margin: auto;"><tr style="padding:5px;">
    <td style="vertical-align: bottom;"><i>'.lang('@Name:').'</i></td> 
    <td style="vertical-align: bottom;"><i>'.lang('@Title:').'</i></td>';
    foreach ($task as $t) echo '<td><span style="padding:3px;" title="'.lang($t[1]).'">'.lang($t[0]).'</span></td>';
    echo '</tr>';
    
    foreach ($users as $usr) { $i= 0;
        echo '<tr style="height: 22px;"><td style="height: 22px;"><a href="">'.$usr[0].'</a></td><td>'.$usr[1].'</td>';
        foreach ($usr[2] as $a)   echo '<td style="height: 22px; width: 22px; text-align: center;">'.htm_MultistateButt($name='ROW'.$i.'COL'.$i++, $valu= $a).'</td>';
        echo '</tr>';
    }
    echo '<tr><td>&nbsp;</td></tr>';
    echo '
    <tr><td colspan="2" ><i>'.lang('@Create New:').'</i></td>';
    for ($i=0; $i<count($task); $i++) echo '<td style="height: 22px; width: 22px; text-align: center;">'. htm_MultistateButt($name='newROWyCOL'.$i, $valu=2) .'</td>';
    echo '<tr>
    <td><input type= "text" name="name1" value="" style="width: 50px; border: 1px solid var(--grayColor);" placeholder="name..." /></td>
    <td><input type= "text" name="titl1" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="titl..." /></td>
    <td colspan="9" ><i><small>Password:</small><input type= "text" name="pass1" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="pass..." /></i></td>
    <td colspan="9" ><i><small>Repeat:</small><input type= "text" name="pass2" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="pass..." /></i></td></tr>';
    echo '<tr><td>&nbsp;</td></tr>';
    echo '<tr style="border: 1px solid lightgray;">
    <td colspan="1"> &nbsp;<small>'.lang('@Meaning').'</small></td>
    <td colspan="2">'.htm_MultistateButt($name='dontCare', $valu=1, '', false).' <small>: '. lang('@No access').'</small></td>
    <td colspan="5">'.htm_MultistateButt($name='dontCare', $valu=2, '', false).' <small>: '. lang('@Read only').'</small></td>
    <td colspan="5">'.htm_MultistateButt($name='dontCare', $valu=3, '', false).' <small>: '. lang('@Full access').'</small></td>
    <td colspan="'.(count($task)-8).'" style="text-align:right;"><small>'.lang('@CLICK symbol to change').'</small>&nbsp;</td></tr>';
    echo '</table>';
    echo '</span>';
    htm_MiniNote('This is an example og using the multi-state button.');
    htm_nl(1);
    
    htm_Panel_00( $labl='Save', $subm=true, $capt='@Save data in this panel', $btnKind='save', $akey='s', $simu=false, $frmName='head3');

    htm_Panel_0($frmName='head4', $capt='@Popup menues:', $parms='', $icon='fas fa-pen-square', $class='panelW800', $func='Undefined', $attr= 'background-color: whitesmoke;'); 
        htm_TextDiv($content= 'You can build popup-menues width the PHP2HTML-system.<br>
              Both left-click and context right-click triggered.<br><br>
              Here you can test it:');
/* */   
        htm_ActionButt($label='@LeftClick Me', $id='left_click', $form='', $type='button', $onclick='', $icon='', $hint='@Try clicking me', $attr='', $echo=true);
        //echo '<smaller class="colrbrown" id="left_click">'. lang('@LeftClick Me'). ': </smaller> - ';
        Pmnu_0($id='left_click',$capt='Popup-Menu', $widt='200px', $icon='fas fa-info',$stick='false',$attr='background-color:lightcyan;',$context=false);
        Pmnu_Item($type='plain',$labl='@LABEL 1',$hint='@Hint 1',$icon='fas fa-info',$id='a',$click='',$attr='',$short='A');
        Pmnu_Item($type='plain',$labl='@LABEL 2',$hint='@Hint 2',$icon='fas fa-info',$id='b',$click='',$attr='',$short='B');
        Pmnu_Sepe();
        Pmnu_Item($type='custo',$labl='@CUST A',$hint='@Hint A',$icon='',$id='c',$click='',$attr='');
        Pmnu_00();
/* */
        htm_ActionButt($label='@RightClick Me', $id='right_click', $form='', $type='button', $onclick='', $icon='', $hint='@Try clicking me', $attr='', $echo=true);
        //echo '<smaller class="colrbrown" id="right_click">'. lang('@RightClick Me'). ': </smaller>';
        Pmnu_0($id='right_click',$capt='Context-Menu', $widt='220px',  $icon='fas fa-info',$stick='false',$attr='background-color:lightyellow;',$context=true);
        Pmnu_Item($type='plain',$labl='@Select All',$hint='@Mark to select',$icon='far fa-object-group colrbrown',$id='d',$click='alert(\"sss\");',$attr='',$short='CTRL+A');
        Pmnu_Item($type='plain',$labl='@Copy',$hint='@Copy selected to buffer',$icon='fas fa-copy colrgreen',$id='d1',$click='alert(\"sss\");',$attr='',$short='CTRL+C');
        Pmnu_Item($type='plain',$labl='@Paste',$hint='@Paste content in buffer',$icon='fas fa-paste colrblue',$id='d2',$click='alert(\"sss\");',$attr='',$short='CTRL+V');
        Pmnu_Sepe();
        Pmnu_Item($type='plain',$labl='@Delete',$hint='@Delete the selected',$icon='fas fa-trash-alt colrred',$id='e',$click=' ',$attr='',$short='DEL');
        Pmnu_Item($type='plain',$labl='@Cut',$hint='@Cut the selected and save to buffer',$icon='fas fa-cut colrblue',$id='d3',$click='alert(\"sss\");',$attr='',$short='CTRL+X');
        Pmnu_Item($type='plain',$labl='@Redo',$hint='@Redo the last delete',$icon='fas fa-redo colrblue',$id='d4',$click='alert(\"sss\");',$attr='',$short='CTRL+Y');
        Pmnu_Item($type='plain',$labl='@Undo',$hint='@Undo latest task',$icon='fas fa-undo colrblue',$id='d5',$click='alert(\"sss\");',$attr='',$short='CTRL+Z');
        Pmnu_Sepe($attr='background-color:lightyellow;');
        Pmnu_Item($type='submenu',$labl='@Sub Menu',$hint='@Go to submenu',$icon='fas fa-home colrgreen',$id='e2',$click='',$attr='',$short='');
        Pmnu_Item($type='footer',$labl='@Just a demo',$hint='@No functionality',$icon='fas fa-info colrgreen',$id='f',$click='',$attr='background-color:lightcyan;',$short='');
        // Pmnu_Item($type='plain',$labl='@Remove',$hint='@Hint 4',$icon='fas fa-minus colrred',$id='e',$click='',$attr='',$short='CTRL+V');
        
        /* 
                items: [
                    {label: 'Item 1', onClick: () => {console.log('Item 1 clicked')}, shortcut: 'Ctrl+A'},
                    {label: 'Item 2', onClick: () => {}, shortcut: 'Ctrl+B'},
                    {type: 'seperator'},
                    {label: 'Item 3', onClick: () => {}, shortcut: 'Ctrl+A'},
                    {type: 'hovermenu', label: 'Hover menu', items: [
                        {label: 'Subitem 1', onClick: () => {}},
                        {label: 'Subitem 2', onClick: () => {}},
                        {label: 'Subitem 3', onClick: () => {}},
                    ]},
                    
        echo 'items [';
        Pmnu_Subm($labl='@LABEL 4',$click='',$echo=true,$trail=',');
        Pmnu_Subm($labl='@LABEL 5',$click='',$echo=true,$trail=',');
        Pmnu_Subm($labl='@LABEL 6',$click='',$echo=true,$trail='');
        echo ' ],';
         */
        Pmnu_00();


        htm_nl(2);
    htm_Panel_00( $labl='', $subm=false, $capt='@...', $btnKind='save', $akey='s', $simu=false, $frmName='head4');
    
    htm_Panel_0($frmName='head5', $capt='@PHP8-specials:', $parms='', $icon='fas fa-pen-square', $class='panelW800', $func='Undefined', $attr= '');
    
    function b($s) {return '<b>'.$s.'</b>';}
    htm_TextDiv('
        A new way to give parameters to functions in PHP8+ is: <b>Named arguments</b><br>
        <small style="paddign-left:100px;">
        &nbsp; --> Specify only required parameters, skipping optional ones.<br>
        &nbsp; --> Arguments are order-independent and self-documented.<br><br>
        </small>
        That means a simpler way to call functions.<br><br>
        Example PHP7:<br><code><div style="background-color:whitesmoke">
        htm_Input($type=\'dec2\', $name=\'dec2\', $valu=$dec2, $labl=\'@htm_Input(Dec2)\',<br>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; $hint=\'@Demo of htm_Input Field type dec2: number with 2 decimal\', <br>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; $plho=\'\', $wdth=\'\', $algn=\'center\', $unit=\'<$ \');</div></code><br><br>
        Example PHP8:<br><code><div style="background-color:whitesmoke">
        htm_Input('.b('labl').':\'@htm_Input(Dec2)\', '.b('type').':\'dec2\', '.b('name').':\'dec2\', '.b('valu').':$dec2, '.b('unit').':\'<$ \',<br>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; '.b('hint').':\'@Demo of htm_Input Field type dec2: number with 2 decimal\');</div></code><br>
        <br>
        Be aware of PHP7.4 is a supported version until 2023/24 ! 
        ');
    htm_Panel_00( $labl='', $subm=false, $capt='@...', $btnKind='save', $akey='s', $simu=false, $frmName='head4');
    
    // echo 'A look at the translate system:';  scannLngStrings();
htm_Page_00();
    run_Script('toast("<b>'. lang('@You`re looking at a DEMO !'). '</b><br>'. lang('@It is a demonstration of the php2html-output.'). '","green","white")');
// phpinfo();
// var_dump(opcache_get_status()['jit']);
?>