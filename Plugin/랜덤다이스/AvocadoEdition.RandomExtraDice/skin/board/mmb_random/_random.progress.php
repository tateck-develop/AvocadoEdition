<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

/******************************************************************************************
					RANDOM DICE 추가부분 
******************************************************************************************/
// 랜덤 지령 있는지 체크
$random_message = sql_fetch("select count(*) as cnt from {$g5['random_dice_table']} where bo_table = '{$bo_table}' and ra_use = '1'");
if($random_message['cnt'] > 0) { 
	unset($random_message);
	$random_message = array();
	$random_result = sql_query("select * from {$g5['random_dice_table']} where bo_table = '{$bo_table}' and ra_use = '1'");

	$rand_index = 0;
	for($i=0; $ra = sql_fetch_array($random_result); $i++) {
		if($ra['ra_progress']) {

			if($ra['ra_limit'] > 0) {
				// 다이스 굴림 횟수 확인
				if($ra['ra_limit_day']) { 
					$random_dice_log_table = sql_fetch("select count(rl_id) as cnt from {$g5['random_dice_log_table_table']} where ch_id = '{$character['ch_id']}' and ra_id = '{$ra['ra_id']}' and rl_date = '".date('Y-m-d')."'");
				} else {
					$random_dice_log_table = sql_fetch("select count(rl_id) as cnt from {$g5['random_dice_log_table_table']} where ch_id = '{$character['ch_id']}' and ra_id = '{$ra['ra_id']}'");
				}
				$random_dice_log_table = $random_dice_log_table['cnt'];
			}
			
			$random_skin_path    = get_skin_path('random', $ra['ra_skin']);
			$random_skin_url     = get_skin_url('random', $ra['ra_skin']);

			@include_once($random_skin_path.'/random.skin.php');
		} else {
			if($ra['ra_limit'] > 0) {
				continue;
			}

			$random_message[$rand_index]['title'] = $ra['ra_title'];
			$random_message[$rand_index]['id'] = $ra['ra_id'];
			$rand_index++;
		}
	}
} else {
	unset($random_message);
}

/******************************************************************************************
					RANDOM DICE 추가부분 종료 
******************************************************************************************/

?>

