<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>

<div class="catalog-mobile">

    <div class="menu-list">
        <ul>
            <li class="wholesale" data-id="wholesale">
                <a href="/wholesale" class="menu-text">Оптовикам</a>
            </li>

            <li class="sale" data-id="sale">
                <span class="menu-icon sale"></span>
                <span class="menu-text">Акции</span>
                <span class="active-icon"><img src="<?= $templateFolder ?>/img/menuarrow.svg" alt="->"></span>
            </li>

            <?php foreach ($arResult['ITEMS'] as $id => $topLevelSection) { ?>
                <li data-id="<?= $id ?>">
                        <span class="menu-icon"
                              style="background-image: url('<?= $topLevelSection['ICON'] ?>');"></span>
                    <span class="menu-text"><?= $topLevelSection['NAME'] ?></span>
                    <span class="active-icon"><img src="<?= $templateFolder ?>/img/menuarrow.svg" alt="->"></span>
                </li>
            <?php } ?>
        </ul>
    </div>

    <!--    -->
    <div class="catalog-slide-menu">
        <div class="catalog-mobile-content">
            <div class="menu-content-data " data-content="sale">
                <div class="title">Действующие акции</div>

                <div class="sale-data">
                    <?php foreach ($arResult['SALE_DATA'] as $saleItem) { ?>

                        <div class="sale-item" onclick="location.href='<?= $saleItem['URL'] ?>'">
                            <img src="<?= $saleItem["IMAGE"] ?>" alt="<?= $saleItem['NAME'] ?>" >

                            <div class="sale-item-textblock">
                                <p class="sale-item-title"><?= $saleItem['NAME'] ?></p>
                                <p class="sale-item-preview"><?= $saleItem['NAME'] ?></p>
                                <a href="<?= $saleItem['URL'] ?>" class="sale-item-button">Подробности акции</a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>


            <?php foreach ($arResult['ITEMS'] as $id => $topLevelSection) { ?>
                <div class="menu-content-data" data-content="<?= $id ?>">
                    <div class="title"><?= $topLevelSection['NAME'] ?></div>

                    <div class="subsection-grid">
                        <?php foreach ($topLevelSection['SUBSECTIONS'] as $subSection) { ?>
                            <div class="catalog-category-mobile">
                                <a href="<?= $subSection['LINK'] ?>" class="catalog-category-mobile__title <?=($subSection['SUBSECTIONS']) ? 'expand' : ''?>">
                                    <?= $subSection['NAME'] ?>
                                </a>

                                <?php if ($subSection['SUBSECTIONS']) { ?>
                                    <div class="catalog-category-mobile__children">
                                        <? foreach ($subSection['SUBSECTIONS'] as $subLvl3) { ?>
                                            <a href="<?= $subLvl3['LINK'] ?>" class="catalog-category-mobile__child">
                                                <?= $subLvl3['NAME'] ?>
                                            </a>
                                        <? } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>
