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

const PANYWAY_ID = 4; // Идентификатор платежной системы Банковская карта PANYWAY
const BANK_TRANSFER_ID = 8; // Идентификатор платежной системы перевод БК
const DEBET_CARD_PERSONALLY_ID = 2; // Идентификатор платежной системы Банковские карты (при получении)
const CASH_PERSONALLY_ID = 1; // Идентификатор платежной системы Наличные (при получении)

const DELIVERY_PICKUP_ID = 3; // Идентификатор службы доставки Самовывоз

const DELIVERY_RF_POST = 6; // Идентификатор службы доставки Почта РФ Доставка в отеделение
const DELIVERY_RF_COURIER = 7; // Идентификатор службы доставки Почта РФ Доставка курьером

const DELIVERY_SDEK_PICKUP = 13; // Идентификатор службы доставки Сдек Самовывоз 
const DELIVERY_SDEK_COURIER = 12; // Идентификатор службы доставки Сдек Доставка курьером

const RESTRICTED_SECTIONS_FOF_FAST_BUY = 'oruzhie_i_patrony'; // Код раздела, в котором не выводится кнопка покупки в 1 клик
const EXCEPTIONS_FOR_FAST_BUY = 'oruzhie_i_patrony'; // Код раздела, в котором не выводится кнопка покупки в 1 клик
const CDEK_DELIVERY_ID = 11; // ID службы доставки СДЭК. Необхоим для получения списка разшрешённых категорий
const CDEK_RESTRICTION_SECTIONS_RULE_ID = 35; // ID ограничения со списков разрешённых категорий для доставки