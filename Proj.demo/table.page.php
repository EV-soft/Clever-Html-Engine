<?php $DocFile= './Proj.demo/table.page.php';    $DocVer='1.4.0';    $DocRev='2024-06-01';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE'; 

$sys= $GLOBALS["gbl_ProgRoot"]= '../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once($sys.'php2html.lib.php');

    $arrData= array([['1'],['@Input VAT'],['66200'],['25,00'],['']], 
                    [['2'],['@Input VAT'],['66201'],['25,00'],[''] ], 
                    [['3'],['@Input VAT'],['66202'],['25,00'],[''] ] );
                 
    htm_Page_(titl:'table.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'', algn:'center', imag:'../_accessories/_background.png',pbrd:false);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    echo '<div style="text-align: center;">';
    htm_Card_(capt: 'htm_Table():', icon:'fas fa-table', hint:'', form:'head', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;'/* , attr:'' */);
    htm_Table(
        capt: array( # ['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:horAlgn',      '5:Tip',    '6:Content'],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
          ['<b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on India','@PURCHASE'],
          ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
        ),
        pref: array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
    //      ['@Pref',       '4%','butt','',['center'],'@Row prefix', '<ic class="fas fa-check" style="color:green; font-size:13px; "></ic>'],
            ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => butt
        body: array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',         '10%','text','',['center'],'@Position number in the group','.No.'],
          ['@Description', '26%','data','',['left'  ],'@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',     '10%','data','',['center'],'@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',      '10%','data','',['center'],'@VAT % rate','25 %...'],
          ['@Note',        '40%','text','',['left'  ],'@Note about the record','.?.'],
        ),
        suff: array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','butt','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),            # Felt 4: ($fieldModes): [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        note: '',       
        data: $arrData, 
        filt: true,     
        sort: true,     
        crea: true,     
        modi: true,     
        vhgh: '200px',  
        styl: 'background-image: none;',
        from:  __FILE__,
        list: ['',''],  
        expo: '',
        rtrn: false
    );
    htm_Card_end(labl:'Save', icon:'', hint:'@Save data in this card', name:'', form:'', subm:true, attr:'', akey:'s', kind:'save', simu:false);
   
    htm_Card_(capt: 'Destription of htm_Table():', icon:'fas fa-info', hint:'', form:'head', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'');
        htm_TextDiv('
The htm_Table() has the following features:<br>
It has fixed (sticky) column headers, and Scrolling content-window.<br>
Column wise it can: Filter - Sort - Width-Resize<br>
Row wise it can: Create - Change - Delete - Add Spec. Buttons - set background color<br>
Above and underneth the table, you can use special captions and notes.<br>
The row background color for odd / even linenumber is varying to help reading.<br>
<br>
htm_Table() is based on Mottie tablesorter<br>
Read more here: <a title="More about the system..." href="https://mottie.github.io/tablesorter/docs/" target="_blank" rel="noopener">Plugin for turning a standard HTML table with THEAD and TBODY tags into a sortable table</a><br>
<br>
        ');
    htm_Card_end();
    echo '</div>';
    htm_Page_end();
?>