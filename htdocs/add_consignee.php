<?php


define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');

if ((DEBUG_MODE & 2) != 2)
{
    $smarty->caching = true;
}
$smarty->display('t_add_consignee.dwt');


?>
