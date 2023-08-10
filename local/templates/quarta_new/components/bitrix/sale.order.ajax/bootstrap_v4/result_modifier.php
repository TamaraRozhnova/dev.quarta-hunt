<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

 CJSCore::Init(array('currency')); 

 Bitrix\Main\Loader::includeModule('iblock');


 if (!empty($arResult['BASKET_ITEMS'])) {
    foreach ($arResult['BASKET_ITEMS'] as $arItem) {
        $arProductsIDS[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
    }
 }

 foreach ($arProductsIDS as $arProduct) {

    $rsSectionsEl = CIBlockElement::GetElementGroups($arProduct, true)->fetch();

    $rsPath = CIBlockSection::GetNavChain(false, $rsSectionsEl['ID']); 

    while ($arPath = $rsPath->GetNext()) {
        $sectionIds[$arPath['ID']] = $arPath['ID']; 
    }

 }

 $entSections = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);

 $rsSections = $entSections::getList(array(
    "filter" => array(
        "IBLOCK_ID" => CATALOG_IBLOCK_ID, 
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
        "ID" => $sectionIds
    ),
    "select" => array("UF_LISENCE_PRODUCTS", "ID"),
))->fetchAll();

if (!empty($rsSections)) {
    foreach ($rsSections as $arSection) {
        if ($arSection['UF_LISENCE_PRODUCTS'] == 1) {
            $arResult['JS_DATA']['LICENSE_NEED'] = 'Y';
            break;
        }
    }
}

/** Получаем бонусы текущего пользователя */

$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();

if ($userId) {

    $userFields = \Bitrix\Main\UserTable::getList([
        'select' => ['ID', 'NAME', 'UF_BONUS_POINTS'],
        'filter' => ['ID' => $userId],
    ])->fetch();

}

/** DEBUG */
$arResult['JS_DATA']['DEBUG_IP'] = $_SERVER['REMOTE_ADDR'];

/** Передаем бонусы пользователя */
$arResult['JS_DATA']['USER_POINTS'] = $userFields['UF_BONUS_POINTS'];

/** Передаем PAYSYSTEMID в script */
$arResult['JS_DATA']['PAY_SYSTEMS']["PANYWAY_ID"] = (int) PANYWAY_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["BANK_TRANSFER_ID"] = (int) BANK_TRANSFER_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["DEBET_CARD_PERSONALLY_ID"] = (int) DEBET_CARD_PERSONALLY_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["CASH_PERSONALLY_ID"] = (int) CASH_PERSONALLY_ID;

/** Передаем доставки */
$arResult['JS_DATA']['DELIVERY_IDS']["DELIVERY_PICKUP_ID"] = DELIVERY_PICKUP_ID;


$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

