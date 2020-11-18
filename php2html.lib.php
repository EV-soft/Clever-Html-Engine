<?   $DocFile='../Proj1/php2html.lib.php';    $DocVers='1.0.0';    $DocRev1='2020-11-18';     $DocIni='evs';  $ModulNo=0; ## File informative only

#   PHP to HTML generator
#   If you program html output in php, you can use this library's routines to generate the html code.
#
#   HTML elements INPUT / CHECKBOX / RADIO-GROUP / TABLE and others, generated from PHP-functions.
#   Combined with: Label, ToolTip, Placeholder, dimensions and others.
#   Included translate system. Font-awesome icons.
#   Extended table functions with Mottie Tablesorter-system.
#
#   Based on HTML5, CSS3
#   Source must be UTF-8, no tabs, indent: 4 chars
/*            _____  _       _                __ _
 *           |  ___|\ \    / /               / _| |
 *           | |__   \ \  / / ___  ___  ___ | |_| |_
 *           |  __)   \ \/ / |___|( __)/ _ \|  _| __)
 *           | |____   \  /       \__ \ (_) ) | | |_
 *           |______|   \/        (___)\___/|_|  \__)
 *
 */ $©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE'; /*

    Created: 2020-02-29 evs - EV-soft
    Latest revision: see files 1. line: $DocRevi
    R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
    2020-00-00 - evs  Initial
*/


### System init:
// session_unset();
session_start();

# CONSTANTS:
define('DEBUG',false);              # Set to true to activate system debugging
define('USEGRID',false);            # Use grid to place objects in rows / colums
define('ThousandsSep',' ');         # Used in number output
define('DecimalSep',',');           # Used in number output

# GLOBALS:
$ØTblIx= -1;                        # Index for table-id to separate multible tables in one page
$ØProgTitl= 'PHP2HTML';
$ØprogVers= 'Develop'. ' '.
$Øcopyright='EV-soft';
$Øcopydate= '2020-00-00';
$Ødesigner= 'EV-soft';
$ØmenuLogo= '21997911.png';

$ØblueColor= 'lightblue';
$ØBodyBcgrd= 'Tan';
$ØiconColor= 'DarkGreen';           # Panel-header icon
$ØTitleColr= 'DarkGreen';           # Caption text-color in panel-head
$ØPanelBgrd= 'transparent';         # Panels hideble background
$GridOn= true;                      # Use grid to place objects in rows / colums

if (is_null($rowHtml)) $rowHtml= '';

# PATHS:
if ($GLOBALS["ØProgRoot"]) $ØProgRoot= $GLOBALS["ØProgRoot"]; else
  $ØProgRoot=  '../';                 # $ØProgRoot=   "./../";  // "../";        //  Relative in 1. subniveau    #-$ØProgRoot= "./../../";   //  Relative in 2. subniveau
$_assets=     $ØProgRoot.'_assets/';
$_images=     $ØProgRoot.'_assets/images/';
$_base=   '';

# MENU-folders:
$folder1= $ØProgRoot.'';
$folder2= $ØProgRoot.'demoFile/';
$folder3= '';
$folder4= '';
$folder5= '';

$App_Conf['language'] = $_SESSION['proglang'];
$Ønovice= false;

## System required:
// require_once ($ØProgRoot.'translate.inc.php');
// require_once ($ØProgRoot.'filedata.inc.php');


# CONFIGURATION:
// if (empty($App_Conf)) $App_Conf= parse_ini_file()      read from file
    if (empty($App_Conf['language'])) $App_Conf['language'] = 'en : English';   // default language
        //else  $App_Conf['language'] = sessionStorage.getItem("proglang");
    if (empty($App_Conf['test'])) $App_Conf['test'] = 'TESTER';
// $lang = 'da';
// $lang = substr($App_Conf['language'],0,2);

if (false) { # Save/Get configuration to/from file:
    FileWrite_arr($filepath='app_Conf.ini',$arrName='$App_Confxx',$list=$App_Conf);
    $App_Confxx= FileRead_arr($filepath='app_Conf.ini');    // parse_str(file_get_contents('app_Conf.ini'), $App_Confxx);
    echo "<pre>".'$App_Confxx:<br>'; print_r($App_Confxx);  echo "</pre><hr>";
    echo $App_Confxx['language'];
    echo $App_Confxx['test'];
}

### NORMALY DON`T EDIT IN THE FOLLOWING CODE
#   You can add special custom code in the file: $custFile= '../customLib.inc.php'
#   else place it in the top of your .page.-file where it are needed

# DEBUGGING and erly declaring:
function arrPrint($arr,$name='',$proc=true) {  ## Output actual value of any variabeltype
    if ($name>'') $name.=': ';
    $result= "<br><textarea>".$name. print_r($arr). "</textarea><hr>\n"; // </pre>
    if ($proc) echo $result;
    else return $result;

}

function run_Script($cmdStr='') {
    echo "\n<script>\n".$cmdStr."\n</script>\n";
}

function set_Style($att='',$string='') {
    echo "\n<style ".$att.'>'.$string." </style>\n";
}

//echo '<style type="text/css"> <!--  @font-face { font-family: barcode; src: url('.$ØProgRoot.'_assets/fonts/barcode.ttf); } --> </style>';


### FUNCTIONS:

/* Active parameters in function htm_Input() by type:
$type:      $name   $valu   $labl   $hint   $plho   $wdth   $algn   $unit   $disa   $rows   $step   $more   $list   $llgn   $bord
'intg' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'text' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'dec0' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'dec1' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'dec2' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?

'num0' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'num1' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'num2' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'num3' :    $name   $valu   $labl   $hint   $plho   $wdth   $algn   ?       ?       ?       ?       ?       ?       $llgn   ?
'barc' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'mail' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?

'link' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'sear' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'file' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'imag' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'date' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'time' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'week' :    $name   $valu   $labl   $hint   -----   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'mont' :    $name   $valu   $labl   $hint   -----   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?

'rang' :    $name   $valu   $labl   $hint   -----   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'butt' :    $name   $valu   $labl   $hint   -----   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'colr' :    $name   $valu   $labl   $hint   -----   $wdth   ?       ?       ?       ?       ?       ?       -----   $llgn   ?
'phon' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'pass' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'area' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?

'html' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       ?       $llgn   ?
'chck' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       $list   $llgn   ?
'rado' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       $list   $llgn   ?
'opti' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       $list   $llgn   ?
'hidd' :    $name   $valu   $labl   $hint   $plho   $wdth   ?       ?       ?       ?       ?       ?       -----   $llgn   ?
*/

function htm_Input(# $type='',$name='',$valu='',$labl='',$hint='',$plho='@Enter...',$wdth='',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='',$list=[],$llgn='R',$bord='',$proc=true);
    $type,              # text, date, ... Look at source !
    $name='',           # Set the fields name (and id)
    $valu='',           # The current content in input field
    $labl='',           # Translated label above the input field
    $hint='',           # Translated description for the field
    $plho='@Enter...',  # Translated placeholder shown when field is empty. Default: Enter...
    $wdth='100%',       # Width of the field-container
    $algn='left',       # The alignment of input content Default: left
    $unit='',           # A unit added to the content eg. currency or % If in front: '<' it is added as a prefix, else a suffix
    $disa=false,        # Disable the field. Default: field is active
    $rows='2',          # Number of rows in multiline input (eg. area/html) Default: 2 (Radio/Check-list: 1 to output horisontal)
    $step='',           # the value of stepup/stepdown for numbers
    $more='',           # Give more (special / non system) input attrib
    $list=[],           # Data for "multi-list" (eg. options, checkbox, radiolist)
    $llgn='R',          # Label align Default: Right
    $bord='',           # BoxBorder color to mark required/optional field.   Default= 'border: 1px solid var(--grayColor);'
    $proc= true         # Act as procedure: Echo result, or as function: Return string
    ) {
    global $GridOn;
    $result= '';
    if ($hint=='') $hint= '@There is no explanation !';
    $hint= lang($hint);
    $labl= lang($labl);
    // if ($plho=='')  $plh=''; else $plh=' placeholder="'.lang($plho).'" ';
    ($plho=='') ? $plh='' : $plh=' placeholder="'.lang($plho).'" ';
    // if ($wdth=='')  $wdth= '200px';    // Default width
    if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
    if (strpos(' '.$more,'required')>0) $bord= 'border: 1px solid orange;';
#GRID:
    if ((USEGRID) and ($GridOn)) $result.= '<div class="grid-item">';
#FIELD:
    $result.= '<div class="inpField" id="inpBox" style="width: '.$wdth.'; margin: auto; display: inline-block;"> '; // float: left;
#INPUT:
    $inpIdNm=  ' id="'.$name.'" name="'.$name.'" ';
    $inpStyle= ' class="boxStyle" style="text-align: '.$algn.'; font-size: 14px; font-weight: normal; width: 90%; '.$bord; //boxStyle - border: 1px solid var(--grayColor);
    $eventInvalid= ' oninvalid="this.setCustomValidity(\''.lang('@Wrong or missing data in ').$labl.' ! \')" oninput="setCustomValidity(\'\')" ';

    //if (gettype($valu)== 'Float') $type= 'number';
    if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    $top= '';

    switch ($type) {
        case 'intg' : $result.= '<input type= "number" '.$inpIdNm. $more. $inpStyle. ' step:'. $step. '" value="'.$valu.'" '. $aktiv. $plh.' />';  break;
        case 'text' : $result.= '<input type= "text" '.  $inpIdNm. $more. $inpStyle. '" value="'. $valu.'" '. $eventInvalid. $aktiv. $plh.' />';  break;
        case 'dec0' : # Used for quantity - outputs unit as prefix or suffix
        case 'dec1' : # Used for Amount -  // SPACE as thousands separator
        case 'dec2' : $result.= '<input type= "text" '.  $inpIdNm. $more. ' value="'.$pref. number_format((float)$valu,(int)substr($type,3,1),DecimalSep,ThousandsSep).$suff. '" '.
                        $inpStyle. '"'. $eventInvalid. $aktiv. $plh. ' pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" />';  break;
        case 'num0' :
        case 'num1' :   // thousands separator ,|. is not allowed in number !  - https://codepen.io/nfisher/pen/YYJoYE/ - SPACE will be removed
        case 'num2' :   /* lang="en" to allow "."-char as decimal separator, and national ","-char */
        case 'num3' : $result.= '<input type="number" '. $inpIdNm. $more.' lang="en" step="'.$step.
//                            '" value="'.(float)number_format((float)$valu,(int)substr($type,3,1),DecimalSep,ThousandsSep).'" '. // FIXIT: Wrong output
                            '" value="'.$valu.'" '. 
                            $eventInvalid. $aktiv. $plh. ' pattern="(\d{3})([\.])(\d{2})"'.
                        $inpStyle. '" />';  break; // No unit but with browser type check ! 
        case 'barc' : $result.= '<input type= "text" '. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh.
                        $inpStyle. ' font-family:barcode; font-size:19px;'. '" />';  break;
        case 'mail' : $result.= '<input type= "email"'. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. 'pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"'.
                        $inpStyle. '" />';  break;

        case 'link' : $result.= '<input type= "url" '.  $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern='https?:/.+'. $aktiv. $plh. //'pattern="^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?"'.
                        $inpStyle. '" />';  break;

        case 'sear' : $result.= '<input type="search" '.$inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break;

        case 'file' : $result.= '<input type= "file" '. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break;

        case 'imag' : $result.= '<input type= "image" '.$inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. ' height: 18px;" />';  break;

        case 'date' : $result.= '<input type= "date" '. $inpIdNm. $more. $inpStyle. ' display:inline-block;'.' min-width: 115px; '. // if empty: color: green;
                                ' margin: 5px 0 0; padding: 8px 0 2px 2px;" value="'.$valu. '" placeholder ="yyyy-mm-dd" '. $aktiv.' />';  break;
        case 'time' : $result.= '<input type= "time" '. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break;
        case 'week' : $result.= '<input type= "week" '. $inpIdNm. $more. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv.' />';  break;
        case 'mont' : $result.= '<input type= "month" '.$inpIdNm. $more. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv.' />';  break;

        case 'rang' : $result.= '<span class="fieldContent boxStyle range-wrap" style="height: 28px;">'.
                            '<input class="range" type= "range" '.$inpIdNm. $more. ' value="'.$valu.'" '. $aktiv. 'onclick="setBubble('.$name.',\'bubble\')" style= "text-align: '.$algn.'; font-size: 12px; margin: 0; box-shadow: none;" /> '.
                            '<div class="bubble" style="font-size: 10px; top: -41px; position: relative; width: min-content; text-align: center; opacity: 80%;"> Min .. Val .. Max </div>'.
                            '</span>';  break;

        case 'butt' : $result.= '<span class="fieldContent boxStyle" style="min-height: 28px;">'.
                            '<input type= "button" '.   $inpIdNm. $more. ' value="'.$valu.'" '. $aktiv.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" /> </span>'; break; // No functionality !

        case 'colr' : $result.= '<span class="fieldContent boxStyle" style="height: 28px;">'.
                            '<input type= "color" '.    $inpIdNm. $more. ' value="'.$valu.'" '. $aktiv.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px;" /> </span>'; break;

        case 'phon' : $result.= '<input type= "tel" '. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh. $inpStyle. '" />';  break;

        case 'pass' : $result.= '<span class="fieldContent boxStyle" style="'.$bord.' text-align: left; height: 34px;">'.
                            '<div style="white-space: nowrap;">'.
                            '<input type= "password" '. $inpIdNm. $more. ' style="height: 8px; width: 67%; margin-top: -1px; box-shadow: none;" value="'.
                            $valu.'" '.$eventInvalid. $aktiv. $plh.' onkeyup="getPassword('.$name.')" />'.
                            htm_IconButt($type='button',$faicon='far fa-eye-slash',$lbl='', $title= lang('@Show/Hide password'),$id='tgl_'.$name,
                                 $link='',$action='onmousedown=\'togglePassword('.'tgl_'.$name.','.$name.')\'',$akey='',$size='').
                            '</div>';
                            $str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
                            $result.= '<meter id= "pwPoint'.$name.'" style="position:relative; top:-13px; height:6px; width:97%;" '.
                                'min="0" low="6" optimum="7" high="9" max="10" id="password-strength-meter" '.
                                'title="'.lang('@Password strength: 0..10').'">'. // $str.'"'. // ' <span id=\"mtPoint\"'.$name.'> 0</span>'. '/10"'.
                            '</meter>'; $result.= '</span>';    break;

        case 'area' : $result.= // TEXTAREA:
                        '<span class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 4px;"> <textarea rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="width:97%; font-size: 1em; border: 1px solid lightgray; border-radius: 4px;" '.
                        $eventInvalid. $aktiv. $plh.' '.$more.' >'.$valu.'</textarea>'; $top=' top: -8px; ';  break;

        case 'html' : $result.= // HTML-TEXT:
                        '<span class="fieldContent boxStyle" style="'.$bord.' top: -1px; padding: 10px 4px 4px;"> <small><div contenteditable="true" rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="background-color: white; min-height: '.($rows>'1' ? '34px;' : '5px;').' border: 1px solid lightgray; padding: 2px;" '. //  Like area, but with html-content
                        $eventInvalid. $aktiv. $plh.' data-placeholder="'.lang($plho).'" '. $more.' >'. $valu.'</div></small>';
                        if ($disa) $result.= '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>'; $top=' top: -8px; '; break;

        case 'chck' : $result.= // CHECKBOX:
                            '<span class="fieldContent boxStyle" style="'.$bord.'"><small>';
                            foreach ($list as $rec) { // $list= [['name','@Label','@ToolTip'], ['0:name',1:'@Label',2:'@ToolTip',3:'checked'], ['@Label','@ToolTip'],...]
                                $result.= '<input type= "hidden" name="'.$rec[0]. '" value="unchecked" /><label for="'.$rec[0].'"></label>'; # Hidden field because Unchecked boxes is not included in $_POST !
                                $result.= '<input type= "checkbox" name="'.$rec[0]. '" value="checked" '.$rec[3].' '.$valu.' style="width: 20px; box-shadow: none;"/>'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px;">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';

                            }   $result.= '</small></span>';  break;

        case 'rado' : $result.= // RADIO:
                            '<span class="fieldContent boxStyle" style="'.$bord.'"><small>';
                            foreach ($list as $rec) { // $list= [[0:'value',1:'Label',2:'@ToolTip',3:'checked'], ['Label','@ToolTip'],...]
                                if ($valu==$rec[0]) $chk= ' checked '; else $chk= '';
                                    $result.= '<input type= "radio" id="'.$rec[0].'" name="'.$name.'" value="'.$rec[0].'" '.$chk.$rec[3].' style="width: 20px; box-shadow: none;">'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px;">'. Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small></span>';  break;

        case 'opti' : $result.= // OPTION:
                            '<span class="fieldContent boxStyle"  style="'.$bord.' background-color; white; text-align: center; padding: 10px 4px 4px;"><small>';
                            $result.= '<select class="styled-select" name="'.$name.'" '.$events.' '.$eventInvalid.'style="width: 98%; '.$colr.'" '.$aktiv.'> '; dvl_pretty();
                            $result.= '<option label="'.lang($plho).'" value="'.$valu.'">'.lang('@Select!').'</option> ';  # title="'.$hint.'"     selected="'.$valu.'"
                            foreach ($list as $rec) { # $list= [[0:value, 1:name, 2:@ToolTip, 3:'checked', [...]]
                                $result.= '<option '. /* .'label="'.lang($rec[x]).'" '. */ 'title="'.lang($rec[2]).'" value="'.$rec[0].'" '.$state=$rec[3]; //  Firefox does not support Label !
                                if ($rec[0]==$valu) $result.= ' selected ';
                                $result.= '>'.$lbl=lang($rec[1]).'</option> ';
                            }   $result.= '</select></small></span>';  break;
    //  case 'show' : $result.= '<input type= "text"   id="'.$name.'" name="'.$name.'" value="'.$valu.'" disabled />';  break;
        case 'hidd' : $result.= '<input type= "hidden" id="'.$name.'" name="'.$name.'" value="'.$valu.'" />';  break;

        default     : $result.= ' htm_Input(): Illegal Type ! ';
        dvl_pretty();
    }

# LABEL & TIP:
    switch (strtoupper($llgn)) {
    case 'L': $lblalign = 'margin-right:  auto;';  break;   // Align label Left
    case 'C': $lblalign = 'margin:        auto;';  break;   // Align label Center
    case 'R': $lblalign = 'margin-left:   auto;';  break;   // Align label Right
    default:  $lblalign = 'margin-left:   auto;';
    }
    $result.= ' <abbr class= "hint">
                   <label for="'.$name.'" style="font-size: 12px; '.$top. '">
                        <div style="white-space: nowrap; '.$lblalign.'">'.$labl.'</div>
                   </label>
                   <data-hint style="top: 45px; left: 2px;">'.lang($hint).'</data-hint>
               </abbr>
            </div>'; # :FIELD

    if ((USEGRID) and ($GridOn)) $result.= '</div>'; # :GRID
    if ($proc==true) echo $result; else return $result;
} # :htm_Input()



function htm_Caption($labl='',$style='color:#550000; font-weight:600; font-size: 13px;',$align='',$hint='') {
  echo '<abbr class= "hint">
            <data-colrlabl style="'.$style.' text-align:'.$align.'">'.lang($labl).'</data-colrlabl>';
            if ($hint>'') echo '<data-hint> '.$hint.' </data-hint>';
  echo '</abbr>';
}
function htm_TextDiv($content,$align='left',$marg='8px',$more='box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray;') {
    echo '<div style="margin: '.$marg.'; text-align: '.$align.'; '.$more.'">'. $content. '</div>';
}

function htm_TextPre($content,$align='left',$marg='8px',$more='',$code=false,$font='') {
    if ($code) $content= htmlspecialchars($content); // convert: &lt;b&gt;bold&lt;/b&gt;
    if ($font>0) $font= ' font-family: '.$font.'; ';
    echo '<pre style="margin: '.$marg.'; text-align: '.$align.'; '.$font.' white-space: pre-wrap; '.$more.'">'. $content. '</pre>';
}

function htm_MiniNote($note) {
    echo '<br><small><small>'.lang($note).'</small></small>';
}
function htm_TextTip($capt='TIP',$body='',$width='',$colr='',$align='center') { // A text with a caption on colored row
    if ($width>'') $width= ' width:'.$width.'; ';
    if ($align=='center') $align= ' margin: auto; ';
    else if ($align>'') $align= ' text-align:'.$align.'; ';
    echo '<div style="'.$width. $align.'; border:1px solid gray; ">'.
        '<div style="background-color: '.$colr.'; color: '.invertColor($colr,true).';">'.$capt. '</div>'.
        '<div style="padding: 8px; ">'.$body.'</div>'.
    '</div>';
}

function invertColor($colr,$bw) { // Get max contrastcolor black or white
  # run_Script("function getHexColor(colorStr) {    // https://stackoverflow.com/questions/1573053/javascript-function-to-convert-color-names-to-hex-codes
  #     var a = document.createElement('div');      // Create html element
  #     a.style.color = colorStr;                   // Set the color
  #     var colors = window.getComputedStyle( document.body.appendChild(a) ).color.match(/\d+/g).map(function(a){ return parseInt(a,10); });
  #                                                 // Get the rgb-code form the element which is just appended to the body (so it is rendered), filter numbers and convert each number to an integer.
  #     document.body.removeChild(a);               // Remove the html element we just created
  #     return (colors.length >= 3) ? '#' + (((1 << 24) + (colors[0] << 16) + (colors[1] << 8) + colors[2]).toString(16).substr(1)) : false;
  #                                                 // Return the HEX code using zyklus code
  # }                                               // getHexColor('teal') // returns #008080, browser calculated
  # ");

    run_Script("function getHexColor(colorStr) {    /* Browser calculated ColrName2Hex */
        var a = document.createElement('div');
        a.style.color = colorStr;
        var colors = window.getComputedStyle( document.body.appendChild(a) ).color.match(/\d+/g).map(function(a){ return parseInt(a,10); });
        document.body.removeChild(a);
        return (colors.length >= 3) ? '#' + (((1 << 24) + (colors[0] << 16) + (colors[1] << 8) + colors[2]).toString(16).substr(1)) : false;
    }");
 //   $hex= run_Script("getHexColor($colr);");
 //   echo $hex;
 //   return run_Script("invertColor($hex, true)");
}

// echo 'XX:'.invertColor('LightPink',true).'YY';




/*
Layout of htm_Table:
|-------------------------------------------------------------------------------------------------------|
|                                                                                                       |
|                                           TABLE-Caption                                               |
|                                                                                                       |
|-------------------------------------------------------------------------------------------------------|
|         |                                   TABLE-HEAD                                      |         |
|         |-----------------------------------------------------------------------------------|         |
|         |                                                                                   |         |
|    R    |                                                                                   |    R    |
|    O    |                                                                                   |    O    |
|    W    |                                                                                   |    W    |
|    P    |                                                                                   |    S    |
|    R    |                                   ROWBody =                                       |    U    |
|    E    |                                   TABLE-BODY                                      |    F    |
|    F    |                                                                                   |    F    |
|    I    |                                                                                   |    I    |
|    X    |                                                                                   |    X    |
|         |                                                                                   |         |
|         |-----------------------------------------------------------------------------------|         |
|         |                                                                                   |         |
|         |                                    TABLE-FOOT                                     |         |
|-------------------------------------------------------------------------------------------------------|
|                                              Table-Notes                                              |
|-------------------------------------------------------------------------------------------------------|
*/
function htm_Table(# $TblCapt,$RowPref,$RowBody,$RowSuff,$TblNote,&$TblData,$FilterOn,$SorterOn,$CreateRec,$ModifyRec,$ViewHeight,$TblStyle,$CalledFrom,$MultiList)
    $TblCapt= array( #['0:Label',   '1:Width',    '2:Type',    '3:OutFormat', '4:horJust',      '5:Tip',    '6:placeholder', '7:Content';], ...
        ),
    $RowPref= array( #['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:Html'], ...
        ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) is 2% ColWidth can be used to => row-select-button
    $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:placeholder','7:default','8:[selectList]'], ...
        ),           # Field 4: $FieldProporties - is composed of: [horJust, FieldBgColor, FieldStyle, TdColor, SorterON, FilterON, SelectON,
    $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:value! '], ...
        ),
    $TblNote= '',           # HTML-string
    &$TblData,              # = array()= [{"name_0":value_0, "name_1":value_1, "name_2":value_2, "name_3":value_3, "name_4":value_4, "name_5":value_5, "name_6":value_6, "name_7":value_7, "name_8":value_8, "name_9":value_9},{...},{...}]
    $fldNames=[],           # FieldNames in array created on submit. Also used to sort data fields
    $FilterOn= true,        # Ability to hide records that do not match filter // Does not work with hidd fields!
    $SorterOn= true,        # Ability to sort records by column content
    $CreateRec=true,        # Ability to create a record
    $ModifyRec=true,        # Ability to select and change data in a row
    $ViewHeight= '400px',   # The height of the visible part of the table's data
    $TblStyle= '',          # Style for the span that holds the table;
    $CalledFrom='',         # = __FILE__ / __FUNCTION__ (debugging: locate error)
    $MultiList= ['',''],    # LookupLists for options // Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
    $ExportTo= ''           # Export values in table fields (only ROWBody-cols) to CSV-file
)
                            # Field 4: $FieldProporties - is composed of: [horJust, FieldBgColor, FieldStyle, TdColor, SorterON, FilterON, SelectON, ]
                            # 0:horJust - Arguments to .td: style="text-align:
                            # 1:FieldBgColor - Arguments to .td: background-color:
                            # 2:FieldStyle - complete expression, e.g.: 'font-style:italic; '
                            # 3:TdColor - like 1: but used for "row marking"
                            # 4: 5: 6: ...
                            # Only impact on Body areas.

