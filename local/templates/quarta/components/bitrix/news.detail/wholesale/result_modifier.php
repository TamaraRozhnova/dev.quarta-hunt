<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['PROPERTIES']['PRICE_LIST']['VALUE'] as $val) {
	$inf = CFile::GetFileArray($val);
	$inf['FILE_SIZE_FORMATED'] = CFile::FormatSize($inf['FILE_SIZE']);
	$arResult['PROPERTIES']['PRICE_LIST']['INF'][] = $inf;
}

$arResult['PROPERTIES']['VIDEO_PREVIEW']['SRC'] = CFile::GetPath($arResult['PROPERTIES']['VIDEO_PREVIEW']['VALUE']);

$arResult = modify_result($arResult);