<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$ids = [];

foreach ($arResult['ITEMS'] as $arItem) {
	$ids[] = $arItem['PROPERTIES']['SECTION']['VALUE'];
}

if (!empty($ids)) {
	$sections = CIBlockSection::GetList([], ['IBLOCK_ID' => 16, 'ID' => $ids]);

	while ($section = $sections->GetNextElement()) {
		$fields = $section->GetFields();

		foreach ($arResult['ITEMS'] as $i => $item) {
			if ($fields['ID'] === $item['PROPERTIES']['SECTION']['VALUE']) {
				$arResult['ITEMS'][$i]['PROPERTIES']['SECTION'] = $fields;
			}
		}
	}
}

foreach ($arResult['ITEMS'] as $i => $arItem) {
    $arResult['ITEMS'][$i]['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC'] = CFile::GetPath($arItem['PROPERTIES']['MOB_IMAGE_PREVIEW']['VALUE']);
    $arResult['ITEMS'][$i]['PROPERTIES']['MOB_IMAGE_DETAIL']['SRC'] = CFile::GetPath($arItem['PROPERTIES']['MOB_IMAGE_DETAIL']['VALUE']);

	if (!empty($arItem['TAGS'])) {
		$tags = explode(',', $arItem['TAGS']);
		foreach ($tags as $j => $t) $tags[$j] = trim($t);
		$arResult['ITEMS'][$i]['TAGS'] = $tags;
	}
}


init_nav($arResult);

$arResult = modify_result($arResult);



