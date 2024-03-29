<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>

<div class="row" style="position: relative;">
    <div class="header-categories">
        <div class="header-nav-item header-categories__item mega-menu-opener">
            <a href="/catalog/">
                <div class="header-categories__icon">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/catalog.svg" alt=""/>
                </div>
                Каталог товаров
            </a>
        </div>

        <?php foreach ($arResult['ITEMS'] as $id => $topLevelSection) { ?>
            <div class="header-nav-item header-categories__item" data-id="<?= $id ?>">
                <a href="<?= $topLevelSection['LINK'] ?>">
                    <span><?= $topLevelSection['NAME'] ?></span>
                </a>
            </div>
        <?php } ?>
    </div>


    <div class="mega-menu">
        <div class="mega-menu-wrapper container">
            <!-- menu-->
            <div class="menu-list">

                <ul>
                    <li class="sale" data-id="sale">
                        <span class="menu-icon sale"></span>
                        <span class="menu-text">Акции</span>
                        <span class="active-icon"><img src="<?=$templateFolder?>/img/menuarrow.svg" alt="->"></span>
                    </li>

                    <?php foreach ($arResult['ITEMS'] as $id => $topLevelSection) { ?>
                        <li data-id="<?= $id ?>">
                        <span class="menu-icon"
                              style="background-image: url('<?= $topLevelSection['ICON'] ?>');"></span>
                            <span class="menu-text"><?= $topLevelSection['NAME'] ?></span>
                            <span class="active-icon"><img src="<?=$templateFolder?>/img/menuarrow.svg" alt="->"></span>
                        </li>
                    <?php } ?>
                </ul>

            </div>

            <div class="menu-content">


                <div class="menu-content-data " data-content="sale">
                    <div class="title">Действующие акции</div>

                    <div class="sale-data">
                        <?php foreach ($arResult['SALE_DATA'] as $saleItem) { ?>

                            <div class="sale-item" onclick="location.href='<?= $saleItem['URL'] ?>'">
                                <img src="<?= $saleItem["IMAGE"] ?>" alt="<?= $saleItem['NAME'] ?>"/>

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
                        <div class="title"><?= $topLevelSection['NAME'] ?>
                            <span><?= $topLevelSection['ELEMENT_CNT'] ?> <?= Loc::getMessage('PRODUCT_TITLE') ?></span>
                        </div>

                        <div class="subsection-grid">
                            <?php foreach ($topLevelSection['SUBSECTIONS'] as $subSection) { ?>
                                <div class="subsection">
                                    <div class="subsection-title">
                                        <a href="<?= $subSection['LINK'] ?>">
                                            <span><?= $subSection['NAME'] ?></span>
                                        </a>
                                    </div>

                                    <?php if ($subSection['SUBSECTIONS']) { ?>
                                        <ul>
                                            <?php foreach ($subSection['SUBSECTIONS'] as $subLvl3) { ?>
                                                <li>
                                                    <a href="<?= $subLvl3['LINK'] ?>"><span><?= $subLvl3['NAME'] ?></span></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- brands-->
            <div class="brands-list" id="manu-brands-list">
                <?php foreach ($arResult['BRAND_DATA'] as $brand) { ?>
                    <a href="<?= $brand['URL'] ?>">
                        <img src="<?= $brand["IMAGE"] ?>" alt="<?= $brand['NAME'] ?>"/>
                    </a>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

