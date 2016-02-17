<?php /* Smarty version Smarty-3.0.6, created on 2016-02-05 03:45:59
         compiled from "./templates/wsvl_training.tpl" */ ?>
<?php /*%%SmartyHeaderCode:60195155956a70c33359f67-82455311%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a9ec21eae1e0b33a89262b55a1eda0e992813ef' => 
    array (
      0 => './templates/wsvl_training.tpl',
      1 => 1452931577,
      2 => 'file',
    ),
    '9ca2812acf62b79acf13d727b2bec806c0bb9214' => 
    array (
      0 => './templates/wsvl_3panels.tpl',
      1 => 1445613447,
      2 => 'file',
    ),
    'dc988f96e970005423b1d45e5f90981520323cfe' => 
    array (
      0 => './templates/wvLeidschendam.tpl',
      1 => 1454617758,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60195155956a70c33359f67-82455311',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include '/home/wvleid01/domains/wvleidschendam.nl/public_html/Smarty/libs/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_date_format')) include '/home/wvleid01/domains/wvleidschendam.nl/public_html/Smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE HTML>
<HTML>
<head>
<meta name="viewport" content="width=device-width, height=device-height"/>  
<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
<meta name="google" content="notranslate">
<meta name="description" content="Windsurfvereniging Leidschendam e.o. op het surfstrand van Vlietland. Daar vind je windsurfles, training, clubwedstrijde, windsurfweekends en nog veel meer." />
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="<?php echo $_smarty_tpl->getVariable('stylesheet')->value;?>
" rel="stylesheet" type="text/css"/>
<title>Informatie | Windsurfvereniging Leidschendam en omstreken</title>
<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('og')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['tag']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
<meta property="og:<?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
" content="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" />
<?php }} ?>
<?php  $_smarty_tpl->tpl_vars['script'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('javascriptFiles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['script']->key => $_smarty_tpl->tpl_vars['script']->value){
?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['script']->value;?>
"></script>
<?php }} ?>
<?php if (count($_smarty_tpl->getVariable('javascriptStatements')->value)){?>
<script type="text/javascript">
<?php  $_smarty_tpl->tpl_vars['statement'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('javascriptStatements')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['statement']->key => $_smarty_tpl->tpl_vars['statement']->value){
?>
<?php echo $_smarty_tpl->tpl_vars['statement']->value;?>

<?php }} ?>
</script>
<script type="text/javascript">
   $(document).ready(function(){
      showLogin(<?php echo $_smarty_tpl->getVariable('mustLogin')->value;?>
 && !<?php echo $_smarty_tpl->getVariable('loggedIn')->value;?>
);
      addOnClicks();
      $(document).ajaxError(function(event,xhr,options,exc)
      {
        window.alert("exception"+event);
      })
   });
</script>
<?php }?>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<!-- 21-1-2016 removed illegal characters from twitter script -->
<script>window.twttr = (function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0],
t = window.twttr || {};
if (d.getElementById(id)) return t;
js = d.createElement(s);
js.id = id;
js.src = "https://platform.twitter.com/widgets.js";
fjs.parentNode.insertBefore(js, fjs); 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));
</script>   
<div class="contentArea">
<!-- NAVIGATIE MENU BALK MET LOGO -->
<div class="navHeader" id="navHeader">
<h1>Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest. <img id="navHeaderLogo" src="images/logo.gif" width="755" height="56" alt="WV Leidschendam - Surf"/>
<!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></h1>
</div>
<div class="huug" id="huug">
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEcssmenu'][0][0]->HEcssmenu(array('menu'=>$_smarty_tpl->getVariable('mainMenu')->value,'id'=>"cssmenu",'hassub'=>"has-sub",'last'=>"last"),$_smarty_tpl);?>

</div>
<div class="errors">
<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
<div class="error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
<?php }} ?>
</div>
<div class="infos">
<?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('infos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
?>
<div class="info"><?php echo $_smarty_tpl->tpl_vars['info']->value;?>
</div>
<?php }} ?>
</div>
<div class="login">
<form method="POST" name="loginform">
emailadres of nick:
<input name="login" type="text" size="25" />
wachtwoord:
<input name="password" type="password" size="15" />
<input name="action" type="hidden" value="JSONlogin"/>
<input type="button" value="inloggen" onclick="logonJSON()"/>
<input type="button" value="annuleren" onclick="showLogin(false)"/>
</form>
</div>

<div class="heter">

<script>
function refresh(field, value) {
    alert(window.location.pathname+" Veld "+field+" is nu '"+value+"'");
    window.location.replace(window.location.pathname+"?"+field+"="+value);
}
</script>
<div class="heterContent">
<div class="leftFloat30pct">
<div class="heterTitel">Wie komen er allemaal?</div>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('present')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<p>
<?php if (count($_smarty_tpl->tpl_vars['item']->value['names'])<=0){?>Geen<?php }else{ ?><?php echo count($_smarty_tpl->tpl_vars['item']->value['names']);?>
<?php }?>
 aanmelding<?php if (count($_smarty_tpl->tpl_vars['item']->value['names'])!=1){?>en<?php }?>
 voor de training van <?php echo $_smarty_tpl->tpl_vars['item']->value['start'];?>

</p>
<ul>
<?php  $_smarty_tpl->tpl_vars['aanmelding'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['names']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['aanmelding']->key => $_smarty_tpl->tpl_vars['aanmelding']->value){
?>
<li>
<?php echo $_smarty_tpl->tpl_vars['aanmelding']->value;?>

<?php }} ?>
</ul>
<?php }} ?>
</div>
<div class="rightFloat70pct">
<div class="heterTitel">Meld je aan voor de trainingen<em>!</em></div>
<p>Om bij de training voldoende instructeurs op het water te hebben
moeten we vooraf weten wie we allemaal op onze trainingen mogen verwachten.
Daarom vragen we je het formulier in te vullen als je van plan bent om te komen.</p>
<form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="post" enctype="multipart/form-data" name="trainingAanmeldForm" id="trainingAanmeldForm"> 
<?php if ($_smarty_tpl->getVariable('currentUserId')->value<0||count($_smarty_tpl->getVariable('userList')->value)==0){?>
<table>
<tr><td><strong>Roepnaam</strong></td>
<td><input type="text" size="30" name="fd[user][roepnaam]"></td></tr>
<tr><td><strong>Voorvoegsel</strong></td>
<td><input type="text" size="30"  name="fd[user][voorvoegsel]"></td></tr>
<tr><td><strong>Achternaam</strong></td>
<td><input type="text" size="30" name="fd[user][naam]"></td></tr>
<tr><td><strong>Email</strong></td>
<td><input type="text" size="30" name="fd[user][email]"></td></tr>
<tr><td colspan="2">(Als je 18- bent: van een ouder/verzorger)</td></tr>
<?php if ($_smarty_tpl->getVariable('NOROBOT')->value!="OK"){?>
<tr><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFrecaptcha'][0][0]->HFrecaptcha(array(),$_smarty_tpl);?>
</tr>
<?php }?>
</table>
<?php }elseif(count($_smarty_tpl->getVariable('userList')->value)==1){?>
Meld je hier aan, <strong>
<?php echo $_smarty_tpl->getVariable('userList')->value[$_smarty_tpl->getVariable('currentUserId')->value];?>

<input type="hidden" name="fd[currentUserId]" value="<?php echo $_smarty_tpl->getVariable('currentUserId')->value;?>
"/>
<input type="hidden" name="fd[user][id]" value="<?php echo $_smarty_tpl->getVariable('currentUserId')->value;?>
"/>
</strong>
<?php }else{ ?>
Kies wie je wilt aanmelden:
<select name="currentUserId" onChange="refresh(this.name, this.value)">
<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('userList')->value,'selected'=>$_smarty_tpl->getVariable('currentUserId')->value),$_smarty_tpl);?>

</select>
<input type="hidden" name="fd[user][id]" value="<?php echo $_smarty_tpl->getVariable('currentUserId')->value;?>
"/>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<div class="heterTitel">
<?php echo $_smarty_tpl->tpl_vars['item']->value['event']['title'];?>

</div>
<p><?php echo $_smarty_tpl->tpl_vars['item']->value['event']['text'];?>
</p>
<!-- input type="hidden" name="fd[event][id]" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['event']['id'];?>
"/ -->
<?php $_smarty_tpl->tpl_vars['elts'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['item']->value['eventRegister']), null, null);?>
<?php $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(1, null, null);?>
<?php if ($_smarty_tpl->getVariable('elts')->value>=10){?><?php $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(2, null, null);?><?php }?>
<?php if ($_smarty_tpl->getVariable('elts')->value>=20){?><?php $_smarty_tpl->tpl_vars['cols'] = new Smarty_variable(3, null, null);?><?php }?>
<?php $_smarty_tpl->tpl_vars['rows'] = new Smarty_variable(floor(($_smarty_tpl->getVariable('elts')->value+$_smarty_tpl->getVariable('cols')->value-1)/$_smarty_tpl->getVariable('cols')->value), null, null);?>
<?php $_smarty_tpl->tpl_vars['row'] = new Smarty_variable(0, null, null);?>
<table>
<?php while ($_smarty_tpl->getVariable('row')->value<$_smarty_tpl->getVariable('rows')->value){?>
<tr>
<?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable(0, null, null);?>
<?php while ($_smarty_tpl->getVariable('col')->value<$_smarty_tpl->getVariable('cols')->value){?>
<?php $_smarty_tpl->tpl_vars['elt'] = new Smarty_variable(($_smarty_tpl->getVariable('col')->value*$_smarty_tpl->getVariable('rows')->value)+$_smarty_tpl->getVariable('row')->value, null, null);?>
<td>
<?php if ($_smarty_tpl->getVariable('elt')->value<$_smarty_tpl->getVariable('elts')->value){?>
<?php $_smarty_tpl->tpl_vars['label'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value['eventRegister'][$_smarty_tpl->getVariable('elt')->value]['label'], null, null);?>
<?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value['eventRegister'][$_smarty_tpl->getVariable('elt')->value]['name'], null, null);?>
<?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable('', null, null);?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['eventRegister'][$_smarty_tpl->getVariable('elt')->value]['checked']!=0){?><?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable("checked", null, null);?><?php }?>
<input type="checkbox" name="<?php echo $_smarty_tpl->getVariable('name')->value;?>
" <?php echo $_smarty_tpl->getVariable('checked')->value;?>
/> <?php echo $_smarty_tpl->getVariable('label')->value;?>

<?php }?>
</td>
<?php $_smarty_tpl->tpl_vars['col'] = new Smarty_variable($_smarty_tpl->getVariable('col')->value+1, null, null);?>
<?php }?>
</tr>
<?php $_smarty_tpl->tpl_vars['row'] = new Smarty_variable($_smarty_tpl->getVariable('row')->value+1, null, null);?>
<?php }?>
</table>
<?php }} ?>
<input type="submit" name="action" value="AANMELDEN"/>
</form>
</div>
</div>

</div>
<div class="heterBottom">

<img src="images/komjijooktrainen.gif" width="442" height="47" style="align:right" alt="Kom jij ook trainen?"/>

</div>
<div class="linkerDeel">
<div class="titelBalk">

<img src="images/kop_informatie.gif" width="186" height="29" alt="Informatie"/>

</div>

<?php  $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('information')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['info']->key => $_smarty_tpl->tpl_vars['info']->value){
?>
<span class="nieuwsTitel"><?php echo $_smarty_tpl->tpl_vars['info']->value['titel'];?>
</span>
<p><?php echo $_smarty_tpl->tpl_vars['info']->value['tekst'];?>
</p>
<?php }} ?>

</div>
<div class="rechterDeel">
<div class="titelBalk">

<img src="images/kop_nog-meer.gif" width="188" height="31" alt="Nog meer..."/>

</div>

<div class="recentNieuwsKader">
<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Trainingsbijdrage</span><br />
<span class="nieuwsAuteur"></span>
<p>Na dat je bent aangemeld voor de training krijg je via email een factuur voor de trainingsbijdrage. Meer over de
trainingsbijdrage</a> vindt je op de <a href="http://<?php echo $_SERVER['SERVER_NAME'];?>
/informatie.php?tab=tarieven">informatie pagina's</a>.</p>
</div>

<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Dinsdagavondprogramma </span><br />
<span class="nieuwsAuteur"></span>
<p>18:15 - Aankomst<br/>
18:20 - Optuigen<br/>
18:45 - Surfpak aantrekken<br/>
19:00 - Voorbespreking van de training<br/>
19:10 - Het water op<br/>
20:30 - Nabespreken en evalueren<br/>
20:45 - Opruimen
<br/>
</p>
</div>
<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Optuigen</span><br />

<span class="nieuwsAuteur"></span>
<p>Als je gebruik maakt van de Surfpool en op dinsdagavond op
verenigingsmateriaal surft is het slim om ruim op tijd te komen,
je spullen optuigen duurt altijd langer dan je denkt.</p>
</div>

<div class="recentNieuwsBericht">
<span class="nieuwsTitel">Afmelden</span><br />

<span class="nieuwsAuteur"></span>
<p>Heb je jezelf al aangemeld voor de komende training, maar gaat het je om wat voor reden toch niet lukken om er bij te zijn? 
<a href="training_afmelden.php">Meld je dan even af</a>.</p>
</div>
</div>

</div>

</div>
<div class="footerTxt">
	Copyright &copy; 1978-<?php echo smarty_modifier_date_format(time(),'%Y');?>
 Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" style="border:no" /></a>&nbsp;
            <a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" style="border:no" /></a>
<!-- Google analytics -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-325606-2";
urchinTracker();
</script>
</div>
</body>
<?php if (count($_smarty_tpl->getVariable('traces')->value)){?>
<?php }?>
<!-- <?php echo $_smarty_tpl->getVariable('template')->value;?>
 -->
</html>
