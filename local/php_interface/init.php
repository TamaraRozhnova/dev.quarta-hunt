<?php
use \Bitrix\Main\Loader;
\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleStatusOrder', 'AddBonusPoints');

Loader::registerAutoLoadClasses(null, array(
    'OrderId' => '/local/php_interface/classes/OrderId.php',
));

include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");

function AddBonusPoints($order_id, $status) {
	
	$order = \Bitrix\Sale\Order::load($order_id);

	$user = new CUser;
	$u = $user->GetByID($order->getUserId());

	$res = [];
	$res['user'] = $u->GetNext();

	if ($order !== null && $status === 'F' && !empty($res['user']) && $res['user']['UF_TYPE'] === 'retail') {

		$basket = $order->getBasket();

		$res['total_bonus_by_order'] = 0;
		$res['user_bonus_points'] = floatval($res['user']['UF_BONUS_POINTS']);

		foreach($basket as $bsk_item) {
			$notes = $bsk_item->getField('NOTES');

			if ($notes !== 'nobonus')
				$res['total_bonus_by_order'] += intval(mb_substr($notes, 7));  //0.03 * floatval($bsk_item->getField('PRICE')) * intval($bsk_item->getField('QUANTITY'));
		}

		if ($res['total_bonus_by_order'] > 0) {
			$bonus = $res['total_bonus_by_order'] + $res['user_bonus_points'];
			$res['upd'] = $user->Update($res['user']['ID'], ['UF_BONUS_POINTS' => intval($bonus)]);
			$res['bonus'] = $bonus;
		}

	}

}
