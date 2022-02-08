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

if($w == '') {
	if(!$cl_subject){
		alert('의상명을 입력해 주시길 바랍니다.', './viewer.php?ch_id='.$ch_id);
	}
	
	// 이미지 등록
	// -- 의상
	if($_FILES['cl_path_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['cl_path_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "closet_".time().".".$exp;
		upload_file($_FILES['cl_path_file']['tmp_name'], $image_name, $character_image_path);
		$cl_path = $character_image_url."/".$image_name;
	}
	// 이미지 무차별 삭제 방어
	if(strstr($cl_path, G5_URL)) {
		// 본 사이트의 경로를 가지고 있을 경우
		if(!strstr($cl_path, $character_image_url)) {
			// 본인의 캐릭터 경로가 아닐 경우
			alert("이미지 경로가 올바르지 않습니다.");
		}
	}

	if(!$cl_path) {
		alert("의상 이미지를 입력해 주시길 바랍니다.");
	}
	$sql_add .= " , cl_path		= '{$cl_path}'";

	sql_query("insert into {$g5['closthes_table']} set ch_id = '{$ch['ch_id']}', cl_subject = '{$cl_subject}', cl_path = '{$cl_path}', cl_use = '0'");

} else { 

	$cl = sql_fetch("select * from {$g5['closthes_table']} where cl_id = '{$cl_id}'");
	if(!$cl['cl_id']) {
		alert('의상 정보를 확인할 수 없습니다.', './viewer.php?ch_id='.$ch_id);
	}

	if($w == 'u') { 
		sql_query("update {$g5['closthes_table']} set cl_use = '0' where cl_id != '{$cl['cl_id']}' and ch_id = '{$ch['ch_id']}'");
		sql_query("update {$g5['closthes_table']} set cl_use = '1' where cl_id = '{$cl['cl_id']}'");
	} else if($w == 'd') { 
		if($cl['cl_type'] == 'default') {
			alert('기본 전신은 삭제할 수 없습니다.', './viewer.php?ch_id='.$ch_id);
		} else if($cl['cl_use'] == '1') {
			alert('현재 사용 중인 의상은 삭제할 수 없습니다.', './viewer.php?ch_id='.$ch_id);
		} else {
			$prev_file_path = str_replace(G5_URL, G5_PATH, $cl['cl_path']);
			@unlink($prev_file_path);
			sql_query("delete from `{$g5['closthes_table']}` where cl_id = '{$cl['cl_id']}'");
		}
	} else {
		alert('잘못된 명령값입니다.', './viewer.php?ch_id='.$ch_id);
	}
}

goto_url('./viewer.php?ch_id='.$ch_id);
?>
