<?php   $DocFile= './Proj.demo/table.page.php';    $DocVer='1.3.0';    $DocRev='2023-05-18';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once($sys.'php2html.lib.php');
require_once($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');

## Activate needed libraries:
//      ConstName:          ix:   LocalPath:                         CDN-path:                                                              // File:
define('LIB_JQUERY',        [2, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);               // jquery.min.js
define('LIB_JQUERYUI',      [2, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);            // jquery-ui.min.js
define('LIB_TABLESORTER',   [2, '_assets/tablesorter/latest/',      'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/']);
define('LIB_FONTAWESOME',   [2, '_assets/font-awesome/latest/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


    $arrData= array([['1'],['@Input VAT'],['66200'],['25,00'],['']], 
                    [['2'],['@Input VAT'],['66201'],['25,00'],[''] ], 
                    [['3'],['@Input VAT'],['66202'],['25,00'],[''] ] );
                 
    htm_Page_0(titl:'table.page.php', hint:$©, info:'File: '.$DocFile.' - ver:'.$DocVer, inis:'', algn:'center', imag:'../_accessories/_background.png',pbrd:false);
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center;">';
    htm_Card_0(capt: 'htm_Table():', icon:'fas fa-table', hint:'', form:'head', acti:'', clas:'cardW800', wdth:'', styl:'background-color: white;', attr:'');
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
        ),            # Felt 4: ($fieldModes), er sammensat af: [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        note: '',          # '<br><b>Notes about htm_Table:</b><br>
        data: $arrData,    # : array(),
        filt: true,        # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
        sort: true,        # Mulighed for at sortere records efter kolonne indhold
        crea: true,        # Mulighed for at oprette en record
        modi: true,        # Mulighed for at vælge og ændre data i en row
        vhgh: '200px',     # Højden af den synlige del af tabellens data
        styl: 'background-image: none;',
        from:  __FILE__,   # = __FUNCTION__ (debugging)
        list: ['',''],     # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
        expo: ''           # string: Export values in table fields (only body-cols) to CSV-file
    );
     htm_Card_00(labl:'Save', icon:'', hint:'@Save data in this card', name:'', form:'', subm:true, attr:'', akey:'s', kind:'save', simu:false);
    echo '</div>';
htm_Page_00();
?>