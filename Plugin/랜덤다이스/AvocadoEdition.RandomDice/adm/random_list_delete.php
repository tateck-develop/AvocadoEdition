<?php
$sub_menu = '600200';
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');


if ($_POST['act_button'] == "선택수정") {
	
	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		$sql_common = "";

		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$si = sql_fetch("select * from {$g5['random_table']} where ra_id = '{$_POST['ra_id'][$k]}'");
		
		if (!$si['ra_id']) {
			$msg .= $si['ra_id'].' : 기존 자료가 존재하지 않습니다.\\n';
		} else {
			$sql = " update {$g5['random_table']}
						set ra_title = '{$_POST['ra_title'][$k]}',
							ra_img = '{$_POST['ra_img'][$k]}',
							ra_text = '{$_POST['ra_text'][$k]}',
							ra_use = '{$_POST['ra_use'][$k]}'";
			
			$sql .= "   where ra_id = '{$_POST['ra_id'][$k]}' ";
			sql_query($sql);
		}
	}
} else if ($_POST['act_button'] == "선택삭제") {

	$count = count($_POST['chk']);
	for ($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		// 랜덤다이스 내역삭제
		$sql = " delete from {$g5['random_table']} where ra_id = '{$_POST['ra_id'][$k]}' ";
		sql_query($sql);
	}
}

if ($msg)
	alert($msg);
goto_url('./random_list.php?'.$qstr);
?>