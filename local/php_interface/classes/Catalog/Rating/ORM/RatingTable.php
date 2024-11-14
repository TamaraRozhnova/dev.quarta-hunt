<?php

namespace Catalog\Rating\ORM;

use Catalog\Rating\Enum\RatingGrade;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\ORM\Fields\EnumField;
use Bitrix\Main\ORM\Fields\IntegerField;

class RatingTable extends DataManager
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'addamant_thanks_catalog_rating';
    }

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return
            [
                (new IntegerField('ID'))
                    ->configurePrimary()
                    ->configureAutocomplete(),
                (new IntegerField('USER_ID'))->configureRequired(),
                (new IntegerField('IBLOCK_ID'))->configureRequired(),
                (new IntegerField('PRODUCT_ID'))->configureRequired(),
                (new EnumField('GRADE'))
                    ->configureRequired()
                    ->configureValues(RatingGrade::getValues()),
            ];
    }
}
