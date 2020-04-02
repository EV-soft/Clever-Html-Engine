<?   $DocFile='../Proj1/php2html.lib.php';    $DocVers='5.0.0';    $DocRev1='2020-04-01';     $DocIni='evs';  $ModulNo=0;

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
 * ## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: ../LICENS_Copyright.txt
 
    Created: 2020-02-29 evs - EV-soft
    Latest revision: se at file top: $DocRevi
    R𝖾𝗏𝗂𝗌𝗂𝗈𝗇𝗌 𝗅𝗈𝗀:
    2020-00-00 - evs  Initial
    

 

### The basic MAIN FUNCTIONS:
function htm_Input($type, $name, $value, $label, $title, $disabl, $rows, $width, $step, $more, $placeholder)    // function htm_CombList
                                    # Combined Input field

function htm_CheckFlt($type, $name, $value, $label, $title, $disabl, $more, $newline)
                                    # Combined Checkbox and label

function htm_OptioFlt($type, $name, $value, $label, $title, $disabl, $optlist, $action, $events, $maxwd, $onForm, $newline) 
                                    # Combined Optionfields and label

function htm_Table($TblCapt, $RowPref, $RowBody, $RowSuff, &$tblData, $FilterOn, $SorterOn, $CreateRec, $ModifyRec, $ViewHeight, $CalledFrom, $Kriterie)    
                                    # Table with lots of functions (Create/Delete/Modify: record; Filter/Sort: rows; Striped rows)

function htm_PanlHead($frmName='', $capt='', $parms='', $icon='', $class='panelWmax', $func='Udefineret', $more='', $BookMark='../_base/page_Blindgyden.php') 
                                    # Start top of an avanced panel

