<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?

global $USER;

if ($USER->isAuthorized()) {
	CModule::IncludeModule("iblock");

	$r = CIBlockElement::GetList([], ['IBLOCK_ID' => 21, 'PROPERTY_USER_ID' => $USER->GetID()]);

	if ($l = $r->GetNextElement()) {
		$field = $l->GetFields();
		$props = $l->GetProperties();
		$r = CIBlockElement::GetList([], ['IBLOCK_ID' => 16, 'ID' => $props['PRODUCT_ID']['VALUE']]);
		while ($i = $r->GetNextElement()) {
			$p = $i->GetFields();
			$p['PROPERTIES'] = $i->GetProperties();
			$p['PRICE'] = CPrice::GetBasePrice($p['ID']);
			foreach ($p['PROPERTIES']['MORE_PHOTO']['VALUE'] as $val) $p['PROPERTIES']['MORE_PHOTO']['SRC'][] = CFile::GetPath($val);
			foreach ($p['PROPERTIES']['FILES']['VALUE'] as $val) $p['PROPERTIES']['FILES']['SRC'][] = CFile::GetPath($val);
			$arResult['items'][] = $p;
		}
		$r = CIBlockElement::GetList([], ['IBLOCK_ID' => 27, 'ID' => $props['PRODUCT_ID']['VALUE']]);
		while ($i = $r->GetNextElement()) {
			$p = $i->GetFields();
			$p['PROPERTIES'] = $i->GetProperties();
			$p['PRICE'] = CPrice::GetBasePrice($p['ID']);
			foreach ($p['PROPERTIES']['MORE_PHOTO']['VALUE'] as $val) $p['PROPERTIES']['MORE_PHOTO']['SRC'][] = CFile::GetPath($val);
			foreach ($p['PROPERTIES']['FILES']['VALUE'] as $val) $p['PROPERTIES']['FILES']['SRC'][] = CFile::GetPath($val);
			$arResult['items'][] = $p;
		}
		$arResult['items'] = modify_result($arResult['items']);
		if (empty($arResult['items'])) {
			$arResult['error'] = false;
			$arResult['message'] = 'В избранном ничего нет';
		}
	} else {
		$uid = $USER->GetID();
		$name = 'fav_' . $uid;
		$pids = [];
		$el = new CIBlockElement();
		$r = $el->Add(['IBLOCK_ID' => 21,'NAME' => $name, 'CODE' => $name, 'XML_ID' => $name, 'PROPERTY_VALUES' => ['USER_ID' => $uid, 'PRODUCT_ID' => $pids]]);
		$arResult['items'] = [];
		$arResult['error'] = $r;
		$arResult['message'] = $r ? 'Нет избранного' : $el->LAST_ERROR;
	}

	if (!empty($_REQUEST['ACT'])) {

		$in_fav = false;
		foreach ($arResult['items'] as $fv)
			if ($fv['ID'] === $_REQUEST['PRODUCT_ID']) $in_fav = true;
		if ($in_fav && $_REQUEST['ACT'] === 'ADD') {
			$arResult['items'] = [];
			$arResult['error'] = true;
			$arResult['message'] = 'Товар уже в избранном';
		} else {
			if ($_REQUEST['ACT'] === 'ADD' && !empty($_REQUEST['PRODUCT_ID'])) {
				$uid = $USER->GetID();
				$pids = [];
				foreach ($arResult['items'] as $fv) $pids[] = $fv['ID'];
				$pids[] = $_REQUEST['PRODUCT_ID'];
				$el = new CIBlockElement();
				$r = $el->Update($field['ID'], ['PROPERTY_VALUES' => ['USER_ID' => $uid, 'PRODUCT_ID' => $pids]]);
				$arResult['items'] = [];
				$arResult['error'] = $r;
				$arResult['message'] = $r ? 'Товар добавлен в избранное' : $el->LAST_ERROR;
			} else
			if ($_REQUEST['ACT'] === 'DEL' && !empty($_REQUEST['PRODUCT_ID'])) {
				$uid = $USER->GetID();
				$pids = [];
				foreach ($arResult['items'] as $fv) 
					if ($_REQUEST['PRODUCT_ID'] !== $fv['ID']) $pids[] = $fv['ID'];
				$el = new CIBlockElement();
				$r = $el->Update($field['ID'], ['PROPERTY_VALUES' => ['USER_ID' => $uid, 'PRODUCT_ID' => $pids]]);
				$arResult['items'] = [];
				$arResult['error'] = $r;
				$arResult['message'] = $r ? 'Товар удален из избранного' : $el->LAST_ERROR;
			} else
			if ($_REQUEST['ACT'] === 'CLR') {
				$uid = $USER->GetID();
				$pids = [];
				$el = new CIBlockElement();
				$r = $el->Update($field['ID'], ['PROPERTY_VALUES' => ['USER_ID' => $uid, 'PRODUCT_ID' => $pids]]);
				$arResult['items'] = [];
				$arResult['error'] = $r;
				$arResult['message'] = $r ? 'Избранное очищено' : $el->LAST_ERROR;
			} else {
				$arResult['items'] = [];
				$arResult['error'] = true;
				$arResult['message'] = 'Ошибка запроса';
			}
		}

	}

} else {
	$arResult['items'] = [];
	$arResult['error'] = true;
	$arResult['message'] = 'Пользователь не авторизован';
}

ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

echo json_encode($arResult);

die();


?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

