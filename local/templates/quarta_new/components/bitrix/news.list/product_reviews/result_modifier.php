<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Feedback\Review;
use General\User;

$userInstance = new User();
$reviewsInstance = new Review();
$allResponseIds = [];

foreach ($arResult['ITEMS'] as $key => $review) {
    $responseIds = $arResult['ITEMS'][$key]['PROPERTIES']['RESPONSES']['VALUE'];
    if ($responseIds) {
        $allResponseIds = array_merge($allResponseIds, $responseIds);
    }
    $reviewUser = $userInstance->getById($review['PROPERTIES']['USER_ID']['VALUE']);
    $arResult['ITEMS'][$key]['USER_NAME'] = $reviewUser['NAME'];

    $likes = $review['PROPERTIES']['LIKES']['VALUE'];
    $dislikes = $review['PROPERTIES']['DISLIKES']['VALUE'];
    $arResult['ITEMS'][$key]['LIKES']['COUNT'] = 0;
    $arResult['ITEMS'][$key]['DISLIKES']['COUNT'] = 0;

    if ($likes) {
        $likesUserIds = explode(',', $likes);
        $arResult['ITEMS'][$key]['LIKES']['COUNT'] = count($likesUserIds);
        $arResult['ITEMS'][$key]['LIKES']['ACTIVE'] = in_array($userInstance->getId(), $likesUserIds);
    }

    if ($dislikes) {
        $dislikesUserIds = explode(',', $dislikes);
        $arResult['ITEMS'][$key]['DISLIKES']['COUNT'] = count($dislikesUserIds);
        $arResult['ITEMS'][$key]['DISLIKES']['ACTIVE'] = in_array($userInstance->getId(), $dislikesUserIds);
    }

    $imageIds = $review['PROPERTIES']['IMAGES']['VALUE'];
    if ($imageIds) {
        foreach ($imageIds as $imageId) {
            $arResult['ITEMS'][$key]['IMAGES'][]['SRC'] = CFile::GetPath($imageId);
        }
    }

    $maxRatingStars = 5;
    $rating = (int)$review['PROPERTIES']['RATING']['VALUE'];
    $arResult['ITEMS'][$key]['RATING']['FILL_STARS'] = $rating;
    $arResult['ITEMS'][$key]['RATING']['OUTLINE_STARS'] = $maxRatingStars - $rating;
}

if (!empty($allResponseIds)) {
    $responses = $reviewsInstance->getResponses($allResponseIds);
    foreach ($arResult['ITEMS'] as $key => $review) {
        $arResult['ITEMS'][$key]['RESPONSES'] = $responses[$review['ID']] ?? [];
    }
}



