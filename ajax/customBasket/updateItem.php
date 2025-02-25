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

$productId = intval($request->getPost('productId')) ?: 0;
$storeIds = (string)$request->getPost('storeIds') ?: '';
$quantity = intval($request->getPost('quantity')) ?: 0;
$mode = $request->getPost('mode') ?: 'all';

if (
    $productId === 0 ||
    $storeIds === '' ||
    $quantity === 0
) {
    die(json_encode(['SUCCESS' => false]));
}

$storeIds = explode(',', $storeIds);
$userId = 0;
$fUser = Fuser::getId();

switch ($mode) {
    case 'store' :
        if (!$storeIds[0]) {
            die(json_encode(['SUCCESS' => false]));
        }

        $customBasketsHl = new HighloadblockManager(QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE);

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

            try {
                $customBasketsHl->update($item['ID'], $field);
                die(json_encode(['SUCCESS' => true]));
            } catch (Exception $error) {
                die(json_encode([
                    'SUCCESS' => false,
                    'ERROR_MESSAGE' => $error->getMessage()
                ]));
            }
        }

        die(json_encode(['SUCCESS' => false]));
    case 'all' :
        foreach ($storeIds as $storeId) {
            $store = StoreProductTable::getList([
                'select' => ['AMOUNT'],
                'filter' => [
                    'PRODUCT_ID' => $productId,
                    'STORE.ACTIVE' => 'Y',
                    'STORE.ID' => $storeId
                ]
            ])?->fetch();

            $maxStoreAmount = 0;
            if ($store) {
                $maxStoreAmount = $store['AMOUNT'];
            }

            if ($maxStoreAmount >= $quantity) {
                $customBasketsHl = new HighloadblockManager(QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE);

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
                    try {
                        $customBasketsHl->update($item['ID'], $field);
                        die(json_encode(['SUCCESS' => true]));
                    } catch (Exception $error) {
                        die(json_encode([
                            'SUCCESS' => false,
                            'ERROR_MESSAGE' => $error->getMessage()
                        ]));
                    }
                }
            } else {
                $quantity = $quantity - $maxStoreAmount;

                $customBasketsHl = new HighloadblockManager(QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE);

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
                    try {
                        $customBasketsHl->update($item['ID'], $field);
                    } catch (Exception $error) {
                        die(json_encode([
                            'SUCCESS' => false,
                            'ERROR_MESSAGE' => $error->getMessage()
                        ]));
                    }
                }
            }
        }

        if ($quantity > 0) {
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
                    'UF_STORE_ID' => $storeIds[0]
                ]
            );

            $item = $customBasketsHl->getData();

            if ($item) {
                $field = [
                    'UF_QUANTITY' => $quantity + $item['UF_QUANTITY']
                ];

                try {
                    $customBasketsHl->update($item['ID'], $field);
                    die(json_encode(['SUCCESS' => true]));
                } catch (Exception $error) {
                    die(json_encode([
                        'SUCCESS' => false,
                        'ERROR_MESSAGE' => $error->getMessage()
                    ]));
                }
            }
        }

        die(json_encode(['SUCCESS' => false]));
}

die(json_encode(['SUCCESS' => false]));