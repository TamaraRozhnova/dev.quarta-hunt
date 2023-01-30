<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

foreach ($arResult['ITEMS'] as $i => $arItem) {
    $filePath = CFile::GetPath($arItem['PROPERTIES']['MOB_IMAGE_PREVIEW']['VALUE']);
    if ($filePath) {
        $arResult['ITEMS'][$i]['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC'] = $filePath;
    }
}