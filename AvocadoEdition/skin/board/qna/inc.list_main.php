<?
// 수정, 삭제 링크
$update_href = $delete_href = "";
// 로그인중이고 자신의 글이라면 또는 관리자라면 패스워드를 묻지 않고 바로 수정, 삭제 가능
if (($member['mb_id'] && ($member['mb_id'] == $write['mb_id'])) || $is_admin) {
    $update_href = "./write.php?w=u&bo_table=$bo_table&wr_id={$lists[$ii]['wr_id']}&page=$page" . $qstr;
    $delete_href = "javascript:del('./delete.php?bo_table=$bo_table&wr_id={$lists[$ii]['wr_id']}&page=$page".urldecode($qstr)."');";
    if ($is_admin) 
    {
        $delete_href = "javascript:del('./delete.php?bo_table=$bo_table&wr_id={$lists[$ii]['wr_id']}&token=$token&page=$page".urldecode($qstr)."');";
    }
}
else if (!$write['mb_id']) { // 회원이 쓴 글이 아니라면
    $update_href = "./password.php?w=u&bo_table=$bo_table&wr_id={$lists[$ii]['wr_id']}&page=$page" . $qstr;
    $delete_href = "./password.php?w=d&bo_table=$bo_table&wr_id={$lists[$ii]['wr_id']}&page=$page" . $qstr;
}
?>
