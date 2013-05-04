<?php
define('IN_ECS', true);


$_SERVER['HTTP_REFERER'] = null;

include dirname(dirname(dirname(__FILE__))).'/admin/includes/init.php';
include 'config.php';
$smarty->template_dir = DENGLU_PATH.'themes';
//$smarty->template_dir = '../../admin/templates';

///////////////show 设置
if($_REQUEST['act']=='setting'){	
	require 'lib/denglu_cache.php';
	$arr_cache[] = show_onoff('denglu_top',$denglu_cache['denglu_top'],$Dlang['denglu_top'],$Dlang['denglu_top_comment']);
	$arr_cache[] = show_onoff('denglu_force_bind',$denglu_cache['denglu_force_bind'],$Dlang['denglu_force_bind'],$Dlang['denglu_force_bind_comment']);
	$arr_cache[] = show_onoff('denglu_login_syn',$denglu_cache['denglu_login_syn'],$Dlang['denglu_login_syn'],$Dlang['denglu_login_syn_comment']);
//	$arr_cache[] = show_onoff('denglu_ignore_checkmail',$denglu_cache['denglu_ignore_checkmail'],$Dlang['denglu_ignore_checkmail'],$Dlang['denglu_ignore_checkmail_comment']);
//	$arr_cache[] = show_onoff('denglu_syn_source',$denglu_cache['denglu_syn_source'],$Dlang['denglu_syn_source'],$Dlang['denglu_syn_source_comment']);
	$arr_cache[] = show_onoff('denglu_syn_goods',$denglu_cache['denglu_syn_goods'],$Dlang['denglu_syn_goods'],$Dlang['denglu_syn_goods_comment']);
	$arr_cache[] = show_onoff('denglu_syn_comment',$denglu_cache['denglu_syn_comment'],$Dlang['denglu_syn_comment'],$Dlang['denglu_syn_comment_comment']);
	$arr_cache[] = show_input('denglu_appid',$denglu_cache['denglu_appid'],$Dlang['denglu_appid'],$Dlang['denglu_appid_comment']);
	$arr_cache[] = show_input('denglu_appkey',$denglu_cache['denglu_appkey'],'APPKEY',$Dlang['denglu_appkey_comment']);
	
	$smarty->assign('ur_here',$Dlang['denglu_setting']);
	$smarty->assign('arr_cache',$arr_cache);
}
///////////保存设置 
if($_REQUEST['act']=='do_setting'){
	unset($_POST['submit']);unset($_POST['reset']);
	$denglu_cache = $_POST;
	!is_writeable(dirname(__FILE__).'/lib') && exit($Dlang['lib_cannot_write']);
	$str = "<?php\r\n \$denglu_cache = ".var_export($denglu_cache,1)."\r\n\n?>";
	
	if($fp = fopen(dirname(__FILE__).'/lib/denglu_cache.php','wb')){
		fwrite($fp,$str);
	}

	clear_all_files();	
    showMsg($Dlang['save_success'], 'admin.php?act=setting');
}
//////////列出用户
if($_REQUEST['act']=='user'){
	//admin_priv('denglu_manage');
    $user_list = get_media_user();
	if(empty($user_list)){
		$user_list=array();
	}

    $smarty->assign('user_list',$user_list);
	$smarty->assign('ur_here',$Dlang['denglu_user']);
}

if($_REQUEST['act']=='del_user' && !empty($_REQUEST['id'])){
	$sql = "select tag from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid='$_REQUEST[id]'";
	$ret = $GLOBALS['db']->getOne($sql);
	$sql = "delete from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid='$_REQUEST[id]'";
	$r = $GLOBALS['db']->query($sql);
	if($r && $ret){
		$ubindall = $api->post_unbind_all($_REQUEST[id]);
		empty($ubindall['result']) && exit('false');
		echo $_REQUEST['id'];exit();
	}elseif( $r && !$ret){
		echo $_REQUEST['id'];exit();
	}else{
		echo '';exit();
	}
}
//////////数据转换
if($_REQUEST['act']=='dswitch'){
	$smarty->assign('ur_here',$Dlang['denglu_dswitch']);
}

