<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent("bitrix:sale.personal.order.list", "order_list", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"ALLOW_INNER" => "N",	// Разрешить оплату с внутреннего счета
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"DEFAULT_SORT" => "ID",	// Сортировка заказов
		"DISALLOW_CANCEL" => "N",	// Запретить отмену заказа
		"HISTORIC_STATUSES" => array(	// Перенести в историю заказы в статусах
			0 => "",
		),
		"ID" => $ID,	// Идентификатор заказа
		"NAV_TEMPLATE" => "",	// Имя шаблона для постраничной навигации
		"ONLY_INNER_FULL" => "N",	// Разрешить оплату с внутреннего счета только в полном объеме
		"ORDERS_PER_PAGE" => "20",	// Количество заказов, выводимых на страницу
		"PATH_TO_BASKET" => "/personal/cart/index.php",	// Страница корзины
		"PATH_TO_CANCEL" => "/personal/order/cancel.php",	// Страница отмены заказа
		"PATH_TO_CATALOG" => "/catalog/",	// Путь к каталогу
		"PATH_TO_COPY" => "/personal/order/repeat.php",	// Страница повторения заказа
		"PATH_TO_DETAIL" => "/personal/order/detail.php",	// Страница c подробной информацией о заказе
		"PATH_TO_PAYMENT" => "payment.php",	// Страница подключения платежной системы
		"REFRESH_PRICES" => "N",	// Пересчитывать заказ после смены платежной системы
		"RESTRICT_CHANGE_PAYSYSTEM" => array(	// Запретить смену платежной системы у заказов в статусах
			0 => "0",
		),
		"SAVE_IN_SESSION" => "N",	// Сохранять установки фильтра в сессии пользователя
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"STATUS_COLOR_F" => "gray",	// Цвет статуса "Выполнен"
		"STATUS_COLOR_N" => "green",	// Цвет статуса "Принят, ожидается оплата"
		"STATUS_COLOR_P" => "yellow",	// Цвет статуса "Оплачен, формируется к отправке"
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",	// Цвет отменённых заказов
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

