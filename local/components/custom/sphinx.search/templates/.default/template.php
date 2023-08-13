<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */?>

<div class = "search-result-page">
    <div class="search-page">

        <div class = "search-page-result-text container">
            <h2>Результаты поиска</h2>
            <p class="mb-4">
                <? if ($arResult['COUNT_SEARCH'] > 0): ?>
                    Найдено <?=$arResult['COUNT_SEARCH']?>  совпадений по вашему запросу
                    <span class="text-primary"><?= $_GET['q'] ?></span>
                <? else: ?>
                    <span>Простите, по вашему запросу товаров сейчас нет.</span>
                        <br>
                    <a href="/">На главную</a>
                <? endif; ?>
            </p>
        </div>

        <? if ($arResult['COUNT_SEARCH'] > 0): ?>

            <? if (!empty($arResult['PRODUCTS'])): ?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "new_search",
                    $arResult['PARAMS_CATALOG']
                );?>
            <? endif; ?>

            <? if (!empty($arResult['BLOG'])): ?>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "news_search_result",
                    $arResult['PARAMS_BLOG']
                );?>
            <? endif; ?>

            <?$APPLICATION->IncludeComponent(
                "bitrix:main.pagenavigation",
                "main",
                array(
                    "NAV_OBJECT" => $arResult['OBJECT_NAVIGATION'],
                    "SEF_MODE" => "N",
                ),
                false
            );?>

        <? endif; ?>
    </div>
</div>