<?php
include_once('./_common.php');
$sql = " update {$g5['member_table']}
			set mb_board_call = '',
				mb_board_link = ''
			where mb_id = '{$member['mb_id']}'";
sql_query($sql);
echo "Y";
?>
