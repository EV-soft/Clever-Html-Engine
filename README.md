# php2html.lib = Clever-Html-engine
Build html pages with php functions in the PHP2HTM library

php2html.lib.php is a PHP library of functions that generates HTML pages and elements.

If you program html output in php, you can use this library's routines to generate the html code.
	
HTML elements INPUT / CHECKBOX / RADIO-GROUP / TABLE and many others, generated from PHP-functions.
all combined with: **Label**, **ToolTip**, **Placeholder**, dimensions and others.

Included translate system. Font-awesome icons.
Extended TABLE functions with Mottie Tablesorter-system.
	
Based on PHP7+/PHP8, HTML5, CSS3.

Source must be in UTF-8, no tabs, indent: 4 chars

When using PHP2HTML your code will be more compact, and easier to read.

<i>As an example this height level PHP-code:</i>

    htm_Input($type='dec2',$name='dec2',$valu=$dec2, $labl='@htm_Input(Dec2)',
              $hint='@Demo of htm_Input Field type dec2: number with 2 decimal', $plho='', $wdth='',$algn='center',$unit='<$ ');


<i>will generate this HTML-code:</i>

    <div class="inpField" id="inpBox" style="width: 200px; margin: auto; display: inline-block;">
       <input type= "text"  id="dec2" name="dec2"  value="$ 54 321,00"  class="boxStyle"
              style="text-align: center; font-size: 14px; font-weight: normal; width: 90%; " 
              oninvalid="this.setCustomValidity('Wrong or missing data in htm_Input(Dec2) ! ')" 
              oninput="setCustomValidity('')"  pattern="^\d*\.?((25)|(50)|(5)|(75)|(0)|(00))?$" />
       <abbr class= "hint">
           <label for="dec2" style="font-size: 12px; ">
                <div style="white-space: nowrap; margin-left:   auto;">htm_Input(Dec2)</div>
           </label>
           <data-hint style="top: 45px; left: 2px;">Demo of htm_Input Field type dec2: number with 2 decimal</data-hint>
       </abbr>
    </div>

and looks like this:

![image](https://user-images.githubusercontent.com/21997911/131254454-3198a243-a1c3-4238-abe7-2fe46b232fc0.png)
    
You can see descriptions and a demo and try the functions here: https://ev-soft.github.io/ 
