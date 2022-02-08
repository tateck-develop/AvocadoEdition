<?php
$sub_menu = "400200";
include_once('./_common.php');

check_demo();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

auth_check($auth[$sub_menu], 'w');

if ($_POST['act_button'] == "선택수정") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$ch = get_character($_POST['ch_id'][$k]);
		
		if (!$ch['ch_id']) {
			$msg .= $ch['ch_id'].' : 캐릭터 자료가 존재하지 않습니다.\\n';
		} else {
			$sql = " update {$g5['character_table']}
						set ch_type = '{$_POST['ch_type'][$k]}',
							ch_side = '{$_POST['ch_side'][$k]}',
							ch_class = '{$_POST['ch_class'][$k]}',
							ch_state = '{$_POST['ch_state'][$k]}'
						where ch_id = '{$_POST['ch_id'][$k]}' ";
			sql_query($sql);
		}
	}

} else if($_POST['act_button'] == "선택승인") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$ch = get_character($_POST['ch_id'][$k]);
		
		if (!$ch['ch_id']) {
			$msg .= $ch['ch_id'].' : 캐릭터 자료가 존재하지 않습니다.\\n';
		} else {
			$sql = " update {$g5['character_table']}
						set ch_state = '승인'
						where ch_id = '{$_POST['ch_id'][$k]}' ";
			sql_query($sql);
		}
	}

}  else if($_POST['act_button'] == "선택삭제") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$ch = get_character($_POST['ch_id'][$k]);
		
		if (!$ch['ch_id']) {
			$msg .= $ch['ch_id'].' : 캐릭터 자료가 존재하지 않습니다.\\n';
		} else {
			$sql = " update {$g5['character_table']}
						set ch_state = '삭제'
						where ch_id = '{$_POST['ch_id'][$k]}' ";
			sql_query($sql);
			
			$sql = " update {$g5['member_table']}
						set ch_id = ''
						where mb_id = '{$ch['mb_id']}' and ch_id = '{$ch['ch_id']}' ";
			sql_query($sql);
		}
	}

} else if ($_POST['act_button'] == "선택제거") {

	for ($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		$ch = get_character($_POST['ch_id'][$k]);

		if (!$ch['ch_id']) {
			$msg .= "{$ch['ch_id']} : 캐릭터 자료가 존재하지 않습니다.\\n";
		} else {
			sql_query(" delete from {$g5['character_table']} where ch_id = '{$ch['ch_id']}' ");
			sql_query(" delete from {$g5['value_table']} where ch_id = '{$ch['ch_id']}' ");
			sql_query(" delete from {$g5['exp_table']} where ch_id = '{$ch['ch_id']}' ");
			sql_query(" delete from {$g5['title_has_table']} where ch_id = '{$ch['ch_id']}' ");
			sql_query(" delete from {$g5['closthes_table']} where ch_id = '{$ch['ch_id']}' ");
			sql_query(" delete from {$g5['inventory_table']} where ch_id = '{$ch['ch_id']}' ");

			$sql = " update {$g5['member_table']}
						set ch_id = ''
						where mb_id = '{$ch['mb_id']}' and ch_id = '{$ch['ch_id']}' ";
			sql_query($sql);
		}
	}
}

if ($msg)
	alert($msg);

goto_url('./character_list.php');
?>
