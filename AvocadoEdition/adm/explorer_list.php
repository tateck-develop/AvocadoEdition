<?php
$sub_menu = "500210";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['explorer_table']} ";

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

if($sch_it_id) { 
	$sql_search .= " and it_id = '{$sch_it_id}' ";
}

if (!$sst) {
	$sst  = "ie_id";
	$sod = "desc";
}
$sql_order = " order by it_id asc, {$sst} {$sod} ";

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

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '아이템 뽑기 관리';
include_once('./admin.head.php');


$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">뽑기 설정 목록</a></li>
	<li><a href="#anc_002">뽑기 등록</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

$colspan = 5;

if($sch_it_id) { 
	$sch_it = get_item($sch_it_id);
	$sch_it_name = $sch_it['it_name'];
	$sch_it_img = $sch_it['it_img'];
}

?>

<section id="anc_001">

	<h2 class="h2_frm">뽑기 설정 목록</h2>
	<?php echo $pg_anchor ?>

	<div class="local_ov01 local_ov">
		<?php echo $listall ?>
		등록된 뽑기 설정 수 <?php echo number_format($total_count) ?>개
	</div>

<? if($sch_it_name) { ?>
	<div style="padding-bottom: 10px;">
		<img src="<?=$sch_it_img?>" style="width: 50px;"/>
		[ <?=$sch_it_name?> ] 뽑기 설정
	</div>
<? } ?>

	<form name="ftitlelist" id="ftitlelist" action="./explorer_list_update.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sch_it_id" value="<?php echo $sch_it_id ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="">

	<div class="tbl_head01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<colgroup>
			<col style="width: 45px;" />
			<col style="width: 100px;" />
			<col style="width: 200px;" />

			<col style="width: 100px;" />
			<col style="width: 200px;" />
			<col />
		</colgroup>
		<thead>
		<tr>
			<th scope="col">
				<label for="chkall" class="sound_only">현재 페이지 타이틀 전체</label>
				<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
			</th>
			<th colspan="2">뽑기아이템</th>
			<th colspan="2">획득아이템</th>
			<th>획득구간</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for ($i=0; $ie=sql_fetch_array($result); $i++) {
			$it = sql_fetch("select it_id, it_name, it_img from {$g5['item_table']} where it_id = '{$ie['it_id']}'");
			$re_it = sql_fetch("select it_id, it_name, it_img from {$g5['item_table']} where it_id = '{$ie['re_it_id']}'");
			$bg = 'bg'.($i%2);
		?>

		<tr class="<?php echo $bg; ?>">
			<td>
				<input type="hidden" name="ie_id[<?php echo $i ?>]" value="<?php echo $ie['ie_id'] ?>" id="ie_id_<?php echo $i ?>">
				<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
			</td>
			<td>
				<? if($it['it_img']) { ?>
				<img src="<?=$it['it_img']?>" style="max-width: 50px;"/>
				<? } else { ?>
				이미지 없음
				<? } ?>
			</td>
			<td>
				<a href="?sch_it_id=<?=$it['it_id']?>"><?=$it['it_name']?></a>
			</td>

			<td>
				<? if($re_it['it_img']) { ?>
				<img src="<?=$re_it['it_img']?>" style="max-width: 50px;"/>
				<? } else { ?>
				이미지 없음
				<? } ?>
			</td>
			<td>
				<?=$re_it['it_name']?>
			</td>

			<td>
				<input type="text" name="ie_per_s[<?php echo $i ?>]" value="<?php echo $ie['ie_per_s']; ?>" size="5" maxlength="11">
				~
				<input type="text" name="ie_per_e[<?php echo $i ?>]" value="<?php echo $ie['ie_per_e']; ?>" size="5" maxlength="11"> 구간 획득
			</td>
		</tr>

		<?php
		}
		if ($i==0)
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

	<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

	<script>
	$(function() {
		$('#ftitlelist').submit(function() {
			if (!is_checked("chk[]")) {
				alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
				return false;
			}
			if(document.pressed == "선택삭제") {
				if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
					return false;
				}
			}

			return true;
		});
	});
	</script>
</section>

<?
if(!$sch_it_id || $sch_it['it_type'] == '뽑기') { 
?>
<section id="anc_002" style="margin-top: 0; margin-bottom: 50px;">
	<form name="fexplorerlist2" method="post" id="fexplorerlist2" action="./explorer_update.php" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="sst" value="<?php echo $sst ?>">
	<input type="hidden" name="sod" value="<?php echo $sod ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="token" value="<?php echo $token ?>">
	<input type="hidden" name="sch_it_id" value="<?php echo $sch_it_id ?>">

	<h2 class="h2_frm">뽑기 등록</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<colgroup>
				<col style="width: 120px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">뽑기 아이템</th>
					<td>
					<? if($sch_it_name) { ?>
						<input type="hidden" name="it_id" value="<?=$sch_it_id?>" />
						<input type="hidden" name="it_name" value="<?=$sch_it_name?>" />
						<img src="<?=$sch_it_img?>" alt="" style="max-width: 50px;" /> <?=$sch_it_name?>

					<? } else { ?>
						<?php echo help("※ [ 아이템 기능 - 뽑기 아이템 ] 이 설정되어 있어야 적용됩니다.") ?>
						<input type="hidden" name="it_id" id="it_id" value="<?=$sch_it_id?>" />
						<input type="text" name="it_name" value="<?=$sch_it_name?>" id="it_name" onkeyup="get_ajax_item(this, 'item_list', 'it_id', '뽑기');" />
						<div id="item_list" class="ajax-list-box"><div class="list"></div></div>
					<? } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">획득 아이템</th>
					<td>
						<input type="hidden" name="re_it_id" id="re_it_id" value="" />
						<input type="text" name="re_it_name" value="" id="re_it_name" onkeyup="get_ajax_item(this, 're_item_list', 're_it_id');" />
						<div id="re_item_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
				</tr>
				<tr>
					<th scope="row">획득구간</th>
					<td>
						<?php echo help("※ 100면체 주사위를 굴렸을 때 나오는 숫자 중 획득 가능 범위를 지정해 주시길 바랍니다. (0~100)<br />※ 다수의 구간이 겹칠 시,랜덤으로 획득 됩니다.") ?>
						<input type="text" name="ie_per_s" value="" size="5" maxlength="11">
						~
						<input type="text" name="ie_per_e" value="" size="5" maxlength="11"> 구간 획득
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="btn_confirm01 btn_confirm">
		<input type="submit" value="등록" class="btn_submit" id="btn_submit">
	</div>

	</form>

</section>
<? } ?>


<?php
include_once ('./admin.tail.php');
?>