<?php /* Smarty version Smarty-3.0.6, created on 2014-11-20 20:22:03
         compiled from "templates/wsvl_importUsers.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1087736831546e3f5b3252f4-99522058%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e5f6385d706a53f09b3ffd0b1460a2d4b8e0741' => 
    array (
      0 => 'templates/wsvl_importUsers.tpl',
      1 => 1399227553,
      2 => 'file',
    ),
    'dc988f96e970005423b1d45e5f90981520323cfe' => 
    array (
      0 => './templates/wvLeidschendam.tpl',
      1 => 1414184327,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1087736831546e3f5b3252f4-99522058',
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
<meta name="viewport" content="width=device-width, height=device-height">  
<meta http-equiv="Content-type" content="text/html;charset=iso-8859-2">
<meta name="google" content="notranslate">
<meta name="description" content="Windsurfvereniging Leidschendam e.o. is te vinden aan het surfstrand van recreatiegebied Vlietland, langs A4 tussen Leidschendam, Voorschoten en Leiden in. Waar we surflessen, clubwedstrijden en diverse andere activiteiten organiseren.">
<meta name="keywords" content="surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa">
<link href="<?php echo $_smarty_tpl->getVariable('stylesheet')->value;?>
" rel="stylesheet" type="text/css">
<title>WV Leidschendam User Beheer</title>
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
  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="contentArea">
<!-- NAVIGATIE MENU BALK MET LOGO -->
<div class="navHeader" id="navHeader">
<h1>Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest. <img id="navHeaderLogo" src="images/logo.gif" width="755" height="56"><!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></h1>
<?php if (count($_smarty_tpl->getVariable('mainMenu')->value)==-1){?>
<!--
<?php $_smarty_tpl->tpl_vars['subMenu'] = new Smarty_variable('', null, null);?>
<?php if (count($_smarty_tpl->getVariable('mainMenu')->value)){?>
<ul>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('mainMenu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<li>
<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
?tab=<?php echo $_smarty_tpl->tpl_vars['item']->value['tab'];?>
"
<?php if ($_smarty_tpl->tpl_vars['item']->value['tab']==$_smarty_tpl->getVariable('currentTab')->value){?>class="current"
<?php $_smarty_tpl->tpl_vars['subMenu'] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value['subMenu'], null, null);?>
<?php }?>
>
<?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
</a></li>
<?php }} ?>
</ul>
<?php }?>
</div>
<?php if (is_array($_smarty_tpl->getVariable('subMenu')->value)){?>
<?php if (count($_smarty_tpl->getVariable('subMenu')->value)){?>
<div class="pageMenu">
<ul>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('subMenu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
<li>
<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
?tab=<?php echo $_smarty_tpl->getVariable('currentTab')->value;?>
&subTab=<?php echo $_smarty_tpl->tpl_vars['item']->value['tab'];?>
"
<?php if ($_smarty_tpl->tpl_vars['item']->value['tab']==$_smarty_tpl->getVariable('currentSubTab')->value){?>class="currentPageMenu"
<?php }?>
>
<?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
</a>
</li>
<?php }} ?>
</ul>
<?php }?>
<?php }?>
-->
<?php }?>
</div>
<!-- div class="navHeader" id="navHeader" -->
<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['HEcssmenu'][0][0]->HEcssmenu(array('menu'=>$_smarty_tpl->getVariable('mainMenu')->value,'id'=>"cssmenu",'hassub'=>"has-sub",'last'=>"last"),$_smarty_tpl);?>

<!-- /div -->
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

<script type="text/javascript">
function moveToStep(form,step)
{
	if (step < 1) {
		window.alert("Er is geen verder terug");
		return false;
	}
	form.step.value=step;
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('resident')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	addMissingInputToForm(form, "<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
", "<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
");
        <?php }} ?>
	form.submit();
        return true;
}
</script>
<h1>Importeren Ledenbestand</h1><br/>
<h2>Stap <?php echo $_smarty_tpl->getVariable('formStep')->value;?>
:
<?php if ($_smarty_tpl->getVariable('formStep')->value==1){?> Import bestand kiezen
<?php }elseif($_smarty_tpl->getVariable('formStep')->value==2){?> Velden toewijzen aan database kolommen
<?php }elseif($_smarty_tpl->getVariable('formStep')->value==3){?> Records importeren of bestaande gegevens bijwerken
<?php }else{ ?> Verrassing!!!<?php }?>
</h2><br/>
<?php if ($_smarty_tpl->getVariable('formStep')->value==1){?>
<form name="form1_a" method="post" action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
" enctype="multipart/form-data">
<input name="step" type="hidden" value="<?php echo $_smarty_tpl->getVariable('formStep')->value;?>
"/>
<?php echo nl2br("Importeren van een CSV bestand, let op:
<list>
<li>Vooraan de file worden regels met slechts een enkel veld geskipt.</li>
<li>Er wordt een kolomregel verwacht als begin van de gegevens.</li>
<li>Alle regels dienen evenveel kolommen te bevatten.</li>
</list>");?>
<br/>
Geef importbestand: <input type="file" name="importFile" /><br/>
<a href="javascript:moveToStep(document.form1_a, <?php echo $_smarty_tpl->getVariable('formStep')->value+1;?>
)">verder</a>
</form>
<?php if ($_smarty_tpl->getVariable('importFile')->value!=''){?>
<form name="form1_b" method="post" action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
">
U kunt ook verder met dit importbestand:
<input name="step" type="hidden" value="<?php echo $_smarty_tpl->getVariable('formStep')->value;?>
"/>
<?php echo $_smarty_tpl->getVariable('importFile')->value;?>

<input type="hidden" name="importFile" value="<?php echo $_smarty_tpl->getVariable('importFile')->value;?>
" />
<a href="javascript:moveToStep(document.form1_b, <?php echo $_smarty_tpl->getVariable('formStep')->value+1;?>
)">verder</a>
</form>
<?php }?>
<?php }elseif($_smarty_tpl->getVariable('formStep')->value==2){?>
<form name="form2" method="post" action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
">
<table>
<tr><td>Import</td>
<?php  $_smarty_tpl->tpl_vars['impColumn'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('impColumns')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['impColumn']->key => $_smarty_tpl->tpl_vars['impColumn']->value){
?>
   <td><?php echo $_smarty_tpl->tpl_vars['impColumn']->value;?>
</td>
<?php }} ?>
</tr>
<tr><td>Intern</td>
<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? count($_smarty_tpl->getVariable('impColumns')->value)-1+1 - (0) : 0-(count($_smarty_tpl->getVariable('impColumns')->value)-1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
   <?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable("destColumn_".($_smarty_tpl->tpl_vars['i']->value), null, null);?>
   <?php if (isset($_smarty_tpl->getVariable('resident',null,true,false)->value[$_smarty_tpl->getVariable('name',null,true,false)->value])){?>
	<?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable($_smarty_tpl->getVariable('resident')->value[$_smarty_tpl->getVariable('name')->value], null, null);?>
   <?php }else{ ?>
        <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable('', null, null);?>
   <?php }?>
   <td>
      <select id="<?php echo $_smarty_tpl->getVariable('name')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('name')->value;?>
">
      <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->getVariable('tbColumns')->value,'output'=>$_smarty_tpl->getVariable('tbColumns')->value,'selected'=>$_smarty_tpl->getVariable('val')->value),$_smarty_tpl);?>

      </select>
   </td>
<?php }} ?>
</tr>
<tr>
<td>Uniek veld</td><td>
<?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable("uniqueKey", null, null);?>
<?php if (isset($_smarty_tpl->getVariable('resident',null,true,false)->value[$_smarty_tpl->getVariable('name',null,true,false)->value])){?>
     <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable($_smarty_tpl->getVariable('resident')->value[$_smarty_tpl->getVariable('name')->value], null, null);?>
<?php }else{ ?>
     <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable('', null, null);?>
<?php }?>
   <select id="<?php echo $_smarty_tpl->getVariable('name')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('name')->value;?>
">
   <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->getVariable('tbColumns')->value,'output'=>$_smarty_tpl->getVariable('tbColumns')->value,'selected'=>$_smarty_tpl->getVariable('val')->value),$_smarty_tpl);?>

   </select>
</td>
<td>Koppel veld</td><td>
<?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable("primaryMatchColumn", null, null);?>
<?php if (isset($_smarty_tpl->getVariable('resident',null,true,false)->value[$_smarty_tpl->getVariable('name',null,true,false)->value])){?>
     <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable($_smarty_tpl->getVariable('resident')->value[$_smarty_tpl->getVariable('name')->value], null, null);?>
<?php }else{ ?>
     <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable('', null, null);?>
<?php }?>
   <select id="<?php echo $_smarty_tpl->getVariable('name')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('name')->value;?>
">
   <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->getVariable('tbColumns')->value,'output'=>$_smarty_tpl->getVariable('tbColumns')->value,'selected'=>$_smarty_tpl->getVariable('val')->value),$_smarty_tpl);?>

   </select>
</td>
<td>2e koppel veld</td><td colspan="0">
<?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable("alternateMatchColumn", null, null);?>
<?php if (isset($_smarty_tpl->getVariable('resident',null,true,false)->value[$_smarty_tpl->getVariable('name',null,true,false)->value])){?>
     <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable($_smarty_tpl->getVariable('resident')->value[$_smarty_tpl->getVariable('name')->value], null, null);?>
<?php }else{ ?>
     <?php $_smarty_tpl->tpl_vars['val'] = new Smarty_variable('', null, null);?>
<?php }?>
   <select id="<?php echo $_smarty_tpl->getVariable('name')->value;?>
" name="<?php echo $_smarty_tpl->getVariable('name')->value;?>
">
   <?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->getVariable('tbColumns')->value,'output'=>$_smarty_tpl->getVariable('tbColumns')->value,'selected'=>$_smarty_tpl->getVariable('val')->value),$_smarty_tpl);?>

   </select>
</td>
</tr>
<tr>
<td>
<tr><td>
<input type="hidden" name="step" value="<?php echo $_smarty_tpl->getVariable('formStep')->value;?>
">
<a href="javascript:moveToStep(document.form2, <?php echo $_smarty_tpl->getVariable('formStep')->value-1;?>
)">Terug</a></td>
<td><a href="javascript:document.form2.reset();">Herstel</a></td>
<td><a href="javascript:moveToStep(document.form2, <?php echo $_smarty_tpl->getVariable('formStep')->value+1;?>
)">Verder</a></td>
</tr>
<?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('users')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
<tr><td>Import</td>
<?php  $_smarty_tpl->tpl_vars['column'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['row']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['column']->key => $_smarty_tpl->tpl_vars['column']->value){
?>
   <td><?php echo $_smarty_tpl->tpl_vars['column']->value;?>
</td>
<?php }} ?>
</tr>
<?php }} ?>
</table>
</form>
<?php }elseif($_smarty_tpl->getVariable('formStep')->value==3){?>
<form name="form<?php echo $_smarty_tpl->getVariable('formStep')->value;?>
" method="post" action="<?php echo $_smarty_tpl->getVariable('action')->value;?>
">
<input type="hidden" name="uniqueKey" id="uniqueKey" value="<?php echo $_smarty_tpl->getVariable('uniqueKey')->value;?>
"/>
<table>
<tr>
<td colspan="3">
<a href="javascript:moveToStep(document.form3, <?php echo $_smarty_tpl->getVariable('formStep')->value-1;?>
)">Terug</a>
</td>
</tr>
<tr>
<td colspan="3">Actie</td>
<td><?php echo $_smarty_tpl->getVariable('uniqueKey')->value;?>
</td>
<?php if (count($_smarty_tpl->getVariable('impColumns')->value)>0){?>
<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? count($_smarty_tpl->getVariable('impColumns')->value)-1+1 - (0) : 0-(count($_smarty_tpl->getVariable('impColumns')->value)-1)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 0, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
   <?php $_smarty_tpl->tpl_vars['name'] = new Smarty_variable("destColumn_".($_smarty_tpl->tpl_vars['i']->value), null, null);?>
   <?php if ($_smarty_tpl->getVariable('resident')->value[$_smarty_tpl->getVariable('name')->value]!=''){?><td><?php echo $_smarty_tpl->getVariable('resident')->value[$_smarty_tpl->getVariable('name')->value];?>
</td><?php }?>
<?php }} ?>
<?php }?>
</tr>
<?php if (count($_smarty_tpl->getVariable('matchUsers')->value)==0){?>
<tr><td colspan="0">Geen records in <?php echo $_smarty_tpl->getVariable('resident')->value['importFile'];?>
</td><tr>
<?php }else{ ?>
<?php  $_smarty_tpl->tpl_vars['matchUser'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('matchUsers')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['matchUser']->key => $_smarty_tpl->tpl_vars['matchUser']->value){
?>
<tr><?php echo $_smarty_tpl->tpl_vars['matchUser']->value;?>
</tr>
<?php }} ?>
<?php }?>
<tr>
<td colspan="3">
<input type="hidden" name="step" value="<?php echo $_smarty_tpl->getVariable('formStep')->value;?>
">
<a href="javascript:moveToStep(document.form3, <?php echo $_smarty_tpl->getVariable('formStep')->value-1;?>
)">Terug</a>
</td>
</tr>
</table>
</form>
<?php }else{ ?>
Step = <?php echo $_smarty_tpl->getVariable('formStep')->value;?>

<?php }?>

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
<!--
count $subMenu = <?php echo count($_smarty_tpl->getVariable('subMenu')->value);?>
...
$subMenu is <?php if (is_array($_smarty_tpl->getVariable('subMenu')->value)){?>array<?php }else{ ?>no array<?php }?>
<?php  $_smarty_tpl->tpl_vars['trace'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('traces')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['trace']->key => $_smarty_tpl->tpl_vars['trace']->value){
?>
<?php echo $_smarty_tpl->tpl_vars['trace']->value;?>

<?php }} ?>
-->
<?php }?>
</html>
