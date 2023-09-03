<?   $DocFile='./hello/world/first.page.php';    $DocVer='1.3.1';    $DocRev='2023-09-03';     $DocIni='evs';  $ModulNo=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2023 EV-soft *** See the file: LICENSE';

#   Getting started:
#   How to output your first page...

$GLOBALS["ØProgRoot"]= '../';           // a system variable
require_once ('../php2html.lib.php');   // the system library

## Activate needed libraries:
//      ConstName:          ix:       LocalPath:                         CDN-path:                                                  // File:
define('LIB_JQUERY',        [1, '_assets/jquery/latest/',           'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/']);   
define('LIB_JQUERYUI',      [1, '_assets/jquery-ui/latest/',        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/']);    // jquery-ui.min.js

/* 

/* PHP7+ - ordered arguments: */
htm_Page_0(                     # Prepare a HTML5 page:
            $titl='@DEMO', 
            $hint= '',
            $info= lang('@PHP2HTML: My first page'),
            $inis= '',
            $algn='center',
            $imag='../_accessories/_background.png',
            );

    htm_Caption(                # Output text as page caption
            $labl='@HELLO WORLD:',
            $icon='',
            $hint='',
            $algn='center',
            $styl='color:#550000; font-weight:600; font-size: 18px;'
            );

    htm_nl(2);                  # Output two new lines

    htm_TextDiv(                # Output text in page-body
            $body=lang('@This page is build with PHP2HTML <br> PHP7+ / PHP8+ mode <br>(ordered functions arguments)'),
            $algn='center',
            $marg='8px',
            $attr='width:300px; margin:auto; box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; background-color: white; '
            );

htm_Page_00();                  # Finalize the HTML5 page



/* PHP8+ - unordered arguments: */
htm_Page_0(titl:'@DEMO', 
        // hint:'',                                 # Default - parameter is not needed
           info:lang('@PHP2HTML: My first page'), 
        // inis:'',                                 # Default - parameter is not needed
        // algn:'center',                           # Default - parameter is not needed
           imag:'../_accessories/_background.png', 
        // attr:'',                                 # Default - parameter is not needed
        // pbrd:true                                # Default - parameter is not needed
    );
            
    htm_Caption(labl:'@HELLO WORLD:',
        //      icon:'',                            # Default - parameter is not needed
        //      hint:'',                            # Default - parameter is not needed
        //      algn:'',                            # Default - parameter is not needed
                styl:'color:#550000; font-weight:600; font-size: 18px;',
        //      rtrn:false                          # Default - parameter is not needed
    );

    htm_nl(2);

    htm_TextDiv(body:lang('@This page is build with PHP2HTML <br> PHP8+ only mode <br>(unordered functions arguments)'), 
                algn:'center'
         //     marg:'8px',                         # Default - parameter is not needed
         //     styl:'box-shadow: 3px 3px 6px 0px #ccc; padding: 5px; border: solid 1px lightgray; ',
         //     attr:'background-color: white;',    # Default - parameter is not needed
         //     rtrn:false                          # Default - parameter is not needed
    );

htm_Page_00();

    // NOTE: Strings prefixed with "'@" are strings that can be translated.


/* 
PHP8+ - unordered arguments:  Comments removed:
htm_Page_0(titl:'@DEMO', info:lang('@PHP2HTML: My first page'), imag:'../_accessories/_background.png');
    htm_Caption(labl:'@HELLO WORLD:', styl:'color:#550000; font-weight:600; font-size: 13px;');
    htm_nl(2);
    htm_TextDiv(body:lang('@This page is build with PHP2HTML <br> PHP8+ only mode <br>(unordered functions arguments)'), algn:'center' );
    htm_Page_00();
*/

?>