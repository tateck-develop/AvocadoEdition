<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$it = array();
$customer_sql = "";
$temp_wr_id = $comment_id;
$wr_num = $wr['wr_num'];
if(!$wr_num) $wr_num = $comment['wr_num'];

include_once($board_skin_path.'/write_update.inc.php');

if($w != 'cu') { 
	$sql = " update {$write_table}
				set wr_subject = '{$wr_subject}'
				{$customer_sql}
			  where wr_id = '{$comment_id}' ";
	sql_query($sql);
} else {
	$sql = " update {$write_table}
				set wr_id = '{$comment_id}'
				{$memo_custom_sql}
			  where wr_id = '{$comment_id}' ";
	sql_query($sql);

}

$original_write =  sql_fetch("select mb_id, wr_subject from $write_table where wr_id = '$wr_id' ");

if($original_write['mb_id'] == $member['mb_id'] && ($original_write['wr_subject'] == '--|UPLOADING|--' || $original_write['wr_subject'] == '')) { 
	// 췩 상태가 해제가 안되었을 때
	$sql = " update {$write_table}
				set wr_subject = '{$character['ch_name']}', wr_ing = '0', wr_datetime = '".date('Y-m-d H:i:s')."'
			  where wr_id = '{$wr_id}' ";
	sql_query($sql);
}


goto_url('./board.php?bo_table='.$bo_table.'&amp;'.$qstr.'&amp;#c_'.$comment_id);
?>
