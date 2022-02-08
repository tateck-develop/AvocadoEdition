<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

set_session("ss_delete_token", $token = uniqid(time())); 

goto_url("./board.php?bo_table=$bo_table" . $qstr);
?>
