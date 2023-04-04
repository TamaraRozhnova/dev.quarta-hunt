<?php

namespace Feedback;

use CFile;
use CIBlockElement;
use CModule;
use General\User;

/**
 * Класс по работе с отзывами на товары.
 */
class Review
{
    const REVIEWS_IBLOCK_ID = 11;
    const RESPONSES_TO_REVIEWS_IBLOCK_ID = 28;

    /** @var int */
    private int $userId;


    public function __construct()
    {
        CModule::IncludeModule('iblock');

        $user = new User();
        if ($user->isAuthorized()) {
            $this->userId = $user->getId();
        }
    }


    public function addReview(array $data, array $images): bool {
        if (!$this->userId || !$data['rating'] || !$data['productId']) {
            return false;
        }

        $fields = $this->makeFieldsForAddingReview($data);

        $el = new CIBlockElement();
        $reviewId = $el->Add($fields);

        if (!$reviewId) {
            return false;
        }

        $this->attachImagesToReview($reviewId, $images);

        return true;
    }


    public function addResponseToReview(int $reviewId, string $responseText): bool
    {
        if (!$this->userId || !$responseText) {
            return false;
        }
        $el = new CIBlockElement();
        $reviewResource = $el->GetByID($reviewId);
        if ($review = $reviewResource->GetNextElement()) {
            $props = $review->GetProperties();
            $data = $this->makeFieldsForAddingResponseToReview($reviewId, $responseText);
            $newResponseId = $el->Add($data);

            if (!$newResponseId) {
                return false;
            }

            $responses = $props['RESPONSES']['VALUE'];
            $responses[] = strval($newResponseId);
            $el->SetPropertyValuesEx($reviewId, Review::REVIEWS_IBLOCK_ID, ['RESPONSES' => $responses]);
            return true;
        }
        return false;
    }


    /**
     * @param int $reviewId - Id отзыва
     * @param bool $isLike - true - если изменяем лайк, false - дизлайк
     * @return array|false - возвращает ассоциативный массив с количиством лайков и дизлайков у отзыва
     * + текущий активный лайк/дизлайк пользователя. В случае ошибки возвращает false
     */
    public function changeLikeOrDislike(int $reviewId, bool $isLike) {
        if (!$this->userId) {
            return false;
        }

        $filter = ['IBLOCK_ID' => Review::REVIEWS_IBLOCK_ID, 'ID' => $reviewId];
        $reviewResource = CIBlockElement::GetList([], $filter);

        if ($review = $reviewResource->GetNextElement()) {
            $fields = $review->GetProperties();
            $likesUserIds = array_diff(explode(',', $fields['LIKES']['VALUE']), ['']);
            $dislikesUserIds = array_diff(explode(',', $fields['DISLIKES']['VALUE']), ['']);
            if ($isLike) {
                $isAdded = $this->changeCountLikesAndDislikes($likesUserIds, $dislikesUserIds);
            } else {
                $isAdded = $this->changeCountLikesAndDislikes($dislikesUserIds, $likesUserIds);
            }
            $this->saveLikesAndDislikes($reviewId, $likesUserIds, $dislikesUserIds);
            return [
                'LIKES' => count($likesUserIds),
                'DISLIKES' => count($dislikesUserIds),
                'ACTIVE' => $this->getActiveLikeOrDislike($isLike, $isAdded)
            ];
        }
        return false;
    }



    /**
     * @param int[] $productIds - массив идентификатор товаров
     * @return array - возвращает ассоциативный массив, где:
     * ключ — идентификатор товара, значение — ассоциавтивный массив с рейтингом товара и количеством отзывов
     */
    public function getReviewsRatingAndCountForProducts(array $productIds): array
    {
        $filter = ['IBLOCK_ID' => Review::REVIEWS_IBLOCK_ID, 'ACTIVE' => 'Y', 'PROPERTY_PRODUCT_ID' => $productIds];
        $reviewsResource = CIBlockElement::GetList([], $filter);
        $tempReviews = [];
        $result = [];

        while ($review = $reviewsResource->GetNextElement()) {
            $props = $review->GetProperties();
            $productId = $props['PRODUCT_ID']['VALUE'];
            $rating = $props['RATING']['VALUE'];
            $tempReviews[$productId][] = $rating;
        }

        foreach ($tempReviews as $productId => $ratings) {
            $result[$productId] = [
                'RATING' => round(array_sum($ratings) / count($ratings), 2),
                'COUNT' => count($ratings)
            ];
        }

        return $result;
    }


