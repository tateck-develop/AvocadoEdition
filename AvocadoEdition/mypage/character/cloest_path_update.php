<?php
include_once('./_common.php');

$ch = get_character($ch_id);

if(!$ch['ch_id']) { 
	alert('캐릭터 정보가 존재하지 않습니다.', "./index.php");
}
if($member['mb_id'] != $ch['mb_id']) {
	alert('의상을 관리할 권한이 없습니다.', './viewer.php?ch_id='.$ch_id);
}

$character_image_path = G5_DATA_PATH."/character/".$ch['mb_id']."/closet";
$character_image_url = G5_DATA_URL."/character/".$ch['mb_id']."/closet";

@mkdir($character_image_path, G5_DIR_PERMISSION);
@chmod($character_image_path, G5_DIR_PERMISSION);

$sql_add = '';


for($i = 0; $i < count($cl_id); $i++) {
	$cl = sql_fetch("select * from {$g5['closthes_table']} where cl_id = '{$cl_id[$i]}'");

	if($cl['cl_type'] == 'default') {
		alert('기본 전신은 수정할 수 없습니다.', './viewer.php?ch_id='.$ch_id);
	} else {
		sql_query("update {$g5['closthes_table']} set cl_path = '{$cl_path[$i]}' where cl_id = '{$cl[cl_id]}'");
	}
}

goto_url('./viewer.php?ch_id='.$ch_id);
?>
