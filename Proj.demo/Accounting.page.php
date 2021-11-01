<?php   $DocFil= './Proj1/demoFile/Accounting.page.php';    $DocVer='1.0.0';    $DocRev='2020-08-17';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
require_once ('../filedata.inc.php');


### SPECIAL this page only:

function DeciList () {return ([
    ['d2',  '@1.00',    '@Vis beløb med 2 decimaler'],
    ['01',  '@1/1',     '@Vis beløb med hele kroner'],
    ['02',  '@1/100',   '@Vis beløb med hele hundreder'],
    ['03',  '@1/1000',  '@Vis beløb med hele tusender']
    ]); }

function periodLabels($number, $year, $month, $day=1, $unit="month", $acountYear="",$format='2d',$colw='4%',$felt='text') {
    ## $unit can be day, week, month, accounting month, or quarter (or just the first letter)
    setlocale(LC_TIME, "da_DK","da","da_DK.utf8");
    $arrResult= [];    $step = 1;
    $unit = strtolower(substr($unit, 0, 1));
    if ( $unit == substr("week",    0, 1) ) $step = 7;
    if ( $unit == substr("quarter", 0, 1) ) $step = 3;
    if ( $unit == substr("month",   0, 1) ) $step = 1;
    $number = $step * $number;
    for ($z=0; $z<$number; $z=$z+$step) {
        switch ($unit) {
            case 'd' : { // day
                $stamp = mktime(12, 0, 0, $month, $day+$z, $year);
                $shortStamp = ucfirst(mb_substr(strftime("%a", $stamp),0,2))."&nbsp;".date("j/n",$stamp);
                $longStamp =  ucfirst(strftime("%A %e. %B %Y",$stamp));             }; break;
            case 'w' : { // week
                $stamp = mktime(12, 0, 0, $month, $day+$z, $year);
                $weekday = strftime("%u", $stamp);
                $start = mktime(12, 0, 0, $month, $day+$z+1-$weekday, $year);
                $end = mktime(12, 0, 0, $month, $day+$z+7-$weekday, $year);
                $shortStamp = strftime("w%V'%g",$stamp);
                $longStamp = strftime(lang('@Week')." %V ".lang('@this year')." %G",$stamp);
                $longStamp .= " (".date("d/m",$start)." - ".date("d/m",$end).")";   }; break;
            case 'q' : { // quarter
                $end = mktime(12, 0, 0, $month+$z+3, 0, $year);
                $quarter = floor((date("m",$stamp)-1)/3)+1;
                $shortStamp = $quarter.". ".substr(lang('@quarter'),0,2). strftime("%y",$stamp);
                $longStamp = $quarter.". ".lang('@quarter')." ". strftime("%Y",$stamp);
                $longStamp .= " (".date("d/m",$stamp)." - ".date("d/m",$end).")";   }; break;
            default : { // month / accounting month / other
                $stamp= mktime(12, 0, 0, $month+$z+1, $day, $year);
                switch ($unit) {
                    case 'm' : { // month
                        $shortStamp = ucfirst(strftime("%b'%y",$stamp));
                        $longStamp =  ucfirst(strftime("%B %Y",$stamp));};  break;
                    case 'a' : { // accounting month",
                        $shortStamp = ucfirst(strftime("%b'%y",$stamp));
                        $longStamp =  ucfirst(strftime("%B %Y",$stamp));
                        $longStamp .= " (".($z+1).". ".lang('@accounting month in financial year');
                        if ( $acountYear ) $longStamp .= " ". $acountYear;
                        $longStamp .= ")"; };                               break;
                    default : {
                        $shortStamp = ($z+1).".";
                        $longStamp = ($z+1).". ".lang('@period');
                    }
                }
            }; 
        }
        array_push($arrResult, ['@'.$shortStamp, $colw, $felt, $outFormat, ['right','','font-style:italic; '], '@'.$longStamp,'']);
    }
    return $arrResult;
}


##### DATA EXCHANGE:
$dPath= '../demoData/';

### SAVE to database:    (DEMO: to files)
# UPDATE files:

$bytes= 0;
# activated buttons:
if (isset($_POST['btn_sav_account'])) { tabl2arr($arrAccount,'acc_id'); $bytes+= FileWrite_arr($dPath.$filepath= 'arrAccount.dat.json',$arrAccount );}

### READ from database:    (DEMO: from files)
# INIT variables:
//if (!$arrCustomr)
$arrNames= ['arrAccount'];
fromfile($dPath, $arrNames);

$TblData= [];
foreach ($arrAccount as $data) {
    $sum[]= array_pop($data);
    array_push($data,'1','2','3','4','5','6','7','8','9','10','11','12',$sum);
    array_push($TblData,$data);
}
/*             $TblData= [['a','1','','','','','','','','','','','','','','','','',''],
                       ['b','2','','','','','','','','','','','','','','','','',''],
                       ['c','3','','','','','','','','','','','','','','','','',''],
                       ['d','4','','','','','','','','','','','','','','','','',''],
                       ['e','5','','','','','','','','','','','','','','','','',''],
                       ['f','6','','','','','','','','','','','','','','','','',''],
                       ['g','7','','','','','','','','','','','','','','','','','']]
                       , */



##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_PagePrep

