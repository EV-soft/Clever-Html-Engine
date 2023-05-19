<? $DocFile='../filedata.inc.php';    $DocVers='1.3.0';    $DocRev1='2023-04-27';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

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
function csv_parse($filepath, $options = []) {
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
    $csv = [];
    foreach ($lines as $line) {
        if (empty($line)) continue;  // Skip if empty
# Explode the line
        $fields = str_getcsv($line, $options['delimiter'], $options['enclosure'], $options['escape']);
# Initialize the line array/object
        $temp   = $options['to_object'] ? new stdClass : [];
        foreach ($header as $index => $key) {
            $options['to_object']
                ? $temp->{trim($key)} = trim($fields[$index])
                : $temp[trim($key)]   = trim($fields[$index]);
        }
        $csv[] = $temp;
    }
    return $csv;
}

function newFieldOrder($arrSource,$order=[]) { ## Change the field order in a associate array.
    foreach ($arrSource as $rec) {
        foreach ($order as $ord) { $arr[$ord] = $rec[$ord]; }
        $newOrder[]= $arr;
    }   // arrPretty($newOrder,'$newOrder');
    return $newOrder;
}

# Exchange data between file and associative array:
function FileWrite_arr($filepath='', $array=[]) {
//  return file_put_contents($filepath, serialize($array));
    return file_put_contents($filepath, json_encode($array,JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_UNICODE));
}

function FileRead_arr($filepath='', &$array=[]) {
//  $array = unserialize(file_get_contents($filepath));
    $arr = json_decode(file_get_contents($filepath), true);
    $array= $arr;
    return $array;
}


# Exchange data between json-file and associative array:
function put_json($fname='DataFile.dat.json',$recData) {
    return file_put_contents($fname, json_encode($recData,JSON_INVALID_UTF8_IGNORE | JSON_UNESCAPED_UNICODE));
}


function get_json($fname='DataFile.dat.json') {
    return (json_decode(file_get_contents($fname), true));
}

# Exchange data between DataBase and associative array:
function DbWrite() {
    
}
function DbRead() {
    
}

