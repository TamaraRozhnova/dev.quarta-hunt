<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="col">
    <div class="products-grid__wrapper">
        <div class="products-grid">
            <div class="filters-sort">
                <button class="filters-sort__btn">
                    <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 2.57143H15.3643C15.0429 1.09286 13.7571 0 12.2143 0C10.6714 0 9.38571 1.09286 9.06429 2.57143H0V3.85714H9.06429C9.38571 5.33571 10.6714 6.42857 12.2143 6.42857C13.7571 6.42857 15.0429 5.33571 15.3643 3.85714H18V2.57143ZM12.2143 5.14286C11.1214 5.14286 10.2857 4.30714 10.2857 3.21429C10.2857 2.12143 11.1214 1.28571 12.2143 1.28571C13.3071 1.28571 14.1429 2.12143 14.1429 3.21429C14.1429 4.30714 13.3071 5.14286 12.2143 5.14286Z" fill="#333333"/><path d="M0 12.8571H2.63571C2.95714 14.3357 4.24286 15.4286 5.78571 15.4286C7.32857 15.4286 8.61429 14.3357 8.93571 12.8571H18V11.5714H8.93571C8.61429 10.0929 7.32857 9 5.78571 9C4.24286 9 2.95714 10.0929 2.63571 11.5714H0V12.8571ZM5.78571 10.2857C6.87857 10.2857 7.71429 11.1214 7.71429 12.2143C7.71429 13.3071 6.87857 14.1429 5.78571 14.1429C4.69286 14.1429 3.85714 13.3071 3.85714 12.2143C3.85714 11.1214 4.69286 10.2857 5.78571 10.2857Z" fill="#333333"/></svg>
                </button>
                <div class="checkbox form-check">
                    <input
                        id="available"
                        class="form-check-input"
                        type="checkbox"
                        <?= $arParams['HIDE_NOT_AVAILABLE'] === 'Y' ? 'checked' : '' ?>
                    />
                    <label class="form-check-label" for="available">
                        В наличии
                    </label>
                </div>
                <div class="select__wrapper select__wrapper--small">
                    <div id="select-sort"
                         class="select select--small"
                         data-initial-id="<?= $arResult['SORT_VALUE'] ?? '' ?>"
                         data-placeholder="Сортировать:"
                    >
                        <button class="select__main btn">
                            <?= $arResult['SORT_OPTIONS'][$arResult['SORT_VALUE']] ?? 'Сортировать:' ?>
                            <div class="select__options">
                                <? foreach ($arResult['SORT_OPTIONS'] as $key => $title) { ?>
                                    <div data-id="<?= $key ?>" class="select__option" tabindex="0">
                                        <span><?= $title ?></span>
                                    </div>
                                <? } ?>
                            </div>
                        </button>
                    </div>
                </div>

                <div id="list-count" class="filters-sort__count">
                    <span>Выводить по:</span>
                    <ul>
                        <? foreach ($arResult['ELEMENT_COUNT_OPTIONS'] as $key => $title) { ?>
                            <li class="<?= $arParams['PAGE_ELEMENT_COUNT'] == $key ? 'active' : '' ?>"  data-id="<?= $key ?>">
                                <?= $title ?>
                            </li>
                        <? } ?>
                    </ul>
                </div>

                <div class="select__wrapper filters-sort__count filters-sort__count--select select__wrapper--small">
                    <div id="select-count"
                         class="select select--small"
                         data-initial-id="<?= $arParams['PAGE_ELEMENT_COUNT'] ?>"
                    >
                        <button class="select__main btn">
                            <?= $arParams['PAGE_ELEMENT_COUNT'] ?>
                            <div class="select__options">
                                <? foreach ($arResult['ELEMENT_COUNT_OPTIONS'] as $key => $title) { ?>
                                    <div data-id="<?= $key ?>" tabindex="0" class="select__option">
                                        <span><?= $title ?></span>
                                    </div>
                                <? } ?>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="loading" style="min-height: 15rem">
                <div
                    class="spinner-border text-primary"
                    style="width: 2rem; height: 2rem"
                    role="status"
                >
                    <span class="visually-hidden">Загрузка</span>
                </div>

                <div class="loading__text">
                    Загрузка
                </div>
            </div>
            <div class="products-data products-data--show">
                <? if (count($arResult['ITEMS']) > 0) { ?>
                    <div class="row">
                        <? foreach ($arResult['ITEMS'] as $item) { ?>
                            <div class="col-6 col-md-3">
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
                <? } else { ?>
                    <div class="products-not-found my-5 py-5">
                        По Вашему запросу ничего не нашлось.<br/>
                        Попробуйте
                        <a class="products-not-found__button" href="#">сбросить фильтры</a>
                    </div>
                <? } ?>

                <?= $arResult['NAV_STRING'] ?>

            </div>
        </div>
    </div>
</div>