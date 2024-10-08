<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
    


<div id="available-window" class="modal">
    <div class="available-window__wrapper">

        <div class="modal__close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x" viewBox="0 0 16 16">
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </div>

        <div class="modal-content">
            <div class="modal-body">
                <div class="row available-product-window" data-id="<?=$result['ID']?>">
                    <div class="col-3">
                        <div itemscope="itemscope" itemtype="https://schema.org/Product" class="product-card-available">
                            <div class="product-card__image">

                                <div class="placeholder--fav"></div>
                                <div class="placeholder--compare"></div>

                                <div class="product-card__image-actions placeholder-glow">
                                    <svg class="product-card__compare product-card__compare--active text-secondary" style="display: none" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.85464 0.542553L5.85464 4.34043L2.03057 4.34043C1.88569 4.34043 1.74673 4.39759 1.64428 4.49934C1.54183 4.60108 1.48428 4.73909 1.48428 4.88298L1.48428 15.9149L0.573785 15.9149C0.428899 15.9149 0.289947 15.9721 0.187497 16.0738C0.0850464 16.1756 0.0274906 16.3136 0.0274906 16.4574C0.0274906 16.6013 0.0850464 16.7393 0.187497 16.8411C0.289947 16.9428 0.428899 17 0.573786 17L16.5984 17C16.7433 17 16.8823 16.9428 16.9847 16.8411C17.0872 16.7393 17.1447 16.6013 17.1447 16.4574C17.1447 16.3136 17.0872 16.1756 16.9847 16.0738C16.8823 15.9721 16.7433 15.9149 16.5984 15.9149L15.6879 15.9149L15.6879 7.7766C15.6879 7.6327 15.6304 7.4947 15.5279 7.39295C15.4255 7.2912 15.2865 7.23404 15.1417 7.23404L11.3176 7.23404L11.3176 0.542552C11.3176 0.398658 11.26 0.260659 11.1576 0.15891C11.0551 0.0571618 10.9162 -4.727e-07 10.7713 -4.6641e-07L6.40093 -2.76684e-07C6.25604 -2.70394e-07 6.11709 0.057162 6.01464 0.15891C5.91219 0.260659 5.85464 0.398659 5.85464 0.542553Z"
                                            fill="currentColor"
                                        ></path>
                                    </svg>

                                    <svg class="product-card__compare product-card__compare--default" style="display: inline;" width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.78723 0.542553L5.78723 4.34043L1.98936 4.34043C1.84547 4.34043 1.70747 4.39759 1.60572 4.49934C1.50397 4.60108 1.44681 4.73909 1.44681 4.88298L1.44681 15.9149L0.542553 15.9149C0.398659 15.9149 0.260658 15.9721 0.15891 16.0738C0.0571616 16.1756 -3.00056e-08 16.3136 -2.37158e-08 16.4574C-1.74259e-08 16.6013 0.0571616 16.7393 0.15891 16.8411C0.260659 16.9428 0.398659 17 0.542553 17L16.4574 17C16.6013 17 16.7393 16.9428 16.8411 16.8411C16.9428 16.7393 17 16.6013 17 16.4574C17 16.3136 16.9428 16.1756 16.8411 16.0738C16.7393 15.9721 16.6013 15.9149 16.4574 15.9149L15.5532 15.9149L15.5532 7.7766C15.5532 7.6327 15.496 7.4947 15.3943 7.39295C15.2925 7.2912 15.1545 7.23404 15.0106 7.23404L11.2128 7.23404L11.2128 0.542552C11.2128 0.398658 11.1556 0.260658 11.0539 0.15891C10.9521 0.0571628 10.8141 -4.727e-07 10.6702 -4.6641e-07L6.32979 -2.76684e-07C6.18589 -2.70394e-07 6.04789 0.057163 5.94614 0.15891C5.84439 0.260658 5.78723 0.398658 5.78723 0.542553ZM2.53191 5.42553L5.78723 5.42553L5.78723 15.9149L2.53191 15.9149L2.53191 5.42553ZM14.4681 8.31915L14.4681 15.9149L11.2128 15.9149L11.2128 8.31915L14.4681 8.31915ZM10.1277 1.08511L10.1277 15.9149L6.87234 15.9149L6.87234 1.08511L10.1277 1.08511Z"
                                            fill="currentColor"
                                        ></path>
                                    </svg>

                                    <svg class="product-card__fav product-card__fav--active text-secondary" style="display: none" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M10.3716 17.5C10.2495 17.5 10.1295 17.4689 10.023 17.4097C9.64407 17.199 0.743109 12.1754 0.743109 5.8125C0.743482 4.69774 1.09682 3.61131 1.75314 2.70696C2.40945 1.80262 3.33549 1.12614 4.40023 0.773272C5.46497 0.420399 6.61448 0.408995 7.6861 0.740674C8.75772 1.07235 9.69719 1.73032 10.3716 2.62146C11.0459 1.73032 11.9854 1.07235 13.057 0.740674C14.1286 0.408995 15.2781 0.420399 16.3429 0.773272C17.4076 1.12614 18.3337 1.80262 18.99 2.70696C19.6463 3.61131 19.9996 4.69774 20 5.8125C20 8.51878 18.4208 11.3025 15.3063 14.0864C13.8936 15.344 12.3571 16.4574 10.7201 17.4097C10.6136 17.4689 10.4936 17.5 10.3716 17.5Z"
                                            fill="currentColor"
                                        ></path>
                                    </svg>

                                    <svg class="product-card__fav product-card__fav--default" style="display: inline;" width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.5625 17C9.44127 17 9.32207 16.9689 9.2163 16.9097C8.84 16.699 0 11.6754 0 5.3125C0.000370456 4.19774 0.351292 3.11131 1.00311 2.20696C1.65492 1.30262 2.57463 0.626144 3.63207 0.273271C4.68951 -0.0796019 5.83115 -0.0910058 6.89543 0.240673C7.95972 0.572352 8.89275 1.23032 9.5625 2.12146C10.2322 1.23032 11.1653 0.572352 12.2296 0.240673C13.2938 -0.0910058 14.4355 -0.0796019 15.4929 0.273271C16.5504 0.626144 17.4701 1.30262 18.1219 2.20696C18.7737 3.11131 19.1246 4.19774 19.125 5.3125C19.125 8.01878 17.5566 10.8025 14.4635 13.5864C13.0604 14.844 11.5345 15.9574 9.90861 16.9097C9.80287 16.9689 9.68369 17 9.5625 17ZM5.3125 1.41667C4.27962 1.41784 3.28938 1.82867 2.55902 2.55903C1.82867 3.28938 1.41784 4.27962 1.41667 5.3125C1.41667 10.204 7.96698 14.496 9.56223 15.4682C11.1569 14.4949 17.7083 10.1967 17.7083 5.3125C17.7081 4.41208 17.396 3.53952 16.8252 2.84317C16.2543 2.14683 15.4599 1.66967 14.577 1.49281C13.6941 1.31596 12.7773 1.45033 11.9822 1.87308C11.1872 2.29583 10.5632 2.98086 10.2161 3.81172C10.1623 3.94067 10.0715 4.0508 9.95516 4.12827C9.83886 4.20573 9.70224 4.24706 9.5625 4.24706C9.42276 4.24706 9.28614 4.20573 9.16984 4.12827C9.05353 4.0508 8.96274 3.94067 8.90888 3.81172C8.61354 3.10155 8.1142 2.49493 7.47403 2.06861C6.83386 1.64228 6.08163 1.4154 5.3125 1.41667Z"
                                            fill="currentColor"
                                        ></path>
                                    </svg>
                                </div>


                                <figure>
                                    <img
                                    
                                        src="<?=$result['DETAIL_PICTURE']['SRC']?>"
                                        alt="<?=!empty($result['~NAME']) ? $result['~NAME'] : $result['NAME']?>"
                                        itemprop="image"
                                    />
                                </figure>
                                
                            </div>

                            <div class="product-card__article">Артикул: 
                                <?=!empty($result['PROPERTIES']['CML2_ARTICLE']['VALUE']) 
                                    ? $result['PROPERTIES']['CML2_ARTICLE']['VALUE'] 
                                    : $result['PROPERTIES']['CML2_ARTICLE']['VALUE']?>
                            </div>
                            <div itemprop="name" class="product-card__title">
                                <?=
                                !empty($result['~NAME']) 
                                    ? $result['~NAME'] 
                                    : $result['NAME']?>
                            </div>

                            <div itemprop="description" class="hidden-on-page unset-margin">
                                <?=
                                !empty($result['PREVIEW_TEXT']) 
                                    ? $result['PREVIEW_TEXT'] 
                                    : $result['PREVIEW_TEXT']?>
                            </div>

                            <div itemprop="offers" itemscope="itemscope" itemtype="https://schema.org/Offer" class="price price--small">
                                <meta itemprop="priceCurrency" content="RUB" /> 
                                <span itemprop="price" class="price__current"> 
                                    <?=$result['PRICES_LIST']['PRICE']?> ₽
                                    <? if ($result['PRICES_LIST']['OLD_PRICE']) { ?>
                                        <span class="price__old"><?= $result['PRICES_LIST']['OLD_PRICE'] ?> ₽</span>
                                    <? } ?>
                                    <? if ($result['PRICES_LIST']['DISCOUNT']) { ?>
                                        <span class="price__discount">-<?= $result['PRICES_LIST']['DISCOUNT'] ?>%</span>
                                    <? } ?>
                                </span>
                                <meta itemprop="availability" href="https://schema.org/InStock" />
                            </div>


                            <div itemprop="aggregateRating" itemscope="itemscope" itemtype="https://schema.org/AggregateRating" class="stars">
                                <div class="stars placeholder-glow">
                                    <div class="placeholder"></div>
                                    <div class="placeholder"></div>
                                    <div class="placeholder"></div>
                                    <div class="placeholder"></div>
                                    <div class="placeholder"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-9">
                        <h3>Посмотреть наличие</h3>
                        <p class="w-75">
                            Забронированный в магазине товар будет готов максимум через 1 рабочий час и зарезервирован для вас в магазине на 1 день
                        </p>
                        <div class="availability-list mt-5">
                            <?if (!empty($result['STORES_ELEMENT'])):?>
                                <hr />
                                <?foreach ($result['STORES_ELEMENT'] as $arStore):?>
                                    <div class="row pt-3">
                                        <div class="col-9 fs-6">
                                            <div class="row mb-3">
                                                <div class="col flex-grow-0">Адрес:</div>
                                                <div class="col w-100 flex-grow-1 text-dark">
                                                    <span>
                                                        <?=$arStore['TITLE']?>
                                                        (<?=$arStore['ADDRESS']?>)
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col flex-grow-0">Режим работы:</div>
                                                <div class="col text-nowrap flex-grow-1 text-dark">
                                                    <?if (!empty($arStore['SCHEDULE'])):?>
                                                        <?=$arStore['SCHEDULE']?>
                                                    <?endif;?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="product-availability-bage mt-1">
                                                <?if ($arStore['AMOUNT'] > 0):?>
                                                    <span class="available">В наличии</span>
                                                <?else:?>
                                                    <span>Нет в наличии</span>
                                                <?endif;?>
                                            </div>
                                        </div>

                                        <?/*<div class="col-3">
                                            <button 
                                            <?=
                                            $arStore['AMOUNT'] > 0
                                                ? null
                                                : "disabled"
                                            ?>
                                            class="btn btn-light text-body w-100">
                                                Выбрать
                                            </button>
                                        </div>*/?>

                                        <div class="col-12 pt-3"><hr /></div>
                                    </div>
                                <?endforeach;?>
                            <?endif;?>
                        </div>
                        
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

