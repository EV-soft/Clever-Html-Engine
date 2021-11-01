<?php   $DocFil= './Proj1/demoFile/functions.page.php';    $DocVer='1.0.0';    $DocRev='2021-11-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
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


    htm_TextPre("
<big>FUNCTIONS - vers. 1.1.0 - 2021-10-24:</big><code>

filedata.inc.php<i>   10: </i><b>ReadCSV</b>(\$filepath='ISO639-1.csv')
filedata.inc.php<i>   25: </i><b>WriteCSV</b>(\$filepath='',\$list=[])
filedata.inc.php<i>   43: </i><b>csv_parse</b>(\$filepath, \$options = array())
filedata.inc.php<i>   75: </i><b>fromFile </b>(\$dPath, \$arrNames)
filedata.inc.php<i>   81: </i><b>FileRead_arr</b>(\$filepath='', &\$array=[])
filedata.inc.php<i>   88: </i><b>FileWrite_arr</b>(\$filepath='', \$array=[])
filedata.inc.php<i>   96: </i><b>get_json</b>(\$fname='DataFile.dat.json')
filedata.inc.php<i>  100: </i><b>put_json</b>(\$fname='DataFile.dat.json',\$recData)

menu.inc.php<i>       13: </i><b>Menu_0</b>(\$clas='firstmain',\$href='#',\$labl='',\$titl='')
menu.inc.php<i>       22: </i><b>Menu_00</b>()
menu.inc.php<i>       33: </i><b>Menu_Item</b>(\$clas='',\$href='#',\$labl='',\$titl='',\$cssIcon='',\$attr='')
menu.inc.php<i>       52: </i><b>Menu_Topdropdown</b>(\$showGroup1=true, \$showGroup2=true, \$showGroup3=false, \$showGroup4=false, \$showGroup5=false, \$showGroup6=false)

php2html.lib.php<i>  118: </i><b>arrPrint</b>(\$arr,\$name='',\$echo=true)
php2html.lib.php<i>  126: </i><b>run_Script</b>(\$cmdStr='')
php2html.lib.php<i>  131: </i><b>set_Style</b>(\$att='',\$string='')
php2html.lib.php<i>  180: </i><b>htm_Input</b>(# PHP7: \$type='',\$name='',\$valu='',\$labl='',\$hint='',\$plho='@Enter...',\$wdth='',\$algn='left',\$unit='',\$disa=false,
                           \$rows='2',\$step='',\$attr='',\$list=[],\$llgn='R',\$bord='',\$echo=true,\$form='',\$ftop='');
php2html.lib.php<i>  370: </i><b>htm_Caption</b>(\$labl='',\$style='color:#550000; font-weight:600; font-size: 13px;',\$align='',\$hint='')
php2html.lib.php<i>  378: </i><b>htm_TextDiv</b>(\$content,\$align='left',\$marg='8px',\$attr='box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; 
                           border: solid 1px lightgray; background-color: white; ')
php2html.lib.php<i>  383: </i><b>htm_Table</b>(# PHP7: \$TblCapt,\$RowPref,\$RowBody,\$RowSuff,\$TblNote,&\$TblData,\$FilterOn,\$SorterOn,\$CreateRec,\$ModifyRec,
                           \$ViewHeight,\$TblStyle,\$CalledFrom,\$MultiList)
php2html.lib.php<i> 1057: </i><b>htm_Fields_0</b>(\$caption='',\$width='',\$margin='',\$attr='')
php2html.lib.php<i> 1063: </i><b>htm_FieldsHead</b>(\$caption='',\$width='',\$margin='',\$attr='')
php2html.lib.php<i> 1068: </i><b>htm_Fields_00</b>()
php2html.lib.php<i> 1073: </i><b>htm_FieldsFoot</b>()
php2html.lib.php<i> 1079: </i><b>htm_PanlHead</b>(\$frmName='',\$capt='',\$parms='',\$icon='',\$class='panelWmax',\$where='Undefined',\$attr='',
                          \$BookMark='', \$panlBg='background-color: white;',\$closWidth='',\$panlHint='')
php2html.lib.php<i> 1083: </i><b>htm_Panel_0</b>(\$frmName='',\$capt='',\$parms='',\$icon='',\$class='panelWmax',\$where='Undefined',\$attr='',\$BookMark='',
                           \$panlBg='background-color: white;',\$closWidth='',\$panlHint='')
php2html.lib.php<i> 1172: </i><b>htm_PanlFoot</b>(\$labl='', \$subm=false, \$hint='', \$btnKind='save', \$akey='', \$simu=false, \$frmName='', \$attr='')
php2html.lib.php<i> 1177: </i><b>htm_Panel_00</b>(\$labl='', \$subm=false, \$hint='', \$btnKind='save', \$akey='', \$simu=false, \$frmName='', \$attr='')
php2html.lib.php<i> 1198: </i><b>PanelInit</b>()
php2html.lib.php<i> 1219: </i><b>PanelMin</b>(\$no)
php2html.lib.php<i> 1223: </i><b>PanelMinimer</b>(\$Last)
php2html.lib.php<i> 1229: </i><b>PanelInitier</b>(\$First,\$Last)
php2html.lib.php<i> 1235: </i><b>PanelMax</b>(\$no)
php2html.lib.php<i> 1240: </i><b>PanelOff</b>(\$First,\$Last)
php2html.lib.php<i> 1244: </i><b>PanelOn</b>(\$noFrom,\$noTo=0)
php2html.lib.php<i> 1312: </i><b>RowColTest</b>(\$colr)
php2html.lib.php<i> 1316: </i><b>htm_RowColTop </b>(\$RowColWdth=240)
php2html.lib.php<i> 1322: </i><b>htm_RowColNext</b>(\$RowColWdth=320)
php2html.lib.php<i> 1326: </i><b>htm_RowColBott</b>()
php2html.lib.php<i> 1335: </i><b>htm_AcceptButt</b>( # \$labl='', \$hint='', \$btnKind='', \$form='', \$width='', \$akey='', \$echo=false, \$tipplc='LblTip_text', 
                          \$tipstyl='',\$clicking='', \$attr, \$faicon, \$idix='');
php2html.lib.php<i> 1409: </i><b>htm_ActionButt</b>(\$label, \$id='', \$form='', \$type='button', \$onclick='', \$icon='', \$hint='', \$attr='', \$echo=false)
php2html.lib.php<i> 1429: </i><b>htm_IconButt</b>(\$type='submit',\$faicon='',\$labl='',\$Hint='',\$id='',\$link='',\$action='',\$akey='',\$size='32px',\$fg='gray',
                          \$bg='white',\$echo=true)
php2html.lib.php<i> 1450: </i><b>htm_MultistateButt</b>(\$name='ROWyCOLx', \$valu='', \$style='style=\"padding:1px;\"', \$active=true)
php2html.lib.php<i> 1483: </i><b>htm_LinkButt</b>(\$labl, \$gotoLink, \$hint='', \$target='_blank', \$echo=true)
php2html.lib.php<i> 1489: </i><b>htm_TextArea</b>(\$labl='', \$hint='', \$id='area', \$form='', \$valu='', \$rows='1', \$widt='', \$plho='?', \$attr='', \$echo=false)
php2html.lib.php<i> 1497: </i><b>str_WithHint</b>(\$labl='',\$hint='',\$icon='')
php2html.lib.php<i> 1504: </i><b>htm_ModalDialog</b>(\$Btype='none',\$capt='@Voilà!',\$mess='',\$butt=['\$type','\$icon','\$labl','\$hint','\$link'],\$html='CSS-based Modal Dialog')
php2html.lib.php<i> 1580: </i><b>htm_Dialog</b>(\$capt='CAPTION', \$content='', \$bgColor='lightyellow', \$buttons= // [])
php2html.lib.php<i> 1631: </i><b>msg_Dialog</b>(\$type='error', \$caption='@User Dialog', \$mess='', \$Buttons= [
php2html.lib.php<i> 1708: </i><b>msg_Error</b>(\$title='Error', \$messg='Message')
php2html.lib.php<i> 1712: </i><b>msg_Info</b>(\$title='Info', \$messg='Message')
php2html.lib.php<i> 1716: </i><b>msg_Warn</b>(\$title='Warning', \$messg='Message')
php2html.lib.php<i> 1721: </i><b>msg_Hint</b>(\$title='Tip', \$messg='Message')
php2html.lib.php<i> 1725: </i><b>msg_Succ</b>(\$title='Hurray', \$messg='Message')
php2html.lib.php<i> 1730: </i><b>msg_System</b>(\$MsgType= 'error', \$title='', \$reason='', \$messg='', \$actions=['goback','goon','close'], \$wdh='600px', \$hgt='150px')
php2html.lib.php<i> 1797: </i><b>Pmnu_0</b>(\$id='id',\$capt='',\$widt='210px',\$icon='',\$stick='false',\$attr='background-color:lightcyan;',\$context=true,\$echo=true)
php2html.lib.php<i> 1822: </i><b>Pmnu_Item</b>(\$type='plain',\$labl='',\$hint='',\$icon='',\$id='',\$click='',\$attr='',\$short='',\$enabl='true',\$echo=true)
php2html.lib.php<i> 1853: </i><b>Pmnu_00</b>(\$labl='',\$hint='',\$attr='',\$echo=true)
php2html.lib.php<i> 1873: </i><b>htm_PagePrep</b>(\$pageTitl='', \$ØPageImage='',\$align='center',\$PgInfo='',\$PgHint='',\$headScript='',\$pageBorder=true)
php2html.lib.php<i> 1877: </i><b>htm_PageFina</b>()
php2html.lib.php<i> 1883: </i><b>htm_Page_0</b>(\$pageTitl='', \$ØPageImage='',\$align='center',\$PgInfo='',\$PgHint='',\$headScript='',\$pageBorder=true)
php2html.lib.php<i> 3039: </i><b>htm_Page_00</b>()
php2html.lib.php<i> 3088: </i><b>Lbl_Tip</b>(\$lbl,\$tip,\$plc='',\$h='13px',\$t='')
php2html.lib.php<i> 3118: </i><b>dvl_echo</b>(\$testlabl='')
php2html.lib.php<i> 3123: </i><b>calcHash</b>(\$usr_name,\$usr_code)
php2html.lib.php<i> 3131: </i><b>htm_Ihead</b>(\$source)
php2html.lib.php<i> 3132: </i><b>htm_hr</b>(\$c='#0',\$attr='')
php2html.lib.php<i> 3133: </i><b>htm_br</b>(\$rept=1)
php2html.lib.php<i> 3134: </i><b>htm_nl</b>(\$rept=1)
php2html.lib.php<i> 3135: </i><b>htm_lf</b>(\$rept=1)
php2html.lib.php<i> 3136: </i><b>htm_sp</b>(\$rept=1)
php2html.lib.php<i> 3138: </i><b>htm_space</b>(\$wdt)
php2html.lib.php<i> 3142: </i><b>str_bold</b>(\$source,\$result='',\$tail='  ')
php2html.lib.php<i> 3143: </i><b>str_Ihead</b>(\$source)
php2html.lib.php<i> 3144: </i><b>str_hr</b>(\$c='#0',\$attr='')
php2html.lib.php<i> 3145: </i><b>str_br</b>(\$rept=1)
php2html.lib.php<i> 3146: </i><b>str_nl</b>(\$rept=1)
php2html.lib.php<i> 3147: </i><b>str_lf</b>(\$rept=1)
php2html.lib.php<i> 3148: </i><b>str_sp</b>(\$rept=1)
php2html.lib.php<i> 3150: </i><b>markFirstChar</b>(\$str='',\$tag='u',\$att='')
php2html.lib.php<i> 3152: </i><b>markAllChars</b>(\$str='',\$tag='u',\$att='')
php2html.lib.php<i> 3155: </i><b>toNum</b>(\$test='')
php2html.lib.php<i> 3158: </i><b>scannSource</b>(\$prefix='\$name=',\$suffix=\"'\",\$files=[])
php2html.lib.php<i> 3175: </i><b>arrPretty</b>(\$arrVar,\$titl='')
php2html.lib.php<i> 3180: </i><b>form2arr</b>(&\$arr, \$checks=[])
php2html.lib.php<i> 3188: </i><b>tabl2arr</b>(&\$arr,\$firstId,\$arrSpec=[])
php2html.lib.php<i> 3226: </i><b>sys_enc</b>(\$text)
php2html.lib.php<i> 3237: </i><b>sys_get_translations</b>(\$transTable)
php2html.lib.php<i> 3273: </i><b>postValue</b>(&\$id,\$varId)
php2html.lib.php<i> 3280: </i><b>get_browser_name</b>(\$user_agent)
php2html.lib.php<i> 3292: </i><b>DropDown</b>(\$name, \$valu, \$list ,\$attr='')
php2html.lib.php<i> 3310: </i><b>infoLabl</b>(\$label='',\$Hint='',\$plac='SW')
php2html.lib.php<i> 3315: </i><b>menuCapt </b>(\$h='32',\$w='120',\$label='')
php2html.lib.php<i> 3323: </i><b>menuButt </b>(\$h='32',\$w='120',\$label='',\$link='',\$Hint='')

translate.inc.php<i>  12: </i><b>scannLngStrings</b>(\$code= 'dk')
translate.inc.php<i> 178: </i><b>langList</b>()
translate.inc.php<i> 192: </i><b>SelNew</b>(\$langList)
<code>
       
");
htm_nl(1);
htm_PanlFoot();
htm_PageFina();
### :PAGE_END
?>