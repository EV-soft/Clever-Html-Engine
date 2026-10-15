# 🧠 Clever HTML Engine – Functional HTML with PHP
A modern, semantic PHP library for generating HTML interfaces with compact code, multilingual support, and responsive layouts.

# 🚀 Features
- UI components like htm_Input(), htm_Table(), htm_Page_()

- Multilingual labels with internal translation engine (@Label)

- Responsive layout with hints, tooltips, collapsible cards

- Integration with Font Awesome, jQuery UI, TinyMCE, and more

# 🆕 What's new in 1.6.0

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

# 🆕 What's new in 1.6.1 - 1.6.3
- **Faster pages:** the CSS/JS of `<head>` is written once to cached files (`_cache/`, ~110 KB less per page); Tablesorter is loaded by the first `htm_Table()` and jQuery UI is no longer needed; preconnect to the CDN; one shared card menu; shorter table cell styles.
- **Libraries:** TinyMCE 8.9.3 (security fixes), Font Awesome 7.3.1, jQuery UI 1.14.2, Tablesorter 2.32.0, pdf.js 6.4.299.
- **Translations:** all texts of the library in Danish, German, French and Swedish; ~190 Danish machine-translation errors corrected.
- **Fixes:** HTML5-valid output (nested forms, unclosed `<style>`, void elements, escaping), `msg_System()` layout, `msg_Dialog()` on the theme-aware dialog (deprecated), session warning after expiry, number formats, folded card widths, page zoom and card resize.
- New settings: `$gbl_AssetCache`, `$gbl_LazyLibs` (see `project.init.php`).

# 🆕 What's new in 1.6.4
- **Reference pages:** `table.page.php` and `card.page.php` document `htm_Table()` and `htm_Card_()` / `htm_Card_end()` with live examples - the code shown is the code that runs, and the parameter lists are read from the library (so they cannot get out of date). Code examples are folded (`htm_CodeBox(fold:'closed')`).
- **Tables:** row actions in the browser (`rowact`: delete, copy, move, undo), `calc` with your own formula (`fn($row) => ...`), rows with field names, short rows padded, the new row gets the row actions, a table no longer shakes when its rows are as high as its window.
- **Uniform parameters:** `rtrn` in every function, the summary comments match the parameters, uniform names with the old ones still working (`valu`, `wdth`, `vhgh`, `disa`; `htm_Inbox(edit:)`).
- **Cards:** a real footer (`htm_Card_end(foot:, subm:)`).
- **Accessibility:** names for table fields, icon buttons and other fields, the password toggle and the captcha slider work with the keyboard, labels that point to the right element.
- **Fixes:** about 100 bugs found in "find five bugs" rounds - e.g. escaping of names, placeholders and labels, dialogs inside card forms, the translation scanner, the tinyEditor upload, database helper errors (`filedata.inc.php`), PHP warnings without `_trans.sys.json`.

# 🆕 What's new in 1.6.5
- **New function:** `htm_faq()` - a question with a folded answer (`<details>`), works without JavaScript; `grup` keeps only one answer open.
- **Function overview:** the complete list of the 4-character parameter names; the description is shown as a hint, and only parameter names are marked.
- **Security:** `calcHash()` no longer writes the clear-text password into the page; `LangCreate.php` reflected XSS closed; texts in popup menus, option lists and messages are escaped (new `p2h_jsStr()`).
- **Accessibility:** names for dialogs and switches, tab state (`aria-expanded`), sortable table headers with Enter/Space, `msg_System()` closable with the keyboard, the captcha slider reports its value.
- **Fixes:** about 50 bugs found in "find five bugs" rounds - e.g. `htm_Inbox(edit:true)` content was never posted, row copy in tables, `ddwn`/`opti` table cells, unique ids for switches, icon buttons, checkboxes and column blocks, `pbrd:true` page border, `htm_List_` numbered lists, `htm_TextDiv()` without `body`, CSV helpers in `filedata.inc.php`.

# 🆕 What's new in 1.7.0 - one parameter order
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

# 🆕 What's new in 1.7.3 - column resize grips
- **Tables:** the grips for changing a column width are on the column lines again. Tablesorter subtracted the table's offset in its wrapper (it must be added), so the grips were beside the lines when the table was not at the left edge - e.g. in a centered card - and with zoom. They are also placed again when the page has loaded and when the window is resized.

