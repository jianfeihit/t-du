<?php
class extension
{
/*
 * php环境检测，检查版本
 *
 */
function Env()
{
	$env = array();
	$env['phpv'] = array('val' => PHP_VERSION, 'sp' => (PHP_VERSION > '5') ? 'w' : 'nw');
    return $env;
}


/**
 * 文件或目录权限检查函数
 *
 * @access          public
 * @param           string  $file_path   文件路径
 * @param           bool    $rename_prv  是否在检查修改权限时检查执行rename()函数的权限
 *
 * @return          int     返回值的取值范围为{0 <= x <= 15}，每个值表示的含义可由四位二进制数组合推出。
 *                          返回值在二进制计数法中，四位由高到低分别代表
 *                          可执行rename()函数权限、可对文件追加内容权限、可写入文件权限、可读取文件权限。
 */
function file_mode_info($file_name)
{
	foreach ($file_name as $file_path){
    $mark = 0;
	
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
    {
        /* 如果是目录 */
        if (is_dir($file_path))
        {
            /* 检查目录是否可读 */
            $dir = @opendir($file_path);
            if ($dir === false)
            {
                return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
            }
            if (@readdir($dir) !== false)
            {
                $mark ^= 1; //目录可读 001，目录不可读 000
            }
            @closedir($dir);
            /* 检查目录是否可写 */
            $fp = @fopen($test_file, 'wb');
            if ($fp === false)
            {
                $mark ^= 1; //如果目录中的文件创建失败，返回不可写。
            }
            if (@fwrite($fp, 'directory access testing.') !== false)
            {
                $mark ^= 2; //目录可写可读011，目录可写不可读 010
            }
            @fclose($fp);
            @unlink($test_file);
            /* 检查目录是否可修改 */
            $fp = @fopen($test_file, 'ab+');
            if ($fp === false)
            {
                $mark ^= 1;
            }
            if (@fwrite($fp, "modify test.\r\n") !== false)
            {
                $mark ^= 4;
            }
            @fclose($fp);
            /* 检查目录下是否有执行rename()函数的权限 */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
            @unlink($test_file);
        }
        /* 如果是文件 */
        elseif (is_file($file_path))
        {
            /* 以读方式打开 */
            $fp = @fopen($file_path, 'rb');
            if ($fp)
            {
                $mark ^= 1; //可读 001
            }
            @fclose($fp);
            /* 试着修改文件 */
            $fp = @fopen($file_path, 'ab+');
            if ($fp && @fwrite($fp, '') !== false)
            {
                $mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
            }
            @fclose($fp);
            /* 检查目录下是否有执行rename()函数的权限 */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
        }
    }
    else
    {
        if (@is_readable($file_path))
        {
            $mark ^= 1;
        }
        if (@is_writable($file_path))
        {
            $mark ^= 14;
        }
    }
    $file[]=array('path'=>$file_path,'value'=>$mark);
}
return $file;
}




/*
 * 检测php函数是否开启
 *
 */
function FunctionTest($list)
{
    $return = array();
    foreach ($list as $i => $func)
    {
    	$sp = function_exists($func) ? 'w' : 'nw';
        $return[] = array(
            'name' => $func,
            'sp' => $sp 
        );
        
    }
    return $return;
}


/*
 * 检查文件权限（是否可写）
 *
 */
function FilePermission($dir){
	define('R_P',str_replace('modules'.DIRECTORY_SEPARATOR.'denglu','',dirname(__FILE__)));
	$path = R_P.$dir;
	$fp = opendir($path);
	$return = array();
	while (false != $file = readdir($fp))
	{
		if (substr($file, -4) == '.php')
		{
			$result = array(
				'path' => $dir.$file
			);
			if (@touch($path.$file))
			{
				$result['rw'] = 'w';
			}
			else
			{
				$result['rw'] = 'nw';
			}
			$result['rw'] || $return[] = $result;
		}
	}
	return $return;
}


function fileP($filelist){
	define('R_P',str_replace('modules'.DIRECTORY_SEPARATOR.'denglu','',dirname(__FILE__)));
	$return  = array();
	foreach($filelist as $file){
		$result = array();
		$result['path'] = $file;
		if(is_writeable(R_P.$file)){
			$result['rw'] = 'w';
		}else{
			$result['rw'] = 'nw';
		}
		$return[] = $result;
	}
	return $return;
}

function write_files($file){///////
//define('R_P',str_replace('modules'.DIRECTORY_SEPARATOR.'denglu','',dirname(__FILE__)));
	$return = array();
	
	foreach($file as $v){
		$str = '';
		$str = file_get_contents(R_P.$v['n']);
		$mark = empty($v['tag']) ? '<!--denglu___mark-->' : '/*denglu___mark*/';
		$pre_mark = empty($v['pre']) ? $mark : '';
		$last_mark = empty($v['last']) ? $mark : '';
		$end_str = empty($v['sort']) ? $v['f'].$v['r'] : $v['r'].$v['f'];
		if(preg_match("/denglu___mark/",$str)){
			$v['ret'] = '修改成功';
		}else{
			$str1 = str_replace($v['f'],$pre_mark.$end_str.$last_mark,$str);
			file_put_contents(R_P.$v['n'],$str1);
			$str2 = file_get_contents(R_P.$v['n']);
			if($str2==$str){
				$v['ret'] = '修改失败';
				!defined('ERROR') && define('ERROR','以上操作如有任何失败,请记录错误然后到http://bbs.denglu.cc查看解决办法');
			}else{
				$v['ret'] = '修改成功';
				
			}
		}
		
		$return[] = $v;
	}
	return $return;
}

/*
 * 复制denglu.php，dl_receiver.php 到跟目录
 *
 * 
 *
 */
function denglu_copy($files){
	foreach($files as $v){
		copy('install/'.$v['f'],$v['s']);
		if(file_exists($v['s'])){ 
			$v['r'] = '复制成功';
		}else{
			$v['r'] = '复制失败';
			!defined('ERROR') && defined('ERROR','以上操作如有任何失败,请记录错误然后到http://bbs.denglu.cc查看解决办法');
		}
		$return[] = $v;
	}
	return $return;
}


function dl_a($a='001'){
	echo '<script>alert("'.$a.'")</script>';

}



/*
 * 获取标准时间的时间戳
 */
function GetStandardTimestamp(){
	$fp=fsockopen('ntp.glb.nist.gov',13,$errno,$errstr,90);
    $fread = fread($fp,date('Y'));
	$i=0;
	for($i=0;$i<=5;$i++){
		if(empty($fread)){

			$fp=fsockopen('time.nist.gov',13,$errno,$errstr,90);
			$fread = fread($fp,date('Y'));
		}else{
			
			$fread = $fread;
		
		}
	}

    $ufc = explode(' ',$fread);
    $date = explode('-',$ufc[1]);
    $processdate = $date[1].'-'.$date[2].'-'. date('Y').' '.$ufc[2];

    switch($ufc[5])  
    {  
        case 0: $timestamp_info = '精确'; break;  
      
        case 1: $timestamp_info = '误差：0-5s'; break;    
      
        case 2: $timestamp_info = '误差： > 5s'; break;  
      
        default: $timestamp_info = '硬件出错！'; break;  
    }  
      
    $aa =  $this->gmttolocalTimestmap($processdate,8); // 中国  
    return $aa; 

}




/*
 * 测试appid，appkey,是否正确
 */
function testAppID($path,$appid,$appkey,$charset){

	//echo $path,$appid,$appkey,$charset;die; 
	require_once($path);
	$token = 'bcca278ef3381e171448d47dfc207dca';
	/*
	 *初始化接口类Denglu
	 */
	$api = new Denglu(trim($appid),trim($appkey),$charset);
	//var_dump($api);die;
	/*
	 *调用接品类相关方法获取媒体用户信息示例
	 */
	try{
		$userinfo = $api->getUserInfoByToken($token);
	}catch(DengluException $e){//获取异常后的处理办法(请自定义)
	//echo $e->geterrorCode();die;
		if($e->geterrorCode()==40002){
			return '1';
		}elseif($e->geterrorCode()==40105){
			return '2';
		}else{
			return '3';
		}
	}



}
//调整服务器时间写入文件时间差
function write_time($time_dif){
	$fp = fopen(dirname(__FILE__).'/saveTimestamp.php','wb');
	$str = "<?php\r\n \$saveTimestamp = ".var_export($time_dif,1)."\r\n\n?>";
	fwrite($fp,$str);
	return true;
}

/*
 * 更新图片信息
 *
 * $path   ----Denglu类文件路径
 * $path_denglu_cache   ----denglu_cache.php文件路径
 * $path_denglu_data    ----denglu_data.php文件路径
 * $pathImg     ----图片存放路径  
 * $charset   ----编码
 *
 */
function updateImg($path,$path_denglu_cache,$path_denglu_data,$pathImg,$charset){
	
	include './denglu_cache.php';
	/*
	 *初始化接口类Denglu
	 */
	// echo $denglu_cache['app_id'],$denglu_cache['app_key'],$charset;die;
	$api = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],$charset);
	
	/*
	 *调用接品类相关方法获取媒体用户信息示例
	 */
	
	try{
		$denglu_data = $api->getMedia();
		if(!is_array($denglu_data)){
			$denglu_data = array();
		}
		if(is_writeable(dirname(__FILE__))){
	
		     $str = "<?php\r\n \$denglu_data = ".var_export($denglu_data,1)."\r\n\n?>";
	
			if($fp = fopen($path_denglu_data,'wb')){
				fwrite($fp,$str);
			}
	
	    }
		if(!is_array($denglu_data)){
			exit('network failed or data error');
		}
		  foreach($denglu_data as $v){
		  	if(!file_exists('themes/images/denglu_second_'.$v['mediaID'].'.png') || 
		  	   !file_exists('themes/images/denglu_second_icon_'.$v['mediaID'].'.gif') || 
		  	   !file_exists('themes/images/denglu_second_icon_no_'.$v['mediaID'].'.gif'))
		  	   {
		  			
				copy($v['mediaImage'],'themes/images/denglu_second_'.$v['mediaID'].'.png');
				copy($v['mediaIconImageGif'],'themes/images/denglu_second_icon_'.$v['mediaID'].'.gif');
				copy($v['mediaIconNoImageGif'],'themes/images/denglu_second_icon_no_'.$v['mediaID'].'.gif');

		  	}
		 
		}
	}catch(DengluException $e){//获取异常后的处理办法(请自定义)
		echo $e->geterrorCode();
	}

}


