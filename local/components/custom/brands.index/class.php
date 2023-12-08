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

    private array $arBrandProperty;
    private array $arPropsBrands;
    private array $arAlphabet;

    function getBrandProperty()
    {
        $this->arBrandProperty = PropertyTable::getList([
            'select' => ['ID','CODE'],
            'filter' => [
                '=ACTIVE' => 'Y',
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
        $arPropBrands = &$this->arPropsBrands;
        foreach ($arPropBrands as $arPropBrand) {
            $this->arResult['BRANDS_FILTERS'][$arPropBrand['VALUE']] = "/brendy/all/?cur={$arPropBrand['ID']}";
        }
    }

    function getSortedWords(&$array)
    {
        return ksort($array);
    }

    function mergeAlphabet($array, $key) 
    {
        return [$key => array_reduce($array, 'array_merge', [])];
    }

    function setAlphabet()
    {
        $alphabet = [];

        foreach ($this->arPropsBrands as $arBrand) {

            $begWordBrand = mb_strtoupper(mb_substr($arBrand['VALUE'], 0, 1));

            $categoryName = 'ENG_WORDS';

            if (preg_match("/[А-Яа-я]/", $begWordBrand)) {
                $categoryName = 'RUS_WORDS';
            }

            if (is_numeric($begWordBrand)) {
                $categoryName = 'NUMERIC';
            }

            $alphabet[$categoryName][$begWordBrand][$arBrand['VALUE']] = $arBrand['VALUE'];
        }

        if (!empty($alphabet['ENG_WORDS'])) {
            $this->getSortedWords($alphabet['ENG_WORDS']);
        }

        if (!empty($alphabet['RUS_WORDS'])) {
            $this->getSortedWords($alphabet['RUS_WORDS']);
        }

        $alphabet['RUS_WORDS'] = $this->mergeAlphabet($alphabet['RUS_WORDS'], 'А-Я');
        $alphabet['NUMERIC'] = $this->mergeAlphabet($alphabet['NUMERIC'], '0-9');

        $this->arAlphabet = $alphabet;
    }
    
    function prepareResult()
    {
        $this->arResult['BRANDS_ALPHABET'] = $this->arAlphabet;

        $merAlphabetMainWords = array_merge(
            $this->mergeAlphabet($this->arAlphabet['RUS_WORDS'], 'R') ?? [],
            $this->mergeAlphabet($this->arAlphabet['ENG_WORDS'], 'E') ?? [],
            $this->mergeAlphabet($this->arAlphabet['NUMERIC'], 'N') ?? [],
        );

        $this->arResult['BRANDS_SEARCH'] = $this->mergeAlphabet($merAlphabetMainWords, 'ALP_SEARCH');
    }

    function executeComponent() 
    {
        $this->getBrandProperty();

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


