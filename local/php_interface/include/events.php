<?php

use Bitrix\Main\EventManager;
use Feedback\Events;

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler('iblock', 'OnAfterIBlockElementUpdate', [Events::class, 'updateProductAfterReviewChange']);