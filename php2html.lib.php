<?   $DocFileLib='../php2html.lib.php';    $DocVers='1.2.0';    $DocRev1='2022-05-31';     $DocIni='evs';  $ModulNo=0; ## File informative only

#   PHP to HTML engine - "Clever-Html-Engine" for front-end design, with lots of advanced features.
#
#   If you program html code in php, you can use this library's routines to generate fast structured html code with advanced features.
#
#   HTML elements INPUT / CHECKBOX / RADIO-GROUP / TABLE and others, generated from PHP-functions.
#   Combined with: Label, ToolTip, Placeholder, dimensions and others.
#   Incorporated translate system. Font-awesome icons.
#   Extended table functions (sort, filter, and much more) with jquery.tablesorter (Mottie Tablesorter-library).
#
#   Based on HTML5, CSS3, PHP7+/PHP8+
#   Source must be UTF-8, no tabs, indent: 4 chars
/*            _____  _       _                __ _
 *           |  ___|\ \    / /               / _| |
 *           | |__   \ \  / / ___  ___  ___ | |_| |_
 *           |  __)   \ \/ / |___|( __)/ _ \|  _| __)
 *           | |____   \  /       \__ \ (_) ) | | |_
 *           |______|   \/        (___)\___/|_|  \__)
 *
 */ $©= 'Open source - Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE'; /*

    Created: 2020-02-29 evs - EV-soft
    Latest revision: see file 1. line: $DocRevi
    R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
    2020-00-00 - evs  Initial
*/

##### WARNING: If you edit this file, you have to do the same edit, after an update !
##### Put your modifications in custom files like: '../customLib.inc.php' (search : include, require_once - in this file)


### System init:
// session_unset();
session_start();

# CONSTANTS:
define('DEBUG',false);              # Set to true to activate system debugging
define('USEGRID',false);            # Use grid to place objects in rows / colums
define('ThousandsSep',' ');         # Used in number output
define('DecimalSep',',');           # Used in number output

$CDN_link = false;                  # Library - Link to CDN (run on-line) 
                                    # or read from /_assets/ folder (run off-line).

$part1= $_SERVER['HTTP_REFERER'] ?? '';
$part2= end(array_reverse(explode('/',trim($_SERVER['SCRIPT_NAME'],'/',))));
$gbl_ProgBase= substr($part1,strpos($part1,strlen($part2)),strpos($part1,$part2)+strlen($part2)+1);
$gbl_ProgBase= $part2.'/';
$gbl_ProgBase= ''; // echo $gbl_ProgBase;
# $gbl_ProgRoot is set in *.page.php files.

# GLOBALS:
$gbl_TblIx= -1;                     # Index for table-id to separate multible tables in one page
$gbl_ProgTitl= 'php2html';
$gbl_progVers= 'Develop'.' ';
$gbl_copyright='EV-soft';
$gbl_copydate= '2022-02-02';
$gbl_designer= 'EV-soft';
$gbl_menuLogo= $gbl_ProgBase.'_accessories/21997911.png';

$gbl_blueColor= 'lightblue';
$gbl_BodyBcgrd= 'Tan';
$gbl_iconColor= 'DarkGreen';        # Panel-header icon
$gbl_TitleColr= 'DarkGreen';        # Caption text-color in panel-head
$gbl_PanelBgrd= 'transparent';      # Panels hideble background
$gbl_GridOn= true;                  # Use grid to place objects in rows / colums
$gbl_progZoom = 'small';            # Global tag "font-scale"

if (is_null($rowHtml ?? '')) $rowHtml= '';

# PATHS:
if ($GLOBALS["gbl_ProgRoot"] ?? '') $gbl_ProgRoot= $GLOBALS["gbl_ProgRoot"]; 
else                             $gbl_ProgRoot=  './';  # $gbl_ProgRoot=   "./../";  // "../";  Relative in 1. subniveau    #-$gbl_ProgRoot= "./../../";   //  Relative in 2. subniveau
$_assets=     $gbl_ProgRoot.'_assets/';
$_base=   '';


# MENU-folders:
if (!isset($folder1)) {
    $folder1= $gbl_ProgRoot.'';
    $folder2= $gbl_ProgRoot.'./';
    $folder3= '';
    $folder4= '';
    $folder5= '';
}

if (!isset($_SESSION['proglang'])) $_SESSION['proglang']= '';

$App_Conf['language'] = $_SESSION['proglang'];
$englishOnly= false;                # Deactivate the language translate system
$gbl_novice= false;                 # Activate extended help

## System required:
// require_once ($gbl_ProgRoot.'translate.inc.php');
// require_once ($gbl_ProgRoot.'filedata.inc.php');
// Now called on demand in *.page.php files !

# CONFIGURATION:
    // if (empty($App_Conf)) $App_Conf= parse_ini_file()      read from file
    if (empty($App_Conf['language'])) $App_Conf['language'] = 'en : English';   // default language
        //else  $App_Conf['language'] = sessionStorage.getItem("proglang");
    if (empty($App_Conf['test'])) $App_Conf['test'] = 'TESTER';
// $lang = 'en';
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
function arrPrint($arr,$name='',$rtrn=false)
{  ## Output actual value of any variabeltype
    if ($name>'') $name.=': ';
    $result= "<br><textarea>".$name. print_r($arr). "</textarea><hr>\n"; // </pre>
    if (!$rtrn) echo $result;
    else return $result;
}

function arrPretty($arrVar,$titl='',$rtrn=false)
{ ## Pretty output of any variable
    //$result= "<br>".$titl."<br><pre>".print_r($arrVar, true)."</pre>";
    $result= "<div style='background: lightcyan;'>".$titl."</div><textarea rows='52' cols='160' wrap = 'off' style='padding: 10px;'>". print_r($arrVar,true)."</textarea><hr>\n"; // </pre>
    if (!$rtrn) echo $result;  else return $result;
}

function run_Script($cmdStr='') 
{
    echo "\n<script>\n".$cmdStr."\n</script>\n";
}

function set_Style($att='',$string='') 
{
    echo "\n<style ".$att.'>'.$string." </style>\n";
}

//echo '<style type="text/css"> <!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_accessories/barcode.ttf); } --> </style>';


### FUNCTIONS:

## PHP7: ordered arguments - PHP8: only needed named arguments (unordered)     
## ver 1.1.0 # PHP8:  type:'', name:'', valu:'', labl:'', hint:'', plho:'@Enter...', wdth:'', algn:'left', unit:'', disa:false, rows:'2', step:'', attr:'', list:[], llgn:'R', bord:'', rtrn:true,$form='',$ftop='');
             # PHP7: $type='',$name='',$valu='',$labl='',$hint='',$plho='@Enter...',$wdth='',$algn='left',$unit='',$disa=false,$rows='2',$step='',$attr='',$list=[],$llgn='R',$bord='',$rtrn=false,$form='',$ftop='');
## ver 1.2.0 # PHP7: $labl='',$plho= '@Enter...',$icon='',$hint='',$type= 'text',$name= '',$valu= '',$form= '',$wdth= '100%',$algn= 'left',$attr= '',$rtrn= false,$unit= '',$disa= false,$rows= '2',$step= '',$list= [],$llgn= 'R',$bord= '',$ftop= ''

