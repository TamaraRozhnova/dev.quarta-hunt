<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$prices = get_prices();

?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.search", "catalog_search", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
		"BASKET_URL" => "/cart/",	// URL, ведущий на страницу с корзиной покупателя
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Искать только в активных по дате документах
		"CONVERT_CURRENCY" => "Y",	// Показывать цены в одной валюте
		"CURRENCY_ID" => "RUB",	// Валюта, в которую будут сконвертированы цены
		"DETAIL_URL" => "#SITE_DIR#/product/#ELEMENT_ID#/#ELEMENT_CODE#",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DISPLAY_COMPARE" => "N",	// Выводить кнопку сравнения
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"ELEMENT_SORT_FIELD" => "name",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => "id",	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "asc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => "asc",	// Порядок второй сортировки элементов
		"HIDE_NOT_AVAILABLE" => "N",	// Недоступные товары
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
		"IBLOCK_ID" => "16",	// Инфоблок
		"IBLOCK_TYPE" => "1c_catalog",	// Тип инфоблока
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
		"NO_WORD_LOGIC" => "Y",	// Отключить обработку слов как логических операторов
		"OFFERS_CART_PROPERTIES" => "",
		"OFFERS_FIELD_CODE" => "",
		"OFFERS_LIMIT" => "5",	// Максимальное количество предложений для показа (0 - все)
		"OFFERS_PROPERTY_CODE" => "",
		"OFFERS_SORT_FIELD" => "name",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "asc",
		"PAGER_DESC_NUMBERING" => "Y",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "Y",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "Y",	// Выводить всегда
		"PAGER_TEMPLATE" => "",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Товары",	// Название категорий
		"PAGE_ELEMENT_COUNT" => "30",	// Количество элементов на странице
		"PRICE_CODE" => $prices,	// Тип цены
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPERTIES" => "", 	// Характеристики товара
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
		"PROPERTY_CODE" => array(	// Свойства
			0 => "NAME",
			1 => "",
		),
		"RESTART" => "Y",	// Искать без учета морфологии (при отсутствии результата поиска)
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_URL" => "#SITE_DIR#/catalog/#SECTION_CODE#",	// URL, ведущий на страницу с содержимым раздела
		"SHOW_PRICE_COUNT" => "0",	// Выводить цены для количества
		"USE_LANGUAGE_GUESS" => "N",	// Включить автоопределение раскладки клавиатуры
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "Y",	// Разрешить указание количества товара
		"USE_SEARCH_RESULT_ORDER" => "N",	// Использовать сортировку результатов по релевантности
		"USE_TITLE_RANK" => "N",	// При ранжировании результата учитывать заголовки
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>