<?php 

define('IN_ECS', true);

include dirname(dirname(__FILE__)).'/includes/init.php';


/* act������ĳ�ʼ�� */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'login';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

include 'install_test.php';


?>