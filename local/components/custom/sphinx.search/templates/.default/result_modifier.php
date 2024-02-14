<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */

use General\User;
use Bitrix\Main\Web\Json;

/** Тип цены пользователя */
$user = new User();
$priceCode = $user->getUserPriceCode();
$userPriceId = $user->getUserPriceId();

if ($arResult['COUNT_SEARCH'] == 0) {
	$searchTarget = $_GET['q'];

	$searchTarget = urlencode($searchTarget);
	$urlAPI = "https://speller.yandex.net/services/spellservice.json/checkText?text=".$searchTarget;

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $urlAPI);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$resultCheck = curl_exec($curl);
	$resultCheck = Json::decode($resultCheck, true);

	$arResult['CORRECT_TEXT'] = '';

	if (!empty($resultCheck)) {
		foreach ($resultCheck as $arWord) {
			if (!empty($arWord)) {
				foreach ($arWord['s'] as $arChainWordIndex => $arChainWord) {

					if ($arChainWordIndex > 0) {
						break;
					}

					$arResult['CORRECT_TEXT'] = implode(' ', [
						$arResult['CORRECT_TEXT'],
						$arChainWord
					]);
				}
			}
		}
	}

	if (!empty($arResult['CORRECT_TEXT'])) {
		$arResult['CORRECT_URL'] = $APPLICATION->GetCurPage().'?q='.trim($arResult['CORRECT_TEXT']);
	}

}

if ($arResult['COUNT_SEARCH'] > 0) {

    if (!empty($arResult['PRODUCTS'])) {

        foreach ($arResult['PRODUCTS'] as $arProduct) {
            $productsIds[$arProduct['id']] = $arProduct['id'];
        }

		array_reverse($productsIds, true);

        $GLOBALS['searchFilter'] = [
			'ID' => $productsIds,
		];

		switch ($_GET['sort']) {
			case 'price_asc':
				$sortField = "catalog_PRICE_" . $userPriceId;
				$sortDirection = 'ASC';
				break;
			case 'price_desc':
				$sortField = "catalog_PRICE_" . $userPriceId;
				$sortDirection = 'DESC';
				break;
			case 'name_alp':
				$sortField = "NAME";
				$sortDirection = 'ASC';
				break;
			case 'name_alp_rev':
				$sortField = "NAME";
				$sortDirection = 'DESC';
				break;
		}

        $arResult['PARAMS_CATALOG'] = [
			"ACTION_VARIABLE" => "action",
			"ADD_PICT_PROP" => "MORE_PHOTO",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"ADD_TO_BASKET_ACTION" => "ADD",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"BASKET_URL" => "/personal/basket.php",
			"BRAND_PROPERTY" => "BRAND_REF",
			"BROWSER_TITLE" => "-",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "N",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "N",
			"COMPATIBLE_MODE" => "Y",
			"CONVERT_CURRENCY" => "Y",
			"CURRENCY_ID" => "RUB",
			"CUSTOM_FILTER" => "",
			"DATA_LAYER_NAME" => "dataLayer",
			"DETAIL_URL" => "/catalog/#ELEMENT_ID#/#ELEMENT_CODE#/",
			"DISABLE_INIT_JS_IN_COMPONENT" => "N",
			"DISCOUNT_PERCENT_POSITION" => "bottom-right",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"DISPLAY_TOP_PAGER" => "N",
			"ELEMENT_SORT_FIELD" => $sortField ?? '',
			"ELEMENT_SORT_FIELD2" => "",
			"ELEMENT_SORT_ORDER" => $sortDirection ?? '',
			"ELEMENT_SORT_ORDER2" => "",
			"FILTER_NAME" => "searchFilter",
			"HIDE_NOT_AVAILABLE" => "L",
			"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
			"IBLOCK_ID" => CATALOG_IBLOCK_ID,
			"IBLOCK_TYPE" => "1c_catalog",
			"INCLUDE_SUBSECTIONS" => "Y",
			"LABEL_PROP" => array("NEWPRODUCT"),
			"LABEL_PROP_MOBILE" => array(),
			"LABEL_PROP_POSITION" => "top-left",
			"LAZY_LOAD" => "Y",
			"LINE_ELEMENT_COUNT" => "3",
			"LOAD_ON_SCROLL" => "N",
			"MESSAGE_404" => "",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_BTN_LAZY_LOAD" => "Показать ещё",
			"MESS_BTN_SUBSCRIBE" => "Подписаться",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"META_DESCRIPTION" => "-",
			"META_KEYWORDS" => "-",
			"OFFERS_CART_PROPERTIES" => array(""),
			"OFFERS_FIELD_CODE" => array(""),
			"OFFERS_LIMIT" => "5",
			"OFFERS_PROPERTY_CODE" => array(""),
			"OFFERS_SORT_FIELD" => "sort",
			"OFFERS_SORT_FIELD2" => "id",
			"OFFERS_SORT_ORDER" => "asc",
			"OFFERS_SORT_ORDER2" => "desc",
			"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
			"OFFER_TREE_PROPS" => array(""),
			"PAGER_BASE_LINK_ENABLE" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "search",
			"PAGER_TITLE" => "Товары",
			"PAGE_ELEMENT_COUNT" => "10",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRICE_CODE" => [$priceCode],
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
			"PRODUCT_DISPLAY_MODE" => "Y",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPERTIES" => array(""),
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "",
			"PRODUCT_ROW_VARIANTS" => "",
			"PRODUCT_SUBSCRIPTION" => "Y",
			"PROPERTY_CODE" => array("HIT"),
			"PROPERTY_CODE_MOBILE" => array(),
			"SECTION_CODE" => "",
			"SECTION_ID" => "",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SECTION_URL" => "",
			"SECTION_USER_FIELDS" => array("",""),
			"SHOW_PRODUCT_TAGS" => "Y",
			"SEF_MODE" => "N",
			"SET_BROWSER_TITLE" => "Y",
			"SET_LAST_MODIFIED" => "N",
			"SET_META_DESCRIPTION" => "Y",
			"SET_META_KEYWORDS" => "Y",
			"SET_STATUS_404" => "N",
			"SET_TITLE" => "Y",
			"SHOW_404" => "N",
			"SHOW_ALL_WO_SECTION" => "Y",
			"BY_LINK" => "Y",
			"SHOW_CLOSE_POPUP" => "N",
			"SHOW_DISCOUNT_PERCENT" => "Y",
			"SHOW_FROM_SECTION" => "N",
			"SHOW_MAX_QUANTITY" => "N",
			"SHOW_OLD_PRICE" => "Y",
			"SHOW_PRICE_COUNT" => "1",
			"USE_ENHANCED_ECOMMERCE" => "Y",
			"USE_MAIN_ELEMENT_SECTION" => "N",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "N"
		];
    }

    if (!empty($arResult['BLOG'])) {
        foreach ($arResult['BLOG'] as $arBlog) {
            $blogIds[$arBlog['id']] = $arBlog['id'];
        }

        $GLOBALS['searchFilterBlog'] = [
			'=ID' => $blogIds
		];

        $arResult['PARAMS_BLOG'] = [
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("NAME","PREVIEW_TEXT", "DETAIL_PAGE_URL"),
            "FILTER_NAME" => "searchFilterBlog",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => "1",
            "IBLOCK_TYPE" => "news",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "INCLUDE_SUBSECTIONS" => "Y",
            "MESSAGE_404" => "",
            "NEWS_COUNT" => "100",
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
            "PROPERTY_CODE" => array("",""),
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
            "STRICT_SECTION_CHECK" => "Y"
        ];
    }

}