htm_PagePrep($pageTitl='Accounting', $ØPageImage='../_background.png',$align='center',$PgInfo=lang('@Account-Plan'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
	Menu_TinyCloud(true); htm_nl(1);
	htm_Caption($labl='Tiny-Cloud-Accounting',$style='color:'.$ØTitleColr.'; font-weight:600; font-size: 18px;',$align='center');
	htm_nl(1);

	htm_PanlHead($frmName='account', $capt=lang('@Accounting:'), $parms='', $icon='fas fa-search', $class='panelWmax', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
        
        $RowBody= array();  #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horJust_mv]', '5:ColTip', '6:placeholder','7:default','8:select'],
        array_push($RowBody, 
            ['@Id.',         '0%','hidd', ''  ,['center'],                        '@Index','..auto..'],
            ['@Account',     '5%','text', ''  ,['center','white','','lightcyan'], '@Kontonummer. Entydig nummerkode, som benyttes til sortering, summering mv.','@Acc...'],
            ['@Description','24%','text', ''  ,['left',  '',     '','lightcyan'], '@Kontonavn - tekst som beskriver kontoen','Desc...'],
            ['@Type',        '0%','hidd', ''  ,['center','',     '','lightcyan'], '@Kontotype: D=Drift, S=Status, Z=Sum, H=Overskrift, R=Resultat, X=Sideskift, L=Lukket','@Type...','hide'],  //  Angår styring af layout i tabelvisning
            //['@Currency',    '1%','show', ''  ,['center','',     '','lightcyan'], '@Valutakode for kontoens beløb','Curr...'],
            ['@Σ-from:',     '0%','hidd', ''  ,['center','',     '','lightcyan'], '@Summation fra konto til denne','from...'],
            ['@Curr.',       '4%','text', ''  ,['center','#EEEEEE; opacity:0.50','','lightcyan'], '@Currency','.Curr..'],
            ['@Primo:',      '6%','text', '2d',['right', '#EEEEEE; opacity:0.50','','' ], '@Årets primo beløb, Sidste års ultimo','Ult...']
            );
        $MdTitles= periodLabels($TablInfo['periods']=12, $TablInfo['startYear']=2020, $TablInfo['startMonth']=1, $TablInfo['periode_dag']=0, $TablInfo['unit']='month', $TablInfo['acountYear']=2020,'2d','5%','show');
        foreach ($MdTitles as $Md) array_push($RowBody, $Md); //  periodLabels uses: ['@'.$periode_kort, '4%','text/show','2d', ['right','','font-style:italic; '], '@'.$periode_lang,'']
        array_push($RowBody, 
            ['@Sum:',        '8%','text', '2d',['right','#EEEEEE; opacity:0.50','','lightcyan'], '@Aktuelle beløb. (Årets ultimo beløb)','.calc.']
            );
            // e-conomic: "Nr.","Navn","Type","Moms","Sumfra","Saldo"
            // saldi:     Nr.	Navn	Type	Moms	Sumfra	   ?	Kurs
            // C5:        Nr.	Navn	Type	Sumfra	Moms	Valuta


        htm_Table(
            $TblCapt= array(
                ['@Year',      '90px',    'labl',    '3:Format', '4:Just',    '5:Tip',    $TablInfo['startYear']],
                ['@Period',    '90px',    'labl',    '3:Format', '4:Just',    '5:Tip',    $TablInfo['periods'].' '.$TablInfo['unit']],
              //['@Start',     '90px',    'labl',    '3:Format', '4:Just',    '5:Tip',    $TablInfo['startMonth'].'. '.$TablInfo['unit']],
              //['@Length',    '90px',    'labl',    '3:Format', '4:Just',    '5:Tip',    $TablInfo['unit']],
                ['@Currency',  '90px',    'labl',    '3:Format', '4:Just',    '5:Tip',    'DKK'],
                ['@Amount',    '90px',    'html',    '3:Format', '4:Just',    '5:Tip',    
                    htm_Input($type='opti',$name='deci',$valu='',$labl='Decimals',$hint='@Shorten amounts in output only',$plho='@Enter...',$wdth='120px',$algn='left',$unit='',$disa=false,
                              $rows='2',$step='',$more='',$list=DeciList(),$llgn='R',$bord='',$proc=false)],
            ), #['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:Just',    '5:Tip',    '6:Content'],... // Gl: 0:Label 1:width 2:align 3:Type 4:title 5:Content
            $RowPref= array(), #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[FeltJust_mm]', '5:ColTip'                                        ], ['Næste record'],... # Generel struktur!
            $RowBody,          #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[horJust_mv]',  '5:ColTip', '6:placeholder','7:default','8:select'],
            $RowSuff= array(),
            $TblNote= '',           # HTML-string
            $TblData,
            $fldNames=['acc_id', 'acc_acc', 'acc_desc', 'acc_type', 'acc_from', 'acc_curr', 'acc_prim', 'acc_sum'],
            $FilterOn= false,     
            $SorterOn= false,    
            $CreateRec=false,    
            $ModifyRec=true,     
            $ViewHeight= '700px',
            $TblStyle= '',       
            $CalledFrom= __FUNCTION__
        );
	htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);


htm_PageFina();

##### CLEANUP:

?>