    /**
     * @param int[] $responseIds - массив идентификатор ответов на отзыв
     * @return array - возвращает ассоциативный массив со свойствами ответа на отзыв,
     * сгруппированных по идентификаторам отзывов
     */
    public function getResponses(array $responseIds): array {
        $filter = [
            'IBLOCK_ID' => Review::RESPONSES_TO_REVIEWS_IBLOCK_ID,
            'ACTIVE' => 'Y',
            'ID' => $responseIds
        ];
        $responsesResource = CIBlockElement::GetList([], $filter);
        $responses = [];
        $userInstance = new User();

        while ($response = $responsesResource->GetNextElement()) {
            $fields = $response->GetFields();
            $props = $response->GetProperties();
            $user = $userInstance->getById($props['USER_ID']['VALUE']);

            $responses[$props['FEEDBACK_ID']['VALUE']][$fields['ID']] = [
                'USER_NAME' => $user['NAME'],
                'DATETIME' => $fields['TIMESTAMP_X'],
                'TEXT' => $props['FEEDBACK_ANSW']['VALUE']
            ];

        }

        return $responses;
    }


    /**
     * Преобразует 2 массива id пользователей, которые поставили лайк/дизлайк на отзыв
     * @param int[] &$first - массив идентификаторов пользователей, с которым производится прямое изменение списка
     * @param int[] &$second - массив идентификаторов пользователей, который будет изменен,
     * в случае нахождения id пользователя в данном массиве
     * @return bool - возвращает true - если был добавлен лайк/дизлайк, и false - если был удален лайк/дизлайк
     */
    private function changeCountLikesAndDislikes(array &$first, array &$second): bool {
        $isAdded = false;
        $keyFirst = array_search($this->userId, $first);
        $keySecond = array_search($this->userId, $second);

        if ($keyFirst !== false) {
            unset($first[$keyFirst]);
        } else {
            $first[] = $this->userId;
            $isAdded = true;
        }
        unset($second[$keySecond]);

        return $isAdded;
    }


    private function getActiveLikeOrDislike(bool $isLike, bool $isAdded) {
        if ($isAdded && $isLike) {
            return 'LIKE';
        }
        if ($isAdded && !$isLike) {
            return 'DISLIKE';
        }
        return false;
    }


    private function saveLikesAndDislikes(int $reviewId, array $likesUserIds, array $dislikesUserIds): void {
        $propertyValues['LIKES'] = implode(',', $likesUserIds);
        $propertyValues['DISLIKES'] = implode(',', $dislikesUserIds);
        $el = new CIBlockElement();
        $el->SetPropertyValuesEx($reviewId, Review::REVIEWS_IBLOCK_ID, $propertyValues);
    }


    private function attachImagesToReview(int $reviewId, array $images): void {
        $resultFiles = [];
        $fileNames = [];
        foreach ($images['name'] as $i => $image) {
            $fileName = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . basename($images['name'][$i]);
            $upl = move_uploaded_file($images['tmp_name'][$i], $fileName);

            if ($upl) {
                $fileArr = CFile::MakeFileArray($fileName);
                $resultFiles[] = ['VALUE' => $fileArr, 'DESCRIPTION' => $fileArr['name']];
                $fileNames[] = $fileName;
            }
        }
        if (!empty($resultFiles)) {
            $el = new CIBlockElement();
            $el->SetPropertyValuesEx($reviewId, Review::REVIEWS_IBLOCK_ID, ['IMAGES' => $resultFiles]);
            foreach ($fileNames as $fileName) {
                unlink($fileName);
            }
        }
    }


    private function makeFieldsForAddingResponseToReview(int $reviewId, $responseText): array {
        $date = date('Y_m_d_H_i_s');
        $name = 'feed_answ_' . $reviewId . '_' . $this->userId . '_' . $date;

        return [
            'IBLOCK_ID' => Review::RESPONSES_TO_REVIEWS_IBLOCK_ID,
            'NAME' => $name,
            'CODE' => $name,
            'XML_ID' => $name,
            'ACTIVE' => 'N',
            'PROPERTY_VALUES' => [
                'FEEDBACK_ID' => $reviewId,
                'USER_ID' => $this->userId,
                'FEEDBACK_ANSW' => $responseText,
            ],
        ];
    }


    private function makeFieldsForAddingReview(array $data): array {
        $date = date('Y_m_d_H_i_s');
        $name = 'feed_' . $data['productId'] . '_' . $this->userId . '_' . $date;

        return [
            'IBLOCK_ID' => Review::REVIEWS_IBLOCK_ID,
            'NAME' => $name,
            'CODE' => $name,
            'XML_ID' => $name,
            'ACTIVE' => 'N',
            'PROPERTY_VALUES' => [
                'PRODUCT_ID' => $data['productId'],
                'USER_ID' => $this->userId,
                'FLAWS' => $data['flaws'],
                'DIGNITIES' => $data['dignities'],
                'COMMENTS' => $data['comments'],
                'RATING' => $data['rating'],
            ],
        ];
    }
}