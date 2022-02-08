<?php
$sub_menu = "300700";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();

@mkdir(G5_DATA_PATH.'/emoticon', G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/emoticon', G5_DIR_PERMISSION);

if ($img = $_FILES['me_img']['name']) {
    if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
        alert("이모티콘 이미지가 gif, jpg, png 파일이 아닙니다.");
    } else {
		$emoticon_path = G5_DATA_PATH.'/emoticon';
		$emoticon_image_code = time();
		$emoticon_image_path = "$emoticon_path/$emoticon_image_code";
		$emoticon_image_url = "/data/emoticon/$emoticon_image_code";

		move_uploaded_file($_FILES['me_img']['tmp_name'], $emoticon_image_path);
		chmod($emoticon_image_path, 0606);
		$sql_common = " , me_img = '{$emoticon_image_url}' ";
	}
}
sql_query(" insert into {$g5['emoticon_table']} set me_text = '{$me_text}'".$sql_common);

goto_url('./emoticon_list.php?'.$qstr);
?>
