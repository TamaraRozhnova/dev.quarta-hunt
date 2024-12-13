<? if ( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain         $APPLICATION
 * @var CBitrixComponent $component
 * @var array            $arParams
 * @var array            $arResult
 * @var array            $arCurSection
 */

/** Баннер на странице каталога
<section class="hero pb-5">
    <div class="container">
        <a href="/catalog/?SECTION_ID=924"><img src="/catalog/ban111.png" alt=""></a>
    </div> 
</section>
 */

if (isset( $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] ) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = isset( $arParams['COMMON_ADD_TO_BASKET_ACTION'] )?$arParams['COMMON_ADD_TO_BASKET_ACTION']:'';
}
else
{
	$basketAction = isset( $arParams['SECTION_ADD_TO_BASKET_ACTION'] )?$arParams['SECTION_ADD_TO_BASKET_ACTION']:'';
}
?>


<div class="main section">
	<section class="inner">
		<div class="container">


            <img class="catalog_bnr" src="/local/templates/gaut-optics/images/catalog_bnr.png" alt="" >


			<div class="inner__wrapper">
                <div class="inner__left">
                    <div class="filter__title">СОРТИРОВКА</div>
                </div>
                <div class="inner__right">
                    <div class="filter">
                        <ul class="filter__ul">
                            <?php
                                $S = $_SESSION['sorting']??'';
                                $O = $_SESSION['sorting_asc']??'';
                            ?>
                            <li class="filter__li <?=($_SESSION["sorting"]=="name"?"active ".$O:"nactive")?>">
                                <a href="javascript:;" class="nav-link jslink" data-href="<?=$APPLICATION->GetCurPageParam("sorting=name&sorting_asc=".($S=='name'&&$O=='asc'?'desc':'asc'), array("sorting", "sorting_asc"));?>"><nobr>По названию<i></i></nobr></a>
                            </li>
                            <li class="filter__li <?=($_SESSION["sorting"]=="shows"?"active ".$O:"nactive")?>">
                                <a href="javascript:;" class="nav-link jslink" data-href="<?=$APPLICATION->GetCurPageParam("sorting=shows&sorting_asc=".($S=='shows'&&$O=='desc'?'asc':'desc'), array("sorting", "sorting_asc"));?>"><nobr>По популярности<i></i></nobr></a>
                            </li>
                            <li class="filter__li <?=($_SESSION["sorting"]=="SCALED_PRICE_1"?"active ".$O:"nactive")?>">
                                <a href="javascript:;" class="nav-link jslink" data-href="<?=$APPLICATION->GetCurPageParam("sorting=SCALED_PRICE_1&sorting_asc=".($S=='SCALED_PRICE_1'&&$O=='asc'?'desc':'asc'), array("sorting", "sorting_asc"));?>"><nobr>По цене<i></i></nobr></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
			<div class="inner__wrapper">
				<? if ($isFilter || $isSidebar): ?>
					<div class="inner__left">
                        <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:catalog.smart.filter",
                            "bootstrap_v4",
                            array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arCurSection['ID'],
                                "FILTER_NAME" => $arParams["FILTER_NAME"],
                                "PRICE_CODE" => $arParams["~PRICE_CODE"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "SAVE_IN_SESSION" => "N",
                                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                                "XML_EXPORT" => "N",
                                "SECTION_TITLE" => "NAME",
                                "SECTION_DESCRIPTION" => "DESCRIPTION",
                                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                "SEF_MODE" => $arParams["SEF_MODE"],
                                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                                "DISPLAY_ELEMENT_COUNT" => "N",
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );
                        ?>

						<?/* $APPLICATION->IncludeComponent(
							"bitrix:menu",
							"smart_sec_catalog",
							[
								"ALLOW_MULTI_SELECT" => "N",
								"CHILD_MENU_TYPE" => "left",
								"DELAY" => "N",
								"MAX_LEVEL" => "1",
								"MENU_CACHE_GET_VARS" => [
								],
								"MENU_CACHE_TIME" => "3600",
								"MENU_CACHE_TYPE" => "N",
								"MENU_CACHE_USE_GROUPS" => "Y",
								"ROOT_MENU_TYPE" => "top",
								"USE_EXT" => "N",
								"COMPONENT_TEMPLATE" => "smart_sec_catalog",
							],
							false
						); */?>

					</div>
				<? endif ?>
				<div class="inner__right">


					<?
					$sectionListParams = [
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
						"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
						"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
						"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
						"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
						"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
						"HIDE_SECTION_NAME" => ( isset( $arParams["SECTIONS_HIDE_SECTION_NAME"] )?$arParams["SECTIONS_HIDE_SECTION_NAME"]:"N" ),
						"ADD_SECTIONS_CHAIN" => ( isset( $arParams["ADD_SECTIONS_CHAIN"] )?$arParams["ADD_SECTIONS_CHAIN"]:'' ),
					];
					if ($sectionListParams["COUNT_ELEMENTS"] === "Y")
					{
						$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_ACTIVE";
						if ($arParams["HIDE_NOT_AVAILABLE"] == "Y")
						{
							$sectionListParams["COUNT_ELEMENTS_FILTER"] = "CNT_AVAILABLE";
						}
					}

					if ($arParams["USE_COMPARE"] == "Y")
					{
//						$APPLICATION->IncludeComponent(
//							"bitrix:catalog.compare.list",
//							"",
//							[
//								"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
//								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
//								"NAME" => $arParams["COMPARE_NAME"],
//								"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
//								"COMPARE_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
//								"ACTION_VARIABLE" => ( !empty( $arParams["ACTION_VARIABLE"] )?$arParams["ACTION_VARIABLE"]:"action" ),
//								"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
//								'POSITION_FIXED' => isset( $arParams['COMPARE_POSITION_FIXED'] )?$arParams['COMPARE_POSITION_FIXED']:'',
//								'POSITION' => isset( $arParams['COMPARE_POSITION'] )?$arParams['COMPARE_POSITION']:'',
//							],
//							$component,
//							[ "HIDE_ICONS" => "Y" ]
//						);
					}

