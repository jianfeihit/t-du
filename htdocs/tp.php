<?php

/**
 * ECSHOP 商品详情
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
if (empty($_SESSION['user_id']))
{
    ecs_header('Location:./user.php');
}

if($_COOKIE['tpp']!="1")
{
setcookie("tpp", "1",time()+86400);
$db->query('UPDATE ' . $ecs->table('goods') . " SET toupiao = toupiao + 1 WHERE goods_id = '$_REQUEST[id]'");
header("Location: /category.php?id=".$_REQUEST[cid]); 

}
else

{
	echo "<script>alert('您今天已投过票!');self.location='/category.php?id=1';</script>";
	
}








?>