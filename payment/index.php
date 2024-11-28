<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Оплата');?>


<div class="payment">
    <div class="jumbotron-vue"
        style="background-image: url('<?= SITE_TEMPLATE_PATH ?>/assets/images/static/payment.jpg');">
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
                    <?=$APPLICATION->ShowTitle()?>
                </h1>
            </div>
        </div>
    </div>

    <div class="bg-white py-5 payment__section">
        <div class="container py-5">
            <div class="row pt-5 pb-0">
                <div class="col-12">
                    <h2 class="h1">
                        Как вы можете оплатить заказ
                    </h2>
                </div>
            </div>

            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "payment",
                Array(
                    "ACTIVE_DATE_FORMAT" => "",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array("", "*", ""),
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => "32",
                    "IBLOCK_TYPE" => "about",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "24",
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
                    "PROPERTY_CODE" => array("", "*", ""),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N"
                )
            );?>

        </div>
    </div>

    <hr class="m-0" >

    <div class="bg-white payment__requisites" >
        <div class="container" >
            <div class="row" >
                <div class="col-12" >
                    <h3 class="mb-4" >Наши реквизиты</h3>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "our_detail_banks",
                        Array(
                            "ACTIVE_DATE_FORMAT" => "",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "",
                            "DISPLAY_BOTTOM_PAGER" => "N",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("", "*", ""),
                            "FILTER_NAME" => "",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => "33",
                            "IBLOCK_TYPE" => "about",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "24",
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
                            "PROPERTY_CODE" => array("", "*", ""),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "ACTIVE_FROM",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "SORT_ORDER2" => "ASC",
                            "STRICT_SECTION_CHECK" => "N"
                        )
                    );?>

                <h3 class="mb-4" >Наши реквизиты</h3>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td class="w-50">Сокращенное наименование</td>
                            <td class="w-50">ООО "ПЕТРОВ ДВОР"</td>
                        </tr>
                        <tr>
                            <td class="w-50">ОГРН</td>
                            <td class="w-50">1247800035878</td>
                        </tr>
                        <tr>
                            <td class="w-50">ИНН</td>
                            <td class="w-50">7813679180</td>
                        </tr>
                        <tr>
                            <td class="w-50">КПП</td>
                            <td class="w-50">781301001</td>
                        </tr>
                        <tr>
                            <td class="w-50">ОКВЭД</td>
                            <td class="w-50">47.78.7</td>
                        </tr>
                        <tr>
                            <td class="w-50">ОКПО</td>
                            <td class="w-50">47377500</td>
                        </tr>
                        <tr>
                            <td class="w-50">Юр. Адрес</td>
                            <td class="w-50">197046, г Санкт-Петербург, ул. наб. Петроградская, д.18, литер А, помещ. 6-н</td>
                        </tr>
                        <tr>
                            <td class="w-50">Почтовый адрес</td>
                            <td class="w-50">197046, г Санкт-Петербург, ул. наб. Петроградская, д.18, литер А, помещ. 6-н</td>
                        </tr>
                        <tr>
                            <td class="w-50">Email</td>
                            <td class="w-50"><a href="mailto:k.kostromina@quarta-hunt.ru">k.kostromina@quarta-hunt.ru</a></td>
                        </tr>
                        <tr>
                            <td class="w-50">Телефон</td>
                            <td class="w-50"><a href="tel:+7 (900) 199-13-66">+7 (900) 199-13-66</a></td>
                        </tr>
                        <tr>
                            <td class="w-50">Ген. Директор</td>
                            <td class="w-50">Костромина Ксения Владимировна</td>
                        </tr>
                        <tr>
                            <td colspan="2">АО «ТБанк» р/с 40702810110001651263 БИК 044525974 к/с 30101810145250000974</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>


</div>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>