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

$sections = [];
$sectionIdsWithBonus = [];
$sectionsResource = CIBlockSection::GetList([], ['IBLOCK_ID' => CATALOG_IBLOCK_ID], false, ['UF_*']);

while ($section = $sectionsResource->GetNext()) {
    $sections[] = $section;
    if ($section['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $section['UF_DOUBLE_BONUS'] === '1') {
        $sectionIdsWithBonus[] = $section['ID'];
    }
}

foreach ($sections as $section) {
    if (in_array($section['IBLOCK_SECTION_ID'], $sectionIdsWithBonus)) {
        $sectionIdsWithBonus[] = $section['ID'];
    }
}

$productIds = [];

foreach ($arResult['ITEMS'] as $index => $product) {
    if ($isWholesaler) {
        unset($arResult['ITEMS'][$index]['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
        unset($arResult['ITEMS'][$index]['PROPERTIES']['DOUBLE_BONUS']);
    } else {
        $arResult['ITEMS'][$index]['PRESENT'] = !empty(DiscountsHelper::getGiftIds($product['ID']));
        if (in_array($product['IBLOCK_SECTION_ID'], $sectionIdsWithBonus)) {
            $arResult['ITEMS'][$index]['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';
        }
    }
    $arResult['ITEMS'][$index]['PRICES'] = DiscountsHelper::getCorrectPrices($product);
    $productIds[] = $product['ID'];
}

$arParams['REVIEWS'] = $reviews->getReviewsRatingForProducts($productIds);

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
