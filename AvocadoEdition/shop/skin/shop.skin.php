<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가 
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/shop.css">', 0);
?>

<div id="shop_page">
	<div id="shop_npc">
		<img src="<?=G5_IMG_URL?>/shop/npc.png" />
	</div>

	<div id="item_info">
		<div id="default_talk"></div>
	</div>

	<div id="item_list_box">
		<div id="shop_cate" class="ajax-link">
			<ul>
			<? for($i = 0; $i < count($shop_cate); $i++) { ?>
				<li>
					<a href="?cate=<?=$shop_cate[$i]?>" class='ui-btn <?=$cate == $shop_cate[$i] ? 'point' : ''?>'><?=$shop_cate[$i]?></a>
				</li>
			<? } ?>
			</ul>
		</div>

		<div id="shop_item_list">
			<ul>
		<? for($i = 0; $i < count($shop_list); $i++) { 
			$shop = $shop_list[$i];
		?>
				<li>
					<a href="javascript:view_shop_item('<?=$shop['sh_id']?>');">
						<img src="<?=$shop['item']['it_img']?>" />
						<span><?=$shop['item']['it_name']?></span>
					</a>
				</li>
		<? } ?>
			</ul>

			<div id="shop_paging" class="ajax-link">
				<?=$write_pages?>
			</div>
		</div>
	</div>

</div>


<script>
function view_shop_item_complete() {
	// 아이템 상세 팝업 창 실행 종료 후 실행할 코드

};
function view_shop_item_buy() {
	// 아이템 구매 완료 후 실행할 코드

};
</script>
