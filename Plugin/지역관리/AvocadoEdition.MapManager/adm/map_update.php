<?php
$sub_menu = "600300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

check_token();

if($type != 'CONFIG') { 
	sql_query ("insert {$g5['map_table']}
					set ma_parent ='{$_POST['ma_parent']}',
						ma_name ='{$_POST['ma_name']}',
						ma_use = '{$_POST['ma_use']}'
	");
	$ma_id = sql_fetch("select ma_id from {$g5['map_table']} order by ma_id desc limit 0, 1");
	$ma_id = $ma_id['ma_id'];

	if(!$_POST['ma_parent']) { 
		sql_query ("update {$g5['map_table']} set ma_parent = '$ma_id' where ma_id = '$ma_id'");
	}

	set_cookie("co_ma_parent", $_POST['ma_parent'], 30);

} else {
	sql_query ("update {$g5['config_table']} set cf_use_map ='{$_POST['cf_use_map']}' ");
}

goto_url('./map_list.php?'.$qstr);

?>
