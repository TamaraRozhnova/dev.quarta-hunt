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
                                <img src="<?= $section['PICTURE']['SRC'] ?>" alt="<?= $section['NAME'] ?>"/>
                            </figure>
                            <div class="category-card__title">
                                <?= $section['NAME'] ?>
                            </div>
                            <div class="category-card__count">
                                <?= $section['ELEMENT_CNT_TITLE'] ?>
                            </div>
                        </div>
                    </a>
                </div>
            <? } ?>
        </div>
    </div>
</section>
