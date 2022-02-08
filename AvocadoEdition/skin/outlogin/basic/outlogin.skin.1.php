<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>


<div class="login-skin-basic">
<form name="foutlogin" action="<?php echo $outlogin_action_url ?>" method="post" autocomplete="off">

	<fieldset class="box-id">
		<!-- 아이디 입력 -->
		<input type="text" name="mb_id" required class="required" maxlength="20">
	</fieldset>

	<fieldset class="box-pw">
		<!-- 비밀번호 입력 -->
		<input type="password" name="mb_password" required class="required" maxlength="20">
	</fieldset>

	<fieldset class="box-btn">
		<!-- 로그인 버튼 -->
		<button type="submit" class="ui-btn point">로그인</button>
	</fieldset>

<? if($is_add_register) { 
	// 사이트 설정이 계정 생성이 가능할 시
?>
	<fieldset class="box-join">
		<a href="<?php echo G5_BBS_URL ?>/register.php" class="ui-btn">계정생성</a>
	</fieldset>
<? } ?>

</form>
</div>
