<?php

use Helpers\Filters\ProductsFilterHelper;

global $arFilterCatalog;

$filterHelperInstance = new ProductsFilterHelper($currentSection);
$filterParams = $filterHelperInstance->getFilters() ?? [];

$arFilterCatalog = array_merge(
    $arFilterCatalog,
    $filterParams
);