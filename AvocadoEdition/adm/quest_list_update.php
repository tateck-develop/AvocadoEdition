<?php
$sub_menu = "600100";
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

		$sql = " update {$g5['quest_table']}
					set qu_type         = '{$_POST['qu_type'][$k]}',
						si_id             = '{$_POST['si_id'][$k]}',
						qu_title             = '{$_POST['qu_title'][$k]}',
						qu_sdate          = '{$_POST['qu_sdate'][$k]}',
						qu_edate         = '{$_POST['qu_edate'][$k]}'
				  where qu_id               = '{$_POST['qu_id'][$k]}' ";
		sql_query($sql);
	}

} else if ($_POST['act_button'] == "선택삭제") {
	auth_check($auth[$sub_menu], 'd');
	check_token();

	for ($i=0; $i<count($_POST['chk']); $i++) {
		$k = $_POST['chk'][$i];
		$temp_qu_id = trim($_POST['qu_id'][$k]);
		if (!$temp_qu_id) { return; }

		sql_query(" delete from {$g5['quest_table']} where qu_id = '{$temp_qu_id}'");
		
	}
}

goto_url('./quest_list.php?'.$qstr."&cate=".$cate."&map_id=".$map_id);
?>
