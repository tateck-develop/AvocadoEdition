<?php
include_once('./_common.php');

if($member['mb_id'] != $_POST['mb_id']) {
	alert('잘못된 접근입니다', "./index.php");
}

sql_query("update {$g5['member_table']} set ch_id = '{$ch_id}' where mb_id = '{$member['mb_id']}'");

goto_url('./index.php');
?>
