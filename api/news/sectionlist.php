<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "section_list", Array(
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",	// Показывать количество
		"FILTER_NAME" => "sectionsFilter",	// Имя массива со значениями фильтра разделов
		"IBLOCK_ID" => "1",	// Инфоблок
		"IBLOCK_TYPE" => "news",	// Тип инфоблока
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_FIELDS" => array(	// Поля разделов
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "SORT",
			5 => "DESCRIPTION",
			6 => "PICTURE",
			7 => "DETAIL_PICTURE",
			8 => "IBLOCK_TYPE_ID",
			9 => "IBLOCK_ID",
			10 => "IBLOCK_CODE",
			11 => "IBLOCK_EXTERNAL_ID",
			12 => "",
		),
		"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SECTION_USER_FIELDS" => array(	// Свойства разделов
			0 => "",
			1 => "",
		),
		"SHOW_PARENT_NAME" => "N",	// Показывать название раздела
		"TOP_DEPTH" => isset($_REQUEST["DEPTH"]) ? $_REQUEST["DEPTH"] : "1",	// Максимальная отображаемая глубина разделов
		"VIEW_MODE" => "LIST",	// Вид списка подразделов
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

