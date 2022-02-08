<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<table class="theme-form">
	<colgroup>
		<col style="width: 100px;" />
		<col />
	</colgroup>
	<tbody>

		<tr>
			<th>제목</th>
			<td><?=$view['subject']?></td>
		</tr>
		<tr>
			<th>작성자</th>
			<td><?php echo $view['name'] ?></td>
		</tr>
		<tr>
			<th>작성일</th>
			<td><?php echo $view['datetime']; ?></td>
		</tr>
		<? if($view['download_count'] > 0) { ?>
		<tr>
			<th>첨부파일</th>
			<td>
				<?php
				// 가변 파일
				for ($i=0; $i<$view['download_count']; $i++) {
				 ?>
					<li>
						<a href="<?php echo $view['download_href'][$i];  ?>" class="view_file_download">
							<img src="<?php echo $qa_skin_url ?>/img/icon_file.gif" alt="첨부">
							<strong><?php echo $view['download_source'][$i] ?></strong>
						</a>
					</li>
				<?php
				}
				 ?>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td colspan="2">
				<?php
				// 파일 출력
				if($view['img_count']) {
					echo "<div id=\"bo_v_img\">\n";

					for ($i=0; $i<$view['img_count']; $i++) {
						//echo $view['img_file'][$i];
						echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
					}

					echo "</div>\n";
				}
				 ?>

				<!-- 본문 내용 시작 { -->
				<div id="bo_v_con" style="min-height: 120px; padding: 10px;">
					<?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?>
				</div>
				<!-- } 본문 내용 끝 -->
			</td>
		</tr>

	</tbody>
</table>

<article id="bo_v">

	<!-- 게시물 상단 버튼 시작 { -->
	<div id="bo_v_top" class="txt-center" style="padding: 20px 0;">
		<?php
		ob_start();
		 ?>
		<?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>" class="ui-btn">이전글</a><?php } ?>
		<?php if ($next_href) { ?><a href="<?php echo $next_href ?>" class="ui-btn">다음글</a><?php } ?>

		<?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="ui-btn">수정</a><?php } ?>
		<?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="ui-btn" onclick="del(this.href); return false;">삭제</a><?php } ?>
		<a href="<?php echo $list_href ?>" class="ui-btn">목록</a>
		<?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="ui-btn">글쓰기</a><?php } ?>
		<?php
		$link_buttons = ob_get_contents();
		ob_end_flush();
		 ?>
	</div>
	<!-- } 게시물 상단 버튼 끝 -->

	<?php
	// 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
	if(!$view['qa_type']) {
		if($view['qa_status'] && $answer['qa_id'])
			include_once($qa_skin_path.'/view.answer.skin.php');
		else
			include_once($qa_skin_path.'/view.answerform.skin.php');
	}
	?>


	<!-- 링크 버튼 시작 { -->
	<div id="bo_v_bot" class="txt-center" style="padding: 20px 0;">
		<?php echo $link_buttons ?>
	</div>
	<!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
$(function() {
	$("a.view_image").click(function() {
		window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
		return false;
	});

	// 이미지 리사이즈
	$("#bo_v_atc").viewimageresize();
});
</script>