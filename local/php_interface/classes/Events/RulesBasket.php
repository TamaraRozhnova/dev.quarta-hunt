<?php 

namespace CustomEvents;

use \Bitrix\Main\Loader;
use \Bitrix\Iblock\IblockTable;
use \Bitrix\Iblock\SectionTable;
use \Bitrix\Iblock\ElementTable;
use \Bitrix\Main\Event;
use \Bitrix\Sale\Internals\DiscountTable;

class RulesBasket
{
    public static function OnAfterAddDiscountTable(&$arFields)
    {
        
        Loader::includeModule('iblock');
        Loader::includeModule('sale');

        $arrData = $arFields->getParameters();

        $iblockCode = CATALOG_IBLOCK_CODE;

        $iblockId = IblockTable::getList(array(
                    'filter' => array('CODE' => $iblockCode),
        ))->fetch()['ID'];

        $discountPercent = reset($arrData['fields']['ACTIONS_LIST']['CHILDREN'])['DATA']['Value'];

        $arrMainData = $arrData['fields']['ACTIONS_LIST'];

        /** Если не пустой блок-обертка */
        if (!empty($arrMainData['CHILDREN'])) {

            /** Перебираем главный блок-обертку */
            foreach ($arrMainData['CHILDREN'] as $arBlockChildren) {

                /** Если не пустой блок с условиями */
                if (!empty($arBlockChildren['CHILDREN'])) {

                    /** Перебираем блоки с условиями */
                    foreach ($arBlockChildren['CHILDREN'] as $arElements) {

                        /** Проверка на условие для разделов и элементов */
                        switch ($arElements['CLASS_ID']) {

                            /** Если это раздел */
                            case 'CondIBSection':

                                if (!empty($arElements['DATA'])) {

                                    /** Если не пустой массив с разделами и условие без "НЕ РАВНО", начинаем перебирать */
                                    if (!empty($arElements['DATA']['value']) && $arElements['DATA']['logic'] != "Not") {

                                        $arSectionsIDS = $arElements['DATA']['value'];

                                        if (!empty($arSectionsIDS)) {

                                            /** Делаем запрос в раздел, чтобы получить элементы */

                                            $rsSection = SectionTable::getByPrimary($arSectionsIDS, [
                                                'filter' => ['IBLOCK_ID' => $iblockId],
                                                'select' => ['LEFT_MARGIN', 'RIGHT_MARGIN'],
                                            ])->fetch();

                                            $rsElements = ElementTable::getList([
                                                'select' => ['ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID'],
                                                'filter' => [
                                                    'IBLOCK_ID' => $iblockId,
                                                    'ACTIVE' => "Y",
                                                    '>=IBLOCK_SECTION.LEFT_MARGIN' => $rsSection['LEFT_MARGIN'],
                                                    '<=IBLOCK_SECTION.RIGHT_MARGIN' => $rsSection['RIGHT_MARGIN'],
                                                ],
                                            ])->fetchAll();

                                            if (!empty($rsElements)) {

                                                foreach ($rsElements as $arElementID) {
                                                    \CIBlockElement::SetPropertyValuesEx($arElementID['ID'], false, array(
                                                        "SIZE_DISCOUNT" => (int)$discountPercent
                                                        )
                                                    );
                                                }

                                                
                                            }

                                        }

                                    }

                                    
                                }

                                break;

                            /** Если это элементы */
                            case 'CondIBElement':

                                if (!empty($arElements['DATA'])) {
                                    if (!empty($arElements['DATA']['value'])) {
                                        foreach ($arElements['DATA']['value'] as $arElementID) {
                                            \CIBlockElement::SetPropertyValuesEx($arElementID, false, array(
                                                "SIZE_DISCOUNT" => (int)$discountPercent
                                                )
                                            );
                                        }   
                                    }
                                }

                                break;
                            
                            default:
                                # code...
                                break;
                        }

                    }
                }
            }
        }

 
    }

    public static function OnBeforeDeleteDiscountTable(Event $event)
    {

        Loader::includeModule('iblock');
        Loader::includeModule('sale');

        $idRulesBasket = $event->getParameter("primary");

        if (!empty($idRulesBasket)) {

            $arDiscount = DiscountTable::getList(
                [
                    'filter' => [
                        'ID' => $idRulesBasket['ID']
                    ]
                ]
            )->fetch();

            $iblockCode = CATALOG_IBLOCK_CODE;

            $iblockId = IblockTable::getList(array(
                        'filter' => array('CODE' => $iblockCode),
            ))->fetch()['ID'];

            $arrMainData = $arDiscount['ACTIONS_LIST'];

            /** Если не пустой блок-обертка */
            if (!empty($arrMainData['CHILDREN'])) {

                /** Перебираем главный блок-обертку */
                foreach ($arrMainData['CHILDREN'] as $arBlockChildren) {

                    /** Если не пустой блок с условиями */
                    if (!empty($arBlockChildren['CHILDREN'])) {

                        /** Перебираем блоки с условиями */
                        foreach ($arBlockChildren['CHILDREN'] as $arElements) {

                            /** Проверка на условие для разделов и элементов */
                            switch ($arElements['CLASS_ID']) {

                                /** Если это раздел */
                                case 'CondIBSection':

                                    if (!empty($arElements['DATA'])) {

                                        /** Если не пустой массив с разделами, начинаем перебирать */
                                        if (!empty($arElements['DATA']['value'])) {

                                            $arSectionsIDS = $arElements['DATA']['value'];

                                            if (!empty($arSectionsIDS)) {

                                                /** Делаем запрос в раздел, чтобы получить элементы */

                                                $rsSection = SectionTable::getByPrimary($arSectionsIDS, [
                                                    'filter' => ['IBLOCK_ID' => $iblockId],
                                                    'select' => ['LEFT_MARGIN', 'RIGHT_MARGIN'],
                                                ])->fetch();

                                                $rsElements = ElementTable::getList([
                                                    'select' => ['ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID'],
                                                    'filter' => [
                                                        'IBLOCK_ID' => $iblockId,
                                                        'ACTIVE' => "Y",
                                                        '>=IBLOCK_SECTION.LEFT_MARGIN' => $rsSection['LEFT_MARGIN'],
                                                        '<=IBLOCK_SECTION.RIGHT_MARGIN' => $rsSection['RIGHT_MARGIN'],
                                                    ],
                                                ])->fetchAll();

                                                if (!empty($rsElements)) {

                                                    foreach ($rsElements as $arElementID) {
                                                        \CIBlockElement::SetPropertyValuesEx($arElementID['ID'], false, array(
                                                            "SIZE_DISCOUNT" => null
                                                            )
                                                        );
                                                    }

                                                    
                                                }

                                            }

                                        }

                                        
                                    }

                                    break;

                                /** Если это элементы */
                                case 'CondIBElement':

                                    if (!empty($arElements['DATA'])) {
                                        if (!empty($arElements['DATA']['value'])) {
                                            foreach ($arElements['DATA']['value'] as $arElementID) {
                                                \CIBlockElement::SetPropertyValuesEx($arElementID, false, array(
                                                    "SIZE_DISCOUNT" => null
                                                    )
                                                );
                                            }   
                                        }
                                    }

                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }
                }
            }
        }
    }
}