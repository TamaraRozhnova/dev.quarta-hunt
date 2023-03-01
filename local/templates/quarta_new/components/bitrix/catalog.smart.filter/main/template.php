<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div class="category__filter-wrap">
    <form class="filters category__filter">
        <section class="filters__header">
            <h6>Фильтры</h6>
            <div class="filters__clear">Сбросить</div>
        </section>

        <span class="filters__wr">

            <? if ($arResult['FILTERS']['CHARACTERISTICS']) { ?>
                <div class="filters-section">
                    <div class="filters-section__header">
                        <h6>
                            Характеристики
                            <div class="filters-section__header-bage"></div>
                        </h6>
                    </div>

                    <div class="filters-section__body">
                        <? foreach ($arResult['FILTERS']['CHARACTERISTICS'] as $filter) { ?>
                            <div>
                                <div class="filters-section filters-section--compact">
                                    <div class="filters-section__header">
                                        <h6>
                                            <?= $filter['TITLE'] ?>
                                            <div class="filters-section__header-bage"></div>
                                        </h6>
                                    </div>
                                    <div class="filters-section__body">
                                        <? foreach ($filter['CHILDREN'] as $child) { ?>
                                            <div>
                                                <div class="filters-item">
                                                    <div class="checkbox form-check">
                                                        <input id="<?= $child['CONTROL_NAME'] ?>" type="checkbox"
                                                               class="form-check-input" <?= isset($child['CHECKED']) ? 'checked' : '' ?>>
                                                        <label for="<?= $child['CONTROL_NAME'] ?>"
                                                               class="form-check-label">
                                                            <span><?= $child['VALUE'] ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            <? } ?>

            <? if ($arResult['FILTERS']['BRANDS']) { ?>
                <div class="filters-section">
                    <div class="filters-section__header">
                        <h6>
                            <?= $arResult['FILTERS']['BRANDS']['TITLE'] ?>
                            <div class="filters-section__header-bage"></div>
                        </h6>
                    </div>

                    <div class="filters-section__body">
                        <? foreach ($arResult['FILTERS']['BRANDS']['CHILDREN'] as $child) { ?>
                            <div>
                                <div class="filters-item">
                                    <div class="checkbox form-check">
                                        <input id="<?= $child['CONTROL_NAME'] ?>" type="checkbox" <?= isset($child['CHECKED']) ? 'checked' : '' ?> class="form-check-input">
                                        <label for="<?= $child['CONTROL_NAME'] ?>" class="form-check-label">
                                            <span><?= $child['VALUE'] ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            <? } ?>

            <div class="filters-section">
                <div class="filters-section__header">
                    <h6>Цена</h6>
                </div>
                <div class="filters-section__body">
                    <div>
                        <div class="filters-item">
                            <div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input">
                                            <label for="i_44" class="form-label">мин.</label>
                                            <span class="input__container">
                                                <input id="i_44" placeholder="0" type="number" class="form-control">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input">
                                            <label for="i_45" class="form-label">макс.</label>
                                            <span class="input__container">
                                                <input id="i_45" placeholder="100000" type="number" class="form-control">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </span>

        <div class="filters__accept-wrap">
            <button class="filters__accept-btn">
                Применить
            </button>
        </div>
    </form>
</div>
