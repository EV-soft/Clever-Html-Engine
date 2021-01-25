<?php   $DocFil= './Proj1/translate.page.php';    $DocVer='1.0.0';    $DocRev='2021-01-25';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
// require_once ('menu.inc.php');
require_once ('translate.inc.php');
require_once ('filedata.inc.php');


htm_PagePrep($pageTitl='translate.page.php', $ØPageImage='_assets/images/_background.png');
    // Menu_Topdropdown(true); htm_nl(1);
    
    global $lang_list;
    // arrPrint($lang_list,'$lang_list');

    echo '<div style="text-align: center; background-image: url(\'_assets/images/_background.png\');">';
    
    htm_PanlHead($frmName='', $capt='@About translate system:', $parms='', $icon='fas fa-info', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    echo '<div style="text-align: left; margin: 20px;">
        All english textstrings that should be translated, can have prefix \'@ <br>
        in the source. It will be translated with function lang(\'English text\') <br><br>
        To create the table with strings to translate a function will scann all the
        source after prefix: <b>lang(\'</b>  .. and with suffix: <b>\')</b><br>
        Other prefix: <b>mess(\'</b>    (See more in file translate.inc.php)<br><br>
        Strings without these prefixes must have prefix: \'@ so it can be found.<br><br>
        All translated languages is defined in file: .sys_trans.json <br>
        If there are no translation, the english text will output with prefix @ removed
        <br><br>
        </div>';
    htm_PanlFoot();
    htm_nl(2);

    // $ISO639= ReadCSV($filepath='ISO639-1.csv');    // arrPrint($ISO639,'ISO639'); 
    global $lang_list, $App_Conf;
    foreach ($lang_list as $lng) {
        $SelList[]= [$lng["code"],$lng["code"].' : '.$lng["name"],$lng["native"].' - Author: '.$lng["author"].' - '.$lng["note"]];}
    if (isset($_POST['langu'])) {
        $App_Conf['language'] = $_POST['langu']; 
        $_SESSION['proglang'] =  $_POST['langu'];
    }
    if (isset($_POST['alllang'])) $alllang = $_POST['alllang']; else $alllang= '';

    htm_PanlHead($frmName='lang', $capt='@Select a language:', $parms='', $icon='fas fa-wrench', $class='panelW560', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    echo '<div style="text-align: center; margin: 20px;">';  
    echo lang('The actual language is').'<b> '.$App_Conf['language'].' / '.($_SESSION['currLang']['native'] ?? '') .' </b><br><br>';
    # $type='',$name='',$valu='',$labl='',$hint='',$plho='@Enter...',$wdth='',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='',$list=[],$llgn='R',$bord='',$proc=true);
    htm_Input($type='rado',$name='alllang',$valu=$alllang,$labl='@Filter',$hint='@Hide/show some (empty) languages in the language selector',$plho='Enter...',$wdth='110px',
              $algn='left',$unit='',$disa=true,$rows='2',$step='',$more='onclick="this.form.submit();"',$list= [
    ['All','All','@Show the complete list','checked'],
    ['Som','Some','@Hide all empty languages'],
    ],$llgn='');
    htm_Input($type='opti',$name='langu',$valu=$App_Conf['language'],$labl='@Select another language',$hint='@Select amongst installed languages',$plho='@Select...',$wdth='200px',
              $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list= $SelList);
    echo '</div>';
    htm_PanlFoot($labl='Activate selected', $subm=true, $title='@Change language to the selected', $btnKind='save', $akey='', $simu=false, $frmName='lang');
    htm_nl(2);

    
    htm_PanlHead($frmName='', $capt='Translate language strings:', $parms='', $icon='fas fa-tools', $class='panelW960', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;', $closWidth='560px');
    echo '<div style="text-align: left; margin: 20px;">';            
    scannLngStrings($code= substr($App_Conf['language'],0,2));
    echo '</div>';
    htm_PanlFoot();
    htm_nl(2);

    echo '</div>';
    
    PanelOff($First=1,$Last=3);
    PanelOn($noFrom=2);
htm_PageFina();
?>