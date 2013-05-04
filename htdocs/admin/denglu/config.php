<?php

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

error_reporting(0);
if(!defined('ROOT_PATH')){
 define('ROOT_PATH',dirname(dirname(dirname(__FILE__))));
}

define ('DENGLU_PATH',ROOT_PATH.'admin/denglu/');
define('DENGLU_URL','open');
if(strtolower(EC_CHARSET) =='utf-8'){
	require DENGLU_PATH.'lib/denglu.lang.utf8.php';
}else{
	require DENGLU_PATH.'lib/denglu.lang.gbk.php';
}

require_once DENGLU_PATH.'lib/denglu_cache.php';
require_once DENGLU_PATH.'lib/denglu_api.class.php';
$api = new denglu_api($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],EC_CHARSET);

require_once DENGLU_PATH.'lib/denglu_func.php';

$denglu_data = denglu_data();
if(!defined('INIT_NO_SMARTY') || INIT_NO_SMARTY==false){
	$smarty->assign('Dlang',$Dlang);
	$smarty->assign('denglu_data',$denglu_data);
	$smarty->assign('denglu_cache',$denglu_cache);
	$smarty->assign('act',$_REQUEST['act']);
	$smarty->assign('denglu_url',DENGLU_URL);
}
if($denglu_cache['denglu_top']==1 && empty($_SESSION['user_id'])){
	$denglu_top_logo = "<script type='text/javascript' charset='utf-8' src='http://open.denglu.cc/connect/logincode?appid=".$denglu_cache['denglu_appid']."&style=popup'></script>";
	
	if(!defined('INIT_NO_SMARTY') || INIT_NO_SMARTY==false){
		$smarty->assign('denglu_top_logo',$denglu_top_logo);
	}
}

if(!empty($_SESSION['user_id'])){
	$syn_data = get_bind_users($_SESSION['user_id']);
	if(count($syn_data)==1 && $syn_data[0][tag]==0){
		$unbind = true;
	}else{
		$unbind = false;
	}
	if(!defined('INIT_NO_SMARTY') || INIT_NO_SMARTY==false){
		$smarty->assign('unbind',$unbind);
	}
	foreach($syn_data as $d){
		if($denglu_data[$d['mediaID']]['shareFlag']==0 && $d['tag']==1){
			$new_syn_data[$d['mediaUserID']] = array('mediaID'=>$d['mediaID'],'thread_syn'=>$d['thread_syn'],'log_syn'=>$d['log_syn']);
		}
	}
	if(!defined('INIT_NO_SMARTY') || INIT_NO_SMARTY==false){
		$smarty->assign('syn_data',$new_syn_data);
		if($syn_data[0]['tag'] && !isset($_SESSION['syn_data']) ){
			$_SESSION['syn_data'] = serialize($new_syn_data);
		}
	}
}


?>