/*
 * 检测图片信息是否齐全
 *
 * $pathImg    图片存放的路径
 *
 */
function testImg($pathImg){
		//判断图片是否齐全
		$file_name = $this->read_files_name($pathImg);
		include './pic_name.php';
		$pic_intersect = array_intersect($pic_name,$file_name);
		$diff_array = array_diff($pic_name,$pic_intersect);
		$pic_pd = empty($diff_array);
		return $pic_pd;
	
		
}

function read_files_name($dir){
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) {
	        	$file_names[]= $file;
	        }
	        closedir($dh);
	     }
	     return $file_names;
	}
}


/*
 * 保存appid,appkey 到文件
 *
 * $path_denglu_cache    denglu_cache.php文件存放的路径
 * $denglu_cache        要保存的appkey数据
 *
 */
function saveAppkey($path_denglu_cache,$denglu_cache){
	$fp = fopen($path_denglu_cache,'wb');
	$str = "<?php\r\n \$denglu_cache = ".var_export($denglu_cache,1)."\r\n\n?>";
	fwrite($fp,$str);
	return true;

}

/**
 * 判断文件是否存在
 *
 */
function _isFind($filename) {
    return file_exists($filename);
}

/**
 * 判断文件夹是否存在? 简单处理： 仅对根目录进行判断
 *
 */
