<?
// this page NOT for request
// this is example. page for send search.title ajax-request

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent("arturgolubev:search.title", "your_template", array(
		// component params
	),
	false
);
?>