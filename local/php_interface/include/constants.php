<?php

const COMPARE_LIST_NAME = 'CATALOG_COMPARE_LIST';

const CATALOG_IBLOCK_ID = 16; // Идентификатор инфоблока каталога
const CATALOG_IBLOCK_CODE = "catalog1c_main"; // Символьный код инфоблока каталога

const REVIEWS_IBLOCK_ID = 11; // Идентификатор инфоблока отзывов

const OPT_PRICE_ID = 3;
const BASE_PRICE_ID = 1;

const OPT_GROUP_ID = 9;

const OPT_PRICE_CODE = 'OPT';
const BASE_PRICE_CODE = 'BASE';

const OPT_PRICE_CODE_ID = 'PRICE_3';
const BASE_PRICE_CODE_ID = 'PRICE_1';

// Лицензионные разделы каталога
const SECTIONS_LICENSED = array("584", "585", "586", "588", "589", "590", "593", "594", "597", "600", "775", "802", "803", "804", "855", "904", '808');

// Разделы, где выводить модальное окно с подтвержденеим возраста
const SECTIONS_ATTENTION_MODAL = [583];

const LINK_CREDIT_ARTICLE = '/blog/news/rassrochka/'; // Ссылка на кнопку "Подробнее" в тултипе кредита

const UKASSA_ID = 25; //3 == 25 Идентификатор платежной системы Юкасса
const UKASSA_CREDIT_ID = 28; //16 == 28Идентификатор платежной системы Юкасса.Рассрочка
const PANYWAY_ID = 4; // Идентификатор платежной системы Банковская карта PANYWAY
const BANK_TRANSFER_ID = 22; //8 == 22 Идентификатор платежной системы перевод БК
const DEBET_CARD_PERSONALLY_ID = 24; //2 == 24 Идентификатор платежной системы Банковские карты (при получении)
const CASH_PERSONALLY_ID = 23; //1 == 23 Идентификатор платежной системы Наличные (при получении)

const DELIVERY_PICKUP_ID = 3; // Идентификатор службы доставки Самовывоз

const DELIVERY_RF_POST = 6; // Идентификатор службы доставки Почта РФ Доставка в отеделение
const DELIVERY_RF_COURIER = 7; // Идентификатор службы доставки Почта РФ Доставка курьером

const DELIVERY_SDEK_PICKUP = 115; // Идентификатор службы доставки Сдек Самовывоз 
const DELIVERY_SDEK_COURIER = 114; // Идентификатор службы доставки Сдек Доставка курьером

const RESTRICTED_SECTIONS_FOF_FAST_BUY = 'oruzhie_i_patrony'; // Код раздела, в котором не выводится кнопка покупки в 1 клик
const EXCEPTIONS_FOR_FAST_BUY = 'oruzhie_i_patrony'; // Код раздела, в котором не выводится кнопка покупки в 1 клик
const CDEK_DELIVERY_ID = 113; // ID службы доставки СДЭК. Необхоим для получения списка разшрешённых категорий
const CDEK_RESTRICTION_SECTIONS_RULE_ID = 210; // ID ограничения со списков разрешённых категорий для доставки

/** HUT */
const IMG_PATH = '/img';
const ICON_PATH = '/img/icons';
const HUT_CATALOG_IBLOCK_ID = 107;

// фильтр разделов для блока на главной
$GLOBALS['mainSectionsFilter'] = ['UF_SHOW_ON_MAIN' => 1];

// фильтр элементов для стартовой страницы каталога
$GLOBALS['mainCatalogFilter'] = ['PROPERTY_IS_TOP_VALUE' => "Y"];

// Справочник размеров одежды
const CLOTHES_SIZE_HL_ENTITY = 'Hutclothessize';

// Справочник температурных режимов
const TEMPERATURE_HL_ENTITY = 'Temperature';

// Код свойства каталога торговых предложений для размера одежды
const OFFERS_CLOTHES_SIZE_PROP_CODE = 'CLOTHES_SIZE';

// код HL блока Цветов торговых предложений HUT
const HUT_OFFERS_COLOR_HL_CODE = 'Hutcolors';

// код HL блока Цветов торговых предложений HUT из 1С
const HUT_OFFERS_COLOR_HL_CODE_ONE_C = 'TSVET';

const HUT_FAVORITES_COOCKIE_NAME = 'hut_favorites';

// ID свойства Размер торговых предложений, приходящих из 1С
const HUT_SIZE_PROP_ID_1C = 1506;

// ID каталога торговых предложений
const HUT_CATALOG_OFFERS_IBLOCK_ID = 108;

// код HL блока кастомных корзин
const QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE = 'CustomBaskets';

// код HL блока по сохранению запросов СДЭК
const QUARTA_HL_SDEK_DELIVERY_DATES_BLOCK_CODE = 'SdekDeliveryDates';

// код HL блока по сохранению запросов Почты России
const QUARTA_HL_RUSSIAN_POST_DELIVERY_DATES_BLOCK_CODE = 'RussianPostDeliveryDates';

// код HL блока по сохранению запросов к сервису Dadata
const QUARTA_HL_DADATA_DELIVERY_DATES_BLOCK_CODE = 'ZipCodes';