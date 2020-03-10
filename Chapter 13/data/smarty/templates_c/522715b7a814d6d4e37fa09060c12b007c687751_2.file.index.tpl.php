<?php
/* Smarty version 3.1.34-dev-7, created on 2020-03-01 01:13:35
  from 'E:\RZECZY_ADAMA\_XAMPP\xampp-7.4\htdocs\laminas_app\module\Application\view\application\index\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e5afe2f714d82_16295725',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '522715b7a814d6d4e37fa09060c12b007c687751' => 
    array (
      0 => 'E:\\RZECZY_ADAMA\\_XAMPP\\xampp-7.4\\htdocs\\laminas_app\\module\\Application\\view\\application\\index\\index.tpl',
      1 => 1583021613,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e5afe2f714d82_16295725 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12871793755e5afe2f712773_83012673', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, 'layout/layout.tpl');
}
/* {block 'content'} */
class Block_12871793755e5afe2f712773_83012673 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_12871793755e5afe2f712773_83012673',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="jumbotron">
        <h1><span class="zf-green">User from DB test</span></h1>
        <p>
            Found user:<br /><br />
            Id: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
<br />
            Username: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['username']->value, ENT_QUOTES, 'UTF-8');?>
<br />
            Password: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['password']->value, ENT_QUOTES, 'UTF-8');?>

        </p>
    </div>
<?php
}
}
/* {/block 'content'} */
}