function htm_PanlFoot( $pmpt='', $subm=false, $title='', $knapArt='', $akey='', $simu=false, $frmName='') { # SKAL følge efter htm_Panl_Top !
                                    # Finish bottom of an avanced panel

function htm_PagePrep(){}           # Prepare output to a page

function htm_PageBody(){}           # Set body of a page

function htm_PageFoot(){}           # Start bottom of a page

*/


### System init:
session_start();
# CONSTANTS:
define('DEBUG',false);              # Set to true to activate system debugging
define('LABELPOS','LeftRight');     # LeftLeft LeftRight TopLeft TopRight (Pos Align)
define('USEGRID',true); 
define ('ThousandsSeparator',' ');
define ('DecimalSeparator',',');
# GLOBALS:
$ØblueColor= 'lightblue';

function get_browser_name($user_agent) { # Call: get_browser_name($_SERVER['HTTP_USER_AGENT']);
    if     (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge'))    return 'Edge';
    elseif (strpos($user_agent, 'Chrome'))  return 'Chrome';
    elseif (strpos($user_agent, 'Safari'))  return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') ||  strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
    return 'Other';
}

### Functions:

// Call: htm_Input($type='',$name='',$valu='',$labl='',$titl='',$algn='left',$suff='',$disabl=false,$rows='2',$width='',$step='',$more='',$plho='Enter...',$dataList=[])   # Inputfield and label
function htm_Input(
    $type='',           # text, date, ... Look at source !
    $name='',           # Set the fields name and id
    $valu='',           # The current content in input field
    $labl='',           # Translated label above the input field
    $titl='',           # Translated desctiption about the field
    $algn='left',       # The alignment of input content Default: left
    $unit='',           # A unit added to the content eg. currency or % If in front: '<' it is added as a prefix, else a suffix
    $disabl=false,      # Disable the field. Default: field is active
    $rows='2',          # Number of rows in multiline input (eg. area/html) Default: 2
    $width='',          # Width of the field-container
    $step='',           # the value of stepup/stepdown for numbers
    $more='',           # Give more (special) input attrib
    $plho='@Enter...',  # Translated placeholder shown when field is empty. Default: Enter...
    $dataList=[]        # Data for "multi-list" (eg. options, checkbox, radiolist)
)
{ global $ØblueColor;
    dvl_pretty('htm_Input');
    $labl= lang($labl);     $titl= lang($titl);
    $browser= get_browser_name($_SERVER['HTTP_USER_AGENT']);
    if ($browser=='Firefox') $topArea= '-20px'; else $topArea= '-14px';
    if ($width=='') $width= '200px';    // Default width
if (substr($unit,0,1)=='<') { $pref= substr($unit,1); $suff= '';} else { $suff= $unit; $pref= ''; }
    switch ($type) {    # LABEL: Height and top: Offset (align label: left/center/right: change in CSS: Fieldstyle - text-align: xxx;)
        case 'rado' : $LablTip= Lbl_Tip($labl,$titl,'','13px;','-14px;');   break; 
        case 'area' : $LablTip= Lbl_Tip($labl,$titl,'','13px;',$topArea);   break; # Browser depended 
        case 'opti' : $LablTip= Lbl_Tip($labl,$titl,'','13px;','-14px');    break; 
        case 'chck' : $LablTip= Lbl_Tip($labl,$titl,'','13px;','-14px');    break; 
        case 'pass' : $LablTip= Lbl_Tip($labl,$titl,'','13px;','-44px;');   break; 
        default     : $LablTip= Lbl_Tip($labl,$titl,'','13px;');
    }
    $inpType=  '<span class="lablInput"> <input type= '; 
    $inpIdNm=  ' id="'.$name.'" name="'.$name.'"';
    $inpStyle= ' style="width: 97%; padding-top: 6px; text-align: '.$algn.'; '; 
    
    $patt1= ' pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" /> <label for="';
    $patt2= ' pattern="(\d{3})([\.])(\d{2})" />  <label for="';
    $eventInvalid= 'oninvalid="this.setCustomValidity(\''.lang('@Wrong data in ').lang($labl).' ! \')"';
    
    if (gettype($valu)== 'Float') $type= 'number'; 
    if (!$disabl==true) $aktiv= ''; else $aktiv=' disabled ';
    if ($plho=='')   $plh='';    else $plh=' placeholder="'.lang($plho).'" ';
    
    $str1= $eventInvalid.' '.$aktiv.$plh.$patt1.$name.'">'.$LablTip.'</label> </span>';
    switch ($type) {     // INPFIELD: Dim/Offset
        case 'area'     : 
        case 'html'     : $fldStyle = 'height: '.(34+$rows*16).'px;'; break; 
        case 'rado'     :
        case 'chck'     : $fldStyle = 'height: '.(17+count($dataList)*17).'px;'; break; 
        default         : $fldStyle = 'height: 32px; ';
    }
#GRID:
    if (USEGRID) echo '<div class="grid-item">';
#FIELD:
    echo '<span class="fieldStyle" name="inpField" style="'.$fldStyle.' width: '.$width.';">';
#INPUT & LABEL & TIP:   
    switch ($type) {     
        case 'date'     : echo $inpType.'"date" '.  $more. $inpStyle. $inpIdNm.'" value="'.$valu.
                                '" placeholder ="yyyy-mm-dd" '.$aktiv.' /> <label for="'.$name.'">'.$LablTip.'</label> </span>'; break;
    
        case 'intg'     : echo $inpType.'"number" '.$more. $inpStyle. $inpIdNm. ' step:'.$step.
                                '" value="'.$valu.'" '.$aktiv.$plh.' /> <label for="'.$name.'">'.$LablTip.'</label> </span>'; break;
        
        case 'text'     : echo $inpType.'"text" '.  $more. $inpStyle. $inpIdNm.'" '.$align.' value="'.$valu.'" '.
                                $eventInvalid.' '.  $aktiv.$plh.' /> <label for="'.$name.'">'.$LablTip.'</label> </span>'; break;
                        
        case 'dec0'     : # quantity
        case 'dec1'     : # Amount -  // SPACE as thousands separator
        case 'dec2'     : echo $inpType.'"text" '.  $more. $inpStyle. $inpIdNm. ';" value="'.$pref.number_format(
							(float)$valu,(int)substr($type,3,1),DecimalSeparator,ThousandsSeparator).$suff,'"  '. $str1; break; 
        
        case 'num0'     :
        case 'num1'     :
        case 'num2'     :   /* lang="en" to allow "."-char as decimal separator, and national ","-char */
        case 'num3'     : echo '<span class="lablInput"> <input type="number" '.$more.' lang="en" '.$inpStyle. $inpIdNm.'" width="'.$width.'px;" step="'.$step.'" id="'.$name.
                                '" name="'.$name.'" value="'.$pref,number_format(
								(float)$valu,(int)substr($type,3,1),DecimalSeparator,ThousandsSeparator).$suff,'" '.$eventInvalid.' '.$aktiv.$plh.$patt2.$name.'">'.$LablTip.'</label> </span>';  break; 
								// thousands separator ,|. is not allowed in number !  - https://codepen.io/nfisher/pen/YYJoYE/
    
        case 'barc'     : echo $inpType.'"text" '.$more. $inpStyle.' font-family:barcode; font-size:19px;"'. $inpIdNm. ' value="'.$valu.'" '.
                                $eventInvalid.' '.$aktiv.$plh.' /> <label for="'.$name.'" style="top: -54px;">'.$LablTip.'</label> </span>';  break; 
        
        case 'rado'     : echo '<label for="'.$name.'">'.$LablTip.'</label>'.
                                '<form action="">'.  // Qarn: Nestet form !
                                '<span class="fieldContent" style="top: -14px;"><small>';
                                foreach ($dataList as $rec) { // $dataList= [['Label','@ToolTip'],['Label','@ToolTip','checked'],['Label','@ToolTip'],...]
                                    echo '<input type= "radio" name="'.$name.'" value="'.$rec[0].'" '.$rec[2].'/>'. lang($rec[1]).'<br>';
                                }
                                echo '</small></span> </form>';  break; 
    
        case 'pass'     : echo '<div style="text-align: left;">'.
                                $inpType.'"password" '.$more. $inpIdNm.' style=" width: 67%;" value="'.$valu.'" '.$eventInvalid.' '.$aktiv.$plh.' onkeyup="getPassword('.$name.')" />'.
                                iconButt($type='button',$faicon='far fa-eye', $title= lang('@Show/Hide password'),$id='tgl_'.$name, $link='',$action='onmousedown="togglePassword('.'tgl_'.$name.','.$name.')"',$akey='',$size='',$labl='').
                                '</div>'.
                                '<label for="'.$name.'" style="top: -40px;">'.$LablTip.'</label> ';
                                $str= ' <span id="mtPoint'.$name.'"> 0</span>'. '/10';
                                echo
                                '<meter id= "pwPoint'.$name.'" style="position:relative; height:6px; top:-33px; width:97%;" '.
                                    'min="0" low="5" optimum="7" high="9" max="10" id="password-strength-meter" '.
                                    'title="'.lang('@Password strength: 0..10').'">'. // $str.'"'. // ' <span id=\"mtPoint\"'.$name.'> 0</span>'. '/10"'.
                                '</meter>';  break;
    
        case 'mail'     : echo $inpType.'"email" '.$more. $inpStyle. $inpIdNm.' value="'.$valu.'" '. $eventInvalid.' '. //  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                $aktiv.$plh.' /> <label for="'.$name.'">'.$LablTip.'</label> </span>';  break; 
    
        case 'hidd'     : echo '<input type= "hidden" id="'.$name.'" name="'.$name.'" value="'.$valu.'" />';  break; 
        
        case 'html'     : echo '<span class="lablInput" style="top: -17px;"> <small><div contenteditable="true" rows="'.$rows.'" id="'.$name.'" name="'.$name.
                                '" style="line-height:100%; min-height: 34px; background-color: white; border: 1px solid lightgray; padding: 2px;" '. //  Som area, men med html-indhold
                                $eventInvalid.' '.$aktiv.$plh.' data-placeholder="'.lang($plho).'" '.$more.' >'.$valu.'</div></small> <label for="'.$name.
                                '" style="top: '.((2+$rows)*-16).'px;">'.$LablTip.'</label> </span>  <br/>';
                                if ($disabl) echo '<script>document.getElementById("'.$name.'").contentEditable = "false"; </script>';
                                break; 
    
        case 'area'     : echo '<span class="lablInput"> <textarea rows="'.$rows.'" id="'.$name.'" name="'.$name.'" style="line-height:100%; width:97%; font-size: 1em;" '.
                                $eventInvalid.' '.$aktiv.$plh.' '.$more.' >'.$valu.'</textarea>   <label for="'.$name.'">'.$LablTip.'</label> </span>  <br/>';  break; 
        
        case 'chck'     : echo '<label for="'.$name.'">'.$LablTip.'</label>'.
                                '<form action="">'.  // Nestet form !
                                '<span class="fieldContent" style="top: -14px;"><small>';
                                foreach ($dataList as $rec) { // $dataList= [['@Label','@ToolTip'],['@Label','@ToolTip','checked'],['@Label','@ToolTip'],...]
                                    echo '<input type= "checkbox" name="'.$name.'" value="'.$rec[0].'" '.$rec[2].'/>'.  
                                    '<label for="'.$name.'" style="top: -2px;">'.Lbl_Tip($rec[0],$rec[1],'','11px; box-shadow:none; top: -3px').'</label>'.'<br>';
                                }
                                echo '</small></span> </form>';  break; 
    
        case 'opti'     : echo '<label for="'.$name.'">'.$LablTip.'</label>'.
                                '<span class="fieldContent" style="top: -14px; text-align: center;"><small>';
                                echo '<select class="styled-select" name="'.$name.'" '.$events.' '.$eventInvalid.' style="width: 80%; max-width: '.$maxwd.'; '.$colr.'" '.$aktiv.'> '; dvl_pretty();
                                echo '<option label="?" value="'.$valu.'">'.lang('@Select!').'</option> ';  # title="'.$titl.'"     selected="'.$valu.'"
                                foreach ($dataList as $rec) { # $dataList= [[0:Label, 1:Tip, 2:value, 3:Action],[...]]
                                    echo '<option '. /* .'label="'.lang($rec[2]).'" '. */ 'title="'.lang($rec[1]).'" value="'.$rec[0].'" '.$rec[3]; //  Firefox understøtter ikke Label !
                                    if ($rec[0]==$valu) echo ' selected ';
                                    echo '>'.$lbl=lang($rec[0]).'</option> ';
                                }
                                echo '</select>';
                                echo '</small></span>';  break; 
    
        default         : echo ' Illegal Type ! ';
        dvl_pretty();
    }
    echo '</span>'; # :FIELD
    
    if (USEGRID) echo '</div>'; # :GRID
} //  htm_Input

function htm_Table(
    $TblCapt= array( #['0:Label',   '1:Width',    '2:Type',    '3:OutFormat', '4:horJust',      '5:Tip',    '6:placeholder', '7:Content';], ['Næste record']
        ),
    $RowPref= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
        ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => knap
    $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
        ),
    $RowSuff= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
        ),            # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
    &$tblData,             # = array(),
    $FilterOn= true,       # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
    $SorterOn= true,       # Mulighed for at sortere records efter kolonne indhold
    $CreateRec=true,       # Mulighed for at oprette en record
    $ModifyRec=true,       # Mulighed for at vælge og ændre data i en row
    $ViewHeight= '400px',  # Højden af den synlige del af tabellens data
    $CalledFrom='', //= __FUNCTION__
    $Kriterie= ['','']    # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
  )                       # Felt 4: ($fieldModes), er sammensat af: [horJust, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
                          # 0:horJust - Argument(er) til .td: style="text-align:
                          # 1:FeltBgColor - Argument(er) til .td: background-color: 
                          # 2:FeltStyle - komplet udtryk, F.eks.: 'font-style:italic; '
                          # 3:TdColor - som 1: men benyttes til "række-markering"
                          # Kun påvirkning af Body-områder.
