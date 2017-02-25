<?php
/* Smarty version 3.1.30, created on 2017-02-12 21:36:53
  from "C:\Users\Hugo\Documents\WSVL\public_html\WSVL-surf\surf\templates\wvLeidschendam.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a0c7654980a8_51741210',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd8071d07d53dd9c56c7986a2ea4544191502c1e8' => 
    array (
      0 => 'C:\\Users\\Hugo\\Documents\\WSVL\\public_html\\WSVL-surf\\surf\\templates\\wvLeidschendam.tpl',
      1 => 1456052528,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a0c7654980a8_51741210 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'C:\\Users\\Hugo\\Documents\\WSVL\\public_html\\WSVL-surf\\smarty\\libs\\plugins\\modifier.date_format.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta name="viewport" content="width=device-width, height=device-height"/>  
<meta http-equiv="Content-type" content="text/html;charset=utf-8"/>
<meta name="google" content="notranslate"/>
<meta name="description" content="Windsurfvereniging Leidschendam e.o. op het surfstrand van Vlietland. Daar vind je windsurfles, training, clubwedstrijde, windsurfweekends en nog veel meer." />
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="<?php echo $_smarty_tpl->tpl_vars['stylesheet']->value;?>
" rel="stylesheet" type="text/css"/>
<title><?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_935358a0c7652d8de9_54356416', "title");
?>
</title>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['og']->value, 'val', false, 'tag');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->value => $_smarty_tpl->tpl_vars['val']->value) {
?>
<meta property="og:<?php echo $_smarty_tpl->tpl_vars['tag']->value;?>
" content="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" />
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['javascriptFiles']->value, 'script');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['script']->value) {
echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['script']->value;?>
"><?php echo '</script'; ?>
>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php if (count($_smarty_tpl->tpl_vars['javascriptStatements']->value)) {
echo '<script'; ?>
 type="text/javascript">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['javascriptStatements']->value, 'statement');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['statement']->value) {
echo $_smarty_tpl->tpl_vars['statement']->value;?>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
   $(document).ready(function(){
      showLogin(<?php echo $_smarty_tpl->tpl_vars['mustLogin']->value;?>
 && !<?php echo $_smarty_tpl->tpl_vars['loggedIn']->value;?>
);
      addOnClicks();
      $(document).ajaxError(function(event,xhr,options,exc)
      {
        window.alert("exception"+event);
      })
   });
<?php echo '</script'; ?>
>
<?php }?>
</head> 
<body>
<div id="fb-root"></div>
<?php echo '<script'; ?>
>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
<?php echo '</script'; ?>
>
<!-- 21-1-2016 removed illegal characters from twitter script -->
<?php echo '<script'; ?>
>window.twttr = (function(d, s, id) {
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
<?php echo '</script'; ?>
>
<div class="contentArea">
<!-- NAVIGATIE MENU BALK MET LOGO -->
<div class="navHeader" id="navHeader">
<h1>Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest. <img id="navHeaderLogo" src="images/logo.gif" width="755" height="56" alt="WV Leidschendam - Surf"/>
<!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></h1>
</div>
<div class="huug" id="huug">
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEcssmenu'][0][0]->HEcssmenu(array('menu'=>$_smarty_tpl->tpl_vars['mainMenu']->value,'id'=>"cssmenu",'hassub'=>"has-sub",'last'=>"last"),$_smarty_tpl);?>

</div>
<div class="errors">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['errors']->value, 'error');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['error']->value) {
?>
<div class="error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</div>
<div class="infos">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['infos']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>
<div class="info"><?php echo $_smarty_tpl->tpl_vars['info']->value;?>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

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
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2507958a0c76533f9f9_37295059', "body");
?>

</div>
<div class="footerTxt">
	Copyright &copy; 1978-<?php echo smarty_modifier_date_format(time(),'%Y');?>
 Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href="http://www.watersportverbond.nl" target="_blank"><img src="images/logo_watersportverbond.gif" alt="Watersportverbond" style="border:no" /></a>&nbsp;
            <a href="http://www.cwo.nl" target="_blank"><img src="images/logo_cwo.gif" alt="CWO" style="border:no" /></a>
<!-- Google analytics -->
<?php echo '<script'; ?>
 src="http://www.google-analytics.com/urchin.js" type="text/javascript">
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
_uacct = "UA-325606-2";
urchinTracker();
<?php echo '</script'; ?>
>
</div>
</body>
<?php if (count($_smarty_tpl->tpl_vars['traces']->value)) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['traces']->value, 'trace');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['trace']->value) {
?>
<!-- <?php echo $_smarty_tpl->tpl_vars['trace']->value;?>
 -->
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php }?>
<!-- <?php echo $_smarty_tpl->tpl_vars['template']->value;?>
 -->
</html>
<?php }
/* {block "title"} */
class Block_935358a0c7652d8de9_54356416 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['og']->value['title'];
}
}
/* {/block "title"} */
/* {block "body"} */
class Block_2507958a0c76533f9f9_37295059 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
Deze pagina is nog niet ingevuld<?php
}
}
/* {/block "body"} */
}
