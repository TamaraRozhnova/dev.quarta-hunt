<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;
use General\User;
use Personal\Favorites;
use Personal\Basket;

$asset = Asset::getInstance();
global $APPLICATION;
$APPLICATION->IncludeFile('functions.php');

$user = new User();
$isAuthorized = $user->IsAuthorized();

$favorites = new Favorites();
$basket = new Basket();
$favoritesCount = $favorites->getFavoritesCount();
$compareItems = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'];

if (
    !empty($compareItems)
    &&
    is_array($compareItems)
) {
    $compareCount = count($compareItems);
} else {
    $compareCount = 0;
}

$basketItemsCount = $basket->getProductsCount();

define("SITE_SERVER_PROTOCOL", (CMain::IsHTTPS()) ? "https://" : "http://");
$curPage = $APPLICATION->GetCurPage();
?>
<!doctype html>
<html 
    lang="ru"
    class="<?=$APPLICATION->ShowProperty('not-found-page')?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, width=device-width, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title><? $APPLICATION->ShowTitle(false); ?></title>
    <?
    // SEO w3org, вместо $APPLICATION->ShowHead();
    $APPLICATION->ShowMeta("robots", false, false);
    $APPLICATION->ShowMeta("description", false, false);
    $APPLICATION->ShowLink("canonical", null, false);
    $APPLICATION->ShowCSS(true, false);
    $APPLICATION->ShowHeadStrings();
    $APPLICATION->ShowHeadScripts();

    $asset->addCss(SITE_TEMPLATE_PATH . "/assets/fonts/stylesheet.css");
    $asset->addCss(SITE_TEMPLATE_PATH . "/assets/libs/styles/swiper.min.css");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/swiper.min.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/jsCookie.min.js");
    $asset->addCss(SITE_TEMPLATE_PATH . "/assets/libs/styles/perfect-scrollbar.min.css");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/perfectScrollbar.min.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/popperJs.min.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/inputMask.min.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/sharer.min.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/useGesture.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/libs/scripts/fslightbox.js");
    $asset->addJs(SITE_TEMPLATE_PATH . "/assets/build/main.js");
    $APPLICATION->AddHeadString('<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>',true);
    $APPLICATION->AddHeadString('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js" type="text/javascript"></script>',true);
    ?>

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/svg" sizes="120x120" href="/favicon_120.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <meta property="og:url" content="<?=SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . $curPage?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?$APPLICATION->ShowProperty("title")?>">
    <meta property="og:description" content="<?=$APPLICATION->ShowProperty("description")?>">
    <meta property="og:image" content="<?=$APPLICATION->ShowProperty("og:image", SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . "/upload/logo_og.png")?>">

    <script>
        window.isAuth = '<?= boolval($isAuthorized) ?>';
        window.favoritesCount = <?= $favoritesCount ?>;
        window.compareCount = <?= $compareCount ?>;
        window.basketItemsCount = <?= $basketItemsCount ?>;
    </script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-V3D494BEBF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-V3D494BEBF');
</script>

</head>

<body>
<? $APPLICATION->ShowPanel(); ?>

