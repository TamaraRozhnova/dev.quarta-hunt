<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Sale\DiscountCouponsManagerBase;

Loader::includeModule('sale');

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementUpdate',
    ['CustomEvents\Hut\OnBeforeIBlockElementUpdate', 'OnBeforeIBlockElementUpdateHandler']
);
