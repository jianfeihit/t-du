<?
require_once ROOT_PATH.'includes/lib_code.php';


function get_userinfo(){ 
	if(!empty($_REQUEST['token'])){
		return $GLOBALS['api']->get_user_info($_REQUEST['token']);
	}elseif(!empty($_REQUEST['userbak'])){
		$result = decrypt($_REQUEST['userbak']);
		
		$result = unserialize($result);

		
		return $result;
	}else{
		return array();
	}
}

function dl_a($a='001'){
	echo '<script>alert("'.$a.'")</script>';
}
function ec_register($userinfo){
	global $_LANG,$db,$ecs;
	include_once(ROOT_PATH . 'includes/lib_passport.php');

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : substr(md5($userinfo['mediaUserID']),0,10);
    $email    = isset($_POST['email']) ? trim($_POST['email']) : substr(md5(time()),0,6).'@denglu.com';
    $other['msn'] = $other['qq'] = $other['office_phone'] = $other['home_phone'] = $other['mobile_phone'] = $sel_question = $passwd_answer = '';

    if (strlen($username) < 3)
    {
        show_message($_LANG['passport_js']['username_shorter']);
    }

    if (strlen($password) < 6)
    {
        show_message($_LANG['passport_js']['password_shorter']);
    }

    if (strpos($password, ' ') > 0)
    {
        show_message($_LANG['passwd_balnk']);
    }

    if (register($username, $password, $email, $other) !== false)
    {
        /*把新注册用户的扩展信息插入数据库*/
        $sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有自定义扩展字段的id
        $fields_arr = $db->getAll($sql);

        $extend_field_str = '';    //生成扩展字段的内容字符串
        foreach ($fields_arr AS $val)
        {
            $extend_field_index = 'extend_field' . $val['id'];
            if(!empty($_POST[$extend_field_index]))
            {
                $temp_field_content = strlen($_POST[$extend_field_index]) > 100 ? mb_substr($_POST[$extend_field_index], 0, 99) : $_POST[$extend_field_index];
                $extend_field_str .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
            }
        }
        $extend_field_str = substr($extend_field_str, 0, -1);

        if ($extend_field_str)      //插入注册扩展数据
        {
            $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
            $db->query($sql);
        }
		return true;
    }
    else
    {
        return false;
    }
}
function ec_login()
{
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($GLOBALS['user']->login($username, $password,isset($_POST['remember'])))
    {
        update_user_info();
        recalculate_price();
        
        return true;
    }
    else
    {
        $_SESSION['login_fail'] ++ ;
        return false;
    }
}
function is_bind($mediaUserID){
	global $db,$ecs;
	$sql = "select uid,mediaID,tag from ".$ecs->table('denglu_bind_info')." where mediaUserID='$mediaUserID' limit 0,1";
	$result = $db->getOne($sql);

	if($result){
		if($result['uid']==$_SESSION['user_id']){
		 	return 1;	
		}else{
			return 2;
		}
	}else{
		return false;
	}

}
function denglu_bind($userinfo){
	$sql = "select * from ".$GLOBALS['ecs']->table('denglu_bind_info')." where  uid=".$_SESSION['user_id'];
	
	$r = $GLOBALS['db']->getAll($sql);
	$is_first = 1;
	if(!empty($r)){
		$is_first=0;
	}
	foreach($r as $v){
		if($v['mediaID']==$userinfo['mediaID']){
			show_message($GLOBALS['Dlang']['cannot_bind_same_media'],$GLOBALS['Dlang']['back_to_home'],'index.php','error',0);
		}
	}
	
	$time = time();
	$sql = "insert into ".$GLOBALS['ecs']->table('denglu_bind_info')."(`uid`,`mediaUserID`,`screenName`,`mediaID`,`is_first`,`thread_syn`,`log_syn`,`tag`,`createtime`) values('$_SESSION[user_id]','$userinfo[mediaUserID]','$userinfo[screenName]','$userinfo[mediaID]','$is_first','1','1','$userinfo[tag]',$time)";
	$GLOBALS['db']->query($sql);
}

function denglu_unbind($mediaUserID){
	$sql = "delete from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid='$_SESSION[user_id]' and mediaUserID='$mediaUserID'";
	$GLOBALS['db']->query($sql);
	return $GLOBALS['api']->post_unbind($mediaUserID);
}

function check_media($bind_users,$denglu_data){////////检查用户还有哪些媒体可以绑定
	$bind_users = (array)$bind_users;
	$result = array();
	
	foreach($bind_users as $v){
		$arr[] = $v['mediaID'];
	}
	if(empty($arr)){
		return $denglu_data;
	}

	foreach($denglu_data as $key => $value){
		if(in_array($value['mediaID'],$arr)){
			continue;
		}
		$result[] = $value;
	}
	return $result;
}
function get_bind_users($uid){
	$result = array();
	$sql = "select * from ".$GLOBALS['ecs']->table('denglu_bind_info')." where uid=$uid";
	$result = $GLOBALS['db']->getALL($sql);

	return $result;
}

function get_media_info($mediaUserID){
	return $GLOBALS['db']->getOne("select * from ".$GLOBALS['ecs']->table('denglu_bind_info')." where mediaUserID=$mediaUserID");
}

function get_bind_info($mediaUserID){
	$sql = "select m.user_id,m.user_name,m.password  from ".$GLOBALS['ecs']->table('denglu_bind_info')." d left join ".$GLOBALS['ecs']->table('users')." m on m.user_id=d.uid where d.mediaUserID='$mediaUserID'";
	return $GLOBALS['db']->getRow($sql);
}

function denglu_userset($uid){////////hidden an array for mediaUserID
	$mediaUserID = $_POST['mediaUserID'];

	foreach($mediaUserID as $v){
		$condition = "uid={$uid} and mediaUserID={$v}";
		$sql = "update ".$GLOBALS['ecs']->table('denglu_bind_info')." set thread_syn=".intval($_REQUEST['thread_syn_'.$v]).", log_syn=".intval($_REQUEST['log_syn_'.$v])." where ".$condition;
		
		$GLOBALS['db']->query($sql);
	}
}
?>
