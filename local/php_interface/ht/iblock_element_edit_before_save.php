<?

use CustomEvents\Hut\OnBeforeIBlockElementUpdate;

function BXIBlockAfterSave(&$arFields)
{
    OnBeforeIBlockElementUpdate::OnBeforeIBlockElementUpdateHandler($arFields);
}
