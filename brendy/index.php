<?php 

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
	"custom:brands.index", 
	"", 
	[]
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");