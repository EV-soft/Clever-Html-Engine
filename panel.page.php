<?php   $DocFil= './Proj1/panel.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-12';     $DocIni='evs';  $ModulNr=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }

htm_PagePrep('panel.page.php');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center;">';
    echo 'Examples of foldable panel-system:';  htm_nl(2);
    htm_PanlHead($frmName='head', $capt='htm_PanlHead(W= 560px) (click to close/open)', $parms='', $icon='fas fa-database', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='../_base/page_Blindgyden.php',$panBg='background-image: url(\'_background.png\');');
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
    htm_PanlFoot( $labl='Demo', $subm=false, $title='Buttom', $buttonKind='', $akey='', $simu=false, $frmName='');
    
    $GridOn= false;
    htm_nl(2);
    htm_PanlHead($frmName='head1', $capt='@Signup: <small>(Example)</small>', $parms='', $icon='fas fa-user-check', $class='panelW240', $func='Undefined', $more='', 
                $BookMark='../_base/page_Blindgyden.php',$panBg='background-image: url(\'_background.png\');');
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
    htm_PanlFoot( $labl='Login', $subm=true, $title='@Login with the given data', $buttonKind='', $akey='l', $simu=false, $frmName='');
    
    htm_nl(2);
    htm_PanlHead($frmName='head2', $capt='@Contact info:', $parms='', $icon='fas fa-pen-square', $class='panelW240', $func='Undefined', $more='', 
                $BookMark='../_base/page_Blindgyden.php',$panBg='background-image: url(\'_background.png\');');
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
    htm_PanlFoot( $labl='Save', $subm=true, $title='@Save data in this panel', $buttonKind='', $akey='s', $simu=false, $frmName='');
    
    echo '</div>';
htm_PageFina();
?>