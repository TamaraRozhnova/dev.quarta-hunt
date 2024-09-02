<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

//Для модуля Сотбит: SEO умного фильтра
global $arCurSection;
//Конец

$APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    "main",
    array(
        "AJAX_MODE" => $params["AJAX_MODE"],
        "IBLOCK_TYPE" => $params["IBLOCK_TYPE"],
        "IBLOCK_ID" => $params["IBLOCK_ID"],
        "FILTER_NAME" => $params["FILTER_NAME"],
        "PRICE_CODE" => $params["~PRICE_CODE"],
        "CACHE_TYPE" => $params["CACHE_TYPE"],
        "CACHE_TIME" => $params["CACHE_TIME"],
        "CACHE_GROUPS" => $params["CACHE_GROUPS"],
        "DISPLAY_ELEMENT_COUNT" => 'Y',
        "SAVE_IN_SESSION" => "N",
        "FILTER_VIEW_MODE" => $params["FILTER_VIEW_MODE"],
		"SECTION_ID" => $currentSection,
        "SECTION_CODE" => $result['VARIABLES']['SECTION_CODE'],
        "SECTION_TITLE" => "NAME",
        "SECTION_DESCRIPTION" => "DESCRIPTION",
        'HIDE_NOT_AVAILABLE' => $params["ONLY_AVAILABLE"],
        "TEMPLATE_THEME" => $params["TEMPLATE_THEME"],
        'CONVERT_CURRENCY' => $params['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $params['CURRENCY_ID'],
        "SEF_RULE" => $params['SEF_URL_TEMPLATES']['smart_filter'],
		//"SMART_FILTER_PATH" => $params["SMART_FILTER_PATH"],
        "SEF_MODE" => 'Y',
        "PAGER_PARAMS_NAME" => "arrPager",
        "INSTANT_RELOAD" => "Y",
        "USE_FILTER" => "Y",
        
    ),
    $component,
    array('HIDE_ICONS' => 'Y')
);

//Подключение компонента sotbit.seometa модуля "Сотбит: SEO умного фильтра – мета-теги, заголовки, карта сайта" ?>
<?if(\Bitrix\Main\Loader::includeModule("sotbit.seometa")):?>
<? 
  $APPLICATION->IncludeComponent(
   "sotbit:seo.meta",
   ".default",
   Array(
        "FILTER_NAME" => $params["FILTER_NAME"],
        "SECTION_ID" => $arCurSection,
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
   )
);
?>
<?endif;?>
<?//Конец