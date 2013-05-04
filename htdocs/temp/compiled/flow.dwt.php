<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />
<title><?php echo $this->_var['page_title']; ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="./themes/default/css/front.css"/>
</head>
<body>
<div id="acsd" class="layer layerSmall hide ui-dialog-content ui-widget-content" style="display: block; width: auto; min-height: 150px; height: auto;margin: 0px auto 0;" scrolltop="0" scrollleft="0">
  <div class="shoppingCart">
    <h6>商品已成功加入购物车</h6>
    <strong>您选择了：</strong>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <dl>
      <dt><img width="66" height="66" src="http://pic.teeker.com/products/1794_577_front_130424160210_70x70.jpg" class="yourimg"/></dt>
      <dd class="yourp">
      <?php $_from = $this->_var['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['k'] => $this->_var['value']):
?>
        <span>key=<?php echo $this->_var['k']; ?>:value=<?php echo $this->_var['value']; ?></span><br/>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
        <span><?php echo $this->_var['goods']['goods_name']; ?></span>
        <ul>
        <li>订单数量:<?php echo $this->_var['goods']['goods_number']; ?></li>
        </ul>
      </dd>
    </dl>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <p><a href="flow.php?step=checkout" class="but settle">去购物车结算</a><a href="./" class="blue continue">&lt;&lt;继续购物</a></p>
  </div>
</div>
<script type="text/javascript">
</script>
</body>
</html>
