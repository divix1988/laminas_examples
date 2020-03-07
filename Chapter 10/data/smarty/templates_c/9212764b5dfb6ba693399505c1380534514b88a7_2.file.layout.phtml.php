<?php
/* Smarty version 3.1.34-dev-7, created on 2020-03-01 01:12:46
  from 'E:\RZECZY_ADAMA\_XAMPP\xampp-7.4\htdocs\laminas_app\module\Application\view\layout\layout.phtml' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e5afdfe199712_45303275',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9212764b5dfb6ba693399505c1380534514b88a7' => 
    array (
      0 => 'E:\\RZECZY_ADAMA\\_XAMPP\\xampp-7.4\\htdocs\\laminas_app\\module\\Application\\view\\layout\\layout.phtml',
      1 => 1582751815,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e5afdfe199712_45303275 (Smarty_Internal_Template $_smarty_tpl) {
echo '<?=';?>
 $this->doctype() <?php echo '?>';?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php echo '<?=';?>
 $this->headTitle('Laminas MVC Skeleton')->setSeparator(' - ')->setAutoEscape(false) <?php echo '?>';?>


        <?php echo '<?=';?>
 $this->headMeta()
            ->appendName('viewport', 'width=device-width, initial-scale=1.0')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge')
        <?php echo '?>';?>


        <!-- Le styles -->
        <?php echo '<?=';?>
 $this->headLink(['rel' => 'shortcut icon', 'type' => 'image/vnd.microsoft.icon', 'href' => $this->basePath() . '/img/favicon.ico'])
            ->prependStylesheet($this->basePath('css/style.css'))
            ->prependStylesheet($this->basePath('css/bootstrap.min.css'))
        <?php echo '?>';?>


        <!-- Scripts -->
        <?php echo '<?=';?>
 $this->inlineScript()
            ->prependFile($this->basePath('js/bootstrap.min.js'))
            ->prependFile($this->basePath('js/jquery-3.4.1.min.js'))
        <?php echo '?>';?>

    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo '<?=';?>
 $this->url('home') <?php echo '?>';?>
">
                        <img src="<?php echo '<?=';?>
 $this->basePath('img/laminas-logo.svg') <?php echo '?>';?>
" height="28" alt="Laminas MVC Skeleton"/>&nbsp;Laminas MVC Skeleton
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo '<?=';?>
 $this->url('home') <?php echo '?>';?>
">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li><a class="nav-link" href="<?php echo '<?=';?>
 $this->url('users') <?php echo '?>';?>
">Users</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <?php echo '<?=';?>
 $this->content <?php echo '?>';?>

            <hr>
            <footer>
                <p>&copy; <?php echo '<?=';?>
 date('Y') <?php echo '?>';?>
 "Laminas: Build Enterprise Websites" - Adam Omelak.</p>
            </footer>
        </div>
        <?php echo '<?=';?>
 $this->inlineScript() <?php echo '?>';?>

    </body>
</html>
<?php }
}
