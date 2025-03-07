<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Application;
use Bitrix\Sale\Basket;
use \Bitrix\Main\Loader;
use \Bitrix\Sale\Fuser;
use Bitrix\Currency\CurrencyManager;

$request = Application::getInstance()->getContext()->getRequest();

$products = $request->getPost('products') ?: [];

if (
    empty($products) ||
    !Loader::includeModule('sale')
) {
    die(json_encode(['SUCCESS' => false]));
}

$fUser = Fuser::getId();

$_SESSION['PRODUCTS_IN_ORDER'] = [];

$basket = Basket::loadItemsForFUser($fUser, SITE_ID);
$basketItems = $basket->getBasketItems();

if (is_array($basketItems) && !empty($basketItems)) {
    foreach ($basketItems as $basketItem) {
        $basket->getItemById($basketItem->getId())->delete();
    }
}

foreach ($products as $product) {
    $item = $basket->createItem('catalog', $product['ID']);

    $item->setFields(array(
        'QUANTITY' => $product['QUANTITY'],
        'CURRENCY' => CurrencyManager::getBaseCurrency(),
        'LID' => SITE_ID,
        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider'
    ));

    $_SESSION['PRODUCTS_IN_ORDER'][] = [
        'ID' => $product['ID'],
        'STORE_ID' => explode(',', $product['STORE_ID'])
    ];
}

if ($basket->save()) {
    die(json_encode(['SUCCESS' => true]));
}

die(json_encode(['SUCCESS' => false]));