function _isFindDir($dir) {
    $ls = scandir(dirname(__FILE__));
    foreach ($ls as $val) {
        if ($val == $dir) return TRUE;
    }
    return FALSE;
}

/**
 * 复制或移动
 *
 * @param   array   源文件夹数组: 简单处理：采用文件名作为元素值
 * @param   string  目的文件夹
 * @param   string  操作数： move - 移动 ; copy - 复制
 * @return  bool
 */
function _copy_move($src = array(), $dst = '', $op = 'move') {
    if ( ! is_array($src)) {
        $src = array($src);
    }

    //判断源文件是否存在?
    foreach ($src as $val) {
        if ( $this->_isFind($val) === FALSE) {
        	
           // return $this->_log('Src file not find', $val);
        }
    }

    //判断目的文件夹是否存在? 如果不存在就生成
    //简单处理： 实际应用需要修改
    if ($this->_isFindDir($dst) === FALSE) {
        @mkdir($dst);
    }

    //执行移动或复制操作
    foreach ($src as $val) {
        $_dst = $dst.'/'.basename($val);

        //判断目的文件是否存在? 存在不允许进行操作
        if ($this->_isFind($_dst) === TRUE) {
           // return $this->_log('Dst file is exists', $dst);
        } else if (strpos($dst, $val) === 0) {
          //  return $this->_log('Unable to copy/move into itself');
        }

        if (strtolower($op) === 'move') {
            if ( ! rename($val, $_dst)) {
               // return $this->_log('Unable to move files', $val);
            }
        } else if (strtolower($op) === 'copy') {
            if ( ! $this->_copy($val, $_dst)) {
                //return $this->_log('Unable to copy files', $val);
            }
        }
    }
    return 'Success!';
}

