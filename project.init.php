<?php   $DocFil= 'project.init.php';    $DocVers='1.3.1';    $DocRev='2023-09-02';     $DocIni='evs';  $ModulNr=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** 
#  This file is included from start of php2html.lib.php

## Activate following if constants is not defined in individual *.page.php-files:
    /* * /
    ## Speedup page-loading, if some libraryes is not needed:
    //      ConstName:          ix:   LocalPath:                 CDN-path:
    define('LIB_JQUERY',        [1, '_assets/jquery/',          'https://cdnjs.cloudflare.com/ajax/libs/']);
    define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
    define('LIB_POLYFILL',      [0, '_assets/',  '']);
    define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
    define('LIB_FONTAWESOME',   [1, '_assets/font-awesome6/',   'https://cdnjs.cloudflare.com/ajax/libs/font-awesome6/']);
    // Set ix 0:deactive  1:Local-source  2:WEB-source-CDN
    /* */
## END Activate

    $gbl_TblIx= -1;                     # Index for table-id to separate multible tables in one page
    $gbl_ProgTitl= 'php2html';
    $gbl_progVers= 'Develop'.' ';
    $gbl_copyright='EV-soft';
    //$gbl_copydate= '2022-02-02'; // See - Project-files
    $gbl_designer= 'EV-soft';
    $gbl_menuLogo= $gbl_ProgBase.'_accessories/21997911.png';

    $gbl_blueColor= 'lightblue';
    $gbl_BodyBcgrd= 'Tan';
    $gbl_iconColor= 'DarkGreen';        # Panel-header icon
    $gbl_TitleColr= 'DarkGreen';        # Caption text-color in panel-head
    // $gbl_PanelBgrd= 'transparent';   # Panels hideble background
    $gbl_CardsBgrd= 'background-color: white;';      # Cards hideble background
    $gbl_GridOn= true;                  # Use grid to place objects in rows / colums
    $gbl_progZoom = 'small';            # Global tag "font-scale"
    $GLOBALS["gbl_ProgRoot"]= './';
    $gbl_labelAlgn= 'R';                # L/C/R - Align label for htm_Input() and htm_Inbox()
    // if (!is_readable('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js')) 
    if (!file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js') > '')
         $LibIx= 1; // Local            # Central adaptive settings Library 1:local/2:CDN
    else $LibIx= 2; // CDN
    
    // echo $LibIx;


    $menudata= [ // Data(0:vrnt='', 1;icon='', 2:labl='', 3:hint='', 4:desc='', 5:link='', 6:subm=[], 7:styl='')
        ['Frst','fas fa-info colrwhite',    '@INTRODUCTION','', '@Here you can read about the systems most useful modules:','PHP2HTML-intro.page.php',[
            ['Next','fas fa-info black',    '@Description', '', '@What is PHP2HTML ?','description.page.php',[],''],
            ['Next','fas fa-info black',    '@Demo',        '', '@See and try examples of nearly all modules in the system...','Demo.page.php',[],''],
            ['Next','fas fa-info black',    '@Tiny editor', '', '@Try the advanced online HTML editor','tinyEditor.page.php ',[],''],
            ['Next','fa-regular fa-credit-card black', '@ Advanced example', '','@Example of an Accounting program','CustomerOrder.page.php',[],''],
            ['Last','fa-regular fa-credit-card black', '@ Danish account plan', '','@Example of an account plan','accountPlan.page.php',[],'']
        ]],
        ['Next','fas fa-cubes colrorange',  '@MODULES',          '@Systm modules',                      '@','input.page.php', [
            ['Next','fas fa-cubes black',   '@htm_Input',        '@htm_Input() used for input and output of values of various variables','@','input.page.php', [],'top:350px;'],
            ['Next','fas fa-cubes black',   '@htm_Table',        '@Example on module htm_Table()',      '@','table.page.php', [] ,'top:350px;'],
            ['Next','fas fa-cubes black',   '@htm_Card',         '@Example and notes about htm_Card()', '@','card.page.php', [] ,'top:350px;'],
            ['Next','fas fa-cubes black',   '@Page layout',      '@About making page layout',           '@','pages.page.php', [] ,'top:350px;'],
            ['Next','fas fa-cubes black',   '@Navigate',         '@About menues an link buttons',       '@','navigate.page.php',[] ,'top:350px;'],
            ['Last','fas fa-cubes black',   '@Others',           '@Buttons, Messages and dialog',       '@','other.page.php',[] ,'top:350px;']
        ],'top:350px;'],
        ['Next','fas fa-file colrbrown',    '@FILES',            '@Go to files.page.php',               '@','files.page.php', [
            ['Next','fas fa-file black',    '@File naming',      '@Go to files.page.php',               '@','files.page.php', [],'top:500px;'],
            ['Last','fas fa-file black',    '@Folders and files','@Go to support.page.php',             '@','support.page.php', [],'top:500px;']
        ],'top:500px;'],
        ['Next','fas fa-language colrblue', '@TRANSLATE',        '@Go to translate.page.php',           '@','translate.page.php', [],'top:500px;'],
        ['Last','fas fa-code colrcyan',     '@FUNCTIONS',        '@Go to functions.page.php',           '@','functions.page.php', [
            ['Last','fas fa-code colrcyan', '@Overview',         '@Go to functions.page.php',           '@','functions.page.php', [],'top:500px;'],
        ],'top:500px;']
        ];    
?>