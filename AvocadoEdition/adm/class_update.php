<?php
$sub_menu = "400700";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

$class_path = G5_DATA_PATH."/class";
$class_url = G5_DATA_URL."/class";

@mkdir($class_path, G5_DIR_PERMISSION);
@chmod($class_path, G5_DIR_PERMISSION);


/** 소속 아이콘 등록 **/
$sql_common = "";
if ($img = $_FILES['cl_img']['name']) {
	
	if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
		alert("타이틀 이미지가 gif, jpg, png 파일이 아닙니다.");
	} else {
		// 확장자 따기
		$exp = explode(".", $_FILES['cl_img']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "class_".time().".".$exp;
		upload_file($_FILES['cl_img']['tmp_name'], $image_name, $class_path);
		$image_url = $class_url."/".$image_name;

		$sql_common .= " , cl_img = '{$image_url}' ";
	}
}

$sql = " insert into {$g5['class_table']}
			set cl_name = '{$_POST['cl_name']}',
				cl_auth = '{$_POST['cl_auth']}'
			{$sql_common}
		";

sql_query($sql);


goto_url('./class_list.php?'.$qstr);
?>
