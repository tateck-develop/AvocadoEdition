<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.admin.css">', 0);
?>

<div id="login_page_box">

	<div id="login_title">
		<div class="inner">
			<h1>
				<em>
					<strong><?=$config['cf_title']?> 관리자</strong> 로그인
				</em>
				<span>
					AVOCADO EDITION Ver.<?=G5_GNUBOARD_VER?>
				</span>
				<sup>
					관리자 비번을 잊을 시, DB 접속을 통해 직접 변경 하여야 합니다.<br />
					최대한 비밀번호를 잊지 않도록 조심해 주시길 바랍니다.<br />
					DB 관리툴은 호스팅 업체에 문의해 주시길 바랍니다.
				</sup>
			</h1>
		</div>
	</div>


	<!-- 로그인 시작 { -->
	<div id="mb_login" class="mbskin">
		<div class="inner">

			<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
			<input type="hidden" name="url" value="<?php echo $login_url ?>">

			<fieldset class="input">
				<input type="text" name="mb_id" id="login_id" required class="frm_input required" size="20" maxLength="20">
				<label for="login_id" class="login_id">회원아이디<strong class="sound_only"> 필수</strong></label>
			</fieldset>
			<fieldset class="input">
				<input type="password" name="mb_password" id="login_pw" required class="frm_input required" size="20" maxLength="20">
				<label for="login_pw" class="login_pw">비밀번호<strong class="sound_only"> 필수</strong></label>
			</fieldset>
			
			<fieldset class="check">
				<input type="checkbox" name="auto_login" id="login_auto_login">
				<label for="login_auto_login">자동로그인</label>
			</fieldset>

			<fieldset class="button">
				<button type="submit" class="btn_submit">로그인</button>
			</fieldset>
			</form>

			<p id="copyright">
				COPYRIGHT &copy; 2017 System by Avocado<br />
				-<br />
				GNU BOARD 5.2.7
			</p>

		</div>
	</div>
	
</div>



<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });

});

function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->