<?php

namespace Catalog\Rating\Service;

use Catalog\Rating\DTO\RatingDTO;
use Catalog\Rating\Enum\RatingGrade;
use Catalog\Rating\ORM\RatingTable;
use Bitrix\Iblock\Model\PropertyFeature;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use CIBlock;
use CIBlockElement;
use CIBlockProperty;

class RatingManager
{
    /**     
     * @throws LoaderException
     */
    public function __construct()
    {
        Loader::includeModule('iblock');
    }

    /**
     * Метод создает рейтинг товара от конкретного пользователя
     *
     * @param RatingDTO $ratingDTO
     *
     * @return Result
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws SqlQueryException
     */
    public function addRating(RatingDTO $ratingDTO): Result
    {
        $result = new Result();

        $connection = Application::getConnection();
        $connection->startTransaction();

        $checkIblockPropertiesExistResult = $this->checkIblockPropertiesExist($ratingDTO->getIblockId());

        if (!$checkIblockPropertiesExistResult->isSuccess()) {
            $connection->rollbackTransaction();
            return $checkIblockPropertiesExistResult;
        }

        if (
            $this->getRatingByUserId(
                $ratingDTO->getUserId(),
                $ratingDTO->getIblockId(),
                $ratingDTO->getProductId(),
            )
        ) {
            $connection->rollbackTransaction();
            $result->addError(new Error(Loc::getMessage('CURRENT_USER_ALREADY_RATING')));
            return $result;
        }

        $addRatingResult = RatingTable::add($ratingDTO->toArray());

        if (!$addRatingResult->isSuccess()) {
            $connection->rollbackTransaction();
            return $addRatingResult;
        }

        $connection->commitTransaction();

        $productRatingInfo = $this->getProductRatingInfo(0, $ratingDTO->getIblockId(), $ratingDTO->getProductId());

        $this->updateProductAverageRating(
            $ratingDTO->getIblockId(),
            $ratingDTO->getProductId(),
            $productRatingInfo['AVERAGE_RATING'],
        );

        $result->setData($productRatingInfo);

        return $result;
    }

    /**
     * Метод удаляет рейтинг товара от конкретного пользователя
     *
     * @param int $ratingId
     *
     * @return Result
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ObjectPropertyException
     * @throws SqlQueryException
     * @throws SystemException
     */
    public function deleteRating(int $ratingId): Result
    {
        $result = new Result();

        $connection = Application::getConnection();
        $connection->startTransaction();

        $productRatingInfo = $this->getProductRatingInfo($ratingId);

        if (!$productRatingInfo['IBLOCK_ID']) {
            return $result;
        }

        $checkIblockPropertiesExistResult = $this->checkIblockPropertiesExist($productRatingInfo['IBLOCK_ID']);

        if (!$checkIblockPropertiesExistResult->isSuccess()) {
            $connection->rollbackTransaction();
            return $checkIblockPropertiesExistResult;
        }

        $deleteRatingResult = RatingTable::delete($ratingId);

        if (!$deleteRatingResult->isSuccess()) {
            $connection->rollbackTransaction();
            return $deleteRatingResult;
        }

        $connection->commitTransaction();

        $productRatingInfo = $this->getProductRatingInfo(
            0,
            $productRatingInfo['IBLOCK_ID'],
            $productRatingInfo['PRODUCT_ID'],
        );

        $this->updateProductAverageRating(
            $productRatingInfo['IBLOCK_ID'],
            $productRatingInfo['PRODUCT_ID'],
            $productRatingInfo['AVERAGE_RATING'],
        );

        return $result;
    }

    /**
     * Метод изменяет оценку товара от конкретного пользователя
     *
     * @param int $ratingId
     * @param RatingGrade $grade
     *
     * @return Result
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ObjectPropertyException
     * @throws SqlQueryException
     * @throws SystemException
     */
    public function updateRating(int $ratingId, RatingGrade $grade): Result
    {
        $result = new Result();

        $connection = Application::getConnection();
        $connection->startTransaction();

        $productRatingInfo = $this->getProductRatingInfo($ratingId);

        if (!$productRatingInfo['IBLOCK_ID']) {
            return $result;
        }

        $checkIblockPropertiesExistResult = $this->checkIblockPropertiesExist($productRatingInfo['IBLOCK_ID']);

        if (!$checkIblockPropertiesExistResult->isSuccess()) {
            $connection->rollbackTransaction();
            return $checkIblockPropertiesExistResult;
        }

        $updateRatingResult = RatingTable::update($ratingId, ['GRADE' => $grade->value]);

        if (!$updateRatingResult->isSuccess()) {
            $connection->rollbackTransaction();
            return $updateRatingResult;
        }

        $connection->commitTransaction();

        $productRatingInfo = $this->getProductRatingInfo(
            0,
            $productRatingInfo['IBLOCK_ID'],
            $productRatingInfo['PRODUCT_ID'],
        );

        $this->updateProductAverageRating(
            $productRatingInfo['IBLOCK_ID'],
            $productRatingInfo['PRODUCT_ID'],
            $productRatingInfo['AVERAGE_RATING'],
        );

        $result->setData($productRatingInfo);

        return $result;
    }