#!  FIXIT: Fixed/Sticky header virker kun på 1. tabel, når der er flere tabeller i samme vindue!
#!         Der forekommer også svigt af zebra-striber (Opdateringsproblem!), samt problemer med filter, når der er hidden kolonner.

{ global $ØblueColor, $ØLineBrun, $ØRollTabl, $ØHeaderFont, $ØIconStyle, $ØPanelIx, $ØTblIx, $ØrowCount, $Ønovice;
  $creaInpBg= '#ffffcc';
  $valgbar= (($ModifyRec) and ($RowBody[0][2]=='indx'));
  //if (!$tblData) {msg_Info('Ingen data','Data tabellen er tom! '); $tblData=[]; };  //  exit;
  if (DEBUG) dvl_pretty('Start-htm_Table: '.$CalledFrom);
  if (!$valgbar) $RowSelect= '';
  else         { $RowSelect= '<span class="tooltip"><span style="font-size:115%;">&#x21E8;</span>'.
                             '<span class="LblTip_text" style="bottom: -12px; left: 65px">'.lang('@Valgbar: ').str_nl(1).
                              lang('@Denne række kan vælges, ved at klikke på Id/Nummer i rækkens første felt.').'</span></span>';
               }
  if ($FilterOn)  {$filt= ' filter-true '; }   else $filt= ' filter-false ';  //  filter-select
  if ($SorterOn)  {$sort= ' sorter-inputs '; } else $sort= ' sorter-false ';
  
  $ØTblIx++;          //  0..7 på en page
  $tix= 'T'.$ØTblIx;  //  Tabel index for flere tabeller i samme vindue
  
  if (!function_exists('RowKlick')) {
    run_Script( 'function rowLookup(CalledFrom,valu,RowIx,ColIx) { window.alert("Du trykkede på " + valu + '.
    '"\nDet sker der ikke noget ved endnu...\nAngår: "+ CalledFrom +" Række: "+ RowIx );'.
    ' }');
    // Hent data i "kassekladder" svarende til valu, og vis dem i redigerings-tabel "kassekladde"
    // Kaldt fra $CalledFrom='Panl_Kassekladder' rediger i: Panl_KasseRedigering
    function RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix='',$CalledFrom) {
      if (!$ModifyRec) {return $rowix;} else return 
      '<span style=" padding:3px;" onclick="rowLookup(\''.$CalledFrom.'\',\''.$valu.'\',\''.$RowIx.'\',\''.$ColIx.'\')" >'.
      '<input name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" style="width:99%; text-align: center; border:0; '.
                    'text-decoration: underline; cursor:zoom-in;" readonly value='.$valu.' />'. '</span>'; 
    };
  }
   
  echo '<span class="tableStyle" name="tblField" style="width:'.$width.'; ">';
### Caption line:
  if ($TblCapt[0][0]>'') {    dvl_pretty();    // htm_nl(1);
    if ($TblCapt) foreach ($TblCapt as $Capt) { // $Capt[x]: 0:Label 1:width 2:type 3:(outFormat) 4:align 5:titletip 6:default 7:value
      $mode= '" placeholder="';
      echo ' '.lang($Capt[0]);  //  Label:  (feltPrefix)
      switch ($Capt[2]) {  # Special outputs:
        case 'show' : $mode= '" disabled value="';        break;
        case 'info' : echo count($tblData).lang($Capt[6]);   break;  //  $Capt[6]= feltSuffix
        case 'html' : echo ' '.lang($Capt[6]);                break;
        default: 
          echo ' <input type= "'.$Capt[2].'" name="note" title="'.lang($Capt[5]).   //  Input-field    
               $mode.lang($Capt[6]).'" style="width:'.$Capt[1].'; text-align:'.$Capt[4].';" value="'.lang($Capt[7]).'" />&nbsp;&nbsp;';
      }
    } // foreach-TblCapt
    
    if ((count($TblCapt)>1) or ($Capt[1]>"40%")) htm_nl(); //  false:Ved smalt panel
    if ($Ønovice) {
      htm_sp(5);
      if ($SorterOn)  {echo $sor= iconButt($type='submit',$faicon='fas fa-sort',$id='',
        $title= lang('@Click column headers to sort data. Hold SHIFT and click, to sort by multiple columns.'),
        $link='#',$action='',$akey='','12px',$labl='@Sortér?'); }
      if ($FilterOn)  {echo $fil= iconButt($type='submit',$faicon='fas fa-search-plus',$id='',
        $title= lang('@Hold your mouse just below the table`s header line and some input fields will appear. ').
                lang('@Enter a search term here to display only data that matches the term.'),
        $link='#',$action='',$akey='','12px',$labl='@Filtrér?'); }
      if ($FilterOn)  {echo $fil= iconButt($type='submit',$faicon='fas fa-search-minus',$id='',    //<button type="button" class="reset">lang('@Vis alt')</button>
        $title= lang('@Reset filter so that all data is displayed. With ESC you can reset the search term in the field you are in.'),
        $link='#',$action='',$akey='','12px',$labl='@Vis alt!'); }
      if ($ModifyRec) {echo $ret= iconButt($type='submit',$faicon='fas fa-pen-square',$id='', 
        $title= lang('@In some of this table`s columns, you can correct data. They are marked with · in the column heading.').str_nl().
                lang('@If the table cannot be saved, the correction must be done on a retail card.'),
        $link='#',$action='',$akey='','12px',$labl='@Rette?'); }
      if ($CreateRec) {echo $til= iconButt($type='submit',$faicon='fas fa-plus',$id='',       
        $title= lang('@Do you want to add data: <br>At the bottom of the table there are fields you can fill with new data. ').
                lang('@Click the "Create" button above the last field to save the new data.'),
        $link='#',$action='',$akey='','12px',$labl='@Tilføj?'); }
      if (true)  {echo $fil= iconButt($type='submit',$faicon='fas fa-arrows-alt-h',$id='',     
        $title= lang('@Move cursor in tables:').'<br><data-yelllabl>'.lang('@Tab-key').'</data-yelllabl> '.
          lang('@jumps to the next field.').' <data-yelllabl>'.lang('@SHIFT Tab-key').'</data-yelllabl> '.lang('@skips to the previous field.').
          ' <data-yelllabl>'.lang('@SPACE-key').'</data-yelllabl> '.lang('@scrolls side down').
          ' <data-yelllabl>'.lang('@SHIFT SPACE-key').'</data-yelllabl> '.lang('@scrolls side up').'<br>'.
          lang('@The cursor must be in the table.')
          /* .'  <br><data-yelllabl>'.lang('@CTRL Pil-taster').'</data-yelllabl> '.lang('@virker ikke. ' */
          ,$link='#',$action='',$akey='','12px',$labl='@Taster '); }
    }
  } dvl_pretty();
  
