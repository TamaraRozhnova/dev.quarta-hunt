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

use General\User;

$user = new User();
$userPriceCode = $user->getUserPriceCode();
$userPriceId = $user->getUserPriceId();

$objectNavigation = new PageNavigation('cur_page');

$objectNavigation->allowAllRecords(false)
    ->setPageSize(10)
    ->initFromUri();

$searchTarget = $_GET['q'];
$searchTarget = mb_strtolower(htmlspecialchars($searchTarget));

function sortMultiDimensionalArray(&$array, $sortKey, $direction = 'ASC') {
    usort($array, function($a, $b) use ($sortKey, $direction) {
        if ($a[$sortKey] == $b[$sortKey]) {
            return 0;
        }
        
        if ($direction == 'ASC') {
            return ($a[$sortKey] < $b[$sortKey]) ? -1 : 1;
        } else {
            return ($a[$sortKey] > $b[$sortKey]) ? -1 : 1;
        }
    });
}

/**
 * Параметры сортировки
 */

 $arResult['SORT_OPTIONS'] = [
    'name_alp' => 'названию в алфавитном порядке',
    'name_alp_rev' => 'названию в обратном алфавитном порядке',
    'price_asc' => 'возрастанию цены',
    'price_desc' => 'убыванию цены',
];

/**
 * Дефолтные значения для сортировок
 */

$priceCodeForSort = 'price_' . $userPriceId;

$sortExpressionsFieldsCatalog = [
    'revelance' => [
        'order' => [
            'weight' => 'DESC',
        ],
        'expression' => new ExpressionField('weight', 'WEIGHT()', 'id'),
    ],
    'name_alp' => [
        'order' => [
            'name' => 'ASC'
        ],
        'expression' => new ExpressionField('name', 'ORDER BY', 'name')
    ],
    'name_alp_rev' => [
        'order' => [
            'name' => 'DESC'
        ],
        'expression' => new ExpressionField('name', 'ORDER BY', 'name')
    ],
    'price_asc' => [
        'order' => [
            $priceCodeForSort => 'ASC'
        ],
        'expression' => new ExpressionField($priceCodeForSort, 'ORDER_BY', $priceCodeForSort),
    ],
    'price_desc' => [
        'order' => [
            $priceCodeForSort => 'DESC',
        ],
        'expression' => new ExpressionField($priceCodeForSort, 'ORDER_BY', $priceCodeForSort),
    ],
];

/**
 * Дефолтные значения сортировки
 */
$selectParamsEF = $sortExpressionsFieldsCatalog['revelance']['expression'];
$orderParamsEF = $sortExpressionsFieldsCatalog['revelance']['order'];

/**
 * Если установлена сортировка, меняем значения выборки
 */
if (!empty($_GET['sort'])) {
    $selectParamsEF = $sortExpressionsFieldsCatalog[$_GET['sort']]['expression'];
    $orderParamsEF = $sortExpressionsFieldsCatalog[$_GET['sort']]['order'];
}

/** 
 * Параметры запроса для индексных таблиц Sphinx
 */
$rsParamsQuery = [
    'select' => [
        '*',
        $selectParamsEF,
    ],
    'match' => $searchTarget,
    'count_total' => true,
    'order' => $orderParamsEF,
    'limit' => 1000,
    'option' => [
        'max_matches' => 50000,
    ],
];

$rsParamsQuerySimple = [
    'select' => [
        '*',
        new ExpressionField('weight', 'WEIGHT()', 'id'),
    ],
    'match' => $searchTarget,
    'count_total' => true,
    'limit' => 1000,
    'order' => [
        'weight' => 'DESC'
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
    $rsParamsQuerySimple
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
     * 
     * Реализовано для расширения области поиска 
     * с учетом разных стратегий транслитерации слова
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

        $rsProductStandart = ProductTable::getList(
            $modifyParamsQuery
        );

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
            $rsProductStandart,
            $rsProduct,
            $rsProductSimple,
            $rsProductAdvanced,
            $rsProductExtended
        ];

        $arProducts = array_merge(
            $rsProductStandart->fetchAll(),
            $rsProduct->fetchAll(), 
            $rsProductSimple->fetchAll(), 
            $rsProductAdvanced->fetchAll(),
            $rsProductExtended->fetchAll()
        );

        $arResult['SEARCH_TEXT'] = $searchTarget;
        $arResult['PRODUCTS'] = $arProducts;

    }

    if (!empty($rsBlog)) {

        if ($rsBlog->getCount() == 0) {

            $rsBlog = BlogTable::getList(
                $rsParamsQuerySimple
            );

            if ($rsBlog->getCount() == 0) {
                $rsParamsQuerySimple['match'] = $translitQueryRu;

                $rsBlog = BlogTable::getList(
                    $rsParamsQuerySimple
                );
            }
    
            $arResult['BLOG'] = $rsBlog->fetchAll();
    
            if (!empty($arResult['BLOG'])) {
                $arResult['SEARCH_TEXT'] = $searchTarget;
            }
    
        }

    }

}

/** Обход товаров для скрытия если не в наличии */
foreach ($arResult['PRODUCTS'] as &$arProduct) {

    if (intval($arProduct['has_stock']) == 0) {
        continue;
    }

    if (
        empty($arProduct['store_1'])
        &&
        empty($arProduct['store_2'])
        &&
        empty($arProduct['store_3'])
    ) {
        continue;
    }

    $arProduct['has_stock'] = match ($userPriceCode) {
        'BASE' => empty($arProduct['price_1']) ? 0 : 1,
        'OPT' => empty($arProduct['price_3']) ? 0 : 1,
    };

}

sortMultiDimensionalArray($arResult['PRODUCTS'], 'has_stock', 'DESC');

$arResult['PRODUCTS'] = array_slice(
    $arResult['PRODUCTS'],
    $objectNavigation->getOffset(),
    10
);

$arResult['BLOG'] = array_slice(
    $arResult['BLOG'],
    $objectNavigation->getOffset(),
    10
);

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
    if (is_array($tmpArrCount['PRODUCT']) && count($tmpArrCount['PRODUCT']) > 1 )  {
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

if (
    !empty($tmpArrCount['PRODUCT'])
    &&
    !empty($tmpArrCount['BLOG']) 
) {
    if (is_array($tmpArrCount['PRODUCT'])) {
        if (strlen($tmpArrCount['PRODUCT'][0]) === strlen($tmpArrCount['BLOG'])) {
            $tmpPageSize = $tmpArrCount['PRODUCT'] > $tmpArrCount['BLOG'] ? $tmpArrCount['PRODUCT'] : $tmpArrCount['BLOG'];
        }
    } else {
        if (strlen($tmpArrCount['PRODUCT']) === strlen($tmpArrCount['BLOG'])) {
            $tmpPageSize = $tmpArrCount['PRODUCT'] > $tmpArrCount['BLOG'] ? $tmpArrCount['PRODUCT'] : $tmpArrCount['BLOG'];
        }
    }    
}

$arResult['COUNT_PRODUCT'] = is_array($tmpArrCount['PRODUCT']) ? current($tmpArrCount['PRODUCT']) : $tmpArrCount['PRODUCT'];
$arResult['COUNT_SEARCH'] = $tmpCountSearch;
$arResult['OBJECT_NAVIGATION'] = $objectNavigation->setRecordCount($tmpPageSize);
$arResult['PAGE_SIZE'] = $objectNavigation->getPageSize();

$this->IncludeComponentTemplate();
