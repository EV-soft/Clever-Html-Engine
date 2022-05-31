<?php   $DocFile= './Proj.demo/navigate.page.php';    $DocVer='1.2.0';    $DocRev='2022-01-06';     $DocIni='evs';  $ModulNr=0; ## File informative only
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

         # $pageTitl='',                  $gbl_PageImage='',                                            $align='center',$PgInfo='',$PgHint='',$headScript='',$pageBorder=true) 
#htm_Page_0($pageTitl='navigate.page.php', $gbl_PageImage= $gbl_ProgRoot.'_accessories/_background.png', $align='center');       
htm_Page_0( $titl='navigate.page.php',$hint=$©,$info=lang('@PHP2HTML Demo and Documentation'),$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=true);
    Menu_Topdropdown(true); htm_nl(1);
        # v1.2: $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'panelWmax',$wdth= '',$styl= 'background-color: white;',$attr= '',$where='Undefined',$BookMark='' 
    htm_Panel_0($capt= '@Navigate functions:',$icon= 'fas fa-info',$hint= '@HINT',$form= '',$acti= '',$clas= 'panelW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );           
    htm_TextDiv('To navigate in a program you can use:<br><br>
            <b>Menu_Topdropdown()</b> witch you can see at the top of all demo pages.<br>
            You find it in the file: menu.inc.php <br>
            and it is called with Menu_Topdropdown() <br><br>
            Another button is <b>menuButt()</b> that can be used to link to subpages:<br><br>');

    echo '<div style="text-align: center;">';
        menuCapt($h='24',$w='200',$label='Simple menuCaption()');
        htm_nl(0);
        menuButt($h='24',$w='200',$label='MenuButt 1',$link='',$title='MenuButt'); htm_nl(1);
        menuButt($h='24',$w='200',$label='MenuButt 2',$link='',$title='MenuButt');
    echo '</div>';
    echo '<br><br>';
    htm_TextTip($capt='See also: <b>htm_IconButt()</b>',$body='- a general button with icon.',$width='',$colr='lightgreen',$align='center');
//See also: <b>htm_IconButt()</b> - a general button with icon. <br><br>
    echo '</div>';

    htm_Panel_00(); # ($labl='', $icon='', $hint='', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false)

htm_Page_00();
?>