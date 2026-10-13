<?php $DocFile= './Proj.demo/table.page.php';    $DocVer='1.6.4';    $DocRev='2026-10-13';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2026 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once($sys.'php2html.lib.php');

# The code of an example: the lines between "// EXAMPLE: <name>" and "// END" in this file - the code shown is the code that runs
function tblExample($name) {
    static $src= null;
    $src ??= file(__FILE__);
    $out= [];  $on= false;
    foreach ($src as $l) {
        if ($on and preg_match('~^\s*// END\s*$~', $l)) break;
        if ($on) $out[]= rtrim($l)."\n";
        if (preg_match('~^\s*// EXAMPLE: '.preg_quote($name, '~').'\s*$~', $l)) $on= true;
    }
    $ind= min(array_map(function($l) { return strlen($l) - strlen(ltrim($l)); }, array_filter($out, 'trim')) ?: [0]);
    return implode('', array_map(function($l) use ($ind) { return substr($l, min($ind, strlen($l) - strlen(ltrim($l)))); }, $out));
}

# The parameters of htm_Table(), read from the library itself (name, default and the comment after it) - so this list cannot get out of date
function tblParams() {
    $rf= new ReflectionFunction('htm_Table');
    $src= implode('', array_slice(file($rf->getFileName()), $rf->getStartLine() - 1, 60));
    $rows= [];
    foreach ($rf->getParameters() as $p) {
        $n= $p->getName();
        if ($n == 'from') $def= '__FILE__';
        else {
            $v= $p->isDefaultValueAvailable() ? $p->getDefaultValue() : null;
            $def= is_array($v) ? json_encode($v) : var_export($v, true);
        }
        $doc= ['', ''];
        if (preg_match('~&?\$'.$n.'\s*=[^\n#]*#\s*(\w+):\s*([^\n]*)~', $src, $m)) $doc= [$m[1], trim($m[2])];
        $more= '';                                           # The comment lines that follow (the details of capt / pref / body / suff)
        if (preg_match('~&?\$'.$n.'\s*=[^\n]*\n((?:[ \t]*#[^\n]*\n)+)~', $src, $m))
            foreach (explode("\n", trim($m[1])) as $l) $more.= '<br>'.sys_enc(trim(ltrim(trim($l), '#')));
        $rows[]= [$n.($p->isPassedByReference() ? ' (&amp;)' : ''), sys_enc($def), $doc[0], sys_enc($doc[1]).'<small>'.$more.'</small>'];
    }
    return $rows;
}

htm_Page_(titl:'table.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'', algn:'center', imag:'../_accessories/_background.png', pbrd:false);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine', data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote);
    htm_nl(2);
    echo '<div style="text-align: center;">';

## What the server got when a card was saved
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $got= $_POST;  unset($got['csrf_token']);
    htm_Card_(capt:'@What the server received ($_POST)', icon:'fas fa-server', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        htm_TextDiv(body:'@Every field of a row is posted as fkey[] - one value per row, in the order of the rows (also new rows, and the order after moving rows).', attr:'white-space: normal;');
        htm_TextPre(body:sys_enc(print_r($got, true)), attr:'max-height: 300px; overflow: auto;');
    htm_Card_end();
}

