<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Feedback\Review;
use General\RecommendedProducts;
use Helpers\DiscountsHelper;
use Helpers\FileSizeHelper;
use Helpers\VideoReviewsHelper;
use Personal\Basket;
use Personal\Favorites;

$recommendedProducts = new RecommendedProducts();
$reviewsInstance = new Review();
$favorites = new Favorites();
$basket = new Basket();

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

$basketItems = $basket->getProductsInBasket(false);

if ($arResult['OFFERS'] && count($arResult['OFFERS']) > 0) {
    foreach ($arResult['OFFERS'] as $key => $offer) {
        if ($offer['CAN_BUY']) {
            $arResult['AVAILABLE'] = true;
            $arResult['OFFERS_QUANTITY'] += (int)$offer['PRODUCT']['QUANTITY'];
            $arResult['OFFERS'][$key]['QUANTITY_IN_BASKET'] = $basketItems[$offer['ID']]['QUANTITY'] ?? 0;
        }
    }
} else {
    $arResult['AVAILABLE'] = boolval($arResult['CAN_BUY']);
}

$arResult['QUANTITY_IN_BASKET'] = $basketItems[$arResult['ID']]['QUANTITY'] ?? 0;
$arResult['PRICES'] = DiscountsHelper::getCorrectPrices($arResult);

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

$arResult['RECOMMENDED_PRODUCTS'] = $recommendedProducts->getRecommendedProducts($recommendedProductIds, $sectionId, 4, $arParams['DETAIL_URL']);

$arResult['VIDEO_REVIEWS'] = VideoReviewsHelper::getVideoReviews($arResult['SECTION']['ID']);

$favoritesIds = $favorites->getFavoritesIds();
$compareListIds = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'];

if (in_array($arResult['ID'], $favoritesIds)) {
    $arResult['IN_FAVORITES'] = true;
}
if (array_key_exists($arResult['ID'], $compareListIds)) {
    $arResult['IN_COMPARE'] = true;
}

DiscountsHelper::fillProductWithBonuses($arResult);

$reviewsRatings = $reviewsInstance->getReviewsRatingAndCountForProducts([$arResult['ID']]);
$arResult['REVIEWS']['COUNT'] = $reviewsRatings[$arResult['ID']]['COUNT'] ?? 0;
$rating = $reviewsRatings[$arResult['ID']]['RATING'];
$arResult['REVIEWS']['RATING'] = $rating;
$maxStars = 5;
$arResult['RATING']['MAX_STARS'] = $maxStars;
$roundedRating = round($rating);
$arResult['RATING']['FILL_STARS'] = floor($rating);
$arResult['RATING']['HALF_STAR'] = 0;
$fraction = $rating - floor($rating);

if ($roundedRating > $rating) {
    $arResult['RATING']['HALF_STAR'] = 1;
}

$arResult['RATING']['OUTLINE_STARS'] = $maxStars - $arResult['RATING']['FILL_STARS'] - $arResult['RATING']['HALF_STAR'];