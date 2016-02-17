<?php /* Smarty version Smarty-3.0.6, created on 2014-11-20 20:41:09
         compiled from "./templates/wsvl_importUsersProcess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:802653360546e43d5516205-40849598%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '089a1b073b1a5cf44d0b5d22fd05acbe4a72ff12' => 
    array (
      0 => './templates/wsvl_importUsersProcess.tpl',
      1 => 1399227553,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '802653360546e43d5516205-40849598',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php echo '<?xml';?> version="1.0" <?php echo '?>';?>
<response>

<errors>
<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
<div name="error"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
<?php }} ?>
</errors>
<results>
<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 0;
  if ($_smarty_tpl->getVariable('i')->value<count($_smarty_tpl->getVariable('status')->value)){ for ($_foo=true;$_smarty_tpl->getVariable('i')->value<count($_smarty_tpl->getVariable('status')->value); $_smarty_tpl->tpl_vars['i']->value++){
?>
<result>
<group><?php echo $_smarty_tpl->getVariable('group')->value[$_smarty_tpl->tpl_vars['i']->value];?>
</group>
<status><?php echo $_smarty_tpl->getVariable('status')->value[$_smarty_tpl->tpl_vars['i']->value];?>
</status>
<uniqueKey><?php echo $_smarty_tpl->getVariable('uniqueKey')->value[$_smarty_tpl->tpl_vars['i']->value];?>
</uniqueKey>
<error><?php echo $_smarty_tpl->getVariable('recordError')->value[$_smarty_tpl->tpl_vars['i']->value];?>
</error>
</result>
<?php }} ?>
</results>
</response>

