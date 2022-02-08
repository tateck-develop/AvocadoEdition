<?php
$g5['title'] = "설문조사";

include_once('./_common.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_PATH.'/head.sub.php');

echo poll('basic', $po_id);

include_once(G5_PATH.'/tail.sub.php');
?>
