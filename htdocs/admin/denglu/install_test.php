<?php 
include 'dl_chearset.php';
define('IN_ECS',true);

header("Content-Type: text/html; charset=utf-8");

if(EC_CHARSET=='utf-8'){
	//include 'denglu_lang.gbk.php';
	include 'denglu_lang.utf8.php';
}



$user_id = $_COOKIE['ECSCP']['admin_id'];
if($user_id !=1 ){
		 header("Content-Type: text/html; charset=utf-8");
		 $links = array(
            array('href' => '../privilege.php?act=logout', 'text' => '点击跳转')
        );
		sys_msg('超级管理员未登录不能进行此操作！',3,$links);//   ,'../privilege.php?act=logout'
		//show_message('超级管理员未登录不能进行此操作！','请登录超级管理员','../privilege.php?act=logout');
		exit;
	}

/**
$user_id = $_SESSION['user_id'];
if($user_id !=1 ){
		show_message('管理员未登录不能进行此操作！','请登录管理员','../admin/privilege.php?act=logout');
		exit;
	}
	
*/

include('Extension_class.php');
$install = new extension();
switch ($_GET['action']){
	case '':
	if(!empty($denglu_data)){
		header("Content-Type: text/html; charset=utf-8");
		$links = array(
            array('href' => '../../index.php', 'text' => '点击跳转')
        );
		sys_msg('您已经执行过了安装,请查看！',3,$links);//    ,'../index.php'
		//show_message('您已经执行过了安装,请查看！','点击返回','../index.php');
			exit;
		
		}
		 include('./themes/install/install/welcome.html');
		 break;
	case 'one':
		//检测PHP版本
		$php_v = $install->Env();
		//检测文件目录是否可写(不存在就是不可写)
		include 'file_name.php';
		$file_info = $install->file_mode_info($file_name);
		//检测函数
		include 'function_name.php';
		$function_info = $install->FunctionTest($list);
		include('./themes/install/install/env.html');
		break;
	case 'two':
		//检测服务器时间
		date_default_timezone_set('PRC');
		$str = file_get_contents("http://ntp.news.sohu.com/mtime.php");
		$str = substr($str,5);
		$arr = explode(",", $str);
		$formate = $arr[3].','.$arr[4].','.$arr[5].','.$arr[1].','.$arr[2].$arr[0];
		$standard = mktime($formate);
		$local = time();
		
		$filename = './saveTimestamp.php';
		if (file_exists($filename)) {
		include('./saveTimestamp.php');
		} else {
			$saveTimestamp = 0;
		
		} 


		$saveTimestamp = empty($saveTimestamp)?0:$saveTimestamp;
		$AdjustmentTime = $local+(int)$saveTimestamp;
		$time_dif =$standard-$AdjustmentTime;

		$time_cha = abs($time_dif);
		if($time_cha<=10*60){
			$time = 1;
		}else {
			$time = 0;
		}
		include('./themes/install/install/dbs.html');
		break;
	case 'put_key':
		//***************************************************保存KEY和ID
		$path_denglu_cache = 'lib/denglu_cache.php';
		$denglu_cache = $_POST;
		$denglu_cache['denglu_top'] = 1;
		$denglu_cache['denglu_force_bind'] = 0;
		$denglu_cache['denglu_login_syn'] = 1;
		$denglu_cache['denglu_syn_comment'] = 1;
		
		$install->saveAppkey($path_denglu_cache,$denglu_cache);
		//*************************************************************end
		header('Location:  ./install_test.php?action=three');
		
		break;
	case 'three':
	
		$filename = dirname(dirname(dirname(__FILE__))).'denglu.php';
		if (file_exists($filename)){
			
			$val  = 'w';
		}else{
			$val  = 'nw';
		}
		
		//社会化平台素材图片验证
		$pathImg = './themes/images/';
		$tb = $install->testImg($pathImg);
		
		//需要修改的文件
		include 'modify_file.php';
		include('./themes/install/install/config.html');
		break;
	case 'four':
		
		//安装文件
		include 'modify_file.php';//包含以前的安装文件
		$install_method = '';
		include('./themes/install/install/install.html');
		break;
	case 'hand':
		
			$install_method = $_GET['install_method'];
			include('./themes/install/install/install.html');
		
		break;
	case 'hand_into':
				
			//*******************************************************获得媒体信息
			$dengl_data = $Denglu->getMedia();//获取媒体信息
			
			if(empty($dengl_data) || !is_array($dengl_data)){
				$dengl_data = array();
			}
			$str = "<?php\r\n \$denglu_data = ".var_export($dengl_data,1)."\r\n\n?>";
			
			if($fp = fopen('lib/denglu_data.php','wb')){
				fwrite($fp,$str);
			}
			
			foreach($dengl_data as $v){
				if(!file_exists('themes/images/denglu_second_'.$v['mediaID'].'.png')){
					
					copy($v['mediaImage'],'themes/images/denglu_second_'.$v['mediaID'].'.png');
					copy($v['mediaIconImageGif'],'themes/images/denglu_second_icon_'.$v['mediaID'].'.gif');
					copy($v['mediaIconNoImageGif'],'themes/images/denglu_second_icon_no_'.$v['mediaID'].'.gif');
				}
			}
		
			//*****************************************************************************************************end
			
//*******************************************************************插入denglu_bind_info数据表
	include dirname(dirname(dirname(__FILE__))).'/includes/init.php';
if(is_writeable(dirname(dirname(__FILE__)).'/denglu') ){//***************如果安装标志文件存在则安装
	$sql = "select user_id,nav_list from ".$ecs->table('admin_user')." where action_list='all'";
	
	$res = $db->query($sql);
	while ($rows = $db->FetchRow($res))
    {
    	$nav_list = array();
        $nav_list = explode(',',$rows['nav_list']);
        $nav_list[] = '灯鹭|denglu/admin.php?act=setting';
        $nav_list = implode(',',$nav_list);
        $sql = "update ".$ecs->table('admin_user')." set nav_list='$nav_list' where user_id={$rows['user_id']}";
        $db->query($sql);
    }
    

    $sql = "CREATE TABLE IF NOT EXISTS ".$ecs->table('denglu_bind_info')." (";
    $sql .= <<<EOF
	`uid` int(11) unsigned NOT NULL,
	`mediaUserID` int(11) NOT NULL, 
	`mediaID` tinyint(1) NOT NULL,
	`screenName` char(250) NOT NULL,
	`createtime` int(10) NOT NULL,
	`is_first` tinyint(1) NOT NULL,
	`thread_syn` tinyint(1) NOT NULL,
	`log_syn` tinyint(1) NOT NULL,
	`tag` tinyint(1) NOT NULL,
	`extendfield1` tinyint(1) NOT NULL,
	`extendfield2` char(250) NOT NULL,
	`extendfield3` tinyint(1) NOT NULL,
	`extendfield4` char(250) NOT NULL,
	`extendfield5` tinyint(1) NOT NULL,
	PRIMARY KEY  (`mediaUserID`),
	KEY `dz_uid` (`uid`),
	KEY `mediaID` (`mediaID`)
) ENGINE=MyISAM;
EOF;
	$db->query($sql);
}
//*****************************************************************************************************end	
header('Location:  ../../index.php');
		
		break;
	case 'testing_appid':
		//检测APPID和APPKEY
		$fname = './Denglu.php';
		$appid = $_POST['denglu_appid'];
		$appkey = $_POST['denglu_appkey'];
		$chart = 'utf-8';
		$test_result = $install->testAppID($fname,$appid,$appkey,$chart);
		echo $test_result;
		break;
	case 'adjust_time':
		$time_dif = $_POST['time_dif'];
		$back = $install->write_time($time_dif);
		echo $back;
		break;
	case 'updateImg':
		 $install->updateImg('./Denglu.php','./lib/denglu_cache.php','./lib/denglu_data.php','./themes/images/','utf-8');
		 $tb = $install->testImg('./themes/images/');
		 echo $tb;
		 break;
}
?>