<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\Filters\ProductsFilterHelper;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;

$sectionId = $arResult['VARIABLES']['SECTION_ID'];

//Для модуля Сотбит: SEO умного фильтра
global $arCurSection;
$arCurSection = $sectionId;
//Конец

/**
 * Проверка на существование раздела
 */

 $rsSection = SectionTable::getList([
    "select" => [
        "NAME", "CODE"
    ],
    "filter" => [
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ID" => $sectionId,
        "ACTIVE" => 'Y'
    ]
])->fetch();

if (empty($rsSection)) {

    if (!defined("ERROR_404")) {
        define("ERROR_404", "Y");
    }

    \CHTTP::setStatus("404 Not Found");

    if ($APPLICATION->RestartWorkarea())
    {
        require(Application::getDocumentRoot() . "/404.php");
        die();
    }
}

$headers = getallheaders();

$filterHelperInstance = new ProductsFilterHelper($sectionId);
$filterParams = $filterHelperInstance->getFilters() ?? [];

/* AJAX old filter
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
            "component" => $component,
            "isAjax" => "Y"
        ]
    );

    exit();
}
*/

?>

<div class="category">
    <section class="category__header">
        <div class="container">
            <? if ($filterParams['SECTION_NAME']) { ?>
                <h1 class="category__header-title">
                    <?$APPLICATION->ShowViewContent('my_code11');?>
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

            /**
             * SORT for standart filter
             */
            $APPLICATION->IncludeFile($templateFolder . "/include/catalog_filter_top.php", [
                "currentSection" => $arCurSection,
            ]);
            
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

<?php

//Переопределение метаинформации для модуля "Сотбит: SEO умного фильтра – мета-теги, заголовки, карта сайта"
//начало
    global $sotbitSeoMetaTitle;
    $this->SetViewTarget('my_code11');
    if(!empty($sotbitSeoMetaTitle)){
        echo $sotbitSeoMetaTitle;
	} else {
		echo $filterParams['SECTION_NAME'];
	}
    $this->EndViewTarget();

    //Переопределение ключевых слов Keywords
    global $sotbitSeoMetaKeywords;
    if(!empty($sotbitSeoMetaKeywords)){
        $APPLICATION->SetPageProperty("keywords", $sotbitSeoMetaKeywords);
    }
    
    //Переопределение описания страницы Description
    global $sotbitSeoMetaDescription;
    if(!empty($sotbitSeoMetaDescription)){
        $APPLICATION->SetPageProperty("description", $sotbitSeoMetaDescription);
    } 
    
    //Переопределение заголовка H1
    global $sotbitSeoMetaH1;  
    if(!empty($sotbitSeoMetaH1)){
             $APPLICATION->SetTitle($sotbitSeoMetaH1); 
    }
        
    //Добавление пункта хлебных крошек Breadcrumb
    global $sotbitSeoMetaBreadcrumbTitle;
    if(!empty($sotbitSeoMetaBreadcrumbTitle)){
        $APPLICATION->AddChainItem($sotbitSeoMetaBreadcrumbTitle  );
    }
//конец
