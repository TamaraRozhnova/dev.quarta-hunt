<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

$isCompactSlider = $arParams['COMPACT'] === 'Y';
?>

<div class="main-slider <?= $isCompactSlider ? 'main-slider__compact' : '' ?>">
    <div class="swiper-container swiper-container_main">
        <div class="swiper-wrapper">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="swiper-slide">
                    <div class="main-slider__q">
                        <div class="container">
                            <? if ($isCompactSlider) { ?>
                                <svg width="327" height="316" viewBox="0 0 327 316" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_b_167:4)">
                                        <path d="M318.547 158C318.547 70.8807 247.09 0 159.262 0C71.4333 0 0 70.9048 0 158C0 245.095 71.4576 316 159.286 316C174.418 316 189.38 313.904 203.783 309.736L221.319 304.676L186.198 259.069L178.644 260.466C172.305 261.647 165.795 262.225 159.286 262.225C101.333 262.225 54.1883 215.461 54.1883 157.976C54.1883 100.491 101.333 53.7268 159.286 53.7268C217.239 53.7268 264.383 100.491 264.383 157.976C264.383 182.334 255.664 205.896 240.143 224.496H181.316L253.211 314.458L253.526 314.506L254.717 315.976H327L281.58 259.165C305.286 230.977 318.547 195.223 318.547 158Z" fill="#004989" fill-opacity="0.28"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_b_167:4" x="-4" y="-4" width="335" height="324" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feGaussianBlur in="BackgroundImage" stdDeviation="2"/>
                                            <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_167:4"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_167:4" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            <? } else { ?>
                                <svg width="562" height="542" viewBox="0 0 562 542" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_b_164:3)">
                                        <path d="M547.473 271C547.473 121.574 424.662 0 273.716 0C122.769 0 0 121.615 0 271C0 420.385 122.811 542 273.757 542C299.764 542 325.478 538.405 350.233 531.256L380.372 522.578L320.01 444.352L307.027 446.749C296.132 448.774 284.945 449.766 273.757 449.766C174.156 449.766 93.131 369.557 93.131 270.959C93.131 172.361 174.156 92.1516 273.757 92.1516C373.359 92.1516 454.384 172.361 454.384 270.959C454.384 312.737 439.398 353.151 412.723 385.053H311.619L435.182 539.355L435.724 539.438L437.77 541.959H562L483.939 444.518C524.681 396.169 547.473 334.845 547.473 271Z" fill="#004989" fill-opacity="0.28"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_b_164:3" x="-4" y="-4" width="570" height="550" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feGaussianBlur in="BackgroundImage" stdDeviation="2"/>
                                            <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_164:3"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_164:3" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                           <? } ?>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="main-slider__subtitle">
                                    <?= $item['FIELDS']['PREVIEW_TEXT'] ?>
                                </div>
                                <div class="main-slider__title">
                                    <?= $item['FIELDS']['NAME'] ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="main-slider__text">
                                    <?= $item['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'] ?>
                                </div>
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

    <? if (!$isCompactSlider) { ?>
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
    <? } ?>

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




