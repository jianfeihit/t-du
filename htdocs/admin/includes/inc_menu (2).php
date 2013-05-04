<?php

/**
 * ECSHOP 管理中心菜单数组
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: inc_menu.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$modules['02_cat_and_goods']['01_goods_list']       = 'goods.php?act=list';         // 商品列表
$modules['02_cat_and_goods']['02_goods_add']        = 'goods.php?act=add';          // 添加商品
$modules['02_cat_and_goods']['03_category_list']    = 'category.php?act=list';
$modules['02_cat_and_goods']['06_goods_brand_list'] = 'brand.php?act=list';
$modules['02_cat_and_goods']['08_goods_type']       = 'goods_type.php?act=manage';
$modules['02_cat_and_goods']['11_goods_trash']      = 'goods.php?act=trash';        // 商品回收站
$modules['02_cat_and_goods']['12_batch_pic']        = 'picture_batch.php';
$modules['02_cat_and_goods']['50_virtual_card_list']   = 'goods.php?act=list&extension_code=virtual_card';
$modules['02_cat_and_goods']['51_virtual_card_add']    = 'goods.php?act=add&extension_code=virtual_card';




$modules['04_order']['02_order_list']               = 'order.php?act=list';
$modules['04_order']['03_order_query']              = 'order.php?act=order_query';
$modules['04_order']['05_edit_order_print']         = 'order.php?act=templates';
$modules['04_order']['06_undispose_booking']        = 'goods_booking.php?act=list_all';
//$modules['04_order']['07_repay_application']        = 'repay.php?act=list_all';
$modules['04_order']['08_add_order']                = 'order.php?act=add';
$modules['04_order']['09_delivery_order']           = 'order.php?act=delivery_list';
$modules['04_order']['10_back_order']               = 'order.php?act=back_list';


$modules['06_stats']['flow_stats']                  = 'flow_stats.php?act=view';
$modules['06_stats']['searchengine_stats']          = 'searchengine_stats.php?act=view';
$modules['06_stats']['z_clicks_stats']              = 'adsense.php?act=list';
$modules['06_stats']['report_guest']                = 'guest_stats.php?act=list';
$modules['06_stats']['report_order']                = 'order_stats.php?act=list';
$modules['06_stats']['report_sell']                 = 'sale_general.php?act=list';
$modules['06_stats']['sale_list']                   = 'sale_list.php?act=list';
$modules['06_stats']['sell_stats']                  = 'sale_order.php?act=goods_num';
$modules['06_stats']['report_users']                = 'users_order.php?act=order_num';
$modules['06_stats']['visit_buy_per']               = 'visit_sold.php?act=list';

$modules['07_content']['03_article_list']           = 'article.php?act=list';
$modules['07_content']['02_articlecat_list']        = 'articlecat.php?act=list';
//$modules['07_content']['shop_help']                 = 'shophelp.php?act=list_cat';
//$modules['07_content']['shop_info']                 = 'shopinfo.php?act=list';


$modules['08_members']['03_users_list']             = 'users.php?act=list';
$modules['08_members']['04_users_add']              = 'users.php?act=add';
$modules['08_members']['05_user_rank_list']         = 'user_rank.php?act=list';

$modules['10_priv_admin']['admin_logs']             = 'admin_logs.php?act=list';
$modules['10_priv_admin']['admin_list']             = 'privilege.php?act=list';
$modules['10_priv_admin']['admin_role']             = 'role.php?act=list';

$modules['11_system']['01_shop_config']             = 'shop_config.php?act=list_edit';
$modules['11_system']['flashplay']                  = 'flashplay.php?act=list';
//$modules['11_system']['fckfile_manage']             = 'fckfile_manage.php?act=list';
$modules['11_system']['021_reg_fields']             = 'reg_fields.php?act=list';




$modules['13_backup']['02_db_manage']               = 'database.php?act=backup';


//$modules['14_sms']['02_sms_my_info']                = 'sms.php?act=display_my_info';
//$modules['14_sms']['04_sms_charge']                 = 'sms.php?act=display_charge_ui';
//$modules['14_sms']['05_sms_send_history']           = 'sms.php?act=display_send_history_ui';
//$modules['14_sms']['06_sms_charge_history']         = 'sms.php?act=display_charge_history_ui';

?>
