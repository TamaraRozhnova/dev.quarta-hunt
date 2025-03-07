<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    'GROUPS' => [
        'SETTINGS' => [
            'NAME' => Loc::getMessage('SETTINGS'),
            'SORT' => 550,
        ],
    ],
    'PARAMETERS' => [
        'CACHE_TIME' => ['DEFAULT' => 3600],
    ]
];