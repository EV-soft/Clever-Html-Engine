<?php  $DocFileInc='../customLib.inc.php';   $DocVers='1.3.0';  $DocRev='2023-04-27';  $DocIni='evs';  $ModulNo=0; ## File informative only
    # In this file you can add your global custom rules and values, for all pages in your project.
    # The file will be read by a require_once() in php2html.lib.php and html added to all page headers:




## Regarding: $string= highlight_string($strCode,true); :
if ($darkTheme= true) {
    ini_set('highlight.comment', '#bdbdbd;');    // 'gray;');                    
    ini_set('highlight.default', 'Tomato;');
    ini_set('highlight.html',    'orange;');
    ini_set('highlight.keyword', 'lightblue;');
    ini_set('highlight.string',  'lightgreen;'); 
    ini_set('CODEBACKGROUND',    '#121212;');   // #121212 
} else {
    ini_set('highlight.comment', '#636262;');   // darkgray
    ini_set('highlight.default', '#cb0052;');   // red     #d71480    'Tomato;');   
    ini_set('highlight.html',    '#e90;');      // orange  #e90       'orange;');   
    ini_set('highlight.keyword', '#07a;');      // blue    #07a       'darkblue;'); 
    ini_set('highlight.string',  '#690;');      // green   #690       'darkgreen;');
    ini_set('CODEBACKGROUND',    '#263238;');   // lightgray #f4f4f4  'GhostWhite');
}
// if (!ini_get('CODEBACKGROUND')) { ini_set('CODEBACKGROUND', 'GhostWhite'); echo '80745608'; } else echo 'skdjf';

## Hightlight - Custom word-list and custom style: 
function highlight_words($text, $wrds='', $styl='',$patt='~\w{4,10}~') { 
    $wrds.='labl capt body foot plho icon hint type name valu form subm acti clas wdth algn marg styl attr font colr fclr bclr llgn link targ akey kind echo unit disa rows step bord plac rept rtrn titl info inis imag pbrd simu clck vhgh stck cntx html butt mess tplc tsty head evnt note rept shrt frst last from to__ elem pref suff filt data crea modi expo just sort filt vrnt capt pref body suff note data filt sort crea modi vhgh styl from list expo show help ftop
           ';
    $wrds= str_replace(' ',': ',$wrds); # Add : to all words
    if ($styl=='') $styl='color:'.'cyan; './* '#550000 #a16802; '. */ 'font-style:italic;';
    preg_match_all($patt, $wrds, $matches);
    if(!$matches) return $text;
    $styl= 'style="'.$styl.'" ';
    $replacement = '~\\b(' . implode('|', $matches[0]). ')\\b~';
    return preg_replace($replacement, '<span '.$styl.'>$0</span>', $text);
} 

function highlight_str($code,$retr=true) { # Remove the needed triggering <? prefix
    $source= highlight_string('<?'.$code,$retr);  #  print_r(htmlentities($source));
    $result= str_replace('&lt;?','',substr($source,0,80)).substr($source,80);     #  print_r(htmlentities($result));
    return $result;
}
   
function htm_CodeDiv($code,$rtrn=false) { // htm_CodeDiv(highlight_words(highlight_string('<? '.$strCode,true)));
    $result= '<p style="text-align: left; padding:4px; white-space: nowrap; overflow-x: auto; line-height: 1; background-color:#121212;">'; // #121212
    $result.= $code; //str_replace(['$','"'],['\$','\"'],$code);
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