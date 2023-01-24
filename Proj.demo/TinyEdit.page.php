<?php   $DocFile='../Proj.demo/TinyEdit.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-18';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
$lateScripts= '';   // $jsScripts= '';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');
 
## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
/* 
define('LIB_JQUERY',        [0, '_assets/jquery/',                  'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [0, '_assets/tablesorter/js/',          'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);  // Not in use           
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);  // Not in use       
 */
define('LIB_FONTAWESOME',   [2, '_assets/font-awesome6/6.1.1/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/']);
define('LIB_TINYMCE',       [2, '_assets/tinymce/6/',               'https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js']);
// Set ix= 0:deactive  1:Local-source  2:WEB-source-CDN


htm_Page_0( $titl='DEMO', $hint=$©, $info='File: '.$DocFile.' - ver:'.$DocVer, $inis='',$algn='center', $gbl_Imag= $bodybg,$gbl_Bord=true);
    echo '<div style="text-align: center;"><br><b>Html-editor</b> ';  htm_nl(2);
  
    if (LIB_TINYMCE[0] > 0) echo 
        " <script type=\"text/javascript\">
          tinymce.init({
            selector: '#TinyTextarea',
            language: 'da',
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
              'forecolor backcolor emoticons | help visualchars',
            menu: {
              favs: { title: 'My Favorites', items: 'code | visualaid | searchreplace | emoticons' }
            },
            menubar: 'favs file edit view insert format tools table help',
            /* content_css: 'css/content.css' */
          });
          </script>";
    
    if (isset($_POST['TinyTextarea'])) { 
        $DataTextarea= $_POST['TinyTextarea']; 
        // file_put_contents('Priser 2.0.htm', $DataTextarea);
    }
  
    htm_Panel_0($capt= '@Redigering af prisliste:',$icon= 'fas fa-info',$hint= '@Specielt tilrettet HTML online editor',$form= 'edit',
                $acti= '',$clas= 'panelW960',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);
        $docContent= /* iconv('ISO-8859-1', "UTF-8",  */ file_get_contents('Priser 2.0.htm') /* ) */ ;
        echo '<textarea id="TinyTextarea" name="TinyTextarea" rows="120" cols="120" style="white-space: nowrap">'.$docContent.'</textarea>';
    htm_Panel_00( labl:'GEM', icon:'', hint:'', name:'', form:'edit',subm:false,  attr:'', akey:'s', kind:'save', simu:false);
    
htm_Page_00();
// phpinfo();
?>