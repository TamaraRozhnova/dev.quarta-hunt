<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

 CJSCore::Init(array('currency')); 

 Bitrix\Main\Loader::includeModule('iblock');

/* Получаем список категорий, разрешённых для доставки */
$dbRestr = \Bitrix\Sale\Delivery\Restrictions\Manager::getList(array(
	'filter' => array('SERVICE_ID' => CDEK_DELIVERY_ID)
));

while ($arRestr = $dbRestr->fetch()) {
    if ($arRestr['ID'] == CDEK_RESTRICTION_SECTIONS_RULE_ID) {
        if (is_array($arRestr['PARAMS']) && is_array($arRestr['PARAMS']['CATEGORIES']))
        $arResult['JS_DATA']['ALLOWED_CATEGORIES'] = $arRestr['PARAMS']['CATEGORIES'];
    }
}

 if (!empty($arResult['BASKET_ITEMS'])) {
     $haveLicenceProducts = false;

    foreach ($arResult['BASKET_ITEMS'] as $arItem) {        
        $arProductsIDS[$arItem['PRODUCT_ID']] = $arItem['PRODUCT_ID'];
        $arResult['JS_DATA']['PRODUCTS_RESTRICT_INFO'][$arItem['PRODUCT_ID']]['NAME'] = $arItem['NAME'];

        $res = CIBlockElement::GetByID($arItem['PRODUCT_ID']);

        if ($element = $res->GetNext()) {
            $rsSection = CIBlockSection::GetList([],
                [
                    'ID' => $element['IBLOCK_SECTION_ID'],
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID
                ],
                false,
                [
                    'ID',
                    'UF_LISENCE_PRODUCTS'
                ]
            )->GetNext();

            if ($rsSection['UF_LISENCE_PRODUCTS'] == 1) {
                $haveLicenceProducts = true;
            }
        }
    }

     $arResult['HAVE_LICENCE_PRODUCTS'] = $haveLicenceProducts;
 }

 foreach ($arProductsIDS as $arProduct) {

    $arResult['JS_DATA']['PRODUCTS_RESTRICT_INFO'][$arProduct]['ALLOWED'] = 'N';

    $rsSectionsEl = CIBlockElement::GetElementGroups($arProduct, true)->fetch();

    $rsPath = CIBlockSection::GetNavChain(false, $rsSectionsEl['ID']); 

    while ($arPath = $rsPath->GetNext()) {
        if (is_array($arResult['JS_DATA']['ALLOWED_CATEGORIES']) && array_search($arPath['ID'], $arResult['JS_DATA']['ALLOWED_CATEGORIES']) !== false) {
            $arResult['JS_DATA']['PRODUCTS_RESTRICT_INFO'][$arProduct]['ALLOWED'] = 'Y';
        }
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

//    $userFields = \Bitrix\Main\UserTable::getList([
//        'select' => ['ID', 'NAME', 'UF_LOGICTIM_BONUS'],
//        'filter' => ['ID' => $userId],
//    ])->fetch();

}

/** DEBUG */
$arResult['JS_DATA']['DEBUG_IP'] = $_SERVER['REMOTE_ADDR'];

/** Передаем бонусы пользователя */
//$arResult['JS_DATA']['USER_POINTS'] = $userFields['UF_LOGICTIM_BONUS'];

/** Передаем PAYSYSTEMID в script */
$arResult['JS_DATA']['PAY_SYSTEMS']["UKASSA_ID"] = (int) UKASSA_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["UKASSA_CREDIT_ID"] = (int) UKASSA_CREDIT_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["BANK_TRANSFER_ID"] = (int) BANK_TRANSFER_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["DEBET_CARD_PERSONALLY_ID"] = (int) DEBET_CARD_PERSONALLY_ID;
$arResult['JS_DATA']['PAY_SYSTEMS']["CASH_PERSONALLY_ID"] = (int) CASH_PERSONALLY_ID;

/** Передаем доставки */
$arResult['JS_DATA']['DELIVERY_IDS']["DELIVERY_PICKUP_ID"] = DELIVERY_PICKUP_ID;


$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

global $USER;
$arGroups = CUser::GetUserGroup($USER->GetId());
$isUserOpt = array_search(OPT_GROUP_ID, $arGroups);

if ($isUserOpt !== false) {
    $arResult['JS_DATA']['IS_USER_OPT'] = true;
}