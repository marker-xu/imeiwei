<?php /* Smarty version Smarty-3.0.7, created on 2012-09-18 23:42:24
         compiled from "string:" */ ?>
<?php /*%%SmartyHeaderCode:6010996945058966008a3c8-05549546%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e66afa7c0e4421b4e6611806a994408e58d7fa41' => 
    array (
      0 => 'string:',
      1 => 0,
      2 => 'string',
    ),
    '68df07346e5399c1245c56e2c8fcc13a6c4ad84e' => 
    array (
      0 => '/home/www/snda-php/admin/application/views/common/base.tpl',
      1 => 1347951335,
      2 => 'file',
    ),
    '1340f19d75e731218e2095d43409c466ba164559' => 
    array (
      0 => '/home/www/snda-php/admin/application/views/common/header.tpl',
      1 => 1347945576,
      2 => 'file',
    ),
    'cbc2466b72548542ead086c846142002cb7e1c30' => 
    array (
      0 => '/home/www/snda-php/admin/application/views/common/footer.tpl',
      1 => 1347945597,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6010996945058966008a3c8-05549546',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_capitalize')) include '/home/www/php5/lib/php-libs/jkit/modules/jkit/vendor/smarty3/plugins/modifier.capitalize.php';
?><!doctype html>
<?php  $_config = new Smarty_Internal_Config('site.conf', $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<html><head><meta charset="utf-8"><title>欢迎来到后台</title><link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/><link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getConfigVariable('resUrl');?>
/css/common.css?v=<?php echo $_smarty_tpl->getConfigVariable('v');?>
">
<script type="text/javascript" src="<?php echo $_smarty_tpl->getConfigVariable('resUrl');?>
/js/third/jquery-1.7.2.min.js"></script>
</head>
<body>
    <div id="doc1">
        
        <?php echo $_smarty_tpl->getConfigVariable('resUrl');?>
<?php echo $_smarty_tpl->getConfigVariable('apiUrl');?>

            <?php $_template = new Smarty_Internal_Template("common/header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
$_template->properties['nocache_hash']  = '6010996945058966008a3c8-05549546';
$_tpl_stack[] = $_smarty_tpl; $_smarty_tpl = $_template;?>
<?php /* Smarty version Smarty-3.0.7, created on 2012-09-18 23:42:24
         compiled from "/home/www/snda-php/admin/application/views/common/header.tpl" */ ?>
<?php $_smarty_tpl->updateParentVariables(0);?>
<?php /*  End of included template "/home/www/snda-php/admin/application/views/common/header.tpl" */ ?>
<?php $_smarty_tpl = array_pop($_tpl_stack);?><?php unset($_template);?>
        
        
<div id="bd">
<h1>This is a sample view.</h1>
<div>Hello <?php echo smarty_modifier_capitalize($_smarty_tpl->getVariable('person')->value);?>
!</div>
</div>

        
            <?php $_template = new Smarty_Internal_Template("common/footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null);
$_template->properties['nocache_hash']  = '6010996945058966008a3c8-05549546';
$_tpl_stack[] = $_smarty_tpl; $_smarty_tpl = $_template;?>
<?php /* Smarty version Smarty-3.0.7, created on 2012-09-18 23:42:24
         compiled from "/home/www/snda-php/admin/application/views/common/footer.tpl" */ ?>
<?php $_smarty_tpl->updateParentVariables(0);?>
<?php /*  End of included template "/home/www/snda-php/admin/application/views/common/footer.tpl" */ ?>
<?php $_smarty_tpl = array_pop($_tpl_stack);?><?php unset($_template);?>
        
    </div>
    
    
    
        


    
    
        
</body>
</html>