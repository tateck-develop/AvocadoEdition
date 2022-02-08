$(function() {
	$('img').attr('title', '');
	$('img[usemap]').rwdImageMaps();

	$('#header_control_box').on('click', function() {
		$('html').toggleClass('close-header');

		if($('html').hasClass('close-header')) { 
			// 닫힘상태
			// - 쿠키 설정
			set_cookie('header_close', 'close', 365, g5_cookie_domain);
		} else {
			// 열림상태
			// - 쿠키 제거
			delete_cookie('header_close');
		}
	});

});

window.onscroll = function() {
	var position = $(window).scrollTop();
	if (position > 50) {
		$('.uparrow').fadeIn();
	} else {
		$('.uparrow').fadeOut();
	}
	$('.scroll-fix').css('transform', "translatey(" + position + "px)");
}

$(document).on("keydown", "textarea", function(e) {
	if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
		$(this).parents('form').submit();
	}
});

if (document.all) {
	document.onkeydown = trapRefreshIE;
} else {
	document.captureEvents(Event.KEYDOWN)
	document.onkeydown = trapRefreshNS;
}

function trapRefreshNS(e){
	if (e.keyCode == 116){
		e.cancelBubble = true; 
		e.returnValue = false;
		document.location.reload();
	}
}

function trapRefreshIE(){
	if (event.keyCode == 116){
		event.keyCode = 0; 
		event.cancelBubble = true; 
		event.returnValue = false;
		document.location.reload();
	}
}

function ajax_link_url(url, obj_id) {
	var h_link = url;
	
	if(typeof(history.pushState) != "undefined") {
		$.ajax({
			async: true
			, url: h_link
			, beforeSend: function() {}
			, success: function(data) {
				// Toss
				var response = data;
				var temp_content = $(response).find(obj_id).clone();

				$(obj_id).fadeOut(300, function(){$(this).empty().append(temp_content.html());}).fadeIn(300, function() {
					
					$(obj_id).find('img').attr('title', '');
					$(obj_id).find('img[usemap]').rwdImageMaps();

					var link = url;
					var link_obj =  { Title: '', Url: link};
					history.pushState(link_obj, link_obj.Title, link_obj.Url);
				});
			}
			, error: function(data, status, err) {
				$(obj_id).fadeOut(300, function(){$(this).empty(); });
			}
			, complete: function() { 
				// Complete
			}
		});
	} else {
		location.href=url;
	}
}


function fn_save_title(val, ch_id) {
	var formData = new FormData();
	var ch_id = ch_id;
	var ti_id = val;
	formData.append("ch_id", ch_id);
	formData.append("ti_id", ti_id);

	$.ajax({
		url:g5_url+'/mypage/character/title_update.php'
		, data: formData
		, processData: false
		, contentType: false
		, type: 'POST'
		, success: function(data){
			
		}
	});
}

