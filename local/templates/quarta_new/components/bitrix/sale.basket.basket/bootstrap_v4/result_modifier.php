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
    $haveLicenceProducts = false;

    foreach ($arResult['GRID']['ROWS'] as $basketId => $item) {
        foreach ($list as $arSectionPath){
            echo '<pre>';print_r($arSectionPath);echo '</pre>';
        }

        $res = CIBlockElement::GetByID($item['PRODUCT_ID']);

        if ($element = $res->GetNext()) {
            $sectionsList = CIBlockSection::GetNavChain(CATALOG_IBLOCK_ID, $element['IBLOCK_SECTION_ID'], ['ID'], true);

            if (!empty($sectionsList)) {
                foreach ($sectionsList as $section) {
                    $rsSection = CIBlockSection::GetList([],
                        [
                            'ID' => $section['ID'],
                            'IBLOCK_ID' => CATALOG_IBLOCK_ID
                        ],
                        false,
                        [
                            'ID',
                            'UF_LISENCE_PRODUCTS'
                        ]
                    )->GetNext();

                    if ($rsSection['UF_LISENCE_PRODUCTS'] == 1) {
                        $haveLicenceProducts = true;
                        break;
                    }
                }
            }
        }
    }

    $arResult['HAVE_LICENCE_PRODUCTS'] = $haveLicenceProducts;
}