if (!function_exists('DbCreate')) {
    function DbCreate() { // https://code-boxx.com/store-arrays-mysql-php/
    class DB {                                          // (A) CONSTRUCTOR - CONNECT TO DATABASE
            private $pdo  = null;
            private $stmt = null;
            public $error = "";
            function __construct () {
                $this->pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHAR,
                DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        function __destruct () {                        // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
            if ($this->stmt !== null) { $this->stmt = null; }
            if ($this->pdo  !== null) { $this->pdo = null; }
        }
        function exec ($sql, $data=null) {              // (C) EXECUTE SQL
            try {
                $this->stmt = $this->pdo->prepare($sql);
                $this->stmt->execute($data);
                return true;
            } catch (Exception $ex) {
                $this->error = $ex->getMessage();
                return false;
            }
        }
        function fetch ($sql, $data=null) {             // (D) FETCH (SINGLE ROW)
        if ($this->exec($sql, $data) === false) { return false; }
        return $this->stmt->fetch();
        }
        function fetchAll ($sql, $data=null) {          // (E) FETCH ALL (SINGLE COLUMN)
            if ($this->exec($sql, $data) === false) { return false; }
            return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
        }
    }
    define("DB_HOST", "localhost");                     // (F) SETTINGS - CHANGE THESE TO YOUR OWN !
    define("DB_NAME", "test");
    define("DB_CHAR", "utf8");
    define("DB_USER", "root");
    define("DB_PASS", "xxxx");
    $DB = new DB();                                     // (G) DATABASE OBJECT
    }
}

function DbTableCreate($tabl,$id,$name,$data) {
    echo '
    CREATE TABLE `'.$tabl.'` (
      `'.$id.'` int(11) NOT NULL,
      `'.$name.'` varchar(255) NOT NULL,
      `'.$data.'` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
     
    ALTER TABLE `'.$tabl.'`
      ADD PRIMARY KEY (`'.$id.'`),
      ADD UNIQUE KEY `'.$name.'` (`'.$name.'`);
     
    ALTER TABLE `'.$tabl.'`
      MODIFY `'.$id.'` int(11) NOT NULL AUTO_INCREMENT;
      ';
}   // ALTER TABLE tca_deliTbl MODIFY delicoun TEXT CHARACTER SET utf8 COLLATE utf8_general_ci

function DbXXXWrite($tabl) { // (A) DATABASE & INSERT SQL
    DbCreate(); // require "1-database.php";
    $sql = "INSERT INTO `".$tabl."` (`name`, `data`) VALUES (?, ?)";
    $person = "Job"; // (B) JSON ENCODE
    $data = json_encode(["Red", "Green", "Blue"]);
    echo $DB->exec($sql, [$person, $data]) ? "JSON OK" : $DB->error ;
    $person = "Joe"; // (C) SERIALIZE
    $data = serialize(["Red"]);
    echo $DB->exec($sql, [$person, $data]) ? "SERIALIZE OK" : $DB->error ;
    $person = "Joy"; // (D) IMPLODE
    $data = implode(",", ["Red", "Green"]);
    echo $DB->exec($sql, [$person, $data]) ? "IMPLODE OK" : $DB->error ;    
}

function DbXXXRead($tabl,$name){ // (A) DATABASE & SELECT SQL
    DbCreate(); // require "1-database.php";
    $sql = "SELECT * FROM `".$tabl."` WHERE `".$name."`=?";
    $data = $DB->fetch($sql, ["Job"]);        // (B) JSON DECODE
    $data = json_decode($data["data"]);
    print_r($data);
    $data = $DB->fetch($sql, ["Joe"]);        // (C) UNSERIALIZE
    $data = unserialize($data["data"]);
    print_r($data);
    $data = $DB->fetch($sql, ["Joy"]);        // (D) EXPLODE
    $data = explode(",", $data["data"]);
    print_r($data);
}



global $db_Link, $debug;
$debug= true;

// if (!function_exists('msg_Besked')) {include_once('../../_base/msg_lib.php');};   //  msg_Besked erstatter msg_Dialog !
function onTest($outStr) {  if ($GLOBALS['debug']) echo $outStr; }
function SQLerror($errtxt) {
  $fp= fopen('./sys_sql.err.log','a'); 
    fwrite($fp,"\n".date("Y-m-d H:i:s").' '.$_SERVER['REQUEST_URI'].' -- '.$errtxt);    
  fclose($fp);
}

function msg_Tip($title='@Tip',        $messg='Besked') {
  msg_Dialog('tip', lang('@Continue'),'$(this).dialog("close")','','','','',ucfirst(lang($title)),ucfirst(lang($messg)));  
  // msg_Besked($MsgType= 'tip', $title,  $reason=$title, $messg, $actions=['','','close']);
}

//  dbi_* functions for PHP7+ - MYSQLI:

if (!function_exists('dbi_connect')) ##  $onFile and $onLine regarding fault location tracking
{ // Statement of all dbi_ functions:
    function dbi_connect($sqhost, $squser, $sqpass, $sqdb, $port='3306', $onFile= __FILE__, $onLine= __LINE__) { ## make connection
        global $db_Problem, $debug;
        switch (DB_TYPE) {
            case 'mysql'   : if ($debug) {mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); error_reporting(E_ALL);  ini_set('display_errors',1); }
                             if (function_exists('mysqli_connect')) {
                                $dbLink= mysqli_connect($sqhost, $squser, $sqpass, $sqdb, $port);
                                $db_Problem= mysqli_connect_error();
                                mysqli_set_charset($dbLink, "utf8mb4");
                                //echo 'SHOW VARIABLES';
                                // $dbLink->set_charset("utf8");
                    #+          if ($db_Encode=='UTF8') $names= 'utf8'; else $names= 'latin9'; mysqli_query($dbLink,'SET NAMES "'.$names.'"');
                             } else { msg_Error('@Program mysql-Error:',lang('@The function mysqli_connect() could not be found')."\n".lang('@Are both DB-MySql and PHP-mysqli installed ?')."<br/>POS: ".$onFile.' :'.$onLine); 
                                //   msg_Dialog('error',lang(' @Continue'),'$jQ112(this).dialog("close")','','','','',lang(' @Program mysql-error:'), lang(' @PHP-funktionen mysqli_connect() kunne ikke findes')."\n".lang(' @Er både DB-MySql og PHP-mysqli installeret?')."<br/>POS: ".$onFile.' :'.$onLine); 
                                    SQLerror('dbi_connect: '.'PHP-function mysqli_connect() could not be found');
                                    exit; 
                             } break;
            case 'postgres': if (function_exists('pg_connect')) {
                                  if ($sqpass) $dbLink = pg_connect ('host='.$sqhost.' dbname='.$sqdb.' user='.$squser.' password='.$sqpass);
                                  else         $dbLink = pg_connect ('host='.$sqhost.' dbname='.$sqdb.' user='.$squser);
                             } else { msg_Dialog('error',lang('@Continue'),'$jQ112(this).dialog("close")','','','','',lang('@Program postgres-error:'),
                                    lang('@PHP-function pg_connect() could not be found')."\n".lang('@Are both DB-postgres og PHP-pgsql installed?')."<br/>POS: ".$onFile.' :'.$onLine); 
                                    SQLerror('dbi_connect: '.'PHP-function pg_connect() could not be found');
                                    exit; 
                             } break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
        return $dbLink;
    }
  
    function dbi_succes( $onFile='', $onLine='') { ## check connection 
        switch (DB_TYPE) {
            case 'mysql'   : if (mysqli_connect_errno()) {
                                printf("Connect failed: %s\n", mysqli_connect_error());  
                                SQLerror('dbi_succes: '.'Connect failed'); exit();
                             } 
                             return mysqli_connect_errno(); break;
            case 'postgres': return pg_last_error;          break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function dbi_askData($dbLink, $strQuery='', $onFile='', $onLine='', $onFunc='') {  ## get result
        global $pageTitl, $debug;        
        if ($dbLink==null) {$reason= '#File: '.substr($onFile,strpos($onFile,'Program')).' - #Line: '.$onLine.' - #Func: '.$onFunc;
            msg_Dialog('error',lang('@Continue'),'$jQ112(this).dialog("close")','','','','',lang('@xxx DB:'),
            lang('@There is no connection to the DB server!')."<br>".lang('@Is connect.php created correctly?').
            '<br><br>'.$pageTitl.':'.'<br>'.$reason); 
            SQLerror('dbi_askData: '.$reason.' <br>SQL:'.$strQuery);
            exit; } 
        else {
            onTest('<brdbi_askData:><br>'. str_replace("(","<br>(",$strQuery).'<br>');
            switch (DB_TYPE) {
                case 'mysql'   : return $Qresult= mysqli_query($dbLink, $strQuery); break; //  var_dump(mysqli_query($dbLink, $strQuery));
                case 'postgres': return pg_query($strQuery); break;
                default: msg_Error(lang('@Not supported database: ').DB_TYPE);
            }
        }
    }

    function dbi_assoData($Qresult, $mode= MYSQLI_ASSOC, $onFile=__FILE__, $onLine=__LINE__, $onFunc='', $strQuery='') { ## associative array
        global $db_Problem, $pageTitl;    //  db_fetch_array($qtext)
        $result= [];
        if (!$Qresult)  {
            msg_Besked ($BgColr= 'error',$title='',  
                        $reason='#File: '.substr($onFile,strpos($onFile,'Program')).'<br>#Line: '.$onLine.'<br>#Func: '.$onFunc.'<br>#Call: '.$strQuery, 
                        $messg = lang('@Function call from').' "'.
                        $pageTitl.'"<br>'.lang('@No data in the table, error in the query, or access denied!').'<br>'.
                                          lang('@If necessary, look for the cause in the error log of the program or the database!'),
                        $actions=['close']);
            SQLerror('dbi_assoData: '.$reason.' <br>SQL:'.$strQuery);
            exit;
        } 
        else 
            switch (DB_TYPE) {
                case 'mysql'   : while ($row= mysqli_fetch_array($Qresult, $mode)) array_push($result,$row); 
                                 if (($result== []) and ($GLOBALS["debug"])) 
                                    return array(['0','','','','There is no data in the database table.','','','','']); // An empty record makes it possible to add data to the table.
                                 else return $result; break;
                case 'postgres': return pg_fetch_array($Qresult); break;
                default: msg_Error(lang('@Not supported database: ').DB_TYPE);
            }
    }
      
    function dbi_freeData($Qresult, $onFile=__FILE__, $onLine=__LINE__) { ## free Qresult set
        switch (DB_TYPE) {
            case 'mysql'   : return mysqli_free_result($Qresult); break;
            case 'postgres': return pg_free_result($Qresult); break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function dbi_DBclose($db_Link, $onFile=__FILE__, $onLine=__LINE__) { ## close connection
        switch (DB_TYPE) {
            case 'mysql'   : return mysqli_close($db_Link); break;
            case 'postgres': return pg_close($db_Link); break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function dbi_modify($strQuery, $onFile=__FILE__, $onLine=__LINE__) { ## dbi_modify()
        global $db_Link, $debug;
        switch (DB_TYPE) {
            case 'mysql'   : $Qresult= mysqli_query($db_Link, $strQuery); 
                                if (!$Qresult) msg_Error('@Program mysqli Error:',lang('@The PHP function dbi_modify() failed to modify data')."\n".$strQuery."<br/>POS: ".$onFile.' :'.$onLine); ;
                                if ($debug) echo $Qresult; 
                                return $Qresult; break;
            case 'postgres':return pg_query($db_Link, $strQuery); break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    } 
      
    function dbi_num_rows($strQuery){  ##  Returns number of rows in the result set.
        switch (DB_TYPE) {
            case 'mysql'   : return mysqli_num_rows($strQuery); break;
            case 'postgres': return pg_num_rows($strQuery); break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
      
    ### Combined: Not necessary, but practical / clear division:  CRUD:   Create Read Update Delete

    function sql_modify($strQuery, $onFile=__FILE__, $onLine=__LINE__) { ##  "CREATE", "INSERT", "ADD"    /* db_modify */
        global $db_Link, $debug;  
        onTest('<br>sql_modify:<br>'. str_replace('("',"<br>(\"",$strQuery).'<br>');
        switch (DB_TYPE) {
            case 'mysql'   : $Qresult= mysqli_query($db_Link, $strQuery);  
                                if ($Qresult) onTest(' - OK <br>'); 
                                else          onTest(' - Fail <br>'); 
                                if ($debug) echo $Qresult;
                                return $Qresult; break;
            case 'postgres': return $Qresult= pg_query($db_Link,$strQuery); break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
     
    function sql_readAssoc($strQuery, $onFile=__FILE__, $onLine=__LINE__) { ##  "SELECT" 
        global $db_Link;  
        switch (DB_TYPE) {
            case 'mysql'   : return dbi_assoData(dbi_askData($db_Link,$strQuery,__FILE__,__LINE__,__FUNCTION__), MYSQLI_ASSOC, $onFile=__FILE__, $onLine=__LINE__,__FUNCTION__, $strQuery); break;
            case 'postgres': return pg_fetch_assoc(pg_query($db_Link,$strQuery)); break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function sql_readNum($strQuery, $onFile=__FILE__, $onLine=__LINE__) { ##  "SELECT" 
        global $db_Link;
        switch (DB_TYPE) {
            case 'mysql'   : return dbi_assoData(dbi_askData($db_Link,$strQuery,__FILE__,__LINE__,__FUNCTION__), MYSQLI_NUM, $onFile=__FILE__, $onLine=__LINE__,__FUNCTION__, $strQuery); break;
            case 'postgres': return pg_num_rows($strQuery); break; // pg_num_fields($strQuery); ?
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function sql_readBoth($strQuery, $onFile='', $onLine='') { ##  "SELECT" 
        global $db_Link;
        switch (DB_TYPE) {
            case 'mysql'   : return dbi_assoData(dbi_askData($db_Link,$strQuery,$onFile,$onLine,__FUNCTION__), MYSQLI_BOTH, $onFile=__FILE__, $onLine=__LINE__,__FUNCTION__, $strQuery); break;
            case 'postgres': return '@Not finished'; break;
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function sql_write($strQuery, $onFile=__FILE__, $onLine=__LINE__) { ##  "MODIFY", "UPDATE", "ALTER"  
        global $db_Link, $debug;  
        onTest('<br>sql_write:<br>'.$strQuery.'<br>');
        switch (DB_TYPE) {
            case 'mysql'   : $Qresult= mysqli_query($db_Link, $strQuery); 
                             if ($Qresult) { onTest(' - OK <br>'); }
                             else          { onTest(' - Fail <br>'); } //  msg_Besked
                             if ($debug) echo $Qresult;
                             return $Qresult; break;
            case 'postgres': return '@Not finished'; break; // "postgres" pg_update() / pg_execute() ?
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function sql_erase($strQuery, $onFile=__FILE__, $onLine=__LINE__) { ##  "DELETE", "DROP"
        global $db_Link, $debug;                           
        onTest('<br>sql_erase:<br>'.$strQuery.'<br>');
        switch (DB_TYPE) {
            case 'mysql'   : $Qresult= mysqli_query($db_Link, $strQuery); 
                             if ($Qresult) { onTest(' - OK <br>'); }
                             else          { onTest(' - Fail <br>'); } //  msg_Besked
                             if ($debug) echo $Qresult;
                             return $Qresult; break;
            case 'postgres': return '@Not finished';  break; // "postgres" pg_execute() ?
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }
      
    function sql_nextRow($strQuery, $mode='B', $onFile=__FILE__, $onLine=__LINE__) {
        global $db_Link, $debug;  
        onTest('<br>sql_nextRow:<br>'.$strQuery.'<br>');
        switch (DB_TYPE) {
            case 'mysql'   : $result = $mysqli->query($strQuery);    //  $strQuery = "SELECT Name, CountryCode FROM City ORDER by ID LIMIT 3";
                             switch ($mode) {
                                 case 'N': $const = MYSQLI_NUM;    /* numeric array                  printf ("%s (%s)\n", $row[0], $row[1]); */
                                 case 'A': $const = MYSQLI_ASSOC;  /* associative array              printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);  */
                                 case 'B': $const = MYSQLI_BOTH;   /* associative and numeric array  printf ("%s (%s)\n", $row[0], $row["CountryCode"]); */
                             }
                             if ($debug) echo $Qresult;
                             return $Qresult = $result->fetch_array($const); break;
            case 'postgres': return '@Not finished'; break;   // "postgres" pg_execute() ?
            default: msg_Error(lang('@Not supported database: ').DB_TYPE);
        }
    }

} // END: Statement of dbi_ functions and sql_ functions




?>