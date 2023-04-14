<?php

namespace Feedback;

use CIBlockElement;
use CModule;

/**
 * Класс по работе с отзывами на товары.
 */
class Reviews
{
    const REVIEWS_IBLOCK_ID = 11;

    public function __construct()
    {
        CModule::IncludeModule('iblock');
    }


    /**
     * @param int[] $productIds - массив идентификатор товаров
     * @return array - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — рейтинг товара
     */
    public function getReviewsRatingForProducts(array $productIds)
    {
        $filter = ['IBLOCK_ID' => Reviews::REVIEWS_IBLOCK_ID, 'PROPERTY_PRODUCT_ID' => $productIds];
        $reviewsResource = CIBlockElement::GetList([], $filter);
        $tempReviews = [];
        $result = [];

        while($review = $reviewsResource->GetNextElement()) {
            $props = $review->GetProperties();
            $productId = $props['PRODUCT_ID']['VALUE'];
            $rating = $props['RATING']['VALUE'];
            $tempReviews[$productId][] = $rating;
        }

        foreach ($tempReviews as $productId => $ratings) {
            $result[$productId] = round(array_sum($ratings) / count($ratings), 2);
        }

        return $result;
    }
}