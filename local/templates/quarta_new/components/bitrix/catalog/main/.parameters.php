<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Iblock\SectionTable;

$rsProducts = SectionTable::getList([
    'select' => [
        'ID', 'NAME'
    ],
    'order' => [
        'NAME' => 'ASC'
    ],
    'filter' => [
        '=IBLOCK_ID' => 16
    ],
    'cache' => [
        'ttl' => 360000000
    ]
])->fetchAll();


$arTemplateParameters = [
    'SHOW_PRODUCT_TAGS_IN_SECTIONS' => [
        'NAME' => 'Показывать тэги у товаров в разделах',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'PARENT' => 'BASE',
    ],
    'SHOW_PRODUCT_TAGS_IN_RECOMMENDED' => [
        'NAME' => 'Показывать тэги у рекомендованных товаров',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'PARENT' => 'BASE',
    ],

];

if (!empty($rsProducts)) {

    foreach ($rsProducts as $arProduct) {
        $preparedProductParams[$arProduct['ID']] = implode(' ', [
            "({$arProduct['ID']})",
            $arProduct['NAME']
        ]);
    }

    $arTemplateParameters += [
        "PRODUCTS_TEXT_LICENSE" => [
            "PARENT" => "SETTINGS",
            "NAME" => 'Отображать надпись о лицензионных товарах',
            "TYPE" => "LIST",
            "SIZE" => 8,
            "MULTIPLE" => "Y",
            "VALUES" => $preparedProductParams
        ]
    ];

}