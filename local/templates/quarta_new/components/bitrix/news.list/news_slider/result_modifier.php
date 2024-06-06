<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['ITEMS'] as $i => $arItem) {
    $filePath = CFile::GetPath($arItem['PROPERTIES']['MOB_IMAGE_PREVIEW']['VALUE']);
    if ($filePath) {
        $arResult['ITEMS'][$i]['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC'] = $filePath;
    }
    $arResult['ITEMS'][$i]['PREVIEW_PICTURE']['SRC'] = \CHTTP::urnEncode(    CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], array('width' => 640, 'height' => 444), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true)['src'], 'UTF-8');
}