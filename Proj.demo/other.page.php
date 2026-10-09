<?php   $DocFile= './Proj.demo/other.page.php';    $DocVer='1.5.0';    $DocRev='2026-10-09';      $DocIni='evs';  $ModulNr=0; ## File informative only
$©= 'Open source - 𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2024 EV-soft *** See the file: LICENSE';

$sys= $GLOBALS["gbl_ProgRoot"]= '../';
$gbl_ProgRoot= './../';

## Activate needed libraries: Set 0:deactive  1:Local-source  2:WEB-source-CDN  3:Auto: Local/CDN
$needJquery=      '2';
$needTablesorter= '2';
$needPolyfill=    '0';
$needFontawesome= '2';
$needTinymce=     '0';

require_once ($sys.'php2html.lib.php');

htm_Page_($titl='other.page.php',$hint=$©,$info='File: '.$DocFile.' - ver:'.$DocVer,$inis='',$algn='center', $gbl_Imag='../_accessories/_background.png',$gbl_Bord=false);
    // $menudata is set in: project.init.php
    htm_Menu_TopDown(capt:'Clever html engine',data:$menudata, foot:'PHP2HTML', styl:'top:0px;', note:$menunote); 
    htm_nl(2);
    htm_Card_($capt= 'Other htm_functions:',$icon= 'fas fa-info',$hint= '',$form= '',$acti= '',$clas= 'cardW480',$wdth= '',$styl= 'background-color: white;',$attr= '' /* ,$where='Undefined',$BookMark='' */ );
                
    htm_TextDiv("There are a lot of small functions <br>
            that could be mentiond here.
            e.g. htm_AcceptButt()
            <br>
            ");
    htm_TextPre("<b>htm_AcceptButt()</b> - a programmeble button. You give:
    \$labl='',           # string: The caption on the button                          
    \$icon='',           # string: The iconclass ( class=\"fas fa-plus\" ) 
    \$hint='',           # string: hint about the button function                     
                                                                                      
    \$form='',           # string: The form the element belongs to, if a name is given
    \$wdth='',           # string: The width of the button                            
    \$attr='',           # string: Generel use e.g. ' action= \"\$link\" '            
                                                                                      
    \$akey='',           # string: Shortcut to activate the button                    
    \$kind='',           # string: save, navi, goon, erase, create, home (Appearance) 
    \$rtrn=true,         # bool:   Act as procedure: Echo string, or as function: Return string
                        
    \$tplc='LblTip_text',# string: Class for Placement of the tooltip 
    \$tsty='',           # string: Style for Placement of the tooltip 
    \$acti='',           # string: Function to run                    
    \$idix='',           # string: ix-suffix on name/id               
    \$disa=false         # bolean: 'disabled' to deactivate the button
    ",attr:'white-space:pre;'); 

    htm_TextDiv("
            <b>htm_IconButt()</b> - a general button with icon. <br><br>
            <b>htm_ModalDialog()</b>    - A popup message, <br>
            locks program and waits for a user response. <br><br>
            <b>msg_System()</b>   - Another modal popup message system,<br><br>
            <b>Pmnu_() / Pmnu_end()</b> - A popup context menu system.  <br><br>
            A special group of functions:                             <br>
            <b>dvl_</b> functions - relates to development (tools and design) <br><br>");

    htm_Card_end();

    ###### Messages and dialogs - a message is shown when the page is opened with ?msg=...
    htm_Card_(capt:'@Messages and dialogs:', icon:'fa-solid fa-comment-dots', hint:'', clas:'cardW800', wdth:'640');
        htm_TextDiv(body: lang('@msg_System() and the short forms show a message when the page is loaded - e.g. after saving. Click to try:'));
        $self= basename(__FILE__);
        foreach (['error'=>'msg_Error()', 'info'=>'msg_Info()', 'warn'=>'msg_Warn()', 'hint'=>'msg_Hint()', 'success'=>'msg_Succ()', 'system'=>'msg_System()'] as $k=>$t)
            htm_LinkButt(labl: $t, hint: '@Reload the page and show this message', link: $self.'?msg='.$k, targ: '_self');
        htm_nl(2);
        switch ($_GET['msg'] ?? '') {
            case 'error'  : msg_Error('@Could not save',     '@The file is locked by another user.'); break;
            case 'info'   : msg_Info('@Information',         '@The backup was made 10 minutes ago.'); break;
            case 'warn'   : msg_Warn('@Are you sure?',       '@The data has not been saved yet.');    break;
            case 'hint'   : msg_Hint('@Tip',                 '@You can fold all cards from the card menu.'); break;
            case 'success': msg_Succ('@Saved',               '@All changes have been saved.');        break;
            case 'system' : msg_System(vrnt:'error', capt:'@Database error', body:'SQLSTATE[HY000] 2002', mess:'@The database server did not answer. Try again in a moment.', list:['goback','goon','close']); break;
        }
        htm_Caption(labl:'@htm_Dialog() - a native modal dialog:'); htm_nl();
        htm_Dialog(capt:'@Delete the record?', body:'@The record will be moved to the trash.', labl:'@Open dialog');
        htm_nl(2);
    htm_Card_end();

    ###### Forms, output and buttons
    htm_Card_(capt:'@Forms, output and buttons:', icon:'fa-solid fa-pen-to-square', hint:'', clas:'cardW800', wdth:'640');
        if (($_POST['demoForm'] ?? '') == '1')
            echo '<p>'.lang('@Received').': note= <b>'.sys_enc($_POST['note'] ?? '').'</b></p>';
        htm_Form_(name:'demoForm', acti:'', mode:'POST');
            echo '<input type="hidden" name="demoForm" value="1" />';
            htm_TextArea(labl:'@htm_TextArea()', hint:'@A multi-line text field', name:'note', valu:'Line 1'."\n".'Line 2 <b>not bold</b>', rows:'3', widt:'300px', rtrn:false);
            htm_nl(2);
            htm_Row_();  htm_Output(labl:'@htm_Output(pgrs) ', vrnt:'pgrs', name:'p1', valu:'70', vmax:'100', hint:'@A progress bar');  htm_Row_end();
            htm_sp(4);
            htm_Row_();  htm_SubmitButt(labl:'@Send (htm_SubmitButt)', hint:'@Submits the form - htm_Form_() adds the CSRF token', font:'14px'); htm_Row_end();
        htm_Form_end();
        htm_nl();
    htm_Card_end();

    ###### Text and layout helpers - one row per function: name | result
    htm_Card_(capt:'@Text and layout helpers:', icon:'fa-solid fa-font', hint:'', clas:'cardW800', wdth:'640');
        $row= function($name, $show) {   # $show: a function that outputs the example
            echo '<tr><td style="padding:6px 12px; white-space:nowrap; vertical-align:top;"><code>'.$name.'</code></td>'.
                 '<td style="padding:6px 12px; text-align:left; vertical-align:top;">'; $show(); echo '</td></tr>';
        };
        echo '<table style="margin:auto; border-collapse:collapse; text-align:left;">';
        $row('htm_TextHint()',   function(){ htm_TextHint(text: lang('@Hover the mouse here'), hint:'@This description is hidden until the mouse is over the text', styl:''); });
        $row('htm_Ihead()',      function(){ echo lang('@Text'); htm_Ihead(html: lang('@italic text after a line break')); });
        $row('htm_sp(6)',        function(){ echo '|'; htm_sp(6); echo '|  &nbsp; <small>('.lang('@6 non-breaking spaces').')</small>'; });
        $row('htm_space(\'80px\')', function(){ echo '|'; htm_space(wdth:'80px'); echo '|  &nbsp; <small>('.lang('@a fixed width').')</small>'; });
        $row('str_bold()',       function(){ echo str_bold(lang('@Bold text')); });
        $row('str_hr()',         function(){ echo str_hr('#888','width:200px; margin:6px 0;'); });
        $row('markFirstChar()',  function(){ echo markFirstChar('@Save').' &nbsp; <small>('.lang('@marks a shortcut key').')</small>'; });
        $row('isBold() / isItal()', function(){ echo 'isBold(\'&lt;b&gt;x&lt;/b&gt;\') = '.(isBold('<b>x</b>') ? 'true' : 'false').
                                                     ' &nbsp; isItal(\'x\') = '.(isItal('x') ? 'true' : 'false'); });
        $row('str_Synt()',       function(){ echo str_Synt_().str_Synt('$name','variable').' = '.str_Synt("'value'",'string').'; '.
                                                  str_Synt('// '.lang('@syntax colors'),'comment').str_Synt_end(); });
        $row('getOptimalBackground()', function(){
            foreach (['#336699','#ffcc00','#228B22','#eeeeee','#990000'] as $c)
                echo '<span style="display:inline-block; color:'.$c.'; background:'.getOptimalBackground($c).'; padding:2px 8px; margin:0 4px 4px 0; border:1px solid #888; border-radius:3px;">'.$c.'</span>';
            echo '<br><small>'.lang('@Black or white background - whichever gives the best contrast to the text color').'</small>'; });
        $row('htm_TextVer()',    function(){ echo '<div style="width:40px; height:135px;">';   # The text is rotated up over its own box - give it room above
                                             htm_TextVer(body:'htm_TextVer()', attr:'width:130px; white-space:nowrap; margin-top:55px;'); echo '</div>'; });
        echo '</table>';
    htm_Card_end();

    ###### iFrame
    htm_Card_(capt:'@htm_iFrame():', icon:'fa-regular fa-window-maximize', hint:'', clas:'cardW800', wdth:'640');
        htm_iFrame(srce:'advantages.htm', wdth:'100%', heig:'220px', titl:'@Advantages', styl:'border:1px solid #888; border-radius:4px;');
    htm_Card_end();

htm_Page_end();
?>