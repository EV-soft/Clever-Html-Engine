# php2html.lib
Build html pages with php functions

PHP to HTML generator.
If you program html output in php, you can use this library's routines to generate the html code.
	
HTML elements INPUT / TABLE and others, generated from PHP-functions.
all combined with: Label, ToolTip, Placeholder, dimensions and more.

Included translate system. Font-awesome icons.
Extended table functions with Mottie Tablesorter-system.
	
Based on PHP7+, HTML5, CSS3.
Source must be UTF-8, no tabs, indent: 4 chars

The layout is compact with labels above fields, so it is suitable to narrow screens.

All labels with shaddow has a tooltip, shown at mouseover.

Look and feel at the demo here:

<iframe width="800px" height="800px" seamless frameborder="0" src="https://1331.dscloud.me/saldi-e/Proj1/Demo.page.php" > </iframe> 

For now INPUT has the following types:

	'date' : INPUT(type= 'date',
	'intg' : INPUT(type= 'number',
	'text' : INPUT(type= 'text',
	'dec0' : INPUT(type= 'text',		- output shown without decimals
	'dec1' : INPUT(type= 'text',		- output shown with 1 decimal
	'dec2' : INPUT(type= 'text',		- output shown with 2 decimals
	'num0' : INPUT(type= 'number',		- output shown without decimals
	'num1' : INPUT(type= 'number',  	- output shown with 1 decimal
	'num2' : INPUT(type= 'number',  	- output shown with 2 decimals
	'num3' : INPUT(type= 'number',		- output shown with 3 decimals
	'barc' : INPUT(type= 'text',		- output shown with barcode font
	'rado' : INPUT(type= 'radio',		- for one or multible radiofields
	'pass' : INPUT(type= 'password',	- with strength-meter and show/hide password
	'mail' : INPUT(type= 'email',
	'hidd' : INPUT(type= 'hidden',
	'area' : INPUT(type= 'textarea', 	- (text-content)
	'html' : INPUT(type= '<div contenteditable',	- (html-content)
	'chck' : INPUT(type= 'checkbox',	- for one or multible checkboxes
	'opti' : INPUT(type= 'option',		- Dropdown option-list


