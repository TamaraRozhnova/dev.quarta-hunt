<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

?>

<div class="delivery">
    <div class="jumbotron-vue"
         style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/static/delivery.jpg');">
        <div class="container">
            <div class="jumbotron-vue__body">
                <div class="jumbotron-vue__q">
                    <svg width="562" height="542" viewBox="0 0 562 542" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_b_164:3)">
                            <path d="M547.473 271C547.473 121.574 424.662 0 273.716 0C122.769 0 0 121.615 0 271C0 420.385 122.811 542 273.757 542C299.764 542 325.478 538.405 350.233 531.256L380.372 522.578L320.01 444.352L307.027 446.749C296.132 448.774 284.945 449.766 273.757 449.766C174.156 449.766 93.131 369.557 93.131 270.959C93.131 172.361 174.156 92.1516 273.757 92.1516C373.359 92.1516 454.384 172.361 454.384 270.959C454.384 312.737 439.398 353.151 412.723 385.053H311.619L435.182 539.355L435.724 539.438L437.77 541.959H562L483.939 444.518C524.681 396.169 547.473 334.845 547.473 271Z"
                                  fill="#004989" fill-opacity="0.28"></path>
                        </g>
                        <defs>
                            <filter id="filter0_b_164:3" x="-4" y="-4" width="570" height="550"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                <feGaussianBlur in="BackgroundImage" stdDeviation="2"></feGaussianBlur>
                                <feComposite in2="SourceAlpha" operator="in"
                                             result="effect1_backgroundBlur_164:3"></feComposite>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_backgroundBlur_164:3"
                                         result="shape"></feBlend>
                            </filter>
                        </defs>
                    </svg>
                </div>
                <h1>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/title.php",
                        ],
                        false
                    ); ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="bg-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h2>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/first_section/title.php",
                            ],
                            false
                        ); ?>
                    </h2>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/first_section/description.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/first_section/first_city/title.php",
                            ],
                            false
                        ); ?>
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/first_section/first_city/text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>

            <hr/>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/first_section/second_city/title.php",
                            ],
                            false
                        ); ?>
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/first_section/second_city/text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <h2>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/second_section/title.php",
                            ],
                            false
                        ); ?>
                    </h2>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/second_section/left_text.php",
                        ],
                        false
                    ); ?>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/second_section/right_text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <? $APPLICATION->IncludeComponent("bitrix:news.list", "delivery_shops", [
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
        "CACHE_TYPE" => "A",
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
        "IBLOCK_ID" => "30",
        "IBLOCK_TYPE" => "about",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "100",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Новости",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => [
            0 => "DESCRIPTION",
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
        false
    ); ?>

    <div class="bg-gray-100 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="d-flex mb-5">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/delivery/fourth_section/title.php",
                            ],
                            false
                        ); ?>
                    </div>

                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/fourth_section/description.php",
                        ],
                        false
                    ); ?>
                </div>
                <div class="col-12 col-sm-6">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => "/include/delivery/fourth_section/text.php",
                        ],
                        false
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
