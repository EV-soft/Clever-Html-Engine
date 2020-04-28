<?php   $DocFil= './Proj1/blindAlley.page.php';    $DocVer='5.0.0';    $DocRev='2020-04-28';     $DocIni='evs';  $ModulNr=0;
## 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** 
require_once ('php2html.lib.php');
htm_PagePrep('Blind Allay');
	
htm_PageFina();
	run_Script('toast("<b>'. lang('@You`re in a dead end !'). '</b><br>'. lang('@The link you used is temporary, because the right one has not been developed.'). '","yellow","black")');
?>