<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;

CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');

$arResult['error'] = false;
$arResult['message'] = '';

$current_user = $USER->GetByID($USER->GetID())->arResult[0];

if (!empty($_REQUEST['BONUS_POINTS']) && intval($_REQUEST['BONUS_POINTS']) > 0) {

	$uf_bonus_points = intval($current_user['UF_BONUS_POINTS']);
	$rq_bonus_points = intval($_REQUEST['BONUS_POINTS']);

	if ($uf_bonus_points >= $rq_bonus_points) {
		$basket_list = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);
		$basket_items = [];
		$price = 0;
		$items_count = 0;
		$b_sys = true;

		while ($basket_item = $basket_list->GetNext()) {
			$basket_items[] = $basket_item;
			$price = $price + $basket_item['PRICE'] * $basket_item['QUANTITY'];
			$items_count = $items_count + $basket_item['QUANTITY'];
			$notes = unserialize(htmlspecialchars_decode($basket_item['NOTES']));
			if ($basket_item['PRICE'] == 0 || $notes['ID'] != 0) {
				$b_sys = false;
				break;
			}
		}

		if ($b_sys) {

			$half_price = $price / 2;
			$half_price = round($half_price, 4);

			if ($items_count > 0) {
				$bonus_points = intval($_REQUEST['BONUS_POINTS']);
	
				if ($half_price > $bonus_points) {
					$dif = $bonus_points / $items_count;
					$dif = round($dif, 4);
					$all_price = 0;
	
					foreach ($basket_items as $basket_item) {
						$new_dif = $dif;
						$new_price = $basket_item['PRICE'] - $new_dif;
						$sum_price = $basket_item['QUANTITY'] * $new_price;
						$all_price += $sum_price;
	
						if ($new_price > 0) {
							$USER->Update($USER->GetID(), ['UF_BONUS_POINTS' => $uf_bonus_points - $rq_bonus_points]);

							$result = CSaleBasket::Update($basket_item['ID'], ['PRICE' => $new_price, 'CUSTOM_PRICE' => 'Y']);
						} else {
							$new_dif = 0;
							$result = false;
						}
	
						$arResult['ITEMS'][] = [
							'ID' => $basket_item['ID'],
							'PRODUCT_ID' => $basket_item['PRODUCT_ID'],
							'RESULT' => $result,
							'DISCOUNT' => $new_dif,
							'SUM_PRICE' => $sum_price,
							'PRICE' => $new_price,
							'QUANTITY' => $basket_item['QUANTITY'],
							'OLD_PRICE' => $basket_item['PRICE'],
						];
					}

					$arResult['ITEMS_COUNT'] = $items_count;
					$arResult['OLD_PRICE'] = $price;
					$arResult['PRICE'] = $all_price;
					$arResult['DISCOUNT'] = $bonus_points;
	
				} else {
					$arResult['error'] = true;
					$arResult['message'] = 'Бонусными баллами можно оплатить не более половины суммы заказа';
				}
	
			} else {
				$arResult['error'] = true;
				$arResult['message'] = 'Ваша корзина пустая';
			}
		} else {
			$arResult['error'] = true;
			$arResult['message'] = 'Бонусы нельзя применять для акций';
		}
	} else {
		$arResult['error'] = true;
		$arResult['message'] = 'Не достаточно бонусных баллов';
	}

} else if (!empty($_REQUEST['ACT']) && !empty($_REQUEST['ACT']) == 'RESET') {

	$basket_list = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);
	$basket_items_ids = [];
	$all_price = 0;
	$items_count = 0;
	$price = 0;

	while ($basket_item = $basket_list->GetNext()) {
		$el = CIBlockElement::GetList([], ['ID' => $basket_item['PRODUCT_ID']], false, false, ['ID', 'NAME', 'CODE', 'PRICE_1']);
		$item = $el->GetNext();

		$price += $basket_item['PRICE'] * $basket_item['QUANTITY'];

		$result = CSaleBasket::Update($basket_item['ID'], [
			'PRICE' => $item['PRICE_1'],
		]);

		$sum_price = $basket_item['QUANTITY'] * $item['PRICE_1'];
		$all_price += $sum_price;
		$items_count++;

		$arResult['ITEMS'][] = [
			'ID' => $basket_item['ID'],
			'PRODUCT_ID' => $basket_item['PRODUCT_ID'],
			'RESULT' => $result,
			'DISCOUNT' => 0,
			'SUM_PRICE' => $sum_price,
			'PRICE' => $item['PRICE_1'],
			'QUANTITY' => $basket_item['QUANTITY'],
			'OLD_PRICE' => $basket_item['PRICE'],
		];

	}

	$uf_bonus_points = intval($current_user['UF_BONUS_POINTS']);
	$USER->Update($USER->GetID(), ['UF_BONUS_POINTS' => $uf_bonus_points + $all_price - $price]);

	$arResult['error'] = false;
	$arResult['message'] = '';
	$arResult['ITEMS_COUNT'] = $items_count;
	$arResult['OLD_PRICE'] = 0;
	$arResult['PRICE'] = $all_price;
	$arResult['DISCOUNT'] = 0;


} else {

	$arResult['error'] = true;
	$arResult['message'] = 'Неверное значение бонусных баллов';

}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>