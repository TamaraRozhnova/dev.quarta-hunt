<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$newsIblockId = 13;
$mainBannerNewsId = $arParams['MAIN_BANNER_NEWS_ID'] ?? '';
$arrivalNewsIds = $arParams['ARRIVAL_NEWS_IDS'] ?? '';

$newArrivalArr = explode(',', $arrivalNewsIds);

if (!empty($mainBannerNewsId) || !empty($newArrivalArr)) {
    $newsIds = array_merge($newArrivalArr, [$mainBannerNewsId]);
    $newsResource = CIBlockElement::GetList([], ['IBLOCK_ID' => $newsIblockId, 'ID' => $newsIds, 'ACTIVE' => 'Y']);

    while ($news = $newsResource->GetNextElement()) {
        $fields = $news->GetFields();
        $properties = $news->GetProperties();
        $newsImage = \CHTTP::urnEncode(CFile::ResizeImageGet($properties['BANNER_IMAGE']['VALUE'], array('width' => 640, 'height' => 328), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true)['src'], 'UTF-8'); // 640 328
        
        // Разделяем путь на директорию и имя файла
        $path_parts = pathinfo($newsImage);
        $directory = $path_parts['dirname'];
        $filename = $path_parts['basename'];

        // Кодируем только имя файла
        $encoded_filename = rawurlencode($filename);

        // Собираем путь обратно
        $encoded_src = $directory . "/" . $encoded_filename;

        if ($fields['ID'] == $mainBannerNewsId) {
            $arResult['MAIN_BANNER_NEWS'] = $properties;
            $arResult['MAIN_BANNER_NEWS']['BANNER_IMAGE']['SRC'] = $encoded_src;
        }

        if (in_array($fields['ID'], $newArrivalArr)) {
            $arResult['ARRIVAL_NEWS'][$fields['ID']] = $properties;
            $arResult['ARRIVAL_NEWS'][$fields['ID']]['BANNER_IMAGE']['SRC'] = $encoded_src;
        }
    }
}
