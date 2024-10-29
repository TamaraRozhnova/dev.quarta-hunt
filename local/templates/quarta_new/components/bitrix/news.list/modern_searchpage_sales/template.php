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
    <div class="filters-sort">
        <button class="filters-sort__btn">
            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 2.57143H15.3643C15.0429 1.09286 13.7571 0 12.2143 0C10.6714 0 9.38571 1.09286 9.06429 2.57143H0V3.85714H9.06429C9.38571 5.33571 10.6714 6.42857 12.2143 6.42857C13.7571 6.42857 15.0429 5.33571 15.3643 3.85714H18V2.57143ZM12.2143 5.14286C11.1214 5.14286 10.2857 4.30714 10.2857 3.21429C10.2857 2.12143 11.1214 1.28571 12.2143 1.28571C13.3071 1.28571 14.1429 2.12143 14.1429 3.21429C14.1429 4.30714 13.3071 5.14286 12.2143 5.14286Z" fill="#333333" />
                <path d="M0 12.8571H2.63571C2.95714 14.3357 4.24286 15.4286 5.78571 15.4286C7.32857 15.4286 8.61429 14.3357 8.93571 12.8571H18V11.5714H8.93571C8.61429 10.0929 7.32857 9 5.78571 9C4.24286 9 2.95714 10.0929 2.63571 11.5714H0V12.8571ZM5.78571 10.2857C6.87857 10.2857 7.71429 11.1214 7.71429 12.2143C7.71429 13.3071 6.87857 14.1429 5.78571 14.1429C4.69286 14.1429 3.85714 13.3071 3.85714 12.2143C3.85714 11.1214 4.69286 10.2857 5.78571 10.2857Z" fill="#333333" />
            </svg>
        </button>
    </div>

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
