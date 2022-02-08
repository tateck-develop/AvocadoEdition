<?php
$sub_menu = "500100";
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

		$sql = " update {$g5['shop_table']}
					set ca_name			= '{$_POST['ca_name'][$k]}',
						sh_money		= '{$_POST['sh_money'][$k]}',
						sh_use_money	= '{$_POST['sh_use_money'][$k]}',
						sh_exp			= '{$_POST['sh_exp'][$k]}',
						sh_use_exp		= '{$_POST['sh_use_exp'][$k]}',
						sh_limit		= '{$_POST['sh_limit'][$k]}',
						sh_qty			= '{$_POST['sh_qty'][$k]}',
						sh_use_money	= '{$_POST['sh_use_money'][$k]}',
						sh_use_exp		= '{$_POST['sh_use_exp'][$k]}',
						sh_use_has_title	= '{$_POST['sh_use_has_title'][$k]}',
						sh_use_has_item		= '{$_POST['sh_use_has_item'][$k]}',
						sh_order			= '{$_POST['sh_order'][$k]}'
				  where sh_id			= '{$_POST['sh_id'][$k]}' ";
		sql_query($sql);

	}

} else if ($_POST['act_button'] == "선택삭제") {
	auth_check($auth[$sub_menu], 'd');
	check_token();

	for ($i=0; $i<count($_POST['chk']); $i++) {
		$k = $_POST['chk'][$i];
		$temp_sh_id = trim($_POST['sh_id'][$k]);
		if (!$temp_sh_id) { return; }
		
		sql_query(" delete from {$g5['shop_table']} where sh_id = '{$temp_sh_id}'");
	}
}

goto_url('./shop_list.php?'.$qstr."&cate=".$cate);
?>
