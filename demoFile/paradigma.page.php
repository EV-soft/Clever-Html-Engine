<?php   $DocFil= './Proj1/demoFile/paradigma.page.php';    $DocVer='1.0.0';    $DocRev='2020-08-05';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft ***
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

### SPECIAL this page only:


##### DATA EXCHANGE:
$dPath= '../demoData/';

### SAVE to database:    # UPDATE files:


### READ from database:  # INIT variables:




##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_PagePrep

htm_PagePrep($pageTitl='-.page.php', $ØPageImage='../_background.png',$align='center',$PgInfo=lang('@-'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
//	Menu_Topdropdown(true); htm_nl(1);


	htm_PanlHead($frmName='', $capt=lang('@-'), $parms='', $icon='fas fa-plus', $class='panelW960', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');

	htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);


htm_PageFina();

##### CLEANUP:

?>