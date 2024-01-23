<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div>
    <section class="product"
         data-id="<?= $arResult['ID'] ?>"
         data-product-quantity="<?= $arResult['PRODUCT']['QUANTITY'] ?>"
         data-available="<?= $arResult['AVAILABLE'] ?>"
    >
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="product-photos">
                        <figure>
                            <div class="product-photos__tags">
                                <? if ($arResult['PROPERTIES']['HIT']['VALUE']) { ?>
                                    <div class="product-photos__tag">Хит</div>
                                <? } ?>
                                <? if ($arResult['PROPERTIES']['NEW_PRODUCT']['VALUE']) { ?>
                                    <div class="product-photos__tag primary">Новинка</div>
                                <? } ?>

                                <? if ($arResult['PRESENT']) { ?>
                                    <span class="info">
                                        <span>
                                            <div class="product-card__tag">Подарок</div>
                                        </span>
                                        <span class="tooltip">При покупке на сумму 5 000 ₽ подарок</span>
                                    </span>
                                <? } ?>

                                <? if ($arResult['PROPERTIES']['DOUBLE_BONUS']['VALUE']) { ?>
                                    <span class="info">
                                        <span>
                                            <div class="product-card__tag bg-primary">x2</div>
                                        </span>
                                        <span class="tooltip">Двойные бонусы за покупку</span>
                                    </span>
                                <? } ?>
                            </div>

                            <a 
                                <?if ($arResult['HIDE_MODAL'] == 'Y'):?>
                                    data-hide = 'Y'
                                <?endif;?>
                                data-modal-index = "0" 
                                class="product-photos__selected-photo"
                                style="background-image: url('<?= $arResult['IMAGES'][0] ?>')">
                                <div class="product-photos__expander"></div>
                            </a>
                        </figure>

                        <div class="photos-slider">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <? foreach ($arResult['IMAGES'] as $imageIndex => $image) { ?>
                                        <a 
                                            <?if ($arResult['HIDE_MODAL'] != 'Y'):?>
                                                data-fslightbox="lightbox-basic" 
                                                href="<?= $image ?>"
                                                data-modal-index="<?=$imageIndex?>" 
                                            <?endif;?>
                                            class="
                                                detail-card-open-modal-mobile 
                                                photos-slider__item swiper-slide
                                                detail-card-open-modal-mobile-<?=$imageIndex?>"
                                            style="background-image: url('<?= $image ?>')">
                                        </a>
                                    <? } ?>
                                </div>
                            </div>
                            <div class="photos-slider__next">
                                <div class="photos-slider__next-button"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row align-items-center mb-3 mb-sm-2">
                        <div class="col-8">
                            <p class="product__article">
                                Артикул: <?= $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'] ?>
                            </p>
                        </div>
                        <div class="col-4">
                            <div class="product__share">
                                <div class="product__share-modal">
                                    <a class="product__share-btn share-network-whatsapp" data-sharer="Whatsapp" data-url="<?='https://'.$_SERVER['HTTP_HOST'].$APPLICATION->GetCurPage()?>" data-title="<?= $arResult['NAME'] ?>">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/whatsapp-circle.svg"
                                             alt="Whatsapp"/>
                                        <span>Whatsapp</span>
                                    </a>
                                    <a class="product__share-btn share-network-vk sharer" data-sharer="vk" data-url="<?='https://'.$_SERVER['HTTP_HOST'].$APPLICATION->GetCurPage()?>" data-title="<?= $arResult['NAME'] ?>">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/vk-circle.svg"
                                             alt="Вконтакте"/>
                                        <span>Вконтакте</span>
                                    </a>
                                    <a class="product__share-btn share-network-telegram sharer" data-sharer="telegram" data-url="<?='https://'.$_SERVER['HTTP_HOST'].$APPLICATION->GetCurPage()?>" data-title="<?= $arResult['NAME'] ?>">
                                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/telegram-circle.svg"
                                             alt="Telegram"/>
                                        <span>Telegram</span>
                                    </a>
                                </div>
                                <button class="product__share-toggle">
                                    <svg width="16" height="17" viewBox="0 0 12 13" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.375 8.5C8.92969 8.5 8.51875 8.65625 8.19687 8.91719L4.95937 6.575C5.01359 6.27745 5.01359 5.97255 4.95937 5.675L8.19687 3.33281C8.51875 3.59375 8.92969 3.75 9.375 3.75C10.4094 3.75 11.25 2.90937 11.25 1.875C11.25 0.840625 10.4094 0 9.375 0C8.34062 0 7.5 0.840625 7.5 1.875C7.5 2.05625 7.525 2.22969 7.57344 2.39531L4.49844 4.62187C4.04219 4.01719 3.31719 3.625 2.5 3.625C1.11875 3.625 0 4.74375 0 6.125C0 7.50625 1.11875 8.625 2.5 8.625C3.31719 8.625 4.04219 8.23281 4.49844 7.62813L7.57344 9.85469C7.525 10.0203 7.5 10.1953 7.5 10.375C7.5 11.4094 8.34062 12.25 9.375 12.25C10.4094 12.25 11.25 11.4094 11.25 10.375C11.25 9.34062 10.4094 8.5 9.375 8.5ZM9.375 1.0625C9.82344 1.0625 10.1875 1.42656 10.1875 1.875C10.1875 2.32344 9.82344 2.6875 9.375 2.6875C8.92656 2.6875 8.5625 2.32344 8.5625 1.875C8.5625 1.42656 8.92656 1.0625 9.375 1.0625ZM2.5 7.5C1.74219 7.5 1.125 6.88281 1.125 6.125C1.125 5.36719 1.74219 4.75 2.5 4.75C3.25781 4.75 3.875 5.36719 3.875 6.125C3.875 6.88281 3.25781 7.5 2.5 7.5ZM9.375 11.1875C8.92656 11.1875 8.5625 10.8234 8.5625 10.375C8.5625 9.92656 8.92656 9.5625 9.375 9.5625C9.82344 9.5625 10.1875 9.92656 10.1875 10.375C10.1875 10.8234 9.82344 11.1875 9.375 11.1875Z"
                                              fill="#ffffff"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <h1 class="product__title">
                        <?= $arResult['NAME'] ?>
                    </h1>

                    <div class="stars placeholder-glow">
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                        <div class="placeholder"></div>
                    </div>

                    <? if ($arResult['AVAILABLE']) { ?>
                        <div class="price">
                            <span class="price__current"><?= $arResult['PRICES_LIST']['PRICE'] ?> ₽</span>
                            <? if ($arResult['PRICES_LIST']['OLD_PRICE']) { ?>
                                <span class="price__old"><?= $arResult['PRICES_LIST']['OLD_PRICE'] ?> ₽</span>
                            <? } ?>
                            <? if ($arResult['PRICES_LIST']['DISCOUNT']) { ?>
                                <span class="price__discount">-<?= $arResult['PRICES_LIST']['DISCOUNT'] ?>%</span>
                            <? } ?>
                        </div>
                    <? } ?>

                    <div class="product__availability">
                        <? if ($arResult['AVAILABLE']) { ?>
                            <span class="product__availability-in-stock">
                                В наличии
                            </span>
                            <a href="" data-available-index="1" class="available-window-open available-window-open-1">Посмотреть наличие</a>
                        <? } else { ?>
                            <span class="me-2">Нет в наличии</span>
                        <? } ?>
                    </div>

                    <? $APPLICATION->IncludeComponent(
                        "logictim:bonus.catalog",
                        "element",
                        Array(
                            "COMPONENT_TEMPLATE" => "element",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                            "ITEMS" => array("ITEMS"=>$arResult)
                        )
                    );?>
                    <div class="product__bonus" id="lb_ajax_<?=$arResult["ID"]?>"></div>

                    <? if (!empty($arResult['OFFERS'])) { ?>
                        <div class="select__wrapper product__trade-offers placeholder-glow">
                            <div class="placeholder"></div>
                            <div class="select" data-placeholder="Выберите размер:">
                                <button class="select__main btn">
                                    Выберите размер:
                                    <div class="select__options">
                                        <? foreach ($arResult['OFFERS'] as $offer) { ?>
                                            <div class="select__option"
                                                 tabindex="0"
                                                 data-id="<?= $offer['ID'] ?>"
                                                 data-quantity="<?= $offer['PRODUCT']['QUANTITY'] ?>"
                                            >
                                                <span><?= $offer['PROPERTIES']['CML2_ATTRIBUTES']['VALUE'][0] ?? $offer['NAME'] ?></span>
                                            </div>
                                        <? } ?>
                                    </div>
                                </button>
                            </div>
                        </div>
                    <? } ?>

                    <? if (!isset($arResult['RESTRICTED_SECTION']) && !CSite::InGroup([OPT_GROUP_ID]) && $arResult['AVAILABLE']) { ?>
                        <a href="javascript:void(0);" 
                            class="btn btn-primary px-5 interlabs-one-click-buy"
                            data-productid="<?=$arResult['ID']?>" 
                            data-data="<?=json_encode(["PRODUCT_ID" => $arResult['ID']])?>" 
                            id="one-click-buy-<?=$arResult['ID']?>"
                            >                        
                            <?=GetMessage("BUY_ONE_CLICK")?>
                        </a>
                    <?}?>

                    <div class="product__add<?= !$arResult['PRODUCT']['USE_OFFERS'] || !$arResult['AVAILABLE'] ? ' placeholder-glow' : '' ?>">
                        <? if (!$arResult['PRODUCT']['USE_OFFERS'] || !$arResult['AVAILABLE']) { ?>
                            <div class="placeholder"></div>
                        <? } ?>

                        <button onclick="ym(30377432,'reachGoal','product-card__fav--default')" class="product-fav btn bg-white mx-1 placeholder-glow">
                            <span class="placeholder"></span>
                            <span class="product-fav__wrapper">
                                <svg class="product-fav__active" width="20" height="18" viewBox="0 0 20 18" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3716 17.5C10.2495 17.5 10.1295 17.4689 10.023 17.4097C9.64407 17.199 0.743109 12.1754 0.743109 5.8125C0.743482 4.69774 1.09682 3.61131 1.75314 2.70696C2.40945 1.80262 3.33549 1.12614 4.40023 0.773272C5.46497 0.420399 6.61448 0.408995 7.6861 0.740674C8.75772 1.07235 9.69719 1.73032 10.3716 2.62146C11.0459 1.73032 11.9854 1.07235 13.057 0.740674C14.1286 0.408995 15.2781 0.420399 16.3429 0.773272C17.4076 1.12614 18.3337 1.80262 18.99 2.70696C19.6463 3.61131 19.9996 4.69774 20 5.8125C20 8.51878 18.4208 11.3025 15.3063 14.0864C13.8936 15.344 12.3571 16.4574 10.7201 17.4097C10.6136 17.4689 10.4936 17.5 10.3716 17.5Z"
                                      fill="currentColor"/>
                                </svg>
                                <svg class="product-fav__default" width="20" height="17" viewBox="0 0 20 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.5625 17C9.44127 17 9.32207 16.9689 9.2163 16.9097C8.84 16.699 0 11.6754 0 5.3125C0.000370456 4.19774 0.351292 3.11131 1.00311 2.20696C1.65492 1.30262 2.57463 0.626144 3.63207 0.273271C4.68951 -0.0796019 5.83115 -0.0910058 6.89543 0.240673C7.95972 0.572352 8.89275 1.23032 9.5625 2.12146C10.2322 1.23032 11.1653 0.572352 12.2296 0.240673C13.2938 -0.0910058 14.4355 -0.0796019 15.4929 0.273271C16.5504 0.626144 17.4701 1.30262 18.1219 2.20696C18.7737 3.11131 19.1246 4.19774 19.125 5.3125C19.125 8.01878 17.5566 10.8025 14.4635 13.5864C13.0604 14.844 11.5345 15.9574 9.90861 16.9097C9.80287 16.9689 9.68369 17 9.5625 17ZM5.3125 1.41667C4.27962 1.41784 3.28938 1.82867 2.55902 2.55903C1.82867 3.28938 1.41784 4.27962 1.41667 5.3125C1.41667 10.204 7.96698 14.496 9.56223 15.4682C11.1569 14.4949 17.7083 10.1967 17.7083 5.3125C17.7081 4.41208 17.396 3.53952 16.8252 2.84317C16.2543 2.14683 15.4599 1.66967 14.577 1.49281C13.6941 1.31596 12.7773 1.45033 11.9822 1.87308C11.1872 2.29583 10.5632 2.98086 10.2161 3.81172C10.1623 3.94067 10.0715 4.0508 9.95516 4.12827C9.83886 4.20573 9.70224 4.24706 9.5625 4.24706C9.42276 4.24706 9.28614 4.20573 9.16984 4.12827C9.05353 4.0508 8.96274 3.94067 8.90888 3.81172C8.61354 3.10155 8.1142 2.49493 7.47403 2.06861C6.83386 1.64228 6.08163 1.4154 5.3125 1.41667Z"
                                          fill="currentColor"/>
                                </svg>
                                <span class="product-fav__text">В избранное</span>
                            </span>
                        </button>
                        <button class="product-compare btn bg-white mx-1 placeholder-glow">
                            <span class="placeholder"></span>
                            <span class="product-compare__wrapper">
                                <svg class="product-compare__active" width="18" height="17" viewBox="0 0 18 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.85464 0.542553L5.85464 4.34043L2.03057 4.34043C1.88569 4.34043 1.74673 4.39759 1.64428 4.49934C1.54183 4.60108 1.48428 4.73909 1.48428 4.88298L1.48428 15.9149L0.573785 15.9149C0.428899 15.9149 0.289947 15.9721 0.187497 16.0738C0.0850464 16.1756 0.0274906 16.3136 0.0274906 16.4574C0.0274906 16.6013 0.0850464 16.7393 0.187497 16.8411C0.289947 16.9428 0.428899 17 0.573786 17L16.5984 17C16.7433 17 16.8823 16.9428 16.9847 16.8411C17.0872 16.7393 17.1447 16.6013 17.1447 16.4574C17.1447 16.3136 17.0872 16.1756 16.9847 16.0738C16.8823 15.9721 16.7433 15.9149 16.5984 15.9149L15.6879 15.9149L15.6879 7.7766C15.6879 7.6327 15.6304 7.4947 15.5279 7.39295C15.4255 7.2912 15.2865 7.23404 15.1417 7.23404L11.3176 7.23404L11.3176 0.542552C11.3176 0.398658 11.26 0.260659 11.1576 0.15891C11.0551 0.0571618 10.9162 -4.727e-07 10.7713 -4.6641e-07L6.40093 -2.76684e-07C6.25604 -2.70394e-07 6.11709 0.057162 6.01464 0.15891C5.91219 0.260659 5.85464 0.398659 5.85464 0.542553Z"
                                      fill="currentColor"/>
                                </svg>
                                <svg class="product-compare__default" width="17" height="17" viewBox="0 0 17 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.78723 0.542553L5.78723 4.34043L1.98936 4.34043C1.84547 4.34043 1.70747 4.39759 1.60572 4.49934C1.50397 4.60108 1.44681 4.73909 1.44681 4.88298L1.44681 15.9149L0.542553 15.9149C0.398659 15.9149 0.260658 15.9721 0.15891 16.0738C0.0571616 16.1756 -3.00056e-08 16.3136 -2.37158e-08 16.4574C-1.74259e-08 16.6013 0.0571616 16.7393 0.15891 16.8411C0.260659 16.9428 0.398659 17 0.542553 17L16.4574 17C16.6013 17 16.7393 16.9428 16.8411 16.8411C16.9428 16.7393 17 16.6013 17 16.4574C17 16.3136 16.9428 16.1756 16.8411 16.0738C16.7393 15.9721 16.6013 15.9149 16.4574 15.9149L15.5532 15.9149L15.5532 7.7766C15.5532 7.6327 15.496 7.4947 15.3943 7.39295C15.2925 7.2912 15.1545 7.23404 15.0106 7.23404L11.2128 7.23404L11.2128 0.542552C11.2128 0.398658 11.1556 0.260658 11.0539 0.15891C10.9521 0.0571628 10.8141 -4.727e-07 10.6702 -4.6641e-07L6.32979 -2.76684e-07C6.18589 -2.70394e-07 6.04789 0.057163 5.94614 0.15891C5.84439 0.260658 5.78723 0.398658 5.78723 0.542553ZM2.53191 5.42553L5.78723 5.42553L5.78723 15.9149L2.53191 15.9149L2.53191 5.42553ZM14.4681 8.31915L14.4681 15.9149L11.2128 15.9149L11.2128 8.31915L14.4681 8.31915ZM10.1277 1.08511L10.1277 15.9149L6.87234 15.9149L6.87234 1.08511L10.1277 1.08511Z"
                                          fill="currentColor"/>
                                </svg>
                                <span class="product-compare__text">В сравнение</span>
                            </span>
                        </button>
                    </div>
                    <hr/>
                    <div class="product__delivery mb-3">
                        <?/*<div class="product__delivery-option">
                            <div class="product__delivery-icon">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/delivery.svg" alt="Доставка"/>
                            </div>
                            Доставка по Москве: <span class="text-dark">с 11.03</span><br/>
                            <a href="#">Узнать стоимость</a>
                        </div>*/?>
                        <div class="product__delivery-option">
                            <div class="product__delivery-icon">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/location.svg" alt="Местоположение"/>
                            </div>
                            Доступно к самовывозу:
                            <span class="text-dark">бесплатно</span><br/>
                            <a class="available-window-open available-window-open-2" data-available-index="2" href="">
                                <?=$arResult['COUNT_DISPLAY_STORES_ELEMENT']?>
                            </a>
                        </div> 
                    </div>                    
                    <?if (isset($arResult['RESTRICTED_SECTION'])) {?>
                        <div class="product__restiction mb-3">
                            <?=GetMessage("RESTRICTION_TEXT")?>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>

        <? $APPLICATION->IncludeFile($templateFolder . '/partials/tabs.php', [
            'templateFolder' => $templateFolder,
            'result' => $arResult,
            'component' => $component
        ], ['SHOW_BORDER' => false]); ?>

    </section>

    <? $APPLICATION->IncludeFile($templateFolder . '/partials/videoReviews.php', [
        'templateFolder' => $templateFolder,
        'result' => $arResult,
        'component' => $component
    ], ['SHOW_BORDER' => false]); ?>

    <? $APPLICATION->IncludeFile($templateFolder . '/partials/recommendedProducts.php', [
        'templateFolder' => $templateFolder,
        'result' => $arResult,
        'params' => $arParams,
        'component' => $component
    ], ['SHOW_BORDER' => false]); ?>
</div>

<? $APPLICATION->IncludeFile($templateFolder . '/partials/availableWindow.php', [
        'templateFolder' => $templateFolder,
        'result' => $arResult,
        'params' => $arParams,
        'component' => $component
    ], ['SHOW_BORDER' => false]); ?>