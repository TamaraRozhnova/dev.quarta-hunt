<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.smart.filter", "common_filter", Array(
        "CACHE_GROUPS" => "N",    // Учитывать права доступа
        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
        "CACHE_TYPE" => "A",    // Тип кеширования
        "CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
        "DISPLAY_ELEMENT_COUNT" => "Y",    // Показывать количество
        "FILTER_NAME" => "arrFilter",    // Имя выходящего массива для фильтрации
        "FILTER_VIEW_MODE" => "vertical",    // Вид отображения
        "HIDE_NOT_AVAILABLE" => "N",    // Не отображать недоступные товары
        "IBLOCK_ID" => "22",    // Инфоблок
        "IBLOCK_TYPE" => "about",    // Тип инфоблока
        "PAGER_PARAMS_NAME" => "arrPager",    // Имя массива с переменными для построения ссылок в постраничной навигации
        "POPUP_POSITION" => "left",    // Позиция для отображения всплывающего блока с информацией о фильтрации
        "PREFILTER_NAME" => "smartPreFilter",    // Имя входящего массива для дополнительной фильтрации элементов
        "PRICE_CODE" => "",    // Тип цены
        "SAVE_IN_SESSION" => "N",    // Сохранять установки фильтра в сессии пользователя
        "SECTION_CODE" => "",    // Код раздела
        "SECTION_DESCRIPTION" => "-",    // Описание
        "SECTION_ID" => $_REQUEST["SECTION_ID"],    // ID раздела инфоблока
        "SECTION_TITLE" => "-",    // Заголовок
        "SEF_MODE" => "N",    // Включить поддержку ЧПУ
        "TEMPLATE_THEME" => "blue",    // Цветовая тема
        "XML_EXPORT" => "N",    // Включить поддержку Яндекс Островов
    ),
    false
);?>

<?$APPLICATION->IncludeComponent("bitrix:news.list", "vacancies", Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DISPLAY_DATE" => "N",	// Выводить дату элемента
		"DISPLAY_NAME" => "N",	// Выводить название элемента
		"DISPLAY_PICTURE" => "N",	// Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"FIELD_CODE" => array(	// Поля
			0 => "ID",
			1 => "CODE",
			2 => "NAME",
			3 => "PREVIEW_TEXT",
			4 => "PREVIEW_PICTURE",
			5 => "DETAIL_TEXT",
			6 => "DETAIL_PICTURE",
			7 => "IBLOCK_TYPE_ID",
			8 => "IBLOCK_ID",
			9 => "IBLOCK_CODE",
			10 => "IBLOCK_NAME",
			11 => "",
		),
		"FILE_404" => "",
		"FILTER_NAME" => "arrFilter",	// Фильтр
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"IBLOCK_ID" => "22",	// Код информационного блока
		"IBLOCK_TYPE" => "about",	// Тип информационного блока (используется только для проверки)
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"NEWS_COUNT" => "20",	// Количество новостей на странице
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"PROPERTY_CODE" => array(	// Свойства
			0 => "TAGS",
			1 => "CITY",
			2 => "ADDRESS",
			3 => "DEPARTMENT",
			4 => "SALARY",
			5 => "RESPONSIBILITIES",
			6 => "REQUIREMENTS",
			7 => "CONDITIONS",
			8 => "",
		),
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