<div class="wrapper">

    
    
    <!-- <div class= "teh-obs">
        <h3>На данный момент на сайте действует авторизация и регистрация только по e-mail</h3>
    </div> -->
    
    


    <header class="header header--desktop">
        <? $APPLICATION->IncludeComponent("bitrix:highloadblock.list", "location_modal", ["BLOCK_ID" => "12"]) ?>
        <div class="container">
            <div class="row header__top-row">
                <div class="header__location col">
                    <a style="display: none;" class="header__city">
                        <svg class="mx-1" width="10" height="14" viewBox="0 0 10 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 0C2.23969 0 0 2.01594 0 4.5C0 8.5 5 14 5 14C5 14 10 8.5 10 4.5C10 2.01594 7.76031 0 5 0ZM5 7C4.60444 7 4.21776 6.8827 3.88886 6.66294C3.55996 6.44318 3.30362 6.13082 3.15224 5.76537C3.00087 5.39991 2.96126 4.99778 3.03843 4.60982C3.1156 4.22186 3.30608 3.86549 3.58579 3.58579C3.86549 3.30608 4.22186 3.1156 4.60982 3.03843C4.99778 2.96126 5.39991 3.00087 5.76537 3.15224C6.13082 3.30362 6.44318 3.55996 6.66294 3.88886C6.8827 4.21776 7 4.60444 7 5C6.99942 5.53026 6.78852 6.03863 6.41357 6.41357C6.03863 6.78852 5.53026 6.99942 5 7Z"
                                  fill="#808D9A"/>
                        </svg>
                        <span>
                            <?= json_decode($_COOKIE['location'])->name ?>
                        </span>
                    </a>
                    <div class="header__spot">
                        <span>
                            Магазины
                            <svg class="icon" width="7" height="5" viewBox="0 0 7 5" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.78724 1.01187e-06L3.30278 2.48446L0.818315 1.43079e-07L-1.43079e-07 0.818315L3.30278 4.12109L6.60556 0.818317L5.78724 1.01187e-06Z"
                                      fill="currentColor"/>
                            </svg>
                        </span>
                        <div class="header__spot-dropdown">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "AREA_FILE_SHOW" => "file",
                                    "PATH" => "/include/header/addresses.php",
                                ],
                                false,
                            ); ?>
                        </div>
                    </div>
                </div>

                <? $APPLICATION->IncludeComponent("bitrix:menu",
                    "menu_horizontal_header",
                    array(
                        "ROOT_MENU_TYPE" => "main_header",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MAX_LEVEL" => "1",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                    )
                ); ?>

                <div class="header__user col">
                    <? if ($isAuthorized) { ?>
                        <a href="/cabinet">
                            <svg class="mx-1" width="12" height="13" viewBox="0 0 12 13" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3.07895C3 4.77647 4.346 6.1579 6 6.1579C7.654 6.1579 9 4.77647 9 3.07895C9 1.38142 7.654 0 6 0C4.346 0 3 1.38142 3 3.07895ZM11.3333 13H12V12.3158C12 9.67542 9.906 7.52632 7.33333 7.52632H4.66667C2.09333 7.52632 0 9.67542 0 12.3158V13H11.3333Z"
                                      fill="#808D9A"/>
                            </svg>
                            <?= getUserFullNameOrEmail() ?>
                        </a>
                        <span>&nbsp;&nbsp;|&nbsp;&nbsp;
                           <a href="<?= $APPLICATION->GetCurPageParam('logout=yes', [
                               "login",
                               "logout",
                               "register",
                               "forgot_password",
                               "change_password"]) ?>"
                           >
                               Выход
                           </a>
                        </span>
                    <? } else { ?>
                        <a href="/login">
                            <svg class="mx-1" width="12" height="13" viewBox="0 0 12 13" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3.07895C3 4.77647 4.346 6.1579 6 6.1579C7.654 6.1579 9 4.77647 9 3.07895C9 1.38142 7.654 0 6 0C4.346 0 3 1.38142 3 3.07895ZM11.3333 13H12V12.3158C12 9.67542 9.906 7.52632 7.33333 7.52632H4.66667C2.09333 7.52632 0 9.67542 0 12.3158V13H11.3333Z"
                                      fill="#808D9A"/>
                            </svg>
                            Личный кабинет
                        </a>
                    <? } ?>
                </div>
            </div>

            <div class="row header__main-row">
                <div class="header__logo-section">
                    <a href="/">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo.svg" class="header__logo" alt="QUARTA">
                    </a>
                </div>

                <?php $APPLICATION->IncludeComponent(
                    'custom:sphinx.search.live',
                    '',
                    []
                ); ?>

                <div class="header__lists-section col">
                    <a href="/compare" class="header__top-item btn-link px-2 mx-2">
                        <span class="position-relative px-1">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 2.42771C0 1.08692 1.08692 0 2.42771 0H15.3755C16.7163 0 17.8032 1.08692 17.8032 2.42771V15.3755C17.8032 16.7163 16.7163 17.8032 15.3755 17.8032H2.42771C1.08692 17.8032 0 16.7163 0 15.3755V2.42771Z" fill="#004989" fill-opacity="0.09"/>
                                <line x1="3" y1="14.167" x2="15" y2="14.167" stroke="#004989"/>
                                <path d="M4.66675 14V7H7.33341V14" stroke="#004989"/>
                                <path d="M7.66675 14L7.66675 4H10.3334V14" stroke="#004989"/>
                                <path d="M10.4666 14.1338L10.4666 8.66712H13.4443V14.0005" stroke="#004989"/>
                            </svg>
                            <span>Сравнение</span>
                            <span class="position-absolute top-0 start-100 translate-middle compare-badge badge bg-secondary"
                                  style="display: <?= $compareCount > 0 ? 'block' : 'none' ?>">
                                <?= $compareCount ?>
                            </span>
                        </span>
                    </a>

                    <a href="/favorites" class="header__top-item btn-link px-2 mx-2">
                        <span class="position-relative px-1 text-primary">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 2.42771C0 1.08692 1.08692 0 2.42771 0H15.3755C16.7163 0 17.8032 1.08692 17.8032 2.42771V15.3755C17.8032 16.7163 16.7163 17.8032 15.3755 17.8032H2.42771C1.08692 17.8032 0 16.7163 0 15.3755V2.42771Z" fill="#004989" fill-opacity="0.09"/>
                                <path d="M8.60803 12.9796L8.60731 12.979C7.3096 11.8247 6.27354 10.9018 5.55589 10.0412C4.84367 9.18702 4.5 8.45711 4.5 7.69755C4.5 6.4721 5.47702 5.5 6.75 5.5C7.47217 5.5 8.17043 5.83219 8.62243 6.35285L9 6.78778L9.37757 6.35285C9.82957 5.83219 10.5278 5.5 11.25 5.5C12.523 5.5 13.5 6.4721 13.5 7.69755C13.5 8.45712 13.1563 9.18705 12.444 10.0419C11.7263 10.9032 10.6904 11.8271 9.39288 12.9837C9.39269 12.9839 9.39249 12.9841 9.39229 12.9843L9.00126 13.3308L8.60803 12.9796Z" stroke="#004989"/>
                            </svg>
                            <span>Избранное</span>
                            <span class="position-absolute top-0 start-100 translate-middle favorites-badge badge bg-secondary"
                                  style="display: <?= $favoritesCount > 0 ? 'block' : 'none' ?>">
                                <?= $favoritesCount ?>
                            </span>
                        </span>
                    </a>

                    <a href="/cart" class="header__top-item btn-link px-2 mx-2">
                        <span class="position-relative px-1 text-primary">
                            <span class="basket-icon-background">
                                <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.1578 9.15255L17.1146 3.89034C17.1311 3.79961 17.1274 3.70636 17.1039 3.61719C17.0804 3.52801 17.0376 3.44509 16.9785 3.37429C16.9194 3.30349 16.8455 3.24653 16.762 3.20744C16.6784 3.16836 16.5873 3.1481 16.4951 3.1481H3.7986L3.41421 1.03399C3.36158 0.743793 3.2087 0.481293 2.98226 0.292313C2.75583 0.103333 2.47021 -0.000123988 2.17528 1.11515e-07H0.75462C0.587634 1.11515e-07 0.427488 0.0663349 0.309411 0.184412C0.191335 0.302488 0.125 0.462634 0.125 0.62962C0.125 0.796606 0.191335 0.956752 0.309411 1.07483C0.427488 1.19291 0.587634 1.25924 0.75462 1.25924H2.1752L4.33606 13.1436C4.02865 13.4143 3.80281 13.7654 3.68391 14.1574C3.565 14.5494 3.55773 14.9667 3.66292 15.3626C3.76811 15.7585 3.98159 16.1172 4.27939 16.3985C4.57718 16.6798 4.9475 16.8725 5.34875 16.9549C5.74999 17.0374 6.16628 17.0063 6.55086 16.8652C6.93543 16.7242 7.27306 16.4787 7.52583 16.1563C7.77859 15.834 7.93649 15.4476 7.98178 15.0405C8.02706 14.6333 7.95795 14.2217 7.7822 13.8516H11.986C11.7814 14.283 11.7225 14.7692 11.8181 15.237C11.9137 15.7048 12.1586 16.1289 12.5161 16.4454C12.8735 16.7619 13.3241 16.9538 13.8 16.9922C14.2759 17.0305 14.7514 16.9132 15.1549 16.658C15.5584 16.4027 15.868 16.0233 16.0373 15.5769C16.2065 15.1304 16.2262 14.6411 16.0933 14.1825C15.9604 13.7239 15.6821 13.3209 15.3004 13.0341C14.9186 12.7474 14.4541 12.5923 13.9766 12.5924H5.51573L5.17227 10.7035H14.2994C14.7418 10.7037 15.1702 10.5486 15.5099 10.2651C15.8495 9.98162 16.0789 9.58786 16.1578 9.15255ZM6.73601 14.7961C6.73601 14.9829 6.68062 15.1655 6.57685 15.3208C6.47307 15.4761 6.32557 15.5971 6.153 15.6686C5.98043 15.7401 5.79053 15.7588 5.60733 15.7224C5.42413 15.6859 5.25585 15.596 5.12377 15.4639C4.99169 15.3318 4.90174 15.1635 4.8653 14.9803C4.82886 14.7971 4.84756 14.6072 4.91904 14.4347C4.99052 14.2621 5.11157 14.1146 5.26688 14.0108C5.42219 13.907 5.60479 13.8516 5.79158 13.8516C6.04198 13.8519 6.28204 13.9515 6.45909 14.1286C6.63615 14.3056 6.73574 14.5457 6.73601 14.7961ZM14.9211 14.7961C14.9211 14.9829 14.8657 15.1655 14.7619 15.3208C14.6581 15.4761 14.5106 15.5971 14.3381 15.6686C14.1655 15.7401 13.9756 15.7588 13.7924 15.7224C13.6092 15.6859 13.4409 15.596 13.3088 15.4639C13.1767 15.3318 13.0868 15.1635 13.0504 14.9803C13.0139 14.7971 13.0326 14.6072 13.1041 14.4347C13.1756 14.2621 13.2966 14.1146 13.4519 14.0108C13.6073 13.907 13.7898 13.8516 13.9766 13.8516C14.227 13.8519 14.4671 13.9515 14.6442 14.1286C14.8212 14.3056 14.9208 14.5457 14.9211 14.7961ZM4.02754 4.40734H15.7407L14.9189 8.92738C14.8925 9.07246 14.8161 9.20369 14.7029 9.29817C14.5897 9.39264 14.4469 9.44436 14.2995 9.4443H4.94332L4.02754 4.40734Z"
                                          fill="currentColor"/>
                                </svg>
                            </span>
                            <span>Корзина</span>
                            <span class="position-absolute top-0 start-100 translate-middle basket-badge badge bg-secondary"
                                  style="display: <?= $basketItemsCount > 0 ? 'block' : 'none' ?>">
                                <?= $basketItemsCount ?>
                            </span>
                        </span>
                    </a>
                </div>
            </div>

            <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "mega_sections_menu", [
                "ADD_SECTIONS_CHAIN" => "N",
                "CACHE_GROUPS" => "N",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COUNT_ELEMENTS" => "Y",
                "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                "IBLOCK_ID" => "16",
                "IBLOCK_TYPE" => "1c_catalog",
                "SECTION_CODE" => "",
                "SECTION_FIELDS" => [
                    0 => "ID",
                    1 => "CODE",
                    2 => "XML_ID",
                    3 => "NAME",
                    4 => "SORT",
                    5 => "DESCRIPTION",
                    6 => "PICTURE",
                    7 => "DETAIL_PICTURE",
                    8 => "IBLOCK_TYPE_ID",
                    9 => "IBLOCK_ID",
                    10 => "IBLOCK_CODE",
                    11 => "IBLOCK_EXTERNAL_ID",
                    12 => "",
                ],
                "SECTION_USER_FIELDS" => [
                    0 => "UF_ICON",
                    1 => "UF_BRAND_LINK"
                ],
                "SECTION_ID" => false,
                "SECTION_URL" => "#SECTION_CODE_PATH#/",
                "SHOW_PARENT_NAME" => "N",
                "TOP_DEPTH" => "3",
                "VIEW_MODE" => "LIST",
                "ELEMENT_SORT_FIELD" => "SORT",
                "ELEMENT_SORT_ORDER" => "ASC",
            ],
                false
            )?>

        </div>
    </header>

    <header class="header header--mobile">
        <a class="header__logo-mobile" href="/">
            <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo.svg" class="header__logo mb-3" alt="QUARTA" >
        </a>
        <div class="row">
            <div class="header__logo-section col">
                <a href="/">
                    <img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo.svg" class="header__logo" alt="QUARTA" >
                </a>
            </div>

            <?php $APPLICATION->IncludeComponent(
                'custom:sphinx.search.live',
                '',
                ['MOBILE' => 'Y']
            ); ?>

            <div class="header__actions col">
                <button class="btn btn-light text-primary p-2 header__button-mobile">
                    <span class="position-relative px-1">
                        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 13H17M1 1H17H1ZM1 7H9H1Z" stroke="#004989" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </button>

                <button class="btn btn-link p-2 ms-2 header__button-contacts">
                    <span class="position-relative px-1">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4873 13.9547L13.4223 10.2587C13.2301 10.084 12.9776 9.9909 12.7181 9.99892C12.4585 10.0069 12.2123 10.1155 12.0313 10.3017L9.63828 12.7627C9.06228 12.6527 7.90428 12.2917 6.71228 11.1027C5.52028 9.90969 5.15928 8.74869 5.05228 8.17669L7.51128 5.78269C7.69769 5.60182 7.80642 5.35551 7.81444 5.0959C7.82247 4.83628 7.72917 4.58373 7.55428 4.39169L3.85928 0.327692C3.68432 0.135049 3.44116 0.0181963 3.18143 0.00195179C2.92171 -0.0142928 2.66588 0.0713504 2.46828 0.240692L0.298282 2.10169C0.125393 2.27521 0.0222015 2.50614 0.00828196 2.75069C-0.00671804 3.00069 -0.292718 8.92269 4.29928 13.5167C8.30528 17.5217 13.3233 17.8147 14.7053 17.8147C14.9073 17.8147 15.0313 17.8087 15.0643 17.8067C15.3088 17.793 15.5396 17.6894 15.7123 17.5157L17.5723 15.3447C17.7423 15.1477 17.8286 14.8921 17.8127 14.6324C17.7968 14.3727 17.68 14.1295 17.4873 13.9547Z" fill="currentColor"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <div class="header__contacts">
            <div class="container">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/header/contacts.php",
                    ],
                    false,
                );?>
            </div>
        </div>

        <div class="mobile-nav">
            <a class="mobile-nav__close"></a>
            <a class="mobile-nav__back"></a>
            <div class="mobile-nav__header">Меню</div>

            <div class="mobile-nav__body">
                <?/*$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => "/include/header/main_links_mobile.php",
                    ],
                    false,
                );*/?>

                <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "mega_sections_menu_mobile", [
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_GROUPS" => "N",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COUNT_ELEMENTS" => "Y",
                    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                    "IBLOCK_ID" => "16",
                    "IBLOCK_TYPE" => "1c_catalog",
                    "SECTION_CODE" => "",
                    "SECTION_FIELDS" => [
                        0 => "ID",
                        1 => "CODE",
                        2 => "XML_ID",
                        3 => "NAME",
                        4 => "SORT",
                        5 => "DESCRIPTION",
                        6 => "PICTURE",
                        7 => "DETAIL_PICTURE",
                        8 => "IBLOCK_TYPE_ID",
                        9 => "IBLOCK_ID",
                        10 => "IBLOCK_CODE",
                        11 => "IBLOCK_EXTERNAL_ID",
                        12 => "",
                    ],
                    "SECTION_ID" => false,
                    "SECTION_URL" => "#SECTION_CODE_PATH#/",
                    "SHOW_PARENT_NAME" => "N",
                    "TOP_DEPTH" => "3",
                    "VIEW_MODE" => "LIST",
                ],
                    false
                )?>

                <?/*$APPLICATION->IncludeComponent("bitrix:menu",
                    "menu_vertical_header_mobile",
                    array(
                        "ROOT_MENU_TYPE" => "main_header_mobile",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "N",
                        "MAX_LEVEL" => "1",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                    )
                );*/?>
            </div>
        </div>

        <div class="header__bottom">
            <a class="header__bottom-item" href="/">
                <div class="header__bottom-icon">
                    <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2044 0L21.2837 9.19176L20.1585 10.317L18.5578 8.86529V19.2076L17.7655 20H13.0111L12.2187 19.2076V13.6609H9.04913V19.2076L8.25674 20H3.50238L2.70998 19.2076V8.87797L1.1252 10.317L0 9.19176L10.0634 0H11.2044ZM4.29477 7.4374V18.4152H7.46434V12.8685L8.25674 12.0761H13.0111L13.8035 12.8685V18.4152H16.9731V7.42789L10.6339 1.67987L4.29477 7.4374Z" fill="currentColor"/>
                    </svg>
                </div>
                <span>Главная</span>
            </a>

            <a class="header__bottom-item" href="/catalog">
                <div class="header__bottom-icon">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="21" height="21" rx="5" fill="#E8EFF4" />
                        <path d="M8.94189 6.97754H15.9871" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8.94189 10.498H13.3451" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8.94189 14.0225H15.9871" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.2992 7.85797C6.73952 7.85797 7.17984 7.41765 7.17984 6.97732C7.17984 6.537 6.73952 6.09668 6.2992 6.09668C5.85888 6.09668 5.41943 6.537 5.41943 6.97732C5.41943 7.41765 5.85888 7.85797 6.2992 7.85797ZM6.2992 11.3806C6.73952 11.3806 7.17984 10.9402 7.17984 10.4999C7.17984 10.0596 6.73952 9.61926 6.2992 9.61926C5.85888 9.61926 5.41943 10.0596 5.41943 10.4999C5.41943 10.9402 5.85888 11.3806 6.2992 11.3806ZM6.2992 14.9031C6.73952 14.9031 7.17984 14.4628 7.17984 14.0225C7.17984 13.5822 6.73952 13.1418 6.2992 13.1418C5.85888 13.1418 5.41943 13.5822 5.41943 14.0225C5.41943 14.4628 5.85888 14.9031 6.2992 14.9031Z" fill="currentColor" />
                    </svg>
                    <?/*div class="header__bottom-badge compare-badge" style="display: <?= $compareCount > 0 ? 'flex' : 'none' ?>">
                        <?= $compareCount ?>
                    </div*/?>
                </div>
                <span>Каталог</span>
            </a>

            <a class="header__bottom-item" href="/cart">
                <div class="header__bottom-icon">
                    <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1578 9.15255L17.1146 3.89034C17.1311 3.79961 17.1274 3.70636 17.1039 3.61719C17.0804 3.52801 17.0376 3.44509 16.9785 3.37429C16.9194 3.30349 16.8455 3.24653 16.762 3.20744C16.6784 3.16836 16.5873 3.1481 16.4951 3.1481H3.7986L3.41421 1.03399C3.36158 0.743793 3.2087 0.481293 2.98226 0.292313C2.75583 0.103333 2.47021 -0.000123988 2.17528 1.11515e-07H0.75462C0.587634 1.11515e-07 0.427488 0.0663349 0.309411 0.184412C0.191335 0.302488 0.125 0.462634 0.125 0.62962C0.125 0.796606 0.191335 0.956752 0.309411 1.07483C0.427488 1.19291 0.587634 1.25924 0.75462 1.25924H2.1752L4.33606 13.1436C4.02865 13.4143 3.80281 13.7654 3.68391 14.1574C3.565 14.5494 3.55773 14.9667 3.66292 15.3626C3.76811 15.7585 3.98159 16.1172 4.27939 16.3985C4.57718 16.6798 4.9475 16.8725 5.34875 16.9549C5.74999 17.0374 6.16628 17.0063 6.55086 16.8652C6.93543 16.7242 7.27306 16.4787 7.52583 16.1563C7.77859 15.834 7.93649 15.4476 7.98178 15.0405C8.02706 14.6333 7.95795 14.2217 7.7822 13.8516H11.986C11.7814 14.283 11.7225 14.7692 11.8181 15.237C11.9137 15.7048 12.1586 16.1289 12.5161 16.4454C12.8735 16.7619 13.3241 16.9538 13.8 16.9922C14.2759 17.0305 14.7514 16.9132 15.1549 16.658C15.5584 16.4027 15.868 16.0233 16.0373 15.5769C16.2065 15.1304 16.2262 14.6411 16.0933 14.1825C15.9604 13.7239 15.6821 13.3209 15.3004 13.0341C14.9186 12.7474 14.4541 12.5923 13.9766 12.5924H5.51573L5.17227 10.7035H14.2994C14.7418 10.7037 15.1702 10.5486 15.5099 10.2651C15.8495 9.98162 16.0789 9.58786 16.1578 9.15255ZM6.73601 14.7961C6.73601 14.9829 6.68062 15.1655 6.57685 15.3208C6.47307 15.4761 6.32557 15.5971 6.153 15.6686C5.98043 15.7401 5.79053 15.7588 5.60733 15.7224C5.42413 15.6859 5.25585 15.596 5.12377 15.4639C4.99169 15.3318 4.90174 15.1635 4.8653 14.9803C4.82886 14.7971 4.84756 14.6072 4.91904 14.4347C4.99052 14.2621 5.11157 14.1146 5.26688 14.0108C5.42219 13.907 5.60479 13.8516 5.79158 13.8516C6.04198 13.8519 6.28204 13.9515 6.45909 14.1286C6.63615 14.3056 6.73574 14.5457 6.73601 14.7961ZM14.9211 14.7961C14.9211 14.9829 14.8657 15.1655 14.7619 15.3208C14.6581 15.4761 14.5106 15.5971 14.3381 15.6686C14.1655 15.7401 13.9756 15.7588 13.7924 15.7224C13.6092 15.6859 13.4409 15.596 13.3088 15.4639C13.1767 15.3318 13.0868 15.1635 13.0504 14.9803C13.0139 14.7971 13.0326 14.6072 13.1041 14.4347C13.1756 14.2621 13.2966 14.1146 13.4519 14.0108C13.6073 13.907 13.7898 13.8516 13.9766 13.8516C14.227 13.8519 14.4671 13.9515 14.6442 14.1286C14.8212 14.3056 14.9208 14.5457 14.9211 14.7961ZM4.02754 4.40734H15.7407L14.9189 8.92738C14.8925 9.07246 14.8161 9.20369 14.7029 9.29817C14.5897 9.39264 14.4469 9.44436 14.2995 9.4443H4.94332L4.02754 4.40734Z" fill="currentColor"/>
                    </svg>
                    <div class="header__bottom-badge basket-badge" style="display: <?= $basketItemsCount > 0 ? 'flex' : 'none' ?>">
                        <?= $basketItemsCount ?>
                    </div>
                </div>
                <span>Корзина</span>
            </a>

            <a class="header__bottom-item" href="/favorites">
                <div class="header__bottom-icon">
                    <svg width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.5625 17C9.44127 17 9.32207 16.9689 9.2163 16.9097C8.84 16.699 0 11.6754 0 5.3125C0.000370456 4.19774 0.351292 3.11131 1.00311 2.20696C1.65492 1.30262 2.57463 0.626144 3.63207 0.273271C4.68951 -0.0796019 5.83115 -0.0910058 6.89543 0.240673C7.95972 0.572352 8.89275 1.23032 9.5625 2.12146C10.2322 1.23032 11.1653 0.572352 12.2296 0.240673C13.2938 -0.0910058 14.4355 -0.0796019 15.4929 0.273271C16.5504 0.626144 17.4701 1.30262 18.1219 2.20696C18.7737 3.11131 19.1246 4.19774 19.125 5.3125C19.125 8.01878 17.5566 10.8025 14.4635 13.5864C13.0604 14.844 11.5345 15.9574 9.90861 16.9097C9.80287 16.9689 9.68369 17 9.5625 17ZM5.3125 1.41667C4.27962 1.41784 3.28938 1.82867 2.55902 2.55903C1.82867 3.28938 1.41784 4.27962 1.41667 5.3125C1.41667 10.204 7.96698 14.496 9.56223 15.4682C11.1569 14.4949 17.7083 10.1967 17.7083 5.3125C17.7081 4.41208 17.396 3.53952 16.8252 2.84317C16.2543 2.14683 15.4599 1.66967 14.577 1.49281C13.6941 1.31596 12.7773 1.45033 11.9822 1.87308C11.1872 2.29583 10.5632 2.98086 10.2161 3.81172C10.1623 3.94067 10.0715 4.0508 9.95516 4.12827C9.83886 4.20573 9.70224 4.24706 9.5625 4.24706C9.42276 4.24706 9.28614 4.20573 9.16984 4.12827C9.05353 4.0508 8.96274 3.94067 8.90888 3.81172C8.61354 3.10155 8.1142 2.49493 7.47403 2.06861C6.83386 1.64228 6.08163 1.4154 5.3125 1.41667Z" fill="currentColor"/>
                    </svg>
                    <div class="header__bottom-badge favorites-badge" style="display: <?= $favoritesCount > 0 ? 'flex' : 'none' ?>">
                        <?= $favoritesCount ?>
                    </div>
                </div>
                <span>Избранное</span>
            </a>

            <a class="header__bottom-item" href="<?= $isAuthorized ? '/cabinet' : '/login' ?>">
                <div class="header__bottom-icon">
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.7831 4.28577C10.0767 4.28577 9.38624 4.49523 8.79892 4.88766C8.2116 5.28009 7.75384 5.83788 7.48353 6.49047C7.21322 7.14306 7.14249 7.86116 7.2803 8.55395C7.4181 9.24673 7.75825 9.8831 8.25772 10.3826C8.75719 10.882 9.39356 11.2222 10.0863 11.36C10.7791 11.4978 11.4972 11.4271 12.1498 11.1568C12.8024 10.8865 13.3602 10.4287 13.7526 9.84137C14.1451 9.25406 14.3545 8.56356 14.3545 7.85719C14.3545 6.90999 13.9783 6.00159 13.3085 5.33181C12.6387 4.66204 11.7303 4.28577 10.7831 4.28577ZM10.7831 10.0001C10.3593 10.0001 9.94498 9.87437 9.59259 9.63892C9.2402 9.40345 8.96555 9.06879 8.80336 8.67723C8.64117 8.28567 8.59873 7.85482 8.68142 7.43914C8.7641 7.02347 8.96819 6.64165 9.26787 6.34197C9.56755 6.04228 9.94938 5.83819 10.365 5.75551C10.7807 5.67283 11.2116 5.71527 11.6031 5.87745C11.9947 6.03964 12.3294 6.3143 12.5648 6.66669C12.8003 7.01908 12.926 7.43338 12.926 7.85719C12.9254 8.42534 12.6994 8.97006 12.2977 9.3718C11.896 9.77354 11.3512 9.99948 10.7831 10.0001Z" fill="currentColor"/>
                        <path d="M10.7832 0C8.80539 0 6.87199 0.58649 5.2275 1.6853C3.58301 2.78412 2.30129 4.3459 1.54441 6.17316C0.787536 8.00043 0.589503 10.0111 0.975355 11.9509C1.36121 13.8907 2.31361 15.6725 3.71214 17.0711C5.11066 18.4696 6.89249 19.422 8.8323 19.8078C10.7721 20.1937 12.7828 19.9957 14.61 19.2388C16.4373 18.4819 17.9991 17.2002 19.0979 15.5557C20.1967 13.9112 20.7832 11.9778 20.7832 10C20.7802 7.34876 19.7256 4.80698 17.8509 2.93227C15.9762 1.05756 13.4344 0.0030248 10.7832 0ZM6.49749 17.4121V16.4286C6.49806 15.8604 6.72401 15.3157 7.12575 14.914C7.52749 14.5122 8.0722 14.2863 8.64035 14.2857H12.9261C13.4942 14.2863 14.0389 14.5122 14.4407 14.914C14.8424 15.3157 15.0684 15.8604 15.0689 16.4286V17.4121C13.7683 18.1716 12.2893 18.5718 10.7832 18.5718C9.27712 18.5718 7.79809 18.1716 6.49749 17.4121ZM16.4918 16.3757C16.4775 15.4388 16.0958 14.545 15.4289 13.8868C14.7619 13.2287 13.8631 12.8589 12.9261 12.8571H8.64035C7.70334 12.8589 6.80452 13.2287 6.13756 13.8868C5.47059 14.545 5.08887 15.4388 5.07464 16.3757C3.77932 15.2191 2.86587 13.6963 2.45523 12.009C2.04459 10.3218 2.15614 8.54953 2.77509 6.92704C3.39405 5.30455 4.49122 3.90833 5.92133 2.92326C7.35144 1.93819 9.04702 1.41073 10.7836 1.41073C12.5201 1.41073 14.2157 1.93819 15.6458 2.92326C17.0759 3.90833 18.1731 5.30455 18.792 6.92704C19.411 8.54953 19.5225 10.3218 19.1119 12.009C18.7013 13.6963 17.7878 15.2191 16.4925 16.3757H16.4918Z" fill="currentColor"/>
                    </svg>
                </div>
                <span>Моя Quarta</span>
            </a>
        </div>
    </header>
    <main>
        <? if (showBreadcrumb()) { ?>
            <div class="breadcrumb-wrapper">
                <div class="container">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb", "", array(
                            "START_FROM" => CSite::InDir('/catalog/') ? '1' : '0',
                            "PATH" => "",
                            "SITE_ID" => "s1"
                        )
                    ); ?>
                </div>
            </div>
        <? } ?>

        <? checkRequestLogout() ?>