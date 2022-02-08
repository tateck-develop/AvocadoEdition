<?php
$sub_menu = "900400";
include_once("./_common.php");

$back = sql_fetch("select * from {$g5['backup_table']} where ba_id = '{$ba_id}'");
$file_path = $back['ba_path'];
@unlink($file_path);
sql_query(" delete from {$g5['backup_table']} where ba_id = '{$ba_id}'");
goto_url('./data_backup.php');

?>