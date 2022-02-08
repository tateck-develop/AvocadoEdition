<?php
$sub_menu = '600600';
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

$site_style_path = G5_DATA_PATH."/site";
$site_style_url = G5_DATA_URL."/site";

@mkdir($site_style_path, G5_DIR_PERMISSION);
@chmod($site_style_path, G5_DIR_PERMISSION);

if ($_FILES['ma_btn_prev_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['ma_btn_prev_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "maze_".time()."_prev.".$exp;
	upload_file($_FILES['ma_btn_prev_file']['tmp_name'], $image_name, $site_style_path);
	$ma_btn_prev = $site_style_url."/".$image_name;
}

if ($_FILES['ma_btn_next_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['ma_btn_next_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "maze_".time()."_next.".$exp;
	upload_file($_FILES['ma_btn_next_file']['tmp_name'], $image_name, $site_style_path);
	$ma_btn_next = $site_style_url."/".$image_name;
}

if ($_FILES['ma_background_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['ma_background_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "maze_".time()."_background.".$exp;
	upload_file($_FILES['ma_background_file']['tmp_name'], $image_name, $site_style_path);
	$ma_background = $site_style_url."/".$image_name;
}


$error_msg = '';

$sql_common = " ma_subject         = '$ma_subject',
                ma_content         = '$ma_content',
                ma_order           = '$ma_order',
				ma_answer          = '$ma_answer',
				ma_background      = '$ma_background',
				ma_btn_prev        = '$ma_btn_prev',
				ma_btn_next        = '$ma_btn_next' ";

if ($w == "")
{
    $sql = " select ma_id from {$g5['maze_table']} where ma_id = '$ma_id' ";
    $row = sql_fetch($sql);

	$sql = " insert {$g5['maze_table']}
                set $sql_common ";
    sql_query($sql);
}
else if ($w == "u")
{
	// 기존 데이터 호출
	$ma = sql_fetch("select * from {$g5['maze_table']} where ma_id = '{$ma_id}'");
	if($ma['ma_btn_prev'] != $ma_btn_prev && strstr($ma['ma_btn_prev'], "maze_")) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $ma['ma_btn_prev']);
		@unlink($prev_file_path);
	}
	if($ma['ma_btn_next'] != $ma_btn_next && strstr($ma['ma_btn_next'], "maze_")) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $ma['ma_btn_next']);
		@unlink($prev_file_path);
	}
	if($ma['ma_background'] != $ma_background && strstr($ma['ma_background'], "maze_")) { 
		// 해당 서버에 업로드 한 파일일 경우
		$prev_file_path = str_replace(G5_URL, G5_PATH, $ma['ma_background']);
		@unlink($prev_file_path);
	}

    $sql = " update {$g5['maze_table']}
                set $sql_common
              where ma_id = '$ma_id' ";
    sql_query($sql);
}
else if ($w == "d")
{
    $sql = " delete from {$g5['maze_table']} where ma_id = '$ma_id' ";
    sql_query($sql);
}

if( $error_msg ){
	alert($error_msg, "./maze_list.php");
} else {
	goto_url("./maze_list.php");
}

?>
