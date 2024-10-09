<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Helpers\IblockHelper;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$this->setFrameMode(true);

$this->SetViewTarget('catalog_banner'); ?>
<div class="catalog__banner-wrap" style="background-image:url('<?= CFile::getPath($arResult['IBLOCK_UF_PROPS']['UF_BACK']) ?>')">
	<div class=" catalog__banner-inner container">
		<div class="catalog__banner-img-wrap">
			<img width="620" class="catalog__banner-img" src="<?= CFile::getPath($arResult['IBLOCK_UF_PROPS']['UF_IMG']) ?>" alt="">
		</div>
		<div class="catalog__banner-bottom">
			<div class="catalog__banner-left">
				<div class="catalog__banner-bread">
					<a href="/" class="catalog__banner-bread-link">Главная</a>
					<span class="catalog__banner-bread-delimiter">/</span>
					<span class="catalog__banner-bread-text">Каталог</span>
				</div>
				<div class="catalob__banner-title">Каталог</div>
			</div>
			<div class="catalog__banner-right">
				<ul class="catalog__banner-doing-list">
					<? foreach ($arResult['DOING_SECTIONS'] as $doing) { ?>
						<li class="catalog__banner-doing-item">
							<a href="<?= $doing['SECTION_PAGE_URL'] ?>">
								<img width="92" src="<?= CFile::GetPath($doing['PICTURE']) ?>" alt="">
								<span><?= $doing['NAME'] ?></span>
							</a>
						</li>
					<? } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<? $this->EndViewTarget();

if (!empty($arResult['IBLOCK_UF_PROPS']['UF_CATALOG_START'])) {
	foreach ($arResult['IBLOCK_UF_PROPS']['UF_CATALOG_START'] as $sectionId) {
		$APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			"main-catalog-page",
			array(
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"ADD_PICT_PROP" => $arParams['ADD_PICT_PROP'] ?? '',
				"ADD_PROPERTIES_TO_BASKET" => ($arParams["ADD_PROPERTIES_TO_BASKET"] ?? ''),
				"ADD_SECTIONS_CHAIN" => 'N',
				"ADD_TO_BASKET_ACTION" => "ADD",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"BACKGROUND_IMAGE" => "-",
				"BASKET_URL" => $arParams["BASKET_URL"],
				"BROWSER_TITLE" => "-",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"COMPATIBLE_MODE" => ($arParams['COMPATIBLE_MODE'] ?? ''),
				"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
				"CUSTOM_FILTER" => "",
				"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
				"DISPLAY_TOP_PAGER" => "N",
				"ELEMENT_SORT_FIELD" => $arParams["TOP_ELEMENT_SORT_FIELD"],
				"ELEMENT_SORT_ORDER" => $arParams["TOP_ELEMENT_SORT_ORDER"],
				"ELEMENT_SORT_FIELD2" => $arParams["TOP_ELEMENT_SORT_FIELD2"],
				"ELEMENT_SORT_ORDER2" => $arParams["TOP_ELEMENT_SORT_ORDER2"],
				"ENLARGE_PRODUCT" => $arParams['TOP_ENLARGE_PRODUCT'],
				"FILTER_NAME" => "mainCatalogFilter",
				'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"IBLOCK_ID" => IblockHelper::getIdByCode("hutcatalog"),
				"IBLOCK_TYPE" => "hut",
				"INCLUDE_SUBSECTIONS" => "Y",
				"LABEL_PROP" => $arParams['LABEL_PROP'] ?? '',
				"LABEL_PROP_MOBILE" => $arParams['LABEL_PROP_MOBILE'] ?? '',
				"LABEL_PROP_POSITION" => $arParams['LABEL_PROP_POSITION'] ?? '',
				"LAZY_LOAD" => "N",
				"LINE_ELEMENT_COUNT" => "3",
				"LOAD_ON_SCROLL" => "N",
				"MESSAGE_404" => "",
				"MESS_BTN_ADD_TO_BASKET" => $arParams['~MESS_BTN_ADD_TO_BASKET'],
				"MESS_BTN_BUY" => $arParams['~MESS_BTN_BUY'],
				"MESS_BTN_DETAIL" => $arParams['~MESS_BTN_DETAIL'],
				"MESS_BTN_LAZY_LOAD" => "Показать ещё",
				"MESS_BTN_SUBSCRIBE" => $arParams['~MESS_BTN_SUBSCRIBE'],
				'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'] ?? '',
				'MESS_NOT_AVAILABLE_SERVICE' => $arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '',
				"META_DESCRIPTION" => "-",
				"META_KEYWORDS" => "-",
				"OFFERS_CART_PROPERTIES" => ($arParams["OFFERS_CART_PROPERTIES"] ?? []),
				"OFFERS_FIELD_CODE" => $arParams["TOP_OFFERS_FIELD_CODE"] ?? [],
				"OFFERS_LIMIT" => ($arParams["TOP_OFFERS_LIMIT"] ?? 0),
				"OFFERS_PROPERTY_CODE" => ($arParams["TOP_OFFERS_PROPERTY_CODE"] ?? []),
				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Товары",
				"PAGE_ELEMENT_COUNT" => "24",
				"PARTIAL_PRODUCT_PROPERTIES" => ($arParams["PARTIAL_PRODUCT_PROPERTIES"] ?? ''),
				"PRICE_CODE" => $arParams["~PRICE_CODE"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"PRODUCT_BLOCKS_ORDER" => $arParams['TOP_PRODUCT_BLOCKS_ORDER'],
				"PRODUCT_DISPLAY_MODE" => $arParams['PRODUCT_DISPLAY_MODE'],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"PRODUCT_PROPERTIES" => ($arParams["PRODUCT_PROPERTIES"] ?? []),
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_ROW_VARIANTS" => $arParams['TOP_PRODUCT_ROW_VARIANTS'],
				"PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
				"PROPERTY_CODE" => ($arParams["TOP_PROPERTY_CODE"] ?? []),
				"PROPERTY_CODE_MOBILE" => $arParams["TOP_PROPERTY_CODE_MOBILE"] ?? [],
				"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
				"RCM_TYPE" => "personal",
				"SECTION_CODE" => "",
				"SECTION_ID" => $sectionId,
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
				"SECTION_USER_FIELDS" => array(
					0 => "",
					1 => "",
				),
				"SEF_MODE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SHOW_ALL_WO_SECTION" => "N",
				"SHOW_CLOSE_POPUP" => $arParams['COMMON_SHOW_CLOSE_POPUP'] ?? '',
				"SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
				"SHOW_FROM_SECTION" => "N",
				"SHOW_MAX_QUANTITY" => "N",
				"SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
				"SHOW_SLIDER" => $arParams['TOP_SHOW_SLIDER'],
				"SLIDER_INTERVAL" => $arParams['TOP_SLIDER_INTERVAL'] ?? '',
				"SLIDER_PROGRESS" => $arParams['TOP_SLIDER_PROGRESS'] ?? '',
				"TEMPLATE_THEME" => ($arParams['TEMPLATE_THEME'] ?? ''),
				"USE_ENHANCED_ECOMMERCE" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
				"COMPONENT_TEMPLATE" => "main-catalog-page",
			),
			false
		);
	}
}
?>
<script>
	document.querySelector('.menu__wrap').classList.remove('scroll');
	document.querySelector('.menu__wrap').classList.add('change');
</script>