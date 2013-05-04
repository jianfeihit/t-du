<?php
define('IN_ECS', true);

include('lib/denglu_comment_func.php');
include dirname(dirname(dirname(__FILE__))).'/includes/init.php';

function array_multi2single($array)
{
static $result_array=array();
foreach($array as $value)
{
if(is_array($value))
{
array_multi2single($value);
}
else
$result_array[]=$value;
}
return $result_array;
} 

function add_denglu_comments(){

	/*获取社会化评论*/
	$denglu_comment = GetCommentInfo();
	$dl_arr = $denglu_comment;

	$last_comment_dir = 'last_comment.php';
	if(file_exists($last_comment_dir)){
		include 'last_comment.php';
		$last_comid = $last_comment['last_comment_id']?$last_comment['last_comment_id']:'';
	}

	/*保存评论前判断是否有更新*/

	if(empty($last_comid)){
		/* 
		*第一次保存评论
		*/
		
		/*在本地评论表里追加一个 dl_comment_id(存储社会化评论的id) 字段*/

			$sql = "SHOW COLUMNS FROM ".$GLOBALS['ecs']->table('comment');
			$result_arr = $GLOBALS['db']->getAll($sql);

			$yiwei_arr = array_multi2single($result_arr);
			
			$show_arr = array_flip($yiwei_arr);
			$res = array_key_exists('dl_comment_id',$show_arr);
			if(!$res){
				$sql = "alter table " .$GLOBALS['ecs']->table('comment') ." add column dl_comment_id int(11);";
				$result = $GLOBALS['db']->query($sql);
			}
		if(!empty($denglu_comment)){

			/* 保存评论 */
			foreach($denglu_comment as $dl_comment){
			$time = strtotime($dl_comment['createTime']);
			$parent_id = $dl_comment['parent']['commentID']?$dl_comment['parent']['commentID']:0;
			$u_email = $dl_comment['userEmail']?$dl_comment['userEmail']:'';
			$denglu_comment_state = $dl_comment['state']==0?1:1;
			$id_value = 1;  

			/*获取评论的 user id */
			$sql = "select user_id from ".$GLOBALS['ecs']->table('users')." where user_name='".$dl_comment['userName']."'";
			$res = $GLOBALS['db']->getOne($sql);
			$u_id = empty($res['user_id']) ? 0 : $res['user_id'];

			/* 保存评论内容 */
			$sql = "INSERT INTO " .$GLOBALS['ecs']->table('comment') .
			   "(id_value, email, user_name, content,add_time, ip_address, status, parent_id, user_id,dl_comment_id) VALUES " ."(".$id_value.",'".$u_email."','".$dl_comment['userName']."','".$dl_comment['content']."',"
			   .$time.",'".$dl_comment['ip']."',".$denglu_comment_state.",".$parent_id.",".$u_id.","
			   .$dl_comment['commentID'].")";
			$result = $GLOBALS['db']->query($sql);
			}
		
		}
	
	}

	/*临时保存评论的最后一条*/
	$last_comment = array_pop($dl_arr);
	$last_comment_id = $last_comment['commentID']?$last_comment['commentID']:$last_comid ;
	
	$last_comment_time = time();
	$last_comment = array();
	$last_comment['last_comment_id'] = $last_comment_id;
	$last_comment['last_comment_time'] = $last_comment_time;

	$str = "<?php\r\n \$last_comment = ".var_export($last_comment,1)."\r\n\n?>";
	if($fp = fopen('last_comment.php','wb')){
		fwrite($fp,$str);
	}
		
	if(!empty($last_comid) && $last_comid!=$last_comment_id){

			/* 保存评论 */
			foreach($denglu_comment as $dl_comment){

			$time = strtotime($dl_comment['createTime']);
			$parent_id = $dl_comment['parent']['commentID']?$dl_comment['parent']['commentID']:0;
			$u_email = $dl_comment['userEmail']?$dl_comment['userEmail']:'';
			$denglu_comment_state = $dl_comment['state']==0?1:1;
			$id_value = 1;  


			/*获取评论的 user id */
			$sql = "select user_id from ".$GLOBALS['ecs']->table('users')." where user_name='".$dl_comment['userName']."'";
			$res = $GLOBALS['db']->getOne($sql);
			$u_id = empty($res['user_id']) ? 0 : $res['user_id'];

			/* 保存评论内容 */
			$sql = "INSERT INTO " .$GLOBALS['ecs']->table('comment') .
			   "(id_value,email,user_name, content,add_time,ip_address,status,parent_id,user_id,dl_comment_id) VALUES " . "(".$id_value.",'".$u_email."','".$dl_comment['userName']."','".$dl_comment['content']."',".$time.",'".
				$dl_comment['ip']."',".$denglu_comment_state.",".$parent_id.",".$u_id.",".$dl_comment['commentID'].")";
			$result = $GLOBALS['db']->query($sql);
			}
		
		
	
	}else{

		/*获取评论的当前状态 如果有删除的评论，则同步到本地数据库*/
		denglu_comment_state();
   }
		
}

	//denglu_comment_state();
	
	//*清除缓存页面
	//clear_cache_files('comments_list.lbi');



function denglu_comment_state(){

	/*获取评论的当前状态*/
	$commentstate = GetCommentState();
	if(!empty($commentstate)){
		
		$arr = array_flip($commentstate);

		$sql = "DELETE FROM ".$GLOBALS['ecs']->table('comment') ." WHERE dl_comment_id=".$arr['3'];
		$res = $GLOBALS['db']->query($sql);
	}
	




}

add_denglu_comments();

//denglu_comment_state();

//alter table friend0 add column pknum int;




?>