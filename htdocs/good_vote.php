<?php

/**
 * ECSHOP 调查程序
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: good_vote.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_json.php');

if (!isset($_REQUEST['good_id']))
{
    ecs_header("Location: ./\n");
    exit;
}

$res        = array('error' => 0, 'message' => '', 'id' => '');

$good_id    = intval($_REQUEST['good_id']);
$ip_address = real_ip();

if (vote_already_submited($good_id, $ip_address))
{
	$res['id'] ='vote_' . $good_id;
    $res['error']   = 1;
    $res['message'] = $_LANG['vote_ip_same'];
}
else
{
    save_vote($good_id, $ip_address);
	$res['id'] ='vote_' . $good_id;
    $res['message'] = $_LANG['vote_success'];
}

$json = new JSON;

echo $json->encode($res);

/*------------------------------------------------------ */
//-- PRIVATE FUNCTION
/*------------------------------------------------------ */

/**
 * 检查是否已经提交过投票
 *
 * @access  private
 * @param   integer     $good_id
 * @param   string      $ip_address
 * @return  boolean
 */
function vote_already_submited($good_id, $ip_address)
{
    $vote_time=gmtime();
    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('good_vote_log')." ".
           "WHERE ip_address = '$ip_address' AND good_id = '$good_id'  AND vote_time  = cast( ($vote_time / 86400) as UNSIGNED) ";

    return ($GLOBALS['db']->GetOne($sql) > 0);
}

/**
 * 检查商品是否已经登记
 *
 * @access  private
 * @param   integer     $good_id
 * @return  boolean
 */
function good_already_reg($good_id)
{
    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('good_vote')." ".
           "WHERE good_id = '$good_id' ";

    return ($GLOBALS['db']->GetOne($sql) > 0);
}

/**
 * 保存投票结果信息
 *
 * @access  public
 * @param   integer     $good_id
 * @param   string      $ip_address
 * @return  void
 */
function save_vote($good_id, $ip_address)
{
    $vote_time=gmtime();
    $sql = "INSERT INTO " . $GLOBALS['ecs']->table('good_vote_log') . " (good_id, ip_address, vote_time) " .
           "VALUES ('$good_id', '$ip_address', cast( ($vote_time / 86400) as UNSIGNED))";
    $res = $GLOBALS['db']->query($sql);

	if(good_already_reg($good_id))
	{
		/* 更新商品投票的数量 */
		$sql = "UPDATE " .$GLOBALS['ecs']->table('good_vote'). " SET ".
			   "vote_count = vote_count + 1 ".
			   "WHERE good_id = '$good_id'";
		$GLOBALS['db']->query($sql);
	}
	else
	{
		$sql = "INSERT INTO " . $GLOBALS['ecs']->table('good_vote') . " (good_id, vote_name,start_time, end_time, can_multi,vote_count) " .
           "VALUES ('$good_id', '$ip_address', " . gmtime() . ',' . gmtime() .",0 ,1)";
		$res = $GLOBALS['db']->query($sql);
	}

}

?>