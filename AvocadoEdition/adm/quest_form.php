<?php
$sub_menu = "600100";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');


/** 세력 정보 **/
if($config['cf_side_title']) {
	$ch_si = array();
	$side_result = sql_query("select si_id, si_name from {$g5['side_table']} where si_auth <= '{$member['mb_level']}' order by si_id asc");
	for($i=0; $row = sql_fetch_array($side_result); $i++) { 
		$ch_si[$i]['name'] = $row['si_name'];
		$ch_si[$i]['id'] = $row['si_id'];
	}
}

/** 종족 정보 **/
if($config['cf_class_title']) {
	$ch_cl = array();
	$class_result = sql_query("select cl_id, cl_name from {$g5['class_table']} where cl_auth <= '{$member['mb_level']}' order by cl_id asc");
	for($i=0; $row = sql_fetch_array($class_result); $i++) { 
		$ch_cl[$i]['name'] = $row['cl_name'];
		$ch_cl[$i]['id'] = $row['cl_id'];
	}

}


$html_title = '퀘스트';
$required = "";
$readonly = "";
if ($w == '') {

	$html_title .= ' 생성';
	$required = 'required';
	$required_valid = 'alnum_';
	$sound_only = '<strong class="sound_only">필수</strong>';


} else if ($w == 'u') {

	$html_title .= ' 수정';
	$quest = sql_fetch("select * from {$g5['quest_table']} where qu_id = '{$qu_id}'");
	if (!$quest['qu_id'])
		alert('존재하지 않는 퀘스트 입니다.');
	$readonly = 'readonly';
}

$g5['title'] = $html_title;
include_once ('./admin.head.php');


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./quest_list.php?'.$qstr.'">목록</a>'.PHP_EOL;
$frm_submit .= '</div>';

?>

<?
	include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
	if (empty($fr_date)) $fr_date = G5_TIME_YMD;
?>


<form name="fitemform" id="fitemform" action="./quest_form_update.php" onsubmit="return fitemform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="qu_id" value="<?php echo $qu_id ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<section id="anc_001">
	<h2 class="h2_frm">퀘스트 기본 설정</h2>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>퀘스트 기본 설정</caption>
			<colgroup>
				<col style="width: 130px;">
				<col style="width: 100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">퀘스트 분류</th>
					<td colspan="2">
						<select name="qu_type">
							<option value="일일" <?=$quest['qu_type'] == "일일" ? "selected" : ""?>>일일 퀘스트</option>
							<option value="주간" <?=$quest['qu_type'] == "주간" ? "selected" : ""?>>주간 퀘스트</option>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row">수행가능</th>
					<td colspan="2">
						<select name="si_id" id="si_id">
							<option value=""><?=$config['cf_side_title']?> 선택</option>
		<? for($i=0; $i < count($ch_si); $i++) { ?>
							<option value="<?=$ch_si[$i]['id']?>" <?=$quest['si_id'] == $ch_si[$i]['id'] ? "selected" : "" ?>><?=$ch_si[$i]['name']?></option>
		<? } ?>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row">퀘스트 이름</th>
					<td colspan="2">
						<input type="text" name="qu_title" value="<?php echo get_text($quest['qu_title']) ?>" id="qu_title" required class="required" size="50" maxlength="120">
					</td>
				</tr>

				<tr>
					<th rowspan="2">
						퀘스트 기간
					</th>
					<td>
						시작일
					</td>
					<td>
						<input type="text" name="qu_sdate" value="<?php echo $quest['qu_sdate']; ?>" id="qu_sdate" class="date"  size="21" maxlength="19">
					</td>
				</tr>
				<tr>
					<td>
						종료일
					</td>
					<td>
						<input type="text" name="qu_edate" value="<?php echo $quest['qu_edate']; ?>" id="qu_edate" class="date"  size="21" maxlength="19">
					</td>
				</tr>

				
				<tr>
					<th scope="row">퀘스트 이미지</th>
					<td colspan="2">
						<?php echo help("※ 여러 이미지를 등록 시, 엔터로 구분 해주세요.") ?>
						<textarea name="qu_image" id="qu_image"><?=$quest['qu_image']?></textarea>
						<p>
							ex)<br />
							<?=G5_URL?>/img/img_01.png<br />
							<?=G5_URL?>/img/img_02.png<br />
							<?=G5_URL?>/img/img_03.png<br />
							...
						</p>
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

</form>


<script>
$(function(){
	$(".date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });
});

function fitemform_submit(f)
{
	return true;
}

</script>

<?php
include_once ('./admin.tail.php');
?>
