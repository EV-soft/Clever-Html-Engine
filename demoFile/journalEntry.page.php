<?php   $DocFil= './Proj1/demoFile/journalEntry.page.php';    $DocVer='1.0.0';    $DocRev='2020-08-17';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
require_once ('../filedata.inc.php');

### SPECIAL this page only:
require_once ('../demoData/datainit.inc.php');

// En gruppe af elementer på en linie, med en faelles overskrift forrest.
function htm_ButtGrup($Pmpt='@Vis:', $Start=true, $ruler=true, $style='text-align:center;') { global $ØPanelRows, $ØbrwnColor;
  if ($Start==true) { if ($ruler) echo '<hr>';
    echo '<span style="margin-left:0.1em; padding:6px; font-weight:normal; font-size:small; background: '.$ØPanelRows.'; color:'.$ØbrwnColor.'; '.$style.'" ><i>'.lang($Pmpt).'</i> &nbsp;'; // display:inline-block; 
  }
  else  
    echo '</span>';
}
# BASISMODUL for link-knap med tekst (på lys baggrund):
function textKnap ($label='',$title='',$link='',$akey='',$more='', $ToolClass='tooltiptext') 
{ global $ØButtnBgrd, $ØButtnText, $ØTastkeys;
  if ($ØTastkeys) {
    if ($akey) $genv=' ´<i>'.$akey.'</i>´'; else $genv='';
    if (!$genv) $key=''; else $key= '<br><em>'.lang('@Tastatur genvej: ').$akey.'</em>';
  }
  $genv=''; // Vis ikke genvej i knaptekst, kun i tooltip!
  if (strpos($link, 'page_Blindgyden.php')>0) 
       {$txtclr= '#AAAAAA';   $note=' <br> ('.lang('@En blindgyde endnu!').')';} 
  else {$txtclr= $ØButtnText; $note='';};
  if (($label=='@Retur til hovedmenu')) $txtclr= 'white';
  dvl_pretty('textKnap');
  $result= '<div class="tooltip" style= "margin:1px 5px; padding:2px 6px; border:2px; box-shadow: 2px 2px 4px #888888; '.$more.'"> '.   //  knap
           '<a href="'.$link.'" accesskey="'.$akey.'"> '.                                                                               //  link
           '<span class="'.$ToolClass.'">'.lang($title).$key.$note.'</span> '.                                                          //  tip
           '<span style= "white-space:nowrap; color:'.$txtclr.'; display:inline;">'. ucfirst(lang($label)).$genv.'</span></a></div>';   //  label
  if ($link!='') echo $result;
  return $result;
}
  

##### DATA EXCHANGE:
$dPath= '../demoData/';

### SAVE to database:    # UPDATE files:

# activated buttons:
if (isset($_POST['btn_sav_journLists'])) { tabl2arr($arrJournLists,'jur_id'); $bytes+= FileWrite_arr($dPath.$filepath= 'arrJournLists.dat.json',$arrJournLists );}
if (isset($_POST['btn_sav_journal']))    { tabl2arr($arrJournal,'jou_id');    $bytes+= FileWrite_arr($dPath.$filepath= 'arrJournal.dat.json',$arrJournal );}


### READ from database:  # INIT variables:
$arrNames= ['arrJournLists','arrJournal'];
fromfile($dPath, $arrNames);    
$tabldata= $arrJournLists;
$DATA= $arrJournal;
foreach ($DATA as $dat) if ($dat[0]=='') $dat[0]= $i++;


##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_PagePrep

htm_PagePrep($pageTitl='-.page.php', $ØPageImage='../_background.png',$align='center',$PgInfo=lang('@-'),$PgHint=lang('Tip: Toggle fullscreen-mode with function key: F11'));
//	Menu_Topdropdown(true); htm_nl(1);
	Menu_TinyCloud(true); htm_nl(1);
htm_Caption($labl='Nice-Cloud-Accounting',$style='color:'.$ØTitleColr.'; font-weight:600; font-size: 18px;',$align='center');
	htm_nl(1);
	

