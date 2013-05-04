<html>
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/front.css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/ext.css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/index_item.css" />
<script type="text/javascript" src="/js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.10.2.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/jqzoom_ev/js/jquery-1.6.js"></script>
<script src="/js/jqzoom_ev/js/jquery.jqzoom-core.js" type="text/javascript"></script>
<link rel="stylesheet" href="/js/jqzoom_ev/css/jquery.jqzoom.css" type="text/css">
<title></title>
<style type="text/css">
ul.pthumbs li a.zoomThumbActive {
	border: 1px solid #0caceb;
	display: inline-block;
}
</style>
</head>
<body>
	<div class="layer " id="bypt" style="display: block; width: auto; min-height: 150px; height: auto; margin: 0" scrolltop="0" scrollleft="0">
		<div class="leftDe" style="position: relative; z-index: 1010;">
			<ul class="nav">
				<li tg=".preview" class="current">大图预览</li>
				<li tg=".act_explain">活动介绍</li>
				<li tg=".explain">商品详情</li>
				<li tg=".sizerule">尺码说明</li>
				<li tg=".shipping">退换货说明</li>
			</ul>
			<div class="preview" style="">
				<?php if ($this->_var['pictures']): ?>
				<ul class="pthumbs">
					<?php $_from = $this->_var['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'picture');$this->_foreach['picture'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['picture']['total'] > 0):
    foreach ($_from AS $this->_var['picture']):
        $this->_foreach['picture']['iteration']++;
?>
					<li>
						<?php if (($this->_foreach['picture']['iteration'] - 1) == 0): ?> <a class="zoomThumbActive" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo $this->_var['picture']['thumb_url']; ?>',largeimage: '<?php echo $this->_var['picture']['img_url']; ?>'}"> <img src="<?php if ($this->_var['picture']['thumb_url']): ?><?php echo $this->_var['picture']['thumb_url']; ?><?php else: ?><?php echo $this->_var['picture']['img_url']; ?><?php endif; ?>" width="50" height="50" alt="<?php echo $this->_var['goods']['goods_name']; ?>" />
					</a> <?php else: ?> <a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo $this->_var['picture']['thumb_url']; ?>',largeimage: '<?php echo $this->_var['picture']['img_url']; ?>'}"> <img src="<?php if ($this->_var['picture']['thumb_url']): ?><?php echo $this->_var['picture']['thumb_url']; ?><?php else: ?><?php echo $this->_var['picture']['img_url']; ?><?php endif; ?>" width="50" height="50" alt="<?php echo $this->_var['goods']['goods_name']; ?>" />
					</a> <?php endif; ?>
					</li>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
				<?php endif; ?>
				<p class="psmallimg">
					<a href="<?php echo $this->_var['goods']['original_img']; ?>" class="jqzoom" title="triumph" rel="gal1"> <img id="goodImg" src="<?php echo $this->_var['goods']['goods_img']; ?>" title="triumph" width="319" height="319">
					</a>
				</p>
			</div>
			<div class="act_explain hide" data-tab="true" style="display: none"><?php echo $this->_var['goods']['goods_brief']; ?></div>
			<div class="explain hide" data-tab="true" style="display: none;">
				<?php echo $this->_var['goods']['goods_desc']; ?>
				<dl>
					<dt>品牌：<?php echo $this->_var['goods']['goods_brand']; ?></dt>
				</dl>
				<p>
					洗涤说明：<img src="/themes/default/v2/pic_washing.gif" width="376" height="87">
				</p>
			</div>
			<div class="sizerule hide" data-tab="true" style="display: none;">
				<p>
					<img src="/themes/default/v2/pic_size.png" width="435" height="381">
				</p>
				<!--<p class="blue"><a href="#">更多尺码请参考&gt;&gt;</a></p>-->
			</div>
			<div class="shipping hide" data-tab="true" style="display: none;">
				<ul>
					<li><strong>时效原则</strong>
						<p>自商品签收之时起30日内，T-DU可为您提供退换货服务。</p></li>
					<li><strong>可退换货的情况</strong>
						<p>当您拿到的商品存在以下质量问题时，T-DU可为您提供退换货服务：</p>
						<p>
							<span>1、商品款式错误；</span> <span>2、商品材质错误；</span> <span>3、商品颜色错误；</span> <span>4、商品尺码错误；</span> <span>5、商品存在开线；</span> <span>6、商品存在破损；</span> <span>7、印花图案错误；</span> <span>8、印花等导致商品污染；</span> <span>9、其他质量问题。</span>
						</p></li>
					<li><strong>不可退换货的情况</strong>
						<p>对于以下两类商品，T-DU无法为您提供退换货服务，恳请谅解！</p>
						<p>1、由于下单操作不当造成的错误商品。</p>
						<p>2、清洗、熨烫不当等造成的坏损商品。</p></li>
				</ul>
				<!--  <p>
                        <a href="/help/return_policy">详细的退换货流程&gt;&gt;</a>
                    </p> -->
			</div>
		</div>
		<div class="rightDe" style="position: relative; z-index: 1001;">
			<form action="javascript:addToCart(<?php echo $this->_var['goods']['goods_id']; ?>)" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">
			<h3 class="pname"><?php echo $this->_var['goods']['goods_name']; ?></h3>
			<?php if ($this->_var['cfg']['show_marketprice']): ?>
			<dl>
				<dt class="padTop">
					<strong>T-du原价:</strong>
				</dt>
				<dd class="market">
					<font class="market">&nbsp;<?php echo $this->_var['goods']['market_price']; ?></font>
				</dd>
			</dl>

			<?php endif; ?>
			<dl>
				<dt class="padTop">
					<strong>优惠价格:</strong>
				</dt>
				<dd>
					<!-- <font class="shop" id="ECS_SHOPPRICE"> <?php echo $this->_var['goods']['shop_price_formated']; ?></font> -->
					<span class="yuan"><em class="pprice"><?php echo $this->_var['goods']['shop_price_formated']; ?></em></span>
				</dd>
			</dl>




			<?php if ($this->_var['goods']['is_promote'] && $this->_var['goods']['gmt_end_time']): ?>
			<dl>
				<dt class="padTop">
					<strong>促销价格:</strong>
				</dt>
				<dd>
					<font class="shop">&nbsp;<?php echo $this->_var['goods']['promote_price']; ?></font>
				</dd>
			</dl>


			<?php endif; ?>

			</dl>
			<dl>
				<dt>订购数量：</dt>
				<dd>
					<ul class="number psizes">
						<li><a href="javascript:void(0);"><input name="397611" value="0" type="text"><span class="minus"><img src="/themes/default/v2/click.png"></span><span class="plus"><img src="/themes/default/v2/click.png"></span></a>S&nbsp;:&nbsp;</li>
						<li><a href="javascript:void(0);"><input name="397612" value="0" type="text"><span class="minus"><img src="/themes/default/v2/click.png"></span><span class="plus"><img src="/themes/default/v2/click.png"></span></a>M&nbsp;:&nbsp;</li>
						<li><a href="javascript:void(0);"><input name="397613" value="0" type="text"><span class="minus"><img src="/themes/default/v2/click.png"></span><span class="plus"><img src="/themes/default/v2/click.png"></span></a>L&nbsp;:&nbsp;</li>
						<li><a href="javascript:void(0);"><input name="397614" value="0" type="text"><span class="minus"><img src="/themes/default/v2/click.png"></span><span class="plus"><img src="/themes/default/v2/click.png"></span></a>XL&nbsp;:&nbsp;</li>
					</ul>

				</dd>
			</dl>

			<p class="addShop">
				<a class="but" onclick="cartOpen('flow.php?step=cart',<?php echo $this->_var['goods']['goods_id']; ?>)" href="#">加入购物车</a>
			</p>
			<div class="fav">
				<a href="javascript:viod(0);" class="like" data-id="<?php echo $this->_var['goods']['goods_id']; ?>">喜欢（<span><?php echo $this->_var['goods']['like_num']; ?></span>）
				</a>
				<div class="bdshare_wrapper">
					
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
						<span class="bds_more">分享到：</span> <a class="bds_tsina"></a> <a class="bds_renren"></a>
					</div>
					
				</div>


			</div>
		</form>
		</div>
	</div>

	<script type="text/javascript">
            $(document).ready(function () {


                // $('#myTab a').click(function (e) {
                //   $(this).tab('show');
                // })
                
                
                 // 商品放大镜功能             

                $('.jqzoom').jqzoom({
                    zoomType: 'standard',
                    lens:true,
                    preloadImages: false,
                    alwaysOn:false
                });



                //商品介绍tab
                $('.nav li').click(function(e){

                        if($(this).hasClass('current')){
                            return;
                        }

                        var prev = $('.current');
                        prev.removeClass('current');
                        $(prev.attr('tg')).hide();

                        $(this).addClass('current');
                        $($(this).attr('tg')).show();
                    
                });


                 //数量增减
                
                $('.psizes span').click(function(e){                 
                  var input = $(this).siblings("input");
                  var val = input.val();
                  if($(this).hasClass('minus')){
                    val--;
                  }else if($(this).hasClass('plus')){
                    val++;
                  }
                  val = Math.max(0, val);
                  input.val(val);
                });


                // 喜欢按钮
             
              $('.like').each(function(index,item){                
                $(item).click(function(e){
                    var goods_id = $(this).attr('data-id');
                    // collect($(item).attr('data-id'), function(){
                    //     var itemSpan = $('span',this);                    
                    //     var num = parseInt(itemSpan.html());                    
                    //     itemSpan.html(++num);
                    // });
                                        
                    $.ajax('user.php?act=collect&id=' + goods_id, {
                        success:function(res){
                            
                            var res = eval('(' + res +')');

                            alert(res.message);
                            
                            if(res.error){
                                return;
                            }
                            var itemSpan = $('span',item);
                            console.log(itemSpan);
                            var num = parseInt(itemSpan.html());
                            itemSpan.html(++num);
                        },

                    });
                });
              });
            });
        </script>
	<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=4546967"></script>
	<script type="text/javascript" id="bdshell_js"></script>
	<script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        
     // add by jianfeihit 2013.05.04 start 
        function addTimeStamp(url) {
        	var timstamp = (new Date()).valueOf();
            if (url.indexOf("?") >= 0) {
            	url = url + "&t=" + timstamp;
            } else {
            	url = url + "?t=" + timstamp;
            };
            return url;
        };
        function cartOpen(url, goodsId) {
            var goods = new Object();
            var spec_arr = new Array();
            var fittings_arr = new Array();
            var number = 1;
            var formBuy = document.forms['ECS_FORMBUY'];
            var quick = 0;
            // 检查是否有商品规格 
            if (formBuy){
               spec_arr = getSelectedAttributes(formBuy);
               if (formBuy.elements['number']){
            	   number = formBuy.elements['number'].value;
               }
               quick = 1;
             }
             goods.quick = quick;
             goods.spec = spec_arr;
             goods.goods_id = goodsId;
             goods.number = number;
             goods.parent = (typeof (parentId) == "undefined") ? 0 : parseInt(parentId);
             var datas = {
            	"goods": JSON.stringify(goods)
             };
             $.ajax({
            	 type: "POST",
                 url: "flow.php?step=add_to_cart",
                 data: datas,
                 datatype: "json",
                 success: function (res) {
                     window.location.href = addTimeStamp(url)
                 }
             });
        }
    // add by jianfeihit 2013.05.04 end
	</script>
</body>
</html>