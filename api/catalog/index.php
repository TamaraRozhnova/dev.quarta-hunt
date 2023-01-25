<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


$PRICES = get_prices();

$sort_field = 'name';
$sort_order = 'asc';

if (!empty($_REQUEST['SORT'])) {

	if ($_REQUEST['SORT'] === 'expensive') {
		$sort_field = 'SCALED_PRICE_1';
		$sort_order = 'desc';
	} else if ($_REQUEST['SORT'] === 'cheaper') {
		$sort_field = 'SCALED_PRICE_1';
		$sort_order = 'asc';
	}

}

$hide_not_avail = 'N';

if (!empty($_REQUEST['AVAILABLE']) && $_REQUEST['AVAILABLE'] === 'true') {
	$hide_not_avail = 'Y';
}


?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.smart.filter", "common_filter", Array(
        "CACHE_GROUPS" => "N",    // Учитывать права доступа
        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
        "CACHE_TYPE" => "A",    // Тип кеширования
        "CONVERT_CURRENCY" => "N",    // Показывать цены в одной валюте
        "DISPLAY_ELEMENT_COUNT" => "Y",    // Показывать количество
        "FILTER_NAME" => "arrFilter",    // Имя выходящего массива для фильтрации
        "FILTER_VIEW_MODE" => "vertical",    // Вид отображения
        "HIDE_NOT_AVAILABLE" => "N",    // Не отображать недоступные товары
        "IBLOCK_ID" => "16",    // Инфоблок
        "IBLOCK_TYPE" => "1c_catalog",    // Тип инфоблока
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
);

if (get_user_type()) {
	if (!empty($_REQUEST['PRICE_2_MIN']) && !empty($_REQUEST['PRICE_2_MAX']))
		$arPrice = ['>PRICE_3' => $_REQUEST['PRICE_2_MIN'], '<PRICE_3' => $_REQUEST['PRICE_2_MAX']];
	else if (!empty($_REQUEST['PRICE_2_MIN']))
		$arPrice = ['>PRICE_3' => $_REQUEST['PRICE_2_MIN']];
	else if (!empty($_REQUEST['PRICE_2_MAX']))
		$arPrice = ['<PRICE_3' => $_REQUEST['PRICE_2_MAX']];
	else
		$arPrice = ['>PRICE_3' => 0];
} else {
	if (!empty($_REQUEST['PRICE_1_MIN']) && !empty($_REQUEST['PRICE_1_MAX']))
		$arPrice = ['>PRICE_1' => $_REQUEST['PRICE_1_MIN'], '<PRICE_1' => $_REQUEST['PRICE_1_MAX']];
	else if (!empty($_REQUEST['PRICE_1_MIN']))
		$arPrice = ['>PRICE_1' => $_REQUEST['PRICE_1_MIN']];
	else if (!empty($_REQUEST['PRICE_1_MAX']))
		$arPrice = ['<PRICE_1' => $_REQUEST['PRICE_1_MAX']];
	else
		$arPrice = [];
}

if (!empty($GLOBALS['arrFilter']))
	$GLOBALS['arrFilter'] = array_merge($GLOBALS['arrFilter'], $arPrice);
else
	$GLOBALS['arrFilter'] = $arPrice;

