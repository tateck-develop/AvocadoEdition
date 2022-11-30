<?php
$sub_menu = "500100";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

$category = explode("||", $config['cf_shop_category']);

$html_title = '상점 진열 아이템';
$required = "";
$readonly = "";
if ($w == '') {

	$html_title .= ' 등록';
	$sound_only = '<strong class="sound_only">필수</strong>';
	$shop['sh_use'] = '1';
	$shop['sh_use_money'] = '1';


} else if ($w == 'u') {

	$html_title .= ' 수정';
	$shop = sql_fetch("select * from {$g5['shop_table']} where sh_id = '{$sh_id}'");
	if (!$shop['sh_id'])
		alert('존재하지 않는 진열정보 입니다.');
	$readonly = 'readonly';
}

$g5['title'] = $html_title;
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본 설정</a></li>
	<li><a href="#anc_002">구매가 설정</a></li>
	<li><a href="#anc_003">구매제한 설정</a></li>
</ul>';


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./shop_list.php?'.$qstr.'">목록</a>'.PHP_EOL;
$frm_submit .= '</div>';


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

?>

<?
	include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
	if (empty($fr_date)) $fr_date = G5_TIME_YMD;
?>

<form name="fshopform" id="fshopform" action="./shop_form_update.php" onsubmit="return fshopform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sh_id" value="<?php echo $sh_id ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<section id="anc_001">
	<h2 class="h2_frm">진열 기본 설정</h2>
	<?php echo $pg_anchor ?>

	<div class="tbl_frm01 tbl_wrap">
		<table>
			<caption>아이템 기본 설정</caption>
			<colgroup>
				<col style="width: 130px;">
				<col style="width: 80px;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th scope="row">판매여부</th>
					<td colspan="2">
						<input type="checkbox" name="sh_use" id="sh_use" value="1" <?=$shop['sh_use'] == '1'? "checked" : ""?>/>
					</td>
				</tr>
				<tr>
					<th scope="row">상점 분류</th>
					<td colspan="2">
						<select name="ca_name">
							<option value="">카테고리 선택</option>
						<? for($i =0; $i < count($category); $i++) { 
							if(!$category[$i]) continue;
						?>
							<option value="<?=$category[$i]?>" <?=$shop['ca_name'] == $category[$i] ? "selected" : ""?>><?=$category[$i]?></option>
						<? } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">진열 아이템</th>
					<td colspan="2">
						<input type="hidden" name="it_id" id="it_id" value="<?=$shop['it_id']?>" />
						<input type="text" name="it_name" value="<?=get_item_name($shop['it_id'])?>" id="it_name" onkeyup="get_ajax_item(this, 'item_list', 'it_id');" />
						<div id="item_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
				</tr>
				<tr>
					<th scope="row">아이템 설명</th>
					<td colspan="2">
						<input type="text" name="sh_content" value="<?php echo get_text($shop['sh_content']) ?>" size="80">
					</td>
				</tr>
				<tr>
					<th rowspan="3" scope="row">진열기간</th>
					<td class="bo-right">날짜</td>
					<td>
						<?php echo help("※ 날짜를 지정하지 않을 시, 적용되지 않습니다.") ?>
						<input type="text" name="sh_date_s" value="<?php echo get_text($shop['sh_date_s']) ?>" size="15" class="date" />
						~ 
						<input type="text" name="sh_date_e" value="<?php echo get_text($shop['sh_date_e']) ?>" size="15" class="date" />
					</td></tr><tr>
					<td class="bo-right">시간</td>
					<td>
						<?php echo help("※ 시작시간과 종료시간이 모두 00 일 시, 적용되지 않습니다.") ?>
						<select name="sh_time_s">
						<? for($i=0; $i <= 24; $i++) { ?>
							<option value="<?=$i?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
						<? } ?>
						</select> 시
						~ 
						<select name="sh_time_e">
						<? for($i=0; $i <= 24; $i++) { ?>
							<option value="<?=$i?>"><?=str_pad($i, 2, "0", STR_PAD_LEFT)?></option>
						<? } ?>
						</select> 시
					</td></tr><tr>
					<td class="bo-right">요일</td>
					<td>
						<?php echo help("※ 요일을 모두 체크하지 않을 시, 적용되지 않습니다.") ?>
						<?
							for($i = 0; $i < 7; $i++) { 
						?>
						<span style="display: inline-block; padding-right: 20px;">
							<input type="checkbox" name="sh_week[]" id="sh_week_<?=$i?>" value="<?=$i?>" <?=strstr($shop['sh_week'], "||".$i."||") ? "checked" : "" ?>>
							<label for="sh_week_<?=$i?>"><?=$yoil[$i]?>요일</label>
						</span>
						<? } ?>
					</td>
				</tr>
				<tr>
					<th>진열순서</th>
					<td colspan="2">
						<input type="text" name="sh_order" value="<?=$shop['sh_order']?>" id="sh_order" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">가격 설정</h2>
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
					<th scope="row" rowspan="2"><?=$config['cf_money']?> 설정</th>
					<td class="bo-right">
						필요 <?=$config['cf_money']?>
					</td>
					<td>
						<input type="text" name="sh_money" value="<?=$shop['sh_money']?>" size="15"/> <?=$config['cf_money_pice']?>
					</td></tr><tr>
					<td class="bo-right">소모여부</td>
					<td>
						<input type="checkbox" name="sh_use_money" id="sh_use_money" value="1" <?=$shop['sh_use_money'] == '1'? "checked" : ""?>/>
						<label for="sh_use_money">구매 시 <?=$config['cf_money']?> 소모</label>
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2"><?=$config['cf_exp_name']?> 설정</th>
					<td class="bo-right">
						필요 <?=$config['cf_exp_name']?>
					</td>
					<td>
						<input type="text" name="sh_exp" value="<?=$shop['sh_exp']?>" size="15"/> <?=$config['cf_exp_pice']?>
					</td></tr><tr>
					<td class="bo-right">소모여부</td>
					<td>
						<input type="checkbox" name="sh_use_exp" id="sh_use_exp" value="1" <?=$shop['sh_use_exp'] == '1'? "checked" : ""?>/>
						<label for="sh_use_exp">구매 시 <?=$config['cf_exp_name']?> 소모</label>
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2">교환아이템 설정</th>
					<td class="bo-right">
						필요 아이템
					</td>
					<td>
						<input type="hidden" name="sh_has_item" id="sh_has_item" value="<?=$shop['sh_has_item']?>" />
						<input type="text" name="sh_has_item_name" value="<?=get_item_name($shop['sh_has_item'])?>" id="sh_has_item_name" onkeyup="get_ajax_item(this, 'has_item_list', 'sh_has_item');" />
						<input type="text" name="sh_has_item_count" value="<?=$shop['sh_has_item_count']?>" size="5"/> 개
						<div id="has_item_list" class="ajax-list-box"><div class="list"></div></div>
					</td></tr><tr>
					<td class="bo-right">소모여부</td>
					<td>
						<input type="checkbox" name="sh_use_has_item" id="sh_use_has_item" value="1" <?=$shop['sh_use_has_item'] == '1'? "checked" : ""?>/>
						<label for="sh_use_has_item">구매 시 아이템 소모</label>
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2">교환타이틀 설정</th>
					<td class="bo-right">
						필요 타이틀
					</td>
					<td>
						<input type="hidden" name="sh_has_title" id="sh_has_title" value="<?=$shop['sh_has_title']?>" />
						<input type="text" name="sh_has_title_name" value="<?=get_title($shop['sh_has_title'], true)?>" id="sh_has_title_name" onkeyup="get_ajax_title(this, 'has_title_list', 'sh_has_title');" />
						<div id="has_title_list" class="ajax-list-box"><div class="list"></div></div>
					</td></tr><tr>
					<td class="bo-right">소모여부</td>
					<td>
						<input type="checkbox" name="sh_use_has_title" id="sh_use_has_title" value="1" <?=$shop['sh_use_has_title'] == '1'? "checked" : ""?>/>
						<label for="sh_use_has_title">구매 시 타이틀 소모</label>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>
