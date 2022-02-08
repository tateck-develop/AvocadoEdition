// 레이아웃 셋팅 - 반응형
fn_layout_setting();

// 화면 사이즈가 변경 될 시, 레이아웃 셋팅 실행
window.onresize = function() { fn_layout_setting(); };

// 즐겨찾기 추가 - Ajax
$('a[data-function="favorite"]').on('click', function() {
	var formData = new FormData();
	var idx = $(this).data('idx');
	var obj = $(this);
	formData.append("wr_id", idx);
	formData.append("bo_table", g5_bo_table);
	formData.append("mb_id", avo_mb_id);

	$.ajax({
		url:avo_board_skin_url + '/ajax/add_favorite.php'
		, data: formData
		, processData: false
		, contentType: false
		, type: 'POST'
		, success: function(data){
			if(data == 'on') { 
				obj.removeClass('on');
				obj.addClass(data);
			}else if(data == 'off') { 
				obj.removeClass('on');
			}
		}
	});

	return false;
});


$('a.ui-open-log').on('click', function() {

	var obj = $(this).closest('.pic-data').children('div');
	var state = $(obj).hasClass('on');
	var original_height = $(obj).find('img').height();
	var setting_height = 470;

	if(state){ 
		//닫기
		$(obj).stop().animate({height: setting_height + "px"}, 1000);
		$(obj).removeClass('on');
		$(this).text("OPEN");
	} else {
		// 열기
		$(obj).stop().animate({height: original_height + "px"}, 1000);
		$(obj).addClass('on');
		$(this).text("CLOSE");
	}

	return false;
});

$('a.ui-remove-blind').on('click', function() {
	$(this).closest('.pic-data').removeClass('ui-blind');
	$(this).fadeOut();
	return false;
});

$('.send_memo').on('click', function() {
	var target = $(this).attr('href');
	window.open(target, 'memo', "width=500, height=300");
	return false;
});

$('.btn-search-guide').on('click', function() {
	$('#searc_keyword').toggleClass('on');
	return false;
});

$(window).ready(function() {
	$('#load_log_board').css('opacity', '1.0');
});

function fn_layout_setting() {
	$('#log_list > .item').each(function(){
		var log_data_width = $(this).find('.ui-pic').data('width');
		var log_width = $(this).find('.pic-data').find('img').width();
		
		if(log_data_width < log_width && log_width > 300) { 
			log_data_width = log_width;
		}

		var comment_width = $('#log_list .item-inner').width() - log_data_width + 10;
		if(comment_width > 320) {
			$(this).removeClass('both');
			$(this).find('.ui-comment').css('width', comment_width - 20 + "px");
		} else {
			$(this).addClass('both');
			$(this).find('.ui-comment').css('width', "auto");
		}
	});
};

$('.new_win').on('click', function() {
	var target = $(this).attr('href');
	window.open(target, 'emoticon', "width=400, height=600");
	return false;
});