<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>


<div id="member_page">

	<h1 class="member-title">
		<strong>계정 정보 <?=$w == '' ? "등록" : "수정"?></strong>
		<span>《 Community Register Form 》</span>
	</h1>

	<div class="member-contents register-pannel">
		<form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="w" value="<?php echo $w ?>">
			<input type="hidden" name="url" value="<?php echo $urlencode ?>">
			<input type="hidden" name="agree" value="<?php echo $agree ?>">
			<input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
			<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
			<input type="hidden" name="cert_no" value="">
			<input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
			<input type="hidden" name="mb_open" value="1">

			<?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
			<?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
			<input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
			<input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
			<?php }  ?>

			<table class="member-form theme-form">
				<colgroup>
					<col style="width: 110px;" />
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th>아이디</th>
						<td>
							<input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20">
							<span id="msg_mb_id"></span>
						</td>
					</tr>
					<tr>
						<th scope="row">비밀번호</th>
						<td><input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="frm_input <?php echo $required ?>" minlength="3" maxlength="20"></td>
					</tr>
					<tr>
						<th scope="row">비밀번호 확인</th>
						<td><input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="frm_input <?php echo $required ?>" minlength="3" maxlength="20"></td>
					</tr>
				</tbody>
			</table>

			<table class="member-form theme-form">
				<colgroup>
					<col style="width: 110px;" />
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th scope="row">닉네임</th>
						<td>
							<input type="text" name="mb_name" value="<?php echo isset($member['mb_name'])?get_text($member['mb_name']):''; ?>" required class="frm_input required" size="10" maxlength="20">
						</td>
					</tr>
					<tr>
						<th scope="row">생년</th>
						<td>
							<input type="text" name="mb_birth" value="<?php echo isset($member['mb_birth'])?$member['mb_birth']:''; ?>" required class="frm_input required" size="5" maxlength="100">
						</td>
					</tr>
				</tbody>
			</table>
	
			<div class="btn_confirm txt-center">
				<button type="submit" id="btn_submit" class="ui-btn point" accesskey="s"><?php echo $w==''?'회원가입':'정보수정'; ?></button>
				<a href="<?php echo G5_URL ?>" class="ui-btn">취소</a>
			</div>
		</form>
	</div>
</div>
	

<script>
	// submit 최종 폼체크
	function fregisterform_submit(f)
	{
		// 회원아이디 검사
		if (f.w.value == "") {
			var msg = reg_mb_id_check();
			if (msg) {
				alert(msg);
				f.mb_id.select();
				return false;
			}
		}

		if (f.w.value == "") {
			if (f.mb_password.value.length < 3) {
				alert("비밀번호를 3글자 이상 입력하십시오.");
				f.mb_password.focus();
				return false;
			}
		}

		if (f.mb_password.value != f.mb_password_re.value) {
			alert("비밀번호가 같지 않습니다.");
			f.mb_password_re.focus();
			return false;
		}

		if (f.mb_password.value.length > 0) {
			if (f.mb_password_re.value.length < 3) {
				alert("비밀번호를 3글자 이상 입력하십시오.");
				f.mb_password_re.focus();
				return false;
			}
		}

		document.getElementById("btn_submit").disabled = "disabled";

		return true;
	}
</script>

</div>
<!-- } 회원정보 입력/수정 끝 -->