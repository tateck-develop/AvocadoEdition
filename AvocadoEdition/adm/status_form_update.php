<?php
$sub_menu = "400420";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

$st_help = htmlspecialchars($_POST['st_help'], ENT_QUOTES);

$sql = " insert into {$g5['status_config_table']}
			set st_name = '{$_POST['st_name']}',
				st_max = '{$_POST['st_max']}',
				st_min = '{$_POST['st_min']}',
				st_order = '{$_POST['st_order']}',
				st_use_max = '{$_POST['st_use_max']}',
				st_help = '{$st_help}'
		";
sql_query($sql);


goto_url('./status_list.php?'.$qstr);
?>
