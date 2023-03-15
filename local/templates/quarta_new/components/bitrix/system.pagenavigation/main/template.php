<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if ($arResult['NavPageCount'] < 2) {
    return;
}

$currentPage = $arResult['NavPageNomer'];
$totalPages = $arResult['NavPageCount'];

$nextPage = $totalPages > $currentPage ? $currentPage + 1 : 0;

?>

<div class="pagination">
    <? if ((int)$arResult['nStartPage'] > 1) { ?>
        <div class="btn btn-sm mx-1" data-id="1">1</div>
    <? } ?>

    <? if ($totalPages > 5 && $currentPage > 3) { ?>
        <div class="btn btn-sm disabled mx-1">...</div>
    <? } ?>

    <? for ($i = (int)$arResult['nStartPage']; $i <= (int)$arResult['nEndPage']; $i++) { ?>
        <div class="btn btn-sm mx-1<?= $currentPage == $i ? ' btn-primary' : '' ?>" data-id="<?= $i ?>">
            <?= $i ?>
        </div>
    <? } ?>

    <? if ($currentPage <= $totalPages - 3) { ?>
        <div class="btn btn-sm disabled mx-1">...</div>
    <? } ?>

    <? if ($nextPage) { ?>
        <div class="btn btn-primary btn-sm mx-1" data-id="<?= $nextPage ?>">Дальше</div>
    <? } ?>
</div>
