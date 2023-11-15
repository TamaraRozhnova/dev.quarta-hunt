<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use General\User;

$item = $arResult['ITEM'];

$arResult['ITEM']['OFFERS_QUANTITY'] = 0;

$user = new User();
$priceCode = $user->getUserPriceCode();

if (is_array($item['OFFERS']) && !empty($item['OFFERS']) && count($item['OFFERS']) > 0) {

    foreach ($item['OFFERS'] as $offer) {

        if (!empty($offer['PRICES'][$priceCode])) {
            if ($offer['PRICES'][$priceCode]['VALUE'] == 0) {
                $offer['CAN_BUY'] = false;
            } 
        }

        if ($offer['CAN_BUY'] == true) {
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
