<?php

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

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
        $itemId = $row['data']['PRODUCT_ID'];

        $mxResult = CCatalogSku::GetProductInfo($itemId);
        if (is_array($mxResult))
        {
            $itemId = $mxResult['ID'];
        }

        $sections = CIBlockElement::GetElementGroups($itemId, true, ['ID', 'NAME']);
        if ($sections) {
            while ($section = $sections->Fetch()) {
                $rowSection = $section['NAME'];
            }
        }

        $row['data']['SECTION'] = $rowSection;

        if (!empty($row['data']['PROPS'])) {
            $entity = HL\HighloadBlockTable::compileEntity(HUT_OFFERS_COLOR_HL_CODE);
            $entityDataClass = $entity->getDataClass();

            foreach ($row['data']['PROPS'] as $key => &$prop) {
                if ($prop['CODE'] == 'COLOR') {
                    $rsData = $entityDataClass::getList([
                        'select' => ['UF_FILE'],
                        'order' => [],
                        'filter' => [
                            'UF_NAME' => $prop['VALUE']
                        ]
                    ]);

                    while($arData = $rsData->Fetch()){
                        if ($arData['UF_FILE']) {
                            $prop['COLOR_VALUE'] = CFile::GetPath($arData['UF_FILE']);
                        }
                    }
                }
            }
        }
    }
}