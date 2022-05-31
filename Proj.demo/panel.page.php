<?php   $DocFile= './Proj.demo/panel.page.php';    $DocVer='1.2.0';    $DocRev='2022-03-04';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                 CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',          'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [0, '_assets/',  '']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


### DATA-INIT/UPDATE:
## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }    // Special case !

### PAGE-START:
htm_Page_0($titl='panel.page.php',$hint=$©,$info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=false);
    Menu_Topdropdown(true); htm_nl(1);
    echo 'About the foldable panel-system:';  htm_nl(2);
    
    htm_RowCol_0($RowColWdth=1100);
    htm_Panel_0($capt= 'htm_Panel_0(W= 560px) (click to close/open)',$icon= 'fas fa-info',$hint= '',$form= 'head',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
        htm_nl(1);
        htm_TextDiv('Panels are used to display a collection of HTML-objects <br>
              possibly with a common form and submit button.<br>
              They are defined i 14 widths from 160px to 1200px.<br><br>
              The panel content can be displayed/hidden by clicking panel-header.','center');
        htm_nl(2);
    htm_Panel_00( $labl='Demo', $subm=false, $title='Buttom', $buttonKind='save', $akey='', $simu=false, $frmName='');
    htm_RowCol_00();
    
    htm_RowCol_0($RowColWdth=280);
    $GridOn= false;
    
    htm_Panel_0($capt= '@Signup: <small>(Example)</small>',$icon= 'fas fa-user-check',$hint= '',$form= 'head1',$acti= '',$clas= 'panelW280',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
    htm_Input($labl='@Financial Accounting',$plho='@Account...',$icon='',$hint='@The name of the accounting for wich you have access',
              $type='text',$name='text1',$valu=$text1, $form='',$wdth='75%',$algn='left',$attr='',$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='', $list=[],$llgn='R',$bord='',$ftop='');
    htm_Input($labl='@Your account',$plho='@Email...', $icon='',$hint='@Type your uniq code (maybe email) as your accont',
              $type='mail',$name='mail2',$valu=$mail2, $form='',$wdth='75%',$algn='left',$attr='',$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='', $list=[],$llgn='R',$bord='',$ftop='');
    htm_Input($labl='@Your password',$plho='@Password...',$icon='',$hint='@Type the password for your account',
              $type='pass',$name='pass3',$valu=$pass3, $form='',$wdth='75%',$algn='left',$attr='',$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='', $list=[],$llgn='R',$bord='',$ftop='');

        /* htm_Input($type='text',$name='text1',$valu=$text1,$labl='@Financial Accounting',$hint='@The name of the accounting for wich you have access',
                  $plho='@Account...',$width='75%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more=''); */
        /* htm_Input($type='mail',$name='mail2',$valu=$mail2,$labl='@Your account',$hint='@Type your email as your accont',
                  $plho='@Email...',$width='75%',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more=''); */
        /* htm_Input($type='pass',$name='pass3',$valu=$pass3,$labl='@Your password',$hint='@Type your password for your account',
                  $plho='@Password...',$algn='left',$unit='',$disa=false,$rows='3',$step='',$more=''); */
        $usr_name= 'user';  
        $usr_code= 'Code: PW-test';     
        $h= calcHash($usr_name,$usr_code);
        //htm_Input($type='html',$name='text',$valu=$h,$labl='Hash:',$hint='@Demo of htm_Input Field type html',$algn='left',$unit='',$disa=false,$rows='2',$width='95%',$step='',$more='',$plho='@Account...');
        echo '<br><br><a href="'.($link ?? '').'" accesskey="'.$akey.'"> '. Lbl_Tip('@Forgotten password ?','@Click to request a new password'). '</a>';
        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
    htm_Panel_00($labl='@Login', $icon='fas fa-key', $hint='@Login with the given data', $name='', $form='',$subm=true, $attr='', $akey='l', $kind='save', $simu=false);
    htm_RowCol_next($RowColWdth=280);
    
    htm_Panel_0($capt= '@Contact info: <small>(Example)</small>',$icon= 'fas fa-pen-square',$hint= '',$form= 'head2',$acti= '',$clas= 'panelW280',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
    //echo '<span style="text-aling: center;">';
    htm_Input($labl='@Name',$plho='@The name...',$icon='',$hint='',
              $type='text',$name='name',$valu=$namex?? '',$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Street',$plho='@Address...',$icon='',$hint='',
              $type='text',$name='stre',$valu=$stre,$form='',$wdth=$wdh,$algn='left',$attr='',$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Your password',$plho='@Password...',$icon='',$hint='@Type your password for your account',
              $type='text',$name='pass4',$valu=$pass3,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');
        
    $GridOn= false; // Without grid the following fields can be placed on a single row.
    htm_Input($labl='@ZIP',$plho='@Code...',$icon='',$hint='',
              $type='opti',$name='zipp',$valu=$zipp,$form='',$wdth='31%',$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[
                    ['5000','5000','@5000'],
                    ['6000','6000','@6000'],
                    ['6050','6050','@6050','checked'],
                    ['6080','6080','@6080'],
                    ['7000','7000','@7000']
              ],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@City',$plho='@Address town...',$icon='',$hint='',
              $type='text',$name='city',$valu=$city,$form='',$wdth='68%',$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Country',$plho='@Country...',$icon='',$hint='',
              $type='text',$name='coun',$valu=$coun,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Remark',$plho='@Remark...',$icon='',$hint='@Demo of htm_Input Field type area: Multi-line text',
              $type='area',$name='remk',$valu=$remk,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='1',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Phone',$plho='@Phone...',$icon='',$hint='',
              $type='text',$name='city1',$valu=$city,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Reference',$plho='@?...',$icon='',$hint='',
              $type='text',$name='refe',$valu=$refe,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Email',$plho='@Email address...',$icon='',$hint='@Demo of htm_Input Field type mail',
              $type='mail',$name='mail3',$valu=$mail3,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    if (isset($_POST['namechck']))  { $namechck = 'checked'; }        
    htm_Input($labl='@Mailing',$plho='@Enter...',$icon='',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',
              $type='chck',$name='chck3',$valu=$chck3,$form='',$wdth=$wdh,$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[['namechck','@Mailing active','@Use mail',$namechck ?? '']],$llgn='R',$bord='',$ftop='');

    $GridOn= false;
    htm_nl(1);
    htm_Input($labl='@Created',$plho='@Address town...',$icon='',$hint='@Demo of htm_Input Field type date with browser popup selector',
              $type='date',$name='datr',$valu=$date ?? '',$form='',$wdth='50%',$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@Changed',$plho='',$icon='',$hint='@Demo of htm_Input Field type date with browser popup selector',
              $type='date',$name='dath',$valu=$date ?? '',$form='',$wdth='50%',$algn='left',$attr=$m,$rtrn=false,
              $unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='');

        // htm_Input($type='intg',$name='intg',$valu='87654321',$labl='htm_Input(Intg)',$hint='Demo of htm_Input Field type intg: centered integer',$algn='center',$unit='',$disa=false,$rows='3',$width='95%');
    //echo '</span>';
    htm_Panel_00( $labl='Save', $subm=true, $title='@Save data in this panel', $buttonKind='save', $akey='s', $simu=false, $frmName='xxx');
    

    htm_RowCol_next($RowColWdth=480);
    htm_Panel_0($capt= '@How creating panels:',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
    htm_TextDiv('To build a panel there are 2 functions: <br><br>
        <b>htm_Panel_0()</b> - prepares the start of a panel.<br>
        and: <br>
        <b>htm_Panel_00()</b> - finalize the panel.     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>
        ');
        htm_Panel_0($capt= '@PHP Source-code:',$icon= 'fas fa-code',$hint= '',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );

str_Pars( <<< 'STRING'
htm_Panel_0($ViewHeight='60px'); // htm_Panel_0() must be followed by htm_Panel_00() !
STRING
);
echo 'htm_TextDiv(\'To build a panel there are 2 functions: <br><br>
        <b>htm_Panel_0()</b> - prepares the start of a panel.<br>
        and: <br>
        <b>htm_Panel_00()</b> - finalize the panel.     <br><br>
        In between, you add your content.             <br><br>
        <small>See the source in php2html.lib.php to manage the function parameters.</small>
        \');';
str_Pars( <<< 'STRING'
htm_Panel_00();
STRING
); 
    htm_Panel_00();
    htm_Panel_00();
    htm_RowCol_00();
    
    PanelOff($First=2,$Last=3); // Close panel 2 and 3 on page open
htm_Page_00();
### :PAGE_END
    PanelOff($First=5,$Last=5);

?>