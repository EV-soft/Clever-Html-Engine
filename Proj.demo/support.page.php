<?php   $DocFile= './Proj.demo/support.page.php';    $DocVer='1.3.0';    $DocRev='2023-05-18';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:       LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [$LibIx, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);               // jquery.min.js
define('LIB_JQUERYUI',      [$LibIx, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [$LibIx, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_FONTAWESOME',   [$LibIx, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN 

//htm_Page_0($titl='support.page.php',$hint='',$info='',$inis='',$algn='center', $gbl_Imag=$gbl_ProgRoot.'_accessories/_background.png',$gbl_Bord=false);
htm_Page_0(titl:'support.page.php', hint:$©,  info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:false);
    Menu_Topdropdown(true); htm_nl(1);
         # $capt= '',$icon= '',$hint= '',$form= '',$acti= '',$clas= 'cardWmax',$wdth= '',$styl= 'background-color: white;',$attr= '' 
    htm_Card_0(capt:'Libraryes and files',icon:'fas fa-file', hint: '',form: 'head',acti: '',clas:'cardW640',wdth: '',styl: 'background-color: white;',attr: '');
    set_Style('type="text/css"', 'li:hover{ color:gray; font-weight: 400; }' );

    echo '<div style="text-align: left;">';
    echo '<p><strong>PHP2HTML</strong> makes use of some external libraries which can be located either locally in a folder on the host server or public on a CDN server: Cloudflare on the Internet.</p>
<p>If location on a CDN server is chosen, it has the disadvantage that the program loses functionality when there is no connection to the Internet.<br>If local location is selected, it is up to you to copy needed files and provide updates manually.</p>
<p>When you program a page, you must choose which library and location to use.</p>
<p>Locally located libraries are located in the system folder _assets.</p>
<hr>
<p>Local folders:</p>
<p style="line-height: 0.5;"><span style="background-color: rgb(191, 237, 210);"><span style="background-color: rgb(255, 255, 255);">&lt;</span></span><span style="background-color: rgb(194, 224, 244);">System_folder</span>&gt;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; System support files (.lib.php .sys.json .init.php)</p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;---- <span style="background-color: rgb(191, 237, 210);">_accessories</span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Project support files (.img .ttf)</p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;---- <span style="background-color: rgb(191, 237, 210);">_assets </span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"libraries"</p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- <span style="background-color: rgb(191, 237, 210);">jquery<span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "jquery"</span></span></p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- <span style="background-color: rgb(191, 237, 210);">jquery-ui<span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "jquery-UserInterface"</span></span></p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- <span style="background-color: rgb(191, 237, 210);">tablesorter<span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"Advanced tables"</span></span></p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- <span style="background-color: rgb(191, 237, 210);">font-awesome</span>&nbsp; &nbsp; &nbsp;"Icons"</p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- <span style="background-color: rgb(191, 237, 210);">tinymce<span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "HTML-editor"</span></span></p>
<p style="line-height: 0.5;"><span style="background-color: rgb(191, 237, 210);"><span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp;&brvbar;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- </span>dialog-polyfill<span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp;"popup dialog"</span></span></p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;---- &lt;<span style="background-color: rgb(194, 224, 244);">Project_1_folder</span>&gt;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(.page.php)</p>
<p style="line-height: 0.5;"><span style="background-color: rgb(191, 237, 210);"><span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp;<span style="background-color: rgb(191, 237, 210);"><span style="background-color: rgb(255, 255, 255);">&brvbar;&nbsp;</span></span>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&brvbar;---- &lt;<span style="background-color: rgb(194, 224, 244);">Project_data</span>&gt;&nbsp; &nbsp; (.dat .json .img)</span></span></p>
<p style="line-height: 0.5;">&nbsp; &nbsp; &nbsp;&brvbar;---- &lt;<span style="background-color: rgb(194, 224, 244);">Project_2_folder</span>&gt;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(.page.php)</p>
<p style="line-height: 0.5;"><span style="background-color: rgb(191, 237, 210);"><span style="background-color: rgb(255, 255, 255);">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &brvbar;---- &lt;<span style="background-color: rgb(194, 224, 244);">Project_data</span>&gt;&nbsp; &nbsp; (.dat .json .img)</span></span></p>
<p style="line-height: 0.5;">&nbsp;</p>
<p style="line-height: 0.5;">Every library-folder has a subfolder: <span style="background-color: rgb(191, 237, 210);">latest</span> containing the newest library-files.</p>
<p style="line-height: 1;">&nbsp;</p>
<p style="line-height: 1;">&nbsp;</p>';

    htm_nl(0);
    echo '</div>';
                # $labl='', $icon='', $hint='', $name='', $form='',$subm=false, $attr='', $akey='', $kind='save', $simu=false)
    htm_Card_00(labl:'Demo', icon:'', hint:'Buttom', name:'', form:'', subm:false, attr:'', akey:'', kind:'save', simu:false);
    
htm_Page_00();
?>