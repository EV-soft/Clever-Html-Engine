<? $DocFile='../Proj1/page.menu.php';    $DocVers='5.0.0';    $DocRev1='2020-03-24';     $DocIni='evs';  $ModulNo=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 

// TopMenu-rutiner: (benyttes i Menu_Topdropdown )
function MenuStart($clas='firstmain',$href='#',$labl='',$titl='') {  //  SKAL efterfølges af MenuSlut()
  echo "\n";
  echo '<div id="container" style="display:inline-block;">';  // style/css: se filen _base/htm_TopMenu-head.css.htm
// Responsive-menu! if (smal skærm) width:120px; else width:1200px;
// Lavet med CSS i /_base/htm_TopMenu-head.css.htm
  echo '  <data-menu id="wb_TopMenu" style="display:inline-block; position:fixed; left:auto; top:1px;  height:24px; z-index:999;">';  //  width:'.$menuwd.';
  echo '    <ul>';
  echo '      <li class="'.$clas.'" style="color:black; width:20px; text-align:left;"><a href="'.$href.'" target="_self" style="background:#EEEEEE;" data-tiptxt="'.tolk($titl).'">'.tolk($labl).'</a> </li>';
}
function MenuGren($clas='',$href='#',$labl='',$titl='',$more='') {
  if ($href=='../_base/page_Blindgyden.php') {$blnd='<i style="font-color:gray;">'; $obs='<small> '.tolk('@påtænkt!').'</small>';} else {$blnd=''; $obs='';};
  if ($clas=='exit') /*(strpos($labl,'Log ud')>0)*/ {$bold='<span style="color:red; font-weight:600; left: -110px;">'; } else {$bold='';};
  if (strpos($href,'ttp' )>0) $targ='_blank'; else $targ='_self'; //  Test om http forekommer (externt/lokalt link?)
  $link= 'href="'.$href.'" target="'.$targ.'" title="" data-tiptxt="'.strip_tags(tolk($titl)).'" >'.$blnd.$bold.ucfirst(tolk($labl));
  if ($bold!='') {$link.= '</span>'.$obs;}
  if ($blnd!='') {$link.= '</i>'.$obs;} else {$link.= $obs;}
  echo "\n\n";
  switch ($clas) {
    case 'withsubmenu': echo '<li><a class="'.$clas.'"    '.$more.$link.'</a>  <ul>'; break;
    case 'firstitem':   echo '<li    class="'.$clas.'"><a '.$more.$link.'</a> </li>'; break;
    case 'exit':        echo '<li    class="'.$clas.'"><a '.$more.$link.'</a> </li>'; break;
    case '':            echo '<li>                     <a '.$more.$link.'</a> </li>'; break;
    case 'lastitem':    echo '<li    class="'.$clas.'"><a '.$more.$link.'</a> </li></ul></li>'; break;
    default :           ;
  }
}
function MenuSlut() {global $ØProgRoot, $ØProgTitl, $Øprogvers, $Øcopydate, $Øcopyright, $Ødesigner;
  //echo "\n";
  echo '    </ul>';
  echo Lbl_Tip($labl='@Lokal menu',$titl='@Alle panelers overskrift, virker som lokale menupunkter i det aktuelle vindue. Klik på panel-overskriften, for at vise/skjule panelets indhold.','SW').' ';
  echo '<span style="text-align: right;" title="'.$ØProgTitl.' - Version '.$Øprogvers.' - Copyright '. $Øcopydate.' '.$Øcopyright.' - '.tolk('@Design: ').$Ødesigner.'" ><img src= "'.
        $ØProgRoot.'_assets/images/saldi-e50x170.png " alt="Logo" height="40" style="top:2px; position:absolute;" >',$GLOBALS['smiley'],'</span>';
  echo '  <br>';
  echo '  </data-menu>';
  echo '</div>';
  echo "\n";
}

