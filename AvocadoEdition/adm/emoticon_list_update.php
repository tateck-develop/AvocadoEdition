<?php
$sub_menu = '300300';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'd');

check_token();

$count = count($_POST['chk']);
if(!$count)
    alert($_POST['act_button'].' 하실 항목을 하나 이상 체크하세요.');

for ($i=0; $i<$count; $i++)
{
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];

    // 이모티콘 등록 내역
    $sql = " select * from {$g5['emoticon_table']} where me_id = '{$_POST['me_id'][$k]}' ";
    $row = sql_fetch($sql);

    if(!$row['me_id'])
        continue;

    // 이모티콘 내역삭제
    $sql = " delete from {$g5['emoticon_table']} where me_id = '{$_POST['me_id'][$k]}' ";
    sql_query($sql);

	// 이모티콘 이미지 삭제
	@unlink(G5_PATH.$row['me_img']);
}

goto_url('./emoticon_list.php?'.$qstr);
?>