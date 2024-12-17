<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Интернет магазин товаров для охоты, стрельбы и активного отдыха в Quarta «Оружейный квартал»");
$APPLICATION->SetPageProperty("title", "Товары для охоты, стрельбы и активного отдыха в Quarta «Оружейный квартал»");

$APPLICATION->SetTitle("Товары для охоты, стрельбы и активного отдыха в Quarta «Оружейный квартал»"); ?>

<h1 class="hidden-on-page unset-margin">
	<?= $APPLICATION->ShowTitle(); ?>
</h1>

<? $APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"main_slider",
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => [
			0 => "ID",
			1 => "CODE",
			2 => "NAME",
			3 => "PREVIEW_TEXT",
			4 => "PREVIEW_PICTURE",
			5 => "DETAIL_TEXT",
			6 => "DETAIL_PICTURE",
			7 => "IBLOCK_TYPE_ID",
			8 => "IBLOCK_ID",
			9 => "IBLOCK_CODE",
			10 => "IBLOCK_NAME",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "35",
		"IBLOCK_TYPE" => "sliders",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "880",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => [
			0 => "DESCRIPTION",
			1 => "LINK",
		],
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "",
		"STRICT_SECTION_CHECK" => "N",
		"COMPACT" => "N"
	],
	false
);

/* $APPLICATION->IncludeComponent(
	"custom:brands.slider", 
	"", 
	[]
); */

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"section_list",
	[
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "Y",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
		"FILTER_NAME" => "sectionsFilter",
		"IBLOCK_ID" => "16",
		"IBLOCK_TYPE" => "1c_catalog",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => [
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "SORT",
			5 => "DESCRIPTION",
			6 => "PICTURE",
			7 => "DETAIL_PICTURE",
			8 => "IBLOCK_TYPE_ID",
			9 => "IBLOCK_ID",
			10 => "IBLOCK_CODE",
			11 => "IBLOCK_EXTERNAL_ID",
			12 => "",
		],
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "/catalog/#SECTION_CODE_PATH#/",
		"SECTION_USER_FIELDS" => [
			0 => "",
			1 => "",
		],
		"SHOW_PARENT_NAME" => "N",
		"TOP_DEPTH" => isset($_REQUEST["DEPTH"]) ? $_REQUEST["DEPTH"] : 1,
		"VIEW_MODE" => "LIST",
	],
	false
);

$GLOBALS['arrPromotionsFilter'] = ['>=DATE_ACTIVE_TO' => date('d.m.Y H:i:s')];

global $USER;

$itsUrFace = false;
$itsPrivatePerson = false;
$itsGuest = !$USER->IsAuthorized();

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

if ($arUser && $arUser['UF_TYPE'] == 'wholesale') {
	$itsUrFace = true;
} else if ($arUser && $arUser['UF_TYPE'] == 'retail') {
	$itsPrivatePerson = true;
}

if ($itsUrFace) {
	$GLOBALS['arrPromotionsFilter']['!PROPERTY_HIDE_ON_UR_VALUE'] = 'Y';
} else if ($itsPrivatePerson) {
	$GLOBALS['arrPromotionsFilter']['!PROPERTY_HIDE_ON_PRIVATE_PERSON_VALUE'] = 'Y';
}

if ($itsGuest) {
	$GLOBALS['arrPromotionsFilter']['!PROPERTY_HIDE_ON_GUEST_VALUE'] = 'Y';
}

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"promotions",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
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
			3 => "SORT",
			4 => "PREVIEW_TEXT",
			5 => "PREVIEW_PICTURE",
			6 => "DETAIL_TEXT",
			7 => "DETAIL_PICTURE",
			8 => "DATE_ACTIVE_FROM",
			9 => "ACTIVE_FROM",
			10 => "DATE_ACTIVE_TO",
			11 => "ACTIVE_TO",
			12 => "IBLOCK_TYPE_ID",
			13 => "IBLOCK_ID",
			14 => "IBLOCK_CODE",
			15 => "IBLOCK_NAME",
			16 => "",
		),
		"FILTER_NAME" => "arrPromotionsFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "37",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "3",
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
			0 => "DESCRIPTION",
			1 => "TEXT_COLOR",
			2 => "MOB_IMAGE_PREVIEW",
			3 => "MOB_IMAGE_DETAIL",
			4 => "",
		),
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
		"STRICT_SECTION_CHECK" => "N",
		"MAIN_BANNER_NEWS_ID" => "4950",
		"ARRIVAL_NEWS_IDS" => "21597,21598",
		"COMPONENT_TEMPLATE" => "promotions"
	),
	false
);

