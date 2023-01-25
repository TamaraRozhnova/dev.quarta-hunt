<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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
					'UF_BONUS_POINTS',
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

function init_nav(&$arResult)
{
	$arResult['NAV']['B_NAV_START'] = $arResult['NAV_RESULT']->bNavStart;
	$arResult['NAV']['NAV_NUM'] = $arResult['NAV_RESULT']->NavNum;
	$arResult['NAV']['NAV_PAGE_COUNT'] = $arResult['NAV_RESULT']->NavPageCount;
	$arResult['NAV']['NAV_PAGE_NOMER'] = $arResult['NAV_RESULT']->NavPageNomer;
	$arResult['NAV']['NAV_PAGE_SIZE'] = $arResult['NAV_RESULT']->NavPageSize;
	$arResult['NAV']['NAV_RECORD_COUNT'] = $arResult['NAV_RESULT']->NavRecordCount;
	$arResult['NAV']['N_START_PAGE'] = $arResult['NAV_RESULT']->nStartPage;
	$arResult['NAV']['N_END_PAGE'] = $arResult['NAV_RESULT']->nEndPage;
}

function get_prices()
{
	global $USER;

	if ($USER && $USER->isAuthorized()) {
		if (in_array('9', $USER->GetUserGroup($USER->GetID())))
			$prices = array('OPT_SMALL');
		else
			$prices = array('BASE');
	} else {
		$prices = array('BASE');
	}

	return $prices;
}

function get_user_type()
{
	global $USER;

	if ($USER && $USER->isAuthorized())
		$opt = in_array('9', $USER->GetUserGroup($USER->GetID()));
	else
		$opt = false;

	return $opt;
}


use Bitrix\Sale\Compatible\DiscountCompatibility;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Discount\Gift;
use Bitrix\Sale\Fuser;

class DiscountsHelper
{
    public static function getGiftIds($productId)
    {
        $giftProductIds = [];

        if (!$productId) {
            return $giftProductIds;
        }

        DiscountCompatibility::stopUsageCompatible();

        $giftManager = Gift\Manager::getInstance();

        $potentialBuy = [
            'ID'                     => $productId,
            'MODULE'                 => 'catalog',
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
            'QUANTITY'               => 1,
        ];

        $basket = Basket::loadItemsForFUser(Fuser::getId(), SITE_ID);
        
        $basketPseudo = $basket->copy();

        foreach ($basketPseudo as $basketItem) {
            $basketItem->delete();
        }

        $collections = $giftManager->getCollectionsByProduct($basketPseudo, $potentialBuy);

        foreach ($collections as $collection) {
            foreach ($collection as $gift) {
                $giftProductIds[] = $gift->getProductId();
            }
        }

        DiscountCompatibility::revertUsageCompatible();

        return $giftProductIds;
    }
}

?>
