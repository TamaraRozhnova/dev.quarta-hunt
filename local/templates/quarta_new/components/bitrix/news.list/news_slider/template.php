<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}
?>

<section class="news-slider">
    <div class="base-slider">
        <div class="container">
            <div class="swiper-container swiper-container_news">
                <div class="swiper-wrapper">
                    <? foreach ($arResult['ITEMS'] as $item) { ?>
                        <div class="swiper-slide">
                            <a href="/news/<?= $item['CODE'] ?>" class="news-slide">
                                <div class="news-slide__background
                                <?= !empty($item['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC']) ? 'news-slide__background--multiple' : '' ?>"
                                     style="background-image: url(<?= $item['PREVIEW_PICTURE']['SRC'] ?>)
                                     <?= !empty($item['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC']) ? ', url(' . $item['PROPERTIES']['MOB_IMAGE_PREVIEW']['SRC'] . ')' : '' ?>"
                                >
                                </div>
                                <div class="news-slide__date"></div>
                                <div class="news-slide__title">
                                    <?= $item['NAME'] ?>
                                </div>
                            </a>
                        </div>
                    <? } ?>
                    <div class="swiper-slide">
                        <div class="news-slider__more">
                            <h2>Еще новости</h2>
                            <a href="/news" class="btn btn-outline-light px-4">
                                Смотреть
                            </a>
                        </div>
                    </div>
                </div>
                <div class="base-slider__arrows">
                    <div class="base-slider__prev"></div>
                    <div class="base-slider__next"></div>
                </div>
            </div>
        </div>
    </div>
</section>