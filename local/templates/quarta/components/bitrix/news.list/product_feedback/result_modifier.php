<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as $n => $item) {
    foreach ($item['PROPERTIES']['IMAGES']['VALUE'] as $i => $val) {
        $arResult['ITEMS'][$n]['PROPERTIES']['IMAGES']['SRC'][$i] = CFile::GetPath($val);
    }

	$user_result = CUser::GetByID($item['PROPERTIES']['USER_ID']['VALUE']);

	if ($user = $user_result->GetNext()) {
		$arResult['ITEMS'][$n]['PROPERTIES']['USER_ID'] = $user;
	}

	$product_result = CIBlockElement::GetByID($item['PROPERTIES']['PRODUCT_ID']['VALUE']);

	if ($product = $product_result->GetNext()) {
		$arResult['ITEMS'][$n]['PROPERTIES']['PRODUCT_ID'] = $product;
	}

	$resp = CIBlockElement::GetList(['created' => 'asc'], ['IBLOCK_ID' => 28, 'ID' => $item['PROPERTIES']['RESPONSES']['VALUE']]);

	while ($r = $resp->GetNextElement()) {
		$f = $r->GetFields();
		$f['PROPERTIES'] = $r->GetProperties();
		$user_result = CUser::GetByID($f['PROPERTIES']['USER_ID']['VALUE']);
		if ($user = $user_result->GetNext()) {
			$f['PROPERTIES']['USER_ID'] = $user;
		}
		$arResult['ITEMS'][$n]['PROPERTIES']['RESPONSES']['INF'][] = $f;
	}

	$user_id = false;

	if ($USER && $USER->isAuthorized()) $user_id = $USER->GetID();

	if ($user_id && !empty($item['PROPERTIES']['LIKES']['VALUE']) && strpos($item['PROPERTIES']['LIKES']['VALUE'], $user_id) !== false) {
		$arResult['ITEMS'][$n]['LIKE'] = '1';
	} else {
		$arResult['ITEMS'][$n]['LIKE'] = '0';
	}

	if ($user_id && !empty($item['PROPERTIES']['DISLIKES']['VALUE']) && strpos($item['PROPERTIES']['DISLIKES']['VALUE'], $user_id) !== false) {
		$arResult['ITEMS'][$n]['DISLIKE'] = '1';
	} else {
		$arResult['ITEMS'][$n]['DISLIKE'] = '0';
	}

	if ($user_id && !empty($item['PROPERTIES']['LIKES']['VALUE'])) {
		$arResult['ITEMS'][$n]['PROPERTIES']['LIKES']['VALUE'] = strval(count(explode(',', $item['PROPERTIES']['LIKES']['VALUE'])));
	} else {
		$arResult['ITEMS'][$n]['PROPERTIES']['LIKES']['VALUE'] = '0';
	}

	if ($user_id && !empty($item['PROPERTIES']['DISLIKES']['VALUE'])) {
		$arResult['ITEMS'][$n]['PROPERTIES']['DISLIKES']['VALUE'] = strval(count(explode(',', $item['PROPERTIES']['DISLIKES']['VALUE'])));
	} else {
		$arResult['ITEMS'][$n]['PROPERTIES']['DISLIKES']['VALUE'] = '0';
	}

}

$arResult['CURRENT_USER_ID'] = $user_id;

$arResult = modify_result($arResult);


