<?php
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

$userinfo = get_userinfo();
$userbak = encrypt(serialize($userinfo));

assign_template();
$smarty->assign('userinfo',$userinfo);
$smarty->assign('dl_media',$denglu_data[$userinfo['mediaID']]);
$smarty->assign('userbak',$userbak);
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');

if(empty($userinfo['mediaID'])){
	show_message($Dlang['error_network'],$Dlang['back_to_home'],'index.php','error');
}

if(!empty($_SESSION['dl_olbind']) && !empty($_SESSION['user_id'])){///在线绑定
	$userinfo['tag'] = 1;
	
	$result = is_bind($userinfo['mediaUserID']);
	$result==1 && show_message($Dlang['denglu_bind_success'],$Dlang['back_to_home'],'index.php','warning',0);
	$result==2 && show_message($Dlang['binded_with_other'],$Dlang['back_to_home'],'index.php','warning',0);

	$userinfo['email'] = $_SESSION['email'];
	$userinfo['username'] = $_SESSION['user_name'];
	$userinfo['uid'] = $_SESSION['user_id'];

	!$result && denglu_bind($userinfo); 

	$bind_r = $api->post_bind_info($userinfo);
	empty($bind_r['result']) && show_message($Dlang['post failed']);

	if($denglu_cache['denglu_login_syn']){
		$login_r = $api->post_login($userinfo['mediaUserID']);
		!$login_r['result'] && show_message($Dlang['post failed']);
	}

	$_SESSION['syn_data'] = null;
	show_message($Dlang['denglu_bind_success'],$Dlang['show_my_info'],'denglu.php?act=dl_user');
}

$result = get_bind_info($userinfo['mediaUserID']);////////check media user exist or no

if(!empty($result['user_id'])){
	$_SESSION['user_id'] = $result['user_id'];
	$sql = "select * from ".$ecs->table('users')." where user_id=".$_SESSION['user_id'];
	$row = $db->getRow($sql);
	$_SESSION['user_name'] = $row['user_name'];
	$_SESSION['email'] = $row['email'];

	update_user_info();
    recalculate_price();
	
	show_message($Dlang['login_success'],array($Dlang['back_to_home'],$Dlang['show_my_info']),array('index.php','user.php'),'info');
}

if(!empty($_REQUEST['token'])) $_REQUEST['act'] = 'quick_login';
if(!empty($_REQUEST['token']) && $denglu_cache['denglu_force_bind']){
	$_REQUEST['act'] = 'bind_have';
}

if( !empty($_REQUEST['act']) && in_array($_REQUEST['act'],array('quick_login','bind_have','bind_haveno'))){//////////直接登录选择

	$smarty->assign('act',$_REQUEST['act']);
	$smarty->display('denglu.dwt');
	exit();
}

if($_REQUEST['act'] == 'do_quick_login' || $_REQUEST['act'] == 'do_bind_haveno'){
	$userinfo['tag'] = 1;
	if($_REQUEST['act'] == 'do_quick_login'){
		$userinfo['tag'] = 0;
	}
	if(ec_register($userinfo)){
		denglu_bind($userinfo);
		if(	$_REQUEST['act'] == 'do_bind_haveno'){
			$userinfo['email'] = $_REQUEST['email'];
			$userinfo['username'] = $_SESSION['user_name'];
			$userinfo['uid'] = $_SESSION['user_id'];
			$bind_r = $api->post_bind_info($userinfo);

			empty($bind_r['result']) && show_message('post failed');

			if($denglu_cache['denglu_login_syn']){
				$login_r = $api->post_login($userinfo['mediaUserID']);
				!$login_r['result'] && show_message($Dlang['post failed']);
			}
		}
	
		show_message($Dlang['denglu_login_success'],array($Dlang['back_to_home'],$Dlang['show_my_info']),array('index.php','user.php'),'info');
	}
	show_message($Dlang['denglu_failed'],$Dlang['back_to_home'],'index.php','error',0);
}

if($_REQUEST['act'] == 'do_bind_have'){
	if(ec_login()){
		$userinfo['tag'] = 1;
		$result = is_bind($userinfo['mediaUserID']);
		$result==1 && show_message($Dlang['denglu_bind_success'],$Dlang['back_to_home'],'index.php');
		$result==2 && show_message($Dlang['binded_with_other'],$Dlang['back_to_home'],'index.php');
		!$result && denglu_bind($userinfo); 
		
		$userinfo['email'] = $_SESSION['email'];
		$userinfo['username'] = $_SESSION['user_name'];
		$userinfo['uid'] = $_SESSION['user_id'];
		$bind_r = $api->post_bind_info($userinfo);

		empty($bind_r['result']) && show_message('post failed');

		if($denglu_cache['denglu_login_syn']){
			$login_r = $api->post_login($userinfo['mediaUserID']);
			!$login_r['result'] && show_message($Dlang['post failed']);
		}
		show_message($Dlang['denglu_bind_success'],$Dlang['back_to_home'],'index.php');
	}
	show_message($Dlang['denglu_bind_failed'],$Dlang['back_to_home'],'index.php','error',0);
}

show_message($Dlang['undefined_action'],$Dlang['back_to_home'],'index.php','warning',0);






?>
