<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

Loader::includeModule("arturgolubev.smartsearch");
?>

<div class="category">
    <div class="container category__main">
        <div class="row">

            <?php
            $bx_search_limit = COption::GetOptionString('search', 'max_result_size', 999);
            $arElements = $APPLICATION->IncludeComponent(
                "arturgolubev:search.page",
                "catalog",
                array(
                    "RESTART" => $arParams["RESTART"],
                    "NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
                    "USE_LANGUAGE_GUESS" => $arParams["USE_LANGUAGE_GUESS"],
                    "CHECK_DATES" => $arParams["CHECK_DATES"],
                    "arrFILTER" => array("iblock_" . $arParams["IBLOCK_TYPE"]),
                    "arrFILTER_iblock_" . $arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
                    "USE_TITLE_RANK" => "Y",
                    "DEFAULT_SORT" => "rank",
                    "FILTER_NAME" => "",
                    "SHOW_WHERE" => "N",
                    "arrWHERE" => array(),
                    "SHOW_WHEN" => "N",
                    "PAGE_RESULT_COUNT" => $bx_search_limit,
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => "N",
                    "INPUT_PLACEHOLDER" => $arParams["INPUT_PLACEHOLDER"],
                    "SHOW_HISTORY" => $arParams["SHOW_HISTORY"],
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );


            if (!empty($arElements) && is_array($arElements)) {
                foreach ($arElements as $k => $v) {
                    if (substr($v, 0, 1) == 'S')
                        unset($arElements[$k]);
                }

                $arElements = array_values($arElements);


                if ($arParams["ELEMENT_SORT_FIELD"] == 'rank') {
                    $arParams["ELEMENT_SORT_FIELD"] = "ID";
                    $arParams["ELEMENT_SORT_ORDER"] = $arElements;
                }

                global $searchFilter;
                $searchFilter = array(
                    "ID" => $arElements,
                );

                ?>
                <div class="category category__filter-wrap"></div>

                <?php
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "search_page",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],

                        "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                        "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],

                        /* For search rank sort for bitrix 19.0.0+ */
                        // "ELEMENT_SORT_FIELD" => "ID",
                        // "ELEMENT_SORT_ORDER" => array_values($arElements),

                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],

                        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                        "PROPERTY_CODE" => $arParams["PROPERTY_CODE"],
                        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                        "OFFERS_FIELD_CODE" => $arParams["OFFERS_FIELD_CODE"],
                        "OFFERS_PROPERTY_CODE" => $arParams["OFFERS_PROPERTY_CODE"],
                        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                        "OFFERS_LIMIT" => $arParams["OFFERS_LIMIT"],
                        "SECTION_URL" => $arParams["SECTION_URL"],
                        "DETAIL_URL" => $arParams["DETAIL_URL"],
                        "BASKET_URL" => $arParams["BASKET_URL"],
                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                        "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
                        "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
                        "CURRENCY_ID" => $arParams["CURRENCY_ID"],
                        "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
                        "HIDE_NOT_AVAILABLE_OFFERS" => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
                        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                        "FILTER_NAME" => "searchFilter",
                        "SECTION_ID" => "",
                        "SECTION_CODE" => "",
                        "SECTION_USER_FIELDS" => array(),
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "META_KEYWORDS" => "",
                        "META_DESCRIPTION" => "",
                        "BROWSER_TITLE" => "",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "N",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "N",
                        "COMPATIBLE_MODE" => "Y",
                    ),
                    $arResult["THEME_COMPONENT"],
                    array('HIDE_ICONS' => 'Y')
                );
                ?>

                <?php

            } elseif (is_array($arElements)) {
                echo Loc::getMessage("CT_BCSE_NOT_FOUND");
            }
            ?>
        </div>
    </div>
</div>
