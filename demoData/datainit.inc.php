<?php // /demoData/datainit.inc.php

function DEB_Grup () { return( [
		['1', '@1. Danske debitorer',        '@1. Danske debitorer'],
		['2', '@2. Europæiske debitorer',    '@2. Europæiske debitorer']
	]  );
}
function DEB_Betl () { return( [
		['1', '@Kontant',       '@Kontant'],
		['2', '@Efterkrav',     '@Efterkrav'],
		['3', '@Forud',         '@Forud'],
		['4', '@Kreditkort',    '@Kreditkort'],
		['5', '@Lb. måned',     '@Lb. Md.'],
		['6', '@Konto',         '@Konto']
	]  );
}
function DEB_Frist () { return( [
		['0',  '@Straks',  '@Betaling øjeblikkelig' ],
		['8',  '@8 dage',  '@Betaling inden 8 dage' ],
		['14', '@14 dage', '@Betaling inden 14 dage'],
		['30', '@30 dage', '@Betaling inden 30 dage']
	]  );
}
function DEB_Dok () { return( [
		['pdf',   '@PDF-fil','@Fil i pdf-format'       ],
		['email', '@email',  '@Elektronisk forsendelse'],
		['ioubl', '@OIOUBL', '@Elektronisk fakturering'],
		['pbs',   '@PBS',    '@PBS faktura'            ]
	]  );
}
function CVR_Land () {return( [
		['dk',   '@Denmark',    '@Search the Danish register',   'checked'],
		['no',   '@Norwegian',  '@Search the Norwegian register',   '']
	]  );
}
function CVR_Liste () {return( [  //  vat, name, produ, phone, search
		['search',  '@General',       '@General search: (not tel.)',   ''],
		['vat',     '@CVR',           '@Centralt Virksomheds Register nr', ''],
		['produ',   '@P-unit',        '@Production unit-no',             ''],
		['phone',   '@Phone',         '@Phone number',                   ''],
		['name',    '@Company name',  '@Company name',            'checked']
	]  );
}
function OrdrStatu () {return( [
		['Status',  '@Status',        '@Ordre Status',   'checked'],
		['Offer',   '@Tilbud',        '@Tilbud',   ''],
		['Order',   '@Ordre',         '@Ordre',    ''],
		['Deliv',   '@Afsendt',       '@Afsendt',  ''],
		['Paid',    '@Betalt',        '@Betalt',   '']
	]  );
}
function JourStatu () {return( [
		['posted',    '@Bogført',    '@Journalens Status',   'checked'],
		['simulated', '@Simuleret',  '@Simuleret',   '']
	]  );
}
function UserList () {return( [
		['ej',  '@Ejner',   '@Ejner Jensen',   'checked'],
		['bh',  '@Birgit',  '@Birgit Hansen',   ''],
		['aa',  '@Anders',  '@Anders And',   '']
	]  );
}


function JustListe () {return( [['@V: Venstre justeret','V','@V'],['@C: Center justeret','C','@C'],['@H: Højre justeret','H','@H']] ); }
function FartListe () {return( [['@0: Generelt - f.eks. papirformat','0','@0: Generelt'],['@1: Grafik= Linier og billeder','1','@1: Grafik'], //  FormularArtListe
                                ['@2: Tekster og variabelnavne ($)','2','@2: Tekster'],['@3: Ordrelinier - Gentagende linier på sidens midte (£)','3','@3: Ordrelinier'],
                                ['@5: Mail tekst - Emne og Beskedtekst i mail forsendelse','5','@5: Mail tekst']] ); }
function SideListe () {return( [['@Alle sider','A','@A: Alle sider',''],['@Kun første side','1','@1: Kun første side',''],['@IKKE første side','!1','@!1: IKKE første side',''],
                                ['@Kun sidste side','S','@S: Kun sidste side',''],['@IKKE sidste side','!S','@!S: IKKE sidste side','']] ); }
function Side_List () {return( [['@Alle sider','A','A'],['@Kun første side','1','1'],['@IKKE første side','!1','!1'],
                                ['@Kun sidste side','S','S'],['@IKKE sidste side','!S','!S']] ); }
function FontListe () {return( [['@Sans-serif','Helvetica','Helvetica'],['@Serif','Times','Times'],['@Optisk Læsbar','OCRbb12','OCRbb12']] ); }

// function KontListe () {return( [['@Drifts konto','D','D','Drift'],['@Status konto','S','S','Status'],['@Sum konto','Z','Z','Sum fra'],['@Overskrift (system!)','H','H',' '],
//                                 ['@Resultat konto','R','R','Resultat'],['@Sideskift (system!)','X','X',' '],['@Lukket konto','L','L','Lukket']] ); }
function accoTypeList () {return ([ // 0:value, 1:Label, 2:@ToolTip
    ['Operation', '@Operation', '@Operation account'],      // @Drift
    ['Balance'  , '@Balance'  , '@Balance account'  ],      // @Status
    ['Header'   , '@Header'   , '@Header line'      ],      // @Overskrift
    ['SumFrom'  , '@Sum From' , '@Calc sum from account'],  // @Sum fra
    ['NewPage'  , '@New Page' , '@Separates pages'  ],      // @Sideskift
    ['Result'   , '@Result'   , '@Result account'   ],      // @Resultat
    ['Closed'   , '@Closed'   , '@Closed account'   ]       // @Lukket
    ]); }
                                
