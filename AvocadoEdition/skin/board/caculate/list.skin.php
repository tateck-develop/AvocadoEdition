<?
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$colspan = 5;
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

if($is_member) { 
	set_session('ss_bo_table', $_REQUEST['bo_table']);
}

// 기본 설정 불러오기
$commu_conf = sql_fetch(" select * from {$g5['article_default_table']} ");

$write_action_url = G5_BBS_URL."/write_update.php";
?>

<? if($board['bo_content_head']) { ?>
	<div class="board-notice">
		<?=stripslashes($board['bo_content_head']);?>
	</div><hr class="padding" />
<? } ?>

<? if ($write_href) { 
	$upload_action_url = G5_BBS_URL."/write_update.php";
	$category_option = get_category_option($bo_table, $sca);
?>
<div class="list-write-area">
	<a href="#" class="btn-write ui-btn point" onclick="$('#write_box').slideToggle(); return false;">정산글 등록하기</a>

	<div id="write_box" class="none-trans" style="display: none;">
		<form name="fwrite" id="fwrite" action="<?php echo $upload_action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
			<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
			<input type="hidden" name="w" value="<?php echo $w ?>">
			<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
			<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
			<input type="hidden" name="redirect" value="1">
			<input type="hidden" name="wr_subject" value="<?=$character['ch_name'] ? $character['ch_name'] : "GUEST"?>" />

			<div class="list-write-box">
				<select name="ca_name" id="ca_name" required class="required" >
					<option value="">정산 분류 선택</option>
					<?php echo $category_option ?>
				</select>
				
				<fieldset>
					<textarea name="wr_content"></textarea>
				</fieldset>
				<button type="submit" id="btn_submit" accesskey="s" class="ui-btn">등록하기</button>
			</div>
		</form>
		<script>
			function fwrite_submit(f) {
				if (document.getElementById("char_count")) {
					if (char_min > 0 || char_max > 0) {
						var cnt = parseInt(check_byte("wr_content", "char_count"));
						if (char_min > 0 && char_min > cnt) {
							alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
							return false;
						}
						else if (char_max > 0 && char_max < cnt) {
							alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
							return false;
						}
					}
				}

				document.getElementById("btn_submit").disabled = "disabled";
				return true;
			}
		</script>
			
	</div>
</div>
<? } ?>


<div class="board-skin-caculate">

	<!-- 게시판 카테고리 시작 { -->
	<? if ($is_category) { ?>
	<nav  class="board-category">
		<select name="sca" id="sca" onchange="location.href='?bo_table=<?=$bo_table?>&sca=' + this.value;">
			<option value="">전체</option>
			<? echo $category_option ?>
		</select>
	</nav>
	<? } ?>
	<!-- } 게시판 카테고리 끝 -->

	<div class="board-list">
