<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_member) { 
?>
	<script>
		var call_event;
		$(function(){
			call_event = setInterval(function(){load_call_state()},3000);
		});

		function load_call_state () {
			$.ajax({
				type: 'get'
				, async: true
				, url: g5_url + "/ajax/load_board_call.php?mb_id=<?=$member['mb_id']?>"
				, success: function(data) {
					var response = data.trim();
					if(response) {
						$('body').append(response);
						$('.ui-call-alram-box').fadeIn(300, function() {
							$(this).addClass('on');
						});
						clearInterval(call_event);
					}
				}
			});
		}
		function close_call() {
			$.ajax({
				url:'<?=G5_URL?>/ajax/close_call.php'
				, success: function(data){
					$('.ui-call-alram-box').fadeOut(function() {
						$(this).remove();
					});
				}
			});
		}

		function move_call(url) {
			$.ajax({
				url:g5_url + '/ajax/close_call.php'
				, success: function(data){
					location.href = url;
				}
			});
		}
	</script>

<? } ?>