<?php

namespace Catalog\Rating\DTO;

use Catalog\Rating\Enum\RatingGrade;

class RatingDTO
{
    /** @var int $userId */
    private int $userId;

    /** @var int $iblockId */
    private int $iblockId;

    /** @var int $productId */
    private int $productId;

    /** @var RatingGrade $grade */
    private RatingGrade $grade;

    /**
     * @param int $userId
     * @param int $iblockId
     * @param int $productId
     * @param RatingGrade $grade
     */
    public function __construct(int $userId, int $iblockId, int $productId, RatingGrade $grade)
    {
        $this->userId = $userId;
        $this->iblockId = $iblockId;
        $this->productId = $productId;
        $this->grade = $grade;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getIblockId(): int
    {
        return $this->iblockId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return RatingGrade
     */
    public function getGrade(): RatingGrade
    {
        return $this->grade;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return
            [
                'USER_ID' => $this->getUserId(),
                'IBLOCK_ID' => $this->getIblockId(),
                'PRODUCT_ID' => $this->getProductId(),
                'GRADE' => $this->getGrade()->value,
            ];
    }
}
