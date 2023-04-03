<?php

namespace Helpers\Filters;

/**
 * Класс по работе с фильтром отзывов.
 */
class ReviewsFilterHelper
{
    /** @var int */
    private int $productId = 0;

    /** @var string */
    private string $sortField = 'PROPERTY_RATING';

    /** @var string */
    private string $sortOrder = 'DESC';


    public function __construct()
    {
        $this->prepareParams();
    }


    public function getSortParams(): array {
        return [
            'SORT_FIELD' => $this->sortField,
            'SORT_ORDER' => $this->sortOrder,
        ];
    }


    public function getFilterParams(): array {
        return [
            'PROPERTY_PRODUCT_ID' => $this->productId,
        ];
    }


    private function prepareParams(): void {
        $this->sanitizeParams();
        $this->defineParams();
    }


    private function sanitizeParams(): void {
        if (empty($_GET)) {
            return;
        }
        foreach ($_GET as $param => $value) {
            $_GET[$param] = filter_var($value, FILTER_SANITIZE_STRING);
        }
    }


    private function defineParams(): void {
        if ($_GET['productId']) {
            $this->productId = $_GET['productId'];
        }
        if ($_GET['sort'] === 'high') {
            $this->sortOrder = 'DESC';
        }
        if ($_GET['sort'] === 'low') {
            $this->sortOrder = 'ASC';
        }
    }
}