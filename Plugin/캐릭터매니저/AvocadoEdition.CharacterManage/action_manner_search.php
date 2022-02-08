<?
header("Content-Type: application/json");
include_once("./_common.php");

$write_table = $g5['write_prefix'].$s_board;

if(!$s_date || !$e_date || !$mb_id || !$s_board) {
	echo(json_encode(array(
		"test" => "error",	
		"state" => "-",
		"link" => ''
	)));
} else {

	$state = '';
	$manner_txt = '';
	$add_manner_str = '';

	if($config['cf_reply_cnt'] < 1) {
		$state = '<span style="opacity:.5">준수</span>';
	} else {

		// 자, 작업을 시작하자. 기간 내의 로그들을 모두 검색해서 돌린다.
		$log_sql = "select wr_id, mb_id, wr_num, wr_manner from {$write_table} where wr_datetime >= '$s_date' and wr_datetime <= '$e_date' and wr_is_comment=0 and mb_id = '{$mb_id}' and wr_manner < {$config['cf_reply_cnt']} order by wr_id";
		$log_result = sql_query($log_sql);

		for($j=0; $log = sql_fetch_array($log_result); $j++) { 
			// 리플 매너를 체크 한다.
			$comment_sql = "select wr_id, wr_num, mb_id from {$write_table} where wr_id < '{$log['wr_id']}' and wr_is_comment=0 order by wr_id desc limit 0, {$config['cf_reply_cnt']}";
			$comment_result = sql_query($comment_sql);

			$manner_count = 0;
			$manner_num = "";
			$add_manner_num = "";

			$prev_num = $log['wr_num'] * -1;
			$is_del = '; color:#fff;';
			$is_del_check = false;

			for($k=0; $comm = sql_fetch_array($comment_result); $k++) {
				$ttmmm_state = "";
				if($comm['mb_id'] == $config['cf_admin']) {
					$manner_count ++;
				} else if($comm['mb_id'] == $mb_id) {
					$manner_count ++;
				} else {
					// 관리자가 쓴 글도 아니고, 내가 쓴 글도 아닐때
					// 해당 글의 덧글 검색한다.
					$check_sql = "select count(wr_id) as cnt from {$write_table} where wr_parent = '{$comm['wr_id']}' and wr_is_comment = 1 and mb_id = '{$mb_id}'";
					$check_result = sql_fetch($check_sql);

					if($check_result['cnt'] > 0) {
						$manner_count ++;
					} else {
						$ttmmm_state = "(X)";
					}
				}

				$now_num = ($comm['wr_num'] * -1);

				if($prev_num - $now_num > 1) {
					$is_del = "; color:red;";
					$is_del_check = true;
				}
				$manner_num .= $add_manner_num.($comm['wr_num'] * -1).$ttmmm_state;
				$add_manner_num = "/";
				$prev_num = ($comm['wr_num'] * -1);
			}

			if($is_del_check && $manner_count == 1) {
				$manner_count = $config['cf_reply_cnt'];
			}

			// 덧글 단 것이 부족할 때
			// 해당 글의 로그 번호를 가져온다.
			if($manner_count < $config['cf_reply_cnt']) {
				$temp_link = "<a href='".G5_BBS_URL."/board.php?bo_table={$s_board}&amp;log=".($log['wr_num']*-1)."' target='_blabk' style='display:block; {$is_del} text-align:left; padding:.2em .5em; border-raidus:4px; margin:1px; background:#29c7c9;'>".($log['wr_num']*-1)." [".($config['cf_reply_cnt']-($manner_count*1))." : {$manner_num}]</a>";
				$manner_txt = $manner_txt.$add_manner_str.$temp_link;
			}

			$update_sql = " update {$write_table} set wr_manner = {$manner_count} where wr_id = '{$log['wr_id']}'";
			sql_query($update_sql);
		}

		if($manner_txt == '') { 
			$state = '<span style="opacity:.5">준수</span>';
		} else {
			$state = '<span style="color:red">경고</span>';
		}
	}

	echo(json_encode(array(
		"test" => $comment_sql,
		"state" => $state,
		"link" => $manner_txt
	)));
}

?>