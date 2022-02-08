<?php
include_once('./_common.php');
$g5['title'] = "상점";
include_once('./_head.php');

// 상점 카테고리 정보
$shop_cate = explode("||", $config['cf_shop_category']);

if(!$cate) {
	$cate = $shop_cate[0];
}

$sql_common = " from {$g5['shop_table']} ";
$sql_search = " where sh_use = '1' and ca_name = '{$cate}' ";
$sql_order = " order by sh_order asc ";
$sql_limit = "";

// --- 진열 기간 사용 시
// 1. 날짜
$sql_search .= " AND (sh_date_s <= '".date('Ymd')."' OR sh_date_s = '') "; 
$sql_search .= " AND (sh_date_e >= '".date('Ymd')."' OR sh_date_e = '') "; 

// 2. 시간
$sql_search .= " AND (sh_time_s <= '".DATE('H')."' OR sh_time_s = '') ";
$sql_search .= " AND (sh_time_e >= '".DATE('H')."' OR sh_time_e = '') ";

// 3. 요일
$sql_search .= " AND (sh_week LIKE '%||".DATE('w')."||%' OR sh_week = '') ";

// -- 구매 제한 사용 시
// -- (구매갯수 / 재고 설정은 리스트 출력 시 계산한다.)
// 1. 세력 제한
$sql_search .= " AND ((sh_side LIKE '%||".$character['ch_side']."||%' AND sh_use_side = '1') OR sh_use_side = '0') ";

// 2. 종족 제한
$sql_search .= " AND ((sh_class LIKE '%||".$character['ch_class']."||%' AND sh_use_class = '1') OR sh_use_class = '0') ";


// ---  페이징 처리

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$page_rows = 10;
$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

$sql_limit = " limit {$from_record}, {$page_rows} ";
$write_pages = get_paging(5, $page, $total_page, './index.php?cate='.$cate.$qstr.'&amp;page=');


$shop_sql = " select * {$sql_common} {$sql_search} {$sql_order} {$sql_limit} ";
$shop_result = sql_query($shop_sql);
$shop_list = array();

for($i = 0; $shop = sql_fetch_array($shop_result); $i++) { 
	$shop_list[$i] = $shop;
	$shop_list[$i]['item'] = get_item($shop['it_id']);
}


if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH."/shop/shop.skin.php")) {
	include(G5_THEME_PATH."/shop/shop.skin.php");
} else {
	include(G5_PATH."/shop/skin/shop.skin.php");
}
?>

<script>
function view_shop_item(shop_idx) {
	var h_link = "./_ajax.shop_item.php?sh_id=" + shop_idx;
	$.ajax({
		async: true
		, url: h_link
		, beforeSend: function() {}
		, success: function(data) {
			// Toss
			var response = data;
			$('#item_info').empty().append(response);
			view_shop_item_complete();
		}
		, error: function(data, status, err) {
			$('#item_info').empty();
		}
		, complete: function() { 
			// Complete
		}
	});
}

function fn_buy_item(shop_idx){
	var h_link = "./_ajax.shop_update.php?sh_id=" + shop_idx;
	$.ajax({
		async: true
		, url: h_link
		, beforeSend: function() {}
		, success: function(data) {
			// Toss
			var response = data;
			$('#item_info').empty().append(response);
			view_shop_item_buy();
		}
		, error: function(data, status, err) {
			$('#item_info').empty();
		}
		, complete: function() { 
			// Complete
		}
	});
}

$('.ajax-link a').on('click', function() {
	$(this).addClass('point').parent().siblings().find('a').removeClass('point');
	ajax_shop_link_url($(this).attr('href'), '#shop_item_list');

	return false;
});

function ajax_shop_link_url(url, obj_id) {
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
					var link = url;
					var link_obj =  { Title: '', Url: link};
					history.pushState(link_obj, link_obj.Title, link_obj.Url);

					$(obj_id).find('.ajax-link').find('a').on('click', function() {
						$(this).parents('li').addClass('on').siblings().removeClass('on');
						ajax_shop_link_url($(this).attr('href'), '#shop_item_list');
						return false;
					});
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
</script>

<?
include_once('./_tail.php');
?>

