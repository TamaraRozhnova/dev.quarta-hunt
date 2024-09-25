<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Helpers\IblockHelper;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

?>

</main>
<footer class="footer">
    <div class="footer__inner">
        <div class="footer__top">
            <div class="footer__column">
                <div class="footer__logo">
                    <?= buildSVG('logo', SITE_TEMPLATE_PATH . IMG_PATH) ?>
                </div>
                <div class="footer__slogan">
                    <?= Loc::GetMessage("SLOGAN"); ?>
                </div>
                <div class="footer__contacts">
                    <div class="footer__contacts-top">
                        <div class="footer__phone">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/footer/phone.php",
                                ],
                                false,
                            ); ?>
                        </div>
                        <div class="footer__time">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/footer/time.php",
                                ],
                                false,
                            ); ?>
                        </div>
                    </div>
                    <div class="footer__mail">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => "/include/footer/mail.php",
                            ],
                            false,
                        ); ?>
                    </div>
                </div>
                <div class="footer__social">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "footer-social",
                        array(
                            "ACTIVE_DATE_FORMAT" => "d.m.Y",
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
                            "DISPLAY_DATE" => "Y",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "Y",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "FIELD_CODE" => array("ID", ""),
                            "FILTER_NAME" => "",
                            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                            "IBLOCK_ID" => IblockHelper::getIdByCode('htsocial'),
                            "IBLOCK_TYPE" => "hut",
                            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "MESSAGE_404" => "",
                            "NEWS_COUNT" => "20",
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
                            "PROPERTY_CODE" => array("LINK", ""),
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "N",
                            "SET_META_KEYWORDS" => "N",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SORT_BY1" => "SORT",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER1" => "ASC",
                            "SORT_ORDER2" => "ASC",
                            "STRICT_SECTION_CHECK" => "N"
                        )
                    ); ?>
                </div>
            </div>
            <div class="footer__column footer__column--menu">
                <div class="footer__menu-title"><?= Loc::GetMessage("LEFT_MENU_TITLE"); ?></div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "bottom",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "bottom_left",
                        "USE_EXT" => "N",
                    ),
                    false
                ); ?>
            </div>
            <div class="footer__column footer__column--menu">
                <div class="footer__menu-title"><?= Loc::GetMessage("MIDDLE_MENU_TITLE"); ?></div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "bottom",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "bottom_middle",
                        "USE_EXT" => "N",
                    ),
                    false
                ); ?>
            </div>
            <div class="footer__column footer__column--menu">
                <div class="footer__menu-title"><?= Loc::GetMessage("RIGHT_MENU_TITLE"); ?></div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "bottom",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "bottom_right",
                        "USE_EXT" => "N",
                    ),
                    false
                ); ?>
            </div>
            <div class="footer__column">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:subscribe.form",
                    "subscribe-footer",
                    array(
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "PAGE" => "",
                        "SHOW_HIDDEN" => "N",
                        "USE_PERSONALIZATION" => "Y",
                        "COMPONENT_TEMPLATE" => "subscribe-footer"
                    ),
                    false
                ); ?>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__copyright">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/footer/copyright.php",
                    ],
                    false,
                ); ?>
            </div>
            <div class="footer__credits">
                <?= Loc::GetMessage("MADE_IN"); ?>
                <a href="https://addamant.ru"><?= buildSVG('adm', SITE_TEMPLATE_PATH . ICON_PATH) ?></a>
            </div>
        </div>
    </div>
</footer>

<? $APPLICATION->IncludeComponent(
    "bitrix:system.auth.authorize",
    "flat",
    array(),
    false
); ?>

<? $APPLICATION->IncludeComponent(
    "custom:main.register",
    "custom",
    array(
        "AUTH" => "Y",
        "REQUIRED_FIELDS" => array("EMAIL", "NAME", "LAST_NAME", "PERSONAL_PHONE"),
        "SET_TITLE" => "N",
        "SHOW_FIELDS" => array("PERSONAL_PHONE", "NAME", "LAST_NAME", "EMAIL"),
        "SUCCESS_PAGE" => "",
        "USER_PROPERTY" => array("UF_TYPE", "UF_PROMO"),
        "USER_PROPERTY_NAME" => "",
        "USE_BACKURL" => "N"
    )
); ?>

<div class="popup cookie-popup">
    <div class="popup__inner">
        <div class="popup__text">
            <?= Loc::GetMessage("COOKIE_TEXT"); ?>
        </div>
        <button onclick="popup.hide(this)" type="button" class="button popup__close"><?= Loc::GetMessage("OK"); ?></button>
    </div>
</div>
<? if ($APPLICATION->GetPageProperty("need_slider") == 'Y') {
    $APPLICATION->AddHeadString('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>', true);
    $APPLICATION->AddHeadString('<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>', true);
} ?>
</body>

</html>