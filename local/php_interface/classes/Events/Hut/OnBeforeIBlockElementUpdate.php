<?php

namespace CustomEvents\Hut;

use Bitrix\Main\Diag\Debug;

class OnBeforeIBlockElementUpdate
{
    public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        //Debug::writeToFile($arFields, "arFields");
    }
}
