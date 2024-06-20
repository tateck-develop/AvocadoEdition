<?php
$sub_menu = "100200";
include_once('./_common.php');

check_demo();
auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
	alert('최고관리자만 접근 가능합니다.');

check_admin_token();


$site_style_path = G5_DATA_PATH."/site";
$site_style_url = G5_DATA_URL."/site";

@mkdir($site_style_path, G5_DIR_PERMISSION);
@chmod($site_style_path, G5_DIR_PERMISSION);

$cf_site_img = $_POST['cf_site_img'];

// 이미지 등록 시, 이미지를 업로드한 뒤 - 해당 이미지 경로를 삽입
if ($_FILES['cf_site_img_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['cf_site_img_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "site_prevew_image.".$exp;
	upload_file($_FILES['cf_site_img_file']['tmp_name'], $image_name, $site_style_path);
	$cf_site_img = $site_style_url."/".$image_name;
}
if ($_FILES['cf_favicon_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['cf_favicon_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "site_favicon.".$exp;
	upload_file($_FILES['cf_favicon_file']['tmp_name'], $image_name, $site_style_path);
	$cf_favicon = $site_style_url."/".$image_name;
}

$cf_profile_group = "";
$add_str = "";
for($i=0; $i < count($_POST['cf_profile_group_spr']); $i++) {
	if($_POST['cf_profile_group_spr'][$i]) {
		$cf_profile_group .= $add_str.$_POST['cf_profile_group_spr'][$i];
		$add_str = "||";
	}
}

$cf_shop_category = "";
$add_str = "";
for($i=0; $i < count($_POST['cf_shop_category_spr']); $i++) {
	if($_POST['cf_shop_category_spr'][$i]) {
		$cf_shop_category .= $add_str.$_POST['cf_shop_category_spr'][$i];
		$add_str = "||";
	}
}

$cf_item_category = "";
$add_str = "";
for($i=0; $i < count($_POST['cf_item_category_spr']); $i++) {
	if($_POST['cf_item_category_spr'][$i]) {
		$cf_item_category .= $add_str.$_POST['cf_item_category_spr'][$i];
		$add_str = "||";
	}
}

$sql = " update {$g5['config_table']}
			set cf_title			= '{$_POST['cf_title']}',
				cf_bgm				= '{$_POST['cf_bgm']}',
				cf_twitter			= '{$_POST['cf_twitter']}',
				cf_side_title		= '{$_POST['cf_side_title']}',
				cf_class_title		= '{$_POST['cf_class_title']}',
				cf_profile_group	= '{$cf_profile_group}',
				cf_shop_category	= '{$cf_shop_category}',
				cf_item_category	= '{$cf_item_category}',
				cf_open				= '{$_POST['cf_open']}',
				cf_site_descript	= '{$_POST['cf_site_descript']}',
				cf_site_img			= '{$cf_site_img}',
				cf_favicon			= '{$cf_favicon}',
				cf_character_count	= '{$_POST['cf_character_count']}', 
				cf_search_count		= '{$_POST['cf_search_count']}', 
				cf_money			= '{$_POST['cf_money']}',
				cf_money_pice		= '{$_POST['cf_money_pice']}',
				cf_exp_name			= '{$_POST['cf_exp_name']}',
				cf_exp_pice			= '{$_POST['cf_exp_pice']}',
				cf_rank_name		= '{$_POST['cf_rank_name']}',
				cf_status_point		= '{$_POST['cf_status_point']}',
				cf_1				= '{$_POST['cf_1']}',
				cf_2				= '{$_POST['cf_2']}',
				cf_3				= '{$_POST['cf_3']}',
				cf_4				= '{$_POST['cf_4']}',
				cf_5				= '{$_POST['cf_5']}',
				cf_6				= '{$_POST['cf_6']}',
				cf_7				= '{$_POST['cf_7']}',
				cf_8				= '{$_POST['cf_8']}',
				cf_9				= '{$_POST['cf_9']}',
				cf_10				= '{$_POST['cf_10']}' ";
sql_query($sql);


//sql_query(" OPTIMIZE TABLE `$g5['config_table']` ");

goto_url('./community_form.php', false);
?>