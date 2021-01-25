<?php $DocFile='../Proj1/menu.inc.php';    $DocVers='1.0.0';    $DocRev1='2021-01-24';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';


# MENU-folders:
$folder1= '';
$folder2= '';
$folder3= '';
$folder4= '';
$folder5= '';

## TopMenu-rutines: (used in Menu_Topdropdown )
function MenuStart($clas='firstmain',$href='#',$labl='',$titl='') {  //  MUST be followed of MenuEnd()
  echo "\n";
  echo '<div id="container" style="display:inline-block;">';  // style/css: see the file _base/htm_TopMenu-head.css.htm
// Responsive-menu! if (narrow screen) width:120px; else width:1200px;
  echo '  <data-menu id="wb_TopMenu" style="display: flex; position: fixed; top:1px; height:24px; width: max-content; z-index:999; left: 0; right: 0; margin: 0 auto;">';  //  width:'.$menuwd.';
  echo '    <ul>';
  echo '      <li class="'.$clas.'" style="color:black; width:20px; text-align:left;"><a href="'.$href.'" target="_self" style="background:#EEEEEE;" title="'.lang($titl).'">'.lang($labl).'</a> </li>';
}

function MenuEnd() {global $ØProgRoot, $ØProgTitl, $Øprogvers, $Øcopydate, $Øcopyright, $Ødesigner, $ØmenuLogo;
  echo '    </ul>';
  // echo Lbl_Tip($labl='@Local menu',$titl='@All paneles headlines, acts as local menu items in the actual window. Click the panel header to show / hide the panel`s contents.','SW').' ';
  echo '<span style="text-align: right;" title="'.
        $ØProgTitl.' - Version '.$Øprogvers.' - Copyright '. $Øcopydate.' '.$Øcopyright.' - '.lang('@Design: ').$Ødesigner.
        '" > <img src= "'. $ØProgRoot.$ØmenuLogo.' " alt="Logo" height="25" style="top:2px; position:absolute; padding-left: 20px;" ></span><br>';
  echo '  </data-menu>';
  echo '</div>';
  echo "\n";
}

