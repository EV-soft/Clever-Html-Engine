<?php   $DocFile= '.\funcscann.php';    $DocVer='1.4.1';    $DocRev='2025-07-28';     $DocIni='evs';  $ModulNr=0; ## File informative only

    $d = dir("../../");  //    var_dump($d);
    // $paths = glob('../../*/*.{htm,php}',GLOB_BRACE); 
    $paths = glob('./*/*.{htm,php}',GLOB_BRACE);
    function sortByKey($a, $b) {
      return $a['key'] > $b['key'];
    }
    $searchWord= 'function ';

    if (is_readable('Functions.list')) {
        $basekeyList= file_get_contents('Functions.list');
        $basekeyList= explode('/', $basekeyList);        // foreach ($basekeyList as $key) echo '<br>'.$key;
    }

    $total= 0;    $buff= array();   $fraser= array(); $d = dir("/");  $html= ''; $arrFunctions= [];      $keyList=[];
    while ((is_object($d)) and (false !== ($entry = $d->read())) )
    {
    //if (false !== ($entry = $d->read())) {
    $dir= $entry.'/';
    if (is_dir($entry) ) {
      $files = scandir($dir);
      if ($files)
      foreach ($files as $sourceFile) { 
        $count= 0;  $searchWord= 'function ';   $arrFunctions= [];      $nn= 0;
        if ( ($sourceFile!=='.') and ($sourceFile!=='..') 
             and (!strpos($sourceFile,'.bak'))   //  Filter:
             and (in_array($sourceFile,[
                'php2html.lib.php'  /* ,
                'customLib.inc.php',
                'translate.inc.php',
                'menu.inc.php',
                'filedata.inc.php'  */
            ])) ) 
        {
          $fileLines = file($dir.$sourceFile); 
          $LinNo= 0;        $prevLine= '';      $BlockComm= false;
          //_//if ($basekeyList) echo 'Checking system functions call in '.$sourceFile.' <br>';
          foreach ($fileLines as $line_num => $line) { $LinNo++;
            if  (substr($line,0,2)=='/*') $BlockComm= true; else        # Multiline comments
            if ((substr($line,0,2)=='*/') or (substr($line,0,3)==' */')) $BlockComm= false;

        # Block comment example:    /* This is a comment */
        #                           p1                   p2
        #                from:        p1+2           to: p2 is the commentstring
        
            if ($p1=strpos($line,'/*')>0) if ($BlockComm= false) $BlockComm= true;
            if ($p2=strpos($line,'*/')>0) if ($BlockComm= true)  $BlockComm= false;
                # strings on same line between pos:p1 and pos:p2 are comments
                
            if ($LinNo==1) { // Get file-info:
                // <?php   $DocFil= './Proj.demo/CustomerOrder.page.php';    $DocVer='1.2.0';    $DocRev='2022-03-05';     $DocIni='evs';  $ModulNr=0; ## File informative only
                $infoline= substr($line,6);
                $a= strpos($infoline,"'")+1;
                $b= strpos($infoline,"';");
                if (strpos($infoline,'$DocVers') > 0) $c= strpos($infoline,'$DocVers')+10; 
                else                                  $c= strpos($infoline,'$DocVer' )+9; 
                if (strpos($infoline,'$DocRev1') > 0) $d= strpos($infoline,'$DocRev1')+10; 
                else                                  $d= strpos($infoline,'$DocRev' )+9;                
                $file= substr($infoline,$a,$b-$a);
                $vers= substr($infoline,$c,5);
                $date= substr($infoline,$d,10);
                $html.= '<br><b><big>Source-file:  '.$file.' vers: '.$vers.' date: '.$date.'</big></b><br>'; 
            }
            ## Statistic on functions call:
            foreach ($basekeyList as $key) {
                if (($p= strpos($line,$key.'(')>0) 
                    and (strpos($line,'unction ')<$p)   # Not the declarations
                    and (strpos($line,'//')<$p)         # Not in linecomment
                    and (strpos($line,'#')<$p)          # Not in linecomment
                    and ($BlockComm == false)           # Not in multilinecomment
                    or ((($p1+2)<$p) and ($p<$p2))      # Code and comment on same line
                    )
                    //_// echo '<br><b>'.$key.'</b>('./* $dir. */ $sourceFile.':'.$LinNo.') '
                    ;
            }
            // if (strpos(' '.$line,'$DocFil')>0) echo "<pre>".$line."</pre>";
            if ($p=strpos(' '.$line,$searchWord)) { 
            if (($p<6) and               // PLACED at start of line!
            (strpos($line,'htm_')>0)) {  // is an html_ function
                if (strpos(' '.$prevLine,'# ') > 0) 
                     $hint= ' title= "'.str_replace('# ','Concerning: ',$prevLine).'" '; 
                else $hint= '';
                if ($s=strpos($line,"{")) $funcN= ' '.substr($line,$p,$s-$p); 
                else                      $funcN= ' '.substr($line,$p);
                $x= substr($funcN,strpos($funcN,'htm_'));
                $x= substr($x,0,strpos($x,'('));
                $keyList[] = $x;
                $funcN= str_replace('(','</b></strong>(<i>',$funcN);                                                // Add format code
                $funcN= str_replace(')',');',$funcN);
                $funcN= str_replace('# ','',$funcN); // Remove comment flag on function parameters
                $funcN= highlight_words($funcN,'','color:'.'red; ');
                $funcN= '<strong style="font-size: 16px;" '.$hint.'>'.substr($funcN,strlen($searchWord)).'</i>';    // Add format code
                
                $lno= $LinNo;
                $lno= str_pad($lno,5,' ',STR_PAD_LEFT);
                $str= "<pre>
".'  '.$sourceFile.str_repeat(" ",max(16-strlen($dir.$sourceFile),0)).
' <small><i>'.$lno.':</i></small> '.$funcN.'</i></pre>';
                $nn++;
              //_// echo $str; //.' '.substr($str,42);
              $arrFunctions[]= [
                  'key' => strtoupper(substr($str,(strpos($str,'htm_')),strpos($str,'('))),
                  'val' => $str
              ];
              //_// 
              $html.= $str;
              }
              if ((strpos($sourceFile,'out_')) and (strpos($sourceFile,'.php'))) {   //  2. KRITERIE: Filename
                $fras= $line;
                #
                $str= "<br>".$line;
                while (strpos($fras,$searchWord)) {
                  $p= strpos($fras,$searchWord);  $fras= substr($fras,$p+1);  $b= strpos($fras,"'");
                  $fras= html_entity_decode($fras);
                  $fras= strip_tags($fras);
                  $prettyFras= substr($fras,0,$b);
                  $html.= $str;
                  $str= '<br>"'.$prettyFras.'"'.
                    str_repeat("&nbsp;",170-strlen(utf8_decode(substr($fras,0,$b)))).',"","","","","",""';  
                  $html.= $str; 
                  $f= substr($fras,0,$b);
                # $f= strip_tags($f);
                # echo '<br>'.strip_tags($f, '<p><small><b><a><u>');
                # echo '<br>'.htmlspecialchars_decode($f);
                  $fraser[] = ['"'.$f.'"'];
                }
              } $count++; $total++;
            } $prevLine= $line; }
            
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
          if ($count>0) $buff[] = '<br>Ialt: '.$count.' '.$nn.' forekomst(er) af: "<font color=red>'.$searchWord.'</font>" i <i>'.$dir.'</i><b>'.$sourceFile.'</b>';
      } } 
      file_put_contents('Functions.html',$html);
      file_put_contents('Functions.list',implode('/', $keyList));
      /* 
      $keyList= file_get_contents('Functions.list');
      $keyList= explode('/', $keyList);
      foreach ($keyList as $key) echo '<br>'.$key;
       */
    }
  }
  //_// echo '<br>System functions that are not mentioned here, may be removed to optimize the system.<br><br>';
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
