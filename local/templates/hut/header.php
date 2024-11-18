<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;
use Helpers\IblockHelper;
use Personal\Favorites;

global $APPLICATION;

$user = new CUser;
$isAuth = $user->isAuthorized();

$favorites = new Favorites(IblockHelper::getIdByCode("hutfavorites"), HUT_FAVORITES_COOCKIE_NAME);
$favoritesCount = $favorites->getFavoritesCount();

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
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/normalize.css") ?>
    <? Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/style.css") ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/jsCookie.min.js"); ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/script.js"); ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/request.js"); ?>
    <? Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/favoritesApi.js"); ?>

    <? $APPLICATION->AddHeadString('<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>', true); ?>
    <? $APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" type="text/javascript"></script>', true); ?>
    <? $APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js" type="text/javascript"></script>', true); ?>

    <script>
        window.isAuth = '<?= boolval($isAuth) ?>';
        window.favoritesCount = <?= $favoritesCount ?>;
    </script>
</head>

<body>
    <? $APPLICATION->ShowPanel(); ?>
    <? if ($APPLICATION->getCurPage() == '/') {
        $APPLICATION->IncludeComponent(
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
        );
    } ?>
    <header class="header">
        <div class="menu__wrap <?php $APPLICATION->ShowProperty('headerClasses', 'scroll') ?>">
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
                    <a id="search_opener" href="#" class="menu__dop-link"><?= buildSVG('search', SITE_TEMPLATE_PATH . ICON_PATH) ?></a>
                    <a href="/favorites/" class="menu__dop-link menu__dop-link--favorites"><?= buildSVG('favorite', SITE_TEMPLATE_PATH . ICON_PATH) ?><span style="display: <?= $favoritesCount > 0 ? 'flex' : 'none' ?>"><?= $favoritesCount ?></span></a>
                    <? if ($isAuth) { ?>
                        <a href="/personal/" class="menu__dop-link"><?= buildSVG('user', SITE_TEMPLATE_PATH . ICON_PATH) ?></a>
                    <? } else { ?>
                        <a href="#auth" rel="modal:open" class="menu__dop-link"><?= buildSVG('user', SITE_TEMPLATE_PATH . ICON_PATH) ?></a>
                    <? } ?>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:sale.basket.basket.line",
                        "line",
                        array(
                            "HIDE_ON_BASKET_PAGES" => "N",
                            "PATH_TO_AUTHORIZE" => "",
                            "PATH_TO_BASKET" => SITE_DIR . "cart/",
                            "PATH_TO_ORDER" => SITE_DIR . "cart/purchase/",
                            "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                            "PATH_TO_PROFILE" => SITE_DIR . "personal/",
                            "PATH_TO_REGISTER" => SITE_DIR . "login/",
                            "POSITION_FIXED" => "N",
                            "SHOW_AUTHOR" => "N",
                            "SHOW_EMPTY_VALUES" => "N",
                            "SHOW_NUM_PRODUCTS" => "Y",
                            "SHOW_PERSONAL_LINK" => "N",
                            "SHOW_PRODUCTS" => "N",
                            "SHOW_REGISTRATION" => "N",
                            "SHOW_TOTAL_PRICE" => "N",
                        ),
                        false
                    ); ?>
                </div>
            </div>
        </div>
        <? $APPLICATION->IncludeComponent(
            "arturgolubev:search.title",
            "header",
            array(
                "ANIMATE_HINTS" => array(""),
                "ANIMATE_HINTS_SPEED" => "1",
                "CATEGORY_0" => array("iblock_hut"),
                "CATEGORY_0_TITLE" => "",
                "CATEGORY_0_iblock_hut" => IblockHelper::getIdByCode('hutcatalog'),
                "CHECK_DATES" => "Y",
                "CONTAINER_ID" => "smart-title-search",
                "CONVERT_CURRENCY" => "N",
                "FILTER_NAME" => "",
                "INPUT_ID" => "smart-title-search-input",
                "INPUT_PLACEHOLDER" => "Я ищу ...",
                "NUM_CATEGORIES" => "1",
                "ORDER" => "rank",
                "PAGE" => "/catalog/",
                "PREVIEW_HEIGHT_NEW" => "",
                "PREVIEW_WIDTH_NEW" => "",
                "PRICE_CODE" => array("BASE"),
                "PRICE_VAT_INCLUDE" => "Y",
                "SHOW_HISTORY" => "N",
                "SHOW_HISTORY_POPUP" => "N",
                "SHOW_INPUT" => "Y",
                "SHOW_LOADING_ANIMATE" => "N",
                "SHOW_PREVIEW" => "Y",
                "SHOW_PREVIEW_TEXT" => "N",
                "SHOW_PROPS" => array('TYPE', 'FULL_PREVIEW'),
                "SHOW_QUANTITY" => "N",
                "TOP_COUNT" => "5",
                "USE_LANGUAGE_GUESS" => "Y",
                "VOICE_INPUT" => "N"
            )
        ); ?>
    </header>
    <main>
        <? $APPLICATION->ShowViewContent('catalog_banner'); ?>