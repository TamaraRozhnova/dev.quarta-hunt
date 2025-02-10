<?php

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Localization\Loc;
use General\User;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var  $APPLICATION */
/** @var  $arResult */

IncludeTemplateLangFile(__FILE__);
?>

<?php

$arCatalogItemFilter = [];
$arNewsItemFilter = [];
$arSalesItemFilter = [];

foreach ($arResult["CATEGORIES"] as $categoryId => $arCategory) {

    foreach ($arCategory["ITEMS"] as $i => $arItem) {

        if ($arItem['PARAM1'] == '1c_catalog' && $arItem['PARAM2'] == 16) {
            $arCatalogItemFilter['ID'][] = $arItem['ITEM_ID'];
            $arCatalogItemFilter['CATEGORY'] = $categoryId;
        }
        if ($arItem['PARAM1'] == 'news') {
            $arNewsItemFilter['ID'][] = $arItem['ITEM_ID'];
            $arNewsItemFilter['CATEGORY'] = $categoryId;
        }
        if ($arItem['PARAM1'] == '1c_catalog' && $arItem['PARAM2'] == 37) {
            $arSalesItemFilter['ID'][] = $arItem['ITEM_ID'];
            $arSalesItemFilter['CATEGORY'] = $categoryId;
        }
    }
}


if (count($arCatalogItemFilter) > 0 || count($arNewsItemFilter) || count($arSalesItemFilter)): ?>
    <div class="search-tabs"><?php
        foreach ($arResult["CATEGORIES"] as $categoryId => $arCategory) {

            if ($categoryId == 'all') {
                continue ;
            }

            $categoryLink = '';
            switch ($arCategory['TITLE']) {
                case 'Каталог товаров':
                    $categoryLink = '/catalog';
                    break;
                case 'Блог':
                    $categoryLink = '/blog';
                    break;
                case 'Акции':
                    $categoryLink = '/promo';
                    break;
            }

            ?>
            <span data-tab="<?= $categoryId ?>" data-href="<?=$categoryLink?>" class="search-tabs-nav <?=($categoryId == 0) ? 'active' : ''?>"><?= $arCategory['TITLE'] ?></span>
        <?php } ?>
    </div><?php

    foreach ($arResult["CATEGORIES"] as $categoryId => $arCategory) { ?>
        <div class="search-tab-content <?=($categoryId == 0) ? 'active' : ''?>" data-tabcontent="<?= $categoryId ?>">
            <?php
            /* CATALOG */
            if (isset($arCatalogItemFilter['CATEGORY']) && $categoryId == $arCatalogItemFilter['CATEGORY']) {
                /* CATALOG */

                global $arrProductFilter;
                $arrProductFilter = [
                    '=ID' => $arCatalogItemFilter['ID']
                ];

                $user = new User();
                $priceCode = $user->getUserPriceCode();
                if (is_array($arCatalogItemFilter['ID']) && count($arCatalogItemFilter['ID']) > 0) {

                    $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "search_title",
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "-",
                            "BASKET_URL" => "/personal/cart/",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "N",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "N",
                            "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                            "DETAIL_URL" => "/catalog/products/#ELEMENT_CODE#/",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_COMPARE" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "CATALOG_AVAILABLE",
                            "ELEMENT_SORT_FIELD2" => "",
                            "ELEMENT_SORT_ORDER" => "DESC",
                            "ELEMENT_SORT_ORDER2" => "",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "arrProductFilter",
                            
                            /**
                             * Переопределяем параметры каталога по показу товаров
                             * Ставим параметры как у каталога
                             * 
                             * @see /catalog/index.php
                             */
                            "HIDE_NOT_AVAILABLE" => "L",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "Y",

                            "IBLOCK_ID" => "16",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "1",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_CART_PROPERTIES" => array(),
                            "OFFERS_FIELD_CODE" => array("", ""),
                            "OFFERS_LIMIT" => "100",
                            "OFFERS_PROPERTY_CODE" => array("CML2_ARTICLE", ""),
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_FIELD2" => "",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_ORDER2" => "",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "99",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => array($priceCode),
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPERTIES" => array(),
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE" => array(
                                0 => "CML2_ARTICLE",
                                1 => "ITS_CREDIT",
                                2 => "HIT",
                                3 => "NEW_PRODUCT",
                                4 => "DOUBLE_BONUS",
                                5 => "",),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_CODE" => "",
                            "SECTION_ID" => "",
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
                            "SECTION_USER_FIELDS" => array("", ""),
                            "SEF_MODE" => "N",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "N",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_PRODUCT_TAGS" => "Y",
                            "SHOW_SLIDER" => "Y",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "Y"
                        ),
                        false
                    );
                } else {
                    echo Loc::getMessage("AG_SMARTIK_NO_RESULT") . '1';
                }
                ?>

                <?php
                /* --- CATALOG --- */
            }
            /* --- CATALOG ---*/

            /* NEWS */
            if (isset($arNewsItemFilter['CATEGORY']) && $categoryId == $arNewsItemFilter['CATEGORY']) {
                global $arrNewsFilter;
                $arrNewsFilter = [
                    '=ID' => $arNewsItemFilter['ID']
                ];

                if (is_array($arNewsItemFilter['ID']) && count($arNewsItemFilter['ID']) > 0) {
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "modern_search_blog",
                        array(
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "N",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "N",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("", "*", ""),
                            "FILTER_NAME" => "arrNewsFilter",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => "1",
                            "IBLOCK_TYPE" => "news",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "4",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_TITLE" => "Новости",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PROPERTY_CODE" => array("", "*", ""),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "ACTIVE_FROM",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "SORT_ORDER2" => "ASC",
                            "STRICT_SECTION_CHECK" => "N"
                        ),
                        false
                    );
                } else {
                    echo Loc::getMessage("AG_SMARTIK_NO_RESULT") . '2';
                }
            }
            /* --- NEWS --- */

            /* SALES */
            if (isset($arSalesItemFilter['CATEGORY']) && $categoryId == $arSalesItemFilter['CATEGORY']) {
                global $arrSalesFilter;
                $arrSalesFilter = [
                    '=ID' => $arSalesItemFilter['ID']
                ];

                if (is_array($arSalesItemFilter['ID']) &&  count($arSalesItemFilter['ID']) > 0) {
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "modern_search_sales",
                        array(
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "N",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "N",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("", "*", ""),
                            "FILTER_NAME" => "arrSalesFilter",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => "37",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "4",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_TITLE" => "Новости",
                            "PARENT_SECTION" => "",
                            "PARENT_SECTION_CODE" => "",
                            "PREVIEW_TRUNCATE_LEN" => "",
                            "PROPERTY_CODE" => array("", "*", ""),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "ACTIVE_FROM",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "SORT_ORDER2" => "ASC",
                            "STRICT_SECTION_CHECK" => "N"
                        ),
                        false
                    );
                } else {
                    echo Loc::getMessage("AG_SMARTIK_NO_RESULT") . '3';
                }
            }
            /* --- SALES ---*/ ?>
        </div>
    <?php }

else:
    ?>
		<div class="bx_smart_no_result_find">
			<?=Loc::getMessage("AG_SMARTIK_NO_RESULT");?>
		</div>
    <?php
endif;
