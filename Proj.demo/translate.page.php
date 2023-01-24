<?php   $DocFil= './Proj.demo/translate.page.php';    $DocVer='1.2.2';    $DocRev='2022-12-28';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [2, '_assetsjquery/latest/',            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);               // jquery.min.js
define('LIB_JQUERYUI',      [2, '_assetsjquery-ui/latest/',         'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [2, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN 

if (!isset($_SESSION['currLang'])) {
    $_SESSION['currLang']= 'en';
    $_SESSION['native']= 'English';
}
         # $titl='',$hint='',$info='',$inis='',$algn='center', $gbl_Imag='',$gbl_Bord=true) 
htm_Page_0( titl:'translate.page.php', hint:'@Maintenance of project translation', info:'', inis:'', algn:'center',  gbl_Imag:$gbl_ProgRoot.'_accessories/_background.png', gbl_Bord:true);
    Menu_Topdropdown(true); 
    // htm_nl(1); 
    
    global $arrLang;
    // arrPrint($arrLang,'$arrLang');

    htm_Caption( labl:'@Maintenance of project translation', icon:'', hint:'', algn:'center', styl:'color:'.$gbl_TitleColr.'; font-weight:600; font-size: 18px;');
    htm_nl(1);
    // htm_TextDiv('@Maintenance of project translation','center');
              # $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'panelWmax',$wdth= '',$styl= 'background-color: white;',$attr= ''
    htm_Panel_0( capt:'@About translate system:',  icon:'fas fa-info',  hint: '', form: '', acti: '', clas:'panelW560',  wdth: '', styl: 'background-color: white;', attr: '');
    echo '<div style="text-align: left; margin: 20px;">
        All english textstrings that should be translated, can have prefix \'@ 
        in the source. <br>It will be translated with function lang(\'English text\') <br><br>
        To create the table with strings to translate a function will scann all the
        source after prefix: <b>lang(\'</b>  .. and with suffix: <b>\')</b><br>
        Other prefix: <b>mess(\'</b>    (See more in file translate.inc.php)<br><br>
        Strings without these prefixes must have prefix: \'@ so it can be found.<br><br>
        All translated languages is defined in file: _trans.sys.json <br>
        If there are no translation, the english text will output with prefix @ removed
        <br><br>
        </div>';
    htm_Panel_00();
    htm_nl(2);

    // $ISO639= ReadCSV($filepath='ISO639-1.csv');    // arrPrint($ISO639,'ISO639'); 
    global $arrLang, $alllang, $App_Conf;
    foreach ($arrLang as $lng) {
        $SelList[]= [$lng["code"],$lng["code"].' : '.$lng["name"],$lng["native"].' - Author: '.$lng["author"].' - '.$lng["note"]];}
    if (isset($_POST['langu'])) {
        $App_Conf['language'] = $_POST['langu']; 
        $_SESSION['proglang'] = $_POST['langu'];
    }

              # $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'panelWmax',$wdth= '',$styl= 'background-color: white;',$attr= ''
    htm_Panel_0( capt:'@Select a language:',  icon:'fas fa-wrench', hint: '', form: 'lang', acti: '', clas:'panelW560', wdth: '', styl: 'background-color: white;', attr: '');
    echo '<div style="text-align: center; margin: 20px;">';  
    echo lang('The actual language is').'<b> '.$App_Conf['language'].' / '/* .$_SESSION['currLang']['native'] */.' </b><br><br>';
# PHP7: $labl='',$plho='@Enter...',$icon='',$hint='',$type= 'text',$name='',$valu='',$form='',$wdth='',$algn='left',$attr='',$proc=true,$unit='',$disa=false,$rows='2',$step='',$list=[],$llgn='R',$bord='',$ftop='');
    htm_Input( labl:'@Filter', plho:'Enter...', icon:'', hint:'@Hide/show some (empty) languages in the language selector',
               type:'rado', name:'alllang', valu:$alllang, form:'', wdth:'110px', algn:'left', attr:'onclick="this.form.submit();"', rtrn:false, unit:'', disa:true, rows:'2', step:'',
               list: [
                 ['All','All','@Show the complete list','checked'],
                 ['Som','Some','@Hide all empty languages'],
              ]);
    htm_Input( labl:'@Select another language', plho:'@Sel...', icon:'', hint:'@Select amongst installed languages',
               type:'opti', name:'langu', valu:'dsads', form:'', wdth:'200px', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'', list: $SelList);
    echo '</div>';
    htm_Panel_00( labl:'@Activate selected', icon:'',  hint:'@Change language to the selected',  name:'',  form:'lang', subm:true,  attr:'',  akey:'',  kind:'save', simu:false);
    htm_nl(2);

    
              # $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'panelWmax',$wdth= '',$styl= 'background-color: white;',$attr= ''
    htm_Panel_0( capt:'@Translating language strings:', icon:'fas fa-tools', hint: '', form: '', acti: '', clas:'panelW960', wdth: '', styl: 'background-color: white;', attr: '');
    echo '<div style="text-align: left; margin: 20px;">';            
    scannLngStrings($code= substr($App_Conf['language'],0,2));
    echo '</div>';
    htm_Panel_00();
    htm_nl(2);
  
htm_Page_00();
?>