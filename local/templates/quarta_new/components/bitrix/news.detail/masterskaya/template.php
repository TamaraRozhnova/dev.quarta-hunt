<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->addExternalCss($templateFolder . '/video-js.min.css');
$this->addExternalJs($templateFolder . '/video.min.js');
?>

<div class="holosun">
    <!--    slider-->
    <?php if ($arResult['PROPERTIES']['MAIN_SLIDER']['VALUE'] != NULL) : ?>
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "main_slider",
            [
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "N",
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_DATE" => "N",
                "DISPLAY_NAME" => "N",
                "DISPLAY_PICTURE" => "N",
                "DISPLAY_PREVIEW_TEXT" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "FIELD_CODE" => [
                    0 => "ID",
                    1 => "CODE",
                    2 => "NAME",
                    3 => "PREVIEW_TEXT",
                    4 => "PREVIEW_PICTURE",
                    5 => "DETAIL_TEXT",
                    6 => "DETAIL_PICTURE",
                    7 => "IBLOCK_TYPE_ID",
                    8 => "IBLOCK_ID",
                    9 => "IBLOCK_CODE",
                    10 => "IBLOCK_NAME",
                ],
                "FILTER_NAME" => "",
                "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                "IBLOCK_ID" => "35",
                "IBLOCK_TYPE" => "sliders",
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                "INCLUDE_SUBSECTIONS" => "N",
                "MESSAGE_404" => "",
                "NEWS_COUNT" => "20",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Новости",
                "PARENT_SECTION" => $arResult['PROPERTIES']['MAIN_SLIDER']['VALUE'],
                "PARENT_SECTION_CODE" => "",
                "PREVIEW_TRUNCATE_LEN" => "",
                "PROPERTY_CODE" => [
                    0 => "DESCRIPTION",
                    1 => "LINK",
                ],
                "SET_BROWSER_TITLE" => "N",
                "SET_LAST_MODIFIED" => "N",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "N",
                "SHOW_404" => "N",
                "SORT_BY1" => "SORT",
                "SORT_BY2" => "",
                "SORT_ORDER1" => "ASC",
                "SORT_ORDER2" => "",
                "STRICT_SECTION_CHECK" => "N",
                "COMPACT" => "N"
            ],
            $component
        ); ?>
    <?php endif; ?>
    <!-- end  slider-->

    <!--    о компании-->
    <div class="container">
        <div class="row mt-3">
            <div class="col-12 col-lg-6">
                <h2><?= html_entity_decode($arResult['PROPERTIES']['ABOUT_TITLE']['VALUE']) ?></h2>
                <p><?= html_entity_decode($arResult['PROPERTIES']['ABOUT_TEXT_1']['VALUE']) ?></p>
            </div>

            <div class="col-12 col-lg-6">
                <p><?= html_entity_decode($arResult['PROPERTIES']['ABOUT_TEXT_2']['VALUE']) ?></p>
            </div>

            <!-- кнопка якорь на форму -->
            <div class="col-12 col-lg-6">
                <a class="btn btn-primary mb-4 go-to-form">
                    Запись в мастерскую
                </a>
            </div>

            <div class="preiskurant-block">
                <h2>Прейскурант Мастерской</h2>
                <div class="preiskurant-table">
                    <h3>Чистка и уход</h3>
                    <div class="preiskurant-table-block">
                        <div class="preiskurant-table-item"><span>Чистка гладкоствольного оружия</span></div>
                        <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                        <div class="preiskurant-table-item"></div>
                        <div class="preiskurant-table-item"><span>Чистка нарезного оружия</span></div>
                        <div class="preiskurant-table-item text-center">от 3 000 ₽</div>
                        <div class="preiskurant-table-item"></div>
                        <div class="preiskurant-table-item border-bottom-left-radius"><span>Отчистка от консервационной смазки</span></div>
                        <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius">Скидка 50% в день покупки оружия в магазине «QUARTA Оружейный квартал».</div>
                    </div>
                </div>
                <div class="preiskurant-table">
                    <h3>Установка и монтаж оптики</h3>
                    <div class="preiskurant-table-block">
                        <div class="preiskurant-table-item"><span>Установка колец и оптического прицела</span></div>
                        <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                        <div class="preiskurant-table-item light-weight">
                            <ul>
                                <li>Бесплатно при покупке набора «оружие + кольца + оптика» в магазине «QUARTA Оружейный квартал».</li>
                                <li>Скидка 50% на работы при покупке набора «оружие + прицел» в магазине «QUARTA Оружейный квартал».</li>
                            </ul>
                        </div>
                        <div class="preiskurant-table-item"><span>Установка оптического прицела в кольца с притиркой колец</span></div>
                        <div class="preiskurant-table-item text-center">от 6 000 ₽</div>
                        <div class="preiskurant-table-item light-weight">Скидка 50% на работы при покупке набора «оружие + прицел» в магазине «QUARTA Оружейный квартал».</div>
                        <div class="preiskurant-table-item"><span>Установка планки на оружие с её фиксацией на клей и винты</span></div>
                        <div class="preiskurant-table-item text-center">от 3 000 ₽</div>
                        <div class="preiskurant-table-item light-weight"></div>
                        <div class="preiskurant-table-item border-bottom-left-radius"><span>Установка коллиматора</span></div>
                        <div class="preiskurant-table-item text-center">от 1 000 ₽</div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius">Бесплатно при покупке набора «оружие + коллиматор» в магазине «QUARTA Оружейный квартал».</div>
                    </div>
                </div>
                <div class="preiskurant-table big-block">
                    <h3>Специализированные работы с оружием АК-серии</h3>
                    <div class="preiskurant-table-block">
                        <div class="left-block">
                            <div class="preiskurant-table-item"><span>Полная разборка/сборка в штатной комплектации</span></div>
                            <div class="preiskurant-table-item text-center">от 3 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Полная разборка/сборка в тюнинге</span></div>
                            <div class="preiskurant-table-item text-center">от 6 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Монтаж цевья без демонтажа оковки</span></div>
                            <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Демонтаж оковки цевья</span></div>
                            <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Установка шасси</span></div>
                            <div class="preiskurant-table-item text-center">от 12 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена приклада</span></div>
                            <div class="preiskurant-table-item text-center">от 3 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена и настройка УСМ</span></div>
                            <div class="preiskurant-table-item text-center">от 3 500 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена пистолетной рукоятки</span></div>
                            <div class="preiskurant-table-item text-center">от 1 000 ₽</div>
                            <div class="preiskurant-table-item">Монтаж устройства сброса магазина</span></div>
                            <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена дульных устройств</span></div>
                            <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                            <div class="preiskurant-table-item"><span>Монтаж/демонтаж газового блока</span></div>
                            <div class="preiskurant-table-item text-center">от 9 000 ₽</div>
                            <div class="preiskurant-table-item border-bottom-left-radius"><span>Установка накладок на рукоятку взведения затвора</span></div>
                            <div class="preiskurant-table-item text-center">от 1 000 ₽</div>
                        </div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius big-block">Скидка 30% на работы при покупке устанавливаемой детали в магазине «QUARTA Оружейный квартал».</div>
                    </div>
                </div>
                <div class="preiskurant-table">
                    <h3>Специализированные работы: платформа СВД</h3>
                    <div class="preiskurant-table-block">
                        <div class="preiskurant-table-item"><span>Установка шасси SAG/цевья РиР</span></div>
                        <div class="preiskurant-table-item text-center">от 15 000 ₽</div>
                        <div class="preiskurant-table-item light-weight"></div>
                        <div class="preiskurant-table-item border-bottom-left-radius"><span>Отладка УСМ</span></div>
                        <div class="preiskurant-table-item text-center">от 6 000 ₽</div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius"></div>
                    </div>
                </div>
                <div class="preiskurant-table big-block">
                    <h3>Специализированные работы: платформа AR</h3>
                    <div class="preiskurant-table-block">
                        <div class="left-block">
                            <div class="preiskurant-table-item"><span>Замена цевья</span></div>
                            <div class="preiskurant-table-item text-center">от 6 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена газблока</span></div>
                            <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена УСМ</span></div>
                            <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена предохранителя</span></div>
                            <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена трубы приклада</span></div>
                            <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                            <div class="preiskurant-table-item"><span>Замена ДТК с подгонкой</span></div>
                            <div class="preiskurant-table-item text-center">от 2 000 ₽</div>
                        </div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius big-block">Скидка 30% на работы при покупке устанавливаемой детали в магазине «QUARTA Оружейный квартал».</div>
                    </div>
                </div>
                <div class="preiskurant-table">
                    <h3>Специализированные работы: ОООП</h3>
                    <div class="preiskurant-table-block">
                        <div class="preiskurant-table-item border-bottom-left-radius"><span>Замена ЗИП на ОООП</span></div>
                        <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius"></div>
                    </div>
                </div>
                <div class="preiskurant-table">
                    <h3>Диагностика</h3>
                    <div class="preiskurant-table-block">
                        <div class="preiskurant-table-item">
                            <span>
                                Комплексная диагностика без выдачи заключения:
                                <ul style="margin-top: 10px;">
                                    <li>оценка технического состояния;</li>
                                    <li>оценка степени износа;</li>
                                    <li>оценка ремонтопригодности;</li>
                                    <li>выявление неисправности;</li>
                                    <li>определение видов работ по устранению выявленной неисправности.</li>
                                </ul>
                            </span>
                        </div>
                        <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                        <div class="preiskurant-table-item light-weight"></div>
                        <div class="preiskurant-table-item"><span>Выдача заключения о техническом состоянии оружия</span></div>
                        <div class="preiskurant-table-item text-center">от 3 000 ₽</div>
                        <div class="preiskurant-table-item light-weight"></div>
                        <div class="preiskurant-table-item border-bottom-left-radius"><span>Осмотр ствола оружия с помощью бороскопа</span></div>
                        <div class="preiskurant-table-item text-center">от 1 500 ₽</div>
                        <div class="preiskurant-table-item light-weight border-bottom-right-radius"></div>
                    </div>
                </div>
                <div class="alarm-info">
                    <h2>Внимание!</h2>
                    <p>В настоящем Прейскуранте указаны некоторые виды работ из возможных. Если вы не обнаружили интересующий вас вид работ, необходимый для вашего оружия, свяжитесь с нами.</p>
                    <p>В настоящем Прейскуранте указаны ориентировочные цены на работы. Они могут изменяться в зависимости от сложности работ. Точная стоимость определяется только после осмотра оружия мастером.</p>
                    <p>На стоимость работ могут влиять следующие факторы:</p>
                    <ul>
                        <li>объём работ;</li>
                        <li>состояние изделия;</li>
                        <li>наличие запасных частей и их стоимость;</li>
                        <li>необходимость использования специализированного инструмента и оборудования;</li>
                        <li>другие факторы.</li>
                    </ul>
                    <p>Не является публичной офертой.</p>
                </div>
            </div>

            <?/*<img src="<?=$templateFolder?>/img/55.jpg">*/?>

        </div>
    </div>
    <!--  end   о компании-->

    <!--    товары на обзор-->
    <?php if (is_array($arResult['PROPERTIES']['REVIEW_PRODUCTS']['VALUE']) && count($arResult['PROPERTIES']['REVIEW_PRODUCTS']['VALUE']) > 0) : ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 mb-4 mb-md-0">
                    <a href="<?= $arResult['PROPERTIES']['REVIEW_LINK']['VALUE'] ?>" class="promo-card promo-card--background-image promo-card--light promo-card--large promo-card--shadow">
                        <figure style="background-image: url('<?= $arResult['PROPERTIES']['REVIEW_IMAGE']['SRC'] ?>')"></figure>
                        <span class="mb-4" style="z-index: 1"><?= $arResult['PROPERTIES']['REVIEW_DATE']['VALUE'] ?></span>
                        <p><?= $arResult['PROPERTIES']['REVIEW_TEXT']['VALUE'] ?></p>
                    </a>
                </div>

                <div class="col-12 col-md-6 holosun__product">
                    <?php
                    global $arrFilterHolosunReviewProduct;
                    $arrFilterHolosunReviewProduct = [
                        '=ID' => $arResult['PROPERTIES']['REVIEW_PRODUCTS']['VALUE']
                    ];
                    ?>
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "products.promo.holosun",
                        array(
                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "-",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "-",
                            "BASKET_URL" => "/personal/basket.php",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "N",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "N",
                            "CUSTOM_FILTER" => "",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_COMPARE" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "arrFilterHolosunReviewProduct",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => "16",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array(),
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "2",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_CART_PROPERTIES" => array(""),
                            "OFFERS_FIELD_CODE" => array(""),
                            "OFFERS_LIMIT" => "0",
                            "OFFERS_PROPERTY_CODE" => array(""),
                            "OFFERS_SORT_FIELD" => "sort",
                            "OFFERS_SORT_FIELD2" => "id",
                            "OFFERS_SORT_ORDER" => "asc",
                            "OFFERS_SORT_ORDER2" => "desc",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => ".default",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "2",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => [$arResult['PRICE_CODE']],
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                            "PRODUCT_DISPLAY_MODE" => "N",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPERTIES" => array(""),
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE" => array(""),
                            "PROPERTY_CODE_MOBILE" => array(""),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_CODE" => "",
                            "SECTION_ID" => "",
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array("", ""),
                            "SEF_MODE" => "N",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SHOW_ALL_WO_SECTION" => "N",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "N",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "N",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N",
                        ),
                        $component
                    ); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--   end товары на обзор-->

    <!--    video-->
    <? if (!empty($arResult['PROPERTIES']['VIDEO_REVIEW_TITLE']['VALUE']) && !empty($arResult['PROPERTIES']['VIDEO_REVIEW_TEXT']['VALUE'][0])) : ?>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h2><?= $arResult['PROPERTIES']['VIDEO_REVIEW_TITLE']['VALUE'] ?></h2>
                </div>
                <div class="col-12 col-md-6">
                    <p><?= $arResult['PROPERTIES']['VIDEO_REVIEW_TEXT']['VALUE'][0] ?></p>
                </div>
            </div>
        </div>
    <? endif; ?>

    <?php if ($arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE']['SRC'] != NULL) : ?>
        <div class="vertically-divided holosun__video">
            <div class="vertically-divided__top"></div>
            <div class="vertically-divided__content">

                <div class="container pb-0">
                    <div size="large" class="video-player">
                        <video class="video-js" controls preload="auto" data-setup="{}" poster="<?= $arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE']['SRC'] ?>" aspectRatio="aspectRatio">
                            <source src="<?= $arResult['PROPERTIES']['VIDEO_REVIEW_LINK']['VALUE'] ?>" type="video/mp4" />
                        </video>

                        <p><?= $arResult['PROPERTIES']['VIDEO_REVIEW_IMAGE_TEXT']['VALUE'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <? if (!empty($arResult['PROPERTIES']['VIDEO_REVIEW_TEXT']['VALUE'][1]) && !empty($arResult['PROPERTIES']['VIDEO_REVIEW_TEXT']['VALUE'][2])) : ?>
        <div class="bg-white pt-5 pb-5">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p><?= $arResult['PROPERTIES']['VIDEO_REVIEW_TEXT']['VALUE'][1] ?></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p><?= $arResult['PROPERTIES']['VIDEO_REVIEW_TEXT']['VALUE'][2] ?></p>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>
    <!-- end   video-->

    <!--    slider 2-->
    <?php if (is_array($arResult['PROPERTIES']['SLIDER_2']['ITEMS']) && count($arResult['PROPERTIES']['SLIDER_2']['ITEMS']) > 0) : ?>
        <div class="holosun__wide-slider">
            <div class="wide-promotion">
                <div class="wide-promotion__image" style="background-image: url(<?= reset($arResult['PROPERTIES']['SLIDER_2']['ITEMS'])['DETAIL_PICTURE']['SRC'] ?>">

                </div>
                <div class="wide-promotion__content-backdrop"></div>

                <div class="wide-promotion__body">
                    <div class="container">
                        <div class="row">
                            <a href="<?= reset($arResult['PROPERTIES']['SLIDER_2']['ITEMS'])['PROPERTIES']['LINK']['VALUE'] ?>" class="col-12 col-md-6">
                                <div class="promo-wide-image-text promo-wide-image-text--light">
                                    <p></p>
                                </div>
                            </a>
                            <div class="col-12 col-md-6 pt-4">
                                <div class="base-slider">
                                    <div class="">
                                        <div class="compact-swiper swiper swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                                            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">

                                                <?php foreach ($arResult['PROPERTIES']['SLIDER_2']['ITEMS'] as $arSlide) : ?>
                                                    <div class="swiper-slide swiper-slide-active">
                                                        <div class="promo-product-slide">
                                                            <div class="row promo-product-slide__top">
                                                                <h2 class="promo-product-slide__title">
                                                                    <?= $arSlide['NAME'] ?>
                                                                </h2>
                                                                <p>
                                                                    <? if (!empty($arSlide['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'])) : ?>
                                                                        <?= $arSlide['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'] ?>
                                                                    <? endif; ?>

                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <div class="swiper-scrollbar" style="display: none;">
                                                <div class="swiper-scrollbar-drag" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; width: 0px;"></div>
                                            </div>
                                            <div class="base-slider__arrows">
                                                <div class="base-slider__prev"></div>
                                                <div class="base-slider__next"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    <?php endif; ?>
    <!--    end slider 2-->

    <?php if (!empty($arResult['PROPERTIES']['DESCR_1_TITLE']['VALUE']) && !empty($arResult['PROPERTIES']['DESCR_1_TEXT']['VALUE'][0])): ?>
        <div class="bg-white pt-5 holosun__row">
            <div class="container pt-5">
                <div class="row py-5">
                    <div class="
                col-12
                d-flex
                flex-column
                justify-content-center
                align-content-start
                col-md-6
                ">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_1_TITLE']['VALUE'])): ?>
                            <h2 class="mb-4"><?= $arResult['PROPERTIES']['DESCR_1_TITLE']['VALUE'] ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($arResult['PROPERTIES']['DESCR_1_TEXT']['VALUE'][0])): ?>
                            <p><?= $arResult['PROPERTIES']['DESCR_1_TEXT']['VALUE'][0] ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 d-flex justify-content-end align-content-center col-md-6">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_1_IMAGES']['SRC'][0])): ?>
                            <img src="<?= $arResult['PROPERTIES']['DESCR_1_IMAGES']['SRC'][0] ?>" alt="Holosun" class="holosun__contain-img" />
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row py-2 py-lg-5 mt-5">
                    <div class="col-12 d-flex justify-content-start align-content-center col-md-6 mb-5">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_1_IMAGES']['SRC'][1])): ?>
                            <img src="<?= $arResult['PROPERTIES']['DESCR_1_IMAGES']['SRC'][1] ?>" alt="Holosun" class="holosun__contain-img" />
                        <?php endif; ?>
                    </div>
                    <div class="
                col-12
                d-flex
                flex-column
                justify-content-center
                align-content-start
                col-md-6
                ">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_1_TEXT']['VALUE'][1])): ?>
                            <p><?= $arResult['PROPERTIES']['DESCR_1_TEXT']['VALUE'][1] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?endif;?>

    <?php if (is_array($arResult['PROPERTIES']['CATALOG_PRODUCTS']['VALUE']) && count($arResult['PROPERTIES']['CATALOG_PRODUCTS']['VALUE']) > 0) : ?>
        <div class="bg-gray-100 py-5 holosun__products">
            <div class="container py-5">
                <div class="row py-5">
                    <div class="
              col-12
              mb-4
              d-flex
              justify-content-between
              align-items-center
              holosun__products-row
              flex-wrap
              flex-md-nowrap
            ">
                        <h3 class="text-left me-auto"><?= $arResult['PROPERTIES']['CATALOG_SECTION_TITLE']['VALUE'] ?></h3>

                        <a href="<?= $arResult['PROPERTIES']['CATALOG_LINK']['VALUE'] ?>" style="font-size: 16px" class="d-inline-block text-nowrap me-auto text-md-end me-md-0">Перейти в каталог</a>
                    </div>
                    <div class="holosun__product">

                        <?php global $arrFilterHolosunProduct;
                        $arrFilterHolosunProduct = [
                            '=ID' => $arResult['PROPERTIES']['CATALOG_PRODUCTS']['VALUE']
                        ];
                        ?>
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:catalog.section",
                            "products.promo.holosun",
                            array(
                                "ACTION_VARIABLE" => "action",
                                "ADD_PICT_PROP" => "-",
                                "ADD_PROPERTIES_TO_BASKET" => "Y",
                                "ADD_SECTIONS_CHAIN" => "N",
                                "ADD_TO_BASKET_ACTION" => "ADD",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "BACKGROUND_IMAGE" => "-",
                                "BASKET_URL" => "/personal/basket.php",
                                "BROWSER_TITLE" => "-",
                                "CACHE_FILTER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "36000000",
                                "CACHE_TYPE" => "N",
                                "COMPATIBLE_MODE" => "Y",
                                "CONVERT_CURRENCY" => "N",
                                "CUSTOM_FILTER" => "",
                                "DETAIL_URL" => "",
                                "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                                "DISPLAY_BOTTOM_PAGER" => "Y",
                                "DISPLAY_COMPARE" => "N",
                                "DISPLAY_TOP_PAGER" => "N",
                                "ELEMENT_SORT_FIELD" => "sort",
                                "ELEMENT_SORT_FIELD2" => "id",
                                "ELEMENT_SORT_ORDER" => "asc",
                                "ELEMENT_SORT_ORDER2" => "desc",
                                "ENLARGE_PRODUCT" => "STRICT",
                                "FILTER_NAME" => "arrFilterHolosunProduct",
                                "HIDE_NOT_AVAILABLE" => "N",
                                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                                "IBLOCK_ID" => "16",
                                "IBLOCK_TYPE" => "1c_catalog",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "LABEL_PROP" => array(),
                                "LAZY_LOAD" => "N",
                                "LINE_ELEMENT_COUNT" => "4",
                                "LOAD_ON_SCROLL" => "N",
                                "MESSAGE_404" => "",
                                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                "MESS_BTN_BUY" => "Купить",
                                "MESS_BTN_DETAIL" => "Подробнее",
                                "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                                "META_DESCRIPTION" => "-",
                                "META_KEYWORDS" => "-",
                                "OFFERS_CART_PROPERTIES" => array(""),
                                "OFFERS_FIELD_CODE" => array(""),
                                "OFFERS_LIMIT" => "0",
                                "OFFERS_PROPERTY_CODE" => array(""),
                                "OFFERS_SORT_FIELD" => "sort",
                                "OFFERS_SORT_FIELD2" => "id",
                                "OFFERS_SORT_ORDER" => "asc",
                                "OFFERS_SORT_ORDER2" => "desc",
                                "PAGER_BASE_LINK_ENABLE" => "N",
                                "PAGER_DESC_NUMBERING" => "N",
                                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                "PAGER_SHOW_ALL" => "N",
                                "PAGER_SHOW_ALWAYS" => "N",
                                "PAGER_TEMPLATE" => ".default",
                                "PAGER_TITLE" => "Товары",
                                "PAGE_ELEMENT_COUNT" => "4",
                                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                "PRICE_CODE" => [$arResult['PRICE_CODE']],
                                "PRICE_VAT_INCLUDE" => "Y",
                                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                                "PRODUCT_DISPLAY_MODE" => "N",
                                "PRODUCT_ID_VARIABLE" => "id",
                                "PRODUCT_PROPERTIES" => array(""),
                                "PRODUCT_PROPS_VARIABLE" => "prop",
                                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                                "PRODUCT_SUBSCRIPTION" => "Y",
                                "PROPERTY_CODE" => array(""),
                                "PROPERTY_CODE_MOBILE" => array(""),
                                "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                                "RCM_TYPE" => "personal",
                                "SECTION_CODE" => "",
                                "SECTION_ID" => "",
                                "SECTION_ID_VARIABLE" => "SECTION_ID",
                                "SECTION_URL" => "",
                                "SECTION_USER_FIELDS" => array("", ""),
                                "SEF_MODE" => "N",
                                "SET_BROWSER_TITLE" => "N",
                                "SET_LAST_MODIFIED" => "N",
                                "SET_META_DESCRIPTION" => "N",
                                "SET_META_KEYWORDS" => "N",
                                "SET_STATUS_404" => "N",
                                "SET_TITLE" => "N",
                                "SHOW_404" => "N",
                                "SHOW_ALL_WO_SECTION" => "N",
                                "SHOW_CLOSE_POPUP" => "N",
                                "SHOW_DISCOUNT_PERCENT" => "N",
                                "SHOW_FROM_SECTION" => "N",
                                "SHOW_MAX_QUANTITY" => "N",
                                "SHOW_OLD_PRICE" => "N",
                                "SHOW_PRICE_COUNT" => "1",
                                "SHOW_SLIDER" => "Y",
                                "SLIDER_INTERVAL" => "3000",
                                "SLIDER_PROGRESS" => "N",
                                "TEMPLATE_THEME" => "blue",
                                "USE_ENHANCED_ECOMMERCE" => "N",
                                "USE_MAIN_ELEMENT_SECTION" => "N",
                                "USE_PRICE_COUNT" => "N",
                                "USE_PRODUCT_QUANTITY" => "N",
                            ),
                            $component
                        ); ?>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!--    slider 3-->
    <?php if (!empty($arResult['PROPERTIES']['SLIDER_3']['ITEMS']) && is_array($arResult['PROPERTIES']['SLIDER_3']['ITEMS']) && count($arResult['PROPERTIES']['SLIDER_3']['ITEMS']) > 0) : ?>
        <div class="holosun__wide-slider">
            <div class="wide-promotion">
                <div class="wide-promotion__image" style="background-image: url(<?= reset($arResult['PROPERTIES']['SLIDER_3']['ITEMS'])['DETAIL_PICTURE']['SRC'] ?>">

                </div>
                <div class="wide-promotion__content-backdrop"></div>

                <div class="wide-promotion__body">
                    <div class="container">
                        <div class="row">
                            <a href="<?= reset($arResult['PROPERTIES']['SLIDER_3']['ITEMS'])['PROPERTIES']['LINK']['VALUE'] ?>" class="col-12 col-md-6">
                                <div class="promo-wide-image-text promo-wide-image-text--light">
                                    <p></p>
                                </div>
                            </a>
                            <div class="col-12 col-md-6 pt-4">
                                <div class="base-slider">
                                    <div class="">
