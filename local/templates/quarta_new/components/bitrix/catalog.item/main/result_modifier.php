<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$item = $arResult['ITEM'];

$arResult['ITEM']['OFFERS_QUANTITY'] = 0;

if ($item['OFFERS'] && count($item['OFFERS']) > 0) {
    foreach ($item['OFFERS'] as $offer) {
        if ($offer['CAN_BUY']) {
            $arResult['ITEM']['AVAILABLE'] = true;
            $arResult['ITEM']['OFFERS_QUANTITY'] += (int)$offer['PRODUCT']['QUANTITY'];
        }
    }
} else {
    $arResult['ITEM']['AVAILABLE'] = boolval($item['CAN_BUY']);
}

if (in_array($item['ID'], $arResult['PARAMS']['FAVORITES'])) {
    $arResult['ITEM']['IN_FAVORITES'] = true;
}

if (array_key_exists($item['ID'], $arResult['PARAMS']['COMPARE_LIST'])) {
    $arResult['ITEM']['IN_COMPARE'] = true;
}

$arResult['ITEM']['QUANTITY_IN_BASKET'] = $arResult['PARAMS']['BASKET_ITEMS'][$item['ID']]['QUANTITY'] ?? 0;

$rating = $item['REVIEWS']['RATING'] ?? $arResult['PARAMS']['REVIEWS'][$item['ID']]['RATING'] ?? 0;

$maxStars = 5;
$roundedRating = round($rating);
$arResult['RATING']['FILL_STARS'] = floor($rating);
$arResult['RATING']['HALF_STAR'] = 0;
$fraction = $rating - floor($rating);

if ($roundedRating > $rating) {
    $arResult['RATING']['HALF_STAR'] = 1;
}

$arResult['RATING']['OUTLINE_STARS'] = $maxStars - $arResult['RATING']['FILL_STARS'] - $arResult['RATING']['HALF_STAR'];
