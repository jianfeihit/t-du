<?php



/**
*以下是灯鹭的评论函数
*/

//*******获取评论信息
function GetCommentInfo(){
		//****灯鹭评论 v4 接口
		include 'lib/Denglu.php';
		include 'denglu_cache.php';
		$last_comment_dir = dirname(dirname(__FILE__)).'/last_comment.php';
		if(file_exists($last_comment_dir)){
		include dirname(dirname(__FILE__)).'/last_comment.php';
		}
		$cache_id = $last_comment['last_comment_id']?$last_comment['last_comment_id']:'';
		$Denglu = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],'gbk');
		$com_id = $cache_id;//获取保留评论的id
		

		try {
			$ret = $Denglu->getComments($com_id);
		} 
		catch(DengluException $e) { // 获取异常后的处理办法(请自定义)
			$ee = $e->geterrorDescription(); //返回错误信息
			echo $ee;
		} 
		if (is_array($ret)) {
			return $ret;
		} 

}

//*******获取评论信息状态
function GetCommentState(){	
		//****灯鹭评论 v4 接口
		include 'denglu_cache.php';
		$last_comment_dir = dirname(dirname(__FILE__)).'/last_comment.php';
		if(file_exists($last_comment_dir)){
		include dirname(dirname(__FILE__)).'/last_comment.php';
		}

		$time = $last_comment['last_comment_time']?$last_comment['last_comment_time']:0;
		$Denglu = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],'gbk');
		try {
			$ret = $Denglu -> getCommentState($time);
		} 
		catch(DengluException $e) { // 获取异常后的处理办法(请自定义)
			$ee = $e->geterrorDescription(); //返回错误信息
			echo $ee;
		} 
		if (is_array($ret)) {
			return $ret;
		} 

}











?>