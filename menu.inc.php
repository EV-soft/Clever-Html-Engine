<?php $DocFile='../Proj1/menu.inc.php';    $DocVers='1.0.0';    $DocRev1='2020-06-08';     $DocIni='evs';  $ModulNo=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 


// TopMenu-rutines: (used in Menu_Topdropdown )
function MenuStart($clas='firstmain',$href='#',$labl='',$titl='') {  //  MUST be followed of MenuEnd()
  echo "\n";
  echo '<div id="container" style="display:inline-block;">';  // style/css: see the file _base/htm_TopMenu-head.css.htm
// Responsive-menu! if (narrow screen) width:120px; else width:1200px;
// Lavet med CSS i /_base/htm_TopMenu-head.css.htm
  echo '  <data-menu id="wb_TopMenu" style="display: flex; position:fixed; top:1px;  height:24px; width: 800px; z-index:999; justify-content: center; 
            left: 0; right: 0; margin: 0 auto;">';  //  width:'.$menuwd.';
  echo '    <ul>';
  echo '      <li class="'.$clas.'" style="color:black; width:20px; text-align:left;"><a href="'.$href.'" target="_self" style="background:#EEEEEE;" title="'.lang($titl).'">'.lang($labl).'</a> </li>';
}

function MenuEnd() {global $ØProgRoot, $ØProgTitl, $Øprogvers, $Øcopydate, $Øcopyright, $Ødesigner, $Ølogo;
  echo '    </ul>';
  // echo Lbl_Tip($labl='@Local menu',$titl='@All paneles headlines, acts as local menu items in the actual window. Click the panel header to show / hide the panel`s contents.','SW').' ';
  echo '<span style="text-align: right;" title="'.
        $ØProgTitl.' - Version '.$Øprogvers.' - Copyright '. $Øcopydate.' '.$Øcopyright.' - '.lang('@Design: ').$Ødesigner.
        '" > <img src= "'. $ØProgRoot.$Ølogo.' " alt="Logo" height="25" style="top:2px; position:absolute; padding-left: 20px;" ></span><br>';
  echo '  </data-menu>';
  echo '</div>';
  echo "\n";
}

function MenuBranch($clas='',$href='#',$labl='',$titl='',$cssIcon='',$more='') {
  if ($href=='blindAlley.page.php') {$blnd='<i style="font-color:gray;">'; $obs='<small> '.lang('@contemplated!').'</small>';} else {$blnd=''; $obs='';};
  if ($clas=='exit')                {$bold='<span style="color:red; font-weight:600; left: -110px;">'; } else {$bold='';};
  if (strpos($href,'ttp' )>0)       {$targ='_blank'; } else $targ='_self'; //  Test if http seems (externel/locale link?)
  $link= 'href="'.$href.'" target="'.$targ.'" title="'.strip_tags(lang($titl)).'" >'.
        '<data-ic class="'.$cssIcon.'" style="font-size:'.$size.'; color:'.$fg.'; "> </data-ic>&nbsp;'.$blnd.$bold.ucfirst(lang($labl));
  if ($bold!='') {$link.= '</span>'.$obs;}
  if ($blnd!='') {$link.= '</i>'.$obs;} else {$link.= $obs;}
  echo "\n\n";
  //$link= '';
  switch ($clas) {
    case 'withsubmenu': echo '<li><a class="'.$clas.'"    '.$more.$link.'</a>  <ul>'; break;
    case 'firstitem':   echo '<li    class="'.$clas.'"><a '.$more.$link.'</a> </li>'; break;
    case 'exit':        echo '<li    class="'.$clas.'"><a '.$more.$link.'</a> </li>'; break;
    case '':            echo '<li>                     <a '.$more.$link.'</a> </li>'; break;
    case 'lastitem':    echo '<li    class="'.$clas.'"><a '.$more.$link.'</a> </li></ul></li>'; break;
    default :           ;
  }
}

