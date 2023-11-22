<?

use Spro\Image;

require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php" );
$APPLICATION->SetTitle("О магазине");
$APPLICATION->SetPageProperty("title", "О магазине");
?>

<p class="text">Наше дело не так однозначно, как может показаться: новая модель организационной деятельности способствует повышению качества прогресса профессионального
	сообщества. Значимость этих проблем настолько очевидна, что убеждённость некоторых оппонентов не даёт нам иного выбора, кроме определения как самодостаточных, так и
	внешне зависимых концептуальных решений. Предварительные выводы неутешительны: курс на социально-ориентированный национальный проект однозначно определяет каждого
	участника как способного принимать собственные решения касаемо существующих финансовых и административных условий.</p>
<?php
// Список новостей
$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"photos",                            // [bottom, .default, official, table]
	array(
		// region Основные параметры
		"IBLOCK_TYPE"                      =>  "news",              // Тип информационного блока (используется только для проверки) : array ( '-' => ' ', 'catalog' => '[catalog] Каталоги', 'news' => '[news] Новости', 'offers' => '[offers] Торговые предложения', 'services' => '[services] Сервисы', 'references' => '[references] Справочники', )
		"IBLOCK_ID"                        =>  "11",  // Код информационного блока : array ( 1 => 'Новости', 2 => 'Одежда', 3 => 'Одежда (предложения)', )
		"NEWS_COUNT"                       =>  "20",                // Количество новостей на странице
		// endregion
		// region Источник данных
		"SORT_BY1"                         =>  "SORT",       // Поле для первой сортировки новостей : array ( 'ID' => 'ID', 'NAME' => 'Название', 'ACTIVE_FROM' => 'Дата начала активности', 'SORT' => 'Сортировка', 'TIMESTAMP_X' => 'Дата последнего изменения', )
		"SORT_ORDER1"                      =>  "ASC",              // Направление для первой сортировки новостей : array ( 'ASC' => 'По возрастанию', 'DESC' => 'По убыванию', )
		"SORT_BY2"                         =>  "SORT",              // Поле для второй сортировки новостей : array ( 'ID' => 'ID', 'NAME' => 'Название', 'ACTIVE_FROM' => 'Дата начала активности', 'SORT' => 'Сортировка', 'TIMESTAMP_X' => 'Дата последнего изменения', )
		"SORT_ORDER2"                      =>  "ASC",               // Направление для второй сортировки новостей : array ( 'ASC' => 'По возрастанию', 'DESC' => 'По убыванию', )
		"FILTER_NAME"                      =>  "",                  // Фильтр
		"FIELD_CODE"                       =>  array(''),           // Поля : array ( 'ID' => 'ID', 'CODE' => 'Символьный код', 'XML_ID' => 'Внешний код', 'NAME' => 'Название', 'TAGS' => 'Теги', 'SORT' => 'Сортировка', 'PREVIEW_TEXT' => 'Описание для анонса', 'PREVIEW_PICTURE' => 'Картинка для анонса', 'DETAIL_TEXT' => 'Детальное описание', 'DETAIL_PICTURE' => 'Детальная картинка', 'DATE_ACTIVE_FROM' => 'Начало активности (дата)', 'ACTIVE_FROM' => 'Начало активности (время)', 'DATE_ACTIVE_TO' => 'Окончание активности (дата)', 'ACTIVE_TO' => 'Окончание активности (время)', 'SHOW_COUNTER' => 'Количество показов', 'SHOW_COUNTER_START' => 'Дата первого показа', 'IBLOCK_TYPE_ID' => 'Тип информационного блока', 'IBLOCK_ID' => 'ID информационного блока', 'IBLOCK_CODE' => 'Символьный код информационного блока', 'IBLOCK_NAME' => 'Название информационного блока', 'IBLOCK_EXTERNAL_ID' => 'Внешний код информационного блока', 'DATE_CREATE' => 'Дата создания', 'CREATED_BY' => 'Кем создан (ID)', 'CREATED_USER_NAME' => 'Кем создан (имя)', 'TIMESTAMP_X' => 'Дата изменения', 'MODIFIED_BY' => 'Кем изменен (ID)', 'USER_NAME' => 'Кем изменен (имя)', )
		"PROPERTY_CODE"                    =>  array(''),           // Свойства
		"CHECK_DATES"                      =>  "Y",                 // Показывать только активные на данный момент элементы
		// endregion
		// region Шаблоны ссылок
		"DETAIL_URL"                       =>  "",                  // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		// endregion
		// region Управление режимом AJAX
		"AJAX_MODE"                        =>  "N",                 // Включить режим AJAX
		"AJAX_OPTION_JUMP"                 =>  "N",                 // Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE"                =>  "Y",                 // Включить подгрузку стилей
		"AJAX_OPTION_HISTORY"              =>  "N",                 // Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL"           =>  "",                  // Дополнительный идентификатор
		// endregion
		// region Настройки кеширования
		"CACHE_TYPE"                       =>  "A",                 // Тип кеширования : array ( 'A' => 'Авто + Управляемое', 'Y' => 'Кешировать', 'N' => 'Не кешировать', )
		"CACHE_TIME"                       =>  "36000000",          // Время кеширования (сек.)
		"CACHE_NOTES"                      =>  "",                  //
		"CACHE_FILTER"                     =>  "N",                 // Кешировать при установленном фильтре
		"CACHE_GROUPS"                     =>  "Y",                 // Учитывать права доступа
		// endregion
		// region Дополнительные настройки
		"PREVIEW_TRUNCATE_LEN"             =>  "",                  // Максимальная длина анонса для вывода (только для типа текст)
		"ACTIVE_DATE_FORMAT"               =>  "d.m.Y",             // Формат показа даты : array ( 'd-m-Y' => '22-02-2007', 'm-d-Y' => '02-22-2007', 'Y-m-d' => '2007-02-22', 'd.m.Y' => '22.02.2007', 'd.M.Y' => '22.Фев.2007', 'm.d.Y' => '02.22.2007', 'j M Y' => '22 Фев 2007', 'M j, Y' => 'Фев 22, 2007', 'j F Y' => '22 Февраля 2007', 'f j, Y' => 'Февраль 22, 2007', 'd.m.y g:i A' => '22.02.07 7:30 AM', 'd.M.y g:i A' => '22.Фев.07 7:30 AM', 'd.M.Y g:i A' => '22.Фев.2007 7:30 AM', 'd.m.y G:i' => '22.02.07 7:30', 'd.m.Y H:i' => '22.02.2007 07:30', 'SHORT' => 'Формат сайта', 'FULL' => 'Формат сайта (включая время)', )
		"SET_TITLE"                        =>  "Y",                 // Устанавливать заголовок страницы
		"SET_BROWSER_TITLE"                =>  "Y",                 // Устанавливать заголовок окна браузера
		"SET_META_KEYWORDS"                =>  "Y",                 // Устанавливать ключевые слова страницы
		"SET_META_DESCRIPTION"             =>  "Y",                 // Устанавливать описание страницы
		"SET_STATUS_404"                   =>  "N",                 // Устанавливать статус 404, если не найдены элемент или раздел
		"INCLUDE_IBLOCK_INTO_CHAIN"        =>  "Y",                 // Включать инфоблок в цепочку навигации
		"ADD_SECTIONS_CHAIN"               =>  "Y",                 // Включать раздел в цепочку навигации
		"HIDE_LINK_WHEN_NO_DETAIL"         =>  "N",                 // Скрывать ссылку, если нет детального описания
		"PARENT_SECTION"                   =>  "",                  // ID раздела
		"PARENT_SECTION_CODE"              =>  "",                  // Код раздела
		"INCLUDE_SUBSECTIONS"              =>  "Y",                 // Показывать элементы подразделов раздела
		// endregion
		// region Настройки постраничной навигации
		"PAGER_TEMPLATE"                   =>  ".default",          // Шаблон постраничной навигации : array ( '.default' => '.default (Встроенный шаблон)', 'arrows_adm' => 'arrows_adm (Встроенный шаблон)', 'modern' => 'modern (Встроенный шаблон)', 'orange' => 'orange (Встроенный шаблон)', 'visual' => 'visual (Встроенный шаблон)', 'blog' => 'blog (Общий шаблон)', 'forum' => 'forum (Общий шаблон)', 'arrows' => 'arrows (Новый адаптивный шаблон интернет-магазина)', )
		"DISPLAY_TOP_PAGER"                =>  "N",                 // Выводить над списком
		"DISPLAY_BOTTOM_PAGER"             =>  "Y",                 // Выводить под списком
		"PAGER_TITLE"                      =>  "Новости",           // Название категорий
		"PAGER_SHOW_ALWAYS"                =>  "N",                 // Выводить всегда
		"PAGER_DESC_NUMBERING"             =>  "N",                 // Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME"  =>  "36000",             // Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL"                   =>  "N",                 // Показывать ссылку 'Все'
		// endregion
	)
);
?>
<h2 class="section__sub-title">заголовок</h2>
<p class="text">Наше дело не так однозначно, как может показаться: новая модель организационной деятельности способствует повышению качества прогресса профессионального
	сообщества. Значимость этих проблем настолько очевидна, что убеждённость некоторых оппонентов не даёт нам иного выбора, кроме определения как самодостаточных, так и
	внешне зависимых концептуальных решений. Предварительные выводы неутешительны: курс на социально-ориентированный национальный проект однозначно определяет каждого
	участника как способного принимать собственные решения касаемо существующих финансовых и административных условий.</p>
