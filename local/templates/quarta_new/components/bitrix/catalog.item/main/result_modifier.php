<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\DiscountsHelper;
use General\User;
use Bitrix\Sale\Internals\ServiceRestrictionTable;
use Bitrix\Sale\Services\PaySystem\Restrictions\Manager;

$item = &$arResult['ITEM'];

$arResult['ITEM']['OFFERS_QUANTITY'] = 0;

$user = new User();
$priceCode = $user->getUserPriceCode();

if (is_array($item['OFFERS']) && count($item['OFFERS']) > 0) {

    foreach ($item['OFFERS'] as $offer) {

        if (!empty($offer['PRICES'][$priceCode])) {
            if ($offer['PRICES'][$priceCode]['VALUE'] == 0) {
                $offer['CAN_BUY'] = false;
            } 
        }

        if ($offer['CAN_BUY'] == true) {
            $arResult['ITEM']['AVAILABLE'] = true;
            $arResult['ITEM']['OFFERS_QUANTITY'] += (int)$offer['PRODUCT']['QUANTITY'];
        }

    }
} else {
    $arResult['ITEM']['AVAILABLE'] = boolval($item['CAN_BUY']);
}

if (!$item['PRICES_LIST']) {
    $arResult['ITEM']['PRICES_LIST'] = DiscountsHelper::getCorrectPrices($item);
}

$productSections = getRootProductSection($item['IBLOCK_ID'], $item['IBLOCK_SECTION_ID']);

if (is_array($productSections) && count($productSections) > 0) {
    if ($productSections[0]['CODE'] == RESTRICTED_SECTIONS_FOF_FAST_BUY) {
        $arResult['RESTRICTED_SECTION'] = 'Y';
    }
}

/** Labels */

// Собираем свойства товара для меток
$arLabelsProps = [
    $item['PROPERTIES']['HIT']['VALUE'], // Свойство "Хит продаж"
    $item['PRESENT'], // Свойство "Подарок"
    $item['PROPERTIES']['NEW_PRODUCT']['VALUE'], // Свойство "Новинка"
    $item['PROPERTIES']['DOUBLE_BONUS']['VALUE'], // Свойство "Двойные бонусы"
];

// Фильтруем массив, удаляя пустые значения
$arLabelsPropsFiltered = array_filter($arLabelsProps);

// Получаем ограничения для сервиса через запрос к таблице ограничений
$dbRestriction = ServiceRestrictionTable::getList([
    'select' => ['PARAMS'],
    'filter' => [
        'SERVICE_ID' => UKASSA_CREDIT_ID,
        'SERVICE_TYPE' => Manager::SERVICE_TYPE_PAYMENT 
    ]
]);

// Инициализируем массив для сбора параметров ограничений
$restrictions = [];
// Перебираем результаты запроса
while ($restriction = $dbRestriction->fetch()) {
    if(is_array($restriction['PARAMS'])) {
        $restrictions = array_merge($restrictions, $restriction['PARAMS']);
    }
}

// Получаем корневые разделы товара
$productSections = getRootProductSection($item['IBLOCK_ID'], $item['IBLOCK_SECTION_ID']);

// Массив с лицензионными разделами
$sectionsLicense = SECTIONS_LICENSED;

// Проверяем, есть ли категории в ограничениях
if (!empty($restrictions['CATEGORIES'])) {
    if (is_array($productSections) && count($productSections) > 0) {
        foreach ($productSections as $section) {

            // Если товар принадлежит к лицензионному разделу
            if (in_array($section['ID'], $sectionsLicense)) {
                // Устанавливаем ограничение
                $item['SHOW_CREDIT'] = 'N';
                break;
            }

            // Если ID раздела есть среди категорий ограничений
            if (in_array($section['ID'], $restrictions['CATEGORIES'])) {
                // Показываем возможность кредитования
                $item['SHOW_CREDIT'] = 'Y'; 
                break;
            }
            
        }    
    }
}

// Если в массиве меток больше одного элемента
if (!empty($arLabelsPropsFiltered) && count($arLabelsPropsFiltered) > 1) {
    $item['SHOW_BTN_LIST_LABELS'] = 'Y'; // Показываем кнопку списка меток
}

// Если есть хотя бы одна метка и товар можно купить в кредит
if (!empty($arLabelsPropsFiltered) && count($arLabelsPropsFiltered) >= 1 && $item['SHOW_CREDIT'] == 'Y') {
    $item['SHOW_BTN_LIST_LABELS'] = 'Y'; // Показываем кнопку списка меток
}




