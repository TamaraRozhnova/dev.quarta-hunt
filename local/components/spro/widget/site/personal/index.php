<?
require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php" );
$APPLICATION->SetTitle( "Персональный раздел" );
?>
<div class="main">
	<div class="personal">
		<div class="container">
			<h1 class="section__title">
			<? $APPLICATION->ShowTitle(); ?>
			</h1>
			<div class="personal-wrap">
				<div class="customers-menu">
					<?php $APPLICATION->ShowViewContent( 'PERSONAL_MENU' ) ?>
				</div>
				<div class="customers-content">
		<? $APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section",
	"bootstrap_v4",
	array(
		"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
			0 => "0",
		),
		"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
		"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
			0 => "100",
			1 => "200",
			2 => "500",
			3 => "1000",
			4 => "5000",
			5 => "",
		),
		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "N",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
		"CUSTOM_PAGES" => "",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"NAV_TEMPLATE" => "",
		"ORDER_HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"PATH_TO_BASKET" => "/personal/cart",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/about/contacts",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PER_PAGE" => "20",
		"PROP_1" => array(
		),
		"PROP_2" => "",
		"SAVE_IN_SESSION" => "N",
		"SEF_FOLDER" => "/personal/",
		"SEF_MODE" => "Y",
		"SEND_INFO_PRIVATE" => "N",
		"SET_TITLE" => "Y",
		"SHOW_ACCOUNT_COMPONENT" => "Y",
		"SHOW_ACCOUNT_PAGE" => "N",
		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
		"SHOW_BASKET_PAGE" => "N",
		"SHOW_CONTACT_PAGE" => "N",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "N",
		"ALLOW_INNER" => "N",
		"ONLY_INNER_FULL" => "N",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"USER_PROPERTY_PRIVATE" => "",
		"USE_AJAX_LOCATIONS_PROFILE" => "N",
		"COMPONENT_TEMPLATE" => "bootstrap_v4",
		"ORDER_HIDE_USER_INFO" => array(
			0 => "0",
		),
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
			0 => "0",
		),
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_DISALLOW_CANCEL" => "Y",
		"ORDERS_PER_PAGE" => "20",
		"MAIN_CHAIN_NAME" => "Мой кабинет",
		"SEF_URL_TEMPLATES" => array(
			"index" => "index.php",
			"orders" => "orders/",
			"account" => "account/",
			"subscribe" => "subscribe/",
			"profile" => "profiles/",
			"profile_detail" => "profiles/#ID#",
			"private" => "",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "cancel/#ID#",
		)
	),
	false
); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<? require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php" ); ?>
