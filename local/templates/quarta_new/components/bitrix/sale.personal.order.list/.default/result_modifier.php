<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();



if (!empty($arResult['ORDERS'])) {

    $entSections = \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID);

    foreach ($arResult['ORDERS'] as $arOrderIndex => $arOrder) {

        if ($arOrder['ORDER']['PERSON_TYPE_ID'] == 2) {
            $arResult['ORDERS'][$arOrderIndex]['HIDE_BUTTON_PAYMENT'] = 'Y';
            continue;
        }

        if (!empty($arOrder['BASKET_ITEMS'])) {
            foreach ($arOrder['BASKET_ITEMS'] as $arBasketItem) {
                
                $rsSectionsEl = CIBlockElement::GetElementGroups($arBasketItem['PRODUCT_ID'], true)->fetch();

                $rsPath = CIBlockSection::GetNavChain(false, $rsSectionsEl['ID']); 

                while ($arPath = $rsPath->GetNext()) {
                    $sectionIds[$arOrderIndex][$arPath['ID']] = $arPath['ID']; 
                }

            }

            $rsSections = $entSections::getList(array(
                "filter" => array(
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID, 
                    "ACTIVE" => "Y",
                    "GLOBAL_ACTIVE" => "Y",
                    "ID" => $sectionIds[$arOrderIndex]
                ),
                "select" => array("NAME", "CODE"),
            ))->fetchAll();
    
            if (!empty($rsSections)) {
                foreach ($rsSections as $arSection) {
    
                    if (
                        $arSection['CODE'] == 'odezhda'
                        ||
                        $arSection['CODE'] == 'obuv'
                    ) {
                        $arResult['ORDERS'][$arOrderIndex]['HIDE_BUTTON_PAYMENT'] = 'Y';

                        break;
                    }
    
                    continue;
    
                }
            }

        }
    }
}



