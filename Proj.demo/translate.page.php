<?php   $DocFil= './Proj.demo/translate.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');
require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php');

if (!isset($_SESSION['currLang'])) {
    $_SESSION['currLang']= 'en';
    $_SESSION['native']= 'English';
}

htm_Page_( titl:'translate.page.php', hint:'@Maintenance of project translation', info:'', inis:'', algn:'center',  imag:$gbl_ProgRoot.'_accessories/_background.png', pbrd:true);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);

    global $arrLang;

    htm_Caption( labl:'@Maintenance of project translation', icon:'', hint:'', algn:'center', styl:'color:'.$gbl_TitleColr.'; font-weight:600; font-size: 18px;');
    htm_nl(1);
    // htm_TextDiv('@Maintenance of project translation','center');
    htm_Card_( capt:'@About translate system:',  icon:'fas fa-info',  hint: '', form: '', acti: '', clas:'cardW560',  wdth: '', styl: 'background-color: white;', attr: '');
    echo '<div style="text-align: left; margin: 20px;">
        All english textstrings to be translated, should have prefix \'@ 
        in the source. <br>It will be translated with function lang(\'English text\') <br>
        You will have to setup source-files for your project in file: translate.inc.php (inside function scannfor())<br><br>
        To create the table with strings to translate a function will scann all the
        source after prefix: <b>lang(\'</b>  .. and with suffix: <b>\')</b><br>
        Other prefix: <b>mess(\'</b>    (See more in file translate.inc.php)<br><br>
        Strings without these prefixes must have prefix: \'@ so it can be found.<br><br>
        All translated languages is defined in file: _trans.sys.json <br>
        If there are no translation, the english text will output with prefix @ removed
        <br><br>
        </div>';
    htm_Card_end();
    htm_nl(2);

    global $arrLang, $alllang, $App_Conf;
    foreach ($arrLang as $lng) {
        $SelList[]= [$lng["code"],$lng["code"].' : '.$lng["name"],$lng["native"].' - Author: '.$lng["author"].' - '.$lng["note"]];}
    if (isset($_POST['langu'])) {
        $App_Conf['language'] = $_POST['langu']; 
        $_SESSION['proglang'] = $_POST['langu'];
    }

    htm_Card_( capt:'@Select a language:',  icon:'fas fa-wrench', hint: '', form: 'lang', acti: '', clas:'cardW560', wdth: '', styl: 'background-color: white;', attr: '');
    echo '<div style="text-align: center; margin: 20px;">';  
    echo lang('The actual language is').'<b> '.$App_Conf['language'].' / '/* .$_SESSION['currLang']['native'] */.' </b><br><br>';
    htm_Input( labl:'@Filter', plho:'Enter...', icon:'', hint:'@Hide/show some (empty) languages in the language selector',
               vrnt:'rado', name:'alllang', valu:$alllang, form:'', wdth:'110px', algn:'left', attr:'onclick="this.form.submit();"', rtrn:false, unit:'', disa:true, rows:'2', step:'',
               list: [
                 ['All','All','@Show the complete list','checked'],
                 ['Som','Some','@Hide all empty languages'],
              ]);   
    htm_Input( labl:'@Select another language', plho:'@Sel...', icon:'', hint:'@Select amongst installed languages',
               vrnt:'opti', name:'langu', valu:'dsads', form:'', wdth:'200px', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'3', step:'', list: $SelList);
    echo '</div>';
    htm_Card_end( labl:'@Activate selected', icon:'',  hint:'@Change language to the selected',  name:'',  form:'lang', subm:true,  attr:'',  akey:'',  kind:'save', simu:false);
    htm_nl(2);

    htm_Card_( capt:'@Translating language strings:', icon:'fas fa-tools', hint: '', form: '', acti: '', clas:'cardW960', wdth: '', styl: 'background-color: white;', attr: '');
    htm_TextDiv('Analysing translatibly text in the project:');
    echo '<div style="text-align: left; margin: 20px;">';            
    scannLngStrings($code= substr($App_Conf['language'],0,2));
    echo '</div>';
    htm_Card_end();
    htm_nl(2);
htm_Page_end();

?>
