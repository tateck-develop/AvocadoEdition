<?php
$sub_menu = "500200";
include_once('./_common.php');

$category = explode("||", $config['cf_item_category']);

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['item_table']} ";
$sql_search = " where (1) ";

if ($stx) {
	$sql_search .= " and ( ";
	switch ($sfl) {
		default :
			$sql_search .= " ({$sfl} like '%{$stx}%') ";
			break;
	}
	$sql_search .= " ) ";
}

if($cate) { $sql_search .= " and it_category = '{$cate}' "; }

if($type) { $sql_search .= " and it_type = '{$type}' "; }

if (!$sst) {
	$sst  = "it_id";
	$sod = "asc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '아이템 관리';
include_once('./admin.head.php');

$colspan = 15;
?>

<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	추가된 아이템 수 <?php echo number_format($total_count) ?>개
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<select name="cate" id="cate">
	<option value="">아이템 종류</option>
	<option value="일반" <?=$cate == "일반" ? "selected" : ""?>>일반 아이템</option>
	<option value="개인" <?=$cate == "개인" ? "selected" : ""?>>개인 아이템</option>
	<option value="출석" <?=$cate == "출석" ? "selected" : ""?>>출석 아이템</option>
</select>
<select name="type">
	<option value="">아이템 기능</option>
<? for($k =0; $k < count($category); $k++) { 
	if(!$category[$k]) continue;
?>
	<option value="<?=$category[$k]?>" <?=$type == $category[$k] ? "selected" : ""?>><?=$category[$k]?></option>
<? } ?>
	<option value="뽑기" <?=$type == "뽑기" ? "selected" : ""?>>뽑기</option>
</select>


<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
	<option value="it_name"<?php echo get_selected($_GET['sfl'], "it_name", true); ?>>아이템 이름</option>
	<option value="it_content"<?php echo get_selected($_GET['sfl'], "it_content"); ?>>아이템 설명</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx">
<input type="submit" value="검색" class="btn_submit">

</form>

<?php if ($is_admin == 'super') { ?>
<div class="btn_add01 btn_add">
	<a href="./item_form.php" id="bo_add">아이템 추가</a>
</div>
<?php } ?>

<form name="fitemlist" id="fitemlist" action="./item_list_update.php" onsubmit="return fitemlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">

<input type="hidden" name="cate" value="<?php echo $cate ?>">
<input type="hidden" name="map_id" value="<?php echo $map_id ?>">

<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">

<div class="tbl_head01 tbl_wrap">
	<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width:  40px;" />
			<col style="width: 80px;" />
			<col style="width: 120px;" />
			<col style="width: 100px;" />

			<col style="width: 60px;" />
			<col />
			

			<col style="width: 50px;"/>
			<col style="width: 50px;"/>
			<col style="width: 50px;"/>
			<col style="width: 50px;"/>
			<col style="width: 70px;"/>
			
			<col style="width: 50px;"/>
			<col style="width: 80px;"/>

			<col style="width: 50px;"/>
			<col style="width: 60px;"/>
		</colgroup>
		<thead>
			<tr>
				<th scope="col" class="bo-right">
					<label for="chkall" class="sound_only">아이템 전체</label>
					<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
				</th>
				<th scope="col">분류</th>
				<th scope="col" colspan="2">기능</th>

				<th scope="col" colspan="2">아이템</th>

				<th scope="col">귀속</th>
				<th scope="col">영구</th>
				<th scope="col">인벤</th>
				<th scope="col">자비</th>
				<th scope="col">레시피</th>
				<th scope="col" colspan="2">되팔기</th>
				<th scope="col">사용</th>
				<th scope="col">관리</th>
			</tr>
		</thead>
		<tbody>
			<?php
			for ($i=0; $item=sql_fetch_array($result); $i++) {
				$one_update = '<a href="./item_form.php?w=u&amp;it_id='.$item['it_id'].'&amp;'.$qstr.'">수정</a>';
				$bg = 'bg'.($i%2);
			?>

			<tr class="<?php echo $bg; ?>">
				<td>
					<label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($item['it_name']) ?></label>
					<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
					<input type="hidden" name="it_id[<?php echo $i ?>]" value="<?php echo $item['it_id'] ?>" />
				</td>
				<td>
					<select name="it_category[<?php echo $i ?>]" id="it_category_<?php echo $i ?>" style="display: block; width:100%;">
						<option value="일반" <?=$item['it_category'] == "일반" ? "selected" : ""?>>일반</option>
						<option value="개인" <?=$item['it_category'] == "개인" ? "selected" : ""?>>개인</option>
						<option value="출석" <?=$item['it_category'] == "출석" ? "selected" : ""?>>출석</option>
					</select>
				</td>
				<td>
					<select name="it_type[<?php echo $i ?>]" style="width:100%;">
						<? for($k =0; $k < count($category); $k++) { 
							if(!$category[$k]) continue;
						?>
							<option value="<?=$category[$k]?>" <?=$item['it_type'] == $category[$k] ? "selected" : ""?>><?=$category[$k]?></option>
						<? } ?>
							<option value="뽑기" <?=$item['it_type'] == "뽑기" ? "selected" : ""?>>뽑기 아이템</option>
					</select>
				</td>
				<td>
					<input type="text" name="it_value[<?php echo $i ?>]" value="<?php echo get_text($item['it_value']) ?>" id="it_value_<?php echo $i ?>" size="8">
				</td>

				<td class="txt-center">
				<? if($item['it_img']) { ?>
					<img src="<?=$item['it_img']?>" style="max-width: 40px;"/>
				<? } else { ?>
					이미지없음
				<? } ?>
				</td>
				<td class="txt-left">
					<input type="text" name="it_name[<?php echo $i ?>]" value="<?php echo get_text($item['it_name']) ?>" id="it_name_<?php echo $i ?>" size="20" style="width:100%;">
				</td>
				
				<td>
					<input type="checkbox" name="it_has[<?php echo $i ?>]" value="1" id="it_has_<?php echo $i ?>" <?php echo $item['it_has']?"checked":"" ?>>
				</td>
				<td>
					<input type="checkbox" name="it_use_ever[<?php echo $i ?>]" value="1" id="it_use_ever_<?php echo $i ?>" <?php echo $item['it_use_ever']?"checked":"" ?>>
				</td>
				<td>
					<input type="checkbox" name="it_use_able[<?php echo $i ?>]" value="1" id="it_use_able_<?php echo $i ?>" <?php echo $item['it_use_able']?"checked":"" ?>>
				</td>
				<td>
					<input type="checkbox" name="it_use_mmb_able[<?php echo $i ?>]" value="1" id="it_use_mmb_able_<?php echo $i ?>" <?php echo $item['it_use_mmb_able']?"checked":"" ?>>
				</td>
				<td>
					<input type="checkbox" name="it_use_recepi[<?php echo $i ?>]" value="1" id="it_use_recepi_<?php echo $i ?>" <?php echo $item['it_use_recepi']?"checked":"" ?>>
				</td>

				<td>
					<input type="checkbox" name="it_use_sell[<?php echo $i ?>]" value="1" id="it_use_sell_<?php echo $i ?>" <?php echo $item['it_use_sell']?"checked":"" ?>>
				</td>
				<td>
					<input type="text" name="it_sell[<?php echo $i ?>]" value="<?php echo get_text($item['it_sell']) ?>" id="it_sell_<?php echo $i ?>" size="5">
				</td>

				<td>
					<input type="checkbox" name="it_use[<?php echo $i ?>]" value="Y" id="it_use_<?php echo $i ?>" <?php echo $item['it_use']?"checked":"" ?>>
				</td>
				<td class="td_mngsmall">
					<?php echo $one_update ?>
					<?php echo $one_copy ?>
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
	<?php if ($is_admin == 'super') { ?>
	<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
	<?php } ?>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?'.$qstr.'&amp;type='.$type.'&amp;cate='.$cate.'&amp;cate2='.$cate2.'&amp;map_id='.$map_id.'&amp;page='); ?>

<script>
function fitemlist_submit(f)
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
include_once('./admin.tail.php');
?>
