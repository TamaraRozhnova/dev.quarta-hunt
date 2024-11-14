<?php

namespace Catalog\Rating\Enum;

enum RatingGrade: int
{
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case FIVE = 5;

    /**
     * @return array
     */
    public static function getValues(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
