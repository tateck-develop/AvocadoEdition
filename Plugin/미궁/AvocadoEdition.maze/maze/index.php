<?php
include_once('./_common.php');

if($member['mb_maze']) { 
	// 이전에 미궁을 진입한 기록이 있다면
	// 이전 미궁 정보를 가져 온다.
	$ma_id = $member['mb_maze'];
	$ma = sql_fetch("select * from {$g5['maze_table']} where ma_id = '{$ma_id}'");
} else {
	// 첫번재 미궁 IDX 정보를 가져온다
	// 멤버 정보 업데이트
	$ma = sql_fetch("select * from {$g5['maze_table']} order by ma_order asc limit 0, 1");
	$ma_id = $ma['ma_id'];
	sql_query("
		update {$g5['member_table']}
				set		mb_maze = '{$ma_id}'
			where		mb_id = '{$member['mb_id']}'
	");
}


// 다음 페이지가 있는지 체크
// 다음 페이지가 없다면, 랭킹 순위 입력
$naxe_ma = sql_fetch("select ma_id from {$g5['maze_table']} where ma_order >= '{$ma['ma_order']}' and ma_id != '{$ma_id}' order by ma_order asc, ma_id asc limit 0, 1");
$naxe_ma = $naxe_ma['ma_id'];
if(!$naxe_ma) { 
	// 클리어 타임 기록
	sql_query("
		update {$g5['member_table']}
				set		mb_maze_datetime = '".date('Y-m-d H:i:s')."'
			where		mb_id = '{$member['mb_id']}'
	");
}



$g5['title'] = "미궁 ".$ma['ma_subject'];
include_once('./_head.sub.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/style.maze.css">', 0);

if($ma['ma_background']) { 
	add_stylesheet("<style>html { background: url('{$ma['ma_background']}') no-repeat 50% 50% #000 !important; background-size: contain; }</style>", 10);
}
?>

<div id="maze_page">
	<div class="maze-content">
		<?=conv_content($ma['ma_content'], 1, 0);?>
		<script>
			$('.maze-content img').attr('title', '');
			$('html, body').animate({scrollTop: 0 }, '100');
		</script>
	</div>
	<div class="maze-answer">

	<? if($ma['ma_answer']) { ?>
		<fieldset class="input">
			<input type="text" name="answer" id="answer" value="" />
			<button type="button" onclick="fn_maze_check();">정답제출</button>
		</fieldset>
		<p class="error"></p>
		<script>
			$('#answer').on('keypress', function(event) { 
				if(event.keyCode==13) {
					fn_maze_check(); 
					return false;
				}
			});

			function fn_maze_check() {
				var formData = new FormData();
				var answer = $('#answer').val();
				formData.append("answer", answer);

				$.ajax({
					url:g5_url+'/maze/check_answer.php'
					, data: formData
					, processData: false
					, contentType: false
					, type: 'POST'
					, success: function(data){

						if(data == 'Y') { 
							location.reload(true);
						} else {
							$('.maze-answer > .error').text(data);
						}
					}
				});
			};
		</script>
	<? } ?>

	<? if($ma['ma_btn_prev']) { ?>
		<a href="javascript:fn_move_maze('prev');">
			<img src="<?=$ma['ma_btn_prev']?>" alt="이전페이지" />
		</a>
	<? } ?>
	<? if($ma['ma_btn_next']) { ?>
		<a href="javascript:fn_move_maze('next');">
			<img src="<?=$ma['ma_btn_next']?>" alt="이전페이지" />
		</a>
	<? } ?>
	<? if($ma['ma_btn_prev'] || $ma['ma_btn_next']) { ?>
		<script>
			function fn_move_maze(dir) {
				var formData = new FormData();
				var dir = dir;
				formData.append("dir", dir);

				$.ajax({
					url:g5_url+'/maze/check_move.php'
					, data: formData
					, processData: false
					, contentType: false
					, type: 'POST'
					, success: function(data){
						if(data == 'Y') { 
							location.reload(true);
						} else {
							$('.maze-answer > .error').text(data);
						}
					}
				});

			};
		</script>
	<? } ?>
	</div>
</div>




<?php
include_once('./_tail.sub.php');
?>