function htm_Input(# $labl='',$plho='@Enter...',$icon='',$hint='',$type= 'text',$name='',$valu='',$form='',$wdth='',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='2',$step='',$list=[],$llgn='R',$bord='',$ftop='');
    $labl= '',              # Translated label above the input field
    $plho= '@Enter...',     # Translated placeholder shown when field is empty. Default: Enter...
    $icon= '',              # comming new (label prefix)
    $hint= '',              # Translated description for the field
    
    $type= 'text',          # text, date, ... Look at source !
    $name= '',              # Set the fields name (and id)
    $valu= '',              # The current content in input field
    $form= '',              # With Local form given, click on label to submit
    # subm not htm_Input()
    
    $wdth= '100%',          # Width of the field-container
    $algn= 'left',          # The alignment of input content Default: left
    # marg not htm_Input()
    # styl not htm_Input()
    $attr= '',              # Give more (special / non system) input attrib
    
    # link not htm_Input()
    # targ not htm_Input()
    # akey not htm_Input()
    # kind not htm_Input()
    $rtrn= false,           # Act as procedure: Echo result, or as function: Return string
    
    # htm_Input() only:
    $unit= '',              # A unit added to the content eg. currency or % If in front: '<' it is added as a prefix, else a suffix
    $disa= false,           # Disable the field. Default: field is active
    $rows= '2',             # Number of rows in multiline input (eg. area/html) Default: 2 (Radio/Check-list: 1 to output horisontal)
    $step= '',              # the value of stepup/stepdown for numbers
    $list= [],              # Data for subitems in "multi-list" (eg. options, checkbox, radiolist) {opti:value,label,hint,attr}
    $llgn= 'R',             # Label align Default: Right
    $bord= '',              # BoxBorder color to mark required/optional field.   Default= 'border: 1px solid var(--grayColor);'
    $ftop= ''               # Ajust field vertical position
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
    if (strpos(' '.$attr,'required')>0) $bord= 'border: 1px solid orange;';

#GRID:
    if ((USEGRID) and ($gbl_GridOn)) $result.= '<div class="grid-item">';

#FIELD:
    $result.= '<div class="inpField" id="inpBox" style="margin: auto; '.$wdth.' '.$ftop.' display: inline-block;"> ';

#INPUT:
    ($name=='') ? $inpIdNm= '' : $inpIdNm= ' id="'.$name.'" name="'.$name.'" ';
    $inpStyle= ' class="boxStyle" style="text-align: '.$algn.'; font-size: 14px; '. /* 'font-weight: normal;'.  */' width: 90%; '.$bord; //boxStyle - border: 1px solid var(--grayColor);
    $eventInvalid= ' oninvalid="this.setCustomValidity(\''.lang('@Wrong or missing data in ').$labl.' ! \')" oninput="setCustomValidity(\'\')" ';

    if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    $top= '';

    switch ($type) {
        case 'intg' : $result.= '<input type= "number" '.$inpIdNm. $attr. $inpStyle. ' step:'. $step. '" value="'.$valu.'" '. $aktiv. $plh.' />';  break;
        case 'text' : $result.= '<input type= "text" '.  $inpIdNm. $attr. $inpStyle. '" value="'. $valu.'" '. $eventInvalid. $aktiv. $plh.' />';  break;
        case 'dec0' : # Used for quantity - outputs unit as prefix or suffix
        case 'dec1' : # Used for Amount -  // SPACE as thousands separator
        case 'dec2' : $result.= '<input type= "text" '.  $inpIdNm. $attr. ' value="'.$pref. number_format((float)$valu,(int)substr($type,3,1),DecimalSep,ThousandsSep).$suff. '" '.
                        $inpStyle. '"'. $eventInvalid. $aktiv. $plh. ' pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" />';  break;
        case 'num0' :
        case 'num1' :   // thousands separator ,|. is not allowed in number !  - https://codepen.io/nfisher/pen/YYJoYE/ - SPACE will be removed
        case 'num2' :   /* lang="en" to allow "."-char as decimal separator, and national ","-char */
        case 'num3' : $result.= '<input type="number" '. $inpIdNm. $attr.' lang="en" step="'.$step.
//                            '" value="'.(float)number_format((float)$valu,(int)substr($type,3,1),DecimalSep,ThousandsSep).'" '. // FIXIT: Wrong output
                            '" value="'.$valu.'" '. 
                            $eventInvalid. $aktiv. $plh. ' pattern="(\d{3})([\.])(\d{2})"'.
                        $inpStyle. '" />';  break; // No unit but with browser type check ! 
        case 'barc' : $result.= '<input type= "text" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh.
                        $inpStyle. ' font-family:barcode; font-size:19px;'. '" />';  break;
        case 'mail' : $result.= '<input type= "email"'. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. 'pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"'.
                        $inpStyle. '" />';  break;

        case 'link' : $result.= '<input type= "url" '.  $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern='https?:/.+'. $aktiv. $plh. //'pattern="^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?"'.
                        $inpStyle. '" />';  break;

        case 'sear' : $result.= '<input type="search" '.$inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break;

        case 'file' : $result.= '<input type= "file" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break;

        case 'imag' : $result.= '<input type= "image" '.$inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. ' height: 18px;" />';  break;

        case 'date' : $result.= '<input type= "date" '. $inpIdNm. $attr. $inpStyle. ' display:inline-block;'.' min-width: 105px; '. // if empty: color: green;
                                ' margin: 5px 5px 0; padding: 8px 2px 2px 2px;" value="'.$valu. '" placeholder ="yyyy-mm-dd" '. $aktiv.' />';  break;
        case 'time' : $result.= '<input type= "time" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break;
        case 'week' : $result.= '<input type= "week" '. $inpIdNm. $attr. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv.' />';  break;
        case 'mont' : $result.= '<input type= "month" '.$inpIdNm. $attr. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv.' />';  break;

        case 'rang' : $result.= '<span class="fieldContent boxStyle range-wrap" style="height: 28px;">'.
                            '<input class="range" type= "range" '.$inpIdNm. $attr. ' value="'.$valu.'" '. $aktiv. 'onclick="setBubble('.$name.',\'bubbleDiv\')" style= "text-align: '.$algn.'; font-size: 12px; margin: 0; box-shadow: none;" /> '.
                            '<div class="bubble" id="bubbleDiv" name="bubbleDiv" 
                                  style="font-size: 10px; top: -41px; position: relative; width: 100%; text-align: center; opacity: 80%;"> '. // ' min="0" max="50"'
                                  '<span style="width: 33.33%; float:left;">'.substr($attr,1,7).' </span> <span style="width: 33.33%;"> '.$valu.'</span> <span style="width: 33.33%; float:right;">'.substr($attr,-8).'</span>
                            </div>'.
                            '</span>';  break; // FIXIT: setBubble - Output min-val-max

        case 'butt' : $result.= '<span class="fieldContent boxStyle" style="min-height: 28px;">'.
                            '<input type= "button" '.   $inpIdNm. $attr. ' value="'.$valu.'" '. $aktiv.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" /> </span>'; break; // No functionality !

        case 'colr' : $result.= ## COLOR:
                            '<span class="fieldContent boxStyle" style="height: 28px;">'.
                            '<input type= "color" '.    $inpIdNm. $attr. ' value="'.$valu.'" '. $aktiv.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px;" /> </span>'; break;

        case 'phon' : $result.= ## PHONE:
                            '<input type= "tel" '. $inpIdNm. $attr. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh. $inpStyle. '" />';  break;

        case 'pass' : $result.= ## PASSWORD:
                            '<span class="fieldContent boxStyle" style="'.$bord.' text-align: left; height: 36px;">'.
                            '<div style="white-space: nowrap;">'.
                                '<input type= "password" '. $inpIdNm. $attr. ' style="height: 8px; width: 75%; margin-top: -1px; 
                                    box-shadow: none;" value="'. $valu.'" '.$eventInvalid. $aktiv. $plh.' onkeyup="getPassword('.$name.')" 
                                 />'.
                                htm_IconButt($_labl='', $_icon='far fa-eye-slash', $_hint='@Show/Hide password (not functioning!)',
                                             $_type='button', $btnName='tgl_'.$name, $_link='',$_acti='onmousedown=\'togglePassword('.$name.','.$btnName.')\'',
                                             $_font='14px', $_fclr='Tomato', $_bclr='white', $_akey='', $_rtrn=true).
                               /*  htm_IconButt($type='button',$faicon='far fa-eye-slash',$lbl='', $Hint= lang('@Show/Hide password (not functioning!)'),$id='tgl_'.$name, // FIXIT
                                             $link='',$action='onmousedown=\'togglePassword('.'tgl_'.$name.','.$name.')\'',$akey='',$size='',
                                             $fg='lightyellow',$bg='white; padding-right:0; padding-bottom:1px; margin-top:1px',$ech=false). */
                            '</div>';   // FIXIT: togglePassword not functioning ?
                            $str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
                            $result.= '<meter id= "pwPoint'.$name.'" style="position:relative; top:-14px; height:12px; width:100%;" '.
                                          'min="0" low="6" optimum="7" high="9" max="10" id="password-strength-meter" '.
                                          'title="'.lang('@Password strength: 0..10').'">'. // $str.'"'. // ' <span id=\"mtPoint\"'.$name.'> 0</span>'. '/10"'.
                                     '</meter>'; 
                      $result.= '</span>';  break;

        case 'area' : $result.= ## TEXTAREA:
                        '<span class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 4px;"> <textarea rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="width:97%; font-size: 1em; border: 1px solid lightgray; border-radius: 4px;" '.
                        $eventInvalid. $aktiv. $plh.' '.$attr.' >'.$valu.'</textarea>'; $top=' top: -8px; ';  break;

        case 'html' : $result.= ## HTML-TEXT:
                        '<span class="fieldContent boxStyle" style="'.$bord.' top: -20px; padding: 10px 4px 4px;"> <small><div contenteditable="true" rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="background-color: white; min-height: '.($rows>'1' ? '34px;' : '5px;').' border: 1px solid lightgray; padding: 2px;" '. //  Like area, but with html-content
                        $eventInvalid. $aktiv. $plh.' data-placeholder="'.lang($plho).'" '. $attr.' >'. $valu.'</div></small>';
                        if ($disa) $result.= '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>'; $top=' top: -8px; '; break;

        case 'chck' : $result.= ## CHECKBOX:
                            '<span class="fieldContent boxStyle '.(count($list)== 1 ? 'fieldSingle' : '').'" style="'.$bord.'"><small>';
                            foreach ($list as $rec) { // $list= [['name','@Label','@ToolTip'], ['0:name',1:'@Label',2:'@ToolTip',3:state:'checked/selected'], ['@Label','@ToolTip'],...]
                                $result.= '<span style="display: inline-block">';
                                $result.= '<input type= "hidden" name="'.$rec[0]. '" value="unchecked" /><label for="'.$rec[0].'"></label>'; # Hidden field because Unchecked boxes is not included in $_POST !
                                $result.= '<input type= "checkbox" name="'.$rec[0]. '" value="checked" '.($rec[3] ?? '').' '.$valu.' style="width: 20px; box-shadow: none;"/>'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px; width: min-content">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; '.$attr).'</label>';
                                $result.= '</span>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small></span>';  break;

        case 'rado' : $result.= ## RADIO:
                            '<span class="fieldContent boxStyle" style="'.$bord.'"><small>';
                            foreach ($list as $rec) { // $list= [[0:'value',1:'Label',2:'@ToolTip',3:state:'checked/selected'], ['Label','@ToolTip'],...]
                                if ($valu==$rec[0]) $chk= ' checked '; else $chk= ' ';
                                    $result.= '<input type= "radio" id="'.$rec[0].'" name="'.$name.'" value="'.$rec[0].'" '.
                                        $chk.($rec[3] ?? ''). ' '.$attr.' style="width: 20px; box-shadow: none;">'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px;">'. Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small></span>';  break;

        case 'opti' : $result.= ## OPTION:
                            '<span class="fieldContent boxStyle"  style="'.$bord.' background-color; white; text-align: center; padding: 10px 4px 4px;"><small>';
                            $result.= '<select class="styled-select" id="'.$name.'" name="'.$name.'" '.($events ?? '') .' '.$eventInvalid.'style="width: 98%; '.($colr ?? '').'" '.$attr.' '.$aktiv.'> '; dvl_pretty();
                            $result.= '<option label="'.lang($plho).'" value="'.$valu.'">'.lang('@Select!').'</option> ';  # title="'.$hint.'"     selected="'.$valu.'"
                            foreach ($list as $rec) { # $list= [[0:value, 1:name, 2:@ToolTip, 3:state:'checked/selected', [...]]
                                $result.= '<option '. /* .'label="'.lang($rec[x]).'" '. */ 'title="'.lang($rec[2] ?? '').'" value="'.$rec[0].'" '.$state=$rec[3] ?? ''.$attr=$rec[4] ?? ''; //  Firefox does not support Label !
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
    if ($form>'') 
        $subm= '<input type="submit" value="OK" style="padding:0 0 0 2px; border-radius: 3px; width:22px; position: relative; left:-13px; color:blue;" title="Submit" />';
    $result.= ' <abbr class= "hint">'.
                ($labl>'' ? 
                   '<label for="'.$name.'" style="font-size: 12px; '.$top. '">
                        <div style="white-space: nowrap; '.$lblalign.'">'.$labl.'</div>
                   </label>'
                   : '').
                   '<data-hint style="top: 45px; left: 2px;">'.lang($hint).($unit>'' ? (' <br>'.lang('@Unit: ').$unit) : '').'</data-hint>
               </abbr>'.($subm ?? '').'
            </div>'; # :FIELD

    if ((USEGRID) and ($gbl_GridOn)) $result.= '</div>'; # :GRID
    ($form=='' ? $result.= '' : $result.= '</form>');

    if (!$rtrn) echo $result; else return $result;
} # :htm_Input()


#$labl='',$style='color:#550000; font-weight:600; font-size: 13px;',$align='',$hint='');
function htm_Caption(# $labl='',$icon='',$hint='',$algn='',$styl='color:#550000; font-weight:600; font-size: 13px;');
    $labl='',                                                  # The caption text
    $icon='',                                                  # comming new (label prefix)
    $hint='',                                                  # The hint/tooltip
    
    $algn='',                                                  # Caption Alignment
    $styl='color:#550000; font-weight:600; font-size: 13px;'   # Default Caption text style
) {
  if ($algn!='') $algn= ' text-align: '.$algn.';';
  echo '<abbr class= "hint">
            <data-colrlabl style="'.$styl.$algn.'">'.lang($labl).'</data-colrlabl>';
            if ($hint>'') echo '<data-hint> '.lang($hint).' </data-hint>';
  echo '</abbr>';
}
function htm_TextDiv(# $body,$algn='left',$marg='8px',$styl='box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',$attr='background-color: white; ');
    $body,                                                                                                         # Html-text inside div
    $algn='left',                                                                                                  # div-text alignment
    $marg='8px',                                                                                                   # div margin
    $styl='box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; white-space: nowrap; ', # Other style
    $attr='background-color: white; ' # Other style 
) {
    echo '<div style="margin: '.$marg.'; overflow-x: auto; text-align: '.$algn.'; '.$styl.$attr.'">'. lang($body). '</div>';
}
          # v1.1: $content,$align='left',$marg='8px',$attr='',$code=false,$font=''
function htm_TextPre(# $body,$algn='left',$marg='8px',$attr='',$font='',$code=false);  ## Preformatted HTML text
    $body,          # Html-text inside pre
    $algn='left',   # pre-text alignment
    $marg='8px',    # Default pre margin
    $attr='',       # Other style
    $font='',       # pre-text font
    $code=false     # convert: &lt;b&gt;bold&lt;/b&gt;
) {
    if ($code) $body= htmlspecialchars($body); // convert: &lt;b&gt;bold&lt;/b&gt;
    if ($font>0) $font= ' font-family: '.$font.'; ';
    echo '<pre style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.' white-space: pre-wrap; '.$attr.'">'. $body. '</pre>';
}
          # v1.1: $content,$align='left',$marg='8px',$attr='',$code=false,$font=''
function htm_TextVer(# $body,$algn='left',$marg='8px',$attr='',$font='',$code=false); ## Vertical text
    $body,          # Html-text inside div
    $algn='left',   # text alignment
    $marg='8px',    # Default margin
    $attr='',       # Other style
    $font='',       # text font
    $code=false     # convert: &lt;b&gt;bold&lt;/b&gt;
) {
    if ($code) $body= htmlspecialchars($body); // convert: &lt;b&gt;bold&lt;/b&gt;
    if ($font>'') $font= ' font-family: '.$font.'; ';
    echo '<div style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.' 
    position: relative; 
    transform-origin: top left; transform: rotate(-90deg) translate(-30%, 49.5%);
    margin: auto; line-height: 1.44; '.$attr.'">'. $body. '</div>';
}

function htm_MiniNote($note) # Very small text-line
{   echo '<br><small><small>'.lang($note).'</small></small>';
}
             # v1.1: #$capt='TIP',$body='',$width='',$colr='',$align='center')
function htm_TextTip(# $capt='TIP',$body='',$wdth='',$algn='center',$colr='');
    $capt='TIP',    # The output caption
    $body='',       # The output text
    $wdth='',       # The div width
    $algn='center', # The div alignment
    $colr=''        # the background-color
)
{ // A text with a caption on colored line
    if ($wdth>'') $wdth= ' width:'.$wdth.'; ';
    if ($algn=='center') $algn= ' margin: auto; ';
    else if ($algn>'') $algn= ' text-align:'.$algn.'; ';
    echo '<div style="'.$wdth. $algn.'; border:1px solid gray; ">'.
        '<div style="background-color: '.$colr.'; color: '.invertColor($colr,true).';">'.$capt. '</div>'.
        '<div style="padding: 8px; ">'.$body.'</div>'.
    '</div>';
}

function invertColor($colr,$bw) 
{ // Get max contrastcolor black or white       # Not tested
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
                 ##( PHP8: TblCapt:,RowPref:,RowBody:,RowSuff:,TblNote,,TblData:,FilterOn:,SorterOn:,CreateRec:,ModifyRec:,ViewHeight:,TblStyle:,CalledFrom:,MultiList)
function htm_Table(# PHP7: $TblCapt,$RowPref,$RowBody,$RowSuff,$TblNote,&$TblData,$FilterOn,$SorterOn,$CreateRec,$ModifyRec,$ViewHeight,$TblStyle,$CalledFrom,$MultiList)
    $TblCapt= array( # ['0:Label',   '1:Width',    '2:Type',     '3:OutFormat', '4:horJust',       '5:Tip',    '6:placeholder', '7:Content';], ...
        ),
    $RowPref= array( # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:Html'], ...
        ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) is 2% ColWidth can be used to => row-select-button
    $RowBody= array( # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:fldKey', '6:ColTip','7:placeholder','8:default','9:[selectList]'], ...
        ),           # Field 4: $FieldProporties - is composed of: [horJust, FieldBgColor, FieldStyle, TdColor, SorterON, FilterON, SelectON,
    $RowSuff= array( # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:value! '], ...
        ),
    $TblNote= '',           # HTML-string
    &$TblData,              # = array()= [{"name_0":value_0, "name_1":value_1, "name_2":value_2, "name_3":value_3, "name_4":value_4, "name_5":value_5, "name_6":value_6, "name_7":value_7, "name_8":value_8, "name_9":value_9},{...},{...}]
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
                            # Field 4: $FieldProporties - is composed of: [0:horJust, 1:FieldBgColor, 2:FieldStyle, 3:TdColor, 4:SorterON, FilterON, SelectON, ]
                            # 0:horJust - Arguments to .td: style="text-align:
                            # 1:FieldBgColor - Arguments to .td: background-color:
                            # 2:FieldStyle - complete expression, e.g.: 'font-style:italic; '
                            # 3:TdColor - like 1: but used for "row marking"
                            # 4: 5: 6: ...
                            # Only impact on Body areas.

# !  FIXIT:  Fixed/Sticky header only works on 1st table when there are several tables in the same window!
# !          Zebra streaks (Update Issue!) Failure, as well as filter problems when hidden columns are also present.
# !  FIXIT:  Change value in INPUT dont only works i 1. table on page.

{ global $gbl_blueColor, $gbl_LineBrun, $gbl_RollTabl, $gbl_HeaderFont, $gbl_IconStyle, $gbl_PanelIx, $gbl_TblIx, $gbl_rowCount, $gbl_novice, $rowHtml, $ordrTotal;
    $creaInpBg= 'LightYellow';
    $gbl_BodyBcgrd= 'yellow';
    //$selectable= (($ModifyRec) and ($RowBody[0][2]=='indx'));
    $selectable= false;
    //if (!$TblData) {msg_Info ('No data', 'The data table is empty!'); $TblData=[]; };  //  exit;
    $arrFldkey= [];
    foreach ($RowBody as $row) $arrFldkeys[]= $row[5];
    $fldNames= $arrFldkeys; # FieldNames in array created on submit. Also used to sort data fields 
    
    if (DEBUG) dvl_pretty('Start-htm_Table: '.$CalledFrom);
    if (!$selectable) $RowSelect= '';
    else    { $RowSelect= '<span class="tooltip"><span style="font-size:115%;">&#x21E8;</span>'.
                            '<span class="LblTip_text" style="bottom: -12px; left: 65px">'.lang('@Selectable: ').str_nl(1).
                            lang('@This row can be selected by clicking Id/Number in the first field of the row.').'</span></span>';
            }
    if ($FilterOn)  { $filtInit= ' filter-true '; }   else $filtInit= ' filter-false '; // filter-select
    if ($SorterOn)  { $sortInit= ' sorter-inputs '; } else $sortInit= ' sorter-false '; // General for all columns
    if (($FilterOn===true) and ($TblNote===''))
        $TblNote= '<small><small>'.lang('@Filtering: Hold mouse over the colored row below the column headers.').'</small></small>';           # HTML-string
    
    $gbl_TblIx++;          //  0..7 on a page
    $tix= 'T'.$gbl_TblIx;  //  Tabel index for flere tabeller i samme vindue

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
    echo '<span class="tableStyle" name="tblSpan" id="tblSpan" style="width:'.($width ?? '').'; padding: 8px; '.$TblStyle.' ">';
### Caption line:
    if ($TblCapt[0][0] ?? ''>'') {    dvl_pretty();    // htm_nl(1);
        if ($TblCapt) foreach ($TblCapt as $Capt) { // $Capt[x]: 0:Label 1:width 2:type 3:name 4:align 5:titletip 6:default 7:value
            $mode= '" placeholder="';
            echo ' '.lang($Capt[0]);  //  Label:  (feltPrefix)
            switch ($Capt[2]) {  # Special outputs:
                case 'show' : $mode= '" disabled value="';              break;
                case 'rows' : echo count($TblData).' '.lang($Capt[6]);  break;  //  $Capt[6]= feltSuffix
                case 'html' : echo ' '.lang($Capt[7] ?? '');                  break;
                case 'data' : echo ' <input type= "'.$Capt[2].'" name="'.$Capt[3].'" title="'.lang($Capt[5]).   //  Input-field with name
                    $mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;'; break;
                default:      echo ' <input type= "'.$Capt[2].'" title="'.lang($Capt[5]).   //  Input-field without name (not saved!)
                    $mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;';
            }
        } // foreach-TblCapt

    if ((count($TblCapt)>1) or ($Capt[1]>"40%")) htm_nl(); //  false: At narrow panel
    if ($gbl_novice==true) {
        htm_sp(5);
        if ($SorterOn)  {echo $sor= htm_IconButt($type='submit',$faicon='fas fa-sort',$id='',$labl='@Sort?',
            $Hint= lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.'),
            $link='#',$action='',$akey='','12px'); }
        if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-plus',$id='',$labl='@Filter?',
            $Hint= lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
                    lang('@Enter a search term here to display only data that matches the term.'),
            $link='#',$action='',$akey='','12px'); }
        if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-minus',$id='',$labl='@Show everything!',    //<button type="button" class="reset">lang( ' @Vis alt')</button>
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
            /* .'  <br><data-yelllabl>'.lang( '@CTRL arrow-keys').'</data-yelllabl> '.lang( ' @virker ikke. ' */
            ,$link='#',$action='',$akey='','12px'); }
    }
  } dvl_pretty();


### Table-start:
    echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$ViewHeight.'; display: block;">'; //  "Table-window": Container for tabel  display: inline ?
    echo '  <div id="overlay'.$gbl_TblIx.'"></div>';
    echo '    <table class="tablesorter" id="table'.$gbl_TblIx.'" style="width:auto; padding:1px; margin:0;">'; //  id= 'table'.$gbl_TblIx  0..6
    echo '    <thead>';
    $filter_cellFilter= []; //  [ '', 'hidden', '', 'hidden' ]
    $resizable_widths = [];
    if ($ExportTo > '') $Export= true; else $Export= false;
    if ($Export) $cvrData= '@:';  // cvrData: Used to export data in table body

### Columns-LABELS with sorting and filtering:
    echo '    <tr style="height:32px;">';
    //if ($selectable) echo  '<th> </th>';
    foreach ($RowPref as $Pref) { dvl_pretty();
        echo '<th class="filter-false sorter-false" style="width:'.$Pref[1].' align:'.$Pref[4][0].'; '.$gbl_HeaderFont.'"> '.
                Lbl_Tip($Pref[0],$Pref[5],'SO',$h='0px').' </th>';
        $resizable_widths[]= $Pref[1];
    }   $cNo= -1;
    $hiddcount= 0;
    $datCount= 0;

    if (is_array($TblData[0] ?? '')) $datCount= count($TblData[0]); else $datCount= count($TblData);
    $fldCount= count($fldNames);
    // if ($datCount!= $fldCount)  echo '<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>';
    // toast('<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>');
    
    if ($selectable) echo  '<th class="filter-false sorter-false" > </th>';
    foreach ($RowBody as $Body) { dvl_pretty();
        $colfilt= ' ';
        $resizable_widths[]= $Body[1]; # ColWidth
        if (($GLOBALS["Øshow"] ?? ''>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
        // if ($Body[9]==true) $selt= ' filter-select filter-onlyAvail'; else $selt= ' ';  //  FIXIT: sorting of datefields don’t works!
        if ($Export) $cvrData.= '"'.lang($Body[0]).'",';

        if ($Body[2]=='hidd') // FIXIT: showing filter-fields, gets columns out of syncronisation ! - $filter_cellFilter obvious don’t work: https://mottie.github.io/tablesorter/docs/#widget-filter-cellfilter
            { array_push($filter_cellFilter, 'hidden');
                $hiddcount++;
                echo '<th class="filter-false sorter-false sortPrefix" style="width:0;" ></th>'; // FIXIT: Filter-fields is showing hidden columns ! <td data-column="9" style="display:none" > fixes it
            } //  visibility:hidden;    //  columnSelector_columns : { 5 : false, 6 : false}
        else // Special behavior:
            { $cNo++; array_push($filter_cellFilter, '');
                if (($ModifyRec==true) and (in_array($Body[2],['text','data','date','osta','ddwn']) ))   # if editable:
                     { $lblsuff= str_nl().'{'.lang('@Editable').'}'; $label= $Body[0]; }
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
                if ($Body[4][3] ?? ''===false) $sort= ' sorter-false '; // '4:[horJust_etc]
                if (($Body[6] ?? '' == '@The name of file or directory') // goUp in file/folder explorers header:
                    and ($GLOBALS['goUp'] ?? '' !=''))
                    $goUp= str_WithHint(
                        $labl='<a href="'.($GLOBALS['goUp'] ?? '').'" target="_self" style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 199;">
                                <i class="fas fa-chevron-circle-left" style="color: blue; box-shadow: 3px 3px 1px lightgray;"></i></a>',
                        $hint= '@Go up to parent folder: '.end(explode('/',$GLOBALS['goUp'] ?? '')) );
                else $goUp='';
            echo '<th class="'. $filtInit. $pars. ($selt ?? ''). $sort. $colfilt.'" data-placeholder= "'.lang('@Filter...').'" style="width:'.$Body[1].'; '.
             $gbl_HeaderFont.' text-align:center;">'.$goUp.Lbl_Tip($label,($Body[6] ?? '').$lblsuff,$tipplc,$h='0px').' </th>';
        } // else (not hidd)
    } // foreach
    foreach ($RowSuff as $Suff) { dvl_pretty();
        $resizable_widths[]= $Suff[1];
        echo '<th class="filter-false sorter-false" style="width:'.$Suff[1].'; align:'.$Suff[4][0].'; '.$gbl_HeaderFont.'">'.
             Lbl_Tip($Suff[0],$Suff[5],'SW',$h='0px').'</th>';
    }
    //echo '<th>'.'</th>';
    echo '    </tr>';    dvl_pretty();
    if ($Export) $cvrData= rtrim($cvrData,',')."\n"; 
    
    // arrPrint($resizable_widths,'$resizable_widths');
    /* run_Script("widgetOptions: {
      resizable: true,
      resizable_widths = $resizable_widths
    }"); */
    set_Style('','$("#table'.$gbl_TblIx.'").tablesorter({ widgetOptions { filter_cellFilter: ["'.implode('","',$filter_cellFilter). '"]}}');   // Hide input filter fields fore hidden columns

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
            if (false) // ?? popMnu_
                $extra= 'style= "cursor: alias;" title= "'.lang('@RightClick for table-row MENU').'"';
            else $extra= 'style="display: revert;"';
            if (count($RowBody)>0)
            echo '<tr class="row" id="tabl_row'.$RowIx.'" '.$extra.'>';  //  Tablesorter with Zebra-striped background
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
                if ($ColDrop ?? ''> 0) {/* Drop Column after colspan */ $ColDrop= $ColDrop-1; $ColIx++;}
                else
                { $ColIx++;    dvl_pretty();
                    $SelectList= $Body[9] ?? [];
                    if (is_array($DataRow[$ColIx])) $valu= $DataRow[$ColIx][0];
                    else                            $valu= $DataRow[$ColIx];
                    $sortData= ' data-sort= "'. $RowIx. /*trim($valu,' '). /* */ '" ';   // Used to sort on unformatted raw data
                    if ($Export) {
                        if (strlen($valu)>550) $cvrData.= '"'.'To complex ! ('.strlen($valu).')",';
                        else $cvrData.= '"'.$valu.'",';  // Unformatted datapost
                    }

            ## Special Output formats:
                if (!($GLOBALS["Øshow"] ?? '')>0)
                    switch ($Body[3]) { # OutFormat
                        case '0d': if ($valu==null) $valu= 0;       else $valu= number_format((float)$valu, 0,',',' '); break;
                        case '1d': if ($valu==null) $valu='';       else $valu= number_format((float)$valu, 1,',',' '); break;
                        case '2d': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2,',',' '); break;  //  88 888 888,88
                        case '2%': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2).' %';    break;
                        case '>0': if (!(float)$valu>0) $valu= ' ';                     break; // 0 an less is shown as BLANK
                        case '= ': $valu= ' ';                                          break; // Values is shown as BLANK
                        case 'B': $valu= '<b>#'.sprintf("%'.05d", $valu).'</b>';        break; // Values is shown as BOLD - ContType must be 'html' Format: #00000
                        case 'R': $valu= '<font style="color:red;">'.$valu.'</font>';   break; // Values is shown in red - ContType must be 'html'
                        case 'L': $valu= '<font style="color:blue;">'.$valu.'</font>';  break; // Values is shown in blue - ContType must be 'html'
                        default: $valu= $valu;
                    }

                $flag= substr($valu,1,2);
                if (($flag=='::') or ($flag==':.')) $valu= substr($valu,2).' '; // fieldFlag is not shown. SPACE so placeholder is not shown.

            if (is_readable('customRules.inc.php')) include('customRules.inc.php');  # Here you can add your special rules 
            ## RowRules:
                if ($fldNames[0]=='pln_nmbr') { // Account Plan
                    $fieldHide= false;
                    if ($DataRow[2]=='Header')  { $rowBg=' background-color: LightSteelBlue; '; $fieldHide= true;}
                    if ($DataRow[2]=='NewPage') { $rowBg=' background-color: black; '; $fieldHide= true;}

                    if ($DataRow[2]=='SumFrom')   { $rowBg=' background-color: AntiqueWhite; opacity:70%;'; }
                    if ($DataRow[2]=='Operation') { $rowBg=' background-color: lightred; opacity:70%;'; }
                    if ($valu=='') $valu= ' '; // Hide placeholder-text
                }
                 if (($fieldHide ?? '' == true) and ($ColIx>1)) { $valu= ' '; $emptyTD= true; } else $emptyTD= false;

            ## ColRules:                                      (FieldProporties)
                if (is_string($Body[4][0] ?? ''))  $txAlign= ' style="text-align:'.($Body[4][0] ?? '').'; '; else $txAlign= '';
                if (is_string($Body[4][1] ?? ''))  $bgColor= ' background-color:'. ($Body[4][1] ?? '').'; '; else $bgColor= '';
                if (is_string($Body[4][2] ?? ''))  $fltStyl= ' '.                  ($Body[4][2] ?? '').' ' ; else $fltStyl= '';   // i.e.: 'font-style:italic; '
                if (is_string($Body[4][3] ?? ''))  $tdColor= ' background-color:'. ($Body[4][3] ?? '').'; '; else $tdColor= '';
                if (is_string($Body[4][4] ?? ''))  $txtSize= ' font-size:'.        ($Body[4][4] ?? '').'; '; else $txtSize= '';
                //  disabled ?

            ## Special conditional "row"-formats:
                if ($MultiList==['','']) $kontotype= '';

                if (is_array($DataRow))
                if ($ColIx<count($DataRow)) {  //  If colspan is there stopped here, when the row is over
                    // if ($emptyTD== true) $rowField.= '<td>'; else
                    $rowField.= '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.$bgColor.$tdColor.$txtSize.$rowBg.($colsp ?? ''); //  tablefield-property

                ## Special InputTypes in tablefields:
                if ($GLOBALS["Øshow"] ?? ''>0) $Body[2]= 'text';
                if ($emptyTD== true) $rowField.= '">'; else
                switch ($Body[2]) { # ContType
                    case 'ddwn' : $rowField.= '"'.$sortData.'>'.DropDown($name= $fldNames[$ColIx].'[]', $valu, $list= $SelectList[0], $attr= $SelectList[1].'; ');  
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
                    case 'calc' : /* if ($Body[9][3] == '2d') */ {
                                    // [1, '45-876', 2:$antal=3, 'stk', 'Redekasser', 5:$momssats=25, 6:$pris=235.50, 7:$rabat=8,  $sum=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                                  $sum= (toNum($DataRow[2])*toNum($DataRow[6]))*(100-toNum($DataRow[7]))/100*(100+toNum($DataRow[5]))/100;
                                  $rowField.= '"> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$sum, 2,',',' '). '" placeholder="'.lang($Body[7]).'"'.
                                       $txAlign.$inpBg.' width:98%; " readonly /> '; };
                                  $ordrTotal+= $sum;
                                  break;

                ### STANDARD:
                    case 'date' : if (($valu==' ') /* or ($valu==NULL) */) $clr= 'color: transparent; '; else $clr= '';  // Skjul browserens placeholder ved at angive SPACE
                                  $rowField.= '"'.$sortData.'>'.'<input type= "date" name="'.$fldNames[$ColIx].'[]" '. //  (id="'.$name.'")
                                          'style="text-align: left; /* line-height: 100%; font-size: revert; height:16px; */ max-width: 150px; z-index: auto; '.$clr. $inpBg.
                                           '" value="'.$valu. '" placeholder="yyyy-mm-dd" '.($aktiv ?? '').' />';  break; // The Browser uses its own placeholder!
                    case 'html' : $rowField.= '"'.$sortData.'>  '.$valu;  break;                                                // Only showing HTML
                    case 'htm0' : $rowField.= '"'.$sortData.'>  '.'<small><small>'.$valu.'</small></small>';  break;            // Only showing HTML
                    case 'show' : if ($valu==' ') $clr= 'color: transparent; ';                                   // Only showing data:
                                  else $clr= '';                                                                  // Hide the browsers placeholder by using a SPACE
                                  $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.$valu. '" placeholder="'.lang($Body[7] ?? '').'"'.
                                       $txAlign.$inpBg.' width:98%; '.$clr.' " readonly /> ';
                                  break;
                    case 'intg' : $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$valu, 0). //  0 dec. = Integer
                                       '" placeholder="'.lang($Body[7]).'"'.$txAlign.$inpBg.
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
                                         'value="'.htmlentities(stripslashes(lang($valu))).'" placeholder="'.lang($Body[7] ?? '').'"'.
                                         $txAlign.$inpBg.' width:98%; padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'opti' :{ $rowField.= '"'.$sortData.'><span '. 
                                        htm_Input($type='opti',$name= $fldNames[$ColIx],$valu,$labl=lang($Body[7]),$hint=lang($Body[6]),$plho= '?...',$wdth='98%',
                                        $algn='left',$unit='', $disa=false,$rows='2',$step='',$attr='',$list=$SelectList,$llgn='R',$bord='border: 1px solid lightgray;',$rtrn=true)
                                    .' </span>';
                                } // print_r($SelectList);
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
                                       ' placeholder="'.lang($Body[7] ?? '').'"'.$txAlign.$inpBg.$fltStyl.' width:98%;" /> ';  //  font-style:inherit;
                                  break;
                                }
                    default   : { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.$valu.' '.$Body[2].'" '.'placeholder="'.lang($Body[7]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%;" /> ';
                                       // toast('Invalid type: '.$Body[2].' in htm_Table() - error !','orange','black');
                                }
                    }   // :switch InputTypes
                    $rowField.= '</td>';
                }      // '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.
                if ($Body[2]!='hidd') {
                    if ($Body[0]=='@Order Date') $currDate= date('Y-m-d'); else $currDate='';
                    $newRow.= '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].';" >'. # ColWidth
                              '<input type= "text" '.$GotoEdit.' name="'.$fldNames[$ColIx].'[]" value="'.$currDate.
                              '" placeholder="'.lang($Body[7] ?? '').'"'.$txAlign.' width: 98%;  background-color: lightyellow; font-style:inherit;" /> </td>';
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
                            $btnSuff= $gbl_TblIx.'_'.$RowIx. $btnStyle;
                            if ($Suff[0]=='@Delete')  { if ($Suff[3]=='dis') $dis= 'disabled'; else $dis= '';
                                                       $output='<button type= "submit" name="btn_del_'.$btnSuff.$dis.' >'.
                                                    Lbl_Tip($Suff[6],lang('@Delete pos: ').$RowIx.' ('.$dis.')','SW','0px'). '</button>'; }   // Buttons that must not be deleted can be deactivated
                            if ($Suff[0]=='@Hide')   { $output='<button type= "submit" name="btn_hid_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Hide pos: ').$RowIx,'SW','0px'). '</button>'; }                   // Records that must not be deleted can be hidden
                            if ($Suff[0]=='@Copy')   { $output='<button type= "submit" name="btn_cpy_' .$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Copy pos: ').$RowIx,'SW','0px'). '</button>'; }
                            if ($Suff[0]=='@Rename') { $output='<button type= "submit" name="btn_ren_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Rename pos: ').$gbl_TblIx.'_'.$RowIx,'SW','0px'). '</button>'; }
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
    $_SESSION["ØrowCount"]['T'.$gbl_TblIx]= $RowIx;

    echo '</tbody>';
    echo '</table>';
    echo '</span>'; //  wrapper
    if ($Export) {  // echo '<br>'.$cvrData;
        $fp= fopen($ExportTo,"w");
        if ($fp) { fwrite($fp,$cvrData."\n"); fclose($fp); }
    }

