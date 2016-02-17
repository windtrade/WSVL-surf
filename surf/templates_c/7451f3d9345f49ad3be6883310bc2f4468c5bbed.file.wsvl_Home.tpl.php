<?php /* Smarty version Smarty-3.0.6, created on 2016-02-05 14:22:54
         compiled from "./templates/wsvl_Home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1437844092551e556d209866-75079568%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7451f3d9345f49ad3be6883310bc2f4468c5bbed' => 
    array (
      0 => './templates/wsvl_Home.tpl',
      1 => 1428051290,
      2 => 'file',
    ),
    'dc988f96e970005423b1d45e5f90981520323cfe' => 
    array (
      0 => './templates/wvLeidschendam.tpl',
      1 => 1454617758,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1437844092551e556d209866-75079568',
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
<title>WV Leidschendam - Surf</title>
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

<?php $_smarty_tpl->tpl_vars['heterOpen'] = new Smarty_variable(0, null, null);?>
<?php  $_smarty_tpl->tpl_vars['hotItem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('hotNews')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['hotItem']->key => $_smarty_tpl->tpl_vars['hotItem']->value){
?>
    <?php if (!$_smarty_tpl->getVariable('heterOpen')->value){?>
	<?php $_smarty_tpl->tpl_vars['heterOpen'] = new Smarty_variable(1, null, null);?>
	<div class="heter">
    <?php }?>
    <div class="heterContent">
    <?php if ($_smarty_tpl->tpl_vars['hotItem']->value['news_image']!=''){?>
	<img src="<?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_title'];?>
">
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['hotItem']->value['news_title']!=''){?>
	<h3><?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_title'];?>
</h3>
    <?php }?>
    <p><?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_short'];?>
</p>
    <div class="linkLogo">
    <a href="news_leesverder.php?news_id=<?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_id'];?>
">
    <img src="<?php echo $_smarty_tpl->getVariable('imageRoot')->value;?>
/butt_sm_leesverder.gif" alt="Lees verder">
    </a>
    </div>
    </div>
<?php }} ?>
<?php if ($_smarty_tpl->getVariable('heterOpen')->value){?>
    </div>
    <div class="heterBottom">
        <img src="<?php echo $_smarty_tpl->getVariable('imageRoot')->value;?>
/heter_dan_de_overstag.gif" alt="heter dan de Overstag">
    </div>
<?php }?>
<div class="tweeDelen">
    <div class="linkerDeel">
	<div class="titelBalk">
	    <img src="<?php echo $_smarty_tpl->getVariable('imageRoot')->value;?>
/kop_over-ons.gif" alt="Over ons">
	</div>
	<p><?php echo $_smarty_tpl->getVariable('aboutUs')->value;?>
</p>
	<div class="fb-like" data-href="http://www.facebook.com/wvleidschendam.surf?" data-send="true" data-width="450" data-show-faces="true" data-font="arial">
	</div>
	<div>
	    <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
		    src="http://maps.google.nl/maps/ms?msa=0&msid=200211834696178789811.0004bcff3d214abfbd88f&hl=nl&ie=UTF8&ll=52.120565,4.45766&spn=0,0&t=h&output=embed">
	    </iframe>
	    <small>
		<a href="http://maps.google.nl/maps/ms?msa=0&msid=200211834696178789811.0004bcff3d214abfbd88f&hl=nl&ie=UTF8&ll=52.120565,4.45766&spn=0,0&t=h&source=embed"
			style="color:#0000FF;text-align:left">
			Mijn opgeslagen plaatsen</a>
		weergeven op een grotere kaart
	    </small>
	</div>
    </div>
    <div class="rechterDeel">
	<div class="titelBalk">
	    <img src="<?php echo $_smarty_tpl->getVariable('imageRoot')->value;?>
/kop_recent-nieuws.gif" alt="Recent nieuws">
	</div>
	<div class="recentNieuwsKader">
	    <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? 1+1 - (0) : 0-(1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
	    <?php if ($_smarty_tpl->tpl_vars['i']->value<count($_smarty_tpl->getVariable('newsItems')->value)){?>
		<?php $_smarty_tpl->tpl_vars['newsItem'] = new Smarty_variable($_smarty_tpl->getVariable('newsItems')->value[$_smarty_tpl->tpl_vars['i']->value], null, null);?>
		<div class="recentNieuwsBericht">
		    <div class="nieuwsTitel">
			<?php echo $_smarty_tpl->getVariable('newsItem')->value['news_title'];?>

		    </div>
		    <p><?php echo $_smarty_tpl->getVariable('newsItem')->value['news_short'];?>
</p>
		    <div class="miniLeesverder">
			<a href="news_leesverder.php?news_id=<?php echo $_smarty_tpl->getVariable('newsItem')->value['news_id'];?>
">
			    <img src="<?php echo $_smarty_tpl->getVariable('imageRoot')->value;?>
/butt_sm_leesverder.gif"
				 alt="lees verder">
			</a>
		    </div>
		</div>
	    <?php }?>
	    <?php }} ?>
	    <ul>
		<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? count($_smarty_tpl->getVariable('newsItems')->value)+1 - (2) : 2-(count($_smarty_tpl->getVariable('newsItems')->value))+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 2, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
		    <?php $_smarty_tpl->tpl_vars['newsItem'] = new Smarty_variable($_smarty_tpl->getVariable('newsItems')->value[$_smarty_tpl->tpl_vars['i']->value], null, null);?>
		    <li class="nieuwsTitel">
		        <a href="news_leesverder.php?news_id=<?php echo $_smarty_tpl->getVariable('newsItem')->value['news_id'];?>
">
			        <?php echo $_smarty_tpl->getVariable('newsItem')->value['news_title'];?>

		        </a>
		    </li>
		<?php }} ?>
	    </ul>
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
