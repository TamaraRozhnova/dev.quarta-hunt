<?php

namespace General;

use CCatalogProduct;
use CCatalogSku;
use CFile;
use CIBlockElement;
use CModule;
use CPrice;
use Feedback\Review;
use Helpers\DiscountsHelper;

/**
 * Класс по работе с рекомендованными товарами.
 */
class RecommendedProducts
{
    /** @var int */
    private int $priceId;


    public function __construct()
    {
        CModule::IncludeModule('iblock');

        $user = new User();
        $this->priceId = $user->getUserPriceId();
    }


    public function getRecommendedProducts(array $productIds, int $sectionId, int $count = 4, string $elementUrlTemplate = ''): array {
        $recommendedProducts = [];

        if (count($productIds)) {
            $filter = ['ID' => $productIds];
            $recommendedProducts = $this->fetchProducts($filter, $count, $elementUrlTemplate);
        }

        $remainProducts = [];
        $remainCount = $count - count($recommendedProducts);

        if ($remainCount) {
            $filter = [
                'AVAILABLE' => 'Y',
                'ACTIVE' => 'Y',
                '!ID' => $productIds,
                'SECTION_ID' => $sectionId,
                'INCLUDE_SUBSECTIONS' => 'Y',
            ];
            $remainProducts = $this->fetchProducts($filter, $remainCount, $elementUrlTemplate);
        }

        $products = array_replace($recommendedProducts, $remainProducts);
        $productIds = array_keys($products);

        $this->fillPrices($products, $productIds);
        $this->fillRatings($products, $productIds);
        $this->fillAvailableProducts($products);
        $this->fillAvailableOffers($products, $productIds);
        DiscountsHelper::fillProductsWithBonuses($products);

        return $products;
    }


    /**
     * Получает список доступных для покупки торговых предложений по id товаров
     * @param array &$products - ассоциативный массив cо свойствами товаров
     * @param int[] $productIds - массив идентификаторов товаров
     */
    private function fillAvailableOffers(array &$products, array $productIds): void
    {
        $selectFields = ['QUANTITY', 'PROPERTY_CML2_ATTRIBUTES'];
        $productsWithOffers = CCatalogSKU::getOffersList($productIds, CATALOG_IBLOCK_ID, ['AVAILABLE' => 'Y'], $selectFields);

        if (!$productsWithOffers) {
            return;
        }

        foreach ($productsWithOffers as $productId => $productWithOffers) {
            foreach ($productWithOffers as $offerId => $offer) {
                $products[$productId]['OFFERS'][$offerId] = [
                    'PRODUCT' => ['QUANTITY' => $offer['QUANTITY']],
                    'CAN_BUY' => 'Y'
                ];
            }
        }
    }


    private function fillAvailableProducts(array &$products): void {
        foreach ($products as $key => $product) {
            if ((float)$product['PRICES']['PRICE'] > 0) {
                $products[$key]['CAN_BUY'] = 'Y';
            }
        }
    }


    private function fillRatings(array &$products, array $productIds): void {
        $reviews = new Review();
        $ratings = $reviews->getReviewsRatingAndCountForProducts($productIds);

        foreach ($ratings as $key => $rating) {
            $products[$key]['REVIEWS'] = $rating['RATING'];
        }
    }


    private function fetchProducts(array $filter, int $count, string $detailUrlTemplate = ''): array {
        $filterParams = $this->makeFilterParams($filter);
        $countParams = $this->makeCountParams($count);
        $products = [];

        $productsResource = CIBlockElement::GetList(
            ['rand' => 'asc'],
            $filterParams,
            false,
            $countParams
        );

        $productsResource->SetUrlTemplates($detailUrlTemplate);
        while ($product = $productsResource->GetNextElement()) {
            $fields = $product->GetFields();
            $fields['PROPERTIES'] = $product->GetProperties();
            $picture = $fields['PREVIEW_PICTURE'];
            $fields['PREVIEW_PICTURE'] = ['SRC' => $picture !== null ? CFile::GetPath($picture) : ''];
            $productId = $fields['ID'];
            $products[$productId] = $fields;
        }

        return $products;
    }


    private function fillPrices(array &$products, array $productIds): void
    {
        $pricesResource = CPrice::GetList([], ['PRODUCT_ID' => $productIds]);

        while ($price = $pricesResource->Fetch()) {
            if ($price['CATALOG_GROUP_ID'] != $this->priceId) {
                continue;
            }
            $optimalPrice = CCatalogProduct::GetOptimalPrice($price['PRODUCT_ID'], 1, [], 'N', [$price]);
            $discountPercent = round($optimalPrice['RESULT_PRICE']['PERCENT']);
            if ($discountPercent > 0) {
                $products[$price['PRODUCT_ID']]['PRICES'] = [
                    'PRICE' => number_format($optimalPrice['RESULT_PRICE']['BASE_PRICE'], 0, '.', ' '),
                    'OLD_PRICE' => number_format($optimalPrice['RESULT_PRICE']['DISCOUNT_PRICE'], 0, '.', ' '),
                    'DISCOUNT' => $discountPercent
                ];
                continue;
            }
            $products[$price['PRODUCT_ID']]['PRICES'] = [
                'PRICE' => number_format($optimalPrice['RESULT_PRICE']['BASE_PRICE'], 0, '.', ' '),
            ];
        }
    }


    private function makeFilterParams(array $filter): array
    {
        return array_merge(['IBLOCK_ID' => CATALOG_IBLOCK_ID], $filter);
    }


    private function makeCountParams(int $count): array
    {
        if (!$count) {
            return [];
        }

        return ['nTopCount' => $count];
    }
}