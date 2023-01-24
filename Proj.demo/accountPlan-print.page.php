<?php   $DocFile= './Proj.demoaccountPlan-print.page.php';    $DocVer='1.2.1';    $DocRev='22-08-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
$lang= 'da';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php');

## Speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                 CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',          'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [0, '_assets/',  '']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


htm_Page_0( $titl='accounPlan-print.page.php');
    htm_Panel_0($capt='Konto plan - print',$icon = '',$hint = '',$form = '',$acti = '',$clas = 'panelWmax',$wdth = '',$styl = 'background-color: white;',$attr = '',$show = false,$head = ''   );
    // file_put_contents('accountPlan.print.htm','<body style="margin:0; padding:0;">'.$spool.'</body>');
    echo file_get_contents('accountPlan.print.htm');
    htm_Panel_00(); 

htm_Page_00();

?>

                      