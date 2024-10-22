<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

global $isMobile;
?>

<section class="modern-promo-sales <?=$isMobile ? 'mobile' : ''?>">
    <? foreach ($arResult['ITEMS'] as $arItem) { ?>
        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="modern-promo-sales__item <?=$isMobile ? 'mobile' : ''?>">
            <div class="modern-promo-sales__img">
                <img src="<?= $arItem['PIC'] ?>">
            </div>
            <div class="modern-promo-sales__text">
                <div class="modern-promo-sales__title">
                    <?= $arItem['NAME'] ?>
                </div>

                <?php if (!$isMobile) { ?>
                    <div class="modern-promo-sales__preview">
                        <?= $arItem['PREVIEW_TEXT'] ?>
                    </div>
                    <div class="modern-promo-sales__btn">
                        <span>Подробности акции</span>
                    </div>
                <?php } ?>
            </div>
            <?php if ($isMobile) { ?>
                <div class="modern-promo-sales__preview">
                    <?= $arItem['PREVIEW_TEXT'] ?>
                </div>
                <div class="modern-promo-sales__btn">
                    <span>Подробности акции</span>
                </div>
            <?php } ?>

        </a>
    <? } ?>
</section>
