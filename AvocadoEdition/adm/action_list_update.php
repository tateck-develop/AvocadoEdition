<?php
$sub_menu = "200200";
include_once('./_common.php');

check_demo();
auth_check($auth[$sub_menu], 'w');

for ($i=0; $i<count($_POST['chk']); $i++)
{
	// 실제 번호를 넘김
	$k = $_POST['chk'][$i];

	$mb = get_member($_POST['mb_id'][$k]);

	if (!$mb['mb_id']) {
		$msg .= $mb['mb_id'].' : 회원자료가 존재하지 않습니다.\\n';
	} else {
		$sql = " update {$g5['member_table']}
					set mb_error_cnt = '{$_POST['mb_error_cnt'][$k]}',
						mb_error_content = '{$_POST['mb_error_content'][$k]}'
					where mb_id = '{$_POST['mb_id'][$k]}' ";
		sql_query($sql);
	}
}

if ($msg)
    alert($msg);

goto_url('./action_list.php?'.$qstr);
?>