//  function Panl_Kassekladder(&$tabldata)  ## out_PanlsPrim.php
//  { dvl_ekko(' Panl_Kassekladder ');
//    global $ØBtNewBgrd;
    htm_PanlHead($frmName= 'journLists',$capt= '@Kassekladder:',$parms='#',$icon='fas fa-list','panelW100',__FUNCTION__);

    htm_Table(
        $TblCapt= array(['@Her kan du vælge en blandt ialt', '15%', 'html', '', 'left','@Vælg en kladde, og se den i panelet nedenfor.', ''],
                        [' ',    '',    'rows',    '', '',      '',    '@kladder']
            ), #['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:Just',          '5:Tip',    '6:Content'],... 
        $RowPref= array(
        ),
        $RowBody= array( #['0:ColLabl', '1:ColWidth', '2:InpType', '3:Format', '4:[FeltJust_mm]', '5:ColTip', '6:placeholder','7:default','8:select'],
             ['@Id',         '10%', 'indx', '',   ['center'], '@Systemoprettet løbenummer','..auto..',''],      //  id 
             ['@Oprettet',   '08%', 'date', '',   ['center'], '@Dato for kladdens oprettelse','YYYY-MM-DD',''], //  kladdedate
             ['@Ejer',       '10%', 'text', '',   ['left'  ], '@Den der har oprettet kladden','Ejer...',''],    //  oprettet_af
             ['@Bemærkning', '50%', 'text', '',   ['left'  ], '@Tekst der beskriver kladden','Bem...',''],      //  kladdenote
             ['@Bogført',    '08%', 'date', '',   ['center'], '@Bogført dato','YYYY-MM-DD',''],                 //  bogforingsdate
          // ['@Af',          '5%', 'text', '',   ['center'], '@Bruger der har bogført','Af...',''],            //  bogfort_af
             ['@Af',          '5%', 'ddwn', '',   ['center'], '@Bruger der har bogført','','', [UserList(),'width: 70px;']],  //  bogfort_af
             ['@Status',      '5%', 'ddwn', '',   ['left'  ], '@B:Bogført og låst / S:Simuleret - kan redigeres','','', [JourStatu(),'width: 70px;']],  //  bogfort
          // ['@hvem',        '0%', 'hidd', '',   ['center'], '@hvem','hvem...',''],                            //  hvem - bogfører - Flerbrugerkontrol
          // ['@tidspkt',     '0%', 'hidd', '',   ['center'], '@tidspkt','tidspkt...','']                       //  tidspkt - hvornår - Flerbrugerkontrol
        ),
        $RowSuff= array(['@Kopi','8%','knap', '',['center'], '@Klik på kopi knap, for at kopiere journalen (journalen= bogført kassekladde) til en ny. <br>Den skal være bogført, inden kopiering!', 
                       /*      '<a href= "#" onclick= "return confirm(\'Vil du kopiere denne kassekladde? - Den skal være bogført, inden du kopierer den!\') ">'.
                            '<ic class="far fa-copy" style="color:'.$ØBtNewBgrd.'; font-size:14px;"></ic></a>' */
                        '<a href='.$link= htm_ModalDialog($Btype='hint',$capt='@DEMO page!', 
                                                    $mess='@The site is still under development.<br>The function to copy the journal is not finished yet.', 
                                                    $butt=[ ['clos'],['hint','','Got it'] ], $html=
                                                    '<ic class="far fa-copy" style="font-size:14px; color:'.$ØBtNewBgrd.';" title="'.
                                                    lang('@Vil du kopiere denne kassekladde? - Den skal være bogført, inden du kopierer den!').'"></ic>').
                        '</a>'
                        ],
                        ['@Slet','8%','knap', '',['center'], '@Klik på rødt kryds for at slette kassekladden. <br>Den skal være tom, inden sletning!', 
                      /*     '<a href= "#" onclick= "return confirm(\'Vil du slette denne kassekladde? - Den skal være tom, inden du sletter den!\') ">'.
                            '<ic class="far fa-times-circle" style="color:red; font-size:14px;"></ic></a>' */
                        '<a href='.$link= htm_ModalDialog($Btype='hint',$capt='@DEMO page!', 
                                                    $mess='@The site is still under development.<br>The function to delete the journal is not finished yet.', 
                                                    $butt=[ ['clos'],['hint','','Got it'] ], $html=
                                                    '<ic class="far fa-times-circle" style="font-size:14px; color:red;" title="'.
                                                    lang('@Vil du slette denne kassekladde? - Den skal være tom, inden du sletter den!').'"></ic>').
                        '</a>'
                        ]),
        $TblNote= '',           # HTML-string
        $tabldata, //= [['1','Dato','Ejer','Bemærkning 1','Bogført-dato','ej','B'], ['2','Dato','Ejer','Bemærkning 2','Bogført-dato','ej','B'], ['3','Dato','Bogholder','Bemærkning3','-','bh','S']],
        $fldNames=['jur_id','jur_crea','jur_ownr','jur_remrk','jur_date','jur_user','jur_stat'/* ,'jur_who','jur_stamp' */],     # FieldNames in array returned on submit. Also used to sort data fields
        $FilterOn= true,       #  Mulighed for at skjule records med filter.
        $SorterOn= true,       #  Mulighed for at sortere records efter kolonne indhold
        $CreateRec=true,       #  Mulighed for at oprette en record
        $ModifyRec=true,       #  Mulighed for at ændre data i en row
        $ViewHeight= '200px',  #  Højden af den synlige del af tabellens data
        $TblStyle= '',         # Style for the span that holds the table;
	    $CalledFrom= __FILE__ ,
        $MultiList= ['',''],   # LookupLists for options // Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
        $ExportTo= 'Journal.csv'
    );                                      
    htm_TextDiv('Klik på Id-nummeret, for at indlæse den kladde, du vil redigere...');
    htm_PanlFoot($pmpt='@Gem',$subm=true,'',$type='','','',$frmName='journLists');
      

      $dkftip=  lang('@D/K/F feltet benyttes i forbindelse med debitor- og kreditor posteringer.').' '.
                lang('@Er feltet tomt eller udfyldt med F, betragtes det efterfølgende kontonummer som et Finans konto-nummer.').
                lang('@Skrives der `d` eller `k`, vil det efterfølgende nummer blive tolket som et Debitor konto-nummer eller et Kreditor konto-nummer.');
      $DKforkl= lang('@Afhængigt af koden i D/K-kolonnen foran feltet, vil der være tale om en Debitor-, Kreditor- eller Finanskonto');
    //  if ($dokument[$y]) print "<td title="klik her for at åbne bilaget: $dokument[$y]"><a href="../includes/bilag.php?kilde=kassekladde&filnavn=$dokument[$y]&bilag_id=$id[$y]&bilag=$bilag[$y]&kilde_id=$kladde_id&fokus=bila$y"> <img style="border: 0px solid" src="../ikoner/paper.png"> </a></td>";
    //  else               print "<td title="klik her for at vedhæfte et bilag">          <a href="../includes/bilag.php?kilde=kassekladde&bilag_id=$id[$y]&bilag=$bilag[$y]&ny=ja&kilde_id=$kladde_id&fokus=bila$y">                 <img style="border: 0px solid" src="../ikoner/clip.png">  </a></td>";
    $y= 0;  $dokument= array();
      if ($dokument[$y]) {
              $title='@klik her for at åbne bilaget: $dokument[$y]';
              $link='../_base/page_Blindgyden.php'; /* "../includes/bilag.php?kilde=kassekladde&filnavn=$dokument[$y]&bilag_id=$id[$y]&bilag=$bilag[$y]&kilde_id=$kladde_id&fokus=bila$y";    */
              $clip= 'paper.png';
       } else {
              $title='@klik her for at vedhæfte et bilag';  
              $link='../_base/page_Blindgyden.php'; /* "../includes/bilag.php?kilde=kassekladde&bilag_id=$id[$y]&bilag=$bilag[$y]&ny=ja&kilde_id=$kladde_id&fokus=bila$y";  */
              $clip= 'clip.png'; 
      };
  
    htm_PanlHead($frmName= 'journal',$capt= lang('@Redigering af kassekladde:').' '.$id='5'.', <small>'.$oprettet_af='demo'.'</small>',$parms='#',$icon='fas fa-database','panelW100',__FUNCTION__);
    htm_Table(
        $TblCapt= array( #['0:Label',   '1:Width',    '2:Type',    '3:Format', '4:horJust',      '5:Tip',    '6:Content']
          ['@Kladde:',       '40%','text','','left', '@Her er den tekst du angav i kladdens bemærkning-felt',  '@Angiv din bemærkning...', 'Bemærkning 3'], 
          ['@Konto-kontrol:','5em','text','','left', '@Angiv kontonummer for den konto, hvis bevægelser skal kontrolleres',  '@Nummer...'], 
        ),
        $RowPref= array(  #['0:ColLabl', '1:ColWidth', '2:InpType', '3:OutFormat', '4:[horJust_mv]', '5:ColTip', '6:Html'],
          ['PDF',           '2%','text', '' ,['center'],'@I denne kolonne håndterer du PDF-bilag, som er tilknyttet den enkelte postering.',
          /*     '<a href='.$link.'><ic class="fas fa-paperclip" style="font-size:14px; color:'.$ØBtNavBgrd.';" title="'.
              lang('@Tilføj eller fjern PDF-bilag til denne post.').'"></ic></a>','placeh' */
                '<a href='.$link= htm_ModalDialog($Btype='hint',$capt='@DEMO page!', 
                                            $mess='@The site is still under development.<br>The function to handle PDF is not finished yet.', 
                                            $butt=[ ['clos'],['hint','','Got it'] ], $html=
                                            '<ic class="fas fa-paperclip" style="font-size:14px; color:'.$ØBtNavBgrd.';" title="'.
                                            lang('@Tilføj eller fjern PDF-bilag til denne post.').'"></ic>').
                '</a>','placeh'
          ]
          ),
        $RowBody= array(
          ['@id',           '0%','show', '' ,['center'],'@System-index.'.' ','..auto..'],
          ['@Bilag',        '4%','text', '' ,['center'],'@Bilagsnummer tildeles automatisk og fortsættes fra sidst anvendte bilagsnummer fra samme bruger.'.' ','...auto...'],
          ['@Dato',         '8%','date', '' ,['center'],'@Bilagets dato, som automatisk sættes til dags dato, men kan ændres.','@Bilags-dato'],
          ['@Bilagstekst', '27%','text', '' ,['left'  ],lang('@Bilagstekst er frivillig, men det er nyttigt senere at kunne se, hvad de enkelte posteringer drejer sig om.').' ',lang('@Posterings note...')],
          ['@D/K',          '3%','text', '' ,['center'],$dkftip,'d/k/f'],
          ['@Debet',        '6%','text', '' ,['center'],lang('@Debet Kt. er til kontonummeret på den konto, posteringen skal ske på.').' '.$DKforkl,'D-kt'],
          ['@D/K',          '3%','text', '' ,['center'],$dkftip,'d/k/f'],
          ['@Kredit',       '6%','text', '' ,['center'],lang('@Kredit Kt. er til kontonummeret på den konto, posteringen skal ske på.').' '.$DKforkl,'K-kt'],
          ['@Faktura',      '7%','text', '' ,['center'],'@Fakturanr. benyttes i forbindelse med debitor- og kreditorposteringer.','Fak...'],
          ['@Beløb',        '7%','text','2d',['right' ],lang('@Beløb indeholder det beløb, der skal bogføres. ').'<br>'.
                                                        lang('Hvis man ved simulering eller anden kontrol opdager, at en linje skal bogføres direkte modsat af, ').
                                                        lang('@hvad der står i kassekladden, så kan man blot sætte minustegn foran beløbet.').' '.
                                                        lang('@På den måde bytter kontonumrene i felterne debet og kredit plads, og beløbet bliver igen positivt.'),'...Kr.'],
          ['@Valuta',       '4%','text', '',['center'],'@Valutakode for den valuta, som er benyttet på bilaget.','DKK'],
          ['@Forfald',      '8%','date', '',['center'],'@Beløbets forfalds dato.','@Forfalds-dato'],
          ['@moms',         '4%','text', '',['center'],'@Uden moms: Angiv 0, hvis der ikke skal beregnes moms. Uden angivelse, benyttes standard moms-sats.','@25%.'],
          ),
        $RowSuff= array(
          ['@Kontrol',      '5%','text', '',['right'], #'0.000,00<div type= "text" name="saldo" value="00.000,00" width="8%"/>',
                lang('@Bevægelser og saldo for den konto, som angives ovenfor i Felt: Konto-kontrol.').' <br>'.
                lang('@Er velegnet til afstemning med bank- og girokonti'),'<small>..auto..</small>'],
          ['@Fortryd',      '3%','text', '',['center'],'@Fortryd postering! <br>Tilbagefør beløbet ved at klikke på ikonen',
                '<a href='.$link= htm_ModalDialog($Btype='hint',$capt='@DEMO page!', 
                                            $mess='@The site is still under development.<br>The function to undo is not finished yet.', 
                                            $butt=[ ['clos'],['hint','','Got it'] ], $html=
                                            '<ic class="fas fa-undo" style="font-size:14px; color:red;" title="'.
                                            lang('@Tilbagefør denne postering').'"></ic>').
                '</a>'
//'><ic class="fas fa-undo" style="font-size:14px; color:red;" title="'.lang('@Tilbagefør denne postering').'"></ic></a>'
                
          ]
          ),
        $TblNote= '',           # HTML-string 
        $DATA, // =[['jou_id','jou_att','jou_date','jou_text','jou_typd','jou_debet','jou_typk','jou_kred','jou_invo','jou_amou','jou_curr','jou_maturity','jou_vat']],
        $fldNames=[/* 'jou_pdf', */ 'jou_id','jou_att','jou_date','jou_text','jou_typd','jou_debet','jou_typk','jou_kred','jou_invo','jou_amou','jou_curr','jou_maturity','jou_vat'],           # FieldNames in array returned on submit. Also used to sort data fields
        $FilterOn= true,       #  Mulighed for at skjule records med filter.
        $SorterOn= true,       #  Mulighed for at sortere records efter kolonne indhold
        $CreateRec=true,       #  Mulighed for at oprette en record
        $ModifyRec=true,       #  Mulighed for at ændre data i en row
        $ViewHeight= '300px',  # Højden af den synlige del af tabellens data
        $TblStyle= '',          # Style for the span that holds the table;
        $CalledFrom= __FUNCTION__ ,
        $MultiList= ['',''],    # LookupLists for options // Test [DataKolonneNr, > grænseværdi] Undlad spec. FieldColor
        $ExportTo= 'Kladde.csv'
      );
    ### PanelFooter:
    ### KnapPanel:
    htm_ButtGrup('@Kassekladde:',true,false);
    //  htm_AcceptButt($label='@Gem',             $title='@Klik her for at gemme',                                                                        $btnKind='save', $form='', $width='', $akey='g', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Opslag',        $title='@Opslag i tabel, som er knyttet til den kolonne, din markør er placeret i (Deb/Kre/fakt/kladder)', $btnKind='goon', $form='', $width='', $akey='o', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more, $icon='fab fa-searchengin');
        htm_AcceptButt($label='@Simuler',       $title='@Simulering af bogføring viser bevægelser i kontoplanen',                                       $btnKind='spc1', $form='', $width='', $akey='s', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Annuller',      $title='@Annuller simulering',                                                                          $btnKind='spc1', $form='', $width='', $akey='a', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more, $icon='fas fa-undo');
        htm_AcceptButt($label='@Bogfør',        $title='@Bogfør - der foretages først en simulering, som du skal bekræfte',                             $btnKind='save', $form='', $width='', $akey='b', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more, $icon='far fa-check-square');
      //htm_AcceptButt( # $labl='', $title='', $btnKind='', $form='', $width='', $akey='', $proc=false, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more, $icon);
        htm_AcceptButt($label='@Clone',         $title='@Kopier kassekladden til en ny',                                                                $btnKind='navi', $form='', $width='', $akey='k', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more, $icon='far fa-clone');
        htm_AcceptButt($label='@Tilbagefør',    $title='@Tilbagefør postering',                                                                         $btnKind='navi', $form='', $width='', $akey='t', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Hent ordrer',   $title='@Henter afsluttede ordrer fra ordreliste',                                                      $btnKind='get_', $form='', $width='', $akey='h', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Bankimport',    $title='@Importerer bankposteringer eller andre data fra .csv-fil (kommasepareret fil)',                $btnKind='get_', $form='', $width='', $akey='i', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Import',        $title='@Importerer hele kassekladden fra .csv-fil (kommasepareret fil)',                               $btnKind='get_', $form='', $width='', $akey='i', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Eksport',       $title='@Eksporter hele kassekladden til .csv-fil (kommasepareret fil)',                                $btnKind='put_', $form='', $width='', $akey='i', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Udlign',        $title='@Finder åbne poster, som modsvarer beløb og fakturanummer',                                     $btnKind='navi', $form='', $width='', $akey='u', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
        htm_AcceptButt($label='@Vis print',     $title='@Skjul header og footer, og vis tabel i fuld højde, så du kan udskrive kassekladden med CTRL-P',$btnKind='navi', $form='', $width='', $akey='u', $proc=true, $tipplc='LblTip_text', $tipstyl='',$clicking='', $more);
    htm_ButtGrup('@Her kan du:',false);
      //TastTip();
    htm_PanlFoot($pmpt='@Gem',$subm=true,'',$type='','','',$frmName='journal');
      
/* 	htm_PanlHead($frmName='', $capt=lang('@-'), $parms='', $icon='fas fa-plus', $class='panelW960', $where=__FILE__, $more='', $BookMark='blindAlley.page.php',$panlBg='background-color: rgba(240, 240, 240, 0.80);');
	htm_PanlFoot($labl='@Save', $subm=true, $title='', $btnKind='save', $akey='', $simu=false, $frmName);
 */
    PanelOff($First=1,$Last=1);
htm_PageFina();

##### CLEANUP:

?>