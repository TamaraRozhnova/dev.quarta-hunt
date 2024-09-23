<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}
?>

<section class="modern-promo-slider">
    <div class="modern-promo-slider__title">
        <span>Действующие акции</span>
    </div>
    <div class="swiper-container swiper-container_modern">
        <div class="swiper-wrapper">
            <? foreach ($arResult['ITEMS'] as $arItem) { ?>
                <div class="swiper-slide">
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="modern-promo">
                        <div class="modern-promo__img">
                            <img src="<?= $arItem['PIC'] ?>">
                        </div>
                        <div class="modern-promo__text">
                            <div class="modern-promo__title">
                                <?= $arItem['NAME'] ?>
                            </div>
                            <div class="modern-promo__preview">
                                <?= $arItem['PREVIEW_TEXT'] ?>
                            </div>
                            <div class="modern-promo__btn">
                                <span>Подробности акции</span>
                            </div>
                        </div>

                    </a>
                </div>
            <? } ?>
            <div class="swiper-slide">
                <div class="modern-promo__more">
                    <h2>Еще новости</h2>
                    <a href="/blog/" class="btn btn-outline-light px-4">
                        Смотреть
                    </a>
                </div>
            </div>
        </div>

        <div class="modern-promo-slider__addit">
            <div class="swiper-pagination"></div>
            <div class="modern-promo-slider__arrows">
                <div class="modern-promo-slider__prev"></div>
                <div class="modern-promo-slider__next"></div>
            </div>
        </div>

    </div>
</section>