# !  FIXIT:  Fixed/Sticky header only works on 1st table when there are several tables in the same window!
# !          Zebra streaks (Update Issue!) Failure, as well as filter problems when hidden columns are also present.
# !  FIXIT:  Change value in INPUT dont only works i 1. table on page.

{ global $ØblueColor, $ØLineBrun, $ØRollTabl, $ØHeaderFont, $ØIconStyle, $ØPanelIx, $ØTblIx, $ØrowCount, $Ønovice, $rowHtml, $ordrTotal;
    $creaInpBg= 'LightYellow';
    $ØBodyBcgrd= 'yellow';
    //$selectable= (($ModifyRec) and ($RowBody[0][2]=='indx'));
    $selectable= false;
    //if (!$TblData) {msg_Info ('No data', 'The data table is empty!'); $TblData=[]; };  //  exit;
    if (DEBUG) dvl_pretty('Start-htm_Table: '.$CalledFrom);
    if (!$selectable) $RowSelect= '';
    else    { $RowSelect= '<span class="tooltip"><span style="font-size:115%;">&#x21E8;</span>'.
                            '<span class="LblTip_text" style="bottom: -12px; left: 65px">'.lang('@Selectable: ').str_nl(1).
                            lang('@This row can be selected by clicking Id/Number in the first field of the row.').'</span></span>';
            }
    if ($FilterOn)  { $filtInit= ' filter-true '; }   else $filtInit= ' filter-false '; // filter-select
    if ($SorterOn)  { $sortInit= ' sorter-inputs '; } else $sortInit= ' sorter-false '; // General for all columns
    if (($SorterOn===true) and ($TblNote===''))
        $TblNote= '<small><small>'.lang('@Filtering: Hold mouse over the colored row below the column headers.').'</small></small>';           # HTML-string
    
    $ØTblIx++;          //  0..7 on a page
    $tix= 'T'.$ØTblIx;  //  Tabel index for flere tabeller i samme vindue

    if (!function_exists('RowKlick')) {
        run_Script( 'function rowLookup(CalledFrom,valu,RowIx,ColIx) { window.alert("'.lang('@You pressed ').'" + valu + '.
            '"\nNothing is happening yet...\nRelates to: "+ CalledFrom +" Row: "+ RowIx );'.
            ' }');
        function RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$fldNames,$CalledFrom) {
            if (!$ModifyRec) {return $rowix;} else return
            '<span style=" padding:3px 0;" onclick="rowLookup(\''.$CalledFrom.'\',\''.$valu.'\',\''.$RowIx.'\',\''.$ColIx.'\')" >'.
            '<input name="'.$fldNames[$ColIx].'[]"
                style="width:99%; text-align: center; text-decoration: underline; color: blue; cursor:zoom-in;"
                readonly
                value="'.$valu.'" />'.
            '</span>';
        };
    }

    $Width= '98%';
    echo '<span class="tableStyle" name="tblSpan" style="width:'.$width.'; padding: 8px; '.$TblStyle.'">';
### Caption line:
    if ($TblCapt[0][0]>'') {    dvl_pretty();    // htm_nl(1);
        if ($TblCapt) foreach ($TblCapt as $Capt) { // $Capt[x]: 0:Label 1:width 2:type 3:name 4:align 5:titletip 6:default 7:value
            $mode= '" placeholder="';
            echo ' '.lang($Capt[0]);  //  Label:  (feltPrefix)
            switch ($Capt[2]) {  # Special outputs:
                case 'show' : $mode= '" disabled value="';              break;
                case 'rows' : echo count($TblData).' '.lang($Capt[6]);  break;  //  $Capt[6]= feltSuffix
                case 'html' : echo ' '.lang($Capt[7]);                  break;
                case 'data' : echo ' <input type= "'.$Capt[2].'" name="'.$Capt[3].'" title="'.lang($Capt[5]).   //  Input-field with name
                    $mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;'; break;
                default:      echo ' <input type= "'.$Capt[2].'" title="'.lang($Capt[5]).   //  Input-field without name (not saved!)
                    $mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;';
            }
        } // foreach-TblCapt

    if ((count($TblCapt)>1) or ($Capt[1]>"40%")) htm_nl(); //  false: At narrow panel
    if ($Ønovice==true) {
        htm_sp(5);
        if ($SorterOn)  {echo $sor= htm_IconButt($type='submit',$faicon='fas fa-sort',$id='',$labl='@Sort?',
            $title= lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.'),
            $link='#',$action='',$akey='','12px'); }
        if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-plus',$id='',$labl='@Filter?',
            $title= lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
                    lang('@Enter a search term here to display only data that matches the term.'),
            $link='#',$action='',$akey='','12px'); }
        if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-minus',$id='',$labl='@Show everything!',    //<button type="button" class="reset">lang( ' @Vis alt')</button>
            $title= lang('@Reset filter so that all data is displayed. With ESC you can reset the search term in the field you are in.'),
            $link='#',$action='',$akey='','12px'); }
        if ($ModifyRec) {echo $ret= htm_IconButt($type='submit',$faicon='fas fa-pen-square',$id='',$labl='@Edit?',
            $title= lang('@In some of this table`s columns, you can correct data. They are marked with · in the column heading.').str_nl().
                    lang('@If the table cannot be saved, the correction must be done on a retail card.'),
            $link='#',$action='',$akey='','12px'); }
        if ($CreateRec) {echo $til= htm_IconButt($type='submit',$faicon='fas fa-plus',$id='',$labl='@Add?',
            $title= lang('@Do you want to add data: <br>At the bottom of the table there are fields you can fill with new data. ').
                    lang('@Click the "Create" button above the last field to save the new data.'),
            $link='#',$action='',$akey='','12px'); }
        if (true)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-arrows-alt-h',$id='',$labl='@Keys ',
            $title= lang('@Move cursor in tables:').'<br><data-yelllabl>'.lang('@TAB-key').'</data-yelllabl> '.
            lang('@jumps to the next field.').' <data-yelllabl>'.lang('@SHIFT TAB-key').'</data-yelllabl> '.lang('@skips to the previous field.').
            ' <data-yelllabl>'.lang('@SPACE-key').'</data-yelllabl> '.lang('@scrolls side down').
            ' <data-yelllabl>'.lang('@SHIFT SPACE-key').'</data-yelllabl> '.lang('@scrolls side up').'<br>'.
            lang('@The cursor must be in the table.')
            /* .'  <br><data-yelllabl>'.lang( '@CTRL arrow-keys').'</data-yelllabl> '.lang( ' @virker ikke. ' */
            ,$link='#',$action='',$akey='','12px'); }
    }
  } dvl_pretty();


### Table-start:
    echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$ViewHeight.'; display: block;">'; //  "Table-window": Container for tabel  display: inline ?
    echo '  <div id="overlay'.$ØTblIx.'"></div>';
    echo '    <table class="tablesorter" id="table'.$ØTblIx.'" style="width:auto; padding:1px; margin:0;">'; //  id= 'table'.$ØTblIx  0..6
    echo '    <thead>';
    $filter_cellFilter= []; //  [ '', 'hidden', '', 'hidden' ]
    $resizable_widths = [];
    if ($ExportTo > '') $Export= true; else $Export= false;
    if ($Export) $cvrData= '@:';  // cvrData: Used to export data in table body