### Init Tablesorter:
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
                resizable: true". //,   resizable_widths = $resizable_widths 
                "
            }
        });
        // https://stackoverflow.com/questions/19413025/use-tablesorter-to-filter-selected-items-in-options-list-chosen
        // if (addParser:)
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
    echo htm_AcceptButt($labl='<i class="fas fa-plus"> </i> '.lang('@Create new row'),$icon='',
                        $hint='@Create an empty row, so you can fill in data in the yellow fields ! ', 
                        $form='form_'.$gbl_PanelIx.'_'.$gbl_TblIx, $wdth='200px; min-height:16px;', 
                        $attr='', $akey='c', $kind='spc2',$rtrn=false, $tplc='LblTip_NW', 
                        $tsty='position: absolute; /* bottom: 80px; */ top: 30px; right: 100px;',
                        $acti='appendRow(table'.$gbl_TblIx.','.$newRow.')');
}
    echo '<br>'.$TblNote;
    echo '</span>'; // tableStyle
    if (DEBUG) dvl_pretty('End-htm_Table: '.$CalledFrom);
} // htm_Table


// # function htm_Fieldset_0($caption='',               $width='',$margin='',$attr='',$rtrn=false) 
                # v1.1: $caption='',$hint='',$icon='',$width='',$margin='',$attr='',$rtrn=false) 
function htm_Fieldset_0($capt='',$icon='',$hint='',$wdth='',$marg='',$attr='',$rtrn=false) # use: htm_Field_0_00() for single object!
{ // Has to be followed by htm_Fieldset_00()
    $result=  '
        <fieldset style="page-break-after: avoid; display: inline-block; box-shadow: 0 3px 3px #AAAAAA; width: '.$wdth.'; margin: '.$marg.'; border-radius: 6px; "> 
        <legend style="box-shadow: 0 0 5px #AAAAAA; '.$attr.'">'.str_WithHint($capt,$hint,$icon='').' </legend>'; // FIXIT: Problem when showing icon !
    if (!$rtrn) echo $result; 
    else return $result;
}

function htm_Fieldset_00($rtrn=false) 
{   if (!$rtrn) echo '</fieldset>
    '; 
    else return '</fieldset>
    ';
}


// Old:     function htm_Field_0_00($labl='',$hint='',$icon='',$name='fld',$html='',$width='',$margin='',$ftop='',$llgn='R',$attr='',$rtrn=false) #FIELD:
               # v.1.1: $labl='',$hint='',$icon='',$name='fld',$html='',$width='',$margin='',$ftop='',$llgn='C',$attr='',$boxstyl='',$rtrn=false
function htm_Field_0_00(# $labl='',$body='',$icon='',$hint='',$name='fld',$wdth='',$styl='',$attr='',$llgn='C',$rtrn=false,$ftop='') #FIELD:
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
    $ftop=''        # fieldtop: label y-offset
){  switch (strtoupper($llgn)) {
        case 'L': $lblalign = 'margin-right:  auto;';  break;   // Align label Left
        case 'C': $lblalign = 'margin:        auto;';  break;   // Align label Center
        case 'R': $lblalign = 'margin-left:   auto;';  break;   // Align label Right
        default : $lblalign = 'margin-left:   auto;';
    }
    $result= '<div class="inpField" id="'.$name.'" style="margin: auto; min-width: 100px; width: '.$wdth.'; top: '.$ftop.
             '; display: inline-block; box-shadow:none; '.$attr.'"> '; // float: left;
    $result.= '<div class="boxStyle" style="padding:5px; margin-top:6px; '.$styl.' ">'.$body.'</div>';
    $result.= ' <abbr class= "hint">'.
            ($labl>'' ? 
               '<label for="'.$name.'" style="font-size: 14px; '.$ftop. '">
                    <div style="white-space: nowrap; box-shadow: none; border: none;'.$lblalign.'">'.$labl.'</div>
               </label>'
               : '').
               ($hint>''? ('<data-hint style="top: 45px; left: 2px;">'.lang($hint).'</data-hint>'):'').'
           </abbr>'.($subm ?? '').'
        </div>'; # :FIELD
    if (!$rtrn) echo $result.'
    '; 
    else return $result.'
    ';
}
/* 
function htm_Field_00($rtrn=false) #FIELD:
{   $result= '</div> ';
    if (!$rtrn) echo $result.'
    '; 
    else return $result.'
    ';
}
 */
 
