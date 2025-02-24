<?php

namespace Local\Util;

use Bitrix\Iblock\Iblock;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;

/**
 * Class IblockHelper
 * @package Local\ORMHelper
 *
 * Класс для работы с инфоблоками.
 */
class IblockHelper implements IblockHelperInterface
{
    /**
     * Получение сущности IB
     * @param string $ibCode Код инфоблока.
     * @return ElementTable
     */
    public static function getIBEntityDataClass(string $ibCode)
    {
        Loader::includeModule('iblock');

        $iblock = Iblock::wakeUp(self::getIBIdByCode($ibCode));

        return $iblock->getEntityDataClass();
    }

    /**
     * Получение ID инфоблока
     * @param string $ibCode Код инфоблока.
     * @return string
     */
    private static function getIBIdByCode(string $ibCode)
    {
        Loader::includeModule('iblock');
        return IblockTable::getList(array(
            'filter' => array('CODE' => $ibCode),
        ))->fetch()['ID'];
    }

    /**
     * Получение ID инфоблока
     * @param string $ibCode Код инфоблока.
     * @return string
     */
    public static function getIdByCode(string $ibCode)
    {
        Loader::includeModule('iblock');
        return IblockTable::getList(array(
            'filter' => array('CODE' => $ibCode),
        ))->fetch()['ID'];
    }
}
