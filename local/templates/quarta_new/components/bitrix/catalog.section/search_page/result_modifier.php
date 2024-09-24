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
    'rating_asc' => 'по возрастанию рейтинга',
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


if (!empty($arResult['IBLOCK_SECTION_ID'])) {
    $arSections = [];
    $sectionId = $arResult['ID'];

    while($sectionId) {
        $arSection = \Bitrix\Iblock\SectionTable::getList([
            'filter' => ['IBLOCK_ID' => CATALOG_IBLOCK_ID, 'ID' => $sectionId],
            'select' => ['ID', 'IBLOCK_SECTION_ID', 'DESCRIPTION']
        ])->fetch();

        if (is_array($arSection) && count($arSection) > 0) {
            $arSections[] = $arSection;
            $sectionId = $arSection['IBLOCK_SECTION_ID'];
        } else {
            $sectionId = '';
        }
    }

    $arSections = array_reverse($arSections);

    if (!empty($arSections[0])) {
        $arResult['ROOT_SECTION_DESC'] = $arSections[0]['DESCRIPTION'];
    }
}
