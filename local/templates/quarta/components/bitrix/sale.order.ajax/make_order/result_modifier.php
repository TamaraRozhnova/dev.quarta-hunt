<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

unset($arResult['JS_DATA']);
unset($arResult['GRID']);
unset($arResult['ITEMS_DIMENSIONS']);
unset($arResult['MAX_DIMENSIONS']);
unset($arResult['LOCATIONS']);
unset($arResult['WARNING']);

$arResult = modify_result($arResult);

$sections = CIBlockSection::GetList([], ['IBLOCK_ID' => 16], false, ['UF_*']);
$sections_ind = 0;
$sids = [];

while ($s = $sections->GetNext()) {
	$arSections[$sections_ind]['IBLOCK_ID'] = $s['IBLOCK_ID'];
	$arSections[$sections_ind]['IBLOCK_SECTION_ID'] = $s['IBLOCK_SECTION_ID'];
	$arSections[$sections_ind]['XML_ID'] = $s['XML_ID'];
	$arSections[$sections_ind]['ID'] = $s['ID'];
	$arSections[$sections_ind]['NAME'] = $s['NAME'];
	$arSections[$sections_ind]['CODE'] = $s['CODE'];
	$arSections[$sections_ind]['SECTION_PAGE_URL'] = $s['SECTION_PAGE_URL'];
	$arSections[$sections_ind]['UF_BONUS_SYSTEM_ACTIVE'] = $s['UF_BONUS_SYSTEM_ACTIVE'];
	$arSections[$sections_ind]['UF_LISENCE_PRODUCTS'] = $s['UF_LISENCE_PRODUCTS'];
	$sections_ind++;
}

foreach ($arSections as $s) {
	if ($s['UF_LISENCE_PRODUCTS'] === '1') $sids[] = $s['ID'];
}

foreach ($arSections as $s) {
	if (in_array($s['IBLOCK_SECTION_ID'], $sids)) $sids[] = $s['ID'];
}

$ids = [];
$product_license = false;

foreach ($arResult['BASKET_ITEMS'] as $item)
	$ids[] = $item['PRODUCT_ID'];

if (!empty($ids)) {

	$b_items = CIBlockElement::GetList([], ['IBLOCK_ID' => 16, 'ID' => $ids]);

	while ($b_item = $b_items->GetNext()) {
		if (in_array($b_item['IBLOCK_SECTION_ID'], $sids)) $product_license = true;
	}

}

$arResult['PRODUCT_LICENSE'] = $product_license;

/** getting sections id by character codes, $sectionsName array for codes **/
$sectionsName = ['odezhda','obuv'];
$sectionsID = [];
$getIdSection = CIBlockSection::GetList(array("SORT"=>"ASC"), array('IBLOCK_ID' => 16, 'CODE' => $sectionsName), false, array('ID','CODE'));
while ($item = $getIdSection->Fetch()){
    $sectionsID[] = array('IBLOCK_SECTION_'.$item['CODE'] => $item['ID']);
}

$clothes = false;
$shoes = false;
$clothes_and_shoes = false;

/** array of current products id (start) **/
$arrayProductID = [];
foreach ($arResult['BASKET_ITEMS'] as $n => $item) {
    if (CModule::IncludeModule("catalog")){
        $mxResult = CCatalogSku::GetProductInfo($item['PRODUCT_ID']);
        if (is_array($mxResult)){
            array_push($arrayProductID, $mxResult['ID']);
        }
    }
    array_push($arrayProductID, $item['PRODUCT_ID']);
}
/** array of current products id (end) **/

/** obtaining sections by elements and displaying the necessary product categories (start) **/
$getElementsSection = CIBlockElement::GetElementGroups($arrayProductID, true);
while($res = $getElementsSection->Fetch()){
    if ($res['IBLOCK_SECTION_ID'] == intval($sectionsID[0]['IBLOCK_SECTION_'.$sectionsName[0]]) || $res['ID'] == intval($sectionsID[0]['IBLOCK_SECTION_'.$sectionsName[0]])) $clothes = true;
    if ($res['IBLOCK_SECTION_ID'] == intval($sectionsID[1]['IBLOCK_SECTION_'.$sectionsName[1]]) || $res['ID'] == intval($sectionsID[1]['IBLOCK_SECTION_'.$sectionsName[1]])) $shoes = true;
}
if ($clothes && $shoes){
    $clothes_and_shoes = true;
}
/** obtaining sections by elements and displaying the necessary product categories (end) **/
$onlyPickup = false;
if ($clothes || $shoes || $clothes_and_shoes || $product_license){
    $onlyPickup = true;
}
$arResult['PRODUCT_LICENSE'] = $product_license;
$arResult['CLOTHES'] = $clothes;
$arResult['SHOES'] = $shoes;
$arResult['ALL_CLOTHES_AND_SHOES'] = $clothes_and_shoes;
$arResult['ONLY_PICKUP'] = $onlyPickup;

$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());

$arResult['SDEK_DELIVERY_PRICE_EXTRA'] = 1.5 * $basket->getPrice() / 100 + 50;

