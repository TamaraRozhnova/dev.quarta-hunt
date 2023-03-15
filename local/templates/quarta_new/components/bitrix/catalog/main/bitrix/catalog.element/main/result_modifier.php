<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use General\Products;
use Helpers\DiscountsHelper;
use Personal\Basket;
use Personal\Favorites;

$productsInstance = new Products();
$favorites = new Favorites();
$basket = new Basket();

$recommendedProductIds = $arResult['PROPERTIES']['BUY_WITH_THIS']['VALUE'];

if (!$recommendedProductIds) {
    $recommendedProductIds = [];
}

$sectionId = $arResult['IBLOCK_SECTION_ID'];

$arResult['RECOMMENDED_PRODUCTS'] = $productsInstance->getRecommendedProducts($recommendedProductIds, $sectionId);

$arParams['FAVORITES'] = $favorites->getFavoritesIds();
$arParams['COMPARE_LIST'] = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'];
$arParams['BASKET_ITEMS'] = $basket->getProductsInBasket();

DiscountsHelper::fillProductsWithBonuses($arResult['RECOMMENDED_PRODUCTS']);