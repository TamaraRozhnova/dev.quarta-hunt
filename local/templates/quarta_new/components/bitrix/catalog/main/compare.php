<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

file_put_contents(
    __DIR__ . '/aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa.php',
    "<? \$param = " . var_export('fdf', true) . "?>\n"
);

$APPLICATION->AddChainItem('Сравнение');

$APPLICATION->IncludeComponent (
    "bitrix:catalog.compare.result",
    "kek",
    Array(
        "AJAX_MODE" => "Y",
        "NAME" => COMPARE_LIST_NAME,
        "FIELD_CODE" => array(),
        "PROPERTY_CODE" => array(),
        "OFFERS_FIELD_CODE" => array(),
        "OFFERS_PROPERTY_CODE" => array(),
        "ELEMENT_SORT_FIELD" => "sort",
        "ELEMENT_SORT_ORDER" => "asc",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "PRICE_CODE" => $arParams['PRICE_CODE'],
        "DISPLAY_ELEMENT_SELECT_BOX" => "Y",
        "ELEMENT_SORT_FIELD_BOX" => "name",
        "ELEMENT_SORT_ORDER_BOX" => "asc",
        "ELEMENT_SORT_FIELD_BOX2" => "id",
        "ELEMENT_SORT_ORDER_BOX2" => "desc",
        "HIDE_NOT_AVAILABLE" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_JUMP" => "Y",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "Y",
    )
);