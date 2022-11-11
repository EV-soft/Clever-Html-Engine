<?php   $DocFile='../Proj.demo/Demo.page.php';    $DocVer='1.2.1';    $DocRev='2022-11-05';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
// require_once ($sys.'filedata.inc.php');
 
## Handle libraryes to speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                        CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',                  'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',          'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);  // Not in use           
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);  // Not in use       
// define('LIB_FONTAWESOME',   [2, '_assets/font-awesome5/5.15.4/',    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/']);
define('LIB_FONTAWESOME',   [2, '_assets/font-awesome6/6.1.1/',     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/']);
// Set ix= 0:deactive  1:Local-source  2:WEB-source-CDN


$tblData=               # = array(),
        array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
               [['2'],[''],[''],[''],[''] ], 
               [['3'],[''],[''],[''],[''] ], 
               [['4'],[''],[''],[''],[''] ], 
               [['5'],[''],[''],[''],[''] ], 
               [['6'],[''],[''],[''],[''] ], 
               [['7'],[''],[''],[''],[''] ] );

htm_Page_0( $titl='DEMO', $hint=$©, $info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag= $bodybg,$gbl_Bord=true);
    echo '<div style="text-align: center;"><br><b>Clever-Html-Engine</b> / php2html-Demo:';  htm_nl(2);

### Program mainmenu:
  if (($vismenu=true) and (($loggetind ?? '') == true) or true)
    { Menu_Topdropdown(true); htm_nl(1); }

    
## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';}; # Init with value 12345
    
    if (isset($_POST['name']))  { $namex = $_POST['name']; } // Special case !

    $date= date("Y-m-d"); 
    htm_Panel_0($capt= 'The variants of htm_Input():',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelW720',$wdth= '640px',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);
    if (USEGRID) echo '<div class="grid-container tableStyle" style="width: 700px; margin:auto;">';
    htm_nl();
    htm_Input($labl='@htm_Input(Text)',$plho='',$icon='',$hint='@Demo of htm_Input Field type text',                                        $type='text',$name='text',$valu=$text,$form='', $wdth='160px');
    htm_Input($labl='@htm_Input(Date)',$plho='',$icon='',$hint='@Demo of htm_Input Field type date with browser popup selector',            $type='date',$name='date',$valu=$date,$form='', $wdth='160px');
    htm_Input($labl='@htm_Input(Intg)',$plho='',$icon='',$hint='@Demo of htm_Input Field type intg: centered integer',                      $type='intg',$name='intg',$valu=$intg,$form='', $wdth='160px',$algn='center');
                              
    htm_Input($labl='@htm_Input(Dec0)',$plho='',$icon='',$hint='@Demo of htm_Input Field type dec0: centered number with 0 decimals',       $type='dec0',$name='dec0',$valu=$dec0,$form='', $wdth='160px',$algn='center',$attr='',$rtrn=false,$unit=' %');
    htm_Input($labl='@htm_Input(Dec1)',$plho='',$icon='',$hint='@Demo of htm_Input Field type dec1: number with 1 decimal ',                $type='dec1',$name='dec1',$valu=$dec1,$form='', $wdth='160px');
    htm_Input($labl='@htm_Input(Dec2)',$plho='',$icon='',$hint='@Demo of htm_Input Field type dec2: number with 2 decimal',                 $type='dec2',$name='dec2',$valu=$dec2,$form='', $wdth='160px',$algn='center',$attr='',$rtrn=false,$unit='<$ ');
    htm_Input($labl='@htm_Input(opti)',$plho='@?...',$icon='',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',  $type='opti',$name='opti',$valu='87654321',$form='', $wdth='160px',$algn='left',$attr='',$rtrn=false,$unit=' %',$disa=false,$rows='3',$step='',$list= [
        ['name1','private','@Details about private'],
        ['name2','proff','@Details about profession'],
        ['name3','private','@Details about private','checked'],
        ['name4','hobby','@Details about hobby'],
        ['name5','private','@Details about private'],
    ]);
    htm_Input($labl='htm_Input(Dec0)',$plho='',$icon='',$hint='Demo of htm_Input Field type dec0: left aligned number with %-suffix',   $type='dec0',$name='dec0a',$valu='87654321',$form='',$wdth='',$algn='left',  $attr='',$rtrn=false,$unit=' %');
    htm_Input($labl='htm_Input(Dec1)',$plho='',$icon='',$hint='Demo of htm_Input Field type dec1: centered number with %-suffix',       $type='dec1',$name='dec1a',$valu='87654321',$form='',$wdth='',$algn='center',$attr='',$rtrn=false,$unit=' %');
    htm_Input($labl='htm_Input(Dec2)',$plho='',$icon='',$hint='Demo of htm_Input Field type dec2: right aligned number with %-suffix',  $type='dec2',$name='dec2a',$valu='87654321',$form='',$wdth='',$algn='right', $attr='',$rtrn=false,$unit=' %');
              
    htm_Input($labl='@htm_Input(num1)',$plho='',$icon='',$hint='@Demo of htm_Input Field type numb: number with 1 decimal',             $type='num1',$name='num1', $valu='87654321',$form='',$wdth='150px;',$algn='center');
    htm_Input(      '@htm_Input(num0)',      '',      '',      '@Demo of htm_Input Field type numb: left-justified number',                   'num0',      'num0',       '87654321',      '',     '150px;');
    htm_nl();
    htm_Input($labl='htm_Input(chck)', $plho='?...',$icon='',$hint='Demo of htm_Input Field type chck: Multi-line formatted chck-text', $type='chck',$name='chck',$valu='',        $form='',$wdth='150px;',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3',$step='',$list= [
        ['name1','@Label1','@Details about label1','checked']
        //['name2','@Label2','@Details about label2','checked']
    ]);
    htm_Input($labl='@htm_Input(mail)',$plho='',$icon='',$hint='@Demo of htm_Input Field type mail with syntax control',                $type='mail',$name='mail',$valu='',         $form='',$wdth='160px;');
    htm_Input($labl='@htm_Input(url)', $plho='https://...',$icon='',$hint='@Demo of htm_Input Field type url with syntax control',      $type='link',$name='link',$valu='',         $form='',$wdth='160px;',  $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
    htm_Input($labl='@htm_Input(pass)',$plho='',$icon='',$hint='@Demo of htm_Input Field type pass with "hidden" output',               $type='pass',$name='pass1',$valu='',        $form='',$wdth='160px;',  $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop='20px;');
    // FIXIT: Not showing pass-field ! ?    
    htm_Input($labl='@htm_Input(barc)',$plho='',$icon='',$hint='@Demo of htm_Input Field type barc: shown with font barcode',           $type='barc',$name='barc',$valu='BARCODE',  $form='',$wdth='160px;',  $algn='center');
    htm_Input($labl='@htm_Input(html)',$plho='',$icon='',$hint='@Demo of htm_Input Field type html: Multi-line formatted html-text',    $type='html',$name='html',$valu='',         $form='',$wdth='140px;',  $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3',$step='',$list=[],$llgn='R',$bord='',$ftop=''); 
    htm_Input($labl='@htm_Input(area)',$plho='',$icon='',$hint='@Demo of htm_Input Field type area: Multi-line text',                   $type='area',$name='area',$valu='',         $form='',$wdth='140px',   $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='6',$step='',$list=[],$llgn='R',$bord='',$ftop='');

    htm_Input($labl='@htm_Input(chck)',$plho='?...',$icon='',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text', $type='chck',$name='chck1',$valu='',$form='',$wdth='120px;',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3',$step='',$list= [
        ['pos1','@private','@Details about private'],
        ['pos2','@proff','@Details about profession'],
        ['pos3','@private','@Details about private'],
        ['pos4','@hobby','@Details about hobby','checked'],
        ['pos5','@private','@Details about private'],
    ]);
    
    htm_Input($labl='@htm_Input(rado)',$plho='?...',$icon='',$hint='@Demo of htm_Input Field type radio',$type='rado',$name='rado1',$valu='', $form='',$wdth='120px;',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='2',$step='',$list= [
        ['post1','private','@private'],
        ['post2','proff','@profession'],
        ['post3','private','@private','checked'],
        ['post4','hobby','@hobby'],
        ['post5','private','@private'],
    ]);
    htm_Input($labl='@htm_Input(rang)',$plho='',    $icon='',$hint='@Demo of htm_Input Field type range: 0..50 ',    $type='rang',$name='rang',$valu='30',$form='',$wdth='',$algn='left',$attr=' min="0" max="50"',$rtrn=false,$unit='',$disa=false,$rows='1',$step='',$list=[],$llgn='R',$bord='',$ftop='33px');
    htm_Input($labl='@htm_Input(chck)',$plho='?...',$icon='',$hint='@Demo of htm_Input Field type checkbox in a row',$type='chck',$name='chcka',$valu='', $form='',$wdth='',$algn='left',$attr='',                 $rtrn=false,$unit='',$disa=false,$rows='1',$step='',$list=[
        ['postc','dark','@Dark (/Light)','checked'],
        ['postd','shiny','@Shiny (/Matt)'],
        ]);
    htm_Input($labl='@htm_Input(rado)',$plho='?...',$icon='',$hint='@Demo of htm_Input Field type radio in a row',$type='rado',$name='rado2',$valu='',$form='', $wdth='',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='',$list= [
        ['posta','happy','@Happy','checked'],
        ['postb','sorry','@Sorry'],
    ]);
    htm_Input($labl='@htm_Input(colr)', $plho='', $icon='',$hint='@Demo of htm_Input Field type color',                                 $type='colr',$name='colr',$valu='#0000ff',$form='',$wdth='100px',$algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='');
    htm_Input($labl='@htm_Input(butt)', $plho='', $icon='',$hint='@Demo of htm_Input Field type butt',                                  $type='butt',$name='butt',$valu='BUTTON', $form='',$wdth='',     $algn='center',$attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='',$list=[],$llgn='R',$bord='',$ftop='-4px');
    htm_Input($labl='<i class=\'fas fa-search\'></i> '.lang('@htm_Input(sear)'),
                                        $plho='?',$icon='',$hint='@Demo of htm_Input Field type search',                                $type='sear',$name='sear',$valu='',       $form='',$wdth='',     $algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='');
    htm_Input($labl='@htm_Input(time)', $plho='', $icon='',$hint='@Demo of htm_Input Field type time<br>NOT supported by all browsers', $type='time',$name='time',$valu='',       $form='',$wdth='',     $algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='');
    htm_Input($labl='@htm_Input(week)', $plho='', $icon='',$hint='@Demo of htm_Input Field type week<br>NOT supported by all browsers', $type='week',$name='week',$valu='',       $form='',$wdth='',     $algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='');
    htm_Input($labl='@htm_Input(mont)', $plho='', $icon='',$hint='@Demo of htm_Input Field type month<br>NOT supported by all browsers',$type='mont',$name='mont',$valu='',       $form='',$wdth='',     $algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='');
    htm_Input($labl='@htm_Input(file)', $plho='', $icon='',$hint='@Demo of htm_Input Field type file',                                  $type='file',$name='file',$valu='',       $form='',$wdth='',     $algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='',$list=[],$llgn='R',$bord='',$ftop='-8px');
    htm_Input($labl='@htm_Input(imag)', $plho='', $icon='',$hint='@Demo of htm_Input Field type image',                                 $type='imag',$name='imag',$valu='',       $form='',$wdth='100px',$algn='left',  $attr='',$rtrn=false,$unit='',$disa=false,$rows='1',$step='',$list=[],$llgn='R',$bord='',$ftop= '9px');
    if (USEGRID) echo '</div>'; // grid-container}
    htm_Panel_00();

    htm_Panel_0($capt= '@Example of htm_Table():',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'panelW960',$wdth= '640px',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);           
    htm_Table(
        $TblCapt= array( # ['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:horAlgn',      '5:Tip',    '6:Content'],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
          ['<b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on Inland','@PURCHASE'],
          ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
        ),
        $RowPref= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
    //      ['@Pref',         '4%','butt','',['center'],'@Row prefix', '<ic class="fas fa-check" style="color:green; font-size:13px; "></ic>'],
            ),           // if (($ModifyRec) or ($RowBody[0][2]!='indx')) er 2% ColWidth benyttet til => butt
        $RowBody= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',          '5%','text','',['center'], 'f1', '@Position number in the group','.No.'],
          ['@Description', '20%','data','',['left'  ], 'f2', '@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',      '6%','data','',['center'], 'f3', '@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',       '6%','data','',['center'], 'f4', '@VAT % rate','25 %...'],
          ['@Note',        '30%','text','',['left'  ], 'f5', '@Note about the record','.?.'],
        ),
        $RowSuff= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','butt','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),            # Felt 4: ($fieldModes), er sammensat af: [horAlgn, FeltBgColor, FeltStyle, SorterON, FilterON, SelectON, ]
        $TblNote=   '<br><b>Notes about htm_Table():</b><br>
                    Records can be sorted, filtered, created, modifyed and more...<br>
                    The visibly rows can be scrolled in a window below the fixed header.
                    ',
        $tblData,               # = array(),
       /*  array( [['1'],['@Input VAT'],['66200'],['25,00'],['']], 
               [['2'],[''],[''],[''],[''] ], 
               [['3'],[''],[''],[''],[''] ] ), */
        $FilterOn= true,        # Mulighed for at skjule records som ikke matcher filter   //  Virker ikke med hidd-felter!
        $SorterOn= true,        # Mulighed for at sortere records efter kolonne indhold
        $CreateRec=false,        # Mulighed for at oprette en record
        $ModifyRec=true,        # Mulighed for at vælge og ændre data i en row
        $ViewHeight= '200px',   # Højden af den synlige del af tabellens data
        $TblStyle= 'background-color: lightyellow;',
        $CalledFrom='',         // = __FUNCTION__
        $Criterion= ['','']     # Test [DataKolonneNr, > grænseværdi] Undlad spec. feltColor
    );

        htm_Panel_0($capt= '@PHP Source-code:',$icon= 'fas fa-code',$hint= '@View part of the demo source-code. !',$form= '',$acti= '',$clas= 'panelW960',$wdth= '640px',$styl= 'background-color: lightgray;',$attr= 'margin:0;');
        $strCode=
