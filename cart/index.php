<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->SetTitle("Корзина");

$APPLICATION->IncludeComponent(
	'addamant:custom.basket',
	'.default',
	[],
	false
);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");