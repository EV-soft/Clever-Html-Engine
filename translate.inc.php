<? $DocFile='../translate.inc.php';    $DocVer='1.2.2';    $DocRev='2022-12-26';      $DocIni='evs';  $ModulNo=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2022 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
require_once ($sys.'php2html.lib.php');
require_once ($sys.'menu.inc.php');
// require_once ($sys.'translate.inc.php');
require_once ($sys.'filedata.inc.php');


/**
 * Scann sourcetxt for strings in func lang('') and others to translate:
 * @param string $code to analyse
 * @output to screen
 */
function scannLngStrings($code= 'dk') {
    global $arrLang, $App_Conf;
    function scannfor($searchPref, $searchSuff='', &$count, &$longest, &$total, &$arrStrings, $flag='') { 
        $gbl_ProgRoot= './'; 
        $sys_Root= '../';
        ## Source files to scann:
        $lines = file(__FILE__);  // This file: translate.inc.php
        $files= [$sys_Root.'php2html.lib.php',
            //   $gbl_ProgRoot.'menu.inc.php',
                $gbl_ProgRoot.'translate.page.php',
                $gbl_ProgRoot.'../filedata.inc.php',
        ## Other project files to scann:
                $gbl_ProgRoot.'Demo.page.php',
                $gbl_ProgRoot.'CustomerOrder.page.php',
                $gbl_ProgRoot.'accountPlan.page.php'
                // './Proj.demo/CustomerOrder.page.php'
                //  $gbl_ProgRoot.'folder-explorer.php'
                ];
        echo '<br><b>Searching </b>for string: '.$searchPref.'<small>';
        foreach ($files as $fname) { 
            $lin= file($fname); 
            if ($lin) { $lines = array_merge($lines, $lin); echo '<br> Project FILE: <b>'.$fname.'</b>'; }
            else echo '<br>Not found FILE: <b>'.$fname.'</b>';
        }
        echo '</small>';

        ## Process the files contents:
        foreach ($lines as $aline => $line) {
            if ($a= strpos(' '.$line,$searchPref)) {
                $str= $line;
                while (strpos($str,$searchPref)) {
                    $str= substr($str, strpos($str,$searchPref) +strlen($searchPref)-1);
                    $str= html_entity_decode($str);
                    $longest= max($longest,strlen(utf8_decode(substr($str,0,strpos($str,$searchSuff)))));
                    $f= ''.htmlspecialchars(substr($str,0,strpos($str,$searchSuff)));  // Allow showing HTML tags
                    if (strpos($line, 'scannfor') == 0)                             // exclude scanfor parameters
                        $arrStrings[] = $f;                                         // = $flag.$f;  // Deactivate Flag
                }
                $count++; $total++;
        }   }
    }  // scannLngStrings
    
    function space($rept=1) { return str_repeat('&nbsp;',max(0,$rept)); }
    

    $total= 0;    $count= 0;    $arrStrings= array();   $longest= 0;    $flag= '';  // $flag: Prefix on key for sorting on kategory
# FUNCTIONS:
    scannfor("lang('@",      "')",  $count, $longest, $total, $arrStrings, 'std: '); // lang(' = standard user interface
    /* 
    scannfor("mess('@",      "')",  $count, $longest, $total, $arrStrings, 'sys: '); // mess(' = system messages
    scannfor("sprintf('@",   "')",  $count, $longest, $total, $arrStrings, 'sys: '); // set_msg(sprintf('  = system messages
     */
 // scannfor("alert('",,  "'), ",  $count, $longest, $total, $arrStrings, 'sys: '); // alert('You..');  = system messages
 // scannfor("die('",     "'), ",  $count, $longest, $total, $arrStrings, 'sys: '); 
# Other STRINGS:
    scannfor("'@",          "'",   $count, $longest, $total, $arrStrings, 'bas: '); // Strings in Lookup tables etc. (not combined with lang()/mess() )

    $count= substr('00'.$count,-3);
    $arrStrings= array_unique($arrStrings, SORT_REGULAR);   // Remove duplicates
    sort($arrStrings, SORT_STRING +SORT_FLAG_CASE);         // Sort the list

# OUTPUT:
    echo '<p style="font-size:11; ">';
    $arrLang = sys_get_translations();  //  All existing lng in _trans.sys.json
//     arrPretty($arrLang,'$arrLang');
    $lang= 'en';    //  System
    //$code= 'de';  //  Analyse
    $name= ($_SESSION['currLang']['name'] ?? '');
    $nati= ($_SESSION['currLang']['native'] ?? ''); // Update problem ! FIXIT
    // $nati= $arrLang[$code]['native'];
    // arrPrint($_SESSION['currLang'],'$_SESSION["currLang"]');
    if(array_key_exists('en',$arrLang ?? [])) {echo 'Data: '.$arrLang['en']; }

    echo '<br><b>The current strings to translate:</b>';
    echo '<br>Without duplicates - Total: '.count($arrStrings).' strings. The longest phrase is on '.$longest.' characters. <br>';
    //echo '<br>Nearly all user interface, can be translated. This page and a few error- and system messages is still only in english!  <br>';
    echo '<br><b>Analysing - '.$App_Conf['language'].' / '.$nati./* array_search($arrLang,substr($App_Conf['language'],0,2)). */'</b>';
    echo '<br>Below is the updated and sorted JSON code, that you can use to create/complete/maintain your language. <br>';
    echo '<br><b>How:</b>';
    echo '<br>Copy / Paste the string-list to your editor, and translate to your language. (UTF8 file-format!)';
    //echo '<br>If some strings is in <span style="color:red;">red</span>, they are missing in the language translate.';
    echo '<br>If some strings are missing in the language translate, the english text will be shown with prefix ???:';
    echo '<br>Let your browser search and mark this prefix, to get overview';
    echo '<br><br>Be aware of character: <b>"</b> inside strings, must be escaped as: <b>\"</b> without separating space !
         <br>If you have trouble after editing _trans.sys.json, you can test the file in
         <br>a validator e.g.:  https://jsonformatter.curiousconcept.com/ <br>';
    echo '<br>To use your translate, the text should be copyed to the system-file: _trans.sys.json';
    echo '<br>If you have a complete translated language, do share it on GITHUB<br><br>';
    
    echo '<span style="padding-left:60px;">KEY (english)</span>   <span style="margin-left:300px;">TRANSLATED</span><br>';
    
    echo '<textarea rows="30" id="EditText" name="EditText" style="line-height:100%; width:100%; white-space: pre; overflow-x: auto;" >';   // .$valu.'</textarea>';
    $lf= '&#013;&#010;';
    ## Translation Start:
    echo $lf.'  {';
    echo $lf.'    "code": "'.  $code.'",            '.str_sp(44-strlen('code": "'.  $code)).    '┐';         //  .'{ISO lngCode: en}",';
    echo $lf.'    "name": "'.  $name.'",            '.str_sp(44-strlen('name": "'.  $name)).    '|';         //  .'{lngName: English}",';
    echo $lf.'    "native": "'.$nati.'",            '.str_sp(44-strlen('native": "'.$nati)).    '|';         //  .'{lngName: Native}",';
    echo $lf.'    "author": "-auto from source-",   '.str_sp(43-strlen('-auto from source-')).  '├—— Example'; 
    echo $lf.'    "note": "'.''.'",                 '.str_sp(34-strlen('   ')).                 '|';         // setlocale(LC_TIME, 'da_DK','da','da_DK.utf8'); ?
    echo $lf.'    "DateTime": "'.date("Y-m-d").'",  '.str_sp(42-strlen(date("Y-m-d"))).         '|';
    echo $lf.'    "AppName": "PHP to HTML",         '.str_sp(36-strlen('PHP to HTML')).         '┘';
    // $transTable['en']['AppName'] = 'PHP to HTML';
    echo $lf.'    "translation": {';
    
    $n = count($arrStrings)-1; $i= 0;   $miss = 0;  $next= ',';
    $googleFile = fopen("sys_2Google.txt", "w");
    $temp = fopen('_trans.'.$code.'.tmp.json', "w");
    $prev= '';
    $strMiss= '';
    fwrite($temp,'"translation": {'.chr(13).chr(10));
    // $arrLang['en']= [];  // Build new translate table for english
    
    ## Translation Body:
    $indx = array_search('da', array_column($arrLang, 'code'));
    // echo $indx; 
    // arrPretty($arrLang[$indx]['translation'],'$arrLang[$indx][\'translation\']');
    foreach ($arrStrings as $str) {
        $i++;
        if (strlen($str)>4) {
        $str= trim($str,'@');
        $str= rtrim($str,'\\');
        $str= html_entity_decode(substr($str,strlen($flag)));   // echo ' ',$str;
        $str= str_replace ('"', '\"', $str );
        $arrLang['en'][$str] = $str; 
        $strLang= @$arrLang[$indx]['translation'][$str];    // Supress error messages
        if (!$strLang) { $missing= ''.$code.' ???: '.$str; $miss= $miss+1; $strMiss.= '"'.$str.'"'.chr(13).chr(10); } 
        else             $missing= '';
        if ($i>=$n-2) $next= ''; 
        fwrite($googleFile, '"'.$str .'"'.$next.chr(13).chr(10));
        echo $lf.str_pad(' ',6,' ').'"'.$str.'": '.space(55-strlen($str)).'"'.$missing.$strLang.'"';
        if ($prev != $str)     // Prevent dublets
            fwrite($temp, str_pad(' ',6,' ').'"'.$str.'":'.'"'.$missing.$strLang.'"');
        if (($i<=$n) and ($prev != $str)) { echo ','; fwrite($temp,','.chr(13).chr(10)); } //  Not after the last!
        $prev= $str;
    }}
    fwrite($temp, chr(13).chr(10).'}');
    fclose($temp);
    fclose($googleFile);
    ## Translation End:
    echo $lf.'      }';
    echo $lf.'  },';
    echo '</textarea><br>';
    
    // arrPrint($arrLang,'$arrLang');
    // arrPrint($arrStrings,'$arrStrings');
    
    $doSave= false;
 //   echo lang('@Edit in the above window, and save the content to file: ');
 //   echo '<button type="button" data-title="'.lang('@Save the content in edit-window to file (Inactive DEMO)').'" onclick="file_save($doSave= true;)">
 //            <span >SAVE</span>
 //         </button>'. ' Demo!';
    $workarea= $_POST['EditText'] ?? '';
    if ($doSave == true)    // @FIXIT
    //if ((isset($workarea)) and (strlen($workarea)>10))
        { $f = fopen('new.json',"w");   
            fwrite($f, $workarea);  fclose($f); 
            set_msg('@File Saved Successfully');
            toast(lang('@Saved in systemfile ').'new.json');
        }
    
    htm_nl(2);
    echo lang('@A file').'<b> _trans.'.$code.'.tmp.json</b> '.lang('@has been created with the content of translation-data<br>You can use it to update _trans.sys.json');
    htm_Input($labl='_trans.'.$code.'.tmp.json',$plho='@Empty !',$icon='',$hint='@The newly generated file _trans.'.$code.'.tmp.json',
              $type= 'area',$name='file',$valu= file_get_contents ('_trans.'.$code.'.tmp.json'),
              $form='',$wdth='930px',$algn='left',$attr= 'wrap = "off"; overflow-x: auto;',$rtrn=false,$unit='',$disa=false,$rows='10');

    htm_nl(2);
    echo '<br><br>'.lang('@<b>A file with all keys: sys_2Google.txt has been created. </b><br>You can use it in Google translate.<br>');
    echo lang('@Do copy-paste the content from this window...<br>');
                                 // $googleFile = fopen("sys_2Google.txt", "w");
                                 // $gog= file_get_contents ("sys_2Google.txt");
                                 // foreach ($gog as $line) $string= $string + '<br>' + $line;
    
    htm_Input($labl='sys_2Google.txt',$plho='@Empty !',$icon='',$hint='@The newly generated file to Google-translate',
              $type= 'area',$name='goog',$valu= file_get_contents ("sys_2Google.txt"),
              $form='',$wdth='930px',$algn='left',$attr=' wrap = "off";',$rtrn=false,$unit='',$disa=false,$rows='10');
    htm_nl(2);
    
/* 
    $i= 0;
    echo '<br><br><b>Missing translate ?</b><br>Keys in language "'.$App_Conf['language'].' / '.$nati.'" with string the same as the key:<br>';
    foreach ($arrLang[$code] ?? [] as $key => $value) { 
        if (in_array($key,$arrLang[$code])) echo '<br>Same: '.$i++.' '.$key; 
    }
    if ($i==0) echo 'None<br>';
    echo '<br><br>';
 */
    $i= 0;
    echo '<br><b>Outdated keys ?</b><br>Unused keys in language "'.$App_Conf['language'].' / '.$nati.'" in this project (maybe renamed key):<br>';
    foreach ($arrLang[$code] ?? [] as $key => $value) {
       if (!in_array($key,$arrLang['en'])) echo '<br>Outd: '.$i++.' '.$key;
    }
    if ($i==0) echo 'None<br>';
    
    echo '<br><br><b>'.lang('@Status:').' '. round(100-($miss/$n*100)). ' % '.lang('@translated').'</b><br>'.lang('@There are missing').': '.$miss.' of '.count($arrStrings);
    echo '<br>';
    htm_Input($labl='@Missing translate',$plho='@Empty !',$icon='',$hint=lang('@Missing in ').$nati,
              $type= 'area',$name='goog',$valu=$strMiss,$form='',$wdth='930px',$algn='left',$attr= '',$rtrn=false,$unit='',$disa=false,$rows='10');

    $trns= file_get_contents ("../_trans.sys.json");
    echo '<br><br><b>Active translate table</b><br>';
    htm_Input($labl='_trans.sys.json',$plho='@Empty !',$icon='',$hint='@Here you can see the actuel translate table',
              $type= 'area',$name='goog',$valu=$trns, $form='',$wdth='930px',$algn='left',$attr=' wrap = "off";',$rtrn=false,$unit='',$disa=false,$rows='10');
    echo '<br><br>';
} // scannLngStrings();


