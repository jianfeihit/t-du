<?php
if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

require_once ROOT_PATH.'denglu/config.php';

if(is_writeable(ROOT_PATH.'denglu') ){//////////////////如果安装标志文件存在则安装
	$sql = "select user_id,nav_list from ".$ecs->table('admin_user')." where action_list='all'";
	$res = $db->query($sql);
	while ($rows = $db->FetchRow($res))
    {
    	$nav_list = array();
        $nav_list = explode(',',$rows['nav_list']);
        $nav_list[] = $Dlang['denglu'].'|../denglu/admin.php?act=setting';
        $nav_list = implode(',',$nav_list);
        $sql = "update ".$ecs->table('admin_user')." set nav_list='$nav_list' where user_id={$rows['user_id']}";
        $db->query($sql);
    }
    
    $sql = "CREATE TABLE IF NOT EXISTS ".$ecs->table('denglu_bind_info')." (";
    $sql .= <<<EOF
	`uid` mediumint(8) unsigned NOT NULL,
	`mediaUserID` mediumint(8) NOT NULL, 
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
	unlink(DENGLU_PATH.'install');
	
}else{
	echo '<script>alert("dir_denglu_cannot_write")</script>';
}





?>
