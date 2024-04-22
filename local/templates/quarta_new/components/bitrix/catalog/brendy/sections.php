<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Context;
use Helpers\Filters\BrandsFilterHelper;

$filterHelperInstance = new BrandsFilterHelper();
$filterParams = $filterHelperInstance->getFilters();

if (!empty($_REQUEST['BRAND_ID'])) {
    if (is_numeric($_REQUEST['BRAND_ID'])) {
        $currentBrandId = $_REQUEST['BRAND_ID'];
    }
}

if (empty($currentBrandId)) {
    LocalRedirect('/brendy/');
}

?>

<div class="catalog">

    <div class="category">

        <section class="category__header">
            <div class="container">
                <h1 class="category__header-title">
                    <?=$APPLICATION->ShowTitle(false)?>
                </h1>
            </div>
        </section>

        <div class="container category__main">
            <div class="row">
                <?php 
                    $APPLICATION->IncludeFile($templateFolder . "/include/catalog_smart_filter.php",
                    [
                        "params" => array_merge($arParams, $filterParams),
                        "result" => $arResult,
                        "currentSection" => $arCurSection,
                        "currentBrandId" => $currentBrandId ?? '',
                        "component" => $component
                    ]);

                    $APPLICATION->IncludeFile($templateFolder . "/include/catalog_section.php",
                    [
                        "params" => array_merge($arParams, $filterParams),
                        "result" => $arResult,
                        "component" => $component,
                        "currentBrandId" => $currentBrandId ?? '',
                    ]);
                ?>
            </div>
        </div>

    <?php $APPLICATION->IncludeComponent("bitrix:form.result.new","subscribe_form", [
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
    );
    ?>

    </div>
</div>
