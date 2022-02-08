<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

$relation_list = "select * from {$g5['relation_table']} where ch_id='{$ch_id}' order by rm_order asc, rm_id desc";
$relation = sql_query($relation_list);

// 캐릭터 소유주일 시, 관계란 입력폼 출력

if($mb['mb_id'] == $member['mb_id']) {
?>
<form name="frmRemember" method="post" action="<?=G5_URL?>/mypage/character/relation_update.php"  onsubmit="return fwrite_submit(this);">
	<input type="hidden" name="w" value="" />
	<input type="hidden" name="ch_id" value="<?=$ch_id?>" />
	<input type="hidden" name="re_ch_id" id="search_re_ch_id" value="" />

	<table class="theme-form">
		<colgroup>
			<col style="width: 100px;" />
			<col />
		</colgroup>
		<tbody>
			<tr>
				<th>대상캐릭터</th>
				<td>
					<input type="hidden" name="re_ch_id" id="search_re_ch_id" value="" />
					<input type="text" name="search_re_ch_name" value="" id="search_re_ch_name" onkeyup="get_ajax_character(this, 'character_list', 'search_re_ch_id');" />
					<div id="character_list" class="ajax-list-box theme-box"><div class="list"></div></div>
				</td>
			</tr>

			<tr>
				<th>호감도</th>
				<td>
					<select name="rm_like" style="width: 100%; margin-bottom: 5px;">
						<option value="">호감도</option>
						<option value="5">5 : ♡♡♡♡♡</option>
						<option value="4">4 : ♡♡♡♡</option>
						<option value="3">3 : ♡♡♡</option>
						<option value="2">2 : ♡♡</option>
						<option value="1">1 : ♡</option>
						<option value="0">0 </option>
					</select>
				</td>
			</tr>

			<tr>
				<th>관계요약</th>
				<td>
					<textarea name="rm_memo" placeholder="관계요약입력" class="full" rows="8"></textarea>
				</td>
			</tr>

			<tr>
				<th>관계링크입력</th>
				<td>
					<textarea name="rm_link" placeholder="관계링크입력 : 여러개를 입력할 경우, 엔터로 구분해 주시길 바랍니다.
ex)
http://url-1
http://url-2
...
" class="full" rows="8"></textarea>
				</td>
			</tr>

			<tr>
				<th>순서</th>
				<td>
					<input type="text" name="rm_order" value="0" class="required frm_input " style="width: 50px;" />
				</td>
			</tr>
			
		</tbody>
	</table>
	
	<button type="submit" class="ui-btn full point">추가</button>

	<hr class="padding" />
</form>

<? } ?>

