<?

use CustomEvents\Hut\OneCImportHandler;

function BXIBlockAfterSave(&$arFields)
{
    OneCImportHandler::IBlockElementUpdateHandler($arFields);
}
