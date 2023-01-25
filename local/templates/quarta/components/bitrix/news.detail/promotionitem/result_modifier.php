<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['MOB_IMAGE_PREVIEW']['VALUE']);
$arResult['PROPERTIES']['MOB_IMAGE_DETAIL']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['MOB_IMAGE_DETAIL']['VALUE']);

$arResult = modify_result($arResult);