### Table-start:  
  echo '<span class="wrapper" style="padding:0; border:0px solid brown; height:'.$ViewHeight.'; display: block;">'; //  "Table-window": Container for tabel  display: inline ?
  echo '  <div id="overlay"></div>';
  echo '    <table class="tablesorter" id="table'.$ØTblIx.'" style="margin:0;">'; //  id= smarttabel eller 'table'.$ØTblIx  0..7
  echo '    <thead>';
  $filter_cellFilter= [];  //  [ '', 'hidden', '', 'hidden' ]
  
### Columns-LABELS with sorting:
  echo '    <tr style="height:32px;">'; 
  foreach ($RowPref as $Pref) { dvl_pretty(); 
      echo '<th class=" filter-false sorter-false" style="width:'.$Pref[1].' align:'.$Pref[4][0].'; '.$ØHeaderFont.'"> '.
            Lbl_Tip($Pref[0],$Pref[5],'SO',$h='0px').' </th>';
  }  $kNo= -1;
  if ($valgbar) echo  '<th class="filter-false sorter-false" > </th>';
  // class="wide" Kolonner, som er smallere end indholdet, kan vises ved at klikke på feltet: http://jsfiddle.net/Mottie/mstoa6cm/
  
  $hiddcount= 0;
  foreach ($RowBody as $Body) { dvl_pretty(); 
   // if ($Body[4][4]==false) $colfilt= ' filter-false'; else 
    $colfilt= ' ';
    if (($GLOBALS["Øshow"]>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
    if (is_null($Body[8])) $Body[8]= false;
    if ($Body[8]==true) $selt= ' filter-select filter-onlyAvail'; else $selt= ' ';  //  FIXIT: sortering af datofelter virker ikke!
    if ($Body[2]=='hidd') // FIXIT: visning af filter-felter, får kolonner ud af takt! - $filter_cellFilter virker tilsyneladende ikke: https://mottie.github.io/tablesorter/docs/#widget-filter-cellfilter
      { array_push($filter_cellFilter, 'hidden');
        $hiddcount++;
        echo '<th class="filter-false sorter-false" style="width:0; display:none;" ></th>'; // FIXIT: Filter-felter vises for skjulte kolonner! <td data-column="9" style="display:none" > fixer det
      } //  visibility:hidden;    //  columnSelector_columns : { 5 : false, 6 : false}
    else 
      { $kNo++; array_push($filter_cellFilter, '');   
        if ((($Body[2]=='text') or ($Body[2]=='data') or ($Body[2]=='date')or ($Body[2]=='osta')) and ($ModifyRec==true))
          {$editmark= '·'; $lblsuff= str_nl().lang('@Can be edited !');} else {$editmark= ''; $lblsuff=''; }
        if ($kNo<=1) $tipplc='SO'; else if ($kNo=1) $tipplc='S'; else $tipplc='SW'; // Placering af tip 1. og 2. kolonne
        if ($kNo==count($RowBody)) $tipplc='SW';  //  Sidste kolonne
        echo '<th class="'.$filt.$selt.$sort.$colfilt.'" data-placeholder= "Vis..." style="width:'.$Body[1].'; '.
             $ØHeaderFont.' text-align:center;">'.Lbl_Tip($Body[0].$editmark,$Body[5].$lblsuff,$tipplc,$h='0px').' </th>';  //  filter-select
  } }
  foreach ($RowSuff as $Suff) { dvl_pretty(); 
      echo '<th class="filter-false sorter-false" style="width:'.$Suff[1].'; align:'.$Suff[4][0].'; '.$ØHeaderFont.'">'.
            Lbl_Tip($Suff[0],$Suff[5],'SW',$h='0px').'</th>';
  }
  echo '    </tr>';    dvl_pretty();
### Column-FILTER:   (dannes af tablesorter, men der er et problem med hidd-felter!) filter-onlyAvail
  echo '    </thead>';

### TableFooter with the options to create a new record:
  echo '    <tfoot>';
  if ($CreateRec) { ## Opret data i ny tabelRow:
    echo '  <tr>';  //  Row med opretknap:
      if (($valgbar) or (count($RowPref)>=1))  echo  '<td> </td>';
      if (count($RowPref)>=2) {$colsp= 'colspan="2"'; $n= 2; } else {$colsp= ''; $n= 1; }
      echo '  <td style="font-size: 12px;" '.$colsp.'>'.lang('@Create new:').'</td>';
      for ($x= $n+1; $x < count($RowPref)+count($RowBody)-$hiddcount; $x++) {echo '<td> </td>';}
        echo '<td style="text-align:center;">'.
              htm_AcceptKnap($labl='@Create record', 
                $title=lang('@Fill in the fields below with data before clicking the Create button!'), $knapArt='create', 
                $form='form_'.$ØPanelIx.'_'.$ØTblIx, $width='', $akey='c', $func='rtrn', $tipplc='LblTip_NW').
              '</td>';
      for ($x= 1; $x <= count($RowSuff); $x++) {echo '<td style="width:'.$RowPref[1].';"> </td>';}
    echo ' </tr>';
    echo '  <tr>';  #  Row med input-felter:
    if ($valgbar) echo '<td style="width:0.5%;"> </td>';
    if ($RowPref) echo '<td style="text-align:right;"></td>';  // Data:
    $ColIx= -1; $bgclr= 'background-color:'.$creaInpBg.'; ';
    foreach ($RowBody as $Body) { $ColIx++;
      $s1= ' style="width:'.$Body[1].';" title="'.lang($Body[5]).'">';
      $s2= $name='New_Row0Col'.$ColIx.'[]' ;
      if ($Body[6]=='@Numr...') $oblg= lang('@Mandatory'); else $oblg= '';
      if (($GLOBALS["Øshow"]>0) and ($Body[2]=='hidd')) $Body[2]= 'text';
      switch ($Body[2]) {  # Specielle InpTyper:
      case 'moms' : echo '<td'.$s1.htm_SelectStr($s2,$valu,MomsListe(),$bgclr.'width:45px; ').'</td>';  break;
      case 'kont' : echo '<td'.$s1.htm_SelectStr($s2,$valu,KontListe(),$bgclr.'width:35px; ').'</td>';  break;
      case 'valu' : echo '<td'.$s1.htm_SelectStr($s2,$valu,ValuListe(),$bgclr.'width:55px; ').'</td>';  break;
      case 'stat' : echo '<td'.$s1.htm_SelectStr($s2,$valu,StatListe(),$bgclr.'width:65px; ').'</td>';  break;  //  Konto status
      case 'osta' : echo '<td'.$s1.htm_SelectStr($s2,$valu,OrdrStatu(),$bgclr.'width:70px; ').'</td>';  break;  //  Ordre status
      case 'just' : echo '<td'.$s1.htm_SelectStr($s2,$valu,JustListe(),$bgclr.'width:35px; ').'</td>';  break;
      case 'side' : echo '<td'.$s1.htm_SelectStr($s2,$valu,Side_List(),$bgclr.'width:35px; ').'</td>';  break;
      case 'font' : echo '<td'.$s1.htm_SelectStr($s2,$valu,FontListe(),$bgclr.'width:75px; ').'</td>';  break;
      case 'show' : //  Kun visning af data:
      case 'indx' : echo '<td style="width:'.$Body[1].'; text-align:center">'.lang($Body[6]).'</td>';   break;  //  Kun visning af data:
      case 'hidd' : echo '<td style="width:0; padding:0; display:none; '.$bord.'">  <input type= "hidden" name="Kol'.$ColIx.'[]" '.
              'value="'.htmlentities(stripslashes(lang($valu))).'" style=" width:0; display:none;"/></td> '; break; //  Ingen visning af data:
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

  echo '<style> $("#table'.$ØTblIx.'").tablesorter({ widgetOptions { filter_cellFilter: ["'.implode('","',$filter_cellFilter). '"]}} </style>';  // Skjule filter input-felter for hidden kolonner

### DATA and html-objects:
  echo '     <tbody>';
  if (!function_exists('RowBg')) {
    function RowBg($clr,$alg,$pos='') { if ($pos>'') $bord= ' border-'.$pos.':3px solid gray; '; else $bord= '';
      return ' background:'.$clr.'; vertical-align:'.$alg.'; height:1.5em; '.$bord.' '; };
  }
  $RowIx=-1;
  if ($tblData)
  foreach ($tblData as $Drow) { $RowIx++; dvl_pretty();
  
    echo '<tr class="row">';  //  Tablesorter med Zebra-stribet baggrund
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
      if ($ColDrop> 0) {/* Kolonne efter colspan springes over */ $ColDrop= $ColDrop-1; $ColIx++;}
      else
      { $ColIx++;    dvl_pretty();
        if (is_array($Drow[$ColIx])) 
              $valu= $Drow[$ColIx][0];
        else  $valu= $Drow[$ColIx];   
        
      ## Specielle Output formater:
        if (!$GLOBALS["Øshow"]>0)
        switch ($Body[3]) {  
          case '0d': if ($valu==null) $valu= 0;     else $valu= number_format((float)$valu, 0,',','.'); break;
          case '1d': if ($valu==null) $valu='';     else $valu= number_format((float)$valu, 1,',','.'); break;
          case '2d': if ($valu==' ')  $valu= $valu; else
                       if ($valu==null) $valu='';   else $valu= number_format((float)$valu, 2,',','.'); break;  //  88.888.888,88
          case '2%': if ($valu==' ')  $valu= $valu; else
                       if ($valu==null) $valu='';   else $valu= number_format((float)$valu, 2).' %';     break;
          case '>0': if (!(float)$valu>0) $valu= ' ';       break; // 0 og mindre værdier vises som BLANK
          case '= ': $valu= ' ';                            break; // værdier vises som BLANK
          default: $valu= $valu;
        } 
        
        $flag= substr($valu,1,2);
        if (($flag=='::') or ($flag==':.')) $valu= substr($valu,2).' '; // feltFlag vises ikke. SPACE så placeholder ikke vises.
      ## Specielle kolonne-formater:
        if (is_string($Body[4][0]))  $txAlign= ' style="text-align:'.$Body[4][0].'; '; else $txAlign= '';
        if (is_string($Body[4][1]))  $bgColor= ' background-color:'. $Body[4][1].'; '; else $bgColor= '';
        if (is_string($Body[4][2]))  $fltStyl= ' '.                  $Body[4][2].' ';  else $fltStyl= '';   // F.eks.: 'font-style:italic; '
        if (is_string($Body[4][3]))  $tdColor= ' background-color:'. $Body[4][3].'; '; else $tdColor= '';
        
      ## Specielle betingede "række"-formater:
        if ($Kriterie==['','']) $kontotype= '';
        
        if ($ColIx<count($Drow)) {  //  Hvis colspan forekommer stoppes her, når rækken er slut
          echo '<td style="text-align:'.$Body[4][0].'; width:'.$Body[1].'; '.$bgColor.$tdColor.$rowBg.$colsp; //  tabelfelt-egenskaber
        ## Specielle InputTyper i tabelfelt:
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
                          //  DropDown-selector:
            case 'moms' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,MomsListe(),'width:45px; ');  break; 
            case 'just' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,JustListe(),'width:35px; ');  break;
            case 'side' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,Side_List(),'width:35px; ');  break;
            case 'font' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,FontListe(),'width:75px; ');  break;
            case 'kont' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,KontListe(),'width:35px; ');  break;
            case 'valu' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,ValuListe(),'width:55px; ');  break;
            case 'stat' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,StatListe(),'width:65px; ');  break;
            case 'osta' : echo '">'.htm_SelectStr($name= $tix.'Row'.$RowIx.'Col'.$ColIx.'[]' ,$valu,OrdrStatu(),'width:70px; ');  break;  //  Ordre status
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
            case 'keyn' : //  Valgbart, og redigerbart index
                          echo '"><span style="font-size:small" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix,$CalledFrom).'</span>';  
                          break;
            case 'indx' : //  Valgbart, men ikke redigerbart index
                          //  < input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.'value="'.$valu.'" /> 
                          //  echo '"><span style="font-size:small" title="'.lang('@Rækken er valgbar. Klik her for at vise alle felter').'">'.
                          //    RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix,$CalledFrom).' <input type= "text" name="Row'.$RowIx.'Col'.$ColIx.'[]" '.'value="'.$valu.'" style="visibility: hidden; width:0; height:0;" /> </span>';  
                          echo '"><span style="font-size:small" title="'.lang('@The row is selectable. Click here to edit the row`s fields').'">'.
                                RowKlick($ModifyRec,$valu,$RowIx,$ColIx,$tix,$CalledFrom).' </span>';  
                          break;
            case 'blnk' : //  Værdi vises som BLANK
                          echo '"><span > </span>';  
                          break;
            case 'hidd' : //  Skjulte data medtages som skjulte kolonner, for at have en komplet record (gør opdatering simplere):
                          echo 'width:0; padding:0; border:none; display:none;">  <input type= "hidden" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]" '.  //   visibility:hidden;
                               'value="'.htmlentities(stripslashes(lang($valu))).'" '.$txAlign.$inpBg.' width:0;" /> ';
                          break;
                         // text, 
            default   : { echo '"> <input type= "text" name="'.$tix.'Row'.$RowIx.'Col'.$ColIx.'[]"  form="form_'.$ØPanelIx.'_'.$ØTblIx.'" value="'.$valu.'" '.
                               'placeholder="'.lang($Body[6]).'"'.$txAlign.$inpBg.$fltStyl.' width:98%; font-style:inherit;" /> ';
                        }
          }   // switch InputTyper
          echo '</td>'; //  tabelfelt slut
        }
      };  //  foreach $RowBody

