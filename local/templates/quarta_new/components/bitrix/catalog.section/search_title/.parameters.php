<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arTemplateParameters = [
    'SHOW_PRODUCT_TAGS' => [
        'NAME' => 'Показывать тэги у товаров',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'PARENT' => 'BASE',
    ]
];