<?php

use \Bitrix\Iblock\Elements\ElementHutMainCatalogTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

if (!empty($arResult['GRID']['ROWS'])) {
    $productsId = [];

    foreach ($arResult['GRID']['ROWS'] as $row) {
        $productsId[] = $row['PRODUCT_ID'];
    }

    if (!empty($productsId)) {

        foreach ($productsId as $key => $id) {
            $mxResult = CCatalogSku::GetProductInfo($id);

            if (is_array($mxResult)) {
                $productsId[$key] = $mxResult['ID'];
            }
        }

        $elems = ElementHutMainCatalogTable::getList([
            'select' => [
                'RECOMMENDED'
            ],
            'filter' => [
                'ACTIVE' => 'Y',
                'ID' => $productsId
            ]
        ])->fetchCollection();

        if ($elems) {
            $recomElemsId = [];
            foreach ($elems as $elem) {
                if ($elem->getRecommended() && $elem->getRecommended()->getAll()) {
                    foreach ($elem->getRecommended()->getAll() as $value) {
                        $recomElemsId[] = $value->getValue();
                    }
                }
            }

            $arResult['RECOMMENDED_PRODUCTS'] = $recomElemsId;
        }
    }
}