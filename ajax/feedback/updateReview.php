<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Feedback\Review;

$requestBody = json_decode(file_get_contents('php://input'));

$reviews = new Review();

switch ($requestBody->action) {
    case 'LIKE':
        $response = $reviews->changeLikeOrDislike($requestBody->reviewId, true);
        break;

    case 'DISLIKE':
        $response = $reviews->changeLikeOrDislike($requestBody->reviewId, false);
        break;

    case 'RESPONSE':
        $response = $reviews->addResponseToReview($requestBody->reviewId, $requestBody->responseText);
        break;

    default:
        $response = null;
        break;
}

echo json_encode($response);