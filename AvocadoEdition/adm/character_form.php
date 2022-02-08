<?php
$sub_menu = "400200";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');
$token = get_token();

// 기본 항목 설정 데이터
$ad = sql_fetch("select * from {$g5['article_default_table']}");

// 추가 항목 설정 데이터
$ch_ar = array();
$ar_result = sql_query("select * from {$g5['article_table']} order by ar_order asc");
for($i = 0; $row = sql_fetch_array($ar_result); $i++) {
	$ch_ar[$i] = $row;
}

$status = array();
if($ad['ad_use_status']) { 
	// 스탯 정보 가져오기
	$st_result = sql_query("select * from {$g5['status_config_table']} order by st_order asc");
	for($i = 0; $row = sql_fetch_array($st_result); $i++) {
		$status[$i] = $row;
	}
}


/** 세력 정보 **/
$ch_si = array();
if($config['cf_side_title']) {
	$side_result = sql_query("select si_id, si_name from {$g5['side_table']} where si_auth <= '{$member['mb_level']}' order by si_id asc");
	for($i=0; $row = sql_fetch_array($side_result); $i++) { 
		$ch_si[$i]['name'] = $row['si_name'];
		$ch_si[$i]['id'] = $row['si_id'];
	}
}

/** 종족 정보 **/
$ch_cl = array();
if($config['cf_class_title']) {
	$class_result = sql_query("select cl_id, cl_name from {$g5['class_table']} where cl_auth <= '{$member['mb_level']}' order by cl_id asc");
	for($i=0; $row = sql_fetch_array($class_result); $i++) { 
		$ch_cl[$i]['name'] = $row['cl_name'];
		$ch_cl[$i]['id'] = $row['cl_id'];
	}

}


if ($w == '') {

	$html_title = '추가';

} else if ($w == 'u') {

	$ch = get_character($ch_id);
	if (!$ch['ch_id'])
		alert('존재하지 않는 캐릭터 자료 입니다.');

	$html_title = '수정';

} else {
	alert('제대로 된 값이 넘어오지 않았습니다.');
}

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본 설정</a></li>
	<li><a href="#anc_002">이미지 설정</a></li>
';
if($ad['ad_use_status']) { 
	$pg_anchor .= '<li><a href="#anc_004">스탯 설정</a></li>';
}
$pg_anchor .= '
	<li><a href="#anc_003">프로필 설정</a></li>
</ul>';


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./character_list.php?{$qstr}">목록</a>
</div>';

$g5['title'] .= "";
$g5['title'] .= '캐릭터 '.$html_title;
include_once('./admin.head.php');
?>

<form name="fmember" id="fmember" action="./character_form_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">
<input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">


<section id="anc_001">
	<h2 class="h2_frm">캐릭터 기본 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?></caption>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">활동 승인</th>
			<td >
				<select name="ch_state">
					<option value="수정중" <?=$ch['ch_state'] == '수정중' ? 'selected' : ''?>>수정중</option>
					<option value="대기" <?=$ch['ch_state'] == '대기' ? 'selected' : ''?>>대기</option>
					<option value="승인" <?=$ch['ch_state'] == '승인' ? 'selected' : ''?>>승인</option>
					<option value="삭제" <?=$ch['ch_state'] == '삭제' ? 'selected' : ''?>>삭제</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>캐릭터유형</th>
			<td>
				<select name="ch_type">
					<option value="main" <?=$ch['ch_type'] == 'main' ? 'selected' : ''?>>메인캐릭터</option>
					<option value="sub" <?=$ch['ch_type'] == 'sub' ? 'selected' : ''?>>서브캐릭터</option>
					<option value="npc" <?=$ch['ch_type'] == 'npc' ? 'selected' : ''?>>NPC</option>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">오너아이디</th>
			<td>
				<input type="text" name="mb_id" value="<?php echo $ch['mb_id'] ?>" id="mb_id" >
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
	</div>
