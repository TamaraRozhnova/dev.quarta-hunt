<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Form\ProductQuestionForm;

$requestBody = (array)json_decode(file_get_contents('php://input'));

$productQuestionForm = new ProductQuestionForm();

$response = $productQuestionForm->sendQuestion($requestBody);

echo json_encode($response);