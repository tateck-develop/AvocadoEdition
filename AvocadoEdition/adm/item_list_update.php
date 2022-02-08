<?php
$sub_menu = "500200";
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {

	auth_check($auth[$sub_menu], 'w');

	for ($i=0; $i<count($_POST['chk']); $i++) {

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$sql = " update {$g5['item_table']}
					set it_category         = '{$_POST['it_category'][$k]}',
						it_name             = '{$_POST['it_name'][$k]}',
						it_sell             = '{$_POST['it_sell'][$k]}',
						it_use_able         = '{$_POST['it_use_able'][$k]}',
						it_use_mmb_able     = '{$_POST['it_use_mmb_able'][$k]}',
						it_use_recepi		= '{$_POST['it_use_recepi'][$k]}',
						it_has              = '{$_POST['it_has'][$k]}',
						it_use_sell         = '{$_POST['it_use_sell'][$k]}',
						it_use_ever         = '{$_POST['it_use_ever'][$k]}',
						it_type         = '{$_POST['it_type'][$k]}',
						it_value         = '{$_POST['it_value'][$k]}',
						it_use			= '{$_POST['it_use'][$k]}'
				  where it_id               = '{$_POST['it_id'][$k]}' ";
		sql_query($sql);
	}

} else if ($_POST['act_button'] == "선택삭제") {
	auth_check($auth[$sub_menu], 'd');
	check_token();

	for ($i=0; $i<count($_POST['chk']); $i++) {
		$k = $_POST['chk'][$i];
		$temp_it_id = trim($_POST['it_id'][$k]);
		if (!$temp_it_id) { return; }

		$it = sql_fetch("select it_img from {$g5['item_table']} where it_id = '{$tmp_it_id}'");
		
		$prev_file_path = str_replace(G5_URL, G5_PATH, $it['it_img']);
		@unlink($prev_file_path);
		
		sql_query(" delete from {$g5['item_table']} where it_id = '{$temp_it_id}'");
		sql_query(" delete from {$g5['inventory_table']} where it_id = '{$temp_it_id}'");
		sql_query(" delete from {$g5['order_table']} where it_id = '{$temp_it_id}'");
		sql_query(" delete from {$g5['shop_table']} where it_id = '{$temp_it_id}'");
	}
}

goto_url('./item_list.php?'.$qstr."&cate=".$cate."&map_id=".$map_id);
?>
