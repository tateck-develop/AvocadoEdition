<?php
$sub_menu = "600200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$sql_common = " from {$g5['random_table']} ";

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

$colspan = 7;



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
				<col style="width: 500px;"/>
				<col  />
				<col style="width: 50px;" />
			</colgroup>
			<thead>
			<tr>
				<th scope="col">
					<label for="chkall" class="sound_only">랜덤주사위 내역 전체</label>
					<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
				</th>
				<th scope="col">IDX</th>
				<th scope="col">랜덤주사위명</th>
				<th scope="col">이미지</th>
				<th scope="col">랜덤텍스트</th>
				<th scope="col">사용여부</th>
			</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$bg = 'bg'.($i%2);
			?>

			<tr class="<?php echo $bg; ?>">
				<td style="text-align: center" rowspan="2">
					<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
				</td>
				<td rowspan="2">
					<input type="text" name="ra_id[<?php echo $i ?>]" value="<?php echo $row['ra_id'] ?>" id="ra_id_<?php echo $i ?>" readonly style="width: 30px;">
				</td>
				<td rowspan="2">
					<input type="text" name="ra_title[<?php echo $i ?>]" value="<?php echo $row['ra_title'] ?>" class="frm_input" style="width: 98%;">
				</td>

				<td  style="text-align: center">
					<?
						$images = nl2br($row['ra_img']);
						$link_list = explode('<br />', $images);
						$link_list = array_values(array_filter(array_map('trim',$link_list)));
						for($j=0; $j < count($link_list); $j++) {
							$r_row = $link_list[$j];
							if(!$r_row) continue;
					?>
								<img src="<?=$r_row?>" style="max-width: 30px; max-height: 30px;"/>&nbsp;
					<? } ?>
				</td>
				
				<td rowspan="2">
					<textarea name="ra_text[<?=$i?>]"><?php echo $row['ra_text'] ?></textarea>
				</td>
				<td rowspan="2">
					<input type="checkbox" name="ra_use[<?=$i?>]" value="1" <?=($row['ra_use'] ? "checked" : "")?>>
				</td>
			</tr>
			<tr>
				<td style="text-align: center">
					<textarea name="ra_img[<?=$i?>]" style="height: 80px;"><?php echo $row['ra_img'] ?></textarea>
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

<section id="anc_002">
	<h2 class="h2_frm">랜덤주사위정보 등록</h2>
	<?php echo $pg_anchor ?>

	<form name="fclassform" method="post" id="fclassform" action="./random_update.php" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<colgroup>
			<col style="width: 120px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><label for="ra_use">사용여부</label></th>
			<td><input type="checkbox" name="ra_use" id="ra_use" value="1" checked></td>
		</tr>
		<tr>
			<th scope="row"><label for="ra_title">랜덤주사위명<strong class="sound_only">필수</strong></label></th>
			<td><input type="text" name="ra_title" id="ra_title" class="required frm_input" required></td>
		</tr>
		<tr>
			<th scope="row"><label for="ra_img">주사위 이미지<strong class="sound_only">필수</strong></label></th>
			<td>
				<?php echo help("랜덤으로 출력될 주사위 이미지의 경로들을 입력해 주시길 바랍니다.\n여러개 입력 시, 엔터로 구분해 주시길 바랍니다.") ?>
				<textarea name="ra_img"></textarea>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="ra_text">랜덤텍스트</label></th>
			<td>
				<?php echo help("랜덤으로 출력될 텍스트를 입력해 주시길 바랍니다.\n여러개 입력 시, 엔터로 구분해 주시길 바랍니다.") ?>
				<textarea name="ra_text"></textarea>
			</td>
		</tr>
		</tbody>
		</table>
	</div>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="확인" class="btn_submit">
	</div>

	</form>

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
