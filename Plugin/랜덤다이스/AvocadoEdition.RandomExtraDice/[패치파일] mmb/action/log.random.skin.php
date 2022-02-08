<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$random_data = explode("||", $random_log);

?>

<? if(!$random_data[1]) { ?>
	<div class="theme-box txt-center" style="margin-bottom:15px;">
		<div>
			<img src="<?=$random_data[0]?>" />
		</div>
	</div>

<? } else {
	// 색상 변경하는 코드
	$random_data[1] = str_replace("<i>", "<i style='color:{$i_color}';>", $random_data[1]);
	$random_data[1] = str_replace("<em>", "<em style='color:{$em_color}';>", $random_data[1]);
	$random_data[1] = str_replace("<strong>", "<strong style='color:{$strong_color}';>", $random_data[1]);
	
?>
	<div class="theme-box txt-center" style="margin-bottom:15px;">
		<? if($random_data[0]) { ?>
			<div class="thumb">
				<img src="<?=$random_data[0]?>" />
			</div>
		<? } ?>
		<? if($random_data[1]) { ?>
			<div>
				<?=$random_data[1]?>
			</div>
		<? } ?>
	</div>
<? } ?>