<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($arResult['ITEM']['LABEL']) && isset($arResult['ITEM']['LABEL_ARRAY_VALUE']['TYPE'])) {
    $arResult['ITEM']['LABEL_IMG'] = $arResult['ITEM']['PROPERTIES'][key($arResult['ITEM']['LABEL_ARRAY_VALUE'])]['VALUE_XML_ID'];

    $arResult['ITEM']['DOING_LINK'] = \Bitrix\Iblock\Elements\ElementHutdoingTable::getList([
        'select' => ['DOING_LINK' => 'LINK.VALUE'],
        'filter' => ['=NAME' => $arResult['ITEM']['LABEL_ARRAY_VALUE']['TYPE']],
    ])->fetch()['DOING_LINK'];
}