function Menu_Topdropdown($vis_finans=true, $vis_debitor=true, $vis_kreditor=true, $vis_prodkt=false, $vis_lager=true, $add_on=false) { //  Menu-placering/størrelse styres i MenuStart()
global $Ødebug, $ØProgTitl, $_assets, $_base, $_config, $_debitor, $_exchange, $_finans, $_kreditor, $_lager, $_produktion, $_system, $_temp, $_userlib, $_xtra;  
    MenuStart($clas='firstmain',    $href='../_base/page_Hovedmenu.php',                $labl='@MENU:',               $titl='@Programmets hovedmenu');
    if ($vis_finans) {        
      MenuGren($clas='withsubmenu', $href='',                                           $labl='@FINANS',              $titl='@Administration af regnskab');
      MenuGren($clas='firstitem',   $href= $_finans.'page_Kladdeliste.php',             $labl='@Kasse kladder',       $titl='@Her kan du vælge kassekladde, og redigere den');
      MenuGren($clas='',            $href= $_finans.'page_Regnskab.php',                $labl='@Regnskab',            $titl='@Se det aktuelle regnskab her');
      MenuGren($clas='',            $href= $_finans.'page_Budget.php',                  $labl='@Budget',              $titl='@Se og rediger budget');
      MenuGren($clas='',            $href= $_system.'page_Kontoplan.php?chg=ok',        $labl='@Se kontoplan',        $titl='@Her kan du se den aktuelle kontoplan');
      MenuGren($clas='lastitem',    $href= $_finans.'page_Rapport-fin.php',             $labl='@Rapporter',           $titl='@Her vælger du hvad du vil se i en rapport');
    }             
    if ($vis_debitor) {       
    MenuGren($clas='withsubmenu',   $href='',                                           $labl='@DEBITOR',             $titl='@Her finder du det, der angår dine Kunder');
      MenuGren($clas='firstitem',   $href= $_debitor.'page_Opretordre.php',             $labl='@Ny ordre...',         $titl='@Opret en ny salgs ordre...');
      MenuGren($clas='',            $href= $_debitor.'page_Ordreliste-deb.php',         $labl='@Salgs ordrer',        $titl='@Oversigt over ordrer og deres indhold');
      MenuGren($clas='',            $href= $_debitor.'page_Debitor.php',                $labl='@Kunde konti',         $titl='@Oversigt over kunder, og leverancer til disse');
      MenuGren($clas='lastitem',    $href= $_debitor.'page_Rapport-deb.php',            $labl='@Rapporter',           $titl='@Analyser af salg');
    }             
    if ($vis_kreditor) {        
    MenuGren($clas='withsubmenu',   $href=' ',                                          $labl='@KREDITOR',            $titl='@Her finder du det, der angår dine Leverandører');
      MenuGren($clas='firstitem',   $href= $_kreditor.'page_Ordreliste-kre.php',        $labl='@Nyt-indkøb...',       $titl='@Opret en ny købs ordre...');
      MenuGren($clas='',            $href= $_kreditor.'page_Ordreliste-kre.php',        $labl='@Købs ordrer',         $titl='@Oversigt over leverandører');
      MenuGren($clas='',            $href= $_kreditor.'page_Kreditor.php',              $labl='@Leverandør konti',    $titl='@Oversigt over kreditorer og oplysninger om disse');
      MenuGren($clas='lastitem',    $href= $_kreditor.'page_Rapport-kre.php',           $labl='@Rapporter',           $titl='@Analyser af køb');
                
    }             
    if ($vis_prodkt) {        
      MenuGren($clas='withsubmenu', $href=' ',                                          $labl='@PRODUKTION',          $titl='@Rutiner angående produktion');
      MenuGren($clas='lastitem',    $href= $_lager.'page_Beholdningsliste.php',         $labl='@Rapporter',           $titl='@Analyser over produktion');
    }       
    if ($vis_lager) {       
    MenuGren($clas='withsubmenu',   $href=' ',                                          $labl='@LAGER',               $titl='@Rutiner angående lagerførte produkter');
      MenuGren($clas='firstitem',   $href= $_lager.'page_Varer.php',                    $labl='@Vare lager',          $titl='@Oversigt over salgsvarer, samt detaljer på varekort');
      MenuGren($clas='',            $href= $_lager.'page_Varemodtagelse.php',           $labl='@Vare modtagelse',     $titl='@Lister for varemodtagelse');
      MenuGren($clas='lastitem',    $href= $_lager.'page_Beholdningsliste.php',         $labl='@Rapporter',           $titl='@Analyser af varesalg m.v.');
    }       
    if (true) {       
    MenuGren($clas='withsubmenu',   $href=' ',                                          $labl='@SYSTEM',              $titl='@Her indstiller du programmet og regnskabet');
      MenuGren($clas='firstitem',   $href= $_system.'page_Kontoplan.php?chg=no',        $labl='@Kontoplan',           $titl='@Her vedligeholder du den aktuelle kontoplan');
      MenuGren($clas='withsubmenu', $href=' ',                                          $labl='@Indstillinger &nbsp; =>', $titl='@Indstillinger for programmet');
        MenuGren($clas='firstitem', $href= $_system.'page_Valuta.php',                  $labl='@1. indstil-ofte',     $titl='@Her har du de hyppigst benyttede indstillinger');
        MenuGren($clas='',          $href= $_system.'page_Divsetup2.php',               $labl='@2. indstil-flere',    $titl='@Her har du de sjældnere benyttede indstillinger');
        MenuGren($clas='lastitem',  $href= $_system.'page_Tilvalgsetup3.php',           $labl='@3. indstil-extra',    $titl='@Her aktiverer og indstiller tilvalgs funktioner');
      MenuGren($clas='',            $href= $_system.'page_Backup.php',                  $labl='@Sikkerheds kopiering',$titl='@Her kan du sikre dig dine regnskabsdata, bilags filer og programinstallation');
      MenuGren($clas='',            $href= $_system.'page_Licens.php',                  $labl='@Om programmet',       $titl='@Her finder du oplysninger om programmet, og serveren det kører på');
      MenuGren($clas='lastitem',    $href= $_system.'page_Regnskabet.php',              $labl='@Om regnskabet',       $titl='@Her finder du oplysninger om regnskabet, som du aktuelt arbejder på');
    }       
    if ($add_on) {        
    MenuGren($clas='withsubmenu',   $href=' ',                                          $labl='@UDVIDELSER',          $titl='@Rutiner angående tilføjede program udvidelser');
      MenuGren($clas='firstitem',   $href= $_xtra.'page_Kasse.php',                     $labl='@Kasse system POS',    $titl='@xxx');
      MenuGren($clas='',            $href= $_xtra.'page_xxxxxxxxxxxxxx.php',            $labl='@xxxxx',               $titl='@xxx');
      MenuGren($clas='lastitem',    $href= $_xtra.'page_xxxxxxxxxxxxxx.php',            $labl='@xxxxx',               $titl='@xxx');
    }
    if (true) {
      MenuGren($clas='withsubmenu', $href=' ',                                          $labl='@EKSTRA',              $titl='@Bogholderens redskaber');
        MenuGren($clas='firstitem', $href= $_assets.'Calculator/strimmelcalc.php?ttp',  $labl='@Strimmelregner',      $titl='@Start en simpel kalkulator');
        MenuGren($clas='',          $href= $_base.'page_Blindgyden.php',                $labl='@Notesblok',           $titl='@Start en simpel skrivemaskine');
        MenuGren($clas='',          $href= $_assets.'tfm\TFM-user.php?ttp',             $labl='@Fil-Manager',         $titl='@Browse/editere bruger filer.');
        MenuGren($clas='',          $href= $_base.'page_Tips.php',                      $labl='@Tips',                $titl=tolk('@Her er der nyttige tips, til brugen af').$ØProgTitl);
        MenuGren($clas='',          $href= $_base.'_intro/intro.html',                  $labl='@Introduktion',        $titl='@Her redegøres for de kommende forbedringer i version 5.0 -'.$ØProgTitl);
        MenuGren($clas='',          $href= $_base.'page_News.php',                      $labl='@Nyheder',             $titl='@Her omtales nogle af de nyheder, der er tilføjet i den nye'.$ØProgTitl);
        MenuGren($clas='lastitem',  $href='http://www.ev-soft.dk/saldi-wiki/doku.php?id=saldi:manualen', 
                                                                                        $labl='@DokuWiki - Manual',   $titl=tolk('@Manual, tips og anden hjælp finder du på').$ØProgTitl.tolk('@-DokuWiki (åbner i nyt vindue)'));  
    }// d:\CloudSt-SALDI\saldi-e\_assets\tinyfilemanager-master\tinyfilemanager.php
    if ($Ødebug) { // Programmers tools:
      MenuGren($clas='withsubmenu', $href= ' ',                                         $labl='@TOOLS',               $titl='@Udviklerens redskaber');
        MenuGren($clas='firstitem', $href= $_assets.'tfm\tinyfilemanager.php?ttp',      $labl='@Fil-Manager',         $titl='@Browse/editere installationens filer. &#xa; For programmører!');
        MenuGren($clas='',          $href= $_base.'_tools/frasescann.php',              $labl='@Frase-skanning',      $titl='@Skanning efter danske fraser, som skal oversættes');
        MenuGren($clas='',          $href= $_base.'_tools/funcscann.php',               $labl='@Funktions-skanning',  $titl='@Skanning efter funktions navne, og parametre');
        MenuGren($clas='',          $href= $_base.'_tools/docscann.php',                $labl='@Ord-skanning...',     $titl='@Skanning efter et angivet ord, f.eks. $DocFil');
        MenuGren($clas='',          $href= '../modulscann.php',                         $labl='@Modul-skanning...',   $titl='@Skanning af alle primære htm/php-filer - vis status mv.');
        MenuGren($clas='',          $href= '../pladsforbrug.php',                       $labl='@Mappe-skanning...',   $titl='@Skanning af alle mappers størrelse');
        MenuGren($clas='lastitem',  $href= $_base.'page_Printlayout.php',               $labl='@Side test...',        $titl='@Test af sider under udvikling');
    }
    if (true) {
        MenuGren($clas='exit',      $href='../_base/page_Startup.php', 
                                    $labl='<i class="fas fa-sign-out-alt" style="font-size:16px; color: red; " ></i> '.tolk('@Log ud'),  
                                    $titl=tolk('@Forlad').$ØProgTitl.str_lf().tolk('@i låst tilstand.'),$more=' style="background:white; width:70px; box-shadow:3px 3px 1px #EDEDED;" ');
    }
  MenuSlut();
  //echo '<br>XXX';
}
 
?>