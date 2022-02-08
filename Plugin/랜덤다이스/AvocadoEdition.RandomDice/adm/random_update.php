<?php
$sub_menu = "600200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

$sql = " insert into {$g5['random_table']}
			set ra_title = '{$_POST['ra_title']}',
				ra_img = '{$_POST['ra_img']}',
				ra_text = '{$_POST['ra_text']}',
				ra_use = '{$_POST['ra_use']}'";

sql_query($sql);


goto_url('./random_list.php?'.$qstr);
?>
