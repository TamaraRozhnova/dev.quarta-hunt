<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\ProductsFilterHelper;

$sectionId = $arResult['VARIABLES']['SECTION_ID'];

$filterHelperInstance = new ProductsFilterHelper($sectionId);
$filterParams = $filterHelperInstance->getFilters();

$headers = getallheaders();

if ((isset($headers["x-requested-with"]) || isset($headers["X-Requested-With"]))) {
    $APPLICATION->RestartBuffer();
    $APPLICATION->IncludeFile($templateFolder . "/include/catalog_smart_filter.php",
        [
            "params" => array_merge($arParams, $filterParams),
            "result" => $arResult,
            "currentSection" => $arCurSection,
            "component" => $component
        ]
    );
    $APPLICATION->IncludeFile($templateFolder . "/include/catalog_section.php",
        [
            "params" => array_merge($arParams, $filterParams),
            "result" => $arResult,
            "component" => $component
        ]
    );
    exit();
}

?>

<div class="category">
    <section class="category__header">
        <div class="container">
            <? if ($filterParams['SECTION_NAME']) { ?>
                <h1 class="category__header-title">
                    <?= $filterParams['SECTION_NAME'] ?>
                </h1>
            <? } ?>
        </div>
    </section>

    <? $APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "subsections",
        [
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => $sectionId,
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
            "TOP_DEPTH" => "1",
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
        ],
        $component
    ); ?>

    <div class="container category__main">
        <div class="row">
            <?
            $APPLICATION->IncludeFile($templateFolder . "/include/catalog_smart_filter.php",
                [
                    "params" => array_merge($arParams, $filterParams),
                    "result" => $arResult,
                    "currentSection" => $arCurSection,
                    "component" => $component
                ]
            );
            $APPLICATION->IncludeFile($templateFolder . "/include/catalog_section.php",
                [
                    "params" => array_merge($arParams, $filterParams),
                    "result" => $arResult,
                    "component" => $component
                ]);
            ?>
        </div>
    </div>

    <? $APPLICATION->IncludeComponent("bitrix:form.result.new", "subscribe_form", [
            "SEF_MODE" => "N",
            "WEB_FORM_ID" => "1",
            "LIST_URL" => $APPLICATION->GetCurPage(),
            "CHAIN_ITEM_TEXT" => "",
            "CHAIN_ITEM_LINK" => "",
            "USE_EXTENDED_ERRORS" => "Y",
            "CACHE_TYPE" => "Y",
            "CACHE_TIME" => "3600000",
            "VARIABLE_ALIASES" => []
        ]
    ); ?>

</div>