### Columns-LABELS with sorting and filtering:
    echo '    <tr style="height:32px;">';
    //if ($selectable) echo  '<th> </th>';
    foreach ($RowPref as $Pref) { dvl_pretty();
        echo '<th class="filter-false sorter-false" style="width:'.$Pref[1].' align:'.$Pref[4][0].'; '.$ØHeaderFont.'"> '.
                Lbl_Tip($Pref[0],$Pref[5],'SO',$h='0px').' </th>';
        $resizable_widths[]= $Pref[1];
    }   $cNo= -1;
    $hiddcount= 0;
    $datCount= 0;

    if (is_array($TblData[0])) $datCount= count($TblData[0]); else $datCount= count($TblData);
    $fldCount= count($fldNames);
    // if ($datCount!= $fldCount)  echo '<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>';
    // toast('<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>');
    
    if ($selectable) echo  '<th class="filter-false sorter-false" > </th>';
    foreach ($RowBody as $Body) { dvl_pretty();
        $colfilt= ' ';
        $resizable_widths[]= $Body[1]; # ColWidth
        if (($GLOBALS["Øshow"]>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
        // if ($Body[8]==true) $selt= ' filter-select filter-onlyAvail'; else $selt= ' ';  //  FIXIT: sorting of datefields don’t works!
        if ($Export) $cvrData.= '"'.lang($Body[0]).'",';

        if ($Body[2]=='hidd') // FIXIT: showing filter-fields, gets columns out of syncronisation ! - $filter_cellFilter obvious don’t work: https://mottie.github.io/tablesorter/docs/#widget-filter-cellfilter
            { array_push($filter_cellFilter, 'hidden');
                $hiddcount++;
                echo '<th class="filter-false sorter-false" style="width:0; display:none;" ></th>'; // FIXIT: Filter-fields is showing hidden columns ! <td data-column="9" style="display:none" > fixes it
            } //  visibility:hidden;    //  columnSelector_columns : { 5 : false, 6 : false}
        else // Special behavior:
            { $cNo++; array_push($filter_cellFilter, '');
                if (($ModifyRec==true) and (in_array($Body[2],['text','data','date','osta','ddwn']) ))   # if editable:
                     { $lblsuff= str_nl().lang('@Editable'); $label= $Body[0]; }
                else { $lblsuff= '' /* str_nl().lang('@Not editable!') */ ; $label= markAllChars($Body[0],'div','style="opacity:0.7; margin: 2px;"'); }

                if ($cNo<=1) $tipplc='SO'; else if ($cNo=1) $tipplc='S'; else $tipplc='SW';
                if ($cNo==count($RowBody)) $tipplc='SW';
                // if (addParser:) class="tags filter-parsed" data-value="sweden"
                if (    // (true) or 
                    (($fldNames[0]=='ord_id') and ($fldNames[$cNo]=='ord_stat')) 
                    )  // Table-orders Status-field
                     $pars= ' filter-parsed ';
                else $pars= '';
                $sort= $sortInit;
                switch ($Body[2]) { // '2:ContType'
                    case 'date': $sort.= ' sorter-isoDate '; break;
                    //case 'html': 
                    case 'hidd': $sort= ' sorter-false '; break;
                        // sorter-no-parser   sorter-text  sorter-digit  sorter-currency  sorter-url  sorter-isoDate  sorter-percent
                        // sorter-image  sorter-usLongDate  sorter-shortDate  sorter-shortDate  sorter-shortDate sorter-time
                    default:  $sort.= ' sorter-text ';
                }
                // if ($Body[3]=='2d') $sort.= ' sorter-currency sorter-digit ';  // '3:OutFormat'
                if ($Body[4][3]===false) $sort= ' sorter-false '; // '4:[horJust_etc]
                if ($Body[5]=='@The name of file or directory') // GoBack in file/space explorers header:
                    $goBack= str_WithHint(
                        $labl='<a href="'.$GLOBALS['goback'].'" target="_self" style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 199;">
                                <i class="fas fa-chevron-circle-left" style="color: blue; box-shadow: 3px 3px 1px lightgray;"></i></a>',
                        $hint= '@Go back to parent folder: '.end(explode('/',$GLOBALS['goback'])) );
                else $goBack='';
        echo '<th class="'. $filtInit. $pars. $selt. $sort. $colfilt.'" data-placeholder= "'.lang('@Filter...').'" style="width:'.$Body[1].'; '.
             $ØHeaderFont.' text-align:center;">'.$goBack.Lbl_Tip($label,$Body[5].$lblsuff,$tipplc,$h='0px').' </th>';
    }}
    foreach ($RowSuff as $Suff) { dvl_pretty();
        $resizable_widths[]= $Suff[1];
        echo '<th class="filter-false sorter-false" style="width:'.$Suff[1].'; align:'.$Suff[4][0].'; '.$ØHeaderFont.'">'.
             Lbl_Tip($Suff[0],$Suff[5],'SW',$h='0px').'</th>';
    }
    //echo '<th>'.'</th>';
    echo '    </tr>';    dvl_pretty();
    if ($Export) $cvrData= rtrim($cvrData,',')."\n"; 
    
    // arrPrint($resizable_widths,'$resizable_widths');
    run_Script("widgetOptions: {
      resizable: true,
      resizable_widths = $resizable_widths
    }");
    set_Style('','$("#table'.$ØTblIx.'").tablesorter({ widgetOptions { filter_cellFilter: ["'.implode('","',$filter_cellFilter). '"]}}');   // Hide input filter fields fore hidden columns

### Column-FILTER:   (created of tablesorter, but there are a problem with hidd-fields!) filter-onlyAvail
    echo '    </thead>';

### TableFooter with the options to create a new record:
    if (false) {
        echo ' <tfoot>';
        echo ' </tfoot>';
    }

/*
    if ( !valid ) {
                $rows.each( function( indx, el ) {
                    var cell = el.parentElement.nodeName;
                    if ( cells.indexOf( cell ) < 0 ) {
                        cells.push( cell );
                    }
                });
                console.error(
                    'Invalid or incorrect number of columns in the ' +
                    cells.join( ' or ' ) + '; expected ' + columns +
                    ', but found ' + len + ' columns'
                );
            }
 */


### DATA and html-objects:
    echo '     <tbody>';
    if (!function_exists('RowBg')) {
        function RowBg($clr,$alg,$pos='') { if ($pos>'') $bord= ' border-'.$pos.':3px solid var(--grayColor); '; else $bord= '';
        return ' background:'.$clr.'; vertical-align:'.$alg.'; height:1.5em; '.$bord.' '; };
    }

    $RowIx=-1;
    if ($TblData)
        foreach ($TblData as $DataRow) {
            $arrTmp= [];
            $rowField= '';
            $newRow= '';
            $parser= 'headers: {  ';
        //  foreach ($fldNames as $fld) {   // Sort data to correct output order   FIXIT
        //      $arrTmp[$fld]= $DataRow[$fld];
        //  }
        //  $DataRow= $arrTmp;

            if (is_array($DataRow))
            $DataRow= array_values($DataRow);
            $RowIx++; dvl_pretty();
            //echo '<tr class="row" id="row_'.$RowIx.'">';  //  Tablesorter with Zebra-striped background
            if (count($RowBody)>0)
            echo '<tr class="row">';  //  Tablesorter with Zebra-striped background
            ## Fields before data-fields:
            foreach ($RowPref as $Pref) {
                $rowField.= '<td style="width:'.$Pref[1].'; text-align:'.$Pref[4][0].'; ">'.lang($Pref[6]).' </td>';
                $newRow.= '<td><div style= "background-color: gray;"> </div></td>';
            }
            if ($selectable) $rowField.=  '<td style="text-align:right; width:2%;">'.$RowSelect.'</td>';

    ### Table-BODY-Rows:
            $optlist= $MultiList;
            $ColIx= -1;
            $rowHtml= '';
            $rowBg= '';
            $inpBg= ' background-color:transparent;';   //' background-color: white; opacity:0.60; '; //$inpBg= ' background-color:rbg(200,200,200,0.3);';  //' background-color: white; opacity:0.60; ';
            ## Fields with data:
            $GotoEdit= ' class="clsFocus" '; // Goto FirstField in created row
            foreach ($RowBody as $Body)
                if ($ColDrop> 0) {/* Drop Column after colspan */ $ColDrop= $ColDrop-1; $ColIx++;}
                else
                { $ColIx++;    dvl_pretty();
                    $SelectList= $Body[8];
                    if (is_array($DataRow[$ColIx])) $valu= $DataRow[$ColIx][0];
                    else                            $valu= $DataRow[$ColIx];
                    $sortData= ' data-sort= "'. $RowIx. /*trim($valu,' '). /* */ '" ';   // Used to sort on unformatted raw data
                    if ($Export) {
                        if (strlen($valu)>30) $cvrData.= '"'.'To complex !'.'",';
                        else $cvrData.= '"'.$valu.'",';  // Unformatted data
                    }

            ## Special Output formats:
                if (!$GLOBALS["Øshow"]>0)
                    switch ($Body[3]) { # OutFormat
                        case '0d': if ($valu==null) $valu= 0;       else $valu= number_format((float)$valu, 0,',',' '); break;
                        case '1d': if ($valu==null) $valu='';       else $valu= number_format((float)$valu, 1,',',' '); break;
                        case '2d': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2,',',' '); break;  //  88 888 888,88
                        case '2%': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2).' %';    break;
                        case '>0': if (!(float)$valu>0) $valu= ' ';       break; // 0 an less is shown as BLANK
                        case '= ': $valu= ' ';                            break; // Values is shown as BLANK
                        default: $valu= $valu;
                    }

                $flag= substr($valu,1,2);
                if (($flag=='::') or ($flag==':.')) $valu= substr($valu,2).' '; // fieldFlag is not shown. SPACE so placeholder is not shown.

            // if (is_readable('customRules.inc.php')) include('customRules.inc.php');
            ## RowRules:
                if ($fldNames[0]=='pln_nmbr') { // Account Plan
                    $fieldHide= false;
                    if ($DataRow[2]=='Header')  { $rowBg=' background-color: LightSteelBlue; '; $fieldHide= true;}
                    if ($DataRow[2]=='NewPage') { $rowBg=' background-color: black; '; $fieldHide= true;}

                    if ($DataRow[2]=='SumFrom')   { $rowBg=' background-color: AntiqueWhite; opacity:70%;'; }
                    if ($DataRow[2]=='Operation') { $rowBg=' background-color: lightred; opacity:70%;'; }
                    if ($valu=='') $valu= ' '; // Hide placeholder-text
                }
                 if (($fieldHide== true) and ($ColIx>1)) { $valu= ' '; $emptyTD= true; } else $emptyTD= false;

            ## ColRules:
                if (is_string($Body[4][0]))  $txAlign= ' style="text-align:'.$Body[4][0].'; '; else $txAlign= '';
                if (is_string($Body[4][1]))  $bgColor= ' background-color:'. $Body[4][1].'; '; else $bgColor= '';
                if (is_string($Body[4][2]))  $fltStyl= ' '.                  $Body[4][2].' ';  else $fltStyl= '';   // i.e.: 'font-style:italic; '
                if (is_string($Body[4][3]))  $tdColor= ' background-color:'. $Body[4][3].'; '; else $tdColor= '';

            ## Special conditional "row"-formats:
                if ($MultiList==['','']) $kontotype= '';

                if (is_array($DataRow))
                if ($ColIx<count($DataRow)) {  //  If colspan is there stopped here, when the row is over
                    // if ($emptyTD== true) $rowField.= '<td>'; else
                    $rowField.= '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.$bgColor.$tdColor.$rowBg.$colsp; //  tablefield-property

                ## Special InputTypes in tablefields:
                if ($GLOBALS["Øshow"]>0) $Body[2]= 'text';
                if ($emptyTD== true) $rowField.= '">'; else
                switch ($Body[2]) { # ContType
                    case 'ddwn' : $rowField.= '"'.$sortData.'>'.DropDown($name= $fldNames[$ColIx].'[]', $valu, $list= $SelectList[0], $more= $SelectList[1].'; ');  
                                  // $rowField.= '-XXX-';
                                  // if ($RowIx==1) 
                                  $parser.= $ColIx. ': { sorter: "select" }, ';
                                  // headers: { 8: { sorter: 'select' } },
                                  break;
                    case 'vars' : $rowField.= '"'.$sortData.'>'.' <div style="margin-right:0; font-size:x-small">'.
                                       '<select class="styled-select" name="liste" style="max-width:120px"> <option value=" " >-';
                                    foreach ($optlist as $rec) {
                                      $rowField.= "\n".'<option label="'.$rec[2].'" value="'.$rec[1].'" '.$rec[3];
                                      if ($rec[1]==$valu) $rowField.= ' selected ';
                                      $rowField.= '>'.$lbl=$rec[2].'</option> ';
                                    }
                                  $rowField.= '</select></div> ';   break;
                    case 'chck' : $rowField.= '"'.$sortData.'>'.'<input type= "checkbox" name="chck" value="" '.$valu.' ';          break;    //  Checkbox-selector:
                    case 'bold' : $rowField.= '"'.$sortData.'>'.'<input type= "checkbox" name="bold" value="" '.isbold($valu).' ';  break;
                    case 'ital' : $rowField.= '"'.$sortData.'>'.'<input type= "checkbox" name="ital" value="" '.isital($valu).' ';  break;
                
                ### SPECIAL:
                    case 'calc' : /* if ($Body[8][3] == '2d') */ {
                                    // [1, '45-876', 2:$antal=3, 'stk', 'Redekasser', 5:$momssats=25, 6:$pris=235.50, 7:$rabat=8,  $sum=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                                  $sum= (toNum($DataRow[2])*toNum($DataRow[6]))*(100-toNum($DataRow[7]))/100*(100+toNum($DataRow[5]))/100;
                                  $rowField.= '"> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$sum, 2,',',' '). '" placeholder="'.lang($Body[6]).'"'.
                                       $txAlign.$inpBg.' width:98%; " readonly /> '; };
                                  $ordrTotal+= $sum;
                                  break;

                ### STANDARD:
                    case 'date' : if (($valu==' ') /* or ($valu==NULL) */) $clr= 'color: transparent; '; else $clr= '';  // Skjul browserens placeholder ved at angive SPACE
                                  $rowField.= '"'.$sortData.'>'.'<input type= "date" name="'.$fldNames[$ColIx].'[]" '. //  (id="'.$name.'")
                                          'style="line-height: 100%; text-align: left; font-size: revert; height:16px; max-width: 150px; z-index: auto; '.$clr. $inpBg.
                                           '" value="'.$valu. '" placeholder="yyyy-mm-dd" '.$aktiv.' />';  break; // The Browser uses its own placeholder!
                                  # (FIXIT:) In Chrome the field-width is to wide !
                    case 'html' : $rowField.= '"'.$sortData.'>  '.$valu;  break;                                                // Only showing HTML
                    case 'htm0' : $rowField.= '"'.$sortData.'>  '.'<small><small>'.$valu.'</small></small>';  break;            // Only showing HTML
                    case 'show' : if ($valu==' ') $clr= 'color: transparent; ';                                   // Only showing data:
                                  else $clr= '';                                                                  // Hide the browsers placeholder by using a SPACE
                                  $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.$valu. '" placeholder="'.lang($Body[6]).'"'.
                                       $txAlign.$inpBg.' width:98%; '.$clr.' " readonly /> ';
                                  break;
                //  case 'helt' : // Danish only !
                    case 'intg' : $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$valu, 0). //  0 dec. = Integer
                                       '" placeholder="'.lang($Body[6]).'"'.$txAlign.$inpBg.
                                       ' width:98%; padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'data' : //  Show and edit data:
                    case 'area' : if ($valu=='New field')  {  # Create new record
                                    $rowField.= '"'.$sortData.'> '.lang('@New field:').' <div style="margin-right:0; font-size:x-small">'.
                                         '<select class="styled-select" name="liste"> <option value=" " >-';
                                      foreach ($ordlist as $rec) {
                                        $rowField.= '<option label="'.$rec[2].'" value="'.$rec[1].'" '.$rec[3];
                                        if ($rec[1]==$valu) $rowField.= ' selected';
                                        $rowField.= '>'.$lbl=$rec[2].'</option> ';
                                      }
                                    $rowField.= '</select></div> ';
                                  } else # Show editable datafield:
                                    $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                         'value="'.htmlentities(stripslashes(lang($valu))).'" placeholder="'.lang($Body[6]).'"'.
                                         $txAlign.$inpBg.' width:98%; padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'keyn' : //  Selectable and editable index
                                  $rowField.= '"'.$sortData.'><span style="font-size:small"  name="'.$fldNames[$ColIx].'[]" title="'.
                                    lang('@The row is selectable. Click here to edit the row`s fields').'">'.RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$fldNames,$CalledFrom).
                                  '</span>';
                                  break;
                    case 'indx' : //  Selectable but not editable index
                                  $rowField.= '"'.$sortData.'><span style="font-size:small;" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.
                                        RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$fldNames,$CalledFrom).' </span>';
                                  break;
                    case 'blnk' : //  Value is displayed as BLANK
                                  $rowField.= '"'.$sortData.'><span name="'.$fldNames[$ColIx].'[]"  > </span>';
                                  break;
                    case 'hidd' : //  Hidden data is included as hidden columns to have a complete record (simplifies updating):
                                  $rowField.= 'width:0; padding:0; border:none; display:none;"'.$sortData.'>  <input type= "hidden" name="'.$fldNames[$ColIx].'[]" '.  //   visibility:hidden;
                                       'value="'.htmlentities(stripslashes(lang($valu))).'" '.$txAlign.$inpBg.' width:0;" /> ';
                                  break;
                                 // text:
                    case 'text' :
                    case 'sttu' :   // "unused" Status
                                { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.$valu.'" '. //'contentEditable="true" '.
                                       ' placeholder="'.lang($Body[6]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%;" /> ';  //  font-style:inherit;
                                  break;
                                }
                    default   : { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.$valu.' '.$Body[2].'" '.'placeholder="'.lang($Body[6]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%;" /> ';
                                       // toast('Invalid type: '.$Body[2].' in htm_Table() - error !','orange','black');
                                }
                    }   // :switch InputTypes
                    $rowField.= '</td>';
                }      // '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.
                if ($Body[2]!='hidd') {
                    if ($Body[0]=='@Order Date') $currDate= date('Y-m-d'); else $currDate='';
                    $newRow.= '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].';" >'. # ColWidth
                              '<input type= "text" '.$GotoEdit.' name="'.$fldNames[$ColIx].'[]" value="'.$currDate.'" placeholder="'.lang($Body[6]).'"'.$txAlign.' width: 98%;  background-color: lightyellow; font-style:inherit;" /> </td>';
                              if (!in_array($Body[2],['show','indx','calc'])) $GotoEdit= '';
                              }
            };  //  foreach $RowBody
            $parser= substr($parser,0,-2).' },';
            echo $rowField;
    
    

        ### Table-BODY-RowSuffix:
                ## Fields after data-fields:
                foreach ($RowSuff as $Suff) { dvl_pretty();
                    if ($ModifyRec) {
                        $output= $Suff[6];
                        if ($Suff[2]=='button') { ## RowSuffix - Special Buttons:
                            $btnStyle= '" class="tooltip" style="height:20px; border:0; box-shadow:none; background-color:transparent;" ';
                            $btnSuff= $ØTblIx.'_'.$RowIx. $btnStyle;
                            if ($Suff[0]=='@Delete')  { if ($Suff[3]=='dis') $dis= 'disabled'; else $dis= '';
                                                       $output='<button type= "submit" name="btn_del_'.$btnSuff.$dis.' >'.
                                                    Lbl_Tip($Suff[6],lang('@Delete pos: ').$RowIx.' ('.$dis.')','SW','0px'). '</button>'; }   // Buttons that must not be deleted can be deactivated
                            if ($Suff[0]=='@Hide')   { $output='<button type= "submit" name="btn_hid_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Hide pos: ').$RowIx,'SW','0px'). '</button>'; }                   // Records that must not be deleted can be hidden
                            if ($Suff[0]=='@Copy')   { $output='<button type= "submit" name="btn_cpy_' .$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Copy pos: ').$RowIx,'SW','0px'). '</button>'; }
                            if ($Suff[0]=='@Rename') { $output='<button type= "submit" name="btn_ren_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Rename pos: ').$ØTblIx.'_'.$RowIx,'SW','0px'). '</button>'; }
                            if ($Suff[0]=='@Select') { $output='<input type= "checkbox" name="btn_sel_'.$btnSuff.
                                                    Lbl_Tip($Suff[6],lang('@Select pos: ').$RowIx,'SW','0px'). ' />'; }
                        }
                        echo '<td style="text-align:'.$Suff[4][0].'; width:'.$Suff[1].';" disabled >'.$output.'</td>';
                    }
                    $newRow.= '<td><div style= "background-color: gray;"> </div></td>';
                }   //  [' @Slet',     '4%',         'text',         '',        'center',   ' @Klik på rødt kryds for at slette  ', '<ic class="far fa-times-circle" style="color:red; font-size:13px;"></ic>']
                //  ['0:ColLabl', '1:ColWidth', '2:ContType', '3:Format', '4:FeltJust', '5:ColTip', '6:value!     '            ]
            //echo '<td>'.'</td>';
            echo '</tr>';
            if ($Export) $cvrData= rtrim($cvrData,',')."\n";

    } //  foreach $TblData
    $_SESSION["ØrowCount"]['T'.$ØTblIx]= $RowIx;

    echo '</tbody>';
    echo '</table>';
    echo '</span>'; //  wrapper
    if ($Export) {  // echo '<br>'.$cvrData;
        $fp= fopen($ExportTo,"w");
        if ($fp) { fwrite($fp,$cvrData."\n"); fclose($fp); }
    }

### Init Tablesorter:
    run_Script("
        $('#table".$ØTblIx."').tablesorter({
            theme: 'blue',"
            .$parser."
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
                filter_reset : '.reset'
            }
        });
        // https://stackoverflow.com/questions/19413025/use-tablesorter-to-filter-selected-items-in-options-list-chosen
        // if (addParser:)
        $.tablesorter.addParser({
            id: 'select',
            is: function () { return false; },
            format: function (s, table".$ØTblIx.", cell) {
                return ($(cell).find('select').val() || []).join(',') || s; },
        });
        $.tablesorter.addParser({
            id: 'data',
            is: function(s, table, cell, Scell) {
              return false; },
            format: function(s, table".$ØTblIx.", cell) {
              var Scell = $(cell);  
              return Scell.attr('data-sort') || s; }
        });

    ");
/*
$(function() {

  $.tablesorter.addParser({
    id: 'data',    // set a unique id
    is: function(s, table, cell, $cell) {      // return false so this parser is not auto detected
      return false;
    },
    format: function(s, table, cell, cellIndex) {
      var $cell = $(cell);     // I could have used $(cell).data(), then we get back an object which contains both
                               // data-lastname & data-date; but I wanted to make this demo a bit more straight-forward
                               // and easier to understand.
      if (cellIndex === 0) {   // first column (zero-based index) has lastname data attribute
        return $cell.attr('data-lastname') || s;    // returns lastname data-attribute, or cell text (s) if it doesn't exist
      } else if (cellIndex === 2) {                 // third column has date data attribute
        return $cell.attr('data-date') || s;        // return "mm-dd" that way we don't need to use "new Date()" to process it
      }
      return s;     // return cell text, just in case
    },
    parsed: false,  // flag for filter widget (true = ALWAYS search parsed values; false = search cell text)
    type: 'text'    // set type, either numeric or text
  });

  $('table').tablesorter({
    theme: 'blue',
    headers: {
      0 : { sorter: 'data' },
      2 : { sorter: 'data' }
    },
    widgets: ['zebra']
  });

});
*/
if ($CreateRec) {
    $rowField= str_replace('<td','<td style="background-color: lightyellow;" ',$rowField);
    //$rowField= str_replace('"','\"',$rowField);
    $newRow= '`<tr style=" border: 3px solid red;">'.$newRow.'</tr>`';
    echo htm_AcceptButt($labl='<i class="fas fa-plus"> </i> '.lang('@Create new row'),
                            $title=lang('@Create an empty row, so you can fill in data in the yellow fields ! '), $btnKind='spc2',
                            $form='form_'.$ØPanelIx.'_'.$ØTblIx, $width='200px; min-height:16px;', $akey='c', $proc=false, $tipplc='LblTip_NW', $tipstyl='position: absolute; bottom: 80px; right: 100px;',
                            $clicking='appendRow(table'.$ØTblIx.','.$newRow.')');
}
    echo '<br>'.$TblNote;
    echo '</span>'; // tableStyle
    if (DEBUG) dvl_pretty('End-htm_Table: '.$CalledFrom);
} // htm_Table


