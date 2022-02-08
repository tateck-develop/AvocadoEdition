<?php
$sub_menu = "500200";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

$category = explode("||", $config['cf_item_category']);

$html_title = '아이템';
$required = "";
$readonly = "";
if ($w == '') {

	$html_title .= ' 생성';
	$required = 'required';
	$required_valid = 'alnum_';
	$sound_only = '<strong class="sound_only">필수</strong>';
	$item['it_use'] = 'Y';


} else if ($w == 'u') {

	$html_title .= ' 수정';
	$item = sql_fetch("select * from {$g5['item_table']} where it_id = '{$it_id}'");
	if (!$item['it_id'])
		alert('존재하지 않는 아이템 입니다.');
	$readonly = 'readonly';
}

$g5['title'] = $html_title;
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본 설정</a></li>';

if($config['cf_4']) {
	$pg_anchor .= '<li><a href="#anc_002">탐색 설정</a></li>';
}
$pg_anchor .= '</ul>';


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./item_list.php?'.$qstr.'">목록</a>'.PHP_EOL;
$frm_submit .= '</div>';

?>

<form name="fitemform" id="fitemform" action="./item_form_update.php" onsubmit="return fitemform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="it_id" value="<?php echo $it_id ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<section id="anc_001">
	<h2 class="h2_frm">아이템 기본 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>아이템 기본 설정</caption>
			<colgroup>
				<col style="width: 130px;">
				<col style="width: 100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">사용여부</th>
					<td colspan="2">
						<input type="checkbox" name="it_use" id="it_use" value="Y" <?=$item['it_use'] == 'Y'? "checked" : ""?>/>
					</td>
				</tr>
				<tr>
					<th scope="row">아이템 분류</th>
					<td colspan="2">
						<select name="it_category">
							<option value="일반" <?=$item['it_category'] == "일반" ? "selected" : ""?>>일반 아이템</option>
							<option value="개인" <?=$item['it_category'] == "개인" ? "selected" : ""?>>개인 아이템</option>
							<option value="출석" <?=$item['it_category'] == "출석" ? "selected" : ""?>>출석 아이템</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2">아이템 기능</th>
					<td>
						기능종류
					</td>
					<td colspan="2">
						<select name="it_type" onchange="fn_type_chage(this);">
						<? for($k =0; $k < count($category); $k++) { 
							if(!$category[$k]) continue;
						?>
							<option value="<?=$category[$k]?>" <?=$item['it_type'] == $category[$k] ? "selected" : ""?>><?=$category[$k]?></option>
						<? } ?>
							<option value="뽑기" <?=$item['it_type'] == "뽑기" ? "selected" : ""?>>뽑기 아이템</option>
						</select>
						<? if($w == 'u' && $item['it_type'] == '뽑기') { ?>
						&nbsp;&nbsp;
						<a href="./explorer_list.php?sch_it_id=<?=$it_id?>">뽑기 아이템 설정하러 가기</a>
						<? } ?>
					</td>
				</tr>
				<tr>
					<td>
						적용값
					</td>
					<td>
						<?php echo help("※ 적용값이 추가로 필요 할 시에만 기입해 주시길 바랍니다.") ?>
						<span data-type="스탯" class="switch-obj" style="display:<?=strstr($item['it_type'], '스탯') ? "inline-block" : "none"?>;">
							스탯 : 
							<select name="st_id">
								<option value="">지정하지 않음</option>
								<?
									$stat_sql = "select st_id, st_name from {$g5['status_config_table']} order by st_order asc";
									$stat_list = sql_query($stat_sql);
									for($i=0; $srow = sql_fetch_array($stat_list); $i++) {
								?>
									<option value="<?=$srow['st_id']?>" <?=$item['st_id'] == $srow['st_id'] ? "selected" : ""?>><?=$srow['st_name']?></option>
								<? } ?>
							</select>
						</span>



						<input type="text" name="it_value" value="<?php echo $item['it_value']; ?>" id="it_value" size="15">
					</td>
				</tr>
				<tr>
					<th scope="row">아이템 이름</th>
					<td colspan="2">
						<input type="text" name="it_name" value="<?php echo get_text($item['it_name']) ?>" id="it_name" required class="required" size="50" maxlength="120">
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2">아이템 이미지</th>
					<td rowspan="2" class="bo-right">
						<? if($item['it_img']) { ?>
							<img src="<?=$item['it_img']?>">
						<? } else { ?>
						이미지 없음
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="it_img_file" value="" size="50">
					</td>
				</tr>
				<tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="it_img" value="<?=$item['it_img']?>" size="50"/>
					</td>
				</tr>

				<tr>
					<th scope="row" rowspan="2">상세이미지</th>
					<td rowspan="2" class="bo-right">
						<? if($item['it_1']) { ?>
							<img src="<?=$item['it_1']?>">
						<? } else { ?>
						이미지 없음
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="it_1_file" value="" size="50">
					</td>
				</tr>
				<tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="it_1" value="<?=$item['it_1']?>" size="50"/>
					</td>
				</tr>

				<tr>
					<th scope="row">아이템 설명</th>
					<td colspan="2">
						<input type="text" name="it_content" value="<?php echo get_text($item['it_content']) ?>" id="it_content" required class="required" size="80">
					</td>
				</tr>
				<tr>
					<th scope="row">아이템 효과</th>
					<td colspan="2">
						<input type="text" name="it_content2" value="<?php echo get_text($item['it_content2']) ?>" id="it_content2" size="80">
					</td>
				</tr>
				
				
				<tr>
					<th rowspan="2" scope="row">되팔기 설정</th>
					<td>사용여부</td>
					<td>
						<input type="checkbox" name="it_use_sell" id="it_use_sell" value="1" <?=$item['it_use_sell']=='1' ? "checked" : ""?> />
						<label for="it_use_sell">판매가능</label>
					</td>
				</tr>
				<tr>
					<td>가격</td>
					<td>
						<input type="text" name="it_sell" value="<?php echo $item['it_sell'] ?>" id="it_sell" size="10">
					</td>
				</tr>
				<tr>
					<th scope="row">아이템 속성</th>
					<td colspan="2">
						<input type="checkbox" name="it_has" id="it_has" value="1" <?=$item['it_has']=='1' ? "checked" : ""?> />
						<label for="it_has">귀속성&nbsp;&nbsp;&nbsp;</label>

						<input type="checkbox" name="it_use_ever" id="it_use_ever" value="1" <?=$item['it_use_ever']=='1' ? "checked" : ""?> />
						<label for="it_use_ever">영구성&nbsp;&nbsp;&nbsp;</label>

						<input type="checkbox" name="it_use_able" id="it_use_able" value="1" <?=$item['it_use_able']=='1' ? "checked" : ""?> />
						<label for="it_use_able">인벤 사용가능&nbsp;&nbsp;&nbsp;</label>

						<input type="checkbox" name="it_use_mmb_able" id="it_use_mmb_able" value="1" <?=$item['it_use_mmb_able']=='1' ? "checked" : ""?> />
						<label for="it_use_mmb_able">자비란 사용가능&nbsp;&nbsp;&nbsp;</label>
						
						<input type="checkbox" name="it_use_recepi" id="it_use_recepi" value="1" <?=$item['it_use_recepi']=='1' ? "checked" : ""?> />
						<label for="it_use_recepi">레시피 재료 사용</label>
						<?php echo help("&nbsp;") ?>
						<?php echo help("※ 아이템 기능에 따라, 인벤만 사용 가능 / 자비란만 사용 가능한 템이 있습니다.") ?>
						<?php echo help("※ 뽑기 아이템의  경우, 자비란 사용 가능에 체크 하셔야 사용 가능합니다. (인벤 사용 X)") ?>
						<?php echo help("※ 나머지 아이템들의 경우, 인벤 사용 가능에 체크 하셔야 사용 가능합니다. (자비란 사용 X)") ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<?if($config['cf_4']) {?>
<section id="anc_002">
	<h2 class="h2_frm">탐색설정</h2>
	<?php echo $pg_anchor ?>
	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>아이템 기본 설정</caption>
			<colgroup>
				<col style="width: 130px;">
				<col style="width: 100px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th rowspan="2" scope="row">탐색획득</th>
					<td>
						탐색사용여부
					</td>
					<td/>
						<input type="checkbox" name="it_seeker" id="it_seeker" value="1" <?=$item['it_seeker']=='1' ? "checked" : ""?> />
						<label for="it_seeker">자비란 탐색시 획득 가능</label>
					</td>
				</tr>
				<tr>
					<td>
						회득 구간 설정
					</td>
					<td>
						<?php echo help("※ 100면체 주사위를 굴렸을 때 나오는 숫자 중 획득 가능 범위를 지정해 주시길 바랍니다. (0 ~ 100)<br />※ 다수의 구간이 겹칠 시,랜덤으로 획득 됩니다.") ?>
						<input type="text" name="it_seeker_per_s" value="<?php echo $item['it_seeker_per_s']; ?>" id="it_seeker_per_s" size="5" maxlength="11">
						~
						<input type="text" name="it_seeker_per_e" value="<?php echo $item['it_seeker_per_e']; ?>" id="it_seeker_per_e" size="5" maxlength="11"> 구간 획득
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>
<? } ?>
</form>


<script>
function fitemform_submit(f)
{
	return true;
}

function fn_type_chage(obj) {
	var target = obj.value;
	$('.switch-obj').hide();
	$('.switch-obj').find('select').val('');
	$('.switch-obj').find('input').val('');

	$('.switch-obj').each(function() {
		var check = $(this).attr('data-type');
		if(target.indexOf(check) < 0) {
			// --
		} else {
			$(this).show();
		}
	});

	
	$('.switch-obj[data-type*="'+target+'"]').show();
}

</script>

<?php
include_once ('./admin.tail.php');
?>
