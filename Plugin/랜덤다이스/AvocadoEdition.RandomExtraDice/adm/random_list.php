<?php
$sub_menu = "600200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['random_dice_table']} ";

$sql_search = " where (1) ";

if (!$sst) {
	$sst  = "ra_id";
	$sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
			{$sql_common}
			{$sql_search}
			{$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
			{$sql_common}
			{$sql_search}
			{$sql_order}
			limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '랜덤주사위 관리';
include_once ('./admin.head.php');

$colspan = 13;


$now_board = "";
$search_board_sql = " select bo_table, bo_subject from {$g5['board_table']} where bo_type = 'mmb' order by bo_subject asc ";
$search_board = sql_query($search_board_sql);
$board_select_option = array();
for($i=0; $row=sql_fetch_array($search_board); $i++) { 
	$board_select_option[] = $row;
}


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">랜덤주사위 목록</a></li>
	<li><a href="#anc_002">랜덤주사위 등록</a></li>
</ul>';

?>

<section id="anc_001">
	<h2 class="h2_frm">랜덤주사위 목록</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php echo $listall ?>
		전체 <?php echo number_format($total_count) ?> 건
	</div>

	<div class="btn_add01 btn_add">
		<a href="./random_form.php" id="bo_add">랜덤주사위 추가</a>
	</div>

	<form name="fclasslist" id="fclasslist" method="post" action="./random_list_delete.php" onsubmit="return fclasslist_submit(this);"  enctype="multipart/form-data">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="hidden" name="token" value="<?php echo $token ?>">

		<div class="tbl_head01 tbl_wrap">
			<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<colgroup>
				<col style="width: 50px;" />
				<col style="width: 50px;" />
				<col style="width: 120px;"/>
				<col />
				<col style="width: 120px;"/>
				<col style="width: 80px;"/>
				<col style="width: 100px;"/>
				<col style="width: 100px;" />
				<col style="width: 100px;" />
				<col style="width: 100px;" />
				<col style="width: 100px;" />
				<col style="width: 50px;" />
				<col style="width: 100px;" />
			</colgroup>
			<thead>
			<tr>
				<th scope="col">
					<label for="chkall" class="sound_only">랜덤주사위 내역 전체</label>
					<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
				</th>
				<th scope="col">IDX</th>
				<th scope="col">게시판IDX</th>
				<th scope="col">랜덤주사위명</th>
				<th scope="col">등록현황</th>
				<th scope="col" colspan="2">굴림제한</th>
				<th scope="col">상태바 사용</th>
				<th scope="col">최대</th>
				<th scope="col">추가</th>
				<th scope="col">감소</th>
				<th scope="col">사용여부</th>
				<th scope="col">관리</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$bg = 'bg'.($i%2);
			?>

			<tr class="<?php echo $bg; ?>">
				<td style="text-align: center">
					<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
				</td>
				<td>
					<input type="text" name="ra_id[<?php echo $i ?>]" value="<?php echo $row['ra_id'] ?>" id="ra_id_<?php echo $i ?>" readonly style="width: 30px;">
				</td>
				<td>
					<select name="bo_table[<?php echo $i ?>]" style="width:100%;">
						<? for($j=0; $j < count($board_select_option); $j++) { ?>
							<option value="<?=$board_select_option[$j]['bo_table']?>" <?=$row['bo_table'] == $board_select_option[$j]['bo_table'] ? "selected" : ""?>>
								<?=$board_select_option[$j]['bo_subject']?>
							</option>
						<? } ?>
					</select>
				</td>
				<td>
					<input type="text" name="ra_title[<?php echo $i ?>]" value="<?php echo $row['ra_title'] ?>" class="frm_input" style="width: 98%;">
				</td>

				<td  style="text-align: center">
					<?
						$images = nl2br($row['ra_img']);
						$img_list = explode('<br />', $images);
						$add_str = '';

						if(count($img_list) > 1) { echo "이미지 <span style='color:red'>".count($img_list)."</span>건 "; $add_str = " / ";}

						$texts = nl2br($row['ra_text']);
						$text_list = explode('<br />', $texts);

						if(count($text_list) > 1) { echo $add_str."텍스트 <span style='color:red'>".count($text_list)."</span>건 ";}
					?>
				</td>
				<td style="border-right-width:0; padding-right:0;">
					<input type="text" name="ra_limit[<?php echo $i ?>]" value="<?php echo $row['ra_limit'] ?>" class="frm_input" style="width: 40px; text-align:center;"> 회
				</td>
				<td>
					<input type="checkbox" id="ra_limit_day_<?=$i?>" name="ra_limit_day[<?=$i?>]" value="1" <?=($row['ra_limit_day'] ? "checked" : "")?>> <label for="ra_limit_day_<?=$i?>">1일초기화</label>
				</td>
				<td>
					<input type="checkbox" name="ra_progress[<?=$i?>]" value="1" <?=($row['ra_progress'] ? "checked" : "")?>>
				</td>
				<td>
					<input type="text" name="ra_progress_max[<?php echo $i ?>]" value="<?php echo $row['ra_progress_max'] ?>" class="frm_input" style="width: 98%;">
				</td>
				<td>
					<input type="text" name="ra_progress_p[<?php echo $i ?>]" value="<?php echo $row['ra_progress_p'] ?>" class="frm_input" style="width: 98%;">
				</td>
				<td>
					<input type="text" name="ra_progress_m[<?php echo $i ?>]" value="<?php echo $row['ra_progress_m'] ?>" class="frm_input" style="width: 98%;">
				</td>
				<td>
					<input type="checkbox" name="ra_use[<?=$i?>]" value="1" <?=($row['ra_use'] ? "checked" : "")?>>
				</td>
				<td>
					<a href="./random_form.php?ra_id=<?=$row['ra_id']?>&amp;w=u">내용수정</a>
				</td>
			</tr>

			<?php
			}

			if ($i == 0)
				echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
			?>
			</tbody>
			</table>
		</div>

		<div class="btn_list01 btn_list">
			<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
			<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
		</div>

	</form>

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['PHP_SELF']}?$qstr&amp;page="); ?>
</section>


<script>
function fclasslist_submit(f)
{
	if (!is_checked("chk[]")) {
		alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
		return false;
	}

	if(document.pressed == "선택삭제") {
		if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
			return false;
		}
	}

	return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
