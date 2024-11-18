<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentParameters =
    [
        'PARAMETERS' =>
            [
                'BLOG_TITLE' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('BLOG_TITLE'),
                        'TYPE' => 'STRING',
                    ],
                'BLOG_DESCRIPTION' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('BLOG_DESCRIPTION'),
                        'TYPE' => 'STRING',
                    ],
                'BLOG_URL' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('BLOG_URL'),
                        'TYPE' => 'STRING',
                    ],
                'BLOG_GROUP_ID' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('BLOG_GROUP_ID'),
                        'TYPE' => 'STRING',
                    ],
                'ELEMENT_ID' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('ELEMENT_ID'),
                        'TYPE' => 'STRING',
                    ],
                'IBLOCK_ID' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('IBLOCK_ID'),
                        'TYPE' => 'STRING',
                    ],
                'ELEMENT_COUNT' =>
                    [
                        'PARENT' => 'BASE',
                        'NAME' => Loc::getMessage('ELEMENT_COUNT'),
                        'TYPE' => 'STRING',
                    ],
                'CACHE_TIME' => ['DEFAULT' => 36000000],
            ],
    ];
