<?php

use Bitrix\Main\Entity\ExpressionField;
use SearchSphinx\ProductTable;

/**
 * Дефолтные значения для сортировок
 */

 $sortExpressionsFields = [
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
            'name' => 'ASC'
        ],
        'expression' => new ExpressionField('name', 'ORDER BY', 'name')
    ],
    'price_desc' => [
        'order' => [
            'name' => 'ASC'
        ],
        'expression' => new ExpressionField('name', 'ORDER BY', 'name')
    ],

];

/**
 * Дефолтные значения сортировки
 */
$selectParamsEF = $sortExpressionsFields['revelance']['expression'];
$orderParanmsEF = $sortExpressionsFields['revelance']['order'];

/**
 * Если установлена сортировка, меняем значения выборки
 */
if (!empty($_GET['sort'])) {
    $selectParamsEF = $sortExpressionsFields[$_GET['sort']]['expression'];
    $orderParanmsEF = $sortExpressionsFields[$_GET['sort']]['order'];
}