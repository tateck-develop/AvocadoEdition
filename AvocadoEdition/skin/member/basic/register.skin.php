<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


<div id="member_page">

	<h1 class="member-title">
		<strong>오너 동의 사항</strong>
		<span>《 Community Joining Assent 》</span>
	</h1>


	<!-- 회원가입약관 동의 시작 { -->
	<div class="member-contents agree-pannel">
		<form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

		<section id="fregister_term">
			<h2>커뮤니티 활동 규칙</h2>
			<div class="theme-box">
				<?=nl2br($config['cf_stipulation'])?>
			</div>
			<fieldset class="check-agree">
				<input type="checkbox" name="agree" value="1" id="agree11">
				<label for="agree11">커뮤니티 활동 규칙 내용에 동의합니다.</label>
			</fieldset>
		</section>

		<section id="fregister_private">
			<h2>캐릭터 유의사항</h2>
			<div class="theme-box">
				<?=nl2br($config['cf_privacy'])?>
			</div>
			<fieldset class="check-agree">
				<input type="checkbox" name="agree2" value="1" id="agree21">
				<label for="agree21">캐릭터 유의사항 내용에 동의합니다.</label>
			</fieldset>
		</section>

		<div class="ui-button-box txt-center">
			<button type="submit" class="ui-btn point">계정생성</button>
		</div>

		</form>

	</div>

</div>

<script>
function fregister_submit(f)
{
	if (!f.agree.checked) {
		alert("커뮤니티 활동 규칙의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}

	if (!f.agree2.checked) {
		alert("캐릭터 유의사항의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree2.focus();
		return false;
	}

	return true;
}
</script>


