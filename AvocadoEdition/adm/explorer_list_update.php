<?php
$sub_menu = "500210";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
check_token();


if ($_POST['act_button'] == "선택수정") {
	for ($i=0; $i<count($_POST['chk']); $i++) {

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$ie = sql_fetch("select * from {$g5['explorer_table']} where ie_id = '{$_POST['ie_id'][$k]}'");
		
		if (!$ie['ie_id']) {
			$msg .= $ie['ie_id'].' : 설정 자료가 존재하지 않습니다.\\n';
		} else {
			$sql_common = "";
			$sql = " update {$g5['explorer_table']}
						set ie_per_s = '{$_POST['ie_per_s'][$k]}',
							ie_per_e = '{$_POST['ie_per_e'][$k]}'
					where ie_id = '{$ie['ie_id']}' ";
			sql_query($sql);
		}
	}
} else if ($_POST['act_button'] == "선택삭제") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$ie = sql_fetch("select * from {$g5['explorer_table']} where ie_id = '{$_POST['ie_id'][$k]}'");

		if (!$ie['ie_id']) {
			$msg .= $ie['ie_id'].' : 설정 자료가 존재하지 않습니다.\\n';
		} else {
			sql_query(" delete from {$g5['explorer_table']} where ie_id = '{$ie['ie_id']}' ");
		}
	}
}

if ($msg) alert($msg);
goto_url('./explorer_list.php?sch_it_id='.$sch_it_id.'&'.$qstr);
?>
