<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$random_data = explode("||", $random_log);
?>

<div class="log-item-box data-item">
<? if($random_data[0]) { ?>
	<em>
		<img src="<?=$random_data[0]?>" />
	</em>
<? } ?>
	<p>
		<?=$random_data[1]?>
	</p>
</div>

