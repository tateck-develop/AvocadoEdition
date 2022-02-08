<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 

$state_space_point = get_space_status($ch['ch_id']);

$total_point = $ch['ch_point'] ? $ch['ch_point'] : $config['cf_status_point'];

$status_modify = false;
$use_status_form = false;
$status_fix = true;

$resent_use_point = 0;

if($member['mb_id']) { 
	if($member['mb_id'] == $mb['mb_id']) { 
		// 캐릭터 수정 상태
		if($ch['ch_state'] != '승인') {
			// 미승인 상태 - 수정이 자유로운 경우
			$status_modify = true;
			$status_fix = false;
		} else if($state_space_point > 0) {
			// 승인 상태, 잔여 포인트가 남아 있을 경우
			$status_modify = true;
			$status_fix = true;
		}

		if(defined('_CHARACTER_FORM_')) {
			// 현재 캐릭터 수정 폼일때
			$use_status_form = false;
		} else {
			// 일반 멤버 프로필 보기 상태일 때
			$use_status_form = true;
		}

	} else if(!$ch['ch_id']) { 

		// 캐릭터 최초 등록 상태
		$status_modify = true;
		$use_status_form = false;
		$status_fix = false;
	}

}

?>

<? if($use_status_form && $status_modify) { ?>
<form name="fwrite" id="fwrite" action="<?=G5_URL?>/mypage/character/status_update.php" onsubmit="return fstatus_submit(this);" method="post" autocomplete="off">
	<input type="hidden" name="ch_id" value="<?php echo $ch['ch_id']; ?>">
	<input type="hidden" name="ch_point" value="<?php echo $ch['ch_point']; ?>">
	<input type="hidden" name="url" value="<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
<? } ?>

<div class="status-bar" data-total="<?=$ch['ch_point']?>" data-space="<?=$state_space_point?>">
<? for($i = 0; $i < count($status); $i++) {
	$st = $status[$i];
	$sc = get_status($ch['ch_id'], $st['st_id']);
	
	$sc['has']	= $sc['has'] ? $sc['has'] : $sc['min'];
	$min_data	= !$status_fix ? $sc['min'] : $sc['has'];

	$status_percent = $sc['max'] ? $sc['has'] / $sc['max'] * 100 : 0;
	$mine_percent = $sc['max'] ? $sc['now'] / $sc['max'] * 100 : 0;

	$resent_use_point += $sc['has'];
	
	$sub_text = "";
	if($sc['drop']) $sub_text = "(".$sc['now'].")"; 
?>
		<dl data-idx="<?=$st['st_id']?>" data-min="<?=$min_data?>" data-max="<?=$sc['max']?>" <?=$status_modify ? "class='ui-control'" : ""?>>
		<? if($status_modify) { ?>
			<input type="hidden" id="st_id_<?=$st['st_id']?>" name="st_id[]" value="<?=$st['st_id']?>" />
			<input type="hidden" id="sc_max_<?=$st['st_id']?>" name="sc_max[]" value="<?=$sc['has']?>" >
		<? } ?>

			<dt><?=$st['st_name']?></dt>
			<dd>
				<p>
					<i><?=$sc['has']?><?=$sub_text?></i>	
					<span style="width: <?=$status_percent?>%;"></span>
					<sup style="width: <?=$mine_percent?>%;"></sup>
				</p>
				<?php if($st['st_help'] && !$use_status_form && $status_modify) { echo help($st['st_help']); } ?>
			</dd>
			<? if($status_modify) { ?>
			<dd class="control">
				<a href="#" data-idx="<?=$st['st_id']?>" data-function="plus" class="ui-btn <?=($sc['max'] <= $sc['has']) ? "disable" : "point"?>">포인트 추가</a>
				<a href="#" data-idx="<?=$st['st_id']?>" data-function="minus" class="ui-btn <?=($min_data >= $sc['has']) ? "disable" : "point"?>">포인트 차감</a>
			</dd>
			<? } ?>
		</dl>
<? } ?>
</div>

