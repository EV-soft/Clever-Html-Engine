<?php  $DocFileInc='../customLib.inc.php';   $DocVers='1.2.0';  $DocRev='2022-05-31';  $DocIni='evs';  $ModulNo=0; ## File informative only
    # In this file you can add global custom rules for all pages in your project.
    # The file will be read by a require_once() in php2html.lib.php and html added to all page headers:
    
ini_set('highlight.comment', 'gray');                       # Regarding: function highlight_string();
ini_set('highlight.default', 'darkred; font-weight: bold');
ini_set('highlight.html',    'orange');
ini_set('highlight.keyword', 'blue; font-weight: bold');
ini_set('highlight.string',  'green');

function highlight_words($text, $wrds, $styl='') {
    preg_match_all('~\w+~', $wrds, $m);
    if(!$m) return $text;
    
    if ($styl>'') $styl= ' style="'.$styl.'" ';
    $re = '~\\b(' . implode('|', $m[0]) . ')\\b~';
    return preg_replace($re, '<span '.$styl.'>$0</span>', $text);
} 

## Project variables:
    $bodybg="
         'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAACvCAIAAACzYSNAAAAAaklEQVR4AaWPwQkDMQwEd9bpNx2lqPQTlIdBYGQ2jzyE7jzSMtLz9bakLmD+z+8uU2PmnMvcUuRQ/X7rpsIutg4+7vAi5kPOX7/uW3L2I/o9/J+f+WQ/FPOlityVOW6/O6/BxjzbsXvtnS/j1hQKn4eomwAAAABJRU5ErkJggg=='
    "; // Used in htm_Page_0()
    
    $headbg="
    background-size: auto 100%;
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAVCAMAAACwjHQ2AAAAOVBMVEXq6urk5OTp6enn5+f9/v/t7e3+///y8vLZ2tzz8/P8/Pz39/fNztDl5eXw8PD+/v7Mzc/g4ODv7+9Vsrq2AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAKUlEQVQI1w3IQQKAEAAAsCklhPL/x3LYZW5RYiuy0zR0zaXu/QWHx+tbDZIAswoz07wAAAAASUVORK5CYII=');
    border-radius: 0.4em 0.4em 0 0;
    border-bottom: 0;
    padding: .25rem .75rem;
    "; // Used in htm_Panel_0()

?>