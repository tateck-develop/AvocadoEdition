<?php
include_once('./_common.php');
define('_MAIN_', true);

if(defined('G5_THEME_PATH')) {
	require_once(G5_THEME_PATH.'/main.php');
	return;
}
include_once(G5_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/main.css">', 0);
include_once(G5_PATH."/intro.php");
?>

<div id="main_body">

<?
$main_content = get_site_content('site_main');
if($main_content) { 
	echo $main_content;
} else { 
?>
	<div id="no_design_main">
		<div id="main_visual_box">
			<? include(G5_PATH."/templete/txt.visual.php"); ?>
		</div>

		<div id="main_twitter_box" class="theme-box">
			<? include(G5_PATH."/templete/txt.twitter.php"); ?>
		</div>

		<div id="main_image_box" class="theme-box">
			<img src="<?=G5_IMG_URL?>/temp_main_image.png" alt="임시 메인 이미지" />
		</div>

		<div id="main_side_box">
			<div id="main_login_box" class="theme-box">
				<? include(G5_PATH."/templete/txt.outlogin.php"); ?>
			</div>
			<div id="main_banner_box" class="theme-box">
				<img src="<?=G5_URL?>/adm/img/logo.png" alt="임시 메인 배너이미지" />
				<p>AVOCADO EDITION</p>
				<p><a href="https://avocado-edition-rout.postype.com/" target="_blank">https://avocado-edition-rout.postype.com/</a></p>
			</div>
		</div>

		<div id="main_copyright_box" class="theme-box txt-center">
			COPYRIGHT &copy; 2021 by Avocado
		</div>
	</div>
<?php } ?>
</div>

<script>
$(function() { 
	window.onload = function() {
		$('#body').css('opacity', 1);
	};
});
</script>

<?
include_once(G5_PATH.'/tail.php');
?>