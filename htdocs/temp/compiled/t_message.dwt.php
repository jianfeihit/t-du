<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
<meta name="Generator" content="ECSHOP v2.7.3" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
        <meta name="Description" content="<?php echo $this->_var['description']; ?>" />
        <title><?php echo $this->_var['page_title']; ?></title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="/assets/css/bootstrap.css" rel="stylesheet">

        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 60px;
            }
            /* Custom container */
            .container {
                margin: 0 auto;
                max-width: 1000px;
            }
            .container > hr {
                margin: 60px 0;
            }
            /* Main marketing message and sign up button */
            .jumbotron {
                margin: 20px 0;
                text-align: center;
            }
            .jumbotron h1 {
                font-size: 100px;
                line-height: 1;
            }
            .jumbotron .lead {
                font-size: 24px;
                line-height: 1.25;
            }
            .jumbotron .btn {
                font-size: 21px;
                padding: 14px 24px;
            }
            /* Supporting marketing content */
            .marketing {
                margin: 40px 0;
            }
            .marketing p + h4 {
                margin-top: 28px;
            }

            /* Customize the navbar links to be fill the entire space of the .navbar */
            .navbar .navbar-inner {
                padding: 0;
            }
            .navbar .nav {
                margin: 0;
                display: table;
                width: 100%;
            }
            .navbar .nav li {
                display: table-cell;
                width: 1%;
                float: none;
            }
            .navbar .nav li a {
                font-weight: bold;
                text-align: center;
                border-left: 1px solid rgba(255, 255, 255, .75);
                border-right: 1px solid rgba(0, 0, 0, .1);
            }
            .navbar .nav li:first-child a {
                border-left: 0;
                border-radius: 3px 0 0 3px;
            }
            .navbar .nav li:last-child a {
                border-right: 0;
                border-radius: 0 3px 3px 0;
            }
            .blocks {
                cursor: pointer;
                margin-top: 0px;
                border: 1px solid #E7E7E7;
                width: 16px;
                height: 16px;
                display: inline-block;
            }
        </style>

    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.10.2.js"></script>
    <style type="text/css">
        input, textarea, select, button {
            font-size: 12px;
        }
        img {
            border-style: none;
        }
        em {
            font-style: normal;
        }
        cite, small, address {
            font-size: 12px;
            font-style: normal;
            color: #999;
        }
        a {
            color: #00f;
            text-decoration: underline;
        }
        #box {
            padding: 10px;
            margin: 10px 20px 10px 20px;
            font-size: 14px;
            position: relative;
        }
        /*演示内容*/
        #imgBox {
            float: left;
            border: #CCC 1px solid;
            width: 400px;
            height: 400px;
        }
        #imgBoard {
            position: absolute;
            border: #CCC 1px dashed;
            width: 200px;
            height: 280px;
            top: 85px;
            left: 108px;
        }
        #imgCut {
            margin: 0;
        }
        #faceImg {
            width: 400px;
            height: 400px;
        }
        #imgBox_pre strong {
            display: block;
            font-size: 12px;
            text-align: center;
        }
        #data {
            clear: both;
            padding-top: 20px;
        }
        #dobutton {
            clear: both;
            margin-top: 8px;
        }
        .pointer {
            cursor: pointer;
        }
    </style>

        
        <link href="/js/uploadify/uploadify.css" rel="stylesheet" type="text/css"></link>
        <link href="/css/jquery-ui.css" rel="stylesheet" type="text/css"></link>
        <script type="text/javascript" src="/js/uploadify/jquery.uploadify.js"></script>
        <script type="text/javascript" src="/js/t-du.js"></script>
        <script type="text/javascript">
            var scale2, scale3, imgH, imgW, imgsrc, scale, temp_top, temp_left;
            var sysW = 100;
            var sysH = 140;
            var cleared = false;
            function RecordImageCss() {
                var css = '{' + 'left:' + $("#left").val() + ';top:' + $("#top").val() + ';width:' + $("#width").val() + ';height:' + $("#height").val() + ';}';
                $('#imgCss').val(css);
            }
            function SmartPos(pos) {
                var frame = $("#imgBoard");
                var design = $("#imgCut");
            
                var css = SmartPosition.pos(pos, design, frame);
                if (css.top < 0) {
                    css = {left: css.left};
                    design.css(css);
                } else if (css.left < 0) {
                    css = {top: css.top};
                    design.css(css);
                } else {
                    design.css(css);
                }
            
                temp_top = design.offset().top - frame.offset().top;
                temp_left = design.offset().left - frame.offset().left;
            
                $("#left").val(temp_left);
                $("#top").val(temp_top);
                RecordImageCss();
            }
            function SetPostImage(file, sf, w, h) {
                $('#clearColor').hide();
                $('#imgUrl').val(sf);
            
                $('#imgTarget').attr('src', sf);
                var rate = w / h;
                var width = $("#imgBoard").width() / 4 * 3;
                var height = $("#imgBoard").height() / 4 * 3;
                if (w < width && h < height) {
                    width = w;
                    height = h;
                }
                if (rate > 1) {
                    height = Math.round(width / rate);
                } else {
                    width = Math.round(height * rate);
                }
            
                $("#imgCut").width(width).height(height);
                $("#width").val(width);
                $("#height").val(height);
                SmartPos("center");
                
                $('#fup').find('#fup-button').css("background-image", "url(" + UploadWrapper.ButtonImage2 + ")");
                RecordImageCss();
            
                $.ajax({
                    data: {FilePath: sf, ColorNum: 2},
                    url: '/imagehandler.php',
                    type: 'POST',
                    success: function(data) {
                        if (data) {
                            var splits = data.split('|');
                            if (splits.length == 2) {
                                var num = splits[0];
                                var info = splits[1];
                                $('#color').show();
                                $('#colorNum').html(num);
                                if (num != 0 && !cleared) {
                                    $('#colorInfo').html(info);
                                    $('.colorBlock').click(function() {
                                        var color = $(this).css('background-color');
                                        $('#clearTarget').css('background-color', color);
                                        $('#clearColor').show();
                                    });
                                } else {
                                    $('#colorInfo').html('系统检测不到您的图案的背景颜色');
                                }
                            }
                        }
                    }
                });
            }
            function RGB2Hex(rgb){
                var re = rgb.replace(/(?:\(|\)|rgb|RGB)*/g,"").split(",");//利用正则表达式去掉多余的部分
                var hexColor = "#";
                var hex = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];
                for (var i = 0; i < 3; i++) {
                    var r = null;
                    var c = re[i];
                    var hexAr = [];
                    while (c > 16) {
                        r = c % 16;
                        c = (c / 16) >> 0;
                        hexAr.push(hex[r]);
                    }
                    hexAr.push(hex[c]);
                    hexColor += hexAr.reverse().join('');
                }
                return hexColor;
            }
            function clearPictureBg() {
                var sf = $('#imgUrl').val();
                var color = RGB2Hex($('#clearTarget').css("background-color"));
                $.ajax({
                    data: {FilePath: sf, Color: color},
                    url: '/imagehandler3.php',
                    type: 'POST',
                    success: function(data) {
                        if (data == "0") {
                            // fail
                            return;
                        }
                        cleared = true;
                        var splits = data.split(":");
                        if (splits.length >= 2 && splits[0] == "1") {
                          $('#imgTarget').attr('src', splits[1]);
                          $('#imgUrl').val(splits[1]);
                        }
                    }
                });
            }
            $(function() {
                var uploader = new UploadWrapper("fup", "fqa", SetPostImage);
                uploader.init();
            
                $("#imgCut").draggable({
                    containment : $("#imgBoard"), 
                    drag : function () {
                        $("#width").val($("#imgCut").width());
                        $("#height").val($("#imgCut").height());
                    
                        temp_top = $(this).offset().top - $("#imgBoard").offset().top;
                        temp_left = $(this).offset().left - $("#imgBoard").offset().left;
                    
                        $("#left").val(temp_left);
                        $("#top").val(temp_top);
                        RecordImageCss();
                    }, 
                    stop : function () {
                    }
                });
            
                $("#imgCut").resizable({
                    containment : $("#imgBoard"), 
                    aspectRatio : true, 
                    minWidth : 50, 
                    minHeight : 50, 
                    resize : function () {
                        $("#width").val($("#imgCut").width());
                        $("#height").val($("#imgCut").height());
                    
                        temp_top = $(this).offset().top - $("#imgBoard").offset().top;
                        temp_left = $(this).offset().left - $("#imgBoard").offset().left;
                    
                        $("#left").val(temp_left);
                        $("#top").val(temp_top);
                        RecordImageCss();
                    }, 
                    stop : function (e, ui) {
                    }
                });
            });
        
            function changeImg(url) {
                var bigimg = document.getElementById("faceImg"); 
                if (bigimg) {
                    bigimg.src = url;
                    $('#shirtUrl').val(url.substring(20));
                }
            }
        </script>
    </head>
    <body>
        <div class="container">
            <ul class="nav nav-pills pull-right">
                <li><?php echo $this->_var['denglu_top_logo']; ?></li>
                <li><font id="ECS_MEMBERZONE"><?php 
