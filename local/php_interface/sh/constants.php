<?php

const COMPARE_LIST_NAME = 'CATALOG_COMPARE_LIST';

const CATALOG_IBLOCK_ID = 71; // Идентификатор инфоблока каталога
const CATALOG_IBLOCK_CODE = "1c_catalog"; // Символьный код инфоблока каталога

const IBLOCKS = [
    'ib-main-slider' => 73,
    'ib-tizers' => 74,
    'ib-glasses' => 75,
    'ib-pistol' => 76,
    'ib-faq' => 77,
    'ib-media' => 78,
    'ib-catalog' => 71,
    'ib-review' => 79,
    'ib-from' => 80,
    'ib-news' => 81,
    'news' => 81,
    'about-photo' => 82,
    'payment' => 82,
    'delivery' => 82,
];

const OPT_PRICE_ID = 3;
const BASE_PRICE_ID = 1;

const OPT_GROUP_ID = 9;

const OPT_PRICE_CODE = 'OPT';
const BASE_PRICE_CODE = 'BASE';

const OPT_PRICE_CODE_ID = 'PRICE_3';
const BASE_PRICE_CODE_ID = 'PRICE_1';

const UKASSA_ID = 3; // Идентификатор платежной системы Юкасса
const PANYWAY_ID = 4; // Идентификатор платежной системы Банковская карта PANYWAY
const BANK_TRANSFER_ID = 8; // Идентификатор платежной системы перевод БК
const DEBET_CARD_PERSONALLY_ID = 2; // Идентификатор платежной системы Банковские карты (при получении)
const CASH_PERSONALLY_ID = 1; // Идентификатор платежной системы Наличные (при получении)

const DELIVERY_PICKUP_ID = 3; // Идентификатор службы доставки Самовывоз

const DELIVERY_RF_POST = 6; // Идентификатор службы доставки Почта РФ Доставка в отеделение
const DELIVERY_RF_COURIER = 7; // Идентификатор службы доставки Почта РФ Доставка курьером

const DELIVERY_SDEK_PICKUP = 13; // Идентификатор службы доставки Сдек Самовывоз 
const DELIVERY_SDEK_COURIER = 12; // Идентификатор службы доставки Сдек Доставка курьером