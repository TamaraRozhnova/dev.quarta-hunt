<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<section class="bg-light catalog-slider">
    <div class="base-slider">
        <div class="container">
            <div class="swiper-container swiper-container_sections">
                <div class="swiper-wrapper">
                    <? foreach ($arResult['SECTIONS'] as $section) { ?>
                        <div class="swiper-slide">
                            <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="category-card category-card--compact">
                                <div class="category-card__background"></div>

                                <div class="category-card__body">
                                    <figure class="category-card__image">
                                        <img loading="lazy" src="<?= $section['PICTURE']['SRC'] ?>" alt="<?= $section['NAME'] ?>">
                                    </figure>

                                    <h2 class="category-card__title">
                                        <?= $section['NAME'] ?>
                                    </h2>
                                </div>
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
</section>