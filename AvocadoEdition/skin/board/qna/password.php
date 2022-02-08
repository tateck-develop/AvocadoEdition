<?php
include_once('./_common.php');

if($_POST['wr_password']){
	set_cookie('read_'.$_POST['wr_idx'], $_POST['wr_password'], 3600);
}

goto_url(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr);

?>