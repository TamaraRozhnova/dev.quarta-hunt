<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Form\ProductSubscribeForm;

$requestBody = (array)json_decode(file_get_contents('php://input'));

$productSubscribeForm = new ProductSubscribeForm();

$response = $productSubscribeForm->subscribe($requestBody);

echo json_encode($response);