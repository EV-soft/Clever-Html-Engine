<?php   $DocFile= './Proj.demo/tinyEditor.page.php';    $DocVer='1.3.1';    $DocRev='2023-09-02';      $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');

## Activate needed libraries:
//      ConstName:          ix:      LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [$LibIx, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);               // jquery.min.js
define('LIB_JQUERYUI',      [$LibIx, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [$LibIx, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_FONTAWESOME',   [$LibIx, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/']);
define('LIB_TINYMCE',       [$LibIx, '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/']);              // tinymce.min.js
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN 


htm_Page_0(titl:'HTML-editor - Introduction to the tiny Editor:', hint:$©, info:'File: '.$DocFile.' - Ver:'.$DocVer, inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:false);
    // Menu_Topdropdown(true);     // htm_nl(1);
    echo '<style> body { padding-top: 0; margin-top:0; } </style>';
    
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;');
    htm_nl(3);

    htm_Card_0(capt: '@Working with tiny Editor:', icon: 'fas fa-info', hint: '@HINT for this card', form: 'head6', acti: '', clas: 'cardWmax', wdth: '640', styl: 'background-color: white;', attr: '',  show : true,  head: $headbg, vhgh:'1200px');
        if (LIB_TINYMCE[0] > 0) # Config editor: https://www.tiny.cloud/docs/tinymce/6/basic-setup/ 
        echo 
            " <script type=\"text/javascript\">
              tinymce.init({
                selector: '#TinyTextarea',
                language: 'en',
                skin: 'oxide-dark',
                content_css: 'dark',
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
        if (isset($_POST['TinyTextarea'])) {                                                    # Save content:
            file_put_contents($docFile, $_POST['TinyTextarea']);
        }
        $docContent= /* iconv('ISO-8859-1', "UTF-8",  */ file_get_contents($docFile) /* ) */ ;  # Load content
        htm_Input(labl:'This is the editor', plho:'@Enter your text here...', icon:'', hint:'Based on open source: tinyMCE',vrnt: 'area',
                  name:'TinyTextarea' /* Name must match selector in tinymce.init() */, valu:$docContent, form:'', wdth:'', algn:'left',
                  attr:'', rtrn:false, unit:'', disa:false, rows:'60', step:'' ,list:[], llgn:'R', bord:'', ftop:'');
        
        htm_textdiv('<b>Info:</b> This demo loads/saves data from file: '.$docFile.' '.str_sp('8').
            htm_Input(labl:'Upload file', plho:'@Enter your filename here...',icon:'',hint:'@Upload file to '.$docFile.'<br>Not working yet !',vrnt: 'file',
                      name:'ufile' , valu:'', form:'', wdth:'220px', algn:'left',
                      attr:'', rtrn:true, unit:'', disa:false, rows:'', step:'', list:[], llgn:'R', bord:'',ftop:''). str_sp('4').
            htm_Input(labl:'Download file', plho:'@Enter your filename here...', icon:'', hint:'@Download '.$docFile.' to a local file<br>Not working yet !',vrnt: 'butt',
                      name:'dfile', valu:'Download...', form:'', wdth:'120px', algn:'left',
                      attr:'background-color:green;', rtrn:true, unit:'', disa:false, rows:'', step:'', list:[], llgn:'R', bord:'', ftop:''). str_sp('12'). str_nl(2).
            htm_textdiv('Alternative you can copy/paste from/to content in Source Code window.', styl:'white-space: nowrap;', rtrn:true)
            ,attr:'margin: auto; display:inline-block; position: relative;');

        
    htm_Card_00(labl:'GEM', icon:'', hint:'', name:'', form:'head6', subm:false,  attr:'', akey:'s', kind:'save', simu:false);
    
htm_Page_00();
?>