function langList() {
    $lngLst= [];  $i= 0;
    $lines = [''];  //$lines = file('.sys_language-codes.csv');  //  source
        foreach ($lines as $aline => $line) {
          $code= substr($line,0,2);
          $lang= substr($line,3);
          if ($i++ > 0) { $lngLst[$code] = $code.': '.$lang; };
        }
    return $lngLst;
}

$langList= langList();

function SelNew($langList) {
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
//                     DateTime
#      echo '<br>'.'  "translation": {';
#      echo '<br>'.'  }';
#      echo '<br>'.'},';
#    }

function DBcorrect() {
       $content = file_get_contents('../_trans.sys.json');
       $temp_list= [];
        if($content !== FALSE) {
            $lng = json_decode($content, TRUE);
            // print_r($lng);
            foreach ($lng["language"] as $key => $value)
            {   $lang_rec["code"]        = $value["code"];                  // $value["code"];
                $lang_rec["name"]        = $value["name"];                  // $value["name"];      Name in english
                $lang_rec["native"]      = $value["native"];                // $value["native"];    Name translated from english
                $lang_rec["author"]      = $value["author"];                // $value["author"];
                $lang_rec["note"]        = $value["DateTime"];                  // $value["note"];
                $lang_rec["DateTime"]    = $value["note"];              // $value["DateTime"]; // setlocale(LC_TIME, 'da_DK','da','da_DK.utf8'); ?
                $lang_rec["translation"] = $value["translation"];

                $temp_list[]= $lang_rec;
            }
            $temp_list= json_encode($temp_list,JSON_PRETTY_PRINT);
            $out = fopen('temp_list.out', "w"); fwrite($out, PHP_EOL. ($temp_list)); fclose($out);  // save pretty JSON-file
        }
}
// DBcorrect();

?>