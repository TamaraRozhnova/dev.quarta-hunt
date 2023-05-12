<?
//define("NEED_AUTH", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order.list", 
	".default", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ALLOW_INNER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"DEFAULT_SORT" => "ID",
		"DISALLOW_CANCEL" => "Y",
		"HISTORIC_STATUSES" => array(
		),
		"ID" => $ID,
		"NAV_TEMPLATE" => "",
		"ONLY_INNER_FULL" => "N",
		"ORDERS_PER_PAGE" => "10",
		"PATH_TO_BASKET" => "/cart/",
		"PATH_TO_CANCEL" => "",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_COPY" => "/cart/",
		"PATH_TO_DETAIL" => "/cabinet/orders/#ID#",
		"PATH_TO_PAYMENT" => "/cabinet/orders/payment.php",
		"REFRESH_PRICES" => "N",
		"RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "F",
			1 => "P",
		),
		"SAVE_IN_SESSION" => "Y",
		"SET_TITLE" => "Y",
		"STATUS_COLOR_B" => "gray",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_H" => "gray",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_OT" => "gray",
		"STATUS_COLOR_P" => "yellow",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"STATUS_COLOR_SV" => "gray",
		"STATUS_COLOR_TT" => "gray",
		"STATUS_COLOR_ZO" => "gray"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>