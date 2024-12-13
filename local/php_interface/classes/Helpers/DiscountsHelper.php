<?php

namespace Helpers;

use Bitrix\Main\Diag\Debug;
use Bitrix\Sale\Compatible\DiscountCompatibility;
use Bitrix\Sale\Discount\Gift\Manager;
use General\Section;
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

        if (is_array($product['OFFERS']) && count($product['OFFERS']) > 0) {
            $prices = reset($product['OFFERS'])['PRICES'];
        } else {
            $prices = $product['PRICES'];
        }

        if ($isWholesaler) {
            $resultPrices = $prices[OPT_PRICE_CODE];
        } else {
            $resultPrices = $prices[BASE_PRICE_CODE];
        }

        $discountPrice = $resultPrices['DISCOUNT_VALUE'];
        $price = $resultPrices['VALUE'];
        $discountPercent = $resultPrices['DISCOUNT_DIFF_PERCENT'];

        if ($discountPercent > 0) {
            return ['PRICE' => number_format($discountPrice, 0, '.', ' '), 'OLD_PRICE' => number_format($price, 0, '.', ' '), 'DISCOUNT' => round($discountPercent)];
        }

        return ['PRICE' => number_format($price, 0, '.', ' ')];
    }


    /**
     * Проверяет и заполняет массив свойств товара бонусами
     * @param array &$product - ассоциативный массив свойств товара
     */
    public static function fillProductWithBonuses(array &$product): void
    {
        $user = new User();

        $isWholesaler = $user->isWholesaler();
        $sectionIdsWithDoubleBonus = Section::getBonusDoubleSectionsArray();

        if ($isWholesaler) {
            unset($product['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
            unset($product['PROPERTIES']['DOUBLE_BONUS']);
        } else {
            $product['PRESENT'] = !empty(DiscountsHelper::getGiftIds($product['ID']));
            if (in_array($product['IBLOCK_SECTION_ID'], $sectionIdsWithDoubleBonus)) {
                $product['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';
            }
        }
    }

    /**
     * @return int[] - возвращает массив идентификаторов товаров - подарков
     */
    public static function getGiftIds(?int $productId): array
    {
        $giftProductIds = [];

        DiscountCompatibility::stopUsageCompatible();
        $giftManager = Manager::getInstance();

        $potentialBuy = ['ID' => $productId, 'MODULE' => 'catalog', 'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider', 'QUANTITY' => 1,];

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

    /**
     * Проверяет и заполняет массив свойств товаров бонусами
     * @param array &$products - ассоциативный массив свойств товаров
     */
    public static function fillProductsWithBonuses(array &$products): void
    {
        $user = new User();

        $isWholesaler = $user->isWholesaler();
        $sectionIdsWithDoubleBonus = Section::getBonusDoubleSectionsArray();

        if ($products['ID']) {
            if ($isWholesaler) {
                unset($products['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
                unset($products['PROPERTIES']['DOUBLE_BONUS']);
            } else {
                $products['PRESENT'] = !empty(DiscountsHelper::getGiftIds($product['ID']));
                if (in_array($products['IBLOCK_SECTION_ID'], $sectionIdsWithDoubleBonus)) {
                    $products['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';
                }
            }
        } else {

            foreach ($products as $index => $product) {

                if ($isWholesaler) {
                    unset($products[$index]['PROPERTIES']['KOMPLEKTY_DLYA_SAYTA']);
                    unset($products[$index]['PROPERTIES']['DOUBLE_BONUS']);
                } else {
                    $products[$index]['PRESENT'] = !empty(DiscountsHelper::getGiftIds($product['ID']));
                    if (in_array($product['IBLOCK_SECTION_ID'], $sectionIdsWithDoubleBonus)) {
                        $products[$index]['PROPERTIES']['DOUBLE_BONUS']['VALUE'] = 'Да';
                    }
                }
            }
        }
    }
}