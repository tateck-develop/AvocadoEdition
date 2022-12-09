<?php
include_once('./_common.php');
include_once('./_head.php');

if(!$ch_id) $ch_id = $character['ch_id'];
$ch = get_character($ch_id);
if(!$ch['ch_id']) {
	alert("캐릭터 정보가 존재하지 않습니다.");
}
if($ch['mb_id'] != $member['mb_id'] && !$is_admin) { 
	alert("본인 소유의 캐릭터가 아닙니다.");
}
/* 오너 정보 */
$mb = $member;

/** 스탯 이용 시 스탯 설정값 가져오기 **/
if($article['ad_use_status']) { 
	$status = array();
	$st_result = sql_query("select * from {$g5['status_config_table']} order by st_order asc");
	for($i = 0; $row = sql_fetch_array($st_result); $i++) {
		$status[$i] = $row;
	}
}
/** 추가 항목 설정값 가져오기 **/
$ch_ar = array();
$str_secret = ' where (1) ';

if($member['mb_id'] == $mb['mb_id']) {
	$str_secret .= " and ar_secret != 'H' ";
} else {
	$str_secret .= " and ar_secret = '' ";
}

$ar_result = sql_query("select * from {$g5['article_table']} {$str_secret} order by ar_order asc");
for($i = 0; $row = sql_fetch_array($ar_result); $i++) {
	$ch_ar[$i] = $row;
}

// --- 캐릭터 별 추가 항목 값 가져오기
$av_result = sql_query("select * from {$g5['value_table']} where ch_id = '{$ch['ch_id']}'");
for($i = 0; $row = sql_fetch_array($av_result); $i++) {
	$ch[$row['ar_code']] = $row['av_value'];
}

// ------- 캐릭터 의상 정보 가져오기
$temp_cl = sql_fetch("select * from {$g5['closthes_table']} where ch_id = '{$ch_id}' and cl_use = '1'");
if($temp_cl['cl_path']) { 
	$ch['ch_body'] = $temp_cl['cl_path'];
}

if(!$tabs) { $tabs = 'c'; }

