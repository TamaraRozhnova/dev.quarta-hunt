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

use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\UI\PageNavigation;

use SearchSphinx\ProductTable;
use SearchSphinx\BlogTable;

use Helpers\Translit;

$objectNavigation = new PageNavigation('cur_page');

$objectNavigation->allowAllRecords(false)
    ->setPageSize(10)
    ->initFromUri();


/** 
 * Параметры запроса для индексных таблиц Sphinx
 */
$rsParamsQuery = [
    'select' => [
        '*',
        new ExpressionField('weight', 'WEIGHT()', 'id'),
    ],
    'match' => $_GET['q'],
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


$arResult['PRODUCTS'] = $rsProduct->fetchAll();
$arResult['BLOG'] = $rsBlog->fetchAll();
$arResult['SEARCH_TEXT'] = htmlspecialchars($_GET['q']);


if (!empty($_GET['q'])) {

    /**
     * Если не найдено совпадений
     * в случае использования английской раскладки, то
     * транслитируем слово на русский язык,
     * и повторно делаем запрос
     */

    $translitQueryRu = Translit::getTranslitRU($_GET['q']);
    $modifyParamsQuery = $rsParamsQuery;
    
    $modifyParamsQuery['match'] = $translitQueryRu;

    if ($rsProduct->getCount() == 0) {
        
        $rsProduct = ProductTable::getList(
            $modifyParamsQuery
        );

        $arResult['SEARCH_TEXT'] = $translitQueryRu;

        $arResult['PRODUCTS'] = $rsProduct->fetchAll();

        if (!empty($arResult['PRODUCTS'])) {
            $arResult['SEARCH_TEXT'] = $translitQueryRu;
        }

    }

    if ($rsBlog->getCount() == 0) {

        $rsBlog = BlogTable::getList(
            $modifyParamsQuery
        );

        $arResult['BLOG'] = $rsBlog->fetchAll();

        if (!empty($arResult['BLOG'])) {
            $arResult['SEARCH_TEXT'] = $translitQueryRu;
        }

    }

}


$arResult['COUNT_SEARCH'] = $rsProduct->getCount() + $rsBlog->getCount();

/**
 * Если кол-во найденных совпадений у 
 * определенной таблицы больше
 * размера установленной страницы 
 * при помощи PageNavigation,
 * тогда добавляем их в пагинацию
 */

if ($rsProduct->getCount() > $objectNavigation->getPageSize()) {
    $tmpPageSize += $rsProduct->getCount();
}

if ($rsBlog->getCount() > $objectNavigation->getPageSize()) {
    $tmpPageSize += $rsBlog->getCount();
}

$arResult['OBJECT_NAVIGATION'] = $objectNavigation->setRecordCount($tmpPageSize);


$this->IncludeComponentTemplate();
