<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arTemplateParameters = [
    'SHOW_PRODUCT_TAGS_IN_SECTIONS' => [
        'NAME' => 'Показывать тэги у товаров в разделах',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'PARENT' => 'BASE',
    ],
    'SHOW_PRODUCT_TAGS_IN_RECOMMENDED' => [
        'NAME' => 'Показывать тэги у рекомендованных товаров',
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'PARENT' => 'BASE',
    ],
];