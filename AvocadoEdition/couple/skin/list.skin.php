<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.couple.css">', 0);
?>

<div id="couple_page">

	<div id="couple_list">
		<ul>
			<? for($i=0; $i < count($list); $i++) { ?>
				<li>
					<div class="visual">
						<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$list[$i]['left']['idx']?>" class="left" target="_blank">
							<img src="<?=$list[$i]['left']['thumb']?>" />
						</a>

						<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$list[$i]['right']['idx']?>" class="right" target="_blank">
							<img src="<?=$list[$i]['right']['thumb']?>" />
						</a>
					</div>

					<p>
						<?=$list[$i]['left']['name']?> ♥ <?=$list[$i]['right']['name']?> 커플<br />
						<?=$list[$i]['dday']?>일 째입니다.
					</p>
				</li>
			<? } ?>
		</ul>

	</div>
</div>
