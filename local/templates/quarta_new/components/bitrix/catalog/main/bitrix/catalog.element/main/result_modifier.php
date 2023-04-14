<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use Helpers\FileSizeHelper;
use Helpers\RecommendedProductsHelper;
use Helpers\VideoReviewsHelper;

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
    'DOUBLE_BONUS'
];

$arResult['FILES'] = [];
$arResult['PROPS'] = [];

if ($arResult['OFFERS'] && count($arResult['OFFERS']) > 0) {
    foreach ($arResult['OFFERS'] as $key => $offer) {
        if ($offer['CAN_BUY']) {
            $arResult['AVAILABLE'] = true;
            $arResult['OFFERS_QUANTITY'] += (int)$offer['PRODUCT']['QUANTITY'];
        } else {
            unset($arResult['OFFERS'][$key]);
        }
    }
} else {
    $arResult['AVAILABLE'] = boolval($arResult['CAN_BUY']);
}

$arResult['PRICES_LIST'] = DiscountsHelper::getCorrectPrices($arResult);

foreach ($arResult['PROPERTIES']['FILES']['VALUE'] as $fileId) {
    $fileResource = CFile::GetByID($fileId);
    if ($file = $fileResource->GetNext()) {
        $arResult['FILES'][] = [
            'NAME' => $file['ORIGINAL_NAME'],
            'SIZE' => FileSizeHelper::getFormattedSize($file['FILE_SIZE']),
            'SRC' => $file['SRC']
        ];
    }
}

$arResult['IMAGES'][] = $arResult['DETAIL_PICTURE']['SRC'];

foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $value) {
    $arResult['IMAGES'][] = CFile::GetPath($value);
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