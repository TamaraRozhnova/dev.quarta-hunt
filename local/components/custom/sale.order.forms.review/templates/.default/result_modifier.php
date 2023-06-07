<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */


use \Bitrix\Sale\OrderId;

$entityOrder = new \OrderId();
$arResult['PRODUCTS'] = $entityOrder->getOrderBasket($arParams['ORDER_NUMBER'], 'NAME');

$arResult['FORM_FIELDS'] = [
	"RATING" => [
		"TEXT" => "Ваша оценка",
		"NAME" => "rating"
	],
	"MINUSES" => [
		"TEXT" => "Недостатки",
		"NAME" => "flaws",
	],
	"PLUSES" => [
		"TEXT" => "Достоинства",
		"NAME" => "dignities"
	],
	"COMMENT" => [
		"TEXT" => "Комментарий",
		"NAME" => "comments"
	],
	"FILE_UPLOAD" => [
		"TEXT" => "Прикрепить файл (не более 5MB)",
		"NAME" => "file-upload"
	],
];

foreach ($arResult['PRODUCTS'] as $arProduct) {
    $arProductsIDS[$arProduct['ID']] = $arProduct['ID'];
}

/** Проверка на уже существующий отзыв 
 * пользователя на товар */

 $rsElement = \Bitrix\Iblock\Elements\ElementFeedbackTable::getList([
    "select" => [
        "NAME",
        "ID",
        "USER_ID_" => "USER_ID",
        "PRODUCT_ID_" => "PRODUCT_ID"
    ],
    "filter" => [
        "=USER_ID.VALUE" => $USER->getId(),
        "=PRODUCT_ID.VALUE" => $arProductsIDS
    ]
 ])->fetchAll();

 if (!empty($rsElement)) {
    foreach ($rsElement as $arElement) {
        foreach ($arResult['PRODUCTS'] as $arProductIndex => $arProduct) {
            if ((int)$arElement['PRODUCT_ID_VALUE'] == $arProduct['ID']) {
                $arResult['PRODUCTS'][$arProductIndex]['REVIEW_SEND'] = 'Y';
            }
        }
    }
 }
