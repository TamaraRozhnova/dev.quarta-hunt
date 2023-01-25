<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent("ipol:ipol.sdekPickup", "sdek", Array(
	"CITIES" => "",	// Подключаемые города (если не выбрано ни одного - подключаются все)
		"CNT_BASKET" => "Y",	// Расчитывать доставку для корзины
		"CNT_DELIV" => "N",	// Расчитывать доставку при подключении
		"COUNTRIES" => array(	// Подключенные страны
			0 => "rus",
		),
		"FORBIDDEN" => "",	// Отключить расчет для профилей
		"MODE" => "PVZ",	// Подключенный профиль на карте
		"NOMAPS" => "Y",	// Не подключать Яндекс-карты (если их подключает что-то еще на странице)
		"PAYER" => "2",	// Тип плательщика, от лица которого считать доставку
		"PAYSYSTEM" => "1",	// Тип платежной системы, с которой будет считатся доставка
		"SEARCH_ADDRESS" => "N",	// Включить поиск адреса (требуется геокодер и ключ к API yandex.карт)
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