?>
<style>
.tab-nav {text-align:center; padding:10px; margin-bottom:30px; background:#333;}
.tab-nav button {font-size:14px; border:none; color:#fff; height:30px; padding:0 20px; margin:2px 0; background:#000;}
@media all and (max-width:640px) {
	.tab-nav {padding:10px 0;}
	.tab-nav img {width:14px;}
	.tab-nav button {font-size:12px;}
}
@media all and (max-width:520px) {
	.profile-viewer .prof,
	.tab-nav {margin-left:-16px; margin-right:-16px;}
}


.closet-list									{  }
.closet-list fieldset						{ position: relative; margin-top: 10px; padding-left:120px; padding-right: 80px; }
.closet-list fieldset input#cl_sibject		{ position: absolute;top: 0; left: 0; width: 115px; }
.closet-list fieldset input#cl_sibject::placeholder {color:rgba(255,255,255,.3);}
.closet-list fieldset input[type="submit"]	{ position: absolute;top: 0; right: 0; line-height: 1.0em; height:30px; width: 75px; }

.closet-list ul							{ text-align: left; }
.closet-list ul li						{ position: relative; padding: 10px 80px 10px 10px; border-bottom: 1px solid rgba(255, 255, 255,0.1); }
.closet-list ul .ui-btn-box				{ position: absolute; top: 5px; right: 0px; bottom:5px; width:80px; }
.closet-list ul .ui-btn-box a			{ display: block; position: relative; height: 100%; width: 30px; float: left; margin-left: 5px; overflow: hidden;text-indent:-999px; border-radius: 2px; }
.closet-list ul .ui-btn-box a:before	{ display: block; position: absolute; font-family: 'icon'; font-size: 15px; width:20px; height:20px; left: 50%; top: 50%; margin-top: -10px; margin-left: -10px; text-indent:0; text-align: center; line-height: 20px; }


.closet-list ul .ui-btn-box a.btn-use:before			{ content: "\e9c3"; font-size: 20px; line-height: 23px; }
.closet-list ul .ui-btn-box a.btn-del:before			{ content: "\e9ac"; }

.closet-list ul .selected .ui-btn-box  	{ display: none; }
.closet-list ul .selected:after			{ content: "사용중"; display:block; position: absolute; width: 70px; top: 10px; right: 10px; text-align: center; }
</style>

<div class="profile-viewer">
	<div class="body">
		<?
			if(strpos($ch['ch_body'], "<img")) { 
				$ch['ch_body'] = "";
			}
		?>
		<em style="background-image:url('<?=$ch['ch_body']?>');"></em>
	</div>

	<div class="data">
		
		<div class="control">
			<? if($ch['ch_state'] != '승인' || $is_mod_character || $is_admin) { ?>
			<a href="./character_form.php?w=u&amp;ch_id=<?=$ch['ch_id']?>">
				수정
			</a>
			<? } ?>
			
			<a href="<?=G5_URL?>/member/exp.php?ch_id=<?=$ch['ch_id']?>" onclick="popup_window(this.href, 'exp', 'width=400, height=500'); return false;">
				경험치
			</a>
		</div>

		<div class="prof">
			<div class="thumb-item">
			<?
				if(strpos($ch['ch_thumb'], "<img")) { 
					$ch['ch_thumb'] = "";
				}
			?>
				
				<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$ch['ch_id']?>" class="character-picture" title="클릭 시 멤버란으로 이동됩니다.">
					<div class="ui-thumb">
						<? if($ch['ch_thumb']) { ?>
							<em><img src="<?=$ch['ch_thumb']?>" alt="" /></em>
						<? } ?>
					</div>
					<div class="name">
						<strong><?=$ch['ch_name']?></strong>
					</div>
				</a>
			</div>
			
			<div class="prof-data">
				<p>
					<strong><?php echo $ch['ch_name'] ?></strong>
					<?php echo get_rank_name($ch['ch_rank']); ?> &middot; <?=get_side_name($ch['ch_side'])?> &middot; <?=get_class_name($ch['ch_class'])?>
				</p>
				<p>
					<?=$ch['ch_exp']?> <?=$config['cf_exp_pice']?>
				</p>
			</div>
		</div>


		<div class="tab-nav">
			<? if($article['ad_use_closet'] && $article['ad_use_body']) { ?>
				<button type="button" onclick="$('#closest_area').show().siblings().hide();">옷장</button>
			<? } ?>
			<? if($article['ad_use_status']) { ?>
				<button type="button" onclick="$('#status_area').show().siblings().hide();">스탯</button>
			<? } ?>
			<? if($article['ad_use_title']) { ?>
				<button type="button" onclick="$('#title_area').show().siblings().hide();">타이틀</button>
			<? } ?>
			<? if($article['ad_use_inven']) { ?>
				<button type="button" onclick="$('#inventory_area').show().siblings().hide();">아이템</button>
			<? } ?>
			<? if($ch['ch_state'] == '승인') { ?>
				<button type="button" onclick="$('#relation_area').show().siblings().hide();">관계</button>
			<? } ?>
		</div>

		<div class="tab-box-group" style="min-height:300px;">
			<? if($article['ad_use_closet'] && $article['ad_use_body']) { ?>
				<div class="tab-box" id="closest_area" <?=$tabs == 'c' ? "" : "style='display:none;'"?>>
					<? include_once(G5_PATH."/mypage/character/cloest.inc.php"); ?>
				</div>
			<? } ?>

			<? if($article['ad_use_status']) { ?>
				<div class="tab-box" id="status_area" <?=$tabs == 's' ? "" : "style='display:none;'"?>>
					<? if($article['ad_use_status']) { ?>
						<span style="float:right; display:block;"><em class="txt-point" data-type="point_space"><?=get_space_status($ch['ch_id'])?></em>/<?=$ch['ch_point']?></span>
						<div class="mypage-box" style="overflow:hidden; clear:both;">
							<? include_once(G5_PATH."/mypage/character/status.inc.php"); ?>
						</div>
					<? } ?>
				</div>
			<? } ?>

			<? if($article['ad_use_title']) { ?>
				<div class="tab-box" id="title_area" <?=$tabs == 't' ? "" : "style='display:none;'"?>>
					<div class="mypage-box">
						<? include_once(G5_PATH."/mypage/character/title.inc.php"); ?>
					</div>
				</div>
			<? } ?>
			<? if($article['ad_use_inven']) { ?>
				<div class="tab-box" id="inventory_area" <?=$tabs == 'i' ? "" : "style='display:none;'"?>>
					<? include_once(G5_PATH."/inventory/list.inc.php"); ?>
				</div>
			<? } ?>
			<? if($ch['ch_state'] == '승인') { ?>
				<div class="tab-box" id="relation_area" <?=$tabs == 'r' ? "" : "style='display:none;'"?>>
					<? if($ch['ch_state'] == "승인") { ?>
					<div class="mypage-box relation-box">
						<? include(G5_PATH.'/mypage/character/relation_list.php'); ?>
					</div>
					<? } ?>
				</div>
			<? } ?>
		</div>

		<? if($ch['ch_state'] != '승인') { ?>
		<div style="padding-top:50px; text-align:center;">
			
			<a href="./character_delete.php?ch_id=<?=$ch['ch_id']?>" class="ui-btn full" onclick="return confirm('정말 삭제 하시겠습니까?');">
				캐릭터 정보 삭제
			</a>
			
		</div>
		<? } ?>
	</div>
</div>
<hr class="padding" />

<?php
include_once('./_tail.php');
?>
