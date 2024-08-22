<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->IncludeComponent(
    "interlabs:oneclick",
    "one-click",
    Array(
        "AGREE_PROCESSING" => "N",
        "AJAX_MODE" => "Y",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "BUY_STRATEGY" => "OnlyProduct",
        "PRODUCT_ID" => $arResult['ID'],
        "USE_CAPTCHA" => "Y",
        "USE_FIELD_COMMENT" => "Y",
        "USE_FIELD_EMAIL" => "Y"
    )
);

$APPLICATION->IncludeComponent(
    "logictim:bonus.catalog",
    "element",
    Array(
        "CACHE_TYPE" => "N",
        "COMPONENT_TEMPLATE" => "element",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "ITEMS" => array("ITEMS"=>$arResult)
    ),
    $component
);