<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;

DiscountsHelper::fillProductsWithBonuses($arResult['ITEMS']);