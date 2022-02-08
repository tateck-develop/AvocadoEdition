<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if(strstr($url, 'adm')) {
	include_once($member_skin_path.'/login.admin.skin.php');
} else {

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/login.css">', 0);


/*********** Logo Data ************/
$logo = get_logo('pc');
$m_logo = get_logo('mo');

$logo_data = "";
if($logo)		$logo_data .= "<img src='".$logo."' />";
/*********************************/
?>



<div class="loginWrap">
	<div class="login-inner">

		<?
		// 등록된 로고 파일이 있을 경우에만 출력 한다.
		if($logo_data) { ?>
			<div class="login-logo">
				<?=$logo_data?>
			</div>
			<hr class="padding" />
		<? } ?>
		<div class="login-form-box theme-box">
			<div class="inner">
				<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
					<input type="hidden" name="url" value='<?php echo $login_url ?>'>
					<fieldset>
						<input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20" placeholder="아이디">
					</fieldset>
					<fieldset>
						<input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20" placeholder="비밀번호">
					</fieldset>
					<button type="submit" class="ui-btn point">LOGIN</button>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
function flogin_submit(f) {
	return true;
}
</script>
<!-- } 로그인 끝 -->
<? } ?>