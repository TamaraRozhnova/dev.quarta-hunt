<?php

namespace General;

use CCatalogProduct;
use CCatalogSku;
use CFile;
use CIBlockElement;
use CPrice;
use Feedback\Review;
use Helpers\DiscountsHelper;

class Product
{
    private array $product;

    public function __construct(int $id)
    {
        $base_pr_res = \CIBlockElement::GetList([], ['ID' => $id], false, false,
            ['ID', 'NAME', 'CODE', 'XML_ID', 'PRICE_1', 'PRICE_2', 'PRICE_3', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'DETAIL_PAGE_URL',
                'PROPERTY_CML2_ARTICLE', 'PROPERTY_CML2_TAXES', 'PROPERTY_CML2_TRAITS', 'PROPERTY_CML2_MANUFACTURER', 'PROPERTY_CML2_BASE_UNIT']);

        if ($base_pr = $base_pr_res->GetNext()) {
            $this->product = $base_pr;
        }
    }

    public static function getProductById(int $id): Product
    {
        return new self($id);
    }

    public function inBonusSection(): bool
    {
        return in_array($this->product['IBLOCK_SECTION_ID'], Section::getBonusSectionsArray());
    }

    public function inDoubleBonusSection(): int
    {
        return in_array($this->product['IBLOCK_SECTION_ID'], Section::getBonusDoubleSectionsArray()) ? 2 : 1;
    }

    public function getFieldValue($typePrice)
    {
        return $this->product[$typePrice];
    }


    public static function fetchProducts(array $filter, int $count = 0, string $detailUrlTemplate = ''): array
    {
        $filterParams = Product::makeFilterParams($filter);
        $countParams = Product::makeCountParams($count);
        $products = [];
        $productIds = [];

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
            $productIds[] = $productId;
        }

        Product::fillPrices($products, $productIds);
        Product::fillRatings($products, $productIds);
        Product::fillAvailableProducts($products);
        Product::fillAvailableOffers($products, $productIds);
        DiscountsHelper::fillProductsWithBonuses($products);

        return $products;
    }


    /**
     * Получает список доступных для покупки торговых предложений по id товаров
     * @param array &$products - ассоциативный массив cо свойствами товаров
     * @param int[] $productIds - массив идентификаторов товаров
     */
    private static function fillAvailableOffers(array &$products, array $productIds): void
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


    private static function fillAvailableProducts(array &$products): void
    {
        foreach ($products as $key => $product) {
            if ((float)$product['PRICES_LIST']['PRICE'] > 0) {
                $products[$key]['CAN_BUY'] = 'Y';
            }
        }
    }


    private static function fillRatings(array &$products, array $productIds): void
    {
        $reviews = new Review();
        $ratings = $reviews->getReviewsRatingAndCountForProducts($productIds);

        foreach ($ratings as $key => $rating) {
            $products[$key]['REVIEWS'] = $rating['RATING'];
        }
    }


    private static function fillPrices(array &$products, array $productIds): void
    {
        $user = new User();
        $priceId = $user->getUserPriceId();
        $pricesResource = CPrice::GetList([], ['PRODUCT_ID' => $productIds]);

        while ($price = $pricesResource->Fetch()) {
            if ($price['CATALOG_GROUP_ID'] != $priceId) {
                continue;
            }
            $optimalPrice = CCatalogProduct::GetOptimalPrice($price['PRODUCT_ID'], 1, [], 'N', [$price]);
            $discountPercent = round($optimalPrice['RESULT_PRICE']['PERCENT']);
            if ($discountPercent > 0) {
                $products[$price['PRODUCT_ID']]['PRICES_LIST'] = [
                    'PRICE' => number_format($optimalPrice['RESULT_PRICE']['BASE_PRICE'], 0, '.', ' '),
                    'OLD_PRICE' => number_format($optimalPrice['RESULT_PRICE']['DISCOUNT_PRICE'], 0, '.', ' '),
                    'DISCOUNT' => $discountPercent
                ];
                continue;
            }
            $products[$price['PRODUCT_ID']]['PRICES_LIST'] = [
                'PRICE' => number_format($optimalPrice['RESULT_PRICE']['BASE_PRICE'], 0, '.', ' '),
            ];
        }
    }


    private static function makeFilterParams(array $filter): array
    {
        return array_merge(['IBLOCK_ID' => CATALOG_IBLOCK_ID], $filter);
    }


    private static function makeCountParams(int $count): array
    {
        if (!$count) {
            return [];
        }

        return ['nTopCount' => $count];
    }
}