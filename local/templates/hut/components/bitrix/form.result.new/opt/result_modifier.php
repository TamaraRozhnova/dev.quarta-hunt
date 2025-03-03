<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die;
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$placeholders = [
    'COMPANY' => Loc::getMessage('COMPANY_PLACEHOLDER'),
    'ADDRESS' => Loc::getMessage('ADDRESS_PLACEHOLDER'),
    'SHOP_PLACE' => Loc::getMessage('SHOP_PLACE_PLACEHOLDER'),
    'FIO' => Loc::getMessage('FIO_PLACEHOLDER'),
    'WORK' => Loc::getMessage('WORK_PLACEHOLDER'),
    'PHONE' => Loc::getMessage('PHONE_PLACEHOLDER'),
    'EMAIL' => Loc::getMessage('EMAIL_PLACEHOLDER')
];

if (!empty($arResult['QUESTIONS'])) {
    foreach ($arResult['QUESTIONS'] as $questionId => &$question) {
        if ($placeholders[$questionId]) {
            $question['PLACEHOLDER'] = $placeholders[$questionId];
        }
    }
}