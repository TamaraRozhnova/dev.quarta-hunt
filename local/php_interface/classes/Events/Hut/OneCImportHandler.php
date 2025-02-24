<?php

namespace CustomEvents\Hut;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Highloadblock as HL;

class OneCImportHandler
{
    protected static $HUT_SIZE_PROPD_ID_1C = 1506;
    protected static $CLOTHES_SIZE_HL_ENTITY = 'Hutclothessize';
    protected static $HUT_CATALOG_OFFERS_IBLOCK_ID = 108;
    protected static $OFFERS_CLOTHES_SIZE_PROP_CODE = 'CLOTHES_SIZE';

    public static function IBlockElementUpdateHandler(&$arFields)
    {
        if ($arFields['IBLOCK_ID'] == self::$HUT_CATALOG_OFFERS_IBLOCK_ID) {
            Loader::includeModule('iblock');

            $oneCSize = false;
            if (is_array($arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C]) && isset($arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C][0])) {
                $oneCSize = $arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C][0]['VALUE'];
            }
            if (is_array($arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C]) &&  isset($arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C]['n0'])) {
                $oneCSize = $arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C]['n0']['VALUE'];
            }
            if (isset($arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C]) && intval($arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C]) > 0) {
                $oneCSize = $arFields['PROPERTY_VALUES'][self::$HUT_SIZE_PROPD_ID_1C];
            }

            if ($oneCSize) {
                $sizeProp = PropertyEnumerationTable::getList([
                    'select' => ['ID', 'VALUE'],
                    'filter' => ['=ID' => $oneCSize],
                ])->fetch();

                if (is_array($sizeProp) && count($sizeProp)) {
                    $entitySize = HL\HighloadBlockTable::compileEntity(self::$CLOTHES_SIZE_HL_ENTITY);
                    $entityDataClassSize = $entitySize->getDataClass();

                    $rsData = $entityDataClassSize::getList([
                        'select' => ['UF_XML_ID'],
                        'order' => [],
                        'filter' => [
                            'UF_NAME' => $sizeProp['VALUE'],
                        ]
                    ])->fetch();

                    if (is_array($rsData) && count($rsData)) {
                        \CIBlockElement::SetPropertyValuesEx($arFields['ID'], self::$HUT_CATALOG_OFFERS_IBLOCK_ID, [self::$OFFERS_CLOTHES_SIZE_PROP_CODE => $rsData['UF_XML_ID']]);
                    }
                }
            }
        }
    }
}
