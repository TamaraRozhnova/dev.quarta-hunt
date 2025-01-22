<?php

namespace Personal;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\Iblock;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Sale\Basket as BitrixBasket;
use Bitrix\Sale\BasketBase;
use Bitrix\Sale\BasketItem;
use Bitrix\Sale\BasketItemBase;
use Bitrix\Main\Context;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\ProductTable;
use CCatalogSku;
use CIBlockElement;
use CModule;
use Exception;
use General\Product;
use General\Section;
use General\User;
use Bitrix\Catalog\VatTable;
use Bitrix\Main\Application;


/**
 * Класс по работе с корзиной
 */
class Basket
{
    /** @var BasketBase */
    private $basket;
    private $user;


    public function __construct()
    {
        CModule::IncludeModule('sale');
        CModule::IncludeModule('catalog');
        CModule::IncludeModule('iblock');

        $this->basket = BitrixBasket::loadItemsForFUser(Fuser::getId(), Context::getCurrent()->getSite());
        $this->user = new User();
    }


    public function getProductsCount(): int
    {
        return array_sum($this->basket->getQuantityList());
    }


    /**
     * Получает список ID товаров и их количества в корзине
     * @return array - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара или ТП, значение — ассоциативный массив свойств товара в корзине
     */
    public function getProductsInBasket(): array
    {
        $result = [];
        foreach ($this->basket as $basketItem) {
            $productId = $basketItem->getProductId();
            $quantity = $basketItem->getQuantity();
            $offerId = null;
            $productData = CCatalogSku::GetProductInfo($productId);
            if (is_array($productData)) {
                $offerId = $productId;
                $productId = $productData['ID'];
            }
            $productQuantityAccumulated = $result[$productId]['QUANTITY'] ?? 0;
            $result[$productId] = ['ID' => $productId, 'QUANTITY' => $productQuantityAccumulated + $quantity];
            if ($offerId) {
                $result[$offerId] = ['ID' => $offerId, 'QUANTITY' => $quantity];
            }
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
     * Получает список доступных для покупки торговых предложений по id товара
     * @return array|bool - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — ассоциативный массив свойств торговых предложений
     */
    private function getAvailableOffers(int $productId): ?array
    {
        $selectFields = ['NAME', 'QUANTITY', 'PROPERTY_CML2_ATTRIBUTES'];
        return CCatalogSKU::getOffersList($productId, CATALOG_IBLOCK_ID, ['AVAILABLE' => 'Y'], $selectFields);
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
        } catch (Exception $e) {
            return $currentQuantityInBasket ?? 0;
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

    private function createBasketItem(int $productId, int $quantity, array $data = []): void
    {

        $basketItem = $this->basket->createItem('catalog', $productId);
        $atFields = [
            'QUANTITY' => $quantity,
            'CURRENCY' => CurrencyManager::getBaseCurrency(),
            'LID' => Context::getCurrent()->getSite(),
        ];

        if (isset($data['NOTES'])) {
            $atFields['NOTES'] = serialize($data['NOTES']);
        }

        if (isset($data['PRICE'])) {
            $atFields['PRICE'] = $data['PRICE'];
            $atFields['BASE_PRICE'] = $data['PRICE'];
        }

        if (isset($data['CUSTOM_PRICE'])) {
            $atFields['CUSTOM_PRICE'] = $data['CUSTOM_PRICE'];
        }

        if (isset($data['NAME'])) {
            $atFields['NAME'] = $data['NAME'];
        }

        if (isset($data['VAT_RATE'])) {
            $atFields['VAT_RATE'] = $data['VAT_RATE'];
        }

        $atFields['WEIGHT'] = (float) $data['WEIGHT'];

        $atFields['CATALOG_XML_ID'] = \Bitrix\Iblock\IblockTable::getList([
            'select' => ['XML_ID'],
            'filter' => [
                '=ID' => CATALOG_IBLOCK_ID
            ]
        ])->fetch()['XML_ID'];

        $atFields['PRODUCT_XML_ID'] = ElementTable::query()
            ->addSelect('XML_ID')
            ->where('ID', $productId)
            ->fetch()['XML_ID'];

        $basketItem->setFields($atFields);

        /* свойства корзины на добавление из каталога */
        $basketItem->save();

        $basketAddProperties = ['CML2_ARTICLE'];

        $iblockId = ElementTable::query()
            ->addSelect('IBLOCK_ID')
            ->where('ID', $productId)
            ->fetch()['IBLOCK_ID'] ?? false;

        $iblockDataClass = Iblock::wakeUp($iblockId)->getEntityDataClass();
        $elementPropertyData = $iblockDataClass::getByPrimary($productId, [
            'select' => ['*', 'CML2_ARTICLE_' => 'CML2_ARTICLE']
        ])->fetchAll();

        $basketPropertyCollection = $basketItem->getPropertyCollection();
        $basketPropertyCollection->getPropertyValues();
        $propertyList = [];
        foreach ($basketAddProperties as $property) {
            $propertyDescription = $this->getPropertyDescrption($property, $iblockId);
            $propertyList[] = [
                'NAME' => $propertyDescription['NAME'],
                'CODE' => $property,
                'VALUE' => current($elementPropertyData)[$property . '_VALUE'],
                'SORT' => 100,
            ];
        }
        $basketPropertyCollection->redefine($propertyList);
        $basketPropertyCollection->save();
        /* ---  */


        $this->basket->save();
    }

    /**
     * Получаем свойства каталога для корзины
     * @param $propertyCode
     * @return array
     */
    private function getPropertyDescrption($propertyCode, $iblock)
    {
        return PropertyTable::query()
            ->addSelect('ID')
            ->addSelect('NAME')
            ->where('CODE', $propertyCode)
            ->where('IBLOCK_ID', $iblock)
            ->fetch();
    }

    public function addProductToBasket(int $productId, int $quantity = 1): bool
    {
        try {
            if (!$this->isProductAvailable($productId, $quantity)) {
                return false;
            }

            $basketItem = $this->getBasketItem($productId);

            $isOpt = $this->user->isWholesaler();
            $product = new Product($productId);
            $price = $product->getFieldValue('PRICE_1');
            $price3 = $product->getFieldValue('PRICE_3');
            $vat = $this->getVat($product->getFieldValue('VAT_ID'), $productId);

            if ($basketItem) {
                $basketItem->setField('WEIGHT', (float) $basketItem->getWeight());
                $basketItem->setField('QUANTITY', $basketItem->getQuantity() + $quantity);
                $basketItem->setField('PRICE', !$isOpt ? $price : $price3);
                $basketItem->setField('VAT_RATE', $vat);
                $this->basket->save();
            } else {
                $this->createBasketItem($productId, $quantity, [
                    'PRICE' => !$isOpt ? $price : $price3,
                    'NAME' => $product->getFieldValue('NAME'),
                    'VAT_RATE' => $vat,
                ]);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Получает ставку НДС по ID
     *
     * @param  int|null $vatId
     * @return float
     */
    private function getVat(int|null $vatId): float
    {
        if ($vatId === null) {
            $connection = Application::getConnection();
            $result = $connection->query('SELECT `VAT_ID` FROM `b_catalog_iblock` WHERE `IBLOCK_ID` = ' . CATALOG_IBLOCK_ID)->fetch();
            if ($result) {
                $vatId = $result['VAT_ID'];
            }
        }
        return floatval(VatTable::getById($vatId)->fetch()['RATE']) / 100;
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
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @throws ArgumentOutOfRangeException
     * @throws ObjectNotFoundException
     */
    public function deleteAllProductFromBasket(): bool
    {
        /** @var BasketItem $basketItem */
        foreach ($this->basket as $basketItem) {
            $basketItem->delete();
        }
        $this->basket->save();

        return true;
    }

    public function getCopyOfBasket(): BasketBase
    {
        return $this->basket->copy();
    }
}
