<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['PROPERTIES']['BANNER_IMAGE']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['BANNER_IMAGE']['VALUE']);
$arResult['PROPERTIES']['BANNER_IMAGE_MOB']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['BANNER_IMAGE_MOB']['VALUE']);

$arResult = modify_result($arResult);