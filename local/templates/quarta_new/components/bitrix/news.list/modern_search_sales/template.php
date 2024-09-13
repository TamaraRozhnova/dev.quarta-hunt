<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}
?>

<section class="modern-promo-sales">
    <? foreach ($arResult['ITEMS'] as $arItem) { ?>
        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="modern-promo-sales__item">
            <div class="modern-promo-sales__img">
                <img src="<?= $arItem['PIC'] ?>">
            </div>
            <div class="modern-promo-sales__text">
                <div class="modern-promo-sales__title">
                    <?= $arItem['NAME'] ?>
                </div>
                <div class="modern-promo-sales__preview">
                    <?= $arItem['PREVIEW_TEXT'] ?>
                </div>
                <div class="modern-promo-sales__btn">
                    <span>Подробности акции</span>
                </div>
            </div>

        </a>
    <? } ?>
</section>
