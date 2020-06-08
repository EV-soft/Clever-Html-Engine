<?   $DocFile='../Proj1/php2html.lib.php';    $DocVers='5.0.0';    $DocRev1='2020-06-08';     $DocIni='evs';  $ModulNo=0; ## File informative only

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
 * ## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: ../LICENSE_Copyright.txt
 
    Created: 2020-02-29 evs - EV-soft
    Latest revision: se at file top: $DocRevi
    R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
    2020-00-00 - evs  Initial
    
*/


### System init:
session_start();

require_once ('translate.inc.php');
require_once ('filedata.inc.php');

# CONSTANTS:
define('DEBUG',false);              # Set to true to activate system debugging
define('USEGRID',true);             # Use grid to place objects in rows / colums
define ('ThousandsSep',' ');        # Used in number output
define ('DecimalSep',',');          # Used in number output

# GLOBALS:
$ØTblIx= -1;                        # Index for table-id to separate multible tables in one page
$ØProgTitl= 'PHP2HTML';
$Øcopyright='EV-soft';
$Øprogvers= 'Develop'. 
$Øcopydate= '2020-00-00';
$Ødesigner= 'EV-soft';
$Ølogo=     '21997911.png';

$ØblueColor= 'lightblue';
$ØBodyBcgrd= 'Tan';
$ØTitleColr= 'green';               # Caption text-color in panel-head
$ØPanelBgrd= 'transparent';         # Panels hideble background
$GridOn= true;                      # Use grid to place objects in rows / colums

# PATHS:
$ØProgRoot= './';                   # $ØProgRoot=   "./../";  // "../";        //  Relative in 1. subniveau    #-$ØProgRoot= "./../../";   //  Relative in 2. subniveau
$_assets=     $ØProgRoot.'_assets/';   
$_images=     $ØProgRoot.'_assets/images/';   
$_base=   ''; 

# MENU-folders:
$folder1= ''; 
$folder2= ''; 
$folder3= ''; 
$folder4= ''; 
$folder5= '';

$App_Conf['language'] = $_SESSION['proglang'];

 
# CONFIGURATION:
// if (empty($App_Conf)) $App_Conf= parse_ini_file()      read from file
    if (empty($App_Conf['language'])) $App_Conf['language'] = 'en : English';   // default language
        //else  $App_Conf['language'] = sessionStorage.getItem("proglang");
    if (empty($App_Conf['test'])) $App_Conf['test'] = 'TESTER';

if (false) {
    FileWrite_arr($filepath='app_Conf.ini',$arrName='$App_Confxx',$list=$App_Conf);
    $App_Confxx= FileRead_arr($filepath='app_Conf.ini');    // parse_str(file_get_contents('app_Conf.ini'), $App_Confxx);
    echo "<pre>".'$App_Confxx:<br>'; print_r($App_Confxx);  echo "</pre><hr>";
    echo $App_Confxx['language'];
    echo $App_Confxx['test'];
}

### FUNCTIONS:

