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

/*
if ($isAjax == 'Y') {
    // $APPLICATION->ShowCSS();
}
*/

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
        "PAGER_TEMPLATE" => 'main_v2',
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

/*
$APPLICATION->IncludeComponent("bitrix:catalog.section", "main", array(
    "IBLOCK_TYPE" => $params["IBLOCK_TYPE"],
    "IBLOCK_ID" => $params["IBLOCK_ID"],
    "ELEMENT_SORT_FIELD" => $params["ELEMENT_SORT_FIELD"],
    "ELEMENT_SORT_ORDER" => $params["ELEMENT_SORT_ORDER"],
    "ELEMENT_SORT_FIELD2" => $params["ELEMENT_SORT_FIELD2"],
    "ELEMENT_SORT_ORDER2" => $params["ELEMENT_SORT_ORDER2"],
    "PROPERTY_CODE" => (isset($params["LIST_PROPERTY_CODE"]) ? $params["LIST_PROPERTY_CODE"] : []),
    "PROPERTY_CODE_MOBILE" => $params["LIST_PROPERTY_CODE_MOBILE"],
    "META_KEYWORDS" => $params["LIST_META_KEYWORDS"],
    "META_DESCRIPTION" => $params["LIST_META_DESCRIPTION"],
    "BROWSER_TITLE" => $params["LIST_BROWSER_TITLE"],
    "SET_LAST_MODIFIED" => $params["SET_LAST_MODIFIED"],
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
    "MESSAGE_404" => $params["~MESSAGE_404"],
    "SET_STATUS_404" => $params["SET_STATUS_404"],
    "SHOW_404" => $params["SHOW_404"],
    "FILE_404" => $params["FILE_404"],
    "DISPLAY_COMPARE" => $params["USE_COMPARE"],
    "PAGE_ELEMENT_COUNT" => $params["PAGE_ELEMENT_COUNT"],
    "LINE_ELEMENT_COUNT" => $params["LINE_ELEMENT_COUNT"],
    "PRICE_CODE" => $params["~PRICE_CODE"],
    "USE_PRICE_COUNT" => $params["USE_PRICE_COUNT"],
    "SHOW_PRICE_COUNT" => $params["SHOW_PRICE_COUNT"],

    "PRICE_VAT_INCLUDE" => $params["PRICE_VAT_INCLUDE"],
    "USE_PRODUCT_QUANTITY" => $params['USE_PRODUCT_QUANTITY'],
    "ADD_PROPERTIES_TO_BASKET" => (isset($params["ADD_PROPERTIES_TO_BASKET"]) ? $params["ADD_PROPERTIES_TO_BASKET"] : ''),
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($params["PARTIAL_PRODUCT_PROPERTIES"]) ? $params["PARTIAL_PRODUCT_PROPERTIES"] : ''),
    "PRODUCT_PROPERTIES" => (isset($params["PRODUCT_PROPERTIES"]) ? $params["PRODUCT_PROPERTIES"] : []),

    "DISPLAY_TOP_PAGER" => $params["DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $params["DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $params["PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => $params["PAGER_SHOW_ALWAYS"],
    "PAGER_TEMPLATE" => $params["PAGER_TEMPLATE"],
    "PAGER_DESC_NUMBERING" => $params["PAGER_DESC_NUMBERING"],
    "PAGER_DESC_NUMBERING_CACHE_TIME" => $params["PAGER_DESC_NUMBERING_CACHE_TIME"],
    "PAGER_SHOW_ALL" => $params["PAGER_SHOW_ALL"],
    "PAGER_BASE_LINK_ENABLE" => $params["PAGER_BASE_LINK_ENABLE"],
    "PAGER_BASE_LINK" => $params["PAGER_BASE_LINK"],
    "PAGER_PARAMS_NAME" => $params["PAGER_PARAMS_NAME"],
    "LAZY_LOAD" => $params["LAZY_LOAD"],
    "MESS_BTN_LAZY_LOAD" => $params["~MESS_BTN_LAZY_LOAD"],
    "LOAD_ON_SCROLL" => $params["LOAD_ON_SCROLL"],

    "OFFERS_CART_PROPERTIES" => (isset($params["OFFERS_CART_PROPERTIES"]) ? $params["OFFERS_CART_PROPERTIES"] : []),
    "OFFERS_FIELD_CODE" => $params["LIST_OFFERS_FIELD_CODE"],
    "OFFERS_PROPERTY_CODE" => (isset($params["LIST_OFFERS_PROPERTY_CODE"]) ? $params["LIST_OFFERS_PROPERTY_CODE"] : []),
    "OFFERS_SORT_FIELD" => $params["OFFERS_SORT_FIELD"],
    "OFFERS_SORT_ORDER" => $params["OFFERS_SORT_ORDER"],
    "OFFERS_SORT_FIELD2" => $params["OFFERS_SORT_FIELD2"],
    "OFFERS_SORT_ORDER2" => $params["OFFERS_SORT_ORDER2"],
    "OFFERS_LIMIT" => (isset($params["LIST_OFFERS_LIMIT"]) ? $params["LIST_OFFERS_LIMIT"] : 0),

    "SECTION_ID" => $result["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $result["VARIABLES"]["SECTION_CODE"],
    "SECTION_URL" => $result["FOLDER"].$result["URL_TEMPLATES"]["section"],
    "DETAIL_URL" => $result["FOLDER"].$result["URL_TEMPLATES"]["element"],
    "USE_MAIN_ELEMENT_SECTION" => $params["USE_MAIN_ELEMENT_SECTION"],
    'CONVERT_CURRENCY' => $params['CONVERT_CURRENCY'],
    'CURRENCY_ID' => $params['CURRENCY_ID'],
    'HIDE_NOT_AVAILABLE' => $params["HIDE_NOT_AVAILABLE"],
    'HIDE_NOT_AVAILABLE_OFFERS' => $params["HIDE_NOT_AVAILABLE_OFFERS"],

    'LABEL_PROP' => $params['LABEL_PROP'],
    'LABEL_PROP_MOBILE' => $params['LABEL_PROP_MOBILE'],
    'LABEL_PROP_POSITION' => $params['LABEL_PROP_POSITION'],
    'ADD_PICT_PROP' => $params['ADD_PICT_PROP'],
    'PRODUCT_DISPLAY_MODE' => $params['PRODUCT_DISPLAY_MODE'],
    'PRODUCT_BLOCKS_ORDER' => $params['LIST_PRODUCT_BLOCKS_ORDER'],
    'PRODUCT_ROW_VARIANTS' => $params['LIST_PRODUCT_ROW_VARIANTS'],
    'ENLARGE_PRODUCT' => $params['LIST_ENLARGE_PRODUCT'],
    'ENLARGE_PROP' => isset($params['LIST_ENLARGE_PROP']) ? $params['LIST_ENLARGE_PROP'] : '',
    'SHOW_SLIDER' => $params['LIST_SHOW_SLIDER'],
    'SLIDER_INTERVAL' => isset($params['LIST_SLIDER_INTERVAL']) ? $params['LIST_SLIDER_INTERVAL'] : '',
    'SLIDER_PROGRESS' => isset($params['LIST_SLIDER_PROGRESS']) ? $params['LIST_SLIDER_PROGRESS'] : '',

    'OFFER_ADD_PICT_PROP' => $params['OFFER_ADD_PICT_PROP'],
    'OFFER_TREE_PROPS' => (isset($params['OFFER_TREE_PROPS']) ? $params['OFFER_TREE_PROPS'] : []),
    'PRODUCT_SUBSCRIPTION' => $params['PRODUCT_SUBSCRIPTION'],
    'SHOW_DISCOUNT_PERCENT' => $params['SHOW_DISCOUNT_PERCENT'],
    'DISCOUNT_PERCENT_POSITION' => $params['DISCOUNT_PERCENT_POSITION'],
    'SHOW_OLD_PRICE' => $params['SHOW_OLD_PRICE'],
    'SHOW_MAX_QUANTITY' => $params['SHOW_MAX_QUANTITY'],
    'MESS_SHOW_MAX_QUANTITY' => (isset($params['~MESS_SHOW_MAX_QUANTITY']) ? $params['~MESS_SHOW_MAX_QUANTITY'] : ''),
    'RELATIVE_QUANTITY_FACTOR' => (isset($params['RELATIVE_QUANTITY_FACTOR']) ? $params['RELATIVE_QUANTITY_FACTOR'] : ''),
    'MESS_RELATIVE_QUANTITY_MANY' => (isset($params['~MESS_RELATIVE_QUANTITY_MANY']) ? $params['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
    'MESS_RELATIVE_QUANTITY_FEW' => (isset($params['~MESS_RELATIVE_QUANTITY_FEW']) ? $params['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
    'MESS_BTN_BUY' => (isset($params['~MESS_BTN_BUY']) ? $params['~MESS_BTN_BUY'] : ''),
    'MESS_BTN_ADD_TO_BASKET' => (isset($params['~MESS_BTN_ADD_TO_BASKET']) ? $params['~MESS_BTN_ADD_TO_BASKET'] : ''),
    'MESS_BTN_SUBSCRIBE' => (isset($params['~MESS_BTN_SUBSCRIBE']) ? $params['~MESS_BTN_SUBSCRIBE'] : ''),
    'MESS_BTN_DETAIL' => (isset($params['~MESS_BTN_DETAIL']) ? $params['~MESS_BTN_DETAIL'] : ''),
    'MESS_NOT_AVAILABLE' => $params['~MESS_NOT_AVAILABLE'] ?? '',
    'MESS_NOT_AVAILABLE_SERVICE' => $params['~MESS_NOT_AVAILABLE_SERVICE'] ?? '',
    'MESS_BTN_COMPARE' => (isset($params['~MESS_BTN_COMPARE']) ? $params['~MESS_BTN_COMPARE'] : ''),

    'USE_ENHANCED_ECOMMERCE' => (isset($params['USE_ENHANCED_ECOMMERCE']) ? $params['USE_ENHANCED_ECOMMERCE'] : ''),
    'DATA_LAYER_NAME' => (isset($params['DATA_LAYER_NAME']) ? $params['DATA_LAYER_NAME'] : ''),
    'BRAND_PROPERTY' => (isset($params['BRAND_PROPERTY']) ? $params['BRAND_PROPERTY'] : ''),

    'TEMPLATE_THEME' => (isset($params['TEMPLATE_THEME']) ? $params['TEMPLATE_THEME'] : ''),
    "ADD_SECTIONS_CHAIN" => "N",
    'ADD_TO_BASKET_ACTION' => $basketAction,
    'SHOW_CLOSE_POPUP' => isset($params['COMMON_SHOW_CLOSE_POPUP']) ? $params['COMMON_SHOW_CLOSE_POPUP'] : '',
    'COMPARE_PATH' => $result['FOLDER'].$result['URL_TEMPLATES']['compare'],
    'COMPARE_NAME' => $params['COMPARE_NAME'],
    'USE_COMPARE_LIST' => 'Y',
    'BACKGROUND_IMAGE' => (isset($params['SECTION_BACKGROUND_IMAGE']) ? $params['SECTION_BACKGROUND_IMAGE'] : ''),
    'COMPATIBLE_MODE' => (isset($params['COMPATIBLE_MODE']) ? $params['COMPATIBLE_MODE'] : ''),
    'DISABLE_INIT_JS_IN_COMPONENT' => (isset($params['DISABLE_INIT_JS_IN_COMPONENT']) ? $params['DISABLE_INIT_JS_IN_COMPONENT'] : '')
),
$component
);
*/
