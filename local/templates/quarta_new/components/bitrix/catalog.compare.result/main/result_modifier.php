<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Feedback\Review;
use Helpers\DiscountsHelper;

$review = new Review();

DiscountsHelper::fillProductsWithBonuses($arResult['ITEMS']);

$bannedProps = [
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
    'SIZE_DISCOUNT'
];

$productIds = [];
$lastValue = [];
$arResult['PROPS'] = [];
$arResult['DIFFERENT_PROP_KEYS'] = [];

foreach ($arResult['ITEMS'] as $item) {
    foreach ($item['PROPERTIES'] as $key => $property) {
        if (in_array($key, $bannedProps)) {
            continue;
        }
        if (!strlen($property['VALUE'])) {
            continue;
        }
        if (!array_key_exists($key, $arResult['PROPS'])) {
            $arResult['PROPS'][$key] = $property['NAME'];
        }
        if ($lastValue[$key] && !in_array($key, $arResult['DIFFERENT_PROP_KEYS']) && $lastValue[$key] != $property['VALUE']) {
            $arResult['DIFFERENT_PROP_KEYS'][] = $key;
        }
        $lastValue[$key] = $property['VALUE'];
    }
}

$arParams['HIDE_RATING'] = 'Y';