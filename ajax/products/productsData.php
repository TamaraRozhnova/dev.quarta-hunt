<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Helpers\ProductsDataHelper;

$requestBody = json_decode(file_get_contents('php://input'));

echo json_encode((object)ProductsDataHelper::getProductsData($requestBody->productIds, true));