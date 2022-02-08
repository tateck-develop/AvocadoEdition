<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="inven-popup-viewer default-form" id="inven_popup_viewer">
	<div class="inner-content"></div>
</div>
<div class="inven_popup_viewer_close">
	<a href="#" class="btn-inven-popup-close">CLOSE</a>
</div>

<script>
var request_url = "<?=urlencode($_SERVER['REQUEST_URI'])?>";

$('.inven-open-popup').on('click', function() {
	var idx = $(this).data('idx');
	var type = $(this).data('type');
	fn_inven_link_event(idx, type);
	return false;
});

$('.btn-inven-popup-close').on('click', function() {
	$('#inven_popup_viewer').fadeOut();
	$('#inven_popup_viewer .inner-content').empty();
	$('body').removeClass('inven-popup-on');
	return false;
});

function fn_inven_link_event(idx, type) {
	var formData = new FormData();
	formData.append("in_id", idx);
	formData.append("url", request_url);

	if(type == 'sell') { 
		// 아이템 판매
		$.ajax({
			url:g5_url + '/inventory/sell_item.php'
			, data: formData
			, processData: false
			, contentType: false
			, type: 'POST'
			, success: function(data){
				if(data) {
					var arr = data.split("||||");
					if(arr[0] == 'LOCATIONURL') {
						location.href = arr[1];
					} else {
						$('#inven_popup_viewer .inner-content').html(data);
						$('#inven_popup_viewer').fadeIn();
						$('body').addClass('inven-popup-on');
					}
				}
			}
		});
	} else if(type == 'use') { 
		// 아이템 사용
		$.ajax({
			url:g5_url + '/inventory/use_item.php'
			, data: formData
			, processData: false
			, contentType: false
			, type: 'POST'
			, success: function(data){
				if(data) {
					var arr = data.split("||||");
					if(arr[0] == 'LOCATIONURL') {
						location.href = arr[1];
					} else {
						$('#inven_popup_viewer .inner-content').html(data);
						$('#inven_popup_viewer').fadeIn();
						$('body').addClass('inven-popup-on');
					}
				}
			}
		});
	} else if(type == 'take') { 
		// 아이템 선물
		$.ajax({
			url:g5_url + '/inventory/send_item.php'
			, data: formData
			, processData: false
			, contentType: false
			, type: 'POST'
			, success: function(data){
				if(data) { 
					$('#inven_popup_viewer .inner-content').html(data);
					$('#inven_popup_viewer').fadeIn();
					$('body').addClass('inven-popup-on');
				}
			}
		});
	} else {
		$.ajax({
			url:g5_url + '/inventory/detail_item.php'
			, data: formData
			, processData: false
			, contentType: false
			, type: 'POST'
			, success: function(data){
				if(data) { 
					$('#inven_popup_viewer .inner-content').html(data);
					$('#inven_popup_viewer').fadeIn();
					$('body').addClass('inven-popup-on');
				}
			}
		});
	}

	//return false;
}
</script>