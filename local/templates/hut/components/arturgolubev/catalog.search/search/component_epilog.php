<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

$APPLICATION->SetTitle(Loc::getMessage("CT_BCSE_FOUND", ["#REQUEST#" => $_GET["q"]]), true);
