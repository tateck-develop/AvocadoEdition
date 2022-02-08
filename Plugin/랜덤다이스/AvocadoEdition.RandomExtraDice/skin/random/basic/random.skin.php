<?php
if (!defined('_GNUBOARD_')) exit;
add_stylesheet('<link rel="stylesheet" href="'.$random_skin_url.'/style.css">', 0);

$max = $ra['ra_progress_max'];
$now = $ra['ra_progress_p'] + $ra['ra_progress_m'];
$result_count = $max_value - $now;
$per = $now > 0 ? ($now/$max*100) : 0;

?>

<div class="basic-progress-box">
	<div class="basic-title">
		<?=$ra['ra_progress_title']?>
	</div>

	<? if($ra['ra_limit']) { ?>
		<div class="able-counter">
			<?=($ra['ra_limit'] - $random_log)?> / <?=$ra['ra_limit']?>
		</div>
	<? } ?>
	<div class="progress-bar" title="<?=$now?>/<?=$max?>">
		<span style="width:<?=$per?>%"></span>
	</div>
</div>
