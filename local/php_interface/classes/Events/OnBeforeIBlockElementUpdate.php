<?php

namespace CustomEvents;

class OnBeforeIBlockElementUpdate
{
    public static function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        if ($_REQUEST['mode'] == 'import') {
            unset($arFields['CODE']);
        }
    }
}