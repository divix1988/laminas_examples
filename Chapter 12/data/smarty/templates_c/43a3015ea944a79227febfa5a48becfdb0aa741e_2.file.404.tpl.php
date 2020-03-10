<?php
/* Smarty version 3.1.34-dev-7, created on 2020-03-01 01:04:04
  from 'E:\RZECZY_ADAMA\_XAMPP\xampp-7.4\htdocs\laminas_app\module\Application\view\error\404.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e5afbf4475e37_58754411',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '43a3015ea944a79227febfa5a48becfdb0aa741e' => 
    array (
      0 => 'E:\\RZECZY_ADAMA\\_XAMPP\\xampp-7.4\\htdocs\\laminas_app\\module\\Application\\view\\error\\404.tpl',
      1 => 1583021007,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e5afbf4475e37_58754411 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<h1>A 404 error occurred</h1>
<h2><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['message']->value, ENT_QUOTES, 'UTF-8');?>
</h2>
<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'layout/layout.tpl');
}
}
