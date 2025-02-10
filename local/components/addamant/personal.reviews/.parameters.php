<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters =
    [
        'PARAMETERS' =>
        [
            'OFFERS_CATALOG_CODE' =>
            [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('OFFERS_CATALOG_CODE'),
                'TYPE' => 'STRING',
            ],
            'IBLOCK_ID' =>
            [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('IBLOCK_ID'),
                'TYPE' => 'STRING',
            ],
        ],
    ];
