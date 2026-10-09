<?php   $DocFile= './Proj.demo/documentation.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../'; 

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: CDN/Local
$needJquery=      '3';
$needTablesorter= '0';
$needPolyfill=    '0';
$needFontawesome= '3';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');

htm_Page_(titl:'documentation.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer,inis:'', algn:'center', imag:'../_accessories/_background.png', pbrd:true);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    
    htm_Card_(capt:'@Documentation:', icon: 'fas fa-info', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr: '');

    htm_TextDiv('You can find informations about using the PHP2HTML-system here:<br><br>
    <b>Overviews:</b><br>
    htm_Functions - Look at this page: <br>
    <li>FUNCTIONS > Overview > Card: <a href="functions.page.php"><i>The overview over the system functions.</i></a></li></li>
    <li>FUNCTIONS > Overview > Card: Parameter-names: <a href="functions.page.php"><i>Notes about function parameters</i></a></li> <br>
    Folder/Files - Look at this page: <br> 
    <li>FILES > Folders and files > Card: <i>Libraryes and files</i> </li>
    <li>Miscellaneous - Study all pages in this demo</li>
    <br><br>
    <b>Details:</b><br>
    Study notes and code in the file: <i>php2html.lib.php</i><br>
    .<br>
'
    );
    htm_Card_end();
    
    htm_Card_(capt:'@User manual:', icon: 'fas fa-info', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr: '');

    htm_TextDiv('Help to the program user:<br><br>
        Following is shown instruktions to handle some complex objects<br>'
    );
    htm_Embed('Data.demo/User-manual.pdf');

    htm_Card_end();
    
    htm_Card_(capt:'@Github source:', icon: 'fas fa-info', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr: '');

    htm_TextDiv('You can find source files on Github here:<br>
        <a href="https://github.com/EV-soft/Clever-Html-Engine" target="_blank"> https://github.com/EV-soft/Clever-Html-Engine </a> <br>
        and a introduktion here:<br>
        <a href="https://ev-soft.github.io/Clever-Html-Engine/" target="_blank"> https://ev-soft.github.io/Clever-Html-Engine/</a>
        '
    );
    
    htm_Card_end();
    
    CardOff($First=1,$Last=3);
htm_Page_end();
?>