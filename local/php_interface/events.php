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


//HUT размеры для сайта, доработка по обмену.
// Обмен не определяет сайт, поэтому евент должен быть в сайте по умолчнию
$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementUpdate',
    ['CustomEvents\Hut\OneCImportHandler', 'IBlockElementUpdateHandler']
);

$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockElementAdd',
    ['CustomEvents\Hut\OneCImportHandler', 'IBlockElementUpdateHandler']
);