function htm_Input(# $type='',$name='',$valu='',$labl='',$llgn='R',$hint='',$algn='left',$unit='',$disa=false,$rows='2',$wdth='',$step='',$more='',$plho='@Enter...',$list=[] )
    $type='',           # text, date, ... Look at source !
    $name='',           # Set the fields name and id
    $valu='',           # The current content in input field
    $labl='',           # Translated label above the input field
    $llgn='R',          # Label align
    $hint='',           # Translated desctiption about the field
    $algn='left',       # The alignment of input content Default: left
    $unit='',           # A unit added to the content eg. currency or % If in front: '<' it is added as a prefix, else a suffix
    $disa=false,        # Disable the field. Default: field is active
    $rows='2',          # Number of rows in multiline input (eg. area/html) Default: 2 (Radio/Check-list: 1 to output horisontal)
    $wdth='',           # Width of the field-container
    $step='',           # the value of stepup/stepdown for numbers
    $more='',           # Give more (special / non system) input attrib
    $plho='@Enter...',  # Translated placeholder shown when field is empty. Default: Enter...
    $list=[]            # Data for "multi-list" (eg. options, checkbox, radiolist)
    ) {
    global $GridOn;
    $proc= true;        # Act as procedure: Echo result, or as function: Return string  dvl_pretty('htm_Input_test');
    $result= '';
    if ($hint=='') $hint= '@There is no explanation !';
    $hint= lang($hint);
    $labl= lang($labl);     
    if ($plho=='')  $plh=''; else $plh=' placeholder="'.lang($plho).'" ';
    if ($wdth=='')  $wdth= '200px';    // Default width
    if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
#GRID:
    if ((USEGRID) and ($GridOn)) $result.= '<div class="grid-item">';
#FIELD:
    $result.= '<div class="inpField" id="inpBox" style="width: '.$wdth.'; margin: auto; display: inline-block;"> '; // float: left; 
#INPUT:
    $inpIdNm=  ' id="'.$name.'" name="'.$name.'" ';
    $inpStyle= ' class="boxStyle" style="text-align: '.$algn.'; font-size:12px; '; 
    $eventInvalid= ' oninvalid="this.setCustomValidity(\''.lang('@Wrong data in ').lang($labl).' ! \')" oninput="setCustomValidity(\'\')" ';
    
    //if (gettype($valu)== 'Float') $type= 'number'; 
    if ($disa==true) $aktiv=' disabled '; else $aktiv= ''; 
    if ($plho=='')   $plh='';    else $plh=' placeholder="'.lang($plho).'" ';
    $top= '';
    
    switch ($type) {     
        case 'intg' : $result.= '<input type= "number" '.$inpIdNm. $more. $inpStyle. ' step:'. $step. '" value="'.$valu.'" '. $aktiv. $plh.' /> '; break;
        case 'text' : $result.= '<input type= "text" '.  $inpIdNm. $more. $inpStyle. '" value="'. $valu.'" '. $eventInvalid. $aktiv. $plh.' /> '; break;
        case 'dec0' : # quantity
        case 'dec1' : # Amount -  // SPACE as thousands separator
        case 'dec2' : $result.= '<input type= "text" '.  $inpIdNm. $more. ' value="'.$pref. number_format((float)$valu,(int)substr($type,3,1),DecimalSep,ThousandsSep).$suff. '" '. 
                        $inpStyle. '"'. $eventInvalid. $aktiv. $plh. ' pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" />';  break; 
        case 'num0' :
        case 'num1' :   // thousands separator ,|. is not allowed in number !  - https://codepen.io/nfisher/pen/YYJoYE/ - SPACE will be removed
        case 'num2' :   /* lang="en" to allow "."-char as decimal separator, and national ","-char */
        case 'num3' : $result.= '<input type="number" '. $inpIdNm. $more.' lang="en" step="'.$step.'" value="'.$valu.'" '. $eventInvalid. $aktiv. $plh. ' pattern="(\d{3})([\.])(\d{2})"'.
                        $inpStyle. '" />';  break; // No unit but with browser type check !
        case 'barc' : $result.= '<input type= "text" '. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $aktiv. $plh.
                        $inpStyle. ' font-family:barcode; font-size:19px;"'. ' />';  break; 
        case 'mail' : $result.= '<input type= "email" '. $inpIdNm. $more. ' value="'.$valu.'" '. /* $eventInvalid. */ $aktiv. $plh. // 'pattern="/^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/"'.
                        $inpStyle. '" />';  break; 

        case 'link' : $result.= '<input type= "url" '.   $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern='https?://.+'. $aktiv. $plh.   // pattern="^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?" 
                        $inpStyle. '" />';  break; 

        case 'sear' : $result.= '<input type="search" '. $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh. 
                        $inpStyle. '" />';  break; 

        case 'file' : $result.= '<input type= "file" '.     $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. '" />';  break; 

        case 'imag' : $result.= '<input type= "image" '.    $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh.
                        $inpStyle. ' height: 18px;" />';  break; 

        case 'date' : $result.= '<input type= "date" '.  $inpIdNm. $more. $inpStyle. ' display:inline-block;'.' min-width: 115px; margin: 5px 0 0; padding: 5px 0 2px;" value="'. $valu. '" placeholder ="yyyy-mm-dd" '. $aktiv.' /> '; break;
        case 'time' : $result.= '<input type= "time" '.     $inpIdNm. $more. ' value="'.$valu.'" '. $eventInvalid. $pattern="". $aktiv. $plh. 
                        $inpStyle. '" />';  break; 
        case 'week' : $result.= '<input type= "week" '.  $inpIdNm. $more. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="yyyy-mm-dd" '. $aktiv.' /> '; break;
        case 'mont' : $result.= '<input type= "month" '.  $inpIdNm. $more. $inpStyle. ' display:inline-block;'.'" value="'. $valu. '" placeholder ="yyyy-mm-dd" '. $aktiv.' /> '; break;
        
        case 'rang' : $result.= '<span class="fieldContent boxStyle range-wrap" style="height: 28px;">'.
                            '<input class="range" type= "range" '.$inpIdNm. $more. ' value="'.$valu.'" '. $aktiv. 'onclick="setBubble('.$name.',\'bubble\')" style= "text-align: '.$algn.'; font-size: 12px; margin: 0; box-shadow: none;" /> '.
                            '<div class="bubble" style="font-size: 10px; top: -41px; position: relative; width: min-content; text-align: center; opacity: 80%;"> Min .. Val .. Max </div>'.  
                            '</span>';  break; 

        case 'butt' : $result.= '<span class="fieldContent boxStyle" style="height: 28px;">'.
                            '<input type= "button" '. $inpIdNm. $more. ' value="'.$valu.'" '. $aktiv. 
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px; background-color: lightgray;" /> </span>'; break; // No functionality !

        case 'colr' : $result.= '<span class="fieldContent boxStyle" style="height: 28px;">'.
                            '<input type= "color" '. $inpIdNm. $more. ' value="'.$valu.'" '. $aktiv. 
                        $inpStyle. ' margin: 0; padding: 2px; border-radius: 4px;" /> </span>'; break; 

        case 'pass' : $result.= '<span class="fieldContent boxStyle" style="text-align: left; height: 34px;">'.
                            '<div style="white-space: nowrap;">'.
                            '<input type= "password" '. $inpIdNm. $more. ' style="height: 8px; width: 67%; margin-top: -1px; box-shadow: none;" value="'.
                            $valu.'" '.$eventInvalid. $aktiv. $plh.' onkeyup="getPassword('.$name.')" />'.
                            htm_IconButt($type='button',$faicon='far fa-eye-slash',$lbl='', $title= lang('@Show/Hide password'),$id='tgl_'.$name, 
                                 $link='',$action='onmousedown="togglePassword('.'tgl_'.$name.','.$name.')"',$akey='',$size='').
                            '</div>';
                            $str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
                            $result.= '<meter id= "pwPoint'.$name.'" style="position:relative; top:-13px; height:6px; width:97%;" '.
                                'min="0" low="6" optimum="7" high="9" max="10" id="password-strength-meter" '.
                                'title="'.lang('@Password strength: 0..10').'">'. // $str.'"'. // ' <span id=\"mtPoint\"'.$name.'> 0</span>'. '/10"'.
                            '</meter>'; $result.= '</span>';    break;

        case 'area' : $result.= '<span class="fieldContent boxStyle" style="padding: 10px 4px 4px;"> <textarea rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="width:97%; font-size: 1em; border: 1px solid lightgray; border-radius: 4px;" '.
                        $eventInvalid. $aktiv. $plh.' '.$more.' >'.$valu.'</textarea>'; $top=' top: -8px; ';  break; 

        case 'html' : $result.= '<span class="fieldContent boxStyle" style="top: -1px; padding: 10px 4px 4px;"> <small><div contenteditable="true" rows="'.$rows.'" id="'.$name.'" name="'.$name.
                        '" style="background-color: white; min-height: 34px; border: 1px solid lightgray; padding: 2px;" '. //  Som area, men med html-indhold
                        $eventInvalid. $aktiv. $plh.' data-placeholder="'.lang($plho).'" '. $more.' >'. $valu.'</div></small>';
                        if ($disa) $result.= '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>'; $top=' top: -8px; '; break; 

        case 'chck' : $result.= '<form action="">'.  // Nestet form !
                            '<span class="fieldContent boxStyle" ><small>';
                            foreach ($list as $rec) { // $list= [['name','@Label','@ToolTip'], ['0:name',1:'@Label',2:'@ToolTip',3:'checked'], ['@Label','@ToolTip'],...]
                                $result.= '<input type= "checkbox" name="'.$rec[0]. /* '" value="'.$rec[3]. */ '" '.$rec[3].' style="width: 20px; box-shadow: none;"/>'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px;">'.Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small></span> </form>';  break; 

        case 'rado' : $result.= '<form action="">'.  // Warn: Nestet form !
                            '<span class="fieldContent boxStyle" ><small>';
                            foreach ($list as $rec) { // $list= [['name','Label','@ToolTip'], [0:'name',1:'Label',2:'@ToolTip',3:'checked'], ['Label','@ToolTip'],...]
                                $result.= '<input type= "radio" id="'.$rec[0].'" name="'.$name.'" value="'.$rec[1].'" '.$rec[3].' style="width: 20px; box-shadow: none;">'.
                                     '<label for="'.$rec[0].'" style="position: relative; top: -2px;">'. Lbl_Tip($rec[1],$rec[2],'','12px; box-shadow: none; ').'</label>';
                                if ($rows=='1') $result.= '&nbsp;'; else $result.= '<br>';
                            }   $result.= '</small></span> </form>';  break; 

        case 'opti' : $result.= '<span class="fieldContent boxStyle" style="background-color; white; text-align: center; padding: 10px 4px 4px;"><small>';
                            $result.= '<select class="styled-select" name="'.$name.'" '.$events.' '.$eventInvalid.'style="width: 98%; '.$colr.'" '.$aktiv.'> '; dvl_pretty();
                            $result.= '<option label="'.lang($plho).'" value="'.$valu.'">'.lang('@Select!').'</option> ';  # title="'.$hint.'"     selected="'.$valu.'"
                            foreach ($list as $rec) { # $list= [[0:name, 1:value, 2:@ToolTip, 3:'checked', [...]]
                                $result.= '<option '. /* .'label="'.lang($rec[x]).'" '. */ 'title="'.lang($rec[2]).'" value="'.$rec[1].'" '.$state=$rec[3]; //  Firefox does not support Label !
                                if ($rec[1]==$valu) $result.= ' selected ';
                                $result.= '>'.$lbl=lang($rec[1]).'</option> ';
                            }   $result.= '</select></small></span>';  break; 

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



/*
Layout of htm_Table:
 -------------------------------------------------------------------------------------------------------
|                                                                                                       |
|                                           TABLE-Caption                                               |
|                                                                                                       |
 -------------------------------------------------------------------------------------------------------
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
 -------------------------------------------------------------------------------------------------------
|                                              Table-Notes                                              |
 -------------------------------------------------------------------------------------------------------
*/
function htm_Table(
    $TblCapt= array( #['0:Label',   '1:Width',    '2:Type',    '3:OutFormat', '4:horJust',      '5:Tip',    '6:placeholder', '7:Content';], ['Næste record']
        ),
    $RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
        ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => knap
    $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
        ),
    $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
        ),            # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
    $TblNote= '',           # HTML-string
    &$TblData,              # = array(),
    $FilterOn= true,        # Ability to hide records that do not match filter // Does not work with hidd fields!
    $SorterOn= true,        # Ability to sort records by column content
    $CreateRec=true,        # Ability to create a record
    $ModifyRec=true,        # Ability to select and change data in a row
    $ViewHeight= '400px',   # The height of the visible part of the table's data
    $TblStyle= '',          # Style for the span that holds the table;
    $CalledFrom='',         # = __FUNCTION__ (debugging)
    $Criterion= ['','']     # Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
)                           # Field 4: ($fieldModes), is composed of: [horJust, FieldBgColor, FieldStyle, SorterON, FilterON, SelectON, ]
                            # 0:horJust - Arguments to .td: style="text-align:
                            # 1:FieldBgColor - Arguments to .td: background-color: 
                            # 2:FieldStyle - complete expression, e.g.: 'font-style:italic; '
                            # 3:TdColor - like 1: but used for "row marking"
                            # Only impact on Body areas.
#!  FIXIT: Fixed/Sticky header only works on 1st table when there are several tables in the same window!
#!         Zebra streaks (Update Issue!) Failure, as well as filter problems when hidden columns are also present.

{ global $ØblueColor, $ØLineBrun, $ØRollTabl, $ØHeaderFont, $ØIconStyle, $ØPanelIx, $ØTblIx, $ØrowCount, $Ønovice;
    $creaInpBg= 'LightYellow';
    $ØBodyBcgrd= 'yellow';
    $valgbar= (($ModifyRec) and ($RowBody[0][2]=='indx'));
    //if (!$TblData) {msg_Info ('No data', 'The data table is empty!'); $TblData=[]; };  //  exit;
    if (DEBUG) dvl_pretty('Start-htm_Table: '.$CalledFrom);
    if (!$valgbar) $RowSelect= '';
    else    { $RowSelect= '<span class="tooltip"><span style="font-size:115%;">&#x21E8;</span>'.
                            '<span class="LblTip_text" style="bottom: -12px; left: 65px">'.lang('@Selectable: ').str_nl(1).
                            lang('@This row can be selected by clicking Id/Number in the first field of the row.').'</span></span>';
            }
    if ($FilterOn)  {$filt= ' filter-true '; }   else $filt= ' filter-false ';  //  filter-select
    if ($SorterOn)  {$sort= ' sorter-inputs '; } else $sort= ' sorter-false ';
    
    $ØTblIx++;          //  0..7 on a page
    $tix= 'T'.$ØTblIx;  //  Tabel index for flere tabeller i samme vindue
  
    if (!function_exists('RowKlick')) {
        run_Script( 'function rowLookup(CalledFrom,valu,RowIx,ColIx) { window.alert("'.lang('@You pressed ').'" + valu + '.
            '"\nNothing is happening yet...\nRelates to: "+ CalledFrom +" Row: "+ RowIx );'.
            ' }');
        function RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix='',$CalledFrom) {
            if (!$ModifyRec) {return $rowix;} else return 
            '<span style=" padding:3px;" onclick="rowLookup(\''.$CalledFrom.'\',\''.$valu.'\',\''.$RowIx.'\',\''.$ColIx.'\')" >'.
            '<input name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" style="width:99%; text-align: center; border:0; '.
                            'text-decoration: underline; cursor:zoom-in;" readonly value='.$valu.' />'. '</span>'; 
        };
    }
   
    echo '<span class="tableStyle" name="tblField" style="width:'.$width.'; padding: 8px; '.$TblStyle.'">';
### Caption line:
    if ($TblCapt[0][0]>'') {    dvl_pretty();    // htm_nl(1);
        if ($TblCapt) foreach ($TblCapt as $Capt) { // $Capt[x]: 0:Label 1:width 2:type 3:(outFormat) 4:align 5:titletip 6:default 7:value
            $mode= '" placeholder="';
            echo ' '.lang($Capt[0]);  //  Label:  (feltPrefix)
            switch ($Capt[2]) {  # Special outputs:
                case 'show' : $mode= '" disabled value="';        break;
                case 'info' : echo count($TblData).lang($Capt[6]);   break;  //  $Capt[6]= feltSuffix
                case 'html' : echo ' '.lang($Capt[6]);                break;
                default: 
                echo ' <input type= "'.$Capt[2].'" name="note" title="'.lang($Capt[5]).   //  Input-field    
                    $mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;';
            }
        } // foreach-TblCapt
    
    if ((count($TblCapt)>1) or ($Capt[1]>"40%")) htm_nl(); //  false:Ved smalt panel
    if ($Ønovice) {
        htm_sp(5);
        if ($SorterOn)  {echo $sor= htm_IconButt($type='submit',$faicon='fas fa-sort',$id='',$labl='@Sort?',
            $title= lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.'),
            $link='#',$action='',$akey='','12px'); }
        if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-plus',$id='',$labl='@Filter?',
            $title= lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
                    lang('@Enter a search term here to display only data that matches the term.'),
            $link='#',$action='',$akey='','12px'); }
        if ($FilterOn)  {echo $fil= htm_IconButt($type='submit',$faicon='fas fa-search-minus',$id='',$labl='@Show everything!',    //<button type="button" class="reset">lang( '@Vis alt')</button>
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
            /* .'  <br><data-yelllabl>'.lang( '@CTRL Pil-taster').'</data-yelllabl> '.lang( '@virker ikke. ' */
            ,$link='#',$action='',$akey='','12px'); }
    }
  } dvl_pretty();
  
