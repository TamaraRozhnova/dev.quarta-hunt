<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$sectionFilter = ['IBLOCK_ID' => CATALOG_IBLOCK_ID, 'ID' => $arParams['SECTION_ID']];

$sectionResource = CIBlockSection::GetList([], $sectionFilter);

while ($section = $sectionResource->GetNext()) {
    if ($section['DEPTH_LEVEL'] == 1) {
        $arResult['SECTION']['IS_PARENT'] = true;
    }
}

$brands = null;
$filters = [];

if (!$arResult['SECTION']['IS_PARENT']) {
    $unnecessaryFilterCodes = [
        'BREND',
        'PRICE',
        'CML2_MANUFACTURER',
        BASE_PRICE_CODE,
        OPT_PRICE_CODE
    ];

    foreach ($arResult['ITEMS'] as $filter) {
        if (in_array($filter['CODE'], $unnecessaryFilterCodes)) {
            continue;
        }
        if (!empty($filter['VALUES']) && count($filter['VALUES'])) {

				$filters['CHARACTERISTICS'][] =
					[
						'TITLE' => $filter['NAME'],
						'CHILDREN' => $filter['VALUES'],
						'CODE' => $filter['CODE']
					];

        }
    }
}

foreach ($arResult['ITEMS'] as $filter) {
    if ($filter['CODE'] === 'BREND') {
        $brands = $filter;
        break;
    }
}

if ($brands) {
    $filters['BRANDS'] =
        [
            'TITLE' => $brands['NAME'],
            'CHILDREN' => $brands['VALUES']
        ];
}

$arResult['FILTERS'] = $filters;
