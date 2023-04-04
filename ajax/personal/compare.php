<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

$_REQUEST["ajax_action"] = "Y";

if ($_GET['action'] === 'CLEAR') {
    unset($_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS']);
    echo json_encode(true);
    exit();
}

$APPLICATION->IncludeComponent(
    "bitrix:catalog.compare.list",
    "main",
    Array(
        "ACTION_VARIABLE" => "action",
        "AJAX_MODE" => "Y",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "COMPARE_URL" => "/catalog/compare/",
        "COMPONENT_TEMPLATE" => ".default",
        "DETAIL_URL" => "",
        "IBLOCK_ID" => "16",
        "IBLOCK_TYPE" => "1c_catalog",
        "NAME" => COMPARE_LIST_NAME,
        "POSITION" => "top left",
        "POSITION_FIXED" => "Y",
        "PRODUCT_ID_VARIABLE" => "id"
    )
);