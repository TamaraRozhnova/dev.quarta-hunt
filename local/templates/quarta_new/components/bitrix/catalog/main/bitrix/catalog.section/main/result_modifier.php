<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use Bitrix\Main\Application;

DiscountsHelper::fillProductsWithBonuses($arResult['ITEMS']);

$arResult['SORT_OPTIONS'] = [
    'relevante' => 'по релевантности',
    'available' => 'по наличию',
    'rating_asc' => 'по розрастанию рейтинга',
    'rating_desc' => 'по убыванию рейтинга',
    'discount_asc' => 'по возрастанию скидки',
    'discount_desc' => 'по убыванию скидки',
    'price_asc' => 'по возрастанию цены',
    'price_desc' => 'по убыванию цены',
    'alphabet_asc' => 'по алфавиту А-Я',
    'alphabet_desc' => 'по алфавиту Я-А',
];

$arResult['ELEMENT_COUNT_OPTIONS'] = [
    20 => '20',
    40 => '40',
    60 => '60',
    9999 => 'Показать все',
];

$arParams['MAX_ITEMS_PER_PAGE'] = 9999;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$arResult['CURRENT_SORT'] = $request->get("sort");