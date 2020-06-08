<? $DocFile='../Proj1/translate.inc.php';    $DocVers='1.0.0';    $DocRev1='2020-06-08';     $DocIni='evs';  $ModulNo=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('filedata.inc.php');


/**
 * Scann sourcetxt for strings in func lang('') and others to translate:
 * @param string $code to analyse
 * @output to screen
 */
function scannLngStrings($code= 'dk') {
    global $lang_list, $App_Conf;
    function scannfor($searchPref, $searchSuff='', &$count, &$longest, &$total, &$arrStrings, $flag='') {
        # Source files:
        $lines = file(__FILE__);  // This file: translate.inc.php
        $files= ['php2html.lib.php','Demo.page.php','menu.inc.php','translate.page.php'];    // Other files to scann
        foreach ($files as $fname) { $lines = array_merge($lines, file($fname));  /* echo ' '.count($lines); */ }
        //arrPrint($lines,'$lines'); 
        foreach ($lines as $aline => $line) {
            if ($a= strpos(' '.$line,$searchPref)) {
                $str= $line;
                while (strpos($str,$searchPref)) {
                    $str= substr($str, strpos($str,$searchPref) +strlen($searchPref)-1);
                    $str= html_entity_decode($str);
                    $longest= max($longest,strlen(utf8_decode(substr($str,0,strpos($str,$searchSuff)))));
                    $f= htmlspecialchars(substr($str,0,strpos($str,$searchSuff)));  // Allow showing HTML tags
                    if (strpos($line, 'scannfor') == 0) // exclude scanfor parameters
                        $arrStrings[] = $f; // = $flag.$f;  // Deactivate Flag
                }
                $count++; $total++;
        }   }
    }
    function space($rept=1) { return str_repeat('&nbsp;',max(0,$rept)); }
    

    $total= 0;    $count= 0;    $arrStrings= array();   $longest= 0;    $flag= '';  // $flag: Prefix on key for sorting on kategory
# FUNCTIONS:
    scannfor("lang('",      "')",  $count, $longest, $total, $arrStrings, 'std: '); // lang(' = standard user interface
    scannfor("mess('",      "')",  $count, $longest, $total, $arrStrings, 'sys: '); // mess(' = system messages
    scannfor("sprintf('",   "')",  $count, $longest, $total, $arrStrings, 'sys: '); // set_msg(sprintf('  = system messages
 // scannfor("alert('",,  "'), ",  $count, $longest, $total, $arrStrings, 'sys: '); // alert('You..');  = system messages
 // scannfor("die('",     "'), ",  $count, $longest, $total, $arrStrings, 'sys: '); 
# Other STRINGS:
    scannfor("'@",          "'",   $count, $longest, $total, $arrStrings, 'bas: '); // Strings in Lookup tables etc. (not combined with lang()/mess() )

    $count= substr('00'.$count,-3);
    $arrStrings= array_unique($arrStrings, SORT_REGULAR); // Remove duplicates
    sort($arrStrings, SORT_STRING +SORT_FLAG_CASE);
    $arrStrings= array_unique($arrStrings, SORT_REGULAR); // Remove duplicates
# OUTPUT:
    echo '<p style="font-size:11; ">';
    $lngArr = sys_get_translations(['']);  //  All existing lng in /sys_trans.json
    $lang= 'en';    //  System
    //$code= 'de';  //  Analyse
    $name= $lang_list[$code];
    $nati= $_SESSION['currLang']['native'];
    //arrPrint($_SESSION['currLang'],'$_SESSION["currLang"]');
    if(array_key_exists('en',$lang_list)) {echo 'Data: '.$lang_list['en']; }

    echo '<br><b>The current strings to translate:</b>';
    echo '<br>Without duplicates - Total: '.count($arrStrings).' strings. The longest phrase is on '.$longest.' characters. <br>';
    //echo '<br>Nearly all user interface, can be translated. This page and a few error- and system messages is still only in english!  <br>';
    echo '<br><b>Analysing - '.$App_Conf['language'].' / '.$nati./* array_search($lang_list,substr($App_Conf['language'],0,2)). */'</b>';
    echo '<br>Below is the updated and sorted JSON code, that you can use to create/complete/maintain your language. <br>';
    echo '<br><b>How:</b>';
    echo '<br>Copy / Paste the list to your editor, and translate to your language. (UTF8 file-format!)';
    //echo '<br>If some strings is in <span style="color:red;">red</span>, they are missing in the language translate.';
    echo '<br>If some strings are missing in the language translate, the english text will be shown with prefix ???:';
    echo '<br>Let your browser search and mark this prefix, to get overview';
    echo '<br><br>Be aware of character: <b>"</b> inside strings, must be escaped as: <b>\"</b> without separating space !
         <br>If you have trouble after editing translate.inc.php, you can test the file in
         <br>a validator e.g.:  https://jsonformatter.curiousconcept.com/ <br>';
    echo '<br>To use your translate, the text should be copyed to the system-file: .sys_trans.json';
    echo '<br>If you have a compleate translated language, do share it on GITHUB<br><br>';
    
    echo '<span style="padding-left:55px;">KEY (english)</span>   <span style="margin-left:380px;">TRANSLATED</span><br>';
    
    echo '<textarea rows="30" id="EditText" name="EditText" style="line-height:100%; width:100%; white-space: pre; overflow-x: auto;" >';   // .$valu.'</textarea>';
    $lf= '&#013;&#010;';
    echo $lf.'  {';
    echo $lf.'    "code": "'.  $code.'",';  //  .'{ISO lngCode: en}",';
    echo $lf.'    "name": "'.  $name.'",';  //  .'{lngName: English}",';
    echo $lf.'    "native": "'.$nati.'",';  //  .'{lngName: Native}",';
    echo $lf.'    "author": "-auto from source-",';
    echo $lf.'    "note": "'.date("Y-m-d").'",';
    echo $lf.'    "translation": {';
    $n = count($arrStrings)-1; $i= 0;   $miss = 0;  $next= ',';
    $googleFile = fopen("sys_2Google.txt", "w");
    $lngArr['en']= [];  // Build translate table for english
    // @ini_set('display_errors', 0);  // Deactivate error messages here:
    foreach ($arrStrings as $str)
        if (strlen($str)>4) {
        $str= trim(substr($str,1),'@');
        $str= html_entity_decode(substr($str,strlen($flag)));
        $lngArr['en'][$str] = $str;
        $lngstr= @$lngArr[$code][$str];
        if (!$lngstr) { $missing= ''.$code.' ???: '.lang($str); $miss= $miss+1; } else $missing= '';
        if ($i>=$n-2) $next= '';
        $i++;
        fwrite($googleFile, '"'.str_replace ('"', '\"', $str ) .'"'.$next.chr(13).chr(10));
        echo $lf.str_pad(' ',6,' ').'"'.$str.'": '.space(55-strlen($str)).'"'.$missing.$lngstr.'"';
        if ($i<$n) echo ','; //  Not after the last!
    }
    fclose($googleFile);
    echo $lf.'      }';
    echo $lf.'  },';
    echo '</textarea><br>';
    
    // arrPrint($lngArr,'$lngArr');
    // arrPrint($arrStrings,'$arrStrings');
    
    $doSave= false;
 //   echo lang('@Edit in the above window, and save the content to file: ');
 //   echo '<button type="button" data-title="'.lang('@Save the content in edit-window to file (Inactive DEMO)').'" onclick="file_save($doSave= true;)">
 //            <span >SAVE</span>
 //         </button>'. ' Demo!';
    $workarea= $_POST['EditText'];
    if ($doSave == true)    // @FIXIT
    //if ((isset($workarea)) and (strlen($workarea)>10))
        { $f = fopen('new.json',"w");   
            fwrite($f, $workarea);  fclose($f); 
            set_msg('@File Saved Successfully');
            toast(lang('@Saved in systemfile ').'new.json');
        }
    echo '<br><br><b>A file with all keys: sys_2Google.txt has been created. You can use it in Google translate.</b><br>';
    echo 'You can copy-paste the content from this window...<br>';
                                 // $googleFile = fopen("sys_2Google.txt", "w");
                                 $gog= file_get_contents ("sys_2Google.txt");
                                 //foreach ($gog as $line) $string= $string + '<br>' + $line;
    htm_Input($type='area',$name='goog',$valu=$gog,$labl='sys_2Google.txt',  $llgn='L', $hint='@The newly generated file to Google-translate',
                    $algn='left',$unit='',$disa=false,$rows='10',$width='930px',$step='',$more=$m,$plho='@Empty !');
        
    $i= 0;
    echo '<br><br><b>Keys in language "'.$App_Conf['language'].' / '.$nati.'" with string the same as the key </b>(missing translate ?):<br>';
    foreach ($lngArr[$code] as $key => $value) { 
        if (in_array($key,$lngArr[$code])) echo '<br>Same: '.$i++.' '.$key; 
    }
    if ($i==0) echo 'None<br>';
    
    // doDebug($arrStrings,'$arrStrings','LINE: '.__LINE__);
    // doDebug($lngArr['en'],'$lngArr["en"]','LINE: '.__LINE__);
    // doDebug($lngArr['da'],'$lngArr["da"]','LINE: '.__LINE__);
    echo '<br><br>';

    $i= 0;
    echo '<br><b>Outdated keys in language "'.$App_Conf['language'].' / '.$nati.'" not used </b>(maybe renamed key?):</b><br>';
    foreach ($lngArr[$code] as $key => $value) {
       if (!in_array($key,$lngArr['en'])) echo '<br>Outd: '.$i++.' '.$key;
    }
    if ($i==0) echo 'None<br>';
    
    echo '<br><br><b>'.lang('@Status:').' '. round(100-($miss/$n*100)). ' % '.lang('@translated').' - '.lang('@There are missing').': '.$miss.' of '.count($arrStrings).'</b>';
    echo '<br><br>';
} // scannLngStrings();