$k = array (
  'name' => 'member_info',
);
echo $this->_echash . $k['name'] . '|' . serialize($k) . $this->_echash;
?> </font>

                    <?php if ($this->_var['navigator_list']['top']): ?>
                    <?php $_from = $this->_var['navigator_list']['top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?> <a href="<?php echo $this->_var['nav']['url']; ?>" <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav']['name']; ?></a>

                    <?php if (! ($this->_foreach['nav_top_list']['iteration'] == $this->_foreach['nav_top_list']['total'])): ?>|
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <div class="topNavR"></div>
                    <?php endif; ?>
                </li>
            </ul>
            <div class="masthead">
                 <h2>T-DU </h2> <h4 class="muted">- 来自清华的个性定制品平台！</h4>

                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <ul class="nav">
                                <li><a href="/">首页</a>

                                </li>
                                <li><a href="/t_about.php">关于T-du</a>

                                </li>
                                <li><a href="/category.php?id=1">T-du活动</a>

                                </li>
                                <li><a href="/goodsVote.php?id=3">班衫评选</a>

                                </li>
                                <li class="active"><a href="/message.php">发布</a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>

            
            <div class="row-fluid">

                <div class="span6"> 
                    <form action="message.php?act=add_new_product" method="POST" enctype="multipart/form-data" name="good_data" id="add_form">
                        <table>
                                <tr>
                                    <td>活动名称</td>
                                    <td>
                                        <input name="goods_name" id="goods_name" type="text" class="inputBg" size="30" />
                                    </td>
                                </tr>

                                <tr>
                                    <td>预计征订量</td>
                                    <td>
                                        <select name="goods_number">
                                            <option value="50" selected="selected">50</option>
                                            <option value="200">200</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td >预计价格</td>
                                    <td>
                                        <select name="shop_price">
                                            <option value="39" selected="selected">39</option>
                                            <option value="35">35</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td valign="middle">活动简介</td>
                                    <td>
                                        <textarea name="goods_desc" id="goods_desc" cols="50" rows="10" wrap="virtual" style="border:1px solid #ccc;"></textarea>
                                    </td>
                                </tr> 
                                <tr>
                                    <td align="right">&nbsp;</td>
                                    <td>
                                        <input type="hidden" id="imgUrl" name="imgUrl" value="" />
                                        <input type="hidden" id="shirtUrl" name="shirtUrl" value="tshirt/1_f.png" />
                                        <input type="hidden" id="imgCss" name="imgCss" value="" />
                                        <a class="btn" onClick="javascript: submitform()">提交</a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <img src="/images/price.png" class="img-polaroid">
                </div>

                <div class="span6">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                <div style="margin-left:30px">
                                    <input type="file" name="fup" id="fup" />
                                    <div id="fqa"></div>
                                    <img src="/tshirt/1_f.png" alt="" class="pointer" onclick="changeImg(this.src)" width="30" />
                                    <img src="/tshirt/2_f.png" alt="" class="pointer" onclick="changeImg(this.src)" width="30" />
                                    <img src="/tshirt/3_f.png" alt="" class="pointer" onclick="changeImg(this.src)" width="30" />
                                    <img src="/tshirt/4_f.png" alt="" class="pointer" onclick="changeImg(this.src)" width="30" />
                                    <img src="/tshirt/5_f.png" alt="" class="pointer" onclick="changeImg(this.src)" width="30" />
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="box">
                                    <div id="imgBox">
                                        <img id="faceImg" src="/tshirt/1_f.png" border="0" />
                                        <div id="imgBoard">
                                            <div id="imgCut">
                                                <img id="imgTarget" src="" width="100%" height="100%" style="border:1px dotted #545565;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-left:30px; margin-top:10px">
                                    <p class="bit">
                                        <span>智能选位</span>
                                        <span class="location"><a title="中心" onclick="javascript:SmartPos('center');">中心</a></span>
                                        <span class="location1"><a title="左胸" onclick="javascript:SmartPos('chest');">左胸</a></span>
                                        <span class="marLet18">居中</span>
                                        <span class="location2"><a title="水平居中" onclick="javascript:SmartPos('hmiddle');">水平居中</a></span>
                                        <span class="location3"><a title="垂直居中" onclick="javascript:SmartPos('vmiddle');">垂直居中</a></span>
                                    </p>
                                    <p id="color" class="bit" style="display: none;">
                                        <span>系统检测到您的图案中共有<span id="colorNum"></span>个颜色：
                                            <span id="colorInfo"></span>
                                        </span>
                                    </p>
                                    <br />
                                    <div id="clearColor" style="display: none;">
                                        <span>需要清除您选择的背景色<li id="clearTarget" style="width: 20px; height: 20px; margin: 0 5px;"></li>吗？
                                            <a onclick="javascript:clearPictureBg();">清除背景色</a></span>
                                    </div>
                                    <div id="data" style="display: none;">
                                        左<input name="left" type="text" id="left" size="3" readonly="readonly" />
                                        上<input name="top" type="text" id="top" size="3" readonly="readonly" />
                                        宽<input name="width" type="text" id="width" size="3" readonly="readonly" />
                                        高<input name="height" type="text" id="height" size="3" readonly="readonly" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

        
            </div>
            <hr>
            <div class="footer">
                <p>&copy; t-du.com 2013</p>
            </div>
        </div>
        
        <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
        <script type="text/javascript">
        function submitform()
        {            
            var g_name = $('#goods_name').val();
            var g_desc = $('#goods_desc').val();
            var g_logo = $('#imgUrl').val();

            var msg_err = '';

            if(g_name.length == 0)
            {
                msg_err += "请输入标题" + '\n';
            }

            if(g_desc.length == 0)
            {
                msg_err += "请输入内容" + '\n'
            }

            if(g_logo.length == 0)
            {
                msg_err += "请选择图片" + '\n'
            }

            if (msg_err.length > 0) 
            {
                alert(msg_err);
            } 
            else
            {
                alert("发布成功，请耐心等待审核通过。");
                document.forms['add_form'].submit();
            }
        }
        </script>
    </body>

</html>