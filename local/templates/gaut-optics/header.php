<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;
global $USER;

if(isset($arUser) and isset($arUser['UF_FAVORITES'])){
    $GLOBALS["FAVOURITES"] = $arUser['UF_FAVORITES'];
}

$APPLICATION->IncludeFile('functions.php');

?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
	<?php $APPLICATION->ShowHead(); ?>
	<title><?php $APPLICATION->ShowTitle(true); ?></title>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
	<meta name="theme-color" content="#fff">
	<meta name="format-detection" content="telephone=no">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <?
    $assets = \Bitrix\Main\Page\Asset::getInstance();

    // CSS
    $assets->addCss(SITE_TEMPLATE_PATH . '/css/swiper.min.css');

    // JS
    $assets->addJs(SITE_TEMPLATE_PATH . '/js/jquery-3.7.1.min.js');
    //$assets->addJs(SITE_TEMPLATE_PATH . '/js/modals.js');

    $assets->addJs(SITE_TEMPLATE_PATH . '/js/app.js');
    $assets->addJs(SITE_TEMPLATE_PATH . '/js/script.js');
    ?>





</head>
<body>
    <? $APPLICATION->ShowPanel(); ?>



    <header class="header">
        <div class="container header__container">
            <div class="header__inner">
                <div class="header__left">
                    <div class="header__logo header__item">
                        <div class="header__mobile-menu" data-modal-open="mobile-menu">
                          <span class="catalog-link-icon">
                            <span class="line line--top"></span>
                            <span class="line line--middle"></span>
                            <span class="line line--bottom"></span>
                          </span>
                        </div>
                        <a href="/" class="logo">
                            <img alt="gaut-optics.com" src="/local/templates/gaut-optics/images/gaut.svg" >
                        </a>
                    </div>
                    <div class="header__item header__catalog">
                        <button class="catalog-link catalog-menu link-modal-another" data-modal-open="catalog">
                              <span class="catalog-link-icon">
                                <span class="line line--top"></span>
                                <span class="line line--middle"></span>
                                <span class="line line--bottom"></span>
                              </span>
                            <span class="catalog-link-text"> Каталог </span>
                        </button>
                    </div>
                    <div class="header__navigation">
                        <div class="menu__wrapper">
                            <div class="bigblock">

                                    <nav class="header__navigation">
                                        <a href="/about/" >О компании</a>
                                        <a href="/about/delivery/" >Доставка и оплата</a>
                                        <a href="/about/contacts/" >Контакты</a>
                                    </nav>

                                <div class="subblock ">
                                    <div class="search">
                                        <form method="get" action="/catalog/" autocomplete="off">
                                            <button class="btn" type="submit" >
                                                <div class="icon lupa">
                                                    <img src="/local/templates/gaut-optics/images/head_search.svg" alt="search">
                                                </div>
                                            </button>
                                            <div class="catalog__search ajaxsearch__wrapper" id="ajaxsearch_id_header">
                                                <div class="input-wrapper">
                                                    <input type="text" class="search-input ajaxsearch__input" placeholder="Введите запрос для поиска" name="q" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="icon cross">
                                                <a href="#" class="close__search"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.45597 0.100422L0.0993155 1.45708C-0.0212764 1.57767 -0.0212768 1.69827 0.099315 1.81886L7.19916 8.9187L0.461617 15.6562C0.341026 15.7768 0.341026 15.8974 0.461618 16.018L1.81828 17.3747C1.93887 17.4953 2.05946 17.4953 2.18005 17.3747L8.91759 10.6371L16.0174 17.737C16.138 17.8576 16.2586 17.8576 16.3792 17.737L17.7359 16.3803C17.8565 16.2597 17.8565 16.1391 17.7359 16.0185L10.636 8.9187L17.3746 2.1801C17.4952 2.05951 17.4952 1.93892 17.3746 1.81832L16.018 0.461665C15.8974 0.341074 15.7768 0.341072 15.6562 0.461665L8.91759 7.20026L1.81775 0.100422C1.69716 -0.0201698 1.57657 -0.0201701 1.45597 0.100422Z" fill="#2A2B2B" fill-opacity="0.85"></path></svg></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="icon lupa">
                                <a href="#" class="close__search">
                                    <img src="/local/templates/gaut-optics/images/head_search.svg" alt="search">
                                </a>
                            </div>

                            <div class="soc">
                                <div class="item">
                                    <a href="https://vk.com/#" rel="nofollow" target="_blank"><div class="soc-logo soc-logo-vk"></div></a>
                                </div>
                                <div class="item">
                                    <a href="https://t.me/#"  rel="nofollow" target="_blank"><div class="soc-logo soc-logo-tg"></div></a>
                                </div>
                            </div>                        </div>
                    </div>
                </div>
                <div class="header__right">
                    <div class="header__actions">


                        <a href="/compare" class="header__top-item btn btn-link px-2 mx-2 header__compare">
                            <div class="position-relative px-1">
                                <img src="/local/templates/gaut-optics/images/head_compare.svg" alt="compare">
                                <span class="compare-badge badge-" style="display:none"></span>
                            </div>
                        </a>
                        <a href="#" class="header__profile" data-modal-open="profile">
                            <img src="/local/templates/gaut-optics/images/head_lk.svg" alt="profile">
                        </a>



                        <a href="#" class="header__cart" data-modal-open="cart">
                            Корзина: <span data-cart-count=""><?php $APPLICATION->ShowViewContent( 'BASKET_PRODUCT_COUNT' ) ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <? if (showBreadcrumb()) { ?>
        <div class="container">
            <div class="breadcrumbs">
                <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => SITE_ID
                ),
                    false
                );?>
            </div>
        </div>
    <? } ?>
<?php
$APPLICATION->IncludeFile( "/_includes/_modal.php" );
?>