<?php

require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');
if(empty($_REQUEST['op'])){
	$_REQUEST['op'] = false;
}

$user_id = $_SESSION['user_id'];
if($user_id==0){
	header('location:user.php?act=login');
}
$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);
$smarty->assign('op',$_REQUEST['op']);
assign_template();
    $position = assign_ur_here(0, $_LANG['user_center']);
    $smarty->assign('page_title', $position['title']); // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);
    $sql = "SELECT value FROM " . $ecs->table('shop_config') . " WHERE id = 419";
    $row = $db->getRow($sql);
    $car_off = $row['value'];
    $smarty->assign('car_off',       $car_off);
    
    $smarty->assign('helps',      get_shop_help());        // 网店帮助
    $smarty->assign('data_dir',   DATA_DIR);   // 数据目录
    $smarty->assign('action',     $action);
    $smarty->assign('lang',       $_LANG);

	if($_REQUEST['op'] == false){////////显示绑定页面
		$bind_users = get_bind_users($_SESSION['user_id']);
		$check_media = check_media($bind_users,$denglu_data);
		
		if(count($bind_users)==1 && $bind_users[0]['tag']==0){
			$_SESSION['mediaUserID'] = $bind_users[0]['mediaUserID'];
			$check_media = array();
		}
		$smarty->assign('bind_users',$bind_users);
		$smarty->assign('check_media',$check_media);

		$smarty->display('denglu_user.dwt');
	}

	if($_REQUEST['op'] == 'unbind' && !empty($_REQUEST['mediaUserID']) && !empty($_SESSION['user_id'])){/////////////在线解绑
		$ubind = denglu_unbind($_REQUEST['mediaUserID']);

		empty($ubind['result']) && show_message($Dlang['post_failed']);
		show_message($Dlang['denglu_unbind_success'],$Dlang['show_my_info'],'denglu.php?act=dl_user');
	}

	if($_REQUEST['op'] == 'olbind' && !empty($_SESSION['user_id']) && !empty($_REQUEST['mid'])){//////////在线绑定跳转
		$_SESSION['dl_olbind'] = 1;
		header('location:http://open.denglu.cc/transfer/'.$_REQUEST['mid'].'?appid='.$denglu_cache['denglu_appid'].'&uid='.$_SESSION['user_id']);
	}

	if($_REQUEST['op'] == 'set'){///////显示分享设置
		$bind_users = get_bind_users($_SESSION['user_id']);
		foreach($bind_users as $m){
			if($denglu_data[$m['mediaID']]['shareFlag']){
				continue;
			}
			$m['mediaName'] = $denglu_data[$m['mediaID']]['mediaName'];
			$bindusers[] = $m;
		}
		if(count($bind_users)==1 && $bind_users[0]['tag']==0){
			$_SESSION['mediaUserID'] = $bind_users[0]['mediaUserID'];
			$bindusers = array();
		}

		$smarty->assign('bind_users',$bind_users);
		$smarty->assign('bindusers',$bindusers);
		$smarty->display('denglu_user.dwt');
	}

	if($_REQUEST['op'] == 'save' && !empty($_SESSION['user_id'])){//////////保存设置
		denglu_userset($_SESSION['user_id']);
		
		show_message($Dlang['setting_success'],$Dlang['show_my_info'],'denglu.php?act=dl_user&op=set');
	}
	
	if($_REQUEST['op'] == 'olbind_have'){///////显示绑定已有用户页
		$smarty->display('denglu_user.dwt');
	} 

	if($_REQUEST['op'] == 'olbind_haveno'){///显示绑定新用户页
		$smarty->display('denglu_user.dwt');
	} 

	if($_REQUEST['op'] == 'olbind_do_have' && !empty($_SESSION['mediaUserID'])){///////绑定已有用户提交页
		if(ec_login() && !isbind($_SESSION['mediaUserID'])){

			if(!olbind($_SESSION['mediaUserID'])){
				show_message($Dlang['denglu_bind_failed'],$Dlang['show_my_info'],'denglu.php?act=dl_user');
			}
			
			$bind_r = $api->post_bind_info(array('mediaUserID'=>$_SESSION['mediaUserID'],'uid'=>$_SESSION['user_id'],'username'=>$_REQUEST['username'],'email'=>$_SESSION['email']));
			empty($bind_r['result']) && show_message('post failed');
			
			show_message($Dlang['denglu_bind_success'],$Dlang['show_my_info'],'denglu.php?act=dl_user');
		}
		show_message($Dlang['denglu_bind_failed'],$Dlang['show_my_info'],'denglu.php?act=dl_user');

	} 

	if($_REQUEST['op'] == 'olbind_do_haveno' && !empty($_SESSION['mediaUserID'])){/////////绑定新用户提交页
		if(ec_register() && !isbind($_SESSION['mediaUserID'])){
			if(!olbind($_SESSION['mediaUserID'])){
				show_message($Dlang['denglu_bind_failed'],$Dlang['show_my_info'],'denglu.php?act=dl_user');
			}
			$bind_r = $api->post_bind_info(array('mediaUserID'=>$_SESSION['mediaUserID'],'uid'=>$_SESSION['user_id'],'username'=>$_REQUEST['username'],'email'=>$_REQUEST['email']));
			empty($bind_r['result']) && show_message($Dlang['post failed']);
			show_message($Dlang['denglu_bind_success'],$Dlang['show_my_info'],'denglu.php?act=dl_user');
		}
	}

	if(	$_REQUEST['op'] == 'ajax' && !empty($_REQUEST['id'])){
		$syn_data_old = unserialize($_SESSION['syn_data']);
		foreach($syn_data_old as $sk => $sv){
			if($sv['mediaID'] == $_REQUEST['id']){
				$sv[$_REQUEST['type']] = $sv[$_REQUEST['type']]==0 ? 1 : 0;
				$back['onoff'] = $sv[$_REQUEST['type']];
				$back['id'] = $sv['mediaID'];
				$syn_data_old[$sk] = $sv;
			}

		}
		$_SESSION['syn_data'] = serialize($syn_data_old);
		if(!empty($back)){
			echo json_encode($back);
		}else{
			echo '{"result":0}';
		}
	}

	if( $_REQUEST['op'] == 'ajax' && !empty($_REQUEST['content']) ){
		
		$syn_data_old = unserialize($_SESSION['syn_data']);
		foreach($syn_data_old as $sk => $sv){
			if($sv[$_REQUEST['type']] > 0){
				$muid[] = $sk;
			}
		}
		if(!empty($muid)){
			$muids = implode(',',$muid);
			$r = $api->pushfeed(array('muid'=>$muids,'uid'=>$_SESSION['user_id'],'content'=>substr($_REQUEST['content'],0,120).'...','url'=>urldecode($_REQUEST['url'])));
			$r['result'] && print('success');
		}
	}

	if($_REQUEST['op'] == 'ajax' && !empty($_REQUEST['share_goods']) ){
		$sql = "select goods_name from ".$ecs->table('goods')." where goods_id=".$_REQUEST['goods_id'];
		$dl_gname = $db->getOne($sql);
		
		$syn_data_old = unserialize($_SESSION['syn_data']);
		foreach($syn_data_old as $sk => $sv){
			if($sv[$_REQUEST['type']] > 0){
				$muid[] = $sk;
			}
		}
		if(!empty($muid)){
			$muids = implode(',',$muid);
			$r = $api->pushfeed(array('muid'=>$muids,'uid'=>$_SESSION['user_id'],'content'=>substr($dl_gname,0,120).'...','url'=>urldecode($_REQUEST['url'])));
			$r['result'] && print('success');
		}else{
			echo 'false';
		}
	}

	function isbind($muid){
		$sql = "select tag from ".$GLOBALS['ecs']->table('denglu_bind_info')." where mediaUserID=".$muid;
		$tag = $GLOBALS['db']->getOne($sql);

		return $tag;
	}

	function olbind($muid){
		$sql = "select mediaID from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid=".$_SESSION['user_id'];
		$r = $GLOBALS['db']->getRow($sql);

		$sql = "select mediaID from ".$GLOBALS['ecs']->table('denglu_bind_info')." where mediaUserID=".$muid;
		$mr = $GLOBALS['db']->getOne($sql);

		foreach($r as $v){
			if($r['mediaID']==$mr){
				show_message($GLOBALS['Dlang']['cannot_bind_same_media'],$GLOBALS['Dlang']['back_to_home'],'index.php','error',0);
			}
		}
		$sql = "update ".$GLOBALS['ecs']->table('denglu_bind_info')." set tag=1,uid=".$_SESSION['user_id']." where mediaUserID=".$muid;
		return $GLOBALS['db']->query($sql);
	}
	
?>