</section>
<? echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">캐릭터 이미지 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?></caption>
		<colgroup>
			<col style="width: 150px;">
			<col style="width: 200px;">
			<col>
		</colgroup>
		<tbody>

<? if($ad['ad_use_thumb']) { ?>
		<tr>
			<th><?=$ad['ad_text_thumb']?></th>
			<td class="bo-left bo-right txt-center">
				<? if($ch['ch_thumb']) { ?>
					<img src="<?=$ch['ch_thumb']?>" class="character-thumb">
				<? } else { ?>
				이미지 미등록
				<? } ?>
			</td>
			<td>
				<?php echo help($ad['ad_help_thumb']) ?>
			<?	if($ad['ad_url_thumb']) { 
				// 두상 - 외부링크 등록
			?>
				<input type="text" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" size="50"/>
			<? } else { 
				// 두상 - 직접 업로드
			?>
				<input type="file" name="ch_thumb_file" />
				<input type="hidden" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" />
			<? } ?>
			</td>
		</tr>
<? } ?>
<? if($ad['ad_use_head']) { ?>
		<tr>
			<th><?=$ad['ad_text_head']?></th>
			<td class="bo-left bo-right txt-center">
				<? if($ch['ch_head']) { ?>
					<img src="<?=$ch['ch_head']?>" class="character-thumb">
				<? } else { ?>
				이미지 미등록
				<? } ?>
			</td>
			<td>
				<?php echo help($ad['ad_help_head']) ?>
			<?	if($ad['ad_url_head']) { 
				// 흉상 - 외부링크 등록
			?>
				<input type="text" name="ch_head" value="<?php echo $ch['ch_head'] ?>" size="50"/>
			<? } else { 
				// 흉상 - 직접 업로드
			?>
				<input type="file" name="ch_head_file" />
				<input type="hidden" name="ch_head" value="<?php echo $ch['ch_head'] ?>" />
			<? } ?>
			</td>
		</tr>
<? } ?>
<? if($ad['ad_use_body']) { ?>
		<tr>
			<th><?=$ad['ad_text_body']?></th>
			<td class="bo-left bo-right txt-center">
				<? if($ch['ch_body']) { ?>
					<img src="<?=$ch['ch_body']?>" class="character-thumb">
				<? } else { ?>
				이미지 미등록
				<? } ?>
			</td>
			<td>
				<?php echo help($ad['ad_help_body']) ?>
			<?	if($ad['ad_url_body']) { 
				// 전신 - 외부링크 등록
			?>
				<input type="text" name="ch_body" value="<?php echo $ch['ch_body'] ?>" size="50"/>
			<? } else { 
				// 전신 - 직접 업로드
			?>
				<input type="file" name="ch_body_file" />
				<input type="hidden" name="ch_body" value="<?php echo $ch['ch_body'] ?>" />
			<? } ?>
			</td>
		</tr>
<? } ?>
		</tbody>
		</table>
	</div>
</section>
<? echo $frm_submit; ?>

