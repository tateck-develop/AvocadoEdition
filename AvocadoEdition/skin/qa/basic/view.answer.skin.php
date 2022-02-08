<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<table class="theme-form">
	<colgroup>
		<col style="width: 100px;" />
		<col />
	</colgroup>
	<tbody>
		<tr>
			<th>답변</th>
			<td><?php echo get_text($answer['qa_subject']); ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<!-- 본문 내용 시작 { -->
				<div style="min-height: 120px; padding: 10px;">
					<?php echo conv_content($answer['qa_content'], $answer['qa_html']); ?>
				</div>
				<!-- } 본문 내용 끝 -->
			</td>
		</tr>
	</tbody>
</table>
<div id="ans_add" class="txt-center" style="padding: 20px 0;">
	<?php if($answer_update_href) { ?>
	<a href="<?php echo $answer_update_href; ?>" class="ui-btn">답변수정</a>
	<?php } ?>
	<?php if($answer_delete_href) { ?>
	<a href="<?php echo $answer_delete_href; ?>" class="ui-btn admin" onclick="del(this.href); return false;">답변삭제</a>
	<?php } ?>
</div>