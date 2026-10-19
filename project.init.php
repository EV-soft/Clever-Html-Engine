<?php   $DocFil= 'project.init.php';    $DocVers='1.7.5';    $DocRev='2026-10-19';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** 
#  This file is included from start of php2html.lib.php 

## Initiate Global variables:
    $gbl_TblIx= -1;                     # Index for table-id to separate multible tables in same page
    $gbl_ProgTitl= 'php2html';
    $gbl_progVers= 'Develop'.' ';
    $gbl_progDesti= 'This program is about using library PHP2HTML';
    $gbl_copyright='EV-soft';
 // $gbl_copydate= '2022-02-02'; // See - Project-files
    $gbl_designer= 'EV-soft';
    $gbl_menuLogo= $gbl_ProgBase.'_accessories/21997911.png';

    $gbl_blueColor= 'lightblue';
    $gbl_BodyBcgrd= 'Tan';
    $gbl_iconColor= 'DarkGreen';        # Panel-header icon
    $gbl_TitleColr= 'DarkGreen';        # Caption text-color in panel-head
 // $gbl_PanelBgrd= 'transparent';      # Panels hideble background
    $gbl_CardsBgrd= 'background-color: white;';      # Cards hideble background
    $gbl_GridOn= true;                  # Use grid to place objects in rows / colums
    $gbl_progZoom = 'small';            # Global tag "font-scale"
    // $GLOBALS["gbl_ProgRoot"]= './';
    $gbl_labelAlgn= 'R';                # L/C/R - Align label for htm_Input() and htm_Inbox()
    
    # Library source 1:local / 2:CDN - from the library's cached CDN check ($autoCDN, max. once per 5 minutes).
    # (Was: jquery.min.js downloaded from cdnjs on every page request - up to 60 s wait when the CDN does not answer)
    $LibIx= (($autoCDN ?? '1') == '2') ? 2 : 1;
    
    // echo $LibIx;

