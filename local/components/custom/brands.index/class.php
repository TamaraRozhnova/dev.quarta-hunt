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

final class IndexBrands extends CBitrixComponent
{

    private array $arBrands;
    private array $arBrandProperty;
    private array $arPropsBrands;
    private array $arAlphabet;

    function getBrandsFromIblock()
    {
        $this->arBrands = ElementBrandsTable::getList([
            'select' => ['ID', 'NAME' , 'CODE', 'PREVIEW_PICTURE'],
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

            $arBrand['URL'] = "/brendy/all/?cur={$arBrand['FILTER_ID']}";

        }
    }

    function getSortedWords(&$array)
    {
        return ksort($array);
    }

    function setAlphabet()
    {
        $alphabet = [];

        foreach ($this->arPropsBrands as $arBrand) {

            $begWordBrand = mb_strtoupper(mb_substr($arBrand['VALUE'], 0, 1));

            if (preg_match("/[А-Яа-я]/", $arBrand['VALUE'][0])) {

                $alphabet['RUS_WORDS'][$begWordBrand][$arBrand['VALUE']] = $arBrand['VALUE'];

                continue;
            }

            if (is_numeric($begWordBrand)) {
                $alphabet['NUMERIC'][$begWordBrand][$arBrand['VALUE']] = $arBrand['VALUE'];

                continue;
            }

            $alphabet['ENG_WORDS'][$begWordBrand][$arBrand['VALUE']] = $arBrand['VALUE'];
        }

        if (!empty($alphabet['ENG_WORDS'])) {
            $this->getSortedWords($alphabet['ENG_WORDS']);
        }

        if (!empty($alphabet['RUS_WORDS'])) {
            $this->getSortedWords($alphabet['RUS_WORDS']);
        }

        $this->arAlphabet = $alphabet;
    }
    
    function prepareResult()
    {

        $this->arResult['BRANDS_SLIDER_ITEMS'] = $this->arBrands;
        $this->arResult['BRANDS_SLIDER_PROPS'] = $this->arPropsBrands;
        $this->arResult['BRANDS_SLIDER_ALPHABET'] = $this->arAlphabet;
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
        $this->setAlphabet();
        $this->prepareResult();

        $this->IncludeComponentTemplate();
    }
}


