<?php   $DocFil= './Proj1/demoFile/accountPlan.page.php';    $DocVer='1.0.0';    $DocRev='2020-11-02';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
require_once ('../filedata.inc.php');


### SPECIAL this page only:
require_once ('../demoData/datainit.inc.php');

// Indlæs data fra fil til array. Separator skifter automatisk fra TAB til "," hvis TAB ikke findes i først indlæste linie.
function ImportTabFile ($fn,$startLin=0,$charset='UTF-8') {
  $fp= fopen($fn,"r");
  if ($fp) {  $felter=array();  $skiller= chr(9);  $Lin=0;
    while (!feof($fp)) {
      if ($txtline= fgets($fp)) { $Lin++;
        if (strpos($txtline,chr(9))==0) $skiller= '","';  //  csv
        if (strpos($txtline,'"'.chr(9).'"')!=0) $textsep='"'; else $textsep=' ';
        if ($charset=='UTF-8') $txtline= addslashes(utf8_encode($txtline)); 
        //  Kommentar-linie overspringes (:-tegnet angiver at efterfølgende er kommentarer, f.eks. felt-navne)
        if ($txtline[0]==':') $startLin= $Lin+0; 
        else 
        { $LinFeltr= explode($skiller, $txtline);   $rawFelt= array();
            //  foreach ($LinFeltr as $felt)  array_push($rawFelt, trim(trim($felt,'"'),"'"));
            foreach ($LinFeltr as $felt)  array_push($rawFelt, trim($felt,$textsep));
            if ($Lin>=$startLin) array_push($felter, $rawFelt);
        }
      }
    } fclose($fp);
  } return $felter;
}


$test= false;
$KIS = false;

//if ($test) arrPrint($_POST,'$_POST');



#### DATA EXCHANGE:
$dPath= '../demoData/';

### SAVE to database:    (DEMO: to files)
# UPDATE files:

$bytes= 0;
# activated buttons:
// btn_cre_form_1_0 - Create new row
// Save:
if (isset($_POST['btn_sav_accplan']))  { tabl2arr($arrAccPlan,'pln_nmbr'); $bytes+= FileWrite_arr($dPath.$filepath= 'arrAccPlan.dat.json',$arrAccPlan );}
if (isset($_POST['btn_sav_accocard'])) { form2arr($arrAccCard,'nonechck'); $bytes+= FileWrite_arr($dPath.$filepath= 'arrAccCard.dat.json',$arrAccCard );}


### READ from database:    (DEMO: from files)
# INIT variables:
// if (!$arrAccPlan) 
// { $arrNam 
$arrNames= ['arrAccCard'];
fromfile($dPath, $arrNames);


/* */
$FileData= ImportTabFile('../_exchange/kontoplan.tab','','ascii');  // Old SALDI format
$data= [];
//SALDI: 0:KtNr 1:Kontonavn 2:Type  3:Moms  4:ΣFra-Kt 5:V-Kurs  6:Saldo 7:Genvej  8:Status
//TCA:   0:nmbr 1:name,     2:type, 3:from, 4:vat_,   5:cntr,   6:sald, 7:curr,   8:shrt,   9:stat
foreach ($FileData as $filrow) { //  Kompenser for fejl i TAB-fil
    $tmp= $filrow[3];
    $filrow[8]= $filrow[7];
    if ($filrow[8][0]=='G')   $filrow[8]= '';          // Shortcut
    //if ($filrow[9]=='1')      $filrow[9]= 'Active';    // Status
    if ($filrow[6]=='100')    $filrow[7]= 'DKK';       // Currency
    if ($filrow[4]>='10')     $filrow[3]= $filrow[4];  // From
    $filrow[4]= $tmp;
    $filrow[5]= '';
    $filrow[6]= '0';
    $filrow[9]= 'Active';         // Status
    switch ($filrow[2]) {         // Type
        case 'D'  : $filrow[2]= 'Operation'; break;
        case 'S'  : $filrow[2]= 'Balance'  ; break;   // Status
        case 'H'  : $filrow[2]= 'Header'   ; break;
        case 'Z'  : $filrow[2]= 'SumFrom'  ; break;
        case 'X'  : $filrow[2]= 'NewPage'  ; break;
        case 'R'  : $filrow[2]= 'Result'   ; break;
        case 'L'  : $filrow[2]= 'Closed'   ; break;
    }
    switch ($filrow[3]) {       // VAT
        case 'K1' : $filrow[4]= 'K25' ; break;
        case 'S1' : $filrow[4]= 'S25' ; break;
        case 'Y1' : $filrow[4]= 'Y25' ; break;
        case 'E1' : $filrow[4]= 'E25' ; break;
    }
    array_push($data, $filrow); 
}
 //arrPrint($FileData[3],'$FileData[3]');
