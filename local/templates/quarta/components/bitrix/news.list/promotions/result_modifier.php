<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as $i => $item) {
	$arResult['ITEMS'][$i]['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC'] = CFile::GetPath($item['PROPERTIES']['MOB_IMAGE_PREVIEW']['VALUE']);
	$arResult['ITEMS'][$i]['PROPERTIES']['MOB_IMAGE_DETAIL']['SRC'] = CFile::GetPath($item['PROPERTIES']['MOB_IMAGE_DETAIL']['VALUE']);
}

init_nav($arResult);

$arResult = modify_result($arResult);
