<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}

use Bitrix\Main\Application;
use Local\Util\HighloadblockManager;
use \Bitrix\Sale\Fuser;

$request = Application::getInstance()->getContext()->getRequest();

$products = $request->getPost('products') ?: [];

if (empty($products)) {
    die(json_encode(['SUCCESS' => false]));
}

$fUser = Fuser::getId();

foreach ($products as $key => $product) {
    $store = explode(',', $product['STORE_ID']);

    if (is_array($store) && !empty($store)) {
        foreach ($store as $storeId) {
            $customBasketsHl = new HighloadblockManager(QUARTA_HL_CUSTOM_BASKET_BLOCK_CODE);

            $customBasketsHl->prepareParamsQuery(
                ['ID'],
                [],
                [
                    'UF_FUSER' => $fUser,
                    'UF_PRODUCT_ID' => $product['ID'],
                    'UF_ORDER_ID' => 0,
                    'UF_STORE_ID' => $storeId
                ]
            );

            $item = $customBasketsHl->getData();

            if ($item) {
                try {
                    $customBasketsHl->delete($item['ID']);
                } catch (Exception $error) {
                    die(json_encode([
                        'SUCCESS' => false,
                        'ERROR_MESSAGE' => $error->getMessage()
                    ]));
                }
            }
        }
    }
}

die(json_encode(['SUCCESS' => true]));