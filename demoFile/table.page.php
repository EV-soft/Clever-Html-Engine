<?php   $DocFil= './Proj1/demoFile/table.page.php';    $DocVer='5.0.0';    $DocRev='2021-01-25';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');

$tblData= array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
                 [['2'],['@Input VAT'],['66201'],['25,00'],[''] ], 
                 [['3'],['@Input VAT'],['66202'],['25,00'],[''] ] );
                 
htm_PagePrep($pageTitl='table.page.php', $ØPageImage=$ØProgRoot.'_assets/images/_background.png');
    Menu_Topdropdown(true); htm_nl(1);
    echo '<div style="text-align: center;">';
    htm_PanlHead($frmName='head', $capt='htm_Table():', $parms='', $icon='fas fa-table', $class='panelW800', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    htm_Table(
        $TblCapt= array( # ['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:horAlgn',      '5:Tip',    '6:Content'],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
          ['<b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on India','@PURCHASE'],
          ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
        ),
        $RowPref= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
    //      ['@Pref',       '4%','butt','',['center'],'@Row prefix', '<ic class="fas fa-check" style="color:green; font-size:13px; "></ic>'],
            ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => butt
        $RowBody= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',          '5%','text','',['center'],'@Position number in the group','.No.'],
          ['@Description', '20%','data','',['left'  ],'@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',      '6%','data','',['center'],'@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',       '6%','data','',['center'],'@VAT % rate','25 %...'],
          ['@Note',        '30%','text','',['left'  ],'@Note about the record','.?.'],
        ),
        $RowSuff= array( # ['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','butt','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),            # Felt 4: ($fieldModes), er sammensat af: [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        $TblNote=   '',
            //        '<br><b>Notes about htm_Table:</b><br>
            //        Records can be sorted, filtered, created, modifyed and more...<br>
            //        The visibly rows can be scrolled in a window below the fixed header.
            //        ' ,
        $tblData,       # = array(),
        $fldNames=              # FieldNames in array returned on submit
        ['f1','f2','f3','f4','f5'],
        $FilterOn= true,        # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
        $SorterOn= true,        # Mulighed for at sortere records efter kolonne indhold
        $CreateRec=true,        # Mulighed for at oprette en record
        $ModifyRec=true,        # Mulighed for at vælge og ændre data i en row
        $ViewHeight= '200px',   # Højden af den synlige del af tabellens data
        $TblStyle= 'background-image: none;',
        $CalledFrom='',         # = __FUNCTION__ (debugging)
        $Criterion= ['','']     # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
    );
    htm_PanlFoot( $labl='Save', $subm=true, $title='@Save data in this panel', $btnKind='save', $akey='s', $simu=false, $frmName='');
    
    echo '</div>';
htm_PageFina();
?>