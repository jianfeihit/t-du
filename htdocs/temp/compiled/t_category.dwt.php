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
            .thumbnail {
                min-height: 410px;
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

            .row-fluid .span4 {
                width: 30.8%;
                *width: 31.861702127659576%;
            }

            .row-fluid [class*="span"]:first-child {
                margin-left: 20px;
            }
        </style>
    </head>
    
    <body>
        <div class="container">
            <ul class="nav nav-pills pull-right">
                <li><?php echo $this->_var['denglu_top_logo']; ?></li>
                <li><?php echo $this->smarty_insert_scripts(array('files'=>'transport.js,utils.js')); ?> <font id="ECS_MEMBERZONE"><?php 
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
                                
                                <li class="active"><a href="/category.php?id=1">T-du活动</a>

                                </li>
                                <li><a href="/goodsVote.php?id=3">班衫评选</a>

                                </li>
                                <li><a href="/message.php">发布</a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row-fluid">
                <ul class="thumbnails">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                    <li class="span4">
                        <div class="thumbnail">
                            <a href="<?php echo $this->_var['goods']['url']; ?>">
                                <img data-src="holder.js/280x276" style="width: 280px; height: 276px;" src="<?php echo $this->_var['goods']['goods_thumb']; ?>">
                            </a>
                            <div class="caption">
                                <h3><?php echo $this->_var['goods']['name']; ?></h3>
                                <p>特价：<span class="label label-important"><?php echo $this->_var['goods']['shop_price']; ?></span></p>
                                <p>截至：<span class="label"><?php echo $this->_var['goods']['promote_end_date']; ?></span></p>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            
            <?php echo $this->fetch('library/pages.lbi'); ?>

            <hr>
            <div class="footer">
                <p>&copy; t-du.com 2013</p>
            </div>
        </div>
    </body>
</html>