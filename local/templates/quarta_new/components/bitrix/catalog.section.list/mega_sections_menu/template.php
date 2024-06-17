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
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="21" height="21" rx="5" fill="#E8EFF4" />
                        <path d="M8.94189 6.97754H15.9871" stroke="#004989" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8.94189 10.498H13.3451" stroke="#004989" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8.94189 14.0225H15.9871" stroke="#004989" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.2992 7.85797C6.73952 7.85797 7.17984 7.41765 7.17984 6.97732C7.17984 6.537 6.73952 6.09668 6.2992 6.09668C5.85888 6.09668 5.41943 6.537 5.41943 6.97732C5.41943 7.41765 5.85888 7.85797 6.2992 7.85797ZM6.2992 11.3806C6.73952 11.3806 7.17984 10.9402 7.17984 10.4999C7.17984 10.0596 6.73952 9.61926 6.2992 9.61926C5.85888 9.61926 5.41943 10.0596 5.41943 10.4999C5.41943 10.9402 5.85888 11.3806 6.2992 11.3806ZM6.2992 14.9031C6.73952 14.9031 7.17984 14.4628 7.17984 14.0225C7.17984 13.5822 6.73952 13.1418 6.2992 13.1418C5.85888 13.1418 5.41943 13.5822 5.41943 14.0225C5.41943 14.4628 5.85888 14.9031 6.2992 14.9031Z" fill="#004989" />
                    </svg>
                    <svg class="close-icon" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="21" height="21" rx="5" fill="#E8EFF4" />
                        <path d="M7 14L15 6" stroke="#004989" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7 6L15 14" stroke="#004989" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                Каталог товаров
            </a>
        </div>

        <?php
        /*  Оптика и крепления
            Оружие и патроны
            Снаряжение и одежда
            Средства для ухода за оружием
            Тюнинг оружия и ЗИП
        */ ?>
        <?php foreach ($arResult['ITEMS'] as $id => $topLevelSection) {

            if (
                $topLevelSection['ID'] == 516 ||
                $topLevelSection['ID'] == 583 ||
                $topLevelSection['ID'] == 609 ||
                $topLevelSection['ID'] == 715 ||
                $topLevelSection['ID'] == 745
            ) { ?>
                <div class="header-nav-item header-categories__item" data-id="<?= $id ?>">
                    <a href="<?= $topLevelSection['LINK'] ?>">
                        <span><?= $topLevelSection['NAME'] ?></span>
                    </a>
                </div>
            <? } ?>
        <?php } ?>
    </div>


    <div class="mega-menu">
        <div class="mega-menu-wrapper container">
            <!-- menu-->
            <div class="menu-list">

                <ul>
                    <li class="sale" data-id="sale" onclick="location.href = '/promo/';">
                        <span class="menu-icon sale"></span>
                        <span class="menu-text">Акции</span>
                        <span class="active-icon"><img src="<?= $templateFolder ?>/img/menuarrow.svg" alt="->"></span>
                    </li>

                    <?php foreach ($arResult['ITEMS'] as $id => $topLevelSection) { ?>
                        <li data-id="<?= $id ?>" onclick="location.href = '<?= $topLevelSection['LINK'] ?>';">
                            <span class="menu-icon" style="background-image: url('<?= $topLevelSection['ICON'] ?>');"></span>
                            <span class="menu-text"><?= $topLevelSection['NAME'] ?></span>
                            <span class="active-icon"><img src="<?= $templateFolder ?>/img/menuarrow.svg" alt="->"></span>
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
                                <img src="<?= $saleItem["IMAGE"] ?>" alt="<?= $saleItem['NAME'] ?>">

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
                            <span><?= num_word($topLevelSection['ELEMENT_CNT'], ['товар', 'товара', 'товаров']) ?></span>
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
                    <span>
                        <img src="<?= $brand["IMAGE"] ?>" alt="<?= $brand['NAME'] ?>" />
                    </span>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

<script>
    const arSectionsBrandsMenu = <?=json_encode($arResult['BRANDS_JS']);?>
</script>