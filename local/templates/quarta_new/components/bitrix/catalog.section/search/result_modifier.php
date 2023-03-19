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
