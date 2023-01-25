<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//unset($arResult['COMBO']);
//unset($arResult['PROPERTY_ID_LIST']);

$items = [];

foreach ($arResult['ITEMS'] as $i)
	if (!empty($i['VALUES'])) $items[] = $i;

$arResult = modify_result($items);

