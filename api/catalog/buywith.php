<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('iblock');

$arResult['ITEMS'] = [];
$ids = [];
$buy_ids = [];
$count = 4;


if (!empty($_REQUEST['ID'])) {
	$res = CIBlockElement::GetByID($_REQUEST['ID']);
	
	if ($product = $res->GetNextElement()) {
		$props = $product->GetProperties();
		$buy_ids = $props['BUY_WITH_THIS']['VALUE'];
	}

	if (!empty($buy_ids)) {
		$res = CIBlockElement::GetList(
			['rand' => 'asc'], 
			['IBLOCK_ID' => 16, 'ID' => $buy_ids, '>*CATALOG_QUANTITY' => 0], 
			false, 
			false, 
			['ID', 'NAME', 'CODE', 'DETAIL_PICTURE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1', 'PROPERTY_CML2_ARTICLE']
		);
	
		while ($product = $res->GetNextElement()) {
			$f = $product->GetFields();
			$discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
			$f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
			$f['FEEDBACK'] = [];
			$f['DETAIL_PICTURE'] = $f['DETAIL_PICTURE'] !== null ? CFile::GetPath($f['DETAIL_PICTURE']) : '';
			$arResult['ITEMS'][] = $f;
			$count--;
			if ($count === 0) break;
		}
	}
}


$count = 4 - count($arResult['ITEMS']);

$res = CIBlockElement::GetList(
	['rand' => 'asc'], 
	['IBLOCK_ID' => 16, 'SECTION_ID' => $_REQUEST['SECTION_ID'], '>*CATALOG_QUANTITY' => 0, 'INCLUDE_SUBSECTIONS' => 'Y'], 
	false, 
	false, 
    ['ID', 'NAME', 'CODE', 'DETAIL_PICTURE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1', 'PROPERTY_CML2_ARTICLE']
);

while ($product = $res->GetNextElement()) {
    $f = $product->GetFields();
    $discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
    $f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
	$f['FEEDBACK'] = [];
	$f['DETAIL_PICTURE'] = $f['DETAIL_PICTURE'] !== null ? CFile::GetPath($f['DETAIL_PICTURE']) : '';
    $arResult['ITEMS'][] = $f;
	$count--;
	if ($count === 0) break;
}


$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $ids], false, false, 
	['ID', 'PROPERTY_PRODUCT_ID', 'PROPERTY_RATING']);

while ($feed = $res->GetNextElement()) {
    $f = $feed->GetFields();
    foreach ($arResult['ITEMS'] as $i => $item)
		if ($f['PROPERTY_PRODUCT_ID_VALUE'] === $item['ID']) $arResult['ITEMS'][$i]['FEEDBACK'][] = $f;
}


$arResult = modify_result($arResult);

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>