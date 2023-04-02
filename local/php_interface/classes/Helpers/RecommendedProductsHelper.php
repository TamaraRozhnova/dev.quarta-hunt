<?php

namespace Helpers;

use General\Product;
use General\User;


/**
 * Класс по работе с рекомендованными товарами.
 */
class RecommendedProductsHelper
{
    public static function getRecommendedProducts(array $productIds, int $sectionId, int $count = 4, string $elementUrlTemplate = ''): array {
        $user = new User();
        $priceCodeId = $user->getUserPriceCodeId();
        $recommendedProducts = [];

        if (count($productIds)) {
            $filter = ['ID' => $productIds];
            $recommendedProducts = Product::fetchProducts($filter, $elementUrlTemplate, $count);
        }

        $remainProducts = [];
        $remainCount = $count - count($recommendedProducts);

        if ($remainCount) {
            $filter = [
                'AVAILABLE' => 'Y',
                'ACTIVE' => 'Y',
                ">$priceCodeId" => 0,
                '!ID' => $productIds,
                'SECTION_ID' => $sectionId,
                'INCLUDE_SUBSECTIONS' => 'Y',
            ];
            $remainProducts = Product::fetchProducts($filter, $elementUrlTemplate, $remainCount);
        }

        return array_replace($recommendedProducts, $remainProducts);
    }
}