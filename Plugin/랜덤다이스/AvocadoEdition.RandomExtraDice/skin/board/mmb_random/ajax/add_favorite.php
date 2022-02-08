<?
include_once('./_common.php');

if($is_member) { 
	$is_favorite = sql_fetch("select ms_id from {$g5['scrap_table']} where mb_id = '{$mb_id}' and wr_id = '{$wr_id}' and bo_table = '{$bo_table}'");

	if($is_favorite['ms_id']) { 
		// 즐겨찾기 내역이 이미 존재할 경우
		// 해당 내역을 제거한다.
		sql_query("delete from {$g5['scrap_table']} where ms_id = '{$is_favorite['ms_id']}'");
		echo "off";
	} else { 
		// 즐겨찾기 내역 추가
		sql_query(" insert {$g5['scrap_table']} set bo_table = '{$bo_table}', wr_id = '{$wr_id}', mb_id = '{$member['mb_id']}', ms_datetime = '".G5_TIME_YMDHIS."' ");
		echo "on";
	}
}
?>