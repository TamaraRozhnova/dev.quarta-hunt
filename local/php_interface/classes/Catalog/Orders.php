<?php

namespace Catalog\Orders;

use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Sale;

/**
 * Работа с заказами
 */
class OrderHelper
{
    private int $userId;

    public function __construct(CurrentUser $currentUser)
    {
        $this->userId = $currentUser->getId();
    }

    /**
     * Возвращает товары из заказов пользователя
     *
     * @return array
     */
    public function getUserPurchasedProducts(): array
    {
        $orders = $this->getUserOrderIds();
        if (!count($orders)) {
            return [];
        }
        $orderIds = array_column($orders, 'ID');

        $result = Sale\Basket::getList([
            'select' => [
                'PRODUCT_ID'
            ],
            'filter' => [
                'ORDER_ID' => $orderIds,
            ],
        ])->fetchAll();

        if (!count($result)) {
            return [];
        }

        return array_column($result, 'PRODUCT_ID');
    }

    /**
     * Возвращает ID всех заказов пользователя
     *
     * @return array
     */
    private function getUserOrderIds(): array
    {
        return Sale\Order::getList([
            'order' => ['ID' => 'DESC'],
            'select' => [
                'ID'
            ],
            'filter' => [
                "USER_ID" => $this->userId,
                'LID' => SITE_ID,
            ]
        ])->fetchAll();
    }
}
