<?php
include_once('./_common.php');
$sql = " update {$g5['character_table']}
			set ch_title = '{$ti_id}'
			where ch_id = '{$ch_id}'";
sql_query($sql);
echo "Y";
?>
