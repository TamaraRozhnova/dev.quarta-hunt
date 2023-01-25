<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule("sale");

global $USER;

$group = $USER->GetUserGroup($USER->GetID());
$opt = in_array('9', $group);
$product = null;
$gift_product = null;

if (!$opt) {
	$bl = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);
	while ($bi = $bl->GetNext()) {
		if ($bi['ID'] === $_REQUEST['CART_ITEM_ID']) $product = $bi;
	}
	if ($product !== null) {
		$gift = DiscountsHelper::getGiftIds($product['PRODUCT_ID']);
		if (!empty($gift)) {
			$bl = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);
			while ($bi = $bl->GetNext()) {
				if (intval($bi['PRODUCT_ID']) === $gift[0]) $gift_product = $bi;
			}
		}
		$notes = unserialize($product['~NOTES']);
		if ($notes['ID'] !== '0') {
			$bl = CSaleBasket::GetList(['NAME' => 'ASC', 'ID' => 'ASC'], ['FUSER_ID' => CSaleBasket::GetBasketUserID(), 'LID' => SITE_ID, 'ORDER_ID' => 'NULL']);
			while ($bi = $bl->GetNext()) {
				$bi_notes = unserialize($bi['~NOTES']);
				if ($notes['ID'] === $bi_notes['ID']) $kit[] = $bi;
			}
		}
	}
}


if ($base_id = CSaleBasket::Delete($_REQUEST['CART_ITEM_ID'])) {
	if (!$opt && $base_id !== false) {
		if (!empty($gift)) {
			if ($gift_product !== null) {
				$gift_id = CSaleBasket::Delete($gift_product['ID']);
				$arResult['gift_id'] = $gift[0];
				$arResult['gift_element_id'] = $gift_id;
			} else {
				$arResult['gift_id'] = 0;
				$arResult['gift_element_id'] = 0;
			}
		}
		if (!empty($kit)) {
			foreach ($kit as $ind => $k) {
				$arResult['kit']['result'][$ind] = CSaleBasket::Delete($k['ID']);
				$arResult['kit']['id'][$ind] = $k['PRODUCT_ID'];
				$arResult['kit']['element_id'][$ind] = $k['ID'];
			}
		}
	}
	$arResult['error'] = false;
	$arResult['message'] = 'Товар удален из корзины';
/*
	$arResult['product'] = $product;
	$arResult['notes'] = $notes;
	$arResult['opt'] = $opt;
	$arResult['base_id'] = $base_id;
	$arResult['gift'] = $gift;
	$arResult['gift_product'] = $gift_product;
*/
} else {
	$arResult['error'] = true;
	$arResult['message'] = 'Ошибка удаления товара из корзины';
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>