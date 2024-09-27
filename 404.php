<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetPageProperty('not-found-page', 'not-found-page');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
define("HIDE_SIDEBAR", true);

$APPLICATION->SetTitle("Страница не найдена");?>

<section class="c404">
 <div class="c404__container">
	<img src="<?=SITE_TEMPLATE_PATH ?>/img/404.png" alt="" class="c404__img">
	<h1 class="c404__title">Такой страницы нет</h1>
	<p class="c404__text">Попробуйте воспользоваться <a href="#">поиском</a> или посмотрите на других страницах:
	</p>
	<div class="c404__links">
		<a href="/">Главная</a>
	   <a href="#">Каталог</a>
	   <a href="#">Товары для охоты</a>
	   <a href="#">Тактическое снаряжение</a>
	   <a href="#">Повседневная одежда</a>
	   <a href="#">Адреса магазинов</a>
	</div>
 </div>
</section>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
