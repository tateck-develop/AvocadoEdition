<?php
include_once('./_common.php');
include_once('./_head.php');

$ch_array = array();
$character_result = sql_query("select * from {$g5['character_table']} where mb_id = '{$member['mb_id']}' and ch_state != '삭제'");
for($i=0; $row = sql_fetch_array($character_result); $i++) { 
	$ch_array[$i] = $row;
}

if($i==1) { 
	//goto_url('./viewer.php?ch_id='.$ch_array[0]['ch_id']);
}
?>

<section>
	<div>
		<table class="theme-form">
			<colgroup>
				<col style="width: 110px;" />
			</colgroup>
			<tbody>
				<tr>
					<th>대표캐릭터</th>
					<td>
						<form name="frm_main_character" action="./maincharacter_update.php" method="post">
							<input type="hidden" name="mb_id" value="<?=$member['mb_id']?>" />
							<input type="hidden" name="return_url" value="character" />
							<select name="ch_id" id="ch_id">
								<option value="">대표캐릭터 선택</option>
						<?	for($i = 0; $i < count($ch_array); $i++) { $ch = $ch_array[$i]; ?>
								<option value="<?=$ch['ch_id']?>" <?=$member['ch_id'] == $ch['ch_id'] ? "selected" : ""?>>
									<?=$ch['ch_name']?>
								</option>
						<? } ?>
							<select>
							<input type="submit" value="변경" class="ui-btn"/>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<section>
	<div class="list-character-box">
<?	for($i = 0; $i < count($ch_array); $i++) { $ch = $ch_array[$i]; ?>
		<div class="item theme-box">
			<a href="./viewer.php?ch_id=<?=$ch['ch_id']?>">
				<? if($ch['ch_thumb']) { ?>
					<em style="background-image:url('<?=$ch['ch_thumb']?>');"></em>
				<? } else { ?>
					<em></em>
				<? } ?>
				<strong><?php echo $ch['ch_name'] ?></strong>
				<? if($config['cf_side_title']) { ?>
					<span><?=get_side_name($ch['ch_side'])?></span>
				<? } ?>
				<? if($config['cf_class_title']) { ?>
					<span><?=get_class_name($ch['ch_class'])?></span>
				<? } ?>
				<? if($article['ad_use_rank']) { ?>
					<span>
						<?php echo get_rank_name($ch['ch_rank']) ?> 
					</span>
				<? } ?>
				<? if($article['ad_use_exp']) { ?>
					<span>
						<?php echo $ch['ch_exp'].$config['cf_exp_pice'] ?> 
					</span>
				<? } ?>
			</a>
		</div>
<? } ?>
	</div>

<? if($is_add_character && ($i == 0 || $i < $config['cf_character_count'])) { ?>
	<div class="txt-center">
		<a href="./character_form.php" class="ui-btn point">신규 캐릭터 등록</a>
	</div>
<? } ?>
</section>


<?php
include_once('./_tail.php');
?>
