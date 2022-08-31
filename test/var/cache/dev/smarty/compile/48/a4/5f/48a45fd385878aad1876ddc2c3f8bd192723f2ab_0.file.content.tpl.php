<?php
/* Smarty version 3.1.33, created on 2022-08-30 11:02:06
  from '/var/www/html/admintest/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_630dd20ecc94f5_54519927',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48a45fd385878aad1876ddc2c3f8bd192723f2ab' => 
    array (
      0 => '/var/www/html/admintest/themes/default/template/content.tpl',
      1 => 1600952248,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_630dd20ecc94f5_54519927 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div>
<?php }
}
