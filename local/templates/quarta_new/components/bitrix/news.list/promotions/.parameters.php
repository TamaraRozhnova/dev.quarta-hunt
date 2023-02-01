<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arTemplateParameters = [
    "MAIN_BANNER_NEWS_ID" => [
        "NAME" => "Идентификатор новости для главного баннера",
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "PARENT" => "BASE",
    ],
    "ARRIVAL_NEWS_IDS" => [
        "NAME" => "Идентификаторы новостей для блока новых поступлений",
        "TYPE" => "STRING",
        "DEFAULT" => [],
        "PARENT" => "BASE",
    ],
    "DISPLAY_DATE" => [
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ],
    "DISPLAY_NAME" => [
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ],
    "DISPLAY_PICTURE" => [
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ],
    "DISPLAY_PREVIEW_TEXT" => [
        "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y",
    ]
];