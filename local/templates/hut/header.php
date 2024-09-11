<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;
use Helpers\IblockHelper;

global $APPLICATION;

?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><? $APPLICATION->ShowTitle(false); ?></title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/manifest.webmanifest">

    <? $APPLICATION->ShowHead(); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,400..700&display=swap" rel="stylesheet">

    <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/normalize.css") ?>
    <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/style.css") ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/script.js"); ?>
</head>

<body>
    <? $APPLICATION->ShowPanel(); ?>
    <? $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "header-string",
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
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "N",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "FIELD_CODE" => array("NAME", ""),
            "FILTER_NAME" => "",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "IBLOCK_ID" => IblockHelper::getIdByCode('headerString'),
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
            "PROPERTY_CODE" => array("", ""),
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
    <header class="header">
        <div class="menu__wrap scroll">
            <div class="menu__inner">
                <button type="button" class="button menu-toggler"><?= buildSVG('burger', SITE_TEMPLATE_PATH . ICON_PATH) ?></button>
                <div class="menu__overlay" style="display: none"></div>
                <div class="menu__catalog" style="display: none">
                    <div class="menu__catalog-inner">
                        <button type="button" class="button mobile-menu-toggler"><?= buildSVG('close', SITE_TEMPLATE_PATH . ICON_PATH) ?> каталог</button>
                        <div class="menu__catalog-menu">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "catalog",
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "3",
                                    "MENU_CACHE_GET_VARS" => array(""),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "N",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "catalog",
                                    "USE_EXT" => "N"
                                )
                            ); ?>
                        </div>
                        <div class="menu__activities">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:news.list",
                                "doing-menu",
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
                                    "DISPLAY_DATE" => "N",
                                    "DISPLAY_NAME" => "Y",
                                    "DISPLAY_PICTURE" => "N",
                                    "DISPLAY_PREVIEW_TEXT" => "N",
                                    "DISPLAY_TOP_PAGER" => "N",
                                    "FIELD_CODE" => array("NAME", ""),
                                    "FILTER_NAME" => "",
                                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                                    "IBLOCK_ID" => IblockHelper::getIdByCode('hutdoing'),
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
                </div>
                <div class="menu__left">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top-left",
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
                            "ROOT_MENU_TYPE" => "top_left",
                            "USE_EXT" => "N",
                        ),
                        false
                    ); ?>
                </div>
                <div class="menu__logo">
                    <a href="/" class="menu__index-link">
                        <span class="desktop"><?= buildSVG('logo', SITE_TEMPLATE_PATH . IMG_PATH) ?></span>
                        <span class="mobile"><?= buildSVG('logo-mob', SITE_TEMPLATE_PATH . IMG_PATH) ?></span>
                    </a>
                </div>
                <div class="menu__right">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top-right",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "2",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top_right",
                            "USE_EXT" => "N"
                        )
                    ); ?>
                </div>
                <div class="menu__dop">
                    <a href="#" class="menu__dop-link"><?= buildSVG('search', SITE_TEMPLATE_PATH . ICON_PATH) ?></a>
                    <a href="#" class="menu__dop-link"><?= buildSVG('favorite', SITE_TEMPLATE_PATH . ICON_PATH) ?><span>10</span></a>
                    <a href="#" class="menu__dop-link"><?= buildSVG('user', SITE_TEMPLATE_PATH . ICON_PATH) ?></a>
                    <a href="#" class="menu__dop-link"><?= buildSVG('cart', SITE_TEMPLATE_PATH . ICON_PATH) ?><span>2</span></a>
                </div>
            </div>
        </div>
    </header>
    <main>