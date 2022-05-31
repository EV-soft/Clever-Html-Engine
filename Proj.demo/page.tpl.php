<?php   $DocFile= './Proj.demo/page.tpl.php';    $DocVer='1.2.0';    $DocRev='2022-03-05';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';
## .tpl.php - Temmplate file for *.page.php files....   - PHP8+ notation !

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
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome5/5.15.4/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN

### DATA-INIT/UPDATE:

## Prepare data used for the page here...

### PAGE-START:
htm_Page_0(titl:'xxxx.page.php', hint:$©, info:'File: '. $DocFile.' - ver:'.$DocVer, inis:'', algn:'center', gbl_Imag:'../_accessories/_background.png', gbl_Bord:false);
    Menu_Topdropdown(true); htm_nl(1);

    htm_Panel_0(capt: '@Template', icon: 'fas fa-info', hint: '@Template for a panel', form: 'formname', acti: '', clas: 'panelW480', wdth: '', styl: 'background-color: white;', attr: '');
## Content here...
    htm_Textdiv('Showing template for a page and a panel.');
                 
    htm_Panel_00(labl:'@Submit button', icon:'', hint:'', name:'xxx', form:'formname', subm:true, attr:'', akey:'', kind:'save', simu:false);
    
htm_Page_00();

### :PAGE_END
## Page init...
    PanelOff($First=2,$Last=5);
?>