## Demo-system:
    ## Global menusystem to be used in multible pages:
    $menudata= [ // Data(0:vrnt='', 1;icon='', 2:labl='', 3:hint='', 4:desc='', 5:link='', 6:subm=[], 7:styl='')
        ['Frst','fas fa-info colrwhite',    '@INTRODUCTION','', '@Here you can read about the systems most useful modules:','PHP2HTML-intro.page.php',[
            ['Next','fas fa-info black',    '@PHP2HTML ?',  '', '@What is Clever html engine ?','PHP2HTML-intro.page.php',[],''],
            ['Next','fas fa-info black',    '@Description', '', '@What is PHP2HTML ?','description.page.php',[],''],
            ['Next','fas fa-info black',    '@Examples',    '', '@See and try examples of nearly all modules in the system...','Demo.page.php',[],''],
            ['Next','fas fa-info black',    '@Tiny editor', '', '@Try the advanced online HTML editor','tinyEditor.page.php ',[],''],
            ['Next','fa-regular fa-credit-card black', '@Advanced example', '','@Example of an Accounting program','CustomerOrder.page.php',[],''],
            ['Next','fa-regular fa-credit-card black', '@Danish account plan', '','@Example of an account plan','accountPlan.page.php',[],''],
            ['Last','fa-solid fa-book black', '@Documentation', '','@Documentation of the system','documentation.page.php',[],'']
           
        ]],
        ['Next','fas fa-cubes colrorange',  '@MODULES',          '@System modules',                      '@','input.page.php', [
            ['Next','fas fa-cubes black',   '@htm_Input',        '@htm_Input() used for input and output of values of various variables','@','input.page.php', [],'top:350px;'],
            ['Next','fas fa-cubes black',   '@htm_Table',        '@Example on module htm_Table()',      '@','table.page.php', [] ,'top:350px;'],
            ['Next','fas fa-cubes black',   '@htm_Card',         '@Example and notes about htm_Card()', '@','card.page.php', [] ,'top:350px;'],
            ['Next','fas fa-cubes black',   '@Page layout',      '@About making page layout',           '@','pages.page.php', [] ,'top:350px;'],
            ['Next','fas fa-cubes black',   '@Navigate',         '@About menues an link buttons',       '@','navigate.page.php',[] ,'top:350px;'],
            ['Last','fas fa-cubes black',   '@Others',           '@Buttons, Messages and dialog',       '@','other.page.php',[] ,'top:350px;']
        ],'top:350px;'],
        ['Next','fas fa-file colryellow ',  '@FILES',            '@Go to files.page.php',               '@','files.page.php', [
            ['Next','fas fa-file black',    '@File naming',      '@Go to files.page.php',               '@','files.page.php', [],'top:500px;'],
            ['Next','fas fa-file black',    '@Folders and files','@Go to support.page.php',             '@','support.page.php', [],'top:500px;'],
            ['Last','fas fa-info black',    '@Quickstart',       '@How to start the system',            '@','../Quick_Proj/quickstart.page.php', [],'top:500px;'],
            ['Last','fas fa-info black',    '@Minimal setup',    '@How to create a mini system',        '@','../Quick_Proj/minisetup.page.php', [],'top:500px;']
        ],'top:500px;'],
        ['Next','fas fa-language colrblue', '@TRANSLATE',        '@Go to translate.page.php',           '@','translate.page.php', [],'top:500px;'],
        ['Last','fas fa-code colrcyan',     '@FUNCTIONS',        '@Go to functions.page.php',           '@','functions.page.php', [
            ['Last','fas fa-code colrcyan', '@Overview',         '@Go to functions.page.php',           '@','functions.page.php', [],'top:500px;'],
        ],'top:500px;']
        ]; 
         
    $gbl_ViewBar= true;     # Floating, movable view bar with zoom, full screen and theme (htm_Menu_TopDown view:)
    $gbl_CardMove= $gbl_CardMove ?? 'icon';   # Move cards: 'icon' (handle in the header) / 'header' (drag the header) / 'toggle' (view bar button) / false
    # Project hooks (no edits in php2html.lib.php needed):
    // $gbl_CustomCss= ':root { --AccnColr: #8a2be2; }';      # Own CSS after the system CSS - or the address of a file: $gbl_ProgRoot.'my.css'
    // $gbl_CustomLib= __DIR__.'/../my.lib.php';              # Own functions (else customLib.inc.php next to the library)
    // $gbl_CustomRules= __DIR__.'/../my.rules.php';          # Own table row rules (else customRules.inc.php)
    // define('DecimalSep', '.');  define('ThousandsSep', ','); # Number format;  define('DEBUG', true);
    // $headEndScript= '...';  $bodyEndScript= '...';  $gbl_novice= true;
    // $gbl_LazyLibs= false;                                 # Tablesorter / jQuery UI in <head> on every page (default: Tablesorter by the first htm_Table(); jQuery UI is not used by the library)
    // $gbl_AssetCache= false;                               # CSS/JS of <head> inline in every page (default: cached files in _cache/ next to the library)
    $menunote= '@<small>Test site and documentation for Clever html engine • Errors may occur and future news may be shown • ver.'.$DocVers.': 78 core functions.</small>';

## Quickstart:
    $menudata_quick= [ // Data(0:vrnt='', 1;icon='', 2:labl='', 3:hint='', 4:desc='', 5:link='', 6:subm=[], 7:styl='', 8:$widt)
        ['Frst','fas fa-info colrwhite',    '@Quick Project','', '@Start your first project:',              'quickstart.page.php',[]
         ],
         /* 
        ['Next','fas fa-file colryellow ',  '@FILES',            '@Go to files.page.php',               '@','files.page.php', [
            ['Next','fas fa-file black',    '@File naming',      '@Go to files.page.php',               '@','files.page.php', [],'top:500px;'],
            ['Last','fas fa-file black',    '@Folders and files','@Go to support.page.php',             '@','support.page.php', [],'top:500px;']
        ],'top:500px;'],
        ['Next','fas fa-language colrblue', '@TRANSLATE',        '@Go to translate.page.php',           '@','translate.page.php', [],'top:500px;'],
        ['Last','fas fa-code colrcyan',     '@FUNCTIONS',        '@Go to functions.page.php',           '@','functions.page.php', [
            ['Last','fas fa-code colrcyan', '@Overview',         '@Go to functions.page.php',           '@','functions.page.php', [],'top:500px;'],
        ],'top:500px;']
         */
        ]; 
        
    $menunote_quick= '@<small>This is a guide to quickly get started with a new project.</small>';
?>