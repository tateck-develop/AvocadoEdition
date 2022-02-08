<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$sub_menu = "400210";
include_once('./_common.php');

sql_query(" delete from {$g5['character_table']} where ch_pass_state != '합격' and ch_state != '승인' ");

goto_url('./character_pass_manager.php?'.$qstr);
?>
