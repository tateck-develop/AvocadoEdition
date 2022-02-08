<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$sub_menu = "400210";
include_once('./_common.php');

$sql = "";

for($i=0; $i < count($ch_id); $i++) {
	// 내역 업데이트
	sql_query("update {$g5['character_table']} set ch_pass_state = '{$ch_pass_state[$i]}' where ch_id = '{$ch_id[$i]}'");

}


goto_url('./character_pass_manager.php?'.$qstr);
?>
