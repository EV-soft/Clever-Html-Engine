<?php   $DocFile= './Proj.demo/card.page.php';    $DocVer='1.6.4';    $DocRev='2026-10-13';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

$gbl_CardMove= in_array($_GET['move'] ?? '', ['icon','header','toggle','off'], true) ? $_GET['move'] : 'icon';   # Demo: try the activation modes
if ($gbl_CardMove=='off') $gbl_CardMove= false;
require_once ($sys.'php2html.lib.php');
require_once('docHelp.inc.php');                  # docExample(), docParamTable(), docPostCard()

### PAGE-START:
htm_Page_(titl:'card.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'',
           algn:'center', imag:'../_accessories/_background.png', pbrd:false);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine', data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote);
    htm_nl(2);
    echo '<div style="text-align: center;">';

docPostCard();                                      # What the server got when a card was saved

## 1. A minimal card
    htm_Card_(capt:'@htm_Card_() - a minimal card', icon:'fas fa-clone', clas:'cardW800', vhgh:'none');
        htm_TextDiv(body:'@A card is htm_Card_() ... htm_Card_end() with your content in between. Click the header to fold the card.', attr:'white-space: normal;');
        // EXAMPLE: minimal
        htm_Card_(capt:'@My card', icon:'fas fa-star', clas:'cardW320');
            htm_TextDiv(body:'@The content of the card.');
        htm_Card_end();
        // END
        htm_CodeBox(code: docExample('minimal'), fold:'closed');
    htm_Card_end();

## 2. Form and footer
    htm_Card_(capt:'@A form in the card - and the footer', icon:'fas fa-pen-to-square', clas:'cardW800', vhgh:'none');
        htm_TextDiv(body:'@With form: the card body is a form (POST, with the CSRF token). htm_Card_end(subm:true) puts a submit button in the footer, foot: a text. '.
                         'The footer stays below the scrolling body. Press Save - the card at the top shows what the server receives.', attr:'white-space: normal;');
        // EXAMPLE: form
        htm_Card_(capt:'@Contact', icon:'fas fa-user', form:'contact', clas:'cardW400');
            htm_Input(labl:'@Name',  name:'name', valu:$_POST['name'] ?? '', wdth:'90%');
            htm_Input(labl:'@Email', name:'mail', valu:$_POST['mail'] ?? '', vrnt:'mail', wdth:'90%');
        htm_Card_end(labl:'@Save', icon:'fas fa-floppy-disk', subm:true, foot:'@Remember to save');
        // END
        htm_CodeBox(code: docExample('form'), fold:'closed');
        htm_TextDiv(body:'@kind: the color of the button - save, navi, goon, eras, crea, home, get_, put_, spc1, spc2. akey: the access key (Alt+key).', attr:'white-space: normal;');
    htm_Card_end();

## 3. The header
    htm_Card_(capt:'@The header', icon:'fas fa-heading', clas:'cardW960', vhgh:'none');
        // EXAMPLE: header
        htm_Card_(capt:'@Simple', simp:true, clas:'cardW240');                                    # Only the centered caption
            htm_TextDiv(body:'simp: true');
        htm_Card_end();
        htm_Card_(capt:'@Colors', icon:'fas fa-palette', clas:'cardW240',
                  head:'background-color:#1565c0;', fclr:'color:white;');                         # Header style and icon color
            htm_TextDiv(body:'head, fclr');
        htm_Card_end();
        htm_Card_(capt:'@Left and right', clas:'cardW240',
                  frst:'<small>frst</small>', last:'<small>last</small>');                        # last replaces the buttons
            htm_TextDiv(body:'frst, last');
        htm_Card_end();
        htm_Card_(capt:'@Help', icon:'fas fa-life-ring', clas:'cardW240', mode:'1',
                  help:'documentation.page.php', hint:'@Your own hint on the caption');          # ? icon, only the height button
            htm_TextDiv(body:'help, mode:1, hint');
        htm_Card_end();
        htm_Card_(capt:'@No buttons', clas:'cardW240', show:false, hint:'', poup:false);          # No buttons, no hint, no right-click menu
            htm_TextDiv(body:'show:false, hint:&#39;&#39;, poup:false');
        htm_Card_end();
        // END
        htm_CodeBox(code: docExample('header'), fold:'closed');
        htm_TextDiv(body:'@The buttons at the right (mode 2): toggle the height, toggle the width, close all cards, open all cards. Right-click a header: a menu for all cards (poup).', attr:'white-space: normal;');
    htm_Card_end();

