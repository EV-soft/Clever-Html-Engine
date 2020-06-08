<? $DocFile='../Proj1/filedata.inc.php';    $DocVers='1.0.0';    $DocRev1='2020-06-07';     $DocIni='evs';  $ModulNo=0; ## File informative only
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 

/**
 * Functions relatede to file transfer
 * and converting
 * 
 */

function ReadCSV($filepath='ISO639-1.csv') {    // CSV_file2arr
    $row = 1;   $result= [''];
    if (($handle = fopen($filepath, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000)) !== FALSE) {
            $num = count($data);
            $row++;      $rec= [];
            for ($c=0; $c < $num; $c++)
                {$rec[]= $data[$c]; }
            $result[]= $rec;
        }
        fclose($handle);
    }
    return $result;
} 
 
function WriteCSV($filepath='',$list=[]) {     // arr2CSV_file
    // $list = array ( array('aaa', 'bbb', 'ccc', 'dddd'), array('123', '456', '789'), array('"aaa"', '"bbb"') );
    $fp = fopen($filepath, 'w');
    if ($fp) {
        foreach ($list as $fields) { fputcsv($fp, $fields); }
        fclose($fp);
    }
}


/**
 * Parses CSV file into an associative array with the first row as field names.
 *
 * @param  string $filepath Path to readable CSV file.
 * @param  array  $options  Parse options (eol, delimiter, enclosure, escape, to_object).
 *
 * @return array           Associative array of parsed CSV file.
 */
function csv_parse($filepath, $options = array()) {
	if ( ! is_readable($filepath)) return FALSE;
    $options = array_merge(array(   // Merge default options
		'eol'       => "\n",
		'delimiter' => ',',
		'enclosure' => '"',
		'escape'    => '\\',
		'to_object' => FALSE,
    ), $options);
# Read file, explode into lines
	$string = file_get_contents($filepath);
	$lines  = explode($options['eol'], $string);
# Read the first row, consider as field names
    $header = array_map('trim', explode($options['delimiter'], array_shift($lines)));
# Build the associative array
    $csv = array();
    foreach ($lines as $line) {
        if (empty($line)) continue;  // Skip if empty
# Explode the line
        $fields = str_getcsv($line, $options['delimiter'], $options['enclosure'], $options['escape']);
# Initialize the line array/object
        $temp   = $options['to_object'] ? new stdClass : array();
        foreach ($header as $index => $key) {
            $options['to_object']
                ? $temp->{trim($key)} = trim($fields[$index])
                : $temp[trim($key)]   = trim($fields[$index]);
        }
        $csv[] = $temp;
    }
    return $csv;
}

function FileWrite_arr($filepath='',$arrName='', $list=[]) {
    $fp = fopen($filepath, 'w');
    if ($fp) {
        fwrite($fp, $arrName.' = '."Array (\n");
        foreach ($list as $index => $string) {
            fwrite($fp, '  "'.$index.'" => "'.$string.'"');
            fwrite($fp, "\n");
        }
        fwrite($fp, ")\n");
        fclose($fp);
    }
    else echo ' FileWrite_arr:Error ';
}

function FileRead_arr($filepath=''){
    parse_str(file_get_contents($filepath), $result);
    return $result;
    /*$fp = file($filepath);
    if ($fp) {
       // foreach($fp as $key=>$value) {
       //     $elem = explode('] => "', $value);
       //     if ($value!=NULL)
       //     $result[$elem[0]]=$elem[1];
       // }
        return $result=file($filepath);
    } 
*/    
    // else // echo ' FileRead_arr:Error ';
    // run_Script('toast("<b>'. lang('@FileRead_arr:Error !'). '</b><br>'. lang('@The file could not open'). '","yellow","black")');
}
?>