$APPLICATION->IncludeComponent("bitrix:catalog.section", "catalog", Array(
	"ACTION_VARIABLE" => "action",	// Название переменной, в которой передается действие
		"ADD_PICT_PROP" => "-",	// Дополнительная картинка основного товара
		"ADD_PROPERTIES_TO_BASKET" => "Y",	// Добавлять в корзину свойства товаров и предложений
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"ADD_TO_BASKET_ACTION" => "ADD",	// Показывать кнопку добавления в корзину или покупки
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"BACKGROUND_IMAGE" => "-",	// Установить фоновую картинку для шаблона из свойства
		"BASKET_URL" => "/personal/basket.php",	// URL, ведущий на страницу с корзиной покупателя
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPATIBLE_MODE" => "N",	// Включить режим совместимости
		"CONVERT_CURRENCY" => "N",	// Показывать цены в одной валюте
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",	// Фильтр товаров
		"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",	// Не подключать js-библиотеки в компоненте
		"DISCOUNT_PERCENT_POSITION" => "bottom-right",	// Расположение процента скидки
		"DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
		"DISPLAY_COMPARE" => "N",	// Разрешить сравнение товаров
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"ELEMENT_SORT_FIELD" => "CATALOG_AVAILABLE",	// По какому полю сортируем элементы
		"ELEMENT_SORT_FIELD2" => $sort_field,	// Поле для второй сортировки элементов
		"ELEMENT_SORT_ORDER" => "desc",	// Порядок сортировки элементов
		"ELEMENT_SORT_ORDER2" => $sort_order,	// Порядок второй сортировки элементов
		"ENLARGE_PRODUCT" => "STRICT",	// Выделять товары в списке
		"FILTER_NAME" => "arrFilter",	// Имя массива со значениями фильтра для фильтрации элементов
		"HIDE_NOT_AVAILABLE" => $hide_not_avail,	// Недоступные товары
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",	// Недоступные торговые предложения
		"IBLOCK_ID" => "16",	// Инфоблок
		"IBLOCK_TYPE" => "1c_catalog",	// Тип инфоблока
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"LABEL_PROP" => "",	// Свойства меток товара
		"LABEL_PROP_MOBILE" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"LAZY_LOAD" => "N",	// Показать кнопку ленивой загрузки Lazy Load
		"LINE_ELEMENT_COUNT" => "3",	// Количество элементов выводимых в одной строке таблицы
		"LOAD_ON_SCROLL" => "N",	// Подгружать товары при прокрутке до конца
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",	// Текст кнопки "Добавить в корзину"
		"MESS_BTN_BUY" => "Купить",	// Текст кнопки "Купить"
		"MESS_BTN_DETAIL" => "Подробнее",	// Текст кнопки "Подробнее"
		"MESS_BTN_LAZY_LOAD" => "Показать ещё",	// Текст кнопки "Показать ещё"
		"MESS_BTN_SUBSCRIBE" => "Подписаться",	// Текст кнопки "Уведомить о поступлении"
		"MESS_NOT_AVAILABLE" => "Нет в наличии",	// Сообщение об отсутствии товара
		"MESS_SHOW_MAX_QUANTITY" => "Наличие",	// Текст для остатка
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "RAZMER_ODEZHDA_ZHENSKAYA",
			1 => "RAZMER",
			2 => "RAZMER_OBUV",
			3 => "RAZMER_NOSKI",
			4 => "RAZMER_AKSESSUAROV_",
			5 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "DLINA_SM",
			1 => "KOLICHESTVO",
			2 => "MATERIAL_LOZHA_PRIKLADA",
			3 => "VID_PTITSY",
			4 => "KOLICHESTVO_STVOLOV",
			5 => "PRITSELNAYA_SETKA",
			6 => "DLINA_STVOLA_STVOLOV",
			7 => "OBYEM_L",
			8 => "PODSVETKA_PRITSELNOY_SETKI",
			9 => "VID_PRIZM",
			10 => "VSTROENNNYY_BALLISTICHESKIY_KALKULYATOR",
			11 => "KALIBR_3",
			12 => "CML2_ARTICLE",
			13 => "CML2_BASE_UNIT",
			14 => "DIAMETR_OBEKTIVA_RAZMER_LINZY_MM",
			15 => "KALIBR_4",
			16 => "PODSVETKA",
			17 => "CML2_MANUFACTURER",
			18 => "CML2_TRAITS",
			19 => "CML2_TAXES",
			20 => "TIP_FONARYA",
			21 => "CML2_ATTRIBUTES",
			22 => "CML2_BAR_CODE",
			23 => "KALIBR_5",
			24 => "KRATNOST_KH",
			25 => "TIP_OKULYARA",
			26 => "MATERIAL_LOZHA_PRIKLADA_1",
			27 => "STEKLO_PRIZM",
			28 => "TIP_KREPLENIYA_SOSHEK",
			29 => "TSENA_SHCHELCHKA",
			30 => "DLINA_STVOLA_MM",
			31 => "KRATNOST_KH_1",
			32 => "TIP_KOLLIMATORNOGO_PRITSELA",
			33 => "VSTROENNYY_LAZERNYY_DALNOMER_",
			34 => "DIAMETR",
			35 => "EMKOST_MAGAZINA",
			36 => "KRATNOST_",
			37 => "MAKSIMALNOE_IZMERYAEMOE_RASSTOYANIE_M",
			38 => "MINIMALNOE_IZMERYAEMOE_RASSTOYANIE_M",
			39 => "PRINTSIP_DEYSTVIYA_1",
			40 => "TSVET",
			41 => "VES_PULI_G",
			42 => "DIAMETR_OBEKTIVA_RAZMER_LINZY_MM_1",
			43 => "DLINA",
			44 => "KRATNOST_KH_2",
			45 => "MATERIAL",
			46 => "TIP_PULI",
			47 => "DIAMETR_1",
			48 => "MATERIAL_3",
			49 => "NOMER_DROBI_DIAMETR_KARTECHI",
			50 => "TIP_TOVARA_1",
			51 => "NA",
			52 => "NAZNACHENIE_1",
			53 => "UROVEN",
			54 => "VID",
			55 => "SVET",
			56 => "TIP_OSNOVANIYA",
			57 => "KREPLENIE_1",
			58 => "TIP_4",
			59 => "TIP_ZASIDKI",
			60 => "PRIMANIVAEMAYA_DICH",
			61 => "PRIMANIVAEMOE_ZHIVOTNOE_PTITSA_",
			62 => "RASTSVETKA",
			63 => "BREND",
			64 => "MATERIAL_4",
			65 => "OTSTROYKA_PARALLAKSA",
			66 => "TIP_MISHENI_",
			67 => "DIAMETR_OBEKTIVA_RAZMER_LINZY_MM_2",
			68 => "TIP_KRONSHTEYNA",
			69 => "TIP_RASPYLENIYA",
			70 => "TSVET_1",
			71 => "KRATNOST_KH_3",
			72 => "KREPLENIE",
			73 => "TIP_TOVARA_NABORY_DLYA_CHISTKI",
			74 => "TIPORAZMER",
			75 => "DLINA_LEZVIYA",
			76 => "KALIBR",
			77 => "DLINA_NOZHA",
			78 => "KALIBR_1",
			79 => "RAZMER_1",
			80 => "VES_PULKI",
			81 => "MATERIAL_RUKOYATI",
			82 => "KOLICHESTVO_V_BANKE",
			83 => "MARKA_STALI",
			84 => "DIAMETR_OBEKTIVA_RAZMER_LINZY_MM_3",
			85 => "ISTOCHNIK_ENERGII_",
			86 => "KOMPLEKTY_DLYA_SAYTA",
			87 => "ELEMENT_PITANIYA",
			88 => "DIAMETR_TRUBY_PRITSELA_MM",
			89 => "NALICHIE_UPORA_",
			90 => "RAZMER_AKSESSUAROV_",
			91 => "TSVET_5",
			92 => "DIAMETR_SHARIKA",
			93 => "RAZMER_NOSKI",
			94 => "ROST",
			95 => "FOKALNAYA_PLOSKOST",
			96 => "RAZMER_OBUV",
			97 => "TIP",
			98 => "TSENA_SHCHELCHKA_1",
			99 => "KRATNOST_KH_4",
			100 => "KREPLENIE_",
			101 => "RAZMER",
			102 => "RAZMER_ODEZHDA_ZHENSKAYA",
			103 => "MATERIAL_1",
			104 => "MATERIAL_5",
			105 => "OBYEM_RYUKZAKI_",
			106 => "DIADOKISPOLZOVATSERVISKONTURMARKIROVKA",
			107 => "DULNAYA_ENERGIYA",
			108 => "TIP_KAMUFLYAZHA",
			109 => "NACHALNAYA_SKOROST_PULI",
			110 => "TSVET_2",
			111 => "BLOUBEK",
			112 => "TIP_1",
			113 => "PRIMANIVAEMOE_ZHIVOTNOE",
			114 => "TSVET_3",
			115 => "TIP_2",
			116 => "TIP_KREPLENIYA_1",
			117 => "MATERIAL_8",
			118 => "SKLADNOE_IZGOLOVE",
			119 => "TIP_OPORY",
			120 => "VYSOTA_STULA",
			121 => "MODEL_PISTOLETA_",
			122 => "CHUVSTVITELNOST_SNR",
			123 => "UPRAVLENIE_",
			124 => "TSVET_LINZ",
			125 => "DALNOST_OBNARUZHENIYA_CHELOVEKA_M",
			126 => "TIP_TOVARA",
			127 => "KRATNOST_KH_5",
			128 => "NAZNACHENIE",
			129 => "OBEM_ML",
			130 => "RAZRESHENIE_MATRITSY",
			131 => "DIAMETR_OBEKTIVA_RAZMER_LINZY_MM_4",
			132 => "MATERIAL_2",
			133 => "MATERIAL_6",
			134 => "TSVET_4",
			135 => "KATEGORIYA_TYUNINGA_",
			136 => "TIP_3",
			137 => "MAKSIMALNYY_SVETOVOY_POTOK_LYUMEN",
			138 => "MODEL_ORUZHIYA",
			139 => "DIAMETR_OBEKTIVA_RAZMER_LINZY_MM_5",
			140 => "TIP_KREPLENIYA",
			141 => "MATERIAL_7",
			142 => "TSVET_LAZERA",
			143 => "ISTOCHNIK_SVETA",
			144 => "KALIBR_2",
			145 => "TIP_LTSU",
			146 => "BREND_1",
			147 => "GRAVIROVANNAYA_SETKA",
			148 => "PRINTSIP_DEYSTVIYA",
			149 => "HIT",
			150 => "NEW_PRODUCT",
			151 => "DOUBLE_BONUS",
			152 => "BUY_WITH_THIS",
			153 => "",
		),
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Товары",	// Название категорий
		"PAGE_ELEMENT_COUNT" => !empty($_REQUEST['ELEMENT_COUNT']) ? $_REQUEST["ELEMENT_COUNT"] : 5,	// Количество элементов на странице
		"PARTIAL_PRODUCT_PROPERTIES" => "N",	// Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
		"PRICE_CODE" => $PRICES,	// Тип цены
		"PRICE_VAT_INCLUDE" => "Y",	// Включать НДС в цену
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",	// Порядок отображения блоков товара
		"PRODUCT_ID_VARIABLE" => "id",	// Название переменной, в которой передается код товара для покупки
		"PRODUCT_PROPS_VARIABLE" => "prop",	// Название переменной, в которой передаются характеристики товара
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",	// Название переменной, в которой передается количество товара
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",	// Вариант отображения товаров
		"PRODUCT_SUBSCRIPTION" => "N",	// Разрешить оповещения для отсутствующих товаров
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],	// Параметр ID продукта (для товарных рекомендаций)
		"RCM_TYPE" => "personal",	// Тип рекомендации
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_ID" => $_REQUEST["SECTION_ID"],	// ID раздела
		"SECTION_ID_VARIABLE" => "SECTION_ID",	// Название переменной, в которой передается код группы
		"SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
		"SECTION_USER_FIELDS" => array(	// Свойства раздела
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",	// Включить поддержку ЧПУ
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SHOW_ALL_WO_SECTION" => "Y",	// Показывать все элементы, если не указан раздел
		"SHOW_CLOSE_POPUP" => "N",	// Показывать кнопку продолжения покупок во всплывающих окнах
		"SHOW_DISCOUNT_PERCENT" => "Y",	// Показывать процент скидки
		"SHOW_FROM_SECTION" => "N",	// Показывать товары из раздела
		"SHOW_MAX_QUANTITY" => "Y",	// Показывать остаток товара
		"SHOW_OLD_PRICE" => "Y",	// Показывать старую цену
		"SHOW_PRICE_COUNT" => "1",	// Выводить цены для количества
		"SHOW_SLIDER" => "Y",	// Показывать слайдер для товаров
		"SLIDER_INTERVAL" => "3000",	// Интервал смены слайдов, мс
		"SLIDER_PROGRESS" => "N",	// Показывать полосу прогресса
		"TEMPLATE_THEME" => "blue",	// Цветовая тема
		"USE_ENHANCED_ECOMMERCE" => "N",	// Отправлять данные электронной торговли в Google и Яндекс
		"USE_MAIN_ELEMENT_SECTION" => "N",	// Использовать основной раздел для показа элемента
		"USE_PRICE_COUNT" => "N",	// Использовать вывод цен с диапазонами
		"USE_PRODUCT_QUANTITY" => "N",	// Разрешить указание количества товара
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
