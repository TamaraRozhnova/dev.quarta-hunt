<?php

namespace Personal;

use CIBlockElement;
use CModule;
use General\Product;
use _CIBElement;


/**
 * Класс по работе с избранными товарами пользователя.
 */
class Favorites
{
    const FAVORITES_IBLOCK_ID = 21;

    /** @var int */
    private $userId = 0;


    public function __construct()
    {
        CModule::IncludeModule('iblock');

        global $USER;
        if ($USER->IsAuthorized()) {
            $this->userId = $USER->GetID();
        }
    }


    public function getFavoritesCount()
    {
        if (!$this->userId) {
            $favorites = json_decode($_COOKIE['favorites']);
            if (is_array($favorites)) {
                return count($favorites);
            }
            return 0;
        }
        $element = $this->getFavoritesElement();
        $props = $element->GetProperties();
        $productIds = $props['PRODUCT_ID']['VALUE'];

        if (is_array($productIds)) {
            return count($productIds);
        }

        return 0;
    }


    /**
     * @return array - возвращает ассоциативный массив избранных товаров с их свойствами
     */
    public function getFavorites(): array
    {
        $favoritesIds = $this->getFavoritesIds();

        if (!count($favoritesIds)) {
            return [];
        }

        $products = $this->getProducts($favoritesIds);

        if (!count($products)) {
            return [];
        }

        return $products;
    }


    public function addFavorites(int $productId): bool
    {
        $element = $this->getFavoritesElement();
        $fields = $element->GetFields();
        $favoritesIds = $this->getProductsIdsInFavorites($element);

        if (in_array($productId, $favoritesIds)) {
            return false;
        }

        $favoritesIds[] = $productId;
        $el = new CIBlockElement();
        return $el->Update($fields['ID'], ['PROPERTY_VALUES' => ['USER_ID' => $this->userId, 'PRODUCT_ID' => $favoritesIds]]);
    }


    public function deleteFavorites(int $productId): bool
    {
        $element = $this->getFavoritesElement();
        $fields = $element->GetFields();
        $props = $element->GetProperties();
        $favoritesIds = $props['PRODUCT_ID']['VALUE'] ?? [];

        unset($favoritesIds[array_search($productId, $favoritesIds)]);

        $el = new CIBlockElement();
        return $el->Update($fields['ID'], ['PROPERTY_VALUES' => ['USER_ID' => $this->userId, 'PRODUCT_ID' => $favoritesIds]]);
    }


    public function clearFavorites(): bool
    {
        $element = $this->getFavoritesElement();
        $fields = $element->GetFields();

        $el = new CIBlockElement();
        return $el->Update($fields['ID'], ['PROPERTY_VALUES' => ['USER_ID' => $this->userId, 'PRODUCT_ID' => []]]);
    }


    /**
     * @return _CIBElement - возвращает элемент инфоблока избранных товаров
     */
    public function getFavoritesElement(): _CIBElement
    {
        $resource = CIBlockElement::GetList([], ['IBLOCK_ID' => self::FAVORITES_IBLOCK_ID, 'PROPERTY_USER_ID' => $this->userId]);
        if ($element = $resource->GetNextElement()) {
            return $element;
        }
        return $this->createFavoritesElement();
    }


    /**
     * @return int[] - возвращает массив ID избранных товаров
     */
    public function getFavoritesIds(): array
    {
        if ($this->userId) {
            $element = $this->getFavoritesElement();
            return $this->getProductsIdsInFavorites($element);
        }

        $cookieFavorites = json_decode($_COOKIE['favorites']);

        if (!is_array($cookieFavorites)) {
            return [];
        }

        return $cookieFavorites;
    }


    /**
     * @param _CIBElement $element - элемент инфоблока избранных товаров пользователя
     * @return int[] - возвращает массив ID избранных товаров
     */
    private function getProductsIdsInFavorites(_CIBElement $element): array
    {
        $props = $element->GetProperties();
        $productIds = $props['PRODUCT_ID']['VALUE'];
        if (is_array($productIds)) {
            return $productIds;
        }
        return [];
    }

    /**
     * @return _CIBElement - возвращает новый элемент инфоблока избранных товаров
     */
    private function createFavoritesElement(): _CIBElement
    {
        $name = 'fav_' . $this->userId;
        $element = new CIBlockElement();
        $element->Add([
            'IBLOCK_ID' => Favorites::FAVORITES_IBLOCK_ID,
            'NAME' => $name,
            'CODE' => $name,
            'XML_ID' => $name,
            'PROPERTY_VALUES' => [
                'USER_ID' => $this->userId,
                'PRODUCT_ID' => []
            ]
        ]);

        return $element::GetList()->GetNextElement();
    }


    /**
     * Формирует ассоциативный массив товаров с их свойствами
     * @param int[] $productIds - масиив ID товаров
     * @return array - возвращает ассоциативный массив свойств товаров
     */
    private function getProducts(array $productIds): array
    {
        $filter = ['ID' => $productIds];
        return Product::fetchProducts($filter);
    }
}