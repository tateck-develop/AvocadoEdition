<?
include_once("./_common.php");

$ch = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$ch_id}'");
if (!$ch['ch_id']) {
	alert("{$ch['ch_id']} : 캐릭터 자료가 존재하지 않습니다.");
}
if($ch['mb_id'] != $member['mb_id'] && !$is_admin) {
	alert("삭제권한이 없습니다.");
}


$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_thumb']);
@unlink($prev_file_path);
$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_head']);
@unlink($prev_file_path);
$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_body']);
@unlink($prev_file_path);

sql_query(" delete from {$g5['character_table']} where ch_id = '{$ch['ch_id']}' ");
sql_query(" delete from {$g5['value_table']} where ch_id = '{$ch['ch_id']}' ");
sql_query(" delete from {$g5['exp_table']} where ch_id = '{$ch['ch_id']}' ");
sql_query(" delete from {$g5['title_has_table']} where ch_id = '{$ch['ch_id']}' ");
sql_query(" delete from {$g5['closthes_table']} where ch_id = '{$ch['ch_id']}' ");
sql_query(" delete from {$g5['inventory_table']} where ch_id = '{$ch['ch_id']}' ");

$sql = " update {$g5['member_table']}
			set ch_id = ''
			where mb_id = '{$ch['mb_id']}' and ch_id = '{$ch['ch_id']}' ";
sql_query($sql);


goto_url("./index.php");
?>
