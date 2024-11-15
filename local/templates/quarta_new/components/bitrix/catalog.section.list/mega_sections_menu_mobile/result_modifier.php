<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['ITEMS'] = [];
$topLevelId = 0;
$secondLevelId = 0;

$saleData = \Bitrix\Iblock\Elements\ElementpromTable::getList([
    'select' => [
        'ID',
        'IBLOCK_ID',
        'CODE',
        'IBLOCK_SECTION_ID',
        'NAME',
        'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL',
        'PREVIEW_PICTURE',
        'PREVIEW_TEXT',
    ],
    'filter' => [
        "<=ACTIVE_FROM" => new \Bitrix\Main\Type\DateTime(),
        ">=ACTIVE_TO" => new \Bitrix\Main\Type\DateTime(),
        'ACTIVE' => 'Y'
    ],
    'order' => ['ID' => 'DESC']
])->fetchAll();

foreach ($saleData as &$sale) {
    if ($sale['PREVIEW_PICTURE']) {
        $sale['URL'] = CIBlock::ReplaceDetailUrl($sale['DETAIL_PAGE_URL'], $sale, false, 'E');
        $sale['IMAGE'] = CFile::ResizeImageGet(
            $sale['PREVIEW_PICTURE'],
            ['width' => 450, 'height' => 250],
            BX_RESIZE_IMAGE_PROPORTIONAL
        )['src'];
    }
}
unset($sale);

$arResult['SALE_DATA'] = $saleData;

foreach ($arResult['SECTIONS'] as $section) {
    $sectionData =
        [
            'NAME' => $section['NAME'],
            'LINK' => $section['LIST_PAGE_URL'] . $section['SECTION_PAGE_URL'],
            'SORT' => $section['SORT'],
            'ELEMENT_CNT' => $section['ELEMENT_CNT'],
            'ICON' => $section['UF_ICON'] ?
                CFile::ResizeImageGet(
                $section['UF_ICON'],
                ['width' => 25, 'height' => 25],
                BX_RESIZE_IMAGE_PROPORTIONAL
            )['src']
                :
                false,
        ];

    switch ($section['DEPTH_LEVEL']) {
        case 1:
            $arResult['ITEMS'][$section['ID']] = $sectionData;
            $topLevelId = $section['ID'];
            break;

        case 2:
            $arResult['ITEMS'][$topLevelId]['SUBSECTIONS'][$section['ID']] = $sectionData;
            $secondLevelId = $section['ID'];
            break;

        default:
            $arResult['ITEMS'][$topLevelId]['SUBSECTIONS'][$secondLevelId]['SUBSECTIONS'][$section['ID']] = $sectionData;
            break;
    }
}
