<?php
/* Smarty version 3.1.30, created on 2017-02-12 21:36:53
  from "C:\Users\Hugo\Documents\WSVL\public_html\WSVL-surf\surf\templates\wsvl_Home.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a0c76511f5e2_48989407',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aa90f588eccd37ab3992645433d09a4442d5463b' => 
    array (
      0 => 'C:\\Users\\Hugo\\Documents\\WSVL\\public_html\\WSVL-surf\\surf\\templates\\wsvl_Home.tpl',
      1 => 1468441398,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:wvLeidschendam.tpl' => 1,
  ),
),false)) {
function content_58a0c76511f5e2_48989407 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2461358a0c7650fe575_15496187', "body");
?>


<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:wvLeidschendam.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block "body"} */
class Block_2461358a0c7650fe575_15496187 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php $_smarty_tpl->_assignInScope('heterOpen', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['hotNews']->value, 'hotItem');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['hotItem']->value) {
?>
    <?php if (!$_smarty_tpl->tpl_vars['heterOpen']->value) {?>
	<?php $_smarty_tpl->_assignInScope('heterOpen', 1);
?>
	<div class="heter">
    <?php }?>
    <div class="heterContent">
    <?php if ($_smarty_tpl->tpl_vars['hotItem']->value['news_image'] != '') {?>
	<img src="<?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_title'];?>
" class="img_small"/>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['hotItem']->value['news_title'] != '') {?>
	<h3><?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_title'];?>
</h3>
    <?php }?>
    <p><?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_short'];?>
</p>
    <div class="linkLogo">
    <a href="news_leesverder.php?news_id=<?php echo $_smarty_tpl->tpl_vars['hotItem']->value['news_id'];?>
">
    <img src="<?php echo $_smarty_tpl->tpl_vars['imageRoot']->value;?>
/butt_sm_leesverder.gif" alt="Lees verder">
    </a>
    </div>
    </div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php if ($_smarty_tpl->tpl_vars['heterOpen']->value) {?>
    </div>
    <div class="heterBottom">
        <img src="<?php echo $_smarty_tpl->tpl_vars['imageRoot']->value;?>
/heter_dan_de_overstag.gif" alt="heter dan de Overstag">
    </div>
<?php }?>
<div class="tweeDelen">
	<div class="linkerDeel">
	<div class="titelBalk"><img src="<?php echo $_smarty_tpl->tpl_vars['imageRoot']->value;?>
/kop_over-ons.gif" alt="Over ons"/></div>
	   	<p><?php echo $_smarty_tpl->tpl_vars['aboutUs']->value;?>
<p>
	</div>
	<div class="rechterDeel">
		<div class="titelBalk"><img src="<?php echo $_smarty_tpl->tpl_vars['imageRoot']->value;?>
/kop_recent-nieuws.gif" alt="Recent nieuws"/></div>
		<div class="recentNieuwsKader">
		<?php $_smarty_tpl->_assignInScope('i', 0);
$_smarty_tpl->_assignInScope('ul', 0);
?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newsItems']->value, 'newsItem');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['newsItem']->value) {
?>
		    <?php if ($_smarty_tpl->tpl_vars['i']->value < 2) {?>
			<div class="recentNieuwsBericht">
			<h2 class="nieuwsTitel"><?php echo $_smarty_tpl->tpl_vars['newsItem']->value['news_title'];?>
</h2>
			<p><?php echo $_smarty_tpl->tpl_vars['newsItem']->value['news_short'];?>
</p>
			<div class="miniLeesverder">
			    <a href="news_leesverder.php?news_id=<?php echo $_smarty_tpl->tpl_vars['newsItem']->value['news_id'];?>
">
				<img src="<?php echo $_smarty_tpl->tpl_vars['imageRoot']->value;?>
/butt_sm_leesverder.gif" alt="Lees verder"/>
			    </a>
			</div>
			</div>
		    <?php } else { ?>
			<?php if ($_smarty_tpl->tpl_vars['ul']->value == 0) {?> <ul> <?php $_smarty_tpl->_assignInScope('ul', 1);
?> <?php }?>
			<li class="nieuwsTitel">
			    <a href="news_leesverder.php?news_id=<?php echo $_smarty_tpl->tpl_vars['newsItem']->value['news_id'];?>
">
			        <?php echo $_smarty_tpl->tpl_vars['newsItem']->value['news_title'];?>

			    </a>
			</li>
		    <?php }?>
			<?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		<?php if ($_smarty_tpl->tpl_vars['ul']->value != 0) {?></ul><?php }?>
		</div>
	</div>
</div>
<?php
}
}
/* {/block "body"} */
}
