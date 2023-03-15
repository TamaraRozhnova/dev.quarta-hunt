<?php

namespace General;

use CCatalogSku;
use CFile;
use CIBlockElement;
use CModule;
use CPrice;
use Feedback\Reviews;

/**
 * Класс по работе с товарами.
 */
class Products
{
    const BASE_PRICE_ID = 1;
    const OPT_PRICE_ID = 3;

    /** @var bool */
    private bool $userIsWholesaler;


    public function __construct()
    {
        CModule::IncludeModule('iblock');

        $user = new User();
        $this->userIsWholesaler = $user->isWholesaler();
    }


    public function getProducts(array $filter, int $count = 0): array
    {
        $products = $this->fetchProducts($filter, $count);
        $productIds = array_keys($products);
        $this->fillPrices($products, $productIds);
        $this->fillRatings($products, $productIds);
        $this->fillAvailableOffers($products, $productIds);

        return $products;
    }


    public function getRecommendedProducts(array $productIds, int $sectionId, int $count = 4): array {
        $recommendedProducts = [];

        if (count($productIds)) {
            $filter = ['>*CATALOG_QUANTITY' => 0, 'ID' => $productIds];
            $recommendedProducts = $this->fetchProducts($filter, $count);
        }

        $remainProducts = [];
        $remainCount = $count - count($recommendedProducts);

        if ($remainCount) {
            $filter = [
                '>*CATALOG_QUANTITY' => 0,
                'ACTIVE' => 'Y',
                '!ID' => $productIds,
                'SECTION_ID' => $sectionId,
                'INCLUDE_SUBSECTIONS' => 'Y',
            ];
            $remainProducts = $this->fetchProducts($filter, $remainCount);
        }

        $products = array_replace($recommendedProducts, $remainProducts);
        $productIds = array_keys($products);

        $this->fillAvailableProducts($products);
        $this->fillPrices($products, $productIds);
        $this->fillRatings($products, $productIds);
        $this->fillAvailableOffers($products, $productIds);

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
            $products[$key]['CAN_BUY'] = 'Y';
        }
    }


    private function fillRatings(array &$products, array $productIds): void {
        $reviews = new Reviews();
        $ratings = $reviews->getReviewsRatingForProducts($productIds);

        foreach ($ratings as $key => $rating) {
            $products[$key]['REVIEWS'] = $rating;
        }
    }


    private function fetchProducts(array $filter, int $count): array {
        $filterParams = $this->makeFilterParams($filter);
        $countParams = $this->makeCountParams($count);
        $products = [];

        $productsResource = CIBlockElement::GetList(
            ['rand' => 'asc'],
            $filterParams,
            false,
            $countParams
        );

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
            if ($this->userIsWholesaler && $price['CATALOG_GROUP_ID'] != Products::OPT_PRICE_ID && $products[$price['PRODUCT_ID']]['PRICES']['PRICE']) {
                continue;
            }
            if (!$this->userIsWholesaler && $price['CATALOG_GROUP_ID'] == Products::OPT_PRICE_ID) {
                continue;
            }
            $products[$price['PRODUCT_ID']]['PRICES']['PRICE'] = number_format($price['PRICE'], 0, '.', ' ');
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