function MenuBranch($clas='',$href='#',$labl='',$titl='',$cssIcon='',$more='') {
  if ($href=='blindAlley.page.php') {$blnd='<i style="font-color:gray;">'; $obs='<small> '.lang('@contemplated!').'</small>';} else {$blnd=''; $obs='';};
  if ($clas=='exit')                {$bold='<span style="color:red; font-weight:600; left: -110px;">'; } else {$bold='';};
  if (strpos($href,'ttp' )>0)       {$targ='_blank'; } else $targ='_self'; //  Test if http seems (externel/locale link?)
  $link= 'href="'.$href.'" target="'.$targ.'" title="'.strip_tags(lang($titl)).'" >'.
        '<data-ic class="'.$cssIcon.'" style="font-size:'.($size ?? 12).'; color:'.($fg ?? '00').'; "> </data-ic>&nbsp;'.$blnd.$bold.ucfirst(lang($labl));
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

function Menu_Topdropdown($showGroup1=true, $showGroup2=false, $showGroup3=false, $showGroup4=false, $showGroup5=false, $showGroup6=false) {
global $Ødebug, $ØProgTitl, $_assets, $_base, $folder1, $folder2, $folder3, $folder4, $folder5;
 // MenuStart($clas='firstmain',      $href='#',                              $labl='@MENU:',         $titl='@Main menu');
    MenuStart($clas='firstmain',      $href='#',                              $labl='<b>PHP2HTML</b>',  $titl='@Demo of the php to html library');
    if ($showGroup1) {
      MenuBranch($clas='withsubmenu', $href= $folder2.'Demo.page.php',          $labl='@DEMO',          $titl='@Presentation of the system');
      MenuBranch($clas='firstitem',   $href= $folder2.'Demo.page.php',          $labl='@Demo',          $titl='@Demonstrate some functions',           $icon='fas fa-info');
      MenuBranch($clas='',            $href= $folder2.'CustomerOrder.page.php', $labl='@Advanced example', $titl='@Example of order creation (In danish)', $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder2.'description.page.php',   $labl='@Description',   $titl='@Something about the system',           $icon='fas fa-info');
      MenuBranch($clas='lastitem',    $href= $folder2.'PHP2HTML-intro.page.php',$labl='@Introduction',  $titl='@Introduction to the systems most usable modules', $icon='fas fa-info');
    }
    if ($showGroup1) {
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@MODULES',       $titl='@Information about php2html modules (htm_functions)');
      MenuBranch($clas='firstitem',   $href= $folder2.'input.page.php',         $labl='@htm_Input()',   $titl='@Something about function htm_Input()', $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder2.'table.page.php',         $labl='@htm_Table()',   $titl='@Something about function htm_Table()', $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder2.'panel.page.php',         $labl='@htm_Panel()',   $titl='@Something about function htm_Panel()', $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder2.'pages.page.php',         $labl='@Page layout',   $titl='@Something about Page and layout',      $icon='fas fa-cubes');
      MenuBranch($clas='',            $href= $folder2.'navigate.page.php',      $labl='@Navigate',      $titl='@Tools related to navigating',          $icon='fas fa-cubes');
      MenuBranch($clas='lastitem',    $href= $folder2.'other.page.php',         $labl='@Others',        $titl='@Other functions than above',           $icon='fas fa-cubes');
    }
    if ($showGroup1) {
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@FILES',         $titl='@Information about php2html files');
      MenuBranch($clas='firstitem',   $href= $folder2.'files.page.php',         $labl='@System files',  $titl='@Something about System files',         $icon='fas fa-file');
      MenuBranch($clas='lastitem',    $href= $folder2.'support.page.php',       $labl='@Support files', $titl='@Something about Support files',        $icon='fas fa-file');
    }
    if ($showGroup1) {
      MenuBranch($clas='withsubmenu', $href= $folder2.'translate.page.php',     $labl='@TRANSLATE',     $titl='@Information about TRANSLATE module');
      MenuBranch($clas='lastitem',    $href= $folder2.'translate.page.php',     $labl='@Translate',     $titl='@About the language translate system',  $icon='fas fa-info');
    }
    if ($showGroup1) {
      MenuBranch($clas='withsubmenu', $href= $folder2.'functions.page.php',     $labl='@FUNCTIONS',     $titl='@Information about TRANSLATE module');
      MenuBranch($clas='lastitem',    $href= $folder2.'functions.page.php',     $labl='@Overview',      $titl='@An overview over the system functions',  $icon='fas fa-info');
    }
    MenuEnd();
}


function Menu_TinyCloud($showGroup1=true, $showGroup2=false, $showGroup3=false, $showGroup4=false, $showGroup5=false, $showGroup6=false) {
global $Ødebug, $ØProgTitl, $_assets, $_base, $folder1, $folder2, $folder3, $folder4, $folder5;
 // MenuStart($clas='firstmain',      $href='#',                                $labl='@MENU:',         $titl='@Main menu');
    MenuStart($clas='firstmain',      $href='#',                                $labl='<b>TinyCloud</b>', $titl='@A Demo');
    
      MenuBranch($clas='withsubmenu', $href= $folder2.'Demo.page.php',          $labl='@FINANCE',       $titl='@Presentation of the system');
      MenuBranch($clas='firstitem',   $href= $folder2.'AccountPlan.page.php',   $labl='@Account Plan',  $titl='@TCA-Demonstrate some functions',        $icon='fas fa-info');
      MenuBranch($clas='',            $href= $folder2.'Accounting.page.php',    $labl='@Accounting',    $titl='@TCA-demo (In danish)',                  $icon='fas fa-file');
      MenuBranch($clas='lastitem',    $href= $folder2.'journalEntry.page.php',  $labl='@Journal Entry', $titl='@-',                                     $icon='fas fa-file');
      
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@DEBTOR',        $titl='@-');
      MenuBranch($clas='firstitem',   $href= $folder2.'CustomerOrder.page.php', $labl='@Customer Order',$titl='@Example of order creation (In danish)', $icon='fas fa-file');
      MenuBranch($clas='lastitem',    $href= $folder0.'',                       $labl='@-',             $titl='@-',         $icon='fas fa-question');
      
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@KREDITOR',      $titl='@-');
      MenuBranch($clas='firstitem',   $href= $folder0.'',                       $labl='@-',             $titl='@-',         $icon='fas fa-question');
      MenuBranch($clas='lastitem',    $href= $folder0.'',                       $labl='@-',             $titl='@-',         $icon='fas fa-question');
      
      MenuBranch($clas='withsubmenu', $href='',                                 $labl='@SETTINGS',      $titl='@-');
      MenuBranch($clas='firstitem',   $href= $folder0.'',                       $labl='@-',             $titl='@-',         $icon='fas fa-question');
      MenuBranch($clas='lastitem',    $href= $folder0.'',                       $labl='@-',             $titl='@-',         $icon='fas fa-question');
    MenuEnd();
}


## Bottom-rutines: (used in Menu_Bottom)
$arrHref= [ // href:             Labl:
    [$folder1.'Demo.page.php','@Demo'],
    [$folder1.'CustomerOrder.page.php','@Example'],
    [$folder1.'description.page.php','@Description'],
    [$folder1.'input.page.php','@htm_Input()'],
    [$folder1.'table.page.php','@htm_Table()'],
    [$folder1.'panel.page.php','@htm_Panel()'],
    [$folder5.'pages.page.php','@Page layout'],
    [$folder5.'navigate.page.php','@Navigate'],
    [$folder5.'other.page.php','@Others'],
    [$folder1.'files.page.php','@System files'],
    [$folder5.'support.page.php','@Support files'],
    [$folder1.'translate.page.php','@Translate'],
    [$folder1.'functions.page.php','@Overview']
];

function Menu_BottomScroll() { global $arrHref;
    run_Script("function changeValue(step) {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 + step : value + step;
        document.getElementById('number').value = value;
    }");
    function ButtBuild($labl,$step,$pg,$ic) {
        echo '<button onclick="changeValue('.$step.')" title="'.lang('@Go to ').$pg.lang(' page').'"><ic class="fas fa-angle-'.$ic.'" </ic> '.$labl.' </button>';
    }
    if (isset($_POST['number'])) $i= $_POST['number'];
    $i= max(min($i,count($arrHref)-1), 0);  // FIXIT
    $ix= array_search(explode('/',$_SERVER['REQUEST_URI'])[2],array_column($arrHref, 0));
    // $i= $ix;
    echo '<form action="'.$arrHref[$i][0].'" method="post">
          <input type="hidden" name="number" id="number" value="'. $i .'" />
          <div style="background-color: lightgray; width: max-content; border: 1px solid lightgray; padding: 3px; position: fixed; bottom: 1px; left: 0; right: 0; margin: auto;"><small>';
          ButtBuild('First',-99,lang('@first'),'double-left');
          ButtBuild('Prev',-1,lang('@previous'),'left');
    echo '<span title="'.lang('@The current page menu-label').'"> This: <b>['.$ix.'] '. lang($arrHref[$ix][1]).' </b> </span>';
          ButtBuild('Next',1,lang('@next'),'right');
          ButtBuild('Last',99,lang('@last'),'double-right');
    echo '</small></div> </form>';
}

##
$CSS_system .= '
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
{   padding-left: 0px;  /* width: 80px; */}
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
{   left: 0px;  /* width: 80px; */}
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
