<?php   $DocFile= './Proj.demo/documentation.page.php';    $DocVer='1.6.0';    $DocRev='2026-10-11';     $DocIni='evs';  $ModulNr=0; ## File informative only
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
    
    htm_Card_(capt:'@What is new in version 1.6.0', icon:'fas fa-star', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'', elem:'section');
    htm_TextDiv('<div style="text-align: left; white-space: normal;">
    <b>For the user of a page:</b>
    <ul>
    <li><b>Keyboard:</b> card headers and their icons, state buttons, the tab close cross and the table index are reached with <kbd>Tab</kbd> and used with <kbd>Enter</kbd> / <kbd>Space</kbd>.
        Hints are also shown when a field or button gets keyboard focus. The left menu opens when it gets focus.</li>
    <li><b>Shortcuts:</b> buttons with <code>akey:</code> work as <kbd>Alt</kbd>+key (Firefox: <kbd>Alt</kbd>+<kbd>Shift</kbd>+key) - the hint shows the key.</li>
    <li><b>Phones:</b> cards are never wider than the screen, the vertical edge texts are hidden, the left menu is placed above the content.</li>
    <li><b>Dark theme:</b> readable card titles, side texts, PDF pager, human test and pasted colored text.</li>
    <li><b>Language:</b> choose the language with the flag button in the floating view bar (the languages that have translations).</li>
    <li><b>Card size:</b> drag the grip in the lower right corner of a card to change its width and height (arrow keys work too).
        The size is remembered per card in the browser; double-click the grip (or <kbd>Home</kbd>) for the original size.
        A program can turn the grips off with <code>$gbl_CardResize= false;</code></li>
    <li><b>Move cards:</b> drag the handle <i class="fa-solid fa-grip-vertical"></i> in a card header to place the card elsewhere among its sibling cards
        (<kbd>Alt</kbd>+<kbd>&uarr;</kbd>/<kbd>&darr;</kbd> moves one place). The order is remembered per page in the browser; the card menu (right-click a header) has <i>Original card order</i>.
        The program decides how moving is activated: <code>$gbl_CardMove= &#39;icon&#39;</code> (default), <code>&#39;header&#39;</code> (drag the header itself - a click still folds),
        <code>&#39;toggle&#39;</code> (the view bar button <i>Arrange cards</i> turns it on) or <code>false</code>. A single card stays in place with <code>htm_Card_(move:false)</code>.
        Try the modes on the <i>Card</i> page.</li>
    <li><b>Quick actions:</b> a page can have a bar with shortcuts at the bottom of the window (see the <i>Advanced example</i> page). On phones only the icons are shown.</li>
    <li><b>Session:</b> while you work, the session is kept alive. After a long pause you are asked 2 minutes before it ends, and if it has ended you are told to reload before you save - no more lost form data.</li>
    <li><b>Print:</b> every page prints only the content - no menus, bars or buttons, folded cards printed open.</li>
    <li><b>Home screen:</b> the demo can be installed as an app (manifest.json, icon).</li>
    <li><b>My notes:</b> the note button in the view bar opens a personal notepad. The notes are saved automatically in this browser - the same notes on every page; nothing is sent to the server.
        A dot on the button shows that there are notes. <i>Download</i> saves them as a text file.</li>
    <li><b>Help:</b> the <b>?</b> button in the view bar opens the help text of the page in a movable window (grey when the page has none).
        The texts are in <i>help_system.json</i> (English) and <i>help_system_da.json</i> (Danish) - one entry per page.</li>
    <li><b>Column view:</b> the column button in the view bar lets the cards flow in columns (like a newspaper) - the number of columns follows the window width. The choice is remembered in the browser.</li>
    </ul>
    <b>For the programmer:</b>
    <ul>
    <li><b>msg_Dialog() is deprecated:</b> it now shows the theme-aware dialog of <code>sysAlert()</code> / <code>sysConfirm()</code> (button 1 = OK, button 2 = Cancel, the message as text) -
        jQuery UI is not used by the library any more. Use <code>sysAlert()</code> / <code>sysConfirm()</code>, <code>msg_Error()</code> ... or <code>htm_Alert()</code> in new code.
        Tablesorter is loaded by the first <code>htm_Table()</code> of a page; <code>$gbl_LazyLibs= false;</code> loads Tablesorter and jQuery UI in &lt;head&gt; as before.</li>
    <li><b>Customize without editing the library:</b> put the settings of a project in its own file, outside the library folder, and point to it
        in the page <i>before</i> the library is loaded: <code>$gbl_InitFile= __DIR__.&#39;/../myproject.init.php&#39;;</code>
        (else <i>project.init.php</i> next to the library is used). An update of the library then never overwrites the project.
        In that file: all <code>$gbl_...</code> settings, <code>$gbl_CustomCss</code> (CSS text or the address of a .css file - added after the system CSS),
        <code>$gbl_CustomLib</code> (own functions), <code>$gbl_CustomRules</code> (table row rules), <code>define(&#39;DecimalSep&#39;, ...)</code> /
        <code>ThousandsSep</code> / <code>DEBUG</code>, and <code>$headEndScript</code>, <code>$bodyEndScript</code>, <code>$gbl_novice</code>.</li>
    <li><code>htm_Card_(elem:\'section\')</code> - the HTML element of a card: <i>span</i> (default), <i>section, article, aside, main, header, footer, div</i>.
        A semantic card gets its caption as accessible name. <code>htm_Page_()</code> now puts the page content in <code>&lt;main&gt;</code>.</li>
    <li><code>htm_Tab(dflt:true)</code> - the tab is opened when the page has loaded.</li>
    <li><code>$englishOnly= true;</code> (in the page before <code>require</code>, or in <i>project.init.php</i>) turns the translation system off - English texts only, no language selector. Before, the library always set it to false.</li>
    <li>From NH-logistik: session warning (<code>$gbl_SessionWarn= false;</code> turns it off; keep-alive request <code>?p2h_keepalive=1</code>), print CSS for all pages,
        and <i>manifest.json</i> + <i>favicon.svg</i> next to the library (linked by <code>htm_Page_()</code> when they exist).</li>
    <li>From TinyCash: <code>htm_NotePad()</code> (personal notes in the view bar; <code>$gbl_NotePad= false;</code> removes it), <code>htm_PageHelp()</code> (help per page, <i>help_system.json</i>) and <code>htm_QuickBar(list:[[link, label, icon, hint, dot color, JavaScript], ...])</code> -
        the page gets room at the bottom, and the fixed elements of the library near the bottom are lifted above the bar.</li>
    <li>From NH-logistik: <code>htm_Alert()</code> (message box), <code>htm_Banner()</code>, <code>htm_Badge()</code> (small label),
        <code>htm_ConfirmPostLink()</code> (asks first, then POSTs with the CSRF token) and <code>htm_TableTools()</code> (search and sort without jQuery) - see the <i>Others</i> page.</li>
    <li><code>htm_LangSelect()</code> - language selector with flags (<code>p2h_flag()</code>: inline SVG), part of <code>htm_ViewBar()</code>. A language is only remembered from a POST with a valid CSRF token.</li>
    <li>Danish numbers like <i>1 234,50</i> keep their decimals in <code>htm_Input</code> (dec/num) and <code>htm_Table</code> (0d/1d/2d, calc) - see <code>sys_toFloat()</code>.</li>
    <li><code>htm_Input(form:\'...\')</code> posts with method POST and the CSRF token. The <i>mail</i> variant has a valid pattern.</li>
    <li><code>htm_Table</code> columns <i>chck</i> save per row; <i>bold/ital</i> are read-only. Data values are no longer translated.</li>
    <li>PDF viewer: a local copy of pdf.js in <i>_assets/pdfview/latest/</i> (<code>$needPdfview=\'1\'</code>), and a message if the PDF cannot be loaded.</li>
    <li><i>project.init.php, customLib.inc.php, customRules.inc.php</i> are read from the folder of <i>php2html.lib.php</i> (before: the folder above the page).</li>
    <li>Card help (<code>help:</code>) - see the <b>?</b> icon, e.g. on the Demo page.</li>
    </ul></div>', algn:'left');
    htm_Card_end();

    htm_Card_(capt:'@Documentation:', icon: 'fas fa-info', hint:'', form:'', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr: '');

    htm_TextDiv('You can find informations about using the PHP2HTML-system here:<br><br>
    <b>Overviews:</b><br>
    htm_Functions - Look at this page: <br>
    <li>FUNCTIONS > Overview > Card: <a href="functions.page.php"><i>The overview over the system functions.</i></a></li>
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
    
    CardOff($First=2,$Last=4);     # (Card 1 "What is new" stays open)
htm_Page_end();
?>