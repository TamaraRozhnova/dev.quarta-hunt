<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

global $isMobile;
?>

<section class="modern-promo-blog">
    <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="modern-promo-blog__item <?= $isMobile ? 'mobile' : '' ?>">
            <div class="modern-promo-blog__img">
                <img src="<?= $arItem['PIC'] ?>">
            </div>
            <div class="modern-promo-blog__text">
                <div class="modern-promo-blog__date">
                    <?= $arItem['DATE_CREATE'] ?> <span>Новости</span>
                </div>
                <div class="modern-promo-blog__title">
                    <?= $arItem['NAME'] ?>
                </div>
                <?php if (!$isMobile) { ?>
                    <div class="modern-promo-blog__preview">
                        <?= $arItem['PREVIEW_TEXT'] ?>
                    </div>
                <?php } ?>
            </div>

            <?php if ($isMobile) { ?>
                <div class="modern-promo-blog__preview">
                    <?= $arItem['PREVIEW_TEXT'] ?>
                </div>
            <?php } ?>

            <div class="modern-promo-blog__btn">
                <span>Подробности новости</span>
            </div>

        </a>
    <?php } ?>
</section>