function Menu_Topdropdown($showGroup1=true, $showGroup2=false, $showGroup3=false, $showGroup4=false, $showGroup5=false, $showGroup6=false) { //  Menu-placering/størrelse styres i MenuStart()
global $Ødebug, $ØProgTitl, $_assets, $_base, $folder1, $folder2, $folder3, $folder4, $folder5;  
    MenuStart($clas='firstmain',    $href='#',                $labl='@MENU:',               $titl='@Main menu');
    if ($showGroup1) {        
      MenuBranch($clas='withsubmenu', $href='Demo.page.php',                    $labl='@DEMO',          $titl='@Presentation of the system');
      MenuBranch($clas='firstitem',   $href= $folder1.'Demo.page.php',          $labl='@Demo',          $titl='@Something about functions', $icon='fas fa-info');
      MenuBranch($clas='lastitem',    $href= $folder1.'blindAlley.page.php',    $labl='@Description',   $titl='@Something about the system', $icon='fas fa-info');
    }                   
    if ($showGroup1) {              
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@MODULES',       $titl='@Information about php2html modules (htm_functions)');
      MenuBranch($clas='firstitem',   $href= $folder1.'input.page.php',         $labl='@htm_Input()',   $titl='@Something about function htm_Input()',  $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder1.'table.page.php',         $labl='@htm_Table()',   $titl='@Something about function htm_Table()',  $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder1.'panel.page.php',         $labl='@htm_Panel()',   $titl='@Something about function htm_Panel()',  $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder5.'pages.page.php',         $labl='@htm_Page...()', $titl='@Something about function htm_Pagex()',  $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder5.'navigate.page.php',      $labl='@Navigate',      $titl='@Tools related to navigating',           $icon='fas fa-cubes');
      MenuBranch($clas='lastitem',    $href= $folder5.'other.page.php',         $labl='@Others',        $titl='@Other functions than above',            $icon='fas fa-cubes');
    }                       
    if ($showGroup1) {              
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@FILES',         $titl='@Information about php2html files');
      MenuBranch($clas='firstitem',   $href= $folder1.'files.page.php',         $labl='@System files',  $titl='@Something about System files', $icon='fas fa-file');
      MenuBranch($clas='lastitem',    $href= $folder5.'support.page.php',       $labl='@Support files', $titl='@Something about Support files', $icon='fas fa-file');
    }                       
    if ($showGroup1) {                  
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@TRANSLATE',     $titl='@Information about TRANSLATE module');
      MenuBranch($clas='lastitem',    $href= $folder1.'translate.page.php',     $labl='@Description',   $titl='@About the language translate system', $icon='fas fa-info');
    }             
    MenuEnd();
}