<div class="customers__characteristics">
	<div class="characteristic-card">
                <span class="lt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="lb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<h3 class="characteristic-card__title"> Лучшие цены </h3>
		<p class="characteristic-card__text"> Рыбатекст используется дизайнерами, проектировщиками и фронтендерами </p>
	</div>
	<div class="characteristic-card">
                <span class="lt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="lb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<h3 class="characteristic-card__title"> Лучшие цены </h3>
		<p class="characteristic-card__text"> Рыбатекст используется дизайнерами, проектировщиками и фронтендерами </p>
	</div>
	<div class="characteristic-card">
                <span class="lt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="lb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<h3 class="characteristic-card__title"> Лучшие цены </h3>
		<p class="characteristic-card__text"> Рыбатекст используется дизайнерами, проектировщиками и фронтендерами </p>
	</div>
	<div class="characteristic-card">
                <span class="lt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rt-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="lb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<span class="rb-plus">
                 <? Image::showSVG( 'plus' ) ?>
                </span>
		<h3 class="characteristic-card__title"> Лучшие цены </h3>
		<p class="characteristic-card__text"> Рыбатекст используется дизайнерами, проектировщиками и фронтендерами </p>
	</div>
</div>
<h2 class="section__sub-title">заголовок</h2>
<ul class="customers__list section-list">
	<li class="section-list__item"> Наше дело не так однозначно, как может показаться: новая модель организационной деятельности</li>
	<li class="section-list__item"> Наше дело не так однозначно, как может показаться: новая модель организационной деятельности</li>
	<li class="section-list__item"> Наше дело не так однозначно, как может показаться: новая модель организационной деятельности</li>
</ul>
<h2 class="section__sub-title  lg-none">Продукция</h2>
<p class="text  lg-none">Рыбатекст используется дизайнерами, проектировщиками и фронтендерами, когда нужно быстро заполнить макеты</p>
<div class="products  lg-none">
	<div class="products__card">
		<svg class="icon icon-yg-acoustics">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-yg-acoustics"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-grimm-audio">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-grimm-audio"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-less-loss">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-less-loss"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-way">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-way"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-yg-acoustics">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-yg-acoustics"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-grimm-audio">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-grimm-audio"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-less-loss">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-less-loss"></use>
		</svg>
	</div>
	<div class="products__card">
		<svg class="icon icon-way">
			<use xlink:href="<?=SITE_TEMPLATE_PATH?>/img/sprite.svg#icon-way"></use>
		</svg>
	</div>
</div>


<? require( $_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php" ); ?>
