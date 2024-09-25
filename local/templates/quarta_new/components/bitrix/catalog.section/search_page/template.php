<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * Определяем шаблон для вывода catalog.item
 */
$strTemplate = match ($_GET['templateView']) {
    'list' => 'list.horizontal.simple',
    default => 'main',
};

?>

<div class="col">
    <div class="products-grid__wrapper">
        <div class="products-grid">
            <div class="filters-sort">
                <div class="checkbox form-check">
                    <input
                        id="available"
                        class="form-check-input"
                        type="checkbox"
                        <?= $arParams['HIDE_NOT_AVAILABLE'] === 'Y' ? 'checked' : '' ?> />
                    <label class="form-check-label" for="available">
                        В наличии
                    </label>
                </div>
                <div class="select__wrapper select__wrapper--small">
                    <div id="select-sort"
                        class="select select--small"
                        data-initial-id="<?= $arResult['CURRENT_SORT'] ?? '' ?>"
                        data-placeholder="Сортировать:">
                        <button class="select__main btn">
                            Сортировать:
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
                            <li class="<?= $arParams['PAGE_ELEMENT_COUNT'] == $key ? 'active' : '' ?>" data-id="<?= $key ?>">
                                <?= $title ?>
                            </li>
                        <? } ?>
                    </ul>
                </div>

                <div class="select__wrapper filters-sort__count filters-sort__count--select select__wrapper--small">
                    <div id="select-count"
                        class="select select--small"
                        data-initial-id="<?= $arParams['PAGE_ELEMENT_COUNT'] ?>">
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

            <div class="loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Загрузка</span>
                </div>
                <div class="loading__text">
                    Загрузка
                </div>
            </div>
            <div class="products-data products-data--show">
                <? if (count($arResult['ITEMS']) > 0) { ?>
                    <div class="row" itemscope itemtype="http://schema.org/ItemList">
                        <? foreach ($arResult['ITEMS'] as $item) { ?>
                            <? $APPLICATION->IncludeComponent(
                                'bitrix:catalog.item',
                                $strTemplate,
                                array(
                                    'RESULT' => array(
                                        'ITEM' => $item,
                                        'PARAMS' => $arParams
                                    ),
                                ),
                                $component
                            ); ?>
                        <? } ?>
                    </div>


                <? } else { ?>
                    <div class="products-not-found my-5 py-5">
                        По Вашему запросу ничего не нашлось.<br />
                        Попробуйте
                        <a class="products-not-found__button" href="#">сбросить фильтры</a>
                    </div>
                <? } ?>

                <?= $arResult['NAV_STRING'] ?>

                <? if ($arResult['ROOT_SECTION_DESC'] && !empty($arResult['ROOT_SECTION_DESC'])) { ?>
                    <div class="section__desc section__desc--root">
                        <?= $arResult['ROOT_SECTION_DESC'] ?>
                    </div>
                <? } ?>

                <? if ($arResult['DESCRIPTION'] && !empty($arResult['DESCRIPTION'])) { ?>
                    <div class="section__desc">
                        <?
                        global $sotbitSeoMetaBottomDesc; //для установки нижнего описания
                        if (empty($sotbitSeoMetaBottomDesc)) {
                            echo $arResult['DESCRIPTION'];
                        } else {
                            echo $sotbitSeoMetaBottomDesc; //вывод нижнего описания
                        };
                        ?>
                    </div>
                <? } ?>

            </div>
        </div>
    </div>
</div>
