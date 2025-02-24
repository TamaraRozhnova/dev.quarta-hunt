<?php

namespace CustomEvents;

use Bitrix\Main;
use Bitrix\Main\Diag\Debug;
use Local\Util\HighloadblockManager;
use \Bitrix\Sale\Fuser;

/**
 * Класс обработчик события OnSaleOrderSaved
 */
class OnSaleOrderSaved
{
    /**
     * Функция обновляет элементы (HL блока кастомной корзины), которые оформлены в заказе
     *
     * @param Main\Event $event
     * @return void
     */
    public static function deleteProductFromCustomBasket(Main\Event $event) : void
    {
        $order = $event->getParameter('ENTITY');
        $isNew = $event->getParameter('IS_NEW');

        if (
            $isNew &&
            is_array($_SESSION['PRODUCTS_IN_ORDER']) &&
            !empty($_SESSION['PRODUCTS_IN_ORDER'])
        ) {
            $fUser = Fuser::getId();

            foreach ($_SESSION['PRODUCTS_IN_ORDER'] as $product) {
                if (is_array($product['STORE_ID'])) {
                    foreach ($product['STORE_ID'] as $storeId) {
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
                            $field = [
                                'UF_ORDER_ID' => $order->getId()
                            ];

                            try {
                                $customBasketsHl->update($item['ID'], $field);
                            } catch (\Exception $error) {
                                Debug::dumpToFile(var_export($error->getMessage(), true), 'ERROR MESSAGE ' . __FILE__, 'deliverySettings.log');
                            }
                        }
                    }
                }
            }

            $_SESSION['PRODUCTS_IN_ORDER'] = [];
        }
    }
}