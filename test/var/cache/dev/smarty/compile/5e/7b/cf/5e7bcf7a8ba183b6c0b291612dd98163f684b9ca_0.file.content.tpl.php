<?php
/* Smarty version 3.1.33, created on 2022-08-30 11:05:16
  from '/var/www/html/admintest/themes/new-theme/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_630dd2cccf5b50_92351356',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e7bcf7a8ba183b6c0b291612dd98163f684b9ca' => 
    array (
      0 => '/var/www/html/admintest/themes/new-theme/template/content.tpl',
      1 => 1600952248,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_630dd2cccf5b50_92351356 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="ajax_confirmation" class="alert alert-success" style="display: none;"></div>


<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
  <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

<?php }
}
}