function htm_Row_0()
{   echo '
    <span style="display: inline-block;">';
}
function htm_Row_00()
{   echo '</span>
    ';
}

/* 
function htm_PanlHead($frmName='',$capt='',$parms='',$icon='',$class='panelWmax',$where='Undefined',$attr='',$BookMark='',$panlBg='background-color: white;',$closWidth='',$panlHint='')  // outdated
{ # START-block
    htm_Panel_0($frmName, $capt, $parms, $icon, $class, $where, $attr, $BookMark, $panlBg, $closWidth, $panlHint);
}
 */

                      # v1.1: $frmName='',$capt='',$action='',$icon='',$class='panelWmax',$where='Undefined',$attr='',$BookMark='',$panlBg='background-color: white;',$closWidth='',$panlHint='')
function htm_Panel_0( # $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'panelWmax',$wdth= '',$styl= 'background-color: white;',$attr= '',$head = '' /* ,$where='Undefined',$BookMark='' */ );
    $capt = '',                           # The panel caption
    $icon = '',                           # icon to the left of caption
    $hint = '',                           # The hint on hover caption (v1.1: panlHint)
    
    $form = '',                           # form id/name          = ? icon 
    $acti = '',                           # form action           = ? clas 
    
    $clas = 'panelWmax',                  # The panel class       = ? where
    $wdth = '',                           # The panel width when closed (v1.1: closWidth) 
    $styl = 'background-color: white;',   # The panel style (v1,1: panlBg) 
    $attr = '',                           # general attributes
    $show = true,                         # Show buttons top-right
    $head = ''                            # Style for Header background - background-color: lightyellow;
    # special:
  //  $where='Undefined',                 # DEBUG-stamp.
  //  $BookMark=''                        # Link to helpsystem
)

{ # MUST be followed of htm_Panel_00 !
    global $gbl_iconColor, $gbl_TitleColr, $gbl_PanlForm, $gbl_ProgRoot, $_assets, $gbl_PanelIx, $gbl_PanelBgrd, $gbl_GridOn;
    $gbl_PanelIx++;
    // echo 'capt:'.$capt. ' icon:'. $icon.           ' hint:'.$hint. ' form:'.$form.  ' acti:'.$acti. ' clas:'.$clas. ' wdth:'.$wdth. ' styl:'. $styl.         ' attr:'.$attr;
    //    capt            icon:About creating pages: hint:           form:fas fa-info acti:panelW480  clas:Undefined  wdth:           styl:blindAlley.page.php attr:background-color: white; where:Undefined 

    echo '<script>';  //  Hide/show Panel-Body
    echo 'function PanelSwitch'.$gbl_PanelIx.'() {
                var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
                var p = document.getElementById("panel'.$gbl_PanelIx.'");'.        // width = substr($clas,-3).'px' panelW560
                //'h.style.transition-delay = 0.8s;'.
                'if (h.style.display === "none")
                    { h.style.display = "block";     p.style.width = "";  $("table").trigger("applyWidgets");}
                    else { h.style.display = "none"; p.style.width = "'.$wdth.'"; }
                }'; //
    /* if ($show==true) */ {
        echo 'function PanelMinimize'.$gbl_PanelIx.'() {
                    var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
                    var p = document.getElementById("panel'.$gbl_PanelIx.'");
                    h.style.display = "none"; 
                    p.style.width = "'.$wdth.'";'.   // $wdth = Panel-width when it is closed
                '}';
        echo 'function PanelMaximize'.$gbl_PanelIx.'() {
                    var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
                    var p = document.getElementById("panel'.$gbl_PanelIx.'");
                    h.style.display = "block";
                '.
                '   $("table").trigger("applyWidgets");
                }'; //  $("table").trigger("applyWidgets"); Refresh the erlier hidden tablesorter objects.
        echo 'function PanelWide'.$gbl_PanelIx.'() {
                    var h = document.getElementById("HideBody'.$gbl_PanelIx.'");
                    var p = document.getElementById("panel'.$gbl_PanelIx.'");
                    const classes = p.classList;
                    if (classes.contains("panelWmax")) {
                        p.classList.remove("panelWmax");
                        p.classList.add("'.$clas.'");
                    } else {
                        p.classList.remove("'.$clas.'");
                        p.classList.add("panelWmax");'.     // $clas= "panelWmax"
                    '}'.
                '}';
            }
    echo '</script>';
    dvl_pretty('htm_Panel_0');
    $gbl_GridOn= false;
    if ($capt=='') $Ph= 'height:0px;'; else $Ph= '';

    if ($form>'') { //  Without name form will not be created, so local forms can be used !
            $gbl_PanlForm= true;
            $formCrea=  "\n\n".'<form name="'.$form.'" id="'.$form.'" action="'.$acti.'" method="POST">'."\n";
        }               //  "ParentForm" - Nestet forms is not allowed, so sub-forms has to specially handled!
    else {$gbl_PanlForm= false; $formCrea= ''; }

    if ($show==true)
    $togg= '<span style="color: var(--lablColor); top: -4px; position: relative; display:inline-block; white-space: nowrap; 
            width:12px; height:12px; margin-top:6px; margin-right:4px; float:right;"><ic class="fas fa-arrows-alt-v"></ic></span>';
//          margin-top:6px; margin-right:4px; float:right;"><ic class="fas fa-exchange-alt  fa-rotate-90"></ic></span>';
    else $togg= '';

    $prnHtml= '<ic class="'.$icon.'" style="font-size: 20px; color: '.$gbl_iconColor.';"></ic> &nbsp;'.ucfirst(lang($capt));


## PANEL-START:                                               style="margin: 0 10px 10px 0; left: -6px;
    echo '<span class="'.$clas.'" id="panel'.$gbl_PanelIx.'"  style="position: relative; vertical-align: top; margin: 1px; margin-bottom: 8px; '.$styl.' '.$attr.'"> '. $formCrea.
            '<span id="phead'.$gbl_PanelIx.'"  style="display:inline-block; width: calc(100% - 24px); text-align: left; padding: 5px; '.$head.'">'.
                '<abbr class= "hint">'.
                '<span class= "panelTitl" style="'.$Ph.' color:'.$gbl_TitleColr.'; cursor:row-resize; text-align: left; min-height:26px;"
                    onclick= PanelSwitch'.$gbl_PanelIx.'();> '.
                    $prnHtml. $togg;
    echo       '</span>'. // panelTitl
            '<data-hint>'.lang('@<b>TOGGLE:</b> Click icon or panel header-text to open / close <i>this</i> panel').' </data-hint></abbr>';  //  Panel-Header
 // if ($show==true)
    {
    if ($show==true)
    echo '<abbr class=     "hint">
            <ic class="fa-solid fa-right-left" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:col-resize; font-size: 16px; " '.
            ' onclick= PanelWide'.$gbl_PanelIx.'(); ></ic>
            <data-hint>'. lang('@<b>WIDE:</b> Click to maximize/normalize <i>this</i> panel width').'</data-hint></abbr>';
            
    if ($show==true)
    echo '<abbr class= "hint">
            <ic class="fas fa-angle-double-up" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:zoom-out; font-size: 16px; " '.
            ' onclick= PanelMinimizeAll(); ></ic>
            <data-hint>'. lang('@<b>COLLAPSE:</b> Click to close <i>all</i> panels').';" </data-hint></abbr>';
            
    if ($show==true)
    echo '<abbr class= "hint">
            <ic class="fas fa-angle-double-down" style="width:12px; height:12px; margin-top:6px; margin-right:0px; float:right; cursor:zoom-in; font-size: 16px; " '.
            ' onclick= PanelMaximizeAll(); ></ic>
            <data-hint>'. lang('@<b>EXPAND:</b> Click to open <i>all</i> panels').';" </data-hint></abbr>';
    }
    if ($hint>'') echo '<abbr class= "hint"> <i class="far fa-question-circle colrbrown" style="font-size: initial;"></i>&nbsp;<data-hint>'.lang($hint).'</data-hint></abbr>';
    echo    '</span>';   // width:100%;

    echo '<span id="HideBody'.$gbl_PanelIx.'" style="background:'.$gbl_PanelBgrd.'; transition-duration: 1s;">';   // Hide from here !
    if ($capt > '') if ($head == '') echo '<hr class="style13" style="margin: 0 6px 6px 0;"/>';
    echo '<div class="pnlContent" style="text-align: center; margin: auto; ">'; // width: min-content;">';
    return $prnHtml;
} // htm_Panel_0 - # Panelets < /Panel-span>, < /hiding> og < /form> er placeret i htm_Panel_00, som skal kaldes til slut!

                 # v1.1: $labl='', $subm=false, $hint='', $kind='save', $akey='', $simu=false, $frmName='', $attr='', $faicon=''
function htm_Panel_00( # $labl='', $icon='', $hint='', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false)
    $labl='',               # Label on the submit button
    $icon='',               # Icon left to label
    $hint='',               # Hint on hover the submit button
    
    $name='',               # The name of the button to submit
    $form='',               # The name of the form to submit
    $subm=false,            # Submit button shown and active
    
    $attr='',               # Button attributes. Generel use e.g. action= "$link"
    $akey='',               # Shortcut to activate the button
    $kind='save',           # The button appearance 
    $simu=false             # Button only simulate
)
{ # MUST follow after htm_Panel_0 and panel content !
    global $gbl_PanlForm;    dvl_pretty('htm_Panel_00 ');
    //if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    if ($hint=='') {$hint= '@Remember to save here if you changed anything above, before leaving the window.'; $kind='save';}
    echo '</div>';  $prnHtml= '</div>';  // class="pnlContent"
    if ($gbl_PanlForm)
        if ($subm==true) {
        echo '<hr class="style13" style= "height:4px;">'.
            '<span class="center" style="height:25px">';
        htm_AcceptButt($labl, $icon, $hint, $form, $wdth='', $attr, $akey, $kind,$rtrn=false, $tipplc='LblTip_text', $tipstyl='',$acti='');
        echo '</span>';
        }
    echo '</span>'; $prnHtml.= '</span>'; // HideBody to here !
    if ($gbl_PanlForm) echo "\n".'</form>'.'<!-- /'.$name.' -->'."\n\n"; //  PanelForm-end
    echo '</span>'; $prnHtml.= '</span>'; // Panel-end
    return $prnHtml;
}


// JS functions to handle Panels:
function PanelInit($panelCount) 
{ // global $panelCount;
    echo '<script>
        function PanelMinimizeAll() {';
        for ($Ix=1; $Ix<=$panelCount; $Ix++) { echo '
                var h = document.getElementById("HideBody'.$Ix.'");
                var p = document.getElementById("panel'.$Ix.'");
                h.style.display = "none"; ';
            }
        echo ' }
            function PanelMaximizeAll() {';
        for ($Ix=1; $Ix<=$panelCount; $Ix++) { echo '
                var h = document.getElementById("HideBody'.$Ix.'");
                var p = document.getElementById("panel'.$Ix.'");
                h.style.display = "block"; ';
            }
        echo ' $("table").trigger("applyWidgets"); }
            </script>';   # Reinit table "zebra": https://mottie.github.io/tablesorter/docs/example-widget-zebra.html
}

function PanelMin($ix) 
{   echo '<script> PanelMinimize'.$ix.'(); </script>';
}
function PanelMinimize($Last) 
{   echo '<script> ';
        for ($ix=0; $ix<=$Last; $ix++) echo 'PanelMinimize'.$ix.'(); ';
    echo '</script>';
}
function PanelInitRange($First,$Last)  //  Minimize an interval
{   echo '<script> ';
        for ($ix=$First; $ix<=$Last; $ix++) echo 'PanelMinimize'.$ix.'(); ';
    echo '</script>';
}
function PanelMax($ix) 
{   echo '<script> PanelMaximize'.$ix.'(); </script>';
}
function PanelOff($First,$Last)    //  Minimize an interval
{   PanelInitRange($First,$Last);
}
function PanelOn($From,$To=0)  //  Maximize a single or a interval
{   if ($To<$From) $To= $From;
    for ($ix=$From; $ix<=$To; $ix++) PanelMax($ix);
}


function htm_wrapp_0($ViewHeight='400px') # WrapperPanel
{   echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$ViewHeight.'; display: block;">'; 
}
function htm_wrapp_00() 
{   echo '</span>';
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
function RowColTest($colr) 
{   if (DEBUG) return ' style="border: 3px solid '.$colr.';"'; else return '';
}

# v1.1: function htm_RowColTop ($wdth=240) // Must be followed/ended of htm_RowColBott()
function htm_RowCol_0($wdth=240)  # ColumnTop // Must be followed/ended of htm_RowColBott()
{  dvl_pretty('htm_RowColTop');      // RowColTop RowCol240, RowCol320 (Look at CSS ! )
    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">'.
         '<data-ColnHead'.RowColTest('yellow').'> <span id="colnwrap" '.RowColTest('green').'> '.
         '<data-RowCol id="RowCol'.$wdth.'" '.RowColTest('blue').' >';
}

# v1.1: function htm_RowColNext($wdth=320) 
function htm_RowCol_next($wdth=320)  # NextColumn
{   echo '</data-RowCol> <data-RowCol id="RowCol'.$wdth.'" '.RowColTest('red').'>'; 
}

# v1.1: function htm_RowColBott() 
function htm_RowCol_00()  # ColumnBottom
{   echo '</data-RowCol> </span></data-ColnHead><span class="clearWrap" >'.
         '</div>';
}
## Importent: $RowColWdth - Only use defined width ! (See CSS: @media screen)


                # v1.1: # $labl='', $hint='', $kind='', $form='', $width='', $akey='', $rtrn=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $attr, $faicon, $idix='');
function htm_AcceptButt(# $labl='',$icon,$hint='',$form='',$wdth='',$attr,$akey='',$kind='',$rtrn=true,$tplc='LblTip_text',$tsty='',$acti='',$idix='');
    $labl='',               # The caption on the button
    $icon='',               # The iconclass ('<i class="fas fa-plus"> </i> ';)
    $hint='',               # hint about the button function
    
    $form='',               # A form Will be created, if a name is given
    
    $wdth='',               # The width of the button
    $attr='',               # Generel use e.g. ' action= "$link" '
    
    $akey='',               # Shortcut to activate the button
    $kind='',               # save, navi, goon, erase, create, home (Appearance)
    $rtrn=true,             # Act as procedure: Echo result, or as function: Return string
    
    $tplc='LblTip_text',    # Class for Placement of the tooltip
    $tsty='',               # Style for Placement of the tooltip
    $acti='',               # Function to run
    $idix=''                # ix-suffix on name/id
    )
{   global $gbl_ShortKeys;
    dvl_pretty('htm_htm_AcceptButt');
    // Colors:
    $gbl_ButtnBgrd= '#44BB44';  /* LysGrøn   */     $gbl_ButtnText= '#FFFFFF';   /* Hvid   */
    $gbl_BtLnkBgrd= 'yellow';   /* '#FCFCCC';  */   $gbl_BtLnkText= '#000000';
    $gbl_TextLight= 'white';       $gbl_TextDark= 'black';
    $gbl_BtDelBgrd= 'Crimson ';    $gbl_BtDelText= $gbl_TextLight;   # Slet:RØD
    $gbl_BtSavBgrd= '#0064b4';     $gbl_BtSavText= $gbl_TextLight;   # Gem/Submit:BLUE
    $gbl_BtNavBgrd= '#269B26';     $gbl_BtNavText= $gbl_TextLight;   # Naviger:GRØN
    $gbl_BtGooBgrd= '#66CDAA';     $gbl_BtGooText= $gbl_TextDark;    # Fortsæt:MARINE
    $gbl_BtNewBgrd= 'Orange';      $gbl_BtNewText= $gbl_TextDark;    # OpretNy:ORANGE
    $gbl_dimmed=    ' opacity:0.8;';
    // Initiate:
    if ($form) {$name= $form; $form=' form="'.$form.'" ';} 
        else {$name= '_none'; }
    if ($wdth) $wdth= ' width: '.$wdth.';';
    if ($icon==='') $iconClass=''; 
        else $iconClass= '<i class="'.$icon.'"></i>&nbsp;';
    $Label= ucfirst(lang($labl));

## Shortcuts:
    $keytip='';
    if ($gbl_ShortKeys) {
        if ($akey>'') $akey=' ´<i>'.$akey.'</i>´'; else $akey='';
        if (!$akey) $keytip=''; else $keytip= '<br><em>'.lang('@Keyboard shortcut: ').$akey.'</em>';
    }
    if (strpos($attr,'disabled')>0) $info=' Disabled ! '; else $info='';
## Appearance & name:
    switch ($kind) {
    case 'save'   : {$colors= ' background:'.$gbl_BtSavBgrd.'; color:'.$gbl_BtSavText.';'.$gbl_dimmed;}  $midn= 'sav_';  break; # Submit-Butt: BLUE
    case 'navi'   : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;}  $midn= 'nav_';  break; # navigate-Butt: GREEN
    case 'goon'   : {$colors= ' background:'.$gbl_BtGooBgrd.'; color:'.$gbl_BtGooText.';'.$gbl_dimmed;}  $midn= 'goo_';  break; # Continue-Butt-Butt: SEA ​​GREEN
    case 'eras'   : {$colors= ' background:'.$gbl_BtDelBgrd.'; color:'.$gbl_TextLight.';'.$gbl_dimmed;}  $midn= 'era_';  break; # Delete: RED
    case 'crea'   : {$colors= ' background:'.$gbl_BtNewBgrd.'; color:'.$gbl_BtNewText.';'.$gbl_dimmed;}  $midn= 'cre_';  break; # Create new: ORANGE
    case 'home'   : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;}  $midn= 'hom_';  break; # navigate-Butt: GREEN
    # Special:
    case 'get_'   : {$colors= ' background:'.'BurlyWood'.'; color:'.$gbl_TextDark .';'.$gbl_dimmed;}  $midn= 'get_';  break; # Import
    case 'put_'   : {$colors= ' background:'.'CadetBlue'.'; color:'.$gbl_TextDark .';'.$gbl_dimmed;}  $midn= 'put_';  break; # Export
    case 'spc1'   : {$colors= ' background:'.'Chocolate'.'; color:'.$gbl_TextLight.';'.$gbl_dimmed;}  $midn= 'spc1';  break; #
    case 'spc2'   : {$colors= ' background:'.'White'.    '; color:'.$gbl_TextDark .';'.$gbl_dimmed;}  $midn= 'spc2';  break; #

    default       : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;}  $midn= $labl;          # navigate-Butt: GREEN
  }
## Action:
    if ($acti=='') {$type='submit';} else {$type='button';}
## Function:
    $result=  '<span class="center" style="height:25px;">';
    $result.= '<abbr class="hint">';
    $result.= '  <button class="acceptbutt buttstyl" '.$form.' type= "'.$type.'" name="btn_'.$midn.$name.'" id="btn_'.$midn.$name.'" '.$attr.
              '    style="min-height: 24px; padding-right: 6px; '.$wdth. $colors.'" onclick=\''.$acti.'\' accesskey="'.$akey.'"> '.
                    $iconClass .$Label.
              '  </button>';
    $result.= '  <data-hint style="'.$tsty.'">'.lang($hint).$keytip.$info.'</data-hint> ';
    $result.= '</abbr> ';
    $result.= '</span>';
    if (!$rtrn) echo $result; else return $result;
} # :htm_AcceptButt()

                # v1.1: $label, $id='', $form='', $type='button', $onclick='', $icon='', $hint='', $attr='', $rtrn=true
