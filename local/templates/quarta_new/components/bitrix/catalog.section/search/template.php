<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="search">
    <div class="container">
        <h2>Результаты поиска</h2>

        <? if (count($arResult['ITEMS']) > 0) { ?>
            <p class="mb-4">
                Найдено <?= count($arResult['ITEMS']) ?> Товаров по вашему запросу
                <span class="text-primary"><?= $_GET['q'] ?></span>
            </p>
        <? } else { ?>
            <p class="mb-4">
                Простите, по вашему запросу товаров сейчас нет. <br />
                <a href="/">На главную</a>
            </p>
        <? } ?>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="col mb-4">
                    <? $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        'main',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                                'PARAMS' => $arParams
                            ),
                        ),
                        $component
                    ); ?>
                </div>
            <? } ?>
        </div>
    </div>
</div>