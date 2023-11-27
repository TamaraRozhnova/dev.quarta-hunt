<?php
/**
 * @param array $arParams
 * @param array $arResult
 * @global CMain $APPLICATION
 */
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Sale\Order;
use \Bitrix\Main\Grid\Declension;

Loc::loadMessages(__FILE__);

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
global $USER;

Loc::loadMessages(__FILE__);
CModule::IncludeModule('sale');

$arResult['USER']['ID'] = $USER->GetID();
$arResult['USER']['EMAIL'] = $USER->GetEmail();
$arResult['USER']['PERSONAL_PHONE'] = $USER->GetByID($USER->GetID())->Fetch()["PERSONAL_PHONE"];
$arResult['USER']['FIRST_NAME'] = $USER->GetFirstName();
$arResult['USER']['LAST_NAME'] = $USER->GetLastName();

$arResult['ORDERS'] = [];

$ordersCountData = \Bitrix\Sale\Order::getList([
    'select' => ['ID'],
    'filter' => ['=USER_ID' => $USER->GetID()],
    'order' => ['ID' => 'DESC'],
]);
$counter = 0;
while($orderCount = $ordersCountData -> fetch()){
    $counter++;
}
$arResult['USER']['ORDERS'] = $counter;

$ordersData = \Bitrix\Sale\Order::getList([
    'select' => ['ID', 'DATE_INSERT', 'PRICE', 'ACCOUNT_NUMBER'],
    'filter' => ['=USER_ID' => $USER->GetID()],
    'order' => ['ID' => 'DESC'],
    'limit' => 3
]);

while($order = $ordersData -> fetch()){
    $basket = \Bitrix\Sale\Order::load($order['ID'])->getBasket();

    foreach ($basket as $basketItem) {
        $basketItemId = $basketItem->getField('PRODUCT_ID');
        
        $mxResult = CCatalogSku::GetProductInfo($basketItemId);
        if (is_array($mxResult))
            $basketItemId = $mxResult['ID'];
        
        $res = CIBlockElement::GetByID($basketItemId);
        if($ar_res = $res->GetNext())
            $imagepath = CFile::GetPath($ar_res['DETAIL_PICTURE']);   
        
        break;
    }

    $order['PICTURE_PATH'] = $imagepath;
    $order['DATE_INSERT'] = $order['DATE_INSERT']->format("d.m.Y");

    $arResult['ORDERS'][] = $order;
}

$rsUser = CUser::GetByID(
    $USER->GetId()
)->fetch();

if (!empty($rsUser)) {
    if (!empty($rsUser['PERSONAL_CITY'])) {
        $arResult['USER_ADDRESS']['PERSONAL_CITY'] = $rsUser['PERSONAL_CITY'];
    }
    if (!empty($rsUser['PERSONAL_STREET'])) {
        $arResult['USER_ADDRESS']['PERSONAL_STREET'] = $rsUser['PERSONAL_STREET'];
    }
    if (!empty($rsUser['PERSONAL_MAILBOX'])) {
        $arResult['USER_ADDRESS']['PERSONAL_MAILBOX'] = $rsUser['PERSONAL_MAILBOX'];
    }
    if (!empty($rsUser['PERSONAL_ZIP'])) {
        $arResult['USER_ADDRESS']['PERSONAL_ZIP'] = $rsUser['PERSONAL_ZIP'];
    }

    $decBonus = new Declension(
        Loc::getMessage('BONUS_DEC_1'),
        Loc::getMessage('BONUS_DEC_2'),
        Loc::getMessage('BONUS_DEC_3')
    );

    $bonus = $rsUser['UF_LOGICTIM_BONUS'];

    if (empty($bonus)) $bonus = 0;

    $arResult['BONUS_DEC'] = $decBonus->get($bonus);
    $arResult['BONUS_COUNT'] = $bonus;

    $arResult['BONUS_DISPLAY'] = implode(' ', [
        $arResult['BONUS_COUNT'],
        $arResult['BONUS_DEC']
    ]);

}


