<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();

if(isset($arUser) and isset($arUser['UF_FAVORITES'])){
    $GLOBALS["FAVOURITES"] = $arUser['UF_FAVORITES'];
}

$APPLICATION->IncludeFile('functions.php');

?><!doctype html>
<html>

<head>
	<meta charset="utf-8"/>
	<?php $APPLICATION->ShowHead(); ?>
	<title><?php $APPLICATION->ShowTitle(true); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="theme-color" content="#fff"/>
	<meta name="format-detection" content="telephone=no"/>
<!--	<meta name="yandex-verification" content="266faedfe7d618bc" />-->
	<link rel="stylesheet" media="all" href="<?=SITE_TEMPLATE_PATH?>/css/style.css?v3"/>
	<link rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.2/style/jquery.jscrollpane.min.css"/>

	<link rel="stylesheet" media="all" href="<?=SITE_TEMPLATE_PATH?>/scss/compiled.css<?=(1?'?tm='.time():'')?>"/>
	<link rel="stylesheet" media="all" href="<?=SITE_TEMPLATE_PATH?>/css/nimda.css<?=(1?'?tm='.time():'')?>"/>



    <?/*?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jScrollPane/2.2.2/script/jquery.jscrollpane.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js" type="text/javascript"></script>



    <link rel="stylesheet" media="all" href="<?=SITE_TEMPLATE_PATH?>/css/bootstrap.min.css"/>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(0, "init", {
        clickmap:false,
        trackLinks:false,
        accurateTrackBounce:false,
        webvisor:false
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/0" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <?*/?>

