<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Ваши избранные товары");
$APPLICATION->SetTitle("Ваши избранные товары");

$APPLICATION->AddChainItem('Избранное');

$APPLICATION->IncludeComponent(
    "custom:favorites", "main", array(
        "IBLOCK_TYPE" => "userdata",
        "IBLOCK_ID" => "21",
    )
);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");