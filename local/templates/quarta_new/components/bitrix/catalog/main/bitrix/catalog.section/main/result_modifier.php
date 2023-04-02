<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;

DiscountsHelper::fillProductsWithBonuses($arResult['ITEMS']);

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
