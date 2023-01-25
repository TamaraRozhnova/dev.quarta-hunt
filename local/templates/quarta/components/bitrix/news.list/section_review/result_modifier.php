<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as $n => $item) {
    foreach ($item['PROPERTIES']['VIDEO_PREVIEW_IMAGES']['VALUE'] as $i => $val) {
        $arResult['ITEMS'][$n]['PROPERTIES']['VIDEO_PREVIEW_IMAGES']['SRC'][$i] = CFile::GetPath($val);
    }
}

$arResult = modify_result($arResult);