<ul class="relation-member-list">
<?
	for($i=0; $row = sql_fetch_array($relation); $i++) { 
	$re_ch = get_character($row['re_ch_id']);
	if($row['rm_memo'] == '') { continue; }
?>
		<li id="rm_<?=$row['rm_id']?>">
			<div class="ui-thumb">
				<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$re_ch['ch_id']?>" target="_blank">
					<img src="<?=$re_ch['ch_thumb']?>" />
				</a>
			</div>
			<div class="info">
				<div class="rm-name">
					<?=$re_ch['ch_name']?>
					<? if($mb['mb_id'] == $member['mb_id']) { ?>
							<a href="#rm_<?=$row['rm_id']?>" class="btn-modify ui-btn small">수정</a>
							<a href="<?=G5_URL?>/mypage/character/relation_delete.php?rm_id=<?=$row['rm_id']?>" class="btn-delete ui-btn small" onclick="return confirm('삭제된 데이터는 복구할 수 없습니다. 삭제 하시겠습니까?');">삭제</a>
					<? } ?>
				</div>
				<div class="rm-like-style">
					<p>
				<? for($j=0; $j < 5; $j++) { 
					$class="";
					$style = "";
					if($j < $row['rm_like']) {
						$class="txt-point";
					} else {
						$style="opacity: 0.2;";
					}
				?>
					
						<i class="<?=$class?>" style="<?=$style?>"></i>
				<? } ?>
					</p>
				</div>
			</div>
			<div class="memo  theme-box">
				<div class="ori-content"><?=nl2br($row['rm_memo'])?></div>
<? if($mb['mb_id'] == $member['mb_id']) { ?>
				<div class="modify-box">
					<input type="hidden" id="re_ch_id_<?=$row['rm_id']?>" value="<?=$row['re_ch_id']?>" />
					<select id="like_<?=$row['rm_id']?>" style="width: 100%; margin-bottom: 5px;">
						<option value="">호감도</option>
						<option value="5" <?=$row['rm_like'] == '5' ? 'selected': ''?> >5 : ♡♡♡♡♡</option>
						<option value="4" <?=$row['rm_like'] == '4' ? 'selected': ''?>>4 : ♡♡♡♡</option>
						<option value="3" <?=$row['rm_like'] == '3' ? 'selected': ''?>>3 : ♡♡♡</option>
						<option value="2" <?=$row['rm_like'] == '2' ? 'selected': ''?>>2 : ♡♡</option>
						<option value="1" <?=$row['rm_like'] == '1' ? 'selected': ''?>>1 : ♡</option>
						<option value="0" <?=$row['rm_like'] == '0' ? 'selected': ''?>>0 </option>
					</select>
					<textarea id="memo_<?=$row['rm_id']?>" class="full" rows="8"><?=$row['rm_memo']?></textarea>
					<textarea id="link_<?=$row['rm_id']?>" class="full" rows="8"><?=$row['rm_link']?></textarea>
					<p>순서 <input type="text" id="order_<?=$row['rm_id']?>" value="<?=$row['rm_order']?>" class="frm_input " style="width: 50px;" /></p>

					<button type="button" class="ui-btn full point" onclick="fn_relation_modify(<?=$row['rm_id']?>);" style="margin-top: 5px;">UPDATE</button>
				</div>
<? } ?>
			</div>
			
			<ol>
	<?
		$row['rm_link'] = nl2br($row['rm_link']);
		$link_list = explode('<br />', $row['rm_link']);
		for($j=0; $j < count($link_list); $j++) {
			$r_row = $link_list[$j];
			if(!$r_row) continue;
	?>
				<li>
					<a href="<?=$r_row?>" class="btn-log" target="_blank"></a>
				</li>
	<? } ?>
			</ol>

		</li>


<? }?>
</ul>

<? if($mb['mb_id'] == $member['mb_id']) { ?>
<form name="frmRemember_modify" id="frmRemember_modify" method="post" action="<?=G5_URL?>/mypage/character/relation_update.php"  onsubmit="return fwrite_submit(this);">
	<input type="hidden" name="ch_id" value="<?=$ch_id?>" />
	<input type="hidden" name="w" value="u" />
	<input type="hidden" name="rm_id"/>
	<input type="hidden" name="re_ch_id"/>
	<input type="hidden" name="rm_memo"/>
	<input type="hidden" name="rm_link"/>
	<input type="hidden" name="rm_order"/>
	<input type="hidden" name="rm_like"/>
</form>
<? } ?>

<script>
$('.btn-modify').on('click', function() {
	$(this).closest('li').toggleClass('state-modify');
	return false;
});
function fwrite_submit(f) {
	return true;
}

function fn_relation_modify(idx) { 
	var f = document.frmRemember_modify;
	
	var rm_id = idx;
	var re_ch_id = document.getElementById('re_ch_id_' + idx).value;
	var rm_memo = document.getElementById('memo_' + idx).value;
	var rm_link = document.getElementById('link_' + idx).value;
	var rm_order = document.getElementById('order_' + idx).value;
	var rm_like = document.getElementById('like_' + idx).value;
	
	f.rm_id.value = rm_id;
	f.re_ch_id.value = re_ch_id;
	f.rm_memo.value = rm_memo;
	f.rm_link.value = rm_link;
	f.rm_order.value = rm_order;
	f.rm_like.value = rm_like;

	f.submit();
}



</script>