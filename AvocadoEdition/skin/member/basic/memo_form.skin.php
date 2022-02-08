<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 보내기 시작 { -->
<div id="memo_write" class="new_win mbskin">
	<form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
	<table class="theme-form">
		<colgroup>
			<col style="width: 80px;" />
			<col />
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="me_recv_mb_id">아이디<strong class="sound_only">필수</strong></label></th>
			<td>
				<input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="frm_input required" size="47">
				<span class="frm_info">여러 회원에게 보낼때는 컴마(,)로 구분하세요.</span>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="me_memo">내용</label></th>
			<td><textarea name="me_memo" id="me_memo" required class="required" style="min-height: 140px;"><?php echo $content ?></textarea></td>
		</tr>
		
		</tbody>
	</table>
	<hr class="padding" />
	<div class="win_btn txt-center">
		<input type="submit" value="보내기" id="btn_submit" class="ui-btn">
		<button type="button" onclick="window.close();" class="ui-btn">창닫기</button>
	</div>
	</form>
</div>

<script>
function fmemoform_submit(f)
{
	<?php echo chk_captcha_js();  ?>

	return true;
}
</script>
<!-- } 쪽지 보내기 끝 -->