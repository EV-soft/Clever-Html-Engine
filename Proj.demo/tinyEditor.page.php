<?php   $DocFile= './Proj.demo/tinyEditor.page.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';      $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2025 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../'; 
$gbl_ProgRoot= './../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '3';

require_once ($sys.'php2html.lib.php');

if (isset($_POST['UploadFile'])) $UploadFile = $_POST['UploadFile']; 
                            else $UploadFile = '';

htm_Page_(titl:'HTML-editor - Introduction to the tiny Editor:', hint:$©, info:'File: '.$DocFile.' - Ver:'.$DocVer, inis:'', algn:'center',  imag:'../_accessories/_background.png', pbrd:false);
    echo '<style> body { padding-top: 0; margin-top:0; } </style>';
    
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'@Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    
    htm_Card_(capt: '@Working with tiny Editor:', icon: 'fas fa-info', hint: '@HINT for this card', form: 'head6', acti: '', clas: 'cardW100', wdth: '640', styl: 'background-color: white;', attr: '',  show : true,  head: $headbg, vhgh:'1200px');
        if ($LIB_TINYMCE[0] > 0) # Config editor: https://www.tiny.cloud/docs/tinymce/6/basic-setup/ 
        echo 
            " <script type=\"text/javascript\">
              tinymce.init({
                selector: '#TinyTextarea',
                license_key: 'gpl',
                language: 'en',
                skin: 'oxide-dark',
                content_css: 'dark',
                promotion: false,
                plugins: [
                  'accordion', 'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                  'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                  'media', 'table', 'emoticons', 'help', 'save', 'visualchars'
                ],
                toolbar: 'save | undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
                  'bullist numlist outdent indent | link image | print preview media fullscreen | accordion | ' +
                  'forecolor backcolor emoticons | help save visualchars',
                menu: {
                  favs: { title: 'My Favorites', items: 'code | visualaid | searchreplace | emoticons' }
                },
                menubar: 'favs file edit view insert format tools table help',
                content_css: 'writer' /* 'css/content.css' */
              });
              </script>";
        $EditFile= 'EditContent.htm';
/* 
https://www.tiny.cloud/docs/tinymce/latest/plugins/#open-source-plugins
Free plugins: (In demo | Indented: not used)
Accordion
Anchor
Autolink
    Autoresize
    Autosave
    Character Map
Code
    Code Sample
    Directionality
Emoticons
Full Screen
Help
Image
    Import CSS
Insert Date/Time
Link
Lists
    List Styles
Media
    Nonbreaking Space
Page Break
Preview
    Quick Toolbars
Save
Search and Replace
Table
Visual Blocks
Visual Characters
Word Count
*/

        # Save content: in this visitor's session only. Writing to the shared file let any visitor put
        # HTML/JavaScript on the page for everybody else. The file is the read-only starting template.
        if (isset($_POST['TinyTextarea']) and is_string($_POST['TinyTextarea']))
            $_SESSION['tinyEditDoc']= substr($_POST['TinyTextarea'], 0, 200000);
        $docContent= $_SESSION['tinyEditDoc'] ?? file_get_contents($EditFile);                # Load content
        htm_Input(labl:'@This is the HTML editor', 
                  plho:'@Enter your text here...', icon:'', 
                  hint:'@Based on open source: tinyMCE',vrnt: 'area',
                  name:'TinyTextarea' /* Name must match selector in tinymce.init() */, 
                  valu:$docContent, form:'', wdth:'', algn:'left',
                  attr:'', rtrn:false, unit:'', disa:false, rows:'60', step:'' ,list:[], llgn:'C', bord:'', ftop:'');
        
    htm_Card_end(labl:'GEM', icon:'', hint:'', name:'', form:'head6', subm:false,  attr:'', akey:'s', kind:'save', simu:false);
   
    htm_Card_(capt:'@Data-file for tiny Editor: '.$EditFile, icon: 'fas fa-database', form:'fmUpload', acti:'', clas: 'cardW100');
        htm_textdiv('<b>Info:</b> The editor loads/saves data from file: '.$EditFile.' '. str_sp('8').
            htm_Field(labl:'Upload local file to edit', body:
                htm_Input(labl:'', 
                          plho:'@Enter your filename here...', icon:'', 
                          hint:'@Upload file to '.$EditFile.'<br>Not working yet !', vrnt:'file', 
                          name:'UploadFile' , 
                          valu:$UploadFile,  form:'fmUpload', wdth:'220px', algn:'left',
                          attr:'', rtrn:true, unit:'', disa:false, rows:'', step:'', list:[], llgn:'R', bord:'',ftop:''). 
                          // 1:Backup current Editfile, 2:Upload file, 3:saveAs EditContent.htm
                str_sp('4').
                htm_AcceptButt(labl:'OK', hint:'Upload now', form:'fmUpload', rtrn:true, tplc:'LblTip_text'), 
                icon:'',hint:'@Upload file to '.$EditFile.'<br>Not working yet !',name:'fld',wdth:'',styl:'',attr:'',llgn:'C',rtrn:true,ftop:'').
             
             htm_Field(labl:'@Download file', body:
                 htm_Inbox(labl:'@Download file', 
                           plho:'@Enter your filename here...', icon:'', 
                           hint:'@Download '.$EditFile.' to a local file<br>Not working yet !', vrnt:'text', name:'dfile', 
                           valu:'<a href= "'.$EditFile.'" download>'.$EditFile.'</a>', form:'fmUpload', wdth:'', algn:'left',
                           attr:'', rtrn:true, unit:'', disa:false, rows:'', step:'', list:[], llgn:'R', bord:'', ftop:''), 
                      icon:'', hint:'@Download file '.$EditFile, name:'fld', wdth:'', styl:'', attr:'', llgn:'C', rtrn:true, ftop:'')
            );  // 1:Download file, 2:Save as newName,
            htm_textdiv(body:'@Alternative you can copy/paste from/to content in Source Code window.', styl:'white-space: nowrap;', rtrn:true,
                        attr:'margin: auto; display:inline-block; position: relative;');
    htm_Card_end(labl:'GEM', icon:'', hint:'', name:'', form:'fmUpload', subm:false,  attr:'', akey:'s', kind:'save', simu:false);
     
htm_Page_end();
?>