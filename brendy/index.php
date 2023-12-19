<?php 

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");

$APPLICATION->IncludeComponent(
	"custom:brands.index", 
	"", 
	[]
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");