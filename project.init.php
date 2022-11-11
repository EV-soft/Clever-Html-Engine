<?php   $DocFil= 'project.init.php';    $DocVer='1.2.1';    $DocRev='2022-10-07';     $DocIni='evs';  $ModulNr=0; ## File informative only
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
    $gbl_PanelBgrd= 'transparent';      # Panels hideble background
    $gbl_GridOn= true;                  # Use grid to place objects in rows / colums
    $gbl_progZoom = 'small';            # Global tag "font-scale"
    $GLOBALS["gbl_ProgRoot"]= '../';
?>