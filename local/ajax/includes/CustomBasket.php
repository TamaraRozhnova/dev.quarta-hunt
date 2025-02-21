<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Application;
use Local\Util\HighloadblockManager;
use \Bitrix\Sale\Fuser;

$request = Application::getInstance()->getContext()->getRequest();

$productId = intval($request->getPost('productId')) ?: 0;

if ($productId === 0) {
    die(json_encode(['SUCCESS' => false]));
}

$storeId = intval($request->getPost('storeId')) ?: 0;
$mode = (string)$request->getPost('mode') ?: 'ADD';
$quantity = intval($request->getPost('quantity')) ?: 1;

$fUser = Fuser::getId();

$customBasketsHl = new HighloadblockManager(QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE);

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
        'UF_STORE_ID' => $storeId
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
            'UF_STORE_ID' => $storeId
        ];

        $result = $customBasketsHl->add($fields);

        if ($result->isSuccess()) {
            die(json_encode(['SUCCESS' => true]));
        }

        die(json_encode([
            'SUCCESS' => false,
            'ERROR_MESSAGE' => implode(', ', $result->getErrorMessages())
        ]));
    case 'UPDATE' :
        if (!empty($product)) {
            $fields = [
                'UF_QUANTITY' => $quantity
            ];

            $result = $customBasketsHl->update($product['ID'], $fields);

            if ($result->isSuccess()) {
                die(json_encode(['SUCCESS' => true]));
            }

            die(json_encode([
                'SUCCESS' => false,
                'ERROR_MESSAGE' => implode(', ', $result->getErrorMessages())
            ]));
        }

        die(json_encode([
            'SUCCESS' => false,
            'ERROR_MESSAGE' => 'empty product'
        ]));
    case 'DELETE' :
        if (!empty($product)) {
            $result = $customBasketsHl->delete($product['ID']);

            if ($result->isSuccess()) {
                die(json_encode(['SUCCESS' => true]));
            }

            die(json_encode([
                'SUCCESS' => false,
                'ERROR_MESSAGE' => implode(', ', $result->getErrorMessages())
            ]));
        }

        die(json_encode([
            'SUCCESS' => false,
            'ERROR_MESSAGE' => 'empty product'
        ]));
}