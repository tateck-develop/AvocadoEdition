<?php
include_once('./_common.php');
$sql = " update {$g5['member_table']}
			set mb_memo_call = ''
			where mb_id = '{$member['mb_id']}'";
sql_query($sql);
echo "Y";
?>