<?php echo $frm_submit; ?>

<section id="anc_003">
	<h2 class="h2_frm">구매제한 설정</h2>
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
					<th scope="row">구매갯수</th>
					<td colspan="2">
						<?php echo help("※ 1인당 구매가 가능한 갯수를 제한합니다. 0 입력 시 제한하지 않습니다.") ?>
						<input type="text" name="sh_limit" value="<?=$shop['sh_limit']?>" size="10"/>
					</td>
				</tr>
				<tr>
					<th scope="row">재고설정</th>
					<td colspan="2">
						<?php echo help("※ 총 판매 갯수를 제한합니다. 0 입력 시 제한하지 않습니다.") ?>
						<input type="text" name="sh_qty" value="<?=$shop['sh_qty']?>" size="10"/>
					</td>
				</tr>
<? if($config['cf_side_title']) { ?>
				<tr>
					<th scope="row" rowspan="2"><?=$config['cf_side_title']?> 제한 설정</th>
					<td class="bo-right">
						구매가능
					</td>
					<td>
<? for($i=0; $i < count($ch_si); $i++) { ?>
						<span style="display: inline-block; padding-right: 20px;">
							<input type="checkbox" name="sh_side[]" id="sh_side_<?=$i?>" value="<?=$ch_si[$i]['id']?>" <?=strstr($shop['sh_side'], "||".$ch_si[$i]['id']."||") ? "checked" : "" ?>>
							<label for="sh_side_<?=$i?>"><?=$ch_si[$i]['name']?></label>
						</span>
<? } ?>
					</td></tr><tr>
					<td class="bo-right">사용여부</td>
					<td>
						<input type="checkbox" name="sh_use_side" id="sh_use_side" value="1" <?=$shop['sh_use_side'] == '1'? "checked" : ""?>/>
						<label for="sh_use_side"><?=$config['sh_use_side']?> 제한 설정을 사용합니다.</label>
					</td>
				</tr>
<? } ?>
<? if($config['cf_class_title']) { ?>
				<tr>
					<th scope="row" rowspan="2"><?=$config['cf_class_title']?> 제한 설정</th>
					<td class="bo-right">
						구매가능
					</td>
					<td>
<? for($i=0; $i < count($ch_cl); $i++) { ?>
						<span style="display: inline-block; padding-right: 20px;">
							<input type="checkbox" name="sh_class[]" id="sh_class_<?=$i?>" value="<?=$ch_cl[$i]['id']?>" <?=strstr($shop['sh_class'], "||".$ch_cl[$i]['id']."||") ? "checked" : "" ?>>
							<label for="sh_class_<?=$i?>"><?=$ch_cl[$i]['name']?></label>
						</span>
<? } ?>
					</td></tr><tr>
					<td class="bo-right">사용여부</td>
					<td>
						<input type="checkbox" name="sh_use_class" id="sh_use_class" value="1" <?=$shop['sh_use_class'] == '1'? "checked" : ""?>/>
						<label for="sh_use_class"><?=$config['sh_use_class']?> 제한 설정을 사용합니다.</label>
					</td>
				</tr>
<? } ?>
<?
	$use_level = sql_fetch("select ad_use_rank from {$g5['article_default_table']}");
	if($use_level['ad_use_rank']) { 
		$level_result = sql_query("select lv_id, lv_name from {$g5['level_table']} order by lv_exp desc");
?>
				<tr>
					<th scope="row" rowspan="2">랭킹 제한 설정</th>
					<td class="bo-right">
						구매가능
					</td>
					<td>
<? for($i=0; $lv = sql_fetch_array($level_result); $i++) { ?>
						<span style="display: inline-block; padding-right: 20px;">
							<input type="checkbox" name="sh_rank[]" id="sh_rank_<?=$i?>" value="<?=$lv['lv_id']?>" <?=strstr($shop['sh_rank'], "||".$lv['lv_id']."") ? "checked" : "" ?>>
							<label for="sh_rank_<?=$i?>"><?=$lv['lv_name']?></label>
						</span>
<? } ?>
					</td></tr><tr>
					<td class="bo-right">사용여부</td>
					<td>
						<input type="checkbox" name="sh_use_rank" id="sh_use_rank" value="1" <?=$shop['sh_use_rank'] == '1'? "checked" : ""?>/>
						<label for="sh_use_rank">랭킹 제한 설정을 사용합니다.</label>
					</td>
				</tr>
<? } ?>
			</tbody>
		</table>
	</div>
</section>
<?php echo $frm_submit; ?>


</form>

<script>
$(function(){
	$(".date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yymmdd", showButtonPanel: true, yearRange: "c-99:c+99" });
});

function fshopform_submit(f)
{
	return true;
}

</script>

<?php
include_once ('./admin.tail.php');
?>
