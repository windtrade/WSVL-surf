<?php /* Smarty version Smarty-3.0.6, created on 2016-01-24 16:18:59
         compiled from "./templates/wsvl_kalender.tpl" */ ?>
<?php /*%%SmartyHeaderCode:969714431566b3bc54d66c2-80882794%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3ab2d84b9f5206755c0640ba43a9d6a8017f0e1' => 
    array (
      0 => './templates/wsvl_kalender.tpl',
      1 => 1449868206,
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
      1 => 1453460092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '969714431566b3bc54d66c2-80882794',
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
<title>WV Leidschendam Kalender</title>
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

<?php if ((isset($_smarty_tpl->getVariable('currentEventItem',null,true,false)->value))){?>
    <?php $_smarty_tpl->tpl_vars['item'] = new Smarty_variable($_smarty_tpl->getVariable('data')->value['event'][$_smarty_tpl->getVariable('currentEventItem')->value['id']], null, null);?>
<?php }else{ ?>
    <?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['title'] = "Overzicht activiteiten";?>
    <?php if (!isset($_smarty_tpl->tpl_vars['currentEventItem']) || !is_array($_smarty_tpl->tpl_vars['currentEventItem']->value)) $_smarty_tpl->createLocalArrayVariable('currentEventItem', null, null);
$_smarty_tpl->tpl_vars['currentEventItem']->value['name'] = '';?>
    <?php if (!isset($_smarty_tpl->tpl_vars['currentEventItem']) || !is_array($_smarty_tpl->tpl_vars['currentEventItem']->value)) $_smarty_tpl->createLocalArrayVariable('currentEventItem', null, null);
$_smarty_tpl->tpl_vars['currentEventItem']->value['startText'] = '';?>
    <?php if (!isset($_smarty_tpl->tpl_vars['currentEventItem']) || !is_array($_smarty_tpl->tpl_vars['currentEventItem']->value)) $_smarty_tpl->createLocalArrayVariable('currentEventItem', null, null);
$_smarty_tpl->tpl_vars['currentEventItem']->value['location'] = '';?>
    <?php if (!isset($_smarty_tpl->tpl_vars['currentEventItem']) || !is_array($_smarty_tpl->tpl_vars['currentEventItem']->value)) $_smarty_tpl->createLocalArrayVariable('currentEventItem', null, null);
$_smarty_tpl->tpl_vars['currentEventItem']->value['url'] = '';?>
    <?php if (count($_smarty_tpl->getVariable('data')->value['event'])==0){?>
         <?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['text'] = "Er zijn geen activiteiten gepland";?>
    <?php }else{ ?>
         <?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['text'] = "Er is altijd wat te doen!";?>
    <?php }?>
    <?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['detail'] = '';?>
    <?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['image'] = 0;?>
<?php }?>

<div class="heter">
<div class="heterContent">
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEimage'][0][0]->HEimage(array('id'=>($_smarty_tpl->getVariable('item')->value['image']),'size'=>"small"),$_smarty_tpl);?>

<h2><?php echo $_smarty_tpl->getVariable('item')->value['title'];?>
 <?php echo $_smarty_tpl->getVariable('currentEventItem')->value['name'];?>
</h2>
<h3><?php echo $_smarty_tpl->getVariable('currentEventItem')->value['startText'];?>
</h3>
<h3><?php if ($_smarty_tpl->getVariable('currentEventItem')->value['location']==''&&$_smarty_tpl->getVariable('currentEventItem')->value['url']!=''){?>
<?php if (!isset($_smarty_tpl->tpl_vars['currentEventItem']) || !is_array($_smarty_tpl->tpl_vars['currentEventItem']->value)) $_smarty_tpl->createLocalArrayVariable('currentEventItem', null, null);
$_smarty_tpl->tpl_vars['currentEventItem']->value['location'] = "info";?>
<?php }?>
<?php if ($_smarty_tpl->getVariable('currentEventItem')->value['location']!=''){?>
<br/>
<?php if ($_smarty_tpl->getVariable('currentEventItem')->value['url']!=''){?>
<a href="<?php echo $_smarty_tpl->getVariable('currentEventItem')->value['url'];?>
"><?php echo $_smarty_tpl->getVariable('currentEventItem')->value['location'];?>
</a>
<?php }else{ ?>
<?php echo $_smarty_tpl->getVariable('currentEventItem')->value['location'];?>

<?php }?>
<?php }?></h3>
<p><?php echo $_smarty_tpl->getVariable('item')->value['text'];?>
</p>
<p><?php echo $_smarty_tpl->getVariable('item')->value['detail'];?>
</p>
</div>
<div class="heterContent">
<form id="kalender" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<table>
<?php  $_smarty_tpl->tpl_vars['elt'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['form']['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['elt']->key => $_smarty_tpl->tpl_vars['elt']->value){
?>
<?php if ($_smarty_tpl->tpl_vars['elt']->value['value']!=''||!$_smarty_tpl->tpl_vars['elt']->value['protected']){?>
<tr>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>"fd[users]",'data'=>$_smarty_tpl->tpl_vars['elt']->value),$_smarty_tpl);?>

</tr>
<?php }?>
<?php }} ?>
<?php if ($_smarty_tpl->getVariable('NOROBOT')->value!="OK"){?>
<tr><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFrecaptcha'][0][0]->HFrecaptcha(array(),$_smarty_tpl);?>
</tr>
<?php }?>
<tr>
<td>
<input type="hidden" name="fd[eventRegister][id]" value="<?php echo $_smarty_tpl->getVariable('currentEventItem')->value['id'];?>
" />
<input type="hidden" name="fd[eventRegister][start]" value="<?php echo $_smarty_tpl->getVariable('currentEventItem')->value['start'];?>
" />
<input type="submit" name="fd[command]" value="<?php echo $_smarty_tpl->getVariable('command')->value;?>
"/>
</td>
<td><input type="reset" value="WISSEN"/></td>
</tr>
</table>
</form>
<p><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEsocial'][0][0]->HEsocial(array('currentEventId'=>($_smarty_tpl->getVariable('currentEventItem')->value['id']),'currentStart'=>($_smarty_tpl->getVariable('currentEventItem')->value['start'])),$_smarty_tpl);?>
</p>
</div>
</div>

</div><!-- hierzo -->
</div>
<div class="linkerDeel">

<table>
<?php $_smarty_tpl->tpl_vars['lastYear'] = new Smarty_variable(-1, null, null);?><?php $_smarty_tpl->tpl_vars['lastMonth'] = new Smarty_variable(-1, null, null);?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['GENERAL']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['date'][1] = $_smarty_tpl->tpl_vars['item']->value['date'][1]+0;?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['date'][1]!=$_smarty_tpl->getVariable('lastMonth')->value||$_smarty_tpl->tpl_vars['item']->value['date'][0]!=$_smarty_tpl->getVariable('lastYear')->value){?>
<?php ob_start();?><?php echo $_smarty_tpl->getVariable('monthNames')->value[$_smarty_tpl->tpl_vars['item']->value['date'][1]];?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['month'] = new Smarty_variable($_tmp1, null, null);?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['date'][0]!=$_smarty_tpl->getVariable('lastYear')->value){?>
<?php $_smarty_tpl->tpl_vars['lastYear'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value['date'][0], null, null);?>
<?php $_smarty_tpl->tpl_vars['month'] = new Smarty_variable(($_smarty_tpl->getVariable('month')->value)." ".($_smarty_tpl->tpl_vars['item']->value['date'][0]), null, null);?>
<?php }?>
<?php $_smarty_tpl->tpl_vars['lastMonth'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value['date'][1], null, null);?>
<tr>
<td colspan='3'><div class="calendarH1"><?php echo $_smarty_tpl->getVariable('month')->value;?>
</div></td>
</tr>
<?php }?>
<tr>
<td>
<?php if ($_smarty_tpl->tpl_vars['item']->value['image']!=0){?>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEimage'][0][0]->HEimage(array('id'=>($_smarty_tpl->tpl_vars['item']->value['image']),'size'=>"thumb"),$_smarty_tpl);?>

<?php }?>
</td>
<td><div class="calendarH2"><?php echo $_smarty_tpl->tpl_vars['item']->value['date'][2];?>
</div></td>
<td>
<a href="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
<?php $_tmp2=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['start'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEbuildURI'][0][0]->HEbuildURI(array('keep'=>"tab",'currentEventId'=>$_tmp2,'currentStart'=>$_tmp3),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
 <?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
<?php if ($_smarty_tpl->tpl_vars['item']->value['location']==''&&$_smarty_tpl->tpl_vars['item']->value['url']!=''){?>
<?php if (!isset($_smarty_tpl->tpl_vars['item']) || !is_array($_smarty_tpl->tpl_vars['item']->value)) $_smarty_tpl->createLocalArrayVariable('item', null, null);
$_smarty_tpl->tpl_vars['item']->value['location'] = "info";?>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['location']!=''){?>
<br/>
<?php if ($_smarty_tpl->tpl_vars['item']->value['url']!=''){?>
<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['location'];?>
</a>
<?php }else{ ?>
<?php echo $_smarty_tpl->tpl_vars['item']->value['location'];?>

<?php }?>
<?php }?>
</td>
</tr>
<?php }} ?>
</table>

</div>
<div class="rechterDeel">

<div class="recentNieuwsKader">
<form id="hiddenSearch" method="GET" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="action" value="showEvent"/>
<input type="hidden" name="fd[event][id]" value=""/>
</form>
<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rightColumns')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
?>
<?php  $_smarty_tpl->tpl_vars['event'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value[$_smarty_tpl->getVariable('group')->value]['dates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['event']->key => $_smarty_tpl->tpl_vars['event']->value){
?>
<table>
<tr><th colspan="2">
<a href="<?php echo $_smarty_tpl->getVariable('data')->value[$_smarty_tpl->getVariable('group')->value]['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['event']->value['title'];?>
</a>
</th></tr>
<?php $_smarty_tpl->tpl_vars['lastDate'] = new Smarty_variable('', null, null);?>
<?php  $_smarty_tpl->tpl_vars['start'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['event']->value['start']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['start']->key => $_smarty_tpl->tpl_vars['start']->value){
?>
<tr>
<td><?php if ($_smarty_tpl->tpl_vars['start']->value['date']!=$_smarty_tpl->getVariable('lastDate')->value){?><?php $_smarty_tpl->tpl_vars['lastDate'] = new Smarty_variable($_smarty_tpl->tpl_vars['start']->value['date'], null, null);?><?php echo $_smarty_tpl->tpl_vars['start']->value['date'];?>
<?php }?></td>
<td><?php echo $_smarty_tpl->tpl_vars['start']->value['time'];?>
</td>
</tr>
<?php }} ?>
</table>
<?php }} ?>
<?php }} ?>
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
</html>
