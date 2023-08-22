<?php

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
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
/** @var CBitrixComponent $component */ ?>

<?php if (!empty($arResult['ITEMS'])): ?>

    <div class="wide-promotion__wrapper bg-primary youtube-promotion">
        <div class="wide-promotion">

            <?php foreach ($arResult['ITEMS'] as $arItem): ?>
                <div class="wide-promotion__image" style="background-image: url('<?= CFile::GetPath($arItem['PROPERTIES']['BANNER_IMAGE']['VALUE']) ?? '' ?>')">
                </div>

                <div class="wide-promotion__content-backdrop">
                    <div class="backdrop">
                        <a href="<?= $arItem['PROPERTIES']['BANNER_LINK']['VALUE'] ?>" target="_blank"
                           class="play-button">
                            <svg width="107" height="107" viewBox="0 0 107 107" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="53.5" cy="53.5" r="53.5" fill="#004989"/>
                                <circle cx="53.5" cy="53.5" r="53" stroke="white" stroke-opacity="0.22"/>
                                <path d="M44.1364 68C43.835 68 43.546 67.8771 43.3328 67.6583C43.1197 67.4395 43 67.1427 43 66.8333V41.1665C43 40.9637 43.0515 40.7645 43.1494 40.5884C43.2473 40.4124 43.3881 40.2655 43.5581 40.1623C43.7281 40.0592 43.9214 40.0033 44.1188 40.0001C44.3163 39.997 44.5111 40.0468 44.6841 40.1445L67.4117 52.9779C67.5899 53.0786 67.7385 53.2266 67.8419 53.4063C67.9454 53.5861 68 53.7911 68 53.9999C68 54.2087 67.9454 54.4137 67.8419 54.5935C67.7385 54.7732 67.5899 54.9212 67.4117 55.0219L44.6841 67.8553C44.5163 67.9502 44.3279 67.9999 44.1364 68Z"
                                      fill="white"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="wide-promotion__body">
                    <div class="container">

                        <div class="row">
                            <div class="col-6 youtube-promotion__preview"></div>
                            <div class="col-6 youtube-promotion__content">
                                <h3><?= $arItem['PROPERTIES']['BANNER_TEXT']['~VALUE'] ?></h3>
                                <a href="<?= $arItem['PROPERTIES']['BANNER_LINK']['VALUE'] ?>"
                                   class="btn btn-outline-light" target="_blank">
                                    <?= Loc::getMessage('YOUTUBE_BTN_TITLE') ?>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
