<?php   $DocFile= './Proj.demo/other.page.php';    $DocVer='1.2.0';    $DocRev='2022-02-22';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                 CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',          'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [0, '_assets/',  '']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN

htm_Page_0($titl='other.page.php',$hint=$©,$info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=false);
#htm_PagePrep($pageTitl='other.page.php', $ØPageImage=$ØProgRoot.'_assets/images/_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);
    htm_Panel_0($capt= 'Other htm_functions:',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
  //htm_PanlHead($frmName='', $capt='Other htm_functions:', $parms='', $icon='fas fa-info', $class='panelW480', $func='Undefined', $more='', 
  //            $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
                
    htm_TextDiv('There are a lot of small functions that could be mentiond here.
            e.g. htm_AcceptButt()
            <br><br>
            <b>htm_AcceptButt()</b> - a programmeble button. You give: <br>
            $labl           - The caption on the button               <br>
            $hint           - The description about actual function   <br>
            $btnKind        - The kind gives the color                <br>
            $form           - The form name on witch it could submit  <br>
            $width          - Width of the button                     <br>
            $akey           - Shortcut key                            <br>
            $rtrn=true,     - Act as a procedure or a function        <br>
            $tipplc         - Placement of the popup tip              <br><br>
            <b>htm_IconButt()</b> - a general button with icon. <br><br>
            <b>htm_ModalDialog()</b>    - A popup message, locks program and waits for a user response. <br>
            <b>Pmnu_0() / Pmnu_00()</b> - A popup context menu system.  <br><br>
            A special group of functions:                             <br>
            <b>dvl_</b> functions - relates to development (tools and design) <br><br>');

    htm_Panel_00();

htm_Page_00();
?>