## 1. A minimal table
    htm_Card_(capt:'@htm_Table() - a minimal table', icon:'fas fa-table', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        htm_TextDiv(body:'@Only body (the columns) and data (the rows) are needed. Each column: label, width, type, format, style, field name.', attr:'white-space: normal;');
        // EXAMPLE: minimal
        $people= [['Anna', 'Copenhagen', '2026-10-01'],
                  ['Bo',   'Aarhus',     '2026-10-05'],
                  ['Carl', 'Odense',     '2026-09-28']];
        htm_Table(body: [['@Name', '35%', 'text', '', ['left'],   'name'],
                         ['@City', '35%', 'text', '', ['left'],   'city'],
                         ['@Date', '30%', 'date', '', ['center'], 'date']],
                  data: $people, crea: false, vhgh: '160px');
        // END
        htm_CodeBox(code: tblExample('minimal'));
    htm_Card_end();

## 2. Column types
    htm_Card_(capt:'@Column types (body, field 2)', icon:'fas fa-columns', form:'tblTypes', clas:'cardW960', styl:'background-color: white;', vhgh:'none');
        htm_TextDiv(body:'@One column of each type. Change some fields and press Save - the card at the top shows what the server receives.', attr:'white-space: normal;');
        // EXAMPLE: types
        $items= [['17', '1', 'Hammer', 'Steel, 500 g', 'Tools',   '2026-10-01', 'DKK', 'checked', '12', '<b>bold</b> text', '<b>Yes</b>'],
                 ['18', '2', 'Saw',    'Wood saw',     'Tools',   '2026-10-03', 'EUR', '',        '3',  '<i>italic</i>',    'No'],
                 ['19', '3', 'Glue',   '250 ml',       'Liquids', '',           'SEK', 'checked', '40', '<u>underline</u>', '<strong>Yes</strong>']];
        $currencies= [[['DKK', 'DKK', '@Danish krone'], ['EUR', 'EUR', '@Euro'], ['SEK', 'SEK', '@Swedish krona']], 'width: 70px;'];
        htm_Table(body: [
                ['@Id',       '0%',  'hidd', '', ['left'],   'id',    '@The record id - hidden, but posted'],
                ['@No.',      '5%',  'indx', '', ['center'], 'no',    '@indx: the row number - click it'],
                ['@Item',     '12%', 'text', '', ['left'],   'item',  '@text: an editable field', '@Item...'],
                ['@Note',     '14%', 'data', '', ['left'],   'note',  '@data: like text', '@Note...'],
                ['@Group',    '10%', 'show', '', ['left'],   'grp',   '@show: read only'],
                ['@Date',     '13%', 'date', '', ['center'], 'date',  '@date: a date field'],
                ['@Cur.',     '10%', 'ddwn', '', ['center'], 'cur',   '@ddwn: a select - the options in field 9', '', '', $currencies],
                ['@In stock', '7%',  'chck', '', ['center'], 'stock', '@chck: a checkbox - posted as checked or empty'],
                ['@Qty.',     '7%',  'intg', '', ['right'],  'qty',   '@intg: an integer'],
                ['@HTML',     '12%', 'html', '', ['left'],   'html',  '@html: the value as HTML (not posted)'],
                ['@Bold?',    '5%',  'bold', '', ['center'], 'bold',  '@bold: is the text bold (read only)']],
            suff: [['@Del.', '3%', 'rowact', '', ['center'], '@Delete the row (it asks first - Undo brings it back)', 'del']],
            data: $items, crea: '@New item', vhgh: '170px', filt: false);
        // END
        htm_CodeBox(code: tblExample('types'));
        $typeList= [
            ['text, data, area, sttu', lang('@An editable text field'), lang('@yes')],
            ['show',       lang('@A read only field'), lang('@yes')],
            ['intg',       lang('@An integer, formatted with the thousands separator'), lang('@yes')],
            ['date',       lang('@A date field (yyyy-mm-dd)'), lang('@yes')],
            ['ddwn',       lang('@A select. Field 9: [[[value, label, hint], ...], css]'), lang('@yes')],
            ['opti',       lang('@A htm_Input() option field (with its own label). Field 9: [[value, label, hint], ...]'), lang('@yes')],
            ['chck',       lang('@A checkbox. The value posted is checked or empty - for every row'), lang('@yes')],
            ['bold, ital', lang('@A read only checkbox: is the text bold / italic'), lang('@no')],
            ['indx, keyn', lang('@The value as a link (e.g. the row number) - with modi a click calls rowLookup()'), lang('@yes')],
            ['html, htm0', lang('@The value as HTML (htm0: small)'), lang('@no')],
            ['blnk',       lang('@Nothing is shown'), lang('@no')],
            ['hidd',       lang('@A hidden column - e.g. the record id'), lang('@yes')],
            ['calc',       lang('@CustomerOrder only: the line total of fixed columns (quantity, price, discount, VAT)'), lang('@yes')],
            ['vars',       lang('@Old: a select with the options of the list parameter (named liste)'), lang('@no')]];
        htm_Table(body: [['@Type',         '20%', 'html', '', ['left'],   'type'],
                         ['@What it does', '65%', 'html', '', ['left'],   'desc'],
                         ['@Posted',       '15%', 'html', '', ['center'], 'post']],
                  data: $typeList, crea: false, modi: false, filt: false, vhgh: '330px');
    htm_Card_end(labl:'@Save', subm:true, foot:'@Save posts the card form - see the card at the top');

## 3. Formats and styles
    htm_Card_(capt:'@Output formats (field 3) and column style (field 4)', icon:'fas fa-paint-brush', clas:'cardW960', styl:'background-color: white;', vhgh:'none');
        // EXAMPLE: formats
        $numbers= [['1234.5', '1234.5', '1234.5', '12.5', '0', '1234.5', '42', 'red text', 'blue text'],
                   ['-7',     '-7',     '-7',     '100',  '3', '-7',     '7',  'stop',     'go']];
        htm_Table(body: [
                ['0d',   '10%', 'show', '0d', ['right'],  'f0', '@0 decimals'],
                ['1d',   '10%', 'show', '1d', ['right'],  'f1', '@1 decimal'],
                ['2d',   '12%', 'show', '2d', ['right'],  'f2', '@2 decimals'],
                ['2%',   '12%', 'show', '2%', ['right'],  'fp', '@2 decimals and %'],
                ['>0',   '8%',  'show', '>0', ['right'],  'fz', '@Blank when 0 or less'],
                ["'= '", '8%',  'show', '= ', ['right'],  'fb', '@Always blank'],
                ['B',    '12%', 'html', 'B',  ['center'], 'fB', '@Bold #00000 (type html)'],
                ['R',    '14%', 'html', 'R',  ['center'], 'fR', '@Red (type html)'],
                ['L',    '14%', 'html', 'L',  ['center'], 'fL', '@Blue (type html)']],
            data: $numbers, crea: false, modi: false, filt: false, sort: false, vhgh: '130px');
        // END
        htm_CodeBox(code: tblExample('formats'));
        htm_TextDiv(body:'@The numbers use the separators of the program (DecimalSep / ThousandsSep).', attr:'white-space: normal;');
        // EXAMPLE: styles
        $styled= [['Normal', 'Yellow cell', 'Italic field', 'Marked cell', 'Small text'],
                  ['Normal', 'Yellow cell', 'Italic field', 'Marked cell', 'Small text']];
        htm_Table(body: [
                ['@[0] align',       '20%', 'text', '', ['right'],                                     'a', '@[0] text-align'],
                ['@[1] background',  '20%', 'text', '', ['left', 'lightyellow'],                       'b', '@[1] cell background'],
                ['@[2] field style', '20%', 'text', '', ['left', '', 'font-style:italic; color:#900;'], 'c', '@[2] style of the text field'],
                ['@[3] marking',     '20%', 'text', '', ['left', '', '', '#d8ecff'],                   'd', '@[3] cell background (row marking)'],
                ['@[4] font-size',   '20%', 'text', '', ['left', '', '', '', '10px'],                  'e', '@[4] font-size']],
            data: $styled, crea: false, filt: false, sort: false, vhgh: '130px');
        // END
        htm_CodeBox(code: tblExample('styles'));
    htm_Card_end();

## 4. Prefix and suffix columns
    htm_Card_(capt:'@Columns before and after the data (pref, suff)', icon:'fas fa-hand-pointer', form:'tblActs', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        htm_TextDiv(body: lang('@rowact: delete, copy, move and undo in the browser - the new order is posted when you save.').'<br>'.
                          lang('@button (label @Delete, @Hide, @Copy, @Rename or @Select): a submit button per row - the server gets e.g. btn_del_&lt;table&gt;_&lt;row&gt;.').'<br>'.
                          lang('@Other suffix types show field 6 as HTML. Suffix columns are shown only with modi:true.'), attr:'white-space: normal;');
        // EXAMPLE: acts
        $tasks= [['31', 'Write the offer',   'Anna'],
                 ['32', 'Order materials',   'Bo'],
                 ['33', 'Book the delivery', 'Carl']];
        htm_Table(
            pref: [['@Pick', '6%', '', '', ['center'], '@Prefix: the same HTML in every row (name="x" becomes name="i&lt;row&gt;_x")',
                    '<input type="checkbox" name="pick" value="1" style="box-shadow:none;">']],
            body: [['@Id',   '0%',  'hidd', '', ['left'], 'id'],
                   ['@Task', '46%', 'text', '', ['left'], 'task', '@The task'],
                   ['@Who',  '20%', 'text', '', ['left'], 'who',  '@Who does it']],
            suff: [['@Rows',   '16%', 'rowact', '', ['center'], '@Delete, copy, move and undo in the browser', 'del copy move undo'],
                   ['@Delete', '6%',  'button', '', ['center'], '@A submit button: the server deletes the row',
                    '<ic class="fas fa-trash-alt" style="color:#c62828;"></ic>'],
                   ['@Info',   '6%',  'text',   '', ['center'], '@Any HTML', '<ic class="fas fa-info-circle" style="color:#1565c0;"></ic>']],
            data: $tasks, crea: '@New task', filt: false, vhgh: '160px');
        // END
        htm_CodeBox(code: tblExample('acts'));
    htm_Card_end(labl:'@Save', subm:true, foot:'@Save posts the rows in their new order');

## 5. Above and below the table
    htm_Card_(capt:'@Above and below the table (capt, note)', icon:'fas fa-heading', form:'tblCapt', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        // EXAMPLE: capt
        $orders= [['1001', 'Anna', '1250'], ['1002', 'Bo', '980']];
        htm_Table(
            capt: [['<b>'.lang('@Orders').'</b>', '',    'show'],
                   ['@Count:',                   '',    'rows', '', '', '', '@orders'],
                   ['@Customer:',                '25%', 'data', 'cust_filter', 'left', '@A field with a name - it is posted', '@Name...', ''],
                   ['@Info:',                    '',    'html', '', '', '', '', '<small>'.lang('@HTML from field 7').'</small>']],
            body: [['@Order', '30%', 'show', '',   ['center'], 'ord'],
                   ['@Name',  '40%', 'text', '',   ['left'],   'name'],
                   ['@Total', '30%', 'show', '2d', ['right'],  'total']],
            note: '<small>'.lang('@note: HTML below the table').'</small>',
            data: $orders, crea: false, filt: false, vhgh: '130px');
        // END
        htm_CodeBox(code: tblExample('capt'));
        htm_TextDiv(body:'@capt types: show (only the text), rows (the number of rows), html (field 7 as HTML), data (a field with the name in field 3 - posted), '.
                         'text / number / date ... (a field without a name - not posted). The fields above are shown only when the table has data.', attr:'white-space: normal;');
    htm_Card_end(labl:'@Save', subm:true);

## 6. Data
    htm_Card_(capt:'@The data: lists or rows with field names', icon:'fas fa-database', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        htm_TextDiv(body:'@A row can be a list (the values in the order of body) or have field names (e.g. a database row) - then the values are placed by the field names, in any order.', attr:'white-space: normal;');
        // EXAMPLE: data
        $asList=  [['1', 'Anna', 'Copenhagen'],                              # In the order of body
                   ['2', 'Bo',   'Aarhus']];
        $asNames= [['city' => 'Copenhagen', 'id' => '1', 'name' => 'Anna'],  # With field names (any order)
                   ['name' => 'Bo', 'city' => 'Aarhus', 'id' => '2']];
        $cols= [['@Id', '20%', 'show', '', ['center'], 'id'], ['@Name', '40%', 'text', '', ['left'], 'name'], ['@City', '40%', 'text', '', ['left'], 'city']];
        htm_Table(body: $cols, data: $asList,  crea: false, filt: false, vhgh: '125px');
        htm_Table(body: $cols, data: $asNames, crea: false, filt: false, vhgh: '125px');
        // END
        htm_CodeBox(code: tblExample('data'));
    htm_Card_end();

## 7. Export to CSV
    htm_Card_(capt:'@Export to CSV (expo)', icon:'fas fa-file-csv', clas:'cardW800', styl:'background-color: white;', vhgh:'none');
        // EXAMPLE: expo
        $vat= [['1', lang('@Input VAT'),  '66200', '25,00'],
               ['2', lang('@Output VAT'), '66201', '25,00'],
               ['3', '=SUM(A1:A9)',       '66202', '-12,50']];               # A formula is written with a leading apostrophe
        htm_Table(body: [['@No.',         '10%', 'show', '', ['center'], 'vat_no'],
                         ['@Description', '50%', 'text', '', ['left'],   'vat_desc'],
                         ['@Account',     '20%', 'text', '', ['center'], 'vat_acc'],
                         ['@%-rate',      '20%', 'text', '', ['right'],  'vat_rate']],
                  data: $vat, crea: false, filt: false, vhgh: '160px', expo: 'tableexport.csv');
        // END
        htm_CodeBox(code: tblExample('expo'));
        htm_LinkButt(labl:'@Download the table as CSV (expo:)', hint:'@Text starting with = + - @ is written with a leading apostrophe, so Excel does not run it as a formula', link:'tableexport.csv', targ:'_blank');
    htm_Card_end();

## 8. All parameters
    htm_Card_(capt:'@All parameters of htm_Table()', icon:'fas fa-list', clas:'cardW960', styl:'background-color: white;', vhgh:'none');
        htm_TextDiv(body:'@Read from the library itself: the name, the default value and the description.', attr:'white-space: normal;');
        $params= tblParams();
        htm_Table(body: [['@Parameter',   '12%', 'html', '', ['left'], 'p'],
                         ['@Default',     '14%', 'html', '', ['left'], 'd'],
                         ['@Type',        '8%',  'html', '', ['left'], 't'],
                         ['@Description', '66%', 'html', '', ['left'], 'x']],
                  data: $params, crea: false, modi: false, filt: false, sort: false, vhgh: '700px');
        htm_TextDiv(body: lang('@htm_Table() uses Mottie Tablesorter (sticky header, sort, filter, zebra).').
                          ' <a href="https://mottie.github.io/tablesorter/docs/" target="_blank" rel="noopener">mottie.github.io/tablesorter</a><br>'.
                          lang('@Without jQuery: htm_TableTools() gives search and sort for any table.'), attr:'white-space: normal;');
    htm_Card_end();

    echo '</div>';
htm_Page_end();
?>
