<?php   $DocFil= './Proj1/demoFile/functions.page.php';    $DocVer='1.0.0';    $DocRev='2020-07-05';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');


### PAGE-START:
htm_PagePrep($pageTitl='functions.page.php', $ØPageImage='../_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);
    htm_PanlHead($frmName='', $capt='Here are the complete overview over the system functions:', $parms='', $icon='fas fa-info', $class='panelWaut', $func='Undefined', $more='', 
            $BookMark='blindAlley.page.php',$panlBg='background-color: white;');

    htm_TextPre('
/filedata.inc.php _ 2020-06-07
                             --> 10: function ReadCSV($filepath=\'ISO639-1.csv\') 
                             --> 25: function WriteCSV($filepath=\'\',$list=[]) 
                             --> 43: function csv_parse($filepath, $options = array()) 
                             --> 75: function FileWrite_arr($filepath=\'\',$arrName=\'\', $list=[]) 
                             --> 89: function FileRead_arr($filepath=\'\')

/menu.inc.php _ 2020-06-12
                             ---> 6: function MenuStart($clas=\'firstmain\',$href=\'#\',$labl=\'\',$titl=\'\') 
                             --> 16: function MenuEnd() 
                             --> 27: function MenuBranch($clas=\'\',$href=\'#\',$labl=\'\',$titl=\'\',$cssIcon=\'\',$more=\'\') 
                             --> 46: function Menu_Topdropdown($showGroup1=true, $showGroup2=false, $showGroup3=false, $showGroup4=false, $showGroup5=false, $showGroup6=false) 

/php2html.lib.php _ 2020-06-13
                             --> 89: function htm_Input(# $type=\'\',$name=\'\',$valu=\'\',$labl=\'\',$llgn=\'R\',$hint=\'\',$algn=\'left\',$unit=\'\',$disa=false,$rows=\'2\',$wdth=\'\',$step=\'\',$more=\'\',$plho=\'@Enter...\',$list=[] )
                             -> 250: function htm_TextDiv($content,$align=\'left\',$marg=\'8px\',$more=\'\') 
                             -> 254: function htm_TextPre($content,$align=\'left\',$marg=\'8px\',$more=\'\') 
                             -> 286: function htm_Table(# $TblCapt,$RowPref,$RowBody,$RowSuff,$TblNote,&$TblData,$FilterOn,$SorterOn,$CreateRec,$ModifyRec,$ViewHeight,$TblStyle,$CalledFrom$Criterion)
                             -> 660: function htm_PanlHead($frmName=\'\', $capt=\'\', $parms=\'\', $icon=\'\', $class=\'panelWmax\', $func=\'Undefined\', $more=\'\', $BookMark=\'\', $panlBg=\'background-color: white;\')
                             -> 735: function htm_PanlFoot( $labl=\'\', $subm=false, $title=\'\', $btnKind=\'save\', $akey=\'\', $simu=false, $frmName=\'\') 
                             -> 754: function PanelInit() 
                             -> 774: function PanelMin($nr) 
                             -> 777: function PanelMinimer($Last) 
                             -> 782: function PanelInitier($First,$Last) 
                             -> 787: function PanelMax($nr) 
                             -> 791: function PanelOff($First,$Last) 
                             -> 794: function PanelOn($nrFra,$nrTil=0) 
                             -> 798: function PanelBetjening() 
                             -> 866: function RowColTest($colr) 
                             -> 868: function htm_RowColTop ($RowColWdth=240) 
                             -> 871: function htm_RowColNext($RowColWdth=320) 
                             -> 873: function htm_RowColBott()       
                             -> 878: function htm_AcceptButt( # $labl=\'\', $title=\'\', $btnKind=\'\', $form=\'\', $width=\'\', $akey=\'\', $proc=false, $tipplc=\'LblTip_text\')
                             -> 936: function htm_PagePrep($pageTitl=\'\', $ØPageImage=\'\',$align=\'center\') 
                             > 1226: function htm_PageFina() 
                             > 1258: function htm_IconButt($type=\'submit\',$faicon=\'\',$labl=\'\',$title=\'\',$id=\'\',$link=\'\',$action=\'\',$akey=\'\',$size=\'32px\',$fg=\'gray\') 
                             > 1277: function calcHash($usr_name,$usr_code) 
                             > 1286: function Lbl_Tip($lbl,$tip,$plc=\'\',$h=\'13px\',$t=\'\') 
                             > 1315: function dvl_ekko($testlabl=\'\') 
                             > 1321: function htm_Ihead($source) 
                             > 1322: function htm_hr($c=\'#0\')    
                             > 1323: function htm_nl($rept=1)    
                             > 1324: function htm_lf($rept=1)    
                             > 1325: function htm_sp($rept=1)    
                             > 1327: function htm_space($wdt)    
                             > 1331: function str_bold($source,$result=\'\',$tail=\'  \') 
                             > 1332: function str_Ihead($source) 
                             > 1333: function str_hr($c=\'#0\')    
                             > 1334: function str_nl($rept=1)    
                             > 1335: function str_lf($rept=1)    
                             > 1336: function str_sp($rept=1)    
                             > 1339: function arrPrint($arr,$name=\'\') 
                             > 1344: function scannSource($prefix=\'$name=\',$suffix="\'",$files=[]) 
                             > 1409: function sys_get_translations($tr) 
                             > 1446: function run_Script ($cmdStr) 
                             > 1450: function postValue(&$id,$varId) 
                             > 1456: function get_browser_name($user_agent) 
                             > 1467: function ddwnList($name,$valu,$optliste=[],$more=\'\',$indiv=true) 
                             > 1487: function infoLabl($label=\'\',$title=\'\',$plac=\'SW\') 
                             > 1491: function menuCapt ($h=\'32\',$w=\'120\',$label=\'\') 
                             > 1498: function menuButt ($h=\'32\',$w=\'120\',$label=\'\',$link=\'\',$title=\'\') 

/translate.inc.php _ 2020-06-09
                             --> 11: function scannLngStrings($code= \'dk\') 
                             -> 158: function langList() 
                             -> 172: function SelNew($langList) 
');

htm_PanlFoot();
htm_PageFina();
### :PAGE_END
?>