<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!CModule::IncludeModule("iblock")) {
    return;
}
/** @var array $arCurrentValues */

$typesEx = CIBlockParameters::GetIBlockTypes(["-" => " "]);

$iBlocks = [];
$filter = ['SITE_ID' => $_REQUEST['site'], 'TYPE' => ($arCurrentValues['IBLOCK_TYPE'] != "-" ? $arCurrentValues['IBLOCK_TYPE']: '')];
$resource = CIBlock::GetList(['SORT'=>"ASC"], $filter);

while ($arRes = $resource->Fetch()) {
    $iBlocks[$arRes['ID']] = "[".$arRes["ID"]."] ".$arRes['NAME'];
}

$arComponentParameters = [
    "PARAMETERS" => [
        "IBLOCK_TYPE" => [
            "PARENT" => "BASE",
            "NAME" => "Тип инфоблока",
            "VALUES" => $typesEx,
            "TYPE" => "LIST",
            "DEFAULT" => "userdata",
            "REFRESH" => "Y",
        ],
        "IBLOCK_ID" => [
            "PARENT" => "BASE",
            "NAME" => "Инфоблок",
            "TYPE" => "LIST",
            "VALUES" => $iBlocks,
            "DEFAULT" => "21",
            "REFRESH" => "Y",
        ],
        "DETAIL_URL" => [
            "PARENT" => "SEF_MODE",
            "NAME" => "Путь до детальной страницы товара",
            "TYPE" => "TEXT",
            "DEFAULT" => "/catalog/#ELEMENT_ID#/#ELEMENT_CODE#/"
        ]
    ]
];