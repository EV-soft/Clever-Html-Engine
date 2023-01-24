<?php   $DocFile= './Proj.demo/tinyEditor.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-22';      $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [1, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/']);               // jquery.min.js
define('LIB_JQUERYUI',      [1, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);      
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);      
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
define('LIB_TINYMCE',       [1, '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/']);              // tinymce.min.js
define('LIB_SWITCHBOX',     [0, '_assets/',  '']);  // Not in use       
define('LIB_POPUPSYSTEM',   [0, '_assets/',  '']);  // Not in use       
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN 


htm_Page_0( titl:'HTML-editor - Introduction to the tiny Editor:',  hint:$©,  info:'File: '.$DocFile.' - Ver:'.$DocVer,  inis:'', algn:'center',  gbl_Imag:'../_accessories/_background.png', gbl_Bord:false);
    Menu_Topdropdown(true); htm_nl(1);

    htm_Panel_0( capt: '@Working with tiny Editor:', icon: 'fas fa-info', hint: '@HINT for this panel', form: 'head6', acti: '', clas: 'panelWmax', wdth: '640', styl: 'background-color: white;', attr: '',  show : true,  head: $headbg);
        if (LIB_TINYMCE[0] > 0) /* Config editor: */ echo 
            " <script type=\"text/javascript\">
              tinymce.init({
                selector: '#TinyTextarea',
                language: 'en',
                /* width: 800, */
                /* height: 300, */
                promotion: false,
                plugins: [
                  'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                  'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                  'media', 'table', 'emoticons', 'template', 'help', 'save', 'visualchars'
                ],
                toolbar: 'save | undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                  'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                  'forecolor backcolor emoticons | help save visualchars',
                menu: {
                  favs: { title: 'My Favorites', items: 'code | visualaid | searchreplace | emoticons' }
                },
                menubar: 'favs file edit view insert format tools table help',
                content_css: 'writer' /* 'css/content.css' */
              });
              </script>";
        $docFile= 'EditContent.htm';
        if (isset($_POST['TinyTextarea'])) { # Save content:
            file_put_contents($docFile, $_POST['TinyTextarea']);
        }
        $docContent= /* iconv('ISO-8859-1', "UTF-8",  */ file_get_contents($docFile) /* ) */ ; # Load content
        // echo '<textarea id="TinyTextarea" name="TinyTextarea" rows="60" cols="120" style="white-space: nowrap;">'.$docContent.'</textarea>';
        htm_Input(labl:'This is the editor',plho:'@Enter your text here...',icon:'',hint:'Based on open source: tinyMCE',type: 'area',
                  name:'TinyTextarea' /* Name must match selector in tinymce.init() */,valu:$docContent,form:'',wdth:'',algn:'left',
                  attr:'', rtrn:false,unit:'',disa:false, rows:'60', step:'',list:[],llgn:'R',bord:'',ftop:'');
                  htm_textdiv('<b>Info:</b> This demo loads/saves data from file: EditContent.htm');
    htm_Panel_00( labl:'GEM', icon:'', hint:'', name:'', form:'head6',subm:false,  attr:'', akey:'s', kind:'save', simu:false);
    

    // PanelOff($First=3,$Last=9);

htm_Page_00();

?>