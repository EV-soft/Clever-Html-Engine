<?php   $DocFile= './Proj.demo/other.page.php';    $DocVer='1.3.1';    $DocRev='2023-09-18';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

htm_Page_0($titl='other.page.php',$hint=$©,$info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=false);
  
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    htm_Card_0($capt= 'Other htm_functions:',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'cardW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
                
    htm_TextDiv("There are a lot of small functions <br>
            that could be mentiond here.
            e.g. htm_AcceptButt()
            <br>
            ");
    htm_TextPre("<b>htm_AcceptButt()</b> - a programmeble button. You give:
    \$labl='',           # string: The caption on the button                          
    \$icon='',           # string: The iconclass ( class=\"fas fa-plus\" ) 
    \$hint='',           # string: hint about the button function                     
                                                                                      
    \$form='',           # string: The form the element belongs to, if a name is given
    \$wdth='',           # string: The width of the button                            
    \$attr='',           # string: Generel use e.g. ' action= \"\$link\" '            
                                                                                      
    \$akey='',           # string: Shortcut to activate the button                    
    \$kind='',           # string: save, navi, goon, erase, create, home (Appearance) 
    \$rtrn=true,         # bool:   Act as procedure: Echo string, or as function: Return string
                        
    \$tplc='LblTip_text',# string: Class for Placement of the tooltip 
    \$tsty='',           # string: Style for Placement of the tooltip 
    \$acti='',           # string: Function to run                    
    \$idix='',           # string: ix-suffix on name/id               
    \$disa=false         # bolean: 'disabled' to deactivate the button
    ",attr:'white-space:pre;'); 

    htm_TextDiv("
            <b>htm_IconButt()</b> - a general button with icon. <br><br>
            <b>htm_ModalDialog()</b>    - A popup message, <br>
            locks program and waits for a user response. <br><br>
            <b>msg_System()</b>   - Another modal popup message system,<br><br>
            <b>Pmnu_0() / Pmnu_00()</b> - A popup context menu system.  <br><br>
            A special group of functions:                             <br>
            <b>dvl_</b> functions - relates to development (tools and design) <br><br>");

    htm_Card_00();

htm_Page_00();
?>