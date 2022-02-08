<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


<div id="password_box">
	<h1 class="ui-btn point">비밀번호 확인</h1>
	<div class="descript theme-box">
		<p>
			<strong>비밀번호를 한번 더 입력해주세요.</strong>
			<?php if ($url == 'member_leave.php') { ?>
			비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
			<?php }else{ ?>
			회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
			<?php }  ?>
		</p>
	
		<div class="pass-form">

			<form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
			<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
			<input type="hidden" name="w" value="u">

			<fieldset class="box-id">
				<span id="mb_confirm_id" class="form-input"><?php echo $member['mb_id'] ?></span>
			</fieldset>
			<fieldset class="box-pw">
				<input type="password" name="mb_password" id="confirm_mb_password" required class="required frm_input" size="15" maxLength="20">
			</fieldset>

			<fieldset class="box-btn">
				<button type="submit" id="btn_submit" class="ui-btn point">확인</button>
			</fieldset>

			</form>

		</div>
	</div>

	<div class="btn_confirm">
		<a href="<?php echo G5_URL ?>" class="ui-btn">메인으로 돌아가기</a>
	</div>

</div>

<script>
function fmemberconfirm_submit(f)
{
	document.getElementById("btn_submit").disabled = true;
	return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->