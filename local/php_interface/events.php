<?php


use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;

Loader::includeModule('sale');

$eventManager = EventManager::getInstance();


$eventManager->addEventHandler(
    "iblock",
    "OnBeforeIBlockElementUpdate",
    ["CustomEvents\OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler"]
);
