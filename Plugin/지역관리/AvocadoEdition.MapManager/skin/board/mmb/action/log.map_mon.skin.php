<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
// 1 : 몬스터 상태, 2: 몬스터 공격력. 3: 유저공격력, 4:캐릭터 HP, 5: 다이스1/다이스2/아이템
$data_detail = explode("+", $data_log[5]);

$monster_comment = "";
$monster_comment_detail = "";

if($data_log[1] != "E") { 
	// 이벤트가 진행 중인 경우

	$monster_comment = "대상을 공격합니다!";

	if($data_log[2] < $data_log[3]) { 
		$monster_comment_detail = "공격 성공! ".($data_log[3] - $data_log[2])."의 피해를 입혔습니다.";
	} else if($data_log[2] > $data_log[3]) {
		// 몬스터의 데미지가 더 높은 경우, 유저의 hp를 제거한다. 단, 플러그인에선 hp에 대한 코드는 제외되어있다.
		// 유저의 HP 를 사용할 경우 아래의 코드를 사용한다.
		// $monster_comment_detail = "공격 실패! ".($data_log[2] - $data_log[3])."의 피해를 입었습니다.";
		$monster_comment_detail = "공격 실패!";
	} else {
		// 비겼을 경우
		$monster_comment_detail = "공격 실패!";
	}
	
} else {
	$monster_comment = "대상을 처치하는데 성공하였습니다!";
	$monster_comment_detail = "공격 성공! ".($data_log[3] - $data_log[2])."의 피해를 입혔습니다.";
}

?>

<div class="log-data-box">
	<p><?=$monster_comment?></p>
	<? 
		if($data_log[5]) {
			// 다이스 정보 추출
			// 해당 부분은 커뮤니티 내의 공격력 산출 공식에 따라 커스텀 한다.
			$dice_result = explode("+", $data_log[5]);
	?>
		<p>
			<img src="<?=$board_skin_url?>/img/d<?=$dice_result[0]?>.png" alt="DICE1" />
			<?=number_format($dice_result[0])?>
			+
			<img src="<?=$board_skin_url?>/img/d<?=$dice_result[1]?>.png" alt="DICE2" />
			<?=number_format($dice_result[1])?>
			<? if($dice_result[2]) { 
				// 아이템을 사용했을 경우
			?>
			+ <?=number_format($dice_result[2])?>
			<? } ?>
		</p>
	<? } ?>
	<p><?=$monster_comment_detail?></p>
</div>

