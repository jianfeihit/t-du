<?php
class extension
{
/*
 * php������⣬���汾
 *
 */
function Env()
{
	$env = array();
	$env['phpv'] = array('val' => PHP_VERSION, 'sp' => (PHP_VERSION > '5') ? 'w' : 'nw');
    return $env;
}


/**
 * �ļ���Ŀ¼Ȩ�޼�麯��
 *
 * @access          public
 * @param           string  $file_path   �ļ�·��
 * @param           bool    $rename_prv  �Ƿ��ڼ���޸�Ȩ��ʱ���ִ��rename()������Ȩ��
 *
 * @return          int     ����ֵ��ȡֵ��ΧΪ{0 <= x <= 15}��ÿ��ֵ��ʾ�ĺ��������λ������������Ƴ���
 *                          ����ֵ�ڶ����Ƽ������У���λ�ɸߵ��ͷֱ����
 *                          ��ִ��rename()����Ȩ�ޡ��ɶ��ļ�׷������Ȩ�ޡ���д���ļ�Ȩ�ޡ��ɶ�ȡ�ļ�Ȩ�ޡ�
 */
function file_mode_info($file_name)
{
	foreach ($file_name as $file_path){
    $mark = 0;
	
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
    {
        /* �����Ŀ¼ */
        if (is_dir($file_path))
        {
            /* ���Ŀ¼�Ƿ�ɶ� */
            $dir = @opendir($file_path);
            if ($dir === false)
            {
                return $mark; //���Ŀ¼��ʧ�ܣ�ֱ�ӷ���Ŀ¼�����޸ġ�����д�����ɶ�
            }
            if (@readdir($dir) !== false)
            {
                $mark ^= 1; //Ŀ¼�ɶ� 001��Ŀ¼���ɶ� 000
            }
            @closedir($dir);
            /* ���Ŀ¼�Ƿ��д */
            $fp = @fopen($test_file, 'wb');
            if ($fp === false)
            {
                $mark ^= 1; //���Ŀ¼�е��ļ�����ʧ�ܣ����ز���д��
            }
            if (@fwrite($fp, 'directory access testing.') !== false)
            {
                $mark ^= 2; //Ŀ¼��д�ɶ�011��Ŀ¼��д���ɶ� 010
            }
            @fclose($fp);
            @unlink($test_file);
            /* ���Ŀ¼�Ƿ���޸� */
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
            /* ���Ŀ¼���Ƿ���ִ��rename()������Ȩ�� */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
            @unlink($test_file);
        }
        /* ������ļ� */
        elseif (is_file($file_path))
        {
            /* �Զ���ʽ�� */
            $fp = @fopen($file_path, 'rb');
            if ($fp)
            {
                $mark ^= 1; //�ɶ� 001
            }
            @fclose($fp);
            /* �����޸��ļ� */
            $fp = @fopen($file_path, 'ab+');
            if ($fp && @fwrite($fp, '') !== false)
            {
                $mark ^= 6; //���޸Ŀ�д�ɶ� 111�������޸Ŀ�д�ɶ�011...
            }
            @fclose($fp);
            /* ���Ŀ¼���Ƿ���ִ��rename()������Ȩ�� */
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
 * ���php�����Ƿ���
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
 * ����ļ�Ȩ�ޣ��Ƿ��д��
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
			$v['ret'] = '�޸ĳɹ�';
		}else{
			$str1 = str_replace($v['f'],$pre_mark.$end_str.$last_mark,$str);
			file_put_contents(R_P.$v['n'],$str1);
			$str2 = file_get_contents(R_P.$v['n']);
			if($str2==$str){
				$v['ret'] = '�޸�ʧ��';
				!defined('ERROR') && define('ERROR','���ϲ��������κ�ʧ��,���¼����Ȼ��http://bbs.denglu.cc�鿴����취');
			}else{
				$v['ret'] = '�޸ĳɹ�';
				
			}
		}
		
		$return[] = $v;
	}
	return $return;
}

/*
 * ����denglu.php��dl_receiver.php ����Ŀ¼
 *
 * 
 *
 */
function denglu_copy($files){
	foreach($files as $v){
		copy('install/'.$v['f'],$v['s']);
		if(file_exists($v['s'])){ 
			$v['r'] = '���Ƴɹ�';
		}else{
			$v['r'] = '����ʧ��';
			!defined('ERROR') && defined('ERROR','���ϲ��������κ�ʧ��,���¼����Ȼ��http://bbs.denglu.cc�鿴����취');
		}
		$return[] = $v;
	}
	return $return;
}


function dl_a($a='001'){
	echo '<script>alert("'.$a.'")</script>';

}



/*
 * ��ȡ��׼ʱ���ʱ���
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
        case 0: $timestamp_info = '��ȷ'; break;  
      
        case 1: $timestamp_info = '��0-5s'; break;    
      
        case 2: $timestamp_info = '�� > 5s'; break;  
      
        default: $timestamp_info = 'Ӳ������'; break;  
    }  
      
    $aa =  $this->gmttolocalTimestmap($processdate,8); // �й�  
    return $aa; 

}




/*
 * ����appid��appkey,�Ƿ���ȷ
 */
function testAppID($path,$appid,$appkey,$charset){

	//echo $path,$appid,$appkey,$charset;die; 
	require_once($path);
	$token = 'bcca278ef3381e171448d47dfc207dca';
	/*
	 *��ʼ���ӿ���Denglu
	 */
	$api = new Denglu(trim($appid),trim($appkey),$charset);
	//var_dump($api);die;
	/*
	 *���ý�Ʒ����ط�����ȡý���û���Ϣʾ��
	 */
	try{
		$userinfo = $api->getUserInfoByToken($token);
	}catch(DengluException $e){//��ȡ�쳣��Ĵ���취(���Զ���)
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
//����������ʱ��д���ļ�ʱ���
function write_time($time_dif){
	$fp = fopen(dirname(__FILE__).'/saveTimestamp.php','wb');
	$str = "<?php\r\n \$saveTimestamp = ".var_export($time_dif,1)."\r\n\n?>";
	fwrite($fp,$str);
	return true;
}

/*
 * ����ͼƬ��Ϣ
 *
 * $path   ----Denglu���ļ�·��
 * $path_denglu_cache   ----denglu_cache.php�ļ�·��
 * $path_denglu_data    ----denglu_data.php�ļ�·��
 * $pathImg     ----ͼƬ���·��  
 * $charset   ----����
 *
 */
function updateImg($path,$path_denglu_cache,$path_denglu_data,$pathImg,$charset){
	
	include './denglu_cache.php';
	/*
	 *��ʼ���ӿ���Denglu
	 */
	// echo $denglu_cache['app_id'],$denglu_cache['app_key'],$charset;die;
	$api = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],$charset);
	
	/*
	 *���ý�Ʒ����ط�����ȡý���û���Ϣʾ��
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
	}catch(DengluException $e){//��ȡ�쳣��Ĵ���취(���Զ���)
		echo $e->geterrorCode();
	}

}


/*
 * ���ͼƬ��Ϣ�Ƿ���ȫ
 *
 * $pathImg    ͼƬ��ŵ�·��
 *
 */
function testImg($pathImg){
		//�ж�ͼƬ�Ƿ���ȫ
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
 * ����appid,appkey ���ļ�
 *
 * $path_denglu_cache    denglu_cache.php�ļ���ŵ�·��
 * $denglu_cache        Ҫ�����appkey����
 *
 */
function saveAppkey($path_denglu_cache,$denglu_cache){
	$fp = fopen($path_denglu_cache,'wb');
	$str = "<?php\r\n \$denglu_cache = ".var_export($denglu_cache,1)."\r\n\n?>";
	fwrite($fp,$str);
	return true;

}

/**
 * �ж��ļ��Ƿ����
 *
 */
function _isFind($filename) {
    return file_exists($filename);
}

/**
 * �ж��ļ����Ƿ����? �򵥴��� ���Ը�Ŀ¼�����ж�
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
 * ���ƻ��ƶ�
 *
 * @param   array   Դ�ļ�������: �򵥴��������ļ�����ΪԪ��ֵ
 * @param   string  Ŀ���ļ���
 * @param   string  �������� move - �ƶ� ; copy - ����
 * @return  bool
 */
function _copy_move($src = array(), $dst = '', $op = 'move') {
    if ( ! is_array($src)) {
        $src = array($src);
    }

    //�ж�Դ�ļ��Ƿ����?
    foreach ($src as $val) {
        if ( $this->_isFind($val) === FALSE) {
        	
           // return $this->_log('Src file not find', $val);
        }
    }

    //�ж�Ŀ���ļ����Ƿ����? ��������ھ�����
    //�򵥴��� ʵ��Ӧ����Ҫ�޸�
    if ($this->_isFindDir($dst) === FALSE) {
        @mkdir($dst);
    }

    //ִ���ƶ����Ʋ���
    foreach ($src as $val) {
        $_dst = $dst.'/'.basename($val);

        //�ж�Ŀ���ļ��Ƿ����? ���ڲ�������в���
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
 * ���Ʋ���
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
 * ��־��¼
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
 * ��ӵ�¼���ݿ�
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