<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;

$arPrice = array();
if (Loader::includeModule("catalog")) {
	$rsPrice = CCatalogGroup::GetList($v1 = "sort", $v2 = "asc");
	while ($arr = $rsPrice->Fetch())
		$arPrice[$arr["NAME"]] = "[" . $arr["NAME"] . "] " . $arr["NAME_LANG"];
}

$arTemplateParameters = array(
	"SHOW_INPUT" => array(
		"NAME" => Loc::getMessage("TP_BST_SHOW_INPUT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		// "REFRESH" => "Y",
		// "PARENT" => "BASE",
	),
	"INPUT_ID" => array(
		"NAME" => Loc::getMessage("AG_TP_BST_INPUT_ID"),
		"TYPE" => "STRING",
		"DEFAULT" => "smart-title-search-input",
		"PARENT" => "BASE",
	),
	"CONTAINER_ID" => array(
		"NAME" => Loc::getMessage("AG_TP_BST_CONTAINER_ID"),
		"TYPE" => "STRING",
		"DEFAULT" => "smart-title-search",
		"PARENT" => "BASE",
	),


	"INPUT_PLACEHOLDER" => array(
		"NAME" => Loc::getMessage("TP_BST_INPUT_PLACEHOLDER"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"REFRESH" => "",
		"PARENT" => "VISUAL",
	),

	"SHOW_PROPS" => array(
		"NAME" => Loc::getMessage("TP_BST_SHOW_PROPS"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
		"MULTIPLE" => "Y",
		"PARENT" => "VISUAL",
	),
	"SHOW_PREVIEW" => array(
		"NAME" => Loc::getMessage("TP_BST_SHOW_PREVIEW"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"REFRESH" => "Y",
		"PARENT" => "VISUAL",
	),
);

if (isset($arCurrentValues['SHOW_PREVIEW']) && 'Y' == $arCurrentValues['SHOW_PREVIEW']) {
	$arTemplateParameters["PREVIEW_WIDTH_NEW"] = array(
		"NAME" => Loc::getMessage("TP_BST_PREVIEW_WIDTH"),
		"TYPE" => "STRING",
		"DEFAULT" => 34,
		"PARENT" => "VISUAL",
	);
	$arTemplateParameters["PREVIEW_HEIGHT_NEW"] = array(
		"NAME" => Loc::getMessage("TP_BST_PREVIEW_HEIGHT"),
		"TYPE" => "STRING",
		"DEFAULT" => 34,
		"PARENT" => "VISUAL",
	);
}

$arTemplateParameters["SHOW_LOADING_ANIMATE"] = array(
	"NAME" => Loc::getMessage("TP_BST_SHOW_LOADING_ANIMATE"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "Y",
	"REFRESH" => "",
	"PARENT" => "VISUAL",
);

$arTemplateParameters["SHOW_HISTORY"] = array(
	"NAME" => Loc::getMessage("TP_BST_SHOW_HISTORY"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"PARENT" => "VISUAL",
);



$arTemplateParameters["SHOW_PREVIEW_TEXT"] = array(
	"NAME" => Loc::getMessage("ARTURGOLUBEV_SMARTSEARCH_TEMPLATE_SHOW_PREVIEW_TEXT"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
	"REFRESH" => "Y",
	"PARENT" => "VISUAL",
);

$arTemplateParameters["POPULAR_REQUESTS"] = array(
	"NAME" => "Популярные запросы",
	"TYPE" => "STRING",
	"MULTIPLE" => "Y",
	"PARENT" => "VISUAL",
);

if (isset($arCurrentValues['SHOW_PREVIEW_TEXT']) && 'Y' == $arCurrentValues['SHOW_PREVIEW_TEXT']) {
	$arTemplateParameters["PREVIEW_TRUNCATE_LEN"] = array(
		"PARENT" => "VISUAL",
		"NAME" => Loc::getMessage("TP_BST_PREVIEW_TRUNCATE_LEN"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

if (Loader::includeModule('catalog') && Loader::includeModule('currency')) {
	$arTemplateParameters['SHOW_QUANTITY'] = array(
		"PARENT" => "VISUAL",
		'NAME' => Loc::getMessage('TP_BST_SHOW_QUANTITY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'N',
	);

	$arTemplateParameters['PRICE_CODE'] = array(
		"PARENT" => "VISUAL",
		"NAME" => Loc::getMessage("TP_BST_PRICE_CODE"),
		"TYPE" => "LIST",
		"MULTIPLE" => "Y",
		"VALUES" => $arPrice,
	);

	$arTemplateParameters['PRICE_VAT_INCLUDE'] = array(
		"PARENT" => "VISUAL",
		"NAME" => Loc::getMessage("TP_BST_PRICE_VAT_INCLUDE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	);

	$arTemplateParameters['CONVERT_CURRENCY'] = array(
		"PARENT" => "VISUAL",
		'NAME' => Loc::getMessage('TP_BST_CONVERT_CURRENCY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);

	if (isset($arCurrentValues['CONVERT_CURRENCY']) && 'Y' == $arCurrentValues['CONVERT_CURRENCY']) {
		$arCurrencyList = array();
		$rsCurrencies = CCurrency::GetList(($by = 'SORT'), ($order = 'ASC'));
		while ($arCurrency = $rsCurrencies->Fetch()) {
			$arCurrencyList[$arCurrency['CURRENCY']] = $arCurrency['CURRENCY'];
		}
		$arTemplateParameters['CURRENCY_ID'] = array(
			"PARENT" => "VISUAL",
			'NAME' => Loc::getMessage('TP_BST_CURRENCY_ID'),
			'TYPE' => 'LIST',
			'VALUES' => $arCurrencyList,
			'DEFAULT' => CCurrency::GetBaseCurrency(),
			// "ADDITIONAL_VALUES" => "Y",
		);
	}
}
