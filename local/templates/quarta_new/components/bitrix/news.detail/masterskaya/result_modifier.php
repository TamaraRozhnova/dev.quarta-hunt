<?php

use General\User;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}


// Главный слайдер
//$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 35, 'SECTION_ID' => $arResult['PROPERTIES']['MAIN_SLIDER']['VALUE']]);
//$items = [];
//
//while ($slider = $res->GetNextElement()) {
//    $f = $slider->GetFields();
//    $f['PROPERTIES'] = $slider->GetProperties();
//    $preview_picture['ID'] = $f['PREVIEW_PICTURE'];
//    $preview_picture['SRC'] = $f['PREVIEW_PICTURE'] !== null ? CFile::GetPath($f['PREVIEW_PICTURE']) : '';
//    $detail_picture['ID'] = $f['DETAIL_PICTURE'];
//    $detail_picture['SRC'] = $f['DETAIL_PICTURE'] !== null ? CFile::GetPath($f['DETAIL_PICTURE']) : '';
//    $f['PREVIEW_PICTURE'] = $preview_picture;
//    $f['DETAIL_PICTURE'] = $detail_picture;
//    $items[] = $f;
//    $items[] = $f['ID'];
//}
//
//$arResult['PROPERTIES']['MAIN_SLIDER']['ITEMS'] = $items;


//цены пользователя
$user = new User();
$arResult['PRICE_CODE'] = $user->getUserPriceCode();

if (!empty($arResult['PROPERTIES']['SLIDER_2']['VALUE'])) {

    // Второй слайдер
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 35, 'SECTION_ID' => $arResult['PROPERTIES']['SLIDER_2']['VALUE']]);

    $items = [];

    while ($slider = $res->GetNextElement()) {
        $f = $slider->GetFields();
        $f['PROPERTIES'] = $slider->GetProperties();
        $preview_picture['ID'] = $f['PREVIEW_PICTURE'];
        $preview_picture['SRC'] = $f['PREVIEW_PICTURE'] !== null ? CFile::GetPath($f['PREVIEW_PICTURE']) : '';
        $detail_picture['ID'] = $f['DETAIL_PICTURE'];
        $detail_picture['SRC'] = $f['DETAIL_PICTURE'] !== null ? CFile::GetPath($f['DETAIL_PICTURE']) : '';
        $f['PREVIEW_PICTURE'] = $preview_picture;
        $f['DETAIL_PICTURE'] = $detail_picture;
        $items[] = $f;
    }

    $arResult['PROPERTIES']['SLIDER_2']['ITEMS'] = $items;
}

if (!empty($arResult['PROPERTIES']['SLIDER_3']['VALUE'])) {

    // Третий слайдер
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 35, 'SECTION_ID' => $arResult['PROPERTIES']['SLIDER_3']['VALUE']]);

    $items = [];

    while ($slider = $res->GetNextElement()) {
        $f = $slider->GetFields();
        $f['PROPERTIES'] = $slider->GetProperties();
        $preview_picture['ID'] = $f['PREVIEW_PICTURE'];
        $preview_picture['SRC'] = $f['PREVIEW_PICTURE'] !== null ? CFile::GetPath($f['PREVIEW_PICTURE']) : '';
        $detail_picture['ID'] = $f['DETAIL_PICTURE'];
        $detail_picture['SRC'] = $f['DETAIL_PICTURE'] !== null ? CFile::GetPath($f['DETAIL_PICTURE']) : '';
        $f['PREVIEW_PICTURE'] = $preview_picture;
        $f['DETAIL_PICTURE'] = $detail_picture;
        $items[] = $f;
    }

    $arResult['PROPERTIES']['SLIDER_3']['ITEMS'] = $items;
}