$APPLICATION->IncludeComponent(
	"custom:products.promotion.main",
	"",
	array()
);

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"about_benefits",
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
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
		"FIELD_CODE" => [
			0 => "ID",
			1 => "CODE",
			2 => "NAME",
			3 => "PREVIEW_TEXT",
			4 => "PREVIEW_PICTURE",
			5 => "DETAIL_TEXT",
			6 => "DETAIL_PICTURE",
			7 => "IBLOCK_TYPE_ID",
			8 => "IBLOCK_ID",
			9 => "IBLOCK_CODE",
			10 => "IBLOCK_NAME",
			11 => "",
		],
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "about",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "238",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => [
			0 => "",
			1 => "",
		],
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "",
		"STRICT_SECTION_CHECK" => "N",
	],
	false
);


$GLOBALS['arrYoutubePromotionFilter'] = ['ID' => 36820];

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"youtube.promotion",
	array(
		"COMPONENT_TEMPLATE" => "youtube.promotion",
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "13",
		"NEWS_COUNT" => "1",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arrYoutubePromotionFilter",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "BANNER_TITLE",
			1 => "BANNER_TEXT",
			2 => "BANNER_TEXT_COLOR",
			3 => "BANNER_LINK",
			4 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);

$GLOBALS['arrFilterNews'] = [];

if ($itsUrFace) {
	$GLOBALS['arrFilterNews']['!PROPERTY_HIDE_ON_UR_VALUE'] = 'Y';
} else if ($itsPrivatePerson) {
	$GLOBALS['arrFilterNews']['!PROPERTY_HIDE_ON_PRIVATE_PERSON_VALUE'] = 'Y';
}

if ($itsGuest) {
	$GLOBALS['arrFilterNews']['!PROPERTY_HIDE_ON_GUEST_VALUE'] = 'Y';
}

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"news_slider",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
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
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "PREVIEW_TEXT",
			6 => "PREVIEW_PICTURE",
			7 => "DETAIL_TEXT",
			8 => "DETAIL_PICTURE",
			9 => "DATE_ACTIVE_FROM",
			10 => "ACTIVE_FROM",
			11 => "DATE_ACTIVE_TO",
			12 => "ACTIVE_TO",
			13 => "IBLOCK_TYPE_ID",
			14 => "IBLOCK_ID",
			15 => "IBLOCK_CODE",
			16 => "IBLOCK_NAME",
			17 => "",
		),
		"FILTER_NAME" => "arrFilterNews",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "3",
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
			0 => "TYPE",
			1 => "MOB_IMAGE_PREVIEW",
			2 => "MOB_IMAGE_DETAIL",
			3 => "",
		),
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
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "news_slider"
	),
	false
);

$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"subscribe_form",
	[
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => "1",
		"LIST_URL" => $APPLICATION->GetCurPage(),
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "3600000",
		"VARIABLE_ALIASES" => [],
		"AJAX_MODE" => "Y"
	]
);


?>
<div class="hidden-on-page unset-margin" itemscope itemtype="http://schema.org/Organization">
	<span itemprop="name">Quarta «Оружейный квартал»</span>

	<link itemprop="url" href="https://quarta-hunt.ru/">
	<link itemprop="image" href="https://quarta-hunt.ru/local/templates/quarta_new/assets/images/logo.svg">
	Контакты:
	<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		Адрес:
		<span itemprop="streetAddress">Московский проспект, д.222А</span>
		<span itemprop="postalCode">196066</span>
		<span itemprop="addressRegion">г. Санкт-Петербург</span>,
		<span itemprop="addressLocality">г. Санкт-Петербург</span>,
		<span itemprop="addressCountry">RU</span>,
	</div>
	Телефон:<span itemprop="telephone">8 (800) 775-03-04</span>,
	Электронная почта: <span itemprop="email">shop@quarta-hunt.ru</span>
</div>
<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
