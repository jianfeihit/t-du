<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" content="ECSHOP v2.7.3" />

<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link href="<?php echo $this->_var['ecs_css_path']; ?>" rel="stylesheet" type="text/css" />
<link rel="alternate" type="application/rss+xml" title="RSS|<?php echo $this->_var['page_title']; ?>" href="<?php echo $this->_var['feed_url']; ?>" />

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,index.js')); ?>
<script type='text/javascript'>
	function ID(id) {
		return document.getElementById(id);
	}
function dl_is_registered( username , nodeid, callback)
{
    var submit_disabled = false;
	var unlen = username.replace(/[^\x00-\xff]/g, "**").length;

    if ( username == '' )
    {
        document.getElementById(nodeid).innerHTML = msg_un_blank;
        var submit_disabled = true;
    }

    if ( !chkstr( username ) )
    {
        document.getElementById(nodeid).innerHTML = msg_un_format;
        var submit_disabled = true;
    }
    if ( unlen < 3 )
    { 
        document.getElementById(nodeid).innerHTML = username_shorter;
        var submit_disabled = true;
    }
    if ( unlen > 14 )
    {
        document.getElementById(nodeid).innerHTML = msg_un_length;
        var submit_disabled = true;
    }
    if ( submit_disabled )
    {
        return false;
    }
	Ajax.call( 'user.php?act=is_registered', 'username=' + username,  typeof(callback) === "function" ? callback : dl_registed_callback , 'GET', 'TEXT', true, true );
}

function dl_registed_callback(result)
{
  if ( result == "true" )
  {
    ID('username_notice').innerHTML = msg_can_rg;
  }
  else
  {
    ID('username_notice').innerHTML = msg_un_registered;
  }
}

function dl_bind_reg_callback(result)
{
  if ( result == "true" )
  {
    ID('reg_username_notice').innerHTML = msg_can_rg;
  }
  else
  {
    ID('reg_username_notice').innerHTML = msg_un_registered;
  }
}

function quick_register(){
	dl_is_registered(ID('username').value, "username_notice", submit_register);
}

function submit_register(result) {
	dl_registed_callback(result);
	if(ID('username_notice').innerHTML == msg_can_rg){
		ID("quick_form").submit()
	}
}

function dl_reg_check_email(email, callback)
{
  var submit_disabled = false;
  
  if (email == '')
  {
    document.getElementById('email_notice').innerHTML = msg_email_blank;
    submit_disabled = true;
  }
  else
  {
    var reg1 = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;
    if (!reg1.test( email )) {
	document.getElementById('email_notice').innerHTML = msg_email_format;
	submit_disabled = true;
    }
  }
 
  if( submit_disabled )
  {
    return false;
  }
  Ajax.call( 'user.php?act=check_email', 'email=' + email, typeof(callback) === "function" ? callback : dl_check_email_callback , 'GET', 'TEXT', true, true );
}

function dl_check_email_callback(result)
{
  if ( result == 'ok' )
  {
    document.getElementById('email_notice').innerHTML = msg_can_rg;
  }
  else
  {
    document.getElementById('email_notice').innerHTML = msg_email_registered;
  }
}

function bind_register() {
	var password = ID('reg_password').value;
	if (password.length == 0)
	  {
	    alert(password_empty);
	    return false;
	  }
	  else if (password.length < 6)
	  {
	    alert(password_shorter);
	    return false;
	 }
	dl_is_registered(ID('reg_user_name').value, "reg_username_notice", dl_reg_1);
}

function dl_reg_1(result) {
	dl_bind_reg_callback(result);
	if(ID('reg_username_notice').innerHTML == msg_can_rg){
		dl_reg_check_email(ID('reg_email').value, dl_reg_2);
	}
}

function dl_reg_2(result) {
	dl_check_email_callback(result);
	if(ID('email_notice').innerHTML == msg_can_rg){
		ID("reg_form").submit();
	}
}

</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'user.js')); ?>

<link type="text/css" href="admin/denglu/themes/style.css" rel="stylesheet" />

