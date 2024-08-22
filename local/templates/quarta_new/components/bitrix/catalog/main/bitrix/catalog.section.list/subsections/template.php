<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (empty($arResult['SECTIONS'])) {
    return;
}

$currentPage = $APPLICATION->GetCurPage();

?>

<section class="subcategory-selector">
    <div class="container"></div>
    <div class="subcategory-selector__container container subcategory-selector__container--desktop">
        <? foreach ($arResult['SECTIONS'] as $section) { ?>
            <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="btn btn-white <?= $section['ID']?> <?= $currentPage === $section['SECTION_PAGE_URL'] ? 'active' : '' ?>">
                <?= $section['NAME'] ?>
            </a>
        <? } ?>
    </div>

    <div class="subcategory-selector__container subcategory-selector__container--mobile">
        <? foreach ($arResult['SECTIONS'] as $section) { ?>
            <a href="<?= $section['SECTION_PAGE_URL'] ?>" class="btn btn-white <?= $section['ID']?>" <?= $currentPage === $section['SECTION_PAGE_URL'] ? 'active' : '' ?>>
                <?= $section['NAME'] ?>
            </a>
        <? } ?>
    </div>

    <?/*div class="container">
        <? if ($arResult['BACK_URL']) { ?>
            <a href="<?= $arResult['BACK_URL'] ?>" class="btn btn-primary me-2 py-2">
                Назад
            </a>
        <? } ?>

        <a class="btn subcategory-selector__more btn-outline-secondary py-2">
            Еще...
        </a>
    </div*/?>
</section>