# 🆕 What's new in 1.7.2 - rtrn:false in every function
- `htm_TextArea()`, `htm_ActionButt()`, `htm_MultistateButt()` and `htm_ModalDialog()` now **echo** the HTML by default, as all other functions (they returned it - called alone they showed nothing).
- **Upgrading:** where you use the result of one of them (`echo htm_TextArea(...)`, `'...'.htm_ActionButt(...)`, `$x= ...`) without `rtrn`, add `rtrn:true` - or run `php tools/named_args.php <folder> --write`, which does it for you.

# 🆕 What's new in 1.7.1 - fixes
- **Tables:** number columns (`0d`, `1d`, `2d`, `2%`) are sorted as numbers (were sorted as text: "1 234,00" before "9,00") and can be filtered with e.g. `>9`; the number 0 is shown as 0,00 (was blank); the format `>0` also hides negative numbers; the CSV export (`expo`) writes the data as shown (it removed `@` and translated values).
- **Fields:** a field without a label is named by its hint or placeholder; `intg` fields get an integer (a decimal value made every typed integer invalid); radio buttons and option values are escaped and get valid, unique ids; the group label of a checkbox/radio list points to its own first box.
- **Upgrade tool:** `tools/named_args.php` also finds `\htm_Input(` and `HTM_INPUT(`, and has `--from=1.6.3` for code written for 1.6.3 or older.
- **Other:** `sys_toFloat(",5")` is 0.5 (was 5); `csv_parse()` reads quoted field names and fields with line breaks; the function overview shows the library version (`P2H_VERSION`) and no stray ";"; more escaping (`htm_Output`, `htm_Humantest`, `htm_Menu_Leftout`); demo links point to v1.7.x.

# ⬆️ Upgrading to 1.7
- **Named arguments** (`labl:'@Name', vrnt:'text'`) work as before - nothing to do. They are the recommended way to call the library.
- **Positional arguments** (`htm_Input('@Name', '@Enter...', ...)`) must be checked: their meaning follows the position. Run the upgrade tool on your code **before** you replace the library:
  ```bash
  php tools/named_args.php  my_project/            # shows what would be changed
  php tools/named_args.php  my_project/  --write    # changes the files (a copy is saved as *.bak)
  ```
  It knows the old and the new order of the 34 functions and rewrites a call to named arguments from the first position whose name has changed - the result works with both 1.6 and 1.7. An old-style argument `$labl= '...'` becomes `labl: '...'`. Code examples inside strings are not changed - check them yourself.
  Code written for **1.6.3 or older**: add `--from=1.6.3` (in those versions `htm_CodeBox()` had `rtrn` as argument 6 - `fold` since 1.6.4).
  Do not run the tool on code written for 1.7 - it would read the positions as the old ones.
- The old alias names (`vlue`, `widt`, `heig`, `hght`) still work.
- **1.7.2:** `htm_TextArea()`, `htm_ActionButt()`, `htm_MultistateButt()` and `htm_ModalDialog()` echo by default - the tool adds `rtrn: true` where their result is used.

