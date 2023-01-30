<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arViewModeList = [
    'LIST' => GetMessage('CPT_BCSL_VIEW_MODE_LIST'),
    'LINE' => GetMessage('CPT_BCSL_VIEW_MODE_LINE'),
    'TEXT' => GetMessage('CPT_BCSL_VIEW_MODE_TEXT'),
    'TILE' => GetMessage('CPT_BCSL_VIEW_MODE_TILE')
];

$arTemplateParameters = [
    'VIEW_MODE' => [
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('CPT_BCSL_VIEW_MODE'),
        'TYPE' => 'LIST',
        'VALUES' => $arViewModeList,
        'MULTIPLE' => 'N',
        'DEFAULT' => 'LINE',
        'REFRESH' => 'Y'
    ],
    'SHOW_PARENT_NAME' => [
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('CPT_BCSL_SHOW_PARENT_NAME'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y'
    ],
];

if (isset($arCurrentValues['VIEW_MODE']) && 'TILE' == $arCurrentValues['VIEW_MODE']) {
    $arTemplateParameters['HIDE_SECTION_NAME'] = [
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('CPT_BCSL_HIDE_SECTION_NAME'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    ];
}