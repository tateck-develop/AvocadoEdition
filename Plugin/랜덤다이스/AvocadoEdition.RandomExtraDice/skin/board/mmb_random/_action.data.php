<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$data_log = explode("||", $data_log);
$log_type = $data_log[0];
$item_log = explode("||", $item_log);

if($log_type) { 
	include($board_skin_path."/action/log.{$log_type}.skin.php");
}


if($item_log[0]) { 
	/** 아이템 사용시 **/
	include($board_skin_path."/action/log.item.skin.php");
}


/******************************************************************************************
					RANDOM DICE 추가부분 
******************************************************************************************/
$random_log = $log_comment['wr_random_dice'];
if($random_log) { 
	/** 랜덤로그 사용 시 **/
	include($board_skin_path."/action/log.random.skin.php");
}
/******************************************************************************************
					RANDOM DICE 추가부분 종료
******************************************************************************************/

?>