<?php   $DocFil= './Proj1/files.page.php';    $DocVer='5.0.0';    $DocRev='2020-05-12';     $DocIni='evs';  $ModulNr=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
require_once ('menu.inc.php');
// require_once ('translate.inc.php');

htm_PagePrep('files.page.php');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: left; padding-left: 160px; line-height: 0.6;">';
    echo '<pre>
        The PHP2HTML-system uses this file naming system:      <br>
        NAME.SYS.TYP                <br>
          |   |   |                 <br>
          |   |   - File type: pdf/txt/json/png...  <br>
          |   ----- Content type: lib/inc/page/...  <br>
          --------- File name: descriptive word     <br>
                                    <br>
    <pre>';
    echo '<div style="line-height: 1.6;">
For now there are the following files:
   _assets              (folder: support libraries) 
   .sys_trans.json      Data-file with translations
   _background.png      Image used as background in panels etc.
   blindAlley.page.php
   Demo.page.php
   files.page.php
   input.page.php
   menu.inc.php         Include regarding the system menu
   panel.page.php
   php2html.lib.php     The main library
   table.page.php
   translate.inc.php    Include library regarding the translate system
    </div>';
    echo '</div>';
htm_PageFina();
?>