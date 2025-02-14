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
$storeIds = $request->getPost('storeIds') ?: null;

if (
    $productId == '0' ||
    $storeIds == null
) {
    die(json_encode(['SUCCESS' => false]));
}

$storeIds = explode(',', $storeIds);
$userId = 0;
$fUser = 0;

global $USER;

if ($USER->IsAuthorized()) {
    $userId = $USER->GetID();
} else {
    $fUser = Fuser::getId();
}

if (is_array($storeIds)) {
    foreach ($storeIds as $storeId) {
        $customBasketsHl = new HighloadblockManager('CustomBaskets');

        $customBasketsHl->prepareParamsQuery(
            ['ID'],
            [],
            [
                'UF_FUSER' => $fUser,
                'UF_PRODUCT_ID' => $productId,
                'UF_ORDER_ID' => 0,
                'UF_USER_ID' => $userId,
                'UF_STORE_ID' => $storeId
            ]
        );

        $item = $customBasketsHl->getData();

        if ($item) {
            $customBasketsHl->delete($item['ID']);
        }
    }

    die(json_encode(['SUCCESS' => true]));
}

die(json_encode(['SUCCESS' => false]));