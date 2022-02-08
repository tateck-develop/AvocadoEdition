<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if($is_admin) set_session("ss_delete_token", $token = uniqid(time()));
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

if($is_member)  {
	$comment_token = uniqid(time());
	set_session('ss_comment_token', $comment_token);
}

?>

<div id="page_board_content">

<!-- 상단 공지 부분 -->
<? if($board['bo_content_head']) { ?>
	<div class="board-notice">
		<?=stripslashes($board['bo_content_head']);?>
	</div>
	<hr class="padding" />
<? } ?>

	<!-- 버튼 링크 -->
	<div class="search-box">
		<form name=fsearch method=get style="margin:0px;">
			<input type="hidden" name="bo_table" value="<?=$bo_table?>">
			<input type="hidden" name="sca"      value="<?=$sca?>">
			<input type="hidden" name="sfl" value='wr_subject||wr_content'>
			<input type="hidden" name="sop" value="and">
			
			<input type="text" name="stx" itemname="검색어" value="<?=$stx?>" >
			<button type="submit" class="ui-btn">SEARCH</button>
		</form>
	</div>

	<? if ($write_href) { ?>
	<div class="ui-write-area">
		<? include ($board_skin_path."/write.php"); ?>
	</div>
	<? } ?>

	<div class="ui-qna-list">
		<ul>
	<? 
		$lists = array();
		for ($i=0; $i<count($list); $i++) { $lists[$i] = $list[$i]; } 
		
		for ($ii=0; $ii < count($lists); $ii++) {
			$profile = get_member($lists[$ii]['mb_id']);
			include "$board_skin_path/inc.list_main.php"; 
			$lists[$ii]['datetime']=substr($lists[$ii]['wr_datetime'],0,4)."/".substr($lists[$ii]['wr_datetime'],5,2)."/".substr($lists[$ii]['wr_datetime'],8,2)." (".substr($lists[$ii]['wr_datetime'],11,8).")";

			$is_open = check_password(get_cookie('read_'.$lists[$ii]['wr_id']), $lists[$ii]['wr_password']);

			$lists[$ii]['content'] = conv_content($lists[$ii]['wr_content'], 0, 'wr_content');
			$lists[$ii]['content'] = search_font($stx, $lists[$ii]['content']);
	?>
				<li>
					<form name="fboardlist" method="post" action="<?=$board_skin_url?>/password.php" style="margin:0">
						<input type="hidden" name="bo_table" value="<?=$bo_table?>">
						<input type="hidden" name="sfl"      value="<?=$sfl?>">
						<input type="hidden" name="stx"      value="<?=$stx?>">
						<input type="hidden" name="spt"      value="<?=$spt?>">
						<input type="hidden" name="page"     value="<?=$page?>">
						<input type="hidden" name="wr_idx"     value="<?=$lists[$ii]['wr_id']?>">
						<input type="hidden" name="sw"       value="">
						
						<div  class="theme-box">
							<p>
							<? if($lists[$ii]['is_notice']) { ?>
								<i>NOTICE</i>
							<? } else { ?>
								<i>NO.<?=$lists[$ii]['num'];?></i>
							<? } ?>
								<em>
									<?=$lists[$ii]['name']?> <? if($is_admin) { ?> [ <?=$lists[$ii]['wr_ip']?> ]<? } ?>
								</em>
								<strong>
									<? if(($member['mb_id'] && ($member['mb_id'] == $lists[$ii]['mb_id'])) || $is_admin) { ?>
										<a href="<?=$delete_href?>">D</a>
									<? } else if (!$lists[$ii]['mb_id']) { ?>
										<a href="<?=$delete_href?>">D</a>
									<? } ?>
									<? if($is_admin) { ?>
										<a href="javascript:comment_wri('comment_write', '<?=$lists[$ii]['wr_id']?>');">R</a>
									<? } ?>
								</strong>
								<span class="date">
									<?=$lists[$ii]['datetime']?>
								</span>
							</p>
							<div class="qna-content">
								<?
									if(strstr($lists[$ii]['wr_option'], 'secret') && !$is_admin && !$is_open) { 
								?>
								<fieldset class="ui-qna-list-password">
									<input type="password" name="wr_password" id="wr_password_<?=$ii?>" value="" placeholder="PASSWORD"/>
									<button type="submit" class="ui-submit ui-btn">ENTER</button>
								</fieldset>
								<? } else { ?>
								<? if(strstr($lists[$ii]['wr_option'], 'secret')) { ?>
									<span style="color: #efb04e;">[SECRET]</span><br />
								<? } ?>
									<?= $lists[$ii]['content'] ?>
									<? echo $secret_msg; ?>
								<? } ?>
							</div>
						</div>
					</form>
					<? 
						if(strstr($lists[$ii]['wr_option'], 'secret') && !$is_admin && !$is_open) { 

						} else { 
							$wr_id = $lists[$ii]['wr_id'];
							include ("$board_skin_path/view_comment.php");
						}
					?>
				</li>
	<?	} 
		// 필터
		if (!$member['mb_id']) // 비회원일 경우에만
			echo "<script language='javascript' src='{$g5['path']}/js/md5.js'></script>\n";
	?>
	<? if (count($lists) == 0) { echo "<li class='no-data'>질문 내역이 없습니다.</li>"; } ?>
		</ul>

		<!-- 페이지 -->

		<div class="ui-page">
			<? if ($prev_part_href) { echo "<a href='$prev_part_href'><img src='$board_skin_path/img/btn_search_prev.gif' border=0 align=absmiddle title='이전검색'></a>"; } ?>
			<?
			// 기본으로 넘어오는 페이지를 아래와 같이 변환하여 이미지로도 출력할 수 있습니다.
			//echo $write_pages;
			$write_pages = str_replace("처음", "<<", $write_pages);
			$write_pages = str_replace("이전", "Prev", $write_pages);
			$write_pages = str_replace("다음", "Next", $write_pages);
			$write_pages = str_replace("맨끝", ">>", $write_pages);
			$write_pages = preg_replace("/<span>([0-9]*)<\/span>/", "$1", $write_pages);
			$write_pages = preg_replace("/<b>([0-9]*)<\/b>/", "<b><font class=\"color_gold2\">$1</font></b>", $write_pages);
			?>
			<?=$write_pages?>
			<? if ($next_part_href) { echo "<a href='$next_part_href'><img src='$board_skin_path/img/btn_search_next.gif' border=0 align=absmiddle title='다음검색'></a>"; } ?>
		</div>

	</div>
