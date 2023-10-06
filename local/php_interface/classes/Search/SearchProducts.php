<?php

namespace SearchSphinx;

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use \Olegpro\BitrixSphinx\Entity\SphinxDataManager;
use \Olegpro\BitrixSphinx\Entity\SphinxQuery;

Loc::loadMessages(__FILE__);

class ProductTable extends SphinxDataManager
{

    /**
     * Returns index sphinx name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'products_index';
    }

    /**
     * Returns sphinx-connection name for entity
     *
     * @return string
     */
    public static function getConnectionName()
    {
        return 'sphinx';
    }

    /**
     * Creates and returns the Query object for the entity
     *
     * @return SphinxQuery
     */
    public static function query()
    {
        return new SphinxQuery(static::getEntity());
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new Main\Entity\IntegerField('id', [
                'primary' => true,
            ]),
            new Main\Entity\StringField('code'),
            new Main\Entity\StringField('name'),
            new Main\Entity\StringField('preview_text'),
            new Main\Entity\StringField('article'),
            new Main\Entity\StringField('iblock_section_id'),
            new Main\Entity\StringField('iblock_code'),
            new Main\Entity\StringField('iblock_id'),

            new Main\Entity\FloatField('price_1'),
            new Main\Entity\FloatField('price_3'),
        ];

    }

}