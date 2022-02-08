<?php
$sub_menu = "400100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

$ar_help = htmlspecialchars ($ar_help, ENT_QUOTES);

$sql = " insert into {$g5['article_table']}
			set ar_code = '$ar_code',
				ar_theme = '$ar_theme',
				ar_name = '$ar_name',
				ar_type = '$ar_type',
				ar_size = '$ar_size',
				ar_text = '$ar_text',
				ar_help = '$ar_help',
				ar_order = '$ar_order',
				ar_secret = '$ar_secret'
";
sql_query($sql);


goto_url('./character_article_list.php?'.$qstr);
?>
