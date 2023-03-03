<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!isset($arResult['ITEM'])) {
    return;
}

$item = $arResult['ITEM'];

?>

<div class="product-card"
     data-id="<?= $item['ID'] ?>"
     data-product-quantity="<?= $item['PRODUCT']['QUANTITY'] ?>"
     data-offers-quantity="<?= $item['OFFERS_QUANTITY'] ?>"
     data-product-basket="<?= $item['QUANTITY_IN_BASKET'] ?>"
>
    <div class="product-card__image">

        <? if ($arResult['PARAMS']['SHOW_PRODUCT_TAGS'] === 'Y') { ?>
            <div class="product-card__tags">
                <? if ($item['PROPERTIES']['HIT']['VALUE']) { ?>
                    <div class="product-card__tag">Хит</div>
                <? } ?>
                <? if ($item['PROPERTIES']['NEW_PRODUCT']['VALUE']) { ?>
                    <div class="product-card__tag bg-primary">Новинка</div>
                <? } ?>
                <? if ($item['PRESENT']) { ?>
                    <span class="info">
                        <span>
                            <div class="product-card__tag">Подарок</div>
                        </span>
                        <span class="tooltip">При покупке на сумму 5 000 ₽ подарок</span>
                    </span>
                <? } ?>
                <? if ($item['PROPERTIES']['DOUBLE_BONUS']['VALUE']) { ?>
                    <span class="info">
                        <span>
                            <div class="product-card__tag bg-primary">x2</div>
                        </span>
                        <span class="tooltip">Двойные бонусы за покупку</span>
                    </span>
                <? } ?>
            </div>
        <? } ?>

        <div class="product-card__image-actions">
            <svg class="product-card__compare product-card__compare--active text-secondary" style="display: <?= $item['IN_COMPARE'] ? 'inline' : 'none' ?>" width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.85464 0.542553L5.85464 4.34043L2.03057 4.34043C1.88569 4.34043 1.74673 4.39759 1.64428 4.49934C1.54183 4.60108 1.48428 4.73909 1.48428 4.88298L1.48428 15.9149L0.573785 15.9149C0.428899 15.9149 0.289947 15.9721 0.187497 16.0738C0.0850464 16.1756 0.0274906 16.3136 0.0274906 16.4574C0.0274906 16.6013 0.0850464 16.7393 0.187497 16.8411C0.289947 16.9428 0.428899 17 0.573786 17L16.5984 17C16.7433 17 16.8823 16.9428 16.9847 16.8411C17.0872 16.7393 17.1447 16.6013 17.1447 16.4574C17.1447 16.3136 17.0872 16.1756 16.9847 16.0738C16.8823 15.9721 16.7433 15.9149 16.5984 15.9149L15.6879 15.9149L15.6879 7.7766C15.6879 7.6327 15.6304 7.4947 15.5279 7.39295C15.4255 7.2912 15.2865 7.23404 15.1417 7.23404L11.3176 7.23404L11.3176 0.542552C11.3176 0.398658 11.26 0.260659 11.1576 0.15891C11.0551 0.0571618 10.9162 -4.727e-07 10.7713 -4.6641e-07L6.40093 -2.76684e-07C6.25604 -2.70394e-07 6.11709 0.057162 6.01464 0.15891C5.91219 0.260659 5.85464 0.398659 5.85464 0.542553Z" fill="currentColor"/>
            </svg>

            <svg class="product-card__compare product-card__compare--default" style="display: <?= $item['IN_COMPARE'] ? 'none' : 'inline' ?>" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.78723 0.542553L5.78723 4.34043L1.98936 4.34043C1.84547 4.34043 1.70747 4.39759 1.60572 4.49934C1.50397 4.60108 1.44681 4.73909 1.44681 4.88298L1.44681 15.9149L0.542553 15.9149C0.398659 15.9149 0.260658 15.9721 0.15891 16.0738C0.0571616 16.1756 -3.00056e-08 16.3136 -2.37158e-08 16.4574C-1.74259e-08 16.6013 0.0571616 16.7393 0.15891 16.8411C0.260659 16.9428 0.398659 17 0.542553 17L16.4574 17C16.6013 17 16.7393 16.9428 16.8411 16.8411C16.9428 16.7393 17 16.6013 17 16.4574C17 16.3136 16.9428 16.1756 16.8411 16.0738C16.7393 15.9721 16.6013 15.9149 16.4574 15.9149L15.5532 15.9149L15.5532 7.7766C15.5532 7.6327 15.496 7.4947 15.3943 7.39295C15.2925 7.2912 15.1545 7.23404 15.0106 7.23404L11.2128 7.23404L11.2128 0.542552C11.2128 0.398658 11.1556 0.260658 11.0539 0.15891C10.9521 0.0571628 10.8141 -4.727e-07 10.6702 -4.6641e-07L6.32979 -2.76684e-07C6.18589 -2.70394e-07 6.04789 0.057163 5.94614 0.15891C5.84439 0.260658 5.78723 0.398658 5.78723 0.542553ZM2.53191 5.42553L5.78723 5.42553L5.78723 15.9149L2.53191 15.9149L2.53191 5.42553ZM14.4681 8.31915L14.4681 15.9149L11.2128 15.9149L11.2128 8.31915L14.4681 8.31915ZM10.1277 1.08511L10.1277 15.9149L6.87234 15.9149L6.87234 1.08511L10.1277 1.08511Z" fill="currentColor"/>
            </svg>

            <svg class="product-card__fav product-card__fav--active text-secondary" style="display: <?= $item['IN_FAVORITES'] ? 'inline' : 'none' ?>" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.3716 17.5C10.2495 17.5 10.1295 17.4689 10.023 17.4097C9.64407 17.199 0.743109 12.1754 0.743109 5.8125C0.743482 4.69774 1.09682 3.61131 1.75314 2.70696C2.40945 1.80262 3.33549 1.12614 4.40023 0.773272C5.46497 0.420399 6.61448 0.408995 7.6861 0.740674C8.75772 1.07235 9.69719 1.73032 10.3716 2.62146C11.0459 1.73032 11.9854 1.07235 13.057 0.740674C14.1286 0.408995 15.2781 0.420399 16.3429 0.773272C17.4076 1.12614 18.3337 1.80262 18.99 2.70696C19.6463 3.61131 19.9996 4.69774 20 5.8125C20 8.51878 18.4208 11.3025 15.3063 14.0864C13.8936 15.344 12.3571 16.4574 10.7201 17.4097C10.6136 17.4689 10.4936 17.5 10.3716 17.5Z" fill="currentColor"/>
            </svg>

            <svg class="product-card__fav product-card__fav--default" style="display: <?= $item['IN_FAVORITES'] ? 'none' : 'inline' ?>" width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.5625 17C9.44127 17 9.32207 16.9689 9.2163 16.9097C8.84 16.699 0 11.6754 0 5.3125C0.000370456 4.19774 0.351292 3.11131 1.00311 2.20696C1.65492 1.30262 2.57463 0.626144 3.63207 0.273271C4.68951 -0.0796019 5.83115 -0.0910058 6.89543 0.240673C7.95972 0.572352 8.89275 1.23032 9.5625 2.12146C10.2322 1.23032 11.1653 0.572352 12.2296 0.240673C13.2938 -0.0910058 14.4355 -0.0796019 15.4929 0.273271C16.5504 0.626144 17.4701 1.30262 18.1219 2.20696C18.7737 3.11131 19.1246 4.19774 19.125 5.3125C19.125 8.01878 17.5566 10.8025 14.4635 13.5864C13.0604 14.844 11.5345 15.9574 9.90861 16.9097C9.80287 16.9689 9.68369 17 9.5625 17ZM5.3125 1.41667C4.27962 1.41784 3.28938 1.82867 2.55902 2.55903C1.82867 3.28938 1.41784 4.27962 1.41667 5.3125C1.41667 10.204 7.96698 14.496 9.56223 15.4682C11.1569 14.4949 17.7083 10.1967 17.7083 5.3125C17.7081 4.41208 17.396 3.53952 16.8252 2.84317C16.2543 2.14683 15.4599 1.66967 14.577 1.49281C13.6941 1.31596 12.7773 1.45033 11.9822 1.87308C11.1872 2.29583 10.5632 2.98086 10.2161 3.81172C10.1623 3.94067 10.0715 4.0508 9.95516 4.12827C9.83886 4.20573 9.70224 4.24706 9.5625 4.24706C9.42276 4.24706 9.28614 4.20573 9.16984 4.12827C9.05353 4.0508 8.96274 3.94067 8.90888 3.81172C8.61354 3.10155 8.1142 2.49493 7.47403 2.06861C6.83386 1.64228 6.08163 1.4154 5.3125 1.41667Z" fill="currentColor"/>
            </svg>
        </div>

        <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
            <figure>
                <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $item['NAME'] ?>"/>
            </figure>
        </a>
    </div>

    <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
        <div class="product-card__article">Артикул: <?= $item['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?></div>
        <div class="product-card__title"><?= $item['NAME'] ?></div>
    </a>

    <? if ($item['AVAILABLE']) { ?>
        <div class="price price--small">
            <span class="price__current"><?= $item['PRICES']['PRICE'] ?> ₽</span>
            <? if ($item['PRICES']['OLD_PRICE']) { ?>
                <span class="price__old"><?= $item['PRICES']['OLD_PRICE'] ?> ₽</span>
            <? } ?>
            <? if ($item['PRICES']['DISCOUNT']) { ?>
                <span class="price__discount">-<?= $item['PRICES']['DISCOUNT'] ?>%</span>
            <? } ?>
        </div>
    <? } else { ?>
        <div class="fs-6 text-dark pb-1"><b>Нет в наличии</b></div>
    <? } ?>

    <div class="stars">

       <? for ($i = 0; $i < $arResult['RATING']['FILL_STARS']; $i++) { ?>
            <div class="star star--small">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            </div>
       <? } ?>


        <? if ($arResult['RATING']['HALF_STAR']) { ?>
            <div class="star star--small">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                    <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                </svg>
            </div>
        <? } ?>

        <? for ($i = 0; $i < $arResult['RATING']['OUTLINE_STARS']; $i++) { ?>
            <div class="star star--small">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                    <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                </svg>
            </div>
        <? } ?>

    </div>

    <? if ($item['AVAILABLE']) { ?>
        <div class="product-card__add product-card__add--main">
            <? if ($arResult['ITEM']['QUANTITY_IN_BASKET'] > 0) { ?>
                <span class="input-group product__add-count">
                    <span class="btn btn-primary product__add-minus">-</span>
                    <input type="number" class="form-control" value="<?= $arResult['ITEM']['QUANTITY_IN_BASKET'] ?>" />
                    <span class="btn btn-primary product__add-plus">+</span>
                </span>
            <? } else { ?>
                <button class="btn btn-primary product-card__button product-card__add-basket">
                    В корзину
                </button>
            <? } ?>
        </div>
    <? } else { ?>
        <div class="product-card__add">
            <button class="btn btn-outline-primary product-card__availability">
                Cообщить о поступлении
            </button>
        </div>
    <? } ?>
</div>

