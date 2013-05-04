<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
<meta name="Generator" content="ECSHOP v2.7.3" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
        <meta name="Description" content="<?php echo $this->_var['description']; ?>" />
        <title><?php echo $this->_var['page_title']; ?></title>
        <link rel="shortcut icon" href="favicon.ico" />
        <link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
        <link href="assets/css/bootstrap.css" rel="stylesheet">

        <?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js,transport.js')); ?>
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

            input[type="submit"] {
                width: 115px;
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
?> 
                    <a href="<?php echo $this->_var['nav']['url']; ?>" 
                    <?php if ($this->_var['nav']['opennew'] == 1): ?> target="_blank" <?php endif; ?><?php echo $this->_var['nav']['name']; ?></a>

                    <?php if (! ($this->_foreach['nav_top_list']['iteration'] == $this->_foreach['nav_top_list']['total'])): ?>|
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <div class="topNavR"></div>
                    <?php endif; ?>
                </li>
            </ul>
            <div class="masthead">
                 <h2><?php echo $this->_var['page_title']; ?> </h2> <h4 class="muted">- 来自清华的个性定制品平台！</h4>

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
                                <li><a href="/message.php">发布</a>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>

<div class="blank"></div>

<?php if ($this->_var['action'] == 'login'): ?>
<div class="usBox clearfix">
  <div class="usBox_1 f_l">
   <div class="logtitle"></div>
   <form name="formLogin" action="user.php" method="post" onSubmit="return userLogin()">
        <table width="100%" border="0" align="left" cellpadding="3" cellspacing="5">
          <tr>
            <td width="15%" align="right"><?php echo $this->_var['lang']['label_username']; ?></td>
            <td width="85%"><input name="username" type="text" size="25" class="inputBg" /></td>
          </tr>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['label_password']; ?></td>
            <td>
            <input name="password" type="password" size="15"  class="inputBg"/>
            </td>
          </tr>
          <?php if ($this->_var['enabled_captcha']): ?>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
            <td><input type="text" size="8" name="captcha" class="inputBg" />
            <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td colspan="2"><input type="checkbox" value="1" name="remember" id="remember" /><label for="remember"><?php echo $this->_var['lang']['remember']; ?></label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left">
            <input type="hidden" name="act" value="act_login" />
            <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
            <input type="submit" name="submit" value="" class="us_Submit" />
            </td>
          </tr>
      <tr><td></td><td><a href="user.php?act=qpassword_name" class="f3"><?php echo $this->_var['lang']['get_password_by_question']; ?></a>&nbsp;&nbsp;&nbsp;<a href="user.php?act=get_password" class="f3"><?php echo $this->_var['lang']['get_password_by_mail']; ?></a></td></tr>
      </table>
    </form>
  </div>
  <div class="usTxt">
    <strong><?php echo $this->_var['lang']['user_reg_info']['0']; ?></strong>  <br />
    <strong class="f4"><?php echo $this->_var['lang']['user_reg_info']['1']; ?>：</strong><br />
    <?php if ($this->_var['car_off'] == 1): ?>
    <?php echo $this->_var['lang']['user_reg_info']['2']; ?><br />
    <?php endif; ?>
    <?php if ($this->_var['car_off'] == 0): ?>
    <?php echo $this->_var['lang']['user_reg_info']['8']; ?><br />
    <?php endif; ?>
    <?php echo $this->_var['lang']['user_reg_info']['3']; ?>：<br />
    1. <?php echo $this->_var['lang']['user_reg_info']['4']; ?><br />
    2. <?php echo $this->_var['lang']['user_reg_info']['5']; ?><br />
    3. <?php echo $this->_var['lang']['user_reg_info']['6']; ?><br />
    4. <?php echo $this->_var['lang']['user_reg_info']['7']; ?>  <br />
    <a href="user.php?act=register"><img src="themes/default/images/bnt_ur_reg.gif" /></a>
  </div>
  <script type='text/javascript' charset='utf-8' src='http://<?php echo $this->_var['denglu_url']; ?>.denglu.cc/connect/logincode?appid=<?php echo $this->_var['denglu_cache']['denglu_appid']; ?>'></script>
</div>
<?php endif; ?>



    <?php if ($this->_var['action'] == 'register'): ?>
    <?php if ($this->_var['shop_reg_closed'] == 1): ?>
    <div class="usBox">
      <div class="usBox_2 clearfix">
        <div class="f1 f5" align="center"><?php echo $this->_var['lang']['shop_register_closed']; ?></div>
      </div>
    </div>
    <?php else: ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
   <div class="regtitle"></div>
    <form action="user.php" method="post" name="formUser" onsubmit="return register();">
      <table width="100%"  border="0" align="left" cellpadding="5" cellspacing="3">
        <tr>
          <td width="13%" align="right"><?php echo $this->_var['lang']['label_username']; ?></td>
          <td width="87%">
          <input name="username" type="text" size="25" id="username" onblur="is_registered(this.value);" class="inputBg"/>
            <span id="username_notice" style="color:#FF0000"> *</span>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['label_email']; ?></td>
          <td>
          <input name="email" type="text" size="25" id="email" onblur="checkEmail(this.value);"  class="inputBg"/>
            <span id="email_notice" style="color:#FF0000"> *</span>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['label_password']; ?></td>
          <td>
          <input name="password" type="password" id="password1" onblur="check_password(this.value);" onkeyup="checkIntensity(this.value)" class="inputBg" style="width:179px;" />
            <span style="color:#FF0000" id="password_notice"> *</span>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['label_password_intensity']; ?></td>
          <td>
            <table width="145" border="0" cellspacing="0" cellpadding="1">
              <tr align="center">
                <td width="33%" id="pwd_lower"><?php echo $this->_var['lang']['pwd_lower']; ?></td>
                <td width="33%" id="pwd_middle"><?php echo $this->_var['lang']['pwd_middle']; ?></td>
                <td width="33%" id="pwd_high"><?php echo $this->_var['lang']['pwd_high']; ?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['label_confirm_password']; ?></td>
          <td>
          <input name="confirm_password" type="password" id="conform_password" onblur="check_conform_password(this.value);"  class="inputBg" style="width:179px;"/>
            <span style="color:#FF0000" id="conform_password_notice"> *</span>
          </td>
        </tr>
        <?php $_from = $this->_var['extend_info_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'field');if (count($_from)):
    foreach ($_from AS $this->_var['field']):
?>
    <?php if ($this->_var['field']['id'] == 6): ?>
        <tr>
          <td align="right"><?php echo $this->_var['lang']['passwd_question']; ?></td>
          <td>
          <select name='sel_question'>
      <option value='0'><?php echo $this->_var['lang']['sel_question']; ?></option>
      <?php echo $this->html_options(array('options'=>$this->_var['passwd_questions'])); ?>
      </select>
          </td>
        </tr>
        <tr>
          <td align="right" <?php if ($this->_var['field']['is_need']): ?>id="passwd_quesetion"<?php endif; ?>><?php echo $this->_var['lang']['passwd_answer']; ?></td>
          <td>
      <input name="passwd_answer" type="text" size="25" class="inputBg" maxlengt='20'/><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
          </td>
        </tr>
    <?php else: ?>
        <tr>
          <td align="right" <?php if ($this->_var['field']['is_need']): ?>id="extend_field<?php echo $this->_var['field']['id']; ?>i"<?php endif; ?>><?php echo $this->_var['field']['reg_field_name']; ?>
          <td>
          <input name="extend_field<?php echo $this->_var['field']['id']; ?>" type="text" size="25" class="inputBg" /><?php if ($this->_var['field']['is_need']): ?><span style="color:#FF0000"> *</span><?php endif; ?>
          </td>
        </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <?php if ($this->_var['enabled_captcha']): ?>
      <tr>
      <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
      <td><input type="text" size="8" name="captcha" class="inputBg" />
      <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?'+Math.random()" /> </td>
      </tr>
      <?php endif; ?>
        <tr>
          <td>&nbsp;</td>
          <td><label>
            <input name="agreement" type="checkbox" value="1" checked="checked" />
            <?php echo $this->_var['lang']['agreement']; ?></label></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">
          <input name="act" type="hidden" value="act_register" >
          <input type="hidden" name="back_act" value="<?php echo $this->_var['back_act']; ?>" />
          <input name="Submit" type="submit" value="" class="us_Submit_reg">
          </td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="actionSub">
          <a href="user.php?act=login"><?php echo $this->_var['lang']['want_login']; ?></a><br />
          <a href="user.php?act=get_password"><?php echo $this->_var['lang']['forgot_password']; ?></a>
          </td>
        </tr>
      </table>
    </form>
  </div>
  <script type='text/javascript' charset='utf-8' src='http://<?php echo $this->_var['denglu_url']; ?>.denglu.cc/connect/logincode?appid=<?php echo $this->_var['denglu_cache']['denglu_appid']; ?>'></script>
</div>
<?php endif; ?>
<?php endif; ?>



    <?php if ($this->_var['action'] == 'get_password'): ?>
    <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js')); ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post" name="getPassword" onsubmit="return submitPwdInfo();">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['username_and_email']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['username']; ?></td>
            <td width="61%"><input name="user_name" type="text" size="30" class="inputBg" /></td>
          </tr>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['email']; ?></td>
            <td><input name="email" type="text" size="30" class="inputBg" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="send_pwd_email" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
        </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>


    <?php if ($this->_var['action'] == 'qpassword_name'): ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['get_question_username']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['username']; ?></td>
            <td width="61%"><input name="user_name" type="text" size="30" class="inputBg" /></td>
          </tr>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="get_passwd_question" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
        </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>


    <?php if ($this->_var['action'] == 'get_passwd_question'): ?>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post">
        <br />
        <table width="70%" border="0" align="center">
          <tr>
            <td colspan="2" align="center"><strong><?php echo $this->_var['lang']['input_answer']; ?></strong></td>
          </tr>
          <tr>
            <td width="29%" align="right"><?php echo $this->_var['lang']['passwd_question']; ?>：</td>
            <td width="61%"><?php echo $this->_var['passwd_question']; ?></td>
          </tr>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['passwd_answer']; ?>：</td>
            <td><input name="passwd_answer" type="text" size="20" class="inputBg" /></td>
          </tr>
          <?php if ($this->_var['enabled_captcha']): ?>
          <tr>
            <td align="right"><?php echo $this->_var['lang']['comment_captcha']; ?></td>
            <td><input type="text" size="8" name="captcha" class="inputBg" />
            <img src="captcha.php?is_login=1&<?php echo $this->_var['rand']; ?>" alt="captcha" style="vertical-align: middle;cursor: pointer;" onClick="this.src='captcha.php?is_login=1&'+Math.random()" /> </td>
          </tr>
          <?php endif; ?>
          <tr>
            <td></td>
            <td><input type="hidden" name="act" value="check_answer" />
              <input type="submit" name="submit" value="<?php echo $this->_var['lang']['submit']; ?>" class="bnt_blue" style="border:none;" />
              <input name="button" type="button" onclick="history.back()" value="<?php echo $this->_var['lang']['back_page_up']; ?>" style="border:none;" class="bnt_blue_1" />
        </td>
          </tr>
        </table>
        <br />
      </form>
  </div>
</div>
<?php endif; ?>

<?php if ($this->_var['action'] == 'reset_password'): ?>
    <script type="text/javascript">
    <?php $_from = $this->_var['lang']['password_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
      var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </script>
<div class="usBox">
  <div class="usBox_2 clearfix">
    <form action="user.php" method="post" name="getPassword2" onSubmit="return submitPwd()">
      <br />
      <table width="80%" border="0" align="center">
        <tr>
          <td><?php echo $this->_var['lang']['new_password']; ?></td>
          <td><input name="new_password" type="password" size="25" class="inputBg" /></td>
        </tr>
        <tr>
          <td><?php echo $this->_var['lang']['confirm_password']; ?>:</td>
          <td><input name="confirm_password" type="password" size="25"  class="inputBg"/></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="hidden" name="act" value="act_edit_password" />
            <input type="hidden" name="uid" value="<?php echo $this->_var['uid']; ?>" />
            <input type="hidden" name="code" value="<?php echo $this->_var['code']; ?>" />
            <input type="submit" name="submit" value="<?php echo $this->_var['lang']['confirm_submit']; ?>" />
          </td>
        </tr>
      </table>
      <br />
    </form>
  </div>
</div>
<?php endif; ?>

            <hr>
            <div class="footer">
                <p>&copy; t-du.com 2013</p>
            </div>
        </div>
        
        <?php echo $this->smarty_insert_scripts(array('files'=>'common.js')); ?>
        <script src="assets/js/jquery.js"></script>
    </body>

</html>