<?php
$sub_menu = "400210";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

// 캐릭터 합발 여부 체크 필드가 존재하지 않을 경우
$temp = sql_fetch("select * from {$g5['character_table']}");
if(!isset($temp['ch_pass_state'])) { 
sql_query(" ALTER TABLE `{$g5['character_table']}` ADD `ch_pass_state` varchar(255) NOT NULL DEFAULT '' AFTER `ch_state` ");
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

$sql_common = " from {$g5['character_table']} ";
$sql_search = " where ch_state = '대기' ";
if ($stx) {
	$sql_search .= " and ( ";

	if($sfl == 'ch_pass_state') {
		switch ($stx) {
			case '미정' :
				$sql_search .= " ({$sfl} = '') ";
				break;
			default :
				$sql_search .= " ({$sfl} like '{$stx}%') ";
				break;
		}
	} else {
		switch ($sfl) {
			default :
				$sql_search .= " ({$sfl} like '{$stx}%') ";
				break;
		}

	}
	$sql_search .= " ) ";
}

if($s_side) { 
	$sql_search .= " and ch_side = '{$s_side}' ";
}

if($s_class) { 
	$sql_search .= " and ch_class = '{$s_class}' ";
}


if (!$sst) {
	$sst = "ch_type";
	$sod = "asc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 50;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

// 합격
$sql = " select count(*) as cnt {$sql_common} where ch_state = '대기' and ch_pass_state = '합격' {$sql_order} ";
$row = sql_fetch($sql);
$pass_count = $row['cnt'];

// 보류
$sql = " select count(*) as cnt {$sql_common} where ch_state = '대기' and ch_pass_state = '보류' {$sql_order} ";
$row = sql_fetch($sql);
$pass2_count = $row['cnt'];

// 불합격
$sql = " select count(*) as cnt {$sql_common} where ch_state = '대기' and ch_pass_state = '불합' {$sql_order} ";
$row = sql_fetch($sql);
$pass3_count = $row['cnt'];


// 미정
$sql = " select count(*) as cnt {$sql_common} where ch_state = '대기' and ch_pass_state = '' {$sql_order} ";
$row = sql_fetch($sql);
$pass4_count = $row['cnt'];


$listall = '<a href="'.$_SERVER['PHP_SELF'].'" class="ov_listall">전체목록</a>';

$g5['title'] = '신청서 합격 관리';
include_once('./admin.head.php');

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$colspan = 8;

// 모바일 배경 가져오기
$m_background = get_style('m_background');
?>


<div class="local_ov01 local_ov">
	<?php echo $listall ?>
	수정완료 신청서 <?php echo number_format($total_count) ?>명
	<span style="float: right;">
		<a href="?sfl=ch_pass_state&amp;stx=합격">합격 <?php echo number_format($pass_count) ?></a>명 | 
		<a href="?sfl=ch_pass_state&amp;stx=보류">보류 <?php echo number_format($pass2_count) ?></a>명 | 
		<a href="?sfl=ch_pass_state&amp;stx=불합">불합 <?php echo number_format($pass3_count) ?></a>명 | 
		<a href="?sfl=ch_pass_state&amp;stx=미정">미정 <?php echo number_format($pass4_count) ?></a>명
	</span>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">
	<?
		if(count($ch_si) > 0) {
	?>
	<select name="s_side" id="c_side">
		<option value=""><?=$config['cf_side_title']?>선택</option>
	<? for($i=0; $i < count($ch_si); $i++) { ?>
		<option value="<?=$ch_si[$i]['id']?>" <?php echo get_selected($_GET['s_side'], $ch_si[$i]['id']); ?>><?=$ch_si[$i]['name']?></option>
	<? } ?>
	</select>
	<? } ?>
	<?
		if(count($ch_cl) > 0) {
	?>
	<select name="s_class" id="c_class">
		<option value=""><?=$config['cf_class_title']?>선택</option>
	<? for($i=0; $i < count($ch_cl); $i++) { ?>
		<option value="<?=$ch_cl[$i]['id']?>" <?php echo get_selected($_GET['s_class'], $ch_cl[$i]['id']); ?>><?=$ch_cl[$i]['name']?></option>
	<? } ?>
	</select>
	<? } ?>

	<select name="sfl" id="sfl">
		<option value="ch_name"<?php echo get_selected($_GET['sfl'], "ch_name"); ?>>캐릭터 이름</option>
		<option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>오너 아이디</option>
		<option value="ch_pass_state"<?php echo get_selected($_GET['sfl'], "ch_pass_state"); ?>>합격여부</option>
	</select>
	<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" class="frm_input">
	<input type="submit" class="btn_submit" value="검색">

	
	<?php if ($is_admin == 'super') { ?>
	<div class="btn_add01 btn_add" style="float:right;">
		<a href="./character_pass_manager_confirm.php" onclick="return confirm('합격자 일괄 처리 시, 합격된 캐릭터들 전원 승인으로 상태가 변경됩니다.처리 하시겠습니까?');">합격자 일괄 처리</a>
		<a href="./character_pass_manager_delete.php" onclick="return confirm('불합격자 일괄 처리 시, 불합격된 캐릭터들 전원 정보가 삭제됩니다. 처리 하시겠습니까?');" style="background:red;">불합격자 일괄 처리</a>
	</div>
	<?php } ?>
</form>

<div class="manager-wrap">
	<div class="btn_list01 btn_list btn_add" style="clear:both; text-align:left; float:none; padding:0;">
		<input type="button" onclick="$('#fmemberlist').submit();" value="상태 일괄 저장" style="background:#262931;" />
	</div>
	<div class="left">
		<form name="fmemberlist" id="fmemberlist" action="./character_pass_manager_update.php" onsubmit="return fshoplist_submit(this);" method="post">
			<input type="hidden" name="sst" value="<?php echo $sst ?>">
			<input type="hidden" name="sod" value="<?php echo $sod ?>">
			<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
			<input type="hidden" name="stx" value="<?php echo $stx ?>">
			<input type="hidden" name="page" value="<?php echo $page ?>">

			<ul class="calc-list">
				<?php
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					$ch_id = $row['ch_id'];
					$bg = 'bg'.($i%2);

					$color = "";
					switch($row['ch_pass_state']) {
						case "":
							$color = "#999;";
						break;
						case "합격":
							$color = "#9f9899;";
						break;
						case "불합":
							$color = "#999;";
						break;
						case "보류":
							$color = "#000;";
						break;

					}

					$is_prev_complete = false;
					if($row['ch_pass_state'] != '') {
						$is_prev_complete = true;
					}

				?>

					<li class="calc-item <?=$is_prev_complete ? "complete" : ""?>" data-type="<?=$row['ch_pass_state']?>">
						<input type="hidden" name="ch_id[<?=$i?>]" value="<?=$row['ch_id']?>" />
						<div class="thumb" style="background-image:url(<?=$row['ch_thumb']?>);"></div>
						<div class="info">
							<span class="state" data-type="<?=$row['ch_pass_state']?>"><?=$row['ch_pass_state'] ? $row['ch_pass_state'] : "미정"?></span>
							<span class="character">
								<?=$row['ch_name']?>
							</span>
						</div>
						<div class="re-content">
							<div class="control">
								<input type="radio" name="ch_pass_state[<?=$i?>]" id="state_<?=$i?>_0" value="" <?=($row['ch_pass_state'] == "" ? "checked" : "")?> />
								<label for="state_<?=$i?>_0" class="ty1">미정</label>
								
								<input type="radio" name="ch_pass_state[<?=$i?>]" id="state_<?=$i?>_1" value="합격" <?=($row['ch_pass_state'] == "합격" ? "checked" : "")?> />
								<label for="state_<?=$i?>_1" class="ty2">합격</label>

								<input type="radio" name="ch_pass_state[<?=$i?>]" id="state_<?=$i?>_2" value="보류" <?=($row['ch_pass_state'] == "보류" ? "checked" : "")?> />
								<label for="state_<?=$i?>_2" class="ty3">보류</label>

								<input type="radio" name="ch_pass_state[<?=$i?>]" id="state_<?=$i?>_3" value="불합" <?=($row['ch_pass_state'] == "불합" ? "checked" : "")?> />
								<label for="state_<?=$i?>_3" class="ty4">불합</label>
							</div>
						</div>
						<a href="<?=G5_URL?>/member/viewer.php?ch_id=<?=$row['ch_id']?>" target="frm_preview" onclick="check_item(this);" class="link">프로필</a>
					</li>
				<? } ?>
			</ul>

			<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['PHP_SELF'].'?'.$qstr); ?>

		</form>
	</div>
	<div class="right">
		<iframe src="" name="frm_preview"></iframe>
	</div>