<!--                                        <div class="compact-swiper swiper swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">-->
<!--                                            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">-->

                                                <?php foreach ($arResult['PROPERTIES']['SLIDER_3']['ITEMS'] as $arSlide) : ?>
                                                    <div class="swiper-slide swiper-slide-active">
                                                        <div class="promo-product-slide">
                                                            <div class="row promo-product-slide__top">
                                                                <h2 class="promo-product-slide__title">
                                                                    <?= $arSlide['NAME'] ?>
                                                                </h2>
                                                                <div class="checklist">
                                                                    <?= $arSlide['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'] ?>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>

<!--                                            </div>-->
<!--                                            <div class="swiper-scrollbar" style="display: none;">-->
<!--                                                <div class="swiper-scrollbar-drag" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; width: 0px;"></div>-->
<!--                                            </div>-->
<!--                                            <div class="base-slider__arrows">-->
<!--                                                <div class="base-slider__prev"></div>-->
<!--                                                <div class="base-slider__next"></div>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    <?php endif; ?>
    <!--    end slider 3-->

    <? if (!empty($arResult['PROPERTIES']['DESCR_2_TITLE']['VALUE']) && !empty($arResult['PROPERTIES']['DESCR_2_TEXT']['VALUE'])) : ?>
        <div class="bg-white py-lg-5 overflow-hidden">
            <div class="container py-lg-5">
                <div class="row py-5 holosun__price-descr">
                    <div class="col-12 d-flex flex-column justify-content-center col-lg-5 ">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_2_TITLE']['VALUE'])): ?>
                            <h2 class="mb-4"><?= $arResult['PROPERTIES']['DESCR_2_TITLE']['VALUE'] ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($arResult['PROPERTIES']['DESCR_2_TEXT']['VALUE'])): ?>
                            <p><?= $arResult['PROPERTIES']['DESCR_2_TEXT']['VALUE'] ?></p>
                        <?php endif; ?>

                        <?php if (!empty($arResult['PROPERTIES']['DESCR_2_WARNING']['VALUE'])): ?>
                            <div class="bg-primary text-white p-5 mt-5 q-small">
                                <p class="m-0"><?= $arResult['PROPERTIES']['DESCR_2_WARNING']['VALUE'] ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-1 d-none d-lg-block"></div>

                    <div class="
                        col-12
                        d-flex
                        flex-column
                        justify-content-center
                        align-items-start
                        ps-lg-5
                        col-lg-6
                        holosun__price-img
                    ">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_2_IMAGES']['SRC'])): ?>
                            <img src="<?= $arResult['PROPERTIES']['DESCR_2_IMAGES']['SRC'] ?>" class="holosun__contain-img ms-lg-5" alt="Holosun" />
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Предполагается, что v-if="thirdDesc.image && thirdDesc.title && thirdDesc.text" является ошибкой, поскольку это синтаксис Vue.js, а не PHP -->
                <div class="row py-3 py-lg-5 holosun__advant">
                    <div class="
                col-6
                d-flex
                flex-column
                justify-content-center
                align-items-start
                ">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_3_IMAGES']['SRC'])): ?>
                            <img src="<?= $arResult['PROPERTIES']['DESCR_3_IMAGES']['SRC'] ?>" alt="Holosun" class="holosun__contain-img" />
                        <?php endif; ?>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center">
                        <?php if (!empty($arResult['PROPERTIES']['DESCR_3_TITLE']['VALUE'])): ?>
                            <h2 class="mb-4"><?= $arResult['PROPERTIES']['DESCR_3_TITLE']['VALUE'] ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($arResult['PROPERTIES']['DESCR_3_TEXT']['VALUE'])): ?>
                            <p><?= $arResult['PROPERTIES']['DESCR_3_TEXT']['VALUE'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row pt-3 pt-lg-5">
                    <div class="col-8 holosun__assort">
                        <small> Ассортимент </small>
                        <?php if (!empty($arResult['PROPERTIES']['ASSORT_TITLE']['VALUE'])): ?>
                            <h2 class="mt-2"><?= $arResult['PROPERTIES']['ASSORT_TITLE']['VALUE'] ?></h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <? endif; ?>

    <?if (!empty($arResult['PROPERTIES']['ASSORT_CLASS_1']['VALUE']) && !empty($arResult['PROPERTIES']['ASSORT_CLASS_2']['VALUE'])):?>
        <div class="holosun__series-tabs bg-white d-md-none">
            <div class="holosun__series-tabs-wr">
                <h2 class="d-flex w-50 align-items-center active">
                    <img src="<?= $templateFolder . '/img/classic-cross.png' ?>" />
                    <?= $arResult['PROPERTIES']['ASSORT_CLASS_1']['VALUE'] ?>
                </h2>
                <h2 class="d-flex w-50 align-items-center">
                    <img src="<?= $templateFolder . '/img/elite-cross.png' ?>" />
                    <?= $arResult['PROPERTIES']['ASSORT_CLASS_2']['VALUE'] ?>
                </h2>
            </div>
        </div>
    <?endif;?>

    <?if (
        !empty($arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['VALUE'])
        || !empty($arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['VALUE'])
    ):?>
        <div class="bg-white series">
            <div class="container">
                <div class="row holosun__series">
                    <?if (
                        !empty($arResult['PROPERTIES']['ASSORT_CLASS_1']['VALUE'])
                        && !empty($arResult['PROPERTIES']['ASSORT_IMAGE_1']['SRC'])
                        && !empty($arResult['PROPERTIES']['ASSORT_DESCR_1']['VALUE'])
                        && !empty($arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['VALUE'])
                    ):?>
                        <div class="col-6 p-5 ps-0 open">
                            <h2 class="d-none d-md-flex justify-content-between align-items-center pb-2">
                                <?= $arResult['PROPERTIES']['ASSORT_CLASS_1']['VALUE'] ?>
                                <img src="<?= $templateFolder . '/img/classic-cross.png' ?>" />
                            </h2>

                            <hr />

                            <figure>
                                <img src="<?= $arResult['PROPERTIES']['ASSORT_IMAGE_1']['SRC'] ?>" />
                            </figure>

                            <p><?= $arResult['PROPERTIES']['ASSORT_DESCR_1']['VALUE'] ?></p>

                            <div class="row mt-5 pt-lg-5">
                                <div class="col-12 holosun__product">

                                    <?php global $arrFilterHolosunFirstAssort;
                                    $arrFilterHolosunFirstAssort = [
                                        '=ID' => $arResult['PROPERTIES']['ASSORT_PRODUCTS_1']['VALUE']
                                    ];
                                    ?>
                                    <?php $APPLICATION->IncludeComponent(
                                        "bitrix:catalog.section",
                                        "products.promo.holosun",
                                        array(
                                            "ACTION_VARIABLE" => "action",
                                            "ADD_PICT_PROP" => "-",
                                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                                            "ADD_SECTIONS_CHAIN" => "N",
                                            "ADD_TO_BASKET_ACTION" => "ADD",
                                            "AJAX_MODE" => "N",
                                            "AJAX_OPTION_ADDITIONAL" => "",
                                            "AJAX_OPTION_HISTORY" => "N",
                                            "AJAX_OPTION_JUMP" => "N",
                                            "AJAX_OPTION_STYLE" => "Y",
                                            "BACKGROUND_IMAGE" => "-",
                                            "BASKET_URL" => "/personal/basket.php",
                                            "BROWSER_TITLE" => "-",
                                            "CACHE_FILTER" => "N",
                                            "CACHE_GROUPS" => "Y",
                                            "CACHE_TIME" => "36000000",
                                            "CACHE_TYPE" => "N",
                                            "COMPATIBLE_MODE" => "Y",
                                            "CONVERT_CURRENCY" => "N",
                                            "CUSTOM_FILTER" => "",
                                            "DETAIL_URL" => "",
                                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                                            "DISPLAY_BOTTOM_PAGER" => "Y",
                                            "DISPLAY_COMPARE" => "N",
                                            "DISPLAY_TOP_PAGER" => "N",
                                            "ELEMENT_SORT_FIELD" => "sort",
                                            "ELEMENT_SORT_FIELD2" => "id",
                                            "ELEMENT_SORT_ORDER" => "asc",
                                            "ELEMENT_SORT_ORDER2" => "desc",
                                            "ENLARGE_PRODUCT" => "STRICT",
                                            "FILTER_NAME" => "arrFilterHolosunFirstAssort",
                                            "HIDE_NOT_AVAILABLE" => "N",
                                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                                            "IBLOCK_ID" => "16",
                                            "IBLOCK_TYPE" => "1c_catalog",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "LABEL_PROP" => array(),
                                            "LAZY_LOAD" => "N",
                                            "LINE_ELEMENT_COUNT" => "2",
                                            "LOAD_ON_SCROLL" => "N",
                                            "MESSAGE_404" => "",
                                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                            "MESS_BTN_BUY" => "Купить",
                                            "MESS_BTN_DETAIL" => "Подробнее",
                                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                            "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                                            "META_DESCRIPTION" => "-",
                                            "META_KEYWORDS" => "-",
                                            "OFFERS_CART_PROPERTIES" => array(""),
                                            "OFFERS_FIELD_CODE" => array(""),
                                            "OFFERS_LIMIT" => "0",
                                            "OFFERS_PROPERTY_CODE" => array(""),
                                            "OFFERS_SORT_FIELD" => "sort",
                                            "OFFERS_SORT_FIELD2" => "id",
                                            "OFFERS_SORT_ORDER" => "asc",
                                            "OFFERS_SORT_ORDER2" => "desc",
                                            "PAGER_BASE_LINK_ENABLE" => "N",
                                            "PAGER_DESC_NUMBERING" => "N",
                                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                            "PAGER_SHOW_ALL" => "N",
                                            "PAGER_SHOW_ALWAYS" => "N",
                                            "PAGER_TEMPLATE" => ".default",
                                            "PAGER_TITLE" => "Товары",
                                            "PAGE_ELEMENT_COUNT" => "2",
                                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                            "PRICE_CODE" => [$arResult['PRICE_CODE']],
                                            "PRICE_VAT_INCLUDE" => "Y",
                                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                                            "PRODUCT_DISPLAY_MODE" => "N",
                                            "PRODUCT_ID_VARIABLE" => "id",
                                            "PRODUCT_PROPERTIES" => array(""),
                                            "PRODUCT_PROPS_VARIABLE" => "prop",
                                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                                            "PRODUCT_SUBSCRIPTION" => "Y",
                                            "PROPERTY_CODE" => array(""),
                                            "PROPERTY_CODE_MOBILE" => array(""),
                                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                                            "RCM_TYPE" => "personal",
                                            "SECTION_CODE" => "",
                                            "SECTION_ID" => "",
                                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                                            "SECTION_URL" => "",
                                            "SECTION_USER_FIELDS" => array("", ""),
                                            "SEF_MODE" => "N",
                                            "SET_BROWSER_TITLE" => "N",
                                            "SET_LAST_MODIFIED" => "N",
                                            "SET_META_DESCRIPTION" => "N",
                                            "SET_META_KEYWORDS" => "N",
                                            "SET_STATUS_404" => "N",
                                            "SET_TITLE" => "N",
                                            "SHOW_404" => "N",
                                            "SHOW_ALL_WO_SECTION" => "N",
                                            "SHOW_CLOSE_POPUP" => "N",
                                            "SHOW_DISCOUNT_PERCENT" => "N",
                                            "SHOW_FROM_SECTION" => "N",
                                            "SHOW_MAX_QUANTITY" => "N",
                                            "SHOW_OLD_PRICE" => "N",
                                            "SHOW_PRICE_COUNT" => "1",
                                            "SHOW_SLIDER" => "Y",
                                            "SLIDER_INTERVAL" => "3000",
                                            "SLIDER_PROGRESS" => "N",
                                            "TEMPLATE_THEME" => "blue",
                                            "USE_ENHANCED_ECOMMERCE" => "N",
                                            "USE_MAIN_ELEMENT_SECTION" => "N",
                                            "USE_PRICE_COUNT" => "N",
                                            "USE_PRODUCT_QUANTITY" => "N",
                                        ),
                                        $component
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    <?endif;?>

                    <?if (
                        !empty($arResult['PROPERTIES']['ASSORT_CLASS_2']['VALUE'])
                        && !empty($arResult['PROPERTIES']['ASSORT_IMAGE_2']['SRC'])
                        && !empty($arResult['PROPERTIES']['ASSORT_DESCR_2']['VALUE'])
                        && !empty($arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['VALUE'])
                    ):?>
                        <div class="col-6 p-5 pe-0">
                            <h2 class="d-none d-md-flex justify-content-between align-items-center pb-2">
                                <?= $arResult['PROPERTIES']['ASSORT_CLASS_2']['VALUE'] ?>
                                <img src="<?= $templateFolder . '/img/elite-cross.png' ?>" />
                            </h2>

                            <hr />

                            <figure>
                                <img src="<?= $arResult['PROPERTIES']['ASSORT_IMAGE_2']['SRC'] ?>" />
                            </figure>

                            <p><?= $arResult['PROPERTIES']['ASSORT_DESCR_2']['VALUE'] ?></p>

                            <div class="row mt-5 pt-lg-5">
                                <div class="col-12 holosun__product">

                                    <?php global $arrFilterHolosunSecondAssort;
                                    $arrFilterHolosunSecondAssort = [
                                        '=ID' => $arResult['PROPERTIES']['ASSORT_PRODUCTS_2']['VALUE']
                                    ];
                                    ?>
                                    <?php $APPLICATION->IncludeComponent(
                                        "bitrix:catalog.section",
                                        "products.promo.holosun",
                                        array(
                                            "ACTION_VARIABLE" => "action",
                                            "ADD_PICT_PROP" => "-",
                                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                                            "ADD_SECTIONS_CHAIN" => "N",
                                            "ADD_TO_BASKET_ACTION" => "ADD",
                                            "AJAX_MODE" => "N",
                                            "AJAX_OPTION_ADDITIONAL" => "",
                                            "AJAX_OPTION_HISTORY" => "N",
                                            "AJAX_OPTION_JUMP" => "N",
                                            "AJAX_OPTION_STYLE" => "Y",
                                            "BACKGROUND_IMAGE" => "-",
                                            "BASKET_URL" => "/personal/basket.php",
                                            "BROWSER_TITLE" => "-",
                                            "CACHE_FILTER" => "N",
                                            "CACHE_GROUPS" => "Y",
                                            "CACHE_TIME" => "36000000",
                                            "CACHE_TYPE" => "N",
                                            "COMPATIBLE_MODE" => "Y",
                                            "CONVERT_CURRENCY" => "N",
                                            "CUSTOM_FILTER" => "",
                                            "DETAIL_URL" => "",
                                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                                            "DISPLAY_BOTTOM_PAGER" => "Y",
                                            "DISPLAY_COMPARE" => "N",
                                            "DISPLAY_TOP_PAGER" => "N",
                                            "ELEMENT_SORT_FIELD" => "sort",
                                            "ELEMENT_SORT_FIELD2" => "id",
                                            "ELEMENT_SORT_ORDER" => "asc",
                                            "ELEMENT_SORT_ORDER2" => "desc",
                                            "ENLARGE_PRODUCT" => "STRICT",
                                            "FILTER_NAME" => "arrFilterHolosunSecondAssort",
                                            "HIDE_NOT_AVAILABLE" => "N",
                                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                                            "IBLOCK_ID" => "16",
                                            "IBLOCK_TYPE" => "1c_catalog",
                                            "INCLUDE_SUBSECTIONS" => "Y",
                                            "LABEL_PROP" => array(),
                                            "LAZY_LOAD" => "N",
                                            "LINE_ELEMENT_COUNT" => "2",
                                            "LOAD_ON_SCROLL" => "N",
                                            "MESSAGE_404" => "",
                                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                                            "MESS_BTN_BUY" => "Купить",
                                            "MESS_BTN_DETAIL" => "Подробнее",
                                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                                            "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                                            "META_DESCRIPTION" => "-",
                                            "META_KEYWORDS" => "-",
                                            "OFFERS_CART_PROPERTIES" => array(""),
                                            "OFFERS_FIELD_CODE" => array(""),
                                            "OFFERS_LIMIT" => "0",
                                            "OFFERS_PROPERTY_CODE" => array(""),
                                            "OFFERS_SORT_FIELD" => "sort",
                                            "OFFERS_SORT_FIELD2" => "id",
                                            "OFFERS_SORT_ORDER" => "asc",
                                            "OFFERS_SORT_ORDER2" => "desc",
                                            "PAGER_BASE_LINK_ENABLE" => "N",
                                            "PAGER_DESC_NUMBERING" => "N",
                                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                                            "PAGER_SHOW_ALL" => "N",
                                            "PAGER_SHOW_ALWAYS" => "N",
                                            "PAGER_TEMPLATE" => ".default",
                                            "PAGER_TITLE" => "Товары",
                                            "PAGE_ELEMENT_COUNT" => "2",
                                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                                            "PRICE_CODE" => [$arResult['PRICE_CODE']],
                                            "PRICE_VAT_INCLUDE" => "Y",
                                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                                            "PRODUCT_DISPLAY_MODE" => "N",
                                            "PRODUCT_ID_VARIABLE" => "id",
                                            "PRODUCT_PROPERTIES" => array(""),
                                            "PRODUCT_PROPS_VARIABLE" => "prop",
                                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                                            "PRODUCT_SUBSCRIPTION" => "Y",
                                            "PROPERTY_CODE" => array(""),
                                            "PROPERTY_CODE_MOBILE" => array(""),
                                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                                            "RCM_TYPE" => "personal",
                                            "SECTION_CODE" => "",
                                            "SECTION_ID" => "",
                                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                                            "SECTION_URL" => "",
                                            "SECTION_USER_FIELDS" => array("", ""),
                                            "SEF_MODE" => "N",
                                            "SET_BROWSER_TITLE" => "N",
                                            "SET_LAST_MODIFIED" => "N",
                                            "SET_META_DESCRIPTION" => "N",
                                            "SET_META_KEYWORDS" => "N",
                                            "SET_STATUS_404" => "N",
                                            "SET_TITLE" => "N",
                                            "SHOW_404" => "N",
                                            "SHOW_ALL_WO_SECTION" => "N",
                                            "SHOW_CLOSE_POPUP" => "N",
                                            "SHOW_DISCOUNT_PERCENT" => "N",
                                            "SHOW_FROM_SECTION" => "N",
                                            "SHOW_MAX_QUANTITY" => "N",
                                            "SHOW_OLD_PRICE" => "N",
                                            "SHOW_PRICE_COUNT" => "1",
                                            "SHOW_SLIDER" => "Y",
                                            "SLIDER_INTERVAL" => "3000",
                                            "SLIDER_PROGRESS" => "N",
                                            "TEMPLATE_THEME" => "blue",
                                            "USE_ENHANCED_ECOMMERCE" => "N",
                                            "USE_MAIN_ELEMENT_SECTION" => "N",
                                            "USE_PRICE_COUNT" => "N",
                                            "USE_PRODUCT_QUANTITY" => "N",
                                        ),
                                        $component
                                    ); ?>

                                </div>
                            </div>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    <?endif;?>

    <!--    slider 4-->
    <?php if (is_array($arResult['PROPERTIES']['SLIDER_4']['ITEMS']) && count($arResult['PROPERTIES']['SLIDER_4']['ITEMS']) > 0) : ?>
        <div class="bg-white pb-5">
            <div class="base-slider">
                <div class="">
                    <div class="holosun-ruler-swiper swiper swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">

                            <?php foreach ($arResult['PROPERTIES']['SLIDER_4']['ITEMS'] as $arSlide) : ?>
                                <div class="swiper-slide swiper-slide-active">
                                    <div class="row slider-card holosun__ruler">
                                        <div class="col-6">
                                            <figure>
                                                <img src="<?= $arSlide['DETAIL_PICTURE']['SRC'] ?>" alt="Holosun" class="holosun__contain-img" />
                                            </figure>
                                        </div>
                                        <div class="col-6">
                                            <h3 class="mb-4"><?= $arSlide['NAME'] ?></h3>
                                            <div><?= $arSlide['PROPERTIES']['DESCRIPTION']['~VALUE']['TEXT'] ?></div>

                                            <a href="<?= $arSlide['PROPERTIES']['LINK']['VALUE'] ?>" class="btn btn-primary mt-4">Перейти в каталог</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-scrollbar" style="display: none;">
                            <div class="swiper-scrollbar-drag" style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; width: 0px;"></div>
                        </div>
                        <div class="base-slider__arrows">
                            <div class="base-slider__prev"></div>
                            <div class="base-slider__next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--    slider 4-->

    <? if (!empty($arResult['PROPERTIES']['COND_TITLE']['VALUE']) && !empty($arResult['PROPERTIES']['COND_DESCR']['VALUE'])) : ?>
        <div class="bg-gray-100 py-5">
            <div class="container py-0 py-lg-5">
                <div class="row py-lg-5 holosun__about">
                    <div class="col-6">
                        <h3><?= $arResult['PROPERTIES']['COND_TITLE']['VALUE'] ?></h3>
                    </div>
                    <div class="col-6">
                        <p><?= $arResult['PROPERTIES']['COND_DESCR']['VALUE'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>

    <? if (!empty($arResult['PROPERTIES']['COND_IMAGE']['SRC'])) : ?>
        <div class="w-100 bg-black">
            <img src="<?= $arResult['PROPERTIES']['COND_IMAGE']['SRC'] ?>" class="img-fluid d-block mx-auto" alt="Holosun" />
        </div>
    <? endif; ?>

    <? if (
        !empty($arResult['PROPERTIES']['COND_BLOCK_TITLE']['VALUE'][0])
        && !empty($arResult['PROPERTIES']['COND_BLOCK_LINK']['VALUE'][0])
    ) : ?>
        <div class="bg-gray-200 py-5 q-end">
            <div class="container py-lg-5">
                <div class="row py-lg-5 holosun__for">
                    <div class="col-6">
                        <div class="cabinet-section">
                            <div v-if="$slots.header" class="cabinet-section__header">
                                <h3 class="my-3">Для <a href="<?= $arResult['PROPERTIES']['COND_BLOCK_LINK']['VALUE'][0] ?>"><?= stristr($arResult['PROPERTIES']['COND_BLOCK_TITLE']['VALUE'][0], ' ') ?></a>
                                </h3>
                            </div>

                            <div class="cabinet-section__content">

                                <p><?= $arResult['PROPERTIES']['COND_BLOCK_DESCR']['VALUE'][0] ?></p>

                                <a href="<?= $arResult['PROPERTIES']['COND_BLOCK_LINK']['VALUE'][0] ?>" class="btn btn-primary py-3 px-5 mt-2 mb-3">
                                    Подробнее
                                </a>
                            </div>
                        </div>

                    </div>

                    <? if (
                        !empty($arResult['PROPERTIES']['COND_BLOCK_LINK']['VALUE'][1])
                        && !empty($arResult['PROPERTIES']['COND_BLOCK_TITLE']['VALUE'][1])
                    ) :
                    ?>
                        <div class="col-6">
                            <div class="cabinet-section">
                                <div v-if="$slots.header" class="cabinet-section__header">
                                    <h3 class="my-3">Для <a href="<?= $arResult['PROPERTIES']['COND_BLOCK_LINK']['VALUE'][1] ?>"><?= stristr($arResult['PROPERTIES']['COND_BLOCK_TITLE']['VALUE'][1], ' ') ?></a>
                                    </h3>
                                </div>

                                <div class="cabinet-section__content">

                                    <p><?= $arResult['PROPERTIES']['COND_BLOCK_DESCR']['VALUE'][1] ?></p>

                                    <a href="<?= $arResult['PROPERTIES']['COND_BLOCK_LINK']['VALUE'][1] ?>" class="btn btn-primary py-3 px-5 mt-2 mb-3">
                                        Подробнее
                                    </a>
                                </div>
                            </div>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>
    <? endif; ?>

    <!-- form -->
    <div class="bg-white py-5">
		<div class="container py-5">
			<div class="row py-lg-5">
				<div class="col-12 col-lg-6">
					<h2>Форма отправки заявки</h2>
					<p>Наш специалист свяжется с вами для уточнения деталей</p>
				</div>
				<div class="col-12 col-lg-5">
                    <?$APPLICATION->IncludeComponent("bitrix:form.result.new", "masterskaya", Array(
                    	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
                    		"CACHE_TYPE" => "A",	// Тип кеширования
                    		"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
                    		"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
                    		"EDIT_URL" => "result_edit.php",	// Страница редактирования результата
                    		"IGNORE_CUSTOM_TEMPLATE" => "N",	// Игнорировать свой шаблон
                    		"LIST_URL" => "",	// Страница со списком результатов
                    		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
                    		"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
                    		"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
                    		"VACANCY_NAME" => "",	// Название вакансии
                    		"VARIABLE_ALIASES" => array(
                    			"RESULT_ID" => "RESULT_ID",
                    			"WEB_FORM_ID" => "WEB_FORM_ID",
                    		),
                    		"WEB_FORM_ID" => "7",	// ID веб-формы
                    	),
                    	false
                    );?>
				</div>
			</div>
		</div>
	</div>

</div>