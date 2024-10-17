<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arResult["SEARCH_HISTORY"] = array();
if($arParams["SHOW_HISTORY"] == 'Y'){
	$arResult["SEARCH_HISTORY"] = \Arturgolubev\Smartsearch\Tools::getSearchHistory(10);
}