<<< 'STRING'
<?
    htm_Table(
        $TblCapt= array( 
          ['<b>'.lang('@Inland').'</b>', '8%','show','left', '', '@VAT on Inland','@PURCHASE'],
          ['@VAT (incoming): ', '34%','show','left', '', '','@The VAT you must return from the Tax Agency']
        ),
        $RowPref= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
        ),
        $RowBody= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horAlgn_mv]', '5:ColTip', '6:placeholder','7:default','8:select'], ['Næste record'],... # Generel struktur! 
          ['@No.',          '5%','text','',['center'], 'f1', '@Position number in the group','.No.'],
          ['@Description', '20%','data','',['left'  ], 'f2', '@Item Description. A descriptive text of your choice','@Enter text...'],
          ['@Account',      '6%','data','',['center'], 'f3', '@The number in the statement of account to which the sales tax must be posted.','Account...'],
          ['@%-rate',       '6%','data','',['center'], 'f4', '@VAT % rate','25 %...'],
          ['@Note',        '30%','text','',['left'  ], 'f5', '@Note about the record','.?.'],
        ),
        $RowSuff= array( # {'0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horAlgn_mv]', '5:ColTip', '6:value!     '                       ], ['Næste record'],... # Generel struktur! 
          ['@Delete',       '4%','butt','',['center'],'@Click the red cross to delete a entry', '<ic class="far fa-times-circle" style="color:red; font-size:13px; "></ic>'],
        ),
        $TblNote=  '<br><b>Notes about htm_Table():</b><br>
                    Records can be sorted, filtered, created, modifyed and more...<br>
                    The visibly rows can be scrolled in a window below the fixed header.',
        $tblData,               # Data to be shown in the table
        $FilterOn= true,
        $SorterOn= true,
        $CreateRec=false,
        $ModifyRec=true,
        $ViewHeight= '200px',
        $TblStyle= 'background-color: lightyellow;',
        $CalledFrom='',
        $Criterion= ['','']
    ); // Uncomplete Code !

