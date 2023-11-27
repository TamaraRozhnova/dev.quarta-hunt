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
                        </h6>
                    </div>

                    <div class="filters-section__body">
                        <? foreach ($arResult['FILTERS']['CHARACTERISTICS'] as $filter) { ?>
                            <div>
                                <div class="filters-section filters-section--compact">
                                    <div class="filters-section__header">
                                        <h6>
                                            <?= $filter['TITLE'] ?>
                                        </h6>
                                    </div>
                                    <div class="filters-section__body">
                                        <? foreach ($filter['CHILDREN'] as $child) { ?>
                                            <div>
                                                <div 
                                                    class="filters-item
                                                    <?=
                                                        $child['ELEMENT_COUNT'] == 0
                                                        ? 'filter-disabled'
                                                        : null
                                                    ?>">
                                                    <div class="checkbox form-check">
                                                        <input id="<?= $child['CONTROL_NAME'] ?>" type="checkbox"
                                                               class="form-check-input" <?= intval($child['CHECKED']) > 0 ? 'checked' : '' ?>>
                                                        <label for="<?= $child['CONTROL_NAME'] ?>"
                                                               class="form-check-label">
                                                               <span>
                                                                    <?= $child['VALUE'] ?>
                                                                    <? if ($child['ELEMENT_COUNT'] != 0): ?>
                                                                        (<?=$child['ELEMENT_COUNT']?>)
                                                                    <? endif;?>
                                                                </span>
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
                        </h6>
                    </div>

                    <div class="filters-section__body">
                        <? foreach ($arResult['FILTERS']['BRANDS']['CHILDREN'] as $child) { ?>
                            <div>
                                <div 
                                    class="filters-item
                                    <?=
                                        $child['ELEMENT_COUNT'] == 0
                                        ? 'filter-disabled'
                                        : null
                                    ?>"
                                >
                                    <div class="checkbox form-check">
                                        <input id="<?= $child['CONTROL_NAME'] ?>" type="checkbox" <?= intval($child['CHECKED']) > 0 ? 'checked' : '' ?> class="form-check-input">
                                        <label for="<?= $child['CONTROL_NAME'] ?>" class="form-check-label">
                                            <span>
                                                <?= $child['VALUE'] ?>
                                                <? if ($child['ELEMENT_COUNT'] != 0): ?>
                                                    (<?=$child['ELEMENT_COUNT']?>)
                                                <? endif;?>
                                            </span>
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
                                            <label for="min-price" class="form-label">мин.</label>
                                            <span class="input__container">
                                                <input id="min-price" placeholder="0" type="number" class="form-control" min="0">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input">
                                            <label for="max-price" class="form-label">макс.</label>
                                            <span class="input__container">
                                                <input id="max-price" placeholder="100000" type="number" class="form-control">
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

        <div class="filters-section-btns">
            <div class="filters-section-btn-apply">
                <button type="button" class="btn btn-primary filters__btn-apply">
                    Применить
                </button>
            </div>
        </div>

        <div class="filters__accept-wrap">
            <button type="button" class="filters__accept-btn">
                Применить
            </button>
        </div>

    </form>
</div>

<div class="filters__accept-on-item-wrapper">
    <button type="button" class="filters__accept-on-item">
        Применить
    </button>
</div>
