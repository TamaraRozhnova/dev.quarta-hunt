<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Iblock\Elements\ElementBrandsTable,
    \Bitrix\Iblock\Elements\ElementpromTable,
    \Bitrix\Main\Type\DateTime;

$arResult['ITEMS'] = [];
$topLevelId = 0;
$secondLevelId = 0;

/**
 * Получение акций
 */
$saleData = ElementpromTable::getList([
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
        "<=ACTIVE_FROM" => new DateTime(),
        ">=ACTIVE_TO" => new DateTime(),
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

$rsBrands = ElementBrandsTable::getList([
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

foreach ($rsBrands as &$arBrand) {

    if (empty($arBrand['PREVIEW_PICTURE'])) {
        continue;
    }

    $arBrand['URL'] = CIBlock::ReplaceDetailUrl($arBrand['DETAIL_PAGE_URL'], $arBrand, false, 'E');

    $arBrand['IMAGE'] = CFile::ResizeImageGet(
        $arBrand['PREVIEW_PICTURE'],
        ['width' => 250, 'height' => 70],
        BX_RESIZE_IMAGE_PROPORTIONAL
    )['src'];

}

/**
 * Переиндексация брендов
 * В качестве ключа выступает ID бренда
 */
$rsBrands = array_column($rsBrands, null, 'ID');

/**
 * Формирование ассоциативного массива
 * разделов с брендами и фильтрация пустых значений
 */
$arSectionsIDSWithBrands = array_filter(
    array_column($arResult['SECTIONS'], 'UF_BRAND_LINK', 'ID')
);

/**
 * Формирование дерева разделов
 */
$arBrandsJS = &$arResult['BRANDS_JS'];
foreach ($arResult['SECTIONS'] as $section) {

    $currentSectionID = $section['ID'];

    $sectionData = [
        'NAME' => $section['NAME'],
        'ID' => $section['ID'],
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

    /**
     * Если бренд привязан к разделу, то
     * формируем массив вида ID раздела => массив брендов
     */
    if (!empty($arSectionsIDSWithBrands[$currentSectionID])) {

        $arCurrentBrandsIDS = $arSectionsIDSWithBrands[$currentSectionID];
        foreach ($arCurrentBrandsIDS as $arBrandID) {
            $currentArBrand = $rsBrands[$arBrandID];
            $arBrandsJS[$section['ID']][$currentArBrand['ID']] = $currentArBrand;
        }

    }

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

function num_word($value, $words, $show = true)
{
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = ($show) ?  $value . ' ' : '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2:
        case 3:
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }

    return $out;
}