if (!empty($arResult['PROPERTIES']['SLIDER_4']['VALUE'])) {

    // Четвертый слайдер
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => 35, 'SECTION_ID' => $arResult['PROPERTIES']['SLIDER_4']['VALUE']]);

    $items = [];

    while ($slider = $res->GetNextElement()) {
        $f = $slider->GetFields();
        $f['PROPERTIES'] = $slider->GetProperties();
        $preview_picture['ID'] = $f['PREVIEW_PICTURE'];
        $preview_picture['SRC'] = $f['PREVIEW_PICTURE'] !== null ? CFile::GetPath($f['PREVIEW_PICTURE']) : '';
        $detail_picture['ID'] = $f['DETAIL_PICTURE'];
        $detail_picture['SRC'] = $f['DETAIL_PICTURE'] !== null ? CFile::GetPath($f['DETAIL_PICTURE']) : '';
        $f['PREVIEW_PICTURE'] = $preview_picture;
        $f['DETAIL_PICTURE'] = $detail_picture;
        $items[] = $f;
    }

    $arResult['PROPERTIES']['SLIDER_4']['ITEMS'] = $items;
}

// Обзор

if (!empty($arResult['PROPERTIES']['REVIEW_IMAGE']['VALUE'])) {
    $arResult['PROPERTIES']['REVIEW_IMAGE']['SRC'] = $arResult['PROPERTIES']['REVIEW_IMAGE']['VALUE'] !== null ?
        CFile::GetPath($arResult['PROPERTIES']['REVIEW_IMAGE']['VALUE']) : '';

    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 16, 'ID' => $arResult['PROPERTIES']['REVIEW_PRODUCTS']['VALUE']],
        false,
        false,
        [
            'ID', 'NAME', 'CODE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1',
            'PROPERTY_CML2_ARTICLE'
        ]
    );

    while ($product = $res->GetNextElement()) {
        $f = $product->GetFields();
        $discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
        $f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
        $arResult['PROPERTIES']['REVIEW_PRODUCTS']['ITEMS'][] = $f;
    }

    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $arResult['PROPERTIES']['REVIEW_PRODUCTS']['VALUE']],
        false,
        false,
        ['ID', 'PROPERTY_PRODUCT_ID', 'PROPERTY_RATING']
    );

    foreach ($arResult['PROPERTIES']['REVIEW_PRODUCTS']['ITEMS'] as &$item1)
        $item1['FEEDBACK'] = [];

    while ($feed = $res->GetNextElement()) {
        $f = $feed->GetFields();
        foreach ($arResult['PROPERTIES']['REVIEW_PRODUCTS']['ITEMS'] as $i => $item)
            if ($f['PROPERTY_PRODUCT_ID_VALUE'] === $item['ID']) $arResult['PROPERTIES']['REVIEW_PRODUCTS']['ITEMS'][$i]['FEEDBACK'][] = $f;
    }
}



if (!empty($arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE']['VALUE'])) {
    // Видео обзор
    $arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE']['SRC'] = $arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE']['VALUE'] !== null ?
        CFile::GetPath($arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE']['VALUE']) : '';
}

if (!empty($arResult['PROPERTIES']['DESCR_1_IMAGES']['VALUE'])) {
    // Описание 1
    foreach ($arResult['PROPERTIES']['DESCR_1_IMAGES']['VALUE'] as $id) {
        $arResult['PROPERTIES']['DESCR_1_IMAGES']['SRC'][] = CFile::GetPath($id);
    }
}

if (!empty($arResult['PROPERTIES']['CATALOG_PRODUCTS']['VALUE'])) {

    // Каталог
    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 16, 'ID' => $arResult['PROPERTIES']['CATALOG_PRODUCTS']['VALUE']],
        false,
        false,
        [
            'ID', 'NAME', 'CODE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1',
            'PROPERTY_CML2_ARTICLE'
        ]
    );

    while ($product = $res->GetNextElement()) {
        $f = $product->GetFields();
        $discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
        $f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
        $arResult['PROPERTIES']['CATALOG_PRODUCTS']['ITEMS'][] = $f;
    }

    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $arResult['PROPERTIES']['CATALOG_PRODUCTS']['VALUE']],
        false,
        false,
        ['ID', 'PROPERTY_PRODUCT_ID', 'PROPERTY_RATING']
    );

    foreach ($arResult['PROPERTIES']['CATALOG_PRODUCTS']['ITEMS'] as &$item2)
        $item2['FEEDBACK'] = [];

    while ($feed = $res->GetNextElement()) {
        $f = $feed->GetFields();
        foreach ($arResult['PROPERTIES']['CATALOG_PRODUCTS']['ITEMS'] as $i => $item)
            if ($f['PROPERTY_PRODUCT_ID_VALUE'] === $item['ID']) $arResult['PROPERTIES']['CATALOG_PRODUCTS']['ITEMS'][$i]['FEEDBACK'][] = $f;
    }
}

