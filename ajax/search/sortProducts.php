<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Entity\ExpressionField;
use Bitrix\Main\UI\PageNavigation;

use SearchSphinx\ProductTable;
use SearchSphinx\BlogTable;

use Helpers\Translit;

use General\User;

$user = new User();
$userPriceId = $user->getUserPriceId();



/**
 * Получение request данных
 */
$requestBody = json_decode(file_get_contents('php://input'), true);
$paramsCatalog = $requestBody['params']['paramsCatalog'];
$sortCode = $requestBody['params']['sortCode'];
$searchTarget = $requestBody['params']['searchTarget'];
$searchPagination = $requestBody['params']['searchPagination'];
$searchPaginationLimit = $requestBody['params']['searchPaginationLimit'];

$objectNavigation = new PageNavigation('cur_page');

$objectNavigation->allowAllRecords(false)
    ->setPageSize($searchPaginationLimit)
    ->initFromUri();

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
            'weight' => 'DESC'
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
            $priceCodeForSort => 'DESC'
        ],
        'expression' => new ExpressionField($priceCodeForSort, 'ORDER_BY', $priceCodeForSort),
    ],
];

/**
 * Дефолтные значения сортировки
 */
$selectParamsEF = $sortExpressionsFieldsCatalog['revelance']['expression'];
$orderParanmsEF = $sortExpressionsFieldsCatalog['revelance']['order'];

/**
 * Если установлена сортировка, меняем значения выборки
 */

 $offsetParams = $objectNavigation->getOffset();

if (!empty($sortCode)) {
    $selectParamsEF = $sortExpressionsFieldsCatalog[$sortCode]['expression'];
    $orderParanmsEF = $sortExpressionsFieldsCatalog[$sortCode]['order'];

    if (!empty($searchTarget)) {
        if (
            $searchTarget != 'page-1'
            &&
            is_numeric(substr($searchPagination, -1))
        ) {
            $offsetParams = ( (int) substr($searchPagination, -1) * (int) $objectNavigation->getLimit() ) - (int) $objectNavigation->getLimit();
        }
    }

}

/** 
 * Параметры запроса для индексных таблиц Sphinx
 */

$rsParamsQuery = [
    'select' => [
        '*',
        $selectParamsEF
    ],
    'match' => $searchTarget,
    'count_total' => true,
    'offset' => $offsetParams,
    'limit' => $objectNavigation->getLimit(),
    'order' => $orderParanmsEF,
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

$tmpCountSearch = 0;
$tmpPageSize = 0;
$tmpArrCount = [
    'PRODUCT' => [],
];

$arResult['PRODUCTS'] = $rsProduct->fetchAll();
$tmpArrCount['PRODUCT'] = $rsProduct->getCount();
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

}

foreach ($arResult['PRODUCTS'] as $arProduct) {
    $productsIds[$arProduct['id']] = $arProduct['id'];
}

$GLOBALS['searchFilter'] = [
    '=ID' => $productsIds,
];

switch ($sortCode) {
    case 'price_asc':
        $paramsCatalog['ELEMENT_SORT_FIELD'] = 'catalog_PRICE_' . $userPriceId;
        $paramsCatalog['ELEMENT_SORT_ORDER'] = 'ASC';
        break;
    case 'price_desc':
        $paramsCatalog['ELEMENT_SORT_FIELD'] = 'catalog_PRICE_' . $userPriceId;
        $paramsCatalog['ELEMENT_SORT_ORDER'] = 'DESC';
        break;
    case 'name_alp':
        $paramsCatalog['ELEMENT_SORT_FIELD'] = 'NAME';
        $paramsCatalog['ELEMENT_SORT_ORDER'] = 'ASC';
        break;
    case 'name_alp_rev':
        $paramsCatalog['ELEMENT_SORT_FIELD'] = 'NAME';
        $paramsCatalog['ELEMENT_SORT_ORDER'] = 'DESC';
        break;
}

$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "new_search",
    $paramsCatalog
);
