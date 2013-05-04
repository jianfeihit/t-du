<?php


define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . '/' . ADMIN_PATH . '/includes/lib_goods.php');
include_once(ROOT_PATH . '/includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);




if ($_REQUEST['act']='add')
{
   
    $is_insert =  'insert';
	
       if (empty($_POST['goods_sn']))
    {
        $max_id     = $is_insert ? $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$ecs->table('goods')) : $_REQUEST['goods_id'];
        $goods_sn   = generate_goods_sn($max_id);
    }
    else
    {
        $goods_sn   = $_POST['goods_sn'];
    }
	
	
       $shop_price = !empty($_POST['shop_price']) ? $_POST['shop_price'] : 0;
    $market_price = !empty($_POST['market_price']) ? $_POST['market_price'] : 0;
    $promote_price = !empty($_POST['promote_price']) ? floatval($_POST['promote_price'] ) : 0;
    $is_promote = empty($promote_price) ? 0 : 1;
    $promote_start_date = ($is_promote && !empty($_POST['promote_start_date'])) ? local_strtotime($_POST['promote_start_date']) : 0;
    $promote_end_date = ($is_promote && !empty($_POST['promote_end_date'])) ? local_strtotime($_POST['promote_end_date']) : 0;
    $goods_weight = !empty($_POST['goods_weight']) ? $_POST['goods_weight'] * $_POST['weight_unit'] : 0;
    $is_best = isset($_POST['is_best']) ? 1 : 0;
    $is_new = isset($_POST['is_new']) ? 1 : 0;
    $is_hot = isset($_POST['is_hot']) ? 1 : 0;
    $is_on_sale = isset($_POST['is_on_sale']) ? 1 : 0;
    $is_alone_sale = isset($_POST['is_alone_sale']) ? 1 : 0;
    $is_shipping = isset($_POST['is_shipping']) ? 1 : 0;
    $goods_number = isset($_POST['goods_number']) ? $_POST['goods_number'] : 0;
    $warn_number = isset($_POST['warn_number']) ? $_POST['warn_number'] : 0;
    $goods_type = isset($_POST['goods_type']) ? $_POST['goods_type'] : 0;
    $give_integral = '-1';
    $rank_integral = isset($_POST['rank_integral']) ? intval($_POST['rank_integral']) : '-1';
    $suppliers_id = isset($_POST['suppliers_id']) ? intval($_POST['suppliers_id']) : '0';

    $goods_name_style = "";

    $catgory_id = empty($_POST['cat_id']) ? '' : intval($_POST['cat_id']);
    $brand_id = empty($_POST['brand_id']) ? '' : intval($_POST['brand_id']);

    $goods_thumb = "";
   $original_img = "";
   $keywords  = "";
   $goods_brief  = "";
	$seller_note   = "";
	
	$_POST['goods_id']=0;
	
	
//
//	 $goods_img        = 'C:\phpnow\htdocs\tu\1.jpg';
//     
//
//         
//
//                // 加水印
//            
//                    if ($image->add_watermark($goods_img,'',"C:\phpnow\htdocs\images\watermark.jpg", 1, 100) === false)
//                    {
//					$aa=$image->error_msg();
//                    }
//                    /* 添加判断是否自动生成相册图片 */
                   
             
         




	
               $sql = "INSERT INTO " . $ecs->table('goods') . " (goods_name, goods_name_style, goods_sn, is_delete,  " .
                    "cat_id, brand_id, shop_price, market_price, is_promote, promote_price, " .
                    "promote_start_date, promote_end_date, goods_img, goods_thumb, original_img, keywords, goods_brief, " .
                    "seller_note, goods_weight, goods_number, warn_number, integral, give_integral, is_best, is_new, is_hot, " .
                    "is_on_sale, is_alone_sale, is_shipping, goods_desc, add_time, last_update, goods_type, rank_integral, suppliers_id)" .
                "VALUES ('$_POST[goods_name]', '$goods_name_style', '$goods_sn', '1','1', " .
                    "'$brand_id', '$shop_price', '$market_price', '$is_promote','$promote_price', ".
                    "'$promote_start_date', '$promote_end_date', '$goods_img', '$goods_thumb', '$original_img', ".
                    "'', '', '', '$goods_weight', '$goods_number',".
                    " '$warn_number', '', '$give_integral', '$is_best', '$is_new', '$is_hot', '$is_on_sale', '$is_alone_sale', $is_shipping, ".
                    " '$_POST[goods_desc]', '" . gmtime() . "', '". gmtime() ."', '$goods_type', '$rank_integral', '$suppliers_id')";

    $GLOBALS['db']->query($sql);
	
	
	 
	   	   show_message('提交成功，请等待管理员审核', '', 'faqi.php');

	     $smarty->display('faqi1.dwt');

	 

}


?>