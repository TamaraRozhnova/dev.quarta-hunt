<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!count($arResult)) {
    return;
}

$currentPage = $APPLICATION->GetCurPage();
?>

<div class="header__nav col">
    <? foreach ($arResult as $index => $item) { ?>
        <a
            href="<?= $item['LINK'] ?>"
            class="header__nav-item
            <?= $currentPage === $item['LINK'] ? ' header__nav-item--active' : '' ?> 
            <?= $item['PARAMS']['SET_BACKGROUND'] == 'Y' ? 'header__nav-item--selected' : null ?>
            <?= $item['PARAMS']['HIGHLIGHT_ORANGE'] == 'Y' ? 'highlight-orange' : null ?>"
        >
            <?= $item['TEXT'] ?>
        </a>
    <? } ?>
</div>