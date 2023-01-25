<?php
define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('DisableEventsCheck', true);
define('BX_SECURITY_SHOW_MESSAGE', true);
define('NOT_CHECK_PERMISSIONS', true);

$siteId = isset($_REQUEST['SITE_ID']) && is_string($_REQUEST['SITE_ID']) ? $_REQUEST['SITE_ID'] : '';
$siteId = mb_substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if (!empty($siteId) && is_string($siteId))
{
	define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER["DOCUMENT_ROOT"]."/local/templates/quarta/header.php");

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

if (!Bitrix\Main\Loader::includeModule('sale'))
	return;

Bitrix\Main\Localization\Loc::loadMessages(dirname(__FILE__).'/class.php');

/*
$signer = new \Bitrix\Main\Security\Sign\Signer;
try
{
	$signedParamsString = $request->get('signedParamsString') ?: '';
	$params = $signer->unsign($signedParamsString, 'sale.order.ajax');
	$params = unserialize(base64_decode($params), ['allowed_classes' => false]);
}
catch (\Bitrix\Main\Security\Sign\BadSignatureException $e)
{
	die();
}

$params = ['ACTION_VARIABLE' => 'action'];

$action = $request->get($params['ACTION_VARIABLE']);
if (empty($action))
	return;
*/


/*
$params = ['ACTION_VARIABLE' => 'action'];
$action = 'saveOrderAjax';

global $APPLICATION;

$APPLICATION->IncludeComponent(
	'bitrix:sale.order.ajax',
	'make_order',
	$params
);
*/



function getPropertyByCode($propertyCollection, $code) 
{
	foreach ($propertyCollection as $property) {
		if ($property->getField('CODE') == $code) {
			return $property;
		}
	}
	return null;
}

function setPropertyValue($propertyCollection, $code, $value) {
	foreach ($propertyCollection as $property) {
		if ($property->getField('CODE') == $code) {
			$property->setValue($value);
			return true;
		}
	}
	return false;
}


CModule::IncludeModule('ipol.sdek');

$arResult['error'] = true;
$arResult['message'] = '';

