<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


function modify_result($inResult, $exf = [])
{
    $defFields = [
        'ID',
        'NAME',
        'ACTIVE',
        'ACTIVE_FROM',
        'ACTIVE_TO',
        'PREVIEW_TEXT',
        '~PREVIEW_TEXT',
        'DETAIL_TEXT',
        '~DETAIL_TEXT',
        'DATE_CREATE',
        'CREATED_BY',
        'TIMESTAMP_X',
        'IBLOCK_SECTION_ID',
        'DETAIL_PAGE_URL',
        'PREVIEW_PICTURE',
        'DETAIL_PRICTURE',
        'CODE',
        'VALUE',
        '~VALUE',
        'IBLOCK_ID',
        'SRC',
        'DESCRIPTION',
        'FILE_NAME',
        'FILE_SIZE',
        'FILE_SIZE_FORMATED',
        'WIDTH',
        'HEIGHT',
        'FILE_TYPE',
        'TITLE',
        'ALT',
        'PRICE_ID',
        'CURRENCY',
        'DISCOUNT_VALUE',
        'DISCOUNT_DIFF',
        'DISCOUNT_DIFF_PERCENT',
        'PRINT_VALUE',
        'PRINT_DISCOUNT_VALUE',
        'PRINT_DISCOUNT_DIFF',
        'TEXT',
        'TYPE',
        'PERSON_TYPE_ID',
        'PAYED',
        'DATE_PAYED',
        'CANCELED',
        'DATE_CANCELED',
        'DATE_STATUS',
        'DATE_MARKED',
        'DATE_ALLOW_DELIVERY',
        'DATE_DEDUCTED',
        'DATE_INSERT',
        'DATE_UPDATE',
        'DATE_INSERT_FORMATED',
        'DATE_STATUS_FORMATED',
        'DATE_UPDATE_FORMATED',
        'PRICE_DELIVERY',
        'PRICE',
        'SUM_PAID',
        'USER_ID',
        'PAY_SYSTEM_ID',
        'DELIVERY_ID',
        'TAX_VALUE',
        'ACCOUNT_NUMBER',
        'TRACKING_NUMBER',
        'XML_ID',
        'URL_TO_DETAIL',
        'URL_TO_COPY',
        'URL_TO_CANCEL',
        'PRODUCT_ID',
        'PRODUCT_PRICE_ID',
        'PRICE_TYPE_ID',
        'BASE_PRICE',
        'WEIGHT',
        'QUANTITY',
        'DISCOUNT_PRICE',
        'CATALOG_XML_ID',
        'PRODUCT_XML_ID',
        'DISCOUNT_NAME',
        'DISCOUNT_COUPON',
        'NAME~',
        'NOTES~',
        'MEASURE_TEXT',
        'STATUS_ID',
        'DELIVERY_NAME',
        'SYSTEM',
        'DELIVERY_ID',
        'ORDER_ID',
        'PAY_SYSTEM_NAME',
        'PAY_SYSTEM_ID',
        'PAID',
        'SUM',
        'IS_CASH',
        'EXTERNAL_ID',
        'PRINT_BASE_PRICE',
        'RATIO_BASE_PRICE',
        'PRINT_PRICE',
        'RATIO_PRICE',
        'HASH',
        'PRICE_FORMATED',
        'FULL_PRICE',
        'FULL_PRICE_FORMATED',
        'DISCOUNT_PRICE',
        'DISCOUNT_PRICE_FORMATED',
        'SUM_PRICE',
        'SUM_PRICE_FORMATED',
        'SUM_FULL_PRICE',
        'SUM_FULL_PRICE_FORMATED',
        'SUM_DISCOUNT_PRICE',
        'SUM_DISCOUNT_PRICE_FORMATED',
        'MEASURE_RATIO',
        'AVAILABLE_QUANTITY',
        'PRODUCT_QUANTITY',
        'CATALOG_GROUP_NAME',
        'CHECKED',
        'CONTENT_TYPE',
        'DATE_UPDATE',
        'PERSON_TYPE',
        'DELIVERY',
        'PAY_SYSTEM',
        'PICK_UP',
        'MEASURE_CODE',
        'PRODUCT_XML_ID',
        'SUM_NUM',
        'SUM_BASE',
        'SUM_BASE_FORMATED',
        'SUM_DISCOUNT_DIFF',
        'SUM_DISCOUNT_DIFF_FORMATED',
        'PREVIEW_PICTURE_SRC',
        'DETAIL_PICTURE_SRC',
        'MEASURE',
        'PSA_NAME',
        'PSA_LOGOTIP_SRC',
        'PSA_LOGOTIP_SRC_2X',
        'PSA_LOGOTIP_SRC_ORIGINAL',
        'OWN_NAME',
        'LOGOTIP_SRC',
        'LOGOTIP_SRC_2X',
        'LOGOTIP_SRC_ORIGINAL',
        'ADDRESS',
        'IMAGE_ID',
        'PHONE',
        'SCHEDULE',
        'GPS_N',
        'GPS_S',
        'BASKET_POSITIONS',
        'PRICE_WITHOUT_DISCOUNT_VALUE',
        'PRICE_WITHOUT_DISCOUNT',
        'BASKET_PRICE_DISCOUNT_DIFF_VALUE',
        'BASKET_PRICE_DISCOUNT_DIFF',
        'PAYED_FROM_ACCOUNT_FORMATED',
        'ORDER_TOTAL_PRICE',
        'ORDER_TOTAL_PRICE_FORMATED',
        'ORDER_WEIGHT',
        'ORDER_WEIGHT_FORMATED',
        'ORDER_PRICE',
        'ORDER_PRICE_FORMATED',
        'USE_VAT',
        'VAT_RATE',
        'VAT_SUM',
        'VAT_SUM_FORMATED',
        'TAX_PRICE',
        'VALUE_FORMATED',
        'VALUE_MONEY',
        'VALUE_MONEY_FORMATED',
        'IS_IN_PRICE',
        'DISCOUNT_PRICE',
        'DISCOUNT_PRICE_FORMATED',
        'DELIVERY_PRICE',
        'DELIVERY_PRICE_FORMATED',
        'PAY_SYSTEM_PRICE',
        'PAY_SYSTEM_PRICE_FORMATTED',
        'CAN_BUY',
        'VAT_INCLUDED',
        'VAT_VALUE',
        'WEIGHT_FORMATED',
        'DISCOUNT_PRICE_PERCENT',
        'DISCOUNT_PRICE_PERCENT_FORMATED',
        'BASE_PRICE_FORMATED',
        'BASE_LANG_CURRENCY',
        'WEIGHT_UNIT',
        'DISCOUNT_PERCENT',
        'DELIVERY_SUM',
        'DISCOUNT_PERCENT_FORMATED',
        'DELIVERY_LOCATION',
        'FINAL_STEP',
        'ORDER_DESCRIPTION',
        'PROFILE_ID',
        'DELIVERY_LOCATION_ZIP',
        'URL',
        'REST_API_URL',
        'URL_WO_PARAMS',
        'DATE_CHANGE',
        'FULL_DATE_CHANGE',
        'REQUEST',
        'HOW',
        'FROM',
        'TO',
        'QUERY',
        'TAGS_ARRAY',
        'TAGS',
        'WHERE',
        'NAV_STRING',
        'NAV',
        'NAV_NUM',
        'NAV_PAGE_COUNT',
        'NAV_PAGE_NOMER',
        'NAV_PAGE_SIZE',
        'NAV_RECORD_COUNT',
        'N_START_PAGE',
        'N_END_PAGE',
        'CONTROL_ID',
        'CONTROL_NAME',
        'CONTROL_NAME_ALT',
        'HTML_VALUE_ALT',
        'UPPER',
        'URL_ID',
        'SORT',
        'ELEMENT_CNT',
        'ELEMENT_CNT_TITLE',
        'NOTES',        
        'UF_BONUS_SYSTEM_ACTIVE',
        'DISCOUNT',
        'PERSENT',
        'PRINT_DISCOUNT',
        'RATIO_DISCOUNT',
        'PRINT_RATIO_DISCOUNT',
        'MIN_QUANTITY',
        'KIT',
        'CML2_ARTICLE',
        'ITEM_ID',
        'DETAIL_PICTURE',
        'PRESENT',
        'ELEMENT_COUNT',
        'IMAGE_URL',
        'PRICE_1_DISCOUNT',
        'PRICE_1_TOTAL',
        'DISCOUNT_PERSENT',
        'CML2_ARTICLE',
        'CATALOG_PRICE_1',
        'CATALOG_PRICE_2',
        'CATALOG_PRICE_3',
        'CATALOG_PRICE_ID_1',
        'CATALOG_PRICE_ID_2',
        'CATALOG_PRICE_ID_3',
        'CATALOG_CURRENCY_1',
        'CATALOG_CURRENCY_2',
        'CATALOG_CURRENCY_3',
        'CATALOG_GROUP_NAME_1',
        'CATALOG_GROUP_NAME_2',
        'CATALOG_GROUP_NAME_3',
        'CATALOG_QUANTITY',
        'PROPERTY_CML2_ARTICLE_VALUE',
        'PROPERTY_PRODUCT_ID',
        'PROPERTY_USER_ID',
        'PROPERTY_RAITING',
        'PROPERTY_PRODUCT_ID_VALUE',
        'PROPERTY_RATING_VALUE',
        'LIKE',
        'DISLIKE',
        'allSum',
        'allSum_FORMATED',
        'DISCOUNT_PRICE_ALL',
        'DISCOUNT_PRICE_ALL_FORMATED',
        'DISCOUNT_PRICE_FORMATED',
        'allVATSum',
        'allVATSum_FORMATED',
        'allSum_wVAT_FORMATED',
        'COUPON',
        'COUPON_LIST',
        'APPLIED_DISCOUNT_LIST',
        'FULL_DISCOUNT_LIST',
        'EMPTY_BASKET',
        'WARNING_MESSAGE',
        'WARNING_MESSAGE_WITH_CODE',
        'ERROR_MESSAGE',
        'BASKET_ITEMS_COUNT',
        'ORDERABLE_BASKET_ITEMS_COUNT',
        'NOT_AVAILABLE_BASKET_ITEMS_COUNT',
        'DELAYED_BASKET_ITEMS_COUNT',
        'BASKET_ITEM_MAX_COUNT_EXCEEDED',
        'FORMAT_STRING',
        'DEC_POINT',
        'THOUSANDS_SEP',
        'DECIMALS',
        'THOUSANDS_VARIANT',
        'HIDE_ZERO',
        'DISABLE_CHECKOUT',
        'PRICE_WITHOUT_DISCOUNT_FORMATED',
        'SHOW_VAT',
        'SUM_WITHOUT_VAT_FORMATED',
        'MAIN_PRODUCT_ID',
        'SKU_ID',
        'BASKET_REFRESHED',
        'VALID_COUPON',
        'APPLIED_DISCOUNT_IDS',
        'VALUE_TYPE',
        'DISCOUNT_ID',
        'DISCOUNT_NAME',
        'DISCOUNT_ACTIVE',
        'DISCOUNT_ACTIVE_FROM',
        'DISCOUNT_ACTIVE_TO',
        'All',
        'True',
        'False',
        'Type',
        'Value',
        'Unit',
        'Max',
        'logic',
        'value',
        'CLASS_ID',
        'LIMIT_VALUE',
        'COUPON',
        'MODE',
        'STATUS',
        'SAVED',
        'MODULE',
        'MODULE_ID',
        'IPROPERTY_VALUES',
        'ELEMENT_META_TITLE',
        'ELEMENT_META_KEYWORDS',
        'ELEMENT_META_DESCRIPTION',
        'ELEMENT_PAGE_TITLE',
        'SECTION_META_TITLE',
        'SECTION_META_KEYWORDS',
        'SECTION_META_DESCRIPTION',
        'SECTION_PAGE_TITLE',
        'CURRENT_USER_ID',
    ];

    $outResult = [];

    foreach($inResult as $k => $val) {
        if ($k === 'DISPLAY_PROPERTIES') continue;
        if (!is_int($k) && in_array($k, $exf)) continue;
        if (is_array($val)) {
            if (!empty($val)) {
                if (isset($val['VALUE']) && ($val['VALUE'] === '' || $val['VALUE'] === null))
                    $val['VALUE'] = false;
                else
                    $outResult[$k] = modify_result($val, $exf);
            } else {
                $outResult[$k] = [];
            }
        } else {
            if (in_array($k, $defFields) || is_int($k)) $outResult[$k] = $val;
        }
    }

    return $outResult;
}

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

