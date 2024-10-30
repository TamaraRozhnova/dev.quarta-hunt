<?php

use Personal\Favorites;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!empty($arResult['ITEM']['LABEL'])) {
    $arResult['ITEM']['LABEL_IMG'] = $arResult['ITEM']['PROPERTIES'][key($arResult['ITEM']['LABEL_ARRAY_VALUE'])]['VALUE_XML_ID'];
}

$favorites = new Favorites();

$favoritesElement = $favorites->getFavoritesElement();
$favoritesIds = $favorites->getProductsIdsInFavorites($favoritesElement);

if (in_array($arResult['ITEM']['ID'], $favoritesIds)) {
    $arResult['ITEM']['IS_FAVORITES'] = true;
}