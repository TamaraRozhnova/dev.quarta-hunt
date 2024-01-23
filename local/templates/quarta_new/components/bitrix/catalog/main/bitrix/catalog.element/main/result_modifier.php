<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use Helpers\FileSizeHelper;
use Helpers\RecommendedProductsHelper;
use Helpers\VideoReviewsHelper;
use Bitrix\Main\Grid\Declension;

$shopsMeasory = new Declension('магазин', 'магазина', 'магазинов');

$bannedProps = [
    'CML2_ARTICLE',
    'CML2_ATTRIBUTES',
    'CML2_TRAITS',
    'CML2_BASE_UNIT',
    'CML2_TAXES',
    'MORE_PHOTO',
    'FILES',
    'KOMPLEKTY_DLYA_SAYTA',
    'BUY_WITH_THIS',
    'NEW_PRODUCT',
    'HIT',
    'PRESENT',
    'DOUBLE_BONUS',
    'DOP_IMAGE_MB',
    'SIZE_DISCOUNT'
];

$arResult['FILES'] = [];
$arResult['PROPS'] = [];

if ($arResult['OFFERS'] && count($arResult['OFFERS']) > 0) {

    foreach ($arResult['OFFERS'] as $key => $offer) {

        if ($offer['PRICES'][reset($arParams['PRICE_CODE'])]['VALUE'] == 0) {
            $offer['CAN_BUY'] = false;
        }

        if ($offer['CAN_BUY'] == true) {
            $arResult['AVAILABLE'] = true;
            $arResult['OFFERS_QUANTITY'] += (int)$offer['PRODUCT']['QUANTITY'];
        } else {
            unset($arResult['OFFERS'][$key]);
        }
    }
} else {

    if ($arResult['PRICES'][reset($arParams['PRICE_CODE'])]['VALUE'] == 0) {
        $arResult['CAN_BUY'] = false;
    }

    $arResult['AVAILABLE'] = boolval($arResult['CAN_BUY']);
}

$arResult['PRICES_LIST'] = DiscountsHelper::getCorrectPrices($arResult);

foreach ($arResult['PROPERTIES']['FILES']['VALUE'] as $fileId) {
    $fileResource = CFile::GetByID($fileId);

    if ($file = $fileResource->GetNext()) {
        /** Выводим только PDF */
        if ($file['CONTENT_TYPE'] != 'text/plain') {
            $arResult['FILES'][] = [
                'NAME' => $file['ORIGINAL_NAME'],
                'SIZE' => FileSizeHelper::getFormattedSize($file['FILE_SIZE']),
                'SRC' => $file['SRC']
            ];
        }
    }
}

if (!empty($arResult['DETAIL_PICTURE']['SRC'])) {
    $arResult['IMAGES'][] = $arResult['DETAIL_PICTURE']['SRC'];
    $arResult['IMAGES_ID'][] = $arResult['DETAIL_PICTURE'];
}

if (!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])) {

    foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $value) {

        if (trim(CFile::GetPath($value)) !== '') {
            $arResult['IMAGES'][] = CFile::GetPath($value);
            $arResult['IMAGES_ID'][] = $value;
        }

    }    

}



/** 
 * Если отсутствуют фото, ставим "Фото на фотосессии" 
 */

if (empty($arResult['IMAGES'])) {
    $arResult['HIDE_MODAL'] = 'Y';
    $arResult['IMAGES'][] = "/upload/cards/photo-not-found.jpg";
}

foreach ($arResult['PROPERTIES'] as $key => $prop) {
    if (!in_array($key, $bannedProps) && $prop['~VALUE']) {
        $arResult['PROPS'][] = ['NAME' => $prop['NAME'], 'VALUE' => $prop['~VALUE']];
    }
}

$recommendedProductIds = $arResult['PROPERTIES']['BUY_WITH_THIS']['VALUE'];

if (!$recommendedProductIds) {
    $recommendedProductIds = [];
}

$sectionId = $arResult['SECTION']['IBLOCK_SECTION_ID'];

$arResult['RECOMMENDED_PRODUCTS'] = RecommendedProductsHelper::getRecommendedProducts($recommendedProductIds, $sectionId, 4, $arParams['DETAIL_URL']);

$arResult['VIDEO_REVIEWS'] = VideoReviewsHelper::getVideoReviews($arResult['SECTION']['ID']);

DiscountsHelper::fillProductWithBonuses($arResult);

$arResult['RATING']['MAX_STARS'] = 5;

/** Получаем склады*/

use Bitrix\Catalog\StoreTable,
    Bitrix\Catalog\StoreProductTable;

$rsStoreElement = StoreProductTable::getList(array(
    'filter' => array('PRODUCT_ID' => $arResult['ID']),
    'select' => array('ID', 'AMOUNT', 'STORE_ID')
))->fetchAll();

if (!empty($rsStoreElement)) {

    foreach ($rsStoreElement as $arStoreElement) {

        $arStoreElementIDS[$arStoreElement['STORE_ID']] = $arStoreElement['STORE_ID'];

        $arStoreElementAmount[$arStoreElement['STORE_ID']] = $arStoreElement['AMOUNT'];

    }

    $arResult['STORES_ELEMENT'] = $rsStore = StoreTable::getList(array(
        'filter' => array('=ID' => $arStoreElementIDS),
        'select' => array('ID', 'TITLE', 'ADDRESS', 'SCHEDULE', '*')
    ))->fetchAll();

    if (!empty($arStoreElementAmount)) {

        $arResult['COUNT_STORES_ELEMENT'] = 0;

        foreach ($arStoreElementAmount as $arStoreAmountKey => $arStoreAmount) {
            foreach ($arResult['STORES_ELEMENT'] as $arStoreElementIndex => $arStoreElement) {

                if ($arStoreAmountKey == $arStoreElement['ID']) {
                    $arResult['STORES_ELEMENT'][$arStoreElementIndex]['AMOUNT'] = $arStoreAmount;

                    if ($arStoreAmount > 0) {
                        $arResult['COUNT_STORES_ELEMENT'] = $arResult['COUNT_STORES_ELEMENT'] + 1;
                    }

                }

            }
            
        }

        $arResult['COUNT_DISPLAY_STORES_ELEMENT'] = $arResult['COUNT_STORES_ELEMENT'] . " " . $shopsMeasory->get($arResult['COUNT_STORES_ELEMENT']);

    }

}

// Получаем ограничения по категориям платёжной системы
$dbRestriction = \Bitrix\Sale\Internals\ServiceRestrictionTable::getList(array(
    'select' => array('PARAMS'),
    'filter' => array(
        'SERVICE_ID' => PANYWAY_ID,
        'SERVICE_TYPE' => \Bitrix\Sale\Services\PaySystem\Restrictions\Manager::SERVICE_TYPE_PAYMENT
    )
));
$restrictions = array();
while ($restriction = $dbRestriction->fetch()) {
    if(is_array($restriction['PARAMS'])) {
        $restrictions = array_merge($restrictions,$restriction['PARAMS']);
    }
}

// Получаем все категории товара вплоть до основной
$productSections = getRootProductSection($arResult['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID']);

// Устанавливаем ограничение
$arResult['RESTRICTED_SECTION'] = 'Y';

// Снимаем ограничение, если хоть одна из категорий товара попадает под исключение
if (is_array($productSections) && is_array($restrictions['CATEGORIES']) && count($productSections) > 0) {
    foreach ($productSections as $section) {
        if (in_array($section['ID'], $restrictions['CATEGORIES'])) {
            unset($arResult['RESTRICTED_SECTION']);
            break;
        }
    }    
}