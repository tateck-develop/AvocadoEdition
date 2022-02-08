<?php
include_once('./_common.php');

$ch = get_character($ch_id);

if($url) { 
	$return_url = urldecode($url);
} else { 
	$return_url = "./viewer.php?ch_id=".$ch_id;
}

if(!$ch['ch_id']) { 
	alert('캐릭터 정보가 존재하지 않습니다.');
}

$item_data_path = G5_DATA_PATH."/item";
$item_data_url = G5_DATA_URL."/item";

@mkdir($item_data_path, G5_DIR_PERMISSION);
@chmod($item_data_path, G5_DIR_PERMISSION);

$in = sql_fetch("select * from {$g5['inventory_table']} inven, {$g5['item_table']} item where inven.in_id = '{$in_id}' and inven.it_id = item.it_id and inven.ch_id = '{$ch_id}'");
$it_id = $in['it_id'];

if($in['it_type'] != '아이템추가') { 
	alert('올바른 아이템 정보가 아닙니다.');
}

$tmp_row = sql_fetch(" select max(it_id) as max_it_id from {$g5['item_table']} ");
$it_id = $tmp_row['max_it_id'] + 1;
$sql_common = "";

if ($img = $_FILES['it_img']['name']) {
	if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
		alert("아이템 이미지가 gif, jpg, png 파일이 아닙니다.");
	} else {
		// 확장자 따기
		$exp = explode(".", $_FILES['it_img']['name']);
		$exp = $exp[count($exp)-1];

		$image_name = "item_".$it_id."_img.".$exp;
		upload_file($_FILES['it_img']['tmp_name'], $image_name, $item_data_path);
		$it_img = $item_data_url."/".$image_name;

		$sql_common = " , it_img = '{$it_img}' ";
	}
}

$sql_common = " it_name = '{$_POST['it_name']}',
				it_category = '개인',
				it_content = '{$_POST['it_content']}'
				{$sql_common} ";
$sql = " insert into {$g5['item_table']} set it_id = '{$it_id}', {$sql_common}";
sql_query($sql);

$sql = " insert into {$g5['inventory_table']}
			set ch_id = '$ch_id',
				it_id = '$it_id',
				it_name = '{$_POST['it_name']}',
				ch_name = '{$ch['ch_name']}'";
sql_query($sql);

// 아이템 삭제
delete_inventory($in_id);

goto_url($return_url);
?>
