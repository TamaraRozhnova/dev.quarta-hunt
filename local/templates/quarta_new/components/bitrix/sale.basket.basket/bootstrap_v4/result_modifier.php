<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die;
}

/**
 * @var array $arParams
 * @var array $arResult
*/

if (
    $arResult &&
    $arResult['GRID'] &&
    $arResult['GRID']['ROWS']
) {
    $countLicenceProduct = 0;
    $arResult['COUNT_PRODUCTS'] = count($arResult['GRID']['ROWS']);

    foreach ($arResult['GRID']['ROWS'] as $basketId => $item) {
        $res = CIBlockElement::GetByID($item['PRODUCT_ID']);

        if ($element = $res->GetNext()) {
            $rsSection = CIBlockSection::GetList([],
                [
                    'ID' => $element['IBLOCK_SECTION_ID'],
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID
                ],
                false,
                [
                    'ID',
                    'UF_LISENCE_PRODUCTS'
                ]
            )->GetNext();

            if ($rsSection['UF_LISENCE_PRODUCTS'] == 1) {
                $countLicenceProduct++;
            }
        }
    }

    $arResult['COUNT_LICENCE_PRODUCTS'] = $countLicenceProduct;
}