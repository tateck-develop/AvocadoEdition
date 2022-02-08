<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$it = array();
$customer_sql = "";
$temp_wr_id = $comment_id;
$wr_num = $wr['wr_num'];
if(!$wr_num) $wr_num = $comment['wr_num'];

$sql = " update {$write_table}
			set wr_10 = '{$state}'
		  where wr_id = '{$wr_id}' ";
sql_query($sql);

if($w != 'cu') { 
	// ----- 경험치 변동
	if($ex_value && $ex_value > 0) {
		insert_exp($comment_ch_id, $ex_value, $ex_content);
	}
	// ----- 금액 변동
	if($mo_value && $mo_value > 0) {
		insert_point($comment_mb_id, $mo_value, $mo_content, '@passive', $comment_mb_id, 'admin-'.uniqid(''), 0);
	}
}

goto_url('./board.php?bo_table='.$bo_table.'&amp;'.$qstr.'&amp;#c_'.$comment_id);
?>
