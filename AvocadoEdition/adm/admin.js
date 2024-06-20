function check_all(f)
{
	var chk = document.getElementsByName("chk[]");

	for (i=0; i<chk.length; i++)
		chk[i].checked = f.chkall.checked;
}

function btn_check(f, act)
{
	if (act == "update") // 선택수정
	{
		f.action = list_update_php;
		str = "수정";
	}
	else if (act == "delete") // 선택삭제
	{
		f.action = list_delete_php;
		str = "삭제";
	}
	else
		return;

	var chk = document.getElementsByName("chk[]");
	var bchk = false;

	for (i=0; i<chk.length; i++)
	{
		if (chk[i].checked)
			bchk = true;
	}

	if (!bchk)
	{
		alert(str + "할 자료를 하나 이상 선택하세요.");
		return;
	}

	if (act == "delete")
	{
		if (!confirm("선택한 자료를 정말 삭제 하시겠습니까?"))
			return;
	}

	f.submit();
}

function is_checked(elements_name)
{
	var checked = false;
	var chk = document.getElementsByName(elements_name);
	for (var i=0; i<chk.length; i++) {
		if (chk[i].checked) {
			checked = true;
		}
	}
	return checked;
}

function delete_confirm(el)
{
	if(confirm("한번 삭제한 자료는 복구할 방법이 없습니다.\n\n정말 삭제하시겠습니까?")) {
		var token = get_ajax_token();
		var href = el.href.replace(/&token=.+$/g, "");
		if(!token) {
			alert("토큰 정보가 올바르지 않습니다.");
			return false;
		}
		el.href = href+"&token="+token;
		return true;
	} else {
		return false;
	}
}

function delete_confirm2(msg)
{
	if(confirm(msg))
		return true;
	else
		return false;
}

function get_ajax_token()
{
	var token = "";

	$.ajax({
		type: "POST",
		url: g5_admin_url+"/ajax.token.php",
		cache: false,
		async: false,
		dataType: "json",
		success: function(data) {
			if(data.error) {
				alert(data.error);
				if(data.url)
					document.location.href = data.url;

				return false;
			}

			token = data.token;
		}
	});

	return token;
}

$(function() {
	$(document).on("click", "form input:submit", function() {
		var f = this.form;
		var token = get_ajax_token();

		if(!token) {
			alert("토큰 정보가 올바르지 않습니다.");
			return false;
		}

		var $f = $(f);

		if(typeof f.token === "undefined")
			$f.prepend('<input type="hidden" name="token" value="">');

		$f.find("input[name=token]").val(token);

		return true;
	});

	if($('.anchor').length > 0) {
		$('.anchor').hide();
		$('.anchor').addClass('auto-horiz');
		$('.anchor').eq(0).addClass('actived').show();
		$('.adminBody').addClass('has-amchor');
		
		$(document).scroll(function() {set_achor();});
		set_achor();
	}
});

function set_achor() {
	const $sections = $('section[id*="anc_"]');
	const $anchorList = $(".anchor");

	let current=""
	const scrollTop = $(window).scrollTop();
	const scrollLeft = $(window).scrollLeft();
	const w_height = $(window).height();

	$sections.each(function(index, item) {
		if($(item).is(':visible')) {
			const sectionTop = $(item).offset().top;
			const checkTop = sectionTop - (w_height / 3);
			if(scrollTop >= checkTop) {
				current = $(item).attr('id');
			}
		}
		
	});

	$anchorList.find('.on').removeClass('on');
	$anchorList.find('a[href="#'+current+'"]').addClass('on');

	$(".auto-horiz").css("transform", "translateX(-"+scrollLeft+"px)");
	$(".auto-horiz").css("-webkit-transform", "translateX(-"+scrollLeft+"px)");
}

/***************************************
	Repeat Item
***************************************/

function fn_add_repeatFrom(id, max_count) {
	const $repeat_pannel = $('#'+id);
	const $original_item = $repeat_pannel.find('.repeat-original');
	const originam_tag = $original_item[0].tagName.toLowerCase();
	const now_count = $repeat_pannel.find(originam_tag).not('.repeat-original').length;

	if(typeof(max_count) != "undefined" && max_count != 0 && now_count + 1 > max_count) {
		alert("최대 등록 가능한 갯수를 초과하였습니다.");
		return false;
	}
	let $add_item = $original_item.clone();
	$add_item.removeClass('repeat-original');
	$repeat_pannel.append($add_item);
}
function fn_del_itemFrom(obj) {
	const $repeat_pannel = $(obj).closest('.repeatFormArea');
	const $original_item = $repeat_pannel.find('.repeat-original');
	const originam_tag = $original_item[0].tagName.toLowerCase();

	$(obj).closest(originam_tag).remove();
}



/***************************************
	Layout Setting
***************************************/

$(function() {
	//$('.local_desc').prepend($('<span class="material-symbols-outlined">emergency</span>'));

	$('input[type="checkbox"]').each(function() {
		let $label = $(this).next('label');
		if($label.length > 0) {
			$(this).addClass('hidden');
		} else {
			$(this).addClass('show');
		}
	});

	$('.local_sch a').addClass('btn_link');

	
	$('.color-preview').each(function() {
		let $input = $(this).prev('input[type="text"]');
		let $color = $(this);
		let is_input = false;

		$color.on('change', function() {
			if(!is_input) {
				let _color = $(this).val();
				$input.val(_color);
			} else {
				is_input = false;
			}
		});

		$input.on('change', function() {
			is_input = true;
			let _color = $(this).val();
			$color.val(_color);
		});
	});


	if($('.btn_add').length > 0 && $('.btn_list').length) {
		$('.btn_add').addClass('btn_list');
	} else if($('.btn_add').length > 0) {
		$('.btn_add').addClass('btn_confirm');
	}

	if($('.btn_list').length > 0 && $('.btn_confirm').length > 0) {
		$('.btn_confirm').closest('section').addClass('writeFromArea');
		$('.container').addClass('writeFromAreaContainer');
	}
});


