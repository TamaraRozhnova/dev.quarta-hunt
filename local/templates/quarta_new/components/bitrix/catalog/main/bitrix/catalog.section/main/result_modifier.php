<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Feedback\Reviews;
use General\User;
use Helpers\DiscountsHelper;
use Personal\Favorites;
use Personal\Basket;

$favorites = new Favorites();
$basket = new Basket();
$reviews = new Reviews();
$user = new User();

$arParams['FAVORITES'] = $favorites->getFavoritesIds();
$arParams['COMPARE_LIST'] = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'];
$arParams['BASKET_ITEMS'] = $basket->getProductsInBasket();

$isWholesaler = $user->isWholesaler();

$sectionsFilter = [
    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
    'IBLOCK_SECTION_ID' => $arResult['SECTION_ID']
];

$sectionWithBonus = false;
$sectionResource = CIBlockSection::GetList([], $sectionsFilter, false, ['UF_*']);

while ($section = $sectionResource->GetNext()) {
    if ($section['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $section['UF_DOUBLE_BONUS'] === '1') {
        $sectionWithBonus = true;
    }
}

$productIds = [];

foreach ($arResult['ITEMS'] as $index => $product) {
    if ($isWholesaler) {
        unset($arResult['ITEMS'][$index]['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
        unset($arResult['ITEMS'][$index]['PROPERTIES']['DOUBLE_BONUS']);
    } else {
        $arResult['ITEMS'][$index]['PRESENT'] = !empty(DiscountsHelper::getGiftIds($product['ID']));
    }
    if ($sectionWithBonus) {
        $arResult['ITEMS'][$index]['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';
    }

    $arResult['ITEMS'][$index]['PRICES'] = DiscountsHelper::getCorrectPrices($arResult['ITEMS'][$index]['PRICES']);
    $productIds[] = $product['ID'];
}

$arParams['REVIEWS'] = $reviews->getReviewsRatingForProducts($productIds);
