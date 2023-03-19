<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Feedback\Review;
use Helpers\DiscountsHelper;
use Personal\Favorites;
use Personal\Basket;

$favorites = new Favorites();
$basket = new Basket();
$reviews = new Review();

$arParams['FAVORITES'] = $favorites->getFavoritesIds();
$arParams['COMPARE_LIST'] = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'];
$arParams['BASKET_ITEMS'] = $basket->getProductsInBasket();

$productIds = [];

DiscountsHelper::fillProductsWithBonuses($arResult['ITEMS']);

foreach ($arResult['ITEMS'] as $index => $product) {
    $arResult['ITEMS'][$index]['PRICES'] = DiscountsHelper::getCorrectPrices($product);
    $productIds[] = $product['ID'];
}

$arParams['REVIEWS'] = $reviews->getReviewsRatingAndCountForProducts($productIds);

$arResult['SORT_OPTIONS'] = [
    'cheaper' => 'дешевле',
    'expensive' => 'дороже',
];

if ($arParams['ELEMENT_SORT_FIELD2'] === 'SCALED_PRICE_1') {
    if ($arParams['ELEMENT_SORT_ORDER2'] === 'ASC') {
        $arResult['SORT_VALUE'] = 'cheaper';
    } else {
        $arResult['SORT_VALUE'] = 'expensive';
    }
}

$arResult['ELEMENT_COUNT_OPTIONS'] = [
    20 => '20',
    40 => '40',
    60 => '60',
    9999 => 'Показать все',
];

$arParams['MAX_ITEMS_PER_PAGE'] = 9999;
