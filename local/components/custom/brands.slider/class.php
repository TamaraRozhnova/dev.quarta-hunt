<?php 

if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) {
    die();
}

use CBitrixComponent;
use Bitrix\Main\Loader;
use Bitrix\Iblock\Elements\ElementBrandsTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\PropertyEnumerationTable;

Loader::includeModule('iblock');

final class SliderBrands extends CBitrixComponent
{

    private array $arBrands;
    private array $arBrandProperty;
    private array $arPropsBrands;

    function getBrandsFromIblock()
    {
        $this->arBrands = ElementBrandsTable::getList([
            'select' => ['ID', 'NAME' , 'CODE', 'PREVIEW_PICTURE'],
            'filter' => ['=ACTIVE' => 'Y'],
            'cache' => [
                'ttl' => 3600
            ]
        ])->fetchAll();
    }

    function getBrandProperty()
    {
        $this->arBrandProperty = PropertyTable::getList([
            'select' => ['ID','CODE'],
            'filter' => [
                '=CODE' => 'BREND',
                '=IBLOCK_ID' => CATALOG_IBLOCK_ID
            ],
            'cache' => [
                'ttl' => 3600
            ]
        ])->fetch();
    }

    function getBrandsPropertiesCatalog()
    {
        $this->arPropsBrands = PropertyEnumerationTable::getList([
            'select' => ['*'],
            'filter' => [
                '=PROPERTY_ID' => $this->arBrandProperty['ID'],
            ],
            'cache' => [
                'ttl' => 3600
            ]
        ])->fetchAll();
    }

    function prepareBrands()
    {
        $arBrands = &$this->arBrands;

        foreach ($arBrands as $arBrandIndex => &$arBrand) {

            $currentBrand = &$arBrands[$arBrandIndex];

            $arBrand['IMAGE'] = CFile::ResizeImageGet(
                $arBrand['PREVIEW_PICTURE'],
                [
                    'width' => 150,
                    'height' => 40
                ],
                BX_RESIZE_IMAGE_PROPORTIONAL
            );

            foreach ($this->arPropsBrands as $arPropBrand) {

                if (
                    strtolower($arPropBrand['VALUE']) == strtolower($arBrand['NAME'])
                    ||
                    strtolower($arPropBrand['VALUE']) == strtolower($arBrand['CODE'])
                ) {
                    $currentBrand['FILTER_ID'] = $arPropBrand['ID'];
                }
            }

            if (empty($arBrand['FILTER_ID'])) {
                continue;
            }

            $this->arResult['BRANDS_FILTERS'][$arPropBrand['VALUE']] = "/brendy/" . $arPropBrand['ID'] . '/';
            $arBrand['URL'] = "/brendy/" . $arBrand['FILTER_ID'] . "/";

        }
    }
    
    function prepareResult()
    {

        $this->arResult['BRANDS_SLIDER_ITEMS'] = $this->arBrands;
        $this->arResult['BRANDS_SLIDER_PROPS'] = $this->arPropsBrands;
    }

    function executeComponent() 
    {
        $this->getBrandProperty();
        $this->getBrandsFromIblock();

        if (empty($this->arBrands)) {
            return false;
        }

        if (empty($this->arBrandProperty)) {
            return false;
        }

        $this->getBrandsPropertiesCatalog();

        $this->prepareBrands();
        $this->prepareResult();

        $this->IncludeComponentTemplate();
    }
}


