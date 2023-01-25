<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "store_amount", Array(
	"CACHE_TIME" => "36000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"ELEMENT_CODE" => "",	// Код товара
		"ELEMENT_ID" => $_REQUEST["ID"],	// Товар
		"FIELDS" => array(	// Поля
			0 => "ADDRESS",
			1 => "SCHEDULE",
			2 => "",
		),
		"IBLOCK_ID" => "16",	// Инфоблок
		"IBLOCK_TYPE" => "1c_catalog",	// Тип инфоблока
		"MAIN_TITLE" => "",	// Заголовок
		"MIN_AMOUNT" => "0",
		"OFFER_ID" => "",	// Торговое предложение
		"SHOW_EMPTY_STORE" => "Y",	// Отображать склад при отсутствии на нем товара
		"SHOW_GENERAL_STORE_INFORMATION" => "N",	// Показывать общую информацию по складам
		"STORES" => array(	// Склады
		),
		"STORE_PATH" => "#",	// URL на страницу, где будет показана детальная информация о складе
		"USER_FIELDS" => array(	// Свойства
			0 => "",
			1 => "",
		),
		"USE_MIN_AMOUNT" => "N",	// Показывать вместо точного количества информацию о достаточности
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

