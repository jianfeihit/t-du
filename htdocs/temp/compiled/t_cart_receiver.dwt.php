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
</head>
<body>
	<?php echo $this->fetch('library/page_header.lbi'); ?>
	<div class="incContent">
		<form accept-charset="utf-8" action="/orders/pay" method="post" id="OrderPayForm">
			<div style="display: none;">
				<input type="hidden" value="POST" name="_method">
			</div>
			<p class="myShop02">02确认订单信息</p>
			<div class="myShopSure">
				<h5>
					<a href="/users/my_delivery_info">管理我的收货人</a>确认收货人
				</h5>
				<ul id="address" class="address">
					<li class="bg" diid="4625"><input type="radio" checked="checked" value="4625" name="data[delivery_info]"> <em>测试</em><em>13800138000</em><em>北京北京东城区大爷接</em> <a href="#" class="modify">[修改这个地址]</a></li>
					<li id="test"><a class="usenew" href="#">使用新地址</a></li>
				</ul>
			</div>
			<div class="myShopSure myOrderSure">
				<h5>确认配送方式</h5>
				<p class="name">
					店铺：<a href="/stores/visit/46">嫣然天使基金会</a> 店主：<a href="/stores/visit/46">嫣-ran</a> <a href="/stores/visit/46">嫣然2013第2期</a>
				</p>
				<table cellspacing="0" cellpadding="0" class="tableBox">
					<tbody>
						<tr>
							<th>商品</th>
							<th>单价</th>
							<th>数量</th>
							<th>小计</th>
						</tr>
						<tr class="hui deepBlue">
							<td>
								<div class="comBox">
									<a href="/stores/buy/1794"><img width="66" height="66" src="http://pic.teeker.com/products/1794_577_front_130424160210_70x70.jpg"></a>
									<h4>
										<a href="/stores/buy/1794">Lets love-儿童笑脸款</a>
									</h4>
									<p>
										<a href="/stores/buy/1794">A01-圆领短袖纯棉T恤-女款麻灰</a>
									</p>
								</div>
							</td>
							<td>99.0元</td>
							<td>
								<div class="number">
									<span>S:1</span>
								</div>
							</td>
							<td>
								<p>
									<span>1*99.0=99</span>元
								</p>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="total">
					共<strong>1</strong>件商品，商品总金额<strong>99</strong>元
				</div>
				<p class="tips">上述商品的生产时间是：2013-05-10 00:00:00，预计配送时间：2013-05-17</p>
				<h6>配送方式</h6>
				<ul class="address">
					<li class="bg"><input type="radio" checked="checked" qnt="1" aid="1042" weight="120" value="mail" name="data[express][1042]"><em>快递</em>北京东城区，运费<span>6.00</span><em>元</em><em class="fontred"></em></li>
				</ul>
				<p class="name">
					<a class="font12 oremarks" href="#">订单备注</a><input type="text" size="50" name="data[remark][1042]" class="hide font12">
				</p>
			</div>
			<div class="myShopBox">
				<div class="right">
					<a href="/orders/view_cart" class="blue">返回购物车</a><a href="/flow.php?step=cart_pay" class="butLarge">提交订单</a>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

		});
	</script>
	<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>