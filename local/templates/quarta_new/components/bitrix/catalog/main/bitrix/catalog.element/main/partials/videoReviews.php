<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($result['VIDEO_REVIEWS'])) {
    return;
}

?>

<div class="video-reviews">
    <? if ($result['VIDEO_REVIEWS']['NAME']) { ?>
        <div class="container">
            <h2 class="mb-4"><?= $result['VIDEO_REVIEWS']['NAME'] ?></h2>
        </div>
    <? } ?>
    <div class="base-slider">
        <div class="container">
            <div class="swiper-container swiper-container_video-reviews">
                <div class="swiper-wrapper">
                    <? foreach ($result['VIDEO_REVIEWS']['LIST'] as $item) { ?>
                        <div class="swiper-slide">
                            <div class="video-preview__wrapper" data-video-src="<?= $item['VIDEO_SRC'] ?>">
                                <div class="video-preview" style="background-image: url('<?= $item['PREVIEW_IMAGE'] ?>')">
                                    <div class="video-preview__inner">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/play-button.svg" alt="Воспроизвести" />
                                    </div>
                                </div>
                            </div>
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
</div>