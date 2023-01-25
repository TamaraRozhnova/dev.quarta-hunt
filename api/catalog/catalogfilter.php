<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

define("FILTER_VALUES", true);

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
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>