<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Iblock\SectionTable;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$section = $arResult['CURRENT_SECTION_ID'] = $request->get('section');

// Перебираем товары
foreach ($arResult['ITEMS'] as $key => $item) {

    // Складываем ID разделов в массив
    $sectionIds[] = $item['IBLOCK_SECTION_ID'];

    // Удаляем товары из результата, если указан раздел и товар не из этого раздела
    if ($section != '' && $item['IBLOCK_SECTION_ID'] != $section) {
        unset($arResult['ITEMS'][$key]);
    }
}

// Удаляем дубли
$sectionIds = array_unique($sectionIds);

// Получаем информацию по разделам
if ($sectionIds) {
    Loader::includeModule('iblock');

    $rsSection = SectionTable::getList(array(
        'filter' => array(
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            'ID' => $sectionIds
        ),
        'select' =>  array('ID', 'NAME'),
    ));

    while ($arSection = $rsSection->fetch()) {
        $arResult['SECTIONS'][$arSection['ID']] = $arSection;
    }
}