</div>

<script language="JavaScript">
//if ("<?=$sca?>") document.fcategory.sca.value = "<?=$sca?>";
if ("<?=$stx?>") {
	document.fsearch.sfl.value = "<?=$sfl?>";
	document.fsearch.sop.value = "<?=$sop?>";
}
</script>

<script language="JavaScript">
// HTML 로 넘어온 <img ... > 태그의 폭이 테이블폭보다 크다면 테이블폭을 적용한다.
function resize_image()
{
	var target = document.getElementsByName('target_resize_image[]');
	var image_width = parseInt('<?=$board['bo_image_width']?>');
	var image_height = 0;

	for(i=0; i<target.length; i++) { 
		// 원래 사이즈를 저장해 놓는다
		target[i].tmp_width  = target[i].width;
		target[i].tmp_height = target[i].height;
		// 이미지 폭이 테이블 폭보다 크다면 테이블폭에 맞춘다
		if(target[i].width > image_width) {
			image_height = parseFloat(target[i].width / target[i].height)
			target[i].width = image_width;
			target[i].height = parseInt(image_width / image_height);
		}
	}
}

window.onload = resize_image;
</script>

<? if ($is_checkbox) { ?>
<script language="JavaScript">
function all_checked(sw)
{
	var f = document.fboardlist;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]")
			f.elements[i].checked = sw;
	}
}

function check_confirm(str)
{
	var f = document.fboardlist;
	var chk_count = 0;

	for (var i=0; i<f.length; i++) {
		if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
			chk_count++;
	}

	if (!chk_count) {
		alert(str + "할 게시물을 하나 이상 선택하세요.");
		return false;
	}
	return true;
}

// 선택한 게시물 삭제
function select_delete()
{
	var f = document.fboardlist;

	str = "삭제";
	if (!check_confirm(str))
		return;

	if (!confirm("선택한 게시물을 정말 "+str+" 하시겠습니까?\n\n한번 "+str+"한 자료는 복구할 수 없습니다"))
		return;

	f.action = "./delete_all.php";
	f.submit();
}

// 선택한 게시물 복사 및 이동
function select_copy(sw)
{
	var f = document.fboardlist;

	if (sw == "copy")
		str = "복사";
	else
		str = "이동";

	if (!check_confirm(str))
		return;

	var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

	f.sw.value = sw;
	f.target = "move";
	f.action = "./move.php";
	f.submit();
}
</script>
<? } ?>
