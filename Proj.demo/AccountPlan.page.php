<?php   $DocFile= './Proj.demo/accounPlan.page.php';    $DocVer='1.2.1';    $DocRev='22-07-31';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';
$lang= 'da';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php');

## Speedup page-loading, if some libraryes is not needed:
//      ConstName:          ix:   LocalPath:                 CDN-path:
define('LIB_JQUERY',        [1, '_assets/jquery/',          'https://cdnjs.cloudflare.com/ajax/libs/']);
define('LIB_TABLESORTER',   [1, '_assets/tablesorter/js/',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.1/js/']);
define('LIB_POLYFILL',      [0, '_assets/',  '']);
define('LIB_POPSCRIPTS',    [0, '_assets/',  '']);
define('LIB_FONTAWESOME',   [0, '_assets/',  '']);
// Set ix 0:deactive  1:Local-source  2:WEB-source-CDN


htm_Page_0( $titl='accounPlan.page.php',$hint=$©,$info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=false);
    Menu_Topdropdown(true); htm_nl(1);
    $dPath= '../Data.demo/';
    $accoPlan= json_decode(file_get_contents(/* $dPath. */'accPlan.dk.json' /* 'export.dat.json' */), true); // export.dat.json / $dPath.'arrAplan2.dat.json'
    // $accoPlan= newFieldOrder($accoPlan,['pln_id__','pln_nmbr','pln_name','pln_type','pln_from','pln_vat_','pln_sald','pln_curr','pln_cour','pln_shrt','pln_stat']);
    // arrPretty($accoPlan,'$accoPlan');
    
    htm_Panel_0($capt= '@Account Plan:',$icon= 'fas fa-info',$hint= '',$form= $fm='plan',$acti= '',$clas= 'panelW110',$wdth= '',$styl= 'background-color: white;',$attr= '');
    htm_Table(TblCapt:[['@@Kontoplan baseret på Erhvervsstyrelsens standard.', 'Width', 'html', 'OutFormat', 'horJust', 'Tip', '', '']],
        RowPref:[],
        RowBody:[
              ['@Id.',          '0%','hidd','',   ['center'],                         'pln_id__', '@Index maintained by the system','serial...'],
              ['@Account no.',  '5%','indx','',   ['center','transparent'],           'pln_nmbr', '@Account number. Unique number code, which is used for sorting, totaling, etc. If you enter an unused one, a new account will be created, otherwise you can correct the account.','@Konto...'],
              ['@Account name','45%','text','',   ['left'  ],                         'pln_name', '@Account name - descriptive text','@Name...'],
              ['@Type',         '9%','text','',   ['center'],                         'pln_type', '@Account type: D=Operation, S=Status, Z=Total, H=Heading, R=Result, X=Page Break, L=Closed','@Type...'],  //  Angår styring af layout i tabelvisning
              ['@FromAcc',      '9%','text','>0', ['center','','font-style:italic; '],'pln_from', '@Total from_account. Enter the lowest account number to be included in the tally. Applies only to sum accounts, type Z','@Fra...'],
              ['@VAT',          '7%','text','',   ['center'],                         'pln_vat_', '@VAT code: K_:Purchase... S_:Sale... Y_:Services, E_:,','@Code...'], 
              ['@Balance',      '9%','show','2d', ['center'],                         'pln_sald', '@Account balance. Calculated amount'],
              ['@Currency',     '5%','text','',   ['left'],                           'pln_curr', '@Currency code','@Currency','',true],
              ['@Course',       '7%','text','',   ['center'],                         'pln_cour', '@Course','','',true],
              ['@Shortcut',     '3%','text','',   ['center','Azure'],                 'pln_shrt', '@Shortcut key, enter a letter','@Ingen'],
              ['@Status',       '7%','sttu','',   ['center','Azure'],                 'pln_stat', '@Status: Active or Closed','@Stat...']  //  DB-Felt "lukket" værdi: "on"
        ],
        RowSuff:[],
        TblNote:'',
        TblData:$accoPlan,
        FilterOn:false, SorterOn:false, CreateRec:true, ModifyRec:true, 
        ViewHeight:'800px', TblStyle:'', CalledFrom:'', 
        MultiList:['KONTOPLAN',['','','','','','','','','','']]   // ,ExportTo: $dPath.'Export.csv.txt'
        );
        htm_nl();
        htm_LinkButt( labl:'@Print preview', hint:'@Vis tabellen i fuld bredde og højde og uden navigations knapper', 
                            attr:'', link:'accountPlan-print.page.php');     // https://ev-soft.work/p2h/v1.2.0/Proj.demo/accountPlan-print.page.php
        
    htm_Panel_00('@Save','','@Save to database','save',$fm,true); 
    htm_nl();
    // arrPretty($accoPlan,'$accoPlan');
    echo str_WithHint($labl='@Kontoplan ?',$hint='@Erhvervsstyrelsen har udgivet en standard kontoplan med tilhørende vejledning til postering på kontiene.',$icon='').'<br><br>';
    echo '<a href="https://erhvervsstyrelsen.dk/sites/default/files/2019-03/Vejledning%20til%20den%20frivillige%20standardkontoplan%20V.1.pdf" target="_blank">Vejledning til standard kontoplanen</a><br><br>';

    // file_put_contents('accountPlan.print.htm','<body style="margin:0; padding:0;">'.$spool.'</body>');

htm_Page_00(); 


    PanelOff($First=2,$Last=2);
    
    /* 
    // echo put_json($fname=$dPath.'arrAplan2.dat.json',$accoPlan).' b saved';
    $string = file_get_contents('accounts.txt');
    $lines  = explode("\n", $string);
    arrPretty($string,'$string');
// $source= json_decode(file_get_contents(/* $dPath. *  /'accounts.txt'), true);
    echo '<code>';
    $fp = fopen('export.dat.json', 'w'); // accPlan.en.json accPlan.dk.json
    $rec= '[';
    $id= 0;
    foreach ($lines as $lin) {
        $acc= trim(substr($lin,0,15));
        $txt= trim(substr($lin,16));
        $from= '';
        $vat= '';
        if ($acc>5000) $type= 'S'; else $type= 'D'; // Status or Drift
        if (strlen($acc)<3)             $type= 'H';
        if ($p= stripos(strval($acc),'sum ') !== false) {
            $type= 'Z'; 
            $from= substr($acc,$p+3,strpos($acc,'-')-4);
            $acc=  substr($acc,     strpos($acc,'-')+1);
        };
        if ($p= stripos(strval($acc),'total ') !== false) {
            $type= 'T'; 
            $from= substr($acc,$p+5,strpos($acc,'-')-6);
            $acc=  substr($acc,     strpos($acc,'-')+1);
        };
        if ($p= stripos(strval($acc),'------') !== false) {
            $type= 'X'; 
            $from= '';
            $acc=  '';
        };
        if (($type== 'D') or ($type== 'S') or ($type== 'Z')) $stat= 'On'; 
        else $stat= 'Off';

        echo $type.' '.$from.' ['.$acc.'] ['.$txt.']<br>';
        $rec.='{
        "pln_id__":"'.($id++).'",
        "pln_nmbr":"'.$acc.'",
        "pln_name":"'.$txt.'",
        "pln_type":"'.$type.'",
        "pln_from":"'.$from.'",
        "pln_vat_":"'.$vat.'",
        "pln_sald":"0.00",
        "pln_curr":"DKK",
        "pln_cour":"100",
        "pln_shrt":"-",
        "pln_stat":"'.$stat.'"
        },';
    }
    if ($fp) fwrite($fp,substr($rec,0,strlen($rec)-1).']'); 
    fclose($fp);
 */
/* 
https://erhvervsstyrelsen.dk/standardkontoplan:

Konto	       Navn
                RESULTATOPGØRELSE
                
                Nettoomsætning
1010	            Salg af varer og ydelser m/ moms
1050	            Salg af varer udland, EU
1100	            Salg af varer udland, ikke-EU
1150	            Salg af ydelser udland, EU
1200	            Salg af ydelser udland, ikke-EU
1250	            Ej momspligtigt salg
Sum 1010-1399   Nettoomsætning
                Ændring i lagre af færdigvarer og varer under fremstilling
1410            Varelagerregulering
1430            Nedskrivning på varelager
1460            Øvrige ændringer på varelager
Sum 1410-1499   Ændring i lagre af færdigvarer og varer under fremstilling
                Andre driftsindtægter
1510            Gevinst ved salg af immaterielle anlægsaktiver
1530            Gevinst ved salg af materielle anlægsaktiver
1550            Øvrige andre driftsindtægter
Sum 1510-1599   Andre driftsindtægter
                Omkostninger til råvarer og hjælpematerialer  
1610            Varekøb m/ moms
1630            Varekøb udland, EU
1650            Varekøb udland, ikke-EU
1670            Varekøb u/  moms
Sum 1610-1699   Omkostninger til råvarer og hjælpematerialer  
                Andre eksterne omkostninger
                Salgsomkostninger
1710	            Fragtomkostninger
1730	            Annoncering og reklame
1750	            Udstillinger og dekoration
1770	            Restaurationsbesøg
1790	            Repræsentationsomkostninger, skattemæssigt begrænset fradrag
1810	            Repræsentationsomkostninger, fuld fradragsret skattemæssigt
1830	            Andre salgsomkostninger
1850	            Gaver og blomster
Sum 1710-1899   Salgsomkostninger
                Lokaleomkostninger
1910            Husleje, ekskl. el, vand og varme /m moms
1930            Husleje, ekskl. el, vand og varme /u moms
1950            El 
1970            Elafgift
1990            Vand
2010            Varme
2030            Olie- og flaskegasafgift
2050            Naturgas- og bygasafgift
2070            Øvrige afgifter
2090            Rengøring og renovation
2110            Reparation og vedligeholdelse
2130            Forsikringer
2150            Ejendomsskatter
2170            Andre lokaleomkostninger
Sum 1910-2199   Lokaleomkostninger
                Administrationsomkostninger
2210	            Småanskaffelser under skattemæssig grænse for småaktiver
2230	            Småanskaffelser over skattemæssig grænse for småaktiver
2250	            Underleverandører
2270	            Forsknings- og udviklingsomkostninger
2290	            Øvrige produktionsomkostninger
2310	            Konstaterede tab på tilgodehavender fra salg og tjenesteydelser
2330	            Regulering af nedskrivning på tilgodehavender fra salg og tjenesteydelser
2350	            Regulering af tilgodehavender fra tilknyttede virksomheder og associerede virksomheder
2370	            It-udstyr mv.
2390	            Skattefri rejse- og befordringsgodtgørelse 
2410	            Kontingenter
2430	            Faglitteratur
2450	            Porto og gebyrer, u/  moms
2470	            Porto og gebyrer, m/  moms
2490	            Telefon, internet mv. på virksomhedens adresse (kun virksomhed)
2510	            Mobiltelefoni, internet mv., anskaffelse og abonnement (delvis privat)
2530	            Kontorartikler
2550	            Leje og operationelle leasingydelser (ekskl. husleje)
2570	            Rejseudgifter
2590	            Vikarassistance
2610	            Konsulentydelser
2630	            Kursusudgifter
2650	            Driftsomkostninger, personbiler (fradragsret for moms)
2670	            Driftsomkostninger, personbiler (ikke fradragsret for moms)
2690	            Driftsomkostninger, varebiler
2710	            Arbejdsskadeforsikring
2730	            Offentlige gebyrer og bøder (ej fradragsberettiget skattemæssigt)
2750	            Revision og regnskabsmæssig assistance
2770	            Advokatmæssig assistance
2790	            Øvrige rådgivningshonorarer
2810	            Administrationsvederlag/management fee
2830	            Øreafrunding/kassedifferencer
2850	            Andre eksterne omkostninger, m/ moms
2870	            Andre eksterne omkostninger, u/ moms
Sum 2210-2899   Administrationsomkostninger
Sum 1710-2899   Andre eksterne omkostninger
                Bruttofortjeneste/Bruttotab
                Personaleomkostninger
2910            Lønninger
2930            Feriepengeforpligtelse
2950            Jubilæumsgratiale og fratrædelsesgodtgørelse 
2970            Bestyrelseshonorar
2990            Bidragspligtig a-indkomst
3010            Bidragsfri a-indkomst
3030            Pensioner
3050            Vederlag til afløsning af pensionstilsagn 
3070            Omkostninger til social sikring
3090            AER/ AUB
3110            ATP
3130            Andre personaleomkostninger
Sum 2910-3149   Personaleomkostninger
                Af- og nedskrivninger af materielle og immaterielle anlægsaktiver 
3160	            Af- og nedskrivninger af erhvervede immaterielle anlægsaktiver
3180	            Af- og nedskrivninger af goodwill
3200	            Af- og nedskrivninger af grunde og bygninger
3220	            Af- og nedskrivninger af produktionsanlæg og maskiner
3240	            Af- og nedskrivninger af indretning af lejede lokaler
3260	            Af- og nedskrivninger af andre anlæg, driftsmateriel og inventar
3280	            Af- og nedskrivninger af software
Sum 3160-3299   Af- og nedskrivninger af materielle og immaterielle anlægsaktiver 
                Andre driftsomkostninger
3310	            Tab ved salg af immaterielle anlægsaktiver
3330	            Tab ved salg af materielle anlægsaktiver
3350	            Øvrige andre driftsomkostninger
Sum 3310-3369   Andre driftsomkostninger
                Indtægter af andre kapitalandele, værdipapirer og tilgodehavender, der er anlægsaktiver
3380            Udbytte fra unoterede porteføljeaktier 
3400            Øvrige indtægter af andre kapitalandele, værdipapirer og tilgodehavender, der er anlægsaktiver
Sum 3380-3419   Indtægter af andre kapitalandele, værdipapirer og tilgodehavender, der er anlægsaktiver
                Andre finansielle indtægter fra tilknyttede virksomheder 
3440	            Andre finansielle indtægter fra tilknyttede virksomheder
Sum 3440-3459   Andre finansielle indtægter fra tilknyttede virksomheder 
                Andre finansielle indtægter
3470            Renter fra banker
3490            Renter vedr. tilgodehavende fra salg af varer og tjenesteydelser
3510            Rentetillæg mv. fra det offentlige (ej skattepligtig)
3530            Øvrige finansielle indtægter
Sum 3470-3549   Andre finansielle indtægter
                Nedskrivning af finansielle aktiver
3560            Nedskrivning af finansielle aktiver
Sum 3560-3579   Nedskrivning af finansielle aktiver
                Finansielle omkostninger, der hidrører fra tilknyttede virksomheder
3590	            Finansielle omkostninger, der hidrører fra tilknyttede virksomheder
Sum 3590-3599   Finansielle omkostninger, der hidrører fra tilknyttede virksomheder
                Øvrige finansielle omkostninger
3610            Valutakursreguleringer
3630            Kurstab på likvider, bankgæld og prioritetsgæld
3650            Renter vedr. leverandører af varer og tjenesteydelser
3670            Renter til banker og realkreditinstitutter
3690            Andre finansielle omkostninger
Sum 3610-3729   Øvrige finansielle omkostninger
                Resultat før skat
                Skat af årets resultat
3740	            Aktuel skat
3760	            Ændring af udskudt skat
3780	            Regulering vedrørende tidligere år
Sum 3740-3799   Skat af årets resultat
                Andre skatter
3810	            Andre skatter
Sum 3810-3849   Andre skatter
                Årets resultat



Konto	       Navn
                BALANCE
                
                AKTIVER
                Anlægsaktiver
                Immaterielle anlægsaktiver
                Goodwill
5110	            Goodwill, bogført værdi primo
5130	            Goodwill, årets tilgange
5150	            Goodwill, øvrige værdireguleringer
5170	            Goodwill, årets af- og nedskrivninger
Sum 5110-5199   Goodwill, ultimo
                Erhvervede immaterielle anlægsaktiver
5210            Erhvervede immaterielle anlægsaktiver, bogført værdi primo
5230            Erhvervede immaterielle anlægsaktiver, årets tilgange
5250            Erhvervede immaterielle anlægsaktiver, øvrige værdireguleringer
5270            Erhvervede immaterielle anlægsaktiver, årets af- og nedskrivninger
Sum 5210-5299   Erhvervede immaterielle anlægsaktiver, ultimo
                Immaterielle anlægsaktiver
                Materielle anlægsaktiver
                Grunde og bygninger
5310	            Grunde og bygninger, bogført værdi primo
5330	            Grunde og bygninger, årets tilgange 
5350	            Grunde og bygninger, årets forbedringer
5370	            Grunde og bygninger, øvrige værdireguleringer
5390	            Grunde og bygninger, årets af- og nedskrivninger
Sum 5310-5399   Grunde og bygninger, ultimo
                Produktionsanlæg og maskiner
5410            Produktionsanlæg og maskiner, bogført værdi primo
5430            Produktionsanlæg og maskiner, årets tilgange
5450            Produktionsanlæg og maskiner, øvrige værdireguleringer
5470            Produktionsanlæg og maskiner, årets af- og nedskrivninger
Sum 5410-5499   Produktionsanlæg og maskiner, ultimo
                Indretning af lejede lokaler
5510	            Indretning af lejede lokaler, bogført værdi primo
5530	            Indretning af lejede lokaler, årets tilgange
5550	            Indretning af lejede lokaler, øvrige værdireguleringer
5570	            Indretning af lejede lokaler, årets af- og nedskrivninger
Sum 5510-5599   Indretning af lejede lokaler, ultimo
                Andre anlæg, driftsmateriel og inventar
5610	            Andre anlæg, driftsmateriel og inventar, bogført værdi primo
5630	            Andre anlæg, driftsmateriel og inventar, årets tilgange
5650	            Andre anlæg, driftsmateriel og inventar, øvrige værdireguleringer
5670	            Andre anlæg, driftsmateriel og inventar, årets af- og nedskrivninger
Sum 5610-5699   Andre anlæg, driftsmateriel og inventar, ultimo
                Materielle anlægsaktiver under udførelse og forudbetalinger for materielle anlægsaktiver
5710	            Materielle anlægsaktiver under udførelse og forudbetalinger for materielle anlægsaktiver, bogført værdi primo
5730	            Materielle anlægsaktiver under udførelse og forudbetalinger for materielle anlægsaktiver, årets tilgange
5750	            Materielle anlægsaktiver under udførelse og forudbetalinger for materielle anlægsaktiver, øvrige værdireguleringer
5770	            Materielle anlægsaktiver under udførelse og forudbetalinger for materielle anlægsaktiver, årets nedskrivninger
Sum 5710-5799   Materielle anlægsaktiver under udførelse og forudbetalinger for materielle anlægsaktiver, ultimo
                Materielle anlægsaktiver
                Finansielle anlægsaktiver
                Langfristede tilgodehavender hos tilknyttede virksomheder
5810            Langfristede tilgodehavender hos tilknyttede virksomheder
5840            Nedskrivning på langfristede tilgodehavender hos tilknyttede virksomheder
Sum 5810-5879   Langfristede tilgodehavender hos tilknyttede virksomheder
                Andre værdipapirer og kapitalandele
5890            Andre værdipapirer og kapitalandele
Sum 5890-5899   Andre værdipapirer og kapitalandele
                Andre (langfristede) tilgodehavender
5910	            Udskudte skatteaktiver
5930	            Øvrige (langfristede) tilgodehavender
5950	            Deposita
Sum 5910-5999   Andre (langfristede) tilgodehavender
                Tilgodehavender hos virksomhedsdeltagere og ledelse
6010	            Tilgodehavender hos virksomhedsdeltagere og ledelse
Sum 6010-6099   Tilgodehavender hos virksomhedsdeltagere og ledelse
Sum 5810-6099   Finansielle anlægsaktiver
                Finansielle anlægsaktiver
                Anlægsaktiver i alt
                Omsætningsaktiver
                Varebeholdninger
                Råvarer og hjælpematerialer
6110            Råvarer og hjælpematerialer
6130            Nedskrivning på råvarer og hjælpematerialer
Sum 6110-6149   Råvarer og hjælpematerialer
                Varer under fremstilling
6160	            Varer under fremstilling
6180	            Nedskrivning på varer under fremstilling
Sum 6160-6199   Varer under fremstilling
                Fremstillede varer og handelsvarer
6210            Fremstillede varer og handelsvarer
6230            Nedskrivning på fremstillede varer og handelsvarer
Sum 6210-6249   Fremstillede varer og handelsvarer
                Forudbetalinger for varer
6260	            Forudbetalinger for varer
Sum 6260-6289   Forudbetalinger for varer
Sum 6110-6289   Varebeholdninger
                Tilgodehavender
                Tilgodehavender fra salg og tjenesteydelser
6310	            Tilgodehavender fra salg og tjenesteydelser
6330	            Akkumulerede nedskrivninger til tab på tilgodehavender fra salg og tjenesteydelser
Sum 6310-6349   Tilgodehavender fra salg og tjenesteydelser
                Kortfristede tilgodehavender hos tilknyttede virksomheder
6360	            Kortfristede tilgodehavender hos tilknyttede virksomheder
6380	            Akkumulerede nedskrivninger til tab på tilgodehavender fra tilknyttede virksomheder
Sum 6360-6399   Kortfristede tilgodehavender hos tilknyttede virksomheder
                Igangværende arbejder for fremmed regning
6410            Igangværende arbejder for fremmed regning
Sum 6410-6419   Igangværende arbejder for fremmed regning
                Andre tilgodehavender (kortfristede)
6430            Udskudte skatteaktiver
6450            Tilgodehavende selskabsskat (kortfristet)
6470            Tilgodehavende moms (kortfristet)
6490            Øvrige tilgodehavender (kortfristede)
Sum 6430-6509   Andre tilgodehavender (kortfristede)
                Krav på indbetaling af virksomhedskapital og overkurs
6520	            Krav på indbetaling af virksomhedskapital og overkurs
Sum 6520-6539   Krav på indbetaling af virksomhedskapital og overkurs
                Kortfristede tilgodehavender hos virksomhedsdeltagere og ledelse
6550	            Kortfristede tilgodehavender hos virksomhedsdeltagere og ledelse
Sum 6550-6569   Kortfristede tilgodehavender hos virksomhedsdeltagere og ledelse
                Periodeafgrænsningsposter
6580	            Periodeafgrænsningsposter
Sum 6580-6599   Periodeafgrænsningsposter
Sum 6310-6599   Tilgodehavender
                Værdipapirer og kapitalandele
                Andre værdipapirer og kapitalandele
6610	            Andre værdipapirer og kapitalandele
Sum 6610-6629   Andre værdipapirer og kapitalandele
Sum 6610-6629   Værdipapirer og kapitalandele
                Likvide beholdninger
6640	            Likvide beholdninger
Sum 6640-6689   Likvide beholdninger
                Omsætningsaktiver i alt
                AKTIVER I ALT
                PASSIVER
                Egenkapital
                Virksomhedskapital
6710	            Registreret kapital mv.
6730	            Indbetalt registreret kapital mv.
Sum 6710-6749   Virksomhedskapital
                Overkurs ved emission
6760	            Overkurs ved emission
Sum 6760-6799   Overkurs ved emission
                Andre reserver
6810            Reserve for udlån og sikkerhedsstillelse
6830            Reserve for ikke indbetalt virksomhedskapital og overkurs
6850            Reserve for iværksætterselskaber
6870            Øvrige lovpligtige reserver
6890            Vedtægtsmæssige reserver
6910            Øvrige reserver
Sum             6810-6919	Andre reserver
                Overført resultat
6930	            Overført resultat
Sum 6930-6949   Overført resultat
                Foreslået udbytte indregnet under egenkapitalen
6960	            Foreslået udbytte indregnet under egenkapitalen
Sum 6960-6999   Foreslået udbytte indregnet under egenkapitalen
                Egenkapital i alt
                Hensatte forpligtelser
                Hensættelse til udskudt skat
7010	            Hensættelser til udskudt skat
Sum 7010-7029   Hensættelse til udskudt skat
                Andre hensatte forpligtelser
7040	            Andre hensatte forpligtelser
Sum 7040-7099   Andre hensatte forpligtelser
Sum 7010-7099   Hensatte forpligtelser
                Langfristet gæld
                Gæld til kreditinstitutter - langfristet gæld
7110	            Gæld til kreditinstitutter - langfristet gæld
7130	            Gæld til banker - langfristet gæld
Sum 7110-7149   Gæld til kreditinstitutter
                Gæld til tilknyttede virksomheder - langfristet gæld
7160	            Gæld til tilknyttede virksomheder - langfristet gæld
Sum 7160-7179   Gæld til tilknyttede virksomheder - langfristet gæld
                Anden gæld, herunder skyldige skatter og skyldige bidrag til social sikring
7190	            Anden gæld - langfristet
7210	            Gæld til selskabsdeltagere og ledelse - langfristet gæld
7230	            Deposita - langfristet gæld
7250	            Selskabsskat - langfristet gæld
Sum 7190-7299   Anden gæld, herunder skyldige skatter og skyldige bidrag til social sikring
Sum 7110-7299   Langfristet gæld
                Langfristet gæld
                Kortfristet gæld
                Gæld til kreditinstitutter - kortfristet gæld
7310	            Gæld til kreditinstitutter - kortfristet gæld
7330	            Gæld til banker - kortfristet gæld
7350	            Kreditinstitutter i øvrigt
Sum 7310-7399   Gæld til kreditinstitutter - kortfristet gæld
                Modtagne forudbetalinger fra kunder
7410	            Modtagne forudbetalinger fra kunder
Sum 7410-7429   Modtagne forudbetalinger fra kunder
                Leverandører af varer og tjenesteydelser
7440            Leverandører af varer og tjenesteydelser
Sum 7440-7499   Leverandører af varer og tjenesteydelser
                Gæld til tilknyttede virksomheder - kortfristet gæld
7510	            Gæld til tilknyttede virksomheder - kortfristet gæld
Sum 7510-7559   Gæld til tilknyttede virksomheder - kortfristet gæld
                Anden gæld, herunder skyldige skatter og skyldige bidrag til social sikring
7590            Gæld til selskabsdeltagere og ledelse - kortfristet gæld
7610            Deposita - kortfristet gæld
7630            Leasingforpligtelse - kortfristet
7680            Salgsmoms
7700            Moms af varekøb udland, EU og ikke-EU
7720            Moms af ydelseskøb udland, EU og ikke-EU
7740            Købsmoms
7760            Olie- og flaskegasafgift
7780            Elafgift
7800            Naturgas- og bygasafgift
7820            Vandafgift
7840	            Skyldig moms
7860	            Skyldig løn og gager
7880	            Skyldig bonus og tantieme
7900	            Skyldige feriepenge
7920	            Skyldig A-skat
7940	            Skyldigt AM-bidrag
7960	            Skyldigt ATP-bidrag
7980	            Skyldigt AMP-bidrag
8000	            Anden skyldig pension
8040	            Øvrig anden gæld
Sum 7680-8059   Anden gæld (kortfristet gæld)
                Periodeafgrænsningsposter
8070            Periodeafgrænsningsposter
Sum 8070-8099   Periodeafgrænsningsposter
                Kortfr istet gæld
                PASSIVER I ALT 









Account         Name
                INCOME STATEMENT
                
                Net turnover
1010	            Sale of goods and services w/ VAT
1050	            Sale of goods abroad, EU
1100	            Sale of goods abroad, non-EU
1150	            Sale of services abroad, EU
1200	            Sale of services abroad, non-EU
1250	            Sales not subject to VAT
Sum 1010-1399   Net turnover
                Change in inventories of finished goods and goods in progress
1410	            Inventory regulation
1430	            Write-down of inventory
1460	            Other changes in inventory
Sum 1410-1499   Change in stocks of finished goods and goods in progress
                other operating income
1510	            Gain on sale of intangible fixed assets
1530	            Gain on sale of tangible fixed assets
1550	            Other other operating income
Sum 1510-1599   Other operating income
                Costs for raw materials and auxiliary materials
1610	            Purchase of goods w/ VAT
1630	            Purchase of goods abroad, EU
1650	            Purchase of goods abroad, non-EU
1670	            Purchase of goods without VAT
Sum 1610-1699   Costs for raw materials and auxiliary materials
                Other external costs
                Selling costs
1710	            Shipping costs
1730	            Advertising and advertising
1750	            Exhibitions and decoration
1770	            Restoration visit
1790	            Representation costs, tax-limited deduction
1810	            Representation costs, fully tax deductible
1830	            Other selling expenses
1850	            Gifts and flowers
Sum 1710-1899   Selling costs
                Local costs
1910	            Rent, excl. electricity, water and heating / with VAT
1930	            Rent, excl. electricity, water and heating / without VAT
1950	            El
1970	            Electricity tax
1990	            Water
2010	            Heat
2030	            Oil and bottled gas tax
2050	            Natural gas and city gas tax
2070	            Other charges
2090	            Cleaning and renovation
2110	            Repair and maintenance
2130	            Insurances
2150	            Property taxes
2170	            Other premises costs
Sum 1910-2199   Local costs
                Administration costs
2210	            Small acquisitions below the tax limit for small assets
2230	            Small acquisitions above the tax limit for small assets
2250	            Subcontractors
2270	            Research and development costs
2290	            Other production costs
2310	            Established losses on receivables from sales and services
2330	            Regulation of write-down of receivables from sales and services
2350	            Adjustment of receivables from associated companies and associated companies
2370	            IT equipment etc.
2390	            Tax-free travel and transport allowance
2410	            Dues
2430	            Nonfiction
2450	            Postage and fees, excluding VAT
2470	            Postage and fees, including VAT
2490	            Telephone, internet, etc. at the company's address (company only)
2510	            Mobile telephony, internet etc., acquisition and subscription (partly private)
2530	            Office supplies
2550	            Rent and operational leasing services (excluding rent)
2570	            Travel expenses
2590	            Temporary assistance
2610	            Consulting services
2630	            Course expenses
2650	            Operating costs, passenger cars (deductible for VAT)
2670	            Operating costs, passenger cars (non-deductible for VAT)
2690	            Operating costs, vans
2710	            Workers' compensation insurance
2730	            Public charges and fines (not tax deductible)
2750	            Audit and accounting assistance
2770	            Legal assistance
2790	            Other advisory fees
2810	            Administration fee/management fee
2830	            Ear rounding/case differences
2850	            Other external costs, including VAT
2870	            Other external costs, excluding VAT
Sum 2210-2899   Administration costs
Sum 1710-2899   Other external costs
                Gross Profit/Gross Loss
                Personnel costs
2910	            Wages
2930	            Holiday pay obligation
2950	            Jubilee gratuity and severance pay
2970	            Board fee
2990	            Contributory income
3010	            Contribution-free a-income
3030	            Pensions
3050	            Remuneration for replacing pension commitments
3070	            Social security costs
3090	            AER/ AUB
3110	            ATP
3130	            Other personnel costs
Total 2910-3149 Personnel costs
                Depreciation and write-downs of tangible and intangible fixed assets
3160            Depreciation and write-downs of acquired intangible fixed assets
3180            Depreciation and impairment of goodwill
3200            Depreciation and write-downs of land and buildings
3220            Depreciation and write-downs of production facilities and machinery
3240            Depreciation and write-downs of furnishings of rented premises
3260            Depreciation and write-downs of other plants, operating equipment and inventory
3280            Depreciation and write-downs of software
Sum 3160-3299   Depreciation and write-downs of tangible and intangible fixed assets
                Other operating costs
3310            Loss on sale of intangible fixed assets
3330            Loss on sale of tangible fixed assets
3350            Other other operating costs
Sum 3310-3369   Other operating costs
                Income from other capital shares, securities and receivables that are fixed assets
3380            Dividends from unlisted portfolio shares
3400            Other income from other capital shares, securities and receivables that are fixed assets
Sum 3380-3419   Income from other capital shares, securities and receivables that are fixed assets
                Other financial income from affiliated companies
3440            Other financial income from affiliated companies
Sum 3440-3459   Other financial income from affiliated companies
                Other financial income
3470            Interest from banks
3490            Interest on receivables from sales of goods and services
3510            Interest supplement etc. from the public sector (non-taxable)
3530            Other financial income
Sum 3470-3549   Other financial income
                Impairment of financial assets
3560            Impairment of financial assets
Sum 3560-3579   Impairment of financial assets
                Financial costs arising from affiliated companies
3590            Financial costs arising from affiliated companies
Sum 3590-3599   Financial costs arising from affiliated companies
                Other financial expenses
3610            Exchange rate adjustments
3630            Exchange rate loss on liquid assets, bank debt and priority debt
3650            Interest on Suppliers of goods and services
3670            Interest for banks and mortgage institutions
3690            Other financial costs
Sum 3610-3729   Other financial costs
                The result before taxes
                Income tax expense
3740            Current tax
3760            Change in deferred tax
3780            Regulation regarding previous years
Sum 3740-3799   Tax on the year's profit
                Other taxes
3810            Other taxes
Sum 3810-3849   Other taxes
                The result of the year



Account Name
                BALANCE
                
                ACTIVE
                Fixed assets
                Intangible fixed assets
                Goodwill
5110            Goodwill, book value primo
5130            Goodwill, year's approaches
5150            Goodwill, other value adjustments
5170            Goodwill, the year's depreciation and write-downs
Total 5110-5199 Goodwill, end of year
                Acquired intangible fixed assets
5210            Acquired intangible fixed assets, book value primo
5230            Acquired intangible fixed assets, additions for the year
5250            Acquired intangible fixed assets, other value adjustments
5270            Acquired intangible fixed assets, depreciation and write-downs for the year
Sum 5210-5299   Acquired intangible fixed assets, end of year
                Intangible fixed assets
                Tangible fixed assets
                Land and buildings
5310            Land and buildings, book value primo
5330            Land and buildings, the year's additions
5350            Land and buildings, improvements for the year
5370            Land and buildings, other value adjustments
5390            Land and buildings, depreciation and write-downs for the year
Sum 5310-5399   Land and buildings, end of year
                Production plants and machines
5410            Production plant and machinery, book value primo
5430            Production plant and machinery, year's additions
5450            Production plant and machinery, other value adjustments
5470            Production plant and machinery, depreciation and write-downs for the year
Sum 5410-5499   Production plant and machinery, end of year
                Furnishing of rented premises
5510            Furnishing of rented premises, book value primo
5530            Furnishing of rented premises, the year's additions
5550            Furnishing of rented premises, other value adjustments
5570            Furnishing of rented premises, depreciation and write-downs for the year
Sum 5510-5599   Furnishing of rented premises, end of year
                Other fixtures and fittings
5610            Other plant, operating equipment and fixtures, book value primo
5630            Other facilities, drift equipment and inventory, the year's approaches
5650            Other plant, operating equipment and inventory, other value adjustments
5670            Other plant, operating equipment and inventory, depreciation and write-downs for the year
Sum 5610-5699   Other plant, operating equipment and inventory, end of year
                Property, plant and equipment under construction and prepayments for property, plant and equipment
5710            Tangible fixed assets under construction and prepayments for tangible fixed assets, book value primo
5730            Tangible fixed assets in progress and prepayments for tangible fixed assets, additions for the year
5750            Tangible fixed assets under construction and prepayments for tangible fixed assets, other value adjustments
5770            Tangible fixed assets under construction and prepayments for tangible fixed assets, write-downs for the year
Sum 5710-5799   Tangible fixed assets under construction and prepayments for tangible fixed assets, year-end
                Tangible fixed assets
                Financial assets
                Long-term receivables from affiliated companies
5810            Long-term receivables from affiliated companies
5840            Impairment of long-term receivables from affiliated companies
Sum 5810-5879   Long-term receivables from affiliated companies
                Other securities and capital shares
5890            Other securities and capital shares
Sum 5890-5899   Other securities and capital shares
                Other (long-term) receivables
5910            Deferred tax assets
5930            Other (long-term) receivables
5950            Deposits
Sum 5910-5999   Other (long-term) receivables
                Receivables from company participants and management
6010            Receivables from company participants and management
Sum 6010-6099   Receivables from company participants and management
Sum 5810-6099   Financial fixed assets
                Financial assets
                Total fixed assets
                Current assets
                Inventories
                Raw materials and auxiliary materials
6110            Raw materials and auxiliary materials
6130            Impairment of raw materials and consumables
Sum 6110-6149   Raw materials and auxiliary materials
                Products being manufactured
6160            Goods under manufacture
6180            Impairment of goods under manufacture
Sum 6160-6199   Goods in progress
                Manufactured goods and trade goods
6210            Manufactured goods and merchandise
6230            Impairment of manufactured goods and trade goods
Sum 6210-6249   Manufactured goods and trade goods
                Advance payments for goods
6260            Advance payments for goods
Sum 6260-6289   Advance payments for goods
Total 6110-6289 Inventories
                Receivables
                Receivables from sales and services
6310            Receivables from sales and services
6330            Accumulated write-downs for losses on trade and service receivables
Sum 6310-6349   Receivables from sales and services
                Short-term receivables from affiliated companies
6360            Short-term receivables from affiliated companies
6380            Accumulated write-downs for losses on receivables from affiliated companies
Sum 6360-6399   Short-term receivables from affiliated companies
                Ongoing work for others
6410            Work in progress for another's account
Sum 6410-6419   Work in progress for another's account
                Other receivables (short-term)
6430            Deferred tax assets
6450            Corporation tax receivable (short-term)
6470            VAT receivable (short-term)
6490            Other receivables (short-term)
Sum 6430-6509   Other receivables (short-term)
                Demand for payment of company capital and premium
6520            Demand for payment of company capital and premium
Sum 6520-6539   Demand for payment of company capital and premium
                Short-term receivables from company participants and management
6550            Short-term receivables from company participants and management
Sum 6550-6569   Short-term receivables from company participants and management
                Period accruals
6580            Period accruals
Sum 6580-6599   Period deferred items
Total 6310-6599 Receivables
                Securities and capital shares
                Other securities and capital shares
6610            Other securities and equity
Sum 6610-6629   Other securities and capital shares
Sum 6610-6629   Securities and capital shares
                Liquid assets
6640            Liquid assets
Total 6640-6689 Liclear stocks
                Total current assets
                TOTAL ASSETS
                PASSIVES
                Equity
                Company capital
6710            Registered capital, etc.
6730            Paid-in registered capital, etc.
Sum 6710-6749   Company capital
                Premium on issue
6760            Premium on issue
Sum 6760-6799   Premium on issue
                Other reserves
6810            Reserve for lending and collateral
6830            Reserve for unpaid company capital and premium
6850            Reserve for entrepreneurial companies
6870            Other statutory reserves
6890            Statutory reserves
6910            Other reserves
Sum 6810-6919   Other reserves
                Transfered result
6930            Transferred result
Sum 6930-6949   Transferred result
                Proposed dividend recognized under equity
6960            Proposed dividend recognized under equity
Sum 6960-6999   Proposed dividend recognized under equity
                Total capital and reserves
                Provisions
                Provision for deferred tax
7010            Provisions for deferred tax
Sum 7010-7029   Provision for deferred tax
                Other provisional duties
7040            Other provisions
Sum 7040-7099   Other provisions
Total 7010-7099 Provisions
                Long term debt
                Debt to credit institutions - long-term debt
7110            Debt to credit institutions - long-term debt
7130            Debt to banks - long-term debt
Sum 7110-7149   Debt to credit institutions
                Debt to affiliated companies - long-term debt
7160            Debt to affiliated companies - long-term debt
Sum 7160-7179   Debt to affiliated companies - long-term debt
                Other debts, including due taxes and due contributions to social security
7190            Other debt - long-term
7210            Debt to shareholders and management - long-term debt
7230            Deposita - long-term debt
7250            Corporation tax - long-term debt
Sum 7190-7299   Other debts, including due taxes and due contributions to social security
Sum 7110-7299   Long-term debt
                Long term debt
                Short-term debt
                Debt to credit institutions - short-term debt
7310            Debt to credit institutions - short-term debt
7330            Debt to banks - short-term debt
7350            Other credit institutions
Sum 7310-7399   Debt to credit institutions - short-term debt
                Received advance payments from customers
7410            Advance payments received from customers
Sum 7410-7429   Advance payments received from customers
                Suppliers of goods and services
7440            Suppliers of goods and services
Sum 7440-7499   Suppliers of goods and services
                Debt to affiliated companies - short-term debt
7510            Debt to affiliated companies - short-term debt
Sum 7510-7559   Debt to affiliated companies - short-term debt
                Other debts, including due taxes and due contributions to social security
7590            Debt to shareholders and management - short-term debt
7610            Deposita - short-term debt
7630            Lease obligation - short-term
7680            Sales tax
7700            VAT on purchases abroad, EU and non-EU
7720            VAT on purchases of services abroad, EU and non-EU
7740            Purchase VAT
7760            Oil and bottled gas tax
7780            Electricity tax
7800            Natural gas and city gas tax
7820            Water tax
7840            VAT due
7860            Wages and wages due
7880            Bonus and royalty owed
7900            Holiday pay owed
7920            Due A tax
7940            Due AM contribution
7960            Due ATP contribution
7980            Due AMP contribution
8000            Other pension due
8040            Other other debts
Sum 7680-8059   Other debt (short-term debt)
                Period accruals
8070            Period accruals
Sum 8070-8099   Period deferred items
                Short-term debt
                TOTAL LIABILITIES

*/
?>
