<?php
$sub_menu = "400200";
include_once("./_common.php");
if ($w == 'u') check_demo();
auth_check($auth[$sub_menu], 'w');
check_token();

$ch_id = trim($_POST['ch_id']);
$mb = get_member($mb_id);

if(!$mb['mb_id']) {
	alert('존재하지 않는 회원 정보 입니다.');
}

$character_image_path = G5_DATA_PATH."/character/".$mb_id;
$character_image_url = G5_DATA_URL."/character/".$mb_id;

@mkdir($character_image_path, G5_DIR_PERMISSION);
@chmod($character_image_path, G5_DIR_PERMISSION);


$sql_article = "";

// 기본 데이터 등록
$ad = sql_fetch("select * from {$g5['article_default_table']}");
$sql_article .= "
	ch_state		= '{$ch_state}',
	ch_type			= '{$ch_type}',
	mb_id			= '{$mb_id}',
	ch_side			= '{$ch_side}',
	ch_class		= '{$ch_class}',
	ch_name			= '{$ch_name}',
	ch_point		= '{$ch_point}'
";

// 이미지 등록
// -- 두상
if ($ad['ad_use_thumb']) {

	if($_FILES['ch_thumb_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['ch_thumb_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "thumb_".time().".".$exp;
		upload_file($_FILES['ch_thumb_file']['tmp_name'], $image_name, $character_image_path);
		$ch_thumb = $character_image_url."/".$image_name;
	}
	$sql_article .= " , ch_thumb		= '{$ch_thumb}'";
}
// -- 흉상
if ($ad['ad_use_head']) {

	if($_FILES['ch_head_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['ch_head_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "head_".time().".".$exp;
		upload_file($_FILES['ch_head_file']['tmp_name'], $image_name, $character_image_path);
		$ch_head = $character_image_url."/".$image_name;
	}
	$sql_article .= " , ch_head		= '{$ch_head}'";
}
// -- 전신
if ($ad['ad_use_body']) {

	if($_FILES['ch_body_file']['name']) {
		// 확장자 따기
		$exp = explode(".", $_FILES['ch_body_file']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "body_".time().".".$exp;
		upload_file($_FILES['ch_body_file']['tmp_name'], $image_name, $character_image_path);
		$ch_body = $character_image_url."/".$image_name;
	}
	$sql_article .= " , ch_body		= '{$ch_body}'";
}


if($w == '') {

	$sql = " insert into {$g5['character_table']} set {$sql_article}";
	sql_query($sql);

	$ch_id = sql_insert_id();
	if($mb['ch_id'] == "") sql_query("update {$g5['member_table']} set ch_id = '{$ch_id}' where mb_id = '{$mb['mb_id']}'");

	if($ch_body) { 
		$sql = " insert into {$g5['closthes_table']}
					set ch_id			= '{$ch_id}',
						cl_subject		= '기본의상',
						cl_path			= '{$ch_body}',
						cl_use			= '1',
						cl_type			= 'default'";
		sql_query($sql);
	}

} else { 

	// 기존 캐릭터 데이터 호출
	$ch = get_character($ch_id);

	if(!$ch['ch_id'])
		alert("캐릭터 정보가 존재하지 않습니다.");

	
	if($ad['ad_use_thumb'] && !$ad['ad_url_thumb'] && $ch['ch_thumb'] != $ch_thumb) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_thumb']);
		@unlink($prev_file_path);
	}
	if($ad['ad_use_head'] && !$ad['ad_url_head'] && $ch['ch_head'] != $ch_head) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_head']);
		@unlink($prev_file_path);
	}
	if($ad['ad_use_body'] && !$ad['ad_url_body'] && $ch['ch_body'] != $ch_body) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $ch['ch_body']);
		@unlink($prev_file_path);
	}


	$sql = " update {$g5['character_table']}
				set {$sql_article}
				where ch_id = '{$ch_id}'";
	sql_query($sql);
	
	if($mb['ch_id'] == "") sql_query("update {$g5['member_table']} set ch_id = '{$ch_id}' where mb_id = '{$mb['mb_id']}'");

	if($ch_body) { 
		// 옷장정보 불러오기
		$cl_sql = "select cl_id from {$g5['closthes_table']} where ch_id = '{$ch_id}' and cl_type = 'default'";
		$cl = sql_fetch($cl_sql);

		if($cl['cl_id']) { 
			// 정보 업데이트
			$sql = " update {$g5['closthes_table']}
						set cl_path = '{$ch_body}'
						where cl_id = '{$cl['cl_id']}'";
			sql_query($sql);
		} else { 
			// 신규등록
			$sql = " insert into {$g5['closthes_table']}
					set ch_id			= '{$ch_id}',
						cl_subject		= '기본의상',
						cl_path			= '{$ch_body}',
						cl_use			= '1',
						cl_type			= 'default'";
			sql_query($sql);
		}
	}
}


