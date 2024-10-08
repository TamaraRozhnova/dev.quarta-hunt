<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arCurrentSectionPath = getRootProductSection(
    $params['IBLOCK_ID'], 
    $result['VARIABLES']['SECTION_ID']
);

if (!empty($arCurrentSectionPath)) {
    $arIdsLicenseSections = array_column($arCurrentSectionPath, 'ID', 'ID');

    foreach (SECTIONS_ATTENTION_MODAL as $arLicenseSectionID) {

        if (!$arIdsLicenseSections[$arLicenseSectionID]) {
            continue;
        }

        /**
         * Вызываем модальное окно с подтверждением возраста,
         * в случае если в разделе нужно показать модальное окно
         */
        $APPLICATION->IncludeComponent(
            "custom:attention.age",
            "",
            []
        );

        break;
    }

}



if (!empty($GLOBALS['arrFilter'])) {
    $GLOBALS['arrFilter'] = array_merge($GLOBALS['arrFilter'], $params['PRICES']);
} else {
    $GLOBALS['arrFilter'] = $params['PRICES'];
}

if ($isAjax == 'Y') {
    $APPLICATION->ShowCSS();
}

if ($params["ELEMENT_COUNT"] == 9999) {
    $params["ELEMENT_COUNT"] = 500;
}

$APPLICATION->IncludeComponent(
    "bitrix:catalog.section",
    "main",
    [
        "AJAX_MODE" => $params["AJAX_MODE"],
        "IBLOCK_TYPE" => $params["IBLOCK_TYPE"],
        "IBLOCK_ID" => $params["IBLOCK_ID"],
        "ELEMENT_SORT_FIELD" => $params['ELEMENT_SORT_FIELD'],
        "ELEMENT_SORT_ORDER" => $params['ELEMENT_SORT_ORDER'],
        "ELEMENT_SORT_FIELD2" => $params['SORT_FIELD'],
        "ELEMENT_SORT_ORDER2" => $params['SORT_ORDER'],
        "PROPERTY_CODE" => $params["LIST_PROPERTY_CODE"],
        "META_KEYWORDS" => $params["LIST_META_KEYWORDS"],
        "META_DESCRIPTION" => $params["LIST_META_DESCRIPTION"],
        "BROWSER_TITLE" => $params["LIST_BROWSER_TITLE"],
        "INCLUDE_SUBSECTIONS" => $params["INCLUDE_SUBSECTIONS"],
        "BASKET_URL" => $params["BASKET_URL"],
        "ACTION_VARIABLE" => $params["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $params["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $params["SECTION_ID_VARIABLE"],
        "PRODUCT_QUANTITY_VARIABLE" => $params["PRODUCT_QUANTITY_VARIABLE"],
        "PRODUCT_PROPS_VARIABLE" => $params["PRODUCT_PROPS_VARIABLE"],
        "FILTER_NAME" => $params["FILTER_NAME"],
        "CACHE_TYPE" => $params["CACHE_TYPE"],
        "CACHE_TIME" => $params["CACHE_TIME"],
        "CACHE_FILTER" => $params["CACHE_FILTER"],
        "CACHE_GROUPS" => $params["CACHE_GROUPS"],
        "SET_TITLE" => $params["SET_TITLE"],
        "SET_STATUS_404" => $params["SET_STATUS_404"],
        "DISPLAY_COMPARE" => $params["USE_COMPARE"],
        "PAGE_ELEMENT_COUNT" => $params["ELEMENT_COUNT"],
        "LINE_ELEMENT_COUNT" => $params["LINE_ELEMENT_COUNT"],
        "PRICE_CODE" => $params["PRICE_CODE"],
        "USE_PRICE_COUNT" => $params["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $params["SHOW_PRICE_COUNT"],
        "ADD_SECTIONS_CHAIN" => 'N',
        "PRICE_VAT_INCLUDE" => $params["PRICE_VAT_INCLUDE"],
        "USE_PRODUCT_QUANTITY" => $params['USE_PRODUCT_QUANTITY'],
        "QUANTITY_FLOAT" => $params["QUANTITY_FLOAT"],
        "PRODUCT_PROPERTIES" => $params["PRODUCT_PROPERTIES"],
        "DISPLAY_TOP_PAGER" => $params["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $params["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $params["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => $params["PAGER_SHOW_ALWAYS"],
        "PAGER_TEMPLATE" => 'main',
        "PAGER_DESC_NUMBERING" => $params["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $params["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $params["PAGER_SHOW_ALL"],
        "OFFERS_CART_PROPERTIES" => $params["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $params["LIST_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $params["LIST_OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $params["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $params["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $params["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $params["OFFERS_SORT_ORDER2"],
        "OFFERS_LIMIT" => $params["LIST_OFFERS_LIMIT"],
        "SECTION_ID" => $result["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $result["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $result["FOLDER"] . $result["URL_TEMPLATES"]["section"],
        "SHOW_PRODUCT_TAGS_IN_SECTIONS" => $params["SHOW_PRODUCT_TAGS_IN_SECTIONS"],
        "SHOW_PRODUCT_TAGS_IN_RECOMMENDED" => $params["SHOW_PRODUCT_TAGS_IN_RECOMMENDED"],
        "DETAIL_URL" => $result["FOLDER"] . $result["URL_TEMPLATES"]["element"],
        'CONVERT_CURRENCY' => $params['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $params['CURRENCY_ID'],
        'HIDE_NOT_AVAILABLE' => $params["ONLY_AVAILABLE"],
        "HIDE_NOT_AVAILABLE_OFFERS" => $params["HIDE_NOT_AVAILABLE_OFFERS"],
        "COMPARE_NAME" => $params["COMPARE_NAME"],
        "USE_FILTER" => "Y",
        "COMPATIBLE_MODE" => "Y"
    ],
    $component
);

