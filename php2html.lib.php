<?php  $DocFileLib='../php2html.lib.php';    $DocVer='1.6.3';    $DocRev='2026-10-11';      $DocIni='evs';  $ModNo=0; ## File informative only
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
 */ $©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** See the file: LICENSE'; /*

    Created: 2020-02-29 evs - EV-soft
    Latest revision: see file 1. line: $DocRev
    R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
    2020-00-00 - evs  Initial
 */
} ## Group ******************** /System HEAD **************************

##### WARNING: If you edit this file, you have to do the same edit, after an update !
##### Put your modifications in custom files like: project.init.php,  customLib.inc.php (search : include, require_once - in this file)
##### They can live outside the library folder: $gbl_InitFile (set in the page before require), and in that file $gbl_CustomLib,
##### $gbl_CustomRules and $gbl_CustomCss - see the documentation page "Customize without editing the library".

{ ## Group ******************** System init: **************************

### System init:
// session_unset();
if (session_status() === PHP_SESSION_NONE) {               # The host project may already have started the session
    if (!headers_sent())                                       # Cookie not readable by JavaScript, not sent with cross-site posts
        session_set_cookie_params(['path'=>'/', 'httponly'=>true, 'samesite'=>'Lax',
                                   'secure'=> (!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS']!=='off'))]);
    session_start();
}
if (($_GET['p2h_keepalive'] ?? '') === '1') {   # From the session warning (htm_Page_end): the request itself keeps the session alive
    header('Cache-Control: no-store');  http_response_code(204);  exit;
}

# CONSTANTS: see after the project init file (it can define them first)
/* 
$isOnline = fsockopen("cdnjs.cloudflare.com", 80, $errno, $errstr, 30);
if ($isOnline) { $autoCDN= '2'; fclose($isOnline); }
else             $autoCDN= '1'; // $autoCDN can be used to auto switch between - 1:Local-source  2:WEB-source-CDN
 */
# Is the CDN reachable? Only asked when a library uses '3' (Auto: Local/CDN) - and the answer is shared by all visitors for 5 minutes
# (was: a network call for every new session, also on pages without '3'; up to 1 second when the CDN is slow)
$autoCDN= '2';                                                   # $autoCDN: 1:Local-source  2:WEB-source-CDN (used by the '3' libraries)
$needAuto= false;
foreach (['needJquery','needTablesorter','needPolyfill','needFontawesome','needTinymce','needPdfview'] as $nv)
    if ((string)($$nv ?? '') === '3') $needAuto= true;
if ($needAuto) {
    $cdnFile= sys_get_temp_dir().'/p2h_autocdn.txt';
    $cdnSaved= @file_get_contents($cdnFile);                     # "2|1760000000": answer|time
    if (isset($_SESSION['autoCDN'], $_SESSION['autoCDN_time']) && (time() - $_SESSION['autoCDN_time'] <= 300))
        $autoCDN= $_SESSION['autoCDN'];
    elseif ($cdnSaved && preg_match('/^([12])\|(\d+)$/', $cdnSaved, $m) && (time() - (int)$m[2] <= 300))
        $autoCDN= $m[1];
    else {
        $isOnline= @fsockopen('cdnjs.cloudflare.com', 443, $errno, $errstr, 1);     # 1 second at most
        $autoCDN= $isOnline ? '2' : '1';
        if ($isOnline) fclose($isOnline);
        @file_put_contents($cdnFile, $autoCDN.'|'.time(), LOCK_EX);
    }
    $_SESSION['autoCDN']= $autoCDN;  $_SESSION['autoCDN_time']= time();
}

//         LibName:           ix:                 LocalPath:                         CDN-path:         (Search: https://cdnjs.com/libraries)          // File:
if ((isset($needJquery)) and ($needJquery>'0')) {
    $LIB_JQUERY=        [$needJquery,      '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/'];               //    
    $LIB_JQUERYUI=      [$needJquery,      '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.14.2/'];            // jquery-ui.min.js
}
if ((isset($needTablesorter)) and ($needTablesorter>0)) {
    $LIB_TABLESORTER=   [$needTablesorter, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.32.0/'];  // js/jquery.tablesorter.js and 4 others
}
if ((isset($needPolyfill)) and ($needPolyfill>0)) {
    $LIB_POLYFILL=      [$needPolyfill,    '_assets/dialog-polyfill/latest/',  'https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.5.6/'];      // dialog-polyfill.js and dialog-polyfill.css
}
if ((isset($needFontawesome)) and ($needFontawesome>0)) {
    $LIB_FONTAWESOME=   [$needFontawesome, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/'];         // css/all.min.css
                                                                             // https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css
}
if ((isset($needTinymce)) and ($needTinymce>0)) {
    $LIB_TINYMCE=       [$needTinymce,     '_assets/tinymce/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/tinymce/8.9.3/'];              // tinymce.min.js
}                                      
if ((isset($needPdfview)) and ($needPdfview>0)) {
    $LIB_PDFVIEW=       [$needPdfview,     '_assets/pdfview/latest/',          'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/6.4.299/'];             // pdf.js
                                                                             // https://cdnjs.cloudflare.com/ajax/libs/pdf.js/6.4.299/pdf.min.mjs
                                                                                      //cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js
                                                                             // https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf_viewer.min.css
    ## https://www.allphptricks.com/create-a-custom-pdf-viewer-with-pdf-js-and-restrict-downloading-printing/
}
## Here you can find all and the latest version: https://cdnjs.com/libraries/

// part1= $_SERVER['HTTP_REFERER'] ?? '';
// part2= end(array_reverse(explode('/',trim($_SERVER['SCRIPT_NAME'],'/',))));
// gbl_ProgBase= substr($part1,strpos($part1,strlen($part2)),strpos($part1,$part2)+strlen($part2)+1);
// gbl_ProgBase= $part2.'/';
$gbl_ProgBase= ''; // echo $gbl_ProgBase;

 //   header("Access-Control-Allow-Origin: *");

# GLOBALS
#Defaults:
{
    $gbl_TblIx= -1;                             # Index for table-id to separate multible tables in one page
    $gbl_ProgTitl= 'php2html';
    $gbl_progVers= 'Develop'.' ';
    $gbl_progDesti= 'This program is about using library PHP2HTML';
    $gbl_copyright='EV-soft';
    $gbl_designer= 'EV-soft';
    $gbl_menuLogo= $gbl_ProgBase.'_accessories/21997911.png';

    $gbl_blueColor= 'lightblue';
    $gbl_BodyBcgrd= 'Tan';
    $gbl_iconColor= 'DarkGreen';    # Card-header icon
    $gbl_TitleColr= 'DarkGreen';    # Caption text-color in card-head
    $gbl_CardsBgrd= 'white;';       # Cards hideble background
    $gbl_GridOn=    true;           # Use grid to place objects in rows / colums
    $gbl_progZoom = 'small';        # Global tag "font-scale"
    $gbl_labelAlgn= 'R';            # L/C/R - Align label for htm_Input() and htm_Inbox()
    
    $gbl_ButtnBgrd= '#44BB44';  /* LightGreen  */   $gbl_ButtnText= '#FFFFFF'; 
    $gbl_BtLnkBgrd= 'yellow';   /* '#FCFCCC';  */   $gbl_BtLnkText= '#000000';
    $gbl_TextLight= 'white';       $gbl_TextDark= 'black';
    $gbl_BtDelBgrd= 'Crimson ';    $gbl_BtDelText= $gbl_TextLight;   # Delete:      RED
    $gbl_BtSavBgrd= '#0064b4';     $gbl_BtSavText= $gbl_TextLight;   # Save/Submit: BLUE
    $gbl_BtNavBgrd= '#1A6E1A';     $gbl_BtNavText= $gbl_TextLight;   # Navigate:    GREEN
    $gbl_BtGooBgrd= '#66CDAA';     $gbl_BtGooText= $gbl_TextDark;    # Continue:    MARINE
    $gbl_BtNewBgrd= 'Orange';      $gbl_BtNewText= $gbl_TextDark;    # CreateNew:   ORANGE
    $gbl_dimmed=    ' opacity:0.9;';
}
# The project settings: $gbl_InitFile (set in the page before require_once of this library) - else project.init.php next to this library.
# Keep the project file outside the library folder, and an update of the library does not overwrite it.
$custFile= $gbl_InitFile ?? (__DIR__.'/project.init.php');
if (is_readable($custFile)) include($custFile);         # Change global defaults
elseif (isset($gbl_InitFile)) trigger_error('php2html: $gbl_InitFile not found: '.$gbl_InitFile, E_USER_WARNING);

# CONSTANTS: (defaults - define them in the page before require, or in the project init file)
defined('DEBUG')        or define('DEBUG',false);       # Set to true to activate system debugging
defined('ThousandsSep') or define('ThousandsSep',' ');  # Used in number output
defined('DecimalSep')   or define('DecimalSep',',');    # Used in number output
/* else echo '<br> '.__LINE__.' '.$custFile.' not found <br>'; */

$javaScripts= '';                                 # Empty buffer

if (is_null($rowHtml ?? '')) $rowHtml= '';

# PATHS:
# $gbl_ProgRoot is set in *.page.php files. 

if (!is_null($GLOBALS["gbl_ProgRoot"])) 
        $gbl_ProgRoot= $GLOBALS["gbl_ProgRoot"]; 
else    $gbl_ProgRoot=  './../';    # $gbl_ProgRoot= "./../";  // "../";  Relative in 1. subniveau    #-$gbl_ProgRoot= "./../../";   //  Relative in 2. subniveau

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
$englishOnly= $englishOnly ?? false;   # Deactivate the language translate system (true: set it in the page before require, or in project.init.php)
$gbl_novice= $gbl_novice ?? false;             # Activate extended help                (can be set in the project init file)
$headEndScript= $headEndScript ?? '';           # Scripts to run at end of page-HEAD    (can be set in the project init file)
$bodyEndScript= $bodyEndScript ?? '';           # Scripts to run at end of page-BODY    (can be set in the project init file)

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
{   if ($name>'') $name.=': ';
    $result= "<br><textarea>".sys_enc($name. print_r($arr, true)). "</textarea><hr>\n"; // Escaped: values may come from the request
    if (!$rtrn) echo $result;
    else return $result;
}

function arrPretty($arrVar,$titl='',$attr='rows="20" cols="135"',$wdth='100%',$rtrn=false)  ## Pretty output of any variable
{   $result= "<meta charset='UTF-8'>
    <div style='background: lightcyan; width:".$wdth.";'>".$titl."</div>
              <textarea ".$attr." wrap = 'off' style='padding: 10px; width: ".$wdth."; display: block;'>".
                    sys_enc(print_r($arrVar,true)).                    # Escaped: values may come from the request
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

# An advanced object rel. in-output of data [Necessary basic element]
function htm_Input(# labl:'', plho:'@Enter...', icon:'', hint:'', vrnt: 'text', name:'', valu:'', form:'', wdth:'100%', algn:'left', attr:'', rtrn:false, unit:'', disa:false, rows:'2', step:'', list:[], llgn:'R',bord:'', ftop:'')

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
    if ($vrnt != 'html') {                                       // Escape brugerinput for at undgå XSS (også hidden + textarea).
        $valu= htmlspecialchars((string)$valu, ENT_QUOTES, 'UTF-8');  // Kun html-varianten må indeholde markup
    }
    if (($llgn == '') and ($gbl_labelAlgn >'')) $llgn= $gbl_labelAlgn;
    if (!empty($GLOBALS['gbl_CardForm'])) $form= '';      # Inside a card form: the field belongs to that form (forms cannot be nested)
    ($form=='' ? $result= '' : $result= '<form name="'.sys_enc($form).'" method="post"'.($vrnt=='file' ? ' enctype="multipart/form-data"' : '').' style="display:inline;">'.csrf_field(true));   # (file: else only the name was sent)
    if ($form>'') $subm= '<input type="submit" value="OK" style="padding:0 0 0 2px; border-radius: 3px; width:22px; position: relative; color:blue;" title="Submit" />';
    if ($wdth>'') $wdth= ' width: '.$wdth.'; '; else $wdth='';
    if ($ftop>'') $ftop= ' top: '.$ftop.'; '; else $ftop='';
    // if ($hint=='') $hint= '@There is no explanation !';
    $hint= lang($hint);
    $labl= lang($labl);
    if ($icon>'') $icon= '<ic class="'.$icon.'" style="color: '.$gbl_iconColor.'; margin: 0 5px;"></ic>&nbsp;'; else $icon= '';
    ($plho=='' ? $plh='' : $plh=' placeholder="'.lang($plho).'" '); // .'<span style="font-weight:300;">'.lang($plho).'</span>" ');
    if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
    if (strpos(' '.$attr,'required')>0) $bord.= 'border: 2px solid orange;';
    if (/* ($vrnt=='date') and */ ($valu=='')) $dataStyle= 'font-weight: 200; color:var(--grenColr1);'; else $dataStyle='font-weight: 600; ';

# htm_Input: FIELD:
    static $inpNo= 0;  $inpNo++;                                # Unique id per field (was: id="inpBox" on every field)
    if ($vrnt!='hidd')
        $result.= '<div class="inpField" id="inpBox'.$inpNo.'" style="margin: auto; padding: 0 2px 6px; '.$wdth.' '.$ftop.' display: inline-block; vertical-align: top;"> ';

# htm_Input: INPUT:
    $iid= sys_uid($vrnt=='area' ? ($name ?: 'missing') : ($name=='' ? 'missing' : 'id_'.$name));   # Unique id (the same name can occur several times, e.g. in a loop)
    ($name=='') ? $inpIdNm= ' id="'.$iid.'" name="missing" '
                : $inpIdNm= ' id="'.$iid.'" name="'.$name.'" ';
    $inpStyle= ' class="boxStyle" style="text-align: '.$algn.'; font-size: 14px; '. $dataStyle. $bord; //boxStyle - border: 1px solid var(--grayColor);
    $eventInvalid= ' oninvalid="this.setCustomValidity(\''.lang('@Wrong or missing data in ').$labl.' ! \')" oninput="setCustomValidity(\'\')" ';
    $pattern= '';
    $numPattern= ' pattern="^[^0-9\-]{0,4}\s?-?\d[\d\s.,]*\s?[^0-9]{0,4}$" ';   # Formatted numbers: "$ 1 234,50", "87 %", "-12.5"

    if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    # Number fields (dec0..2, num0..3): the value as formatted number - empty stays empty, a non-number is shown as typed
    $numVal= function($dec) use ($valu) {
        $v= trim((string)$valu);
        if ($v === '') return '';
        if (!preg_match('/\d/', $v)) return sys_enc($v);
        return number_format(sys_toFloat($v), $dec, DecimalSep, ThousandsSep);
    };
    $numUnit= function($dec) use ($numVal, $pref, $suff) {         # With the unit - but an empty field stays empty (the unit alone fails the pattern)
        $n= $numVal($dec);  return ($n === '') ? '' : $pref.$n.$suff;
    };
    $top= '';
    $just= ''; 

    switch ($vrnt) { ## VARIANTS:
        case 'intg' : $result.= '<input type= "number" '.$inpIdNm. $inpStyle. '"'.($step>'' ? ' step="'.$step.'"' : ''). ' value="'.$valu.'" '. $aktiv. $plh. $attr.' />';  break;
        case 'text' : $result.= '<input type= "text" '.  $inpIdNm. $inpStyle. '" value="'. $valu.'" '. $eventInvalid. $aktiv. $plh. $attr.' />';  break;
        case 'dec0' : # Used for quantity - outputs unit as prefix or suffix
        case 'dec1' : # Used for Amount -  // SPACE as thousands separator
        case 'dec2' : $result.= '<input type= "text" '.  $inpIdNm. ' value="'.$numUnit((int)substr($vrnt,3,1)). '" '.
                        $inpStyle. '"'. $eventInvalid. $aktiv. $plh. $attr. $numPattern. ' />';  break;
        case 'num0' : 
        case 'num1' :   // thousands separator ,|. is not allowed in number !  - https://codepen.io/nfisher/pen/YYJoYE/ - SPACE will be removed
        case 'num2' :   /* lang="en" to allow "."-char as decimal separator, and national ","-char */
        case 'num3' : $result.= '<input type="text" '. $inpIdNm. ' lang="en" step="'.$step.
                            '" value="'.$numUnit((int)substr($vrnt,3,1)).'" '.      # (was FIXIT "Wrong output": empty became 0,00)
                            //'" value="'.$valu.'" '. 
                            $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" '.$numPattern. ' />';  break; // No unit but with browser type check ! 
              ## Number values accepted by input-validation, has to be cleaned 
              ## for SPACE '%' and currency symbols (prefix/suffix), before saved in DB !
              ## Also check the decimal separator.
        case 'barc' : $result.= '<input type= "text" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 'title="'.$valu.'"'.
                        $inpStyle. ' font-family:barcode; font-size:19px; font-weight:normal; '. '" />';  break;
        /* case 'qrcd' : $result.= '<input type= "text" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr.  // 2D QR code
                        $inpStyle. ' font-family:barcode; font-size:19px; font-weight:normal; '. '" />';  break; */
        case 'mail' : $result.= '<input type= "email"'. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" pattern="^[^\s@]+@[^\s@.]+(\.[^\s@.]+)+$" />';  break;     # (was: the regex with ' />' shown in the hint)       // (?i)\b[A-Z0-9._%+-]              +@(?:[A-Z0-9-]+   \.)+[A-Z]{2,6}\b
        case 'link' : $result.= '<input type= "url" '.  $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        //'pattern="^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?"'.
                        $inpStyle. '" pattern="https?://.+" />';  break;

        case 'sear' : $result.= '<input type="search" '.$inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" />';  break;

        case 'file' : $result.= '<input type= "file" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle.$dataStyle. '" />';  break;

        case 'imag' : $result.= '<input type= "image" '.$inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr.
                        $inpStyle. ' height: 18px;" />';  break;

        case 'date' : $result.= '<input type= "date" '. $inpIdNm. $inpStyle. ' display:inline-block;'.' min-width: 105px; '. // if empty: color: green;
                                ' margin: 5px 5px 0; padding: 8px 2px 2px 2px;" value="'.$valu. '" placeholder = "yyyy-mm-dd" '. $aktiv. $attr. ' />';  break;
        case 'time' : $result.= '<input type= "time" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. 
                        $inpStyle. '" />';  break;
        case 'week' : $result.= '<input type= "week" '. $inpIdNm. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv. $attr.' />';  break;
        case 'mont' : $result.= '<input type= "month" '.$inpIdNm. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="?" '. $aktiv. $attr.' />';  break;

        case 'rang' : $result.= '<span class="fieldContent boxStyle range-wrap" style="height: 32px; ">'.
                                '<input class="range" type= "range" '.$inpIdNm. '  value="'.$valu.'" '. $aktiv. $attr. /* 'onclick="setBubble('.$name.',\'bubbleDiv\') " ' . */
                                ' oninput="this.nextElementSibling.value = this.value" style= "text-align: '.$algn.'; font-size: 12px; margin: 0; padding-top: 5px; box-shadow: none;" /> 
                                <output style="top: -18px; left: 45%; position: relative; font-size: 10px">'.$valu.'</output>'.
                            '<div class="bubble" 
                                  style="font-size: 10px; position: relative; width: 100%; text-align: center; opacity: 80%; top: -37px; "> '. // ' min="0" max="50"'
                                   '<span style="width: 10%; float:left;">min='.(preg_match('/\bmin\s*=\s*["\']?(-?[\d.]+)/', $attr, $mn) ? $mn[1] : '0').'</span> '.
                                  // '<span style="width: 33.33%;"> './* $valu. */'</span> '.
                                   '<span style="width: 20%; float:right;">max='.(preg_match('/\bmax\s*=\s*["\']?(-?[\d.]+)/', $attr, $mx) ? $mx[1] : '100').'</span>'.
                            '</div>'.
                            '</span>';  break; // min / value / max (the min and max from the attributes, as the browser uses them)

        case 'butt' : $result.= '<span class="fieldContent boxStyle" style="min-height: 28px;">'.
                            '<input type= "button" '.   $inpIdNm. ' value="'.$valu.'" '. $aktiv. $attr.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" /> </span>'; break; // No functionality !

        case 'subm' : $result.= // '<span class="fieldContent boxStyle" style="min-height: 28px;">'.
                            '<input type= "submit" '.   $inpIdNm. ' value="'.$valu.'" '. $aktiv. $attr.
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" '.'/> '/* .'</span>' */; break;

        case 'colr' : $result.= ## COLOR:
                            '<span class="fieldContent boxStyle" style="height: 28px;">'.
                            '<input type= "color" '.    $inpIdNm. ' value="'.$valu.'" '. $aktiv. $attr.
                        $inpStyle. ' margin: 0; padding: 0; width: 100%;border-radius: 4px;" /> </span>'; break;

        case 'phon' : $result.= ## PHONE:
                            '<input type= "tel" '. $inpIdNm. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. $attr. $inpStyle. '" />';  break;

        case 'pass' : $result.= ## PASSWORD:
                            '<span class="fieldContent boxStyle" style="'.$bord.' text-align: left; '.($rows!='0' ? 'height: 36px; ':'').'padding-right: 20px;">'.
                            '<div style="white-space: nowrap;">'.
                                '<input type= "password" '. $inpIdNm. /* $inpStyle. */' style="font-weight: 600; height: 8px; width: 75%; margin-top: -1px; 
                                    box-shadow: none;" value="'. $valu.'" '.$eventInvalid. $aktiv. $plh. $attr.' onkeyup="pw_strength(this)" 
                                 />'.
                                 # labl:'', icon:'', hint:'', type:'submit', name:'', link:'', evnt:'', wdth:'', font:'32px', fclr:'gray' bclr:'white', akey:'', rtrn:false)
                                htm_IconButt($btnlabl='', $btnicon='far fa-eye fa-fw colrgreen',$btnhint= lang('@Show/Hide password'),
                                             $btntype='button', $btnname='tgl_'.$name, $btnlink='',
                                             $btnevnt='onmousedown=\'togglePassword(document.getElementById("'.$iid.'"),this)\'', $wdth='', $btnfont='14px;', 
                                             $btnfclr='green', $btnbclr='white; padding-right:3px; padding-bottom:1px; margin-top:1px; width:28px;',
                                             $btnakey='', $btnrtrn=true ).
                            '</div>';
                            $str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
                            if ($rows!='0')
                                $result.= '<meter id= "pwPoint_'.$iid.'" style="position:relative; height:12px; width:100%; top: -10px;" '. 
                                          'min="0" low="6" optimum="7" high="9" max="10" '.
                                          'title="'.lang('@Password strength: 0..10').'">'. // $str.'"'. // ' <span id=\"mtPoint\"'.$name.'> 0</span>'. '/10"'.
                                     '</meter>'; 
                      $result.= '</span>';  break;

        case 'area' : $result.= ## TEXTAREA:
                        '<span class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 0;"> <textarea rows="'.$rows.'" id="'.$iid.'" name="'.$name.
                        '" style="width:99%; font-size: 1em; border: 1px solid Gainsboro; border-radius: 4px; '.$dataStyle.' '.'" '.
                        $eventInvalid. $aktiv. $plh.$attr.' >'.$valu.'</textarea></span>'; $just= 'top: -4px; position: relative;'; break;

        case 'html' : $result.= ## HTML-TEXT:
                        '<div class="fieldContent boxStyle" style="'.$bord.' padding: 10px 4px 4px; font-size: smaller;"><div contenteditable="'.($disa ? 'false' : 'true').'" role="textbox" aria-multiline="true"'.($disa ? ' aria-disabled="true"' : '').' id="'.$iid.'"'.
                        ' oninput="this.nextElementSibling.value= this.innerHTML;"'.     # The hidden field carries the HTML to the server
                        ' style="background-color: white; min-height: '.($rows>'1' ? '34px;' : '5px;').' border: 1px solid Gainsboro; padding: 2px; " '. //  Like area, but with html-content
                        ' data-placeholder="'.lang($plho).'" '. $attr.' >'. $valu.'</div>'.         # (disa: not editable - was the attribute disabled, which a div ignores)
                        '<input type="hidden" name="'.$name.'" value="'.sys_enc((string)$valu).'"'.$aktiv.'/></div>';
                        // if ($disa) $result.= '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>';  
                        $just= 'top: -4px; position: relative;'; break;

        case 'chck' : $result.= ## CHECKBOX:
                            '<span class="fieldContent boxStyle '.(count($list)== 1 ? 'fieldSingle' : '').'" style="'.$bord.' ">';
                            $i=0;
                            foreach ($list as $rec) { // $list= [['name','@Label','@ToolTip'], ['0:name',1:'@Label',2:'@ToolTip',3:state:'checked/selected',4:otherAttr (id="idxx")], ['@Label','@ToolTip'],...]
                                $rec = array_pad($rec, 4, null); // Ensures that there are always at least 4 elements
                                $on= isset($_POST[$rec[0]]) || ($valu == $rec[0]) || ($valu == 'checked') ||
                                     (is_string($rec[3]) && (stripos(' '.$rec[3], 'checked') > 0));
                                $chk= $on ? ' checked ' : ' ';
                                array_push($rec, '', '');   # Prevent error on $rec[3] / $rec[4]
                                $result.= '<span style="display: inline-block; top: 3px; position: relative;">';
                                ## https://stackoverflow.com/questions/11424037/do-checkbox-inputs-only-post-data-if-theyre-checked (dublicated id because of this !)
/*  Copilot:
    <input type="checkbox" id="agree" onchange="document.getElementById('agree_hidden').value = this.checked ? '1' : '0'">
    <input type="hidden" id="agree_hidden" name="agree" value="0">
 */
                                // if(isset($_POST['subscribe'])) echo 'checked';   (isset($_POST['subscribe']) ? 'checked' : '')
                             // $result.= '<input type= "hidden"   id="'.$rec[0].'" name="'.$rec[0].'" value="unchecked" /><label for="'.$rec[0].'"></label>'; # Hidden field because Unchecked boxes is not included in $_POST !
                             // $result.= '<input type= "checkbox" id="'.$rec[0].'" name="'.$rec[0].'" value="checked" '.$aktiv. (is_array($rec[3]) ? $rec[3][$i++][1] : $rec[3]).' '. $rec[4]. ' '.$valu.' style="width: 20px; box-shadow: none; scale:1.3;"/>'.
                                $result.= '<input type= "checkbox" id="'.$rec[0].'" name="'.$rec[0].'" value="checked" '.$aktiv. $chk. $rec[4]. ' style="width: 20px; box-shadow: none; scale:1.3;"/>'.
                                   '<label for="'.$rec[0].'" style="position: relative; top: 0px; width: min-content;'.$lpos.'">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; '.$attr).'</label>';
                                 //  '<label for="'.$rec[0].'"                                              ">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; '.$attr).'</label>';
                                $result.= '</span>';
                             //   if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= ''.($subm ?? '').'</span>';  break; 

        case 'rado' : $result.= ## RADIO:
                            '<span class="fieldContent boxStyle" style="'.$bord.'"><small>';
                            foreach ($list as $rec) { // $list= [[0:'value',1:'Label',2:'@ToolTip',3:state:'checked/selected'], ['Label','@ToolTip'],...]
                                if ($valu==$rec[0]) $chk= ' checked '; else $chk= ' ';
                                    $result.= '<input type= "radio" id="'.$iid.'_'.$rec[0].'" name="'.$name.'" value="'.$rec[0].'" '.
                                        $chk.($rec[3] ?? '').$aktiv. ' '.$attr.' style="width: 20px; box-shadow: none;">'.
                                     '<label for="'.$iid.'_'.$rec[0].'" style="position: relative; top: -2px;">'. Lbl_Tip($rec[1] ?? $rec[0],$rec[2] ?? '','','12px; box-shadow: none; ').'</label>';   # (the tooltip is optional - was a PHP warning)
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small>'.($subm ?? '').'</span>';  break;

        case 'opti' : $result.= ## OPTION:
                            '<span class="fieldContent boxStyle"  style="'.$bord.' background-color; white; text-align: center; padding: 10px 4px 4px;"><small>';
                            $result.= '<select class="styled-select" id="'.$iid.'" name="'.$name.'" '.($events ?? '') .' '.$eventInvalid.'style="width: 98%; border-color: Gainsboro; '.($valu>'' ? 'font-weight: 600;':'color:var(--grenColr1)').($colr ?? '').'" '.$attr.' '.$aktiv.'> '; dvl_pretty();
                            $result.= '<option label="'.lang($plho).'" value="'.$valu.'">'.lang('@Select!').'</option> ';  # title="'.$hint.'"     selected="'.$valu.'"
                            foreach ($list as $rec) { # $list= [[0:value, 1:name, 2:@ToolTip, 3:state:'checked/selected', [...]]
                                $result.= '<option '. /* .'label="'.lang($rec[x]).'" '. */ 'title="'.lang($rec[2] ?? '').'" value="'.$rec[0].'" '.($rec[3] ?? '').' '.($rec[4] ?? ''); //  Firefox does not support Label !
                                if ($rec[0]==$valu) $result.= ' selected ';
                                $result.= '>'.$lbl=lang($rec[1]).'</option> ';
                            }   $result.= '</select></small>'.($subm ?? '').'</span>';  break;
                            
    //  case 'show' : $result.= '<input type= "text"   id="id_'.$name.'" name="'.$name.'" value="'.$valu.'" disabled />';  break;
    
        case 'hidd' : $result.= ## INVISIBLY:
                            '<input type= "hidden" id="'.$iid.'" name="'.$name.'" value="'.$valu.'" />';  break;

        default     : $result.= ## UNSPECIFYED:
                            ' htm_Input(): Illegal vrnt ! ';
        dvl_pretty();
    }

# htm_Input: LABEL & HINT:
    $lblFor= $iid;                                        # Group label: point to the first option (there is no element id_<name>)
    if (($vrnt=='rado') and isset($list[0][0])) $lblFor= $iid.'_'.$list[0][0];
    if (($vrnt=='chck') and isset($list[0][0])) $lblFor= $list[0][0];
    if ($vrnt=='area') $lblFor= $iid;                            # The <textarea> has id = name (tinyMCE selectors use it) - the first one
    switch (strtoupper($llgn)) {
    case 'L': $lblalign = 'margin-right: auto;';  break;   // Align label Left
    case 'C': $lblalign = 'margin:       auto;';  break;   // Align label Center
    case 'R': $lblalign = 'margin-left:  auto;';  break;   // Align label Right
    default:  $lblalign = 'margin-left:  auto;';
    }
    if ($vrnt!='hidd')
        $result.= ' <abbr class= "hint">'.
                ($labl>'' ? 
                   '<label for="'.$lblFor.'" style="font-size: 12px; '.$top. ' vertical-align:top; ">
                        <div style="white-space: nowrap; '.$lblalign.$just.'">'.$icon.$labl.'</div>
                   </label>' : '').($hint>'' ?
                   '<data-hint style="top: 45px; left: 2px;">'. $hint.
                        ($unit>'' ? (' <br>'.lang('@Unit: ').ltrim($unit,'<')) : '').
                        ($pattern>"" ? ('<br><div style="color:green">'. $pattern. '</div>') : '').
                   '</data-hint>' : '').
               '</abbr>';                                       # Always closed (was: only when there was a hint)
         if ($vrnt!='hidd')
            $result.= '</div>'; # :FIELD inpField
    if ($form>'') $result.= (in_array($vrnt, ['chck','rado','opti']) ? '' : $subm).'</form>';   # (chck/rado/opti have the OK button inside the field)

    if (!$rtrn) echo $result; else return $result;
} # :htm_Input()


# A ontainer with: Border, Label, Hint, (Placeholder)
function htm_Inbox(# labl:'', plho:'@Enter...', icon:'', hint:'', vrnt: 'noUse', name:'noUse', valu:'', form:'noUse', wdth:'200px;', algn:'left',attr:'', rtrn:false, unit:'noUse', disa:false, rows:'noUse', step:'noUse', list:['noUse'], llgn:'R', bord:'1px solid var(--grayColor);', ftop:'')
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
    '<div class="boxStyle" id="'.($bid= sys_uid('id_Inbox_div_'.$name)).'" style="  '.                /* The outher div with border: */
           'box-shadow: 3px 4px 2px var(--shadColor);
            border-radius: 5px;
            border: '.$bord.'
            '.$ftop.'
            width: '.$wdth.';
            padding: 10px 5px 2px 5px;
            margin: 5px 2px 2px;
            /* background-color: transparent; */
            display: inline-block;
            vertical-align: top;
            text-align: '.$algn.';
            ">
        <abbr class= "hint" >'.                                                                             /* The Tooltip-container shown on mouse over */
           '<label for="'.$bid.'" style="font-size: 12px; height: 0; display: block; '.$lblalign.'; ">'.   /* The Label above the field content */
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
            <div style="position: relative; ">'. 
                '<data-hint style="left: -5px;">'.lang($hint).      /* The text for the Tooltip */ 
                '</data-hint>
            </div>
        </abbr>
        <div id="'.sys_uid($name).'" class="p2hInbox" '.$disa.' data-ph="'.sys_enc(strip_tags(lang($plho))).'"'.   /* The inner div-field content */
            ' style="font-size: smaller; '.$attr.' ">'.
                    $valu.
        '</div>
    </div>';
    if (!$rtrn) echo $result; else return $result;
} # htm_Inbox

# General output for pt. Progress etc. [Necessary basic element]
function htm_Output(# labl:'', icon:'', hint:'', vrnt:'pgrs', name:'', form:'', valu:'', vmax:'',attr:'',bclr:'white',rtrn:false)
    $labl='',           # string: The caption text                                               
    $icon='',           # string: comming new (label prefix)                                     
    $hint='',           # string: The hint/tooltip
    $vrnt= 'pgrs',      # string: Variant (outp/pgrs)
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
    $result= '<span id="id_'.$name.'" style= "padding: 2px 5px; position: relative;'.$bclr.'; ">';
    if ($hint>'') $result.= ' <abbr class= "hint">';
    switch ($vrnt) { // Variants:
        case 'outp' : $result.= '<label for="id_'.$name.'_outp">'.$icon.lang($labl).'</label>'. # Output element with label and hint
                                '<output id="id_'.$name.'_outp" name="'.$name.'outp" for="'.$valu.'" form="'.$form.'">
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
                      $result.= '<label for="id_'.$name.'_pgrs">'.$icon.lang($labl).'</label>'. # Output Progress indicator
                                '<progress id="id_'.$name.'_pgrs" '.$value.' max="'.$vmax.'" >
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


# A caption with icon, label and hint
function htm_Caption(# labl:'',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 13px;',rtrn:false)
    $labl='',       # string: The caption text
    $icon='',       # string: label prefix
    $hint='',       # string: The hint/tooltip
    $algn='',       # string: Caption Alignment
    $styl=          # string: Default Caption text style
          'color:#550000; font-weight:600; font-size: 13px;',
    $rtrn=false
) { global $gbl_iconColor;
    if ($icon>'') $icon= '<ic class="'.$icon.'" style="color: '.$gbl_iconColor.'; margin: 0 5px;"></ic>&nbsp;'; else $icon= '';
    if ($algn>'') $algn= ' text-align: '.$algn.';';
    $result= '<abbr class= "hint">
            <data-colrlabl style="'.$styl.$algn.'">'.$icon.' '.lang($labl).'</data-colrlabl>';
            if ($hint>'') $result.= '<data-hint> '.lang($hint).' </data-hint>';
    $result.= '</abbr>';
    if (!$rtrn) echo $result; else return $result;
}

# Text formatted in a div
function htm_TextDiv(# body:'', algn:'left', marg:'8px', styl:'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',attr:'background-color: white;', rtrn:false )
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

# Text displayed in a fixed-width font, and preserves both spaces and line breaks
function htm_TextPre(# body, algn:'left', marg:'8px', attr:'', font:'', code:false, rtrn:false)  ## Preformatted HTML text
    $body,          # string: Html-text inside pre
    $algn='left',   # string: pre-text alignment
    $marg='8px',    # string: Default pre margin
    $attr='',       # string: Other style
    $font='',       # string: pre-text font
    $code=false,    # bool:   convert: &lt;b&gt;bold&lt;/b&gt;
    $rtrn=false     # bool:   Act as procedure: Echo result, or as function: Return string
) {
    if ($code) $body= htmlspecialchars($body); // convert: &lt;b&gt;bold&lt;/b&gt;
    if ($font>0) $font= ' font-family: '.$font.'; ';
    $result= '<pre style="margin: '.$marg.'; text-align: '.$algn.'; '.$font.' white-space: pre-wrap; '.$attr.'">'. $body. '</pre>';
    if (!$rtrn) echo $result; else return $result;
}

/*     function htm_CodeDiv($code,$rtrn=false) { // htm_CodeDiv(highlight_words(highlight_string('<? '.$strCode,true)));
    $result= '<p style="text-align: left; padding:4px; white-space: nowrap; overflow-x: auto; line-height: 1; background-color:#121212;">'; // #121212
    $result.= $code; //str_replace(['$','"'],['\$','\"'],$code);
    $result.= '</p>';
    if ($rtrn==false) echo $result;
    else return $result;
};
 */

/* 

<dt>	a term in a description list
<dd>	Describes the term in a description list
 */
 
# Starting various types ef text list
function htm_List_(# capt:'', vrnt:'ul', type:'circle', $strt:'0', styl:'text-align:left;', rtrn:false)
$capt='',                   # string: Html-text
$vrnt='ul',                 # string: Variants: <ul> an unordered list  /  <ol> an ordered list  /  <li> a list item  /  <dl> a description list
$type='disc',               # string: List-style marker type (Ref: https://www.w3schools.com/cssref/playdemo.php?filename=playcss_list-style-type)
$strt='0',                  # string: Index start for ordered list
$styl='text-align:left;',   # string: Other style rel. body
$rtrn=false                 # bool:   Function Return or echo result
) { $mark=' style="list-style-type: '.$type.'; "';
$result= '<span style="'.$styl.'">';
    switch ($vrnt= strtolower($vrnt)) {
        case 'ul' : $result.='<ul '.$mark.'>';                    break; # Unordered list
        case 'ol' : $result.='<ol '.$mark.' start="'.$strt.'">';  break; # Ordered list
        case 'li' : $result.='<ul '.$mark.'>'; $vrnt='ul';        break; # List of items with the chosen marker
        case 'dl' : $result.='<dl '.$mark.'>';                    break; # Description list
        default   : $result.='<'.$vrnt.' '.$mark.'>';                    # Custom variant
    }
    $result.= lang($capt);
    $GLOBALS['ListVrnt']= $vrnt;
    $GLOBALS['ListMark']= $mark;
    if ($rtrn==false) echo $result; else return $result;
}

# A single item in a text list
function htm_List_item(# labl:'', body:'', rtrn:false)
$labl='',       # string: Html-text - term/name in a description list
$body='',       # string: Variants: <dt> term/name in a description list.  /  <dl> an description list
$rtrn=false     # bool:   Function Return or echo result
) {
    switch ($flag= $GLOBALS['ListVrnt']) {    
        case 'dl' : $result= '<dt>'.lang($labl).'</dt>'.
                             '<dd>'.lang($body).'</dd>';    break; # Description list
        default   : $result= '<li>'.lang($body).'</li>';         # Item in ul / ol / custom lists (the marker style is set on the list)
    }
    if ($rtrn==false) echo $result; else return $result;
}

# Ending a text list
function htm_List_end(# rtrn:false)
$rtrn=false     # bool:   Function Return or echo result
) { $result= '</'.$GLOBALS['ListVrnt'].'>'. '</span>';
    if ($rtrn==false) echo $result; else return $result;
}


## Hightlight - Custom word-list and custom style: 
function highlight_words($text, $wrds='', $styl='',$patt='~\w{4,10}~') { 
    if ($wrds=='')
        $wrds='labl capt body foot plho icon hint desc type name valu vmax vmin form subm acti clas wdth heig algn marg styl attr mode font colr fclr bclr llgn link targ akey kind echo unit disa rows step bord plac rept rtrn titl info inis imag pbrd simu clck stck cntx text html srce butt mess tplc tsty head evnt note rept shrt frst last from to__ elem pref suff filt data crea modi expo just sort filt vrnt capt pref body suff idix note data filt sort crea modi vhgh styl from list enbl dflt strt expo show poup help ftop code synt repl tout
              ';
    else $wrds.= $wrds;
    $wrds= str_replace(' ',': ',$wrds); # Add : to all words
    if ($styl=='') $styl='color:'.'cyan; './* '#550000 #a16802; '. */ 'font-style:italic;';
    preg_match_all($patt, $wrds, $matches);
    if(!$matches) return $text;
    $styl= 'style="'.$styl.'" ';
    $replacement = '~\\b(' . implode('|', $matches[0]). ')\\b~';
    return preg_replace($replacement, '<span '.$styl.'>$0</span>', $text);
} 

## Remove the needed triggering <?php prefix
function highlight_str($code,$rtrn=true) { 
    $source= highlight_string('<?php '.$code,true);                              # Full tag: works also when short_open_tag=Off
    $result= preg_replace('/&lt;\?php(&nbsp;|\s)?/','',$source,1);             # Remove the triggering prefix
    $result= str_replace('<code style="color: orange;">','',substr($result,0,80)).substr($result,80);
    $result= str_replace('</code>','',$result); ## Added in highlight_string() !
    if ($rtrn==false) echo $result; else return $result;
}
   
# A span containing syntax formattet php-code
function htm_CodeBox(# code:'', synt:true, repl:false, fmat:'',  vlue:'', rtrn:false)
    $code='',       # string: php-code with syntax display
    $synt=true,     # bool:   Activate syntax output
    $repl=false,    # bool:   Do output formattet string
    $fmat='',       # string: Format string
    $vlue='',       # string: Value to replace 
    $rtrn=false     # bool:   Function Return or echo result
    ){
    if ($repl==true) {                                  // The format string with the value inserted, followed by the code
        try { $code= sprintf($fmat, $vlue).$code; }
        catch (\ArgumentCountError $e) { $code= $fmat.$vlue.$code; }   // More placeholders than values: show unformatted
    }
    $result= '<span style="text-align: left; white-space: nowrap; overflow-x: auto; line-height: 1;">
              <pre style= "background-color: #121212; text-align: left;  padding:6px; overflow-x: auto; ">'.
              (($synt==true) ? highlight_words(highlight_str($code)) : $code ).
              '</pre></span>';
    if ($rtrn==false) echo $result; else return $result;
};

# Vertical orientated text
function htm_TextVer(# body, algn:'left', marg:'8px', attr:'', font:'', code:false) ## Vertical text
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

# A very small text line
function htm_MiniNote(# note:'') # Very small text-line
    $note= ''
)
{   echo '<br><small><small>'.lang($note).'</small></small>';
}

# A text with a caption on colored line
function htm_TextTip(# capt:'TIP', body:'', wdth:'', algn:'center', colr:'')
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
        '<div style="background-color: '.$colr.';'.                # Caption text: black or white, the best contrast to a hex color
            (preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $colr) ? ' color: '.getOptimalBackground($colr).';' : '').'">'.lang($capt). '</div>'.
        '<div style="padding: 8px; ">'.$body.'</div>'.
    '</div>';
}

# A div containing a text with a hidden hint
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
    <style>.tiptext:hover > .description { display: block !important; }</style>';   # (no jQuery needed)
    if (!$rtrn) echo $result; else return $result;
}

# A image with caption, label and a hint
function htm_Figure(# capt:'',type:'',imag:'',styl:'',labl:'',hint:'',rtrn:false) {
    $capt= '',      # string: The header text
    $type= 'h1',    # string: Header type (h1..h6)
    $imag='',       # string: Path to the image
    $info= '',      # string: alternative text
    $styl= '',      # string: Styles for the image
    $labl= '',      # string: The figure caption/label
    $hint= '',      # string: Hidden description
    $rtrn= false    # bool:   Function Return or echo result
) 
{   $result= '<'.$type.'>'.lang($capt).'</'.$type.'>
        <figure>
          <img src="'.sys_enc($imag).'" alt="'.sys_enc(strip_tags(lang($info))).'" style="'.$styl.'">
          <figcaption>'.lang($labl).'</figcaption>
        </figure>';
    if ($hint>'') $result= 
        '<abbr class= "hint" style="position: relative;">'.
            $result.
            '<data-hint style="left: auto;">'.lang($hint).'</data-hint>'.
        '</abbr>';
    if (!$rtrn) echo $result; else return $result;
}

# A summery list with collapsible details
function htm_Details(# capt:'',type:'',body:'',styl:'',labl:'',hint:'',mode:'',rtrn:false) { # Collapsibly text
    $capt= '',      # string: The header text 
    $type= 'h1',    # string: Header type (h1..h6)
    $labl= '',      # string: The details summary
    $body='',       # string: The details text
    $styl= '',      # string: Styles for capt & body & labl
    $hint= '',      # string: Hidden description
    $mode= '',      # string: Initial mode: 'open'/''
    $rtrn= false    # bool:   Function Return or echo result
) 
{   if ($capt>'')
        $result= '<'.$type.' style="'.$styl.'">'.(($capt>'') ? lang($capt) :'').'</'.$type.'>';
    else $result= '';
        $result.= '
        <details '.$mode.' style="'.$styl.'">
            <summary>'.
                lang($labl).'
            </summary>
          <div style="margin-left:14px;">'.lang($body).'</div>
        </details>';
    if ($hint>'') $result= 
        '<abbr class= "hint" style="position: relative;">'.
            $result.
            '<data-hint style="left: auto;">'.lang($hint).'</data-hint>'.
        '</abbr>';
    if (!$rtrn) echo $result; else return $result;
}


# experimental: Change colors
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

# Get background color B/W with optimal contrast to Fg-color
function getOptimalBackground($hexFg) {
    $hexFg = str_replace('#', '', $hexFg);
    if (strlen($hexFg) == 3) {
        $hexFg = $hexFg[0].$hexFg[0].$hexFg[1].$hexFg[1].$hexFg[2].$hexFg[2];
    }
    $r = hexdec(substr($hexFg, 0, 2));
    $g = hexdec(substr($hexFg, 2, 2));
    $b = hexdec(substr($hexFg, 4, 2));
    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b);    // Beregner luminans
    return $luminance > 128 ? '#000000' : '#FFFFFF';        // Returnér sort eller hvid afhængig af lysstyrke
}
/*
$textColor = "#336699"; // blå
$optimalBackground = getOptimalBackground($textColor);
echo "Optimal baggrund: $optimalBackground";
 */
 
# Add strings to a buffer
# Big inline <style>/<script> blocks of the <head> become files in a cache folder, named by their content (hash): the browser keeps them
# between pages and visits (was ~110 KB in every page). Same place in the page = same order and effect. A block with the CSRF token or the
# session id stays inline. $gbl_AssetCache: folder (default _cache/ next to this library) - false: everything inline as before.
function p2h_assetFiles($html) {
    $dir= $GLOBALS['gbl_AssetCache'] ?? (__DIR__.'/_cache');
    if (!is_string($dir) or $dir === '') return $html;
    $url= $GLOBALS['gbl_AssetCacheUrl'] ?? (($GLOBALS['gbl_ProgRoot'] ?? '../').'_cache/');
    if (!is_dir($dir) and !@mkdir($dir, 0755, true)) return $html;
    if (!is_writable($dir)) return $html;
    if (!is_file($dir.'/.htaccess'))                    # The names change with the content: the browser may keep them for a year
        @file_put_contents($dir.'/.htaccess', "<IfModule mod_headers.c>\n  Header set Cache-Control \"public, max-age=31536000, immutable\"\n</IfModule>\n");
    $secret= array_filter([(string)($_SESSION['csrf_token'] ?? ''), (string)session_id()]);
    return preg_replace_callback('#<(style|script)( type="text/css")?>(.*?)</\1>#s', function($m) use ($dir, $url, $secret) {
        $code= $m[3];
        if (strlen($code) < 1000) return $m[0];                                    # Small blocks: not worth a request
        foreach ($secret as $x) if (strpos($code, $x) !== false) return $m[0];      # Never in a shared file
        $ext= ($m[1] === 'style') ? 'css' : 'js';
        $name= 'p2h-'.substr(md5($code), 0, 16).'.'.$ext;
        if (is_file($dir.'/'.$name)) {
            if (@filemtime($dir.'/'.$name) < time()-86400) @touch($dir.'/'.$name);   # In use: kept fresh (at most once a day)
        } else {
            foreach (glob($dir.'/p2h-*') ?: [] as $old)                            # A new version: remove files not used for 30 days
                if (@filemtime($old) < time()-30*86400) @unlink($old);
            $tmp= $dir.'/'.$name.'.'.getmypid().'.tmp';
            if (@file_put_contents($tmp, $code) === false or !@rename($tmp, $dir.'/'.$name)) { @unlink($tmp); return $m[0]; }
        }
        $href= htmlspecialchars($url.$name, ENT_QUOTES, 'UTF-8');
        return ($ext === 'css') ? '<link rel="stylesheet" href="'.$href.'">' : '<script src="'.$href.'"></script>';
    }, $html);
}

# The script/link tags of a library that is loaded where it is first used (htm_Page_ prepares them; $gbl_LazyLibs= false: in <head> as before)
function p2h_libTags($key) {
    static $done= [];
    if (isset($done[$key])) return '';
    $done[$key]= true;
    return $GLOBALS[$key] ?? '';
}

# htm_Table() suffix column type 'rowact' (value: 'del copy move undo' ...): row actions in the browser - delete (asks first), copy (below the
# row, as a new record: the hidden id field emptied), move up/down, undo the last row change. The rows are posted as field[] lists with the form,
# so the server gets the new rows and order when the card is saved. Tablesorter is told about every change.
function p2h_rowActs($acts) {
    static $jsDone= false;
    $def= ['del'  => ['fa-solid fa-trash-alt',   '#c62828', '@Delete the row'],
           'copy' => ['fa-regular fa-clone',     '#1565c0', '@Copy the row (the copy is inserted below it)'],
           'up'   => ['fa-solid fa-arrow-up',    '#2e7d32', '@Move the row up'],
           'down' => ['fa-solid fa-arrow-down',  '#2e7d32', '@Move the row down'],
           'undo' => ['fa-solid fa-undo',        '#ef6c00', '@Undo the last row change (delete, copy, move)']];
    $list= preg_split('/[\s,]+/', str_replace('move', 'up down', strtolower($acts)), -1, PREG_SPLIT_NO_EMPTY);
    $result= '';
    foreach ($list as $a) {
        if (!isset($def[$a])) continue;
        [$ic, $cl, $tip]= $def[$a];
        $result.= '<abbr class="hint"><button type="button" class="p2hRowAct" data-act="'.$a.'" aria-label="'.sys_enc(strip_tags(lang($tip))).'">'.
                  '<ic class="'.$ic.'" style="color:'.$cl.';" aria-hidden="true"></ic></button><data-hint style="left:auto; right:0;">'.lang($tip).'</data-hint></abbr>';
    }
    if (!$jsDone) { $jsDone= true;  $result.= '<script>
(function(){
  var T= '.json_encode(['ask'=>strip_tags(lang('@Delete the row?')), 'none'=>strip_tags(lang('@Nothing to undo'))], JSON_HEX_TAG | JSON_HEX_APOS).';
  function upd(t) { if (window.jQuery && t.config) jQuery(t).trigger("update"); }
  function rows(tb) { return [].filter.call(tb.children, function(r) { return r.tagName === "TR" && r.classList.contains("row") && r.style.display !== "none"; }); }
  function fresh(tr) {                                     /* A copy is a new record: no ids, the record id (first hidden field) empty */
    tr.removeAttribute("id");  tr.querySelectorAll("[id]").forEach(function(e) { e.removeAttribute("id"); });
    var h= tr.querySelector("input[type=hidden]");  if (h) h.value= "";
  }
  document.addEventListener("click", function(e) {
    var b= e.target.closest && e.target.closest(".p2hRowAct");  if (!b) return;
    e.preventDefault();
    var tr= b.closest("tr"), tb= tr.parentNode, t= tr.closest("table"), st= t.p2hUndo || (t.p2hUndo= []), a= b.dataset.act;
    if (a === "del") sysConfirm(T.ask, function() { st.push({k: "del", tr: tr, next: tr.nextSibling, tb: tb});  tb.removeChild(tr);  upd(t); });
    else if (a === "copy") { var c= tr.cloneNode(true);  fresh(c);  tb.insertBefore(c, tr.nextSibling);  st.push({k: "add", tr: c});  upd(t); }
    else if (a === "up" || a === "down") {
      var l= rows(tb), i= l.indexOf(tr), o= l[a === "up" ? i - 1 : i + 1];  if (!o) return;
      st.push({k: "move", tr: tr, next: tr.nextSibling, tb: tb});
      tb.insertBefore(tr, a === "up" ? o : o.nextSibling);  upd(t);  b.focus();
    }
    else if (a === "undo") {
      var u= st.pop();  if (!u) { sysAlert(T.none); return; }
      if (u.k === "add") u.tr.remove();
      else u.tb.insertBefore(u.tr, (u.next && u.next.parentNode === u.tb) ? u.next : null);
      upd(t);
    }
  });
})();
</script>'; }
    return $result;
}

function spool($data,$echo=false) { global $spool;
    if ($echo==true) echo $data;
    $spool.= $data;
}

function isBold($html) {
    return strpos($html, '<b>') !== false || strpos($html, '<strong>') !== false;
}

function isItal($html) {
    return strpos($html, '<i>') !== false || strpos($html, '<em>') !== false;
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

# Output data in a advanced table
# One CSV cell: quotes are doubled, and text starting with = + - @ (or tab/CR) gets a leading apostrophe,
# so Excel/LibreOffice does not execute it as a formula (CSV injection). Real numbers like -12.50 are left alone.
function sys_csvCell($v) {
    $v= (string)$v;
    if (($v>'') and (strpos("=+-@\t\r", $v[0]) !== false) and !is_numeric($v)) $v= "'".$v;
    return '"'.str_replace('"', '""', $v).'"';
}

# A table with records: sort, filter, edit, add rows and export to CSV [Necessary basic element]
function htm_Table(# capt:[], pref:[], body:[],suff:[], note:'', data:[], filt:true, sort:true, crea:true, modi:true, vhgh:'400px',  styl:'',  from:__FILE__,list:[],expo:'',rtrn:false)
    $capt= [ # ['0:Label',   '1:Width',    '2:Type',     '3:OutFormat', '4:td-style',       '5:Tip',    '6:placeholder', '7:Content';], ...
           ],
    $pref= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[td-style]', '5:ColTip', '6:Html'], ...
           ],           // if (($modi) or ($body[0][2]!='indx')) is 2% ColWidth can be used to => row-select-button
    $body= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[td-style]', '5:fldKey', '6:ColTip','7:placeholder','8:default','9:[selectList]'], ...
             # [ labl,        wdth,         type,         frmt,          feld[],            fkey,       hint,      plho,           dflt,       list ] # Future Fieldnames
           ],          # Field 4: $FieldProporties - is composed of: [horJust, FieldBgColor, FieldStyle, TdColor, sort, filt, SelectON, Unit?
                       #                                              just,    bclr,         styl,       colr,    sort, filt, slct,     unit
    $suff= [ # ['0:ColLabl', '1:ColWidth', '2:ContType', '3:OutFormat', '4:[td-style]', '5:ColTip', '6:value! '], ...
           ],
                # $capt= array:  HTML to be shown above the table
                # $pref= array:  Leding columns left to the table data
                # $body= array:  Rows with table data
                # $suff= array:  Ending columns right to the table data
    $note= '',         # string: HTML-string - note to be shown below the table
    &$data= [],        # array:  [{"name_0":value_0, "name_1":value_1, "name_2":value_2, "name_3":value_3, "name_4":value_4, "name_5":value_5, "name_6":value_6, "name_7":value_7, "name_8":value_8, "name_9":value_9},{...},{...}]
    $filt= true,       # bool:   Ability to hide records that do not match filter // Does not work with hidd fields!
    $sort= true,       # bool:   Ability to sort records by column content
    $crea= true,       # bool:   Ability to create a records - string: Labeltext on createButton
    $modi= true,       # bool:   Ability to select and change data in a row
    $vhgh= '400px',    # string: The height of the visible part of the table's data
    $styl= '',         # string: Style for the span that holds the table;
    $from= __FILE__,   # string: = __FILE__ / __FUNCTION__ (debugging: locate error)
    $list= ['',''],    # array:  LookupLists for options // Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
    $expo= '',         # string: Export values in table data fields to CSV-file
    $rtrn= false,      # bool:   Function Return or echo result
    $wdth= '98%'       # string: The width of the table parent (span)
// ,$dropFirst=false   # remove first field (dbIndex id) from TblData-rows
)
                       # Field 4: $FieldProporties - is composed of: [0:horJust, 1:FieldBgColor, 2:FieldStyle, 3:TdColor, 4:SorterON, FilterON, SelectON, Flst]
                       # 0:td-style - Arguments to .td: style="text-align:
                       # 1:FieldBgColor - Arguments to .td: background-color:
                       # 2:FieldStyle - complete expression, e.g.: 'font-style:italic; '
                       # 3:TdColor - like 1: but used for "row marking"
                       # 4: 5: 6: ...
                       # Only impact on Body areas.

#    (Fixed: sticky headers in every table - each is attached to its own wrapper.)
# !          Zebra streaks (Update Issue!) Failure, as well as filter problems when hidden columns are also present.
#    (Checked: input values are posted from every table.)
#    (Fixed: rows with field names are placed by the field names of body; rows without names by their order.)

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
        run_Script( 'function rowLookup(CalledFrom,valu,RowIx,ColIx) { sysAlert("'.lang('@You pressed ').'" + valu + '.
            '"\nNothing is happening yet...\nRelates to: "+ CalledFrom +" Row: "+ RowIx );'.
            ' }');
        function RowKlick($modi,$valu,$RowIx,$ColIx,$fldNames,$from,$ixalign) {
            if (!$modi) {return $RowIx;}
            # Only the file name - never the server path (was: the full __FILE__ path in the page HTML)
            $src= preg_replace_callback('~(?:[A-Za-z]:)?[\\\\/]\S+~', function($m) { return basename(str_replace('\\', '/', $m[0])); }, (string)$from);
            $js= function($v) { return sys_enc(json_encode((string)$v, JSON_UNESCAPED_UNICODE)); };   # Safe JS string in an attribute
            return
            '<span style=" padding:3px 0;" onclick="rowLookup('.$js($src).','.$js($valu).','.$js($RowIx).','.$js($ColIx).')" >'.
            '<input name="'.$fldNames[$ColIx].'[]"
                style="width:99%; text-align: center; '.$ixalign.' text-decoration: underline; color: blue; cursor:zoom-in; background-color: transparent; font-weight:600;"
                readonly onkeydown="if (event.key===\'Enter\') { event.preventDefault(); this.click(); }"
                value="'.sys_enc((string)$valu).'" />'.
            '</span>';
        };
    }

    echo p2h_libTags('p2hTsTags');                       # Tablesorter: loaded with the first table (echo: the init script below is echoed at once too)
    spool( '<span class="tableStyle" id="tblSpan'.$gbl_TblIx.'" style="'.($wdth>'' ? 'width:'.$wdth.'; ' : '').' padding: 8px; '.$styl.' ">');
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
        if ($sort)  {echo htm_IconButt(labl:'@Sort?', icon:'fas fa-sort', type:'button', font:'12px', rtrn:true,   # An info button (its hint) - was positional with the wrong order: type became the label...
            hint: lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.')); }
        if ($filt)  {echo htm_IconButt(labl:'@Filter?', icon:'fas fa-search-plus', type:'button', font:'12px', rtrn:true,   # An info button (its hint) - was positional with the wrong order: type became the label...
            hint: lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
                   lang('@Enter a search term here to display only data that matches the term.')); }
        if ($filt)  {echo htm_IconButt(labl:'@Show everything!', icon:'fas fa-search-minus', type:'button', font:'12px', rtrn:true,   # An info button (its hint) - was positional with the wrong order: type became the label...
            hint: lang('@Reset filter so that all data is displayed. With ESC you can reset the search term in the field you are in.')); }
        if ($modi) {echo htm_IconButt(labl:'@Edit?', icon:'fas fa-pen-square', type:'button', font:'12px', rtrn:true,   # An info button (its hint) - was positional with the wrong order: type became the label...
            hint: lang('@In some of this table`s columns, you can correct data. They are marked with · in the column heading.').str_nl().
                   lang('@If the table cannot be saved, the correction must be done on a retail card.')); }
        if ($crea) {echo htm_IconButt(labl:'@Add?', icon:'fas fa-plus', type:'button', font:'12px', rtrn:true,   # An info button (its hint) - was positional with the wrong order: type became the label...
            hint: lang('@Do you want to add data: <br>At the bottom of the table there are fields you can fill with new data. ').
                   lang('@Click the "Create" button above the last field to save the new data.')); }
        if (true)  {echo htm_IconButt(labl:'@Keys ', icon:'fas fa-arrows-alt-h', type:'button', font:'12px', rtrn:true,   # An info button (its hint) - was positional with the wrong order: type became the label...
            hint: lang('@Move cursor in tables:').'<br><data-yelllabl>'.lang('@TAB-key').'</data-yelllabl> '.
            lang('@jumps to the next field.').' <data-yelllabl>'.lang('@SHIFT TAB-key').'</data-yelllabl> '.lang('@skips to the previous field.').
            ' <data-yelllabl>'.lang('@SPACE-key').'</data-yelllabl> '.lang('@scrolls side down').
            ' <data-yelllabl>'.lang('@SHIFT SPACE-key').'</data-yelllabl> '.lang('@scrolls side up').'<br>'.
            lang('@The cursor must be in the table.')
            /* .'  <br><data-yelllabl>'.lang( '@CTRL arrow-keys').'</data-yelllabl> '.lang( ' @virker ikke. ' */); }
    }
  } dvl_pretty();


### Table-start:
    spool(  '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$vhgh.'; display: block;">'); //  "Table-window": Container for tabel  display: inline ?
    spool(  '  <div id="overlay'.$gbl_TblIx.'"></div>');
    spool( '    <table class="tablesorter" id="table'.$gbl_TblIx.'" style="width:auto; padding:1px; margin:0; table-layout: fixed;">'); //  id= 'table'.$gbl_TblIx  0..6
    spool( '    <thead>');
    $filter_cellFilter= []; //  [ '', 'hidden', '', 'hidden' ]
    $resizable_widths = [];
    if ($expo > '') $Export= true; else $Export= false;
    if ($Export) $cvrData= '';    // cvrData: Used to export data in table body  (the old '@:' prefix broke the first header cell)

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
    // htm_toast('<div style="color:red;"> DataError! '.$datCount.'(data)/'. $fldCount.'(flds)<div>');
    
    if ($selectable) spool(  '<th class="filter-false sorter-false" > </th>');
    $colPos= $selectable ? 1 : 0;  $hiddCols= [];               # The positions of the hidden columns (their filter cells are hidden too)
    foreach ($body as $bdy) { dvl_pretty();
        $colfilt= ' ';
        $resizable_widths[]= $bdy[1]; # ColWidth
        if (($GLOBALS["Øshow"] ?? ''>0) and ($bdy[2]=='hidd')) $bdy[2]= 'text';
        // if ($bdy[9]==true) $selt= ' filter-select filter-onlyAvail'; else $selt= ' ';  //  (date fields sort: sorter-isoDate)
        if ($Export) $cvrData.= sys_csvCell(lang($bdy[0])).',';

        $colPos++;
        if ($bdy[2]=='hidd') // Hidden column: its filter cell is hidden by the CSS written after the header (was FIXIT: the filter fields were out of place)
            { array_push($filter_cellFilter, 'hidden');  $hiddCols[]= $colPos;
                $hiddcount++;
                spool( '<th class="filter-false sorter-false sortPrefix" style="width:0;" ></th>');
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
                    case 'ddwn': $sort= preg_replace('/sorter-\S+/', '', $sort).' sorter-select-text '; break;   # By the chosen option (the first sorter- class wins)
                    //case 'html': 
                    case 'hidd': $sort= ' sorter-false '; break;
                        // sorter-no-parser   sorter-text  sorter-digit  sorter-currency  sorter-url  sorter-isoDate  sorter-percent
                        // sorter-image  sorter-usLongDate  sorter-shortDate  sorter-shortDate  sorter-shortDate sorter-time
                    default:  $sort.= ' sorter-text ';
                }
                // if ($bdy[3]=='2d') $sort.= ' sorter-currency sorter-digit ';  // '3:OutFormat'
                if (($bdy[6] ?? '') === '@The name of file or directory') // '6:ColTip' - goUp in file/folder explorers header:
                {
                    if ($bdy[4][3] ?? ''===false) $sort= ' sorter-false '; // '4:[td-style]
                     if ($GLOBALS['goUp'] ?? '' !='')
                    $goUp= str_WithHint(
                        $labl='<a href="'.($GLOBALS['goUp'] ?? '').'" target="_self" style= "float: left; position: inherit; margin-top: 3px; font-size: 16px; z-index: 105;">
                                <i class="fas fa-chevron-circle-left" style="color: blue; box-shadow: 3px 3px 1px lightgray;"></i><small>'.lang('@Up').'</small></a>',
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
    if ($hiddCols) spool('<style>'.implode(', ', array_map(function($c) use ($gbl_TblIx) {     # Filter cells of hidden columns: hidden like the column
                                 return '#table'.$gbl_TblIx.' .tablesorter-filter-row > td:nth-child('.$c.'), #table'.$gbl_TblIx.'-sticky .tablesorter-filter-row > td:nth-child('.$c.')'; }, $hiddCols)).
                         ' { display: none; }</style>');
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
    # (Was: JavaScript written into a <style> block - it never ran. Hidden columns: see the CSS after the header)

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
        //  foreach ($fldNames as $fld) {   // Sort data to correct output order   (done below: rows with field names)
        //      $arrTmp[$fld]= $DataRow[$fld];
        //  }
        //  $DataRow= $arrTmp;

            # A row with field names (e.g. a database row): place the values by the field names of body (was: by their order only)
            if (is_array($DataRow) and $DataRow and !array_is_list($DataRow) and array_intersect($fldNames, array_keys($DataRow))) {
                $tmp= [];  foreach ($fldNames as $fn) $tmp[]= $DataRow[$fn] ?? '';  $DataRow= $tmp;
            }
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
            spool( '<tr class="row" id="tabl'.$gbl_TblIx.'_row'.$RowIx.'" '.$extra.'>');   # Unique also with several tables on a page  //  Tablesorter with Zebra-striped background
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
            $inpBg= '';      # Transparent background and width 98%: CSS "table.tablesorter td > input" (was in every cell)   //' background-color: white; opacity:0.60; '; //$inpBg= ' background-color:rbg(200,200,200,0.3);';  //' background-color: white; opacity:0.60; ';
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
                        if (strlen((string)$valu)>550) $cvrData.= sys_csvCell('To complex ! ('.strlen((string)$valu).')').',';
                        else $cvrData.= sys_csvCell(lang((string)$valu)).',';  // Unformatted datapost - translated like on screen
                    }

            ## Special Output formats:
                if (!($GLOBALS["Øshow"] ?? '')>0)
                    switch ($bdy[3]) { # OutFormat
                        case '0d': if ($valu==null) $valu= 0;       else $valu= number_format(sys_toFloat($valu), 0,',',' '); break;
                        case '1d': if ($valu==null) $valu='';       else $valu= number_format(sys_toFloat($valu), 1,',',' '); break;
                        case '2d': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format(sys_toFloat($valu), 2,',',' '); break;  //  88 888 888,88
                        case '2%': if ($valu==' ')  $valu= $valu;   else
                                        if ($valu==null) $valu='';  else $valu= number_format(sys_toFloat($valu), 2,',',' ').' %';    break;
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
            if (is_readable($custFile= $GLOBALS['gbl_CustomRules'] ?? (__DIR__.'/customRules.inc.php')))   # Your special table row-rules ($gbl_CustomRules, else next to this library)
                 include($custFile);
            /* else echo '<br> '.__LINE__.' '.$custFile.' not found <br>'; */

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
                if (is_string($bdy[4][1] ?? '') and (($bdy[4][1] ?? '') > ''))  $bgColor= ' background-color:'. $bdy[4][1].'; '; else $bgColor= '';
                if (is_string($bdy[4][2] ?? ''))  $fltStyl= ' '.   /* Custom */   ($bdy[4][2] ?? '').' ' ; else $fltStyl= '';   // i.e.: 'font-style:italic; '
                if (is_string($bdy[4][3] ?? '') and (($bdy[4][3] ?? '') > ''))  $tdColor= ' background-color:'. $bdy[4][3].'; '; else $tdColor= '';
                if (is_string($bdy[4][4] ?? '') and (($bdy[4][4] ?? '') > ''))  $txtSize= ' font-size:'.        $bdy[4][4].'; '; else $txtSize= '';
                //  disabled ?

            ## Special conditional "row"-formats:
                if ($list==['','']) { $rowType= ''; $ixalign= ''; }

                if (is_array($DataRow))
                if ($ColIx<count($DataRow)) {  //  If colspan is there stopped here, when the row is over
                    // if ($emptyTD== true) $rowField.= '<td>'; else
                    $rowField.= '<td style="'.(stripos($ixalign, 'text-align') !== false ? $ixalign : 'text-align:'.$bdy[4][0].'; '.$ixalign).   # (the row rule's text-align won anyway)
                                ' width:'.$bdy[1].'; '.$bgColor.$tdColor.$txtSize.$rowBg.($colsp ?? ''); //  tablefield-property

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
                    case 'chck' : # Checkbox per row: the hidden field carries the value, so every row is posted (an unchecked box is not)
                                  $on= sys_switchIsOn($valu);
                                  $rowField.= '"'.$sortData.'><input type="hidden" name="'.$fldNames[$ColIx].'[]" value="'.($on ? 'checked' : '').'" />'.
                                       '<input type="checkbox" style="box-shadow:none;" '.($on ? 'checked ' : '').
                                       'onchange="this.previousElementSibling.value= this.checked ? \'checked\' : \'\';" />';  break;
                    case 'bold' : # Shows whether the text is bold / italic (read only)
                    case 'ital' : $on= ($bdy[2]=='bold') ? isBold((string)$valu) : isItal((string)$valu);
                                  $rowField.= '"'.$sortData.'><input type="checkbox" style="box-shadow:none;" disabled '.($on ? 'checked ' : '').'/>';  break;
                
                ### SPECIAL:
                    case 'calc' : { // [1, '45-876', 2:$antal=3, 'stk', 'Redekasser', 5:$momssats=25, 6:$pris=235.50, 7:$rabat=8,  $sum=($antal*$pris)*(100-$rabat)/100*(100+$momssats)/100, 'DKK'],
                                  $x= 1;
                                  $sum= (toNum($DataRow[2+$x])*toNum($DataRow[6+$x]))*(100-toNum($DataRow[7+$x]))/100*(100+toNum($DataRow[5+$x]))/100;
                                  $rowField.= '"> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format((float)$sum, 2,',',' '). '" placeholder="'.lang($bdy[7]).'"'.
                                       $txAlign.$inpBg.' " readonly /> '; };
                                  $ordrTotal+= $sum;
                                  break;

                ### STANDARD:
                    case 'date' : if (($valu==' ') /* or ($valu==NULL) */) $clr= 'color: transparent; '; else $clr= '';  // Hide the browsers placeholder by using a SPACE
                                  $rowField.= '"'.$sortData.'>'.'<input type= "date" name="'.$fldNames[$ColIx].'[]" '. //  (id="'.$name.'")
                                          'style="text-align: left; /* line-height: 100%; font-size: revert; height:16px; */ max-width: 150px; z-index: auto; '.$clr. $inpBg.
                                           '" value="'.sys_enc((string)$valu). '" placeholder="yyyy-mm-dd" '.($aktiv ?? '').' />';  break; // The Browser uses its own placeholder!
                    case 'html' : $rowField.= '"'.$sortData.'>  '.$valu;  break;                                                // Only showing HTML
                    case 'htm0' : $rowField.= '"'.$sortData.'>  '.'<small><small>'.$valu.'</small></small>';  break;            // Only showing HTML
                    case 'show' : if ($valu==' ') $clr= 'color: transparent; ';                                   // Only showing data:
                                  else $clr= '';                                                                  // Hide the browsers placeholder by using a SPACE
                                  $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.sys_enc((string)$valu). '" placeholder="'.lang($bdy[7] ?? '').'"'.
                                       $txAlign.$inpBg.' '.$clr.' " readonly /> ';
                                  break;
                    case 'intg' : $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" '.
                                       'value="'.number_format(sys_toFloat($valu), 0,',',' '). //  0 dec. = Integer
                                       '" placeholder="'.lang($bdy[7]).'"'.$txAlign.$inpBg.
                                       ' padding-left:2px; padding-right:2px;" /> ';
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
                                         'value="'.sys_enc((string)$valu).'" placeholder="'.lang($bdy[7] ?? '').'"'.
                                         $txAlign.$inpBg.' padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'opti' :{ $rowField.= '"'.$sortData.'><span '. 
                                        htm_Input($labl=lang($bdy[7]),$plho= '?...',$icon='',$hint=lang($bdy[6]),$vrnt='opti',$name= $fldNames[$ColIx],$valu,$form='',$wdth='98%',
                                        $algn='left',$attr='',$rtrnx=true,$unit='', $disa=false,$rows='2',$step='',$list=$SelectList,$llgn='R',$bord='border: 1px solid Gainsboro;',$ftop='')
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
                                       'value="'.sys_enc((string)$valu).'" '.$txAlign.$inpBg.' width:0;" /> ';
                                  break;
                                 // text:
                    case 'text' :
                    case 'sttu' :   // "unused" Status
                                { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.sys_enc((string)$valu).'" '. //'contentEditable="true" '.
                                       ' placeholder="'.lang($bdy[7] ?? '').'"'.$txAlign.$inpBg.$fltStyl.' '.$captStyle.'" /> ';  //  font-style:inherit;
                                  break;
                                }
                    default   : { $rowField.= '"'.$sortData.'> <input type= "text" name="'.$fldNames[$ColIx].'[]" value="'.sys_enc((string)$valu).'" '.
                                        'placeholder="'.lang($bdy[7] ?? '').'"'.$txAlign.$inpBg.$fltStyl.'" /> ';
                                       // htm_toast('Invalid type: '.$Body[2].' in htm_Table() - error !','orange','black');
                                }
                    }   // :switch InputTypes
                    $rowField.= '</td>';
                }      // '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.
                if ($bdy[2]=='hidd')                     # Hidden column: an empty hidden field (a new record) - else the fields after it were one column out of place
                    $newRow.= '<td style="width:0; padding:0; border:none; display:none;"><input type= "hidden" name="'.$fldNames[$ColIx].'[]" value="" /></td>';
                else {
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
                        $output= preg_replace('/\bopen-modal_(\d+)\b/', 'open-modal_$1_'.$gbl_TblIx.'_'.$RowIx, (string)$Suf[6]);   # One dialog per row (unique id)
                        if ($Suf[2]=='rowact') $output= p2h_rowActs((string)$Suf[6]);    # Row actions in the browser: del copy up down move undo
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
        file_put_contents($expo, "\xEF\xBB\xBF".$cvrData."\n", LOCK_EX);   # UTF-8 BOM: else Excel shows æøå wrong   # Locked: two simultaneous page views must not interleave
    }

### Init Tablesorter:   VIRKER DETTE ? eller $javaScripts ?
    run_Script("
        $('#table".$gbl_TblIx."').tablesorter({
            theme: 'blue',"
            .($parser ?? '')."
            dateFormat : \"Y-m-d\",
            widthFixed : true,
            widgets: ['zebra', 'cssStickyHeaders', 'filter', 'editable', 'resizable'],
            widgetOptions: {
                cssStickyHeaders_attachTo : $('#table".$gbl_TblIx."').closest('.wrapper'),     /* Its own wrapper (was: the first of the page) */
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
            format: function (s, table".$gbl_TblIx.", cell) {        /* val() is a string for a single select, an array for multiple */
                var v= $(cell).find('select').val();  return (Array.isArray(v) ? v.join(',') : v) || s; },
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
    spool( '<div style="text-align: center;">'. 
            htm_AcceptButt($labl='<i class="fas fa-plus"> </i> '.lang($ButtLabl),$icon='', // Create new item record
                        $hint='@Create an empty row, so you can fill in data in the yellow fields ! ', 
                        $form='form_'.$gbl_CardIx.'_'.$gbl_TblIx, $wdth='200px; min-height:16px;', 
                        $attr='', $akey='c', $kind='spc2',$rtrnx=true, $tplc='LblTip_NW', 
                        $tsty='position: absolute; right: 100px;',
                        $acti='appendRow(table'.$gbl_TblIx.','.$newRow.')').
                        '</div>'
        );
}
    spool( (($note>'') ? '<br>'  : ''). '<span style="display: inline-block; position: relative;">'.$note.'</span>');
    spool( '</span>'); // tableStyle
    if (DEBUG) dvl_pretty('End-htm_Table: '.$from);
    
    if (!$rtrn) echo $spool; 
    else      return $spool;
} // htm_Table


# Start a bordered area with a caption, icon ant hint (Remaned from: htm_Fieldset_)
function htm_Fieldset(# capt:'',icon:'',hint:'',wdth:'',marg:'',styl:'',attr:'',rtrn:false)
    $capt='',       # string: The fieldset caption
    $icon='',       # string: Class: icon to the left of fieldset caption
    $hint='',       # string: The hint on hover caption
    $wdth='',       # string: fieldset width
    $marg='',       # string: fieldset margin-size
    $styl='',       # string: fieldset style
    $attr='',       # string: legend attributes
    $rtrn=false     # bool:   Function Return or echo result
    )
{   
    if ($wdth>'') $wdth= 'width: '.$wdth.'; ';
    if ($marg>'') $marg= 'margin: '.$marg.'; ';
    $result=  '
        <fieldset style="page-break-after: avoid; display: inline-block; box-shadow: 0 3px 3px #AAAAAA; min-width: 0; max-width: 100%; box-sizing: border-box; 
                         '.$wdth.$marg.'; border-radius: 6px; '.$styl.'"> 
        <legend style="box-shadow: 0 0 5px #AAAAAA; '.$attr.'">'.str_WithHint($capt,$hint,$icon).' </legend>';
    if (!$rtrn) echo $result; 
    else return $result;
}

# End a bordered area
function htm_Fieldset_end(# rtrn:false) 
    $rtrn=false) 
{   $result= '</fieldset>';
    if (!$rtrn) echo $result; else return $result;
}

# Output external content in a local frame
function htm_iFrame(# srce:'', wdth:'300px', heig:'200px', titl:'', styl:'', rtrn:false)
    $srce= '',      # string: Source with html content
    $wdth= '300px', # string: iframe width
    $heig= '200px', # string: iframe height
    $titl= '',      # string: iframe title
    $styl= '',      # string: iframe style (eg. border)
    $rtrn= false    # bool:   Act as procedure: Echo result, or as function: Return string
){
    $result= '<iframe src="'.sys_enc($srce).'" style="width:'.rtrim($wdth,'; ').'; height:'.rtrim($heig,'; ').'; '.$styl.'" title="'.sys_enc(lang($titl)).'"></iframe>';
    if (!$rtrn) echo $result; else return $result;
}

# View a container with a external resource
function htm_Embed(# name:'', type:'application/pdf', wdth:'800px', heig:'2100px', bord:'0', rtrn:false) 
    $name= '',                  # string: Filename and path
    $type= 'application/pdf',   # string: MIME-type: (https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types)
    $wdth= '800px',             # string: content width
    $heig= '2100px',            # string: content height
    $bord= '0',                 # string: frameBorder
    $rtrn= false                # bool:   Act as procedure: Echo result, or as function: Return string
){  if ($name > '') {
    $result= '<embed src="'.sys_enc($name).
        '" width="'.sys_enc($wdth).'" height="'.sys_enc($heig).'" type="'.sys_enc($type).'">';     # (embed is a void element: no </embed>)
    if (!$rtrn) echo $result; else return $result;
    }
};


# Make a box like htm_input() with label, icon and hint 
function htm_Field(# labl:'',body:'',icon:'',hint:'',name:'fld',wdth:'',styl:'',attr:'',llgn:'C',rtrn:false,ftop:'') #FIELD:
    $labl='',       # string: label for the box
    $body='',       # string: Html content
    $icon='',       # string: Class: icon to the left of ?? !
    $hint='',       # string: The hint on hover label
    $name='fld',    # string: field name
    $wdth='',       # string: field width
    $styl='',       # string: field style
    $attr='',       # string: field attributes
    $llgn='C',      # string: label align L/C/R
    $rtrn=false,    # bool:   Act as procedure: Echo result, or as function: Return string:   
    $ftop=''        # string: fieldtop: label y-offset
){  switch (strtoupper($llgn)) {
        case 'L': $lblalign = 'margin-right:  auto;';  break;   // Align label Left
        case 'C': $lblalign = 'margin:        auto;';  break;   // Align label Center
        case 'R': $lblalign = 'margin-left:   auto;';  break;   // Align label Right
        default : $lblalign = 'margin-left:   auto;';
    }
    $result= '<div class="inpField" id="'.sys_uid('id_'.$name).'" style="margin: auto; min-width: 100px; width: '.$wdth.'; top: '.$ftop.
             '; display: inline-block; box-shadow:none; '.$attr.'"> '; // float: left;
    $result.= '<div class="boxStyle" style="padding:5px; margin-top:6px; '.$styl.' ">'.$body.'</div>';
    $result.= ' <abbr class= "hint">'.
            ($labl>'' ? 
               '<label for="id_'.$name.'" style="font-size: 14px; '.$ftop. '">
                    <div style="white-space: nowrap; box-shadow: none; border: none;'.$lblalign.'">'.lang($labl).'</div>
               </label>'
               : '').
               ($hint>''? ('<data-hint style="top: 45px; left: 2px;">'.lang($hint).'</data-hint>'):'').'
           </abbr>'.($subm ?? '').'
        </div>';
    if (!$rtrn) echo $result.'
    '; // lf in html
    else return $result.'
    '; // lf in html
}

# Prepare a span with inline-block output
function htm_Row_()
{   echo '
    <span style="display: inline-block;">';
}
# Finalize the span
function htm_Row_end()
{   echo '</span>
    ';
}


// CSRF-beskyttelse: generér en token pr. session, hvis den ikke findes
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token']= bin2hex(random_bytes(32));
}

function csrf_field($rtrn=false) // Genererer et skjult input-felt med CSRF-token
{   $result= '<input type="hidden" name="csrf_token" value="'.htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8').'" />';
    if (!$rtrn) echo $result; else return $result;
}

function csrf_verify() // Kaldes ved håndtering af POST - return true/false
{   if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') return true; // Kun relevant ved POST
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token'])) return false;
    if (!is_string($_POST['csrf_token']) || !is_string($_SESSION['csrf_token'])) return false;
    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/*
Layout of htm_Card:
|---------------------|-----------------------------------|----------------------|  htm_Card_()
|        C-left       |        CARD-Caption-center        |       C-right        |  C-left: Menu-links / C-right: Card-contrl
|---------------------|-----------------------------------|----------------------|  CARD-Caption: $icon & $capt
|                                                                                |
|                                                                                |
|                                                                                |
|                                                                                |
|                                                                                |
|                                  CARD-BODY                                     |  HTML between htm_Card_() and htm_Card_end()
|                                                                                |
|                                                                                |
|                                                                                |
|                                                                                |
|--------------------------------------------------------------------------------|
|                                   CARD-FOOT                                    |  htm_Card_end()
|--------------------------------------------------------------------------------|
*/

# An advanced span with lots of functionality [Necessary basic element]
function htm_Card_(# capt:'', icon:'', hint:'', form:'', acti:'', clas:'cardWmax', wdth:'', styl:'background-color: white;', attr:'margin-bottom: 8px;', show:true, mode:'2', poup:true, head:'background-color: white;', vhgh:'600px', move:true, help:'', fclr:'', frst:'', last:'',simp:false, fold:'', elem:'span');
    $capt = '',                         # string: The card caption
    $icon = '',                         # string: Class: icon to the left of caption
    $hint = 'tgl',                      # string: The default hint on hover caption (tgl: toggle open/close card-body)
    $form = '',                         # string: form id/name (No form without a name)
    $acti = '',                         # string: form action 
    $clas = 'cardWmax',                 # string: The card class (general CSS-data) The open card width: .cardWmax, .cardWaut, .cardW120 (1200), .cardW110 (1100), .cardW100 (1000),
                                        #         .cardW960, .cardW800, .cardW720, .cardW640, .cardW560, .cardW480, .cardW400, .cardW320, .cardW280, .cardW240, .cardW160
    $wdth = '',                         # string: The closed card width
    $styl = 'background-color: white;', # string: The card body style
    $attr = 'margin-bottom: 8px;',      # string: general attributes (style) for the card-container
    $show = true,                       # bool:   Show card-contrl-buttons top-right
    $mode = '2',                        # string: Mode regarding card-contrl-buttons: 0:none, 1:heiht-only, 2:width-also, ( 3:AllCards, 4:ThisCard )
    $poup = true,                       # bool:   Activate popup-menu for handling all cards
    $head = 'background-color: white;', # string: Style for Header background
    $vhgh = '600px',                    # string: Fixed ViewHeight for span (HideBody) with scrollable content
    $help = '',                         # string: Link to show custom Card-help (HTML-file to open)
    $fclr = '',                         # string: Special header forground-style  (Icon, text and arrow-icons). Ex.: fclr:'color:snow;'
    $frst = '',                         # string: Html content in Caption left
    $last = '',                         # string: Html content in Caption right
    $simp = false,                      # bool:   HeaderMode: Simple==true: centered caption in header (hide nav-icons)
    $fold = '',                         # string: 'closed': the card starts folded (click the caption to open it)
    $elem = 'span',                     # string: The HTML element of the card: span (default) / section / article / aside / main / header / footer / div
                                        #         A semantic element (section...) gets the caption as its accessible name (aria-labelledby)
    $move = true                        # bool:   The card can be moved among its sibling cards (how: $gbl_CardMove) - false: it stays in place
)
{   global $gbl_iconColor, $gbl_TitleColr, $gbl_CardForm, $gbl_CardStack, $gbl_ProgRoot, $_assets, $gbl_CardIx, $gbl_CardsBgrd, $gbl_GridOn; # v.1.2.3: $gbl_PanlForm => $gbl_CardForm
    $gbl_CardIx++;
    
    $icon= '<ic class="'.$icon.'" style="font-size: 20px; color: '.$gbl_iconColor.'; '.$fclr.'margin: 0 5px;"></ic>';
    # Moving the card (p2hCardMove): $gbl_CardMove= 'icon' (default: a handle in the header) / 'header' (drag the header itself)
    # / 'toggle' (the view bar button "Arrange cards" turns moving on and off) / false (never). The order is remembered per page in the browser.
    $mvMode= $GLOBALS['gbl_CardMove'] ?? 'icon';  if ($mvMode===true) $mvMode= 'icon';
    $mvMode= ($move && in_array($mvMode, ['icon','header','toggle'], true)) ? $mvMode : '';
    $mvKey= $mvMode ? sys_uid('k'.substr(md5(strip_tags((string)$capt)), 0, 8)) : '';    # By the caption (not the language): the same key when cards are added
    $capt= lang($capt);

   // if ($frst == '') { $frst= $icon.' &nbsp;'.$capt; }
    # Per-card JS API (kept for backward compatibility): thin wrappers around the shared p2hCard*() functions (see p2h_themeBoot)
    if (preg_match('/^\d+(\.\d+)?$/', trim((string)$wdth))) $wdth= trim($wdth).'px';     # A plain number (wdth:'640') means pixels
    $ix= $gbl_CardIx;  $jsW= json_encode((string)$wdth);  $jsH= json_encode((string)$vhgh);  $jsC= json_encode((string)$clas);
    echo '<script>'.
         'function CardHeight'.$ix.'()   { p2hCardHeight('.$ix.','.$jsH.'); }'.
         'function CardSwitch'.$ix.'()   { p2hCardToggle('.$ix.','.$jsW.'); }'.
         'function CardMinimize'.$ix.'() { p2hCardMin('.$ix.','.$jsW.'); }'.
         'function CardMaximize'.$ix.'() { p2hCardMax('.$ix.'); }'.
         'function CardWide'.$ix.'()     { p2hCardWide('.$ix.','.$jsC.'); }'.
         'function WrapperHeight'.$ix.'() { }'.
         '</script>'."\n";
    
    dvl_pretty('htm_Card_');
    $gbl_GridOn= false;
    if ($capt=='') $Ph= 'height:0px;'; else $Ph= '';
    
    if ($frst >'') $frst= '<div style="float:left;  color:'.$gbl_TitleColr.'; display:inline-block; padding: 0  8px;">'.$frst.'</div>'; else $frst= '';
    if ($last >'') $last= '<div style="float:right; color:'.$gbl_TitleColr.'; display:inline-block; padding: 0 10px;">'.$last.'</div>';
    
    $Card_contrl= '';
    // TOGGLE butt: Toggle max-height between vhgh and 999px 
    $buttstyl= 'width:12px; height:12px; margin:6px 2px 0 0; float:right; font-size: 12px; '.$fclr;
    if (($show==true) and ($mode>'0') /* and ($hint>'') */) // ???
        $Card_contrl.=  '<abbr class= "hint">'.
            '<ic class="fa-solid fa-up-down" style="'.$buttstyl .' padding:0 4px 0 0; margin-left: 0; cursor:row-resize;" '.
            ' role="button" tabindex="0" onclick= CardHeight'.$gbl_CardIx.'(); ></ic> 
            <data-hint>'.lang('@<b>TOGGLE-height:</b> Click icon to toggle viewHeight for <i>this</i> card').' </data-hint></abbr>';
    // WIDE butt: this
    if (($show==true) and ($mode>'1'))  // ($mode== '4')
        $Card_contrl.=  '<abbr class= "hint">
            <ic class="fa-solid fa-right-left" style="'.$buttstyl .' padding:0 0 0 4px; cursor:col-resize;" '.
            ' role="button" tabindex="0" onclick= CardWide'.$gbl_CardIx.'(); ></ic>
            <data-hint>'. lang('@<b>WIDE:</b> Click to maximize/normalize <i>this</i> card width').'</data-hint></abbr>';
    // HEIGHT butt: this
    if ($show==true) if (false) // if (class="wrapper") // ($mode== '4')
        // <script> const el = document.getElementById('card'.$gbl_CardIx.'');    el.closest('.wrapper');     el.find('.wrapper'): </script>
        $Card_contrl.=  '<abbr class= "hint">
            <ic class="fa-solid fa-right-left fa-rotate-90" style="'.$buttstyl .' cursor:s-resize;"'.
            ' onclick= WrapperHeight'.$gbl_CardIx.'(); ></ic>
            <data-hint>'. lang('@<b>HEIGHT:</b> Click to maximize/normalize <i>this</i> View height (Table/WrapperCard)').'</data-hint></abbr>';
    // COLLAPSE butt: all
    if (($show==true) and ($mode>'1'))  // ($mode== '3')
        $Card_contrl.=  '<abbr class= "hint">
            <ic class="fas fa-angle-double-up" style="'.$buttstyl .' cursor:zoom-out;" '.
            ' role="button" tabindex="0" onclick= CardMinimizeAll(); ></ic>
            <data-hint>'. lang('@<b>COLLAPSE:</b> Click to close <i>all</i> cards').' </data-hint></abbr>';
    // EXPAND butt: all
    if (($show==true) and ($mode>'1'))  // ($mode== '3')
        $Card_contrl.=  '<abbr class= "hint">
            <ic class="fas fa-angle-double-down" style="'.$buttstyl .' cursor:zoom-in;" '.
            ' role="button" tabindex="0" onclick= CardMaximizeAll(); ></ic>
            <data-hint>'. lang('@<b>EXPAND:</b> Click to open <i>all</i> cards').' </data-hint></abbr>';
            
    // MOVE handle (icon mode):
    $Card_move= ($mvMode=='icon') ?
         '<abbr class="hint p2hMoveHint"><ic class="fa-solid fa-grip-vertical p2hMoveIc" role="button" tabindex="0" aria-label="'.sys_enc(strip_tags(lang('@Move the card'))).'"'.
            ' style="font-size: 12px; padding: 2px 3px; '.$fclr.'"></ic>'.
            '<data-hint>'.lang('@<b>MOVE:</b> Drag to place <i>this</i> card elsewhere among the cards. Alt + arrow up/down: one place. The order is remembered in this browser.').'</data-hint></abbr>' : '';
    $mvHint= ($mvMode=='header') ? ($hint>'' ? '<br>' : '').lang('@Drag the header to move the card (Alt + arrow up/down: one place).') :
             (($mvMode=='toggle') ? ($hint>'' ? '<br>' : '').lang('@When "Arrange cards" is on in the view bar: drag the header to move the card.') : '');
    // CardHelp:
    if ($help>'') $Card_help=
         '<abbr class= "hint">'.
            '<ic class="fa-solid fa-question" style="'.$buttstyl .' float:none; cursor:help; padding: 0 6px;" '.
            ' role="button" tabindex="0" onclick="window.open(\''.$help.'\', \'_blank\')" >'.
            '</ic>
            <data-hint>'.lang('@<b>HELP:</b>'.lang('@Click icon to goto custom help for <i>this</i> card: ').$help.'').' </data-hint>
         </abbr>'; else $Card_help= '';

    # Each open card pushes "do I own an open <form>?" on a stack, so nested cards close the right form.
    # HTML does not allow nested forms: inside a card that already has a form, an inner form is not created
    # (the inner fields then belong to the outer form, which is what the browser would do anyway).
    if (!is_array($gbl_CardStack)) $gbl_CardStack= [];
    $outerForm= in_array(true, $gbl_CardStack, true);
    if (($form>'') and !$outerForm) { //  Without name form will not be created, so local forms can be used !
        $gbl_CardStack[]= true;  $GLOBALS['gbl_CardFormName'][]= $form;   # (the footer button submits this form)
        $gbl_CardForm= true;
        $formCrea=  "\n\n".'<form name="'.$form.'" id="'.$form.'" action="'.$acti.'" 
                    method="POST" enctype="multipart/form-data"
                    style="margin-block-end: 0;">'."\n".
                    csrf_field(true)."\n"; // CSRF-token indlejres automatisk i hver formular
    }
    else { $gbl_CardStack[]= false; $GLOBALS['gbl_CardFormName'][]= ''; $formCrea= ''; }   # $gbl_CardForm keeps the state of an enclosing form
    
    $prnHtml= $icon.ucfirst($capt);
    if ($last=='') $last= $Card_contrl. $Card_help;

## CARD-START:
    $closed= ($fold=='closed');
    $elem= in_array($elem, ['span','section','article','aside','main','header','footer','div'], true) ? $elem : 'span';
    $GLOBALS['gbl_CardElem'][]= $elem;                  # htm_Card_end() closes the same element (cards can be nested)
    $label= ($elem!='span' && $capt>'') ? ' aria-labelledby="ctitl'.$gbl_CardIx.'"' : '';
    echo '<'.$elem.' class="'.$clas.'" id="card'.$gbl_CardIx.'"'.$label.($mvMode ? ' data-p2h-move="'.$mvMode.'" data-p2h-key="'.$mvKey.'"' : '').'  style="position: relative; vertical-align: top; margin: 1px; margin-bottom: 8px; '.$attr.($closed && $wdth>'' ? ' width:'.$wdth.';' : '').'"> '.
        $formCrea.
        // CardTop:
        '<span id="chead'.$gbl_CardIx.'"'.($poup==true ? ' data-p2h-menu="1"' : '').' style="display:inline-block; width: calc(100% - 0px); text-align: left; padding: 4px 0;'.$head.($Card_move ? ' padding-left: 16px; box-sizing: border-box;' : '').'">'.
        $Card_move;                                                      # The move handle: in the left edge of the header
        if ($hint=='tgl')   $hint= '@<b>TOGGLE:</b> Click icon or card header-text to open / close <i>this</i> card';

       // CardTitl:
      $titlSty = '<span class="cardsTitl" id="ctitl'.$gbl_CardIx.'" role="button" tabindex="0" onclick="CardSwitch'.$gbl_CardIx.'();" style="'.$Ph.' color:'.$gbl_TitleColr.'; cursor:row-resize;';


// if ($simp == false) { # Complete header output inclusive navi-icons
if (!$simp) { # Complete header output inclusive navi-icons
    echo '<span>' . 
            '<span style="float:left; width:10%; text-align:left;">' . $frst . '</span>' . # Left-txt
            '<abbr class="hint" role="heading" aria-level="2">' .     # The caption is a heading (the fold button inside it)
                ($frst > '' 
                    ? $titlSty . ' text-align:center; width:68%; display: inline-block;">' . $prnHtml . '</span>'
                    : $titlSty . ' text-align:left;">' . $prnHtml . '</span>'
                ) . 
                (($hint>'' || $mvHint>'') ? '<data-hint>' . ($hint>'' ? lang($hint) : '') . $mvHint . ' </data-hint>' : '') .
            '</abbr>' .
            '<span style="float:right; text-align:right;">' . $last . '</span>' . # Right-txt
         '</span>';

    if (($last == '') && ($Card_contrl > '')) {
        echo '<span style="padding: 0 10px;">' . $Card_contrl . $Card_help . '</span>';
    }
}
else { # Clean and simple header output:
    echo '<span style="padding: 0 10px; text-align:center; display:block;">' .
            '<abbr class="hint" role="heading" aria-level="2">' .
                $titlSty . '">' . $prnHtml . '</span>' .
                (($hint>'' || $mvHint>'') ? '<data-hint>' . ($hint>'' ? lang($hint) : '') . $mvHint . ' </data-hint>' : '') .  
            '</abbr>' .
         '</span>';
}
    echo '</span>';   // CardTop 
    
    # The card menu (right-click a card header): ONE menu for all cards - was a copy of the whole menu script in every card (~2.5 KB each)
    static $cardMenuDone= false;
    if (($poup==true) and !$cardMenuDone) {
        $cardMenuDone= true;
        $mItems= Pmnu_Item(labl:'@Close cards',     icon:'far fa-rectangle-xmark colrgreen',   hint:'@Close all cards',        vrnt:'plain',     name:'m1', clck:'CardHeightAll(`clo`,330);',attr:'',rtrn:true)
               .Pmnu_Item(labl:'@Minimize height', icon:'fas fa-minus     colrgreen',         hint:'@Minimize all cards height',   vrnt:'plain',     name:'m2', clck:'CardHeightAll(`min`,330)', attr:'',rtrn:true)
               .Pmnu_Item(labl:'@Small height',    icon:'fas fa-compress  colrgreen',         hint:'@Small height to all cards',   vrnt:'custom',    name:'m3', clck:'CardHeightAll(`sma`,330)', attr:'',rtrn:true)
               .Pmnu_Item(labl:'@Default height',  icon:'fas fa-check     colrgreen',         hint:'@Default height to all cards', vrnt:'custom',    name:'m4', clck:'CardHeightAll(`def`,330)', attr:'',rtrn:true)
               .Pmnu_Item(labl:'@Large height',    icon:'fas fa-expand    colrgreen',         hint:'@Large height to all cards',   vrnt:'custom',    name:'m5', clck:'CardHeightAll(`gre`,330)', attr:'',rtrn:true)
               .Pmnu_Item(labl:'@Maximize height', icon:'fas fa-plus      colrgreen',         hint:'@Maximize all cards height',   vrnt:'plain',     name:'m8', clck:'CardHeightAll(`max`,330)', attr:'',rtrn:true)
               .Pmnu_Item(vrnt:'separator', rtrn:true)
               .Pmnu_Item(labl:'@COLLAPSE body',   icon:'fas fa-angle-double-up   colrgreen', hint:'@Click to close <i>all</i> cards', vrnt:'plain', name:'m6', clck:'CardMinimizeAll();', shrt:'', rtrn:true)
               .Pmnu_Item(labl:'@EXPAND body',     icon:'fas fa-angle-double-down colrgreen', hint:'@Click to open <i>all</i> cards',  vrnt:'plain', name:'m7', clck:'CardMaximizeAll();', shrt:'', rtrn:true);
        $mvOn= in_array(($GLOBALS['gbl_CardMove'] ?? 'icon') === true ? 'icon' : ($GLOBALS['gbl_CardMove'] ?? 'icon'), ['icon','header','toggle'], true);
        if ($mvOn) $mItems.= Pmnu_Item(labl:'@Original card order', icon:'fas fa-arrow-down-1-9 colrgreen', hint:'@Put the moved cards of this page back in their original order', vrnt:'plain', name:'m9', clck:'p2hCardMove.reset();', shrt:'', rtrn:true);
        echo '<script>document.addEventListener("contextmenu", function(event) {     /* Card headers with data-p2h-menu (htm_Card_ poup:true) */
    var h= event.target.closest && event.target.closest("[data-p2h-menu]");  if (!h) return;
    event.preventDefault();
    new ctxP_({ isSticky: false, width: "240px", top: "30%", left: "40%", items: [
        {label: '.json_encode(lang('@Applies to all cards:')).', hint: "", cssicon: "fas fa-info", custAttr: " height: 14px;"},'.$mItems.'
        {label: "", hint: ""} ] });
});</script>';
    }
    echo '<span id="HideBody'.$gbl_CardIx.'" style="'.$gbl_CardsBgrd.'; transition: max-height 1s;
          max-height:'.($vhgh > '' ? $vhgh : "500px").'; overflow-y: auto; display: '.($closed ? 'none' : 'block').';  overflow-y:auto;'.$styl.'">';   // Hide from here ! 
    if ($capt > '') if ($head != '') echo '<hr class="style13" style="margin: 0 0 6px 0;"/>';
    echo '<div class="cardContent" style="text-align: center; margin: 4px; '.$styl.'">'; // width: min-content;">';
    return $prnHtml;
} // htm_Card_()

# Finalize htm_Card_()
function htm_Card_end(# labl:'', icon:'', hint:'', name:'', form:'',subm:false, attr:'', akey:'', kind:'save', simu:false, foot:'')
    $labl='',       # string: Label on the submit button in the footer
    $icon='',       # string: Icon left to label
    $hint='',       # string: Hint on hover the submit button
    $name='',       # string: The name of the button to submit
    $form='',       # string: The name of the form to submit
    $subm=false,    # bool:   Submit button shown and active
    $attr='',       # string: Button attributes. Generel use e.g. action= "$link"
    $akey='',       # string: Shortcut to activate the button
    $kind='save',   # string: The button appearance 
    $simu=false,    # bool:   Button only simulate
    $foot=''        # string: Footer text (HTML, translated) - the footer stays below the scrolling body and is hidden with it when the card is folded
)
{   global $gbl_CardForm, $gbl_CardStack;    dvl_pretty('htm_Card_end ');
    $ownForm= is_array($gbl_CardStack) && $gbl_CardStack ? array_pop($gbl_CardStack) : false;  # Did THIS card open a form?
    $cardForm= (is_array($GLOBALS['gbl_CardFormName'] ?? null) && $GLOBALS['gbl_CardFormName']) ? array_pop($GLOBALS['gbl_CardFormName']) : '';
    if ($ownForm and ($cardForm > '')) $form= $cardForm;    # The footer button submits this card's form (a different form: name did nothing)
    $gbl_CardForm= is_array($gbl_CardStack) && in_array(true, $gbl_CardStack, true);         # Is an enclosing form still open?
    //if ($disa==true) $aktiv=' disabled '; else $aktiv= '';
    if ($hint=='') {$hint= '@Remember to save here if you changed anything above, before leaving the window.'; $kind='save';}
    echo '</div>';  $prnHtml= '</div>';  // class="cardContent"
    echo '</span>'; $prnHtml.= '</span>'; // HideBody to here !
    # The footer: below the scrolling body (always visible while the card is open, hidden with the body when it is folded - see .p2hCardFoot).
    # Shown when there is a text, or a submit button (subm:true in a card with its own form).
    # (Was: only in cards with their own form, and inside the scrolling body - a tall card scrolled it out of sight.)
    $subm= (($subm==true) and $ownForm);           # The button submits THIS card's form (a nested card has none - the button would do nothing)
    if ($subm or ($foot > '')) {
        echo '<div class="p2hCardFoot">';
        if ($foot > '') echo '<small>'.lang($foot).'</small>';
        if ($subm) {
            echo '<span class="center" style="height:35px; display: inline-block; position: relative;">';
            htm_AcceptButt(labl:$labl, icon:$icon, hint:$hint, form:$form, attr:$attr, akey:$akey, kind:$kind, rtrn:false, tplc:'LblTip_N', tsty:'left: auto; top: -65px;');
            echo '</span>';
        }
        echo '</div>';
    }
    if ($ownForm) echo "\n".'</form>'.'<!-- /'.$name.' -->'."\n\n"; //  CardForm-end
    $elem= (is_array($GLOBALS['gbl_CardElem'] ?? null) && $GLOBALS['gbl_CardElem']) ? array_pop($GLOBALS['gbl_CardElem']) : 'span';
    if ($GLOBALS['gbl_CardResize'] ?? true)              # Drag grip: card width and body height (remembered per card, see p2hCardSize)
        echo '<abbr class="hint p2hGripHint"><span class="p2hCardGrip" role="button" tabindex="0" aria-label="'.sys_enc(strip_tags(lang('@Resize the card'))).'"'.
             ' data-colhint="'.sys_enc(strip_tags(lang('@Column view: the column decides the width of the card - only the height can be dragged (down to less than the content). Turn the column view off to change the width.'))).'"></span>'.      # (data-colhint: the toast in column view)
             '<data-hint><span class="p2hGripTxt">'.lang('@Drag to resize the card (or use the arrow keys). Double-click or Home: original size').'</span>'.
             '<span class="p2hGripCol">'.lang('@Column view: the column decides the width of the card - only the height can be dragged (down to less than the content). Turn the column view off to change the width.').'</span></data-hint></abbr>';
    echo '</'.$elem.'>'; $prnHtml.= '</'.$elem.'>'; // Card-end (the element chosen in htm_Card_)
    return $prnHtml;
} # htm_Card_end

// $CardState= [[ix:1..xx,display:none/block],[...]];


function CardInit($cardCount) {     // JS functions to handle Cards:
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
        function CardMinimizeAll() { p2hCardsAll(false); }      /* As CardMinimizeN(): the closed width of each card */
        function CardMaximizeAll() { p2hCardsAll(true); }       /* As CardMaximizeN(): the open width, the saved size, the tables */
            function CustHelp() {';
        // for ($Ix=1; $Ix<=$cardCount; $Ix++) { echo ' No help for this card yet '; }
        echo ' $("table").trigger("applyWidgets"); }
        </script>';   # Reinit table "zebra": https://mottie.github.io/tablesorter/docs/example-widget-zebra.html
}


# A span/group with a set of labels and data
function htm_DataGroup(# capt:'', $icon='', $hint='', head:'', data:[['Label0','Data0']], foot:'', wdth:'', vhgh:'', fclr:'', attr:'', styl:'', bord:'3px solid green;')
    $capt = '',                             # string: The group caption
    $icon='',                               # string: Icon left to label
    $hint='',                               # string: Hint on hover the submit button
    $head = '',                             # string: The group header
    $data = [['Label0','Data0','Lstyl','Dstyl']],    # array:  Records with label, Data and style
    $foot = '',                             # string: The group footer
    $wdth = '',                             # string: group width
    $vhgh = '600px',                        # string: ViewHeight for group with scrollable content
    $fclr = '',                             # Special header forground-style  (Icon, text and arrow-icons). Ex.: fclr:'color:snow;'
    $attr = '',                             # string: additional style for the ScrollWindow
    $styl = '',                             # string: Custom style for div containing data
    $bord = '3px solid black;'              # string: The group border style
)
{   global $gbl_iconColor;
    $capt= lang($capt); 
    $icon= '<ic class="'.$icon.'" style="font-size: 20px; color: '.$gbl_iconColor.'; '.$fclr.'margin: 0 5px;"></ic>';
    if ($bord>'') $bord= 'border: '.$bord. 'border-radius: 5px;'; else $bord= '';
    if ($hint>'') $hint= '<data-hint> '.lang($hint).' </data-hint>';
   # Field - ScrollWindow - Caption - Header - dataRecords - Footer
    echo # Field:
         '<span style="position: relative; vertical-align: top; margin: 1px; margin-bottom: 8px; '.
                      'align-content: center; margin: auto; display: block; '.$bord.' width: max-content;'.$attr.'"> ';
        echo # ScrollWindow:
            '<span style="max-height:'.($vhgh > '' ? $vhgh : "500px").'; overflow-y: auto; display: block;  width: '.$wdth.'; overflow-y:auto;'.$styl.'">';
        if ($capt > '') {
            echo '<abbr class= "hint">';
                echo $icon.$capt.'<hr class="style13" style="margin: 0 0 6px 0;"/>';
                echo $hint;
            echo '</abbr>';
        }
            echo '<div style="text-align: center; margin: 4px; '.$styl.'">'; // width: min-content;">';
            if ($head > '') echo $head;
            foreach ($data as $rec) 
                echo '<div style= "display: block; font-size:smaller;">
                         <span style= "width: 49%; text-align:left;  display: inline-block; '.(isset($rec[2]) ? $rec[2] : '').' ">'.$rec[0].'</span>'.
                        '<span style= "width: 49%; text-align:right; display: inline-block; '.(isset($rec[3]) ? $rec[3] : '').' ">'.$rec[1].'</span>'.
                     '</div>';
            echo '</div>';
            if ($foot > '') echo $foot;
            echo '</span>'. # ScrollWindow
        '</span>'; # Field
} # htm_DataGroup

# An input field with a list of values to pick from (HTML datalist)
function htm_DataList(# capt: '@Choose here from the list:', icon: 'fas fa-database', hint: '@Use datalist to pick a value from list', plho: '?',name: '', form: '', acti: '', data: ['Itm1','Itm2','Itm3','Itm4'], wdth: '220px', fclr: 'color: green;', attr: '', bord: '1px solid black; border-radius: 5px;', rtrn: false )
    $capt = '@Choose here from the list:',              # string: The group caption
    $icon = 'fas fa-database',                          # string: Icon left to label
    $hint = '@Use datalist to pick a value from list',  # string: Hint on hover the submit button
    $plho = '@Type or pick a value',                    # string: The placeholder shown when blank value
    $name = '',                                         # string: The field name submitted with the choice. '' => datalist1, datalist2...
    $form = '',                                         # string: The name of the form to submit
    $acti = '',                                         # string: Form action
    $data = ['Itm1','Itm2','Itm3','Itm4'],              # array:  Record with Data
    $wdth = '220px',                                    # string: the width
    $fclr = 'color: green;',                            # Special header forground-style  (Icon, text and arrow-icons). Ex.: fclr:'color:snow;'
    $attr = '',                                         # string: additional style 
    $bord = '1px solid black; border-radius: 5px;',     # string: The group border style
    $rtrn = false                                       # bool:   Act as procedure: Echo result, or as function: Return string:   

)
{   $ownForm= empty($GLOBALS['gbl_CardForm']);                 # Inside a card form: no form of its own (its </form> ended the card form)
    $html= $ownForm ? '<form action="'.sys_enc($acti).'" method="get">' : '';
    static $dlNo= 0; $dlNo++;
    if ($name=='') $name= 'datalist'.$dlNo;                     # Without a name the chosen value is not submitted
    $listId= 'list_'.sys_enc($name);   # Unique per field - several datalists on one page must not share options
    $datalist= '<input list="'.$listId.'" name="'.sys_enc($name).'" id="'.sys_enc($name).'" onfocus="this.value=\'\'" onchange="this.blur();" placeholder="'.lang($plho).'" style="width:65%;">';
        $datalist.= '<datalist id="'.$listId.'">';
            for ($ix=0; $ix<count($data); $ix++) $datalist.= '<option value="'.sys_enc($data[$ix]).'">';
        $datalist.= '</datalist>';
    $datalist.= '<input type="submit" value="'.lang('@Choose').'">';
    $html.=
    htm_Inbox(labl:$capt, plho:'', icon:$icon, hint:$hint,
              name:$name.'_box', valu:$datalist, form:$form, wdth:$wdth, algn:'center', attr:$fclr, // Box-width - botton-width = input-width
              rtrn:true, unit:'', disa:false, rows:'2', step:'', list:[], llgn:'R', bord:$bord, ftop:'');
    if ($ownForm) $html.= '</form>';
    if (!$rtrn) echo $html; else return $html;
} # htm_DataList
 
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
                sysAlert(data.reply);
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


# Start a span with scrolling content in a fixed-height window
function htm_Wrapp_(# vhgh:'400px') # WrapperCard - open
    $vhgh='400px') # WrapperCard - vhgh: ViewHeight
{   echo '<span class="wrapper" style="padding:0; margin: 0 0 6px; border:1px solid gray; height:'.$vhgh.'; display: block;">'; 
}
# Finalize a wrapper window
function htm_Wrapp_end()         # WrapperCard - close
{   echo '</span>';
}

# Start creating a form
function htm_Form_(# name:'', acti:'', mode:'POST', type:'multipart/form-data', attr:'')
    $name= '',                      # string: The name of the form
    $acti= '',                      # string: Form action
    $mode= 'POST',                  # string: Form method
    $type= 'multipart/form-data',   # string: enctype
    $attr= ''                       # string: Other attributes
    )
{   echo '<form'.($name>'' ? ' name="'.sys_enc($name).'" id="'.sys_enc($name).'"' : '').' action="'.sys_enc($acti).'" method="'.sys_enc($mode).'" enctype="'.sys_enc($type).'" '.$attr.'>';  
    if (strtoupper($mode)=='POST') csrf_field();
    /*
    Form attributes:
    accept-charset  Specifies the character encodings used for form submission
    action          Specifies where to send the form-data when a form is submitted
    autocomplete    Specifies whether a form should have autocomplete on or off
    enctype         Specifies how the form-data should be encoded when submitting it to the server (only for method="post")
    method          Specifies the HTTP method to use when sending form-data
    name            Specifies the name of the form
    novalidate      Specifies that the form should not be validated when submitted
    rel             Specifies the relationship between a linked resource and the current document
    target          Specifies where to display the response that is received after submitting the form
    */
}
    
# Finalixe a form
function htm_Form_end() 
{   echo '</form>';
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
# Start a first column in a div
function htm_RowCol_(# wdth:240)        # ColumnTop // Must be followed/ended of htm_RowCol_end()
    $wdth=240)
{  dvl_pretty('htm_RowColTop');      // RowColTop RowCol240, RowCol320 (Look at CSS ! )
    echo '<div style="text-align: center; width:min-content; left: 0; right: 0; margin: 0 auto;">'.
         '<data-ColnHead'.RowColTest('yellow').'> <span id="colnwrap" '.RowColTest('green').'> '.
         '<data-RowCol class="RowCol'.$wdth.'" '.RowColTest('blue').' >';
}

# Create the next column
function htm_RowCol_next(# wdth:320)    # NextColumn
    $wdth=320) 
{   echo '</data-RowCol> <data-RowCol class="RowCol'.$wdth.'" '.RowColTest('red').'>'; 
}

# Create the last column
function htm_RowCol_end() #             # ColumnBottom
{   echo '</data-RowCol> </span></data-ColnHead><span class="clearWrap"></span>'.     # (the span was never closed)
         '</div>';
}
## Importent: $RowColWdth - Only use defined width ! (See CSS: @media screen)

# A button for different purposes with colors according to purpose: Delete/Create/Navigate/Continue/Submit  [Necessary basic element]
function htm_AcceptButt(# labl:'', icon:'', hint:'', form:'', wdth:'', attr:'', akey:'', kind:'home', rtrn:false, tplc:'LblTip_text', tsty:'', acti:'', idix:'')
    $labl='',           # string: The caption on the button
    $icon='',           # string: The iconclass ('<i class="fas fa-plus"> </i> ';)
    $hint='',           # string: hint about the button function
    $form='',           # string: The form the element belongs to, if a name is given
    $wdth='',           # string: The width of the button
    $attr='',           # string: Generel use e.g. ' action= "$link" '
    $akey='',           # string: Shortcut to activate the button
    $kind='home',       # string: save, navi, goon, erase, create, home (rel. Appearance)
    $rtrn=false,        # bool:   Act as procedure: Echo result, or as function: Return string
    $tplc='LblTip_text',# string: Class for Placement of the tooltip
    $tsty='',           # string: Style for Placement of the tooltip
    $acti='',           # string: Function to run, or submit if empty
    $idix='',           # string: ix-suffix on name/id
    $disa=false         # bolean: 'disabled' to deactivate the button
    )
{   global $gbl_ShortKeys, $gbl_ButtnBgrd, $gbl_BtLnkBgrd, $gbl_TextLight, $gbl_TextDark, $gbl_BtDelBgrd, 
           $gbl_BtDelText, $gbl_BtNavBgrd,  $gbl_BtSavBgrd, $gbl_BtSavText, $gbl_dimmed, $gbl_BtNewBgrd , 
           $gbl_BtNewText , $gbl_BtGooBgrd , $gbl_BtGooText , $gbl_BtNavText;
    dvl_pretty('htm_htm_AcceptButt');
/*     // Colors:
    $gbl_ButtnBgrd= '#44BB44';  /* LysGrøn   * /     $gbl_ButtnText= '#FFFFFF'; 
    $gbl_BtLnkBgrd= 'yellow';   /* '#FCFCCC';  * /   $gbl_BtLnkText= '#000000';
    $gbl_TextLight= 'white';       $gbl_TextDark= 'black';
    $gbl_BtDelBgrd= 'Crimson ';    $gbl_BtDelText= $gbl_TextLight;   # Delete:      RED
    $gbl_BtSavBgrd= '#0064b4';     $gbl_BtSavText= $gbl_TextLight;   # Save/Submit: BLUE
    $gbl_BtNavBgrd= '#1A6E1A';     $gbl_BtNavText= $gbl_TextLight;   # Navigate:    GREEN
    $gbl_BtGooBgrd= '#66CDAA';     $gbl_BtGooText= $gbl_TextDark;    # Continue:    MARINE
    $gbl_BtNewBgrd= 'Orange';      $gbl_BtNewText= $gbl_TextDark;    # CreateNew:   ORANGE
    $gbl_dimmed=    ' opacity:0.9;';
*/
 
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
    if (($akey>'') and ($gbl_ShortKeys ?? true)) {               # On by default - set $gbl_ShortKeys= false to turn shortcuts off
        $akey= mb_substr($akey, 0, 1);                           # accesskey is one character (Alt+key / Alt+Shift+key)
        $keytip= '<br><em>'.lang('@Keyboard shortcut: ').'Alt+'.sys_enc(mb_strtoupper($akey)).'</em>';
        $akey= 'accesskey="'.sys_enc($akey).'" ';
    } else $akey= '';
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

    default       : {$colors= ' background:'.$gbl_BtNavBgrd.'; color:'.$gbl_BtNavText.';'.$gbl_dimmed;} $midn= preg_replace('/[^A-Za-z0-9]/', '', $kind).'_';    # navigate-Butt: GREEN
  }
## Action:
    if ($acti=='') {$type='submit';} else {$type='button';}
## Function:
    $result=  '<span class="center" style="height:25px; display: inline-block;">';
    $result.= '<abbr class="hint">';
    $result.= '    <button class="acceptbutt buttstyl" '.$form.' type= "'.$type.'" name="btn_'.$midn.$name.'" id="'.sys_uid('btn_'.$midn.$name.$idix).'" '.$attr.
              '        style="min-height: 24px; padding-right: 6px; margin-bottom: 6px; '.$wdth. $colors.'" '.
                              ($acti > '' ? ('onclick=\''.$acti.'\' ') : 'onclick=\'location.reload();\' ') .
                              $akey.' '.$aktiv.'> '. 
                              $iconClass .$Label.
              '    </button>';
    $result.= '    <data-hint style="'.$tsty.'">'.lang($hint).$keytip.$info.'</data-hint> ';
    $result.= '</abbr> ';
    $result.= '</span>';
    if (!$rtrn) echo $result; else return $result;
} # :htm_AcceptButt()

# A generel action button 
function htm_ActionButt(# labl:'', icon:'', hint:'', type:'button', name:'', form:'', acti:'', attr:'', rtrn:true)
    $labl='',       # string: Text on the button
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
                    type=\''. $type.'\' 
                    id=\''.$name.'\' 
                    name=\''. $name.'\' '.
                    ($form>'' ? ' form=\''.$form.'\' ' : '').
                    ($acti>'' ? ' onclick=\''.$acti.'\' ' : '').
                    $attr.'>
                    <i class=\''.$icon.'\'> </i> '.lang($labl).
               '</button>
                '.$s2;
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
} # htm_ActionButt()

# A generel botton with icon and label [Necessary basic element]
function htm_IconButt(# labl:'', icon:'', hint:'', type:'submit', name:'', link:'', evnt:'', wdth:'', font:'32px', fclr:'#555', bclr:'white', akey:'', rtrn:false)
    $labl='',       # string: Button label
    $icon='',       # string: Icon before label
    $hint='',       # string: User hint
    $type='submit', # string: Button type
    $name='',       # string: Button id / name
    $link='',       # string: formtarget
    $evnt='',       # string: Event script (earlier: $action)
    $wdth='',       # string: Width
    $font='32px',   # string: font-size
    $fclr='#555',   # string: Forground color (gray gave too little contrast)
    $bclr='white',  # string: Background color
    $akey='',       # string: Keyboard shortcut
    $rtrn=false     # bool:   Function Return or echo
    )
{   global $gbl_ButtnBgrd, $gbl_ShortKeys, $btnix;
    dvl_pretty('htm_IconButt');
    if ($wdth) $wdth= ' width: '.$wdth.';';
    if ($akey) $keytip= '<br>'.lang('@Keyboard shortcut: ').$akey; else $keytip='';
    # A link needs a form (GET) - but forms cannot be nested: inside a card form the button itself carries the target (formaction)
    $inForm= !empty($GLOBALS['gbl_CardForm']);
    $formOpen= ($link > '' and !$inForm) ? '<form name="zzz" action="'.sys_enc($link).'" method="get" style=" display: inline-block; ">' : '';
    $formEnd=  $formOpen ? '</form>' : '';
    $btnTarget= ($link > '' and $inForm) ? ' formaction="'.sys_enc($link).'" formmethod="get"' : '';
    $btnix++;
    $result = '
    <span class="tooltip" style="display:inline; padding:0; width:200px;">
        <abbr class="hint">
            '.$formOpen.'
                <button class="buttstyl" type= "'.$type.'" id="'.$name.'" name="btn_ico_'.$btnix.'"'.$btnTarget.
                 ' style="color:'.$fclr.'; background:'.$bclr.'; '.$wdth.'" accesskey="'.$akey.'" '.$evnt.'>'.
                ' <data-ic class="'.$icon.'" style="font-size:'.$font.'; color:'.$fclr.';  '.$gbl_ButtnBgrd.'; "> </data-ic> '.
                lang($labl). '&nbsp; 
                </button>
            '.$formEnd.'
                <data-hint>'.lang($hint).$keytip.'</data-hint> 
        </abbr>'.
    '</span>';
    if (!$rtrn) echo $result;
    else return $result;
} # htm_IconButt

# Submit button with hint 
function htm_SubmitButt(# labl:'',  hint:'', type:'submit', wdth:'', font:'32px', fclr:'#555', bclr:'white', rtrn:false)
    $labl='',       # string: Button label
    $hint='',       # string: User hint
    $type='submit', # string: Button type
    $wdth='',       # string: Minimum Width
    $font='32px',   # string: font-size
    $fclr='#555',   # string: Forground color (gray gave too little contrast)
    $bclr='white',  # string: Background color
    $rtrn=false     # bool:   Function Return or echo
)
{   if ($wdth) $wdth= ' min-width: '.$wdth.';';
    $result= '<span class="tooltip" style="display:inline; padding:0; width:200px;"> 
        <abbr class="hint">
            <input class="buttstyl" type="'.$type.'" value="'.lang($labl).'" 
                    style="border-width: 2px; font-size:'.$font.'; color:'.$fclr.'; background:'.$bclr.'; '.$wdth.'" >'.
            ' <data-hint>'.lang($hint).'</data-hint>'.
        '</abbr>
    </span>';
    if (!$rtrn) echo $result;
    else return $result;
} # htm_SubmitButt
 

        
# Special buttons for going to top/middle/bottom of page
function htm_GoTopButt(# labl:'@Top', icon:'fa-solid fa-arrow-up', hint:'@Go to page top', styl:'') 
    $labl='@Top',                   # string: Button label
    $icon='fa-solid fa-arrow-up',   # string: Icon before label
    $hint='@Go to page top',        # string: User hint
    $styl=''                        # string: Button custom style
) 
{   global $gbl_BtNavBgrd, $gbl_BtNavText;

    if (!function_exists('renderScrollButton')) {
        function renderScrollButton($id, $onclick, $label, $icon, $hint, $extraStyle = '', $bottom = '6px') {
          global $gbl_BtNavBgrd, $gbl_BtNavText;
          echo '<button type="button" onclick="'.$onclick.'" id="'.$id.'" title="'.sys_enc(strip_tags(lang($hint))).'" style="
            display: none;                          /* Hidden by default */
            position: fixed;                        /* Fixed/sticky position */
            bottom: '.$bottom.';                    /* Place the button at the bottom of the page */
            right: 16px;                            /* Place the button 30px from the right */
            z-index: 99;                            /* Make sure it does not overlap */
            border: none;                           /* Remove borders */
            outline: none;                          /* Remove outline */
            background-color: '.$gbl_BtNavBgrd.';   /* Set a background color */
            color: '.$gbl_BtNavText.';              /* Text color */
            cursor: pointer;                        /* Add a mouse pointer on hover */
            padding: 6px;                           /* Some padding */
            border-radius: 6px;                     /* Rounded corners */
            font-size: 14px;                        /* Increase font size */
            '.$extraStyle.'">
              <abbr class="hint" style="position: relative; color: '.$gbl_BtNavText.';">
                '.($icon ? '<i class="'.$icon.'"></i> ' : '').lang($label).'
                <data-hint style="left: auto; top:-33px; right:44px;">'.lang($hint).'</data-hint>
              </abbr>
          </button>';
        }
    }

    renderScrollButton("btnGoTop", "scrollToTop()", $labl, $icon, $hint, $styl, $bott = "6px");
if (true)     // Use mid-button: (if page-height is very large)
    renderScrollButton("btnGoMid", "scrollToMid()", "@Mid", "fa-solid fa-sort", "@Go to page middle", $styl, $bott ="40px");
    renderScrollButton("btnGoBot", "scrollToBot()", "@Bot", "fa-solid fa-arrow-down", "@Go to page bottom", $styl, $bott ="74px");

echo '<style> html { scroll-behavior: smooth; } </style>
    <script>
        window.onscroll = function() {
          toggleButton("btnGoTop");
          toggleButton("btnGoMid");
          toggleButton("btnGoBot");
        };
        function toggleButton(id) {
          const btn = document.getElementById(id);
          if (!btn) return;
          btn.style.display = (document.documentElement.scrollTop > 30 || document.body.scrollTop > 30) ? "block" : "none";
        }
        function scrollToTop() {
          document.documentElement.scrollTop = 0;   // For Safari
          document.body.scrollTop = 0;              // For Chrome, Firefox, IE and Opera
        }
        function scrollToMid() {
          const pos = document.documentElement.scrollHeight / 2;
          document.documentElement.scrollTop = pos; // For Safari
          document.body.scrollTop = pos;            // For Chrome, Firefox, IE and Opera
        }
        function scrollToBot() {
          const pos = document.documentElement.scrollHeight / 1;
          document.documentElement.scrollTop = pos; // For Safari
          document.body.scrollTop = pos;            // For Chrome, Firefox, IE and Opera
        }
    </script>';
}

# Extract a CSS color from "background-color: white;" / "white;" / "white" (used by the palette)
function p2h_cssColor($v, $default) {
    $v= trim(preg_replace('/^\s*background(-color)?\s*:\s*/i', '', (string)$v), " ;\t\n");
    return preg_match('/^[#\w(),.\s%-]+$/', $v) && ($v>'') ? $v : $default;
}

# One <script> in <head>: sets the theme before the page is painted, and defines the shared JS helpers:
# p2hSetTheme()/p2hCycleTheme(), sysAlert()/sysConfirm()/sysPrompt() and the card functions p2hCard*().
# Default theme: $gbl_Theme ('light' | 'dark' | 'auto' | 'custom') - 'light' keeps the classic look.
function p2h_themeBoot() {
    $T= json_encode(['ok'=>lang('@OK'), 'cancel'=>lang('@Cancel'), 'info'=>lang('@Information'), 'confirm'=>lang('@Please confirm'),
                     'input'=>lang('@Input'), 'light'=>lang('@Light'), 'dark'=>lang('@Dark'), 'auto'=>lang('@Auto'),
                     'custom'=>lang('@Custom')], JSON_UNESCAPED_UNICODE);
    $def= in_array($GLOBALS['gbl_Theme'] ?? 'light', ['light','dark','auto','custom']) ? ($GLOBALS['gbl_Theme'] ?? 'light') : 'light';
    return '<script>
var P2H_T= '.$T.';
/* Custom ("own") theme: a few base colors chosen by the user, stored in this browser */
var P2H_CVARS= {page:["--PageBcgrd"], card:["--CardsBgrd"], text:["--TextColr"], input:["--InptBgrd"], accent:["--AccnColr","--themeColr"]};
var P2H_CDEF=  {light: {base:"light", page:"#e6e8ea", card:"#ffffff", text:"#222222", input:"#ffffff", accent:"#006400"},
                dark:  {base:"dark",  page:"#15181c", card:"#1f2328", text:"#e3e3e3", input:"#2a2f36", accent:"#8fd18f"}};
/* Set the saved theme before the page is painted (after the variables above are defined) */
(function(){ var m; try { m= localStorage.getItem("p2h-theme"); } catch(e) {} p2hApplyTheme(m || "'.$def.'"); })();
function p2hGetCustom() {
    var c= null; try { c= JSON.parse(localStorage.getItem("p2h-theme-custom") || "null"); } catch(e) {}
    var base= (c && c.base==="dark") ? "dark" : "light";
    return Object.assign({}, P2H_CDEF[base], c || {});
}
function p2hApplyTheme(m, preview) {
    var d= document.documentElement, t;
    for (var k in P2H_CVARS) P2H_CVARS[k].forEach(function(v){ d.style.removeProperty(v); });
    if (m==="custom") {
        var c= preview || p2hGetCustom();
        t= (c.base==="dark") ? "dark" : "light";
        for (var k2 in P2H_CVARS) if (c[k2]) P2H_CVARS[k2].forEach(function(v){ d.style.setProperty(v, c[k2]); });
        d.setAttribute("data-p2h-custom", "1");
    } else {
        t= (m==="auto") ? (matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light") : m;
        d.removeAttribute("data-p2h-custom");
    }
    d.setAttribute("data-theme-mode", m);
    d.setAttribute("data-theme", t);
    if (t==="dark" || m==="custom") d.setAttribute("data-p2h-vars", "1"); else d.removeAttribute("data-p2h-vars");
}
function p2hSaveCustom(c) {
    try { localStorage.setItem("p2h-theme-custom", JSON.stringify(c)); } catch(e) {}
    p2hSetTheme("custom");
}
function p2hSetTheme(m) {
    try { localStorage.setItem("p2h-theme", m); } catch(e) {}
    p2hApplyTheme(m);
    document.querySelectorAll(".p2hThemeButt").forEach(p2hThemeLabel);
}
function p2hCycleTheme() {
    var o= ["light","dark","auto","custom"], c= document.documentElement.getAttribute("data-theme-mode") || "light";
    p2hSetTheme(o[(o.indexOf(c)+1) % o.length]);
}
function p2hThemeLabel(b) {
    var m= document.documentElement.getAttribute("data-theme-mode") || "light";
    var ic= b.querySelector(".p2hThemeIc"); if (ic) ic.className= "p2hThemeIc fa-solid "+({light:"fa-sun",dark:"fa-moon",auto:"fa-circle-half-stroke",custom:"fa-palette"}[m]);
    var tx= b.querySelector(".p2hThemeTx"); if (tx) tx.textContent= P2H_T[m];
}
/* Card size: drag the grip in the lower right corner - the width of the card and the height of its body (scrolls if needed).
   Remembered per page and card in this browser. Double-click / Home: back to the original size. Arrow keys: 10px (Shift: 50px). */
var p2hCardSize= (function() {
    function key(card)   { return "p2h-card:" + location.pathname + "#" + card.id; }
    function body(card)  { return document.getElementById("HideBody" + card.id.replace("card", "")); }
    function apply(card, s) {
        var b= body(card);
        if (!(b && b.style.display === "none"))                    /* A folded card keeps its closed width */
            card.style.width= (s && s.w && innerWidth > 760) ? s.w + "px" : "";
        if (b) b.style.maxHeight= (s && s.h) ? s.h + "px" : (b.dataset.p2hMaxh || b.style.maxHeight);
    }
    function save(card, s) { try { if (s) localStorage.setItem(key(card), JSON.stringify(s)); else localStorage.removeItem(key(card)); } catch(e) {} }
    function size(card)  { var b= body(card); return {w: Math.round(card.offsetWidth), h: b ? Math.round(b.offsetHeight) : 0}; }
    function reset(card) { save(card, null); apply(card, null); }
    function stored(card) { try { return JSON.parse(localStorage.getItem(key(card)) || "null"); } catch(e) { return null; } }
    function resize(card, w, h) {
        var old= stored(card), cols= !!card.closest(".p2hColview");                /* Column view: the column sets the width */
        var s= {w: cols ? ((old && old.w) || 0) : Math.max(200, Math.round(w)), h: Math.max(40, Math.round(h))};
        apply(card, s);  return s;
    }
    function cardOf(g) { return g.closest(".p2hGripHint").parentElement; }
    var hinted= 0;
    function colHint(g) {                                       /* Column view: say why the width does not follow the mouse */
        if (!cardOf(g).closest(".p2hColview") || Date.now() - hinted < 6000) return;
        hinted= Date.now();  if (typeof htm_Toast === "function") htm_Toast(g.dataset.colhint, "#2c3e50", "#fff", 6000);
    }
    document.addEventListener("pointerdown", function(e) {
        var g= e.target.closest && e.target.closest(".p2hCardGrip");  if (!g || e.button > 0) return;
        colHint(g);
        var card= cardOf(g), s0= size(card), x0= e.clientX, y0= e.clientY, last= null;
        e.preventDefault();  try { g.setPointerCapture(e.pointerId); } catch(err) {}
        var z= parseFloat(getComputedStyle(document.body).zoom) || 1;              /* Page zoom: mouse pixels are zoomed pixels */
        function move(ev) { last= resize(card, s0.w + (ev.clientX - x0) / z, s0.h + (ev.clientY - y0) / z); }
        function up()     { g.removeEventListener("pointermove", move);  g.removeEventListener("pointerup", up);  g.removeEventListener("pointercancel", up);
                            if (last) save(card, last); }
        g.addEventListener("pointermove", move);  g.addEventListener("pointerup", up);  g.addEventListener("pointercancel", up);
    });
    document.addEventListener("dblclick", function(e) { var g= e.target.closest && e.target.closest(".p2hCardGrip"); if (g) reset(cardOf(g)); });
    document.addEventListener("keydown", function(e) {
        var g= e.target.closest && e.target.closest(".p2hCardGrip");  if (!g) return;
        var card= cardOf(g), n= e.shiftKey ? 50 : 10, d= {ArrowLeft:[-n,0], ArrowRight:[n,0], ArrowUp:[0,-n], ArrowDown:[0,n]}[e.key];
        if (e.key==="Home") { e.preventDefault(); reset(card); return; }
        if (!d) return;
        if (d[0]) colHint(g);
        e.preventDefault();  var s= size(card);  save(card, resize(card, s.w + d[0], s.h + d[1]));
    });
    document.addEventListener("DOMContentLoaded", function() {      /* The saved sizes of this page */
        document.querySelectorAll(".p2hCardGrip").forEach(function(g) {
            var card= cardOf(g), b= body(card), s= null;
            if (b) b.dataset.p2hMaxh= b.style.maxHeight;            /* The original max-height (for reset) */
            try { s= JSON.parse(localStorage.getItem(key(card)) || "null"); } catch(e) {}
            if (s) apply(card, s);
        });
    });
    function restore(card) { var s= null; try { s= JSON.parse(localStorage.getItem(key(card)) || "null"); } catch(e) {} if (s) apply(card, s); }
    return {reset: reset, restore: restore};
})();
/* Card order: drag a card to another place among its sibling cards - htm_Card_(move:) and $gbl_CardMove (icon / header / toggle).
   Remembered per page in this browser. Alt + arrow up/down: one place. The card menu (right-click the header): "Original card order". */
var p2hCardMove= (function() {
    var SK= "p2h-order:" + location.pathname, noClick= false;
    function cards(p)   { return [].filter.call(p.children, function(c) { return c.hasAttribute("data-p2h-move"); }); }
    function arranging() { return document.documentElement.classList.contains("p2hArrange"); }
    function active(c)  { var m= c.getAttribute("data-p2h-move");  return !!m && (m !== "toggle" || arranging()); }
    function load()     { try { return JSON.parse(localStorage.getItem(SK) || "{}") || {}; } catch(e) { return {}; } }
    function group(p)   { var l= cards(p).sort(function(a, b) { return a.dataset.p2hIx - b.dataset.p2hIx; });   /* The first card of the original order */
                          return l.length ? l[0].getAttribute("data-p2h-key") : ""; }
    function save(p)    { var o= load();  o[group(p)]= cards(p).map(function(c) { return c.getAttribute("data-p2h-key"); });
                          try { localStorage.setItem(SK, JSON.stringify(o)); } catch(e) {} }
    function place(p, list) {                                   /* The cards of p in this order - other content keeps its place */
        var marks= cards(p).map(function(c) { var m= document.createComment("p2h");  p.insertBefore(m, c);  return m; });
        list.forEach(function(c, i) { p.insertBefore(c, marks[i]); });
        marks.forEach(function(m) { m.remove(); });
    }
    function groups(fn) { var seen= [];
        document.querySelectorAll("[data-p2h-move]").forEach(function(c) { var p= c.parentElement;  if (seen.indexOf(p) < 0) { seen.push(p);  fn(p); } }); }
    function refresh()  { var c= document.querySelector("[data-p2h-cols]");  if (c && typeof p2hColBreaks === "function") p2hColBreaks(c); }
    function restore() {
        document.querySelectorAll("[data-p2h-move]").forEach(function(c, i) { c.dataset.p2hIx= i; });   /* The original order (for reset) */
        var o= load();
        groups(function(p) {
            var want= o[group(p)];  if (!want) return;
            var now= cards(p), by= {};  now.forEach(function(c) { by[c.getAttribute("data-p2h-key")]= c; });
            var list= want.map(function(k) { return by[k]; }).filter(Boolean);
            now.forEach(function(c) { if (list.indexOf(c) < 0) list.splice(now.indexOf(c), 0, c); });   /* A new card: near its own place */
            place(p, list);
        });
        refresh();
    }
    function reset() {
        try { localStorage.removeItem(SK); } catch(e) {}
        groups(function(p) { place(p, cards(p).sort(function(a, b) { return a.dataset.p2hIx - b.dataset.p2hIx; })); });
        refresh();
    }
    function arrange(on, toggle) {                              /* "toggle" mode: the view bar button turns moving on / off */
        if (toggle) on= !arranging();
        document.documentElement.classList.toggle("p2hArrange", !!on);
        document.querySelectorAll("[data-vb=arrange]").forEach(function(b) { b.setAttribute("aria-pressed", on ? "true" : "false"); });
    }
    function cardOf(t) {                                        /* The card whose handle (icon or header) t is in */
        if (!t || !t.closest) return null;
        var ic= t.closest(".p2hMoveIc");  if (ic) return ic.closest("[data-p2h-move]");
        var h= t.closest("[id^=chead]");  if (!h) return null;
        var c= document.getElementById("card" + h.id.slice(5));
        if (!c || !c.hasAttribute("data-p2h-move") || c.getAttribute("data-p2h-move") === "icon") return null;
        return t.closest("ic[role=button], button, a, input, select, textarea") ? null : c;   /* The header buttons keep working */
    }
    document.addEventListener("pointerdown", function(e) {
        if (e.button > 0) return;
        var card= cardOf(e.target);  if (!card || !active(card)) return;
        var x0= e.clientX, y0= e.clientY, started= false;
        if (e.target.closest(".p2hMoveIc")) e.preventDefault();
        function move(ev) {
            if (!started) {
                if (Math.abs(ev.clientX - x0) + Math.abs(ev.clientY - y0) < 6) return;   /* A click on the header still folds the card */
                started= true;  card.classList.add("p2hMoving");  document.documentElement.classList.add("p2hDragging");
                try { getSelection().removeAllRanges(); } catch(err) {}
            }
            var el= document.elementFromPoint(ev.clientX, ev.clientY), t= (el && el.closest) ? el.closest("[data-p2h-move]") : null;
            while (t && t.parentElement !== card.parentElement) t= t.parentElement ? t.parentElement.closest("[data-p2h-move]") : null;
            if (!t || t === card) return;
            var r= t.getBoundingClientRect(), cr= card.getBoundingClientRect();
            var row= (r.top < cr.bottom) && (cr.top < r.bottom);   /* Side by side: left / right half - else upper / lower half */
            var after= row ? (ev.clientX > r.left + r.width / 2) : (ev.clientY > r.top + r.height / 2);
            card.parentElement.insertBefore(card, after ? t.nextSibling : t);
        }
        function up() {
            removeEventListener("pointermove", move, true);  removeEventListener("pointerup", up, true);  removeEventListener("pointercancel", up, true);
            if (!started) return;
            card.classList.remove("p2hMoving");  document.documentElement.classList.remove("p2hDragging");
            noClick= true;  setTimeout(function() { noClick= false; }, 0);      /* No fold click after a drag */
            save(card.parentElement);  refresh();
        }
        addEventListener("pointermove", move, true);  addEventListener("pointerup", up, true);  addEventListener("pointercancel", up, true);
    });
    document.addEventListener("click", function(e) { if (noClick) { noClick= false;  e.preventDefault();  e.stopPropagation(); } }, true);
    document.addEventListener("keydown", function(e) {
        var d= e.altKey ? {ArrowUp: -1, ArrowDown: 1}[e.key] : 0;  if (!d) return;
        var t= e.target, card= (t.closest && t.closest(".p2hMoveIc")) ? t.closest("[data-p2h-move]") : cardOf(t);
        if (!card || !active(card)) return;
        e.preventDefault();
        var l= cards(card.parentElement), j= l.indexOf(card) + d;  if (j < 0 || j >= l.length) return;
        card.parentElement.insertBefore(card, d < 0 ? l[j] : l[j].nextSibling);
        t.focus();  save(card.parentElement);  refresh();
    });
    document.addEventListener("DOMContentLoaded", restore);
    return {reset: reset, restore: restore, arrange: arrange};
})();
/* Print: a card or fieldset taller than a page is an inline-block, which the browser cannot split over pages - it would jump to the
   next page and leave an empty one. Only those big ones become blocks while printing; small cards keep their side-by-side layout. */
addEventListener("beforeprint", function() {
    document.querySelectorAll("[id^=card], fieldset").forEach(function(e) { if (e.offsetHeight > 900) e.classList.add("p2hPrintBlock"); });
});
addEventListener("afterprint", function() { document.querySelectorAll(".p2hPrintBlock").forEach(function(e) { e.classList.remove("p2hPrintBlock"); }); });
/* Skip links: to the first card (past the menus) or to the view bar (it is the last element in the document) */
document.addEventListener("click", function(e) {
    var a= e.target.closest && e.target.closest(".p2hSkip");  if (!a) return;
    e.preventDefault();
    var t= (a.dataset.skip === "tools") ? document.querySelector(".p2hViewBar button")
                                        : (document.querySelector("#p2hMain [id^=card]") || document.getElementById("p2hMain"));
    if (!t) return;
    if (t.tabIndex < 0 && !/^(BUTTON|A|INPUT)$/.test(t.tagName)) t.setAttribute("tabindex", "-1");
    t.focus();  t.scrollIntoView({block: "start"});
});
/* Keyboard: Enter / Space on an element with role="button" (card header icons, state buttons...) acts like a click */
document.addEventListener("keydown", function(e) {
    var t= e.target;
    if ((e.key==="Enter" || e.key===" ") && t.matches && t.matches("[role=button]:not(button):not(a):not(input):not(.p2hCardGrip)")) { e.preventDefault(); t.click(); }
});
/* Tablesorter "zebra" only colors rows that are visible when it runs - tables in a closed card or tab got no stripes.
   Re-run it when a table becomes visible (and after its size changes, e.g. a card is opened). */
addEventListener("load", function() {
    if (!window.jQuery || !jQuery.tablesorter || !window.ResizeObserver) return;
    var ro= new ResizeObserver(function(entries) {
        entries.forEach(function(e) { if (e.contentRect.height > 0 && e.target.config) jQuery(e.target).trigger("applyWidgetId", ["zebra"]); });
    });
    document.querySelectorAll("table").forEach(function(t) { ro.observe(t); });   /* tablesorter may be set up after "load" */
});
matchMedia("(prefers-color-scheme: dark)").addEventListener("change", function(){
    if (document.documentElement.getAttribute("data-theme-mode")==="auto") p2hApplyTheme("auto"); });

/* Theme-aware dialogs. The message is shown as text (no HTML). */
function p2hDialog(o) {
    if (typeof HTMLDialogElement !== "function") {          // Very old browser: native fallback
        if (o.input) { var r= prompt(o.msg, o.def||""); if (r!==null && o.onOk) o.onOk(r); else if (r===null && o.onCancel) o.onCancel(); }
        else if (o.cancel) { if (confirm(o.msg)) { if (o.onOk) o.onOk(true); } else if (o.onCancel) o.onCancel(); }
        else { alert(o.msg); if (o.onOk) o.onOk(true); }
        return;
    }
    var d= document.createElement("dialog"); d.className= "p2hDlg";
    var h= document.createElement("div");    h.className= "p2hDlgHead"; h.textContent= o.title || "";
    var b= document.createElement("div");    b.className= "p2hDlgBody"; b.textContent= (o.msg === undefined ? "" : String(o.msg));
    var inp= null;
    if (o.input) { inp= document.createElement("input"); inp.type= "text"; inp.className= "p2hDlgInp"; inp.value= o.def || ""; b.appendChild(inp); }
    var f= document.createElement("div");    f.className= "p2hDlgFoot";
    var done= false;
    function close(okay) {
        if (done) return; done= true; d.close(); d.remove();
        if (okay) { if (o.onOk) o.onOk(inp ? inp.value : true); } else if (o.onCancel) o.onCancel();
    }
    if (o.cancel) { var c= document.createElement("button"); c.type= "button"; c.textContent= o.cancel; c.onclick= function(){ close(false); }; f.appendChild(c); }
    var ok= document.createElement("button"); ok.type= "button"; ok.className= "p2hDlgOk"; ok.textContent= o.ok; ok.onclick= function(){ close(true); };
    f.appendChild(ok);
    d.appendChild(h); d.appendChild(b); d.appendChild(f);
    d.addEventListener("cancel", function(e){ e.preventDefault(); close(false); });          // Esc
    if (inp) inp.addEventListener("keydown", function(e){ if (e.key==="Enter") { e.preventDefault(); close(true); } });
    document.body.appendChild(d); d.showModal(); (inp || ok).focus();
}
function sysAlert(msg, title, onOk)              { p2hDialog({title: title || P2H_T.info,    msg: msg, ok: P2H_T.ok, onOk: onOk}); }
function sysConfirm(msg, onOk, title, onCancel)  { p2hDialog({title: title || P2H_T.confirm, msg: msg, ok: P2H_T.ok, cancel: P2H_T.cancel, onOk: onOk, onCancel: onCancel}); }
function sysPrompt(msg, onOk, def, title)        { p2hDialog({title: title || P2H_T.input,   msg: msg, input: true, def: def, ok: P2H_T.ok, cancel: P2H_T.cancel, onOk: onOk}); }

/* Cards: shared functions (the per-card CardSwitchN() etc. call these). No jQuery needed. */
function p2hCardEls(ix)        { return [document.getElementById("HideBody"+ix), document.getElementById("card"+ix)]; }
function p2hRefreshTables()    { if (window.jQuery) jQuery("table").trigger("applyWidgets"); }   // Re-layout tablesorter tables that were hidden
function p2hCardHeight(ix, vh) { var h= p2hCardEls(ix)[0]; if (!h) return; h.style.maxHeight= (parseInt(h.style.maxHeight) < 4000) ? "4000px" : vh; }
function p2hCardToggle(ix, w)  { var e= p2hCardEls(ix); if (!e[0]) return;
    if (e[0].style.display === "none") { e[0].style.display= "block"; e[1].style.width= ""; if (window.p2hCardSize) p2hCardSize.restore(e[1]); p2hRefreshTables(); }
    else                               { e[0].style.display= "none";  e[1].style.width= w; } }
function p2hCardMin(ix, w)     { var e= p2hCardEls(ix); if (!e[0]) return; e[0].style.display= "none";  e[1].style.width= w; }
function p2hCardMax(ix)        { var e= p2hCardEls(ix); if (!e[0]) return; e[0].style.display= "block"; e[1].style.width= ""; if (window.p2hCardSize) p2hCardSize.restore(e[1]); p2hRefreshTables(); }
function p2hCardWide(ix, c)    { var p= p2hCardEls(ix)[1]; if (!p) return;
    if (p.classList.contains("cardWmax")) { p.classList.remove("cardWmax"); p.classList.add(c); } else { p.classList.remove(c); p.classList.add("cardWmax"); } }
function p2hCardsAll(open)     { document.querySelectorAll("[id^=HideBody]").forEach(function(h){
        var f= window[(open ? "CardMaximize" : "CardMinimize") + h.id.slice(8)];  if (typeof f === "function") f(); }); }
</script>';
}

# A button that cycles the page theme: light -> dark -> auto (follows the operating system) -> custom. The choice is remembered.
function htm_ThemeButt(# labl:'', hint:'@...', rtrn:false)
    $labl= '',              # string: Optional text before the current theme name
    $hint= '@Switch theme: light, dark, automatic (follows the system) or your own colors',
    $rtrn= false            # bool:   Return or echo result
) {
    $result= '<button type="button" class="p2hThemeButt" onclick="p2hCycleTheme()" title="'.sys_enc(strip_tags(lang($hint))).'">'.
             '<ic class="p2hThemeIc fa-solid fa-sun"></ic> '.($labl>'' ? lang($labl).' ' : '').'<span class="p2hThemeTx"></span></button>'.
             '<script>document.querySelectorAll(".p2hThemeButt").forEach(p2hThemeLabel);</script>';
    if (!$rtrn) echo $result; else return $result;
}


# A small flag (inline SVG - flag emojis are not shown on Windows). Unknown codes: the code as text.
function p2h_flag($code) {
    static $F= [
        'da' => ['0 0 20 14', '<rect width="20" height="14" fill="#c8102e"/><rect x="6" width="2" height="14" fill="#fff"/><rect y="6" width="20" height="2" fill="#fff"/>'],
        'sv' => ['0 0 20 14', '<rect width="20" height="14" fill="#006aa7"/><rect x="6" width="2.4" height="14" fill="#fecc00"/><rect y="5.8" width="20" height="2.4" fill="#fecc00"/>'],
        'no' => ['0 0 22 16', '<rect width="22" height="16" fill="#ba0c2f"/><rect x="6" width="4" height="16" fill="#fff"/><rect y="6" width="22" height="4" fill="#fff"/><rect x="7" width="2" height="16" fill="#00205b"/><rect y="7" width="22" height="2" fill="#00205b"/>'],
        'de' => ['0 0 20 14', '<rect width="20" height="14" fill="#ffce00"/><rect width="20" height="9.33" fill="#dd0000"/><rect width="20" height="4.67" fill="#000"/>'],
        'fr' => ['0 0 20 14', '<rect width="20" height="14" fill="#ef4135"/><rect width="13.33" height="14" fill="#fff"/><rect width="6.67" height="14" fill="#0055a4"/>'],
        'en' => ['0 0 60 30', '<rect width="60" height="30" fill="#012169"/><path d="M0,0 60,30M60,0 0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 60,30M60,0 0,30" stroke="#c8102e" stroke-width="2"/><path d="M30,0v30M0,15h60" stroke="#fff" stroke-width="10"/><path d="M30,0v30M0,15h60" stroke="#c8102e" stroke-width="6"/>'],
    ];
    $c= strtolower(substr((string)$code, 0, 2));
    if ($c=='nb' or $c=='nn') $c= 'no';
    if (!isset($F[$c])) return '<span class="p2hFlagTx">'.sys_enc(strtoupper($c)).'</span>';
    return '<svg class="p2hFlag" width="20" height="14" viewBox="'.$F[$c][0].'" preserveAspectRatio="none" aria-hidden="true">'.$F[$c][1].'</svg>';
}

# Language selector with flags (used in the view bar): the languages that have translations, plus English
function htm_LangSelect(# rtrn:false)
    $rtrn= false            # bool:   Return or echo result
) {
    global $allLang, $lang, $englishOnly;
    if ($englishOnly or !is_array($allLang)) return '';
    $list= ['en'=>'English'];
    foreach ($allLang as $l)
        if (is_array($l) and !empty($l['translation']) and preg_match('/^[a-z]{2}$/', $l['code'] ?? ''))
            $list[$l['code']]= mb_convert_case(trim(explode(',', (string)($l['native'] ?? $l['code']))[0]), MB_CASE_TITLE, 'UTF-8');
    if (count($list) < 2) return '';
    $cur= isset($list[$lang]) ? $lang : 'en';
    $t= function($k) { return sys_enc(strip_tags(lang($k))); };
    $result= '<span class="p2hLang" data-csrf="'.sys_enc($_SESSION['csrf_token'] ?? '').'">'.
             '<button type="button" class="p2hLangButt" aria-haspopup="true" aria-expanded="false" title="'.$t('@Language').': '.sys_enc($list[$cur]).'">'.
                p2h_flag($cur).' <span class="p2hLangCode">'.strtoupper($cur).'</span></button>'.
             '<span class="p2hLangList" role="menu" aria-label="'.$t('@Choose language').'" hidden>';
    foreach ($list as $code=>$name)
        $result.= '<button type="button" role="menuitemradio" aria-checked="'.($code==$cur ? 'true' : 'false').'" data-lang="'.$code.'" lang="'.$code.'">'.
                  p2h_flag($code).' '.sys_enc($name).'</button>';
    $result.= '</span></span>';
    static $jsDone= false;
    if (!$jsDone) { $jsDone= true;  $result.= '<script>
(function(){    /* Open / close the list; a choice posts the language (with the CSRF token) and the page is shown again */
  function close(box) { var l= box.querySelector(".p2hLangList"); l.hidden= true; box.querySelector(".p2hLangButt").setAttribute("aria-expanded", "false"); }
  document.addEventListener("click", function(e) {
    var box= e.target.closest && e.target.closest(".p2hLang");
    document.querySelectorAll(".p2hLang").forEach(function(b) { if (b!==box) close(b); });
    if (!box) return;
    var item= e.target.closest("[data-lang]");
    if (item) {
      if (item.getAttribute("aria-checked")==="true") { close(box); return; }
      var f= document.createElement("form");  f.method= "post";  f.action= location.href;  f.style.display= "none";
      [["language", item.dataset.lang], ["csrf_token", box.dataset.csrf], ["p2h_langOnly", "1"]].forEach(function(v) {
        var i= document.createElement("input");  i.type= "hidden";  i.name= v[0];  i.value= v[1];  f.appendChild(i); });
      document.body.appendChild(f);  f.submit();  return;
    }
    if (e.target.closest(".p2hLangButt")) {
      var l= box.querySelector(".p2hLangList"), open= l.hidden;
      l.hidden= !open;  box.querySelector(".p2hLangButt").setAttribute("aria-expanded", open ? "true" : "false");
      if (open) {
        l.classList.toggle("up", box.getBoundingClientRect().bottom + l.offsetHeight + 8 > innerHeight);   /* No room below: open upwards */
        (l.querySelector("[aria-checked=true]") || l.querySelector("button")).focus();
      }
    }
  });
  document.addEventListener("keydown", function(e) {
    var box= e.target.closest && e.target.closest(".p2hLang");  if (!box) return;
    if (e.key==="Escape") { close(box); box.querySelector(".p2hLangButt").focus(); }
    if (e.key==="ArrowDown" || e.key==="ArrowUp") {
      var items= [].slice.call(box.querySelectorAll("[data-lang]")), i= items.indexOf(document.activeElement);
      if (i < 0) return;  e.preventDefault();
      items[(i + (e.key==="ArrowDown" ? 1 : items.length-1)) % items.length].focus();
    }
  });
})();
</script>'; }
    if (!$rtrn) echo $result; else return $result;
}

# A personal notepad: plain text, saved automatically in this browser (the same notes on all pages of the site) - from TinyCash
function htm_NotePad(# rtrn:false)
    $rtrn= false            # bool:   Return or echo result
) {
    # Plain text (a <textarea>) - the notes can never become code on the page. No server, no login: only this browser keeps them.
    if (!($GLOBALS['gbl_NotePad'] ?? true)) return '';
    $t= function($k) { return sys_enc(strip_tags(lang($k))); };
    $result= '<button type="button" class="p2hNoteButt" aria-haspopup="dialog" aria-controls="p2hNoteWin" title="'.$t('@My notes').'"><ic class="fa-solid fa-note-sticky"></ic></button>'.
             '<div id="p2hNoteWin" class="p2hHelpWin p2hNoteWin" role="dialog" aria-labelledby="p2hNoteTtl" hidden>'.
                '<div class="p2hNoteHead" title="'.$t('@Drag to move').'"><ic class="fa-solid fa-note-sticky" aria-hidden="true"></ic> '.
                    '<span id="p2hNoteTtl">'.$t('@My notes').'</span>'.
                    '<button type="button" class="p2hNoteClose" aria-label="'.$t('@Close').'">&times;</button></div>'.
                '<textarea class="p2hNoteText" placeholder="'.$t('@Write your notes here...').'" aria-label="'.$t('@My notes').'"></textarea>'.
                '<div class="p2hHelpFoot p2hNoteFoot">'.
                    '<span class="p2hNoteState" aria-live="polite"></span>'.
                    '<button type="button" data-note="download" title="'.$t('@Save the notes as a text file').'"><ic class="fa-solid fa-download"></ic> '.$t('@Download').'</button>'.
                    '<button type="button" data-note="clear" title="'.$t('@Delete all notes').'"><ic class="fa-solid fa-trash"></ic> '.$t('@Clear').'</button>'.
                '</div>'.
             '</div>'.
             '<script>
(function(){    /* Notepad: auto-save (localStorage), "saved" state, download, clear; movable like the help window */
  var KEY= "p2h-notepad", T= '.json_encode(['saved'=>strip_tags(lang('@Saved in this browser')), 'nostore'=>strip_tags(lang('@The notes cannot be saved in this browser')),
                                          'ask'=>strip_tags(lang('@Delete all notes?')), 'chars'=>strip_tags(lang('@characters'))]).';
  var win= document.getElementById("p2hNoteWin"), ta= win.querySelector(".p2hNoteText"), st= win.querySelector(".p2hNoteState"), timer= null, opener= null;
  function get()  { try { return localStorage.getItem(KEY) || ""; } catch(e) { return ""; } }
  function put(v) { try { if (v) localStorage.setItem(KEY, v); else localStorage.removeItem(KEY); return true; } catch(e) { return false; } }
  function mark() { document.querySelectorAll(".p2hNoteButt").forEach(function(b) { b.classList.toggle("hasNotes", get() !== ""); }); }
  function save() { st.textContent= put(ta.value) ? T.saved + " - " + ta.value.length + " " + T.chars : T.nostore;  mark(); }
  ta.value= get();  mark();
  ta.addEventListener("input", function() { clearTimeout(timer);  timer= setTimeout(save, 400); });
  function show(b) { if (win.parentNode !== document.documentElement) document.documentElement.appendChild(win);
                     opener= b;  ta.value= get();  st.textContent= "";  win.hidden= false;  ta.focus(); }
  function hide()  { if (win.hidden) return;  clearTimeout(timer);  save();  win.hidden= true;  if (opener) opener.focus(); }
  document.addEventListener("click", function(e) {
    var b= e.target.closest && e.target.closest(".p2hNoteButt");
    if (b) { win.hidden ? show(b) : hide();  return; }
    if (e.target.closest && e.target.closest(".p2hNoteClose")) { hide();  return; }
    var a= e.target.closest && e.target.closest("[data-note]");  if (!a || !win.contains(a)) return;
    if (a.dataset.note === "download") {
      var l= document.createElement("a");  l.href= URL.createObjectURL(new Blob([ta.value], {type: "text/plain;charset=utf-8"}));
      l.download= "notes.txt";  document.body.appendChild(l);  l.click();  l.remove();
    }
    if (a.dataset.note === "clear") sysConfirm(T.ask, function() { ta.value= "";  save();  ta.focus(); });
  });
  document.addEventListener("keydown", function(e) { if (e.key==="Escape" && !win.hidden && win.contains(document.activeElement)) hide(); });
  addEventListener("storage", function(e) { if (e.key===KEY) { if (document.activeElement !== ta) ta.value= get();  mark(); } });   /* Another tab changed the notes */
  win.querySelector(".p2hNoteHead").addEventListener("pointerdown", function(e) {
    if (e.target.closest(".p2hNoteClose") || e.button > 0) return;
    var h= e.currentTarget, r= win.getBoundingClientRect(), dx= e.clientX - r.left, dy= e.clientY - r.top;
    e.preventDefault();  try { h.setPointerCapture(e.pointerId); } catch(err) {}
    function move(ev) { win.style.left= Math.max(0, Math.min(ev.clientX - dx, innerWidth - win.offsetWidth)) + "px";
                        win.style.top=  Math.max(0, Math.min(ev.clientY - dy, innerHeight - win.offsetHeight)) + "px";  win.style.right= "auto"; }
    function up() { h.removeEventListener("pointermove", move);  h.removeEventListener("pointerup", up);  h.removeEventListener("pointercancel", up); }
    h.addEventListener("pointermove", move);  h.addEventListener("pointerup", up);  h.addEventListener("pointercancel", up);
  });
})();
</script>';
    if (!$rtrn) echo $result; else return $result;
}

# A fixed bar at the bottom of the window with shortcuts, e.g. "New invoice" (from TinyCash, the buttons given by the program)
function htm_QuickBar(# list:[], rtrn:false)
    $list= [],              # array:  The buttons: [[0:link, 1:labl, 2:icon, 3:hint, 4:colr (a small dot), 5:acti (JavaScript instead of the link)], ...]
    $rtrn= false            # bool:   Return or echo result
) {
    # The page gets room at the bottom, and the library's own fixed elements near the bottom are lifted above the bar
    # (in TinyCash a bottom bar hid the page end and other fixed buttons - see the CSS .p2hHasQuickBar).
    if (!$list) return '';
    $result= '<nav class="p2hQuickBar" aria-label="'.sys_enc(strip_tags(lang('@Quick actions'))).'">';
    foreach ($list as $b) {
        $b= array_pad((array)$b, 6, '');
        $lbl= lang($b[1]);
        $result.= '<a class="p2hQbItem" href="'.sys_enc($b[0]>'' ? $b[0] : '#').'"'.
                  ($b[5]>'' ? ' onclick="'.sys_enc($b[5]).'; return false;"' : '').
                  ($b[3]>'' ? ' title="'.sys_enc(strip_tags(lang($b[3]))).'"' : '').' aria-label="'.sys_enc(strip_tags($lbl)).'">'.
                  ($b[4]>'' ? '<span class="p2hQbDot" style="background:'.sys_enc($b[4]).';"></span>' : '').
                  ($b[2]>'' ? '<ic class="'.sys_enc($b[2]).'" aria-hidden="true"></ic>' : '').
                  '<span class="p2hQbTxt">'.$lbl.'</span></a>';
    }
    $result.= '</nav><script>document.documentElement.classList.add("p2hHasQuickBar");</script>';
    if (!$rtrn) echo $result; else return $result;
}

# Help for the page: a "?" button (in the view bar) and a movable window with the help text of this page (from TinyCash)
function htm_PageHelp(# rtrn:false)
    $rtrn= false            # bool:   Return or echo result
) {
    # The texts: help_system.json (English) and help_system_<lang>.json, next to this library (or $gbl_HelpFile):
    #   { "Demo.page.php": ["<h3>Title</h3>", "<p>Text...</p>"], ... }   - one entry per page, HTML lines.
    #   A page without an entry gets a grey, disabled button. A missing translation shows the English text.
    global $lang;
    $page= basename($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? '');
    $file= $GLOBALS['gbl_HelpFile'] ?? (__DIR__.'/help_system.json');
    $read= function($f) use ($page) { if (!is_readable($f)) return null;  $d= json_decode((string)file_get_contents($f), true);
                                      return (is_array($d) && isset($d[$page]) && is_array($d[$page])) ? $d[$page] : null; };
    $code= preg_match('/^[a-z]{2}$/', (string)$lang) ? $lang : 'en';
    $lines= ($code!='en' ? $read(preg_replace('/\.json$/', '_'.$code.'.json', $file)) : null) ?? $read($file);
    $t= function($k) { return sys_enc(strip_tags(lang($k))); };
    if (!$lines) {
        $result= '<button type="button" class="p2hHelpButt" disabled title="'.$t('@No help text for this page').'"><ic class="fa-solid fa-circle-question"></ic></button>';
        if (!$rtrn) echo $result; else return $result;
        return;
    }
    $result= '<button type="button" class="p2hHelpButt" aria-haspopup="dialog" aria-controls="p2hHelpWin" title="'.$t('@Help for this page').'"><ic class="fa-solid fa-circle-question"></ic></button>'.
             '<div id="p2hHelpWin" class="p2hHelpWin" role="dialog" aria-labelledby="p2hHelpTtl" hidden>'.
                '<div class="p2hHelpHead" title="'.$t('@Drag to move').'"><ic class="fa-solid fa-circle-question" aria-hidden="true"></ic> '.
                    '<span id="p2hHelpTtl">'.$t('@Help').'</span>'.
                    '<button type="button" class="p2hHelpClose" aria-label="'.$t('@Close').'">&times;</button></div>'.
                '<div class="p2hHelpBody" tabindex="0">'.implode("\n", $lines).'</div>'.
                '<div class="p2hHelpFoot"><ic class="fa-solid fa-language" aria-hidden="true"></ic> '.$t('@Language').': '.strtoupper($code).'</div>'.
             '</div>';
    static $jsDone= false;
    if (!$jsDone) { $jsDone= true;  $result.= '<script>
(function(){    /* Open / close / move the help window (no external library) */
  var win= null, opener= null;
  function show(b) {
    win= document.getElementById("p2hHelpWin");  if (!win) return;
    if (win.parentNode !== document.documentElement) document.documentElement.appendChild(win);   /* Outside <body>: not scaled by the page zoom */
    opener= b;  win.hidden= false;  win.querySelector(".p2hHelpBody").focus();
  }
  function hide() { if (!win || win.hidden) return;  win.hidden= true;  if (opener) opener.focus(); }
  document.addEventListener("click", function(e) {
    var b= e.target.closest && e.target.closest(".p2hHelpButt");
    if (b && !b.disabled) { (win && !win.hidden) ? hide() : show(b);  return; }
    if (e.target.closest && e.target.closest(".p2hHelpClose")) hide();
  });
  document.addEventListener("keydown", function(e) { if (e.key==="Escape" && win && !win.hidden && win.contains(document.activeElement)) hide(); });
  document.addEventListener("pointerdown", function(e) {
    var h= e.target.closest && e.target.closest(".p2hHelpHead");  if (!h || e.target.closest(".p2hHelpClose") || e.button > 0) return;
    var w= h.parentNode, r= w.getBoundingClientRect(), dx= e.clientX - r.left, dy= e.clientY - r.top;
    e.preventDefault();  try { h.setPointerCapture(e.pointerId); } catch(err) {}
    function move(ev) {
      w.style.left= Math.max(0, Math.min(ev.clientX - dx, innerWidth  - w.offsetWidth))  + "px";
      w.style.top=  Math.max(0, Math.min(ev.clientY - dy, innerHeight - w.offsetHeight)) + "px";  w.style.right= "auto";
    }
    function up() { h.removeEventListener("pointermove", move);  h.removeEventListener("pointerup", up);  h.removeEventListener("pointercancel", up); }
    h.addEventListener("pointermove", move);  h.addEventListener("pointerup", up);  h.addEventListener("pointercancel", up);
  });
})();
</script>'; }
    if (!$rtrn) echo $result; else return $result;
}

# A small floating, movable toolbar: zoom out/in (click the % to reset), full screen and theme.
# Zoom and position are remembered in this browser. Drag the grip - double-click it (or Home) to put it back.
function htm_ViewBar(# rtrn:false)
    $rtrn= false            # bool:   Return or echo result
) {
    static $no= 0; $no++;  $id= 'p2hViewBar'.$no;
    $t= function($k) { return sys_enc(strip_tags(lang($k))); };
    $result= '<div id="'.$id.'" class="p2hViewBar" role="toolbar" aria-label="'.$t('@View').'">'.
             '<span class="p2hVbGrip" tabindex="0" role="button" title="'.$t('@Drag to move (or use the arrow keys). Double-click or Home: back to the corner').'">&#10303;</span>'.
             '<button type="button" data-vb="out"  title="'.$t('@Zoom out').'"><ic class="fa-solid fa-minus"></ic></button>'.
             '<button type="button" data-vb="reset" class="p2hVbZoom" title="'.$t('@Zoom: click to reset to 100%').'">100%</button>'.
             '<button type="button" data-vb="in"   title="'.$t('@Zoom in').'"><ic class="fa-solid fa-plus"></ic></button>'.
             '<span class="p2hVbSep"></span>'.
             '<button type="button" data-vb="full" title="'.$t('@Full screen on/off').'"><ic class="fa-solid fa-expand"></ic></button>'.
             '<button type="button" data-vb="cols" aria-pressed="false" title="'.$t('@Column view on/off').'"><ic class="fa-solid fa-table-columns"></ic></button>'.
             ((($GLOBALS['gbl_CardMove'] ?? 'icon') === 'toggle') ?                       # $gbl_CardMove= 'toggle': moving the cards is turned on here
                '<button type="button" data-vb="arrange" aria-pressed="false" title="'.$t('@Arrange cards on/off (drag the card headers)').'"><ic class="fa-solid fa-up-down-left-right"></ic></button>' : '').
             htm_LangSelect(rtrn:true).                                  # Language with flags ('' when only English)
             htm_NotePad(rtrn:true).                                     # My notes (saved in this browser)
             htm_PageHelp(rtrn:true).                                    # "?" - help for this page (grey when there is none)
             htm_ThemeButt(rtrn:true).
             '</div>';
    if ($no==1) $result.= '<script>
function p2hViewBar(bar) {
    document.documentElement.appendChild(bar);              /* Outside <body>: the page zoom does not scale the bar */
    var PK= "p2h-viewbar-pos", ZK= "p2h-zoom", grip= bar.querySelector(".p2hVbGrip"), out= bar.querySelector(".p2hVbZoom");
    var zoom= 1, pos= null;
    try { zoom= parseFloat(localStorage.getItem(ZK)) || 1;  pos= JSON.parse(localStorage.getItem(PK) || "null"); } catch(e) {}
    function store(k, v) { try { if (v===null) localStorage.removeItem(k); else localStorage.setItem(k, v); } catch(e) {} }
    function setZoom(z, save) {
        zoom= Math.round(Math.min(2, Math.max(0.5, z)) * 10) / 10;
        document.body.style.zoom= (zoom===1) ? "" : zoom;
        out.textContent= Math.round(zoom*100) + "%";
        if (save) store(ZK, zoom===1 ? null : String(zoom));
    }
    setZoom(zoom, false);
    var full= bar.querySelector("[data-vb=full]");
    if (!document.fullscreenEnabled) full.style.display= "none";
    document.addEventListener("fullscreenchange", function() {
        full.firstChild.className= "fa-solid " + (document.fullscreenElement ? "fa-compress" : "fa-expand"); });
    bar.addEventListener("click", function(e) {
        var b= e.target.closest("[data-vb]"); if (!b) return;
        var a= b.getAttribute("data-vb");
        if (a==="in") setZoom(zoom + 0.1, true); else if (a==="out") setZoom(zoom - 0.1, true); else if (a==="reset") setZoom(1, true);
        else if (a==="full") { if (!document.fullscreenElement) document.documentElement.requestFullscreen().catch(function(){}); else document.exitFullscreen(); }
        else if (a==="cols") p2hColView(null, true);
        else if (a==="arrange") p2hCardMove.arrange(null, true);
    });
    function place(x, y) {                                  /* Keep the bar inside the window */
        x= Math.round(Math.max(0, Math.min(x, innerWidth  - bar.offsetWidth)));
        y= Math.round(Math.max(0, Math.min(y, innerHeight - bar.offsetHeight)));
        bar.style.left= x+"px";  bar.style.top= y+"px";  bar.style.right= "auto";
        return {x:x, y:y};
    }
    function home() { bar.style.left= bar.style.top= bar.style.right= "";  pos= null;  store(PK, null); }
    function save(p) { pos= p;  store(PK, JSON.stringify(p)); }
    if (pos) place(pos.x, pos.y);
    grip.addEventListener("pointerdown", function(e) {
        if (e.button > 0) return;
        e.preventDefault();
        var r= bar.getBoundingClientRect(), dx= e.clientX - r.left, dy= e.clientY - r.top, p= null;
        try { grip.setPointerCapture(e.pointerId); } catch(err) {}
        grip.classList.add("dragging");
        function move(ev) { p= place(ev.clientX - dx, ev.clientY - dy); }
        function stop() { grip.removeEventListener("pointermove", move); grip.removeEventListener("pointerup", stop);
                          grip.removeEventListener("pointercancel", stop); grip.classList.remove("dragging"); if (p) save(p); }
        grip.addEventListener("pointermove", move); grip.addEventListener("pointerup", stop); grip.addEventListener("pointercancel", stop);
    });
    grip.addEventListener("dblclick", home);
    grip.addEventListener("keydown", function(e) {
        if (e.key==="Home") { e.preventDefault(); home(); return; }
        var st= {ArrowLeft:[-1,0], ArrowRight:[1,0], ArrowUp:[0,-1], ArrowDown:[0,1]}[e.key];
        if (!st) return;
        e.preventDefault();
        var r= bar.getBoundingClientRect(), n= e.shiftKey ? 50 : 10;
        save(place(r.left + st[0]*n, r.top + st[1]*n));
    });
    addEventListener("resize", function() { if (pos) place(pos.x, pos.y); });
    p2hColView(null, false);                                /* Show the saved column choice on the button */
}
/* Column view: on/off (toggle) - the button shows the state. Unusually tall cards may break between columns (see p2hColBreaks). */
function p2hColView(on, toggle) {
    var c= document.querySelector("[data-p2h-cols]");  if (!c) return;
    if (toggle) { on= !c.classList.contains("p2hColview");  try { localStorage.setItem("p2h-colview", on ? "1" : "0"); } catch(e) {} }
    else if (on===null) on= c.classList.contains("p2hColview");
    c.classList.toggle("p2hColview", on);
    document.querySelectorAll("[data-vb=cols]").forEach(function(b) { b.setAttribute("aria-pressed", on ? "true" : "false"); });
    p2hColBreaks(c);
}
/* As in NH-logistik: a card is kept in one piece (break-inside: avoid) - but a card much higher than the window may break,
   else it takes a whole column alone. Hysteresis (1.5x in, 1.3x out) and a short debounce stop it from flipping back and forth.
   A card with a table never breaks: the browser does not repeat the table header in the next column. */
var p2hColState= new WeakMap(), p2hColTimer= null, p2hColObs= null;
function p2hColBreaks(c) {
    function now() {
        var on= c.classList.contains("p2hColview"), inLim= innerHeight * 1.5, outLim= innerHeight * 1.3;
        [].forEach.call(c.children, function(card) {
            if (!/^card\d+$/.test(card.id)) return;
            var was= p2hColState.get(card) === true;
            var isAuto= on && !card.querySelector("table") && (was ? card.offsetHeight > outLim : card.offsetHeight > inLim);
            if (isAuto !== was) { p2hColState.set(card, isAuto);  card.style.breakInside= isAuto ? "auto" : ""; }
        });
    }
    clearTimeout(p2hColTimer);  p2hColTimer= setTimeout(now, 150);
    if (!p2hColObs && window.ResizeObserver) {
        p2hColObs= new ResizeObserver(function() { clearTimeout(p2hColTimer); p2hColTimer= setTimeout(now, 150); });
        [].forEach.call(c.children, function(card) { if (/^card\d+$/.test(card.id)) p2hColObs.observe(card); });
    }
}
</script>';
    $result.= '<script>p2hViewBar(document.getElementById("'.$id.'"));</script>';
    if (!$rtrn) echo $result; else return $result;
}


# Editor for the user's own theme: pick a few base colors, see the result live, save it in this browser.
function htm_ThemeEditor(# rtrn:false)
    $rtrn= false            # bool:   Return or echo result
) {
    static $no= 0; $no++;  $id= 'p2hThemeEd'.$no;
    $fields= ['page'=>'@Page background', 'card'=>'@Card background', 'text'=>'@Text', 'input'=>'@Input fields', 'accent'=>'@Accent (titles and buttons)'];
    $result= '<div id="'.$id.'"><div class="p2hThemeEd">'.
             '<span>'.lang('@Start from').'</span><select data-k="base"><option value="light">'.lang('@Light').'</option><option value="dark">'.lang('@Dark').'</option></select>';
    foreach ($fields as $k=>$labl)
        $result.= '<span>'.lang($labl).'</span><input type="color" data-k="'.$k.'" />';
    $result.= '</div><div class="p2hThemeEdButt">'.
              '<button type="button" data-act="save">'.lang('@Use my theme').'</button>'.
              '<button type="button" data-act="reset">'.lang('@Reset').'</button></div></div>'.
    '<script>(function(){
        var box= document.getElementById("'.$id.'");
        function read() { var c= {}; box.querySelectorAll("[data-k]").forEach(function(e){ c[e.dataset.k]= e.value; }); return c; }
        function fill(c) { box.querySelectorAll("[data-k]").forEach(function(e){ e.value= c[e.dataset.k]; }); }
        fill(p2hGetCustom());
        box.querySelectorAll("input[data-k]").forEach(function(e){ e.addEventListener("input", function(){ p2hApplyTheme("custom", read()); }); });
        box.querySelector("select").addEventListener("change", function(){ fill(P2H_CDEF[this.value]); p2hApplyTheme("custom", read()); });
        box.querySelector("[data-act=save]").addEventListener("click", function(){ p2hSaveCustom(read()); });
        box.querySelector("[data-act=reset]").addEventListener("click", function(){
            try { localStorage.removeItem("p2h-theme-custom"); } catch(e) {}
            fill(P2H_CDEF.light); p2hSetTheme("light"); });
    })();</script>';
    if (!$rtrn) echo $result; else return $result;
}


# Is a switch value "on"? Accepts 1/true/on/yes/checked/pressed (and the old spelling "presssed")
function sys_switchIsOn($valu) {
    if ($valu === true) return true;
    return in_array(strtolower(trim((string)$valu)), ['1','true','on','yes','checked','pressed','presssed'], true);
}

# A button with switch layout
function htm_SwitchButt(# labl:'', hint:'', name:'switchbox_id', valu:'', list:[], wdth:'', bclr:'', rtrn:false) 
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
{   global $gbl_progZoom;
    $yes = lang($list[0] ?? '@Yes');
    $no  = lang($list[1] ?? '@No');
    if ($wdth=='') $strWd= (max(mb_strlen($yes),mb_strlen($no))+2).'ch';
    else           $strWd= $wdth;
    $on  = sys_switchIsOn($valu);
    $id  = 'id_'.sys_enc($name);
    # Self-contained toggle: no external JS needed. The hidden input carries the state (1/0) in the form POST.
    $result = '
        <'.$gbl_progZoom.'>
        <abbr class="hint">
            <button type="button" role="switch" class="switchbox'.($on ? ' is-pressed' : '').'" aria-checked="'.($on ? 'true' : 'false').'"
                style="width:'.$strWd.'; --sw-width: '.$strWd.'; '.($bclr>'' ? '--themeColr: '.$bclr.'; ' : '').'"
                id="'.$id.'"
                onclick="var on= this.classList.toggle(\'is-pressed\'); this.setAttribute(\'aria-checked\', on); this.nextElementSibling.value= on ? \'1\' : \'0\';">
                <span class="switchbox-yes">'.$yes.'</span>
                <span class="switchbox-no" >'.$no.'</span>
            </button><input type="hidden" name="'.sys_enc($name).'" value="'.($on ? '1' : '0').'" />
        <label for="'.$id.'">'.lang($labl).'</label>
        ';
    $result.= '<data-hint>'.lang($hint).'</data-hint>
        </abbr>
        </'.$gbl_progZoom.'>';
    if (!$rtrn) echo $result; else return $result;
} # htm_SwitchButt()

# Another button with switch layout
function htm_SwitchButton(# labl, name:'switchbox_id', valu:'', wdth:'', bclr:'', styl:'', hint:'', list:[], rtrn:false) 
    $labl,                  # string: Button label
    $name='switchbox_id',   # string: 
    $valu='',               # string: 
    $wdth='',               # string: Width
    $bclr='',               # string: 
    $styl='',               # string: 
    $hint='',               # string: Hint about the button function
    $list=[],               # string: 
    $rtrn=false             # bool:   Act as procedure: Echo result, or as function: Return string
)
{   static $styleDone= false;   # The CSS is only needed once per page
    $css= '';
    if (!$styleDone) { $styleDone= true; $css= '
        <style>
        .switch { position: relative; display: inline-block; min-width: 3em; height: 1em; padding: .125em;
            overflow: hidden; box-sizing: content-box; border: 2px solid darkgrey; border-radius: .75em;
            background-color: white; font-size: 1.25em; vertical-align: middle; cursor: pointer; transition: .15s ease-out; }
        .switch input { position: absolute; opacity: 0; width: 0; height: 0; }
        .switch .slider { position: absolute; inset: 0; transition: .2s; }
        .switch .slider:before { position: absolute; content: ""; z-index: 2; width: 1em; height: 1em; left: .125em; top: .125em;
            border-radius: 50%; background-color: darkgrey; transition: .2s; }
        .switch .sw-yes, .switch .sw-no { position: absolute; top: 50%; z-index: 1; transform: translateY(-50%);
            font-size: .7em; pointer-events: none; transition: .15s; white-space: nowrap; }
        .switch .sw-yes { left: .7em;  color: white; font-weight: bold; opacity: 0; }
        .switch .sw-no  { right: .7em; color: #5f5f5f; opacity: 1; }   /* (darkgrey on white was 2.4:1) */
        .switch input:checked ~ .slider { background-color: var(--themeColr); }
        .switch input:checked ~ .slider:before { background-color: white; transform: translateX(calc(var(--sw-width) - 1em)); }
        .switch input:checked ~ .sw-yes { opacity: 1; }
        .switch input:checked ~ .sw-no  { opacity: 0; }
        .switch:hover, .switch:focus-within { border-color: var(--themeColr); box-shadow: 0 0 .25em var(--themeColr); }
        </style>';
    }
    $yes = lang($list[0] ?? '@Yes');
    $no  = lang($list[1] ?? '@No');
    if ($wdth=='') $strWd= (max(mb_strlen($yes),mb_strlen($no))+2).'ch';
    else           $strWd= $wdth;
    $on  = sys_switchIsOn($valu);
    $nm  = sys_enc($name);
    # The hidden 0 is sent when the box is unchecked (unchecked checkboxes are not included in $_POST)
    $result= $css.'
        <abbr class="hint">
            <small style="vertical-align:middle;">
            <label class="switch" style="width:'.$strWd.'; --sw-width: '.$strWd.'; '.($bclr>'' ? '--themeColr: '.$bclr.'; ' : '').'">
                <input type="hidden" name="'.$nm.'" value="0" />
                <input type="checkbox" role="switch" id="id_'.$nm.'" name="'.$nm.'" value="1"'.($on ? ' checked' : '').' />
                <span class="slider round"></span>
                <span class="sw-yes">'.$yes.'</span>
                <span class="sw-no">'.$no.'</span>
            </label>
            '.lang($labl).'
            </small>
            <data-hint>'.lang($hint).'</data-hint>
        </abbr>
    ';
    if (!$rtrn) echo $result; else return $result;
} # htm_SwitchButton()

# A special button to switch between many states
function htm_MultistateButt(# name:'ROWyCOLx', valu:'', acti:true, styl:'padding:1px;') 
    $name='ROWyCOLx',       # string: 
    $valu='',               # string: 
    $acti=true,             # bool:   
    $styl='padding:1px;'    # string: 
    )
{   $Bicon= ['<i class="far fa-square colrgray"          style="'.$styl.'" ></i>',
             '<i class="far fa-minus-square colrred"     style="'.$styl.'" ></i>',
             '<i class="far fa-check-square colrorange"  style="'.$styl.'" ></i>',
             '<i class="far fa-plus-square colrgreen"    style="'.$styl.'" ></i>'
           ];
    $valu= max(0, min(3, (int)$valu));                  # State 0..3 ('' = 0)
    $result= '<p style="display: inline; width: 28px; height: 28px;"'.($acti==true ? ' id="'.$name.'"' : '');      # (A legend has no id)
    if ($acti==true)
        $result.= ' role="button" tabindex="0" aria-label="'.sys_enc($name).': '.$valu.'" onclick="changeBoxValues(this)" ';
    $result.= '>'.$Bicon[$valu].'</p>';
    if ($acti==true) $result.= '<input type="hidden" name="'.$name.'" value="'. $valu.  '">';                  # Only a real button sends its state
    static $jsDone= false;                              # The functions are the same for all buttons - write them once
    if (($acti==true) and !$jsDone) { $jsDone= true;
        $result.= "<script>
            function changeBoxValues(mButt) {
            var hidden = document.querySelector('[name=\"' + mButt.id + '\"]');
                if      (hidden.value == 0)   { hidden.value = 1; }
                else if (hidden.value == 1)   { hidden.value = 2; }
                else if (hidden.value == 2)   { hidden.value = 3; }
                else                          { hidden.value = 0; }
                setCheckBoxes(mButt, hidden.value);
                mButt.setAttribute('aria-label', mButt.id + ': ' + hidden.value);      // The new state for screen readers
            }
            function setCheckBoxes(mButt, value) {
                if      (value == 0) { mButt.classList.add(                 'colrgray');   mButt.innerHTML = '<p>".$Bicon[0]."</p>'; }
                else if (value == 1) { mButt.classList.replace('colrgray'  ,'colrred');    mButt.innerHTML = '<p>".$Bicon[1]."</p>'; }
                else if (value == 2) { mButt.classList.replace('colrred'   ,'colrorange'); mButt.innerHTML = '<p>".$Bicon[2]."</p>'; }
                else                 { mButt.classList.replace('colrorange','colrgreen');  mButt.innerHTML = '<p>".$Bicon[3]."</p>'; }
            }
        </script>";
    }
    return $result;
}
 
# Button for test human or robot
function htm_Humantest(# capt:'@Are you human? ', icon:'fa-solid fa-arrow-right-to-bracket', hint:'@Grab and slide to right to change state', 
                       # form:'form-id', wdth:'200px', hght:'24px', yclr:'lightgray', nclr:'white', bclr: '#1bd441', xytx:'@YES', ntxt:'@NO',rtrn: false);
$capt= '@Are you human? ',                          # string: capt $quest= '@Are you human?',
$icon= 'fa-solid fa-arrow-right-to-bracket',        # string: icon after caption
$hint= '@Grab and slide to right to change state',  # string: hint $slide_hint= '@Grab and slide to right to change state'
$form= 'form-id',                                   # string: form $form_id= 'form-id',
$wdth= '200px',                                     # string: wdth $grab_width= '200px',
$hght= '24px',                                      # string: hght $grab_height= '24px',
$yclr= 'lightgray',                                 # string: yclr $yclr= 'lightgray',
$nclr= 'white',                                     # string: nclr $no_colr= 'white',
$bclr= '#1bd441',                                   # string: background in human state
$xytx= '@YES',                                      # string: xytx $yes_text= '@YES',
$ntxt= '@NO',                                       # string: ntxt $no_text= '@NO',
$rtrn= false                                        # bool: Act as procedure: Echo result, or as function: Return string
) 
{
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
    color: #111;                                    /* Dark text on the white slider - also in the dark theme */
    border-color: white;
    box-shadow: 0 0 5px gray;
  }

  .grab-slider > abbr.hint { color: #111 !important; }
  .grab-slider-wrapper.human {
    background-color: '.$bclr.';
    border-color: '.$bclr.';
    box-shadow: none;
  }
</style>
'; 

// https://codepen.io/aratour/pen/xxbwLMz :
if (!empty($GLOBALS['gbl_CardForm'])) $form= '';     # Inside a card form: no form of its own (forms cannot be nested) - the card form is checked
if ($form>'') $result.= ' <form name="'.sys_enc($form).'" id="'.sys_enc($form).'">';
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
            <input type="hidden" name="p2h_human" value="isbot">
        </div>';
if ($form>'') $result.= ' </form>';

static $hmJs= false;                                # The script handles all sliders on the page - write it once
if (!$hmJs) { $hmJs= true;
$result.= '
<script>
(function(){    /* Drag with mouse, finger or pen (pointer events). Each slider works on its own. */
  function init(wrapper) {
    var slider= wrapper.children[0], input= wrapper.parentNode.querySelector("input[name=p2h_human]");
    if (!slider || !input || wrapper.dataset.p2hInit) return;  wrapper.dataset.p2hInit= "1";
    slider.style.touchAction= "none";
    slider.addEventListener("pointerdown", function(e) {
      var startX= e.clientX - slider.offsetLeft, maxleft= wrapper.clientWidth - slider.offsetWidth;
      try { slider.setPointerCapture(e.pointerId); } catch(err) {}
      function move(ev) {
        var left= Math.max(0, Math.min(maxleft, ev.clientX - startX)), ok= (left >= maxleft - 1);
        slider.style.left= left + "px";
        wrapper.classList.toggle("human", ok);
        input.value= ok ? "notbot" : "isbot";
      }
      function up() { slider.removeEventListener("pointermove", move); slider.removeEventListener("pointerup", up); slider.removeEventListener("pointercancel", up); }
      slider.addEventListener("pointermove", move);  slider.addEventListener("pointerup", up);  slider.addEventListener("pointercancel", up);
    });
  }
  function go() { document.querySelectorAll(".grab-slider-wrapper").forEach(init); }
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", go); else go();
  /* Stop every form that contains an unsolved slider - also the form around it (e.g. the login form) */
  document.addEventListener("submit", function(e) {
    var inps= e.target.querySelectorAll ? e.target.querySelectorAll("input[name=p2h_human]") : [];
    for (var i= 0; i < inps.length; i++) if (inps[i].value !== "notbot") {
      e.preventDefault();  sysAlert('.json_encode(lang('@Please complete the captcha')).');  return;
    }
  }, true);
})();
</script>';
}
    if (!$rtrn) echo $result; else return $result;
} # htm_Humantest

# Start a tab-object with multibly tabs
function htm_Tabs_(# head:'', styl:'', rtrn:false)
    $head='',
    $styl='', 
    $rtrn=false
)
{   $GLOBALS['TabLabl']='<div class="tab">';
    $GLOBALS['TabBody']='';
    $GLOBALS['TabDflt']='';
    $result= '
        <span style="'.$styl.'">'. 
            $head.
        '</span>';
   if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}

# Create a tab in the htm_Tabs_() object [Necessary basic element]
function htm_Tab(# labl:'', body:'', name:'', styl:'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;', bclr:'white')
    $labl='',       # string: Tab Label
    $body='',       # string: Content on tab
    $name='',       # string: id
    $styl=          # string: Style
          'text-align: left; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; background-color: white;',
    $bclr='white',  # string: Background color
    $vhgh='',       # string: ViewHeight (future !)
    $dflt=false     # boolean: Open as default
    ) 
{   $b= 'small'; 
    $GLOBALS['TabLabl'].= '
        <button class="tablinks" type="button" id="tab_'.$name.'" title="'.lang('@Show this Tab-content').'" 
        onclick="openTab(event, \''.$name.'\')" 
        style="background-color:'.$bclr.';border-bottom-color: '.$bclr.'; "><'.$b.'>'.lang($labl).'</'.$b.'></button>';
        if ($dflt==true) $GLOBALS['TabDflt']= $name;          # Opened when the page has loaded (see htm_Tabs_end)
       
    $GLOBALS['TabBody'].= '
        <div id="'.$name.'" class="tabcontent" style="display: none; background-color:'.$bclr.'; '.
            $styl.' border-right: 2px solid #aaa;">'. lang($body).
       '</div>';
}

# Finalize a htm_Tabs_() object
function htm_Tabs_end(# foot:'', styl:'', rtrn:false)
    $foot='', 
    $styl='', 
    $rtrn=false
    ) 
{   $result=
        $GLOBALS['TabLabl'].'<span style="float:right;" title="'.lang('@Hide the Tab-content').
                            '" role="button" tabindex="0" aria-label="'.lang('@Hide the Tab-content').'" onclick="closeTabs()"><i class="far fa-window-close"></i>&nbsp;</span> </div>'.
        $GLOBALS['TabBody'];
        if ($foot>'') $result.= '<span style="'.$styl.'">'.lang($foot).'</span>';
        $result.= '<hr style="border-top: 2px solid #aaa; margin-top: 0;">';
        if (($GLOBALS['TabDflt'] ?? '')>'')                 # The default tab: open it like a click (openTab() is defined at the page end)
            $result.= '<script>document.addEventListener("DOMContentLoaded", function(){ var b= document.getElementById('.
                      json_encode('tab_'.$GLOBALS['TabDflt']).'); if (b) b.click(); });</script>';
    if (!$rtrn) echo $result; else return $result; // str_replace('"','\'',$result); 
}

# A general link-button
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

# Create a HTML-textarea with multibly lines
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
    $result= '<textarea rows="'.sys_enc($rows).'" id="'.sys_enc($name).'" name="'.sys_enc($name).'"'.($form>'' ? ' form="'.sys_enc($form).'"' : '').
        ' placeholder="'.sys_enc(lang($plho)).'" style="width:'.$widt.'; font-size: 1em; border: 1px solid Gainsboro; border-radius: 4px; margin-top: 10px; '.$attr.'">'.
        sys_enc((string)$valu).'</textarea>';
    if ($hint > '')
        $result.= '<abbr class="hint">'. lang($labl).'<data-hint>'.lang($hint).'</data-hint></abbr>';
    else
        $result.= lang($labl);   # (was: lang($labl).$result - which output the textarea twice)
    if (!$rtrn) echo $result; else return $result;
}

# Create a text with hidden hint/title
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


// echo $htm_ModalDialog; Initiated in htm_Page_ ($htm_ModalDialog)
# Create a modal popup window with color-coded background
function htm_ModalDialog(# type:'none', capt:'@Voilà!', mess:'', butt:['type:','icon:','labl:','hint:','link:'], html:'CSS-based Modal Dialog', rtrn:true) 
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
    foreach ($butt as $ix => $bt) {                     // A button may be given as 'clos' or ['clos', ...] - and the type with a @ prefix
        if (!is_array($bt)) $bt= [$bt];
        $bt[0]= ltrim((string)($bt[0] ?? ''), '@');
        $butt[$ix]= $bt;
    }
    static $mNo= 0;  $mNo++;  $mId= 'open-modal_'.$mNo;   // Unique id per dialog - the link must point to the same id
    
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
    $result = '<div> <a href="#'.$mId.'">'.$html.'</a> </div>
        <div id="'.$mId.'" class="modal-window" >
            <div style="border: 4px solid '.$css_Box[$type][0].';">';
                if (in_array_r('clos',$butt))
                    $result.= '<a href="#" title="Close" class="modal-close"><i class="fas fa-times"></i>&nbsp;Close</a>';
                $result.=  '
                <h3  class="mdlHeader" style="background-color: '.$css_Box[$type][1].'; font-weight:600;">'.lang($capt).'</h3>
                <div class="mdlMessage">'.
                    lang($mess). /* ' A CSS-only modal, based on the :target pseudo-class. Hope you find it helpful.<br>  */ '
                </div>
                <div class="mdlFooter">';
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
                    default: $key='none'; $result.=  '<a href="#" title="Confirm'.
                                            '" style="background-color: '.$css_Box[$key][1].';" class="btnlabl">'.
                                            $css_Box[$key][3].'&nbsp;'.$css_Box[$key][2].'</a>';
                } $result.=  '&nbsp;'; }
                $result.=  '
                </div>
            </div>
        </div>';
    if (!$rtrn) echo $result; else return $result;
} // htm_ModalDialog

# A message box in the page: success / error / warning / info - theme colors, also in the dark theme (from NH-logistik)
function htm_Alert(# body:'', kind:'success', wdth:'700px', rtrn:false)
    $body= '',              # string: The message (HTML allowed, translated with lang())
    $kind= 'success',       # string: success / error / warning / info
    $wdth= '700px',         # string: Max width
    $rtrn= false            # bool:   Return or echo result
) {
    if ($body=='') return '';
    $kind= in_array($kind, ['success','error','warning','info'], true) ? $kind : 'success';
    $icon= ['success'=>'fa-circle-check', 'error'=>'fa-circle-exclamation', 'warning'=>'fa-triangle-exclamation', 'info'=>'fa-circle-info'][$kind];
    $result= '<div class="p2hAlert p2hAlert-'.$kind.'" role="'.(in_array($kind, ['error','warning']) ? 'alert' : 'status').'" style="max-width:'.sys_enc($wdth).';">'.
             '<ic class="fa-solid '.$icon.'" aria-hidden="true"></ic> '.lang($body).'</div>';
    if (!$rtrn) echo $result; else return $result;
}

# A banner across the page: a short notice with a colored edge, e.g. "Demo data" or "Read only" (from NH-logistik)
function htm_Banner(# body:'', kind:'warning', rtrn:false)
    $body= '',              # string: The text (HTML allowed, translated with lang())
    $kind= 'warning',       # string: info / warning / danger / success
    $rtrn= false            # bool:   Return or echo result
) {
    if ($body=='') return '';
    $kind= in_array($kind, ['info','warning','danger','success'], true) ? $kind : 'warning';
    $result= '<div class="p2hBanner p2hBanner-'.$kind.'" role="note">'.lang($body).'</div>';
    if (!$rtrn) echo $result; else return $result;
}

# A small label: a status, a count or "New" - e.g. in tables and menus (from NH-logistik)
function htm_Badge(# labl:'', kind:'secondary', hint:'', rtrn:false)
    $labl= '',              # string: The text (translated with lang())
    $kind= 'secondary',     # string: primary / secondary / success / danger / warning / info
    $hint= '',              # string: Tooltip
    $rtrn= false            # bool:   Return or echo result (rtrn:true to use it inside other output)
) {
    $kind= in_array($kind, ['primary','secondary','success','danger','warning','info'], true) ? $kind : 'secondary';
    $result= '<span class="p2hBadge p2hBadge-'.$kind.'"'.($hint>'' ? ' title="'.sys_enc(strip_tags(lang($hint))).'"' : '').'>'.lang($labl).'</span>';
    if (!$rtrn) echo $result; else return $result;
}

# A button for an action that changes data (e.g. Delete): asks "Are you sure?" and then POSTs with the CSRF token (from NH-logistik)
function htm_ConfirmPostLink(# labl:'', icon:'', hint:'', acti:'', data:[], mess:'@Are you sure?', kind:'danger', rtrn:false)
    $labl= '',              # string: Button text
    $icon= '',              # string: Icon class, e.g. 'fa-solid fa-trash'
    $hint= '',              # string: Tooltip
    $acti= '',              # string: Where to POST ('' = this page)
    $data= [],              # array:  The fields to send: ['name' => 'value', ...]
    $mess= '@Are you sure?',# string: The question
    $kind= 'danger',        # string: primary / secondary / success / danger / warning / info (button color)
    $rtrn= false            # bool:   Return or echo result
) {
    # The form is built when confirmed (in JS) - so the button also works inside a card that is a form (forms cannot be nested)
    $kind= in_array($kind, ['primary','secondary','success','danger','warning','info'], true) ? $kind : 'danger';
    $result= '<button type="button" class="p2hConfirmPost p2hBadge-'.$kind.'"'.($hint>'' ? ' title="'.sys_enc(strip_tags(lang($hint))).'"' : '').
             ' data-acti="'.sys_enc($acti).'" data-fields="'.sys_enc(json_encode((object)$data)).'" data-mess="'.sys_enc(strip_tags(lang($mess))).'"'.
             ' data-csrf="'.sys_enc($_SESSION['csrf_token'] ?? '').'">'.
             ($icon>'' ? '<ic class="'.sys_enc($icon).'" aria-hidden="true"></ic> ' : '').lang($labl).'</button>';
    static $jsDone= false;
    if (!$jsDone) { $jsDone= true;  $result.= '<script>
document.addEventListener("click", function(e) {
    var b= e.target.closest && e.target.closest(".p2hConfirmPost");  if (!b) return;
    sysConfirm(b.dataset.mess, function() {
        var f= document.createElement("form");  f.method= "post";  f.action= b.dataset.acti || location.href;  f.style.display= "none";
        var v= JSON.parse(b.dataset.fields || "{}");  v.csrf_token= b.dataset.csrf;
        Object.keys(v).forEach(function(k) { var i= document.createElement("input"); i.type= "hidden"; i.name= k; i.value= v[k]; f.appendChild(i); });
        document.body.appendChild(f);  f.submit();
    });
});
</script>'; }
    if (!$rtrn) echo $result; else return $result;
}

# Search and sort for a table - without jQuery: a search field with "x of y rows", and sorting by clicking a column header (from NH-logistik)
function htm_TableTools(# tabl:'', srch:true, sort:true, plho:'@Search...', rtrn:false)
    $tabl= '',              # string: id of the table ('' = the next table on the page, e.g. the htm_Table() that follows)
    $srch= true,            # bool:   Show the search field
    $sort= true,            # bool:   Sort by clicking a header (only when Tablesorter is not active on the table - it sorts itself)
    $plho= '@Search...',    # string: Placeholder in the search field
    $rtrn= false            # bool:   Return or echo result
) {
    $result= '<div class="p2hTableTools" data-tabl="'.sys_enc($tabl).'" data-sort="'.($sort ? '1' : '0').'"'.
             ' data-tmpl="'.sys_enc(lang('@%1 of %2 rows shown')).'" data-dsep="'.sys_enc(DecimalSep).'" data-tsep="'.sys_enc(ThousandsSep).'">'.
             ($srch ? '<label class="p2hTtSearch"><ic class="fa-solid fa-magnifying-glass" aria-hidden="true"></ic>'.
                      '<input type="search" placeholder="'.sys_enc(strip_tags(lang($plho))).'" aria-label="'.sys_enc(strip_tags(lang('@Search in the table'))).'" /></label>'.
                      ' <span class="p2hTtCount" aria-live="polite"></span>' : '').'</div>';
    static $jsDone= false;
    if (!$jsDone) { $jsDone= true;  $result.= '<script>
(function(){
  function cellVal(td) {     /* The shown value: the field in the cell (table cells may hold input fields) or the text */
    if (!td) return "";
    var i= td.querySelector("input:not([type=hidden]),select,textarea");
    return (i ? (i.type==="checkbox" ? (i.checked ? "1" : "0") : i.value) : td.textContent).trim();
  }
  function sortKey(t, ds, ts) {   /* Numbers in the number format of the program (DecimalSep / ThousandsSep), dd.mm.yyyy dates - else the text */
    var s= t.replace(/[\s\u00a0\u202f%]/g, "");
    if (ts && ts.trim()) s= s.split(ts).join("");                                   /* Thousands separator */
    if (ds && ds !== ".") { if (s.indexOf(ds) > -1) s= s.split(".").join("").replace(ds, "."); }   /* 1.234,50 */  else s= s.replace(/,/g, "");
    if (/^-?\d+(\.\d+)?$/.test(s) && !/^\d{1,2}\.\d{1,2}\.\d{4}/.test(t.trim())) return parseFloat(s);
    var d= t.match(/^(\d{1,2})\.(\d{1,2})\.(\d{4})/);  if (d) return new Date(+d[3], d[2]-1, +d[1]).getTime();
    return t.toLowerCase();
  }
  function cmp(a, b) { if (typeof a !== typeof b) return typeof a === "number" ? -1 : 1;  return a < b ? -1 : (a > b ? 1 : 0); }
  function nextTable(el) { var ts= document.querySelectorAll("table"); for (var i= 0; i < ts.length; i++) if (el.compareDocumentPosition(ts[i]) & 4) return ts[i]; return null; }
  function setup(tools) {
    var t= tools.dataset.tabl ? document.getElementById(tools.dataset.tabl) : nextTable(tools);
    if (!t || !t.tBodies[0]) return;
    var body= t.tBodies[0], inp= tools.querySelector("input"), cnt= tools.querySelector(".p2hTtCount");
    function count(shown) { if (cnt) { var n= 0; cnt.textContent= tools.dataset.tmpl.replace(/%[12]/g, function(m) { return m==="%1" ? shown : body.rows.length; }); } }
    if (inp) inp.addEventListener("input", function() {
      var q= inp.value.toLowerCase(), shown= 0;
      [].forEach.call(body.rows, function(r) {
        var hit= !q || [].some.call(r.cells, function(c) { return cellVal(c).toLowerCase().indexOf(q) > -1; });
        r.style.display= hit ? "" : "none";  if (hit) shown++;
      });
      count(shown);
      if (window.jQuery && t.config) jQuery(t).trigger("applyWidgets");      /* Tablesorter: zebra again */
    });
    count(body.rows.length);
    if (tools.dataset.sort !== "1" || t.config || !t.tHead) return;          /* Tablesorter sorts itself */
    var head= t.tHead.rows[t.tHead.rows.length - 1];
    [].forEach.call(head.cells, function(th, ci) {
      th.setAttribute("role", "button");  th.tabIndex= 0;  th.classList.add("p2hTtSort");
      th.addEventListener("click", function() {
        var asc= th.getAttribute("aria-sort") !== "ascending";
        [].forEach.call(head.cells, function(h) { h.removeAttribute("aria-sort"); });
        th.setAttribute("aria-sort", asc ? "ascending" : "descending");
        var rows= [].slice.call(body.rows).map(function(r) { return [sortKey(cellVal(r.cells[ci]), tools.dataset.dsep, tools.dataset.tsep), r]; });
        rows.sort(function(a, b) { return asc ? cmp(a[0], b[0]) : cmp(b[0], a[0]); });
        rows.forEach(function(x) { body.appendChild(x[1]); });
      });
    });
  }
  function go() { document.querySelectorAll(".p2hTableTools").forEach(setup); }
  if (document.readyState === "complete") go(); else addEventListener("load", go);   /* After Tablesorter has started (it sets t.config) */
})();
</script>'; }
    if (!$rtrn) echo $result; else return $result;
}

# Create a Dialog with alternative buttons to select between [Necessary basic element]
function htm_Dialog(# capt:'CAPTION', body:'', bclr:'lightyellow', butt:[], labl:'@Open dialog', rtrn:false) # Modal dialog:
    $capt='CAPTION',
    $body='',
    $bclr='lightyellow', # Background color
    $butt= [ ['confirmBtn','default','@Confirm','fas fa-check','green','@Accept and go on'],   // (0:id, 1:value, 2:label, 3:icon, 4:color, 5:hint)
                ['',          'cancel', '@Cancel', 'fas fa-minus-circle','red','@Break and return']
              ],
    $labl='@Open dialog',   # string: Label of the button that opens the dialog ('' = no button; open it with: document.getElementById("htmDialog1").showModal())
    $rtrn=false             # bool:   Return or echo result
)  // https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog
{   static $dlgNo= 0;  $dlgNo++;  $dId= 'htmDialog'.$dlgNo;   # Unique ids - several dialogs on one page
    $result= '<dialog id="'.$dId.'" style="padding:5px; background-color:lightcyan; border-radius: 6px;">
        <form  name="yyy" method="dialog">
            <div style="background-color:'.$bclr.'; padding:4px;">'.lang($capt).'</div>
            <p>'.lang($body).'</p>'.   //  <p><label>Favorite animal: <select> <option></option> <option>Brine shrimp</option> <option>Red panda</option> <option>Spider monkey</option> </select> </label></p>
            '<menu style="padding-inline-start: 40px; padding-inline-end: 40px;">'; 
                foreach ($butt as $butn) {
                $iconClass= $butn[3];
                // if ($iconClass === '') $icon=''; else 
                $icon= '<ic class="'.$butn[3].'" style="font-size: 16px; color: '.$butn[4].';"></ic>&nbsp;';
                $result.= '<button'.($butn[0]>'' ? ' id="'.$dId.'_'.$butn[0].'"' : '').' value="'.$butn[1].'" title="'.lang($butn[5] ?? '').'" style="padding: 3px 5px;">'.$icon.lang($butn[2]).'</button>&nbsp;';
                }
    $result.= '</menu>
        </form>
        </dialog>
        '.($labl>'' ? '<button type="button" onclick="document.getElementById(\''.$dId.'\').showModal()" style="padding: 3px 8px;">'.lang($labl).'</button>' : '').'
        <output id="'.$dId.'_out" aria-live="polite"></output>
        <script>
        (function(){
            var dlg= document.getElementById("'.$dId.'"), sel= dlg.querySelector("select"), ok= document.getElementById("'.$dId.'_confirmBtn");
            if (sel && ok) sel.addEventListener("change", function(){ ok.value= sel.value; });      // A <select> INSIDE the dialog sets the return value
            dlg.addEventListener("close", function(){ document.getElementById("'.$dId.'_out").value= dlg.returnValue; });
        })();
        </script>';  // The button value ("default"/"cancel"/...) is in dialog.returnValue and shown in the <output>
    if (!$rtrn) echo $result; else return $result;
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
                        ['@Confirm', '@Hint', '', 'Icon', true ],
                        ['@Close',   '@Hint', '', 'Icon', false]
                    ])
{ # DEPRECATED - use sysAlert() / sysConfirm() (JavaScript), msg_System() / msg_Error() ... (server messages) or htm_Alert() (on the page).
  # Was a jQuery UI dialog; now the theme-aware <dialog> of sysAlert()/sysConfirm() - no jQuery / jQuery UI needed.
  # Button 1 runs at OK, button 2 at Cancel (a 3rd button is not shown). "$(this).dialog('close')" is not needed: the dialog closes itself.
  # The message is shown as text (<br> and </p> become line breaks).
    $pref= ['error'=>'@Error: ', 'info'=>'@Info: ', 'warn'=>'@Warn: ', 'tip'=>'@Hint: ', 'success'=>'@Bingo: '][strtolower((string)$vrnt)] ?? '';
    $title= trim(strip_tags(($pref>'' ? ucfirst(lang($pref)) : '').lang($caption)));
    $text= ($mess=='') ? lang('@This is a modal dialog, which can be used to display information.') : lang($mess);
    $text= trim(html_entity_decode(strip_tags(preg_replace('#<br\s*/?>|</p>#i', "\n", $text)), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $js= function($b) {                             # The JavaScript of a button - without the jQuery UI close call
        $code= preg_replace('/\$\w*\(\s*this\s*\)\s*\.\s*dialog\(\s*["\']close["\']\s*\)\s*;?/', '', (string)($b[2] ?? ''));
        return 'function(){ '.trim($code).' }';
    };
    $j= function($v) { return json_encode($v, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); };
    $b1= $Buttons[0] ?? null;  $b2= $Buttons[1] ?? null;
    $opt= '{title: '.$j($title).', msg: '.$j($text).
          ', ok: '.($b1 ? $j(strip_tags(lang($b1[0]))) : 'P2H_T.ok').', onOk: '.($b1 ? $js($b1) : 'null').
          ($b2 ? ', cancel: '.$j(strip_tags(lang($b2[0]))).', onCancel: '.$js($b2) : '').'}';
    echo '<script>(function(){ function go(){ p2hDialog('.$opt.'); }'.
         ' if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", go); else go(); })();</script>';
    return false;
} // msg_Dialog()


## Short forms of msg_System() - one message with a Close button. (They were commented out, so calling them was a fatal error.)
function msg_Error($title='@Error',   $messg='') { msg_System('error',   $title, '', $messg, ['goon','close']); }
function msg_Info($title='@Info',     $messg='') { msg_System('info',    $title, '', $messg, ['close']); }
function msg_Warn($title='@Warning',  $messg='') { msg_System('warn',    $title, '', $messg, ['goback','close']); }
function msg_Hint($title='@Tip',      $messg='') { msg_System('hint',    $title, '', $messg, ['close']); }
function msg_Succ($title='@Hurray',   $messg='') { msg_System('success', $title, '', $messg, ['close']); }
 
// Afhængig af: msg_lib.css.php   -   Afløser for msg_Dialog()
function msg_System($vrnt= 'error', $capt='',  $body='', $mess='', $list=['goback','goon','close'], $wdth='600px', $rtrn=false) # $type:'error'|'info'|'warn'|'hint'|'success'|'#color'
{ ## INIT:   (?: instead of ?? - the parameters default to '' and not to null, so ?? never used the defaults)
    static $msgNo= 0;  $msgNo++;  $mId= 'open-modal'.$msgNo;     # Unique id - several messages on one page
    $capt= ucfirst(lang($capt ?: 'PHP2HTML'));
    $body= ucfirst(lang($body));
    $mess= ucfirst(lang($mess ?: lang('@This is a CSS based modal dialog independent of jquery that can be used to display information.').'<br><br>'.
                                 lang('@The window can be closed with the \'x\' icon, or by clicking anywhere outside the window.')));
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
                        $pref= ucfirst(lang('@Hint: '));    $Capt1='';                    break;
        case "success": $headColr= '#DFF2BF';    # color: light-green
                        $pref= ucfirst(lang('@Hurray: '));                                break;
        default:  $headColr= $vrnt; $pref= ''; //  Custom color and without prefix
    } 
    $result= '';   # (The CSS for .modal* is in the system CSS)
    $result.= '<div class="modal__container">'.
              '  <input type="checkbox" id="'.$mId.'" class="modal__toggler" checked />'.  // Hidden checkbox: unchecking it closes the modal
              '  <label class="modal__mask" for="'.$mId.'"></label>';                     // Background mask. Clicking it closes the modal 
    $result.= '  <div class="modal" style="width: '.$wdth.'; margin: 0 auto; ">'.
              '    <label class="modal__close" for="'.$mId.'" title="'.lang('@Close').'"></label>'.
              '    <div class="modal__header" style="background-color: '.$headColr.';">'.
              '      <h3 style="margin:8px;">'.$pref.$capt.'</h3>'.
              '    </div>'.
              '    <section class="modlwrap">';
    if ($body>' ')  
        $result.= '<div class="modal__content" style="width:35%; box-sizing: border-box; float: left; background:lightcyan; text-align:left; word-wrap: break-word; ">
                   '.(($Capt1 ?? '')>'' ? '<div style="font-weight:600;">'.$Capt1.':</div>' : '').'<samp><small>'.$body.'</small></samp>'.'<br><br></div>';
    $result.= '      <div class="modal__content" style="'.($body>' ' ? 'width:65%; box-sizing: border-box; float: right;' : 'float: none; box-sizing: border-box; width: 100%;').' background:lightyellow; text-align:left; word-wrap: break-word; ">
                     '.(($Capt2 ?? '')>'' ? '<div style="font-weight:600;">'.$Capt2.':</div>' : '').'<var>'.$mess.'</var>'.'<br><br></div>'.
              '    </section> '.
              '    <div class="modal__footer" style="background-color: '.$headColr.'; ">';
    if (in_array('goback',$list)) $result.= '<label class="modlButt" for="'.$mId.'"  title="'.lang('@Close the window and return to the previous screen').'">'.lang('@Undo').' </label>';
    if (in_array('goon',  $list)) $result.= '<label class="modlButt" for="'.$mId.'"  title="'.lang('@Close the message-window and continue').'">'.lang('@Continue').' </label>';
    if (in_array('accept',$list)) $result.= '<label class="modlButt" for="'.$mId.'"  title="'.lang('@Confirm and continue').'">'.lang('@Accept').' </label>';
    if (in_array('close', $list)) $result.= '<label class="modlButt" for="'.$mId.'"  title="'.lang('@Close the window!').'">'.lang('@Close')    .' </label>';
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
function Pmnu_(#  elem:'id', capt:'', wdth:'210px', icon:'', stck:'false', attr:'background-color:lightcyan;', cntx:true, rtrn:false) 
                 $elem='id',$capt='', $wdth='210px', $icon='', $stck='false', $attr='background-color:lightcyan; height: 26px; border: 2px solid lightgray; border-radius: 4px; margin-left: 1px;', $cntx=true, $rtrn=false) // Note: $elem is used to link to the calling element
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
    top: '30%".    /* TEST1 */ "',
    left: '40%".   /* TEST1 */ "',
    items: [    // ITEMS:
    ";
    if ($capt>'') $result.= '{label: "'.lang($capt).'", hint: "Just an informative Caption", cssicon: "'.$icon.'", custAttr: "'.$attr.'"}, 
        ';
    
    if (!$rtrn) echo $result; else return $result;
} // Pmnu_

//      function Pmnu_Item($type='plain',$labl='',$hint='',$icon='',$id='',$click='',$attr='',$short='',$enbl='true',$rtrn=false) 
function Pmnu_Item(# labl:'', icon:'', hint:'', vrnt:'plain', name:'', clck:'', attr:'', shrt:'', enbl:'true', rtrn:false) 
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
                                  (opts.enabled  !== undefined ? opts.enabled : true));   break; 
*/
            case 'hovermenu': $result.= ', type: "hovermenu", items: [';                    break;
            case 'submenu'  : $result.= ', type: "submenu", items: [';                      break;
            case 'subitem'  : $result.= ', type: "subitem", onClick: () => {'.$clck.'}},';  break;
            case 'multi'    : $result.= ', type: "multi", items: [';                        break;
            case 'end_sub'  : $result = ']},';                                              break;
            
            case 'separator': $result.= ', type: "separator"';  break;       // $result.= " <li class='ctxP_Js ctxP_MenuSeparator'><span></span></li>"; break;
            case 'footer'   : $result.= "";                     break;
            default         : $result.= 'Type parameter ERROR: '.$vrnt;
        }
    if (!in_array($vrnt,['multi','hovermenu','submenu','subitem','end_sub']))
        $result.= '},'; // ?:  '],';
    if (!$rtrn) echo $result; else return $result;
} // Pmnu_Item

function Pmnu_end(# labl:'', hint:'', attr:'', rtrn:false) 
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
    if ($rtrn) return $result; else echo $result; 
}

// Add html_ functions for generel use:

# Init popup context menu group
function htm_Pmnu_($elem='id',$capt='', $wdth='210px', $icon='', $stck='false', $attr='background-color:lightcyan; height: 26px; border: 2px solid lightgray; border-radius: 4px; margin-left: 1px;', $cntx=true, $rtrn=false) {
             Pmnu_($elem,     $capt,    $wdth,         $icon,    $stck,         $attr, $cntx, $rtrn);
}

# Add a popup context menu item
function htm_Pmnu_Item($labl='', $icon='', $hint='', $vrnt='plain', $name='', $clck='', $attr='', $shrt='', $enbl='true', $rtrn=false) {
             Pmnu_Item($labl,    $icon,    $hint,    $vrnt,         $name,    $clck,    $attr,    $shrt,    $enbl,        $rtrn);
}

# Finish a popup context menu group
function htm_Pmnu_end($labl='', $hint='', $attr='', $rtrn=false) {
             Pmnu_end($labl,    $hint,    $attr,    $rtrn);
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
*/

{ ## Group ******************** htm_Menu: ************************** 

# A page-menu on top of the page
function htm_Menu_TopDown(# capt:'Clever html engine', data:[], foot:'PHP2HTML', styl:'', wdth;'150px', note;'')
$capt='Clever html engine', # string: Title at left
$data=[],                   # array:  Data for the meny - Data(0:vrnt='', 1;icon='', 2:labl='', 3:hint='', 4:desc='', 5:link='', 6:subm=[], 7:styl='')
$foot='PHP2HTML',           # string: Text right to menu
$styl='',                   # string: Additional style to default style
$wdth='150px',              # string: Widths of menu columns. NOT used yet !
$note='',                   # string: Text left to menu
$niv0='',                   # string: Style attribute to node niveau 0 (div)
$niv1='',                   # string: Style attribute to node niveau 1 (div class="dropdown")
$niv2='',                   # string: Style attribute to node niveau 2 (data-hint)
$them=true,                 # bool:   Show the theme button (htm_ThemeButt) as the last menu item
$view=null                  # bool:   Show the floating view bar (htm_ViewBar: zoom, full screen, theme) instead of the theme button. null: use $gbl_ViewBar
)
{   static $menuNo= 0;  $menuNo++;
    $view= $view ?? ($GLOBALS['gbl_ViewBar'] ?? false);
    $navId= ($menuNo==1) ? 'htmTopnav' : 'htmTopnav'.$menuNo;      # Unique id when a page has more than one menu
    $here= strtolower(basename($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? ''));
    $isHere= function($link) use ($here) {                          # Is the link the page we are on?
        $path= parse_url(trim((string)$link), PHP_URL_PATH);
        return ($here>'') && ($path>'') && (strtolower(basename($path))==$here);
    };
    $hasFlag= function($item, $flag) { return isset($item[7]) && (strpos(' '.$item[7], $flag) > 0); };
    $hintEl= function($text, $style) { return '<data-hint style="'.$style.'">'.$text.'</data-hint>'; };

    # htm_Menu_TopDown:
    echo '<style> body { padding-top: 0; margin-top:0; } </style>'; # Allow menu to be placed at window top
        // Data(0:vrnt='', 1;icon='', 2:labl='', 3:hint='', 4:desc='', 5:link='', 6:subm=[], 7:styl='')  7: 'disabled' / 'active'
    echo ' <span>';
    echo '<nav class="topnav bgcldark" id="'.$navId.'" style="width: max-content; padding-right: 20px;
            border: 0px solid lightgray; border-radius: 4px;
            margin-left: auto; margin-right: auto; position: sticky; top: 0; z-index:999; '.($niv0>'' ? $niv0 : '').'">';
    $heading= true;
    if ($heading==true)
        if ($capt>'') echo '<div class="mnu_heads">'.lang($capt).'</div>';
    foreach ($data as $item) {
        $subm= $item[6] ?? [];
        if ($item[1]>'') $icon= '<data-ic class="'.trim($item[1]).' fa-fw" style="font-size:16px;"></data-ic>'; else $icon= '';
        $dis= $hasFlag($item, 'disabled');
        $act= $hasFlag($item, 'active') || $isHere($item[5]);       # Active: the page itself, or one of its submenu pages
        foreach ($subm as $it) if ($isHere($it[5])) $act= true;
        echo '
            <div class="dropdown'.($subm != [] ? ' hasSub' : '').'" '.($niv1>'' ? 'style="'.$niv1.'"' : '').'>
                <abbr class= "hint menulabl" >
                    <a class="dropbtn'.($act ? ' mnuActive' : '').'" href="'.sys_enc(trim($item[5])).'"'.
                        ($act && $isHere($item[5]) ? ' aria-current="page"' : '').
                        ($subm != [] ? ' aria-haspopup="true" aria-expanded="false"' : '').
                        ($dis ? ' aria-disabled="true" tabindex="-1"' : '').
                        ' style="'.$styl.($dis ? ' opacity:0.8; pointer-events:none;' : '').'">'.
                        $icon. lang($item[2]). ($subm != [] ? ' <i class="fa fa-caret-down"></i>' : '').
                    '</a>';
                    if ($item[3]>'') echo $hintEl(trim(lang($item[3]).' '.(trim((string)($item[4] ?? ''), '@ ')>'' ? lang($item[4]) : '')),   # Each part translated
                                                  'left: 160px; top: 35px; overflow:visible;'.$niv2);
                echo '
                </abbr>
                <div class="dropdown-content">';
                foreach ($subm as $i) {
                    $sIcon= ($i[1]>'') ? '<data-ic class="'.$i[1].' fa-fw" style="font-size:16px;"></data-ic>' : '';
                    $sDis= $hasFlag($i, 'disabled');
                    $sAct= $isHere($i[5]);
                    echo '
                    <abbr class= "hint " style="background-color:yellow;">
                        <a href="'.sys_enc(trim($i[5])).'"'.($sAct ? ' class="mnuActive" aria-current="page"' : '').
                            ($sDis ? ' aria-disabled="true" tabindex="-1" style="pointer-events: none; opacity:0.5;"' : '').'>'. $sIcon. lang($i[2]). '</a>';
                    if (($i[3]>'') or ($i[4]>''))
                        echo $hintEl(($i[3]>'' ? lang($i[3]) : lang($i[4])), 'left: 150px; top: 18px; overflow:visible;');
                    echo '</abbr>';
                }
                echo '
                </div>
            </div> ';
    }
    if ($them && !$view) echo '
            <div class="dropdown mnuTheme">'.htm_ThemeButt(rtrn:true).'</div>';
    echo '<a href="javascript:void(0);" style="font-size:17px; background-color:#333; padding:2px;"
                                        class="icon" aria-label="Menu" onclick="TopnavResp(this)">&#9776;</a>'; // Burgermenu
    if ($heading==true)
        if ($foot>'') echo '<span class="mnu_heads">'.lang($foot).'</span>';
    echo '
    </nav>';
    if ($view && ($menuNo==1)) htm_ViewBar();
    if ($note>'') echo '<br><br><span style="background:transparent; top:-16px; position:relative; ">'.lang($note).'</span>';
    echo ' </span>';

    if ($menuNo==1) echo '
    <script>
        function TopnavResp(btn) {                                  /* Burger menu (narrow screens): open/close */
            var x= btn ? btn.closest(".topnav") : document.getElementById("htmTopnav");
            if (x) x.classList.toggle("responsive");
        }
        /* Submenus open by hover (mouse), by Tab (keyboard, CSS :focus-within) - and by tap on touch screens:
           the first tap on a menu item with a submenu opens the submenu, the next tap follows the link. */
        function p2hMenuClose(except) {
            document.querySelectorAll(".topnav .dropdown.open").forEach(function(d){
                if (d !== except) { d.classList.remove("open"); var b= d.querySelector(".dropbtn"); if (b) b.setAttribute("aria-expanded","false"); } });
        }
        document.addEventListener("click", function(e) {
            var btn= e.target.closest(".topnav .hasSub > abbr > .dropbtn");
            if (btn && matchMedia("(hover: none)").matches) {
                var d= btn.closest(".dropdown");
                if (!d.classList.contains("open")) { e.preventDefault(); p2hMenuClose(d); d.classList.add("open"); btn.setAttribute("aria-expanded","true"); return; }
            }
            if (!e.target.closest(".topnav .dropdown")) p2hMenuClose(null);
        });
        document.addEventListener("keydown", function(e) {           /* Esc closes an open submenu */
            if (e.key !== "Escape") return;
            p2hMenuClose(null);
            var a= document.activeElement;
            if (a && a.closest(".topnav .dropdown-content")) { var b= a.closest(".dropdown").querySelector(".dropbtn"); if (b) b.focus(); }
        });
    </script>
    ';
} # htm_Menu_TopDown

# A page-menu to the left of the page
function htm_Menu_Leftout(# capt:'Clever html engine', data:[], foot:'', styl:'',wdth:'180px')
    $capt='Clever html engine', # string: Title at top
    $data=[],                   # array:  Data for the menu
    $foot='',                   # string: Note at bottom
    $styl='',                   # string: Aditional style to default style
    $wdth='180px'               # string: Widths of menu columns
)
{ //                    0          1        2         3         4         5         6         7         8         9
    if (!function_exists('MenuLine')) {                     # Declared once - htm_Menu_Leftout() may be called again
    function MenuLine(# $pref='', $vrnt='', $icon='', $labl='', $hint='', $desc='', $link='', $subm=[], $styl='', $wdth) 
        $pref='',     # string - Prefix (indent) for submenu
        $vrnt='',     # string - Variant not in use (Frst/Next/Last)
        $icon='',     # string - icon class        
        $labl='',     # string - Allways visible
        $hint='',     # string - Visible on mouseover lable
        $desc='',     # string - Visible on mouseover menu (description)
        $link='',     # string - url / href
        $subm=[],     # array  - Data for submenu
        $styl='',     # string - Override style for hint position
        $wdth=''      # string - Widths of menu columns
     )
     { echo                                                                         
        '<br><span class="mnuLine">'.                                              
            '<span class= "iconlabl" '.                                             
             'style="width:'.$wdth.'; display:inline-block;;">'.$pref;              
            if ($icon>'') echo                                                      
            '<data-ic class="'.$icon.' fa-fw" style="font-size:16px;"></data-ic>';  
            echo                                                                    
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
            <span class="desc_div" style="/* left: 180px; */ color: yellow; position: revert; display: inline-block; 
                vertical-align: top; font-size:smaller; max-width:'.$wdth.'; ">'.
                lang($desc).
            '</span>';
       echo '
       </span>';
    } // MenuLine
    }
    
    $jsCapt= sys_enc(json_encode(lang($capt)));  $jsWdth= sys_enc(json_encode($wdth));   # Safe in the JS call
    echo '<div class="p2hLeftMenu" onmouseover="desc_div(\'wide\', '.$jsCapt.', '.$jsWdth.')" onmouseout="desc_div(\'narrow\', '.$jsCapt.', '.$jsWdth.')"
           onfocusin="desc_div(\'wide\', '.$jsCapt.', '.$jsWdth.')" onfocusout="if (!this.contains(event.relatedTarget)) desc_div(\'narrow\', '.$jsCapt.', '.$jsWdth.')"
           style="text-align:left; background:#fafafa; opacity: 0.9; background-color: var(--darkBcgrd); color: white;
           border: 2px solid lightgray; border-radius: 4px; padding:5px; width:max-content; z-index: 1000;
           position:fixed; top:28px; left:15px;'.$styl.'">';

     if ($capt> '') echo '<span class="mnu_heads" style="width:94%;">'.lang($capt).'<hr><br></span>';
     if ($capt=='') echo '<div class="mnu_heads">'. lang('@Menu:').'</div>';
     echo '<br>';
     foreach ($data as $top) {          // TopMenu:
        MenuLine($pref='', $top[0], $top[1], $top[2], $top[3], $top[4], $top[5], $top[6], ($top[7] ?? ''), $wdth);
        if (count($top[6])>0)
            foreach ($top[6] as $sub)   // SubMenu:
                MenuLine($pref=' &nbsp; &nbsp; ', $sub[0], $sub[1], $sub[2], $sub[3], $sub[4], $sub[5], $sub[6], $sub[7], $wdth);
     };
    if ($foot>'') echo '<br><span class="mnu_heads" style="width:94%;"><hr>'.lang($foot).'</span>';
    echo '</div>';
} // htm_Menu_Leftout

// Hide parts of menu:
$javaScripts.= '<script>
function desc_div(state, capt, widt) {   /* Narrow: icons only - wide: labels and descriptions. Line by line. */
    var phone= matchMedia("(max-width: 760px)").matches;     /* Phone: the menu is in the page flow - show the texts (the icons are no links) */
    var narrow= (state == "narrow") && !phone, heads= document.getElementsByClassName("mnu_heads");
    document.querySelectorAll(".mnuLine").forEach(function(line) {
        var ic= line.querySelector(".iconlabl"), lb= line.querySelector(".menulabl"), ds= line.querySelector(".desc_div");
        if (ic) ic.style.width= narrow ? "max-content" : widt;
        if (lb) lb.classList.toggle("p2hVisHidden", narrow);   /* Hidden from view, but the link can still get keyboard focus */
        if (ds) ds.style.display= (narrow || phone) ? "none" : "inline-block";
    });
    if (heads[0]) heads[0].innerHTML= narrow ? "Menu:<br>" : capt + "<br><hr>";
    for (var i= 1; i < heads.length; i++) heads[i].style.display= narrow ? "none" : "inline";
}
</script>';

  /* Context menu system: */
$javaScripts.= "
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
            if (!docked) {   ". /* TEST1 Dont calc left & top but use 30% 40% ("near center in window" )*/ "
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



} ## Group ******************** /htm_Menu **************************

{ ## Group ******************** htm_Page: **************************

# Start creating a page [Necessary basic element]
function htm_Page_(# titl:'', hint:'', info:'', inis:'', algn:'center', imag:'', attr:'', pbrd:true) 
    $titl='',           # string: Page title
    $hint='',           # string: Page tip  (vertical text - left)
    $info='',           # string: Page into (vertical text - right)
    # $foot='',         ¤ string: Page footer text at page bottom
    $inis='',           # string: Page initial CSS/js script in page header
    $algn='center',     # string: align - "text-align"
    $imag='',           # string: Page background-image
    $attr='',           # string: Page attributes
    $pbrd=true          # bool:   Draw border around the page body-div
    )
{ # Prepare / initialize a page  # Must be followed by htm_Page_end() to finalise the page
    global $gbl_ProgRoot, $CSS_system, $gbl_TitleColr, $cardCount, $pbrd,$gbl_progZoom, $javaScripts, $headEndScript, 
           $gbl_progDesti, $gbl_copyright, $autoCDN, $LIB_JQUERY, $LIB_JQUERYUI, $LIB_TABLESORTER, $LIB_FONTAWESOME, $LIB_TINYMCE, $LIB_PDFVIEW, $LIB_POLYFILL, $pdf_file;
    $pageMess= '<b>ERROR:</b> ';

    # Preconnect to the CDN when a library is taken from it: DNS + TLS start at once, not first when the first <script>/<link> is met
    $cdnUse= false;
    foreach ([$LIB_JQUERY, $LIB_JQUERYUI, $LIB_TABLESORTER, $LIB_FONTAWESOME, $LIB_TINYMCE, $LIB_PDFVIEW, $LIB_POLYFILL] as $lb)
        if (is_array($lb) and ((($lb[0] ?? 0)==2) or ((($lb[0] ?? 0)==3) and (($autoCDN ?? '')=='2')))) $cdnUse= true;
// <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    $headBuf= (($GLOBALS['gbl_AssetCache'] ?? true) !== false);  if ($headBuf) ob_start();   # The <head>: big CSS/JS blocks to cached files (p2h_assetFiles)
    echo '<!DOCTYPE html>
    <html lang="'.sys_enc(preg_match('/^[a-z]{2}(-[A-Za-z]{2})?$/', $GLOBALS['lang'] ?? '') ? $GLOBALS['lang'] : 'en').'" dir="ltr">
    <head>
    <meta charset="UTF-8">
    '.p2h_themeBoot().'
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="'.$gbl_progDesti.'">
    <meta name="author" content="'.$gbl_copyright.'">
    <meta name="robots" content="Noindex, Nofollow">'.  // Reject robots
   '<meta name="googlebot" content="Noindex">'.         // Reject robots
   '<title>'.htmlspecialchars(strip_tags(lang($titl)), ENT_QUOTES, 'UTF-8').'</title>'. "\n".
   ($cdnUse ? '<link rel="preconnect" href="https://cdnjs.cloudflare.com"><link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>'."\n" : '').   # Scripts/CSS (no CORS) and fonts (CORS)
   (is_readable(__DIR__.'/manifest.json') ? '<link rel="manifest" href="'.sys_enc($gbl_ProgRoot.'manifest.json').'">' : '').      # Install on the home screen (PWA)
   (is_readable(__DIR__.'/favicon.svg')   ? '<link rel="icon" href="'.sys_enc($gbl_ProgRoot.'favicon.svg').'" type="image/svg+xml">'.
                                            '<link rel="apple-touch-icon" href="'.sys_enc($gbl_ProgRoot.'_accessories/icon-192.png').'">' : '').
   '<meta name="theme-color" content="#2c3e50">'."\n";  
    dvl_pretty('htm_Page_');


### ----------------------Library-dialog-polyfill-------------------------
    if (isset($LIB_POLYFILL)) {
        if ($LIB_POLYFILL[0]=='3') $LIB_POLYFILL[0]= $autoCDN;       # Auto: Local/CDN
        switch($LIB_POLYFILL[0]) {
            case 0 : $path= '';                              break;  # Not active
            case 1 : $path= $gbl_ProgRoot.$LIB_POLYFILL[1];  break;  # Local-folder
            case 2 : $path=               $LIB_POLYFILL[2];  break;  # CDN-server  :https://
           default : { $pageMess.= 'LIB_POLYFILL: illegal index ! '; }
        }
        if ($path > '') {
            echo '<script src="'.$path.'dialog-polyfill.js"></script>';
            echo '<link rel="stylesheet" href="'.$path.'dialog-polyfill.css"/>';
            run_Script("document.addEventListener('DOMContentLoaded', function() {    /* Every <dialog> on the page acts like a native one */
                document.querySelectorAll('dialog').forEach(function(d) { dialogPolyfill.registerDialog(d); });
            });");
            }
    } else 
    { $LIB_POLYFILL=  [0, '', '']; /* $pageMess.= ' dialog-polyfill is not loaded  ! <br>'; */ }
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
} 
*/
### ----------------------

### ----------------------Library-jQuery-------------------------
### jQuery-latest:  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js
//                  https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js 
//                  https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js
//                  https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css
//                                          _assets/jquery/*********************************

    if (isset($LIB_JQUERY[0]) and ($LIB_JQUERY[0] >=0)) {
        if ($LIB_JQUERY[0]==3) $LIB_JQUERY[0]= $autoCDN;            # Auto: Local/CDN
        switch($LIB_JQUERY[0]) {
            case 0 : $path= '';                             break;  # Not active
            case 1 : $path= $gbl_ProgRoot.$LIB_JQUERY[1];   break;  # Local-folder
            case 2 : $path=               $LIB_JQUERY[2];   break;  # CDN-server  :https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery.min.js
           default : { $pageMess.= 'LIB_JQUERY: illegal index ! '.$LIB_JQUERY[0]; }
        }
        if ($path > '') {
            echo '<script src="'.$path.'jquery.min.js"></script>';              //  topic="Tablesorter-system" and Topmenu-system      
        } 
    } else 
    { $pageMess.= ' jQuery is not loaded - Some functions do not work!<br>'.($LIB_JQUERY[0] ?? '0'); $LIB_JQUERY=  [0, '', '']; }

    if (isset($LIB_JQUERYUI[0]) and ($LIB_JQUERYUI[0] >=0)) { 
        if ($LIB_JQUERYUI[0]==3) $LIB_JQUERYUI[0]= $autoCDN;             # Auto: Local/CDN
        switch($LIB_JQUERYUI[0]) {
            case 0 : $path= '';                              break;  # Not active
            case 1 : $path= $gbl_ProgRoot.$LIB_JQUERYUI[1];  break;  # Local-folder
            case 2 : $path=               $LIB_JQUERYUI[2];  break;  # CDN-server  :https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js
           default : { $pageMess.= 'LIB_JQUERYUI: illegal index ! '.$LIB_JQUERYUI[0]; }
        }
        if ($path > '') {
        $GLOBALS['p2hUiTags']= '<script src="'.$path.'jquery-ui.min.js"></script>';   # The library itself does not use jQuery UI any more:
                                                                                      # loaded only with $gbl_LazyLibs= false (projects that use it)
        if (!($GLOBALS['gbl_LazyLibs'] ?? true)) echo p2h_libTags('p2hUiTags');
        // echo '<link  href="'.$path.'jquery-ui.min.css" rel="stylesheet" />'; //  topic="jquery Dialog"> 
        // 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/'
        // echo '<link  href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.css" />';    // topic="jquery Dialog"> 
        } 
    } else 
    { $pageMess.= ' jQuery-ui is not loaded  ! <br>'; $LIB_JQUERYUI=  [0, '', '']; }
### ----------------------

### ----------------------Library-Tablesorter-------------------------
    if (isset($LIB_TABLESORTER) and ($LIB_TABLESORTER[0]>=0)) {
        if (array_key_exists(0, $LIB_TABLESORTER))
            if ($LIB_TABLESORTER[0]>0) {                                                 # if library activated
                if ($LIB_TABLESORTER[0]==3) $LIB_TABLESORTER[0]= $autoCDN;               # Auto: Local/CDN
                if ($LIB_TABLESORTER[0]==1) $path= $gbl_ProgRoot.$LIB_TABLESORTER[1];    # Local-folder
                else                        $path=               $LIB_TABLESORTER[2];    # CDN-server 
            $GLOBALS['p2hTsTags']=                                                                 # Loaded by the first htm_Table() (or here: $gbl_LazyLibs= false)
                 '<script src="'.$path.'js/jquery.tablesorter.js"></script>'.                      // topic="Tablesorter-system" - required
                 '<script src="'.$path.'js/widgets/widget-cssStickyHeaders.min.js"></script>'.     // topic="Tablesorter-system - parsers"
                 '<script src="'.$path.'js/parsers/parser-input-select.min.js"></script>'.         // topic="Tablesorter-extra"
                 '<script src="'.$path.'js/jquery.tablesorter.widgets.js"></script>'.
                 '<link  href="'.$path.'css/theme.blue.css" rel="stylesheet" />';
            if (!($GLOBALS['gbl_LazyLibs'] ?? true)) echo p2h_libTags('p2hTsTags');
            // topic="Tablesorter-system" (choose a theme file)
        }
    } 
    /* 
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
    */
    // $lateScripts= '';   // To be run before >/body>
//    echo "//    echo "


// if (!(isset($LIB_TABLESORTER[0]) && array_key_exists(0, $LIB_TABLESORTER) && ($LIB_TABLESORTER[0]==0) )) 
if (isset($LIB_TABLESORTER) and ($LIB_TABLESORTER[0]>0))
{   
$javaScripts.= "
<script>
    $(function () {
    /* $('#table0, #table1, #table2, #table3, #table4, #table5, #table6').tablesorter({ gbl_TblIx       */
    if ($.fn.tablesorter) $('table.tablesorter').filter(function () { return /^table\\d+$/.test(this.id); }).each(function () { var wrap= $(this).closest('.wrapper'); $(this).tablesorter({   /* All htm_Table() tables (Tablesorter is loaded by the first one) */
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
        stickyHeaders_attachTo: wrap,       // The wrapper of THIS table (was '.wrapper': the first of the page - FIXIT: only the 1st table had sticky headers)
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
          }
        },
        storage_storageType: 's', // use first letter (s)ession
        resizable_addLastColumn : true,
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
    }); });                                                      /* (each table) */

//  // (old: make second table scroll within its wrapper - done: each table is attached to its own wrapper)
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
</script>";

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
    background: rgba(244,244,244,0.8); /*  url(http:mottie.github.com/tablesorter/addons/pager/icons/loading.gif) center center no-repeat; */
    position: absolute;
    z-index: 1000;
    display: none;
    width: 100%;
    height: auto;
    margin: 0;
    top: 0;
    left: 0;
}

.tablesorter-blue input.tablesorter-filter, .tablesorter-blue select.tablesorter-filter {      /* (was a jQuery call here: an invalid selector) */
  width: 99%;
  height: auto;
  margin: 0;
  padding: 1px;
}
</style>     <!-- (was not closed: the next blocks were read as CSS text until some later </style>) -->
";
} # LIB_TABLESORTER

if (!(isset($LIB_FONTAWESOME[0]) && array_key_exists(0, $LIB_FONTAWESOME) && ($LIB_FONTAWESOME[0]==0) )) 
   $javaScripts.= "
<script>


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
        var $table= $(this).closest("table");
        var clone = $("$table .row:first").clone().appendTo("$table");
        // INFO: Indsætter som sidste række, en kopi af 1. række
        // Bedre: Indsætter herunder en kopi, af aktuel række
        // window.alert("Insert as last row, a copy of the 1. row");
        sysConfirm("'.lang('@Insert copy as the last row, a copy of 1. row ?').'", function() {
            $(".txtbox", clone);
        });
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
        var self= this;
        sysConfirm("'.lang('@Are You Sure to Remove This Row?').'", function() {
            $(self).closest("tr").remove();
        });
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


    function pw_strength(input) {
        var text =      input.value;
        var point = 0;
        if ( text.length >= 6 )     {point += 1};
        if ( text.length >= 8 )     {point += 1};
        if ( text.length >= 10 )    {point += 2};
        if ( text.length >= 12 )    {point += 2};
        if (/[a-zæøå]/.test(text) ) {point += 1};
        if (/[A-ZÆØÅ]/.test(text) ) {point += 1};
        if (/[0-9]/.test(text) )    {point += 1};
        if (/[~`!@#$£€¤%?()\^&*+=\-\[\]\\\';,/{}|\\":<>\?]/g.test(text) ) {point += 1};
        document.getElementById("pwPoint_" + input.id).value = point;
    }
'.
"   function togglePassword(input,butt) {
        var passInput = input;
        var togglePW  = butt;
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

</script>"; // LIB_FONTAWESOME $javaScripts
### ----------------------

if (isset($LIB_PDFVIEW) and ($LIB_PDFVIEW[0]>0)) {  
$javaScripts.= 
'';   // (Removed: PHP code inside a <script> block - it was sent to the browser as invalid JavaScript)
$pdfview_css = 
'
body{
    background: black;
    margin:0px;
    }
.pagination{
    background: #ffffff;
    width: 62%;
    float: left;
}
.pagination .wrap{
    float:right;
    width: 300px;
} 
#the-canvas {
    border: 1px solid gray;
    direction: ltr;
    margin: 0 auto;
    display: block;
}
@media print {
  body {display:none;}
}';
set_Style('', '.pagination { background: #ffffff; width: 62%; float: left; } .pagination .wrap { float: right; width: 300px; } '.
              '#the-canvas { border: 1px solid gray; direction: ltr; margin: 0 auto; display: block; }');
    # (Only these rules of $pdfview_css: the whole block was sent inside a <script>, and the browser happened to use these via an unclosed
    #  <style> - plus body{display:none} in print, which made the page print blank. body{background:black} was never used.)
}

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
            padding: 4px 8px 2px 4px;
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
        position: fixed;  /* fixed absolute  */
        padding: 4px 0;
        margin: 2px;
        top: 40%;
        left: 50%;
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
      background-color: inherit;
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
    .dropdown a.dropbtn { float: none; font-size: 13.3333px; line-height: normal; }
    .dropdown:focus-within .dropdown-content, .dropdown.open .dropdown-content { display: block; }   /* Keyboard and touch */
    .topnav a.dropbtn.mnuActive { background-color: rgba(255,255,255,0.18); box-shadow: inset 0 -3px 0 #4fc3f7; font-weight: 600; }
    .dropdown-content a.mnuActive { font-weight: 600; box-shadow: inset 3px 0 0 #4fc3f7; }
    .topnav a:focus-visible, .topnav button:focus-visible { outline: 2px solid #4fc3f7; outline-offset: -2px; }
    @media screen and (max-width: 640px) { .topnav.responsive .mnu_heads { display: block; } }
        .message{ padding:4px 7px;border:1px solid #ddd;background-color:#fff;
            border-radius:6px;text-align:center;}
        .message.ok{ border-color:green;color:green}
        .message.error{ border-color:red;color:red}
        .message.alert{ border-color:orange;color:orange}
        body.fm-login-page.theme-dark {background-color: #2f2a2a;}
        
    </style>    <!-- htm_Menu_TopDown -->
        
";  // $sys_Style


if (isset($LIB_SWITCHBOX[0]) && array_key_exists(0, $LIB_SWITCHBOX) && ($LIB_SWITCHBOX[0]==0) )
{ $switchbox_style = ""; }
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


/* 
?>
<script>
/*! easy-toggle-state v1.16.0 | (c) 2020 Matthieu Bué <https://twikito.com> | MIT License | https://twikito.github.io/easy-toggle-state/ https://twikito.github.io/easy-toggle-state/#examples * /
!function(){"use strict";const t=document.documentElement.getAttribute("data-easy-toggle-state-custom-prefix")||"toggle",e=(e,r=(()=>t)())=>["data",r,e].filter(Boolean).join("-"),r=e("arrows"),i=e("class"),n=e("class-on-target"),s=e("class-on-trigger"),a="is-active",o=e("escape"),u=e("event"),c=e("group"),l=e("is-active"),g=e("modal"),d=e("outside"),h=e("outside-event"),A=e("radio-group"),b=e("target"),f=e("target-all"),$=e("target-next"),v=e("target-parent"),m=e("target-previous"),E=e("target-self"),w=e("state"),p=e("trigger-off"),y=new Event("toggleAfter"),k=new Event("toggleBefore"),L=(t,e)=>{const r=t?`[${t}]`:"";if(e)return[...e.querySelectorAll(r)];const a=[`[${i}]${r}`,`[${s}]${r}`,`[${n}][${b}]${r}`,`[${n}][${f}]${r}`,`[${n}][${$}]${r}`,`[${n}][${m}]${r}`,`[${n}][${v}]${r}`,`[${n}][${E}]${r}`].join().trim();return[...document.querySelectorAll(a)]},x=(t,e)=>t.dispatchEvent(e),O=t=>"easyToggleState_"+t,S=(t,e={"aria-checked":t[O("isActive")],"aria-expanded":t[O("isActive")],"aria-hidden":!t[O("isActive")],"aria-pressed":t[O("isActive")],"aria-selected":t[O("isActive")]})=>Object.keys(e).forEach(r=>t.hasAttribute(r)&&t.setAttribute(r,e[r])),D=(t,e,r=!1)=>`This trigger has the class name '${t}' filled in both attributes '${i}' and '${e}'. As a result, this class will be toggled ${r&&"on its target(s)"} twice at the same time.`,z=(t,e)=>(t.getAttribute(e)||"").split(" ").filter(Boolean),I=t=>{const e=t.hasAttribute(c)?c:A;return L(`${e}="${t.getAttribute(e)}"`).filter(t=>t[O("isActive")])},T=(t,e)=>{t||console.warn(`You should fill the attribute '${e}' with a selector`)},q=(t,e)=>{if(0===e.length)return console.warn(`There's no match with the selector '${t}' for this trigger`),[];const r=t.match(/#\w+/gi);return r&&r.forEach(t=>{const r=[...e].filter(e=>e.id===t.slice(1));r.length>1&&console.warn(`There's ${r.length} matches with the selector '${t}' for this trigger`)}),[...e]},K=(t,e)=>e.forEach(e=>{t.classList.toggle(e)}),j={},B=t=>document.addEventListener(t.getAttribute(h)||t.getAttribute(u)||"click",Y,!1),Y=t=>{const e=t.target,r=t.type;let a=!1;L(d).filter(t=>t.getAttribute(h)===r||t.getAttribute(u)===r&&!t.hasAttribute(h)||"click"===r&&!t.hasAttribute(u)&&!t.hasAttribute(h)).forEach(t=>{const r=e.closest(`[${w}="true"]`);r&&r[O("trigger")]===t&&(a=!0),a||t===e||t.contains(e)||!t[O("isActive")]||(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)}),a||document.removeEventListener(r,Y,!1);const o=e.closest(`[${i}][${d}],[${s}][${d}],[${n}][${d}]`);o&&o[O("isActive")]&&B(e)},C=t=>M(t.currentTarget[O("target")]),H=(t,e,r)=>(t=>{if(t.hasAttribute(b)||t.hasAttribute(f)){const e=t.getAttribute(b)||t.getAttribute(f);return T(e,t.hasAttribute(b)?b:f),q(e,document.querySelectorAll(e))}if(t.hasAttribute(v)){const e=t.getAttribute(v);return T(e,v),q(e,t.parentElement.querySelectorAll(e))}if(t.hasAttribute(E)){const e=t.getAttribute(E);return T(e,E),q(e,t.querySelectorAll(e))}return t.hasAttribute(m)?q("previous",[t.previousElementSibling].filter(Boolean)):t.hasAttribute($)?q("next",[t.nextElementSibling].filter(Boolean)):[]})(t).forEach(i=>{x(i,k),i[O("isActive")]=!i[O("isActive")],S(i),r?i.classList.add(...e):K(i,e),t.hasAttribute(d)&&(i.setAttribute(w,t[O("isActive")]),i[O("trigger")]=t),t.hasAttribute(g)&&(i[O("isActive")]?(j[i]=(t=>e=>{const r=[...t.querySelectorAll("a[href], area[href], input:not([type='hidden']):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]")];if(!r.length||"Tab"!==e.key)return;const i=e.target,n=r[0],s=r[r.length-1];return-1===r.indexOf(i)?(e.preventDefault(),n.focus()):e.shiftKey&&i===n?(e.preventDefault(),s.focus()):e.shiftKey||i!==s?void 0:(e.preventDefault(),n.focus())})(i),document.addEventListener("keydown",j[i],!1)):(document.removeEventListener("keydown",j[i],!1),delete j[i])),x(i,y),((t,e)=>{const r=L(p,t).filter(e=>!e.getAttribute(p)||t.matches(e.getAttribute(p)));if(0!==r.length)e[O("isActive")]?r.forEach(t=>{t[O("target")]||(t[O("target")]=e,t.addEventListener("click",C,!1))}):(r.forEach(t=>{t[O("target")]===e&&(t[O("target")]=null,t.removeEventListener("click",C,!1))}),e.focus())})(i,t)}),M=t=>{x(t,k);const e=(t=>{if(t.hasAttribute(i)&&t.getAttribute(i)&&(t.hasAttribute(s)||t.hasAttribute(n))){const e=z(t,s),r=z(t,n);z(t,i).forEach(i=>{e.includes(i)&&console.warn(D(i,s),t),r.includes(i)&&console.warn(D(i,n,!0),t)})}const e=[i,s,n].reduce((e,r)=>{const a=z(t,r);return(r===i||r===s)&&e.trigger.push(...a),(r===i||r===n)&&e.target.push(...a),e},{trigger:[],target:[]});return!e.trigger.length&&(t.hasAttribute(i)||t.hasAttribute(s))&&e.trigger.push(a),!e.target.length&&(t.hasAttribute(i)||t.hasAttribute(n))&&e.target.push(a),e})(t);return K(t,e.trigger),t[O("isActive")]=!t[O("isActive")],S(t),x(t,y),H(t,e.target,!1),(t=>{if(t.hasAttribute(d))return t.hasAttribute(A)?console.warn(`You can't use '${d}' on a radio grouped trigger`):t[O("isActive")]?B(t):void 0})(t)},R=t=>{const e=I(t);return 0===e.length?M(t):-1===e.indexOf(t)?(e.forEach(M),M(t)):-1===e.indexOf(t)||t.hasAttribute(A)?void 0:M(t)},U=t=>((t[Symbol.iterator]?[...t]:[t]).forEach(t=>{t[O("unbind")]&&t[O("unbind")]()}),t),_=()=>{[...document.querySelectorAll(`[${n}]:not([${b}]):not([${f}]):not([${$}]):not([${m}]):not([${v}]):not([${E}])`)].forEach(t=>{console.warn(`This trigger has the attribute '${n}', but no specified target\n`,t)}),L(l).filter(t=>!t[O("isDefaultInitialized")]).forEach(t=>{if((t.hasAttribute(c)||t.hasAttribute(A))&&I(t).length>0)return console.warn(`Toggle group '${t.getAttribute(c)||t.getAttribute(A)}' must not have more than one trigger with '${l}'`);M(t),t[O("isDefaultInitialized")]=!0});const t=L().filter(t=>!t[O("isInitialized")]);return t.forEach(t=>{const e=e=>{e.preventDefault(),(t.hasAttribute(c)||t.hasAttribute(A)?R:M)(t)},r=t.getAttribute(u)||"click";t.addEventListener(r,e,!1),t[O("unbind")]=()=>{t.removeEventListener(r,e,!1),t[O("isInitialized")]=!1},t[O("isInitialized")]=!0}),L(o).length>0&&!document[O("isEscapeKeyInitialized")]&&(document.addEventListener("keydown",t=>{"Escape"!==t.key&&"Esc"!==t.key||L(o).forEach(t=>{if(t[O("isActive")])return t.hasAttribute(A)?console.warn(`You can't use '${o}' on a radio grouped trigger`):(t.hasAttribute(c)?R:M)(t)})},!1),document[O("isEscapeKeyInitialized")]=!0),L(r).length>0&&!document[O("isArrowKeysInitialized")]&&(document.addEventListener("keydown",t=>{const e=document.activeElement;if(-1===["ArrowUp","ArrowDown","ArrowLeft","ArrowRight","Home","End"].indexOf(t.key)||!e.hasAttribute(i)&&!e.hasAttribute(s)&&!e.hasAttribute(n)||!e.hasAttribute(r))return;if(!e.hasAttribute(c)&&!e.hasAttribute(A))return console.warn(`You can't use '${r}' on a trigger without '${c}' or '${A}'`);t.preventDefault();const a=e.hasAttribute(c)?L(`${c}='${e.getAttribute(c)}'`):L(`${A}='${e.getAttribute(A)}'`);let o=e;switch(t.key){case"ArrowUp":case"ArrowLeft":o=a.indexOf(e)>0?a[a.indexOf(e)-1]:a[a.length-1];break;case"ArrowDown":case"ArrowRight":o=a.indexOf(e)<a.length-1?a[a.indexOf(e)+1]:a[0];break;case"Home":o=a[0];break;case"End":o=a[a.length-1]}return o.focus(),o.dispatchEvent(new Event(o.getAttribute(u)||"click"))},!1),document[O("isArrowKeysInitialized")]=!0),t},F=()=>{_(),document.removeEventListener("DOMContentLoaded",F)};document.addEventListener("DOMContentLoaded",F),window.easyToggleState=Object.assign(_,{isActive:t=>!!t[O("isActive")],unbind:U,unbindAll:()=>U(L().filter(t=>t[O("isInitialized")]))})}();
</script>
<?
*/
 
/* 
### ----------------------Library-xxx debricated ??? ----------------------
if (isset($LIB_POPUPSYSTEM[0]) && array_key_exists(0, $LIB_POPUPSYSTEM) && ($LIB_POPUPSYSTEM[0]==0))
     $switchbox_style = ""; else 
*/

echo "
<style>
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
<!-- // .modal-window header { font-weight: bold; } -->

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

.mdlHeader {
    text-align: center;
    background-color: whitesmoke; /* default */
}
.mdlFooter {
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
.modlButt, .modal__close, .label{
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
	color: #222;                       /* The dialog is light in both themes: dark text (was the light theme text in dark mode) */
	box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.6);
}
.modal .modlButt { color: #222; }

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
	top: 9px;
	right: 10px;
	font-size: 15px;
	font-weight: bold;
	cursor: pointer;
    padding: 3px 6px 1px;
    border: 1px solid;
    border-radius: 5px;
    background: white;
}

.modal__title {
	margin: 0;
}

.modal__header {
	padding: 2px 46px 1px;          /* Room for the close cross (both sides: the title stays centred) */
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
  display: flex;                  /* Tracking and message side by side, the same height */
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

//echo $inis;   // initScript: read CSS given in htm_Page_ parameter

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
 
# Special script: message with auto-timeout
 # function htm_Toast(text, bclr:'#333', fclr:'#fff', tout:5000)
run_Script("function htm_Toast(text, bclr='#333', fclr='#fff', tout=5000) {
    var x = document.getElementById('snackbar');
    if (!x) { x = document.createElement('div'); x.id = 'snackbar'; document.body.appendChild(x); }
        x.innerHTML= text;
        x.className = 'show';
        x.style.background = bclr;
        x.style.color = fclr;
        setTimeout(function(){ x.className = x.className.replace('show', ''); }, tout);
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
    if (isset($LIB_FONTAWESOME) && array_key_exists(0, $LIB_FONTAWESOME) )  {
        if ($LIB_FONTAWESOME[0]>0) {                                                    # if library activated
                if ($LIB_FONTAWESOME[0]==3) $LIB_FONTAWESOME[0]= $autoCDN;              # Auto: Local/CDN
                if ($LIB_FONTAWESOME[0]==1) $path= $gbl_ProgRoot.$LIB_FONTAWESOME[1];   # Local-folder
                else                        $path=               $LIB_FONTAWESOME[2];   # CDN-server 
            echo '<link  href="'.$path.'css/all.min.css" rel="stylesheet" />';      // topic="fontawesome-system" (choose a theme file)
        } else {
            $pageMess.= ' Fontawesome is not loaded - Icons do not work!<br>';
        }
    }
### ----------------------


### ----------------------Library-tinyMCE editor ----------------------
    if (isset($LIB_TINYMCE)) {
        if (array_key_exists(0, $LIB_TINYMCE))
        if ($LIB_TINYMCE[0]>0) {                                             # if library activated
            if ($LIB_TINYMCE[0]==3) $LIB_TINYMCE[0]= $autoCDN;               # Auto: Local/CDN
            if ($LIB_TINYMCE[0]==1) $path= $gbl_ProgRoot.$LIB_TINYMCE[1];    # Local-folder
            else                    $path=               $LIB_TINYMCE[2];    # CDN-server 
            echo '<script src="'.   $path.'tinymce.min.js" referrerpolicy="origin"> </script>';
    }} 
    ## Be aware tinyMCE has its own translate system !
### ----------------------



### ----------------------Library-PDFViewer ----------------------
    if (isset($LIB_PDFVIEW)) {
        if (array_key_exists(0, $LIB_PDFVIEW))
        if ($LIB_PDFVIEW[0]>0) {                                             # if library activated
            if ($LIB_PDFVIEW[0]==3) $LIB_PDFVIEW[0]= $autoCDN;               # Auto: Local/CDN
            if ($LIB_PDFVIEW[0]==1) $path= $gbl_ProgRoot.$LIB_PDFVIEW[1];    # Local-folder
            else                    $path=               $LIB_PDFVIEW[2];    # CDN-server 
            echo "<script type=\"module\">
            import * as pdfjsLib from '".$path."pdf.min.mjs';                                          // pdf.js 4+ is an ES module
            pdfjsLib.GlobalWorkerOptions.workerSrc = '".$path."pdf.worker.min.mjs';                    // Worker: same version as the library
            document.addEventListener('contextmenu', event => event.preventDefault());                  // Disable Canvas Image Downloading    
            var url = ".json_encode($pdf_file ?? '')." || ((document.getElementById('the-canvas') || {dataset:{}}).dataset.pdf || ''); // From <canvas data-pdf=...>; your file location and file name with ext.    // If absolute URL from the remote server is provided, configure the CORS
                                                                                                        // header on that server.

            var pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                scale = 2,
                canvas = document.getElementById('the-canvas'),
                ctx = canvas ? canvas.getContext('2d') : null;

           function renderPage(num) {              /** Get page info from document, resize canvas accordingly, and render page. @param num Page number. */
              pageRendering = true;
              pdfDoc.getPage(num).then(function(page) {             // Using promise to fetch the page
                var viewport = page.getViewport({scale: scale});
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                var renderContext = {                               // Render PDF page into canvas context
                  canvasContext: ctx,
                  viewport: viewport
                };
                var renderTask = page.render(renderContext);
                renderTask.promise.then(function() {                // Wait for rendering to finish
                  pageRendering = false;
                  if (pageNumPending !== null) {
                    // New page rendering is pending
                    renderPage(pageNumPending);
                    pageNumPending = null;
                  }
                });
              });
              document.getElementById('page_num').textContent = num;    // Update page counters
            }

           function queueRenderPage(num) { /** If another page rendering in progress, waits until the rendering is finised. Otherwise, executes rendering immediately. */
              if (pageRendering) {
                pageNumPending = num;
              } else {
                renderPage(num);
              }
            }

            function onPrevPage() {         /** Displays previous page. */
              if (!pdfDoc || pageNum <= 1) {    // (not loaded yet)
                return;
              }
              pageNum--;
              queueRenderPage(pageNum);
            }
            var b_prev= document.getElementById('prev');                        // type=button: inside a card form a <button> would submit (reload the page)
            if (b_prev) { b_prev.type= 'button';  b_prev.addEventListener('click', onPrevPage); }

            function onNextPage() {         /** Displays next page. */
              if (!pdfDoc || pageNum >= pdfDoc.numPages) {    // (not loaded yet)
                return;
              }
              pageNum++;
              queueRenderPage(pageNum);
            }
            var b_next= document.getElementById('next');                        // type=button: inside a card form a <button> would submit (reload the page)
            if (b_next) { b_next.type= 'button';  b_next.addEventListener('click', onNextPage); }

            function pdfFail(err) {     /** The PDF could not be loaded: say so instead of an empty canvas */
              var m= document.createElement('p');
              m.style.color= '#c62828';
              m.textContent= ".json_encode(lang('@The PDF file could not be shown:'))." + ' ' + url + ' (' + ((err && err.message) || err) + ')';
              canvas.insertAdjacentElement('beforebegin', m);
            }
            function pdfLoad(src) {     /** Load a PDF: {url: ...} or {data: bytes} (pdf.js 6 refuses a plain string) */
              try {
                pdfjsLib.getDocument(src).promise.then(function(pdfDoc_) {
                  pdfDoc = pdfDoc_;  pageNum = 1;
                  document.getElementById('page_count').textContent = pdfDoc.numPages;
                  queueRenderPage(pageNum);    // The first page
                }, pdfFail);
              } catch (err) { pdfFail(err); }         // (An error thrown at once - not a rejected promise)
            }
            if (url && canvas) pdfLoad({url: url});
            document.addEventListener('change', function(e) {   /** A PDF chosen in a file field (accept=.pdf) is shown in the viewer (was: nothing happened) */
              var f = e.target;
              if (!canvas || !f.matches || !f.matches('input[type=file]') || !/pdf/i.test(f.accept || '') || !f.files || !f.files[0]) return;
              f.files[0].arrayBuffer().then(function(b) { url = f.files[0].name;  pdfLoad({data: new Uint8Array(b)}); }, pdfFail);
            });
            </script>";
    }} 
    ## 
### ----------------------


    echo $CSS_system;    // Activate the system style
    echo $GLOBALS['CSS_theme'] ?? '';   // Dark theme + dialog style
    set_Style('type="text/css"', '<!--  @font-face { font-family: barcode; src: url('.$gbl_ProgRoot.'_accessories/barcode.ttf); } --> ');
    
    set_Style('type="text/css"', 
              'body { background: left top no-repeat; background-size: 100% 100%; font-family: sans-serif; '.
               $attr.' '.(($imag>'') ? ' background-repeat: repeat; background-size: 225px; background-image: url('.$imag.')}' : '')
    );
    
    $sideTxt= '';   # The vertical edge texts are written after <body> (a <div> in <head> ends the head early)
    if ($info>'')   // Page into (vertical text - right)
        $sideTxt.= '<div class="p2hSideTxt" style="position: fixed; z-index: 99; float: right; display: inline-block; width: max-content; line-height: 14px;line-height: 14px; right: 0;
            transform-origin: bottom left; transform: rotate(-90deg); translate: 100% 85vh; white-space: nowrap; 
            padding: 2px; background-color:#ddddddbd;"><span style="font-size: 0.8em;">'.lang($info).'</span></div>';

    if ($hint>'')   // Page tip  (vertical text - left)
        $sideTxt.= '<div class="p2hSideTxt" style="position: fixed; width: min-content; line-height: 14px; bottom: -10px; left: 0px; z-index: 99;
            transform-origin: top left; transform: rotate(-90deg); white-space: nowrap; padding: 2px; background-color:#ddddddbd;" '.
            'title="'.lang('@CTRL-Scroll UP/Down mousewheel to zoom window content.').'">'.
    // '<data-hint>CTRL-Scroll UP/Down mousewheel to zoom window content</data-hint>'.
            '<small>'.lang($hint).'</small></div>';
    // echo '<div class="ver_right"; style="color:red;">[[[[[[[[[HHHHH__HHHHHH]]]]]]]]]]</div>';

    echo $javaScripts;
    
    echo $sys_Style;

    $cc= trim((string)($GLOBALS['gbl_CustomCss'] ?? ''));     # Project CSS (project init file): CSS text, or the address of a .css file
    if ($cc > '') echo (!str_contains($cc, '{') && preg_match('/\.css(\?.*)?$/i', $cc))
                        ? '<link rel="stylesheet" href="'.sys_enc($cc).'">'."\n"
                        : "<style>\n".$cc."\n</style>\n";
    if ($inis>'')            echo $inis;            // read CSS/js given in htm_Page_ parameter
    // if ($lateScripts > '') echo $lateScripts;    // run_Script($lateScripts);
    if ($headEndScript > '') run_Script($headEndScript);
    if ($headBuf) echo p2h_assetFiles(ob_get_clean());
    

    echo "\n</head>\n
             <body>\n";
    echo $sideTxt;

    echo '<a class="p2hSkip" href="#p2hMain" data-skip="main">'.lang('@Skip to the content').'</a>'.
         '<a class="p2hSkip" href="#" data-skip="tools">'.lang('@Go to the view tools').'</a>'.
         '<h1 class="p2hVisHidden">'.sys_enc(strip_tags(lang($titl))).'</h1>';          # The page title as heading (screen readers)
    if ($pageMess > '<b>ERROR:</b> ') echo $pageMess;
    
    if ((isset($imag)) and ($imag>'')) $image= 'background-image: url(\''.$imag.'\');'; else  $image= '';
    echo '<main id="p2hMain" style="text-align: '.$algn.'; '.$image.' margin: auto; ">';   # The page content as <main> (landmark for screen readers)
    if ($pbrd) echo '<div style="border: 2px solid #AAA; border-radius: 8px; overflow: hidden; margin: auto;" >'; // margin: 24px 4px 4px;
    # Column view (button in htm_ViewBar): the cards flow in columns. Container = the innermost page element; the saved choice is
    # applied right here, before the cards are drawn (no jump).
    echo '<script>(function(){ var c= document.getElementById("p2hMain"); if ('.($pbrd ? 'true' : 'false').') c= c.lastElementChild;
          c.setAttribute("data-p2h-cols", "1");  try { if (localStorage.getItem("p2h-colview")==="1") c.classList.add("p2hColview"); } catch(e) {} })();</script>';
} // htm_Page_()

# A paragraf with border, can be used as a page-footer, or separator on a page.
function htm_Page_Sect(# body,styl:'border: 1px solid #888; border-radius: 8px; overflow: hidden; margin: auto; background-color:white;')
    $body,  
    $styl='border: 1px solid #888; border-radius: 8px; overflow: hidden; margin: auto; background-color:white;'
    )
{   echo '<p style="'.$styl.'">'.lang($body).'</p>';
}

# Finalize the htm_Page_()
function htm_Page_end()
{ global $gbl_CardIx, $cardCount, $gbl_ProgRoot, $sys_Style, $javaScripts, $bodyEndScript, $pbrd, $gbl_Imag;
    $cardCount= $gbl_CardIx;
    if ($pbrd) echo '</div>';   // Started in htm_Page_()
    echo '</main>';             // $align - <main> started in htm_Page_()
    //Menu_Bottom();
    // echo '<div id="snackbar">Short message</div>';
    CardInit($cardCount ? $cardCount : 15);
    // echo $javaScripts;
    // echo $sys_Style;
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
    $url= $gbl_ProgRoot.'../spormig.php';
    $url= './../spormig.php';
    // $url= 'https://ev-soft.work/spormig.php';
    // echo $url;
#    if (is_readable($url)) { include($url); echo '+'; } else echo 'o';
    // if (is_readable('../'.$url)) { include('../'.$url); echo '+'; } else echo '-';
    // if (is_readable('../../'.$url)) { include('../../'.$url); echo '+'; } else echo '-';


    htm_nl(2);
    # Session warning: the session ends after session.gc_maxlifetime without a request. While the user works, a light request keeps
    # it alive; after a pause a dialog asks 2 minutes before the end; after the end a notice says to reload (a POST would be refused).
    $life= (int)ini_get('session.gc_maxlifetime');
    if (($GLOBALS['gbl_SessionWarn'] ?? true) and ($life >= 300))
        echo '<script>(function(){
  if (!document.querySelector("input[name=csrf_token], [data-csrf]:not(.p2hLang)")) return;     /* Nothing to post on this page (the language button does not count) */
  var L= '.($life*1000).', W= 120000, KEY= "p2h-session-last", tWarn= null, tEnd= null, asking= false, last= Date.now();
  function share() { try { localStorage.setItem(KEY, String(last)); } catch(e) {} }                  /* Every tab knows the last request */
  function newest() { var v= 0; try { v= +localStorage.getItem(KEY) || 0; } catch(e) {}  return Math.max(last, v); }
  var T= '.json_encode(['title'=>strip_tags(lang('@Still working?')), 'warn'=>strip_tags(lang('@Your session ends in 2 minutes. Continue?')),
                        'gone'=>strip_tags(lang('@Your session has ended. Copy any text you have written, then reload the page before you save.')),
                        'reload'=>strip_tags(lang('@Reload'))]).';
  function ping() { last= Date.now();  share();  fetch(location.pathname + "?p2h_keepalive=1", {credentials: "same-origin", cache: "no-store"}).catch(function(){});  plan(); }
  function plan() { last= newest();  var left= last + L - Date.now();  clearTimeout(tWarn);  clearTimeout(tEnd);
                    tWarn= setTimeout(warn, Math.max(0, left - W));  tEnd= setTimeout(ended, Math.max(0, left)); }
  var gone= false, dlg= null;
  function over() { return Date.now() - newest() >= L; }                             /* The session has ended (timers can sleep in a background tab) */
  function warn() { if (newest() > last) { plan(); return; }                           /* Another tab kept the session alive */
                    asking= true;  sysConfirm(T.warn, function() { asking= false;  dlg= null;  if (over()) ended(); else ping(); }, T.title,
                                              function() { asking= false;  dlg= null; });
                    var ds= document.querySelectorAll("dialog.p2hDlg");  dlg= ds[ds.length - 1] || null; }
  function ended() {
    if (gone) return;
    if (newest() > last) { plan(); return; }
    gone= true;  asking= false;
    if (dlg) { try { dlg.close(); } catch(e) {}  dlg.remove();  dlg= null; }          /* "Continue?" is too late now */
    var d= document.createElement("div");  d.className= "p2hAlert p2hAlert-warning p2hSessionEnd";  d.setAttribute("role", "alert");
    d.textContent= T.gone + " ";
    var b= document.createElement("button");  b.type= "button";  b.textContent= T.reload;  b.onclick= function() { location.reload(); };
    d.appendChild(b);  document.body.appendChild(d);
  }
  ["keydown", "pointerdown", "input"].forEach(function(ev) {                       /* Activity: keep alive (at most every third of the time) */
    addEventListener(ev, function() { if (gone || asking) return;  if (over()) { ended(); return; }
                                      if (Date.now() - newest() > L / 3) ping(); }, {capture: true, passive: true});
  });
  addEventListener("storage", function(e) { if (e.key === KEY) plan(); });          /* Another tab made a request: count from there */
  share();  plan();                                                                   /* This page load was a request too */
})();</script>';
    # Output after htm_Page_end() (e.g. CardOff(), run_Script() in the page) must stay inside <body>: it is collected and the
    # document is closed when the script ends - before PHP flushes the output buffers. (Was: <script>s after </html>.)
    $lvl= ob_get_level();  ob_start();
    register_shutdown_function(function() use ($lvl) {
        $late= '';  while (ob_get_level() > $lvl) $late= ob_get_clean().$late;
        echo $late, "\n  </body>", '</html>';       // <body> started in htm_Page_()
    });
} # htm_Page_end

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
    return $result= "<span style='color:red;'>'".htmlspecialchars($usr_name)."' => '".password_hash($usr_code, PASSWORD_BCRYPT)."',</span>". ' '.'//'.' '.$usr_code;
}
/* 
function calcHash($usr_name,$usr_code) 
{   // Klartekst-password vises IKKE i output - kun hash
    return $result= "<span style='color:red;'>'".htmlspecialchars($usr_name)."' => '".password_hash($usr_code, PASSWORD_BCRYPT)."',</span>";
} */


// String-output:
# String function: make italic-text
function htm_Ihead(# html) ):
    $html)             {echo '<br/><i>'.$html.'</i> ';}
# String function: make horisontal line/ruler
function htm_hr(# colr:'#0',attr:'')   
    $colr='#0',$attr='') {echo '<hr style="background-color:'.$colr.';'.$attr.'"/>';}
# String function: Add one or more line-breaks
function htm_br(# rept:1)   
    $rept=1)            {echo str_repeat('<br />',$rept);}
# String function: Add one ore more new line(s)
function htm_nl(# rept:1)
    $rept=1)            {echo str_repeat('<br />',$rept);}
# String function: Add one or more linefeed
function htm_lf(# rept:1)  
    $rept=1)            {echo str_repeat(' &#xa;',$rept);}  //  LineFeed
# String function: Add one ore more nobreaking spaces [Necessary basic element]
function htm_sp(# rept:1) 
    $rept=1)            {echo str_repeat('&nbsp;',$rept);}
# String function: Make a span with given width
function htm_space(# wdth)  
    $wdth)              {echo '<span style="width:'.$wdth.'; display:inline-block; ">&nbsp;</span>';}

// String-functions:
function str_bold($source,$result='',$tail='&nbsp;&nbsp;') {return $result.'<b>'.$source.'</b>'.$tail;}
function str_Ihead($source)         {return '<br /><i>'.$source.'</i> ';}
function str_hr($c='#0',$attr='')   {return '<hr style=\'color:'.$c.';'.$attr.'\'/>';}
function str_br($rept=1)            {return str_repeat('<br />',$rept);}
function str_nl($rept=1)            {return str_repeat('<br />',$rept);}
function str_lf($rept=1)            {return str_repeat(' &#xa;',$rept);}  //  LineFeed in strings:  &#010;  &#xa;  \n \u000A  \x0A  &#13;  %10%13  %0D%0A    PHP_EOL
function str_sp($rept=1)            {return str_repeat('&nbsp;',$rept);}
function str_space($wdth)           {return '<span style="width:'.$wdth.'; display:inline-block; ">&nbsp;</span>';}

function markFirstChar($str='',$tag='u',$att='') 
{ $str= lang($str); $str= '<'.$tag.' '.$att.'>'.substr($str,0,1).'</'.$tag.'>'.substr($str,1); return $str; }
function markAllChars($str='',$tag='u',$att='')  
{ $str= lang($str); $str= '<'.$tag.' '.$att.'>'.$str.'</'.$tag.'>'; return $str; }

function toNum($test='')
{ return sys_toFloat($test); }

# A number written as "1 234,50" / "1.234,50" / "1234.50" / "87 %" / "kr. 12,5" -> float  ((float)"1 234,50" gives 1)
function sys_toFloat($v) {
    if (is_int($v) or is_float($v)) return (float)$v;
    $s= str_replace([' ', "\u{00A0}", "\u{202F}"], '', (string)$v);   # Thousands separators: space, nbsp, narrow nbsp
    if (DecimalSep !== ',') $s= str_replace([ThousandsSep, ','], '', $s);       # Decimal point (DecimalSep "."): commas are thousands
    elseif (strpos($s, ',') !== false) $s= str_replace(['.', ','], ['', '.'], $s);  # Comma is the decimal sign: dots are thousands
    return preg_match('/-?\d+(\.\d+)?/', $s, $m) ? (float)$m[0] : 0.0;
}

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
        if (is_readable('./_trans.sys.json'))
             $content = file_get_contents('./_trans.sys.json');
        else $content = file_get_contents($gbl_ProgRoot.'_trans.sys.json');
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
        }; // else htm_toast('File error reading: _trans.sys.json !','yellow','black');
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
if (isset($_POST['language']) and is_string($_POST['language']) and preg_match('/^[a-z]{2}(-[A-Za-z]{2})?$/', $_POST['language'])) {
    $lang = $_POST['language'];                                 # Accept only language codes
    $langOk= (function_exists('csrf_verify') && csrf_verify());     # Remembered only from a genuine form of this site (CSRF token)
    if ($langOk) $_SESSION['p2h_lang']= $lang;                  #   - for the next pages
    if ($langOk and isset($_POST['p2h_langOnly']) and !headers_sent()) {
        header('Location: '.($_SERVER['REQUEST_URI'] ?? './'), true, 303);   # From htm_LangSelect(): show the same page again (GET)
        exit;
    }
}
elseif (isset($_SESSION['p2h_lang']) and is_string($_SESSION['p2h_lang'])) $lang = $_SESSION['p2h_lang'];
if (!isset($lang)) $lang = 'en';                        // Default language english
$allLang= $englishOnly ? [] : sys_get_translations();   # (Also defined with $englishOnly - was: Undefined variable)
if ($allLang) {
    $natindx = array_search($lang, array_column($allLang, 'code')); //  echo $natindx;
    $engindx = array_search('en',  array_column($allLang, 'code')); //  echo $engindx;
    if ($natindx === false) $natindx = $engindx;               // Unknown language: use English
}

if (!function_exists('lang')) { ## Be aware tinyMCE has its own translate system !
    function lang(# text)     # lang() is used to translate all hard-coded user interface
    $text           # String: Frase to be transated, with prefix: '@ and with suffix: '
    )
    {   global  $natindx, $engindx, $allLang, $lang;
        $text= trim($text,"@");
        $tr= $allLang[$natindx]['translation'][$text] ?? ($allLang[$engindx]['translation'][$text] ?? null);   # National, else translated English
        if ($tr === null) return $text;                                  # Default English, if not in the translate table
        if ((substr($text, -1) === ' ') and (substr($tr, -1) !== ' ')) $tr.= ' ';   # "@Warning: " keeps its space (the translations had lost it)
        return $tr;
    }
}

/**
 * Encode html entities
 * @param string $text
 * @return string
 */
function sys_uid($id)       # A unique element id on the page: the first keeps its id, repeats get _2, _3... (fields in loops, table rows)
{
    static $used= [];
    $id= ($id === '') ? 'missing' : $id;
    if (!isset($used[$id])) { $used[$id]= 1;  return $id; }
    do { $uid= $id.'_'.(++$used[$id]); } while (isset($used[$uid]));
    $used[$uid]= 1;  return $uid;
}

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
    $Result.= '<select class="styled-select" id="'.sys_uid(preg_replace('/[^A-Za-z0-9_\-]/', '', $name)).'" name="'.$name.
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
        function str_Synt_()  {return '<pre class="synt">';}
        function str_Synt_end() {return '</pre>';}
        function str_Synt($elem='',$type='default') { return '<span class="synt-'.$type.'">'.$elem.'</span>'; }
        
/* 
        function str_Pars($source) {
    #   htm_Fields_(                                                   # funcName
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
            echo str_Synt_().$result.'<br>'.str_Synt(substr($funcTail,0,2),'default').str_Synt(substr($funcTail,2),'comment').str_Synt_end();
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
    --lablBgrnd: #f0ffff;   /* FloralWhite; */
    --cardsTitl: #ffffff00; /* Transparent */
    --oranColor: #F37033;
    --brunColor: #550000;   /*  Table borders  */
    --grayColor: #aca9a870; /* #ACA9A8; */
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
    --CardsBgrd: '.p2h_cssColor($GLOBALS['gbl_CardsBgrd'] ?? '', 'white').';
    --Wall_Bgrd : '.p2h_cssColor($GLOBALS['ØWall_Bgrd'] ?? '', '#f4f4f4').';
    --ButtnBgrd: #44BB44;   /* LysGrøn   */
    --ButtnText: #FFFFFF;   /* Hvid   */
    --BtLnkBgrd: #FCFCCC;   /* LysGul  */
    --BtLnkText: #000000;   /* Sort   */
    --ButtnShad: #bcbcbc;   /* Knap skygge (lysgrå)  */
    --PageBcgrd: #333333;   /* Side baggrund (lysblå) F4FFF4  */
    --PageBcgrd: '.p2h_cssColor($GLOBALS['gbl_PageBcgrd'] ?? '', '#e6e8ea').';  /* Set $gbl_PageBcgrd in project.init.php */
    --TextColr: #222222;    /* Normal text (theme) */
    --InptBgrd: #ffffff;    /* Input fields (theme) */
    --LinkColr: #0645ad;    /* Links (theme) */
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
    .RowCol240  {width: 240px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol280  {width: 280px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol320  {width: 320px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol400  {width: 400px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol480  {width: 480px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol640  {width: 640px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol720  {width: 720px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol800  {width: 800px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol960  {width: 960px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowCol1100 {width:1100px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    .RowColsaut {width: auto;   padding: 5px 0px 5px 5px; margin: 5px 0px 5px 0px; float: left;}
    data-PanlHead, PanlFoot  {clear: both;   padding: 0 5px;}
}

 /* for 960px or less */
@media screen and (max-width: 960px) {
    #colnwrap   {width: 99%;  }
    .RowCol320  {width: 41%;  padding: 5px 5px;   margin: 0px 0px 5px 5px;}
    .RowColsaut {width: auto; padding: 5px 5px;   margin-left: 0px;   clear: both;    float: none;  }
    data-PanlHead, PanlFoot {padding: 1px 5px;   clear: both;}
}

 /* for 640px or less */
@media screen and (max-width: 640px) {
    .RowCol320  {width: auto;  float: none;  margin-left: 5px; }
    .RowColsaut {width: auto;  float: none;  margin-left: 5px; }
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
@media screen and (max-width: 760px) { .p2hSideTxt { display: none !important; } }   /* Vertical edge texts: no room on phones */
@media screen and (max-width: 760px) { .p2hLeftMenu { position: static !important; margin: 8px auto !important; } }   /* Left menu: in the flow, not over the text */
.p2hVisHidden { position: absolute !important; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }
/* A card with an unknown class (e.g. an old name) is still a box - else the resize grip lands in the middle below it */
:where([id^=card]) { display: inline-block; }
.cardWmax { width:  99%;   }
.cardWaut { width: auto;   }
.cardW120 { width: 1200px; }
.cardW110 { width: 1100px; }
.cardW100 { width: 1020px; }
/* Narrow screens: a fixed-width card is never wider than the window (no sideways page scrolling on phones) */
.cardW120, .cardW110, .cardW100, .cardW960, .cardW800, .cardW720, .cardW640, .cardW560, .cardW480,
.cardW400, .cardW320, .cardW280, .cardW240, .cardW160 { max-width: min(100%, calc(100vw - 32px)); box-sizing: border-box; }   /* (100vw includes the scrollbar) */
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
    box-shadow: 3px 3px 4px var(--ButtnShad);
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
    border: 2px solid var(--grayColor);
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
[role=button][tabindex]:focus-visible { outline: 2px solid var(--AccnColr, DarkGreen); outline-offset: 2px; }   /* Keyboard focus */
/* htm_Alert / htm_Banner / htm_Badge / htm_ConfirmPostLink / htm_TableTools (from NH-logistik) */
.p2hAlert { margin: 10px auto; padding: 11px 15px; border: 1px solid; border-radius: 6px; text-align: left; column-span: all; }
.p2hAlert-success { background: #d4edda; color: #155724; border-color: #a9d8b4; }
.p2hAlert-error   { background: #f8d7da; color: #721c24; border-color: #efb1b8; }
.p2hAlert-warning { background: #fff3cd; color: #664d03; border-color: #f2d98a; }
.p2hAlert-info    { background: #d1ecf1; color: #0c5460; border-color: #9fd3dd; }
[data-p2h-vars] .p2hAlert-success { background: #1d3a26; color: #b8f0c6; border-color: #2f6b41; }
[data-p2h-vars] .p2hAlert-error   { background: #42201f; color: #ffc9c4; border-color: #7a3a36; }
[data-p2h-vars] .p2hAlert-warning { background: #3d3412; color: #ffe8a3; border-color: #6e5d1f; }
[data-p2h-vars] .p2hAlert-info    { background: #133a42; color: #b9eaf3; border-color: #286b78; }
.p2hBanner { margin: 0 auto 14px; padding: 9px 14px; border-left: 5px solid; border-radius: 4px; text-align: left; column-span: all;
    background: var(--CardsBgrd, #fff); color: var(--TextColr, #222); box-shadow: 0 1px 3px rgba(0,0,0,0.15); }
.p2hBanner-info { border-color: #0b7285; }  .p2hBanner-warning { border-color: #e0a800; }
.p2hBanner-danger { border-color: #c62828; }  .p2hBanner-success { border-color: #1a7f37; }
.p2hBadge { display: inline-block; padding: 2px 9px; border-radius: 10px; font-size: 11px; font-weight: 700; line-height: 1.5; vertical-align: middle; }
.p2hBadge-primary { background: #0d6efd; color: #fff; }  .p2hBadge-secondary { background: #5c636a; color: #fff; }
.p2hBadge-success { background: #1a7f37; color: #fff; }  .p2hBadge-danger    { background: #c62828; color: #fff; }
.p2hBadge-warning { background: #ffc107; color: #222; }  .p2hBadge-info      { background: #0b7285; color: #fff; }
.p2hConfirmPost { padding: 5px 14px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; }
.p2hConfirmPost:hover { filter: brightness(1.12); }
.p2hTableTools { display: flex; gap: 12px; align-items: center; justify-content: center; margin: 6px 0; flex-wrap: wrap; }
.p2hTtSearch { position: relative; }
.p2hTtSearch ic { position: absolute; left: 8px; top: 50%; transform: translateY(-50%); opacity: 0.6; font-size: 12px; }
.p2hTtSearch input { padding: 5px 8px 5px 26px; border: 1px solid var(--grayColor, #aaa); border-radius: 4px; width: 200px; }
.p2hTtCount { font-size: 12px; opacity: 0.8; }
.p2hTtSort { cursor: pointer; }
.p2hTtSort[aria-sort=ascending]::after  { content: " \25B2"; font-size: 0.8em; }
.p2hTtSort[aria-sort=descending]::after { content: " \25BC"; font-size: 0.8em; }
/* Card size grip (lower right corner of every card) */
.p2hCardGrip { position: absolute; right: 1px; bottom: 1px; width: 14px; height: 14px; cursor: nwse-resize; touch-action: none; opacity: 0.45; z-index: 3;
    background-image: linear-gradient(135deg, transparent 0 5px, currentColor 5px 6px, transparent 6px 8px, currentColor 8px 9px, transparent 9px 11px, currentColor 11px 12px, transparent 12px 100%); }
.p2hCardGrip:hover, .p2hCardGrip:focus-visible { opacity: 0.9; }
@media (hover: none) { .p2hCardGrip { width: 22px; height: 22px; } }    /* Bigger on touch screens */
abbr.hint.p2hGripHint { position: absolute; right: 0; bottom: 0; z-index: 3; text-decoration: none; }
abbr.hint.p2hGripHint:hover data-hint, abbr.hint.p2hGripHint:focus-within data-hint { left: auto; top: auto; right: 4px; bottom: 18px; width: 240px; }
.p2hGripCol, .p2hColview .p2hGripTxt { display: none; }
.p2hColview .p2hGripCol { display: inline; }                    /* Column view: only the height can be dragged */
/* htm_Table() row actions (suffix type rowact) */
.p2hRowAct { background: none; border: 0; padding: 1px 3px; cursor: pointer; box-shadow: none; font-size: 13px; }
.p2hRowAct:hover, .p2hRowAct:focus-visible { background: rgba(127,127,127,0.18); border-radius: 3px; }
/* htm_Table(): inputs in the cells - transparent (the zebra stripe shows) and almost the cell width (were inline in every cell) */
table.tablesorter > tbody > tr > td > input:not([type=hidden]):not([type=checkbox]):not([type=date]) { background-color: transparent; width: 98%; }
table.tablesorter > tbody > tr > td > input[type=date] { background-color: transparent; }
/* Card order (p2hCardMove): the handle, the card being moved, "Arrange cards" mode */
abbr.hint.p2hMoveHint { position: absolute; left: 1px; top: 6px; z-index: 2; text-decoration: none; }
abbr.hint.p2hMoveHint:hover data-hint, abbr.hint.p2hMoveHint:focus-within data-hint { left: 18px; top: 0; }
.p2hMoveIc { touch-action: none; cursor: grab !important; opacity: 0.55; }
.p2hMoveIc:hover, .p2hMoveIc:focus-visible { opacity: 1; }
[data-p2h-move=header] [id^=chead], .p2hArrange [data-p2h-move=toggle] [id^=chead] { cursor: grab; }
.p2hArrange [data-p2h-move=toggle] { outline: 2px dashed var(--AccnColr, DarkGreen); outline-offset: 2px; }
.p2hMoving { opacity: 0.6; outline: 2px dashed var(--AccnColr, DarkGreen) !important; outline-offset: 2px; }
.p2hDragging, .p2hDragging * { user-select: none !important; cursor: grabbing !important; }
/* htm_Card_end(foot:, subm:) - the card footer: below the scrolling body, hidden when the card is folded */
.p2hCardFoot { border-top: 2px solid var(--grayColor, #ccc); margin: 2px 4px 0; padding: 6px 8px 4px; text-align: center; display: flex;
    flex-wrap: wrap; align-items: center; justify-content: center; gap: 4px 12px; }
:has(> [id^=HideBody][style*="display: none"]) > .p2hCardFoot { display: none; }
[id^=card]:has(> [id^=HideBody][style*="display: none"], > form > [id^=HideBody][style*="display: none"]) > .p2hGripHint { display: none; }   /* Folded card: no grip */

abbr.hint:hover data-hint, abbr.hint:focus-within data-hint, .inpField:focus-within > abbr.hint data-hint {
    /* opacity: 0;    transition: opacity 2s;    transition-delay: 1s; */
    display: block;
    position: absolute;     /* this will let you align the popup with flexibility */
/*  left: 20px;             /* change this depending on how far from the left you want it align */
/*  top: -30px;             /* change this depending on how far from the top you want it to align */
/*  data-hint.style.left = ((el.clientX + data-hint.offsetWidth)  >= window.innerWidth) ?  ((el.clientX - data-hint.offsetWidth))+"px"  : (el.clientX)+"px";
/*  data-hint.style.top =  ((el.clientY + data-hint.offsetHeight) >= window.innerHeight) ?  (el.clientY - data-hint.offsetHeight)+"px"  : (el.clientY)+"px"; */
    width: 200px;           /* give this your own width */
    min-width: 160px;

    border: solid 1px #aaa;
    border-radius: 6px;
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
    /* padding: 24px 0 0 0; */
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
    background: #1A6E1A;
    opacity: 0.9;
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

# Dark theme: overrides the palette variables, plus the most common hard-coded inline colors.
# Activated by <html data-theme="dark"> (set by p2h_themeBoot() / p2hSetTheme()).
$CSS_theme = '
<style>
[data-theme="dark"] {
    color-scheme: dark;
    --PageBcgrd: #15181c;  --CardsBgrd: #1f2328;  --Wall_Bgrd: #181b1f;  --TextColr: #e3e3e3;
    --InptBgrd: #2a2f36;   --LinkColr: #8ab4f8;   --lablColor: #f0c8a0;  --lablBgrnd: #20262c;
    --grayColor: #5a5f66;  --FieldBord: #555b62;  --FieldBgrd: #2a2f36;  --shadColor: #00000066;
    --ButtnShad: #000000;  --HintsBgrd: #2b3036;  --HintsText: #eeeeee;  --tblRowDrk: #2a2f36;
    --tblRowLgt: #23272d;  --BtLnkBgrd: #3a3a20;  --BtLnkText: #eeeeee;  --fltBgColr: #2a2f36;
    --fltTxColr: #f0c8a0;  --btnTxNorm: #eeeeee;  --brunColor: #c08080;  --xx33Color: #22394a;
    --AccnColr: #8fd18f;
}
:where(:root) { --AccnColr: DarkGreen; }   /* Accent: card titles/icons, OK buttons. :where() = no specificity, so the dark block wins */
[data-p2h-vars] body { background: var(--PageBcgrd) !important; background-image: none !important; color: var(--TextColr); }
[data-p2h-vars] a { color: var(--LinkColr); }
[data-p2h-vars] a.button, [data-p2h-vars] a.button:visited {   /* htm_LinkButt: white text on a darker green (not the link color) */
    color: #ffffff !important; background-color: #2e7d32 !important; }
[data-p2h-vars] a.button:hover { background-color: #388e3c !important; }
[data-p2h-vars] .buttstyl { background-color: var(--InptBgrd) !important; color: var(--TextColr) !important; border-color: #5a6370 !important; }
[data-p2h-vars] input, [data-p2h-vars] textarea, [data-p2h-vars] select,
[data-p2h-vars] .boxStyle, [data-p2h-vars] .inpField input {
    background-color: var(--InptBgrd) !important; color: var(--TextColr) !important; border-color: var(--grayColor); }
[data-p2h-vars] .cardsTitl, [data-p2h-vars] [style*="DarkGreen" i],
[data-p2h-vars] [style*="color: green" i], [data-p2h-vars] [style*="color:green" i] { color: var(--AccnColr) !important; }
[data-p2h-vars] .pagination { background: var(--CardsBgrd) !important; color: var(--TextColr); }   /* PDF viewer: "Page: 1 / 2" */
[data-p2h-vars] [style*="background-color: white" i], [data-p2h-vars] [style*="background-color:white" i],
[data-p2h-vars] [style*="background: white" i],       [data-p2h-vars] [style*="background:white" i],
[data-p2h-vars] [style*="background-color: #fff" i],  [data-p2h-vars] [style*="background-color:#fff" i],
[data-p2h-vars] [style*="background-color: ivory" i], [data-p2h-vars] [style*="background-color:ivory" i],
[data-p2h-vars] [style*="background-color: lightyellow" i], [data-p2h-vars] [style*="background-color:lightyellow" i],
[data-p2h-vars] [style*="background-color:lightcyan" i],    [data-p2h-vars] [style*="background-color: lightcyan" i],
[data-p2h-vars] [style*="background-color: lightgray" i],   [data-p2h-vars] [style*="background-color:lightgray" i],
[data-p2h-vars] .mnu_heads {
    background-color: var(--CardsBgrd) !important; color: var(--TextColr); }
[data-p2h-vars] [style*="color: black" i], [data-p2h-vars] [style*="color:black" i],
[data-p2h-vars] [style*="color:#550000" i], [data-p2h-vars] [style*="color: #550000" i],
[data-p2h-vars] [style*="color:#500000" i], [data-p2h-vars] [style*="color: #500000" i],
[data-p2h-vars] [style*="color: #000000" i], [data-p2h-vars] [style*="color:#000000" i],
[data-p2h-vars] [style*="color: #000;" i],   [data-p2h-vars] [style*="color:#000;" i] { color: var(--TextColr) !important; }
/* 3. The vertical page texts at the left / right edge (htm_Page_ hint / info) */
[data-p2h-vars] [style*="background-color:#ddddddbd" i] { background-color: #2a2f36cc !important; color: var(--TextColr) !important; }
[data-p2h-vars] .tablesorter-blue, [data-p2h-vars] .tablesorter-blue td { background-color: var(--tblRowLgt) !important; color: var(--TextColr) !important; border-color: #3a3f46 !important; }
[data-p2h-vars] .tablesorter-blue tbody > tr.even > td { background-color: var(--CardsBgrd) !important; }
[data-p2h-vars] .tablesorter-blue tbody > tr.odd > td  {   /* Zebra stripe: a clear shade of the card color (dark and custom themes) */
    background-color: color-mix(in srgb, var(--CardsBgrd) 86%, var(--AccnColr)) !important; }
[data-p2h-vars] .tablesorter-blue tbody td input:not([type=checkbox]):not([type=radio]), [data-p2h-vars] .tablesorter-blue tbody td textarea {
    background-color: transparent !important; }   /* Let the zebra stripe show through the cell fields - as in the light theme */
[data-p2h-vars] .tablesorter-blue .tablesorter-filter-row, [data-p2h-vars] .tablesorter-blue .tablesorter-filter-row td {
    background-color: color-mix(in srgb, var(--CardsBgrd) 75%, var(--AccnColr)) !important; }
[data-p2h-vars] .tablesorter-blue tbody > tr:hover > td { background-color: color-mix(in srgb, var(--CardsBgrd) 70%, var(--AccnColr)) !important; }
[data-p2h-vars] .tablesorter-blue th, [data-p2h-vars] .tablesorter-blue thead td { background-color: #26364a !important; color: #e3e3e3 !important; }
[data-p2h-vars] [style*="_background.png"], [data-p2h-vars] .grid-container {
    background-image: none !important; background-color: var(--PageBcgrd) !important; }
[data-p2h-vars] [id^="chead"] {   /* Card headers: a shade of the card color (works for dark and custom themes) */
    background-image: none !important; background-color: color-mix(in srgb, var(--CardsBgrd) 90%, var(--TextColr)) !important; }

/* htm_Inbox(): placeholder text in an empty editable box */
.p2hInbox[contenteditable=true]:empty:not(:focus)::before { content: attr(data-ph); color: var(--grayColor, #888); font-style: italic; }

/* Theme button */
.p2hThemeButt { cursor: pointer; border: 1px solid var(--grayColor); border-radius: 6px; padding: 3px 10px;
    background: var(--InptBgrd); color: var(--TextColr); font-size: 13px; }

/* Theme button as a menu item in htm_Menu_TopDown */
.topnav .p2hThemeButt { border: none; border-radius: 0; padding: 6px 12px; margin: 0; background-color: inherit; color: white; font-family: inherit; }
.topnav .p2hThemeButt:hover { background-color: #555; }
@media screen and (max-width: 640px) { .topnav .mnuTheme { display: none; } .topnav.responsive .mnuTheme { display: block; float: none; } }

/* htm_ViewBar: a small floating toolbar (zoom, full screen, theme) - it lives outside <body>, so the page zoom does not scale it */
.p2hViewBar { position: fixed; top: 38px; right: 12px; z-index: 1001; display: flex; align-items: center; gap: 1px; padding: 3px 4px;
    background: rgba(40,44,52,0.92); color: #fff; border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.35);
    font: 13px/1.2 sans-serif; user-select: none; }
.p2hViewBar button { background: none; border: none; color: #fff; cursor: pointer; padding: 4px 7px; border-radius: 5px; font: inherit; }
.p2hViewBar button:hover { background: rgba(255,255,255,0.15); }
.p2hViewBar button:focus-visible, .p2hVbGrip:focus-visible { outline: 2px solid #4fc3f7; outline-offset: -2px; }
.p2hViewBar .p2hThemeTx { display: none; }
/* Column view (htm_ViewBar button): the cards flow in columns; the browser picks the number of columns from the width */
.p2hColview { column-width: 480px; column-gap: 16px; padding: 0 8px; }
.p2hColview > * { column-span: all; }                           /* Menu, headings, text: across all columns */
.p2hColview > span:not([id^=card]) { display: block; }          /* column-span works on blocks only (the menus are in a <span>) */
.p2hColview > [id^=card] { column-span: none; display: block; width: auto !important; max-width: 100%;
    margin: 0 0 14px !important; break-inside: avoid; -webkit-column-break-inside: avoid; }
.p2hViewBar [aria-pressed=true] { background: rgba(79,195,247,0.30); }
/* Skip links: hidden until they get keyboard focus */
.p2hSkip { position: absolute; left: -9999px; top: 4px; z-index: 3000; padding: 8px 14px; background: #2c3e50; color: #fff !important; border-radius: 6px; font-weight: 600; }
.p2hSkip:focus { left: 8px; outline: 2px solid #4fc3f7; }
.p2hSkip + .p2hSkip:focus { left: 200px; }
/* htm_NotePad(): uses the help window style; a dot on the button when there are notes */
.p2hNoteWin { top: 120px; right: 60px; }
.p2hNoteText { flex: 1; min-height: 220px; margin: 10px; padding: 8px; resize: vertical; font: 14px/1.5 sans-serif;
    border: 1px solid var(--grayColor, #aaa); border-radius: 4px; background: var(--InptBgrd, #fff); color: var(--TextColr, #222); }
.p2hNoteFoot { display: flex; align-items: center; gap: 6px; opacity: 1; }
.p2hNoteState { margin-right: auto; opacity: 0.7; }
.p2hNoteFoot button { background: none; border: 1px solid rgba(127,127,127,0.4); border-radius: 4px; padding: 3px 9px; cursor: pointer; color: inherit; font-size: 12px; }
.p2hNoteFoot button:hover { background: rgba(127,127,127,0.15); }
.p2hNoteButt { position: relative; }
.p2hNoteButt.hasNotes::after { content: ""; position: absolute; top: 3px; right: 3px; width: 7px; height: 7px; border-radius: 50%; background: #f0a050; }
/* Print (all pages): only the content - no menus, bars or buttons; folded cards are printed open; no background image */
@media print {
    nav, .topnav, .p2hViewBar, .p2hQuickBar, .p2hSideTxt, .p2hHelpWin, .p2hCardGrip, .p2hGripHint, .p2hMoveHint, .p2hTableTools, .p2hSessionEnd,
    [id^=btnGo], .ctxP_Js, button, .acceptbutt, a.button { display: none !important; }
    body { background: #fff !important; background-image: none !important; color: #000 !important; padding: 0 !important; }
    [id^=HideBody] { display: block !important; max-height: none !important; overflow: visible !important; }
    [id^=card] { box-shadow: none !important; }                    /* (no break-inside:avoid - a big card would leave an empty page) */
    .wrapper { height: auto !important; overflow: visible !important; }   /* Table windows: all rows */
    ic[onclick], abbr.hint > data-hint { display: none !important; }        /* Card control icons, hints */
    [id^=chead] { break-after: avoid; }                             /* A card header stays with the start of its content */
    .p2hPrintBlock, fieldset, [id^=card]:has([id^=card], table) { display: block !important; }   /* An inline-block cannot be split over pages -
                                       big ones become blocks: groups, cards with cards or tables inside (they grow when printed open), and (beforeprint) tall cards */
    a[href^="http"]::after { content: " (" attr(href) ")"; font-size: 0.8em; }   /* External links: show the address */
}
.p2hSessionEnd { position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 2000; width: min(640px, calc(100vw - 24px)); }
.p2hSessionEnd button { margin-left: 8px; }
/* htm_QuickBar(): fixed at the bottom - the page gets room, and fixed elements near the bottom are lifted above the bar */
.p2hQuickBar { position: fixed; left: 0; right: 0; bottom: 0; z-index: 1000; display: flex; justify-content: center; gap: 6px;
    padding: 5px 8px; overflow-x: auto; background: rgba(40,44,52,0.96); border-top: 2px solid var(--AccnColr, DarkGreen);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.25); box-sizing: border-box; }
.p2hQbItem { display: flex; align-items: center; gap: 7px; padding: 5px 13px; border-radius: 5px; white-space: nowrap;
    color: #fff !important; text-decoration: none; font: 600 13px/1.3 sans-serif; }
.p2hQbItem:hover, .p2hQbItem:focus-visible { background: rgba(255,255,255,0.15); outline: none; }
.p2hQbItem:focus-visible { box-shadow: inset 0 0 0 2px #4fc3f7; }
.p2hQbDot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
.p2hHasQuickBar body { padding-bottom: 56px; }
.p2hHasQuickBar #btnGoTop { bottom: 60px !important; }  .p2hHasQuickBar #btnGoMid { bottom: 94px !important; }
.p2hHasQuickBar #btnGoBot { bottom: 128px !important; }
.p2hHasQuickBar .p2hSideTxt { margin-bottom: 52px; }
.p2hHasQuickBar #snackbar.show { bottom: 70px !important; }
@media screen and (max-width: 600px) { .p2hQbTxt { display: none; } .p2hQbItem { padding: 7px 12px; font-size: 16px; } }   /* Phones: icons only */
@media print { .p2hQuickBar { display: none !important; } .p2hHasQuickBar body { padding-bottom: 0; } }
/* htm_PageHelp(): the help window (lives outside <body>, like the view bar) */
.p2hHelpButt:disabled { opacity: 0.35; cursor: not-allowed; }
.p2hHelpWin { position: fixed; top: 84px; right: 24px; z-index: 1003; width: min(460px, calc(100vw - 24px)); max-height: calc(100vh - 100px);
    display: flex; flex-direction: column; background: var(--CardsBgrd, #fff); color: var(--TextColr, #222); border: 1px solid #9aa5b1;
    border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); font: 14px/1.55 sans-serif; text-align: left; }
.p2hHelpWin[hidden] { display: none; }
.p2hHelpHead, .p2hNoteHead { display: flex; align-items: center; gap: 6px; padding: 9px 12px; background: #2c3e50; color: #fff; border-radius: 7px 7px 0 0;
    cursor: move; user-select: none; touch-action: none; font-weight: 600; }
.p2hHelpHead > ic, .p2hNoteHead > ic { color: #f0a050; }
.p2hHelpClose, .p2hNoteClose { margin-left: auto; background: none; border: none; color: #cfd6dd; font-size: 22px; line-height: 1; cursor: pointer; padding: 0 4px; }
.p2hHelpClose:hover, .p2hHelpClose:focus-visible, .p2hNoteClose:hover, .p2hNoteClose:focus-visible { color: #fff; }
.p2hHelpBody { padding: 4px 16px 10px; overflow-y: auto; }
.p2hHelpBody:focus { outline: none; }                          /* Gets focus when opened (keyboard scroll) - the window itself shows where you are */
.p2hHelpBody h3 { font-size: 16px; margin: 10px 0 6px; }
.p2hHelpFoot { padding: 6px 12px; border-top: 1px solid rgba(127,127,127,0.25); font-size: 11px; opacity: 0.7; text-align: right; }
/* htm_LangSelect(): flag button and the list of languages */
.p2hLang { position: relative; display: inline-flex; }
.p2hFlag { vertical-align: -2px; border-radius: 2px; box-shadow: 0 0 0 1px rgba(255,255,255,0.35); }
.p2hFlagTx { display: inline-block; min-width: 20px; font-size: 10px; text-align: center; border: 1px solid currentColor; border-radius: 2px; }
.p2hLangCode { font-size: 11px; }
.p2hLangList { position: absolute; top: calc(100% + 6px); right: 0; z-index: 1002; display: flex; flex-direction: column; min-width: 150px;
    padding: 4px; background: rgba(40,44,52,0.97); border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.45); }
.p2hLangList[hidden] { display: none; }
.p2hLangList.up { top: auto; bottom: calc(100% + 6px); }
.p2hLangList button { display: flex; align-items: center; gap: 8px; text-align: left; white-space: nowrap; }
.p2hLangList button[aria-checked=true] { background: rgba(255,255,255,0.18); font-weight: 600; }
.p2hVbGrip { cursor: grab; color: #aaa; padding: 4px 5px; touch-action: none; border-radius: 5px; }
.p2hVbGrip:hover { color: #fff; }
.p2hVbGrip.dragging { cursor: grabbing; color: #4fc3f7; }
.p2hVbZoom { min-width: 3.3em; text-align: center; }
.p2hVbSep { width: 1px; align-self: stretch; background: rgba(255,255,255,0.25); margin: 3px 3px; }

/* Dark theme: menu and view bar a step lighter than the page, so they stand out */
[data-theme="dark"] .topnav, [data-theme="dark"] .topnav .dropdown, [data-theme="dark"] .topnav a.icon { background-color: #464e5a !important; }
[data-theme="dark"] .topnav { box-shadow: 0 2px 10px rgba(0,0,0,0.5); }
[data-theme="dark"] .topnav a:hover, [data-theme="dark"] .dropdown:hover .dropbtn,
[data-theme="dark"] .topnav .p2hThemeButt:hover { background-color: #5c6573 !important; }
[data-theme="dark"] .topnav .mnu_heads { background-color: #5a6370 !important; color: #f2f2f2; }
[data-theme="dark"] .p2hViewBar { background: rgba(78,86,99,0.97); border: 1px solid rgba(255,255,255,0.14); box-shadow: 0 4px 16px rgba(0,0,0,0.55); }
[data-theme="dark"] .p2hViewBar button:hover { background: rgba(255,255,255,0.18); }

/* sysAlert / sysConfirm / sysPrompt dialogs (theme-aware) */
dialog.p2hDlg { border: 1px solid var(--grayColor); border-radius: 8px; padding: 0; min-width: 280px; max-width: min(520px, 92vw);
    background: var(--CardsBgrd); color: var(--TextColr); box-shadow: 0 8px 30px rgba(0,0,0,.35); }
dialog.p2hDlg::backdrop { background: rgba(0,0,0,.35); }
.p2hDlgHead { padding: 8px 14px; font-weight: 600; border-bottom: 1px solid var(--grayColor); }
.p2hDlgBody { padding: 14px; white-space: pre-line; text-align: left; }
.p2hDlgInp  { width: 100%; box-sizing: border-box; margin-top: 8px; padding: 5px; }
.p2hDlgFoot { padding: 8px 14px 12px; text-align: right; }
.p2hDlgFoot button { margin-left: 8px; padding: 4px 14px; border-radius: 5px; border: 1px solid var(--grayColor);
    background: var(--InptBgrd); color: var(--TextColr); cursor: pointer; }
.p2hDlgFoot button.p2hDlgOk { background: #1A6E1A; border-color: #1A6E1A; color: white; }
[data-p2h-custom] .p2hDlgFoot button.p2hDlgOk { background: var(--AccnColr); border-color: var(--AccnColr); }

/* Theme editor (htm_ThemeEditor) */
.p2hThemeEd { display: inline-grid; grid-template-columns: auto auto; gap: 6px 12px; align-items: center; text-align: left; }
.p2hThemeEd input[type=color] { width: 44px; height: 26px; padding: 0; border: 1px solid var(--grayColor); border-radius: 4px; cursor: pointer; }
.p2hThemeEd select { padding: 2px 6px; }
.p2hThemeEdButt { margin-top: 10px; }
.p2hThemeEdButt button { margin: 0 4px; padding: 4px 12px; border-radius: 5px; border: 1px solid var(--grayColor); background: var(--InptBgrd); color: var(--TextColr); cursor: pointer; }
</style>
';
} ## Group ******************** /CSS STYLE **************************

 
if (is_readable($custFile= $gbl_CustomLib ?? (__DIR__.'/customLib.inc.php')))     # Your own functions/code ($gbl_CustomLib, else customLib.inc.php next to this library)
    require_once($custFile);
/* else echo '<br> '.__LINE__.' '.$custFile.' not found <br>'; */

# CSRF global guard - køres automatisk ved hver POST-request
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && !csrf_verify()) {
    http_response_code(403);
    die(lang('@CSRF-validating failed. Reload the page and try again.'));
}

?>
