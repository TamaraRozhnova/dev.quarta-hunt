<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?


//$APPLICATION->IncludeComponent("bitrix:sale.order.payment.receive", "", Array('PAY_SYSTEM_ID_NEW' => '4'));

CModule::IncludeModule("sale");


if (!empty($_REQUEST['MNT_ID']) && !empty($_REQUEST['MNT_TRANSACTION_ID']) && !empty($_REQUEST['MNT_OPERATION_ID'])) {
	$order_id = explode('_', $_REQUEST['MNT_TRANSACTION_ID']);

	if (is_array($order_id) && !empty($order_id[0])) {
		$order_id = $order_id[0];
		//$id = CSaleOrder::StatusOrder($order_id, 'P');
		$id = CSaleOrder::PayOrder($order_id, 'Y');

		$arResult['error'] = !$id;
		$arResult['message'] = $id !== 0 ? 'Заказ оплачен' : 'Ошибка смены статуса заказа';
		$arResult['id'] = $id;
	} else {
		$arResult['error'] = true;
		$arResult['message'] = 'Неверный номер заказа';
	}
} else {
	$arResult['error'] = true;
	$arResult['message'] = 'Неверные параметры';
}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


/*
CModule::IncludeModule("sale");

$dbPaySysAction = CSalePaySystemAction::GetList(
    array(),
    array('ID' => 4),
    false,
    false,
    array("ACTION_FILE", "PARAMS", "ENCODING")
);

$arPaySysAction = $dbPaySysAction->Fetch();

$arResult['paysysaction'] = $arPaySysAction;
*/

/*
$arResult['error'] = false;
$arResult['message'] = '';


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();
*/

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>