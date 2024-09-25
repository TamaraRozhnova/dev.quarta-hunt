<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

global $isMobile;
?>

<div class="col">
    <section class="modern-promo-page-sales <?= $isMobile ? 'mobile' : '' ?>">
        <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div class="sale-item">
                <img src="<?= $arItem['PIC'] ?>" alt="<?= $arItem['NAME'] ?>">

                <div class="sale-item-textblock">
                    <p class="sale-item-title"><?= $arItem['NAME'] ?></p>
                    <p class="sale-item-preview"><?= $arItem['PREVIEW_TEXT'] ?></p>
                    <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="sale-item-button">Подробности акции</a>
                </div>
            </div>
        <?php } ?>
    </section>
</div>