</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>
<?
if($USER->isAuthorized()){
    echo_j($USER->getLogin(), 'auth');
}else{
    echo_j('', '!auth');
}
?>
<!-- BEGIN content -->
<div class="page">
	<!-- start header -->
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
							<?
							$APPLICATION->IncludeFile('/_includes/logo.php');
							?>
						</a>
					</div>
                    <div class="header__item header__catalog">
                        <button class="catalog-link catalog-menu link-modal-another" data-modal-open="catalog">
                              <span class="catalog-link-icon">
                                <span class="line line--top"></span>
                                <span class="line line--middle"></span>
                                <span class="line line--bottom"></span>
                              </span>
                            <span class="catalog-link-text ui-link ui-link--underline"> Каталог </span>
                        </button>
                    </div>
					<?php /* $APPLICATION->IncludeComponent(
						"bitrix:menu",
						"smart_top",
						[
							"ALLOW_MULTI_SELECT" => "N",
							"CHILD_MENU_TYPE" => "left",
							"DELAY" => "N",
							"MAX_LEVEL" => "1",
							"MENU_CACHE_GET_VARS" => [ "" ],
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"ROOT_MENU_TYPE" => "top",
							"USE_EXT" => "N",
						]
					); */ ?>
                    <nav class="header__navigation">
                        <div class="menu__wrapper">
                            <div class="bigblock">
                                <div class="subblock active">
                                    <div class="men">
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:menu",
                                        "smart_top",
                                        [
                                            "ALLOW_MULTI_SELECT" => "N",
                                            "CHILD_MENU_TYPE" => "left",
                                            "DELAY" => "N",
                                            "MAX_LEVEL" => "1",
                                            "MENU_CACHE_GET_VARS" => [ "" ],
                                            "MENU_CACHE_TIME" => "3600",
                                            "MENU_CACHE_TYPE" => "N",
                                            "MENU_CACHE_USE_GROUPS" => "Y",
                                            "ROOT_MENU_TYPE" => "top",
                                            "USE_EXT" => "N",
                                        ]
                                    );?>
                                    <div class="icon lupa">
                                        <a href="#" class="close__search"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.0574 0.0398782C16.8844 0.358295 19.3027 1.89874 20.7484 4.29548C21.3423 5.28085 21.708 6.28774 21.9231 7.50117C22.035 8.15091 22.0221 9.65263 21.9016 10.3196C21.3853 13.1466 19.7157 15.4272 17.2243 16.718C15.8904 17.4065 14.6813 17.6991 13.1581 17.6948C11.3035 17.6948 9.78026 17.2344 8.2312 16.2103L7.71915 15.8704L4.72431 18.8523C2.70623 20.8661 1.67783 21.8644 1.56165 21.9203C1.32929 22.0279 0.84306 22.0279 0.636518 21.9203C0.120167 21.6492 -0.116495 21.0898 0.0556222 20.5563C0.128773 20.3368 0.287981 20.1647 3.14083 17.3075L6.14858 14.2912L5.81726 13.8007C4.22087 11.4427 3.86803 8.49084 4.862 5.75847C5.18472 4.86346 5.80435 3.82216 6.4756 3.04332C7.59437 1.75244 9.17785 0.749862 10.8001 0.315265C11.7897 0.0484839 13.1322 -0.0676964 14.0574 0.0398782ZM12.5212 2.23437C10.8861 2.41079 9.60814 3.01751 8.46356 4.16209C7.29747 5.32818 6.67784 6.65349 6.52294 8.30581C6.38524 9.78172 6.78111 11.2877 7.65461 12.6001C8.01606 13.1466 8.86804 13.9986 9.41451 14.36C11.6176 15.8273 14.3328 15.9048 16.5746 14.5623C18.1925 13.5984 19.3328 11.9719 19.7071 10.0915C19.8448 9.40306 19.8448 8.31012 19.7071 7.62165C19.3199 5.68102 18.128 4.0287 16.4068 3.05193C15.2579 2.39789 13.8078 2.09238 12.5212 2.23437Z" fill="#2A2B2B"/></svg></a>
                                    </div>
                                    </div>
                                </div>
                                <div class="subblock ">
                                    <div class="search">
                                    <form method="get" action="/search/" autocomplete="off">
                                        <button class="btn" type="submit" style="border: none;background: transparent;">
                                            <div class="icon lupa">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.0574 0.0398782C16.8844 0.358295 19.3027 1.89874 20.7484 4.29548C21.3423 5.28085 21.708 6.28774 21.9231 7.50117C22.035 8.15091 22.0221 9.65263 21.9016 10.3196C21.3853 13.1466 19.7157 15.4272 17.2243 16.718C15.8904 17.4065 14.6813 17.6991 13.1581 17.6948C11.3035 17.6948 9.78026 17.2344 8.2312 16.2103L7.71915 15.8704L4.72431 18.8523C2.70623 20.8661 1.67783 21.8644 1.56165 21.9203C1.32929 22.0279 0.84306 22.0279 0.636518 21.9203C0.120167 21.6492 -0.116495 21.0898 0.0556222 20.5563C0.128773 20.3368 0.287981 20.1647 3.14083 17.3075L6.14858 14.2912L5.81726 13.8007C4.22087 11.4427 3.86803 8.49084 4.862 5.75847C5.18472 4.86346 5.80435 3.82216 6.4756 3.04332C7.59437 1.75244 9.17785 0.749862 10.8001 0.315265C11.7897 0.0484839 13.1322 -0.0676964 14.0574 0.0398782ZM12.5212 2.23437C10.8861 2.41079 9.60814 3.01751 8.46356 4.16209C7.29747 5.32818 6.67784 6.65349 6.52294 8.30581C6.38524 9.78172 6.78111 11.2877 7.65461 12.6001C8.01606 13.1466 8.86804 13.9986 9.41451 14.36C11.6176 15.8273 14.3328 15.9048 16.5746 14.5623C18.1925 13.5984 19.3328 11.9719 19.7071 10.0915C19.8448 9.40306 19.8448 8.31012 19.7071 7.62165C19.3199 5.68102 18.128 4.0287 16.4068 3.05193C15.2579 2.39789 13.8078 2.09238 12.5212 2.23437Z" fill="#2A2B2B"/>
                                                </svg>
                                            </div>
                                        </button>
                                        <div class="catalog__search ajaxsearch__wrapper" id="ajaxsearch_id_header">
                                            <div class="input-wrapper">
                                                <input type="text" class="search-input ajaxsearch__input"  placeholder="Введите запрос для поиска" name="q" value="" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="icon cross">
                                            <a href="#" class="close__search"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.45597 0.100422L0.0993155 1.45708C-0.0212764 1.57767 -0.0212768 1.69827 0.099315 1.81886L7.19916 8.9187L0.461617 15.6562C0.341026 15.7768 0.341026 15.8974 0.461618 16.018L1.81828 17.3747C1.93887 17.4953 2.05946 17.4953 2.18005 17.3747L8.91759 10.6371L16.0174 17.737C16.138 17.8576 16.2586 17.8576 16.3792 17.737L17.7359 16.3803C17.8565 16.2597 17.8565 16.1391 17.7359 16.0185L10.636 8.9187L17.3746 2.1801C17.4952 2.05951 17.4952 1.93892 17.3746 1.81832L16.018 0.461665C15.8974 0.341074 15.7768 0.341072 15.6562 0.461665L8.91759 7.20026L1.81775 0.100422C1.69716 -0.0201698 1.57657 -0.0201701 1.45597 0.100422Z" fill="#2A2B2B" fill-opacity="0.85"/></svg></a>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <div class="soc">
                                <div class="item">
                                    <a href="#"><div class="soc-logo soc-logo-vk"></div></a>
                                </div>
                                <div class="item">
                                    <a href="#"><div class="soc-logo soc-logo-tg"></div></a>
                                </div>
                            </div>
                        </div>
                    </nav>
				</div>
				<div class="header__right">
					<div class="header__actions">
                        <?/*?>
						<button class="header__search link-modal-another" data-modal-open="search">
							<svg class="icon icon-search">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-search"></use>
							</svg>
						</button>
                        <?*/?>

						<?php /* if (!$USER->IsAuthorized()): ?>
							<a href="#" class="header__profile" data-modal-open="profile">
								<svg class="icon icon-profile">
									<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-profile"></use>
								</svg>
							</a>
						<?php else:?>
							<a href="/favs/" class="header__profile">
<!--								<svg class="icon icon-profile">-->
<!--									<use xlink:href="--><?//=SITE_TEMPLATE_PATH?><!--/img/sprite.svg#icon-star"></use>-->
<!--								</svg>-->
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 28.3333L10 33.3333L12.5 23.3333L5 15L15.8333 14.1667L20 5L24.1667 14.1667L35 15L27.5 23.3333L30 33.3333L20 28.3333Z" stroke="#090909" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
							</a>
						<?php endif */?>

                        <a href="/favs/" class="header__profile">
                            <!--								<svg class="icon icon-profile">-->
                            <!--									<use xlink:href="--><?//=SITE_TEMPLATE_PATH?><!--/img/sprite.svg#icon-star"></use>-->
                            <!--								</svg>-->
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 28.3333L10 33.3333L12.5 23.3333L5 15L15.8333 14.1667L20 5L24.1667 14.1667L35 15L27.5 23.3333L30 33.3333L20 28.3333Z" stroke="#090909" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>

						<a href="#" class="header__cart" data-modal-open="cart">
							Корзина: <span data-cart-count><?php $APPLICATION->ShowViewContent( 'BASKET_PRODUCT_COUNT' ) ?> </span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>

	<?php $APPLICATION->IncludeFile( "/_includes/_modal.php" ); ?>
	<?php if ( CSite::InDir( '/about/' ) && !CSite::InDir( '/about/contacts/' ) ): ?>
		<div class="main">
			<section class="customers container">
				<!-- start sidebar-menu -->
				<?php $APPLICATION->IncludeFile( '/_includes/sidebar.php', false, [ 'SHOW_BORDER' => false ] ); ?>

				<!-- end sidebar-menu -->
				<div class="customers__content">
					<h1 class="section__title"> <?php $APPLICATION->ShowTitle(); ?></h1>
	<?php endif; ?>

    <?
    if ( CSite::InDir( '/login/' ) || CSite::InDir( '/auth/' ) ):
    ?>
    <div class="main">
        <section class="container">

            <!-- end sidebar-menu -->
            <div class="customers__content">
    <?php endif; ?>



                    <? if (showBreadcrumb()) { ?>
                    <div class="container">
                        <div class="breadcrumbs">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:breadcrumb", "", array(
                                        "START_FROM" => "0",
                                        "PATH" => "",
                                        "SITE_ID" => "st"
                                    )
                                ); ?>
                        </div>
                    </div>
                    <? } ?>



