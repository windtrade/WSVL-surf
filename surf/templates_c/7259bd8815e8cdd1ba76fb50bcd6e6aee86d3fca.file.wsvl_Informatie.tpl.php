<?php /* Smarty version Smarty-3.0.6, created on 2016-02-05 04:30:57
         compiled from "./templates/wsvl_Informatie.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1768632654564ce057216137-27823253%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7259bd8815e8cdd1ba76fb50bcd6e6aee86d3fca' => 
    array (
      0 => './templates/wsvl_Informatie.tpl',
      1 => 1447878707,
      2 => 'file',
    ),
    'a28f446736d8ce46541af161844c498badb36845' => 
    array (
      0 => './templates/wsvl_personal.tpl',
      1 => 1447595440,
      2 => 'file',
    ),
    'dc988f96e970005423b1d45e5f90981520323cfe' => 
    array (
      0 => './templates/wvLeidschendam.tpl',
      1 => 1454617758,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1768632654564ce057216137-27823253',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/home/wvleid01/domains/wvleidschendam.nl/public_html/Smarty/libs/plugins/modifier.date_format.php';
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
<title>WV Leidschendam - Informatie</title>
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
<div class="heterContent">

<?php if (count($_smarty_tpl->getVariable('teksten')->value)>0){?>
<h1><?php echo $_smarty_tpl->getVariable('teksten')->value[0]['titel'];?>
</h1>
<br/>
<?php echo $_smarty_tpl->getVariable('teksten')->value[0]['tekst'];?>

<br/>
<?php }?>
<?php if (count($_smarty_tpl->getVariable('data')->value)>0){?>
<h1>Aanmelden</h1>
<br/>
Vul onderstaand formulier in om je op te geven voor de starterscursus:
<br/>
<form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="post" enctype="multipart/form-data" name="surflesAanmeldForm" id="surflesAanmeldForm">
<table>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['user']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>"fd[user]",'data'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>
</tr>
<?php }} ?>
<?php if ($_smarty_tpl->getVariable('NOROBOT')->value==false){?>
<tr><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFrecaptcha'][0][0]->HFrecaptcha(array(),$_smarty_tpl);?>
</tr>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['eventRegister']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable('', null, null);?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['checked']!=0){?><?php $_smarty_tpl->tpl_vars['checked'] = new Smarty_variable("checked", null, null);?><?php }?>
<tr>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
</td>
<td><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
" <?php echo $_smarty_tpl->getVariable('checked')->value;?>
/></td>
</tr>
<?php }} ?>
<?php }} ?>
</table>
<input type="submit" name="action" value="AANMELDEN"/>
</form>
<?php }?>

</div><!-- hierzo -->
</div>
<div class="linkerDeel">

<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 1;
  if ($_smarty_tpl->getVariable('i')->value<count($_smarty_tpl->getVariable('teksten')->value)){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<count($_smarty_tpl->getVariable('teksten')->value); $_smarty_tpl->tpl_vars['i']->value++){
?>
<h1><?php echo $_smarty_tpl->getVariable('teksten')->value[$_smarty_tpl->tpl_vars['i']->value]['titel'];?>
</h1>
<p>
<?php echo $_smarty_tpl->getVariable('teksten')->value[$_smarty_tpl->tpl_vars['i']->value]['tekst'];?>

</p>
<?php }} ?>

</div>
<div class="rechterDeel">

<div class="recentNieuwsKader">
<form id="hiddenSearch" method="GET" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="action" value="showEvent"/>
<input type="hidden" name="fd[event][id]" value=""/>
</form>
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
