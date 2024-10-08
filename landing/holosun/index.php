<?php

/** @var  $APPLICATION */

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Holosun');

CJSCore::Init(['jquery']);
?>

<?php $APPLICATION->IncludeComponent(
	"bitrix:news.detail", 
	"holosun", 
	array(
		"COMPONENT_TEMPLATE" => "holosun",
		"IBLOCK_TYPE" => "landings",
		"IBLOCK_ID" => "24",
		"ELEMENT_ID" => "21612",
		"ELEMENT_CODE" => "",
		"CHECK_DATES" => "Y",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "ABOUT_TITLE",
			1 => "ABOUT_TEXT_1",
			2 => "ABOUT_TEXT_2",
			3 => "REVIEW_DATE",
			4 => "REVIEW_TEXT",
			5 => "REVIEW_LINK",
			6 => "VIDEO_REVIEW_IMAGE_TEXT",
			7 => "VIDEO_REVIEW_LINK",
			8 => "VIDEO_REVIEW_TITLE",
			9 => "VIDEO_REVIEW_TEXT",
			10 => "DESCR_1_TITLE",
			11 => "DESCR_1_TEXT",
			12 => "CATALOG_SECTION_TITLE",
			13 => "CATALOG_LINK",
			14 => "DESCR_2_TITLE",
			15 => "DESCR_2_TEXT",
			16 => "DESCR_2_WARNING",
			17 => "DESCR_3_TITLE",
			18 => "DESCR_3_TEXT",
			19 => "DESCR_3_WARNING",
			20 => "ASSORT_TITLE",
			21 => "ASSORT_CLASS_1",
			22 => "ASSORT_CLASS_2",
			23 => "ASSORT_DESCR_1",
			24 => "ASSORT_DESCR_2",
			25 => "COND_TITLE",
			26 => "COND_DESCR",
			27 => "COND_BLOCK_TITLE",
			28 => "COND_BLOCK_DESCR",
			29 => "COND_BLOCK_LINK",
			30 => "",
		),
		"IBLOCK_URL" => "",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_CANONICAL_URL" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"USE_PERMISSIONS" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"USE_SHARE" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Страница",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"FILE_404" => ""
	),
	false
);?>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
