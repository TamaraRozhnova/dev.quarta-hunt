<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['ITEMS'] as $index => &$arItem) {
    $arItem['PIC'] = \CFile::ResizeImageGet(
        $arItem['PREVIEW_PICTURE'] ?: $arItem['DETAIL_PICTURE'],
        array('width' => 180, 'height' => 180),
        BX_RESIZE_IMAGE_EXACT,
        true
    )['src'];

    if (empty($arItem['PIC'])) {
        unset($arResult['ITEMS'][$index]);
    }
}
