<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Application;
use Local\Util\HighloadblockManager;
use \Bitrix\Sale\Fuser;

$request = Application::getInstance()->getContext()->getRequest();

$productId = $request->getPost('productId') ?: '0';

if ($productId == '0') {
    die(json_encode(['SUCCESS' => false]));
}

$storeId = $request->getPost('storeId') ?: '0';
$mode = $request->getPost('mode') ?: 'ADD';
$quantity = $request->getPost('quantity') ?: '1';
$userId = 0;
$fUser = 0;

global $USER;

if ($USER->IsAuthorized()) {
    $userId = $USER->GetID();
} else {
    $fUser = Fuser::getId();
}

$customBasketsHl = new HighloadblockManager('CustomBaskets');

$customBasketsHl->prepareParamsQuery(
    [
        'ID',
        'UF_QUANTITY'
    ],
    [],
    [
        'UF_FUSER' => $fUser,
        'UF_PRODUCT_ID' => $productId,
        'UF_ORDER_ID' => 0,
        'UF_STORE_ID' => $storeId,
        'UF_USER_ID' => $userId
    ]
);

$product = $customBasketsHl->getData();

switch ($mode) {
    case 'ADD' :
        $fields = [
            'UF_FUSER' => $fUser,
            'UF_PRODUCT_ID' => $productId,
            'UF_QUANTITY' => $quantity,
            'UF_ORDER_ID' => 0,
            'UF_STORE_ID' => $storeId,
            'UF_USER_ID' => $userId
        ];

        $customBasketsHl->add($fields);

        die(json_encode(['SUCCESS' => true]));
    case 'UPDATE' :
        if (!empty($product)) {
            $fields = [
                'UF_QUANTITY' => $quantity
            ];

            $customBasketsHl->update($product['ID'], $fields);
            die(json_encode(['SUCCESS' => true]));
        }

        die(json_encode(['SUCCESS' => false]));
    case 'DELETE' :
        if (!empty($product)) {
            $customBasketsHl->delete($product['ID']);
            die(json_encode(['SUCCESS' => true]));
        }

        die(json_encode(['SUCCESS' => false]));
}