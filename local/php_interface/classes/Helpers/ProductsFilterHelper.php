<?php

namespace Helpers;

/**
 * Класс по работе с дополнительными фильтрами товаров.
 */
class ProductsFilterHelper
{
    /** @var string */
    private string $sortField = 'NAME';

    /** @var string */
    private string $sortOrder = 'ASC';

    /** @var string */
    private string $onlyAvailable = 'N';

    /** @var int */
    private int $itemsPerPage = 20;


    public function __construct()
    {
        $this->prepareParams();
    }


    public function getFilters(): array {
        return [
            "SORT_FIELD" => $this->sortField,
            "SORT_ORDER" => $this->sortOrder,
            "ONLY_AVAILABLE" => $this->onlyAvailable,
            "ELEMENT_COUNT" => $this->itemsPerPage,
        ];
    }


    private function prepareParams(): void {
        $this->defineSortParams();
        $this->definePageParams();
        $this->defineAvailableParam();
    }


    private function defineSortParams(): void {
        if ($_REQUEST['sort'] === 'expensive') {
            $this->sortField = 'SCALED_PRICE_1';
            $this->sortOrder = 'DESC';
        }
        if ($_REQUEST['sort'] === 'cheaper') {
            $this->sortField = 'SCALED_PRICE_1';
            $this->sortOrder = 'ASC';
        }
    }


    private function definePageParams(): void {
        if ((int)$_REQUEST['itemsPerPage']) {
            $this->itemsPerPage = $_REQUEST['itemsPerPage'];
        }
    }


    private function defineAvailableParam(): void {
        if ($_REQUEST['onlyAvailable'] === 'true') {
            $this->onlyAvailable = 'Y';
        }
    }

}