### Table-BODY-RowSuffix:
    foreach ($RowSuff as $Suff) { dvl_pretty();
      if ($ModifyRec) {
        $output= $Suff[6];
        if ($Suff[2]=='button') { ## Specielle-knapper i RowSuffix:
          $btnStyle= '" class="tooltip" style="height:20px; border:0; box-shadow:none; background-color:transparent;" ';
          $btnSuff= $ØTblIx.'_'.$RowIx. $btnStyle;
          if ($Suff[0]=='@Delete')  { if ($Suff[3]=='dis') $dis= 'disabled'; else $dis= '';
                                    $output='<button type= "submit" name="btn_del_'.$btnSuff.$dis.' >'.
                                  Lbl_Tip($Suff[6],lang('@Delete pos: ').$RowIx.' ('.$dis.')','SW','0px'). '</button>'; }   // Knap som ikke må slette, kan deaktivers
          if ($Suff[0]=='@Hide') { $output='<button type= "submit" name="btn_hid_'.$btnSuff.'>'.
                                  Lbl_Tip($Suff[6],lang('@Hide pos: ').$RowIx,'SW','0px'). '</button>'; }                // Records som ikke må slettes, kan skjules
          if ($Suff[0]=='@Copy')  { $output='<button type= "submit" name="btn_cpy_' .$btnSuff.'>'.
                                  Lbl_Tip($Suff[6],lang('@Copy pos: ').$RowIx,'SW','0px'). '</button>'; }
          if ($Suff[0]=='@Rename') { $output='<button type= "submit" name="btn_ren_'.$btnSuff.'>'.
                                  Lbl_Tip($Suff[6],lang('@Rename pos: ').$ØTblIx.'_'.$RowIx,'SW','0px'). '</button>'; } 
          if ($Suff[0]=='@Select') { $output='<input type= "checkbox" name="btn_sel_'.$btnSuff.
                                  Lbl_Tip($Suff[6],lang('@Select pos: ').$RowIx,'SW','0px'). ' />'; }
        }
        echo '<td style="text-align:'.$Suff[4][0].'; width:'.$Suff[1].';" disabled >'.$output.'</td>';
      }
    } //  ['@Slet',     '4%',         'text',         '',        'center',   '@Klik på rødt kryds for at slette  ', '<ic class="far fa-times-circle" style="color:red; font-size:13px;"></ic>']
      //  ['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:FeltJust', '5:ColTip', '6:value!     '            ]
    echo '</tr>';
    
  } //  foreach $tblData
  $_SESSION["ØrowCount"]['T'.$ØTblIx]= $RowIx;
  
  echo '    </tbody>';
  echo '  </table>';
  echo '</span>';  //  wrapper
      echo '</span>';

  if (DEBUG) dvl_pretty('Slut-htm_Table: '.$CalledFrom);
} // htm_Table