<?
	for ($i=0; $i<count($list); $i++) {
		$data = $list[$i];
		$ch = get_character($data['ch_id']);
		$content = conv_content($data['wr_content'], 0, 'wr_content');
?>
		<div class="calc-item">
			<div class="thumb">
				<img src="<?=$ch['ch_thumb']?>" />
			</div>
			<div class="con-box theme-box">
				<div class="inner">
					<p class="name">
						<? if($data['wr_10']) { ?><i class="state" data-item = "<?=$data['wr_10']?>"><?=$data['wr_10']?></i><? } ?>
						<span>
							<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$ch['ch_id']?>"><?=$ch['ch_name']?></a>
							[ <?=$data['wr_name']?> ]

							<?
								if(($data['mb_id'] == $member['mb_id'] && $data['wr_10'] == '') || $is_admin) { 
									$delete_href ='./delete.php?bo_table='.$bo_table.'&amp;wr_id='.$data['wr_id'];
							?>
						</span>
						<sup class="calc-btn-box">
							<a href="#" onclick="$(this).closest('.con-box').find('.modify-con').toggle(); return false;" class="btn-mod">수정</a>
							<a href="<?=$delete_href?>"  class="btn-del">삭제</a>
						</sup>
						<? } ?>
					</p>
					<div class="con">
						<?=$content?>
					</div>

					<? if(($data['mb_id'] == $member['mb_id'] && $data['wr_10'] == '') || $is_admin) { ?>
					<div class="modify-con">
						<form name="fwrite_<?=$data['wr_id']?>" action="<?php echo $write_action_url ?>" method="post" onsubmit="return fwrite_submit(this);" autocomplete="off">
							<input type="hidden" name="w" value="u">
							<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
							<input type="hidden" name="wr_10" value="<?php echo $data['wr_10'] ?>">
							<input type="hidden" name="wr_id" value="<?php echo $data['wr_id'] ?>">
							<input type="hidden" name="wr_subject" value="<?php echo $data['wr_subject'] ?>">
							<select name="ca_name">
								<option value="">정산 분류 선택</option>
								<?php echo get_category_option($bo_table, $data['ca_name']); ?>
							</select>
							<textarea name="wr_content"><?=$data['wr_content']?></textarea>
							<button type="submit" id="btn_submit" accesskey="s" class="btn_submit ui-btn point">내용수정완료</button>
						</form>
					</div>
					<? } ?>

					<? include($board_skin_path."/view_comment.php");?>
					<? if($is_admin) { ?>
					<div class="comment-form-box">
						<? include($board_skin_path."/write_comment.php");?>
					</div>
					<? } ?>
				</div>
			</div>
		</div>


<? } ?>
	</div>

	<!-- 페이지 -->
	<? echo $write_pages;  ?>

	<!-- 게시판 검색 시작 { -->
	<fieldset id="bo_sch" class="txt-center">
		<legend>게시물 검색</legend>

		<form name="fsearch" method="get">
		<input type="hidden" name="bo_table" value="<? echo $bo_table ?>">
		<input type="hidden" name="sca" value="<? echo $sca ?>">
		<input type="hidden" name="sop" value="and">
		<select name="sfl" id="sfl">
			<option value="wr_subject"<? echo get_selected($sfl, 'wr_subject', true); ?>>캐릭터명</option>
			<option value="wr_content"<? echo get_selected($sfl, 'wr_content'); ?>>내용</option>
			<option value="mb_id,1"<? echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
			<option value="mb_id,0"<? echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
			<option value="wr_name,1"<? echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
			<option value="wr_name,0"<? echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
		</select>
		<input type="text" name="stx" value="<? echo stripslashes($stx) ?>" id="stx" class="frm_input" size="15" maxlength="20">
		<button type="submit" class="ui-btn point ico search default">검색</button>
		</form>
	</fieldset>
	<!-- } 게시판 검색 끝 -->
</div>

<script>
var avo_mb_id = "<?=$member['mb_id']?>";
var avo_board_skin_path = "<?=$board_skin_path?>";
var avo_board_skin_url = "<?=$board_skin_url?>";

var save_before = '';
var save_html = '';

function fviewcomment_submit(f)
{
	set_comment_token(f);
	var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"content": f.wr_content.value
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(data, textStatus) {
			content = data.content;
		}
	});

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		f.wr_content.focus();
		return false;
	}
	
	if (!f.wr_content.value) {
		alert("댓글을 입력하여 주십시오.");
		return false;
	}

	if (typeof(f.wr_name) != 'undefined')
	{
		f.wr_name.value = f.wr_name.value.replace(pattern, "");
		if (f.wr_name.value == '')
		{
			alert('이름이 입력되지 않았습니다.');
			f.wr_name.focus();
			return false;
		}
	}

	if (typeof(f.wr_password) != 'undefined')
	{
		f.wr_password.value = f.wr_password.value.replace(pattern, "");
		if (f.wr_password.value == '')
		{
			alert('비밀번호가 입력되지 않았습니다.');
			f.wr_password.focus();
			return false;
		}
	}

	return true;
}

function comment_delete()
{
	return confirm("이 댓글을 삭제하시겠습니까?");
}

function comment_box(co_id, wr_id) { 
	$('.modify_area').hide();
	$('.original_comment_area').show();

	$('#c_'+co_id).find('.modify_area').show();
	$('#c_'+co_id).find('.original_comment_area').hide();

	$('#save_co_comment_'+co_id).focus();

	var modify_form = document.getElementById('frm_modify_comment');
	modify_form.wr_id.value = wr_id;
	modify_form.comment_id.value = co_id;
}

function modify_commnet(co_id) { 
	var modify_form = document.getElementById('frm_modify_comment');
	var wr_content = $('#save_co_comment_'+co_id).val();

	modify_form.wr_content.value = wr_content;
	$('#frm_modify_comment').submit();
}

</script>

<form name="modify_comment" id="frm_modify_comment"  action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="w" value="cu">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">

	<input type="hidden" name="comment_id" value="">
	<input type="hidden" name="wr_id" value="">
	<textarea name="wr_content" style="display: none;"></textarea>
	<button type="submit" style="display: none;"></button>
</form>
