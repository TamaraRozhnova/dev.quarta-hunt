<?php

namespace Helpers;

use General\Product;
use General\User;


/**
 * Класс по работе с аналогами товаров.
 */
class AnalogProductsHelper
{
    const MAX_COUNT_ANALOGS = 12;
    public static function getAnalogProducts(int $productId, int $sectionId, string $elementUrlTemplate = ''): array {
        $user = new User();
        $priceCodeId = $user->getUserPriceCodeId();

        $analogIds = [];

        $sectionPath = [];
        $listSection = \CIBlockSection::GetNavChain(false,$sectionId, ['ID', 'NAME'], true);
        foreach ($listSection as $arSectionPath){
            $sectionPath[] = $arSectionPath['ID'];
        }
        $sectionData = \CIBlockSection::GetList(['DEPTH_LEVEL' => 'DESC'], [
            'ID' => $sectionPath,
            'IBLOCK_ID' => CATALOG_IBLOCK_ID,
            '!UF_PROPS_ANALOG' => false,
        ], false, [
            'ID',
            'NAME',
            'IBLOCK_SECTION_ID',
            'SECTION_ID',
            'DEPTH_LEVEL',
            'UF_PROPS_ANALOG',
        ]);

        $sections = [];
        while ($section = $sectionData->Fetch()){
            $sections[$section['ID']] = $section;
        }

        if (!empty($sections)) {
            $propAnalogIds = [];
            foreach ($sections as $section) {
                $propAnalogIds = array_merge($propAnalogIds, $section['UF_PROPS_ANALOG']);
            }
            $propsCodes = \Bitrix\Iblock\PropertyTable::query()
                ->setSelect(['ID', 'CODE', 'PROPERTY_TYPE'])
                ->where('IBLOCK_ID', CATALOG_IBLOCK_ID)
                ->where('ACTIVE', 'Y')
                ->whereIn('ID', $propAnalogIds)
                ->fetchAll();


            $propsCodesSelect = array_map(function ($prop) {
                return 'PROPERTY_' . $prop['CODE'];
            }, $propsCodes);

            $productsResource = \CIBlockElement::GetList(
                [],
                [
                    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                    'ID' => $productId,
                ],
                false,
                false,
                array_merge([
                    'IBLOCK_ID',
                    'ID',
                ], $propsCodesSelect)
            );
            $product = $productsResource->Fetch();

            $countAnalogs = 0;
            foreach ($sections as $sectionId => $section) {
                if ($countAnalogs >= self::MAX_COUNT_ANALOGS) {
                    break;
                }

                $propsAnalogSection = array_filter($propsCodes, function ($prop) use ($section) {
                    return in_array($prop['ID'], $section['UF_PROPS_ANALOG']);
                });

                $filterPropsAnalogSection = [
                    'LOGIC' => 'OR',
                ];
                foreach ($propsAnalogSection as $prop) {
                    $productPropValue = $product['PROPERTY_' . $prop['CODE'] . '_VALUE'] ?? false;
                    if (!$productPropValue) {
                        continue;
                    }

                    switch ($prop['PROPERTY_TYPE']) {
                        case 'L':
                            $filterPropsAnalogSection['PROPERTY_' .$prop['CODE'] . '_VALUE'] = $productPropValue;
                            break;
                        default:
                            $filterPropsAnalogSection['PROPERTY_' .$prop['CODE']] = $productPropValue;
                    }
                }

                $productsSectionResource = \CIBlockElement::GetList(
                    [],
                    array_merge([
                        'IBLOCK_ID' => CATALOG_IBLOCK_ID,
                        'SECTION_ID' => $sectionId,
                        'AVAILABLE' => 'Y',
                        'ACTIVE' => 'Y',
                        ">$priceCodeId" => 0,
                        'INCLUDE_SUBSECTIONS' => 'Y',
                        '!ID' => $productId,
                    ], [$filterPropsAnalogSection]),
                    false,
                    ['nTopCount' => self::MAX_COUNT_ANALOGS - $countAnalogs],
                    array_merge([
                        'IBLOCK_ID',
                        'ID',
                        'NAME'
                    ], $propsCodesSelect)
                );

                while ($productAnalog = $productsSectionResource->Fetch()) {
                    $analogIds[] = $productAnalog['ID'];
                    if (++$countAnalogs > self::MAX_COUNT_ANALOGS) {
                        break;
                    }
                }
            }
        }

        if (!empty($analogIds)) {
            $analogIds = array_unique($analogIds);
            $filter = [
                'AVAILABLE' => 'Y',
                'ACTIVE' => 'Y',
                ">$priceCodeId" => 0,
                'ID' => $analogIds,
                '!ID' => $productId,
            ];
            $analogProducts = Product::fetchProducts($filter, $elementUrlTemplate, count($analogIds));
            return array_replace(array_flip($analogIds), $analogProducts);

        } else {
            return [];
        }
    }
}