<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>


<? if($qaconfig['qa_content_head']) { ?>
<div class="board-notice">
	<?=conv_content($qaconfig['qa_content_head'], 1);?>
</div>
<hr class="padding" />
<? } ?>


<div id="bo_list">
	

	<form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
	<input type="hidden" name="stx" value="<?php echo $stx; ?>">
	<input type="hidden" name="sca" value="<?php echo $sca; ?>">
	<input type="hidden" name="page" value="<?php echo $page; ?>">

	
	<table class="theme-list">
		<caption><?php echo $board['bo_subject'] ?> 목록</caption>
		<thead>
		<tr>
			<th scope="col">번호</th>
			<?php if ($is_checkbox) { ?>
			<th scope="col">
				<label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
				<input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
			</th>
			<?php } ?>
			<th scope="col">제목</th>
			<th scope="col">작성자</th>
			<th scope="col">상태</th>
			<th scope="col">등록일</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $i<count($list); $i++) {
		?>
		<tr>
			<td class="td_num txt-center"><?php echo $list[$i]['num']; ?></td>
			<?php if ($is_checkbox) { ?>
			<td class="td_chk txt-center">
				<label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
				<input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
			</td>
			<?php } ?>
			<td class="td_subject">
				<a href="<?php echo $list[$i]['view_href']; ?>">
					<?php echo $list[$i]['subject']; ?>
				</a>
				<?php echo $list[$i]['icon_file']; ?>
			</td>
			<td class="td_name txt-center"><?php echo $list[$i]['name']; ?></td>
			<td class="td_stat  txt-center <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></td>
			<td class="td_date txt-center"><?php echo $list[$i]['date']; ?></td>
		</tr>
		<?php
		}
		?>

		<?php if ($i == 0) { echo '<tr><td colspan="'.$colspan.'" class="no-data">게시물이 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>
	

	<div class="bo_fx">
		

		<div class="btn_bo_user txt-right">
			<?php if ($is_checkbox) { ?><input type="submit" name="btn_submit" class="ui-btn admin" value="선택삭제" onclick="document.pressed=this.value"><? } ?>
			<?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="ui-btn">목록</a><?php } ?>
			<?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="ui-btn point">문의등록</a><?php } ?>
		</div>
	</div>
	</form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>

<!-- 게시판 검색 시작 { -->
<fieldset id="bo_sch" class="txt-center">
	<legend>게시물 검색</legend>

	<form name="fsearch" method="get">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required  class="frm_input required" size="15" maxlength="15">
	<input type="submit" value="검색" class="ui-btn">
	</form>
</fieldset>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
	var f = document.fqalist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_qa_id[]")
			f.elements[i].checked = sw;
	}
}

function fqalist_submit(f) {
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택삭제") {
		if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
			return false;
	}

	return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->