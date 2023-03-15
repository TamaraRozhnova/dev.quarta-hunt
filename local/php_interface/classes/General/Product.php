<?php

namespace General;

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
}