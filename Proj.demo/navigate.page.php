<?php   $DocFile= './Proj.demo/navigate.page.php';    $DocVer='1.4.0';    $DocRev='2024-06-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../'; 

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');

htm_Page_(titl:'navigate.page.php',hint:$©,info:lang('@PHP2HTML Demo and Documentation'),inis:'',algn:'center', imag:'../_accessories/_background.png',pbrd:true);
    
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    
    htm_Card_(capt:'@Navigate functions:', icon:'fas fa-info', hint:'@HINT',form:'', acti:'', clas:'cardW480', wdth:'', styl:'background-color: white;',attr:'');
    htm_TextDiv('To navigate in a program you can use:<br><br>
            Two system functions <b>htm_Menu_TopDown()</b><br>
            <img src="'.$gbl_ProgRoot.'_accessories/top_menu.JPG" width="450"></img><br>
            and <b>htm_Menu_Leftout()</b> <br>
            <img src="'.$gbl_ProgRoot.'_accessories/left_menu.JPG" width="40"></img><br>
            Both are 2-level sticky adaptive menues. <br>
            The menucontent is set in an data-array().
            <br><br>
            Including library menu.inc.php you can also use:<br>
            <b>Menu_Topdropdown()</b> <br>
            <img src="'.$gbl_ProgRoot.'_accessories/topDown_menu.JPG" width="450"></img>
            <br><br>
            You find it in the file: menu.inc.php <br>
            and it is called with Menu_Topdropdown() <br>
            It is a multi-level adaptive menu.<br>
            The menucontent is set in the file menu.inc.php.
            <br><br>
            Another button is <b>menuButt()</b> that can be used <br>
            to link to subpages:
            <br><br>'
        );

    echo '<div style="text-align: center;">';
        menuCapt($h='24',$w='200',$label='Simple menuCaption()');
        htm_nl(0);
        menuButt($h='24',$w='200',$label='MenuButt 1',$link='',$title='MenuButt'); htm_nl(1);
        menuButt($h='24',$w='200',$label='MenuButt 2',$link='',$title='MenuButt');
    echo '</div>';
    
    echo '<br><br>';
    htm_TextTip($capt='See also: <b>htm_IconButt()</b>',$body='- a general button with icon.',$width='',$colr='lightgreen',$align='center');
    htm_TextTip($capt='See also: <b>htm_AcceptButt()</b>',$body='- a general button with icon.',$width='',$colr='lightgreen',$align='center');
//See also: <b>htm_IconButt()</b> - a general button with icon. <br><br>
    echo '</div>';
    htm_Card_end();
    
htm_Page_end();
?>