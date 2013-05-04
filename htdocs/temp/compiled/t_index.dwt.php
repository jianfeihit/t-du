<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
<meta name="Generator" content="ECSHOP v2.7.3" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            T-DU-你的T恤云工厂！上传创意，自定时间内售出超过10件产品，服务大品牌的工厂即刻为你生产！
        </title>
        <link href="http://www.teeker.com/favicon.ico" type="image/x-icon" rel="icon">
        <link href="http://www.teeker.com/favicon.ico" type="image/x-icon" rel="shortcut icon">
        <meta name="keywords" content="T-DU,云工厂,文化衫,设计师,团购,创意,印染,印花,征订,定制,品牌,平台,T恤衫,Polo衫,圆领衫,帽衫,卫衣,毕业衫,院衫,会衫,班服,校服,版衫,站衫,队服">
        <meta name="description" content="t-du.com是一个服务圈子和圈子文化，为圈子提供文化衫征订、定制的电子商务平台，致力于帮助您更美、更准、更快地将自己的圈子文化符号和内涵穿到身上，穿到学校，穿到公司，穿回家。百万件品牌文化衫库存，全球顶级印染设备，充分满足您的多款式、多档次、多颜色定制需求！">
       <!-- <script type="text/javascript" charset="utf-8" async="" src="./teeker_index_files/lxb.js"></script>-->
        
