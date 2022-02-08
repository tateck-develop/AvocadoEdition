<?php
$sub_menu = "600300";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$token = get_token();

$start_area = sql_fetch("select * from {$g5['map_table']} where ma_id = '{$ma_id}'");

if(!$start_area['ma_id']) { 
	alert("지역정보를 확인할 수 없습니다.");
}

$end_result = sql_query("select * from {$g5['map_table']} where ma_id != '{$ma_id}' and ma_id = ma_parent");
$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./map_list.php">메인으로</a>
</div>';

$g5['title'] = "[ ".$start_area['ma_name']." ] 지역 통행 관리";
include_once ('./admin.head.php');

?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>" id="token">
<input type="hidden" name="mf_start" value="<?=$start_area['ma_id']?>" />

<section id="anc_cf_basic">
    <h2 class="h2_frm">각 지역간 이동 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>지역간 이동 설정</caption>
        <colgroup>
            <col style="width: 150px;" />
            <col style="width: 150px;" />
			<col />
        </colgroup>
        <tbody>
<?
	for($i=0; $end = sql_fetch_array($end_result); $i++) { 
		unset($mf);
		$mf = sql_fetch("select * from {$g5['map_move_table']} where mf_start = '{$ma_id}' and mf_end = '{$end['ma_id']}'");
		$checked = "";
		$use_save = "";
		if(!$mf['mf_id']) { 
			$mf = sql_fetch("select mf_use from {$g5['map_move_table']} where mf_start = '{$end['ma_id']}' and mf_end = '{$ma_id}'");
			$checked = $mf['mf_use'] ? "checked" : "";
			$use_save = "<span style='color: red;'> (저장필요)</span>";
		} else {
			$checked = $mf['mf_use'] ? "checked" : "";
		}
?>
        <tr>
            <th scope="row">
				<?=$start_area['ma_name']?> ↔ <?=$end['ma_name']?>
			</th>
            <td>
				<input type="checkbox" name="mf_use[<?=$i?>]" value="1" <?=$checked?> id="mf_use_<?=$i?>">
				<label for="mf_use_<?=$i?>">이동가능</label>
				<?=$use_save?>
				
				<input type="hidden" name="index[]" value="<?=$i?>" />
				<input type="hidden" name="mf_end[<?=$i?>]" value="<?=$end['ma_id']?>" />
				<input type="hidden" name="mf_id[<?=$i?>]" value="<?=$mf['mf_id']?>" />
			</td>
			<td></td>
        </tr>
<? } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

</form>

<script>
function fconfigform_submit(f)
{
    f.action = "./map_move_update.php";
    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
