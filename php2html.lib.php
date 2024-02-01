<?  $DocFileLib='../php2html.lib.php';    $DocVer='1.3.2';    $DocRev='2024-01-30';      $DocIni='evs';  $ModNo=0; ## File informative only
{ ## Group ******************** System HEAD: **************************
#   PHP to HTML generator - "Clever-Html-Engine" for front-end design, with lots of advanced features.
#
#   If you program html code in php, you can use this library's routines to generate fast structured html code with many special functions.
#
#   HTML elements INPUT / CHECKBOX / RADIO-GROUP / TABLE and others, generated from PHP-functions.
#   Combined with: Label, ToolTip, Placeholder, dimensions and others.
#   Multi language translate system. 
#   Incorporated open source: Font-awesome icons.
#   Incorporated open source: HTML-editor system. TinyMCE.
#   Extended table functions (sort, filter, and much more) with jquery.tablesorter (Mottie Tablesorter-library).
#
#   Based on HTML5, CSS3, PHP7+ / PHP8+
#   Source must be UTF-8, no tabs, indent: 4 chars
/*            _____  _       _                __ _
 *           |  ___|\ \    / /               / _| |
 *           | |__   \ \  / / ___  ___  ___ | |_| |_
 *           |  __)   \ \/ / |___|( __)/ _ \|  _| __)
 *           | |____   \  /       \__ \ (_) ) | | |_
 *           |______|   \/        (___)\___/|_|  \__)
 *
 */ $©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE'; /*

    Created: 2020-02-29 evs - EV-soft
    Latest revision: see file 1. line: $DocRev
    R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
    2020-00-00 - evs  Initial
 */
} ## Group ******************** /System HEAD **************************

##### WARNING: If you edit this file, you have to do the same edit, after an update !
##### Put your modifications in custom files like: project.init.php,  customLib.inc.php (search : include, require_once - in this file)

