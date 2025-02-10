<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Sale\DiscountCouponsManagerBase;

Loader::includeModule('sale');

$eventManager = EventManager::getInstance();

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
