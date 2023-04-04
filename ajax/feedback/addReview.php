<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Feedback\Review;

$reviews = new Review();

$response = $reviews->addReview($_POST, $_FILES['images'] ?? []);

echo json_encode($response);