<?php
$sub_menu = "400400";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();


$sql = " insert into {$g5['level_table']}
			set lv_name = '{$_POST['lv_name']}',
				lv_exp = '{$_POST['lv_exp']}',
				lv_add_state = '{$_POST['lv_add_state']}',
				lv_1 = '{$_POST['lv_1']}',
				lv_2 = '{$_POST['lv_2']}',
				lv_3 = '{$_POST['lv_3']}',
				lv_4 = '{$_POST['lv_4']}',
				lv_5 = '{$_POST['lv_5']}'
		";
sql_query($sql);


goto_url('./level_list.php?'.$qstr);
?>
