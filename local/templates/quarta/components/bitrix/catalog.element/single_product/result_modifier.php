<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


function getHlBlockData($id) {
	$result = array();
	$hlblock = \Bitrix\Highloadblock\HighloadBlockTable::getById($id)->fetch();
	$entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock);
	$entity_data_class = $entity->getDataClass();
	$rs_data = $entity_data_class::getList(array('order' => array(), 'select' => array('UF_NAME', 'UF_XML_ID')));
	while ($el = $rs_data->fetch())
	{
		$data['NAME'] = $el['UF_NAME'];
		$data['VALUE'] = $el['UF_XML_ID'];
		$result[] = $data;
	}
	return $result;
}


unset($arResult['ITEM_QUANTITY_RANGES']);

foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $i => $val)
	$arResult['PROPERTIES']['MORE_PHOTO']['SRC'][$i] = CFile::GetPath($val);

foreach($arResult['PROPERTIES']['FILES']['VALUE'] as $i => $val)
	$arResult['PROPERTIES']['FILES']['SRC'][$i] = CFile::GetPath($val);
	
foreach($arResult['PROPERTIES']['FILES']['VALUE'] as $i => $val)
	$arResult['PROPERTIES']['FILES']['INF'][$i] = CFile::GetFileArray($val);


$list = CIBlockElement::GetList([], ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $arResult['ID']]);

while($i = $list->GetNextElement()) {
    $f = $i->GetFields();
    $p = $i->GetProperties();

    $f['USER_ID'] = $p['USER_ID'];
    $f['PRODUCT_ID'] = $p['PRODUCT_ID'];
	$f['FLAWS'] = $p['FLAWS'];
	$f['DIGNITIES'] = $p['DIGNITIES'];
	$f['COMMENTS'] = $p['COMMENTS'];
	$f['IMAGES'] = $p['IMAGES'];
    $f['RATING'] = $p['RATING'];
    $f['LIKES'] = $p['LIKES'];
    $f['DISLIKES'] = $p['DISLIKES'];
    $f['RESPONSES'] = $p['RESPONSES'];

	foreach($f['IMAGES']['VALUE'] as $val) $f['IMAGES']['SRC'] = CFile::GetPath($val);

    $arResult['FEEDBACK'][] = $f;
}

$opt = get_user_type();

if ($opt) {
	unset($arResult['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
	unset($arResult['PROPERTIES']['DOUBLE_BONUS']);
	unset($arResult['PROPERTIES']['PRESENT']);
}

if (!$opt) {
	$sections = CIBlockSection::GetList([], ['IBLOCK_ID' => 16], false, ['UF_*']);
	$sections_ind = 0;
	$sids = [];
	$sids_db = [];
	
	while ($s = $sections->GetNext()) {
		$arSections[$sections_ind]['IBLOCK_ID'] = $s['IBLOCK_ID'];
		$arSections[$sections_ind]['IBLOCK_SECTION_ID'] = $s['IBLOCK_SECTION_ID'];
		$arSections[$sections_ind]['XML_ID'] = $s['XML_ID'];
		$arSections[$sections_ind]['ID'] = $s['ID'];
		$arSections[$sections_ind]['NAME'] = $s['NAME'];
		$arSections[$sections_ind]['CODE'] = $s['CODE'];
		$arSections[$sections_ind]['SECTION_PAGE_URL'] = $s['SECTION_PAGE_URL'];
		$arSections[$sections_ind]['UF_BONUS_SYSTEM_ACTIVE'] = $s['UF_BONUS_SYSTEM_ACTIVE'];
		$arSections[$sections_ind]['UF_DOUBLE_BONUS'] = $s['UF_DOUBLE_BONUS'];
		$arSections[$sections_ind]['UF_LISENCE_PRODUCTS'] = $s['UF_LISENCE_PRODUCTS'];
		$sections_ind++;
	}

	foreach ($arSections as $s) {
		if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1') $sids[] = $s['ID'];
		if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $s['UF_DOUBLE_BONUS'] === '1') $sids_db[] = $s['ID'];
	}

	foreach ($arSections as $s) {
		if (in_array($s['IBLOCK_SECTION_ID'], $sids)) $sids[] = $s['ID'];
		if (in_array($s['IBLOCK_SECTION_ID'], $sids_db)) $sids_db[] = $s['ID'];
	}

	$db = in_array($arResult['IBLOCK_SECTION_ID'], $sids_db) ? 2 : 1;

	if ($db == 2)
		$arResult['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';

	$db = 1;

	if (in_array($arResult['IBLOCK_SECTION_ID'], $sids)) {
		$arResult['ITEM_PRICES'][0]['UF_BONUS_POINTS'] = $db * ceil(0.03 * $arResult['ITEM_PRICES'][0]['PRICE']);
		$arResult['PRICES']['BASE']['UF_BONUS_POINTS'] = $db * ceil(0.03 * $arResult['ITEM_PRICES'][0]['PRICE']);
	} else {
		$arResult['ITEM_PRICES'][0]['UF_BONUS_POINTS'] = 0;
		$arResult['PRICES']['BASE']['UF_BONUS_POINTS'] = 0;
	}

	$arResult['PRESENT'] = !empty(DiscountsHelper::getGiftIds($arResult['ID']));
} else {
	$arResult['ITEM_PRICES'][0]['UF_BONUS_POINTS'] = 0;
	$arResult['PRICES']['BASE']['UF_BONUS_POINTS'] = 0;
}

//$arResult['SIDS'] = $sids;
//$arResult['SIDS_SECTIONS'] = $arSections;

// RAZMER_OBUV
$arResult['RAZMER_OBUV'] = getHlBlockData(9);

// RAZMER_ODEZHDA_ZHENSKAYA
$arResult['RAZMER_ODEZHDA_ZHENSKAYA'] = getHlBlockData(10);

// RAZMER_NOSKI
$arResult['RAZMER_NOSKI'] = getHlBlockData(8);

// RAZMER_AKSESSUAROV_
$arResult['RAZMER_AKSESSUAROV_'] = getHlBlockData(7);

// RAZMER
$arResult['RAZMER'] = getHlBlockData(11);


$arResult = modify_result($arResult);
