<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['SECTIONS'])) {
    return;
}

?>

<section class="catalog__categories">
    <div class="container">
        <div class="row">
            <? foreach ($arResult['SECTIONS'] as $section) { ?>
                <div class="col-4">
                    <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="category-card">
                        <div class="category-card__background"></div>

                        <div class="category-card__body">
                            <figure class="category-card__image">
                                <img src="<?= $section['PICTURE']['SRC'] ?>" alt="<?= $section['NAME'] ?>">
                            </figure>
                            <h2 class="category-card__title">
                                <?= $section['NAME'] ?>
                            </h2>
                            <p class="category-card__count">
                                <?= $section['ELEMENT_CNT_TITLE'] ?>
                            </p>
                        </div>
                    </a>
                </div>
            <? } ?>
        </div>
    </div>
</section>
