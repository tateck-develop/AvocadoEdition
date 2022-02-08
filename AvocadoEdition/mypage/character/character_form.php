<?php
include_once('./_common.php');
include_once('./_head.php');
define('_CHARACTER_FORM_', TRUE);

$mb = $member;

if($in_id) { 
	$in = get_inventory_item($in_id);
}

// 추가 항목 설정 데이터
// -- 권한 설정에 따라 가져오기
// -- 관리자 권한 제외 하고 가져온다.
$ch_ar = array();
$str_secret = ' where (1) ';

if($member['mb_id'] == $mb['mb_id']) {
	$str_secret .= " and ar_secret != 'H' ";
} else {
	$str_secret .= " and ar_secret = '' ";
}
if($config['cf_theme']) {
	$str_secret .= " and ar_theme = '{$config['cf_theme']}' ";
} else {
	$str_secret .= " and ar_theme = '' ";
}

$ar_result = sql_query("select * from {$g5['article_table']} {$str_secret} order by ar_order asc");
for($i = 0; $row = sql_fetch_array($ar_result); $i++) {
	$ch_ar[$i] = $row;
}

if($ad['ad_use_status']) { 
	// 스탯 정보 가져오기
	$status = array();
	$st_result = sql_query("select * from {$g5['status_config_table']} order by st_order asc");
	for($i = 0; $row = sql_fetch_array($st_result); $i++) {
		$status[$i] = $row;
	}
}


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

if($w == "") {
	if(!$is_add_character && !$is_admin) { 
		alert("현재 캐릭터 생성 기간이 아닙니다.", "./index.php");
	}
	$ch = sql_fetch("select count(ch_id) as cnt from {$g5['character_table']} where mb_id = '{$member['mb_id']}'");

	// 생성한 캐릭터 갯수 제한 체크
	if($ch['cnt'] > $config['cf_character_count']) { 
		alert("생성 가능한 캐릭터 갯수를 초과하였습니다.", "./index.php");
	}

	$ch['ch_state'] = '수정중';
	$ch['ch_type'] = 'main';
	$ch['mb_id'] = $member['mb_id'];
	$ch['ch_point'] = $config['cf_status_point'];

} else {
	$ch = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$ch_id}'");
	if(empty($ch)){
		alert("캐릭터 내역이 존재하지 않습니다.");
	}
	if(!$is_mod_character && !$is_admin){ 
		if($in['ch_id'] != $ch['ch_id'] || $in['it_type'] != '프로필수정') {
			alert("캐릭터 수정 기간이 아닙니다.");
		}
	}

	// 추가 항목 값 가져오기
	$av_result = sql_query("select * from {$g5['value_table']} where ch_id = '{$ch['ch_id']}'");
	for($i = 0; $row = sql_fetch_array($av_result); $i++) {
		$ch[$row['ar_code']] = $row['av_value'];
	}
}
?>

<form name="fwrite" id="fwrite" action="./character_form_update.php" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" class="ui-register-form">
	<input type="hidden" name="w" value="<?php echo $w; ?>">
	<input type="hidden" name="mb_id" value="<?php echo $ch['mb_id']; ?>">
	<input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
	<input type="hidden" name="in_id" value="<?php echo $in_id; ?>">

	<input type="hidden" name="ch_id" value="<?php echo $ch['ch_id']; ?>">
	<input type="hidden" name="ch_type" value="<?php echo $ch['ch_type']; ?>">

	<input type="hidden" name="ch_point" value="<?php echo $ch['ch_point']; ?>">

<? if($ch['ch_state'] == "승인") { ?>
	<input type="hidden" name="ch_state" value="<?=$ch['ch_state']?>" />
<? } else { ?>

	<h3 class="sub-title">신청서 상태</h3>

	<table class="theme-form">
		<colgroup>
			<col style="width: 110px;" />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<th>신청서상태</th>
				<td>
					<?php echo help('※ 신청서 작성 완료 후, <span class="txt-point">[수정완료]</span>로 변경해 주시길 바랍니다.') ?>
					<select name="ch_state">
						<option value="수정중" <?=$ch['ch_state'] == "수정중" ? "selected" : ""?>>수정중</option>
						<option value="대기" <?=$ch['ch_state'] == "대기" ? "selected" : ""?>>수정완료</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<hr class="padding" />
<? } ?>

	<h3 class="sub-title">캐릭터 기본정보</h3>

	<table class="theme-form">
		<colgroup>
			<col style="width: 110px;" />
			<col />
		</colgroup>
		<tbody>
		<tr>
			<th scope="row"><?=$ad['ad_text_name']?></th>
			<td>
				<p class="ui-helper"><?=$ad['ad_help_name']?></p>
				<input type="text" name="ch_name" value="<?php echo $ch['ch_name'] ?>" id="ch_name" >
			</td>
		</tr>
