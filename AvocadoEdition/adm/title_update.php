<?php
$sub_menu = "400300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();


$title_path = G5_DATA_PATH."/title";
$title_url = G5_DATA_URL."/title";

@mkdir($title_path, G5_DIR_PERMISSION);
@chmod($title_path, G5_DIR_PERMISSION);


/** 타이틀 등록 **/
$sql_common = "";
if ($img = $_FILES['ti_img']['name']) {
	if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
		alert("타이틀 이미지가 gif, jpg, png 파일이 아닙니다.");
	} else {
		// 확장자 따기
		$exp = explode(".", $_FILES['ti_img']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "tlt_".time().".".$exp;
		upload_file($_FILES['ti_img']['tmp_name'], $image_name, $title_path);
		$sql_common .= " , ti_img = '".$title_url."/".$image_name."' ";
	}
}

$sql = " insert into {$g5['title_table']}
			set ti_title = '{$_POST['ti_title']}',
				ti_use = '{$_POST['ti_use']}',
				ti_value = '{$_POST['ti_value']}'
				{$sql_common}
		";
sql_query($sql);



goto_url('./title_list.php?'.$qstr);
?>
