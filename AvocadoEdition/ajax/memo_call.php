<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_member) { 
?>
	<script>
		var memo_call_event;
		$(function(){
			memo_call_event = setInterval(function(){load_memo_state()},5000);
		});

		function load_memo_state () {
			$.ajax({
				type: 'get'
				, async: true
				, url: g5_url + "/ajax/load_memo_call.php?mb_id=<?=$member['mb_id']?>"
				, success: function(data) {
					var response = data.trim();
					if(response) {
						$('body').append(response);
						$('.ui-memo-alram-box').fadeIn(300, function() {
							$(this).addClass('on');
						});
						clearInterval(memo_call_event);
					}
				}
			});
		}
		function close_memo() {
			$.ajax({
				url:'<?=G5_URL?>/ajax/close_memo.php'
				, success: function(data){
					$('.ui-memo-alram-box').fadeOut(function() {
						$(this).remove();
					});
				}
			});
		}
	</script>
<? } ?>