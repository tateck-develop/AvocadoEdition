<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
goto_url('./board.php?bo_table='.$bo_table.'&amp;'.$qstr.'&amp;#log_'.$write['wr_parent']);
?>