</div>


<style>
body {min-width:1400px;}
#wrapper {height:100vh;}
.manager-wrap {display:block; position:absolute; top:175px; left:20px; right:20px; bottom:20px; overflow:hidden;}
.manager-wrap > .left {display:block; position:absolute; top:40px; left:0; bottom:0; width:500px; overflow:auto;}
.manager-wrap > .right {display:block; position:relative; height:100%; width:auto; margin-left:520px; border:1px solid #ddd; max-width:1000px; box-sizing:border-box; margin-top:-40px;}
.manager-wrap iframe {border:none; width:100%; height:100%;
	<? if($m_background['cs_value']) { ?>
	background-image: url('<?=$m_background['cs_value']?>');
	<? } else { ?>
	background-image: none;
	<? } if($m_background['cs_etc_1']) { ?>
	background-color: <?=$m_background['cs_etc_1']?>;
	<? } if($m_background['cs_etc_2']) { ?>
	background-repeat: <?=$m_background['cs_etc_2']?>;
	<? } if($m_background['cs_etc_3']) { ?>
	background-position: <?=$m_background['cs_etc_3']?>;
	<? } if($m_background['cs_etc_4']) { ?>
	background-size: <?=$m_background['cs_etc_4']?>;
	<? } if($m_background['cs_etc_5']) { ?>
	background-attachment: <?=$m_background['cs_etc_5']?>;
	<? } ?>
}


.calc-list {display:block; position:relative; margin:0 0 20px; padding:0; clear:both;}
.calc-item {display:block; position:relative; border:1px solid #dadada; margin:0; padding:10px; padding-left:70px; padding-right:70px;}
.calc-item > .thumb {position:absolute; width:50px; height:50px; top:10px; left:10px; overflow:hidden; background:no-repeat 50% 50%; background-size:cover;}
.calc-item + .calc-item {margin-top:5px;}
.calc-list .calc-item:nth-child(even) {background:#f1f1f1;}

.calc-item .link {display:block; position:absolute; top:10px; right:10px; width:50px; height:50px; background:#29c7c9; line-height:50px; text-align:center; color:#fff;}

.calc-item:hover {background:#ffdddd !important; border-color:#e2a0a0;}

.calc-item.focus {background:#fff8d4 !important; border-color:#e0d184;}

.calc-item.over {background:#608fca !important; border-color:#2f7ad8;}
.calc-item.over * {color:#fff;}

.calc-item.complete:before {content:""; display:block; position:absolute; top:-1px; left:-1px; bottom:-1px; width:4px; background:red;}

.calc-item.complete[data-type="합격"]:before {background:#2e4893;}
.calc-item.complete[data-type="보류"]:before {background:#999;}
.calc-item.complete[data-type="불합"]:before {background:#000000;}

.calc-item .info {display:table; width:100%; table-layout:fixed;}
.calc-item .info > * {display:table-cell; vertical-align:middle; font-size:12px;}
.calc-item .info .state {width:50px;}

.calc-item .info .state[data-type=""] {color:#cc5959;}
.calc-item .info .state[data-type="합격"] {color:#2e4893;}
.calc-item .info .state[data-type="보류"] {color:#999;}
.calc-item .info .state[data-type="불합"] {color:#000000;}

.calc-item .info .num {opacity:.6; width:70px; text-align:center;}
.calc-item .info .type {text-align:center; width:80px;}
.calc-item .info .tit em {display:inline-block; font-style:normal; font-size:11px; background:rgba(0,0,0,.4); padding:2px 3px; color:#fff; font-weight:300; font-family:'dotum';}

.calc-item .calc {display:table; width:100%; table-layout:fixed; margin-top:10px;}
.calc-item .calc > * {display:table-cell; vertical-align:middle; font-size:12px; margin:0;}
.calc-item .calc .ty1 {width:220px;}
.calc-item .calc .ty2 {width:230px;}
.calc-item .calc .ty3 {width:230px;}
.calc-item .calc .ty4 {width:auto;}
.calc-item .calc dl {display:table; width:100%; table-layout:fixed; margin:0;}
.calc-item .calc dt,
.calc-item .calc dd {display:table-cell; margin:0; padding:0;}
.calc-item .calc dt {white-space:nowrap; text-align:right; box-sizing:border-box; padding-right:5px;}
.calc-item .calc dt input {display:none;}
.calc-item .calc dt span,
.calc-item .calc dt label {display:block; position:relative; text-align:center; height:25px; line-height:22px; box-sizing:border-box; border:1px solid rgba(0,0,0,.5); background:rgba(0,0,0,.3); color:#fff; border-radius:3px;}
.calc-item .calc dt input:checked + label {background:#29c7c9;}

.calc-item .calc .ty1 dt {width:60px;}
.calc-item .calc .ty2 dt {width:65px;}
.calc-item .calc .ty3 dt {width:65px;}
.calc-item .calc .ty4 dt {width:50px;}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {-webkit-appearance: none;}

.calc-item .calc input[type="number"],
.calc-item .calc input[type="text"],
.calc-item .calc input[type="number"] {background:transparent; border:none; border-bottom:1px solid rgba(0,0,0,.5);; height:25px; padding:0; width:100px; outline:0;}
.calc-item .calc input[type="number"] {appearance:none; -webkit-appearance:none;}
.calc-item .calc input[type="text"].error,
.calc-item .calc input[type="number"].error {color:red; font-weight:800;}
.calc-item .calc .small {width:30px !important;}

.calc-item .calc .ty4 input[type="text"] {width:100%;}

.calc-item .re-content {display:table; width:100%; table-layout:fixed; margin-top:10px;}
.calc-item .re-content > * {display:table-cell; vertical-align:middle; font-size:12px; margin:0;}
.calc-item .re-content input[type="text"] {border:none; width:100%; border-bottom:1px solid rgba(0,0,0,.5); background:transparent; outline:0; padding:0;}
.calc-item .re-content .control {width:190px; text-align:right;}
.calc-item .re-content .control input {display:none;}
.calc-item .re-content .control label {display:inline-block; position:relative; vertical-align:middle; width:60px; text-align:center; height:25px; line-height:22px; box-sizing:border-box; border:1px solid rgba(0,0,0,.3); color:#333; border-radius:0px;}
.calc-item .re-content .control label.ty1 {color:red;}
.calc-item .re-content .control label.ty2 {color:#2e4893;}
.calc-item .re-content .control label.ty3 {color:#999;}
.calc-item .re-content .control label.ty4 {color:#000000;}

.calc-item .re-content .control input:checked + label.ty1 {background:#cc5959; color:#fff;}
.calc-item .re-content .control input:checked + label.ty2 {background:#2e4893; color:#fff;}
.calc-item .re-content .control input:checked + label.ty3 {background:#999; color:#fff;}
.calc-item .re-content .control input:checked + label.ty4 {background:#000000; color:#fff;}

</style>

<script>
function fshoplist_submit(f) {
	return true;
}
function check_item(obj) {
	$(obj).closest('li').addClass('over').siblings().removeClass('over');
}
function reset_item() {
	$('.calc-list').find('li').removeClass('hover');
}

$('.calc-list *').on('focus', function() {
	$(this).closest('.calc-item').addClass('focus');
}).on('focusout', function() {
	$(this).closest('.calc-item').removeClass('focus');
});



</script>

<?php
include_once ('./admin.tail.php');
?>