// --------------------- 추가 프로필 데이터
// 추가 항목 값 가져오기
for($i=0; $i < count($ar_code); $i++) { 
	$key = 'av_'.$ar_code[$i];

	$prev_value = sql_fetch("select av_value from {$g5['value_table']} where ch_id = '{$ch_id}' and ar_code = '{$ar_code[$i]}' and ar_theme = '{$ar_theme[$i]}'");
	$prev_value = $prev_value['av_value'];
	
	// 파일 등록일 경우, 이미지 업로드 처리
	if ($_FILES['av_value_file']['name'][$i]) {
		// 확장자 따기
		$exp = explode(".", $_FILES['av_value_file']['name'][$i]);
		$exp = $exp[count($exp)-1];

		$image_name = "img_".$ar_code[$i]."_".time().".".$exp;
		upload_file($_FILES['av_value_file']['tmp_name'][$i], $image_name, $character_image_path);
		$av_value[$i] = $character_image_url."/".$image_name;
	}

	if($prev_value != $av_value[$i] && strstr(G5_URL, $prev_value)) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $prev_value);
		@unlink($prev_file_path);
	}
	
	$sql_article = "
		ch_id		= '{$ch_id}',
		ar_code		= '{$ar_code[$i]}',
		ar_theme	= '{$ar_theme[$i]}',
		av_value	= '{$av_value[$i]}'
	";
	
	if(isset($prev_value)) {
		// 업데이트
		$sql = " update {$g5['value_table']}
					set {$sql_article}
					where ar_code = '{$ar_code[$i]}' and ch_id = '{$ch_id}' and ar_theme = '{$ar_theme[$i]}'
		";
		sql_query($sql);
	} else {
		// 추가
		$sql = " insert into {$g5['value_table']}
					set {$sql_article}
		";
		sql_query($sql);
	}
}



// --------------------- 캐릭터 스탯 등록
if(count($st_id) > 0) {
	// 저장되는 스탯 정보가 존재할 시
	for($i=0; $i < count($st_id); $i++) {
		$temp_st_id = $st_id[$i];
		$old_sc = sql_fetch("select * from {$g5['status_table']} where ch_id = '{$ch_id}' and st_id = '{$temp_st_id}'");

		if($old_sc['sc_id']) { 
			// 업데이트
			$sql = " update {$g5['status_table']}
						set sc_max = '{$sc_max[$i]}',
							sc_value = '{$sc_value[$i]}'
						where sc_id = '{$old_sc['sc_id']}'
			";
			sql_query($sql);

		} else {
			// 등록
			$sql = " insert into {$g5['status_table']}
						set		st_id		= '{$st_id[$i]}',
								ch_id		= '{$ch_id}',
								sc_max		= '{$sc_max[$i]}',
								sc_value	= '{$sc_value[$i]}'
			";
			sql_query($sql);
		}
	}
}


goto_url('./character_form.php?'.$qstr.'&amp;w=u&amp;ch_id='.$ch_id, false);
?>
