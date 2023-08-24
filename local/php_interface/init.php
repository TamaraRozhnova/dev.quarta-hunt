<?php
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/mylog-8898956595.txt");

COption::SetOptionString("main", "check_agents", "N"); 
COption::SetOptionString("main", "agents_use_crontab", "N"); 

use \Bitrix\Main\Loader;

include($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/constants.php');
include($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

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

    'SearchSphinx\ProductTable' => '/local/php_interface/classes/Search/SearchProducts.php',
    'SearchSphinx\BlogTable' => '/local/php_interface/classes/Search/SearchBlog.php',
    'Helpers\Translit' => '/local/php_interface/classes/Helpers/TranslitHelper.php',

    'OrderId' => '/local/php_interface/classes/OrderId.php',
    'Personal\Favorites' => '/local/php_interface/classes/Personal/Favorites.php',
    'Personal\Basket' => '/local/php_interface/classes/Personal/Basket.php',
]);

//\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleStatusOrder', 'AddBonusPoints');

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
function num_declension($number, $titles) {	
    $abs = abs($number);	
    $cases = array (2, 0, 1, 1, 1, 2);	
    return $number." ".$titles[ ($abs%100 > 4 && $abs %100 < 20) ? 2 : $cases[min($abs%10, 5)] ];
}

AddEventHandler("main", "OnBeforeUserLogin", Array("CUserEx", "OnBeforeUserLogin"));
AddEventHandler("main", "OnBeforeUserRegister", Array("CUserEx", "OnBeforeUserRegister"));
AddEventHandler("main", "OnBeforeUserRegister", Array("CUserEx", "OnBeforeUserUpdate"));
AddEventHandler("main", "OnAfterUserRegister", Array("CUserEx", "OnAfterUserRegister"));
class CUserEx{
    function OnBeforeUserLogin($arFields){
        $filter = Array("EMAIL" => $arFields["LOGIN"]);
        $rsUsers = CUser::GetList(($by="LAST_NAME"), ($order="asc"), $filter);
        if($user = $rsUsers->GetNext())
        $arFields["LOGIN"] = $user["LOGIN"];
    }
    function OnBeforeUserRegister(&$arFields){
        $arFields["LOGIN"] = $arFields["EMAIL"];

        if ($arFields['UF_TYPE'] == 'wholesale'){
            $arFields["GROUP_ID"] = [];
            $arFields["GROUP_ID"][] = 9;
        };
    }
    function onAfterUserRegister(&$arFields) {

        if ($arFields["USER_ID"] > 0) {

            Loader::includeModule("catalog");
            Loader::includeModule("sale");

            $discountID = 42;

            $COUPON = CatalogGenerateCoupon();
            $addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
                'DISCOUNT_ID' => $discountID,
                'COUPON'      => $COUPON,
                'TYPE'        => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER,
                'MAX_USE'     => 1,
                'USER_ID'     => $arFields["USER_ID"],
                'DESCRIPTION' => ''
            ));

            if (!$addDb->isSuccess()) {
                echo $addDb->getErrorMessages();
            } else {

                \Bitrix\Main\Mail\Event::send(array(
                    "EVENT_NAME" => "NEW_USER_COUPON", 
                    "LID" => "s1", 
                    "C_FIELDS" => array( 
                        "EMAIL" => $arFields["EMAIL"], 
                        "USER_ID" => $arFields["USER_ID"],
                        "PROMO_CODE" => $COUPON,
                    ), 
                ));

            }
  
        }
    }
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

