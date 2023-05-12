<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['ITEMS'] = [];
$topLevelId = 0;
$secondLevelId = 0;

foreach ($arResult['SECTIONS'] as $section) {
    $sectionData =
        [
            'NAME' => $section['NAME'],
            'LINK' => $section['LIST_PAGE_URL'] . $section['SECTION_PAGE_URL'],
            'SORT' => $section['SORT']
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