// function MomsListe () {return( [['@Købs-moms','K1','K1','Køb 1'],['@Salgs-moms','S1','S1','Salg 1'],['@Ydelses-moms','Y1','Y1','Ydelse 1'],['@EU-moms','E1','E1','Varer 1']] ); } //  '@Momskode: K_:Købs... S_:Salgs... Y_:Ydelses..., E_:Europæisk..., '
function VatList () {return ([
    ['P25', '@P25 Purchase','@Purchase-VAT'],   //['@Købs-moms','K1','K1','Køb 1'],
    ['S25', '@S25 Sale' ,   '@Sale-VAT'],       //['@Salgs-moms','S1','S1','Salg 1'],
    ['V25', '@V25 Service', '@Service-VAT'],    //['@Ydelses-moms','Y1','Y1','Ydelse 1'],
    ['D25', '@D25 Product', '@Product-VAT'],    //['@Vare-moms
    ['E25', '@E25 EU-VAT',  '@Euro-VAT']        //['@EU-moms','E1','E1','Varer 1']
    ]); }

//function StatListe () {return( [['@Aktiv','','@Aktiv'],['@Lukket','on','@Lukket']] ); } // værdi: "on" svarer til Lukket! Alt andet: Aktiv
function StatusList () {return ([
    ['Active',  '@Active','@The account is aktive'],
    ['Closed',  '@Closed','@The account is closed']
    ]); }

function Aar_Liste () {return( [['2016','2016','2016'],['2017','2017','2017'],['2018','2018','2018'],['2019','2019','2019']] ); }
function Grp0Liste () {return( [['@Alle ','0','@0. Alle','']] ); }
function Grp1Liste () {return( [['@Ydelser ','1','@1. Ydelser',''],['@Handelsvarer','2','@2. Handelsvarer',''],
                                ['@Forbrugsvarer', '3','@3. Forbrugsvarer',''],['@Fragt/Porto','4','@4. Fragt/Porto','']] ); }
function Grp_Liste () {return( [['@Alle ','0','@0. Alle',''],['@Ydelser ','1','@1. Ydelser',''],['@Handelsvarer','2','@2. Handelsvarer',''],
                                ['@Forbrugsvarer', '3','@3. Forbrugsvarer',''],['@Fragt/Porto','4','@4. Fragt/Porto','']] ); }
function Afd_Liste () {return( [['@Alle ',        '0','@0. Alle',''],       ['@Forretning ',  '1','@1. Forretning',''],
                                ['@Lager 1 ',     '2','@2. Lager 1',''],    ['@Lager 2 ',     '3','@3. Lager 2','']] ); }
function Slg_Liste () {return( [['@Alle ',        '0','@0. Alle',''],       ['@Revisor ',     '1','@1. Revisor',''],
                                ['@Bogholder ',   '2','@2. Bogholder',''],  ['@Admin ',       '3','@3. Admin','']] ); }                                
function PageListe () {return( [['@A5-Højformat ','A5-portrait','A5-p'],['@A5-bredformat ','A5-landscape','A5-l'],['@A4-Højformat ','A4-portrait','A4-p'],
                                ['@A4-bredformat ','A4-landscape','A4-l'],['@A3-Højformat ','A3-portrait','A3-p'],['@A3-bredformat ','A3-landscape','A3-l']] ); }
function PaprListe () {return( [['@A5 Højformat: H:210mm B:148mm', 'A5p', '@A5 portrait',''], ['@A5 Bredformat: H:148mm B:210mm','A5l', '@A5 landscape',''],
                                ['@A4 Højformat: H:297mm B:210mm', 'A4p', '@A4 portrait',''], ['@A4 Bredformat: H:210mm B:297mm','A4l', '@A4 landscape',''],
                                ['@A3 Højformat: H:420mm B:297mm', 'A3p', '@A3 portrait',''], ['@A3 Bredformat: H:297mm B:420mm','A3l', '@A3 landscape','']] ); }
function FormObjkt () {return( [['@Side layout og placering af ordrelinier',                    '0:Layout',       '@Layout'],
                                ['@Tekster og variabler med data',                              '1:Tekster',      '@Tekster'],
                                ['@Grafiske streger og logo-billede',                           '2:Linjer',       '@Grafik'],
                                ['@Gentagne ordre- eller specikations-linier på siders midte',  '3:Ordrelinjer',  '@Ordrelinjer'],
                                ['@Emne og besked benyttet til mailforsendelse',                '5:Mail tekst',   '@Mail tekst']] ); }
function ValuListe () {return( [['@Danske kroner','DKK','DKK'],['@Euro','EUR','EUR'],['@US dollar','$','$'],['@Engelsk pund','£','£']] ); }
//function ValutaArr () {return( [['@Danske kroner','DKK','@DKK - Danmark - Kroner'],['@Svenske kroner','SEK','@SEK - Sverige - kroner'],  
//                                ['@Norske kroner','NOK','@NOK - Norge - Kroner'],['@Europæisk Euro','EUR','@EUR - EU fællesskabet - Euro'],  
//                                ['@US dollar','USD','@USD - Amerikansk - Dollar'],['@Pund Sterling','GBP','@GBP - Det Forenede Kongerige - Pund']] ); }

function CurrencyArr () {return( [
    ['DKK','@DKK Danish kroner',  '@DKK - Denmark - kroner'],
    ['SEK','@SEK Swedish kroner', '@SEK - Sweden - kroner'],  
    ['NOK','@NOK Norway kroner',  '@NOK - Norway - Kroner'],
    ['EUR','@EUR European Euro',  '@EUR - The EU community - Euro'],  
    ['USD','@USD US dollar',      '@USD - Amerikansk - Dollar'],
    ['GBP','@GBP Pound Sterling', '@GBP - Det Forenede Kongerige - Pund']
    ]); }


?>