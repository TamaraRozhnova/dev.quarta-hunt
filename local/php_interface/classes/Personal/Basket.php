<?php

namespace Personal;

use Bitrix\Sale\Basket as BitrixBasket;
use Bitrix\Sale\BasketBase;
use Bitrix\Sale\BasketItemBase;
use Bitrix\Main\Context;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Fuser;
use CCatalogSku;
use CIBlockElement;
use CModule;


/**
 * Класс по работе с корзиной
 */
class Basket
{
    /** @var BasketBase */
    private $basket;


    public function __construct()
    {
        CModule::IncludeModule('sale');
        CModule::IncludeModule('catalog');
        $this->basket = BitrixBasket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());
    }


    public function getProductsCount(): int
    {
        return array_sum($this->basket->getQuantityList());
    }


    /**
     * Получает список ID товаров и их количества в корзине
     * @return array - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — ассоциативный массив свойств товара в корзине
     */
    public function getProductsInBasket(): array
    {
        $result = [];
        foreach ($this->basket as $basketItem) {
            $productId = $basketItem->getProductId();
            $productData = CCatalogSku::GetProductInfo($basketItem->getProductId());
            if (is_array($productData)) {
                $productId = $productData['ID'];
            }
            $productQuantityAccumulated = $result[$productId]['QUANTITY'] ?? 0;
            $result[$productId] = ['ID' => $productId, 'QUANTITY' => $productQuantityAccumulated + $basketItem->getQuantity()];
        }
        return $result;
    }


    /**
     * Получает список доступных для покупки торговых предложений и их количества по id товара
     * @return array - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — ассоциативный массив свойств товара
     */
    public function getAvailableOffersForPurchasing(int $productId): array
    {
        $result = [];
        $basketItems = [];
        $offers = $this->getAvailableOffers($productId);

        if (!is_array($offers)) {
            return $result;
        }

        foreach ($this->basket as $basketItem) {
            $basketItems[$basketItem->getProductId()] = $basketItem->getQuantity();
        }

        foreach ($offers[$productId] as $offer) {
            $offerQuantityInBasket = $basketItems[$offer['ID']] ?? 0;
            $availableOfferQuantity = $offer['QUANTITY'] - $offerQuantityInBasket;
            if ($availableOfferQuantity <= 0) {
                continue;
            }
            $offerName = $offer['PROPERTY_CML2_ATTRIBUTES_VALUE'] ?? $offer['NAME'];
            $result[$offer['ID']] = [
                'ID' => $offer['ID'],
                'NAME' => $offerName,
                'QUANTITY' => $availableOfferQuantity
            ];
        }

        return $result;
    }


    /**
     * Получает список доступных для удаления из корзины торговых предложений и их количества по id товара
     * @return array - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — ассоциативный массив свойств товара
     */
    public function getAvailableOffersForDeleting(int $productId): array
    {
        $result = [];
        $basketItems = [];
        $offers = $this->getAvailableOffers($productId);

        if (!is_array($offers)) {
            return $result;
        }

        foreach ($this->basket as $basketItem) {
            $basketItems[$basketItem->getProductId()] = $basketItem->getQuantity();
        }

        foreach ($offers[$productId] as $offer) {
            $offerQuantityInBasket = $basketItems[$offer['ID']];
            if (!$offerQuantityInBasket) {
                continue;
            }
            $offerName = $offer['PROPERTY_CML2_ATTRIBUTES_VALUE'] ?? $offer['NAME'];
            $result[$offer['ID']] = [
                'ID' => $offer['ID'],
                'NAME' => $offerName,
                'QUANTITY' => $offerQuantityInBasket
            ];
        }

        return $result;
    }


    /**
     * Устанавливает определенное количество товара в корзину
     * @return int - возвращает новое установленное количество товара в корзине
     */
    public function setProductQuantityToBasket(int $productId, int $quantity): int
    {
        try {
            $basketItem = $this->getBasketItem($productId);
            $element = CIBlockElement::GetList([], ['ID' => $productId], ['QUANTITY'])->GetNext();
            $availableQuantity = $element['QUANTITY'];

            if (!$availableQuantity) {
                return 0;
            }

            $resultQuantity = $quantity;

            if ($availableQuantity < $quantity) {
                $resultQuantity = $availableQuantity;
            }

            if (!$basketItem) {
                $this->createBasketItem($productId, $resultQuantity);
                return $resultQuantity;
            }

            if ($quantity === 0) {
                $basketItem->delete();
            } else {
                $currentQuantityInBasket = $basketItem->getQuantity();
                $basketItem->setField('QUANTITY', $resultQuantity);
            }
            $this->basket->save();
            return $resultQuantity;
        } catch (\Exception $e) {
            return $currentQuantityInBasket ?? 0;
        }
    }


    public function addProductToBasket(int $productId, int $quantity = 1): bool
    {
        try {
            if (!$this->isProductAvailable($productId, $quantity)) {
                return false;
            }

            $basketItem = $this->getBasketItem($productId);

            if ($basketItem) {
                $basketItem->setField('QUANTITY', $basketItem->getQuantity() + $quantity);
                $this->basket->save();
            } else {
                $this->createBasketItem($productId, $quantity);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function deleteProductFromBasket(int $productId, int $quantity = 1): bool
    {
        try {
            $basketItem = $this->getBasketItem($productId);
            if (!$basketItem) {
                return false;
            }
            $currentQuantity = $basketItem->getQuantity();
            if ($currentQuantity > $quantity) {
                $basketItem->setField('QUANTITY', $currentQuantity - $quantity);
            } else {
                $basketItem->delete();
            }
            $this->basket->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    private function getBasketItem(int $productId): ?BasketItemBase
    {
        foreach ($this->basket as $basketItem) {
            if ($basketItem->getProductId() == $productId) {
                return $basketItem;
            }
        }
        return null;
    }


    private function isProductAvailable(int $productId, int $quantity): bool
    {
        $basketItem = $this->getBasketItem($productId);
        $element = CIBlockElement::GetList([], ['ID' => $productId], ['QUANTITY'])->GetNext();
        $availableQuantity = $element['QUANTITY'];

        if (!$availableQuantity) {
            return false;
        }
        if ($basketItem && $availableQuantity < $basketItem->getQuantity() + $quantity) {
            return false;
        }
        if (!$basketItem && $availableQuantity < $quantity) {
            return false;
        }

        return true;
    }


    public function getCopyOfBasket(): BasketBase
    {
        return $this->basket->copy();
    }


    private function createBasketItem(int $productId, int $quantity): void
    {
        $basketItem = $this->basket->createItem('catalog', $productId);
        $basketItem->setFields([
            'QUANTITY' => $quantity,
            'CURRENCY' => CurrencyManager::getBaseCurrency(),
            'LID' => Context::getCurrent()->getSite(),
            'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
        ]);
        $this->basket->save();
    }


    /**
     * Получает список доступных для покупки торговых предложений по id товара
     * @return array|bool - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — ассоциативный массив свойств торговых предложений
     */
    private function getAvailableOffers(int $productId): ?array
    {
        $selectFields = ['NAME', 'QUANTITY', 'PROPERTY_CML2_ATTRIBUTES'];
        return CCatalogSKU::getOffersList($productId, CATALOG_IBLOCK_ID, ['AVAILABLE' => 'Y'], $selectFields);
    }

}

