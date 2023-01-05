<?php
/* Smarty version 3.1.34-dev-7, created on 2020-03-01 01:11:58
  from 'E:\RZECZY_ADAMA\_XAMPP\xampp-7.4\htdocs\laminas_app\module\Application\view\layout\layout.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e5afdcec20916_26234888',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a0177503238b7605211c065eea6a217f6bae3c8b' => 
    array (
      0 => 'E:\\RZECZY_ADAMA\\_XAMPP\\xampp-7.4\\htdocs\\laminas_app\\module\\Application\\view\\layout\\layout.tpl',
      1 => 1583021517,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e5afdcec20916_26234888 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Laminas MVC Skeleton</title>

        <link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/img/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
	<link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/css/style.css" rel="stylesheet" type="text/css" />

        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/js/jquery-3.4.1.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
">
                        <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/img/laminas-logo.svg" height="28" alt="Laminas MVC Skeleton"/>&nbsp;Laminas MVC Skeleton
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li><a class="nav-link" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['baseUrl']->value, ENT_QUOTES, 'UTF-8');?>
/users/index">Users</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21088626835e5afdcec1ec04_19597072', 'content');
?>

            <hr>
            <footer>
                <p>&copy; <?php echo '<?=';?>
 date('Y') <?php echo '?>';?>
 "Laminas: MVC Framework for PHP" - Adam Omelak.</p>
            </footer>
        </div>
    </body>
</html>
<?php }
/* {block 'content'} */
class Block_21088626835e5afdcec1ec04_19597072 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_21088626835e5afdcec1ec04_19597072',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'content'} */
}
