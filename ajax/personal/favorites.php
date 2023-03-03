<?php

include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';

use Personal\Favorites;

$requestBody = json_decode(file_get_contents('php://input'));
$response = null;

$favorites = new Favorites();

switch ($requestBody->action) {
    case 'ADD':
        $response = $favorites->addFavorites($requestBody->id);
        break;

    case 'DELETE':
        $response = $favorites->deleteFavorites($requestBody->id);
        break;

    case 'CLEAR':
        $response = $favorites->clearFavorites();
        break;

    default:
        break;
}

echo json_encode($response);