<?php

/** @var  $APPLICATION */

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use General\User;

$APPLICATION->SetPageProperty("title", "Результаты поиска по сайту quarta-hunt.ru");

$APPLICATION->SetTitle("Результаты поиска по сайту quarta-hunt.ru");
$APPLICATION->AddChainItem('Результаты поиска');

$user = new User();
$priceCode = $user->getUserPriceCode();

$APPLICATION->IncludeComponent(
	"arturgolubev:catalog.search",
	"modern",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "1c_catalog",
		"IBLOCK_ID" => "16",
		"ELEMENT_SORT_FIELD" => "rank",
		"ELEMENT_SORT_ORDER" => "desc",
		"ELEMENT_SORT_FIELD2" => "CATALOG_AVAILABLE",
		"ELEMENT_SORT_ORDER2" => "desc",
		"HIDE_NOT_AVAILABLE" => "L",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"PAGE_ELEMENT_COUNT" => "20",
		"LINE_ELEMENT_COUNT" => "1",
        "PROPERTY_CODE" => array(
            0 => "CML2_ARTICLE",
            1 => "ITS_CREDIT",
            2 => "HIT",
            3 => "NEW_PRODUCT",
            4 => "DOUBLE_BONUS",
            ),
        "OFFERS_FIELD_CODE" => array("", ""),
        "OFFERS_PROPERTY_CODE" => array("CML2_ARTICLE", ""),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "100",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"DISPLAY_COMPARE" => "N",
        "PRICE_CODE" => [$priceCode],
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"USE_PRODUCT_QUANTITY" => "Y",
		"CONVERT_CURRENCY" => "N",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"CHECK_DATES" => "N",
		"USE_LANGUAGE_GUESS" => "Y",
		"INPUT_PLACEHOLDER" => "",
		"SHOW_HISTORY" => "N",
		"PAGER_TEMPLATE" => "main",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N"
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
