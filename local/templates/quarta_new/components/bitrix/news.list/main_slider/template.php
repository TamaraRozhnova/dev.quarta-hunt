<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

$isCompactSlider = $arParams['COMPACT'] === 'Y';?>

<div class="main-slider <?= $isCompactSlider ? 'main-slider__compact' : '' ?>">
    <div class="swiper-container swiper-container_main">
        <div class="swiper-wrapper">
            <? foreach ($arResult['ITEMS'] as $k => $item) { ?>
                <div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="main-slider__top-text">
                                    <? if (!empty($item['PROPERTIES']['LABEL']['VALUE'])): ?>
                                        <div class="main-slider__label">
                                            <?= $item['PROPERTIES']['LABEL']['VALUE'] ?>
                                        </div>
                                    <? endif; ?>
                                    <? if (!empty($item['FIELDS']['PREVIEW_TEXT'])): ?>
                                        <div class="main-slider__subtitle">
                                            <?= $item['FIELDS']['PREVIEW_TEXT'] ?>
                                        </div>
                                    <? endif; ?>
                                </div>
                                <h2 class="main-slider__title">
                                    <? if (!empty($item['FIELDS']['NAME'])): ?>
                                        <?= $item['FIELDS']['NAME'] ?>
                                    <? endif; ?>
                                </h2>
                                <? if (!empty($item['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'])): ?>
                                    <div class="main-slider__text">
                                        <?= $item['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'] ?>
                                    </div>
                                <? endif; ?>
                                <? if (!empty($item['PROPERTIES']['LINK']['VALUE'])) { ?>
                                    <div class="main-slider__aсtion">
                                        <a href="<?= $item['PROPERTIES']['LINK']['VALUE'] ?>"
                                           class="btn btn-outline-light">Смотреть</a>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>

    <?/* if (!$isCompactSlider) { ?>
        <div class="main-slider-progress">
            <div class="container">
                <? foreach (array_values($arResult['ITEMS']) as $index => $item) { ?>
                    <div class="main-slider-progress__item">
                        <div class="main-slider-progress__number">
                            0<?= $index + 1 ?>
                        </div>
                        <span><?= $item['FIELDS']['NAME'] ?></span>
                    </div>
                <? } ?>
            </div>

            <div class="container">
                <div class="main-slider-progress__scroller">
                    <div class="main-slider-progress__scroller-inner"></div>
                </div>
            </div>
        </div>
    <? } */?>

    <div class="main-slider__arrows">
        <div class="container">
            <div class="main-slider__arrow-prev"></div>
            <div class="main-slider__arrow-next"></div>
        </div>
    </div>

    <? if (!$isCompactSlider) { ?>
        <div class="main-slider__dots">
            <div class="container">
                <? foreach (array_values($arResult['ITEMS']) as $index => $item) { ?>
                    <div class="main-slider__dot">
                        <div class="main-slider-dot">
                            <svg width="20px"
                                 height="20px"
                                 viewBox="-1 -1 22 22"
                                 xmlns="http://www.w3.org/2000/svg"
                            >
                                <circle
                                        cx="10"
                                        cy="10"
                                        r="10"
                                        fill="transparent"
                                        stroke-width="1"
                                        stroke="rgba(128, 141, 154, 0.3)"
                                />
                                <circle
                                        cx="10"
                                        cy="10"
                                        r="10"
                                        fill="transparent"
                                        stroke-width="1"
                                        stroke="white"
                                        stroke-dasharray="0 62.831853072"
                                        stroke-dashoffset="15.707963268"
                                />
                            </svg>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    <? } ?>
</div>

<script>
    window.mainSliderImages = <?= CUtil::PhpToJSObject($arResult['SLIDER_IMAGES'], false, true) ?>;
    window.mainSliderCompact = <?= CUtil::PhpToJSObject($isCompactSlider, false, true) ?>;
</script>




