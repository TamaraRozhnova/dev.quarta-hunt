<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Loader;
use General\User;

if (!Loader::includeModule('iblock'))
    throw new Bitrix\Main\SystemException('Module iblock is not initialized');

if (!Loader::includeModule('currency'))
    throw new Bitrix\Main\SystemException('Module iblock is not initialized');

/** Тип цены пользователя */
$user = new User();
$priceCode = $user->getUserPriceCode();


/** Тип цены пользователя для слайдера */
$rsTypesPrices = \Bitrix\Catalog\GroupTable::getList([
	"select" => ["ID"],
	"filter" => [
		"NAME" => $priceCode
	]
])->fetch();


/** Слайдер */
$rsMarketingBlockSlider = Bitrix\Iblock\Elements\ElementMarketingBlockSliderTable::getList([
    "select" => [
		"ID",
		"IBLOCK_ID",
        "NAME",
		"IBLOCK_SECTION_ID",
        "PREVIEW_TEXT",
        "PREVIEW_PICTURE",
        "MB_PRODUCTS_IN_SLIDER_" => "MB_PRODUCTS_IN_SLIDER.ELEMENT",
		"PRODUCT_PRICE" => "PRICE.PRICE",
		"PRODUCT_FULL_PRICE" => "PRICE",
		"SECTION_PICTURE" => "SECTION.PICTURE",
    ],
	"filter" => [
		"ACTIVE" => "Y",
		"SECTION.ACTIVE" => "Y",
		"PRICE.CATALOG_GROUP_ID" => $rsTypesPrices['ID']
	],
	"runtime" => [
        new \Bitrix\Main\Entity\ReferenceField(
            'PRICE',
            '\Bitrix\Catalog\PriceTable',
            [
				'=this.MB_PRODUCTS_IN_SLIDER.ELEMENT.ID' => 'ref.PRODUCT_ID',
			]
		),
		new \Bitrix\Main\Entity\ReferenceField(
            'SECTION',
            '\Bitrix\Iblock\SectionTable',
            [
				'=this.IBLOCK_SECTION_ID' => 'ref.ID',
			]
        ),
	],
    "cache" => [
        "ttl" => 12800000
    ]
])->fetchAll();


if (!empty($rsMarketingBlockSlider)) {

	$tmpMarketingBlock = reset($rsMarketingBlockSlider);
	$entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock($tmpMarketingBlock['IBLOCK_ID']);

	$iblockSectionCatalog = $entity::getList(array(
		"select" => ["UF_SECTION_CATALOG"], 
		"filter" => ['ID' => $tmpMarketingBlock['IBLOCK_SECTION_ID']],
		"cache"  => ['ttl' => 12800000],
	))->fetch();

	$previousID = 0;

    foreach ($rsMarketingBlockSlider as $arSliderIndex => $arSlider) {

		if ($arSlider['ID'] == $previousID)
			continue;

		$tmpSectionUrl = CIBlockSection::GetNavChain($arSlider['MB_PRODUCTS_IN_SLIDER_IBLOCK_ID'], $iblockSectionCatalog['UF_SECTION_CATALOG'], false);

		if (!empty($tmpSectionUrl)) {
			while ($res = $tmpSectionUrl->GetNext()) {
				$arResult['DATA_SLIDER'][$arSliderIndex]['SECTION_PAGE_URL'] = $res['SECTION_PAGE_URL'];
			}
		}

        $arResult['DATA_SLIDER'][$arSliderIndex]["NAME"] = $arSlider['NAME'];

		$tmpNameArray = explode(' ', $arSlider['NAME']);

		$arResult['DATA_SLIDER'][$arSliderIndex]['NAME_BOLD'] = array_pop($tmpNameArray);
		$arResult['DATA_SLIDER'][$arSliderIndex]['NAME'] = implode(' ', $tmpNameArray);

		$tmpPrice = (int) $arSlider['PRODUCT_PRICE'];

        $arResult['DATA_SLIDER'][$arSliderIndex]["SECTION_PICTURE"] = CFile::GetPath($arSlider['SECTION_PICTURE']);
		$arResult['DATA_SLIDER'][$arSliderIndex]["PREVIEW_PICTURE"] = CFile::GetPath($arSlider['MB_PRODUCTS_IN_SLIDER_PREVIEW_PICTURE']);

		$arResult['DATA_SLIDER'][$arSliderIndex]["PREVIEW_TEXT"] = $arSlider['PREVIEW_TEXT'];
		
        $arResult['DATA_SLIDER'][$arSliderIndex]["URL"] = 
		'/catalog/' . $arSlider['MB_PRODUCTS_IN_SLIDER_ID'] . '/' . $arSlider['MB_PRODUCTS_IN_SLIDER_CODE'] . '/';

		$arResult['DATA_SLIDER'][$arSliderIndex]["PRODUCT_PRICE"] = str_replace('.',' ', CCurrencyLang::CurrencyFormat($tmpPrice, 'RUB'));

		$previousID = $arSlider['ID'];


    }

}

