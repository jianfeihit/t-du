	<div class="sideNav">
  <h5>订单中心</h5>
  <ul class="myList">
        <li><a href="user.php?act=order_list"<?php if ($this->_var['action'] == 'order_list' || $this->_var['action'] == 'order_detail'): ?>class="current"<?php endif; ?>> 我的订单</a></li>
        <li><a href="user.php?act=address_list"<?php if ($this->_var['action'] == 'address_list'): ?>class="curs"<?php endif; ?>>我的常用收货人</a></li>
        <li><a href="http://www.teeker.com/activities/mygroups/delivery">我负责的统一发货</a></li>
        <li><a href="http://www.teeker.com/activities/mygroups/pay">我负责的线下收款</a></li>
  </ul>
  <h5>店铺中心</h5>
  <ul class="myList">
        <li><a href="http://www.teeker.com/stores/mystore">我的店铺</a></li>
        <li><a href="http://www.teeker.com/designs/mydesigns">我的设计图案</a></li>
        <li><a href="http://www.teeker.com/activities/mylaunchs">我的主题销售</a></li>
        <!--
    <li><a href="/samples/mysamples" >我的样衣</a></li>
    -->
  </ul>
  <h5>我的账户</h5>
  <ul class="myList">
        <li><a href="user.php?act=profile"<?php if ($this->_var['action'] == 'profile'): ?>class="current"<?php endif; ?>> 编辑个人资料</a></li>
        <li><a href="user.php?act=modify_passwd"<?php if ($this->_var['action'] == 'modify_passwd'): ?>class="current"<?php endif; ?>>修改密码</a></li>
        <li><a href="http://www.teeker.com/users/validate_email">验证邮箱</a></li>
  </ul>
	</div>
