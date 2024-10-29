<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!isset($arResult['ITEM'])) {
    return;
}

$item = &$arResult['ITEM'];

if (!empty($item['PREVIEW_PICTURE']) && is_array($item['PREVIEW_PICTURE'])) {
    if (count($item['PREVIEW_PICTURE']) > 1) {
        $item['IMG_SRC'] = CFile::ResizeImageGet(
            $item['PREVIEW_PICTURE'],
            ['width' => 220, 'height' => 250],
            BX_RESIZE_IMAGE_PROPORTIONAL
        )['src'];
    } else {
        $item['IMG_SRC'] = $item['PREVIEW_PICTURE']['SRC'];
    }
} else {
    $item['IMG_SRC'] = '/upload/cards/photo-not-found.jpg';
}

global $isMobile;
?>

<div class="col-12">
    <div class="product-card product-card-search <?=$isMobile ? 'mobile' : ''?>"
        itemscope
        itemprop="itemListElement" itemtype="http://schema.org/Product"
        data-id="<?= $item['ID'] ?>"
        data-product-quantity="<?= $item['PRODUCT']['QUANTITY'] ?>"
        data-offers-quantity="<?= $item['OFFERS_QUANTITY'] ?>"
        data-available="<?= $item['AVAILABLE'] ?>">
        <div class="product-card-search__image">

            <? if ($arResult['PARAMS']['SHOW_PRODUCT_TAGS_IN_SECTIONS'] === 'Y') { ?>
                <div
                    class="product-card-search__tags <?= $item['SHOW_BTN_LIST_LABELS'] ? 'show-btn-list-labels' : null ?>">
                    <? if ($item['SHOW_CREDIT'] == 'Y') { ?>
                        <div class="product-card-search__tag">Рассрочка до 12 мес.</div>
                    <? } ?>
                    <? if ($item['PROPERTIES']['HIT']['VALUE']) { ?>
                        <div class="product-card-search__tag">Хит</div>
                    <? } ?>
                    <? if ($item['PROPERTIES']['NEW_PRODUCT']['VALUE']) { ?>
                        <div class="product-card-search__tag bg-primary">Новинка</div>
                    <? } ?>
                    <? if ($item['PRESENT']) { ?>
                        <span class="info">
                            <span>
                                <div class="product-card-search__tag">Подарок</div>
                            </span>
                            <span class="tooltip">При покупке на сумму 5 000 ₽ подарок</span>
                        </span>
                    <? } ?>
                    <? if ($item['PROPERTIES']['DOUBLE_BONUS']['VALUE']) { ?>
                        <span class="info">
                            <span>
                                <div class="product-card-search__tag bg-primary">x2</div>
                            </span>
                            <span class="tooltip">Двойные бонусы за покупку</span>
                        </span>
                    <? } ?>
                    <? if ($item['SHOW_BTN_LIST_LABELS']) { ?>
                        <span class="product-btn-list-labels">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="Layer_1" viewBox="0 0 512.005 512.005" xml:space="preserve">
                                <g>
                                    <g>
                                        <path d="M388.418,240.923L153.751,6.256c-8.341-8.341-21.824-8.341-30.165,0s-8.341,21.824,0,30.165L343.17,256.005    L123.586,475.589c-8.341,8.341-8.341,21.824,0,30.165c4.16,4.16,9.621,6.251,15.083,6.251c5.461,0,10.923-2.091,15.083-6.251    l234.667-234.667C396.759,262.747,396.759,249.264,388.418,240.923z" />
                                    </g>
                                </g>
                            </svg>
                        </span>
                    <? } ?>
                </div>
            <? } ?>

            <a itemprop="url" href="<?= $item['DETAIL_PAGE_URL'] ?>">
                <figure>
                    <img loading="lazy" itemprop="image" src="<?= $item['IMG_SRC'] ?>" alt="<?= $item['NAME'] ?>">
                </figure>
            </a>
        </div>

        <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
            <p class="product-card-search__article" itemprop="description">Артикул: <?= $item['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?></p>
            <h2 itemprop="name" class="product-card-search__title"><?= $item['NAME'] ?></h2>

            <div class="price-block">
            <? if ($item['AVAILABLE']) { ?>
                <div class="price price--small" itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                    <span class="price__current"><?= $item['PRICES_LIST']['PRICE'] ?> ₽</span>
                    <? if ($item['PRICES_LIST']['OLD_PRICE']) { ?>
                        <span class="price__old"><?= $item['PRICES_LIST']['OLD_PRICE'] ?> ₽</span>
                    <? } ?>
                    <? if ($item['PRICES_LIST']['DISCOUNT']) { ?>
                        <span class="price__discount">-<?= $item['PRICES_LIST']['DISCOUNT'] ?>%</span>
                    <? } ?>
                    <meta itemprop="priceCurrency" content="RUB">
                    <meta itemprop="price" content="<?= str_replace([' '], '', $item['PRICES_LIST']['PRICE']) ?>">
                    <meta itemprop="availability" content="http://schema.org/InStock">
                </div>
            <? } else { ?>
                <div class="fs-6 text-dark pb-1 item-not-available" itemscope itemprop="offers" itemtype="http://schema.org/Offer">
                    <b>Закончился</b>
                    <meta itemprop="availability" content="http://schema.org/SoldOut">
                </div>
            <? } ?>
            </div>
        </a>


        <? if ($arResult['PARAMS']['HIDE_RATING'] !== 'Y') { ?>
            <div class="stars placeholder-glow">
                <div class="placeholder"></div>
                <div class="placeholder"></div>
                <div class="placeholder"></div>
                <div class="placeholder"></div>
                <div class="placeholder"></div>
            </div>
        <? } ?>

        <div class="product-card-search-buttons">
            <? if ($arResult['PARAMS']['ON_COMPARE_PAGE'] == 'Y'): ?>
                <div class=" product-card-search__add-wrapper product-card__add-wrapper">
                    <div class="product-card__add product-card-search__add placeholder-glow">
                        <div class="placeholder"></div>
                    </div>
                    <div class="product-card__remove-compare">
                        <button class="btn btn-light ms-2 product-card__remove">
                            <svg width="22" height="22" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                                <path d="M4.813 4.813l.859 13.75c.04.794.619 1.375 1.375 1.375h7.906c.76 0 1.327-.581 1.375-1.375l.86-13.75" stroke="#808d9a" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M3.438 4.813h15.124H3.438z" fill="#808d9a"></path>
                                <path d="M3.438 4.813h15.124" stroke="#808d9a" stroke-miterlimit="10" stroke-linecap="round"></path>
                                <path
                                        d="M8.25 4.813v-1.72a1.028 1.028 0 011.031-1.03h3.438a1.029 1.029 0 011.031 1.03v1.72M11 7.563v9.625M7.906 7.563l.344 9.625m5.844-9.625l-.344 9.625"
                                        stroke="#808d9a"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            <? else: ?>
                <div class="product-card__add  product-card-search__add placeholder-glow">
                    <div class="placeholder"></div>
                </div>
            <? endif; ?>

            <? if ($item['AVAILABLE'] && !isset($arResult['RESTRICTED_SECTION']) && !CSite::InGroup([OPT_GROUP_ID])) { ?>
                <a href="javascript:void(0);"
                    class="btn btn-primary interlabs-one-click-buy"
                    data-productid="<?= $item['ID'] ?>"
                    data-data='<?= json_encode(["PRODUCT_ID" => $item['ID']]) ?>'
                    id="one-click-buy-<?= $item['ID'] ?>">
                    <?= GetMessage("BUY_ONE_CLICK") ?>
                </a>
            <? } ?>
        </div>
    </div>
</div>
