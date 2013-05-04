<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>T-DU-你的T恤云工厂！上传创意，自定时间内售出超过10件产品，服务大品牌的工厂即刻为你生产！</title>
<link href="http://www.teeker.com/favicon.ico" type="image/x-icon" rel="icon" />
<link href="http://www.teeker.com/favicon.ico" type="image/x-icon" rel="shortcut icon" />
<meta name="keywords" content="T-DU,云工厂,文化衫,设计师,团购,创意,印染,印花,征订,定制,品牌,平台,T恤衫,Polo衫,圆领衫,帽衫,卫衣,毕业衫,院衫,会衫,班服,校服,版衫,站衫,队服" />
<meta name="description" content="t-du.com是一个服务圈子和圈子文化，为圈子提供文化衫征订、定制的电子商务平台，致力于帮助您更美、更准、更快地将自己的圈子文化符号和内涵穿到身上，穿到学校，穿到公司，穿回家。百万件品牌文化衫库存，全球顶级印染设备，充分满足您的多款式、多档次、多颜色定制需求！" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/front.css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/ext.css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/index_item.css" />
<link rel="stylesheet" type="text/css" href="js/fancy/jquery.fancybox.css" />
<script type="text/javascript" src="js/fancy/jquery.fancybox.js"></script>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="./themes/default/js/order.js"></script>
<script type="text/javascript" src="./themes/default/js/cart.js"></script>
</head>
<body>
	<?php echo $this->fetch('library/page_header.lbi'); ?>
	<div class="incContent">
		<p class="myShop01">01我的购物车</p>
		<form id="OrderConfirmConsigneeForm" method="post" action="/orders/confirm_consignee" accept-charset="utf-8">
			<div style="display: none;">
				<input type="hidden" name="_method" value="POST" />
			</div>
			<table cellpadding="0" cellspacing="0" class="myShopTable">
				<tr>
					<th colspan="2" class="textLeft"><input name="all" type="checkbox" checked="checked" /> 全选 <span class="marLeft">商品</span></th>
					<th>单价</th>
					<th>数量</th>
					<th>小计</th>
					<th>&nbsp;</th>
				</tr>
				<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
				<tr class="hui deepBlue" rec_id="<?php echo $this->_var['goods']['rec_id']; ?>">
					<td colspan="2">
						<div class="comBox">
							<input name="p46_76102" type="checkbox" checked="checked" value="76102" /> <a href="/stores/buy/1794"> <img src="<?php echo $this->_var['goods']['goods_thumb']; ?>" width="66" height="66" />
							</a>
							<h6>
								<a href="/stores/buy/1794"><?php echo $this->_var['goods']['goods_name']; ?></a>
							</h6>
							<!-- <p>
								<a href="/stores/buy/1794">A01-圆领短袖纯棉T恤-女款麻灰</a>
							</p> -->
						</div>
					</td>
					<td class="price"><span><?php echo $this->_var['goods']['goods_price']; ?></span></td>
					<td>
						<div class="number">
							S： 
							<a href="#">
							<input name="" type="text" value="<?php echo $this->_var['goods']['goods_number']; ?>" piid="397611" /> 
							<span class="minus"><img src="./themes/default/v2/click.png" /></span> 
							<span class="plus"><img src="./themes/default/v2/click.png" /></span>
							</a>
						</div>
					</td>
					<td class="toprice"><span>1*99.0=99</span> 元</td>
					<td>
						<p>
							<a class="hui del" href="#" piid="397611">删除</a>
						</p>
					</td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
			<div class="myShopBox">
				<div class="right">
					共 <strong id="total_qnt">1</strong> 件商品，商品总金额 <strong id="total_price">99</strong>元 <a class="butLarge commits" href="flow.php?step=cart_receiver">去结算</a>
				</div>
				<input name="all" type="checkbox" checked="checked" /> 全选
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

		});
		$(document).ready(function() {
		    var vcart = new ViewCart();
		    vcart.init();
		    vcart.set_login_check(function(callback) {
		      if (LoginDialog.check()){
		        callback();
		      } else {
		        ld.set_login_callback(callback);
		        ld.open();
		      }
		    });
		    if (Cart != undefined) {
		      Cart.update_callback = function() {
		        location.reload();
		      };
		    }
		  });
	</script>
	<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>