function htm_PanlHead($frmName='', $capt='', $parms='', $icon='', $class='panelWmax', $func='Undefined', $more='', $BookMark='../_base/page_Blindgyden.php')
{ # MUST be followed of htm_PanlFoot !
  global $ØTitleColr, $ØPanlForm, $ØProgRoot, $ØPanelIx, $ØBodyBcgrd; 
  $ØPanelIx++;
  echo '<script>';  //  Hide/show Panel-Body
  echo 'function PanelSwitch'.$ØPanelIx.'() {';
  echo '    var h = document.getElementById("HideDiv'.$ØPanelIx.'");';
  echo '    var p = document.getElementById("panel'.$ØPanelIx.'");';
  echo '    if (h.style.display === "none") { h.style.display = "block"; p.style.width = "100%"; $("table").trigger("applyWidgets");} 
            else { h.style.display = "none"; p.style.width = "100%"; } }'; //   
  echo 'function PanelMinimize'.$ØPanelIx.'() {';
  echo '    var h = document.getElementById("HideDiv'.$ØPanelIx.'");  var p = document.getElementById("panel'.$ØPanelIx.'");';
  echo '    h.style.display = "none"; p.style.width = "100%"; }';  //h.style.width = "480px"; }';
  echo 'function PanelMaximize'.$ØPanelIx.'() {';
  echo '    var h = document.getElementById("HideDiv'.$ØPanelIx.'");  var p = document.getElementById("panel'.$ØPanelIx.'");';
  echo '    h.style.display = "block"; p.style.width = "100%"; $("table").trigger("applyWidgets");}'; //  $("table").trigger("applyWidgets"); Refresh de tidliger skjulte tablesorter objekter.
  echo '</script>';
  dvl_pretty('htm_PanlHead');
  if ($capt=='') $Ph= 'height:0px;'; else $Ph= '';
  
  if ($frmName>'') { //  Without name form will not be created, so local forms can be used !
        $ØPanlForm= true;  
        echo "\n\n".'<form name="'.$frmName.'" id="'.$frmName.'" action="'.$parms.'" method="post">'."\n"; 
    }               //  "ParentForm" - Nestet forms is not allowed, so sub-forms has to specially handled!
  else $ØPanlForm= false;
  
  if (DEBUG) {$fn= '&nbsp; <small><small><small>'.$func.'()</small></small></small>';} 
  else        $fn= '';
  $source='https://www.ev-soft.dk/saldi-wiki/doku.php?id=';  $book= 'legeplads:';  $mark= '#';
  
  if (strpos('#',$BookMark.' ')>0) $BookMark= $book.$mark.$BookMark;
  else
  if (strpos('legeplads',$BookMark.' ')>0) {
    if ($BookMark=='../_base/page_Blindgyden.php') {$source= $BookMark; $BookMark= '';};
    if ($BookMark=='') { $wikilnk= '';  $source=''; }
  };
  if (strpos($BookMark,'page_Blindgyden.php'))  $wikilnk=''; 
  else  $wikilnk= '<a href="'.$source.$BookMark.'" target="_blank" title="'.
        lang('@Online Help, Find relevant information for this panel, in Program wiki. (When Wiki for '.$ØProgTitl.' '.lang('@is created...) ')).
        lang('@You can also help maintain help and guidance here as the WIKI is editable.').'"><img src= "'.$ØProgRoot.
        '_assets/images/wikilogo.png " alt="Wiki" style="width:20px;height:20px; margin-right:2px; float:right;" '.'> </a>';
        
  echo  '<span class="'.$class.'" id="panel'.$ØPanelIx.'" '.$more.' style="position: relative; left: -6px;"> '.    //  Panel-start 
        '<span class="panelTitl" style="'.$Ph.' color:'.$ØTitleColr.'; cursor:row-resize; text-align: left; display: inline-block;  min-height:26px;" '.
        'data-tiptxt="'. lang('@Click to open / close this panel').'" title="'. lang('@Click to open / close this panel').
        '" onclick= PanelSwitch'.$ØPanelIx.'(); >';  //  Panel-Header
  echo  '<ic class="'.$icon.'" style="font-size:20px;color:brown;"> </ic> &nbsp;'.ucfirst(lang($capt)).$fn;
  echo  '<ic class="fas fa-angle-double-up" style="width:12px; height:12px; margin-top:6px; margin-right:4px; float:right; cursor:zoom-out;" '.
        'title="'. lang('@Click to close all panels').';" onclick= PanelMinimizeAll(); ></ic>';
  echo  '<ic class="fas fa-angle-double-down" style="width:12px; height:12px; margin-top:6px; margin-right:0px; float:right; cursor:zoom-in;" '.
        'title="'. lang('@Click to open all panels').';"  onclick= PanelMaximizeAll(); ></ic>';
  echo  $wikilnk; //  data-tiptxt virker ikke ovenfor, derfor: title !
  echo  '</span>'; // panelTitl
  //echo '</ div>'; //  Panel-Header
  echo '<span id="HideDiv'.$ØPanelIx.'" style="background:'.$ØBodyBcgrd.';">';   // Hide from here ! 
  if ($capt!='') echo '<hr class="style13" style="margin: 6px 6px 6px 0;"/>';
} // htm_PanlHead - # Panelets < /Panel-span>, < /hiding> og < /form> er placeret i htm_PanlFoot, som skal kaldes til slut!

