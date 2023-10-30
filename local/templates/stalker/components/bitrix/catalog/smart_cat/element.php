<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

?>
<div class="main">
	<div class="product-card">
		<div class="container">
		<?

		$componentElementParams = array(
			'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
			'IBLOCK_ID' => $arParams['IBLOCK_ID'],
			'PROPERTY_CODE' => (isset($arParams['DETAIL_PROPERTY_CODE']) ? $arParams['DETAIL_PROPERTY_CODE'] : []),
			'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
			'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
			'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
			'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
			'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
			'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
			'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
			'CHECK_SECTION_ID_VARIABLE' => (isset($arParams['DETAIL_CHECK_SECTION_ID_VARIABLE']) ? $arParams['DETAIL_CHECK_SECTION_ID_VARIABLE'] : ''),
			'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'CACHE_TYPE' => $arParams['CACHE_TYPE'],
			'CACHE_TIME' => $arParams['CACHE_TIME'],
			'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
			'SET_TITLE' => $arParams['SET_TITLE'],
			'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
			'MESSAGE_404' => $arParams['~MESSAGE_404'],
			'SET_STATUS_404' => $arParams['SET_STATUS_404'],
			'SHOW_404' => $arParams['SHOW_404'],
			'FILE_404' => $arParams['FILE_404'],
			'PRICE_CODE' => $arParams['~PRICE_CODE'],
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
			'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
			'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
			'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'PRODUCT_PROPERTIES' => (isset($arParams['PRODUCT_PROPERTIES']) ? $arParams['PRODUCT_PROPERTIES'] : []),
			'ADD_PROPERTIES_TO_BASKET' => (isset($arParams['ADD_PROPERTIES_TO_BASKET']) ? $arParams['ADD_PROPERTIES_TO_BASKET'] : ''),
			'PARTIAL_PRODUCT_PROPERTIES' => (isset($arParams['PARTIAL_PRODUCT_PROPERTIES']) ? $arParams['PARTIAL_PRODUCT_PROPERTIES'] : ''),
			'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
			'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
			'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
			'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],

			'OFFERS_CART_PROPERTIES' => (isset($arParams['OFFERS_CART_PROPERTIES']) ? $arParams['OFFERS_CART_PROPERTIES'] : []),
			'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
			'OFFERS_PROPERTY_CODE' => (isset($arParams['DETAIL_OFFERS_PROPERTY_CODE']) ? $arParams['DETAIL_OFFERS_PROPERTY_CODE'] : []),
			'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
			'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
			'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
			'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],

			'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
			'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
			'SECTION_ID' => $arResult['VARIABLES']['SECTION_ID'],
			'SECTION_CODE' => $arResult['VARIABLES']['SECTION_CODE'],
			'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
			'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams['HIDE_NOT_AVAILABLE'],
			'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
			'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
			'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
			'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
			'STRICT_SECTION_CHECK' => (isset($arParams['DETAIL_STRICT_SECTION_CHECK']) ? $arParams['DETAIL_STRICT_SECTION_CHECK'] : ''),
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
			'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'DISCOUNT_PERCENT_POSITION' => (isset($arParams['DISCOUNT_PERCENT_POSITION']) ? $arParams['DISCOUNT_PERCENT_POSITION'] : ''),
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
			'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
			'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
			'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
			'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
			'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
			'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
			'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
			'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
			'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),
			'MESS_PRICE_RANGES_TITLE' => (isset($arParams['~MESS_PRICE_RANGES_TITLE']) ? $arParams['~MESS_PRICE_RANGES_TITLE'] : ''),
			'MESS_DESCRIPTION_TAB' => (isset($arParams['~MESS_DESCRIPTION_TAB']) ? $arParams['~MESS_DESCRIPTION_TAB'] : ''),
			'MESS_PROPERTIES_TAB' => (isset($arParams['~MESS_PROPERTIES_TAB']) ? $arParams['~MESS_PROPERTIES_TAB'] : ''),
			'MESS_COMMENTS_TAB' => (isset($arParams['~MESS_COMMENTS_TAB']) ? $arParams['~MESS_COMMENTS_TAB'] : ''),
			'MAIN_BLOCK_PROPERTY_CODE' => (isset($arParams['DETAIL_MAIN_BLOCK_PROPERTY_CODE']) ? $arParams['DETAIL_MAIN_BLOCK_PROPERTY_CODE'] : ''),
			'MAIN_BLOCK_OFFERS_PROPERTY_CODE' => (isset($arParams['DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE']) ? $arParams['DETAIL_MAIN_BLOCK_OFFERS_PROPERTY_CODE'] : ''),
			'USE_VOTE_RATING' => $arParams['DETAIL_USE_VOTE_RATING'],
			'VOTE_DISPLAY_AS_RATING' => (isset($arParams['DETAIL_VOTE_DISPLAY_AS_RATING']) ? $arParams['DETAIL_VOTE_DISPLAY_AS_RATING'] : ''),
			'USE_COMMENTS' => $arParams['DETAIL_USE_COMMENTS'],
			'BLOG_USE' => (isset($arParams['DETAIL_BLOG_USE']) ? $arParams['DETAIL_BLOG_USE'] : ''),
			'BLOG_URL' => (isset($arParams['DETAIL_BLOG_URL']) ? $arParams['DETAIL_BLOG_URL'] : ''),
			'BLOG_EMAIL_NOTIFY' => (isset($arParams['DETAIL_BLOG_EMAIL_NOTIFY']) ? $arParams['DETAIL_BLOG_EMAIL_NOTIFY'] : ''),
			'VK_USE' => (isset($arParams['DETAIL_VK_USE']) ? $arParams['DETAIL_VK_USE'] : ''),
			'VK_API_ID' => (isset($arParams['DETAIL_VK_API_ID']) ? $arParams['DETAIL_VK_API_ID'] : 'API_ID'),
			'FB_USE' => (isset($arParams['DETAIL_FB_USE']) ? $arParams['DETAIL_FB_USE'] : ''),
			'FB_APP_ID' => (isset($arParams['DETAIL_FB_APP_ID']) ? $arParams['DETAIL_FB_APP_ID'] : ''),
			'BRAND_USE' => (isset($arParams['DETAIL_BRAND_USE']) ? $arParams['DETAIL_BRAND_USE'] : 'N'),
			'BRAND_PROP_CODE' => (isset($arParams['DETAIL_BRAND_PROP_CODE']) ? $arParams['DETAIL_BRAND_PROP_CODE'] : ''),
			'DISPLAY_NAME' => (isset($arParams['DETAIL_DISPLAY_NAME']) ? $arParams['DETAIL_DISPLAY_NAME'] : ''),
			'IMAGE_RESOLUTION' => (isset($arParams['DETAIL_IMAGE_RESOLUTION']) ? $arParams['DETAIL_IMAGE_RESOLUTION'] : ''),
			'PRODUCT_INFO_BLOCK_ORDER' => (isset($arParams['DETAIL_PRODUCT_INFO_BLOCK_ORDER']) ? $arParams['DETAIL_PRODUCT_INFO_BLOCK_ORDER'] : ''),
			'PRODUCT_PAY_BLOCK_ORDER' => (isset($arParams['DETAIL_PRODUCT_PAY_BLOCK_ORDER']) ? $arParams['DETAIL_PRODUCT_PAY_BLOCK_ORDER'] : ''),
			'ADD_DETAIL_TO_SLIDER' => (isset($arParams['DETAIL_ADD_DETAIL_TO_SLIDER']) ? $arParams['DETAIL_ADD_DETAIL_TO_SLIDER'] : ''),
			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			'ADD_SECTIONS_CHAIN' => (isset($arParams['ADD_SECTIONS_CHAIN']) ? $arParams['ADD_SECTIONS_CHAIN'] : ''),
			'ADD_ELEMENT_CHAIN' => (isset($arParams['ADD_ELEMENT_CHAIN']) ? $arParams['ADD_ELEMENT_CHAIN'] : ''),
			'DISPLAY_PREVIEW_TEXT_MODE' => (isset($arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE']) ? $arParams['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] : ''),
			'DETAIL_PICTURE_MODE' => (isset($arParams['DETAIL_DETAIL_PICTURE_MODE']) ? $arParams['DETAIL_DETAIL_PICTURE_MODE'] : array()),
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'ADD_TO_BASKET_ACTION_PRIMARY' => (isset($arParams['DETAIL_ADD_TO_BASKET_ACTION_PRIMARY']) ? $arParams['DETAIL_ADD_TO_BASKET_ACTION_PRIMARY'] : null),
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'DISPLAY_COMPARE' => (isset($arParams['USE_COMPARE']) ? $arParams['USE_COMPARE'] : ''),
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
			'USE_COMPARE_LIST' => 'Y',
			'BACKGROUND_IMAGE' => (isset($arParams['DETAIL_BACKGROUND_IMAGE']) ? $arParams['DETAIL_BACKGROUND_IMAGE'] : ''),
			'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
			'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
			'SET_VIEWED_IN_COMPONENT' => (isset($arParams['DETAIL_SET_VIEWED_IN_COMPONENT']) ? $arParams['DETAIL_SET_VIEWED_IN_COMPONENT'] : ''),
			'SHOW_SLIDER' => (isset($arParams['DETAIL_SHOW_SLIDER']) ? $arParams['DETAIL_SHOW_SLIDER'] : ''),
			'SLIDER_INTERVAL' => (isset($arParams['DETAIL_SLIDER_INTERVAL']) ? $arParams['DETAIL_SLIDER_INTERVAL'] : ''),
			'SLIDER_PROGRESS' => (isset($arParams['DETAIL_SLIDER_PROGRESS']) ? $arParams['DETAIL_SLIDER_PROGRESS'] : ''),
			'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
			'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
			'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

			'USE_GIFTS_DETAIL' => $arParams['USE_GIFTS_DETAIL']?: 'Y',
			'USE_GIFTS_MAIN_PR_SECTION_LIST' => $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST']?: 'Y',
			'GIFTS_SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
			'GIFTS_SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
			'GIFTS_DETAIL_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
			'GIFTS_DETAIL_HIDE_BLOCK_TITLE' => $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'],
			'GIFTS_DETAIL_TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],
			'GIFTS_DETAIL_BLOCK_TITLE' => $arParams['GIFTS_DETAIL_BLOCK_TITLE'],
			'GIFTS_SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
			'GIFTS_SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
			'GIFTS_MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
			'GIFTS_PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
			'GIFTS_SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
			'GIFTS_SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
			'GIFTS_SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

			'GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
			'GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],
			'GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'],
		);

		if (isset($arParams['USER_CONSENT']))
		{
			$componentElementParams['USER_CONSENT'] = $arParams['USER_CONSENT'];
		}

		if (isset($arParams['USER_CONSENT_ID']))
		{
			$componentElementParams['USER_CONSENT_ID'] = $arParams['USER_CONSENT_ID'];
		}

		if (isset($arParams['USER_CONSENT_IS_CHECKED']))
		{
			$componentElementParams['USER_CONSENT_IS_CHECKED'] = $arParams['USER_CONSENT_IS_CHECKED'];
		}

		if (isset($arParams['USER_CONSENT_IS_LOADED']))
		{
			$componentElementParams['USER_CONSENT_IS_LOADED'] = $arParams['USER_CONSENT_IS_LOADED'];
		}

		$elementId = $APPLICATION->IncludeComponent(
			'bitrix:catalog.element',
			'',
			$componentElementParams,
			$component
		);
		$GLOBALS['CATALOG_CURRENT_ELEMENT_ID'] = $elementId;

		global $otherFilter;
		$otherFilter = [
			'!=ID' => $elementId,
		];
		?>

		<div class="section section-similar section-slider">
			<?
			$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"smart_similar",                            // [.default, board, links, list]
				array(
					// region Основные параметры
					"IBLOCK_TYPE"                      =>  $arParams['IBLOCK_TYPE'],                          // Тип инфоблока : array ( 'catalog' => '[catalog] Каталоги', 'news' => '[news] Новости', 'offers' => '[offers] Торговые предложения', 'services' => '[services] Сервисы', 'references' => '[references] Справочники', )
					"IBLOCK_ID"                        =>  $arParams['IBLOCK_ID'],                          // Инфоблок : array ( 1 => '[1] Новости', 2 => '[2] Одежда', 3 => '[3] Одежда (предложения)', )
					"SECTION_ID"                       =>  "",  // ID раздела
					"SECTION_CODE"                     =>  $arResult['VARIABLES']['SECTION_CODE'],                          // Код раздела
					// endregion
					// region Источник данных
					"SECTION_USER_FIELDS"              =>  array(''),                   // Свойства раздела
					"ELEMENT_SORT_FIELD"               =>  "sort",                      // По какому полю сортируем элементы : array ( 'shows' => 'количество просмотров в среднем', 'sort' => 'индекс сортировки', 'timestamp_x' => 'дата изменения', 'name' => 'название', 'id' => 'ID', 'active_from' => 'дата активности (с)', 'active_to' => 'дата активности (по)', 'CATALOG_AVAILABLE' => 'доступность на складах', )
					"ELEMENT_SORT_ORDER"               =>  "asc",                       // Порядок сортировки элементов : array ( 'asc' => 'по возрастанию', 'desc' => 'по убыванию', )
					"ELEMENT_SORT_FIELD2"              =>  "id",                        // Поле для второй сортировки элементов : array ( 'shows' => 'количество просмотров в среднем', 'sort' => 'индекс сортировки', 'timestamp_x' => 'дата изменения', 'name' => 'название', 'id' => 'ID', 'active_from' => 'дата активности (с)', 'active_to' => 'дата активности (по)', 'CATALOG_AVAILABLE' => 'доступность на складах', )
					"ELEMENT_SORT_ORDER2"              =>  "desc",                      // Порядок второй сортировки элементов : array ( 'asc' => 'по возрастанию', 'desc' => 'по убыванию', )
					"FILTER_NAME"                      =>  "otherFilter",                 // Имя массива со значениями фильтра для фильтрации элементов
					"INCLUDE_SUBSECTIONS"              =>  "Y",                         // Показывать элементы подразделов раздела : array ( 'Y' => 'всех подразделов', 'A' => 'активных подразделов', 'N' => 'не показывать', )
					"SHOW_ALL_WO_SECTION"              =>  "N",                         // Показывать все элементы, если не указан раздел
					"HIDE_NOT_AVAILABLE"               =>  "N",                         // Не отображать товары, которых нет на складах
					// endregion
					// region Внешний вид
					"PAGE_ELEMENT_COUNT"               =>  "30",                        // Количество элементов на странице
					"LINE_ELEMENT_COUNT"               =>  "3",                         // Количество элементов выводимых в одной строке таблицы
					"PROPERTY_CODE"                    =>  array(''),                   // Свойства
					"OFFERS_LIMIT"                     =>  "5",                         // Максимальное количество предложений для показа (0 - все)
					// endregion
					// region Шаблоны ссылок
					"SECTION_URL"                      =>  "",                          // URL, ведущий на страницу с содержимым раздела
					"DETAIL_URL"                       =>  "",                          // URL, ведущий на страницу с содержимым элемента раздела
					"SECTION_ID_VARIABLE"              =>  "SECTION_ID",                // Название переменной, в которой передается код группы
					// endregion
					// region Управление режимом AJAX
					"AJAX_MODE"                        =>  "N",                         // Включить режим AJAX
					"AJAX_OPTION_JUMP"                 =>  "N",                         // Включить прокрутку к началу компонента
					"AJAX_OPTION_STYLE"                =>  "Y",                         // Включить подгрузку стилей
					"AJAX_OPTION_HISTORY"              =>  "N",                         // Включить эмуляцию навигации браузера
					"AJAX_OPTION_ADDITIONAL"           =>  "",                          // Дополнительный идентификатор
					// endregion
					// region Настройки кеширования
					"CACHE_TYPE"                       =>  "A",                         // Тип кеширования : array ( 'A' => 'Авто + Управляемое', 'Y' => 'Кешировать', 'N' => 'Не кешировать', )
					"CACHE_TIME"                       =>  "36000000",                  // Время кеширования (сек.)
					"CACHE_NOTES"                      =>  "",                          //
					"CACHE_GROUPS"                     =>  "Y",                         // Учитывать права доступа
					// endregion
					// region Дополнительные настройки
					"SET_TITLE"                        =>  "Y",                         // Устанавливать заголовок страницы
					"SET_BROWSER_TITLE"                =>  "Y",                         // Устанавливать заголовок окна браузера
					"BROWSER_TITLE"                    =>  "-",                         // Установить заголовок окна браузера из свойства : array ( '-' => ' ', 'NAME' => 'Название', )
					"SET_META_KEYWORDS"                =>  "Y",                         // Устанавливать ключевые слова страницы
					"META_KEYWORDS"                    =>  "-",                         // Установить ключевые слова страницы из свойства : array ( '-' => ' ', )
					"SET_META_DESCRIPTION"             =>  "Y",                         // Устанавливать описание страницы
					"META_DESCRIPTION"                 =>  "-",                         // Установить описание страницы из свойства : array ( '-' => ' ', )
					"ADD_SECTIONS_CHAIN"               =>  "N",                         // Включать раздел в цепочку навигации
					"SET_STATUS_404"                   =>  "N",                         // Устанавливать статус 404, если не найдены элемент или раздел
					"CACHE_FILTER"                     =>  "N",                         // Кешировать при установленном фильтре
					// endregion
					// region Настройки действий
					"ACTION_VARIABLE"                  =>  "action",                    // Название переменной, в которой передается действие
					"PRODUCT_ID_VARIABLE"              =>  "id",                        // Название переменной, в которой передается код товара для покупки
					// endregion
					// region Цены
					"PRICE_CODE"                       =>  array('BASE'),                   // Тип цены : array ( 'BASE' => '[BASE] Розничная цена', )
					"USE_PRICE_COUNT"                  =>  "N",                         // Использовать вывод цен с диапазонами
					"SHOW_PRICE_COUNT"                 =>  "1",                         // Выводить цены для количества
					"PRICE_VAT_INCLUDE"                =>  "Y",                         // Включать НДС в цену
					"CONVERT_CURRENCY"                 =>  "N",                         // Показывать цены в одной валюте
					// endregion
					// region Добавление в корзину
					"BASKET_URL"                       =>  "/personal/basket.php",      // URL, ведущий на страницу с корзиной покупателя
					"USE_PRODUCT_QUANTITY"             =>  "N",                         // Разрешить указание количества товара
					"PRODUCT_QUANTITY_VARIABLE"        =>  "quantity",                  // Название переменной, в которой передается количество товара
					"ADD_PROPERTIES_TO_BASKET"         =>  "Y",                         // Добавлять в корзину свойства товаров и предложений
					"PRODUCT_PROPS_VARIABLE"           =>  "prop",                      // Название переменной, в которой передаются характеристики товара
					"PARTIAL_PRODUCT_PROPERTIES"       =>  "N",                         // Разрешить добавлять в корзину товары, у которых заполнены не все характеристики
					"PRODUCT_PROPERTIES"               =>  array(''),                   // Характеристики товара
					// endregion
					// region Сравнение товаров
					"DISPLAY_COMPARE"                  =>  "N",                         // Разрешить сравнение товаров
					// endregion
					// region Настройки постраничной навигации
					"PAGER_TEMPLATE"                   =>  ".default",                  // Шаблон постраничной навигации : array ( '.default' => '.default (Встроенный шаблон)', 'arrows_adm' => 'arrows_adm (Встроенный шаблон)', 'modern' => 'modern (Встроенный шаблон)', 'orange' => 'orange (Встроенный шаблон)', 'visual' => 'visual (Встроенный шаблон)', 'blog' => 'blog (Общий шаблон)', 'forum' => 'forum (Общий шаблон)', 'arrows' => 'arrows (Новый адаптивный шаблон интернет-магазина)', )
					"DISPLAY_TOP_PAGER"                =>  "N",                         // Выводить над списком
					"DISPLAY_BOTTOM_PAGER"             =>  "Y",                         // Выводить под списком
					"PAGER_TITLE"                      =>  "Товары",                    // Название категорий
					"PAGER_SHOW_ALWAYS"                =>  "N",                         // Выводить всегда
					"PAGER_DESC_NUMBERING"             =>  "N",                         // Использовать обратную навигацию
					"PAGER_DESC_NUMBERING_CACHE_TIME"  =>  "36000",                     // Время кеширования страниц для обратной навигации
					"PAGER_SHOW_ALL"                   =>  "N",                         // Показывать ссылку 'Все'
					// endregion
				),
				$component
			);
			?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"smart_tizers_catalog",
				array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "Y",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "Y",
					"COMPONENT_TEMPLATE" => "smart_media_1",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "Y",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array(
						0 => "",
						1 => "",
					),
					"FILTER_NAME" => "",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => COption::GetOptionString( 'spro.wizard', 'ib-media',  '', SITE_ID ),
					"IBLOCK_TYPE" => "news",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
					"INCLUDE_SUBSECTIONS" => "Y",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "20",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array(
						0 => "",
						1 => "",
					),
					"SET_BROWSER_TITLE" => "Y",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "Y",
					"SET_META_KEYWORDS" => "Y",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "Y",
					"SHOW_404" => "N",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_BY2" => "SORT",
					"SORT_ORDER1" => "DESC",
					"SORT_ORDER2" => "ASC",
					"STRICT_SECTION_CHECK" => "N"
				),
				false
			);?>
		</div>
	</div>
</div>
