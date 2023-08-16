<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;

CModule::IncludeModule('iblock');
CModule::IncludeModule('sale');

$arResult['error'] = false;
$arResult['message'] = '';

$current_user = $USER->GetByID($USER->GetID())->arResult[0];

if (!empty($_REQUEST['ACT']) && !empty($_REQUEST['ACT']) == 'RESET') {

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