<? if($config['cf_side_title']) { ?>
		<tr>
			<th><?=$config['cf_side_title']?></th>
			<td>
				<select name="ch_side" id="ch_side">
					<option value=""><?=$config['cf_side_title']?> 선택</option>
<? for($i=0; $i < count($ch_si); $i++) { ?>
					<option value="<?=$ch_si[$i]['id']?>" <?=$ch['ch_side'] == $ch_si[$i]['id'] ? "selected" : "" ?>><?=$ch_si[$i]['name']?></option>
<? } ?>
				</select>
			</td>
		</tr>
<? } ?>

<? if($config['cf_class_title']) { ?>
		<tr>
			<th><?=$config['cf_class_title']?></th>
			<td>
				<select name="ch_class" id="ch_class">
					<option value=""><?=$config['cf_class_title']?> 선택</option>
<? for($i=0; $i < count($ch_cl); $i++) { ?>
					<option value="<?=$ch_cl[$i]['id']?>" <?=$ch['ch_class'] == $ch_cl[$i]['id'] ? "selected" : "" ?>><?=$ch_cl[$i]['name']?></option>
<? } ?>
				</select>
			</td>
		</tr>
<? } ?>

		</tbody>
	</table>
	<hr class="padding" />


	<h3 class="sub-title">캐릭터 이미지 정보</h3>

	<table class="theme-form">
		<colgroup>
			<col style="width: 110px;" />
			<col />
		</colgroup>
		<tbody>
		<? if($ad['ad_use_thumb']) { ?>
			<tr>
				<th><?=$ad['ad_text_thumb']?></th>
				<td>
					<?php echo help($ad['ad_help_thumb']) ?>
				<?	if($ad['ad_url_thumb']) { // 두상 - 외부링크 등록 ?>
					<input type="text" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" />
				<? } else { // 두상 - 직접 업로드 ?>
					<input type="file" name="ch_thumb_file" accept="image/*"/>
					<input type="hidden" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" />
				<? } ?>
				<? if($ch['ch_thumb']) { ?>
					<a href="<?=$ch['ch_thumb']?>" class="ui-btn" target="_blank">
						<?=$ad['ad_text_thumb']?> 이미지 확인
					</a>
				<? } ?>
				</td>
			</tr>
		<? } ?>
		<? if($ad['ad_use_head']) { ?>
			<tr>
				<th><?=$ad['ad_text_head']?></th>
				<td>
					<?php echo help($ad['ad_help_head']) ?>
				<?	if($ad['ad_url_head']) { // 두상 - 외부링크 등록 ?>
					<input type="text" name="ch_head" value="<?php echo $ch['ch_head'] ?>" />
				<? } else { // 두상 - 직접 업로드 ?>
					<input type="file" name="ch_head_file" accept="image/*"/>
					<input type="hidden" name="ch_head" value="<?php echo $ch['ch_head'] ?>" />
				<? } ?>
				<? if($ch['ch_head']) { ?>
					<a href="<?=$ch['ch_head']?>" class="ui-btn" target="_blank">
						<?=$ad['ad_text_head']?> 이미지 확인
					</a>
				<? } ?>
				</td>
			</tr>
		<? } ?>
		<? if($ad['ad_use_body']) { ?>
			<tr>
				<th><?=$ad['ad_text_body']?></th>
				<td>
					<?php echo help($ad['ad_help_body']) ?>
				<?	if($ad['ad_url_body']) { // 두상 - 외부링크 등록 ?>
					<input type="text" name="ch_body" value="<?php echo $ch['ch_body'] ?>" />
				<? } else { // 두상 - 직접 업로드 ?>
					<input type="file" name="ch_body_file" accept="image/*"/>
					<input type="hidden" name="ch_body" value="<?php echo $ch['ch_body'] ?>" />
				<? } ?>
				<? if($ch['ch_body']) { ?>
					<a href="<?=$ch['ch_body']?>" class="ui-btn" target="_blank">
						<?=$ad['ad_text_body']?> 이미지 확인
					</a>
				<? } ?>
				</td>
			</tr>
		<? } ?>
		</tbody>
	</table>
	<hr class="padding" />

