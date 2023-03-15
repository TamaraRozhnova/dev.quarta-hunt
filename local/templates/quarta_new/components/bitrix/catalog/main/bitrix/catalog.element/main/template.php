<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

?>

<div>
    <section class="product">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <ProductPhotosVue :product="product"/>
                </div>

                <div class="col-12 col-md-6">
                    <div class="row align-items-center mb-3 mb-sm-2">
                        <div class="col-8">
                            <div class="product__article">Артикул: {{ product.article }}</div>
                        </div>
                        <div class="col-4">
                            <div class="product__share">
                                <transition name="product__share-modal">
                                    <div class="product__share-modal" v-if="showSharePopup"
                                         v-click-outside="closeModal">
                                        <ShareNetwork
                                                class="product__share-btn"
                                                network="whatsapp"
                                                :url="shareOptions.url"
                                                :title="shareOptions.title"
                                                :description="shareOptions.description"
                                        >
                                            <svg id="whatsapp-icon" style="enable-background:new 0 0 1000 1000;"
                                                 version="1.1" viewBox="0 0 1000 1000" xml:space="preserve"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"><style
                                                        type="text/css">.whatsapp0 {
                                                        fill: #25D366;
                                                    }

                                                    .whatsapp1 {
                                                        fill-rule: evenodd;
                                                        clip-rule: evenodd;
                                                        fill: #FFFFFF;
                                                    }</style>
                                                <title/>
                                                <g>
                                                    <path class="whatsapp0"
                                                          d="M500,1000L500,1000C223.9,1000,0,776.1,0,500v0C0,223.9,223.9,0,500,0h0c276.1,0,500,223.9,500,500v0   C1000,776.1,776.1,1000,500,1000z"/>
                                                    <g>
                                                        <g id="WA_Logo">
                                                            <g>
                                                                <path class="whatsapp1"
                                                                      d="M733.9,267.2c-62-62.1-144.6-96.3-232.5-96.4c-181.1,0-328.6,147.4-328.6,328.6      c0,57.9,15.1,114.5,43.9,164.3L170.1,834l174.2-45.7c48,26.2,102,40,157,40h0.1c0,0,0,0,0,0c181.1,0,328.5-147.4,328.6-328.6      C830.1,411.9,796,329.3,733.9,267.2z M501.5,772.8h-0.1c-49,0-97.1-13.2-139-38.1l-10-5.9L249,755.9l27.6-100.8l-6.5-10.3      c-27.3-43.5-41.8-93.7-41.8-145.4c0.1-150.6,122.6-273.1,273.3-273.1c73,0,141.5,28.5,193.1,80.1c51.6,51.6,80,120.3,79.9,193.2      C774.6,650.3,652,772.8,501.5,772.8z M651.3,568.2c-8.2-4.1-48.6-24-56.1-26.7c-7.5-2.7-13-4.1-18.5,4.1      c-5.5,8.2-21.2,26.7-26,32.2c-4.8,5.5-9.6,6.2-17.8,2.1c-8.2-4.1-34.7-12.8-66-40.8c-24.4-21.8-40.9-48.7-45.7-56.9      c-4.8-8.2-0.5-12.7,3.6-16.8c3.7-3.7,8.2-9.6,12.3-14.4c4.1-4.8,5.5-8.2,8.2-13.7c2.7-5.5,1.4-10.3-0.7-14.4      c-2.1-4.1-18.5-44.5-25.3-61c-6.7-16-13.4-13.8-18.5-14.1c-4.8-0.2-10.3-0.3-15.7-0.3c-5.5,0-14.4,2.1-21.9,10.3      c-7.5,8.2-28.7,28.1-28.7,68.5c0,40.4,29.4,79.5,33.5,84.9c4.1,5.5,57.9,88.4,140.3,124c19.6,8.5,34.9,13.5,46.8,17.3      c19.7,6.3,37.6,5.4,51.7,3.3c15.8-2.4,48.6-19.9,55.4-39c6.8-19.2,6.8-35.6,4.8-39C665,574.4,659.5,572.4,651.3,568.2z"/>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g></svg>
                                            <span>Whatsapp</span>
                                        </ShareNetwork>
                                        <ShareNetwork
                                                class="product__share-btn"
                                                network="vk"
                                                :url="shareOptions.url"
                                                :title="shareOptions.title"
                                                :description="shareOptions.description"
                                        >
                                            <svg id="vk-icon" style="enable-background:new 0 0 1000 1000;" version="1.1"
                                                 viewBox="0 0 1000 1000" xml:space="preserve"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"><style
                                                        type="text/css">.vk-icon0 {
                                                        fill: #5181B8;
                                                    }

                                                    .vk-icon1 {
                                                        fill-rule: evenodd;
                                                        clip-rule: evenodd;
                                                        fill: #FFFFFF;
                                                    }</style>
                                                <title/>
                                                <g>
                                                    <path class="vk-icon0"
                                                          d="M500,1000L500,1000C223.9,1000,0,776.1,0,500v0C0,223.9,223.9,0,500,0h0c276.1,0,500,223.9,500,500v0   C1000,776.1,776.1,1000,500,1000z"/>
                                                    <path class="vk-icon1"
                                                          d="M819,344.5c4.6-15.5,0-26.8-22.1-26.8H724c-18.5,0-27.1,9.8-31.7,20.6c0,0-37.1,90.4-89.6,149.1   c-17,17-24.7,22.4-34,22.4c-4.6,0-11.3-5.4-11.3-20.9V344.5c0-18.5-5.4-26.8-20.8-26.8H422c-11.6,0-18.6,8.6-18.6,16.8   c0,17.6,26.3,21.6,29,71.1v107.4c0,23.5-4.3,27.8-13.5,27.8c-24.7,0-84.8-90.8-120.5-194.7c-7-20.2-14-28.3-32.6-28.3h-72.9   c-20.8,0-25,9.8-25,20.6c0,19.3,24.7,115.1,115.1,241.8c60.3,86.5,145.1,133.4,222.4,133.4c46.3,0,52.1-10.4,52.1-28.4v-65.4   c0-20.8,4.4-25,19.1-25c10.8,0,29.4,5.4,72.6,47.1c49.4,49.4,57.6,71.6,85.4,71.6h72.9c20.8,0,31.2-10.4,25.2-31   c-6.6-20.5-30.2-50.2-61.5-85.5c-17-20.1-42.5-41.7-50.2-52.5c-10.8-13.9-7.7-20.1,0-32.4C720.9,512.1,809.7,387,819,344.5z"
                                                          id="Logo"/>
                                                </g></svg>
                                            <span>Вконтакте</span>
                                        </ShareNetwork>
                                        <ShareNetwork
                                                class="product__share-btn"
                                                network="telegram"
                                                :url="shareOptions.url"
                                                :title="shareOptions.title"
                                                :description="shareOptions.description"
                                        >
                                            <svg id="telegram-icon" style="enable-background:new 0 0 512 512;"
                                                 version="1.1" viewBox="0 0 512 512" xml:space="preserve"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink"><style
                                                        type="text/css">.telegram0 {
                                                        fill: url(#SVGID_1_);
                                                    }

                                                    .telegram1 {
                                                        fill: #FFFFFF;
                                                    }

                                                    .telegram2 {
                                                        fill: #D2E4F0;
                                                    }

                                                    .telegram3 {
                                                        fill: #B5CFE4;
                                                    }</style>
                                                <g>
                                                    <linearGradient gradientUnits="userSpaceOnUse" id="SVGID_1_"
                                                                    x1="256" x2="256" y1="0" y2="510.1322">
                                                        <stop offset="0" style="stop-color:#41BCE7"/>
                                                        <stop offset="1" style="stop-color:#22A6DC"/>
                                                    </linearGradient>
                                                    <circle class="telegram0" cx="256" cy="256" r="256"/>
                                                    <g>
                                                        <path class="telegram1"
                                                              d="M380.6,147.3l-45.7,230.5c0,0-6.4,16-24,8.3l-105.5-80.9L167,286.7l-64.6-21.7c0,0-9.9-3.5-10.9-11.2    c-1-7.7,11.2-11.8,11.2-11.8l256.8-100.7C359.5,141.2,380.6,131.9,380.6,147.3z"/>
                                                        <path class="telegram2"
                                                              d="M197.2,375.2c0,0-3.1-0.3-6.9-12.4c-3.8-12.1-23.3-76.1-23.3-76.1l155.1-98.5c0,0,9-5.4,8.6,0    c0,0,1.6,1-3.2,5.4c-4.8,4.5-121.8,109.7-121.8,109.7"/>
                                                        <path class="telegram3"
                                                              d="M245.8,336.2l-41.7,38.1c0,0-3.3,2.5-6.8,0.9l8-70.7"/>
                                                    </g>
                                                </g></svg>
                                            <span>Telegram</span>
                                        </ShareNetwork>
                                    </div>
                                </transition>
                                <button class="product__share-toggle" @click="toggleSharePopup()">
                                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.375 8.5C8.92969 8.5 8.51875 8.65625 8.19687 8.91719L4.95937 6.575C5.01359 6.27745 5.01359 5.97255 4.95937 5.675L8.19687 3.33281C8.51875 3.59375 8.92969 3.75 9.375 3.75C10.4094 3.75 11.25 2.90937 11.25 1.875C11.25 0.840625 10.4094 0 9.375 0C8.34062 0 7.5 0.840625 7.5 1.875C7.5 2.05625 7.525 2.22969 7.57344 2.39531L4.49844 4.62187C4.04219 4.01719 3.31719 3.625 2.5 3.625C1.11875 3.625 0 4.74375 0 6.125C0 7.50625 1.11875 8.625 2.5 8.625C3.31719 8.625 4.04219 8.23281 4.49844 7.62813L7.57344 9.85469C7.525 10.0203 7.5 10.1953 7.5 10.375C7.5 11.4094 8.34062 12.25 9.375 12.25C10.4094 12.25 11.25 11.4094 11.25 10.375C11.25 9.34062 10.4094 8.5 9.375 8.5ZM9.375 1.0625C9.82344 1.0625 10.1875 1.42656 10.1875 1.875C10.1875 2.32344 9.82344 2.6875 9.375 2.6875C8.92656 2.6875 8.5625 2.32344 8.5625 1.875C8.5625 1.42656 8.92656 1.0625 9.375 1.0625ZM2.5 7.5C1.74219 7.5 1.125 6.88281 1.125 6.125C1.125 5.36719 1.74219 4.75 2.5 4.75C3.25781 4.75 3.875 5.36719 3.875 6.125C3.875 6.88281 3.25781 7.5 2.5 7.5ZM9.375 11.1875C8.92656 11.1875 8.5625 10.8234 8.5625 10.375C8.5625 9.92656 8.92656 9.5625 9.375 9.5625C9.82344 9.5625 10.1875 9.92656 10.1875 10.375C10.1875 10.8234 9.82344 11.1875 9.375 11.1875Z"
                                              fill="#808D9A"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="product__title">
                        <?= $arResult['NAME'] ?>
                    </div>

                    <StarsVue :rating="product.rating"/>

                    <? if ($arResult['AVAILABLE']) { ?>
                        <div class="price">
                            <span class="price__current"><?= $item['PRICES']['PRICE'] ?> ₽</span>
                            <? if ($item['PRICES']['OLD_PRICE']) { ?>
                                <span class="price__old"><?= $item['PRICES']['OLD_PRICE'] ?> ₽</span>
                            <? } ?>
                            <? if ($item['PRICES']['DISCOUNT']) { ?>
                                <span class="price__discount">-<?= $item['PRICES']['DISCOUNT'] ?>%</span>
                            <? } ?>
                        </div>
                    <? } ?>

                    <div class="product__availability">
                        <? if ($arResult['AVAILABLE']) { ?>
                            <span class="product__availability-in-stock">
                            В наличии
                        </span>
                        <? } else { ?>
                            <span class="me-2">Нет в наличии</span>
                        <? } ?>

                        <a href="#" @click="availabilityModal = true">
                            Посмотреть наличие
                        </a>

                        <InfoVue/>
                    </div>

                    <div v-if="bonus" class="product__bonus">
            <span
                    class="product__bonus-points"
                    :class="{ 'bg-secondary text-white': hasDoubleBonus }"
            >
              + {{ bonus }} б
            </span>
                        Бонусные баллы
                        <InfoVue>
                            {{
                            hasDoubleBonus
                            ? 'Двойные бонусы за покупку!'
                            : 'Оплачивайте бонусными баллами до 50% стоимости следующей покупки!'
                            }}
                        </InfoVue>
                    </div>
                    <SelectVue
                            class="product__trade-offerss"
                            v-if="product.options && product.options.length"
                            :options="product.options"
                            :value="offerText"
                            :label="'Выберите размер'"
                            @change="setTradingOffer"
                    />

                    <div class="product__add">
                        <ProductCountVue
                                v-if="isInCart && !isCounterDisabled && isAvaible"
                                :product="product"
                                :product-count="product.rawResponse.PRODUCT.QUANTITY"
                        />

                        <button
                                v-else-if="!isAvaible"
                                class="btn btn-primary px-3"
                                @click="() => (showAvailabilityInform = true)"
                        >
                            Cообщить о поступлении
                        </button>

                        <button
                                v-else-if="isInCart && isAvaible"
                                class="btn btn-primary px-5"
                                @click="removeFromCart"
                        >
                            Убрать из корзины
                        </button>

                        <button
                                v-if="!isInCart && isAvaible"
                                class="btn btn-primary px-5"
                                @click="addToCart"
                        >
                            В корзину
                        </button>

                        <button
                                class="btn bg-white mx-1"
                                :class="{ 'text-secondary border-secondary': isInFavs }"
                                @click="toggleFavs"
                        >
                            <HeartFillIcon v-if="isInFavs"/>
                            <HeartIcon v-else/>
                            {{ isInFavs ? 'В избранном' : 'В избранное' }}
                        </button>
                        <button
                                class="btn bg-white mx-1"
                                :class="{ 'text-secondary border-secondary': isInCompare }"
                                @click="toggleCompare"
                        >
                            <CompareFillIcon v-if="isInCompare"/>
                            <CompareIcon v-else/>
                            В
                            сравнение
                        </button>
                    </div>
                    <hr/>

                    <div class="product__delivery mb-5">
                        <div class="product__delivery-option">
                            <div class="product__delivery-icon">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/delivery.svg" alt="Доставка"/>
                            </div>
                            Доставка по Москве: <span class="text-dark">с 11.03</span><br/>
                            <a href="#">Узнать стоимость</a>
                        </div>
                        <div class="product__delivery-option">
                            <div class="product__delivery-icon">
                                <img src="<?= SITE_TEMPLATE_PATH ?>/assets/icons/location.svg" alt="Местоположение"/>
                            </div>
                            Доступно к самовывозу:
                            <span class="text-dark">бесплатно</span><br/>
                            <a href="#" @click="availabilityModal = true">{{ availableCount }}</a>
                        </div>
                    </div>

                    <ProductComboVue
                            v-if="count === 0 && !isCounterDisabled"
                            :parent="product"
                            @change="onComboChange"
                    />
                </div>
            </div>
        </div>

        <ProductAboutVue :product="product"/>
    </section>

    <div class="recommendations">
        <div class="container">
            <h2 class="mb-4">С этим товаром покупают</h2>
        </div>
        <div class="base-slider">
            <div class="container">
                <div class="swiper-container swiper-container_recommended">
                    <div class="swiper-wrapper">
                        <? foreach ($arResult['RECOMMENDED_PRODUCTS'] as $product) { ?>
                            <div class="swiper-slide">
                                <? $APPLICATION->IncludeComponent(
                                    'bitrix:catalog.item',
                                    'main',
                                    array(
                                        'RESULT' => array(
                                            'ITEM' => $product,
                                            'PARAMS' => $arParams
                                        ),
                                    ),
                                    $component
                                ); ?>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
