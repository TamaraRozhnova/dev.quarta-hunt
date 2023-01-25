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


foreach($arResult['ITEMS'] as $n => $item)
	foreach($item['PROPERTIES']['MORE_PHOTO']['VALUE'] as $i => $val)
		$arResult['ITEMS'][$n]['PROPERTIES']['MORE_PHOTO']['SRC'][$i] = CFile::GetPath($val);

foreach($arResult['ITEMS'] as $n => $item)
	foreach($item['PROPERTIES']['FILES']['VALUE'] as $i => $val)
		$arResult['ITEMS'][$n]['PROPERTIES']['FILES']['SRC'][$i] = CFile::GetPath($val);

$id = $_REQUEST['SECTION_ID'] ? $_REQUEST['SECTION_ID'] : 16;

$count = CIBlockSection::GetSectionElementsCount($id, []);

$arResult['ELEMENT_COUNT'] = $count;

$ids = [];

foreach($arResult['ITEMS'] as $item) $ids[] = $item['ID'];

$list = CIBlockElement::GetList([], ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $ids]);

while($i = $list->GetNextElement()) {
	$f = $i->GetFields();
	$p = $i->GetProperties();

	$f['USER_ID'] = $p['USER_ID'];
	$f['PRODUCT_ID'] = $p['PRODUCT_ID'];
	$f['RATING'] = $p['RATING'];

	foreach($arResult['ITEMS'] as $n => $item)
		if ($item['ID'] == $p['PRODUCT_ID']['VALUE']) $arResult['ITEMS'][$n]['FEEDBACK'][] = $f;
}

$opt = get_user_type();

if ($opt) {
	foreach($arResult['ITEMS'] as $n => $item) {
		unset($arResult['ITEMS'][$n]['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
		unset($arResult['ITEMS'][$n]['PROPERTIES']['DOUBLE_BONUS']);
	}
}

if (!$opt) {
	foreach($arResult['ITEMS'] as $n => $item) {
		$arResult['ITEMS'][$n]['PRESENT'] = !empty(DiscountsHelper::getGiftIds($item['ID']));
	}
}

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

foreach ($arResult['ITEMS'] as $n => $item) {
	$arResult['ITEMS'][$n]['RAZMER_OBUV'] = $arResult['RAZMER_OBUV'];
	$arResult['ITEMS'][$n]['RAZMER_ODEZHDA_ZHENSKAYA'] = $arResult['RAZMER_ODEZHDA_ZHENSKAYA'];
	$arResult['ITEMS'][$n]['RAZMER_NOSKI'] = $arResult['RAZMER_NOSKI'];
	$arResult['ITEMS'][$n]['RAZMER_AKSESSUAROV_'] = $arResult['RAZMER_AKSESSUAROV_'];
	$arResult['ITEMS'][$n]['RAZMER'] = $arResult['RAZMER'];
}


init_nav($arResult);

$arResult = modify_result($arResult);

$sections = CIBlockSection::GetList([], ['IBLOCK_ID' => 16], false, ['UF_*']);
$sections_ind = 0;
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
    if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $s['UF_DOUBLE_BONUS'] === '1') $sids_db[] = $s['ID'];
}

foreach ($arSections as $s) {
    if (in_array($s['IBLOCK_SECTION_ID'], $sids_db)) $sids_db[] = $s['ID'];
}

foreach ($arResult['ITEMS'] as $n => $item) {
	if (in_array($item['IBLOCK_SECTION_ID'], $sids_db)) {
		$arResult['ITEMS'][$n]['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';
	}
}

