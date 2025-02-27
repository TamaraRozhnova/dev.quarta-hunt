<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die;
}

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

Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
?>
<h2><?= Loc::getMessage('CONTACT_BLOCK_TITLE') ?></h2>
<div class="contacts__wrap">
    <?php foreach($arResult["ITEMS"] as $arItem) : ?>
        <div class="contacts__card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="contacts__info">
                <div class="contacts__icon">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/img/map.svg" alt="">
                </div>
                <div class="contacts__inf">
                    <div class="contacts__addr">
                        <?= $arItem['NAME'] ?>
                        <?php if(
                            isset($arItem['PROPERTIES']['OPENING_SOON']['VALUE']) &&
                            $arItem['PROPERTIES']['OPENING_SOON']['VALUE'] == 'Да'
                        ) : ?>
                            <span>Скоро открытие</span>
                        <?php endif?>
                    </div>
                    <?php if ($arItem['PROPERTIES']['PHONE']['VALUE']) : ?>
                        <a href="tel:<?=$arItem['PROPERTIES']['PHONE']['VALUE']?>" class="contacts__link">
                            <?= $arItem['PROPERTIES']['PHONE']['VALUE'] ?>
                        </a>
                    <?php endif?>
                    <?php if ($arItem['PROPERTIES']['MAIL']['VALUE']) : ?>
                        <a href="mailto:<?=$arItem['PROPERTIES']['MAIL']['VALUE']?>" class="contacts__link">
                            <?= $arItem['PROPERTIES']['MAIL']['VALUE'] ?>
                        </a>
                    <?php endif?>
                    <?php if ($arItem['PROPERTIES']['WORK_TIME']['VALUE']) : ?>
                        <span class="work-time-text"><?= Loc::getMessage('WORK_TIME_TITLE') . ' ' . $arItem['PROPERTIES']['WORK_TIME']['VALUE'] ?></span>
                    <?php endif; ?>
                    <?php if ($arItem['PROPERTIES']['WORK_TIME_WEEKDAY']['VALUE']) : ?>
                        <span class="work-time-text"><?= Loc::getMessage('WORK_TIME_WEEKDAY_TITLE') . ' ' . $arItem['PROPERTIES']['WORK_TIME_WEEKDAY']['VALUE'] ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach?>
</div>
