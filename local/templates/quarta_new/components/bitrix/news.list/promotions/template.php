<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<section class="promo">
    <div class="container">
        <? if ($arResult['MAIN_BANNER_NEWS']) { ?>
            <div class="promo-wide-light">
                <div class="row">
                    <div class="col-6 promo-wide-light__text">
                        <h3><?= $arResult['MAIN_BANNER_NEWS']['BANNER_TITLE']['VALUE'] ?></h3>
                        <p><?= $arResult['MAIN_BANNER_NEWS']['BANNER_TEXT']['VALUE'] ?></p>

                        <? if ($arResult['MAIN_BANNER_NEWS']['BANNER_LINK']['VALUE']) { ?>
                            <a href="<?= $arResult['MAIN_BANNER_NEWS']['BANNER_LINK']['VALUE'] ?>" class="btn btn-primary">
                                <?= $arResult['MAIN_BANNER_NEWS']['BANNER_BTN_TEXT']['VALUE'] ?? 'Подробнее' ?>
                            </a>
                        <? } ?>
                    </div>

                    <div class="col-6">
                        <figure class="promo-wide-light__image">
                            <img loading="lazy"
                                 src="<?= $arResult['MAIN_BANNER_NEWS']['BANNER_IMAGE']['SRC'] ?>"
                                 alt="<?= $arResult['MAIN_BANNER_NEWS']['BANNER_TITLE']['VALUE'] ?>"
                            />
                        </figure>
                    </div>
                </div>
            </div>
        <? } ?>
    </div>

    <? if (count($arResult['ITEMS']) > 0) { ?>
        <div class="base-slider promo__slider">
            <div class="container">
                <div class="swiper-container swiper-container_promo">
                    <div class="swiper-wrapper">
                        <? foreach ($arResult['ITEMS'] as $item) { ?>
                            <div class="swiper-slide">
                                <a
                                   href="/promo/<?= $item['CODE'] ?>"
                                   class="promo-card promo-card--background-image
                                   <?= $item['PROPERTIES']['TEXT_COLOR']['VALUE'] !== 'Темный' ? 'promo-card--light' : '' ?>"
                                >
                                    <figure style="background-image: url(<?= $item['PREVIEW_PICTURE']['SRC'] ?>)"></figure>
                                    <?if ($item['PROPERTIES']['HIDE_NAME_CARD_IN_SLIDER']['VALUE'] != 'Y'):?>
                                        <h3><?= $item['NAME'] ?></h3>
                                    <?endif;?>
                                </a>
                            </div>
                        <? } ?>
                    </div>
                    <div class="base-slider__arrows">
                        <div class="base-slider__prev"></div>
                        <div class="base-slider__next"></div>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>

    <? if (count($arResult['ARRIVAL_NEWS']) > 0) { ?>
        <div class="index__new-arrivals">
            <div class="container">
                <div class="row">
                    <? foreach ($arResult['ARRIVAL_NEWS'] as $arrival) { ?>
                        <div class="col-12 col-md-6 index__new-arrivals-item">
                            <a
                               href="<?= $arrival['BANNER_LINK']['VALUE'] ?>"
                               class="promo-card promo-card--background-image
                               <?= $arrival['BANNER_TEXT_COLOR']['VALUE'] !== 'Темный' ? 'promo-card--light' : '' ?>"
                            >
                                <figure style="background-image: url(<?= $arrival['BANNER_IMAGE']['SRC'] ?>)"></figure>
                                <h3><?= $item['BANNER_TITLE']['VALUE'] ?></h3>
                                <p><?= $item['BANNER_TEXT']['VALUE'] ?></p>
                            </a>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
    <? } ?>
</section>