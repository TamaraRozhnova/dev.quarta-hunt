<?php

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/mylog-8898956595.txt");

use \Bitrix\Main\Loader;
use \Bitrix\Main\EventManager;

$eventManager = EventManager::getInstance();

include($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/constants.php');
include($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/functions.php');


include($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");

include 'events.php';

Loader::registerAutoLoadClasses(null, [
    'Feedback\Review' => '/local/php_interface/classes/Feedback/Review.php',
    'Feedback\Events' => '/local/php_interface/classes/Feedback/Events.php',
    'Form\Auth\RegistrationForm' => '/local/php_interface/classes/Form/Auth/RegistrationForm.php',
    'Form\ProductSubscribeForm' => '/local/php_interface/classes/Form/ProductSubscribeForm.php',
    'Form\ProductQuestionForm' => '/local/php_interface/classes/Form/ProductQuestionForm.php',
    'Form\WebForm' => '/local/php_interface/classes/Form/WebForm.php',
    'General\User' => '/local/php_interface/classes/General/User.php',
    'General\Product' => '/local/php_interface/classes/General/Product.php',
    'General\Section' => '/local/php_interface/classes/General/Section.php',
    'Helpers\DiscountsHelper' => '/local/php_interface/classes/Helpers/DiscountsHelper.php',
    'Helpers\FileSizeHelper' => '/local/php_interface/classes/Helpers/FileSizeHelper.php',
    'Helpers\Filters\ProductsFilterHelper' => '/local/php_interface/classes/Helpers/Filters/ProductsFilterHelper.php',
    'Helpers\Filters\ReviewsFilterHelper' => '/local/php_interface/classes/Helpers/Filters/ReviewsFilterHelper.php',
    'Helpers\Filters\BrandsFilterHelper' => '/local/php_interface/classes/Helpers/Filters/BrandsFilterHelper.php',
    'Helpers\NumWordHelper' => '/local/php_interface/classes/Helpers/NumWordHelper.php',
    'Helpers\ProductsDataHelper' => '/local/php_interface/classes/Helpers/ProductsDataHelper.php',
    'Helpers\RecommendedProductsHelper' => '/local/php_interface/classes/Helpers/RecommendedProductsHelper.php',
    'Helpers\VideoReviewsHelper' => '/local/php_interface/classes/Helpers/VideoReviewsHelper.php',
    'Helpers\VideoUrlHelper' => '/local/php_interface/classes/Helpers/VideoUrlHelper.php',
    'Helpers\WorkProsHelper' => '/local/php_interface/classes/Helpers/WorkProsHelper.php',
    'SearchSphinx\ProductTable' => '/local/php_interface/classes/Search/SearchProducts.php',
    'SearchSphinx\BlogTable' => '/local/php_interface/classes/Search/SearchBlog.php',
    'Helpers\Translit' => '/local/php_interface/classes/Helpers/TranslitHelper.php',
    'OrderId' => '/local/php_interface/classes/OrderId.php',
    'Personal\Favorites' => '/local/php_interface/classes/Personal/Favorites.php',
    'Personal\Basket' => '/local/php_interface/classes/Personal/Basket.php',
    'CustomEvents\CUserEx' => '/local/php_interface/classes/Events/CUserEx.php',
    'CustomEvents\SaleOrderAjaxEventsO2K' => '/local/php_interface/classes/Events/SaleOrderAjaxEventsO2K.php',
    'CustomEvents\RulesBasket' => '/local/php_interface/classes/Events/RulesBasket.php',
    'CustomEvents\OnDiscount' => '/local/php_interface/classes/Events/OnDiscount.php',
    'CustomEvents\OnBeforeIBlockElementUpdate' => '/local/php_interface/classes/Events/OnBeforeIBlockElementUpdate.php',
    'Upload\UserUploadForm1c' => '/local/php_interface/classes/Upload/UserUploadForm1c.php',
]);


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
			if ($notes !== 'nobonus') {
                $res['total_bonus_by_order'] += intval(mb_substr($notes, 7));
            }
		}

		if ($res['total_bonus_by_order'] > 0) {
			$bonus = $res['total_bonus_by_order'] + $res['user_bonus_points'];
			$res['upd'] = $user->Update($res['user']['ID'], ['UF_BONUS_POINTS' => intval($bonus)]);
			$res['bonus'] = $bonus;
		}
	}
}

function num_declension($number, $titles) {
    $abs = abs($number);	
    $cases = array (2, 0, 1, 1, 1, 2);	
    return $number." ".$titles[ ($abs%100 > 4 && $abs %100 < 20) ? 2 : $cases[min($abs%10, 5)] ];
}

function random_number($length = 6){
	$arr = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
		'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
	);
 
	$res = '';
	for ($i = 0; $i < $length; $i++) {
		$res .= $arr[random_int(0, count($arr) - 1)];
	}
	return $res;
}

function changeOrderStatus(\Bitrix\Main\Event $event)
{
    $arPickup = DELIVERY_PICKUP_ID;

    $arPayments = UKASSA_ID;
    $arDeliveries = [
        DELIVERY_RF_POST,
        DELIVERY_RF_COURIER,
        DELIVERY_SDEK_COURIER,
        DELIVERY_SDEK_PICKUP
    ];

    $entity = $event->getParameter("ENTITY");
    $orderId = $entity->getField('ORDER_ID');

    $order = \Bitrix\Sale\Order::load($orderId);
    $shipmentCollection = $order->getShipmentCollection();

    $arOrder = $shipmentCollection->getOrder()->getFields()->getValues();

    if (!empty($arOrder)) {
        $deliveryId = $arOrder['DELIVERY_ID'];
        $payed = $arOrder['PAYED'] == 'Y' ? true : false;

        $payedSystem = $arOrder['PAY_SYSTEM_ID'];

        /** Если заказ оплачен, 
         * платежная система равна "Panyway" 
         * и доставки - Курьером», «Почтой», «Сдэк */
        if (
            $payed
            &&
            $payedSystem == $arPayments
            &&
            in_array($deliveryId,$arDeliveries) 
        ) {
            $statusId = 'P';
        }

        /** Если заказ оплачен, 
         * платежная система равна "Panyway" 
         * и доставки - Самовывоз */
        if (
            $payed
            &&
            $payedSystem == $arPayments
            &&
            $deliveryId == $arPickup
        ) {
            $statusId = 'PP';
        }

        $statusList = \Bitrix\Sale\Internals\StatusTable::getList([
            'filter' => ['ID' => $statusId],
            'select' => ['ID']
        ]);
    
        if ($status = $statusList->fetch()) {
            $order->setField('STATUS_ID', $statusId);
            $order->save();
        }
    }
}

function debug($var) {
    if (Bitrix\Main\Engine\CurrentUser::get()->isAdmin()) {
        print_r('<pre>');
        print_r($var);
        print_r('</pre>');
    }
}
/*
 * SEO, replace text/javascript for html5 validation w3c
 * */
function removeType(&$content)
{
    $content = str_replace(' type="text/javascript"', '', $content);
    $content = str_replace(' type=\'text/javascript\'', '', $content);
    $content = str_replace(' type="text/css"', '', $content);
    $content = str_replace(' type=\'text/css\'', '', $content);
    $content = str_replace('<br />', '<br>', $content);
    $content = str_replace('<hr />', '<hr>', $content);
}