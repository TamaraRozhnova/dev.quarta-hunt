<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use General\Section;

$parentSectionId = $arResult['SECTION']['IBLOCK_SECTION_ID'];

if (!empty($parentSectionId)) {
    $parentSection = Section::getSection($parentSectionId, $arParams['SECTION_URL']);
    $arResult['BACK_URL'] = $parentSection['SECTION_PAGE_URL'];
}

if (empty($arResult['SECTIONS'])) {
    $arResult['SECTIONS'] = Section::getSubsections($parentSectionId, $arParams['SECTION_URL']);
}

