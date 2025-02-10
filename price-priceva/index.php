<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle('Quarta Hunt');


?><div class="priceva">
    <div class="container py-5">
        <div class="row my-5 pt-5">
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
            <? $APPLICATION->IncludeComponent("bitrix:news.detail","price_list_priceva", Array(
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
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>