## 4. Size and folding
    htm_Card_(capt:'@Size and folding', icon:'fas fa-up-right-and-down-left-from-center', clas:'cardW960', vhgh:'none');
        // EXAMPLE: size
        htm_Card_(capt:'@Starts folded', icon:'fas fa-folder', clas:'cardW400',
                  fold:'closed', wdth:'200px');                                                  # Folded: 200px wide - open: 400px
            htm_TextDiv(body:'fold: closed, wdth: 200px');
        htm_Card_end();
        htm_Card_(capt:'@Scrolling body', icon:'fas fa-scroll', clas:'cardW280', vhgh:'110px',
                  styl:'background-color: #fffbe6;', attr:'border: 2px solid #e0a800; border-radius: 8px;');
            htm_TextDiv(body: str_repeat(lang('@More content than the height (vhgh) - it scrolls.').'<br>', 6), attr:'white-space: normal;');
        htm_Card_end();
        // END
        htm_CodeBox(code: docExample('size'), fold:'closed');
        htm_TextDiv(body:'@clas: the width - cardWmax (full), cardWaut (the content), cardW120 (1200px), cardW110, cardW100, cardW960, cardW800, cardW720, cardW640, cardW560, cardW480, cardW400, cardW320, cardW280, cardW240, cardW160. '.
                         'On a narrow screen the cards are placed below each other. vhgh: the max height of the body (none: no limit).', attr:'white-space: normal;');
    htm_Card_end();

## 5. Cards in cards
    htm_Card_(capt:'@Cards in cards - and forms', icon:'fas fa-layer-group', clas:'cardW800', vhgh:'none');
        htm_TextDiv(body:'@Cards can be nested. HTML does not allow a form in a form: inside a card with a form, the form of an inner card is not made - its fields belong to the outer form. Press Save: both fields are sent.', attr:'white-space: normal;');
        // EXAMPLE: nested
        htm_Card_(capt:'@Outer card (with a form)', icon:'fas fa-box-open', form:'outer', clas:'cardW560');
            htm_Input(labl:'@Outer field', name:'outer_f', valu:$_POST['outer_f'] ?? '', wdth:'90%');
            htm_Card_(capt:'@Inner card', icon:'fas fa-box', form:'inner', clas:'cardW480', poup:false);   # form: ignored (no nested forms)
                htm_Input(labl:'@Inner field', name:'inner_f', valu:$_POST['inner_f'] ?? '', wdth:'90%');
            htm_Card_end();
        htm_Card_end(labl:'@Save', subm:true);
        // END
        htm_CodeBox(code: docExample('nested'), fold:'closed');
    htm_Card_end();

## 6. Semantic element
    htm_Card_(capt:'@The HTML element (elem)', icon:'fas fa-code', clas:'cardW800', vhgh:'none');
        htm_TextDiv(body:'@A card is a span. elem: section, article, aside, main, header, footer or div - a semantic element gets the caption as its accessible name (aria-labelledby). The caption is a heading.', attr:'white-space: normal;');
        // EXAMPLE: elem
        htm_Card_(capt:'@News', icon:'fas fa-newspaper', clas:'cardW320', elem:'article');
            htm_TextDiv(body:'&lt;article aria-labelledby=...&gt;');
        htm_Card_end();
        // END
        htm_CodeBox(code: docExample('elem'), fold:'closed');
    htm_Card_end();

## 7. Moving and resizing
    htm_Card_(capt:'@Moving and resizing cards', icon:'fas fa-arrows-up-down-left-right', clas:'cardW800', vhgh:'none');
        htm_TextDiv(body: lang('@Move: drag a card to another place among its sibling cards (Alt + arrow up/down: one place). The order is remembered in this browser - the right-click menu has "Original card order".').'<br>'.
                          lang('@How it is started is set with $gbl_CardMove (e.g. in project.init.php) - try it on this page:'), attr:'white-space: normal;');
        foreach (['icon' => '@A handle in the header (default)', 'header' => '@Drag the header', 'toggle' => '@The view bar button Arrange cards', 'off' => '@Off'] as $m => $t)
            htm_LinkButt(labl:'$gbl_CardMove= '.($m=='off' ? 'false' : "'".$m."'"), hint:$t, link:'card.page.php?move='.$m, targ:'_self');
        htm_nl(1);
        htm_TextDiv(body: lang('@move:false on a card: it stays in place.').'<br>'.
                          lang('@Resize: drag the grip in the lower right corner (or the arrow keys). Double-click or Home: the original size. $gbl_CardResize= false: no grip.').'<br>'.
                          lang('@Keyboard: Tab to the header or a button, Enter or Space to use it. The hint is also shown on keyboard focus.'), attr:'white-space: normal;');
        htm_TextDiv(body: lang('@From JavaScript: CardMinimizeAll(), CardMaximizeAll() (close / open all cards), CardHeightAll(mode) and p2hCardMove.reset() (the original order).'), attr:'white-space: normal;');
        htm_AcceptButt(labl:'@Close all cards', icon:'fas fa-angle-double-up',   kind:'navi', acti:'CardMinimizeAll();');
        htm_AcceptButt(labl:'@Open all cards',  icon:'fas fa-angle-double-down', kind:'navi', acti:'CardMaximizeAll();');
    htm_Card_end();

## 8. All parameters
    htm_Card_(capt:'@All parameters of htm_Card_() and htm_Card_end()', icon:'fas fa-list', clas:'cardW960', vhgh:'none');
        htm_TextDiv(body:'@Read from the library itself: the name, the default value and the description.', attr:'white-space: normal;');
        htm_Caption(labl:'htm_Card_()');
        docParamTable('htm_Card_', vhgh: '700px');
        htm_Caption(labl:'htm_Card_end()');
        docParamTable('htm_Card_end', vhgh: '420px');
    htm_Card_end();

    echo '</div>';
htm_Page_end();
?>
