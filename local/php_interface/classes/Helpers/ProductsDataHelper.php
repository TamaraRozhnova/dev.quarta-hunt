<?php

namespace Helpers;

use Feedback\Review;
use Personal\Basket;
use Personal\Favorites;

/**
 * Класс для получения некэшируемой информации о товарах.
 */
class ProductsDataHelper
{
    /**
     * Получает некэшируемые данные для товаров
     * @param int[] $productIds - массив ids товаров
     * @param bool $isAjax - вызов метода через ajax запрос
     * @return array - возвращает ассоциативный массив с некэшируемой дополнительной информации о товарах
     */
    public static function getProductsData(array $productIds, bool $isAjax = false): array
    {
        $favoritesInstance = new Favorites();
        $basketInstance = new Basket();
        $reviewsInstance = new Review();

        $favorites = $favoritesInstance->getFavoritesIds();
        $compare = $_SESSION[COMPARE_LIST_NAME][CATALOG_IBLOCK_ID]['ITEMS'] ?? [];
        $basket = $basketInstance->getProductsInBasket();
        $ratings = $reviewsInstance->getReviewsRatingAndCountForProducts($productIds);

        if ($isAjax) {
            $favorites = (object)array_fill_keys($favorites, true);
            $compare = (object)array_fill_keys(array_keys($compare), true);
            $ratings = (object)$ratings;
        }

        return [
            'FAVORITES' => $favorites,
            'COMPARE' => $compare,
            'BASKET' => $basket,
            'RATINGS' => $ratings
        ];
    }
}