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
/** @var CBitrixComponent $component */

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);?>

<div class = "search-result-page">
    <div class="search-page">

        <div class = "search-page-result-text container">
            <h2><?=Loc::getMessage('TITLE_RESULT')?></h2>
            <p class="mb-4">
                <? if ($arResult['COUNT_SEARCH'] > 0): ?>
                    <?=Loc::getMessage('CNT_SEARCH_PREFIX')?> <?=$arResult['COUNT_SEARCH']?> <?=Loc::getMessage('CNT_SEARCH_POSTFIX')?>
                    <span class="text-primary"><?= $arResult['SEARCH_TEXT'] ?></span>
                <? else: ?>
                    <span>
                        <?=Loc::getMessage('SEARCH_FAILED')?>
                    </span>
                        <br>
                    <?if (!empty($arResult['CORRECT_TEXT'])):?>
                        <span>
                            <?=Loc::getMessage('MAYBE_YOU_SEARCH')?> 
                            <a href="<?=$arResult['CORRECT_URL']?>"><?=$arResult['CORRECT_TEXT']?></a>
                        </span>
                    <?endif;?>
                        <br> <br>
                    <a href="/">
                        <?=Loc::getMessage('MAIN_LINK_NAME')?> 
                    </a>
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