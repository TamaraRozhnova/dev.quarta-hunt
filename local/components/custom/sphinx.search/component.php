<?php if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponent $this */
/** @var string $epilogFile */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $templateData */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Entity\ExpressionField as EF;
use Bitrix\Main\UI\PageNavigation;

use SearchSphinx\ProductTable;
use SearchSphinx\BlogTable;

use Helpers\Translit;

$objectNavigation = new PageNavigation('cur_page');

$objectNavigation->allowAllRecords(false)
    ->setPageSize(10)
    ->initFromUri();

$searchTarget = $_GET['q'];
$searchTarget = mb_strtolower(htmlspecialchars($searchTarget));

/** 
 * Параметры запроса для индексных таблиц Sphinx
 */
$rsParamsQuery = [
    'select' => [
        '*',
        new EF('weight', 'WEIGHT()', 'id'),
    ],
    'match' => $searchTarget,
    'count_total' => true,
    'offset' => $objectNavigation->getOffset(),
    'limit' => $objectNavigation->getLimit(),
    'order' => [
        'weight' => 'DESC',
    ],
    'option' => [
        'max_matches' => 50000,
    ],
];

/**
 * Запрос в таблицу товаров
 */
$rsProduct = ProductTable::getList(
    $rsParamsQuery
);

/**
 * Запрос в таблицу статей
 */
$rsBlog = BlogTable::getList(
    $rsParamsQuery
);

$tmpCountSearch = 0;
$tmpPageSize = 0;
$tmpArrCount = [
    'PRODUCT' => [],
    'BLOG' => []
];

$arResult['PRODUCTS'] = $rsProduct->fetchAll();

$tmpArrCount['PRODUCT'] = $rsProduct->getCount();

$arResult['BLOG'] = $rsBlog->fetchAll();
$arResult['SEARCH_TEXT'] = $searchTarget;

if (!empty($searchTarget)) {

    /** 
     * Делаем несколько запросов с разными транслитами слова
     * Сохраняем в результирующий массив
     */

    $modifyParamsQuery = $rsParamsQuery;


    $translitQueryRu = Translit::getTranslitRU($searchTarget);
    $simpleWord = Translit::getChangeSimpleWordRU($searchTarget);
    $advancedWord = Translit::getChangeAdvancedWordRU($searchTarget);
    $extendedWord = Translit::getChangeExtendedWordRU($searchTarget);

    if (
        $rsProduct->getCount() == 0
        ||
        $rsProduct->getCount() < 5
    ) {

        $modifyParamsQuery['match'] = $translitQueryRu;

        $rsProduct = ProductTable::getList(
            $modifyParamsQuery
        );

        $modifyParamsQuery['match'] =  $simpleWord;
        
        $rsProductSimple = ProductTable::getList(
            $modifyParamsQuery
        );

        $modifyParamsQuery['match'] =  $advancedWord;

        $rsProductAdvanced = ProductTable::getList(
            $modifyParamsQuery
        );

        $modifyParamsQuery['match'] =  $extendedWord;

        $rsProductExtended = ProductTable::getList(
            $modifyParamsQuery
        );

        $arProcessProducts = [
            $rsProduct,
            $rsProductSimple,
            $rsProductAdvanced,
            $rsProductExtended
        ];

        $arProducts = array_merge(
            $rsProduct->fetchAll(), 
            $rsProductSimple->fetchAll(), 
            $rsProductAdvanced->fetchAll(),
            $rsProductExtended->fetchAll()
        );

        $arResult['SEARCH_TEXT'] = $translitQueryRu;

        $arResult['PRODUCTS'] = $arProducts;

    }

    if (!empty($rsBlog)) {

        if ($rsBlog->getCount() == 0) {

            $rsBlog = BlogTable::getList(
                $modifyParamsQuery
            );

            if ($rsBlog->getCount() == 0) {
                $modifyParamsQuery['match'] = $translitQueryRu;

                $rsBlog = BlogTable::getList(
                    $modifyParamsQuery
                );
            }
    
            $arResult['BLOG'] = $rsBlog->fetchAll();
    
            if (!empty($arResult['BLOG'])) {
                $arResult['SEARCH_TEXT'] = $translitQueryRu;
            }
    
        }

    }

}

if (!empty($arProcessProducts)) {

    if (!is_array($tmpArrCount['PRODUCT'])) {
        $tmpArrCount['PRODUCT'] = (array) $tmpArrCount['PRODUCT'];
    }

    foreach ($arProcessProducts as $arProcessProduct) {
        if (!empty($arProcessProduct)) {

            if ($arProcessProduct->getCount() != 0) {

                array_push($tmpArrCount['PRODUCT'], $arProcessProduct->getCount());

            }
            
        }
    }
}

if (!empty($tmpArrCount['PRODUCT'])) {
    if (count($tmpArrCount['PRODUCT']) > 1 )  {
        $tmpArrCount['PRODUCT'] = array_sum(array_unique($tmpArrCount['PRODUCT']));
    }
}

if (!empty($rsBlog)) {
    $tmpArrCount['BLOG'] = $rsBlog->getCount();
}

$tmpCountSearch = array_sum($tmpArrCount);

if (!empty($tmpCountSearch)) {
    if ($tmpCountSearch > $objectNavigation->getPageSize()) {
        $tmpPageSize = $tmpCountSearch;
    }
}

$arResult['COUNT_SEARCH'] = $tmpCountSearch;
$arResult['OBJECT_NAVIGATION'] = $objectNavigation->setRecordCount($tmpPageSize);

$this->IncludeComponentTemplate();
