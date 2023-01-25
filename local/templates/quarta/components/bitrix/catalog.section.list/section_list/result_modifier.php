<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/*
foreach($arResult['SECTIONS'] as $i => $sect) {
	$count = CIBlockSection::GetSectionElementsCount($sect['ID'], []);
	$arResult['SECTIONS'][$i]['ELEMENT_COUNT'] = $count;
}
*/
$arResult = modify_result($arResult);

?>