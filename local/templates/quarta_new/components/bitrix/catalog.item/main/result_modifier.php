<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;

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

if (!$item['PRICES_LIST']) {
    $arResult['ITEM']['PRICES_LIST'] = DiscountsHelper::getCorrectPrices($item);
}