function htm_PanlHead($frmName='', $capt='', $parms='', $icon='', $class='panelWmax', $where='Undefined', $more='', $BookMark='', $panlBg='background-color: white;')
{ # MUST be followed of htm_PanlFoot !
    global $ØiconColor, $ØTitleColr, $ØPanlForm, $ØProgRoot, $_assets, $ØPanelIx, $ØPanelBgrd, $GridOn;
    $ØPanelIx++;
    echo '<script>';  //  Hide/show Panel-Body
    echo 'function PanelSwitch'.$ØPanelIx.'() {
                var h = document.getElementById("HideDiv'.$ØPanelIx.'");
                var p = document.getElementById("panel'.$ØPanelIx.'");'.        // width = substr($class,-3).'px' panelW560
                'if (h.style.display === "none")
                    { h.style.display = "block";  $("table").trigger("applyWidgets");}
                    else { h.style.display = "none";}
            }'; //
    echo 'function PanelMinimize'.$ØPanelIx.'() {
                var h = document.getElementById("HideDiv'.$ØPanelIx.'");
                var p = document.getElementById("panel'.$ØPanelIx.'");
                h.style.display = "none";
            }'; // p.style.width = "100%"; }';  //h.style.width = "480px"; }';
    echo 'function PanelMaximize'.$ØPanelIx.'() {
                var h = document.getElementById("HideDiv'.$ØPanelIx.'");
                var p = document.getElementById("panel'.$ØPanelIx.'");
                h.style.display = "block";
            '.// p.style.width = "100%";
            '   $("table").trigger("applyWidgets");
            }'; //  $("table").trigger("applyWidgets"); Refresh the erlier hidden tablesorter objects.
    echo '</script>';
    dvl_pretty('htm_PanlHead');
    $GridOn= false;
    if ($capt=='') $Ph= 'height:0px;'; else $Ph= '';

    if ($frmName>'') { //  Without name form will not be created, so local forms can be used !
            $ØPanlForm= true;
            $formCrea=  "\n\n".'<form name="'.$frmName.'" id="'.$frmName.'" action="'.$parms.'" method="post">'."\n";
        }               //  "ParentForm" - Nestet forms is not allowed, so sub-forms has to specially handled!
    else {$ØPanlForm= false; $formCrea= ''; }

    if (DEBUG) {$fn= '&nbsp; <small><small><small>'.$where.'()</small></small></small>';}
    else        $fn= '';
    $source='https://www.ev-soft.dk/saldi-wiki/doku.php?id=';  $book= 'legeplads:';  $mark= '#';

    if (strpos('#',$BookMark.' ')>0) $BookMark= $book.$mark.$BookMark;
    else
    if (strpos('legeplads',$BookMark.' ')>0) {
        if ($BookMark=='blindAlley.page.php') {$source= $BookMark; $BookMark= '';};
        if ($BookMark=='') { $wikilnk= '';  $source=''; }
    };
    if (strpos($BookMark,'blindAlley.page.php')==0)  $wikilnk='';
    else  $wikilnk= '<a href="'.$source.$BookMark.'" target="_blank" title="'.
            lang('@Online Help, Find relevant information for this panel, in Program Wiki. ').
            lang('@(When Wiki for').' '.$ØProgTitl.' '.lang('@is created...) ').
            lang('@You can also help maintain help and guidance here as the WIKI is editable.').'"><img src= "'.$_assets.
            'images/wikilogo.png " alt="Wiki" style="width:20px;height:20px; margin-right:2px; float:right;" '.'> </a>';
    $togg= '<span style="color: black; font-size: 16px; display:inline-block; white-space: nowrap; width:12px; height:12px;
            margin-top:6px; margin-right:4px; float:right; font-size: smaller;"><ic class="fas fa-exchange-alt  fa-rotate-90"></ic></span>';

## PANEL-START:
    echo '<span class="'.$class.'" id="panel'.$ØPanelIx.'" '.$more.' style="margin: 0 10px 10px 0; position: relative; left: -6px; vertical-align: top; '.$panlBg.'"> '. $formCrea.
            '<span style="display:inline-block; width:100%; text-align:left;">'.
                '<abbr class= "hint">'.
                '<span class= "panelTitl" style="'.$Ph.' color:'.$ØTitleColr.'; cursor:row-resize; text-align: left; min-height:26px;"
                    onclick= PanelSwitch'.$ØPanelIx.'();> '.
                    '<ic class="'.$icon.'" style="font-size: 20px; color: '.$ØiconColor.';"></ic> &nbsp;'.ucfirst(lang($capt)).$fn. $togg;
    echo       '</span>'. // panelTitl
            '<data-hint>'.lang('@<b>TOGGLE:</b> Click icon or panel header-text to open / close this panel').' </data-hint></abbr>';  //  Panel-Header
    
    echo '<abbr class= "hint">
            <ic class="fas fa-angle-double-up" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:zoom-out; font-size: smaller;" '.
            ' onclick= PanelMinimizeAll(); ></ic>
            <data-hint>'. lang('@<b>COLLAPSE:</b> Click to close all panels').';" </data-hint></abbr>';
            
    echo '<abbr class= "hint">
            <ic class="fas fa-angle-double-down" style="width:12px; height:12px; margin-top:6px; margin-right:0px; float:right; cursor:zoom-in; font-size: smaller;" '.
            ' onclick= PanelMaximizeAll(); ></ic>
            <data-hint>'. lang('@<b>EXPAND:</b> Click to open all panels').';" </data-hint></abbr>';
    echo    '</span>';   // width:100%;

    if ($wikilnk > '') echo  $wikilnk;

    echo '<span id="HideDiv'.$ØPanelIx.'" style="background:'.$ØPanelBgrd.'; ">';   // Hide from here !
    if ($capt!='') echo '<hr class="style13" style="margin: 6px 6px 6px 0;"/>';
    echo '<div class="pnlContent" style="text-align: center; margin: auto; ">'; // width: min-content;">';
} // htm_PanlHead - # Panelets < /Panel-span>, < /hiding> og < /form> er placeret i htm_PanlFoot, som skal kaldes til slut!

function htm_PanlFoot( $labl='', $subm=false, $title='', $btnKind='save', $akey='', $simu=false, $frmName='')
{ # MUST follow after htm_PanlHead and panel content !
    global $ØPanlForm;    dvl_pretty('htm_PanlFoot ');
    if ($title=='') {$title= '@Remember to save here if you changed anything above, before leaving the window.'; $btnKind='save';}
    echo '</div>';    // class="pnlContent"
    if ($ØPanlForm)
        if ($subm==true) {
        echo '<hr class="style13" style= "height:4px;">'.
            '<span class="center" style="height:25px">';
        htm_AcceptButt($labl, $title, $btnKind, $frmName, $width='', $akey, $proc=true);
        echo '</span>';
        }
    echo '</span>';  // HideDiv to here !
    if ($ØPanlForm) echo "\n".'</form>'.'<!-- /'.$frmName.' -->'."\n\n"; //  PanelForm-end
    echo '</span>';  // Panel-end
}


// JS functions to handle Panels:
function PanelInit() { global $panelCount;
    echo '<script>';
        echo 'function PanelMinimizeAll() {';
        for ($Ix=1; $Ix<=$panelCount; $Ix++) { echo '
                var h = document.getElementById("HideDiv'.$Ix.'");
                var p = document.getElementById("panel'.$Ix.'");
                h.style.display = "none";
                ';
            }
        echo ' }';
        echo 'function PanelMaximizeAll() {';
        for ($Ix=1; $Ix<=$panelCount; $Ix++) { echo '
                var h = document.getElementById("HideDiv'.$Ix.'");
                var p = document.getElementById("panel'.$Ix.'");
                h.style.display = "block"; ';
            }
        echo ' $("table").trigger("applyWidgets"); }';  # Reinit table "zebra": https://mottie.github.io/tablesorter/docs/example-widget-zebra.html
    echo '</script>';
}

function PanelMin($no) {    // run_Script('PanelMinimize'.$no.'();');
    echo '<script> PanelMinimize'.$no.'(); </script>';
}
function PanelMinimer($Last) {
    echo '<script> ';
        for ($no=0; $no<=$Last; $no++) echo 'PanelMinimize'.$no.'(); ';
    echo '</script>';
}
function PanelInitier($First,$Last) { //  Minimize an interval
    echo '<script> ';
        for ($no=$First; $no<=$Last; $no++) echo 'PanelMinimize'.$no.'(); ';
    echo '</script>';
}
function PanelMax($no) {
    echo '<script> PanelMaximize'.$no.'(); </script>';
}
# Fremtidig benyttelse:
function PanelOff($First,$Last) {   //  Minimize an interval
    PanelInitier($First,$Last);
}
function PanelOn($noFrom,$noTo=0) { //  Maximize a single or a interval
    if ($noTo<$noFrom) $noTo= $noFrom;
    for ($no=$noFrom; $no<=$noTo; $no++) PanelMax($no);
}


/*
Terms used in the RowCOLUMNS:
 -------------------------------------------------------------------------------------------------------
|                                                                                                      |
|                                                WINDOW                                                |
|                                                                                                      |
|   |---------------------------|---------------------------|---------------------------|              |
|   |         ColumnTop         |         NextColumn        |         NextColumn        |              |
|   |                           |                           |                           |              |
|   |                           |                           |                           |              |
|   |             C             |             C             |             C             |              |
|   |             O             |             O             |             O             |              |
|   |             L             |             L             |             L             |              |
|   |             U             |             U             |             U             |              |
|   |             M             |             M             |             M             |              |
|   |             N             |             N             |             N             |              |
|   |                           |                           |                           |              |
|   |             1             |             2             |             3             |              |
|   |                           |                           |                           |              |
|   |                           |                           |                           |              |
|   |                           |                           |       ColumnBottom        |              |
|   |---------------------------|---------------------------|---------------------------|              |
|                                                                                                      |
|   |---------------------------|---------------------------|---------------------------|              |
|   |         ColumnTop         |         NextColumn        |         NextColumn        |              |
|   |                           |                           |                           |              |
|   |                           |                           |                           |              |
|   |             C             |             C             |             C             |              |
|   |             O             |             O             |             O             |              |
|   |             L             |             L             |             L             |              |
|   |             U             |             U             |             U             |              |
|   |             M             |             M             |             M             |              |
|   |             N             |             N             |             N             |              |
|   |                           |                           |                           |              |
|   |             1             |             2             |             3             |              |
|   |                           |                           |                           |              |
|   |                           |                           |                           |              |
|   |                           |                           |                           |              |
|   |---------------------------|---------------------------|---------------------------|              |
|                                                                                                      |
|   |---------------------------|                                                                      |
|   |        NextColumn         |                                                                      |
|   |                           |                                                                      |
|   |                           |                                                                      |
|   |             C             |                                                                      |
|   |             O             |                                                                      |
|   |             L             |                                                                      |
|   |             U             |                                                                      |
|   |             M             |                                                                      |
|   |             N             |                                                                      |
|   |                           |                                                                      |
|   |             4             |                                                                      |
|   |                           |                                                                      |
|   |                           |                                                                      |
|   |       ColumnBottom        |                                                                      |
|   |---------------------------|--                                                                    |
|                                                                                                      |
|------------------------------------------------------------------------------------------------------|
*/

### COLUMNS:    // Columns, layout in windows. Is used in xxx.page.php-files:
function RowColTest($colr) {
    if (DEBUG) return ' style="border: 3px solid '.$colr.';"'; else return '';
}
function htm_RowColTop ($RowColWdth=240) {  dvl_pretty('htm_RowColTop');      // RowColTop RowCol240, RowCol320 (Look at CSS ! )
    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">'.
         '<data-ColnHead'.RowColTest('yellow').'> <span id="colnwrap" '.RowColTest('green').'> '.
         '<data-RowCol id="RowCol'.$RowColWdth.'" '.RowColTest('blue').' >';
}
function htm_RowColNext($RowColWdth=320) {
    echo '</data-RowCol> <data-RowCol id="RowCol'.$RowColWdth.'" '.RowColTest('red').'>'; 
}
function htm_RowColBott() {
    echo '</data-RowCol> </span></data-ColnHead><span class="clearWrap" >'.
         '</div>';
}
## Importent: $RowColWdth - Only use defined width ! (See CSS: @media screen)



function htm_AcceptButt( # $labl='', $title='', $btnKind='', $form='', $width='', $akey='', $proc=false, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more, $faicon);
    $labl='',               # The caption on the button
    $title='',              # Hint about the button function
    $btnKind='',            # save, navi, goon, erase, create, home (Appearance)
    $form='',               # A form Will be created, if a name is given
    $width='',              # The width of the button
    $akey='',               # Shortcut to activate the button
    $proc=false,            # Act as procedure: Echo result, or as function: Return string
    $tipplc='LblTip_text',  # Class for Placement of the tooltip
    $tipstyl='',            # Style for Placement of the tooltip
    $clicking='',           # Function to run
    $more='',               # Generel use e.g. ' action= "$link" '
    $faicon=''              # The iconclass ('<i class="fas fa-plus"> </i> ';)
    )
{   global $ØShortKeys;
    dvl_pretty('htm_htm_AcceptButt');
    // Colors:
    $ØButtnBgrd= '#44BB44';  /* LysGrøn   */     $ØButtnText= '#FFFFFF';   /* Hvid   */
    $ØBtLnkBgrd= 'yellow';   /* '#FCFCCC';  */   $ØBtLnkText= '#000000';
    $ØTextLight= 'white';       $ØTextDark= 'black';
    $ØBtDelBgrd= 'Crimson ';    $ØBtDelText= $ØTextLight;   # Slet:RØD
    $ØBtSavBgrd= '#0064b4';     $ØBtSavText= $ØTextLight;   # Gem/Submit:BLUE
    $ØBtNavBgrd= '#269B26';     $ØBtNavText= $ØTextLight;   # Naviger:GRØN
    $ØBtGooBgrd= '#66CDAA';     $ØBtGooText= $ØTextDark;    # Fortsæt:MARINE
    $ØBtNewBgrd= 'Orange';      $ØBtNewText= $ØTextDark;    # OpretNy:ORANGE
    $Ødimmed=    ' opacity:0.8;';
    // Initiate:
    if ($form) {$name= $form; $form=' form="'.$form.'" ';} else {$name= '_none'; }
    if ($width) $width= ' width: '.$width.';';
    if ($faicon==='') $iconClass=''; else $iconClass= '<i class="'.$faicon.'" </i>&nbsp;';
    $Label= /* $iconClass. */ ucfirst(lang($labl));   // Strange behavior with icon !?  FIXIT

## Shortcuts:
    $keytip='';
    if ($ØShortKeys) {
        if ($akey>'') $short=' ´<i>'.$akey.'</i>´'; else $short='';
        if (!$short) $keytip=''; else $keytip= '<br><em>'.lang('@Keyboard shortcut: ').$akey.'</em>';
    }
## Appearance & name:
    switch ($btnKind) {
    case 'save'   : {$colors= ' background:'.$ØBtSavBgrd.'; color:'.$ØBtSavText.';'.$Ødimmed;}  $midn= 'sav_';  break; # Submit-Butt: BLUE
    case 'navi'   : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= 'nav_';  break; # navigate-Butt: GREEN
    case 'goon'   : {$colors= ' background:'.$ØBtGooBgrd.'; color:'.$ØBtGooText.';'.$Ødimmed;}  $midn= 'goo_';  break; # Continue-Butt-Butt: SEA ​​GREEN
    case 'eras'   : {$colors= ' background:'.$ØBtDelBgrd.'; color:'.$ØTextLight.';'.$Ødimmed;}  $midn= 'era_';  break; # Delete: RED
    case 'crea'   : {$colors= ' background:'.$ØBtNewBgrd.'; color:'.$ØBtNewText.';'.$Ødimmed;}  $midn= 'cre_';  break; # Create new: ORANGE
    case 'home'   : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= 'hom_';  break; # navigate-Butt: GREEN
    # Special:
    case 'get_'   : {$colors= ' background:'.'BurlyWood'.'; color:'.$ØTextDark .';'.$Ødimmed;}  $midn= 'get_';  break; # Import
    case 'put_'   : {$colors= ' background:'.'CadetBlue'.'; color:'.$ØTextDark .';'.$Ødimmed;}  $midn= 'put_';  break; # Export
    case 'spc1'   : {$colors= ' background:'.'Chocolate'.'; color:'.$ØTextLight.';'.$Ødimmed;}  $midn= 'spc1';  break; #
    case 'spc2'   : {$colors= ' background:'.'White'.    '; color:'.$ØTextDark .';'.$Ødimmed;}  $midn= 'spc2';  break; #

    default       : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= $labl;          # navigate-Butt: GREEN
  }
## Action:
    if ($clicking=='') {$type='submit';} else {$type='button';}
## Function:
    $result=  '<span class="center" style="height:25px;">';
    $result.= '<abbr class="hint">';
    $result.= '  <button class="acceptbutt" '.$form.' type= "'.$type.'" name="btn_'.$midn.$name.'" id="btn_'.$midn.$name.'" '.$more.
              '    style="min-height: 24px; '.$width. $colors.'" onclick=\''.$clicking.'\' accesskey="'.$akey.'"> '.$Label.
              '  </button>';
    $result.= '  <data-hint style="'.$tipstyl.'">'.lang($title).$keytip.'</data-hint> ';
    $result.= '</abbr> ';
    $result.= '</span>';
    if ($proc==true) echo $result; else return $result;
} # :htm_AcceptButt()

function htm_IconButt($type='submit',$faicon='',$labl='',$title='',$id='',$link='',$action='',$akey='',$size='32px',$fg='gray',$bg='white')
{   global $ØButtnBgrd, $ØShortKeys, $btnix;
    dvl_pretty('htm_IconButt');
    if ($ØShortKeys) {
        //($akey>'') ? $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; : $keytip=''; ;
        if ($akey) $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; else $keytip='';
        if ($link=='') $targ= 'formtarget="_self"';
    }
    $btnix++;
    $result = '
    <span class="tooltip" style="display:inline; padding:0; ">
        <button type= "'.$type.'" '.$targ.' id='.$id.' name="btn_ico_'.$btnix.'" style="color:'.$fg.'; background:'.$bg.';" accesskey="'.$akey.'" action="'.$action.'">'.
        '<span class="LblTip_text">'.$title.$keytip.'</span>'.
        ' <data-ic class="'.$faicon.'" style="font-size:'.$size.'; color:'.$fg.';  '.$ØButtnBgrd.'; "> </data-ic> '
        .lang($labl).
        '</button>'.
    '</span>';
    if ($size=='32px') echo $result;
    return $result;
}

function htm_LinkButt($labl, $gotoLink, $hint='', $target='_blank') {
    echo '<a class="button" href="'.$gotoLink.'"  target="'.$target.'" title="'.lang($hint).'">'.lang($labl).'</a>';
}

function str_WithHint($labl='',$hint='',$icon='') {
    if ($icon>'') $icon= '<i class="'.$icon.'" </i>&nbsp;'; else $icon= '';
    return '<abbr class= "hint">'.$icon.lang($labl).'<data-hint>'.lang($hint).'</data-hint></abbr>';
}

