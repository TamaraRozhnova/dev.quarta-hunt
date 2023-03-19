<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Helpers\ReviewsFilterHelper;

$APPLICATION->RestartBuffer();

$filterHelper = new ReviewsFilterHelper();
$filterParams = $filterHelper->getFilterParams();
$sortParams = $filterHelper->getSortParams();

$GLOBALS['arrFilterReviews'] = $filterParams;

$APPLICATION->IncludeComponent("bitrix:news.list", "product_reviews", Array(
    "ACTIVE_DATE_FORMAT" => "d.m.Y",
    "ADD_SECTIONS_CHAIN" => "N",
    "AJAX_MODE" => "Y",
    "AJAX_OPTION_ADDITIONAL" => "",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "CHECK_DATES" => "Y",
    "DETAIL_URL" => "",
    "DISPLAY_BOTTOM_PAGER" => "N",
    "DISPLAY_DATE" => "N",
    "DISPLAY_NAME" => "N",
    "DISPLAY_PICTURE" => "N",
    "DISPLAY_PREVIEW_TEXT" => "N",
    "DISPLAY_TOP_PAGER" => "N",
    "FIELD_CODE" => array(
        0 => "ID",
        1 => "CODE",
        2 => "NAME",
        3 => "IBLOCK_TYPE_ID",
        4 => "IBLOCK_ID",
        5 => "IBLOCK_CODE",
        6 => "IBLOCK_NAME",
        7 => "DATE_CREATE",
        8 => "CREATED_BY",
        9 => "CREATED_USER_NAME",
        10 => "",
    ),
    "FILTER_NAME" => "arrFilterReviews",
    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
    "IBLOCK_ID" => "11",
    "IBLOCK_TYPE" => "userdata",
    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
    "INCLUDE_SUBSECTIONS" => "N",
    "MESSAGE_404" => "",
    "NEWS_COUNT" => "10",
    "PAGER_BASE_LINK_ENABLE" => "N",
    "PAGER_DESC_NUMBERING" => "N",
    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
    "PAGER_SHOW_ALL" => "N",
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => ".default",
    "PAGER_TITLE" => "Новости",
    "PARENT_SECTION" => "",
    "PARENT_SECTION_CODE" => "",
    "PREVIEW_TRUNCATE_LEN" => "",
    "PROPERTY_CODE" => array(
        0 => "PRODUCT_ID",
        1 => "USER_ID",
        2 => "FLAWS",
        3 => "DIGNITIES",
        4 => "COMMENTS",
        5 => "IMAGES",
        6 => "RATING",
        7 => "LIKES",
        8 => "DISLIKES",
        9 => "RESPONSES",
        10 => "",
        11 => "",
    ),
    "SET_BROWSER_TITLE" => "N",
    "SET_LAST_MODIFIED" => "N",
    "SET_META_DESCRIPTION" => "N",
    "SET_META_KEYWORDS" => "N",
    "SET_STATUS_404" => "N",
    "SET_TITLE" => "N",
    "SHOW_404" => "N",
    "SORT_BY1" => $sortParams['SORT_FIELD'],
    "SORT_BY2" => "",
    "SORT_ORDER1" => $sortParams['SORT_ORDER'],
    "SORT_ORDER2" => "",
    "STRICT_SECTION_CHECK" => "N",
),
    false
);