    /**
     * Метод возвращает информацию о рейтинге
     *
     * Данные о рейтинге: идентификатор продукта, идентификатор каталога, средний рейтинг, кол-во оценок, сумма оценок
     *
     * @param int $ratingId Является необязательным параметром, если передается идентификатор инфоблока и товара
     * @param int $iblockId
     * @param int $productId
     *
     * @return array
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getProductRatingInfo(int $ratingId, int $iblockId = 0, int $productId = 0): array
    {
        if (!$ratingId && (!$iblockId || !$productId)) {
            throw new ArgumentNullException('ratingId');
        }

        if ($ratingId) {
            $filter = ['ID' => $ratingId];
        } else {
            $filter = ['IBLOCK_ID' => $iblockId, 'PRODUCT_ID' => $productId];
        }

        $ratingQuery = RatingTable::getList([
            'filter' => $filter,
        ]);
        $countRating = 0;
        $sumRating = 0;
        $ratingProductId = 0;
        $ratingIblockId = 0;

        while ($rating = $ratingQuery->fetch()) {
            $ratingProductId = $rating['PRODUCT_ID'];
            $ratingIblockId = $rating['IBLOCK_ID'];
            $sumRating += $rating['GRADE'];
            $countRating++;
        }

        $averageRating = ($countRating === 0) ? 0 : round($sumRating / $countRating, 1);

        return
            [
                'PRODUCT_ID' => $ratingProductId,
                'IBLOCK_ID' => $ratingIblockId,
                'AVERAGE_RATING' => $averageRating,
                'COUNT_RATING' => $countRating,
                'SUM_RATING' => $sumRating,
            ];
    }

    /**
     * Метод возвращает информацию о рейтинге конкретного пользователя
     *
     * Данные о рейтинге: идентификатор продукта, идентификатор каталога, средний рейтинг, кол-во оценок, сумма оценок
     *
     * @param int $userId
     * @param int $iblockId
     * @param int $productId
     *
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getRatingByUserId(int $userId, int $iblockId, int $productId): array
    {
        $ratingQuery = RatingTable::getList([
            'filter' => ['USER_ID' => $userId, 'IBLOCK_ID' => $iblockId, 'PRODUCT_ID' => $productId],
        ]);
        $rating = $ratingQuery->fetch();

        return $rating ?: [];
    }

    /**
     * @param int $iblockId
     * @param int $productId
     * @param float $averageRating
     *
     * @return void
     */
    private function updateProductAverageRating(int $iblockId, int $productId, float $averageRating): void
    {
        CIBlockElement::SetPropertyValuesEx($productId, $iblockId, ['AVERAGE_RATING' => $averageRating]);
    }

    /**
     * @param int $iblockId
     *
     * @return Result
     */
    private function checkIblockPropertiesExist(int $iblockId): Result
    {
        $result = new Result();
        $properties = $this->getIblockProperties();

        $propertyQuery = CIBlock::GetProperties($iblockId, [], ['CHECK_PERMISSIONS' => 'N']);
        $propertiesExist = [];

        while ($property = $propertyQuery->fetch()) {
            $propertiesExist[$property['CODE']] = $property['ID'];
        }

        $nonExistentProperties = array_diff_key($properties, $propertiesExist);

        if (!$nonExistentProperties) {
            return $result;
        }

        return $this->createIblockProperties($iblockId, $nonExistentProperties);
    }

    /**
     * @param int $iblockId
     * @param array $properties
     *
     * @return Result
     */
    private function createIblockProperties(int $iblockId, array $properties): Result
    {
        $result = new Result();

        foreach ($properties as $property) {
            $propertyFeatures = $property['PROPERTY_FEATURES'];
            unset($property['PROPERTY_FEATURES']);

            $property['IBLOCK_ID'] = $iblockId;

            $propertyEntity = new CIBlockProperty();
            $propertyId = $propertyEntity->Add($property);

            if (!$propertyId) {
                $errorsText = explode('.<br>', $propertyEntity->LAST_ERROR);

                foreach ($errorsText as $errorText) {
                    if (empty($errorText)) {
                        continue;
                    }

                    $result->addError(new Error($errorText));
                }

                return $result;
            }

            if (!$propertyFeatures) {
                continue;
            }

            $addFeaturesResult = PropertyFeature::addFeatures($propertyId, $propertyFeatures);

            if (!$addFeaturesResult->isSuccess()) {
                return $addFeaturesResult;
            }
        }

        return $result;
    }

    /**
     * @return array[]
     */
    private function getIblockProperties(): array
    {
        return
            [
                'AVERAGE_RATING' => [
                    'NAME' => 'Средняя оценка',
                    'CODE' => 'AVERAGE_RATING',
                    'PROPERTY_TYPE' => PropertyTable::TYPE_NUMBER,
                    'PROPERTY_FEATURES' =>
                    [
                        [
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                            'IS_ENABLED' => 'Y',
                        ],
                        [
                            'MODULE_ID' => 'iblock',
                            'FEATURE_ID' => 'LIST_PAGE_SHOW',
                            'IS_ENABLED' => 'Y',
                        ],
                    ],
                ],
            ];
    }
}
