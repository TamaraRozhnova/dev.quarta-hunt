<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Sale\DiscountCouponsManagerBase;

Loader::includeModule('sale');

$eventManager = EventManager::getInstance();

$eventManager->addEventHandler(
    "sale",
    "OnSaleOrderSaved",
    [
        "CustomEvents\SaleOrderAjaxEventsO2K",
        "eventNewOrder"
    ]
);

$eventManager->addEventHandler(
    "sale",
    "\Bitrix\Sale\Internals\Discount::OnAfterUpdate",
    array(
        "CustomEvents\RulesBasket",
        "OnAfterAddDiscountTable"
    )
);

$eventManager->addEventHandler(
    "sale",
    "\Bitrix\Sale\Internals\Discount::OnAfterAdd",
    array(
        "CustomEvents\RulesBasket",
        "OnAfterAddDiscountTable"
    )
);

$eventManager->addEventHandler(
    "sale",
    "\Bitrix\Sale\Internals\Discount::OnBeforeDelete",
    array(
        "CustomEvents\RulesBasket",
        "OnBeforeDeleteDiscountTable"
    )
);

$eventManager->addEventHandler(
    'sale',
    'OnSalePaymentEntitySaved',
    'changeOrderStatus'
);

$eventManager->addEventHandler(
    'main',
    'OnBeforeUserLogin',
    [
        'CustomEvents\CUserEx',
        'OnBeforeUserLogin'
    ]
);

$eventManager->addEventHandler(
    'main',
    'OnBeforeUserRegister',
    [
        'CustomEvents\CUserEx',
        'OnBeforeUserRegister'
    ]
);

$eventManager->addEventHandler(
    'main',
    'OnAfterUserRegister',
    [
        'CustomEvents\CUserEx',
        'OnAfterUserRegister'
    ]
);

//Применение скидки по купону, только если заказ первый
$eventManager->addEventHandler(
    'sale',
    DiscountCouponsManagerBase::EVENT_ON_COUPON_ADD,
    ['CustomEvents\OnDiscount', 'onManagerCouponAddHandler']
);

//не менять символьный код при обновении из 1с
$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementUpdate',
    ['CustomEvents\OnBeforeIBlockElementUpdate', 'OnBeforeIBlockElementUpdateHandler']
);

// SEO, w3org
$eventManager->addEventHandler(
    'main',
    'OnEndBufferContent',
    'removeType'
);