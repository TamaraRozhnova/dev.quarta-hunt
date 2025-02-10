<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="favorites">
    <div class="container">
        <? if (!empty($arResult['ITEMS'])) { ?>
            <div class="favorites__main">
                <h2>Избранное</h2>
                <? if (!empty($arResult['SECTIONS'])) { ?>
                    <div class="subcategory-selector">
                        <div class="subcategory-selector__container subcategory-selector__container--desktop">
                            <a href="<?= $APPLICATION->GetCurPage(); ?>" class="btn btn-white <?= empty($arResult['CURRENT_SECTION_ID']) ? 'active' : '' ?>">
                                Все категории
                            </a>
                            <? foreach ($arResult['SECTIONS'] as $section) { ?>
                                <a href="?section=<?= $section['ID'] ?>" class="btn btn-white <?= $arResult['CURRENT_SECTION_ID'] == $section['ID'] ? 'active' : '' ?>">
                                    <?= $section['NAME'] ?>
                                </a>
                            <? } ?>
                        </div>

                        <div class="subcategory-selector__container subcategory-selector__container--mobile">
                            <a href="<?= $APPLICATION->GetCurPage(); ?>" class="btn btn-white <?= empty($arResult['CURRENT_SECTION_ID']) ? 'active' : '' ?>">
                                Все категории
                            </a>
                            <? foreach ($arResult['SECTIONS'] as $section) { ?>
                                <a href="?section=<?= $section['ID'] ?>" class="btn btn-white <?= $arResult['CURRENT_SECTION_ID'] == $section['ID'] ? 'active' : '' ?>">
                                    <?= $section['NAME'] ?>
                                </a>
                            <? } ?>
                        </div>
                    </div>
                <? } ?>
                <div class="row align-items-center">
                    <p class="favorites__count col-6 my-4"></p>
                    <div class="col-6 text-right">
                        <button class="favorites__clean-btn">Очистить</button>
                    </div>
                </div>
                <div class="row">
                    <? foreach ($arResult['ITEMS'] as $item) { ?>
                        <div class="mb-4 favorites__item" data-id="<?= $item['ID'] ?>">
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
        <? } ?>

        <div class="cart__empty" style="display: <?= empty($arResult['ITEMS']) ? 'block' : 'none' ?>">
            <h2>В избранном ничего нет</h2>
            <p>Воспользуйтесь поиском, чтобы найти всё, что нужно.</p>
            <a class="btn btn-lg btn-primary" href="/catalog">Продолжить покупки</a>
        </div>

    </div>
</div>