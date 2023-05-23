<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult['ITEMS'])) {
    return;
}

?>

<div class="row">
    <div class="header-categories">
        <div class="header-nav-item header-categories__item">
            <a href="/catalog/">
                <div class="header-categories__icon">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/catalog.svg" alt=""/>
                </div>
                Каталог товаров
            </a>
        </div>
        <div class="header-nav-item header-categories__item non-dropmenu">
            <a href="/promo/">
                <span>Акции</span>
            </a>
        </div>

        <? foreach ($arResult['ITEMS'] as $id => $topLevelSection) { ?>
            <div class="header-nav-item header-categories__item" data-id="<?= $id ?>">
                <a href="<?= $topLevelSection['LINK'] ?>">
                    <span><?= $topLevelSection['NAME'] ?></span>
                </a>
            </div>
        <? } ?>
    </div>
</div>

<script>
    window.catalogListMenu = <?= CUtil::PhpToJSObject($arResult['ITEMS'], false, true) ?>;
</script>