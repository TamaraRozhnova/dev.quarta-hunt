<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['ITEMS'] = [];
$topLevelId = 0;
$secondLevelId = 0;

$brandData = \Bitrix\Iblock\Elements\ElementBrandsTable::getList([
    'select' => [
        'ID',
        'IBLOCK_ID',
        'CODE',
        'IBLOCK_SECTION_ID',
        'NAME',
        'DETAIL_PAGE_URL' => 'IBLOCK.DETAIL_PAGE_URL',
        'PREVIEW_PICTURE'
        ],
    'filter' => ['ACTIVE' => 'Y'],
    'order' => ['SORT' => 'ASC']
])->fetchAll();

foreach ($brandData as &$brand) {
    if ($brand['PREVIEW_PICTURE']) {
        $brand['URL'] = CIBlock::ReplaceDetailUrl($brand['DETAIL_PAGE_URL'], $brand, false, 'E');
        $brand['IMAGE'] = CFile::ResizeImageGet(
            $brand['PREVIEW_PICTURE'],
            ['width' => 250, 'height' => 70],
            BX_RESIZE_IMAGE_PROPORTIONAL
        )['src'];
    }
}
unset($brand);

$arResult['BRAND_DATA'] = $brandData;

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