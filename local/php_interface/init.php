<?php
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/mylog-8898956595.txt");

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
function num_declension($number, $titles) {	
    $abs = abs($number);	
    $cases = array (2, 0, 1, 1, 1, 2);	
    return $number." ".$titles[ ($abs%100 > 4 && $abs %100 < 20) ? 2 : $cases[min($abs%10, 5)] ];
}

AddEventHandler("main", "OnBeforeUserLogin", Array("CUserEx", "OnBeforeUserLogin"));
AddEventHandler("main", "OnBeforeUserRegister", Array("CUserEx", "OnBeforeUserRegister"));
AddEventHandler("main", "OnBeforeUserRegister", Array("CUserEx", "OnBeforeUserUpdate"));
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

Bitrix\Main\EventManager::getInstance()->addEventHandler("sale", "OnSaleOrderBeforeSaved", array("SaleOrderAjaxEventsO2K","OnSaleOrderBeforeSavedHandler"));
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