if($_REQUEST['act']=='do_dswitch'){
	$sql = "desc ".$GLOBALS['ecs']->table('users');
	$fields = $GLOBALS['db']->getAll($sql);
	foreach($fields as $f){
		$Fields[] = $f['Field'];
	}
	if(!in_array('mediaID',$Fields) || !in_array('mediaUID',$Fields)){
		exit($Dlang['old_switch_failed']);
	}
	$sql = "select user_id,user_name,reg_time,mediaUID,mediaID from ".$GLOBALS['ecs']->table('users')." where mediaID>0 limit 0,10";
	$result = $GLOBALS['db']->getAll($sql);
	if(empty($result)){
		showMsg($Dlang['old_data_all_switch'],'admin.php?act=dswitch');
	}
	$i=0;
	foreach($result as $v){
		$sql = "select * from ".$GLOBALS['ecs']->table('denglu_bind_info')." where mediaUserID=".$v['mediaUID'];
		if($db->getOne($sql)){
			continue;
		}
		$sql = "insert into ".$GLOBALS['ecs']->table('denglu_bind_info')." (`uid`,`mediaUserID`,`mediaID`,`createtime`,`screenName`,`is_first`,`tag`) values('$v[user_id]','$v[mediaUID]','$v[mediaID]','$v[reg_time]','$v[user_name]',1,0)";
		$db->query($sql);
		$sql = "update ".$ecs->table('users')." set mediaID=0";
		$db->query($sql);
		$i++;	
	}
	showMsg($i.$Dlang['old_data_switch_success'],'admin.php?act=do_dswitch');
}
/////////show 媒体信息
if($_REQUEST['act']=='mediainfo'){
	require 'lib/denglu_data.php';
	if(empty($denglu_data)){
		$dl_data=array();
	}
	foreach($denglu_data as $v){
		$dl_data[$v[mediaName]] = $v;
	}
	$smarty->assign('denglu_data',$dl_data);
	$smarty->assign('ur_here',$Dlang['denglu_mediainfo']);
}

if($_REQUEST['act']=='delete' && !empty($_REQUEST['id'])){
	$sql = "delete from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid=".$_REQUEST['id'];
	$GLOBALS['db']->query($sql);
	
	showMsg($Dlang['deleted'], 'admin.php?act=user');
}

//////获得媒体信息
if($_REQUEST['act']=='do_mediainfo'){

		include 'Denglu.php';
    	include 'lib/denglu_cache.php';
    	$DL = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],'utf');
    	//*******************************************************获得媒体信息
			//$dengl_data = $DL->getMedia();//获取媒体信息
			try{
				$dengl_data = $DL->getMedia();
			}catch(DengluException $e){
				//处理办法同上
				echo $e->geterrorDescription();  //返回错误信息
				showMsg('', 'admin.php?act=setting');
			}
			
			
			if(empty($dengl_data) || !is_array($dengl_data)){
				$dengl_data = array();
			}
			$str = "<?php\r\n \$denglu_data = ".var_export($dengl_data,1)."\r\n\n?>";
			
			if($fp = fopen(dirname(__FILE__).'/lib/denglu_data.php','wb')){
				fwrite($fp,$str);
			}
			
			foreach($dengl_data as $v){
			//	if(!file_exists('themes/images/denglu_second_'.$v['mediaID'].'.png')){
					
					copy($v['mediaImage'],'themes/images/denglu_second_'.$v['mediaID'].'.png');
					copy($v['mediaIconImageGif'],'themes/images/denglu_second_icon_'.$v['mediaID'].'.gif');
					copy($v['mediaIconNoImageGif'],'themes/images/denglu_second_icon_no_'.$v['mediaID'].'.gif');
			//	}
			}
			//*****************************************************************************************************end
	
	/**
	$denglu_data = $api->get_media_data();
	if(!is_array($denglu_data)){
		$denglu_data = array();
	}
	!is_writeable(dirname(__FILE__).'/lib') && exit($Dlang['lib_cannot_write']);
	$str = "<?php\r\n \$denglu_data = ".var_export($denglu_data,1)."\r\n\n?>";
	
	if($fp = fopen(dirname(__FILE__).'/lib/denglu_data.php','wb')){
		fwrite($fp,$str);
	}
	if(!is_array($denglu_data)){
		exit('network failed or data error');
	}	
	foreach($denglu_data as $v){	
		if(!file_exists('themes/images/denglu_second_'.$v['mediaID'].'.gif')){
			copy(substr($v['mediaImage'],0,-4).'.gif','themes/images/denglu_second_'.$v['mediaID'].'.gif');
			copy(substr($v['mediaIconImage'],0,-4).'.gif','themes/images/denglu_second_icon_'.$v['mediaID'].'.gif');
			copy(substr($v['mediaIconNoImage'],0,-4).'.gif','themes/images/denglu_second_icon_no_'.$v['mediaID'].'.gif');
		}
	}
	*/
    showMsg($Dlang['get_media_success'], 'admin.php?act=mediainfo');
}

