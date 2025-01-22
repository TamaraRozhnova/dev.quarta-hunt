<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use Helpers\FileSizeHelper;
use General\User;
use Helpers\RecommendedProductsHelper;
use Helpers\VideoReviewsHelper;
use Bitrix\Main\Grid\Declension;
use Bitrix\Sale\Internals\ServiceRestrictionTable;
use Bitrix\Sale\Services\PaySystem\Restrictions\Manager;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Loader;
use Classes\DeliverySettings\DeliverySettings;

Loader::includeModule('currency');

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
    'SIZE_DISCOUNT',
    'ITS_CREDIT'
];

$arResult['FILES'] = [];
$arResult['PROPS'] = [];

$user = new User();
$priceCode = $user->getUserPriceCode();

if ($arResult['OFFERS'] && count($arResult['OFFERS']) > 0) {

    foreach ($arResult['OFFERS'] as $key => $offer) {

        if ($offer['PRICES'][reset($arParams['PRICE_CODE'])]['VALUE'] == 0) {
            $offer['CAN_BUY'] = false;
        }

        $iblockData = CIBlockElement::GetByID($offer['ID'])->Fetch();

        $arResult['OFFERS'][$key] = array_merge($arResult['OFFERS'][$key], $iblockData);

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


if (is_array($recommendedProductIds) && count($recommendedProductIds) > 0) {
    $arResult['RECOMMENDED_PRODUCTS'] = RecommendedProductsHelper::getRecommendedProducts($recommendedProductIds, $sectionId, 4, $arParams['DETAIL_URL']);
}

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
        'filter' => array('=ID' => $arStoreElementIDS, 'ACTIVE' => 'Y'),
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

// Получаем ограничения для сервиса через запрос к таблице ограничений
$dbRestriction = ServiceRestrictionTable::getList([
    'select' => ['PARAMS'],
    'filter' => [
        'SERVICE_ID' => UKASSA_CREDIT_ID,
        'SERVICE_TYPE' => Manager::SERVICE_TYPE_PAYMENT 
    ]
]);

// Инициализируем массив для сбора параметров ограничений
$restrictions = [];
// Перебираем результаты запроса
while ($restriction = $dbRestriction->fetch()) {
    if(is_array($restriction['PARAMS'])) {
        $restrictions = array_merge($restrictions, $restriction['PARAMS']);
    }
}

// Получаем все категории товара вплоть до основной
$productSections = getRootProductSection($arResult['IBLOCK_ID'], $arResult['IBLOCK_SECTION_ID']);

// Массив с разделами, где отображать надпись о лицензии
$sectionsLicense = $arParams['PRODUCTS_TEXT_LICENSE'];

// Снимаем ограничение, если хоть одна из категорий товара попадает под исключение
if (is_array($productSections) && count($productSections) > 0) {
    foreach ($productSections as $section) {
        if (in_array($section['ID'], $sectionsLicense)) {
            // Устанавливаем ограничение
            $arResult['RESTRICTED_SECTION'] = 'Y';
            break;
        }
    }    
}

// Для лицензионных товаров рассрочки не будет
if ($arResult['RESTRICTED_SECTION'] !== 'Y') {
    // Проверяем, есть ли категории в ограничениях
    if (!empty($restrictions['CATEGORIES'])) {
        if (is_array($productSections) && count($productSections) > 0) {
            foreach ($productSections as $section) {
                // Если ID раздела есть среди категорий ограничений
                if (in_array($section['ID'], $restrictions['CATEGORIES'])) {
                    $arResult['SHOW_CREDIT'] = 'Y'; // Показываем возможность кредитования

                    $productPrice = (float) $arResult['PRICES'][$priceCode]['VALUE'];
                    $countMonth = (float) 12;

                    $arResult['CREDIT_PRICE_PER_MONTH'] = round($productPrice / $countMonth);

                    $arResult['CREDIT_PRICE_PER_MONTH_FORMATTED'] = CCurrencyLang::CurrencyFormat(
                        $arResult['CREDIT_PRICE_PER_MONTH'], 
                        CurrencyManager::getBaseCurrency()
                    );

                    break;
                }
            }    
        }
    }
}

if ($arResult['AVAILABLE']) {
    $deliveryMethods = DeliverySettings::getDeliveryMethods($arResult['ID']);
}

/*
 * Поиск внешних ссылок в тексте
 * Добавление target="_blank"
 * Добавление rel="nofollow"
 */
preg_match_all('/<a(.*)>/U', $arResult['~DETAIL_TEXT'], $output_array);
if(!empty($output_array[0][0]))
    foreach ($output_array[0] AS $v){
        $new = $v;

        if(!stripos($v, 'http')){
            continue;
        }

        if(!stripos($v, '_blank')){
            $new = str_replace('href=', 'target="_blank" href=', $new);
        }
        if(!stripos($v, 'nofollow')){
            $new = str_replace('href=', 'rel="nofollow" href=', $new);
        }
        $arResult["~DETAIL_TEXT"] = str_replace($v, $new, $arResult["~DETAIL_TEXT"]);
    }

// Создаем изображение для превью соц.сетей
$image_social = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], array('width'=>'1200', 'height'=>'630'), BX_RESIZE_IMAGE_EXACT, true);
$arResult["DETAIL_PICTURE"]["SOCIAL"] = $image_social["src"];

// Передаем данные в результат после кеширования
$this->__component->SetResultCacheKeys(array(
    "DETAIL_PICTURE"
));