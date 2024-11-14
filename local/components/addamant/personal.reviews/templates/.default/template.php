<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Grid\Declension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var string $componentPath
 */
//debug($arResult);
?>
<div class="personal-reviews">
    <? if (empty($arResult['PROD_IDS'])) { ?>
        <div class="personal-reviews__empty">
            <img src="<?= $templateFolder ?>/img/no-reviews.svg" alt="">
            <div class="personal-reviews__no-reviews"><?= Loc::getMessage('NO_REVIEWS') ?></div>
            <div class="personal-reviews__no-reviews-text"><?= Loc::getMessage('NO_REVIEWS_TEXT') ?></div>
        </div>
    <? } else { ?>
        <div class="personal-reviews__list">
            <? foreach ($arResult['PRODUCTS'] as $prod) { ?>
                <div class="personal-reviews__item">
                    <a class="item__left" href="<?= $prod['DETAIL_PAGE_URL'] ?>">
                        <div class="item__img <?= $prod['IS_FULL'] == 'Y' ? 'full' : '' ?>">
                            <img width="175" height="200" src="<?= $prod['IMG'] ?>" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__price"><?= CurrencyFormat($prod['PRICE'], 'RUB') ?></div>
                            <div class="item__name"><?= $prod['NAME'] ?></div>
                            <? if ($prod['PROPS']['COLOR']) { ?>
                                <div class="item__prop">Цвет: <img width="20" height="20" src="<?= $prod['PROPS']['COLOR_FILE'] ?>" alt=""> <span><?= $prod['PROPS']['COLOR'] ?></span></div>
                            <? } ?>
                            <? if ($prod['PROPS']['SIZE']) { ?>
                                <div class="item__prop">Размер: <span><?= $prod['PROPS']['SIZE'] ?></span></div>
                            <? } ?>
                        </div>
                    </a>
                    <div class="item__right">
                        <div class="item__rating">
                            <?php
                            $APPLICATION->IncludeComponent(
                                'addamant:product.rating',
                                'personal',
                                [
                                    'IBLOCK_ID' => $arParams['CATALOG_ID'],
                                    'ELEMENT_ID' => $prod['PRODUCT_ID'],
                                    'USER_ID' => $arResult['USER_ID'],
                                ],
                                $component,
                            );
                            ?>
                        </div>
                        <div class="item__comments">
                            <?php
                            $APPLICATION->IncludeComponent(
                                'addamant:product.comments',
                                'personal',
                                [
                                    'BLOG_URL' => 'reviews',
                                    'IBLOCK_ID' => $arParams['CATALOG_ID'],
                                    'ELEMENT_ID' => $prod['PRODUCT_ID'],
                                    'BLOG_GROUP_ID' => 1,
                                    'ELEMENT_COUNT' => $arParams['COMMENTS_COUNT'],
                                    'USER_ID' => $arResult['USER_ID'],
                                ],
                                $component,
                            );
                            ?>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
    <? } ?>
</div>