<? if($status_modify) { ?>
<script>

// 포인트 셋팅
set_space_status('<?=($total_point - $resent_use_point)?>');

var now_control_obj = null;
var plus_function = null;
var minus_function = null;

$('a[data-function="plus"]').on('click', function() {
	now_control_obj = this;
	fn_status_plus();
	return false;
}).on('mousedown', function() {
	now_control_obj = this;
	plus_function = null;
	minus_function = null
	plus_function = setInterval(fn_status_plus, 500);
}).on('mouseup mouseleave', function() {
	clearTimeout(plus_function);
	plus_function = null;
	minus_function = null
	now_control_obj = null;
});

$('a[data-function="minus"]').on('click', function() {
	now_control_obj = this;
	fn_status_minus();
	return false;
}).on('mousedown', function() {
	now_control_obj = this;
	minus_function = null;
	plus_function = null;
	minus_function = setInterval(fn_status_minus, 500);
}).on('mouseup mouseleave', function() {
	clearTimeout(minus_function);
	minus_function = null;
	now_control_obj = null;
	plus_function = null;
});

function fn_status_plus() {
	var obj = now_control_obj;

	if($(obj).hasClass('disable')) {
		// 사용불가

	} else {
		// 스텟 포인트 추가 이벤트
		var parent_box = $(obj).closest('.status-bar');
		var status = $(obj).closest('dl');

		var all_max_point = parent_box.attr('data-total');
		var now_space_point = parent_box.attr('data-space');

		var state_id = $(obj).attr('data-idx');

		// 남은 분배 포인트가 0 보다 클 경우
		if(now_space_point > 0) {

			var input_obj = $('#sc_max_' + state_id);
			var max_point = status.attr('data-max'); // 해당 스텟의 최대값
			var temp_point = (input_obj.val() * 1) + 1; // 증가치 계산
			
			if(temp_point <= max_point) {
				// 포인트 추가
				input_obj.val(temp_point);

				// 그래프 사이즈 조절
				var percent_value = (temp_point/max_point) * 100;
				status.find('dd').find('p').find('span').css('width', ((temp_point/max_point) * 100) + "%");
				status.find('dd').find('p').find('i').text(temp_point);
				
				now_space_point = now_space_point-1;
				set_space_status(now_space_point);

				if(now_space_point == 0) {
					parent_box.find('a[data-function="plus"]').removeClass('point').addClass('disable');
				}
			} else {
				status.find('a[data-function="plus"]').removeClass('point').addClass('disable');
			}

			if(temp_point == max_point) {
				status.find('a[data-function="plus"]').removeClass('point').addClass('disable');
			}
		}
		status.find('a[data-function="minus"]').removeClass('disable').addClass('point');
	}
}


function fn_status_minus() {
	var obj = now_control_obj;

	if($(obj).hasClass('disable')) {
		// 사용불가

	} else {
		// 스텟 포인트 추가 이벤트
		var parent_box = $(obj).closest('.status-bar');
		var status = $(obj).closest('dl');

		var all_max_point = parent_box.attr('data-total');
		var now_space_point = parent_box.attr('data-space');

		var state_id = $(obj).attr('data-idx');


		var input_obj = $('#sc_max_' + state_id);
		var max_point = status.attr('data-max'); // 해당 스텟의 최대값
		var min_point = status.attr('data-min'); // 해당 스텟의 최소값
		var temp_point = (input_obj.val() * 1) - 1; // 감소치 계산
		
		if(temp_point >= min_point) {
			// 포인트 감소
			input_obj.val(temp_point);

			// 그래프 사이즈 조절
			var percent_value = (temp_point/max_point) * 100;
			status.find('dd').find('p').find('span').css('width', ((temp_point/max_point) * 100) + "%");
			status.find('dd').find('p').find('i').text(temp_point);
			
			now_space_point = (now_space_point * 1)+1;
			set_space_status(now_space_point);

			parent_box.find('dl').each(function(){
				var now_value = $(this).find('[name="sc_max[]"]').val() * 1;
				var max_value = $(this).attr('data-max') * 1;

				if( now_value < max_value ) 
					$(this).find('a[data-function="plus"]').removeClass('disable').addClass('point');
			});

			if(temp_point == min_point) {
				status.find('a[data-function="minus"]').removeClass('point').addClass('disable');
			}
		} else {
			status.find('a[data-function="minus"]').removeClass('point').addClass('disable');
		}

		if(temp_point == min_point) {
			status.find('a[data-function="minus"]').removeClass('point').addClass('disable');
		}

		status.find('a[data-function="plus"]').removeClass('disable').addClass('point');
	}
}

function set_space_status(space_point) {
	$('.status-bar').attr('data-space', space_point);
	$('[data-type="point_space"]').text(space_point);
}
</script>
<? } ?>

<? if($use_status_form && $status_modify) { ?>
	<hr class="padding" />
	<button type="submit" class="ui-btn point full">스탯 분배하기</button>
</form>

<? } ?>