//                    echo_j($arResult);

					$intSectionID = $APPLICATION->IncludeComponent(
						"bitrix:catalog.section",
						"orig",
						[
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
							"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
							"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
							"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
							"PROPERTY_CODE" => ( isset( $arParams["LIST_PROPERTY_CODE"] )?$arParams["LIST_PROPERTY_CODE"]:[] ),
							"PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
							"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
							"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
							"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
							"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
							"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
							"BASKET_URL" => $arParams["BASKET_URL"],
							"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
							"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
							"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
							"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
							"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
							"FILTER_NAME" => $arParams["FILTER_NAME"],
							"CACHE_TYPE" => $arParams["CACHE_TYPE"],
							"CACHE_TIME" => $arParams["CACHE_TIME"],
							"CACHE_FILTER" => $arParams["CACHE_FILTER"],
							"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							"SET_TITLE" => $arParams["SET_TITLE"],
							"MESSAGE_404" => $arParams["~MESSAGE_404"],
							"SET_STATUS_404" => $arParams["SET_STATUS_404"],
							"SHOW_404" => $arParams["SHOW_404"],
							"FILE_404" => $arParams["FILE_404"],
							"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
							"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
							"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							"PRICE_CODE" => $arParams["~PRICE_CODE"],
							"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
							"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

							"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
							"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
							"ADD_PROPERTIES_TO_BASKET" => ( isset( $arParams["ADD_PROPERTIES_TO_BASKET"] )?$arParams["ADD_PROPERTIES_TO_BASKET"]:'' ),
							"PARTIAL_PRODUCT_PROPERTIES" => ( isset( $arParams["PARTIAL_PRODUCT_PROPERTIES"] )?$arParams["PARTIAL_PRODUCT_PROPERTIES"]:'' ),
							"PRODUCT_PROPERTIES" => ( isset( $arParams["PRODUCT_PROPERTIES"] )?$arParams["PRODUCT_PROPERTIES"]:[] ),

							"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
							"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
							"PAGER_TITLE" => $arParams["PAGER_TITLE"],
							"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
							"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
							"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
							"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
							"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
							"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
							"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
							"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
							"LAZY_LOAD" => $arParams["LAZY_LOAD"],
							"MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
							"LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

							"OFFERS_CART_PROPERTIES" => ( isset( $arParams["OFFERS_CART_PROPERTIES"] )?$arParams["OFFERS_CART_PROPERTIES"]:[] ),
							"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
							"OFFERS_PROPERTY_CODE" => ( isset( $arParams["LIST_OFFERS_PROPERTY_CODE"] )?$arParams["LIST_OFFERS_PROPERTY_CODE"]:[] ),
							"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
							"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
							"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
							"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
							"OFFERS_LIMIT" => ( isset( $arParams["LIST_OFFERS_LIMIT"] )?$arParams["LIST_OFFERS_LIMIT"]:0 ),

							"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
							"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
							"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
							"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
							"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
							'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
							'CURRENCY_ID' => $arParams['CURRENCY_ID'],
							'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
							'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

							'LABEL_PROP' => $arParams['LABEL_PROP'],
							'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
							'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
							'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
							'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
							'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
							'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
							'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
							'ENLARGE_PROP' => isset( $arParams['LIST_ENLARGE_PROP'] )?$arParams['LIST_ENLARGE_PROP']:'',
							'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
							'SLIDER_INTERVAL' => isset( $arParams['LIST_SLIDER_INTERVAL'] )?$arParams['LIST_SLIDER_INTERVAL']:'',
							'SLIDER_PROGRESS' => isset( $arParams['LIST_SLIDER_PROGRESS'] )?$arParams['LIST_SLIDER_PROGRESS']:'',

							'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
							'OFFER_TREE_PROPS' => ( isset( $arParams['OFFER_TREE_PROPS'] )?$arParams['OFFER_TREE_PROPS']:[] ),
							'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
							'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
							'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
							'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
							'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
							'MESS_SHOW_MAX_QUANTITY' => ( isset( $arParams['~MESS_SHOW_MAX_QUANTITY'] )?$arParams['~MESS_SHOW_MAX_QUANTITY']:'' ),
							'RELATIVE_QUANTITY_FACTOR' => ( isset( $arParams['RELATIVE_QUANTITY_FACTOR'] )?$arParams['RELATIVE_QUANTITY_FACTOR']:'' ),
							'MESS_RELATIVE_QUANTITY_MANY' => ( isset( $arParams['~MESS_RELATIVE_QUANTITY_MANY'] )?$arParams['~MESS_RELATIVE_QUANTITY_MANY']:'' ),
							'MESS_RELATIVE_QUANTITY_FEW' => ( isset( $arParams['~MESS_RELATIVE_QUANTITY_FEW'] )?$arParams['~MESS_RELATIVE_QUANTITY_FEW']:'' ),
							'MESS_BTN_BUY' => ( isset( $arParams['~MESS_BTN_BUY'] )?$arParams['~MESS_BTN_BUY']:'' ),
							'MESS_BTN_ADD_TO_BASKET' => ( isset( $arParams['~MESS_BTN_ADD_TO_BASKET'] )?$arParams['~MESS_BTN_ADD_TO_BASKET']:'' ),
							'MESS_BTN_SUBSCRIBE' => ( isset( $arParams['~MESS_BTN_SUBSCRIBE'] )?$arParams['~MESS_BTN_SUBSCRIBE']:'' ),
							'MESS_BTN_DETAIL' => ( isset( $arParams['~MESS_BTN_DETAIL'] )?$arParams['~MESS_BTN_DETAIL']:'' ),
							'MESS_NOT_AVAILABLE' => ( isset( $arParams['~MESS_NOT_AVAILABLE'] )?$arParams['~MESS_NOT_AVAILABLE']:'' ),
							'MESS_BTN_COMPARE' => ( isset( $arParams['~MESS_BTN_COMPARE'] )?$arParams['~MESS_BTN_COMPARE']:'' ),

							'USE_ENHANCED_ECOMMERCE' => ( isset( $arParams['USE_ENHANCED_ECOMMERCE'] )?$arParams['USE_ENHANCED_ECOMMERCE']:'' ),
							'DATA_LAYER_NAME' => ( isset( $arParams['DATA_LAYER_NAME'] )?$arParams['DATA_LAYER_NAME']:'' ),
							'BRAND_PROPERTY' => ( isset( $arParams['BRAND_PROPERTY'] )?$arParams['BRAND_PROPERTY']:'' ),

							'TEMPLATE_THEME' => ( isset( $arParams['TEMPLATE_THEME'] )?$arParams['TEMPLATE_THEME']:'' ),
							"ADD_SECTIONS_CHAIN" => "Y",
							'ADD_TO_BASKET_ACTION' => $basketAction,
							'SHOW_CLOSE_POPUP' => isset( $arParams['COMMON_SHOW_CLOSE_POPUP'] )?$arParams['COMMON_SHOW_CLOSE_POPUP']:'',
							'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
							'COMPARE_NAME' => $arParams['COMPARE_NAME'],
							'USE_COMPARE_LIST' => 'Y',
							'BACKGROUND_IMAGE' => ( isset( $arParams['SECTION_BACKGROUND_IMAGE'] )?$arParams['SECTION_BACKGROUND_IMAGE']:'' ),
							'COMPATIBLE_MODE' => ( isset( $arParams['COMPATIBLE_MODE'] )?$arParams['COMPATIBLE_MODE']:'' ),
							'DISABLE_INIT_JS_IN_COMPONENT' => ( isset( $arParams['DISABLE_INIT_JS_IN_COMPONENT'] )?$arParams['DISABLE_INIT_JS_IN_COMPONENT']:'' ),
						],
						$component
					);

                    $GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
					?>
				</div>
			</div>




            <div class="section section-similar section-slider">
                <?
                //echo '<pre>';print_r($arParams);echo '</pre>';
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "recomm",                            // [.default, board, links, list]
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
                        "CACHE_TYPE"                       =>  "N",                         // Тип кеширования : array ( 'A' => 'Авто + Управляемое', 'Y' => 'Кешировать', 'N' => 'Не кешировать', )
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

            </div>



            <? $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "smart_tizers",
                [
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "N",
                    "CHECK_DATES" => "Y",
                    "COMPONENT_TEMPLATE" => "smart_media_1",
                    "DETAIL_URL" => "",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "Y",
                    "DISPLAY_PREVIEW_TEXT" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => [
                        0 => "",
                        1 => "",
                    ],
                    "FILTER_NAME" => "",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "IBLOCK_ID" => IBLOCKS['ib-tizers'],
                    "IBLOCK_TYPE" => SITE_ID,
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
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
                    "PROPERTY_CODE" => [
                        0 => "",
                        1 => "",
                    ],
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N",
                ],
                false
            ); ?>


	</section>
<div>


