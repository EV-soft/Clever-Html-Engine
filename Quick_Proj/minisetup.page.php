<?php   $DocFile= './Quick_Proj/minisetup.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');
// require_once ($sys.'translate.inc.php');     // Other system-librarie
// require_once ($sys.'filedata.inc.php');      // Other system-librarie

### DATA-INIT/UPDATE here:

$phpCode= 
<<< 'STRING'
<?php   $DocFile= './<yourFile>.page.php';    $DocVer='1.4.0';    $DocRev='2025-xx-xx';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= './';   // system in same folder
$gbl_ProgRoot= './'; 

## Activate needed libraries: Set 0:deactive  (1:Local-source)  2:WEB-source-CDN  3:Auto: Local/CDN 
$needJquery=      '2';
$needTablesorter= '0';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');

### PAGE-START:
htm_Page_(titl:'<yourFile>.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'',
          algn:'center', imag:'', pbrd:false);

### Here you put your code...
    echo 'Hello World - Build with Clever HTML engine...';
    
### :PAGE_END
htm_Page_end();

?>
STRING;

### PAGE-START:
htm_Page_(titl:'minisetup.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'',
           algn:'center', imag:'../_accessories/_background.png', pbrd:false);
   
    // $menudata and menunote is set in: project.init.php
    htm_Menu_TopDown(capt:'',data:$menudata_quick, foot:'minisetup', styl:'top:0px;', note:$menunote_quick); 
    
##### Replace frome here - with your new project code
    htm_nl(2);
    htm_Caption(labl:'Minimal Clever HTML engine.',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 18px;',rtrn:false);
        
    htm_nl(2);
    htm_Card_(capt:'Guide', icon:'fa-solid fa-screwdriver-wrench', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'', show:true, head:'background-color: white;', vhgh:'850px', help:'', fclr:'');
        htm_Caption(labl:'This is a guide to setup a minimal Clever HTML engine.',icon:'',hint:'',algn:'',styl:'color:#550000; font-weight:600; font-size: 13px;',rtrn:false);
        htm_textdiv('
        <b>Steps:</b><br>
        &nbsp;&nbsp;SYSTEM:<br>
        &nbsp;1. On your web-server, create a new projectfolder.<br>
        &nbsp;2. Copy some of the system files to this folder. (from: github-clone.zip-file)<br>
        '.str_space('55px').'<b>php2html.lib.php</b> - always used<br>
        '.str_space('55px').'<b>project.init.php</b> - if menu-system is used<br>
        &nbsp;PROJECT:<br>
        &nbsp;3. In projectfolder create a file: yourFile.page.php file with this content:<br>'.
        
        htm_CodeBox($phpCode, rtrn:true).
        '
        &nbsp;4. Add your code in yourFile.page.php<br>
        &nbsp;5. Modify "project.init.php" regarding the menudata, to your purpose<br>
        &nbsp;6. Test and revise your project.... <br>
        Now you are going...<br>
        <br>
        Limitations in this setup:<br>
        Translate is not used, but you can activate it later.
        ');
    htm_Card_end();
       
    CardOff($First=2,$Last=3); // Close card 2 and 3 on page open

##### Replace to here

### :PAGE_END
htm_Page_end();

# Now you have one html-page with menu, and prepared for icons & helps & hints & placeholders & translate & much more ...
?>