<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Iblock\SectionTable;

Loader::includeModule('iblock');

$parentSectionId = $arResult['SECTION']['IBLOCK_SECTION_ID'];

if (!empty($parentSectionId)) {
    $rsSection = SectionTable::getList([
        'filter' => [
            'IBLOCK_ID' => HUT_CATALOG_IBLOCK_ID,
            'ID' => $parentSectionId,
        ],
        'select' =>  [
            'ID',
            'NAME',
            'IBLOCK_ID',
            'CODE',
            'IBLOCK_SECTION_ID',
            'IBLOCK_SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL',
        ],
    ]);

    while ($arSection = $rsSection->fetch()) {
        $arResult['ALL_URL'] = CIBlock::ReplaceDetailUrl($arSection['IBLOCK_SECTION_PAGE_URL'], $arSection, true, 'S');
    }
}

if (empty($arResult['SECTIONS'])) {
    $rsSection = SectionTable::getList([
        'filter' => [
            'IBLOCK_ID' => HUT_CATALOG_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $parentSectionId,
        ],
        'select' =>  [
            'ID',
            'NAME',
            'IBLOCK_ID',
            'CODE',
            'IBLOCK_SECTION_ID',
            'IBLOCK_SECTION_PAGE_URL' => 'IBLOCK.SECTION_PAGE_URL',
        ],
    ]);

    while ($arSection = $rsSection->fetch()) {
        $arSection['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arSection['IBLOCK_SECTION_PAGE_URL'], $arSection, true, 'S');
        $arResult['SECTIONS'][] = $arSection;
    }
}
