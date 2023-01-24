<?php   $DocFil= './Proj.demo/support.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-19';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');
## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [2, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);               // jquery.min.js
define('LIB_JQUERYUI',      [2, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [2, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN 

htm_Page_0($titl='support.page.php',$hint='',$info='',$inis='',$algn='center', $gbl_Imag=$gbl_ProgRoot.'_accessories/_background.png',$gbl_Bord=false);
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center;">';
         # $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'panelWmax',$wdth= '',$styl= 'background-color: white;',$attr= '' 
    htm_Panel_0($capt='Support-files',$icon='fas fa-file', $hint= '',$form= 'head',$acti= '',$clas='panelW560',$wdth= '',$styl= 'background-color: white;',$attr= '');
    htm_nl(1);
    echo '<pre style="text-align: left;">
    The system relies on some external libraries, <br>
    all of which are placed in a subfolder: <b>_assets</b> <br>
    In there are currently following sub-folders: <br>
    _assets:            - libraries <br>
        css             - CSS styles <br>
        font-awesome6   - Icon system <br>
        fonts           - Special fonts <br>
        icons           - System icons <br>
        images          - System images <br>
        jquery          - Base Java scripts <br>
        tablesorter     - Mottie table-libraries <br>
          <br>
        Most of these can alternatively be called from CDN <br>
        (Cloudflare) on the Web. <br>
        </pre>';
    htm_nl(0);
                # $labl='', $icon='', $hint='', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false)
    htm_Panel_00( $labl='Demo', $icon='', $hint='Buttom', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false);
    echo '</div>';

htm_Page_00();
?>