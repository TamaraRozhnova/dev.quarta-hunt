<?php

namespace Local\Util;

interface IblockHelperInterface
{
    /**
     * Получение сущности IB
     * @param string $ibCode Код инфоблока.
     * @return ElementTable
     */
    public static function getIBEntityDataClass(string $ibCode);
}
