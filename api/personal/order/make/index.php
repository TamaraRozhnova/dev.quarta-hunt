<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "make_order", Array(
		"PAY_FROM_ACCOUNT" => "Y",	// Разрешить оплату с внутреннего счета
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
		"ALLOW_AUTO_REGISTER" => "Y",	// Оформлять заказ с автоматической регистрацией пользователя
		"SEND_NEW_USER_NOTIFY" => "Y",	// Отправлять пользователю письмо, что он зарегистрирован на сайте
		"DELIVERY_NO_AJAX" => "N",	// Когда рассчитывать доставки с внешними системами расчета
		"TEMPLATE_LOCATION" => "popup",	// Визуальный вид контрола выбора местоположений
		"PROP_1" => "",
		"PATH_TO_BASKET" => "",	// Путь к странице корзины
		"PATH_TO_PERSONAL" => "",	// Путь к странице персонального раздела
		"PATH_TO_PAYMENT" => "",	// Страница подключения платежной системы
		"PATH_TO_ORDER" => "",
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"DELIVERY_NO_SESSION" => "Y",	// Проверять сессию при оформлении заказа
		"COMPATIBLE_MODE" => "N",	// Режим совместимости для предыдущего шаблона
		"BASKET_POSITION" => "before",	// Расположение списка товаров
		"BASKET_IMAGES_SCALING" => "adaptive",	// Режим отображения изображений товаров
		"SERVICES_IMAGES_SCALING" => "adaptive",	// Режим отображения вспомагательных изображений
		"USER_CONSENT" => "Y",	// Запрашивать согласие
		"USER_CONSENT_ID" => "1",	// Соглашение
		"USER_CONSENT_IS_CHECKED" => "Y",	// Галка по умолчанию проставлена
		"USER_CONSENT_IS_LOADED" => "Y",	// Загружать текст сразу
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>