// echo $htm_ModalDialog; Initiated in htm_PagePrep
function htm_ModalDialog($Btype='none',$capt='@Voilà!',$mess='',$butt=['$type','$icon','$labl','$hint','$link'],$html='CSS-based Modal Dialog') { 
global $cssButt;    // JS-free Modal dialog based on CSS only.
    $css_Box= [ // Predefined boxes:
    //['boxType'=>[0:'bordFg', 1:'headBg',    2:'label', 3:'icon'],
        'none' => ['black',    'whitesmoke;', '@Default' ,'<i class="far fa-thumbs-up"></i>'],
        'info' => ['darkgrey', '#f1f1f1;',    '@Info'    ,'<i class="fas fa-info"></i>'],
        'mess' => ['darkgrey', '#f1f1f1;',    '@Info'    ,'<i class="fas fa-info"></i>'],
        'hint' => ['blue',     'lightcyan;',  '@Hint'    ,'<i class="far fa-flag"></i>'],
        'succ' => ['green',    '#DFF2BF;',    '@Succes'  ,'<i class="fas fa-check"></i>'],
        'acce' => ['green',    '#DFF2BF;',    '@Accept'  ,'<i class="fas fa-question"></i>'],
        'warn' => ['orange',   '#FEEFB3;',    '@Warning' ,'<i class="fas fa-exclamation-triangle"></i>'],
        'erro' => ['red',      '#FFD2D2;',    '@Error'   ,'<i class="fas fa-exclamation"></i>']
    ];
    // if ($mess=='') $mess='A CSS-only modal based on the :target pseudo-class. Hope you find it helpful.<br>';
        $cssButt= [ // Predefined buttons:
        //  0:type  1/0:icon                       2/1:Label   3/2:Hint               4/3:Link
            'info' => ['fas fa-info',                 '@Info',     '@To inform you',       '#'],
            'mess' => ['fas fa-info',                 '@Message',  '@To inform you',       '#'],
            'hint' => ['fas fa-flag',                 '@Hint',     '@To inform you',       '#'],
            'succ' => ['fas fa-check',                '@Succes',   '@To inform you',       '#'],
            'acce' => ['fas fa-question',             '@Confirm',  '@Your choice',         '#'],
            'warn' => ['fas fa-exclamation-triangle', '@Warning',  '@Message to warn you', '#'],
            'erro' => ['fas fa-exclamation',          '@Error',    '@Critical message !',  '#'],
            'clos' => ['fas fa-close',                '@Close',    '@Close the window',    '#']
        ];    // Also used if calling parameter == ''
    if ($butt==['$type','$icon','$labl','$hint','$link']) $butt=['clos']; // Just the close button
    
    $arrButtons= [];    // Create assoative array:
    foreach ($butt as $bt) $arrButtons[]= [$bt[0] => [$bt[1],$bt[2],$bt[3],$bt[4]]];
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
    $result = '<div> <a href="#open-modal_'.++$GLOBALS['Mcount'].'">'.$html.'</a> </div>
        <div id="open-modal_'. $GLOBALS['Mcount'].'" class="modal-window" >
            <div style="border: 4px solid '.$css_Box[$Btype][0].';">';
                if (in_array_r('clos',$butt))
                    $result.= '<a href="#" title="Close" class="modal-close"><i class="fas fa-times"></i>&nbsp;Close</a>';
                $result.=  '
                <b><h3  id="header" style="background-color: '.$css_Box[$Btype][1].';">'.lang($capt).'</h3></b>
                <div id="message">'.
                    lang($mess). /* ' A CSS-only modal, based on the :target pseudo-class. Hope you find it helpful.<br>  */ '
                </div>
                <div id="footer">';
                foreach ($arrButtons as $bton) // Show none or more button types:
                foreach ($bton as $bt) {
                    $key= strtolower(key($bton));
                    switch ($key) {
                        case 'clos' : break;    // Window close button
                        case 'info' : case 'mess' : case 'hint' : case 'succ' : case 'acce' : case 'warn' : 
                        case 'erro' : $result.=  '<a   href="'.notEmpty($key,$bt[3],3).
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
        return $result;
        //echo $result;   
} // htm_ModalDialog


function htm_Dialog($capt='CAPTION', $content='', $bgColor='lightyellow', $buttons= // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog
                    [['confirmBtn','default','@Confirm','fas fa-check','green','@Accept and go on'],   // (0:id, 1:value, 2:label, 3:icon, 4:title)
                     ['',          'cancel', '@Cancel', 'fas fa-minus-circle','red','@Break and return']])
{   $result= '<dialog id="htmDialog" style="padding:5px; background-color:lightcyan; border-radius: 6px;">
        <form method="dialog">
            <div style="background-color:'.$bgColor.'; padding:4px;">'.$capt.'</div>
            <p>'.$content.'</p>'.   //  <p><label>Favorite animal: <select> <option></option> <option>Brine shrimp</option> <option>Red panda</option> <option>Spider monkey</option> </select> </label></p>
            '<menu>';
                foreach ($buttons as $butt) {
                $iconClass= $butt[3];
                // if ($iconClass === '') $icon=''; else 
                $icon= '<ic class="'.$butt[3].'" style="font-size: 16px; color: '.$butt[4].';"></ic>&nbsp;';
                $result.= '<button id="'.$butt[0].'" value="'.$butt[1].'" title="'.lang($butt[5]).'" style="padding: 3px 5px;">'.$icon.lang($butt[2]).'</button>&nbsp;';
                }
    $result.= '</menu>
        </form>
        </dialog>
        <menu> <button id="startDialog">Test Modal Dialog</button> </menu>
        <output aria-live="polite"></output>';  // "Modal"
    echo $result;
   
    run_Script("
        var htmDialog = document.getElementById('htmDialog');
        var updateButton = document.getElementById('startDialog');
        updateButton.addEventListener('click', function onOpen() {". // updateButton opens the <dialog> modally
        "   if (typeof htmDialog.showModal === \"function\") { htmDialog.showModal(); } 
            else { alert(\"The <showModalDialog> API is not supported by this browser\"); }
        });
        var confirmBtn = document.getElementById('confirmBtn');
        var selectEl = document.querySelector('select');
        selectEl.addEventListener('change', function onSelect(e) {". // "Favorite animal" input sets the value of the submit button
        "   confirmBtn.value = selectEl.value;
        });
        var DialogBox = document.querySelector('output');
        htmDialog.addEventListener('close', function onClose() {".    // "Confirm" button of form triggers "close" on dialog because of [method="dialog"]
        "   DialogBox.value = htmDialog.returnValue + \" button clicked - \" + (new Date()).toString();
        });
    ");
   return $result;
}



//  msg_Dialog('warn','Fortsæt','$(this).dialog("close")',$Butt2_title='','','','','User Dialog',$messg='');
// function msg_Dialog (   // Problemer med forskellige jquery-versioner, saboterer denne function!!!
//     $BgColr= 'error',   //  msg_System() er mere stabil, men vinduet kan ikke flyttes/ændre størrelse.
//     $Butt1_title= '@Accept', $Butt1_function='$(this).dialog("close")',
//     $Butt2_title= '@Cancel', $Butt2_function='$(this).dialog("close")',
//     $Butt3_title= '',         $Butt3_function='$(this).dialog("close")',       
//     $title='User Dialog',     $messg='') 

function msg_Dialog($type='error', $caption='@User Dialog', $mess='', $Buttons= [
                        // 0: strLabel  (Cancel/Accept/Close)  1: strHint 2: jsFunction() 3: imgIcon 4: Result
                        ['@Confirm', '@Hint', '$(this).dialog("close")', 'Icon', true ],
                        ['@Close',   '@Hint', '$(this).dialog("close")', 'Icon', false]
                    ])

{ //  DOKUMENTATION: http://api.jqueryui.com/dialog/
# Depends of:
# echo '  <link rel="stylesheet" href= "../.../jquery-ui.css" topic="jquery Dialog">';
# echo '    <script src="../.../jquery.js"></script>    <!--  topic=jquery Dialog -->'; 
# echo '    <script src="../.../jquery-ui.js"></script> <!--  topic=jquery Dialog -->';

# INIT: (Change as needed)
  $result= false;
  if ($mess=='') $mess='<p>This is a CSS based modal dialog, which can be used to display information. '.
      'The window can be moved and stretched, as well as closed with the \'x\' icon. <br>'.
      '<br>The buttons below can be programmed, with optional code.</p>';
  
# CODE: (don't change!)
switch (strtolower($type)) {  # BG-olors and Hint-prefix:
    case "error"  : $headColr= '#FF8888'; $pref= ucfirst(lang('@Error: ')); break;   # color: red
    case "info"   : $headColr= '#BDE5F8'; $pref= ucfirst(lang('@Info: '));  break;   # color: blue
    case "warn"   : $headColr= '#FEEFB3'; $pref= ucfirst(lang('@Warn: '));  break;   # color: orange
    case "tip"    : $headColr= '#88ff22'; $pref= ucfirst(lang('@Hint: '));  break;   # color: green
    case "success": $headColr= '#DFF2BF'; $pref= ucfirst(lang('@Bingo: ')); break;   # color: light-green
    default       : $headColr= $type;     $pref= ''; # Custom color for non-standard types
} 
# Spec.Style:
  echo '<style type="text/css">'.
       '  .ui-dialog .ui-dialog-titlebar    { background: '.$headColr.'}'.
       '  .ui-dialog .ui-dialog-buttonpane  { background: '.$headColr.'}';
# If more than 2 buttons: Increase the width from standard 300px to 360px:
  echo '  .ui-dialog  { width: 320px; margin: auto; position: fixed; top: 20%;  left: 0px; right: 0px; -moz-box-shadow: 0px 0px 8px #000000; -webkit-box-shadow: 0px 0px 8px #000000; box-shadow: 0px 0px 8px #000000;}'.
       '   ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close  {width: 20px; title: "'.lang('@Close').'";}'.
       '  .ui-button  {padding: 2px 8px};}';
/*  
  <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
    <div class="ui-dialog-buttonset">
      <button type="button" class="ui-button ui-corner-all ui-widget">Godkend</button>
      <button type="button" class="ui-button ui-corner-all ui-widget">Fortryd</button>
      <button type="button" class="ui-button ui-corner-all ui-widget">3. knap</button>
  </div></div>
 */ 
  echo '</style>';
# Func-script:
//  echo ' $("#foo").dialog({   width: "'.$WinW.'",    height: "'.$WinH.'",';
//  echo '    buttons: { '.$Butt1_title.': function(){ '.$Butt1_function.'; }, '.$Butt2_title.': function(){ '.$Butt2_function.'; } }';
//  echo '});';

  echo '  <script>';    //   $( function() {  $( "#dialog-message" ).dialog ({ modal: true, buttons: {"OK": function(){ $(this).dialog("close"); } } }); }); 
//  echo '  $( function() {  $( "#dialog-message" ).dialog ({';
    echo '  $( document ).ready( function() {  $( "#dialog-message" ).dialog ({';
    echo '  position: "fixed", top: "320px",';  //position: "right top",';  // Her er problemer med placering af dialog-vinduet, når Window er meget højt!
    echo '  modal: true,';
    echo '  buttons: {';    // Space is not allowed in titel!
    foreach ($Buttons as $butt) 
        echo ' "'. str_replace(' ','_',lang($butt[0])).'": function() {'.$butt[2].';},';
    //    "Delete all items": function() { $( this ).dialog( "close" ); },
    //     Cancel           : function() { $( this ).dialog( "close" ); }
     
 // if ($Butt1_title) echo  '"'.  str_replace(' ','...',lang($Butt1_title)).'": function(){ '.$Butt1_function.'; }';  # Primær knap!
 // if ($Butt2_title) echo ',"'.  str_replace(' ','_',  lang($Butt2_title)).'": function(){ '.$Butt2_function.'; }';  # Kun som 2. knap
 // if ($Butt3_title) echo ',"'.  str_replace(' ','_',  lang($Butt3_title)).'": function(){ '.$Butt3_function.'; }';  # Kun som 2. ell. 3. knap
    echo '  }';
  echo '      }); });';
# echo '  $( ".selector" ).dialog({  position: { my: "left top", at: "center", of: window }});';
# echo '  $("#dialog-modal").dialog({ height: 330, modal: true, position: {my: "center", at: "center", of: "window"} });';
# echo '  $("#dialog").dialog({position: "top"});';
# echo '  dialog("option","position","center").dialog("widget").css("top","125px"); '; 
  echo '  </script>';
  echo '<div id="dialog-message" title="'.$pref.lang($caption).'"> '.lang($mess).' </div>';  #  style=" position: fixed; top: 320px; "
  return $result;
}


//  $goon= lang('$Fortsæt');   $close= lang('@Luk');
## Almindelige af-arter med kun 1 fortsæt-knap, samt "luk":
function msg_Error($title='Fejl',     $messg='Besked') {
//  msg_Dialog('error',   lang('@Fortsæt'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  msg_System($MsgType= 'error', $title,  $reason='', $messg, $actions=['','goon','close']);
}
function msg_Info($title='Info',      $messg='Besked') {
  msg_Dialog('info',    lang('@Fortsæt'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
}
function msg_Warn($title='Advarsel',  $messg='Besked') {    //  msg_Dialog('warn',    lang('@Fortsæt'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  $str= '<br>'.  lang($messg);
  msg_System($MsgType= 'warn', $title,  $reason=' ', $messg=$str, $actions=['','goback','close']);
}
function msg_Hint($title='Tip',        $messg='Besked') {   //  msg_Dialog('tip',     lang('@Fortsæt'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  msg_System($MsgType= 'tip', $title,  $reason=$title, $messg, $actions=['','','close']);
}
function msg_Succ($title='Hurra',     $messg='Besked') {      //  msg_Dialog('success', lang('@Fortsæt'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  msg_System($MsgType= 'success', $title='',  $reason='', $messg, $actions=['','','close']);
}
// Afhængig af: msg_lib.css.php   -   Afløser for msg_Dialog()
function msg_System($MsgType= 'error', $title='',  $reason='', $messg='', $actions=['goback','goon','close'], $wdh='600px', $hgt='150px') {
## INIT: (Change as needed)
    $result= false; # Return værdi kan ændres med programmering.
    $title=  ucfirst(lang($title));
    $reason= ucfirst(lang($reason));
    $messg=  ucfirst(lang($messg));
    if ($title=='')   $title= 'PHP2HTML - ';
    if ($reason=='')  $reason='<p>Info about the system.</p>';
    if ($messg=='')   $messg='<p>This is a CSS based modal dialog independent of jquery that can be used to display information. '.'<br>'.
        'The window can be closed with the \'x\' icon, or by clicking anywhere outside the window. <br>'.
        '<br>The buttons in the footer can be programmed, with optional code.</p>';
## CODE: (don't change!)
  switch (strtolower($MsgType)) {  # TEMA-farver og Titel-prefix:
      case "error"  : $headColr= '#FF8888';    # color: red
                      $pref= ucfirst(lang('@Fejl: '));     
                      $Capt1= '<div style="font-weight:600;">'.lang('@Sporing').':</div>';
                      $Capt2= '<div style="font-weight:600;">'.lang('@Forklaring').':</div>'; 
                      break;
      case "info"   : $headColr= '#BDE5F8';    # color: blue
                      $pref= ucfirst(lang('@Info: '));                  
                      break;
      case "warn"   : $headColr= '#FEEFB3';    # color: orange
                      $pref= ' '.ucfirst(lang('@Advarsel: '));
                      $Capt1= '<div style="font-weight:600;">'.lang('@Hov').':</div>'; 
                      break;
      case "tip"    : $headColr= '#88ff22';    # color: green
                      $pref= ucfirst(lang('@Tip: '));   
                      $title='';                      
                      break;
      case "success": $headColr= '#DFF2BF';    # color: light-green
                      $pref= ucfirst(lang('@Hurra: '));                 
                      break;
      default:  $headColr= $MsgType; $pref= ''; //  Custom color og uden prefix
  } 
  echo '<label class="button demo-button" for="open-modal"> </label>';  // The way to toggle the modal is to check the hidden checkbox with the ID #open-modal "Open The Modal"
  echo '<div class="modal__container">';
  echo '  <input type="checkbox" id="open-modal" class="modal__toggler" checked />';  //echo '  <!-- Here is the hidden checkbox element which makes toggling the modal work -->
  echo '  <label class="modal__mask" for="open-modal"></label>';               //echo '  <!-- Here is the background mask. When clicked, it closes the modal. Change this to a div to disable that functionality. -->
  echo '  <div class="modal" style="width: '.$wdh.';  ">';  //  height: '.$hgt.';
  echo '    <label class="modal__close" for="open-modal"></label>';
  echo '    <div class="modal__header" style="background-color: '.$headColr.';">';
  echo '      <h3 style="margin:8px;">'.$title.$pref.'</h3>';
  echo '    </div>';
  echo '    <section class="modlwrap">';
  if ($reason>' ')  echo '<div class="modal__content" style="width:33%; background:lightcyan;  ">'.$Capt1.'<samp><small>'.$reason.'</small></samp>'.'<br><br></div>';
  echo '      <div class="modal__content" style="width:67%; background:lightyellow;">'.$Capt2.'<var>'.$messg.'</var>'.'<br><br></div>';
  echo '    </section> ';
  echo '    <div class="modal__footer" style="background-color: '.$headColr.';">';
  if (in_array('goback',$actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Luk vinduet og vend tilbage til forrige visning').'">'.lang('@Fortryd').' </label>';
  if (in_array('goon',  $actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Luk besked-vinduet og fortsæt').'">'.lang('@Fortsæt').' </label>';
  if (in_array('accept',$actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Bekræft og fortsæt').'">'.lang('@Godkend').' </label>';
  if (in_array('close', $actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Luk vinduet!').'">'.lang('@Luk')    .' </label>';
//  echo '      <script> ';
//  echo '        function goBack() { window.history.back() } ';
//  echo '        function winclose() { open(location, "_self").close() } ';
//  echo '      </script>';
//  echo '      <button type="button" style="border-radius: 5px; height:20px;" onclick="goBack()">Fortryd</button> ';
//  echo '      <button type="button" style="border-radius: 5px; height:20px;" disabled> Godkend </button> ';
//  echo '      <button type="button" style="border-radius: 5px; height:20px;" onclick="winclose()"> OK </button> ';
  echo '    </div>';
  echo '  </div>';
  echo '</div>';
  return $result;
}

function htm_PagePrep($pageTitl='', $ØPageImage='',$align='center',$PgInfo='',$PgHint='',$headScript='') { # Prepare / initialize a page
    global $ØProgRoot, $CSS_system, $ØTitleColr, $panelCount;                                              # Must be followed of htm_PageFina() to finalise the page

    echo '<!DOCTYPE html>';
    echo '<html lang="da" dir="ltr">';
    echo "\n<head>\n";
    echo '  <meta charset="UTF-8">';
    echo '  <meta name="viewport" content="width=device-width, initial-scale=1.0">';    // dvl_echo('htm_PagePrep');
    echo '  <meta name="robots" content="Noindex, Nofollow">';                          // Reject robots
    echo '  <title>'.$pageTitl.'</title>'. "\n";                                        dvl_pretty('htm_PagePrep');

### ----------------------Library-dialog-polyfill-------------------------
 //   $path= $ØProgRoot.'_assets/dialog-polyfill/';                                       // To get Firefox and other browsers to support <dialog>
 //   echo '<script src="'.$path.'dialog-polyfill.js"></script>';
 //   echo '<link rel="stylesheet" href="'.$path.'dialog-polyfill.css"/>';
 //   run_Script("var dialog = document.querySelector('dialog');
 //               dialogPolyfill.registerDialog(dialog);        // Now dialog always acts like a native <dialog>.
 //               dialog.showModal(); ");
    
   // run_Script("function phpDialog(capt='CAPTION', content='Content') 
   //     { var result= <?= htm_Dialog(capt, content); ? > return result; }");
//        { alert(\"<?php echo htm_Dialog(capt, content); ? >\"); }");

### ----------------------Library-jQuery-------------------------
### jQuery-latest:
    echo '<script src="'.$ØProgRoot.'_assets/jquery/3/jquery-3.3.1.js"></script>';      //  latest // topic="Tablesorter-system" and Topmenu-system
    
    echo '  <link rel="stylesheet" href= "'.$ØProgRoot.'_assets/jquery-ui/1.12.1/jquery-ui.css"/>';//  topic="jquery Dialog"> 
    echo '    <script src="'.$ØProgRoot.'_assets/jquery-ui/1.12.1/external/jquery/jquery.js"></script>';  // <!-- jquery Dialog -->
    echo '    <script src="'.$ØProgRoot.'_assets/jquery-ui/1.12.1/jquery-ui.js"></script>             ';  // <!-- jquery Dialog -->
    
### ----------------------Library-Tablesorter-------------------------
//$path= './../_assets/tablesorter/';
    $path= $ØProgRoot.'_assets/tablesorter/';
// Tablesorter script: required
    echo '<script src="'.$path.'js/jquery.tablesorter.js"></script>';                   //  topic="Tablesorter-system"
//  echo '<script src="'.$path.'js/widgets/widget-filter.js"></script>';                //  topic="Tablesorter-system"
//    echo '<script src="'.$path.'js/widgets/widget-stickyHeaders.js"></script>';       //  topic="Tablesorter-system"
    echo '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.js"></script>';

    echo '<script src="'.$path.'js/parsers/parser-input-select.js"></script>';          //  topic="Tablesorter-extra"
    echo '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>';
    echo '<link rel="stylesheet" href="'.$path.'css/theme.blue.css"/>';                 //  topic="Tablesorter-system" (choose a theme file)
//    echo "
    $jsScripts = "
<script>
  $(function () {
    /* $('#table0, #table1, #table2, #table3, #table4, #table5, #table6').tablesorter({ */
    $('#table').tablesorter({
      theme: 'blue',
      dateFormat : \"Y-m-d\",
      widthFixed : true,
   // showProcessing : true,
      widgets: ['zebra', 'stickyHeaders', 'filter', 'editable', 'resizable'],
      widgetOptions: {
        stickyHeaders: '',                  // extra class name added to the sticky header row
        stickyHeaders_offset: 0,            // number or jquery selector targeting the position:fixed element
        stickyHeaders_cloneId: '-sticky',   // added to table ID, if it exists
        stickyHeaders_addResizeEvent: true, // trigger \"resize\" event on headers
        stickyHeaders_includeCaption: true, // if false and a caption exist, it won't be included in the sticky header
        stickyHeaders_zIndex: 2,            // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
        stickyHeaders_attachTo: '.wrapper', // jQuery selector or object to attach sticky header to
        stickyHeaders_xScroll: null,        // jQuery selector or object to monitor horizontal scroll position (defaults: xScroll > attachTo > window)
        stickyHeaders_yScroll: null,        // jQuery selector or object to monitor vertical scroll position (defaults: yScroll > attachTo > window)
        stickyHeaders_filteredToTop: true,  // scroll table top into view after filtering
     // editable_enterToAccept : true,
     // editable_validate : function(txt, orig, columnIndex, $element) {
     //         // only allow one word
     //         var t = /\s/.test(txt) ? txt.split(/\s/)[0] : txt;
     //         return t || false;
     //     },
     // filter_columnFilters : false,
        filter_hideFilters : true,
        filter_cellFilter : 'tablesorter-filter-cell',
        filter_reset : '.reset',
        filter_functions: {
          0: {
            '{empty}' : ".'function (e, n, f, i, $r, c) {'."
              return $.trim(e) === '';
            }
          },
        storage_storageType: 's', // use first letter (s)ession
        resizable_addLastColumn : true,
        },
        filter_selectSource: {
          0: function (table, column, onlyAvail) {  // get an array of all table cell contents for a table column
            var array = $.tablesorter.filter.getOptions(table, column, onlyAvail);
            array.push('{empty}');          //  manipulate the array as desired, then return it
            return array;
          }
        } //,
          // filter_cellFilter: {[]}
          // filter_cellFilter : \"tablesorter-filter-cell\"
      }
    });

//  // make second table scroll within its wrapper  - FIXIT
//  $('#table0, #table1, #table2, #table3, #table4, #table5, #table6').tablesorter({
//    widthFixed : true,
//    headerTemplate : '{content} {icon}',  /* Add icon for various themes */
//    widgets: [ 'zebra', 'stickyHeaders', 'filter', 'editable' ],
//    widgetOptions: {
//          // jQuery selector or object to attach sticky header to
//          stickyHeaders_attachTo : '.wrapper' // or $('.wrapper')
//      }
//  });
  });


  /*  assign the sortStart event */
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
        $('#table0, /* #table1, */ #table2, #table3, #table4, #table5, #table6, .nested').each(function() {
          if (this.config) {
            this.config.widgetOptions.stickyHeaders_includeCaption = includeCaption;
            this.config.widgetOptions.".'$sticky'.".children('caption').toggle(includeCaption);
          }
        });
      });

      /*  removed jQuery UI theme because of the accordion! */
      $('link.theme').each(function() { this.disabled = true; });
    });

".'
//    function deleteRow(table) {
//        var Sthis = $(this);
//        var Stable= $(table);
//        // console.log($(this).closest("tr"));
//        $(this).closest("tr").remove();
//        Stable.trigger("update");
//        return false;
//    };

    function appendRow(tableID, row_html) {    // Add row(s) - to the table bottom
        $(tableID).find("tbody").append(row_html).trigger("update");
        $(".clsFocus:last").focus();
    };
    
    $(".plusbtn").click(function() {
        alert("The clone botton was clicked.");
        var $table= $(this).closest("table");
        var clone = $("$table .row:first").clone().appendTo("$table");
        // INFO: Indsætter som sidste række, en kopi af 1. række
        // Bedre: Indsætter herunder en kopi, af aktuel række
        // window.alert("Indsætter som sidste række, en kopi af 1. række");
        if (confirm("'.lang('@Indsæt kopi som sidste række, af kopi af 1. række ?').'") == true) {
            $(".txtbox", clone);
        }
	});
  
    function removeRow() {'.
//      if (confirm("'.lang('@Are You Sure to Remove This Row?').'") == true) {
//      if ('.msg_Dialog('warn','@Yes','$(this).dialog("close")',$Butt2_title='@No','','','','User Dialog',$messg='@Are You Sure to Remove This Row?').' == true) {
//msg_Dialog($type='error', $caption='@User Dialog', $mess='', $Buttons= [
                        // 0: strLabel  (Cancel/Accept/Close)  1: strHint 2: jsFunction() 3: imgIcon 4: Result
//                        ['@Confirm', '@Hint', '$(this).dialog("close")', 'Icon', true ],
//                        ['@Close',   '@Hint', '$(this).dialog("close")', 'Icon', false]
//                    ])
        
//        if (('.msg_Dialog($type='warn', $caption='@User Dialog', $mess='@Are You Sure to Remove This Row', 
//                         $Buttons= [[$label='@Accept', $hint='', $func='$(this).dialog("close")', $Result=false],
//                                    [$label='@Cancel', $hint='', $func='$(this).dialog("close")', $Result=false]]).' == true) 
//            or (true))
        '
        if (confirm("'.lang('@Are You Sure to Remove This Row?').'") == true) {
            var $this = $(this);        
            // console.log($this.closest("tr"));
            // $this.closest("tbodyxxx").remove();
            // $this.closest("tr").remove();
            $(this).closest("tr").remove();
            // $(this).parent().parent().remove();
            // $this.closest("table").trigger({type:"update", resort:true});
        }
    };

    $(\'#ButtRowDelete\').click(function() {     //find the closest parent row and remove it
        // if (confirm("'.lang('@Are You Sure to Remove This Row?').'") == true) {
    //    $(this).closest(\'tr\').remove();
        // }
    });    
    
    function restoreTable() {   // Restore table-content:
        var original = $("table").html();   // Save content to restore
        // Add or remove something here
        $("#restore").click(function() { 
            $("table").html(original); 
            return false; 
        });
    };

    function remove(rowId){ // Remove Row by ID
        $("#" + rowId).remove();
    };


    function getPassword(input) {
        var text =      document.getElementById(input.id).value;
        var point =     document.getElementById("pwPoint"+input.id).value;
        point = 0;
        if ( text.length >= 6 )     {point += 1};
        if ( text.length >= 8 )     {point += 1};
        if ( text.length >= 10 )    {point += 2};
        if ( text.length >= 12 )    {point += 2};
        if (/[a-zæøå]/.test(text) ) {point += 1};
        if (/[A-ZÆØÅ]/.test(text) ) {point += 1};
        if (/[0-9]/.test(text) )    {point += 1};
        if (/[~`!@#$£€¤%?()\^&*+=\-\[\]\\\';,/{}|\\":<>\?]/g.test(text) ) {point += 1};
        document.getElementById("pwPoint"+input.id).value = point;
    /*  document.getElementById("mtPoint"+input.id).innerHTML = point;  */
    }
'.
"   function togglePassword(butt,input) {
        var passInput = document.getElementById(input.id);
        var togglePW  = document.getElementById(butt.id);
        if (passInput.type  === 'password')
            { passInput.type = 'text';      togglePW.innerHTML = '<i class=\'far fa-eye\'>'; } else
            { passInput.type = 'password';  togglePW.innerHTML = '<i class=\'far fa-eye-slash\'>'; }
    }

".  // https://stackoverflow.com/questions/40905372/how-to-ensure-a-tooltip-stays-within-the-browser-visible-area
'   $(".hint").on( "mouseenter", function() {
        var $this = $(this);
        var hint = $(this).find(".data-hint");
        var offset = $this.offset();
        hint.toggleClass("top", $(window).height() + hint.height() < 0);
        hint.color = "red";
        // hint.toggleClass("bottom", offset.top - hint.height() < 0);  // - just for case you want to change the default behavior -
        }
    );
'.
"   function updateInput(fieldname,ish){
        document.getElementById(fieldname).value = ish;
    }

</script>"; // $jsScripts

echo "
    <style>    /* popMnu_: if externel: <link rel=\"stylesheet\" type=\"text/css\" href=\"popMnu_.theme.css\"> */
        :root{
            --popMnu_MenuBg:        rgb(237, 237, 238);
            --popMnu_MenuShadow:    1px 1px 10px #000;
            --popMnu_MenuRadius:    3px;
            --popMnu_MenuText:      black; /* #cccccc; */
            --popMnu_SubMenuBg:     lightgray; /* rgb(127, 127, 128); */
            --popMnu_Hover:         white; /* #080a79; */
            --popMnu_OverflowIcon:  #999;
            --popMnu_Seperator:     #999;
            --FM_Link:              #007bff;
        }

        .colrred    {color: red;}
        .colrgreen  {color: green;}
        .colrblue   {color: blue;}
        .colrcyan   {color: cyan;}
        .colrbrown  {color: brown;}
        .colryellow {color: yellow;}
        .colrgold   {color: gold;}
        .colrblack  {color: black;}
        .colgray    {color: gray;}

        .bgclwhite  {background-color: white;}
        .bgclgray   {background-color: gray;}
        .bgclblack  {background-color: black;}
        .bgclgold   {background-color: gold;}

        .font14     {font-size: 14px;}
        .font16     {font-size: 16px;}
        .font18     {font-size: 18px;}
        .bold       {font-weight: bold;}

        .buttbord {
            border-style: solid;
            border-color: gray;
            border-width: 1px;
            margin: 5px;
            padding: 3px 6px;
        }
    </style>    <!-- popMnu_.theme.css -->


    <style>   /* popMnu_: if externel: <link rel=\"stylesheet\" type=\"text/css\" href=\"popMnu_.css\"> */
        .popMnu_Menu{    /* Main context menu outer */
            position: absolute;
            top: 300px;
            padding: 8px 0;
            background: var(--popMnu_MenuBg);
            box-shadow: var(--popMnu_MenuShadow);
            border-radius: var(--popMnu_MenuRadius);
            margin: 0;
            list-style: none;
            color: var(--popMnu_MenuText);
            overflow: hidden;
        }

        .popMnu_MenuSeperator{   /* Menu seperator item */
            display: block;
            padding: 5px 5px;
        }
            .popMnu_MenuSeperator div{
                width: 100%;
                height: 1px;
                background: var(--popMnu_Seperator);
            }

        .popMnu_MenuItem{    /* Default menu item */
            display: block;
            padding: 5px 8px;
            cursor: default;
        }
            .popMnu_MenuItem:hover{
                background: var(--popMnu_Hover);
            }
            .popMnu_MenuItemIcon{
                /* float: left; */
                width: 16px;
                height: 16px;
                /* padding-right: 20px; */
            }
            .popMnu_MenuItemLabel{
                text-align: left;
                line-height: 16px;
                display: inline-block;
                padding: 0px 0px 0px 8px;
            }
            .popMnu_MenuItemShort{
                float: right;
                padding: 0px 0px 0px 24px;
                text-align: right;
                line-height: 16px;
            }
            .popMnu_MenuItemOverflow{
                float: right;
                width: 16px;
                height: 16px;
                padding: 1px 0px 0px 8px;
            }
                .popMnu_MenuItemOverflow {
                    display: block;
                    height: 0px;
                    margin: 0px 6px;
                    <!-- margin: 3px 2px; -->
                    <!-- background: var(--popMnu_OverflowIcon); -->
                }
                .popMnu_MenuItemOverflow.hidden{
                    display: none;
                }

        .popMnu_SubMenu{     /* Submenu item */
            padding: 0;
            margin: 0;
            list-style: none;
            background: var(--popMnu_SubMenuBg);
            border-radius: var(--popMnu_MenuRadius);
            position: absolute;
            top: 0;
            min-height: 100%;
            width: 100%;
            left: 0;
            transition: left 0.25s;
        }
            .popMnu_Header{
                border-bottom: 1px solid var(--popMnu_Seperator);
            }
                .popMnu_Header input{
                    background: transparent;
                    color: var(--popMnu_MenuText);
                    border: none;
                    width: 30px;
                    height: 30px;
                    position: absolute;
                    left: 0;
                    font-weight: bold;
                }
                    .popMnu_Header :hover{
                        background: var(--popMnu_Hover);
                    }
                .popMnu_Header span{
                    width:100%;
                    text-align: center;
                    display: inline-block;
                    line-height: 30px;
                    font-weight: bold;
                }
            .popMnu_SubMenu .popMnu_MenuItem:hover{
                background: var(--popMnu_Hover);
            }

        .popMnu_MenuHidden{
            left: 100% !important;
        }
    </style>   <!-- \"popMnu_.css\"> -->
";

echo "
<script>    /* popMnu_: if externel: <script: src=\"popMnu_.js\"> */
    class popMnu_{
        /**
         * Creates a new popMnu_ menu
         * @param {object} opts options which build the menu e.g. position and items
         * @param {number} opts.width sets the width of the menu including children
         * @param {boolean} opts.isSticky sets how the menu apears, follow the mouse or sticky
         * @param {Array<popMnu_Item>} opts.items sets the default items in the menu
         */
        constructor(opts){
            popMnu_Core.CloseMenu();
            this.position = opts.isSticky != null ? opts.isSticky : false;
            this.menuControl = popMnu_Core.CreateEl('<ul class=\"popMnu_Js popMnu_Menu\"</ul>');
            this.menuControl.style.width = opts.width != null ? opts.width : '200px';
            opts.items.forEach(i => {
                this.menuControl.appendChild(i.element);
            });
            if(event != undefined){
                event.stopPropagation()
                document.body.appendChild(this.menuControl);
                popMnu_Core.PositionMenu(this.position, event, this.menuControl);
            }
            document.onclick = function(e){
                if(!e.target.classList.contains('popMnu_Js')){
                    popMnu_Core.CloseMenu();
                }
            }
        }
        
        add(item){  /*** Adds item to this popMnu_ menu instance    * @param {popMnu_Item} item to add to the popMnu_ menu */
            this.menuControl.appendChild(item);
        }
        show(){     /** * Makes this popMnu_ menu visible */
            event.stopPropagation()
            document.body.appendChild(this.menuControl);
            popMnu_Core.PositionMenu(this.position, event, this.menuControl);
        }
        hide(){     /** * Hides this popMnu_ menu */
            event.stopPropagation()
            popMnu_Core.CloseMenu();
        }
        toggle(){   /** * Toggle visibility of menu */
            event.stopPropagation()
            if(this.menuControl.parentElement != document.body){
                document.body.appendChild(this.menuControl);
                popMnu_Core.PositionMenu(this.position, event, this.menuControl);
            }else{
                popMnu_Core.CloseMenu();
            }
        }
    }

    class popMnu_Item{ /**
         * @param {Object} opts
         * @param {string}              [opts.label]
         * @param {string}              [opts.popHint]
         * @param {string}              [opts.type]
         * @param {Array:popMnu_Item}   [opts.submenu]
         * @param {string}              [opts.customMarkup]
         * @param {string}              [opts.imgIcon]
         * @param {string}              [opts.cssIcon]
         * @param {string}              [opts.custAttr]
         * @param {string}              [opts.shortcut]
         * @param {void}                [opts.onClick]
         */
        constructor(opts){
            switch(opts.type){
                case 'seperator':
                    this.element = popMnu_Core.CreateEl('<li class=\"popMnu_Js popMnu_MenuSeperator\"><div></div></li>');
                    break;
                case 'custom':
                case 'submenu':
                case 'normal':
                default:
                    this.element = popMnu_Core.CreateEl( 
                    `   <li class='popMnu_Js' ${'opts.popHint' != 'undefined' ? 'data-title=\"".lang(opts.popHint)."\"' : ''}>
                            <div class='popMnu_Js popMnu_MenuItem high-light_size' style=\"${'opts.custAttr' == 'undefined' ? '' : 'opts.custAttr'}\">
                                ${'opts.imgIcon' != 'undefined' ? `<img src=\"${'opts.imgIcon'}\" class='popMnu_Js popMnu_MenuItemIcon'/>` :
                                    `<div class='popMnu_Js popMnu_MenuItemIcon ${'opts.cssIcon' != 'undefined' ? 'opts.cssIcon' : ''}'></div>`
                                }
                                <span class='popMnu_Js popMnu_MenuItemLabel'>${'opts.label' == 'undefined' ? lang('@No label') : lang('opts.label')}</span>
                                <span class='popMnu_Js popMnu_MenuItemOverflow ${'opts.type' === 'submenu' ? '' : 'hidden' }' title=\"".lang('@Go to submenu')."\">
                                    <span class='popMnu_Js fas fa-bars colgray font18'></span>
                                </span>
                                <span class='popMnu_Js popMnu_MenuItemShort'>${'opts.shortcut' == 'undefined' ? '' : 'opts.shortcut'}</span>
                            </div>
                            <ul class='popMnu_Js popMnu_SubMenu popMnu_MenuHidden'>
                                <li class=\"popMnu_Js popMnu_Header popMnu_SubMenuClose\" title=\"<? echo lang('@Go back to previous menu'); ?>\">
                                    <input type='button' value='<' class='popMnu_Js' />
                                    <span class='popMnu_Js '>${'opts.label' != 'undefined' ? lang('opts.label') : lang('@No label')}</span>
                                </li>
                            </ul>
                        </li>
                    ` );

                    let childMenu = this.element.querySelector('.popMnu_SubMenu'),
                        menuItem = this.element.querySelector('.popMnu_MenuItem');

                    if (opts.submenu !== undefined || opts.customMarkup !== undefined){
                        if (opts.submenu !== undefined) {
                            opts.submenu.forEach(i => {
                                childMenu.appendChild(i.element);
                            });
                        } else if (opts.customMarkup !== undefined) {
                            childMenu.appendChild(popMnu_Core.CreateEl(`<li><div class=\"popMnu_Js popMnu_CustomEl\">${'opts.customMarkup'}</div></li>`));
                        }
                        menuItem.addEventListener('click',() => {
                            menuItem.classList.add('SubMenuActive');
                            childMenu.classList.remove('popMnu_MenuHidden');
                        });
                        childMenu.querySelector('.popMnu_SubMenuClose').addEventListener('click',() => {
                            menuItem.classList.remove('SubMenuActive');
                            childMenu.classList.add('popMnu_MenuHidden');
                        });
                    } else {
                        childMenu.parentElement.removeChild(childMenu);
                        this.element.addEventListener('click', () => {
                            event.stopPropagation();
                            if (opts.onClick !== undefined){ opts.onClick(); }
                            /* popMnu_Core.CloseMenu(); /* deactivated only in DEMO ! (don't close on Checkbox-setting) */
                        });
                    }
            }
        }
    }

    const popMnu_Core = {
        PositionMenu: (docked, el, menu) => {
            if (docked){
                menu.style.left = ((el.target.offsetLeft + menu.offsetWidth) >= window.innerWidth) ?
                         ((el.target.offsetLeft - menu.offsetWidth) + el.target.offsetWidth)+\"px\"
                        : (el.target.offsetLeft)+\"px\";

                menu.style.top = ((el.target.offsetTop + menu.offsetHeight) >= window.innerHeight) ?
                          (el.target.offsetTop - menu.offsetHeight)+\"px\"
                        : (el.target.offsetHeight + el.target.offsetTop)+\"px\";
            } else {
                menu.style.left = ((el.clientX + menu.offsetWidth) >= window.innerWidth) ?
                          (el.clientX + window.pageXOffset - 10     - menu.scrollWidth)+\"px\"  /* 10px distance from cursor */
                        : (el.clientX + window.pageXOffset + 10)+\"px\";

                menu.style.top = ((el.clientY  + menu.scrollHeight) >= window.innerHeight) ?
                          (el.clientY + window.pageYOffset - 10  - menu.scrollHeight)+\"px\"
                        : (el.clientY + window.pageYOffset + 10) +\"px\";
            }
        },
        


        CloseMenu: () => {
            let openMenuItem = document.querySelector('.popMnu_Menu:not(.popMnu_MenuHidden)');
            if (openMenuItem != null) { document.body.removeChild(openMenuItem); }
        },
        CreateEl: (template) => {
            var el = document.createElement('div');
            el.innerHTML = template;
            return el.firstElementChild;
        }
    };
</script> <!-- \"popMnu_.js\" -->
";

function MakePop($lbl='',$tip='',$icon='',$type='',$id='',$click='',$sep=',') {
    $result= 'new popMnu_Item({label: \''.lang($lbl).'\', popHint: \''.lang($tip).'\', cssIcon: \''.$icon.'\', shortcut: ';
    switch ($type) {
        case 'radio': $result.= '\'<input type="radio" id="'.$id.'" name="'.$id.'" onclick="'.$click.'" >\''; break;
        default:    $result.= 'Parameter ERROR';
    }
    $result.= '})'.$sep;
    return $result;
}

echo "
<style>
 /* Global constants/variables: */
:root {
  --creaInpBg: LightYellow;
}
 /* Special adjustments: */
th input,
tfoot input {
  padding-left:4px;
  margin-left:2px;
  height:18px;
}

td input,
input[type=text] {
    padding:3px;
    /*
    border:1px solid #ccc;
    -webkit-border-radius: 5px;
    border-radius: 3px;
    */
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

.tablesorter-blue tfoot td {    /* footer */
    font: 12px/18px Arial, Sans-serif;
    font-weight: bold;
    color: #000;
    background-color: #eee;     /* background-color: #99bfe6; */
    border-collapse: collapse;
    padding: 2px;
    text-shadow: 0 1px 0 rgba(204, 204, 204, 0.7);
}

.tablesorter .tablesorter-filter {  /* Prevents accidental min-width of filter fields */
    width: 100%;
}
.tablesorter .tablesorter-filter-row {
    background-color: #DFF;
    height: 10px;
}

</style>


<style id=".'css'.">  /* wrapper of table  */
.wrapper {
    position: relative;
    top: 14px;
    overflow-x: auto;
    display: block;
    padding: 0 5px;
    height: 300px;   /* Adjusted in HTML: $ ViewHeight */
    overflow-y: auto;
}

#overlay0, #overlay1 {
    background: rgba(244,244,244,0.8) url(http: /* mottie.github.com/tablesorter/addons/pager/icons/loading.gif) center center no-repeat; */
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
    /* background-color: #333; */
    /* color: #fff; */
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
    /* transition: visibility 2s, opacity 1.5s linear; */
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
}
// .modal-window header { font-weight: bold; }

.modal-window h1 {
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
    font-size: smaller;
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
    background-color: whitesmoke; // default
}
#footer {
    text-align: right;
}

/* Demo Styles */
// html, body { height: 100%; }
// body {
//     font: 600 18px/1.5 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
//     background-image: -webkit-gradient(linear, left top, right top, color-stop(0, #7f53ac), to(#657ced));
//     background-image: linear-gradient(to right, #7f53ac 0, #657ced 100%);
//     color: black;
// }
a { color: inherit; }
.container {
    display: grid;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    // height: 100vh;
}}
</style>
';
echo $htm_ModalDialog;

echo $headScript;   // read CSS given in htm_PagePrep parameter

if (DEBUG)
run_Script(    // Implementing Server Timing: (https://www.smashingmagazine.com/2018/10/performance-server-timing/)
'class Timers
  { private $timers = [];
    public function startTimer($name, $description = null)
    {   $this->timers[$name] = [
            "start" => microtime(true),
            "desc" => $description,
        ]; }
    public function endTimer($name)
    {   $this->timers[$name]["end"] = microtime(true); }
    public function getTimers()
    {   $metrics = [];
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
');
//  Use timer:
//  if (DEBUG) run_Script('$Timers->startTimer("db"); ');
//  ReadSQL();
//  if (DEBUG) run_Script('$Timers->endTimer("db"); ');

//  Create header with timings:
//  if (DEBUG) run_Script('header("Server-Timing: ".$Timers->getTimers()); ');

run_Script("function toast(txt, bgcolr='#333', fgcolr='#fff') {
    var x = document.getElementById('snackbar');
        x.innerHTML= txt;
        x.className = 'show';
        x.style.background = bgcolr;
        x.style.color = fgcolr;
        setTimeout(function(){ x.className = x.className.replace('show', ''); }, 5000);
    }");
/*        
    run_Script("function deleteThisRow(table) {
        var Sthis = $(this);
        var Stable= $(table);
        console.log($(this).closest('tr'));
        $(this).closest('tr').remove();
        Stable.trigger('update');
        return false;
    }");
*/
    run_Script("function invertColor(hex, bw) {
        if (hex.indexOf('#') === 0) {
            hex = hex.slice(1);
        }
        if (hex.length === 3) { // convert 3-digit hex to 6-digits.
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        if (hex.length !== 6) {
            throw new Error('Invalid HEX color.');
        }
        var r = parseInt(hex.slice(0, 2), 16),
            g = parseInt(hex.slice(2, 4), 16),
            b = parseInt(hex.slice(4, 6), 16);
        if (bw) {
            // http://stackoverflow.com/a/3943023/112731
            return (r * 0.299 + g * 0.587 + b * 0.114) > 186
                ? '#000000'
                : '#FFFFFF';
        }
        // invert color components
        r = (255 - r).toString(16);
        g = (255 - g).toString(16);
        b = (255 - b).toString(16);
        // pad each with zeros and return
        return '#' + padZero(r) + padZero(g) + padZero(b);
    }");

//   run_Script('function addRow(tableID) {                      // Get a reference to the table
//           let tableRef = document.getElementById(tableID);
//           let newRow = tableRef.insertRow(-1);                // Insert a row at the end of the table
//           let newCell = newRow.insertCell(0);                 // Insert a cell in the row at index 0
//           let newText = document.createTextNode("New");       // Append a text node to the cell
//           newCell.appendChild(newText);
//           let newCell1 = newRow.insertCell(1);
//           let newCell2 = newRow.insertCell(2);
//           let newCell3 = newRow.insertCell(3);
//           let newCell4 = newRow.insertCell(4);
//           let newCell5 = newRow.insertCell(5);
//            let newCell6 = newRow.insertCell(6);
//            let newCell7 = newRow.insertCell(7);
//            let newCell8 = newRow.insertCell(8);
//      }
//        // addRow("my-table");                                  // Call addRow() with the table´s ID
//    ');
    

### ----------------------Library-fontawesome icons ----------------------
    //$source_Ajax = 'https://cdnjs.cloudflare.com/ajax/libs/';
    $source_Ajax = $ØProgRoot.'_assets/font-awesome5/';
    echo '<link rel="stylesheet" href="'. $source_Ajax. '5.9.0/css/all.min.css">';
    //echo '<script defer src="'.$_assets.'font-awesome5/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.js"></script>';   //   topic= "ICON-system" version 5


    $ØPageLogo= $ØProgRoot.'21997911.png';

    echo $CSS_system;    // Activate the system style
//  echo '<style type="text/css"> <!--  @font-face { font-family: barcode; src: url('.$ØProgRoot.'_assets/fonts/barcode.ttf); } --> </style>';
    set_Style('type="text/css"', '<!--  @font-face { font-family: barcode; src: url('.$ØProgRoot.'_assets/fonts/barcode.ttf); } --> ');
    $bottLogo= ''; //'url('.$ØPageLogo.') right bottom/3% no-repeat,';
//  echo '<style type="text/css"> body { background: '.$bottLogo.' url('.$ØPageImage.') left top repeat; font-family: sans-serif;} </style>';
    set_Style('type="text/css"', 'body { background: '.$bottLogo.' url('.$ØPageImage.') left top repeat; font-family: sans-serif;}');
    //$PgInfo= lang('@page: Customer-ORDER');
    if ($PgInfo>'')
    //    echo '<div style="position: fixed; width: min-content; bottom: 10px; right: -'.(8.2 * min(strlen($PgInfo),33) ).'px; z-index: 99;
    //        transform-origin: bottom left; transform: rotate(-90deg); white-space: nowrap; padding: 3px; background-color:white;">'.$PgInfo.'</div>';
/*        echo '<div style="position: fixed; width: 0; bottom: 10px; right: -0.5em;; z-index: 99; 
            transform-origin: bottom left; transform: rotate(-90deg); white-space: nowrap; padding: 3px; background-color:white;">'.$PgInfo.'</div>';*/
        echo '<div style="position: fixed; z-index: 99; float: right; display: inline-block; width: max-content; right: 0;
            transform-origin: right bottom; transform: rotate(-90deg) translate(-100%, 0); white-space: nowrap; padding: 2px; background-color:#ddddddbd;">'.$PgInfo.'</div>';

    
    //$PgHint= 'Tip: Toggle fullscreen-mode with function key: F11';
    if ($PgHint>'')
        echo '<div style="position: fixed; width: min-content; bottom: -10px; left: 0px; z-index: 99;
            transform-origin: top left; transform: rotate(-90deg); white-space: nowrap; padding: 2px; background-color:#ddddddbd;" '.
            'title="CTRL-Scroll UP/Down mousewheel to zoom window content">'.
     // '<data-hint>CTRL-Scroll UP/Down mousewheel to zoom window content</data-hint>'.
            $PgHint.'</div>';
    // echo '<div class="ver_right"; style="color:red;">[[[[[[[[[HHHHH__HHHHHH]]]]]]]]]]</div>';

    echo $jsScripts;
    
    echo "\n</head>\n
             <body>\n"; 
    echo '<div style="text-align: '.$align.'; background-image: url(\''.$ØPageImage.'\');">';
} // htm_PagePrep()


function htm_PageFina() { global $ØPanelIx, $panelCount, $ØProgRoot, $jsScripts;
    $panelCount= $ØPanelIx;
    echo '</div>';  // $align - Started in htm_PagePrep()
    //Menu_Bottom();
    echo '<div id="snackbar">Short message</div>';
    if (is_null($panelCount)) $panelCount= 15;
    PanelInit();
    // echo $jsScripts;
    echo "
    <script>    /* https://css-tricks.com/value-bubbles-for-range-inputs/ */
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
            /* bubble.style.left = `calc(${pctVal}% + (${8 - pctVal * 0.15}px))`;  // Sorta magic numbers based on size of the native UI thumb */
            "
        }
    </script>";
    
    if (DEBUG) run_Script('header("Server-Timing: ".$Timers->getTimers()); ');
//  include($ØProgRoot.'../spormig.php');
    htm_nl(1);
    echo "\n  </body>"; // Started in htm_PagePrep()
    echo '</html>';
}



 if (!function_exists('Lbl_Tip'))
{ // Start: GRANULES - Group of function declearins:  Read only once !

# BASE GRANULE:
function Lbl_Tip($lbl,$tip,$plc='',$h='13px',$t='') { # Label with popup-tip / info / LongLabel / details to the user, when mouseover the label.
    if ($t!='')  $t= ' top:'.$t;
    if ($lbl=='') return '';
    else {    dvl_pretty('Lbl_Tip');
        if ($h=='0px') {$h='';}
        switch (strtoupper($plc)) {
        case 'W':  $class= 'LblTip_W';  break;    # Plac. Left                'tooltipW';
        case 'S':  $class= 'LblTip_S';  break;    # Plac. Under               'tooltipS';
        case 'O':  $class= 'LblTip_O';  break;    # Plac. Right               'tooltipO';
        case 'N':  $class= 'LblTip_N';  break;    # Plac. Over                'tooltipN';
        case 'NW': $class= 'LblTip_NW'; break;    # Plac. direction NW        'tooltipNW';
        case 'SW': $class= 'LblTip_SW'; break;    # Plac. direction SW        'tooltipSW';
        case 'SO': $class= 'LblTip_SØ'; break;    # Plac. direction SØ        'tooltipSØ';
        default :  $class= 'LblTip_text';         # Plac. Over
        }
        if (strlen($tip.' ')<140) {$wdth='';} else {$wdth='style ="min-width: 320px;"';}
        if ($tip=='') $tip=lang('@No details !');
        $tip= '<span class="'.$class.'" '.$wdth.'>'.lang($tip).'</span>';
        return '<span class="LblTip" style="height:'.$h.$t.'">'.ucfirst(lang($lbl).' ').$tip.'</span>';
    }
}

# dvl ~ DEVELOP - Rutines to search for errors:
if (!function_exists('dvl_pretty')) {
    function dvl_pretty($testlabl='') {   // Insert linefeed and label, in the html-kode, so sourcecode gets more readably
    if (DEBUG) { echo "\n"; if ($testlabl>'') echo '<!-- '.$testlabl.': -->'."\n"; return "\n"; }
}}

if (!function_exists('dvl_echo')) {
function dvl_echo($testlabl='') {      // Debugging system - labels will be added in html-sourcecode
    if ((DEBUG) and ($testlabl>'')) {echo "<br>". $testlabl. "\n";}
}}

function calcHash($usr_name,$usr_code) {
    return $result= "<span style='color:red;'>'".$usr_name."' => '".password_hash($usr_code, PASSWORD_BCRYPT)."',</span>". ' '.'//'.' '.$usr_code;
}



// String-output:
function htm_Ihead($source) {echo '<br/><i>'.$source.'</i> ';}
function htm_hr($c='#0')    {echo '<hr style="background-color:'.$c.';"/>';}
function htm_nl($rept=1)    {echo str_repeat('<br />',$rept);}
function htm_lf($rept=1)    {echo str_repeat(' &#xa;',$rept);}  //  LineFeed
function htm_sp($rept=1)    {echo str_repeat('&nbsp;',$rept);}

function htm_space($wdt)    {echo '<span style="width:'.$wdt.';"></span>';}


// String-funktions:
function str_bold($source,$result='',$tail='&nbsp;&nbsp;') {return $result.'<b>'.$source.'</b>'.$tail;}
function str_Ihead($source) {return '<br /><i>'.$source.'</i> ';}
function str_hr($c='#0')    {return '<hr style="color:'.$c.';"/>';}
function str_nl($rept=1)    {return str_repeat('<br />',$rept);}
function str_lf($rept=1)    {return str_repeat(' &#xa;',$rept);}  //  LineFeed in strngs:  &#010;  &#xa;  \n \u000A  \x0A  &#13;  %10%13  %0D%0A
function str_sp($rept=1)    {return str_repeat('&nbsp;',$rept);}

function markFirstChar($str='',$tag='u',$att='') { $str= lang($str); $str= '<'.$tag.' '.$att.'>'.substr($str,0,1).'</'.$tag.'>'.substr($str,1); return $str; }
function markAllChars($str='',$tag='u',$att='')  { $str= lang($str); $str= '<'.$tag.' '.$att.'>'.$str.'</'.$tag.'>'; return $str; }

function toNum($test='') { $test= str_replace(',','.',$test); if (!is_numeric($test)) $test= 0; return $test; }

function scannSource($prefix='$name=',$suffix="'",$files=[]) {
    $echo= false;   if ($echo) echo '<br>'.$prefix.' <b>';
    $result= [];    $lines = [];
    foreach ($files as $fname) $lines = $lines + file($fname);
    foreach ($lines as $aline => $line) {
        $pos1= strpos($line,$prefix);
        if (($pos1>0) and (strpos($line,'cannSource')==0)) {
            $tag= substr($line,$pos1+2+strlen($prefix));
            $len= strpos($tag,$suffix)+3;
            $str= trim(substr($line,$pos1+strlen($prefix),$len),"'");
            $result[]= $str;    $count++;   if ($echo) echo $str.', ';
    }   }
    if ($echo) { echo '</b> :COUNT: '.$count.' '.count($result).'<br>'; arrPrint($result,'result'); }
    return $result;
}

function form2arr(&$arr, $checks=[]) {
    $result= [];
    foreach($_POST as $key=>$val) {
        if (substr($key,0,4) != 'btn_') $result[$key]= $val;
    }
    $arr= $result;
}
function tabl2arr(&$arr,$firstId,$arrSpec=[]) {
    $arrTmp= [];    $result= [];
    foreach($_POST as $key=>$val) { if (substr($key,0,4) != 'btn_') $arrTmp[$key]= $val; }
    for ($i= 0; $i < count($arrTmp[$firstId]); $i++) {
        foreach ($arrTmp as $key=>$val) {
            if (in_array($key,$arrSpec)) $val= str_replace([" ","."], ["",""], $val);   // Remove SPACE and thousand-sep
            if (substr($key,0,4)==substr($firstId,0,4)) // Filter tableFields
                $arrRow[$key] = $val[$i];               // Only variables with aktual prefix
        }
        $result[]= $arrRow;
    }
    $arr= $result;
}

function fromFile ($dPath, $arrNames) {
    foreach ($arrNames as $aname) {
        if (is_readable($dPath.$aname.'.dat.json'))  FileRead_arr($dPath.$aname.'.dat.json', $GLOBALS[$aname]);
}}


if (!function_exists('lang')) {
    function lang($txt) {                # lang() is used to translate all hard-coded program-text.
        global $lang, $transTable;
        // return trim($txt,"@");

        if (!strlen($lang)) $lang = 'en';
        $transTable['en']['AppName'] = 'PHP to HTML';   // English Language:
    //  $allLang = sys_get_translations($transTable);
        //$transTable == $allLang ? $allLang : $transTable;
        $transTable = $allLang;
        if (isset($transTable[$lang][$txt]))     return sys_enc($transTable[$lang][$txt]);  // National
        else if (isset($transTable['en'][$txt])) return sys_enc($transTable['en'][$txt]);   // English
        else                                     return trim($txt,"@");                     // English default, if not in translate table   // Native (english)
    }
}

/**
 * Encode html entities
 * @param string $text
 * @return string
 */
function sys_enc($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}


/*
 * get language translations from json file
 * @param int $transTable
 * @return array
 */
function sys_get_translations($transTable) { global $lang_list;
    try {
        $content = file_get_contents('../.sys_trans.json');
        if($content !== FALSE) {
            $lng = json_decode($content, TRUE);        // arrPrint($lng,'$lng');
            foreach ($lng["language"] as $key => $value)
            if ($value["translation"])  // Only if translation exists for that language
            {   $lang_rec["code"]        = $value["code"];           // $value["code"];
                $lang_rec["name"]        = $value["name"];           // $value["name"];      Name in english
                $lang_rec["native"]      = $value["native"];         // $value["native"];    Name translated from english
                $lang_rec["author"]      = $value["author"];         // $value["author"];
                $lang_rec["note"]        = $value["note"];           // $value["note"];
                $lang_rec["DateTime"]    = $value["DateTime"];       // $value["DateTime"]; // setlocale(LC_TIME, 'da_DK','da','da_DK.utf8'); ?
                $lang_rec["translation"] = $value["translation"];

                $lang_list[]= $lang_rec;
                if ($transTable) { $transTable[$value["code"]] = $value["translation"]; }    // $value["translation"];
                if (substr($_SESSION['proglang'],0,2)==$lang_rec["code"]) $_SESSION['currLang']= $lang_rec;
            }
            # if (false) { $out = fopen('json.out', "w"); fwrite($out, PHP_EOL. print_r($value["translation"], true)); fclose($out); } // save pretty JSON-file
            return $transTable;
        }   // else toast('File error !','yellow','black');
    }
    catch (Exception $e) {
        echo $e;
    }
}
// if ($transTable==[]) $transTable= sys_get_translations($transTable); // All languages with translation: en, da, fr, de
//$_SESSION['trans'] = $transTable;
// arrPrint($lang_list,'$lang_list');
 // arrPrint($transTable,'$transTable');


function postValue(&$id,$varId) {
    if (isset($_POST[$varId]))  { $id = $_POST[$varId]; }
    else $id= 54321;    // Default init in DEMO !
    return $id;
}

function get_browser_name($user_agent) { # Call: get_browser_name($_SERVER['HTTP_USER_AGENT']);
    if     (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge'))    return 'Edge';
    elseif (strpos($user_agent, 'Chrome'))  return 'Chrome';
    elseif (strpos($user_agent, 'Safari'))  return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') ||  strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    return 'Other';
}

# DropDown:HTML-string
function DropDown($name, $valu, $list ,$more='') {
    dvl_pretty();
    $Result=  '<div style="margin-right:0;"> ';
    $Result.= '<select class="styled-select" id="'.$name.'" name="'.$name.
              '" style="max-width:140px; background-color:transparent; '.$more.
              '"> '."\n".'<option label="" value="" > - </option>';  //  selected disabled hidden
    foreach ($list as $rec) { dvl_pretty();
        $Result.= "\n".'<option label="'.lang($rec[1]).'" value="'.$rec[0].'" title="'.lang($rec[2]).'"';
            if ($rec[0]==$valu) $Result.= ' SELECTED ';
        $Result.= '>'.$lbl=lang($rec[1]).'</option> ';
    }
    $Result.= '</select></div> ';
    // echo '<pre>'.$Result.'</pre>';
    return($Result);
}


function infoLabl($label='',$title='',$plac='SW') {
    echo Lbl_Tip($label,$title,$plac,$h='20px');
}

function menuCapt ($h='32',$w='120',$label='') {  dvl_pretty();
    echo '<div style="background-image: linear-gradient(lightgray, white); height: '.$h.'px; width: '.$w.
                'px; border: solid 1px darkgray; text-align: center; font-weight: 600; margin: auto;">
                '.ucfirst(str_replace(' ','&nbsp;',lang($label))).
        '</div>';
}

function menuButt ($h='32',$w='120',$label='',$link='',$title='') {  dvl_pretty();
    if (strpos($link,'blindAlley.page.php')>0)
        { $state= ' disabled '; $mess= str_lf().' (A blind alley yet!)';}
    else {$mess=''; $state=''; };
    echo '<button type="button" onclick="location.href=\''.$link.'\'"
            style="background-image: linear-gradient(white, lightgray); height: '.$h.'px; width: '.$w.'px; border: solid 1px darkgray; text-align: center;"
            title="'. lang($title).$mess.'" '.$state.'data-tiptxt="'.lang($title).$mess.'" '. '>
            <span style= "white-space: nowrap;">'.ucfirst(str_replace(' ','&nbsp;',lang($label))).'</span>
            </button>';
}



} // End of group: GRANULES


# CSS for the system:
$CSS_system = '
<style>

/* COLORPALETTE: (Central settings of used colors) */
:root {   /* Static nuances: */
    --roedColor: #FF0000;
    --guulColor: #F3F033;
    --grenColor: #336600;
    --grenColr1: #448800;   /* placeholder-text */
    --lablColor: #500000;   /*  #1b5b22;  #363eba;   /* LysBlå: Labels Caption */
    --lablBgrnd: FloralWhite;
    --oranColor: #F37033;
    --brunColor: #550000;   /*  Table borders  */
    --grayColor: #ACA9A8;
    --shadColor: #d3d3d352;
    --xx11Color: #3CBC8D;
 /* --HintsBgrd: rgba(55, 55, 55, 0.90);     --HintsText: #FFFFFF; */
 /* --HintsBgrd: rgba(240, 240, 240, 0.90); */
    --HintsBgrd: lightyellow; /* #E4FBFBE8; */
    --HintsText: #000000;
    --xx33Color: #CCEDFE;   /*  Filter: Light-Blue background */
    --grColrLgt: #CCCCCC;
    --FieldBord: #AAAAAA;   /* Panel- and Field-border */
    --FieldBgrd: #FAFAFA;   /* Field background-color */
    --PanelBgrd: <?php echo $GLOBALS["ØPanelBgrd"]; ?>;
    --TapetBgrd: <?php echo $GLOBALS["ØTapetBgrd"]; ?>;
    --ButtnBgrd: #44BB44;   /* LysGrøn   */
    --ButtnText: #FFFFFF;   /* Hvid   */
    --BtLnkBgrd: #FCFCCC;   /* LysGul   */
    --BtLnkText: #000000;   /* Sort   */
    --ButtnShad: #DDDDDD;   /* Knap skygge (lysgrå)  */
    --PageBcgrd: #333333;   /* Side baggrund (lysblå) F4FFF4  */
    --PageBcgrd: <?php echo $ØPageBcgrd; ?>;  /* Initieres i ../_base/_base_init.php */
    /* --PageImage: url(../_assets/images/paper_fibers.png);   /* Side baggrundsbillede  */
    /* url understøttes ikke i browsere endnu! (March 29, 2016) https://blog.hospodarets.com/css_properties_in_depth  Images url like url(var(--image-url)) don’t work */
    /* --PageImage: <?php echo $ØPageImage; ?>;  /* Initieres i _base_init.php /Virker i ../_base/htm_pagePrepare.php */
    --fltBgColr: #FFFFFF;   /* Validerede input felters baggrund  #53a40 */
    --fltTxColr: #550000;   /* Validerede input felters tekster #53a40 */
    --tblRowDrk: #e0e0e0;   /* Tabellinie med mørk baggrund */
    --tblRowLgt: #f0f0f0;   /* Tabellinie med lys baggrund  */
    --btnTxNorm: #000000;   /* Standard tekst på knap */
    --btnTxOver: #900000;   /* Tekst på knap, når musen er over knappen */
    --SkyTxNorm: #AAF;      /* Tekst med skygge #AAF; */

    /* Herudover forekommer green, blue, white, black og grånuancer, samt "importerede".  */
    /* Således kaldes farvekonstanter:    var(--FieldBord) */

    --FldHeight: 32px;
}

    /*************************************

    Tip-system:  Label [.LblTip .labltip], som kan vise popup-vindue [.LblTip*]
           med teksten [.LblTip_text] på mørkfarvet shape-baggrund, når musen holdes over label
           Vises med minimal forsinkelse
    */

    .LblTip,
    .LblTip_W,  .LblTip_O,  .LblTip_S, .LblTip_N,
    .LblTip_NW, .LblTip_SW, .LblTip_SØ
    {   font-family: sans-serif;
        position: relative;
        cursor: help;
        display: inline-block;
        background: var(--lablBgrnd);
        color: var(--lablColor);
        border-radius:3px;
        border: 1px solid var(--FieldBord);
        box-shadow: 2px 2px 1px var(--ButtnShad) inset;
        padding: 0px 3px 1px 3px;
        text-align: center;
        margin-bottom: 2px;
        font-size: 11px;
    }

    .LblTip {
        text-shadow:0px 0.6px var(--SkyTxNorm);
    }

    .LblTip_text,                                   /* LABEL som musen holdes over */
    .LblTip_W,  .LblTip_O,  .LblTip_S, .LblTip_N,   /* Hjælpetekst som synliggøres */
    .LblTip_NW, .LblTip_SW, .LblTip_SØ              /* Bestemmer placering af Tip  */
    {                   /* Hidden tip text on colored background placed at label */
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
    .LblTip_N {bottom: 20px;  left: -25px;}                      /* Plac over kilde - Inputfelters label */
    .LblTip_S {top: 22px;     left: -90px;   min-width: 120px;}  /* Plac under kilde - Kolonneoverskrifter, hvor der ikke er plads ovenover. */
    .LblTip_NW {bottom: 20px; left: -180px;  min-width: 160px;}
    .LblTip_SW {top: 22px;    left: -280px;  min-width: 160px;}  /* Ved 1. kolonne er der ikke plads tv for feltet*/
    .LblTip_SØ {top: 22px;    left: 28px;    min-width: 160px;}  /* Ved n. kolonne er der ikke plads th for feltet*/
    .LblTip_W {left: -26px;   margin-top: -28px;}
    .LblTip_O {right: -26px;  margin-top: -28px;}

    .LblTip:hover   .LblTip_N,
    .LblTip:hover   .LblTip_S,
    .LblTip:hover   .LblTip_NW,
    .LblTip:hover   .LblTip_SW,
    .LblTip:hover   .LblTip_SØ,
    .LblTip:hover   .LblTip_W,
    .LblTip:hover   .LblTip_O,
    .LblTip:hover   .LblTip_text,
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
    /* .lablInput input[type="text"],
    .lablInput input[type="password"] {
        width: 71%;
    }  */

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
      font: normal normal normal 14px/1em;  /*  font-style  font-variant  font-weight   font-size/line-height font-family */
      font-size: 2em;
      text-rendering: auto;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      position: absolute;
      top: 0.3em;
      right: 0.3em;
      transform: translate(0, 0);
    }

    ::-webkit-input-placeholder { color: var(--grenColr1); font-size: 90%; }
    :-moz-placeholder { color: var(--grenColr1); font-size: 90%; } /* Firefox 18- */
    ::-moz-placeholder { color: var(--grenColr1); font-size: 90%; }  /* Firefox 19+ */
    :-ms-input-placeholder { color: var(--grenColr1); font-size: 90%; }


    hr.style13 {
      height: 6px;
      border: 0;
      box-shadow: 0 10px 10px -10px #8c8b8b inset;
    }


/* RowColS: (Adaptation to narrow screens) */
/* for 960px or greater */
@media screen and (min-width: 960px) {
    #colnwrap   {width: 99%; padding: 0px;    /*  margin: 5px 5px; */}
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
    #RowColsaut {width: auto;   padding: 5px 0px 5px 5px; margin: 5px 0px 5px 0px; float: left;}
    data-PanlHead, PanlFoot  {clear: both;   padding: 0 5px;}
}

/* for 960px or less */
@media screen and (max-width: 960px) {
    #colnwrap   {width: 99%;  }
    #RowCol320  {width: 41%;  padding: 5px 5px;   margin: 0px 0px 5px 5px;}
    #RowColsaut {width: auto; padding: 5px 5px;   margin-left: 0px;   clear: both;    float: none;  }
    data-PanlHead, PanlFoot {padding: 1px 5px;   clear: both;}
}

/* for 640px or less */
@media screen and (max-width: 640px) {
    #RowCol320  {width: auto;  float: none;  margin-left: 5px; }
    #RowColsaut {width: auto;  float: none;  margin-left: 5px; }
}

/* for 480px or less */
@media screen and (max-width: 480px) {
    data-PanlHead {height: auto; }
    h1    {font-size: 2em;  }
}

@media screen and (max-width: 1280px) { @viewport { width: 1280px; } }

/*************************************/

/* PANELS: (in different widths) */
.panelWmax, .panelWaut, .panelW120, .panelW110, .panelW100, .panelW960, .panelW800, .panelW720,
.panelW640, .panelW560, .panelW480, .panelW400, .panelW320, .panelW280, .panelW240, .panelW160 {
    border: 1px solid var(--grayColor);
    background: var(--PanelBgrd);
    box-shadow: 3px 3px  <?php echo $shadowBlur; ?> var(--ButtnShad);
    border-radius: 0.4em;
    border-style: inset;
    border-color: lightgray;
    border-width: thin;
    /* margin: 0.4em 0.2em 0.4em 0.2em; /**/
    padding: 0.3em 0.3em 0.4em 0.3em; /**/
    display: inline-block;
}
.panelWmax { /* width: 100%; */   }
.panelWaut { width: auto;   }
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
    font-size: 0.88em;
    font-weight: 600;
    height: 1.1em;
    margin: 0.0em 0.2em;
    padding: 0.1em 0.1em 0.3em;
    background: #var(--panelTitl);
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
    background-image: url('.$ØProgRoot.'_assets/images/eurosymbol60.png);
    box-shadow: 3px 3px  <?php echo $shadowBlur; ?> var(--ButtnShad);
    border-radius: 0.40em;
    margin: 0.4em 0.2em 0.4em 0.2em;
    padding: 0.3em 0.3em 0.3em 0.3em;
    /* max-width: 100%;   */
    /* width: 640px;    */
}

.clearWrap {
    /* overflow: auto; */
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

.fieldStyle,
.tableStyle {
    display:inline-block;
    border-radius: 5px;
    border: 1px solid var(--FieldBord); /* border: none; */
    background-color: var(--FieldBgrd); /* background-color: transparent; */
                                        /* background-image: url(\'_background.png\'); */
    position: relative;
    /* text-align: right; */
    margin:3px;                         /* margin: 0; */
    padding:3px;                        /* padding: 0; */
 /* Minimalistic: - change here: */
    /* background-color: transparent; */
    margin: 1px;
    padding: 1px;
}
.lablInput input {
      border: 0px solid var(--grColrLgt);
 /* */
}


.fieldStyle {
    height: var(--FldHeight);
}

/* 
input[type=date]::-webkit-inner-spin-button,
input[type=date]::-webkit-outer-spin-button {
    -webkit-appearance: none; /* Hide in Chrome * /
    margin: 0; 
}

input[type="date"]::-webkit-calendar-picker-indicator{
    display: inline-block;
    margin-top: 2%;
    float: right;
}
*/
 
/* https://stackoverflow.com/questions/15530850/method-to-show-native-datepicker-in-chrome/30895180#answer-45461709 */
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

/* adjust clear button */
input[type="date"]::-webkit-clear-button {
    z-index: 1;
}
input[type="date"] {
    position: relative;
}
input[type="date"]:after {
    content: "\25BC"; 
    color: #555;
    padding: 0; /* 0 2px; */
}
input[type="date"]:hover:after {    /* change color of symbol on hover */
    color: #bf1400;
}

input[type="date"]::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0;
}

.inpField {                     /* The container for INPUT and LABEL: */
    /* border: 1px solid #d3d3d357;  */
    position: relative;
    min-height: 38px;
}
.inpField input {               /* The INPUT-field: */
    border: 1px solid var(--FieldBord);
    border-radius: 5px;
    font-size: 12px;
    padding: 8px 0px 6px 6px;
    margin: 6px 1px 1px 1px;
    width: 94%
 /* USER: text-align: center; */
}
.inpField label {               /* The visibly LABEL: */
    padding: 0px 0px 1px 3px;
    position: absolute;
    top:  -3px;
    left: 0px;
    width: 94%;
    text-align: right;
}
.inpField label div {           /* The labels popup-HINT: */
    border: solid 1px var(--FieldBord);
    border-radius: 3px;
    box-shadow: 2px 2px 1px var(--ButtnShad) inset;
    background-color: var(--lablBgrnd);
    /* margin: auto; */
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
    /* "ToolTip" with html content (formattet with html tags): */
    /* Example: <abbr class="hint">This activity will be open to registration on April 31st <data-hint>[ *the contents<b> you </b>would want to popup here* ]</data-hint></abbr> */
    /* // SYNTAX: <abbr class= "hint"> <div>'.Slabel.'</div><data-hint>'.Stitle.'</data-hint></abbr> */
'
.hint {
    color: var(--lablColor); // #900000;
    background-color: var(--lablBgrnd);
}
abbr.hint data-hint {
    display: none;
    position: relative;
    /* left: 50%; */
    left: 50px;
}
abbr.hint:hover {
    cursor: pointer;
}
abbr.hint:hover data-hint {
    /* opacity: 0;    transition: opacity 2s;    transition-delay: 1s; */
    display: block;
    position: absolute;     /* this will let you align the popup with flexibility */
/*  left: 20px;             /* change this depending on how far from the left you want it align */
/*  top: -30px;             /* change this depending on how far from the top you want it to align */
/*  data-hint.style.left = ((el.clientX + data-hint.offsetWidth)  >= window.innerWidth) ?  ((el.clientX - data-hint.offsetWidth))+"px"  : (el.clientX)+"px";
    data-hint.style.top =  ((el.clientY + data-hint.offsetHeight) >= window.innerHeight) ?  (el.clientY - data-hint.offsetHeight)+"px"  : (el.clientY)+"px";
*/
    width: 200px;           /* give this your own width */
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


.btnTit { /* Titels in grid-menu top-buttons: Dont show tooltip! */
/*   content: attr(title); */
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

.btn       { color: var(--btnTxNorm); text-decoration: none;}
.btn:hover { color: var(--btnTxOver); z-index: 777;}
.btn {
    font-size: 0.85em;
    font-family: sans-serif;
    white-space: pre-wrap;
    // min-width: 220px;
    position: absolute;
    top: 30%;
    left: 50%;
    z-index: 666;
    transform: translate(-50%, -50%);
    color: var(--btnTxNorm);
    margin-top: 3px;
//   max-width: 160px; 
    padding: .001em;
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
    /* background-color: LightYellow; */
    background-image: url("'.$ØProgRoot.'_background.png");
    padding: 10px;
    grid-gap: 10px;
    text-align: center;
}

.grid-item {
    /* background-color: rgba(255, 255, 255, 0.8); */
    /* border: 1px solid rgba(100, 100, 150, 0.6); */
    /* padding: 5px; */
    /* font-size: 30px; */
    /* text-align: center; */
}

[contentEditable=true]:empty:not(:focus):before{
    content:attr(data-placeholder);
    color: var(--grenColr1);
    font-size: 90%;
}



.range-wrap {   /* https://css-tricks.com/value-bubbles-for-range-inputs/ */
    position: relative;
    /* margin: 0 auto 3rem; */
}
.range {
    width: 100%;
}
.bubble {
    /* background: green; */
    background: lightgray;
    /* color: white; */
    /* padding: 4px 12px; */
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
/*  -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button; */

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

</style>
';  // End of $CSS_system

if (is_readable($custFile= '../customLib.inc.php')) require_once($custFile);
# In /customLib.inc.php you can add modified or needed code

##  ToDo: 
 #  FIX: removeRow()
 #  FIX: clone: plusbtn

// HOW TO COMPRESS SOURCE CODE:
// Open your file in Notepad++
// Edit > BLANK Operations > TAB to SPACE
// Open the Replace dialog ( CTRL + H )
// Check the two options Wrap around and Regular expresion.
// Find:
//  \/\*([\s\S]*?)\*\/|#+ .*?(?=\r?$)|(\s\/\/.*?)(?=\r?$)|#+\r
// Explained:
//  \/\*([\s\S]*?)\*\/      /**/    Mark multi-line comments
//  |#+ .*?(?=\r?$)         #       or Mark #SPACE comments until EOL (Word/LF starting with One or more # followed by SPACE )
//  |(\s\/\/.*?)(?=\r?$)    //      or Mark // comments until EOL (From lineStart or prefixed width SPACE)
//  |#+\r                   #       or Mark single # at EOL
// Replace with EMPTY (Now is all comments removed)
// Edit > Line Operations > Remove Empty Lines (Containing Blank Characters)
// Edit > BLANK Operations > Remove preceeded and subordinate SPACES
// Repeat - Find: SPACESPACESPACE Replace to:SPACESPACE until not found
// Save lib-file as minimized file .min.

// Now lib-file is ready for removing unused functions....
//      Search:'function'   Put 'funcName' in array
//      Search in Project-files: Mark used 'funcName' s
//      Remove unused functions in lib-file
//      Save lib-file as optimized file .opt.

// Regex: https://regexr.com/

?>