<?php
define("_LOGIN_PAGE_", true);
include_once('./_common.php');

$g5['title'] = '관리자 로그인';
include_once (G5_PATH.'/head.sub.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/login.css">', 0);

if ($is_admin) {goto_url(G5_ADMIN_URL);}
$login_action_url = G5_ADMIN_URL."/login_check.php";
?>

<div class="loginLayout">
	<div class="in">

		<div class="loginWrap">
			<div class="desc">
				<h1>Administrator</h1>
				<p><?=$config['cf_title']?> Management</p>
				<ul>
					<li>관리자 비번을 잊을 시, DB 접속을 통해 직접 변경 하여야 합니다.</li>
					<li>최대한 비밀번호를 잊지 않도록 조심해 주시길 바랍니다.</li>
					<li>DB 관리툴은 호스팅 업체에 문의해 주시길 바랍니다.</li>
				</ul>
				<div class="copy">AVOCADO EDITION Ver.<?=G5_GNUBOARD_VER?> &copy; 2017</div>
			</div>
			<div class="loginForm">
				<div class="frame">
					<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
						<fieldset class="input id">
							<input type="text" name="mb_id" required maxLength="20">
						</fieldset>
						<fieldset class="input pw">
							<input type="password" name="mb_password" required maxLength="20">
						</fieldset>
						<fieldset class="check">
							<input type="checkbox" name="auto_login" id="login_auto_login">
							<label for="login_auto_login"> &nbsp;&nbsp;Auto Login</label>
						</fieldset>

						<fieldset class="control">
							<button type="submit">로그인</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

<script>
$(function() {
	$("#login_auto_login").click(function() {
		if (this.checked) {
			this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
		}
	});
});
function flogin_submit(f) { return true; }
</script>

<?
include_once (G5_PATH.'/tail.sub.php');
?>
