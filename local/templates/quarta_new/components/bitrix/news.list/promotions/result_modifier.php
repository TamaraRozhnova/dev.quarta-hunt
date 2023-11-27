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
        $newsImage = CFile::GetPath($properties['BANNER_IMAGE']['VALUE']);
        if ($fields['ID'] == $mainBannerNewsId) {
            $arResult['MAIN_BANNER_NEWS'] = $properties;
            $arResult['MAIN_BANNER_NEWS']['BANNER_IMAGE']['SRC'] = $newsImage;
        }

        if (in_array($fields['ID'], $newArrivalArr)) {
            $arResult['ARRIVAL_NEWS'][$fields['ID']] = $properties;
            $arResult['ARRIVAL_NEWS'][$fields['ID']]['BANNER_IMAGE']['SRC'] = $newsImage;
        }
    }
}
