<?php $DocFile='./menu.inc.php';    $DocVer='1.1.0';    $DocRev='2021-11-01';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2021 EV-soft *** See the file: LICENSE';


# MENU-folders:
$folder1= '';
$folder2= '';
$folder3= '';
$folder4= '';
$folder5= '';

## TopMenu-rutines: (used in Menu_Topdropdown )
function Menu_0($clas='firstmain',$href='#',$labl='',$titl='') {  //  MUST be followed of Menu_00() after the Menu_Items
  echo "\n";
  echo '<div id="container" style="display:inline-block; height: 0px;">';  // style/css: see the file _base/htm_TopMenu-head.css.htm
// Responsive-menu! if (narrow screen) width:120px; else width:1200px;
  echo '  <data-menu id="wb_TopMenu" style="display: flex; position: fixed; top:1px; height:24px; width: max-content; z-index:999; left: 0; right: 0; margin: 0 auto;">';  //  width:'.$menuwd.';
  echo '    <ul>';
  echo '      <li class="'.$clas.'" style="color:black; width:20px; text-align:left;"><a href="'.$href.'" target="_self" style="background:#EEEEEE;" title="'.lang($titl).'">'.lang($labl).'</a> </li>';
}

function Menu_00() {global $ØProgRoot, $ØProgTitl, $Øprogvers, $Øcopydate, $Øcopyright, $Ødesigner, $ØmenuLogo;
  echo '    </ul>';
  // echo Lbl_Tip($labl='@Local menu',$titl='@All paneles headlines, acts as local menu items in the actual window. Click the panel header to show / hide the panel`s contents.','SW').' ';
  echo '<span style="text-align: right;" title="'.
        $ØProgTitl.' - Version '.$Øprogvers.' - Copyright '. $Øcopydate.' '.$Øcopyright.' - '.lang('@Design: ').$Ødesigner.
        '" > <img src= "'. $ØProgRoot.$ØmenuLogo.' " alt="Logo" height="25" style="top:-2px; position:absolute; padding-left: 20px;" ></span><br>';
  echo '  </data-menu>';
  echo '</div>';
  echo "\n";
}

function Menu_Item($clas='',$href='#',$labl='',$titl='',$cssIcon='',$attr='') {
  if ($href=='blindAlley.page.php') {$blnd='<i style="font-color:gray;">'; $obs='<small> '.lang('@contemplated!').'</small>';} else {$blnd=''; $obs='';};
  if ($clas=='exit')                {$bold='<span style="color:red; font-weight:600; left: -110px;">'; } else {$bold='';};
  if (strpos($href,'ttp' )>0)       {$targ='_blank'; } else $targ='_self'; //  Test if http seems (externel/locale link?)
  $link= 'href="'.$href.'" target="'.$targ.'" title="'.strip_tags(lang($titl)).'" >'.
        '<data-ic class="'.$cssIcon.'" style="font-size:'.($size ?? 12).'; color:'.($fg ?? '00').'; width:15px; "> </data-ic>'.$blnd.$bold.ucfirst(lang($labl));
  if ($bold!='') {$link.= '</span>'.$obs;}
  if ($blnd!='') {$link.= '</i>'.$obs;} else {$link.= $obs;}
  echo "\n\n";
  switch ($clas) {
    case 'withsubmenu': echo '<li><a class="'.$clas.'"    '.$attr.$link.'</a>  <ul>'; break;
    case 'firstitem':   echo '<li    class="'.$clas.'"><a '.$attr.$link.'</a> </li>'; break;
    case 'exit':        echo '<li    class="'.$clas.'"><a '.$attr.$link.'</a> </li>'; break;
    case '':            echo '<li>                     <a '.$attr.$link.'</a> </li>'; break;
    case 'lastitem':    echo '<li    class="'.$clas.'"><a '.$attr.$link.'</a> </li></ul></li>'; break;
    default :           ;
  }
}