{ ## Group ******************** System init: **************************

### System init:
// session_unset();
session_start();

# CONSTANTS:
define('DEBUG',false);              # Set to true to activate system debugging
define('ThousandsSep',' ');         # Used in number output
define('DecimalSep',',');           # Used in number output

//         ConstName:           ix:                 LocalPath:                         CDN-path:                                                              // File:
if ((isset($needJquery)) and ($needJquery>0)) {
    define('LIB_JQUERY',        [$needJquery,      '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);               // jquery.min.js
    define('LIB_JQUERYUI',      [$needJquery,      '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
}
if ((isset($needTablesorter)) and ($needTablesorter>0)) {
    define('LIB_TABLESORTER',   [$needTablesorter, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/']);
}
if ((isset($needPolyfill)) and ($needPolyfill>0)) {
    define('LIB_TABLESORTER',   [$needPolyfill,    '_assets/tablesorter/latest/',         'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/']);
}
if ((isset($needFontawesome)) and ($needFontawesome>0)) {
    define('LIB_FONTAWESOME',   [$needFontawesome, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/']);
}
if ((isset($needTinymce)) and ($needTinymce>0)) {
    define('LIB_TINYMCE',       [$needTinymce,     '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/']); 
}

// part1= $_SERVER['HTTP_REFERER'] ?? '';
// part2= end(array_reverse(explode('/',trim($_SERVER['SCRIPT_NAME'],'/',))));
// gbl_ProgBase= substr($part1,strpos($part1,strlen($part2)),strpos($part1,$part2)+strlen($part2)+1);
// gbl_ProgBase= $part2.'/';
$gbl_ProgBase= ''; // echo $gbl_ProgBase;

# GLOBALS:
if (is_readable($custFile= '../project.init.php')) include($custFile);
else {
    $gbl_TblIx= -1;                             # Index for table-id to separate multible tables in one page
    $gbl_ProgTitl= 'php2html';
    $gbl_progVers= 'Develop'.' ';
    $gbl_progDesti= 'This program is about using library PHP2HTML';
    $gbl_copyright='EV-soft';
    $gbl_designer= 'EV-soft';
    $gbl_menuLogo= $gbl_ProgBase.'_accessories/21997911.png';

    $gbl_blueColor= 'lightblue';
    $gbl_BodyBcgrd= 'Tan';
    $gbl_iconColor= 'DarkGreen';                # Card-header icon
    $gbl_TitleColr= 'DarkGreen';                # Caption text-color in card-head
    $gbl_CardsBgrd= 'background-color: white;'; # Cards hideble background
    $gbl_GridOn= true;                          # Use grid to place objects in rows / colums
    $gbl_progZoom = 'small';                    # Global tag "font-scale"
    $gbl_labelAlgn= 'R';                        # L/C/R - Align label for htm_Input() and htm_Inbox()
}
$jsScripts= '';                                 # Empty buffer

if (is_null($rowHtml ?? '')) $rowHtml= '';

# PATHS:
# $gbl_ProgRoot is set in *.page.php files. 
if ($GLOBALS["gbl_ProgRoot"] ?? '') $gbl_ProgRoot= $GLOBALS["gbl_ProgRoot"]; 
else                                $gbl_ProgRoot=  './'; # $gbl_ProgRoot=   "./../";  // "../";  Relative in 1. subniveau    #-$gbl_ProgRoot= "./../../";   //  Relative in 2. subniveau
$gbl_ProgRoot=   "./../"; 

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
$headEndScript= '';                 # Scripts to run at end of page-HEAD
$bodyEndScript= '';                 # Scripts to run at end of page-HEAD

## System required:
// require_once ($gbl_ProgRoot.'translate.inc.php');
// require_once ($gbl_ProgRoot.'filedata.inc.php');
// Now called on demand in *.page.php files !

# CONFIGURATION:
    // if (empty($App_Conf)) $App_Conf= parse_ini_file()      read from file
    if (empty($App_Conf['language'])) $App_Conf['language'] = 'en : English';   // default language
        //else  $App_Conf['language'] = sessionStorage.getItem("proglang");
    if (empty($App_Conf['test']))     $App_Conf['test'] = 'TESTER';
// $lang = 'en';
// $lang = substr($App_Conf['language'],0,2);

/* 
if (false) { # Save/Get configuration to/from file:
    FileWrite_arr($filepath='app_Conf.ini',$arrName='$App_Confxx',$list=$App_Conf);
    $App_Confxx= FileRead_arr($filepath='app_Conf.ini');    // parse_str(file_get_contents('app_Conf.ini'), $App_Confxx);
    echo "<pre>".'$App_Confxx:<br>'; print_r($App_Confxx);  echo "</pre><hr>";
    echo $App_Confxx['language'];
    echo $App_Confxx['test'];
}
 */
} ## Group ******************** /System init **************************

{ ## Group ******************** SYS-FUNCTIONS: **************************

### NORMALY DON`T EDIT IN THE FOLLOWING CODE
#   You can add special custom code in the file: $custFile= '../customLib.inc.php'
#   else place it in the top of your .page.-file where it are needed

# DEBUGGING and erly declaring:

function arrPrint($arr,$name='',$rtrn=false)  ## Output actual value of any variabeltype
{
    if ($name>'') $name.=': ';
    $result= "<br><textarea>".$name. print_r($arr). "</textarea><hr>\n"; // </pre>
    if (!$rtrn) echo $result;
    else return $result;
}

function arrPretty($arrVar,$titl='',$attr='rows="20" cols="135"',$wdth='100%',$rtrn=false)  ## Pretty output of any variable
{
    $result= "<meta charset='UTF-8'>
    <div style='background: lightcyan; width:".$wdth.";'>".$titl."</div>
              <textarea ".$attr." wrap = 'off' style='padding: 10px; width: ".$wdth."; display: block;'>".
                    print_r($arrVar,true).
              "</textarea><hr>\n"; // </pre>
    if (!$rtrn) echo $result;  else return $result;
}

function run_Script($cmdStr='') {
    echo "\n<script>\n".$cmdStr."\n</script>\n";
}

function set_Style($att='',$string='') {
    echo "\n<style ".$att.'>'.$string." </style>\n";
}

//echo '<style type="text/css"> <!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_accessories/barcode.ttf); } --> </style>';

} ## Group ******************** /SYS-FUNCTIONS **************************

{ ## Group ******************** FUNCTIONS: **************************
### FUNCTIONS:

## PHP7: ordered arguments - PHP8: only needed named arguments (unordered)     
## ver 1.1.0 # PHP8:  type:'', name:'', valu:'', labl:'', hint:'', plho:'@Enter...', wdth:'', algn:'left', unit:'', disa:false, rows:'2', step:'', attr:'', list:[], llgn:'R', bord:'', rtrn:true,$form='',$ftop='');
             # PHP7: $type='',$name='',$valu='',$labl='',$hint='',$plho='@Enter...',$wdth='',$algn='left',$unit='',$disa=false,$rows='2',$step='',$attr='',$list=[],$llgn='R',$bord='',$rtrn=false,$form='',$ftop='');
## ver 1.2.0 # PHP7: $labl='',$plho= '@Enter...',$icon='',$hint='',$type= 'text',$name= '',$valu= '',$form= '',$wdth= '100%',$algn= 'left',$attr= '',$rtrn= false,$unit= '',$disa= false,$rows= '2',$step= '',$list= [],$llgn= 'R',$bord= '',$ftop= ''

function htm_Input(# labl:'',plho:'@Enter...',icon:'',hint:'',vrnt: 'text',name:'',valu:'',form:'',wdth:'100%',algn:'left',attr:'',rtrn:false,unit:'',disa:false,rows:'2',step:'',list:[],llgn:'R',bord:'',ftop:'');

    # Generel order:
    $labl= '',              # string: Translated label above the input field
    $plho= '@Enter...',     # string: Translated placeholder shown when field is empty. Default: Enter...
    $icon= '',              # string: The icon left of the label (label prefix)
    $hint= '',              # string: Translated description for the field
    
    $vrnt= 'text',          # string: Input Variant - text, date, ... Look at source !
    $name= '',              # string: Set the fields name (and id)
    $valu= '',              # string: The current content in input field
    $form= '',              # string: With Local form given, click on showed OK-butt to submit
    
    $wdth= '100%',          # string: Width of the field-container
    $algn= 'left',          # string: The alignment of input content Default: left
    $attr= '',              # string: Give more (special / non system) input attrib to the input (height priority)
    $rtrn= false,           # bool:   Act as procedure: Echo result, or as function: Return string
    
    # htm_Input() only:
    $unit= '',              # string: A unit added to the content eg. currency or % If in front: '<' it is added as a prefix, else a suffix
    $disa= false,           # bool:   Disable the field. Default: field is active
    $rows= '2',             # string: Number of rows in multiline input (eg. area/html) Default: 2 (Radio/Check-list: 1 to output horisontal)
    $step= '',              # string: the value of stepup/stepdown for numbers
    
    $list= [],              # array:  Data for subitems in "multi-list" (eg. options, checkbox, radiolist) {opti:value,label,hint,attr}
    $llgn= 'R',             # string: Label align Default: Right
    $bord= '',              # string: BoxBorder color to mark required/optional field.   Default= 'border: 1px solid var(--grayColor);'
    $ftop= '',              # string: Ajust field vertical position
    $lpos= ''               # string: style rel. Label offset (chck)
    ) {
    global $gbl_GridOn, $gbl_iconColor, $gbl_labelAlgn;
    if (($llgn == '') and ($gbl_labelAlgn >'')) $llgn= $gbl_labelAlgn;
    ($form=='' ? $result= '' : $result= '<form name= "'.$form.'" style="display:inline;">');
    if ($form>'') $subm= '<input type="submit" value="OK" style="padding:0 0 0 2px; border-radius: 3px; width:22px; position: relative; color:blue;" title="Submit" />';
    if ($wdth>'') $wdth= ' width: '.$wdth.'; '; else $wdth='';
    if ($ftop>'') $ftop= ' top: '.$ftop.'; '; else $ftop='';
    // if ($hint=='') $hint= '@There is no explanation !';
    $hint= lang($hint);
    $labl= lang($labl);
    if ($icon>'') $icon= '<ic class="'.$icon.'" style="color: '.$gbl_iconColor.'; margin: 0 5px;"></ic>&nbsp;'; else $icon= '';
    ($plho=='' ? $plh='' : $plh=' placeholder="'.lang($plho).'" '); // .'<span style="font-weight:300;">'.lang($plho).'</span>" ');
    if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
    if (strpos(' '.$attr,'required')>0) $bord.= 'border: 1px solid orange;';
    if (/* ($vrnt=='date') and */ ($valu=='')) $dataStyle= 'font-weight: 200; color:var(--grenColr1);'; else $dataStyle='font-weight: 600; ';

# htm_Input: FIELD:
    $result.= '<div class="inpField" id="inpBox" style="margin: auto; padding: 0 2px 6px; '.$wdth.' '.$ftop.' display: inline-block; vertical-align: top;"> ';

# htm_Input: INPUT:
    ($name=='') ? $inpIdNm= ' id="missing" name="missing" ' 
                : $inpIdNm= ' id="'.$name.'" name="'.$name.'" ';
    $inpStyle= ' class="boxStyle" style="text-align: '.$algn.'; font-size: 14px; '. $dataStyle. $bord; //boxStyle - border: 1px solid var(--grayColor);
    $eventInvalid= ' oninvalid="this.setCustomValidity(\''.lang('@Wrong or missing data in ').$labl.' ! \')" oninput="setCustomValidity(\'\')" ';
    $pattern= '';

    if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    $top= '';
    $just= ''; 

    switch ($vrnt) { ## VARIANTS:
        case 'intg' : $result.= '<input type= "number" '.$inpIdNm. $inpStyle. ' step:'. $step. '" value="'.$valu.'" '. $aktiv. $plh. $attr.' />';  break;
        case 'text' : $result.= '<input type= "text" '.  $inpIdNm. $inpStyle. '" value="'. $valu.'" '. $eventInvalid. $aktiv. $plh. $attr.' />';  break;
        case 'dec0' : # Used for quantity - outputs unit as prefix or suffix
        case 'dec1' : # Used for Amount -  // SPACE as thousands separator
        case 'dec2' : $result.= '<input type= "text" '.  $inpIdNm. ' value="'.$pref. number_format((float)$valu,(int)substr($vrnt,3,1),DecimalSep,ThousandsSep).$suff. '" '.
                        $inpStyle. '"'. $eventInvalid. $aktiv. $plh. $attr. $pattern=' pattern="^[$\-\s]*[\d,]*?([.]\d{0,2})?\s$" />';  break;
        case 'num0' : 
        case 'num1' :   // thousands separator ,|. is not allowed in number !  - https://codepen.io/nfisher/pen/YYJoYE/ - SPACE will be removed
        case 'num2' :   /* lang="en" to allow "."-char as decimal separator, and national ","-char */
        case 'num3' : $result.= '<input type="text" '. $inpIdNm. ' lang="en" step="'.$step.
                            '" value="'.$pref.number_format((float)$valu,(int)substr($vrnt,3,1),DecimalSep,ThousandsSep).$suff.'" '. // FIXIT: Wrong output
                            //'" value="'.$valu.'" '. 
                            $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" '.$pattern=' pattern="(\d{3})([\.])(\d{2})"'. ' />';  break; // No unit but with browser type check ! 
              ## Number values accepted by input-validation, has to be cleaned 
              ## for SPACE '%' and currency symbols (prefix/suffix), before saved in DB !
              ## Also check the decimal separator.
        case 'barc' : $result.= '<input type= "text" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. ' font-family:barcode; font-size:19px; font-weight:normal; '. '" />';  break;
        /* case 'qrcd' : $result.= '<input type= "text" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr.  // 2D QR code
                        $inpStyle. ' font-family:barcode; font-size:19px; font-weight:normal; '. '" />';  break; */
        case 'mail' : $result.= '<input type= "email"'. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" '.$pattern='pattern="^[a-zA-Z0-9.!#$%&]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"'. ' />';  break;       // (?i)\b[A-Z0-9._%+-]              +@(?:[A-Z0-9-]+   \.)+[A-Z]{2,6}\b
        case 'link' : $result.= '<input type= "url" '.  $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        //'pattern="^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?"'.
                        $inpStyle. '" '.$pattern='https?:/.+'. ' />';  break;

        case 'sear' : $result.= '<input type="search" '.$inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" />';  break;

        case 'file' : $result.= '<input type= "file" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle.$dataStyle. '" />';  break;

        case 'imag' : $result.= '<input type= "image" '.$inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr.
                        $inpStyle. ' height: 18px;" />';  break;

        case 'date' : $result.= '<input type= "date" '. $inpIdNm. $inpStyle. ' display:inline-block;'.' min-width: 105px; '. // if empty: color: green;
                                ' margin: 5px 5px 0; padding: 8px 2px 2px 2px;" value="'.$valu. '" placeholder ="yyyy-mm-dd" '. $aktiv. $attr. ' />';  break;
        case 'time' : $result.= '<input type= "time" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" />';  break;
        case 'week' : $result.= '<input type= "week" '. $inpIdNm. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv. $attr.' />';  break;
        case 'mont' : $result.= '<input type= "month" '.$inpIdNm. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv. $attr.' />';  break;

        case 'rang' : $result.= '<span class="fieldContent boxStyle range-wrap" style="height: 32px; ">'.
                                '<input class="range" type= "range" '.$inpIdNm. '  value="'.$valu.'" '. $aktiv. $attr. /* 'onclick="setBubble('.$name.',\'bubbleDiv\') " ' . */
                                'oninput="this.nextElementSibling.value = this.value" style= "text-align: '.$algn.'; font-size: 12px; margin: 0; padding-top: 5px; box-shadow: none;" /> 
                                <output style="top: -18px; left: 45%; position: relative; font-size: 10px">'.$valu.'</output>'.
                            '<div class="bubble" id="bubbleDiv" name="bubbleDiv" 
                                  style="font-size: 10px; position: relative; width: 100%; text-align: center; opacity: 80%; top: -37px; "> '. // ' min="0" max="50"'
                                   '<span style="width: 10%; float:left;">'.str_replace('"','',substr($attr,1,7)).'</span> '.
                                  // '<span style="width: 33.33%;"> './* $valu. */'</span> '.
                                   '<span style="width: 20%; float:right;">'.str_replace('"','',substr($attr,-9)).'</span>'.
                            '</div>'.
                            '</span>';  break; // (FIXIT:) setBubble - Output min-val-max

        case 'butt' : $result.= '<span class="fieldContent boxStyle" style="min-height: 28px;">'.
                            '<input type= "button" '.   $inpIdNm. ' value="'.$valu.'" '. $aktiv. $attr.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" /> </span>'; break; // No functionality !

        case 'colr' : $result.= ## COLOR:
                            '<span class="fieldContent boxStyle" style="height: 28px;">'.
                            '<input type= "color" '.    $inpIdNm. ' value="'.$valu.'" '. $aktiv. $attr.
                        $inpStyle. ' margin: 0; padding: 0; width: 100%;border-radius: 4px;" /> </span>'; break;

        case 'phon' : $result.= ## PHONE:
                            '<input type= "tel" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. $inpStyle. '" />';  break;

        case 'pass' : $result.= ## PASSWORD:
                            '<span class="fieldContent boxStyle" style="'.$bord.' text-align: left; '.($rows!='0' ? 'height: 36px; ':'').'padding-right: 20px;">'.
                            '<div style="white-space: nowrap;">'.
                                '<input type= "password" '. $inpIdNm. ' style="height: 8px; width: 75%; margin-top: -1px; 
                                    box-shadow: none;" value="'. $valu.'" '.$eventInvalid. $aktiv. $plh. $attr.' onkeyup="getPassword('.$name.')" 
                                 />'.
                                 # labl:'', icon:'', hint:'', type:'submit', name:'', link:'', evnt:'', wdth:'', font:'32px', fclr:'gray' bclr:'white', akey:'', rtrn:false)
                                htm_IconButt($btnlabl='', $btnicon='far fa-eye fa-fw colrgreen',$btnhint= lang('@Show/Hide password'),
                                             $btntype='button', $btnname='tgl_'.$name, $btnlink='',
                                             $btnevnt='onmousedown=\'togglePassword('.$name.','.'tgl_'.$name.')\'', $wdth='', $btnfont='14px;', 
                                             $btnfclr='green', $btnbclr='white; padding-right:3px; padding-bottom:1px; margin-top:1px; width:28px;',
                                             $btnakey='', $btnrtrn=true ).
                            '</div>';
                            $str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
                            if ($rows!='0')
                                $result.= '<meter id= "pwPoint'.$name.'" style="position:relative; height:12px; width:100%; top: -10px;" '.
                                          'min="0" low="6" optimum="7" high="9" max="10" '.
                                          'title="'.lang('@Password strength: 0..10').'">'. // $str.'"'. // ' <span id=\"mtPoint\"'.$name.'> 0</span>'. '/10"'.
                                     '</meter>'; 
                      $result.= '</span>';  break;

        case 'area' : $result.= ## TEXTAREA:
                        '<span class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 0;"> <textarea rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="width:99%; font-size: 1em; border: 1px solid Gainsboro; border-radius: 4px; '.$dataStyle.' '.'" '.
                        $eventInvalid. $aktiv. $plh.$attr.' >'.$valu.'</textarea>'; $just= 'top: -4px; position: relative;'; break;

        case 'html' : $result.= ## HTML-TEXT:
                        '<span class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 4px;"> <small><div contenteditable="true" rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="background-color: white; min-height: '.($rows>'1' ? '34px;' : '5px;').' border: 1px solid Gainsboro; padding: 2px; " '. //  Like area, but with html-content
                        $eventInvalid. $aktiv. $plh.' data-placeholder="'.lang($plho).'" '. $attr.' >'. $valu.'</div></small>';
                        if ($disa) $result.= '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>';  
                        $just= 'top: -4px; position: relative;'; break;

        case 'chck' : $result.= ## CHECKBOX:
                            '<span class="fieldContent boxStyle '.(count($list)== 1 ? 'fieldSingle' : '').'" style="'.$bord.' margin: 0 2px; ">';
                            foreach ($list as $rec) { // $list= [['name','@Label','@ToolTip'], ['0:name',1:'@Label',2:'@ToolTip',3:state:'checked/selected',4:otherAttr (id="idxx")], ['@Label','@ToolTip'],...]
                                array_push($rec, '', '');   # Prevent error on $rec[3] / $rec[4]
                                $result.= '<span style="display: inline-block">';
                                $result.= '<input type= "hidden"   name="'.$rec[0].'" value="unchecked" /><label for="'.$rec[0].'"></label>'; # Hidden field because Unchecked boxes is not included in $_POST !
                                $result.= '<input type= "checkbox" name="'.$rec[0].'" value="checked" '. $rec[3].' '. $rec[4]. ' '.$valu.' style="width: 20px; box-shadow: none; scale:1.3;"/>'.
                                   '<label for="'.$rec[0].'" style="position: relative; width: min-content;'.$lpos.'">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; '.$attr).'</label>';
                                 //  '<label for="'.$rec[0].'"                                              ">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; '.$attr).'</label>';
                                $result.= '</span>';
                             //   if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= ''.($subm ?? '').'</span>';  break;

        case 'rado' : $result.= ## RADIO:
                            '<span class="fieldContent boxStyle" style="'.$bord.'"><small>';
                            foreach ($list as $rec) { // $list= [[0:'value',1:'Label',2:'@ToolTip',3:state:'checked/selected'], ['Label','@ToolTip'],...]
                                if ($valu==$rec[0]) $chk= ' checked '; else $chk= ' ';
                                    $result.= '<input type= "radio" id="'.$rec[0].'" name="'.$name.'" value="'.$rec[0].'" '.
                                        $chk.($rec[3] ?? ''). ' '.$attr.' style="width: 20px; box-shadow: none;">'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px;">'. Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small>'.($subm ?? '').'</span>';  break;

        case 'opti' : $result.= ## OPTION:
                            '<span class="fieldContent boxStyle"  style="'.$bord.' background-color; white; text-align: center; padding: 10px 4px 4px;"><small>';
                            $result.= '<select class="styled-select" id="'.$name.'" name="'.$name.'" '.($events ?? '') .' '.$eventInvalid.'style="width: 98%; border-color: Gainsboro; '.($valu>'' ? 'font-weight: 600;':'color:var(--grenColr1)').($colr ?? '').'" '.$attr.' '.$aktiv.'> '; dvl_pretty();
                            $result.= '<option label="'.lang($plho).'" value="'.$valu.'">'.lang('@Select!').'</option> ';  # title="'.$hint.'"     selected="'.$valu.'"
                            foreach ($list as $rec) { # $list= [[0:value, 1:name, 2:@ToolTip, 3:state:'checked/selected', [...]]
                                $result.= '<option '. /* .'label="'.lang($rec[x]).'" '. */ 'title="'.lang($rec[2] ?? '').'" value="'.$rec[0].'" '.$state=$rec[3] ?? ''.$attr=$rec[4] ?? ''; //  Firefox does not support Label !
                                if ($rec[0]==$valu) $result.= ' selected ';
                                $result.= '>'.$lbl=lang($rec[1]).'</option> ';
                            }   $result.= '</select></small>'.($subm ?? '').'</span>';  break;
    //  case 'show' : $result.= '<input type= "text"   id="'.$name.'" name="'.$name.'" value="'.$valu.'" disabled />';  break;
        case 'hidd' : $result.= ## INVISIBLY:
                            '<input type= "hidden" id="'.$name.'" name="'.$name.'" value="'.$valu.'" />';  break;

        default     : $result.= ## UNSPECIFYED:
                            ' htm_Input(): Illegal vrnt ! ';
        dvl_pretty();
    }

# htm_Input: LABEL & TIP:
    switch (strtoupper($llgn)) {
    case 'L': $lblalign = 'margin-right: auto;';  break;   // Align label Left
    case 'C': $lblalign = 'margin:       auto;';  break;   // Align label Center
    case 'R': $lblalign = 'margin-left:  auto;';  break;   // Align label Right
    default:  $lblalign = 'margin-left:  auto;';
    }
    if ($vrnt!='hidd')
        $result.= ' <abbr class= "hint">'.
                ($labl>'' ? 
                   '<label for="'.$name.'" style="font-size: 12px; '.$top. ' vertical-align:top; ">
                        <div style="white-space: nowrap; '.$lblalign.$just.'">'.$icon.$labl.'</div>
                   </label>' : '').($hint>'' ?
                   '<data-hint style="top: 45px; left: 2px;">'. $hint.
                        ($unit>'' ? (' <br>'.lang('@Unit: ').ltrim($unit,'<')) : '').
                        ($pattern>"" ? ('<br><div style="color:green">'. $pattern. '</div>') : '').
                   '</data-hint>
               </abbr>' : '');
         $result.= '</div>'; # :FIELD inpField
    if ($form>'') $result.= '</form>';

    if (!$rtrn) echo $result; else return $result;
} # :htm_Input()


function htm_Inbox(# labl:'',plho:'@Enter...',icon:'',hint:'',vrnt: 'noUse',name:'noUse',valu:'',form:'noUse',wdth:'200px;',algn:'left',attr:'',rtrn:false,unit:'noUse',disa:false,rows:'noUse',step:'noUse',list:['noUse'],llgn:'R',bord:'1px solid var(--grayColor);',ftop:'');
    # Inbox: container with: Border, Label, Hint, (Placeholder)
    # Design and parameters same as htm_Input()
    $labl= '',                              # string: Translated label above the input field
    $plho= '@Enter...',                     # string: The placeholder shown with blank value
    $icon= '',                              # string: The icon left of the label
    $hint= '',                              # string: The Translated description for the field

    $vrnt= 'noUse',                         # string: Variant
    $name= 'Body_div',                      # String: Set the Editable name (and id)
    $valu= '',                              # string: The HTML content of the box-body
    $form= 'noUse',                         # 

    $wdth= '200px',                         # string: The outher Width of the field-container
    $algn= 'left',                          # string: The alignment of input content Default: left 
    $attr= '',                              # string: Give more (special / non system) attrib to the field 
    $rtrn= false,                           # bool:  Act as procedure: Echo result, or as function: Return string

    $unit= 'noUse',                         # 
    $disa= false,                           # bool: Disable the field as editeble. Default: field is not editeble
    $rows= 'noUse',                         # 
    $step= 'noUse',                         # 

    $list= ['noUse'],                       # 
    $llgn= 'R',                             # string: Label align Default: Right 
    $bord= '1px solid var(--grayColor);',   # string: BoxBorder color to mark required/optional field.   Default= 'border: 1px solid var(--grayColor);' 
    $ftop= ''                               # string: Ajust field vertical position 
    ) {
    global $gbl_iconColor, $gbl_labelAlgn;
    if ($llgn == '') $llgn= $gbl_labelAlgn;
    if ($disa==true) $disa='contenteditable="true"'; else $disa='';
    if ($icon>'') $icon= '<ic class="'.$icon.'" style="color: '.$gbl_iconColor.'; margin: 0 5px;"></ic>&nbsp;'; else $icon= '';
    $ftop= ($ftop>'') ? ' top: '.$ftop.'; ' : '';
    
    switch (strtoupper($llgn)) {
        case 'L': $lblalign = 'margin-right: auto;';  break;   // Align label Left
        case 'C': $lblalign = 'margin:       auto;';  break;   // Align label Center
        case 'R': $lblalign = 'margin-left:  auto;';  break;   // Align label Right
        default:  $lblalign = 'margin-left:  auto;';
        }
      
    $result= 
    '<div id="Inbox_div" style="  '.                /* The outher div with border: */
           'box-shadow: 3px 4px 2px var(--shadColor);
            border-radius: 5px;
            border: '.$bord.'
            '.$ftop.'
            width: '.$wdth.';
            text-align: '.$algn.';
            padding: 10px 5px 2px 5px;
            margin: 5px 2px 2px;
            background-color: white;
            display: inline-block;
            vertical-align: top;
            ">
        <abbr class= "hint" >'.                                                                             /* The Tooltip-container shown on mouse over */
           '<label for="Inbox_div" style="font-size: 12px; height: 0; display: block; '.$lblalign.'; ">'.   /* The Label above the field content */
                '<div style="white-space: nowrap; position: relative; background-color: var(--lablBgrnd); '. 
                    'border: 1px solid  var(--FieldBord);
                    top: -19px;
                    border-radius: 9px;
                    width: min-content;
                    padding: 0 5px;
                    '.$lblalign.'
                ">'.  
                    $icon.lang($labl).
                '</div>
            </label>
            <div id= "label_div"; style="position: relative; ">'. 
                '<data-hint style="left: -5px;">'.lang($hint).      /* The text for the Tooltip */ 
                '</data-hint>
            </div>
        </abbr>
        <div id="'.$name.'" '.$disa.' data-ph="'.$plho.'"'.         /* The inner div-field content */
            'style="
                font-size: smaller;
                [contenteditable=true]:empty:not(:focus):before { content:attr(data-ph) };'. // Not working !
                $attr.' ">'.
                    $valu.
        '</div>
    </div>';
    if (!$rtrn) echo $result; else return $result;
} # htm_Inbox

## General output for pt. Progress etc.
function htm_Output(# labl:'', icon:'', hint:'', vrnt:'pgrs', name:'', form:'', valu:'', vmax:''
    $labl='',           # string: The caption text
    $icon='',           # string: comming new (label prefix)
    $hint='',           # string: The hint/tooltip
    $vrnt= 'pgrs',      # string: Variant
    $name= '',          # String: Set the name/id
    $form= '',          # String: Form name
    $valu= '',          # string: The actual value / list of other elements' ids
    $vmax= '',          # string: The Max value
    $attr= '',          # string: Give more (special / non system) attrib to the field 
    $bclr= 'white',     # string: span background-color
    $rtrn= false,       # bool:  Act as procedure: Echo result, or as function: Return string
) { global $gbl_iconColor;
    if ($icon>'') $icon= '<ic class="'.$icon.'" style="color: '.$gbl_iconColor.'; margin: 0 5px;"></ic>&nbsp;'; else $icon= '';
    if ($bclr>'') $bclr= ' background: '.$bclr.';'; else $bclr= '';
    $result= '<span id="'.$name.'" style= "padding: 2px 5px; position: relative;'.$bclr.'; ">';
    if ($hint>'') $result.= ' <abbr class= "hint">';
    switch ($vrnt) { // Variants:
        case 'outp' : $result.= '<label for="'.$name.'">'.$icon.lang($labl).'</label>'. # Output element with label and hint
                                '<output name="'.$name.'outp" for="'.$valu.'" form="'.$form.'">
                                </output>';  break;
/*      case 'outp' : echo '
                        <form oninput="x.value=parseInt(a.value)+parseInt(b.value)">
                          <input type="range" id="a" value="50">
                          +<input type="number" id="b" value="25">
                          =<output name="x" for="a b"></output>
                        </form>';
                         break;'
*/
        case 'pgrs' : if ($valu<0) $value=''; else $value=' value="'.$valu.'"';
                      $result.= '<label for="'.$name.'">'.$icon.lang($labl).'</label>'. # Output Progress indicator
                                '<progress id="'.$name.'pqrs" '.$value.' max="'.$vmax.'" >
                                </progress>';  break;
        default     : $result.= ' htm_Output(): Illegal vrnt ! ';
    }
    if ($hint>'') $result.= 
                       '<data-hint style="top: 45px; left: 2px;">'. lang($hint). '</data-hint>
               </abbr>';
    $result.= '</span>';
    if (!$rtrn) echo $result; else return $result;

/* 
<style>
progress{                           /* custom style for overall progress bar * /
    -webkit-appearance: none;       /*reset to default appearance* /
    -moz-appearance: none;
    appearance: none;
    width: 200px;
    height: 20px;
    border-radius: 20px;
    border: 1px solid #434343;
}
 
progress::-webkit-progress-bar {    /* style for background track* /
    background: rgb(221, 221, 221);
    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.2) inset;
    border-radius: 20px;
}
progress::-webkit-progress-value {  /*style for progress track* /
    background-image: linear-gradient(120deg,#ffd173 0,#18cc00 55%);
    border-radius: 20px;
}
</style>
*/
}


## A caption with icon, label and hint
function htm_Caption(# labl:'',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 13px;',rtrn:false);
    $labl='',       # string: The caption text
    $icon='',       # string: label prefix
    $hint='',       # string: The hint/tooltip
    $algn='',       # string: Caption Alignment
    $styl=          # string: Default Caption text style
          'color:#550000; font-weight:600; font-size: 13px;',
    $rtrn=false
) {
    if ($icon>'') $icon= '<ic class="'.$icon.'" style="color: '.$gbl_iconColor.'; margin: 0 5px;"></ic>&nbsp;'; else $icon= '';
    if ($algn>'') $algn= ' text-align: '.$algn.';';
    $result= '<abbr class= "hint">
            <data-colrlabl style="'.$styl.$algn.'">'.$icon.' '.lang($labl).'</data-colrlabl>';
            if ($hint>'') $result.= '<data-hint> '.lang($hint).' </data-hint>';
    $result.= '</abbr>';
    if (!$rtrn) echo $result; else return $result;
}

function htm_TextDiv(# body:'', algn:'left', marg:'8px', styl:'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',attr:'background-color: white;', rtrn:false );
    $body,          # string: Html-text inside div
    $algn='left',   # string: div-text alignment
    $marg='8px',    # string: div margin
    $styl=          # string: Other style
          'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; white-space: nowrap; ',
    $attr=          # string: Other style 
          'background-color: white; ',
    $rtrn=false
) {
    $result= '<div style="margin: '.$marg.'; overflow-x: auto; text-align: '.$algn.'; '.$styl.$attr.'">'. lang($body). '</div>';
    if (!$rtrn) echo $result; else return $result;
}

## Text displayed in a fixed-width font, and preserves both spaces and line breaks
function htm_TextPre(# body,algn:'left',marg:'8px',attr:'',font:'',code:false,rtrn:false);  ## Preformatted HTML text
    $body,          # string: Html-text inside pre
    $algn='left',   # string: pre-text alignment
    $marg='8px',    # string: Default pre margin
    $attr='',       # string: Other style
    $font='',       # string: pre-text font
    $code=false,    # bool:   convert: &lt;b&gt;bold&lt;/b&gt;
    $rtrn=false
) {
    if ($code) $body= htmlspecialchars($body); // convert: &lt;b&gt;bold&lt;/b&gt;
    if ($font>0) $font= ' font-family: '.$font.'; ';
    $result= '<pre style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.' white-space: pre-wrap; '.$attr.'">'. $body. '</pre>';
    if (!$rtrn) echo $result; else return $result;
}

/* 
function htm_CodeDiv($code,$rtrn=false) { // htm_CodeDiv(highlight_words(highlight_string('<? '.$strCode,true)));
    $result= '<p style="text-align: left; padding:4px; white-space: nowrap; overflow-x: auto; line-height: 1; background-color:#121212;">'; // #121212
    $result.= $code; //str_replace(['$','"'],['\$','\"'],$code);
    $result.= '</p>';
    if ($rtrn==false) echo $result;
    else return $result;
};
 */

function htm_CodeBox($code,$rtrn=false) {
    $result= '<span style="text-align: left; white-space: nowrap; overflow-x: auto; line-height: 1;">
              <pre style= "background-color: #121212; text-align: left;  padding:6px;">'.
              $code.
              '</pre></span>';
    if ($rtrn==false) echo $result; else return $result;
};

## Vertical text
function htm_TextVer(# body,algn:'left',marg:'8px',attr:'',font:'',code:false); ## Vertical text
    $body,          # string: Html-text inside div
    $algn='left',   # string: text alignment
    $marg='8px',    # string: Default margin
    $attr='',       # string: Other style
    $font='',       # string: text font
    $code=false     # bool:   convert: &lt;b&gt;bold&lt;/b&gt;
) {
    if ($code) $body= htmlspecialchars($body); // convert: &lt;b&gt;bold&lt;/b&gt;
    if ($font>'') $font= ' font-family: '.$font.'; ';
    echo '<div style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.' 
    position: relative; 
    transform-origin: top left; transform: rotate(-90deg) translate(-30%, 49.5%);
    margin: auto; line-height: 1.44; '.$attr.'">'. $body. '</div>';
}

## A very small text
function htm_MiniNote(# note:'') # Very small text-line
    $note= ''
)
{   echo '<br><small><small>'.lang($note).'</small></small>';
}

## A text with a caption on colored line
function htm_TextTip(# capt:'TIP',body:'',wdth:'',algn:'center',colr:'');
    $capt='TIP',    # string: The output caption
    $body='',       # string: The output text
    $wdth='',       # string: The div width
    $algn='center', # string: The div alignment
    $colr=''        # string: the background-color
)
{   if ($wdth>'') $wdth= ' width:'.$wdth.'; ';
    if ($algn=='center') $algn= ' margin: auto; ';
    else if ($algn>'') $algn= ' text-align:'.$algn.'; ';
    echo '<div style="'.$wdth. $algn.'; border:1px solid gray; ">'.
        '<div style="background-color: '.$colr.'; color: '.invertColor($colr,true).';">'.$capt. '</div>'.
        '<div style="padding: 8px; ">'.$body.'</div>'.
    '</div>';
}

function htm_TextHint(# text:'', hint:'', styl:'', attr:'', rtrn:false) {
    $text='Visibly Text',               # string: Visibly Text       
    $hint='Hidden description',         # string: Hidden description 
    $styl='background-color: white; ',  # string: Outher style (div-container)
    $attr=                              # string: Inner style (span-popup)
          'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; white-space: nowrap; ',
    $rtrn=false                         # bool:   Function Return or echo result
){ # onmouseover: show popup description window:
    $result= '
    <div class="tiptext" style="width: max-content; '.$styl.'">'.$text.'
        <span class="description abbr hint"
             style="display:none; position:relative; top:30px; left: -50px; border:1px solid gray; width:200px; background-color: var(--HintsBgrd); '.$attr.'"> 
             '.lang($hint).'
        </span>
    </div>
    <script>
        $(".tiptext").mouseover(function() { $(this).children(".description").show();
                   }).mouseout (function() { $(this).children(".description").hide();});
    </script>';
    if (!$rtrn) echo $result; else return $result;
}

function htm_Figure(# capt:'',type:'',imag:'',styl:'',labl:'',hint:'',rtrn:false) {
    $capt= '',      # string: The header text
    $type= 'h1',    # string: Header type (h1..h6)
    $imag,          # string: Path to the image
    $info= '',      # string: alternative text
    $styl= '',      # string: Styles for the image
    $labl= '',      # string: The figure caption/label
    $hint= '',      # string: Hidden description
    $rtrn= false    # bool:   Function Return or echo result
) 
{   $result= '<'.$type.'>'.lang($capt).'</'.$type.'>
        <figure>
          <img src="'.$imag.'" alt="'.$info.'" style="'.$styl.'">
          <figcaption>'.lang($labl).'</figcaption>
        </figure>';
    if ($hint>'') $result= 
        '<abbr class= "hint" style="position: relative;">'.
            $result.
            '<data-hint style="left: auto;">'.lang($hint).'</data-hint>'.
        '</abbr>';
    if (!$rtrn) echo $result; else return $result;
}

function htm_Details(# capt:'',type:'',body:'',styl:'',labl:'',hint:'',mode:'',rtrn:false) { # Collapsibly text
    $capt= '',      # string: The header text 
    $type= 'h1',    # string: Header type (h1..h6)
    $body,          # string: The details text
    $styl= '',      # string: Styles for capt & body & labl
    $labl= '',      # string: The details summary
    $hint= '',      # string: Hidden description
    $mode= '',      # string: Initial mode: 'open'/''
    $rtrn= false    # bool:   Function Return or echo result
) 
{   $result= '<'.$type.' style="'.$styl.'">'.lang($capt).'</'.$type.'>
        <details '.$mode.' style="'.$styl.'">
            <summary>'.
                lang($labl).'
            </summary>
          <p>'.lang($body).'</p>
        </details>';
    if ($hint>'') $result= 
        '<abbr class= "hint" style="position: relative;">'.
            $result.
            '<data-hint style="left: auto;">'.lang($hint).'</data-hint>'.
        '</abbr>';
    if (!$rtrn) echo $result; else return $result;
}


function invertColor($colr,$bw) ## Untested !
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

## Add strings to a buffer
function spool($data,$echo=true) { global $spool;
    if ($echo==true) echo $data;
    $spool.= $data;
}


/*
Layout of htm_Table:
|-------------------------------------------------------------------------------------------------------|
|                                                                                                       |
|                                           TABLE-Caption                                               |
|                                              ($capt)                                                  |
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
|    F    |                                    ($data)                                        |    F    |
|    I    |                                                                                   |    I    |
|    X    |                                                                                   |    X    |
| ($pref) |                                                                                   | ($suff) |
|         |-----------------------------------------------------------------------------------|         |
|         |                                                                                   |         |
|         |                                    TABLE-FOOT                                     |         |
|-------------------------------------------------------------------------------------------------------|
|                                              Table-Notes                                              |
|                                                ($note)                                                |
|-------------------------------------------------------------------------------------------------------|
*/
         # PHP7: $TblCapt,$RowPref,$RowBody,$RowSuff,$TblNote,&$TblData,$FilterOn,$SorterOn,$CreateRec,$ModifyRec,$ViewHeight,$TblStyle,$CalledFrom,$MultiList)
     # ver 1.2.2: TblCapt:,RowPref:,RowBody:,RowSuff:,TblNote:,TblData:,FilterOn:,SorterOn:,CreateRec:,ModifyRec:,ViewHeight:,TblStyle:,CalledFrom:,MultiList:,ExportTo:'')
function htm_Table(# capt:[], pref:[], body:[],suff:[], note:'', data:[], filt:true, sort:true, crea:true, modi:true, vhgh:'400px',  styl:'',  from:__FILE__,list:[],expo:'');
    $capt= [ # ['0:Label',   '1:Width',    '2:Type',     '3:OutFormat', '4:horJust',       '5:Tip',    '6:placeholder', '7:Content';], ...
           ],
    $pref= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:Html'], ...
           ],           // if (($modi) or ($body[0][2]!='indx')) is 2% ColWidth can be used to => row-select-button
    $body= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:fldKey', '6:ColTip','7:placeholder','8:default','9:[selectList]'], ...
             # [ labl,        wdth,         type,         frmt,          feld[],            fkey,       hint,      plho,           dflt,       list ] # Future Fieldnames
           ],          # Field 4: $FieldProporties - is composed of: [horJust, FieldBgColor, FieldStyle, TdColor, sort, filt, SelectON, Unit?
                       #                                              just,    bclr,         styl,       colr,    sort, filt, slct,     unit
    $suff= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[horJust_etc]', '5:ColTip', '6:value! '], ...
           ],
                # $capt= array:  HTML to be shown above the table
                # $pref= array:  Leding columns left to the table data
                # $body= array:  Rows with table data
                # $suff= array:  Ending columns right to the table data
    $note= '',         # string: HTML-string - note to be shown below the table
    &$data,            # array:  [{"name_0":value_0, "name_1":value_1, "name_2":value_2, "name_3":value_3, "name_4":value_4, "name_5":value_5, "name_6":value_6, "name_7":value_7, "name_8":value_8, "name_9":value_9},{...},{...}]
    $filt= true,       # bool:   Ability to hide records that do not match filter // Does not work with hidd fields!
    $sort= true,       # bool:   Ability to sort records by column content
    $crea= true,       # bool:   Ability to create a records - string: Labeltext on createButton
    $modi= true,       # bool:   Ability to select and change data in a row
    $vhgh= '400px',    # string: The height of the visible part of the table's data
    $styl= '',         # string: Style for the span that holds the table;
    $from= __FILE__,   # string: = __FILE__ / __FUNCTION__ (debugging: locate error)
    $list= ['',''],    # array:  LookupLists for options // Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
    $expo= ''          # string: Export values in table fields (only body-cols) to CSV-file
// ,$dropFirst=false   # remove first field (dbIndex id) from TblData-rows
)
                       # Field 4: $FieldProporties - is composed of: [0:horJust, 1:FieldBgColor, 2:FieldStyle, 3:TdColor, 4:SorterON, FilterON, SelectON, Flst]
                       # 0:horJust - Arguments to .td: style="text-align:
                       # 1:FieldBgColor - Arguments to .td: background-color:
                       # 2:FieldStyle - complete expression, e.g.: 'font-style:italic; '
                       # 3:TdColor - like 1: but used for "row marking"
                       # 4: 5: 6: ...
                       # Only impact on Body areas.

# !  FIXIT:  Fixed/Sticky header only works on 1st table when there are several tables in the same window!
# !          Zebra streaks (Update Issue!) Failure, as well as filter problems when hidden columns are also present.
# !  FIXIT:  Change value in INPUT dont only works i 1. table on page.
# !  FIXIT:  Fieldnames are not used on reading records from $TblData, only the order are used !

{ global $gbl_blueColor, $gbl_LineBrun, $gbl_RollTabl, $gbl_HeaderFont, $gbl_IconStyle, $gbl_CardIx, $gbl_TblIx, $gbl_rowCount, $gbl_novice, $rowHtml, $ordrTotal, $spool;
    $spool= '';
    $creaInpBg= 'LightYellow';
    $gbl_BodyBcgrd= 'yellow';
    //$selectable= (($ModifyRec) and ($body[0][2]=='indx'));
    $selectable= false;
    //if (!$TblData) {msg_Info ('No data', 'The data table is empty!'); $TblData=[]; };  //  exit;
    $arrFldkey= [];
    foreach ($body as $row) $arrFldkeys[]= $row[5];
    $fldNames= $arrFldkeys ?? []; # FieldNames in array created on submit. Also used to sort data fields 
    
    if (DEBUG) dvl_pretty('Start-htm_Table: '.$from);
    if (!$selectable) $RowSelect= '';
    else    { $RowSelect= '<span class="tooltip"><span style="font-size:115%;">&#x21E8;</span>'.
                            '<span class="LblTip_text" style="bottom: -12px; left: 65px">'.lang('@Selectable: ').str_nl(1).
                            lang('@This row can be selected by clicking Id/Number in the first field of the row.').'</span></span>';
            }
    if ($filt)  { $filtInit= ' filter-true '; }   else $filtInit= ' filter-false '; // filter-select
    if ($sort)  { $sortInit= ' sorter-inputs '; } else $sortInit= ' sorter-false '; // General for all columns
    if (($filt===true) and ($note===''))
        $note= '<small><small>'.lang('@Table-Filtering/Searching: Hold mouse over the colored row below the column headers.').'</small></small>';           # HTML-string
    if (is_string($crea)) { $ButtLabl= $crea; $crea= true; } else $ButtLabl= '@Create new row';
    $gbl_TblIx++;          //  0..7 on a page
    $tix= 'T'.$gbl_TblIx;  //  Tabel index for flere tabeller i samme vindue

    if (!function_exists('RowKlick')) {
        run_Script( 'function rowLookup(CalledFrom,valu,RowIx,ColIx) { window.alert("'.lang('@You pressed ').'" + valu + '.
            '"\nNothing is happening yet...\nRelates to: "+ CalledFrom +" Row: "+ RowIx );'.
            ' }');
        function RowKlick($modi,$valu,$RowIx,$ColIx,$fldNames,$from,$ixalign) {
            if (!$modi) {return $RowIx;} else return
            '<span style=" padding:3px 0;" onclick="rowLookup(\''.$from.'\',\''.$valu.'\',\''.$RowIx.'\',\''.$ColIx.'\')" >'.
            '<input name="'.$fldNames[$ColIx].'[]"
                style="width:99%; text-align: center; '.$ixalign.' text-decoration: underline; color: blue; cursor:zoom-in; background-color: transparent; font-weight:600;"
                readonly
                value="'.$valu.'" />'.
            '</span>';
        };
    }

    $Width= '98%';
    spool( '<span class="tableStyle" name="tblSpan" id="tblSpan" style="width:'.($width ?? '').'; padding: 8px; '.$styl.' ">');
### Caption line:
    if ($data!=null)
    if ($capt[0][0] ?? ''>'') {    dvl_pretty();    // htm_nl(1);
        if ($capt) foreach ($capt as $cpt) { // $cpt[x]: 0:Label 1:width 2:type 3:name 4:align 5:titletip 6:default 7:value
            $mode= '" placeholder="';
            spool( ' '.lang($cpt[0]));  //  Label:  (feltPrefix)
            switch ($cpt[2]) {  # Special outputs:
                case 'show' : $mode= '" disabled value="';              break;
                case 'rows' : spool( count($data).' '.lang($cpt[6]));  break;  //  $cpt[6]= feltSuffix
                case 'html' : spool( ' '.lang($cpt[7] ?? ''));                  break;
                case 'data' : spool( ' <input type= "'.$cpt[2].'" name="'.$cpt[3].'" title="'.lang($cpt[5]).   //  Input-field with name
                    $mode.lang($cpt[6]).'" style="width:'.$cpt[1].'; text-align:'.$cpt[4].';" value="'.lang($cpt[7]).'" />&nbsp;&nbsp;'); break;
                default:      spool( ' <input type= "'.$cpt[2].'" title="'.lang($cpt[5]).   //  Input-field without name (not saved!)
                    $mode.lang($cpt[6]).'" style="width:'.$cpt[1].'; text-align:'.$cpt[4].';" value="'.lang($cpt[7]).'" />&nbsp;&nbsp;');
            }
        } // foreach-TblCapt

    if ((count($capt)>1) or ($cpt[1]>"40%")) htm_nl(); //  false: At narrow card
    if ($gbl_novice==true) {
        htm_sp(5);
        if ($sort)  {echo $sor= htm_IconButt($type='submit',$faicon='fas fa-sort',$id='',$labl='@Sort?',
            $Hint= lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.'),
            $link='#',$action='',$akey='','12px'); }
        if ($filt)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-plus',$id='',$labl='@Filter?',
            $Hint= lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
                   lang('@Enter a search term here to display only data that matches the term.'),
            $link='#',$action='',$akey='','12px'); }
        if ($filt)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-minus',$id='',$labl='@Show everything!',    //<button type="button" class="reset">lang( ' @Vis alt')</button>
            $Hint= lang('@Reset filter so that all data is displayed. With ESC you can reset the search term in the field you are in.'),
            $link='#',$action='',$akey='','12px'); }
        if ($modi) {echo $ret= htm_IconButt($type='submit',$faicon='fas fa-pen-square',$id='',$labl='@Edit?',
            $Hint= lang('@In some of this table`s columns, you can correct data. They are marked with · in the column heading.').str_nl().
                   lang('@If the table cannot be saved, the correction must be done on a retail card.'),
            $link='#',$action='',$akey='','12px'); }
        if ($crea) {echo $til= htm_IconButt($type='submit',$faicon='fas fa-plus',$id='',$labl='@Add?',
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
    echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$vhgh.'; display: block;">'; //  "Table-window": Container for tabel  display: inline ?
    echo '  <div id="overlay'.$gbl_TblIx.'"></div>';
    spool( '    <table class="tablesorter" id="table'.$gbl_TblIx.'" style="width:auto; padding:1px; margin:0; table-layout: fixed;">'); //  id= 'table'.$gbl_TblIx  0..6
    spool( '    <thead>');
    $filter_cellFilter= []; //  [ '', 'hidden', '', 'hidden' ]
    $resizable_widths = [];
    if ($expo > '') $Export= true; else $Export= false;
    if ($Export) $cvrData= '@:';  // cvrData: Used to export data in table body

### Columns-LABELS with sorting and filtering:
    spool( '    <tr style="height:32px;">');
    //if ($selectable) echo  '<th> </th>';
    foreach ($pref as $prf) { dvl_pretty();
        spool( '<th class="filter-false sorter-false" style="width:'.$prf[1].' align:'.$prf[4][0].'; '.$gbl_HeaderFont.'"> '.
                Lbl_Tip($prf[0],$prf[5],'SO',$h='0px').' </th>');
        $resizable_widths[]= $prf[1];
    }   $cNo= -1;
    $hiddcount= 0;
    $datCount= 0;

    if (($data!=null) /* and (!is_string($data)) */)
    if (is_array($data[0] ?? [])) $datCount= count($data[0] ?? []); 
                             else $datCount= count($data    ?? []);
    $fldCount= count($fldNames ?? []);
    // if ($datCount!= $fldCount)  echo '<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>';
    // toast('<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>');
    
    if ($selectable) spool(  '<th class="filter-false sorter-false" > </th>');
    foreach ($body as $bdy) { dvl_pretty();
        $colfilt= ' ';
        $resizable_widths[]= $bdy[1]; # ColWidth
        if (($GLOBALS["Øshow"] ?? ''>0) and ($bdy[2]=='hidd')) $bdy[2]= 'text';
        // if ($bdy[9]==true) $selt= ' filter-select filter-onlyAvail'; else $selt= ' ';  //  FIXIT: sorting of datefields don’t works!
        if ($Export) $cvrData.= '"'.lang($bdy[0]).'",';

        if ($bdy[2]=='hidd') // FIXIT: showing filter-fields, gets columns out of syncronisation ! - $filter_cellFilter obvious don’t work: https://mottie.github.io/tablesorter/docs/#widget-filter-cellfilter
            { array_push($filter_cellFilter, 'hidden');
                $hiddcount++;
                spool( '<th class="filter-false sorter-false sortPrefix" style="width:0;" ></th>'); // FIXIT: Filter-fields is showing hidden columns ! <td data-column="9" style="display:none" > fixes it
            } //  visibility:hidden;    //  columnSelector_columns : { 5 : false, 6 : false}
        else // Special behavior:
            { $cNo++; array_push($filter_cellFilter, '');
                if (($modi==true) and (in_array($bdy[2],['text','data','date','osta','ddwn']) ))   # if editable:
                     { $lblsuff= str_nl().'{'.lang('@Editable').'}'; $label= $bdy[0]; }
                else { $lblsuff= '' /* str_nl().lang('@Not editable!') */ ; $label= markAllChars($bdy[0],'div','style="opacity:0.7; margin: 2px;"'); }

                if ($cNo<=1) $tipplc='SO'; else if ($cNo=1) $tipplc='S'; else $tipplc='SW';
                if ($cNo==count($body)) $tipplc='SW';
                // if (addParser:) class="tags filter-parsed" data-value="sweden"
                if (    // (true) or 
                    (($fldNames[0]=='ord_id') and ($fldNames[$cNo]=='ord_stat')) 
                    )  // Table-orders Status-field
                     $pars= ' filter-parsed ';
                else $pars= '';
                $sort= $sortInit;
                switch ($bdy[2]) { // '2:ContType'
                    case 'date': $sort.= ' sorter-isoDate '; break;
                    //case 'html': 
                    case 'hidd': $sort= ' sorter-false '; break;
                        // sorter-no-parser   sorter-text  sorter-digit  sorter-currency  sorter-url  sorter-isoDate  sorter-percent
                        // sorter-image  sorter-usLongDate  sorter-shortDate  sorter-shortDate  sorter-shortDate sorter-time
                    default:  $sort.= ' sorter-text ';
                }
                // if ($bdy[3]=='2d') $sort.= ' sorter-currency sorter-digit ';  // '3:OutFormat'
                if (($bdy[6] ?? '') === '@The name of file or directory') // '6:ColTip' - goUp in file/folder explorers header:
                {
                    if ($bdy[4][3] ?? ''===false) $sort= ' sorter-false '; // '4:[horJust_etc]
                     if ($GLOBALS['goUp'] ?? '' !='')
                    $goUp= str_WithHint(
                        $labl='<a href="'.($GLOBALS['goUp'] ?? '').'" target="_self" style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 199;">
                                <i class="fas fa-chevron-circle-left" style="color: blue; box-shadow: 3px 3px 1px lightgray;"></i></a>',
                        $hint= '@Go up to parent folder: '.end(explode('/',$GLOBALS['goUp'] ?? '')) );
                else $goUp=str_WithHint(
                        $labl='<span style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 199;">
                                <i class="fas fa-chevron-circle-left" style="color: lightgray; "></i></span>',
                        $hint= '@You are at the top-folder, or outside permitted tree ! ');
                }
                else $goUp='';
            spool( '<th class="'. $filtInit. $pars. ($selt ?? ''). $sort. $colfilt.'" data-placeholder= "'.lang('@Filter...').'" name="xxxx" style="width:'.$bdy[1].'; '.
             $gbl_HeaderFont.' text-align:center;">'.$goUp.Lbl_Tip($label,($bdy[6] ?? '').$lblsuff,$tipplc,$h='0px').' </th>');
        } // else (not hidd)
    } // foreach
    foreach ($suff as $suf) { dvl_pretty();
        $resizable_widths[]= $suf[1];
        spool( '<th class="filter-false sorter-false" style="width:'.$suf[1].'; align:'.$suf[4][0].'; '.$gbl_HeaderFont.'">'.
             Lbl_Tip($suf[0],$suf[5],'SW',$h='0px').'</th>');
    }
    //echo '<th>'.'</th>';
    spool( '    </tr>');    dvl_pretty();
    if ($Export) $cvrData= rtrim($cvrData,',')."\n"; 
    
    // arrPrint($resizable_widths,'$resizable_widths');
    /* run_Script("widgetOptions: {
      resizable: true,
      resizable_widths = $resizable_widths
    }"); */
    set_Style('','$("#table'.$gbl_TblIx.'").tablesorter({ widgetOptions { filter_cellFilter: ["'.implode('","',$filter_cellFilter). '"]}}');   // Hide input filter fields fore hidden columns

### Column-FILTER:   (created of tablesorter, but there are a problem with hidd-fields!) filter-onlyAvail
    spool( '    </thead>');

### TableFooter with the options to create a new record:
    if (false) {
        spool( ' <tfoot>');
        spool( ' </tfoot>');
    }



### DATA and html-objects:
    spool( '     <tbody>');
    if (!function_exists('RowBg')) {
        function RowBg($clr,$alg,$pos='') { if ($pos>'') $bord= ' border-'.$pos.':3px solid var(--grayColor); '; else $bord= '';
        return ' background:'.$clr.'; vertical-align:'.$alg.'; height:1.5em; '.$bord.' '; };
    }

    $RowIx=-1;
    // arrPretty($TblData,'$TblData');
    if ($data!=null) 
        if ($data)
        foreach ($data as $DataRow) {
            // if ($dropFirst== true) array_shift($DataRow);
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
            $DataNam= array_keys($DataRow);
            // arrPretty($DataNam,'$DataNam');
            //if ($DataNam[0]=='id') array_shift($DataRow);
            
            $RowIx++; dvl_pretty();
            //echo '<tr class="row" id="row_'.$RowIx.'">';  //  Tablesorter with Zebra-striped background
            if (false) // ?? popMnu_
                $extra= 'style= "cursor: alias;" title= "'.lang('@RightClick for table-row MENU').'"';
            else $extra= 'style="display: revert;"';
            if (count($body)>0)
            spool( '<tr class="row" id="tabl_row'.$RowIx.'" '.$extra.'>');  //  Tablesorter with Zebra-striped background
            ## Fields before data-fields:
            foreach ($pref as $prf) {
                if (strpos($prf[6],'name="')>'') {
                    $prf[6]= str_replace('name="','name="i'.$RowIx.'_',$prf[6]);
                    $prf[6]= str_replace('label for="','label for="i'.$RowIx.'_',$prf[6]);
                    }
                $rowField.= '<td style="width:'.$prf[1].'; text-align:'.$prf[4][0].'; ">'.lang($prf[6]).' </td>';
                $newRow.= '<td><div style= "background-color: gray;"> </div></td>';
            }
            if ($selectable) $rowField.=  '<td style="text-align:right; width:2%;">'.$RowSelect.'</td>';

    ### Table-BODY-Rows:
            $optlist= $list;
            $ColIx= -1;
            $rowHtml= '';
            $rowBg= '';
            $inpBg= ' background-color:transparent;';   //' background-color: white; opacity:0.60; '; //$inpBg= ' background-color:rbg(200,200,200,0.3);';  //' background-color: white; opacity:0.60; ';
            ## Fields with data:
            $GotoEdit= ' class="clsFocus" '; // Goto FirstField in created row
            foreach ($body as $bdy)
                // if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
                if ($ColDrop ?? ''> 0) {/* Drop Column after colspan */ $ColDrop= $ColDrop-1; $ColIx++;}
                else
                { $ColIx++;    dvl_pretty();
                    $SelectList= $bdy[9] ?? [];
                    if (is_array($DataRow[$ColIx])) $valu= $DataRow[$ColIx][0];
                    else                            $valu= $DataRow[$ColIx];
                    $sortData= ' data-sort= "'. $RowIx. /*trim($valu,' '). /* */ '" ';   // Used to sort on unformatted raw data
                    if ($Export) {
                        if (strlen($valu)>550) $cvrData.= '"'.'To complex ! ('.strlen($valu).')",';
                        else $cvrData.= '"'.$valu.'",';  // Unformatted datapost
                    }

            ## Special Output formats:
                if (!($GLOBALS["Øshow"] ?? '')>0)
                    switch ($bdy[3]) { # OutFormat
                        case '0d': if ($valu==null) $valu= 0;       else $valu= number_format((float)$valu, 0,',',' '); break;
                        case '1d': if ($valu==null) $valu='';       else $valu= number_format((float)$valu, 1,',',' '); break;
                        case '2d': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2,',',' '); break;  //  88 888 888,88
                        case '2%': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format((float)$valu, 2).' %';    break;
                        case '>0': if (!(float)$valu>0) $valu= ' ';                      break; // 0 an less is shown as BLANK
                        case '= ':  $valu= ' ';                                          break; // Values is shown as BLANK
                        case 'B':   $valu= '<b>#'.sprintf("%'.05d", $valu).'</b>';       break; // Values is shown as BOLD - ContType must be 'html' Format: #00000
                        case 'R':   $valu= '<font style="color:red;">'.$valu.'</font>';  break; // Values is shown in red - ContType must be 'html'
                        case 'L':   $valu= '<font style="color:blue;">'.$valu.'</font>'; break; // Values is shown in blue - ContType must be 'html'
                        // case 'cust':$valu= $bdy[4][3][0].$valu.$bdy[4][3][1];            break; // Custom attributes given i FieldStyle list - ContType must be 'html'
                        default:    $valu= $valu;
                    }

                $flag= substr($valu,1,2);
                if (($flag=='::') or ($flag==':.')) $valu= substr($valu,2).' '; // fieldFlag is not shown. SPACE so placeholder is not shown.

  ## Special conditional "row" formats:
            if (is_readable($custFile= '../customRules.inc.php')) include($custFile);  # Here you can add your special rules 
            $ixalign= $ixalign ?? '';
            $captStyle= $captStyle ?? '';
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
                if (is_string($bdy[4][0] ?? ''))  $txAlign= ' style="text-align:'.($bdy[4][0] ?? '').'; '; else $txAlign= '';
                if (is_string($bdy[4][1] ?? ''))  $bgColor= ' background-color:'. ($bdy[4][1] ?? '').'; '; else $bgColor= '';
                if (is_string($bdy[4][2] ?? ''))  $fltStyl= ' '.   /* Custom */   ($bdy[4][2] ?? '').' ' ; else $fltStyl= '';   // i.e.: 'font-style:italic; '
                if (is_string($bdy[4][3] ?? ''))  $tdColor= ' background-color:'. ($bdy[4][3] ?? '').'; '; else $tdColor= '';
                if (is_string($bdy[4][4] ?? ''))  $txtSize= ' font-size:'.        ($bdy[4][4] ?? '').'; '; else $txtSize= '';
                //  disabled ?

            ## Special conditional "row"-formats:
                if ($list==['','']) { $rowType= ''; $ixalign= ''; }

                if (is_array($DataRow))
                if ($ColIx<count($DataRow)) {  //  If colspan is there stopped here, when the row is over
                    // if ($emptyTD== true) $rowField.= '<td>'; else
                    $rowField.= '<td style="text-align:'.$bdy[4][0].'; '.$ixalign.' width:'.$bdy[1].'; '.$bgColor.$tdColor.$txtSize.$rowBg.($colsp ?? ''); //  tablefield-property

                ## Special InputTypes in tablefields:
                if ($GLOBALS["Øshow"] ?? ''>0) $bdy[2]= 'text';
                if ($emptyTD== true) $rowField.= '">'; else
                switch ($bdy[2]) { # ContType / vrnt
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
                    case 'calc' : { // [1, '45-876', 2:$antal=3, 'stk', 'Redekasser', 5:$momssats=25, 6:$pris=235.50, 7:$rabat=8,  $sum=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                                  $x= 1;
                                  $sum= (toNum($DataRow[2+$x])*toNum($DataRow[6+$x]))*(100-toNum($DataRow[7+$x]))/100*(100+toNum($DataRow[5+$x]))/100;
                                  $rowField.= '"> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$sum, 2,',',' '). '" placeholder="'.lang($bdy[7]).'"'.
                                       $txAlign.$inpBg.' width:98%; " readonly /> '; };
                                  $ordrTotal+= $sum;
                                  break;

                ### STANDARD:
                    case 'date' : if (($valu==' ') /* or ($valu==NULL) */) $clr= 'color: transparent; '; else $clr= '';  // Hide the browsers placeholder by using a SPACE
                                  $rowField.= '"'.$sortData.'>'.'<input type= "date" name="'.$fldNames[$ColIx].'[]" '. //  (id="'.$name.'")
                                          'style="text-align: left; /* line-height: 100%; font-size: revert; height:16px; */ max-width: 150px; z-index: auto; '.$clr. $inpBg.
                                           '" value="'.$valu. '" placeholder="yyyy-mm-dd" '.($aktiv ?? '').' />';  break; // The Browser uses its own placeholder!
                    case 'html' : $rowField.= '"'.$sortData.'>  '.$valu;  break;                                                // Only showing HTML
                    case 'htm0' : $rowField.= '"'.$sortData.'>  '.'<small><small>'.$valu.'</small></small>';  break;            // Only showing HTML
                    case 'show' : if ($valu==' ') $clr= 'color: transparent; ';                                   // Only showing data:
                                  else $clr= '';                                                                  // Hide the browsers placeholder by using a SPACE
                                  $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.$valu. '" placeholder="'.lang($bdy[7] ?? '').'"'.
                                       $txAlign.$inpBg.' width:98%; '.$clr.' " readonly /> ';
                                  break;
                    case 'intg' : $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$valu, 0). //  0 dec. = Integer
                                       '" placeholder="'.lang($bdy[7]).'"'.$txAlign.$inpBg.
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
                                         'value="'.htmlentities(stripslashes(lang($valu))).'" placeholder="'.lang($bdy[7] ?? '').'"'.
                                         $txAlign.$inpBg.' width:98%; padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'opti' :{ $rowField.= '"'.$sortData.'><span '. 
                                        htm_Input($labl=lang($bdy[7]),$plho= '?...',$icon='',$hint=lang($bdy[6]),$vrnt='opti',$name= $fldNames[$ColIx],$valu,$form='',$wdth='98%',
                                        $algn='left',$attr='',$rtrn=true,$unit='', $disa=false,$rows='2',$step='',$list=$SelectList,$llgn='R',$bord='border: 1px solid Gainsboro;',$ftop='')
                                    .' </span>';
                                } // print_r($SelectList);
                                  break;
                    case 'keyn' : //  Selectable and editable index
                                  $rowField.= '"'.$sortData.'><span style="font-size:small"  name="'.$fldNames[$ColIx].'[]" title="'.
                                    lang('@The row is selectable. Click here to edit the row`s fields').'">'.RowKlick($modi,$valu,$RowIx,$ColIx,$fldNames,$from,$ixalign).
                                  '</span>';
                                  break;
                    case 'indx' : //  Selectable but not editable index
                                  $rowField.= '"'.$sortData.'><span style="font-size:small;" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.
                                        RowKlick($modi,$valu,$RowIx,$ColIx,$fldNames,$from,$ixalign).' </span>';
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
                                       ' placeholder="'.lang($bdy[7] ?? '').'"'.$txAlign.$inpBg.$fltStyl.' width:98%; '.$captStyle.'" /> ';  //  font-style:inherit;
                                  break;
                                }
                    default   : { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.$valu.' '.
                                        $bdy[2].'" '.'placeholder="'.lang($bdy[7]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%;" /> ';
                                       // toast('Invalid type: '.$Body[2].' in htm_Table() - error !','orange','black');
                                }
                    }   // :switch InputTypes
                    $rowField.= '</td>';
                }      // '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.
                if ($bdy[2]!='hidd') {
                    if ($bdy[0]=='@Order Date') $currDate= date('Y-m-d'); else $currDate='';
                    $newRow.= '<td style="text-align:'.$bdy[4][0].'; width:'.$bdy[1].';" >'. # ColWidth
                              '<input type= "text" '.$GotoEdit.' name="'.$fldNames[$ColIx].'[]" value="'.$currDate.
                              '" placeholder="'.lang($bdy[7] ?? '').'"'.$txAlign.' width: 98%;  background-color: lightyellow; font-style:inherit;" /> </td>';
                              if (!in_array($bdy[2],['show','indx','calc'])) $GotoEdit= '';
                              }
            };  //  foreach $RowBody
            $parser= substr($parser,0,-2).' },';
            spool( $rowField);
    
    

        ### Table-BODY-RowSuffix:
                ## Fields after data-fields:
                foreach ($suff as $Suf) { dvl_pretty();
                    if ($modi) {
                        $output= $Suf[6];
                        if ($Suf[2]=='button') { ## RowSuffix - Special Buttons:
                            $btnStyle= '" class="tooltip" style="height:20px; border:0; box-shadow:none; background-color:transparent;" ';
                            $btnSuff= $gbl_TblIx.'_'.$RowIx. $btnStyle;
                            if ($Suf[0]=='@Delete')  { if ($Suf[3]=='dis') $dis= 'disabled'; else $dis= '';
                                                       $output='<button type= "submit" name="btn_del_'.$btnSuff.$dis.' >'.
                                                    Lbl_Tip($Suf[6],lang('@Delete pos: ').$RowIx.' ('.$dis.')','SW','0px'). '</button>'; }   // Buttons that must not be deleted can be deactivated
                            if ($Suf[0]=='@Hide')   { $output='<button type= "submit" name="btn_hid_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suf[6],lang('@Hide pos: ').$RowIx,'SW','0px'). '</button>'; }                   // Records that must not be deleted can be hidden
                            if ($Suf[0]=='@Copy')   { $output='<button type= "submit" name="btn_cpy_' .$btnSuff.'>'.
                                                    Lbl_Tip($Suf[6],lang('@Copy pos: ').$RowIx,'SW','0px'). '</button>'; }
                            if ($Suf[0]=='@Rename') { $output='<button type= "submit" name="btn_ren_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suf[6],lang('@Rename pos: ').$gbl_TblIx.'_'.$RowIx,'SW','0px'). '</button>'; }
                            if ($Suf[0]=='@Select') { $output='<input type= "checkbox" name="btn_sel_'.$btnSuff.
                                                    Lbl_Tip($Suf[6],lang('@Select pos: ').$RowIx,'SW','0px'). ' />'; }
                        }
                        spool( '<td style="text-align:'.$Suf[4][0].'; width:'.$Suf[1].';" disabled >'.$output.'</td>');
                    }
                    $newRow.= '<td><div style= "background-color: gray;"> </div></td>';
                }   //  [' @Slet',     '4%',         'text',         '',        'center',   ' @Klik på rødt kryds for at slette  ', '<ic class="far fa-times-circle" style="color:red; font-size:13px;"></ic>']
                //  ['0:ColLabl', '1:ColWidth', '2:ContType', '3:Format', '4:FeltJust', '5:ColTip', '6:value!     '            ]
            //echo '<td>'.'</td>';
            spool( '</tr>');
            if ($Export) $cvrData= rtrim($cvrData,',')."\n";

    } //  foreach $TblData
    $_SESSION["ØrowCount"]['T'.$gbl_TblIx]= $RowIx;

    spool( '</tbody>');
    spool( '</table>');
    spool( '</span>'); //  wrapper
    if ($Export) {  // echo '<br>'.$cvrData;
        $fp= fopen($expo,"w");
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
if ($crea) {
    if (!isset($rowField)) $rowField= ''; 
    if (!isset($newRow)) $newRow= ''; 
    
    $rowField= str_replace('<td','<td style="background-color: lightyellow;" ',$rowField);
    //$rowField= str_replace('"','\"',$rowField);
    $newRow= '`<tr style=" border: 3px solid red;">'.$newRow.'</tr>`';
    echo htm_AcceptButt($labl='<i class="fas fa-plus"> </i> '.lang($ButtLabl),$icon='', // Create new item record
                        $hint='@Create an empty row, so you can fill in data in the yellow fields ! ', 
                        $form='form_'.$gbl_CardIx.'_'.$gbl_TblIx, $wdth='200px; min-height:16px;', 
                        $attr='', $akey='c', $kind='spc2',$rtrn=false, $tplc='LblTip_NW', 
                        $tsty='position: absolute; right: 100px;',
                        $acti='appendRow(table'.$gbl_TblIx.','.$newRow.')');
}
    echo '<br><span style="display: inline-block; position: relative;">'.$note.'</span>';
    echo '</span>'; // tableStyle
    if (DEBUG) dvl_pretty('End-htm_Table: '.$from);
    
    
} // htm_Table


function htm_Fieldset_0(# capt:'',icon:'',hint:'',wdth:'',marg:'',attr:'',rtrn:false) # use: htm_Field_0_00() for single object!
    $capt='',$icon='',$hint='',$wdth='',$marg='',$attr='',$rtrn=false)
{ // Has to be followed by htm_Fieldset_00()
    // if ($icon>'') $icon= '<i class="'.$icon.'"></i>';
        $result=  '
        <fieldset style="page-break-after: avoid; display: inline-block; box-shadow: 0 3px 3px #AAAAAA; font-size:smaller; 
                         width: '.$wdth.'; margin: '.$marg.'; border-radius: 6px; "> 
        <legend style="box-shadow: 0 0 5px #AAAAAA; '.$attr.'">'.str_WithHint($capt,$hint,$icon).' </legend>';
    if (!$rtrn) echo $result; 
    else return $result;
}

function htm_Fieldset_00(# rtrn:false) 
    $rtrn=false) 
{   if (!$rtrn) echo '</fieldset>
    '; 
    else return '</fieldset>
    ';
}


// Old:     function htm_Field_0_00($labl='',$hint='',$icon='',$name='fld',$html='',$width='',$margin='',$ftop='',$llgn='R',$attr='',$rtrn=false) #FIELD:
                # v.1.1: $labl='',$hint='',$icon='',$name='fld',$html='',$width='',$margin='',$ftop='',$llgn='C',$attr='',$boxstyl='',$rtrn=false
function htm_Field_0_00(# labl:'',body:'',icon:'',hint:'',name:'fld',wdth:'',styl:'',attr:'',llgn:'C',rtrn:false,ftop:'') #FIELD:
    $labl='',       # string: 
    $body='',       # string: 
    $icon='',       # string: 
    $hint='',       # string: 
    $name='fld',    # string: 
                    
    $wdth='',       # string: 
    $styl='',       # string: 
    $attr='',       # string: 
    $llgn='C',      # string: 
                   
    $rtrn=false,    # bool:   Act as procedure: Echo result, or as function: Return string:   
    $ftop=''        # string: fieldtop: label y-offset
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
                    <div style="white-space: nowrap; box-shadow: none; border: none;'.$lblalign.'">'.lang($labl).'</div>
               </label>'
               : '').
               ($hint>''? ('<data-hint style="top: 45px; left: 2px;">'.lang($hint).'</data-hint>'):'').'
           </abbr>'.($subm ?? '').'
        </div>'; # :FIELD
    if (!$rtrn) echo $result.'
    '; // lf in html
    else return $result.'
    '; // lf in html
}
/* 
func tion htm_Field_00($rtrn=false) #FIELD:
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

function htm_Card_0(# capt:'', icon:'', hint:'', form:'', acti:'', clas:'cardWmax', wdth:'', styl:'background-color: white;', attr:'', show:true, head:'background-color: white;', vhgh:'600px', help:'', fclr:'');
    $capt = '',                         # string: The card caption
    $icon = '',                         # string: Class: icon to the left of caption
    $hint = '',                         # string: The hint on hover caption
    $form = '',                         # string: form id/name (No form without a name)
    $acti = '',                         # string: form action 
                                        
    $clas = 'cardWmax',                 # string: The card class (general CSS-data)
    $wdth = '',                         # string: The closed card width
    $styl = 'background-color: white;', # string: The card body style
    $attr = 'margin-bottom: 8px;',      # string: general attributes (style) for the card-container
    $show = true,                       # bool:   Show card-buttons top-right
    $head = 'background-color: white;', # string: Style for Header background
    $vhgh = '600px',                    # string: MaxHeight (ViewHeight) for span (HideBody) with scrollable content
    $help = '',                         # string: Link to show custom Card-help (HTML-file to open)
    $fclr = ""                          # Special header forground-style  (Icon, text and arrow-icons). Ex.: fclr:'color:snow;'
) // Renamed from htm_Panel_0 in v.1.3.0
{ # MUST be followed of htm_Card_00 after card-content !
    global $gbl_iconColor, $gbl_TitleColr, $gbl_CardForm, $gbl_ProgRoot, $_assets, $gbl_CardIx, $gbl_CardsBgrd, $gbl_GridOn; # v.1.2.3: $gbl_PanlForm => $gbl_CardForm
    $gbl_CardIx++;

    echo '<script>';  //  Hide/show Card-Body:  
    echo 'function CardHeight'.$gbl_CardIx.'() {
                var h = document.getElementById("HideBody'.$gbl_CardIx.'");
                if (parseInt(h.style.maxHeight) < parseInt("4000px") ) 
                    {      h.style.maxHeight = "4000px" }
                    else { h.style.maxHeight = "'.$vhgh.'" }
                }';                
    echo 'function CardSwitch'.$gbl_CardIx.'() {
                var h = document.getElementById("HideBody'.$gbl_CardIx.'");
                var p = document.getElementById("card'.$gbl_CardIx.'");'.        // width = substr($clas,-3).'px' cardW560
                //'h.style.transition-delay = 0.8s;'.
                'if (h.style.display === "none")
                    {      h.style.display = "block";     p.style.width = "";  $("table").trigger("applyWidgets");}
                    else { h.style.display = "none"; p.style.width = "'.$wdth.'"; }
                }';
    echo 'function CardMinimize'.$gbl_CardIx.'() {
                var h = document.getElementById("HideBody'.$gbl_CardIx.'");
                var p = document.getElementById("card'.$gbl_CardIx.'");
                h.style.display = "none"; 
                p.style.width = "'.$wdth.'";'.   // $wdth = Card-width when it is closed
            '}';
    echo 'function CardMaximize'.$gbl_CardIx.'() {
                var h = document.getElementById("HideBody'.$gbl_CardIx.'");
                var p = document.getElementById("card'.$gbl_CardIx.'");
                h.style.display = "block"; '.
            '   $("table").trigger("applyWidgets");
            }'; //  $("table").trigger("applyWidgets"); Refresh the erlier hidden tablesorter objects.
    echo 'function CardWide'.$gbl_CardIx.'() {
                var h = document.getElementById("HideBody'.$gbl_CardIx.'");
                var p = document.getElementById("card'.$gbl_CardIx.'");
                const classes = p.classList;
                if (classes.contains("cardWmax")) {
                    p.classList.remove("cardWmax");
                    p.classList.add("'.$clas.'");
                } else {
                    p.classList.remove("'.$clas.'");
                    p.classList.add("cardWmax");'.     // $clas= "cardWmax"
                '}'.
            '}';
    // if (class="wrapper")
        echo 'function WrapperHeight'.$gbl_CardIx.'() { 
                '. // Has to be developed !  class="wrapper" - $Viewheight - TextArea-rows
                ''.
            '}';
    echo '</script>
    ';
    
    dvl_pretty('htm_Card_0');
    $gbl_GridOn= false;
    if ($capt=='') $Ph= 'height:0px;'; else $Ph= '';

    if ($form>'') { //  Without name form will not be created, so local forms can be used !
            $gbl_CardForm= true;
            $formCrea=  "\n\n".'<form name="'.$form.'" id="'.$form.'" action="'.$acti.'" method="POST" style="margin-block-end: 0;">'."\n";
        }               //  "ParentForm" - Nestet forms is not allowed, so sub-forms has to specially handled!
    else {$gbl_CardForm= false; $formCrea= ''; }
    $prnHtml= '<ic class="'.$icon.'" style="font-size: 20px; color: '.$gbl_iconColor.'; '.$fclr.'margin: 0 5px;"></ic> &nbsp;'.ucfirst(lang($capt));


## CARD-START:                                               style="margin: 0 10px 10px 0; left: -6px;
    echo '<span class="'.$clas.'" id="card'.$gbl_CardIx.'"  style="position: relative; vertical-align: top; margin: 1px; margin-bottom: 8px; '.$attr.'"> '.
            $formCrea.
            // CardTop:
            '
            <span id="chead'.$gbl_CardIx.'" style="display:inline-block; width: calc(100% - 0px); text-align: left; padding: 4px 0;'.$head.'">';
            if ($hint=='')   $hint= '@<b>TOGGLE:</b> Click icon or card header-text to open / close <i>this</i> card';

            // CardTitl:
            echo '<abbr class= "hint">'.
                 '<span class= "cardsTitl" style="'.$Ph.' color:'.$gbl_TitleColr.'; cursor:row-resize; text-align: left; min-height:26px; padding-right:calc(80% - 350px); display:inline;'.$fclr.'"'.
                    ' onclick= CardSwitch'.$gbl_CardIx.'(); > '. $prnHtml. '
                 </span>
                    <data-hint>'.lang($hint).' </data-hint></abbr>';
            // TOGGLE butt: Toggle max-height between vhgh and 999px 
            if ($show==true) 
            echo '<abbr class= "hint">'.
                    '<ic class="fas fa-arrows-alt-v" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:row-resize; font-size: 12px; '.$fclr.'" '.
                    ' onclick= CardHeight'.$gbl_CardIx.'(); ></ic> 
                    <data-hint>'.lang('@<b>TOGGLE-height:</b> Click icon to toggle viewHeight for <i>this</i> card').' </data-hint></abbr>';
            // WIDE butt:
            if ($show==true) 
            echo '<abbr class= "hint">
                    <ic class="fa-solid fa-right-left" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:col-resize; font-size: 12px; '.$fclr.'" '.
                    ' onclick= CardWide'.$gbl_CardIx.'(); ></ic>
                    <data-hint>'. lang('@<b>WIDE:</b> Click to maximize/normalize <i>this</i> card width').'</data-hint></abbr>';
            // HEIGHT butt:
            if ($show==true) if (false) // if (class="wrapper")
                // <script> const el = document.getElementById('card'.$gbl_CardIx.'');    el.closest('.wrapper');     el.find('.wrapper'): </script>
            echo '<abbr class= "hint">
                    <ic class="fa-solid fa-right-left fa-rotate-90" style="width:12px; height:12px; margin-top:6px; margin-right:2px; float:right; cursor:s-resize; font-size: 12px; '.$fclr.'" '.
                    ' onclick= WrapperHeight'.$gbl_CardIx.'(); ></ic>
                    <data-hint>'. lang('@<b>HEIGHT:</b> Click to maximize/normalize <i>this</i> View height (Table/WrapperCard)').'</data-hint></abbr>';

            // COLLAPSE butt:
            if ($show==true)
            echo '<abbr class= "hint">
                    <ic class="fas fa-angle-double-up" style="width:12px; height:12px; margin-top:6px; margin-right:2px; float:right; cursor:zoom-out; font-size: 12px; '.$fclr.'" '.
                    ' onclick= CardMinimizeAll(); ></ic>
                    <data-hint>'. lang('@<b>COLLAPSE:</b> Click to close <i>all</i> cards').';" </data-hint></abbr>';
            // EXPAND butt:
            if ($show==true)
            echo '<abbr class= "hint">
                    <ic class="fas fa-angle-double-down" style="width:12px; height:12px; margin-top:6px; margin-right:2px; float:right; cursor:zoom-in; font-size: 12px; '.$fclr.'" '.
                    ' onclick= CardMaximizeAll(); ></ic>
                    <data-hint>'. lang('@<b>EXPAND:</b> Click to open <i>all</i> cards').';" </data-hint></abbr>';
            if ($help>'') 
            echo '<abbr class= "hint">'.
                    '<ic class="fa-solid fa-question" style="width:12px; height:12px; margin-top:6px; margin-right:2px; float:right; cursor:help; font-size: 12px; " '.
                    ' onclick="window.open(\''.$help.'\', \'_blank\')" >'.
                    '</ic> 
                    <data-hint>'.lang('@<b>HELP:</b> Click icon to goto custom help for <i>this</i> card: '.$help.'').' </data-hint>
                 </abbr>';
            
    echo '</span>';   // CardTop
    if (true) {    
    Pmnu_0(elem:'chead'.$gbl_CardIx.'',capt:'@Applies to all cards:', wdth:'240px',  icon:'fas fa-info', stck:'false', attr:' height: 14px;',cntx:true);
    Pmnu_Item(labl:'@Close cards',     icon:'far fa-rectangle-xmark colrgreen', hint:'@Close all cards',        vrnt:'plain',     name:'m1', clck:'CardHeightAll(`clo`,330);',attr:'',shrt:'');
    Pmnu_Item(labl:'@Minimize height', icon:'fas fa-minus     colrgreen',  hint:'@Minimize all cards height',   vrnt:'plain',     name:'m2', clck:'CardHeightAll(`min`,330)', attr:'',shrt:'');
    Pmnu_Item(labl:'@Small height',    icon:'fas fa-compress  colrgreen',  hint:'@Small height to all cards',   vrnt:'custom',    name:'m3', clck:'CardHeightAll(`sma`,330)', attr:'',shrt:'');
    Pmnu_Item(labl:'@Default height',  icon:'fas fa-check     colrgreen',  hint:'@Default height to all cards', vrnt:'custom',    name:'m4', clck:'CardHeightAll(`def`,330)', attr:'',shrt:'');
    Pmnu_Item(labl:'@Great height',    icon:'fas fa-expand    colrgreen',  hint:'@Great height to all cards',   vrnt:'custom',    name:'m5', clck:'CardHeightAll(`gre`,330)', attr:'',shrt:'');
    Pmnu_Item(labl:'@Maximize height', icon:'fas fa-plus      colrgreen',  hint:'@Maximize all cards height',   vrnt:'plain',     name:'m4', clck:'CardHeightAll(`max`,330)', attr:'',shrt:'');
    Pmnu_Item(vrnt:'separator');                                                                                                                                              
    Pmnu_Item(labl:'@COLLAPSE body', icon:'fas fa-angle-double-up   colrgreen', hint:'@Click to close <i>all</i> cards', vrnt:'plain', name:'m6', clck:'CardHeightAll(`max`,330);', attr:'',shrt:'');
    Pmnu_Item(labl:'@EXPAND body',   icon:'fas fa-angle-double-down colrgreen', hint:'@Click to open <i>all</i> cards',  vrnt:'plain', name:'m7', clck:'CardHeightAll(`max`,330);', attr:'',shrt:'');
    // Pmnu_Item(vrnt:'separator');
    Pmnu_00(/* labl:'@Not working yet',hint:'@Working on it',attr:'padding-top: 2px; text-color:red; text-align:center;' */);
   // Pmnu_00(labl:'<small>No function yet ! </small>',hint:'',attr:'padding-top: 8px; text-color:red;');
    }
    echo '<span id="HideBody'.$gbl_CardIx.'" style="background:'.$gbl_CardsBgrd.'; transition-duration: 1s; 
          max-height:'.($vhgh > '' ? $vhgh : "500px").'; overflow-y: auto; display: block; '.$styl.'">';   // Hide from here ! 
    if ($capt > '') if ($head != '') echo '<hr class="style13" style="margin: 0 0 6px 0;"/>';
    echo '<div class="cardContent" style="text-align: center; margin: 4px; '.$styl.'">'; // width: min-content;">';
    return $prnHtml;
} // htm_Card_0 -   # Cardets < /Card-span>, < /hiding> og < /form> er placeret i htm_Card_00, som skal kaldes til slut!

function htm_Card_00(# labl:'', icon:'', hint:'', name:'', form:'',subm:false, attr:'', akey:'', kind:'save', simu:false)
    $labl='',       # string: Label on the submit button
    $icon='',       # string: Icon left to label
    $hint='',       # string: Hint on hover the submit button
    $name='',       # string: The name of the button to submit
    $form='',       # string: The name of the form to submit
    $subm=false,    # bool:   Submit button shown and active
                    
    $attr='',       # string: Button attributes. Generel use e.g. action= "$link"
    $akey='',       # string: Shortcut to activate the button
    $kind='save',   # string: The button appearance 
    $simu=false     # bool:   Button only simulate
)
{ # MUST follow after htm_Card_0 and card content !
    global $gbl_CardForm;    dvl_pretty('htm_Card_00 ');
    //if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    if ($hint=='') {$hint= '@Remember to save here if you changed anything above, before leaving the window.'; $kind='save';}
    echo '</div>';  $prnHtml= '</div>';  // class="cardContent"
    if ($gbl_CardForm)
        if ($subm==true) {
        echo '<hr class="style13" style= "height:4px;">'.
             '<span class="center" style="height:35px; display: inline-block; position: relative;">';
                     # labl:'', icon:'', hint:'', form:'', wdth:'', attr:'', akey:'', kind:'', rtrn:true, tplc:'LblTip_text', tsty:'', acti:'', idix:'');
        htm_AcceptButt($labl, $icon, $hint, $form, $wdth='', $attr, $akey, $kind='button',$rtrn=false, tplc:'LblTip_N', tsty:'left: auto; top: -65px;');
        echo '</span>';
        }
    echo '</span>'; $prnHtml.= '</span>'; // HideBody to here !
    if ($gbl_CardForm) echo "\n".'</form>'.'<!-- /'.$name.' -->'."\n\n"; //  CardForm-end
    echo '</span>'; $prnHtml.= '</span>'; // Card-end
    return $prnHtml;
} # htm_Card_00

// $CardState= [[ix:1..xx,display:none/block],[...]];

// JS functions to handle Cards:
function CardInit($cardCount) {
    global $CardState;
    echo '<script>';
      /*   for ($Ix=1; $Ix<=$cardCount; $Ix++) { 
            echo '
                var h = document.getElementById("HideBody'.$Ix.'");
                h.style.max-height = "1000px"; ';
               
            }  /* Initiate style to prevent errors */
    echo '
        function CardHeightAll(cmd, def) {';
            for ($Ix=1; $Ix<=$cardCount; $Ix++) {
            echo '
                var h = document.getElementById(`HideBody'.$Ix.'`);
                switch (cmd) {
                  case "clo": h.style.maxHeight = `0px`;      break;
                  case "min": h.style.maxHeight = `200px`;    break;
                  case "sma": h.style.maxHeight = `500px`;    break;
                  case "def": h.style.maxHeight = `${def}px`; break;
                  case "gre": h.style.maxHeight = `1000px`;   break;
                  case "max": h.style.maxHeight = `6000px`;   break;
                  default   : console.log(`Sorry, Wrong parameter: ${cmd}.`);
                }';
            } // for-loop small height      great height
    echo '
        };'; // function

    echo '
        function CardMinimizeAll() {';
        for ($Ix=1; $Ix<=$cardCount; $Ix++) { 
            echo '
                var h = document.getElementById("HideBody'.$Ix.'");
                var p = document.getElementById("card'.$Ix.'");
                h.style.display = "none"; ';
                /* $CardState[$ix]= [$ix,'none']; */
            }
    echo ' }
        function CardMaximizeAll() {';
        for ($Ix=1; $Ix<=$cardCount; $Ix++) { 
            echo '
                var h = document.getElementById("HideBody'.$Ix.'");
                var p = document.getElementById("card'.$Ix.'");
                h.style.display = "block"; ';
                /* $CardState[$ix]= [$ix,'block']; */
            }
    echo ' }
            function CustHelp() {';
        // for ($Ix=1; $Ix<=$cardCount; $Ix++) { echo ' No help for this card yet '; }
        echo ' $("table").trigger("applyWidgets"); }
        </script>';   # Reinit table "zebra": https://mottie.github.io/tablesorter/docs/example-widget-zebra.html
}

function getState() {   // https://bobbyhadz.com/blog/javascript-get-all-elements-by-id-starting-with
                        // https://bobbyhadz.com/blog/javascript-get-css-display-value
    if (false)
        echo 'getState:
    <script>
        console.log(":getState"); 
        /* const elem0 = window.getComputedStyle(elements1[0]); */
        const states = [];

        const elements1 = document.querySelectorAll(`[id^="HideBody"]`);
        elements1.forEach(element => {
            console.log("div.id " + element.id + ".style.display: " + element.style.display);
            states.push(element.style.display);
        });
        console.log(states);
        $("#input_hidden_field").val(states);  //store array
        $.post("", {data: states}).always(function() { /* window.location = "../getState.php"; */ });   
        

        $.ajax({
            type: "POST",
            url: "./getState.json",
            data:{ array : JSON.stringify(states) },
            /* dataType: "json", */
            success: function(data) {
                console.log(data.reply);
                alert(data.reply);
            }
        });
    

/* 
        jsondata = JSON.stringify(states);
        console.log(jsondata); 
        var sendData = function() {
          $.post("../getState.json", {
            data: jsondata
          }, function(response) {
            console.log(response);
          });
        }
        sendData();
*/
        /* console.log(elements1);  */ 
        /* console.log(elements1[0].CSSStyleDeclaration["display"]);  */
        /* console.log("DISPLAY:" + elem0.display); */
        /* elements1[1].style.display = "block"; */
        console.log(":END"); 
        
    </script>';    
}

function CardMin($indx) {
   global $CardState;
   echo '<script> CardMinimize'.$indx.'(); </script>'; $CardState[$indx]= [$indx,'none'];
}
function CardMinimize($last) {
    global $CardState;
    echo '<script> ';
        for ($ix=0; $ix<=$last; $ix++) { 
            echo 'CardMinimize'.$ix.'(); '; $CardState[1+$ix]= [1+$ix,'none']; 
        }
    echo '</script>';
}
function CardRange($frst,$last)  //  Minimize an interval
{   echo '<script> ';
        for ($ix=$frst; $ix<=$last; $ix++) echo 'CardMinimize'.$ix.'(); ';
    echo '</script>';
}
function CardMax($indx) 
{   echo '<script> CardMaximize'.$indx.'(); </script>';
}
function CardOff($frst,$last)    //  Minimize an interval
{   CardRange($frst,$last); 
}
function CardOn($from,$to__=0)  //  Maximize a single or a interval
{   if ($to__<$from) $to__= $from;
    for ($ix=$from; $ix<=$to__; $ix++) CardMax($ix);
}



function htm_wrapp_0(# vhgh:'400px') # WrapperCard
    $vhgh='400px') # WrapperCard - vhgh: ViewHeight
{   echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$vhgh.'; display: block;">'; 
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
function RowColTest( # colr:'gray') 
    $colr= 'gray')
{   if (DEBUG) return ' style="border: 3px solid '.$colr.';"'; else return '';
}

## PROBLEM: This courses topMenu not to stay visibly at page top !
function htm_RowCol_0(# wdth:240)  # ColumnTop // Must be followed/ended of htm_RowColBott()
    $wdth=240)
{  dvl_pretty('htm_RowColTop');      // RowColTop RowCol240, RowCol320 (Look at CSS ! )
    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">'.
         '<data-ColnHead'.RowColTest('yellow').'> <span id="colnwrap" '.RowColTest('green').'> '.
         '<data-RowCol id="RowCol'.$wdth.'" '.RowColTest('blue').' >';
}

function htm_RowCol_next(# wdth:320)  # NextColumn
    $wdth=320) 
{   echo '</data-RowCol> <data-RowCol id="RowCol'.$wdth.'" '.RowColTest('red').'>'; 
}

function htm_RowCol_00()  # ColumnBottom
{   echo '</data-RowCol> </span></data-ColnHead><span class="clearWrap" >'.
         '</div>';
}
## Importent: $RowColWdth - Only use defined width ! (See CSS: @media screen)


function htm_AcceptButt(# labl:'', icon:'', hint:'', form:'', wdth:'', attr:'', akey:'', kind:'', rtrn:true, tplc:'LblTip_text', tsty:'', acti:'', idix:'');
    $labl='',           # string: The caption on the button
    $icon='',           # string: The iconclass ('<i class="fas fa-plus"> </i> ';)
    $hint='',           # string: hint about the button function
                        
    $form='',           # string: The form the element belongs to, if a name is given
                        
    $wdth='',           # string: The width of the button
    $attr='',           # string: Generel use e.g. ' action= "$link" '
                        
    $akey='',           # string: Shortcut to activate the button
    $kind='home',       # string: save, navi, goon, erase, create, home (Appearance)
    $rtrn=false,        # bool:   Act as procedure: Echo result, or as function: Return string
                        
    $tplc='LblTip_text',# string: Class for Placement of the tooltip
    $tsty='',           # string: Style for Placement of the tooltip
    $acti='',           # string: Function to run
    $idix='',           # string: ix-suffix on name/id
    $disa=false         # bolean: 'disabled' to deactivate the button
    )
{   global $gbl_ShortKeys;
    dvl_pretty('htm_htm_AcceptButt');
    // Colors:
    $gbl_ButtnBgrd= '#44BB44';  /* LysGrøn   */     $gbl_ButtnText= '#FFFFFF'; 
    $gbl_BtLnkBgrd= 'yellow';   /* '#FCFCCC';  */   $gbl_BtLnkText= '#000000';
    $gbl_TextLight= 'white';       $gbl_TextDark= 'black';
    $gbl_BtDelBgrd= 'Crimson ';    $gbl_BtDelText= $gbl_TextLight;   # Delete:      RED
    $gbl_BtSavBgrd= '#0064b4';     $gbl_BtSavText= $gbl_TextLight;   # Save/Submit: BLUE
    $gbl_BtNavBgrd= '#269B26';     $gbl_BtNavText= $gbl_TextLight;   # Navigate:    GREEN
    $gbl_BtGooBgrd= '#66CDAA';     $gbl_BtGooText= $gbl_TextDark;    # Continue:    MARINE
    $gbl_BtNewBgrd= 'Orange';      $gbl_BtNewText= $gbl_TextDark;    # CreateNew:   ORANGE
    $gbl_dimmed=    ' opacity:0.8;';


    // Initiate:
    if ($form>'') {$name= $form; $form=' form="'.$form.'" ';} 
    else          {$name= '_none'; }
    if ($wdth) $wdth= ' width: '.$wdth.';';
    if ($icon==='') $iconClass=''; 
    else            $iconClass= '<i class="'.$icon.'"></i>&nbsp;';
    $Label= ucfirst(lang($labl));
    if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    

## Shortcuts:
    $keytip='';
    if ($gbl_ShortKeys) {
        if (!$akey) $keytip=''; else $keytip= '<br><em>'.lang('@Keyboard shortcut: ').$akey.'</em>';
        if ($akey>'') { $akey=' ´<i>'.$akey.'</i>´'; $akey= 'accesskey="'.$akey.'" '; } else $akey='';
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

    default       : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;} $midn= lang($labl);    # navigate-Butt: GREEN
  }
## Action:
    if ($acti=='') {$type='submit';} else {$type='button';}
## Function:
    $result=  '<span class="center" style="height:25px; display: inline-block;">';
    $result.= '<abbr class="hint">';
    $result.= '    <button class="acceptbutt buttstyl" '.$form.' type= "'.$type.'" name="btn_'.$midn.$name.'" id="btn_'.$midn.$name.$idix.'" '.$attr.
              '        style="min-height: 24px; padding-right: 6px; margin-bottom: 6px; '.$wdth. $colors.'" 
                              onclick=\''.$acti.'\' '.$akey.' '.$aktiv.'> '. 
                              $iconClass .$Label.
              '    </button>';
    $result.= '    <data-hint style="'.$tsty.'">'.lang($hint).$keytip.$info.'</data-hint> ';
    $result.= '</abbr> ';
    $result.= '</span>';
    if (!$rtrn) echo $result; else return $result;
} # :htm_AcceptButt()

function htm_ActionButt(# labl:'', icon:'', hint:'', type:'button', name:'', form:'', acti:'', attr:'', rtrn:true)
    $labl='',          # string: Text on the button
    $icon='',       # string: Icon before the label
    $hint='',       # string: Hint about the button function
              
    $type='button', # string: 
    $name='',       # string: The name and id for the button
    $form='',       # string: The form button belongs to
    $acti='',       # string: Function to run
                 
    $attr='',       # string: Button attributes. 
    $rtrn=true      # bool:   return string or echo string
    ) 
{ global $ButtName;
    $ButtName= $name;
    if ($hint>'') {
    $s1= '<abbr class= \'hint\'>';
    $s2= '    <data-hint>'.lang($hint).'</data-hint>
            </abbr>';
    } else {$s1=''; $s2='';};
    $result= $s1. '
                <button class=\'buttstyl\' 
                    type=\''.$type.'\' 
                    id=\''  .$name.'\' 
                    name=\''.$name.'\' '.
                    ($form>'' ? ' form=\''.$form.'\' ' : '').
                    ($acti>'' ? ' onclick=\''.$acti.'\' ' : '').
                    $attr.'>
                    <i class=\''.$icon.'\'> </i> '.lang($labl).
               '</button>
                '.$s2;
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
} # htm_ActionButt()

function htm_IconButt(# labl:'', icon:'', hint:'', type:'submit', name:'', link:'', evnt:'', wdth:'', font:'32px', fclr:'gray', bclr:'white', akey:'', rtrn:false)
    $labl='',       # string: Button label
    $icon='',       # string: Icon before label
    $hint='',       # string: User hint
                
    $type='submit', # string: Button type
    $name='',       # string: Button id / name
                  
    $link='',       # string: formtarget
    $evnt='',       # string: Event script (earlier: $action)
    $wdth='',
    $font='32px',   # string: font-size
    $fclr='gray',   # string: Forground color
    $bclr='white',  # string: Background color
                   
    $akey='',       # string: Keyboard shortcut
    $rtrn=false     # bool:   Function Return or echo
    )
{   global $gbl_ButtnBgrd, $gbl_ShortKeys, $btnix;

    dvl_pretty('htm_IconButt');
    if ($wdth) $wdth= ' width: '.$wdth.';';
    /* if ($gbl_ShortKeys) */ {
        //($akey>'') ? $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; : $keytip=''; ;
        if ($akey) $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; else $keytip='';
        if ($link=='') $targ= 'formtarget="_self"'; 
        else           $targ= 'action="'.$link.'" method="get" formtarget="_self"';
    }
    $btnix++;
    $result = '
    <span class="tooltip" style="display:inline; padding:0; width:200px;">
        <abbr class="hint">
            <form name="zzz" '.($targ ?? '').' style=" display: inline-block; ">
                <button class="buttstyl" type= "'.$type.'" id="'.$name.'" name="btn_ico_'.$btnix.
                 '" style="color:'.$fclr.'; background:'.$bclr.'; '.$wdth.'" accesskey="'.$akey.'" '.$evnt.'>'.
                ' <data-ic class="'.$icon.'" style="font-size:'.$font.'; color:'.$fclr.';  '.$gbl_ButtnBgrd.'; "> </data-ic> '.
                lang($labl). '&nbsp; 
                </button>
            </form>
                <data-hint>'.lang($hint).$keytip.'</data-hint> 
        </abbr>
        '.
    '</span>';
    // if (($font=='32px') or ($rtrn)) echo $result;
    if (!$rtrn) echo $result;
    else return $result;
} # htm_IconButt

function htm_SwitchButt(# labl:'', hint:'',name:'switchbox_id', valu:'', list:[], wdth:'', bclr:'', rtrn:false) 
    $labl='',               # string: Button label
    $hint='',               # string: Hint about the button function
                          
    $name='switchbox_id',   # string: Button name
    $valu='',               # string: Value
    $list=[],               # array:  Setting
                        
    $wdth='',               # string: Width
    $bclr='',               # string: Background color
    $styl='',               # string: Style
    $rtrn=false             # bool:   Function Return or echo result
    )
{   global $gbl_progZoom;       // $valu="(un)pressed"  https://twikito.github.io/easy-toggle-state/#data-toggle-class
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

function htm_SwitchButton(# labl, name:'switchbox_id', valu:'', wdth:'', bclr:'', styl:'', hint:'', list:[], rtrn:false) 
    $labl,  
    $name='switchbox_id',
    $valu='', 
    $wdth='', 
    $bclr='', 
    $styl='', 
    $hint='', 
    $list=[], 
    $rtrn=false           # bool:   Act as procedure: Echo result, or as function: Return string
)
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
} # htm_SwitchButton

function htm_MultistateButt(# name:'ROWyCOLx', valu:'', acti:true, styl:'padding:1px;') 
    $name='ROWyCOLx',       # string: 
    $valu='',               # string: 
    $acti=true,             # bool:   
                          
    $styl='padding:1px;'    # string: 
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
 
function htm_Humantest(# capt:'@Are you human? ', icon:'fa-solid fa-arrow-right-to-bracket', hint:'@Grab and slide to right to change state', 
                        # form:'form-id', wdth:'200px', hght:'30px30px', yclr:'lightcyan', nclr:'white', xytx:'@YES', ntxt:'@NO',$rtrn= false);
$capt= '@Are you human? ',                          # capt $quest= '@Are you human?',
$icon= 'fa-solid fa-arrow-right-to-bracket',        # icon after caption
$hint= '@Grab and slide to right to change state',  # hint $slide_hint= '@Grab and slide to right to change state'
$form= 'form-id',                                   # form $form_id= 'form-id',

$wdth= '200px',                                     # wdth $grab_width= '200px',
$hght= '24px',                                      # hght $grab_height= '30px',
$yclr= 'lightgray',                                 # yclr $yclr= 'lightcyan',
$nclr= 'white',                                     # nclr $no_colr= 'white',
$bclr= '#1bd441',                                   # background in human state

$xytx= '@YES',                                      # xytx $yes_text= '@YES',
$ntxt= '@NO',                                       # ntxt $no_text= '@NO',
$rtrn= false                                        # bool: Act as procedure: Echo result, or as function: Return string
) {
$result= '
<style>
@import url(\'https://fonts.googleapis.com/css?family=Open+Sans\');
.grab-slider-field input {
    display: none;
  }

  .grab-slider-wrapper {
    position: relative;
    width: '.$wdth.';
    height: '.$hght.';
    border: 1px solid gray;
    border-radius: calc('.$hght.' / 2);
    background-color: '.$yclr.';
    border-color: #a2a2a2;
    box-shadow: inset 0 0 3px gray;
    font-family: "Open Sans", sans-serif;
    margin: auto;
  }

  .grab-slider-wrapper:before {
    content: "'.lang($xytx).'";
    position: absolute;
    left: 8px;
    line-height: '.$hght.';
    font-size: 12px;
    z-index: 1;
    color: white;
  }

  .grab-slider-wrapper:after {
    content: "'.lang($ntxt).'";
    position: absolute;
    right: 10px;
    line-height: '.$hght.';
    font-size: 12px;
    z-index: 1;
  }

  .grab-slider {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 2;
    height: calc('.$hght.' - 2px);
    /* width: calc('.$hght.' - 2px); */
    border: 1px solid #111;
    border-radius: calc('.$hght.' / 2);
    cursor: grab;
    background: white;
    border-color: white;
    box-shadow: 0 0 5px gray;
  }


  .grab-slider-wrapper.human {
    background-color: '.$bclr.';
    border-color: '.$bclr.';
    box-shadow: none;
  }
</style>
'; 

// https://codepen.io/aratour/pen/xxbwLMz :
if ($form>'') $result.= ' <form name="'.$form.'" id="'.$form.'">';
    $result.= '    
        <div class="grab-slider-field">
            <div class="grab-slider-wrapper" title="'.lang($hint).'">
                <div class="grab-slider" style="padding: 0 5px; font-size: 12px;">'.
                    '<abbr class= "hint" style="white-space: nowrap;">'.
                        lang($capt). (($icon>'') ? ' <i class="'.$icon.'"></i>' : '').
                        '<data-hint style="left: auto;"> '.
                           lang($hint).
                        '</data-hint>
                    </abbr>'.
                '</div>
            </div>
            <input value="isbot">
        </div>';
if ($form>'') $result.= ' </form>';

$result.= '    
<script>
    var bot = true;
      var captchas = document.getElementsByClassName("grab-slider-wrapper");
      var wrapper, slider;
      for (var i = 0; i < captchas.length; i++) {
        var wrapper = captchas[i];
        var slider = wrapper.children[0];
        var maxleft = wrapper.offsetWidth - slider.offsetWidth - 2;
        slider.addEventListener("mousedown", function() {
          this.addEventListener("mousemove", onmousemove);
          document.addEventListener("mouseup", function() {
            slider.removeEventListener("mousemove", onmousemove);
          });
        });
      }

      function offset(el) {
        var rect = el.getBoundingClientRect(),
          scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
          scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        return {
          top: rect.top + scrollTop,
          left: rect.left + scrollLeft
        }
      }

      function onmousemove() {
        var w_offset = offset(wrapper);
        var left = event.pageX - w_offset.left - this.offsetWidth / 2;
        if (left <= 0) left = 0;
        else if (left >= maxleft) left = maxleft;
        this.style.left = left + "px";
        if (left == maxleft) {
          wrapper.classList.add("human");
          document.querySelector(\'.grab-slider-field input\').value = "notbot";
          bot = false;
        } else {
          wrapper.classList.remove("human");
          document.querySelector(\'.grab-slider-field input\').value = "isbot";
          bot = true;
        }
      }
      document.getElementById(\''. ($form ? $form : 'missing') .'\').addEventListener(\'submit\', function(event) {
        if (document.querySelector(\'.grab-slider-field input\').value != "notbot") {
          event.preventDefault();
          alert(\'Please complete the captcha\');
        }
      });
</script>';
    if (!$rtrn) echo $result; else return $result;
} # htm_Humantest


function htm_Tabs_0(# head:'', styl:'', rtrn:false)
    $head='',
    $styl='', 
    $rtrn=false
)
{   $GLOBALS['TabLabl']='<div class="tab">';
    $GLOBALS['TabBody']='';
    $result= '
        <div style="'.$styl.'">'. 
            $head.
        '</div>';
   if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}
                #$name, $labl='', $body='', $bclr='white', $style='text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;') 
function htm_Tab(# labl:'', body:'', name:'', styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white')
    $labl='',       # string: Tab Label
    $body='',       # string: Content on tab
    $name='',       # string: id
    $styl=          # string: Style
          'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;',
    $bclr='white',  # string: Background color
    $vhgh=''        # ViewHeight (future !)
    ) 
    
{   $b= 'small'; 
    $GLOBALS['TabLabl'].= '
        <button class="tablinks" type="button" title="'.lang('@Show this Tab-content').'" 
        onclick="openTab(event, \''.$name.'\')" 
        style="background-color:'.$bclr.';border-bottom-color: '.$bclr.'; "><'.$b.'>'.lang($labl).'</'.$b.'></button>';
    $GLOBALS['TabBody'].= '
        <div id="'.$name.'" class="tabcontent" style="display: none; background-color:'.$bclr.'; '.$styl.' border-right: 2px solid #aaa;">'. lang($body).'</div>';
}
function htm_Tabs_00(# foot:'', styl:'', rtrn:false)
    $foot='', 
    $styl='', 
    $rtrn=false
    ) 
{   $result= 
        $GLOBALS['TabLabl'].'<span style="float:right;" title="'.lang('@Hide the Tab-content').'" onclick="closeTabs()"><i class="far fa-window-close"></i>&nbsp;<span> </div>'.
        $GLOBALS['TabBody'];
        if ($foot>'') $result.= '<span style="'.$styl.'">'.lang($foot).'</span>';
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}


function htm_LinkButt(# labl:'', hint:'', attr:'', link:'', targ:'_blank', rtrn:false)
    $labl='',       # string: Label
    $hint='',       # string: 
    $attr='',       # string: 
                   
    $link='',       # string: 
    $targ='_blank', # string: 
    $rtrn=false     # bool:   Function Return or echo result
)
{   $result= '<span '.$attr.'><a class="button" href="'.$link.'" target="'.$targ.'" title="'.lang($hint).'">'.lang($labl).'</a></span>';
    if (!$rtrn) echo $result; else return $result;
}

function htm_TextArea(# labl:'', hint:'', name:'area', form:'', valu:'', rows:'1', widt:'', plho:'?', attr:'', rtrn:true) 
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
        '\' style= \'width:'.$widt.'; font-size: 1em; border: 1px solid Gainsboro; border-radius: 4px; margin-top: 10px; '.$attr.'\'>'.$valu.'</textarea>';
    if ($hint > '') 
        $result.= '<abbr class= \'hint\'>'. lang($labl).'<data-hint>'.lang($hint).'</data-hint></abbr>';
    else 
        $result.= lang($labl).$result;
    if (!$rtrn) echo $result; else return $result;
}

function str_WithHint(# labl:'', hint:'', icon:'', $styl);
    $labl='',       # string: Your text
    $hint='',       # string: On-Mouse-over text
    $icon='',       # string: Icon prefix
    $styl=''        # string: Custom style
    ) 
{
    if ($icon>'') $icon= '<i class="'.$icon.'"></i>&nbsp;'; else $icon= '';
    if ($hint>'') return '<abbr class= "hint" style="position: relative;">'.$icon.lang($labl).'<data-hint style="left: auto;'.$styl.'"> '.lang($hint).' </data-hint></abbr>';
    else          return $icon.lang($labl);
}


// echo $htm_ModalDialog; Initiated in htm_Page_0 ($htm_ModalDialog)
function htm_ModalDialog(# type:'none', capt:'@Voilà!', mess:'', butt:['$type','$icon','$labl','$hint','$link'], html:'CSS-based Modal Dialog', rtrn:true) 
    $type='none', # Variant
    $capt='@Voilà!',
    $mess='',
    $butt=['$type','$icon','$labl','$hint','$link'],
    $html='CSS-based Modal Dialog',
    $rtrn=true
) // https://codepen.io/timothylong/pen/AJxrPR
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
                <h3  id="header" style="background-color: '.$css_Box[$type][1].'; font-weight:600;">'.lang($capt).'</h3>
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
    if (!$rtrn) echo $result; else return $result;
} // htm_ModalDialog


function htm_Dialog(# capt:'CAPTION', content:'', bclr:'lightyellow', buttons: // []) # Modal dialog:
    $capt='CAPTION', 
    $content='', 
    $bclr='lightyellow', # Background color
    $buttons= [ ['confirmBtn','default','@Confirm','fas fa-check','green','@Accept and go on'],   // (0:id, 1:value, 2:label, 3:icon, 4:hint) 
                ['',          'cancel', '@Cancel', 'fas fa-minus-circle','red','@Break and return']
              ]
)  // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog
{   $result= '<dialog id="htmDialog" style="padding:5px; background-color:lightcyan; border-radius: 6px;">
        <form  name="yyy" method="dialog">
            <div style="background-color:'.$bclr.'; padding:4px;">'.lang($capt).'</div>
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

function msg_Dialog($vrnt='error', $caption='@User Dialog', $mess='', $Buttons= [
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
switch (strtolower($vrnt)) {  # BG-olors and Hint-prefix:
    case "error"  : $headColr= '#FF8888'; $pref= ucfirst(lang('@Error: ')); break;   # color: red
    case "info"   : $headColr= '#BDE5F8'; $pref= ucfirst(lang('@Info: '));  break;   # color: blue
    case "warn"   : $headColr= '#FEEFB3'; $pref= ucfirst(lang('@Warn: '));  break;   # color: orange
    case "tip"    : $headColr= '#88ff22'; $pref= ucfirst(lang('@Hint: '));  break;   # color: green
    case "success": $headColr= '#DFF2BF'; $pref= ucfirst(lang('@Bingo: ')); break;   # color: light-green
    default       : $headColr= $vrnt;     $pref= ''; # Custom color for non-standard types
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
} // msg_Dialog()


/* 
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
 */
 
// Afhængig af: msg_lib.css.php   -   Afløser for msg_Dialog()
function msg_System($vrnt= 'error', $capt='',  $body='', $mess='', $list=['goback','goon','close'], $wdth='600px', $rtrn=false) # $type:'error'|'info'|'warn'|'hint'|'success'|'#color'
{ ## INIT:
    $capt= ucfirst(lang($capt ?? 'PHP2HTML'));
    $body= ucfirst(lang($body ?? '<p>Info about the system.</p>'));
    $mess= ucfirst(lang($mess ?? lang('<p>This is a CSS based modal dialog independent of jquery that can be used to display information.').'<br><br>'.
                                 lang('The window can be closed with the \'x\' icon, or by clicking anywhere outside the window.').' <br>'.
                                 lang('The buttons in the footer can be programmed, with optional code.</p>')));
  ## CODE:
    switch (strtolower($vrnt)) {  # TEMA-farver og Titel-prefix:
        case "error"  : $headColr= '#FF8888';    # color: red
                        $pref= ucfirst(lang('@Error: '));   $Capt1= lang('@Tracking');  
                                                            $Capt2= lang('@Explanation'); break;
        case "info"   : $headColr= '#BDE5F8';    # color: blue
                        $pref= ucfirst(lang('@Info: '));                                  break;
        case "warn"   : $headColr= '#FEEFB3';    # color: orange
                        $pref= ucfirst(lang('@Warning: ')); $Capt1= lang('@Oops');        break;
        case "hint"   : $headColr= '#88ff22';    # color: green
                        $pref= ucfirst(lang('@Hint: '));    $capt1='';                    break;
        case "success": $headColr= '#DFF2BF';    # color: light-green
                        $pref= ucfirst(lang('@Hurray: '));                                break;
        default:  $headColr= $vrnt; $pref= ''; //  Custom color and without prefix
    } 
    $result = '<label class="button demo-button" for="open-modal"> </label>'.               // The way to toggle the modal is to check the hidden checkbox with the ID #open-modal "Open The Modal"
              '<div class="modal__container">'.                                             // label: class="button demo-button hidden" to hide toggle checkbox
              '  <input type="checkbox" id="open-modal" class="modal__toggler" checked />'. // Here is the hidden checkbox element which makes toggling the modal work 
              '  <label class="modal__mask" for="open-modal"></label>';                     // Here is the background mask. When clicked, it closes the modal. Change this to a div to disable that functionality. 
    $result.= '  <div class="modal" style="width: '.$wdth.'; margin: 0 auto; ">'.
              '    <label class="modal__close" for="open-modal"></label>'.
              '    <div class="modal__header" style="background-color: '.$headColr.';">'.
              '      <h3 style="margin:8px;">'.$pref.$capt.'</h3>'.
              '    </div>'.
              '    <section class="modlwrap">';
    if ($body>' ')  
        $result.= '<div class="modal__content" style="width:25%; float: left; background:lightcyan; text-align:left; word-wrap: break-word; ">
                   <div style="font-weight:600;">'.($Capt1 ?? '').':</div><samp><small>'.$body.'</small></samp>'.'<br><br></div>';
    $result.= '      <div class="modal__content" style="width:60%; float: right; background:lightyellow; text-align:left; word-wrap: break-word; ">
                     <div style="font-weight:600;">'.($Capt2 ?? '').':</div><var>'.$mess.'</var>'.'<br><br></div>'.
              '    </section> '.
              '    <div class="modal__footer" style="background-color: '.$headColr.'; ">';
    if (in_array('goback',$list)) $result.= '<label class="modlButt" for="open-modal"  title="'.lang('@Close the window and return to the previous screen').'">'.lang('@Undo').' </label>';
    if (in_array('goon',  $list)) $result.= '<label class="modlButt" for="open-modal"  title="'.lang('@Close the message-window and continue').'">'.lang('@Continue').' </label>';
    if (in_array('accept',$list)) $result.= '<label class="modlButt" for="open-modal"  title="'.lang('@Confirm and continue').'">'.lang('@Accept').' </label>';
    if (in_array('close', $list)) $result.= '<label class="modlButt" for="open-modal"  title="'.lang('@Close the window!').'">'.lang('@Close')    .' </label>';
    //  $result.= '      <script> ';
    //  $result.= '        function goBack() { window.history.back() } ';
    //  $result.= '        function winclose() { open(location, "_self").close() } ';
    //  $result.= '      </script>';
    //  $result.= '      <button type="button" style="border-radius: 5px; height:20px;" onclick="goBack()">Fortryd</button> ';
    //  $result.= '      <button type="button" style="border-radius: 5px; height:20px;" disabled> Godkend </button> ';
    //  $result.= '      <button type="button" style="border-radius: 5px; height:20px;" onclick="winclose()"> OK </button> ';
    $result.= '    </div>'.
              '  </div>'.
              '</div>';
    if (!$rtrn) echo $result; else return $result;
} // msg_System()


//       Pmnu_Prepare:
function Pmnu_0(# elem:'id', capt:'', wdth:'210px', icon:'', stck:'false', attr:'background-color:lightcyan;', cntx:true, rtrn:false) 
                 $elem='id',$capt='',$wdth='210px',$icon='',$stck='false',$attr='background-color:lightcyan;',$cntx=true,$rtrn=false) // Note: $elem is used to link to the calling element
{ // Create jsCode:
if (DEBUG) return false;
    $result= "
    <script>".
    "let ".$elem." = document.getElementById(\"".        $elem."\"); "; // link to single id object
 // "let ".$elem." = document.getElementsByClassName(\"".$elem."\"); "; // link to multible class objects
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

//      function Pmnu_Item($type='plain',$labl='',$hint='',$icon='',$id='',$click='',$attr='',$short='',$enbl='true',$rtrn=false) 
function Pmnu_Item(# labl:'', icon:'', hint:'', vrnt:'plain', name:'', clck:'', attr:'', akey:'', enbl:'true', rtrn:false) 
                    $labl='',$icon='',$hint='',$vrnt='plain',$name='',$clck='',$attr='',$shrt='',$enbl='true',$rtrn=false) 
{ // Create jsCode:
if (DEBUG) return false;
    $result= '
    {label: "'.lang($labl).'", hint: "'.lang($hint).'", cssIcon: "'.$icon.'"';    // or imgIcon !
        switch ($vrnt) {
            case 'plain'    : $result.= ', shortcut: "<small>'.$shrt.'</small>", id:"'.$name.'", name:"'.$name.'", onClick: () => {'.$clck.'} '; break;  
            case 'custom'   : $result.= ', shortcut: "'.       $shrt.'", id:"'.        $name.'", name:"'.$name.'", onClick: () => {'.$clck.'} '; break;
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
            default         : $result.= 'Type parameter ERROR: '.$vrnt;
        }
    if (!in_array($vrnt,['multi','hovermenu','submenu','subitem','end_sub']))
        $result.= '},'; // ?:  '],';
    if (!$rtrn) echo $result; else return $result;
} // Pmnu_Item

function Pmnu_00(# labl:'',hint:'',attr:'',rtrn:false) 
    $labl='',
    $hint='',
    $attr='',
    $rtrn=false
) 
{ // Create jsCode:
if (DEBUG) return false;
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
    if ($rtrn) return $result; else  echo $result; 
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

{ ## Group ******************** htm_Menu: **************************


function htm_Menu_TopDown(# capt:'Clever html engine', data:[], foot:'', styl:'', widt;150px, note;'')
$capt='Clever html engine', # string: Title at left
$data,                      # array:  Data for the meny
$foot='PHP2HTML',           # string: Note at right
$styl='',                   # string: Aditional style to default style
$widt='150px',              # string: Widths of menu columns. NOT used yet !
$note=''
)
{
    /* function MenuBran($pref='', $vrnt='', $icon='', $labl='', $hint='', $desc='', $link='', $subm=[], $styl='', $widt) { 
    echo '
    <span style="display:inline-block; width:'.$widt.'; padding:2px; text-align:'.($pref=='' ? 'center' : 'left').
        '; background:lightgray; color:white;">
        &nbsp;'. (($icon > '')  ? '<data-ic class="'.$icon.' fa-fw" style="font-size:16px;"></data-ic>' : ''). 
       '<a href="'.$link.'" target=_self style="text-decoration: none; onhover {text-decoration: underline;}">'.lang($labl).'</a>'.
    '</span>';
    } */
    /*
    echo '<div onmouseover="desc_div(`wide`, `'.$capt.'`, `'.$widt.'`)" onmouseout="desc_div(`narrow`, `'.$capt.'`, `'.$widt.'`)"
           style="text-align:left; background:#fafafa; opacity: 0.9; 
           border: 1px solid lightgray; border-radius: 4px; padding:2px; width:max-content; z-index: 1000;
           position:relative; top:0; margin-left:auto; margin-right:auto;'.$styl.'">';

     echo '
     <ul style="list-style-type: none;">';
     if ($capt>'') echo '<span class="mnu_heads";>'.lang($capt).'&nbsp;<br></span>';
     foreach ($data as $item)
         { /* echo '<li style="float: left;">';  * / // Toplevel;
        //         0          1        2         3         4         5         6         7         8                9
        MenuBran($pref='', $item[0], $item[1], $item[2], $item[3], $item[4], $item[5], $item[6], ($item[7] ?? ''),$widt);
        /*  echo '</li>'; * /
        if (count($item[6])>0) { echo '
        <ul>'; // Sublevel;
            foreach ($item[6] as $xx) {
                echo '
                <li style="list-style-type: none;>';
                    MenuBran($pref='',$xx[0],$xx[1],$xx[2],$xx[3],$xx[4],$xx[5],$xx[6],$xx[7],$widt);
                echo '
                </li>
                ';
            }
        echo '
        </ul>';
        }
     };
    if ($foot>'') echo '<span class="mnu_heads";>&nbsp;'.lang($foot),'<span>'; 
    echo '
    </ul>';
     
    echo '</div>';
 */
    if (!function_exists('subMenu')) {
    function subMenu($i) {
        if ($i[1]>'') $ic= '<data-ic class="'.$i[1].' fa-fw" style="font-size:16px;"></data-ic>'; else $ic= '';
        echo '<abbr class= "hint " style="background-color:yellow;">
             <a href="'.$i[5].'">'.
                $ic. lang($i[2]).
             '</a>';
            if (($i[3]>'') or ($i[4]>'')) echo 
                '<data-hint style="left: 150px; top: 18px; /* z-index:1001; */ overflow:visible;"> '.
                    ( $i[3]>'' ? lang($i[3]) : lang($i[4]) ).
                ' </data-hint>';
        echo '</abbr>';
    }
    }
    # htm_Menu_TopDown:
    /* if ($styl>'')  */echo '<style> body { padding-top: 0; margin-top:0; } </style>'; # Allow menu to be placed at window top
        // Data(0:vrnt='', 1;icon='', 2:labl='', 3:hint='', 4:desc='', 5:link='', 6:subm=[], 7:styl='')
    echo ' <span>';
    echo '<div class="topnav bgcldark" id="htmTopnav" style="width: max-content; padding-right: 20px;
            border: 2px solid lightgray; border-radius: 4px;
            margin-left: auto; margin-right: auto; position: sticky; top: 0; z-index:999; ">';
    $ac= 'btnactive'; $bgstyl='';
    $heading= true;
    if ($heading==true)
        if ($capt>'') echo '<div class="mnu_heads">'.lang($capt).'</div>';
    foreach ($data as $item) {
        if ($item[1]>'') $ic= '<data-ic class="'.trim($item[1]).' fa-fw" style="font-size:16px;"></data-ic>'; else $ic= '';
        { echo '
            <div class="dropdown">
                <abbr class= "hint menulabl" >
                    <button class="dropbtn '.($ac=='btnactive' ? 'btnactive' : ''). 
                        '" onclick="window.location.href=\''.$item[5].'\'" '.$bgstyl.'>'.
                        $ic. lang($item[2]). ($item[6] != [] ? ' <i class="fa fa-caret-down"></i>' : '').
                    '</button>';
                    if ($item[3]>'') echo '
                    <data-hint style="left: 50px; top: 5px; overflow:visible;">'.
                        lang($item[3].' '.$item[4]).
                    '</data-hint>';
                echo '
                </abbr>
                <div class="dropdown-content">';
                foreach ($item[6] as $it) subMenu($it);
                echo '
                </div>
            </div> ';
        }
        if ($ac>'') { $ac=''; $bgstyl='style="background-color: inherit;"'; }
    }
    echo '<a href="javascript:void(0);" style="font-size:17px; background-color:#333; padding:2px;" 
                                        class="icon" onclick="TopnavResp()">&#9776;</a>'; // Burgermenu
    if ($heading==true) 
        if ($foot>'') echo '<span class="mnu_heads">'.lang($foot),'<span>'; 
    echo '
    </div>';
    if ($note>'') echo '<br><br><span style="background:transparent; top:-16px; position:relative; ">'.lang($note),'<span>'; 
    echo ' </span>';
    
    echo '
    <script>
        function TopnavResp() {
          var x = document.getElementById("htmTopnav");
          if (x.className === "topnav") {
            x.className += " responsive";
          } else {
            x.className = "topnav";
          }
          const heads  = document.getElementsByClassName("mnu_heads");
          for (let i = 1; i < heads.length; i++) {
            if (x.className === "topnav") heads[i].style.display = "none"; 
            else                          heads[i].style.display = "inline"; 
        }
    }
    
    var btnContainer = document.getElementById("htmTopnav");    // Get the container element
    var btns = btnContainer.getElementsByClassName("btn");      // Get all buttons with class="btn" inside the container
    for (var i = 0; i < btns.length; i++) {                     // Loop through the buttons and add the active class to the current/clicked button
        btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
      });
    }
    </script>
    ';
} # htm_Menu_TopDown



function htm_Menu_Leftout(# $capt='Clever html engine', $data, $foot='', $styl='')
$capt='Clever html engine', # string: Title at top
$data,                      # array:  Data for the menu
$foot='',                   # string: Note at bottom
$styl='',                   # string: Aditional style to default style
$widt='180px'               # string: Widths of menu columns
)
{ //                    0          1        2         3         4         5         6         7         8         9
    function MenuLine($pref='', $vrnt='', $icon='', $labl='', $hint='', $desc='', $link='', $subm=[], $styl='', $widt) {
        echo                                                                        # pref; string - Prefix (indent) for submenu
        '<br><span>'.                                                               # vrnt: string - Variant not in use (Frst/Next/Last)
            '<span class= "iconlabl" '.                                             # icon: string - icon class        
             'style="width:'.$widt.'; display:inline-block;;">'.$pref;              # labl: string - Alays visible
                                                                                    # hint: string - Visible on mouseover lable
            if ($icon>'') echo                                                      # desc: string - Visible on mouseover menu
            '<data-ic class="'.$icon.' fa-fw" style="font-size:16px;"></data-ic>';  # link: string - url / href
                                                                                    # subm: array  - Data for submenu
            echo                                                                    # styl: string - Override style for hint position
            '<abbr class= "hint menulabl" >                                                             
                <a href="'.$link.'" target=_self style="text-decoration: none; color: white; onhover {text-decoration: underline;}">'.
                    lang($labl).
                '</a> ';  
                if ($hint>'') echo
                '<data-hint style="left: auto; left: 150px; top: 45px; '.$styl.'"> '.lang($hint).' </data-hint>';
            echo
            '</abbr>
            </span>';
            if ($desc>'') echo '
            <span class="desc_div"; style="max-width:'.$widt.'; /* left: 180px; */ position: revert; display: inline-block; 
                vertical-align: top; font-size:smaller;">'.
                lang($desc).
            '</span>';
       echo '
       </span>';
    } // MenuLine
    
    echo '<div onmouseover="desc_div(`wide`, `'.$capt.'`, `'.$widt.'`)" onmouseout="desc_div(`narrow`, `'.$capt.'`, `'.$widt.'`)"
           style="text-align:left; background:#fafafa; opacity: 0.9; background-color: var(--darkBcgrd); color: white;
           border: 2px solid lightgray; border-radius: 4px; padding:5px; width:max-content; z-index: 1000;
           position:fixed; top:28px; left:15px;'.$styl.'">';

     if ($capt> '') echo '<span class="mnu_heads"; style="width:94%;">'.lang($capt).'<hr><br></span>';
     if ($capt=='') echo '<div class="mnu_heads";>'. lang('@Menu:').'</div>';
     echo '<br>';
     foreach ($data as $top) {          // TopMenu:
        MenuLine($pref='', $top[0], $top[1], $top[2], $top[3], $top[4], $top[5], $top[6], ($top[7] ?? ''),$widt);
        if (count($top[6])>0)
            foreach ($top[6] as $sub)   // SubMenu:
                MenuLine($pref=' &nbsp; &nbsp; ',$sub[0],$sub[1],$sub[2],$sub[3],$sub[4],$sub[5],$sub[6],$sub[7],$widt);
     };
    if ($foot>'') echo '<br><span class="mnu_heads"; style="width:94%;"><hr>'.lang($foot),'<span>'; 
    echo '</div>';
} // htm_Menu_Leftout

// Hide parts of menu:
$jsScripts.= '<script>
function desc_div(state, capt, widt) {
    const labels = document.getElementsByClassName("menulabl");
    const bodyes = document.getElementsByClassName("desc_div");
    const heads  = document.getElementsByClassName("mnu_heads");
    const iclbl  = document.getElementsByClassName("iconlabl");
    for (let i = 0; i < bodyes.length; i++) {
      if (state == "narrow") { 
          heads[0].innerHTML = "Menu:<br>";
          heads[0].outerHTML = "<span class=\"mnu_heads\" ;=\"\" style=\"width:;\">Menu:<br></span>";
          iclbl[i].style.width = "max-content";       
          labels[i].style.display = "none";         
          bodyes[i].style.display = "none";          
      } else { 
          heads[0].innerHTML = capt + "<br><hr>";
          heads[0].outerHTML = "<span class=\"mnu_heads\";\" style=\"width:94%;\">" + capt + "<br><hr></span>";
          iclbl[i].style.width = widt; 
          labels[i].style.display = "inline-block"; 
          bodyes[i].style.display = "inline-block";  
      }
    }
    for (let i = 1; i < heads.length; i++) {
        if (state == "narrow") heads[i].style.display = "none"; 
        else                   heads[i].style.display = "inline"; 
    }
}
</script>';

} ## Group ******************** /htm_Menu **************************

{ ## Group ******************** htm_Page: **************************

function htm_Page_0(# titl:'', hint:'', info:'', inis:'', algn:'center', imag:'', attr:'', pbrd:true) 
    $titl='',           # string: Page title
    $hint='',           # string: Page tip  (vertical text - left)
    $info='',           # string: Page into (vertical text - right)
    $inis='',           # string: Initial CSS/js script in page header

    $algn='center',     # string: align - "text-align"
    $imag='',           # string: Page background-image
    $attr='',           # string: Page attributes
    $pbrd=true          # bool:   Draw border around the page body-div
    )
{ # Prepare / initialize a page  # Must be followed of htm_Page_00() to finalise the page
    global $gbl_ProgRoot, $CSS_system, $gbl_TitleColr, $cardCount, $pbrd,$gbl_progZoom, $jsScripts, $headEndScript, $gbl_progDesti, $gbl_copyright;
    $pageMess= '<b>ERROR:</b> ';
// Library_state: 0:inactive - 1:Offline (from /_assets) - 2:Online (from CDN)
// libraries: jQuery-latest, Dialog-polyfill, TableSorter, ContextMenu, (popMnu_) ctxP_ Menu

/* in project.inc.php (globaly) or in *.page.php files (individualy) PLACE THE FOLLOWING LINES:
## Library selector: Activate needed libraries.
//      ConstName:          ix:   LocalPath:                         CDN-path:   ( https://cdnjs.com: 2023-09-02)                                                         // File:
define('LIB_JQUERY',        [0, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/']);               // jquery/3.6.3/jquery.min.js
define('LIB_JQUERYUI',      [0, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jqueryui/1.13.2/jquery-ui.min.js
define('LIB_TABLESORTER',   [0, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_POLYFILL',      [0, '_assets/dialog-polyfill/latest/',  'https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.5.6/']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  ' Not in use ']);      
define('LIB_FONTAWESOME',   [0, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/']);
define('LIB_TINYMCE',       [0, '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.0/']);              // tinymce.min.js
define('LIB_SWITCHBOX',     [0, '_assets/',  ' Not in use ']);
define('LIB_POPUPSYSTEM',   [0, '_assets/',  ' Not in use ']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN
*/

if (false) {
    // include '../_assets/phpqrcode/qrlib.php';       // Include the qrlib file
    include '../_assets/chillerlan/QRCode.php';        // Include the qrlib file
}

// <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    echo '<!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="'.$gbl_progDesti.'">
    <meta name="author" content="'.$gbl_copyright.'">
    <meta name="robots" content="Noindex, Nofollow">'.  // Reject robots
   '<meta name="googlebot" content="Noindex">'.         // Reject robots
   '<title>'.lang($titl).'</title>'. "\n";  
    dvl_pretty('htm_Page_0');


### ----------------------Library-dialog-polyfill-------------------------
    if (defined('LIB_POLYFILL')) {
        switch(LIB_POLYFILL[0]) {
            case 0 : $path= '';                             break;  # Not active
            case 1 : $path= $gbl_ProgRoot.LIB_POLYFILL[1];  break;  # Local-folder
            case 2 : $path=               LIB_POLYFILL[2];  break;  # CDN-server  :https://
           default : { $pageMess.= 'LIB_POLYFILL: illegal index ! '; }
        }
        if ($path > '') {
            echo '<script src="'.$path.'dialog-polyfill.js"></script>';
            echo '<link rel="stylesheet" href="'.$path.'dialog-polyfill.css"/>';
            run_Script("var dialog = document.querySelector('dialog');
                        dialogPolyfill.registerDialog(dialog);    // Now dialog always acts like a native <dialog>.
                        dialog.showModal(); ");
            
            run_Script("function phpDialog(capt='CAPTION', content='Content') 
                { var result= <?= htm_Dialog(capt, content); ? > return result; }");
        //        { alert(\"<?php echo htm_Dialog(capt, content); ? >\"); }");
            }
    } else 
    { define('LIB_POLYFILL', [0, '', '']); /* $pageMess.= ' dialog-polyfill is not loaded  ! <br>'; */ }
/* 
if (LIB_POLYFILL[0]==1) {
    $path= $gbl_ProgRoot.'_assets/dialog-polyfill/';      // To get Firefox and other browsers to support <dialog>
    echo '<script src="'.$path.'dialog-polyfill.js"></script>';
    echo '<link rel="stylesheet" href="'.$path.'dialog-polyfill.css"/>';
    run_Script("var dialog = document.querySelector('dialog');
                dialogPolyfill.registerDialog(dialog);    // Now dialog always acts like a native <dialog>.
                dialog.showModal(); ");
    
    run_Script("function phpDialog(capt='CAPTION', content='Content') 
        { var result= <?= htm_Dialog(capt, content); ? > return result; }");
//        { alert(\"<?php echo htm_Dialog(capt, content); ? >\"); }");
} */
### ----------------------

### ----------------------Library-jQuery-------------------------
### jQuery-latest:  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js
//                  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js 
//                  https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js
//                  https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css
//                                          _assets/jquery/*********************************

    if (defined('LIB_JQUERY')) {
        switch(LIB_JQUERY[0]) {
            case 0 : $path= '';                             break;  # Not active
            case 1 : $path= $gbl_ProgRoot.LIB_JQUERY[1];    break;  # Local-folder
            case 2 : $path=               LIB_JQUERY[2];    break;  # CDN-server  :https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery.min.js
           default : { $pageMess.= 'LIB_JQUERY: illegal index ! '; }
        }
        if ($path > '') {
            echo '<script src="'.$path.'jquery.min.js"></script>';              //  topic="Tablesorter-system" and Topmenu-system      
        } 
    } else 
    { define('LIB_JQUERY', [0, '', '']); $pageMess.= ' jQuery is not loaded  ! <br>'; }

    if (defined('LIB_JQUERYUI')) {
        switch(LIB_JQUERYUI[0]) {
            case 0 : $path= '';                             break;  # Not active
            case 1 : $path= $gbl_ProgRoot.LIB_JQUERYUI[1];  break;  # Local-folder
            case 2 : $path=               LIB_JQUERYUI[2];  break;  # CDN-server  :https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js
           default : { $pageMess.= 'LIB_JQUERYUI: illegal index ! '; }
        }
        if ($path > '') {
        echo '<script src="'.$path.'jquery-ui.min.js"></script>';               //  topic="Tablesorter-system" and Topmenu-system
        // echo '<link  href="'.$path.'jquery-ui.min.css" rel="stylesheet" />'; //  topic="jquery Dialog"> 
        // 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/'
        // echo '<link  href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.css" />';    // topic="jquery Dialog"> 
        } 
    } else 
    { define('LIB_JQUERYUI', [0, '', '']); $pageMess.= ' jQuery-ui is not loaded  ! <br>'; }
### ----------------------

### ----------------------Library-Tablesorter-------------------------
    if (defined('LIB_TABLESORTER')) {
        if (array_key_exists(0, LIB_TABLESORTER))
            if (LIB_TABLESORTER[0]>0) {                                                 # if library activated
                if (LIB_TABLESORTER[0]==1)  $path= $gbl_ProgRoot.LIB_TABLESORTER[1];    # Local-folder
                else                        $path=               LIB_TABLESORTER[2];    # CDN-server 
            echo '<script src="'.$path.'js/jquery.tablesorter.js"></script>';                      // topic="Tablesorter-system" - required
            echo '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.min.js"></script>';     // topic="Tablesorter-system - parsers"
            echo '<script src="'.$path.'js/parsers/parser-input-select.min.js"></script>';         // topic="Tablesorter-extra"
            echo '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>';
            echo '<link  href="'.$path.'css/theme.blue.css" rel="stylesheet" />';     
            // topic="Tablesorter-system" (choose a theme file)
        } /* else {
            define('LIB_TABLESORTER',       [0, '', '']);
            $pageMess.= ' Tablesorter is not loaded ! <br>';
        } */
    } 
    else {
//$path= './../_assets/tablesorter/';
    $path= $gbl_ProgRoot.'_assets/tablesorter/';
// Tablesorter script: required
    echo '<script src="'.$path.'js/jquery.tablesorter.js"></script>';                   // topic="Tablesorter-system"
//  echo '<script src="'.$path.'js/widgets/widget-filter.js"></script>';                // topic="Tablesorter-system"
//    echo '<script src="'.$path.'js/widgets/widget-stickyHeaders.js"></script>';       // topic="Tablesorter-system"
    echo '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.min.js"></script>';  // https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/parsers/parser-input-select.min.js
                                                                                           
    echo '<script src="'.$path.'js/parsers/parser-input-select.min.js"></script>';      // topic="Tablesorter-extra"
    echo '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>';              
    echo '<link rel="stylesheet" href="'.$path.'css/theme.blue.css"/>';                 // topic="Tablesorter-system" (choose a theme file)
    }
    
    // $lateScripts= '';   // To be run before >/body>
//    echo "//    echo "

if (!(defined('LIB_FONTAWESOME[0]') && array_key_exists(0, LIB_FONTAWESOME) && (LIB_FONTAWESOME[0]==0) )) 
    // $doNothing = ""; else
    $jsScripts.= "
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
        alert("The clone button was clicked.");
        var $table= $(this).closest("table");
        var clone = $("$table .row:first").clone().appendTo("$table");
        // INFO: Indsætter som sidste række, en kopi af 1. række
        // Bedre: Indsætter herunder en kopi, af aktuel række
        // window.alert("Insert as last row, a copy of the 1. row");
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
        document.getElementById("pwPoint" + input.id).value = point;
    /*  document.getElementById("mtPoint" + input.id).innerHTML = point;  */
    }
'.
"   function togglePassword(input,butt) {
        var passInput = document.getElementById(input.id);
        var togglePW  = document.getElementById(butt.id);
        if (passInput.type  == 'password')
            { passInput.type = 'text';      togglePW.innerHTML = '<i class=\'far fa-eye-slash fa-fw colrred\'>'; } else
            { passInput.type = 'password';  togglePW.innerHTML = '<i class=\'far fa-eye fa-fw colrgreen\'>'; }
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
### ----------------------
/* 
run_Script("
/* https://css-tricks.com/value-bubbles-for-range-inputs/ * /
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
        /* bubble.style.left = `calc(${pctVal}% + (${8 - pctVal * 0.15}px))`;  
        // Sorta magic numbers based on size of the native UI thumb * /
        "
    }
");
 */
$sys_Style= "
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
        .bgcldark   {background-color: #333;}

        .font14     {font-size: 14px;}
        .font16     {font-size: 16px;}
        .font18     {font-size: 18px;}
        .font20     {font-size: 20px;}
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
        font-family: sans-serif;
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
        
    <style> <!-- htm_Menu_TopDown -->
    
    .topnav {
        overflow: hidden;
        background-color: var(--darkBcgrd); /* #333 */
        position: sticky;
        top: 0;
    }

    .topnav a {
      float: left;
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 6px 12px;
      text-decoration: none;
    }

    .btnactive {
      background-color: #333;  /* #04AA6D; */
      color: white;
    }

    .topnav .icon {
      display: none;
    }

    .dropdown {
      float: left;
      overflow: hidden;
      background-color: var(--darkBcgrd); /* #333; */
    }

    .dropdown .dropbtn {
      border: none;
      outline: none;
      color: white;
      padding: 6px 12px;
      /* background-color: inherit; */
      font-family: inherit;
      margin: 0;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }

    .dropdown-content a {
      float: none;
      color: black;
      padding: 8px 12px;
      text-decoration: none;
      display: block;
      text-align: left;
    }

    .topnav a:hover, .dropdown:hover .dropbtn {
      background-color: #555;
      color: white;
    }

    .dropdown-content a:hover {
      background-color: #ddd;
      color: black;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    @media screen and (max-width: 640px) {
      .topnav a:not(:first-child), .dropdown .dropbtn 
      {
        display: none;
      }
      .mnu_heads {
          display: none;
      }
      .topnav a.icon {
        float: right;
        display: block;
      }
    }

    @media screen and (max-width: 640px) {
      .topnav.responsive {position: relative;}
      .topnav.responsive .icon {
        position: absolute;
        right: 0;
        top: 0;
      }
      .topnav.responsive a {
        float: none;
        display: block;
        text-align: left;
      }
      .topnav.responsive .dropdown {float: none;}
      .topnav.responsive .dropdown-content {position: relative;}
      .topnav.responsive .dropdown .dropbtn {
        display: block;
        width: 100%;
        text-align: left;
      }
    }
    </style>
        
";  // $sys_Style


if (defined('LIB_SWITCHBOX{[0]') && array_key_exists(0, LIB_SWITCHBOX) && (LIB_SWITCHBOX[0]==0) ) 
     $switchbox_style = ""; 
else $switchbox_style= "
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
	/* padding: 2em; */
	background: #e6e8ea;
	/* font-size: 1.125em; */
	line-height: 1.5;
}
    </style> <!-- ctxP_ -->
    
";  // $switchbox_style


?>

<script>
/*! easy-toggle-state v1.16.0 | (c) 2020 Matthieu Bué <https://twikito.com> | MIT License | https://twikito.github.io/easy-toggle-state/ https://twikito.github.io/easy-toggle-state/#examples */
!function(){"use strict";const t=document.documentElement.getAttribute("data-easy-toggle-state-custom-prefix")||"toggle",e=(e,r=(()=>t)())=>["data",r,e].filter(Boolean).join("-"),r=e("arrows"),i=e("class"),n=e("class-on-target"),s=e("class-on-trigger"),a="is-active",o=e("escape"),u=e("event"),c=e("group"),l=e("is-active"),g=e("modal"),d=e("outside"),h=e("outside-event"),A=e("radio-group"),b=e("target"),f=e("target-all"),$=e("target-next"),v=e("target-parent"),m=e("target-previous"),E=e("target-self"),w=e("state"),p=e("trigger-off"),y=new Event("toggleAfter"),k=new Event("toggleBefore"),L=(t,e)=>{const r=t?`[${t}]`:"";if(e)return[...e.querySelectorAll(r)];const a=[`[${i}]${r}`,`[${s}]${r}`,`[${n}][${b}]${r}`,`[${n}][${f}]${r}`,`[${n}][${$}]${r}`,`[${n}][${m}]${r}`,`[${n}][${v}]${r}`,`[${n}][${E}]${r}`].join().trim();return[...document.querySelectorAll(a)]},x=(t,e)=>t.dispatchEvent(e),O=t=>"easyToggleState_"+t,S=(t,e={"aria-checked":t[O("isActive")],"aria-expanded":t[O("isActive")],"aria-hidden":!t[O("isActive")],"aria-pressed":t[O("isActive")],"aria-selected":t[O("isActive")]})=>Object.keys(e).forEach(r=>t.hasAttribute(r)&&t.setAttribute(r,e[r])),D=(t,e,r=!1)=>`This trigger has the class name '${t}' filled in both attributes '${i}' and '${e}'. As a result, this class will be toggled ${r&&"on its target(s)"} twice at the same time.`,z=(t,e)=>(t.getAttribute(e)||"").split(" ").filter(Boolean),I=t=>{const e=t.hasAttribute(c)?c:A;return L(`${e}="${t.getAttribute(e)}"`).filter(t=>t[O("isActive")])},T=(t,e)=>{t||console.warn(`You should fill the attribute '${e}' with a selector`)},q=(t,e)=>{if(0===e.length)return console.warn(`There's no match with the selector '${t}' for this trigger`),[];const r=t.match(/#\w+/gi);return r&&r.forEach(t=>{const r=[...e].filter(e=>e.id===t.slice(1));r.length>1&&console.warn(`There's ${r.length} matches with the selector '${t}' for this trigger`)}),[...e]},K=(t,e)=>e.forEach(e=>{t.classList.toggle(e)}),j={},B=t=>document.addEventListener(t.getAttribute(h)||t.getAttribute(u)||"click",Y,!1),Y=t=>{const e=t.target,r=t.type;let a=!1;L(d).filter(t=>t.getAttribute(h)===r||t.getAttribute(u)===r&&!t.hasAttribute(h)||"click"===r&&!t.hasAttribute(u)&&!t.hasAttribute(h)).forEach(t=>{const r=e.closest(`[${w}="true"]`);r&&r[O("trigger")]===t&&(a=!0),a||t===e||t.contains(e)||!t[O("isActive")]||(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)}),a||document.removeEventListener(r,Y,!1);const o=e.closest(`[${i}][${d}],[${s}][${d}],[${n}][${d}]`);o&&o[O("isActive")]&&B(e)},C=t=>M(t.currentTarget[O("target")]),H=(t,e,r)=>(t=>{if(t.hasAttribute(b)||t.hasAttribute(f)){const e=t.getAttribute(b)||t.getAttribute(f);return T(e,t.hasAttribute(b)?b:f),q(e,document.querySelectorAll(e))}if(t.hasAttribute(v)){const e=t.getAttribute(v);return T(e,v),q(e,t.parentElement.querySelectorAll(e))}if(t.hasAttribute(E)){const e=t.getAttribute(E);return T(e,E),q(e,t.querySelectorAll(e))}return t.hasAttribute(m)?q("previous",[t.previousElementSibling].filter(Boolean)):t.hasAttribute($)?q("next",[t.nextElementSibling].filter(Boolean)):[]})(t).forEach(i=>{x(i,k),i[O("isActive")]=!i[O("isActive")],S(i),r?i.classList.add(...e):K(i,e),t.hasAttribute(d)&&(i.setAttribute(w,t[O("isActive")]),i[O("trigger")]=t),t.hasAttribute(g)&&(i[O("isActive")]?(j[i]=(t=>e=>{const r=[...t.querySelectorAll("a[href], area[href], input:not([type='hidden']):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]")];if(!r.length||"Tab"!==e.key)return;const i=e.target,n=r[0],s=r[r.length-1];return-1===r.indexOf(i)?(e.preventDefault(),n.focus()):e.shiftKey&&i===n?(e.preventDefault(),s.focus()):e.shiftKey||i!==s?void 0:(e.preventDefault(),n.focus())})(i),document.addEventListener("keydown",j[i],!1)):(document.removeEventListener("keydown",j[i],!1),delete j[i])),x(i,y),((t,e)=>{const r=L(p,t).filter(e=>!e.getAttribute(p)||t.matches(e.getAttribute(p)));if(0!==r.length)e[O("isActive")]?r.forEach(t=>{t[O("target")]||(t[O("target")]=e,t.addEventListener("click",C,!1))}):(r.forEach(t=>{t[O("target")]===e&&(t[O("target")]=null,t.removeEventListener("click",C,!1))}),e.focus())})(i,t)}),M=t=>{x(t,k);const e=(t=>{if(t.hasAttribute(i)&&t.getAttribute(i)&&(t.hasAttribute(s)||t.hasAttribute(n))){const e=z(t,s),r=z(t,n);z(t,i).forEach(i=>{e.includes(i)&&console.warn(D(i,s),t),r.includes(i)&&console.warn(D(i,n,!0),t)})}const e=[i,s,n].reduce((e,r)=>{const a=z(t,r);return(r===i||r===s)&&e.trigger.push(...a),(r===i||r===n)&&e.target.push(...a),e},{trigger:[],target:[]});return!e.trigger.length&&(t.hasAttribute(i)||t.hasAttribute(s))&&e.trigger.push(a),!e.target.length&&(t.hasAttribute(i)||t.hasAttribute(n))&&e.target.push(a),e})(t);return K(t,e.trigger),t[O("isActive")]=!t[O("isActive")],S(t),x(t,y),H(t,e.target,!1),(t=>{if(t.hasAttribute(d))return t.hasAttribute(A)?console.warn(`You can't use '${d}' on a radio grouped trigger`):t[O("isActive")]?B(t):void 0})(t)},R=t=>{const e=I(t);return 0===e.length?M(t):-1===e.indexOf(t)?(e.forEach(M),M(t)):-1===e.indexOf(t)||t.hasAttribute(A)?void 0:M(t)},U=t=>((t[Symbol.iterator]?[...t]:[t]).forEach(t=>{t[O("unbind")]&&t[O("unbind")]()}),t),_=()=>{[...document.querySelectorAll(`[${n}]:not([${b}]):not([${f}]):not([${$}]):not([${m}]):not([${v}]):not([${E}])`)].forEach(t=>{console.warn(`This trigger has the attribute '${n}', but no specified target\n`,t)}),L(l).filter(t=>!t[O("isDefaultInitialized")]).forEach(t=>{if((t.hasAttribute(c)||t.hasAttribute(A))&&I(t).length>0)return console.warn(`Toggle group '${t.getAttribute(c)||t.getAttribute(A)}' must not have more than one trigger with '${l}'`);M(t),t[O("isDefaultInitialized")]=!0});const t=L().filter(t=>!t[O("isInitialized")]);return t.forEach(t=>{const e=e=>{e.preventDefault(),(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)},r=t.getAttribute(u)||"click";t.addEventListener(r,e,!1),t[O("unbind")]=()=>{t.removeEventListener(r,e,!1),t[O("isInitialized")]=!1},t[O("isInitialized")]=!0}),L(o).length>0&&!document[O("isEscapeKeyInitialized")]&&(document.addEventListener("keydown",t=>{"Escape"!==t.key&&"Esc"!==t.key||L(o).forEach(t=>{if(t[O("isActive")])return t.hasAttribute(A)?console.warn(`You can't use '${o}' on a radio grouped trigger`):(t.hasAttribute(c)?R:M)(t)})},!1),document[O("isEscapeKeyInitialized")]=!0),L(r).length>0&&!document[O("isArrowKeysInitialized")]&&(document.addEventListener("keydown",t=>{const e=document.activeElement;if(-1===["ArrowUp","ArrowDown","ArrowLeft","ArrowRight","Home","End"].indexOf(t.key)||!e.hasAttribute(i)&&!e.hasAttribute(s)&&!e.hasAttribute(n)||!e.hasAttribute(r))return;if(!e.hasAttribute(c)&&!e.hasAttribute(A))return console.warn(`You can't use '${r}' on a trigger without '${c}' or '${A}'`);t.preventDefault();const a=e.hasAttribute(c)?L(`${c}='${e.getAttribute(c)}'`):L(`${A}='${e.getAttribute(A)}'`);let o=e;switch(t.key){case"ArrowUp":case"ArrowLeft":o=a.indexOf(e)>0?a[a.indexOf(e)-1]:a[a.length-1];break;case"ArrowDown":case"ArrowRight":o=a.indexOf(e)<a.length-1?a[a.indexOf(e)+1]:a[0];break;case"Home":o=a[0];break;case"End":o=a[a.length-1]}return o.focus(),o.dispatchEvent(new Event(o.getAttribute(u)||"click"))},!1),document[O("isArrowKeysInitialized")]=!0),t},F=()=>{_(),document.removeEventListener("DOMContentLoaded",F)};document.addEventListener("DOMContentLoaded",F),window.easyToggleState=Object.assign(_,{isActive:t=>!!t[O("isActive")],unbind:U,unbindAll:()=>U(L().filter(t=>t[O("isInitialized")]))})}();
</script>

<?
if (defined('LIB_POPUPSYSTEM[0]') && array_key_exists(0, LIB_POPUPSYSTEM) && (LIB_POPUPSYSTEM[0]==0) ) 
     $switchbox_style = ""; else 

  /* Context menu system: */
echo "
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
                    <div class='ctxP_Js ctxP_MenuItem \${enabled == true ? '' : 'disabled'}'>
                        <abbr class=\"hint\">
                        \${icon != ''? `<img src='\${icon}' class='ctxP_Js ctxP_MenuItemIcon'/>` 
                        : `<div class='ctxP_Js ctxP_MenuItemIcon \${cssIcon != '' ? cssIcon : ''}'>
                          </div>`} 
                        <span class='ctxP_Js ctxP_MenuItemTitle'>\${label == undefined? 'No label in button' : label}</span>
                        <span class='ctxP_Js ctxP_MenuItemTip'>\${shortcut == ''? '' : shortcut}</span>
                        \${hint == '' ? '' : '<data-hint>' + hint + '</data-hint>'}</abbr> 
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
        
        /* <abbr class=\"hint\">This text has a popup info <data-hint>[ *the hint contents to popup* ]</data-hint></abbr> */
        
        custom(markup) {
            this.element = ctxP_Core.CreateEl(`<li class='ctxP_Js ctxP_CustomEl'>\${markup}</li>`);
        }
        
        hoverMenu(label, items, icon = '', cssIcon = '', hint = '', enabled = true) {
            this.element = ctxP_Core.CreateEl(`
                <li class='ctxP_Js ctxP_HoverMenuOuter'>
                    <div class='ctxP_Js ctxP_HoverMenuItem \${enabled == true ? '' : 'disabled'}' >
                        <abbr class=\"hint\">
                        \${icon != ''
                            ? `<img src='\${icon}' class='ctxP_Js ctxP_MenuItemIcon'/>` 
                            : `<div class='ctxP_Js ctxP_MenuItemIcon \${cssIcon != '' ? cssIcon : ''}'></div> `}
                        <span class='ctxP_Js ctxP_MenuItemTitle'>\${label == undefined ? 'No label in hovermenu' : label}</span>
                        <span class='ctxP_Js ctxP_MenuItemOverflow'></span>
                        \${hint == '' 
                            ? '' 
                            : '<data-hint style=\"top: -30px;\">' + hint + '</data-hint>'}
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
                    <div class='ctxP_Js ctxP_MenuItem \${enabled == true ? '' : 'disabled'}'>
                        <abbr class=\"hint\">
                            \${icon != ''? `<img src='\${icon}' class='ctxP_Js ctxP_MenuItemIcon'/>` : `<div class='ctxP_Js ctxP_MenuItemIcon \${cssIcon != '' ? cssIcon : ''}'></div>`}
                            <span class='ctxP_Js ctxP_MenuItemTitle'>\${label == undefined? 'No label in submenu' : label}</span>
                            <span class='ctxP_Js ctxP_MenuItemOverflow'>
                                <span class='ctxP_Js ctxP_MenuItemOverflowLine'></span>
                                <span class='ctxP_Js ctxP_MenuItemOverflowLine'></span>
                                <span class='ctxP_Js ctxP_MenuItemOverflowLine'></span>
                            </span>
                        \${hint == '' ? '' : '<data-hint>' + hint + '</data-hint>'}
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
                    ((el.target.offsetLeft - menu.offsetWidth) + el.target.offsetWidth)+\"px\"
                        : (el.target.offsetLeft)+\"px\";

                menu.style.top = ((el.target.offsetTop + menu.offsetHeight) >= window.innerHeight) ?
                    (el.target.offsetTop - menu.offsetHeight)+\"px\"    
                        : (el.target.offsetHeight + el.target.offsetTop)+\"px\";
            } else {
                menu.style.left = ((el.clientX + menu.offsetWidth) >= window.innerWidth) ?
                    ((el.clientX - menu.offsetWidth))+\"px\"
                        : (el.clientX)+\"px\";

                menu.style.top = ((el.clientY + menu.offsetHeight) >= window.innerHeight) ?
                    (el.clientY - menu.offsetHeight)+\"px\"    
                        : (el.clientY)+\"px\";
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
</script>";     /* :Context menu system */


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
    top: 50%;
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
    opacity: 0.95;
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





/* Modal messages: */

.modlButt {
	display: inline-block;
	padding: 2px 8px;
    margin: 0 6px;
	color: white;
	background: gray;
	transition: background 1150ms ease-out;
}
.modlButt, modal__close, .label{
	padding: 3px;
    border: 1px solid;
    border-radius: 5px;
    background: white;
	cursor: pointer;
    margin: 5px;
}
.modlButt:hover, .modlButt:active {
	background: #ff7960;
    cursor: pointer;
    padding: 3px;
    border: 1px solid;
    border-radius: 5px;
	transition: background 1250ms ease-out;
}

.modal {
	position: fixed;
	z-index: 20;
	max-width: 85%;
	width: 30%; /* 400px; */
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	margin: 0 auto;
  box-shadow: 0px 0px 0.4em white; 
  border-radius: 0.4em;
	opacity: 1;
	transition: margin-top 150ms ease-out,  opacity 150ms ease-out;
	background: #eee;
	box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.6);
}

@media screen and (max-height: 500px) {
	.modal {
		width: 80%;
		height: 80vh;
	}
}

.modal__toggler {
	display: none;
}

.modal__toggler:not(:checked) ~ .modal {
	position: absolute;
	overflow: hidden;
	clip: rect(0 0 0 0);
	opacity: 0;
	height: 1px;
	width: 1px;
	margin: -1px;
	padding: 0;
	border: 0;
	margin-top: -10px;
}

.modal__toggler:not(:checked) ~ .modal__mask {
	position: absolute;
	overflow: hidden;
	clip: rect(0 0 0 0);
	opacity: 0;
	height: 1px;
	width: 1px;
	margin: -1px;
	padding: 0;
	border: 0;
}

.modal__mask {
	position: fixed;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
    z-index: 5;
	opacity: 1;
	transition: opacity 150ms ease-out;
	background: RGBA(0, 0, 0, 0.7);
	cursor: pointer;
}

.modal__close::after {
	content: "\2715";
	position: absolute;
	display: inline-block;
	top: 5px;
	right: 5px;
	font-size: 15px;
	font-weight: bold;
	cursor: pointer;
    padding: 3px 5px 0;
    border: 1px solid;
    border-radius: 5px;
    background: white;
}

.modal__title {
	margin: 0;
}

.modal__header {
	padding: 2px 15px 1px;
  border-radius: 0.4em 0.4em 0 0;
	font-size: 15px;
}

.modal__content {
	padding: 5px 20px;
	/* max-height: 30%; */
	max-height: 60vh;
  overflow-y: auto;
  float: left;
}

@media screen and (max-height: 500px) {
	.modal__content {
    max-height: 45vh;
	}
}

.modlwrap {
  min-height: 100%;
  position:relative;
  background-color: white;
}
.modlwrap:after {
  content: "";
  display: block;
}

.modal__footer {
	padding: 10px 0;
  border-radius: 0 0 0.4em 0.4em;
	text-align: center;
  background-color: #AAAAAA;
  display:table;
  width: 100%;
}

.modal__window {
	max-height: 80vh;
	overflow-y: auto;
	background: #eee;
}

</style>
';
echo $htm_ModalDialog;

echo $switchbox_style;

//echo $inis;   // initScript: read CSS given in htm_Page_0 parameter

/* 
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
 */
 
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
//           let newCell6 = newRow.insertCell(6);
//           let newCell7 = newRow.insertCell(7);
//           let newCell8 = newRow.insertCell(8);
//      }
//        // addRow("my-table");                                  // Call addRow() with the table´s ID
//    ');
    

### ----------------------Library-fontawesome icons ----------------------
    if (defined('LIB_FONTAWESOME') && array_key_exists(0, LIB_FONTAWESOME) )  {
        if (LIB_FONTAWESOME[0]>0) {                                                     # if library activated
                if (LIB_FONTAWESOME[0]==1)  $path= $gbl_ProgRoot.LIB_FONTAWESOME[1];    # Local-folder
                else                        $path=               LIB_FONTAWESOME[2];    # CDN-server 
            echo '<link  href="'.$path.'css/all.min.css" rel="stylesheet" />';      // topic="fontawesome-system" (choose a theme file)
        } else {
            // define('LIB_FONTAWESOME',       [0, '', '']);
            $pageMess.= ' Fontawesome is not loaded ! <br>';
        }
    } /* else {
    echo '<script defer src="'.$gbl_ProgRoot.'_assets/font-awesome/latest/js/all.js"></script>'; 
    echo '<link        href="'.$gbl_ProgRoot.'_assets/font-awesome/latest/css/all.css" rel="stylesheet">';
    
    }
     */
### ----------------------


### ----------------------Library-tinyMCE editor ----------------------
    if (defined('LIB_TINYMCE')) {
        if (array_key_exists(0, LIB_TINYMCE))
        if (LIB_TINYMCE[0]>0) {                                             # if library activated
            if (LIB_TINYMCE[0]==1)  $path= $gbl_ProgRoot.LIB_TINYMCE[1];    # Local-folder
            else                    $path=               LIB_TINYMCE[2];    # CDN-server 
            echo '<script src="'.   $path.'/tinymce.min.js" referrerpolicy="origin"></script>';
    // } else { define('LIB_TINYMCE',       [0, '', '']); 
        // $pageMess.= ' tinyMCE is not loaded ! <br>'; }
    }
    /* else {
        // define('LIB_TINYMCE',       [0, '', '']);
        /* $pageMess.= ' tinyMCE is not loaded ! <br>'; */
    } 
    ## Be aware tinyMCE has its own translate system !
### ----------------------


    $gbl_PageLogo= ($gbl_ProgBase ?? './').'_accessories/21997911.png';

    echo $CSS_system;    // Activate the system style
    set_Style('type="text/css"', '<!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_accessories/barcode.ttf); } --> ');
    $bottLogo= ''; //'url('.$gbl_PageLogo.') right bottom/3% no-repeat,';
    
    set_Style('type="text/css"', 
              'body { background: left top no-repeat; background-size: 100% 100%; font-family: sans-serif; '.
               $attr.' '.(($imag>'') ? ' background-repeat: repeat; background-size: 225px; background-image: url('.$imag.')}' : '')
    );
    
    if ($info>'')
        echo '<div style="position: fixed; z-index: 99; float: right; display: inline-block; width: max-content; line-height: 14px;line-height: 14px; right: 0;
            transform-origin: bottom left; transform: rotate(-90deg); translate: 100% 85vh; white-space: nowrap; 
            padding: 2px; background-color:#ddddddbd;"><span style="font-size: 0.8em;">'.lang($info).'</span></div>';

    if ($hint>'')
        echo '<div style="position: fixed; width: min-content; line-height: 14px; bottom: -10px; left: 0px; z-index: 99;
            transform-origin: top left; transform: rotate(-90deg); white-space: nowrap; padding: 2px; background-color:#ddddddbd;" '.
            'title="CTRL-Scroll UP/Down mousewheel to zoom window content">'.
    // '<data-hint>CTRL-Scroll UP/Down mousewheel to zoom window content</data-hint>'.
            '<small>'.lang($hint).'</small></div>';
    // echo '<div class="ver_right"; style="color:red;">[[[[[[[[[HHHHH__HHHHHH]]]]]]]]]]</div>';

    echo $jsScripts;
    echo $sys_Style;

    if ($inis>'')          echo $inis;   // read CSS/js given in htm_Page_0 parameter
    // if ($lateScripts > '') echo $lateScripts; // run_Script($lateScripts);
    if ($headEndScript > '') run_Script($headEndScript);


    echo "\n</head>\n
             <body>\n"; 

    if ($pageMess > '<b>ERROR:</b> ') echo $pageMess;
    
    if ((isset($imag)) and ($imag>'')) $image= 'background-image: url(\''.$imag.'\');'; else  $image= '';
    echo '<div style="text-align: '.$algn.'; '.$image.' margin: auto; ">';
    if ($pbrd) echo '<div style="border: 2px solid #AAA; border-radius: 8px; overflow: hidden; margin: auto;" >'; // margin: 24px 4px 4px;
} // htm_Page_0()



function htm_Page_00()
{ global $gbl_CardIx, $cardCount, $gbl_ProgRoot, $sys_Style, $jsScripts, $bodyEndScript, $pbrd, $gbl_Imag;
    $cardCount= $gbl_CardIx;
    if ($pbrd) echo '</div>';   // Started in htm_Page_0()
    echo '</div>';                  // $align - Started in htm_Page_0()
    //Menu_Bottom();
    echo '<div id="snackbar">Short message</div>';
    CardInit($cardCount ? $cardCount : 15);
    // echo $jsScripts;
    echo $sys_Style;
    # Regards Cards:
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
    // if ($lateScripts > '') echo $lateScripts; // run_Script($lateScripts);
    if ($bodyEndScript > '') run_Script($bodyEndScript);
    
   // if (DEBUG) run_Script('header("Server-Timing: ".$Timers->getTimers()); ');
    $url= $gbl_ProgRoot.'../../spormig.php';
    if (is_readable($url)) { include($url); echo '+'; } else echo '-';


    htm_nl(2);
    echo "\n  </body>"; // Started in htm_Page_0()
    echo '</html><br>';
} # htm_Page_00

} ## Group ******************** /htm_Page **************************

{ ## Group ******************** GRANULES: **************************

 if (!function_exists('Lbl_Tip'))
{ // Start: GRANULES - Group of function declearins:  Read only once !

# BASE GRANULE:
function Lbl_Tip(# labl,hint,plac:'',$h='13px',$t='') 
    $labl,$hint,$plac='',$h='13px',$t='') 
{ # Label with popup-tip / info / LongLabel / details to the user, when mouseover the label.
    if ($t!='')  $t= ' top:'.$t;
    if ($labl=='') return '';
    else {    dvl_pretty('Lbl_Tip');
        if ($h=='0px') {$h='';}
        switch (strtoupper($plac)) {
        case 'W':  $class= 'LblTip_W';  break;    # Plac. Left                'tooltipW';
        case 'S':  $class= 'LblTip_S';  break;    # Plac. Under               'tooltipS';
        case 'O':  $class= 'LblTip_O';  break;    # Plac. Right               'tooltipO';
        case 'N':  $class= 'LblTip_N';  break;    # Plac. Over                'tooltipN';
        case 'NW': $class= 'LblTip_NW'; break;    # Plac. direction NW        'tooltipNW';
        case 'SW': $class= 'LblTip_SW'; break;    # Plac. direction SW        'tooltipSW';
        case 'SO': $class= 'LblTip_SØ'; break;    # Plac. direction SØ        'tooltipSØ';
        default :  $class= 'LblTip_text';         # Plac. Over
        }
        if (strlen($hint.' ')<140) {$wdth='';} else {$wdth='style ="min-width: 320px;"';}
        if ($hint=='') $hint=lang('@No details !');
        $hint= '<span class="'.$class.'" '.$wdth.'>'.lang($hint).'</span>';
        return '<span class="LblTip" style="height:'.$h.$t.'">'.ucfirst(lang($labl).' ').$hint.'</span>';
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
function htm_Ihead(# source) 
    $source)            {echo '<br/><i>'.$source.'</i> ';}
function htm_hr(# $c='#0',$attr='')   
    $c='#0',$attr='')   {echo '<hr style="background-color:'.$c.';'.$attr.'"/>';}
function htm_br(# rept:1)   
    $rept=1)            {echo str_repeat('<br />',$rept);}
function htm_nl(# rept:1)
    $rept=1)            {echo str_repeat('<br />',$rept);}
function htm_lf(# $rept=1)  
    $rept=1)            {echo str_repeat(' &#xa;',$rept);}  //  LineFeed
function htm_sp(# rept:1) 
    $rept=1)            {echo str_repeat('&nbsp;',$rept);}
function htm_space(# wdth)  
    $wdth)              {echo '<span style="width:'.$wdth.'; display:block; "></span>';}

// String-functions:
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



/*
 * get language translations from json file
 * @param int $transTable
 * @return array
 */
function sys_get_translations($transTable=[])  
{ global $gbl_ProgRoot, $arrLang;
    if (isset($_POST['alllang']))  $alllang = $_POST['alllang']; else $alllang = '';
    if ($arrLang == null)     // Prevent repeating calls
    try {
        $content = file_get_contents($gbl_ProgRoot.'_trans.sys.json');
         // echo $content;
        if ($content !== FALSE) {
            $lng = json_decode($content, TRUE);
            // arrPretty($lng,'$lng');
            if ($lng != null)
            foreach ($lng["language"] as $key => $value)
            // if ((!$value["translation"] == null) or ($alllang == 'All'))    // Only if translation exists for that language
            {   $lang_rec["code"]        = $value["code"];                  // $value["code"];
                $lang_rec["name"]        = $value["name"];                  // $value["name"];      Name in english
                $lang_rec["native"]      = $value["native"];                // $value["native"];    Name translated from english
                $lang_rec["author"]      = $value["author"];                // $value["author"];
                $lang_rec["note"]        = $value["note"];                  // $value["note"];
                $lang_rec["DateTime"]    = $value["DateTime"];              // $value["DateTime"]; // setlocale(LC_TIME, 'da_DK','da','da_DK.utf8'); ?
                $lang_rec["translation"] = $value["translation"];
                $arrLang[] = $lang_rec;

                // if ($transTable) { $transTable[$value["code"]] = $value["translation"]; }    // $value["translation"];
                if (substr($_SESSION['proglang'],0,2)==$lang_rec["code"]) $_SESSION['currLang']= $lang_rec;
            }
            else $arrLang= ['ERROR on decoding: _trans.sys.json',' '];
            // arrPretty($arrLang,'$arrLang');
            # if (false) { $out = fopen('json.out', "w"); fwrite($out, PHP_EOL. print_r($value["translation"], true)); fclose($out); } // save pretty JSON-file
            return $arrLang;
            // if ($transTable) return $arrLang; else return $transTable;
        }; // else toast('File error reading: _trans.sys.json !','yellow','black');
    }
    catch (Exception $e) {
        echo $e;
    }
    return $arrLang;
} // sys_get_translations

// if ($transTable==[]) $transTable= sys_get_translations($transTable); // All languages with translation: en, da, fr, de
//$_SESSION['trans'] = $transTable;
// arrPrint($arrLang,'$arrLang');
 // arrPrint($transTable,'$transTable');

## Prepare Lang-system;
// $lang = $_SESSION['currLang']; 
if (isset($_POST['language'])) $lang = $_POST['language']; 
if (!isset($lang)) $lang = 'en';                        // Default language english
if (!$englishOnly) $allLang = sys_get_translations();   // arrPretty($allLang,'$allLang');
if ($allLang) {
    $natindx = array_search($lang, array_column($allLang, 'code')); //  echo $natindx;
    $engindx = array_search('en',  array_column($allLang, 'code')); //  echo $engindx;
}

if (!function_exists('lang')) { ## Be aware tinyMCE has its own translate system !
    function lang(# text)     # lang() is used to translate all hard-coded user interface
    $text           # String: Frase to be transated, with prefix: '@ and with suffix: '
    )
    {   global  $natindx, $engindx, $allLang, $lang;
        $text= trim($text,"@");
        if      (isset($allLang[$natindx]['translation'][$text]))    return /* sys_enc */($allLang[$natindx]['translation'][$text]); // .' ('.$lang.')');   // National
        else if (isset($allLang[$engindx]['translation'][$text]))    return /* sys_enc */($allLang[$engindx]['translation'][$text]);                        // Translated English
        else                                                        return trim($text,"@");  // Default English, if not in translate table           // Native (english)
    }
}

/**
 * Encode html entities
 * @param string $text
 * @return string
 */
function sys_enc($text)     # Make valid HTML string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}


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


function infoLabl(# labl:'',hint:'',plac:'SW') 
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

function menuButt ($h='32',$w='120',$label='',$link='',$Hint='') // Icon ?
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
        
/* 
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
                $val= substr(substr($arg, strrpos($arg,'=')+1),0 /* ,strrpos($arg,');') * / );
                if ($var>'')
                    $result.= '<br>    '.
                          str_Synt($elem=$var,$type='variable').
                          str_Synt($elem='= ',$type='operator').
                          str_Synt($elem=$val,$type='string').
                          str_Synt($elem=', ',$type='operator');
                
            }
            echo str_Synt_0().$result.'<br>'.str_Synt(substr($funcTail,0,2),'default').str_Synt(substr($funcTail,2),'comment').str_Synt_00();
        }
  */

} // End of group: GRANULES

} ## Group ******************** /GRANULES **************************

} ## Group ******************** /FUNCTIONS **************************

{ ## Group ******************** CSS STYLE: **************************

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
    --cardsTitl: #ffffff00; /* Transparent */
    --oranColor: #F37033;
    --brunColor: #550000;   /*  Table borders  */
    --grayColor: #ACA9A8;
    --shadColor: #d3d3d352;
    --xx11Color: #3CBC8D;
 /* --HintsBgrd: rgba(55, 55, 55, 0.90);     --HintsText: #FFFFFF; */
 /* --HintsBgrd: rgba(240, 240, 240, 0.90); */
    --HintsBgrd: Ivory; /* lightyellow; /* #E4FBFBE8; */
    --HintsText: #000000;
    --xx33Color: #CCEDFE;   /*  Filter: Light-Blue background */
    --grColrLgt: #CCCCCC;
    --FieldBord: #AAAAAA;   /* Card- and Field-border */
    --FieldBgrd: #FAFAFA;   /* Field background-color */
    --CardsBgrd: <?php echo $GLOBALS["gbl_CardsBgrd"]; ?>;
    --Wall_Bgrd : <?php echo $GLOBALS["ØWall_Bgrd"]; ?>;
    --ButtnBgrd: #44BB44;   /* LysGrøn   */
    --ButtnText: #FFFFFF;   /* Hvid   */
    --BtLnkBgrd: #FCFCCC;   /* LysGul  */
    --BtLnkText: #000000;   /* Sort   */
    --ButtnShad: #bcbcbc;   /* Knap skygge (lysgrå)  */
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
    --darkBcgrd: #333;      /* Lable background color */

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
    
    /* --ButtnShad: gray; */
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
        box-shadow: 1px 1px 1px var(--ButtnShad) inset;
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
    {                     /* Hidden tip text on colored background placed at label */
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

    ::-webkit-input-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }
    :-moz-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; } /* Firefox 18- */
    ::-moz-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }  /* Firefox 19+ */
    :-ms-input-placeholder { color: var(--grenColr1); font-size: 80%; font-weight:200; }

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

/* 
@media only screen and (min-width: 200px) and (max-width: 767px)  {
    .cardW960 { width: 330px;  }
}
 */

/*************************************/

/* CARDS: (in different widths) */
.cardWmax, .cardWaut, .cardW120, .cardW110, .cardW100, .cardW960, .cardW800, .cardW720,
.cardW640, .cardW560, .cardW480, .cardW400, .cardW320, .cardW280, .cardW240, .cardW160 {
    border: 1px solid var(--grayColor);
    background: var(--CardsBgrd);
    box-shadow: 2px 2px var(--ButtnShad);
    border-radius: 0.4em;
    border-style: inset;
    border-color: lightgray;
    border-width: thin;
    /* margin: 0.4em 0.2em 0.4em 0.2em; /**/
    /* padding: 0.3em 0.3em 0.4em 0.3em; /**/
    padding: 2px 0;
    display: inline-block;
}
.cardWmax { width:  99%;   }
.cardWaut { width: auto;   }
.cardW120 { width: 1200px; }
.cardW110 { width: 1100px; }
.cardW100 { width: 1020px; }
.cardW960 { width: 960px;  }
.cardW800 { width: 800px;  }
.cardW720 { width: 720px;  }
.cardW640 { width: 640px;  }
.cardW560 { width: 560px;  }
.cardW480 { width: 480px;  }
.cardW400 { width: 400px;  }
.cardW320 { width: 320px;  }
.cardW280 { width: 280px;  }
.cardW240 { width: 240px;  }
.cardW160 { width: 160px;  }

.cardsTitl,.wallTitl {
    font-family: sans-serif;
    /* font-size: 0.88em; */
    font-size: 14px;
    font-weight: 600;
    height: 1.1em;
    margin: 0.0em 0.2em;
    padding: 0.1em 0.1em 0.3em;
    background-color: var(--cardsTitl);
    position: relative;
    width: 100%;
    text-align: center;
}
.wallTitl {
    font-size: 1.2em;
    font-family: sans-serif;
}

.wallWmax {
    border: 3px solid var(--grayColor);
    background: var(--Wall_Bgrd);
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
input[type="date"]::-webkit-inner-spin-button,
input[type="date"]::-webkit-outer-spin-button {
    -webkit-appearance: none; /* Hide in Chrome * /
    margin: 0; 
}


input[type="date"]::-webkit-calendar-picker-indicator{
    display: inline-block;
    margin-top: 2%;
    float: right;
}
/*  */
 
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
    /* content: "\25BC";  */
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
    /* text-align: right; */
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
    margin: 5px 5px;
    background-color: white;
}

'.
    /* hint: "ToolTip" with html content (formattet with html tags): */
    /* Example: <abbr class="hint">This activity will be open to registration on April 31st <data-hint>[ *the contents<b> you </b>would want to popup here* ]</data-hint></abbr> */
    /* // SYNTAX: <abbr class= "hint"> <div>'.Slabel.'</div><data-hint>'.Stitle.'</data-hint></abbr> */
'
.hint {
    color: var(--lablColor);
    background-color: var(--cardsTitl);
}
.mnu_heads {
    color:black;
    background-color: ivory;
    float: left;
    padding: 3px 12px;
}
.menulabl.a {
    color:white;
}
.menulabl:hover {
    text-decoration: underline;
    font-weight:600;
}
abbr.hint data-hint {
    display: none;
    position: relative;
    left: 50px;
    /* top: 35px;  */
    /* bottom: 80px; */
}
data-hint {
    top: 35px;
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

input[type=text][title]:hover::after {
    content: attr(title);
    color: var(--HintsText);
    background-color: var(--HintsBgrd);
    font-size: 14px;
    border: 1px solid var(--grayColor);
    border-radius: 4px;
    padding: 5px 3px;
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
    min-height: calc(100vh - 55px);
    padding: 24px 0 0 0;
}

.button, a.button {
/*  -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button; */

    text-decoration: none;
    font-size: 13px;
    min-height: 28px;
    color: white;
    border: solid 2px #aaa;
    border-style: outset;
    background: #269B26;
    opacity: 0.8;
    padding: 2px 6px;
}

/* 
https://stackoverflow.com/questions/27124746/centering-legend-in-firefox */
/* indended styling for other browsers */
fieldset>legend {
  display: table;
  float: none;
  margin: 0 auto;
}

/* FF only */
@media screen and (-moz-images-in-menus: 0) {
  fieldset {
    position: relative;
  }
  fieldset>legend {
    position: absolute;
    left: 50%;
    top: -12px; /* depends on font size and border */
    background: white; /* depends on background */
    transform: translate(-50%, 0);
  }
}

</style>
';  // End of $CSS_system
} ## Group ******************** /CSS STYLE **************************

 
if (is_readable($custFile= '../customLib.inc.php')) require_once($custFile);
# In /customLib.inc.php you can add modified or needed code

?>
