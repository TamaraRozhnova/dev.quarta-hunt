<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Iblock\SectionTable;

Loader::includeModule('iblock');

$parentSectionId = $arResult['SECTION']['IBLOCK_SECTION_ID'];

if ($arResult['SECTION']['DEPTH_LEVEL'] == 1) {
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
            'order' => ['NAME' => 'ASC'],
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
} else {
    $rsSection = SectionTable::getList([
        'order' => ['NAME' => 'ASC'],
        'filter' => [
            'IBLOCK_ID' => HUT_CATALOG_IBLOCK_ID,
            'IBLOCK_SECTION_ID' => $arResult['SECTION']['PATH'][0]['ID'],
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

    $arResult['SECTIONS'] = [];

    while ($arSection = $rsSection->fetch()) {
        $arSection['SECTION_PAGE_URL'] = CIBlock::ReplaceDetailUrl($arSection['IBLOCK_SECTION_PAGE_URL'], $arSection, true, 'S');
        $arResult['SECTIONS'][] = $arSection;
    }

    $arResult['SECTION']['NAME'] = $arResult['SECTION']['PATH'][0]['NAME'];
    $arResult['ALL_URL'] = $arResult['SECTION']['PATH'][0]['SECTION_PAGE_URL'];
}
