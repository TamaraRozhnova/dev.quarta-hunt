<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use Helpers\NumWordHelper;

DiscountsHelper::fillProductsWithBonuses($arResult['ITEMS']);

$resultCount = $arResult['NAV_RESULT']->NavRecordCount;
if ($resultCount > 0) {
    $arResult['COUNT'] = $resultCount;
    $arResult['DISPLAY_COUNT'] = NumWordHelper::getNumWord($resultCount, ['товар', 'товара', 'товаров']);
}