//Bitrix\Main\EventManager::getInstance()->addEventHandler("sale", "OnSaleOrderBeforeSaved", array("SaleOrderAjaxEventsO2K","OnSaleOrderBeforeSavedHandler"));
class SaleOrderAjaxEventsO2K
{
    public static function OnSaleOrderBeforeSavedHandler(\Bitrix\Main\Event $event)
    {
        $order = $event->getParameter('ENTITY');

        if (!$order->isNew()) {
            return;
        }

        $basket = $order->getBasket();
        $basket_items = $basket->getBasketItems();

        foreach ($basket_items as $item) {

            $itemSerialize = unserialize((string)$item->getField('NOTES'));
            
            $item->setFields(array(
                'NOTES' => $itemSerialize['UF_BONUS_POINTS'] . ' б.'
            ));

            $basket->save();
        }
    }

}

Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "sale",
    "\Bitrix\Sale\Internals\Discount::OnAfterUpdate",
    array(
        "RulesBasket",
        "OnAfterAddDiscountTable"
    )
);

Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "sale",
    "\Bitrix\Sale\Internals\Discount::OnAfterAdd",
    array(
        "RulesBasket",
        "OnAfterAddDiscountTable"
    )
);

Bitrix\Main\EventManager::getInstance()->addEventHandler(
    "sale",
    "\Bitrix\Sale\Internals\Discount::OnBeforeDelete",
    array(
        "RulesBasket",
        "OnBeforeDeleteDiscountTable"
    )
);

class RulesBasket
{
    public static function OnAfterAddDiscountTable(&$arFields)
    {
        
        \Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Loader::includeModule('sale');

        $arrData = $arFields->getParameters();

        $iblockCode = CATALOG_IBLOCK_CODE;

        $iblockId = \Bitrix\Iblock\IblockTable::getList(array(
                    'filter' => array('CODE' => $iblockCode),
        ))->fetch()['ID'];

        $discountPercent = reset($arrData['fields']['ACTIONS_LIST']['CHILDREN'])['DATA']['Value'];

        $arrMainData = $arrData['fields']['ACTIONS_LIST'];

        /** Если не пустой блок-обертка */
        if (!empty($arrMainData['CHILDREN'])) {

            /** Перебираем главный блок-обертку */
            foreach ($arrMainData['CHILDREN'] as $arBlockChildren) {

                /** Если не пустой блок с условиями */
                if (!empty($arBlockChildren['CHILDREN'])) {

                    /** Перебираем блоки с условиями */
                    foreach ($arBlockChildren['CHILDREN'] as $arElements) {

                        /** Проверка на условие для разделов и элементов */
                        switch ($arElements['CLASS_ID']) {

                            /** Если это раздел */
                            case 'CondIBSection':

                                if (!empty($arElements['DATA'])) {

                                    /** Если не пустой массив с разделами и условие без "НЕ РАВНО", начинаем перебирать */
                                    if (!empty($arElements['DATA']['value']) && $arElements['DATA']['logic'] != "Not") {

                                        $arSectionsIDS = $arElements['DATA']['value'];

                                        if (!empty($arSectionsIDS)) {

                                            /** Делаем запрос в раздел, чтобы получить элементы */

                                            $rsSection = \Bitrix\Iblock\SectionTable::getByPrimary($arSectionsIDS, [
                                                'filter' => ['IBLOCK_ID' => $iblockId],
                                                'select' => ['LEFT_MARGIN', 'RIGHT_MARGIN'],
                                            ])->fetch();

                                            $rsElements = \Bitrix\Iblock\ElementTable::getList([
                                                'select' => ['ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID'],
                                                'filter' => [
                                                    'IBLOCK_ID' => $iblockId,
                                                    'ACTIVE' => "Y",
                                                    '>=IBLOCK_SECTION.LEFT_MARGIN' => $rsSection['LEFT_MARGIN'],
                                                    '<=IBLOCK_SECTION.RIGHT_MARGIN' => $rsSection['RIGHT_MARGIN'],
                                                ],
                                            ])->fetchAll();

                                            if (!empty($rsElements)) {

                                                foreach ($rsElements as $arElementID) {
                                                    \CIBlockElement::SetPropertyValuesEx($arElementID['ID'], false, array(
                                                        "SIZE_DISCOUNT" => (int)$discountPercent
                                                        )
                                                    );
                                                }

                                                
                                            }

                                        }

                                    }

                                    
                                }

                                break;

                            /** Если это элементы */
                            case 'CondIBElement':

                                if (!empty($arElements['DATA'])) {
                                    if (!empty($arElements['DATA']['value'])) {
                                        foreach ($arElements['DATA']['value'] as $arElementID) {
                                            \CIBlockElement::SetPropertyValuesEx($arElementID, false, array(
                                                "SIZE_DISCOUNT" => (int)$discountPercent
                                                )
                                            );
                                        }   
                                    }
                                }

                                break;
                            
                            default:
                                # code...
                                break;
                        }

                    }
                }
            }
        }

 
    }

