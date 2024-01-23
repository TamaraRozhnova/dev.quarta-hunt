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
/** @var CBitrixComponent $component */?>

<?if (!empty($arResult['ITEMS'])):?>
    <div class="sharing-elements__wrapper">
        <div class="sharing-elements__inner">
            <div class="sharing-elements">
                <?foreach ($arResult['ITEMS'] as $arItem):?>
                    <?if (!empty($arItem['PROPERTIES']['SS_ICON']['VALUE'])):?>
                        <a rel="nofollow" target="_blank"
                        <?=$arItem['COPY_ATTR'] ? 'data-copy-attr='. $arItem['COPY_ATTR'] : null ?>
                        href='<?=$arItem['LINK_SERVICE']?>'
                        class="sharing-element">
                            <img class="svg" src="<?=CFile::GetPath($arItem['PROPERTIES']['SS_ICON']['VALUE'])?>">
                        </a>
                    <?endif?>
                <?endforeach;?>
            </div>
        </div>
    </div>
<?endif;?>