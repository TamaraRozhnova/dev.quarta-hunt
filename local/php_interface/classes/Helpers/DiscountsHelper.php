<?php

namespace Helpers;

use Bitrix\Sale\Compatible\DiscountCompatibility;
use Bitrix\Sale\Discount\Gift\Manager;
use General\User;
use Personal\Basket;


/**
 * Класс по работе со скидками.
 */
class DiscountsHelper
{
    /**
     * Получает цены товара для вывода в каталоге
     * @param array $product - ассоциативный массив свойств товара
     * @return array - возвращает ассоциативный массив с видами цен
     */
    public static function getCorrectPrices(array $product): array
    {
        $user = new User();
        $isWholesaler = $user->isWholesaler();

        if (count($product['OFFERS']) > 0) {
            $prices = $product['OFFERS'][0]['PRICES'];
        } else {
            $prices = $product['PRICES'];
        }

        $basePrices = $prices[BASE_PRICE_CODE];
        $discountPrice = $basePrices['DISCOUNT_VALUE'];
        $price = $basePrices['VALUE'];
        $discountPercent = $basePrices['DISCOUNT_DIFF_PERCENT'];

        $optPrices = $prices[OPT_PRICE_CODE];

        if ($isWholesaler && !empty($optPrices)) {
            $discountPrice = $optPrices['DISCOUNT_VALUE'];
            $price = $optPrices['VALUE'];
            $discountPercent = $optPrices['DISCOUNT_DIFF_PERCENT'];
        }

        if ($discountPercent > 0) {
            return [
                'PRICE' => number_format($discountPrice, 0, '.', ' '),
                'OLD_PRICE' => number_format($price, 0, '.', ' '),
                'DISCOUNT' => round($discountPercent)
            ];
        }

        return ['PRICE' => number_format($price, 0, '.', ' ')];
    }


    /**
     * @return int[] - возвращает массив идентификаторов товаров - подарков
     */
    public static function getGiftIds(int $productId): array
    {
        $giftProductIds = [];

        if (!$productId) {
            return $giftProductIds;
        }

        DiscountCompatibility::stopUsageCompatible();
        $giftManager = Manager::getInstance();

        $potentialBuy = [
            'ID' => $productId,
            'MODULE' => 'catalog',
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
            'QUANTITY' => 1,
        ];

        $basket = new Basket();
        $basketPseudo = $basket->getCopyOfBasket();

        foreach ($basketPseudo as $basketItem) {
            $basketItem->delete();
        }

        $collections = $giftManager->getCollectionsByProduct($basketPseudo, $potentialBuy);

        foreach ($collections as $collection) {
            foreach ($collection as $gift) {
                $giftProductIds[] = $gift->getProductId();
            }
        }

        DiscountCompatibility::revertUsageCompatible();

        return $giftProductIds;
    }
}