function Menu_Topdropdown($showGroup1=true, $showGroup2=true, $showGroup3=false, $showGroup4=false, $showGroup5=false, $showGroup6=false) {
global $Ødebug, $ØProgTitl, $_assets, $_base, $folder1, $folder2, $folder3, $folder4, $folder5;
 // Menu_0($clas='firstmain',        $href='#',                                $labl='@MENU:',           $titl='@Main menu');
    Menu_0($clas='firstmain',        $href='#',                                $labl='<b>EV-soft</b>',        $titl='@...');
    if ($showGroup1) {
      Menu_Item($clas='withsubmenu', $href= $folder2.'',                       $labl='@INTRODUCTION',    $titl='@Introduction to the systems most usable modules');
      Menu_Item($clas='firstitem',   $href= $folder2.'PHP2HTML-intro.page.php',$labl='@About',           $titl='@Introduction to the systems most usable modules',$icon='fas fa-home');
      Menu_Item($clas='',            $href= $folder2.'description.page.php',   $labl='@Description',     $titl='@Something about the system',            $icon='fas fa-info');
      Menu_Item($clas='',            $href= $folder2.'Demo.page.php',          $labl='@Demo',            $titl='@Demonstrate some functions',            $icon='fas fa-info');
      Menu_Item($clas='lastitem',    $href= $folder2.'CustomerOrder.page.php', $labl='@Advanced example',$titl='@Example of order creation (In danish)', $icon='fas fa-cubes');
    }
    if ($showGroup2) {
      Menu_Item($clas='withsubmenu', $href='',                                 $labl='@MODULES',         $titl='@Information about php2html modules (htm_functions)');
      Menu_Item($clas='firstitem',   $href= $folder2.'input.page.php',         $labl='@htm_Input()',     $titl='@Something about function htm_Input()',  $icon='fas fa-cubes');
      Menu_Item($clas='',            $href= $folder2.'table.page.php',         $labl='@htm_Table()',     $titl='@Something about function htm_Table()',  $icon='fas fa-cubes');
      Menu_Item($clas='',            $href= $folder2.'panel.page.php',         $labl='@htm_Panel()',     $titl='@Something about function htm_Panel()',  $icon='fas fa-cubes');
      Menu_Item($clas='',            $href= $folder2.'pages.page.php',         $labl='@Page layout',     $titl='@Something about Page and layout',       $icon='fas fa-cubes');
      Menu_Item($clas='',            $href= $folder2.'navigate.page.php',      $labl='@Navigate',        $titl='@Tools related to navigating',           $icon='fas fa-cubes');
      Menu_Item($clas='lastitem',    $href= $folder2.'other.page.php',         $labl='@Others',          $titl='@Other functions than above',            $icon='fas fa-cubes');
    }                                                                                                                                                    
    if ($showGroup3) {                                                                                                                                   
      Menu_Item($clas='withsubmenu', $href='',                                 $labl='@FILES',           $titl='@Information about php2html files');     
      Menu_Item($clas='firstitem',   $href= $folder2.'files.page.php',         $labl='@System files',    $titl='@Something about System files',          $icon='fas fa-file');
      Menu_Item($clas='lastitem',    $href= $folder2.'support.page.php',       $labl='@Support files',   $titl='@Something about Support files',         $icon='fas fa-file');
    }                                                                                                                                                    
    if ($showGroup1) {                                                                                                                                   
      Menu_Item($clas='withsubmenu', $href= $folder2.'translate.page.php',     $labl='@TRANSLATE',       $titl='@Information about TRANSLATE module');   
      Menu_Item($clas='lastitem',    $href= $folder2.'translate.page.php',     $labl='@Translate',       $titl='@About the language translate system',   $icon='fas fa-info');
    }                                                                                                    
    if ($showGroup1) {                                                                                   
      Menu_Item($clas='withsubmenu', $href= $folder2.'functions.page.php',     $labl='@FUNCTIONS',       $titl='@Information about TRANSLATE module');
      Menu_Item($clas='lastitem',    $href= $folder2.'functions.page.php',     $labl='@Overview',        $titl='@An overview over the system functions', $icon='fas fa-info');
    }
    Menu_00();
}


##
$CSS_system .= '
<style type="text/css">
:root {
--width120: 140px; /* var(--width120); */
--width128: 140px; /* var(--width128); */
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
   line-height: 20px;   text-align: center;
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
{   float: none;   margin: 0;   width: 150px;   height: auto;   white-space: normal;
   padding: 3px 6px 3px 6px;   background-color: #EEEEEE;   background-image: none;   border: 1px #C0C0C0 solid;
   -moz-border-radius: 0;
   -webkit-border-radius: 0;
   border-radius: 0;   color: #666666;   font-family: Arial;    font-family: sans-serif;   font-weight: normal;   font-size: 12px;
   font-style: normal;   line-height: auto;   text-align: left;   text-decoration: none;
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