    public static function OnBeforeDeleteDiscountTable(\Bitrix\Main\Event $event)
    {

        \Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Loader::includeModule('sale');

        $idRulesBasket = $event->getParameter("primary");

        if (!empty($idRulesBasket)) {

            $arDiscount = \Bitrix\Sale\Internals\DiscountTable::getList(
                [
                    'filter' => [
                        'ID' => $idRulesBasket['ID']
                    ]
                ]
            )->fetch();

            $arrMainData = $arDiscount['ACTIONS_LIST'];

            /** Если не пустой блок-обертка */
            if (!empty($arrMainData['CHILDREN'])) {

                /** Перебираем главный блок-обертку */
                foreach ($arrMainData['CHILDREN'] as $arBlockChildren) {

                    /** Если не пустой блок с условиями */
                    if (!empty($arBlockChildren['CHILDREN'])) {

                        /** Перебираем блоки с условиями */
                        foreach ($arBlockChildren['CHILDREN'] as $arElements) {

                            /** Проверка на условие для разделов и элементов */
                            switch ($arElements['CLASS_ID']) {

                                /** Если это раздел */
                                case 'CondIBSection':

                                    if (!empty($arElements['DATA'])) {

                                        /** Если не пустой массив с разделами, начинаем перебирать */
                                        if (!empty($arElements['DATA']['value'])) {

                                            $arSectionsIDS = $arElements['DATA']['value'];

                                            if (!empty($arSectionsIDS)) {

                                                /** Делаем запрос в раздел, чтобы получить элементы */

                                                $rsSection = \Bitrix\Iblock\SectionTable::getByPrimary($arSectionsIDS, [
                                                    'filter' => ['IBLOCK_ID' => $iblockId],
                                                    'select' => ['LEFT_MARGIN', 'RIGHT_MARGIN'],
                                                ])->fetch();

                                                $rsElements = \Bitrix\Iblock\ElementTable::getList([
                                                    'select' => ['ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID'],
                                                    'filter' => [
                                                        'IBLOCK_ID' => $iblockId,
                                                        'ACTIVE' => "Y",
                                                        '>=IBLOCK_SECTION.LEFT_MARGIN' => $rsSection['LEFT_MARGIN'],
                                                        '<=IBLOCK_SECTION.RIGHT_MARGIN' => $rsSection['RIGHT_MARGIN'],
                                                    ],
                                                ])->fetchAll();

                                                if (!empty($rsElements)) {

                                                    foreach ($rsElements as $arElementID) {
                                                        \CIBlockElement::SetPropertyValuesEx($arElementID['ID'], false, array(
                                                            "SIZE_DISCOUNT" => null
                                                            )
                                                        );
                                                    }

                                                    
                                                }

                                            }

                                        }

                                        
                                    }

                                    break;

                                /** Если это элементы */
                                case 'CondIBElement':

                                    if (!empty($arElements['DATA'])) {
                                        if (!empty($arElements['DATA']['value'])) {
                                            foreach ($arElements['DATA']['value'] as $arElementID) {
                                                \CIBlockElement::SetPropertyValuesEx($arElementID, false, array(
                                                    "SIZE_DISCOUNT" => null
                                                    )
                                                );
                                            }   
                                        }
                                    }

                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }
                }
            }
        }
    }
}

\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSalePaymentEntitySaved', 'changeOrderStatus');

function changeOrderStatus(\Bitrix\Main\Event $event)
{
    $arPickup = DELIVERY_PICKUP_ID;

    $arPayments = PANYWAY_ID;
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