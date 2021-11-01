<?php   $DocFil= './Proj1/demoFile/input.page.php';    $DocVer='1.0.0';    $DocRev='2020-11-01';     $DocIni='evs';  $ModulNr=0; ## File informative only
$©= '𝘓𝘐𝘊𝘌𝘕𝘚𝘌 & 𝘊𝘰𝘱𝘺𝘳𝘪𝘨𝘩𝘵 ©  2019-2020 EV-soft *** See the file: LICENSE';

$GLOBALS["ØProgRoot"]= '../';
require_once ('../php2html.lib.php');
require_once ('../menu.inc.php');
// require_once ('translate.inc.php');
// require_once ('filedata.inc.php');


## REMARK: scannSource() are only usefull, when rules like:     $name='intg', $valu=$intg, - are used !
## Can not be used when variables are in lists: 'chck' 'rado' 'opti'
    $varId= scannSource('$name=',"'",[__FILE__]);   //  
    foreach ($varId as $id) {$$id= postValue($$id,$id); }; // echo $id.':'.$$id.' ';};
    if (isset($_POST['name']))  { $namex = $_POST['name']; }
    
    $date= date("Y-m-d");

##### SCREEN OUTPUT:
#!!!: Remember no OUTPUT to screen, before htm_PagePrep

htm_PagePrep($pageTitl='input.page.php', $ØPageImage=$ØProgRoot.'_assets/images/_background.png',$align='center');
    Menu_Topdropdown(true); htm_nl(1);

    htm_PanlHead($frmName='test', $capt='The collection of htm_Input() variants:', $parms='', $icon='fas fa-info', $class='panelW720', $func='Undefined', $more='', 
                $BookMark='blindAlley.page.php',$panlBg='background-color: white;');
    if (USEGRID) echo '<div class="grid-container tableStyle" style="width: 700px; margin:auto; background-color: white; background-image: none;">';
    // htm_Input() Only $type is required - Defaults for all others!
    htm_Input($type='text',$name='text',$valu=$text, $labl='@htm_Input(Text)',$hint='@Demo of htm_Input Field type text',                                       $plho='',       $wdth='');
    htm_Input($type='date',$name='date',$valu=$date, $labl='@htm_Input(Date)',$hint='@Demo of htm_Input Field type date with browser popup selector',           $plho='',       $wdth='');
    htm_Input($type='intg',$name='intg',$valu=$intg, $labl='@htm_Input(Intg)',$hint='@Demo of htm_Input Field type intg: centered integer',                     $plho='',       $wdth='', $algn='center');
    
    htm_Input($type='dec0',$name='dec0',$valu=$dec0, $labl='@htm_Input(Dec0)',$hint='@Demo of htm_Input Field type dec0: centered number with 0 decimals',      $plho='',       $wdth='', $algn='center',$unit=' %');
    htm_Input($type='dec1',$name='dec1',$valu=$dec1, $labl='@htm_Input(Dec1)',$hint='@Demo of htm_Input Field type dec1: number with 1 decimal ');
    htm_Input($type='dec2',$name='dec2',$valu=$dec2, $labl='@htm_Input(Dec2)',$hint='@Demo of htm_Input Field type dec2: number with 2 decimal',                $plho='',       $wdth='', $algn='center',$unit='<$ ');
    htm_Input($type='opti',$name='opti',$valu='87654321',$labl='@htm_Input(opti)',$hint='@Demo of htm_Input Field type opti: left aligned number with %-unit',  $plho='@Enter...',$wdth='', $algn='left',$unit=' %',$disa=false,$rows='3',$step='',$more='',$list= [
    ['name1','private','@Details about private'],
    ['name2','proff','@Details about profession'],
    ['name3','private','@Details about private','checked'],
    ['name4','hobby','@Details about hobby'],
    ['name5','private','@Details about private'],
    ]);
    htm_Input($type='dec0',$name='dec0a',$valu='87654321',$labl='htm_Input(Dec0)',$hint='Demo of htm_Input Field type dec0: left aligned number with %-suffix', $plho='',       $wdth='', $algn='left',$unit=' %');
    htm_Input($type='dec1',$name='dec1a',$valu='87654321',$labl='htm_Input(Dec1)',$hint='Demo of htm_Input Field type dec1: centered number with %-suffix',     $plho='',       $wdth='', $algn='center',$unit=' %');
    htm_Input($type='dec2',$name='dec2a',$valu='87654321',$labl='htm_Input(Dec2)',$hint='Demo of htm_Input Field type dec2: right aligned number with %-suffix',$plho='',       $wdth='', $algn='right',$unit=' %');
    
    htm_Input($type='num1',$name='num1',$valu='87654321',$labl='@htm_Input(num1)',$hint='@Demo of htm_Input Field type numb: number with 1 decimal',            $plho='',       $wdth='', $algn='center');
    htm_Input(      'num0',      'num0',      '87654321',      '@htm_Input(num0)',      '@Demo of htm_Input Field type numb: left-justified number and label',  $plho='',       $wdth='', $algn='left',$unit='',$disa=false,$rows='2',$step='',$more='',$list=[],$llgn='L' );
    htm_Input($type='chck',$name='chck',$valu='', $labl='htm_Input(chck)',$hint='Demo of htm_Input Field type chck: Multi-line formatted chck-text',            $plho='Enter...', $wdth='', $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list= [
        ['name1','@Label1','@Details about label1','checked'],
        //['name2','@Label2','@Details about label2','checked']
    ]);
    htm_Input($type='mail',$name='mail',$valu='',       $labl='@htm_Input(mail)',$hint='@Demo of htm_Input Field type mail with syntax control',  $plho='aa@bb.dd');
    htm_Input($type='link',$name='link',$valu='',       $labl='@htm_Input(url)', $hint='@Demo of htm_Input Field type url with syntax control',                 $plho='https://...',$wdth='', $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='');
    htm_Input($type='pass',$name='pas1',$valu='',       $labl='@htm_Input(pass)',$hint='@Demo of htm_Input Field type pass with "hidden" output',               $plho='Enter...',   $wdth='', $algn='left',$unit='');
    htm_Input($type='barc',$name='barc',$valu='BARCODE',$labl='@htm_Input(barc)',$hint='@Demo of htm_Input Field type barc: shown with font barcode',           $plho='',           $wdth='', $algn='center');
    htm_Input($type='html',$name='html',$valu='',       $labl='@htm_Input(html)',$hint='@Demo of htm_Input Field type html: Multi-line formatted html-text',    $plho='<div>...</div>',   $wdth='', $algn='left',$unit='',$disa=false,$rows='3');
    htm_Input($type='area',$name='area',$valu='',       $labl='@htm_Input(area)',$hint='@Demo of htm_Input Field type area: Multi-line text',                   $plho='Enter...',   $wdth='', $algn='left',$unit='',$disa=false,$rows='6');
        
    htm_Input($type='chck',$name='chck1',$valu='',$labl='@htm_Input(chck)',$hint='@Demo of htm_Input Field type chck: Multi-line formatted chck-text',          $plho='Enter...',   $wdth='', $algn='left',$unit='',$disa=false,$rows='3',$step='',$more='',$list= [
    ['pos1','@private','@Details about private'],
    ['pos2','@proff','@Details about profession'],
    ['pos3','@private','@Details about private'],
    ['pos4','@hobby','@Details about hobby','checked'],
    ['pos5','@private','@Details about private'],
    ]);
    
    htm_Input($type='rado',$name='rad1',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio',               $plho='Enter...',   $wdth='', $algn='left',$unit='',$disa=false,$rows='2',$step='',$more='',$list= [
    ['post1','private','@private'],
    ['post2','proff','@profession'],
    ['post3','private','@private','checked'],
    ['post4','hobby','@hobby'],
    ['post5','private','@private'],
    ]);
    htm_Input($type='rang',$name='rang',$valu='10',$labl='@htm_Input(rang)',$hint='@Demo of htm_Input Field type range: 0..50 ',     $plho='',          $wdth='', $algn='left',$unit='',$disa=false,$rows='1',$step='',$more=' min="0" max="50"');
    htm_Input($type='chck',$name='chcka',$valu='',$labl='@htm_Input(chck)', $hint='@Demo of htm_Input Field type checkbox in a row', $plho='Enter...',  $wdth='', $algn='left',$unit='',$disa=false,$rows='1',$step='',$more='',$list= [
    ['postc','dark','@Dark','checked'],
    ['postd','shiny','@Shiny'],
    ]);
    htm_Input($type='rado',$name='rad2',$valu='',$labl='@htm_Input(rado)',$hint='@Demo of htm_Input Field type radio in a row', $plho='Enter...',  $wdth='', $algn='left',$unit='',$disa=false,$rows='1',$step='',$more='',$list= [
    ['posta','happy','@Happy','checked'],
    ['postb','sorry','@Sorry'],
    ]);
    htm_nl(2);
    htm_Input($type='colr',$name='colr',$valu='#0000ff',$labl='@htm_Input(colr)',$hint='@Demo of htm_Input Field type color',   $plho='',  $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='butt',$name='butt',$valu='BUTTON',$labl='@htm_Input(butt)',$hint='@Demo of htm_Input Field type butt',     $plho='',  $wdth='', $algn='center',$unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='sear',$name='sear',$valu='',$labl='@htm_Input(sear)',$hint='@Demo of htm_Input Field type search',         $plho='?', $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='time',$name='time',$valu='',$labl='@htm_Input(time)',$hint='@Demo of htm_Input Field type time',           $plho='',  $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='week',$name='week',$valu='',$labl='@htm_Input(week)',$hint='@Demo of htm_Input Field type week',           $plho='',  $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='mont',$name='mont',$valu='',$labl='@htm_Input(mont)',$hint='@Demo of htm_Input Field type month',          $plho='',  $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='file',$name='file',$valu='',$labl='@htm_Input(file)',$hint='@Demo of htm_Input Field type file',           $plho='',  $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    htm_Input($type='imag',$name='imag',$valu='',$labl='@htm_Input(imag)',$hint='@Demo of htm_Input Field type image',          $plho='',  $wdth='', $algn='left',  $unit='',$disa=false,$rows='1',$step='',$more='');
    if (USEGRID) echo '</div>'; // grid-container}
    //htm_PanlFoot();
    htm_PanlFoot($labl='@Save', $subm=true, $title='@Just demo !', $btnKind='save', $akey='', $simu=false, $frmName);
    
htm_PageFina();
?>