<div class="dl_main">
	<div class="dl_top layout">
		<div class="dl_logo">
			<img src="admin/denglu/themes/images/denglu_second_<?php echo $this->_var['userinfo']['mediaID']; ?>.png">
        </div>

        <div class="dl_notes">
        	<p class="h3"><?php echo $this->_var['Dlang']['use']; ?><span><?php echo $this->_var['dl_media']['mediaName']; ?></span><?php echo $this->_var['Dlang']['account_login']; ?><span><?php echo $this->_var['Dlang']['our_website']; ?></span><?php echo $this->_var['Dlang']['success']; ?></p>
			<p><?php echo $this->_var['Dlang']['discuz_tip0']; ?><?php echo $this->_var['dl_media']['mediaName']; ?><?php echo $this->_var['Dlang']['discuz_tip1']; ?></p>
        </div>
    </div>
			<?php if ($this->_var['userinfo']['mediaID'] == 7): ?><p style="margin-top:15px;font-weight:bold;">
				<?php echo $this->_var['Dlang']['renren_auth_tip']; ?><a style="color:#ff6000" target="_blank" href="http://app.renren.com/apps/authorize.do?api_key=<?php echo $this->_var['denglu_data']['7']['apiKey']; ?>&next=&ext_perm=publish_feed&display=noad"><?php echo $this->_var['Dlang']['click_here']; ?></a>
				<?php echo $this->_var['Dlang']['auth_over']; ?>
				</p><?php endif; ?>
	<?php if ($this->_var['act'] == 'quick_login'): ?>
	<div class="dl_text" id='quick_login'><span id='loader' style='display:none'></span>
		<form method='post' action='denglu.php' id='quick_form' >
			<div class="dl_form layout">
				<p><?php echo $this->_var['Dlang']['dl_username']; ?></p>
				<p><input type="text" id='username' value="<?php echo $this->_var['userinfo']['screenName']; ?>" name='username' onblur='dl_is_registered(this.value, "username_notice");'/></p>
				<p class="dl_wrong" id='username_notice'></p>
        	</div>
      	  	 <div class="dl_btn layout">
      	  	 	<input type='hidden' name='quick' value='1'>
      	  	 	<input type='hidden' name='act' value='do_quick_login' id='act'>
      	  	 	<input type='hidden' name='userbak' value='<?php echo $this->_var['userbak']; ?>'>
	        <p><a href='javascript:quick_register()'><?php echo $this->_var['Dlang']['quick_login']; ?></a></p>
             	<p><a href='javascript:ID("act").value="bind_have";ID("quick_form").submit();' ><?php echo $this->_var['Dlang']['account_bindding']; ?></a></p>
			 </div>
		</form>
        <div class="dl_warnning">
			<p class="dl_wrong"><?php echo $this->_var['Dlang']['denglu_tip0']; ?><?php echo $this->_var['dl_media']['mediaName']; ?><?php echo $this->_var['Dlang']['denglu_tip1']; ?></p>
        </div>
	</div>
	<?php endif; ?>
	<?php if ($this->_var['act'] == 'bind_have'): ?> 
	<div class="dl_text" id='bind_have'  >
    	<div class="dl_tab layout">
			<p><a href="javascript:;" onclick='ID("act").value="bind_haveno";ID("bind_form").submit()'><?php echo $this->_var['Dlang']['have_no_account']; ?></a></p>
			<p class="active"><a href="javascript:;"><?php echo $this->_var['Dlang']['have_account']; ?></a></p>
        </div>
        <form method='post' action='denglu.php' id='bind_form' onsubmit='return quick_login()'>
			<input type='hidden' name='userbak' value='<?php echo $this->_var['userbak']; ?>'>
				<input type='hidden' name='act' value='do_bind_have' id='act'>
	        <div class="dl_inform">
	            <div class="dl_form layout">
					<p><?php echo $this->_var['Dlang']['dl_username']; ?></p>
	                <p><input type="text" value="" name='username'/></p>
	                <p class="dl_wrong"></p>
	                <p class="dl_wrong"></p>
	            </div>
	            <div class="dl_form layout">
					<p><?php echo $this->_var['Dlang']['password']; ?></p>
	                <p><input type="password" value="" name='password'/></p>
	                <p class="dl_wrong"></p>
	                <p class="dl_point"></p>
	            </div>
	        </div>
	        <div class="dl_btn layout">
				<p><button tabindex="1" value="true" name="bind" type="submit" class="pn pnc"><span><?php echo $this->_var['Dlang']['bind_it']; ?></span></button></p>
				
	        </div>
        </form>
	</div>
	<?php endif; ?>
	<?php if ($this->_var['act'] == bind_haveno): ?>
	<div class="dl_text" id='bind_haveno'>
    	<div class="dl_tab layout">
        	<p class="active"><a href="javascript:;"><?php echo $this->_var['Dlang']['have_no_account']; ?></a></p>
			<p><a href="javascript:;" onclick='ID("act").value="bind_have";ID("reg_form").submit();'><?php echo $this->_var['Dlang']['have_account']; ?></a></p>
        </div>
        <form method='post' action="denglu.php" id='reg_form'>
        	<input type='hidden' name='userbak' value='<?php echo $this->_var['userbak']; ?>'>
        		<input type='hidden' name='act' value='do_bind_haveno' id='act'>
	        <div class="dl_inform">
	            <div class="dl_form layout">
	                <p><?php echo $this->_var['Dlang']['dl_username']; ?></p>
					<p><input id='reg_user_name' type="text" value="<?php echo $this->_var['userinfo']['screenName']; ?>" name='username' onblur='dl_is_registered(this.value, "reg_username_notice", dl_bind_reg_callback);'/></p>
	                <p class="dl_wrong" id='reg_username_notice'>*</p>
					<p class="dl_wrong"><?php echo $this->_var['u_error']; ?></p>
	            </div>
	            <div class="dl_form layout">
	                <p><?php echo $this->_var['Dlang']['password']; ?></p>
	                <p><input type="password" value="" name='password' id='reg_password'/></p>
	                <p class="dl_wrong">*</p>
					<p class="dl_point"><?php echo $this->_var['Dlang']['password_tip']; ?></p>
	            </div>
	            <div class="dl_form layout">
	                <p><?php echo $this->_var['Dlang']['email']; ?></p>
	                <p><input type="text"  name='email' onblur='dl_reg_check_email(this.value);' id='reg_email'/></p>
					<p class="dl_wrong" id='email_notice'>*<?php echo $this->_var['e_error']; ?></p>
					<p class="dl_point"><?php if (! $this->_var['e_error']): ?><?php echo $this->_var['Dlang']['email_advise']; ?><?php endif; ?></p>
	            </div>
	        </div>
	        <div class="dl_btn layout">
	        	<p><button onclick='bind_register();' tabindex="1" value="true" name="reg" type="button" class="pn pnc"><span><?php echo $this->_var['Dlang']['confirm']; ?></span></button></p>
	            
	        </div>
        </form>
	</div>
	<?php endif; ?>
