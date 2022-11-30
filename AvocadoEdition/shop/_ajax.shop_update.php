<?
include_once("./_common.php");

if($character['ch_id'] && $character['ch_state'] == '승인') { 

	$msg = "";
	$item = sql_fetch("select * from {$g5['shop_table']} shop, {$g5['item_table']} item where shop.it_id = item.it_id and shop.sh_id = '{$sh_id}'");

	if($item['sh_id']) {
		// 구매 가능한 아이템인지 체크한다.
		// -- 체크 항목 : 각 구매 가격 및 교환 아이템/타이틀
		// -- 구매 갯수 및 재고, 세력, 진영 제한 체크

		//------------------
		// 구매가격 체크
		//------------------

		$use_point = 0;
		$use_exp_point = 0;
		$use_inventory_item = 0;
		$use_has_title = 0;

		$is_able_buy = true;

		if($item['sh_money']) {
			// 구매가격이 존재 시
			if($member['mb_point'] < $item['sh_money']) {
				// 소지금 부족
				$msg .= $config['cf_money']." 부족합니다.<br />";
				$is_able_buy = false;

			} else if($item['sh_use_money']) {
				// 소지금 소모
				$use_point += $item['sh_money'];
			}
		}

		if($item['sh_exp']) {
			// 구매 경험치 존재 시
			if($character['ch_exp'] < $item['sh_exp']) {
				// 경험치 부족
				$msg .= $config['cf_exp_name']." 부족합니다.<br />";
				$is_able_buy = false;

			} else if($item['sh_use_exp']) {
				// 경험치 소모
				$use_exp_point += $item['sh_exp'];
			}
		}

		if($item['sh_has_item']) {
			// 구매 아이템 존재 시
			$item['sh_has_item_count'] = $item['sh_has_item_count'] == 0 ? 1 : $item['sh_has_item_count'];
			$in = sql_fetch("select count(in_id) as cnt, in_id from {$g5['inventory_table']} where ch_id = '{$character['ch_id']}' and it_id = '{$item['sh_has_item']}'");

			if($in['cnt'] < $item['sh_has_item_count']) {
				// 필요 아이템 미소유
				$has_item_name = get_item_name($item['sh_has_item']);
				$msg .= $has_item_name.j($has_item_name, '이')." ".$item['sh_has_item_count']."개 있어야 살 수 있습니다.<br />";
				$is_able_buy = false;
			} else if($item['sh_use_has_item']) {
				// 아이템 소모
				$use_inventory_item = $item['sh_has_item'];
				$use_inventory_item_count = $item['sh_has_item_count'];
			}
		}

		if($item['sh_has_title']) {
			// 구매 타이틀 존재 시
			$ti = sql_fetch("select hi_id from {$g5['title_has_table']} where ch_id = '{$character['ch_id']}' and ti_id = '{$item['sh_has_title']}'");
			if(!$ti['hi_id']) {
				// 필요 타이틀 미소유
				$has_title = get_title($item['sh_has_item']);
				$msg .= $has_title['ti_title'].j($has_title['ti_title'], '이')." 있어야 살 수 있습니다.<br />";
				$is_able_buy = false;
			} else if($item['sh_use_has_title']) {
				// 타이틀 소모
				$use_has_title = $ti['hi_id'];
			}
		}

		//-------------------------------------------------
		// 구매 가능 여부 체크
		//-------------------------------------------------

		if($item['sh_limit']) {
			// 구매 갯수 제한이 존재 시
			// 구매 내역 정보를 가져온다
			$order = sql_fetch("select count(*) as cnt from {$g5['order_table']} where ch_id = '{$character['ch_id']}' and it_id = '{$item['it_id']}'");
			if($order['cnt'] >= $item['sh_limit']) {
				$msg .= "너무 많이 구매했습니다. 더이상 구매할 수 없습니다.<br />";
				$is_able_buy = false;
			}
		}

		if($item['sh_qty']) {
			// 재고가 존재시
			// 구매 내역 정보를 가져온다
			$order = sql_fetch("select count(*) as cnt from {$g5['order_table']} where it_id = '{$item['it_id']}'");
			if($order['cnt'] >= $item['sh_qty']) {
				$msg .= "재고가 모두 소진되었습니다. 더이상 구매할 수 없습니다.<br />";
				$is_able_buy = false;
			}
		}

		if($item['sh_class']) {
			// 종족 구매 제한이 존재시
			if(!strstr($item['sh_class'], '||'.$character['ch_class'].'||')) {
				$msg .= "구매할 수 없는 ".$config['cf_class_title']."입니다.<br />";
				$is_able_buy = false;
			}
		}
		if($item['sh_side']) {
			// 세력 구매 제한이 존재시
			if(!strstr($item['sh_side'], '||'.$character['ch_side'].'||')) {
				$msg .= "구매할 수 없는 ".$config['cf_side_title']."입니다.<br />";
				$is_able_buy = false;
			}
		}

		if($is_able_buy) {

			// 구매 성공 시 아이템 인벤토리에 추가
			// 인벤에 집어넣기
			$inven_sql = " insert into {$g5['inventory_table']}
							set ch_id = '{$character['ch_id']}',
								it_id = '{$item['it_id']}',
								it_name = '{$item['it_name']}',
								ch_name = '{$character['ch_name']}'";
			sql_query($inven_sql);

			// 구매내역 기록
			$inven_sql = " insert into {$g5['order_table']}
							set ch_id = '{$character['ch_id']}',
								it_id = '{$item['it_id']}',
								or_datetime = '".G5_TIME_YMDHIS."',
								mb_id = '{$member['mb_id']}'";
			sql_query($inven_sql);

			if($use_point) {
				// 소지금 차감
				$insert_point = $use_point * -1;
				insert_point($member['mb_id'], $insert_point, $item['it_name'].' 구매 ( '.$use_point.$config['cf_money_pice'].' 소모 )', 'shop', time(), '구매');
			}
			if($use_exp_point) {
				// 경험치 차감
				$action = '차감';
				$ex_content = $item['it_name'].' 구매 ( '.$use_exp_point.$config['cf_exp_pice'].' 소모 )';
				$ex_point = $use_exp_point * -1;
				insert_exp($character['ch_id'], $ex_point, $ex_content, $action);
			}

			if($use_inventory_item) {
				// 아이템 제거
				$item_result = sql_query("select in_id from {$g5['inventory_table']} where ch_id = '{$character['ch_id']}' and it_id = '{$use_inventory_item}' order by se_ch_name asc, in_id asc limit 0, {$use_inventory_item_count}");
				for($k = 0; $in = sql_fetch_array($item_result); $k++) { 
					// 인벤에서 제거
					delete_inventory($in['in_id'], 0);
				}
			}

			if($use_has_title) {
				// 타이틀 제거
				sql_query("delete from {$g5['title_has_table']} where hi_id = '{$use_has_title}'");
			}

			$msg = "《 ".$item['it_name']." 》 구매 되었습니다.";
		}
	}
} else {
	$msg = "<p style='color:red; padding-top:5px;'>부정사용 적발 시, 접근 차단이 될 수 있습니다.</p>";
}

if(defined('G5_THEME_PATH') && is_file(G5_THEME_PATH."/shop/shop.result.skin.php")) {
	include(G5_THEME_PATH."/shop/shop.result.skin.php");
} else {
	include(G5_PATH."/shop/skin/shop.result.skin.php");
}

?>
