<?php
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

if(!function_exists('mb_convert_encoding')){
	function mb_convert_encoding($string,$to,$from)
	{
		if ($from == "UTF-8")
		$iso_string = utf8_decode($string);
		else
		if ($from == "UTF7-IMAP")
		$iso_string = imap_utf7_decode($string);
		else
		$iso_string = $string;

		if ($to == "UTF-8")
		return(utf8_encode($iso_string));
		else
		if ($to == "UTF7-IMAP")
		return(imap_utf7_encode($iso_string));
		else
		return($iso_string);
	}
}

if ( !function_exists('json_decode') ){
	function json_decode($json)
	{
		$comment = false;
		$out = '$x=';
	 
		for ($i=0; $i<strlen($json); $i++)
		{
			if (!$comment)
			{
				if (($json[$i] == '{') || ($json[$i] == '['))       $out .= ' array(';
				else if (($json[$i] == '}') || ($json[$i] == ']'))   $out .= ')';
				else if ($json[$i] == ':')    $out .= '=>';
				else                         $out .= $json[$i];         
			}
			else $out .= $json[$i];
			if ($json[$i] == '"' && $json[($i-1)]!="\\")    $comment = !$comment;
		}
		eval($out . ';');
		return $x;
	}
}

if (!function_exists('json_encode')){
	function json_encode($in) {
		$out = "";
		if (is_object($in)) {
			$class_vars = get_object_vars(($in));
			$arr = array();
			foreach ($class_vars as $key => $val) {
				$arr[$key] = "\"{$_escape($key)}\":\"{$val}\"";
			}
			$val = implode(',', $arr);
			$out .= "{{$val}}";
		}elseif (is_array($in)) {
			$obj = false;
			$arr = array();
			foreach($in AS $key => $val) {
				if(!is_numeric($key)) {
					$obj = true;
				}
				$arr[$key] = my_json_encode($val);
			}
			if($obj) {
				foreach($arr AS $key => $val) {
					$arr[$key] = "\"{$_escape($key)}\":{$val}";
				}
				$val = implode(',', $arr);
				$out .= "{{$val}}";
			}else {
				$val = implode(',', $arr);
				$out .= "[{$val}]";
			}
		}elseif (is_bool($in)) {
			$out .= $in ? 'true' : 'false';
		}elseif (is_null($in)) {
			$out .= 'null';
		}elseif (is_string($in)) {
			$out .= "\"".addcslashes($in, "\v\t\n\r\f\"\\/")."\"";
		}else {
			$out .= $in;
		}
		return "{$out}";
	}
}
function dl_conv($str,$to,$from){
	if(is_array($str)){
		foreach($str as $k => $v){
			$k = dl_conv($k,$to,$from);
			$v = dl_conv($v,$to,$from);
			$str[$k] = $v;
		}
	}else{
		return  mb_convert_encoding($str,$to,$from);
	}
	return $str;
}

function denglu_data(){
	require dirname(__FILE__).'/denglu_data.php';/////////////denglu_data.php和denglu_api.class.php在一个目录下

	foreach($denglu_data as $data){
		$arr[$data['mediaID']] = $data;
	}
	return $arr;
}

class denglu_api{
	var $charset;
	var $params = array();
	var $api_server = 'http://open.denglu.cc/api/v3/';
	
	function denglu_api($appid,$secret,$charset) {
		$this->param['appid'] = $appid;
		$this->param['secret'] = $secret;
		$this->charset = $charset;
	}
	
	function __construct($appid,$secret,$charset='utf-8'){
		$this->denglu_api($appid,$secret,$charset);
	}
	
	function call_api($method,$param=array(),$return=false,$json=false){///接口路径,参数,有无返回值,是否json格式
		$post = $this->create_post_body($param);
		$result = $this->dfopen($this->api_server.$method,0,$post,'',true,'',30,true);
	
		$result = $json ? json_decode($result,1) : $result;

		if($return && strtolower($this->charset)!='utf-8'){
			$result = dl_conv($result, "GBK", "UTF8");
		}


		return $result;
	}
	
	function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
		$return = '';
		$matches = parse_url($url);
		$host = $matches['host'];
		if(empty($matches['query'])) $matches['query']='';
		$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
		$port = !empty($matches['port']) ? $matches['port'] : 80;
	
		if($post) {
			$out = "POST $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= 'Content-Length: '.strlen($post)."\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cache-Control: no-cache\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
			$out .= $post;
		} else {
			$out = "GET $path HTTP/1.0\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Accept-Language: zh-cn\r\n";
			$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Cookie: $cookie\r\n\r\n";
		}
	
		if(function_exists('fsockopen')) {
			$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		} elseif(function_exists('pfsockopen')) {
			$fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
		} else {
			$fp = 'error_func';
		}
	
		if(!$fp) {
			return 'error_net';
		} else {
			stream_set_blocking($fp, $block);
			stream_set_timeout($fp, $timeout);
			@fwrite($fp, $out);
			$status = stream_get_meta_data($fp);
			if(!$status['timed_out']) {
				while (!feof($fp)) {
					if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
						break;
					}
				}
	
				$stop = false;
				while(!feof($fp) && !$stop) {
					$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
					$return .= $data;
					if($limit) {
						$limit -= strlen($data);
						$stop = $limit <= 0;
					}
				}
			}
			@fclose($fp);
			return $return;
		}
	}
	
	function create_sig($param){
		ksort($param);
		$sig = '';
		foreach($param as $key=>$value) {
			$sig .= "$key=$value";
		}
		$sig .= $this->param['secret'];
		return md5($sig);
	}
	
	function create_post_body($param){
		foreach($param as $key => $v){
			if(is_array($v)){
				$param[$key] = implode(',',$v);
			}
			if(strtolower($this->charset)!='utf-8'){
				$param[$key] = dl_conv($v,'UTF-8','GBK');
			}
		}
		$param['timestamp'] = time().'000';
		$param['sign_type'] = 'MD5';
		$param['sign']  = $this->create_sig($param);
	
		$arr = array();
		foreach($param as $key => $v){
			$arr[] = $key.'='.urlencode($v);
		}
		return implode('&',$arr);
	}
	
	function post_bind_info($userinfo){////appid=xx&muid=xx&uid=xx&uname=xx&uemail=xx
		return $this->call_api('bind',array('appid'=>$this->param['appid'],'muid'=>$userinfo['mediaUserID'],'uid'=>$userinfo['uid'],'uname'=>$userinfo['username'],'uemail'=>$userinfo['email']),1,1);
	}
	
	function post_login($mediaUserID){///登录成功调用接口
		return  $this->call_api('send_login_feed',array('muid'=>$mediaUserID,'appid'=>$this->param['appid']),1,1);
	}
	
	function post_unbind($mediaUserID){
		return $this->call_api('unbind',array('muid'=>$mediaUserID,'appid'=>$this->param['appid']),1,1);
	}
	
	function post_unbind_all($uid){
		return $this->call_api('all_unbind',array('uid'=>$uid,'appid'=>$this->param['appid']),1,1);
	}
	
	function get_media_data(){
		return $this->call_api('get_media',array('appid'=>$this->param['appid']),1,1);
	}
	
	function get_user_info($token) {//////////get userinfo from api or hidden input
		return $this->call_api('user_info',array('token'=>$token),1,1);
	}
	
	function pushfeed($array) {
		return $this->call_api('share',array('appid'=>$this->param['appid'],'muid'=>$array['muid'],'uid'=>$array['uid'],'content'=>$array['content'],'url'=>$array['url']),1,1);
	}
}
?>
