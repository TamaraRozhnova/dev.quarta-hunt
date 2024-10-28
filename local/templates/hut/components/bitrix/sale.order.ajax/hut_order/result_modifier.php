<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var SaleOrderAjax $component
 */

$arParams['SERVICES_IMAGES_SCALING'] = (string)($arParams['SERVICES_IMAGES_SCALING'] ?? 'adaptive');

$component = $this->__component;
$component::scaleImages($arResult['JS_DATA'], $arParams['SERVICES_IMAGES_SCALING']);

if (!empty($arResult['JS_DATA']['GRID']['ROWS'])) {
    foreach ($arResult['JS_DATA']['GRID']['ROWS'] as &$row) {
        $rowSection = null;
        $sections = CIBlockElement::GetElementGroups($row['data']['PRODUCT_ID'], true, ['ID', 'NAME']);
        if ($sections) {
            while ($section = $sections->Fetch()) {
                $rowSection = $section['NAME'];
            }
        }

        $row['data']['SECTION'] = $rowSection;
    }
}