function htm_ActionButt(# $labl,$icon='',$hint='',$type='button',$name='',$form='',$acti='',$attr='',$rtrn=true)
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
    $s1= '<abbr class= "hint">';
    $s2= '    <data-hint>'.lang($hint).'</data-hint>
            </abbr>';
    } else {$s1=''; $s2='';};
    $result= $s1. '
                <button class="buttstyl" 
                    type="'.$type.'" 
                    id="'  .$name.'" 
                    name="'.$name.'" '.
                    ($form   >'' ? ' form="'.$form.'" ' : '').
                    ($acti>'' ? ' onclick="'.$acti.'" ' : '').
                    $attr.'>
                    <i class="'.$icon.'"> </i> '.lang($labl).
               '</button>
                '.$s2;
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
} # htm_ActionButt()

               # v1.1: $type='submit',$faicon='',$labl='',$Hint='',$id='',$link='',$action='',$akey='',$size='32px',$fg='gray',$bg='white',$rtrn=false
function htm_IconButt(# $labl='',$icon='',$hint='',$type='submit',$name='',$link='',$acti='',$font='32px',$fclr='gray',$bclr='white',$akey='',$rtrn=false)
    $labl='',
    $icon='',
    $hint='',
    
    $type='submit',
    $name='',
    
    $link='',
    $acti='',
    
    $font='32px',
    $fclr='gray',
    $bclr='white',
    
    $akey='',
    $rtrn=false
    )
{   global $gbl_ButtnBgrd, $gbl_ShortKeys, $btnix;

    dvl_pretty('htm_IconButt');
    if ($gbl_ShortKeys) {
        //($akey>'') ? $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; : $keytip=''; ;
        if ($akey) $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; else $keytip='';
        if ($link=='') $targ= 'formtarget="_self"';
    }
    $btnix++;
    $result = '
    <span class="tooltip" style="display:inline; padding:0; ">
        <button class="buttstyl" type= "'.$type.'" '.($targ ?? '').' id="'.$name.'" name="btn_ico_'.$btnix.
             '" style="color:'.$fclr.'; background:'.$bclr.';" accesskey="'.$akey.'" action="'.$acti.'">'.
        '<span class="LblTip_text">'.$hint.($keytip ?? '').'</span>'.
        ' <data-ic class="'.$icon.'" style="font-size:'.$font.'; color:'.$fclr.';  '.$gbl_ButtnBgrd.'; "> </data-ic> '.
        lang($labl).
        '</button>'.
    '</span>';
    // if (($font=='32px') or ($rtrn)) echo $result;
    if (!$rtrn) echo $result;
    else return $result;
}
                 # v1.1: $label,$name='switchbox_id', $valu='', $width='', $bgColr='', $style='', $hint='', $list=[], $rtrn=false