if ($USER && $USER->isAuthorized()) {

	// user
	$user_groups = explode(',', $USER->GetUserGroupString());
	$user_type = in_array(9, $user_groups);

	// order data
	$data['PERSON_TYPE_ID'] = $user_type ? 2 : 1;
	$data['DELIVERY_ID'] = !empty($_REQUEST['DELIVERY_ID']) ? $_REQUEST['DELIVERY_ID'] : '1';
	$data['PAY_SYSTEM_ID'] = !empty($_REQUEST['PAY_SYSTEM_ID']) ? $_REQUEST['PAY_SYSTEM_ID'] : '1';


	if ($data['PERSON_TYPE_ID'] === 1) {

		$data['FIO'] = !empty($_REQUEST['ORDER_PROP_1']) ? $_REQUEST['ORDER_PROP_1'] : $USER->GetParam('EMAIL');
		$data['EMAIL'] = !empty($_REQUEST['ORDER_PROP_2']) ? $_REQUEST['ORDER_PROP_2'] : $USER->GetParam('EMAIL');
		$data['PHONE'] = !empty($_REQUEST['ORDER_PROP_3']) ? $_REQUEST['ORDER_PROP_3'] : $USER->GetParam('PERSONAL_PHONE');
		$data['CITY'] = !empty($_REQUEST['ORDER_PROP_5']) ? $_REQUEST['ORDER_PROP_5'] : 'Санкт-Петербург';
		$data['ADDRESS'] = !empty($_REQUEST['ORDER_PROP_7']) ? $_REQUEST['ORDER_PROP_7'] : 'Московский проспект, д.222А';

		$data['BANK_INN'] = $_REQUEST['BANK_INN'];
		$data['BANK_KPP'] = $_REQUEST['BANK_KPP'];
		$data['BANK_ORGN'] = $_REQUEST['BANK_ORGN'];
		$data['BANK_PAYMENT_ACCOUNT'] = $_REQUEST['BANK_PAYMENT_ACCOUNT'];
		$data['BANK_NAME'] = $_REQUEST['BANK_NAME'];
		$data['BANK_BIK'] = $_REQUEST['BANK_BIK'];
		$data['BANK_CORRESCPONDENT_ACCOUNT'] = $_REQUEST['BANK_CORRESCPONDENT_ACCOUNT'];
		$data['BANK_PHONE'] = $_REQUEST['BANK_PHONE'];
		$data['BANK_CEO'] = $_REQUEST['BANK_CEO'];

	} else if ($data['PERSON_TYPE_ID'] === 2) {

		$data['FIO'] = !empty($_REQUEST['ORDER_PROP_12']) ? $_REQUEST['ORDER_PROP_12'] : $USER->GetParam('EMAIL');
		$data['EMAIL'] = !empty($_REQUEST['ORDER_PROP_13']) ? $_REQUEST['ORDER_PROP_13'] : $USER->GetParam('EMAIL');
		$data['PHONE'] = !empty($_REQUEST['ORDER_PROP_14']) ? $_REQUEST['ORDER_PROP_14'] : $USER->GetParam('PERSONAL_PHONE');
		$data['CITY'] = !empty($_REQUEST['ORDER_PROP_17']) ? $_REQUEST['ORDER_PROP_17'] : 'Санкт-Петербург';
		$data['ADDRESS'] = !empty($_REQUEST['ORDER_PROP_19']) ? $_REQUEST['ORDER_PROP_19'] : 'Московский проспект, д.222А';
		$data['COMPANY'] = !empty($_REQUEST['ORDER_PROP_8']) ? $_REQUEST['ORDER_PROP_8'] : $USER->GetParam('WORK_COMPANY');

		$data['BANK_INN'] = $_REQUEST['BANK_INN'];
		$data['BANK_KPP'] = $_REQUEST['BANK_KPP'];
		$data['BANK_ORGN'] = $_REQUEST['BANK_ORGN'];
		$data['BANK_PAYMENT_ACCOUNT'] = $_REQUEST['BANK_PAYMENT_ACCOUNT'];
		$data['BANK_NAME'] = $_REQUEST['BANK_NAME'];
		$data['BANK_BIK'] = $_REQUEST['BANK_BIK'];
		$data['BANK_CORRESCPONDENT_ACCOUNT'] = $_REQUEST['BANK_CORRESCPONDENT_ACCOUNT'];
		$data['BANK_PHONE'] = $_REQUEST['BANK_PHONE'];
		$data['BANK_CEO'] = $_REQUEST['BANK_CEO'];

	} else {

		$data['FIO'] = $USER->GetParam('EMAIL');
		$data['EMAIL'] = $USER->GetParam('EMAIL');
		$data['PHONE'] = $USER->GetParam('PERSONAL_PHONE');
		$data['CITY'] = 'Санкт-Петербург';
		$data['ADDRESS'] = 'Московский проспект, д.222А';

	}


	// delivery
	if ($data['DELIVERY_ID'] == 12 || $data['DELIVERY_ID'] == 13) {
		$sdek_city_id = !empty($_REQUEST['CITY_ID']) ? $_REQUEST['CITY_ID'] : 137;
		$bitrix_city_id = sqlSdekCity::getBySId($sdek_city_id);
		$data['LOCATION'] = CSaleLocation::getLocationCODEbyID($bitrix_city_id['BITRIX_ID']);
		$data['ZIP'] = !empty($_REQUEST['ZIP']) ? $_REQUEST['ZIP'] : '196066';
	} else if ($data['DELIVERY_ID'] == 6) {
		$data['ZIP'] = !empty($_REQUEST['ZIP']) ? $_REQUEST['ZIP'] : '196066';
		$data['LOCATION'] = CSaleLocation::GetByZIP($data['ZIP']);
		if (empty($data['LOCATION'])) {
			$city_name = explode(' ', $data['CITY']);
			$city_name = end($city_name);
			$list = CSaleLocation::GetList([], ['COUNTRY_LID' => 'ru', '!CITY_ID' => null, '%CITY_NAME' => $city_name]);
			if ($item = $list->GetNext()) {
				$bitrix_city_id['BITRIX_ID'] = !empty($item['CITY_ID']) ? $item['CITY_ID'] : 269;
			} else {
				$bitrix_city_id['BITRIX_ID'] = 269;
			}
			$data['LOCATION'] = CSaleLocation::getLocationCODEbyID($bitrix_city_id['BITRIX_ID']);
		}
	} else {
		$data['LOCATION'] = CSaleLocation::getLocationCODEbyID(269);
		$data['ZIP'] = '196066';
	}


	// basket
	$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());

	// clear notes
	$basket_items = $basket->getBasketItems();

	foreach ($basket_items as $basket_item) {
		$notes = unserialize($basket_item->getField('NOTES'));
		$id = $notes['ID'];
		if ($id === '0') 
			$notes = 'bonus: ' . intval($notes['UF_BONUS_POINTS']);
		else
			$notes = 'nobonus';
		$basket_item->setFieldNoDemand('NOTES', $notes);
	}

	// order
	$order = \Bitrix\Sale\Order::create(SITE_ID, $USER->GetID());
	$order->setPersonTypeId($data['PERSON_TYPE_ID']);
	$order->setBasket($basket);

	$propertyCollection = $order->getPropertyCollection();

	setPropertyValue($propertyCollection, 'FIO', $data['FIO']);
	setPropertyValue($propertyCollection, 'EMAIL', $data['EMAIL']);
	setPropertyValue($propertyCollection, 'PHONE', $data['PHONE']);
	setPropertyValue($propertyCollection, 'LOCATION', $data['LOCATION']);
	setPropertyValue($propertyCollection, 'ZIP', $data['ZIP']);
	setPropertyValue($propertyCollection, 'CITY', $data['CITY']);
	setPropertyValue($propertyCollection, 'ADDRESS', $data['ADDRESS']);

	if ($data['PERSON_TYPE_ID'] === 2) {

		setPropertyValue($propertyCollection, 'COMPANY', $data['COMPANY']);

	}

	$bill = 
		'ИНН: ' . $data['BANK_INN'] . ', ' .
		'КПП: ' . $data['BANK_KPP'] . ', ' .
		'ОРГН: ' . $data['BANK_ORGN'] . ', ' .
		'Расчетный счет: ' . $data['BANK_PAYMENT_ACCOUNT'] . ', ' .
		'Название банка: ' . $data['BANK_NAME'] . ', ' .
		'БИК: ' . $data['BANK_BIK'] . ', ' .
		'Корр. счет: ' . $data['BANK_CORRESCPONDENT_ACCOUNT'] . ', ' .
		'Телефон: ' . $data['BANK_PHONE'] . ', ' .
		'Генеральный директор: ' . $data['BANK_CEO'];

	$order->setField('USER_DESCRIPTION', $bill);

	// delivery
	$shipmentCollection = $order->getShipmentCollection();
	$shipment = $shipmentCollection->createItem(\Bitrix\Sale\Delivery\Services\Manager::getObjectById($data['DELIVERY_ID']));

	$shipmentItemCollection = $shipment->getShipmentItemCollection();

	foreach ($basket as $basketItem) {
		$item = $shipmentItemCollection->createItem($basketItem);
		$item->setQuantity($basketItem->getQuantity());
	}

	//$shipmentCollection->calculateDelivery();

	//$shipment_list = \Bitrix\Sale\Delivery\Services\Manager::getActiveList();

	// payment
	$paymentCollection = $order->getPaymentCollection();
	$payment = $paymentCollection->createItem(Bitrix\Sale\PaySystem\Manager::getObjectById($data['PAY_SYSTEM_ID']));

	$payment->setField('SUM', $order->getPrice());
	$payment->setField('CURRENCY', $order->getCurrency());

	// save
	$result = false;

	if ($_REQUEST['SAVE'] === 'Y') $result = $order->save();

	if ($result) {
		$arResult['error'] = !$result->isSuccess();
		$arResult['message'] = $result->getErrors();
	}

	$arResult['id'] = $order->getId();
	$arResult['order'] = $order->toArray();

	// send email
	if ($order->getId()) {
		$discount = $order->getDiscount();
		$orderdiscount = 0;
		if ($discount) {
			$discount->calculate();
			$calc = $discount->getApplyResult(true);
			foreach ($calc["PRICES"]["BASKET"] as $n => $i) {
				if ($p = $basket->getItemById($n)) {
					$orderdiscount += $p->getQuantity() * $i["DISCOUNT"];
				}
			}
			$orderdiscount = round($orderdiscount);
		}
		$table = '<table width="800">
				<thead>
					<tr style="text-align: left;">
						<th style="padding: 10px">N</th>
						<th style="padding: 10px">Артикул</th>
						<th style="padding: 10px">Наменование</th>
						<th style="padding: 10px">Количество</th>
						<th style="padding: 10px">Цена</th>
					</tr>
					<tr>
						<td colspan="5"><hr></td>
					</tr>
				</thead>
				<tbody>';
		foreach ($basket as $i => $item) {
			$row = '';
			$collection = $item->getPropertyCollection();
			foreach ($collection as $prop) {
				if ($prop->getField('CODE') === 'CML2_ARTICLE') $art = $prop->getField('VALUE');
			}
			$row .= '<td style="padding: 10px">'.($i+1).'</td>';
			$row .= '<td style="padding: 10px">'.$art.'</td>';
			$row .= '<td style="padding: 10px">'.$item->getField('NAME').'</td>';
			$row .= '<td style="padding: 10px">'.$item->getField('QUANTITY').'</td>';
			$row .= '<td style="padding: 10px">'.$item->getField('PRICE').'</td>';
			$table .= '<tr>' . $row . '</tr>';
		}
		$table .= '</tbody>
				<tfoot style="text-align: right;">
					<tr><td colspan="5"><hr></td></tr>
					<tr><th colspan="4" style="padding: 5px 10px;">Сумма заказа:</th><td>'.$basket->getBasePrice().' '.$order->getCurrency().'</td></tr>
					<tr><th colspan="4" style="padding: 5px 10px;">Скидка:</th><td>'.$orderdiscount.' '.$order->getCurrency().'</td></tr>
					<tr><th colspan="4" style="padding: 5px 10px;">Доставка:</th><td>'.$order->getDeliveryPrice().' '.$order->getCurrency().'</td></tr>
					<tr><th colspan="4" style="padding: 5px 10px;">Итого:</th><td>'.$order->getPrice().' '.$order->getCurrency().'</td></tr>
				</tfoot>
			 </table>';
		$email = $data['PERSON_TYPE_ID'] === 2 ? 'sales@quarta-hunt.ru' : 'shop@quarta-hunt.ru';
		$fields = [
			'ORDER_ID' => $order->getId(),
			'ORDER_DATE' => $order->getField('DATE_INSERT')->toString(),
			'ORDER_FIO' => $data['FIO'],
			'ORDER_PHONE' => $data['PHONE'],
			'ORDER_EMAIL' => $data['EMAIL'],
			'EMAIL' => $data['EMAIL'],
			'ORDER_ZIP' => $data['ZIP'],
			'ORDER_CITY' => $data['CITY'],
			'ORDER_ADDRESS' => $data['ADDRESS'],
			'ORDER_PRICE' => $order->getPrice().' '.$order->getCurrency(),
			'ORDER_LIST' => $table,
			'SALE_EMAIL' => $email,
			'COMPANY' => $data['COMPANY'],
			'BANK_INN' => $data['BANK_INN'],
			'BANK_KPP' => $data['BANK_KPP'],
			'BANK_ORGN' => $data['BANK_ORGN'],
			'BANK_PAYMENT_ACCOUNT' => $data['BANK_PAYMENT_ACCOUNT'],
			'BANK_NAME' => $data['BANK_NAME'],
			'BANK_BIK' => $data['BANK_BIK'],
			'BANK_CORRESCPONDENT_ACCOUNT' => $data['BANK_CORRESCPONDENT_ACCOUNT'],
			'BANK_PHONE' => $data['BANK_PHONE'],
			'BANK_CEO' => $data['BANK_CEO'],
		];
		$event = new CEvent;
		if ($data['PERSON_TYPE_ID'] === 2)
			$result = $event->SendImmediate('SALE_NEW_ORDER_WHOLESALE', SITE_ID, $fields);
		else
			$result = $event->SendImmediate('SALE_NEW_ORDER_RETAIL', SITE_ID, $fields);
		$arResult['send_email'] = $result;
	}

} else {

	$arResult['error'] = true;
	$arResult['message'] = 'Пользователь не авторизован';

}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();









