<?php   $DocFil= './functions.page.php';    $DocVer='1.2.2';    $DocRev='2023-01-23';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [2, '_assets/jquery/latest/',            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/']);   
define('LIB_JQUERYUI',      [2, '_assets/jquery-ui/latest/',         'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);
define('LIB_TABLESORTER',   [0, '_assets/tablesorter/latest/',       'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']); 
define('LIB_FONTAWESOME',   [0, '_assets/font-awesome/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/']);        // css/all.min.css
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN

include('../funcscann.php');

### PAGE-START:
htm_Page_0( titl:'functions.page.php', hint:'', info:'', inis:'', algn:'center',  gbl_Imag:$gbl_ProgRoot.'_assets/images/_background.png', gbl_Bord:true);
    Menu_Topdropdown(true); htm_nl(1);
    
    htm_Panel_0( capt: 'Here are the complete overview over the system functions:', icon: 'fas fa-info', hint: '', form: '', acti: '', clas: 'panelWaut', wdth: '', styl: 'background-color: white;', attr: '');
        htm_TextPre('<big>FUNCTIONS - vers. '.$DocVer.' - '.date("Y-m-d").':</big><br>'.
            file_get_contents('../Functions.html'));
        htm_nl(1);
    htm_Panel_00();
htm_Page_00();
### :PAGE_END
/* 
    ## Notes:
    funcscann.php - Analyze project files and save in Functions.html
    functions.page.php - Display content in ../Functions.html
 */
?>