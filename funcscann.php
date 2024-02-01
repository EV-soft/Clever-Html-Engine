<?php   $DocFile= '.\funcscann.php';    $DocVer='1.3.2';    $DocRev='2024-01-26';     $DocIni='evs';  $ModulNr=0; ## File informative only

#  $d = dir("../../saldi-e/'");  ## saldi-e\_base\_tools\funcscann.php   ~/.rcinfo
#  $d = basename('./saldi-e');
  $d = dir("../../");  //    var_dump($d);
  // $paths = glob('../../*/*.{htm,php}',GLOB_BRACE); 
  $paths = glob('./*/*.{htm,php}',GLOB_BRACE);
    function sortByKey($a, $b) {
        return $a['key'] > $b['key'];
    }
  // echo "<br>";
#  var_dump($paths);
  $searchWord= 'function ';
  if (false) // Not in use !
  foreach ($paths as $file) {
    echo "<br>".$file;
    $fileLines = file($file);  $LinNo=0;
    foreach ($fileLines as $line_num => $line) {  $LinNo++; 
            if ($p=strpos(' '.$line,$searchWord)) { 
            if ($p<5) { //  PLACERING i starten af en linie!
                if ($s=strpos($line,"{")) $funcN= substr($line,0,$s); else $funcN= $line;
                $lno= '-----> '.$LinNo;
                echo "<pre style=\"line-height:5px;\">".$d.' '.$sourceFile.str_repeat("&nbsp;",max(35-strlen($d.$sourceFile),0)).' '.substr($lno,-6).': '.$funcN."</pre>";
              }
              if ((strpos($sourceFile,'out_')) and (strpos($sourceFile,'.php'))) {   //  2. KRITERIE: Filnavn
                $fras= $line;
                while (strpos($fras,$searchWord)) {
                  $p= strpos($fras,$searchWord);  $fras= substr($fras,$p+1);  $b= strpos($fras,"'");
                  $fras= html_entity_decode($fras);
                  $fras= strip_tags($fras);
                  echo  'XXXXXXXXXXXX<br>"'.substr($fras,0,$b).'"'.
                    str_repeat("&nbsp;",170-strlen(utf8_decode(substr($fras,0,$b)))).',"","","","","",""';  
                  $f= substr($fras,0,$b);
                  $fraser[] = ['"'.$f.'"'];
                } 
              } $count++; $total++;
          }}
    }
    
    
    
  $total= 0;    $buff= array();   $fraser= array(); $d = dir("/");  $html= ''; $arrFunctions= [];
#  echo "<br>".basename('./../saldi-e')."<br>";
#  echo $_SERVER['SERVER_NAME'] . dirname(__FILE__);
#  echo "<br><big>".'Projektskanning: '."</big><br>";
  
  ## Supress output: //_// comments
  //_// echo '<p style="font-family:courier; font-size:11; ">';