## Example creating a panel in PHP8-syntax: 
    htm_Panel_0(capt: '@PHP Source-code:',icon: 'fas fa-code',
                hint: '@View part of the demo source-code. !',
                clas: 'panelW960',styl: 'background-color: #121212;');
?>

STRING
;

        htm_CodeDiv(highlight_words(highlight_string(/* '<? '. */$strCode,true)));
        htm_Panel_00();

    htm_nl(2);
    echo 'Examples of Container-type elements:';  htm_nl(2);
    htm_Panel_0($capt= '@Containers',$icon= 'fas fa-database',$hint= '',$form= 'head',$acti= '',$clas= 'panelW560',$wdth= '640px',$styl= 'background-color: #f8f8f8;',$attr= '', $show=false, $head= $headbg);    
        htm_TextDiv($content= 'The system includes the following functions of container-type:.<br>
              htm_Page_0()<br>
              htm_Panel_0()<br>
              htm_Fieldset_0()<br>
              '.// htm_Row_0()<br>
              'htm_wrapp_0()<br><br>
              An example of htm_Page_0() is this actual page.<br>
              On this page you also see examples on multiple panels<br>
              Tables... (also a container-type)
              ');
        htm_nl(1);
        
        htm_Fieldset_0($caption='@Caption: ',$hint='@You can use hints',$icon='',$wdth='180px',$margin='',$attr='background-color:lightyellow',$rtrn=false);
        echo 'You place your html-objects here inside fieldset-frames...<br>';
        htm_Fieldset_00($rtrn=false);
        
        htm_Fieldset_0($caption='@Caption: ',$hint='@You can use hints',$icon='',$wdth='180px',$margin='',$attr='background-color:MintCream',$rtrn=false);
        echo 'You place your html-objects here inside fieldset-frames...<br>';
        htm_Fieldset_00($rtrn=false);

    htm_Panel_0($capt= '@PHP Source-code:',$icon= 'fas fa-code',$hint= '@HINT for this panel',$form= '',$acti= '',$clas= 'panelW480',$wdth= '640px',$styl= 'background-color: lightgray;',$attr= 'margin:0;');


$strCode= 
<<< 'STRING'
<? // PHP7-syntax:
htm_Fieldset_0($capt='@Caption: ',
               $hint='@You can use hints',$icon='',
               $wdth='180px',$marg='',
               $attr='background-color:MintCream',
               $rtrn=false); 
               // htm_Fieldset_0() must be followed by htm_Fieldset_00() !
               
STRING
;
echo 'echo \'You place your html-objects here inside fieldset-frames...\';';

        htm_CodeDiv(highlight_words(highlight_string(/* '<? '. */$strCode,true)));
    htm_Panel_00();
    
        htm_nl(2);
        // htm_Field_0_00(# $labl='',$body='',$icon='',$hint='',$name='fld',$wdth='',$styl='',$attr='',$llgn='C',$rtrn=false,$ftop='')
        htm_Field_0_00($labl='Label with hint',$body='HTML-Content <br>in container htm_Field_0_00() <br>---
        ',$icon='',$hint='Tip for htm_Field_0_00()<br>
        htm_Field_0_00($labl=\'Label with hint\',$hint=\'HINT for htm_Field_0_00()\',$icon=\'\',$name=\'fld\',$html=\'HTML-Content <br>in container htm_Field_0_00() <br>---\',$width=\'\',$margin=\'\',$ftop=\'\',$attr=\'\',$rtrn=false);',
        /* $icon='',$name='fld',
        /* $html='HTML-Content <br>in container htm_Field_0_00() <br>---
        ', */
        $name='fld',$wdth='',$styl='',$attr='',$llgn='C',$rtrn=false,$ftop='');
        // echo 'CONTENT';

    htm_Panel_0($capt= '@PHP Source-code:',$icon= 'fas fa-code',$hint= '',$form= '',$acti= '',$clas= 'panelW560',$wdth= '640px',$styl= 'background-color: lightgray;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );           

$strCode= 
<<< 'STRING'
<? // PHP7-syntax:
htm_Field_0_00($labl='Label with hint',
               $hint='Tip for htm_Field_0_00()',
               $icon='',$name='fld',
               $html='HTML-Content <br>in container htm_Field_0_00() <br>---',
               $wdth='',
               $marg='',$ftop='',$attr='',
               $rtrn=false);
               
STRING
; 

        htm_CodeDiv(highlight_words(highlight_string(/* '<? '. */$strCode,true)));
    htm_Panel_00();
        
        
        
        htm_wrapp_0($ViewHeight='60px');
        echo 'You place your html-objects here inside Wrapper-window...<br><br>
        A Wrapper-window is a window with a fixed height<br>
        in with you can scroll the content<br>
        if it owerflow the window-height<br>
        <br>
        ';
        htm_wrapp_00();
        htm_nl(1);

    htm_Panel_0($capt= '@PHP Source-code:',$icon= 'fas fa-code',$hint= '',$form= '',$acti= '',$clas= 'panelW560',$wdth= '640px',$styl= 'background-color: lightgray;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );           


$strCode= 
<<< 'STRING'
<? // PHP7-syntax:
htm_wrapp_0($ViewHeight='60px'); // htm_wrapp_0() must be followed by htm_wrapp_00() !
    echo 'You place your html-objects here inside Wrapper-window...<br><br>
          A Wrapper-window is a window with a fixed height<br>
          in with you can scroll the content<br>
          if it owerflow the window-heigh';
htm_wrapp_00();
    
STRING
; 

        htm_CodeDiv(/* highlight_words */(highlight_string(/* '<? '. */$strCode,true)));
    htm_Panel_00();

        htm_nl(2);
    htm_Panel_00( $labl='Demo', $subm=false, $Hint='Buttom', $btnKind='goon', $akey='', $simu=false, $frmName='');
        htm_nl(2);
    echo 'Examples of foldable panel-system:';  htm_nl(2);
    htm_Panel_0($capt= '@htm_Panel_0(W= 560px) (click to close/open)',$icon= 'fas fa-database',$hint= '',$form= 'head2',$acti= '',$clas= 'panelW560',$wdth= '640px',$styl= 'background-color: lightcyan;',$attr= '', $show = true, $head= $headbg, $show = true, $head= $headbg /* ,$where='Undefined',$BookMark='' */ );           
        htm_nl(2);
        htm_TextDiv($content= 'Panels are used to display a collection of fields.<br>
              They are defined i 14 widths from 160 px to 1200 px and width 100%.<br><br>
              The panel content can be displayed/hidden by clicking panel-header text.');
        htm_nl(1);
        htm_Input($labl='@htm_Input(pass)',$plho='',           $icon='',$hint='Demo of htm_Input Field type password with "hidden" output',        $type='pass',$name='pass2',$valu='',$form='',$wdth='45%',            $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3');
        htm_Input($labl='@htm_Input(mail)',$plho='xxx@yyy.zzz',$icon='',$hint='Demo of htm_Input Field type mail with syntax control',             $type='mail',$name='mail1',$valu='',$form='',$wdth='45%; top: -35px',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3');
        htm_nl(2);
        htm_Input($labl='@htm_Input(chck)',$plho='?...',       $icon='',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',$type='chck',$name='chck2',$valu='',$form='',$wdth='300px',          $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3',$step='',$list= [
            ['name1','Label1','@Details about label','checked'],
            ['name1','Label2','@Details about label','checked']
        ]);
        htm_nl(2);
    htm_Panel_00( $labl='Demo', $subm=false, $Hint='Buttom', $btnKind='goon', $akey='', $simu=false, $frmName='');
    
    $GridOn= false;
    htm_nl(2);
    $ic= ''; // iconStack($cl1='fa-stack fa-2x',$cl2='fa-solid fa-square fa-stack-2',$cl3='fab fa-twitter fa-stack-1x fa-inverse',$rtrn=false)
    htm_Panel_0($capt= '@Signup: <small>(Example)</small>',$icon= 'fas fa-user-check',$hint= '',$form= 'head1',$acti= '',$clas= 'panelW240',$wdth= '640px',$styl= 'background-color: lightcyan;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );           
        htm_Input($labl='@Financial Accounting'.$ic,$plho='@Account...', $icon='',$hint='@The name of the accounting for wich you have access',$type='text',$name='text1',$valu=$text1,$form='',$wdth='75%',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3', $step='');
        htm_Input($labl='@Your account',        $plho='@Email...',   $icon='',$hint='@Type your email as your accont',                     $type='mail',$name='mail2',$valu=$mail2,$form='',$wdth='75%',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3', $step='');
        htm_Input($labl='@Your password',       $plho='@Password...',$icon='',$hint='@Type your password for your account',                $type='pass',$name='pass3',$valu=$pass3,$form='',$wdth='70%',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3', $step='',$list=[],$llgn='R',$bord='',$ftop='20px;');
                 // $usr_name= 'user';  $usr_code= 'Code: PW-test';     $h= calcHash($usr_name,$usr_code);
                   # $labl='',$icon='',$hint='',$type='submit',$name='',$link='',$acti='',$font='32px',$fclr='gray',$bclr='white',$akey='',$rtrn=false
        htm_IconButt($labl='@Forgotten password ?',$icon='fas fa-key',$hint='@Click to request a new password',$type='button',$name='lost',$link='',$acti='',$font='18px',$fclr='gray',$bclr='white',$akey='',$rtrn=false);
        htm_nl(0);
                
    htm_Panel_00( $labl='Login', $icon='', $hint='@Login with the given data', $name='butt', $form='head1',$subm=true, $attr='', $akey='l', $kind='navi', $simu=false); 
               // $labl='Login', $subm=true, $Hint='@Login with the given data', $btnKind='navi', $akey='l', $simu=false, $frmName='head1');
    
    htm_nl(2);
    htm_Panel_0($capt= '@Contact info:',$icon= 'fas fa-pen-square',$hint= '',$form= 'head2',$acti= '',$clas= 'panelW480',$wdth= '640',$styl= 'background-color: lightcyan;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );           
        $wdh= '100%';
        $m= ' padding:0; test:99; ';
        $m= '';
        htm_Input($labl='@Name',  $plho='@The name...', $icon='',$hint='',$type='text',$name='name',$valu=$namex ?? '',$form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        htm_Input($labl='@Street',$plho='@Address 1...',$icon='',$hint='',$type='text',$name='stre',$valu=$stre,       $form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        htm_Input($labl='@Place', $plho='@Address 2...',$icon='',$hint='',$type='text',$name='plac',$valu=$plac,       $form='',$wdth='66%', $algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        
        $GridOn= false; // Without grid the following fields can be placed on a single row.
        htm_Input($labl='@ZIP',$plho='@Code...',$icon='',$hint='',$type='opti',$name='zipp',$valu=$zipp,$form='',$wdth='30%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='',$list= [
                    ['5000','5000','5000'],
                    ['6000','6000','6000'],
                    ['6050','6050','6050','checked'],
                    ['6080','6080','6080'],
                    ['7000','7000','7000'],
                    ]);
        htm_Input($labl='@City',     $plho='@Address town...', $icon='',$hint='',                                                   $type='text',$name='city', $valu=$city, $form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');        //if (USEGRID) $GridOn= true;
        htm_Input($labl='@Country',  $plho='@Country...',      $icon='',$hint='',                                                   $type='text',$name='coun', $valu=$coun, $form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        htm_Input($labl='@Remark',   $plho='@Remark?...',      $icon='',$hint='@Demo of htm_Input Field type area: Multi-line text',$type='area',$name='remk', $valu=$remk, $form='',$wdth='100%' ,$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='1',$step='');
        htm_Input($labl='@Phone',    $plho='@Phone number...', $icon='',$hint='',                                                   $type='text',$name='phon', $valu=$phon, $form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        htm_Input($labl='@Reference',$plho='@?...',            $icon='',$hint='',                                                   $type='text',$name='refe', $valu=$refe, $form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        htm_Input($labl='@Email',    $plho='@Email address...',$icon='',$hint='@Demo of htm_Input Field type mail',                 $type='mail',$name='mail3',$valu=$mail3,$form='',$wdth='100%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='');
        
        if (isset($_POST['namechck']))  { $namechck = 'checked'; }
        htm_Input($labl='@Mailing',  $plho='@?...',            $icon='',$hint='@Demo of htm_Input Field type chck',                 $type='chck',$name='chck3',$valu=$chck3,$form='',$wdth='96%',$algn='left',$attr=$m,$rtrn=false,$unit='',$disa=false,$rows='3',$step='',
                  $list= [['namechck','@Mailing active','@Use mail',$namechck ?? '']]);
        
        $GridOn= false;
        htm_nl(1);
        htm_Input($labl='@Created',$plho='',$icon='',$hint='@Demo of htm_Input Field type date with browser popup selector',$type='date',$name='datr',$valu=$date,$form='',$wdth='46%; float: left',$algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3');
        htm_Input($labl='@Changed',$plho='',$icon='',$hint='@Demo of htm_Input Field type date with browser popup selector',$type='date',$name='dath',$valu=$date,$form='',$wdth='46%',             $algn='left',$attr='',$rtrn=false,$unit='',$disa=false,$rows='3');
        //if (USEGRID) $GridOn= true;
        
        htm_nl(0);
    htm_Panel_00( $labl='Save', $subm=true, $capt='@Save data in this panel', $btnKind='save', $akey='s', $simu=false, $frmName='');
    
    echo '</div>'; // DEMO
    
    htm_nl(4);
    htm_Panel_0($capt= '@User rights:',$icon= 'fas fa-pen-square',$hint= '@In this panel, you see a DEMO of the Multi-state button',$form= 'head3',$acti= '',$clas= 'panelW960',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);           

    $task= [['@Chart of Accounts',      'Struktur for regnskabet'],
            ['@Account settings',       'Angående regnskabet'],
            ['@Journal Entry ',         'Daglige posteringer'],
            ['@Financial Accounting',   'Bogførte posteringer'],
            ['@Financial reports',      'Regnskabs posteringer'],
            ['@Debtor orders',          'Kunde ordrer'],
            ['@Debtor accounts',        'Kunde konti'],
            ['@Debtor reports',         'Kunde oversigter'],
            ['@Creditor orders',        'Leverandør ordrer'],
            ['@Creditor accounts',      'Leverandør konti'],
            ['@Creditor reports',       'Leverandør oversigter'],
            ['@Item stock',             'Salgs produkter'],
            ['@Product reception',      'Ankommende produkter'],
            ['@Product reception',      'Produkt oversigter'],
            ['@Production orders',      'Bestillinger'],
            ['@Program setting',        'Setup af program og databaser'],
            ['@Data backup',            'Sikkerheds kopiering af program og databaser'],
            ['@Security',               'Administrer bruger rettigheder']
            ];

    $users = [
        ['adm','Administrator', ['3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3']],
        ['bok','Bookkeeper',    ['3','3','3','3','3','2','1','3','3','3','3','3','3','3','3','3','3','1']],
        ['aud','Auditor',       ['3','3','3','3','3','2','1','3','3','3','3','3','3','3','3','3','3','1']]
    ];

    $w= 0;
    foreach ($task as $t) $w= max($w,strlen($t[0]));
    echo '<span style="text-align:left;">';
    // echo '<style> table, th, td { border: 1px solid lightgray; border-collapse: collapse;} 
    echo '<style> table, th, td { border: none; border-collapse: collapse;} 
        td span { writing-mode: vertical-lr; transform: rotate(180deg); height: '.($w*7.5).'px; }
        </style>';
        
    echo '<table style="margin: auto; font-size: smaller; "><tr style="padding:5px;">
    <td style="vertical-align: bottom;"><i>'.lang('@Name:').'</i></td> 
    <td style="vertical-align: bottom;"><i>'.lang('@Title:').'</i></td>';
    foreach ($task as $t) echo '<td><span style="padding:3px;" title="'.lang($t[1]).'">'.lang($t[0]).'</span></td>';
    echo '</tr>';
    foreach ($users as $usr) { $i= 0;
        echo '<tr style="height: 22px;"><td style="height: 22px;"><a href="">'.$usr[0].'</a></td><td>'.$usr[1].'</td>';
        foreach ($usr[2] as $a)   echo '<td style="height: 22px; width: 22px; text-align: center;">'.htm_MultistateButt($name='ROW'.$i.'COL'.$i++, $valu= $a).'</td>';
        echo '</tr>';
    }
    echo '<tr><td>&nbsp;</td></tr>';
    echo '
    <tr><td colspan="2" ><i>'.lang('@Create New:').'</i></td>';
    for ($i=0; $i<count($task); $i++) echo '<td style="height: 22px; width: 22px; text-align: center;">'. htm_MultistateButt($name='newROWyCOL'.$i, $valu=2) .'</td>';
    echo '<tr>
    <td><input type= "text" name="name1" value="" style="width: 50px; border: 1px solid var(--grayColor);" placeholder="name..." /></td>
    <td><input type= "text" name="titl1" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="titl..." /></td>
    <td colspan="9" ><i><small>Password:</small><input type= "text" name="pass1" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="pass..." /></i></td>
    <td colspan="9" ><i><small>Repeat:</small><input type= "text" name="pass2" value="" style="width: 100px; border: 1px solid var(--grayColor);" placeholder="pass..." /></i></td></tr>';
    echo '<tr><td>&nbsp;</td></tr>';
    echo '<tr style="border: 1px solid lightgray;">
    <td colspan="1"> &nbsp;<small>'.lang('@Meaning').'</small></td>
    <td colspan="2">'.htm_MultistateButt($name='dontCare', $valu=1, '', false).' <small>: '. lang('@No access').'</small></td>
    <td colspan="5">'.htm_MultistateButt($name='dontCare', $valu=2, '', false).' <small>: '. lang('@Read only').'</small></td>
    <td colspan="5">'.htm_MultistateButt($name='dontCare', $valu=3, '', false).' <small>: '. lang('@Full access').'</small></td>
    <td colspan="'.(count($task)-8).'" style="text-align:right;"><small>'.lang('@CLICK symbol to change').'</small>&nbsp;</td></tr>';
    echo '</table>';
    
    echo '</span>';
    htm_AcceptButt(labl:'@Create', icon:'',hint:lang('@Create new user'), form:'head3',  wdth:'100px', attr:'' ,akey:'', kind:'creat', rtrn:false, 
                   tplc:'LblTip_text', tsty:'position: absolute; bottom: 50px;',acti:'toast("Create new user<br>Cant create yet !","orange","black")');
    htm_MiniNote('This is an example using the multi-state button.');
    htm_nl(1);
    
    htm_Panel_00( $labl='Save', $subm=true, $capt='@Save data in this panel', $btnKind='save', $akey='s', $simu=false, $frmName='head3');

/* * /
        htm_ActionButt($label='@LeftClick Me', $id='left_click', $form='', $type='button', $onclick='', $icon='fas fa-mouse colrgreen', $hint='@Try clicking me <br>to test popup-menues', $attr='', $rtrn=false);
        //echo '<smaller class="colrbrown" id="left_click">'. lang('@LeftClick Me'). ': </smaller> - ';
        Pmnu_0($idElem='left_click',$capt='Popup-Menu', $widt='200px', $icon='fas fa-info',$stick='false',$attr='background-color:lightcyan;',$context=false);
        Pmnu_Item($type='plain',$labl='@LABEL 1',$hint='@Hint 1',$icon='fas fa-info',$id='a',$click='',$attr='',$short='A');
        Pmnu_Item($type='plain',$labl='@LABEL 2',$hint='@Hint 2',$icon='fas fa-info',$id='b',$click='',$attr='',$short='B');
        Pmnu_Item($type='separator');
        Pmnu_Item($type='custom',$labl='@CUST A',$hint='@Hint A',$icon='',$id='c',$click='',$attr='');
        Pmnu_00();
/* */

    htm_Panel_0($capt= '@Popup menues:',$icon= 'fas fa-pen-square',$hint= '@HINT for this panel',$form= 'head4',$acti= '',$clas= 'panelW800',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);           
        htm_TextDiv($content= 'You can build popup-menues with the PHP2HTML-system.<br>
              Both left-click and context right-click triggered.<br><br>
              Here you can test it:');
/* */ 
        htm_ActionButt($labl='@LeftClick Me', $icon='fas fa-mouse colrgreen', $hint='@Try clicking me <br>to test popup-menues',$type='button', $name='left_click', $form='', $acti='',  $attr='', $rtrn=false);
        //echo '<smaller class="colrbrown" id="left_click">'. lang('@LeftClick Me'). ': </smaller> - ';
        Pmnu_0($idElem='left_click',$capt='Popup-Menu', $widt='200px', $icon='fas fa-info',$stick='false',$attr='background-color:lightcyan;',$context=false);
        Pmnu_Item($labl='@LABEL 1', $icon='fas fa-info',$hint='@Hint 1',$type='plain',      $name='a',$clck='',$attr='',$short='A');
        Pmnu_Item($labl='@LABEL 2', $icon='fas fa-info',$hint='@Hint 2',$type='plain',      $name='b',$clck='',$attr='',$short='B');
        Pmnu_Item($labl='<hr>',     $icon='',           $hint='',       $type='separator');
        Pmnu_Item($labl='@CUST A',  $icon='',           $hint='@Hint A',$type='custom',     $name='c',$clck='',$attr='');
        Pmnu_00();
/* */ 

        htm_ActionButt($labl='@RightClick Me', $icon='fas fa-mouse colrgreen', $hint='@Try right-clicking me <br>to test context-menu', $type='button', $name='right_click', $form='', $acti='', $attr='', $rtrn=false);
        
        Pmnu_0($idElem='right_click',$capt='Context-Menu', $widt='280px',  $icon='',$stick='true',$attr='background-color:lightyellow; height: 16px;',$context=true);
     // Pmnu_Item($type='plain',$labl='',$hint='',$icon='',$id='',$click='',$attr='',$short='',$enabl='true',$rtrn=false) 
     // Pmnu_Item($labl='',$icon='',$hint='',$type='plain',$name='',$clck='',$attr='',$short='',$enabl='true',$rtrn=false) 
        Pmnu_Item($labl='@Select All',$icon='far fa-object-group colrbrown iconsize', $hint='@Mark to select',                            $type='plain',    $name='d',    $clck='alert(\"sss\");',  $attr='',$short='CTRL+A');
        Pmnu_Item($labl='@Copy',      $icon='fas fa-copy colrgreen iconsize',         $hint='@Copy selected to text-buffer',              $type='plain',    $name='d1',   $clck='alert(\"sss\");',  $attr='',$short='CTRL+C');
        Pmnu_Item($labl='@Paste',     $icon='fas fa-paste colrblue iconsize',         $hint='@Paste content in text-buffer',              $type='plain',    $name='d2',   $clck='alert(\"sss\");',  $attr='',$short='CTRL+V');
        Pmnu_Item($labl='<hr>',       $icon='',                                       $hint='',                                           $type='separator',$name='',     $clck='',                 $attr='');
        Pmnu_Item($labl='@Delete',    $icon='fas fa-trash-alt colrred iconsize',      $hint='@Delete the selected',                       $type='plain',    $name='e',    $clck='',                 $attr='',$short='DEL'.str_sp(6));
        Pmnu_Item($labl='@Cut',       $icon='fas fa-cut colrblue iconsize',           $hint='@Cut the selected and save to text-buffer',  $type='plain',    $name='d3',   $clck='alert(\"sss\");',  $attr='',$short='CTRL+X');
        Pmnu_Item($labl='@Undo',      $icon='fas fa-undo colrblue iconsize',          $hint='@Undo latest task',                          $type='plain',    $name='d5',   $clck='alert(\"sss\");',  $attr='',$short='CTRL+Z');
        Pmnu_Item($labl='@Redo',      $icon='fas fa-redo colrblue iconsize',          $hint='@Redo the last delete',                      $type='plain',    $name='d4',   $clck='alert(\"sss\");',  $attr='',$short='CTRL+Y');
        Pmnu_Item($labl='<hr>',       $icon='',                                       $hint='',                                           $type='separator',$name='',     $clck='',                 $attr='background-color:lightyellow;');
        Pmnu_Item($labl='@Multi Menu',$icon='fas fa-home colrgreen iconsize',         $hint='@Horisontal menu.',                          $type='multi',    $name='e2',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Delete',    $icon='fas fa-trash-alt colrred iconsize',      $hint='@Delete the selected',                       $type='subitem',  $name='e',    $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Cut',       $icon='fas fa-cut colrblue iconsize',           $hint='@Cut the selected and save to text-buffer',  $type='subitem',  $name='d3',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Undo',      $icon='fas fa-undo colrblue iconsize',          $hint='@Undo latest task',                          $type='subitem',  $name='d5',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='',           $icon='',                                       $hint='',                                           $type='end_sub'); // multimenu                  
        Pmnu_Item($labl='<hr>',       $icon='',                                       $hint='',                                           $type='separator',$name='',     $clck='',                 $attr='background-color:lightyellow;');
        Pmnu_Item($labl='@Sub Menu',  $icon='fas fa-home colrgreen iconsize',         $hint='@Open submenu.',                             $type='submenu',  $name='f1',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Sub Item 1',$icon='fas fa-link colrblue iconsize',          $hint='@Open...Sub Item 1',                         $type='subitem',  $name='f2',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Sub Item 2',$icon='fas fa-link colrblue iconsize',          $hint='@Open...Sub Item 2',                         $type='subitem',  $name='f3',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Sub Item 3',$icon='fas fa-link colrblue iconsize',          $hint='@Open...Sub Item 3',                         $type='subitem',  $name='f4',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='',           $icon='',                                       $hint='',                                           $type='end_sub'); // submenu                                           $
        Pmnu_Item($labl='@Hover Menu',$icon='fas fa-bars colrgreen iconsize',         $hint='@Open hovermenu',                            $type='hovermenu',$name='g1',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Sub Item 4',$icon='fas fa-link colrblue iconsize',          $hint='@Open...Sub Item 4',                         $type='subitem',  $name='g2',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Sub Item 5',$icon='fas fa-link colrblue iconsize',          $hint='@Open...Sub Item 5',                         $type='subitem',  $name='g3',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='@Sub Item 6',$icon='fas fa-link colrblue iconsize',          $hint='@Open...Sub Item 6',                         $type='subitem',  $name='g4',   $clck='',                 $attr='',$short='');
        Pmnu_Item($labl='',           $icon='',                                       $hint='',                                           $type='end_sub'); // hovermenu
        Pmnu_Item($labl='<hr>',       $icon='',                                       $hint='',                                           $type='separator',);
        //Pmnu_Item($type='footer',   $labl='@A demo of PopUp menu, witch showup when you right-click an object<br><br>',$hint='',$icon='',$id='f',$click='',$attr='',$short='');
        // Pmnu_Item($type='plain',$labl='@Remove',$hint='@Hint 4',$icon='fas fa-minus colrred',$id='e',$click='',$attr='',$short='CTRL+V');
        Pmnu_00($labl='FOOTER',$hint='The menu footer.',$attr='background-color:lightyellow; padding-top: 8px;');

        htm_nl(2);
    htm_Panel_00( $labl='', $icon='', $hint='', $name='', $form='head4', $subm=false, $attr='', $akey='s', $kind='save', $simu=false);
    /**/
    
    htm_Panel_0($capt= '@Switch buttons: (working on it)',$icon= 'fas fa-pen-square',$hint= '',$form= 'sw',$acti= '',$clas= 'panelW800',$wdth= '640',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );           
//  htm_Panel_0($frmName='sw', $capt='@Switch buttons: (working on it)', $parms='', $icon='fas fa-pen-square', $class='panelW800', $func='Undefined', $attr= '');
    htm_SwitchButt($labl='@Switch conneting',$hint='@Click to toggle setting', $name='switchbox_id1', $valu='presssed', 
                   $list=['@Connect','@disconnect'], $wdth='6em', $bclr='blue', $styl='style="padding:1px;"', 
                   $rtrn=false);
    htm_nl();
    htm_SwitchButton($labl='@Switch accepting',$name='switchbox_id2', $valu='', $wdth='6em', $bclr='green', $styl='style="padding:1px;"', $hint='@Here you can toggle setting', 
                   $list=['@Accept','@Decline'], $rtrn=false);
    htm_nl();
    htm_Panel_00( $labl='', $icon='', $hint='', $name='', $form='sw', $subm=false, $attr='', $akey='s', $kind='save', $simu=false);

    htm_Panel_0($capt= '@Toggleable Tabs:',$icon= 'fas fa-pen-square',$hint= '@HINT for this panel',$form= 'tb',$acti= '',$clas= 'panelW800',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg );           

    $strTabel= 'The function htm_Table() is a advanced module to show and input user data.<br>
            It has fixed (sticky) column headers, and Scrolling content-window.<br>
            Column wise it can: Filter - Sort - Width-Resize<br><br>
            Row wise it can: Create - Change - Delete - Spec. Buttons - set background color<br>
            Above and underneth the table, you can use special captions and notes.<br><br>
            Example: htm_Table(<abbr class= "hint"><data-hint>htm_Table($TblCapt, $RowPref, $RowBody, $RowSuff, $TblNote, &$TblData, $FilterOn, $SorterOn, $CreateRec, $ModifyRec, $ViewHeight, $TblStyle, $CalledFrom, $MultiList)</data-hint>Parameters</abbr>)
        ';
    $strPanels= 'Panels is a container for html-objects.<br>
            It is build with two functions: htm_Panel_0() and htm_Panel_00()<br><br>
            It consists of: icon + header - a body with content - and a footer that can be hidden.<br>
            The header-caption is automatic translated to the current selected language.<br>
            When clicking the caption-text in the header, it will show/hide the body&footer-content.<br>
            In the headers right side there are icons to open/close single or all the panels in the window.<br><br>
            Panels has predefined widths, and its position will swap, if the window-width is to small.<br>
            Panels can be used as a "Local Menu" and to keep overview...<br>
            Example: htm_Panel_0(<abbr class= "hint"><data-hint>htm_Panel_0($frmName=\'orders\', $capt=lang(\'@Find existing order:\'), $parms=\'\', $icon=\'fas fa-search\', $class=\'panelW720\', $where=__FILE__, $attr=\'\', $BookMark=\'blindAlley.page.php\',$panlBg=\'background-color: rgba(240, 240, 240, 0.80);\');</data-hint>Parameters</abbr>) and htm_Panel_00(<abbr class= "hint"><data-hint>htm_Panel_00($labl=\'@Save\', $subm=true, $title=\'\', $btnKind=\'save\', $akey=\'\', $simu=false, $frmName);</data-hint>Parameters</abbr>)
		';
    $strPage= 'To build a page there are 2 functions: <br><br>
            <b>htm_Page_0()</b> - prepares the start of a page, by creating the HEAD content and starting the BODY section.<br>
            <br>and: <br>
            <b>htm_Page_00()</b> - finalize the page, by loading scripts and ending the BODY     <br><br>
            In between, you add your content.             <br><br>
            <small>See the source in php2html.lib.php to manage the function parameters.</small>
        ';
    htm_Tabs_0($head='<small>Here you see the htm_Tabs_0() - Toggleable tabs system:</small>', $styl='text-align:left;', $rtrn=false);
    htm_Tab($labl='HTML Page',$body= $strPage,  $name='HTMLPage', $styl='text-align:left;',    $bclr='white',      $vhgh='200px');
    htm_Tab($labl='Panels',   $body= $strPanels,$name='Panels',   $styl='text-align:left;',    $bclr='lightyellow',$vhgh='200px');
    htm_Tab($labl='Tables',   $body= $strTabel, $name='Tables',   $styl='text-align:left;',    $bclr='lightcyan',  $vhgh='200px');
    htm_Tab($labl='Input',    $body= '',        $name='input',    $styl='text-align:left;',    $bclr='lightgray', );
    htm_Tabs_00($foot='@FOOTER for Toggleable Tabs', $styl='font-size: smaller;', $rtrn=false);
    
                # $labl='', $icon='', $hint='', $name='tb', $form='tb',$subm=false, $attr='', $akey='', $kind='save', $simu=false)
    htm_Panel_00( $labl='', $subm=false, $capt='@...', $btnKind='save', $akey='s', $simu=false, $frmName='tb');

     
    htm_Panel_0($capt= '@Containers:',$icon= 'fas fa-info',$hint= '@HINT for this panel',$form= '',$acti= '',$clas= 'panelW800',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);           
    htm_Fieldset_0($capt='This is af fieldSet container',$icon='',$hint='',$wdth='80%',$marg='',$attr='',$rtrn=false);
    htm_TextDiv('Tabels, Panels and Fieldsets is areas that contains other elements.');
    htm_Fieldset_00();
    htm_Panel_00( $labl='', $subm=false, $capt='@...', $btnKind='save', $akey='s', $simu=false, $frmName='tb');


    htm_Panel_0($capt= '@Navigate functions:',$icon= 'fas fa-info',$hint= '@HINT for this panel',$form= '',$acti= '',$clas= 'panelW800',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);           
    htm_TextDiv('To navigate in your project, you can use the Menu_Topdropdown() shown on top of all demo pages.<br>
                 You can also use various buttons for that...
    ');
    htm_Panel_00( $labl='', $subm=false, $capt='@...', $btnKind='save', $akey='s', $simu=false, $frmName='tb');


    htm_Panel_0($capt= '@About function parameters:',$icon= 'fas fa-info',$hint= '@HINT for this panel',$form= 'head5',$acti= '',$clas= 'panelW800',$wdth= '640',$styl= 'background-color: white;',$attr= '', $show = true, $head= $headbg);

    function b($s) {return '<b>'.$s.'</b>';}
    htm_TextDiv('
        A new way to give parameters to functions in PHP 8+ is: <br><b>Named arguments</b><br>
        <small style="paddign-left:100px;">
        &nbsp; --> Specify only required parameters, skipping optional ones. (free order!)
        &nbsp; --> Arguments are order-independent and self-documented.<br><br>
        </small>
        That means a simpler way to call functions.<br><br>
        Example PHP 7: (fixed order!)<br><code><div style="background-color:whitesmoke">
        htm_Input($labl=\'@htm_Input(Dec2)\', $plho=\'\', $hint=\'@Demo of htm_Input Field type dec2: number with 2 decimal\', ,<br>
         $type=\'dec2\', $name=\'dec2\', $valu=$dec2, $wdth=\'\', $algn=\'center\', $unit=\'<$ \');</div></code><br><br>
        Example PHP 8: (free order!)<br><code><div style="background-color:whitesmoke">
        htm_Input('.b('labl').':\'@htm_Input(Dec2)\', '.b('type').':\'dec2\','.b('name').':\'dec2\','.b('valu').':$dec2,'.b('unit').':\'<$ \','.
        b('hint').':\'@Demo of htm_Input Field type dec2: number with 2 decimal\');</div></code><br>
        <br>
        Be aware of PHP 7.4 is a supported version until 2023/24 ! 
        ');
    htm_Panel_00( $labl='', $subm=false, $capt='@...', $btnKind='save', $akey='s', $simu=false, $frmName='head4');
    
    PanelOff($First=3,$Last=6);
    
    // echo 'A look at the translate system:';  scannLngStrings();
htm_Page_00();
    run_Script('toast("<b>'. lang('@You`re looking at a DEMO !'). '</b><br>'. lang('@It is a demonstration of the php2html-output.'). '","green","white")');
// phpinfo();
// var_dump(opcache_get_status()['jit']);
getState();
?>