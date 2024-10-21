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

$startPageUrl = $arResult['sUrlPath'] . '?' . $arResult['NavQueryString'] . '&PAGEN_' . $arResult['NavNum'];

?>

<div class="pagination">
    <? if ((int)$arResult['nStartPage'] > 1) { ?>
        <a class="btn btn-sm mx-1" href="<?= $startPageUrl . '=' . 1 ?>">
            1
        </a>
    <? } ?>

    <? if ($totalPages > 5 && $currentPage > 3) { ?>
        <div class="btn btn-sm disabled mx-1">...</div>
    <? } ?>

    <? for ($i = (int)$arResult['nStartPage']; $i <= (int)$arResult['nEndPage']; $i++) { ?>
        <a class="btn btn-sm mx-1<?= $currentPage == $i ? ' btn-primary' : ''?>" href="<?= $startPageUrl . '=' . $i ?>">
            <?= $i ?>
        </a>
    <? } ?>

    <? if ($currentPage <= $totalPages - 3) { ?>
        <div class="btn btn-sm disabled mx-1">...</div>
    <? } ?>

    <? if ($nextPage) { ?>
        <a class="btn btn-primary btn-sm mx-1" href="<?= $startPageUrl . '=' . $nextPage ?>">
            Дальше
        </a>
    <? } ?>
</div>
