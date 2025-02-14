<?php

namespace CustomEvents;

use Bitrix\Main;
use Local\Util\HighloadblockManager;
use \Bitrix\Sale\Fuser;

class OnSaleOrderSaved
{
    public static function deleteProductFromCustomBasket(Main\Event $event) : void
    {
        $order = $event->getParameter('ENTITY');
        $isNew = $event->getParameter('IS_NEW');

        if (
            $isNew &&
            is_array($_SESSION['PRODUCTS_IN_ORDER']) &&
            !empty($_SESSION['PRODUCTS_IN_ORDER'])
        ) {
            $userId = 0;
            $fUser = 0;

            global $USER;

            if ($USER->IsAuthorized()) {
                $userId = $USER->GetID();
            } else {
                $fUser = Fuser::getId();
            }

            foreach ($_SESSION['PRODUCTS_IN_ORDER'] as $product) {
                if (is_array($product['STORE_ID'])) {
                    foreach ($product['STORE_ID'] as $storeId) {
                        $customBasketsHl = new HighloadblockManager('CustomBaskets');

                        $customBasketsHl->prepareParamsQuery(
                            ['ID'],
                            [],
                            [
                                'UF_FUSER' => $fUser,
                                'UF_PRODUCT_ID' => $product['ID'],
                                'UF_ORDER_ID' => 0,
                                'UF_USER_ID' => $userId,
                                'UF_STORE_ID' => $storeId
                            ]
                        );

                        $item = $customBasketsHl->getData();

                        if ($item) {
                            $field = [
                                'UF_ORDER_ID' => $order->getId()
                            ];

                            $customBasketsHl->update($item['ID'], $field);
                        }
                    }
                }
            }

            $_SESSION['PRODUCTS_IN_ORDER'] = [];
        }
    }
}