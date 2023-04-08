<?php

use \Bitrix\Main\Loader;

include($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/constants.php');

Loader::registerAutoLoadClasses(null, [
    'Feedback\Review' => '/local/php_interface/classes/Feedback/Review.php',
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
    'Helpers\NumWordHelper' => '/local/php_interface/classes/Helpers/NumWordHelper.php',
    'Helpers\ProductsDataHelper' => '/local/php_interface/classes/Helpers/ProductsDataHelper.php',
    'Helpers\RecommendedProductsHelper' => '/local/php_interface/classes/Helpers/RecommendedProductsHelper.php',
    'Helpers\VideoReviewsHelper' => '/local/php_interface/classes/Helpers/VideoReviewsHelper.php',
    'Helpers\VideoUrlHelper' => '/local/php_interface/classes/Helpers/VideoUrlHelper.php',
    'Helpers\WorkProsHelper' => '/local/php_interface/classes/Helpers/WorkProsHelper.php',
    'OrderId' => '/local/php_interface/classes/OrderId.php',
    'Personal\Favorites' => '/local/php_interface/classes/Personal/Favorites.php',
    'Personal\Basket' => '/local/php_interface/classes/Personal/Basket.php',
]);

\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleStatusOrder', 'AddBonusPoints');

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
