<?php if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();


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
	<meta name="yandex-verification" content="266faedfe7d618bc" />
	<link rel="stylesheet" media="all" href="/bitrix/templates/stalker/css/style.css?v3"/>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(94259503, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/94259503" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>
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
					<?php $APPLICATION->IncludeComponent(
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
					); ?>
				</div>
				<div class="header__right">
					<div class="header__actions">
						<button class="header__search link-modal-another" data-modal-open="search">
							<svg class="icon icon-search">
								<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-search"></use>
							</svg>
						</button>

						<?php if ($USER->IsAuthorized()): ?>
							<a href="/personal/" class="header__profile">
								<svg class="icon icon-profile">
									<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-profile"></use>
								</svg>
							</a>
						<?php else:?>
							<a href="#" class="header__profile" data-modal-open="profile">
								<svg class="icon icon-profile">
									<use xlink:href="/bitrix/templates/stalker/img/sprite.svg#icon-profile"></use>
								</svg>
							</a>
						<?php endif ?>

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
