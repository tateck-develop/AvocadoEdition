<?php
include_once('./_common.php');


$ch_id = 0;


if($rm_id) { 
	$rm =sql_fetch("select * from {$g5['relation_table']} where rm_id = '{$rm_id}'");

	$ch = get_character($rm['ch_id']);
	$ch_id = $ch['ch_id'];

	if($ch['mb_id'] != $member['mb_id']) { 
		alert("삭제권한이 없습니다.");
	}

	sql_query(" delete from {$g5['relation_table']} where rm_id = '{$rm_id}' ");
}

goto_url('./viewer.php?ch_id='.$ch_id);
?>