#  echo '<pre>Folder/        File'.str_repeat("&nbsp;",35-15).'Line: Function </pre>';
  while ((is_object($d)) and (false !== ($entry = $d->read())) )
  {
  //if (false !== ($entry = $d->read())) {
    $dir= $entry.'/';
    if (is_dir($entry) ) {
      $files = scandir($dir);
      if ($files)
      foreach ($files as $sourceFile) 
      { $count= 0;  $searchWord= 'function ';   $arrFunctions= [];
        if ( ($sourceFile!=='.') and ($sourceFile!=='..') 
             and (!strpos($sourceFile,'.bak'))   //  Filter:
             and (in_array($sourceFile,[
                'php2html.lib.php',/* 
                'customLib.inc.php',
                'menu.inc.php',
                'translate.inc.php',
                'filedata.inc.php' */
            ])) ) 
        {
          $fileLines = file($dir.$sourceFile); 
          $LinNo= 0;
          // echo "<pre>".$fileLines[]."</pre>";
            //echo '<p style="font-family:monospace>"';
          //_// echo '<br>';
          foreach ($fileLines as $line_num => $line) { $LinNo++;
            // echo '.';
            if ($LinNo==1) { // Get file-info:
                // <?php   $DocFil= './Proj.demo/CustomerOrder.page.php';    $DocVer='1.2.0';    $DocRev='2022-03-05';     $DocIni='evs';  $ModulNr=0; ## File informative only
                $infoline= substr($line,6);
                $a= strpos($infoline,"'")+1;
                $b= strpos($infoline,"';");
                if (strpos($infoline,'$DocVers') > 0) 
                    $c= strpos($infoline,'$DocVers')+10; else
                    $c= strpos($infoline,'$DocVer' )+9;
                // $d= strpos($infoline,'$DocRev')+9;
                if (strpos($infoline,'$DocRev1') > 0) 
                    $d= strpos($infoline,'$DocRev1')+10; else
                    $d= strpos($infoline,'$DocRev' )+9;
                $file= substr($infoline,$a,$b-$a);
                $vers= substr($infoline,$c,5);
                $date= substr($infoline,$d,10);
                $html.= '<br><b><big>Source-file:  '.$file.' vers: '.$vers.' date: '.$date.'</big></b><br>'; 
                //_// echo $html;
            }
            // if (strpos(' '.$line,'$DocFil')>0) echo "<pre>".$line."</pre>";
            if ($p=strpos(' '.$line,$searchWord)) { 
            if (($p<6) and               // PLACED at start of line!
            (strpos($line,'htm_')>0))    // is an html_ function
            { 
                if ($s=strpos($line,"{")) $funcN= ' '.substr($line,$p,$s-$p); 
                else                      $funcN= ' '.substr($line,$p);
                $funcN= str_replace('(','</b></strong>(<i>',$funcN);                                    // Add format code
                $funcN= str_replace(')',');',$funcN);
                $funcN= str_replace('# ','',$funcN); // Remove comment flag on function parameters
                $funcN= highlight_words($funcN,'','color:'.'red; ');
                $funcN= '<strong style="font-size: 16px;">'.substr($funcN,strlen($searchWord)).'</i>';  // Add format code
                
                $lno= $LinNo;
                $lno= str_pad($lno,5,' ',STR_PAD_LEFT);
                $str= "<pre>
".'  '.$sourceFile.str_repeat(" ",max(16-strlen($dir.$sourceFile),0)).
' <small><i>'.$lno.':</i></small> '.$funcN.'</i></pre>';
              //_// echo $str; //.' '.substr($str,42);
              $arrFunctions[]= [
                  'key' => strtoupper(substr($str,42,strpos($str,'(')-42)),
                  'val' => $str
              ];
              //_// 
              $html.= $str;
              }
              if ((strpos($sourceFile,'out_')) and (strpos($sourceFile,'.php'))) {   //  2. KRITERIE: Filnavn
                $fras= $line;
                #
                $str= "<br>".$line;
                while (strpos($fras,$searchWord)) {
                  $p= strpos($fras,$searchWord);  $fras= substr($fras,$p+1);  $b= strpos($fras,"'");
                  $fras= html_entity_decode($fras);
                  $fras= strip_tags($fras);
                  $prettyFras= substr($fras,0,$b);
                  //$prettyFras= '<b>XXX'.substr($prettyFras,strlen($searchWord),strpos($prettyFras,')')).'</b>';
                  //_// echo $str;
                  //_// 
                  $html.= $str;
                  $str= '<br>"'.$prettyFras.'"'.
                    str_repeat("&nbsp;",170-strlen(utf8_decode(substr($fras,0,$b)))).',"","","","","",""';  
                  //_// echo $str;
                  //_// 
                  $html.= $str; 
                  $f= substr($fras,0,$b);
                # $f= strip_tags($f);
                # echo '<br>'.strip_tags($f, '<p><small><b><a><u>');
                # echo '<br>'.htmlspecialchars_decode($f);
                  $fraser[] = ['"'.$f.'"'];
                } 
              } $count++; $total++;
            } }
            
            usort($arrFunctions, 'sortByKey');
            $capt = '<div style="background-color:#fffff0; padding:8px;">Sorted by name:<br>';
            //_// echo $capt; 
            $html= $capt;
            foreach ($arrFunctions as $elem) { //_// echo $elem['val']; 
                //_// 
                $html.= $elem['val']; 
                }
            //_// echo '</div>';  $html.= '</div>';
            
          $count= substr('000'.$count,-3); 
          if ($count>0) $buff[] = '<br>Ialt: '.$count.' forekomst(er) af: "<font color=red>'.$searchWord.'</font>" i <i>'.$dir.'</i><b>'.$sourceFile.'</b>';
      } } 
      file_put_contents('Functions.html',$html);
    }
  }
  if (is_object($d)) $d->close();
  //_// echo '</p>';
  /* 
  echo 'BEMÆRK: listen kan være ukomplet, hvis systematikken i kildefilerne, ikke er konsekvent! (max 4 tegns indrykning af: "function")'."<br>";
  foreach ($buff as $buf) {echo $buf;};
  echo '<br>Total: '.$total. ' forekomst(er) af: <i>'.$searchWord.'</i> i de undersøgte filer<br>';
   */
  $fraser= array_unique($fraser, SORT_REGULAR);
  sort($fraser);
# var_dump($fraser); echo '<br>';
//  echo '<br>Sorteret liste uden dubletter:';
  $x= 0;
  foreach ($fraser as $frase) {if (strlen($frase[0])>3) echo '<br>'./* $x++.'  '. */trim($frase[0],'"');};
# var_dump($GLOBALS['system']);
# phpinfo();
// ToDo: Dubletter fjernes, listen sortes og resultatet gemmes i fil.
?>