function htm_PanlFoot( $pmpt='', $subm=false, $title='', $knapArt='save', $akey='', $simu=false, $frmName='') 
{ # MUST follow after htm_PanlHead and panel content !
  global $ØPanlForm;    dvl_pretty('htm_PanlFoot ');
  if ($title=='') {$title= '@Remember to save here if you fixed anything above, before leaving the window.'; $knapArt='save';}
  if ($ØPanlForm)
    if ($subm==true) {
      echo '<hr class="style13" style= "height:4px;">'.
           '<span class="center" style="height:25px">';  
      if ($simu) {
        htm_CheckFlt($type='checkbox',$name='sim', $valu= $Ønovice, $labl='@Simulations? ', $titl='@Simulations, ie look, but don`t save immediately',$disabl=false);//  Simuler
        htm_sp(3);
      }
      htm_AcceptKnap($pmpt, $title, $knapArt, $frmName, $width='', $akey, $func='');
      echo '</span>';
    }                                                                                       
  echo '</span>';  // HideDiv to here !
  echo '</span>';  // Panel-end
  if ($ØPanlForm) echo "\n".'</form>'.'<!-- /'.$frmName.' -->'."\n\n"; //  PanelForm-slut
}

 
// JS functioner for Panel håndtering:
function PanelInit() { $maxPaneler= 40;
    echo '<script>';
        echo 'function PanelMinimizeAll() {';
        for ($Ix=1; $Ix<=$maxPaneler; $Ix++) {
                echo ' var h = document.getElementById("HideDiv'.$Ix.'"); var p = document.getElementById("panel'.$Ix.'");';  
                echo ' h.style.display = "none"; p.style.width = "240px"; ';
            }
        echo ' }';
        echo 'function PanelMaximizeAll() {';
        for ($Ix=1; $Ix<=$maxPaneler; $Ix++) {echo ' var h = document.getElementById("HideDiv'.$Ix.'"); var p = document.getElementById("panel'.$Ix.'");';  
        echo ' h.style.display = "block"; p.style.width = "100%"; ';}
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
    execKnap($label= '@Maximize All', $title ='@View content in all panels', $function = 'PanelMaximizeAll()');
}


function htm_AcceptKnap($labl='', $title='', $knapArt='', $form='', $width='', $akey='', $func='', $tipplc='LblTip_text')   //  Afløser for htm_Accept
//  knapArt: save, navi, goon, erase, create, home
{global $ØTastkeys;
    dvl_pretty('htm_AcceptKnap');
    # Knap-kategorier: Slet:RØD    Gem/Submit:GUL    Naviger:GRØN    OpretNy:BLÅ    Andre:HVID
    $ØButtnBgrd= '#44BB44';  /* LysGrøn   */     $ØButtnText= '#FFFFFF';   /* Hvid   */
    $ØBtLnkBgrd= 'yellow';   /* '#FCFCCC';  */   $ØBtLnkText= '#000000';
    // Knap-farver:
    $ØTextLight= 'white';       $ØTextDark= 'black'; 
    $ØBtDelBgrd= 'Crimson ';    $ØBtDelText= $ØTextLight;   # Slet:RØD
    //$ØBtSavBgrd= 'yellow';      $ØBtSavText= $ØTextDark;  # Gem/Submit:GUL
    $ØBtSavBgrd= '#0064b4';     $ØBtSavText= $ØTextLight;   # Gem/Submit:BLUE
    $ØBtNavBgrd= '#269B26';     $ØBtNavText= $ØTextLight;   # Naviger:GRØN
    $ØBtGooBgrd= '#66CDAA';     $ØBtGooText= $ØTextDark;    # Fortsæt:MARINE
    $ØBtNewBgrd= 'Orange';      $ØBtNewText= $ØTextDark;    # OpretNy:ORANGE
    $Ødimmed=    ' opacity:0.8;';
    if ($form) {$navn= $form; $form=' form="'.$form.'" ';}
    if ($width) $width= ' width: '.$width.';';
  
## Shortcuts:
    $keytip='';
    if ($ØTastkeys) {
        if ($akey>'') $genv=' ´<i>'.$akey.'</i>´'; else $genv='';
        if (!$genv) $keytip=''; else $keytip= '<br><em>'.lang('@Keyboard shortcut: ').$akey.'</em>';
    }
## Appearance & name:
    switch ($knapArt) {
    case 'save'   : {$colors= ' background:'.$ØBtSavBgrd.'; color:'.$ØBtSavText.';'.$Ødimmed;}  $midn= 'sav_';  break; # Submit-Butt: BLUE
    case 'navi'   : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= 'nav_';  break; # navigate-Butt: GREEN 
    case 'goon'   : {$colors= ' background:'.$ØBtGooBgrd.'; color:'.$ØBtGooText.';'.$Ødimmed;}  $midn= 'goo_';  break; # Continue-Butt-Butt: SEA ​​GREEN 
    case 'erase'  : {$colors= ' background:'.$ØBtDelBgrd.'; color:'.$ØTextLight.';'.$Ødimmed;}  $midn= 'era_';  break; # Delete: RED  
    case 'create' : {$colors= ' background:'.$ØBtNewBgrd.'; color:'.$ØBtNewText.';'.$Ødimmed;}  $midn= 'cre_';  break; # Create new: ORANGE
    case 'home'   : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= 'hom_';  break; # navigate-Butt: GREEN 
    default       : {$colors= ' background:'.$ØBtNavBgrd.'; color:'.$ØBtNavText.';'.$Ødimmed;}  $midn= '';             # navigate-Butt: GREEN
  }
## Function:
  $result= '<span class="center" style="height:25px; ">'; 
  $result.= "\n\n".'<button '.$form.' type= "submit" name="btn_'.$midn.$navn.'" id="btn_'.$midn.$navn.
              '" class="tooltip" style="margin: 1px 2px; padding: 2px 6px; height: 22px; '.$width.  
              $colors.'" accesskey="'.$akey.'"> '. ucfirst(lang($labl)).
              '<span class="'.$tipplc.'">'.lang($title).$keytip.'</span>'."\n".'</button>'."\n\n";
  $result.= '</span>';
  if ($func!='rtrn') echo $result;
  else return $result;
}

