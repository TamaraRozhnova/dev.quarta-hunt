<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle('Оптовым покупателям - Quarta Hunt');

use General\User;

$user = new User();
$isWholesaler = $user->isWholesaler();

?><div class="wholesale">
    <div class="jumbotron-vue jumbotron-vue--large" style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/static/wholesale.jpg')">
        <div class="container">
            <div class="jumbotron-vue__body">
                <div class="jumbotron-vue__q">
                    <svg width="562" height="542" viewBox="0 0 562 542" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_b_164:3)">
                            <path d="M547.473 271C547.473 121.574 424.662 0 273.716 0C122.769 0 0 121.615 0 271C0 420.385 122.811 542 273.757 542C299.764 542 325.478 538.405 350.233 531.256L380.372 522.578L320.01 444.352L307.027 446.749C296.132 448.774 284.945 449.766 273.757 449.766C174.156 449.766 93.131 369.557 93.131 270.959C93.131 172.361 174.156 92.1516 273.757 92.1516C373.359 92.1516 454.384 172.361 454.384 270.959C454.384 312.737 439.398 353.151 412.723 385.053H311.619L435.182 539.355L435.724 539.438L437.77 541.959H562L483.939 444.518C524.681 396.169 547.473 334.845 547.473 271Z" fill="#004989" fill-opacity="0.28"></path>
                        </g>
                        <defs>
                            <filter id="filter0_b_164:3" x="-4" y="-4" width="570" height="550" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                <feGaussianBlur in="BackgroundImage" stdDeviation="2"></feGaussianBlur>
                                <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_164:3"></feComposite>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_164:3" result="shape"></feBlend>
                            </filter>
                        </defs>
                    </svg>
                </div>
                <div class="row wholesale__head">
                    <div class="col-6">
                        <p class="wholesale__subtitle">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/wholesale/subtitle.php",
                                ],
                                false
                            ); ?>
                        </p>
                        <h1>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/wholesale/title.php",
                                ],
                                false
                            ); ?>
                        </h1>
                    </div>
                    <div class="col-4">
                        <p class="fs-6 mt-5 wholesale__head-descr">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/wholesale/text.php",
                                ],
                                false
                            ); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <? if (!$isWholesaler) { ?>
        <div class="container py-5">
            <div class="row my-5 pt-5 wholesale__form">
                <div class="col-6 wholesale__form-item">
                    <h3>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/wholesale/form/title.php",
                            ],
                            false
                        ); ?>
                    </h3>
                </div>
                <div class="col-5 wholesale__form-item">

                    <? $APPLICATION->IncludeFile('/local/php_interface/include/forms/registrationForm.php') ?>

                    <small class="wholesale__form-consent">
                        Нажимая кнопку «Отправить»,
                        <a href="/privacy-statement">
                            я даю свое согласие на обработку моих персональных данных.
                        </a>
                    </small>
                </div>
            </div>
        </div>
    <? } else { ?>
        <div class="container py-5">
            <div class="row my-5 pt-5 wholesale__price-list">
                <div class="col-6">
                    <h2>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/wholesale/price_list/title.php",
                            ],
                            false
                        ); ?>
                    </h2>
                </div>
                <? $APPLICATION->IncludeComponent("bitrix:news.detail","price_list", Array(
                        "IBLOCK_TYPE" => "wholesale",
                        "IBLOCK_ID" => "29",
                        "ELEMENT_ID" => "35761",
                        "ELEMENT_CODE" => "",
                        "CHECK_DATES" => "Y",
                        "FIELD_CODE" => Array("ID"),
                        "PROPERTY_CODE" => Array("PRICE_LIST"),
                        "DETAIL_URL" => "",
                        "SET_TITLE" => "N",
                        "SET_CANONICAL_URL" => "N",
                        "SET_BROWSER_TITLE" => "N",
                        "BROWSER_TITLE" => "-",
                        "SET_META_KEYWORDS" => "N",
                        "META_KEYWORDS" => "-",
                        "SET_META_DESCRIPTION" => "N",
                        "META_DESCRIPTION" => "-",
                        "SET_STATUS_404" => "N",
                        "SET_LAST_MODIFIED" => "Y",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "ADD_ELEMENT_CHAIN" => "N",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "USE_PERMISSIONS" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "N",
                        "PAGER_TITLE" => "Страница",
                        "PAGER_TEMPLATE" => "",
                        "SHOW_404" => "N",
                        "MESSAGE_404" => "",
                        "STRICT_SECTION_CHECK" => "Y",
                        "PAGER_BASE_LINK" => "",
                        "PAGER_PARAMS_NAME" => "arrPager",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N"
                    )
                ); ?>
            </div>
        </div>
    <? } ?>

    <hr class="my-5 wholesale__line" />

    <div class="container py-5 wholesale__advantages">
        <div class="row my-5 wholesale__advantages-item">
            <div class="col-6">
                <h2>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/title.php",
                        ],
                        false
                    ); ?>
                </h2>
            </div>
            <div class="col-6">
                <p class="mt-5">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/description.php",
                        ],
                        false
                    ); ?>
                </p>
            </div>
        </div>

        <hr class="my-5" />

        <div class="row mt-5 pt-3">
            <div class="col-6">
                <h3 class="has-checkmark">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/first_section/title.php",
                        ],
                        false
                    ); ?>
                </h3>
            </div>
            <div class="col-6">
                <p>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/first_section/description.php",
                        ],
                        false
                    ); ?>
                </p>
            </div>
        </div>

        <hr class="my-5" />

        <div class="row mt-5 pt-3">
            <div class="col-6">
                <h3 class="has-checkmark">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/second_section/title.php",
                        ],
                        false
                    ); ?>
                </h3>
            </div>
            <div class="col-6">
                <p>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/second_section/description.php",
                        ],
                        false
                    ); ?>
                </p>

                <div class="row wholesale__advantages-img">
                    <div class="col-6">
                        <figure>
                            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/static/wholesale-holosun.jpg" alt="" />
                        </figure>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center">
                        <p>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/wholesale/list/second_section/extra.php",
                                ],
                                false
                            ); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5" />

        <div class="row mt-5 pt-3">
            <div class="col-6">
                <h3 class="has-checkmark">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/third_section/title.php",
                        ],
                        false
                    ); ?>
                </h3>
            </div>
            <div class="col-6">
                <p>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/third_section/description.php",
                        ],
                        false
                    ); ?>
                </p>
            </div>
        </div>

        <hr class="my-5" />

        <div class="row mt-5 pt-3">
            <div class="col-6">
                <h3 class="has-checkmark">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/fourth_section/title.php",
                        ],
                        false
                    ); ?>
                </h3>
            </div>
            <div class="col-6 wholesale__advantages-mark">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/wholesale/list/fourth_section/description.php",
                    ],
                    false
                ); ?>
            </div>
        </div>

        <div class="my-5">
            <? $APPLICATION->IncludeComponent("bitrix:news.detail","video", Array(
                    "IBLOCK_TYPE" => "wholesale",
                    "IBLOCK_ID" => "29",
                    "ELEMENT_ID" => "35761",
                    "ELEMENT_CODE" => "",
                    "CHECK_DATES" => "Y",
                    "FIELD_CODE" => Array("ID"),
                    "PROPERTY_CODE" => Array("VIDEO_LINK"),
                    "DETAIL_URL" => "",
                    "SET_TITLE" => "N",
                    "SET_CANONICAL_URL" => "N",
                    "SET_BROWSER_TITLE" => "N",
                    "BROWSER_TITLE" => "-",
                    "SET_META_KEYWORDS" => "N",
                    "META_KEYWORDS" => "-",
                    "SET_META_DESCRIPTION" => "N",
                    "META_DESCRIPTION" => "-",
                    "SET_STATUS_404" => "N",
                    "SET_LAST_MODIFIED" => "Y",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_ELEMENT_CHAIN" => "N",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "USE_PERMISSIONS" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_GROUPS" => "N",
                    "PAGER_TITLE" => "Страница",
                    "PAGER_TEMPLATE" => "",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => "",
                    "STRICT_SECTION_CHECK" => "Y",
                    "PAGER_BASE_LINK" => "",
                    "PAGER_PARAMS_NAME" => "arrPager",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N"
                )
            ); ?>
        </div>

        <div class="row my-5 pt-3 pb-5 wholesale__advantages-item wholesale__advantages-item--last">
            <div class="col-6">
                <h3 class="has-checkmark">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/fifth_section/title.php",
                        ],
                        false
                    ); ?>
                </h3>
            </div>
            <div class="col-6">
                <p>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/wholesale/list/fifth_section/description.php",
                        ],
                        false
                    ); ?>
                </p>
            </div>
        </div>
    </div>

    <? if (!$isWholesaler) { ?>
        <div class="jumbotron-vue jumbotron-vue--small" style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/static/wholesale-bottom.jpg')">
            <div class="container">
                <div class="jumbotron-vue__body">
                    <div class="jumbotron-vue__q">
                        <svg width="562" height="542" viewBox="0 0 562 542" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_b_164:3)">
                                <path d="M547.473 271C547.473 121.574 424.662 0 273.716 0C122.769 0 0 121.615 0 271C0 420.385 122.811 542 273.757 542C299.764 542 325.478 538.405 350.233 531.256L380.372 522.578L320.01 444.352L307.027 446.749C296.132 448.774 284.945 449.766 273.757 449.766C174.156 449.766 93.131 369.557 93.131 270.959C93.131 172.361 174.156 92.1516 273.757 92.1516C373.359 92.1516 454.384 172.361 454.384 270.959C454.384 312.737 439.398 353.151 412.723 385.053H311.619L435.182 539.355L435.724 539.438L437.77 541.959H562L483.939 444.518C524.681 396.169 547.473 334.845 547.473 271Z" fill="#004989" fill-opacity="0.28"></path>
                            </g>
                            <defs>
                                <filter id="filter0_b_164:3" x="-4" y="-4" width="570" height="550" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feGaussianBlur in="BackgroundImage" stdDeviation="2"></feGaussianBlur>
                                    <feComposite in2="SourceAlpha" operator="in" result="effect1_backgroundBlur_164:3"></feComposite>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_164:3" result="shape"></feBlend>
                                </filter>
                            </defs>
                        </svg>
                    </div>
                    <div class="row wholesale__bottom">
                        <div class="col-6">
                            <p class="wholesale__subtitle">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    [
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => "/include/wholesale/last_section/subtitle.php",
                                    ],
                                    false
                                ); ?>
                            </p>
                            <h2 class="h1">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    [
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => "/include/wholesale/last_section/title.php",
                                    ],
                                    false
                                ); ?>
                            </h2>
                            <a href="#registration-form" class="btn btn-outline-light mt-4 py-3 px-5">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    [
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => "/include/wholesale/last_section/button.php",
                                    ],
                                    false
                                ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>

</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>