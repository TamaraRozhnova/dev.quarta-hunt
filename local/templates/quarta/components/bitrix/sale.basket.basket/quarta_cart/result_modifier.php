<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$ids = [];

foreach($arResult['BASKET_ITEM_RENDER_DATA'] as $item) $ids[] = $item['PRODUCT_ID'];

$list = CIBlockElement::GetList([], ['IBLOCK_ID' => 11, 'PROPERTY_PRODUCT_ID' => $ids]);

while($i = $list->GetNextElement()) {
    $f = $i->GetFields();
    $p = $i->GetProperties();

    $f['USER_ID'] = $p['USER_ID'];
    $f['PRODUCT_ID'] = $p['PRODUCT_ID'];
    $f['RATING'] = $p['RATING'];

    foreach($arResult['BASKET_ITEM_RENDER_DATA'] as $n => $item)
        if ($item['PRODUCT_ID'] == $p['PRODUCT_ID']['VALUE']) $arResult['BASKET_ITEM_RENDER_DATA'][$n]['FEEDBACK'][] = $f;
}


foreach($arResult['ITEMS']['AnDelCanBuy'] as $i => $item) {
	$arResult['BASKET_ITEM_RENDER_DATA'][$i]['NOTES'] = unserialize(htmlspecialchars_decode($item['NOTES']));
}

$arResult['ITEMS'] = $arResult['BASKET_ITEM_RENDER_DATA'];

unset($arResult['BASKET_ITEM_RENDER_DATA']);
unset($arResult['GRID']);

$arResult = modify_result($arResult);

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
	if ($s['UF_LISENCE_PRODUCTS'] === '1') $sids[] = $s['ID'];
	if ($s['UF_BONUS_SYSTEM_ACTIVE'] === '1' && $s['UF_DOUBLE_BONUS'] === '1') $sids_db[] = $s['ID'];
}

foreach ($arSections as $s) {
	if (in_array($s['IBLOCK_SECTION_ID'], $sids)) $sids[] = $s['ID'];
	if (in_array($s['IBLOCK_SECTION_ID'], $sids_db)) $sids_db[] = $s['ID'];
}


foreach ($arResult['ITEMS'] as $n => $item) {
	foreach ($item['PROPS'] as $prop) {
		if ($prop['CODE'] === 'IBLOCK_SECTION_ID' && in_array($prop['VALUE'], $sids_db))
	        $arResult['ITEMS'][$n]['DOUBLE_BONUS'] = 'Да';
	}
}


$product_license = false;

if (!empty($ids)) {
    $b_items = CIBlockElement::GetList([], ['IBLOCK_ID' => 16, 'ID' => $ids], false, false, ['ID', 'IBLOCK_SECTION_ID', 'PROPERTY_CML2_ARTICLE']);

    while ($b_item = $b_items->GetNext()) {
        if (in_array($b_item['IBLOCK_SECTION_ID'], $sids)) $product_license = true;

        $test123[] = [
            "IBLOCK_SECTION_ID" => $b_item['IBLOCK_SECTION_ID']
        ];
		foreach ($arResult as $j => $data) {
			if ($b_item['ID'] === $data['PRODUCT_ID']) {
				$arResult[$j]['CML2_ARTICLE'] = $b_item['PROPERTY_CML2_ARTICLE_VALUE'];
				$arResult[$j]['IBLOCK_SECTION_ID'] = $b_item['IBLOCK_SECTION_ID'];
			}
		}

    }
}


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
foreach ($arResult['ITEMS'] as $n => $item) {
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


//$userId = \Bitrix\Main\Engine\CurrentUser::get()->getId();
//$giftManager = \Bitrix\Sale\Discount\Gift\Manager::getInstance()->setUserId($userId);

//$basketStorage = \Bitrix\Sale\Basket\Storage::getInstance(\Bitrix\Sale\Fuser::getId(), SITE_ID);
//$basketStorage = \Bitrix\Sale\Basket\Storage::getInstance($userId, SITE_ID);
//$basket = $basketStorage->getBasket();

//$basket = \Bitrix\Sale\Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);

//$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
//$basket = \Bitrix\Sale\Basket::loadItemsForFUser($userId, SITE_ID);

//$collections = $giftManager->getCollectionsByBasket($basket);
//$collections = $giftManager->getCollectionsByProduct($basket, ['PRODUCT_ID' => 4849, 'MODULE' => 'catalog', 
//	'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider', 'QUANTITY' => 1]);
//$collections = $giftManager->getCollectionsByProduct($basket, ['PRODUCT_ID' => 4849]);

//foreach ($collections as $collection)
//	foreach ($collection as $gift)
//		$arResult['col'][] = $gift->getProductId();

//$arResult['fusr'] = \Bitrix\Sale\Fuser::getId();
//$arResult['usr'] = $userId;
//$arResult['mgr'] = $giftManager;

