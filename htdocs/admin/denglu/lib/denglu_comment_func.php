<?php



/**
*�����ǵ��ص����ۺ���
*/

//*******��ȡ������Ϣ
function GetCommentInfo(){
		//****�������� v4 �ӿ�
		include 'lib/Denglu.php';
		include 'denglu_cache.php';
		$last_comment_dir = dirname(dirname(__FILE__)).'/last_comment.php';
		if(file_exists($last_comment_dir)){
		include dirname(dirname(__FILE__)).'/last_comment.php';
		}
		$cache_id = $last_comment['last_comment_id']?$last_comment['last_comment_id']:'';
		$Denglu = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],'gbk');
		$com_id = $cache_id;//��ȡ�������۵�id
		

		try {
			$ret = $Denglu->getComments($com_id);
		} 
		catch(DengluException $e) { // ��ȡ�쳣��Ĵ���취(���Զ���)
			$ee = $e->geterrorDescription(); //���ش�����Ϣ
			echo $ee;
		} 
		if (is_array($ret)) {
			return $ret;
		} 

}

//*******��ȡ������Ϣ״̬
function GetCommentState(){	
		//****�������� v4 �ӿ�
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
		catch(DengluException $e) { // ��ȡ�쳣��Ĵ���취(���Զ���)
			$ee = $e->geterrorDescription(); //���ش�����Ϣ
			echo $ee;
		} 
		if (is_array($ret)) {
			return $ret;
		} 

}











?>