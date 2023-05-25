<?php

namespace Helpers\Filters;

use Bitrix\Iblock\SectionTable;
use General\User;

/**
 * Класс по работе с фильтрами товаров.
 */
class ProductsFilterHelper
{
    /** @var string */
    private string $sectionName = '';

    /** @var string */
    private string $priceId = BASE_PRICE_CODE_ID;

    /** @var string */
    private string $sortField = 'NAME';

    /** @var string */
    private string $sortOrder = 'ASC';

    /** @var string */
    private string $onlyAvailable = 'N';

    /**
     * @var array - ассоциативный массив, где ключ - код типа цены со знаком "<" или ">", значение - порог цены
     */
    private array $prices = [];

    /** @var int */
    private int $itemsPerPage = 20;

    /** @var int[] */
    private array $itemsPerPageOptions = [20, 40, 60, 9999];


    public function __construct($sectionId)
    {
        $this->definePriceId();
        $this->prepareParams();
        $this->defineSectionName($sectionId);
    }


    public function getFilters(): array {
        return [
            "SECTION_NAME" => $this->sectionName,
            "SORT_FIELD" => $this->sortField,
            "SORT_ORDER" => $this->sortOrder,
            "ONLY_AVAILABLE" => $this->onlyAvailable,
            "ELEMENT_COUNT" => $this->itemsPerPage,
            "PRICES" => $this->prices
        ];
    }


    private function definePriceId(): void {
        $user = new User();
        $this->priceId = $user->getUserPriceCodeId();
    }


    private function defineSectionName($sectionId): void {
        try {
            $section = SectionTable::query()
                ->addSelect('NAME')
                ->where('IBLOCK_ID', CATALOG_IBLOCK_ID)
                ->where('ID', $sectionId)
                ->setCacheTtl(3600000)
                ->fetch()
            ;
            $this->sectionName = $section['NAME'];
        } catch (\Exception $expected) {
        }
    }


    private function prepareParams(): void {
        $this->sanitizeParams();
        $this->defineAvailableParam();
        $this->definePriceParams();
        $this->definePageParams();
        $this->defineSortParams();
    }


    private function sanitizeParams(): void {
        if (empty($_GET)) {
            return;
        }
        foreach ($_GET as $param => $value) {
            $_GET[$param] = filter_var($value, FILTER_SANITIZE_STRING);
        }
    }


    private function definePriceParams(): void {
        $minPrice = (int)$_GET['minPrice'];
        $maxPrice = (int)$_GET['maxPrice'];

        if ($this->onlyAvailable === 'Y') {
            $this->prices[">$this->priceId"] = 0;
        }
        if ($minPrice) {
            $this->prices[">=$this->priceId"] = $minPrice;
        }
        if ($maxPrice) {
            $this->prices["<=$this->priceId"] = $maxPrice;
        }
    }


    private function defineSortParams(): void {
        if ($_GET['sort'] === 'expensive') {
            $this->sortField = 'SCALED_' . $this->priceId;
            $this->sortOrder = 'DESC';
        }
        if ($_GET['sort'] === 'cheaper') {
            $this->sortField = 'SCALED_' . $this->priceId;
            $this->sortOrder = 'ASC';
        }
        if ($_GET['sort'] === 'available_discount') {
            $this->sortField = 'PROPERTY_SIZE_DISCOUNT';
            $this->sortOrder = 'DESC';
        }
    }


    private function definePageParams(): void {

        $itemsPerPage = (int)$_GET['itemsPerPage'];
        if (!$itemsPerPage) {
            return;
        }
        if (in_array($itemsPerPage, $this->itemsPerPageOptions)) {
            $this->itemsPerPage = $itemsPerPage;
        }
    }


    private function defineAvailableParam(): void {
        if ($_GET['onlyAvailable'] === 'true') {
            $this->onlyAvailable = 'Y';
        }
    }

}