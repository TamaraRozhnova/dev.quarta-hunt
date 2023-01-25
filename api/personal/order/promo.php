<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('sale');

$promo = $_REQUEST['PROMO'];
$act = $_REQUEST['ACT'];

if (!empty($promo)) {
	$arResult['promo'] = \Bitrix\Sale\DiscountCouponsManager::getData($promo);
	$discount = CSaleDiscount::GetByID($arResult['promo']['DISCOUNT_ID']); //(array(), array('ID' => $arResult['promo']['DISCOUNT_ID']));
	$arResult['discount'] = $discount;
	$arResult['discount']['CONDITIONS'] = unserialize(htmlspecialchars_decode($arResult['discount']['CONDITIONS']));
	unset($arResult['discount']['UNPACK']);
	unset($arResult['discount']['APPLICATION']);
	unset($arResult['discount']['ACTIONS']);
	$error = $arResult['promo']['ACTIVE'] === 'Y' ? false : true;
	$arResult['error'] = $error;
	$arResult['message'] = $error ? 'Купон не активен' : '';
	if (!$error && !empty($act)) {
		if ($act === 'APPLY') {
			\Bitrix\Sale\DiscountCouponsManager::init();
			\Bitrix\Sale\DiscountCouponsManager::clearApply(true);
			\Bitrix\Sale\DiscountCouponsManager::clear(true);
			\Bitrix\Sale\DiscountCouponsManager::add($promo);

			//\Bitrix\Sale\DiscountCouponsManager::saveApplied();

			/*
			$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
			$order = \Bitrix\Sale\Order::create(SITE_ID, $USER->GetID());
			$order->setPersonTypeId(1);
			$order->setBasket($basket);

			$discounts = $order->getDiscount();
			$discounts->setOrderRefresh(true);
			$discount->setApplyResult(array());
			$discounts->calculate();
			$basket->refreshData(["PRICE", "COUPONS"]);
			$order->doFinalAction(true);
			*/

			$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
			$basket->refreshData(array('PRICE', 'COUPONS'));
			$discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
			$discounts->calculate();
			$result = $discounts->getApplyResult(true);
			$prices = $result['PRICES']['BASKET'];

			$arResult['discount_prices'] = $prices;


			$arResult['message'] = 'Купон применен';
		} else if ($act === 'CLEAR') {
			\Bitrix\Sale\DiscountCouponsManager::init();
			\Bitrix\Sale\DiscountCouponsManager::clearApply(true);
			\Bitrix\Sale\DiscountCouponsManager::clear(true);
			$arResult['message'] = 'Купон отменен';
		} else {
			$arResult['error'] = true;
			$arResult['message'] = 'Невозможно применить купон';
		}
	}
} else {
	$arResult['error'] = true;
	$arResult['message'] = 'Не указан промокод';
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>