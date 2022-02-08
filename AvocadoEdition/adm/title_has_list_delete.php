<?php
$sub_menu = '400310';
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

    // 아이템 내역삭제
    $sql = " delete from {$g5['title_has_table']} where hi_id = '{$_POST['hi_id'][$k]}' ";
    sql_query($sql);
}

goto_url('./title_has_list.php?'.$qstr);
?>