<?if($ad['ad_use_status']) { ?>
	<h3 class="sub-title">
		캐릭터 스탯 정보
		<span style="float: right;">
			<em class="txt-point" data-type="point_space"><?=get_space_status($ch['ch_id'])?></em>
			/
			<?=$config['cf_status_point']?>
		</span>
	</h3>
	<div class="theme-box">
		<? include_once('./status.inc.php'); ?>
	</div>
	<hr class="padding" />
<? } ?>

<? if(count($ch_ar) > 0) { ?>
	<h3 class="sub-title">추가 캐릭터 프로필 정보</h3>
	<table class="theme-form">
		<colgroup>
			<col style="width: 110px;" />
			<col />
		</colgroup>
		<tbody>
	<? for($i=0; $i < count($ch_ar); $i++) { 
		$ar = $ch_ar[$i];
		$key = $ar['ar_code'];

		$style = "";
		if($ar['ar_size']) {
			if($ar['ar_type'] != 'textarea') 
				$style = "style = 'width: {$ar['ar_size']}px;'";
			else
				$style = "style = 'width: 100%; height: {$ar['ar_size']}px;'";
		} else {
			$style = "style = 'width: 100%;'";
		}
	?>
			<tr>
				<th>
					<input type="hidden" name="ar_code[<?=$i?>]" value="<?=$ar['ar_code']?>" />
					<input type="hidden" name="ar_theme[<?=$i?>]" value="<?=$config['cf_theme']?>" />
					<?=$ar['ar_name']?>
				</th>
				<?
					if($ar['ar_type'] == 'file' || $ar['ar_type'] == 'url') { 
						// 이미지 타입의 파일
				?>

					<td>
						<?php echo help($ar['ar_help']) ?>
					<? if($ar['ar_type'] == 'url') { ?>
						<input type="text" name="av_value[<?=$i?>]" value="<?php echo $ch[$key] ?>" <?=$style?> />
					<? } else { 
						// 직접 업로드
					?>
						<input type="file" name="av_value_file[<?=$i?>]" />
						<input type="hidden" name="av_value[<?=$i?>]" value="<?php echo $ch[$key] ?>" />
					<? } ?>
					<? if($ch[$key]) { ?>
						<a href="<?=$ch[$key]?>" class="ui-btn" target="_blank">
							<?=$ar['ar_name']?> 확인
						</a>
					<? } ?>
					</td>

				<? } else { ?>
					<td>
						<?php echo help($ar['ar_help']) ?>
					<?
						if($ar['ar_type'] == 'text') { 
					?>
						<input type="text" name="av_value[<?=$i?>]" value="<?php echo $ch[$key] ?>" <?=$style?> /> <?=$ar['ar_text']?>

					<? } else if($ar['ar_type'] == 'textarea') { ?>

						<textarea name="av_value[<?=$i?>]" <?=$style?>><?php echo $ch[$key] ?></textarea>

					<? } else if($ar['ar_type'] == 'select') { 
						$option = explode("||", $ar['ar_text']);
					?>
						<select name="av_value[<?=$i?>]" <?=$style?>>
						<? for($j=0; $j < count($option); $j++) { ?>
							<option value="<?=$option[$j]?>" <?=$option[$j] == $ch[$key] ? "selected" : ""?>><?=$option[$j]?></option>
						<? } ?>
						</select>
					<? } ?>

					</td>
				<? } ?>
			</tr>
	<? } ?>
		</tbody>
	</table>
<? } ?>
	
	<hr class="padding" />
	<div class="txt-center">
		<button type="submit" class="ui-btn point">
			캐릭터 정보 <?=$w == 'u' ? "수정" : "등록" ?>
		</button>

		<a href="./index.php" class="ui-btn">취소</a>
	</div>


</form>

<hr class="padding" />

<script type="text/javascript">

function fwrite_submit(f)
{
	document.getElementById("btn_submit").disabled = "disabled";
	return true;
}

$('.preview-image > a').on('click', function() {
	$(this).parent().children('div').stop().slideToggle();
	return false;
});


</script>

<?php
include_once('./_tail.php');
?>
