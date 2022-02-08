<?php
$sub_menu = "600300";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'w');

$html_title = '지역 이벤트 설정';
$required = "";
$readonly = "";
if ($w == '') {

	$html_title .= ' 등록';
	$sound_only = '<strong class="sound_only">필수</strong>';
	$me['me_use'] = '1';

} else if ($w == 'u') {

	$html_title .= ' 수정';
	$me = sql_fetch("select * from {$g5['map_event_table']} where me_id = '{$me_id}'");
	if (!$me['me_id'])
		alert('존재하지 않는 정보 입니다.');
	$ma_id = $me['ma_id'];
	$readonly = 'readonly';
}

$ma = sql_fetch("select * from {$g5['map_table']} where ma_id = '{$ma_id}'");
if(!$ma['ma_id']) { alert("지역정보를 확인할 수 없습니다."); }


$g5['title'] = "[ ".$ma['ma_name']." ] ".$html_title;
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
	<li><a href="#anc_001">기본 설정</a></li>
	<li><a href="#anc_002">이벤트 효과 설정</a></li>
</ul>';


$frm_submit = '<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey="s">
	<a href="./map_event_list.php?ma_id='.$ma_id.'&'.$qstr.'">목록</a>'.PHP_EOL;
$frm_submit .= '</div>';

$ma_sql = "select ma_id, ma_name from {$g5['map_table']} order by ma_id asc";
$ma_result = sql_query($ma_sql);
for($i=0; $maps = sql_fetch_array($ma_result); $i++) { 
	$map[$i]['name'] = $maps['ma_name'];
	$map[$i]['id'] = $maps['ma_id'];
}

?>

<?
	include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
	if (empty($fr_date)) $fr_date = G5_TIME_YMD;
?>

<form name="fshopform" id="fshopform" action="./map_event_form_update.php" onsubmit="return fshopform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="me_id" value="<?php echo $me_id ?>">
<input type="hidden" name="ma_id" value="<?php echo $ma_id ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">

<section id="anc_001">
	<h2 class="h2_frm">기본 설정</h2>
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
					<th scope="row">이벤트명</th>
					<td colspan="2">
						<input type="text" name="me_title" value="<?=$me['me_title']?>" />
						<input type="checkbox" name="me_use" id="me_use" value="1" <?=$me['me_use'] == '1'? "checked" : ""?>/>
						<label for="me_use">사용하기</label>
					</td>
				</tr>
				<tr>
					<th scope="row">이벤트타입</th>
					<td colspan="2">
						<select name="me_type">
							<option value="" <?=$me['me_type'] == '' ? 'selected' : ''?>>일반</option>
							<option value="아이템" <?=$me['me_type'] == '아이템' ? 'selected' : ''?>>아이템획득</option>
							<option value="화폐" <?=$me['me_type'] == '화폐' ? 'selected' : ''?>>화폐변동</option>
							<option value="이동" <?=$me['me_type'] == '이동' ? 'selected' : ''?>>지역이동</option>
							<option value="몬스터" <?=$me['me_type'] == '몬스터' ? 'selected' : ''?>>몬스터공격</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2">이벤트 이미지</th>
					<td rowspan="2" class="bo-right">
						<? if($me['me_img']) { ?>
							<img src="<?=$me['me_img']?>" style="max-width: 50px;">
						<? } else { ?>
						이미지 없음
						<? } ?>
					</td>
					<td>
						직접등록&nbsp;&nbsp; <input type="file" name="me_img_file" value="" size="50">
					</td>
				</tr>
				<tr>
					<td>
						외부경로&nbsp;&nbsp; <input type="text" name="me_img" value="<?=$me['me_img']?>" size="50"/>
					</td>
				</tr>
				<tr>
					<th scope="row">이벤트텍스트</th>
					<td colspan="2">
						<textarea name="me_content"><?=$me['me_content']?></textarea>
					</td>
				</tr>
				<tr>
					<th scope="row">
						회득 구간 설정
					</th>
					<td colspan="2">
						<?php echo help("※ 100면체 주사위를 굴렸을 때 나오는 숫자 중 획득 가능 범위를 지정해 주시길 바랍니다. (0 ~ 100)<br />※ 다수의 구간이 겹칠 시,랜덤으로 획득 됩니다.") ?>
						<input type="text" name="me_per_s" value="<?php echo $me['me_per_s']; ?>" id="me_per_s" size="5" maxlength="11">
						~
						<input type="text" name="me_per_e" value="<?php echo $me['me_per_e']; ?>" id="me_per_e" size="5" maxlength="11"> 구간 획득
					</td>
				</tr>
				<tr>
					<th scope="row">획득가능갯수설정</th>
					<td colspan="2">
						<?php echo help("※ 총 획득 갯수를 제한합니다. 0 입력 시 제한하지 않습니다.") ?>
						<input type="text" name="me_replay_cnt" value="<?=$me['me_replay_cnt']?>" size="10"/>
					</td>
				</tr>
				<tr>
					<th scope="row">획득갯수설정</th>
					<td colspan="2">
						<?php echo help("※ 현재까지 멤버들이 획득한 갯수를 수정합니다.") ?>
						<input type="text" name="me_now_cnt" value="<?=$me['me_now_cnt']?>" size="10"/>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_002">
	<h2 class="h2_frm">이벤트 효과 설정</h2>
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
					<th scope="row">획득 아이템</th>
					<td colspan="2">
						<input type="hidden" name="me_get_item" id="me_get_item" value="<?=$me['me_get_item']?>" />
						<input type="text" name="it_name" value="<?=get_item_name($me['me_get_item'])?>" id="it_name" onkeyup="get_ajax_item(this, 'item_list', 'me_get_item');" />
						<div id="item_list" class="ajax-list-box"><div class="list"></div></div>
					</td>
				</tr>
				<tr>
					<th scope="row">화폐 변동</th>
					<td colspan="2">
						<input type="text" name="me_get_money" value="<?=$me['me_get_money']?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">위치이동</th>
					<td colspan="2">
						<select name="me_move_map">
							<option value="">-</option>
						<? for($k=0; $k < count($map); $k++) { ?>
							<option value="<?=$map[$k]['id']?>" <?php echo get_selected($map[$k]['id'], $me['me_move_map']); ?>><?=$map[$k]['name']?></option>
						<? } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row" rowspan="2">몬스터설정</th>
					<td class="bo-right">
						HP
					</td>
					<td>
						<input type="text" name="me_mon_hp" value="<?=$me['me_mon_hp']?>" />
					</td>
				</tr>
				<tr>
					<td class="bo-right">
						공격력
					</td>
					<td>
						<input type="text" name="me_mon_attack" value="<?=$me['me_mon_attack']?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<?php echo $frm_submit; ?>


</form>

<script>
function fshopform_submit(f)
{
	return true;
}

</script>

<?php
include_once ('./admin.tail.php');
?>
