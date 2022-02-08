<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>


<div class="logined-skin-basic">
	<div class="ui-thumb">
<? if($character['ch_id']) { 
	if($character['ch_thumb']) { 
		echo "
			<a href='".G5_URL."/mypage/character/viewer.php?ch_id={$character['ch_id']}' class='thumb-box'>
				<img src='{$character['ch_thumb']}' />
			</a>";
	} else {
		echo "<span class='ui-btn etc'></span>";
	}
} else {
	if($is_add_character) {
		echo "<a href='".G5_URL."/mypage/character/character_form.php' class='ui-btn point'>캐릭터 생성</a>";
	} else {
		echo "<span class='ui-btn etc'></span>";
	}
} ?>
	</div>

	<div class="info">
<?
	if($character['ch_name']) { 
		echo "<p class='character txt-point'>{$character['ch_name']}</p>";
	}
?>
		<p class="name">
			<?php echo $nick ?>
		<? if($is_admin) { ?>
			<a href="<?=G5_ADMIN_URL?>" class="ui-btn admin" target="_blank">관리자</a>
		<? } ?>
		</p>
<?
	if(!$character['ch_name']) { 
		if($is_add_character) { 
			echo "<p class='descript'>보유중인 캐릭터가 없습니다.</p>";
		} else { 
			echo "<p class='descript'>캐릭터 생성기간이 아닙니다.</p>";
		}
	}
?>

		<ul class="control-group">
			<li class="link-memo">
			<? if($memo_not_read) { // 새로운 쪽지가 도착 했을 때
			?>
				<a href="<?php echo G5_URL ?>/mypage/memo/" class="ui-btn point">
					쪽지
					<i><?php echo $memo_not_read ?></i>
				</a>
			<? } else { ?>
				<a href="<?php echo G5_URL ?>/mypage/memo/" class="ui-btn">
					쪽지
				</a>
			<? } ?>
			</li>
			<li class="link-my">
				<a href="<?php echo G5_URL ?>/mypage/" class="ui-btn">
					계정관리
				</a>
			</li>
			<li class="link-logout">
				<a href="<?php echo G5_BBS_URL ?>/logout.php" class="ui-btn">
					로그아웃
				</a>
			</li>
		</ul>
	</div>
</div>

