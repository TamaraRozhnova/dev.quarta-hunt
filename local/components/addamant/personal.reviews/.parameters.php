<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters =
    [
        'PARAMETERS' =>
        [
            // 'ELEMENT_ID' =>
            //     [
            //         'PARENT' => 'BASE',
            //         'NAME' => Loc::getMessage('ELEMENT_ID'),
            //         'TYPE' => 'STRING',
            //     ],
            'IBLOCK_ID' =>
            [
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('IBLOCK_ID'),
                'TYPE' => 'STRING',
            ],
        ],
    ];
