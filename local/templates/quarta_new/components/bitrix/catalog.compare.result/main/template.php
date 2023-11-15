<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="compare__add-more" style="display: <?= count($arResult['ITEMS']) === 1 ? 'block' : 'none' ?>">
    <p class="text-dark fs-6">
        Добавьте еще один товар чтобы начать сравнение
    </p>
    <a href="/catalog" class="btn btn-primary px-4">Продолжить покупки</a>
</div>

<button class="move-left">Влево</button>
<button class="move-right">Вправо</button>

<div class="compare__table-wrapper" style="display: <?= count($arResult['ITEMS']) > 1 ? 'block' : 'none' ?>">
    <div class="compare__table">
        <div class="compare__column-backdrop"></div>
        <div class="compare__row">
            <div class="compare__col compare__col--first"></div>
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="compare__col compare__item" data-id="<?= $item['ID'] ?>">
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

        <div class="compare__row">
            <div class="compare__col compare__col--first mb-0 mt-5">
                <div class="checkbox form-check">
                    <input id="only-different" type="checkbox" class="form-check-input">
                    <label for="only-different" class="form-check-label">
                        Показывать только различия
                    </label>
                </div>
            </div>
        </div>

        <div class="compare__divider"></div>

        <div class="compare__row">
            <div class="compare__col compare__col--first">
                <b>Рейтинг</b>
            </div>
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="compare__col compare__rating" data-id="<?= $item['ID'] ?>">
                    <div class="stars placeholder-glow">
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                    </div>
                </div>
            <? } ?>
        </div>

        <div class="compare__divider"></div>

        <div class="compare__row">
            <div class="compare__col compare__col--first">
                <b>Основные характеристики</b>
            </div>
        </div>
        <? foreach ($arResult['PROPS'] as $key => $name) { ?>
            <div class="compare__row compare__prop" data-different="<?= in_array($key, $arResult['DIFFERENT_PROP_KEYS']) ? 'true' : 'false' ?>">
                <div class="compare__col compare__col--first">
                    <?= $name ?>
                </div>
                <? foreach ($arResult['ITEMS'] as $item) { ?>
                    <div class="compare__col compare__col--main"
                         data-id="<?= $item['ID'] ?>"
                         data-value="<?= $item['PROPERTIES'][$key]['VALUE'] ?>"
                    >
                        <?= $item['PROPERTIES'][$key]['VALUE'] ?>
                    </div>
                <? } ?>
            </div>
        <? } ?>

        <div class="compare__divider"></div>
    </div>

    <div class="compare__clear btn bg-white px-4 py-2 btn-sm mt-2">
        Очистить
    </div>
</div>




