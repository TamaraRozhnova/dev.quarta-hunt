<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('sale');

$data['PERSON_TYPE_ID'] = 1;
$data['FIO'] = 'Мария Петрова';
$data['PHONE'] = '+7 (999) 111-11-11';
$data['EMAIL'] = 'return_to_castle@mail.ru';
$data['ZIP'] = '100101';
$data['CITY'] = 'Москва';
$data['ADDRESS'] = 'ул. Инженерная, 111';
$data['COMPANY'] = '';
$data['BANK_INN'] = '';
$data['BANK_KPP'] = '';
$data['BANK_ORGN'] = '';
$data['BANK_PAYMENT_ACCOUNT'] = '';
$data['BANK_NAME'] = '';
$data['BANK_BIK'] = '';
$data['BANK_CORRESCPONDENT_ACCOUNT'] = '';
$data['BANK_PHONE'] = '';
$data['BANK_CEO'] = '';


$order = \Bitrix\Sale\Order::load(729);
$basket = $order->getBasket();

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
	$result = $event->SendImmediate('TEST_TYPE', SITE_ID, $fields);
	$arResult['send_email'] = $result;
	$arResult['data'] = $fields;
}

echo '<pre>';
print_r($arResult);
echo '</pre>';

/*
ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();
*/

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