/** Товары */
$rsMarketingBlockProducts = Bitrix\Iblock\Elements\ElementMarketingBlockTable::getList([
    "select" => [
        "MB_PRODUCTS_" => "MB_PRODUCTS.ELEMENT.ID",
    ],
    "cache" => [
        "ttl" => 12800000
    ]
])->fetchAll();

if (!empty($rsMarketingBlockProducts)) {
    foreach ($rsMarketingBlockProducts as $arProduct) {
        $arResult['MB_PRODUCTS_ID'][$arProduct['MB_PRODUCTS_']] = $arProduct['MB_PRODUCTS_'];
    }
}

/** Акции */
$rsMarketingBlockPromo = Bitrix\Iblock\Elements\ElementMarketingBlockTable::getList([
    "select" => [
        "MB_PROMO_" => "MB_PROMO.ELEMENT",
        "DOP_IMAGE" => "MB_PROMO.ELEMENT.DOP_IMAGE.VALUE"
    ],
    "cache" => [
        "ttl" => 12800000
    ]
])->fetchAll();


if (!empty($rsMarketingBlockPromo)) {

    foreach ($rsMarketingBlockPromo as $arPromo) {

        if (!empty($arPromo['DOP_IMAGE'])) {
            $tmpPicture = CFile::GetPath($arPromo['DOP_IMAGE']);
        } elseif (!empty($arPromo['MB_PROMO_PREVIEW_PICTURE'])) {
            $tmpPicture = CFile::GetPath($arPromo['MB_PROMO_PREVIEW_PICTURE']);
        } elseif (!empty($arPromo['MB_PROMO_DETAIL_PICTURE'])) {
            $tmpPicture = CFile::GetPath($arPromo['MB_PROMO_DETAIL_PICTURE']);
        }

        $arResult['DATA_SECTION_PROMO']['MB_PROMO']['PICTURE'] = $tmpPicture;
        $arResult['DATA_SECTION_PROMO']['MB_PROMO']['URL'] = '/promo/' . $arPromo['MB_PROMO_CODE'] . '/';

    }

    unset($tmpPicture);
}

/** Раздел каталога */
$rsMarketingBlockSectionCatalog = Bitrix\Iblock\Elements\ElementMarketingBlockTable::getList([
    "select" => [
        "MB_SECTION_CATALOG_" => "MB_SECTION_CATALOG.SECTION",
    ],
    "cache" => [
        "ttl" => 12800000
    ]
])->fetchAll();

