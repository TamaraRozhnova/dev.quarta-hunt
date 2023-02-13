<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>

<div class="catalog-mobile">
    <? foreach ($arResult['ITEMS'] as $topLevelSection) { ?>
        <div class="catalog-category-mobile">
            <div class="catalog-category-mobile__title">
                <?= $topLevelSection['NAME'] ?>
            </div>

            <? if (count($topLevelSection['SUBSECTIONS'])) { ?>
                <div class="catalog-category-mobile__children">
                    <? foreach ($topLevelSection['SUBSECTIONS'] as $secondLevelSection) { ?>
                        <a href="<?= $secondLevelSection['LINK'] ?>" class="catalog-category-mobile__child">
                            <?= $secondLevelSection['NAME'] ?>
                        </a>
                    <? } ?>
                </div>
            <? } ?>

        </div>
    <? } ?>
</div>