<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 * @var array $arParam
 * @var CBitrixComponentTemplate $this
 */

/** @var PageNavigationComponent $component */

$component = $this->getComponent();

if ($arResult['PAGE_COUNT'] < 2) {
    return;
}

$currentPage = $arResult['CURRENT_PAGE'];
$totalPages = $arResult['PAGE_COUNT'];


$nextPage = $totalPages > $currentPage ? $currentPage + 1 : 0;

$queryString = parse_url($arResult['URL'], PHP_URL_QUERY);
parse_str($queryString, $params);

if (isset($params['cur_page'])) {
    unset($params['cur_page']);
}

$queryString = http_build_query($params);
$arResult['URL'] = '/search/?' . $queryString;?>

<div class="pagination container">
    <? if ((int)$arResult['START_PAGE'] > 1) { ?>
        <a href="<?=$arResult['URL']?>&cur_page=page-<?=$i?>" class="btn btn-sm mx-1" data-id="1">
            1
        </a>
    <? } ?>

    <? if ($totalPages > 5 && $currentPage > 3) { ?>
        <div class="btn btn-sm disabled mx-1">...</div>
    <? } ?>

    <? for ($i = (int)$arResult['START_PAGE']; $i <= (int)$arResult['END_PAGE']; $i++) { ?>
        <a href="<?=$arResult['URL']?>&cur_page=page-<?=$i?>" class="btn btn-sm mx-1<?= $currentPage == $i ? ' btn-primary' : '' ?>" data-id="<?= $i ?>">
            <?= $i ?>
        </a>
    <? } ?>

    <? if ($currentPage <= $totalPages - 3) { ?>
        <div class="btn btn-sm disabled mx-1">...</div>
    <? } ?>

    <? if ($nextPage) { ?>
        <a href="<?=$arResult['URL']?>&cur_page=page-<?=$nextPage?>" class="btn btn-primary btn-sm mx-1" data-id="<?= $nextPage ?>">
            Дальше
        </a>
    <? } ?>
</div>