/**
 * 复制操作
 *
 */
function _copy($src, $dst) {
    if ( ! is_dir($src)) {
        if ( ! copy($src, $dst)) {
           // return $this->_log('Unable to copy files', $src);
        }
    } else {
        mkdir($dst);
        $ls = scandir($src);

        for ($i = 0; $i < count($ls); $i++) {
            if ($ls[$i] == '.' OR $ls[$i] == '..') continue;

            $_src = $src.'/'.$ls[$i];
            $_dst = $dst.'/'.$ls[$i];

            if ( is_dir($_src)) {
                if ( ! $this->_copy($_src, $_dst)) {
                  //  return $this->_log('Unable to copy files', $_src);
                }
            } else {
                if ( ! copy($_src, $_dst)) {
                   // return $this->_log('Unable to copy files', $_src);
                }
            }
        }
    }
    return TRUE;
}

/**
 * 日志记录
 *
 */
function _log($msg, $arg = '') {
    if ($arg != '') {
        $msg = "date[".date('Y-m-d H:i:s')."]\tmsg[".$msg."]\targ[".$arg."]\n";
    } else {
        $msg = "date[".date('Y-m-d H:i:s')."]\tmsg[".$msg."]\n";
    }
    echo $msg;
    return @file_put_contents('copy.log', $msg, FILE_APPEND);
}


/**
 * 添加登录数据库
 *
 */
function denglu_run_sql($sql,$config){
	mysql_connect($config['settings']['db_host'].':'.$config['settings']['db_port'],$config['settings']['db_user'],$config['settings']['db_pass']);
	mysql_select_db($config['settings']['db_name']);
	mysql_query('set names '.$config['settings']['charset']);
	return mysql_query($sql);
}




function gmttolocal($mydate,$mydifference){
	
	$datetime = explode(" ",$mydate);  
	$dateexplode = explode("-",$datetime[0]);  
	$timeexplode = explode(":",$datetime[1]);  
	$unixdatetime = mktime($timeexplode[0]+$mydifference,$timeexplode[1],$timeexplode[2],$dateexplode[0],$dateexplode[1],$dateexplode[2]);  
	return date('Y-m-d H:i:s',$unixdatetime);  
}  




function gmttolocalTimestmap($mydate,$mydifference){
	
	$datetime = explode(" ",$mydate);  
	$dateexplode = explode("-",$datetime[0]);  
	$timeexplode = explode(":",$datetime[1]);  
	$unixdatetime = mktime($timeexplode[0]+$mydifference,$timeexplode[1],$timeexplode[2],$dateexplode[0],$dateexplode[1],$dateexplode[2]);  
	return $unixdatetime;  
} 




}
?>