### Table-start:  
    echo '<span class="wrapper" style="padding:0; border:1px solid gray; height:'.$ViewHeight.'; display: block;">'; //  "Table-window": Container for tabel  display: inline ?
    echo '  <div id="overlay"></div>';
    echo '    <table class="tablesorter" id="table'.$ØTblIx.'" style="padding:1px; margin:0;">'; //  id= smarttabel eller 'table'.$ØTblIx  0..7
    echo '    <thead>';
    $filter_cellFilter= [];  //  [ '', 'hidden', '', 'hidden' ]
  
### Columns-LABELS with sorting and filtering:
    echo '    <tr style="height:32px;">'; 
    foreach ($RowPref as $Pref) { dvl_pretty(); 
        echo '<th class=" filter-false sorter-false" style="width:'.$Pref[1].' align:'.$Pref[4][0].'; '.$ØHeaderFont.'"> '.
                Lbl_Tip($Pref[0],$Pref[5],'SO',$h='0px').' </th>';
    }   $kNo= -1;
    if ($valgbar) echo  '<th class="filter-false sorter-false" > </th>';
  
    $hiddcount= 0;
    foreach ($RowBody as $Body) { dvl_pretty(); 
        $colfilt= ' ';
        if (($GLOBALS["Øshow"]>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
        if (is_null($Body[8])) $Body[8]= false;
        if ($Body[8]==true) $selt= ' filter-select filter-onlyAvail'; else $selt= ' ';  //  FIXIT: sorting of datefields don’t works!
        if ($Body[2]=='hidd') // FIXIT: visning af filter-felter, får kolonner ud af takt! - $filter_cellFilter virker tilsyneladende ikke: https://mottie.github.io/tablesorter/docs/#widget-filter-cellfilter
            { array_push($filter_cellFilter, 'hidden');
                $hiddcount++;
                echo '<th class="filter-false sorter-false" style="width:0; display:none;" ></th>'; // FIXIT: Filter-felter vises for skjulte kolonner! <td data-column="9" style="display:none" > fixer det
            } //  visibility:hidden;    //  columnSelector_columns : { 5 : false, 6 : false}
        else 
            { $kNo++; array_push($filter_cellFilter, '');   
                if ((($Body[2]=='text') or ($Body[2]=='data') or ($Body[2]=='date')or ($Body[2]=='osta')) and ($ModifyRec==true))
                {$editmark= '·'; $lblsuff= str_nl().lang('@Can be edited !');} else {$editmark= ''; $lblsuff=''; }
                if ($kNo<=1) $tipplc='SO'; else if ($kNo=1) $tipplc='S'; else $tipplc='SW';
                if ($kNo==count($RowBody)) $tipplc='SW';
                echo '<th class="'.$filt.$selt.$sort.$colfilt.'" data-placeholder= "'.lang('@Search...').'" style="width:'.$Body[1].'; '.
                    $ØHeaderFont.' text-align:center;">'.Lbl_Tip($Body[0].$editmark,$Body[5].$lblsuff,$tipplc,$h='0px').' </th>';
    }       }
    foreach ($RowSuff as $Suff) { dvl_pretty(); 
        echo '<th class="filter-false sorter-false" style="width:'.$Suff[1].'; align:'.$Suff[4][0].'; '.$ØHeaderFont.'">'.
                Lbl_Tip($Suff[0],$Suff[5],'SW',$h='0px').'</th>';
    }
    echo '    </tr>';    dvl_pretty();
### Column-FILTER:   (created of tablesorter, but there are a problem with hidd-fields!) filter-onlyAvail
    echo '    </thead>';

### TableFooter with the options to create a new record:
    echo '    <tfoot>';
    if ($CreateRec) { ## Create new data in a new tabelRow:
        echo '  <tr>';  //  Row with createbutton:
        if (($valgbar) or (count($RowPref)>=1))  
            echo  '<td> </td>';
        if (count($RowPref)>=2) {$colsp= 'colspan="2"'; $n= 2; } else {$colsp= ''; $n= 1; }
        echo '  <td style="font-size: 12px;" '.$colsp.'>'.lang('@Create new:').'</td>';
        for ($x= $n+1; $x < count($RowPref)+count($RowBody)-$hiddcount; $x++) 
            echo '<td> </td>';
        echo '<td style="text-align:center;">'.
             htm_AcceptButt($labl='@Create record', 
                            $title=lang('Fill in the fields below with data before clicking the Create button! '), $btnKind='create', 
                            $form='form_'.$ØPanelIx.'_'.$ØTblIx, $width='', $akey='c', $proc=false, $tipplc='LblTip_NW').
             '</td>';
        for ($x= 1; $x <= count($RowSuff); $x++) 
            echo '<td style="width:'.$RowPref[1].';"> </td>';
        echo ' </tr>';
        echo '  <tr>';  #  Row with input-fields:
        if ($valgbar) echo '<td style="width:0.5%;"> </td>';
        if ($RowPref) echo '<td style="text-align:right;"></td>';  // Data:
        $ColIx= -1; $bgclr= 'background-color:'.$creaInpBg.'; ';
        foreach ($RowBody as $Body) { $ColIx++;
            $s1= ' style="width:'.$Body[1].';" title="'.lang($Body[5]).'">';
            $s2= $name='New_Row0Col'.$ColIx.'[]' ;
            if ($Body[6]=='@Numr...') $oblg= lang('@Mandatory'); else $oblg= '';
            if (($GLOBALS["Øshow"]>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
            switch ($Body[2]) {  # Special InpTypes ("Lookup"):
            # case 'vat_' : echo '<td'.$s1.ddwnList($s2,$valu,MomsListe(),$bgclr.'width:45px; ').'</td>';  break;
            # case 'kont' : echo '<td'.$s1.ddwnList($s2,$valu,KontListe(),$bgclr.'width:35px; ').'</td>';  break;
            # case 'valu' : echo '<td'.$s1.ddwnList($s2,$valu,ValuListe(),$bgclr.'width:55px; ').'</td>';  break;
            # case 'stat' : echo '<td'.$s1.ddwnList($s2,$valu,StatListe(),$bgclr.'width:65px; ').'</td>';  break;
            # case 'osta' : echo '<td'.$s1.ddwnList($s2,$valu,OrdrStatu(),$bgclr.'width:70px; ').'</td>';  break;
            # case 'just' : echo '<td'.$s1.ddwnList($s2,$valu,JustListe(),$bgclr.'width:35px; ').'</td>';  break;
            # case 'side' : echo '<td'.$s1.ddwnList($s2,$valu,Side_List(),$bgclr.'width:35px; ').'</td>';  break;
            # case 'font' : echo '<td'.$s1.ddwnList($s2,$valu,FontListe(),$bgclr.'width:75px; ').'</td>';  break;
                case 'show' : //  Just show the data:
                case 'indx' : echo '<td style="width:'.$Body[1].'; text-align:center">'.lang($Body[6]).'</td>';   break;  //  Show only
                case 'hidd' : echo '<td style="width:0; padding:0; display:none; '.$bord.'">  <input type= "hidden" name="Kol'.$ColIx.'[]" '.
                                    'value="'.htmlentities(stripslashes(lang($valu))).'" style=" width:0; display:none;"/></td> '; break; //  Show nothing
                //  text, indx, data, :
                default:      echo '<td style="width:'.$Body[1].';"> <input type="text" name="New_Row0Col'.$ColIx.'[]'.
                                    '" form="form_'.$ØPanelIx.'_'.$ØTblIx.'" style="width:94%; background:'.$creaInpBg.';" placeholder="'.$oblg.' ?..." value="" title="'.
                                    lang('@Data-field in new record').' '.$oblg.': '.lang($Body[5]).'" /> </td>';
            }
        }
        $ColIx= -1; foreach ($RowSuff as $Suff) {$ColIx++; if ($ColIx>=0) echo '<td></td>';}
        echo ' </tr>';
    }
    echo '  </tfoot>';
    echo '<style> $("#table'.$ØTblIx.'").tablesorter({ widgetOptions { filter_cellFilter: ["'.implode('","',$filter_cellFilter). '"]}} </style>';  // Hide input filter fields fore hidden columns

### DATA and html-objects:
    echo '     <tbody>';
    if (!function_exists('RowBg')) {
        function RowBg($clr,$alg,$pos='') { if ($pos>'') $bord= ' border-'.$pos.':3px solid var(--grayColor); '; else $bord= '';
        return ' background:'.$clr.'; vertical-align:'.$alg.'; height:1.5em; '.$bord.' '; };
    }
    $RowIx=-1;
    if ($TblData)
        foreach ($TblData as $Drow) { $RowIx++; dvl_pretty();
            echo '<tr class="row">';  //  Tablesorter with Zebra-striped background
            foreach ($RowPref as $Pref) {
                echo '<td style="width:'.$Pref[1].'; text-align:'.$Pref[4][0].'; ">'.lang($Pref[6]).' </td>';
            }
            if ($valgbar) echo '<td style="text-align:right; width:2%;">'.$RowSelect.'</td>';
            
    ### Table-BODY-Rows:
            //$optlist= FormVarsList(4); $ordlist= OrdrVarsList(4);
            $ColIx= -1;
            $rowBg= '';
            $inpBg= ' background-color:transparent;';   //' background-color: white; opacity:0.60; '; //$inpBg= ' background-color:rbg(200,200,200,0.3);';  //' background-color: white; opacity:0.60; ';
            foreach ($RowBody as $Body) 
                if ($ColDrop> 0) {/* Drop Column after colspan */ $ColDrop= $ColDrop-1; $ColIx++;}
                else
                { $ColIx++;    dvl_pretty();
                    if (is_array($Drow[$ColIx])) 
                        $valu= $Drow[$ColIx][0];
                    else  $valu= $Drow[$ColIx];   
                    
            ## Special Output formats:
                if (!$GLOBALS["Øshow"]>0)
                    switch ($Body[3]) {  
                        case '0d': if ($valu==null) $valu= 0;     else $valu= number_format((float)$valu, 0,',','.'); break;
                        case '1d': if ($valu==null) $valu='';     else $valu= number_format((float)$valu, 1,',','.'); break;
                        case '2d': if ($valu==' ')  $valu= $valu; else
                                        if ($valu==null) $valu='';   else $valu= number_format((float)$valu, 2,',','.'); break;  //  88.888.888,88
                        case '2%': if ($valu==' ')  $valu= $valu; else
                                        if ($valu==null) $valu='';   else $valu= number_format((float)$valu, 2).' %';     break;
                        case '>0': if (!(float)$valu>0) $valu= ' ';       break; // 0 an less is shown as BLANK
                        case '= ': $valu= ' ';                            break; // Values is shown as BLANK
                        default: $valu= $valu;
                    } 
                
                $flag= substr($valu,1,2);
                if (($flag=='::') or ($flag==':.')) $valu= substr($valu,2).' '; // fieldFlag is not shown. SPACE so placeholder is not shown.
            ## Special column-formats:
                if (is_string($Body[4][0]))  $txAlign= ' style="text-align:'.$Body[4][0].'; '; else $txAlign= '';
                if (is_string($Body[4][1]))  $bgColor= ' background-color:'. $Body[4][1].'; '; else $bgColor= '';
                if (is_string($Body[4][2]))  $fltStyl= ' '.                  $Body[4][2].' ';  else $fltStyl= '';   // i.e.: 'font-style:italic; '
                if (is_string($Body[4][3]))  $tdColor= ' background-color:'. $Body[4][3].'; '; else $tdColor= '';
                
              ## Specielle betingede "række"-formater:
                if ($Kriterie==['','']) $kontotype= '';
                
                if ($ColIx<count($Drow)) {  //  If colspan is there stopped here, when the row is over
                    echo '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.$bgColor.$tdColor.$rowBg.$colsp; //  tabelfelt-egenskaber
                ## Special InputTypes i tabelfield:
                if ($GLOBALS["Øshow"]>0) $Body[2]= 'text';
                switch ($Body[2]) {  
                    case 'vars' : echo '">'.' <div style="margin-right:0; font-size:x-small">'.
                                       '<select class="styled-select" name="liste" style="max-width:120px"> <option value=" " >-';
                                    foreach ($optlist as $rec) { 
                                      echo "\n".'<option label="'.$rec[2].'" value="'.$rec[1].'" '.$rec[3];   
                                      if ($rec[1]==$valu) echo ' selected ';   
                                      echo '>'.$lbl=$rec[2].'</option> '; 
                                    }
                                  echo '</select></div> ';   break;
                                  //  Checkbox-selector:
                    case 'chck' : echo '">'.'<input type= "checkbox" name="chck" value="" '.$valu.' ';  break;
                    case 'bold' : echo '">'.'<input type= "checkbox" name="bold" value="" '.isbold($valu).' ';  break;
                    case 'ital' : echo '">'.'<input type= "checkbox" name="ital" value="" '.isital($valu).' ';  break;
                ##  Custom - DropDown-selector:
                #   case 'moms' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,MomsListe(),'width:45px; ');  break; 
                #   case 'just' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,JustListe(),'width:35px; ');  break;
                #   case 'side' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,Side_List(),'width:35px; ');  break;
                #   case 'font' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,FontListe(),'width:75px; ');  break;
                #   case 'kont' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,KontListe(),'width:35px; ');  break;
                #   case 'valu' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,ValuListe(),'width:55px; ');  break;
                #   case 'stat' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,StatListe(),'width:65px; ');  break;
                #   case 'osta' : echo '">'.ddwnList($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,OrdrStatu(),'width:70px; ');  break;  //  Ordre status
                    case 'sttu' : if ($Drow[9]!=' ')  echo '">'.lang(ListLookup(StatListe(),$search= '',$colsearch=1,$colresult=2)); 
                                  else                echo '">'; break;
                    case 'date' : if (($valu==' ') /* or ($valu==NULL) */) $clr= 'color: transparent; '; else $clr= '';  // Skjul browserens placeholder ved at angive SPACE
                                  echo '">'.'<input type= "date" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '. //  (id="'.$name.'")
                                          'style="line-height:100%; text-align:left; font-size:small; height:16px; '.$clr. $inpBg. 
                                           '" value="'.$valu. '" placeholder="yyyy-mm-dd" '.$aktiv.' />';  break; //  Browseren benytter egen placeholder!
                    case 'html' : echo '">  '.$valu;  break;                                                      //  Kun visning af HTML
                    case 'htm0' : echo '">  '.'<small><small>'.$valu.'</small></small>';  break;                                                      //  Kun visning af HTML
                    case 'show' : if ($valu==' ') $clr= 'color: transparent; ';                                   //  Kun visning af data:
                                  else $clr= '';                                                                  // Skjul browserens placeholder ved at angive SPACE
                                  echo '"> <input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.
                                       'value="'.$valu. '" placeholder="'.lang($Body[6]).'"'.
                                       $txAlign.$inpBg.' width:98%; '.$clr.' " readonly /> ';  
                                  break;
                    case 'helt' : echo '"> <input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.
                                       'value="'.number_format((float)$valu, 0). //  0 dec. = Heltal
                                       '" placeholder="'.lang($Body[6]).'"'.$txAlign.$inpBg.
                                       ' width:98%; padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'data' : //  Vis og rediger data: 
                    case 'area' : if ($valu=='New field')  {  # Opret ny record
                                    echo '"> '.lang('@New field:').' <div style="margin-right:0; font-size:x-small">'.
                                         '<select class="styled-select" name="liste"> <option value=" " >-';
                                      foreach ($ordlist as $rec) { 
                                        echo '<option label="'.$rec[2].'" value="'.$rec[1].'" '.$rec[3];  
                                        if ($rec[1]==$valu) echo ' selected';   
                                        echo '>'.$lbl=$rec[2].'</option> '; 
                                      }
                                    echo '</select></div> ';
                                  } else # Vis redigerbart datafelt:
                                    echo '"> <input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.
                                         'value="'.htmlentities(stripslashes(lang($valu))).'" placeholder="'.lang($Body[6]).'"'.
                                         $txAlign.$inpBg.' width:98%; padding-left:2px; padding-right:2px;" /> ';
                                  break;
                    case 'keyn' : //  Selectable and editable index
                                  echo '"><span style="font-size:small" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix,$CalledFrom).'</span>';  
                                  break;
                    case 'indx' : //  Selectable but not editable index
                                  //  < input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.'value="'.$valu.'" /> 
                                  echo '"><span style="font-size:small" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.
                                        RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix,$CalledFrom).' </span>';  
                                  break;
                    case 'blnk' : //  Value is displayed as BLANK
                                  echo '"><span > </span>';  
                                  break;
                    case 'hidd' : //  Hidden data is included as hidden columns to have a complete record (simplifies updating):
                                  echo 'width:0; padding:0; border:none; display:none;">  <input type= "hidden" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.  //   visibility:hidden;
                                       'value="'.htmlentities(stripslashes(lang($valu))).'" '.$txAlign.$inpBg.' width:0;" /> ';
                                  break;
                                 // text, 
                    default   : { echo '"> <input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]"  form="form_'.$ØPanelIx.'_'.$ØTblIx.'" value="'.$valu.'" '.
                                       'placeholder="'.lang($Body[6]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%; font-style:inherit;" /> ';
                                }
                    }   // :switch InputTypes
                    echo '</td>'; //  tabelfelt slut
                }
            };  //  foreach $RowBody

        ### Table-BODY-RowSuffix:
                foreach ($RowSuff as $Suff) { dvl_pretty();
                    if ($ModifyRec) {
                        $output= $Suff[6];
                        if ($Suff[2]=='button') { ## RowSuffix Special Buttons:
                            $btnStyle= '" class="tooltip" style="height:20px; border:0; box-shadow:none; background-color:transparent;" ';
                            $btnSuff= $ØTblIx.'_'.$RowIx. $btnStyle;
                            if ($Suff[0]=='@Delete')  { if ($Suff[3]=='dis') $dis= 'disabled'; else $dis= '';
                                                        $output='<button type= "submit" name="btn_del_'.$btnSuff.$dis.' >'.
                                                    Lbl_Tip($Suff[6],lang('@Delete pos: ').$RowIx.' ('.$dis.')','SW','0px'). '</button>'; }   // Buttons that must not be deleted can be deactivated
                            if ($Suff[0]=='@Hide') { $output='<button type= "submit" name="btn_hid_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Hide pos: ').$RowIx,'SW','0px'). '</button>'; }                   // Records that must not be deleted can be hidden
                            if ($Suff[0]=='@Copy')  { $output='<button type= "submit" name="btn_cpy_' .$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Copy pos: ').$RowIx,'SW','0px'). '</button>'; }
                            if ($Suff[0]=='@Rename') { $output='<button type= "submit" name="btn_ren_'.$btnSuff.'>'.
                                                    Lbl_Tip($Suff[6],lang('@Rename pos: ').$ØTblIx.'_'.$RowIx,'SW','0px'). '</button>'; } 
                            if ($Suff[0]=='@Select') { $output='<input type= "checkbox" name="btn_sel_'.$btnSuff.
                                                    Lbl_Tip($Suff[6],lang('@Select pos: ').$RowIx,'SW','0px'). ' />'; }
                        }
                        echo '<td style="text-align:'.$Suff[4][0].'; width:'.$Suff[1].';" disabled >'.$output.'</td>';
                    }
                }   //  [' @Slet',     '4%',         'text',         '',        'center',   ' @Klik på rødt kryds for at slette  ', '<ic class="far fa-times-circle" style="color:red; font-size:13px;"></ic>']
                //  ['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:FeltJust', '5:ColTip', '6:value!     '            ]
            echo '</tr>';
        
    } //  foreach $TblData
    $_SESSION["ØrowCount"]['T'.$ØTblIx]= $RowIx;
    
    echo '</tbody>';
    echo '</table>';
    echo '</span>'; //  wrapper
    echo $TblNote;
    echo '</span>'; // tableStyle
    if (DEBUG) dvl_pretty('End-htm_Table: '.$CalledFrom);
} // htm_Table


function htm_PanlHead($frmName='', $capt='', $parms='', $icon='', $class='panelWmax', $func='Undefined', $more='', $BookMark='', $panlBg='background-color: white;')
{ # MUST be followed of htm_PanlFoot !
    global $ØTitleColr, $ØPanlForm, $ØProgRoot, $_assets, $ØPanelIx, $ØPanelBgrd, $GridOn; 
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
    
    if (DEBUG) {$fn= '&nbsp; <small><small><small>'.$func.'()</small></small></small>';} 
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
            lang('@Online Help, Find relevant information for this panel, in Program wiki. ').
            lang('@(When Wiki for').' '.$ØProgTitl.' '.lang('@is created...) ').
            lang('@You can also help maintain help and guidance here as the WIKI is editable.').'"><img src= "'.$_assets.
            'images/wikilogo.png " alt="Wiki" style="width:20px;height:20px; margin-right:2px; float:right;" '.'> </a>';

## PANEL-START:
    echo  '<span class="'.$class.'" id="panel'.$ØPanelIx.'" '.$more.' style="position: relative; left: -6px; '.$panlBg.'"> '. $formCrea.
            '<span class="panelTitl" style="'.$Ph.' color:'.$ØTitleColr.'; cursor:row-resize; text-align: left; display: inline-block;  min-height:26px;" '.
            'data-tiptxt="'. lang('@Click to open / close this panel').'" title="'. lang('@Click to open / close this panel').
            '" onclick= PanelSwitch'.$ØPanelIx.'(); >';  //  Panel-Header
    echo  '<ic class="'.$icon.'" style="font-size:20px;color:brown;"> </ic> &nbsp;'.ucfirst(lang($capt)).$fn;
    /* 
    echo  '<ic class="fas fa-angle-double-up" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:zoom-out;" '.
            'title="'. lang('@Click to close all panels').';" onclick= PanelMinimizeAll(); ></ic>';
    echo  '<ic class="fas fa-angle-double-down" style="width:12px; height:12px; margin-top:6px; margin-right:0px; float:right; cursor:zoom-in;" '.
            'title="'. lang('@Click to open all panels').';"  onclick= PanelMaximizeAll(); ></ic>';
            //  data-tiptxt virker ikke ovenfor, derfor: title !
    /* */
    if ($wikilnk > '') echo  $wikilnk;
    echo  '</span>'; // panelTitl
    //echo '</ div>'; //  Panel-Header
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

 
// JS functioner for Panel håndtering:
function PanelInit() { $maxPanels= 10;
    echo '<script>';
        echo 'function PanelMinimizeAll() {';
        for ($Ix=1; $Ix<=$maxPanels; $Ix++) { echo '
                var h = document.getElementById("HideDiv'.$Ix.'"); 
                var p = document.getElementById("panel'.$Ix.'");';  
                echo ' h.style.display = "none"; p.style.width = "240px"; ';
            }
        echo ' }';
        echo 'function PanelMaximizeAll() {';
        for ($Ix=1; $Ix<=$maxPanels; $Ix++) { echo ' 
                var h = document.getElementById("HideDiv'.$Ix.'"); 
                var p = document.getElementById("panel'.$Ix.'"); ';  
                echo ' h.style.display = "block"; ';    // p.style.width = "100%"; ';}
            }
        echo ' $("table").trigger("applyWidgets"); }';
    echo '</script>';
    //echo ' $("table").trigger("applyWidgets");';
}
  // Når et panel har været klappet sammen, skal Zebra gen-initieres:
  // run_script('$("table").trigger("applyWidgets");');  //  Opdatere Zebra: https://mottie.github.io/tablesorter/docs/example-widget-zebra.html
  // Det virker ikke her!

function PanelMin($nr) {    // run_Script('PanelMinimize'.$nr.'();');
    echo '<script> PanelMinimize'.$nr.'(); </script>';
}
function PanelMinimer($Last) {
    echo '<script> ';
        for ($nr=0; $nr<=$Last; $nr++) echo 'PanelMinimize'.$nr.'(); ';
    echo '</script>';
}
function PanelInitier($First,$Last) { //  Minimer et interval
    echo '<script> ';
        for ($nr=$First; $nr<=$Last; $nr++) echo 'PanelMinimize'.$nr.'(); ';
    echo '</script>';
}
function PanelMax($nr) {
    echo '<script> PanelMaximize'.$nr.'(); </script>';
}
# Fremtidig benyttelse:
function PanelOff($First,$Last) {   //  Minimer et interval
    PanelInitier($First,$Last);
}
function PanelOn($nrFra,$nrTil=0) { //  Maksimer et enkelt eller et interval
    if ($nrTil<$nrFra) $nrTil= $nrFra;
    for ($nr=$nrFra; $nr<=$nrTil; $nr++) PanelMax($nr);
}
function PanelBetjening() { // Pt. ikke i brug
    htm_Caption('@Click the individual panel headers to view / hide the contents of the panels.');
    execKnap($label= '@Minimize all', $title ='@Hide content in all panels', $function = 'PanelMinimizeAll ()');
    execKnap($label= '@Maximize all', $title ='@View content in all panels', $function = 'PanelMaximizeAll()');
}


function htm_AcceptButt( # $labl='', $title='', $btnKind='', $form='', $width='', $akey='', $proc=false, $tipplc='LblTip_text')
    $labl='',               # The caption on the button
    $title='',              # Hint about the button function
    $btnKind='',            # save, navi, goon, erase, create, home (Appearance)
    $form='',               # A form Will be created, if a name is given
    $width='',              # The width of the button
    $akey='',               # Shortcut to activate the button
    $proc=false,            # Act as procedure: Echo result, or as function: Return string
    $tipplc='LblTip_text'   # Class for Placement of the tooltip
    ) 
{   global $ØShortKeys;
    dvl_pretty('htm_htm_AcceptButt');
    // Colors:
    $ØButtnBgrd= '#44BB44';  /* LysGrøn   */     $ØButtnText= '#FFFFFF';   /* Hvid   */
    $ØBtLnkBgrd= 'yellow';   /* '#FCFCCC';  */   $ØBtLnkText= '#000000';
    $ØTextLight= 'white';       $ØTextDark= 'black'; 
    $ØBtDelBgrd= 'Crimson ';    $ØBtDelText= $ØTextLight;   # Slet:RØD
    //$ØBtSavBgrd= 'yellow';      $ØBtSavText= $ØTextDark;  # Gem/Submit:GUL
    $ØBtSavBgrd= '#0064b4';     $ØBtSavText= $ØTextLight;   # Gem/Submit:BLUE
    $ØBtNavBgrd= '#269B26';     $ØBtNavText= $ØTextLight;   # Naviger:GRØN
    $ØBtGooBgrd= '#66CDAA';     $ØBtGooText= $ØTextDark;    # Fortsæt:MARINE
    $ØBtNewBgrd= 'Orange';      $ØBtNewText= $ØTextDark;    # OpretNy:ORANGE
    $Ødimmed=    ' opacity:0.8;';
    // Initiate:
    if ($form) {$name= $form; $form=' form="'.$form.'" ';} else {$name= '_none'; }
    if ($width) $width= ' width: '.$width.';';
  
## Shortcuts:
    $keytip='';
    if ($ØShortKeys) {
        if ($akey>'') $genv=' ´<i>'.$akey.'</i>´'; else $genv='';
        if (!$genv) $keytip=''; else $keytip= '<br><em>'.lang('@Keyboard shortcut: ').$akey.'</em>';
    }
## Appearance & name:
    switch ($btnKind) {
    case 'save'   : {$colors= ' background:'.$ØBtSavBgrd.'; color:'.$ØBtSavText.';'.$Ødimmed;}  $midn= 'sav_';  break; # Submit-Butt: BLUE
    case 'navi'   : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= 'nav_';  break; # navigate-Butt: GREEN 
    case 'goon'   : {$colors= ' background:'.$ØBtGooBgrd.'; color:'.$ØBtGooText.';'.$Ødimmed;}  $midn= 'goo_';  break; # Continue-Butt-Butt: SEA ​​GREEN 
    case 'erase'  : {$colors= ' background:'.$ØBtDelBgrd.'; color:'.$ØTextLight.';'.$Ødimmed;}  $midn= 'era_';  break; # Delete: RED  
    case 'create' : {$colors= ' background:'.$ØBtNewBgrd.'; color:'.$ØBtNewText.';'.$Ødimmed;}  $midn= 'cre_';  break; # Create new: ORANGE
    case 'home'   : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= 'hom_';  break; # navigate-Butt: GREEN 
    default       : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= $labl;          # navigate-Butt: GREEN
  }
## Function:
    $result=  '<span class="center" style="height:25px; ">'; 
    $result.= '<abbr class="hint"> ';
    $result.= '  <button class="acceptbutt" '.$form.' type= "submit" name="btn_'.$midn.$name.'" id="btn_'.$midn.$name.
              '" style="'.$width. $colors.'" accesskey="'.$akey.'"> '. ucfirst(lang($labl)).
              '  </button>';
    $result.= '  <data-hint>'.lang($title).$keytip.'</data-hint> ';
    $result.= '</abbr> ';
    $result.= '</span>';
  // if ($func!='rtrn') echo $result;
  // else return $result;
  if ($proc==true) echo $result; else return $result;
} # :htm_AcceptButt()


function htm_PagePrep($pageTitl='', $ØPageImage='') {   # Prepare / initialize a page
    global $CSS_style, $ØTitleColr;                       # Must be followed of htm_PageFina() to finalise the page
    
    echo '<!DOCTYPE html>';
    echo '<html lang="da" dir="ltr">';
    echo "\n<head>\n";
    echo '  <meta charset="UTF-8">';
    echo '  <meta name="viewport" content="width=device-width, initial-scale=1.0">';  // dvl_ekko('htm_PagePrep');
    echo '  <meta name="robots" content="Noindex, Nofollow">';                        // Reject robots
    echo '  <title>'.$pageTitl.'</title>'. "\n";                                      dvl_pretty('htm_PagePrep');

# include_once $_base."msg_lib.php";      #+  Nødvendigt dialog-system 
# include_once $_base."std_func.php";     #+  Standard blandede funktioner 
# include_once $_base."fil_func.php";     #+  Funktioner med filer involveret 
# include_once $_base."dbi_func.php";     #+  Forbedrede DataBase-funktioner, kompatible med PHP7
# include_once $_base."version.php";      #+  Initiering af globale konstanter 
# include_once $_config."connect.php";    #+  Database tilkobling

# echo '  <link rel="stylesheet" type="text/css" href= "'.$_base.'out_style.css.php" />';         //  emne="out_modulers style" /* _base/ */
# echo '  <link rel="stylesheet" type="text/css" href= "'.$_base.'msg_lib.css.php" />';
# echo '  <link rel="stylesheet" type="text/css" href= "'.$_config.'_custom\custom.css" />';   //  Bruger tilpassede ændringer af standard


### ----------------------Library-jQuery-------------------------
### jQuery-latest:
    echo '<script src="./_assets/jquery/3/jquery-3.3.1.js"></script>'; // latest //  emne="Tablesorter-system" og Topmenu-system

### ----------------------Library-Tablesorter-------------------------
//$path= './../_assets/tablesorter/';
    $path= './_assets/tablesorter/';
// Tablesorter script: required 
    echo '<script src="'.$path.'js/jquery.tablesorter.js"></script>';               //  emne="Tablesorter-system"
    echo '<script src="'.$path.'js/widgets/widget-filter.js"></script>';            //  emne="Tablesorter-system"
    echo '<script src="'.$path.'js/widgets/widget-stickyHeaders.js"></script>';     //  emne="Tablesorter-system"
    echo '<script src="'.$path.'js/parsers/parser-input-select.js"></script>';      //  emne="Tablesorter-extra"
    echo '<link rel="stylesheet" href="'.$path.'css/theme.blue.css"/>';             //  emne="Tablesorter-system" (choose a theme file)
  
    echo "
<script>
  $(function () {
    $('table').tablesorter({
      theme: 'blue',
      dateFormat : \"Y-m-d\",
   // showProcessing : true, 
      widgets: ['zebra', 'stickyHeaders', 'filter'],  
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
        stickyHeaders_filteredToTop: true,  // scroll table top into view after filtering ". 
     // filter_columnFilters : false,
        "filter_hideFilters : true,
        filter_reset : '.reset',
        filter_functions: {
          0: {
            '{empty}' : ".'function (e, n, f, i, $r, c) {'."
              return $.trim(e) === '';
            }
          }
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
    
    /*  columnSelector_columns : {    5 : false,    6 : false} */
    
    // make second table scroll within its wrapper
    $('#smarttabel, #table0, #table1, #table2, #table3, #table4, #table5, #table6').tablesorter({
      widthFixed : true,
      headerTemplate : '{content} {icon}',  /* Add icon for various themes */
      widgets: [ 'zebra', 'stickyHeaders', 'filter' ],
      widgetOptions: {
            // jQuery selector or object to attach sticky header to
            stickyHeaders_attachTo : '.wrapper' // or $('.wrapper')
        }
    });
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
        $('#smarttabel, #table0, #table1, #table2, #table3, #table4, #table5, #table6, .nested').each(function() {
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
'."
    function togglePassword(butt,input) {
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
'."
</script>



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

.tablesorter-blue tfoot td {   /* footer */ 
    font: 12px/18px Arial, Sans-serif;
    font-weight: bold;
    color: #000;
    /* background-color: #99bfe6; */
    background-color: #eee;
    border-collapse: collapse;
    padding: 2px;
    text-shadow: 0 1px 0 rgba(204, 204, 204, 0.7);
}

.tablesorter .tablesorter-filter {  /* Prevents accidental min-width of filter fields */
    width: 100%;
}

</style>


<style id=".'css'.">  /* wrapper of table  */ 
.wrapper {
    position: relative;
  display: block;
    padding: 0 5px;
    height: 300px;   /* Adjusted in HTML: $ ViewHeight */
    overflow-y: auto;
}

#overlay {
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

$('#smarttabel, #table0, #table1, #table2, #table3, #table4, #table5, #table6').tablesorter-blue input.tablesorter-filter, .tablesorter-blue select.tablesorter-filter {
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

</style>
";
  
    run_Script("function toast(txt, bgcolr='#333', fgcolr='#fff') { 
        var x = document.getElementById('snackbar'); 
            x.innerHTML= txt;
            x.className = 'show'; 
            x.style.background = bgcolr;
            x.style.color = fgcolr;
            setTimeout(function(){ x.className = x.className.replace('show', ''); }, 5000); 
        }");
 
### ----------------------Library-fontawesome icons ----------------------
    //$source_Ajax = 'https://cdnjs.cloudflare.com/ajax/libs/'; 
    $source_Ajax = './_assets/font-awesome5/'; 
    echo '<link rel="stylesheet" href="'. $source_Ajax. '5.9.0/css/all.min.css">';
    //echo '<script defer src="'.$_assets.'font-awesome5/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.js"></script>';   //   emne= "ICON-system" version 5
  
    
    echo $CSS_style;    // Activate the system style
    echo '<style type="text/css"> <!--  @font-face { font-family: barcode; src: url(./_assets/fonts/barcode.ttf); } --> </style>';
    echo '<style type="text/css"> body { background: url('.$ØPageLogo.') right bottom no-repeat, url('.$ØPageImage.') left top repeat; font-family: sans-serif;} </style>';
    PanelInit();
  
    echo "\n</head>\n";
} // htm_PagePrep()


function htm_PageFina() {
    echo '<div id="snackbar">Short message</div>';
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
    </script>
    ";
    
    include('.././spormig.php');
    htm_nl(3);
    echo '  </body>'; // Started in htm_PagePrep()

    echo '</html>';
}

function htm_IconButt($type='submit',$faicon='',$labl='',$title='',$id='',$link='',$action='',$akey='',$size='32px',$fg='gray') 
{   global $ØButtnBgrd, $ØShortKeys, $btnix;
    if ($ØShortKeys) {
        if (!$akey) $tasttip=''; else $tasttip= '<br>'.lang('@Keyboard shortcut: ').$akey;
        if ($link=='') $targ= 'formtarget="_self"';
    }   dvl_pretty('htm_IconButt');
    $btnix++;
    $result = '
    <span class="tooltip" style="display:inline; padding:0; ">
        <button type= "'.$type.'" '.$targ.' id='.$id.' name="btn_ico_'.$btnix.'" style="color:'.$fg.'; background:white;" accesskey="'.$akey.'" '.$action.'>'.
        '<span class="LblTip_text">'.$title.$tasttip.'</span>'.
        ' <data-ic class="'.$faicon.'" style="font-size:'.$size.'; color:'.$fg.';  '.$ØButtnBgrd.'; "> </data-ic> '
        .lang($labl).
        '</button>'.
    '</span>'; 
    if ($size=='32px') echo $result;
    return $result;
}

function calcHash($usr_name,$usr_code) {
    return $result= "<span style='color:red;'>'".$usr_name."' => '".password_hash($usr_code, PASSWORD_BCRYPT)."',</span> // ".$usr_code;
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
        if (strlen($tip.' ')<140) {$wdth='';} else {$wdth='style ="min-width: 380px;"';}
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

if (!function_exists('dvl_ekko')) {
function dvl_ekko($testlabl='') {      // Debugging system - labels will be added in html-sourcecode
    if ((DEBUG) and ($testlabl>'')) {echo "<br>". $testlabl. "\n";}
}}


// String-output:
function htm_Ihead($source) {echo '<br/><i>'.$source.'</i> ';}
function htm_hr($c='#0')    {echo '<hr style="color:'.$c.';"/>';}
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


function arrPrint($arr,$name='') {  ## Output actual value of any variabeltype
    if ($name>'') $name.=': ';
    echo "<pre>".$name; print_r($arr);  echo "</pre><hr>";
}

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


if (!function_exists('lang')) {
    function lang($FraseKey) {                # lang() / trans() is used to translate all hard-coded program-text.
    global $ØsprogTabl, $ØprogSprog,          # Strings in single quotes with @-prefix is system-text, that can be tranlated to another language.
            $ØlanguageTable, $App_Conf;         # Be aware that a string, will not be translated more than once ! opmærksom på at samme frase, ikke kaldes flere gange f.eks. i rutiner i underniveauer.

    if (!function_exists('found_index')) {
    function found_index($sprogDB, $field, $value) {
    if ($sprogDB)
        foreach($sprogDB as $key => $row) {
        if ($row[$field] === $value)  
        {return $key; break;}
    }  return false;  # 'TranslateError';
    }}
    if (substr($FraseKey.' ',0,1)!='@') {return($FraseKey); exit;}  # Dont translate twice !
    $ØprogSprog= substr($App_Conf['language'],0,2);
    if (($ØprogSprog) and ($ØlanguageTable))    
    switch ($ØprogSprog= strtolower($ØprogSprog)) { # 0 Key - set index for lookup
        case 'da' :$ix= 1;  break;  # 1 Danish   
        case 'en' :$ix= 2;  break;  # 2 Engelsk 
        case 'de' :$ix= 3;  break;  # 3 Deutsch 
        case 'fr' :$ix= 4;  break;  # 4 Français
        case 'tr' :$ix= 5;  break;  # 5 Türkçe  
        case 'pl' :$ix= 6;  break;  # 6 Polski  
        case 'es' :$ix= 7;  break;  # 7 Español 
        case 'it' :$ix= 8;  break;  # 8 Italian 
        default   :{$ix= 1; echo "<data-colrlabl>Sprog?:".$ØprogSprog." </data-colrlabl>"; $ØprogSprog='da'; break;} // Er $ØprogSprog ugyldigt, sættes det til 'da'
    } else $ix= 1;
    $TblRow= found_index($ØlanguageTable, 0, $FraseKey);
    if (substr($FraseKey,0,2)=='@:') {};                                    # Er frasen med @:-prefix: (Angår blanketter/formularer) ikke benyttet endnu!
    if (substr($FraseKey,0,1)=='@')                                         # Er frasen med @-prefix:
        {if ($ØprogSprog=='da')  {$result= trim($FraseKey,'@');}           # Er sproget dansk fjernes @-prefix blot i resultatet, skal udkommenteres!
            else if ($TblRow>0) {$result= $ØlanguageTable[$TblRow][$ix];}     # ellers slås op i sprog-tabellen
            else 
            if (DEBUG) {$result= trim($FraseKey,'@');}
            else #{$result= $FraseKey.'<small><small> (Danish!)</small></small>'; $MissingFrase.='<br>'.$FraseKey;} # Oversættelse mangler: Vis $FraseKey  med @-prefix
            {$result= trim($FraseKey,'@');}
        }  
    else {$result= $FraseKey;}                                              # Fraser uden @-prefix returneres uændret.
    return($result= trim($result,',"'));
    }
}


/*
 * get language translations from json file
 * @param int $tr
 * @return array
 */
function sys_get_translations($tr) { global $lang_list;
    try {
        $content = @file_get_contents('.sys_trans.json');
        if($content !== FALSE) {
            $lng = json_decode($content, TRUE);
        // arrPrint($lng,'$lng');
            
            foreach ($lng["language"] as $key => $value)
            {   $lang_rec["code"]        = $value["code"];           // $value["code"];
                $lang_rec["name"]        = $value["name"];           // $value["name"];      Name in english
                $lang_rec["native"]      = $value["native"];         // $value["native"];    Name translated from english
                $lang_rec["author"]      = $value["author"];         // $value["author"];
                $lang_rec["note"]        = $value["note"];           // $value["note"];
                $lang_rec["translation"] = $value["translation"];
                $lang_list[]= $lang_rec;
                if ($tr) {
                    //$tr["native"] = $value["native"];
                    $tr[$value["code"]] = $value["translation"];    // $value["translation"];
                }
                if (substr($_SESSION['proglang'],0,2)==$lang_rec["code"]) $_SESSION['currLang']= $lang_rec;
                //if ('da'==$lang_rec["code"]) $_SESSION['currLang']= $lang_rec;
            }
            # if (false) // save pretty JSON-file:
            #     { $out = fopen('json.out', "w"); fwrite($out, PHP_EOL. print_r($value["translation"], true)); fclose($out); }
            // arrPrint($lang_list,'$lang_list');
            return $tr;
        }
    }
    catch (Exception $e) {
        echo $e;
    }
    // arrPrint($lang_list,'$lang_list');
}
$tr= sys_get_translations($tr);
//$_SESSION['trans'] = $tr;


function run_Script ($cmdStr) {
    echo "\n".'<script> '.$cmdStr.' </script>'."\n";
}

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

# DropDownList:string
function ddwnList($name,$valu,$optliste=[],$more='',$indiv=true) {
    dvl_pretty();
    if ($indiv) $Result= '<div style="margin-right:0;"> ';  else  $Result= ''; 
    $Result.= '<select class="styled-select" id="'.$name.'" name="'.$name.
              '" style="max-width:140px; background-color:transparent; '.$more.
              '"> '."\n".'<option label="" value="" > - </option>';  //  selected disabled hidden
    foreach ($optliste as $rec) { dvl_pretty();
      $titl= lang($rec[0]);
    #+  if (strpos('KtInterval',' '.$more)>0) {if (strlen(' '.$titl)>15) {$titl= ':'.substr($titl,0,15).'...';}} 
    #+  else {$titl= '';}
      $Result.= "\n".'<option label="'.$rec[2].'" value="'.$rec[1].'" title="'.$titl.'"'; //  .$rec[3]
        if ($rec[1]==$valu) $Result.= ' SELECTED ';
      $Result.= '>'.$lbl=lang($rec[2]).'</option> ';
      }
    $Result.= '</select>'; 
    if ($indiv) {$Result.='</div> ';}
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
$CSS_style = '
<style>

/* COLORPALETTE: (Central settings of used colors) */
:root {   /* Static nuances: */
    --roedColor: #FF0000;
    --guulColor: #F3F033;
    --grenColor: #336600; 
    --grenColr1: #448800;   /* placeholder-text */
    --lablColor: #1b5b22;   /* #363eba;   /* LysBlå: Labels Caption */ 
    --lablBgrnd: FloralWhite;
    --oranColor: #F37033;
    --brunColor: #550000;   /*  Table borders  */
    --grayColor: #ACA9A8;
    --xx11Color: #3CBC8D;
  /*   --HintsBgrd: rgba(55, 55, 55, 0.90);     --HintsText: #FFFFFF; */
    --HintsBgrd: rgba(240, 240, 240, 0.85); 
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
    --PageImage: url(../_assets/images/paper_fibers.png);   /* Side baggrundsbillede  */
    /* url understøttes ikke i browsere endnu! (March 29, 2016) https://blog.hospodarets.com/css_properties_in_depth  Images url like url(var(--image-url)) don’t work */
    --PageImage: <?php echo $ØPageImage; ?>;  /* Initieres i _base_init.php /Virker i ../_base/htm_pagePrepare.php */
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
        box-shadow: 2px 2px 1px var(--ButtnShad);
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


/* PANELS IN SPALTERS: (Adaptation to narrow screens) */
/* for 960px or greater */
@media screen and (min-width: 960px) {
    #spltwrap  {width: 1280px; padding: 0px;    /*  margin: 5px 5px; */}
    #spalt240  {width: 240px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt280  {width: 280px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt320  {width: 320px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt400  {width: 400px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt480  {width: 480px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt640  {width: 640px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt720  {width: 720px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt800  {width: 800px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt960  {width: 960px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spalt1100 {width:1100px;  padding: 5px 5px; margin: 5px 5px 5px 0px; float: left; }
    #spaltsaut {width: auto;   padding: 5px 0px 5px 5px; margin: 5px 0px 5px 0px; float: left;}
    data-PanlHead, PanlFoot  {clear: both;   padding: 0 5px;}
}

/* for 960px or less */
@media screen and (max-width: 960px) {
    #spltwrap  {width: 99%;  }
    #spalt320  {width: 41%;  padding: 5px 5px;   margin: 0px 0px 5px 5px;}
    #spaltsaut {width: auto; padding: 5px 5px;   margin-left: 0px;   clear: both;    float: none;  }
    data-PanlHead, PanlFoot {padding: 1px 5px;   clear: both;}
}
  
/* for 640px or less */
@media screen and (max-width: 640px) {
    #spalt320  {width: auto;  float: none;  margin-left: 5px; }
    #spaltsaut {width: auto;  float: none;  margin-left: 5px; }
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
    font-size: 0.82em;
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
    background-image: url(../_assets/images/eurosymbol60.png);
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

input[type=date]::-webkit-inner-spin-button,
input[type=date]::-webkit-outer-spin-button {
    -webkit-appearance: none; /* Hide in Chrome */
}

input[type="date"]::-webkit-calendar-picker-indicator{
    display:inline-block;
    margin-top:2%;
    float:right;
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
    width: 91%
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
    box-shadow: 2px 2px 1px var(--ButtnShad);  
    background-color: var(--lablBgrnd);
    /* margin: auto; */
    width: min-content;
    padding: 0 5px;
}
.boxStyle, .inpField input {
    box-shadow: 3px 4px 2px lightgray;
    border: 1px solid var(--grayColor);
    border-radius: 5px;
    margin: 5px;
    background-color: white;
}


    /* "ToolTip" with html content (formattet with html tags): */
    /* Example: <abbr class="hint">This activity will be open to registration on April 31st <data-hint>[ *the contents<b> you </b>would want to popup here* ]</data-hint></abbr> */

abbr.hint data-hint { 
    display: none;  
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
    width: 190px;           /* give this your own width */
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
    padding: 2px 6px; 
    height: 22px;
    
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
    /* min-width: 220px; */
    position: absolute;
    top: 30%;
    left: 50%;
    z-index: 666;
    transform: translate(-50%, -50%);
    color: var(--btnTxNorm);
    margin-top: 3px;
/*   max-width: 160px; */
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
    background-image: url("_background.png");
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
    margin: 2rem;
}

</style>
';  // End of $CSS_style

?>