<?php   $DocFil= './Proj1/demoFile/functions.page.php';    $DocVer='1.0.0';    $DocRev='2020-12-21';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= './../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');


### PAGE-START:
htm_PagePrep($pageTitl='functions.page.php', $ØPageImage= $ØProgRoot.'_assets/images/_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);
    htm_PanlHead($frmName='', $capt='Here are the complete overview over the system functions:', $parms='', $icon='fas fa-info', $class='panelWaut', $func='Undefined', $more='', 
            $BookMark='blindAlley.page.php',$panlBg='background-color: white;');


    htm_TextPre('
/filedata.inc.php _ 2020-08-17
       --> 10: function ReadCSV($filepath=\'ISO639-1.csv\') 
       --> 25: function WriteCSV($filepath=\'\',$list=[]) 
       --> 43: function csv_parse($filepath, $options = array()) 
       --> 75: function FileWrite_arr($filepath=\'\', $array=[]) 
       --> 80: function FileRead_arr($filepath=\'\', &$array=[]) 

/menu.inc.php _ 2020-09-04
       ---> 5: function MenuStart($clas=\'firstmain\',$href=\'#\',$labl=\'\',$titl=\'\') 
       --> 14: function MenuEnd() 
       --> 25: function MenuBranch($clas=\'\',$href=\'#\',$labl=\'\',$titl=\'\',$cssIcon=\'\',$more=\'\') 
       --> 44: function Menu_Topdropdown($showGroup1=true, $showGroup2=false, $showGroup3=false, $showGroup4=false, 
                                         $showGroup5=false, $showGroup6=false) 
       --> 80: function Menu_TinyCloud($showGroup1=true, $showGroup2=false, $showGroup3=false, $showGroup4=false, 
                                       $showGroup5=false, $showGroup6=false) 
       -> 122: function Menu_BottomScroll() 

/php2html.lib.php _ 2020-09-04
       --> 96: function arrPrint($arr,$name=\'\',$proc=true) 
       -> 104: function run_Script($cmdStr=\'\') 
       -> 108: function set_Style($att=\'\',$string=\'\') 
       -> 156: function htm_Input(# $type=\'\',$name=\'\',$valu=\'\',$labl=\'\',$hint=\'\',$plho=\'@Enter...\',$wdth=\'\',$algn=\'left\',
                                $unit=\'\',$disa=false,$rows=\'2\',$step=\'\',$more=\'\',$list=[],$llgn=\'R\',$bord=\'\',$proc=true);
       -> 329: function htm_Caption($labl=\'\',$style=\'color:#550000; font-weight:600; font-size: 13px;\',$align=\'\') 
       -> 332: function htm_TextDiv($content,$align=\'left\',$marg=\'8px\',$more=\'\') 
       -> 336: function htm_TextPre($content,$align=\'left\',$marg=\'8px\',$more=\'\',$code=false,$font=\'\') 
       -> 342: function htm_MiniNote($note) 
       -> 345: function htm_TextTip($capt=\'TIP\',$body=\'\',$width=\'\',$colr=\'\',$align=\'center\') 
       -> 355: function invertColor($colr,$bw) 
       -> 411: function htm_Table(# $TblCapt,$RowPref,$RowBody,$RowSuff,$TblNote,&$TblData,$FilterOn,$SorterOn,$CreateRec,
                                    $ModifyRec,$ViewHeight,$TblStyle,$CalledFrom,$MultiList)
       -> 895: function htm_PanlHead($frmName=\'\', $capt=\'\', $parms=\'\', $icon=\'\', $class=\'panelWmax\', $where=\'Undefined\', 
                                     $more=\'\', $BookMark=\'\', $panlBg=\'background-color: white;\')
       -> 973: function htm_PanlFoot( $labl=\'\', $subm=false, $title=\'\', $btnKind=\'save\', $akey=\'\', $simu=false, $frmName=\'\')
       -> 992: function PanelInit() 
       > 1013: function PanelMin($no) 
       > 1016: function PanelMinimer($Last) 
       > 1021: function PanelInitier($First,$Last) 
       > 1026: function PanelMax($no) 
       > 1030: function PanelOff($First,$Last) 
       > 1033: function PanelOn($noFrom,$noTo=0) 
       > 1100: function RowColTest($colr) 
       > 1102: function htm_RowColTop ($RowColWdth=240) 
       > 1105: function htm_RowColNext($RowColWdth=320) 
       > 1107: function htm_RowColBott()       
       > 1112: function htm_AcceptButt( # $labl=\'\', $title=\'\', $btnKind=\'\', $form=\'\', $width=\'\', $akey=\'\', $proc=false, 
                                          $tipplc=\'LblTip_text\', $tipstyl=\'\',$clicking=\'\', $more, $faicon);
       > 1180: function htm_IconButt($type=\'submit\',$faicon=\'\',$labl=\'\',$title=\'\',$id=\'\',$link=\'\',$action=\'\',$akey=\'\',
                                     $size=\'32px\',$fg=\'gray\',$bg=\'white\')
       > 1200: function htm_LinkButt($labl, $gotoLink, $hint=\'\', $target=\'_blank\') 
       > 1205: function htm_PagePrep($pageTitl=\'\', $ØPageImage=\'\',$align=\'center\',$PgInfo=\'\',$PgHint=\'\') 
       > 1435: function updateInput(fieldname,ish)
       > 1652: function htm_PageFina() 
       > 1690: function Lbl_Tip($lbl,$tip,$plc=\'\',$h=\'13px\',$t=\'\') 
       > 1719: function dvl_echo($testlabl=\'\') 
       > 1723: function calcHash($usr_name,$usr_code) 
       > 1730: function htm_Ihead($source) 
       > 1731: function htm_hr($c=\'#0\')    
       > 1732: function htm_nl($rept=1)    
       > 1733: function htm_lf($rept=1)    
       > 1734: function htm_sp($rept=1)    
       > 1736: function htm_space($wdt)    
       > 1740: function str_bold($source,$result=\'\',$tail=\'  \') 
       > 1741: function str_Ihead($source) 
       > 1742: function str_hr($c=\'#0\')    
       > 1743: function str_nl($rept=1)    
       > 1744: function str_lf($rept=1)    
       > 1745: function str_sp($rept=1)    
       > 1747: function markFirstChar($str=\'\',$tag=\'u\',$att=\'\') 
       > 1748: function markAllChars($str=\'\',$tag=\'u\',$att=\'\')  
       > 1750: function toNum($test=\'\') 
       > 1752: function scannSource($prefix=\'$name=\',$suffix=\"\'\",$files=[]) 
       > 1768: function form2arr(&$arr, $checks=[]) 
       > 1775: function tabl2arr(&$arr,$firstId,$arrSpec=[]) 
       > 1789: function fromFile ($dPath, $arrNames) 
       > 1816: function sys_enc($text) 
       > 1826: function sys_get_translations($transTable) 
       > 1859: function postValue(&$id,$varId) 
       > 1865: function get_browser_name($user_agent) 
       > 1876: function DropDown($name, $valu, $list ,$more=\'\') 
       > 1893: function infoLabl($label=\'\',$title=\'\',$plac=\'SW\') 
       > 1897: function menuCapt ($h=\'32\',$w=\'120\',$label=\'\') 
       > 1904: function menuButt ($h=\'32\',$w=\'120\',$label=\'\',$link=\'\',$title=\'\') 

/translate.inc.php _ 2020-08-17
       --> 12: function scannLngStrings($code= \'dk\') 
       -> 171: function langList() 
       -> 185: function SelNew($langList) 
');
htm_nl(1);
htm_PanlFoot();
htm_PageFina();
### :PAGE_END
?>