</div>
<script type="text/javascript">
var username_empty = "<?php echo $this->_var['Dlang']['username_empty']; ?>";
var username_shorter = "<?php echo $this->_var['Dlang']['username_shorter']; ?>";
var username_invalid = "<?php echo $this->_var['Dlang']['username_invalid']; ?>";
var password_empty = "<?php echo $this->_var['Dlang']['password_empty']; ?>";
var password_shorter = "<?php echo $this->_var['Dlang']['password_shorter']; ?>";
var email_empty = "<?php echo $this->_var['Dlang']['email_empty']; ?>";
var email_invalid = "<?php echo $this->_var['Dlang']['email_invalid']; ?>";
var msg_un_blank = "<?php echo $this->_var['Dlang']['msg_un_blank']; ?>";
var msg_un_length = "<?php echo $this->_var['Dlang']['msg_un_length']; ?>";
var msg_un_format = "<?php echo $this->_var['Dlang']['msg_un_format']; ?>";
var msg_un_registered = "<?php echo $this->_var['Dlang']['msg_un_registered']; ?>";
var msg_can_rg = "<?php echo $this->_var['Dlang']['msg_can_rg']; ?>";
var msg_email_blank = "<?php echo $this->_var['Dlang']['msg_email_blank']; ?>";
var msg_email_registered = "<?php echo $this->_var['Dlang']['msg_email_registered']; ?>";
var msg_email_format = "<?php echo $this->_var['Dlang']['msg_email_format']; ?>";
var passwd_balnk = "<?php echo $this->_var['Dlang']['passwd_balnk']; ?>";
var username_exist = "<?php echo $this->_var['Dlang']['username_exist']; ?>";

</script>


<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
</html>

