# php2html.lib
Build html pages with php functions

php2html.lib.php is a PHP library of functions that can generate HTML pages.

If you program html output in php, you can use this library's routines to generate the html code.
	
HTML elements INPUT / TABLE and others, generated from PHP-functions.
all combined with: Label, ToolTip, Placeholder, dimensions and more.

Included translate system. Font-awesome icons.
Extended table functions with Mottie Tablesorter-system.
	
Based on PHP7+, HTML5, CSS3.
Source must be UTF-8, no tabs, indent: 4 chars

The layout is compact with labels above fields, so it is suitable to narrow screens.

All shaded labels have a tooltip, that appears when mouse is held over.

Look and feel at the demo here:

<iframe width="800px" height="800px" seamless frameborder="0" src="https://1331.dscloud.me/saldi-e/Proj1/Demo.page.php" > </iframe> 



For now htm_Input() has the following types:

	'date' : INPUT(type= 'date',
	'intg' : INPUT(type= 'number',
	'text' : INPUT(type= 'text',
	'dec0' : INPUT(type= 'text',		- value shown without decimals
	'dec1' : INPUT(type= 'text',		- value shown with 1 decimal
	'dec2' : INPUT(type= 'text',		- value shown with 2 decimals
	'num0' : INPUT(type= 'number',		- value shown without decimals
	'num1' : INPUT(type= 'number',  	- value shown with 1 decimal
	'num2' : INPUT(type= 'number',  	- value shown with 2 decimals
	'num3' : INPUT(type= 'number',		- value shown with 3 decimals
	'barc' : INPUT(type= 'text',		- value shown with barcode font
	'rado' : INPUT(type= 'radio',		- for one or multible radiofields
	'pass' : INPUT(type= 'password',	- with strength-meter and show/hide password
	'mail' : INPUT(type= 'email',
	'hidd' : INPUT(type= 'hidden',
	'area' : INPUT(type= 'textarea', 	- (text-content)
	'html' : INPUT(type= '<div contenteditable',	- (html-content)
	'chck' : INPUT(type= 'checkbox',	- for one or multible checkboxes
	'opti' : INPUT(type= 'option',		- Dropdown option-list


The parameters to htm_Input:

	function htm_Input(
		$type='',           # text, date, ... Look at source !
		$name='',           # Set the fields name and id
		$valu='',           # The current content in input field
		$labl='',           # Translated label above the input field
		$titl='',           # Translated desctiption about the field
		$algn='left',       # The alignment of input content Default: left
		$unit='',           # A unit added to the content eg. currency or % (prefix or suffix)
		$disabl=false,      # Disable the field (Output only). Default: field is active
		$rows='2',          # Number of rows in multiline input (eg. area/html) Default: 2
		$width='',          # Width of the field-container
		$step='',           # the value of stepup/stepdown for numbers
		$more='',           # Give more (special) input attrib
		$plho='@Enter...',  # Translated placeholder shown when field is empty. Default: Enter...
		$dataList=[]        # Data for "multi-list" (eg. options, checkbox, radiolist)
	)

