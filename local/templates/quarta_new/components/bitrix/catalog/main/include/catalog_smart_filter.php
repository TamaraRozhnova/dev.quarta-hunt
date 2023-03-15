<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    "main",
    array(
        "AJAX_MODE" => "Y",
        "IBLOCK_TYPE" => $params["IBLOCK_TYPE"],
        "IBLOCK_ID" => $params["IBLOCK_ID"],
        "FILTER_NAME" => $params["FILTER_NAME"],
        "PRICE_CODE" => $params["~PRICE_CODE"],
        "CACHE_TYPE" => $params["CACHE_TYPE"],
        "CACHE_TIME" => $params["CACHE_TIME"],
        "CACHE_GROUPS" => $params["CACHE_GROUPS"],
        "SAVE_IN_SESSION" => "N",
        "FILTER_VIEW_MODE" => $params["FILTER_VIEW_MODE"],
        "SECTION_ID" => $currentSection,
        "SECTION_CODE" => $result['VARIABLES']['SECTION_CODE'],
        "SECTION_TITLE" => "NAME",
        "SECTION_DESCRIPTION" => "DESCRIPTION",
        'HIDE_NOT_AVAILABLE' => $params["HIDE_NOT_AVAILABLE"],
        "TEMPLATE_THEME" => $params["TEMPLATE_THEME"],
        'CONVERT_CURRENCY' => $params['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $params['CURRENCY_ID'],
        "SEF_MODE" => 'N',
        "PAGER_PARAMS_NAME" => "arrPager",
        "INSTANT_RELOAD" => "Y",
        "USE_FILTER" => "Y"
    ),
    $component,
    array('HIDE_ICONS' => 'Y')
);