function langList() {
    $lngLst= [];  $i= 0;
    //$lines = file('.sys_language-codes.csv');  //  source
                                 $lines = [''];
        foreach ($lines as $aline => $line) {
          $code= substr($line,0,2);
          $lang= substr($line,3);
          if ($i++ > 0) { $lngLst[$code] = $code.': '.$lang; };
        }
    return $lngLst;
}

  $langList= langList();

function SelNew($langList) {
//doDebug($langList,'$langList');
    echo '<div class="form-group row">'.
         '    <label for="js-newLanguage" class="col-sm-3 col-form-label right" >'. 'Dont work yet! '.lang('@Create new language').':</label>'.
         '    <div class="col-sm-5">'.
         '        <select class="form-control" id="js-newLanguage" name="js-newLanguage">';
                      function getSelected($l) { global $lang; return ($lang == $l) ? 'selected' : ''; }
                      foreach ($langList as $k => $v) {
                          echo "<option value='$k' ".getSelected($k).">$v</option>";
                      }
    echo '        </select>'.
         '    </div>'.
         '</div>';
}



    // $ISO639= ReadCSV($filepath='ISO639-1.csv');
    // arrPrint($ISO639,'ISO639'); 
#    foreach ($ISO639  as $lang) if (strlen($lang[0])==2) {
#      echo '<br>'.'{';
#      echo '<br>'.'  "code": "'.$lang[0].'",';
#      echo '<br>'.'  "name": "'.$lang[1].'",';
#      echo '<br>'.'  "native": "'.$lang[2].'",';
#      echo '<br>'.'  "author": "-none-",';
#      echo '<br>'.'  "note": "'.date("Y-m-d").'",';
#      echo '<br>'.'  "translation": {';
#      echo '<br>'.'  }';
#      echo '<br>'.'},';
#    }

?>