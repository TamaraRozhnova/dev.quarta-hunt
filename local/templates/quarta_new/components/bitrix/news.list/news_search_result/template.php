<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$this->setFrameMode(false);?>

<? if (!empty($arResult['ITEMS'])): ?>
    <div class="search-page-other-result">
        <div class = "container">
            <? foreach($arResult['ITEMS'] as $arBlog): ?>
                <div class="search-item">
                    <h4>
                        <a href="<?=$arBlog['DETAIL_PAGE_URL']?>">
                            <b><?=$arBlog['NAME']?></b>
                        </a>
                    </h4>
                    <div class="search-preview">
                        <?=$arBlog['PREVIEW_TEXT']?>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
<? endif ;?>