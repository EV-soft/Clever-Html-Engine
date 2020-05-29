<? $DocFile='../Proj1/translate.inc.php';    $DocVers='1.0.0';    $DocRev1='2020-05-29';     $DocIni='evs';  $ModulNo=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 

/**
 * Scann sourcetxt for strings in func lang('') and others to translate:
 * @param string $code to analyse
 * @output to screen
 */
function scannLngStrings($code= 'de') {
    function scannfor($search, &$count, &$longest, &$total, &$arrStrings, $flag='') {
		# Source files:
		$lines = file(__FILE__);  // This file: translate.inc.php
		$files= ['php2html.lib.php','Demo.page.php','menu.inc.php'];    // Other files to scann
		foreach ($files as $fname) $lines = $lines + file($fname);
        foreach ($lines as $aline => $line) {
          if ($a= strpos(' '.$line,$search)) {
              $str= $line;
              while (strpos($str,$search)) {
                  $a= strpos($str,$search);
                  $str= substr($str,$a+5);
                  $b1= strpos($str,"')");
                  $b2= strpos($str,"', ");
                  if ($search=="lang('") $b= $b1; else $b= $b2;
                  $str= html_entity_decode($str);
                  $longest= max($longest,strlen(utf8_decode(substr($str,0,$b))));
                  $f= htmlspecialchars(substr($str,0,$b));  // Allow showing HTML tags
                 // $f= str_replace('<','&lt;',$f);         // Allow showing HTML tags
                 // $f= str_replace('>','&gt;',$f);         // $f = htmlspecialchars($f); ?
                 if (strpos($f, '$longest') == 0)           // Filter parameter for scannfor()
                   $arrStrings[] = $flag.$f;
              }
            $count++; $total++;
          } }
    }
    function space($rept=1) { return str_repeat('&nbsp;',max(0,$rept)); }
    
    global $lang_list;

    $total= 0;    $count= 0;    $arrStrings= array();   $longest= 0;    $flag= ''; //'std: ';   // $flag: Prefix on key for sorting on kategory
    scannfor("lang('", $count, $longest, $total, $arrStrings, ''); //  'std: '); // lang(' = standard user interface
    scannfor("msg('", $count, $longest, $total, $arrStrings, ''); //  'sys: '); // msg(' = system messages
    scannfor("ntf('", $count, $longest, $total, $arrStrings, ''); //  'sys: '); // set_msg(sprintf('  = system messages
    //scannfor("ert('", $count, $longest, $total, $arrStrings, ''); //  'sys: '); // alert('You..');  = system messages
    //scannfor("die('", $count, $longest, $total, $arrStrings, ''); //  'sys: ');

    $count= substr('00'.$count,-3);
    $arrStrings= array_unique($arrStrings, SORT_REGULAR); // Remove duplicates
    sort($arrStrings);
    
    echo '<p style="font-family:courier; font-size:11; ">';
    $lngArr = sys_get_translations(['']);  //  All existing lng in /sys_trans.json
    $lang= 'en';    //  System
    //$code= 'de';  //  Analyse
    $name= $lang_list[$code];
    switch (strtolower($code)) {
        case 'en':      $nati = 'English'; echo '<br><br>English is in source-files, not in .sys_trans.json! It could, if you wish to modify it.<br>'; break;
        case 'da':      $nati = 'Dansk'; break;
        case 'ru':      $nati = 'русский'; break;
        case 'it':      $nati = 'Italiano'; break;
        case 'fr':      $nati = 'Français'; break;
        case 'hu':      $nati = 'Hungarian'; break;
        case 'es':      $nati = 'Español'; break;
        case 'ca':      $nati = 'Català'; break;
        case 'de':      $nati = 'Deutsch'; break;
        case 'th':      $nati = 'ภาษาไทย'; break;
        case 'zh-cn':   $nati = '简体中文'; break;
        case 'zh-tw':   $nati = '中文(繁體)'; break;
        case 'id':      $nati = 'Bahasa Indonesia'; break;
        case 'el':      $nati = 'Ελληνικά'; break;
        case 'pt':      $nati = 'Português'; break;
        case 'pl':      $nati = 'Polski'; break;
        case 'vi':      $nati = 'Việt Nam'; break;
        case 'he':      $nati = 'Hebrew'; break;
        case 'ar':      $nati = 'العربية'; break;
        case 'cs':      $nati = 'Česky'; break;
        default:        $nati = 'Enter it...';
    }

    echo '<br><b>The current Language:</b>';
    echo '<br>Without duplicates - Total: '.count($arrStrings).' strings. The longest phrase is on '.$longest.' characters. ';
    echo '<br>Nearly all user interface, can be translated. This page and a few error- and system messages is still only in english!  <br>';
    echo '<br><i>Analysing: "'.$code.'": '.$name.'</i>';
    echo '<br>Here is the updated and sorted JSON code, that you can use to create / complete / maintain your language:';
    echo '<br>Copy / Paste the list to your editor, and translate to your language. (UTF8 file-format!)';
    //echo '<br>If some strings is in <span style="color:red;">red</span>, they are missing in the language translate.';
    echo '<br>If some strings are missing in the language translate, the english text will be shown with prefix ???:';
    echo '<br>Let your browser search and mark this prefix, to get overview';
    echo '<br>To use your translate, the text should be copyed to the system-file: .sys_trans.json';
    echo '<br>If you have a compleate translate, do share it on GITHUB<br><br>';
    echo '<span style="padding-left:55px;">KEY (english)</span>   <span style="margin-left:380px;">TRANSLATED</span><br>';
    echo '<textarea rows="30" id="EditText" name="EditText" style="line-height:100%; width:100%; white-space: pre; overflow-x: auto;" >';   // .$valu.'</textarea>';
    //echo '<pre>';
    $lf= '&#013;&#010;';
    echo $lf.'  {';
    echo $lf.'    "code": "'.  $code.'",';  //  .'{ISO lngCode: en}",';
    echo $lf.'    "name": "'.  $name.'",';  //  .'{lngName: English}",';
    echo $lf.'    "native": "'.$nati.'",';  //  .'{lngName: Native}",';
    echo $lf.'    "author": "-auto-",';
    echo $lf.'    "note": "'.date("Y-m-d").'",';
    echo $lf.'    "translation": {';
    $n = count($arrStrings)-1; $i= 0;   $miss = 0;
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
        $i++;
        fwrite($googleFile, '"'.$str.'"'.chr(13).chr(10));
        echo $lf.str_pad(' ',6,' ').'"'.$str.'": '.space(55-strlen($str)).'"'.$missing.$lngstr.'"';
        if ($i<$n) echo ','; //  Not after the last!
    }
    fclose($googleFile);
    echo $lf.'      }';
    echo $lf.'  },';
    //echo '</pre>';
    echo '</textarea><br>';
    $doSave= false;
    echo lang('@Edit in the above window, and save the content to file: ');
    echo '<button type="button" data-title="'.lang('@Save the content in edit-window to file (Inactive DEMO)').'" onclick="file_save($doSave= true;)">
             <span >SAVE</span>
          </button>'.
		  ' Demo!';
    $workarea= $_POST['EditText'];
    if ($doSave == true)    // @FIXIT
    //if ((isset($workarea)) and (strlen($workarea)>10))
        { $f = fopen('new.json',"w");   
            fwrite($f, $workarea);  fclose($f); 
            set_msg('@File Saved Successfully');
            toast(lang('@Saved in systemfile ').'new.json');
        }
    echo '<br><br><b>A file with all keys: sys_2Google.txt has been created. You can use it in Google translate.</b><br>';
	// $googleFile = fopen("sys_2Google.txt", "w");
	$gog= file_get_contents ("sys_2Google.txt");
	//foreach ($gog as $line) $string= $string + '<br>' + $line;
    htm_Input($type='area',$name='goog',$valu=$gog,$labl='sys_2Google.txt',   $hint='@The newly generated file to Google-translate',
                    $algn='left',$unit='',$disa=false,$rows='10',$width='900px',$step='',$more=$m,$plho='@Remark?...');
        
    $i= 0;
    echo '<br><br>Keys in language "'.$code.'" with string the same as the key (missing translate ?):<br>';
    foreach ($lngArr[$code] as $key => $value) { 
        if (in_array($key,$lngArr[$code])) echo '<br>Same: '.$i++.' '.$key; 
    }
    if ($i==0) echo 'None<br>';
    
    // doDebug($arrStrings,'$arrStrings','LINE: '.__LINE__);
    // doDebug($lngArr['en'],'$lngArr["en"]','LINE: '.__LINE__);
    // doDebug($lngArr['da'],'$lngArr["da"]','LINE: '.__LINE__);
    echo '<br><br>';

    $i= 0;
    echo '<br>Outdated keys in language "'.$code.'" not used (maybe renamed key?):<br>';
    foreach ($lngArr[$code] as $key => $value) {
       if (!in_array($key,$lngArr['en'])) echo '<br>Outd: '.$i++.' '.$key;
    }
    if ($i==0) echo 'None<br>';
    
    echo '<br><br><b>'.lang('@Status:').' '. round(100-($miss/$n*100)). ' % '.lang('@translated').' - '.lang('@There are missing').': '.$miss.'</b>';
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
// SelNew($langList);
// doDebug($langList,'$langList');


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

?>