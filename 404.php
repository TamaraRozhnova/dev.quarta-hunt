<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetPageProperty('not-found-page', 'not-found-page');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
define("HIDE_SIDEBAR", true);

$APPLICATION->SetTitle("Страница не найдена");?>

<div class="not-found__wrapper">
	<div class="error-message__wrapper">		
		<div class="error-message-content">
			<div class="error-message">
				<h2>
					Упс, что-то пошло не так, похоже, такой страницы не существует!
				</h2>
				<p>Попробуйте воспользоваться нашим поиском на сайте.</p>
				<a href="/" class="btn btn-lg btn-primary">Вернуться на главную</a>
			</div>

		</div>
	</div>
</div>


<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
