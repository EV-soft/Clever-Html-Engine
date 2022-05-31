<?php   $DocFil= './functions.page.php';    $DocVer='1.2.0';    $DocRev='2022-05-28';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                         CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',                  'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',          'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
// define('LIB_FONTAWESOME',   [1, '_assets/font-awesome5/5.15.4/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/']);
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome6/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome6/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN _assets/font-awesome6/js/all.js

### PAGE-START:
htm_Page_0($titl='functions.page.php',$hint='',$info='',$inis='',$algn='center', $gbl_Imag=$gbl_ProgRoot.'_assets/images/_background.png',$gbl_Bord=true);
    Menu_Topdropdown(true); htm_nl(1);
    
    htm_Panel_0($capt= 'Here are the complete overview over the system functions:',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelWaut',$wdth= '',$styl= 'background-color: white;',$attr= '');
    htm_TextPre('<big>FUNCTIONS - vers. 1.2.0 - '.date("Y-m-d").':</big><br>'.file_get_contents('../Functions.html'));

htm_nl(1);
htm_Panel_00();
htm_Page_00();
### :PAGE_END
/* 
## Notes:
funcscann.php       - Analyser projekt filer og gem i Functions.html
functions.page.php  - Vis indhold i ../Functions.html
 */
?>