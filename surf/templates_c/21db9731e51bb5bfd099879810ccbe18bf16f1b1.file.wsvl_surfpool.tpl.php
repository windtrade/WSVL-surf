<?php /* Smarty version Smarty-3.0.6, created on 2015-05-08 16:36:50
         compiled from "./templates/wsvl_surfpool.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1502759007554cca020964c0-72426043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21db9731e51bb5bfd099879810ccbe18bf16f1b1' => 
    array (
      0 => './templates/wsvl_surfpool.tpl',
      1 => 1431095802,
      2 => 'file',
    ),
    'a28f446736d8ce46541af161844c498badb36845' => 
    array (
      0 => './templates/wsvl_personal.tpl',
      1 => 1426110504,
      2 => 'file',
    ),
    'dc988f96e970005423b1d45e5f90981520323cfe' => 
    array (
      0 => './templates/wvLeidschendam.tpl',
      1 => 1428050896,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1502759007554cca020964c0-72426043',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/home/wvleid01/domains/wvleidschendam.nl/public_html/Smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE HTML>
<HTML>
<head>
<meta name="viewport" content="width=device-width, height=device-height">  
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="google" content="notranslate">
<meta name="description" content="Windsurfvereniging Leidschendam e.o. is te vinden aan het surfstrand van recreatiegebied Vlietland, langs A4 tussen Leidschendam, Voorschoten en Leiden in. Waar we surflessen, clubwedstrijden en diverse andere activiteiten organiseren.">
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="<?php echo $_smarty_tpl->getVariable('stylesheet')->value;?>
" rel="stylesheet" type="text/css">
<title>WV Leidschendam Surfpool 24/7</title>
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
<?php }?>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="contentArea">
<!-- NAVIGATIE MENU BALK MET LOGO -->
    <div class="navHeader" id="navHeader">
	<h1>
	    Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest.
	    <img id="navHeaderLogo" src="images/logo.gif" width="755" height="56" alt="WV Leidschendam-Surf">
	    <!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //-->
	</h1>
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
    <?php if ($_smarty_tpl->getVariable('mustLogin')->value&&!$_smarty_tpl->getVariable('loggedIn')->value){?>
    <div class="login">
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
	    emailadres of nick:
	    <input name="login" type="text" size="25" />
	    wachtwoord:
	    <input name="password" type="password" size="15" />
	    <input name="action" type="hidden" value="login">
	    <input type="submit" value="in loggen">
	</form>
    </div>
    <?php }else{ ?>
    
<div class="heter">
<div class="heterContent">

<div class="heter">
<div class="heterContent">
<?php if (isset($_smarty_tpl->getVariable('data',null,true,false)->value['user']['id'])&&$_smarty_tpl->getVariable('data')->value['user']['id']!=''){?>
<form id="kalender"
    enctype="multipart/form-data" method="POST"
    action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<table>
<?php  $_smarty_tpl->tpl_vars['elt'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['surfpoolRegistration']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['elt']->key => $_smarty_tpl->tpl_vars['elt']->value){
?>
<?php if ($_smarty_tpl->tpl_vars['elt']->value['value']!=''||!$_smarty_tpl->tpl_vars['elt']->value['protected']){?>
<tr>
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HFlabeledField'][0][0]->HFlabeledField(array('prefix'=>"fd[users]",'data'=>$_smarty_tpl->tpl_vars['elt']->value),$_smarty_tpl);?>

</tr>
<?php }?>
<?php }} ?>
<tr>
<td><input type="submit" name="fd[command]" value="<?php echo $_smarty_tpl->getVariable('command')->value['reservation'];?>
"/></td>
<td><input type="reset" value="WISSEN"/></td>
</tr>
</table>
</form>
<?php }else{ ?>
je moet wel aangemeld zijn om hier wat te kunnen doen
<?php }?>
</div>
</div>

</div>
</div>
<div class="linkerDeel">

<table>
<tr><th colspan="3">Bestaande resreveringen</th><tr>
<tr>
<th>Start</th>
<th>Einde</th>
<th>Locker</th>
</tr>
<?php  $_smarty_tpl->tpl_vars[$_smarty_tpl->getVariable('elt')->value] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('planning')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars[$_smarty_tpl->getVariable('elt')->value]->key => $_smarty_tpl->tpl_vars[$_smarty_tpl->getVariable('elt')->value]->value){
?>
<tr>
<td><?php echo $_smarty_tpl->getVariable('elt')->value['start'];?>
</td>
<td><?php echo $_smarty_tpl->getVariable('elt')->value['end'];?>
</td>
<td><?php echo $_smarty_tpl->getVariable('lockers')->value[$_smarty_tpl->getVariable('elt')->value['locker']];?>
</td>
</tr>
<?php }} ?>
</table>

</div>
<div class="rechterDeel">

<div class="recentNieuwsKader">
<ul>
<ul>
<form id="hiddenSearch" method="POST" action="<?php echo $_SERVER['REQUEST_URI'];?>
">
<input type="hidden" name="action" value="showEvent">
<input type="hidden" name="fd[event][id]" value="">
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
<?php }} ?>
</tr>
<?php }} ?>
</table>
<?php }} ?>
</ul>
</ul>
</div>

</div>

    <?php }?>
</div>
<div class="footerTxt">
	Copyright &copy; 1978-<?php echo smarty_modifier_date_format(time(),'%Y');?>
 Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" border="0" /></a>&nbsp;<a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" border="0" /></a>
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