function htm_PagePrep($pageTitl){   // Prepare / initialize a page
  global $CSS_style;                // Must be followed of htm_PageFina() to finalise the page
  
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

//  $ØProgRoot=   "./../";  // "../";        //  Relativ i 1. subniveau    #-$ØProgRoot= "./../../";   //  Relativ i 2. subniveau
$ØProgRoot= '/';
//  $_assets=     $ØProgRoot.'_assets/';   
$ØTitleColr= 'green';

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
      dateFormat : \"yyyy-mm-dd\",
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
        if (/[~`!#$£€¤%()\^&*+=\-\[\]\\\';,/{}|\\":<>\?]/g.test(text) ) {point += 1};
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
      
</script>

<style>
 /* Globale konstanter/variabler: */ 
:root {
  --creaInpBg: #ffffcc;  /* Create input #ffffcc; Yellow-light */           
}      
 /* Specielle tilretninger: */ 
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
    border-radius: 3px; */
}
input[type=text]:focus {
    border-color:#222;
}

tfoot input {
  background: var(--creaInpBg);
}

.tablesorter-blue tfoot td {   /* footer */ 
    font: 12px/18px Arial, Sans-serif;
    font-weight: bold;
    color: #000;
    background-color: #99bfe6;
    border-collapse: collapse;
    padding: 2px;
    text-shadow: 0 1px 0 rgba(204, 204, 204, 0.7);
}
.tablesorter .tablesorter-filter {  /* Forebygger utilsigtet min-width af filter-felter */
    width: 100%;
}
</style>

<style id=".'css'.">  /* wrapper of table  */ 
.wrapper {
    position: relative;
  display: block;
    padding: 0 5px;
    height: 300px;   /* Justeres i HTML: $ViewHeight */
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
</style>

";
  
 
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
    include('.././spormig.php');
    htm_nl(3);
    echo '  </body>'; // Started in htm_PagePrep()
    echo '</html>';
}

function iconButt($type='submit',$faicon='',$title='',$id='',$link='',$action='',$akey='',$size='32px',$labl='',$fg='gray') 
{ global $ØButtnBgrd, $ØTastkeys, $btnix;
  if ($ØTastkeys) {
    if (!$akey) $tasttip=''; else $tasttip= '<br>'.lang('@Keyboard shortcut: ').$akey;
    if ($link=='') $targ= 'formtarget="_self"';
  }   dvl_pretty('iconButt');
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
    return '<span class="LblTip" style="height:'.$h.$t.'">'.ucfirst(lang($lbl).' ').'<span class="'.$class.'" '.$wdth.'>'.lang($tip).'</span></span>';
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


// String-funktions:
function str_bold($source,$result='',$tail='&nbsp;&nbsp;') {return $result.'<b>'.$source.'</b>'.$tail;}
function str_Ihead($source) {return '<br /><i>'.$source.'</i> ';}
function str_hr($c='#0')    {return '<hr style="color:'.$c.';"/>';}
function str_nl($rept=1)    {return str_repeat('<br />',$rept);}
function str_lf($rept=1)    {return str_repeat(' &#xa;',$rept);}  //  LineFeed in strngs:  &#010;  &#xa;  \n \u000A  \x0A  &#13;  %10%13  %0D%0A
function str_sp($rept=1)    {return str_repeat('&nbsp;',$rept);}


if (!function_exists('lang')) {
  function lang($FraseKey) {                         # lang() / trans() benyttes til sprogoversættelse af alle hard-codede program-tekster.
  global $ØsprogTabl, $ØprogSprog,                   # Fraser med @-prefix er system-tekster, der kan omsættes til andet sprog.
         $ØlanguageTable;                    # Vær opmærksom på at samme frase, ikke kaldes flere gange f.eks. i rutiner i underniveauer.
if (!function_exists('found_index')) {
  function found_index($sprogDB, $field, $value) {
  if ($sprogDB)
    foreach($sprogDB as $key => $row) {
     if ($row[$field] === $value)  
    {return $key; break;}
  }  return false;  # 'TranslateError';
 }}
 if (substr($FraseKey.' ',0,1)!='@') {return($FraseKey); exit;}  # Dont translate twice !
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

function run_Script ($cmdStr) {
  echo "\n".'<script> '.$cmdStr.' </script>'."\n";
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
    --oranColor: #F37033;
    --brunColor: #550000;   /*  Table borders  */
    --grayColor: #ACA9A8;
    --xx11Color: #3CBC8D;
    --HintsBgrd: rgba(55, 55, 55, 0.90); 
    --HintsText: #FFFFFF;
    --xx33Color: #CCEDFE;   /*  Filter: Light-Blue background */
    --grColrLgt: #CCCCCC;
    --Saldiblue: #003366;
    --FieldBord: #CCCCCC;   /* Panel- and Field-border */
/*  --FieldBgrd: #FFFFF5;   /* Field background-color */
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
        background: Snow;
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
    
    .fieldContent {
        text-align: left; 
        display: block; 
        padding: 0 6px; 
        position: relative;
    }
    
    hr.style13 {
      height: 6px;
      border: 0;
      box-shadow: 0 10px 10px -10px #8c8b8b inset;
    }


/* PANELER i SPALTER: (Tilpasning til smalle skærme) */
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

/* PANELER: (i forskellige bredder) */
.panelWmax, .panelWaut, .panelW120, .panelW110, .panelW100, .panelW960, .panelW800, .panelW720, 
.panelW640, .panelW560, .panelW480, .panelW400, .panelW320, .panelW280, .panelW240, .panelW160 {
    border: 1px solid gray;
    background: var(--PanelBgrd);
    box-shadow: 3px 3px  <?php echo $shadowBlur; ?> var(--ButtnShad);
    border-radius: 0.4em;
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
    border: 3px solid gray;
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

.fieldStyle,
.tableStyle {
    display:inline-block; 
    border: 1px solid var(--FieldBord); 
    border-radius: 5px;
    background-color: var(--FieldBgrd); 
    position: relative; 
    text-align: right;
    margin:3px;
    min-width: 150px;
    padding:3px;
}
.fieldStyle {
    height: var(--FldHeight);
}

.data-colrlabl {
    color: green;
}

.hidden { display: none; }
input { border: 0; }

.grid-container {
  display: grid;
  grid-template-columns: 35% 30% 35% ;
  background-color: #fffded;
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
  color:grey;
}

</style>
';  // End of CSS

?>