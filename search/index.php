<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Результаты поиска по сайту quarta-hunt.ru");

$APPLICATION->SetTitle("Результаты поиска по сайту quarta-hunt.ru");
$APPLICATION->AddChainItem('Результаты поиска');

$APPLICATION->IncludeComponent(
	"custom:sphinx.search",
	"",
Array()
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");