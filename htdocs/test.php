<?php
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');

$smarty->assign('currency_format', $_CFG['currency_format']);
$smarty->assign('integral_scale',  $_CFG['integral_scale']);
$smarty->assign('step',            $_REQUEST['step']);
assign_dynamic('shopping_flow');

$smarty->display('flow.dwt');

?>