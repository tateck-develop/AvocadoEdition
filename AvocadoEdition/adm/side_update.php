<?php
$sub_menu = "400600";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

$side_path = G5_DATA_PATH."/side";
$side_url = G5_DATA_URL."/side";

@mkdir($side_path, G5_DIR_PERMISSION);
@chmod($side_path, G5_DIR_PERMISSION);


/** 소속 아이콘 등록 **/
$sql_common = "";
if ($img = $_FILES['si_img']['name']) {
	
	if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
		alert("타이틀 이미지가 gif, jpg, png 파일이 아닙니다.");
	} else {
		// 확장자 따기
		$exp = explode(".", $_FILES['si_img']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "side_".time().".".$exp;
		upload_file($_FILES['si_img']['tmp_name'], $image_name, $side_path);
		$image_url = $side_url."/".$image_name;

		$sql_common .= " , si_img = '{$image_url}' ";
	}
}

$sql = " insert into {$g5['side_table']}
			set si_name = '{$_POST['si_name']}',
				si_auth = '{$_POST['si_auth']}'
			{$sql_common}
		";

sql_query($sql);


goto_url('./side_list.php?'.$qstr);
?>
