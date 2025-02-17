<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/** @var $arParams */
/** @var $arResult */

global $APPLICATION;

$this->setFrameMode(false);
Loc::loadMessages(__FILE__); ?>
<div class="basket-block">
    <div class="container">
        <div class="top-basket-block">
            <h1><?= $APPLICATION->GetTitle() ?></h1>
            <?php if ($arResult['COUNT_PRODUCTS'] > 0) : ?>
                <a href="javascript:void(0)" class="btn basket__btn-clear">
                    <?= Loc::getMessage('CLEAR_BTN_TEXT') ?>
                </a>
            <?php endif; ?>
        </div>
        <?php if ($arResult['COUNT_PRODUCTS'] > 0) :
            $num = 0;
            foreach ($arResult['ITEMS'] as $key => $items) : ?>
                <div class="basket-store-block" data-store-id="<?= $key ?>">
                    <h3><?= $arResult['STORE_TEXT'][$num] ?></h3>
                    <?php
                    $storeSum = 0;
                    $countItems = count($items);
                    $countCantBuy = 0;

                    if (is_array($items)) {
                        foreach ($items as $item) : ?>
                            <?php if (!$item['CAN_BUY']) {
                                $countCantBuy++;
                            } ?>
                            <div class="product-item-card <?= !$item['CAN_BUY'] ? 'cant-buy' : '' ?>"
                                 data-product-id="<?= $item['ID'] ?>"
                                 data-quantity="<?= $item['QUANTITY'] ?>"
                                 data-store-ids="<?= (is_array($item['STORE_ID'])) ? implode(',', $item['STORE_ID']) : $item['STORE_ID'] ?>"
                            >
                                <?php if ($item['PICTURE']) : ?>
                                    <a href="<?= $item['LINK'] ?>" class="product-image-block">
                                        <img src="<?= $item['PICTURE'] ?>" alt="<?= $item['NAME'] ?>">
                                    </a>
                                <?php endif; ?>
                                <div class="info-product-block">
                                    <?php if ($item['ARTICLE']) : ?>
                                        <span class="product-article-text"><?= Loc::getMessage('ARTICLE_TEXT') . ' ' . $item['ARTICLE'] ?></span>
                                    <?php endif; ?>
                                    <a href="<?= $item['LINK'] ?>" class="product-name"><?= $item['NAME'] ?></a>
                                </div>
                                <div class="product-price-block">
                                    <span class="product-price"><?= number_format((int)$item['PRICE']['DISCOUNT_PRICE'], 0, '.', ' ') . ' ₽' ?></span>
                                </div>
                                <div class="product-quantity-block">
                                    <div class="basket-item-block-amount">
                                        <span class="basket-item-amount-btn-minus <?= $item['QUANTITY'] == 1 ? 'disabled' : '' ?>"></span>
                                        <div class="basket-item-amount-filed-block">
                                            <input type="text" class="basket-item-amount-filed" <?= ($item['AMOUNT'] == 0) ? 'disabled' : '' ?> data-max-quantity="<?= $item['AMOUNT'] ?>" value="<?= $item['QUANTITY'] ?>">
                                        </div>
                                        <span class="basket-item-amount-btn-plus <?= $item['QUANTITY'] == $item['AMOUNT'] ? 'disabled' : '' ?>"></span>
                                    </div>
                                </div>
                                <div class="product-sum-block">
                                    <span class="product-sum"><?= number_format((int)$item['SUM'], 0, '.', ' ') . ' ₽' ?></span>
                                    <?php $storeSum += (int)$item['SUM']; ?>
                                </div>
                                <div class="delete-product-icon"></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="bottom-store-block">
                            <div class="total-store-text">
                                <?= Loc::getMessage('TOTAL_STORE_TEXT') . ' ' . number_format($storeSum, 0, '.', ' ') . ' ₽' ?>
                            </div>
                            <div class="store-total-button-block">
                                <button <?= ($countItems == $countCantBuy) ? 'disabled' : '' ?> class="btn btn-lg btn-primary basket-btn-checkout">
                                    <?= Loc::getMessage('BASKET_CHECKOUT_BTN') ?>
                                </button>
                            </div>
                        </div>
                        <?php $num++; ?>
                    <?php } ?>
                </div>
            <?php endforeach;
        else : ?>
            <div class="bx-sbb-empty-cart-container">
                <div class="bx-sbb-empty-cart-image">
                    <img src="" alt="">
                </div>
                <div class="bx-sbb-empty-cart-text"><?= Loc::getMessage('BASKET_EMPTY_TITLE') ?></div>
                <div class="bx-sbb-empty-cart-desc">
                    <?= Loc::getMessage('BASKET_EMPTY_TEXT') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>