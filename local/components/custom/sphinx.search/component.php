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

$objectNavigation = new PageNavigation('cur_page');

$objectNavigation->allowAllRecords(false)
    ->setPageSize(10)
    ->initFromUri();


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
 * Ищем товары в базе индексов 
 * */
$rsProduct = ProductTable::getList(
    $rsParamsQuery
);

/** 
 * Ищем статьи в базе индексов 
 * */
$rsBlog = BlogTable::getList(
    $rsParamsQuery
);


$arResult['COUNT_SEARCH'] = $rsProduct->getCount() + $rsBlog->getCount();

$arResult['OBJECT_NAVIGATION'] = $objectNavigation->setRecordCount($rsProduct->getCount() + $rsBlog->getCount());

$arResult['PRODUCTS'] = $rsProduct->fetchAll();
$arResult['BLOG'] = $rsBlog->fetchAll();



$this->IncludeComponentTemplate();
