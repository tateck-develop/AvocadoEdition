<?php
include_once('./_common.php');
define('_INDEX_', true);
if (G5_IS_MOBILE) {
	include_once(G5_PATH.'/main.php');
	exit;
}
include_once('./head.sub.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/index.css">', 0);
?>

<? if($config['cf_bgm']) { // 배경음악 출력부분 ?>
<div id="site_bgm_box">
	<iframe src="./bgm.php?action=play" name="bgm_frame" id="bgm_frame" border="0" frameborder="0" marginheight="0" marginwidth="0" topmargin="0" scrolling="no" allowTransparency="true"></iframe>
</div>
<? } ?>

<!-- 콘텐츠 시작 -->
<div id="wrapper">
	<iframe src="./main.php" name="frm_main" id="main" border="0" frameborder="0" marginheight="0" marginwidth="0" topmargin="0" scrolling="auto" allowTransparency="true"></iframe>
</div>

<script>
$(document.body).on("keydown", this, function (event) {
	if (event.keyCode == 116) {
		document.getElementById('main').contentDocument.location.reload(true);
		return false;
	}
});
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>