<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Application;
use Local\Util\HighloadblockManager;
use \Bitrix\Sale\Fuser;
use \Bitrix\Catalog\StoreProductTable;

$request = Application::getInstance()->getContext()->getRequest();

$productId = $request->getPost('productId') ?: '0';
$storeIds = $request->getPost('storeIds') ?: null;
$quantity = $request->getPost('quantity') ?: '0';
$mode = $request->getPost('mode') ?: 'all';

if (
    $productId == '0' ||
    $storeIds == null ||
    $quantity == '0'
) {
    die(json_encode(['SUCCESS' => false]));
}

$storeIds = explode(',', $storeIds);
$userId = 0;
$fUser = Fuser::getId();

switch ($mode) {
    case 'store' :
        $customBasketsHl = new HighloadblockManager('CustomBaskets');

        $customBasketsHl->prepareParamsQuery(
            ['ID'],
            [],
            [
                'UF_FUSER' => $fUser,
                'UF_PRODUCT_ID' => $productId,
                'UF_ORDER_ID' => 0,
                'UF_STORE_ID' => $storeIds[0]
            ]
        );

        $item = $customBasketsHl->getData();

        if ($item) {
            $field = [
                'UF_QUANTITY' => $quantity
            ];
            $customBasketsHl->update($item['ID'], $field);

            die(json_encode(['SUCCESS' => true]));
        }

        die(json_encode(['SUCCESS' => false]));
    case 'all' :
        foreach ($storeIds as $storeId) {
            $store = StoreProductTable::getList([
                'select' => ['*'],
                'filter' => [
                    'PRODUCT_ID' => $productId,
                    'STORE.ACTIVE' => 'Y',
                    'STORE.ID' => $storeId
                ]
            ])->fetch();

            $maxStoreAmount = 0;
            if ($store) {
                $maxStoreAmount = $store['AMOUNT'];
            }

            if ($maxStoreAmount >= $quantity) {
                $customBasketsHl = new HighloadblockManager('CustomBaskets');

                $customBasketsHl->prepareParamsQuery(
                    ['ID'],
                    [],
                    [
                        'UF_FUSER' => $fUser,
                        'UF_PRODUCT_ID' => $productId,
                        'UF_ORDER_ID' => 0,
                        'UF_STORE_ID' => $storeId
                    ]
                );

                $item = $customBasketsHl->getData();

                if ($item) {
                    $field = [
                        'UF_QUANTITY' => $quantity
                    ];
                    $customBasketsHl->update($item['ID'], $field);

                    die(json_encode(['SUCCESS' => true]));
                }
            } else {
                $quantity = $quantity - $maxStoreAmount;

                $customBasketsHl = new HighloadblockManager('CustomBaskets');

                $customBasketsHl->prepareParamsQuery(
                    ['ID'],
                    [],
                    [
                        'UF_FUSER' => $fUser,
                        'UF_PRODUCT_ID' => $productId,
                        'UF_ORDER_ID' => 0,
                        'UF_STORE_ID' => $storeId
                    ]
                );

                $item = $customBasketsHl->getData();

                if ($item) {
                    $field = [
                        'UF_QUANTITY' => $maxStoreAmount
                    ];
                    $customBasketsHl->update($item['ID'], $field);
                }
            }
        }

        if ($quantity > 0) {
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
                    'UF_STORE_ID' => $storeIds[0]
                ]
            );

            $item = $customBasketsHl->getData();

            if ($item) {
                $field = [
                    'UF_QUANTITY' => $quantity + $item['UF_QUANTITY']
                ];
                $customBasketsHl->update($item['ID'], $field);
            }

            die(json_encode(['SUCCESS' => true]));
        }

        die(json_encode(['SUCCESS' => false]));
}

die(json_encode(['SUCCESS' => false]));