<?php   $DocFil= './Proj1/panel.page.php';    $DocVer='1.0.0';    $DocRev='2020-06-14';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

### DATA-INIT/UPDATE:
## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }    // Special case !

### PAGE-START:
htm_PagePrep($pageTitl='panel.page.php', $ØPageImage='_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);
    echo 'About the foldable panel-system:';  htm_nl(2);
    
    htm_RowColTop($RowColWdth=1100);
    htm_PanlHead($frmName='head', $capt='htm_PanlHead(W= 560px) (click to close/open)', $parms='', $icon='fas fa-info', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php');
        htm_nl(1);
        htm_TextDiv('Panels are used to display a collection of HTML-objects <br>
              possibly with a common form and submit button.<br>
              They are defined i 14 widths from 160 px to 1200 px.<br><br>
              The panel content can be displayed/hidden by clicking panel-header.','center');
        htm_nl(2);
    htm_PanlFoot( $labl='Demo', $subm=false, $title='Buttom', $buttonKind='save', $akey='', $simu=false, $frmName='');
    htm_RowColBott();
    
    htm_RowColTop($RowColWdth=280);
    $GridOn= false;
    
    htm_PanlHead($frmName='head1', $capt='@Signup: <small>(Example)</small>', $parms='', $icon='fas fa-user-check', $class='panelW280', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php');
        htm_Input($type='text',$name='text1',$valu=$text1,$labl='@Financial Accounting',$llgn='',$hint='@The name of the accounting for wich you have access',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='75%',$step='',$more='',$plho='@Account...');
        htm_Input($type='mail',$name='mail2',$valu=$mail2,$labl='@Your account',$llgn='',$hint='@Type your email as your accont',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='75%',$step='',$more='',$plho='@Email...');
        htm_Input($type='pass',$name='pass3',$valu=$pass3,$labl='@Your password',$llgn='',$hint='@Type your password for your account',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='75%',$step='',$more='',$plho='@Password...');
        $usr_name= 'user';  $usr_code= 'Code: PW-test';     $h= calcHash($usr_name,$usr_code);
        //htm_Input($type='html',$name='text',$valu=$h,$labl='Hash:',$llgn='',$hint='@Demo of htm_Input Field type html',$algn='left',$unit='',$disa=false,$rows='2',$width='95%',$step='',$more='',$plho='@Account...');
        echo '<br><br><a href="'.$link.'" accesskey="'.$akey.'"> '. Lbl_Tip('@Forgotten password ?','@Click to request a new password'). '</a>';
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$llgn='',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
    htm_PanlFoot( $labl='Login', $subm=true, $title='@Login with the given data', $buttonKind='save', $akey='l', $simu=false, $frmName='');
    htm_RowColNext($RowColWdth=280);
    
    htm_PanlHead($frmName='head2', $capt='@Contact info: <small>(Example)</small>', $parms='', $icon='fas fa-pen-square', $class='panelW280', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php');
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
        //echo '<span style="text-aling: center;">';
        htm_Input($type='text',$name='name',$valu=$namex,$labl='@Name',$llgn='', $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@The name...');
        htm_Input($type='text',$name='stre',$valu=$stre,$labl='@Street',$llgn='',   $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Address 1...');
        htm_Input($type='text',$name='plac',$valu=$plac,$labl='@Place',$llgn='',    $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Address 2...');
        
        $GridOn= false; // Without grid the following fields can be placed on a single row.
        htm_Input($type='opti',$name='zipp',$valu=$zipp,$labl='@ZIP',$llgn='',      $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='31%',$step='',$more=$m,$plho='@Code...',$list= [
                    ['5000','5000','@5000'],
                    ['6000','6000','@6000'],
                    ['6050','6050','@6050','checked'],
                    ['6080','6080','@6080'],
                    ['7000','7000','@7000'],
                  ]);
        htm_Input($type='text',$name='city',$valu=$city,$labl='@City',$llgn='', $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='68%',$step='',$more=$m,$plho='@Address town...');
        
        htm_Input($type='text',$name='coun',$valu=$coun,$labl='@Country',$llgn='',  $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Country...');
        htm_Input($type='area',$name='remk',$valu=$remk,$labl='@Remark',$llgn='',   $hint='@Demo of htm_Input Field type area: Multi-line text',
                  $algn='left',$unit='',$disa=false,$rows='1',$width=$wdh,$step='',$more=$m,$plho='@Remark?...');
        htm_Input($type='text',$name='phon',$valu=$phon,$labl='@Phone',$llgn='',    $hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Phone number...');
        htm_Input($type='text',$name='refe',$valu=$refe,$labl='@Reference',$llgn='',$hint='',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@?...');
        htm_Input($type='mail',$name='mail3',$valu=$mail3,$labl='@Email',$llgn='',   $hint='@Demo of htm_Input Field type mail',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='@Email address...');
        
        if (isset($_POST['namechck']))  { $namechck = 'checked'; }        
        htm_Input($type='chck',$name='chck3',$valu=$chck3,$labl='@Mailing',$llgn='', $hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',
                  $algn='left',$unit='',$disa=false,$rows='3',$width=$wdh,$step='',$more=$m,$plho='Enter...',
        $list= [['namechck','@Mailing active','@Use mail',$namechck]]);
        
        $GridOn= false;
        htm_nl(1);
        htm_Input($type='date',$name='datr',$valu=$datr, $labl='@Created',$llgn='',$hint='@Demo of htm_Input Field type date with browser popup selector',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='50%');
        htm_Input($type='date',$name='dath',$valu=$dath, $labl='@Changed',$llgn='',$hint='@Demo of htm_Input Field type date with browser popup selector',
                  $algn='left',$unit='',$disa=false,$rows='3',$width='50%');
        
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$llgn='',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
        //echo '</span>';
    htm_PanlFoot( $labl='Save', $subm=true, $title='@Save data in this panel', $buttonKind='save', $akey='s', $simu=false, $frmName='');
    
    htm_RowColNext($RowColWdth=480);
    htm_PanlHead($frmName='', $capt='How creating panels:', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    htm_TextDiv('To build a panel there are 2 functions: <br><br>
        <b>htm_PanlHead()</b> - prepares the start of a panel.<br>
        and: <br>
        <b>htm_PanlFoot()</b> - finalize the panel.     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>
        ');
    htm_PanlFoot();
    htm_RowColBott();
    
    PanelOff($First=2,$Last=3); // Close panel 2 and 3 on page open
htm_PageFina();
### :PAGE_END
?>