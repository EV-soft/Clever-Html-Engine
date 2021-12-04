<?   $DocFile='./hello/world/first.page.php';    $DocVer='1.0.0';    $DocRev='2021-12-04';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2021 EV-soft *** See the file: LICENSE';

#   Getting started:
#   How to output your first page...

$GLOBALS["ØProgRoot"]= '../';           // a system variable
require_once ('../php2html.lib.php');   // the system library
// require_once ('../menu.inc.php');    // a system module
// require_once ('filedata.inc.php');   // a system module
// require_once ('translate.inc.php');  // a system module
/* 

/* PHP7+ - ordered arguments: */
htm_Page_0(                                                 # Prepare a HTML5 page:
            $pageTitl='@DEMO', 
            $ØPageImage='../_accessories/_background.png',
            $align='center',
            $PgInfo=lang('@PHP2HTML: My first page')
            );

    htm_Caption(                                            # Output text as page caption
                $labl='@HELLO WORLD:',
                $style='color:#550000; font-weight:600; font-size: 18px;',
                $align='center',
                $hint='');

    htm_nl(2);                                              # Output two new lines

    htm_TextDiv(                                            # Output text in page-body
                $content=lang('@This page is build with PHP2HTML <br> PHP7+ / PHP8+ mode <br>(ordered arguments)'),
                $align='center',
                $marg='8px',
                $attr='width:300px; margin:auto; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; background-color: white; ');

htm_Page_00(); # Finalize the HTML5 page



/* PHP8+ - unordered arguments: */
htm_Page_0( pageTitl:'@DEMO', 
            ØPageImage:'../_accessories/_background.png',
            // PgInfo:lang('@PHP2HTML: My first page')
            // align:'center',                              # Default - parameter is not needed
            );
 
    htm_Caption(labl:'@HELLO WORLD:',
                style:'color:#550000; font-weight:600; font-size: 18px;',
                // align:'center',                          # Default - parameter is not needed
                // hint:''                                  # Default - parameter is not needed
                );

    htm_nl(2);

    htm_TextDiv(content:lang('@This page is build with PHP2HTML <br> PHP8+ only mode <br>(unordered arguments)'),
                align:'center',
                attr:'width:300px; margin:auto; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; background-color: white; ',
                // marg:'8px',                              # Default - parameter is not needed
                );

htm_Page_00();

    // NOTE: Strings prefixed with "'@" are strings that can be translated.

?>