function htm_SwitchButt(# $labl,$hint='',$name='switchbox_id',$valu='',$list=[],$wdth='',$bclr='',$rtrn=false) 
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
{   global $gbl_progZoom;                            // $valu="(un)pressed"  https://twikito.github.io/easy-toggle-state/#data-toggle-class
    $yes = lang($list[0]);
    $no  = lang($list[1]);
    if ($wdth=='') $strWd= (max(strlen($yes),strlen($no))+2).'ch';
    else           $strWd= $wdth;
    // if (($valu=='') or (!$valu=='presssed')) $presssed= 'data-toggle-class'; else  
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
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}

function htm_SwitchButton($labl,$name='switchbox_id', $valu='', $wdth='', $bclr='', $styl='', $hint='', $list=[], $rtrn=false) 
{   echo '
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
          /* width: 60px;
          height: 34px; */
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
          /* background-color: #ccc; */
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
            border-color: var(--themeColr); /* You probably need to change this! */
            box-shadow: 0 0 .25em var(--themeColr); /* You probably need to change this too! */
        }
        .switch:hover::before,
        .switch:focus::before {
            background-color: var(--themeColr); /* You probably need to change this! */
        }
        .slider:before {
            position: absolute;
            content: "";
            left: .75em;
         /* bottom: .75em; */
            width: 1em;
            height: 1em;
            left: 0.1em;
            top: 0.1em;
            background-color: white;
            /* background-color: darkgray; */
            -webkit-transition: .2s;
            transition: .2s;
        }

        input:checked + .slider {
          background-color: var(--themeColr); /* #2196F3; */
        }
        input:focus + .slider {
          box-shadow: 0 0 1px var(--themeColr); /* #2196F3; */
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
    else            $strWd= $wdth;
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
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}

                      # v1.1: $name='ROWyCOLx', $valu='', $style='style="padding:1px;"', $active=true
function htm_MultistateButt(# $name='ROWyCOLx', $valu='', $acti=true, $styl='padding:1px;') 
    $name='ROWyCOLx', 
    $valu='', 
    $acti=true,
    
    $styl='padding:1px;'
    )
{
    $Bicon= ['<i class="far fa-square colrgray"          style="'.$styl.'" ></i>',
             '<i class="far fa-minus-square colrred"     style="'.$styl.'" ></i>',
             '<i class="far fa-check-square colrorange"  style="'.$styl.'" ></i>',
             '<i class="far fa-plus-square colrgreen"    style="'.$styl.'" ></i>'
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
                if      (hidden.value == 0)   { hidden.value = 1; }
                else if (hidden.value == 1)   { hidden.value = 2; }
                else if (hidden.value == 2)   { hidden.value = 3; }
                else                          { hidden.value = 0; }
                setCheckBoxes(mButt, hidden.value);
            }
            function setCheckBoxes(mButt, value) {
                if      (value == 0) { mButt.classList.add(                 'colrgray');   mButt.innerHTML = '<p>".$Bicon[0]."</p>'; }
                else if (value == 1) { mButt.classList.replace('colrgray'  ,'colrred');    mButt.innerHTML = '<p>".$Bicon[1]."</p>'; }
                else if (value == 2) { mButt.classList.replace('colrred'   ,'colrorange'); mButt.innerHTML = '<p>".$Bicon[2]."</p>'; }
                else                 { mButt.classList.replace('colrorange','colrgreen');  mButt.innerHTML = '<p>".$Bicon[3]."</p>'; }
            }
        ");
    return $result;
}


function htm_Tabs_0($head='', $styl='', $rtrn=false)
{   $GLOBALS['TabLabl']='<div class="tab">';
    $GLOBALS['TabBody']='';
    $result= '
        <div style="'.$styl.'">'. 
            $head.
        '</div>';
   if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}
                #$name, $labl='', $body='', $bclr='white', $style='text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;') 
function htm_Tab(# $labl='',$body='',$name='',$styl='text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;',$bclr='white')
    $labl='', 
    $body='', 
    $name='', 
    $styl='text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;',
    $bclr='white'
    ) 
{   $GLOBALS['TabLabl'].= '
        <button class="tablinks" type="button" title="'.lang('@Show the Tab-content').'" onclick="openTab(event, \''.$name.'\')" style="background-color:'.$bclr.';border-bottom-color: '.$bclr.'; ">'.$labl.'</button>';
    $GLOBALS['TabBody'].= '
        <div id="'.$name.'" class="tabcontent" style="display: none; background-color:'.$bclr.'; '.$styl.' border-right: 2px solid #aaa;">'. $body.'</div>';
}
function htm_Tabs_00($foot='', $styl='', $rtrn=false) { 
    $result= 
        $GLOBALS['TabLabl'].'<span style="float:right;" title="'.lang('@Hide the Tab-content').'" onclick="closeTabs()"><i class="far fa-window-close"></i>&nbsp;<span> </div>'.
        $GLOBALS['TabBody'];
        if ($foot>'') $result.= '<span style="'.$styl.'">'.lang($foot).'</span>';
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}

               # v1.1: $labl, $gotoLink, $hint='', $target='_blank', $attr='', $rtrn=false)
function htm_LinkButt(# $labl='', $hint='', $attr='', $link='', $targ='_blank', $rtrn=false)
    $labl='', 
    $hint='', 
    
    $attr='', 
    
    $link='', 
    $targ='_blank', 
    $rtrn=false
)
{   $result= '<span '.$attr.'><a class="button" href="'.$link.'" target="'.$targ.'" title="'.lang($hint).'">'.lang($labl).'</a></span>';
    if (!$rtrn) echo $result; else return $result;
}

function htm_TextArea($labl='', $hint='', $id='area', $form='', $valu='', $rows='1', $widt='', $plho='?', $attr='', $rtrn=true) 
{
    $result= '<textarea rows= \''.$rows.'\' id= \''.$id.'\' name= \''.$id.'\' form=\''.$form.'\' placeholder= \''.lang($plho).
        '\' style= \'width:'.$widt.'; font-size: 1em; border: 1px solid lightgray; border-radius: 4px; margin-top: 10px; '.$attr.'\'>'.$valu.'</textarea>';
    if ($hint > '') 
        $result.= '<abbr class= \'hint\'>'. lang($labl).$result.'<data-hint>'.lang($hint).'</data-hint></abbr>';
    else 
        $result= lang($labl).$result;
    if (!$rtrn) echo $result; else return $result;
}

function str_WithHint($labl='',$hint='',$icon='') {
    if ($icon>'') $icon= '<i class="'.$icon.'" </i>&nbsp;'; else $icon= '';
    if ($hint>'') return '<abbr class= "hint">'.$icon.lang($labl).'<data-hint>'.lang($hint).'</data-hint></abbr>';
    else          return $icon.lang($labl);
}

// echo $htm_ModalDialog; Initiated in htm_Page_0
function htm_ModalDialog($type='none',$capt='@Voilà!',$mess='',$butt=['$type','$icon','$labl','$hint','$link'],$html='CSS-based Modal Dialog') 
{ 
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


function htm_Dialog($capt='CAPTION', $content='', $bgColor='lightyellow', $buttons= // []) # Modal dialog:
                    [['confirmBtn','default','@Confirm','fas fa-check','green','@Accept and go on'],   // (0:id, 1:value, 2:label, 3:icon, 4:hint) 
                     ['',          'cancel', '@Cancel', 'fas fa-minus-circle','red','@Break and return']])  // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog
{   $result= '<dialog id="htmDialog" style="padding:5px; background-color:lightcyan; border-radius: 6px;">
        <form method="dialog">
            <div style="background-color:'.$bgColor.'; padding:4px;">'.lang($capt).'</div>
            <p>'.lang($content).'</p>'.   //  <p><label>Favorite animal: <select> <option></option> <option>Brine shrimp</option> <option>Red panda</option> <option>Spider monkey</option> </select> </label></p>
            '<menu style="padding-inline-start: 40px; padding-inline-end: 40px;">'; 
                foreach ($buttons as $butt) {
                $iconClass= $butt[3];
                // if ($iconClass === '') $icon=''; else 
                $icon= '<ic class="'.$butt[3].'" style="font-size: 16px; color: '.$butt[4].';"></ic>&nbsp;';
                $result.= '<button id="'.$butt[0].'" value="'.$butt[1].'" title="'.lang($butt[5]).'" style="padding: 3px 5px;">'.$icon.lang($butt[2]).'</button>&nbsp;';
                }
    $result.= '</menu>
        </form>
        </dialog>
        <menu style="padding-inline-start: 40px; padding-inline-end: 40px;"> <button id="startDialog">Test Modal Dialog</button> </menu>
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
//   function msg_Dialog (   // Problemer med forskellige jquery-versioner, saboterer denne function!!!
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


//  $goon= lang('@Continue');   $close= lang('@Luk');
## Almindelige af-arter med kun 1 fortsæt-knap, samt "luk":
function msg_Error($title='Error',     $messg='Message') 
{ //  msg_Dialog('error',   lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  msg_System($MsgType= 'error', $title,  $reason='', $messg, $actions=['','goon','close']);
}
function msg_Info($title='Info',    $messg='Message') 
{
  msg_Dialog('info',    lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
}
function msg_Warn($title='Warning', $messg='Message') 
{ //  msg_Dialog('warn',    lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  $str= '<br>'.  lang($messg);
  msg_System($MsgType= 'warn', $title,  $reason=' ', $messg=$str, $actions=['','goback','close']);
}
function msg_Hint($title='Tip',     $messg='Message') 
{ //  msg_Dialog('tip',     lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  msg_System($MsgType= 'tip', $title,  $reason=$title, $messg, $actions=['','','close']);
}
function msg_Succ($title='Hurray',  $messg='Message') 
{ //  msg_Dialog('success', lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  msg_System($MsgType= 'success', $title='',  $reason='', $messg, $actions=['','','close']);
}
// Afhængig af: msg_lib.css.php   -   Afløser for msg_Dialog()
function msg_System($MsgType= 'error', $title='',  $reason='', $messg='', $actions=['goback','goon','close'], $wdh='600px', $hgt='150px') 
{ ## INIT: (Change as needed)
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
                        $pref= ucfirst(lang('@Error: '));     
                        $Capt1= '<div style="font-weight:600;">'.lang('@Tracking').':</div>';
                        $Capt2= '<div style="font-weight:600;">'.lang('@Explanation').':</div>'; 
                        break;
        case "info"   : $headColr= '#BDE5F8';    # color: blue
                        $pref= ucfirst(lang('@Info: '));                  
                        break;
        case "warn"   : $headColr= '#FEEFB3';    # color: orange
                        $pref= ' '.ucfirst(lang('@Warning: '));
                        $Capt1= '<div style="font-weight:600;">'.lang('@Oops').':</div>'; 
                        break;
        case "tip"    : $headColr= '#88ff22';    # color: green
                        $pref= ucfirst(lang('@Tip: '));   
                        $title='';                      
                        break;
        case "success": $headColr= '#DFF2BF';    # color: light-green
                        $pref= ucfirst(lang('@Hurray: '));                 
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
    if (in_array('goback',$actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Close the window and return to the previous screen').'">'.lang('@Undo').' </label>';
    if (in_array('goon',  $actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Close the message-window and continue').'">'.lang('@Continue').' </label>';
    if (in_array('accept',$actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Confirm and continue').'">'.lang('@Accept').' </label>';
    if (in_array('close', $actions)) echo '<label class="modlButt" for="open-modal" title="'.lang('@Close the window!').'">'.lang('@Close')    .' </label>';
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
} // msg_System()


//       Pmnu_Prepare:
function Pmnu_0(# elem:'id', capt:'', widt:'210px', icon:'', stck:'false', attr:'background-color:lightcyan;', cntx:true, rtrn:false) 
                 $elem='id',$capt='',$wdth='210px',$icon='',$stck='false',$attr='background-color:lightcyan;',$cntx=true,$rtrn=false) // Note: $elem is used to link to the calling element
{ // Create jsCode:
    $result= "
    <script>
    let ".$elem." = document.getElementById(\"".$elem."\"); ";
    if ($cntx == true) 
         $result.= "
        ".$elem.".addEventListener('contextmenu', 
        event => {                // Activate RightClick
        event.preventDefault();   // Deactivate LeftClick
                // INIT: ";
    else $result.= $elem.".addEventListener('click', () => { 
                // INIT: ";
    $result.= "
    new ctxP_({ // MENU:
    isSticky: ".$stck.",
    width: '".  $wdth. "',
    items: [    // ITEMS:
    ";
    if ($capt>'') $result.= '{label: "'.lang($capt).'", hint: "Just an informative Caption", cssicon: "'.$icon.'", custAttr: "'.$attr.'"}, 
        {type: "separator"},';
    
    if (!$rtrn) echo $result; else return $result;
}

//      function Pmnu_Item($type='plain',$labl='',$hint='',$icon='',$id='',$click='',$attr='',$short='',$enabl='true',$rtrn=false) 
function Pmnu_Item($labl='',$icon='',$hint='',$type='plain',$name='',$clck='',$attr='',$akey='',$enabl='true',$rtrn=false) 
{ // Create jsCode:
    $result= '
    {label: "'.lang($labl).'", hint: "'.lang($hint).'", cssIcon: "'.$icon.'"';    // or imgIcon !
        switch ($type) {
            case 'plain'    : $result.= ', shortcut: "<small>'.$akey.'</small>", id:"'.$name.'", name:"'.$name.'", onclick:"'.$clck.'" '; break;
            case 'custom'   : $result.= ', shortcut: "'.$akey.'", id:"'.$name.'", name:"'.$name.'", onclick:"'.$clck.'" '; break;
/*          case 'multi'    : this.multiButton(opts.items);   break;
            case 'normal'   : this.button
                                  (opts.label, 
                                   opts.onClick, 
                                  (opts.shortcut !== undefined ? opts.shortcut: ''), 
                                  (opts.icon     !== undefined ? opts.icon    : ''), 
                                  (opts.cssIcon  !== undefined ? opts.cssIcon : ''), 
                                  (opts.enabled  !== undefined ? opts.enabled : true));   break; */
            case 'hovermenu': $result.= ', type: "hovermenu", items: [';    break;
            case 'submenu'  : $result.= ', type: "submenu", items: [';      break;
            case 'subitem'  : $result.= ', type: "subitem", onClick: () => {'.$clck.'}},';   break;
            case 'multi'    : $result.= ', type: "multi", items: [';        break;
            case 'end_sub'  : $result = ']},';                              break;
            
            case 'separator': $result.= ', type: "separator"';  break;       // $result.= " <li class='ctxP_Js ctxP_MenuSeparator'><span></span></li>"; break;
            case 'footer'   : $result.= "";                     break;
            default         : $result.= 'Type parameter ERROR: '.$type;
        }
    if (!in_array($type,['multi','hovermenu','submenu','subitem','end_sub']))
        $result.= '},';
    
    if (!$rtrn) echo $result; else return $result;
}

function Pmnu_00($labl='',$hint='',$attr='',$rtrn=false) 
{ // Create jsCode:
    $result= '
    {' . ($attr > '' ? ('custAttr: "'.$attr.'", ') : '')
      .'label: "'. lang($labl).'", hint: "'.lang($hint). '" '
      . // 'type: "footer"'
   '}'. 
    " 
           ] // :ITEMS
        });  // :MENU
    });      // :INIT (addEventListener)
    </script>
";
    if (!$rtrn) echo $result; else return $result;
}
/* 
<script>
    let left_click = document.getElementById("left_click");   left_click.addEventListener('click', () => { 
                // INIT: 
    new ctxP_({ // MENU:
    isSticky: false,
    width: '200px',
    items: [    // ITEMS:
    {label: "<b>Popup-Menu</b>", hint: "Just an informative Caption.", cssIcon: "fas fa-info", custAttr: "background-color:lightcyan;"}, 
        {type: "separator"},
    {label: "LABEL 1", hint: "Hint 1", cssIcon: "fas fa-info", shortcut: "<small>A</small>", id:"a", name:"a", onclick:"" },
    {label: "LABEL 2", hint: "Hint 2", cssIcon: "fas fa-info", shortcut: "<small>B</small>", id:"b", name:"b", onclick:"" },
    {label: "",        hint: "",       cssIcon: "",            type: "separator"},
    {label: "CUST A",  hint: "Hint A", cssIcon: "",            shortcut: "", id:"c", name:"c", onclick:"" },
    {label: "<hr>",    type: "separator"},
    {label: "",        hint: "" } 
           ] // :ITEMS
        });  // :MENU
    });      // :INIT (addEventListener)
    </script>
/* */
 
           # v1.1:   $pageTitl='', $gbl_PageImage='',$align='center',$PgInfo='',$PgHint='',$headScript='',$pageBorder=true) 
function htm_Page_0(# titl:'', hint:'', info:'', inis:'', algn:'center', gbl_Imag:'', attr='',, gbl_Bord:true) 
    $titl='',           # Page title
    $hint='',           # Page tip  (vertical text - left)
    $info='',           # Page into (vertical text - right)
    
    $inis='',           # Initial CSS/js script in page header
    $algn='center',     # align background-image
    
    $gbl_Imag='',       # Page background-image
    $attr='',           # Page attributes
    $gbl_Bord=true      # Draw border around the page body-div
    ) 
{ # Prepare / initialize a page  # Must be followed of htm_Page_00() to finalise the page
    global $gbl_ProgRoot, $CSS_system, $gbl_TitleColr, $panelCount, $CDN_link, $gbl_Bord,$gbl_progZoom;
    $pageMess= '<b>ERROR:</b> ';
// Library_state: 0:inactive - 1:Offline (from /_assets) - 2:Online (from CDN)
// Libraryes: jQuery-latest, Dialog-polyfill, TableSorter, ContextMenu, (popMnu_) ctxP_ Menu

/* in *.page.php files PLACE THE FOLLOWING LINES:
## Handle libraryes to speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                        CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',                  'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',          'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);  // Not in use           
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);  // Not in use       
define('LIB_FONTAWESOME',   [1, '_assets/font-awesome5/5.15.4/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/']);
define('LIB_SWITCHBOX',     [0, '_assets/',  '']);  // Not in use       
define('LIB_POPUPSYSTEM',   [0, '_assets/',  '']);  // Not in use       
// Set ix= 0:deactive  1:Local-source  2:WEB-source-CDN
 */

    echo '
    <!DOCTYPE html>
    <html lang="da" dir="ltr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="Noindex, Nofollow">'.      // Reject robots
    '<title>'.lang($titl).'</title>'. "\n";  
    dvl_pretty('htm_Page_0');

### ----------------------Library-dialog-polyfill-------------------------
 //   $path= $gbl_ProgRoot.'_assets/dialog-polyfill/';      // To get Firefox and other browsers to support <dialog>
 //   echo '<script src="'.$path.'dialog-polyfill.js"></script>';
 //   echo '<link rel="stylesheet" href="'.$path.'dialog-polyfill.css"/>';
 //   run_Script("var dialog = document.querySelector('dialog');
 //               dialogPolyfill.registerDialog(dialog);    // Now dialog always acts like a native <dialog>.
 //               dialog.showModal(); ");
    
   // run_Script("function phpDialog(capt='CAPTION', content='Content') 
   //     { var result= <?= htm_Dialog(capt, content); ? > return result; }");
//        { alert(\"<?php echo htm_Dialog(capt, content); ? >\"); }");

### ----------------------Library-jQuery-------------------------
### jQuery-latest:  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js
//                ( https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js )
//                  https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js
//                  https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css
//                                          _assets/jquery/*********************************
    if (defined(LIB_JQUERY[0]) && array_key_exists(0, LIB_JQUERY))  {
            if (LIB_JQUERY[0]>0) {
                if (LIB_JQUERY[0]==1)  $path= $gbl_ProgRoot.LIB_JQUERY[LIB_JQUERY[0]];    # Local-folder
                else                   $path= LIB_JQUERY[LIB_JQUERY[0]];               # CDN-server 
            echo '<script src="'.$path.'jquery/3.6.0/jquery.js"></script>';                         //  latest // topic="Tablesorter-system" and Topmenu-system
            echo '<script src="'.$path.'jqueryui/1.12.1/jquery-ui.min.js"></script>';               // <!-- jquery Dialog -->
            echo '<link  href="'.$path.'jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" />';    //  topic="jquery Dialog"> 
        } else {
            $pageMess.= ' jQuery is not loaded  ! <br>';
        }
    } 
    else { // Old system:
        if ($CDN_link==true) {  
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';                   //  latest // topic="Tablesorter-system" and Topmenu-system
            echo '  <link rel="stylesheet" href= "https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>'; //  topic="jquery Dialog"> 
      // ?? echo '    <script src="'.$gbl_ProgRoot.'_assets/jquery-ui/1.12.1/external/jquery/jquery.js"></script>';                // <!-- jquery Dialog -->
            echo '    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>';         // <!-- jquery Dialog -->
                   // <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        }
        else {
            $path= $gbl_ProgRoot.'_assets/jquery';
            echo '<script src="'.$path.'/3/jquery-3.3.1.js"></script>';                         //  latest // topic="Tablesorter-system" and Topmenu-system
            echo '  <link rel="stylesheet" href= "'.$path.'-ui/1.12.1/jquery-ui.css"/>';        //  topic="jquery Dialog"> 
            echo '    <script src="'.$path.'-ui/1.12.1/external/jquery/jquery.js"></script>';   // <!-- jquery Dialog -->
            echo '    <script src="'.$path.'-ui/1.12.1/jquery-ui.js"></script>             ';   // <!-- jquery Dialog -->
        }
    }

### ----------------------Library-Tablesorter-------------------------
    if (defined(LIB_TABLESORTER[0]) && array_key_exists(0, LIB_TABLESORTER))  {
            if (LIB_TABLESORTER[0]>0) {
                if (LIB_TABLESORTER[0]==1)  $path= $gbl_ProgRoot.LIB_TABLESORTER[LIB_TABLESORTER[0]];    # Local-folder
                else                        $path= LIB_TABLESORTER[LIB_TABLESORTER[0]];               # CDN-server 
            echo '<script src="'.$path.'jquery.tablesorter.js"></script>';                      // topic="Tablesorter-system" - required
            echo '<script src="'.$path.'widgets/widget-cssStickyHeaders.min.js"></script>';     // topic="Tablesorter-system - parsers"
            echo '<script src="'.$path.'parsers/parser-input-select.min.js"></script>';         // topic="Tablesorter-extra"
            echo '<script src="'.$path.'jquery.tablesorter.widgets.js"></script>';
            echo '<link  href="'.$path.'css/theme.blue.css" />';                                // topic="Tablesorter-system" (choose a theme file)
        } else {
            $pageMess.= ' Tablesorter is not loaded ! <br>';
        }
    } 
    else {
//$path= './../_assets/tablesorter/';
       if ($CDN_link==true)
         $path= 'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/';
    else $path= $gbl_ProgRoot.'_assets/tablesorter/';
// Tablesorter script: required
    echo '<script src="'.$path.'js/jquery.tablesorter.js"></script>';                   // topic="Tablesorter-system"
//  echo '<script src="'.$path.'js/widgets/widget-filter.js"></script>';                // topic="Tablesorter-system"
//    echo '<script src="'.$path.'js/widgets/widget-stickyHeaders.js"></script>';       // topic="Tablesorter-system"
    echo '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.min.js"></script>';  // https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/parsers/parser-input-select.min.js
                                                                                           
    echo '<script src="'.$path.'js/parsers/parser-input-select.min.js"></script>';      // topic="Tablesorter-extra"
    echo '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>';              
    echo '<link rel="stylesheet" href="'.$path.'css/theme.blue.css"/>';                 // topic="Tablesorter-system" (choose a theme file)
    }
    
    $lateScripts= '';   // To be run before >/body>
//    echo "//    echo "

if (defined(LIB_FONTAWESOME[0]) && array_key_exists(0, LIB_FONTAWESOME) && (LIB_FONTAWESOME[0]==0) ) 
    $jsScripts = ""; else
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
     /*
     // editable_enterToAccept : true,
     // editable_validate : function(txt, orig, columnIndex, $ element) {
     //         // only allow one word
     //         var t = /\s/.test(txt) ? txt.split(/\s/)[0] : txt;
     //         return t || false;
     //     },
     // filter_columnFilters : false,
     */
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
        if (confirm("'.lang('@Insert copy as the last row, a copy of 1. row ?').'") == true) {
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
"   function togglePassword(input,butt) {
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

run_Script("
/* https://css-tricks.com/value-bubbles-for-range-inputs/ */
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
");

$popScripts= "
    <style>
        .colrred    {color: red;}
        .colrgreen  {color: green;}
        .colrblue   {color: blue;}
        .colrcyan   {color: cyan;}
        .colrbrown  {color: brown;}
        .colryellow {color: yellow;}
        .colrorange {color: orange;}
        .colrgold   {color: gold;}
        .colrblack  {color: black;}
        .colrgray   {color: gray;}

        .bgclwhite  {background-color: white;}
        .bgclgray   {background-color: gray;}
        .bgclblack  {background-color: black;}
        .bgclgold   {background-color: gold;}

        .font14     {font-size: 14px;}
        .font16     {font-size: 16px;}
        .font18     {font-size: 18px;}
        .bold       {font-weight: bold;}


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
        .synt-variable  {color: Tomato;     }
        .synt-string    {color: lightgreen; }
        .synt-attribute {color: red;        }
        .synt-comment   {color: rgb(174,174,174); }
        .synt-literal   {color: red;        }
        .synt-constant  {color: cyan;       }
        .synt-operator  {color: yellow;     }
        .synt-word      {color: blue;       }
        .synt-number    {color: lightgreen; }
        .synt-default   {color: white;  font-weight: bold; }

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
        .tab {                  /* Style the tab */
            overflow: hidden;
            background-color: #f1f1f1;
            border-top: 2px solid #aaa; 
            border-right: 2px solid #aaa;
            border-bottom: none;
            
        }
        .tab button {           /* Style the buttons inside the tab */
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
        .tab button:hover {     /* Change background color of buttons on hover */
            background-color: white;
            border-radius: 0 10px 0 0;
        }
        .tab button.active {    /* Create an active/current tablink class */
            background-color: #fff;
            border: 2px solid #aaa;
            border-radius: 0 10px 0 0;
        }
        .tabcontent {           /* Style the tab content */
            display: none;
            padding: 6px 12px;
            border: 2px solid #aaa;
            border-top: none; 
        }
    </style>


    <style>
    /* <!-- ####################################### - ctxP_.css -->  */

    /* ctxP_ = Context Popup Menu system */
    
    .ctxP_Menu{              /* Main context menu outer */
        /* font-size: 14px; */
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

    .ctxP_MenuSeparator{     /* Menu separator item */
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

    .ctxP_MenuItemOuter ,li:hover {    /* Default menu item */
        /* position: relative; */
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
        /* width:18px; */
        /* height: 18px; */
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

    .ctxP_SubMenu{           /* Submenu item */ 
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

    .ctxP_MultiItem{         /* Multi item button */
        display: flex;
        position: relative;
    }
    .ctxP_MultiItem .ctxP_MenuItemOuter{
        flex: auto;
        display: inline-block;
    }

    .ctxP_HoverMenuOuter{    /* Hover menu */
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
";  // $popScripts


// if (defined(LIB_SWITCHBOX{[0]) && array_key_exists(0, LIB_SWITCHBOX) && (LIB_SWITCHBOX[0]==0) ) 
//     $switchbox_style = ""; else
$switchbox_style= "
    <style>

    /* switchbox = Toggle switchbox system */

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
	/* text-transform: uppercase; */
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
	border-color: var(--themeColr); /* You probably need to change this! */
	box-shadow: 0 0 .25em var(--themeColr); /* You probably need to change this too! */
}
.switchbox:hover::before,
.switchbox:focus::before {
	background-color: var(--themeColr); /* You probably need to change this! */
}

.switchbox.is-pressed {
	border-color: var(--themeColr); /* You probably need to change this! */
	background-color: var(--themeColr); /* You probably need to change this too! */
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

/* Only for screen readers */
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

/* For demo */
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
    
";  // $switchbox_style


?>

<script>
/*! easy-toggle-state v1.16.0 | (c) 2020 Matthieu Bué <https://twikito.com> | MIT License | https://twikito.github.io/easy-toggle-state/ https://twikito.github.io/easy-toggle-state/#examples */
!function(){"use strict";const t=document.documentElement.getAttribute("data-easy-toggle-state-custom-prefix")||"toggle",e=(e,r=(()=>t)())=>["data",r,e].filter(Boolean).join("-"),r=e("arrows"),i=e("class"),n=e("class-on-target"),s=e("class-on-trigger"),a="is-active",o=e("escape"),u=e("event"),c=e("group"),l=e("is-active"),g=e("modal"),d=e("outside"),h=e("outside-event"),A=e("radio-group"),b=e("target"),f=e("target-all"),$=e("target-next"),v=e("target-parent"),m=e("target-previous"),E=e("target-self"),w=e("state"),p=e("trigger-off"),y=new Event("toggleAfter"),k=new Event("toggleBefore"),L=(t,e)=>{const r=t?`[${t}]`:"";if(e)return[...e.querySelectorAll(r)];const a=[`[${i}]${r}`,`[${s}]${r}`,`[${n}][${b}]${r}`,`[${n}][${f}]${r}`,`[${n}][${$}]${r}`,`[${n}][${m}]${r}`,`[${n}][${v}]${r}`,`[${n}][${E}]${r}`].join().trim();return[...document.querySelectorAll(a)]},x=(t,e)=>t.dispatchEvent(e),O=t=>"easyToggleState_"+t,S=(t,e={"aria-checked":t[O("isActive")],"aria-expanded":t[O("isActive")],"aria-hidden":!t[O("isActive")],"aria-pressed":t[O("isActive")],"aria-selected":t[O("isActive")]})=>Object.keys(e).forEach(r=>t.hasAttribute(r)&&t.setAttribute(r,e[r])),D=(t,e,r=!1)=>`This trigger has the class name '${t}' filled in both attributes '${i}' and '${e}'. As a result, this class will be toggled ${r&&"on its target(s)"} twice at the same time.`,z=(t,e)=>(t.getAttribute(e)||"").split(" ").filter(Boolean),I=t=>{const e=t.hasAttribute(c)?c:A;return L(`${e}="${t.getAttribute(e)}"`).filter(t=>t[O("isActive")])},T=(t,e)=>{t||console.warn(`You should fill the attribute '${e}' with a selector`)},q=(t,e)=>{if(0===e.length)return console.warn(`There's no match with the selector '${t}' for this trigger`),[];const r=t.match(/#\w+/gi);return r&&r.forEach(t=>{const r=[...e].filter(e=>e.id===t.slice(1));r.length>1&&console.warn(`There's ${r.length} matches with the selector '${t}' for this trigger`)}),[...e]},K=(t,e)=>e.forEach(e=>{t.classList.toggle(e)}),j={},B=t=>document.addEventListener(t.getAttribute(h)||t.getAttribute(u)||"click",Y,!1),Y=t=>{const e=t.target,r=t.type;let a=!1;L(d).filter(t=>t.getAttribute(h)===r||t.getAttribute(u)===r&&!t.hasAttribute(h)||"click"===r&&!t.hasAttribute(u)&&!t.hasAttribute(h)).forEach(t=>{const r=e.closest(`[${w}="true"]`);r&&r[O("trigger")]===t&&(a=!0),a||t===e||t.contains(e)||!t[O("isActive")]||(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)}),a||document.removeEventListener(r,Y,!1);const o=e.closest(`[${i}][${d}],[${s}][${d}],[${n}][${d}]`);o&&o[O("isActive")]&&B(e)},C=t=>M(t.currentTarget[O("target")]),H=(t,e,r)=>(t=>{if(t.hasAttribute(b)||t.hasAttribute(f)){const e=t.getAttribute(b)||t.getAttribute(f);return T(e,t.hasAttribute(b)?b:f),q(e,document.querySelectorAll(e))}if(t.hasAttribute(v)){const e=t.getAttribute(v);return T(e,v),q(e,t.parentElement.querySelectorAll(e))}if(t.hasAttribute(E)){const e=t.getAttribute(E);return T(e,E),q(e,t.querySelectorAll(e))}return t.hasAttribute(m)?q("previous",[t.previousElementSibling].filter(Boolean)):t.hasAttribute($)?q("next",[t.nextElementSibling].filter(Boolean)):[]})(t).forEach(i=>{x(i,k),i[O("isActive")]=!i[O("isActive")],S(i),r?i.classList.add(...e):K(i,e),t.hasAttribute(d)&&(i.setAttribute(w,t[O("isActive")]),i[O("trigger")]=t),t.hasAttribute(g)&&(i[O("isActive")]?(j[i]=(t=>e=>{const r=[...t.querySelectorAll("a[href], area[href], input:not([type='hidden']):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]")];if(!r.length||"Tab"!==e.key)return;const i=e.target,n=r[0],s=r[r.length-1];return-1===r.indexOf(i)?(e.preventDefault(),n.focus()):e.shiftKey&&i===n?(e.preventDefault(),s.focus()):e.shiftKey||i!==s?void 0:(e.preventDefault(),n.focus())})(i),document.addEventListener("keydown",j[i],!1)):(document.removeEventListener("keydown",j[i],!1),delete j[i])),x(i,y),((t,e)=>{const r=L(p,t).filter(e=>!e.getAttribute(p)||t.matches(e.getAttribute(p)));if(0!==r.length)e[O("isActive")]?r.forEach(t=>{t[O("target")]||(t[O("target")]=e,t.addEventListener("click",C,!1))}):(r.forEach(t=>{t[O("target")]===e&&(t[O("target")]=null,t.removeEventListener("click",C,!1))}),e.focus())})(i,t)}),M=t=>{x(t,k);const e=(t=>{if(t.hasAttribute(i)&&t.getAttribute(i)&&(t.hasAttribute(s)||t.hasAttribute(n))){const e=z(t,s),r=z(t,n);z(t,i).forEach(i=>{e.includes(i)&&console.warn(D(i,s),t),r.includes(i)&&console.warn(D(i,n,!0),t)})}const e=[i,s,n].reduce((e,r)=>{const a=z(t,r);return(r===i||r===s)&&e.trigger.push(...a),(r===i||r===n)&&e.target.push(...a),e},{trigger:[],target:[]});return!e.trigger.length&&(t.hasAttribute(i)||t.hasAttribute(s))&&e.trigger.push(a),!e.target.length&&(t.hasAttribute(i)||t.hasAttribute(n))&&e.target.push(a),e})(t);return K(t,e.trigger),t[O("isActive")]=!t[O("isActive")],S(t),x(t,y),H(t,e.target,!1),(t=>{if(t.hasAttribute(d))return t.hasAttribute(A)?console.warn(`You can't use '${d}' on a radio grouped trigger`):t[O("isActive")]?B(t):void 0})(t)},R=t=>{const e=I(t);return 0===e.length?M(t):-1===e.indexOf(t)?(e.forEach(M),M(t)):-1===e.indexOf(t)||t.hasAttribute(A)?void 0:M(t)},U=t=>((t[Symbol.iterator]?[...t]:[t]).forEach(t=>{t[O("unbind")]&&t[O("unbind")]()}),t),_=()=>{[...document.querySelectorAll(`[${n}]:not([${b}]):not([${f}]):not([${$}]):not([${m}]):not([${v}]):not([${E}])`)].forEach(t=>{console.warn(`This trigger has the attribute '${n}', but no specified target\n`,t)}),L(l).filter(t=>!t[O("isDefaultInitialized")]).forEach(t=>{if((t.hasAttribute(c)||t.hasAttribute(A))&&I(t).length>0)return console.warn(`Toggle group '${t.getAttribute(c)||t.getAttribute(A)}' must not have more than one trigger with '${l}'`);M(t),t[O("isDefaultInitialized")]=!0});const t=L().filter(t=>!t[O("isInitialized")]);return t.forEach(t=>{const e=e=>{e.preventDefault(),(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)},r=t.getAttribute(u)||"click";t.addEventListener(r,e,!1),t[O("unbind")]=()=>{t.removeEventListener(r,e,!1),t[O("isInitialized")]=!1},t[O("isInitialized")]=!0}),L(o).length>0&&!document[O("isEscapeKeyInitialized")]&&(document.addEventListener("keydown",t=>{"Escape"!==t.key&&"Esc"!==t.key||L(o).forEach(t=>{if(t[O("isActive")])return t.hasAttribute(A)?console.warn(`You can't use '${o}' on a radio grouped trigger`):(t.hasAttribute(c)?R:M)(t)})},!1),document[O("isEscapeKeyInitialized")]=!0),L(r).length>0&&!document[O("isArrowKeysInitialized")]&&(document.addEventListener("keydown",t=>{const e=document.activeElement;if(-1===["ArrowUp","ArrowDown","ArrowLeft","ArrowRight","Home","End"].indexOf(t.key)||!e.hasAttribute(i)&&!e.hasAttribute(s)&&!e.hasAttribute(n)||!e.hasAttribute(r))return;if(!e.hasAttribute(c)&&!e.hasAttribute(A))return console.warn(`You can't use '${r}' on a trigger without '${c}' or '${A}'`);t.preventDefault();const a=e.hasAttribute(c)?L(`${c}='${e.getAttribute(c)}'`):L(`${A}='${e.getAttribute(A)}'`);let o=e;switch(t.key){case"ArrowUp":case"ArrowLeft":o=a.indexOf(e)>0?a[a.indexOf(e)-1]:a[a.length-1];break;case"ArrowDown":case"ArrowRight":o=a.indexOf(e)<a.length-1?a[a.indexOf(e)+1]:a[0];break;case"Home":o=a[0];break;case"End":o=a[a.length-1]}return o.focus(),o.dispatchEvent(new Event(o.getAttribute(u)||"click"))},!1),document[O("isArrowKeysInitialized")]=!0),t},F=()=>{_(),document.removeEventListener("DOMContentLoaded",F)};document.addEventListener("DOMContentLoaded",F),window.easyToggleState=Object.assign(_,{isActive:t=>!!t[O("isActive")],unbind:U,unbindAll:()=>U(L().filter(t=>t[O("isInitialized")]))})}();
</script>


<!-- if (defined(LIB_POPUPSYSTEM[0]) && array_key_exists(0, LIB_POPUPSYSTEM) && (LIB_POPUPSYSTEM[0]==0) ) 
     $switchbox_style = ""; else -->

 <!-- Context menu system: -->
<script>
    //  <!-- ###################################### - ctxP_.js -->
    class ctxP_{
        /**
         * Creates a new ctxP_ menu
         * @param {object} opts options which build the menu e.g. position and items
         * @param {number} opts.width sets the width of the menu including children
         * @param {boolean} opts.isSticky sets how the menu apears, follow the mouse or sticky
         * @param {Array<ctxP_Item>} opts.items sets the default items in the menu
         */
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
        add(item) { /* Adds item to this ctxP_ menu instance  * @param {ctxP_Item} item item to add to the ctxP_ menu */
            this.menuControl.appendChild(item.element);
        }
        show() {    /* Makes this ctxP_ menu visible */
            event.stopPropagation()
            document.body.appendChild(this.menuControl);
            ctxP_Core.PositionMenu(this.position, event, this.menuControl);    
        }
        hide() {    /* Hides this ctxP_ menu */
            event.stopPropagation()
            ctxP_Core.CloseMenu();
        }
        toggle() {  /* Toggle visibility of menu */
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
        /**
         * @param {Object}            opts
         * @param {string}           [opts.label]
         * @param {string}           [opts.type]
         * @param {string}           [opts.markup]
         * @param {string}           [opts.icon]
         * @param {string}           [opts.cssIcon]
         * @param {string}           [opts.custAttr]
         * @param {string}           [opts.shortcut]
         * @param {string}           [opts.hint]
         * @param {void}             [opts.onClick]
         * @param {boolean}          [opts.enabled]
         * @param {Array<ctxP_Item>} [opts.items]
         */
        constructor(opts) {
            switch(opts.type) {
                case 'separator':   this.separator();               break;
                case 'custom':      this.custom(opts.markup);       break;
                case 'multi':       this.multiButton(opts.items);   break;
                case 'submenu':     this.subMenu(opts.label, opts.items, 
                                                (opts.icon     !== undefined ? opts.icon    : ''), 
                                                (opts.cssIcon  !== undefined ? opts.cssIcon : ''), 
                                                (opts.hint     !== undefined ? opts.hint    : ''),
                                                (opts.enabled  !== undefined ? opts.enabled : true));   break;
                case 'hovermenu':   this.hoverMenu(opts.label, opts.items, 
                                        (opts.icon     !== undefined ? opts.icon    : ''), 
                                        (opts.cssIcon  !== undefined ? opts.cssIcon : ''), 
                                        (opts.hint     !== undefined ? opts.hint    : ''),
                                        (opts.enabled  !== undefined ? opts.enabled : true));   break;
                case 'footer':      this.custom(opts.markup,
                                        (opts.custAttr !== undefined ? opts.custAttr: ''),
                                        (opts.shortcut !== undefined ? opts.shortcut: '')
                                        );       break;
                case 'normal':
                default:            this.button(opts.label, opts.onClick, 
                                        (opts.shortcut !== undefined ? opts.shortcut: ''), 
                                        (opts.icon     !== undefined ? opts.icon    : ''), 
                                        (opts.cssIcon  !== undefined ? opts.cssIcon : ''), 
                                        (opts.custAttr !== undefined ? opts.custAttr: ''),
                                        (opts.hint     !== undefined ? opts.hint    : ''),
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
        } /* ctxP_Item */
        
        /* <abbr class="hint">This text has a popup info <data-hint>[ *the hint contents to popup* ]</data-hint></abbr> */
        
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

/* tablesorter CSS: */
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

/* hovered row colors
 you'll need to add additional lines for
 rows with more than 2 child rows
 */
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

.tablesorter .tablesorter-filter {  /* Prevents accidental min-width of filter fields */
    width: 100%;
}
.tablesorter .tablesorter-filter-row {
    background-color: #DFF;
    height: 10px;
}
/* .tablesorter thead .disabled {display: none} */
.tablesorter .tablesorter-filter-row .disabled {
    display: none;
}

.sortPrefix {
    display: none;
}

</style> <!-- :tablesorter -->


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
// a { color: inherit; }

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

echo $switchbox_style;

//echo $inis;   // initScript: read CSS given in htm_Page_0 parameter

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

run_Script("function toast(txt, bgcolr='#333', fgcolr='#fff', timeout=5000) {
    var x = document.getElementById('snackbar');
        x.innerHTML= txt;
        x.className = 'show';
        x.style.background = bgcolr;
        x.style.color = fgcolr;
        setTimeout(function(){ x.className = x.className.replace('show', ''); }, timeout);
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
    if (defined(LIB_FONTAWESOME[0]) && array_key_exists(0, LIB_FONTAWESOME) )  {
        if (LIB_FONTAWESOME[0]>0) {
                // echo LIB_FONTAWESOME[1];
                if (LIB_FONTAWESOME[0]==1)  $path= $gbl_ProgRoot.LIB_FONTAWESOME[LIB_FONTAWESOME[0]];   # Local-folder
                else                        $path= LIB_FONTAWESOME[LIB_FONTAWESOME[0]];                 # CDN-server 
            echo '<link  href="'.$path.'css/all.min.css" rel="stylesheet" />';      // topic="fontawesome-system" (choose a theme file)
        } else {
            $pageMess.= ' Fontawesome is not loaded ! <br>';
        }
    } else {  # https://cdnjs.com/libraries/font-awesome
    // https://cdnjs.cloudflare.com/ajax/libs/font-awesome/css/all.min.css
 #   if ($CDN_link==true) $source_Ajax = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/';
 #   else $source_Ajax = $gbl_ProgRoot.'_assets/font-awesome5/';
 #   echo '<link rel="stylesheet" href="'. $source_Ajax. '5.15.4/css/all.min.css">'; // https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css
 //    https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css
 // 
    echo '<script defer src="'.$gbl_ProgRoot.'_assets/font-awesome6/js/all.js"></script>'; 
    echo '<link        href="'.$gbl_ProgRoot.'_assets/font-awesome6/css/all.css" rel="stylesheet">';
    //echo '<script defer src="'.$_assets.'font-awesome5/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.js"></script>';   //   topic= "ICON-system" version 5
    }

    $gbl_PageLogo= ($gbl_ProgBase ?? './').'_accessories/21997911.png';

    echo $CSS_system;    // Activate the system style
//  echo '<style type="text/css"> <!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_assets/fonts/barcode.ttf); } --> </style>';
    set_Style('type="text/css"', '<!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_accessories/barcode.ttf); } --> ');
    $bottLogo= ''; //'url('.$gbl_PageLogo.') right bottom/3% no-repeat,';
//  echo '<style type="text/css"> body { background: '.$bottLogo.' url('.$gbl_Imag.') left top repeat; font-family: sans-serif;} </style>'; 
    set_Style('type="text/css"', 'body { left top no-repeat; background-size: 100% 100%; font-family: sans-serif; '.$attr.' url('.$gbl_Imag.')}');
    //$PgInfo= lang('@page: Customer-ORDER');
    if ($info>'')
    //    echo '<div style="position: fixed; width: min-content; bottom: 10px; right: -'.(8.2 * min(strlen($PgInfo),33) ).'px; z-index: 99;
    //        transform-origin: bottom left; transform: rotate(-90deg); white-space: nowrap; padding: 3px; background-color:white;">'.$PgInfo.'</div>';
/*        echo '<div style="position: fixed; width: 0; bottom: 10px; right: -0.5em;; z-index: 99; 
            transform-origin: bottom left; transform: rotate(-90deg); white-space: nowrap; padding: 3px; background-color:white;">'.$PgInfo.'</div>';*/
        echo '<div style="position: fixed; z-index: 99; float: right; display: inline-block; width: max-content; right: 0;
            transform-origin: right bottom; transform: rotate(-90deg) translate(-100%, 0); white-space: nowrap; 
            padding: 2px; background-color:#ddddddbd;"><span style="font-size: 0.8em;">'.lang($info).'</span></div>';

    
    //$PgHint= 'Tip: Toggle fullscreen-mode with function key: F11';
    if ($hint>'')
        echo '<div style="position: fixed; width: min-content; bottom: -10px; left: 0px; z-index: 99;
            transform-origin: top left; transform: rotate(-90deg); white-space: nowrap; padding: 2px; background-color:#ddddddbd;" '.
            'title="CTRL-Scroll UP/Down mousewheel to zoom window content">'.
     // '<data-hint>CTRL-Scroll UP/Down mousewheel to zoom window content</data-hint>'.
            '<small>'.lang($hint).'</small></div>';
    // echo '<div class="ver_right"; style="color:red;">[[[[[[[[[HHHHH__HHHHHH]]]]]]]]]]</div>';

    echo $jsScripts;
    
    echo $popScripts;
    if ($inis>'')
        echo $inis;   // read CSS/js given in htm_Page_0 parameter

    echo "\n</head>\n
             <body>\n"; 
    if ($pageMess > '<b>ERROR:</b> ')
        echo $pageMess;
    
    if ((isset($gbl_Imag)) and ($gbl_Imag>'')) $image= 'background-image: url(\''.$gbl_Imag.'\');'; else  $image= '';
    echo '<div style="text-align: '.$algn.'; '.$image.'">';
    if ($gbl_Bord) 
        echo '<div style="border: 2px solid #AAA; border-radius: 8px; margin: 24px 4px 4px; overflow: hidden;" >';
} // htm_Page_0()



function htm_Page_00()
{ global $gbl_PanelIx, $panelCount, $gbl_ProgRoot, $popScripts, $jsScripts, $lateScripts, $gbl_Bord, $gbl_Imag;
    $panelCount= $gbl_PanelIx;
    if ($gbl_Bord) echo '</div>';
    //if ((isset($gbl_Imag)) and ($gbl_Imag>''))
    echo '</div>';  // $align - Started in htm_Page_0()
    //Menu_Bottom();
    echo '<div id="snackbar">Short message</div>';
    if (is_null($panelCount)) $panelCount= 15;
    PanelInit($panelCount);
    // echo $jsScripts;
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
    if ($lateScripts > '') run_Script($lateScripts);
    
    if (DEBUG) run_Script('header("Server-Timing: ".$Timers->getTimers()); ');
    // include('../../spormig.php');
    // include($gbl_ProgRoot.'./../spormig.php');
    htm_nl(2);
    echo "\n  </body>"; // Started in htm_Page_0()
    echo '</html><br>';
}



 if (!function_exists('Lbl_Tip'))
{ // Start: GRANULES - Group of function declearins:  Read only once !

# BASE GRANULE:
function Lbl_Tip($lbl,$tip,$plc='',$h='13px',$t='') 
{ # Label with popup-tip / info / LongLabel / details to the user, when mouseover the label.
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
function dvl_echo($testlabl='') 
{ // Debugging system - labels will be added in html-sourcecode
    if ((DEBUG) and ($testlabl>'')) {echo "<br>". $testlabl. "\n";}
}}

function calcHash($usr_name,$usr_code) 
{
    return $result= "<span style='color:red;'>'".$usr_name."' => '".password_hash($usr_code, PASSWORD_BCRYPT)."',</span>". ' '.'//'.' '.$usr_code;
}



// String-output:
function htm_Ihead($source)         {echo '<br/><i>'.$source.'</i> ';}
function htm_hr($c='#0',$attr='')   {echo '<hr style="background-color:'.$c.';'.$attr.'"/>';}
function htm_br($rept=1)            {echo str_repeat('<br />',$rept);}
function htm_nl($rept=1)            {echo str_repeat('<br />',$rept);}
function htm_lf($rept=1)            {echo str_repeat(' &#xa;',$rept);}  //  LineFeed
function htm_sp($rept=1)            {echo str_repeat('&nbsp;',$rept);}
        
function htm_space($wdt)            {echo '<span style="width:'.$wdt.'; display:block; "></span>';}


// String-funktions:
function str_bold($source,$result='',$tail='&nbsp;&nbsp;') {return $result.'<b>'.$source.'</b>'.$tail;}
function str_Ihead($source)         {return '<br /><i>'.$source.'</i> ';}
function str_hr($c='#0',$attr='')   {return '<hr style=\'color:'.$c.';'.$attr.'\'/>';}
function str_br($rept=1)            {return str_repeat('<br />',$rept);}
function str_nl($rept=1)            {return str_repeat('<br />',$rept);}
function str_lf($rept=1)            {return str_repeat(' &#xa;',$rept);}  //  LineFeed in strngs:  &#010;  &#xa;  \n \u000A  \x0A  &#13;  %10%13  %0D%0A
function str_sp($rept=1)            {return str_repeat('&nbsp;',$rept);}

function markFirstChar($str='',$tag='u',$att='') 
{ $str= lang($str); $str= '<'.$tag.' '.$att.'>'.substr($str,0,1).'</'.$tag.'>'.substr($str,1); return $str; }
function markAllChars($str='',$tag='u',$att='')  
{ $str= lang($str); $str= '<'.$tag.' '.$att.'>'.$str.'</'.$tag.'>'; return $str; }

function toNum($test='') 
{ $test= str_replace(',','.',$test); if (!is_numeric($test)) $test= 0; return $test; }

function scannSource($prefix='$name=',$suffix="'",$files=[]) 
{
    $rtrn=true;   if (!$rtrn) echo '<br>'.$prefix.' <b>';
    $result= [];    $lines = [];
    foreach ($files as $fname) $lines = $lines + file($fname);
    foreach ($lines as $aline => $line) {
        $pos1= strpos($line,$prefix);
        if (($pos1>0) and (strpos($line,'cannSource')==0)) {
            $tag= substr($line,$pos1+2+strlen($prefix));
            $len= strpos($tag,$suffix)+3;
            $str= trim(substr($line,$pos1+strlen($prefix),$len),"'");
            $result[]= $str;    ($count ?? 0)+ 1;   if (!$rtrn) echo $str.', ';
    }   }
    if (!$rtrn) { echo '</b> :COUNT: '.$count.' '.count($result).'<br>'; arrPrint($result,'result'); }
    return $result;
}

function form2arr(&$arr, $checks=[]) 
{
    $result= [];
    foreach($_POST as $key=>$val) {
        if (substr($key,0,4) != 'btn_') $result[$key]= $val;
    }
    $arr= $result;
}
function tabl2arr(&$arr,$firstId,$arrSpec=[]) 
{
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

if (!function_exists('lang')) {
    function lang($txt) 
    {                # lang() is used to translate all hard-coded program-text.
        global $lang, $transTable, $englishOnly;
        // return trim($txt,"@");

        if (!strlen($lang)) $lang = 'en';
        $transTable['en']['AppName'] = 'PHP to HTML';   // English Language:
        if (!$englishOnly)
            $allLang = sys_get_translations($transTable);
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
function sys_enc($text) 
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}


/*
 * get language translations from json file
 * @param int $transTable
 * @return array
 */
function sys_get_translations($transTable) 
{ global $gbl_ProgRoot, $lang_list;
    if (isset($_POST['alllang']))  $alllang = $_POST['alllang']; else $alllang = '';
    if ($lang_list == null)     // Prevent repeating calls
    try {
       //$content = file_get_contents('./'.'_trans.sys.json');
       $content = file_get_contents($gbl_ProgRoot.'_trans.sys.json');
        if($content !== FALSE) {
            $lng = json_decode($content, TRUE);
            foreach ($lng["language"] as $key => $value)
            if ((!$value["translation"] == null) or ($alllang == 'All'))    // Only if translation exists for that language
            {   $lang_rec["code"]        = $value["code"];                  // $value["code"];
                $lang_rec["name"]        = $value["name"];                  // $value["name"];      Name in english
                $lang_rec["native"]      = $value["native"];                // $value["native"];    Name translated from english
                $lang_rec["author"]      = $value["author"];                // $value["author"];
                $lang_rec["note"]        = $value["note"];                  // $value["note"];
                $lang_rec["DateTime"]    = $value["DateTime"];              // $value["DateTime"]; // setlocale(LC_TIME, 'da_DK','da','da_DK.utf8'); ?
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


function postValue(&$id,$varId) 
{
    if (isset($_POST[$varId]))  { $id = $_POST[$varId]; }
    else $id= 54321;    // Default init in DEMO !
    return $id;
}

function get_browser_name($user_agent) 
{ # Call: get_browser_name($_SERVER['HTTP_USER_AGENT']);
    if     (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge'))    return 'Edge';
    elseif (strpos($user_agent, 'Chrome'))  return 'Chrome';
    elseif (strpos($user_agent, 'Safari'))  return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') ||  strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    return 'Other';
}

# DropDown:HTML-string
function DropDown($name, $valu, $list ,$attr='') 
{
    dvl_pretty();
    $Result=  '<div style="margin-right:0;"> ';
    $Result.= '<select class="styled-select" id="'.$name.'" name="'.$name.
              '" style="max-width:140px; background-color:transparent; '.$attr.
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


function infoLabl($label='',$Hint='',$plac='SW') 
{
    echo Lbl_Tip($label,$Hint,$plac,$h='20px');
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

        
        /* 
        .synt-variable  {color: red;        }
        .synt-string    {color: green;      }
        .synt-attribute {color: red;        }
        .synt-comment   {color: lightgray;  }
        .synt-literal   {color: red;        }
        .synt-constant  {color: cyan;       }
        .synt-operator  {color: yellow;     }
        .synt-word      {color: blue;       }
        .synt-number    {color: lightgreen; }
        .synt-default   {color: white;      }
*/
        function str_Synt_0()  {return '<pre class="synt">';}
        function str_Synt_00() {return '</pre>';}
        function str_Synt($elem='',$type='default') { return '<span class="synt-'.$type.'">'.$elem.'</span>'; }
        
        function str_Pars($source) {
    #   htm_Fields_0(                                                   # funcName
    #                $caption='',
    #                            $width='',
    #                                      $margin='',
    #                                                 $attr=''          # funcArgu
    #                                                         ) // comm # funcTail
            $start= strpos($source,'(')+1;
            $end=  strrpos($source,');');
            $funcName= substr($source,0,$start);
            $funcTail= substr($source,$end);
            $result= str_Synt($funcName,'default');
            $funcArgu= substr($source,$start,strpos($source,');')-$start);
            // echo $funcArgu;
            $args= explode(',',$funcArgu);
            // print_r($args);
            foreach ($args as $arg) {
                $var= substr($arg,0,strpos($arg,'='));
                $val= substr(substr($arg, strrpos($arg,'=')+1),0 /* ,strrpos($arg,');') */ );
                if ($var>'')
                    $result.= '<br>    '.
                          str_Synt($elem=$var,$type='variable').
                          str_Synt($elem='= ',$type='operator').
                          str_Synt($elem=$val,$type='string').
                          str_Synt($elem=', ',$type='operator');
                
            }
            echo str_Synt_0().$result.'<br>'.str_Synt(substr($funcTail,0,2),'default').str_Synt(substr($funcTail,2),'comment').str_Synt_00();
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
    --lablBgrnd: #fffaf0;   /* FloralWhite; */
    --panelTitl: #ffffff00; /* Transparent */
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
    --PageBcgrd: <?php echo $gbl_PageBcgrd; ?>;  /* Initieres i ../_base/_base_init.php */
    /* --PageImage: url(../_assets/images/paper_fibers.png);   /* Side baggrundsbillede  */
    /* url understøttes ikke i browsere endnu! (March 29, 2016) https://blog.hospodarets.com/css_properties_in_depth  Images url like url(var(--image-url)) don’t work */
    /* --PageImage: <?php echo $gbl_Imag; ?>;  /* Initieres i _base_init.php /Virker i ../_base/htm_pagePrepare.php */
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
    
    --ButtnShad: gray;
    --HintsBgrd: Cornsilk;
    --HintsText: black;

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

    .fa, .far, .fas {
        margin-right: 6px;
    }

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
    /* padding: 0.3em 0.3em 0.4em 0.3em; /**/
    display: inline-block;
}
.panelWmax { width:  99%;   }
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
    /* font-size: 0.88em; */
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
.fieldSingle {
    padding: 2px 6px 4px;
}

.fieldStyle,
.tableStyle {
    display:inline-block;
    border-radius: 5px;
    border: 1px solid var(--FieldBord); /* border: none; */
    background-color: var(--FieldBgrd); /* background-color: transparent; */
                                        /* background-image: url(\'_accessories/_background.png\'); */
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
    top:  -5px;
    left: 0px;
    width: 94%;
    text-align: right;
}
.inpField label div {           /* The labels popup-HINT: */
    border: solid 1px var(--FieldBord);
    border-radius: 9px;
    /* 
    border-radius: 3px;
    box-shadow: 2px 2px 1px var(--ButtnShad) inset;
     */
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
    background-color: var(--panelTitl);
    // position: relative;
}
abbr.hint data-hint {
    display: none;
    position: relative;
    left: 50px;
    /* top: 35px; */
    /* bottom: 80px; */
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
/*  data-hint.style.top =  ((el.clientY + data-hint.offsetHeight) >= window.innerHeight) ?  (el.clientY - data-hint.offsetHeight)+"px"  : (el.clientY)+"px"; */
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


.btnTit { /* Titles in grid-menu top-buttons: Dont show tooltip! */
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
    background-image: url("'.$gbl_ProgRoot.'_accessories/_background.png");
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
    /* background: lightyellow; */
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

// Searc for all external called files.
// Find:
// ([\/\.\-_a-z0-9]*\.css")|([\/\.\-_a-z0-9]*\.js")|([\/\.\-_a-z0-9]*\.png")|([\/\.\-_a-z0-9]*\.ico")|([\/\.\-_a-z0-9]*\.jpg")|(src=)|(rel=)

// Now lib-file is ready for removing unused functions....
//      Search:'function'   Put 'funcName' in array
//      Search in Project-files: Mark used 'funcName' s
//      Remove unused functions in lib-file
//      Save lib-file as optimized file .opt.

// Regex: https://regexr.com/

// upgrade function call to php8 notation for named variables:
// '\$([A-z]{4})='  # Search for   '$xxxx='
// ' \1:'           # Replace with ' xxxx:'
// downgrade:
// ([ ,(])([A-z]{4})(:['[ $ft]) # xxxx:
// '\1$\2=\3'                   # $xxxx=

/*
Changelog.txt:

v1.1.0:
New:
Choose to fetch libraryes from local folder /_assets or from Web: CDN-servers
Context Popup menu system (leftclick / rightclick)

Changed:
Table - fldNames: removed
Table - RowBody: new param: fldKey

Function rename:
$Title      => $Hint
$Title      => $Capt
StartBlock  => Suffix: _0
EndBlock    => Suffix: _00
Blocks: Page, Panel, Pmnu
Menu_Branch => Menu_Item

Variable rename:
$Lang_list  => $arrLang
$more       => $attr


File rename:
_sys_trans.json => _trans.sys.json

###########
v1.2.0:
Variable rename:
$Ø* $gbl_*

Function variables renamed and changed order to standard groups
/* 
Function variables name and order:
       labl capt body plho icon hint                                                    (Visibly for the user)
               type name valu form subm acti elem                                       (HTML-Teknical)
                       clas wdth algn marg styl attr font colr fclr bclr llgn bord                (presentation)
                               link targ akey kind rtrn                                 (Navigate)
                                       code ftop unit disa rows rows step rept          (not common)
                                                        cntx  butn mess enbl clck       (special)
KeyWords for syntax highlighting:
 labl capt body plho icon hint type name valu form subm acti clas wdth algn marg styl attr font colr fclr bclr bord llgn link targ akey kind rept rtrn
(Usefull when used for PHP8+ programming)

Name:  Meening:
labl - Label
capt - Caption
body - Body (content)
plho - PlaceHolder
icon - Icon
hint - Hint (user tip)
type - Type
name - Name
valu - Value
form - Form
subm - Submit
acti - Action
clas - Class
wdth - Width
algn - Align
marg - Margin
styl - Style
attr - Attribute
font - Font
colr - Color
fclr - Foreground color
bclr - Background color
llgn - LabelAlign
link - Link
targ - Target
akey - AcessKey
kind - Kind
rept - Repeat
rtrn - Return
vhgh - ViewHeight
stck - isSticky
cntx - Context
html - String with HTML codes
capt - Caption
butt - Button
mess - Message
tplc - Class for Placement of tooltipT
tsty - Style for Placement of tooltip


Upgrade: font-awesome 5 to font-awesome 6
Created: customLib.inc.php for global user rules 
htm_Panel_0: New toggle width button

*/

?>