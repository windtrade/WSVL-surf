<?php /* Smarty version Smarty-3.0.6, created on 2016-02-05 10:10:11
         compiled from "./templates/wsvl_userBeheer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:40251689456ab3fb5eeace4-08195916%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e940ab3dc60a2b9864ebcdbe6663d8c68efafdbf' => 
    array (
      0 => './templates/wsvl_userBeheer.tpl',
      1 => 1454063480,
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
  'nocache_hash' => '40251689456ab3fb5eeace4-08195916',
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
<title>WV Leidschendam Beheer Lidmaatschap</title>
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

<h3>Wachtwoord wijzigen</h3>
<form id="password"
method="POST"
action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<?php if (isset($_SESSION['user'])&&isset($_SESSION['user']['id'])){?>
<?php $_smarty_tpl->tpl_vars['oldId'] = new Smarty_variable($_SESSION['user']['id'], null, null);?>
<?php }?>
<?php if (isset($_smarty_tpl->getVariable('search',null,true,false)->value)){?>
<?php if (isset($_smarty_tpl->getVariable('search',null,true,false)->value['id'])){?><?php $_smarty_tpl->tpl_vars['oldId'] = new Smarty_variable($_smarty_tpl->getVariable('search')->value['id'], null, null);?><?php }?>
<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('search')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
<input type='hidden' name='fd[search][<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]' value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
">
<?php }} ?>
<?php }?>
<input type="hidden" name="action" value="updatePassword"/>
<input type="hidden" name="fd[pw][oldId]" value="<?php echo $_smarty_tpl->getVariable('oldId')->value;?>
"/>
<table>
<tr><td>Huidig wachtwoord</td><td><input type="password" name="fd[pw][oldWachtwoord]"/></tr>
<tr><td>Nieuw wachtwoord</td><td><input type="password" name="fd[pw][newWachtwoord]"/></tr></tr>
<tr><td>Herhaal nieuw wachtwoord</td><td><input type="password" name="fd[pw][chkWachtwoord]"/></tr>
<tr>
<td>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFsubmit'][0][0]->HFsubmit(array('value'=>"Wijzigen"),$_smarty_tpl);?>

</td>
<td>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFreset'][0][0]->HFreset(array('value'=>"Herstellen"),$_smarty_tpl);?>

</td>
</tr>
</table>
</form>

</div><!-- hierzo -->
</div>
<div class="linkerDeel">

<h3>Bijwerken gebruikersgegevens</h3>
<form id="userData" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<?php if (isset($_smarty_tpl->getVariable('search',null,true,false)->value)){?>
<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('search')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
<input type='hidden' name='fd[search][<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
]' value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
">
<?php }} ?>
<?php }?>
<input type="hidden" name="action" value="updateUser"/>
<table>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('user')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>'fd[user]','data'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>

</tr>
<?php }} ?>
<tr>
<td>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFsubmit'][0][0]->HFsubmit(array('value'=>"Opslaan"),$_smarty_tpl);?>

</td>
<td>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFreset'][0][0]->HFreset(array('value'=>"Herstellen"),$_smarty_tpl);?>

</td>
</tr>
</table>
</form>
<h3>Bijwerken gebruikersfuncties</h3>
<form id="userRoles" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="action" value="updateRoles"/>
<input type="hidden" name="fd[role][id]" value="<?php echo $_smarty_tpl->getVariable('roleId')->value;?>
"/>
<table>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('roles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr>
<td><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
</td>
<td>
<input type="<?php echo $_smarty_tpl->tpl_vars['item']->value['type'];?>
"
       name="<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
"
       value="<?php echo $_smarty_tpl->tpl_vars['item']->value['value'];?>
"
       <?php echo $_smarty_tpl->tpl_vars['item']->value['checked'];?>

       <?php echo $_smarty_tpl->tpl_vars['item']->value['disabled'];?>
/>
</td>
</tr>
<?php }} ?>
<tr>
<td>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFsubmit'][0][0]->HFsubmit(array('value'=>"Opslaan"),$_smarty_tpl);?>

</td>
<td>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFreset'][0][0]->HFreset(array('value'=>"Herstellen"),$_smarty_tpl);?>

</td>
</tr>
</table>
</form>

</div>
<div class="rechterDeel">

<div class="recentNieuwsKader">
<ul>
<ul>
<form id="resetPassword" method="GET" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="fd[search][id]" value="">
<input type="hidden" name="action" value="resetPassword">
</form>
<form id="hiddenSearch" method="GET" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="fd[search][id]" value="">
</form>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('other')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<li class="nieuwsTitel">
<a href="#" onClick="setAndSubmit('hiddenSearch','id', <?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">
<?php echo $_smarty_tpl->tpl_vars['item']->value['text'];?>

</a>
<a href="#" onClick="setAndSubmit('resetPassword','id', <?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">
wachtwoordherstel</a>
</li>
<?php }} ?>
</ul>
</ul
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
