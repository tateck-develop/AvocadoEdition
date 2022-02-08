<?php
$sub_menu = "500400";
include_once('./_common.php');

check_demo();
auth_check($auth[$sub_menu], 'd');
check_token();

print_r($_POST);

for ($i=0; $i<count($_POST['chk']); $i++) {
	$k = $_POST['chk'][$i];
	$temp_or_id = trim($_POST['or_id'][$k]);
	if (!$temp_or_id) { return; }

	sql_query(" delete from {$g5['order_table']} where or_id = '{$temp_or_id}'");
}


goto_url('./order_list.php?'.$qstr);
?>
