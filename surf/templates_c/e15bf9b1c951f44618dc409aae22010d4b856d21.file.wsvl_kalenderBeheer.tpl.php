<?php /* Smarty version Smarty-3.0.6, created on 2016-02-05 13:44:47
         compiled from "./templates/wsvl_kalenderBeheer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4702093705644fb0d48cb02-78411694%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e15bf9b1c951f44618dc409aae22010d4b856d21' => 
    array (
      0 => './templates/wsvl_kalenderBeheer.tpl',
      1 => 1454615489,
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
  'nocache_hash' => '4702093705644fb0d48cb02-78411694',
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

<h3>Voer hier de clubactiviteiten in of werk de gevens bij</h3>

</div><!-- hierzo -->
</div>
<div class="linkerDeel">

<form id="eventData" enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<?php if (isset($_smarty_tpl->getVariable('search',null,true,false)->value)){?>
<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('search')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
<input type='hidden' name='fd_search_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
">
<?php }} ?>
<?php }?>
<input type="hidden" name="action" value="saveEvent"/>
<table>
<tr><th colspan="3">
<h3><?php if ($_smarty_tpl->getVariable('currentId')->value<=0){?>Nieuw Evenement<?php }else{ ?>Evenement bewerken<?php }?></h3>
</th></tr>
<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
<?php if (!isset($_smarty_tpl->tpl_vars['prefix']) || !is_array($_smarty_tpl->tpl_vars['prefix']->value)) $_smarty_tpl->createLocalArrayVariable('prefix', null, null);
$_smarty_tpl->tpl_vars['prefix']->value[$_smarty_tpl->getVariable('i')->value] = "fd[event]";?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['event']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>($_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value]),'data'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>

    <td></td>
</tr>
<?php }} ?>
<tr><th colspan="3">
<h3>Voeg eventueel een nieuwe afbeelding toe</h3>
</th></tr>
<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
<?php if (!isset($_smarty_tpl->tpl_vars['prefix']) || !is_array($_smarty_tpl->tpl_vars['prefix']->value)) $_smarty_tpl->createLocalArrayVariable('prefix', null, null);
$_smarty_tpl->tpl_vars['prefix']->value[$_smarty_tpl->getVariable('i')->value] = "fd[image]";?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['image']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>($_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value]),'data'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>

    <td></td>
</tr>
<?php }} ?>
<tr><td colspan="3">
<h3>Data waarop dit evenement plaats vindt en aanvullende informatie</h3>
</td></tr>
<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable(0, null, null);?>
<?php if (!isset($_smarty_tpl->tpl_vars['prefix']) || !is_array($_smarty_tpl->tpl_vars['prefix']->value)) $_smarty_tpl->createLocalArrayVariable('prefix', null, null);
$_smarty_tpl->tpl_vars['prefix']->value[$_smarty_tpl->getVariable('i')->value] = "fd[calendar]";?>
<?php ob_start();?><?php echo $_smarty_tpl->getVariable('i')->value+1;?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_tmp1, null, null);?>
<?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable(0, null, null);?>
<?php  $_smarty_tpl->tpl_vars['eventItem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['calendar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['eventItem']->key => $_smarty_tpl->tpl_vars['eventItem']->value){
?>
<?php ob_start();?><?php echo $_smarty_tpl->getVariable('j')->value+1;?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['j'] = new Smarty_variable($_tmp2, null, null);?>
<?php if (!isset($_smarty_tpl->tpl_vars['prefix']) || !is_array($_smarty_tpl->tpl_vars['prefix']->value)) $_smarty_tpl->createLocalArrayVariable('prefix', null, null);
$_smarty_tpl->tpl_vars['prefix']->value[$_smarty_tpl->getVariable('i')->value] = ($_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value-1])."[".($_smarty_tpl->getVariable('j')->value)."]";?>
<?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEelement'][0][0]->HEelement(array('tag'=>"a",'value'=>"-",'onClick'=>"switchList('eventData', '".($_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value])."', 0)"),$_smarty_tpl);?>
<?php $_tmp3=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['min'] = new Smarty_variable($_tmp3, null, null);?>
<?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEelement'][0][0]->HEelement(array('tag'=>"a",'value'=>"+",'onClick'=>"switchList('eventData', '".($_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value])."', 1)"),$_smarty_tpl);?>
<?php $_tmp4=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['plus'] = new Smarty_variable($_tmp4, null, null);?>
<?php $_smarty_tpl->tpl_vars['col3'] = new Smarty_variable(($_smarty_tpl->getVariable('min')->value)."/".($_smarty_tpl->getVariable('plus')->value), null, null);?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['eventItem']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<tr name='<?php echo $_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value];?>
'>
    <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>($_smarty_tpl->getVariable('prefix')->value[$_smarty_tpl->getVariable('i')->value]),'data'=>$_smarty_tpl->tpl_vars['item']->value),$_smarty_tpl);?>

    <td><?php echo $_smarty_tpl->getVariable('col3')->value;?>
</td>
</tr>
<?php $_smarty_tpl->tpl_vars['col3'] = new Smarty_variable('', null, null);?>
<?php }} ?>
<?php }} ?>
<tr>
<td>Herhaal</td>
<td>
<select name="fd[copy][count]" id="fd[copy][count]" />
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
</select>x elke
<select name="fd[copy][interval]" id="fd[copy][interval]">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
</select>
<select name="fd[copy][unit]" id="fd[copy][unit]">
<option value="hour">uur</option>
<option value="day">dag</option>
<option value="week">week</option>
<option value="month">maand</option>
</select>
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
<form id="hiddenSearch" method="GET" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="action" value="showEvent">
<input type="hidden" name="fd[event][id]" value="">
</form>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('eventList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<li class="nieuwsTitel">
<a href="#" onClick="setAndSubmit('hiddenSearch','id.', <?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
)">
<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>

</a>
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
