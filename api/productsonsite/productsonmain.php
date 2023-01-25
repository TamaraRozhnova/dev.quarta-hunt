<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

CModule::IncludeModule('iblock');

$el = CIBlockElement::GetByID(34117);

if ($data = $el->GetNextElement()) {
	$p = $data->GetProperties();
	
	$res = CIBlockElement::GetList(['rand' => 'asc'], ['IBLOCK_ID' => 16, 'ID' => $p['PRODUCTS']['VALUE']], false, false, 
		['ID', 'NAME', 'CODE', 'CATALOG_PRICE_1', 'CATALOG_PRICE_ID_1', 'CATALOG_CURRENCY_1', 'CATALOG_GROUP_NAME_1', 
			'PROPERTY_CML2_ARTICLE']);

	while ($product = $res->GetNextElement()) {
		$f = $product->GetFields();
		$discount = CCatalogDiscount::GetDiscountByProduct($f['ID'], [1, 2, 3, 4, 6, 9], 'N', [], SITE_ID);
		$f['DISCOUNT'] = !empty($discount) ? current($discount) : null;
		$arItems[] = $f;
	}

	$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $p['PRODUCTS']['VALUE']], false, false,
		['ID', 'PROPERTY_PRODUCT_ID', 'PROPERTY_RATING']);

	foreach ($arItems as &$item2) 
		$item2['FEEDBACK'] = [];

	while ($feed = $res->GetNextElement()) {
		$f = $feed->GetFields();
		foreach ($arItems as $i => $item)
			if ($f['PROPERTY_PRODUCT_ID_VALUE'] === $item['ID']) $arItems[$i]['FEEDBACK'][] = $f;
	}

	$arResult['ITEMS'] = modify_result($arItems);
	$arResult['error'] = false;
	$arResult['message'] = '';	
} else {
	$arResult['error'] = true;
	$arResult['message'] = 'Элемент не найден';
}


ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>