$smarty->display('admin.htm');





function show_onoff($name,$value,$title,$comment){
	global $Dlang;
	$yes = $no = '';
	if($value){
		$yes = 'checked';
	}else{
		$no = 'checked';
	}
	return "<tr><td class='label'>".$title."</td><td><input type='radio' name=".$name." value='1' ".$yes.">".$Dlang['yes']."<input type='radio' name=".$name." value='0' ".$no.">".$Dlang['no']."<br><span style='display:block' class='notice-span'>".$comment."</span></td></tr>";
}
function show_input($name,$value,$title,$comment){
	return "<tr><td class='label'>".$title."</td><td><input type='test' name=".$name."  size='40' value='".$value."'><br><span style='display:block' class='notice-span'>".$comment."</span></td></tr>";
}
function showMsg($msg,$url=false){
	global $Dlang;
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><div><p>'.$msg.'</p>';
	if($url!=false){
		echo '<p class="alert_btnleft"><a href="'.$url.'">'.$Dlang['jump_tip'].'</a></p>';
		echo '<script type="text/javascript" reload="1">setTimeout("window.location.href =\''.$url.'\';", 3000);</script>';
	}
	echo '</div>';
	exit();
}

function get_media_user()
{
	///select * from users where user_name like '%%';
	$sql = "select distinct uid from " .$GLOBALS['ecs']->table('denglu_bind_info');
	$r = $GLOBALS['db']->getAll($sql);
	//var_dump($r);die;
	foreach($r as $v){
		$arr[] = $v['uid'];
	}
	if(empty($arr)) return array();
	
	$uids = '('.implode(',',$arr).')';
	$where = " where user_id in $uids ";

	if(count($arr)==1){
		$where = " where user_id=".$arr[0]." ";	
	}
	$url = 'admin.php?act=user&';
	if($_REQUEST['username']){
		$username = trim($_REQUEST['username']);
		$where  .= " and user_name like '%$username%'";
		$url .= 'username='.$username.'&';
	}
	$start = max(0,($_REQUEST['page']-1)*10);

	$limit = "limit $start ,10";
	$count = $GLOBALS['db']->getOne("select count(*) from ".$GLOBALS['ecs']->table('users') .$where);
	//$count = $count[0];
	
	$filter['prev'] = $url.'page='.max(1,$page-1);
	$filter['next'] = $url.'page='.min($page+1,ceil($count/10));
	$filter['first'] = $url.'page=1';
	$filter['last'] = $url.'page='.ceil($count/10);
	
	$sql = "select user_id,user_name from ".$GLOBALS['ecs']->table('users') .$where.$limit;
	$ecs_user = $GLOBALS['db']->getAll($sql);
	
	if(empty($ecs_user)) return array();

	$i = 0;
	foreach($ecs_user as $e_u){
		$sql = "select mediaID,createtime from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid={$e_u[user_id]} order by createtime";
		$e_u_a = $GLOBALS['db']->getAll($sql);
		$ecs_user[$i]['is_first'] = 'themes/images/denglu_second_icon_'.$e_u_a[0]['mediaID'].'.gif';
		$ecs_user[$i]['createtime'] = date('Y-m-d H:i:s',$e_u_a[0]['createtime']);
		array_shift($e_u_a);
		
		if(empty($e_u_a)){
			$i++;   
			continue;
		}
		
		$euev = array();
		foreach($e_u_a as $eua){
			$euav[] = '<img src="themes/images/denglu_second_icon_'.$eua['mediaID'].'.gif">';
		}
		$ecs_user[$i]['other'] = implode(',',$euav);
		$i++;	
	}

	$filter['list'] = $ecs_user;
	if(ceil($count/10)>1) $filter['page'] = true;
	return $filter;
		
}

?>