# 📦 Installation
```bash
git clone https://github.com/EV-soft/Clever-Html-Engine.git
```
Include the library in your PHP project (PHP 8.1+):
```php
require_once 'php2html.lib.php';
```
# 💡 Examples
Input field with currency:
```php
htm_Input(
    vrnt: 'dec2',
    name: 'price',
    valu: 123.45,
    labl: '@Price',
    hint: '@Enter amount with 2 decimals',
    unit: 'US$'
);
```
Simple table:
```php
$data = [
    ['Alice',   30, 'alice@example.com'],
    ['Bob',     42, 'bob@example.com'],
    ['Charlie', 25, 'charlie@example.com']
];
htm_Table(
    capt: [], pref: [],
    body: [     # [0:label, 1:width, 2:type, 3:format, 4:[align], 5:field key]
        ['@Name',  '40%', 'text', '', ['left'],   'f1'],
        ['@Age',   '20%', 'text', '', ['right'],  'f2'],
        ['@Email', '40%', 'text', '', ['center'], 'f3']
    ],
    suff: [], note: '',
    data: $data
);
```
# 🌐 Resources
- Online demo and documentation: [ev-soft.work/p2h/v1.7.x](https://ev-soft.work/p2h/v1.7.x/Proj.demo/PHP2HTML-intro.page.php) (use the top menu)
- Project page: [ev-soft.github.io/Clever-Html-Engine](https://ev-soft.github.io/Clever-Html-Engine/)
- Source and releases: [github.com/EV-soft/Clever-Html-Engine](https://github.com/EV-soft/Clever-Html-Engine/releases)

# 🤝 Community
Got ideas or improvements? Contribute via GitHub Pull Requests or open an Issue. Collaboration is welcome!

# 👨‍🚀 Users
You are a php developer who wants to let php2html take over the trivial work of writing basic html code.

***


# php2html.lib = Clever-Html-Engine
Your tool to quickly program html code in your PHP web project.

php2html.lib.php also called "HTML clever engine" consists of a PHP library, with 78 core functions that generate HTML code for standard html elements (INPUT / CHECKBOX / RADIO-GROUP / TABLE), as well as other useful functions.
You get a complete system to form the frontend part of your program.
Built into the system is the easy use of several open-source modules (icons, advanced tables, HTML editor, jquery), and a complete system for changing user languages.	

Standards: PHP 8.1+ (named arguments), HTML5, CSS3, JavaScript.

Source should be in UTF-8, with no tabs, indent: 4 chars

When using <i>PHP2HTML</i> your code will be more compact, and easier to read, and you can have both backend and frontend code in one file.

<i>As an example this high level PHP code:</i>

```php
htm_Input(vrnt:'dec2', name:'dec2', valu:$dec2, labl:'@htm_Input(Dec2)',
          hint:'@Demo of htm_Input Field type dec2: number with 2 decimal',
          algn:'center', unit:'<$ ');
```

<i>will generate this HTML code</i> (with `$dec2= 54321`, lines broken for reading):

```html
<div class="inpField" id="inpBox1" style="margin: auto; padding: 0 2px 6px; width: 100%; display: inline-block; vertical-align: top;">
  <input type="text" id="id_dec2" name="dec2" value="$ 54 321,00" class="boxStyle"
         style="text-align: center; font-size: 14px; font-weight: 600;"
         oninvalid="this.setCustomValidity('Wrong or missing data in htm_Input(Dec2) ! ')" oninput="setCustomValidity('')"
         placeholder="Enter..." pattern="^[^0-9\-]{0,4}\s?-?\d[\d\s.,]*\s?[^0-9]{0,4}$" />
  <abbr class="hint">
    <label for="id_dec2" style="font-size: 12px; vertical-align:top;">
      <div style="white-space: nowrap; margin-left: auto;">htm_Input(Dec2)</div>
    </label>
    <data-hint style="top: 45px; left: 2px;">Demo of htm_Input Field type dec2: number with 2 decimal <br>Unit: $ </data-hint>
  </abbr>
</div>
```

and looks like this:

![image](https://user-images.githubusercontent.com/21997911/131254454-3198a243-a1c3-4238-abe7-2fe46b232fc0.png)


<h3><b>Integrated benefits of the system:</b></h3>
<ul>
<li>Advanced translation system - choose the language with flags in the view bar</li>
<li>Block-oriented provides compact code</li>
<li>Possibility of Font-awesome Icons anywhere</li>
<li>Hints/Tooltip for all html elements</li>
<li>Placeholder/validation for all input elements</li>
<li>Compact layout with advanced collapsible cards - the user can resize and move them, and show them in columns</li>
<li>Floating view bar: zoom, full screen, column view, language, personal notes, page help and theme</li>
<li>Light, dark, automatic and own color themes</li>
<li>Option for user defined system blocks - customize a project without editing the library ($gbl_InitFile, $gbl_CustomCss ...)</li>
<li>Advanced tables based on Mottie Table Sorter system - or simple search and sort without jQuery (htm_TableTools)</li>
<li>TinyMCE integrated HTML-editor library</li>
<li>PDF viewer (pdf.js)</li>
<li>Optional use of libraries locally or on the Web (CDN)</li>
<li>Narrow cards suitable for automatic adaptation, and print of the content only</li>
<li>Easily enter dates with browsers date picker interface</li>
<li>Security built in: escaped output, CSRF token in every form, session warning before the session ends</li>
</ul>


<br><strong>About the powerful external libraries:</strong> (all optional - jQuery is only needed by Tablesorter and jQuery UI)<br>
jquery&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "jquery" &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a title="More about the system..." href="https://jquery.com/" target="_blank" rel="noopener">Feature-rich JavaScript library</a><br>
jquery-ui&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "jquery-UserInterface"&nbsp; &nbsp; &nbsp; <a title="More about the system..." href="https://jqueryui.com/" target="_blank" rel="noopener">User interface interactions</a><br>
tablesorter&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"Advanced tables"&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a title="More about the system..." href="https://mottie.github.io/tablesorter/docs/" target="_blank" rel="noopener">Plugin for turning a standard HTML table into a sortable table</a><br>
font-awesome&nbsp; &nbsp; &nbsp;"Icons"&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a title="More about the system..." href="https://fontawesome.com/" target="_blank" rel="noopener">Icon library and toolkit</a><br>
tinymce&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; "HTML rich text editor"&nbsp; &nbsp; <a title="More about the system..." href="https://www.tiny.cloud/" target="_blank" rel="noopener">Self hosted advanced WYSIWYG HTML editor</a><br>
dialog-polyfill&nbsp; &nbsp; &nbsp; &nbsp;"popup dialog"&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a title="More about the system..." href="https://github.com/GoogleChrome/dialog-polyfill" target="_blank" rel="noopener">Dialog element for a popup box</a><br>
pdf.js&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;"PDF viewer"&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a title="More about the system..." href="https://mozilla.github.io/pdf.js/" target="_blank" rel="noopener">Show PDF files in the page</a><br><br>



<h3><b>How to start your first project</b></h3>

Save system-files on your web-server in system-folder '{public-URL}/hello'

Create project-folder '/world' and create the file: '{public-URL}/hello/world/first.page.php' with this content (it is also in the repository):

```php
<?php
#   Getting started:
#   How to output your first page...

$sys= $GLOBALS["gbl_ProgRoot"]= '../';     // a system variable: path to the system folder

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '0';
$needTablesorter= '0';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');    // the system library

### PAGE-START:
htm_Page_(titl:'@DEMO', hint:'', info:lang('@PHP2HTML: My first page'), inis:'',
          algn:'center', imag:'../_accessories/_background.png', pbrd:false);

    htm_Caption(labl:'@HELLO WORLD:', icon:'fa-solid fa-earth-europe', hint:'@This is your first page', algn:'center',
                styl:'color:#550000; font-weight:600; font-size: 18px;');

    htm_Card_(capt:'@My first card', icon:'fa-solid fa-star', clas:'cardW480');
        htm_Input(labl:'@Your name', plho:'@Enter...', hint:'@Type your name', vrnt:'text', name:'yourName', valu:'');
        htm_Input(labl:'@Price', hint:'@Enter amount with 2 decimals', vrnt:'dec2', name:'price', valu:123.45, unit:'<$ ');
    htm_Card_end();

### :PAGE_END
htm_Page_end();
```

Now you can see the page in your browser at URL: '{public-URL}/hello/world/first.page.php'

Another more in-depth way is to follow the instructions in Quick_Proj/quickstart.page.php

Advanced example - see files in folder: '{public-URL}/hello/Proj.demo/'
 
<h3><b>More information...</b></h3>

You can see a combined documentation & demo and try the functions here: https://ev-soft.github.io/Clever-Html-Engine/

To learn the system and its possibilities, it is recommended to study the *.page.php files in the folder: Proj.demo

<h3><b>Online-Demo:</b></h3>

Get inspired and test the system.

Go to the full window demo and see advanced example: [CustomerOrder](https://ev-soft.work/p2h/v1.7.x/Proj.demo/CustomerOrder.page.php)

Use the top menu to view documentation and examples.

<p style="text-align: center;"><b>

                      PHP is the language to make server-side backend programming.

            PHP2HTML is your tool/framework to make your client-side frontend programming in PHP.
     		
               "HTML clever engine" combines frontend and backend php in a common PHP file.

</b></p>
