<?php   $DocFile= './Proj.demo/navigate.page.php';    $DocVer='1.4.1';    $DocRev='2024-07-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../'; 

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
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
    
    htm_Card_(capt:'@Navigate functions:', icon:'fas fa-info', hint:'@Use these buttons fx. to make links to other pages',
              form:'', acti:'', clas:'cardW480', wdth:'', styl:'background-color: white;',attr:'');
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

    echo '<div style="text-align: center;">'.'<hr>';
        menuCapt($h='24',$w='200',$label='Context popup menu');
        htm_ActionButt(labl:'@RightClick Me', icon:'fas fa-mouse colrgreen', hint:'@Try clicking me <br>to test popup-menues',type:'button', name:'right_click', form:'', acti:'',  attr:'', rtrn:false);
        // Build and echo jscode script for element with name'right_click':  
        htm_Pmnu_(elem:'right_click',capt:'Context-Menu', wdth:'280px',  icon:'',stck:'true',attr:'background-color:lightyellow; height: 16px;',cntx:true);
        htm_Pmnu_Item(labl:'@Select All',icon:'far fa-object-group colrbrown iconsize', hint:'@Mark to select',                            vrnt:'plain',    name:'d',    clck:'alert("sss");',  attr:'',shrt:'CTRL+A');
        htm_Pmnu_Item(labl:'@Copy',      icon:'fas fa-copy colrgreen iconsize',         hint:'@Copy selected to text-buffer',              vrnt:'plain',    name:'d1',   clck:'alert("sss");',  attr:'',shrt:'CTRL+C');
        htm_Pmnu_Item(labl:'@Paste',     icon:'fas fa-paste colrblue iconsize',         hint:'@Paste content in text-buffer',              vrnt:'plain',    name:'d2',   clck:'alert("sss");',  attr:'',shrt:'CTRL+V');
        htm_Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',name:'',     clck:'',               attr:'');
        htm_Pmnu_Item(labl:'@Delete',    icon:'fas fa-trash-alt colrred iconsize',      hint:'@Delete the selected',                       vrnt:'plain',    name:'e',    clck:'',               attr:'',shrt:'DEL'.str_sp(6));
        htm_Pmnu_Item(labl:'@Cut',       icon:'fas fa-cut colrblue iconsize',           hint:'@Cut the selected and save to text-buffer',  vrnt:'plain',    name:'d3',   clck:'alert("sss");',  attr:'',shrt:'CTRL+X');
        htm_Pmnu_Item(labl:'@Undo',      icon:'fas fa-undo colrblue iconsize',          hint:'@Undo latest task',                          vrnt:'plain',    name:'d5',   clck:'alert("sss");',  attr:'',shrt:'CTRL+Z');
        htm_Pmnu_Item(labl:'@Redo',      icon:'fas fa-redo colrblue iconsize',          hint:'@Redo the last delete',                      vrnt:'plain',    name:'d4',   clck:'alert("sss");',  attr:'',shrt:'CTRL+Y');
        htm_Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',name:'',     clck:'',               attr:'background-color:lightyellow;');
        htm_Pmnu_Item(labl:'@Multi Menu',icon:'fas fa-home colrgreen iconsize',         hint:'@Horisontal menu.',                          vrnt:'multi',    name:'e2',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Delete',    icon:'fas fa-trash-alt colrred iconsize',      hint:'@Delete the selected',                       vrnt:'subitem',  name:'e',    clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Cut',       icon:'fas fa-cut colrblue iconsize',           hint:'@Cut the selected and save to text-buffer',  vrnt:'subitem',  name:'d3',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Undo',      icon:'fas fa-undo colrblue iconsize',          hint:'@Undo latest task',                          vrnt:'subitem',  name:'d5',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'',           icon:'',                                       hint:'',                                           vrnt:'end_sub'); // multimenu                  
        htm_Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',name:'',     clck:'',               attr:'background-color:lightyellow;');
        htm_Pmnu_Item(labl:'@Sub Menu',  icon:'fas fa-home colrgreen iconsize',         hint:'@Open submenu.',                             vrnt:'submenu',  name:'f1',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Sub Item 1',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 1',                         vrnt:'subitem',  name:'f2',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Sub Item 2',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 2',                         vrnt:'subitem',  name:'f3',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Sub Item 3',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 3',                         vrnt:'subitem',  name:'f4',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'',           icon:'',                                       hint:'',                                           vrnt:'end_sub'); // submenu                                         
        htm_Pmnu_Item(labl:'@Hover Menu',icon:'fas fa-bars colrgreen iconsize',         hint:'@Open hovermenu',                            vrnt:'hovermenu',name:'g1',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Sub Item 4',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 4',                         vrnt:'subitem',  name:'g2',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Sub Item 5',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 5',                         vrnt:'subitem',  name:'g3',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'@Sub Item 6',icon:'fas fa-link colrblue iconsize',          hint:'@Open...Sub Item 6',                         vrnt:'subitem',  name:'g4',   clck:'',               attr:'',shrt:'');
        htm_Pmnu_Item(labl:'',           icon:'',                                       hint:'',                                           vrnt:'end_sub'); // hovermenu
        htm_Pmnu_Item(labl:'<hr>',       icon:'',                                       hint:'',                                           vrnt:'separator',);
        htm_Pmnu_end(labl:'FOOTER',hint:'The menu footer.',attr:'background-color:lightyellow; padding-top: 8px;');

        htm_nl(0);
    echo '</div>';
    
    echo '<br><br>';
    htm_TextTip($capt='See also: <b>htm_IconButt()</b>',$body='- a general button with icon.',$width='',$colr='lightgreen',$align='center');
    htm_TextTip($capt='See also: <b>htm_AcceptButt()</b>',$body='- a general button with icon.',$width='',$colr='lightgreen',$align='center');
//See also: <b>htm_IconButt()</b> - a general button with icon. <br><br>
    echo '</div>';
    htm_Card_end();
    
htm_Page_end();
?>