if (!empty($rsMarketingBlockSectionCatalog)) {

    foreach ($rsMarketingBlockSectionCatalog as $arSection) {
        if (!empty($arSection['MB_SECTION_CATALOG_PICTURE'])) {
            $tmpPicture = CFile::GetPath($arSection['MB_SECTION_CATALOG_PICTURE']);
        } elseif (!empty($arSection['MB_SECTION_CATALOG_DETAIL_PICTURE'])) {
            $tmpPicture = CFile::GetPath($arSection['MB_SECTION_CATALOG_DETAIL_PICTURE']);
        }

		$tmpSectionUrlSect = CIBlockSection::GetNavChain($arSection['MB_SECTION_CATALOG_IBLOCK_ID'], $arSection['MB_SECTION_CATALOG_ID'], false);

		if (!empty($tmpSectionUrlSect)) {
			while ($res = $tmpSectionUrlSect->GetNext()) {
				$arResult['DATA_SECTION_PROMO']['MB_SECTION_CATALOG']['URL'] = $res['SECTION_PAGE_URL'];
			}
		}
		
        $arResult['DATA_SECTION_PROMO']['MB_SECTION_CATALOG']['PICTURE'] = $tmpPicture;


    }

    unset($tmpPicture);
}


/** Заголовки и описания */
$rsMarketingBlockTitlesDesc = Bitrix\Iblock\Elements\ElementMarketingBlockTable::getList([
    "select" => [
        "MB_TITLE_FOR_PROMO_" => "MB_TITLE_FOR_PROMO.VALUE",
        "MB_DESC_FOR_PROMO_" => "MB_DESC_FOR_PROMO.VALUE",
        "MB_TITLE_FOR_SECTION_CATALOG_" => "MB_TITLE_FOR_SECTION_CATALOG.VALUE",
        "MB_DESC_FOR_SECTION_CATALOG_" => "MB_DESC_FOR_SECTION_CATALOG.VALUE"
    ],
    "cache" => [
        "ttl" => 12800000
    ]
])->fetchAll();

if (!empty($rsMarketingBlockTitlesDesc)) {
    foreach ($rsMarketingBlockTitlesDesc as $arTitleDesc) {
        if (!empty($arTitleDesc)) {
            foreach ($arTitleDesc as $arKeyTitleDesc => $arInnerTitleDesc) {
                $tmpTitleDesc = rtrim($arKeyTitleDesc, '_');

                if (
                    $tmpTitleDesc == 'MB_TITLE_FOR_PROMO'
                    ||
                    $tmpTitleDesc == 'MB_DESC_FOR_PROMO'
                ) {
                    $arResult['DATA_SECTION_PROMO']['MB_PROMO'][$tmpTitleDesc] = $arInnerTitleDesc;
                }

                if (
                    $tmpTitleDesc == 'MB_TITLE_FOR_SECTION_CATALOG'
                    ||
                    $tmpTitleDesc == 'MB_DESC_FOR_SECTION_CATALOG'
                ) {
                    $arResult['DATA_SECTION_PROMO']['MB_SECTION_CATALOG'][$tmpTitleDesc] = $arInnerTitleDesc;
                }

                continue;

            }
        }

    }

    unset($tmpTitleDesc);

}

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"products.promo.main",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilterMarketingBlock",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "16",
		"IBLOCK_TYPE" => "1c_catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(),
		"LAZY_LOAD" => "N",
        "ELEMENT_ID" => $arResult['MB_PRODUCTS_ID'],
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_LAZY_LOAD" => "Показать ещё",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(""),
		"OFFERS_FIELD_CODE" => array(""),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(""),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "4",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => [$priceCode],
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(""),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(""),
		"PROPERTY_CODE_MOBILE" => array(""),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array("", ""),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
        "OTHER_DATA" => [
            "OTHER_DATA_PROMO" => $arResult['DATA_SECTION_PROMO']['MB_PROMO'],
            "OTHER_DATA_SECTION_CATALOG" => $arResult['DATA_SECTION_PROMO']['MB_SECTION_CATALOG'],
			"OTHER_DATA_SLIDER" => $arResult['DATA_SLIDER']
		],
	)
);