if (!empty($arResult['PROPERTIES']['DESCR_2_IMAGES']['VALUE'])) {
    // Описание 2
    $arResult['PROPERTIES']['DESCR_2_IMAGES']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['DESCR_2_IMAGES']['VALUE']);
}

if (!empty($arResult['PROPERTIES']['DESCR_3_IMAGES']['VALUE'])) {
    // Описание 3
    $arResult['PROPERTIES']['DESCR_3_IMAGES']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['DESCR_3_IMAGES']['VALUE']);
}

if (!empty($arResult['PROPERTIES']['ASSORT_IMAGE_1']['VALUE'])) {
    // Ассортимент
    $arResult['PROPERTIES']['ASSORT_IMAGE_1']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['ASSORT_IMAGE_1']['VALUE']);
}

if (!empty($arResult['PROPERTIES']['ASSORT_IMAGE_2']['VALUE'])) {
    // Ассортимент
    $arResult['PROPERTIES']['ASSORT_IMAGE_2']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['ASSORT_IMAGE_2']['VALUE']);
}

if (!empty($arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['VALUE'])) {

    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 16, 'ID' => $arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['VALUE']],
        false,
        false,
        [
            'ID', 'NAME', 'CODE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1',
            'PROPERTY_CML2_ARTICLE'
        ]
    );

    while ($product = $res->GetNextElement()) {
        $f = $product->GetFields();
        $discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
        $f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
        $arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['ITEMS'][] = $f;
    }

    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['VALUE']],
        false,
        false,
        ['ID', 'PROPERTY_PRODUCT_ID', 'PROPERTY_RATING']
    );

    foreach ($arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['ITEMS'] as &$item3)
        $item3['FEEDBACK'] = [];

    while ($feed = $res->GetNextElement()) {
        $f = $feed->GetFields();
        foreach ($arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['ITEMS'] as $i => $item)
            if ($f['PROPERTY_PRODUCT_ID_VALUE'] === $item['ID']) $arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['ITEMS'][$i]['FEEDBACK'][] = $f;
    }
}

if (!empty($arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['VALUE'])) {
    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 16, 'ID' => $arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['VALUE']],
        false,
        false,
        [
            'ID', 'NAME', 'CODE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1',
            'PROPERTY_CML2_ARTICLE'
        ]
    );

    while ($product = $res->GetNextElement()) {
        $f = $product->GetFields();
        $discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
        $f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
        $arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['ITEMS'][] = $f;
    }

    $res = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['VALUE']],
        false,
        false,
        ['ID', 'PROPERTY_PRODUCT_ID', 'PROPERTY_RATING']
    );

    foreach ($arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['ITEMS'] as &$item4)
        $item4['FEEDBACK'] = [];

    while ($feed = $res->GetNextElement()) {
        $f = $feed->GetFields();
        foreach ($arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['ITEMS'] as $i => $item)
            if ($f['PROPERTY_PRODUCT_ID_VALUE'] === $item['ID']) $arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['ITEMS'][$i]['FEEDBACK'][] = $f;
    }
}


if (!empty($arResult['PROPERTIES']['COND_IMAGE']['VALUE'])) {
    // Условия
    $arResult['PROPERTIES']['COND_IMAGE']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['COND_IMAGE']['VALUE']);
}
