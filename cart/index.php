<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?><?php
$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket", 
	"bootstrap_v4", 
	array(
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "DISCOUNT",
			2 => "PRICE",
			3 => "QUANTITY",
			4 => "SUM",
			5 => "PROPS",
			6 => "DELETE",
			7 => "DELAY",
			8 => "DETAIL_PICTURE",
			9 => "",
		),
		"COLUMNS_LIST_EXT" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DELETE",
			2 => "SUM",
			3 => "PROPERTY_CML2_ARTICLE",
		),
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_TO_ORDER" => "/cart/purchase/",

		"HIDE_COUPON" => "Y",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "Y",
		"TEMPLATE_THEME" => "site",
		"SET_TITLE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"OFFERS_PROPS" => array(
		),
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"USE_PREPAYMENT" => "N",
		"CORRECT_RATIO" => "Y",
		"AUTO_CALCULATION" => "Y",
		"ACTION_VARIABLE" => "basketAction",
		"COMPATIBLE_MODE" => "Y",
		"ADDITIONAL_PICT_PROP_16" => "-",
		"ADDITIONAL_PICT_PROP_26" => "-",
		"ADDITIONAL_PICT_PROP_27" => "-",
		"BASKET_IMAGES_SCALING" => "adaptive",
		"USE_GIFTS" => "Y",
		"GIFTS_PLACE" => "BOTTOM",
		"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
		"GIFTS_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
		"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
		"GIFTS_SHOW_OLD_PRICE" => "N",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_MESS_BTN_BUY" => "Выбрать",
		"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
		"GIFTS_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_CONVERT_CURRENCY" => "N",
		"GIFTS_HIDE_NOT_AVAILABLE" => "N",
		"DEFERRED_REFRESH" => "N",
		"USE_DYNAMIC_SCROLL" => "Y",
		"SHOW_FILTER" => "N",
		"SHOW_RESTORE" => "N",
		"COLUMNS_LIST_MOBILE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DELETE",
			2 => "PROPERTY_CML2_ARTICLE",
		),
		"TOTAL_BLOCK_DISPLAY" => array(
			0 => "bottom",
		),
		"DISPLAY_MODE" => "extended",
		"DETAIL_URL" => "/catalog/#ELEMENT_ID#/#ELEMENT_CODE#/",
		"PRICE_DISPLAY_MODE" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",
		"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
		"USE_PRICE_ANIMATION" => "Y",
		"LABEL_PROP" => array(
		),
		"EMPTY_BASKET_HINT_PATH" => "/",
		"USE_ENHANCED_ECOMMERCE" => "N"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