/**/





 
##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_PagePrep

htm_PagePrep($pageTitl='Account Plan', $ØPageImage='../_background.png',$align='center',$PgInfo=lang('@Account-Plan: Build with <b>PHP2HTML</b>'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
    Menu_TinyCloud(true); htm_nl(1);

    if ($test) echo '<pre>'.$log.'</pre>'. '<br>Saved: '.$bytes.' bytes to data-files.<br>';

    htm_Caption($labl='BONUS Accounting',$style='color:'.$ØTitleColr.'; font-weight:600; font-size: 18px;',$align='center');
    htm_nl(1);
    htm_PanlHead($frmName='accplan', $capt=lang('@Account Plan:'), $parms='', $icon='fas fa-search', $class='panelW100', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
        htm_Table(
            $TblCapt= array( [lang('@KONTOPLANEN'), '18%','show','','left', ' ', $status] ),
            $RowPref= array(), #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[FeltJust_mm]', '5:ColTip' ], ...
            $RowBody= array(   #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[]FeltJust_mm', '5:ColTip', '6:placeholder','7:default','8:selectList'], ...
                ['@Number',         '7%','indx','',   ['center','','font-style:italic; '], '@Kontonummer. Entydig nummerkode, som benyttes til sortering, summering mv. Angiver du et ubenyttet, oprettes en ny konto, ellers kan du rette kontoen.','@Konto...'],
                ['@Account name',  '45%','text','',   ['left'  ],                          '@Kontonavn - beskrivende tekst',    '@Navn...'],
                ['@Type',           '8%','ddwn','',   ['center','','opacity:30%; '],       '@Kontotype: D=Drift, S=Status, Z=Sum, H=Overskrift, R=Resultat, X=Sideskift, L=Lukket','@Type..', '', [accoTypeList(),'width: 85px; color: gray; border: none']],  //  Angår styring af layout i tabelvisning
                ['@Sum from',       '8%','text','>0', ['center','','font-style:italic; '], '@Summér fra_konto. Angiv laveste kontonummer, som skal med i sammentællingen. Angår kun sum-konti, type Z','@Fra...'],
                ['@VAT',            '7%','ddwn','',   ['center','','font-weight:600; '],   '@Momskode: K_:Købs... S_:Salgs... Y_:Ydelser, E_:, ','@VAT...', '', [VatList(),'width: 50px; font-weight:600; ']],
                ['@Contra',         '9%','text','',   ['center'],                          '@Kontonummer på hvilken der skal modposteres','@Modpost...'],
                ['@Saldo',          '7%','show','2d', ['center','','opacity:70%'],         '@Kontoens saldo. beregnet beløb','..calc..'],
                ['@Currency',       '7%','ddwn','',   ['center'],                          '@Valuta kode',                      '@Curr..',  '', [CurrencyArr(),'width: 55px;']],
                ['@Shortcut',       '3%','text','',   ['center','Azure'],                  '@Genvejs tast, angiv et bogstav',   '@-'],
                ['@Status',         '7%','ddwn','',   ['center','Azure'],                  '@Status: Aktiv eller Lukket',       '@Stat...', '', [StatusList(),'width: 65px;']]  //  DB-Felt "lukket" værdi: "on"
            ),
            $RowSuff= array(),
            $TblNote= '',           # HTML-string
            // $FileData= $arrAccPlan,
            $data,
            $fldNames=['pln_nmbr', 'pln_name', 'pln_type', 'pln_from', 'pln_vat_', 'pln_cntr', 'pln_sald', 'pln_curr', 'pln_shrt', 'pln_stat'],
            $FilterOn= false,     
            $SorterOn= false,    
            $CreateRec=false,    
            $ModifyRec=true,     
            $ViewHeight= '800px',
            $TblStyle= '',       
            $CalledFrom= __FUNCTION__
        );
    htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);

    htm_PanlHead($frmName= 'accocard',$capt= '@Accounting card:',$parms='', $icon='fas fa-pen-square', $class='panelW480', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
        htm_Input($type='text', $name='accnmbr', $valu=$arrAccCard[$name], $labl='@Number',        $hint='@Angiv kontoens nummer',             $plho='@Konto...',  $wdth='20%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='required');
        htm_Input($type='text', $name='accname', $valu=$arrAccCard[$name], $labl='@Account name',  $hint='@Angiv kontoens navn/beskrivelse',   $plho='@Beskriv...',$wdth='80%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='required');
        htm_nl(1);
        htm_Input($type='opti', $name='acctype', $valu=$arrAccCard[$name], $labl='@Type',          $hint='@Kontotype: D=Drift, S=Status, Z=Sum, H=Overskrift, R=Resultat, X=Sideskift, L=Lukket',
                                                                                                                                                $plho='@Type...',$wdth='24%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='required',$list= accoTypeList());
        htm_Input($type='text', $name='accfrom', $valu=$arrAccCard[$name], $labl='@Sum from',      $hint='@Summér fra_konto. Angiv laveste kontonummer, som skal med i sammentællingen. Angår kun sum-konti, type Z',
                                                                                                                                                $plho='@Fra...',$wdth='24%');
        htm_Input($type='opti', $name='acc_vat', $valu=$arrAccCard[$name], $labl='@VAT',           $hint='@Momskode: K_:Købs... S_:Salgs... Y_:Ydelser, E_:, ',$plho='@Moms...',$wdth='24%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='',$list= VatList());
        htm_Input($type='text', $name='acccont', $valu=$arrAccCard[$name], $labl='@Contra',        $hint='@Modposterings konto',               $plho='@Modpost...',$wdth='24%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='',$list= VatList());
        htm_nl(1);
        htm_Input($type='text', $name='accsald', $valu=$arrAccCard[$name], $labl='@Saldo',         $hint='@Kontoens saldo. Beregnet beløb',    $plho='@..auto..',$wdth='24%',$algn='left',$unit='',$disa=true);
        htm_Input($type='opti', $name='acccurr', $valu=$arrAccCard[$name], $labl='@Currency',      $hint='@Valuta kode',                       $plho='@Curr...',$wdth='24%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='required',$list= CurrencyArr());
        htm_Input($type='text', $name='accshrt', $valu=$arrAccCard[$name], $labl='@Shortcut',      $hint='@Genvejs tast, angiv et bogstav',    $plho='@Genv...',$wdth='24%',$algn='left',$unit='',$disa=false);
        htm_Input($type='opti', $name='accstat', $valu=$arrAccCard[$name], $labl='@Status',        $hint='@Status: Aktiv eller Lukket',        $plho='@Stat...',$wdth='24%',$algn='left',$unit='',$disa=false,$rows='2',$step='',$more='required',$list= StatusList());
        htm_MiniNote('@Orange boxes are required fields.');
    htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);


    if ($KIS!=true) {
        if ($bytes== 0) {   // on page open
            // PanelOff($First=5,$Last=11); // Close panel 5 to 11,
            // PanelOff($First=14,$Last=15);
            PanelOff($First=2,$Last=2);
        }
    }
htm_PageFina();

?>