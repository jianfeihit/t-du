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
		<p class="myShop03">03订单支付</p>
		<div class="myShopSure">
			<h5>确认支付方式</h5>
			<div class="sureOrderInfor">
				<ul>
					<li>您提交了<span>1</span>个订单，订单号：16486
					</li>
					<li>该订单包含<em>1</em>件商品，商品总金额<em>99.00</em>元，运费<em>6.00</em>元。 <a oid="16486" href="#" class="blue detail">详情</a>
					</li>
				</ul>
				<p>
					应支付金额<span>=</span>商品总金额<strong>99.00</strong>元<span>+</span>运费<strong>6.00</strong>元<span>-</span>优惠<strong>0.00</strong>元<span>=</span><strong>105.00</strong>元
				</p>
			</div>

			<h6>请选择在线付款方式：</h6>
			<div class="bank">
				<form accept-charset="utf-8" action="/payments/pay" method="post" id="OrderPayForm" target="_blank">
					<div style="display: none;">
						<input type="hidden" value="POST" name="_method">
					</div>
					<input type="hidden" value="16486" name="data[items]">
						<ul>
							<li><lable>
								<input type="radio" bn="支付宝" value="alipay" name="data[bank]"><img src="./themes/default/v2/bank_zfb.gif"></lable></li>
						</ul>
						<!-- <p>选择在线银行支付：</p>
						<ul>
							<li><lable>
								<input type="radio" bn="中国工商银行" value="ICBCB2C" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zggs.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="中国农业银行" value="ABC" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zgny.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="中国银行" value="BOCB2C" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zg.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="中国建设银行" value="CCB" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zgjs.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="交通银行" value="COMM" name="data[bank]"><img width="140" height="32" src="/images/banklogo_jt.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="招商银行" value="CMB" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zs.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="浦东发展银行" value="SPDB" name="data[bank]"><img width="140" height="32" src="/images/banklogo_shpdfz.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="民生银行" value="CMBC" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zgms.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="光大银行" value="CEBBANK" name="data[bank]"><img width="140" height="32" src="/images/banklogo_zggd.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="深圳发展银行" value="SDB" name="data[bank]"><img width="140" height="32" src="/images/banklogo_szfz.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="广东发展银行" value="GDB" name="data[bank]"><img width="140" height="32" src="/images/banklogo_gdfz.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="兴业银行" value="CIB" name="data[bank]"><img width="140" height="32" src="/images/banklogo_xy.gif"></lable></li>
							<li><lable>
								<input type="radio" bn="平安银行" value="SPABANK" name="data[bank]"><img width="140" height="32" src="/images/banklogo_pa.gif"></lable></li>
						</ul> -->
						<p>
							<a href="#" class="butLarge">确定,去付款</a>
						</p>
				</form>
			</div>

		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {

		});
	</script>
	<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>