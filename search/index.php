<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle('Quarta Hunt');
$APPLICATION->AddChainItem('Результаты поиска');

$APPLICATION->IncludeComponent(
	"custom:sphinx.search",
	"",
Array()
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");