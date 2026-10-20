# Changelog

What is new in each version of php2html (Clever-Html-Engine). Upgrading from 1.6: see [README.md](README.md#upgrading-to-17).

## Unreleased
- **No false error:** a page that does not ask for jQuery (`$needJquery= '0'`, as `world/first.page.php`) no longer shows "ERROR: jQuery is not loaded" - jQuery and jQuery UI are optional.
- **Composer:** `composer.json` - install with `composer require ev-soft/clever-html-engine`; the old 1.4 copy in `latest/` is left out of the package.

## 1.7.5 - hints, view bar user, card headers, session
- **Hints instead of `title`:** tabs, the tab close icon, the vertical page tip, the view bar buttons, the notes and the help window show the library hint (theme-aware, placed at the element) instead of the browser tooltip.
- **View bar:** `htm_ViewBar(user: '...', lout: '...')` shows the logged in user and a log out button at the end of the bar.
- **Help button:** `$gbl_PageHelp= false;` hides the help button for the page (as `$gbl_NotePad` for the notes).
- **Card headers:** a click on the empty part of a card header folds the card (as a click on the caption) - not after a drag, not on tools, fields or selected text; the fold cursor is shown over the whole header.
- **Session:** `$gbl_SessionKeep= true;` - an open page keeps the session alive by itself (a light request every 5 minutes at most), without the "Still working?" dialog.
- **Human test slider:** robust drag (reaches the end, snaps at 80 %, no text selection, zoom-aware).

## 1.7.4 - card icon hints
- **Cards:** the hint of a card header icon (toggle height, wide, collapse / expand all, help) is shown just below its own icon. The icons float right inside an inline hint element, so the hint was placed from the card's corner - up to 1250 px away from the icon.
- **Tables:** the "Go up" button of a file / folder table no longer gives a PHP notice (`end(explode())`), and a precedence error in its sorter check is fixed.

## 1.7.3 - column resize grips
- **Tables:** the grips for changing a column width are on the column lines again. Tablesorter subtracted the table's offset in its wrapper (it must be added), so the grips were beside the lines when the table was not at the left edge - e.g. in a centered card - and with zoom. They are also placed again when the page has loaded and when the window is resized.

## 1.7.2 - rtrn:false in every function
- `htm_TextArea()`, `htm_ActionButt()`, `htm_MultistateButt()` and `htm_ModalDialog()` now **echo** the HTML by default, as all other functions (they returned it - called alone they showed nothing).
- **Upgrading:** where you use the result of one of them (`echo htm_TextArea(...)`, `'...'.htm_ActionButt(...)`, `$x= ...`) without `rtrn`, add `rtrn:true` - or run `php tools/named_args.php <folder> --write`, which does it for you.

## 1.7.1 - fixes
- **Tables:** number columns (`0d`, `1d`, `2d`, `2%`) are sorted as numbers (were sorted as text: "1 234,00" before "9,00") and can be filtered with e.g. `>9`; the number 0 is shown as 0,00 (was blank); the format `>0` also hides negative numbers; the CSV export (`expo`) writes the data as shown (it removed `@` and translated values).
- **Fields:** a field without a label is named by its hint or placeholder; `intg` fields get an integer (a decimal value made every typed integer invalid); radio buttons and option values are escaped and get valid, unique ids; the group label of a checkbox/radio list points to its own first box.
- **Upgrade tool:** `tools/named_args.php` also finds `\htm_Input(` and `HTM_INPUT(`, and has `--from=1.6.3` for code written for 1.6.3 or older.
- **Other:** `sys_toFloat(",5")` is 0.5 (was 5); `csv_parse()` reads quoted field names and fields with line breaks; the function overview shows the library version (`P2H_VERSION`) and no stray ";"; more escaping (`htm_Output`, `htm_Humantest`, `htm_Menu_Leftout`); demo links point to v1.7.x.

## 1.7.0 - one parameter order
The parameters of all functions now follow one order, so a call reads the same everywhere:

| Group | Parameters |
|---|---|
| 1. Texts | `capt` / `labl`, `icon`, `hint`, `plho` |
| 2. Variant, name, value, content | `vrnt` / `type` / `kind` / `mode`, `name`, `valu`, `body` ..., `list`, `data` |
| 3. Form and action | `form`, `acti`, `link`, `clck`, `evnt`, `targ` |
| 4. Size and look | `wdth`, `vhgh`, `algn`, `marg`, `bord`, `font`, `fclr`, `bclr`, `colr`, `styl`, `attr` |
| 5. The function's own parameters | e.g. `unit`, `rows`, `step` in `htm_Input()` |
| 6. Return | `rtrn` - always last |

A function without a heading text keeps its main content first: `htm_TextDiv(body)`, `htm_Alert(body)`, `htm_Form_(name)`, `htm_TableTools(tabl)`.
34 functions got a new order, e.g. `htm_Input(labl, icon, hint, plho, vrnt, name, valu, list, form, ...)` (plho was 2nd), `htm_Table(... note, list, data, wdth, vhgh, styl, filt, ...)`, `msg_System(capt, vrnt, ...)`, and `htm_SwitchButt()` / `htm_SwitchButton()` now have the same order.
Also: an unknown `vrnt` in `htm_Input()` / `htm_Output()` names the variant in its message, and its label no longer points to a missing field.

## 1.6.5
- **New function:** `htm_faq()` - a question with a folded answer (`<details>`), works without JavaScript; `grup` keeps only one answer open.
- **Function overview:** the complete list of the 4-character parameter names; the description is shown as a hint, and only parameter names are marked.
- **Security:** `calcHash()` no longer writes the clear-text password into the page; `LangCreate.php` reflected XSS closed; texts in popup menus, option lists and messages are escaped (new `p2h_jsStr()`).
- **Accessibility:** names for dialogs and switches, tab state (`aria-expanded`), sortable table headers with Enter/Space, `msg_System()` closable with the keyboard, the captcha slider reports its value.
- **Fixes:** about 50 bugs found in "find five bugs" rounds - e.g. `htm_Inbox(edit:true)` content was never posted, row copy in tables, `ddwn`/`opti` table cells, unique ids for switches, icon buttons, checkboxes and column blocks, `pbrd:true` page border, `htm_List_` numbered lists, `htm_TextDiv()` without `body`, CSV helpers in `filedata.inc.php`.

## 1.6.4
- **Reference pages:** `table.page.php` and `card.page.php` document `htm_Table()` and `htm_Card_()` / `htm_Card_end()` with live examples - the code shown is the code that runs, and the parameter lists are read from the library (so they cannot get out of date). Code examples are folded (`htm_CodeBox(fold:'closed')`).
- **Tables:** row actions in the browser (`rowact`: delete, copy, move, undo), `calc` with your own formula (`fn($row) => ...`), rows with field names, short rows padded, the new row gets the row actions, a table no longer shakes when its rows are as high as its window.
- **Uniform parameters:** `rtrn` in every function, the summary comments match the parameters, uniform names with the old ones still working (`valu`, `wdth`, `vhgh`, `disa`; `htm_Inbox(edit:)`).
- **Cards:** a real footer (`htm_Card_end(foot:, subm:)`).
- **Accessibility:** names for table fields, icon buttons and other fields, the password toggle and the captcha slider work with the keyboard, labels that point to the right element.
- **Fixes:** about 100 bugs found in "find five bugs" rounds - e.g. escaping of names, placeholders and labels, dialogs inside card forms, the translation scanner, the tinyEditor upload, database helper errors (`filedata.inc.php`), PHP warnings without `_trans.sys.json`.

## 1.6.1 - 1.6.3
- **Faster pages:** the CSS/JS of `<head>` is written once to cached files (`_cache/`, ~110 KB less per page); Tablesorter is loaded by the first `htm_Table()` and jQuery UI is no longer needed; preconnect to the CDN; one shared card menu; shorter table cell styles.
- **Libraries:** TinyMCE 8.9.3 (security fixes), Font Awesome 7.3.1, jQuery UI 1.14.2, Tablesorter 2.32.0, pdf.js 6.4.299.
- **Translations:** all texts of the library in Danish, German, French and Swedish; ~190 Danish machine-translation errors corrected.
- **Fixes:** HTML5-valid output (nested forms, unclosed `<style>`, void elements, escaping), `msg_System()` layout, `msg_Dialog()` on the theme-aware dialog (deprecated), session warning after expiry, number formats, folded card widths, page zoom and card resize.
- New settings: `$gbl_AssetCache`, `$gbl_LazyLibs` (see `project.init.php`).

## 1.6.0
**For the user of a page**
- **View bar:** a floating, movable bar with zoom, full screen, column view, language (with flags), personal notes, page help and theme.
- **Column view:** the cards flow in columns that fit the window.
- **Cards:** drag the corner grip to resize a card, and move cards to another place among their sibling cards. Size and order are remembered per page in the browser.
- **Page help:** a "?" button opens the help text of the page in a movable window (`help_system.json`, one file per language).
- **Session warning:** while you work, the session is kept alive. After a long pause you are asked before it ends, and if it has ended you are told to reload before you save.
- **Print:** every page prints only the content (no menus, bars or buttons), and folded cards are printed open.
- **Accessibility:** skip links, a page heading, card captions as headings, keyboard use of all card icons, hints on keyboard focus, and unique element ids.
- **Install as an app:** `manifest.json` and icons.

**For the programmer**
- New functions: `htm_Alert()`, `htm_Banner()`, `htm_Badge()`, `htm_ConfirmPostLink()`, `htm_TableTools()`, `htm_LangSelect()`, `htm_PageHelp()`, `htm_NotePad()` and `htm_QuickBar()`. There are 78 core functions in total.
- `htm_Card_()`: `elem:` sets a semantic element (section/article/aside...), `fold:'closed'` makes the card start folded, and `move:false` keeps it in place.
- **Customize without editing the library.** Set `$gbl_InitFile` in the page before `require` to use a project file outside the library folder. That file can set:
  - `$gbl_CustomCss`, `$gbl_CustomLib` and `$gbl_CustomRules`;
  - the number format constants `DecimalSep`, `ThousandsSep` and `DEBUG`;
  - `$gbl_CardMove` (`'icon'`, `'header'`, `'toggle'` or `false`), plus `$gbl_CardResize`, `$gbl_NotePad` and `$gbl_SessionWarn`.
- Output after `htm_Page_end()` now stays inside `<body>`.
- Many fixes (XSS, CSRF, dark theme, number formats, duplicate ids). See the page *Documentation → What is new in version 1.6.0* in the demo.