/*
// Example (Menu in danish): 
NOTE: Some SPACE is inserted to prevent translate scanning to pick some strings forom comments !
function Menu_TopdropdownDK($showGroup1=true, $showGroup2=true, $showGroup3=true, $showGroup4=false, $showGroup5=true, $showGroup6=false) { //  Menu-placering/størrelse styres i MenuStart()
global $Ødebug, $ØProgTitl, $_assets, $_base, $_config, $folder2, $_exchange, $folder1, $folder3, $folder4, $_produktion, $folder5, $_temp, $_userlib, $_xtra;  
    MenuStart($clas='firstmain',    $href='../_base/page_Hovedmenu.php',                $labl=' @MENU:',               $titl=' @Main menu');
    if ($showGroup1) {        
      MenuBranch($clas='withsubmenu', $href='',                                           $labl=' @FINANCE',             $titl=' @Accounting Management');
      MenuBranch($clas='firstitem',   $href= $folder1.'page_Kladdeliste.php',             $labl=' @Cash register',       $titl=' @Here you can select the cash register and edit it');
      MenuBranch($clas='',            $href= $folder1.'page_Regnskab.php',                $labl=' @Regnskab',            $titl=' @Se det aktuelle regnskab her');
      MenuBranch($clas='',            $href= $folder1.'page_Budget.php',                  $labl=' @Budget',              $titl=' @Se og rediger budget');
      MenuBranch($clas='',            $href= $folder5.'page_Kontoplan.php?chg=ok',        $labl=' @Se kontoplan',        $titl=' @Her kan du se den aktuelle kontoplan');
      MenuBranch($clas='lastitem',    $href= $folder1.'page_Rapport-fin.php',             $labl=' @Rapporter',           $titl=' @Her vælger du hvad du vil se i en rapport');
    }             
    if ($showGroup2) {       
    MenuBranch($clas='withsubmenu',   $href='',                                           $labl=' @DEBTORS',             $titl=' @Here you will find what concerns your Customers');
      MenuBranch($clas='firstitem',   $href= $folder2.'page_Opretordre.php',             $labl=' @Ny ordre...',         $titl=' @Opret en ny salgs ordre...');
      MenuBranch($clas='',            $href= $folder2.'page_Ordreliste-deb.php',         $labl=' @Salgs ordrer',        $titl=' @Oversigt over ordrer og deres indhold');
      MenuBranch($clas='',            $href= $folder2.'page_Debitor.php',                $labl=' @Kunde konti',         $titl=' @Oversigt over kunder, og leverancer til disse');
      MenuBranch($clas='lastitem',    $href= $folder2.'page_Rapport-deb.php',            $labl=' @Rapporter',           $titl=' @Analyser af salg');
    }             
    if ($showGroup3) {        
    MenuBranch($clas='withsubmenu',   $href=' ',                                          $labl=' @CREDITOR',            $titl=' @Here you will find what concerns your suppliers');
      MenuBranch($clas='firstitem',   $href= $folder3.'page_Ordreliste-kre.php',        $labl=' @Nyt-indkøb...',       $titl=' @Opret en ny købs ordre...');
      MenuBranch($clas='',            $href= $folder3.'page_Ordreliste-kre.php',        $labl=' @Købs ordrer',         $titl=' @Oversigt over leverandører');
      MenuBranch($clas='',            $href= $folder3.'page_Kreditor.php',              $labl=' @Leverandør konti',    $titl=' @Oversigt over kreditorer og oplysninger om disse');
      MenuBranch($clas='lastitem',    $href= $folder3.'page_Rapport-kre.php',           $labl=' @Rapporter',           $titl=' @Analyser af køb');
                
    }             
    if ($showGroup4) {        
      MenuBranch($clas='withsubmenu', $href=' ',                                          $labl=' @PRODUCTION',          $titl=' @Production routines');
      MenuBranch($clas='lastitem',    $href= $folder4.'page_Beholdningsliste.php',         $labl=' @Rapporter',           $titl=' @Analyser over produktion');
    }       
    if ($showGroup5) {       
    MenuBranch($clas='withsubmenu',   $href=' ',                                          $labl=' @STORAGE',               $titl=' @Routines regarding stocked products');
      MenuBranch($clas='firstitem',   $href= $folder4.'page_Varer.php',                    $labl=' @Vare lager',          $titl=' @Oversigt over salgsvarer, samt detaljer på varekort');
      MenuBranch($clas='',            $href= $folder4.'page_Varemodtagelse.php',           $labl=' @Vare modtagelse',     $titl=' @Lister for varemodtagelse');
      MenuBranch($clas='lastitem',    $href= $folder4.'page_Beholdningsliste.php',         $labl=' @Rapporter',           $titl=' @Analyser af varesalg m.v.');
    }       
    if (true) {       
    MenuBranch($clas='withsubmenu',   $href=' ',                                          $labl=' @SYSTEM',              $titl=' @Here you set the program and the accounts');
      MenuBranch($clas='firstitem',   $href= $folder5.'page_Kontoplan.php?chg=no',        $labl=' @Kontoplan',           $titl=' @Her vedligeholder du den aktuelle kontoplan');
      MenuBranch($clas='withsubmenu', $href=' ',                                          $labl=' @Indstillinger &nbsp; =>', $titl=' @Indstillinger for programmet');
        MenuBranch($clas='firstitem', $href= $folder5.'page_Valuta.php',                  $labl=' @1. indstil-ofte',     $titl=' @Her har du de hyppigst benyttede indstillinger');
        MenuBranch($clas='',          $href= $folder5.'page_Divsetup2.php',               $labl=' @2. indstil-flere',    $titl=' @Her har du de sjældnere benyttede indstillinger');
        MenuBranch($clas='lastitem',  $href= $folder5.'page_Tilvalgsetup3.php',           $labl=' @3. indstil-extra',    $titl=' @Her aktiverer og indstiller tilvalgs funktioner');
      MenuBranch($clas='',            $href= $folder5.'page_Backup.php',                  $labl=' @Sikkerheds kopiering',$titl=' @Her kan du sikre dig dine regnskabsdata, bilags filer og programinstallation');
      MenuBranch($clas='',            $href= $folder5.'page_Licens.php',                  $labl=' @Om programmet',       $titl=' @Her finder du oplysninger om programmet, og serveren det kører på');
      MenuBranch($clas='lastitem',    $href= $folder5.'page_Regnskabet.php',              $labl=' @Om regnskabet',       $titl=' @Her finder du oplysninger om regnskabet, som du aktuelt arbejder på');
    }       
    if ($showGroup6) {        
    MenuBranch($clas='withsubmenu',   $href=' ',                                          $labl=' @EXTENSIONS',          $titl=' @Routines regarding added program extensions');
      MenuBranch($clas='firstitem',   $href= $_xtra.'page_Kasse.php',                     $labl=' @Kasse system POS',    $titl=' @xxx');
      MenuBranch($clas='',            $href= $_xtra.'page_xxxxxxxxxxxxxx.php',            $labl=' @xxxxx',               $titl=' @xxx');
      MenuBranch($clas='lastitem',    $href= $_xtra.'page_xxxxxxxxxxxxxx.php',            $labl=' @xxxxx',               $titl=' @xxx');
    }
    if (true) {
      MenuBranch($clas='withsubmenu', $href=' ',                                          $labl=' @ADDITIONAL',              $titl=' @Bookkeeper`s Tools');
        MenuBranch($clas='firstitem', $href= $_assets.'Calculator/strimmelcalc.php?ttp',  $labl=' @Strimmelregner',      $titl=' @Start en simpel kalkulator');
        MenuBranch($clas='',          $href= $_base.'page_Blindgyden.php',                $labl=' @Notesblok',           $titl=' @Start en simpel skrivemaskine');
        MenuBranch($clas='',          $href= $_assets.'tfm\TFM-user.php?ttp',             $labl=' @Fil-Manager',         $titl=' @Browse/editere bruger filer.');
        MenuBranch($clas='',          $href= $_base.'page_Tips.php',                      $labl=' @Tips',                $titl=lang (' @Her er der nyttige tips, til brugen af').$ØProgTitl);
        MenuBranch($clas='',          $href= $_base.'_intro/intro.html',                  $labl=' @Introduktion',        $titl=' @Her redegøres for de kommende forbedringer i version 5.0 -'.$ØProgTitl);
        MenuBranch($clas='',          $href= $_base.'page_News.php',                      $labl=' @Nyheder',             $titl=' @Her omtales nogle af de nyheder, der er tilføjet i den nye'.$ØProgTitl);
        MenuBranch($clas='lastitem',  $href='http://www.ev-soft.dk/saldi-wiki/doku.php?id=saldi:manualen', 
                                                                                        $labl=' @DokuWiki - Manual',   $titl=lang (' @Manual, tips og anden hjælp finder du på').$ØProgTitl.lang( ' @-DokuWiki (åbner i nyt vindue)'));  
    }
    if ($Ødebug) { // Programmers tools:
      MenuBranch($clas='withsubmenu', $href= ' ',                                         $labl=' @TOOLS',               $titl=' @Developer tools');
        MenuBranch($clas='firstitem', $href= $_assets.'tfm\tinyfilemanager.php?ttp',      $labl=' @Fil-Manager',         $titl=' @Browse/editere installationens filer. &#xa; For programmører!');
        MenuBranch($clas='',          $href= $_base.'_tools/frasescann.php',              $labl=' @Frase-skanning',      $titl=' @Skanning efter danske fraser, som skal oversættes');
        MenuBranch($clas='',          $href= $_base.'_tools/funcscann.php',               $labl=' @Funktions-skanning',  $titl=' @Skanning efter funktions navne, og parametre');
        MenuBranch($clas='',          $href= $_base.'_tools/docscann.php',                $labl=' @Ord-skanning...',     $titl=' @Skanning efter et angivet ord, f.eks. $DocFil');
        MenuBranch($clas='',          $href= '../modulscann.php',                         $labl=' @Modul-skanning...',   $titl=' @Skanning af alle primære htm/php-filer - vis status mv.');
        MenuBranch($clas='',          $href= '../pladsforbrug.php',                       $labl=' @Mappe-skanning...',   $titl=' @Skanning af alle mappers størrelse');
        MenuBranch($clas='lastitem',  $href= $_base.'page_Printlayout.php',               $labl=' @Side test...',        $titl=' @Test af sider under udvikling');
    }
    if (true) {
        MenuBranch($clas='exit',      $href='../_base/page_Startup.php', 
                                    $labl='<i class="fas fa-sign-out-alt" style="font-size:16px; color: red; " ></i> '.lang ( '@log out'),  
                                    $titl=lang (' @Leave').$ØProgTitl.str_lf().lang (' @in locked state.'),$more=' style="background:white; width:70px; box-shadow:3px 3px 1px #EDEDED;" ');
    }
  MenuEnd();
  //echo '<br>XXX';
}
*/

