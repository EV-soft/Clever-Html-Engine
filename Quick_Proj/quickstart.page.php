<?php   $DocFile= './Quick_Proj/quickstart.page.php';    $DocVer='1.4.0';    $DocRev='2024-02-18';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'translate.inc.php');     // Other system-librarie
// require_once ($sys.'filedata.inc.php');      // Other system-librarie

### DATA-INIT/UPDATE here:


### PAGE-START:
htm_Page_(titl:'quickstart.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'',
           algn:'center', imag:'../_accessories/_background.png', pbrd:false);
   
    // $menudata and menunote is set in: project.init.php
    htm_Menu_TopDown(capt:'',data:$menudata_quick, foot:'Quickstart', styl:'top:0px;', note:$menunote_quick); 
    
##### Replace frome here - with your new project code
    htm_nl(2);
    htm_Caption(labl:'How getting started using Clever HTML builder.',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 18px;',rtrn:false);
        
    htm_nl(2);
    htm_Card_(capt:'Guide', icon:'fa-solid fa-screwdriver-wrench', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'', show:true, head:'background-color: white;', vhgh:'600px', help:'', fclr:'');
        htm_Caption(labl:'This is a guide to quickly build your first project using Clever HTML builder.',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 13px;',rtrn:false);
        htm_textdiv('
        <b>Steps:</b><br>
        &nbsp;&nbsp;SYSTEM:<br>
        &nbsp;1. On your web-server, create a new folder: PHP2HTML in the public area.<br>
        &nbsp;2. Copy all the system files & folders to this folder. (from: github-clone.zip-file)<br><br>
        &nbsp;PROJECT:<br>
        &nbsp;3. In projectfolder "Quick_Proj" you find the file quickstart.page.php<br>
        &nbsp;4. Modify files and links with "quick" in the file-name to your purpose<br>
        &nbsp;5. Modify "PHP2HTML/project.init.php" regarding the menudata_quick, to your purpose<br><br>
        &nbsp;6. Add your content to new .page.-files in "Quick_Proj" to your purpose<br>
        &nbsp;7. Test and revise your project.... <br>
        &nbsp;8. Cleanup and remove all unnecessary "quick" comments in your projects source files.<br>
        &nbsp;9. Setup index-link to "quickstart.page.php"<br><br>
        10. If you want to use the FILES, TRANSLATE, FUNCTIONS menu items,<br> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; you can copy the necessary files from the folder.: "Proj.demo" to "Quick_Proj"<br><br>
        ');
        htm_Caption(labl:'Now you can work on your new project.',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 13px;',rtrn:false);
    htm_Card_end();
    
    htm_nl(2);
    htm_Card_(capt:'Nice to know', icon:'fa-regular fa-lightbulb', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'', show:true, head:'background-color: white;', vhgh:'600px', help:'', fclr:'');
        htm_textdiv('
        In demo and quickproject all possibly parameters to functionscall are given, so you can learn the system.<br>
        Actually you can remove all those who have default values...<br>
        You find default values in the function declarations in php2html.lib.php<br>
        ');
    htm_Card_end();
    
    htm_nl(2);
    htm_Card_(capt:'Programming Environment', icon:'fa-solid fa-code', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'', show:true, head:'background-color: white;', vhgh:'600px', help:'', fclr:'');
        htm_textdiv('
        EV-soft are using Notepad++ on Windows to edit projects "Online"<br>
        By installing nppFTP plugin, it can syncronize a windows temp-folder with the files on the web-server.<br>
        In that way I instantly can see the result of edit by refresing the browser window.<br>
        ');
    htm_Card_end();
    
    CardOff($First=2,$Last=3); // Close card 2 and 3 on page open

##### Replace to here

### :PAGE_END
htm_Page_end();

# Now you have one html-page with menu, and prepared for icons & helps & hints & placeholders & translate & much more ...
?>