</script>
        <link rel="stylesheet" type="text/css" href="./themes/default/css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="./themes/default/css/front.css">
        <link rel="stylesheet" type="text/css" href="./themes/default/css/ext.css">
        <link rel="stylesheet" type="text/css" href="./themes/default/css/index_item.css">

        
        <?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.9.0.min.js,cart.js,jquery-ui-1.10.2.js')); ?>  

      
      <link rel="stylesheet" type="text/css" href="js/fancy/jquery.fancybox.css">
      <script type="text/javascript" src="js/fancy/jquery.fancybox.js"></script>


    </head>
    <body>
      <?php echo $this->fetch('library/page_header.lbi'); ?>
       
    
        <div class="homeBanner" >
            <div class="window" style="width: 1261px;height: 200px">
                <ul class="windowLine">
                    <li class="continusBox box1" slide_id="0" style="width: 1261px;">
                        <div class="superiority" style="right: 120.5px;">
                            <h4>
                                上传创意，自定时间内售出≥10件产品
                            </h4>
                            <p>
                                服务大品牌的工厂即刻为你生产！
                            </p>
                        </div>
                    </li>
                    <li class="continusBox box2" slide_id="1" style="width: 1261px;">
                        <div class="superiority" style="right: 120.5px;">
                            <h3>
                                零库存，零投入，零风险
                            </h3>
                            <p>
                                只要上传图案, 就能免费开家TEEKER店。
                            </p>
                        </div>
                    </li>
                    <li class="continusBox box3" slide_id="2" style="width: 1261px;">
                        <div class="superiority moveDown" style="left: 670.5px;">
                            <h4>
                                上传一个创意，却可拥有N款色产品组合
                            </h4>
                            <p>
                                群体穿着统一，颜色款式穿出个性！
                            </p>
                        </div>
                    </li>
                    <li class="continusBox box4" slide_id="3" style="width: 1261px;">
                        <div class="superiority" style="right: 120.5px;">
                            <h4>
                                Web, Discuz, 开放平台API, App SDK
                            </h4>
                            <p>
                                全平台开放系统，等你来！
                            </p>
                        </div>
                    </li>
                </ul>
                <ul class="iconPage" style="right: 150.5px;">
                    <li class="current">
                        <a href="http://www.teeker.com/#" slide_id="0">第一张</a>
                    </li>
                    <li>
                        <a href="http://www.teeker.com/#" slide_id="1">第二张</a>
                    </li>
                    <li>
                        <a href="http://www.teeker.com/#" slide_id="2">第三张</a>
                    </li>
                    <li>
                        <a href="http://www.teeker.com/#" slide_id="3">第四张</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="homeContent">
            <div class="hotTitle">
                <h5>
                    热销文化衫推荐
                </h5>
               <!--  <ul>
                    <li>
                        <a class="current" id="ShowHotest" href="http://www.teeker.com/#">最热</a>
                    </li>
                    <li>
                        <a href="http://www.teeker.com/#" id="ShowLatest">最新</a>
                    </li>
                </ul> -->
            </div>
            <div id="content" class="normal-deal-list cf">

                 <?php $_from = $this->_var['best_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['goods']['iteration']++;
?>

                <?php if (($this->_foreach['goods']['iteration'] - 1) % 3 == 2): ?>

                <div class="item right">

                <?php else: ?>

                <div class="item">

                <?php endif; ?>


                    <div class="cover">
                        <a  href="<?php echo $this->_var['goods']['url']; ?>" data-fancybox-type="iframe" data-type="detail"><img width="306" height="189" alt="<?php echo $this->_var['goods']['name']; ?>" src="<?php echo $this->_var['goods']['thumb']; ?>"  ></a>
                    </div>
                    <h3>
                        <a target="_blank" href="<?php echo $this->_var['goods']['url']; ?>" title="<?php echo $this->_var['goods']['name']; ?>" data-fancybox-type="iframe" data-type="detail"><span class="xtitle"><?php echo $this->_var['goods']['name']; ?></span> <span class="short-title"></span></a>
                    </h3>
                    <p class="detail">
                        <a rel="nofollow" class="buy" hidefocus="true" target="_blank" href="<?php echo $this->_var['goods']['url']; ?>" data-fancybox-type="iframe" data-type="detail">去看看</a> <em class="price num"><?php echo $this->_var['goods']['shop_price']; ?></em> <!-- <span class="bypast">门店价 <span class="num"><span>¥</span>120</span></span> -->
                    </p>
                    <div class="total">
                        <a href="javascript:viod(0);" class="like" data-id="<?php echo $this->_var['goods']['goods_id']; ?>">喜欢（<span><?php echo $this->_var['goods']['like_num']; ?></span>）</a>
                        <div class="share">
                          
                          <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
                            <span class="bds_more">分享到：</span>                        
                            <a class="bds_tsina"></a>                        
                            <a class="bds_renren"></a>                        
                          </div>
                          
                        </div>

                        <strong class="num"><?php echo $this->_var['goods']['purchase_num']; ?></strong>人已购买
                    </div>
                   
                   
                </div>


                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                
                
                
               
               
               
               




               
            </div>
            
        </div><script type="text/javascript">
    $(document).ready(function() {
              // $(".hotPicList li").hover(function(){
              //   $(this).addClass('hover');
              // }, function(){
              //   $(this).removeClass('hover');
              // })
              // $("#ShowHotest").click(function(e){
              //   e.preventDefault();
              //   $("#ShowHotest").addClass('current');
              //   $("#ShowLatest").removeClass('current');
              //   $(".latestPanel").hide();
              //   $(".hotestPanel").show();
              // });
              // $("#ShowLatest").click(function(e){
              //   e.preventDefault();
              //   $("#ShowHotest").removeClass('current');
              //   $("#ShowLatest").addClass('current');
              //   $(".hotestPanel").hide();
              //   $(".latestPanel").show();
              // });
              var timeout = 10000;
              // $("<img src='/v2/home_banner1.jpg'>");
              // $("<img src='/v2/home_banner2.jpg'>");
              // $("<img src='/v2/home_banner3.jpg'>");

              var w = $(".homeBanner").width();
              w = (w > 1020 ? w : 1020);
              $(".window").width(w);
              $(".continusBox").width(w);
              $(".box1 .superiority").css('right', ((w - 1020) / 2) + "px");
              $(".box2 .superiority").css('right', ((w - 1020) / 2) + "px");
              $(".box3 .superiority").css('left', ((w - 1020) / 2 + 550) + "px");
              $(".box4 .superiority").css('right', ((w - 1020) / 2) + "px");
              $(".iconPage").css("right", ((w - 1020) / 2 + 30) + "px");

              var bannerQnt = $(".windowLine li").length;
              $(".iconPage > li > a").click(function(e){
                e.preventDefault();
                var seq = parseInt($(this).attr('slide_id'));
                // console.log( 'click',seq);
                scrollBannerTo(seq);
              });

              var bannerSeq = 0;
              var slidingCtrl = setTimeout(slideBanner, timeout);

              // console.log(slidingCtrl);


              function slideBanner(from, to)
              {
                // console.log('slideBanner',from,to);
                if (from == undefined) {
                  from = bannerSeq; to = (bannerSeq + 1) % bannerQnt;
                }
                var ml = '-' + (to* w).toString();
                ml += 'px';

                // clone the current li, and change text
                if (from == (bannerQnt - 1) && to == 0) {
                  $(".windowLine").css({'margin-left':ml});
                  updateBackground(to, bannerQnt);
                  bannerSeq = to;
                }
                else {
                  $(".windowLine").animate({'margin-left':ml}, 500, 'swing', function(){
                    updateBackground(to, bannerQnt);
                    bannerSeq = to;
                  });
                }
                 slidingCtrl = setTimeout(slideBanner, timeout);
              }

              function updateBackground(to, qnt) {
                $(".iconPage > li").removeClass('current');
                $(".iconPage > li:eq(" + ((to % qnt))+ ")").addClass('current');
                // $("#homeLogo > p").hide();
                // $("#homeLogo > p:eq(" + ((to % qnt))+ ")").show();
                return to;
              }



              function scrollBannerTo(seq)
              {
                // console.log('scrollBannerTo',seq);
                clearTimeout(slidingCtrl);
                slideBanner(bannerSeq, seq);
                slidingCtrl = setTimeout(slideBanner, timeout);
              }
              
              $(window).blur(function(){
                // console.log('blur',slidingCtrl);
                clearTimeout(slidingCtrl);
              });

              $(window).focus(function(){
                // console.log('focus',slidingCtrl);
                // clearInterval(slidingCtrl);
                slidingCtrl = setTimeout(slideBanner, timeout);
              });

              
              


              // function getCaseImages() {
              //   var caseImages = new Array();
              //   caseImages[0] = {d:"/images/aboutus/icons/yrstar.png",
              //     l:"/images/aboutus/icons/yrstar_l.png"
              //   };
              //   caseImages[1] = {d:"/images/aboutus/icons/shuimu.png",
              //     l:"/images/aboutus/icons/shuimu_l.png"
              //   };
              //   caseImages[2] = {d:"/images/aboutus/icons/she.png",
              //     l:"/images/aboutus/icons/she_l.png"
              //   };
              //   caseImages[3] = {d:"/images/aboutus/icons/xiaoyu.png",
              //     l:"/images/aboutus/icons/xiaoyu_l.png"
              //   };
              //   caseImages[4] = {d:"/images/aboutus/icons/shafake.png",
              //     l:"/images/aboutus/icons/shafake_l.png"
              //   };
              //   caseImages[5] = {d:"/images/aboutus/icons/hejiong.png",
              //     l:"/images/aboutus/icons/hejiong_l.png"
              //   };
              //   return caseImages;
              // }

              // function toggleCaseImage(i, t, self) {
              //   var caseImages = getCaseImages();
              //   if (t == 'd')
              //     $(self).attr('src', caseImages[i].d);
              //   else
              //     $(self).attr('src', caseImages[i].l);
              // }

              // $(".api_case").hover(function(e){
              //   toggleCaseImage($(this).attr('case_id'), 'd', this);
              // }, function(){
              //   toggleCaseImage($(this).attr('case_id'), 'l', this);
              // });
              // var caseImages = getCaseImages();
              // for (var i = 0; i < caseImages.length; i++) {
              //   $("<img src='" + caseImages[i].d + "' />");
              // }


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


            // 详情页弹框逻辑
            $("a[data-type=detail]").fancybox({
              maxWidth  : 1070,
              maxHeight : 800,
              fitToView : false,
              width   : '90%',
              height    : '80%',
              autoSize  : false,
              closeClick  : false,
              openEffect  : 'none',
              closeEffect : 'none'
            });

           


            });
        </script>

        

        <?php echo $this->fetch('library/page_footer.lbi'); ?>
       




<!--
<script type="text/javascript" src="./teeker_index_files/cart.js">
</script>
<script type="text/javascript" src="./teeker_index_files/jquery-ui.js">
</script>
-->
<script type="text/javascript">
// $(document).ready(function() {
//         Cart.init("http://pic.teeker.com/");
//         ld = new LoginDialog($(".logindig"), $(".plslogin"));
//         if (typeof __login_callback__ != 'undefined' && __login_callback__ != null) {
//         ld.callback = __login_callback__;
//         }
//         ld.init();
//         });
        </script>
      
        <div style="display: none; z-index: 1000; outline: 0px;" class="ui-dialog ui-widget ui-widget-content ui-corner-all dialogc" tabindex="-1" role="dialog" aria-labelledby="ui-dialog-title-1">
            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">
                <span class="ui-dialog-title" id="ui-dialog-title-1">&nbsp;</span><a href="http://www.teeker.com/#" class="ui-dialog-titlebar-close ui-corner-all" role="button"><span class="ui-icon ui-icon-closethick">close</span></a>
            </div>
            <div class="layer layerSize2 logindig hide ui-dialog-content ui-widget-content" style="display: block;">
                <div class="loginBox clearfix">
                    <div class="left">
                        <ul class="clearfix tabs">
                            <li>
                                <a href="http://www.teeker.com/mylogin" class="current">登录</a>
                            </li>
                            <li>
                                <a href="http://www.teeker.com/myregister">注册</a>
                            </li>
                        </ul>
                        <dl class="clearfix mylogin" style="display: block;">
                            <dt>
                                帐号：
                            </dt>
                            <dd>
                                <input class="userSytle" name="user" type="text" value="用户名 或 邮箱" autocomplete="off">
                            </dd>
                            <dt>
                                密码：
                            </dt>
                            <dd>
                                <input class="userSytle" name="pwd" type="password" autocomplete="off">
                            </dd>
                            <dt class="hide">
                                验证码：
                            </dt>
                            <dd class="hide">
                                <input class="yzmSytle" name="verify_code" type="text" value="验证码" autocomplete="off"><img src="./teeker_index_files/verify_image" width="129" height="46"><a class="blue" href="http://www.teeker.com/#" id="newverify">看不清？换一张</a>
                            </dd>
                            <dt>
                                &nbsp;
                            </dt>
                            <dd class="marTop18">
                                <input name="auto_login" type="checkbox" value="1">下次自动登录
                            </dd>
                            <dt>
                                &nbsp;
                            </dt>
                            <dd>
                                <a class="butLarge loginb" href="http://www.teeker.com/#">登录</a><a href="http://www.teeker.com/users/retrieve_password/getcode/" id="forgotpwd">忘记密码，找回？</a>
                            </dd>
                        </dl>
                        <dl class="clearfix myregister" style="display: none;">
                            <dt>
                                邮箱：
                            </dt>
                            <dd>
                                <input class="userSytle" name="email" type="text" autocomplete="off">
                            </dd>
                            <dt>
                                用户名：
                            </dt>
                            <dd>
                                <input class="userSytle" name="username" type="text" value="2-30个字符，支持中文" autocomplete="off">
                            </dd>
                            <dt>
                                密码：
                            </dt>
                            <dd>
                                <input class="userSytle" name="pwd" type="password" value="" autocomplete="off">
                            </dd>
                            <dt>
                                确认密码：
                            </dt>
                            <dd>
                                <input class="userSytle" name="repwd" type="password" autocomplete="off">
                            </dd>
                            <dt class="hide">
                                验证码：
                            </dt>
                            <dd class="hide">
                                <input class="yzmSytle" name="verify_code" type="text" autocomplete="off"><img src="./teeker_index_files/verify_image" width="129" height="46"><a class="blue" href="http://www.teeker.com/#" id="newverify2">看不清？换一张</a>
                            </dd>
                            <dt>
                                &nbsp;
                            </dt>
                            <dd class="marTop18">
                                <input name="agreement" type="checkbox" checked="checked">同意<a class="blue" target="_blank" href="http://www.teeker.com/help/user_agreement">注册协议</a>
                            </dd>
                            <dt>
                                &nbsp;
                            </dt>
                            <dd>
                                <a class="butLarge registerb" href="http://www.teeker.com/#">注册</a>
                            </dd>
                        </dl>
                    </div>
                    <div class="right">
                        <p class="font14">
                            您也可以使用合作网站账号登录
                        </p>
                        <p style="margin-top:20px;">
                            <a href="http://www.teeker.com/users/connect/weibo"><img src="./teeker_index_files/connect_weibo_logo.png"></a>
                        </p>
                        <p style="margin-top:20px;">
                            <a href="http://www.teeker.com/users/connect/renren"><img src="./teeker_index_files/connect_renren_logo.png"></a>
                        </p>
                        <p style="margin-top:20px;">
                            <a href="http://www.teeker.com/users/connect/tencent"><img src="./teeker_index_files/connect_tqq_logo.png"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
         
        <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=4546967" ></script>
        <script type="text/javascript" id="bdshell_js"></script>
        <script type="text/javascript">
        document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
        </script>
        

    </body>
</html>