<?if($ad['ad_use_status']) { ?>

<section id="anc_004">
	<h2 class="h2_frm">캐릭터 스탯 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?></caption>
		<colgroup>
			<col style="width: 150px;">
			<col style="width: 80px;">
			<col>
		</colgroup>
		<tbody>
<?
	$use_point = 0;
	for($i = 0; $i < count($status); $i++) {
		$st = $status[$i];
		$sc = get_status($ch['ch_id'], $st['st_id']);
		$use_point += $sc['has'];
?>
		<tr>
			<th rowspan="2" scope="row"><?=$st['st_name']?></th>
			<td class="bo-right">보유 스탯</td>
			<td>
				<?php echo help($st['st_help']) ?>
				<input type="hidden" name="st_id[]" value="<?php echo $st['st_id'] ?>" />
				<input type="text" name="sc_max[]" value="<?php echo $sc['has'] ? $sc['has'] : $st['st_min'] ?>" size="5" >
			</td></tr><tr>
			<td class="bo-right">차감 수치</td>
			<td>
				<input type="text" name="sc_value[]" value="<?php echo $sc['drop']?>" size="5" >
			</td>
		</tr>

<? } 
if($i == 0 ) { ?>
		<tr>
			<td colspan="3" class="empty_table txt-center">
				등록된 스탯 정보가 존재하지 않습니다.
			</td>
		</tr>
<? } ?>
		<tr>
			<th rowspan="2" scope="row">스탯포인트</th>
			<td class="bo-right">전체포인트</td>
			<td>
				<input type="text" name="ch_point" value="<?php echo $ch['ch_point'] ? $ch['ch_point'] : $config['cf_status_point'] ?>" size="5" >
			</td></tr><tr>
			<td class="bo-right">사용포인트</td>
			<td>
				<?=$use_point?>
			</td>
		</tr>
		</tbody>
		</table>
	</div>
</section>
<? echo $frm_submit; ?>
<? } ?>


<section id="anc_003">
	<h2 class="h2_frm">캐릭터 프로필 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
		<caption><?php echo $g5['title']; ?></caption>
		<colgroup>
			<col style="width: 150px;">
			<col>
		</colgroup>
		<tbody>
<? if($ad['ad_use_name']) { ?>
		<tr>
			<th scope="row"><?=$ad['ad_text_name']?></th>
			<td colspan="3">
				<?php echo help($ad['ad_help_name']) ?>
				<input type="text" name="ch_name" value="<?php echo $ch['ch_name'] ?>" id="ch_name" >
			</td>
		</tr>
<? }


	// 추가 항목 값 가져오기
	$av_result = sql_query("select * from {$g5['value_table']} where ch_id = '{$ch['ch_id']}'");
	for($i = 0; $row = sql_fetch_array($av_result); $i++) {
		$ch['av_'.$row['ar_code']] = $row['av_value'];
	}


?>
<? for($i=0; $i < count($ch_ar); $i++) { 
	$ar = $ch_ar[$i];

	$key = 'av_'.$ar['ar_code'];

	$ch[$key] = sql_fetch("select av_value from {$g5['value_table']} where ch_id = '{$ch_id}' and ar_code = '{$ar['ar_code']}' and ar_theme = '{$ar['ar_theme']}'");
	$ch[$key] = $ch[$key]['av_value'];

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
				<input type="hidden" name="ar_theme[<?=$i?>]" value="<?=$ar['ar_theme']?>" />
				<input type="hidden" name="ar_code[<?=$i?>]" value="<?=$ar['ar_code']?>" />
				<? if($ar['ar_theme']) { echo "[{$ar['ar_theme']}]"; } ?>
				<?=$ar['ar_name']?>
			</th>
			<?
				if($ar['ar_type'] == 'file' || $ar['ar_type'] == 'url') { 
					// 이미지 타입의 파일
			?>
				<td class="bo-right txt-center">
					<? if($ch[$key]) { ?>
						<img src="<?=$ch[$key]?>" class="character-thumb" />
					<? } else { ?>
					이미지 미등록
					<? } ?>
				</td>
				<td>
					<?php echo help($ar['ar_help']) ?>
				<? if($ar['ar_type'] == 'url') { ?>
					<input type="text" name="av_value[<?=$i?>]" value="<?php echo $ch[$key] ?>" <?=$style?> />
				<? } else { 
					// 두상 - 직접 업로드
				?>
					<input type="file" name="av_value_file[<?=$i?>]" />
					<input type="hidden" name="av_value[<?=$i?>]" value="<?php echo $ch[$key] ?>" />
				<? } ?>
				</td>
			<? } else { ?>
				<td colspan="2">
					<?php echo help($ad['ad_help']) ?>
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
	</div>
</section>
<? echo $frm_submit; ?>

</form>






<?php
include_once('./admin.tail.php');
?>
