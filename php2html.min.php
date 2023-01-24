<?  $DocFileLib='../php2html.lib.php';  $DocVer='1.2.2';  $DocRev='2023-01-22';  $DocIni='evs';  $ModulNo=0;
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE'; /*
Created: 2020-02-29 evs - EV-soft
Latest revision: see file 1. line: $DocRevi
R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
2020-00-00 - evs  Initial
*/
session_start();
define('DEBUG',false);
define('USEGRID',false);
define('ThousandsSep',' ');
define('DecimalSep',',');
$part1= $_SERVER['HTTP_REFERER'] ?? '';
$part2= end(array_reverse(explode('/',trim($_SERVER['SCRIPT_NAME'],'/',))));
$gbl_ProgBase= substr($part1,strpos($part1,strlen($part2)),strpos($part1,$part2)+strlen($part2)+1);
$gbl_ProgBase= $part2.'/';
$gbl_ProgBase= '';
if (is_readable('../project.init.php')) include('project.init.php'); else {
$gbl_TblIx= -1;
$gbl_ProgTitl= 'php2html';
$gbl_progVers= 'Develop'.' ';
$gbl_copyright='EV-soft';
$gbl_designer= 'EV-soft';
$gbl_menuLogo= $gbl_ProgBase.'_accessories/21997911.png';
$gbl_blueColor= 'lightblue';
$gbl_BodyBcgrd= 'Tan';
$gbl_iconColor= 'DarkGreen';
$gbl_TitleColr= 'DarkGreen';
$gbl_PanelBgrd= 'transparent';
$gbl_GridOn= true;
$gbl_progZoom = 'small';
}
$jsScripts= '';
if (is_null($rowHtml ?? '')) $rowHtml= '';
if ($GLOBALS["gbl_ProgRoot"] ?? '') $gbl_ProgRoot= $GLOBALS["gbl_ProgRoot"];
else  $gbl_ProgRoot=  './';
$gbl_ProgRoot=  "./../";
$_assets=  $gbl_ProgRoot.'_assets/';
$_base=  '';
if (!isset($folder1)) {
$folder1= $gbl_ProgRoot.'';
$folder2= $gbl_ProgRoot.'./';
$folder3= '';
$folder4= '';
$folder5= '';
}
if (!isset($_SESSION['proglang'])) $_SESSION['proglang']= '';
$App_Conf['language'] = $_SESSION['proglang'];
$englishOnly= false;
$gbl_novice= false;
if (empty($App_Conf['language'])) $App_Conf['language'] = 'en : English';
if (empty($App_Conf['test'])) $App_Conf['test'] = 'TESTER';function arrPrint($arr,$name='',$rtrn=false)
{
if ($name>'') $name.=': ';
$result= "<br><textarea>".$name. print_r($arr). "</textarea><hr>\n";
if (!$rtrn) echo $result;
else return $result;
}
function arrPretty($arrVar,$titl='',$attr='rows="20" cols="135"',$rtrn=false)
{
$result= "<meta charset='UTF-8'>
<div style='background: lightcyan;'>".$titl."</div>
<textarea ".$attr." wrap = 'off' style='padding: 10px;'>". print_r($arrVar,true)."</textarea><hr>\n";
if (!$rtrn) echo $result;  else return $result;
}
function run_Script($cmdStr='') {
echo "\n<script>\n".$cmdStr."\n</script>\n";
}
function set_Style($att='',$string='') {
echo "\n<style ".$att.'>'.$string." </style>\n";
}function htm_Input(
$labl= '',
$plho= '@Enter...',
$icon= '',
$hint= '',
$type= 'text',
$name= '',
$valu= '',
$form= '',
$wdth= '100%',
$algn= 'left',
$attr= '',
$rtrn= false,
$unit= '',
$disa= false,
$rows= '2',
$step= '',
$list= [],
$llgn= 'R',
$bord= '',
$ftop= ''
) {
global $gbl_GridOn;
($form=='' ? $result= '' : $result= '<form name= "'.$form.'" style="display:inline;">');
if ($wdth>'') $wdth= ' width: '.$wdth.'; '; else $wdth='';
if ($ftop>'') $ftop= ' top: '.$ftop.'; '; else $ftop='';
if ($hint=='') $hint= '@There is no explanation !';
$hint= lang($hint);
$labl= lang($labl);
($plho=='' ? $plh='' : $plh=' placeholder="'.lang($plho).'" ');
if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
if (strpos(' '.$attr,'required')>0) $bord.= 'border: 1px solid orange;';
if ( ($valu=='')) $dataStyle= 'font-weight: 200; color:var(--grenColr1);'; else $dataStyle='font-weight: 600; ';
#GRID:
if ((USEGRID) and ($gbl_GridOn)) $result.= '<div class="grid-item">';
#FIELD:
$result.= '<div class="inpField" id="inpBox" style="margin: auto; '.$wdth.' '.$ftop.' display: inline-block;"> ';
#INPUT:
($name=='') ? $inpIdNm= '' : $inpIdNm= ' id="'.$name.'" name="'.$name.'" ';
$inpStyle= ' class="boxStyle" style="text-align: '.$algn.'; font-size: 14px; '. $dataStyle. $bord;
$eventInvalid= ' oninvalid="this.setCustomValidity(\''.lang('@Wrong or missing data in ').$labl.' ! \')" oninput="setCustomValidity(\'\')" ';
if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
$top= '';
switch ($type) {
case 'intg' : $result.= '<input type= "number" '.$inpIdNm. $attr. $inpStyle. ' step:'. $step. '" value="'.$valu.'" '. $aktiv. $plh.' />';  break;
case 'text' : $result.= '<input type= "text" '.  $inpIdNm. $attr. $inpStyle. '" value="'. $valu.'" '. $eventInvalid. $aktiv. $plh.' />';  break;
case 'dec0' :
case 'dec1' :
case 'dec2' : $result.= '<input type= "text" '.  $inpIdNm. $attr. ' value="'.$pref. number_format((float)$valu,(int)substr($type,3,1),DecimalSep,ThousandsSep).$suff. '" '.
$inpStyle. '"'. $eventInvalid. $aktiv. $plh. ' pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" />';  break;
case 'num0' :
case 'num1' :
case 'num2' :
case 'num3' : $result.= '<input type="number" '. $inpIdNm. $attr.' lang="en" step="'.$step.'" value="'.$valu.'" '.
$eventInvalid. $aktiv. $plh. ' pattern="(\d{3})([\.])(\d{2})"'.
$inpStyle. '" />';  break;
case 'barc' : $result.= '<input type= "text" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh.
$inpStyle. ' font-family:barcode; font-size:19px; font-weight:normal; '. '" />';  break;
case 'mail' : $result.= '<input type= "email"'. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. 'pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"'.
$inpStyle. '" />';  break;
case 'link' : $result.= '<input type= "url" '.  $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern='https?:/.+'. $aktiv. $plh.
$inpStyle. '" />';  break;
case 'sear' : $result.= '<input type="search" '.$inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
$inpStyle. '" />';  break;
case 'file' : $result.= '<input type= "file" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
$inpStyle.$dataStyle. '" />';  break;
case 'imag' : $result.= '<input type= "image" '.$inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
$inpStyle. ' height: 18px;" />';  break;
case 'date' : $result.= '<input type= "date" '. $inpIdNm. $attr. $inpStyle. ' display:inline-block;'.' min-width: 105px; '.
' margin: 5px 5px 0; padding: 8px 2px 2px 2px;" value="'.$valu. '" placeholder ="yyyy-mm-dd" '. $aktiv.' />';  break;
case 'time' : $result.= '<input type= "time" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
$inpStyle. '" />';  break;
case 'week' : $result.= '<input type= "week" '. $inpIdNm. $attr. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv.' />';  break;
case 'mont' : $result.= '<input type= "month" '.$inpIdNm. $attr. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv.' />';  break;
case 'rang' : $result.= '<span class="fieldContent boxStyle range-wrap" style="height: 28px; ">'.
'<input class="range" type= "range" '.$inpIdNm. $attr. ' value="'.$valu.'" '. $aktiv. 'onclick="setBubble('.$name.',\'bubbleDiv\')" style= "text-align: '.$algn.'; font-size: 12px; margin: 0; box-shadow: none;" /> '.
'<div class="bubble" id="bubbleDiv" name="bubbleDiv"
style="font-size: 10px; top: -45px; position: relative; width: 100%; text-align: center; opacity: 80%;"> '.
'<span style="width: 33.33%; float:left;">'.substr($attr,1,7).' </span> <span style="width: 33.33%;"> '.$valu.'</span> <span style="width: 33.33%; float:right;">'.substr($attr,-8).'</span>
</div>'.
'</span>';  break;
case 'butt' : $result.= '<span class="fieldContent boxStyle" style="min-height: 28px;">'.
'<input type= "button" '.  $inpIdNm. $attr. ' value="'.$valu.'" '. $aktiv.
$inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" /> </span>'; break;
case 'colr' : $result.=
'<span class="fieldContent boxStyle" style="height: 28px;">'.
'<input type= "color" '.  $inpIdNm. $attr. ' value="'.$valu.'" '. $aktiv.
$inpStyle. ' margin: 0; padding: 2px; border-radius: 4px;" /> </span>'; break;
case 'phon' : $result.=
'<input type= "tel" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh. $inpStyle. '" />';  break;
case 'pass' : $result.=
'<span class="fieldContent boxStyle" style="'.$bord.' text-align: left; height: 36px;">'.
'<div style="white-space: nowrap;">'.
'<input type= "password" '. $inpIdNm. $attr. ' style="height: 8px; width: 75%; margin-top: -1px;
box-shadow: none;" value="'. $valu.'" '.$eventInvalid. $aktiv. $plh.' onkeyup="getPassword('.$name.')"
/>'.
htm_IconButt($btnlabl='', $btnicon='far fa-eye fa-fw colrgreen',$btnhint= lang('@Show/Hide password'),
$btntype='button', $btnname='tgl_'.$name, $btnlink='',
$btnevnt='onmousedown=\'togglePassword('.$name.','.'tgl_'.$name.')\'', $btnfont='14px;',
$btnfclr='green', $btnbclr='white; padding-right:3px; padding-bottom:1px; margin-top:1px; width:28px;',
$btnakey='', $btnrtrn=true ).
'</div>';
$str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
$result.= '<meter id= "pwPoint'.$name.'" style="position:relative; top:-14px; height:12px; width:100%;" '.
'min="0" low="6" optimum="7" high="9" max="10" '.
'title="'.lang('@Password strength: 0..10').'">'.
'</meter>';
$result.= '</span>';  break;
case 'area' : $result.=
'<span class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 4px; margin: 0 10px;"> <textarea rows="'.$rows.'" id="'.$name.'" name="'.$name.
'" style="width:97%; font-size: 1em; border: 1px solid lightgray; border-radius: 4px; '.$dataStyle.'" '.
$eventInvalid. $aktiv. $plh.' '.$attr.' >'.$valu.'</textarea>'; $top=' top: -8px; ';  break;
case 'html' : $result.=
'<span class="fieldContent boxStyle" style="'.$bord.' top: -20px; padding: 10px 4px 4px;"> <small><div contenteditable="true" rows="'.$rows.'" id="'.$name.'" name="'.$name.
'" style="background-color: white; min-height: '.($rows>'1' ? '34px;' : '5px;').' border: 1px solid lightgray; padding: 2px;" '.
$eventInvalid. $aktiv. $plh.' data-placeholder="'.lang($plho).'" '. $attr.' >'. $valu.'</div></small>';
if ($disa) $result.= '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>'; $top=' top: -8px; '; break;
case 'chck' : $result.=
'<span class="fieldContent boxStyle '.(count($list)== 1 ? 'fieldSingle' : '').'" style="'.$bord.'"><small>';
foreach ($list as $rec) {
$result.= '<span style="display: inline-block">';
$result.= '<input type= "hidden" name="'.$rec[0]. '" value="unchecked" /><label for="'.$rec[0].'"></label>';
$result.= '<input type= "checkbox" name="'.$rec[0]. '" value="checked" '.($rec[3] ?? '').' '.$valu.' style="width: 20px; box-shadow: none;"/>'.
'<label for="'.$rec[0].'" style="position: relative; top: -2px; width: min-content">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; '.$attr).'</label>';
$result.= '</span>';
if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
}  $result.= '</small></span>';  break;
case 'rado' : $result.=
'<span class="fieldContent boxStyle" style="'.$bord.'"><small>';
foreach ($list as $rec) {
if ($valu==$rec[0]) $chk= ' checked '; else $chk= ' ';
$result.= '<input type= "radio" id="'.$rec[0].'" name="'.$name.'" value="'.$rec[0].'" '.
$chk.($rec[3] ?? ''). ' '.$attr.' style="width: 20px; box-shadow: none;">'.
'<label for="'.$rec[0].'" style="position: relative; top: -2px;">'. Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
}  $result.= '</small></span>';  break;
case 'opti' : $result.=
'<span class="fieldContent boxStyle"  style="'.$bord.' background-color; white; text-align: center; padding: 10px 4px 4px;"><small>';
$result.= '<select class="styled-select" id="'.$name.'" name="'.$name.'" '.($events ?? '') .' '.$eventInvalid.'style="width: 98%; border-color: lightgray; '.($valu>'' ? 'font-weight: 600;':'color:var(--grenColr1)').($colr ?? '').'" '.$attr.' '.$aktiv.'> '; dvl_pretty();
$result.= '<option label="'.lang($plho).'" value="'.$valu.'">'.lang('@Select!').'</option> ';
foreach ($list as $rec) {
$result.= '<option '.  'title="'.lang($rec[2] ?? '').'" value="'.$rec[0].'" '.$state=$rec[3] ?? ''.$attr=$rec[4] ?? '';
if ($rec[0]==$valu) $result.= ' selected ';
$result.= '>'.$lbl=lang($rec[1]).'</option> ';
}  $result.= '</select></small></span>';  break;
case 'hidd' : $result.= '<input type= "hidden" id="'.$name.'" name="'.$name.'" value="'.$valu.'" />';  break;
default  : $result.= ' htm_Input(): Illegal Type ! ';
dvl_pretty();
}
switch (strtoupper($llgn)) {
case 'L': $lblalign = 'margin-right:  auto;';  break;
case 'C': $lblalign = 'margin:  auto;';  break;
case 'R': $lblalign = 'margin-left:  auto;';  break;
default:  $lblalign = 'margin-left:  auto;';
}
if ($form>'')
$subm= '<input type="submit" value="OK" style="padding:0 0 0 2px; border-radius: 3px; width:22px; position: relative; left:-13px; color:blue;" title="Submit" />';
if ($type!='hidd')
$result.= ' <abbr class= "hint">'.
($labl>'' ?
'<label for="'.$name.'" style="font-size: 12px; '.$top. '">
<div style="white-space: nowrap; '.$lblalign.'">'.$labl.'</div>
</label>'
: '').
'<data-hint style="top: 45px; left: 2px;">'.lang($hint).($unit>'' ? (' <br>'.lang('@Unit: ').ltrim($unit,'<')) : '').'</data-hint>
</abbr>'.($subm ?? '');
$result.= '</div>';
if ((USEGRID) and ($gbl_GridOn)) $result.= '</div>';
($form=='' ? $result.= '' : $result.= '</form>');
if (!$rtrn) echo $result; else return $result;
}
#$labl='',$style='color:#550000; font-weight:600; font-size: 13px;',$align='',$hint='');
function htm_Caption(
$labl='',
$icon='',
$hint='',
$algn='',
$styl=
'color:#550000; font-weight:600; font-size: 13px;'
) {
if ($algn!='') $algn= ' text-align: '.$algn.';';
echo '<abbr class= "hint">
<data-colrlabl style="'.$styl.$algn.'">'.lang($labl).'</data-colrlabl>';
if ($hint>'') echo '<data-hint> '.lang($hint).' </data-hint>';
echo '</abbr>';
}
function htm_TextDiv(
$body,
$algn='left',
$marg='8px',
$styl=
'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; white-space: nowrap; ',
$attr=
'background-color: white; '
) {
echo '<div style="margin: '.$marg.'; overflow-x: auto; text-align: '.$algn.'; '.$styl.$attr.'">'. lang($body). '</div>';
}
function htm_TextPre(
$body,
$algn='left',
$marg='8px',
$attr='',
$font='',
$code=false
) {
if ($code) $body= htmlspecialchars($body);
if ($font>0) $font= ' font-family: '.$font.'; ';
echo '<pre style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.' white-space: pre-wrap; '.$attr.'">'. $body. '</pre>';
}
function htm_TextVer(
$body,
$algn='left',
$marg='8px',
$attr='',
$font='',
$code=false
) {
if ($code) $body= htmlspecialchars($body);
if ($font>'') $font= ' font-family: '.$font.'; ';
echo '<div style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.'
position: relative;
transform-origin: top left; transform: rotate(-90deg) translate(-30%, 49.5%);
margin: auto; line-height: 1.44; '.$attr.'">'. $body. '</div>';
}
function htm_MiniNote(
$note
)
{  echo '<br><small><small>'.lang($note).'</small></small>';
}
function htm_TextTip(
$capt='TIP',
$body='',
$wdth='',
$algn='center',
$colr=''
)
{
if ($wdth>'') $wdth= ' width:'.$wdth.'; ';
if ($algn=='center') $algn= ' margin: auto; ';
else if ($algn>'') $algn= ' text-align:'.$algn.'; ';
echo '<div style="'.$wdth. $algn.'; border:1px solid gray; ">'.
'<div style="background-color: '.$colr.'; color: '.invertColor($colr,true).';">'.$capt. '</div>'.
'<div style="padding: 8px; ">'.$body.'</div>'.
'</div>';
}
function invertColor($colr,$bw)
{
run_Script("function getHexColor(colorStr) {
var a = document.createElement('div');
a.style.color = colorStr;
var colors = window.getComputedStyle( document.body.appendChild(a) ).color.match(/\d+/g).map(function(a){ return parseInt(a,10); });
document.body.removeChild(a);
return (colors.length >= 3) ? '#' + (((1 << 24) + (colors[0] << 16) + (colors[1] << 8) + colors[2]).toString(16).substr(1)) : false;
}");
}function spool($data,$echo=true) { global $spool;
if ($echo==true) echo $data;
$spool.= $data;
}
function htm_Table(
$TblCapt= array(
),
$RowPref= array(
),
$RowBody= array(
),
$RowSuff= array(
),
$TblNote= '',
&$TblData,
$FilterOn= true,
$SorterOn= true,
$CreateRec=true,
$ModifyRec=true,
$ViewHeight= '400px',
$TblStyle= '',
$CalledFrom=__FILE__,
$MultiList= ['',''],
$ExportTo= ''
)
{ global $gbl_blueColor, $gbl_LineBrun, $gbl_RollTabl, $gbl_HeaderFont, $gbl_IconStyle, $gbl_PanelIx, $gbl_TblIx, $gbl_rowCount, $gbl_novice, $rowHtml, $ordrTotal, $spool;
$spool= '';
$creaInpBg= 'LightYellow';
$gbl_BodyBcgrd= 'yellow';
$selectable= false;
$arrFldkey= [];
foreach ($RowBody as $row) $arrFldkeys[]= $row[5];
$fldNames= $arrFldkeys;
if (DEBUG) dvl_pretty('Start-htm_Table: '.$CalledFrom);
if (!$selectable) $RowSelect= '';
else  { $RowSelect= '<span class="tooltip"><span style="font-size:115%;">&#x21E8;</span>'.
'<span class="LblTip_text" style="bottom: -12px; left: 65px">'.lang('@Selectable: ').str_nl(1).
lang('@This row can be selected by clicking Id/Number in the first field of the row.').'</span></span>';
}
if ($FilterOn)  { $filtInit= ' filter-true '; }  else $filtInit= ' filter-false ';
if ($SorterOn)  { $sortInit= ' sorter-inputs '; } else $sortInit= ' sorter-false ';
if (($FilterOn===true) and ($TblNote===''))
$TblNote= '<small><small>'.lang('@Filtering/Searching: Hold mouse over the colored row below the column headers.').'</small></small>';
$gbl_TblIx++;
$tix= 'T'.$gbl_TblIx;
if (!function_exists('RowKlick')) {
run_Script( 'function rowLookup(CalledFrom,valu,RowIx,ColIx) { window.alert("'.lang('@You pressed ').'" + valu + '.
'"\nNothing is happening yet...\nRelates to: "+ CalledFrom +" Row: "+ RowIx );'.
' }');
function RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$fldNames,$CalledFrom,$ixalign) {
if (!$ModifyRec) {return $RowIx;} else return
'<span style=" padding:3px 0;" onclick="rowLookup(\''.$CalledFrom.'\',\''.$valu.'\',\''.$RowIx.'\',\''.$ColIx.'\')" >'.
'<input name="'.$fldNames[$ColIx].'[]"
style="width:99%; text-align: center; '.$ixalign.' text-decoration: underline; color: blue; cursor:zoom-in; background-color: transparent; font-weight:600;"
readonly
value="'.$valu.'" />'.
'</span>';
};
}
$Width= '98%';
spool( '<span class="tableStyle" name="tblSpan" id="tblSpan" style="width:'.($width ?? '').'; padding: 8px; '.$TblStyle.' ">');
if ($TblData!=null)
if ($TblCapt[0][0] ?? ''>'') {  dvl_pretty();
if ($TblCapt) foreach ($TblCapt as $Capt) {
$mode= '" placeholder="';
spool( ' '.lang($Capt[0]));
switch ($Capt[2]) {
case 'show' : $mode= '" disabled value="';  break;
case 'rows' : spool( count($TblData).' '.lang($Capt[6]));  break;
case 'html' : spool( ' '.lang($Capt[7] ?? ''));  break;
case 'data' : spool( ' <input type= "'.$Capt[2].'" name="'.$Capt[3].'" title="'.lang($Capt[5]).
$mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;'); break;
default:  spool( ' <input type= "'.$Capt[2].'" title="'.lang($Capt[5]).
$mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;');
}
}
if ((count($TblCapt)>1) or ($Capt[1]>"40%")) htm_nl();
if ($gbl_novice==true) {
htm_sp(5);
if ($SorterOn)  {echo $sor= htm_IconButt($type='submit',$faicon='fas fa-sort',$id='',$labl='@Sort?',
$Hint= lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.'),
$link='#',$action='',$akey='','12px'); }
if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-plus',$id='',$labl='@Filter?',
$Hint= lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
lang('@Enter a search term here to display only data that matches the term.'),
$link='#',$action='',$akey='','12px'); }
if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-minus',$id='',$labl='@Show everything!',
$Hint= lang('@Reset filter so that all data is displayed. With ESC you can reset the search term in the field you are in.'),
$link='#',$action='',$akey='','12px'); }
if ($ModifyRec) {echo $ret= htm_IconButt($type='submit',$faicon='fas fa-pen-square',$id='',$labl='@Edit?',
$Hint= lang('@In some of this table`s columns, you can correct data. They are marked with · in the column heading.').str_nl().
lang('@If the table cannot be saved, the correction must be done on a retail card.'),
$link='#',$action='',$akey='','12px'); }
if ($CreateRec) {echo $til= htm_IconButt($type='submit',$faicon='fas fa-plus',$id='',$labl='@Add?',
$Hint= lang('@Do you want to add data: <br>At the bottom of the table there are fields you can fill with new data. ').
lang('@Click the "Create" button above the last field to save the new data.'),
$link='#',$action='',$akey='','12px'); }
if (true)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-arrows-alt-h',$id='',$labl='@Keys ',
$Hint= lang('@Move cursor in tables:').'<br><data-yelllabl>'.lang('@TAB-key').'</data-yelllabl> '.
lang('@jumps to the next field.').' <data-yelllabl>'.lang('@SHIFT TAB-key').'</data-yelllabl> '.lang('@skips to the previous field.').
' <data-yelllabl>'.lang('@SPACE-key').'</data-yelllabl> '.lang('@scrolls side down').
' <data-yelllabl>'.lang('@SHIFT SPACE-key').'</data-yelllabl> '.lang('@scrolls side up').'<br>'.
lang('@The cursor must be in the table.')
,$link='#',$action='',$akey='','12px'); }
}
} dvl_pretty();
echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$ViewHeight.'; display: block;">';
echo '  <div id="overlay'.$gbl_TblIx.'"></div>';
spool( '  <table class="tablesorter" id="table'.$gbl_TblIx.'" style="width:auto; padding:1px; margin:0;">');
spool( '  <thead>');
$filter_cellFilter= [];
$resizable_widths = [];
if ($ExportTo > '') $Export= true; else $Export= false;
if ($Export) $cvrData= '@:';
spool( '  <tr style="height:32px;">');
foreach ($RowPref as $Pref) { dvl_pretty();
spool( '<th class="filter-false sorter-false" style="width:'.$Pref[1].' align:'.$Pref[4][0].'; '.$gbl_HeaderFont.'"> '.
Lbl_Tip($Pref[0],$Pref[5],'SO',$h='0px').' </th>');
$resizable_widths[]= $Pref[1];
}  $cNo= -1;
$hiddcount= 0;
$datCount= 0;
if ($TblData!=null)
if (is_array($TblData[0] ?? '')) $datCount= count($TblData[0]); else $datCount= count($TblData);
$fldCount= count($fldNames);
if ($selectable) spool(  '<th class="filter-false sorter-false" > </th>');
foreach ($RowBody as $Body) { dvl_pretty();
$colfilt= ' ';
$resizable_widths[]= $Body[1];
if (($GLOBALS["Øshow"] ?? ''>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
if ($Export) $cvrData.= '"'.lang($Body[0]).'",';
if ($Body[2]=='hidd')
{ array_push($filter_cellFilter, 'hidden');
$hiddcount++;
spool( '<th class="filter-false sorter-false sortPrefix" style="width:0;" ></th>');
}
else
{ $cNo++; array_push($filter_cellFilter, '');
if (($ModifyRec==true) and (in_array($Body[2],['text','data','date','osta','ddwn']) ))
{ $lblsuff= str_nl().'{'.lang('@Editable').'}'; $label= $Body[0]; }
else { $lblsuff= ''  ; $label= markAllChars($Body[0],'div','style="opacity:0.7; margin: 2px;"'); }
if ($cNo<=1) $tipplc='SO'; else if ($cNo=1) $tipplc='S'; else $tipplc='SW';
if ($cNo==count($RowBody)) $tipplc='SW';
if (
(($fldNames[0]=='ord_id') and ($fldNames[$cNo]=='ord_stat'))
)
$pars= ' filter-parsed ';
else $pars= '';
$sort= $sortInit;
switch ($Body[2]) {
case 'date': $sort.= ' sorter-isoDate '; break;
case 'hidd': $sort= ' sorter-false '; break;
default:  $sort.= ' sorter-text ';
}
if (($Body[6] ?? '') === '@The name of file or directory')
{
if ($Body[4][3] ?? ''===false) $sort= ' sorter-false ';
if ($GLOBALS['goUp'] ?? '' !='')
$goUp= str_WithHint(
$labl='<a href="'.($GLOBALS['goUp'] ?? '').'" target="_self" style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 199;">
<i class="fas fa-chevron-circle-left" style="color: blue; box-shadow: 3px 3px 1px lightgray;"></i></a>',
$hint= '@Go up to parent folder: '.end(explode('/',$GLOBALS['goUp'] ?? '')) );
else $goUp=str_WithHint(
$labl='<span style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 199;">
<i class="fas fa-chevron-circle-left" style="color: lightgray; "></i></span>',
$hint= '@You are at the top-folder ! ');
}
else $goUp='';
spool( '<th class="'. $filtInit. $pars. ($selt ?? ''). $sort. $colfilt.'" data-placeholder= "'.lang('@Filter...').'" style="width:'.$Body[1].'; '.
$gbl_HeaderFont.' text-align:center;">'.$goUp.Lbl_Tip($label,($Body[6] ?? '').$lblsuff,$tipplc,$h='0px').' </th>');
}
}
foreach ($RowSuff as $Suff) { dvl_pretty();
$resizable_widths[]= $Suff[1];
spool( '<th class="filter-false sorter-false" style="width:'.$Suff[1].'; align:'.$Suff[4][0].'; '.$gbl_HeaderFont.'">'.
Lbl_Tip($Suff[0],$Suff[5],'SW',$h='0px').'</th>');
}
spool( '  </tr>');  dvl_pretty();
if ($Export) $cvrData= rtrim($cvrData,',')."\n";
set_Style('','$("#table'.$gbl_TblIx.'").tablesorter({ widgetOptions { filter_cellFilter: ["'.implode('","',$filter_cellFilter). '"]}}');
spool( '  </thead>');
if (false) {
spool( ' <tfoot>');
spool( ' </tfoot>');
}
spool( '  <tbody>');
if (!function_exists('RowBg')) {
function RowBg($clr,$alg,$pos='') { if ($pos>'') $bord= ' border-'.$pos.':3px solid var(--grayColor); '; else $bord= '';
return ' background:'.$clr.'; vertical-align:'.$alg.'; height:1.5em; '.$bord.' '; };
}
$RowIx=-1;
if ($TblData!=null)
if ($TblData)
foreach ($TblData as $DataRow) {
$arrTmp= [];
$rowField= '';
$newRow= '';
$parser= 'headers: {  ';
if (is_array($DataRow))
$DataRow= array_values($DataRow);
$DataNam= array_keys($DataRow);
$RowIx++; dvl_pretty();
if (false)
$extra= 'style= "cursor: alias;" title= "'.lang('@RightClick for table-row MENU').'"';
else $extra= 'style="display: revert;"';
if (count($RowBody)>0)
spool( '<tr class="row" id="tabl_row'.$RowIx.'" '.$extra.'>');
foreach ($RowPref as $Pref) {
if (strpos($Pref[6],'name="')>'') {
$Pref[6]= str_replace('name="','name="i'.$RowIx.'_',$Pref[6]);
$Pref[6]= str_replace('label for="','label for="i'.$RowIx.'_',$Pref[6]);
}
$rowField.= '<td style="width:'.$Pref[1].'; text-align:'.$Pref[4][0].'; ">'.lang($Pref[6]).' </td>';
$newRow.= '<td><div style= "background-color: gray;"> </div></td>';
}
if ($selectable) $rowField.=  '<td style="text-align:right; width:2%;">'.$RowSelect.'</td>';
$optlist= $MultiList;
$ColIx= -1;
$rowHtml= '';
$rowBg= '';
$inpBg= ' background-color:transparent;';
$GotoEdit= ' class="clsFocus" ';
foreach ($RowBody as $Body)
if ($ColDrop ?? ''> 0) { $ColDrop= $ColDrop-1; $ColIx++;}
else
{ $ColIx++;  dvl_pretty();
$SelectList= $Body[9] ?? [];
if (is_array($DataRow[$ColIx])) $valu= $DataRow[$ColIx][0];
else  $valu= $DataRow[$ColIx];
$sortData= ' data-sort= "'. $RowIx.  '" ';
if ($Export) {
if (strlen($valu)>550) $cvrData.= '"'.'To complex ! ('.strlen($valu).')",';
else $cvrData.= '"'.$valu.'",';
}
if (!($GLOBALS["Øshow"] ?? '')>0)
switch ($Body[3]) {
case '0d': if ($valu==null) $valu= 0;  else $valu= number_format((float)$valu, 0,',',' '); break;
case '1d': if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 1,',',' '); break;
case '2d': if ($valu==' ')  $valu= $valu;  else
if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2,',',' '); break;
case '2%': if ($valu==' ')  $valu= $valu;  else
if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2).' %';  break;
case '>0': if (!(float)$valu>0) $valu= ' ';  break;
case '= ': $valu= ' ';  break;
case 'B':  $valu= '<b>#'.sprintf("%'.05d", $valu).'</b>';  break;
case 'R':  $valu= '<font style="color:red;">'.$valu.'</font>';  break;
case 'L':  $valu= '<font style="color:blue;">'.$valu.'</font>'; break;
default:  $valu= $valu;
}
$flag= substr($valu,1,2);
if (($flag=='::') or ($flag==':.')) $valu= substr($valu,2).' ';
if (is_readable('../customRules.inc.php')) include('customRules.inc.php');
$ixalign= $ixalign ?? '';
$captStyle= $captStyle ?? '';
if ($fldNames[0]=='pln_nmbr') {
$fieldHide= false;
if ($DataRow[2]=='Header')  { $rowBg=' background-color: LightSteelBlue; '; $fieldHide= true;}
if ($DataRow[2]=='NewPage') { $rowBg=' background-color: black; '; $fieldHide= true;}
if ($DataRow[2]=='SumFrom')  { $rowBg=' background-color: AntiqueWhite; opacity:70%;'; }
if ($DataRow[2]=='Operation') { $rowBg=' background-color: lightred; opacity:70%;'; }
if ($valu=='') $valu= ' ';
}
if (($fieldHide ?? '' == true) and ($ColIx>1)) { $valu= ' '; $emptyTD= true; } else $emptyTD= false;
if (is_string($Body[4][0] ?? ''))  $txAlign= ' style="text-align:'.($Body[4][0] ?? '').'; '; else $txAlign= '';
if (is_string($Body[4][1] ?? ''))  $bgColor= ' background-color:'. ($Body[4][1] ?? '').'; '; else $bgColor= '';
if (is_string($Body[4][2] ?? ''))  $fltStyl= ' '.  ($Body[4][2] ?? '').' ' ; else $fltStyl= '';
if (is_string($Body[4][3] ?? ''))  $tdColor= ' background-color:'. ($Body[4][3] ?? '').'; '; else $tdColor= '';
if (is_string($Body[4][4] ?? ''))  $txtSize= ' font-size:'.  ($Body[4][4] ?? '').'; '; else $txtSize= '';
if ($MultiList==['','']) { $rowType= ''; $ixalign= ''; }
if (is_array($DataRow))
if ($ColIx<count($DataRow)) {
$rowField.= '<td style="text-align:'.$Body[4][0].'; '.$ixalign.' width:'.$Body[1].'; '.$bgColor.$tdColor.$txtSize.$rowBg.($colsp ?? '');
if ($GLOBALS["Øshow"] ?? ''>0) $Body[2]= 'text';
if ($emptyTD== true) $rowField.= '">'; else
switch ($Body[2]) {
case 'ddwn' : $rowField.= '"'.$sortData.'>'.DropDown($name= $fldNames[$ColIx].'[]', $valu, $list= $SelectList[0], $attr= $SelectList[1].'; ');
$parser.= $ColIx. ': { sorter: "select" }, ';
break;
case 'vars' : $rowField.= '"'.$sortData.'>'.' <div style="margin-right:0; font-size:x-small">'.
'<select class="styled-select" name="liste" style="max-width:120px"> <option value=" " >-';
foreach ($optlist as $rec) {
$rowField.= "\n".'<option label="'.$rec[2].'" value="'.$rec[1].'" '.$rec[3];
if ($rec[1]==$valu) $rowField.= ' selected ';
$rowField.= '>'.$lbl=$rec[2].'</option> ';
}
$rowField.= '</select></div> ';  break;
case 'chck' : $rowField.= '"'.$sortData.'>'.'<input type= "checkbox" name="chck" value="" '.$valu.' ';  break;
case 'bold' : $rowField.= '"'.$sortData.'>'.'<input type= "checkbox" name="bold" value="" '.isbold($valu).' ';  break;
case 'ital' : $rowField.= '"'.$sortData.'>'.'<input type= "checkbox" name="ital" value="" '.isital($valu).' ';  break;
case 'calc' : {
$x= 1;
$sum= (toNum($DataRow[2+$x])*toNum($DataRow[6+$x]))*(100-toNum($DataRow[7+$x]))/100*(100+toNum($DataRow[5+$x]))/100;
$rowField.= '"> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
'value="'.number_format((float)$sum, 2,',',' '). '" placeholder="'.lang($Body[7]).'"'.
$txAlign.$inpBg.' width:98%; " readonly /> '; };
$ordrTotal+= $sum;
break;
case 'date' : if (($valu==' ') ) $clr= 'color: transparent; '; else $clr= '';
$rowField.= '"'.$sortData.'>'.'<input type= "date" name="'.$fldNames[$ColIx].'[]" '.
'style="text-align: left;  max-width: 150px; z-index: auto; '.$clr. $inpBg.
'" value="'.$valu. '" placeholder="yyyy-mm-dd" '.($aktiv ?? '').' />';  break;
case 'html' : $rowField.= '"'.$sortData.'>  '.$valu;  break;
case 'htm0' : $rowField.= '"'.$sortData.'>  '.'<small><small>'.$valu.'</small></small>';  break;
case 'show' : if ($valu==' ') $clr= 'color: transparent; ';
else $clr= '';
$rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
'value="'.$valu. '" placeholder="'.lang($Body[7] ?? '').'"'.
$txAlign.$inpBg.' width:98%; '.$clr.' " readonly /> ';
break;
case 'intg' : $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
'value="'.number_format((float)$valu, 0).
'" placeholder="'.lang($Body[7]).'"'.$txAlign.$inpBg.
' width:98%; padding-left:2px; padding-right:2px;" /> ';
break;
case 'data' :
case 'area' : if ($valu=='New field')  {
$rowField.= '"'.$sortData.'> '.lang('@New field:').' <div style="margin-right:0; font-size:x-small">'.
'<select class="styled-select" name="liste"> <option value=" " >-';
foreach ($ordlist as $rec) {
$rowField.= '<option label="'.$rec[2].'" value="'.$rec[1].'" '.$rec[3];
if ($rec[1]==$valu) $rowField.= ' selected';
$rowField.= '>'.$lbl=$rec[2].'</option> ';
}
$rowField.= '</select></div> ';
} else
$rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
'value="'.htmlentities(stripslashes(lang($valu))).'" placeholder="'.lang($Body[7] ?? '').'"'.
$txAlign.$inpBg.' width:98%; padding-left:2px; padding-right:2px;" /> ';
break;
case 'opti' :{ $rowField.= '"'.$sortData.'><span '.
htm_Input($labl=lang($Body[7]),$plho= '?...',$icon='',$hint=lang($Body[6]),$type='opti',$name= $fldNames[$ColIx],$valu,$form='',$wdth='98%',
$algn='left',$attr='',$rtrn=true,$unit='', $disa=false,$rows='2',$step='',$list=$SelectList,$llgn='R',$bord='border: 1px solid lightgray;',$ftop='')
.' </span>';
}
break;
case 'keyn' :
$rowField.= '"'.$sortData.'><span style="font-size:small"  name="'.$fldNames[$ColIx].'[]" title="'.
lang('@The row is selectable. Click here to edit the row`s fields').'">'.RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$fldNames,$CalledFrom,$ixalign).
'</span>';
break;
case 'indx' :
$rowField.= '"'.$sortData.'><span style="font-size:small;" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.
RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$fldNames,$CalledFrom,$ixalign).' </span>';
break;
case 'blnk' :
$rowField.= '"'.$sortData.'><span name="'.$fldNames[$ColIx].'[]"  > </span>';
break;
case 'hidd' :
$rowField.= 'width:0; padding:0; border:none; display:none;"'.$sortData.'>  <input type= "hidden" name="'.$fldNames[$ColIx].'[]" '.
'value="'.htmlentities(stripslashes(lang($valu))).'" '.$txAlign.$inpBg.' width:0;" /> ';
break;
case 'text' :
case 'sttu' :
{ $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.$valu.'" '.
' placeholder="'.lang($Body[7] ?? '').'"'.$txAlign.$inpBg.$fltStyl.' width:98%; '.$captStyle.'" /> ';
break;
}
default  : { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.$valu.' '.$Body[2].'" '.'placeholder="'.lang($Body[7]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%;" /> ';
}
}
$rowField.= '</td>';
}
if ($Body[2]!='hidd') {
if ($Body[0]=='@Order Date') $currDate= date('Y-m-d'); else $currDate='';
$newRow.= '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].';" >'.
'<input type= "text" '.$GotoEdit.' name="'.$fldNames[$ColIx].'[]" value="'.$currDate.
'" placeholder="'.lang($Body[7] ?? '').'"'.$txAlign.' width: 98%;  background-color: lightyellow; font-style:inherit;" /> </td>';
if (!in_array($Body[2],['show','indx','calc'])) $GotoEdit= '';
}
};
$parser= substr($parser,0,-2).' },';
spool( $rowField);
foreach ($RowSuff as $Suff) { dvl_pretty();
if ($ModifyRec) {
$output= $Suff[6];
if ($Suff[2]=='button') {
$btnStyle= '" class="tooltip" style="height:20px; border:0; box-shadow:none; background-color:transparent;" ';
$btnSuff= $gbl_TblIx.'_'.$RowIx. $btnStyle;
if ($Suff[0]=='@Delete')  { if ($Suff[3]=='dis') $dis= 'disabled'; else $dis= '';
$output='<button type= "submit" name="btn_del_'.$btnSuff.$dis.' >'.
Lbl_Tip($Suff[6],lang('@Delete pos: ').$RowIx.' ('.$dis.')','SW','0px'). '</button>'; }
if ($Suff[0]=='@Hide')  { $output='<button type= "submit" name="btn_hid_'.$btnSuff.'>'.
Lbl_Tip($Suff[6],lang('@Hide pos: ').$RowIx,'SW','0px'). '</button>'; }
if ($Suff[0]=='@Copy')  { $output='<button type= "submit" name="btn_cpy_' .$btnSuff.'>'.
Lbl_Tip($Suff[6],lang('@Copy pos: ').$RowIx,'SW','0px'). '</button>'; }
if ($Suff[0]=='@Rename') { $output='<button type= "submit" name="btn_ren_'.$btnSuff.'>'.
Lbl_Tip($Suff[6],lang('@Rename pos: ').$gbl_TblIx.'_'.$RowIx,'SW','0px'). '</button>'; }
if ($Suff[0]=='@Select') { $output='<input type= "checkbox" name="btn_sel_'.$btnSuff.
Lbl_Tip($Suff[6],lang('@Select pos: ').$RowIx,'SW','0px'). ' />'; }
}
spool( '<td style="text-align:'.$Suff[4][0].'; width:'.$Suff[1].';" disabled >'.$output.'</td>');
}
$newRow.= '<td><div style= "background-color: gray;"> </div></td>';
}
spool( '</tr>');
if ($Export) $cvrData= rtrim($cvrData,',')."\n";
}
$_SESSION["ØrowCount"]['T'.$gbl_TblIx]= $RowIx;
spool( '</tbody>');
spool( '</table>');
spool( '</span>');
if ($Export) {
$fp= fopen($ExportTo,"w");
if ($fp) { fwrite($fp,$cvrData."\n"); fclose($fp); }
}
run_Script("
$('#table".$gbl_TblIx."').tablesorter({
theme: 'blue',"
.($parser ?? '')."
dateFormat : \"Y-m-d\",
widthFixed : true,
widgets: ['zebra', 'cssStickyHeaders', 'filter', 'editable', 'resizable'],
widgetOptions: {
cssStickyHeaders_attachTo : '.wrapper',
cssStickyHeaders_filteredToTop : false,
cssStickyHeaders_offset: 0,
cssStickyHeaders_addCaption : true,
filter_hideFilters : true,
filter_cellFilter : 'tablesorter-filter-cell',
filter_reset : '.reset',
resizable: true".
"
}
});
$.tablesorter.addParser({
id: 'select',
is: function () { return false; },
format: function (s, table".$gbl_TblIx.", cell) {
return ($(cell).find('select').val() || []).join(',') || s; },
});
$.tablesorter.addParser({
id: 'data',
is: function(s, table, cell, Scell) {
return false; },
format: function(s, table".$gbl_TblIx.", cell) {
var Scell = $(cell);
return Scell.attr('data-sort') || s; }
});
");
if ($CreateRec) {
if (!isset($rowField)) $rowField= '';
if (!isset($newRow)) $newRow= '';
$rowField= str_replace('<td','<td style="background-color: lightyellow;" ',$rowField);
$newRow= '`<tr style=" border: 3px solid red;">'.$newRow.'</tr>`';
echo htm_AcceptButt($labl='<i class="fas fa-plus"> </i> '.lang('@Create new row'),$icon='',
$hint='@Create an empty row, so you can fill in data in the yellow fields ! ',
$form='form_'.$gbl_PanelIx.'_'.$gbl_TblIx, $wdth='200px; min-height:16px;',
$attr='', $akey='c', $kind='spc2',$rtrn=false, $tplc='LblTip_NW',
$tsty='position: absolute;  top: 30px; right: 100px;',
$acti='appendRow(table'.$gbl_TblIx.','.$newRow.')');
}
echo '<br>'.$TblNote;
echo '</span>';
if (DEBUG) dvl_pretty('End-htm_Table: '.$CalledFrom);
}function htm_Fieldset_0(
$capt='',$icon='',$hint='',$wdth='',$marg='',$attr='',$rtrn=false)
{
$result=  '
<fieldset style="page-break-after: avoid; display: inline-block; box-shadow: 0 3px 3px #AAAAAA; width: '.$wdth.'; margin: '.$marg.'; border-radius: 6px; ">
<legend style="box-shadow: 0 0 5px #AAAAAA; '.$attr.'">'.str_WithHint($capt,$hint,$icon='').' </legend>';
if (!$rtrn) echo $result;
else return $result;
}
function htm_Fieldset_00(
$rtrn=false)
{  if (!$rtrn) echo '</fieldset>
';
else return '</fieldset>
';
}function htm_Field_0_00(
$labl='',
$body='',
$icon='',
$hint='',
$name='fld',
$wdth='',
$styl='',
$attr='',
$llgn='C',
$rtrn=false,
$ftop=''
){  switch (strtoupper($llgn)) {
case 'L': $lblalign = 'margin-right:  auto;';  break;
case 'C': $lblalign = 'margin:  auto;';  break;
case 'R': $lblalign = 'margin-left:  auto;';  break;
default : $lblalign = 'margin-left:  auto;';
}
$result= '<div class="inpField" id="'.$name.'" style="margin: auto; min-width: 100px; width: '.$wdth.'; top: '.$ftop.
'; display: inline-block; box-shadow:none; '.$attr.'"> ';
$result.= '<div class="boxStyle" style="padding:5px; margin-top:6px; '.$styl.' ">'.$body.'</div>';
$result.= ' <abbr class= "hint">'.
($labl>'' ?
'<label for="'.$name.'" style="font-size: 14px; '.$ftop. '">
<div style="white-space: nowrap; box-shadow: none; border: none;'.$lblalign.'">'.$labl.'</div>
</label>'
: '').
($hint>''? ('<data-hint style="top: 45px; left: 2px;">'.lang($hint).'</data-hint>'):'').'
</abbr>'.($subm ?? '').'
</div>';
if (!$rtrn) echo $result.'
';
else return $result.'
';
}
function htm_Row_0()
{  echo '
<span style="display: inline-block;">';
}
function htm_Row_00()
{  echo '</span>
';
}
function htm_Panel_0(
$capt = '',
$icon = '',
$hint = '',
$form = '',
$acti = '',
$clas = 'panelWmax',
$wdth = '',
$styl = 'background-color: white;',
$attr = '',
$show = true,
$head = ''
)
{
global $gbl_iconColor, $gbl_TitleColr, $gbl_PanlForm, $gbl_ProgRoot, $_assets, $gbl_PanelIx, $gbl_PanelBgrd, $gbl_GridOn;
$gbl_PanelIx++;
echo '<script>';
echo 'function PanelSwitch'.$gbl_PanelIx.'() {
var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
var p = document.getElementById("panel'.$gbl_PanelIx.'");'.
'if (h.style.display === "none")
{ h.style.display = "block";  p.style.width = "";  $("table").trigger("applyWidgets");}
else { h.style.display = "none"; p.style.width = "'.$wdth.'"; }
}';
echo 'function PanelMinimize'.$gbl_PanelIx.'() {
var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
var p = document.getElementById("panel'.$gbl_PanelIx.'");
h.style.display = "none";
p.style.width = "'.$wdth.'";'.
'}';
echo 'function PanelMaximize'.$gbl_PanelIx.'() {
var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
var p = document.getElementById("panel'.$gbl_PanelIx.'");
h.style.display = "block"; '.
'  $("table").trigger("applyWidgets");
}';
echo 'function PanelWide'.$gbl_PanelIx.'() {
var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
var p = document.getElementById("panel'.$gbl_PanelIx.'");
const classes = p.classList;
if (classes.contains("panelWmax")) {
p.classList.remove("panelWmax");
p.classList.add("'.$clas.'");
} else {
p.classList.remove("'.$clas.'");
p.classList.add("panelWmax");'.
'}'.
'}';
echo 'function WrapperHeight'.$gbl_PanelIx.'() {
'.
''.
'}';
echo '</script>';
dvl_pretty('htm_Panel_0');
$gbl_GridOn= false;
if ($capt=='') $Ph= 'height:0px;'; else $Ph= '';
if ($form>'') {
$gbl_PanlForm= true;
$formCrea=  "\n\n".'<form name="'.$form.'" id="'.$form.'" action="'.$acti.'" method="POST" style="margin-block-end: 0;">'."\n";
}
else {$gbl_PanlForm= false; $formCrea= ''; }
$prnHtml= '<ic class="'.$icon.'" style="font-size: 20px; color: '.$gbl_iconColor.'; margin: 0 5px;"></ic> &nbsp;'.ucfirst(lang($capt));
echo '<span class="'.$clas.'" id="panel'.$gbl_PanelIx.'"  style="position: relative; vertical-align: top; margin: 1px; margin-bottom: 8px; '.$styl.' '.$attr.'"> '.
$formCrea.
'<span id="phead'.$gbl_PanelIx.'"  style="display:inline-block; width: calc(100% - 0px); text-align: left; padding: 4px 0;'.$head.'">';
if ($hint=='')  $hint= '@<b>TOGGLE:</b> Click icon or panel header-text to open / close <i>this</i> panel';
echo '<abbr class= "hint">'.
'<span class= "panelTitl" style="'.$Ph.' color:'.$gbl_TitleColr.'; cursor:row-resize; text-align: left; min-height:26px; padding-right:calc(80% - 350px); display:inline;"'.
' onclick= PanelSwitch'.$gbl_PanelIx.'(); > '. $prnHtml. '
</span>
<data-hint>'.lang($hint).' </data-hint></abbr>';
if ($show==true)
echo '<abbr class= "hint">'.
'<ic class="fas fa-arrows-alt-v" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:row-resize; font-size: 14px; " '.
' onclick= PanelSwitch'.$gbl_PanelIx.'(); ></ic>
<data-hint>'.lang('@<b>TOGGLE:</b> Click icon or panel header-text to open / close <i>this</i> panel').' </data-hint></abbr>';
if ($show==true)
echo '<abbr class= "hint">
<ic class="fa-solid fa-right-left" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:col-resize; font-size: 14px; " '.
' onclick= PanelWide'.$gbl_PanelIx.'(); ></ic>
<data-hint>'. lang('@<b>WIDE:</b> Click to maximize/normalize <i>this</i> panel width').'</data-hint></abbr>';
if ($show==true) if (false)
echo '<abbr class= "hint">
<ic class="fa-solid fa-right-left fa-rotate-90" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:s-resize; font-size: 14px; " '.
' onclick= WrapperHeight'.$gbl_PanelIx.'(); ></ic>
<data-hint>'. lang('@<b>HEIGHT:</b> Click to maximize/normalize <i>this</i> View height (Table/WrapperPanel)').'</data-hint></abbr>';
if ($show==true)
echo '<abbr class= "hint">
<ic class="fas fa-angle-double-up" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:zoom-out; font-size: 14px; " '.
' onclick= PanelMinimizeAll(); ></ic>
<data-hint>'. lang('@<b>COLLAPSE:</b> Click to close <i>all</i> panels').';" </data-hint></abbr>';
if ($show==true)
echo '<abbr class= "hint">
<ic class="fas fa-angle-double-down" style="width:12px; height:12px; margin-top:6px; margin-right:0px; float:right; cursor:zoom-in; font-size: 14px; " '.
' onclick= PanelMaximizeAll(); ></ic>
<data-hint>'. lang('@<b>EXPAND:</b> Click to open <i>all</i> panels').';" </data-hint></abbr>';
echo '</span>';
echo '<span id="HideBody'.$gbl_PanelIx.'" style="background:'.$gbl_PanelBgrd.'; transition-duration: 1s;">';
if ($capt > '') if ($head == '') echo '<hr class="style13" style="margin: 0 0 6px 0;"/>';
echo '<div class="pnlContent" style="text-align: center; margin: 8px;">';
return $prnHtml;
}
function htm_Panel_00(
$labl='',
$icon='',
$hint='',
$name='',
$form='',
$subm=false,
$attr='',
$akey='',
$kind='save',
$simu=false
)
{
global $gbl_PanlForm;  dvl_pretty('htm_Panel_00 ');
if ($hint=='') {$hint= '@Remember to save here if you changed anything above, before leaving the window.'; $kind='save';}
echo '</div>';  $prnHtml= '</div>';
if ($gbl_PanlForm)
if ($subm==true) {
echo '<hr class="style13" style= "height:4px;">'.
'<span class="center" style="height:25px">';
htm_AcceptButt($labl, $icon, $hint, $form, $wdth='', $attr, $akey, $kind='button',$rtrn=false);
echo '</span>';
}
echo '</span>'; $prnHtml.= '</span>';
if ($gbl_PanlForm) echo "\n".'</form>'.'<!-- /'.$name.' -->'."\n\n";
echo '</span>'; $prnHtml.= '</span>';
return $prnHtml;
}function PanelInit($panelCount) {
global $PanelState;
echo '<script>
function PanelMinimizeAll() {';
for ($Ix=1; $Ix<=$panelCount; $Ix++) {
echo '
var h = document.getElementById("HideBody'.$Ix.'");
var p = document.getElementById("panel'.$Ix.'");
h.style.display = "none"; ';
}
echo ' }
function PanelMaximizeAll() {';
for ($Ix=1; $Ix<=$panelCount; $Ix++) {
echo '
var h = document.getElementById("HideBody'.$Ix.'");
var p = document.getElementById("panel'.$Ix.'");
h.style.display = "block"; ';
}
echo ' $("table").trigger("applyWidgets"); }
</script>';
}
function getState() {
if (false)
echo 'getState:
<script>
console.log(":getState");
const states = [];
const elements1 = document.querySelectorAll(`[id^="HideBody"]`);
elements1.forEach(element => {
console.log("div.id " + element.id + ".style.display: " + element.style.display);
states.push(element.style.display);
});
console.log(states);
$("#input_hidden_field").val(states);
$.post("", {data: states}).always(function() {  });
$.ajax({
type: "POST",
url: "./getState.json",
data:{ array : JSON.stringify(states) },
success: function(data) {
console.log(data.reply);
alert(data.reply);
}
});
console.log(":END");
</script>';
}
function PanelMin($ix) {
global $PanelState;
echo '<script> PanelMinimize'.$ix.'(); </script>'; $PanelState[$ix]= [$ix,'none'];
}
function PanelMinimize($Last) {
global $PanelState;
echo '<script> ';
for ($ix=0; $ix<=$Last; $ix++) {
echo 'PanelMinimize'.$ix.'(); '; $PanelState[1+$ix]= [1+$ix,'none'];
}
echo '</script>';
}
function PanelInitRange($First,$Last)
{  echo '<script> ';
for ($ix=$First; $ix<=$Last; $ix++) echo 'PanelMinimize'.$ix.'(); ';
echo '</script>';
}
function PanelMax($ix)
{  echo '<script> PanelMaximize'.$ix.'(); </script>';
}
function PanelOff($First,$Last)
{  PanelInitRange($First,$Last);
}
function PanelOn($From,$To=0)
{  if ($To<$From) $To= $From;
for ($ix=$From; $ix<=$To; $ix++) PanelMax($ix);
}
function htm_wrapp_0(
$ViewHeight='400px')
{  echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$ViewHeight.'; display: block;">';
}
function htm_wrapp_00()
{  echo '</span>';
}
function RowColTest($colr)
{  if (DEBUG) return ' style="border: 3px solid '.$colr.';"'; else return '';
}
function htm_RowCol_0(
$wdth=240)
{  dvl_pretty('htm_RowColTop');
echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">'.
'<data-ColnHead'.RowColTest('yellow').'> <span id="colnwrap" '.RowColTest('green').'> '.
'<data-RowCol id="RowCol'.$wdth.'" '.RowColTest('blue').' >';
}
function htm_RowCol_next(
$wdth=320)
{  echo '</data-RowCol> <data-RowCol id="RowCol'.$wdth.'" '.RowColTest('red').'>';
}
function htm_RowCol_00()
{  echo '</data-RowCol> </span></data-ColnHead><span class="clearWrap" >'.
'</div>';
}
function htm_AcceptButt(
$labl='',
$icon='',
$hint='',
$form='',
$wdth='',
$attr='',
$akey='',
$kind='',
$rtrn=true,
$tplc='LblTip_text',
$tsty='',
$acti='',
$idix=''
)
{  global $gbl_ShortKeys;
dvl_pretty('htm_htm_AcceptButt');
$gbl_ButtnBgrd= '#44BB44';  $gbl_ButtnText= '#FFFFFF';
$gbl_BtLnkBgrd= 'yellow';  $gbl_BtLnkText= '#000000';
$gbl_TextLight= 'white';  $gbl_TextDark= 'black';
$gbl_BtDelBgrd= 'Crimson ';  $gbl_BtDelText= $gbl_TextLight;
$gbl_BtSavBgrd= '#0064b4';  $gbl_BtSavText= $gbl_TextLight;
$gbl_BtNavBgrd= '#269B26';  $gbl_BtNavText= $gbl_TextLight;
$gbl_BtGooBgrd= '#66CDAA';  $gbl_BtGooText= $gbl_TextDark;
$gbl_BtNewBgrd= 'Orange';  $gbl_BtNewText= $gbl_TextDark;
$gbl_dimmed=  ' opacity:0.8;';
if ($form>'') {$name= $form; $form=' form="'.$form.'" ';}
else  {$name= '_none'; }
if ($wdth) $wdth= ' width: '.$wdth.';';
if ($icon==='') $iconClass='';
else  $iconClass= '<i class="'.$icon.'"></i>&nbsp;';
$Label= ucfirst(lang($labl));
$keytip='';
if ($gbl_ShortKeys) {
if (!$akey) $keytip=''; else $keytip= '<br><em>'.lang('@Keyboard shortcut: ').$akey.'</em>';
if ($akey>'') { $akey=' ´<i>'.$akey.'</i>´'; $akey= 'accesskey="'.$akey.'" '; } else $akey='';
}
if (strpos($attr,'disabled')>0) $info=' Disabled ! '; else $info='';
switch ($kind) {
case 'save'  : {$colors= ' background:'.$gbl_BtSavBgrd.'; color:'.$gbl_BtSavText.';'.$gbl_dimmed;}  $midn= 'sav_';  break;
case 'navi'  : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;}  $midn= 'nav_';  break;
case 'goon'  : {$colors= ' background:'.$gbl_BtGooBgrd.'; color:'.$gbl_BtGooText.';'.$gbl_dimmed;}  $midn= 'goo_';  break;
case 'eras'  : {$colors= ' background:'.$gbl_BtDelBgrd.'; color:'.$gbl_TextLight.';'.$gbl_dimmed;}  $midn= 'era_';  break;
case 'crea'  : {$colors= ' background:'.$gbl_BtNewBgrd.'; color:'.$gbl_BtNewText.';'.$gbl_dimmed;}  $midn= 'cre_';  break;
case 'home'  : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;}  $midn= 'hom_';  break;
case 'get_'  : {$colors= ' background:'.'BurlyWood'.'; color:'.$gbl_TextDark .';'.$gbl_dimmed;}  $midn= 'get_';  break;
case 'put_'  : {$colors= ' background:'.'CadetBlue'.'; color:'.$gbl_TextDark .';'.$gbl_dimmed;}  $midn= 'put_';  break;
case 'spc1'  : {$colors= ' background:'.'Chocolate'.'; color:'.$gbl_TextLight.';'.$gbl_dimmed;}  $midn= 'spc1';  break;
case 'spc2'  : {$colors= ' background:'.'White'.  '; color:'.$gbl_TextDark .';'.$gbl_dimmed;}  $midn= 'spc2';  break;
default  : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;}  $midn= $labl;
}
if ($acti=='') {$type='submit';} else {$type='button';}
$result=  '<span class="center" style="height:25px;">';
$result.= '<abbr class="hint">';
$result.= '  <button class="acceptbutt buttstyl" '.$form.' type= "'.$type.'" name="btn_'.$midn.$name.'" id="btn_'.$midn.$name.'" '.$attr.
'  style="min-height: 24px; padding-right: 6px; margin-bottom: 6px; '.$wdth. $colors.'" onclick=\''.$acti.'\' '.$akey.'> '.
$iconClass .$Label.
'  </button>';
$result.= '  <data-hint style="'.$tsty.'">'.lang($hint).$keytip.$info.'</data-hint> ';
$result.= '</abbr> ';
$result.= '</span>';
if (!$rtrn) echo $result; else return $result;
}
function htm_ActionButt(
$labl,
$icon='',
$hint='',
$type='button',
$name='',
$form='',
$acti='',
$attr='',
$rtrn=true
)
{ global $ButtName;
$ButtName= $name;
if ($hint>'') {
$s1= '<abbr class= \'hint\'>';
$s2= '  <data-hint>'.lang($hint).'</data-hint>
</abbr>';
} else {$s1=''; $s2='';};
$result= $s1. '
<button class=\'buttstyl\'
type=\''.$type.'\'
id=\''  .$name.'\'
name=\''.$name.'\' '.
($form  >'' ? ' form=\''.$form.'\' ' : '').
($acti>'' ? ' onclick=\''.$acti.'\' ' : '').
$attr.'>
<i class=\''.$icon.'\'> </i> '.lang($labl).
'</button>
'.$s2;
if (!$rtrn) echo $result; else return $result;
}
function htm_IconButt(
$labl='',
$icon='',
$hint='',
$type='submit',
$name='',
$link='',
$evnt='',
$font='32px',
$fclr='gray',
$bclr='white',
$akey='',
$rtrn=false
)
{  global $gbl_ButtnBgrd, $gbl_ShortKeys, $btnix;
dvl_pretty('htm_IconButt');
if ($gbl_ShortKeys) {
if ($akey) $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; else $keytip='';
if ($link=='') $targ= 'formtarget="_self"';
}
$btnix++;
$result = '
<span class="tooltip" style="display:inline; padding:0; ">
<button class="buttstyl" type= "'.$type.'" '.($targ ?? '').' id="'.$name.'" name="btn_ico_'.$btnix.
'" style="color:'.$fclr.'; background:'.$bclr.';" accesskey="'.$akey.'" '.$evnt.'>'.
'<span class="LblTip_text">'.$hint.($keytip ?? '').'</span>'.
' <data-ic class="'.$icon.'" style="font-size:'.$font.'; color:'.$fclr.';  '.$gbl_ButtnBgrd.'; "> </data-ic> '.
lang($labl).
'&nbsp; </button>'.
'</span>';
if (!$rtrn) echo $result;
else return $result;
}
function htm_SwitchButt(
$labl='',
$hint='',
$name='switchbox_id',
$valu='',
$list=[],
$wdth='',
$bclr='',
$styl='',
$rtrn=false
)
{  global $gbl_progZoom;
$yes = lang($list[0]);
$no  = lang($list[1]);
if ($wdth=='') $strWd= (max(strlen($yes),strlen($no))+2).'ch';
else  $strWd= $wdth;
$presssed= 'data-toggle-class="is-pressed"';
$result = '
<'.$gbl_progZoom.'>
<abbr class="hint">
<button type="button" class="switchbox" '.$presssed.' style="width:'.$strWd.
'; --sw-width: '.$strWd.'; --themeColr: '.$bclr.'; '.
';" id="'.$name. '" aria-pressed="'.$presssed.'">
<span class="switchbox-yes">'.$yes.'</span>
<span class="switchbox-no" >'.$no.'<//span>
</button>
<label for="'.$name.'">'.lang($labl).'</label>
';
$result.= '<data-hint>'.lang($hint).'</data-hint>
</abbr>
</'.$gbl_progZoom.'>';
if (!$rtrn) echo $result; else return $result;
}
function htm_SwitchButton(
$labl,
$name='switchbox_id',
$valu='',
$wdth='',
$bclr='',
$styl='',
$hint='',
$list=[],
$rtrn=false
)
{  echo '
<style>
.switch {
position: relative;
display: inline-block;
min-width: 3em;
height: 1em;
padding: .125em;
overflow: hidden;
box-sizing: content-box;
border: 2px solid darkgrey;
outline: none;
border-radius: .75em;
background-color: white;
font-size: 1.25em;
vertical-align: middle;
cursor: pointer;
transition: .15s ease-out;
}
.switch input {
opacity: 0;
width: 0;
height: 0;
}
.slider {
position: absolute;
cursor: pointer;
top: 0;
left: 0;
right: 0;
bottom: 0;
-webkit-transition: .2s;
transition: .2s;
}
.switch-yes {
left: .75em;
color: white;
content: "YES";
font-weight: bold;
opacity: 0;
}
.switch-no {
right: .75em;
color: darkgrey;
content: "NO";
opacity: 1;
}
.switch:hover,
.switch:focus {
border-color: var(--themeColr);
box-shadow: 0 0 .25em var(--themeColr);
}
.switch:hover::before,
.switch:focus::before {
background-color: var(--themeColr);
}
.slider:before {
position: absolute;
content: "";
left: .75em;
width: 1em;
height: 1em;
left: 0.1em;
top: 0.1em;
background-color: white;
-webkit-transition: .2s;
transition: .2s;
}
input:checked + .slider {
background-color: var(--themeColr);
}
input:focus + .slider {
box-shadow: 0 0 1px var(--themeColr);
}
input:checked + .slider:before {
-webkit-transform: translateX(1em);
-ms-transform: translateX(1em);
transform: translateX(1em);
}
.slider.round:before {
border-radius: 50%;
}
</style>
';
$yes = lang($list[0]);
$no  = lang($list[1]);
if ($wdth=='') $strWd= (max(strlen($yes),strlen($no))+2).'ch';
else  $strWd= $wdth;
$result= '
<abbr class="hint">
<small style="vertical-align:middle;">
<label class="switch" style="width:'.$strWd.'; --sw-width: '.$strWd.'; --themeColr: '.$bclr.'; ">
<input type="checkbox" unchecked>
<span class="slider round"></span>
</label>
'.lang($labl).'
</small>
<data-hint>'.lang($hint).'</data-hint>
</abbr>
';
if (!$rtrn) echo $result; else return $result;
}
function htm_MultistateButt(
$name='ROWyCOLx',
$valu='',
$acti=true,
$styl='padding:1px;'
)
{
$Bicon= ['<i class="far fa-square colrgray"  style="'.$styl.'" ></i>',
'<i class="far fa-minus-square colrred"  style="'.$styl.'" ></i>',
'<i class="far fa-check-square colrorange"  style="'.$styl.'" ></i>',
'<i class="far fa-plus-square colrgreen"  style="'.$styl.'" ></i>'
];
$result= '<p style="display: inline;" id="'.$name.'" style="width: 28px; height: 28x;"';
if ($acti==true)
$result.= 'onclick="changeBoxValues(this)" ';
$result.= '>'.$Bicon[$valu].'</p>';
$result.= '<input type="hidden" name="'.$name.'" value="'. $valu.  '">';
if ($acti==true)
run_Script("
function changeBoxValues(mButt) {
var hidden = document.querySelector('[name=\"' + mButt.id + '\"]');
if  (hidden.value == 0)  { hidden.value = 1; }
else if (hidden.value == 1)  { hidden.value = 2; }
else if (hidden.value == 2)  { hidden.value = 3; }
else  { hidden.value = 0; }
setCheckBoxes(mButt, hidden.value);
}
function setCheckBoxes(mButt, value) {
if  (value == 0) { mButt.classList.add(  'colrgray');  mButt.innerHTML = '<p>".$Bicon[0]."</p>'; }
else if (value == 1) { mButt.classList.replace('colrgray'  ,'colrred');  mButt.innerHTML = '<p>".$Bicon[1]."</p>'; }
else if (value == 2) { mButt.classList.replace('colrred'  ,'colrorange'); mButt.innerHTML = '<p>".$Bicon[2]."</p>'; }
else  { mButt.classList.replace('colrorange','colrgreen');  mButt.innerHTML = '<p>".$Bicon[3]."</p>'; }
}
");
return $result;
}
function htm_Tabs_0(
$head='',
$styl='',
$rtrn=false
)
{  $GLOBALS['TabLabl']='<div class="tab">';
$GLOBALS['TabBody']='';
$result= '
<div style="'.$styl.'">'.
$head.
'</div>';
if (!$rtrn) echo $result; else return $result;
}
#$name, $labl='', $body='', $bclr='white', $style='text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;')
function htm_Tab(
$labl='',
$body='',
$name='',
$styl=
'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;',
$bclr='white'
)
{  $b= 'small';
$GLOBALS['TabLabl'].= '
<button class="tablinks" type="button" title="'.lang('@Show the Tab-content').'"
onclick="openTab(event, \''.$name.'\')"
style="background-color:'.$bclr.';border-bottom-color: '.$bclr.'; "><'.$b.'>'.lang($labl).'</'.$b.'></button>';
$GLOBALS['TabBody'].= '
<div id="'.$name.'" class="tabcontent" style="display: none; background-color:'.$bclr.'; '.$styl.' border-right: 2px solid #aaa;">'. lang($body).'</div>';
}
function htm_Tabs_00(
$foot='',
$styl='',
$rtrn=false
)
{  $result=
$GLOBALS['TabLabl'].'<span style="float:right;" title="'.lang('@Hide the Tab-content').'" onclick="closeTabs()"><i class="far fa-window-close"></i>&nbsp;<span> </div>'.
$GLOBALS['TabBody'];
if ($foot>'') $result.= '<span style="'.$styl.'">'.lang($foot).'</span>';
if (!$rtrn) echo $result; else return $result;
}
function htm_LinkButt(
$labl='',
$hint='',
$attr='',
$link='',
$targ='_blank',
$rtrn=false
)
{  $result= '<span '.$attr.'><a class="button" href="'.$link.'" target="'.$targ.'" title="'.lang($hint).'">'.lang($labl).'</a></span>';
if (!$rtrn) echo $result; else return $result;
}
function htm_TextArea(
$labl='',
$hint='',
$name='area',
$form='',
$valu='',
$rows='1',
$widt='',
$plho='?',
$attr='',
$rtrn=true
)
{
$result= '<textarea rows= \''.$rows.'\' id= \''.$name.'\' name= \''.$name.'\' form=\''.$form.'\' placeholder= \''.lang($plho).
'\' style= \'width:'.$widt.'; font-size: 1em; border: 1px solid lightgray; border-radius: 4px; margin-top: 10px; '.$attr.'\'>'.$valu.'</textarea>';
if ($hint > '')
$result.= '<abbr class= \'hint\'>'. lang($labl).'<data-hint>'.lang($hint).'</data-hint></abbr>';
else
$result.= lang($labl).$result;
if (!$rtrn) echo $result; else return $result;
}
function str_WithHint(
$labl='',
$hint='',
$icon='')
{
if ($icon>'') $icon= '<i class="'.$icon.'"></i>&nbsp;'; else $icon= '';
if ($hint>'') return '<abbr class= "hint">'.$icon.lang($labl).'<data-hint>'.lang($hint).'</data-hint></abbr>';
else  return $icon.lang($labl);
}function htm_ModalDialog(
$type='none',
$capt='@Voilà!',
$mess='',
$butt=['$type','$icon','$labl','$hint','$link'],
$html='CSS-based Modal Dialog',
$rtrn=true
)
{
global $cssButt;
$css_Box= [
'none' => ['black',  'whitesmoke;', '@Default' ,'<i class="far fa-thumbs-up"></i>'],
'info' => ['darkgrey', '#f1f1f1;',  '@Info'  ,'<i class="fas fa-info"></i>'],
'mess' => ['darkgrey', '#f1f1f1;',  '@Info'  ,'<i class="fas fa-info"></i>'],
'hint' => ['blue',  'lightcyan;',  '@Hint'  ,'<i class="far fa-flag"></i>'],
'succ' => ['green',  '#DFF2BF;',  '@Succes'  ,'<i class="fas fa-check"></i>'],
'acce' => ['green',  '#DFF2BF;',  '@Accept'  ,'<i class="fas fa-question"></i>'],
'warn' => ['orange',  '#FEEFB3;',  '@Warning' ,'<i class="fas fa-exclamation-triangle"></i>'],
'erro' => ['red',  '#FFD2D2;',  '@Error'  ,'<i class="fas fa-exclamation"></i>']
];
$cssButt= [
'info' => ['fas fa-info',  '@Info',  '@To inform you',  '#'],
'mess' => ['fas fa-info',  '@Message',  '@To inform you',  '#'],
'hint' => ['fas fa-flag',  '@Hint',  '@To inform you',  '#'],
'succ' => ['fas fa-check',  '@Succes',  '@To inform you',  '#'],
'acce' => ['fas fa-question',  '@Confirm',  '@Your choice',  '#'],
'warn' => ['fas fa-exclamation-triangle', '@Warning',  '@Message to warn you', '#'],
'erro' => ['fas fa-exclamation',  '@Error',  '@Critical message !',  '#'],
'clos' => ['fas fa-close',  '@Close',  '@Close the window',  '#']
];
if ($butt==['$type','$icon','$labl','$hint','$link']) $butt=['clos'];
$arrButtons= [];
foreach ($butt as $bt) $arrButtons[]= [$bt[0] => [$bt[1] ?? '',$bt[2] ?? '',$bt[3] ?? '',$bt[4] ?? '']];
if (!function_exists('notEmpty')) {
function notEmpty($type,$bo,$ix) { global $cssButt;
if ($bo=='') return $cssButt[$type][$ix];
else return $bo;
}}
if (!function_exists('in_array_r')) {
function in_array_r($needle, $haystack, $strict = false) {
foreach ($haystack as $item) {
if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
return true; } }
return false;
}}
$result = '<div> <a href="#open-modal_'. (string)(($GLOBALS['Mcount'] ?? 0)+1). '">'.$html.'</a> </div>
<div id="open-modal_'. ($GLOBALS['Mcount'] ?? 0).'" class="modal-window" >
<div style="border: 4px solid '.$css_Box[$type][0].';">';
if (in_array_r('clos',$butt))
$result.= '<a href="#" title="Close" class="modal-close"><i class="fas fa-times"></i>&nbsp;Close</a>';
$result.=  '
<b><h3  id="header" style="background-color: '.$css_Box[$type][1].';">'.lang($capt).'</h3></b>
<div id="message">'.
lang($mess).  '
</div>
<div id="footer">';
foreach ($arrButtons as $bton)
foreach ($bton as $bt) {
$key= strtolower(key($bton));
switch ($key) {
case 'clos' : break;
case 'info' : case 'mess' : case 'hint' : case 'succ' : case 'acce' : case 'warn' :
case 'erro' : $result.=  '<a  href="'.notEmpty($key,$bt[3],3).
'"  title="'.lang(notEmpty($key,$bt[2],2)).
'"  style="background-color: '.$css_Box[$key][1]. ';" class="btnlabl">'.
'<i class="'.notEmpty($key,$bt[0],0).'"></i>&nbsp;'.lang(notEmpty($key,$bt[1],1)).'</a>'; break;
default: $key='none'; $result.=  '<a href="" title="Confirm'.
'" style="background-color: '.$css_Box[$key][1].';" class="btnlabl">'.
$css_Box[$key][3].'&nbsp;'.$css_Box[$key][2].'</a>';
} $result.=  '&nbsp;'; }
$result.=  '
</div>
</div>
</div>';
if (!$rtrn) echo $result; else return $result;
}
function htm_Dialog(
$capt='CAPTION',
$content='',
$bclr='lightyellow',
$buttons= [ ['confirmBtn','default','@Confirm','fas fa-check','green','@Accept and go on'],
['',  'cancel', '@Cancel', 'fas fa-minus-circle','red','@Break and return']
]
)
{  $result= '<dialog id="htmDialog" style="padding:5px; background-color:lightcyan; border-radius: 6px;">
<form method="dialog">
<div style="background-color:'.$bclr.'; padding:4px;">'.lang($capt).'</div>
<p>'.lang($content).'</p>'.
'<menu style="padding-inline-start: 40px; padding-inline-end: 40px;">';
foreach ($buttons as $butt) {
$iconClass= $butt[3];
$icon= '<ic class="'.$butt[3].'" style="font-size: 16px; color: '.$butt[4].';"></ic>&nbsp;';
$result.= '<button id="'.$butt[0].'" value="'.$butt[1].'" title="'.lang($butt[5]).'" style="padding: 3px 5px;">'.$icon.lang($butt[2]).'</button>&nbsp;';
}
$result.= '</menu>
</form>
</dialog>
<menu style="padding-inline-start: 40px; padding-inline-end: 40px;"> <button id="startDialog">Test Modal Dialog</button> </menu>
<output aria-live="polite"></output>';
echo $result;
run_Script("
var htmDialog = document.getElementById('htmDialog');
var updateButton = document.getElementById('startDialog');
updateButton.addEventListener('click', function onOpen() {".
"  if (typeof htmDialog.showModal === \"function\") { htmDialog.showModal(); }
else { alert(\"The <showModalDialog> API is not supported by this browser\"); }
});
var confirmBtn = document.getElementById('confirmBtn');
var selectEl = document.querySelector('select');
selectEl.addEventListener('change', function onSelect(e) {".
"  confirmBtn.value = selectEl.value;
});
var DialogBox = document.querySelector('output');
htmDialog.addEventListener('close', function onClose() {".
"  DialogBox.value = htmDialog.returnValue + \" button clicked - \" + (new Date()).toString();
});
");
return $result;
}function msg_Dialog($type='error', $caption='@User Dialog', $mess='', $Buttons= [
['@Confirm', '@Hint', '$(this).dialog("close")', 'Icon', true ],
['@Close',  '@Hint', '$(this).dialog("close")', 'Icon', false]
])
{
$result= false;
if ($mess=='') $mess='<p>This is a CSS based modal dialog, which can be used to display information. '.
'The window can be moved and stretched, as well as closed with the \'x\' icon. <br>'.
'<br>The buttons below can be programmed, with optional code.</p>';
switch (strtolower($type)) {
case "error"  : $headColr= '#FF8888'; $pref= ucfirst(lang('@Error: ')); break;
case "info"  : $headColr= '#BDE5F8'; $pref= ucfirst(lang('@Info: '));  break;
case "warn"  : $headColr= '#FEEFB3'; $pref= ucfirst(lang('@Warn: '));  break;
case "tip"  : $headColr= '#88ff22'; $pref= ucfirst(lang('@Hint: '));  break;
case "success": $headColr= '#DFF2BF'; $pref= ucfirst(lang('@Bingo: ')); break;
default  : $headColr= $type;  $pref= '';
}
echo '<style type="text/css">'.
'  .ui-dialog .ui-dialog-titlebar  { background: '.$headColr.'}'.
'  .ui-dialog .ui-dialog-buttonpane  { background: '.$headColr.'}';
echo '  .ui-dialog  { width: 320px; margin: auto; position: fixed; top: 20%;  left: 0px; right: 0px; -moz-box-shadow: 0px 0px 8px #000000; -webkit-box-shadow: 0px 0px 8px #000000; box-shadow: 0px 0px 8px #000000;}'.
'  ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close  {width: 20px; title: "'.lang('@Close').'";}'.
'  .ui-button  {padding: 2px 8px};}';
echo '</style>';
echo '  <script>';echo '  $( document ).ready( function() {  $( "#dialog-message" ).dialog ({';
echo '  position: "fixed", top: "320px",';
echo '  modal: true,';
echo '  buttons: {';
foreach ($Buttons as $butt)
echo ' "'. str_replace(' ','_',lang($butt[0])).'": function() {'.$butt[2].';},';
echo '  }';
echo '  }); });';
echo '  </script>';
echo '<div id="dialog-message" title="'.$pref.lang($caption).'"> '.lang($mess).' </div>';
return $result;
}function msg_Error($title='Error',  $messg='Message')
{
msg_System($MsgType= 'error', $title,  $reason='', $messg, $actions=['','goon','close']);
}
function msg_Info($title='Info',  $messg='Message')
{
msg_Dialog('info',  lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));
}
function msg_Warn($title='Warning', $messg='Message')
{
$str= '<br>'.  lang($messg);
msg_System($MsgType= 'warn', $title,  $reason=' ', $messg=$str, $actions=['','goback','close']);
}
function msg_Hint($title='Tip',  $messg='Message')
{
msg_System($MsgType= 'tip', $title,  $reason=$title, $messg, $actions=['','','close']);
}
function msg_Succ($title='Hurray',  $messg='Message')
{
msg_System($MsgType= 'success', $title='',  $reason='', $messg, $actions=['','','close']);
}function msg_System($MsgType= 'error', $title='',  $reason='', $messg='', $actions=['goback','goon','close'], $wdh='600px', $hgt='150px')
{
$result= false;
$title=  ucfirst(lang($title));
$reason= ucfirst(lang($reason));
$messg=  ucfirst(lang($messg));
if ($title=='')  $title= 'PHP2HTML - ';
if ($reason=='')  $reason='<p>Info about the system.</p>';
if ($messg=='')  $messg='<p>This is a CSS based modal dialog independent of jquery that can be used to display information. '.'<br>'.
'The window can be closed with the \'x\' icon, or by clicking anywhere outside the window. <br>'.
'<br>The buttons in the footer can be programmed, with optional code.</p>';
switch (strtolower($MsgType)) {
case "error"  : $headColr= '#FF8888';
$pref= ucfirst(lang('@Error: '));
$Capt1= '<div style="font-weight:600;">'.lang('@Tracking').':</div>';
$Capt2= '<div style="font-weight:600;">'.lang('@Explanation').':</div>';
break;
case "info"  : $headColr= '#BDE5F8';
$pref= ucfirst(lang('@Info: '));
break;
case "warn"  : $headColr= '#FEEFB3';
$pref= ' '.ucfirst(lang('@Warning: '));
$Capt1= '<div style="font-weight:600;">'.lang('@Oops').':</div>';
break;
case "tip"  : $headColr= '#88ff22';
$pref= ucfirst(lang('@Tip: '));
$title='';
break;
case "success": $headColr= '#DFF2BF';
$pref= ucfirst(lang('@Hurray: '));
break;
default:  $headColr= $MsgType; $pref= '';
}
echo '<label class="button demo-button" for="open-modal"> </label>';
echo '<div class="modal__container">';
echo '  <input type="checkbox" id="open-modal" class="modal__toggler" checked />';
echo '  <label class="modal__mask" for="open-modal"></label>';
echo '  <div class="modal" style="width: '.$wdh.';  ">';
echo '  <label class="modal__close" for="open-modal"></label>';
echo '  <div class="modal__header" style="background-color: '.$headColr.';">';
echo '  <h3 style="margin:8px;">'.$title.$pref.'</h3>';
echo '  </div>';
echo '  <section class="modlwrap">';
if ($reason>' ')  echo '<div class="modal__content" style="width:33%; background:lightcyan;  ">'.$Capt1.'<samp><small>'.$reason.'</small></samp>'.'<br><br></div>';
echo '  <div class="modal__content" style="width:67%; background:lightyellow;">'.$Capt2.'<var>'.$messg.'</var>'.'<br><br></div>';
echo '  </section> ';
echo '  <div class="modal__footer" style="background-color: '.$headColr.';">';
if (in_array('goback',$actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Close the window and return to the previous screen').'">'.lang('@Undo').' </label>';
if (in_array('goon',  $actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Close the message-window and continue').'">'.lang('@Continue').' </label>';
if (in_array('accept',$actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Confirm and continue').'">'.lang('@Accept').' </label>';
if (in_array('close', $actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Close the window!').'">'.lang('@Close')  .' </label>';
echo '  </div>';
echo '  </div>';
echo '</div>';
return $result;
}function Pmnu_0(
$elem='id',$capt='',$wdth='210px',$icon='',$stck='false',$attr='background-color:lightcyan;',$cntx=true,$rtrn=false)
{
$result= "
<script>
let ".$elem." = document.getElementById(\"".$elem."\"); ";
if ($cntx == true)
$result.= "
".$elem.".addEventListener('contextmenu',
event => {
event.preventDefault();
else $result.= $elem.".addEventListener('click', () => {
$result.= "
new ctxP_({
isSticky: ".$stck.",
width: '".  $wdth. "',
items: [
";
if ($capt>'') $result.= '{label: "'.lang($capt).'", hint: "Just an informative Caption", cssicon: "'.$icon.'", custAttr: "'.$attr.'"},
{type: "separator"},';
if (!$rtrn) echo $result; else return $result;
}function Pmnu_Item(
$labl='',$icon='',$hint='',$type='plain',$name='',$clck='',$attr='',$akey='',$enbl='true',$rtrn=false)
{
$result= '
{label: "'.lang($labl).'", hint: "'.lang($hint).'", cssIcon: "'.$icon.'"';
switch ($type) {
case 'plain'  : $result.= ', shortcut: "<small>'.$akey.'</small>", id:"'.$name.'", name:"'.$name.'", onClick: () => {"'.$clck.'"} '; break;
case 'custom'  : $result.= ', shortcut: "'.  $akey.'", id:"'.  $name.'", name:"'.$name.'", onClick: () => {"'.$clck.'"} '; break;
case 'hovermenu': $result.= ', type: "hovermenu", items: [';  break;
case 'submenu'  : $result.= ', type: "submenu", items: [';  break;
case 'subitem'  : $result.= ', type: "subitem", onClick: () => {'.$clck.'}},';  break;
case 'multi'  : $result.= ', type: "multi", items: [';  break;
case 'end_sub'  : $result = ']},';  break;
case 'separator': $result.= ', type: "separator"';  break;
case 'footer'  : $result.= "";  break;
default  : $result.= 'Type parameter ERROR: '.$type;
}
if (!in_array($type,['multi','hovermenu','submenu','subitem','end_sub']))
$result.= '},';
if (!$rtrn) echo $result; else return $result;
}
function Pmnu_00(
$labl='',
$hint='',
$attr='',
$rtrn=false
)
{
$result= '
{' . ($attr > '' ? ('custAttr: "'.$attr.'", ') : '')
.'label: "'. lang($labl).'", hint: "'.lang($hint). '" '
.
'}'.
"
]
});
});
</script>
";
if ($rtrn) return $result; else  echo $result;
}
function htm_Page_0(
$titl='',
$hint='',
$info='',
$inis='',
$algn='center',
$gbl_Imag='',
$attr='',
$gbl_Bord=true
)
{
global $gbl_ProgRoot, $CSS_system, $gbl_TitleColr, $panelCount, $gbl_Bord,$gbl_progZoom, $jsScripts;
$pageMess= '<b>ERROR:</b> ';echo '
<!DOCTYPE html>
<html lang="da" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="Noindex, Nofollow">'.
'<title>'.lang($titl).'</title>'. "\n";
dvl_pretty('htm_Page_0');
if (defined('LIB_POLYFILL')) {
switch(LIB_POLYFILL[0]) {
case 0 : $path= '';  break;
case 1 : $path= $gbl_ProgRoot.LIB_POLYFILL[1];  break;
case 2 : $path=  LIB_POLYFILL[2];  break;
default : { $pageMess.= 'LIB_POLYFILL: illegal index ! '; }
}
if ($path > '') {
echo '<script  src="'.$path.'dialog-polyfill.min.js"></script>';
echo '<link rel="stylesheet" href="'.$path.'dialog-polyfill.min.css"/>';
run_Script("var dialog = document.querySelector('dialog');
dialogPolyfill.registerDialog(dialog);
dialog.showModal(); ");
run_Script("function phpDialog(capt='CAPTION', content='Content')
{ var result= <?= htm_Dialog(capt, content); ? > return result; }");
}
} else
{ define('LIB_POLYFILL', [0, '', '']); $pageMess.= ' dialog-polyfill is not loaded  ! <br>'; }
if (defined('LIB_JQUERY')) {
switch(LIB_JQUERY[0]) {
case 0 : $path= '';  break;
case 1 : $path= $gbl_ProgRoot.LIB_JQUERY[1];  break;
case 2 : $path=  LIB_JQUERY[2];  break;
default : { $pageMess.= 'LIB_JQUERY: illegal index ! '; }
}
if ($path > '') {
echo '<script src="'.$path.'jquery.min.js"></script>';
}
} else
{ define('LIB_JQUERY', [0, '', '']); $pageMess.= ' jQuery is not loaded  ! <br>'; }
if (defined('LIB_JQUERYUI')) {
switch(LIB_JQUERYUI[0]) {
case 0 : $path= '';  break;
case 1 : $path= $gbl_ProgRoot.LIB_JQUERYUI[1];  break;
case 2 : $path=  LIB_JQUERYUI[2];  break;
default : { $pageMess.= 'LIB_JQUERYUI: illegal index ! '; }
}
if ($path > '') {
echo '<script src="'.$path.'jquery-ui.min.js"></script>';
}
} else
{ define('LIB_JQUERYUI', [0, '', '']); $pageMess.= ' jQuery-ui is not loaded  ! <br>'; }
if (defined('LIB_TABLESORTER')) {
if (array_key_exists(0, LIB_TABLESORTER))
if (LIB_TABLESORTER[0]>0) {
if (LIB_TABLESORTER[0]==1)  $path= $gbl_ProgRoot.LIB_TABLESORTER[1];
else  $path=  LIB_TABLESORTER[2];
echo '<script src="'.$path.'js/jquery.tablesorter.min.js"></script>';
echo '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.min.js"></script>';
echo '<script src="'.$path.'js/parsers/parser-input-select.min.js"></script>';
echo '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>';
echo '<link  href="'.$path.'css/theme.blue.min.css" />';
}
}
else {$path= $gbl_ProgRoot.'_assets/tablesorter/';echo '<script src="'.$path.'js/jquery.tablesorter.js"></script>';echo '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.min.js"></script>';
echo '<script src="'.$path.'js/parsers/parser-input-select.min.js"></script>';
echo '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>';
echo '<link rel="stylesheet" href="'.$path.'css/theme.blue.css"/>';
}
$lateScripts= '';if (!(defined('LIB_FONTAWESOME[0]') && array_key_exists(0, LIB_FONTAWESOME) && (LIB_FONTAWESOME[0]==0) ))
$jsScripts.= "
<script>
$(function () {
$('#table').tablesorter({
theme: 'blue',
dateFormat : \"Y-m-d\",
widthFixed : true,
widgets: ['zebra', 'stickyHeaders', 'filter', 'editable', 'resizable'],
widgetOptions: {
stickyHeaders: '',
stickyHeaders_offset: 0,
stickyHeaders_cloneId: '-sticky',
stickyHeaders_addResizeEvent: true,
stickyHeaders_includeCaption: true,
stickyHeaders_zIndex: 2,
stickyHeaders_attachTo: '.wrapper',
stickyHeaders_xScroll: null,
stickyHeaders_yScroll: null,
stickyHeaders_filteredToTop: true,
filter_hideFilters : true,
filter_cellFilter : 'tablesorter-filter-cell',
filter_reset : '.reset',
filter_functions: {
0: {
'{empty}' : ".'function (e, n, f, i, $r, c) {'."
return $.trim(e) === '';
}
},
storage_storageType: 's',
resizable_addLastColumn : true,
},
filter_selectSource: {
0: function (table, column, onlyAvail) {
var array = $.tablesorter.filter.getOptions(table, column, onlyAvail);
array.push('{empty}');
return array;
}
}
}
});});
$(\"table\").bind(\"sortStart\", function() {
$(\"#overlay\").height($(this).outerHeight()).show();
}).bind(\"sortEnd\", function() {
$(\"#overlay\").hide();
});
$(function() {
window.includeCaption = true;
$('.caption').on('click', function() {
includeCaption = !includeCaption;
$(this).html( '' + includeCaption );
$('#table0,  #table2, #table3, #table4, #table5, #table6, .nested').each(function() {
if (this.config) {
this.config.widgetOptions.stickyHeaders_includeCaption = includeCaption;
this.config.widgetOptions.".'$sticky'.".children('caption').toggle(includeCaption);
}
});
});
$('link.theme').each(function() { this.disabled = true; });
});
".'function appendRow(tableID, row_html) {
$(tableID).find("tbody").append(row_html).trigger("update");
$(".clsFocus:last").focus();
};
$(".plusbtn").click(function() {
alert("The clone botton was clicked.");
var $table= $(this).closest("table");
var clone = $("$table .row:first").clone().appendTo("$table");
if (confirm("'.lang('@Insert copy as the last row, a copy of 1. row ?').'") == true) {
$(".txtbox", clone);
}
});
function removeRow() {'.'
if (confirm("'.lang('@Are You Sure to Remove This Row?').'") == true) {
var $this = $(this);
$(this).closest("tr").remove();
}
};
$(\'#ButtRowDelete\').click(function() {
});
function restoreTable() {
var original = $("table").html();
$("#restore").click(function() {
$("table").html(original);
return false;
});
};
function remove(rowId){
$("#" + rowId).remove();
};
function getPassword(input) {
var text =  document.getElementById(input.id).value;
var point =  document.getElementById("pwPoint"+input.id).value;
point = 0;
if ( text.length >= 6 )  {point += 1};
if ( text.length >= 8 )  {point += 1};
if ( text.length >= 10 )  {point += 2};
if ( text.length >= 12 )  {point += 2};
if (/[a-zæøå]/.test(text) ) {point += 1};
if (/[A-ZÆØÅ]/.test(text) ) {point += 1};
if (/[0-9]/.test(text) )  {point += 1};
if (/[~`!@#$£€¤%?()\^&*+=\-\[\]\\\';,/{}|\\":<>\?]/g.test(text) ) {point += 1};
document.getElementById("pwPoint"+input.id).value = point;
}
'.
"  function togglePassword(input,butt) {
var passInput = document.getElementById(input.id);
var togglePW  = document.getElementById(butt.id);
if (passInput.type  == 'password')
{ passInput.type = 'text';  togglePW.innerHTML = '<i class=\'far fa-eye-slash fa-fw colrred\'>'; } else
{ passInput.type = 'password';  togglePW.innerHTML = '<i class=\'far fa-eye fa-fw colrgreen\'>'; }
}
".
'  $(".hint").on( "mouseenter", function() {
var $this = $(this);
var hint = $(this).find(".data-hint");
var offset = $this.offset();
hint.toggleClass("top", $(window).height() + hint.height() < 0);
hint.color = "red";
}
);
'.
"  function updateInput(fieldname,ish){
document.getElementById(fieldname).value = ish;
}
</script>";
run_Script("
const allRanges = document.querySelectorAll(\".range-wrap\");
allRanges.forEach(wrap => {
const range = wrap.querySelector(\".range\");
const bubble = wrap.querySelector(\".bubble\");
range.addEventListener(\"input\", () => { setBubble(range, bubble); });
setBubble(range, bubble);
});
function setBubble(range, bubble) {
const val = range.value;
const min = range.min ? range.min : 0;
const max = range.max ? range.max : 100;
const pctVal = Number(((val - min) * 100) / (max - min));
bubble.innerHTML = min + '..' + '<b>' + val + '</b>' +'..' + max;
".
"
}
");
$popScripts= "
<style>
.colrred  {color: red;}
.colrgreen  {color: green;}
.colrblue  {color: blue;}
.colrcyan  {color: cyan;}
.colrbrown  {color: brown;}
.colryellow {color: yellow;}
.colrorange {color: orange;}
.colrgold  {color: gold;}
.colrblack  {color: black;}
.colrgray  {color: gray;}
.bgclwhite  {background-color: white;}
.bgclgray  {background-color: gray;}
.bgclblack  {background-color: black;}
.bgclgold  {background-color: gold;}
.font14  {font-size: 14px;}
.font16  {font-size: 16px;}
.font18  {font-size: 18px;}
.bold  {font-weight: bold;}
li:hover{
color:black;
font-weight: bold;
}
.synt {
display: block;
overflow-x: auto;
padding: 0.5em;
background: rgb(44, 44, 44);
color: rgb(0, 25, 58);
text-align:left;
}
.synt-variable  {color: Tomato;  }
.synt-string  {color: lightgreen; }
.synt-attribute {color: red;  }
.synt-comment  {color: rgb(174,174,174); }
.synt-literal  {color: red;  }
.synt-constant  {color: cyan;  }
.synt-operator  {color: yellow;  }
.synt-word  {color: blue;  }
.synt-number  {color: lightgreen; }
.synt-default  {color: white;  font-weight: bold; }
.buttbord {
border-style: solid;
border-color: gray;
border-width: 1px;
margin: 5px;
padding: 3px 6px;
}
.buttstyl {
background-color: rgb(239, 239, 239);
text-decoration: none;
font-size: ".$gbl_progZoom.";
border-radius: 8px;
border-width: 2px;
margin: 4px 4px 0 0;
padding: 4px 0px 2px 4px;
}
</style>
<style>
.tab {
overflow: hidden;
background-color: #f1f1f1;
border-top: 2px solid #aaa;
border-right: 2px solid #aaa;
border-bottom: none;
}
.tab button {
background-color: inherit;
float: left;
border: 2px solid #aaa;
border-radius: 0 10px 0 0;
outline: none;
cursor: pointer;
padding: 6px 16px;
transition: 0.2s;
font-size: 17px;
}
.tab button:hover {
background-color: white;
border-radius: 0 10px 0 0;
}
.tab button.active {
background-color: #fff;
border: 2px solid #aaa;
border-radius: 0 10px 0 0;
}
.tabcontent {
display: none;
padding: 6px 12px;
border: 2px solid #aaa;
border-top: none;
}
</style>
<style>
.ctxP_Menu{
position: fixed;
padding: 4px 0;
margin: 2px;
background: var(--ctxP_MenuBg);
box-shadow: var(--ctxP_MenuShadow);
border-radius: var(--ctxP_MenuRadius);
margin:0;
list-style: none;
color: var(--ctxP_MenuText);
}
.ctxP_MenuSeparator{
display: block;
position: relative;
padding: 6px 5px;
}
.ctxP_MenuSeparator span{
display: block;
width: 95%;
height: 2px;
background: var(--ctxP_Separator);
}
.ctxP_MenuItemOuter ,li:hover {
position: static;
padding: 6px 0;
width: 98%;
}
.ctxP_MenuItem{
display: block;
padding: 5px 8px;
cursor: default;
width: 92%;
}
.ctxP_MenuItem: hover{
background: var(--ctxP_Hover);
width: 92%;
}
.ctxP_MenuItemIcon{
float: left;
}
.ctxP_MenuItemTitle{
text-align: left;
float: left;
line-height: 16px;
display: inline-block;
padding: 0px 0px 0px 4px;
}
.ctxP_MenuItemTip{
float: right;
padding: 0px 0px 0px 6px;
text-align: right;
line-height: 16px;
}
.ctxP_MenuItemOverflow{
float: right;
width: 16px;
height: 16px;
padding: 1px 0px 0px 7px;
}
.ctxP_MenuItemOverflow .ctxP_MenuItemOverflowLine{
display: block;
height: 1px;
margin: 3px 2px;
background: var(--ctxP_OverflowIcon);
}
.ctxP_MenuItemOverflow.hidden{
display: none;
}
.ctxP_MenuItem.disabled{
opacity: 0.4;
}
.ctxP_MenuItem.disabled:hover{
background: none;
}
.ctxP_SubMenu{
padding: 0;
margin: 0;
background: var(--ctxP_SubMenuBg);
border-radius: var(--ctxP_MenuRadius);
width: 100%;
height: auto;
max-height: 1000px;
transition: max-height 0.5s;
overflow: hidden;
}
.ctxP_SubMenu .ctxP_MenuItem: hover{
background: var(--ctxP_Hover);
}
.ctxP_MenuHidden{
max-height: 0;
}
.ctxP_MultiItem{
display: flex;
position: relative;
}
.ctxP_MultiItem .ctxP_MenuItemOuter{
flex: auto;
display: inline-block;
}
.ctxP_HoverMenuOuter{
position: relative;
}
.ctxP_HoverMenuItem{
display: block;
padding: 5px 8px;
cursor: default;
}
.ctxP_HoverMenuItem.disabled{
opacity: 0.4;
}
.ctxP_HoverMenuItem.disabled:hover{
background: none;
}
.ctxP_HoverMenuItem:hover{
background: var(--ctxP_Hover);
}
.ctxP_HoverMenuOuter > .ctxP_HoverMenu{
display: none;
}
.ctxP_HoverMenuOuter > .end_sub{
display: none;
}
.ctxP_HoverMenuOuter:hover > .ctxP_HoverMenu{
display: block;
position: absolute;
left: 100%;
top: 0;
background: var(--ctxP_MenuBg);
box-shadow: var(--ctxP_MenuShadow);
border-radius: var(--ctxP_MenuRadius);
padding: 8px 0;
width: 100%;
z-index: 1000;
list-style: none;
}
</style> <!-- ctxP_ -->
";$switchbox_style= "
<style>
.switchbox {
position: relative;
display: inline-block;
min-width: 3em;
height: 1em;
padding: .125em;
overflow: hidden;
box-sizing: content-box;
border: 2px solid darkgrey;
outline: none;
border-radius: .75em;
background-color: white;
font-size: 1.25em;
vertical-align: middle;
cursor: pointer;
transition: .15s ease-out;
}
.switchbox::before {
position: relative;
z-index: 2;
display: block;
width: 1em;
height: 1em;
border-radius: 50%;
background-color: darkgrey;
content: '';
transition: .15s ease-out;
}
.switchbox + label {
vertical-align: middle;
}
.switchbox-yes,
.switchbox-no {
position: absolute;
top: 50%;
z-index: 1;
transform: translateY(-50%);
font-size: .75em;
pointer-events: none;
transition: inherit;
}
.switchbox-yes {
left: .75em;
color: white;
font-weight: bold;
opacity: 0;
}
.switchbox-no {
right: .75em;
color: darkgrey;
opacity: 1;
}
.switchbox:hover,
.switchbox:focus {
border-color: var(--themeColr);
box-shadow: 0 0 .25em var(--themeColr);
}
.switchbox:hover::before,
.switchbox:focus::before {
background-color: var(--themeColr);
}
.switchbox.is-pressed {
border-color: var(--themeColr);
background-color: var(--themeColr);
}
.switchbox.is-pressed .switchbox-yes {
opacity: 1;
}
.switchbox.is-pressed .switchbox-no {
opacity: 0;
}
.switchbox.is-pressed::before {
transform: translateX(calc(var(--sw-width) - 1em));
background-color: white;
}
.switchbox.is-pressed:hover,
.switchbox.is-pressed:focus {
border-color: rgba(0,0,0,.35);
}
.switchbox.is-pressed:hover::before,
.switchbox.is-pressed:focus::before {
background-color: white;
}
.sr-only {
position: absolute;
width: 1px;
height: 1px;
margin: -1px;
padding: 0;
overflow: hidden;
border: 0;
white-space: nowrap;
clip: rect(0 0 0 0);
clip-path: inset(50%);
}
:root {
--themeColr: #00885a;
}
body {
padding: 2em;
background: #e6e8ea;
font-size: 1.125em;
line-height: 1.5;
}
</style> <!-- ctxP_ -->
";
?>
<script>
!function(){"use strict";const t=document.documentElement.getAttribute("data-easy-toggle-state-custom-prefix")||"toggle",e=(e,r=(()=>t)())=>["data",r,e].filter(Boolean).join("-"),r=e("arrows"),i=e("class"),n=e("class-on-target"),s=e("class-on-trigger"),a="is-active",o=e("escape"),u=e("event"),c=e("group"),l=e("is-active"),g=e("modal"),d=e("outside"),h=e("outside-event"),A=e("radio-group"),b=e("target"),f=e("target-all"),$=e("target-next"),v=e("target-parent"),m=e("target-previous"),E=e("target-self"),w=e("state"),p=e("trigger-off"),y=new Event("toggleAfter"),k=new Event("toggleBefore"),L=(t,e)=>{const r=t?`[${t}]`:"";if(e)return[...e.querySelectorAll(r)];const a=[`[${i}]${r}`,`[${s}]${r}`,`[${n}][${b}]${r}`,`[${n}][${f}]${r}`,`[${n}][${$}]${r}`,`[${n}][${m}]${r}`,`[${n}][${v}]${r}`,`[${n}][${E}]${r}`].join().trim();return[...document.querySelectorAll(a)]},x=(t,e)=>t.dispatchEvent(e),O=t=>"easyToggleState_"+t,S=(t,e={"aria-checked":t[O("isActive")],"aria-expanded":t[O("isActive")],"aria-hidden":!t[O("isActive")],"aria-pressed":t[O("isActive")],"aria-selected":t[O("isActive")]})=>Object.keys(e).forEach(r=>t.hasAttribute(r)&&t.setAttribute(r,e[r])),D=(t,e,r=!1)=>`This trigger has the class name '${t}' filled in both attributes '${i}' and '${e}'. As a result, this class will be toggled ${r&&"on its target(s)"} twice at the same time.`,z=(t,e)=>(t.getAttribute(e)||"").split(" ").filter(Boolean),I=t=>{const e=t.hasAttribute(c)?c:A;return L(`${e}="${t.getAttribute(e)}"`).filter(t=>t[O("isActive")])},T=(t,e)=>{t||console.warn(`You should fill the attribute '${e}' with a selector`)},q=(t,e)=>{if(0===e.length)return console.warn(`There's no match with the selector '${t}' for this trigger`),[];const r=t.match(/#\w+/gi);return r&&r.forEach(t=>{const r=[...e].filter(e=>e.id===t.slice(1));r.length>1&&console.warn(`There's ${r.length} matches with the selector '${t}' for this trigger`)}),[...e]},K=(t,e)=>e.forEach(e=>{t.classList.toggle(e)}),j={},B=t=>document.addEventListener(t.getAttribute(h)||t.getAttribute(u)||"click",Y,!1),Y=t=>{const e=t.target,r=t.type;let a=!1;L(d).filter(t=>t.getAttribute(h)===r||t.getAttribute(u)===r&&!t.hasAttribute(h)||"click"===r&&!t.hasAttribute(u)&&!t.hasAttribute(h)).forEach(t=>{const r=e.closest(`[${w}="true"]`);r&&r[O("trigger")]===t&&(a=!0),a||t===e||t.contains(e)||!t[O("isActive")]||(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)}),a||document.removeEventListener(r,Y,!1);const o=e.closest(`[${i}][${d}],[${s}][${d}],[${n}][${d}]`);o&&o[O("isActive")]&&B(e)},C=t=>M(t.currentTarget[O("target")]),H=(t,e,r)=>(t=>{if(t.hasAttribute(b)||t.hasAttribute(f)){const e=t.getAttribute(b)||t.getAttribute(f);return T(e,t.hasAttribute(b)?b:f),q(e,document.querySelectorAll(e))}if(t.hasAttribute(v)){const e=t.getAttribute(v);return T(e,v),q(e,t.parentElement.querySelectorAll(e))}if(t.hasAttribute(E)){const e=t.getAttribute(E);return T(e,E),q(e,t.querySelectorAll(e))}return t.hasAttribute(m)?q("previous",[t.previousElementSibling].filter(Boolean)):t.hasAttribute($)?q("next",[t.nextElementSibling].filter(Boolean)):[]})(t).forEach(i=>{x(i,k),i[O("isActive")]=!i[O("isActive")],S(i),r?i.classList.add(...e):K(i,e),t.hasAttribute(d)&&(i.setAttribute(w,t[O("isActive")]),i[O("trigger")]=t),t.hasAttribute(g)&&(i[O("isActive")]?(j[i]=(t=>e=>{const r=[...t.querySelectorAll("a[href], area[href], input:not([type='hidden']):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]")];if(!r.length||"Tab"!==e.key)return;const i=e.target,n=r[0],s=r[r.length-1];return-1===r.indexOf(i)?(e.preventDefault(),n.focus()):e.shiftKey&&i===n?(e.preventDefault(),s.focus()):e.shiftKey||i!==s?void 0:(e.preventDefault(),n.focus())})(i),document.addEventListener("keydown",j[i],!1)):(document.removeEventListener("keydown",j[i],!1),delete j[i])),x(i,y),((t,e)=>{const r=L(p,t).filter(e=>!e.getAttribute(p)||t.matches(e.getAttribute(p)));if(0!==r.length)e[O("isActive")]?r.forEach(t=>{t[O("target")]||(t[O("target")]=e,t.addEventListener("click",C,!1))}):(r.forEach(t=>{t[O("target")]===e&&(t[O("target")]=null,t.removeEventListener("click",C,!1))}),e.focus())})(i,t)}),M=t=>{x(t,k);const e=(t=>{if(t.hasAttribute(i)&&t.getAttribute(i)&&(t.hasAttribute(s)||t.hasAttribute(n))){const e=z(t,s),r=z(t,n);z(t,i).forEach(i=>{e.includes(i)&&console.warn(D(i,s),t),r.includes(i)&&console.warn(D(i,n,!0),t)})}const e=[i,s,n].reduce((e,r)=>{const a=z(t,r);return(r===i||r===s)&&e.trigger.push(...a),(r===i||r===n)&&e.target.push(...a),e},{trigger:[],target:[]});return!e.trigger.length&&(t.hasAttribute(i)||t.hasAttribute(s))&&e.trigger.push(a),!e.target.length&&(t.hasAttribute(i)||t.hasAttribute(n))&&e.target.push(a),e})(t);return K(t,e.trigger),t[O("isActive")]=!t[O("isActive")],S(t),x(t,y),H(t,e.target,!1),(t=>{if(t.hasAttribute(d))return t.hasAttribute(A)?console.warn(`You can't use '${d}' on a radio grouped trigger`):t[O("isActive")]?B(t):void 0})(t)},R=t=>{const e=I(t);return 0===e.length?M(t):-1===e.indexOf(t)?(e.forEach(M),M(t)):-1===e.indexOf(t)||t.hasAttribute(A)?void 0:M(t)},U=t=>((t[Symbol.iterator]?[...t]:[t]).forEach(t=>{t[O("unbind")]&&t[O("unbind")]()}),t),_=()=>{[...document.querySelectorAll(`[${n}]:not([${b}]):not([${f}]):not([${$}]):not([${m}]):not([${v}]):not([${E}])`)].forEach(t=>{console.warn(`This trigger has the attribute '${n}', but no specified target\n`,t)}),L(l).filter(t=>!t[O("isDefaultInitialized")]).forEach(t=>{if((t.hasAttribute(c)||t.hasAttribute(A))&&I(t).length>0)return console.warn(`Toggle group '${t.getAttribute(c)||t.getAttribute(A)}' must not have more than one trigger with '${l}'`);M(t),t[O("isDefaultInitialized")]=!0});const t=L().filter(t=>!t[O("isInitialized")]);return t.forEach(t=>{const e=e=>{e.preventDefault(),(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)},r=t.getAttribute(u)||"click";t.addEventListener(r,e,!1),t[O("unbind")]=()=>{t.removeEventListener(r,e,!1),t[O("isInitialized")]=!1},t[O("isInitialized")]=!0}),L(o).length>0&&!document[O("isEscapeKeyInitialized")]&&(document.addEventListener("keydown",t=>{"Escape"!==t.key&&"Esc"!==t.key||L(o).forEach(t=>{if(t[O("isActive")])return t.hasAttribute(A)?console.warn(`You can't use '${o}' on a radio grouped trigger`):(t.hasAttribute(c)?R:M)(t)})},!1),document[O("isEscapeKeyInitialized")]=!0),L(r).length>0&&!document[O("isArrowKeysInitialized")]&&(document.addEventListener("keydown",t=>{const e=document.activeElement;if(-1===["ArrowUp","ArrowDown","ArrowLeft","ArrowRight","Home","End"].indexOf(t.key)||!e.hasAttribute(i)&&!e.hasAttribute(s)&&!e.hasAttribute(n)||!e.hasAttribute(r))return;if(!e.hasAttribute(c)&&!e.hasAttribute(A))return console.warn(`You can't use '${r}' on a trigger without '${c}' or '${A}'`);t.preventDefault();const a=e.hasAttribute(c)?L(`${c}='${e.getAttribute(c)}'`):L(`${A}='${e.getAttribute(A)}'`);let o=e;switch(t.key){case"ArrowUp":case"ArrowLeft":o=a.indexOf(e)>0?a[a.indexOf(e)-1]:a[a.length-1];break;case"ArrowDown":case"ArrowRight":o=a.indexOf(e)<a.length-1?a[a.indexOf(e)+1]:a[0];break;case"Home":o=a[0];break;case"End":o=a[a.length-1]}return o.focus(),o.dispatchEvent(new Event(o.getAttribute(u)||"click"))},!1),document[O("isArrowKeysInitialized")]=!0),t},F=()=>{_(),document.removeEventListener("DOMContentLoaded",F)};document.addEventListener("DOMContentLoaded",F),window.easyToggleState=Object.assign(_,{isActive:t=>!!t[O("isActive")],unbind:U,unbindAll:()=>U(L().filter(t=>t[O("isInitialized")]))})}();
</script>
<!-- if (defined('LIB_POPUPSYSTEM[0]') && array_key_exists(0, LIB_POPUPSYSTEM) && (LIB_POPUPSYSTEM[0]==0) )
$switchbox_style = ""; else -->
<!-- Context menu system: -->
<script>
class ctxP_{
constructor(opts) {
ctxP_Core.CloseMenu();
this.position = opts.isSticky != null ? opts.isSticky : false;
this.menuControl = ctxP_Core.CreateEl(`<ul class='ctxP_Js ctxP_Menu'></ul>`);
this.menuControl.style.width = opts.width != null ? opts.width : '200px';
opts.items.forEach(i => {
let item = new ctxP_Item(i);
this.menuControl.appendChild(item.element);
});
if (event != undefined) {
event.stopPropagation()
document.body.appendChild(this.menuControl);
ctxP_Core.PositionMenu(this.position, event, this.menuControl);
}
document.onclick = function(e) {
if (!e.target.classList.contains('ctxP_Js')){
ctxP_Core.CloseMenu();
}
}
}
add(item) {
this.menuControl.appendChild(item.element);
}
show() {
event.stopPropagation()
document.body.appendChild(this.menuControl);
ctxP_Core.PositionMenu(this.position, event, this.menuControl);
}
hide() {
event.stopPropagation()
ctxP_Core.CloseMenu();
}
toggle() {
event.stopPropagation()
if (this.menuControl.parentElement != document.body){
document.body.appendChild(this.menuControl);
ctxP_Core.PositionMenu(this.position, event, this.menuControl);
} else {
ctxP_Core.CloseMenu();
}
}
}
class ctxP_Item {
element;
constructor(opts) {
switch(opts.type) {
case 'separator':  this.separator();  break;
case 'custom':  this.custom(opts.markup);  break;
case 'multi':  this.multiButton(opts.items);  break;
case 'submenu':  this.subMenu(opts.label, opts.items,
(opts.icon  !== undefined ? opts.icon  : ''),
(opts.cssIcon  !== undefined ? opts.cssIcon : ''),
(opts.hint  !== undefined ? opts.hint  : ''),
(opts.enabled  !== undefined ? opts.enabled : true));  break;
case 'hovermenu':  this.hoverMenu(opts.label, opts.items,
(opts.icon  !== undefined ? opts.icon  : ''),
(opts.cssIcon  !== undefined ? opts.cssIcon : ''),
(opts.hint  !== undefined ? opts.hint  : ''),
(opts.enabled  !== undefined ? opts.enabled : true));  break;
case 'footer':  this.custom(opts.markup,
(opts.custAttr !== undefined ? opts.custAttr: ''),
(opts.shortcut !== undefined ? opts.shortcut: '')
);  break;
case 'normal':
default:  this.button(opts.label, opts.onClick,
(opts.shortcut !== undefined ? opts.shortcut: ''),
(opts.icon  !== undefined ? opts.icon  : ''),
(opts.cssIcon  !== undefined ? opts.cssIcon : ''),
(opts.custAttr !== undefined ? opts.custAttr: ''),
(opts.hint  !== undefined ? opts.hint  : ''),
(opts.enabled  !== undefined ? opts.enabled : true));
}
}
button(label, onClick, shortcut = '', icon = '', cssIcon = '', custAttr = '', hint = '', enabled = true) {
this.element = ctxP_Core.CreateEl( `
<li class='ctxP_Js ctxP_MenuItemOuter' style= '` + custAttr + `'>
<div class='ctxP_Js ctxP_MenuItem ${enabled == true ? '' : 'disabled'}'>
<abbr class="hint">
${icon != ''? `<img src='${icon}' class='ctxP_Js ctxP_MenuItemIcon'/>`
: `<div class='ctxP_Js ctxP_MenuItemIcon ${cssIcon != '' ? cssIcon : ''}'>
</div>`}
<span class='ctxP_Js ctxP_MenuItemTitle'>${label == undefined? 'No label in button' : label}</span>
<span class='ctxP_Js ctxP_MenuItemTip'>${shortcut == ''? '' : shortcut}</span>
${hint == '' ? '' : '<data-hint>' + hint + '</data-hint>'}</abbr>
</div>
</li>`);
if (enabled == true) {
this.element.addEventListener('click', () => {
event.stopPropagation();
if (onClick !== undefined) { onClick(); }
ctxP_Core.CloseMenu();
}, false);
}
}
custom(markup) {
this.element = ctxP_Core.CreateEl(`<li class='ctxP_Js ctxP_CustomEl'>${markup}</li>`);
}
hoverMenu(label, items, icon = '', cssIcon = '', hint = '', enabled = true) {
this.element = ctxP_Core.CreateEl(`
<li class='ctxP_Js ctxP_HoverMenuOuter'>
<div class='ctxP_Js ctxP_HoverMenuItem ${enabled == true ? '' : 'disabled'}' >
<abbr class="hint">
${icon != ''
? `<img src='${icon}' class='ctxP_Js ctxP_MenuItemIcon'/>`
: `<div class='ctxP_Js ctxP_MenuItemIcon ${cssIcon != '' ? cssIcon : ''}'></div> `}
<span class='ctxP_Js ctxP_MenuItemTitle'>${label == undefined ? 'No label in hovermenu' : label}</span>
<span class='ctxP_Js ctxP_MenuItemOverflow'></span>
${hint == ''
? ''
: '<data-hint style="top: -30px;">' + hint + '</data-hint>'}
</abbr>
</div>
<ul class='ctxP_Js ctxP_HoverMenu'> </ul>
</li>
`);
let childMenu = this.element.querySelector('.ctxP_HoverMenu'),
menuItem = this.element.querySelector('.ctxP_HoverMenuItem');
if (items !== undefined) {
items.forEach( i => {
let item = new ctxP_Item(i);
childMenu.appendChild(item.element);
});
}
if (enabled == true) {
menuItem.addEventListener('mouseenter', () => { });
menuItem.addEventListener('mouseleave', () => { });
}
}
multiButton(buttons) {
this.element = ctxP_Core.CreateEl(`
<li class='ctxP_Js ctxP_MultiItem'>
</li>
`);
buttons.forEach(i => {
let item = new ctxP_Item(i);
this.element.appendChild(item.element);
});
}
subMenu(label, items, icon = '', cssIcon = '', hint = '', enabled = true) {
this.element = ctxP_Core.CreateEl(`
<li class='ctxP_Js ctxP_MenuItemOuter'>
<div class='ctxP_Js ctxP_MenuItem ${enabled == true ? '' : 'disabled'}'>
<abbr class="hint">
${icon != ''? `<img src='${icon}' class='ctxP_Js ctxP_MenuItemIcon'/>` : `<div class='ctxP_Js ctxP_MenuItemIcon ${cssIcon != '' ? cssIcon : ''}'></div>`}
<span class='ctxP_Js ctxP_MenuItemTitle'>${label == undefined? 'No label in submenu' : label}</span>
<span class='ctxP_Js ctxP_MenuItemOverflow'>
<span class='ctxP_Js ctxP_MenuItemOverflowLine'></span>
<span class='ctxP_Js ctxP_MenuItemOverflowLine'></span>
<span class='ctxP_Js ctxP_MenuItemOverflowLine'></span>
</span>
${hint == '' ? '' : '<data-hint>' + hint + '</data-hint>'}
</abbr>
</div>
<ul class='ctxP_Js ctxP_SubMenu ctxP_MenuHidden'> </ul>
</li>`);
let childMenu = this.element.querySelector('.ctxP_SubMenu'),
menuItem = this.element.querySelector('.ctxP_MenuItem');
if (items !== undefined) {
items.forEach( i => {
let item = new ctxP_Item(i);
childMenu.appendChild(item.element);
});
}
if (enabled == true) {
menuItem.addEventListener('click',() => {
menuItem.classList.toggle('SubMenuActive');
childMenu.classList.toggle('ctxP_MenuHidden');
}, false);
}
}
separator(label, items) {
this.element = ctxP_Core.CreateEl(`<li class='ctxP_Js ctxP_MenuSeparator'><span><hr></span></li>`);
}
}
const ctxP_Core = {
PositionMenu: (docked, el, menu) => {
if (docked) {
menu.style.left = ((el.target.offsetLeft + menu.offsetWidth) >= window.innerWidth) ?
((el.target.offsetLeft - menu.offsetWidth) + el.target.offsetWidth)+"px"
: (el.target.offsetLeft)+"px";
menu.style.top = ((el.target.offsetTop + menu.offsetHeight) >= window.innerHeight) ?
(el.target.offsetTop - menu.offsetHeight)+"px"
: (el.target.offsetHeight + el.target.offsetTop)+"px";
} else {
menu.style.left = ((el.clientX + menu.offsetWidth) >= window.innerWidth) ?
((el.clientX - menu.offsetWidth))+"px"
: (el.clientX)+"px";
menu.style.top = ((el.clientY + menu.offsetHeight) >= window.innerHeight) ?
(el.clientY - menu.offsetHeight)+"px"
: (el.clientY)+"px";
}
},
CloseMenu: () => {
let openMenuItem = document.querySelector('.ctxP_Menu:not(.ctxP_MenuHidden)');
if (openMenuItem != null) { document.body.removeChild(openMenuItem); }
},
CreateEl: (template) => {
var el = document.createElement('div');
el.innerHTML = template;
return el.firstElementChild;
}
};
</script>
<!-- :Context menu system -->
<?
echo "
<style>
:root {
--creaInpBg: LightYellow;
}
th input,
tfoot input {
padding-left:4px;
margin-left:2px;
height:18px;
}
td input,
input[type=text] {
padding:3px;
}
input[type=text]:focus {
border-color:#222;
}
tfoot input {
background: var(--creaInpBg);
}
.tablesorter-blue th, .tablesorter-blue thead td {
background-color: #eee;
}
.tablesorter-blue tfoot td {
font: 12px/18px Arial, Sans-serif;
font-weight: bold;
color: #000;
background-color: #eee;
border-collapse: collapse;
padding: 2px;
text-shadow: 0 1px 0 rgba(204, 204, 204, 0.7);
}
.tablesorter-blue tbody > tr.hover > td,
.tablesorter-blue tbody > tr:hover > td,
.tablesorter-blue tbody > tr:hover + tr.tablesorter-childRow > td,
.tablesorter-blue tbody > tr:hover + tr.tablesorter-childRow + tr.tablesorter-childRow > td,
.tablesorter-blue tbody > tr.even.hover > td,
.tablesorter-blue tbody > tr.even:hover > td,
.tablesorter-blue tbody > tr.even:hover + tr.tablesorter-childRow > td,
.tablesorter-blue tbody > tr.even:hover + tr.tablesorter-childRow + tr.tablesorter-childRow > td {
background-color: #d9f9f9;
}
.tablesorter-blue tbody > tr.odd.hover > td,
.tablesorter-blue tbody > tr.odd:hover > td,
.tablesorter-blue tbody > tr.odd:hover + tr.tablesorter-childRow > td,
.tablesorter-blue tbody > tr.odd:hover + tr.tablesorter-childRow + tr.tablesorter-childRow > td {
background-color: #bff1ff;
}
.tablesorter .tablesorter-filter {
width: 100%;
}
.tablesorter .tablesorter-filter-row {
background-color: #DFF;
height: 10px;
}
.tablesorter .tablesorter-filter-row .disabled {
display: none;
}
.sortPrefix {
display: none;
}
</style> <!-- :tablesorter -->
<style id=".'css'.">
.wrapper {
position: relative;
top: 14px;
overflow-x: auto;
display: block;
padding: 0 5px;
height: 300px;
overflow-y: auto;
}
#overlay0, #overlay1 {
background: rgba(244,244,244,0.8) url(http:
position: absolute;
z-index: 1000;
display: none;
width: 100%;
height: auto;
margin: 0;
top: 0;
left: 0;
}
$('#table0, #table1, #table2, #table3, #table4, #table5, #table6').tablesorter-blue input.tablesorter-filter, .tablesorter-blue select.tablesorter-filter {
width: 99%;
height: auto;
margin: 0;
padding: 1px;
}
#snackbar {
visibility: hidden;
width: min-content;
min-width: 250px;
margin-left: -125px;
text-align: center;
border-radius: 6px;
padding: 16px;
position: fixed;
z-index: 1;
left: 50%;
top: 200px;
font-size: 14px;
}
#snackbar.show {
visibility: visible;
transition: opacity 2s ease-out;
}
.ver_left,
.ver_right {
position: fixed;
top: 0;
bottom: 0;
height: 1.5em;
margin: auto;
}
.ver_left {
left: 0;
-webkit-transform-origin: 0 50%;
-moz-transform-origin: 0 50%;
-ms-transform-origin: 0 50%;
-o-transform-origin: 0 50%;
transform-origin: 0 50%;
-webkit-transform: rotate(-90deg) translate(-50%, 50%);
-moz-transform: rotate(-90deg) translate(-50%, 50%);
-ms-transform: rotate(-90deg) translate(-50%, 50%);
-o-transform: rotate(-90deg) translate(-50%, 50%);
transform: rotate(-90deg) translate(-50%, 50%);
}
.ver_right {
right: 0;
-webkit-transform-origin: 100% 50%;
-moz-transform-origin: 100% 50%;
-ms-transform-origin: 100% 50%;
-o-transform-origin: 100% 50%;
transform-origin: 100% 50%;
-webkit-transform: rotate(-90deg) translate(50%, 50%);
-moz-transform: rotate(-90deg) translate(50%, 50%);
-ms-transform: rotate(-90deg) translate(50%, 50%);
-o-transform: rotate(-90deg) translate(50%, 50%);
transform: rotate(-90deg) translate(50%, 50%);
}
</style>
";
$htm_ModalDialog= '
<style>
.modal-window {
position: fixed;
background-color: rgba(255, 255, 255, 0.25);
top: 0;
right: 0;
bottom: 0;
left: 0;
z-index: 999;
visibility: hidden;
opacity: 0;
pointer-events: none;
-webkit-transition: all 0.3s;
transition: all 0.3s;
}
.modal-window:target {
visibility: visible;
opacity: 1;
pointer-events: auto;
}
.modal-window > div {
width: 400px;
position: absolute;
top: 50%;
left: 50%;
-webkit-transform: translate(-50%, -50%);
transform: translate(-50%, -50%);
padding: 2em;
background: #ffffff;
border-radius: 8px;
}.modal-window h1 {
font-size: 150%;
margin: 0 0 15px;
}
.modal-close {
color: #757575;
font-size: 80%;
position: absolute;
right: 0;
text-align: center;
top: 0;
text-decoration: none;
padding: 0.25em 0.5em;
border: 1px solid;
border-radius: 5px;
}
.modal-close:hover {
color: black;
}
.modal-window div:not(:last-of-type) {
margin-bottom: 15px;
}
.btnlabl {
color: #757575;
padding: 0.25em 0.5em;
text-decoration: none;
font-size: '.$gbl_progZoom.';
border: 1px solid;
border-radius: 5px;
}
.btnlabl:hover {
color: black;
}
.btn {
background-color: #fff;
padding: 0.25em 0.5em;
text-decoration: none;
border: 1px solid;
border-radius: 5px;
}
#header {
text-align: center;
background-color: whitesmoke;
}
#footer {
text-align: right;
}
.container {
display: grid;
-webkit-box-pack: center;
justify-content: center;
-webkit-box-align: center;
align-items: center;
}}
</style>
';
echo $htm_ModalDialog;
echo $switchbox_style;if (DEBUG)
run_Script(
'class Timers
{ private $timers = [];
public function startTimer($name, $description = null)
{  $this->timers[$name] = [
"start" => microtime(true),
"desc" => $description,
]; }
public function endTimer($name)
{  $this->timers[$name]["end"] = microtime(true); }
public function getTimers()
{  $metrics = [];
if (count($this->timers)) {
foreach($this->timers as $name => $timer) {
$timeTaken = ($timer["end"] - $timer["start"]) * 1000;
$output = sprintf(\"%s;dur=%f\", $name, $timeTaken);
if ($timer["desc"] != null) {
$output .= sprintf(";desc="%s"", addslashes($timer["desc"]));
}
$metrics[] = $output;
}
}
return implode($metrics, ", ");
}
}
$Timers = new Timers();
');run_Script("function toast(txt, bgcolr='#333', fgcolr='#fff', timeout=5000) {
var x = document.getElementById('snackbar');
x.innerHTML= txt;
x.className = 'show';
x.style.background = bgcolr;
x.style.color = fgcolr;
setTimeout(function(){ x.className = x.className.replace('show', ''); }, timeout);
}");
run_Script("function invertColor(hex, bw) {
if (hex.indexOf('#') === 0) {
hex = hex.slice(1);
}
if (hex.length === 3) {
hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
}
if (hex.length !== 6) {
throw new Error('Invalid HEX color.');
}
var r = parseInt(hex.slice(0, 2), 16),
g = parseInt(hex.slice(2, 4), 16),
b = parseInt(hex.slice(4, 6), 16);
if (bw) {
return (r * 0.299 + g * 0.587 + b * 0.114) > 186
? '#000000'
: '#FFFFFF';
}
r = (255 - r).toString(16);
g = (255 - g).toString(16);
b = (255 - b).toString(16);
return '#' + padZero(r) + padZero(g) + padZero(b);
}");if (defined('LIB_FONTAWESOME') && array_key_exists(0, LIB_FONTAWESOME) )  {
if (LIB_FONTAWESOME[0]>0) {
if (LIB_FONTAWESOME[0]==1)  $path= $gbl_ProgRoot.LIB_FONTAWESOME[1];
else  $path=  LIB_FONTAWESOME[2];
echo '<link  href="'.$path.'css/all.min.css" rel="stylesheet" />';
}
}
if (defined('LIB_TINYMCE')) {
if (array_key_exists(0, LIB_TINYMCE))
if (LIB_TINYMCE[0]>0) {
if (LIB_TINYMCE[0]==1)  $path= $gbl_ProgRoot.LIB_TINYMCE[1];
else  $path=  LIB_TINYMCE[2];
echo '<script src="'.  $path.'/tinymce.min.js" referrerpolicy="origin"></script>';
}
}
$gbl_PageLogo= ($gbl_ProgBase ?? './').'_accessories/21997911.png';
echo $CSS_system;
set_Style('type="text/css"', '<!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_accessories/barcode.ttf); } --> ');
$bottLogo= '';
set_Style('type="text/css"', 'body { left top no-repeat; background-size: 100% 100%; font-family: sans-serif; '.$attr.' url('.$gbl_Imag.')}');
if ($info>'')
echo '<div style="position: fixed; z-index: 99; float: right; display: inline-block; width: max-content; right: 0;
transform-origin: right bottom; transform: rotate(-90deg) translate(-100%, 0); white-space: nowrap;
padding: 2px; background-color:#ddddddbd;"><span style="font-size: 0.8em;">'.lang($info).'</span></div>';
if ($hint>'')
echo '<div style="position: fixed; width: min-content; bottom: -10px; left: 0px; z-index: 99;
transform-origin: top left; transform: rotate(-90deg); white-space: nowrap; padding: 2px; background-color:#ddddddbd;" '.
'title="CTRL-Scroll UP/Down mousewheel to zoom window content">'.
'<small>'.lang($hint).'</small></div>';
echo $jsScripts;
echo $popScripts;
if ($inis>'')  echo $inis;
if ($lateScripts > '') echo $lateScripts;
echo "\n</head>\n
<body>\n";
if ($pageMess > '<b>ERROR:</b> ') echo $pageMess;
if ((isset($gbl_Imag)) and ($gbl_Imag>'')) $image= 'background-image: url(\''.$gbl_Imag.'\');'; else  $image= '';
echo '<div style="text-align: '.$algn.'; '.$image.'  margin: auto; ">';
if ($gbl_Bord)
echo '<div style="border: 2px solid #AAA; border-radius: 8px; overflow: hidden; margin: auto;" >';
}
function htm_Page_00()
{ global $gbl_PanelIx, $panelCount, $gbl_ProgRoot, $popScripts, $jsScripts, $lateScripts, $gbl_Bord, $gbl_Imag;
$panelCount= $gbl_PanelIx;
if ($gbl_Bord) echo '</div>';
echo '</div>';
echo '<div id="snackbar">Short message</div>';
if (is_null($panelCount)) $panelCount= 15;
PanelInit($panelCount);
echo $popScripts;
echo '
<script>
function closeTabs() {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
tabcontent[i].style.display = "none";
}
}
function openTab(evt, TabName) {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
tabcontent[i].style.display = "none";
}
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
tablinks[i].className = tablinks[i].className.replace(" active", "");
}
document.getElementById(TabName).style.display = "block";
evt.currentTarget.className += " active";
}
</script>
';
if ($lateScripts > '') echo $lateScripts;
if (DEBUG) run_Script('header("Server-Timing: ".$Timers->getTimers()); ');
$url= $gbl_ProgRoot.'../../spormig.php';
if (is_readable($url)) { include($url); echo '+'; } else echo '-';
htm_nl(2);
echo "\n  </body>";
echo '</html><br>';
}
if (!function_exists('Lbl_Tip'))
{
function Lbl_Tip(
$labl,$hint,$plac='',$h='13px',$t='')
{
if ($t!='')  $t= ' top:'.$t;
if ($labl=='') return '';
else {  dvl_pretty('Lbl_Tip');
if ($h=='0px') {$h='';}
switch (strtoupper($plac)) {
case 'W':  $class= 'LblTip_W';  break;
case 'S':  $class= 'LblTip_S';  break;
case 'O':  $class= 'LblTip_O';  break;
case 'N':  $class= 'LblTip_N';  break;
case 'NW': $class= 'LblTip_NW'; break;
case 'SW': $class= 'LblTip_SW'; break;
case 'SO': $class= 'LblTip_SØ'; break;
default :  $class= 'LblTip_text';
}
if (strlen($hint.' ')<140) {$wdth='';} else {$wdth='style ="min-width: 320px;"';}
if ($hint=='') $hint=lang('@No details !');
$hint= '<span class="'.$class.'" '.$wdth.'>'.lang($hint).'</span>';
return '<span class="LblTip" style="height:'.$h.$t.'">'.ucfirst(lang($labl).' ').$hint.'</span>';
}
}
if (!function_exists('dvl_pretty')) {
function dvl_pretty($testlabl='') {
if (DEBUG) { echo "\n"; if ($testlabl>'') echo '<!-- '.$testlabl.': -->'."\n"; return "\n"; }
}}
if (!function_exists('dvl_echo')) {
function dvl_echo($testlabl='')
{
if ((DEBUG) and ($testlabl>'')) {echo "<br>". $testlabl. "\n";}
}}
function calcHash($usr_name,$usr_code)
{
return $result= "<span style='color:red;'>'".$usr_name."' => '".password_hash($usr_code, PASSWORD_BCRYPT)."',</span>". ' '.'//'.' '.$usr_code;
}function htm_Ihead(
$source)  {echo '<br/><i>'.$source.'</i> ';}
function htm_hr(
$c='#0',$attr='')  {echo '<hr style="background-color:'.$c.';'.$attr.'"/>';}
function htm_br(
$rept=1)  {echo str_repeat('<br />',$rept);}
function htm_nl(
$rept=1)  {echo str_repeat('<br />',$rept);}
function htm_lf(
$rept=1)  {echo str_repeat(' &#xa;',$rept);}
function htm_sp(
$rept=1)  {echo str_repeat('&nbsp;',$rept);}
function htm_space(
$wdth)  {echo '<span style="width:'.$wdth.'; display:block; "></span>';}function str_bold($source,$result='',$tail='&nbsp;&nbsp;') {return $result.'<b>'.$source.'</b>'.$tail;}
function str_Ihead($source)  {return '<br /><i>'.$source.'</i> ';}
function str_hr($c='#0',$attr='')  {return '<hr style=\'color:'.$c.';'.$attr.'\'/>';}
function str_br($rept=1)  {return str_repeat('<br />',$rept);}
function str_nl($rept=1)  {return str_repeat('<br />',$rept);}
function str_lf($rept=1)  {return str_repeat(' &#xa;',$rept);}
function str_sp($rept=1)  {return str_repeat('&nbsp;',$rept);}
function markFirstChar($str='',$tag='u',$att='')
{ $str= lang($str); $str= '<'.$tag.' '.$att.'>'.substr($str,0,1).'</'.$tag.'>'.substr($str,1); return $str; }
function markAllChars($str='',$tag='u',$att='')
{ $str= lang($str); $str= '<'.$tag.' '.$att.'>'.$str.'</'.$tag.'>'; return $str; }
function toNum($test='')
{ $test= str_replace(',','.',$test); if (!is_numeric($test)) $test= 0; return $test; }
function scannSource($prefix='$name=',$suffix="'",$files=[])
{
$rtrn=true;  if (!$rtrn) echo '<br>'.$prefix.' <b>';
$result= [];  $lines = [];
foreach ($files as $fname) $lines = $lines + file($fname);
foreach ($lines as $aline => $line) {
$pos1= strpos($line,$prefix);
if (($pos1>0) and (strpos($line,'cannSource')==0)) {
$tag= substr($line,$pos1+2+strlen($prefix));
$len= strpos($tag,$suffix)+3;
$str= trim(substr($line,$pos1+strlen($prefix),$len),"'");
$result[]= $str;  ($count ?? 0)+ 1;  if (!$rtrn) echo $str.', ';
}  }
if (!$rtrn) { echo '</b> :COUNT: '.$count.' '.count($result).'<br>'; arrPrint($result,'result'); }
return $result;
}
function sys_get_translations($transTable=[])
{ global $gbl_ProgRoot, $arrLang;
if (isset($_POST['alllang']))  $alllang = $_POST['alllang']; else $alllang = '';
if ($arrLang == null)
try {
$content = file_get_contents($gbl_ProgRoot.'_trans.sys.json');
if ($content !== FALSE) {
$lng = json_decode($content, TRUE);
if ($lng != null)
foreach ($lng["language"] as $key => $value)
{  $lang_rec["code"]  = $value["code"];
$lang_rec["name"]  = $value["name"];
$lang_rec["native"]  = $value["native"];
$lang_rec["author"]  = $value["author"];
$lang_rec["note"]  = $value["note"];
$lang_rec["DateTime"]  = $value["DateTime"];
$lang_rec["translation"] = $value["translation"];
$arrLang[] = $lang_rec;
if (substr($_SESSION['proglang'],0,2)==$lang_rec["code"]) $_SESSION['currLang']= $lang_rec;
}
else $arrLang= ['ERROR on decoding: _trans.sys.json',' '];
return $arrLang;
};
}
catch (Exception $e) {
echo $e;
}
return $arrLang;
}if (isset($_POST['language'])) $lang = $_POST['language'];
if (!isset($lang)) $lang = 'en';
if (!$englishOnly) $allLang = sys_get_translations();
if ($allLang) {
$natindx = array_search($lang, array_column($allLang, 'code'));
$engindx = array_search('en',  array_column($allLang, 'code'));
}
if (!function_exists('lang')) {
function lang(
$text
)
{  global  $natindx, $engindx, $allLang, $lang;
$text= trim($text,"@");
if  (isset($allLang[$natindx]['translation'][$text]))  return ($allLang[$natindx]['translation'][$text]);
else if (isset($allLang[$engindx]['translation'][$text]))  return ($allLang[$engindx]['translation'][$text]);
else  return trim($text,"@");
}
}
function sys_enc($text)
{
return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
function postValue(&$id,$varId)
{
if (isset($_POST[$varId]))  { $id = $_POST[$varId]; }
else $id= 54321;
return $id;
}
function get_browser_name($user_agent)
{
if  (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
elseif (strpos($user_agent, 'Edge'))  return 'Edge';
elseif (strpos($user_agent, 'Chrome'))  return 'Chrome';
elseif (strpos($user_agent, 'Safari'))  return 'Safari';
elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
elseif (strpos($user_agent, 'MSIE') ||  strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
return 'Other';
}
function DropDown($name, $valu, $list ,$attr='')
{
dvl_pretty();
$Result=  '<div style="margin-right:0;"> ';
$Result.= '<select class="styled-select" id="'.$name.'" name="'.$name.
'" style="max-width:140px; background-color:transparent; '.$attr.
'"> '."\n".'<option label="" value="" > - </option>';
foreach ($list as $rec) { dvl_pretty();
$Result.= "\n".'<option label="'.lang($rec[1]).'" value="'.$rec[0].'" title="'.lang($rec[2]).'"';
if ($rec[0]==$valu) $Result.= ' SELECTED ';
$Result.= '>'.$lbl=lang($rec[1]).'</option> ';
}
$Result.= '</select></div> ';
return($Result);
}
function infoLabl(
$labl='',$hint='',$plac='SW')
{
echo Lbl_Tip($labl,$hint,$plac,$h='20px');
}
function menuCapt ($h='32',$w='120',$label='')
{  dvl_pretty();
echo '<div style="background-image: linear-gradient(lightgray, white); height: '.$h.'px; width: '.$w.
'px; border: solid 1px darkgray; text-align: center; font-weight: 600; margin: auto;">
'.ucfirst(str_replace(' ','&nbsp;',lang($label))).
'</div>';
}
function menuButt ($h='32',$w='120',$label='',$link='',$Hint='')
{  dvl_pretty();
if (strpos($link,'blindAlley.page.php')>0)
{ $state= ' disabled '; $mess= str_lf().' (A blind alley yet!)';}
else {$mess=''; $state=''; };
echo '<button type="button" onclick="location.href=\''.$link.'\'"
style="background-image: linear-gradient(white, lightgray); height: '.$h.'px; width: '.$w.'px; border: solid 1px darkgray; text-align: center;"
title="'. lang($Hint).$mess.'" '.$state.'data-tiptxt="'.lang($Hint).$mess.'" >
<span style= "white-space: nowrap;">'.ucfirst(str_replace(' ','&nbsp;',lang($label))).'</span>
</button>';
}
function str_Synt_0()  {return '<pre class="synt">';}
function str_Synt_00() {return '</pre>';}
function str_Synt($elem='',$type='default') { return '<span class="synt-'.$type.'">'.$elem.'</span>'; }
}
$CSS_system = '
<style>
:root {
--roedColor: #FF0000;
--guulColor: #F3F033;
--grenColor: #336600;
--grenColr1: #448800;
--lablColor: #500000;
--lablBgrnd: #fffaf0;
--panelTitl: #ffffff00;
--oranColor: #F37033;
--brunColor: #550000;
--grayColor: #ACA9A8;
--shadColor: #d3d3d352;
--xx11Color: #3CBC8D;
--HintsBgrd: lightyellow;
--HintsText: #000000;
--xx33Color: #CCEDFE;
--grColrLgt: #CCCCCC;
--FieldBord: #AAAAAA;
--FieldBgrd: #FAFAFA;
--PanelBgrd: <?php echo $GLOBALS["ØPanelBgrd"]; ?>;
--TapetBgrd: <?php echo $GLOBALS["ØTapetBgrd"]; ?>;
--ButtnBgrd: #44BB44;
--ButtnText: #FFFFFF;
--BtLnkBgrd: #FCFCCC;
--BtLnkText: #000000;
--ButtnShad: #bcbcbc;
--PageBcgrd: #333333;
--PageBcgrd: <?php echo $gbl_PageBcgrd; ?>;
--fltBgColr: #FFFFFF;
--fltTxColr: #550000;
--tblRowDrk: #e0e0e0;
--tblRowLgt: #f0f0f0;
--btnTxNorm: #000000;
--btnTxOver: #900000;
--SkyTxNorm: #AAF;
--FldHeight: 32px;
--ctxP_MenuBg: GhostWhite;
--ctxP_MenuShadow: 1px 1px 10px #000;
--ctxP_MenuRadius: 5px;
--ctxP_MenuText: black;
--ctxP_SubMenuBg: snow;
--ctxP_Hover: #d7f1e5;
--ctxP_OverflowIcon: #999;
--ctxP_Separator: #999;
--lablColor: #500000;
--lablBgrnd: FloralWhite;
--HintsBgrd: Cornsilk;
--HintsText: black;
}
.LblTip,
.LblTip_W,  .LblTip_O,  .LblTip_S, .LblTip_N,
.LblTip_NW, .LblTip_SW, .LblTip_SØ
{  font-family: sans-serif;
position: relative;
cursor: help;
display: inline-block;
background: var(--lablBgrnd);
color: var(--lablColor);
border-radius:3px;
border: 1px solid var(--FieldBord);
box-shadow: 2px 1px 1px var(--ButtnShad) inset;
padding: 0px 3px 1px 3px;
text-align: center;
margin-bottom: 2px;
font-size: 11px;
}
.LblTip {
text-shadow:0px 0.6px var(--SkyTxNorm);
}
.LblTip_text,
.LblTip_W,  .LblTip_O,  .LblTip_S, .LblTip_N,
.LblTip_NW, .LblTip_SW, .LblTip_SØ
{
visibility: hidden;
min-width: 160px;
background-color: var(--HintsBgrd);
color: var(--btnTxNorm);
font-style:normal;
font-weight:400;
font-size: 12px;
text-align: center;
border-radius: 6px;
border: 1px solid #555555;
padding: 5px 3px;
position: absolute;
z-index: 99999;
}
.LblTip_text,
.LblTip_N {bottom: 20px;  left: -25px;}
.LblTip_S {top: 22px;  left: -90px;  min-width: 120px;}
.LblTip_NW {bottom: 20px; left: -180px;  min-width: 160px;}
.LblTip_SW {top: 22px;  left: -280px;  min-width: 160px;}
.LblTip_SØ {top: 22px;  left: 28px;  min-width: 160px;}
.LblTip_W {left: -26px;  margin-top: -28px;}
.LblTip_O {right: -26px;  margin-top: -28px;}
.LblTip:hover  .LblTip_N,
.LblTip:hover  .LblTip_S,
.LblTip:hover  .LblTip_NW,
.LblTip:hover  .LblTip_SW,
.LblTip:hover  .LblTip_SØ,
.LblTip:hover  .LblTip_W,
.LblTip:hover  .LblTip_O,
.LblTip:hover  .LblTip_text,
.LblTip_text:hover
{
box-shadow: 3px 3px 5px var(--grColrLgt);
transition-delay: 0.2s;
background-color: var(--HintsBgrd);
color: var(--HintsText);
visibility: visible;
z-index: 999;
text-shadow: 0px 0px  var(--SkyTxNorm);
}
.lablInput {
height: 2.2em;
margin: 0.05em 0.05em;
text-align: left;
position: relative;
width: 50px;
}
.lablInput checkbox,
.lablInput textarea,
.lablInput input {
border: 1px solid var(--grColrLgt);
border-radius: 0.20em;
background: white;
margin: 0.20em 0.0em;
height: auto;
width: 94%;
cursor: text;
font-size: 0.850em;
font-weight: 500;
position: relative;
transition: all 0.15s ease;
padding: 4px 2px 1px;
}
.lablInput input[type="radio"] {
width: 71%;
}
.lablInput label {
color: var(--grayColor);
padding: 0.2em 1%;
cursor: text;
font-size: 0.95em;
font-weight: 500;
padding: 0.1em 1% 0.1em 1%;
position: relative;
transition: all 0.15s ease;
width: 95%;
}
.label {
font-style: italic;
font-family: sans-serif;
font-weight: normal;
color: blue;
padding: 0.05em 1%;
}
.lablInput checkbox.filled ~ label,
.lablInput textarea.filled ~ label,
.lablInput input.filled ~ label,
.lablInput checkbox ~ label,
.lablInput textarea ~ label,
.lablInput input ~ label,
.lablInput input:focus ~ label {
font-size: 0.65em;
font-weight: 400;
text-align: right;
position: relative;
top: -45px;
width: 0;
color: var(--lablColor);
padding: 0.005em 0 0;
}
.lablInput checkbox.filled,
.lablInput textarea.filled,
.lablInput input[type="date"].filled,
.lablInput input[type="text"].filled,
.lablInput input[type="email"].filled:valid {
font-weight: 500;
background: var(--fltBgColr);
color: var(--fltTxColr);
}
.lablInput input[type="number"].filled {
color: var(--roedColor);
width: 80px;
position: absolute;
}
.lablInput checkbox.filled ~label:after,
.lablInput textarea.filled ~label:after,
.lablInput input[type="text"].filled ~label:after,
.lablInput input[type="email"].filled:valid ~label:after {
color: var(--lablColor);
display: inline-block;
font: normal normal normal 14px/1em;
font-size: 2em;
text-rendering: auto;
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale;
position: absolute;
top: 0.3em;
right: 0.3em;
transform: translate(0, 0);
}
::-webkit-input-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }
:-moz-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }
::-moz-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }
:-ms-input-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }
.fa, .far, .fas {
margin-right: 6px;
}
hr.style13 {
height: 6px;
border: 0;
box-shadow: 0 10px 10px -10px #8c8b8b inset;
}
@media screen and (min-width: 960px) {
#colnwrap  {width: 99%; padding: 0px;  }
#RowCol240  {width: 240px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol280  {width: 280px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol320  {width: 320px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol400  {width: 400px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol480  {width: 480px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol640  {width: 640px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol720  {width: 720px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol800  {width: 800px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol960  {width: 960px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowCol1100 {width:1100px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
#RowColsaut {width: auto;  padding: 5px 0px 5px 5px; margin: 5px 0px 5px 0px; float: left;}
data-PanlHead, PanlFoot  {clear: both;  padding: 0 5px;}
}
@media screen and (max-width: 960px) {
#colnwrap  {width: 99%;  }
#RowCol320  {width: 41%;  padding: 5px 5px;  margin: 0px 0px 5px 5px;}
#RowColsaut {width: auto; padding: 5px 5px;  margin-left: 0px;  clear: both;  float: none;  }
data-PanlHead, PanlFoot {padding: 1px 5px;  clear: both;}
}
@media screen and (max-width: 640px) {
#RowCol320  {width: auto;  float: none;  margin-left: 5px; }
#RowColsaut {width: auto;  float: none;  margin-left: 5px; }
}
@media screen and (max-width: 480px) {
data-PanlHead {height: auto; }
h1  {font-size: 2em;  }
}
@media screen and (max-width: 1280px) { @viewport { width: 1280px; } }
.panelWmax, .panelWaut, .panelW120, .panelW110, .panelW100, .panelW960, .panelW800, .panelW720,
.panelW640, .panelW560, .panelW480, .panelW400, .panelW320, .panelW280, .panelW240, .panelW160 {
border: 1px solid var(--grayColor);
background: var(--PanelBgrd);
box-shadow: 3px 3px  <?php echo $shadowBlur; ?> var(--ButtnShad);
border-radius: 0.4em;
border-style: inset;
border-color: lightgray;
border-width: thin;
display: inline-block;
}
.panelWmax { width:  99%;  }
.panelWaut { width: auto;  }
.panelW120 { width: 1200px; }
.panelW110 { width: 1100px; }
.panelW100 { width: 1020px; }
.panelW960 { width: 960px;  }
.panelW800 { width: 800px;  }
.panelW720 { width: 720px;  }
.panelW640 { width: 640px;  }
.panelW560 { width: 560px;  }
.panelW480 { width: 480px;  }
.panelW400 { width: 400px;  }
.panelW320 { width: 320px;  }
.panelW280 { width: 280px;  }
.panelW240 { width: 240px;  }
.panelW160 { width: 160px;  }
.panelTitl,.tapetTitl {
font-family: sans-serif;
font-size: 14px;
font-weight: 600;
height: 1.1em;
margin: 0.0em 0.2em;
padding: 0.1em 0.1em 0.3em;
background-color: var(--panelTitl);
position: relative;
width: 100%;
text-align: center;
}
.tapetTitl {
font-size: 1.2em;
font-family: sans-serif;
}
.tapetWmax {
border: 3px solid var(--grayColor);
background: var(--TapetBgrd);
background-image: url('.$gbl_ProgRoot.'_accessories/eurosymbol60.png);
box-shadow: 3px 3px  <?php echo $shadowBlur; ?> var(--ButtnShad);
border-radius: 0.40em;
margin: 0.4em 0.2em 0.4em 0.2em;
padding: 0.3em 0.3em 0.3em 0.3em;
}
.clearWrap {
clear: both;
}
.fieldContent {
text-align: left;
display: block;
padding: 0 6px;
position: relative;
background-color: white;
padding: 10px 10px 4px;
margin: 3px;
border: 1px solid var(--FieldBord);
border-radius: 4px;
}
.fieldSingle {
padding: 2px 6px 4px;
}
.fieldStyle,
.tableStyle {
display:inline-block;
border-radius: 5px;
border: 1px solid var(--FieldBord);
background-color: var(--FieldBgrd);
position: relative;
margin:3px;
padding:3px;
margin: 1px;
padding: 1px;
}
.lablInput input {
border: 0px solid var(--grColrLgt);
}
.fieldStyle {
height: var(--FldHeight);
}
input[type="date"]::-webkit-calendar-picker-indicator {
position: absolute;
top: 0;
left: 0;
right: 0;
bottom: 0;
width: auto;
height: auto;
color: transparent;
background: transparent;
}
input[type="date"]::-webkit-inner-spin-button {
z-index: 1;
}
input[type="date"]::-webkit-clear-button {
z-index: 1;
}
input[type="date"] {
position: relative;
}
input[type="date"]:after {
content: "\25BC";
color: #555;
padding: 0;
}
input[type="date"]:hover:after {
color: #bf1400;
}
input[type="date"]::-webkit-inner-spin-button {
-webkit-appearance: none;
margin: 0;
}
.inpField {
position: relative;
min-height: 38px;
}
.inpField input {
border: 1px solid var(--FieldBord);
border-radius: 5px;
font-size: 12px;
padding: 8px 0px 6px 6px;
margin: 6px 1px 1px 1px;
width: 94%
}
.inpField label {
padding: 0px 0px 1px 3px;
position: absolute;
top:  -5px;
left: 0px;
width: 94%;
text-align: right;
}
.inpField label div {
border: solid 1px var(--FieldBord);
border-radius: 9px;
background-color: var(--lablBgrnd);
width: min-content;
padding: 0 5px;
}
.boxStyle, .inpField input {
box-shadow: 3px 4px 2px var(--shadColor);
border: 1px solid var(--grayColor);
border-radius: 5px;
margin: 5px 0;
background-color: white;
}
'.
'
.hint {
color: var(--lablColor);
background-color: var(--panelTitl);
}
abbr.hint data-hint {
display: none;
position: relative;
left: 50px;
top: 35px;
}
abbr.hint:hover {
cursor: pointer;
}
abbr.hint:hover data-hint {
display: block;
position: absolute;

width: 200px;
min-width: 160px;
border: solid 1px #aaa;
border-radius: 4px;
box-shadow: 3px 3px 3px var(--ButtnShad);
overflow-wrap: break-word;
white-space: pre-line;
background-color: var(--HintsBgrd);
color: var(--HintsText);
font-style:normal;
font-weight:400;
font-size: 12px;
text-align: center;
padding: 5px 3px;
z-index: 99999;
}
. acceptbutt {
margin: 1px 2px;
padding: 2px 3px;
min-height: 28px;
}
.btnTit {
font-size: 0.95em;
font-family: sans-serif;
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
color: black;
padding: .5em 1em;
border: 2px;
border-radius: 4px;
letter-spacing: 0em;
font-weight: 600;
}
.btn  { color: var(--btnTxNorm); text-decoration: none;}
.btn:hover { color: var(--btnTxOver); z-index: 777;}
.btn {
font-size: 0.85em;
font-family: sans-serif;
white-space: pre-wrap;
position: absolute;
top: 30%;
left: 50%;
z-index: 666;
transform: translate(-50%, -50%);
color: var(--btnTxNorm);
margin-top: 3px;padding: .001em;
border: none;
border-radius: 4px;
letter-spacing: 0em;
font-weight: 300;
}
.data-colrlabl {
color: green;
}
.hidden { display: none; }
input { border: 0; }
.grid-container {
display: grid;
grid-template-columns: 35% 30% 35% ;
background-image: url("'.$gbl_ProgRoot.'_accessories/_background.png");
padding: 10px;
grid-gap: 10px;
text-align: center;
}
.grid-item {
}
[contentEditable=true]:empty:not(:focus):before{
content:attr(data-placeholder);
color: var(--grenColr1);
font-size: 90%;
}
.range-wrap {
position: relative;
}
.range {
width: 100%;
}
.bubble {
padding: 2px;
position: absolute;
border-radius: 4px;
left: 50%;
transform: translateX(-50%);
}
.bubble::after {
content: "";
position: absolute;
width: 2px;
height: 2px;
background: lightgreen;
top: -1px;
left: 50%;
}
body {
margin: 1rem;
}
.button, a.button {
text-decoration: none;
font-size: 13px;
min-height: 28px;
color: initial;
color: white;
border: solid 2px #aaa;
border-style: outset;
background: #269B26;
opacity: 0.8;
padding: 2px 6px;
}
fieldset>legend {
display: table;
float: none;
margin: 0 auto;
}
@media screen and (-moz-images-in-menus: 0) {
fieldset {
position: relative;
}
fieldset>legend {
position: absolute;
left: 50%;
top: -12px;
background: white;
transform: translate(-50%, 0);
}
}
</style>
';
if (is_readable($custFile= '../customLib.inc.php')) require_once($custFile);
?>