<?php
$sub_menu = "600300";
include_once('./_common.php');

if ($w == 'u') check_demo();
auth_check($auth[$sub_menu], 'w');
check_token();


$map_data_path = G5_DATA_PATH."/map";
$map_data_url = G5_DATA_URL."/map";

@mkdir($item_data_path, G5_DIR_PERMISSION);
@chmod($item_data_path, G5_DIR_PERMISSION);




// 보상 아이템 유효성 여부 체크
if(!$me_get_item && $it_name) {
	$it = sql_fetch("select it_id from {$g5['item_table']} where it_name = '{$it_name}'");
	$me_get_item = $it['it_id'];
	if(!$it['it_id']) {
		alert("진열 아이템으로 등록되는 아이템의 정보가 없습니다.");
	}
}


if ($img = $_FILES['me_img_file']['name']) {
	// 확장자 따기
	$exp = explode(".", $_FILES['me_img_file']['name']);
	$exp = $exp[count($exp)-1];

	$image_name = "ma_event_".time()."_img.".$exp;
	upload_file($_FILES['me_img_file']['tmp_name'], $image_name, $map_data_path);
	$me_img = $map_data_url."/".$image_name;
}



$sql_common = "
	ma_id			= '{$ma_id}',
	me_type			= '{$me_type}',
	me_title		= '{$me_title}',
	me_img			= '{$me_img}',
	me_content		= '{$me_content}',
	me_get_item		= '{$me_get_item}',
	me_get_money	= '{$me_get_money}',
	me_move_map		= '{$me_move_map}',
	me_get_hp		= '{$me_get_hp}',
	me_mon_hp		= '{$me_mon_hp}',
	me_mon_attack	= '{$me_mon_attack}',
	me_per_s		= '{$me_per_s}',
	me_per_e		= '{$me_per_e}',
	me_replay_cnt	= '{$me_replay_cnt}',
	me_now_cnt		= '{$me_now_cnt}',
	me_use			= '{$me_use}'
";




if($w == '') { 
	$sql = " insert into {$g5['map_event_table']}
				set {$sql_common}";
	sql_query($sql);
} else {
	$me = sql_fetch("select me_id from {$g5['map_event_table']} where me_id = '{$me_id}'");

	if(!$me['me_id']) {
		alert("이벤트 정보가 존재하지 않습니다.");
	}

	$sql = " update {$g5['map_event_table']}
				set {$sql_common}
				where me_id = '{$me_id}'";
	sql_query($sql);
}

goto_url('./map_event_list.php?ma_id='.$ma_id.'&'.$qstr, false);
?>
