<?php

namespace Catalog\Orders;

use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Sale;
use Helpers\IblockHelper;

/**
 * Работа с заказами
 */
class OrderHelper
{
    private int $userId;
    private int $offersCatalogId;
    public array $products;

    public function __construct(CurrentUser $currentUser, string $offersCatalogId)
    {
        $this->userId = $currentUser->getId();
        $this->offersCatalogId = $offersCatalogId;
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
                'ID',
                'PRODUCT_ID',
                'PRODUCT_XML_ID',
                'DETAIL_PAGE_URL',
                'NAME',
                'PRICE',
            ],
            'filter' => [
                'ORDER_ID' => $orderIds,
            ],
        ])->fetchAll();

        if (!count($result)) {
            return [];
        }

        foreach ($result as &$item) {
            // Проверяем, предложение это или товар
            // Если предложение, ищем ID основного товара
            if (str_contains($item['PRODUCT_XML_ID'], '#')) {
                $parentId = \CCatalogSku::GetProductInfo(
                    $item['PRODUCT_ID'],
                    $this->offersCatalogId,
                )['ID'];
                $prodIds[] = $parentId;

                $item['OFFER_ID'] = $item['PRODUCT_ID'];
                $item['PRODUCT_ID'] = $parentId;
            } else {
                $prodIds[] = $item['PRODUCT_ID'];
            }

            $this->products[] = $item;
        }

        return $prodIds;
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