$CSS_style .= '
<style type="text/css">
:root {
--width120: 100px; /* var(--width120); */
--width128: 100px; /* var(--width128); */
}
    
section#container
{   width: 1200px;   position: relative;   margin: 0 auto 0 auto;   text-align: left;}

#wb_TopMenu
{   border: 0px #C0C0C0 solid;   background-color: transparent; }
#wb_TopMenu ul
{   list-style-type: none;   margin: 0;   padding: 0;}
#wb_TopMenu li
{   float: left;   margin: 0;   padding: 0px 2px 0px 0px;   width: var(--width120);}
#wb_TopMenu a, aaa
{  display: block;   float: left;   color: #FFFFFF;   border: 1px #C0C0C0 solid;   -moz-border-radius: 3px;
   -webkit-border-radius: 3px;   border-radius: 3px;   background-color: #3A3A3A;
   background: -moz-linear-gradient(bottom,#3A3A3A 0%,#999999 100%);
   background: -webkit-linear-gradient(bottom,#3A3A3A 0%,#999999 100%);
   background: -o-linear-gradient(bottom,#3A3A3A 0%,#999999 100%);
   background: -ms-linear-gradient(bottom,#3A3A3A 0%,#999999 100%);
   background: linear-gradient(bottom,#3A3A3A 0%,#999999 100%);
   font-family: Arial;   font-weight: normal;   font-size: 11px;   font-style: normal;   text-decoration: none;
   width: var(--width128);   padding: 0px 5px 0px 5px;   vertical-align: middle;
   line-height: 18px;   text-align: center;
}
#wb_TopMenu aaa, #wb_TopMenu a:hover
{  text-align: left;  width: 50px; color:#D2691E; background: #DEDEDE; }

#wb_TopMenu li:hover a, #wb_TopMenu a:hover, #wb_TopMenu .active
{  color: #D2691E;   background-color: #C0C0C0;
   background: -moz-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -webkit-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -o-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -ms-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   border: 2px #C0C0C0 solid;
}
#wb_TopMenu li.firstmain
{   padding-left: 0px;  width: 40px;}
#wb_TopMenu li.lastmain
{   padding-right: 0px;}
#wb_TopMenu li:hover, #wb_TopMenu li a:hover
{   position: relative;}
#wb_TopMenu a.withsubmenu
{   padding: 0 5px 0 5px;   width: var(--width128);}
#wb_TopMenu li:hover a.withsubmenu, #wb_TopMenu a.withsubmenu:hover
{  background-image: none;
   background: -moz-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -webkit-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -o-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -ms-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
}
#wb_TopMenu li.exit, li:hover
{   padding-left: 8px;  width: 80px;
    color: yellow;   background-color: white;
}

#wb_TopMenu ul ul
{   position: absolute;   left: 0px;   top: 0px;   visibility: hidden;   width: var(--width120);   height: auto;
    border: none;   background-color: transparent;
}
#wb_TopMenu ul :hover ul
{   left: 0px;   top: 20px;   padding-top: 0px;   visibility: visible;}
#wb_TopMenu .firstmain:hover ul
{   left: 0px;  width: 50px;}
#wb_TopMenu li li
{   width: var(--width120);   padding: 0 0px 0px 0px;   border: 0px #C0C0C0 solid;   border-width: 0 0px;}
#wb_TopMenu li li.firstitem
{   border-top: 0px #C0C0C0 solid;}
#wb_TopMenu li li.lastitem
{   border-bottom: 0px #C0C0C0 solid;}
#wb_TopMenu ul ul a, #wb_TopMenu ul :hover ul a, #wb_TopMenu ul :hover ul :hover ul a
{   float: none;   margin: 0;   width: 126px;   height: auto;   white-space: normal;
   padding: 3px 6px 3px 6px;   background-color: #EEEEEE;   background-image: none;   border: 1px #C0C0C0 solid;
   -moz-border-radius: 0;
   -webkit-border-radius: 0;
   border-radius: 0;   color: #666666;   font-family: Arial;    font-family: sans-serif;   font-weight: normal;   font-size: 12px;
   font-style: normal;   line-height: 12px;   text-align: left;   text-decoration: none;
}
#wb_TopMenu ul :hover ul .firstitem a, #wb_TopMenu ul :hover ul :hover ul .firstitem a
{   margin-top: 0px; }
#wb_TopMenu ul ul :hover a, #wb_TopMenu ul ul a:hover, #wb_TopMenu ul ul :hover ul :hover a, #wb_TopMenu ul ul :hover ul a:hover, #wb_TopMenu ul ul :hover ul :hover ul :hover a, #wb_TopMenu ul ul :hover ul :hover ul a:hover
{  background-color: #C0C0C0;   border: 1px #C0C0C0 solid;   color: #D2691E;
   /* background-image: none; */
   background-image: url(../_assets/images/Arrow_Drop_Right.png);
   background-repeat: no-repeat;
   background-position: right top;
   background: -moz-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -webkit-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -o-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -ms-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
}
#wb_TopMenu ul ul a.withsubmenu, #wb_TopMenu ul :hover ul a.withsubmenu, #wb_TopMenu ul :hover ul :hover ul a.withsubmenu
{   width: var(--width128);   padding: 3px 5px 3px 5px;   <!-- background-image: none; --> }
#wb_TopMenu ul ul :hover a.withsubmenu, #wb_TopMenu ul ul a.withsubmenu:hover, #wb_TopMenu ul ul :hover ul :hover a.withsubmenu, #wb_TopMenu ul ul a.withsubmenu:hover a.withsubmenu:hover
{  /* background-image: none; */
   background-image: url(../_assets/images/Arrow_Drop_Right.png);
   background-repeat: no-repeat;
   background-position: right top;
   background: -moz-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -webkit-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -o-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: -ms-linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
   background: linear-gradient(bottom,#C0C0C0 0%,#EEEEEE 100%);
}
#wb_TopMenu ul :hover ul ul, #wb_TopMenu ul :hover ul :hover ul ul
{   position: absolute;   left: 0px;   top: 0px;   visibility: hidden;}
#wb_TopMenu ul :hover ul :hover ul, #wb_TopMenu ul :hover ul :hover ul :hover ul
{   left: var(--width128);   top: 0px;   visibility: visible;}
#wb_TopMenu ul :hover ul .firstitem:hover ul, #wb_TopMenu ul :hover ul :hover ul .firstitem:hover ul
{   top: 0px;}
#wb_TopMenu br
{   clear: both;   font-size: 1px;   height: 0;   line-height: 0;}
#wb_TopMenu
{   position: absolute;   left: 0px;   top: 0px;   width: 1000px;   height: 20px;   z-index: 0;}

@media screen and (max-width: 640px) { 
  #wb_TopMenu { width: 140px; } 
  #container { height: 140px; } 
}

/* 
#all ul:hover a, #.parent.siblings:hover {
opacity: 0.5; visibility: visible;
}
 */
</style>';
?>
