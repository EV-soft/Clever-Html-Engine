<?php  $DocFileInc='../customLib.inc.php';   $DocVers='1.2.2';  $DocRev='2022-12-26';  $DocIni='evs';  $ModulNo=0; ## File informative only
    # In this file you can add your global custom rules and values, for all pages in your project.
    # The file will be read by a require_once() in php2html.lib.php and html added to all page headers:




## Regarding: $string= highlight_string($strCode,true); :
if ($darkTheme=false) {
    ini_set('highlight.comment', 'gray;');                    
    ini_set('highlight.default', 'Tomato;');
    ini_set('highlight.html',    'orange;');
    ini_set('highlight.keyword', 'lightblue;');
    ini_set('highlight.string',  'lightgreen;'); 
    ini_set('CODEBACKGROUND',    '#121212;');
} else {
    ini_set('highlight.comment', '#636262;');   // darkgray
    ini_set('highlight.default', '#cb0052;');   // red     #d71480  'Tomato;');   
    ini_set('highlight.html',    '#e90;');      // orange  #e90     'orange;');   
    ini_set('highlight.keyword', '#07a;');      // blue    #07a     'darkblue;'); 
    ini_set('highlight.string',  '#690;');      // green   #690     'darkgreen;');
    ini_set('CODEBACKGROUND',    '#f4f4f4;');   // lightgray #f4f4f4  'GhostWhite');
}
## Hightlight - Custom word-list and custom style: 
function highlight_words($text, $wrds='', $styl='',$patt='~\w+~') {
    $wrds.='labl capt body plho icon hint type name valu form subm acti clas wdth algn marg styl attr font colr fclr bclr llgn link targ akey kind  echo unit 
            disa rows step bord rtrn titl info inis gbl_imag gbl_bord simu clck vhgh stck cntx html butt mess tplc tsty';
    if ($styl=='') $styl='color:'.'#550000'./* '#a16802'. */'; font-style:italic;';
    preg_match_all($patt, $wrds, $m);
    if(!$m) return $text;
    if ($styl>'') $styl= ' style="'.$styl.'" ';
    $re = '~\\b(' . implode('|', $m[0]) . ')\\b~';
    return preg_replace($re, '<span '.$styl.'>$0</span>', $text);
} 

// if (!ini_get('CODEBACKGROUND')) { ini_set('CODEBACKGROUND', 'GhostWhite'); echo '80745608'; } else echo 'skdjf';

function htm_CodeDiv($code,$rtrn=false) { // htm_CodeDiv(highlight_words(highlight_string('<? '.$strCode,true)));
    $result= '<p style="text-align: left; padding:4px; white-space: nowrap; overflow-x: auto; line-height: 1; background-color:#f4f4f4;">'; // #121212
    $result.= $code;
    $result.= '</p>';
    if ($rtrn==false) echo $result;
    else return $result;
};

/*  // https://www.php.net/manual/en/function.highlight-string.php
<?esc_code()?>
  $string = 'Here I put my code';
<?esc_code()?>
 */
function esc_code() {
    static $on=false;
    if (!$on) ob_start();
    else {
      $buffer= "<?\n".ob_get_contents()."?>";
      ob_end_clean();
      return highlight_string($buffer,true);
    }
    $on=!$on;
}
  
## Regarding: Combine 2 font-awesome icons
function iconStack($cl1='fa-stack fa-2x',$cl2='fa-solid fa-square fa-stack-2',$cl3='fab fa-twitter fa-stack-1x fa-inverse',$rtrn=false) {
    $result= '
    <span class="'.$cl1.'">
        <i class="'.$cl2.'"></i>
        <i class="'.$cl3.'"></i>
    </span>';
    if ($rtrn==false) echo $result;
    else return $result;
}

## Project variables:
    $bodybg="
         'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAACvCAIAAACzYSNAAAAAaklEQVR4AaWPwQkDMQwEd9bpNx2lqPQTlIdBYGQ2jzyE7jzSMtLz9bakLmD+z+8uU2PmnMvcUuRQ/X7rpsIutg4+7vAi5kPOX7/uW3L2I/o9/J+f+WQ/FPOlityVOW6/O6/BxjzbsXvtnS/j1hQKn4eomwAAAABJRU5ErkJggg=='
    "; // Used in htm_Page_0()
    
    $headbg="
    background-size: 100% 100%;
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAVCAMAAACwjHQ2AAAAOVBMVEXq6urk5OTp6enn5+f9/v/t7e3+///y8vLZ2tzz8/P8/Pz39/fNztDl5eXw8PD+/v7Mzc/g4ODv7+9Vsrq2AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAKUlEQVQI1w3IQQKAEAAAsCklhPL/x3LYZW5RYiuy0zR0zaXu/QWHx+tbDZIAswoz07wAAAAASUVORK5CYII=');
    border-radius: 0.4em 0.4em 0 0;
    border-bottom: 0;"
    // padding: .25rem .25rem;
    ; // Used in htm_Panel_0()

define('DB_TYPE', 'mysql'); // $db_Type = 'mysql';

?>